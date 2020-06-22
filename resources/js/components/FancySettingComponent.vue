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
                                        <v-select class="text-capitalize" multiple v-model="notification.period" :options="notificationPeriods" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Language Options -->
            <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
              <div class="card-body">
                <div class="row">
                  <div class="col-xl-4">
                    <h2 class="mb-1">{{ trans('Language Options') }}</h2>
                    <p class="text-black-50">{{ trans('Language Options Message') }}</p>
                  </div>
                  <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
                    <div class="row">
                      <div class="col-lg-7">
                        <table class="border-bottom mb-2 table table-hover table-sm" ref="languages-table">
                          <thead>
                            <tr>
                              <th scope="col">{{ trans('Language') }}</th>
                              <th scope="col" class="w-25">{{ trans('Key') }}</th>
                              <th><span class="sr-only">Action</span></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr class="content-action-hover"
                                v-for="item in languages"
                                :key="item.id">
                              <td>
                                <label :for="'language_'+ item.id"
                                        class="sr-only">Language</label>
                                <input type="text"
                                       :id="'language_'+ item.id"
                                       class="form-control form-control-sm"
                                       min="1"
                                       v-model="item.language"/>
                              </td>
                              <td>
                                <label :for="'language_key'+ item.id"
                                        class="sr-only">Language Key</label>
                                <input type="number"
                                       :id="'language_key'+ item.id"
                                       class="form-control form-control-sm"
                                       v-model="item.key"/>
                              </td>
                              <td>
                                <button class="action btn btn-link btn-sm mt-n1 py-0 text-danger"
                                        title="Remove"
                                        @click="deleteLanguage(item.id)">
                                    <i class="fe fe-minus-circle h2"></i>
                                </button>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <button type="button" class="btn btn-link" @click="addLanguage()">
                            <i class="fe fe-plus"></i>
                            {{ trans('Add a new Language') }}
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Voice Menu Options -->
            <div class="border border-bottom-0 border-left-0 border-primary border-right-0 border-top border-top-2 card">
              <div class="card-body">
                <div class="row">
                  <div class="col-xl-4">
                    <h2 class="mb-1">{{ trans('Voice Menu Options') }}</h2>
                    <p class="text-black-50">{{ trans('Voice Menu Option Message') }}</p>
                  </div>
                  <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
                    <div class="row">
                      <div class="col-lg-7">
                        <table class="border-bottom mb-2 table table-hover table-sm" ref="voice-menus-table">
                          <thead>
                            <tr>
                              <th scope="col">{{ trans('Voice Menu') }}</th>
                              <th scope="col" class="w-25">{{ trans('Option') }}</th>
                              <th><span class="sr-only">Action</span></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr class="content-action-hover"
                                v-for="item in voiceMenus"
                                :key="item.id">
                              <td>
                                <label :for="'voice_menu_'+ item.id"
                                        class="sr-only">Voice Menu</label>
                                <input type="text"
                                       :id="'voice_menu_'+ item.id"
                                       class="form-control form-control-sm"
                                       min="1"
                                       v-model="item.menu"/>
                              </td>
                              <td>
                                <label :for="'voice_menu_option'+ item.id"
                                        class="sr-only">Option</label>
                                <input type="number"
                                       :id="'voice_menu_option'+ item.id"
                                       class="form-control form-control-sm"
                                       v-model="item.option"/>
                              </td>
                              <td>
                                <button class="action btn btn-link btn-sm mt-n1 py-0 text-danger"
                                        title="Remove"
                                        @click="deleteVoiceMenu(item.id)">
                                    <i class="fe fe-minus-circle h2"></i>
                                </button>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <button type="button" class="btn btn-link" @click="addVoiceMenu()">
                            <i class="fe fe-plus"></i>
                            {{ trans('Add a new Voice Option') }}
                        </button>
                      </div>
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
                            <h2 class="mb-1">{{ trans('Extension Settings') }}</h2>
                            <p class="text-black-50">{{ trans('Custom extensions description') }}.</p>
                        </div>
                        <div class="border-top border-top-2 border-xl-top-0 border-xl-left border-xl-left-2 col-xl-8 pt-4 pt-xl-0">
                            <div class="row">
                                <div class="col-lg-10">
                                    <table class="border-bottom mb-2 table table-hover table-sm">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ trans('Voice Menu') }}</th>
                                            <th scope="col" class="w-25">{{ trans('Option') }}</th>
                                            <th scope="col">{{ trans('Phone Numbers') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="item in voiceMenus"
                                            v-show="item.menu && item.option"
                                            :key="item.id">
                                          <td>
                                            {{ item.menu }}
                                          </td>
                                          <td>
                                            {{ item.option }}
                                          </td>
                                          <td>
                                            <ul v-show="item.phones.length > 0"
                                                class="list-unstyled mb-0">
                                              <li v-for="(phone, index) in item.phones"
                                                  :key="`${item.id}_phone_${index}`"
                                                  class="d-flex">
                                                  <input type="number"
                                                         :id="'voice_menu_option'+ item.id"
                                                         class="form-control form-control-sm"
                                                         v-model="item.phones[index]"/>
                                                  <button class="btn btn-link btn-sm mt-n1 py-0 text-danger"
                                                          title="Remove"
                                                          type="button"
                                                          @click.prevent="item.phones.splice(index, 1)">
                                                      <i class="fe fe-minus-circle h2"></i>
                                                  </button>
                                              </li>
                                            </ul>
                                            <button class="btn btn-link btn-sm pl-0" 
                                                    type="button"
                                                    @click="item.phones.push('')">
                                                <i class="fe fe-plus"></i>
                                                <small>{{ trans('Add Phone Number') }}</small>
                                            </button>
                                          </td>
                                        </tr>
                                        </tbody>
                                    </table>
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
                                          <label for="predefined_audio" class="custom-control-label">{{ trans('Default Recording') }}</label>
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
                                            <span class="form-text text-muted">$ {{ professionalRecordingPrice.toFixed(2) }} (will be charge immediately)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right">
              <button type="submit"
                      id="submit-fancy-setting"
                      class="btn btn-primary btn btn-primary ladda-button"
                      data-style="zoom-out">
                  {{ trans('Submit') }}
              </button>
            </div>
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
    professionalRecordingPrice: {
      type: Number,
      required: true
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
  components: {
    VueTimepicker
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
      languages: [],
      voiceMenus: [],
      audioType: 'predefined',
      audioFile: null,
      successModal: {
        text: '',
        url: ''
      }
    };
  },
  created() {
    if (this.settings.notification) {
      this.notification = this.settings.notification;
    }

    if (this.settings.languages) {
      this.languages = this.settings.languages;
    }

    if (this.settings.voice_menus) {
      this.voiceMenus = this.settings.voice_menus;
    }

    if (this.settings.audio_type) {
      this.audioType = this.settings.audio_type;
    }
  },
  mounted() {
    this.laddaButton = Ladda.create(
      document.querySelector('#submit-fancy-setting')
    );
  },
  methods: {
    addLanguage() {
      const language = {
        id: new Date().valueOf(),
        language: '',
        key: this.languages.length + 1
      };

      this.languages.push(language);

      this.$nextTick(() => {
        this.$refs['languages-table'].querySelector('tbody tr:last-child td:first-child input').focus();
      });
    },
    deleteLanguage(id) {
      const index = this.languages.findIndex(el => el.id === id);
      this.languages.splice(index, 1);
    },
    addVoiceMenu() {
      const voiceMenu = {
        id: new Date().valueOf(),
        menu: '',
        option: this.voiceMenus.length + 1,
        phones: []
      };

      this.voiceMenus.push(voiceMenu);

      this.$nextTick(() => {
        this.$refs['voice-menus-table'].querySelector('tbody tr:last-child td:first-child input').focus();
      });
    },
    deleteVoiceMenu(id) {
      const index = this.voiceMenus.findIndex(el => el.id === id);
      this.voiceMenus.splice(index, 1);
    },
    getSettingPayload() {
      const formData = new FormData();

      formData.append('notification_email', this.notification.email);
      formData.append('notification_period', this.notification.period);
      formData.append('audio_type', this.audioType);
      formData.append('audio_file', this.audioFile);

      // Languages
      if (this.languages.length > 0) {
        formData.append(
          'languages',
          JSON.stringify(this.languages.filter(el => el.language && el.key))
        );
      }

      // Voice Menus
      if (this.voiceMenus.length > 0) {
        formData.append(
          'voice_menus',
          JSON.stringify(this.voiceMenus.filter(el => el.menu && el.option))
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
  }
};
</script>