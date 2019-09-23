<template>
  <div class="form-wizard">
    <div class="mb-3 row">
      <div class="col-lg-4 mb-3" v-for="(step, index) in steps" :key="step.id">
        <div
          class="form-step"
          @click="changeToStep(step)"
          :class="{'active': step.isActive, 'completed': !step.isActive && step.isCompleted }"
        >
          <div class="px-3 py-4">
            <div class="d-flex">
              <div class="mr-3 pt-1">
                <span class="form-step-number">{{ index + 1 }}</span>
              </div>
              <div>
                <h3 class="h2 mb-0">{{ trans(step.title) }}</h3>
                <h5 class="form-step-description">{{ trans(step.description) }}</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <form :action="action" id="create-user-form" method="POST" @submit.prevent="submit">
          <div v-show="currentStep.id === 'plans'">
            <div class="row">
              <div class="col-lg-6 col-xl-4">
                <div class="form-group">
                  <label for="product">{{ trans('Product') }}</label>
                  <select
                    name="product"
                    id="product"
                    class="form-control"
                    required
                    autofocus
                    :class="{'is-invalid': errors.hasOwnProperty('product')}"
                    v-model="user.product"
                  >
                    <option
                      v-for="product in products"
                      :key="product.slug"
                      :value="product.slug"
                    >{{ trans(product.name) }} - ${{ trans(product.cost) }}</option>
                  </select>
                  <div
                    class="invalid-feedback"
                    v-if="errors.hasOwnProperty('product')"
                  >{{ errors.product[0] }}</div>
                </div>

                <p>{{ trans('Additional Features') }}</p>
                <div class="form-group" v-for="addon in addons" :key="addon.code">
                  <div class="custom-control custom-switch">
                    <input
                      type="checkbox"
                      class="custom-control-input"
                      :id="addon.code"
                      :name="addon.code"
                      :aria-describedby="addon.code + '-help-block'"
                      :value="addon.code"
                      v-model="user.addons"
                    />
                    <label class="custom-control-label" :for="addon.code">
                      {{ trans(addon.name) }} - ${{ addon.cost }}
                      <span
                        :id="addon.code + '-help-block'"
                        class="form-text text-muted"
                      >{{ addon.name }} description text</span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="col-lg-5 col-xl-6 mt-4 mt-lg-0 offset-lg-1">
                <p class="font-weight-normal h3">{{ trans('Features') }}</p>
                <ul class="list-unstyled">
                  <li class="pb-3">
                    <i class="fe fe-check-circle"></i>
                    <span v-html="trans('Unlimited extensions')"></span>
                  </li>
                  <li class="pb-3">
                    <i class="fe fe-check-circle"></i>
                    <span v-html="trans('Customer support')"></span>
                  </li>
                  <li class="pb-3">
                    <i class="fe fe-check-circle"></i>
                    <span v-html="trans('All minutes = fixed')"></span>
                  </li>
                  <li class="pb-3">
                    <i class="fe fe-check-circle"></i>
                    <span v-html="trans('Choose your number')"></span>
                  </li>
                  <li class="pb-3">
                    <i class="fe fe-check-circle"></i>
                    <span v-html="trans('Conference call')"></span>
                  </li>
                  <li class="pb-3">
                    <i class="fe fe-check-circle"></i>
                    <span v-html="trans('Custom voice')"></span>
                  </li>
                  <li class="pb-3">
                    <i class="fe fe-check-circle"></i>
                    <span v-html="trans('Recording voice')"></span>
                  </li>
                  <li class="pb-3">
                    <i class="fe fe-check-circle"></i>
                    <span v-html="trans('Recording voicemail to Email')"></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <div v-show="currentStep.id === 'personal-information'">
            <fieldset>
              <legend>{{ trans('Personal information') }}</legend>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name">{{ trans('First Name') }}</label>
                    <input
                      type="text"
                      class="form-control"
                      id="first_name"
                      name="first_name"
                      required
                      :class="{'is-invalid': errors.hasOwnProperty('first_name')}"
                      v-model="user.first_name"
                    />
                    <div
                      class="invalid-feedback"
                      v-if="errors.hasOwnProperty('first_name')"
                    >{{ errors.first_name[0] }}</div>
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
                      required
                      :class="{'is-invalid': errors.hasOwnProperty('last_name')}"
                      v-model="user.last_name"
                    />
                    <div
                      class="invalid-feedback"
                      v-if="errors.hasOwnProperty('last_name')"
                    >{{ errors.last_name[0] }}</div>
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
                      required
                      :class="{'is-invalid': errors.hasOwnProperty('email')}"
                      v-model="user.email"
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
                      required
                      :class="{'is-invalid': errors.hasOwnProperty('email_confirmation')}"
                      v-model="user.email_confirmation"
                    />
                    <div
                      class="invalid-feedback"
                      v-if="errors.hasOwnProperty('email_confirmation')"
                    >{{ errors.email_confirmation[0] }}</div>
                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset class="mt-4">
              <legend>{{ trans('Billing information') }}</legend>
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
                      v-model="user.country"
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
                      required
                      :class="{'is-invalid': errors.hasOwnProperty('city')}"
                      v-model="user.city"
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
                      required
                      :class="{'is-invalid': errors.hasOwnProperty('state')}"
                      v-model="user.state"
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
                      :class="{'is-invalid': errors.hasOwnProperty('zip_code')}"
                      v-model="user.zip_code"
                    />
                    <div
                      class="invalid-feedback"
                      v-if="errors.hasOwnProperty('zip_code')"
                    >{{ errors.zip_code[0] }}</div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="address">{{ trans('Address') }}</label>
                    <input
                      type="text"
                      class="form-control"
                      id="address"
                      name="address"
                      required
                      :placeholder="trans('Street address, P.O. box, company name, c/o')"
                      :class="{'is-invalid': errors.hasOwnProperty('address')}"
                      v-model="user.address"
                    />
                    <div
                      class="invalid-feedback"
                      v-if="errors.hasOwnProperty('address')"
                    >{{ errors.address[0] }}</div>
                  </div>
                </div>
              </div>
            </fieldset>
          </div>

          <div v-show="currentStep.id === 'payment-information'">
            <div class="row">
              <div class="col-lg-6 col-xl-4">
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

              <div class="col-lg-5 col-xl-6 mt-4 mt-lg-0 offset-lg-1"></div>
            </div>
          </div>

          <div class="card-footer mt-4 pb-0 pl-0">
            <button
              type="button"
              class="btn btn-light mr-3 px-4"
              v-if="hasPreviousStep"
              @click="goToPreviousStep()"
            >{{ trans('Previous') }}</button>
            <button
              type="button"
              class="btn btn-primary px-4"
              v-if="!isLastStep"
              @click="goToNextStep()"
            >{{ trans('Next') }}</button>
            <button
              type="submit"
              id="submit-create-user"
              class="btn btn-primary ladda-button px-4"
              data-style="zoom-out"
              v-show="isLastStep"
            >{{ trans('Create') }}</button>
          </div>
        </form>
      </div>
    </div>

    <div
      id="user-created-message"
      tabindex="-1"
      role="dialog"
      class="modal fade"
      aria-hidden="true"
      v-if="isUserCreated"
    >
      <div role="document" class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
          <div class="modal-body p-0">
            <div class="d-flex my-3 pl-4 pt-4">
              <i class="display-4 fe fe-check-circle mr-3 mt-n2 mt-n3 text-success"></i>
              <div>
                <h3 class="mb-1">{{ trans('User created') }}</h3>
                <p class="line-height-normal text-black-50">{{ trans('User created messsage') }}</p>
              </div>
            </div>
            <div class="overflow-hidden rounded-bottom">
              <a
                :href="listUrl"
                data-style="zoom-out"
                class="btn btn-block btn-lg btn-success rounded-0"
              >{{ trans('Return to list') }}</a>
            </div>
          </div>
        </div>
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
    listUrl: {
      type: String,
      required: true
    },
    action: {
      type: String,
      required: true
    },
    products: {
      type: Array,
      required: true
    },
    addons: {
      type: Array,
      required: true
    }
  },
  components: {
    Card
  },
  data() {
    return {
      laddaButton: null,
      steps: [
        {
          id: 'plans',
          title: 'Plan & features',
          description: 'Select plan and one or more features',
          isActive: true,
          isCompleted: false,
          required: ['product']
        },
        {
          id: 'personal-information',
          title: 'Personal information',
          description: 'User information and billing address',
          isActive: false,
          isCompleted: false,
          required: [
            'first_name',
            'last_name',
            'email',
            'email_confirmation',
            'country',
            'city',
            'state',
            'zip_code',
            'address'
          ]
        },
        {
          id: 'payment-information',
          title: 'Payment information',
          description: 'Credic card and summary',
          isActive: false,
          isCompleted: false,
          required: []
        }
      ],
      currentStep: {},
      errors: {},
      user: {
        product: this.products[0].slug,
        addons: [],
        first_name: '',
        last_name: '',
        email: '',
        email_confirmation: '',
        country: null,
        city: '',
        state: '',
        zip_code: '',
        address: ''
      },
      countries: [],
      isProcessing: true,
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
      complete: false,
      stripeError: '',
      isUserCreated: false
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
    stripeChange($event) {
      this.complete = $event.complete;
      this.stripeError = $event.error ? $event.error.message : '';
    },
    toggleProcessing() {
      this.isProcessing = !this.isProcessing;
    },
    currentStepIsCompleted() {
      this.errors = {};

      this.currentStep.required.forEach(el => {
        if (Array.isArray(this.user[el]) && this.user[el].length === 0) {
          this.$set(this.errors, el, ['This field is required']);
        }

        if (this.user[el] === '') {
          this.$set(this.errors, el, ['This field is required']);
        }
      });

      return Object.keys(this.errors).length === 0;
    },
    changeToStep(step) {
      if (this.isProcessing) {
        return false;
      }

      const stepIndex = this.steps.findIndex(el => el === step);
      const currentStepIndex = this.steps.findIndex(
        el => el === this.currentStep
      );

      if (stepIndex - currentStepIndex > 1) {
        return false;
      }

      if (stepIndex > currentStepIndex && !this.currentStepIsCompleted()) {
        return false;
      }

      const previousStep = this.currentStep;
      previousStep.isActive = false;

      for (let i = stepIndex + 1; i < this.steps.length - 1; i++) {
        this.steps[i].isCompleted = false;
      }

      if (stepIndex > currentStepIndex) {
        previousStep.isCompleted = true;
      }

      this.currentStep = step;
      this.currentStep.isActive = true;
    },
    goToPreviousStep() {
      const currentStepIndex = this.steps.findIndex(
        el => el === this.currentStep
      );

      if (this.hasPreviousStep) {
        this.changeToStep(this.steps[currentStepIndex - 1]);
      }
    },
    goToNextStep() {
      const currentStepIndex = this.steps.findIndex(
        el => el === this.currentStep
      );

      if (!this.isLastStep) {
        this.changeToStep(this.steps[currentStepIndex + 1]);
      }
    },
    submit() {
      if (this.isProcessing) {
        return;
      }

      this.toggleProcessing();
      this.errors = {};
      this.laddaButton.start();

      createToken()
        .then(data => {
          this.user.stripe_token = data.token.id;
          this.processPayment();
        })
        .catch(error => this.stripeError.message);
    },
    processPayment() {
      axios
        .post(this.action, this.user)
        .then(response => {
          this.isUserCreated = true;

          this.$nextTick(() => {
            $('#user-created-message').modal({
              backdrop: 'static',
              keyboard: false
            });
          });
        })
        .catch(error => {
          const data = error.response.data;
          this.errors = data.errors;

          this.laddaButton.stop();
          this.toggleProcessing();
        });
    }
  },
  computed: {
    hasPreviousStep() {
      const currentStepIndex = this.steps.findIndex(
        el => el === this.currentStep
      );

      return currentStepIndex > 0;
    },
    isLastStep() {
      const currentStepIndex = this.steps.findIndex(
        el => el === this.currentStep
      );

      return currentStepIndex === this.steps.length - 1;
    }
  },
  mounted() {
    this.currentStep = this.steps[0];
    this.setCountryList();

    this.laddaButton = Ladda.create(
      document.querySelector('#submit-create-user')
    );
  }
};
</script>
