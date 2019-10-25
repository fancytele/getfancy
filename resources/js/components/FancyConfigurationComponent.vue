<template>
  <div id="did-settings" class="mb-5">
    <!-- Business Hours -->
    <div
      class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card"
    >
      <div class="card-body">
        <div class="row">
          <div class="col-xl-4">
            <h2 class="mb-1">{{ trans('Business hours') }}</h2>
            <p class="text-black-50">{{ trans('Business hours description') }}</p>
          </div>
          <div
            class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0"
          >
            <div class="form-group">
              <div class="custom-control custom-control-block custom-switch">
                <label for="all_day">
                  <span class="custom-control-text">{{ trans('Open 24/7') }}?</span>
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    id="all_day"
                    v-model="businessHours.allDay"
                  />
                  <span class="custom-control-label"></span>
                </label>
              </div>
            </div>

            <div class="mt-5" :class="{'disabled-setting': businessHours.allDay}">
              <div
                class="align-items-baseline content-action-hover d-lg-flex mb-4 mb-lg-1"
                v-for="item in businessHours.days"
                :key="item.id"
              >
                <div
                  class="custom-checkbox custom-control custom-control-md d-lg-inline mb-3 mb-lg-0 mr-lg-4"
                >
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    :id="item.id"
                    v-model="item.isOpen"
                  />
                  <label
                    class="align-items-start label-day custom-control-label"
                    :for="item.id"
                  >{{ trans(item.text) }}</label>
                </div>

                <div class="d-inline-block mr-4">
                  <label class="sr-only" :for="item.id + '_open_time'">Start time</label>
                  <div class="input-group input-group-sm input-group-time">
                    <input
                      type="text"
                      class="form-control"
                      :id="item.id + '_open_time'"
                      :name="item.id + '_open_time'"
                      :aria-label="item.text + ' open time'"
                      :aria-describedby="item.id + '-open-time-icon'"
                      v-model="item.open"
                      :disabled="!item.isOpen"
                    />
                    <div class="input-group-append">
                      <span class="input-group-text" :id="item.id + '-open-time-icon'">
                        <i class="fe fe-clock"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="d-inline-block mr-4">
                  <label class="sr-only" :for="item.id + '_close_time'">Start time</label>
                  <div class="input-group input-group-sm input-group-time">
                    <input
                      type="text"
                      class="form-control"
                      :id="item.id + '_close_time'"
                      :name="item.id + '_close_time'"
                      :aria-label="item.text + ' close time'"
                      :aria-describedby="item.id + '-close-time-icon'"
                      v-model="item.close"
                      :disabled="!item.isOpen"
                    />
                    <div class="input-group-append">
                      <span class="input-group-text" :id="item.id + '-close-time-icon'">
                        <i class="fe fe-clock"></i>
                      </span>
                    </div>
                  </div>
                </div>

                <button class="action btn btn-link pl-0 pl-lg-3 text-decoration-underline">
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
    <div
      class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card"
    >
      <div class="card-body">
        <div class="row">
          <div class="col-xl-4">
            <h2 class="mb-1">{{ trans('Downtime hours') }}</h2>
            <p class="text-black-50">{{ trans('Downtime hours description') }}</p>
          </div>
          <div
            class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0"
          >
            <div class="form-group">
              <div class="custom-control custom-control-block custom-switch">
                <label for="enable_downtime">
                  <span class="custom-control-text">{{ trans('Enable downtime hours') }}?</span>
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    id="enable_downtime"
                    v-model="downtimeHours.enable"
                  />
                  <span class="custom-control-label"></span>
                </label>
              </div>
            </div>

            <div class="mt-5" :class="{'disabled-setting': !downtimeHours.enable}">
              <div
                class="align-items-baseline content-action-hover d-lg-flex mb-4 mb-lg-1"
                v-for="item in downtimeHours.days"
                :key="item.id"
              >
                <div
                  class="custom-checkbox custom-control custom-control-md d-lg-inline mb-3 mb-lg-0 mr-lg-4"
                >
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    :id="item.id"
                    v-model="item.isClosed"
                  />
                  <label
                    class="align-items-start label-day custom-control-label"
                    :for="item.id"
                  >{{ trans(item.text) }}</label>
                </div>

                <div class="d-inline-block mr-4">
                  <label class="sr-only" :for="item.id + '_start_time'">Start time</label>
                  <div class="input-group input-group-sm input-group-time">
                    <input
                      type="text"
                      class="form-control"
                      :id="item.id + '_start_time'"
                      :name="item.id + '_start_time'"
                      :aria-label="item.text + ' start time'"
                      :aria-describedby="item.id + '-start-time-icon'"
                      v-model="item.start"
                      :disabled="!item.isClosed"
                    />
                    <div class="input-group-append">
                      <span class="input-group-text" :id="item.id + '-start-time-icon'">
                        <i class="fe fe-clock"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="d-inline-block mr-4">
                  <label class="sr-only" :for="item.id + '_end_time'">Start time</label>
                  <div class="input-group input-group-sm input-group-time">
                    <input
                      type="text"
                      class="form-control"
                      :id="item.id + '_end_time'"
                      :name="item.id + '_end_time'"
                      :aria-label="item.text + ' end time'"
                      :aria-describedby="item.id + '-end-time-icon'"
                      v-model="item.end"
                      :disabled="!item.isClosed"
                    />
                    <div class="input-group-append">
                      <span class="input-group-text" :id="item.id + '-end-time-icon'">
                        <i class="fe fe-clock"></i>
                      </span>
                    </div>
                  </div>
                </div>

                <button class="action btn btn-link pl-0 pl-lg-3 text-decoration-underline">
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
    <div
      class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card"
    >
      <div class="card-body">
        <div class="row">
          <div class="col-xl-4">
            <h2 class="mb-1">{{ trans('Notifications') }}</h2>
            <p class="text-black-50">{{ trans('Notifications description') }}</p>
          </div>
          <div
            class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0"
          >
            <div class="row">
              <div class="col-md-8 col-lg-6">
                <div class="form-group">
                  <label for="email">{{ trans('E-mail') }}</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    required
                    v-model="notification.email"
                  />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8 col-lg-6">
                <div class="form-group">
                  <label for="period">{{ trans('Period') }}</label>
                  <select
                    name="period"
                    id="period"
                    class="form-control"
                    required
                    v-model="notification.period"
                  >
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- PBX -->
    <div
      class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card"
    >
      <div class="card-body">
        <div class="row">
          <div class="col-xl-4">
            <h2 class="mb-1">PBX</h2>
            <p class="text-black-50">{{ trans('Choose your PBX message') }}.</p>
          </div>
          <div
            class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0"
          >
            <div>
              <fieldset class="mb-4">
                <legend class="pl-4">{{ trans('Message for business hours') }}</legend>
                <div v-show="pbx.type === 'predefined'">
                  <div class="custom-control custom-radio mb-3">
                    <input
                      type="radio"
                      id="business-message-1"
                      name="business-message"
                      class="custom-control-input"
                    />
                    <label class="custom-control-label" for="business-message-1">
                      For English press 1, para Español presione
                      el número dos.” For training purposes this
                      call may be recorded
                    </label>
                  </div>
                  <div class="custom-control custom-radio mb-3">
                    <input
                      type="radio"
                      id="business-message-2"
                      name="business-message"
                      class="custom-control-input"
                    />
                    <label class="custom-control-label" for="business-message-2">
                      You’ve reached “Company Name”. For Sales
                      Press 1. For Customer Service press 2. For
                      all other inquiries press 3 or wait in line
                      for one of our operators.
                    </label>
                  </div>
                  <div class="custom-control custom-radio mb-3">
                    <input
                      type="radio"
                      id="business-message-3"
                      name="business-message"
                      class="custom-control-input"
                    />
                    <label class="custom-control-label" for="business-message-3">
                      For Sales, Press 1. For Support, Press 2.
                      For all other questions, press 3.
                    </label>
                  </div>
                  <div class="custom-control custom-radio mb-3">
                    <input
                      type="radio"
                      id="business-message-4"
                      name="business-message"
                      class="custom-control-input"
                    />
                    <label class="custom-control-label" for="business-message-4">
                      If you know the extension of the person you
                      would like to reach, you may dial it at any
                      time. You can also press 0 to reach an
                      agent. For all other callers, please listen
                      to the following options: for account
                      information press 1, for questions about a
                      product you purchased press 2…
                    </label>
                  </div>
                  <div class="custom-control custom-radio mb-3">
                    <input
                      type="radio"
                      id="business-message-5"
                      name="business-message"
                      class="custom-control-input"
                    />
                    <label class="custom-control-label" for="business-message-5">
                      If you know your party’s extension, you may
                      dial it at any time. Otherwise, please
                      choose from the following options: for
                      customer support press 1, for sales press 2…
                    </label>
                  </div>
                  <div class="custom-control custom-radio mb-3">
                    <input
                      type="radio"
                      id="business-message-6"
                      name="business-message"
                      class="custom-control-input"
                    />
                    <label class="custom-control-label" for="business-message-6">
                      To reach our company directory, press 1. For
                      more information about [Company Name], press
                      2. If you are an existing customer, please
                      press 3. For billing questions, press 4. To
                      repeat menu options, press 9. For all other
                      inquiries, press 0.
                    </label>
                  </div>
                  <div class="custom-control custom-radio mb-3">
                    <input
                      type="radio"
                      id="business-message-7"
                      name="business-message"
                      class="custom-control-input"
                    />
                    <label class="custom-control-label" for="business-message-7">Custom</label>
                  </div>
                  <div class="form-group pl-4">
                    <textarea
                      name="business_hours_message"
                      id="business_hours_message"
                      class="form-control resize-none"
                      rows="3"
                    ></textarea>
                  </div>
                </div>
              </fieldset>

              <fieldset class="mb-4">
                <legend class="pl-4">
                  {{ trans('Message for downtime hours') }}
                  <p
                    class="mt-n2 small text-warning"
                    v-show="businessHours.allDay"
                  >The company is open 24/7. No need for Downtime hours message</p>
                </legend>

                <div :class="{ 'disabled-setting': businessHours.allDay }">
                  <div v-show="pbx.type === 'predefined'">
                    <div class="custom-control custom-radio mb-3">
                      <input
                        type="radio"
                        id="downtime-message-1"
                        name="downtime-message"
                        class="custom-control-input"
                      />
                      <label class="custom-control-label" for="downtime-message-1">
                        You have reached “Company Name” our business
                        hours are 8 am to 5 pm.
                      </label>
                    </div>
                    <div class="custom-control custom-radio mb-3">
                      <input
                        type="radio"
                        id="downtime-message-2"
                        name="downtime-message-2"
                        class="custom-control-input"
                      />
                      <label class="custom-control-label" for="downtime-message-2">
                        Hello! Thank you for calling "Company Name".
                        Our offices are closed. We are open Monday
                        to Friday from 8.30 a.m. to 1.30 p.m. and
                        from 4.30 p.m. to 7.30 p.m. If you wish you
                        can send a fax to the number *** or an email
                        to ***. Thank you and goodbye for now!
                      </label>
                    </div>
                    <div class="custom-control custom-radio mb-3">
                      <input
                        type="radio"
                        id="downtime-message-custom"
                        name="downtime-message-custom"
                        class="custom-control-input"
                      />
                      <label class="custom-control-label" for="downtime-message-custom">Custom</label>
                    </div>
                    <div class="form-group">
                      <textarea
                        name="downtime-message"
                        id="downtime-message"
                        class="form-control resize-none"
                        rows="3"
                      ></textarea>
                    </div>
                  </div>
                </div>
              </fieldset>

              <fieldset class="mb-4">
                <legend class="pl-4">{{ trans('Message for on-hold calls') }}</legend>
                <div v-show="pbx.type === 'predefined'">
                  <div class="custom-control custom-radio mb-3">
                    <input
                      type="radio"
                      id="on-hold-message-1"
                      name="on-hold-message-1"
                      class="custom-control-input"
                    />
                    <label class="custom-control-label" for="on-hold-message-1">
                      Our operators are all busy as to not keep
                      you waiting too long, if you have called us
                      from an identifiable user, you will be
                      contacted by the first available operator.
                      Thank you for calling and talk to you later!
                    </label>
                  </div>
                  <div class="custom-control custom-radio mb-3">
                    <input
                      type="radio"
                      id="on-hold-message-custom"
                      name="on-hold-message-custom"
                      class="custom-control-input"
                    />
                    <label class="custom-control-label" for="on-hold-message-custom">Custom</label>
                  </div>
                  <div class="form-group pl-4">
                    <textarea
                      name="bon-hold-message"
                      id="on-hold-message"
                      class="form-control resize-none"
                      rows="5"
                    ></textarea>
                  </div>
                </div>
              </fieldset>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Extensions -->
    <div
      class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card"
    >
      <div class="card-body">
        <div class="row">
          <div class="col-xl-4">
            <h2 class="mb-1">{{ trans('Custom extensions') }}</h2>
            <p class="text-black-50">{{ trans('Custom extensions description') }}.</p>
          </div>
          <div
            class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0"
          >
            <div class="row">
              <div class="col-lg-10">
                <table class="border-bottom mb-2 table table-hover table-sm">
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
                    <tr class="content-action-hover" v-for="item in extensions" :key="item.id">
                      <td>
                        <input
                          type="number"
                          class="form-control form-control-sm w-75"
                          min="0"
                          v-model="item.number"
                        />
                      </td>
                      <td>
                        <input type="text" class="form-control form-control-sm" v-model="item.name" />
                      </td>
                      <td>
                        <button
                          class="action btn btn-link btn-sm mt-n1 py-0 text-danger"
                          @click="deleteExtension(item.id)"
                        >
                          <i class="fe fe-minus-circle h2"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <button class="btn btn-link text-secondary" @click="addExtension()">
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
    <div
      class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card"
    >
      <div class="card-body">
        <div class="row">
          <div class="col-xl-4">
            <h2 class="mb-1">{{ trans('Audio') }}</h2>
            <p class="text-black-50">{{ trans('Audio description') }}.</p>
          </div>
          <div
            class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0"
          >
            <!-- <div
              class="custom-checkbox custom-control custom-control-md"
            >
              <input
                type="checkbox"
                class="custom-control-input"
                id="professinal_greeting"
                checked
                disabled
              />
              <label
                class="align-items-start custom-control-label text-body"
                for="professinal_greeting"
              >{{ trans('Professional Greeting/Custom Recordings') }}</label>
            </div> -->
            <div>
              <div class="custom-control custom-control-md custom-radio d-inline-block mr-6">
                <input
                  type="radio"
                  id="predefined_audio"
                  name="type_audio"
                  class="custom-control-input"
                />
                <label for="predefined_audio" class="custom-control-label">Predefined</label>
              </div>
              <div class="custom-control custom-control-md custom-radio d-inline-block">
                <input
                  type="radio"
                  id="custom_audio"
                  name="type_audio"
                  class="custom-control-input"
                />
                <label for="custom_audio" class="custom-control-label">Custom</label>
              </div>
            </div>

            <h4 class="my-4">OR</h4>

            <div class="custom-checkbox custom-control custom-control-md">
              <input type="checkbox" class="custom-control-input" id="professinal_greeting" />
              <label
                class="align-items-start custom-control-label text-body"
                for="professinal_greeting"
              >
                {{ trans('Buy Professional Greeting/Custom Recordings') }}
                <span
                  class="form-text text-muted"
                >$ 8.00 (will be charge next month)</span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <button
      type="submit"
      class="btn btn-primary btn btn-primary ladda-button"
      style="zoom-out"
    >{{ trans('Save setting') }}</button>
  </div>
