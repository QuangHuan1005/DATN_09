<script>
    window.RS_MODULES = window.RS_MODULES || {};
		window.RS_MODULES.modules = window.RS_MODULES.modules || {};
		window.RS_MODULES.waiting = window.RS_MODULES.waiting || [];
		window.RS_MODULES.defered = true;
		window.RS_MODULES.moduleWaiting = window.RS_MODULES.moduleWaiting || {};
		window.RS_MODULES.type = 'compiled';
</script>
<script type="speculationrules">
    {"prefetch":[{"source":"document","where":{"and":[{"href_matches":"\/*"},{"not":{"href_matches":["\/wp-*.php","\/wp-admin\/*","\/wp-content\/uploads\/*","\/wp-content\/*","\/wp-content\/plugins\/*","\/wp-content\/themes\/mixtas\/*","\/*\\?(.+)"]}},{"not":{"selector_matches":"a[rel~=\"nofollow\"]"}},{"not":{"selector_matches":".no-prefetch, .no-prefetch a"}}]},"eagerness":"conservative"}]}
    </script>

<!-- GTM Container placement set to footer -->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TH4WGRG" height="0" width="0"
        style="display:none;visibility:hidden" aria-hidden="true"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<script>
    const lazyloadRunObserver = () => {
			const lazyloadBackgrounds = document.querySelectorAll(`.e-con.e-parent:not(.e-lazyloaded)`);
			const lazyloadBackgroundObserver = new IntersectionObserver((entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						let lazyloadBackground = entry.target;
						if (lazyloadBackground) {
							lazyloadBackground.classList.add('e-lazyloaded');
						}
						lazyloadBackgroundObserver.unobserve(entry.target);
					}
				});
			}, { rootMargin: '200px 0px 200px 0px' });
			lazyloadBackgrounds.forEach((lazyloadBackground) => {
				lazyloadBackgroundObserver.observe(lazyloadBackground);
			});
		};
		const events = [
			'DOMContentLoaded',
			'elementor/lazyload/observe',
		];
		events.forEach((event) => {
			document.addEventListener(event, lazyloadRunObserver);
		});
</script>
<script type='text/javascript'>
    (function () {
			var c = document.body.className;
			c = c.replace(/woocommerce-no-js/, 'woocommerce-js');
			document.body.className = c;
		})();
</script>
<link rel='stylesheet' id='wc-blocks-style-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/client/blocks/wc-blocks2656.css?ver=wc-9.7.1'
    type='text/css' media='all' />
<link rel='stylesheet' id='widget-heading-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/css/widget-heading.min87cc.css?ver=3.28.3'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-banner-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/banner40d7.css?ver=1759215509'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-advanced-carousel-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/advanced-carousel40d7.css?ver=1759215509'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-nav-menu-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/nav-menu40d7.css?ver=1759215509'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-posts-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/posts40d7.css?ver=1759215509'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-search-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/search40d7.css?ver=1759215509'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-tabs-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/tabs40d7.css?ver=1759215509'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-canvas-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/kitify-canvas40d7.css?ver=1759215509'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-breadcrumbs-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/breadcrumbs1a84.css?ver=1759215531'
    type='text/css' media='all' />
<link rel='stylesheet' id='elementor-post-1073-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/post-10737d1c.css?ver=1743737314' type='text/css'
    media='all' />
<link rel='stylesheet' id='kitify-woocommerce-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/kitify-woocommerce40d7.css?ver=1759215509'
    type='text/css' media='all' />
<link rel='stylesheet' id='novaapf-style-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/nova-ajax-product-filter/assets/css/novaapf-styles6c2d.css?ver=6.8.2'
    type='text/css' media='all' />
<link rel='stylesheet' id='font-awesome-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/lib/font-awesome/css/font-awesome.min1849.css?ver=4.7.0'
    type='text/css' media='all' />
<style id='font-awesome-inline-css' type='text/css'>
    [data-font="FontAwesome"]:before {
        font-family: 'FontAwesome' !important;
        content: attr(data-icon) !important;
        speak: none !important;
        font-weight: normal !important;
        font-variant: normal !important;
        text-transform: none !important;
        line-height: 1 !important;
        font-style: normal !important;
        -webkit-font-smoothing: antialiased !important;
        -moz-osx-font-smoothing: grayscale !important;
    }
</style>
<link rel='stylesheet' id='widget-social-icons-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/css/widget-social-icons.min87cc.css?ver=3.28.3'
    type='text/css' media='all' />
<link rel='stylesheet' id='e-apple-webkit-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/custom-apple-webkit.minbea4.css?ver=1743737085'
    type='text/css' media='all' />
<link rel='stylesheet' id='widget-icon-list-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/custom-widget-icon-list.minbea4.css?ver=1743737085'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-subscribe-form-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/subscribe-form1a84.css?ver=1759215531'
    type='text/css' media='all' />
<link rel='stylesheet' id='widget-image-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/css/widget-image.min87cc.css?ver=3.28.3'
    type='text/css' media='all' />
<link rel='stylesheet' id='rs-plugin-settings-css'
    href='../wp-content/plugins/revslider/sr6/assets/css/rs61676.css?ver=6.7.31' type='text/css' media='all' />
<style id='rs-plugin-settings-inline-css' type='text/css'>
    #rs-demo-id {}
</style>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/yith-woocommerce-wishlist/assets/js/jquery.selectBox.min7359.js?ver=1.2.0"
    id="jquery-selectBox-js"></script>
<script type="text/javascript"
    src="../wp-content/plugins/woocommerce/assets/js/prettyPhoto/jquery.prettyPhoto.min005e.js?ver=3.1.6"
    id="prettyPhoto-js" data-wp-strategy="defer"></script>
