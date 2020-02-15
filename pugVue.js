module.exports = {
  components: {},
  changeAttribute(el) {
    if (el.attrs) {
      el.attrs.forEach((item) => {
        if (item.name === 'class' && item.mustEscape === true) {
          const newVal = item.val;
          item.name = 'v-bind:class';
          item.val = `"[${newVal}]"`;
        } else if (item.name === 'style' && item.mustEscape === true) {
          item.name = 'v-bind:style';
          item.val = `"${item.val}"`;
        } else if (item.mustEscape === true && (item.val[0] !== "'" || item.val[item.val.length - 1] !== "'")) {
          if (item.val.indexOf('loadAssets') === -1) {
            item.name = `v-bind:${item.name}`;
            item.val = `"${item.val}"`;
          }
        }
      });
    }
  },
  postParse(value) {
    value.nodes.forEach((node) => {
      if (node.type === 'Mixin' && node.call === false) {
        this.components[node.name] = node.args === null ? [] : node.args.split(',').map(item => item.trim());
      }
    });
    return value;
  },
  preLex(value) {
    const tmp = value.replace(/\| <!--nossr(.*?)nossr-->/gm, '$1');
    return tmp;
  },
  preCodeGen(value, options) {
    const vElseIf = (element) => {
      let result = [];
      if (element.type === 'Conditional') {
        const ifEl = element.consequent.nodes[0];
        ifEl.attrs.push({
          mustEscape: false,
          name: 'v-else-if',
          val: `"${element.test}"`,
        });
        result.push(ifEl);
        const elseEl = vElseIf(element.alternate);
        result = result.concat(elseEl);
      } else {
        const elseEl = element.nodes[0];
        if (elseEl.type !== 'Text') {
          elseEl.attrs.push({
            mustEscape: false,
            name: 'v-else',
            val: "''",
          });
          result.push(elseEl);
        }
      }
      return result;
    };
    const rewriteLexemm = (root, parent) => {
      this.changeAttribute(root);
      let tmp = Object.assign({}, root);
      if (tmp.type && tmp.type === 'Conditional') {
        let ifEl = tmp.consequent.nodes[0];
        ifEl.parent = parent;
        ifEl = rewriteLexemm(ifEl, parent);
        ifEl.attrs.push({
          mustEscape: false,
          name: 'v-if',
          val: `"${root.test}"`,
        });
        const addElement = [ifEl];
        if (tmp.alternate) {
          const items = vElseIf(tmp.alternate);
          items.forEach((item) => {
            item = rewriteLexemm(item, parent);
            addElement.push(item);
          });
          // let elseEl = tmp.alternate.nodes[0];
          // if (elseEl.type !== 'Text') {
          //   elseEl.parent = parent;
          //   elseEl = rewriteLexemm(elseEl, parent);
          //   elseEl.attrs.push({
          //     mustEscape: false,
          //     name: 'v-else',
          //     val: "''",
          //   });
          //   addElement.push(elseEl);
          // }
        }
        tmp = addElement;
      } else if (root.type && root.type === 'Each') {
        let eachEl = root.block.nodes[0];
        eachEl.parent = parent;
        eachEl = rewriteLexemm(eachEl, parent);
        eachEl.attrs.push({
          mustEscape: false,
          name: 'v-for',
          val: (root.key == null) ? `"${root.val} in ${root.obj}"` : `"(${root.val}, ${root.key}) in ${root.obj}"`,
        });
        tmp = eachEl;
      } else if (root.type && root.type === 'Mixin' && root.call === false) {
        tmp.block = rewriteLexemm(tmp.block, root);
        tmp = [tmp, {
          type: tmp.type,
          name: tmp.name,
          args: tmp.args,
          block: null,
          call: true,
          attrs: [],
          attributeBlocks: [],
        }];
      } else if (root.type && root.type === 'Mixin' && root.call === true) {
        let values = [];
        if (Object.keys(this.components[tmp.name]).length > 1) {
          values = tmp.args.split(',').map(item => item.trim());
        } else {
          values.push(tmp.args.replace(new RegExp('\\n', 'g'), ''));
        }
        let attrs = [];
        tmp.attrs.forEach((attr) => {
          if (attr.name.indexOf('v-bind') === -1) {
            attrs.push(attr);
          }
        });
        if (this.components[tmp.name].length > 0) {
          attrs = attrs.concat(values.map((item, key) => {
            const data = {
              mustEscape: false,
              name: `v-bind:${this.components[tmp.name][key]}`,
              val: `"${item}"`,
            };
            return data;
          }));
        }
        tmp = {
          type: 'Tag',
          name: `c-${tmp.name}`,
          attributeBlocks: [],
          attrs,
          selfClosing: (tmp.block === null),
          isInline: true,
          block: (tmp.block === null) ? null : Object.assign({}, tmp.block),
        };
        tmp = rewriteLexemm(tmp, null);
      } else if (root.type && root.type === 'MixinBlock') {
        tmp = {
          type: 'Tag',
          name: 'slot',
          attributeBlocks: [],
          attrs: [],
          selfClosing: false,
          isInline: true,
          block: {
            type: 'Block',
            nodes: [],
          },
        };
      } else if (root.type && root.type === 'Code' && parent.type !== 'Block') {
        if (root.val.indexOf('var') === -1) {
          if (root.mustEscape) {
            tmp.val = `"{{${root.val}}}"`;
          } else {
            parent.attrs.push({
              mustEscape: false,
              name: 'v-html',
              val: `"${tmp.val}"`,
            });
            tmp.val = '""';
          }
        } else {
          tmp.val = '""';
        }
      } else if (root.type && root.type === 'Code' && parent.type === 'Block') {
        tmp.val = '""';
      } else if (tmp.nodes) {
        let resultNodes = [];
        root.parent = parent;
        tmp.nodes.forEach((item) => {
          if (item.filename !== undefined && item.filename !== options.filename) {
            resultNodes = resultNodes.concat(item);
          } else {
            const res = rewriteLexemm(item, root);
            if (res != null) {
              resultNodes = resultNodes.concat(res);
            }
          }
        });
        tmp.nodes = resultNodes;
      } else if (tmp.block) {
        let resultNodes = [];
        root.parent = parent;
        tmp.block.nodes.forEach((item) => {
          if (item.filename !== undefined && item.filename !== options.filename) {
            resultNodes = resultNodes.concat(item);
          } else {
            const res = rewriteLexemm(item, root);
            if (res != null) {
              resultNodes = resultNodes.concat(res);
            }
          }
        });
        tmp.block.nodes = resultNodes;
      }
      return tmp;
    };
    const tmp = rewriteLexemm(value, null);
    return tmp;
  },
};
