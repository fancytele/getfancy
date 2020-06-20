<?php

namespace App\Services;

use App\Addon;
use App\Enums\AddonCode;
use App\Enums\FancyAudioType;
use App\Enums\TicketCategory;
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

        $this->UpdateExistingTicket();

        $setting->email_notification = (string) $request->input('notification_email');
        $setting->period_notification = $request->input('notification_period');

        $setting->business_message_id = $request->input('business_id');

        if (is_null($setting->business_message_id) && $request->has('business_text')) {
            $setting->business_custom_message = $request->input('business_text');
        } else {
            $setting->business_custom_message = null;
        }

        $setting->languages = json_decode($request->input('languages'));
        $setting->voice_menu = json_decode($request->input('voice_menus'));

        $setting->audio_type = $request->input('audio_type');

        if ($request->hasfile('audio_file')) {
            $setting->audio_url = \Storage::disk('s3')->put('audios', $request->file('audio_file'));
        }

        $this->fancyNumber->settings()->save($setting);

        if ($setting->audio_type === FancyAudioType::PROFESSIONAL) {
            $this->buyProfessionalRecording();
        }

        return $setting;
    }

    /**
     * Get settings value to display in Form
     * @return mixed
     */
    public function getSettingsToEdit()
    {
        if (is_null($this->user->fancy_setting)) {
            return (object) [];
        }

        return collect([
            'business_hours' => optional($this->user->fancy_setting)->business_hours,
            'downtime_hours' => optional($this->user->fancy_setting)->downtime_hours,
            'notification' => [
                'email' => optional($this->user->fancy_setting)->email_notification,
                'period' => explode(',', optional($this->user->fancy_setting)->period_notification)
            ],
            'pbx' => [
                'business' => optional($this->user->fancy_setting)->business_message_id,
                'business_text' => optional($this->user->fancy_setting)->business_custom_message,
                'downtime' => optional($this->user->fancy_setting)->downtime_message_id,
                'downtime_text' => optional($this->user->fancy_setting)->downtime_custom_message,
                'onhold' => optional($this->user->fancy_setting)->onhold_message_id,
                'onhold_text' => optional($this->user->fancy_setting)->onhold_custom_message
            ],
            'languages' => optional($this->user->fancy_setting)->languages ?? [],
            'voice_menus' => optional($this->user->fancy_setting)->voice_menu ?? [],
            'audio_type' => optional($this->user->fancy_setting)->audio_type ?? FancyAudioType::PREDEFINED
        ]);
    }

    private function UpdateExistingTicket()
    {
        if (!$this->fancyNumber->hasOpenTicket()) {
            $new_ticket = new Ticket();
            $new_ticket->fancy_number_id = $this->fancyNumber->id;

            $new_ticket->save();
        }

        if ($this->fancyNumber->hasTicketInProgress()) {
            $current_ticket = $this->fancyNumber->tickets->firstWhere('status', TicketStatus::IN_PROGRESS);
            $current_ticket->category = TicketCategory::UPDATE;

            $current_ticket->save();
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
