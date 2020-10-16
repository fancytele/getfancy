<template>
<div>
  <button type="submit"
          class="btn btn-lg btn-success ladda-button rounded-0 w-50"
          data-style="zoom-out">
    {{ trans('Link to Dashboard') }}
  </button>
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
  }
}
</script>

<style scoped>

</style>