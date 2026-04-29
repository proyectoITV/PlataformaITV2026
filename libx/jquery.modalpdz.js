/*  My.MyModal by JPedraza PrymeCode */

! function(o) {
    "object" == typeof module && "object" == typeof module.exports ? o(require("jquery"), window, document) : o(jQuery, window, document)
}(function(o, t, i, e) {
    var s = [],
        l = function() {
            return s.length ? s[s.length - 1] : null
        },
        n = function() {
            var o, t = !1;
            for (o = s.length - 1; o >= 0; o--) s[o].$blocker && (s[o].$blocker.toggleClass("current", !t).toggleClass("behind", t), t = !0)
        };
    o.MyModal = function(t, i) {
        var e, n;
        if (this.$body = o("body"), this.options = o.extend({}, o.MyModal.defaults, i), this.options.doFade = !isNaN(parseInt(this.options.fadeDuration, 10)), this.$blocker = null, this.options.closeExisting)
            for (; o.MyModal.isActive();) o.MyModal.close();
        if (s.push(this), t.is("a"))
            if (n = t.attr("href"), this.anchor = t, /^#/.test(n)) {
                if (this.$elm = o(n), 1 !== this.$elm.length) return null;
                this.$body.append(this.$elm), this.open()
            } else this.$elm = o("<div>"), this.$body.append(this.$elm), e = function(o, t) {
                t.elm.remove()
            }, this.showSpinner(), t.trigger(o.MyModal.AJAX_SEND), o.get(n).done(function(i) {
                if (o.MyModal.isActive()) {
                    t.trigger(o.MyModal.AJAX_SUCCESS);
                    var s = l();
                    s.$elm.empty().append(i).on(o.MyModal.CLOSE, e), s.hideSpinner(), s.open(), t.trigger(o.MyModal.AJAX_COMPLETE)
                }
            }).fail(function() {
                t.trigger(o.MyModal.AJAX_FAIL);
                var i = l();
                i.hideSpinner(), s.pop(), t.trigger(o.MyModal.AJAX_COMPLETE)
            });
        else this.$elm = t, this.anchor = t, this.$body.append(this.$elm), this.open()
    }, o.MyModal.prototype = {
        constructor: o.MyModal,
        open: function() {
            var t = this;
            this.block(), this.anchor.blur(), this.options.doFade ? setTimeout(function() {
                t.show()
            }, this.options.fadeDuration * this.options.fadeDelay) : this.show(), o(i).off("keydown.MyModal").on("keydown.MyModal", function(o) {
                var t = l();
                27 === o.which && t.options.escapeClose && t.close()
            }), this.options.clickClose && this.$blocker.click(function(t) {
                t.target === this && o.MyModal.close()
            })
        },
        close: function() {
            s.pop(), this.unblock(), this.hide(), o.MyModal.isActive() || o(i).off("keydown.MyModal")
        },
        block: function() {
            this.$elm.trigger(o.MyModal.BEFORE_BLOCK, [this._ctx()]), this.$body.css("overflow", "hidden"), this.$blocker = o('<div class="' + this.options.blockerClass + ' blocker current"></div>').appendTo(this.$body), n(), this.options.doFade && this.$blocker.css("opacity", 0).animate({
                opacity: 1
            }, this.options.fadeDuration), this.$elm.trigger(o.MyModal.BLOCK, [this._ctx()])
        },
        unblock: function(t) {
            !t && this.options.doFade ? this.$blocker.fadeOut(this.options.fadeDuration, this.unblock.bind(this, !0)) : (this.$blocker.children().appendTo(this.$body), this.$blocker.remove(), this.$blocker = null, n(), o.MyModal.isActive() || this.$body.css("overflow", ""))
        },
        show: function() {
            this.$elm.trigger(o.MyModal.BEFORE_OPEN, [this._ctx()]), this.options.showClose && (this.closeButton = o('<a href="#close-MyModal" rel="MyModal:close" class="close-MyModal ' + '">' + "</a>"), this.$elm.append(this.closeButton)), this.$elm.addClass(this.options.MyModalClass).appendTo(this.$blocker), this.options.doFade ? this.$elm.css({
                opacity: 0,
                display: "inline-block"
            }).animate({
                opacity: 1
            }, this.options.fadeDuration) : this.$elm.css("display", "inline-block"), this.$elm.trigger(o.MyModal.OPEN, [this._ctx()])
        },
        hide: function() {
            this.$elm.trigger(o.MyModal.BEFORE_CLOSE, [this._ctx()]), this.closeButton && this.closeButton.remove();
            var t = this;
            this.options.doFade ? this.$elm.fadeOut(this.options.fadeDuration, function() {
                t.$elm.trigger(o.MyModal.AFTER_CLOSE, [t._ctx()])
            }) : this.$elm.hide(0, function() {
                t.$elm.trigger(o.MyModal.AFTER_CLOSE, [t._ctx()])
            }), this.$elm.trigger(o.MyModal.CLOSE, [this._ctx()])
        },
        showSpinner: function() {
            this.options.showSpinner && (this.spinner = this.spinner || o('<div class="' + this.options.MyModalClass + '-spinner"></div>').append(this.options.spinnerHtml), this.$body.append(this.spinner), this.spinner.show())
        },
        hideSpinner: function() {
            this.spinner && this.spinner.remove()
        },
        _ctx: function() {
            return {
                elm: this.$elm,
                $elm: this.$elm,
                $blocker: this.$blocker,
                options: this.options
            }
        }
    }, o.MyModal.close = function(t) {
        if (o.MyModal.isActive()) {
            t && t.preventDefault();
            var i = l();
            console.log('MyModal');
            return i.close(), i.$elm
        }
    }, o.MyModal.isActive = function() {
        return s.length > 0
    }, o.MyModal.getCurrent = l, o.MyModal.defaults = {
        closeExisting: !0,
        escapeClose: !0,
        clickClose: !0,
        closeText: "",
        closeClass: "",
        MyModalClass: "MyModal",
        blockerClass: "jquery-MyModal",
        spinnerHtml: '<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div>',
        showSpinner: !0,
        showClose: !0,
        fadeDuration: null,
        fadeDelay: 1
    }, o.MyModal.BEFORE_BLOCK = "MyModal:before-block", o.MyModal.BLOCK = "MyModal:block", o.MyModal.BEFORE_OPEN = "MyModal:before-open", o.MyModal.OPEN = "MyModal:open", o.MyModal.BEFORE_CLOSE = "MyModal:before-close", o.MyModal.CLOSE = "MyModal:close", o.MyModal.AFTER_CLOSE = "MyModal:after-close", o.MyModal.AJAX_SEND = "MyModal:ajax:send", o.MyModal.AJAX_SUCCESS = "MyModal:ajax:success", o.MyModal.AJAX_FAIL = "MyModal:ajax:fail", o.MyModal.AJAX_COMPLETE = "MyModal:ajax:complete", o.fn.MyModal = function(t) {
        return 1 === this.length && new o.MyModal(this, t), this
    }, o(i).on("click.MyModal", 'a[rel~="MyModal:close"]', o.MyModal.close), o(i).on("click.MyModal", 'a[rel~="MyModal:open"]', function(t) {
        t.preventDefault(), o(this).MyModal()
    })
});