<script type="text/javascript" id="jquery-yith-wcwl-js-extra">
    /* <![CDATA[ */
		var yith_wcwl_l10n = { "ajax_url": "\/wp-admin\/admin-ajax.php", "redirect_to_cart": "no", "yith_wcwl_button_position": "after_add_to_cart", "multi_wishlist": "", "hide_add_button": "1", "enable_ajax_loading": "", "ajax_loader_url": "https:\/\/mixtas.b-cdn.net\/wp-content\/plugins\/yith-woocommerce-wishlist\/assets\/images\/ajax-loader-alt.svg", "remove_from_wishlist_after_add_to_cart": "1", "is_wishlist_responsive": "", "time_to_close_prettyphoto": "3000", "fragments_index_glue": ".", "reload_on_found_variation": "1", "mobile_media_query": "768", "labels": { "cookie_disabled": "We are sorry, but this feature is available only if cookies on your browser are enabled.", "added_to_cart_message": "<div class=\"woocommerce-notices-wrapper\"><div class=\"woocommerce-message\" role=\"alert\">Product added to cart successfully<\/div><\/div>" }, "actions": { "add_to_wishlist_action": "add_to_wishlist", "remove_from_wishlist_action": "remove_from_wishlist", "reload_wishlist_and_adding_elem_action": "reload_wishlist_and_adding_elem", "load_mobile_action": "load_mobile", "delete_item_action": "delete_item", "save_title_action": "save_title", "save_privacy_action": "save_privacy", "load_fragments": "load_fragments" }, "nonce": { "add_to_wishlist_nonce": "54e378c625", "remove_from_wishlist_nonce": "47efc3fe29", "reload_wishlist_and_adding_elem_nonce": "2a7b7e69b5", "load_mobile_nonce": "9943d11ffb", "delete_item_nonce": "52dcfee0b6", "save_title_nonce": "7d0742e0b7", "save_privacy_nonce": "31d311c85b", "load_fragments_nonce": "66747c4b21" }, "redirect_after_ask_estimate": "", "ask_estimate_redirect_url": "https:\/\/mixtas.novaworks.net" };
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/yith-woocommerce-wishlist/assets/js/jquery.yith-wcwl.min474a.js?ver=4.4.0"
    id="jquery-yith-wcwl-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-includes/js/dist/hooks.min4fdd.js?ver=4d63a3d491d11ffd8ac6" id="wp-hooks-js">
</script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/dist/i18n.minc33c.js?ver=5e580eb46a90c2b997e6"
    id="wp-i18n-js">
</script>
<script type="text/javascript" id="wp-i18n-js-after">
    /* <![CDATA[ */
		wp.i18n.setLocaleData({ 'text direction\u0004ltr': ['ltr'] });
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/contact-form-7/includes/swv/js/index52c7.js?ver=6.0.5" id="swv-js">
</script>
<script type="text/javascript" id="contact-form-7-js-before">
    /* <![CDATA[ */
		var wpcf7 = {
			"api": {
				"root": "https:\/\/mixtas.novaworks.net\/wp-json\/",
				"namespace": "contact-form-7\/v1"
			},
			"cached": 1
		};
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/contact-form-7/includes/js/index52c7.js?ver=6.0.5"
    id="contact-form-7-js"></script>
<script type="text/javascript" src="../wp-content/plugins/revslider/sr6/assets/js/rbtools.min0c0c.js?ver=6.7.29" defer
    async id="tp-tools-js"></script>
<script type="text/javascript" src="../wp-content/plugins/revslider/sr6/assets/js/rs6.min1676.js?ver=6.7.31" defer async
    id="revmin-js"></script>
<script type="text/javascript" id="crisp-js-before">
    /* <![CDATA[ */
		window.$crisp = [];
		if (!window.CRISP_RUNTIME_CONFIG) {
			window.CRISP_RUNTIME_CONFIG = {}
		}

		if (!window.CRISP_RUNTIME_CONFIG.locale) {
			window.CRISP_RUNTIME_CONFIG.locale = 'en-us'
		}

		CRISP_WEBSITE_ID = '114c3be4-da0f-4663-b5f7-3febfccc9984';
		/* ]]> */
</script>
<script type="text/javascript" async src="../../client.crisp.chat/ldad2.js?ver=20250930" id="crisp-js"></script>
<script type="text/javascript" id="wp-api-request-js-extra">
    /* <![CDATA[ */
		var wpApiSettings = { "root": "https:\/\/mixtas.novaworks.net\/wp-json\/", "nonce": "b30a18ec1e", "versionString": "wp\/v2\/" };
		/* ]]> */
</script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/api-request.min6c2d.js?ver=6.8.2"
    id="wp-api-request-js"></script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/dist/vendor/wp-polyfill.min2c7c.js?ver=3.15.0"
    id="wp-polyfill-js">
</script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/dist/url.mind63a.js?ver=c2964167dfe2477c14ea"
    id="wp-url-js">
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-includes/js/dist/api-fetch.minc31c.js?ver=3623a576c78df404ff20" id="wp-api-fetch-js">
</script>
<script type="text/javascript" id="wp-api-fetch-js-after">
    /* <![CDATA[ */
		wp.apiFetch.use(wp.apiFetch.createRootURLMiddleware("../wp-json/index.html"));
		wp.apiFetch.nonceMiddleware = wp.apiFetch.createNonceMiddleware("b30a18ec1e");
		wp.apiFetch.use(wp.apiFetch.nonceMiddleware);
		wp.apiFetch.use(wp.apiFetch.mediaUploadMiddleware);
		wp.apiFetch.nonceEndpoint = "../wp-admin/admin-ajaxf809.html?action=rest-nonce";
		/* ]]> */
</script>
<script type="text/javascript" id="woo-variation-swatches-js-extra">
    /* <![CDATA[ */
		var woo_variation_swatches_options = { "show_variation_label": "1", "clear_on_reselect": "", "variation_label_separator": ":", "is_mobile": "1", "show_variation_stock": "", "stock_label_threshold": "5", "cart_redirect_after_add": "no", "enable_ajax_add_to_cart": "yes", "cart_url": "https:\/\/mixtas.novaworks.net\/cart\/", "is_cart": "" };
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woo-variation-swatches/assets/js/frontend.mine98f.js?ver=1743737055"
    id="woo-variation-swatches-js"></script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/imagesloaded.minbb93.js?ver=5.0.0"
    id="imagesloaded-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/foundation/dist/js/foundation.min40d7.js?ver=1759215509"
    id="foundation-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/cookies/js.cookie40d7.js?ver=1759215509"
    id="cookies-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/jquery-visible/jquery.visible40d7.js?ver=1759215509"
    id="jquery-visible-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/scrollTo/jquery.scrollTo.min40d7.js?ver=1759215509"
    id="scrollTo-js"></script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/hoverIntent.min3e5a.js?ver=1.10.2"
    id="hoverIntent-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/jquery.perfect-scrollbar.minceb2.js?ver=0.7.1"
    id="perfect-scrollbar-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/mojs/mo.min40d7.js?ver=1759215509" id="mojs-js">
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/anime/anime.min40d7.js?ver=1759215509"
    id="anime-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/lib/swiper/v8/swiper.min94a4.js?ver=8.4.5"
    id="swiper-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/headroom.js/headroom.min40d7.js?ver=1759215509"
    id="headroom-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/slick/slick.min40d7.js?ver=1759215509"
    id="slick-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/sticky-kit/jquery.sticky-kit.min40d7.js?ver=1759215509"
    id="sticky-kit-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/jquery-loading-overlay/loadingoverlay.min40d7.js?ver=1759215509"
    id="jquery-loading-overlay-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/readmore/readmorec64e.js?ver=1.1.1"
    id="readmore-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/isotope/isotope.pkgd.minc64e.js?ver=1.1.1"
    id="isotope-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/video.popupc64e.js?ver=1.1.1"
    id="video-popup-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/animatedModal.js/animatedModalc64e.js?ver=1.1.1"
    id="animatedModal-js"></script>
