export default class popupEvent {
  static open(type, name, info, className) {
    const detail = {
      type,
      name,
      info
    };
    window.dispatchEvent(new window.CustomEvent('popupOpen', {
      detail
    }));
  }

  static openAsync(name, info, className, wrapperClass) {
    const detail = {
      type: 'async',
      name,
      info: (info && typeof info === 'object') ? info : {},
      className,
      wrapperClass
    };
    window.dispatchEvent(new window.CustomEvent('popupOpen', {
      detail
    }));
  }

  static close() {
    window.dispatchEvent(new window.CustomEvent('popupClose'));
  }
}
