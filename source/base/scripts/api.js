import axios from 'axios';

export default class api {
  static post(url, data = {}) {
    if (window.BX !== undefined && window.BX.bitrix_sessid !== undefined) {
      data.sessid_id = window.BX.bitrix_sessid();
    }
    return axios.post(url, data);
  }

  static get(url, data = {}) {
    if (window.BX !== undefined && window.BX.bitrix_sessid !== undefined) {
      data.sessid_id = window.BX.bitrix_sessid();
    }
    return axios.get(url, {
      params: data,
    });
  }
}
