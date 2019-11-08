<?php

namespace App\Services;

use App\Addon;
use App\Enums\AddonCode;
use App\Enums\FancyAudioType;
use App\Enums\TicketStatus;
use App\Events\RegisterInvoiceEvent;
use App\FancyNumber;
use App\FancySetting;
use App\Http\Requests\FancySettingRequest;
use App\Ticket;
use App\User;

class FancySettingService
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var FancyNumber
     */
    private $fancyNumber;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->fancyNumber = $user->fancy_number;
    }

    public function SaveSetting(FancySettingRequest $request)
    {
        $setting = FancySetting::firstOrNew(['fancy_number_id' => $this->fancyNumber->id]);

        $this->cleanExistingTicket($request->user()->id, $request->input('reason'));

        $setting->business_hours = $request->input('business_hours');
        $setting->downtime_hours = $request->input('downtime_hours');
        $setting->email_notification = (string) $request->input('notification.email');
        $setting->period_notification = (string) $request->input('notification.period');

        $setting->business_message_id = $request->input('business_id');

        if (is_null($setting->business_message_id) && $request->has('business_text')) {
            $setting->business_custom_message = $request->input('business_text');
        } else {
            $setting->business_custom_message = null;
        }

        $setting->downtime_message_id = $request->input('downtime_id');

        if (is_null($setting->downtime_message_id) && $request->has('downtime_text')) {
            $setting->downtime_custom_message = $request->input('downtime_text');
        } else {
            $setting->downtime_custom_message = null;
        }

        $setting->onhold_message_id = $request->input('onhold_id');

        if (is_null($setting->onhold_message_id) && $request->has('onhold_text')) {
            $setting->onhold_custom_message = $request->input('onhold_text');
        } else {
            $setting->onhold_custom_message = null;
        }

        $setting->extensions = $request->input('extensions');
        $setting->audio_type = $request->input('audio_type');

        $this->fancyNumber->settings()->save($setting);

        if ($setting->audio_type === FancyAudioType::PROFESSIONAL) {
            $this->buyProfessionalRecording();
        }

        return $setting;
    }

    /**
     * Get settings value to display in Form
     */
    public function getSettingsToEdit()
    {
        if (is_null($this->user->fancy_setting)) {
            return [];
        }

        return collect([
            'business_hours' => optional($this->user->fancy_setting)->business_hours,
            'downtime_hours' => optional($this->user->fancy_setting)->downtime_hours,
            'notification' => [
                'email' => optional($this->user->fancy_setting)->email_notification,
                'period' => optional($this->user->fancy_setting)->period_notification
            ],
            'pbx' => [
                'business' => optional($this->user->fancy_setting)->business_message_id,
                'business_text' => optional($this->user->fancy_setting)->business_custom_message,
                'downtime' => optional($this->user->fancy_setting)->downtime_message_id,
                'downtime_text' => optional($this->user->fancy_setting)->downtime_custom_message,
                'onhold' => optional($this->user->fancy_setting)->onhold_message_id,
                'onhold_text' => optional($this->user->fancy_setting)->onhold_custom_message
            ],
            'extensions' => optional($this->user->fancy_setting)->extensions ?? [],
            'audio_type' => optional($this->user->fancy_setting)->audio_type ?? FancyAudioType::PREDEFINED
        ]);
    }

    /**
     * @param FancySetting $setting
     * @param int $userId
     * @param string|null $reason
     */
    private function cleanExistingTicket(int $userId, string $reason = null)
    {
        if ($this->fancyNumber->hasPendingTicket() === false) {
            $new_ticket = new Ticket();
            $new_ticket->fancy_number_id = $this->fancyNumber->id;

            if ($this->fancyNumber->hasTicketInProgress()) {
                $current_ticket = $this->fancyNumber->tickets->firstWhere('status', TicketStatus::IN_PROGRESS);
                $current_ticket->reason = $reason;
                $current_ticket->reason_by = $userId;

                $current_ticket->delete();

                $new_ticket->parent_id = $current_ticket->id;
            }

            $new_ticket->save();
        }
    }

    /**
     * @throws \Stripe\Error\Api
     */
    private function buyProfessionalRecording()
    {
        $add_on = Addon::where('code', AddonCode::PROFESSIONAL_RECORDING)->first();

        if ($this->user->hasBoughtAddon($add_on->id) === false) {
            $stripe_invoice = (new StripeService())->createInvoice($add_on->cost * 100, $this->user->email, $add_on->name);
            event(new RegisterInvoiceEvent($this->user, $add_on, $stripe_invoice));
        }
    }
}
