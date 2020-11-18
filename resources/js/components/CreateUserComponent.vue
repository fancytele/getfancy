<template>
    <div class="form-wizard">
        <div class="mb-3 row">
            <div class="col-lg-3 mb-3" v-for="(step, index) in steps" :key="step.id">
                <div class="form-step"
                     @click="changeToStep(step)"
                     :class="{'active': step.isActive, 'completed': !step.isActive && step.isCompleted }">
                    <div class="px-3 py-4">
                        <div class="d-flex">
                            <div class="mr-3 pt-1">
                                <span class="form-step-number">{{ index + 1 }}</span>
                            </div>
                            <div class="text-truncate">
                                <h3 class="h2 mb-0 text-truncate">{{ trans(step.title) }}</h3>
                                <h5 class="form-step-description text-truncate">{{ trans(step.description) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div id="create-user-form">
                    <div v-show="currentStep.id === 'plans'">
                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="form-group">
                                  <label>{{ trans('How much do you want to pay?') }}</label>
                                  <div class="d-flex flex-row justify-content-center">
                                    <div>
                                      <span>{{ trans('$')}}</span>
                                    </div>
                                    <div>
                                      <input type="number"
                                             class="form-control"
                                             id="price"
                                             name="price"
                                             v-imask="priceMask"
                                             v-model="user.price"
                                             placeholder="__"
                                             required
                                             :class="{'is-invalid': errors.hasOwnProperty('price')}"
                                      >
                                      <div
                                          class="invalid-feedback"
                                          v-if="errors.hasOwnProperty('price')"
                                      >{{ errors.price[0] }}
                                      </div>
                                    </div>

                                  </div>
                                </div>
                              <div class="modal fade" id= "exampleModal" tabindex="-1" role="dialog"
                                   aria-labelledby="delete-element-label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                  <div class="modal-content">
                                    <div class="modal-body p-0">
                                      <button type="button" class="close mr-3 mt-3"
                                              data-dismiss="modal" aria-label="Close">
                                        <i class="fe fe-x-circle"></i>
                                      </button>
                                      <div class="d-flex my-3 pl-4 pt-4">
                                        <i
                                            class="display-4 fe fe-alert-circle mr-3 mt-n2 mt-n3 "></i>
                                        <div>
                                          <h3 class="mb-0">
                                            {{ trans('Heads Up!') }}
                                            <br>
                                            <span
                                                class="element-name text-capitalize"></span>{{ trans('Although we believe you should be able to name your own price, we don’t believe less than $10.00 is fair') }}
                                          </h3>
                                          <p class="element-detail text-black-50"></p>
                                        </div>
                                      </div>
                                        <div class="d-flex overflow-hidden rounded-bottom">
                                          <button type="button"
                                                  class="btn btn-lg btn-outline-primary rounded-0 text-body w-100"
                                                  data-dismiss="modal">
                                            {{ trans('OK') }}
                                          </button>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                                <p>{{ trans('Additional Features') }}</p>
                                <div class="form-group" v-for="addon in addons" :key="addon.code">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               :id="addon.code"
                                               :name="addon.code"
                                               :aria-describedby="addon.code + '-help-block'"
                                               :value="addon.code"
                                               v-model="user.addons"/>
                                        <label class="custom-control-label" :for="addon.code">
                                            {{ trans(addon.name) }} - ${{ addon.cost }}
                                            <span
                                                    :id="addon.code + '-help-block'"
                                                    class="form-text text-muted"
                                            >{{ addon.description }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xl-6">
                                <p class="font-weight-normal h3">{{ trans('Features') }}</p>
                                <ul class="list-unstyled">
                                    <li class="pb-3">
                                        <i class="fe fe-check-circle"></i>
                                        <span v-html="trans('Feature Phone Calls')"></span>
                                    </li>
                                    <li class="pb-3">
                                        <i class="fe fe-check-circle"></i>
                                        <span v-html="trans('Feature Text-able')"></span>
                                    </li>
                                    <li class="pb-3">
                                        <i class="fe fe-check-circle"></i>
                                        <span v-html="trans('Feature Auto-Reply SMS')"></span>
                                    </li>
                                    <li class="pb-3">
                                        <i class="fe fe-check-circle"></i>
                                        <span v-html="trans('Feature Data Driven')"></span>
                                    </li>
                                    <li class="pb-3">
                                        <i class="fe fe-check-circle"></i>
                                        <span v-html="trans('Feature Call Queues')"></span>
                                    </li>
                                    <li class="pb-3">
                                        <i class="fe fe-check-circle"></i>
                                        <span v-html="trans('Feature Auto-Play')"></span>
                                    </li>
                                    <li class="pb-3">
                                        <i class="fe fe-check-circle"></i>
                                        <span v-html="trans('Feature Conference Call Room')"></span>
                                    </li>
                                    <li class="pb-3">
                                        <i class="fe fe-check-circle"></i>
                                        <span v-html="trans('Feature E-Fax')"></span>
                                    </li>
                                    <li class="pb-3">
                                        <i class="fe fe-check-circle"></i>
                                        <span v-html="trans('Feature Spam Filtering Queues')"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div v-show="currentStep.id === 'fancy-number'">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="number_type">{{ trans('Phone Number Type') }}</label>
                                    <select
                                            class="form-control"
                                            name="number_type"
                                            id="number_type"
                                            required
                                            :class="{'is-invalid': errors.hasOwnProperty('number_type')}"
                                            v-model="user.number_type"
                                    >
                                        <option value="custom">{{ trans('Existing number') }}</option>
                                        <option value="fancy">{{ trans('New Fancyy number') }}</option>
                                    </select>
                                    <div
                                            class="invalid-feedback"
                                            v-if="errors.hasOwnProperty('number_type')"
                                    >{{ errors.number_type[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="number_type">{{ trans('Existing Number') }}</label>
                                    <input
                                            type="tel"
                                            class="form-control"
                                            id="phone_number"
                                            name="phone_number"
                                            required
                                            :class="{'is-invalid': errors.hasOwnProperty('phone_number') }"
                                            v-model="user.phone_number"
                                    />
                                    <div
                                            class="invalid-feedback"
                                            v-if="errors.hasOwnProperty('phone_number')"
                                    >{{ errors.phone_number[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <fieldset class="mt-4">
                            <legend>{{ trans('Reserve Fancyy Number') }}</legend>
                            <div v-if="userHasReservation">
                                <div class="mt-2">
                                    <p class="mb-0">
                                        <b>{{ trans('Fancyy Number') }}:</b>
                                        {{ user.did.number | phone }}
                                    </p>
                                </div>

                                <button
                                        id="cancel-reservation-did"
                                        type="button"
                                        class="btn btn-danger btn-sm ladda-button text-white"
                                        data-style="zoom-out"
                                        @click="cancelReservationDID()"
                                >
                                    <i class="fe fe-phone-off mr-2"></i>
                                    {{ trans('Cancel Reservation') }}
                                </button>
                            </div>

                            <button
                                    type="button"
                                    class="btn btn-secondary btn-sm text-white"
                                    data-toggle="modal"
                                    data-backdrop="static"
                                    data-target="#search-did"
                                    v-else
                                    @click="resetSearchDIDs()"
                            >
                                <i class="fe fe-search mr-2"></i>
                                {{ trans('Search Fancyy Numbers') }}
                            </button>

                            <div
                                    class="d-block invalid-feedback mt-3"
                                    v-if="errors.hasOwnProperty('did') || errors.hasOwnProperty('did.number') || errors.hasOwnProperty('did.reservation')"
                            >{{ trans('The Fancyy Number is required') }}
                            </div>
                        </fieldset>
                    </div>

                    <div v-show="currentStep.id === 'personal-information'">
                        <fieldset>
                            <legend>{{ trans('User Information') }}</legend>

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
                                        >{{ errors.first_name[0] }}
                                        </div>
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
                                        >{{ errors.last_name[0] }}
                                        </div>
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
                                                :class="{'border-success': user.email && user.email_confirmation && emailMatched, 'is-invalid': errors.hasOwnProperty('email') || user.email && user.email_confirmation && !emailMatched}"
                                                v-model="user.email"
                                        />
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('email')"
                                        >{{ errors.email[0] }}
                                        </div>
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
                                                :class="{'border-success': user.email && user.email_confirmation && emailMatched, 'is-invalid': errors.hasOwnProperty('email_confirmation') || user.email && user.email_confirmation && !emailMatched}"
                                                v-model="user.email_confirmation"
                                        />
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('email_confirmation')"
                                        >{{ errors.email_confirmation[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="mt-4">
                            <legend>{{ trans('Business Information') }}</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="company_name">{{ trans('Company Name') }}</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="company_name"
                                                name="company_name"
                                                required
                                                :class="{'is-invalid': errors.hasOwnProperty('company_name')}"
                                                v-model="user.company_name"
                                        />
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('company_name')"
                                        >{{ errors.company_name[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="company_phone">{{ trans('Company Phone') }}</label>
                                        <input
                                                type="tel"
                                                class="form-control"
                                                id="company_phone"
                                                name="company_phone"
                                                required
                                                :class="{'is-invalid': errors.hasOwnProperty('company_phone')}"
                                                v-model="user.company_phone"
                                        />
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('company_phone')"
                                        >{{ errors.company_phone[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="company_contact_name">{{ trans('Contact Name') }}</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="company_contact_name"
                                                name="company_contact_name"
                                                :class="{'is-invalid': errors.hasOwnProperty('company_contact_name')}"
                                                v-model="user.company_contact_name"
                                        />
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('company_contact_name')"
                                        >{{ errors.company_contact_name[0] }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="company_address1">{{ trans('Address') }} 1</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="company_address1"
                                                name="company_address1"
                                                required
                                                :placeholder="trans('Street address, P.O. box, company name, c/o')"
                                                :class="{'is-invalid': errors.hasOwnProperty('company_address1')}"
                                                v-model="user.company_address1"
                                        />
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('company_address1')"
                                        >{{ errors.company_address1[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="company_address2">{{ trans('Address') }} 2</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="company_address2"
                                                name="company_address2"
                                                :placeholder="trans('Apartment, suite, unit, building, floor, etc')"
                                                v-model="user.company_address2"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_country">{{ trans('Country') }}</label>
                                        <v-select name="company_country"
                                          id="company_country"
                                          label="Name"
                                          v-model="user.company_country"
                                          :reduce="country => country.Code"
                                          :options="countries"
                                          required></v-select>
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('company_country')"
                                        >{{ errors.company_country[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_city">{{ trans('City') }}</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="company_city"
                                                name="company_city"
                                                required
                                                :class="{'is-invalid': errors.hasOwnProperty('company_city')}"
                                                v-model="user.company_city"
                                        />
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('company_city')"
                                        >{{ errors.company_city[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_state">{{ trans('State, Providence, Region') }}</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="company_state"
                                                name="company_state"
                                                required
                                                :class="{'is-invalid': errors.hasOwnProperty('company_state')}"
                                                v-model="user.company_state"
                                        />
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('company_state')"
                                        >{{ errors.company_state[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_zip_code">{{ trans('Zip Code') }}</label>
                                        <input
                                                type="number"
                                                class="form-control"
                                                id="company_zip_code"
                                                name="company_zip_code"
                                                required
                                                :class="{'is-invalid': errors.hasOwnProperty('company_zip_code')}"
                                                v-model="user.company_zip_code"
                                        />
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('company_zip_code')"
                                        >{{ errors.company_zip_code[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div v-show="currentStep.id === 'payment-information'">
                        <fieldset>
                            <legend>{{ trans('Billing information') }}</legend>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="same-address"
                                            name="same-address"
                                            v-model="sameAddress"
                                            @change="toggleSameAddress()"
                                    />
                                    <label
                                            class="custom-control-label"
                                            for="same-address"
                                    >{{ trans('Same as Company address') }}?</label>
                                </div>
                            </div>

                            <div class="row" v-if="!sameAddress">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="billing_address1">{{ trans('Address') }} 1</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="billing_address1"
                                                name="billing_address1"
                                                required
                                                :disabled="sameAddress"
                                                :placeholder="trans('Street address, P.O. box, company name, c/o')"
                                                :class="{'is-invalid': errors.hasOwnProperty('billing_address1')}"
                                                v-model="user.billing_address1"
                                        />
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('billing_address1')"
                                        >{{ errors.billing_address1[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="billing_address2">{{ trans('Address') }} 2</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="billing_address2"
                                                name="billing_address2"
                                                :disabled="sameAddress"
                                                :placeholder="trans('Apartment, suite, unit, building, floor, etc')"
                                                v-model="user.billing_address2"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="billing_country">{{ trans('Country') }}</label>
                                        <v-select name="billing_country"
                                          id="billing_country"
                                          label="Name"
                                          v-model="user.billing_country"
                                          :disabled="sameAddress"
                                          :reduce="country => country.Code"
                                          :options="countries"
                                          required></v-select>
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('billing_country')"
                                        >{{ errors.billing_country[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="billing_city">{{ trans('City') }}</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="billing_city"
                                                name="billing_city"
                                                required
                                                :disabled="sameAddress"
                                                :class="{'is-invalid': errors.hasOwnProperty('billing_city')}"
                                                v-model="user.billing_city"
                                        />
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('billing_city')"
                                        >{{ errors.billing_city[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="billing_state">{{ trans('State, Providence, Region') }}</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="billing_state"
                                                name="billing_state"
                                                required
                                                :disabled="sameAddress"
                                                :class="{'is-invalid': errors.hasOwnProperty('billing_state')}"
                                                v-model="user.billing_state"
                                        />
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('billing_state')"
                                        >{{ errors.billing_state[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="billing_zip_code">{{ trans('Zip Code') }}</label>
                                        <input
                                                type="number"
                                                class="form-control"
                                                id="billing_zip_code"
                                                name="billing_zip_code"
                                                required
                                                :disabled="sameAddress"
                                                :class="{'is-invalid': errors.hasOwnProperty('billing_zip_code')}"
                                                v-model="user.billing_zip_code"
                                        />
                                        <div
                                                class="invalid-feedback"
                                                v-if="errors.hasOwnProperty('billing_zip_code')"
                                        >{{ errors.billing_zip_code[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="mt-4">
                            <legend>{{ trans('Payment information') }}</legend>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="credit-card">{{ trans('Credit Card') }}</label>
                                        <card
                                                id="credit-card"
                                                class="stripe-card"
                                                :class="{ 'complete': stripe.validationCompleted }"
                                                :stripe="stripe.key"
                                                :options="stripe.options"
                                                @change="stripeChange"
                                        />
                                        <div
                                                id="card-errors"
                                                class="d-block invalid-feedback"
                                                role="alert"
                                                v-show="stripe.error !== ''"
                                        >{{ stripe.error }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="card-footer mt-4 pb-0 px-0">
                        <div class="align-items-center row">
                            <div class="col">
                                <button
                                        type="button"
                                        class="btn btn-light mr-3 px-4"
                                        v-if="hasPreviousStep"
                                        @click="goToPreviousStep()"
                                >{{ trans('Back') }}
                                </button>
                                <button
                                        type="button"
                                        class="btn btn-primary px-4"
                                        v-if="!isLastStep"
                                        @click="goToNextStep()"
                                >{{ trans('Next') }}
                                </button>
                                <button
                                        type="submit"
                                        id="submit-create-user"
                                        class="btn btn-primary ladda-button px-4"
                                        data-style="zoom-out"
                                        v-show="isLastStep"
                                        @click.prevent="submit()"
                                >{{ trans('Submit') }}
                                </button>
                                <p
                                        class="d-inline-block mb-0 ml-lg-3 mt-3 mt-lg-0 text-danger"
                                        v-if="Object.keys(errors).length > 0"
                                >{{ trans('Something went wrong, please review all the steps') }}</p>
                                <p
                                        class="d-inline-block mb-0 ml-lg-3 mt-3 mt-lg-0 text-danger"
                                        v-if="errorMessage"
                                >{{ trans('errorMessage') }}</p>
                            </div>
                            <div class="col-auto" v-if="userHasReservation && userCreated === null">
                                <div class="mt-2 mt-md-0 text-danger text-right">
                                    <p class="mb-0">
                                        <strong class="text-decoration-underline">{{ trans('Fancyy Number') }} reservation expires in:</strong>
                                        <countdown-timer
                                                :end-date="user.did.expire_at"
                                                @countdown-over="reservationOver()"
                                        ></countdown-timer>
                                    </p>
                                </div>
                            </div>
                            <div class="col-auto" v-if="reservationHasExpired">
                                <div class="mt-2 mt-md-0 text-warning text-right">
                                    <p class="mb-0">
                                      <i class="fe fe-alert-triangle"></i>
                                      <strong class="text-decoration-underline">{{ trans('Fancyy Number') }} has expired</strong>, please select a new {{ trans('Fancyy Number') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
                id="search-did"
                tabindex="-1"
                role="dialog"
                class="modal fade"
                aria-hidden="true"
                aria-labelledby="search-did-title"
                v-if="!userHasReservation">
            <div role="document" class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 id="search-did-title" class="modal-title">{{ trans('Reserve Fancyy Number') }}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="align-items-end mb-5 row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="did_region">{{ trans('Country') }}</label>
                                    <select name="did_country" id="did_country" class="form-control" disabled>
                                        <option :value="didCountry.id">{{ didCountry.attributes.name }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="did_region">{{ trans('State or Region') }}</label>
                                    <v-select name="did_region"
                                      id="did_region"
                                      label="text"
                                      v-model="reservationDID.region"
                                      :reduce="region => region.id"
                                      :options="didRegions"
                                      required></v-select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="did_city">{{ trans('City') }}</label>
                                    <div
                                            class="spinner-border spinner-border-sm text-primary"
                                            role="status"
                                            v-show="reservationDID.isSearchingCities && reservationDID.cities.length === 0"
                                    >
                                        <span class="sr-only">{{ trans('Loading') }}...</span>
                                    </div>
                                    <v-select name="did_city"
                                      id="did_city"
                                      label="text"
                                      v-model="reservationDID.city"
                                      :reduce="city => city.id"
                                      :options="reservationDID.cities"
                                      :disabled="!reservationDID.region || isProcessing"
                                      required></v-select>
                                </div>
                            </div>

                            <div class="col">
                                <button
                                        type="button"
                                        class="btn btn-block btn-info"
                                        @click="searchAvailablesDIDs()"
                                        :disabled="!reservationDID.city"
                                >
                                    <i class="fe fe-search"></i>
                                    {{ trans('Search') }}
                                </button>
                            </div>
                        </div>

                        <hr v-show="availablesDIDs.length > 0"/>

                        <fieldset class="mb-5" v-show="availablesDIDs.length > 0">
                            <legend>
                                <span>{{ availablesDIDs.length }}</span>
                                {{ trans('Available Fancyy Numbers') }}
                            </legend>
                            <div class="overflow-auto row vh-max-35">
                                <div
                                        class="col-md-6 cursor-pointer mb-3"
                                        v-for="item in availablesDIDs"
                                        :key="item.id"
                                >
                                    <div class="custom-control custom-control-button custom-radio">
                                        <input
                                                type="radio"
                                                :id="item.attributes.number"
                                                :name="item.attributes.number"
                                                class="custom-control-input"
                                                :value="item"
                                                v-model="reservationDID.item"
                                        />
                                        <label
                                                class="btn btn-block btn-lg btn-white custom-control-label cursor-pointer"
                                                :for="item.attributes.number"
                                        >{{ item.attributes.number| phone }}</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <div class="text-center" v-show="!reservationDID.hasError">
                            <button
                                    id="load-more-dids"
                                    class="btn btn-outline-primary px-4"
                                    @click="getAvailablesDIDs()"
                                    v-show="!reservationDID.isLoading && availablesDIDs.length > 0 && existsMoreAvailableDIDs"
                            >{{ trans('Load more') }}...
                            </button>
                            <div
                                    class="align-middle mb-3 spinner-border text-primary"
                                    role="status"
                                    v-show="reservationDID.isLoading"
                            >
                                <span class="sr-only">{{ trans('Loading') }}...</span>
                            </div>
                        </div>

                        <p
                                class="text-center text-danger"
                                v-if="reservationDID.hasError"
                        >{{ trans('Internal error. Please close modal and try again') }}</p>
                    </div>

                    <div class="align-items-center modal-footer">
                        <div class="col" v-if="reservationDID.item.hasOwnProperty('id')">
                            {{ trans('Selected Fancyy Number') }}:
                            <div class="font-weight-bold">{{ reservationDID.item.attributes.number | phone }}</div>
                        </div>
                        <div class="col-auto">
                            <button
                                    type="button"
                                    class="btn btn-light px-4"
                                    data-dismiss="modal"
                            >{{ trans('Cancel') }}
                            </button>
                            <button
                                    id="submit-search-did"
                                    type="button"
                                    class="btn btn-primary ladda-button px-4"
                                    data-style="zoom-out"
                                    :disabled="!reservationDID.item.hasOwnProperty('id')"
                                    @click="reserveDID()"
                            >{{ trans('Reserve') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
                id="user-created-message"
                tabindex="-2"
                role="dialog"
                class="modal fade"
                aria-hidden="true"
                v-if="userCreated !== null">
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
                                    :href="fancySettingUrl"
                                    data-style="zoom-out"
                                    class="btn btn-block btn-lg btn-success rounded-0"
                            >{{ trans('Go to Fancyy Settings') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {IMaskDirective} from "vue-imask";
import { Card, createToken } from 'vue-stripe-elements-plus';

export default {
  props: {
    locale: {
      type: String,
      required: true
    },
    urls: {
      type: Object,
      required: true
    },
    didCountry: {
      type: Object,
      required: true
    },
    didRegions: {
      type: Array,
      required: true
    },
    addons: {
      type: Array,
      required: true
    },
    product_id:{
      type: String,
      required: true
    }
  },
  components: {
    Card
  },
  directives: {
    imask: IMaskDirective
  },

  data() {
    return {
      laddaButton: null,
      isProcessing: true,
      userCreated: null,
      errors: {},
      errorMessage: '',
      sameAddress: true,
      reservationHasExpired: false,
      reservationDID: {
        region: null,
        city: null,
        item: {},
        isLoading: false,
        isSearchingCities: false,
        existsMoreAvailableDIDs: true,
        searchSubmit: null,
        cancelSubmit: null,
        hasError: false,
        cities: []
      },
      steps: [
        {
          id: 'personal-information',
          title: 'Personal Information',
          description: 'User and Company information',
          isActive: true,
          isCompleted: false,
          required: [
            'first_name',
            'last_name',
            'email',
            'email_confirmation',
            'company_name',
            'company_phone',
            'company_country',
            'company_city',
            'company_state',
            'company_zip_code',
            'company_address1'
          ]
        },

        {
          id: 'payment-information',
          title: 'Payment Information',
          description: 'Billing address and credic card',
          isActive: false,
          isCompleted: false,
          required: [
            'billing_country',
            'billing_city',
            'billing_state',
            'billing_zip_code',
            'billing_address1'
          ]
        },
        {
          id: 'fancy-number',
          title: 'Fancyy Number on Hold',
          description: 'Virtual number reservation',
          isActive: false,
          isCompleted: false,
          required: ['number_type', 'phone_number', 'did']
        },
        {
          id: 'plans',
          title: 'Plan & Features',
          description: 'Select plan and one or more features',
          isActive: true,
          isCompleted: false,
          required: ['price']
        }
      ],
      currentStep: {},
      countries: [],
      availablesDIDs: [],
      existsMoreAvailableDIDs: true,
      stripe: {
        key: process.env.MIX_STRIPE_KEY,
        options: {
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
        validationCompleted: false,
        error: ''
      },
      user: {
        product_id: this.product_id,
        addons: [],
        first_name: '',
        last_name: '',
        email: '',
        email_confirmation: '',
        company_name: '',
        company_phone: '',
        company_contact_name: '',
        company_country: 'US',
        company_city: '',
        company_state: '',
        company_zip_code: '',
        company_address1: '',
        company_address2: '',
        billing_country: 'US',
        billing_city: '',
        billing_state: '',
        billing_zip_code: '',
        billing_address1: '',
        billing_address2: '',
        stripe_token: '',
        number_type: '',
        phone_number: '',
        did: {},
        price:'',
      },

      priceMask: {
        mask: '00'
      },
      invalid_cost: false
    };
  },
  methods: {
    setCountryList() {
      axios
        // .get('https://datahub.io/core/country-list/r/data.json')
        .get('/data/countries.json')
        .then(response => (this.countries = response.data))
        .then(() => this.toggleProcessing());
    },
    getDIDCities() {
      if (this.isProcessing) {
        return;
      }

      this.toggleProcessing();
      this.reservationDID.isSearchingCities = true;

      axios
        .get(this.didCityUrl)
        .then(this.setDIDCityList)
        .catch(error => console.error(error))
        .then(() => {
          this.toggleProcessing();
          this.reservationDID.isSearchingCities = false;
        });
    },
    setDIDCityList(response) {
      this.reservationDID.cities = response.data;

      this.$nextTick(() => {
        this.reservationDID.city = response.data[0].id;
      });
    },
    getAvailablesDIDs() {
      if (this.reservationDID.isLoading || !this.reservationDID.city) {
        return;
      }

      this.toggleSearchDIDLoading();
      this.existsMoreAvailableDIDs = true;
      this.reservationDID.hasError = false;

      axios
        .get(this.didAvailableUrl)
        .then(this.setAvailablesDIDsList)
        .catch(() => (this.reservationDID.hasError = true))
        .then(this.toggleSearchDIDLoading);
    },
    setAvailablesDIDsList(response) {
      if (this.availablesDIDs.length === 0) {
        this.availablesDIDs = response.data;
        return;
      }

      let mergedData = [].concat(this.availablesDIDs, response.data);
      let uniqueDIDs = _.uniqBy(mergedData, 'attributes.number');

      if (uniqueDIDs.length === this.availablesDIDs.length) {
        this.existsMoreAvailableDIDs = false;
        return;
      }

      this.availablesDIDs = uniqueDIDs;
    },
    toggleSearchDIDLoading() {
      this.reservationDID.isLoading = !this.reservationDID.isLoading;
    },
    resetSearchDIDs() {
      this.availablesDIDs = [];
      this.existsMoreAvailableDIDs = true;

      this.reservationDID.item = {};
      this.reservationDID.cities = [];
      this.reservationDID.region = null;
      this.reservationDID.city = null;
      this.reservationDID.hasError = false;
    },
    searchAvailablesDIDs() {
      this.availablesDIDs = [];
      this.getAvailablesDIDs();
    },
    reserveDID() {
      if (this.isProcessing) {
        return;
      }

      this.toggleProcessing();
      this.reservationDID.searchSubmit.start();

      axios
        .post(this.urls.did_reservation, { did: this.reservationDID.item.id })
        .then(this.setSuccessfullReservation)
        .catch(error => {
          console.error(error);
          this.reservationDID.hasError = true;

          if (this.reservationDID.searchSubmit) {
            this.reservationDID.searchSubmit.stop();
          }
        })
        .then(this.toggleProcessing);
    },
    setSuccessfullReservation(response) {
      let reservation = {
        id: this.reservationDID.item.id,
        number: this.reservationDID.item.attributes.number,
        reservation: response.data.id
      };

      this.reservationHasExpired = false;
      this.user.did = Object.assign(reservation, response.data.attributes);

      this.$nextTick(() => {
        this.reservationDID.searchSubmit = null;
        this.reservationDID.cancelSubmit = Ladda.create(
          document.querySelector('#cancel-reservation-did')
        );
      });

      $('#search-did').modal('hide');
    },
    cancelReservationDID() {
      if (!this.userHasReservation) {
        return;
      }

      this.reservationDID.cancelSubmit.start();

      axios
        .delete(`${this.urls.did_reservation}/${this.user.did.reservation}`)
        .then(this.reservationOver)
        .catch(error => {
          if (this.reservationDID.cancelSubmit) {
            this.reservationDID.cancelSubmit.stop();
          }

          console.error(error);
        });
    },
    reservationOver() {
      this.user.did = {};
      this.reservationDID.item = {};
      this.reservationDID.cancelSubmit = null;
      this.reservationHasExpired = true;

      this.resetSearchDIDs();

      this.$nextTick(() => {
        this.reservationDID.searchSubmit = Ladda.create(
          document.querySelector('#submit-search-did')
        );
      });
    },
    stripeChange($event) {
      this.stripe.validationCompleted = $event.complete;
      this.stripe.error = $event.error ? $event.error.message : '';
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

        if (
          el === 'email_confirmation' &&
          this.user.email !== this.user.email_confirmation
        ) {
          this.$set(this.errors, el, ['This field must match']);
        }

        if (
          this.user[el] instanceof Object &&
          Object.keys(this.user[el]).length === 0
        ) {
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

      for (let i = stepIndex + 1; i < this.steps.length-1; i++) {
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
        this.toggleSameAddress();
      }
    },
    toggleSameAddress() {
      if (this.sameAddress) {
        this.user.billing_country = this.user.company_country;
        this.user.billing_city = this.user.company_city;
        this.user.billing_state = this.user.company_state;
        this.user.billing_zip_code = this.user.company_zip_code;
        this.user.billing_address1 = this.user.company_address1;
        this.user.billing_address2 = this.user.company_address2;
      }
    },
    submit() {

      if(!this.currentStepIsCompleted())
      {
        return false;
      }
      if (this.isProcessing) {
        return;
      }

      this.toggleProcessing();
      this.errors = {};
      this.errorMessage = '';
      this.laddaButton.start();

      createToken()
        .then(data => {
          this.user.stripe_token = data.token.id;
          this.processPayment();
        })
        .catch(error => {
          this.toggleProcessing();
          this.laddaButton.stop();
        });
    },
    processPayment() {
      this.toggleSameAddress();

      axios
        .post(this.urls.create_user, this.user)
        .then(response => {
          this.userCreated = response.data.user;

          this.$nextTick(() => {
            $('#user-created-message').modal({
              backdrop: 'static',
              keyboard: false
            });
          });
        })
        .catch(error => {
          const data = error.response.data;

          if(data.errors.price){
            $('#exampleModal').modal('show');
          }
          if (data.message) {
            this.errorMessage = data.message;
          }

          if (data.errors) {
            if(data.errors.price){
              this.errors == null;
            }
            else{
              this.errors = data.errors;
            }

          }

          this.laddaButton.stop();
          this.toggleProcessing();
        });
    }


  },
  filters: {
    phone: function(value) {
      return value
        .replace(/[^0-9]/g, '')
        .replace(/(\d{1})(\d{3})(\d{3})(\d{4})/, '$1($2) $3-$4');
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
    },
    didCityUrl() {
      return this.urls.did_cities.replace(
        '_region_',
        this.reservationDID.region
      );
    },
    didAvailableUrl() {
      if (!this.reservationDID.city) {
        return '';
      }

      return this.urls.dids_availables.replace(
        '_city_',
        this.reservationDID.city
      );
    },
    reserveDIDCity() {
      return this.reservationDID.city;
    },
    reserveDIDRegion() {
      return this.reservationDID.region;
    },
    userHasReservation() {
      return this.user.did.hasOwnProperty('reservation');
    },
    fancySettingUrl() {
      if (this.userCreated === null) {
        return '';
      }

      return this.urls.fancy_settings.replace('_user_', this.userCreated);
    },
    emailMatched() {
      return this.user.email === this.user.email_confirmation;
    }
  },
  watch: {
    reserveDIDCity() {
      this.availablesDIDs = [];
      this.reservationDID.item = {};
      this.reservationDID.hasError = false;
    },
    reserveDIDRegion(newValue) {
      this.reservationDID.city = null;
      this.reservationDID.cities = [];

      if (newValue) {
        this.getDIDCities();
      }
    }
  },
  mounted() {
    this.currentStep = this.steps[0];
    this.setCountryList();

    this.reservationDID.searchSubmit = Ladda.create(
      document.querySelector('#submit-search-did')
    );
    this.laddaButton = Ladda.create(
      document.querySelector('#submit-create-user')
    );
  }
};
</script>
<style scoped>
#price{
  border: none;
}
input:focus{
  outline: none;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>