import popupEvent from '../../base/scripts/popupEvent';
import bodyFixed from '../../base/scripts/body-fixed';
import Vue from 'vue';
import headerFavorite from './favorite/header-favorite';
class Header {
  constructor(parent) {
    this.header = parent;
    if (this.header) {
      const favorite = this.header.querySelector('#favoriteBlock');
      if (favorite) {
        const app = new Vue(headerFavorite);
        app.$mount(favorite); 
      }
      this.header = parent;
      this.headerBtn = this.header.querySelector('.header__btn-menu');
      this.headerMenu = this.header.querySelector('.header__menu');
      this.dropdownItems = Array.from(this.header.querySelectorAll('.header__list-item--dropdown'));
      this.popupCallbackBtn = Array.from(this.header.querySelectorAll('.header__phone-replace'));
      if (this.headerBtn) this.initEvents();
      if (this.dropdownItems) this.initDropdowns();
    }
  }

  initEvents() {
    this.headerBtn.addEventListener('click', (event) => {
      event.preventDefault();
      this.header.classList.toggle('header--open');
      this.headerBtn.classList.toggle('header__btn-menu--open');

      if (this.headerBtn.classList.contains('header__btn-menu--open')) {
        bodyFixed.fixed(this.headerMenu);
      } else {
        bodyFixed.unFixed();
      }
    });

    this.checkScroll();

    window.addEventListener('scroll', () => {
      if (window.innerWidth > 1023) this.checkScroll();
    });

    this.popupCallbackBtn.forEach((btn) => {
      btn.addEventListener('click', () => popupEvent.open('form', 'callback'));
    })
  }

  initDropdowns() {
    this.dropdownItems.forEach((item) => {
      const link = item.querySelector('.header__list-link--dropdown');
      item.dropdown = item.querySelector('.header__dropdown');

      if (link) {
        link.addEventListener('click', (event) => {
          event.preventDefault();

          if (window.innerWidth <= 1279) {
            if (item.classList.contains('header__list-item--open')) {
              item.classList.remove('header__list-item--open');
              item.dropdown.removeAttribute('style');
            } else {
              this.dropdownItems.forEach((element) => {
                element.dropdown.removeAttribute('style');
                element.classList.remove('header__list-item--open');
              });

              item.classList.add('header__list-item--open');
              item.dropdown.style.maxHeight = `${item.dropdown.scrollHeight}px`;
            }
          }
        });
      }
    });
  }

  checkScroll() {
    const scroll = window.pageYOffset;
    if (scroll > this.header.offsetHeight) {
      this.header.classList.add('header--scroll');
    } else {
      this.header.classList.remove('header--scroll');
    }
  }
}
export default Header;
