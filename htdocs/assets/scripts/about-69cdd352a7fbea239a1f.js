!function(c){function t(t){for(var e,a,s=t[0],i=t[1],n=t[2],o=0,r=[];o<s.length;o++)a=s[o],Object.prototype.hasOwnProperty.call(l,a)&&l[a]&&r.push(l[a][0]),l[a]=0;for(e in i)Object.prototype.hasOwnProperty.call(i,e)&&(c[e]=i[e]);for(d&&d(t);r.length;)r.shift()();return _.push.apply(_,n||[]),u()}function u(){for(var t,e=0;e<_.length;e++){for(var a=_[e],s=!0,i=1;i<a.length;i++){var n=a[i];0!==l[n]&&(s=!1)}s&&(_.splice(e--,1),t=o(o.s=a[0]))}return t}var a={},l={1:0},_=[];function o(t){if(a[t])return a[t].exports;var e=a[t]={i:t,l:!1,exports:{}};return c[t].call(e.exports,e,e.exports,o),e.l=!0,e.exports}o.m=c,o.c=a,o.d=function(t,e,a){o.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:a})},o.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},o.t=function(e,t){if(1&t&&(e=o(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(o.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var s in e)o.d(a,s,function(t){return e[t]}.bind(null,s));return a},o.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return o.d(e,"a",e),e},o.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},o.p="/";var e=window.webpackJsonp=window.webpackJsonp||[],s=e.push.bind(e);e.push=t,e=e.slice();for(var i=0;i<e.length;i++)t(e[i]);var d=s;_.push([693,0]),u()}({564:function(t,e,a){},565:function(module,exports){module.exports=function(vueComponent){return Object.assign(vueComponent,{render:function anonymous(){with(this)return info?_c("div",{staticClass:"about-main"},[_c("c-picture",{attrs:{data:info.image,className:"about-main__background"}}),_c("div",{staticClass:"main about-main__container"},[_c("c-breadcrumbs",{attrs:{links:info.breadcrumbs,className:"about-main__breadcrumbs"}}),_c("div",{staticClass:"about-main__content"},[info.preTitle||info.title?_c("div",{staticClass:"about-main__titles"},[info.preTitle?_c("c-title-fourth",{attrs:{text:info.preTitle,className:"title-fourth--up about-main__pre-title"}}):_e(),info.title?_c("div",{staticClass:"about-main__title",domProps:{innerHTML:_s(info.title)}}):_e()],1):_e(),info.text?_c("div",{staticClass:"about-main__text"},_l(info.text,function(t){return _c("p",{domProps:{innerHTML:_s(t)}})}),0):_e(),info.info?_c("div",{staticClass:"about-main__info"},_l(info.info,function(t){return _c("div",{staticClass:"about-main__info-item"},[_c("div",{staticClass:"about-main__info-item-title",domProps:{innerHTML:_s(t.number)}}),_c("span",{domProps:{innerHTML:_s(t.text)}})])}),0):_e()])],1)],1):_e()},staticRenderFns:[]})}},570:function(t,e,a){},571:function(module,exports){module.exports=function(vueComponent){return Object.assign(vueComponent,{render:function anonymous(){with(this)return _c("div",{staticClass:"feature",class:[className]},[_c("div",{staticClass:"feature__number",domProps:{innerHTML:_s(info.number)}}),_c("c-title-fifth",{attrs:{text:info.title,className:"feature__title"}}),_c("c-text",{attrs:{text:info.text,className:"feature__text"}}),_c("button",{staticClass:"feature__button",attrs:{"data-popup":info.button.popup},domProps:{innerHTML:_s(info.button.text)}})],1)},staticRenderFns:[]})}},572:function(t,e,a){},573:function(module,exports){module.exports=function(vueComponent){return Object.assign(vueComponent,{render:function anonymous(){with(this)return info?_c("div",{staticClass:"about-features"},[_c("div",{staticClass:"main"},[_c("c-title",{attrs:{text:info.title,className:"about-features__title"}}),info.subtitle?_c("c-title-fifth",{attrs:{text:info.subtitle,className:"about-features__subtitle"}}):_e(),info.list?_c("div",{staticClass:"about-features__list"},_l(info.list,function(t){return _c("c-feature",{attrs:{info:t,className:"about-features__item"}})}),1):_e()],1)]):_e()},staticRenderFns:[]})}},580:function(t,e,a){},581:function(module,exports){module.exports=function(vueComponent){return Object.assign(vueComponent,{render:function anonymous(){with(this)return info?_c("div",{staticClass:"about-location"},[_c("div",{staticClass:"main about-location__container"},[_c("div",{staticClass:"about-location__content"},[_c("c-picture",{attrs:{data:info.image,className:"about-location__image",optimize:"lazyload"}}),_c("div",{staticClass:"about-location__content-wrp"},[_c("div",{staticClass:"about-location__text"},[_c("c-title-fourth",{attrs:{text:info.preTitle,className:"title-fourth--up about-location__pre-title"}}),_c("div",{staticClass:"about-location__title",domProps:{innerHTML:_s(info.title)}})],1),_c("c-btn",{attrs:{tag:info.link.url,text:info.link.text,className:"btn--white about-location__button"}})],1)],1),_c("div",{staticClass:"about-location__map-wrp"},[_c("c-map",{attrs:{info:info.map,className:"about-location__map"}})],1)])]):_e()},staticRenderFns:[]})}},586:function(t,e,a){},587:function(module,exports){module.exports=function(vueComponent){return Object.assign(vueComponent,{render:function anonymous(){with(this)return _c("div",{staticClass:"about-services"},[_c("div",{staticClass:"main"},[_c("div",{staticClass:"about-services__container"},[_c("c-title",{attrs:{text:info.title,className:"about-services__title"}}),_c("div",{staticClass:"about-services__subtitle",domProps:{innerHTML:_s(info.subtitle)}}),info.buttons?_c("div",{staticClass:"about-services__buttons-wrp"},[_c("c-tabs",{attrs:{btns:info.buttons,className:"about-services__buttons"},on:{changeTab:changeTab}})],1):_e()],1),info.tabs?_c("div",{staticClass:"about-services__tabs"},_l(info.tabs,function(t){return activeTab===t.name?_c("div",{staticClass:"about-services__tab"},_l(t.services,function(t){return _c("c-services-item",{attrs:{info:t,className:"about-services__item",isLazy:"lazy"}})}),1):_e()}),0):_e()])])},staticRenderFns:[]})}},588:function(t,e,a){},589:function(module,exports){module.exports=function(vueComponent){return Object.assign(vueComponent,{render:function anonymous(){with(this)return _c("div",{staticClass:"about-leadership"},[_c("svg",{staticClass:"about-leadership__bg"},[_c("use",{attrs:{"xlink:href":"/assets/sprite.svg#about-leadership"}})]),_c("div",{staticClass:"main"},[_c("c-title",{attrs:{text:info.title,className:"about-leadership__title"}}),_c("div",{staticClass:"about-leadership__slider swiper-container"},[_c("div",{staticClass:"swiper-wrapper"},_l(info.slides,function(t,e){return _c("div",{staticClass:"swiper-slide about-leadership__slide"},[_c("div",{staticClass:"about-leadership__content-wrp"},[_c("div",{staticClass:"about-leadership__content"},[t.quote?_c("div",{staticClass:"about-leadership__quote",domProps:{innerHTML:_s(t.quote)}}):_e(),_c("div",{staticClass:"about-leadership__info"},[_c("c-title-fourth",{attrs:{text:t.name,className:"title-fourth--up about-leadership__name"}}),_c("c-text",{attrs:{text:t.post,className:"about-leadership__post"}}),_c("c-text",{attrs:{text:t.description,className:"about-leadership__descr"}})],1)])]),_c("c-picture",{attrs:{data:t.image,className:"about-leadership__image",optimize:"lazyload"}})],1)}),0),1<info.slides.length?_c("div",{staticClass:"about-leadership__buttons"},[_c("div",{staticClass:"about-leadership__button about-leadership__button--prev",on:{click:function(t){return slider.slidePrev()}}},[_c("svg",[_c("use",{attrs:{"xlink:href":"/assets/sprite.svg#arrow-right"}})])]),_c("div",{staticClass:"about-leadership__button about-leadership__button--next",on:{click:function(t){return slider.slideNext()}}},[_c("svg",[_c("use",{attrs:{"xlink:href":"/assets/sprite.svg#arrow-right"}})])])]):_e()])],1)])},staticRenderFns:[]})}},590:function(t,e,a){},591:function(module,exports){module.exports=function(vueComponent){return Object.assign(vueComponent,{render:function anonymous(){with(this)return info?_c("div",{staticClass:"about-awards"},[_c("div",{staticClass:"main"},[_c("c-title",{attrs:{text:info.title,className:"about-awards__title"}}),_c("c-title-fourth",{attrs:{text:info.subtitle,className:"about-awards__subtitle"}}),_c("div",{staticClass:"about-awards__wrap"},[_c("c-tabs",{attrs:{btns:info.years,className:"about-awards__tabs"},on:{changeTab:changeTab}}),_l(info.sliders,function(t){return activeTab===t.year?_c("div",{staticClass:"about-awards__slider swiper-container"},[_c("div",{staticClass:"swiper-wrapper"},_l(t.list,function(t){return _c("div",{staticClass:"swiper-slide about-awards__slide"},[_c("c-picture",{attrs:{data:t.image,className:"about-awards__image",optimize:"lazyload"}}),_c("c-title-second",{attrs:{text:t.title,className:"about-awards__slide-title"}})],1)}),0),1<t.list.length?_c("div",{staticClass:"about-awards__nav"},[_c("div",{staticClass:"about-awards__btn about-awards__btn--prev",on:{click:function(t){return swiper.slidePrev()}}},[_c("svg",[_c("use",{attrs:{"xlink:href":"/assets/sprite.svg#arrow-right"}})])]),_c("div",{staticClass:"about-awards__count"},[_v(_s(currentSlide+" ")),_c("span",[_v("/ "+_s(t.list.length))])]),_c("div",{staticClass:"about-awards__btn",on:{click:function(t){return swiper.slideNext()}}},[_c("svg",[_c("use",{attrs:{"xlink:href":"/assets/sprite.svg#arrow-right"}})])])]):_e()]):_e()})],2)],1)]):_e()},staticRenderFns:[]})}},594:function(t,e,a){},595:function(module,exports){module.exports=function(vueComponent){return Object.assign(vueComponent,{render:function anonymous(){with(this)return info?_c("div",{staticClass:"about"},[_c("c-about-main",{attrs:{info:info.top}}),_c("c-about-features",{attrs:{info:info.features}}),_c("c-about-location",{attrs:{info:info.location}}),_c("c-about-services",{attrs:{info:info.services}}),_c("c-about-leadership",{attrs:{info:info.leadership}}),_c("c-about-awards",{attrs:{info:info.awards}}),_c("c-clients",{attrs:{obj:info.clients,className:"about__clients",itemClass:"about__clients-item"}})],1):_e()},staticRenderFns:[]})}},693:function(t,e,a){"use strict";a.r(e);var s=a(13),i=a(34),n=a(11),o=a(22);a(564);var r=a(565)({components:{cBreadcrumbs:i.a,cPicture:n.a,cTitleFourth:o.a},props:["info"]}),c=a(9),u=a(46),l=a(15);a(570);var _=a(571)({components:{cTitleFifth:u.a,cText:l.a},props:["info","className"]});a(572);var d=a(573)({components:{cTitle:c.a,cTitleFifth:u.a,cFeature:_},props:["info"]}),f=a(8),p=a(82);a(580);var b=a(581)({components:{cTitleFourth:o.a,cPicture:n.a,cMap:p.a,cBtn:f.a},props:["info"]}),m=a(55),v=a(142);a(586);var h=a(587)({components:{cTitle:c.a,cTabs:m.a,cServicesItem:v.a},data:function(){return{activeTab:this.info.buttons[0].value}},methods:{changeTab:function(t){this.activeTab=t}},props:["info"]}),C=a(26),w=a.n(C);a(588);var x=a(589)({components:{cTitle:c.a,cTitleFourth:o.a,cText:l.a,cPicture:n.a},mounted:function(){if(1<this.info.slides.length){var t=this.$el.querySelector(".about-leadership__slider");this.slider=new w.a(t,{slidesPerView:1,preloadImages:!1,autoHeight:!0,spaceBetween:30,lazy:{loadPrevNext:!0},loop:!0})}},props:["info"]}),g=a(39);a(590);var T=a(591)({components:{cTitle:c.a,cTitleFourth:o.a,cTitleSecond:g.a,cPicture:n.a,cTabs:m.a},data:function(){return{activeTab:this.info.sliders[0].year,currentSlide:1}},methods:{changeTab:function(t){var e=this;this.activeTab=t,this.$nextTick(function(){e.initSlider()})},initSlider:function(){var t=this,e=this.$el.querySelector(".about-awards__slider");1<e.querySelectorAll(".about-awards__slide").length&&(this.swiper=new w.a(e,{slidesPerView:1,preloadImages:!1,spaceBetween:30,lazy:{loadPrevNext:!0},loop:!0,on:{slideChange:function(){t.currentSlide=this.realIndex+1}}}))}},mounted:function(){this.initSlider()},props:["info"]}),y=a(143);a(594);var N=a(595);!function(t){window.INIT&&window.INIT.about&&new s.a(N({name:"app",components:{cAboutMain:r,cAboutFeatures:d,cAboutLocation:b,cAboutServices:h,cAboutLeadership:x,cAboutAwards:T,cClients:y.a},data:function(){return{info:window.INIT.about}}})).$mount(t)}(document.querySelector(".about"))}});