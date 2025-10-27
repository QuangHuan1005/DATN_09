<!-- Google Tag Manager for WordPress by gtm4wp.com -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script data-cfasync="false" data-pagespeed-no-defer>
    var gtm4wp_datalayer_name = "dataLayer";
    var dataLayer = dataLayer || [];
</script>
<!-- End Google Tag Manager for WordPress by gtm4wp.com -->
<link rel='dns-prefetch' href='http://client.crisp.chat/' />
<link rel='dns-prefetch' href='http://use.typekit.net/' />
<link rel='dns-prefetch' href='http://fonts.googleapis.com/' />
<link rel='preconnect' href='https://mixtas.b-cdn.net/' />
<link rel="alternate" type="application/rss+xml" title="Mixtas &raquo; Feed" href="../feed/index.html" />
<link rel="alternate" type="application/rss+xml" title="Mixtas &raquo; Comments Feed"
    href="../comments/feed/index.html" />
<link rel="alternate" type="application/rss+xml" title="Mixtas &raquo; Products Feed" href="feed/index.html" />
<script type="text/javascript">
    /* <![CDATA[ */
    window._wpemojiSettings = {
        "baseUrl": "https:\/\/s.w.org\/images\/core\/emoji\/16.0.1\/72x72\/",
        "ext": ".png",
        "svgUrl": "https:\/\/s.w.org\/images\/core\/emoji\/16.0.1\/svg\/",
        "svgExt": ".svg",
        "source": {
            "concatemoji": "https:\/\/mixtas.b-cdn.net\/wp-includes\/js\/wp-emoji-release.min.js?ver=6.8.2"
        }
    };
    /*! This file is auto-generated */
    ! function(s, n) {
        var o, i, e;

        function c(e) {
            try {
                var t = {
                    supportTests: e,
                    timestamp: (new Date).valueOf()
                };
                sessionStorage.setItem(o, JSON.stringify(t))
            } catch (e) {}
        }

        function p(e, t, n) {
            e.clearRect(0, 0, e.canvas.width, e.canvas.height), e.fillText(t, 0, 0);
            var t = new Uint32Array(e.getImageData(0, 0, e.canvas.width, e.canvas.height).data),
                a = (e.clearRect(0, 0, e.canvas.width, e.canvas.height), e.fillText(n, 0, 0), new Uint32Array(e
                    .getImageData(0, 0, e.canvas.width, e.canvas.height).data));
            return t.every(function(e, t) {
                return e === a[t]
            })
        }

        function u(e, t) {
            e.clearRect(0, 0, e.canvas.width, e.canvas.height), e.fillText(t, 0, 0);
            for (var n = e.getImageData(16, 16, 1, 1), a = 0; a < n.data.length; a++)
                if (0 !== n.data[a]) return !1;
            return !0
        }

        function f(e, t, n, a) {
            switch (t) {
                case "flag":
                    return n(e, "\ud83c\udff3\ufe0f\u200d\u26a7\ufe0f", "\ud83c\udff3\ufe0f\u200b\u26a7\ufe0f") ? !1 : !
                        n(e, "\ud83c\udde8\ud83c\uddf6", "\ud83c\udde8\u200b\ud83c\uddf6") && !n(e,
                            "\ud83c\udff4\udb40\udc67\udb40\udc62\udb40\udc65\udb40\udc6e\udb40\udc67\udb40\udc7f",
                            "\ud83c\udff4\u200b\udb40\udc67\u200b\udb40\udc62\u200b\udb40\udc65\u200b\udb40\udc6e\u200b\udb40\udc67\u200b\udb40\udc7f"
                        );
                case "emoji":
                    return !a(e, "\ud83e\udedf")
            }
            return !1
        }

        function g(e, t, n, a) {
            var r = "undefined" != typeof WorkerGlobalScope && self instanceof WorkerGlobalScope ? new OffscreenCanvas(
                    300, 150) : s.createElement("canvas"),
                o = r.getContext("2d", {
                    willReadFrequently: !0
                }),
                i = (o.textBaseline = "top", o.font = "600 32px Arial", {});
            return e.forEach(function(e) {
                i[e] = t(o, e, n, a)
            }), i
        }

        function t(e) {
            var t = s.createElement("script");
            t.src = e, t.defer = !0, s.head.appendChild(t)
        }
        "undefined" != typeof Promise && (o = "wpEmojiSettingsSupports", i = ["flag", "emoji"], n.supports = {
            everything: !0,
            everythingExceptFlag: !0
        }, e = new Promise(function(e) {
            s.addEventListener("DOMContentLoaded", e, {
                once: !0
            })
        }), new Promise(function(t) {
            var n = function() {
                try {
                    var e = JSON.parse(sessionStorage.getItem(o));
                    if ("object" == typeof e && "number" == typeof e.timestamp && (new Date).valueOf() <
                        e.timestamp + 604800 && "object" == typeof e.supportTests) return e.supportTests
                } catch (e) {}
                return null
            }();
            if (!n) {
                if ("undefined" != typeof Worker && "undefined" != typeof OffscreenCanvas && "undefined" !=
                    typeof URL && URL.createObjectURL && "undefined" != typeof Blob) try {
                    var e = "postMessage(" + g.toString() + "(" + [JSON.stringify(i), f.toString(), p
                            .toString(), u.toString()
                        ].join(",") + "));",
                        a = new Blob([e], {
                            type: "text/javascript"
                        }),
                        r = new Worker(URL.createObjectURL(a), {
                            name: "wpTestEmojiSupports"
                        });
                    return void(r.onmessage = function(e) {
                        c(n = e.data), r.terminate(), t(n)
                    })
                } catch (e) {}
                c(n = g(i, f, p, u))
            }
            t(n)
        }).then(function(e) {
            for (var t in e) n.supports[t] = e[t], n.supports.everything = n.supports.everything && n
                .supports[t], "flag" !== t && (n.supports.everythingExceptFlag = n.supports
                    .everythingExceptFlag && n.supports[t]);
            n.supports.everythingExceptFlag = n.supports.everythingExceptFlag && !n.supports.flag, n
                .DOMReady = !1, n.readyCallback = function() {
                    n.DOMReady = !0
                }
        }).then(function() {
            return e
        }).then(function() {
            var e;
            n.supports.everything || (n.readyCallback(), (e = n.source || {}).concatemoji ? t(e
                .concatemoji) : e.wpemoji && e.twemoji && (t(e.twemoji), t(e.wpemoji)))
        }))
    }((window, document), window._wpemojiSettings);
    /* ]]> */
</script>
<link rel='stylesheet' id='kitify-css-transform-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/css-transform40d7.css?ver=1759215509'
    type='text/css' media='all' />
<style id='wp-emoji-styles-inline-css' type='text/css'>
    img.wp-smiley,
    img.emoji {
        display: inline !important;
        border: none !important;
        box-shadow: none !important;
        height: 1em !important;
        width: 1em !important;
        margin: 0 0.07em !important;
        vertical-align: -0.1em !important;
        background: none !important;
        padding: 0 !important;
    }
</style>
<link rel='stylesheet' id='wp-block-library-css'
    href='../../mixtas.b-cdn.net/wp-includes/css/dist/block-library/style.min6c2d.css?ver=6.8.2' type='text/css'
    media='all' />
