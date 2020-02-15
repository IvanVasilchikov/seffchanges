import { TweenLite, Power1 } from 'gsap';

const template = require('./animation-fade.pug');

export default template({
  props: {
    duration: Number,
  },
  methods: {
    beforeEnter(el) {
      el.style.opacity = '0';
    },
    enter(el, done) {
      TweenLite.to(el, this.duration, {
        ease: Power1.easeInOut,
        opacity: 1,
        onComplete() {
          done();
        },
      });
    },
    leave(el, done) {
      el.style.opacity = '0';
      TweenLite.to(el, this.duration, {
        ease: Power1.easeInOut,
        position: 'absolute',
        opacity: 0,
        onComplete() {
          done();
        },
      });
    },
    afterLeave(el) {
      el.style.position = null;
      el.style.opacity = null;
    },
  },
});
