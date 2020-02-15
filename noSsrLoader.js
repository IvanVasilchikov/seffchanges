module.exports = (source) => {
  const tmp = source.replace(/\/\/-nossr(.+?)nossr-\/\//gs, '$1');
  return tmp;
};
