<template>
    <div id="did-settings" class="mb-5">
        <form :action="urlAction" @submit.prevent="saveSetting()">
            <input type="hidden" name="_method" value="PUT"/>

            <!-- Notification -->
            <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <h2 class="mb-1">{{ trans('Notifications') }}</h2>
                            <p class="text-black-50">{{ trans('Notifications description') }}</p>
                        </div>
                        <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
                            <div class="row">
                                <div class="col-md-8 col-lg-6">
                                    <div class="form-group">
                                        <label for="email">{{ trans('E-mail') }}</label>
                                        <input type="email"
                                               class="form-control"
                                               id="email"
                                               name="email"
                                               required
                                               v-model="notification.email"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-lg-6">
                                    <div class="form-group">
                                        <label for="period">{{ trans('Period') }}</label>
                                        <select name="period"
                                                id="period"
                                                class="form-control text-capitalize"
                                                required
                                                v-model="notification.period">
                                            <option :value="period"
                                                    v-for="period in notificationPeriods"
                                                    :key="period">
                                                {{ trans(period) }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PBX -->
            <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <h2 class="mb-1">{{ trans('PBX Message') }}</h2>
                            <p class="text-black-50">{{ trans('Choose your PBX message') }}.</p>
                        </div>
                        <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
                            <div>
                                <fieldset class="mb-4">
                                    <legend class="pl-4">{{ trans('Message') }}</legend>
                                    <div>
                                        <div class="custom-control custom-radio mb-3"
                                             v-for="item in messages.business"
                                             :key="item.id">
                                            <input type="radio"
                                                   :id="`${item.type}_message_${item.id}`"
                                                   name="business-message"
                                                   class="custom-control-input"
                                                   :value="item.id"
                                                   v-model="pbx.business"/>
                                            <label class="custom-control-label"
                                                   :for="`${item.type}_message_${item.id}`">
                                                {{ trans(item.message) }}
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio"
                                                   id="business_message_0"
                                                   name="business-message"
                                                   class="custom-control-input"
                                                   value="0"
                                                   v-model="pbx.business"/>
                                            <label class="custom-control-label" for="business_message_0">
                                              {{ trans('Custom message') }}
                                            </label>
                                        </div>
                                        <div class="form-group pl-4"
                                             :class="{'disabled-setting': pbx.business != 0}">
                                            <textarea name="business_message_custom"
                                                      id="business_message_custom"
                                                      class="form-control resize-none"
                                                      rows="3"
                                                      :disabled="pbx.business != 0"
                                                      v-model="pbx.business_text"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Extensions -->
            <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <h2 class="mb-1">{{ trans('Custom extensions') }}</h2>
                            <p class="text-black-50">{{ trans('Custom extensions description') }}.</p>
                        </div>
                        <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
                            <div class="row">
                                <div class="col-lg-10">
                                    <table class="border-bottom mb-2 table table-hover table-sm" ref="extensions-table">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ trans('Number') }}</th>
                                            <th scope="col">{{ trans('Name') }}</th>
                                            <th>
                                                <span class="sr-only">Action</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="content-action-hover"
                                            v-for="item in extensions"
                                            :key="item.id">
                                            <td>
                                                <label :for="'extension_number_'+ item.id"
                                                       class="sr-only">Extension number</label>
                                                <input type="number"
                                                       :id="'extension_number_'+ item.id"
                                                       class="form-control form-control-sm w-75"
                                                       min="0"
                                                       v-model="item.number"/>
                                            </td>
                                            <td>
                                                <label :for="'extension_name_'+ item.id"
                                                       class="sr-only">Extension name</label>
                                                <input type="text"
                                                       :id="'extension_name_'+ item.id"
                                                       class="form-control form-control-sm"
                                                       v-model="item.name"/>
                                            </td>
                                            <td>
                                                <button class="action btn btn-link btn-sm mt-n1 py-0 text-danger"
                                                        @click="deleteExtension(item.id)">
                                                    <i class="fe fe-minus-circle h2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-link" @click="addExtension()">
                                        <i class="fe fe-plus"></i>
                                        {{ trans('Add a new extension') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Audio -->
            <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <h2 class="mb-1">{{ trans('Audio') }}</h2>
                            <p class="text-black-50">{{ trans('Audio description') }}.</p>
                        </div>
                        <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
                            <div>
                                <div :class="{'disabled-setting': buyProfessionalRecording}">
                                  <div>
                                      <div class="custom-control custom-control-md custom-radio d-xl-inline-block mb-4 mr-6">
                                          <input type="radio"
                                                id="predefined_audio"
                                                name="type_audio"
                                                class="custom-control-input"
                                                value="predefined"
                                                v-model="audioType"/>
                                          <label for="predefined_audio" class="custom-control-label">{{ trans('Predefined') }}</label>
                                      </div>
                                      <div class="custom-control custom-control-md custom-radio d-xl-inline-block mb-4 mr-6">
                                          <input type="radio"
                                                id="custom_audio"
                                                name="type_audio"
                                                value="custom"
                                                class="custom-control-input"
                                                v-model="audioType"/>
                                          <label for="custom_audio" class="custom-control-label">{{ trans('Upload personal Recording') }}</label>
                                      </div>
                                      <div class="custom-control custom-control-md custom-radio d-xl-inline-block mb-4 "
                                          v-if="hasProfessionalRecording">
                                          <input type="radio"
                                                id="professional_audio"
                                                name="type_audio"
                                                value="professional"
                                                class="custom-control-input"
                                                v-model="audioType"/>
                                          <label for="professional_audio" class="custom-control-label">
                                            {{ trans('Professional Greeting/Custom Recordings') }}
                                          </label>
                                      </div>
                                  </div>

                                  <div class="custom-file mb-4" v-if="allowUploadAudio && audioType == 'custom'">
                                    <input type="file" 
                                           class="custom-file-input"
                                           id="audioFile" 
                                           accept=".mp3,audio/*"
                                           :lang="lang"
                                           @change="setAudioFile">
                                    <label class="custom-file-label" for="audioFile">
                                      <span v-if="audioFile == null">{{ trans('Select custom audio') }}</span>
                                      <span v-else>{{ audioFile.name }}</span>
                                    </label>
                                  </div>
                                </div>

                                <div v-if="hasProfessionalRecording === false">
                                    <h4 class="mb-4">OR</h4>

                                    <div class="custom-checkbox custom-control custom-control-md">
                                        <input type="checkbox" class="custom-control-input"
                                              id="buy_professional_greeting"
                                              v-model="buyProfessionalRecording"/>
                                        <label class="align-items-start custom-control-label text-body"
                                              for="buy_professional_greeting">
                                            {{ trans('Buy Professional Greeting/Custom Recordings') }}
                                            <span class="form-text text-muted">$ 8.00 (will be charge immediately)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit"
                    id="submit-fancy-setting"
                    class="btn btn-primary btn btn-primary ladda-button"
                    data-style="zoom-out">
                {{ trans('Save settings') }}
            </button>
        </form>

        <div id="success-modal"
             tabindex="-2"
             role="dialog"
             class="modal fade"
             aria-hidden="true"
             ref="success-modal"
             v-if="settingsSaved">
            <div role="document" class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="d-flex my-3 pl-4 pt-4">
                            <i class="display-4 fe fe-check-circle mr-3 mt-n2 mt-n3 text-success"></i>
                            <div>
                                <h3 class="mb-1">{{ trans('Fancy Settings saved') }}</h3>
                                <p class="line-height-normal text-black-50">
                                    {{ trans('Changes will be applied within 24 hours') }}
                                </p>
                            </div>
                        </div>
                        <div class="overflow-hidden rounded-bottom">
                            <a :href="successModal.url" class="btn btn-block btn-lg btn-success rounded-0">
                                {{ trans(successModal.text) }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueTimepicker from 'vue2-timepicker';

export default {
  props: {
    hasProfessionalRecording: {
      type: Boolean,
      default() {
        return false;
      }
    },
    settings: {
      type: Object,
      required: true
    },
    notificationPeriods: {
      type: Array,
      required: true
    },
    messages: {
      type: Object,
      required: true
    },
    allowUploadAudio: {
      type: Boolean,
      default: false
    },
    lang: {
      type: String,
      default: 'en'
    },
    urlAction: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      buyProfessionalRecording: false,
      settingsSaved: false,
      isProcessing: false,
      laddaButton: null,
      notification: {
        email: '',
        period: 'daily'
      },
      pbx: {
        business: null,
        business_text: ''
      },
      extensions: [],
      audioType: 'predefined',
      audioFile: null,
      successModal: {
        text: '',
        url: ''
      }
    };
  },
  components: {
    VueTimepicker
  },
  methods: {
    toggleHour(item) {
      if (item.enable) {
        return;
      }

      item.start = { HH: '', mm: '' };
      item.end = { HH: '', mm: '' };
    },
    copyHours(list, item) {
      if (item.enable === false || !item.start || !item.end) {
        return;
      }

      list.days.forEach(el => {
        if (el.id === item.id) {
          return false;
        }

        el.enable = true;
        el.start = item.start;
        el.end = item.end;
      });
    },
    addExtension() {
      const extension = {
        id: new Date().valueOf(),
        number: null,
        name: ''
      };

      this.extensions.push(extension);

      this.$nextTick(() => {
        this.$refs['extensions-table']
          .querySelector('tbody tr:last-child td:first-child input')
          .focus();
      });
    },
    deleteExtension(id) {
      const index = this.extensions.findIndex(el => el.id === id);
      this.extensions.splice(index, 1);
    },
    getSettingPayload() {
      const formData = new FormData();

      formData.append('notification_email', this.notification.email);
      formData.append('notification_period', this.notification.period);
      formData.append('audio_type', this.audioType);
      formData.append('audio_file', this.audioFile);

      // PBX
      if (this.pbx.business && this.pbx.business > 0) {
        formData.append('business_id', this.pbx.business);
      }

      if (this.pbx.business > 0 && this.pbx.business_text) {
        formData.append('business_text', this.pbx.business_text);
      }

      // Extensions
      if (this.extensions.length > 0) {
        formData.append(
          'extensions',
          JSON.stringify(this.extensions.filter(el => el.number && el.name))
        );
      }

      // Audio
      if (this.buyProfessionalRecording) {
        formData.append('audio_type', 'professional');
      }

      return formData;
    },
    setAudioFile(event) {
      // process your files, read as DataUrl or upload...
      console.log(event.target.files[0]);
      this.audioFile = event.target.files[0];
    },
    saveSetting() {
      if (this.isProcessing) {
        return false;
      }

      this.isProcessing = true;
      this.laddaButton.start();
    
      const data = this.getSettingPayload();
      console.log(data);
      
      axios
        .post(this.urlAction, data, {
          headers: { 'Content-Type': 'multipart/form-data' }
        })
        .then(response => {
          this.settingsSaved = true;
          this.laddaButton.stop();

          this.successModal = response.data;

          this.$nextTick(() => {
            $(this.$refs['success-modal']).modal({
              backdrop: 'static',
              keyboard: false
            });
          });
        })
        .catch(error => {
          console.error(error);

          this.isProcessing = false;
          this.laddaButton.stop();
        });
    }
  },
  created() {
    if (this.settings.notification) {
      this.notification = this.settings.notification;
    }

    if (this.settings.pbx) {
      this.pbx = this.settings.pbx;
    }

    if (this.settings.extensions) {
      this.extensions = this.settings.extensions;
    }

    if (this.settings.audio_type) {
      this.audioType = this.settings.audio_type;
    }
  },
  mounted() {
    this.laddaButton = Ladda.create(
      document.querySelector('#submit-fancy-setting')
    );
  }
};
</script>