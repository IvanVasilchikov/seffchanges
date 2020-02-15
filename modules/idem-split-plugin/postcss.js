/**
 * The PostCSS plugin component is supposed to extract the media CSS from the source chunks.
 * The CSS get saved in the store.
 */

const postcss = require('postcss');
const regex = /([\w+-]*)\: (\d+)/g;

module.exports = postcss.plugin('MediaQueryPostCSS', options => {
  const _opt = options;
  const keys = Object.keys(_opt);
  return (css, result) => {
    result.medias = {};
    css.walkAtRules('media', (atRule) => {
      // const str = arRule.params;
      const str = atRule.params;
      let m;
      let splitParams = {};
      while ((m = regex.exec(str)) !== null) {
          splitParams[m[1]] = m[2];
      }
      let currentFile = false;
      keys.some((key) => {
        if (splitParams['min-width'] && _opt[key] >= splitParams['min-width']) {
          if (splitParams['max-width'] && _opt[key] < splitParams['max-width']) {
              currentFile = key;
              return true;
          } else if (splitParams['max-width'] === undefined){
            currentFile = key;
            return true;
          }
        } else if (splitParams['max-width'] && _opt[key] < splitParams['max-width']) {
          currentFile = key;
          return true;
        }
      });
      if (currentFile) {
        if (result.medias[currentFile] === undefined) {
          result.medias[currentFile] = {splitParams, css: []};
        }
        result.medias[currentFile].css.push(atRule.toString());
        atRule.remove();
      }
    });
  };
});
