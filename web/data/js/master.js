function initTinyMCE(e){"undefined"==typeof e&&(e=stfalcon_tinymce_config),function(t,n){t(function(){var n=t("textarea");e.selector&&(n=t("textarea"+e.selector)),n.each(function(){var n=t(this),i=n.attr("data-theme")||"simple",r="undefined"!=typeof e.theme[i]?e.theme[i]:e.theme.simple;r.script_url=e.jquery_script_url,r.external_plugins=r.external_plugins||{},n.is("[required]")&&n.prop("required",!1),r.setup=function(n){t.each(e.tinymce_buttons||{},function(e,i){i=t.extend({},i,{onclick:function(){var t=window["tinymce_button_"+e];"function"==typeof t?t(n):alert('You have to create callback function: "tinymce_button_'+e+'"')}}),n.addButton(e,i)}),t.each(e.external_plugins||{},function(e,t){var n=t.url||null;n&&(r.external_plugins[e]=n,tinymce.PluginManager.load(e,n))}),e.use_callback_tinymce_init&&n.on("init",function(){var e=window.callback_tinymce_init;"function"==typeof e?e(n):alert("You have to create callback function: callback_tinymce_init")})},n.tinymce(r)})})}(jQuery)}function initTinyMCE(e){return"undefined"!=typeof tinymce&&("undefined"==typeof e&&(e=stfalcon_tinymce_config),void domready(function(){var t,n=tinymce.editors,i=[];for(t in n)n.hasOwnProperty(t)&&n[t].remove();switch(e.selector.substring(0,1)){case"#":var r=document.getElementById(e.selector.substring(1));r&&i.push(r);break;case".":i=getElementsByClassName(e.selector.substring(1),"textarea");break;default:i=document.getElementsByTagName("textarea")}if(!i.length)return!1;var o=[];if("object"==typeof e.external_plugins)for(var a in e.external_plugins)if(e.external_plugins.hasOwnProperty(a)){var c=e.external_plugins[a],s=c.url||null;s&&(o.push({id:a,url:s}),tinymce.PluginManager.load(a,s))}for(t=0;t<i.length;t++){var u=i[t].getAttribute("data-theme")||"simple",f="undefined"!=typeof e.theme[u]?e.theme[u]:e.theme.simple;f.external_plugins=f.external_plugins||{};for(var l=0;l<o.length;l++)f.external_plugins[o[l].id]=o[l].url;""!==i[t].getAttribute("required")&&i[t].removeAttribute("required");var p=i[t].getAttribute("id");""!==p&&null!==p||i[t].setAttribute("id","tinymce_"+Math.random().toString(36).substr(2)),"object"==typeof e.tinymce_buttons&&(f.setup=function(t){for(var n in e.tinymce_buttons)e.tinymce_buttons.hasOwnProperty(n)&&!function(e,n){n.onclick=function(){var n=window["tinymce_button_"+e];"function"==typeof n?n(t):alert('You have to create callback function: "tinymce_button_'+e+'"')},t.addButton(e,n)}(n,clone(e.tinymce_buttons[n]));e.use_callback_tinymce_init&&t.on("init",function(){var e=window.callback_tinymce_init;"function"==typeof e?e(t):alert("You have to create callback function: callback_tinymce_init")})}),tinymce.createEditor(i[t].getAttribute("id"),f).render()}}))}function getElementsByClassName(e,t){for(var n=document.getElementsByTagName(t),i=[],r=new RegExp("\\b"+e+"\\b"),o=0,a=n.length;o<a;o++)r.test(n[o].className)&&i.push(n[o]);return i}function clone(e){if(!e||"object"!=typeof e)return e;var t,n,i="function"==typeof e.pop?[]:{};for(t in e)e.hasOwnProperty(t)&&(n=e[t],n&&"object"==typeof n?i[t]=clone(n):i[t]=n);return i}var AppMain=function(){this.params={imagecurrent:$("#head #imagecurrent img"),success:$("#seccess")},this.create=function(){}},AppMain=function(){this.params={imagecurrent:$("#head #imagecurrent img"),success:$("#seccess")},this.create=function(){}};!function(){function e(e,t){var n=e.split("."),i=u;!(n[0]in i)&&i.execScript&&i.execScript("var "+n[0]);for(var r;n.length&&(r=n.shift());)n.length||void 0===t?i=i[r]?i[r]:i[r]={}:i[r]=t}function t(e,i){this.c={},this.a=[];var r=arguments.length;if(1<r){if(r%2)throw Error("Uneven number of arguments");for(var o=0;o<r;o+=2)this.set(arguments[o],arguments[o+1])}else if(e){var a;if(e instanceof t)for(n(e),o=e.a.concat(),n(e),a=[],r=0;r<e.a.length;r++)a.push(e.c[e.a[r]]);else{var r=[],c=0;for(o in e)r[c++]=o;o=r,r=[],c=0;for(a in e)r[c++]=e[a];a=r}for(r=0;r<o.length;r++)this.set(o[r],a[r])}}function n(e){if(e.f!=e.a.length){for(var t=0,n=0;t<e.a.length;){var r=e.a[t];i(e.c,r)&&(e.a[n++]=r),t++}e.a.length=n}if(e.f!=e.a.length){for(var o={},n=t=0;t<e.a.length;)r=e.a[t],i(o,r)||(e.a[n++]=r,o[r]=1),t++;e.a.length=n}}function i(e,t){return Object.prototype.hasOwnProperty.call(e,t)}function r(){return u.navigator?u.navigator.userAgent:null}function o(e,t){this.b=e||{e:"",prefix:"",host:"",scheme:""},this.h(t||{})}function a(e,t,n,i){var r,o=RegExp(/\[\]$/);if(n instanceof Array)l(n,function(n,r){o.test(t)?i(t,n):a(e,t+"["+("object"==typeof n?r:"")+"]",n,i)});else if("object"==typeof n)for(r in n)a(e,t+"["+r+"]",n[r],i);else i(t,n)}var c,s=!1,u=this,f=Array.prototype,l=f.forEach?function(e,t,n){f.forEach.call(e,t,n)}:function(e,t,n){for(var i=e.length,r="string"==typeof e?e.split(""):e,o=0;o<i;o++)o in r&&t.call(n,r[o],o,e)};t.prototype.f=0,t.prototype.p=0,t.prototype.get=function(e,t){return i(this.c,e)?this.c[e]:t},t.prototype.set=function(e,t){i(this.c,e)||(this.f++,this.a.push(e),this.p++),this.c[e]=t};var p,h,m,d;d=m=h=p=s;var y;if(y=r()){var g=u.navigator;p=0==y.indexOf("Opera"),h=!p&&-1!=y.indexOf("MSIE"),m=!p&&-1!=y.indexOf("WebKit"),d=!p&&!m&&"Gecko"==g.product}var v,b=h,_=d,x=m;if(p&&u.opera){var w=u.opera.version;"function"==typeof w&&w()}else _?v=/rv\:([^\);]+)(\)|;)/:b?v=/MSIE\s+([^\);]+)(\)|;)/:x&&(v=/WebKit\/(\S+)/),v&&v.exec(r());o.g=function(){return o.j?o.j:o.j=new o},c=o.prototype,c.h=function(e){this.d=new t(e)},c.o=function(){return this.d},c.k=function(e){this.b.e=e},c.n=function(){return this.b.e},c.l=function(e){this.b.prefix=e},c.i=function(e){var t=this.b.prefix+e;if(i(this.d.c,t))e=t;else if(!i(this.d.c,e))throw Error('The route "'+e+'" does not exist.');return this.d.get(e)},c.m=function(e,t,n){var i,r=this.i(e),o=t||{},c={};for(i in o)c[i]=o[i];var u="",f=!0,p="";l(r.tokens,function(t){if("text"===t[0])u=t[1]+u,f=s;else{if("variable"!==t[0])throw Error('The token type "'+t[0]+'" is not supported.');var n=t[3]in r.defaults;if(s===f||!n||t[3]in o&&o[t[3]]!=r.defaults[t[3]]){if(t[3]in o){var n=o[t[3]],i=t[3];i in c&&delete c[i]}else{if(!n){if(f)return;throw Error('The route "'+e+'" requires the parameter "'+t[3]+'".')}n=r.defaults[t[3]]}(!0!==n&&s!==n&&""!==n||!f)&&(i=encodeURIComponent(n).replace(/%2F/g,"/"),"null"===i&&null===n&&(i=""),u=t[1]+i+u),f=s}else n&&(t=t[3],t in c&&delete c[t])}}),""===u&&(u="/"),l(r.hosttokens,function(e){var t;if("text"===e[0])p=e[1]+p;else if("variable"===e[0]){if(e[3]in o){t=o[e[3]];var n=e[3];n in c&&delete c[n]}else e[3]in r.defaults&&(t=r.defaults[e[3]]);p=e[1]+t+p}}),u=this.b.e+u,"_scheme"in r.requirements&&this.b.scheme!=r.requirements._scheme?u=r.requirements._scheme+"://"+(p||this.b.host)+u:p&&this.b.host!==p?u=this.b.scheme+"://"+p+u:!0===n&&(u=this.b.scheme+"://"+this.b.host+u);var h,t=0;for(h in c)t++;if(0<t){var m,d=[];h=function(e,t){t="function"==typeof t?t():t,d.push(encodeURIComponent(e)+"="+encodeURIComponent(null===t?"":t))};for(m in c)a(this,m,c[m],h);u=u+"?"+d.join("&").replace(/%20/g,"+")}return u},e("fos.Router",o),e("fos.Router.setData",function(e){var t=o.g();t.k(e.base_url),t.h(e.routes),"prefix"in e&&t.l(e.prefix),t.b.host=e.host,t.b.scheme=e.scheme}),o.getInstance=o.g,o.prototype.setRoutes=o.prototype.h,o.prototype.getRoutes=o.prototype.o,o.prototype.setBaseUrl=o.prototype.k,o.prototype.getBaseUrl=o.prototype.n,o.prototype.generate=o.prototype.m,o.prototype.setPrefix=o.prototype.l,o.prototype.getRoute=o.prototype.i,window.Routing=o.g()}(),!function(e,t){"undefined"!=typeof module?module.exports=t():"function"==typeof define&&"object"==typeof define.amd?define(t):this[e]=t()}("domready",function(e){function t(e){for(p=1;e=i.shift();)e()}var n,i=[],r=!1,o=document,a=o.documentElement,c=a.doScroll,s="DOMContentLoaded",u="addEventListener",f="onreadystatechange",l="readyState",p=/^loade|c/.test(o[l]);return o[u]&&o[u](s,n=function(){o.removeEventListener(s,n,r),t()},r),c&&o.attachEvent(f,n=function(){/^c/.test(o[l])&&(o.detachEvent(f,n),t())}),e=c?function(t){self!=top?p?t():i.push(t):function(){try{a.doScroll("left")}catch(n){return setTimeout(function(){e(t)},50)}t()}()}:function(e){p?e():i.push(e)}});var AppMain=function(){this.params={imagecurrent:$("#head #imagecurrent img"),success:$("#seccess")},this.create=function(){}};
//# sourceMappingURL=master.js.map