</template>

<script>
export default {
  props: {
    periods: {
      type: Array,
      required: true
    },
    messages: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      businessHours: {
        allDay: false,
        days: [
          {
            id: 'monday',
            text: 'Mon',
            open: null,
            close: null,
            isOpen: false
          },
          {
            id: 'tuesday',
            text: 'Tue',
            open: null,
            close: null,
            isOpen: false
          },
          {
            id: 'wednesday',
            text: 'Wed',
            open: null,
            close: null,
            isOpen: false
          },
          {
            id: 'thursday',
            text: 'Thu',
            open: null,
            close: null,
            isOpen: false
          },
          {
            id: 'friday',
            text: 'Fri',
            open: null,
            close: null,
            isOpen: false
          },
          {
            id: 'saturday',
            text: 'Sat',
            open: null,
            close: null,
            isOpen: false
          },
          {
            id: 'sunday',
            text: 'Sun',
            open: null,
            close: null,
            isOpen: false
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
            isClosed: false
          },
          {
            id: 'tuesday',
            text: 'Tue',
            start: null,
            end: null,
            isClosed: false
          },
          {
            id: 'wednesday',
            text: 'Wed',
            start: null,
            end: null,
            isClosed: false
          },
          {
            id: 'thursday',
            text: 'Thu',
            start: null,
            end: null,
            isClosed: false
          },
          {
            id: 'friday',
            text: 'Fri',
            start: null,
            end: null,
            isClosed: false
          },
          {
            id: 'saturday',
            text: 'Sat',
            start: null,
            end: null,
            isClosed: false
          },
          {
            id: 'sunday',
            text: 'Sun',
            start: null,
            end: null,
            isClosed: false
          }
        ]
      },
      notification: {
        email: '',
        period: 'daily'
      },
      pbx: {
        type: 'predefined'
      },
      extensions: []
    };
  },
  methods: {
    addExtension() {
      const extension = {
        id: new Date().valueOf(),
        number: null,
        name: ''
      };

      this.extensions.push(extension);
    },
    deleteExtension(id) {
      const index = this.extensions.findIndex(el => el.id === id);
      this.extensions.splice(index, 1);
    }
  }
};
</script>