<script type="text/javascript" id="nova-app-js-extra">
    /* <![CDATA[ */
		var nova_js_var = { "js_path": "https:\/\/mixtas.b-cdn.net\/wp-content\/themes\/mixtas\/assets\/js\/vendor\/", "js_min": "1", "site_preloader": "", "topbar_progress": "", "select_placeholder": "Choose an option", "blog_pagination_type": "default", "load_more_btn": "Load more", "read_more_btn": "Read more", "read_less_btn": "Read less", "enable_header_sticky": "0", "shop_pagination_type": "infinite_scroll", "accent_color": "#000000", "shop_display": "grid", "popup_show_after": "2000", "product_image_zoom": "1", "is_customize_preview": "" };
		/* ]]> */
</script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/js/app40d7.js?ver=1759215509"
    id="nova-app-js">
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/sourcebuster/sourcebuster.min04d4.js?ver=9.7.1"
    id="sourcebuster-js-js"></script>
<script type="text/javascript" id="wc-order-attribution-js-extra">
    /* <![CDATA[ */
		var wc_order_attribution = { "params": { "lifetime": 1.0e-5, "session": 30, "base64": false, "ajaxurl": "https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php", "prefix": "wc_order_attribution_", "allowTracking": true }, "fields": { "source_type": "current.typ", "referrer": "current_add.rf", "utm_campaign": "current.cmp", "utm_source": "current.src", "utm_medium": "current.mdm", "utm_content": "current.cnt", "utm_id": "current.id", "utm_term": "current.trm", "utm_source_platform": "current.plt", "utm_creative_format": "current.fmt", "utm_marketing_tactic": "current.tct", "session_entry": "current_add.ep", "session_start_time": "current_add.fd", "session_pages": "session.pgs", "session_count": "udata.vst", "user_agent": "udata.uag" } };
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/frontend/order-attribution.min04d4.js?ver=9.7.1"
    id="wc-order-attribution-js"></script>
<script type="text/javascript" id="novaapf-script-js-extra">
    /* <![CDATA[ */
		var novaapf_price_filter_params = { "currency_symbol": "$", "currency_pos": "left" };
		var novaapf_params = { "shop_loop_container": ".novaapf-before-products", "not_found_container": ".novaapf-before-products", "pagination_container": ".woocommerce-pagination", "overlay_bg_color": "#fff", "sorting_control": "1", "scroll_to_top": "1", "scroll_to_top_offset": "150", "enable_font_awesome": "", "custom_scripts": "", "disable_transients": "" };
		/* ]]> */
</script>
{{-- <script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/nova-ajax-product-filter/assets/js/scripts11a8.js?ver=20120206"
    id="novaapf-script-js"></script> --}}
<script type="text/javascript" id="wc-cart-fragments-js-extra">
    /* <![CDATA[ */
		var wc_cart_fragments_params = { "ajax_url": "\/wp-admin\/admin-ajax.php", "wc_ajax_url": "\/?wc-ajax=%%endpoint%%", "cart_hash_key": "wc_cart_hash_5d3227775be22d377568ebad71c4a81b", "fragment_name": "wc_fragments_5d3227775be22d377568ebad71c4a81b", "request_timeout": "5000" };
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.min04d4.js?ver=9.7.1"
    id="wc-cart-fragments-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/js/webpack.runtime.min87cc.js?ver=3.28.3"
    id="elementor-webpack-runtime-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/js/frontend-modules.min87cc.js?ver=3.28.3"
    id="elementor-frontend-modules-js"></script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/jquery/ui/core.minb37e.js?ver=1.13.3"
    id="jquery-ui-core-js"></script>
<script type="text/javascript" id="elementor-frontend-js-extra">
    /* <![CDATA[ */
		var kitifySubscribeConfig = { "action": "kitify_ajax", "nonce": "c8247f9c14", "type": "POST", "data_type": "json", "is_public": "true", "ajax_url": "https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php", "sys_messages": { "invalid_mail": "Please, provide valid mail", "mailchimp": "Please, set up MailChimp API key and List ID", "internal": "Internal error. Please, try again later", "server_error": "Server error. Please, try again later", "invalid_nonce": "Invalid nonce. Please, try again later", "subscribe_success": "Success" } };
		/* ]]> */
