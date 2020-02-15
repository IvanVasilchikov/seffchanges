import { disableBodyScroll, enableBodyScroll, clearAllBodyScrollLocks } from 'body-scroll-lock';

//TODO: В тестовом режиме поставил плагин для фиксации
export default class bodyFixed {
  static fixed(el) {
    disableBodyScroll(el);
    // const height = -1 * window.pageYOffset;
    // document.body.style.top = `${height}px`;
    // document.body.classList.add('fixed');
  }
  static unFixed() {
    clearAllBodyScrollLocks(null);
    // const height = -1 * parseInt(document.body.style.top);
    // document.body.classList.remove('fixed');
    // document.body.style.top = null;
    // window.scrollTo(0, height);
  }
  static toggle() {
    if (document.body.style.overflow === 'hidden') {
      disableBodyScroll(null);
    } else {
      clearAllBodyScrollLocks(null);
    }
    // return document.body.classList.contains('fixed') ? BodyFixed.unFixed() : BodyFixed.fixed();
  };
};
