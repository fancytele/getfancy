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
                  Checkout
                  <span class="d-block d-lg-none text-primary">
                    {{ plan.name }}
                    ${{ plan.cost }}
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
                  Create Account
                </h3>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="first_name">First Name</label>
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
                      <label for="last_name">Last Name</label>
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
                      <label for="email">E-mail</label>
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
                      <label for="email_confirmation">Verify E-mail</label>
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
                      <label for="password">Password</label>
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
                      <label for="password_confirmation">Confirm Password</label>
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
                  Your Billing Information
                </h3>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="country">Country</label>
                      <input
                        type="text"
                        class="form-control"
                        id="country"
                        name="country"
                        placeholder="---"
                        required
                        v-model="checkout.country"
                        :class="{'is-invalid': errors.hasOwnProperty('country')}"
                        :readonly="isProcessing"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="errors.hasOwnProperty('country')"
                      >{{ errors.country[0] }}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="city">City</label>
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
                      <label for="state">State, Providence, Region</label>
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
                      <label for="zip_code">Zip Code</label>
                      <input
                        type="text"
                        class="form-control"
                        id="zip_code"
                        name="zip_code"
                        placeholder="---"
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
                      <label for="address">Address</label>
                      <input
                        type="text"
                        class="form-control"
                        id="address"
                        name="address"
                        placeholder="Street address, P.O. box, company name, c/o"
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
                  Additional Features
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
                  Your Payment Information
                </h3>
                <div>
                  <div class="form-group">
                    <label for="credit-card">Credict Card</label>
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
                  <h3 class="font-italic h2">Order Summary</h3>

                  <transition-group name="fade" tag="ul" class="list-unstyled text-black-50">
                    <li
                      class="align-items-center d-flex justify-content-between py-2"
                      v-for="item in summaryDetail"
                      :key="item.name"
                    >
                      {{ item.name }}
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
                <p class="small text-center text-danger" v-if="generalError">{{ generalError }}</p>
                <button
                  id="submit-payment"
                  type="submit"
                  class="btn btn-block btn-lg btn-primary font-weight-bold ladda-button py-3"
                  data-style="zoom-out"
                  :disabled="!complete"
                >Checkout</button>
                <p class="mt-4 text-center">
                  <span class="align-middle h2 mb-0 text-primary">
                    <i class="fa-question-circle far"></i>
                  </span>
                  <span class="font-weight-bold">Need any help?</span>
                  Don't hesitate to
                  <a
                    href="mailto:info@getfancy.co"
                    class="text-body text-decoration-underline"
                  >contact support!</a>
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
                >{{ plan.cost }}</span>
                <span class="d-inline-block h3 mb-0 plan-price-time text-white">/ {{ plan.slug }}</span>
              </div>
              <p class="font-italic mb-0">Automatically renews</p>
            </div>

            <ul class="list-unstyled">
              <li class="mb-2">
                <span class="mr-2">
                  <i class="far fa-check-circle"></i>
                </span>
                Unlimited extensions
              </li>
              <li class="mb-2">
                <span class="mr-2">
                  <i class="far fa-check-circle"></i>
                </span>
                Customer support
              </li>
              <li class="mb-2">
                <span class="mr-2">
                  <i class="far fa-check-circle"></i>
                </span>
                All minutes = fixed
              </li>
              <li class="mb-2">
                <span class="mr-2">
                  <i class="far fa-check-circle"></i>
                </span>
                Choose your number
              </li>
              <li class="mb-2">
                <span class="mr-2">
                  <i class="far fa-check-circle"></i>
                </span>
                Conference call
              </li>
              <li class="mb-2">
                <span class="mr-2">
                  <i class="far fa-check-circle"></i>
                </span>
                More...
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
          <div class="position-absolute pull-bottom pull-left mb-4 px-5 w-100">
            <h3 class="font-italic h2">Order Summary</h3>

            <ul class="list-unstyled text-white-50">
              <li
                class="align-items-center d-flex justify-content-between py-2"
                v-for="(item, index) in summaryDetail"
                :key="index"
              >
                {{ item.name }}
                <span>${{ item.cost }}</span>
              </li>
              <li
                class="align-items-center border-top border-white-50 d-flex font-weight-bold justify-content-between py-3 text-white"
              >
                <span class="h3 m-0">TOTAL</span>
                <span>${{ summaryTotal }}</span>
              </li>
            </ul>
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
    locale: {
      type: String,
      required: true
    },
    action: {
      type: String,
      required: true
    },
    plan: {
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
      isProcessing: false,
      checkout: {
        checkout_plan: this.plan.slug,
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
    stripeChange($event) {
      this.complete = $event.complete;
      this.stripeError = $event.error ? $event.error.message : '';
    },
    submit() {
      if (this.isProcessing) {
        return;
      }

      this.isProcessing = !this.isProcessing;
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
        .then(data => console.log(data))
        .catch(error => {
          const data = error.response.data;
          this.generalError = data.message;
          this.errors = data.errors;
        })
        .then(() => {
          this.laddaButton.stop();
          this.isProcessing = !this.isProcessing;
        });
    }
  },
  mounted() {
    this.laddaButton = Ladda.create(document.querySelector('#submit-payment'));
  },
  computed: {
    summaryDetail() {
      const plan = {
        name: this.plan.name,
        cost: this.plan.cost
      };

      const summary = this.addons
        .filter(el => this.checkout.addons.includes(el.code))
        .map(el => {
          return { name: el.name, cost: el.cost };
        });

      summary.unshift(plan);

      return summary;
    },
    summaryTotal() {
      return this.summaryDetail.reduce((prev, el) => prev + el.cost, 0);
    }
  }
};
</script>
