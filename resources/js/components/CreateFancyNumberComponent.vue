<template>
  <div>
    <h2 class="mb-5">{{ trans('What do you want to do?') }}</h2>
  
    <div class="row">
      <div class="col-lg-5">
        <button
          class="btn btn-lg btn-light d-block d-md-inline-block w-100 w-md-auto mb-2"
          @click="setNumberType('fancy')"
        >Create New number</button>
        <p>
          <small>You can choose a brand new Fancyy number to publish and share any way you like</small>
        </p>
      </div>
      
      <div class="col-lg-2 h1 py-5 py-lg-0">or</div>

      <div class="col-lg">
        <button
          class="btn btn-lg btn-primary d-block d-md-inline-block w-100 w-md-auto mb-2"
          @click="setNumberType('custom')"
        >Use my existing number</button>
        <p>
          <small>
            You will get all of Fancyy's features by forwarding your existing calls to a secret Fancyy number. This lets you keep your published number and decide when to play the greeting.
          </small>
        </p>
      </div>
    </div>

    <div v-if="numberType">
      <hr />

      <form method="POST">
        <div class="card">
          <div class="card-body">
            <div class="form-group mb-0">
              <label for="phone_number">Current Number*</label>
              <input
                type="phone_number"
                class="form-control"
                id="phone_number"
                placeholder="(000) 000-0000"
                aria-describedby="phoneHelp"
                v-imask="phoneNumberMask"
                v-model="phoneNumber"
                @complete="onCompleteDate"
              />
              <p
                id="phoneHelp"
                class="form-text mb-0 text-muted"
              >We will email you instructions on how to forward your calls to your secret Fancyy number.</p>
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
                    <label for="did_region">{{ trans('State') }}</label>
                    <v-select name="did_region"
                      id="did_region"
                      label="text"
                      v-model="region"
                      :reduce="region => region.id"
                      :options="didRegions"></v-select>
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
                    <v-select name="did_city"
                      id="did_city"
                      label="text"
                      v-model="city"
                      :reduce="city => city.id"
                      :disabled="!region || isProcessing"
                      :options="cities"></v-select>
                  </div>
                </div>

                <div class="col">
                  <button
                    type="button"
                    class="btn btn-block btn-primary"
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

        <div class="text-right">
          <button
            class="btn btn-primary ladda-button px-4"
            type="submit"
            id="submit-fancy-number"
            data-style="zoom-out"
            v-show="showSubmitButton"
            @click.prevent="submit()"
          >
            <i class="fe fe-settings"></i>
            Next
          </button>
        </div>
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
      isProcessing: true,
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
      unmasKedPhoneNumber: '',
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
        // .get('https://datahub.io/core/country-list/r/data.json')
        .get('/data/countries.json')
        .then(response => (this.countries = response.data))
        .then(() => this.toggleProcessing);
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
    onCompleteDate: function(e) {
      this.unmasKedPhoneNumber = e.detail.unmaskedValue;
    },
    submit() {
      let data = {
        phone_number: this.unmasKedPhoneNumber,
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