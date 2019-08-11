<template>
  <div class="border-4 card shadow">
    <div class="container-fluid">
      <div class="row">
        <!-- Form -->
        <div class="col-lg-8 pt-3">
          <form :action="action" method="POST" id="payment-form" @submit.prevent="submit">
            <div class="card-body">
              <div>
                <h2 class="display-4">
                  {{ trans('Checkout') }}
                  <span class="d-block d-lg-none text-primary">
                    {{ trans(product.name) }}
                    ${{ product.cost }}
                  </span>
                </h2>
              </div>

              <hr />

              <!-- Create Account -->
              <div class="pt-4">
                <h3 class="ml-n2">
                  <span class="fa-stack text-primary">
                    <i class="far fa-circle fa-stack-2x"></i>
                    <span class="fa-stack-1x">1</span>
                  </span>
                  {{ trans('Create Account') }}
                </h3>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="first_name">{{ trans('First Name') }}</label>
                      <input
                        type="text"
                        class="form-control"
                        id="first_name"
                        name="first_name"
                        placeholder="John"
                        required
                        autofocus
                        v-model="checkout.first_name"
                        :class="{'is-invalid': errors.hasOwnProperty('first_name')}"
                        :readonly="isProcessing"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="errors.hasOwnProperty('first_name')"
                      >{{ errors.first_name }}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="last_name">{{ trans('Last Name') }}</label>
                      <input
                        type="text"
                        class="form-control"
                        id="last_name"
                        name="last_name"
                        placeholder="Doe"
                        required
                        v-model="checkout.last_name"
                        :class="{'is-invalid': errors.hasOwnProperty('last_name')}"
                        :readonly="isProcessing"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="errors.hasOwnProperty('last_name')"
                      >{{ errors.last_name }}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">{{ trans('E-mail') }}</label>
                      <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        placeholder="johndoe@example.com"
                        required
                        v-model="checkout.email"
                        :class="{'is-invalid': errors.hasOwnProperty('email')}"
                        :readonly="isProcessing"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="errors.hasOwnProperty('email')"
                      >{{ errors.email[0] }}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email_confirmation">{{ trans('Verify E-mail') }}</label>
                      <input
                        type="email"
                        class="form-control"
                        id="email_confirmation"
                        name="email_confirmation"
                        placeholder="johndoe@example.com"
                        required
                        v-model="checkout.email_confirmation"
                        :class="{'is-invalid': errors.hasOwnProperty('email_confirmation')}"
                        :readonly="isProcessing"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="errors.hasOwnProperty('email_confirmation')"
                      >{{ errors.email_confirmation[0] }}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="password">{{ trans('Password') }}</label>
                      <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="********"
                        required
                        v-model="checkout.password"
                        :class="{'is-invalid': errors.hasOwnProperty('password')}"
                        :readonly="isProcessing"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="errors.hasOwnProperty('password')"
                      >{{ errors.password[0] }}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="password_confirmation">{{ trans('Confirm Password') }}</label>
                      <input
                        type="password"
                        class="form-control"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="********"
                        required
                        v-model="checkout.password_confirmation"
                        :class="{'is-invalid': errors.hasOwnProperty('password_confirmation')}"
                        :readonly="isProcessing"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="errors.hasOwnProperty('password_confirmation')"
                      >{{ errors.password_confirmation[0] }}</div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Create Account -->

              <hr class="mx-n5" />

              <!-- Billing Information -->
              <div class="pt-4">
                <h3 class="ml-n2">
                  <span class="fa-stack text-primary">
                    <i class="far fa-circle fa-stack-2x"></i>
                    <span class="fa-stack-1x">2</span>
                  </span>
                  {{ trans('Your Billing Information') }}
                </h3>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="country">{{ trans('Country') }}</label>
                      <select2
                        name="country"
                        id="country"
                        class="form-control"
                        :options="countries"
                        :class="{'is-invalid': errors.hasOwnProperty('country')}"
                        :readonly="isProcessing"
                        v-model="checkout.country"
                        required
                      >
                        <option disabled value>---</option>
                      </select2>
                      <div
                        class="invalid-feedback"
                        v-if="errors.hasOwnProperty('country')"
                      >{{ errors.country[0] }}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="city">{{ trans('City') }}</label>
                      <input
                        type="text"
                        class="form-control"
                        id="city"
                        name="city"
                        placeholder="---"
                        required
                        v-model="checkout.city"
                        :class="{'is-invalid': errors.hasOwnProperty('city')}"
                        :readonly="isProcessing"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="errors.hasOwnProperty('city')"
                      >{{ errors.city[0] }}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="state">{{ trans('State, Providence, Region') }}</label>
                      <input
                        type="text"
                        class="form-control"
                        id="state"
                        name="state"
                        placeholder="---"
                        required
                        v-model="checkout.state"
                        :class="{'is-invalid': errors.hasOwnProperty('state')}"
                        :readonly="isProcessing"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="errors.hasOwnProperty('state')"
                      >{{ errors.state[0] }}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="zip_code">{{ trans('Zip Code') }}</label>
                      <input
                        type="text"
                        class="form-control"
                        id="zip_code"
                        name="zip_code"
                        required
                        v-model="checkout.zip_code"
                        :class="{'is-invalid': errors.hasOwnProperty('zip_code')}"
                        :readonly="isProcessing"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="errors.hasOwnProperty('zip_code')"
                      >{{ errors.zip_code[0] }}</div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="address">{{ trans('Address') }}</label>
                      <input
                        type="text"
                        class="form-control"
                        id="address"
                        name="address"
                        :placeholder="trans('Street address, P.O. box, company name, c/o')"
                        required
                        v-model="checkout.address"
                        :class="{'is-invalid': errors.hasOwnProperty('address')}"
                        :readonly="isProcessing"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="errors.hasOwnProperty('address')"
                      >{{ errors.address[0] }}</div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Billing Information -->

              <hr class="mx-n5" />

              <!-- Additional Features -->
              <div class="pt-4">
                <h3 class="ml-n2">
                  <span class="fa-stack text-primary">
                    <i class="far fa-circle fa-stack-2x"></i>
                    <span class="fa-stack-1x">3</span>
                  </span>
                  {{ trans('Additional Features') }}
                </h3>
                <div>
                  <div class="form-group" v-for="item in addons" :key="item.code">
                    <div class="custom-control custom-switch">
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        :id="item.code"
                        :name="item.code"
                        :value="item.code"
                        v-model="checkout.addons"
                      />
                      <label class="custom-control-label" :for="item.code">
                        {{ item.name }}
                        <small class="d-block text-black-50">${{ item.cost }}</small>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Additional Features -->

              <hr class="mx-n5" />

              <!-- Payment Information -->
              <div class="pt-4">
                <h3 class="ml-n2">
                  <span class="fa-stack text-primary">
                    <i class="far fa-circle fa-stack-2x"></i>
                    <span class="fa-stack-1x">4</span>
                  </span>
                  {{ trans('Your Payment Information') }}
                </h3>
                <div>
                  <div class="form-group">
                    <label for="credit-card">{{ trans('Credit Card') }}</label>
                    <card
                      class="stripe-card"
                      :class="{ complete }"
                      :stripe="stripe"
                      :options="stripeOptions"
                      @change="stripeChange"
                    />
                    <div
                      id="card-errors"
                      class="d-block invalid-feedback"
                      role="alert"
                      v-show="stripeError"
                    >{{ stripeError }}</div>
                  </div>
                </div>
              </div>
              <!-- /Payment Information -->

              <hr class="mx-n5" />

              <!-- Submit -->
              <div class="pt-4">
                <!-- Summary -->
                <div class="d-lg-none">
                  <h3 class="font-italic h2">{{ trans('Order Summary') }}</h3>

                  <transition-group name="fade" tag="ul" class="list-unstyled text-black-50">
                    <li
                      class="align-items-center d-flex justify-content-between py-2"
                      v-for="item in summaryDetail"
                      :key="item.name"
                    >
                      {{ trans(item.name) }}
                      <span>${{ item.cost }}</span>
                    </li>
                    <li
                      class="align-items-center border-top d-flex font-weight-bold justify-content-between py-3 text-body"
                      key="total"
                    >
                      <span class="h3 m-0">TOTAL</span>
                      <span>${{ summaryTotal }}</span>
                    </li>
                  </transition-group>
                </div>

                <p class="small text-center text-danger" v-if="generalError">
                  {{ trans(generalError) }}
                  {{ trans('Please review your information') }}
                </p>
                <button
                  id="submit-payment"
                  type="submit"
                  class="btn btn-block btn-lg btn-primary font-weight-bold ladda-button py-3"
                  data-style="zoom-out"
                  :disabled="!complete"
                >{{ trans('Submit Checkout') }}</button>
                <p class="mt-4 text-center">
                  <span class="align-middle h2 mb-0 text-primary">
                    <i class="fa-question-circle far"></i>
                  </span>
                  <span class="font-weight-bold">{{ trans('Need any help?') }}</span>
                  {{ trans("Don't hesitate to") }}
                  <a
                    :href="`mailto:${supportEmail}`"
                    class="text-body text-decoration-underline"
                  >{{ trans('contact support') }}!</a>
                </p>
              </div>
              <!-- /Submit -->
            </div>
          </form>
        </div>
        <!-- /Form -->

        <!-- Information -->
        <div
          class="bg-primary col-lg-4 d-none d-lg-block position-relative pt-4 rounded-right text-white"
        >
          <div class="card-body">
            <div class="mb-4">
              <div>
                <span class="align-top d-inline-block h2 mb-0 plan-price-sign">$</span>
                <span
                  class="d-inline-block display-1 font-weight-light mt-n3 plan-price-amount"
                >{{ product.cost }}</span>
                <span
                  class="d-inline-block h3 mb-0 plan-price-time text-lowercase text-white"
                >/ {{ trans(product.name) }}</span>
              </div>
              <p class="font-italic mb-0">
                <span>{{ trans('Automatically renews every') }}</span>
                <span>{{ trans(product.renew) }}</span>
              </p>
            </div>

            <ul class="list-unstyled">
              <li class="mb-2">
                <span class="mr-2">
                  <i class="far fa-check-circle"></i>
                </span>
                <span v-html="trans('Unlimited extensions')"></span>
              </li>
              <li class="mb-2">
                <span class="mr-2">
                  <i class="far fa-check-circle"></i>
                </span>
                <span v-html="trans('Customer support')"></span>
              </li>
              <li class="mb-2">
                <span class="mr-2">
                  <i class="far fa-check-circle"></i>
                </span>
                <span v-html="trans('All minutes = fixed')"></span>
              </li>
              <li class="mb-2">
                <span class="mr-2">
                  <i class="far fa-check-circle"></i>
                </span>
                <span v-html="trans('Choose your number')"></span>
              </li>
              <li class="mb-2">
                <span class="mr-2">
                  <i class="far fa-check-circle"></i>
                </span>
                <span v-html="trans('Conference call')"></span>
              </li>
              <li class="mb-2">
                <span class="mr-2">
                  <i class="far fa-check-circle"></i>
                </span>
                {{ trans('More') }}...
              </li>
            </ul>

            <hr class="border-white-50" />

            <div class="mt-6">
              <blockquote class="blockquote blockquote-fancy">
                <p
                  class="font-italic"
                >Like you, our mission is to connect people, therefore the needs of our clients come first.</p>
                <footer class="blockquote-footer font-weight-bold text-white">
                  <img
                    class="mr-3 rounded-circle w-15"
                    src="https://media.licdn.com/dms/image/C5103AQGWZc65_HDAOQ/profile-displayphoto-shrink_800_800/0?e=1568246400&v=beta&t=hpibmKZIeORLRXDltT5pp196r-q2IR9Bd-8EJ25gDj8"
                    alt="Johnny Bosche"
                  />
                  Johnny Bosche
                </footer>
              </blockquote>
            </div>
          </div>

          <!-- Summary -->
          <div class="summary-checkout position-absolute pull-left px-5 w-100">
            <h3 class="font-italic h2">{{ trans('Order Summary') }}</h3>

            <transition-group name="fade" tag="ul" class="list-unstyled text-white-50">
              <li
                class="align-items-center d-flex justify-content-between py-2"
                v-for="item in summaryDetail"
                :key="item.name"
              >
                {{ trans(item.name) }}
                <span>${{ item.cost }}</span>
              </li>
              <li
                class="align-items-center border-top border-white-50 d-flex font-weight-bold justify-content-between py-3 text-white"
                key="total"
              >
                <span class="h3 m-0">TOTAL</span>
                <span>${{ summaryTotal }}</span>
              </li>
            </transition-group>
          </div>
        </div>
        <!-- /Summary -->

        <!-- /Information -->
      </div>
    </div>
  </div>
