export default class inputCheck {
  static required(value = '') {
    return value.length ? true : false;
  }

  static lengthString(value, min = 0, max = 0) {
    return [value.length >= min, value.length <= max];
  }

  static email(value) {
    const regularExpression = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regularExpression.test(String(value).toLowerCase());
  }
}