</script>
<script type="text/javascript" id="elementor-frontend-js-before">
    /* <![CDATA[ */
		var elementorFrontendConfig = {
			"environmentMode": { "edit": false, "wpPreview": false, "isScriptDebug": false }, "i18n": { "shareOnFacebook": "Share on Facebook", "shareOnTwitter": "Share on Twitter", "pinIt": "Pin it", "download": "Download", "downloadImage": "Download image", "fullscreen": "Fullscreen", "zoom": "Zoom", "share": "Share", "playVideo": "Play Video", "previous": "Previous", "next": "Next", "close": "Close", "a11yCarouselPrevSlideMessage": "Previous slide", "a11yCarouselNextSlideMessage": "Next slide", "a11yCarouselFirstSlideMessage": "This is the first slide", "a11yCarouselLastSlideMessage": "This is the last slide", "a11yCarouselPaginationBulletMessage": "Go to slide" }, "is_rtl": false, "breakpoints": { "xs": 0, "sm": 480, "md": 768, "lg": 1025, "xl": 1440, "xxl": 1600 }, "responsive": {
				"breakpoints": { "mobile": { "label": "Mobile Portrait", "value": 767, "default_value": 767, "direction": "max", "is_enabled": true }, "mobile_extra": { "label": "Mobile Landscape", "value": 991, "default_value": 880, "direction": "max", "is_enabled": true }, "tablet": { "label": "Tablet Portrait", "value": 1024, "default_value": 1024, "direction": "max", "is_enabled": true }, "tablet_extra": { "label": "Tablet Landscape", "value": 1279, "default_value": 1200, "direction": "max", "is_enabled": true }, "laptop": { "label": "Laptop", "value": 1599, "default_value": 1366, "direction": "max", "is_enabled": true }, "widescreen": { "label": "Widescreen", "value": 2400, "default_value": 2400, "direction": "min", "is_enabled": false } },
				"hasCustomBreakpoints": true
			}, "version": "3.28.3", "is_static": false, "experimentalFeatures": { "e_font_icon_svg": true, "additional_custom_breakpoints": true, "container": true, "e_local_google_fonts": true, "theme_builder_v2": true, "nested-elements": true, "editor_v2": true, "home_screen": true }, "urls": { "assets": "https:\/\/mixtas.b-cdn.net\/wp-content\/plugins\/elementor\/assets\/", "ajaxurl": "https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php", "uploadUrl": "https:\/\/mixtas.b-cdn.net\/wp-content\/uploads" }, "nonces": { "floatingButtonsClickTracking": "1bf67367a8" }, "swiperClass": "swiper", "settings": { "page": [], "editorPreferences": [] }, "kit": { "active_breakpoints": ["viewport_mobile", "viewport_mobile_extra", "viewport_tablet", "viewport_tablet_extra", "viewport_laptop"], "viewport_mobile": 767, "viewport_mobile_extra": 991, "viewport_tablet": 1024, "viewport_tablet_extra": 1279, "viewport_laptop": 1599, "global_image_lightbox": "yes", "lightbox_enable_counter": "yes", "lightbox_enable_fullscreen": "yes", "lightbox_enable_zoom": "yes", "lightbox_enable_share": "yes", "lightbox_title_src": "title", "lightbox_description_src": "description" }, "post": { "id": 863, "title": "Home%20v3%20%E2%80%93%20Mixtas", "excerpt": "", "featuredImage": "https:\/\/mixtas.b-cdn.net\/wp-content\/uploads\/2023\/12\/blog-06-1024x683.jpg" }
		};
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/js/frontend.min87cc.js?ver=3.28.3"
    id="elementor-frontend-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/lib/isotope.pkgd.min35ee.js?ver=1759215510"
    id="jquery-isotope-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/lib/jquery.sticky.min35ee.js?ver=1759215510"
    id="kitify-sticky-js-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/motion-fx35ee.js?ver=1759215510"
    id="kitify-motion-fx-js"></script>
<script type="text/javascript" id="kitify-base-js-extra">
    /* <![CDATA[ */
		var KitifySettings = { "templateApiUrl": "https:\/\/mixtas.novaworks.net\/wp-json\/kitify-api\/v1\/elementor-template", "widgetApiUrl": "https:\/\/mixtas.novaworks.net\/wp-json\/kitify-api\/v1\/elementor-widget", "homeURL": "https:\/\/mixtas.novaworks.net\/", "ajaxurl": "https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php", "isMobile": "true", "devMode": "false", "cache_ttl": "300", "local_ttl": "86400", "themeName": "mixtas", "i18n": [], "ajaxNonce": "c8247f9c14", "useFrontAjax": "true", "isElementorAdmin": "" };
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/kitify-base35ee.js?ver=1759215510"
    id="kitify-base-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/nav-menu35ee.js?ver=1759215510"
    id="kitify-w__nav-menu-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/nova-menu35ee.js?ver=1759215510"
    id="kitify-w__nova-menu-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/toggle-sidebarbe54.js?ver=1759215532"
    id="kitify-w__toggle-sidebar-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/tabs35ee.js?ver=1759215510"
    id="kitify-w__tabs-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/subscribe-form35ee.js?ver=1759215510"
    id="kitify-w__subscribe-form-js"></script>


<script>
    window.RS_MODULES = window.RS_MODULES || {};
		window.RS_MODULES.modules = window.RS_MODULES.modules || {};
		window.RS_MODULES.waiting = window.RS_MODULES.waiting || [];
		window.RS_MODULES.defered = true;
		window.RS_MODULES.moduleWaiting = window.RS_MODULES.moduleWaiting || {};
		window.RS_MODULES.type = 'compiled';
</script>
<script type="speculationrules">
    {"prefetch":[{"source":"document","where":{"and":[{"href_matches":"\/*"},{"not":{"href_matches":["\/wp-*.php","\/wp-admin\/*","\/wp-content\/uploads\/*","\/wp-content\/*","\/wp-content\/plugins\/*","\/wp-content\/themes\/mixtas\/*","\/*\\?(.+)"]}},{"not":{"selector_matches":"a[rel~=\"nofollow\"]"}},{"not":{"selector_matches":".no-prefetch, .no-prefetch a"}}]},"eagerness":"conservative"}]}
</script>

<!-- GTM Container placement set to footer -->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TH4WGRG" height="0" width="0"
        style="display:none;visibility:hidden" aria-hidden="true"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<script>
    const lazyloadRunObserver = () => {
			const lazyloadBackgrounds = document.querySelectorAll(`.e-con.e-parent:not(.e-lazyloaded)`);
			const lazyloadBackgroundObserver = new IntersectionObserver((entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						let lazyloadBackground = entry.target;
						if (lazyloadBackground) {
							lazyloadBackground.classList.add('e-lazyloaded');
						}
						lazyloadBackgroundObserver.unobserve(entry.target);
					}
				});
			}, { rootMargin: '200px 0px 200px 0px' });
			lazyloadBackgrounds.forEach((lazyloadBackground) => {
				lazyloadBackgroundObserver.observe(lazyloadBackground);
			});
		};
		const events = [
			'DOMContentLoaded',
			'elementor/lazyload/observe',
		];
		events.forEach((event) => {
			document.addEventListener(event, lazyloadRunObserver);
		});