<style id='classic-theme-styles-inline-css' type='text/css'>
    /*! This file is auto-generated */
    .wp-block-button__link {
        color: #fff;
        background-color: #32373c;
        border-radius: 9999px;
        box-shadow: none;
        text-decoration: none;
        padding: calc(.667em + 2px) calc(1.333em + 2px);
        font-size: 1.125em
    }

    .wp-block-file__button {
        background: #32373c;
        color: #fff;
        text-decoration: none
    }
</style>
<link rel='stylesheet' id='jquery-selectBox-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/yith-woocommerce-wishlist/assets/css/jquery.selectBox7359.css?ver=1.2.0'
    type='text/css' media='all' />
<link rel='stylesheet' id='woocommerce_prettyPhoto_css-css'
    href='../wp-content/plugins/woocommerce/assets/css/prettyPhoto005e.css?ver=3.1.6' type='text/css' media='all' />
<link rel='stylesheet' id='yith-wcwl-main-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/yith-woocommerce-wishlist/assets/css/style474a.css?ver=4.4.0'
    type='text/css' media='all' />
<style id='yith-wcwl-main-inline-css' type='text/css'>
    :root {
        --rounded-corners-radius: 16px;
        --add-to-cart-rounded-corners-radius: 16px;
        --color-headers-background: #F4F4F4;
        --feedback-duration: 3s
    }

    :root {
        --rounded-corners-radius: 16px;
        --add-to-cart-rounded-corners-radius: 16px;
        --color-headers-background: #F4F4F4;
        --feedback-duration: 3s
    }
