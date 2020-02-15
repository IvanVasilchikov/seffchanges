class Util {
  static send(url, type = 'GET', params) {
    let request = `${url}`;
    if (type === 'GET' && params !== undefined) {
      request += '?';
      if (params) {
        Object.keys(params).forEach((key) => {
          const value = encodeURIComponent(params[key]);
          request += `${key}=${value}&`;
        });
      }
    }
    const promise = new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.overrideMimeType('application/json; charset=utf-8');
      xhr.onreadystatechange = () => {
        if (xhr.readyState !== 4) return;
        if (xhr.status !== 200) {
          reject(xhr);
        }
        resolve(xhr.responseText);
      };
      xhr.withCredentials = true;
      xhr.open(type, request);
      xhr.setRequestHeader('Content-Type', 'application/json');
      if (type === 'POST') {
        xhr.send(JSON.stringify(params));
      } else {
        xhr.send();
      }
    });
    return promise;
  }

  static formData(form) {
    const tmp = {};
    [].slice.call(form.querySelectorAll('input,select,textarea')).forEach((input) => {
      const type = input.getAttribute('type');
      const key = input.getAttribute('name');
      if (type === 'radio') {
        if (input.checked === true) {
          tmp[key] = input.value;
        }
      } else if (type === 'checkbox') {
        if (input.checked === true) {
          if (tmp[key]) {
            tmp[key].push(input.value);
          } else {
            tmp[key] = [input.value];
          }
        }
      } else if (type === 'file') {
        tmp[key] = input.files[0];
      } else {
        tmp[key] = input.value;
      }
    });

    return tmp;
  }

  static parseJSONorNot(mayBeJSON) {
    let result = null;
    if (typeof mayBeJSON === 'string') {
      result = JSON.parse(mayBeJSON);
    } else {
      result = mayBeJSON;
    }
    return result;
  }
  static validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }
}

export default Util;