</script>
<link href="http://fonts.googleapis.com/css?family=Roboto:400%7COutfit:600%7CMulish:500%2C700&amp;display=swap"
    rel="stylesheet" property="stylesheet" media="all" type="text/css">

<script type='text/javascript'>
    (function () {
			var c = document.body.className;
			c = c.replace(/woocommerce-no-js/, 'woocommerce-js');
			document.body.className = c;
		})();
</script>
<script>
    if (typeof revslider_showDoubleJqueryError === "undefined") { function revslider_showDoubleJqueryError(sliderID) { console.log("You have some jquery.js library include that comes after the Slider Revolution files js inclusion."); console.log("To fix this, you can:"); console.log("1. Set 'Module General Options' -> 'Advanced' -> 'jQuery & OutPut Filters' -> 'Put JS to Body' to on"); console.log("2. Find the double jQuery.js inclusion and remove it"); return "Double Included jQuery Library"; } }
</script>
<link rel="preload" as="font" id="rs-icon-set-revicon-woff"
    href="../wp-content/plugins/revslider/sr6/assets/fonts/revicons/revicons90c6.woff?5510888" type="font/woff"
    crossorigin="anonymous" media="all" />
<link rel='stylesheet' id='wc-blocks-style-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/client/blocks/wc-blocks2656.css?ver=wc-9.7.1'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-canvas-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/kitify-canvasf54b.css?ver=1759215505'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-banner-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/bannerf54b.css?ver=1759215505'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-advanced-carousel-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/advanced-carouself54b.css?ver=1759215505'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-banner-list-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/banner-listf54b.css?ver=1759215505'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-nav-menu-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/nav-menuf54b.css?ver=1759215505'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-search-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/searchf54b.css?ver=1759215505'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-video-modal-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/video-modalf54b.css?ver=1759215505'
    type='text/css' media='all' />
<link rel='stylesheet' id='widget-social-icons-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/css/widget-social-icons.min87cc.css?ver=3.28.3'
    type='text/css' media='all' />
<link rel='stylesheet' id='e-apple-webkit-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/custom-apple-webkit.minbea4.css?ver=1743737085'
    type='text/css' media='all' />
<link rel='stylesheet' id='widget-icon-list-css'
    href='../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/custom-widget-icon-list.minbea4.css?ver=1743737085'
    type='text/css' media='all' />
<link rel='stylesheet' id='kitify-subscribe-form-css'
    href='../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/subscribe-formf54b.css?ver=1759215505'
    type='text/css' media='all' />
<link rel='stylesheet' id='rs-plugin-settings-css'
    href='../wp-content/plugins/revslider/sr6/assets/css/rs61676.css?ver=6.7.31' type='text/css' media='all' />
<style id='rs-plugin-settings-inline-css' type='text/css'>
    #rev_slider_3_1_wrapper .mixtas.tparrows {
        cursor: pointer;
        background: #fff;
        color: #222222;
        width: 60px;
        height: 60px;
        position: absolute;
        display: block;
        z-index: 1000;
        border-radius: 50%;
        box-shadow: 0px 2px 6px 0px rgba(0, 0, 0, 0.09)
    }

    #rev_slider_3_1_wrapper .mixtas.tparrows.rs-touchhover {
        background: #000000
    }

    #rev_slider_3_1_wrapper .mixtas.tparrows:before {
        font-family: 'revicons';
        font-size: 15px;
        color: #222222;
        display: block;
        line-height: 60px;
        text-align: center
    }

    #rev_slider_3_1_wrapper .mixtas.tparrows.rs-touchhover:before {
        color: #FFFFFF
    }

    #rev_slider_3_1_wrapper .mixtas.tparrows.tp-leftarrow:before {
        content: '\e824'
    }

    #rev_slider_3_1_wrapper .mixtas.tparrows.tp-rightarrow:before {
        content: '\e825'
    }

    #rev_slider_3_1_wrapper .hermes.tp-bullets {}

    #rev_slider_3_1_wrapper .hermes .tp-bullet {
        overflow: hidden;
        border-radius: 50%;
        width: 12px;
        height: 12px;
        background-color: rgba(0, 0, 0, 0);
        box-shadow: inset 0 0 0 2px #ffffff;
        -webkit-transition: background 0.3s ease;
        transition: background 0.3s ease;
        position: absolute
    }

    #rev_slider_3_1_wrapper .hermes .tp-bullet.rs-touchhover {
        background-color: rgba(0, 0, 0, 0.21)
    }

    #rev_slider_3_1_wrapper .hermes .tp-bullet:after {
        content: ' ';
        position: absolute;
        bottom: 0;
        height: 0;
        left: 0;
        width: 100%;
        background-color: #ffffff;
        box-shadow: 0 0 1px #ffffff;
        -webkit-transition: height 0.3s ease;
        transition: height 0.3s ease
    }

    #rev_slider_3_1_wrapper .hermes .tp-bullet.selected:after {
        height: 100%
    }
</style>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/yith-woocommerce-wishlist/assets/js/jquery.selectBox.min7359.js?ver=1.2.0"
    id="jquery-selectBox-js"></script>
<script type="text/javascript"
    src="../wp-content/plugins/woocommerce/assets/js/prettyPhoto/jquery.prettyPhoto.min005e.js?ver=3.1.6"
    id="prettyPhoto-js" data-wp-strategy="defer"></script>
