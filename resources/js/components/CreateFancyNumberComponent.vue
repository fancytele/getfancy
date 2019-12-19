<template>
  <div>
    <div>
      <h2 class="mb-2">Fancy number</h2>
      <p class="text-muted mb-4">Get the Perfect Phone Number for Your Business</p>
    </div>

    <div>
      <button
        class="btn btn-lg btn-light d-block d-md-inline-block w-100 w-md-auto"
        @click="setNumberType('custom')"
      >Use my existing number</button>
      <span class="d-block d-md-inline h1 mx-4 my-3 my-md-0 text-center">or</span>
      <button
        class="btn btn-lg btn-info d-block d-md-inline-block w-100 w-md-auto"
        @click="setNumberType('fancy')"
      >Create New number</button>
    </div>

    <div v-if="numberType">
      <hr />

      <form method="POST">
        <div class="card">
          <div class="card-body">
            <div class="form-group mb-0">
              <label for="phone_number">Current number</label>
              <input
                type="phone_number"
                class="form-control"
                id="phone_number"
                placeholder="(000) 000-0000"
                aria-describedby="phoneHelp"
                v-imask="phoneNumberMask"
                v-model="phoneNumber"
              />
              <p
                id="phoneHelp"
                class="form-text mb-0 text-muted"
              >An agent will contact you for intructions to transferring your number.</p>
            </div>
          </div>
        </div>

        <transition name="fade">
          <div class="card" v-if="isNewNumber">
            <div class="card-body">
              <div class="row">
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
                    <label for="did_region">{{ trans('Region') }}</label>
                    <select2
                      name="did_region"
                      id="did_region"
                      class="form-control select2-hidden-accessible"
                      :options="didRegions"
                      :class="{'is-invalid select2-hidden-accessible': errors.hasOwnProperty('did_region'), 'form-control select2-hidden-accessible': !errors.hasOwnProperty('did_region')}"
                      v-model="region"
                    >
                      <option disabled value>---</option>
                    </select2>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="did_city">{{ trans('City') }}</label>
                    <div
                      class="spinner-border spinner-border-sm text-primary"
                      role="status"
                      v-show="isSearchingCities && cities.length === 0"
                    >
                      <span class="sr-only">{{ trans('Loading') }}...</span>
                    </div>

                    <select2
                      name="did_city"
                      id="did_city"
                      class="form-control select2-hidden-accessible"
                      :options="cities"
                      :class="{'is-invalid select2-hidden-accessible': errors.hasOwnProperty('did_city'), 'form-control select2-hidden-accessible': !errors.hasOwnProperty('did_city')}"
                      v-model="city"
                      :disabled="!region || isProcessing"
                    >
                      <option disabled value>---</option>
                    </select2>
                  </div>
                </div>

                <div class="col">
                  <button
                    type="button"
                    class="btn btn-block btn-info"
                    @click="searchAvailablesDIDs()"
                    :disabled="!city"
                  >
                    <i class="fe fe-search"></i>
                    {{ trans('Search') }}
                  </button>
                </div>
              </div>

              <hr v-show="availablesDIDs.length > 0" />

              <fieldset class="mb-5" v-show="availablesDIDs.length > 0">
                <legend>{{ trans('Select your number') }}</legend>
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
                        v-model="selectedDID"
                      />
                      <label
                        class="btn btn-block btn-lg btn-white custom-control-label cursor-pointer"
                        :for="item.attributes.number"
                      >{{ item.attributes.number| phone }}</label>
                    </div>
                  </div>
                </div>
              </fieldset>

              <div class="text-center" v-show="!hasError">
                <button
                  type="button"
                  id="load-more-dids"
                  class="btn btn-outline-primary px-4"
                  @click="getAvailablesDIDs()"
                  v-show="!isLoading && availablesDIDs.length > 0 && existsMoreAvailableDIDs"
                >{{ trans('Load more') }}...</button>
                <div
                  class="align-middle mt-4 spinner-border text-primary"
                  role="status"
                  v-show="isLoading"
                >
                  <span class="sr-only">{{ trans('Loading') }}...</span>
                </div>
              </div>

              <p
                class="text-center text-danger"
                v-if="hasError"
              >{{ trans('Internal error. Please try again or contact support') }}</p>
            </div>
          </div>
        </transition>

        <button
          class="btn btn-primary ladda-button px-4"
          type="submit"
          id="submit-fancy-number"
          data-style="zoom-out"
          v-show="showSubmitButton"
          @click.prevent="submit()"
        >
          Go to settings
          <i class="fe fe-settings"></i>
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import { IMaskDirective } from 'vue-imask';

