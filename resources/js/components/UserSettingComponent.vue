<template>
  <div class="mb-5">
    <form :action="urlAction" @submit.prevent="onSubmit()">
      <input type="hidden" name="_method" value="PUT"/>
      <!--User Profile -->
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
      <!--User Profile -->

      <!--Update Password -->
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
      <!--Update Password -->

      <!--Billing information -->
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
      <!--Billing information -->

      <!--Update Payment Method -->
      <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
        <div class="card-body">
          <div class="row">
            <div class="col-xl-4">
              <h2 class="mb-1">{{ trans('Payment Method') }}</h2>
            </div>
            <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <label><strong>{{ trans('Available Cards') }}</strong></label>
                  <div v-for = "payment_method in payment_methods">
                    <div class="card" style="width: 22rem;">
                      <div class="card-body">
                        <div v-if="payment_method.id == default_card">
                          <span class="badge badge-pill badge-primary float-right">{{ trans('Default Card') }}</span>
                        </div>
                        <p class="card-text">{{ trans('Card brand:') }} <strong>{{ payment_method.card.brand }}</strong></p>
                        <p class="card-text">{{ trans('Card Number:') }} <strong>XXXX XXXX XXXX {{ payment_method.card.last4 }}</strong></p>
                        <p class="card-text">{{ trans('Card expiry date:') }}<strong>{{ payment_method.card.exp_month }}/{{ payment_method.card.exp_year }}</strong></p>
                        <div v-if="payment_method.id !== default_card">
                          <button @click ="deleteCardDetail(payment_method.id)" class="btn btn-primary btn btn-primary ladda-button"
                                  data-style="zoom-out">{{ trans('Delete') }}</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label for="credit-card"><strong>{{ trans('Add a new credit card') }}</strong></label>
                    <card
                        class="stripe-card"
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
            </div>
          </div>
        </div>
      </div>
      <!--Update Payment Method -->

      <!--Two Factor Authentication -->
      <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
        <div class="card-body">
          <div class="row">
            <div class="col-xl-4">
              <h2 class="mb-1">{{ trans('Two Factor Authentication') }}</h2>
            </div>
            <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
              <div class="row">
                <div class="col-md-8 col-lg-6">
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="custom-control custom-switch my-4">
                    <input
                        type="checkbox"
                        class="custom-control-input"
                        id="two-factor-authentication"
                        name="two-factor-authentication"
                        v-model="user.is_twoFactorAuthentication"
                        @change="toggleTwoFactorAuthentication()"
                    />
                    <label
                        class="custom-control-label"
                        for="two-factor-authentication"
                    >{{ trans('Do you want two factor authentication') }}?</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Two Factor Authentication -->

      <!--Submit Button -->
      <div class="text-right">
        <button type="submit"
                id="submit-user-setting"
                class="btn btn-primary btn btn-primary ladda-button"
                data-style="zoom-out">
          {{ trans('Submit') }}
        </button>
      </div>
      <!--Submit Button -->
      &nbsp;&nbsp;&nbsp;&nbsp;
    </form>

    <!--Cancel Subscription -->
    <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
      <div class="card-body">
        <div class="row">
          <div class="col-xl-4">
            <h2 class="mb-1">{{ trans('Subscription') }}</h2>
          </div>
          <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
            <div class="row">
              <div class="col-md-8 col-lg-6">
                <h5>Need to cancel your subscription?</h5>
                <p>we're sad to see you go.</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8 col-lg-6">
                <button @click="cancelSubscription(user.id)"
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
    <!--Cancel Subscription -->

    <!--Cancel Subscription Modal -->
    <div class="modal-align">
      <div class="modal-sm" v-if="showCancelSubscriptionModal">
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
                    <button @click="cancelSubscriptionModal(user_id)" class="btn btn-primary btn btn-primary ladda-button"
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
    <!--Cancel Subscription Modal -->
  </div>
</template>

<script>
import {IMaskDirective} from "vue-imask";
import { Card, createToken } from 'vue-stripe-elements-plus';

export default {
  name: "UserSettingComponent",

  props:{
    locale: {
      type: String,
      required: true
    },
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
    get_all_payment_methods:{
      type:String,
      required:true
    },
    delete_payment_method:{
      type:String,
      required:true
    }
  },
  directives: {
    imask: IMaskDirective
  },
  components: {
    Card
  },
  mounted() {
    this.getUserDetails();
    this.getAllPaymentMethods();

    this.laddaButton = Ladda.create(
        document.querySelector('#submit-user-setting')
    );
  },
  data(){
    return {
      laddaButton: null,
      user: {
        first_name:'',
        last_name:'',
        email:'',
        phone_number:'',
        current_password:'',
        new_password: null,
        new_password_confirmation:'',
        twoFactorAuthentication:null,
        is_twoFactorAuthentication:'',
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
      payment_methods:{},
      default_card:'',
      unmasKedPhoneNumber: '',
      phoneNumberMask: {
        mask: '(000) 000-0000'
      },
      showCancelSubscriptionModal: false,

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
        hidePostalCode: true,
      },
      stripeError: '',
      stripe_token: '',

      user_id:'',
    };
  },

  methods:{
    stripeChange($event) {
        this.complete = $event.complete;
        this.stripeError = $event.error ? $event.error.message : '';
    },

    cancelSubscription(id){
      this.user_id = id;
      this.showCancelSubscriptionModal = true;
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

    getAllPaymentMethods(){
      axios.get(this.get_all_payment_methods)
          .then(response=>{
            console.log(response);
            this.payment_methods = response.data[1].data;
            this.default_card = response.data[0];
            console.log(this.payment_methods);
          })
          .catch(error => {
            console.log(error);
          });
    },

    deleteCardDetail(id){
      let card_id = id;

       axios.post(this.delete_payment_method,{
         _method: 'delete',
          card_id :  card_id
         })
          .then(response=>{
            console.log(response);
            window.location.reload();
          })
          .catch(error => {
            console.log(error);
          });
    },
    toggleTwoFactorAuthentication(){
      this.user.twoFactorAuthentication = this.user.is_twoFactorAuthentication;
    },

    onComplete: function(e) {
      this.unmasKedPhoneNumber = e.detail.unmaskedValue;
    },

    onSubmit(){
      this.laddaButton.start();
      if(this.complete){
        createToken()
            .then(data => {
              this.stripe_token = data.token.id;
              this.laddaButton.stop();
              this.updateUser();
            })
            .catch(error => {
            });
      }
      else{
        this.laddaButton.stop();
        this.updateUser();
      }
    },
    updateUser(){
      this.laddaButton.start();
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
        zip_code: this.billing_address.zip_code,
        stripe_token:this.stripe_token,
        is_twoFactorAuthentication: this.user.twoFactorAuthentication,
      })
          .then(response=>{
            console.log(response);
            this.laddaButton.stop();
          })
          .catch(error => {
            console.log(error.response);
            this.errors.first_name= error.response.data.original.first_name;
            this.errors.last_name= error.response.data.original.last_name;
            this.errors.email=error.response.data.original.last_name;
            this.errors.phone_number=error.response.data.original.phone_number;
            this.errors.current_password=error.response.data.original.current_password;
            this.errors.new_password=error.response.data.original.new_password;
            this.laddaButton.stop();
          });
    },

    cancelSubscriptionModal(id) {

      axios.post(this.url ,{
        user_id :  id
      })
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
.modal-align{
  position: absolute;
  top: 40%;
  left:50%;
  margin-left: 200px;
}
</style>