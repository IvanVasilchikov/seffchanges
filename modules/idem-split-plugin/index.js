const pluginName = 'IdemSplitPlugin';
const { RawSource, ConcatSource } = require('webpack-sources');
const plugin = require('./postcss');
const postcss = require('postcss');

module.exports = class IdemSplitPlugin {
  constructor(params) {
    this.options = params;
  }
	apply(compiler) {
		compiler.hooks.thisCompilation.tap(pluginName, (compilation) => {
			compilation.hooks.additionalAssets.tapAsync(pluginName, (cb) => {
				Promise.all(Object.keys(compilation.assets).filter((item) => {
					return /\.css/.test(item);
				}).map((item) => {
          return new Promise((resolve) => {
            postcss([ plugin(this.options) ]).process(compilation.assets[item].source()).then(result => {
              let mediaInclude = '';
              Object.keys(result.medias).forEach((media) => {
                const name = item.replace('.css',`-${media}.css`);
                compilation.assets[name] = new RawSource(result.medias[media].css.join("\n"));
                mediaInclude += `@import '${name.substr(1)}' screen and (min-width:${this.options[media]}px);\n`;
              });
              const name = item.replace('.css',`-mobile.css`);
              compilation.assets[name] = new RawSource(result.css);
              compilation.assets[item] = new RawSource(`@import '${name.substr(1)}';\n`+mediaInclude);
              resolve();
            });
          });
				})).then(() => {
				  cb();	
        });
			});
		});
	}
}