export default {
  props: {
    didCountry: {
      type: Object,
      required: true
    },
    didRegions: {
      type: Array,
      required: true
    },
    urls: {
      type: Object,
      required: true
    }
  },
  directives: {
    imask: IMaskDirective
  },
  filters: {
    phone: function(value) {
      return value
        .replace(/[^0-9]/g, '')
        .replace(/(\d{1})(\d{3})(\d{3})(\d{4})/, '$1($2) $3-$4');
    }
  },
  data() {
    return {
      errors: {},
      isLoading: false,
      isProcessing: false,
      isSearchingCities: false,
      existsMoreAvailableDIDs: false,
      hasError: false,
      numberType: '',
      countries: [],
      cities: [],
      availablesDIDs: [],
      city: null,
      region: null,
      submitButton: null,
      selectedDID: {},
      phoneNumber: '',
      phoneNumberMask: {
        mask: '(000) 000-0000'
      }
    };
  },
  computed: {
    isExistingNumber() {
      return this.numberType === 'custom';
    },
    isNewNumber() {
      return this.numberType === 'fancy';
    },
    didAvailableUrl() {
      if (!this.city) {
        return '';
      }

      return this.urls.dids_availables.replace('_city_', this.city);
    },
    didCityUrl() {
      return this.urls.did_cities.replace('_region_', this.region);
    },
    reserveDIDCity() {
      return this.city;
    },
    reserveDIDRegion() {
      return this.region;
    },
    showSubmitButton() {
      if (this.isExistingNumber) {
        return this.phoneNumber;
      }

      if (this.isNewNumber) {
        return this.phoneNumber && this.selectedDID.id !== undefined;
      }

      return false;
    }
  },
  methods: {
    setNumberType(type) {
      this.numberType = type;

      if (!this.submitButton) {
        this.$nextTick(() => {
          this.submitButton = Ladda.create(
            document.querySelector('#submit-fancy-number')
          );
        });
      }
    },
    setCountryList() {
      this.toggleProcessing();

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
        .then(() => {
          this.toggleProcessing();
        });
    },
    getDIDCities() {
      if (this.isProcessing) {
        return;
      }

      this.toggleProcessing();
      this.isSearchingCities = true;

      axios
        .get(this.didCityUrl)
        .then(this.setDIDCityList)
        .catch(error => console.error(error))
        .then(() => {
          this.toggleProcessing();
          this.isSearchingCities = false;
        });
    },
    setDIDCityList(response) {
      this.cities = response.data;

      this.$nextTick(() => {
        this.city = response.data[0].id;
      });
    },
    getAvailablesDIDs() {
      if (this.isLoading || !this.city) {
        return;
      }

      this.toggleSearchDIDLoading();
      this.existsMoreAvailableDIDs = true;
      this.hasError = false;

      axios
        .get(this.didAvailableUrl)
        .then(this.setAvailablesDIDsList)
        .catch(() => (this.hasError = true))
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
      this.isLoading = !this.isLoading;
    },
    resetSearchDIDs() {
      this.availablesDIDs = [];
      this.existsMoreAvailableDIDs = true;

      this.selectedDID = {};
      this.cities = [];
      this.region = null;
      this.city = null;
      this.hasError = false;
    },
    searchAvailablesDIDs() {
      this.availablesDIDs = [];
      this.getAvailablesDIDs();
    },
    toggleProcessing() {
      this.isProcessing = !this.isProcessing;
    },
    submit() {
      let data = {
        phone_number: this.phoneNumber,
        number_type: this.numberType
      };

      if (this.isNewNumber) {
        data.did = {
          id: this.selectedDID.id,
          number: this.selectedDID.attributes.number
        };
      }

      this.submitButton.start();

      axios
        .post(this.urls.create_fancy, data)
        .then(response => {
          console.log(response);
          window.location = this.urls.fancy_settings.replace(
            '_user_',
            response.data.user
          );
        })
        .catch(error => {
          const data = error.response.data;

          if (data.errors) {
            this.errors = data.errors;
          }

          this.toggleProcessing();
          this.submitButton.stop();
        });
    }
  },
  watch: {
    reserveDIDCity() {
      this.availablesDIDs = [];
      this.selectedDID = {};
      this.hasError = false;
    },
    reserveDIDRegion(newValue) {
      this.city = null;
      this.cities = [];

      if (newValue) {
        this.getDIDCities();
      }
    }
  },
  mounted() {
    this.setCountryList();
  }
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>