!function(s){"use strict";function o(t,i,o){this.options={group:i},s.extend(this.options,p,o),this.$element=t instanceof s?t:s(t),this.uid=++a,this.setup(),i=this.$element.data(r),l[this.options.group]||(l[this.options.group]={}),(i=i||{})[this.options.group]||((i[(l[this.options.group][this.uid]=this).options.group]=this).$element.data(r,i),this.bind(),this.init())}var e=[13,32],n=["a","div","figure","p","pre","blockquote","img","ins","del","output","span","summary"],r="contentToggle",l={},t=s(document),h=navigator.userAgent.match(/iPad|iPhone/i),i=/[^a-z0-9_-]/gi,a=0,p={defaultState:null,globalClose:!1,independent:!1,noSelfClosing:!1,beforeCallback:null,stopPropagation:!0,triggerSelector:".js-contentToggle__trigger",triggerSelectorContext:!0,labelSelector:null,labelSelectorContext:!0,contentSelector:".js-contentToggle__content",contentSelectorContext:!0,elementClass:"is-open",triggerClass:"is-active",openedLabel:null,closedLabel:null,toggleProperties:["height"],toggleOptions:{duration:0}};o.prototype.setup=function(){this.setupDataOptions(),this.options.group&&(this.options.group=this.options.group.toString().replace(i,"")),"string"==typeof this.options.toggleProperties&&(this.options.toggleProperties=JSON.parse(this.options.toggleProperties)),"string"==typeof this.options.toggleOptions&&(this.options.toggleOptions=JSON.parse(this.options.toggleOptions)),this.options.triggerSelectorContext?this.$triggers=s(this.options.triggerSelector,this.$element):this.$triggers=s(this.options.triggerSelector),0===this.$triggers.length&&(this.$triggers=this.$element),this.options.labelSelector?this.options.labelSelectorContext?this.$labels=s(this.options.labelSelector,this.$element):this.$labels=s(this.options.labelSelector):this.$labels=this.$triggers,this.options.contentSelectorContext?this.$contents=s(this.options.contentSelector,this.$element):this.$contents=s(this.options.contentSelector),"string"==typeof this.options.beforeCallback&&window[this.options.beforeCallback]&&"function"==typeof window[this.options.beforeCallback]?this.options.beforeCallback=window[this.options.beforeCallback].bind(this):"function"==typeof this.options.beforeCallback&&(this.options.beforeCallback=this.options.beforeCallback.bind(this))},o.prototype.setupDataOptions=function(){s.each(this.$element.data(),function(t,i){t in p&&(this.options[t]=i)}.bind(this))},o.prototype.bind=function(){var t="."+r+"."+this.options.group,i=h&&this.options.globalClose?"touchstart":"click",o=this.$element.add(this.$triggers).add(this.$contents);o.on("destroy"+t,this.destroy.bind(this)),o.on("toggle"+t,s.proxy(this.toggle,this,null)),o.on("close"+t,s.proxy(this.toggle,this,!1)),o.on("open"+t,s.proxy(this.toggle,this,!0)),o.on("isOpen"+t,function(){return this.isOpen}.bind(this)),this.$triggers.on(i+t,function(t){t.preventDefault(),t.originalEvent.mozInputSource&&t.originalEvent.mozInputSource===MouseEvent.MOZ_SOURCE_KEYBOARD||this.toggle(null,t)}.bind(this)),this.$triggers.on("keydown"+t,function(t){-1!==s.inArray(t.keyCode,e)&&(t.preventDefault(),this.toggle(null,t))}.bind(this)),this.options.stopPropagation&&this.$contents.on(i+t,function(t){t.stopPropagation()})},o.prototype.init=function(){this.tid=[],this.$triggers.each(s.proxy(this.initId,this,this.tid,"contentToggle__trigger")),this.cid=[],this.$contents.each(s.proxy(this.initId,this,this.cid,"contentToggle__content")),this.$triggers.each(function(t,i){t=this.$triggers.eq(t);t.attr("role")||-1===s.inArray(i.tagName.toLowerCase(),n)||t.attr("role","button"),t.attr("tabindex")||t.attr("tabindex","0")}.bind(this)),this.$triggers.attr("aria-controls",this.cid.join(" ")),-1!==s.inArray(this.options.defaultState,["open","close"])?this.$element.trigger(this.options.defaultState+"."+r):(this.isOpen=this.$contents.is(":visible"),this.update())},o.prototype.initId=function(t,i,o,e){e=s(e);t[o]=e.attr("id"),t[o]||(t[o]=i+"-"+this.uid+"-"+o,e.attr("id",t[o]))},o.prototype.toggle=function(t,i){i.stopPropagation(),"boolean"!=typeof t&&(t=!this.isOpen),this.$currentTrigger=null,this.$triggers.is(i.currentTarget)&&(this.$currentTrigger=s(i.currentTarget)),(!this.options.beforeCallback||"function"==typeof this.options.beforeCallback&&this.options.beforeCallback(i))&&(t?this.open():this.options.noSelfClosing||this.close())},o.prototype.open=function(){!0!==this.isOpen&&(this.isOpen=!0,this.performToggle(),this.closeAll(!0),this.options.globalClose&&t.on((h?"touchstart":"click")+"."+r+this.uid,function(){this.closeAll()}.bind(this)))},o.prototype.close=function(){!1!==this.isOpen&&(this.isOpen=!1,this.performToggle(),t.off("."+r+this.uid))},o.prototype.closeAll=function(t){this.options.independent||s.each(l[this.options.group],function(t,i){Number(t)!==this.uid&&i.close()}.bind(this)),t||this.close()},o.prototype.performToggle=function(){var o={},e=this.isOpen?"show":"hide";this.update(),s.each(this.options.toggleProperties,function(t,i){o[i]=e}),this.$contents.stop().animate(o,this.options.toggleOptions)},o.prototype.update=function(){this.isOpen?(this.$element.addClass(this.options.elementClass),this.$contents.attr("aria-hidden",!1),this.$triggers.attr("aria-expanded",!0),(this.$currentTrigger||this.$triggers).addClass(this.options.triggerClass),"string"==typeof this.options.openedLabel&&this.$labels.html(this.options.openedLabel)):(this.$element.removeClass(this.options.elementClass),this.$contents.attr("aria-hidden",!0),this.$triggers.attr("aria-expanded",!1),this.$triggers.removeClass(this.options.triggerClass),"string"==typeof this.options.closedLabel&&this.$labels.html(this.options.closedLabel))},o.prototype.destroy=function(){this.$element.removeData(r),this.$element.off("."+r),this.$triggers.off("."+r),this.$contents.off("."+r),t.off("."+r+this.uid)},s.fn[r]=function(t){var i=this.selector;return this.each(function(){new o(this,i,t)})}}(jQuery);