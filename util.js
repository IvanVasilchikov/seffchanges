module.exports = {
  pagination(page, pages) {
    let result = [];
    if (pages < 5) {
      for (let i = 1; i <= pages; i += 1) {
        result.push(i);
      }
    } else if (page < 5) {
      for (let i = 1; i <= 5; i += 1) {
        result.push(i);
      }
      result.push('...');
      result.push(pages);
    } else if (page > pages - 4) {
      result = [1, '...'];
      for (let i = pages - 4; i <= pages; i += 1) {
        result.push(i);
      }
    } else if (page >= 5 && page <= pages - 4) {
      result = [1, '...'];
      for (let i = page - 1; i <= page + 1; i += 1) {
        result.push(i);
      }
      result.push('...');
      result.push(pages);
    }
    return result;
  },
  getByPath(obj, path) {
    var paths = path.split('.');
    var result = paths.reduce((summ, item) => {
      if (summ[item] == undefined) {
        summ = '-';
      } else {
        summ = summ[item];
      }
      return summ;
    }, summ = obj);
    return result;
  },
  loadAssets(file) {
    const fileInfo = file.split('/').pop().split('.');
    let result = '';
    if (fileInfo[1] === 'svg') {
      result = `/assets/sprite.svg#${fileInfo[0]}`;
    } else {
      result = `/assets/images/${fileInfo[0]}.${fileInfo[1]}`;
    }
    return result;
  },
};
