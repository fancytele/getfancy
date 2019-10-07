<template>
  <span>{{ countdown }}</span>
</template>

<script>
import moment from 'moment';

export default {
  props: {
    endDate: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      countdown: ''
    };
  },
  methods: {
    countDownIsOver() {
      return (
        moment().format('h:mm:ss a') ===
        moment(this.endDate).format('h:mm:ss a')
      );
    },
    timerLoop() {
      this.countdown = moment().to(this.endDate, true);

      if (this.countDownIsOver()) {
        this.$emit('countdown-over', true);
        return true;
      }

      requestAnimationFrame(this.timerLoop);
    }
  },
  mounted() {
    this.timerLoop();
  }
};
</script>