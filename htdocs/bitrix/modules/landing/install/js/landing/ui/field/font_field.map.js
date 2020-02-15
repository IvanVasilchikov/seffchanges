{"version":3,"sources":["font_field.js"],"names":["BX","namespace","isFunction","Landing","Utils","isPlainObject","bind","proxy","escapeHtml","addClass","clone","UI","Field","Font","data","BaseField","apply","this","arguments","layout","frame","items","keys","Object","map","key","name","value","onChangeHandler","onChange","onValueChangeHandler","onValueChange","content","input","innerHTML","element","document","querySelectorAll","selector","family","style","replace","split","onInputClick","makeFontClassName","toLowerCase","prototype","constructor","__proto__","event","preventDefault","stopPropagation","Panel","GoogleFonts","getInstance","show","then","font","response","forEach","fontItem","push","setValue","className","href","client","makeUrl","FontManager","Tool","addFont","category","window","postfix","property","removeUnusedFonts","headString","getUsedLoadedFonts","item","setAttribute","removeAttribute","outerHTML","CSSDeclaration","Backend","action"],"mappings":"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","file":"font_field.map.js"}