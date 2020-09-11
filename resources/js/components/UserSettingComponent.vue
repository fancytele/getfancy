<template>
  <div class="mb-5">
    <form :action="urlAction" @submit.prevent="updateUser()">
      <input type="hidden" name="_method" value="PUT"/>
      <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
        <div class="card-body">
          <div class="row">
            <div class="col-xl-4">
              <h2 class="mb-1">{{ trans('User Profile') }}</h2>
            </div>
            <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label>{{ trans('First Name') }}</label>
                    <input type="text"
                           class="form-control"
                           required
                           v-model="user.first_name"
                    />
                    <div v-if ="errors.first_name" class = "validation-error">
                      <div v-for="error in errors.first_name" v-bind:key="error.id">
                                    <span class="small">
                                        {{error}}
                                    </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label>{{ trans('last Name') }}</label>
                    <input type="text"
                           class="form-control"
                           required
                           v-model="user.last_name"
                    />
                    <div v-if ="errors.last_name" class = "validation-error">
                      <div v-for="error in errors.last_name" v-bind:key="error.id">
                                    <span class="small">
                                        {{error}}
                                    </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label>{{ trans('E-mail') }}</label>
                    <input type="email"
                           class="form-control"
                           required
                           v-model="user.email"
                           />
                    <div v-if ="errors.email" class = "validation-error">
                      <div v-for="error in errors.email" v-bind:key="error.id">
                                    <span class="small">
                                        {{error}}
                                    </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label>{{ trans('Phone Number') }}</label>
                    <input type="phoneNumber"
                           class="form-control"
                           required
                           v-imask="phoneNumberMask"
                           v-model="user.phone_number"
                           @complete="onComplete"
                    />
                    <div v-if ="errors.phone_number" class = "validation-error">
                      <div v-for="error in errors.phone_number" v-bind:key="error.id">
                                    <span class="small">
                                        {{error}}
                                    </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
        <div class="card-body">
          <div class="row">
            <div class="col-xl-4">
              <h2 class="mb-1">{{ trans('Update Password') }}</h2>
            </div>
            <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label>{{ trans('Current Password') }}</label>
                    <input type="password"
                           class="form-control"
                           v-model="user.current_password"
                    />
                    <div v-if ="errors.current_password" class = "validation-error">
                      <div v-for="error in errors.current_password" v-bind:key="error.id">
                                    <span class="small">
                                        {{error}}
                                    </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label>{{ trans('New Password') }}</label>
                    <input type="password"
                           class="form-control"
                           v-model="user.new_password"
                    />
                    <div v-if ="errors.new_password" class = "validation-error">
                      <div v-for="error in errors.new_password" v-bind:key="error.id">
                                    <span class="small">
                                        {{error}}
                                    </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label>{{ trans('Confirm New Password') }}</label>
                    <input type="password"
                           class="form-control"
                           v-model="user.new_password_confirmation"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
        <div class="card-body">
          <div class="row">
            <div class="col-xl-4">
              <h2 class="mb-1">{{ trans('Billing Information') }}</h2>
            </div>
            <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label for="billing_address1">{{ trans('Address') }} 1</label>
                    <input
                        type="text"
                        class="form-control"
                        id="billing_address1"
                        name="billing_address1"
                        v-model="billing_address.address1"
                        required
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label for="billing_address2">{{ trans('Address') }} 2</label>
                    <input
                        type="text"
                        class="form-control"
                        id="billing_address2"
                        name="billing_address2"
                        v-model="billing_address.address2"
                        required
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label for="country">{{ trans('Country') }}</label>
                    <input
                        type="text"
                        class="form-control"
                        name="country"
                        id="country"
                        v-model="billing_address.country"
                        required
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label for="city">{{ trans('City') }}</label>
                    <input
                        type="text"
                        class="form-control"
                        id="city"
                        name="city"
                        v-model="billing_address.city"
                        required
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label for="state">{{ trans('State, Providence, Region') }}</label>
                    <input
                        type="text"
                        class="form-control"
                        id="state"
                        name="state"
                        v-model="billing_address.state"
                        required
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label for="zip_code">{{ trans('Zip Code') }}</label>
                    <input
                        type="text"
                        class="form-control"
                        id="zip_code"
                        name="zip_code"
                        v-model="billing_address.zip_code"
                        required
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
        <div class="card-body">
          <div class="row">
            <div class="col-xl-4">
              <h2 class="mb-1">{{ trans('Subscription') }}</h2>
            </div>
            <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
              <div class="row">
                <div class="col-md-8 col-lg-6">
                 <h5>Need to cancel your subcription?</h5>
                  <p>we're sad to see you go.</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                    <button @click="showCancelSubscriptionModal = true"
                            class="btn btn-danger btn btn-danger ladda-button"
                            data-style="zoom-out">
                      {{ trans('Cancel Subscription') }}
                    </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="text-right">
        <button type="submit"
                class="btn btn-primary btn btn-primary ladda-button"
                data-style="zoom-out">
          {{ trans('Submit') }}
        </button>
      </div>
    </form>

    <form action="/charge" method="post" id="payment-form">
      <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
        <div class="card-body">
          <div class="row">
            <div class="col-xl-4">
              <h2 class="mb-1">{{ trans('Update Payment Method') }}</h2>
            </div>
            <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <label for="card-element" style="margin-left:38px">{{ trans('Credit Card') }}</label>
                  <div id="card-element" style="margin:40px"></div>
                  <div id="card-errors" role="alert" style="margin-left:35px"></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <button>Submit Payment</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    <div class="relative">
      <div class="absolute" v-if="showCancelSubscriptionModal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                  <h2 class="text-center"><strong>{{ trans('Are you Sure?') }}</strong></h2>
                  <p class="text-center">{{ trans('If you cancel your subscription you will loss all your data.') }}</p>
                </div>
                <div class="d-flex justify-content-center">
                  <div>
                    <button class="btn btn-secondary btn btn-secondary ladda-button"
                            data-style="zoom-out" @click="showCancelSubscriptionModal = false">{{ trans('No! Go Back') }}</button>
                  </div>
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <div>
                    <button @click="cancelSubscriptionModal" class="btn btn-primary btn btn-primary ladda-button"
                            data-style="zoom-out">{{ trans('Yes, Sure') }}</button>
                  </div>

                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {IMaskDirective} from "vue-imask";
