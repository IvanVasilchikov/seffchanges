import popupResponse from './response/popup-response';
import popupForm from './form/popup-form';
import popupContent from './content/popup-content';
import popupArea from './area/popup-area';
import popupObject from './object/popup-object';
import bodyFixed from '../../base/scripts/body-fixed';
import VueBus from '../../base/scripts/vue/v-bus';
import Vue from 'vue';
require('./popup.scss');

const template = require('./popup.pug');

export default function(targetEl) {
  const popup = new Vue(template({
    name: 'popup',
    data() {
      return {
        modal: null,
        info: null,
        className: null,
        wrapperClass: null,
      };
    },
    components: {
      popupResponse,
      popupForm,
      popupContent,
      popupArea,
      popupObject,
    },
    methods: {
      contentClickOver(event) {
        if (event) {
          const { target } = event;
          if(this.$refs.content && !this.$refs.content.contains(target)) {
            this.close();
          }
        }
      },
      openStatic(type, name, info, className, wrapperClass) {
        this.info = window.INIT.popups[type][name];
        if (info) this.info = Object.assign({}, this.info, info);
        if (this.info.initSelectData) {
          Object.keys(this.info.initSelectData).forEach((key) => {
            this.info.inputs.filter((el) => el.type === 'select').forEach((select) => {
              if (select.info.name === key) {
                select.info.values.forEach((option) => {
                  this.$set(option, 'selected', option.value === this.info.initSelectData[`${key}`]);
                });
              }
            });
          });
        }
        this.modal = `popup${type[0].toUpperCase() + type.slice(1)}`;
        this.className = className;
        this.wrapperClass = wrapperClass;
        this.$nextTick(bodyFixed.fixed(this.$refs.wrapper));
      },
      openAsync(name, info, className, wrapperClass) {
        this.info = null;
        this.info = Object.assign({}, this.info, info);
        if (!Object.keys(this.info).length) this.info = null;
        this.modal = `popup${name[0].toUpperCase() + name.slice(1)}`;
        this.className = className;
        if (wrapperClass) {
          this.wrapperClass = wrapperClass;
          this.$nextTick(() => {
            const area = this.$el.querySelector('.popup-area');
            if (area) bodyFixed.fixed(area);
          });
        } else this.$nextTick(bodyFixed.fixed(this.$refs.wrapper));
      },
      close() {
        this.modal = null;
        bodyFixed.unFixed();
        window.popup_object = undefined;
      },
    },
    mounted() {
      window.addEventListener('popupOpen', (event) => {
        const { detail } = event;
        if (detail.type === 'async') {
          this.openAsync(detail.name, detail.info, detail.className, detail.wrapperClass);
        } else {
          this.openStatic(detail.type, detail.name, detail.info, detail.className, detail.wrapperClass);
        }
      });
      window.addEventListener('popupClose', () => {
        this.close();
      });
      VueBus.$on('popupClose', () => {
        this.close();
      });
    },
  }));
  popup.$mount(targetEl);
}
