import popupEvent from '../../base/scripts/popupEvent';

export default class Footer {
  constructor(parent) {
    this.parent = parent;
    if (this.parent) {
      this.buttons = [].slice.call(this.parent.querySelectorAll('.footer__write'));

      if (this.buttons) {
        this.buttons.forEach((btn) => {
          btn.addEventListener('click', () => {popupEvent.open('form', 'writeUs_common')});
        });
      }
    }
  }
}