import {Stripe} from "vue-stripe-elements-plus";
//import { Card, createToken } from 'vue-stripe-elements-plus';

export default {
name: "UserSettingComponent",

  props:{
    lang: {
      type: String,
      default: 'en'
    },
    urlAction: {
      type: String,
      required: true
    },

    route: {
      type: String,
      required: true
    },

    url: {
      type: String,
      required: true
    },
  },
  directives: {
    imask: IMaskDirective
  },

  mounted() {
    this.getUserDetails();
  },
  data(){
    return {
      user: {
        first_name:'',
        last_name:'',
        email:'',
        phone_number:'',
        current_password:'',
        new_password: null,
        new_password_confirmation:''
      },
      billing_address:{
        address1: '',
        address2: '',
        city: '',
        country: '',
        state: '',
        zip_code: '',

      },
      errors: {
        first_name: null,
        last_name: null,
        email: null,
        phone_number: null,
        current_password: null,
        new_password: null,
        new_password_confirmation: null,
        subscription_id: null
      },
      unmasKedPhoneNumber: '',
      phoneNumberMask: {
        mask: '(000) 000-0000'
      },
      showCancelSubscriptionModal: false,

      tokenGlobal: "",
      tag: "",
      picked: "",
      userTags: [
        {
          text: "User Experience",
          tiClasses: ["valid"]
        },
        {
          text: "UI Design",
          tiClasses: ["valid"]
        },
        {
          text: "React JS",
          tiClasses: ["valid"]
        },
        {
          text: "HTML & CSS",
          tiClasses: ["valid"]
        },
        {
          text: "JavaScript",
          tiClasses: ["valid"]
        },
        {
          text: "Bootstrap 4",
          tiClasses: ["valid"]
        }
      ],
      stripetoken: {
        value: "",
        error: ""
      },
    };
  },

  methods:{
    stripeToken() {
      let that = this;
      var stripe = Stripe('pk_TMBfEj9GXcGCePpgJAFLIb8tHWpEA');
      var elements = stripe.elements();
      var style = {
        base: {
          color: "#32325d",
          fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
          fontSmoothing: "antialiased",
          fontSize: "16px",
          "::placeholder": {
            color: "#aab7c4"
          }
        },
        invalid: {
          color: "#fa755a",
          iconColor: "#fa755a"
        }
      };

      var card = elements.create("card", { style: style });
      card.mount("#card-element");

      card.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
          displayError.textContent = event.error.message;
        } else {
          displayError.textContent = '';
        }
      });

      var form = document.getElementById('payment-form');
      form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
          if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
          } else {
            // Send the token to your server.
            that.stripeTokenHandler(result.token);
          }
        });
      });

    },

    stripeTokenHandler(token) {
      this.tokenGlobal = token.id;
      console.log("Stripe Token" ,this.tokenGlobal);
    },
    getUserDetails() {
      axios.get(this.route)
            .then(response=>{
          console.log(response);
          this.user = response.data.user;
          this.billing_address = response.data.billing_information;
        })
            .catch(error => {
              console.log(error);
            });

    },

    onComplete: function(e) {
      this.unmasKedPhoneNumber = e.detail.unmaskedValue;
    },

    updateUser(){

      this.errors.first_name = null;
      this.errors.last_name = null;
      this.errors.phone_number =  null;
      this.errors.email =  null;
      this.errors.current_password = null;
      this.errors.new_password = null;

      axios.post(this.urlAction, {
        first_name: this.user.first_name,
        last_name: this.user.last_name,
        email: this.user.email,
        phone_number: this.unmasKedPhoneNumber,
        current_password: this.user.current_password,
        new_password: this.user.new_password,
        new_password_confirmation: this.user.new_password_confirmation,
        address_1: this.billing_address.address1,
        address_2: this.billing_address.address2,
        country: this.billing_address.country,
        city: this.billing_address.city,
        state: this.billing_address.state,
        zip_code: this.billing_address.zip_code
      })
      .then(response=>{
        console.log(response);
      })
      .catch(error => {
       console.log(error.response);
        this.errors.first_name= error.response.data.original.first_name;
        this.errors.last_name= error.response.data.original.last_name;
        this.errors.email=error.response.data.original.last_name;
        this.errors.phone_number=error.response.data.original.phone_number;
        this.errors.current_password=error.response.data.original.current_password;
        this.errors.new_password=error.response.data.original.new_password;
      });
    },

    cancelSubscriptionModal() {
      axios.get(this.url)
          .then(response=>{
            console.log(response);
          })
          .catch(error => {
            console.log(error.response);
            this.errors.subscription_id = error.response.data.data.errors.message;
            this.showCancelSubscriptionModal = false;
          });

    }
  }
}


</script>

<style scoped>
.validation-error{
  color: red;
}

.relative{
  position: relative;
}
.absolute{
  position: absolute;
  left: 50%;
  top: 50%;
}

.StripeElement {
  box-sizing: border-box;

  height: 40px;

  padding: 10px 12px;

  border: 1px solid transparent;
  border-radius: 4px;
  background-color: white;

  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}

</style>