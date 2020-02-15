import { TweenLite, Expo } from 'gsap';

const template = require('./animation-height.pug');

export default template({
  props: {
    duration: Number,
  },
  methods: {
    beforeEnter(el) {
      el.style.height = '0px';
      el.style.overflow = 'hidden';
    },
    enter(el, done) {
      TweenLite.to(el, this.duration, {
        ease: Expo.linear,
        height: el.children[0].offsetHeight,
        onComplete() {
          done();
          el.removeAttribute('style');
        },
      });
    },
    leave(el, done) {
      el.style.overflow = 'hidden';
      TweenLite.to(el, this.duration, {
        ease: Expo.linear,
        height: 0,
        onComplete() {
          done();
        },
      });
    },
    afterLeave(el) {
      el.style.overflow = null;
    },
  },
});