<script type="text/javascript" id="jquery-yith-wcwl-js-extra">
    /* <![CDATA[ */
		var yith_wcwl_l10n = { "ajax_url": "\/wp-admin\/admin-ajax.php", "redirect_to_cart": "no", "yith_wcwl_button_position": "after_add_to_cart", "multi_wishlist": "", "hide_add_button": "1", "enable_ajax_loading": "", "ajax_loader_url": "https:\/\/mixtas.b-cdn.net\/wp-content\/plugins\/yith-woocommerce-wishlist\/assets\/images\/ajax-loader-alt.svg", "remove_from_wishlist_after_add_to_cart": "1", "is_wishlist_responsive": "", "time_to_close_prettyphoto": "3000", "fragments_index_glue": ".", "reload_on_found_variation": "1", "mobile_media_query": "768", "labels": { "cookie_disabled": "We are sorry, but this feature is available only if cookies on your browser are enabled.", "added_to_cart_message": "<div class=\"woocommerce-notices-wrapper\"><div class=\"woocommerce-message\" role=\"alert\">Product added to cart successfully<\/div><\/div>" }, "actions": { "add_to_wishlist_action": "add_to_wishlist", "remove_from_wishlist_action": "remove_from_wishlist", "reload_wishlist_and_adding_elem_action": "reload_wishlist_and_adding_elem", "load_mobile_action": "load_mobile", "delete_item_action": "delete_item", "save_title_action": "save_title", "save_privacy_action": "save_privacy", "load_fragments": "load_fragments" }, "nonce": { "add_to_wishlist_nonce": "54e378c625", "remove_from_wishlist_nonce": "47efc3fe29", "reload_wishlist_and_adding_elem_nonce": "2a7b7e69b5", "load_mobile_nonce": "9943d11ffb", "delete_item_nonce": "52dcfee0b6", "save_title_nonce": "7d0742e0b7", "save_privacy_nonce": "31d311c85b", "load_fragments_nonce": "66747c4b21" }, "redirect_after_ask_estimate": "", "ask_estimate_redirect_url": "https:\/\/mixtas.novaworks.net" };
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/yith-woocommerce-wishlist/assets/js/jquery.yith-wcwl.min474a.js?ver=4.4.0"
    id="jquery-yith-wcwl-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-includes/js/dist/hooks.min4fdd.js?ver=4d63a3d491d11ffd8ac6" id="wp-hooks-js">
</script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/dist/i18n.minc33c.js?ver=5e580eb46a90c2b997e6"
    id="wp-i18n-js">
</script>
<script type="text/javascript" id="wp-i18n-js-after">
    /* <![CDATA[ */
		wp.i18n.setLocaleData({ 'text direction\u0004ltr': ['ltr'] });
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/contact-form-7/includes/swv/js/index52c7.js?ver=6.0.5" id="swv-js">
</script>
<script type="text/javascript" id="contact-form-7-js-before">
    /* <![CDATA[ */
		var wpcf7 = {
			"api": {
				"root": "https:\/\/mixtas.novaworks.net\/wp-json\/",
				"namespace": "contact-form-7\/v1"
			},
			"cached": 1
		};
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/contact-form-7/includes/js/index52c7.js?ver=6.0.5"
    id="contact-form-7-js"></script>
<script type="text/javascript" src="../wp-content/plugins/revslider/sr6/assets/js/rbtools.min0c0c.js?ver=6.7.29" defer
    async id="tp-tools-js"></script>
<script type="text/javascript" src="../wp-content/plugins/revslider/sr6/assets/js/rs6.min1676.js?ver=6.7.31" defer async
    id="revmin-js"></script>
<script type="text/javascript" id="crisp-js-before">
    /* <![CDATA[ */
		window.$crisp = [];
		if (!window.CRISP_RUNTIME_CONFIG) {
			window.CRISP_RUNTIME_CONFIG = {}
		}

		if (!window.CRISP_RUNTIME_CONFIG.locale) {
			window.CRISP_RUNTIME_CONFIG.locale = 'en-us'
		}

		CRISP_WEBSITE_ID = '114c3be4-da0f-4663-b5f7-3febfccc9984';
		/* ]]> */
</script>
<script type="text/javascript" async src="../../client.crisp.chat/ldad2.js?ver=20250930" id="crisp-js"></script>
<script type="text/javascript" id="wp-api-request-js-extra">
    /* <![CDATA[ */
		var wpApiSettings = { "root": "https:\/\/mixtas.novaworks.net\/wp-json\/", "nonce": "b30a18ec1e", "versionString": "wp\/v2\/" };
		/* ]]> */
</script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/api-request.min6c2d.js?ver=6.8.2"
    id="wp-api-request-js"></script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/dist/vendor/wp-polyfill.min2c7c.js?ver=3.15.0"
    id="wp-polyfill-js">
</script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/dist/url.mind63a.js?ver=c2964167dfe2477c14ea"
    id="wp-url-js">
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-includes/js/dist/api-fetch.minc31c.js?ver=3623a576c78df404ff20" id="wp-api-fetch-js">
</script>
<script type="text/javascript" id="wp-api-fetch-js-after">
    /* <![CDATA[ */
		wp.apiFetch.use(wp.apiFetch.createRootURLMiddleware("../wp-json/index.html"));
		wp.apiFetch.nonceMiddleware = wp.apiFetch.createNonceMiddleware("b30a18ec1e");
		wp.apiFetch.use(wp.apiFetch.nonceMiddleware);
		wp.apiFetch.use(wp.apiFetch.mediaUploadMiddleware);
		wp.apiFetch.nonceEndpoint = "../wp-admin/admin-ajaxf809.html?action=rest-nonce";
		/* ]]> */
</script>
<script type="text/javascript" id="woo-variation-swatches-js-extra">
    /* <![CDATA[ */
		var woo_variation_swatches_options = { "show_variation_label": "1", "clear_on_reselect": "", "variation_label_separator": ":", "is_mobile": "", "show_variation_stock": "", "stock_label_threshold": "5", "cart_redirect_after_add": "no", "enable_ajax_add_to_cart": "yes", "cart_url": "https:\/\/mixtas.novaworks.net\/cart\/", "is_cart": "" };
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woo-variation-swatches/assets/js/frontend.mine98f.js?ver=1743737055"
    id="woo-variation-swatches-js"></script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/imagesloaded.minbb93.js?ver=5.0.0"
    id="imagesloaded-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/foundation/dist/js/foundation.minf54b.js?ver=1759215505"
    id="foundation-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/cookies/js.cookief54b.js?ver=1759215505"
    id="cookies-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/jquery-visible/jquery.visiblef54b.js?ver=1759215505"
    id="jquery-visible-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/scrollTo/jquery.scrollTo.minf54b.js?ver=1759215505"
    id="scrollTo-js"></script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/hoverIntent.min3e5a.js?ver=1.10.2"
    id="hoverIntent-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/jquery.perfect-scrollbar.minceb2.js?ver=0.7.1"
    id="perfect-scrollbar-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/mojs/mo.minf54b.js?ver=1759215505" id="mojs-js">
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/anime/anime.minf54b.js?ver=1759215505"
    id="anime-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/lib/swiper/v8/swiper.min94a4.js?ver=8.4.5"
    id="swiper-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/headroom.js/headroom.minf54b.js?ver=1759215505"
    id="headroom-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/slick/slick.minf54b.js?ver=1759215505"
    id="slick-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/sticky-kit/jquery.sticky-kit.minf54b.js?ver=1759215505"
    id="sticky-kit-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/jquery-loading-overlay/loadingoverlay.minf54b.js?ver=1759215505"
    id="jquery-loading-overlay-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/readmore/readmorec64e.js?ver=1.1.1"
    id="readmore-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/isotope/isotope.pkgd.minc64e.js?ver=1.1.1"
    id="isotope-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/video.popupc64e.js?ver=1.1.1"
    id="video-popup-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/animatedModal.js/animatedModalc64e.js?ver=1.1.1"
    id="animatedModal-js"></script>
