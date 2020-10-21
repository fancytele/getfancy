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
  data(){
  return{
    link:null
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
          console.log(response);
          window.open(response.data.link , '_blank');
          this.laddaButton.stop();
        })
        .catch(error => {
          console.log(error.response);
          this.laddaButton.stop();
        });
    }
  },
}
</script>

<style scoped>

</style>