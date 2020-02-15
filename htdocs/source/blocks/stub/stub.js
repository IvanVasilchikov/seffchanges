import Vue from 'vue';
import cPicture from '../core/picture/picture';
require('./stub.scss');

const template = require('./stub.pug');

export default function (rootEl) {
  if (window.INIT && window.INIT.stubPage) {
    const app = new Vue(template({
      name: 'app',
      components: {
        cPicture
      },
      data() {
        return {
          info: window.INIT.stubPage,
          deadline: '',
          days: '',
          hours: '',
          minutes: '',
          seconds: '',
          countdownExpired: false,
        }
      },
      methods: {
        countdown() {
          setInterval(() => {
            const now = new Date().getTime();
            const time = this.deadline - now;
            this.days = Math.floor(time / (1000 * 60 * 60 * 24));
            this.hours = Math.floor((time % (1000 * 60 * 60 * 24))/(1000 * 60 * 60));
            this.minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));
            this.seconds = Math.floor((time % (1000 * 60)) / 1000);

            if (time < 0) {
              clearInterval(this.countdown);
              this.countdownExpired = true;
            }
          }, 1000);
        }
      },
      mounted() {
        this.deadline = new Date(this.info.deadline).getTime();
        this.countdown();
      },
    }));
    app.$mount(rootEl);
  }
};
