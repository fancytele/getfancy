<template>
    <div id="did-settings" class="mb-5">
        <form :action="urlAction" @submit.prevent="saveSetting()">
            <input type="hidden" name="_method" value="PUT"/>

            <!-- Business Hours -->
            <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <h2 class="mb-1">{{ trans('Business hours') }}</h2>
                            <p class="text-black-50">{{ trans('Business hours description') }}</p>
                        </div>
                        <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
                            <div class="form-group">
                                <div class="custom-control custom-control-block custom-switch">
                                    <label for="all_day">
                                        <span class="custom-control-text">{{ trans('Open 24/7') }}?</span>
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               id="all_day"
                                               v-model="businessHours.all_day"/>
                                        <span class="custom-control-label"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-5" :class="{'disabled-setting': businessHours.all_day}">
                                <div class="align-items-baseline content-action-hover d-lg-flex mb-4 mb-lg-1"
                                     v-for="item in businessHours.days" :key="item.id">
                                    <div class="custom-checkbox custom-control custom-control-md d-lg-inline mb-3 mb-lg-0 mr-lg-4">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               :id="'business_' + item.id"
                                               v-model="item.enable"
                                               @change="toggleHour(item)"/>
                                        <label class="align-items-start label-day custom-control-label"
                                               :for="'business_' + item.id">
                                            {{ trans(item.text) }}
                                        </label>
                                    </div>

                                    <div class="d-inline-block mr-4">
                                        <label class="sr-only" :for="'business_' + item.id + '_open_time'">
                                            Start time
                                        </label>
                                        <div class="input-group input-group-sm input-group-time">
                                            <vue-timepicker input-class="form-control"
                                                            :id="'business_' + item.id + '_open_time'"
                                                            :name="'business_' + item.id + '_open_time'"
                                                            :aria-label="'business_' + item.text + ' open time'"
                                                            :aria-describedby="'business_' + item.id + '-open-time-icon'"
                                                            v-model="item.start"
                                                            :disabled="!item.enable"
                                                            minute-interval="30"></vue-timepicker>
                                            <div class="input-group-append">
                                                <span class="input-group-text"
                                                      :id="'business_' + item.id + '-open-time-icon'">
                                                  <i class="fe fe-clock"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-inline-block mr-4">
                                        <label class="sr-only" :for="item.id + '_close_time'">Start time</label>
                                        <div class="input-group input-group-sm input-group-time">
                                            <vue-timepicker input-class="form-control"
                                                            :id="'business_' + item.id + '_close_time'"
                                                            :name="'business_' + item.id + '_close_time'"
                                                            :aria-label="'business_' + item.text + ' close time'"
                                                            :aria-describedby="'business_' + item.id + '-close-time-icon'"
                                                            v-model="item.end"
                                                            :disabled="!item.enable"
                                                            minute-interval="30"></vue-timepicker>
                                            <div class="input-group-append">
                                                <span class="input-group-text" :id="item.id + '-close-time-icon'">
                                                  <i class="fe fe-clock"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button"
                                            class="action btn btn-link pl-0 pl-lg-3 text-decoration-underline"
                                            :class="{'invisible': item.enable === false}"
                                            @click="copyHours(businessHours, item)">
                                        <i class="fe fe-copy"></i>
                                        {{ trans('Copy to all') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Downtime Hours -->
            <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <h2 class="mb-1">{{ trans('Downtime hours') }}</h2>
                            <p class="text-black-50">{{ trans('Downtime hours description') }}</p>
                        </div>
                        <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
                            <div class="form-group">
                                <div class="custom-control custom-control-block custom-switch">
                                    <label for="enable_downtime">
                                        <span class="custom-control-text">{{ trans('Enable downtime hours') }}?</span>
                                        <input type="checkbox" class="custom-control-input" id="enable_downtime"
                                               :disabled="businessHours.all_day" v-model="downtimeHours.enable"/>
                                        <span class="custom-control-label"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-5"
                                 :class="{'disabled-setting': !downtimeHours.enable || businessHours.all_day}">
                                <div class="align-items-baseline content-action-hover d-lg-flex mb-4 mb-lg-1"
                                     v-for="item in downtimeHours.days" :key="item.id">
                                    <div class="custom-checkbox custom-control custom-control-md d-lg-inline mb-3 mb-lg-0 mr-lg-4">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               :id="'downtime_' + item.id"
                                               v-model="item.enable"
                                               @change="toggleHour(item)"/>
                                        <label class="align-items-start label-day custom-control-label"
                                               :for="'downtime_' + item.id">
                                            {{ trans(item.text) }}
                                        </label>
                                    </div>

                                    <div class="d-inline-block mr-4">
                                        <label class="sr-only" :for="'downtime_' + item.id + '_start_time'">Start
                                            time</label>
                                        <div class="input-group input-group-sm input-group-time">
                                            <vue-timepicker input-class="form-control"
                                                            :id="'downtime_' + item.id + '_start_time'"
                                                            :name="'downtime_' + item.id + '_start_time'"
                                                            :aria-label="'downtime_' + item.text + ' start time'"
                                                            :aria-describedby="'downtime_' + item.id + '-start-time-icon'"
                                                            v-model="item.start"
                                                            :disabled="!item.enable"
                                                            minute-interval="30"></vue-timepicker>
                                            <div class="input-group-append">
                                                <span class="input-group-text"
                                                      :id="'downtime_' + item.id + '-start-time-icon'">
                                                  <i class="fe fe-clock"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-inline-block mr-4">
                                        <label class="sr-only" :for="'downtime_' + item.id + '_end_time'">Start
                                            time</label>
                                        <div class="input-group input-group-sm input-group-time">
                                            <vue-timepicker input-class="form-control"
                                                            :id="'downtime_' + item.id + '_end_time'"
                                                            :name="'downtime_' + item.id + '_end_time'"
                                                            :aria-label="'downtime_' + item.text + ' end time'"
                                                            :aria-describedby="'downtime_' + item.id + '-end-time-icon'"
                                                            v-model="item.end"
                                                            :disabled="!item.enable"
                                                            minute-interval="30"></vue-timepicker>
                                            <div class="input-group-append">
                                                <span class="input-group-text"
                                                      :id="'downtime_' + item.id + '-end-time-icon'">
                                                  <i class="fe fe-clock"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button"
                                            class="action btn btn-link pl-0 pl-lg-3 text-decoration-underline"
                                            :class="{'invisible': item.enable === false}"
                                            @click="copyHours(downtimeHours, item)">
                                        <i class="fe fe-copy"></i>
                                        {{ trans('Copy to all') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification -->
            <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <h2 class="mb-1">{{ trans('Notifications') }}</h2>
                            <p class="text-black-50">{{ trans('Notifications description') }}</p>
                        </div>
                        <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
                            <div class="row">
                                <div class="col-md-8 col-lg-6">
                                    <div class="form-group">
                                        <label for="email">{{ trans('E-mail') }}</label>
                                        <input type="email"
                                               class="form-control"
                                               id="email"
                                               name="email"
                                               required
                                               v-model="notification.email"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-lg-6">
                                    <div class="form-group">
                                        <label for="period">{{ trans('Period') }}</label>
                                        <select name="period"
                                                id="period"
                                                class="form-control text-capitalize"
                                                required
                                                v-model="notification.period">
                                            <option :value="period"
                                                    v-for="period in notificationPeriods"
                                                    :key="period">
                                                {{ trans(period) }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PBX -->
            <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <h2 class="mb-1">{{ trans('PBX profile') }}</h2>
                            <p class="text-black-50">{{ trans('Choose your PBX message') }}.</p>
                        </div>
                        <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
                            <div>
                                <fieldset class="mb-4">
                                    <legend class="pl-4">{{ trans('Message for business hours') }}</legend>
                                    <div>
                                        <div class="custom-control custom-radio mb-3"
                                             v-for="item in messages.business"
                                             :key="item.id">
                                            <input type="radio"
                                                   :id="`${item.type}_message_${item.id}`"
                                                   name="business-message"
                                                   class="custom-control-input"
                                                   :value="item.id"
                                                   v-model="pbx.business"/>
                                            <label class="custom-control-label"
                                                   :for="`${item.type}_message_${item.id}`">
                                                {{ trans(item.message) }}
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio"
                                                   id="business_message_0"
                                                   name="business-message"
                                                   class="custom-control-input"
                                                   value="0"
                                                   v-model="pbx.business"/>
                                            <label class="custom-control-label" for="business_message_0">
                                              {{ trans('Custom message') }}
                                            </label>
                                        </div>
                                        <div class="form-group pl-4"
                                             :class="{'disabled-setting': pbx.business != 0}">
                                            <textarea name="business_message_custom"
                                                      id="business_message_custom"
                                                      class="form-control resize-none"
                                                      rows="3"
                                                      :disabled="pbx.business != 0"
                                                      v-model="pbx.business_text"></textarea>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="mb-4">
                                    <legend class="pl-4">
                                        {{ trans('Message for downtime hours') }}
                                        <p class="mt-n2 small text-warning" v-show="businessHours.all_day">
                                            {{ trans('The company is open 24/7. No need for Downtime hours message') }}
                                        </p>
                                    </legend>

                                    <div :class="{'disabled-setting': businessHours.all_day}">
                                        <div class="custom-control custom-radio mb-3"
                                             v-for="item in messages.downtime"
                                             :key="item.id">
                                            <input type="radio"
                                                   :id="`${item.type}_message_${item.id}`"
                                                   name="downtime-message"
                                                   class="custom-control-input"
                                                   :value="item.id"
                                                   v-model="pbx.downtime"/>
                                            <label class="custom-control-label"
                                                   :for="`${item.type}_message_${item.id}`">
                                                {{ trans(item.message) }}
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio"
                                                   id="downtime_message_0"
                                                   name="downtime_message"
                                                   class="custom-control-input"
                                                   value="0"
                                                   v-model="pbx.downtime"/>
                                            <label class="custom-control-label" for="downtime_message_0">Custom</label>
                                        </div>
                                        <div class="form-group pl-4"
                                             :class="{'disabled-setting': pbx.downtime != 0}">
                                            <textarea name="downtime_message_custom"
                                                      id="downtime_message_custom"
                                                      class="form-control resize-none"
                                                      rows="3"
                                                      :disabled="pbx.downtime != 0"
                                                      v-model="pbx.downtime_text"></textarea>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="mb-4">
                                    <legend class="pl-4">{{ trans('Message for on-hold calls') }}</legend>
                                    <div>
                                        <div class="custom-control custom-radio mb-3"
                                             v-for="item in messages.onhold"
                                             :key="item.id">
                                            <input type="radio"
                                                   :id="`${item.type}_message_${item.id}`"
                                                   name="onhold-message"
                                                   class="custom-control-input"
                                                   :value="item.id"
                                                   v-model="pbx.onhold"/>
                                            <label class="custom-control-label"
                                                   :for="`${item.type}_message_${item.id}`">
                                                {{ trans(item.message) }}
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio"
                                                   id="onhold_message_0"
                                                   name="onhold_message"
                                                   class="custom-control-input"
                                                   value="0"
                                                   v-model="pbx.onhold"/>
                                            <label class="custom-control-label" for="onhold_message_0">Custom</label>
                                        </div>
                                        <div class="form-group pl-4"
                                             :class="{'disabled-setting': pbx.onhold != 0}">
                                            <textarea name="onhold_message_custom"
                                                      id="onhold_message_custom"
                                                      class="form-control resize-none"
                                                      rows="3"
                                                      :disabled="pbx.onhold != 0"
                                                      v-model="pbx.onhold_text"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Extensions -->
            <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <h2 class="mb-1">{{ trans('Custom extensions') }}</h2>
                            <p class="text-black-50">{{ trans('Custom extensions description') }}.</p>
                        </div>
                        <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
                            <div class="row">
                                <div class="col-lg-10">
                                    <table class="border-bottom mb-2 table table-hover table-sm" ref="extensions-table">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ trans('Number') }}</th>
                                            <th scope="col">{{ trans('Name') }}</th>
                                            <th>
                                                <span class="sr-only">Action</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="content-action-hover"
                                            v-for="item in extensions"
                                            :key="item.id">
                                            <td>
                                                <label :for="'extension_number_'+ item.id"
                                                       class="sr-only">Extension number</label>
                                                <input type="number"
                                                       :id="'extension_number_'+ item.id"
                                                       class="form-control form-control-sm w-75"
                                                       min="0"
                                                       v-model="item.number"/>
                                            </td>
                                            <td>
                                                <label :for="'extension_name_'+ item.id"
                                                       class="sr-only">Extension name</label>
                                                <input type="text"
                                                       :id="'extension_name_'+ item.id"
                                                       class="form-control form-control-sm"
                                                       v-model="item.name"/>
                                            </td>
                                            <td>
                                                <button class="action btn btn-link btn-sm mt-n1 py-0 text-danger"
                                                        @click="deleteExtension(item.id)">
                                                    <i class="fe fe-minus-circle h2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-link" @click="addExtension()">
                                        <i class="fe fe-plus"></i>
                                        {{ trans('Add a new extension') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Audio -->
            <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <h2 class="mb-1">{{ trans('Audio') }}</h2>
                            <p class="text-black-50">{{ trans('Audio description') }}.</p>
                        </div>
                        <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
                            <div>
                                <div :class="{'disabled-setting': buyProfessionalRecording}">
                                    <div class="custom-control custom-control-md custom-radio d-xl-inline-block mb-4 mr-6">
                                        <input type="radio"
                                               id="predefined_audio"
                                               name="type_audio"
                                               class="custom-control-input"
                                               value="predefined"
                                               v-model="audioType"/>
                                        <label for="predefined_audio" class="custom-control-label">Predefined</label>
                                    </div>
                                    <div class="custom-control custom-control-md custom-radio d-xl-inline-block mb-4 mr-6">
                                        <input type="radio"
                                               id="custom_audio"
                                               name="type_audio"
                                               value="custom"
                                               class="custom-control-input"
                                               v-model="audioType"/>
                                        <label for="custom_audio" class="custom-control-label">Custom</label>
                                    </div>
                                    <div class="custom-control custom-control-md custom-radio d-xl-inline-block mb-4 "
                                         v-if="hasProfessionalRecording">
                                        <input type="radio"
                                               id="professional_audio"
                                               name="type_audio"
                                               value="professional"
                                               class="custom-control-input"
                                               v-model="audioType"/>
                                        <label for="professional_audio" class="custom-control-label">
                                          {{ trans('Professional Greeting/Custom Recordings') }}
                                        </label>
                                    </div>
                                </div>

                                <div v-if="hasProfessionalRecording === false">
                                    <h4 class="mb-4">OR</h4>

                                    <div class="custom-checkbox custom-control custom-control-md">
                                        <input type="checkbox" class="custom-control-input"
                                              id="buy_professional_greeting"
                                              v-model="buyProfessionalRecording"/>
                                        <label class="align-items-start custom-control-label text-body"
                                              for="buy_professional_greeting">
                                            {{ trans('Buy Professional Greeting/Custom Recordings') }}
                                            <span class="form-text text-muted">$ 8.00 (will be charge immediately)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit"
                    id="submit-fancy-setting"
                    class="btn btn-primary btn btn-primary ladda-button"
                    data-style="zoom-out">
                {{ trans('Save setting') }}
            </button>
        </form>

        <div class="modal fade" id="reason-modal" tabindex="-1" role="dialog"
             aria-labelledby="reason-modal-label" aria-hidden="true"
             v-if="ticketInProgress" ref="reason-modal">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="align-items-center d-flex modal-header py-3">
                        <h5 class="h3 mb-0 modal-title" id="reason-modal-label">Reason</h5>
                        <button type="button"
                                data-dismiss="modal"
                                aria-label="Close"
                                class="close py-0"
                                @click="hideReasonModal()">
                            <i class="fe fe-x-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <form :action="urlAction" @submit.prevent="saveSetting()">
                            <label class="w-100">
                                <textarea class="form-control form-control-flush px-4 resize-none"
                                          name="reason"
                                          id="reason"
                                          rows="5"
                                          placeholder="Specify why this change is necessary"
                                          v-model="reason"
                                          ref="reason-input">
                                </textarea>
                            </label>
                            <div class="d-flex overflow-hidden rounded-bottom">
                                <button type="button"
                                        class="btn btn-lg btn-outline-light rounded-0 text-body w-50"
                                        data-dismiss="modal"
                                        @click="hideReasonModal()">
                                    {{ trans('Cancel') }}
                                </button>
                                <button type="submit"
                                        class="btn btn-lg btn-primary rounded-0 w-50"
                                        :disabled="reason === ''">
                                    {{ trans('Confirm') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="success-modal"
             tabindex="-2"
             role="dialog"
             class="modal fade"
             aria-hidden="true"
             ref="success-modal"
             v-if="settingsSaved">
            <div role="document" class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="d-flex my-3 pl-4 pt-4">
                            <i class="display-4 fe fe-check-circle mr-3 mt-n2 mt-n3 text-success"></i>
                            <div>
                                <h3 class="mb-1">{{ trans('Fancy Settings saved') }}</h3>
                                <p class="line-height-normal text-black-50">
                                    {{ trans('Changes will be applied within 24 hours') }}
                                </p>
                            </div>
                        </div>
                        <div class="overflow-hidden rounded-bottom">
                            <a :href="urlUserList" class="btn btn-block btn-lg btn-success rounded-0">
                                {{ trans('Return to list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import VueTimepicker from 'vue2-timepicker'

  export default {
    props: {
      ticketInProgress: {
        type: Boolean,
        default() {
          return false;
        }
      },
      hasProfessionalRecording: {
        type: Boolean,
        default() {
          return false;
        }
      },
      settings: {
        type: Object,
        required: true
      },
      notificationPeriods: {
        type: Array,
        required: true
      },
      messages: {
        type: Object,
        required: true
      },
      urlAction: {
        type: String,
        required: true
      },
      urlUserList: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        buyProfessionalRecording: false,
        settingsSaved: false,
        isProcessing: false,
        laddaButton: null,
        reason: '',
        businessHours: {
          all_day: false,
          days: [
            {
              id: 'monday',
              text: 'Mon',
              start: null,
              end: null,
              enable: false
            },
            {
              id: 'tuesday',
              text: 'Tue',
              start: null,
              end: null,
              enable: false
            },
            {
              id: 'wednesday',
              text: 'Wed',
              start: null,
              end: null,
              enable: false
            },
            {
              id: 'thursday',
              text: 'Thu',
              start: null,
              end: null,
              enable: false
            },
            {
              id: 'friday',
              text: 'Fri',
              start: null,
              end: null,
              enable: false
            },
            {
              id: 'saturday',
              text: 'Sat',
              start: null,
              end: null,
              enable: false
            },
            {
              id: 'sunday',
              text: 'Sun',
              start: null,
              end: null,
              enable: false
            }
          ]
        },
        downtimeHours: {
          enable: false,
          days: [
            {
              id: 'monday',
              text: 'Mon',
              start: null,
              end: null,
              enable: false
            },
            {
              id: 'tuesday',
              text: 'Tue',
              start: null,
              end: null,
              enable: false
            },
            {
              id: 'wednesday',
              text: 'Wed',
              start: null,
              end: null,
              enable: false
            },
            {
              id: 'thursday',
              text: 'Thu',
              start: null,
              end: null,
              enable: false
            },
            {
              id: 'friday',
              text: 'Fri',
              start: null,
              end: null,
              enable: false
            },
            {
              id: 'saturday',
              text: 'Sat',
              start: null,
              end: null,
              enable: false
            },
            {
              id: 'sunday',
              text: 'Sun',
              start: null,
              end: null,
              enable: false
            }
          ]
        },
        notification: {
          email: '',
          period: 'daily'
        },
        pbx: {
          business: null,
          business_text: '',
          downtime: null,
          downtime_text: '',
          onhold: null,
          onhold_text: ''
        },
        extensions: [],
        audioType: 'predefined'
      };
    },
    components: {
      VueTimepicker
    },
    methods: {
      toggleHour(item) {
        if (item.enable) {
          return;
        }

        item.start = {HH: '', mm: ''};
        item.end = {HH: '', mm: ''};
      },
      copyHours(list, item) {
        if (item.enable === false || !item.start || !item.end) {
          return;
        }

        list.days.forEach(el => {
          if (el.id === item.id) {
            return false;
          }

          el.enable = true;
          el.start = item.start;
          el.end = item.end;
        });
      },
      addExtension() {
        const extension = {
          id: new Date().valueOf(),
          number: null,
          name: ''
        };

        this.extensions.push(extension);

        this.$nextTick(() => {
          this.$refs['extensions-table'].querySelector('tbody tr:last-child td:first-child input').focus();
        });
      },
      deleteExtension(id) {
        const index = this.extensions.findIndex(el => el.id === id);
        this.extensions.splice(index, 1);
      },
      getSettingPayload() {
        const payload = {
          notification: this.notification,
          audio_type: this.audioType
        };

        // Business Hours
        if (this.businessHours.all_day || this.businessHours.days.filter(el => el.enable).length > 0) {
          payload.business_hours = {
            all_day: this.businessHours.all_day,
            days: this.businessHours.days
          };
        }

        // Downtime Hours
        if (this.businessHours.all_day === false && (this.downtimeHours.enable && this.downtimeHours.days.filter(el => el.enable).length > 0)) {
          payload.downtime_hours = {
            enable: this.downtimeHours.enable,
            days: this.downtimeHours.days
          };
        }

        // PBX
        if (this.pbx.business && this.pbx.business > 0) {
          payload.business_id = this.pbx.business;
        }

        if (this.pbx.business > 0 && this.pbx.business_text) {
          payload.business_text = this.pbx.business_text;
        }

        if (this.businessHours.all_day === false) {
          if (this.pbx.downtime && this.pbx.business > 0) {
            payload.downtime_id = this.pbx.downtime;
          }

          if (this.pbx.downtime > 0 && this.pbx.downtime_text) {
            payload.downtime_text = this.pbx.downtime_text;
          }
        }

        if (this.pbx.onhold && this.pbx.onhold > 0) {
          payload.onhold_id = this.pbx.onhold;
        }

        if (this.pbx.onhold > 0 && this.pbx.onhold_text) {
          payload.onhold_text = this.pbx.onhold_text;
        }

        // Extensions
        if (this.extensions.length > 0) {
          payload.extensions = this.extensions.filter(el => el.number && el.name);
        }

        // Audio
        if (this.buyProfessionalRecording) {
          payload.audio_type = 'professional';
        }

        // Reason, only if Ticket in progress exists
        if (this.ticketInProgress) {
          payload.ticket_in_progress = this.ticketInProgress;
          payload.reason = this.reason;
        }

        return payload;
      },
      showReasonModal() {
        $(this.$refs['reason-modal']).modal({
          backdrop: 'static',
          keyboard: false
        }).on('shown.bs.modal', () => this.$refs['reason-input'].focus());
      },
      hideReasonModal() {
        this.reason = '';
      },
      saveSetting() {
        if (this.ticketInProgress && this.reason === '') {
          this.showReasonModal();
          return false;
        }

        if (this.isProcessing) {
          return false;
        }

        this.isProcessing = true;
        this.laddaButton.start();

        if (this.$refs['reason-modal']) {
          $(this.$refs['reason-modal']).modal('hide');
        }

        axios.put(this.urlAction, this.getSettingPayload())
          .then(() => {
            this.settingsSaved = true;
            this.laddaButton.stop();

            this.$nextTick(() => {
              $(this.$refs['success-modal']).modal({backdrop: 'static', keyboard: false});
            });
          })
          .catch(error => {
            console.error(error);

            this.isProcessing = false;
            this.laddaButton.stop();
          });
      }
    },
    created() {
      if (this.settings.business_hours) {
        this.businessHours = this.settings.business_hours;
      }

      if (this.settings.downtime_hours) {
        this.downtimeHours = this.settings.downtime_hours;
      }

      if (this.settings.notification) {
        this.notification = this.settings.notification;
      }

      if (this.settings.pbx) {
        this.pbx = this.settings.pbx;
      }

      if (this.settings.extensions) {
        this.extensions = this.settings.extensions;
      }

      if (this.settings.audio_type) {
        this.audioType = this.settings.audio_type;
      }
    },
    mounted() {
      this.laddaButton = Ladda.create(
        document.querySelector('#submit-fancy-setting')
      );
    }
  };
</script>