!function(t){function e(i){if(n[i])return n[i].exports;var s=n[i]={i:i,l:!1,exports:{}};return t[i].call(s.exports,s,s.exports,e),s.l=!0,s.exports}var n={};e.m=t,e.c=n,e.d=function(t,n,i){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:i})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="",e(e.s=0)}({0:function(t,e,n){n("sV/x"),t.exports=n("xZZD")},"21It":function(t,e,n){"use strict";var i=n("FtD3");t.exports=function(t,e,n){var s=n.config.validateStatus;n.status&&s&&!s(n.status)?e(i("Request failed with status code "+n.status,n.config,null,n.request,n)):t(n)}},"5VQ+":function(t,e,n){"use strict";var i=n("cGG2");t.exports=function(t,e){i.forEach(t,function(n,i){i!==e&&i.toUpperCase()===e.toUpperCase()&&(t[e]=n,delete t[i])})}},"7GwW":function(t,e,n){"use strict";var i=n("cGG2"),s=n("21It"),r=n("DQCr"),o=n("oJlt"),a=n("GHBc"),u=n("FtD3"),c="undefined"!=typeof window&&window.btoa&&window.btoa.bind(window)||n("thJu");t.exports=function(t){return new Promise(function(e,l){var f=t.data,d=t.headers;i.isFormData(f)&&delete d["Content-Type"];var h=new XMLHttpRequest,p="onreadystatechange",g=!1;if("undefined"==typeof window||!window.XDomainRequest||"withCredentials"in h||a(t.url)||(h=new window.XDomainRequest,p="onload",g=!0,h.onprogress=function(){},h.ontimeout=function(){}),t.auth){var m=t.auth.username||"",v=t.auth.password||"";d.Authorization="Basic "+c(m+":"+v)}if(h.open(t.method.toUpperCase(),r(t.url,t.params,t.paramsSerializer),!0),h.timeout=t.timeout,h[p]=function(){if(h&&(4===h.readyState||g)&&(0!==h.status||h.responseURL&&0===h.responseURL.indexOf("file:"))){var n="getAllResponseHeaders"in h?o(h.getAllResponseHeaders()):null,i=t.responseType&&"text"!==t.responseType?h.response:h.responseText,r={data:i,status:1223===h.status?204:h.status,statusText:1223===h.status?"No Content":h.statusText,headers:n,config:t,request:h};s(e,l,r),h=null}},h.onerror=function(){l(u("Network Error",t,null,h)),h=null},h.ontimeout=function(){l(u("timeout of "+t.timeout+"ms exceeded",t,"ECONNABORTED",h)),h=null},i.isStandardBrowserEnv()){var y=n("p1b6"),w=(t.withCredentials||a(t.url))&&t.xsrfCookieName?y.read(t.xsrfCookieName):void 0;w&&(d[t.xsrfHeaderName]=w)}if("setRequestHeader"in h&&i.forEach(d,function(t,e){void 0===f&&"content-type"===e.toLowerCase()?delete d[e]:h.setRequestHeader(e,t)}),t.withCredentials&&(h.withCredentials=!0),t.responseType)try{h.responseType=t.responseType}catch(e){if("json"!==t.responseType)throw e}"function"==typeof t.onDownloadProgress&&h.addEventListener("progress",t.onDownloadProgress),"function"==typeof t.onUploadProgress&&h.upload&&h.upload.addEventListener("progress",t.onUploadProgress),t.cancelToken&&t.cancelToken.promise.then(function(t){h&&(h.abort(),l(t),h=null)}),void 0===f&&(f=null),h.send(f)})}},DQCr:function(t,e,n){"use strict";function i(t){return encodeURIComponent(t).replace(/%40/gi,"@").replace(/%3A/gi,":").replace(/%24/g,"$").replace(/%2C/gi,",").replace(/%20/g,"+").replace(/%5B/gi,"[").replace(/%5D/gi,"]")}var s=n("cGG2");t.exports=function(t,e,n){if(!e)return t;var r;if(n)r=n(e);else if(s.isURLSearchParams(e))r=e.toString();else{var o=[];s.forEach(e,function(t,e){null!==t&&void 0!==t&&(s.isArray(t)&&(e+="[]"),s.isArray(t)||(t=[t]),s.forEach(t,function(t){s.isDate(t)?t=t.toISOString():s.isObject(t)&&(t=JSON.stringify(t)),o.push(i(e)+"="+i(t))}))}),r=o.join("&")}return r&&(t+=(-1===t.indexOf("?")?"?":"&")+r),t}},FtD3:function(t,e,n){"use strict";var i=n("t8qj");t.exports=function(t,e,n,s,r){var o=new Error(t);return i(o,e,n,s,r)}},GHBc:function(t,e,n){"use strict";var i=n("cGG2");t.exports=i.isStandardBrowserEnv()?function(){function t(t){var e=t;return n&&(s.setAttribute("href",e),e=s.href),s.setAttribute("href",e),{href:s.href,protocol:s.protocol?s.protocol.replace(/:$/,""):"",host:s.host,search:s.search?s.search.replace(/^\?/,""):"",hash:s.hash?s.hash.replace(/^#/,""):"",hostname:s.hostname,port:s.port,pathname:"/"===s.pathname.charAt(0)?s.pathname:"/"+s.pathname}}var e,n=/(msie|trident)/i.test(navigator.userAgent),s=document.createElement("a");return e=t(window.location.href),function(n){var s=i.isString(n)?t(n):n;return s.protocol===e.protocol&&s.host===e.host}}():function(){return function(){return!0}}()},"JP+z":function(t,e,n){"use strict";t.exports=function(t,e){return function(){for(var n=new Array(arguments.length),i=0;i<n.length;i++)n[i]=arguments[i];return t.apply(e,n)}}},KCLY:function(t,e,n){"use strict";(function(e){function i(t,e){!s.isUndefined(t)&&s.isUndefined(t["Content-Type"])&&(t["Content-Type"]=e)}var s=n("cGG2"),r=n("5VQ+"),o={"Content-Type":"application/x-www-form-urlencoded"},a={adapter:function(){var t;return"undefined"!=typeof XMLHttpRequest?t=n("7GwW"):void 0!==e&&(t=n("7GwW")),t}(),transformRequest:[function(t,e){return r(e,"Content-Type"),s.isFormData(t)||s.isArrayBuffer(t)||s.isBuffer(t)||s.isStream(t)||s.isFile(t)||s.isBlob(t)?t:s.isArrayBufferView(t)?t.buffer:s.isURLSearchParams(t)?(i(e,"application/x-www-form-urlencoded;charset=utf-8"),t.toString()):s.isObject(t)?(i(e,"application/json;charset=utf-8"),JSON.stringify(t)):t}],transformResponse:[function(t){if("string"==typeof t)try{t=JSON.parse(t)}catch(t){}return t}],timeout:0,xsrfCookieName:"XSRF-TOKEN",xsrfHeaderName:"X-XSRF-TOKEN",maxContentLength:-1,validateStatus:function(t){return t>=200&&t<300}};a.headers={common:{Accept:"application/json, text/plain, */*"}},s.forEach(["delete","get","head"],function(t){a.headers[t]={}}),s.forEach(["post","put","patch"],function(t){a.headers[t]=s.merge(o)}),t.exports=a}).call(e,n("W2nU"))},Re3r:function(t,e){function n(t){return!!t.constructor&&"function"==typeof t.constructor.isBuffer&&t.constructor.isBuffer(t)}function i(t){return"function"==typeof t.readFloatLE&&"function"==typeof t.slice&&n(t.slice(0,0))}t.exports=function(t){return null!=t&&(n(t)||i(t)||!!t._isBuffer)}},TNV1:function(t,e,n){"use strict";var i=n("cGG2");t.exports=function(t,e,n){return i.forEach(n,function(n){t=n(t,e)}),t}},Uigp:function(t,e){!function(t){"use strict";var e={slide:0,delay:5e3,loop:!0,preload:!1,preloadImage:!1,preloadVideo:!1,timer:!0,overlay:!1,autoplay:!0,shuffle:!1,cover:!0,color:null,align:"center",valign:"center",firstTransition:null,firstTransitionDuration:null,transition:"fade",transitionDuration:1e3,transitionRegister:[],animation:null,animationDuration:"auto",animationRegister:[],slidesToKeep:1,init:function(){},play:function(){},pause:function(){},walk:function(){},slides:[]},n={},i=function(n,i){this.elmt=n,this.settings=t.extend({},e,t.vegas.defaults,i),this.slide=this.settings.slide,this.total=this.settings.slides.length,this.noshow=this.total<2,this.paused=!this.settings.autoplay||this.noshow,this.ended=!1,this.$elmt=t(n),this.$timer=null,this.$overlay=null,this.$slide=null,this.timeout=null,this.first=!0,this.transitions=["fade","fade2","blur","blur2","flash","flash2","negative","negative2","burn","burn2","slideLeft","slideLeft2","slideRight","slideRight2","slideUp","slideUp2","slideDown","slideDown2","zoomIn","zoomIn2","zoomOut","zoomOut2","swirlLeft","swirlLeft2","swirlRight","swirlRight2"],this.animations=["kenburns","kenburnsLeft","kenburnsRight","kenburnsUp","kenburnsUpLeft","kenburnsUpRight","kenburnsDown","kenburnsDownLeft","kenburnsDownRight"],this.settings.transitionRegister instanceof Array==0&&(this.settings.transitionRegister=[this.settings.transitionRegister]),this.settings.animationRegister instanceof Array==0&&(this.settings.animationRegister=[this.settings.animationRegister]),this.transitions=this.transitions.concat(this.settings.transitionRegister),this.animations=this.animations.concat(this.settings.animationRegister),this.support={objectFit:"objectFit"in document.body.style,transition:"transition"in document.body.style||"WebkitTransition"in document.body.style,video:t.vegas.isVideoCompatible()},!0===this.settings.shuffle&&this.shuffle(),this._init()};i.prototype={_init:function(){var e,n,i,s="BODY"===this.elmt.tagName,r=this.settings.timer,o=this.settings.overlay,a=this;this._preload(),s||(this.$elmt.css("height",this.$elmt.css("height")),e=t('<div class="vegas-wrapper">').css("overflow",this.$elmt.css("overflow")).css("padding",this.$elmt.css("padding")),this.$elmt.css("padding")||e.css("padding-top",this.$elmt.css("padding-top")).css("padding-bottom",this.$elmt.css("padding-bottom")).css("padding-left",this.$elmt.css("padding-left")).css("padding-right",this.$elmt.css("padding-right")),this.$elmt.clone(!0).children().appendTo(e),this.elmt.innerHTML=""),r&&this.support.transition&&(i=t('<div class="vegas-timer"><div class="vegas-timer-progress">'),this.$timer=i,this.$elmt.prepend(i)),o&&(n=t('<div class="vegas-overlay">'),"string"==typeof o&&n.css("background-image","url("+o+")"),this.$overlay=n,this.$elmt.prepend(n)),this.$elmt.addClass("vegas-container"),s||this.$elmt.append(e),setTimeout(function(){a.trigger("init"),a._goto(a.slide),a.settings.autoplay&&a.trigger("play")},1)},_preload:function(){var t,e;for(e=0;e<this.settings.slides.length;e++)(this.settings.preload||this.settings.preloadImages)&&this.settings.slides[e].src&&(t=new Image,t.src=this.settings.slides[e].src),(this.settings.preload||this.settings.preloadVideos)&&this.support.video&&this.settings.slides[e].video&&(this.settings.slides[e].video instanceof Array?this._video(this.settings.slides[e].video):this._video(this.settings.slides[e].video.src))},_random:function(t){return t[Math.floor(Math.random()*t.length)]},_slideShow:function(){var t=this;this.total>1&&!this.ended&&!this.paused&&!this.noshow&&(this.timeout=setTimeout(function(){t.next()},this._options("delay")))},_timer:function(t){var e=this;clearTimeout(this.timeout),this.$timer&&(this.$timer.removeClass("vegas-timer-running").find("div").css("transition-duration","0ms"),this.ended||this.paused||this.noshow||t&&setTimeout(function(){e.$timer.addClass("vegas-timer-running").find("div").css("transition-duration",e._options("delay")-100+"ms")},100))},_video:function(t){var e,i,s=t.toString();return n[s]?n[s]:(t instanceof Array==0&&(t=[t]),e=document.createElement("video"),e.preload=!0,t.forEach(function(t){i=document.createElement("source"),i.src=t,e.appendChild(i)}),n[s]=e,e)},_fadeOutSound:function(t,e){var n=this,i=e/10,s=t.volume-.09;s>0?(t.volume=s,setTimeout(function(){n._fadeOutSound(t,e)},i)):t.pause()},_fadeInSound:function(t,e){var n=this,i=e/10,s=t.volume+.09;s<1&&(t.volume=s,setTimeout(function(){n._fadeInSound(t,e)},i))},_options:function(t,e){return void 0===e&&(e=this.slide),void 0!==this.settings.slides[e][t]?this.settings.slides[e][t]:this.settings[t]},_goto:function(e){function n(){m._timer(!0),setTimeout(function(){y&&(m.support.transition?(u.css("transition","all "+w+"ms").addClass("vegas-transition-"+y+"-out"),u.each(function(){var t=u.find("video").get(0);t&&(t.volume=1,m._fadeOutSound(t,w))}),i.css("transition","all "+w+"ms").addClass("vegas-transition-"+y+"-in")):i.fadeIn(w));for(var t=0;t<u.length-m.settings.slidesToKeep;t++)u.eq(t).remove();m.trigger("walk"),m._slideShow()},100)}void 0===this.settings.slides[e]&&(e=0),this.slide=e;var i,s,r,o,a,u=this.$elmt.children(".vegas-slide"),c=this.settings.slides[e].src,l=this.settings.slides[e].video,f=this._options("delay"),d=this._options("align"),h=this._options("valign"),p=this._options("cover"),g=this._options("color")||this.$elmt.css("background-color"),m=this,v=u.length,y=this._options("transition"),w=this._options("transitionDuration"),b=this._options("animation"),x=this._options("animationDuration");this.settings.firstTransition&&this.first&&(y=this.settings.firstTransition||y),this.settings.firstTransitionDuration&&this.first&&(w=this.settings.firstTransitionDuration||w),this.first&&(this.first=!1),"repeat"!==p&&(!0===p?p="cover":!1===p&&(p="contain")),("random"===y||y instanceof Array)&&(y=y instanceof Array?this._random(y):this._random(this.transitions)),("random"===b||b instanceof Array)&&(b=b instanceof Array?this._random(b):this._random(this.animations)),("auto"===w||w>f)&&(w=f),"auto"===x&&(x=f),i=t('<div class="vegas-slide"></div>'),this.support.transition&&y&&i.addClass("vegas-transition-"+y),this.support.video&&l?(o=l instanceof Array?this._video(l):this._video(l.src),o.loop=void 0===l.loop||l.loop,o.muted=void 0===l.mute||l.mute,!1===o.muted?(o.volume=0,this._fadeInSound(o,w)):o.pause(),r=t(o).addClass("vegas-video").css("background-color",g),this.support.objectFit?r.css("object-position",d+" "+h).css("object-fit",p).css("width","100%").css("height","100%"):"contain"===p&&r.css("width","100%").css("height","100%"),i.append(r)):(a=new Image,s=t('<div class="vegas-slide-inner"></div>').css("background-image",'url("'+c+'")').css("background-color",g).css("background-position",d+" "+h),"repeat"===p?s.css("background-repeat","repeat"):s.css("background-size",p),this.support.transition&&b&&s.addClass("vegas-animation-"+b).css("animation-duration",x+"ms"),i.append(s)),this.support.transition||i.css("display","none"),v?u.eq(v-1).after(i):this.$elmt.prepend(i),u.css("transition","all 0ms").each(function(){this.className="vegas-slide","VIDEO"===this.tagName&&(this.className+=" vegas-video"),y&&(this.className+=" vegas-transition-"+y,this.className+=" vegas-transition-"+y+"-in")}),m._timer(!1),o?(4===o.readyState&&(o.currentTime=0),o.play(),n()):(a.src=c,a.complete?n():a.onload=n)},_end:function(){this.ended=!0,this._timer(!1),this.trigger("end")},shuffle:function(){for(var t,e,n=this.total-1;n>0;n--)e=Math.floor(Math.random()*(n+1)),t=this.settings.slides[n],this.settings.slides[n]=this.settings.slides[e],this.settings.slides[e]=t},play:function(){this.paused&&(this.paused=!1,this.next(),this.trigger("play"))},pause:function(){this._timer(!1),this.paused=!0,this.trigger("pause")},toggle:function(){this.paused?this.play():this.pause()},playing:function(){return!this.paused&&!this.noshow},current:function(t){return t?{slide:this.slide,data:this.settings.slides[this.slide]}:this.slide},jump:function(t){t<0||t>this.total-1||t===this.slide||(this.slide=t,this._goto(this.slide))},next:function(){if(++this.slide>=this.total){if(!this.settings.loop)return this._end();this.slide=0}this._goto(this.slide)},previous:function(){if(--this.slide<0){if(!this.settings.loop)return void this.slide++;this.slide=this.total-1}this._goto(this.slide)},trigger:function(t){var e=[];e="init"===t?[this.settings]:[this.slide,this.settings.slides[this.slide]],this.$elmt.trigger("vegas"+t,e),"function"==typeof this.settings[t]&&this.settings[t].apply(this.$elmt,e)},options:function(n,i){var s=this.settings.slides.slice();if("object"==typeof n)this.settings=t.extend({},e,t.vegas.defaults,n);else{if("string"!=typeof n)return this.settings;if(void 0===i)return this.settings[n];this.settings[n]=i}this.settings.slides!==s&&(this.total=this.settings.slides.length,this.noshow=this.total<2,this._preload())},destroy:function(){clearTimeout(this.timeout),this.$elmt.removeClass("vegas-container"),this.$elmt.find("> .vegas-slide").remove(),this.$elmt.find("> .vegas-wrapper").clone(!0).children().appendTo(this.$elmt),this.$elmt.find("> .vegas-wrapper").remove(),this.settings.timer&&this.$timer.remove(),this.settings.overlay&&this.$overlay.remove(),this.elmt._vegas=null}},t.fn.vegas=function(t){var e,n=arguments,s=!1;if(void 0===t||"object"==typeof t)return this.each(function(){this._vegas||(this._vegas=new i(this,t))});if("string"==typeof t){if(this.each(function(){var i=this._vegas;if(!i)throw new Error("No Vegas applied to this element.");"function"==typeof i[t]&&"_"!==t[0]?e=i[t].apply(i,[].slice.call(n,1)):s=!0}),s)throw new Error('No method "'+t+'" in Vegas.');return void 0!==e?e:this}},t.vegas={},t.vegas.defaults=e,t.vegas.isVideoCompatible=function(){return!/(Android|webOS|Phone|iPad|iPod|BlackBerry|Windows Phone)/i.test(navigator.userAgent)}}(window.jQuery||window.Zepto)},W2nU:function(t,e){function n(){throw new Error("setTimeout has not been defined")}function i(){throw new Error("clearTimeout has not been defined")}function s(t){if(l===setTimeout)return setTimeout(t,0);if((l===n||!l)&&setTimeout)return l=setTimeout,setTimeout(t,0);try{return l(t,0)}catch(e){try{return l.call(null,t,0)}catch(e){return l.call(this,t,0)}}}function r(t){if(f===clearTimeout)return clearTimeout(t);if((f===i||!f)&&clearTimeout)return f=clearTimeout,clearTimeout(t);try{return f(t)}catch(e){try{return f.call(null,t)}catch(e){return f.call(this,t)}}}function o(){g&&h&&(g=!1,h.length?p=h.concat(p):m=-1,p.length&&a())}function a(){if(!g){var t=s(o);g=!0;for(var e=p.length;e;){for(h=p,p=[];++m<e;)h&&h[m].run();m=-1,e=p.length}h=null,g=!1,r(t)}}function u(t,e){this.fun=t,this.array=e}function c(){}var l,f,d=t.exports={};!function(){try{l="function"==typeof setTimeout?setTimeout:n}catch(t){l=n}try{f="function"==typeof clearTimeout?clearTimeout:i}catch(t){f=i}}();var h,p=[],g=!1,m=-1;d.nextTick=function(t){var e=new Array(arguments.length-1);if(arguments.length>1)for(var n=1;n<arguments.length;n++)e[n-1]=arguments[n];p.push(new u(t,e)),1!==p.length||g||s(a)},u.prototype.run=function(){this.fun.apply(null,this.array)},d.title="browser",d.browser=!0,d.env={},d.argv=[],d.version="",d.versions={},d.on=c,d.addListener=c,d.once=c,d.off=c,d.removeListener=c,d.removeAllListeners=c,d.emit=c,d.prependListener=c,d.prependOnceListener=c,d.listeners=function(t){return[]},d.binding=function(t){throw new Error("process.binding is not supported")},d.cwd=function(){return"/"},d.chdir=function(t){throw new Error("process.chdir is not supported")},d.umask=function(){return 0}},XmWM:function(t,e,n){"use strict";function i(t){this.defaults=t,this.interceptors={request:new o,response:new o}}var s=n("KCLY"),r=n("cGG2"),o=n("fuGk"),a=n("xLtR"),u=n("dIwP"),c=n("qRfI");i.prototype.request=function(t){"string"==typeof t&&(t=r.merge({url:arguments[0]},arguments[1])),t=r.merge(s,this.defaults,{method:"get"},t),t.method=t.method.toLowerCase(),t.baseURL&&!u(t.url)&&(t.url=c(t.baseURL,t.url));var e=[a,void 0],n=Promise.resolve(t);for(this.interceptors.request.forEach(function(t){e.unshift(t.fulfilled,t.rejected)}),this.interceptors.response.forEach(function(t){e.push(t.fulfilled,t.rejected)});e.length;)n=n.then(e.shift(),e.shift());return n},r.forEach(["delete","get","head","options"],function(t){i.prototype[t]=function(e,n){return this.request(r.merge(n||{},{method:t,url:e}))}}),r.forEach(["post","put","patch"],function(t){i.prototype[t]=function(e,n,i){return this.request(r.merge(i||{},{method:t,url:e,data:n}))}}),t.exports=i},cGG2:function(t,e,n){"use strict";function i(t){return"[object Array]"===R.call(t)}function s(t){return"[object ArrayBuffer]"===R.call(t)}function r(t){return"undefined"!=typeof FormData&&t instanceof FormData}function o(t){return"undefined"!=typeof ArrayBuffer&&ArrayBuffer.isView?ArrayBuffer.isView(t):t&&t.buffer&&t.buffer instanceof ArrayBuffer}function a(t){return"string"==typeof t}function u(t){return"number"==typeof t}function c(t){return void 0===t}function l(t){return null!==t&&"object"==typeof t}function f(t){return"[object Date]"===R.call(t)}function d(t){return"[object File]"===R.call(t)}function h(t){return"[object Blob]"===R.call(t)}function p(t){return"[object Function]"===R.call(t)}function g(t){return l(t)&&p(t.pipe)}function m(t){return"undefined"!=typeof URLSearchParams&&t instanceof URLSearchParams}function v(t){return t.replace(/^\s*/,"").replace(/\s*$/,"")}function y(){return("undefined"==typeof navigator||"ReactNative"!==navigator.product)&&("undefined"!=typeof window&&"undefined"!=typeof document)}function w(t,e){if(null!==t&&void 0!==t)if("object"==typeof t||i(t)||(t=[t]),i(t))for(var n=0,s=t.length;n<s;n++)e.call(null,t[n],n,t);else for(var r in t)Object.prototype.hasOwnProperty.call(t,r)&&e.call(null,t[r],r,t)}function b(){function t(t,n){"object"==typeof e[n]&&"object"==typeof t?e[n]=b(e[n],t):e[n]=t}for(var e={},n=0,i=arguments.length;n<i;n++)w(arguments[n],t);return e}function x(t,e,n){return w(e,function(e,i){t[i]=n&&"function"==typeof e?T(e,n):e}),t}var T=n("JP+z"),_=n("Re3r"),R=Object.prototype.toString;t.exports={isArray:i,isArrayBuffer:s,isBuffer:_,isFormData:r,isArrayBufferView:o,isString:a,isNumber:u,isObject:l,isUndefined:c,isDate:f,isFile:d,isBlob:h,isFunction:p,isStream:g,isURLSearchParams:m,isStandardBrowserEnv:y,forEach:w,merge:b,extend:x,trim:v}},cWxy:function(t,e,n){"use strict";function i(t){if("function"!=typeof t)throw new TypeError("executor must be a function.");var e;this.promise=new Promise(function(t){e=t});var n=this;t(function(t){n.reason||(n.reason=new s(t),e(n.reason))})}var s=n("dVOP");i.prototype.throwIfRequested=function(){if(this.reason)throw this.reason},i.source=function(){var t;return{token:new i(function(e){t=e}),cancel:t}},t.exports=i},dIwP:function(t,e,n){"use strict";t.exports=function(t){return/^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(t)}},dVOP:function(t,e,n){"use strict";function i(t){this.message=t}i.prototype.toString=function(){return"Cancel"+(this.message?": "+this.message:"")},i.prototype.__CANCEL__=!0,t.exports=i},fuGk:function(t,e,n){"use strict";function i(){this.handlers=[]}var s=n("cGG2");i.prototype.use=function(t,e){return this.handlers.push({fulfilled:t,rejected:e}),this.handlers.length-1},i.prototype.eject=function(t){this.handlers[t]&&(this.handlers[t]=null)},i.prototype.forEach=function(t){s.forEach(this.handlers,function(e){null!==e&&t(e)})},t.exports=i},mtWM:function(t,e,n){t.exports=n("tIFN")},oJlt:function(t,e,n){"use strict";var i=n("cGG2");t.exports=function(t){var e,n,s,r={};return t?(i.forEach(t.split("\n"),function(t){s=t.indexOf(":"),e=i.trim(t.substr(0,s)).toLowerCase(),n=i.trim(t.substr(s+1)),e&&(r[e]=r[e]?r[e]+", "+n:n)}),r):r}},p1b6:function(t,e,n){"use strict";var i=n("cGG2");t.exports=i.isStandardBrowserEnv()?function(){return{write:function(t,e,n,s,r,o){var a=[];a.push(t+"="+encodeURIComponent(e)),i.isNumber(n)&&a.push("expires="+new Date(n).toGMTString()),i.isString(s)&&a.push("path="+s),i.isString(r)&&a.push("domain="+r),!0===o&&a.push("secure"),document.cookie=a.join("; ")},read:function(t){var e=document.cookie.match(new RegExp("(^|;\\s*)("+t+")=([^;]*)"));return e?decodeURIComponent(e[3]):null},remove:function(t){this.write(t,"",Date.now()-864e5)}}}():function(){return{write:function(){},read:function(){return null},remove:function(){}}}()},pBtG:function(t,e,n){"use strict";t.exports=function(t){return!(!t||!t.__CANCEL__)}},pxG4:function(t,e,n){"use strict";t.exports=function(t){return function(e){return t.apply(null,e)}}},qRfI:function(t,e,n){"use strict";t.exports=function(t,e){return e?t.replace(/\/+$/,"")+"/"+e.replace(/^\/+/,""):t}},"sV/x":function(t,e,n){n("Uigp"),window.axios=n("mtWM"),window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";var i=document.head.querySelector('meta[name="csrf-token"]');i&&(window.axios.defaults.headers.common["X-CSRF-TOKEN"]=i.content),$(document).foundation();var s=$(".infinite-container");s.infiniteScroll({path:".invinite-btn",append:".infinite-item",history:!1,button:".invinite-btn",checkLastPage:".invinite-btn",scrollThreshold:!1}),s.on("load.infiniteScroll",function(t,e,n){var i=$(e).find(".invinite-btn").attr("href");i&&$(".invinite-btn").attr("href",i)}),$(".resep-img-field").on("change",function(){$(".resep-img").css("background-image","url("+window.URL.createObjectURL(this.files[0])+")")}),$("#user-navigation").on("change",function(){window.location.href=$(this).val()})},t8qj:function(t,e,n){"use strict";t.exports=function(t,e,n,i,s){return t.config=e,n&&(t.code=n),t.request=i,t.response=s,t}},tIFN:function(t,e,n){"use strict";function i(t){var e=new o(t),n=r(o.prototype.request,e);return s.extend(n,o.prototype,e),s.extend(n,e),n}var s=n("cGG2"),r=n("JP+z"),o=n("XmWM"),a=n("KCLY"),u=i(a);u.Axios=o,u.create=function(t){return i(s.merge(a,t))},u.Cancel=n("dVOP"),u.CancelToken=n("cWxy"),u.isCancel=n("pBtG"),u.all=function(t){return Promise.all(t)},u.spread=n("pxG4"),t.exports=u,t.exports.default=u},thJu:function(t,e,n){"use strict";function i(){this.message="String contains an invalid character"}function s(t){for(var e,n,s=String(t),o="",a=0,u=r;s.charAt(0|a)||(u="=",a%1);o+=u.charAt(63&e>>8-a%1*8)){if((n=s.charCodeAt(a+=.75))>255)throw new i;e=e<<8|n}return o}var r="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";i.prototype=new Error,i.prototype.code=5,i.prototype.name="InvalidCharacterError",t.exports=s},xLtR:function(t,e,n){"use strict";function i(t){t.cancelToken&&t.cancelToken.throwIfRequested()}var s=n("cGG2"),r=n("TNV1"),o=n("pBtG"),a=n("KCLY");t.exports=function(t){return i(t),t.headers=t.headers||{},t.data=r(t.data,t.headers,t.transformRequest),t.headers=s.merge(t.headers.common||{},t.headers[t.method]||{},t.headers||{}),s.forEach(["delete","get","head","post","put","patch","common"],function(e){delete t.headers[e]}),(t.adapter||a.adapter)(t).then(function(e){return i(t),e.data=r(e.data,e.headers,t.transformResponse),e},function(e){return o(e)||(i(t),e&&e.response&&(e.response.data=r(e.response.data,e.response.headers,t.transformResponse))),Promise.reject(e)})}},xZZD:function(t,e){}});