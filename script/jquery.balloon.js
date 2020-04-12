!function(t){"use strict";function e(){this.initialize.apply(this,arguments)}function o(o,i,s){function a(t,e,o,i,n){var s=Math.round(i/1.7320508);e.inactive()["setBorder"+o.camel.pos.f](i)["setBorder"+o.camel.pos.c1](s)["setBorder"+o.camel.pos.c2](s)["set"+o.camel.pos.p1](o.isTopLeft?-i:t.inner[o.size.p])["set"+o.camel.pos.c1](t.inner[o.size.c]/tipPosition-s).active().$.css("border-"+o.pos.f+"-color",n)}i.stop(!0,!0);var r,l,p={position:"absolute",height:"0",width:"0",border:"solid 0 transparent"},c=new e(o),d=new e(i);if(d.setTop(-s.offsetY+(s.position&&s.position.indexOf("top")>=0?c.top-d.height:s.position&&s.position.indexOf("bottom")>=0?c.bottom:c.center.top-d.height/2)),d.setLeft(s.offsetX+(s.position&&s.position.indexOf("left")>=0?c.left-d.width:s.position&&s.position.indexOf("right")>=0?c.right:c.center.left-d.width/2)),s.tipSize>0){i.data("outerTip")&&(i.data("outerTip").remove(),i.removeData("outerTip")),i.data("innerTip")&&(i.data("innerTip").remove(),i.removeData("innerTip")),r=new e(t("<div>").css(p).appendTo(i)),l=new e(t("<div>").css(p).appendTo(i));for(var h,u=0;u<n.pos.length;u++){if(h=n.getRelativeNames(u),d.center[h.pos.c1]>=c[h.pos.c1]&&d.center[h.pos.c1]<=c[h.pos.c2])if(u%2===0){if(d[h.pos.o]>=c[h.pos.o]&&d[h.pos.f]>=c[h.pos.f])break}else if(d[h.pos.o]<=c[h.pos.o]&&d[h.pos.f]<=c[h.pos.f])break;h=null}h?(d["set"+h.camel.pos.p1](d[h.pos.p1]+(h.isTopLeft?1:-1)*(s.tipSize-d["border"+h.camel.pos.o])),a(d,r,h,s.tipSize,i.css("border-"+h.pos.o+"-color"),s.tipPosition),a(d,l,h,s.tipSize-2*d["border"+h.camel.pos.o],i.css("background-color"),s.tipPosition),i.data("outerTip",r.$).data("innerTip",l.$)):t.each([r.$,l.$],function(){this.remove()})}}function i(e,o){var i=e.data("balloon")&&e.data("balloon").get(0);return!(i&&(i===o.relatedTarget||t.contains(i,o.relatedTarget)))}var n={};n.pos=t.extend(["top","bottom","left","right"],{camel:["Top","Bottom","Left","Right"]}),n.size=t.extend(["height","width"],{camel:["Height","Width"]}),n.getRelativeNames=function(t){var e={pos:{o:t,f:t%2===0?t+1:t-1,p1:t%2===0?t:t-1,p2:t%2===0?t+1:t,c1:2>t?2:0,c2:2>t?3:1},size:{p:2>t?0:1,c:2>t?1:0}},o={};for(var i in e){o[i]||(o[i]={});for(var s in e[i])o[i][s]=n[i][e[i][s]],o.camel||(o.camel={}),o.camel[i]||(o.camel[i]={}),o.camel[i][s]=n[i].camel[e[i][s]]}return o.isTopLeft=o.pos.o===o.pos.p1,o},function(){function o(t,e){if(null==e)return o(t,!0),o(t,!1);var i=n.getRelativeNames(e?0:2);return t[i.size.p]=t.$["outer"+i.camel.size.p](),t[i.pos.f]=t[i.pos.o]+t[i.size.p],t.center[i.pos.o]=t[i.pos.o]+t[i.size.p]/2,t.inner[i.pos.o]=t[i.pos.o]+t["border"+i.camel.pos.o],t.inner[i.size.p]=t.$["inner"+i.camel.size.p](),t.inner[i.pos.f]=t.inner[i.pos.o]+t.inner[i.size.p],t.inner.center[i.pos.o]=t.inner[i.pos.f]+t.inner[i.size.p]/2,t}var i={setBorder:function(t,e){return function(i){return this.$.css("border-"+t.toLowerCase()+"-width",i+"px"),this["border"+t]=i,this.isActive?o(this,e):this}},setPosition:function(t,e){return function(i){return this.$.css(t.toLowerCase(),i+"px"),this[t.toLowerCase()]=i,this.isActive?o(this,e):this}}};e.prototype={initialize:function(e){this.$=e,t.extend(!0,this,this.$.offset(),{center:{},inner:{center:{}}});for(var o=0;o<n.pos.length;o++)this["border"+n.pos.camel[o]]=parseInt(this.$.css("border-"+n.pos[o]+"-width"))||0;this.active()},active:function(){return this.isActive=!0,o(this),this},inactive:function(){return this.isActive=!1,this}};for(var s=0;s<n.pos.length;s++)e.prototype["setBorder"+n.pos.camel[s]]=i.setBorder(n.pos.camel[s],2>s),s%2===0&&(e.prototype["set"+n.pos.camel[s]]=i.setPosition(n.pos.camel[s],2>s))}(),t.fn.balloon=function(e){return this.one("mouseenter",function o(n){var s=t(this),a=this,r=s.off("mouseenter",o).showBalloon(e).on("mouseenter",function(t){i(s,t)&&s.showBalloon()}).data("balloon");r&&r.on("mouseleave",function(e){a===e.relatedTarget||t.contains(a,e.relatedTarget)||s.hideBalloon()}).on("mouseenter",function(e){a===e.relatedTarget||t.contains(a,e.relatedTarget)||(r.stop(!0,!0),s.showBalloon())})}).on("mouseleave",function(e){var o=t(this);i(o,e)&&o.hideBalloon()})},t.fn.showBalloon=function(e){var i,n;return(e||!this.data("options"))&&(null===t.balloon.defaults.css&&(t.balloon.defaults.css={}),this.data("options",t.extend(!0,{},t.balloon.defaults,e||{}))),e=this.data("options"),this.each(function(){var s,a;i=t(this),s=!i.data("balloon"),n=i.data("balloon")||t("<div>"),(s||!n.data("active"))&&(n.data("active",!0),clearTimeout(i.data("minLifetime")),a=t.isFunction(e.contents)?e.contents.apply(this):e.contents||(e.contents=i.attr("title")||i.attr("alt")),n.append(a),(e.url||""!==n.html())&&(s||a===n.html()||n.empty().append(a),i.removeAttr("title"),e.url&&n.load(t.isFunction(e.url)?e.url(this):e.url,function(t,s,a){e.ajaxComplete&&e.ajaxComplete(t,s,a),o(i,n,e)}),s?(n.addClass(e.classname).css(e.css||{}).css({visibility:"hidden",position:"absolute"}).appendTo("body"),i.data("balloon",n),o(i,n,e),n.hide().css("visibility","visible")):o(i,n,e),i.data("delay",setTimeout(function(){e.showAnimation?e.showAnimation.apply(n.stop(!0,!0),[e.showDuration,function(){e.showComplete&&e.showComplete.apply(n)}]):n.show(e.showDuration,function(){this.style.removeAttribute&&this.style.removeAttribute("filter"),e.showComplete&&e.showComplete.apply(n)}),e.maxLifetime&&(clearTimeout(i.data("maxLifetime")),i.data("maxLifetime",setTimeout(function(){i.hideBalloon()},e.maxLifetime)))},e.delay))))})},t.fn.hideBalloon=function(){var e=this.data("options");return this.data("balloon")?this.each(function(){var o=t(this);clearTimeout(o.data("delay")),clearTimeout(o.data("minLifetime")),o.data("minLifetime",setTimeout(function(){var i=o.data("balloon");e.hideAnimation?e.hideAnimation.apply(i.stop(!0,!0),[e.hideDuration,function(o){t(this).data("active",!1),e.hideComplete&&e.hideComplete(o)}]):i.stop(!0,!0).hide(e.hideDuration,function(o){t(this).data("active",!1),e.hideComplete&&e.hideComplete(o)})},e.minLifetime))}):this},t.balloon={defaults:{contents:null,url:null,ajaxComplete:null,classname:null,position:"top",offsetX:0,offsetY:0,tipSize:12,tipPosition:2,delay:0,minLifetime:200,maxLifetime:0,showDuration:100,showAnimation:null,hideDuration:80,hideAnimation:function(t,e){this.fadeOut(t,e)},showComplete:null,hideComplete:null,css:{minWidth:"20px",padding:"5px",borderRadius:"6px",border:"solid 1px #777",boxShadow:"4px 4px 4px #555",color:"#666",backgroundColor:"#efefef",opacity:"0.85",zIndex:"32767",textAlign:"left"}}}}(jQuery);