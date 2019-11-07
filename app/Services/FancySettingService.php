<?php

namespace App\Services;

use App\Addon;
use App\Enums\AddonCode;
use App\Enums\FancyAudioType;
use App\FancyNumber;
use App\FancySetting;
use App\Http\Requests\FancySettingRequest;
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

        $this->cleanExistingTicket($setting, $request->user()->id, $request->input('reason'));

        $setting->business_hours = $request->input('business_hours');
        $setting->downtime_hours = $request->input('downtime_hours');
        $setting->email_notification = (string)$request->input('notification.email');
        $setting->period_notification = (string)$request->input('notification.period');

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

        $this->buyProfessionalRecording($request->input('audio_type'));

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
            'audio' => [
                'type' => optional($this->user->fancy_setting)->audio_type ?? FancyAudioType::PREDEFINED,
                'buy_professional' => optional($this->user->fancy_setting)->audio_type === FancyAudioType::PROFESSIONAL
            ]
        ]);
    }

    /**
     * @param FancySetting $setting
     * @param int $userId
     * @param string|null $reason
     */
    private function cleanExistingTicket(FancySetting $setting, int $userId, string $reason = null)
    {
        $current_ticket = $this->fancyNumber->ticket;

        if ($setting->exists && $current_ticket->inProgress()) {
            $new_ticket = $current_ticket->replicate();
            $new_ticket->parent_id = $current_ticket->id;
            $new_ticket->save();

            $current_ticket->reason = $reason;
            $current_ticket->reason_by = $userId;

            $current_ticket->delete();
        }
    }

    /**
     * @param string $audioType
     * @throws \Stripe\Error\Api
     */
    private function buyProfessionalRecording(string $audioType)
    {
        // TODO: Verify if payment already has been made, so we don't charge User multiple time
        if ($audioType === FancyAudioType::PROFESSIONAL) {
            $add_on = Addon::where('code', AddonCode::PROFESSIONAL_RECORDING)->first();

            (new StripeService())->createInvoice($add_on->cost * 100, $this->user->email, $add_on->name);
        }
    }
}