<template>
<div>
  <div class="row">
    <div class="col">
      <button @click="getDashboardLink"
              id="link-to-dashboard"
              class="btn btn-primary btn btn-primary ladda-button float-right"
              data-style="zoom-out"
      >
        <i class="fa fa-link" aria-hidden="true"></i> {{ trans('Link to Dashboard') }}
      </button>
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
                {{ trans('Oops!') }}
                <br>
                <span
                    class="element-name text-capitalize"></span>{{ trans('Something went wrong, Please try again later.') }}
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

</div>
</template>

<script>
export default {
name: "DidSettingComponent",
  props:{
    get_dashboard_link:{
      type:String,
      required: true
    }
  },
  mounted() {
    this.laddaButton = Ladda.create(
        document.querySelector('#link-to-dashboard')
    );
  },

  methods:{
    getDashboardLink(){
      this.laddaButton.start();
    axios.get(this.get_dashboard_link)
        .then(response=>{
          console.log(response.data.link);
          window.open(response.data.link , '_blank');
          this.laddaButton.stop();
        })
        .catch(error => {
          console.log(error.response);
          this.laddaButton.stop();
          $('#exampleModal').modal('show');
        });
    }
  }
}
</script>

<style scoped>

</style>