</template>

<script>
import { Card, createToken } from 'vue-stripe-elements-plus';

export default {
  props: {
    supportEmail: {
      type: String,
      required: true
    },
    locale: {
      type: String,
      required: true
    },
    action: {
      type: String,
      required: true
    },
    product: {
      type: Object,
      required: true
    },
    addons: {
      type: Array,
      required: true
    }
  },
  components: { Card },
  data() {
    return {
      laddaButton: null,
      complete: false,
      stripe: process.env.MIX_STRIPE_KEY,
      stripeOptions: {
        elements: {
          locale: this.locale
        },
        style: {
          base: {
            color: '#32325d',
            fontFamily: '"Cerebri Sans", sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
              color: '#b1c2d9'
            }
          },
          invalid: {
            color: '#e63757',
            iconColor: '#e63757'
          }
        },
        hidePostalCode: true
      },
      generalError: '',
      errors: {},
      stripeError: '',
      isProcessing: true,
      countries: [],
      checkout: {
        checkout_product: this.product.slug,
        stripe_token: '',
        first_name: '',
        last_name: '',
        email: '',
        email_confirmation: '',
        password: '',
        password_confirmation: '',
        country: '',
        city: '',
        state: '',
        zip_code: '',
        address: '',
        addons: []
      }
    };
  },
  methods: {
    setCountryList() {
      axios
        .get('https://datahub.io/core/country-list/r/data.json')
        .then(response => {
          this.countries = response.data.map(el => {
            return {
              id: el.Code,
              text: el.Name
            };
          });
        })
        .then(this.toggleProcessing);
    },
    toggleProcessing() {
      this.isProcessing = !this.isProcessing;
    },
    stripeChange($event) {
      this.complete = $event.complete;
      this.stripeError = $event.error ? $event.error.message : '';
    },
    submit() {
      if (this.isProcessing) {
        return;
      }

      this.toggleProcessing();
      this.generalError = '';
      this.errors = {};
      this.laddaButton.start();

      createToken()
        .then(data => {
          this.checkout.stripe_token = data.token.id;
          this.processPayment();
        })
        .catch(error => this.stripeError.message);
    },
    processPayment() {
      axios
        .post(this.action, this.checkout)
        .then(response => {
          window.location.href = response.data.route;
        })
        .catch(error => {
          const data = error.response.data;
          this.generalError = data.message;
          this.errors = data.errors;

          this.laddaButton.stop();
          this.toggleProcessing();
        });
    }
  },
  mounted() {
    this.laddaButton = Ladda.create(document.querySelector('#submit-payment'));
    this.setCountryList();
  },
  computed: {
    summaryDetail() {
      const product = {
        name: this.product.name,
        cost: this.product.cost
      };

      const summary = this.addons
        .filter(el => this.checkout.addons.includes(el.code))
        .map(el => {
          return { name: el.name, cost: el.cost };
        });

      summary.unshift(product);

      return summary;
    },
    summaryTotal() {
      return this.summaryDetail
        .reduce((prev, el) => prev + el.cost, 0)
        .toFixed(2);
    }
  }
};
</script>
