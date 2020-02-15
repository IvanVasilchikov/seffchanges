module.exports = (source) => {
  const tmp = "@import '_function';\n@import '_vars';\n"+source
  return tmp;
};
