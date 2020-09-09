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
                           v-model="user.phone_number"
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
      <div class="text-right">
        <button type="submit"
                class="btn btn-primary btn btn-primary ladda-button"
                data-style="zoom-out">
          {{ trans('Submit') }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
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
    }
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
      errors: {
        first_name: null,
        last_name: null,
        email: null,
        phone_number: null,
        current_password: null,
        new_password: null,
        new_password_confirmation: null
      }
    }
  },

  methods:{

    getUserDetails()
    {
      axios.get(this.route)
            .then(response=>{
          console.log(response);
          this.user = response.data;

        })
            .catch(error => {
              console.log(error);
            });

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
        phone_number: this.user.phone_number,
        current_password: this.user.current_password,
        new_password: this.user.new_password,
        new_password_confirmation: this.user.new_password_confirmation,
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

  }
}


</script>

<style scoped>
.validation-error{
  color: red;
}
</style>