<template>
  <div id="modal-vertical-right"
        class="fade fixed-right modal"
        tabindex="-1"
        role="dialog"
        aria-hidden="true">
    <div class="modal-dialog modal-dialog-vertical" 
          role="document">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close h1" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <div class="form-group mt-5">
            <label for="role">Select role</label>
            <select id="role" name="role" class="form-control" v-model="role" @change="initSearch()">
                <option value="user">User</option>
                <option value="agent">Agent</option>
                <option value="operator">Operator</option>
            </select>
          </div>
          <div class="form-group" v-show="users.length > 0">
            <p>Login as</p>
            <div class="list-group list-group-flush mb-4">
              <a class="list-group-item px-0" 
                  :href="impersonateUrl.replace('_user_', user.id)" 
                  v-for="user in users" :key="user.id"
                  @click="impersonate(user.id)">
                {{ user.first_name }} {{ user.last_name }}
              </a>
            </div>
            <button class="btn btn-block btn-sm btn-primary" @click="getUsersByRole()" v-show="!isLoading">Load more...</button>
          </div>
          <div class="text-center">
            <div class="align-middle mb-3 spinner-border text-primary"
                role="status"
                v-show="isLoading">
                <span class="sr-only">{{ trans('Loading') }}...</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['rolesUrl', 'impersonateUrl'],
  data() {
    return {
      isLoading: false,
      role: null,
      user: null,
      users: [],
      nextPage: null
    };
  },
  methods: {
    initSearch() {
      this.users = [];
      this.nextPage = null;
      this.getUsersByRole();
    },
    getUsersByRole() {
      if (this.isLoading) {
        return false;
      }

      this.isLoading = true;

      axios.get(this.formatedRolesUrl)
        .then((response) => {
          this.isLoading = false;
          this.nextPage = response.data.next_page_url;

          let data = [].concat(this.users, response.data.data);
          this.users = data;
        }).catch((error) => {
          console.errro(error);
          this.isLoading = false;
        });
    },
    impersonate(userId) {
      this.user = userId;
    }
  },
  computed: {
    formatedRolesUrl() {
      if (!this.role) {
        return '#';
      }
      
      if (this.nextPage) {
        return this.nextPage;
      }
      
      return this.rolesUrl.replace('_role_', this.role);
    }   
  }
};
</script>