</style>
<style id='global-styles-inline-css' type='text/css'>
    :root {
        --wp--preset--aspect-ratio--square: 1;
        --wp--preset--aspect-ratio--4-3: 4/3;
        --wp--preset--aspect-ratio--3-4: 3/4;
        --wp--preset--aspect-ratio--3-2: 3/2;
        --wp--preset--aspect-ratio--2-3: 2/3;
        --wp--preset--aspect-ratio--16-9: 16/9;
        --wp--preset--aspect-ratio--9-16: 9/16;
        --wp--preset--color--black: #000000;
        --wp--preset--color--cyan-bluish-gray: #abb8c3;
        --wp--preset--color--white: #ffffff;
        --wp--preset--color--pale-pink: #f78da7;
        --wp--preset--color--vivid-red: #cf2e2e;
        --wp--preset--color--luminous-vivid-orange: #ff6900;
        --wp--preset--color--luminous-vivid-amber: #fcb900;
        --wp--preset--color--light-green-cyan: #7bdcb5;
        --wp--preset--color--vivid-green-cyan: #00d084;
        --wp--preset--color--pale-cyan-blue: #8ed1fc;
        --wp--preset--color--vivid-cyan-blue: #0693e3;
        --wp--preset--color--vivid-purple: #9b51e0;
        --wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg, rgba(6, 147, 227, 1) 0%, rgb(155, 81, 224) 100%);
        --wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg, rgb(122, 220, 180) 0%, rgb(0, 208, 130) 100%);
        --wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg, rgba(252, 185, 0, 1) 0%, rgba(255, 105, 0, 1) 100%);
        --wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg, rgba(255, 105, 0, 1) 0%, rgb(207, 46, 46) 100%);
        --wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg, rgb(238, 238, 238) 0%, rgb(169, 184, 195) 100%);
        --wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg, rgb(74, 234, 220) 0%, rgb(151, 120, 209) 20%, rgb(207, 42, 186) 40%, rgb(238, 44, 130) 60%, rgb(251, 105, 98) 80%, rgb(254, 248, 76) 100%);
        --wp--preset--gradient--blush-light-purple: linear-gradient(135deg, rgb(255, 206, 236) 0%, rgb(152, 150, 240) 100%);
        --wp--preset--gradient--blush-bordeaux: linear-gradient(135deg, rgb(254, 205, 165) 0%, rgb(254, 45, 45) 50%, rgb(107, 0, 62) 100%);
        --wp--preset--gradient--luminous-dusk: linear-gradient(135deg, rgb(255, 203, 112) 0%, rgb(199, 81, 192) 50%, rgb(65, 88, 208) 100%);
        --wp--preset--gradient--pale-ocean: linear-gradient(135deg, rgb(255, 245, 203) 0%, rgb(182, 227, 212) 50%, rgb(51, 167, 181) 100%);
        --wp--preset--gradient--electric-grass: linear-gradient(135deg, rgb(202, 248, 128) 0%, rgb(113, 206, 126) 100%);
        --wp--preset--gradient--midnight: linear-gradient(135deg, rgb(2, 3, 129) 0%, rgb(40, 116, 252) 100%);
        --wp--preset--font-size--small: 13px;
        --wp--preset--font-size--medium: 20px;
        --wp--preset--font-size--large: 36px;
        --wp--preset--font-size--x-large: 42px;
        --wp--preset--font-family--inter: "Inter", sans-serif;
        --wp--preset--font-family--cardo: Cardo;
        --wp--preset--spacing--20: 0.44rem;
        --wp--preset--spacing--30: 0.67rem;
        --wp--preset--spacing--40: 1rem;
        --wp--preset--spacing--50: 1.5rem;
        --wp--preset--spacing--60: 2.25rem;
        --wp--preset--spacing--70: 3.38rem;
        --wp--preset--spacing--80: 5.06rem;
        --wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);
        --wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);
        --wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);
        --wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1);
        --wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);
    }

    :where(.is-layout-flex) {
        gap: 0.5em;
    }

    :where(.is-layout-grid) {
        gap: 0.5em;
    }

    body .is-layout-flex {
        display: flex;
    }

    .is-layout-flex {
        flex-wrap: wrap;
        align-items: center;
    }

    .is-layout-flex> :is(*, div) {
        margin: 0;
    }

    body .is-layout-grid {
        display: grid;
    }

    .is-layout-grid> :is(*, div) {
        margin: 0;
    }

    :where(.wp-block-columns.is-layout-flex) {
        gap: 2em;
    }

    :where(.wp-block-columns.is-layout-grid) {
        gap: 2em;
    }

    :where(.wp-block-post-template.is-layout-flex) {
        gap: 1.25em;
    }

    :where(.wp-block-post-template.is-layout-grid) {
        gap: 1.25em;
    }

    .has-black-color {
        color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-color {
        color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-color {
        color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-color {
        color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-color {
        color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-color {
        color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-color {
        color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-color {
        color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-color {
        color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-color {
        color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-color {
        color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-color {
        color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-black-background-color {
        background-color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-background-color {
        background-color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-background-color {
        background-color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-background-color {
        background-color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-background-color {
        background-color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-background-color {
        background-color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-background-color {
        background-color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-background-color {
        background-color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-background-color {
        background-color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-background-color {
        background-color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-background-color {
        background-color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-background-color {
        background-color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-black-border-color {
        border-color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-border-color {
        border-color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-border-color {
        border-color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-border-color {
        border-color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-border-color {
        border-color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-border-color {
        border-color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-border-color {
        border-color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-border-color {
        border-color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-border-color {
        border-color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-border-color {
        border-color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-border-color {
        border-color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-border-color {
        border-color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-vivid-cyan-blue-to-vivid-purple-gradient-background {
        background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;
    }

    .has-light-green-cyan-to-vivid-green-cyan-gradient-background {
        background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;
    }

    .has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background {
        background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-orange-to-vivid-red-gradient-background {
        background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;
    }

    .has-very-light-gray-to-cyan-bluish-gray-gradient-background {
        background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;
    }

    .has-cool-to-warm-spectrum-gradient-background {
        background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;
    }

    .has-blush-light-purple-gradient-background {
        background: var(--wp--preset--gradient--blush-light-purple) !important;
    }

    .has-blush-bordeaux-gradient-background {
        background: var(--wp--preset--gradient--blush-bordeaux) !important;
    }

    .has-luminous-dusk-gradient-background {
        background: var(--wp--preset--gradient--luminous-dusk) !important;
    }

    .has-pale-ocean-gradient-background {
        background: var(--wp--preset--gradient--pale-ocean) !important;
    }

    .has-electric-grass-gradient-background {
        background: var(--wp--preset--gradient--electric-grass) !important;
    }

    .has-midnight-gradient-background {
        background: var(--wp--preset--gradient--midnight) !important;
    }

    .has-small-font-size {
        font-size: var(--wp--preset--font-size--small) !important;
    }

    .has-medium-font-size {
        font-size: var(--wp--preset--font-size--medium) !important;
    }

    .has-large-font-size {
        font-size: var(--wp--preset--font-size--large) !important;
    }

    .has-x-large-font-size {
        font-size: var(--wp--preset--font-size--x-large) !important;
    }

    :where(.wp-block-post-template.is-layout-flex) {
        gap: 1.25em;
    }

    :where(.wp-block-post-template.is-layout-grid) {
        gap: 1.25em;
    }

    :where(.wp-block-columns.is-layout-flex) {
        gap: 2em;
    }

    :where(.wp-block-columns.is-layout-grid) {
        gap: 2em;
    }

    :root :where(.wp-block-pullquote) {
        font-size: 1.5em;
        line-height: 1.6;
    }
</style>
<link rel='stylesheet' id='contact-form-7-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/contact-form-7/includes/css/styles52c7.css?ver=6.0.5'
    type='text/css' media='all' />
<link rel='stylesheet' id='custom-typekit-css-css' href='../../use.typekit.net/ihj1qly40d7.css?ver=1759215509'
    type='text/css' media='all' />
<link rel='stylesheet' id='novaworks_plugin_fontend-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/mixtas-core/public/css/frontend8a54.css?ver=1.0.0' type='text/css'
    media='all' />
<style id='woocommerce-inline-inline-css' type='text/css'>
    .woocommerce form .form-row .required {
        visibility: visible;
    }
</style>
<link rel='stylesheet' id='woo-variation-swatches-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/woo-variation-swatches/assets/css/frontend.mine98f.css?ver=1743737055'
    type='text/css' media='all' />
<style id='woo-variation-swatches-inline-css' type='text/css'>
    :root {
        --wvs-tick: url("data:image/svg+xml;utf8,%3Csvg filter='drop-shadow(0px 0px 2px rgb(0 0 0 / .8))' xmlns='http://www.w3.org/2000/svg'  viewBox='0 0 30 30'%3E%3Cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='4' d='M4 16L11 23 27 7'/%3E%3C/svg%3E");

        --wvs-cross: url("data:image/svg+xml;utf8,%3Csvg filter='drop-shadow(0px 0px 5px rgb(255 255 255 / .6))' xmlns='http://www.w3.org/2000/svg' width='72px' height='72px' viewBox='0 0 24 24'%3E%3Cpath fill='none' stroke='%23ff0000' stroke-linecap='round' stroke-width='0.6' d='M5 5L19 19M19 5L5 19'/%3E%3C/svg%3E");
        --wvs-single-product-item-width: 30px;
        --wvs-single-product-item-height: 30px;
        --wvs-single-product-item-font-size: 16px
    }
</style>
<link rel='stylesheet' id='brands-styles-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/css/brands04d4.css?ver=9.7.1' type='text/css'
    media='all' />
<link rel='stylesheet' id='novaworks-icons-css'
    href='../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/icon-fonts/core/css/iconsc64e.css?ver=1.1.1'
    type='text/css' media='all' />
<link rel='stylesheet' id='select2-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/css/select204d4.css?ver=9.7.1' type='text/css'
    media='all' />
<link rel='stylesheet' id='fontawesome-pro-css'
    href='../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/fontawesome-pro/css/all0e7d.css?ver=5.1.0'
    type='text/css' media='all' />
<link rel='stylesheet' id='normalize-css'
    href='../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/animatedModal.js/css/normalize.min5b75.css?ver=3.0.2'
    type='text/css' media='all' />
<link rel='stylesheet' id='animate-css'
    href='../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/animatedModal.js/css/animate.min40d7.css?ver=1759215509'
    type='text/css' media='all' />
<link rel='stylesheet' id='nova-mixtas-layout-css'
    href='../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/css/layout40d7.css?ver=1759215509' type='text/css'
    media='all' />
<link rel='stylesheet' id='nova-mixtas-styles-css'
    href='../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/css/app40d7.css?ver=1759215509' type='text/css'
    media='all' />
<link rel='stylesheet' id='typekit-css' href='../../use.typekit.net/ihj1qly40d7.css?ver=1759215509' type='text/css'
    media='all' />
<link rel='stylesheet' id='nova-google-fonts-css'
    href='https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800&amp;display=swap'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-base-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/kitify-base40d7.css?ver=1759215509'
    type='text/css' media='all' />
<link rel='stylesheet' id='elementor-frontend-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/custom-frontend.minbea4.css?ver=1743737085'
    type='text/css' media='all' />
<style id='elementor-frontend-inline-css' type='text/css'>
    @media(min-width:768px) {
        .kitify-vheader--hidemobile.kitify--is-vheader {
            position: relative
        }

        .kitify-vheader--hidemobile.kitify--is-vheader.kitify-vheader-pleft {
            padding-left: var(--kitify-vheader-width)
        }

        .kitify-vheader--hidemobile.kitify--is-vheader.kitify-vheader-pright {
            padding-right: var(--kitify-vheader-width)
        }

        .kitify-vheader--hidemobile.kitify--is-vheader>.elementor-location-header.elementor-edit-area {
            position: static
        }

        .kitify-vheader--hidemobile.kitify--is-vheader>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child {
            position: absolute;
            top: 0;
            bottom: 0;
            width: var(--kitify-vheader-width);
            height: auto;
            z-index: 3;
            min-height: calc(100vh - 32px)
        }

        .kitify-vheader--hidemobile.kitify--is-vheader.kitify-vheader-pleft>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child {
            left: 0
        }

        .kitify-vheader--hidemobile.kitify--is-vheader.kitify-vheader-pright>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child {
            right: 0
        }

        .kitify-vheader--hidemobile.kitify--is-vheader>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child>.elementor-container {
            flex-flow: row wrap;
            height: auto;
            position: sticky;
            top: var(--kitify-adminbar-height);
            left: 0;
            min-height: calc(100vh - 32px)
        }

        .kitify-vheader--hidemobile.kitify--is-vheader>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child>.elementor-container>.elementor-column {
            width: 100%
        }
    }

    @media(min-width:992px) {
        .kitify-vheader--hidemobile_extra.kitify--is-vheader {
            position: relative
        }

        .kitify-vheader--hidemobile_extra.kitify--is-vheader.kitify-vheader-pleft {
            padding-left: var(--kitify-vheader-width)
        }

        .kitify-vheader--hidemobile_extra.kitify--is-vheader.kitify-vheader-pright {
            padding-right: var(--kitify-vheader-width)
        }

        .kitify-vheader--hidemobile_extra.kitify--is-vheader>.elementor-location-header.elementor-edit-area {
            position: static
        }

        .kitify-vheader--hidemobile_extra.kitify--is-vheader>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child {
            position: absolute;
            top: 0;
            bottom: 0;
            width: var(--kitify-vheader-width);
            height: auto;
            z-index: 3;
            min-height: calc(100vh - 32px)
        }

        .kitify-vheader--hidemobile_extra.kitify--is-vheader.kitify-vheader-pleft>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child {
            left: 0
        }

        .kitify-vheader--hidemobile_extra.kitify--is-vheader.kitify-vheader-pright>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child {
            right: 0
        }

        .kitify-vheader--hidemobile_extra.kitify--is-vheader>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child>.elementor-container {
            flex-flow: row wrap;
            height: auto;
            position: sticky;
            top: var(--kitify-adminbar-height);
            left: 0;
            min-height: calc(100vh - 32px)
        }

        .kitify-vheader--hidemobile_extra.kitify--is-vheader>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child>.elementor-container>.elementor-column {
            width: 100%
        }
    }

    @media(min-width:1025px) {
        .kitify-vheader--hidetablet.kitify--is-vheader {
            position: relative
        }

        .kitify-vheader--hidetablet.kitify--is-vheader.kitify-vheader-pleft {
            padding-left: var(--kitify-vheader-width)
        }

        .kitify-vheader--hidetablet.kitify--is-vheader.kitify-vheader-pright {
            padding-right: var(--kitify-vheader-width)
        }

        .kitify-vheader--hidetablet.kitify--is-vheader>.elementor-location-header.elementor-edit-area {
            position: static
        }

        .kitify-vheader--hidetablet.kitify--is-vheader>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child {
            position: absolute;
            top: 0;
            bottom: 0;
            width: var(--kitify-vheader-width);
            height: auto;
            z-index: 3;
            min-height: calc(100vh - 32px)
        }

        .kitify-vheader--hidetablet.kitify--is-vheader.kitify-vheader-pleft>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child {
            left: 0
        }

        .kitify-vheader--hidetablet.kitify--is-vheader.kitify-vheader-pright>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child {
            right: 0
        }

        .kitify-vheader--hidetablet.kitify--is-vheader>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child>.elementor-container {
            flex-flow: row wrap;
            height: auto;
            position: sticky;
            top: var(--kitify-adminbar-height);
            left: 0;
            min-height: calc(100vh - 32px)
        }

        .kitify-vheader--hidetablet.kitify--is-vheader>.elementor-location-header>.elementor-section-wrap>.elementor-top-section:first-child>.elementor-container>.elementor-column {
            width: 100%
        }
    }

    .col-mob-1,
    .col-mob-2,
    .col-mob-3,
    .col-mob-4,
    .col-mob-5,
    .col-mob-6,
    .col-mob-7,
    .col-mob-8,
    .col-mob-9,
    .col-mob-10,
    .col-tabp-1,
    .col-tabp-2,
    .col-tabp-3,
    .col-tabp-4,
    .col-tabp-5,
    .col-tabp-6,
    .col-tabp-7,
    .col-tabp-8,
    .col-tabp-9,
    .col-tabp-10,
    .col-tab-1,
    .col-tab-2,
    .col-tab-3,
    .col-tab-4,
    .col-tab-5,
    .col-tab-6,
    .col-tab-7,
    .col-tab-8,
    .col-tab-9,
    .col-tab-10,
    .col-lap-1,
    .col-lap-2,
    .col-lap-3,
    .col-lap-4,
    .col-lap-5,
    .col-lap-6,
    .col-lap-7,
    .col-lap-8,
    .col-lap-9,
    .col-lap-10,
    .col-desk-1,
    .col-desk-2,
    .col-desk-3,
    .col-desk-4,
    .col-desk-5,
    .col-desk-6,
    .col-desk-7,
    .col-desk-8,
    .col-desk-9,
    .col-desk-10 {
        position: relative;
        min-height: 1px;
        padding: 10px;
        box-sizing: border-box;
        width: 100%
    }

    .col-mob-1 {
        flex: 0 0 calc(100%/1);
        max-width: calc(100%/1)
    }

    .col-mob-2 {
        flex: 0 0 calc(100%/2);
        max-width: calc(100%/2)
    }

    .col-mob-3 {
        flex: 0 0 calc(100%/3);
        max-width: calc(100%/3)
    }

    .col-mob-4 {
        flex: 0 0 calc(100%/4);
        max-width: calc(100%/4)
    }

    .col-mob-5 {
        flex: 0 0 calc(100%/5);
        max-width: calc(100%/5)
    }

    .col-mob-6 {
        flex: 0 0 calc(100%/6);
        max-width: calc(100%/6)
    }

    .col-mob-7 {
        flex: 0 0 calc(100%/7);
        max-width: calc(100%/7)
    }

    .col-mob-8 {
        flex: 0 0 calc(100%/8);
        max-width: calc(100%/8)
    }

    .col-mob-9 {
        flex: 0 0 calc(100%/9);
        max-width: calc(100%/9)
    }

    .col-mob-10 {
        flex: 0 0 calc(100%/10);
        max-width: calc(100%/10)
    }

    @media(min-width:768px) {
        .col-tabp-1 {
            flex: 0 0 calc(100%/1);
            max-width: calc(100%/1)
        }

        .col-tabp-2 {
            flex: 0 0 calc(100%/2);
            max-width: calc(100%/2)
        }

        .col-tabp-3 {
            flex: 0 0 calc(100%/3);
            max-width: calc(100%/3)
        }

        .col-tabp-4 {
            flex: 0 0 calc(100%/4);
            max-width: calc(100%/4)
        }

        .col-tabp-5 {
            flex: 0 0 calc(100%/5);
            max-width: calc(100%/5)
        }

        .col-tabp-6 {
            flex: 0 0 calc(100%/6);
            max-width: calc(100%/6)
        }

        .col-tabp-7 {
            flex: 0 0 calc(100%/7);
            max-width: calc(100%/7)
        }

        .col-tabp-8 {
            flex: 0 0 calc(100%/8);
            max-width: calc(100%/8)
        }

        .col-tabp-9 {
            flex: 0 0 calc(100%/9);
            max-width: calc(100%/9)
        }

        .col-tabp-10 {
            flex: 0 0 calc(100%/10);
            max-width: calc(100%/10)
        }
    }

    @media(min-width:992px) {
        .col-tab-1 {
            flex: 0 0 calc(100%/1);
            max-width: calc(100%/1)
        }

        .col-tab-2 {
            flex: 0 0 calc(100%/2);
            max-width: calc(100%/2)
        }

        .col-tab-3 {
            flex: 0 0 calc(100%/3);
            max-width: calc(100%/3)
        }

        .col-tab-4 {
            flex: 0 0 calc(100%/4);
            max-width: calc(100%/4)
        }

        .col-tab-5 {
            flex: 0 0 calc(100%/5);
            max-width: calc(100%/5)
        }

        .col-tab-6 {
            flex: 0 0 calc(100%/6);
            max-width: calc(100%/6)
        }

        .col-tab-7 {
            flex: 0 0 calc(100%/7);
            max-width: calc(100%/7)
        }

        .col-tab-8 {
            flex: 0 0 calc(100%/8);
            max-width: calc(100%/8)
        }

        .col-tab-9 {
            flex: 0 0 calc(100%/9);
            max-width: calc(100%/9)
        }

        .col-tab-10 {
            flex: 0 0 calc(100%/10);
            max-width: calc(100%/10)
        }
    }

    @media(min-width:1025px) {
        .col-lap-1 {
            flex: 0 0 calc(100%/1);
            max-width: calc(100%/1)
        }

        .col-lap-2 {
            flex: 0 0 calc(100%/2);
            max-width: calc(100%/2)
        }

        .col-lap-3 {
            flex: 0 0 calc(100%/3);
            max-width: calc(100%/3)
        }

        .col-lap-4 {
            flex: 0 0 calc(100%/4);
            max-width: calc(100%/4)
        }

        .col-lap-5 {
            flex: 0 0 calc(100%/5);
            max-width: calc(100%/5)
        }

        .col-lap-6 {
            flex: 0 0 calc(100%/6);
            max-width: calc(100%/6)
        }

        .col-lap-7 {
            flex: 0 0 calc(100%/7);
            max-width: calc(100%/7)
        }

        .col-lap-8 {
            flex: 0 0 calc(100%/8);
            max-width: calc(100%/8)
        }

        .col-lap-9 {
            flex: 0 0 calc(100%/9);
            max-width: calc(100%/9)
        }

        .col-lap-10 {
            flex: 0 0 calc(100%/10);
            max-width: calc(100%/10)
        }
    }

    @media(min-width:1600px) {
        .col-desk-1 {
            flex: 0 0 calc(100%/1);
            max-width: calc(100%/1)
        }

        .col-desk-2 {
            flex: 0 0 calc(100%/2);
            max-width: calc(100%/2)
        }

        .col-desk-3 {
            flex: 0 0 calc(100%/3);
            max-width: calc(100%/3)
        }

        .col-desk-4 {
            flex: 0 0 calc(100%/4);
            max-width: calc(100%/4)
        }

        .col-desk-5 {
            flex: 0 0 calc(100%/5);
            max-width: calc(100%/5)
        }

        .col-desk-6 {
            flex: 0 0 calc(100%/6);
            max-width: calc(100%/6)
        }

        .col-desk-7 {
            flex: 0 0 calc(100%/7);
            max-width: calc(100%/7)
        }

        .col-desk-8 {
            flex: 0 0 calc(100%/8);
            max-width: calc(100%/8)
        }

        .col-desk-9 {
            flex: 0 0 calc(100%/9);
            max-width: calc(100%/9)
        }

        .col-desk-10 {
            flex: 0 0 calc(100%/10);
            max-width: calc(100%/10)
        }
    }

    @media(max-width: 1599px) {
        .elementor-element.kitify-col-width-auto-laptop {
            width: auto !important
        }

        .elementor-element.kitify-col-width-auto-laptop.kitify-col-align-left {
            margin-right: auto
        }

        .elementor-element.kitify-col-width-auto-laptop.kitify-col-align-right {
            margin-left: auto
        }

        .elementor-element.kitify-col-width-auto-laptop.kitify-col-align-center {
            margin-left: auto;
            margin-right: auto
        }
    }

    @media(max-width: 1279px) {
        .elementor-element.kitify-col-width-auto-tablet_extra {
            width: auto !important
        }

        .elementor-element.kitify-col-width-auto-tablet_extra.kitify-col-align-left {
            margin-right: auto
        }

        .elementor-element.kitify-col-width-auto-tablet_extra.kitify-col-align-right {
            margin-left: auto
        }

        .elementor-element.kitify-col-width-auto-tablet_extra.kitify-col-align-center {
            margin-left: auto;
            margin-right: auto
        }
    }

    @media(max-width: 1024px) {
        .elementor-element.kitify-col-width-auto-tablet {
            width: auto !important
        }

        .elementor-element.kitify-col-width-auto-tablet.kitify-col-align-left {
            margin-right: auto
        }

        .elementor-element.kitify-col-width-auto-tablet.kitify-col-align-right {
            margin-left: auto
        }

        .elementor-element.kitify-col-width-auto-tablet.kitify-col-align-center {
            margin-left: auto;
            margin-right: auto
        }
    }

    @media(max-width: 991px) {
        .elementor-element.kitify-col-width-auto-mobile_extra {
            width: auto !important
        }

        .elementor-element.kitify-col-width-auto-mobile_extra.kitify-col-align-left {
            margin-right: auto
        }

        .elementor-element.kitify-col-width-auto-mobile_extra.kitify-col-align-right {
            margin-left: auto
        }

        .elementor-element.kitify-col-width-auto-mobile_extra.kitify-col-align-center {
            margin-left: auto;
            margin-right: auto
        }
    }

    @media(max-width: 767px) {
        .elementor-element.kitify-col-width-auto-mobile {
            width: auto !important
        }

        .elementor-element.kitify-col-width-auto-mobile.kitify-col-align-left {
            margin-right: auto
        }

        .elementor-element.kitify-col-width-auto-mobile.kitify-col-align-right {
            margin-left: auto
        }

        .elementor-element.kitify-col-width-auto-mobile.kitify-col-align-center {
            margin-left: auto;
            margin-right: auto
        }
    }

    @keyframes kitifyShortFadeInDown {
        from {
            opacity: 0;
            transform: translate3d(0, -50px, 0)
        }

        to {
            opacity: 1;
            transform: none
        }
    }

    .kitifyShortFadeInDown {
        animation-name: kitifyShortFadeInDown
    }

    @keyframes kitifyShortFadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 50px, 0)
        }

        to {
            opacity: 1;
            transform: none
        }
    }

    .kitifyShortFadeInUp {
        animation-name: kitifyShortFadeInUp
    }

    @keyframes kitifyShortFadeInLeft {
        from {
            opacity: 0;
            transform: translate3d(-50px, 0, 0)
        }

        to {
            opacity: 1;
            transform: none
        }
    }

    .kitifyShortFadeInLeft {
        animation-name: kitifyShortFadeInLeft
    }

    @keyframes kitifyShortFadeInRight {
        from {
            opacity: 0;
            transform: translate3d(50px, 0, 0)
        }

        to {
            opacity: 1;
            transform: none
        }
    }

    .kitifyShortFadeInRight {
        animation-name: kitifyShortFadeInRight
    }
</style>
<link rel='stylesheet' id='elementor-post-6-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/post-60dc3.css?ver=1743737087' type='text/css'
    media='all' />
<link rel='stylesheet' id='widget-heading-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/css/widget-heading.min87cc.css?ver=3.28.3'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-woocommerce-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/kitify-woocommercef54b.css?ver=1759215505'
    type='text/css' media='all' />
<link rel='stylesheet' id='fancybox-css'
    href='../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/fancybox/jquery.fancybox.minf8ee.css?ver=3.5.7'
    type='text/css' media='all' />
<link rel='stylesheet' id='widget-image-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/css/widget-image.min87cc.css?ver=3.28.3'
    type='text/css' media='all' />
<link rel='stylesheet' id='widget-icon-box-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/custom-widget-icon-box.minbea4.css?ver=1743737085'
    type='text/css' media='all' />
<link rel='stylesheet' id='elementor-post-917-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/post-917f9cc.css?ver=1745074389' type='text/css'
    media='all' />
<link rel='stylesheet' id='elementor-post-1043-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/post-1043f9cc.css?ver=1745074389' type='text/css'
    media='all' />
<link rel='stylesheet' id='elementor-post-1052-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/post-1052ca92.css?ver=1743737312' type='text/css'
    media='all' />
<link rel='stylesheet' id='elementor-post-459-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/post-45915a9.css?ver=1743737313' type='text/css'
    media='all' />
<link rel='stylesheet' id='elementor-post-478-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/post-47848bb.css?ver=1743737091' type='text/css'
    media='all' />
<link rel='stylesheet' id='elementor-post-342-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/post-342cdb4.css?ver=1745076735' type='text/css'
    media='all' />
<link rel='stylesheet' id='elementor-gf-local-outfit-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/google-fonts/css/outfita373.css?ver=1743737096'
    type='text/css' media='all' />
<link rel='stylesheet' id='elementor-icons-novaicon-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/inc/extensions/elementor/assets/css/novaicon8a54.css?ver=1.0.0'
    type='text/css' media='all' />
<link rel='stylesheet' id='elementor-icons-dlicon-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/inc/extensions/elementor/assets/css/nucleo8a54.css?ver=1.0.0'
    type='text/css' media='all' />

<script type="text/template" id="tmpl-unavailable-variation-template">
    <p role="alert">Sorry, this product is unavailable. Please choose a different combination.</p>
</script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/jquery/jquery.minf43b.js?ver=3.7.1"
    id="jquery-core-js"></script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/jquery/jquery-migrate.min5589.js?ver=3.4.1"
    id="jquery-migrate-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.min4a91.js?ver=2.7.0-wc.9.7.1"
    id="jquery-blockui-js" data-wp-strategy="defer"></script>
<script type="text/javascript" id="wc-add-to-cart-js-extra">
    /* <![CDATA[ */
    var wc_add_to_cart_params = {
        "ajax_url": "\/wp-admin\/admin-ajax.php",
        "wc_ajax_url": "\/?wc-ajax=%%endpoint%%",
        "i18n_view_cart": "View cart",
        "cart_url": "https:\/\/mixtas.novaworks.net\/cart\/",
        "is_cart": "",
        "cart_redirect_after_add": "no"
    };
    /* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart.min04d4.js?ver=9.7.1"
    id="wc-add-to-cart-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/js-cookie/js.cookie.min73a9.js?ver=2.1.4-wc.9.7.1"
    id="js-cookie-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript" id="woocommerce-js-extra">
    /* <![CDATA[ */
    var woocommerce_params = {
        "ajax_url": "\/wp-admin\/admin-ajax.php",
        "wc_ajax_url": "\/?wc-ajax=%%endpoint%%",
        "i18n_password_show": "Show password",
        "i18n_password_hide": "Hide password"
    };
    /* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/frontend/woocommerce.min04d4.js?ver=9.7.1"
    id="woocommerce-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/underscore.min3ab8.js?ver=1.13.7"
    id="underscore-js"></script>
<script type="text/javascript" id="wp-util-js-extra">
    /* <![CDATA[ */
    var _wpUtilSettings = {
        "ajax": {
            "url": "\/wp-admin\/admin-ajax.php"
        }
    };
    /* ]]> */
</script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/wp-util.min6c2d.js?ver=6.8.2" id="wp-util-js">
</script>
<script type="text/javascript" id="wp-statistics-tracker-js-extra">
    /* <![CDATA[ */
    var WP_Statistics_Tracker_Object = {
        "hitRequestUrl": "https:\/\/mixtas.novaworks.net\/wp-json\/wp-statistics\/v2\/hit?wp_statistics_hit_rest=yes&track_all=1&current_page_type=page&current_page_id=1052&search_query&page_uri=L2hvbWUtdjMv",
        "keepOnlineRequestUrl": "https:\/\/mixtas.novaworks.net\/wp-json\/wp-statistics\/v2\/online?wp_statistics_hit_rest=yes&track_all=1&current_page_type=page&current_page_id=1052&search_query&page_uri=L2hvbWUtdjMv",
        "option": {
            "dntEnabled": "1",
            "cacheCompatibility": "1"
        }
    };
    /* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/wp-statistics/assets/js/tracker6c2d.js?ver=6.8.2"
    id="wp-statistics-tracker-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/select2/select2.full.minab30.js?ver=4.0.3-wc.9.7.1"
    id="select2-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/flexslider/jquery.flexslider.mind207.js?ver=2.7.2-wc.9.7.1"
    id="flexslider-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript" id="wc-single-product-js-extra">
    /* <![CDATA[ */
    var wc_single_product_params = {
        "i18n_required_rating_text": "Please select a rating",
        "i18n_rating_options": ["1 of 5 stars", "2 of 5 stars", "3 of 5 stars", "4 of 5 stars", "5 of 5 stars"],
        "i18n_product_gallery_trigger_text": "View full-screen image gallery",
        "review_rating_required": "yes",
        "flexslider": {
            "rtl": false,
            "animation": "slide",
            "smoothHeight": true,
            "directionNav": false,
            "controlNav": "thumbnails",
            "slideshow": false,
            "animationSpeed": 300,
            "animationLoop": false
        },
        "zoom_enabled": "",
        "zoom_options": [],
        "photoswipe_enabled": "1",
        "photoswipe_options": {
            "shareEl": false,
            "closeOnScroll": false,
            "history": false,
            "hideAnimationDuration": 400,
            "showAnimationDuration": 400,
            "captionEl": false,
            "showHideOpacity": true
        },
        "flexslider_enabled": "1"
    };
    /* ]]> */
</script>
<script type="text/javascript" id="wc-single-product-js-before">
    /* <![CDATA[ */
    try {
        wc_single_product_params.flexslider.directionNav = true;
        wc_single_product_params.flexslider.before = function(slider) {
            jQuery(document).trigger('kitify/woocommerce/single/init_product_slider', [slider]);
        }
    } catch (ex) {}
    /* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/frontend/single-product.min04d4.js?ver=9.7.1"
    id="wc-single-product-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript" id="wc-add-to-cart-variation-js-extra">
    /* <![CDATA[ */
    var wc_add_to_cart_variation_params = {
        "wc_ajax_url": "\/?wc-ajax=%%endpoint%%",
        "i18n_no_matching_variations_text": "Sorry, no products matched your selection. Please choose a different combination.",
        "i18n_make_a_selection_text": "Please select some product options before adding this product to your cart.",
        "i18n_unavailable_text": "Sorry, this product is unavailable. Please choose a different combination.",
        "i18n_reset_alert_text": "Your selection has been reset. Please select some product options before adding this product to your cart."
    };
    /* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart-variation.min04d4.js?ver=9.7.1"
    id="wc-add-to-cart-variation-js" defer="defer" data-wp-strategy="defer"></script>
<link rel="https://api.w.org/" href="../wp-json/index.html" />
<link rel="alternate" title="JSON" type="application/json" href="../wp-json/wp/v2/pages/1052.json" />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="../xmlrpc0db0.php?rsd" />
<meta name="generator" content="WordPress 6.8.2" />
<meta name="generator" content="WooCommerce 9.7.1" />
<link rel="canonical" href="index.html" />
<link rel='shortlink' href='../index3674.html?p=1052' />
<link rel="alternate" title="oEmbed (JSON)" type="application/json+oembed"
    href="../wp-json/oembed/1.0/embedf4af.json?url=https%3A%2F%2Fmixtas.novaworks.net%2Fhome-v3%2F" />
<link rel="alternate" title="oEmbed (XML)" type="text/xml+oembed"
    href="../wp-json/oembed/1.0/embed7737?url=https%3A%2F%2Fmixtas.novaworks.net%2Fhome-v3%2F&amp;format=xml" />

<!-- Google Tag Manager for WordPress by gtm4wp.com -->
<!-- GTM Container placement set to footer -->
<script data-cfasync="false" data-pagespeed-no-defer type="text/javascript">
    var dataLayer_content = {
        "pagePostType": "page",
        "pagePostType2": "single-page",
        "pagePostAuthor": "admin"
    };
    dataLayer.push(dataLayer_content);
</script>
<script data-cfasync="false">
    (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            '../../www.googletagmanager.com/gtm5445.html?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-TH4WGRG');
</script>
<!-- End Google Tag Manager for WordPress by gtm4wp.com -->
<!-- Analytics by WP Statistics v14.5.1 - https://wp-statistics.com/ -->
<script>
    var nova_ajax_url = '../wp-admin/admin-ajax.html';
</script>
<noscript>
    <style>
        .woocommerce-product-gallery {
            opacity: 1 !important;
        }
    </style>
</noscript>
<meta name="generator"
    content="Elementor 3.28.3; features: e_font_icon_svg, additional_custom_breakpoints, e_local_google_fonts; settings: css_print_method-external, google_font-enabled, font_display-swap">
<style>
    .e-con.e-parent:nth-of-type(n+4):not(.e-lazyloaded):not(.e-no-lazyload),
    .e-con.e-parent:nth-of-type(n+4):not(.e-lazyloaded):not(.e-no-lazyload) * {
        background-image: none !important;
    }

    @media screen and (max-height: 1024px) {

        .e-con.e-parent:nth-of-type(n+3):not(.e-lazyloaded):not(.e-no-lazyload),
        .e-con.e-parent:nth-of-type(n+3):not(.e-lazyloaded):not(.e-no-lazyload) * {
            background-image: none !important;
        }
    }

    @media screen and (max-height: 640px) {

        .e-con.e-parent:nth-of-type(n+2):not(.e-lazyloaded):not(.e-no-lazyload),
        .e-con.e-parent:nth-of-type(n+2):not(.e-lazyloaded):not(.e-no-lazyload) * {
            background-image: none !important;
        }
    }
</style>
<meta name="generator"
    content="Powered by Slider Revolution 6.7.31 - responsive, Mobile-Friendly Slider Plugin for WordPress with comfortable drag and drop interface." />
<style class='wp-fonts-local' type='text/css'>
    @font-face {
        font-family: Inter;
        font-style: normal;
        font-weight: 300 900;
        font-display: fallback;
        src: url('https://mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/fonts/Inter-VariableFont_slnt,wght.woff2') format('woff2');
        font-stretch: normal;
    }

    @font-face {
        font-family: Cardo;
        font-style: normal;
        font-weight: 400;
        font-display: fallback;
        src: url('https://mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/fonts/cardo_normal_400.woff2') format('woff2');
    }
</style>
<style>
    :root {
        --site-bg-color: #FFFFFF;
        --site-font-size: 16px;
        --site-font-weight: 400;
        --site-text-color: #666666;
        --site-heading-color: #222222;
        --site-accent-color: #000000;
        --site-border-color: #EEEEEE;
        --site-link-color: #000000;
        --site-link-hover-color: #666666;
        --site-width: 1440px;
        --site-main-font: 'muli', sans-serif;
        --site-secondary-font: 'Outfit', serif;
        --heading-font-weight: 400;

        --site-wc-price: rgba(34, 34, 34, 0.8);
        --site-wc-price-old: rgba(34, 34, 34, 0.5);

        --site-primary-button-color: #FFFFFF;
        --site-primary-button-bg: #000000;
        --site-secondary-button-color: #FFFFFF;
        --site-secondary-button-bg: #222222;

        --site-header-height: 100px;
        --site-header-logo-width: 130px;
        --site-header-bg-color: #FFFFFF;
        --site-header-text-color: #666666;
        --site-header-accent-color: #000000;
        --site-header-border-color: rgba(102, 102, 102, 0.15);

        --site-main-menu-bg-color: #FFFFFF;
        --site-main-menu-text-color: #222222;
        --site-main-menu-accent-color: #000000;
        --site-main-menu-border-color: #EEEEEE;

        --mobile-header-bg-color: #FFFFFF;
        --mobile-header-text-color: #000000;
        --mobile-pre-header-bg-color: #000000;
        --mobile-pre-header-text-color: #FFFFFF;
        --mobile-pre-header-border-color: #000000;

        --page-header-bg-color: #F6F6F6;
        --page-header-overlay-color: #000000;
        --page-header-text-color: #777777;
        --page-header-heading-color: #111111;
        --page-header-height: 300px;
        --page-header-font-size: 60px;

        --dropdown-bg-color: #FFFFFF;
        --dropdown-text-color: #666666;
        --dropdown-accent-color: #000000;
        --dropdown-secondary-color: rgba(102, 102, 102, 0.7);
        --dropdown-grey-color: rgba(102, 102, 102, 0.5);
        --dropdown-border-color: rgba(102, 102, 102, 0.15);


        --site-filter-widget-height: 150px;

        --site-button-radius: 3px;
        --site-field-radius: 0px;

    }

    .styling__quickview {
        --qv-bg-color: #FFFFFF;
        --qv-text-color: #666666;
        --qv-heading-color: #222222;
        --qv-border-color: rgba(34, 34, 34, 0.15);
    }

    .error-404 {
        --p404-text-color: #000000;
    }

    body,
    body .kitify {

        --kitify-primary-color: #000000;
        --kitify-pagination-link-hover-bg-color: #000000;
        --kitify-secondary-color: #222222;
        --kitify-body-color: #666666;
        --kitify-border-color: #EEEEEE;
    }

    .isPageSpeed .nova-image-loading,
    body>div.pace {
        display: none;
        visibility: hidden;
        /*content-visibility: hidden;*/
    }

    body:not(.body-loaded) .kitify-text-marquee .kititfy-m-content {
        display: none;
    }

    body.elementor-editor-active .kitify-text-marquee .kititfy-m-content {
        display: block !important;
    }

    .isPageSpeed .site-wrapper .elementor-top-section+.elementor-top-section~.elementor-top-section,
    .isPageSpeed .elementor-kitify-nova-menu,
    .isPageSpeed .elementor-location-footer {
        /*content-visibility: hidden;*/
        visibility: hidden;
        margin: 0;
        padding: 0;
    }

    /********************************************************************/
    /* Shop *************************************************************/
    /********************************************************************/
</style>
<link rel="icon" href="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/cropped-fav-32x32.png" sizes="32x32" />
<link rel="icon" href="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/cropped-fav-192x192.png"
    sizes="192x192" />
<link rel="apple-touch-icon" href="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/cropped-fav-180x180.png" />
<meta name="msapplication-TileImage"
    content="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/cropped-fav-270x270.png" />
<script>
    function setREVStartSize(e) {
        //window.requestAnimationFrame(function() {
        window.RSIW = window.RSIW === undefined ? window.innerWidth : window.RSIW;
        window.RSIH = window.RSIH === undefined ? window.innerHeight : window.RSIH;
        try {
            var pw = document.getElementById(e.c).parentNode.offsetWidth,
                newh;
            pw = pw === 0 || isNaN(pw) || (e.l == "fullwidth" || e.layout == "fullwidth") ? window.RSIW : pw;
            e.tabw = e.tabw === undefined ? 0 : parseInt(e.tabw);
            e.thumbw = e.thumbw === undefined ? 0 : parseInt(e.thumbw);
            e.tabh = e.tabh === undefined ? 0 : parseInt(e.tabh);
            e.thumbh = e.thumbh === undefined ? 0 : parseInt(e.thumbh);
            e.tabhide = e.tabhide === undefined ? 0 : parseInt(e.tabhide);
            e.thumbhide = e.thumbhide === undefined ? 0 : parseInt(e.thumbhide);
            e.mh = e.mh === undefined || e.mh == "" || e.mh === "auto" ? 0 : parseInt(e.mh, 0);
            if (e.layout === "fullscreen" || e.l === "fullscreen")
                newh = Math.max(e.mh, window.RSIH);
            else {
                e.gw = Array.isArray(e.gw) ? e.gw : [e.gw];
                for (var i in e.rl)
                    if (e.gw[i] === undefined || e.gw[i] === 0) e.gw[i] = e.gw[i - 1];
                e.gh = e.el === undefined || e.el === "" || (Array.isArray(e.el) && e.el.length == 0) ? e.gh : e.el;
                e.gh = Array.isArray(e.gh) ? e.gh : [e.gh];
                for (var i in e.rl)
                    if (e.gh[i] === undefined || e.gh[i] === 0) e.gh[i] = e.gh[i - 1];

                var nl = new Array(e.rl.length),
                    ix = 0,
                    sl;
                e.tabw = e.tabhide >= pw ? 0 : e.tabw;
                e.thumbw = e.thumbhide >= pw ? 0 : e.thumbw;
                e.tabh = e.tabhide >= pw ? 0 : e.tabh;
                e.thumbh = e.thumbhide >= pw ? 0 : e.thumbh;
                for (var i in e.rl) nl[i] = e.rl[i] < window.RSIW ? 0 : e.rl[i];
                sl = nl[0];
                for (var i in nl)
                    if (sl > nl[i] && nl[i] > 0) {
                        sl = nl[i];
                        ix = i;
                    }
                var m = pw > (e.gw[ix] + e.tabw + e.thumbw) ? 1 : (pw - (e.tabw + e.thumbw)) / (e.gw[ix]);
                newh = (e.gh[ix] * m) + (e.tabh + e.thumbh);
            }
            var el = document.getElementById(e.c);
            if (el !== null && el) el.style.height = newh + "px";
            el = document.getElementById(e.c + "_wrapper");
            if (el !== null && el) {
                el.style.height = newh + "px";
                el.style.display = "block";
            }
        } catch (e) {
            console.log("Failure at Presize of Slider:" + e)
        }
        //});
    };
</script>
<style>
    .form-actions-extra {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: #555;
    }

    .form-actions-extra a {
        color: #0073aa;
        /* xanh nhẹ */
        font-weight: 500;
        text-decoration: none;
    }

    .form-actions-extra a:hover {
        text-decoration: underline;
    }

    .products_ajax_button:not(:first-of-type) {
        display: none;
    }
</style>
<style>
    :root {
        --bg: #fafafa;
        --card: #fff;
        --text: #222;
        --muted: #6b7280;
        --primary: #ee4d2d;
        --primary-600: #d63a1b;
        --border: #e5e7eb;
        --ring: #ffefe9;
    }

    html,
    body {
        height: 100%;
    }

    body {
        margin: 0;
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
        background: var(--bg);
        color: var(--text);
    }

    .container {
        max-width: 1120px;
        margin: 0 auto;
        padding: 24px;
    }

    .card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 12px;
        box-shadow: 0 1px 2px rgba(16, 24, 40, .04);
    }

    .layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 24px;
    }

    @media (max-width: 920px) {
        .layout {
            grid-template-columns: 1fr
        }

        .sidebar {
            position: sticky;
            top: 0;
            z-index: 5
        }
    }

    .sidebar {
        padding: 16px
    }

    .side-section {
        margin-bottom: 18px
    }

    .side-title {
        font-size: 12px;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: var(--muted);
        margin: 18px 0 8px 12px
    }

    .nav {
        list-style: none;
        margin: 0;
        padding: 0
    }

    .nav a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 10px;
        color: var(--text);
        text-decoration: none
    }

    .nav a:hover {
        background: #f5f6f7
    }

    .nav a.active {
        background: var(--ring);
        color: var(--primary);
        font-weight: 600;
        border: 1px solid #ffd3c6
    }

    .content {
        padding: 24px
    }

    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px
    }

    .title {
        font-size: 20px;
        font-weight: 700
    }

    .desc {
        color: var(--muted);
        font-size: 14px
    }

    .grid {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 20px
    }

    @media (max-width: 920px) {
        .grid {
            grid-template-columns: 1fr
        }
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 14px
    }

    .label {
        font-size: 13px;
        color: #374151
    }

    .input,
    .select {
        height: 40px;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 0 12px;
        font-size: 14px;
        background: #fff
    }

    .input[readonly] {
        background: #f8fafc;
        color: #6b7280
    }

    .input:focus,
    .select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--ring)
    }

    .help {
        font-size: 12px;
        color: var(--muted)
    }

    .error {
        font-size: 12px;
        color: #b91c1c
    }

    .radio-row {
        display: flex;
        gap: 16px
    }

    .actions {
        display: flex;
        gap: 12px;
        margin-top: 10px
    }

    .btn {
        height: 40px;
        padding: 0 16px;
        border-radius: 10px;
        border: 1px solid transparent;
        cursor: pointer;
        font-weight: 600
    }

    .btn-primary {
        background: var(--primary);
        color: #fff
    }

    .btn-primary:hover {
        background: var(--primary-600)
    }

    .btn-ghost {
        background: #fff;
        border-color: var(--border)
    }

    .avatar-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        border-left: 1px dashed var(--border);
        padding-left: 20px
    }

    @media (max-width: 920px) {
        .avatar-card {
            border-left: 0;
            border-top: 1px dashed var(--border);
            padding: 20px 0 0
        }
    }

    .avatar {
        width: 120px;
        height: 120px;
        border-radius: 999px;
        object-fit: cover;
        border: 1px solid var(--border);
        background: #f3f4f6
    }

    .uploader input {
        display: none
    }

    .uploader label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 10px;
        border: 1px dashed var(--primary);
        color: var(--primary);
        background: #fff7f5
    }

    .note {
        font-size: 12px;
        color: var(--muted);
        text-align: center
    }

    .alert {
        padding: 10px 12px;
        border-radius: 10px;
        margin-bottom: 14px
    }

    .alert-success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46
    }

    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #7f1d1d
    }
</style>
 <?php /**PATH C:\laragon\www\DATN_09\resources\views/layouts/css.blade.php ENDPATH**/ ?>