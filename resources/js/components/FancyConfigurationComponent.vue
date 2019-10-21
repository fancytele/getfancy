<template>
  <div id="did-settings" class="mb-5">
    <!-- Business Hours -->
    <div
      class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card"
    >
      <div class="card-body">
        <div class="row">
          <div class="col-xl-4">
            <h2 class="mb-1">Business hours</h2>
            <p class="text-black-50">
              Lorem ipsum dolor sit, amet consectetur adipisicing
              elit.
            </p>
          </div>
          <div
            class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0"
          >
            <div class="form-group">
              <div class="custom-control custom-control-block custom-switch">
                <label for="all_day">
                  <span class="custom-control-text">Open 24/7</span>
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
                class="align-items-baseline d-lg-flex mb-4 mb-lg-1"
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
                  >{{ item.text }}</label>
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

                <button class="btn btn-link pl-0 pl-lg-3 text-decoration-underline">
                  <i class="fe fe-copy"></i>
                  Copy to all
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
            <h2 class="mb-1">Notifications</h2>
            <p class="text-black-50">
              Lorem ipsum dolor sit amet, consectetur adipisicing
              elit.
            </p>
          </div>
          <div
            class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0"
          >
            <div class="row">
              <div class="col-md-8 col-lg-6">
                <div class="form-group">
                  <label for="email">E-mail</label>
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
                  <label for="period">Period</label>
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
            <p class="text-black-50">
              Lorem ipsum dolor sit amet, consectetur adipisicing
              elit.
            </p>
          </div>
          <div
            class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0"
          >
            <div class="custom-control custom-control-md custom-radio d-inline-block mr-5">
              <input
                type="radio"
                id="predefined"
                name="pbx_type"
                class="custom-control-input"
                value="predefined"
                v-model="pbx.type"
              />
              <label class="custom-control-label" for="predefined">Predefined</label>
            </div>
            <div class="custom-control custom-control-md custom-radio d-inline-block">
              <input
                type="radio"
                id="custom"
                name="pbx_type"
                class="custom-control-input"
                value="custom"
                v-model="pbx.type"
              />
              <label class="custom-control-label" for="custom">Custom</label>
            </div>

            <div class="mt-5">
              <fieldset class="mb-4">
                <legend class="pl-4">Message for Business hours</legend>
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
                </div>
                <div class="form-group pl-4" v-show="pbx.type === 'custom'">
                  <textarea
                    name="business_hours_message"
                    id="business_hours_message"
                    class="form-control resize-none"
                    rows="5"
                  ></textarea>
                </div>
              </fieldset>

              <fieldset class="mb-4">
                <legend class="pl-4">
                  Message for Downtime hours
                  <p
                    class="mt-n2 small text-warning"
                    v-if="businessHours.allDay"
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
                        name="downtime-message"
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
                  </div>

                  <div class="form-group pl-4" v-show="pbx.type === 'custom'">
                    <textarea
                      name="business_hours_message"
                      id="business_hours_message"
                      class="form-control resize-none"
                      rows="5"
                    ></textarea>
                  </div>
                </div>
              </fieldset>

              <fieldset class="mb-4">
                <legend class="pl-4">Message for On-hold hours</legend>
                <div v-show="pbx.type === 'predefined'">
                  <div class="custom-control custom-radio mb-3">
                    <input
                      type="radio"
                      id="on-hold-message-1"
                      name="on-hold-message"
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
                </div>
                <div class="form-group pl-4" v-show="pbx.type === 'custom'">
                  <textarea
                    name="business_hours_message"
                    id="business_hours_message"
                    class="form-control resize-none"
                    rows="5"
                  ></textarea>
                </div>
              </fieldset>
            </div>
          </div>
        </div>
      </div>
    </div>

    <button
      type="submit"
      class="btn btn-primary btn btn-primary ladda-button"
      style="zoom-out"
    >Save setting</button>
  </div>
</template>

<script>
export default {
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
      notification: {
        email: '',
        period: 'daily'
      },
      pbx: {
        type: 'predefined'
      }
    };
  }
};
</script>