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
            <div class="border-top border-top-2 col-xl-12 pt-4">
              <div class="row">
                <div class="col-md-6 col-lg-6">
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
                <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                    <label>{{ trans('Last Name') }}</label>
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
                <div class="col-md-6 col-lg-6">
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
                <div class="col-md-6 col-lg-6">
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
            <div class="border-top border-top-2 col-xl-12 pt-4">
              <div class="row">
                <div class="col-md-6 col-lg-6">
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
                <div class="col-md-6 col-lg-6">
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
                <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                    <label>{{ trans('Confirm New Password') }}</label>
                    <input type="password"
                           class="form-control"
                           v-model="user.new_password_confirmation"
                    />
                  </div>
                </div>
              </div>
              <div class="row">
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
            <div class="border-top border-top-2 col-xl-12 pt-4">
              <div class="row">
                <div class="col-md-6 col-lg-6">
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
                    <div v-if ="errors.address1" class = "validation-error">
                      <div v-for="error in errors.address1" v-bind:key="error.id">
                                    <span class="small">
                                        {{error}}
                                    </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="billing_address2">{{ trans('Address') }} 2</label>
                    <input
                        type="text"
                        class="form-control"
                        id="billing_address2"
                        name="billing_address2"
                        v-model="billing_address.address2"
                    />
                    <div v-if ="errors.address2" class = "validation-error">
                      <div v-for="error in errors.address2" v-bind:key="error.id">
                                    <span class="small">
                                        {{error}}
                                    </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-lg-6">
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
                    <div v-if ="errors.country" class = "validation-error">
                      <div v-for="error in errors.country" v-bind:key="error.id">
                                    <span class="small">
                                        {{error}}
                                    </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-6">
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
                    <div v-if ="errors.city" class = "validation-error">
                      <div v-for="error in errors.city" v-bind:key="error.id">
                                    <span class="small">
                                        {{error}}
                                    </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-lg-6">
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
                    <div v-if ="errors.state" class = "validation-error">
                      <div v-for="error in errors.state" v-bind:key="error.id">
                                    <span class="small">
                                        {{error}}
                                    </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-6">
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
                    <div v-if ="errors.zip_code" class = "validation-error">
                      <div v-for="error in errors.zip_code" v-bind:key="error.id">
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
                    <div class="card" style="max-width: 22rem;">
                      <div class="card-body">
                        <div v-if="payment_method.id == default_card">
                          <span class="badge badge-pill badge-primary float-right">{{ trans('Default Card') }}</span>
                        </div>
                        <div v-if="payment_method.id != default_card">
                          <a href="#" @click="setAsDefaultCard(payment_method.id)"><span class="badge badge-pill badge-secondary float-right">{{ trans('Set As Default Card') }}</span></a>
                        </div>
                        <p class="card-text" style="text-transform: capitalize;"><small>{{ trans('Card Brand:') }} {{ payment_method.card.brand }}</small></p>
                        <p class="card-text"><small>{{ trans('Card Number:') }} XXXX XXXX XXXX {{ payment_method.card.last4 }}</small></p>
                        <p class="card-text"><small>{{ trans('Card Expiry Date:')}} {{ payment_method.card.exp_month }}/{{ payment_method.card.exp_year }}</small></p>
                        <div v-if="payment_method.id !== default_card" class="text-right">
                          <button @click ="deleteCardDetail(payment_method.id)"  class="btn btn-primary btn btn-primary ladda-button"
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
                    <label for="credit-card"><strong>{{ trans('Add A New Credit Card') }}</strong></label>
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
      <!-- Update Payment Method -->

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
                        style="text-transform: capitalize"
                    >{{ trans('Do you want two factor authentication') }}?</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Two Factor Authentication -->

      <!--Cancel Subscription -->
      <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
        <div class="card-body">
          <div class="row">
            <div class="col-xl-4">
              <h2 class="mb-1">{{ trans('Subscription') }}</h2>
            </div>
            <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
              <div class="row">
                <div class="col-md-8 col-lg-6" style="text-transform: capitalize">
                  <h5>Need to cancel your subscription?</h5>
                  <p>we're sad to see you go.</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-lg-6">
                  <button
                      class="btn btn-danger btn btn-danger ladda-button"
                      data-style="zoom-out"
                      data-toggle="modal"
                      data-target="#exampleModal"
                      :disabled='isDisabled'
                  >
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
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
           aria-labelledby="delete-element-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-body p-0">
              <button type="button" class="close mr-3 mt-3"
                      data-dismiss="modal" aria-label="Close">
                <i class="fe fe-x-circle"></i>
              </button>
              <form :action="url" class="mb-0" @submit.prevent="cancelSubscriptionModal(user.id)">
                <div class="d-flex my-3 pl-4 pt-4">
                  <i
                      class="display-4 fe fe-alert-circle mr-3 mt-n2 mt-n3 "></i>
                  <div>
                    <h3 class="mb-0">
                      {{ trans('Are You Sure?') }}
                      <br>
                      <span
                          class="element-name text-capitalize"></span>{{ trans('If You Cancel Your Subscription You Will Lose Data.') }}
                    </h3>
                    <p class="element-detail text-black-50"></p>
                  </div>
                </div>

                <div class="d-flex overflow-hidden rounded-bottom">
                  <button type="button"
                          class="btn btn-lg btn-outline-light rounded-0 text-body w-50"
                          data-dismiss="modal">
                    {{ trans('No! Go Back') }}
                  </button>
                  <button type="submit"
                          id="cancel-subscription"
                          class="btn btn-lg btn-danger ladda-button rounded-0 w-50"
                          data-style="zoom-out">
                    {{ trans('Yes, Sure') }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!--Cancel Subscription Modal -->

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
    </form>
    
    <!-- Add Authorized User
    <form :action="add_authorized_user" @submit.prevent="addAuthorizedUser()">
    <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
      <div class="card-body">
        <div class="row">
          <div class="col-xl-4">
            <h2 class="mb-1">{{ trans('Add Authorized User') }}</h2>
          </div>
          <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
            <div v-for="authorized_user in authorized_users">
              <div v-if="user.authorized_user_id_1 && user.authorized_user_id_1 == authorized_user['id']" class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label>{{ trans('Authorized User') }} <a  href="#"
                                                              data-style="zoom-out"
                                                              data-toggle="modal"
                                                              data-target="#DeleteAuthorisedUserFirstModal"><i class="fa fa-trash" aria-hidden="true"></i></a></label>
                    <h5>{{ trans('Name: ') }} {{ authorized_user['first_name'] + ' ' +authorized_user['last_name'] }}</h5>
                    <h5>{{ trans('Email: ') }} {{ authorized_user['email']}}</h5>
                  </div>
                </div>
                <div class="modal fade" id="DeleteAuthorisedUserFirstModal" tabindex="-1" role="dialog"
                     aria-labelledby="delete-element-label" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                      <div class="modal-body p-0">
                        <button type="button" class="close mr-3 mt-3"
                                data-dismiss="modal" aria-label="Close">
                          <i class="fe fe-x-circle"></i>
                        </button>
                        <form :action="delete_authorized_user" class="mb-0" @submit.prevent="deleteAuthorizedUser(user.authorized_user_id_1)">
                          <div class="d-flex my-3 pl-4 pt-4">
                            <i
                                class="display-4 fe fe-alert-circle mr-3 mt-n2 mt-n3 "></i>
                            <div>
                              <h3 class="mb-0">
                                {{ trans('Are you Sure?') }}
                                <br>
                              </h3>
                              <p class="element-detail text-black-50"></p>
                            </div>
                          </div>

                          <div class="d-flex overflow-hidden rounded-bottom">
                            <button type="button"
                                    class="btn btn-lg btn-outline-light rounded-0 text-body w-50"
                                    data-dismiss="modal">
                              {{ trans('No! Go Back') }}
                            </button>
                            <button type="submit"
                                    class="btn btn-lg btn-danger ladda-button rounded-0 w-50"
                                    data-style="zoom-out">
                              {{ trans('Yes, Sure') }}
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-if="user.authorized_user_id_2 && user.authorized_user_id_2 == authorized_user['id']" class="row">

                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label>{{ trans('Authorized User') }} <a  href="#"
                                                              data-style="zoom-out"
                                                              data-toggle="modal"
                                                              data-target="#DeleteAuthorisedUserSecondModal"><i class="fa fa-trash" aria-hidden="true"></i></a></label>
                    <h5>{{ trans('Name: ') }} {{ authorized_user['first_name'] + ' ' +authorized_user['last_name'] }}</h5>
                    <h5>{{ trans('Email: ') }} {{ authorized_user['email']}}</h5>
                  </div>
                </div>
                <div class="modal fade" id="DeleteAuthorisedUserSecondModal" tabindex="-1" role="dialog"
                     aria-labelledby="delete-element-label" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                      <div class="modal-body p-0">
                        <button type="button" class="close mr-3 mt-3"
                                data-dismiss="modal" aria-label="Close">
                          <i class="fe fe-x-circle"></i>
                        </button>
                        <form :action="delete_authorized_user" class="mb-0" @submit.prevent="deleteAuthorizedUser(user.authorized_user_id_2)">
                          <div class="d-flex my-3 pl-4 pt-4">
                            <i
                                class="display-4 fe fe-alert-circle mr-3 mt-n2 mt-n3 "></i>
                            <div>
                              <h3 class="mb-0">
                                {{ trans('Are you Sure?') }}
                                <br>
                              </h3>
                              <p class="element-detail text-black-50"></p>
                            </div>
                          </div>

                          <div class="d-flex overflow-hidden rounded-bottom">
                            <button type="button"
                                    class="btn btn-lg btn-outline-light rounded-0 text-body w-50"
                                    data-dismiss="modal">
                              {{ trans('No! Go Back') }}
                            </button>
                            <button type="submit"
                                    class="btn btn-lg btn-danger ladda-button rounded-0 w-50"
                                    data-style="zoom-out">
                              {{ trans('Yes, Sure') }}
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-if="user.authorized_user_id_3 && user.authorized_user_id_3 == authorized_user['id']" class="row">
                <div class="col-md-8 col-lg-6">
                  <div class="form-group">
                    <label>{{ trans('Authorized User') }}  <a  href="#"
                                                               data-style="zoom-out"
                                                               data-toggle="modal"
                                                               data-target="#DeleteAuthorisedUserThirdModal"><i class="fa fa-trash" aria-hidden="true"></i></a></label>
                    <h5>{{ trans('Name: ') }} {{ authorized_user['first_name'] + ' ' +authorized_user['last_name'] }}</h5>
                    <h5>{{ trans('Email: ') }} {{ authorized_user['email']}}</h5>
                  </div>
                </div>
                <div class="modal fade" id="DeleteAuthorisedUserThirdModal" tabindex="-1" role="dialog"
                     aria-labelledby="delete-element-label" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                      <div class="modal-body p-0">
                        <button type="button" class="close mr-3 mt-3"
                                data-dismiss="modal" aria-label="Close">
                          <i class="fe fe-x-circle"></i>
                        </button>
                        <form :action="delete_authorized_user" class="mb-0" @submit.prevent="deleteAuthorizedUser(user.authorized_user_id_3)">
                          <div class="d-flex my-3 pl-4 pt-4">
                            <i
                                class="display-4 fe fe-alert-circle mr-3 mt-n2 mt-n3 "></i>
                            <div>
                              <h3 class="mb-0">
                                {{ trans('Are you Sure?') }}
                                <br>
                              </h3>
                              <p class="element-detail text-black-50"></p>
                            </div>
                          </div>

                          <div class="d-flex overflow-hidden rounded-bottom">
                            <button type="button"
                                    class="btn btn-lg btn-outline-light rounded-0 text-body w-50"
                                    data-dismiss="modal">
                              {{ trans('No! Go Back') }}
                            </button>
                            <button type="submit"
                                    class="btn btn-lg btn-danger ladda-button rounded-0 w-50"
                                    data-style="zoom-out">
                              {{ trans('Yes, Sure') }}
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div v-if="!user.authorized_user_id_1" class="row">
              <div class="col-md-8 col-lg-6">
                <div class="form-group">
                  <label>{{ trans('Add New Authorized User') }}</label>
                  <input type="email"
                         class="form-control"
                         v-model="user.authorized_user_1"

                  />
                  <div v-if ="errors.authorized_user_1" class = "validation-error">
                    <div v-for="error in errors.authorized_user_1" v-bind:key="error.id">
                                    <span class="small">
                                        {{error}}
                                    </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div v-if="!user.authorized_user_id_2" class="row">
              <div class="col-md-8 col-lg-6">
                <div class="form-group">
                  <label>{{ trans('Add New Authorized User') }}</label>
                  <input type="email"
                         class="form-control"
                         v-model="user.authorized_user_2"

                  />
                  <div v-if ="errors.authorized_user_2" class = "validation-error">
                    <div v-for="error in errors.authorized_user_2" v-bind:key="error.id">
                                    <span class="small">
                                        {{error}}
                                    </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div v-if="!user.authorized_user_id_3" class="row">
              <div class="col-md-8 col-lg-6">
                <div class="form-group">
                  <label>{{ trans('Add New Authorized User') }}</label>
                  <input type="email"
                         class="form-control"
                         v-model="user.authorized_user_3"
                  />
                  <div v-if ="errors.authorized_user_3" class = "validation-error">
                    <div v-for="error in errors.authorized_user_3" v-bind:key="error.id">
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
      <div class="text-right">
        <button type="submit"
                id="add_authorized_user"
                class="btn btn-primary btn btn-primary ladda-button"
                data-style="zoom-out">
          {{ trans('Add') }}
        </button>
      </div>
    </form>
    Add Authorized User -->
  </div>
</template>

<script>
import {IMaskDirective} from "vue-imask";
import {Card, createToken} from 'vue-stripe-elements-plus';

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
    },
    update_two_factor_authentication:{
      type:String,
      required:true
    },
    add_authorized_user:{
      type:String,
      required:true
    },
    delete_authorized_user:{
      type:String,
      required:true
    },
    update_default_card:{
      type:String,
      required:true
    },
    phone_system_dashboard_link:{
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
    this.getPhoneSystemDashboardLink();
    this.laddaButton = Ladda.create(
        document.querySelector('#submit-user-setting')
    );
  },

  data(){
    return {
      laddaButton: null,
      authorized_users:{},
      user: {
        first_name:'',
        last_name:'',
        email:'',
        phone_number:'',
        current_password:'',
        new_password: null,
        new_password_confirmation:'',
        is_twoFactorAuthentication:'',
        subscription:'',
        authorized_user_id_1:'',
        authorized_user_id_2:'',
        authorized_user_id_3:'',
        authorized_user_1:'',
        authorized_user_2:'',
        authorized_user_3:'',
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
        address1: null,
        address2: null,
        city: null,
        country: null,
        state: null,
        zip_code: null,
        authorized_user_1:null,
        authorized_user_2:null,
        authorized_user_3:null,
      },
      payment_methods:{},
      default_card:'',
      unmasKedPhoneNumber: '',
      phoneNumberMask: {
        mask: '(000) 000-0000'
      },

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
    };
  },

  methods:{
    stripeChange($event) {
        this.complete = $event.complete;
        this.stripeError = $event.error ? $event.error.message : '';
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
      })
          .then(response=>{
            console.log(response);
            window.location.reload();
            this.laddaButton.stop();
          })
          .catch(error => {
            console.log(error.response);
            this.errors.first_name= error.response.data.original.first_name;
            this.errors.last_name= error.response.data.original.last_name;
            this.errors.email= error.response.data.original.last_name;
            this.errors.phone_number= error.response.data.original.phone_number;
            this.errors.current_password= error.response.data.original.current_password;
            this.errors.new_password= error.response.data.original.new_password;
            this.errors.address1= error.response.data.original.address_1;
            this.errors.address2= error.response.data.original.address_2;
            this.errors.city= error.response.data.original.city;
            this.errors.country= error.response.data.original.country;
            this.errors.state= error.response.data.original.state;
            this.errors.zip_code= error.response.data.original.zip_code;
            this.laddaButton.stop();
          });
    },

    setAsDefaultCard(id){
      axios.post(this.update_default_card,{
        'card_id' : id
      })
      .then(response=>{
        console.log(response);
        this.laddaButton.stop();
        window.location.reload();
      })
      .catch(error => {
        console.log(error);
        this.laddaButton.stop();
      });
    },
    deleteCardDetail(id){
      axios.post(this.delete_payment_method,{
         _method: 'delete',
          card_id :  id
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
      axios.post(this.update_two_factor_authentication,{
        is_twoFactorAuthentication: this.user.is_twoFactorAuthentication
      })
          .then(response=>{
            console.log(response);
          })
          .catch(error => {
            console.log(error.response);
          });

    },

    addAuthorizedUser(){
      this.laddaButton = Ladda.create(
          document.querySelector('#add_authorized_user')
      );

      this.laddaButton.start();

      this.errors.authorized_user_1 = null;
      this.errors.authorized_user_2 = null;
      this.errors.authorized_user_3 = null;
      axios.post(this.add_authorized_user,{
        'authorized_user_1' : this.user.authorized_user_1,
        'authorized_user_2' : this.user.authorized_user_2,
        'authorized_user_3' : this.user.authorized_user_3,

      })
        .then(response=>{
          console.log(response);
          this.laddaButton.stop();
          window.location.reload();
        })
        .catch(error => {
          console.log(error.response);
          this.laddaButton.stop();
          this.errors.authorized_user_1 = error.response.data.original.authorized_user_1
          this.errors.authorized_user_2 = error.response.data.original.authorized_user_2
          this.errors.authorized_user_3 = error.response.data.original.authorized_user_3
        });


    },

    deleteAuthorizedUser(id){
      axios.post(this.delete_authorized_user ,{
        'authorized_user_id': id
      })
          .then(response=>{
            console.log(response);
            this.laddaButton.stop();
            window.location.reload();
          })
          .catch(error => {
            console.log(error.response);
            this.laddaButton.stop();
          });
    },

    cancelSubscriptionModal(id) {
      this.laddaButton = Ladda.create(
          document.querySelector('#cancel-subscription')
      );
      this.laddaButton.start();
      axios.post(this.url ,{
        'user_id': id
      })
          .then(response=>{
            console.log(response);
            this.laddaButton.stop();
            window.location.reload();
          })
          .catch(error => {
            console.log(error.response);
            this.laddaButton.stop();
            window.location.reload();
          });
    },

    getUserDetails() {
      axios.get(this.route)
          .then(response=>{
            console.log(response);
            this.user = response.data.user;
            this.billing_address = response.data.billing_information;
            this.user.subscription = response.data.subscription;
            this.authorized_users = response.data.authorized_users;
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
          })
          .catch(error => {
            console.log(error);
          });
    },

    getPhoneSystemDashboardLink(){
      axios.get(this.phone_system_dashboard_link)
          .then(response=>{
            console.log(response);
          })
          .catch(error => {
            console.log(error.response);
          });
    }
  },

  computed: {
    isDisabled() {
      if(this.user.subscription == null)
      {
        return true;
      }
      else{
        return false;
      }
    },
  }
}


</script>

<style scoped>
.validation-error{
  color: red;
}
</style>