<script type="text/javascript" id="nova-app-js-extra">
    /* <![CDATA[ */
		var nova_js_var = { "js_path": "https:\/\/mixtas.b-cdn.net\/wp-content\/themes\/mixtas\/assets\/js\/vendor\/", "js_min": "1", "site_preloader": "", "topbar_progress": "", "select_placeholder": "Choose an option", "blog_pagination_type": "default", "load_more_btn": "Load more", "read_more_btn": "Read more", "read_less_btn": "Read less", "enable_header_sticky": "0", "shop_pagination_type": "infinite_scroll", "accent_color": "#000000", "shop_display": "grid", "popup_show_after": "2000", "product_image_zoom": "1", "is_customize_preview": "" };
		/* ]]> */
</script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/js/appf54b.js?ver=1759215505"
    id="nova-app-js">
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/sourcebuster/sourcebuster.min04d4.js?ver=9.7.1"
    id="sourcebuster-js-js"></script>
<script type="text/javascript" id="wc-order-attribution-js-extra">
    /* <![CDATA[ */
		var wc_order_attribution = { "params": { "lifetime": 1.0e-5, "session": 30, "base64": false, "ajaxurl": "https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php", "prefix": "wc_order_attribution_", "allowTracking": true }, "fields": { "source_type": "current.typ", "referrer": "current_add.rf", "utm_campaign": "current.cmp", "utm_source": "current.src", "utm_medium": "current.mdm", "utm_content": "current.cnt", "utm_id": "current.id", "utm_term": "current.trm", "utm_source_platform": "current.plt", "utm_creative_format": "current.fmt", "utm_marketing_tactic": "current.tct", "session_entry": "current_add.ep", "session_start_time": "current_add.fd", "session_pages": "session.pgs", "session_count": "udata.vst", "user_agent": "udata.uag" } };
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/frontend/order-attribution.min04d4.js?ver=9.7.1"
    id="wc-order-attribution-js"></script>
<script type="text/javascript" id="wc-cart-fragments-js-extra">
    /* <![CDATA[ */
		var wc_cart_fragments_params = { "ajax_url": "\/wp-admin\/admin-ajax.php", "wc_ajax_url": "\/?wc-ajax=%%endpoint%%", "cart_hash_key": "wc_cart_hash_5d3227775be22d377568ebad71c4a81b", "fragment_name": "wc_fragments_5d3227775be22d377568ebad71c4a81b", "request_timeout": "5000" };
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.min04d4.js?ver=9.7.1"
    id="wc-cart-fragments-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/js/webpack.runtime.min87cc.js?ver=3.28.3"
    id="elementor-webpack-runtime-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/js/frontend-modules.min87cc.js?ver=3.28.3"
    id="elementor-frontend-modules-js"></script>
<script type="text/javascript" src="../../mixtas.b-cdn.net/wp-includes/js/jquery/ui/core.minb37e.js?ver=1.13.3"
    id="jquery-ui-core-js"></script>
<script type="text/javascript" id="elementor-frontend-js-extra">
    /* <![CDATA[ */
		var kitifySubscribeConfig = { "action": "kitify_ajax", "nonce": "c8247f9c14", "type": "POST", "data_type": "json", "is_public": "true", "ajax_url": "https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php", "sys_messages": { "invalid_mail": "Please, provide valid mail", "mailchimp": "Please, set up MailChimp API key and List ID", "internal": "Internal error. Please, try again later", "server_error": "Server error. Please, try again later", "invalid_nonce": "Invalid nonce. Please, try again later", "subscribe_success": "Success" } };
		/* ]]> */
</script>
<script type="text/javascript" id="elementor-frontend-js-before">
    /* <![CDATA[ */
		var elementorFrontendConfig = {
			"environmentMode": { "edit": false, "wpPreview": false, "isScriptDebug": false }, "i18n": { "shareOnFacebook": "Share on Facebook", "shareOnTwitter": "Share on Twitter", "pinIt": "Pin it", "download": "Download", "downloadImage": "Download image", "fullscreen": "Fullscreen", "zoom": "Zoom", "share": "Share", "playVideo": "Play Video", "previous": "Previous", "next": "Next", "close": "Close", "a11yCarouselPrevSlideMessage": "Previous slide", "a11yCarouselNextSlideMessage": "Next slide", "a11yCarouselFirstSlideMessage": "This is the first slide", "a11yCarouselLastSlideMessage": "This is the last slide", "a11yCarouselPaginationBulletMessage": "Go to slide" }, "is_rtl": false, "breakpoints": { "xs": 0, "sm": 480, "md": 768, "lg": 1025, "xl": 1440, "xxl": 1600 }, "responsive": {
				"breakpoints": { "mobile": { "label": "Mobile Portrait", "value": 767, "default_value": 767, "direction": "max", "is_enabled": true }, "mobile_extra": { "label": "Mobile Landscape", "value": 991, "default_value": 880, "direction": "max", "is_enabled": true }, "tablet": { "label": "Tablet Portrait", "value": 1024, "default_value": 1024, "direction": "max", "is_enabled": true }, "tablet_extra": { "label": "Tablet Landscape", "value": 1279, "default_value": 1200, "direction": "max", "is_enabled": true }, "laptop": { "label": "Laptop", "value": 1599, "default_value": 1366, "direction": "max", "is_enabled": true }, "widescreen": { "label": "Widescreen", "value": 2400, "default_value": 2400, "direction": "min", "is_enabled": false } },
				"hasCustomBreakpoints": true
			}, "version": "3.28.3", "is_static": false, "experimentalFeatures": { "e_font_icon_svg": true, "additional_custom_breakpoints": true, "container": true, "e_local_google_fonts": true, "theme_builder_v2": true, "nested-elements": true, "editor_v2": true, "home_screen": true }, "urls": { "assets": "https:\/\/mixtas.b-cdn.net\/wp-content\/plugins\/elementor\/assets\/", "ajaxurl": "https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php", "uploadUrl": "https:\/\/mixtas.b-cdn.net\/wp-content\/uploads" }, "nonces": { "floatingButtonsClickTracking": "1bf67367a8" }, "swiperClass": "swiper", "settings": { "page": [], "editorPreferences": [] }, "kit": { "active_breakpoints": ["viewport_mobile", "viewport_mobile_extra", "viewport_tablet", "viewport_tablet_extra", "viewport_laptop"], "viewport_mobile": 767, "viewport_mobile_extra": 991, "viewport_tablet": 1024, "viewport_tablet_extra": 1279, "viewport_laptop": 1599, "global_image_lightbox": "yes", "lightbox_enable_counter": "yes", "lightbox_enable_fullscreen": "yes", "lightbox_enable_zoom": "yes", "lightbox_enable_share": "yes", "lightbox_title_src": "title", "lightbox_description_src": "description" }, "post": { "id": 917, "title": "Home%20v2%20%E2%80%93%20Mixtas", "excerpt": "", "featuredImage": false }
		};
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/js/frontend.min87cc.js?ver=3.28.3"
    id="elementor-frontend-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/lib/isotope.pkgd.min1c6a.js?ver=1759215507"
    id="jquery-isotope-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/lib/jquery.sticky.min1c6a.js?ver=1759215507"
    id="kitify-sticky-js-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/motion-fx1c6a.js?ver=1759215507"
    id="kitify-motion-fx-js"></script>
<script type="text/javascript" id="kitify-base-js-extra">
    /* <![CDATA[ */
		var KitifySettings = { "templateApiUrl": "https:\/\/mixtas.novaworks.net\/wp-json\/kitify-api\/v1\/elementor-template", "widgetApiUrl": "https:\/\/mixtas.novaworks.net\/wp-json\/kitify-api\/v1\/elementor-widget", "homeURL": "https:\/\/mixtas.novaworks.net\/", "ajaxurl": "https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php", "isMobile": "false", "devMode": "false", "cache_ttl": "300", "local_ttl": "86400", "themeName": "mixtas", "i18n": [], "ajaxNonce": "c8247f9c14", "useFrontAjax": "true", "isElementorAdmin": "" };
		/* ]]> */
</script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/kitify-base1c6a.js?ver=1759215507"
    id="kitify-base-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/nav-menu1c6a.js?ver=1759215507"
    id="kitify-w__nav-menu-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/nova-menu1c6a.js?ver=1759215507"
    id="kitify-w__nova-menu-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/subscribe-form1c6a.js?ver=1759215507"
    id="kitify-w__subscribe-form-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/fancybox/jquery.fancybox.minf8ee.js?ver=3.5.7"
    id="fancybox-js"></script>
<script type="text/javascript"
    src="../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/video-modal1c6a.js?ver=1759215507"
    id="kitify-w__video-modal-js"></script>
<script id="rs-initialisation-scripts">
    var tpj = jQuery;

		var revapi3;

		if (window.RS_MODULES === undefined) window.RS_MODULES = {};
		if (RS_MODULES.modules === undefined) RS_MODULES.modules = {};
		RS_MODULES.modules["revslider31"] = {
			once: RS_MODULES.modules["revslider31"] !== undefined ? RS_MODULES.modules["revslider31"].once : undefined, init: function () {
				window.revapi3 = window.revapi3 === undefined || window.revapi3 === null || window.revapi3.length === 0 ? document.getElementById("rev_slider_3_1") : window.revapi3;
				if (window.revapi3 === null || window.revapi3 === undefined || window.revapi3.length == 0) { window.revapi3initTry = window.revapi3initTry === undefined ? 0 : window.revapi3initTry + 1; if (window.revapi3initTry < 20) requestAnimationFrame(function () { RS_MODULES.modules["revslider31"].init() }); return; }
				window.revapi3 = jQuery(window.revapi3);
				if (window.revapi3.revolution == undefined) { revslider_showDoubleJqueryError("rev_slider_3_1"); return; }
				revapi3.revolutionInit({
					revapi: "revapi3",
					DPR: "dpr",
					sliderLayout: "fullwidth",
					visibilityLevels: "1240,1024,778,480",
					gridwidth: "1440,1024,778,480",
					gridheight: "920,600,500,300",
					lazyType: "smart",
					perspective: 600,
					perspectiveType: "global",
					editorheight: "920,600,500,300",
					responsiveLevels: "1240,1024,778,480",
					progressBar: { disableProgressBar: true },
					navigation: {
						wheelCallDelay: 1000,
						onHoverStop: false,
						arrows: {
							enable: true,
							style: "mixtas",
							hide_onmobile: true,
							hide_under: 778,
							left: {
								h_offset: 30
							},
							right: {
								h_offset: 30
							}
						},
						bullets: {
							enable: true,
							tmp: "",
							style: "hermes",
							hide_over: "778px"
						}
					},
					viewPort: {
						global: true,
						globalDist: "-200px",
						enable: false
					},
					fallbacks: {
						allowHTML5AutoPlayOnAndroid: true
					},
				});

			}
		} // End of RevInitScript

		if (window.RS_MODULES.checkMinimal !== undefined) { window.RS_MODULES.checkMinimal(); };
</script>
<script>
document.addEventListener('click', function (e) {
  const a = e.target.closest('.category-filter a'); // .category-filter = ul bọc danh mục
  if (!a) return;
  const li = a.closest('li');
  if (!li) return;
  li.parentElement.querySelectorAll('li.chosen').forEach(el => el.classList.remove('chosen'));
  li.classList.add('chosen'); // tô sáng ngay
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.novaapf-active-filters');
    document.querySelectorAll('.category-filter a').forEach(a => {
        a.addEventListener('click', () => {
            const name = a.querySelector('.name').textContent.trim();
            const href = a.getAttribute('href');
            container.innerHTML = `
                <a href="${href}" data-key="product-cata">${name}</a>
                <a href="/shop" class="reset">Reset</a>
            `;
        });
    });
});
</script>

</body>

<!-- Mirrored from mixtas.novaworks.net/home-v2/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Sep 2025 12:52:16 GMT -->