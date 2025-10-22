@extends('master')
@section('content')
  

        <link rel="stylesheet" id="elementor-post-70-css"
            href="https://mixtas.b-cdn.net/wp-content/uploads/elementor/css/post-70.css?ver=1745088068" type="text/css"
            media="all">
        <link rel="stylesheet" id="elementor-post-459-css"
            href="https://mixtas.b-cdn.net/wp-content/uploads/elementor/css/post-459.css?ver=1743737313" type="text/css"
            media="all">

        <script type="text/javascript" src="https://mixtas.b-cdn.net/wp-includes/js/jquery/jquery.min.js?ver=3.7.1"
            id="jquery-core-js"></script>
        <script type="text/javascript" src="https://mixtas.b-cdn.net/wp-includes/js/jquery/jquery-migrate.min.js?ver=3.4.1"
            id="jquery-migrate-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.min.js?ver=2.7.0-wc.9.7.1"
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
            src="https://mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart.min.js?ver=9.7.1"
            id="wc-add-to-cart-js" defer="defer" data-wp-strategy="defer"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/js-cookie/js.cookie.min.js?ver=2.1.4-wc.9.7.1"
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
            src="https://mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/frontend/woocommerce.min.js?ver=9.7.1"
            id="woocommerce-js" defer="defer" data-wp-strategy="defer"></script>
        <script type="text/javascript" src="https://mixtas.b-cdn.net/wp-includes/js/underscore.min.js?ver=1.13.7"
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
        <script type="text/javascript" src="https://mixtas.b-cdn.net/wp-includes/js/wp-util.min.js?ver=6.8.3" id="wp-util-js">
        </script>
        <script type="text/javascript" id="wp-statistics-tracker-js-extra">
            /* <![CDATA[ */
            var WP_Statistics_Tracker_Object = {
                "hitRequestUrl": "https:\/\/mixtas.novaworks.net\/wp-json\/wp-statistics\/v2\/hit?wp_statistics_hit_rest=yes&track_all=1&current_page_type=page&current_page_id=70&search_query&page_uri=L2NvbnRhY3QtdXMv",
                "keepOnlineRequestUrl": "https:\/\/mixtas.novaworks.net\/wp-json\/wp-statistics\/v2\/online?wp_statistics_hit_rest=yes&track_all=1&current_page_type=page&current_page_id=70&search_query&page_uri=L2NvbnRhY3QtdXMv",
                "option": {
                    "dntEnabled": "1",
                    "cacheCompatibility": "1"
                }
            };
            /* ]]> */
        </script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/wp-statistics/assets/js/tracker.js?ver=6.8.3"
            id="wp-statistics-tracker-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/select2/select2.full.min.js?ver=4.0.3-wc.9.7.1"
            id="select2-js" defer="defer" data-wp-strategy="defer"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/flexslider/jquery.flexslider.min.js?ver=2.7.2-wc.9.7.1"
            id="flexslider-js" defer="defer" data-wp-strategy="defer"></script>
        
        <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/62/9c/intl/vi_ALL/common.js"></script>
        <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/62/9c/intl/vi_ALL/util.js"></script>
        <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/62/9c/intl/vi_ALL/map.js"></script>
        <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/62/9c/intl/vi_ALL/marker.js"></script>
        <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/62/9c/intl/vi_ALL/infowindow.js"></script>
        <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/62/9c/intl/vi_ALL/log.js"></script>
        <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/62/9c/intl/vi_ALL/onion.js"></script>
        <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i15!2i29576!3i20106!1m4!1m3!1i15!2i29576!3i20107!1m4!1m3!1i15!2i29577!3i20106!1m4!1m3!1i15!2i29577!3i20107!1m4!1m3!1i15!2i29578!3i20106!1m4!1m3!1i15!2i29578!3i20107!1m4!1m3!1i15!2i29576!3i20108!1m4!1m3!1i15!2i29576!3i20109!1m4!1m3!1i15!2i29577!3i20108!1m4!1m3!1i15!2i29577!3i20109!1m4!1m3!1i15!2i29578!3i20108!1m4!1m3!1i15!2i29578!3i20109!2m3!1e0!2sm!3i753513404!3m18!2svi-VN!3sUS!5e18!12m5!1e68!2m2!1sset!2sRoadmap!4e2!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjZ8cy5lOmd8cC5jOiNlOWU5ZTl8cC5sOjE3LHMudDo1fHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMCxzLnQ6NDl8cy5lOmcuZnxwLmM6I2ZmZmZmZnxwLmw6MTcscy50OjQ5fHMuZTpnLnN8cC5jOiNmZmZmZmZ8cC5sOjI5fHAudzowLjIscy50OjUwfHMuZTpnfHAuYzojZmZmZmZmfHAubDoxOCxzLnQ6NTF8cy5lOmd8cC5jOiNmZmZmZmZ8cC5sOjE2LHMudDoyfHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMSxzLnQ6NDB8cy5lOmd8cC5jOiNkZWRlZGV8cC5sOjIxLHMuZTpsLnQuc3xwLnY6b258cC5jOiNmZmZmZmZ8cC5sOjE2LHMuZTpsLnQuZnxwLnM6MzZ8cC5jOiMzMzMzMzN8cC5sOjQwLHMuZTpsLml8cC52Om9mZixzLnQ6NHxzLmU6Z3xwLmM6I2YyZjJmMnxwLmw6MTkscy50OjF8cy5lOmcuZnxwLmM6I2ZlZmVmZXxwLmw6MjAscy50OjF8cy5lOmcuc3xwLmM6I2ZlZmVmZXxwLmw6MTd8cC53OjEuMg!4e3!12m1!5b1!23i46991212!23i47054750&amp;callback=_xdc_._iql04i&amp;key=AIzaSyDH-rtpwvyMwHPW0joNQHm5te6FE7DOk-U&amp;token=47629">
        </script>
        <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/62/9c/intl/vi_ALL/controls.js"></script>
    </head>

    <body
        class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-70 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-70 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active kitify--enabled kitify--js-ready body-loaded e--ua-blink e--ua-chrome e--ua-webkit"
        data-elementor-device-mode="laptop">
        <div class="site-wrapper">

            <div class="kitify-site-wrapper elementor-459kitify">
               @include('layouts.header')
                <div id="site-content" class="site-content-wrapper">
                    <div data-elementor-type="wp-page" data-elementor-id="70" class="elementor elementor-70">
                        <div class="elementor-element elementor-element-06123e3 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent e-lazyloaded"
                            data-id="06123e3" data-element_type="container">
                            <div class="e-con-inner" style="--kitify-section-width: 1425px;">
                                <div class="elementor-element elementor-element-7ed7dea e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="7ed7dea" data-element_type="container">
                                    <div class="e-con-inner">
                                        <div class="elementor-element elementor-element-9e1a2bf kitify-breadcrumbs-page-title-yes kitify-breadcrumbs-align-center elementor-widget kitify elementor-kitify-breadcrumbs"
                                            data-id="9e1a2bf" data-element_type="widget"
                                            data-widget_type="kitify-breadcrumbs.default">
                                            <div class="elementor-widget-container">

                                                <div class="kitify-breadcrumbs">
                                                    <h3 class="kitify-breadcrumbs__title">Contact Us</h3>
                                                    <div class="kitify-breadcrumbs__content">
                                                        <div class="kitify-breadcrumbs__wrap">
                                                            <div class="kitify-breadcrumbs__item"><a
                                                                    href="https://mixtas.novaworks.net/"
                                                                    class="kitify-breadcrumbs__item-link is-home"
                                                                    rel="home" title="Home">Home</a></div>
                                                            <div class="kitify-breadcrumbs__item">
                                                                <div class="kitify-breadcrumbs__item-sep"><span>/</span>
                                                                </div>
                                                            </div>
                                                            <div class="kitify-breadcrumbs__item"><span
                                                                    class="kitify-breadcrumbs__item-target">Contact
                                                                    Us</span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-d257c78 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent e-lazyloaded"
                            data-id="d257c78" data-element_type="container">
                            <div class="e-con-inner" style="--kitify-section-width: 1225px;">
                                <div class="elementor-element elementor-element-77f340c e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="77f340c" data-element_type="container">
                                    <div class="elementor-element elementor-element-c997bcd elementor-view-stacked elementor-shape-circle elementor-position-top elementor-mobile-position-top elementor-widget elementor-widget-icon-box"
                                        data-id="c997bcd" data-element_type="widget" data-widget_type="icon-box.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-icon-box-wrapper">

                                                <div class="elementor-icon-box-icon">
                                                    <span class="elementor-icon">
                                                        <i aria-hidden="true" class="dlicon location_pin"></i> </span>
                                                </div>

                                                <div class="elementor-icon-box-content">

                                                    <h3 class="elementor-icon-box-title">
                                                        <span>
                                                            Store Address </span>
                                                    </h3>

                                                    <p class="elementor-icon-box-description">
                                                        PO Box 16122 Collins Street West Victoria 8007 Australia </p>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-f0c1729 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="f0c1729" data-element_type="container">
                                    <div class="elementor-element elementor-element-5e6d30c elementor-view-stacked elementor-shape-circle elementor-position-top elementor-mobile-position-top elementor-widget elementor-widget-icon-box"
                                        data-id="5e6d30c" data-element_type="widget" data-widget_type="icon-box.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-icon-box-wrapper">

                                                <div class="elementor-icon-box-icon">
                                                    <span class="elementor-icon">
                                                        <i aria-hidden="true" class="novaicon novaicon-phone-call-2"></i>
                                                    </span>
                                                </div>

                                                <div class="elementor-icon-box-content">

                                                    <h3 class="elementor-icon-box-title">
                                                        <span>
                                                            Call Info </span>
                                                    </h3>

                                                    <p class="elementor-icon-box-description">
                                                        Open a chat or give us call at <br>
                                                        <strong>+61 3 8376 6284</strong>
                                                    </p>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-b066443 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="b066443" data-element_type="container">
                                    <div class="elementor-element elementor-element-9611cef elementor-view-stacked elementor-shape-circle elementor-position-top elementor-mobile-position-top elementor-widget elementor-widget-icon-box"
                                        data-id="9611cef" data-element_type="widget" data-widget_type="icon-box.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-icon-box-wrapper">

                                                <div class="elementor-icon-box-icon">
                                                    <span class="elementor-icon">
                                                        <i aria-hidden="true" class="dlicon ui-1_email-83"></i> </span>
                                                </div>

                                                <div class="elementor-icon-box-content">

                                                    <h3 class="elementor-icon-box-title">
                                                        <span>
                                                            Email Support </span>
                                                    </h3>

                                                    <p class="elementor-icon-box-description">
                                                        Sent mail to<br>
                                                        <a href="mailto:support@mixtas.com">support@mixtas.com</a>
                                                    </p>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-c26e49b e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="c26e49b" data-element_type="container">
                                    <div class="elementor-element elementor-element-7de3199 elementor-view-stacked elementor-shape-circle elementor-position-top elementor-mobile-position-top elementor-widget elementor-widget-icon-box"
                                        data-id="7de3199" data-element_type="widget" data-widget_type="icon-box.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-icon-box-wrapper">

                                                <div class="elementor-icon-box-icon">
                                                    <span class="elementor-icon">
                                                        <i aria-hidden="true" class="novaicon novaicon-b-chat"></i>
                                                    </span>
                                                </div>

                                                <div class="elementor-icon-box-content">

                                                    <h3 class="elementor-icon-box-title">
                                                        <span>
                                                            Live Support </span>
                                                    </h3>

                                                    <p class="elementor-icon-box-description">
                                                        Live chat service<br>
                                                        <a href="https://www.livechat.com/">https://www.livechat.com</a>
                                                    </p>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-57766e8 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent e-lazyloaded"
                            data-id="57766e8" data-element_type="container">
                            <div class="e-con-inner" style="--kitify-section-width: 1225px;">
                                <div class="elementor-element elementor-element-758ed7c e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="758ed7c" data-element_type="container">
                                    <div class="elementor-element elementor-element-84f145e elementor-widget elementor-widget-heading"
                                        data-id="84f145e" data-element_type="widget" data-widget_type="heading.default">
                                        <div class="elementor-widget-container">
                                            <h2 class="elementor-heading-title elementor-size-default">get in touch</h2>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-2943964 elementor-widget kitify elementor-kitify-contactform7"
                                        data-id="2943964" data-element_type="widget"
                                        data-widget_type="kitify-contactform7.default">
                                        <div class="elementor-widget-container">

                                            <div class="wpcf7" id="wpcf7-f13-p70-o1" lang="en-US" dir="ltr"
                                                data-wpcf7-id="13">
                                                <div class="screen-reader-response">
                                                    <p role="status" aria-live="polite" aria-atomic="true"></p>
                                                    <ul></ul>
                                                </div>
                                                <form action="/contact-us/#wpcf7-f13-p70-o1" method="post"
                                                    class="wpcf7-form init" aria-label="Contact form"
                                                    novalidate="novalidate" data-status="init">
                                                    <div style="display: none;">
                                                        <input type="hidden" name="_wpcf7" value="13">
                                                        <input type="hidden" name="_wpcf7_version" value="6.0.5">
                                                        <input type="hidden" name="_wpcf7_locale" value="en_US">
                                                        <input type="hidden" name="_wpcf7_unit_tag"
                                                            value="wpcf7-f13-p70-o1">
                                                        <input type="hidden" name="_wpcf7_container_post"
                                                            value="70">
                                                        <input type="hidden" name="_wpcf7_posted_data_hash"
                                                            value="">
                                                    </div>
                                                    <p><span class="wpcf7-form-control-wrap" data-name="your-name"><input
                                                                size="40" maxlength="400"
                                                                class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                                autocomplete="name" aria-required="true"
                                                                aria-invalid="false" value="Your Name" type="text"
                                                                name="your-name"></span><br>
                                                        <span class="wpcf7-form-control-wrap"
                                                            data-name="your-email"><input size="40" maxlength="400"
                                                                class="wpcf7-form-control wpcf7-email wpcf7-validates-as-required wpcf7-text wpcf7-validates-as-email"
                                                                autocomplete="email" aria-required="true"
                                                                aria-invalid="false" value="Your email" type="email"
                                                                name="your-email"></span><br>
                                                        <span class="wpcf7-form-control-wrap"
                                                            data-name="your-subject"><input size="40"
                                                                maxlength="400"
                                                                class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                                aria-required="true" aria-invalid="false" value="Subject"
                                                                type="text" name="your-subject"></span><br>
                                                        <span class="wpcf7-form-control-wrap" data-name="your-message">
                                                            <textarea cols="40" rows="10" maxlength="2000" class="wpcf7-form-control wpcf7-textarea"
                                                                aria-invalid="false" name="your-message">Your message (optional)</textarea>
                                                        </span><br>
                                                        <input class="wpcf7-form-control wpcf7-submit has-spinner"
                                                            type="submit" value="Send Message"><span
                                                            class="wpcf7-spinner"></span>
                                                    </p>
                                                    <div class="wpcf7-response-output" aria-hidden="true"></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-4a316ad e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="4a316ad" data-element_type="container">
                                    <div class="elementor-element elementor-element-9c81281 elementor-widget kitify elementor-kitify-google-maps"
                                        data-id="9c81281" data-element_type="widget"
                                        data-widget_type="kitify-google-maps.default">
                                        <div class="elementor-widget-container">
                                            <div class="kitify-gmap"
                                                data-init="{&quot;center&quot;:{&quot;lat&quot;:-37.8205727,&quot;lng&quot;:144.9487173},&quot;zoom&quot;:15,&quot;scrollwheel&quot;:false,&quot;zoomControl&quot;:true,&quot;fullscreenControl&quot;:true,&quot;streetViewControl&quot;:true,&quot;mapTypeControl&quot;:true,&quot;styles&quot;:[{&quot;featureType&quot;:&quot;water&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#e9e9e9&quot;},{&quot;lightness&quot;:17}]},{&quot;featureType&quot;:&quot;landscape&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#f5f5f5&quot;},{&quot;lightness&quot;:20}]},{&quot;featureType&quot;:&quot;road.highway&quot;,&quot;elementType&quot;:&quot;geometry.fill&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:17}]},{&quot;featureType&quot;:&quot;road.highway&quot;,&quot;elementType&quot;:&quot;geometry.stroke&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:29},{&quot;weight&quot;:0.2}]},{&quot;featureType&quot;:&quot;road.arterial&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:18}]},{&quot;featureType&quot;:&quot;road.local&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:16}]},{&quot;featureType&quot;:&quot;poi&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#f5f5f5&quot;},{&quot;lightness&quot;:21}]},{&quot;featureType&quot;:&quot;poi.park&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#dedede&quot;},{&quot;lightness&quot;:21}]},{&quot;elementType&quot;:&quot;labels.text.stroke&quot;,&quot;stylers&quot;:[{&quot;visibility&quot;:&quot;on&quot;},{&quot;color&quot;:&quot;#ffffff&quot;},{&quot;lightness&quot;:16}]},{&quot;elementType&quot;:&quot;labels.text.fill&quot;,&quot;stylers&quot;:[{&quot;saturation&quot;:36},{&quot;color&quot;:&quot;#333333&quot;},{&quot;lightness&quot;:40}]},{&quot;elementType&quot;:&quot;labels.icon&quot;,&quot;stylers&quot;:[{&quot;visibility&quot;:&quot;off&quot;}]},{&quot;featureType&quot;:&quot;transit&quot;,&quot;elementType&quot;:&quot;geometry&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#f2f2f2&quot;},{&quot;lightness&quot;:19}]},{&quot;featureType&quot;:&quot;administrative&quot;,&quot;elementType&quot;:&quot;geometry.fill&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#fefefe&quot;},{&quot;lightness&quot;:20}]},{&quot;featureType&quot;:&quot;administrative&quot;,&quot;elementType&quot;:&quot;geometry.stroke&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#fefefe&quot;},{&quot;lightness&quot;:17},{&quot;weight&quot;:1.2}]}]}"
                                                data-pins="[{&quot;position&quot;:{&quot;lat&quot;:-37.8205727,&quot;lng&quot;:144.9487173},&quot;desc&quot;:&quot;PO Box 16122 Collins Street West Victoria 8007 Australia&quot;,&quot;state&quot;:&quot;visible&quot;,&quot;image&quot;:&quot;https:\/\/mixtas.novaworks.net\/wp-content\/uploads\/2023\/12\/pin.svg&quot;}]"
                                                style="position: relative; overflow: hidden;">
                                                <div
                                                    style="height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);">
                                                    <div><button draggable="false" aria-label="Phím tắt" title="Phím tắt"
                                                            type="button"
                                                            style="background: none transparent; display: block; border: none; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: absolute; cursor: pointer; user-select: none; z-index: 1000002; outline-offset: 3px; right: 0px; bottom: 0px; transform: translateX(100%);"></button>
                                                    </div>
                                                    <div tabindex="0" aria-label="Bản đồ" aria-roledescription="bản đồ"
                                                        role="region"
                                                        aria-describedby="C7855EE4-230E-45F9-9D97-D0BCC2E1416D"
                                                        style="position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px;">
                                                        <div id="C7855EE4-230E-45F9-9D97-D0BCC2E1416D"
                                                            style="display: none;">
                                                            <div class="LGLeeN-keyboard-shortcuts-view">
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><kbd aria-label="Mũi tên trái">←</kbd></td>
                                                                            <td aria-label="Di chuyển sang trái.">Di chuyển
                                                                                sang trái</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><kbd aria-label="Mũi tên phải">→</kbd></td>
                                                                            <td aria-label="Di chuyển sang phải.">Di chuyển
                                                                                sang phải</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><kbd aria-label="Mũi tên lên">↑</kbd></td>
                                                                            <td aria-label="Di chuyển lên.">Di chuyển lên
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><kbd aria-label="Mũi tên xuống">↓</kbd>
                                                                            </td>
                                                                            <td aria-label="Di chuyển xuống.">Di chuyển
                                                                                xuống</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><kbd>+</kbd></td>
                                                                            <td aria-label="Phóng to.">Phóng to</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><kbd>-</kbd></td>
                                                                            <td aria-label="Thu nhỏ.">Thu nhỏ</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><kbd>Di chuyển lên trên</kbd></td>
                                                                            <td aria-label="Di chuyển sang trái 75%.">Di
                                                                                chuyển sang trái 75%</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><kbd>Di chuyển xuống dưới</kbd></td>
                                                                            <td aria-label="Di chuyển sang phải 75%.">Di
                                                                                chuyển sang phải 75%</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><kbd>Di chuyển lên</kbd></td>
                                                                            <td aria-label="Di chuyển lên trên 75%.">Di
                                                                                chuyển lên trên 75%</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><kbd>Di chuyển xuống</kbd></td>
                                                                            <td aria-label="Di chuyển xuống dưới 75%.">Di
                                                                                chuyển xuống dưới 75%</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="gm-style"
                                                        style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px;">
                                                        <div
                                                            style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; cursor: url(&quot;https://maps.gstatic.com/mapfiles/openhand_8_8.cur&quot;), default; touch-action: pan-x pan-y;">
                                                            <div
                                                                style="z-index: 1; position: absolute; left: 50%; top: 50%; width: 100%; will-change: transform; transform: translate(0px, 0px);">
                                                                <div
                                                                    style="position: absolute; left: 0px; top: 0px; z-index: 100; width: 100%;">
                                                                    <div
                                                                        style="position: absolute; left: 0px; top: 0px; z-index: 0;">
                                                                        <div
                                                                            style="position: absolute; z-index: 985; transform: matrix(1, 0, 0, 1, -142, -190);">
                                                                            <div
                                                                                style="position: absolute; left: 0px; top: 256px; width: 256px; height: 256px;">
                                                                                <div style="width: 256px; height: 256px;">
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                style="position: absolute; left: -256px; top: 256px; width: 256px; height: 256px;">
                                                                                <div style="width: 256px; height: 256px;">
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                style="position: absolute; left: -256px; top: 0px; width: 256px; height: 256px;">
                                                                                <div style="width: 256px; height: 256px;">
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px;">
                                                                                <div style="width: 256px; height: 256px;">
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                style="position: absolute; left: 256px; top: 0px; width: 256px; height: 256px;">
                                                                                <div style="width: 256px; height: 256px;">
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                style="position: absolute; left: 256px; top: 256px; width: 256px; height: 256px;">
                                                                                <div style="width: 256px; height: 256px;">
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                style="position: absolute; left: 256px; top: 512px; width: 256px; height: 256px;">
                                                                                <div style="width: 256px; height: 256px;">
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                style="position: absolute; left: 0px; top: 512px; width: 256px; height: 256px;">
                                                                                <div style="width: 256px; height: 256px;">
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                style="position: absolute; left: -256px; top: 512px; width: 256px; height: 256px;">
                                                                                <div style="width: 256px; height: 256px;">
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                style="position: absolute; left: -256px; top: -256px; width: 256px; height: 256px;">
                                                                                <div style="width: 256px; height: 256px;">
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                style="position: absolute; left: 0px; top: -256px; width: 256px; height: 256px;">
                                                                                <div style="width: 256px; height: 256px;">
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                style="position: absolute; left: 256px; top: -256px; width: 256px; height: 256px;">
                                                                                <div style="width: 256px; height: 256px;">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    style="position: absolute; left: 0px; top: 0px; z-index: 101; width: 100%;">
                                                                </div>
                                                                <div
                                                                    style="position: absolute; left: 0px; top: 0px; z-index: 102; width: 100%;">
                                                                </div>
                                                                <div
                                                                    style="position: absolute; left: 0px; top: 0px; z-index: 103; width: 100%;">
                                                                    <div
                                                                        style="position: absolute; left: 0px; top: 0px; z-index: -1;">
                                                                        <div
                                                                            style="position: absolute; z-index: 985; transform: matrix(1, 0, 0, 1, -142, -190);">
                                                                            <div
                                                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 0px; top: 256px;">
                                                                            </div>
                                                                            <div
                                                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -256px; top: 256px;">
                                                                            </div>
                                                                            <div
                                                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -256px; top: 0px;">
                                                                            </div>
                                                                            <div
                                                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 0px; top: 0px;">
                                                                            </div>
                                                                            <div
                                                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 256px; top: 0px;">
                                                                            </div>
                                                                            <div
                                                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 256px; top: 256px;">
                                                                            </div>
                                                                            <div
                                                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 256px; top: 512px;">
                                                                            </div>
                                                                            <div
                                                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 0px; top: 512px;">
                                                                            </div>
                                                                            <div
                                                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -256px; top: 512px;">
                                                                            </div>
                                                                            <div
                                                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -256px; top: -256px;">
                                                                            </div>
                                                                            <div
                                                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 0px; top: -256px;">
                                                                            </div>
                                                                            <div
                                                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 256px; top: -256px;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        style="width: 50px; height: 50px; overflow: hidden; position: absolute; left: -25px; top: -50px; z-index: 0;">
                                                                        <img alt=""
                                                                            src="https://mixtas.novaworks.net/wp-content/uploads/2023/12/pin.svg"
                                                                            draggable="false"
                                                                            style="position: absolute; left: 0px; top: 0px; user-select: none; width: 50px; height: 50px; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    style="position: absolute; left: 0px; top: 0px; z-index: 0;">
                                                                    <div
                                                                        style="position: absolute; z-index: 985; transform: matrix(1, 0, 0, 1, -142, -190);">
                                                                        <div
                                                                            style="position: absolute; left: -256px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear;">
                                                                            <img draggable="false" alt=""
                                                                                role="presentation"
                                                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i29576!3i20107!4i256!2m3!1e0!2sm!3i753512948!3m18!2svi-VN!3sUS!5e18!12m5!1e68!2m2!1sset!2sRoadmap!4e2!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjZ8cy5lOmd8cC5jOiNlOWU5ZTl8cC5sOjE3LHMudDo1fHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMCxzLnQ6NDl8cy5lOmcuZnxwLmM6I2ZmZmZmZnxwLmw6MTcscy50OjQ5fHMuZTpnLnN8cC5jOiNmZmZmZmZ8cC5sOjI5fHAudzowLjIscy50OjUwfHMuZTpnfHAuYzojZmZmZmZmfHAubDoxOCxzLnQ6NTF8cy5lOmd8cC5jOiNmZmZmZmZ8cC5sOjE2LHMudDoyfHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMSxzLnQ6NDB8cy5lOmd8cC5jOiNkZWRlZGV8cC5sOjIxLHMuZTpsLnQuc3xwLnY6b258cC5jOiNmZmZmZmZ8cC5sOjE2LHMuZTpsLnQuZnxwLnM6MzZ8cC5jOiMzMzMzMzN8cC5sOjQwLHMuZTpsLml8cC52Om9mZixzLnQ6NHxzLmU6Z3xwLmM6I2YyZjJmMnxwLmw6MTkscy50OjF8cy5lOmcuZnxwLmM6I2ZlZmVmZXxwLmw6MjAscy50OjF8cy5lOmcuc3xwLmM6I2ZlZmVmZXxwLmw6MTd8cC53OjEuMg!4e0!5m2!1e3!5f2!23i46991212!23i47054750!23i47083502&amp;key=AIzaSyDH-rtpwvyMwHPW0joNQHm5te6FE7DOk-U&amp;token=75128"
                                                                                style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                                                        </div>
                                                                        <div
                                                                            style="position: absolute; left: 0px; top: 256px; width: 256px; height: 256px; transition: opacity 200ms linear;">
                                                                            <img draggable="false" alt=""
                                                                                role="presentation"
                                                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i29577!3i20108!4i256!2m3!1e0!2sm!3i753513368!3m18!2svi-VN!3sUS!5e18!12m5!1e68!2m2!1sset!2sRoadmap!4e2!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjZ8cy5lOmd8cC5jOiNlOWU5ZTl8cC5sOjE3LHMudDo1fHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMCxzLnQ6NDl8cy5lOmcuZnxwLmM6I2ZmZmZmZnxwLmw6MTcscy50OjQ5fHMuZTpnLnN8cC5jOiNmZmZmZmZ8cC5sOjI5fHAudzowLjIscy50OjUwfHMuZTpnfHAuYzojZmZmZmZmfHAubDoxOCxzLnQ6NTF8cy5lOmd8cC5jOiNmZmZmZmZ8cC5sOjE2LHMudDoyfHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMSxzLnQ6NDB8cy5lOmd8cC5jOiNkZWRlZGV8cC5sOjIxLHMuZTpsLnQuc3xwLnY6b258cC5jOiNmZmZmZmZ8cC5sOjE2LHMuZTpsLnQuZnxwLnM6MzZ8cC5jOiMzMzMzMzN8cC5sOjQwLHMuZTpsLml8cC52Om9mZixzLnQ6NHxzLmU6Z3xwLmM6I2YyZjJmMnxwLmw6MTkscy50OjF8cy5lOmcuZnxwLmM6I2ZlZmVmZXxwLmw6MjAscy50OjF8cy5lOmcuc3xwLmM6I2ZlZmVmZXxwLmw6MTd8cC53OjEuMg!4e0!5m2!1e3!5f2!23i46991212!23i47054750!23i47083502&amp;key=AIzaSyDH-rtpwvyMwHPW0joNQHm5te6FE7DOk-U&amp;token=65797"
                                                                                style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                                                        </div>
                                                                        <div
                                                                            style="position: absolute; left: -256px; top: 256px; width: 256px; height: 256px; transition: opacity 200ms linear;">
                                                                            <img draggable="false" alt=""
                                                                                role="presentation"
                                                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i29576!3i20108!4i256!2m3!1e0!2sm!3i753513141!3m18!2svi-VN!3sUS!5e18!12m5!1e68!2m2!1sset!2sRoadmap!4e2!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjZ8cy5lOmd8cC5jOiNlOWU5ZTl8cC5sOjE3LHMudDo1fHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMCxzLnQ6NDl8cy5lOmcuZnxwLmM6I2ZmZmZmZnxwLmw6MTcscy50OjQ5fHMuZTpnLnN8cC5jOiNmZmZmZmZ8cC5sOjI5fHAudzowLjIscy50OjUwfHMuZTpnfHAuYzojZmZmZmZmfHAubDoxOCxzLnQ6NTF8cy5lOmd8cC5jOiNmZmZmZmZ8cC5sOjE2LHMudDoyfHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMSxzLnQ6NDB8cy5lOmd8cC5jOiNkZWRlZGV8cC5sOjIxLHMuZTpsLnQuc3xwLnY6b258cC5jOiNmZmZmZmZ8cC5sOjE2LHMuZTpsLnQuZnxwLnM6MzZ8cC5jOiMzMzMzMzN8cC5sOjQwLHMuZTpsLml8cC52Om9mZixzLnQ6NHxzLmU6Z3xwLmM6I2YyZjJmMnxwLmw6MTkscy50OjF8cy5lOmcuZnxwLmM6I2ZlZmVmZXxwLmw6MjAscy50OjF8cy5lOmcuc3xwLmM6I2ZlZmVmZXxwLmw6MTd8cC53OjEuMg!4e0!5m2!1e3!5f2!23i46991212!23i47054750!23i47083502&amp;key=AIzaSyDH-rtpwvyMwHPW0joNQHm5te6FE7DOk-U&amp;token=35928"
                                                                                style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                                                        </div>
                                                                        <div
                                                                            style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear;">
                                                                            <img draggable="false" alt=""
                                                                                role="presentation"
                                                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i29577!3i20107!4i256!2m3!1e0!2sm!3i753513368!3m18!2svi-VN!3sUS!5e18!12m5!1e68!2m2!1sset!2sRoadmap!4e2!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjZ8cy5lOmd8cC5jOiNlOWU5ZTl8cC5sOjE3LHMudDo1fHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMCxzLnQ6NDl8cy5lOmcuZnxwLmM6I2ZmZmZmZnxwLmw6MTcscy50OjQ5fHMuZTpnLnN8cC5jOiNmZmZmZmZ8cC5sOjI5fHAudzowLjIscy50OjUwfHMuZTpnfHAuYzojZmZmZmZmfHAubDoxOCxzLnQ6NTF8cy5lOmd8cC5jOiNmZmZmZmZ8cC5sOjE2LHMudDoyfHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMSxzLnQ6NDB8cy5lOmd8cC5jOiNkZWRlZGV8cC5sOjIxLHMuZTpsLnQuc3xwLnY6b258cC5jOiNmZmZmZmZ8cC5sOjE2LHMuZTpsLnQuZnxwLnM6MzZ8cC5jOiMzMzMzMzN8cC5sOjQwLHMuZTpsLml8cC52Om9mZixzLnQ6NHxzLmU6Z3xwLmM6I2YyZjJmMnxwLmw6MTkscy50OjF8cy5lOmcuZnxwLmM6I2ZlZmVmZXxwLmw6MjAscy50OjF8cy5lOmcuc3xwLmM6I2ZlZmVmZXxwLmw6MTd8cC53OjEuMg!4e0!5m2!1e3!5f2!23i46991212!23i47054750!23i47083502&amp;key=AIzaSyDH-rtpwvyMwHPW0joNQHm5te6FE7DOk-U&amp;token=19857"
                                                                                style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                                                        </div>
                                                                        <div
                                                                            style="position: absolute; left: 256px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear;">
                                                                            <img draggable="false" alt=""
                                                                                role="presentation"
                                                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i29578!3i20107!4i256!2m3!1e0!2sm!3i753513368!3m18!2svi-VN!3sUS!5e18!12m5!1e68!2m2!1sset!2sRoadmap!4e2!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjZ8cy5lOmd8cC5jOiNlOWU5ZTl8cC5sOjE3LHMudDo1fHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMCxzLnQ6NDl8cy5lOmcuZnxwLmM6I2ZmZmZmZnxwLmw6MTcscy50OjQ5fHMuZTpnLnN8cC5jOiNmZmZmZmZ8cC5sOjI5fHAudzowLjIscy50OjUwfHMuZTpnfHAuYzojZmZmZmZmfHAubDoxOCxzLnQ6NTF8cy5lOmd8cC5jOiNmZmZmZmZ8cC5sOjE2LHMudDoyfHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMSxzLnQ6NDB8cy5lOmd8cC5jOiNkZWRlZGV8cC5sOjIxLHMuZTpsLnQuc3xwLnY6b258cC5jOiNmZmZmZmZ8cC5sOjE2LHMuZTpsLnQuZnxwLnM6MzZ8cC5jOiMzMzMzMzN8cC5sOjQwLHMuZTpsLml8cC52Om9mZixzLnQ6NHxzLmU6Z3xwLmM6I2YyZjJmMnxwLmw6MTkscy50OjF8cy5lOmcuZnxwLmM6I2ZlZmVmZXxwLmw6MjAscy50OjF8cy5lOmcuc3xwLmM6I2ZlZmVmZXxwLmw6MTd8cC53OjEuMg!4e0!5m2!1e3!5f2!23i46991212!23i47054750!23i47083502&amp;key=AIzaSyDH-rtpwvyMwHPW0joNQHm5te6FE7DOk-U&amp;token=182"
                                                                                style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                                                        </div>
                                                                        <div
                                                                            style="position: absolute; left: 256px; top: 256px; width: 256px; height: 256px; transition: opacity 200ms linear;">
                                                                            <img draggable="false" alt=""
                                                                                role="presentation"
                                                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i29578!3i20108!4i256!2m3!1e0!2sm!3i753513368!3m18!2svi-VN!3sUS!5e18!12m5!1e68!2m2!1sset!2sRoadmap!4e2!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjZ8cy5lOmd8cC5jOiNlOWU5ZTl8cC5sOjE3LHMudDo1fHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMCxzLnQ6NDl8cy5lOmcuZnxwLmM6I2ZmZmZmZnxwLmw6MTcscy50OjQ5fHMuZTpnLnN8cC5jOiNmZmZmZmZ8cC5sOjI5fHAudzowLjIscy50OjUwfHMuZTpnfHAuYzojZmZmZmZmfHAubDoxOCxzLnQ6NTF8cy5lOmd8cC5jOiNmZmZmZmZ8cC5sOjE2LHMudDoyfHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMSxzLnQ6NDB8cy5lOmd8cC5jOiNkZWRlZGV8cC5sOjIxLHMuZTpsLnQuc3xwLnY6b258cC5jOiNmZmZmZmZ8cC5sOjE2LHMuZTpsLnQuZnxwLnM6MzZ8cC5jOiMzMzMzMzN8cC5sOjQwLHMuZTpsLml8cC52Om9mZixzLnQ6NHxzLmU6Z3xwLmM6I2YyZjJmMnxwLmw6MTkscy50OjF8cy5lOmcuZnxwLmM6I2ZlZmVmZXxwLmw6MjAscy50OjF8cy5lOmcuc3xwLmM6I2ZlZmVmZXxwLmw6MTd8cC53OjEuMg!4e0!5m2!1e3!5f2!23i46991212!23i47054750!23i47083502&amp;key=AIzaSyDH-rtpwvyMwHPW0joNQHm5te6FE7DOk-U&amp;token=46122"
                                                                                style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                                                        </div>
                                                                        <div
                                                                            style="position: absolute; left: 256px; top: 512px; width: 256px; height: 256px; transition: opacity 200ms linear;">
                                                                            <img draggable="false" alt=""
                                                                                role="presentation"
                                                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i29578!3i20109!4i256!2m3!1e0!2sm!3i753513296!3m18!2svi-VN!3sUS!5e18!12m5!1e68!2m2!1sset!2sRoadmap!4e2!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjZ8cy5lOmd8cC5jOiNlOWU5ZTl8cC5sOjE3LHMudDo1fHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMCxzLnQ6NDl8cy5lOmcuZnxwLmM6I2ZmZmZmZnxwLmw6MTcscy50OjQ5fHMuZTpnLnN8cC5jOiNmZmZmZmZ8cC5sOjI5fHAudzowLjIscy50OjUwfHMuZTpnfHAuYzojZmZmZmZmfHAubDoxOCxzLnQ6NTF8cy5lOmd8cC5jOiNmZmZmZmZ8cC5sOjE2LHMudDoyfHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMSxzLnQ6NDB8cy5lOmd8cC5jOiNkZWRlZGV8cC5sOjIxLHMuZTpsLnQuc3xwLnY6b258cC5jOiNmZmZmZmZ8cC5sOjE2LHMuZTpsLnQuZnxwLnM6MzZ8cC5jOiMzMzMzMzN8cC5sOjQwLHMuZTpsLml8cC52Om9mZixzLnQ6NHxzLmU6Z3xwLmM6I2YyZjJmMnxwLmw6MTkscy50OjF8cy5lOmcuZnxwLmM6I2ZlZmVmZXxwLmw6MjAscy50OjF8cy5lOmcuc3xwLmM6I2ZlZmVmZXxwLmw6MTd8cC53OjEuMg!4e0!5m2!1e3!5f2!23i46991212!23i47054750!23i47083502&amp;key=AIzaSyDH-rtpwvyMwHPW0joNQHm5te6FE7DOk-U&amp;token=117273"
                                                                                style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                                                        </div>
                                                                        <div
                                                                            style="position: absolute; left: -256px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear;">
                                                                            <img draggable="false" alt=""
                                                                                role="presentation"
                                                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i29576!3i20106!4i256!2m3!1e0!2sm!3i753513404!3m18!2svi-VN!3sUS!5e18!12m5!1e68!2m2!1sset!2sRoadmap!4e2!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjZ8cy5lOmd8cC5jOiNlOWU5ZTl8cC5sOjE3LHMudDo1fHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMCxzLnQ6NDl8cy5lOmcuZnxwLmM6I2ZmZmZmZnxwLmw6MTcscy50OjQ5fHMuZTpnLnN8cC5jOiNmZmZmZmZ8cC5sOjI5fHAudzowLjIscy50OjUwfHMuZTpnfHAuYzojZmZmZmZmfHAubDoxOCxzLnQ6NTF8cy5lOmd8cC5jOiNmZmZmZmZ8cC5sOjE2LHMudDoyfHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMSxzLnQ6NDB8cy5lOmd8cC5jOiNkZWRlZGV8cC5sOjIxLHMuZTpsLnQuc3xwLnY6b258cC5jOiNmZmZmZmZ8cC5sOjE2LHMuZTpsLnQuZnxwLnM6MzZ8cC5jOiMzMzMzMzN8cC5sOjQwLHMuZTpsLml8cC52Om9mZixzLnQ6NHxzLmU6Z3xwLmM6I2YyZjJmMnxwLmw6MTkscy50OjF8cy5lOmcuZnxwLmM6I2ZlZmVmZXxwLmw6MjAscy50OjF8cy5lOmcuc3xwLmM6I2ZlZmVmZXxwLmw6MTd8cC53OjEuMg!4e0!5m2!1e3!5f2!23i46991212!23i47054750!23i47083502&amp;key=AIzaSyDH-rtpwvyMwHPW0joNQHm5te6FE7DOk-U&amp;token=64658"
                                                                                style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                                                        </div>
                                                                        <div
                                                                            style="position: absolute; left: 0px; top: 512px; width: 256px; height: 256px; transition: opacity 200ms linear;">
                                                                            <img draggable="false" alt=""
                                                                                role="presentation"
                                                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i29577!3i20109!4i256!2m3!1e0!2sm!3i753513296!3m18!2svi-VN!3sUS!5e18!12m5!1e68!2m2!1sset!2sRoadmap!4e2!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjZ8cy5lOmd8cC5jOiNlOWU5ZTl8cC5sOjE3LHMudDo1fHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMCxzLnQ6NDl8cy5lOmcuZnxwLmM6I2ZmZmZmZnxwLmw6MTcscy50OjQ5fHMuZTpnLnN8cC5jOiNmZmZmZmZ8cC5sOjI5fHAudzowLjIscy50OjUwfHMuZTpnfHAuYzojZmZmZmZmfHAubDoxOCxzLnQ6NTF8cy5lOmd8cC5jOiNmZmZmZmZ8cC5sOjE2LHMudDoyfHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMSxzLnQ6NDB8cy5lOmd8cC5jOiNkZWRlZGV8cC5sOjIxLHMuZTpsLnQuc3xwLnY6b258cC5jOiNmZmZmZmZ8cC5sOjE2LHMuZTpsLnQuZnxwLnM6MzZ8cC5jOiMzMzMzMzN8cC5sOjQwLHMuZTpsLml8cC52Om9mZixzLnQ6NHxzLmU6Z3xwLmM6I2YyZjJmMnxwLmw6MTkscy50OjF8cy5lOmcuZnxwLmM6I2ZlZmVmZXxwLmw6MjAscy50OjF8cy5lOmcuc3xwLmM6I2ZlZmVmZXxwLmw6MTd8cC53OjEuMg!4e0!5m2!1e3!5f2!23i46991212!23i47054750!23i47083502&amp;key=AIzaSyDH-rtpwvyMwHPW0joNQHm5te6FE7DOk-U&amp;token=5877"
                                                                                style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                                                        </div>
                                                                        <div
                                                                            style="position: absolute; left: 0px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear;">
                                                                            <img draggable="false" alt=""
                                                                                role="presentation"
                                                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i29577!3i20106!4i256!2m3!1e0!2sm!3i753513368!3m18!2svi-VN!3sUS!5e18!12m5!1e68!2m2!1sset!2sRoadmap!4e2!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjZ8cy5lOmd8cC5jOiNlOWU5ZTl8cC5sOjE3LHMudDo1fHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMCxzLnQ6NDl8cy5lOmcuZnxwLmM6I2ZmZmZmZnxwLmw6MTcscy50OjQ5fHMuZTpnLnN8cC5jOiNmZmZmZmZ8cC5sOjI5fHAudzowLjIscy50OjUwfHMuZTpnfHAuYzojZmZmZmZmfHAubDoxOCxzLnQ6NTF8cy5lOmd8cC5jOiNmZmZmZmZ8cC5sOjE2LHMudDoyfHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMSxzLnQ6NDB8cy5lOmd8cC5jOiNkZWRlZGV8cC5sOjIxLHMuZTpsLnQuc3xwLnY6b258cC5jOiNmZmZmZmZ8cC5sOjE2LHMuZTpsLnQuZnxwLnM6MzZ8cC5jOiMzMzMzMzN8cC5sOjQwLHMuZTpsLml8cC52Om9mZixzLnQ6NHxzLmU6Z3xwLmM6I2YyZjJmMnxwLmw6MTkscy50OjF8cy5lOmcuZnxwLmM6I2ZlZmVmZXxwLmw6MjAscy50OjF8cy5lOmcuc3xwLmM6I2ZlZmVmZXxwLmw6MTd8cC53OjEuMg!4e0!5m2!1e3!5f2!23i46991212!23i47054750!23i47083502&amp;key=AIzaSyDH-rtpwvyMwHPW0joNQHm5te6FE7DOk-U&amp;token=104988"
                                                                                style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                                                        </div>
                                                                        <div
                                                                            style="position: absolute; left: 256px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear;">
                                                                            <img draggable="false" alt=""
                                                                                role="presentation"
                                                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i29578!3i20106!4i256!2m3!1e0!2sm!3i753513368!3m18!2svi-VN!3sUS!5e18!12m5!1e68!2m2!1sset!2sRoadmap!4e2!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjZ8cy5lOmd8cC5jOiNlOWU5ZTl8cC5sOjE3LHMudDo1fHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMCxzLnQ6NDl8cy5lOmcuZnxwLmM6I2ZmZmZmZnxwLmw6MTcscy50OjQ5fHMuZTpnLnN8cC5jOiNmZmZmZmZ8cC5sOjI5fHAudzowLjIscy50OjUwfHMuZTpnfHAuYzojZmZmZmZmfHAubDoxOCxzLnQ6NTF8cy5lOmd8cC5jOiNmZmZmZmZ8cC5sOjE2LHMudDoyfHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMSxzLnQ6NDB8cy5lOmd8cC5jOiNkZWRlZGV8cC5sOjIxLHMuZTpsLnQuc3xwLnY6b258cC5jOiNmZmZmZmZ8cC5sOjE2LHMuZTpsLnQuZnxwLnM6MzZ8cC5jOiMzMzMzMzN8cC5sOjQwLHMuZTpsLml8cC52Om9mZixzLnQ6NHxzLmU6Z3xwLmM6I2YyZjJmMnxwLmw6MTkscy50OjF8cy5lOmcuZnxwLmM6I2ZlZmVmZXxwLmw6MjAscy50OjF8cy5lOmcuc3xwLmM6I2ZlZmVmZXxwLmw6MTd8cC53OjEuMg!4e0!5m2!1e3!5f2!23i46991212!23i47054750!23i47083502&amp;key=AIzaSyDH-rtpwvyMwHPW0joNQHm5te6FE7DOk-U&amp;token=85313"
                                                                                style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                                                        </div>
                                                                        <div
                                                                            style="position: absolute; left: -256px; top: 512px; width: 256px; height: 256px; transition: opacity 200ms linear;">
                                                                            <img draggable="false" alt=""
                                                                                role="presentation"
                                                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i15!2i29576!3i20109!4i256!2m3!1e0!2sm!3i753513141!3m18!2svi-VN!3sUS!5e18!12m5!1e68!2m2!1sset!2sRoadmap!4e2!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjZ8cy5lOmd8cC5jOiNlOWU5ZTl8cC5sOjE3LHMudDo1fHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMCxzLnQ6NDl8cy5lOmcuZnxwLmM6I2ZmZmZmZnxwLmw6MTcscy50OjQ5fHMuZTpnLnN8cC5jOiNmZmZmZmZ8cC5sOjI5fHAudzowLjIscy50OjUwfHMuZTpnfHAuYzojZmZmZmZmfHAubDoxOCxzLnQ6NTF8cy5lOmd8cC5jOiNmZmZmZmZ8cC5sOjE2LHMudDoyfHMuZTpnfHAuYzojZjVmNWY1fHAubDoyMSxzLnQ6NDB8cy5lOmd8cC5jOiNkZWRlZGV8cC5sOjIxLHMuZTpsLnQuc3xwLnY6b258cC5jOiNmZmZmZmZ8cC5sOjE2LHMuZTpsLnQuZnxwLnM6MzZ8cC5jOiMzMzMzMzN8cC5sOjQwLHMuZTpsLml8cC52Om9mZixzLnQ6NHxzLmU6Z3xwLmM6I2YyZjJmMnxwLmw6MTkscy50OjF8cy5lOmcuZnxwLmM6I2ZlZmVmZXxwLmw6MjAscy50OjF8cy5lOmcuc3xwLmM6I2ZlZmVmZXxwLmw6MTd8cC53OjEuMg!4e0!5m2!1e3!5f2!23i46991212!23i47054750!23i47083502&amp;key=AIzaSyDH-rtpwvyMwHPW0joNQHm5te6FE7DOk-U&amp;token=81868"
                                                                                style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                style="z-index: 3; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; touch-action: pan-x pan-y;">
                                                                <div
                                                                    style="z-index: 4; position: absolute; left: 50%; top: 50%; width: 100%; will-change: transform; transform: translate(0px, 0px);">
                                                                    <div
                                                                        style="position: absolute; left: 0px; top: 0px; z-index: 104; width: 100%;">
                                                                    </div>
                                                                    <div
                                                                        style="position: absolute; left: 0px; top: 0px; z-index: 105; width: 100%;">
                                                                    </div>
                                                                    <div
                                                                        style="position: absolute; left: 0px; top: 0px; z-index: 106; width: 100%;">
                                                                        <slot></slot><span
                                                                            id="49C1B4C4-25B3-462E-9F60-B9C81F301EEC"
                                                                            aria-live="polite"
                                                                            style="position: absolute; width: 1px; height: 1px; margin: -1px; padding: 0px; overflow: hidden; clip-path: inset(100%); white-space: nowrap; border: 0px;"></span>
                                                                        <div title="" role="button"
                                                                            tabindex="0"
                                                                            style="width: 50px; height: 50px; overflow: hidden; position: absolute; cursor: pointer; touch-action: none; left: -25px; top: -50px; z-index: 0;">
                                                                            <img alt=""
                                                                                src="https://maps.gstatic.com/mapfiles/transparent.png"
                                                                                draggable="false"
                                                                                style="width: 50px; height: 50px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        style="position: absolute; left: 0px; top: 0px; z-index: 107; width: 100%;">
                                                                        <div
                                                                            style="cursor: default; position: absolute; top: 0px; left: 0px; z-index: -170;">
                                                                            <div class="gm-style-iw-a"
                                                                                style="position: absolute; left: 0px; top: 0px;">
                                                                                <div class="gm-style-iw-t"
                                                                                    style="right: 0px; bottom: 61px;">
                                                                                    <div role="dialog" tabindex="-1"
                                                                                        class="gm-style-iw gm-style-iw-c"
                                                                                        aria-labelledby="E4DB85A0-C325-4879-B133-C84F91F77F77"
                                                                                        style="padding-inline-end: 0px; padding-bottom: 0px; padding-top: 0px; max-width: 437px; max-height: 519px; min-width: 0px;">
                                                                                        <div class="gm-style-iw-chr">
                                                                                            <div class="gm-style-iw-ch"
                                                                                                id="E4DB85A0-C325-4879-B133-C84F91F77F77">
                                                                                            </div><button
                                                                                                draggable="false"
                                                                                                aria-label="Đóng"
                                                                                                title="Đóng"
                                                                                                type="button"
                                                                                                class="gm-ui-hover-effect"
                                                                                                style="background: none; display: block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; width: 48px; height: 48px;"><span
                                                                                                    style="mask-image: url(&quot;data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M19%206.41L17.59%205%2012%2010.59%206.41%205%205%206.41%2010.59%2012%205%2017.59%206.41%2019%2012%2013.41%2017.59%2019%2019%2017.59%2013.41%2012z%22/%3E%3Cpath%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22/%3E%3C/svg%3E&quot;); pointer-events: none; display: block; width: 24px; height: 24px; margin: 12px;"></span></button>
                                                                                        </div>
                                                                                        <div class="gm-style-iw-d"
                                                                                            style="overflow: scroll; max-height: 501px;">
                                                                                            <div>PO Box 16122 Collins Street
                                                                                                West Victoria 8007 Australia
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="gm-style-iw-tc"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="gm-style-moc"
                                                                style="z-index: 4; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; transition-property: opacity, display; transition-behavior: allow-discrete; opacity: 0; display: none;">
                                                                <p class="gm-style-mot"></p>
                                                            </div>
                                                        </div><iframe aria-hidden="true" frameborder="0"
                                                            tabindex="-1"
                                                            style="z-index: -1; position: absolute; width: 100%; height: 100%; top: 0px; left: 0px; border: none; opacity: 0;"></iframe>
                                                        <div
                                                            style="pointer-events: none; width: 100%; height: 100%; box-sizing: border-box; position: absolute; z-index: 1000002; opacity: 0; border: 2px solid rgb(26, 115, 232);">
                                                        </div>
                                                        <div>
                                                            <div class="gmnoprint gm-style-mtc-bbw" role="menubar"
                                                                style="margin: 10px; z-index: 0; position: absolute; cursor: pointer; left: 0px; top: 0px;">
                                                                <div class="gm-style-mtc"
                                                                    style="float: left; position: relative;"><button
                                                                        draggable="false"
                                                                        aria-label="Hiển thị bản đồ phố"
                                                                        title="Hiển thị bản đồ phố" type="button"
                                                                        role="menuitemradio" aria-checked="true"
                                                                        aria-haspopup="true"
                                                                        style="background: none padding-box rgb(255, 255, 255); display: table-cell; border: 0px; margin: 0px; padding: 0px 17px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; overflow: hidden; text-align: center; height: 40px; vertical-align: middle; color: rgb(0, 0, 0); font-family: Roboto, Arial, sans-serif; font-size: 18px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; min-width: 57px; font-weight: 500;"
                                                                        id="6495B925-6766-4D06-AD2E-11C52E361376">Bản
                                                                        đồ</button>
                                                                    <ul role="menu"
                                                                        aria-labelledby="6495B925-6766-4D06-AD2E-11C52E361376"
                                                                        style="background-color: rgb(255, 255, 255); list-style: none; padding: 2px; margin: 0px; z-index: -1; border-bottom-left-radius: 2px; border-bottom-right-radius: 2px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; position: absolute; left: 0px; top: 40px; text-align: left; display: none;">
                                                                        <li tabindex="-1" role="menuitemcheckbox"
                                                                            aria-label="Địa hình" draggable="false"
                                                                            title="Hiển thị bản đồ phố với địa hình"
                                                                            aria-checked="false"
                                                                            class="ssQIHO-checkbox-menu-item"
                                                                            style="color: rgb(0, 0, 0); font-family: Roboto, Arial, sans-serif; user-select: none; font-size: 18px; background-color: rgb(255, 255, 255); padding: 5px 8px 5px 5px; direction: ltr; text-align: left; white-space: nowrap;">
                                                                            <span><span
                                                                                    style="mask-image: url(&quot;data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22/%3E%3Cpath%20d%3D%22M19%203H5c-1.11%200-2%20.9-2%202v14c0%201.1.89%202%202%202h14c1.11%200%202-.9%202-2V5c0-1.1-.89-2-2-2zm-9%2014l-5-5%201.41-1.41L10%2014.17l7.59-7.59L19%208l-9%209z%22/%3E%3C/svg%3E&quot;); height: 1em; width: 1em; transform: translateY(0.15em); display: none;"></span><span
                                                                                    style="mask-image: url(&quot;data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M19%205v14H5V5h14m0-2H5c-1.1%200-2%20.9-2%202v14c0%201.1.9%202%202%202h14c1.1%200%202-.9%202-2V5c0-1.1-.9-2-2-2z%22/%3E%3Cpath%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22/%3E%3C/svg%3E&quot;); height: 1em; width: 1em; transform: translateY(0.15em);"></span></span><label
                                                                                style="cursor: inherit;">Địa hình</label>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="gm-style-mtc"
                                                                    style="float: left; position: relative;"><button
                                                                        draggable="false"
                                                                        aria-label="Hiển thị hình ảnh qua vệ tinh"
                                                                        title="Hiển thị hình ảnh qua vệ tinh"
                                                                        type="button" role="menuitemradio"
                                                                        aria-checked="false" aria-haspopup="true"
                                                                        style="background: none padding-box rgb(255, 255, 255); display: table-cell; border: 0px; margin: 0px; padding: 0px 17px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; overflow: hidden; text-align: center; height: 40px; vertical-align: middle; color: rgb(86, 86, 86); font-family: Roboto, Arial, sans-serif; font-size: 18px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; min-width: 56px;"
                                                                        id="1D8F39A9-792E-4F7D-82E6-795B75A1AF52">Vệ
                                                                        tinh</button>
                                                                    <ul role="menu"
                                                                        aria-labelledby="1D8F39A9-792E-4F7D-82E6-795B75A1AF52"
                                                                        style="background-color: rgb(255, 255, 255); list-style: none; padding: 2px; margin: 0px; z-index: -1; border-bottom-left-radius: 2px; border-bottom-right-radius: 2px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; position: absolute; right: 0px; top: 40px; text-align: left; display: none;">
                                                                        <li tabindex="-1" role="menuitemcheckbox"
                                                                            aria-label="Nhãn" draggable="false"
                                                                            title="Hiển thị hình ảnh có tên phố"
                                                                            aria-checked="true"
                                                                            class="ssQIHO-checkbox-menu-item"
                                                                            style="color: rgb(0, 0, 0); font-family: Roboto, Arial, sans-serif; user-select: none; font-size: 18px; background-color: rgb(255, 255, 255); padding: 5px 8px 5px 5px; direction: ltr; text-align: left; white-space: nowrap;">
                                                                            <span><span
                                                                                    style="mask-image: url(&quot;data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22/%3E%3Cpath%20d%3D%22M19%203H5c-1.11%200-2%20.9-2%202v14c0%201.1.89%202%202%202h14c1.11%200%202-.9%202-2V5c0-1.1-.89-2-2-2zm-9%2014l-5-5%201.41-1.41L10%2014.17l7.59-7.59L19%208l-9%209z%22/%3E%3C/svg%3E&quot;); height: 1em; width: 1em; transform: translateY(0.15em);"></span><span
                                                                                    style="mask-image: url(&quot;data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M19%205v14H5V5h14m0-2H5c-1.1%200-2%20.9-2%202v14c0%201.1.9%202%202%202h14c1.1%200%202-.9%202-2V5c0-1.1-.9-2-2-2z%22/%3E%3Cpath%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22/%3E%3C/svg%3E&quot;); height: 1em; width: 1em; transform: translateY(0.15em); display: none;"></span></span><label
                                                                                style="cursor: inherit;">Nhãn</label></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div><button draggable="false"
                                                                aria-label="Chuyển đổi chế độ xem toàn màn hình"
                                                                title="Chuyển đổi chế độ xem toàn màn hình"
                                                                type="button" aria-pressed="false"
                                                                class="gm-control-active gm-fullscreen-control"
                                                                style="background: none rgb(255, 255, 255); border: 0px; margin: 10px; padding: 0px; text-transform: none; appearance: none; position: absolute; cursor: pointer; user-select: none; border-radius: 2px; height: 40px; width: 40px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; overflow: hidden; top: 0px; right: 0px;"><img
                                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2018%2018%22%3E%3Cpath%20fill%3D%22%23666%22%20d%3D%22M0%200v6h2V2h4V0H0zm16%200h-4v2h4v4h2V0h-2zm0%2016h-4v2h6v-6h-2v4zM2%2012H0v6h6v-2H2v-4z%22/%3E%3C/svg%3E"
                                                                    alt=""
                                                                    style="height: 18px; width: 18px;"><img
                                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2018%2018%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M0%200v6h2V2h4V0H0zm16%200h-4v2h4v4h2V0h-2zm0%2016h-4v2h6v-6h-2v4zM2%2012H0v6h6v-2H2v-4z%22/%3E%3C/svg%3E"
                                                                    alt=""
                                                                    style="height: 18px; width: 18px;"><img
                                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2018%2018%22%3E%3Cpath%20fill%3D%22%23111%22%20d%3D%22M0%200v6h2V2h4V0H0zm16%200h-4v2h4v4h2V0h-2zm0%2016h-4v2h6v-6h-2v4zM2%2012H0v6h6v-2H2v-4z%22/%3E%3C/svg%3E"
                                                                    alt=""
                                                                    style="height: 18px; width: 18px;"></button></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div>
                                                            <div class="gmnoprint gm-bundled-control gm-bundled-control-on-bottom"
                                                                draggable="false" data-control-width="40"
                                                                data-control-height="225"
                                                                style="margin: 10px; user-select: none; position: absolute; bottom: 239px; right: 40px;">
                                                                <div class="gmnoprint" data-control-width="40"
                                                                    data-control-height="40"
                                                                    style="display: none; position: absolute;">
                                                                    <div
                                                                        style="background-color: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px; width: 40px; height: 40px;">
                                                                        <button draggable="false"
                                                                            aria-label="Xoay bản đồ theo chiều kim đồng hồ"
                                                                            title="Xoay bản đồ theo chiều kim đồng hồ"
                                                                            type="button" class="gm-control-active"
                                                                            style="background: none; display: none; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; left: 0px; top: 0px; overflow: hidden; width: 40px; height: 40px;"><img
                                                                                alt=""
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20fill%3D%22none%22%20d%3D%22M0%200h24v24H0V0z%22/%3E%3Cpath%20fill%3D%22%23666%22%20d%3D%22M12.06%209.06l4-4-4-4-1.41%201.41%201.59%201.59h-.18c-2.3%200-4.6.88-6.35%202.64-3.52%203.51-3.52%209.21%200%2012.72%201.5%201.5%203.4%202.36%205.36%202.58v-2.02c-1.44-.21-2.84-.86-3.95-1.97-2.73-2.73-2.73-7.17%200-9.9%201.37-1.37%203.16-2.05%204.95-2.05h.17l-1.59%201.59%201.41%201.41zm8.94%203c-.19-1.74-.88-3.32-1.91-4.61l-1.43%201.43c.69.92%201.15%202%201.32%203.18H21zm-7.94%207.92V22c1.74-.19%203.32-.88%204.61-1.91l-1.43-1.43c-.91.68-2%201.15-3.18%201.32zm4.6-2.74l1.43%201.43c1.04-1.29%201.72-2.88%201.91-4.61h-2.02c-.17%201.18-.64%202.27-1.32%203.18z%22/%3E%3C/svg%3E"
                                                                                style="width: 20px; height: 20px;"><img
                                                                                alt=""
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20fill%3D%22none%22%20d%3D%22M0%200h24v24H0V0z%22/%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M12.06%209.06l4-4-4-4-1.41%201.41%201.59%201.59h-.18c-2.3%200-4.6.88-6.35%202.64-3.52%203.51-3.52%209.21%200%2012.72%201.5%201.5%203.4%202.36%205.36%202.58v-2.02c-1.44-.21-2.84-.86-3.95-1.97-2.73-2.73-2.73-7.17%200-9.9%201.37-1.37%203.16-2.05%204.95-2.05h.17l-1.59%201.59%201.41%201.41zm8.94%203c-.19-1.74-.88-3.32-1.91-4.61l-1.43%201.43c.69.92%201.15%202%201.32%203.18H21zm-7.94%207.92V22c1.74-.19%203.32-.88%204.61-1.91l-1.43-1.43c-.91.68-2%201.15-3.18%201.32zm4.6-2.74l1.43%201.43c1.04-1.29%201.72-2.88%201.91-4.61h-2.02c-.17%201.18-.64%202.27-1.32%203.18z%22/%3E%3C/svg%3E"
                                                                                style="width: 20px; height: 20px;"><img
                                                                                alt=""
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20fill%3D%22none%22%20d%3D%22M0%200h24v24H0V0z%22/%3E%3Cpath%20fill%3D%22%23111%22%20d%3D%22M12.06%209.06l4-4-4-4-1.41%201.41%201.59%201.59h-.18c-2.3%200-4.6.88-6.35%202.64-3.52%203.51-3.52%209.21%200%2012.72%201.5%201.5%203.4%202.36%205.36%202.58v-2.02c-1.44-.21-2.84-.86-3.95-1.97-2.73-2.73-2.73-7.17%200-9.9%201.37-1.37%203.16-2.05%204.95-2.05h.17l-1.59%201.59%201.41%201.41zm8.94%203c-.19-1.74-.88-3.32-1.91-4.61l-1.43%201.43c.69.92%201.15%202%201.32%203.18H21zm-7.94%207.92V22c1.74-.19%203.32-.88%204.61-1.91l-1.43-1.43c-.91.68-2%201.15-3.18%201.32zm4.6-2.74l1.43%201.43c1.04-1.29%201.72-2.88%201.91-4.61h-2.02c-.17%201.18-.64%202.27-1.32%203.18z%22/%3E%3C/svg%3E"
                                                                                style="width: 20px; height: 20px;"></button>
                                                                        <div
                                                                            style="position: relative; overflow: hidden; width: 30px; height: 1px; margin: 0px 5px; background-color: rgb(230, 230, 230); display: none;">
                                                                        </div><button draggable="false"
                                                                            aria-label="Xoay bản đồ ngược chiều kim đồng hồ"
                                                                            title="Xoay bản đồ ngược chiều kim đồng hồ"
                                                                            type="button" class="gm-control-active"
                                                                            style="background: none; display: none; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; left: 0px; top: 0px; overflow: hidden; width: 40px; height: 40px; transform: scaleX(-1);"><img
                                                                                alt=""
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20fill%3D%22none%22%20d%3D%22M0%200h24v24H0V0z%22/%3E%3Cpath%20fill%3D%22%23666%22%20d%3D%22M12.06%209.06l4-4-4-4-1.41%201.41%201.59%201.59h-.18c-2.3%200-4.6.88-6.35%202.64-3.52%203.51-3.52%209.21%200%2012.72%201.5%201.5%203.4%202.36%205.36%202.58v-2.02c-1.44-.21-2.84-.86-3.95-1.97-2.73-2.73-2.73-7.17%200-9.9%201.37-1.37%203.16-2.05%204.95-2.05h.17l-1.59%201.59%201.41%201.41zm8.94%203c-.19-1.74-.88-3.32-1.91-4.61l-1.43%201.43c.69.92%201.15%202%201.32%203.18H21zm-7.94%207.92V22c1.74-.19%203.32-.88%204.61-1.91l-1.43-1.43c-.91.68-2%201.15-3.18%201.32zm4.6-2.74l1.43%201.43c1.04-1.29%201.72-2.88%201.91-4.61h-2.02c-.17%201.18-.64%202.27-1.32%203.18z%22/%3E%3C/svg%3E"
                                                                                style="width: 20px; height: 20px;"><img
                                                                                alt=""
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20fill%3D%22none%22%20d%3D%22M0%200h24v24H0V0z%22/%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M12.06%209.06l4-4-4-4-1.41%201.41%201.59%201.59h-.18c-2.3%200-4.6.88-6.35%202.64-3.52%203.51-3.52%209.21%200%2012.72%201.5%201.5%203.4%202.36%205.36%202.58v-2.02c-1.44-.21-2.84-.86-3.95-1.97-2.73-2.73-2.73-7.17%200-9.9%201.37-1.37%203.16-2.05%204.95-2.05h.17l-1.59%201.59%201.41%201.41zm8.94%203c-.19-1.74-.88-3.32-1.91-4.61l-1.43%201.43c.69.92%201.15%202%201.32%203.18H21zm-7.94%207.92V22c1.74-.19%203.32-.88%204.61-1.91l-1.43-1.43c-.91.68-2%201.15-3.18%201.32zm4.6-2.74l1.43%201.43c1.04-1.29%201.72-2.88%201.91-4.61h-2.02c-.17%201.18-.64%202.27-1.32%203.18z%22/%3E%3C/svg%3E"
                                                                                style="width: 20px; height: 20px;"><img
                                                                                alt=""
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20fill%3D%22none%22%20d%3D%22M0%200h24v24H0V0z%22/%3E%3Cpath%20fill%3D%22%23111%22%20d%3D%22M12.06%209.06l4-4-4-4-1.41%201.41%201.59%201.59h-.18c-2.3%200-4.6.88-6.35%202.64-3.52%203.51-3.52%209.21%200%2012.72%201.5%201.5%203.4%202.36%205.36%202.58v-2.02c-1.44-.21-2.84-.86-3.95-1.97-2.73-2.73-2.73-7.17%200-9.9%201.37-1.37%203.16-2.05%204.95-2.05h.17l-1.59%201.59%201.41%201.41zm8.94%203c-.19-1.74-.88-3.32-1.91-4.61l-1.43%201.43c.69.92%201.15%202%201.32%203.18H21zm-7.94%207.92V22c1.74-.19%203.32-.88%204.61-1.91l-1.43-1.43c-.91.68-2%201.15-3.18%201.32zm4.6-2.74l1.43%201.43c1.04-1.29%201.72-2.88%201.91-4.61h-2.02c-.17%201.18-.64%202.27-1.32%203.18z%22/%3E%3C/svg%3E"
                                                                                style="width: 20px; height: 20px;"></button>
                                                                        <div
                                                                            style="position: relative; overflow: hidden; width: 30px; height: 1px; margin: 0px 5px; background-color: rgb(230, 230, 230); display: none;">
                                                                        </div><button draggable="false"
                                                                            aria-label="Nghiêng bản đồ"
                                                                            title="Nghiêng bản đồ" type="button"
                                                                            class="gm-tilt gm-control-active"
                                                                            style="background: none; display: block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; top: 0px; left: 0px; overflow: hidden; width: 40px; height: 40px;"><img
                                                                                alt=""
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2018%2016%22%3E%3Cpath%20fill%3D%22%23666%22%20d%3D%22M0%2016h8V9H0v7zm10%200h8V9h-8v7zM0%207h8V0H0v7zm10-7v7h8V0h-8z%22/%3E%3C/svg%3E"
                                                                                style="width: 18px;"><img alt=""
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2018%2016%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M0%2016h8V9H0v7zm10%200h8V9h-8v7zM0%207h8V0H0v7zm10-7v7h8V0h-8z%22/%3E%3C/svg%3E"
                                                                                style="width: 18px;"><img alt=""
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2018%2016%22%3E%3Cpath%20fill%3D%22%23111%22%20d%3D%22M0%2016h8V9H0v7zm10%200h8V9h-8v7zM0%207h8V0H0v7zm10-7v7h8V0h-8z%22/%3E%3C/svg%3E"
                                                                                style="width: 18px;"></button>
                                                                    </div>
                                                                </div><gmp-internal-camera-control data-control-width="40"
                                                                    data-control-height="40" draggable="false"
                                                                    class="gmnoprint"
                                                                    style="position: absolute; cursor: pointer; user-select: none; left: 0px; top: 0px;"><button
                                                                        draggable="false"
                                                                        aria-label="Các chế độ điều khiển camera trên bản đồ"
                                                                        title="Các chế độ điều khiển camera trên bản đồ"
                                                                        type="button" class="gm-control-active"
                                                                        aria-expanded="false"
                                                                        aria-controls="7F9F79B7-D12E-4A98-AE1F-A26632A8090D"
                                                                        style="background: none 6px center / 28px no-repeat rgb(255, 255, 255); display: block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; width: 40px; height: 40px; border-radius: 50%; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px;"><img
                                                                            src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12%2019.175l2.125-2.125%201.425%201.4L12%2022l-3.55-3.55%201.425-1.4L12%2019.175zM4.825%2012l2.125%202.125-1.4%201.425L2%2012l3.55-3.55%201.4%201.425L4.825%2012zm14.35%200L17.05%209.875l1.4-1.425L22%2012l-3.55%203.55-1.4-1.425L19.175%2012zM12%204.825L9.875%206.95%208.45%205.55%2012%202l3.55%203.55-1.425%201.4L12%204.825z%22%20fill%3D%22%23666%22/%3E%3C/svg%3E"
                                                                            alt=""
                                                                            style="height: 28px; width: 28px;"><img
                                                                            src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12%2019.175l2.125-2.125%201.425%201.4L12%2022l-3.55-3.55%201.425-1.4L12%2019.175zM4.825%2012l2.125%202.125-1.4%201.425L2%2012l3.55-3.55%201.4%201.425L4.825%2012zm14.35%200L17.05%209.875l1.4-1.425L22%2012l-3.55%203.55-1.4-1.425L19.175%2012zM12%204.825L9.875%206.95%208.45%205.55%2012%202l3.55%203.55-1.425%201.4L12%204.825z%22%20fill%3D%22%23666%22/%3E%3C/svg%3E"
                                                                            alt=""
                                                                            style="height: 28px; width: 28px;"><img
                                                                            src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12%2019.175l2.125-2.125L15.55%2018.45%2012%2022%208.45%2018.45%209.875%2017.05%2012%2019.175zM4.825%2012l2.125%202.125L5.55%2015.55%202%2012%205.55%208.45%206.95%209.875%204.825%2012zM19.175%2012L17.05%209.875%2018.45%208.45%2022%2012%2018.45%2015.55%2017.05%2014.125%2019.175%2012zM12%204.825L9.875%206.95%208.45%205.55%2012%202%2015.55%205.55%2014.125%206.95%2012%204.825z%22%20fill%3D%22%231A73E8%22/%3E%3C/svg%3E"
                                                                            alt=""
                                                                            style="height: 28px; width: 28px;"><img
                                                                            src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12%2019.175l2.125-2.125L15.55%2018.45%2012%2022%208.45%2018.45%209.875%2017.05%2012%2019.175zM4.825%2012l2.125%202.125L5.55%2015.55%202%2012%205.55%208.45%206.95%209.875%204.825%2012zM19.175%2012L17.05%209.875%2018.45%208.45%2022%2012%2018.45%2015.55%2017.05%2014.125%2019.175%2012zM12%204.825L9.875%206.95%208.45%205.55%2012%202%2015.55%205.55%2014.125%206.95%2012%204.825z%22%20fill%3D%22%23D1D1D1%22/%3E%3C/svg%3E"
                                                                            alt=""
                                                                            style="height: 28px; width: 28px;"></button>
                                                                    <menu id="7F9F79B7-D12E-4A98-AE1F-A26632A8090D"
                                                                        style="list-style: none; padding: 0px; display: none; position: absolute; z-index: 999999; margin: 10px; width: 140px; height: 140px; right: 100%; top: -60px;">
                                                                        <li><button draggable="false"
                                                                                aria-label="Di chuyển lên"
                                                                                title="Di chuyển lên" type="button"
                                                                                class="gm-control-active"
                                                                                style="background: none 6px center / 28px no-repeat rgb(255, 255, 255); display: block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: absolute; cursor: pointer; user-select: none; width: 40px; height: 40px; border-radius: 50%; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; top: 0px; left: 50%; transform: translateX(-50%);"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12%2010.8l-4.6%204.6L6%2014l6-6%206%206-1.4%201.4-4.6-4.6z%22%20fill%3D%22%23666%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12%2010.8l-4.6%204.6L6%2014l6-6%206%206L16.6%2015.4%2012%2010.8z%22%20fill%3D%22%23333%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12%2010.8l-4.6%204.6L6%2014l6-6%206%206-1.4%201.4-4.6-4.6z%22%20fill%3D%22%23666%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12%2010.8l-4.6%204.6L6%2014l6-6%206%206L16.6%2015.4%2012%2010.8z%22%20fill%3D%22%23D1D1D1%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"></button>
                                                                        </li>
                                                                        <li><button draggable="false"
                                                                                aria-label="Di chuyển sang trái"
                                                                                title="Di chuyển sang trái"
                                                                                type="button" class="gm-control-active"
                                                                                style="background: none 6px center / 28px no-repeat rgb(255, 255, 255); display: block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: absolute; cursor: pointer; user-select: none; width: 40px; height: 40px; border-radius: 50%; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; bottom: 50%; left: 0px; transform: translateY(50%);"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M14%2018l-6-6%206-6%201.4%201.4-4.6%204.6%204.6%204.6L14%2018z%22%20fill%3D%22%23666%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M14%2018l-6-6%206-6L15.4%207.4%2010.8%2012%2015.4%2016.6%2014%2018z%22%20fill%3D%22%23333%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M14%2018l-6-6%206-6%201.4%201.4-4.6%204.6%204.6%204.6L14%2018z%22%20fill%3D%22%23666%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M14%2018l-6-6%206-6L15.4%207.4%2010.8%2012%2015.4%2016.6%2014%2018z%22%20fill%3D%22%23D1D1D1%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"></button>
                                                                        </li>
                                                                        <li><button draggable="false"
                                                                                aria-label="Di chuyển sang phải"
                                                                                title="Di chuyển sang phải"
                                                                                type="button" class="gm-control-active"
                                                                                style="background: none 6px center / 28px no-repeat rgb(255, 255, 255); display: block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: absolute; cursor: pointer; user-select: none; width: 40px; height: 40px; border-radius: 50%; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; bottom: 50%; right: 0px; transform: translateY(50%);"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12.6%2012L8%207.4%209.4%206l6%206-6%206L8%2016.6l4.6-4.6z%22%20fill%3D%22%23666%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12.6%2012L8%207.4%209.4%206l6%206-6%206L8%2016.6%2012.6%2012z%22%20fill%3D%22%23333%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12.6%2012L8%207.4%209.4%206l6%206-6%206L8%2016.6l4.6-4.6z%22%20fill%3D%22%23666%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12.6%2012L8%207.4%209.4%206l6%206-6%206L8%2016.6%2012.6%2012z%22%20fill%3D%22%23D1D1D1%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"></button>
                                                                        </li>
                                                                        <li><button draggable="false"
                                                                                aria-label="Di chuyển xuống"
                                                                                title="Di chuyển xuống" type="button"
                                                                                class="gm-control-active"
                                                                                style="background: none 6px center / 28px no-repeat rgb(255, 255, 255); display: block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: absolute; cursor: pointer; user-select: none; width: 40px; height: 40px; border-radius: 50%; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; bottom: 0px; left: 50%; transform: translateX(-50%);"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12%2015.4l-6-6L7.4%208l4.6%204.6L16.6%208%2018%209.4l-6%206z%22%20fill%3D%22%23666%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12%2015.4l-6-6L7.4%208l4.6%204.6L16.6%208%2018%209.4l-6%206z%22%20fill%3D%22%23333%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12%2015.4l-6-6L7.4%208l4.6%204.6L16.6%208%2018%209.4l-6%206z%22%20fill%3D%22%23666%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M12%2015.4l-6-6L7.4%208l4.6%204.6L16.6%208%2018%209.4l-6%206z%22%20fill%3D%22%23666%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"></button>
                                                                        </li>
                                                                        <li><button draggable="false"
                                                                                aria-label="Phóng to" title="Phóng to"
                                                                                type="button" class="gm-control-active"
                                                                                style="background: none 6px center / 28px no-repeat rgb(255, 255, 255); display: block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: absolute; cursor: pointer; user-select: none; overflow: hidden; width: 40px; height: 40px; border-radius: 50%; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; top: 0px; right: 0px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23666%22%3E%3Cpath%20d%3D%22M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240z%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23333%22%3E%3Cpath%20d%3D%22M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240z%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23111%22%3E%3Cpath%20d%3D%22M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240z%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23d1d1d1%22%3E%3Cpath%20d%3D%22M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240z%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"></button>
                                                                        </li>
                                                                        <li><button draggable="false"
                                                                                aria-label="Thu nhỏ" title="Thu nhỏ"
                                                                                type="button" class="gm-control-active"
                                                                                style="background: none 6px center / 28px no-repeat rgb(255, 255, 255); display: block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: absolute; cursor: pointer; user-select: none; overflow: hidden; width: 40px; height: 40px; border-radius: 50%; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; bottom: 0px; right: 0px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23666%22%3E%3Cpath%20d%3D%22M200-440v-80h560v80H200z%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23333%22%3E%3Cpath%20d%3D%22M200-440v-80h560v80H200z%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23111%22%3E%3Cpath%20d%3D%22M200-440v-80h560v80H200z%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"><img
                                                                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23d1d1d1%22%3E%3Cpath%20d%3D%22M200-440v-80h560v80H200z%22/%3E%3C/svg%3E"
                                                                                    alt=""
                                                                                    style="height: 28px; width: 28px;"></button>
                                                                        </li>
                                                                    </menu>
                                                                </gmp-internal-camera-control><button draggable="false"
                                                                    aria-label="Kéo Người hình mắc áo vào bản đồ để mở Chế độ xem phố"
                                                                    title="Kéo Người hình mắc áo vào bản đồ để mở Chế độ xem phố"
                                                                    type="button" class="gm-svpc" dir="ltr"
                                                                    data-control-width="40" data-control-height="40"
                                                                    style="background: rgb(255, 255, 255); border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: absolute; cursor: pointer; user-select: none; --pegman-scaleX: 1; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px; width: 40px; height: 40px; left: 0px; top: 72px;">
                                                                    <div
                                                                        style="position: absolute; left: 50%; top: 50%; transform: scaleX(var(--pegman-scaleX));">
                                                                        <img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2023%2038%22%3E%3Cpath%20d%3D%22M16.6%2038.1h-5.5l-.2-2.9-.2%202.9h-5.5L5%2025.3l-.8%202a1.53%201.53%200%2001-1.9.9l-1.2-.4a1.58%201.58%200%2001-1-1.9v-.1c.3-.9%203.1-11.2%203.1-11.2a2.66%202.66%200%20012.3-2l.6-.5a6.93%206.93%200%20014.7-12%206.8%206.8%200%20014.9%202%207%207%200%20012%204.9%206.65%206.65%200%2001-2.2%205l.7.5a2.78%202.78%200%20012.4%202s2.9%2011.2%202.9%2011.3a1.53%201.53%200%2001-.9%201.9l-1.3.4a1.63%201.63%200%2001-1.9-.9l-.7-1.8-.1%2012.7zm-3.6-2h1.7L14.9%2020.3l1.9-.3%202.4%206.3.3-.1c-.2-.8-.8-3.2-2.8-10.9a.63.63%200%2000-.6-.5h-.6l-1.1-.9h-1.9l-.3-2a4.83%204.83%200%20003.5-4.7A4.78%204.78%200%200011%202.3H10.8a4.9%204.9%200%2000-1.4%209.6l-.3%202h-1.9l-1%20.9h-.6a.74.74%200%2000-.6.5c-2%207.5-2.7%2010-3%2010.9l.3.1L4.8%2020l1.9.3.2%2015.8h1.6l.6-8.4a1.52%201.52%200%20011.5-1.4%201.5%201.5%200%20011.5%201.4l.9%208.4zm-10.9-9.6zm17.5-.1z%22%20style%3D%22isolation%3Aisolate%22%20fill%3D%22%23333%22%20opacity%3D%22.7%22/%3E%3Cpath%20d%3D%22M5.9%2013.6l1.1-.9h7.8l1.2.9%22%20fill%3D%22%23ce592c%22/%3E%3Cellipse%20cx%3D%2210.9%22%20cy%3D%2213.1%22%20rx%3D%222.7%22%20ry%3D%22.3%22%20style%3D%22isolation%3Aisolate%22%20fill%3D%22%23ce592c%22%20opacity%3D%22.5%22/%3E%3Cpath%20d%3D%22M20.6%2026.1l-2.9-11.3a1.71%201.71%200%2000-1.6-1.2H5.699999999999999a1.69%201.69%200%2000-1.5%201.3l-3.1%2011.3a.61.61%200%2000.3.7l1.1.4a.61.61%200%2000.7-.3l2.7-6.7.2%2016.8h3.6l.6-9.3a.47.47%200%2001.44-.5h.06c.4%200%20.4.2.5.5l.6%209.3h3.6L15.7%2020.3l2.5%206.6a.52.52%200%2000.66.31l1.2-.4a.57.57%200%2000.5-.7z%22%20fill%3D%22%23fdbf2d%22/%3E%3Cpath%20d%3D%22M7%2013.6l3.9%206.7%203.9-6.7%22%20style%3D%22isolation%3Aisolate%22%20fill%3D%22%23cf572e%22%20opacity%3D%22.6%22/%3E%3Ccircle%20cx%3D%2210.9%22%20cy%3D%227%22%20r%3D%225.9%22%20fill%3D%22%23fdbf2d%22/%3E%3C/svg%3E"
                                                                            alt="Kiểm soát người hình mắc áo trong chế độ xem phố"
                                                                            style="height: 30px; width: 30px; position: absolute; transform: translate(-50%, -50%); pointer-events: none;"><img
                                                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2038%22%3E%3Cpath%20d%3D%22M22%2026.6l-2.9-11.3a2.78%202.78%200%2000-2.4-2l-.7-.5a6.82%206.82%200%20002.2-5%206.9%206.9%200%2000-13.8%200%207%207%200%20002.2%205.1l-.6.5a2.55%202.55%200%2000-2.3%202s-3%2011.1-3%2011.2v.1a1.58%201.58%200%20001%201.9l1.2.4a1.63%201.63%200%20001.9-.9l.8-2%20.2%2012.8h11.3l.2-12.6.7%201.8a1.54%201.54%200%20001.5%201%201.09%201.09%200%2000.5-.1l1.3-.4a1.85%201.85%200%2000.7-2zm-1.2.9l-1.2.4a.61.61%200%2001-.7-.3l-2.5-6.6-.2%2016.8h-9.4L6.6%2021l-2.7%206.7a.52.52%200%2001-.66.31l-1.1-.4a.52.52%200%2001-.31-.66l3.1-11.3a1.69%201.69%200%20011.5-1.3h.2l1-.9h2.3a5.9%205.9%200%20113.2%200h2.3l1.1.9h.2a1.71%201.71%200%20011.6%201.2l2.9%2011.3a.84.84%200%2001-.4.7z%22%20fill%3D%22%23333%22%20fill-opacity%3D%22.2%22/%3E%26quot%3B%3C/svg%3E"
                                                                            alt="Người hình mắc áo ở đầu Bản đồ"
                                                                            style="height: 30px; width: 30px; position: absolute; transform: translate(-50%, -50%); pointer-events: none; display: none;"><img
                                                                            alt="Kiểm soát người hình mắc áo trong chế độ xem phố"
                                                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2040%2050%22%3E%3Cpath%20d%3D%22M34-30.4l-2.9-11.3a2.78%202.78%200%2000-2.4-2l-.7-.5a6.82%206.82%200%20002.2-5%206.9%206.9%200%2000-13.8%200%207%207%200%20002.2%205.1l-.6.5a2.55%202.55%200%2000-2.3%202s-3%2011.1-3%2011.2v.1a1.58%201.58%200%20001%201.9l1.2.4a1.63%201.63%200%20001.9-.9l.8-2%20.2%2012.8h11.3l.2-12.6.7%201.8a1.54%201.54%200%20001.5%201%201.09%201.09%200%2000.5-.1l1.3-.4a1.85%201.85%200%2000.7-2zm-1.2.9l-1.2.4a.61.61%200%2001-.7-.3L28.4-36l-.2%2016.8h-9.4L18.6-36l-2.7%206.7a.52.52%200%2001-.66.31l-1.1-.4a.52.52%200%2001-.31-.66l3.1-11.3a1.69%201.69%200%20011.5-1.3h.2l1-.9h2.3a5.9%205.9%200%20113.2%200h2.3l1.1.9h.2a1.71%201.71%200%20011.6%201.2l2.9%2011.3a.84.84%200%2001-.4.7zM34%2029.6l-2.9-11.3a2.78%202.78%200%2000-2.4-2l-.7-.5a6.82%206.82%200%20002.2-5%206.9%206.9%200%2000-13.8%200%207%207%200%20002.2%205.1l-.6.5a2.55%202.55%200%2000-2.3%202s-3%2011.1-3%2011.2v.1a1.58%201.58%200%20001%201.9l1.2.4a1.63%201.63%200%20001.9-.9l.8-2%20.2%2012.8h11.3l.2-12.6.7%201.8a1.54%201.54%200%20001.5%201%201.09%201.09%200%2000.5-.1l1.3-.4a1.85%201.85%200%2000.7-2zm-1.2.9l-1.2.4a.61.61%200%2001-.7-.3L28.4%2024l-.2%2016.8h-9.4L18.6%2024l-2.7%206.7a.52.52%200%2001-.66.31l-1.1-.4a.52.52%200%2001-.31-.66l3.1-11.3a1.69%201.69%200%20011.5-1.3h.2l1-.9h2.3a5.9%205.9%200%20113.2%200h2.3l1.1.9h.2a1.71%201.71%200%20011.6%201.2l2.9%2011.3a.84.84%200%2001-.4.7z%22%20fill%3D%22%23333%22%20fill-opacity%3D%22.2%22/%3E%3Cpath%20d%3D%22M15.4%2038.8h-4a1.64%201.64%200%2001-1.4-1.1l-3.1-8a.9.9%200%2001-.5.1l-1.4.1a1.62%201.62%200%2001-1.6-1.4L2.3%2015.4l1.6-1.3a6.87%206.87%200%2001-3-4.6A7.14%207.14%200%20012%204a7.6%207.6%200%20014.7-3.1A7.14%207.14%200%200112.2%202a7.28%207.28%200%20012.3%209.6l2.1-.1.1%201c0%20.2.1.5.1.8a2.41%202.41%200%20011%201s1.9%203.2%202.8%204.9c.7%201.2%202.1%204.2%202.8%205.9a2.1%202.1%200%2001-.8%202.6l-.6.4a1.63%201.63%200%2001-1.5.2l-.6-.3a8.93%208.93%200%2000.5%201.3%207.91%207.91%200%20001.8%202.6l.6.3v4.6l-4.5-.1a7.32%207.32%200%2001-2.5-1.5l-.4%203.6zm-10-19.2l3.5%209.8%202.9%207.5h1.6V35l-1.9-9.4%203.1%205.4a8.24%208.24%200%20003.8%203.8h2.1v-1.4a14%2014%200%2001-2.2-3.1%2044.55%2044.55%200%2001-2.2-8l-1.3-6.3%203.2%205.6c.6%201.1%202.1%203.6%202.8%204.9l.6-.4c-.8-1.6-2.1-4.6-2.8-5.8-.9-1.7-2.8-4.9-2.8-4.9a.54.54%200%2000-.4-.3l-.7-.1-.1-.7a4.33%204.33%200%2000-.1-.5l-5.3.3%202.2-1.9a4.3%204.3%200%2000.9-1%205.17%205.17%200%2000.8-4%205.67%205.67%200%2000-2.2-3.4%205.09%205.09%200%2000-4-.8%205.67%205.67%200%2000-3.4%202.2%205.17%205.17%200%2000-.8%204%205.67%205.67%200%20002.2%203.4%203.13%203.13%200%20001%20.5l1.6.6-3.2%202.6%201%2011.5h.4l-.3-8.2z%22%20fill%3D%22%23333%22/%3E%3Cpath%20d%3D%22M3.35%2015.9l1.1%2012.5a.39.39%200%2000.36.42h.14l1.4-.1a.66.66%200%2000.5-.4l-.2-3.8-3.3-8.6z%22%20fill%3D%22%23fdbf2d%22/%3E%3Cpath%20d%3D%22M5.2%2028.8l1.1-.1a.66.66%200%2000.5-.4l-.2-3.8-1.2-3.1z%22%20fill%3D%22%23ce592b%22%20fill-opacity%3D%22.25%22/%3E%3Cpath%20d%3D%22M21.4%2035.7l-3.8-1.2-2.7-7.8L12%2015.5l3.4-2.9c.2%202.4%202.2%2014.1%203.7%2017.1%200%200%201.3%202.6%202.3%203.1v2.9m-8.4-8.1l-2-.3%202.5%2010.1.9.4v-2.9%22%20fill%3D%22%23e5892b%22/%3E%3Cpath%20d%3D%22M17.8%2025.4c-.4-1.5-.7-3.1-1.1-4.8-.1-.4-.1-.7-.2-1.1l-1.1-2-1.7-1.6s.9%205%202.4%207.1a19.12%2019.12%200%20001.7%202.4z%22%20style%3D%22isolation%3Aisolate%22%20fill%3D%22%23cf572e%22%20opacity%3D%22.6%22/%3E%3Cpath%20d%3D%22M14.4%2037.8h-3a.43.43%200%2001-.4-.4l-3-7.8-1.7-4.8-3-9%208.9-.4s2.9%2011.3%204.3%2014.4c1.9%204.1%203.1%204.7%205%205.8h-3.2s-4.1-1.2-5.9-7.7a.59.59%200%2000-.6-.4.62.62%200%2000-.3.7s.5%202.4.9%203.6a34.87%2034.87%200%20002%206z%22%20fill%3D%22%23fdbf2d%22/%3E%3Cpath%20d%3D%22M15.4%2012.7l-3.3%202.9-8.9.4%203.3-2.7%22%20fill%3D%22%23ce592b%22/%3E%3Cpath%20d%3D%22M9.1%2021.1l1.4-6.2-5.9.5%22%20style%3D%22isolation%3Aisolate%22%20fill%3D%22%23cf572e%22%20opacity%3D%22.6%22/%3E%3Cpath%20d%3D%22M12%2013.5a4.75%204.75%200%2001-2.6%201.1c-1.5.3-2.9.2-2.9%200s1.1-.6%202.7-1%22%20fill%3D%22%23bb3d19%22/%3E%3Ccircle%20cx%3D%227.92%22%20cy%3D%228.19%22%20r%3D%226.3%22%20fill%3D%22%23fdbf2d%22/%3E%3Cpath%20d%3D%22M4.7%2013.6a6.21%206.21%200%20008.4-1.9v-.1a8.89%208.89%200%2001-8.4%202z%22%20fill%3D%22%23ce592b%22%20fill-opacity%3D%22.25%22/%3E%3Cpath%20d%3D%22M21.2%2027.2l.6-.4a1.09%201.09%200%2000.4-1.3c-.7-1.5-2.1-4.6-2.8-5.8-.9-1.7-2.8-4.9-2.8-4.9a1.6%201.6%200%2000-2.17-.65l-.23.15a1.68%201.68%200%2000-.4%202.1s2.3%203.9%203.1%205.3c.6%201%202.1%203.7%202.9%205.1a.94.94%200%20001.24.49l.16-.09z%22%20fill%3D%22%23fdbf2d%22/%3E%3Cpath%20d%3D%22M19.4%2019.8c-.9-1.7-2.8-4.9-2.8-4.9a1.6%201.6%200%2000-2.17-.65l-.23.15-.3.3c1.1%201.5%202.9%203.8%203.9%205.4%201.1%201.8%202.9%205%203.8%206.7l.1-.1a1.09%201.09%200%2000.4-1.3%2057.67%2057.67%200%2000-2.7-5.6z%22%20fill%3D%22%23ce592b%22%20fill-opacity%3D%22.25%22/%3E%3C/svg%3E"
                                                                            style="display: none; height: 40px; width: 40px; position: absolute; transform: translate(-60%, -45%); pointer-events: none;">
                                                                    </div>
                                                                </button>
                                                                <div class="gmnoprint" data-control-width="40"
                                                                    data-control-height="81"
                                                                    style="position: absolute; left: 0px; top: 144px;">
                                                                    <div draggable="false"
                                                                        style="user-select: none; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px; cursor: pointer; background-color: rgb(255, 255, 255); width: 40px; height: 81px;">
                                                                        <button draggable="false" aria-label="Phóng to"
                                                                            title="Phóng to" type="button"
                                                                            class="gm-control-active"
                                                                            style="background: none rgb(255, 255, 255); display: block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; overflow: hidden; width: 40px; height: 40px; top: 0px; left: 0px;"><img
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23666%22%3E%3Cpath%20d%3D%22M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240z%22/%3E%3C/svg%3E"
                                                                                alt=""
                                                                                style="height: 28px; width: 28px;"><img
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23333%22%3E%3Cpath%20d%3D%22M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240z%22/%3E%3C/svg%3E"
                                                                                alt=""
                                                                                style="height: 28px; width: 28px;"><img
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23111%22%3E%3Cpath%20d%3D%22M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240z%22/%3E%3C/svg%3E"
                                                                                alt=""
                                                                                style="height: 28px; width: 28px;"><img
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23d1d1d1%22%3E%3Cpath%20d%3D%22M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240z%22/%3E%3C/svg%3E"
                                                                                alt=""
                                                                                style="height: 28px; width: 28px;"></button>
                                                                        <div
                                                                            style="position: relative; overflow: hidden; width: 30px; height: 1px; margin: 0px 5px; background-color: rgb(230, 230, 230); top: 0px;">
                                                                        </div><button draggable="false"
                                                                            aria-label="Thu nhỏ" title="Thu nhỏ"
                                                                            type="button" class="gm-control-active"
                                                                            style="background: none rgb(255, 255, 255); display: block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; overflow: hidden; width: 40px; height: 40px; top: 0px; left: 0px;"><img
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23666%22%3E%3Cpath%20d%3D%22M200-440v-80h560v80H200z%22/%3E%3C/svg%3E"
                                                                                alt=""
                                                                                style="height: 28px; width: 28px;"><img
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23333%22%3E%3Cpath%20d%3D%22M200-440v-80h560v80H200z%22/%3E%3C/svg%3E"
                                                                                alt=""
                                                                                style="height: 28px; width: 28px;"><img
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23111%22%3E%3Cpath%20d%3D%22M200-440v-80h560v80H200z%22/%3E%3C/svg%3E"
                                                                                alt=""
                                                                                style="height: 28px; width: 28px;"><img
                                                                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%20-960%20960%20960%22%20fill%3D%22%23d1d1d1%22%3E%3Cpath%20d%3D%22M200-440v-80h560v80H200z%22/%3E%3C/svg%3E"
                                                                                alt=""
                                                                                style="height: 28px; width: 28px;"></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div
                                                                style="margin: 0px 5px; z-index: 1000000; position: absolute; left: 0px; bottom: 0px;">
                                                                <a target="_blank" rel="noopener"
                                                                    title="Mở khu vực này trong Google Maps (mở cửa sổ mới)"
                                                                    aria-label="Mở khu vực này trong Google Maps (mở cửa sổ mới)"
                                                                    href="https://maps.google.com/maps?ll=-37.820573,144.948717&amp;z=15&amp;t=m&amp;hl=vi-VN&amp;gl=US&amp;mapclient=apiv3"
                                                                    style="display: inline;">
                                                                    <div style="width: 66px; height: 26px;"><img
                                                                            alt="Google"
                                                                            src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2069%2029%22%3E%3Cg%20opacity%3D%22.3%22%20fill%3D%22%23000%22%20stroke%3D%22%23000%22%20stroke-width%3D%221.5%22%3E%3Cpath%20d%3D%22M17.4706%207.33616L18.0118%206.79504%2017.4599%206.26493C16.0963%204.95519%2014.2582%203.94522%2011.7008%203.94522c-4.613699999999999%200-8.50262%203.7551699999999997-8.50262%208.395779999999998C3.19818%2016.9817%207.0871%2020.7368%2011.7008%2020.7368%2014.1712%2020.7368%2016.0773%2019.918%2017.574%2018.3689%2019.1435%2016.796%2019.5956%2014.6326%2019.5956%2012.957%2019.5956%2012.4338%2019.5516%2011.9316%2019.4661%2011.5041L19.3455%2010.9012H10.9508V14.4954H15.7809C15.6085%2015.092%2015.3488%2015.524%2015.0318%2015.8415%2014.403%2016.4629%2013.4495%2017.1509%2011.7008%2017.1509%209.04835%2017.1509%206.96482%2015.0197%206.96482%2012.341%206.96482%209.66239%209.04835%207.53119%2011.7008%207.53119%2013.137%207.53119%2014.176%208.09189%2014.9578%208.82348L15.4876%209.31922%2016.0006%208.80619%2017.4706%207.33616z%22/%3E%3Cpath%20d%3D%22M24.8656%2020.7286C27.9546%2020.7286%2030.4692%2018.3094%2030.4692%2015.0594%2030.4692%2011.7913%2027.953%209.39009%2024.8656%209.39009%2021.7783%209.39009%2019.2621%2011.7913%2019.2621%2015.0594c0%203.25%202.514499999999998%205.6692%205.6035%205.6692zM24.8656%2012.8282C25.8796%2012.8282%2026.8422%2013.6652%2026.8422%2015.0594%2026.8422%2016.4399%2025.8769%2017.2905%2024.8656%2017.2905%2023.8557%2017.2905%2022.8891%2016.4331%2022.8891%2015.0594%2022.8891%2013.672%2023.853%2012.8282%2024.8656%2012.8282z%22/%3E%3Cpath%20d%3D%22M35.7511%2017.2905v0H35.7469C34.737%2017.2905%2033.7703%2016.4331%2033.7703%2015.0594%2033.7703%2013.672%2034.7343%2012.8282%2035.7469%2012.8282%2036.7608%2012.8282%2037.7234%2013.6652%2037.7234%2015.0594%2037.7234%2016.4439%2036.7554%2017.2961%2035.7511%2017.2905zM35.7387%2020.7286C38.8277%2020.7286%2041.3422%2018.3094%2041.3422%2015.0594%2041.3422%2011.7913%2038.826%209.39009%2035.7387%209.39009%2032.6513%209.39009%2030.1351%2011.7913%2030.1351%2015.0594%2030.1351%2018.3102%2032.6587%2020.7286%2035.7387%2020.7286z%22/%3E%3Cpath%20d%3D%22M51.953%2010.4357V9.68573H48.3999V9.80826C47.8499%209.54648%2047.1977%209.38187%2046.4808%209.38187%2043.5971%209.38187%2041.0168%2011.8998%2041.0168%2015.0758%2041.0168%2017.2027%2042.1808%2019.0237%2043.8201%2019.9895L43.7543%2020.0168%2041.8737%2020.797%2041.1808%2021.0844%2041.4684%2021.7772C42.0912%2023.2776%2043.746%2025.1469%2046.5219%2025.1469%2047.9324%2025.1469%2049.3089%2024.7324%2050.3359%2023.7376%2051.3691%2022.7367%2051.953%2021.2411%2051.953%2019.2723v-8.8366zm-7.2194%209.9844L44.7334%2020.4196C45.2886%2020.6201%2045.878%2020.7286%2046.4808%2020.7286%2047.1616%2020.7286%2047.7866%2020.5819%2048.3218%2020.3395%2048.2342%2020.7286%2048.0801%2021.0105%2047.8966%2021.2077%2047.6154%2021.5099%2047.1764%2021.7088%2046.5219%2021.7088%2045.61%2021.7088%2045.0018%2021.0612%2044.7336%2020.4201zM46.6697%2012.8282C47.6419%2012.8282%2048.5477%2013.6765%2048.5477%2015.084%2048.5477%2016.4636%2047.6521%2017.2987%2046.6697%2017.2987%2045.6269%2017.2987%2044.6767%2016.4249%2044.6767%2015.084%2044.6767%2013.7086%2045.6362%2012.8282%2046.6697%2012.8282zM55.7387%205.22081v-.75H52.0788V20.4412H55.7387V5.22081z%22/%3E%3Cpath%20d%3D%22M63.9128%2016.0614L63.2945%2015.6492%2062.8766%2016.2637C62.4204%2016.9346%2061.8664%2017.3069%2061.0741%2017.3069%2060.6435%2017.3069%2060.3146%2017.2088%2060.0544%2017.0447%2059.9844%2017.0006%2059.9161%2016.9496%2059.8498%2016.8911L65.5497%2014.5286%2066.2322%2014.2456%2065.9596%2013.5589%2065.7406%2013.0075C65.2878%2011.8%2063.8507%209.39832%2060.8278%209.39832%2057.8445%209.39832%2055.5034%2011.7619%2055.5034%2015.0676%2055.5034%2018.2151%2057.8256%2020.7369%2061.0659%2020.7369%2063.6702%2020.7369%2065.177%2019.1378%2065.7942%2018.2213L66.2152%2017.5963%2065.5882%2017.1783%2063.9128%2016.0614zM61.3461%2012.8511L59.4108%2013.6526C59.7903%2013.0783%2060.4215%2012.7954%2060.9017%2012.7954%2061.067%2012.7954%2061.2153%2012.8161%2061.3461%2012.8511z%22/%3E%3C/g%3E%3Cpath%20d%3D%22M11.7008%2019.9868C7.48776%2019.9868%203.94818%2016.554%203.94818%2012.341%203.94818%208.12803%207.48776%204.69522%2011.7008%204.69522%2014.0331%204.69522%2015.692%205.60681%2016.9403%206.80583L15.4703%208.27586C14.5751%207.43819%2013.3597%206.78119%2011.7008%206.78119%208.62108%206.78119%206.21482%209.26135%206.21482%2012.341%206.21482%2015.4207%208.62108%2017.9009%2011.7008%2017.9009%2013.6964%2017.9009%2014.8297%2017.0961%2015.5606%2016.3734%2016.1601%2015.7738%2016.5461%2014.9197%2016.6939%2013.7454h-4.9931V11.6512h7.0298C18.8045%2012.0207%2018.8456%2012.4724%2018.8456%2012.957%2018.8456%2014.5255%2018.4186%2016.4637%2017.0389%2017.8434%2015.692%2019.2395%2013.9838%2019.9868%2011.7008%2019.9868zM29.7192%2015.0594C29.7192%2017.8927%2027.5429%2019.9786%2024.8656%2019.9786%2022.1884%2019.9786%2020.0121%2017.8927%2020.0121%2015.0594%2020.0121%2012.2096%2022.1884%2010.1401%2024.8656%2010.1401%2027.5429%2010.1401%2029.7192%2012.2096%2029.7192%2015.0594zM27.5922%2015.0594C27.5922%2013.2855%2026.3274%2012.0782%2024.8656%2012.0782S22.1391%2013.2937%2022.1391%2015.0594C22.1391%2016.8086%2023.4038%2018.0405%2024.8656%2018.0405S27.5922%2016.8168%2027.5922%2015.0594zM40.5922%2015.0594C40.5922%2017.8927%2038.4159%2019.9786%2035.7387%2019.9786%2033.0696%2019.9786%2030.8851%2017.8927%2030.8851%2015.0594%2030.8851%2012.2096%2033.0614%2010.1401%2035.7387%2010.1401%2038.4159%2010.1401%2040.5922%2012.2096%2040.5922%2015.0594zM38.4734%2015.0594C38.4734%2013.2855%2037.2087%2012.0782%2035.7469%2012.0782%2034.2851%2012.0782%2033.0203%2013.2937%2033.0203%2015.0594%2033.0203%2016.8086%2034.2851%2018.0405%2035.7469%2018.0405%2037.2087%2018.0487%2038.4734%2016.8168%2038.4734%2015.0594zM51.203%2010.4357v8.8366C51.203%2022.9105%2049.0595%2024.3969%2046.5219%2024.3969%2044.132%2024.3969%2042.7031%2022.7955%2042.161%2021.4897L44.0417%2020.7095C44.3784%2021.5143%2045.1997%2022.4588%2046.5219%2022.4588%2048.1479%2022.4588%2049.1499%2021.4487%2049.1499%2019.568V18.8617H49.0759C48.5914%2019.4612%2047.6552%2019.9786%2046.4808%2019.9786%2044.0171%2019.9786%2041.7668%2017.8352%2041.7668%2015.0758%2041.7668%2012.3%2044.0253%2010.1319%2046.4808%2010.1319%2047.6552%2010.1319%2048.5914%2010.6575%2049.0759%2011.2323H49.1499V10.4357H51.203zM49.2977%2015.084C49.2977%2013.3512%2048.1397%2012.0782%2046.6697%2012.0782%2045.175%2012.0782%2043.9267%2013.3429%2043.9267%2015.084%2043.9267%2016.8004%2045.175%2018.0487%2046.6697%2018.0487%2048.1397%2018.0487%2049.2977%2016.8004%2049.2977%2015.084zM54.9887%205.22081V19.6912H52.8288V5.22081H54.9887zM63.4968%2016.6854L65.1722%2017.8023C64.6301%2018.6072%2063.3244%2019.9869%2061.0659%2019.9869%2058.2655%2019.9869%2056.2534%2017.827%2056.2534%2015.0676%2056.2534%2012.1439%2058.2901%2010.1483%2060.8278%2010.1483%2063.3818%2010.1483%2064.6301%2012.1768%2065.0408%2013.2773L65.2625%2013.8357%2058.6843%2016.5623C59.1853%2017.5478%2059.9737%2018.0569%2061.0741%2018.0569%2062.1746%2018.0569%2062.9384%2017.5067%2063.4968%2016.6854zM58.3312%2014.9115L62.7331%2013.0884C62.4867%2012.4724%2061.764%2012.0454%2060.9017%2012.0454%2059.8012%2012.0454%2058.2737%2013.0145%2058.3312%2014.9115z%22%20fill%3D%22%23fff%22/%3E%3C/svg%3E"
                                                                            draggable="false"
                                                                            style="position: absolute; left: 0px; top: 0px; width: 66px; height: 26px; user-select: none; border: 0px; padding: 0px; margin: 0px;">
                                                                    </div>
                                                                </a></div>
                                                        </div>
                                                        <div></div>
                                                        <div>
                                                            <div
                                                                style="display: inline-flex; position: absolute; right: 0px; bottom: 0px;">
                                                                <div class="gmnoprint" style="z-index: 1000001;">
                                                                    <div draggable="false" class="gm-style-cc"
                                                                        style="user-select: none; position: relative; height: 14px; line-height: 14px;">
                                                                        <div
                                                                            style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                                                            <div style="width: 1px;"></div>
                                                                            <div
                                                                                style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;">
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            style="position: relative; padding-right: 6px; padding-left: 6px; box-sizing: border-box; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(0, 0, 0); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;">
                                                                            <button draggable="false"
                                                                                aria-label="Phím tắt" title="Phím tắt"
                                                                                type="button"
                                                                                style="background: none; display: inline-block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; color: rgb(0, 0, 0); font-family: inherit; line-height: inherit;">Phím
                                                                                tắt</button></div>
                                                                    </div>
                                                                </div>
                                                                <div class="gmnoprint" style="z-index: 1000001;">
                                                                    <div draggable="false" class="gm-style-cc"
                                                                        style="user-select: none; position: relative; height: 14px; line-height: 14px;">
                                                                        <div
                                                                            style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                                                            <div style="width: 1px;"></div>
                                                                            <div
                                                                                style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;">
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            style="position: relative; padding-right: 6px; padding-left: 6px; box-sizing: border-box; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(0, 0, 0); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;">
                                                                            <button draggable="false"
                                                                                aria-label="Dữ liệu Bản đồ"
                                                                                title="Dữ liệu Bản đồ" type="button"
                                                                                style="background: none; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; color: rgb(0, 0, 0); font-family: inherit; line-height: inherit; display: none;">Dữ
                                                                                liệu Bản đồ</button><span
                                                                                style="">Dữ liệu bản đồ ©2025
                                                                                Google</span></div>
                                                                    </div>
                                                                </div>
                                                                <div class="gmnoscreen">
                                                                    <div
                                                                        style="font-family: Roboto, Arial, sans-serif; font-size: 11px; color: rgb(0, 0, 0); direction: ltr; text-align: right; background-color: rgb(245, 245, 245);">
                                                                        Dữ liệu bản đồ ©2025 Google</div>
                                                                </div><button draggable="false"
                                                                    aria-label="Tỷ lệ bản đồ: 200 m/53 pixel"
                                                                    title="Tỷ lệ bản đồ: 200 m/53 pixel" type="button"
                                                                    class="gm-style-cc"
                                                                    aria-describedby="372D1946-EDDB-47AE-989E-DD0050BA93E0"
                                                                    style="background: none; display: none; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; height: 14px; line-height: 14px;">
                                                                    <div
                                                                        style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                                                        <div style="width: 1px;"></div>
                                                                        <div
                                                                            style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;">
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        style="position: relative; padding-right: 6px; padding-left: 6px; box-sizing: border-box; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(0, 0, 0); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;">
                                                                        <span style="color: rgb(0, 0, 0);">200
                                                                            m&nbsp;</span>
                                                                        <div
                                                                            style="position: relative; display: inline-block; height: 8px; bottom: -1px; width: 57px;">
                                                                            <div
                                                                                style="width: 100%; height: 4px; position: absolute; left: 0px; top: 0px;">
                                                                            </div>
                                                                            <div
                                                                                style="width: 4px; height: 8px; left: 0px; top: 0px;">
                                                                            </div>
                                                                            <div
                                                                                style="width: 4px; height: 8px; position: absolute; right: 0px; bottom: 0px;">
                                                                            </div>
                                                                            <div
                                                                                style="position: absolute; background-color: rgb(0, 0, 0); height: 2px; left: 1px; bottom: 1px; right: 1px;">
                                                                            </div>
                                                                            <div
                                                                                style="position: absolute; width: 2px; height: 6px; left: 1px; top: 1px; background-color: rgb(0, 0, 0);">
                                                                            </div>
                                                                            <div
                                                                                style="width: 2px; height: 6px; position: absolute; background-color: rgb(0, 0, 0); bottom: 1px; right: 1px;">
                                                                            </div>
                                                                        </div>
                                                                    </div><span id="372D1946-EDDB-47AE-989E-DD0050BA93E0"
                                                                        style="display: none;">Nhấp để chuyển đổi giữa các
                                                                        đơn vị hệ mét và hệ đo lường Anh</span>
                                                                </button>
                                                                <div class="gmnoprint gm-style-cc" draggable="false"
                                                                    style="z-index: 1000001; user-select: none; position: relative; height: 14px; line-height: 14px;">
                                                                    <div
                                                                        style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                                                        <div style="width: 1px;"></div>
                                                                        <div
                                                                            style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;">
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        style="position: relative; padding-right: 6px; padding-left: 6px; box-sizing: border-box; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(0, 0, 0); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;">
                                                                        <a aria-label="Điều khoản (mở trong thẻ mới)"
                                                                            href="https://www.google.com/intl/vi-VN_US/help/terms_maps.html"
                                                                            target="_blank" rel="noopener"
                                                                            style="text-decoration: none; cursor: pointer; color: rgb(0, 0, 0);">Điều
                                                                            khoản</a></div>
                                                                </div>
                                                                <div draggable="false" class="gm-style-cc"
                                                                    style="user-select: none; position: relative; height: 14px; line-height: 14px;">
                                                                    <div
                                                                        style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                                                        <div style="width: 1px;"></div>
                                                                        <div
                                                                            style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;">
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        style="position: relative; padding-right: 6px; padding-left: 6px; box-sizing: border-box; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(0, 0, 0); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;">
                                                                        <a target="_blank" rel="noopener"
                                                                            title="Báo cáo lỗi trong bản đồ đường hoặc hình ảnh đến Google"
                                                                            dir="ltr"
                                                                            href="https://www.google.com/maps/@-37.8205727,144.9487173,15z/data=!10m1!1e1!12b1?source=apiv3&amp;rapsrc=apiv3"
                                                                            style="font-family: Roboto, Arial, sans-serif; font-size: 10px; text-decoration: none; position: relative; color: rgb(0, 0, 0);">Báo
                                                                            cáo một lỗi bản đồ</a></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .site-content-wrapper -->
                <div data-elementor-type="footer" data-elementor-id="478"
                    class="elementor elementor-478 elementor-location-footer">
                    <div class="elementor-element elementor-element-22c97ffc e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                        data-id="22c97ffc" data-element_type="container"
                        data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                        <div class="e-con-inner" style="--kitify-section-width: 1225px;">
                            <div class="elementor-element elementor-element-861c9ce e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                data-id="861c9ce" data-element_type="container">
                                <div class="elementor-element elementor-element-afefbe8 kitify-widget-align-none elementor-widget kitify elementor-kitify-logo"
                                    data-id="afefbe8" data-element_type="widget"
                                    data-widget_type="kitify-logo.default">
                                    <div class="elementor-widget-container">
                                        <div class="kitify-logo kitify-logo-type-image kitify-logo-display-block">
                                            <a href="https://mixtas.novaworks.net/" class="kitify-logo__link"><img
                                                    src="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/footer-logo.svg"
                                                    class="kitify-logo__img kitify-logo-default" alt="Mixtas"
                                                    width="150" height="36"><img
                                                    src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/images/logo_light.svg"
                                                    class="kitify-logo__img kitify-logo-light" alt="Mixtas"
                                                    width="150" height="36"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-7276cec9 elementor-widget elementor-widget-heading"
                                    data-id="7276cec9" data-element_type="widget" data-widget_type="heading.default">
                                    <div class="elementor-widget-container">
                                        <p class="elementor-heading-title elementor-size-default">Whether you're a
                                            trendsetter, a minimalist, or an adventurer at heart, Mixtas has something for
                                            everyone. Our diverse range of styles caters to various personas. </p>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-4b1084e8 elementor-shape-circle e-grid-align-left elementor-grid-0 elementor-widget elementor-widget-social-icons"
                                    data-id="4b1084e8" data-element_type="widget"
                                    data-widget_type="social-icons.default">
                                    <div class="elementor-widget-container">
                                        <div class="elementor-social-icons-wrapper elementor-grid">
                                            <span class="elementor-grid-item">
                                                <a class="elementor-icon elementor-social-icon elementor-social-icon- elementor-repeater-item-974b910"
                                                    href="#" target="_blank">
                                                    <span class="elementor-screen-only"></span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="11"
                                                        height="19" viewBox="0 0 11 19" fill="none">
                                                        <path
                                                            d="M9.70117 10.7671H7.06445V18.6421H3.54883V10.7671H0.666016V7.53271H3.54883V5.03662C3.54883 2.22412 5.23633 0.64209 7.80273 0.64209C9.0332 0.64209 10.334 0.888184 10.334 0.888184V3.66553H8.89258C7.48633 3.66553 7.06445 4.50928 7.06445 5.42334V7.53271H10.1934L9.70117 10.7671Z">
                                                        </path>
                                                    </svg> </a>
                                            </span>
                                            <span class="elementor-grid-item">
                                                <a class="elementor-icon elementor-social-icon elementor-social-icon- elementor-repeater-item-0171b7d"
                                                    href="#" target="_blank">
                                                    <span class="elementor-screen-only"></span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="19"
                                                        height="19" viewBox="0 0 19 19" fill="none">
                                                        <path
                                                            d="M14.1828 2.32959H16.6649L11.2438 8.52412L17.6211 16.9546H12.6289L8.71603 11.8429L4.24415 16.9546H1.75861L7.55587 10.3276L1.4422 2.32959H6.56095L10.0942 7.00186L14.1828 2.32959ZM13.3109 15.471H14.6856L5.81212 3.73584H4.33556L13.3109 15.471Z">
                                                        </path>
                                                    </svg> </a>
                                            </span>
                                            <span class="elementor-grid-item">
                                                <a class="elementor-icon elementor-social-icon elementor-social-icon- elementor-repeater-item-ce3448b"
                                                    href="#" target="_blank">
                                                    <span class="elementor-screen-only"></span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="17"
                                                        height="19" viewBox="0 0 17 19" fill="none">
                                                        <g clip-path="url(#clip0_89_2537)">
                                                            <path
                                                                d="M8.50353 5.59893C6.26759 5.59893 4.46407 7.40244 4.46407 9.63838C4.46407 11.8743 6.26759 13.6778 8.50353 13.6778C10.7395 13.6778 12.543 11.8743 12.543 9.63838C12.543 7.40244 10.7395 5.59893 8.50353 5.59893ZM8.50353 12.2646C7.05861 12.2646 5.87736 11.0868 5.87736 9.63838C5.87736 8.18994 7.05509 7.01221 8.50353 7.01221C9.95197 7.01221 11.1297 8.18994 11.1297 9.63838C11.1297 11.0868 9.94845 12.2646 8.50353 12.2646ZM13.6504 5.43369C13.6504 5.95752 13.2285 6.37588 12.7082 6.37588C12.1844 6.37588 11.766 5.954 11.766 5.43369C11.766 4.91338 12.1879 4.4915 12.7082 4.4915C13.2285 4.4915 13.6504 4.91338 13.6504 5.43369ZM16.3258 6.38994C16.266 5.12783 15.9777 4.00986 15.0531 3.08877C14.132 2.16768 13.0141 1.87939 11.752 1.81611C10.4512 1.74229 6.55236 1.74229 5.25157 1.81611C3.99298 1.87588 2.87501 2.16416 1.9504 3.08525C1.02579 4.00635 0.741028 5.12432 0.677747 6.38643C0.603918 7.68721 0.603918 11.586 0.677747 12.8868C0.737512 14.1489 1.02579 15.2669 1.9504 16.188C2.87501 17.1091 3.98947 17.3974 5.25157 17.4606C6.55236 17.5345 10.4512 17.5345 11.752 17.4606C13.0141 17.4009 14.132 17.1126 15.0531 16.188C15.9742 15.2669 16.2625 14.1489 16.3258 12.8868C16.3996 11.586 16.3996 7.69072 16.3258 6.38994ZM14.6453 14.2825C14.3711 14.9716 13.8402 15.5024 13.1477 15.7802C12.1106 16.1915 9.64962 16.0966 8.50353 16.0966C7.35743 16.0966 4.89298 16.188 3.85939 15.7802C3.17032 15.506 2.63947 14.9751 2.36173 14.2825C1.9504 13.2454 2.04532 10.7845 2.04532 9.63838C2.04532 8.49229 1.95392 6.02783 2.36173 4.99424C2.63595 4.30518 3.16681 3.77432 3.85939 3.49658C4.8965 3.08525 7.35743 3.18018 8.50353 3.18018C9.64962 3.18018 12.1141 3.08877 13.1477 3.49658C13.8367 3.7708 14.3676 4.30166 14.6453 4.99424C15.0567 6.03135 14.9617 8.49229 14.9617 9.63838C14.9617 10.7845 15.0567 13.2489 14.6453 14.2825Z">
                                                            </path>
                                                        </g>
                                                    </svg> </a>
                                            </span>
                                            <span class="elementor-grid-item">
                                                <a class="elementor-icon elementor-social-icon elementor-social-icon- elementor-repeater-item-aa47dc0"
                                                    href="#" target="_blank">
                                                    <span class="elementor-screen-only"></span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                        height="19" viewBox="0 0 15 19" fill="none">
                                                        <g clip-path="url(#clip0_89_2540)">
                                                            <path
                                                                d="M7.92188 0.870605C4.31484 0.870605 0.75 3.27529 0.75 7.16709C0.75 9.64209 2.14219 11.0483 2.98594 11.0483C3.33398 11.0483 3.53437 10.078 3.53437 9.80381C3.53437 9.47686 2.70117 8.78076 2.70117 7.42021C2.70117 4.59365 4.85273 2.58975 7.63711 2.58975C10.0312 2.58975 11.8031 3.95029 11.8031 6.4499C11.8031 8.3167 11.0543 11.8183 8.62852 11.8183C7.75313 11.8183 7.0043 11.1854 7.0043 10.2784C7.0043 8.94951 7.93242 7.66279 7.93242 6.2917C7.93242 3.96436 4.63125 4.38623 4.63125 7.19873C4.63125 7.78936 4.70508 8.44326 4.96875 8.98115C4.48359 11.0694 3.49219 14.1808 3.49219 16.3323C3.49219 16.9968 3.58711 17.6507 3.65039 18.3151C3.76992 18.4487 3.71016 18.4347 3.89297 18.3679C5.66484 15.9421 5.60156 15.4675 6.40313 12.2929C6.83555 13.1155 7.95352 13.5585 8.83945 13.5585C12.573 13.5585 14.25 9.91982 14.25 6.63975C14.25 3.14873 11.2336 0.870605 7.92188 0.870605Z">
                                                            </path>
                                                        </g>
                                                    </svg> </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-78bc8008 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                data-id="78bc8008" data-element_type="container">
                                <div class="elementor-element elementor-element-675d55a4 elementor-widget elementor-widget-heading"
                                    data-id="675d55a4" data-element_type="widget" data-widget_type="heading.default">
                                    <div class="elementor-widget-container">
                                        <h3 class="elementor-heading-title elementor-size-default">About Us</h3>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-2675c66c elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list"
                                    data-id="2675c66c" data-element_type="widget"
                                    data-widget_type="icon-list.default">
                                    <div class="elementor-widget-container">
                                        <ul class="elementor-icon-list-items">
                                            <li class="elementor-icon-list-item">
                                                <a href="/order-tracking">

                                                    <span class="elementor-icon-list-text">Our Story</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/cart">

                                                    <span class="elementor-icon-list-text">Mission &amp; Values</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/wishlist">

                                                    <span class="elementor-icon-list-text">Meet the Team</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/wishlist">

                                                    <span class="elementor-icon-list-text">Sustainability Efforts</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/faqs">

                                                    <span class="elementor-icon-list-text">Brand Partnerships</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/faqs">

                                                    <span class="elementor-icon-list-text">Influencer
                                                        Collaborations</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-16032d9e e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                data-id="16032d9e" data-element_type="container">
                                <div class="elementor-element elementor-element-4d7c4cfe elementor-widget elementor-widget-heading"
                                    data-id="4d7c4cfe" data-element_type="widget" data-widget_type="heading.default">
                                    <div class="elementor-widget-container">
                                        <h3 class="elementor-heading-title elementor-size-default">Accessibility</h3>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-40eb361b elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list"
                                    data-id="40eb361b" data-element_type="widget"
                                    data-widget_type="icon-list.default">
                                    <div class="elementor-widget-container">
                                        <ul class="elementor-icon-list-items">
                                            <li class="elementor-icon-list-item">
                                                <a href="/my-account">

                                                    <span class="elementor-icon-list-text">Accessibility Statement</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/cart">

                                                    <span class="elementor-icon-list-text">Site Map</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/wishlist">

                                                    <span class="elementor-icon-list-text">Web Accessibility
                                                        Options</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/wishlist">

                                                    <span class="elementor-icon-list-text">ADA Compliance</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/wishlist">

                                                    <span class="elementor-icon-list-text">Privacy Policy</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/wishlist">

                                                    <span class="elementor-icon-list-text">Terms of Service</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-31de1b1 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                data-id="31de1b1" data-element_type="container">
                                <div class="elementor-element elementor-element-7362d692 elementor-widget elementor-widget-heading"
                                    data-id="7362d692" data-element_type="widget" data-widget_type="heading.default">
                                    <div class="elementor-widget-container">
                                        <h3 class="elementor-heading-title elementor-size-default">Join Our Community</h3>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-1ee74dbf elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list"
                                    data-id="1ee74dbf" data-element_type="widget"
                                    data-widget_type="icon-list.default">
                                    <div class="elementor-widget-container">
                                        <ul class="elementor-icon-list-items">
                                            <li class="elementor-icon-list-item">
                                                <a href="/about-us">

                                                    <span class="elementor-icon-list-text">VIP Membership</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/cart">

                                                    <span class="elementor-icon-list-text">Loyalty Program</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/wishlist">

                                                    <span class="elementor-icon-list-text">Customer Reviews</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/wishlist">

                                                    <span class="elementor-icon-list-text">Style Forums</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/wishlist">

                                                    <span class="elementor-icon-list-text">Job Openings</span>
                                                </a>
                                            </li>
                                            <li class="elementor-icon-list-item">
                                                <a href="/wishlist">

                                                    <span class="elementor-icon-list-text">Culture and Values</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-76773236 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                data-id="76773236" data-element_type="container">
                                <div class="elementor-element elementor-element-dd4dd2b elementor-widget elementor-widget-heading"
                                    data-id="dd4dd2b" data-element_type="widget" data-widget_type="heading.default">
                                    <div class="elementor-widget-container">
                                        <h2 class="elementor-heading-title elementor-size-default">Let’s get in touch</h2>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-3a84aaf4 elementor-widget elementor-widget-heading"
                                    data-id="3a84aaf4" data-element_type="widget" data-widget_type="heading.default">
                                    <div class="elementor-widget-container">
                                        <span class="elementor-heading-title elementor-size-default">Sign up for our
                                            newsletter and receive 10% off your</span>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-6e184175 elementor-widget kitify elementor-kitify-subscribe-form"
                                    data-id="6e184175" data-element_type="widget"
                                    data-widget_type="kitify-subscribe-form.default">
                                    <div class="elementor-widget-container">
                                        <div class="kitify-subscribe-form kitify-subscribe-form--inline-layout"
                                            data-settings="{&quot;redirect&quot;:false,&quot;redirect_url&quot;:&quot;#&quot;,&quot;use_target_list_id&quot;:false,&quot;target_list_id&quot;:&quot;&quot;}">
                                            <form method="POST" action="#" class="kitify-subscribe-form__form">
                                                <div class="kitify-subscribe-form__input-group">
                                                    <div class="kitify-subscribe-form__fields">
                                                        <input
                                                            class="kitify-subscribe-form__input kitify-subscribe-form__mail-field"
                                                            type="email" name="email"
                                                            placeholder="Enter your email address..."
                                                            data-instance-data="[]">
                                                    </div>
                                                    <a class="kitify-subscribe-form__submit elementor-button elementor-size-md"
                                                        href="#"><span class="elementor-icon"><i
                                                                aria-hidden="true"
                                                                class="kitify-subscribe-form__submit-icon novaicon novaicon-arrow-right"></i></span><span
                                                            class="kitify-subscribe-form__submit-text"></span></a>
                                                </div>
                                                <div class="kitify-subscribe-form__message">
                                                    <div class="kitify-subscribe-form__message-inner"><span></span></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="elementor-element elementor-element-54567fd e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                        data-id="54567fd" data-element_type="container"
                        data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                        <div class="e-con-inner" style="--kitify-section-width: 1225px;">
                            <div class="elementor-element elementor-element-32ef9720 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                data-id="32ef9720" data-element_type="container">
                                <div class="elementor-element elementor-element-55712cf9 elementor-widget elementor-widget-heading"
                                    data-id="55712cf9" data-element_type="widget" data-widget_type="heading.default">
                                    <div class="elementor-widget-container">
                                        <span class="elementor-heading-title elementor-size-default">© 2024 Mixtas All
                                            rights reserved. Designed by Novaworks</span>
                                    </div>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-ba77c84 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                data-id="ba77c84" data-element_type="container">
                                <div class="elementor-element elementor-element-3f8296cb elementor-widget elementor-widget-image"
                                    data-id="3f8296cb" data-element_type="widget" data-widget_type="image.default">
                                    <div class="elementor-widget-container">
                                        <img width="192" height="14"
                                            src="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/payment_icon.svg"
                                            class="attachment-large size-large wp-image-477" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="site-content styling__quickview" id="nova_wc_quickview">
                    <div class="nova_wc_quickview__content site-content"></div>
                </div>
            </div><!-- .site-wrapper -->
            <!-- .site-search -->
            <div class="off-canvas-wrapper">
                <div class="site-canvas-menu off-canvas position-left is-transition-overlap is-closed"
                    id="MenuOffCanvas_3726810d" data-off-canvas="" data-transition="overlap" aria-hidden="true"
                    data-i="afumxq-i">
                    <div class="row has-scrollbar">
                        <div class="header-mobiles-primary-menu">
                            <div class="is-drilldown animate-height" style="height: 228.984px; max-width: 285px;">
                                <ul id="menu-main-menu-1" class="vertical menu drilldown mobile-menu"
                                    data-drilldown=""
                                    data-back-button="&lt;li class='js-drilldown-back'&gt;&lt;a class='js_mobile_menu_back'&gt;&lt;/a&gt;&lt;/li&gt;"
                                    data-auto-height="true" data-animate-height="true" role="tree"
                                    aria-multiselectable="false" data-mutate="6nfldk-drilldown" data-n="uzweed-n">
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-has-children menu-item-766 is-drilldown-submenu-parent"
                                        role="treeitem" aria-haspopup="true" aria-label="Home"
                                        aria-expanded="false"><a tabindex="0"><span>Home</span></a>
                                        <ul class="menu vertical nested submenu is-drilldown-submenu invisible"
                                            data-submenu="" role="group" aria-hidden="true">
                                            <li class="js-drilldown-back"><a class="js_mobile_menu_back">Home</a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-1645 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a href="https://mixtas.novaworks.net/"><span>Home v1 —
                                                        ChicCanvas</span></a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-941 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/home-v2/"><span>Home v2 —
                                                        VogueVibes</span></a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1112 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/home-v3/"><span>Home v3 —
                                                        ModaMatrix</span></a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1176 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/home-v4/"><span>Home v4 —
                                                        StyleSymphony</span></a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1316 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/home-v5/"><span>Home v5 —
                                                        TrendTapestry</span></a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1368 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/home-v6/"><span>Home v6 —
                                                        HauteHarmony</span></a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1551 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/home-v7/"><span>Home v7 —
                                                        EleganceEnclave</span></a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1604 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/home-v8/"><span>Home v8 —
                                                        CoutureCanvas</span></a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1641 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/home-v9/"><span>Home v9 —
                                                        UrbanUtopia</span></a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1644 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/home-v10/"><span>Home v10 —
                                                        SilkSculpt</span></a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-79 is-drilldown-submenu-parent"
                                        role="treeitem" aria-haspopup="true" aria-label="Shop"
                                        aria-expanded="false"><a tabindex="0"><span>Shop</span></a>
                                        <ul class="menu vertical nested submenu is-drilldown-submenu invisible"
                                            data-submenu="" role="group" aria-hidden="true">
                                            <li class="js-drilldown-back"><a class="js_mobile_menu_back">Shop</a></li>
                                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-358 is-drilldown-submenu-parent is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem" aria-haspopup="true" aria-label="Shop Pages"
                                                aria-expanded="false"><a tabindex="0"><span>Shop Pages</span></a>
                                                <ul class="menu vertical nested submenu is-drilldown-submenu invisible"
                                                    data-submenu="" role="group" aria-hidden="true">
                                                    <li class="js-drilldown-back"><a class="js_mobile_menu_back">Shop
                                                            Pages</a></li>
                                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-360 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/shop/"><span>Shop — Left
                                                                Sidebar</span></a></li>
                                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-359 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/shop/?theme_template_id=353"><span>Shop
                                                                — Right Sidebar</span></a></li>
                                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-368 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/shop/?theme_template_id=363"><span>Shop
                                                                — Fullwidth</span></a></li>
                                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-375 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/shop/?theme_template_id=371"><span>Shop
                                                                — No Sidebar</span></a></li>
                                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-382 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/shop/?theme_template_id=376"><span>Shop
                                                                — 2 Columns</span></a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-408 is-drilldown-submenu-parent is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem" aria-haspopup="true" aria-label="Product Layouts"
                                                aria-expanded="false"><a tabindex="0"><span>Product Layouts</span></a>
                                                <ul class="menu vertical nested submenu is-drilldown-submenu invisible"
                                                    data-submenu="" role="group" aria-hidden="true">
                                                    <li class="js-drilldown-back"><a class="js_mobile_menu_back">Product
                                                            Layouts</a></li>
                                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-409 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/product/carhartt-american-script-sweat-tobacco/"><span>Product
                                                                — Layout v1</span></a></li>
                                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-414 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/product/carhartt-american-script-sweat-tobacco/?theme_template_id=410"><span>Product
                                                                — Layout v2</span></a></li>
                                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-421 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/product/carhartt-american-script-sweat-tobacco/?theme_template_id=417"><span>Product
                                                                — Layout v3</span></a></li>
                                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-426 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/product/carhartt-american-script-sweat-tobacco/?theme_template_id=422"><span>Product
                                                                — Layout v4</span></a></li>
                                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-435 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/product/carhartt-american-script-sweat-tobacco/?theme_template_id=430"><span>Product
                                                                — Layout v5</span></a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-436 is-drilldown-submenu-parent is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem" aria-haspopup="true" aria-label="Product Pages"
                                                aria-expanded="false"><a tabindex="0"><span>Product Pages</span></a>
                                                <ul class="menu vertical nested submenu is-drilldown-submenu invisible"
                                                    data-submenu="" role="group" aria-hidden="true">
                                                    <li class="js-drilldown-back"><a class="js_mobile_menu_back">Product
                                                            Pages</a></li>
                                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-437 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/product/carhartt-detroit-jacket-summer-zeus-rigid/"><span>Product
                                                                — Simple</span></a></li>
                                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-438 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/product/the-north-face-denali-jacket-summit-gold/"><span>Product
                                                                — Variable</span></a></li>
                                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-439 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/product/carhartt-hooded-coach-jacket-cypress/"><span>Product
                                                                — Grouped</span></a></li>
                                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-440 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/product/carhartt-windbreaker-pullover-winter-black/"><span>Product
                                                                — External / Affiliate</span></a></li>
                                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-441 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/product/polar-welcome-to-the-new-age-ls-tee-black/"><span>Product
                                                                — Out of Stock</span></a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-442 is-drilldown-submenu-parent is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem" aria-haspopup="true" aria-label="Core Pages"
                                                aria-expanded="false"><a tabindex="0"><span>Core Pages</span></a>
                                                <ul class="menu vertical nested submenu is-drilldown-submenu invisible"
                                                    data-submenu="" role="group" aria-hidden="true">
                                                    <li class="js-drilldown-back"><a class="js_mobile_menu_back">Core
                                                            Pages</a></li>
                                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-445 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/my-account/"><span>My
                                                                account</span></a></li>
                                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-447 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/cart/"><span>Shopping
                                                                Cart</span></a></li>
                                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-446 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/checkout/"><span>Checkout</span></a>
                                                    </li>
                                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-443 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/order-tracking/"><span>Order
                                                                Tracking</span></a></li>
                                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-444 is-submenu-item is-drilldown-submenu-item"
                                                        role="treeitem"><a
                                                            href="https://mixtas.novaworks.net/wishlist/"><span>Wishlist</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-80 is-drilldown-submenu-parent"
                                        role="treeitem" aria-haspopup="true" aria-label="Pages"
                                        aria-expanded="false"><a tabindex="0"><span>Pages</span></a>
                                        <ul class="menu vertical nested submenu is-drilldown-submenu invisible"
                                            data-submenu="" role="group" aria-hidden="true">
                                            <li class="js-drilldown-back"><a class="js_mobile_menu_back">Pages</a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-83 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/about-us/"><span>About
                                                        Us</span></a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-81 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/faqs/"><span>FAQs</span></a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-82 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/order-tracking/"><span>Order
                                                        Tracking</span></a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-77 is-drilldown-submenu-parent"
                                        role="treeitem" aria-haspopup="true" aria-label="Blog"
                                        aria-expanded="false"><a tabindex="0"><span>Blog</span></a>
                                        <ul class="menu vertical nested submenu is-drilldown-submenu invisible"
                                            data-submenu="" role="group" aria-hidden="true">
                                            <li class="js-drilldown-back"><a class="js_mobile_menu_back">Blog</a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-644 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a href="https://mixtas.novaworks.net/blog/"><span>Blog
                                                        — Style 01</span></a></li>
                                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-643 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/blog/?theme_template_id=637"><span>Blog
                                                        — Style 02</span></a></li>
                                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-652 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/blog/?theme_template_id=646"><span>Blog
                                                        — Style 03</span></a></li>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-post menu-item-645 is-submenu-item is-drilldown-submenu-item"
                                                role="treeitem"><a
                                                    href="https://mixtas.novaworks.net/2023/12/gentlemans-gazette-a-guide-to-timeless-mens-fashion/"><span>Blog
                                                        — Single</span></a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-70 current_page_item menu-item-84"
                                        role="treeitem"><a href="https://mixtas.novaworks.net/contact-us/"
                                            aria-current="page"><span>Contact Us</span></a></li>
                                </ul>
                            </div> <button class="close-button" aria-label="Close menu" type="button"
                                data-close="">
                                <svg class="nova-close-canvas">
                                    <use xlink:href="#nova-close-canvas"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="js-off-canvas-overlay is-overlay-fixed"></div>
                <div id="headerSearchModal" class="full-search-reveal animated headerSearchModal-off"
                    style="position: fixed; width: 100%; height: 100%; top: 0px; left: 0px; overflow-y: auto; z-index: -99999; opacity: 0; visibility: hidden; animation-duration: 0.6s;">
                    <button id="btn-close-search-modal" class="close-button close-headerSearchModal"
                        aria-label="Close menu" type="button" data-close="">
                        <svg class="nova-close-canvas">
                            <use xlink:href="#nova-close-canvas"></use>
                        </svg>
                    </button>
                    <div class="site-search full-screen">
                        <div class="header-search">


                            <form class="header_search_form" role="search" method="get"
                                action="https://mixtas.novaworks.net/">
                                <div class="header_search_form_inner">
                                    <div class="header_search_input_wrapper">
                                        <input name="s" id="search_410" class="header_search_input"
                                            type="search" autocomplete="off" value="" data-min-chars="3"
                                            placeholder="Product Search">

                                        <input type="hidden" name="post_type" value="product">
                                    </div>
                                    <div class="header_search_button_wrapper">
                                        <button class="header_search_button" type="submit">
                                            <svg class="mixtas-btn-search">
                                                <use xlink:href="#mixtas-btn-search"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="header_search_ajax_loading">
                                    <span></span>
                                </div>
                                <div class="header_search_ajax_results_wrapper">
                                    <div class="header_search_ajax_results">
                                        <div class="header_search_icon">
                                            <svg class="mixtas-search-product-icon">
                                                <use xlink:href="#mixtas-search-product-icon"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="kitify-offcanvas minicart-canvas site-canvas-menu off-canvas position-right is-transition-overlap is-closed"
                    id="MiniCartCanvas_4cfba4d5" data-off-canvas="" data-transition="overlap" aria-hidden="true"
                    data-i="xf0ql4-i">
                    <h2 class="title">Shopping Cart
                        <span class="nova_js_count_bag_item_canvas count-item-canvas">0</span>

                    </h2>
                    <div class="add_ajax_loading">
                        <span></span>
                    </div>
                    <div class="widget woocommerce widget_shopping_cart">
                        <h2 class="widgettitle">Cart</h2>
                        <div class="widget_shopping_cart_content">

                            <p class="woocommerce-mini-cart__empty-message">No products in the cart.</p>


                        </div>
                    </div> <button class="close-button" aria-label="Close menu" type="button" data-close="">
                        <svg class="nova-close-canvas">
                            <use xlink:href="#nova-close-canvas"></use>
                        </svg>
                    </button>
                </div>
                <div class="js-off-canvas-overlay is-overlay-fixed"></div>
                <div class="nova-offcanvas login-canvas site-canvas-menu off-canvas position-right is-transition-overlap is-closed"
                    id="AcccountCanvas_Popup" data-off-canvas="" data-transition="overlap" aria-hidden="true"
                    data-i="3jqdgj-i">
                    <div class="nova-offcanvas__content nova_box_ps ps ps--theme_default ps--active-y"
                        data-ps-id="72439ac4-7cfb-9dc2-4390-5ac6d0fe36ea">


                        <div class="container">

                            <div class="woocommerce-notices-wrapper"></div>
                            <div class="nova-login-wrapper is_popup">

                                <div class="nova-form-container">

                                    <div id="nova-login-form" class="">

                                        <h2 class="page-title">Login</h2>


                                        <form action="https://mixtas.novaworks.net/my-account/"
                                            class="woocommerce-form woocommerce-form-login login" method="post">

                                            <input type="hidden" name="redirect"
                                                value="https://mixtas.novaworks.net/my-account/">



                                            <p
                                                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <input type="text"
                                                    class="woocommerce-Input woocommerce-Input--text input-text"
                                                    name="username" id="username"
                                                    placeholder="Username or email address" autocomplete="username"
                                                    value="">
                                            </p>
                                            <p
                                                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <input class="woocommerce-Input woocommerce-Input--text input-text"
                                                    type="password" name="password" id="password"
                                                    placeholder="Password" autocomplete="current-password">
                                            </p>


                                            <p class="form-row form-group">
                                                <label
                                                    class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme inline">
                                                    <input
                                                        class="woocommerce-form__input woocommerce-form__input-checkbox"
                                                        name="rememberme" type="checkbox" id="rememberme"
                                                        value="forever"> <span>Remember me</span>
                                                </label>
                                            </p>

                                            <p class="form-actions">
                                                <input type="hidden" id="woocommerce-login-nonce"
                                                    name="woocommerce-login-nonce" value="e43d964ea3"><input
                                                    type="hidden" name="_wp_http_referer" value="/contact-us/">
                                                <button type="submit"
                                                    class="woocommerce-button button woocommerce-form-login__submit"
                                                    name="login" value="Log in">Log in</button>
                                                <span class="woocommerce-LostPassword lost_password">
                                                    <a href="https://mixtas.novaworks.net/my-account/lost-password/">Lost
                                                        your password?</a>
                                                </span>
                                            </p>



                                            <p class="form-actions extra">Not a member?<a href="#nova-register-wrap"
                                                    class="register-link">Register</a></p>




                                        </form>

                                    </div>



                                    <div id="nova-register-form" class="">

                                        <h2 class="page-title">Register</h2>


                                        <form action="https://mixtas.novaworks.net/my-account/"
                                            class="woocommerce-form woocommerce-form-register register" method="post">

                                            <input type="hidden" name="redirect"
                                                class="et-login-popup-redirect-input"
                                                value="https://mixtas.novaworks.net/my-account/">




                                            <p
                                                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <input type="email"
                                                    class="woocommerce-Input woocommerce-Input--text input-text"
                                                    name="email" id="reg_email" placeholder="Email address"
                                                    autocomplete="email" value="">
                                            </p>


                                            <p>A password will be sent to your email address.</p>


                                            <wc-order-attribution-inputs><input type="hidden"
                                                    name="wc_order_attribution_source_type" value="organic"><input
                                                    type="hidden" name="wc_order_attribution_referrer"
                                                    value="https://www.google.com/"><input type="hidden"
                                                    name="wc_order_attribution_utm_campaign" value="(none)"><input
                                                    type="hidden" name="wc_order_attribution_utm_source"
                                                    value="google"><input type="hidden"
                                                    name="wc_order_attribution_utm_medium" value="organic"><input
                                                    type="hidden" name="wc_order_attribution_utm_content"
                                                    value="(none)"><input type="hidden"
                                                    name="wc_order_attribution_utm_id" value="(none)"><input
                                                    type="hidden" name="wc_order_attribution_utm_term"
                                                    value="(none)"><input type="hidden"
                                                    name="wc_order_attribution_utm_source_platform"
                                                    value="(none)"><input type="hidden"
                                                    name="wc_order_attribution_utm_creative_format"
                                                    value="(none)"><input type="hidden"
                                                    name="wc_order_attribution_utm_marketing_tactic"
                                                    value="(none)"><input type="hidden"
                                                    name="wc_order_attribution_session_entry"
                                                    value="https://mixtas.novaworks.net/"><input type="hidden"
                                                    name="wc_order_attribution_session_start_time"
                                                    value="2025-10-19 06:03:16"><input type="hidden"
                                                    name="wc_order_attribution_session_pages" value="7"><input
                                                    type="hidden" name="wc_order_attribution_session_count"
                                                    value="1"><input type="hidden"
                                                    name="wc_order_attribution_user_agent"
                                                    value="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36"></wc-order-attribution-inputs>
                                            <div class="woocommerce-privacy-policy-text">
                                                <p>Your personal data will be used to support your experience throughout
                                                    this website, to manage access to your account, and for other purposes
                                                    described in our <a href="https://mixtas.novaworks.net/?page_id=3"
                                                        class="woocommerce-privacy-policy-link" target="_blank">privacy
                                                        policy</a>.</p>
                                            </div>
                                            <p class="woocommerce-form-row form-row">
                                                <input type="hidden" id="woocommerce-register-nonce"
                                                    name="woocommerce-register-nonce" value="25329d721b"><input
                                                    type="hidden" name="_wp_http_referer" value="/contact-us/">
                                                <button type="submit"
                                                    class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit"
                                                    name="register" value="Register">Register</button>
                                            </p>


                                            <p class="form-actions extra">Already a member?<a href="#nova-login-wrap"
                                                    class="login-link">Login</a></p>



                                        </form>

                                    </div>


                                </div>

                            </div>


                        </div>
                        <div class="ps__scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                            <div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__scrollbar-y-rail" style="top: 0px; right: 0px; height: 371px;">
                            <div class="ps__scrollbar-y" tabindex="0" style="top: 0px; height: 333px;"></div>
                        </div>
                    </div>
                    <button class="close-button" aria-label="Close menu" type="button" data-close="">
                        <svg class="nova-close-canvas">
                            <use xlink:href="#nova-close-canvas"></use>
                        </svg>
                    </button>
                </div>
                <div class="js-off-canvas-overlay is-overlay-fixed"></div>


            </div>
            <div id="svg-defs" class="svg-defs hide">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <symbol id="mixtas-burger-menu" fill="none" viewBox="0 0 22 16"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor" d="M0 0h22v2H0zM0 7h10v2H0zM0 14h16v2H0z"></path>
                        </symbol>
                        <symbol id="mixtas-search" fill="none" viewBox="0 0 19 20">
                            <path d="M18.0211 18.4375L12.8824 13.2988" stroke="currentColor" stroke-width="1.2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                            <path
                                d="M8.02112 15.3125C11.8181 15.3125 14.8961 12.2345 14.8961 8.4375C14.8961 4.64054 11.8181 1.5625 8.02112 1.5625C4.22416 1.5625 1.14612 4.64054 1.14612 8.4375C1.14612 12.2345 4.22416 15.3125 8.02112 15.3125Z"
                                stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </symbol>
                        <symbol id="mixtas-bag" fill="none" viewBox="0 0 18 21"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M3.50856 19.6429H13.6343C15.4114 19.6429 16.8571 18.1972 16.8571 16.42V6.78573C16.8571 6.47144 16.6 6.2143 16.2857 6.2143H12.8571V5.35716C12.8571 2.9943 10.9343 1.07144 8.57142 1.07144C6.20856 1.07144 4.2857 2.9943 4.2857 5.35716V6.2143H0.857134C0.542848 6.2143 0.285706 6.47144 0.285706 6.78573V16.42C0.285706 18.1972 1.73142 19.6429 3.50856 19.6429ZM5.42856 5.35716C5.42856 3.62287 6.83713 2.2143 8.57142 2.2143C10.3057 2.2143 11.7143 3.62287 11.7143 5.35716V6.2143H5.42856V5.35716ZM1.42856 7.35716H4.2857V8.78573C4.2857 9.10001 4.54285 9.35716 4.85713 9.35716C5.17142 9.35716 5.42856 9.10001 5.42856 8.78573V7.35716H11.7143V8.78573C11.7143 9.10001 11.9714 9.35716 12.2857 9.35716C12.6 9.35716 12.8571 9.10001 12.8571 8.78573V7.35716H15.7143V16.42C15.7143 17.5657 14.78 18.5 13.6343 18.5H3.50856C2.36285 18.5 1.42856 17.5657 1.42856 16.42V7.35716Z"
                                fill="currentColor"></path>
                        </symbol>
                        <symbol fill="none" id="mixtas-wishlist" viewBox="0 0 20 18"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.10276 0.535722C1.83186 1.44929 -0.014983 3.82623 0.26654 7.33722C0.477821 9.97215 1.93049 12.1153 3.64664 13.7278C5.36367 15.3411 7.39577 16.4739 8.89721 17.0966C9.41075 17.3094 9.98779 17.3218 10.512 17.1222C12.0881 16.5221 14.1129 15.3949 15.8125 13.7748C17.5105 12.1562 18.9254 10.004 19.1783 7.35969C19.6544 3.79445 17.7508 1.42311 15.4153 0.528745C13.4653 -0.218011 11.0862 0.0495936 9.7063 1.64133C8.31911 0.037531 6.02213 -0.236441 4.10276 0.535722ZM4.59785 1.76639C6.37434 1.05172 8.28816 1.53022 9.1221 3.13029C9.23724 3.35128 9.46656 3.48906 9.71577 3.48697C9.96498 3.4849 10.192 3.3433 10.3035 3.12042C11.0791 1.56961 13.0744 1.05272 14.941 1.76755C16.7373 2.45542 18.2576 4.26655 17.8619 7.19546C17.8607 7.20431 17.8596 7.21324 17.8588 7.22208C17.6487 9.45569 16.4499 11.3346 14.8972 12.8146C13.3432 14.2958 11.4761 15.3357 10.0401 15.8825C9.8371 15.9597 9.61062 15.9563 9.40536 15.8712C8.01666 15.2953 6.13049 14.2415 4.55499 12.761C2.9786 11.2799 1.76454 9.42244 1.58883 7.23119C1.35374 4.29929 2.86493 2.46355 4.59785 1.76639Z"
                                fill="currentColor"></path>
                        </symbol>
                        <symbol id="mixtas-menu-user" fill="none" viewBox="0 0 20 21"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_15_749)">
                                <path
                                    d="M0.833313 19.6667C0.833313 15.0642 4.56415 11.3333 9.16665 11.3333H10.8333C15.4358 11.3333 19.1666 15.0642 19.1666 19.6667"
                                    stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M10 11.3333C12.7614 11.3333 15 9.09477 15 6.33334C15 3.57192 12.7614 1.33334 10 1.33334C7.23858 1.33334 5 3.57192 5 6.33334C5 9.09477 7.23858 11.3333 10 11.3333Z"
                                    stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </g>
                        </symbol>
                        <symbol id="mixtas-shopbycat" viewBox="0 0 27 14">
                            <g fill="currentColor" fill-rule="evenodd">
                                <path
                                    d="M26.085 1.342H1.135c-.314 0-.568-.225-.568-.5 0-.278.254-.501.567-.501h24.951c.313 0 .567.223.567.501 0 .275-.254.5-.567.5M26.085 4.342H1.135c-.314 0-.568-.225-.568-.5 0-.278.254-.501.567-.501h24.951c.313 0 .567.223.567.501 0 .275-.254.5-.567.5M26.085 7.342H1.135c-.314 0-.568-.225-.568-.5 0-.278.254-.501.567-.501h24.951c.313 0 .567.223.567.501 0 .275-.254.5-.567.5M26.085 10.342H1.135c-.314 0-.568-.225-.568-.5 0-.278.254-.501.567-.501h24.951c.313 0 .567.223.567.501 0 .275-.254.5-.567.5M14.744 13.342H1.134c-.313 0-.567-.225-.567-.5 0-.278.254-.501.567-.501h13.61c.313 0 .567.223.567.501 0 .275-.254.5-.567.5">
                                </path>
                            </g>
                        </symbol>
                        <symbol id="mixtas-addtocart" viewBox="0 0 14 16" fill="none">
                            <path d="M7.6 14.6H1V4.40002H11.8V8.60002" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <path
                                d="M4 6.20002V3.80002C4 2.47462 5.0746 1.40002 6.4 1.40002C7.7254 1.40002 8.8 2.47462 8.8 3.80002V6.20002"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M11.2 11V14.6" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <path d="M9.39996 12.8H13" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </symbol>
                        <symbol id="mixtas-mc-fb" viewBox="0 0 26 26">
                            <g fill="none" fill-rule="evenodd">
                                <path d="M-2-2h30v30H-2z"></path>
                                <path
                                    d="M15.1 11.75h-1.7a.4.4 0 0 1-.4-.4v-.85a3.75 3.75 0 0 1 3.75-3.75h2.1c.22 0 .4.18.4.4v1.7a.4.4 0 0 1-.4.4h-2.1c-.69 0-1.25.56-1.25 1.25v.85a.4.4 0 0 1-.4.4z"
                                    fill="var(--site-accent-color)"></path>
                                <path
                                    d="M13 23v-7.5h-2a.5.5 0 0 1-.5-.5v-1.5a.5.5 0 0 1 .5-.5h7.75a.5.5 0 0 1 .5.5V15a.5.5 0 0 1-.5.5H15.5V23H18a5 5 0 0 0 5-5V8a5 5 0 0 0-5-5H8a5 5 0 0 0-5 5v10a5 5 0 0 0 5 5h5zM8 .5h10A7.5 7.5 0 0 1 25.5 8v10a7.5 7.5 0 0 1-7.5 7.5H8A7.5 7.5 0 0 1 .5 18V8A7.5 7.5 0 0 1 8 .5z"
                                    fill="currentColor"></path>
                            </g>
                        </symbol>
                        <symbol id="mixtas-btn-search" viewBox="0 0 22 22">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M14.962 14.12l4.86 4.86a.6.6 0 0 1-.42 1.02.603.603 0 0 1-.422-.177l-4.86-4.86a8.493 8.493 0 0 1-5.592 2.092C3.827 17.055 0 13.228 0 8.528 0 3.827 3.823 0 8.528 0c4.7 0 8.527 3.823 8.527 8.528 0 2.137-.789 4.093-2.093 5.592zM8.523 1.197c-4.04 0-7.33 3.286-7.33 7.33 0 4.045 3.29 7.336 7.33 7.336 4.045 0 7.33-3.295 7.33-7.335s-3.285-7.33-7.33-7.33z"
                                fill="currentColor"></path>
                        </symbol>
                        <symbol id="mixtas-search-product-icon" viewBox="0 0 48 48">
                            <g transform="translate(.5 .5)" fill="none" stroke="currentColor"
                                stroke-miterlimit="10">
                                <path data-cap="butt" data-color="color-2" d="M46 43l-5.757-5.757"></path>
                                <circle data-color="color-2" stroke-linecap="square" cx="36" cy="33"
                                    r="6"></circle>
                                <path stroke-linecap="square"
                                    d="M24 31H2v0a6 6 0 0 0 6 6h16M6 26V10a4 4 0 0 1 4-4h28a4 4 0 0 1 4 4v11M23 12h2">
                                </path>
                            </g>
                        </symbol>
                        <symbol id="nova-close-canvas" viewBox="0 0 22 22">
                            <path
                                d="M12.592 11.015l8.988-8.939c.43-.426.43-1.117 0-1.542a1.108 1.108 0 0 0-1.558 0l-8.98 8.931L1.977.401A1.1 1.1 0 0 0 .42.4a1.107 1.107 0 0 0 0 1.562l9.057 9.058-9.09 9.039a1.084 1.084 0 0 0 0 1.543c.43.426 1.129.426 1.558 0l9.082-9.032 9.028 9.028a1.1 1.1 0 0 0 1.557 0c.43-.432.43-1.131 0-1.562l-9.02-9.022z"
                                fill="currentColor" fill-rule="evenodd"></path>
                        </symbol>
                        <symbol id="mixtas-settings-bar" viewBox="0 0 26 26">
                            <g stroke="currentColor" fill="none" fill-rule="evenodd" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M3.694 5.381c.031-.037.069-.081.106-.119.456-.468.919-.924 1.388-1.387.612-.6 1.35-.656 2.05-.156.374.268.75.531 1.112.806.119.087.213.106.356.038.419-.194.838-.37 1.263-.538.137-.05.194-.125.219-.262.074-.475.13-.957.25-1.425a2.87 2.87 0 0 1 .38-.832c.188-.281.52-.381.826-.487h2.618a.554.554 0 0 0 .107.05c.625.175.987.594 1.106 1.225.088.475.169.95.238 1.425.018.137.075.212.212.262.456.175.906.375 1.363.55a.356.356 0 0 0 .287-.025c.394-.262.775-.544 1.163-.819.718-.506 1.443-.45 2.068.17l.306.305M22.07 5.076c.02.02-.03-.03 0 0M22.637 6.175c.063.381-.05.713-.33 1.119-.27.381-.55.756-.807 1.144a.355.355 0 0 0-.031.287c.168.444.362.875.531 1.319.05.131.125.181.25.2.475.075.956.131 1.425.25.281.069.556.2.794.362.287.194.4.525.5.844v2.619a.746.746 0 0 0-.05.1c-.181.631-.607.993-1.25 1.112-.475.088-.95.163-1.425.231-.144.02-.213.088-.263.22-.169.424-.337.85-.525 1.268-.062.144-.05.238.038.356.281.375.544.756.812 1.138.488.694.438 1.425-.156 2.031-.456.469-.919.931-1.387 1.388-.607.593-1.338.65-2.032.156-.394-.275-.781-.563-1.181-.838a.35.35 0 0 0-.262-.031c-.45.175-.894.356-1.332.55a.372.372 0 0 0-.187.244c-.094.475-.163.95-.244 1.425-.094.556-.394.956-.912 1.181-.1.044-.2.075-.3.112h-2.62c-.018-.012-.037-.03-.056-.037-.687-.175-1.062-.631-1.168-1.325-.069-.456-.156-.906-.225-1.356-.019-.138-.075-.213-.213-.269-.094-.038-.181-.069-.275-.106M8.575 21.469a.22.22 0 0 0-.088.037c-.406.275-.8.563-1.2.844-.693.487-1.418.431-2.025-.169-.462-.45-.918-.906-1.368-1.369-.6-.612-.657-1.343-.163-2.05.263-.375.531-.75.806-1.118.094-.119.1-.219.038-.356a18.06 18.06 0 0 1-.525-1.244c-.056-.157-.144-.213-.294-.238-.475-.075-.956-.143-1.425-.243a2.544 2.544 0 0 1-.7-.288c-.337-.206-.469-.563-.594-.919v-.931M1.031 12.113v-.375a.746.746 0 0 0 .05-.1c.182-.638.613-.994 1.25-1.107.475-.087.95-.15 1.425-.244a.363.363 0 0 0 .225-.18c.194-.438.375-.888.544-1.338a.32.32 0 0 0-.025-.263c-.281-.412-.575-.812-.856-1.218a1.862 1.862 0 0 1-.207-.375">
                                </path>
                                <path
                                    d="M11.044 16.325c.07.04.03-.04.1 0m1.319.444c.175.025.35.037.525.037 2.087.019 3.83-1.719 3.825-3.812 0-2.094-1.7-3.8-3.807-3.813C10.92 9.162 9.181 10.9 9.181 13c0 .906.319 1.737.85 2.394">
                                </path>
                            </g>
                        </symbol>
                        <symbol id="mixtas-menu-bar" fill="none" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12h22M1 5h22M1 19h22" stroke="currentColor" stroke-width="1"
                                stroke-miterlimit="10" stroke-linecap="square"></path>
                        </symbol>
                        <symbol id="mixtas-user-bar" viewBox="0 0 24 25">
                            <g fill="none" fill-rule="evenodd">
                                <circle stroke="currentColor" stroke-linecap="round" cx="12" cy="12"
                                    r="11.52"></circle>
                                <path d="M0 0h24v24H0z"></path>
                                <path
                                    d="M14.368 17.053c-.07-.773-.043-1.313-.043-2.02.35-.184.978-1.356 1.084-2.347.275-.022.71-.291.837-1.352.069-.57-.204-.89-.37-.991.448-1.349 1.38-5.52-1.722-5.951-.32-.56-1.137-.844-2.2-.844-4.249.078-4.762 3.209-3.83 6.795-.166.1-.438.421-.37.99.128 1.062.562 1.33.837 1.353.106.99.758 2.163 1.11 2.347 0 .707.026 1.247-.044 2.02-.605 1.628-3.714 1.755-5.507 3.324 1.875 1.888 4.913 3.238 8.12 3.238 3.206 0 6.975-2.531 7.602-3.222-1.782-1.584-4.897-1.707-5.504-3.34z"
                                    stroke="currentColor" stroke-linecap="round"></path>
                            </g>
                        </symbol>
                        <symbol id="mixtas-wishlist-bar" viewBox="0 0 28 25">
                            <path
                                d="M3.205 13.395A7.52 7.52 0 1 1 13.837 2.757 7.52 7.52 0 0 1 24.47 13.395L13.837 24 3.205 13.395z"
                                stroke="currentColor" fill="none" fill-rule="evenodd" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </symbol>
                        <symbol id="mixtas-bag-bar" viewBox="0 0 18 22">
                            <g stroke="currentColor" stroke-width="1" fill="none" fill-rule="evenodd">
                                <path
                                    d="M16.106 21H1.45A.457.457 0 0 1 1 20.552V6.448C1 6.207 1.207 6 1.45 6h14.656c.242 0 .45.207.45.448v14.104a.457.457 0 0 1-.45.448z"
                                    stroke-linecap="square"></path>
                                <path d="M4.333 6c0-5 4.445-5 4.445-5s4.444 0 4.444 5"></path>
                            </g>
                        </symbol>
                        <symbol id="mixtas-grid" viewBox="0 0 20 20">
                            <g stroke="currentColor" fill="none" fill-rule="evenodd">
                                <path d="M.5.5h8v8h-8zM11.5.5h8v8h-8zM11.5 11.5h8v8h-8zM.5 11.5h8v8h-8z"></path>
                            </g>
                        </symbol>
                        <symbol id="mixtas-list" fill="none" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 2H2v7h7V2zM9 15H2v7h7v-7zM14 3h8M14 8h8M14 16h8M14 21h8" stroke="currentColor"
                                stroke-width="1" stroke-miterlimit="10" stroke-linecap="square"></path>
                        </symbol>
                        <symbol id="mixtas-product-wishlist-btn" viewBox="0 0 21 19">
                            <path
                                d="M2.74 8.648l7.833 8.665 7.81-8.665c.01-.015.021-.033.035-.048a4.515 4.515 0 0 0 1.142-2.995 4.52 4.52 0 0 0-4.518-4.517 4.536 4.536 0 0 0-4.11 2.644c-.132.293-.61.293-.744 0A4.535 4.535 0 0 0 6.08 1.088 4.52 4.52 0 0 0 1.56 5.605c0 1.105.406 2.16 1.143 2.995a.472.472 0 0 1 .037.048zm7.834 9.68a.418.418 0 0 1-.304-.132L2.087 9.148c-.017-.025-.032-.042-.045-.058a5.34 5.34 0 0 1-1.3-3.485A5.34 5.34 0 0 1 6.08.27c1.822 0 3.508.933 4.481 2.439A5.345 5.345 0 0 1 15.042.27a5.34 5.34 0 0 1 5.337 5.335 5.33 5.33 0 0 1-1.304 3.485c-.012.016-.025.033-.04.058l-8.158 9.048a.416.416 0 0 1-.303.131z"
                                fill="currentColor" fill-rule="evenodd"></path>
                        </symbol>
                        <symbol id="mixtas-product-quickview-btn" viewBox="0 0 19 12">
                            <g fill="currentColor" fill-rule="evenodd">
                                <path
                                    d="M1.529 6.341a9.749 9.749 0 0 0 8.192 4.429c3.325 0 6.365-1.65 8.193-4.429C16.086 3.56 13.046 1.91 9.721 1.91c-3.325 0-6.365 1.65-8.192 4.431zm8.192 5.429C5.943 11.77 2.5 9.841.51 6.6a.492.492 0 0 1 0-.52C2.5 2.84 5.943.911 9.721.911c3.779 0 7.222 1.929 9.211 5.169a.492.492 0 0 1 0 .52c-1.989 3.241-5.432 5.17-9.211 5.17z">
                                </path>
                                <path
                                    d="M9.721 4.14a2.204 2.204 0 0 0-2.197 2.201c0 1.209.986 2.199 2.197 2.199 1.212 0 2.197-.99 2.197-2.199 0-1.21-.985-2.201-2.197-2.201zm0 5.4a3.205 3.205 0 0 1-3.197-3.199A3.205 3.205 0 0 1 9.721 3.14a3.205 3.205 0 0 1 3.197 3.201A3.205 3.205 0 0 1 9.721 9.54zM13.564 11.03a.499.499 0 0 1-.368-.169.493.493 0 0 1 .03-.701 5.2 5.2 0 0 0 1.676-3.819 5.194 5.194 0 0 0-1.68-3.821.503.503 0 0 1-.03-.709c.186-.2.503-.21.706-.03a6.206 6.206 0 0 1 2.004 4.56 6.17 6.17 0 0 1-2 4.549.498.498 0 0 1-.338.14M5.882 11.03a.487.487 0 0 1-.338-.13 6.204 6.204 0 0 1-2.003-4.559c0-1.73.729-3.391 2.001-4.551a.494.494 0 0 1 .707.03c.187.2.173.521-.031.7a5.199 5.199 0 0 0-1.677 3.821c0 1.449.612 2.839 1.679 3.819.204.19.218.501.031.711a.53.53 0 0 1-.369.159">
                                </path>
                            </g>
                        </symbol>
                        <symbol id="mixtas-product-bag-btn" viewBox="0 0 18 19">
                            <g fill="currentColor" fill-rule="evenodd">
                                <path
                                    d="M13.375 8.88A.373.373 0 0 1 13 8.506V3.255c0-1.477-1.426-2.25-2.834-2.25h-.75C7.903 1.005 7 1.845 7 3.255v5.25c0 .21-.168.375-.375.375a.373.373 0 0 1-.375-.374V3.255c0-1.822 1.242-3 3.166-3h.75c1.737 0 3.584 1.05 3.584 3v5.25c0 .21-.168.375-.375.375">
                                </path>
                                <path
                                    d="M11.5 18.256H1.166a.375.375 0 0 1-.356-.495L4.56 6.51a.378.378 0 0 1 .356-.255h9.75c.16 0 .303.104.354.255l1.672 4.889a.372.372 0 0 1-.233.473.373.373 0 0 1-.476-.233l-1.586-4.634H5.186l-3.5 10.5H11.5c.207 0 .375.164.375.374s-.168.376-.375.376">
                                </path>
                                <path
                                    d="M15.75 17.13c-.276 0-.5-.165-.5-.375v-3.75c0-.21.224-.374.5-.374s.5.165.5.375v3.749c0 .21-.224.376-.5.376">
                                </path>
                                <path
                                    d="M17.5 15.505h-3.75c-.207 0-.375-.22-.375-.5s.168-.5.375-.5h3.75c.207 0 .375.22.375.5s-.168.5-.375.5">
                                </path>
                            </g>
                        </symbol>
                        <symbol id="mixtas-zoom" viewBox="0 0 26 26">
                            <g fill="currentColor" fill-rule="evenodd">
                                <path d="M24 0h2v8.308h-2z"></path>
                                <path d="M24.083.76l1.372 1.405-9.858 8.153-1.372-1.405z"></path>
                                <path d="M17 0h9v2h-9zM0 0h13v2H0z"></path>
                                <path d="M0 0h2v24H0z"></path>
                                <path d="M0 23.077h26v2H0z"></path>
                                <path d="M24 12h2v12h-2z"></path>
                            </g>
                        </symbol>
                        <symbol id="mixtas-play-video" viewBox="0 0 22 28">
                            <path d="M0 0v28l22-14z" fill="currentColor" fill-rule="evenodd"></path>
                        </symbol>
                        <symbol id="mixtas-arrow-right" viewBox="0 0 40 36">
                            <path d="M37.098 18.756L20.864 34.9 21.9 36 40 18 21.9 0l-1.036 1.1 16.234 16.144H0v1.512z"
                                fill="currentColor" fill-rule="evenodd"></path>
                        </symbol>
                        <symbol id="mixtas-filter-icon" viewBox="0 0 20 17">
                            <g fill="currentColor" fill-rule="evenodd">
                                <path d="M0 0h20v1H0zM0 8h15v1H0zM0 16h10v1H0z"></path>
                            </g>
                        </symbol>
                        <symbol id="mixtas-button-arrow" viewBox="0 0 24 24">
                            <g class="nc-icon-wrapper" stroke-linecap="square" stroke-linejoin="miter"
                                stroke-width="2" fill="currentColor" stroke="currentColor">
                                <line data-cap="butt" data-color="color-2" fill="none" stroke-miterlimit="10"
                                    x1="2" y1="12" x2="22" y2="12"
                                    stroke-linecap="butt"></line>
                                <polyline fill="none" stroke="currentColor" stroke-miterlimit="10"
                                    points="15,5 22,12 15,19 "></polyline>
                            </g>
                        </symbol>
                        <symbol id="mixtas-video-play" viewBox="0 0 70 70" xmlns="http://www.w3.org/2000/svg">
                            <g fill="none" fill-rule="evenodd" transform="translate(1.913 1.26)">
                                <path fill="currentColor" fill-rule="nonzero"
                                    d="M45.13 34.348c0-.287-.19-.574-.382-.765L27.53 21.148c-.287-.191-.67-.287-1.052-.096-.287.191-.478.478-.478.861v24.87c0 .382.191.67.478.86.192.096.287.096.479.096.19 0 .382-.096.573-.191l17.218-12.435c.191-.191.382-.478.382-.765z">
                                </path>
                                <circle cx="33.087" cy="33.739" r="33" stroke="currentColor" stroke-width="4">
                                </circle>
                            </g>
                        </symbol>
                        <symbol id="mixtas-plus" fill="none" viewBox="0 0 16 16"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"
                                fill="currentColor"></path>
                        </symbol>
                        <symbol fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 13 15"
                            id="mixtas-calendar">
                            <path
                                d="M3.4375 0.75C3.65625 0.75 3.875 0.96875 3.875 1.1875V2.5H9.125V1.1875C9.125 0.96875 9.31641 0.75 9.5625 0.75C9.78125 0.75 10 0.96875 10 1.1875V2.5H10.875C11.832 2.5 12.625 3.29297 12.625 4.25V13C12.625 13.9844 11.832 14.75 10.875 14.75H2.125C1.14062 14.75 0.375 13.9844 0.375 13V4.25C0.375 3.29297 1.14062 2.5 2.125 2.5H3V1.1875C3 0.96875 3.19141 0.75 3.4375 0.75ZM11.75 6H8.90625V7.96875H11.75V6ZM11.75 8.84375H8.90625V11.0312H11.75V8.84375ZM11.75 11.9062H8.90625V13.875H10.875C11.3398 13.875 11.75 13.4922 11.75 13V11.9062ZM8.03125 11.0312V8.84375H4.96875V11.0312H8.03125ZM4.96875 13.875H8.03125V11.9062H4.96875V13.875ZM4.09375 11.0312V8.84375H1.25V11.0312H4.09375ZM1.25 11.9062V13C1.25 13.4922 1.63281 13.875 2.125 13.875H4.09375V11.9062H1.25ZM1.25 7.96875H4.09375V6H1.25V7.96875ZM4.96875 7.96875H8.03125V6H4.96875V7.96875ZM10.875 3.375H2.125C1.63281 3.375 1.25 3.78516 1.25 4.25V5.125H11.75V4.25C11.75 3.78516 11.3398 3.375 10.875 3.375Z"
                                fill="currentColor"></path>
                        </symbol>
                        <symbol fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            id="mini-cart-add">
                            <path d="M12 7V17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <path d="M17 12H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </symbol>
                        <symbol fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            id="mini-cart-delete">
                            <path d="M17 12H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </symbol>
                    </defs>
                </svg>
            </div>
            <div class="nova-overlay-global"></div>
        </div><!-- .kitify-site-wrapper -->
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
                }, {
                    rootMargin: '200px 0px 200px 0px'
                });
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
        <script type="text/javascript">
            (function() {
                var c = document.body.className;
                c = c.replace(/woocommerce-no-js/, 'woocommerce-js');
                document.body.className = c;
            })();
        </script>
        <link rel="stylesheet" id="wc-blocks-style-css"
            href="https://mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/client/blocks/wc-blocks.css?ver=wc-9.7.1"
            type="text/css" media="all">
        <link rel="stylesheet" id="kitify-breadcrumbs-css"
            href="https://mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/breadcrumbs.css?ver=1760853825"
            type="text/css" media="all">
        <link rel="stylesheet" id="kitify-google-maps-css"
            href="https://mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/google-map.css?ver=1760853825"
            type="text/css" media="all">
        <link rel="stylesheet" id="kitify-nav-menu-css"
            href="https://mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/nav-menu.css?ver=1760853825"
            type="text/css" media="all">
        <link rel="stylesheet" id="kitify-search-css"
            href="https://mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/search.css?ver=1760853825"
            type="text/css" media="all">
        <link rel="stylesheet" id="kitify-canvas-css"
            href="https://mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/kitify-canvas.css?ver=1760853825"
            type="text/css" media="all">
        <link rel="stylesheet" id="widget-social-icons-css"
            href="https://mixtas.b-cdn.net/wp-content/plugins/elementor/assets/css/widget-social-icons.min.css?ver=3.28.3"
            type="text/css" media="all">
        <link rel="stylesheet" id="e-apple-webkit-css"
            href="https://mixtas.b-cdn.net/wp-content/uploads/elementor/css/custom-apple-webkit.min.css?ver=1743737085"
            type="text/css" media="all">
        <link rel="stylesheet" id="widget-icon-list-css"
            href="https://mixtas.b-cdn.net/wp-content/uploads/elementor/css/custom-widget-icon-list.min.css?ver=1743737085"
            type="text/css" media="all">
        <link rel="stylesheet" id="kitify-subscribe-form-css"
            href="https://mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/subscribe-form.css?ver=1760853825"
            type="text/css" media="all">
        <link rel="stylesheet" id="widget-image-css"
            href="https://mixtas.b-cdn.net/wp-content/plugins/elementor/assets/css/widget-image.min.css?ver=3.28.3"
            type="text/css" media="all">
        <link rel="stylesheet" id="rs-plugin-settings-css"
            href="//mixtas.novaworks.net/wp-content/plugins/revslider/sr6/assets/css/rs6.css?ver=6.7.31" type="text/css"
            media="all">
        <style id="rs-plugin-settings-inline-css" type="text/css">
            #rs-demo-id {}
        </style>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/yith-woocommerce-wishlist/assets/js/jquery.selectBox.min.js?ver=1.2.0"
            id="jquery-selectBox-js"></script>
        <script type="text/javascript"
            src="//mixtas.novaworks.net/wp-content/plugins/woocommerce/assets/js/prettyPhoto/jquery.prettyPhoto.min.js?ver=3.1.6"
            id="prettyPhoto-js" data-wp-strategy="defer"></script>
        <script type="text/javascript" id="jquery-yith-wcwl-js-extra">
            /* <![CDATA[ */
            var yith_wcwl_l10n = {
                "ajax_url": "\/wp-admin\/admin-ajax.php",
                "redirect_to_cart": "no",
                "yith_wcwl_button_position": "after_add_to_cart",
                "multi_wishlist": "",
                "hide_add_button": "1",
                "enable_ajax_loading": "",
                "ajax_loader_url": "https:\/\/mixtas.b-cdn.net\/wp-content\/plugins\/yith-woocommerce-wishlist\/assets\/images\/ajax-loader-alt.svg",
                "remove_from_wishlist_after_add_to_cart": "1",
                "is_wishlist_responsive": "",
                "time_to_close_prettyphoto": "3000",
                "fragments_index_glue": ".",
                "reload_on_found_variation": "1",
                "mobile_media_query": "768",
                "labels": {
                    "cookie_disabled": "We are sorry, but this feature is available only if cookies on your browser are enabled.",
                    "added_to_cart_message": "<div class=\"woocommerce-notices-wrapper\"><div class=\"woocommerce-message\" role=\"alert\">Product added to cart successfully<\/div><\/div>"
                },
                "actions": {
                    "add_to_wishlist_action": "add_to_wishlist",
                    "remove_from_wishlist_action": "remove_from_wishlist",
                    "reload_wishlist_and_adding_elem_action": "reload_wishlist_and_adding_elem",
                    "load_mobile_action": "load_mobile",
                    "delete_item_action": "delete_item",
                    "save_title_action": "save_title",
                    "save_privacy_action": "save_privacy",
                    "load_fragments": "load_fragments"
                },
                "nonce": {
                    "add_to_wishlist_nonce": "2650057b0a",
                    "remove_from_wishlist_nonce": "b6e55f8237",
                    "reload_wishlist_and_adding_elem_nonce": "b44f99ce60",
                    "load_mobile_nonce": "c0df1f3560",
                    "delete_item_nonce": "cf551604c5",
                    "save_title_nonce": "6ba96c554f",
                    "save_privacy_nonce": "7cbcd084eb",
                    "load_fragments_nonce": "1c46015fdd"
                },
                "redirect_after_ask_estimate": "",
                "ask_estimate_redirect_url": "https:\/\/mixtas.novaworks.net"
            };
            /* ]]> */
        </script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/yith-woocommerce-wishlist/assets/js/jquery.yith-wcwl.min.js?ver=4.4.0"
            id="jquery-yith-wcwl-js"></script>
        <script type="text/javascript" src="https://mixtas.b-cdn.net/wp-includes/js/dist/hooks.min.js?ver=4d63a3d491d11ffd8ac6"
            id="wp-hooks-js"></script>
        <script type="text/javascript" src="https://mixtas.b-cdn.net/wp-includes/js/dist/i18n.min.js?ver=5e580eb46a90c2b997e6"
            id="wp-i18n-js"></script>
        <script type="text/javascript" id="wp-i18n-js-after">
            /* <![CDATA[ */
            wp.i18n.setLocaleData({
                'text direction\u0004ltr': ['ltr']
            });
            /* ]]> */
        </script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/contact-form-7/includes/swv/js/index.js?ver=6.0.5" id="swv-js">
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
            src="https://mixtas.b-cdn.net/wp-content/plugins/contact-form-7/includes/js/index.js?ver=6.0.5"
            id="contact-form-7-js"></script>
        <script type="text/javascript"
            src="//mixtas.novaworks.net/wp-content/plugins/revslider/sr6/assets/js/rbtools.min.js?ver=6.7.29" defer="" async=""
            id="tp-tools-js"></script>
        <script type="text/javascript"
            src="//mixtas.novaworks.net/wp-content/plugins/revslider/sr6/assets/js/rs6.min.js?ver=6.7.31" defer="" async=""
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
        <script type="text/javascript" async="" src="https://client.crisp.chat/l.js?ver=20251019" id="crisp-js"></script>
        <script type="text/javascript" id="wp-api-request-js-extra">
            /* <![CDATA[ */
            var wpApiSettings = {
                "root": "https:\/\/mixtas.novaworks.net\/wp-json\/",
                "nonce": "9cd2e48e74",
                "versionString": "wp\/v2\/"
            };
            /* ]]> */
        </script>
        <script type="text/javascript" src="https://mixtas.b-cdn.net/wp-includes/js/api-request.min.js?ver=6.8.3"
            id="wp-api-request-js"></script>
        <script type="text/javascript" src="https://mixtas.b-cdn.net/wp-includes/js/dist/vendor/wp-polyfill.min.js?ver=3.15.0"
            id="wp-polyfill-js"></script>
        <script type="text/javascript" src="https://mixtas.b-cdn.net/wp-includes/js/dist/url.min.js?ver=c2964167dfe2477c14ea"
            id="wp-url-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-includes/js/dist/api-fetch.min.js?ver=3623a576c78df404ff20" id="wp-api-fetch-js">
        </script>
        <script type="text/javascript" id="wp-api-fetch-js-after">
            /* <![CDATA[ */
            wp.apiFetch.use(wp.apiFetch.createRootURLMiddleware("https://mixtas.novaworks.net/wp-json/"));
            wp.apiFetch.nonceMiddleware = wp.apiFetch.createNonceMiddleware("9cd2e48e74");
            wp.apiFetch.use(wp.apiFetch.nonceMiddleware);
            wp.apiFetch.use(wp.apiFetch.mediaUploadMiddleware);
            wp.apiFetch.nonceEndpoint = "https://mixtas.novaworks.net/wp-admin/admin-ajax.php?action=rest-nonce";
            /* ]]> */
        </script>
        <script type="text/javascript" id="woo-variation-swatches-js-extra">
            /* <![CDATA[ */
            var woo_variation_swatches_options = {
                "show_variation_label": "1",
                "clear_on_reselect": "",
                "variation_label_separator": ":",
                "is_mobile": "",
                "show_variation_stock": "",
                "stock_label_threshold": "5",
                "cart_redirect_after_add": "no",
                "enable_ajax_add_to_cart": "yes",
                "cart_url": "https:\/\/mixtas.novaworks.net\/cart\/",
                "is_cart": ""
            };
            /* ]]> */
        </script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/woo-variation-swatches/assets/js/frontend.min.js?ver=1743737055"
            id="woo-variation-swatches-js"></script>
        <script type="text/javascript" src="https://mixtas.b-cdn.net/wp-includes/js/imagesloaded.min.js?ver=5.0.0"
            id="imagesloaded-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/foundation/dist/js/foundation.min.js?ver=1760853825"
            id="foundation-js"></script><iframe height="0" width="0"
            style="display: none; visibility: hidden;"></iframe>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/cookies/js.cookie.js?ver=1760853825"
            id="cookies-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/jquery-visible/jquery.visible.js?ver=1760853825"
            id="jquery-visible-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/scrollTo/jquery.scrollTo.min.js?ver=1760853825"
            id="scrollTo-js"></script>
        <script type="text/javascript" src="https://mixtas.b-cdn.net/wp-includes/js/hoverIntent.min.js?ver=1.10.2"
            id="hoverIntent-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/jquery.perfect-scrollbar.min.js?ver=0.7.1"
            id="perfect-scrollbar-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/mojs/mo.min.js?ver=1760853825" id="mojs-js">
        </script>
        <div></div>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/anime/anime.min.js?ver=1760853825"
            id="anime-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/elementor/assets/lib/swiper/v8/swiper.min.js?ver=8.4.5"
            id="swiper-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/headroom.js/headroom.min.js?ver=1760853825"
            id="headroom-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/slick/slick.min.js?ver=1760853825"
            id="slick-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/sticky-kit/jquery.sticky-kit.min.js?ver=1760853825"
            id="sticky-kit-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/jquery-loading-overlay/loadingoverlay.min.js?ver=1760853825"
            id="jquery-loading-overlay-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/readmore/readmore.js?ver=1.1.1"
            id="readmore-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/isotope/isotope.pkgd.min.js?ver=1.1.1"
            id="isotope-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/video.popup.js?ver=1.1.1" id="video-popup-js">
        </script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/animatedModal.js/animatedModal.js?ver=1.1.1"
            id="animatedModal-js"></script>
        <script type="text/javascript" id="nova-app-js-extra">
            /* <![CDATA[ */
            var nova_js_var = {
                "js_path": "https:\/\/mixtas.b-cdn.net\/wp-content\/themes\/mixtas\/assets\/js\/vendor\/",
                "js_min": "1",
                "site_preloader": "",
                "topbar_progress": "",
                "select_placeholder": "Choose an option",
                "blog_pagination_type": "default",
                "load_more_btn": "Load more",
                "read_more_btn": "Read more",
                "read_less_btn": "Read less",
                "enable_header_sticky": "0",
                "shop_pagination_type": "infinite_scroll",
                "accent_color": "#000000",
                "shop_display": "grid",
                "popup_show_after": "2000",
                "product_image_zoom": "1",
                "is_customize_preview": ""
            };
            /* ]]> */
        </script>
        <script type="text/javascript" src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/js/app.js?ver=1760853825"
            id="nova-app-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/sourcebuster/sourcebuster.min.js?ver=9.7.1"
            id="sourcebuster-js-js"></script>
        <script type="text/javascript" id="wc-order-attribution-js-extra">
            /* <![CDATA[ */
            var wc_order_attribution = {
                "params": {
                    "lifetime": 1.0e-5,
                    "session": 30,
                    "base64": false,
                    "ajaxurl": "https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php",
                    "prefix": "wc_order_attribution_",
                    "allowTracking": true
                },
                "fields": {
                    "source_type": "current.typ",
                    "referrer": "current_add.rf",
                    "utm_campaign": "current.cmp",
                    "utm_source": "current.src",
                    "utm_medium": "current.mdm",
                    "utm_content": "current.cnt",
                    "utm_id": "current.id",
                    "utm_term": "current.trm",
                    "utm_source_platform": "current.plt",
                    "utm_creative_format": "current.fmt",
                    "utm_marketing_tactic": "current.tct",
                    "session_entry": "current_add.ep",
                    "session_start_time": "current_add.fd",
                    "session_pages": "session.pgs",
                    "session_count": "udata.vst",
                    "user_agent": "udata.uag"
                }
            };
            /* ]]> */
        </script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/frontend/order-attribution.min.js?ver=9.7.1"
            id="wc-order-attribution-js"></script>
        <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDH-rtpwvyMwHPW0joNQHm5te6FE7DOk-U&amp;ver=1760853825"
            id="kitify-google-maps-api-js"></script>
        <script type="text/javascript" id="wc-cart-fragments-js-extra">
            /* <![CDATA[ */
            var wc_cart_fragments_params = {
                "ajax_url": "\/wp-admin\/admin-ajax.php",
                "wc_ajax_url": "\/?wc-ajax=%%endpoint%%",
                "cart_hash_key": "wc_cart_hash_5d3227775be22d377568ebad71c4a81b",
                "fragment_name": "wc_fragments_5d3227775be22d377568ebad71c4a81b",
                "request_timeout": "5000"
            };
            /* ]]> */
        </script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.min.js?ver=9.7.1"
            id="wc-cart-fragments-js" defer="defer" data-wp-strategy="defer"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/elementor/assets/js/webpack.runtime.min.js?ver=3.28.3"
            id="elementor-webpack-runtime-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/elementor/assets/js/frontend-modules.min.js?ver=3.28.3"
            id="elementor-frontend-modules-js"></script>
        <script type="text/javascript" src="https://mixtas.b-cdn.net/wp-includes/js/jquery/ui/core.min.js?ver=1.13.3"
            id="jquery-ui-core-js"></script>
        <script type="text/javascript" id="elementor-frontend-js-extra">
            /* <![CDATA[ */
            var kitifySubscribeConfig = {
                "action": "kitify_ajax",
                "nonce": "48e1c80042",
                "type": "POST",
                "data_type": "json",
                "is_public": "true",
                "ajax_url": "https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php",
                "sys_messages": {
                    "invalid_mail": "Please, provide valid mail",
                    "mailchimp": "Please, set up MailChimp API key and List ID",
                    "internal": "Internal error. Please, try again later",
                    "server_error": "Server error. Please, try again later",
                    "invalid_nonce": "Invalid nonce. Please, try again later",
                    "subscribe_success": "Success"
                }
            };
            /* ]]> */
        </script>
        <script type="text/javascript" id="elementor-frontend-js-before">
            /* <![CDATA[ */
            var elementorFrontendConfig = {
                "environmentMode": {
                    "edit": false,
                    "wpPreview": false,
                    "isScriptDebug": false
                },
                "i18n": {
                    "shareOnFacebook": "Share on Facebook",
                    "shareOnTwitter": "Share on Twitter",
                    "pinIt": "Pin it",
                    "download": "Download",
                    "downloadImage": "Download image",
                    "fullscreen": "Fullscreen",
                    "zoom": "Zoom",
                    "share": "Share",
                    "playVideo": "Play Video",
                    "previous": "Previous",
                    "next": "Next",
                    "close": "Close",
                    "a11yCarouselPrevSlideMessage": "Previous slide",
                    "a11yCarouselNextSlideMessage": "Next slide",
                    "a11yCarouselFirstSlideMessage": "This is the first slide",
                    "a11yCarouselLastSlideMessage": "This is the last slide",
                    "a11yCarouselPaginationBulletMessage": "Go to slide"
                },
                "is_rtl": false,
                "breakpoints": {
                    "xs": 0,
                    "sm": 480,
                    "md": 768,
                    "lg": 1025,
                    "xl": 1440,
                    "xxl": 1600
                },
                "responsive": {
                    "breakpoints": {
                        "mobile": {
                            "label": "Mobile Portrait",
                            "value": 767,
                            "default_value": 767,
                            "direction": "max",
                            "is_enabled": true
                        },
                        "mobile_extra": {
                            "label": "Mobile Landscape",
                            "value": 991,
                            "default_value": 880,
                            "direction": "max",
                            "is_enabled": true
                        },
                        "tablet": {
                            "label": "Tablet Portrait",
                            "value": 1024,
                            "default_value": 1024,
                            "direction": "max",
                            "is_enabled": true
                        },
                        "tablet_extra": {
                            "label": "Tablet Landscape",
                            "value": 1279,
                            "default_value": 1200,
                            "direction": "max",
                            "is_enabled": true
                        },
                        "laptop": {
                            "label": "Laptop",
                            "value": 1599,
                            "default_value": 1366,
                            "direction": "max",
                            "is_enabled": true
                        },
                        "widescreen": {
                            "label": "Widescreen",
                            "value": 2400,
                            "default_value": 2400,
                            "direction": "min",
                            "is_enabled": false
                        }
                    },
                    "hasCustomBreakpoints": true
                },
                "version": "3.28.3",
                "is_static": false,
                "experimentalFeatures": {
                    "e_font_icon_svg": true,
                    "additional_custom_breakpoints": true,
                    "container": true,
                    "e_local_google_fonts": true,
                    "theme_builder_v2": true,
                    "nested-elements": true,
                    "editor_v2": true,
                    "home_screen": true
                },
                "urls": {
                    "assets": "https:\/\/mixtas.b-cdn.net\/wp-content\/plugins\/elementor\/assets\/",
                    "ajaxurl": "https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php",
                    "uploadUrl": "https:\/\/mixtas.b-cdn.net\/wp-content\/uploads"
                },
                "nonces": {
                    "floatingButtonsClickTracking": "3309d5891e"
                },
                "swiperClass": "swiper",
                "settings": {
                    "page": [],
                    "editorPreferences": []
                },
                "kit": {
                    "active_breakpoints": ["viewport_mobile", "viewport_mobile_extra", "viewport_tablet",
                        "viewport_tablet_extra", "viewport_laptop"
                    ],
                    "viewport_mobile": 767,
                    "viewport_mobile_extra": 991,
                    "viewport_tablet": 1024,
                    "viewport_tablet_extra": 1279,
                    "viewport_laptop": 1599,
                    "global_image_lightbox": "yes",
                    "lightbox_enable_counter": "yes",
                    "lightbox_enable_fullscreen": "yes",
                    "lightbox_enable_zoom": "yes",
                    "lightbox_enable_share": "yes",
                    "lightbox_title_src": "title",
                    "lightbox_description_src": "description"
                },
                "post": {
                    "id": 70,
                    "title": "Contact%20Us%20%E2%80%93%20Mixtas",
                    "excerpt": "",
                    "featuredImage": false
                }
            };
            /* ]]> */
        </script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/elementor/assets/js/frontend.min.js?ver=3.28.3"
            id="elementor-frontend-js"></script><span id="elementor-device-mode" class="elementor-screen-only"></span>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/lib/jquery.sticky.min.js?ver=1760853825"
            id="kitify-sticky-js-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/motion-fx.js?ver=1760853825"
            id="kitify-motion-fx-js"></script>
        <script type="text/javascript" id="kitify-base-js-extra">
            /* <![CDATA[ */
            var KitifySettings = {
                "templateApiUrl": "https:\/\/mixtas.novaworks.net\/wp-json\/kitify-api\/v1\/elementor-template",
                "widgetApiUrl": "https:\/\/mixtas.novaworks.net\/wp-json\/kitify-api\/v1\/elementor-widget",
                "homeURL": "https:\/\/mixtas.novaworks.net\/",
                "ajaxurl": "https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php",
                "isMobile": "false",
                "devMode": "false",
                "cache_ttl": "300",
                "local_ttl": "86400",
                "themeName": "mixtas",
                "i18n": [],
                "ajaxNonce": "48e1c80042",
                "useFrontAjax": "true",
                "isElementorAdmin": ""
            };
            /* ]]> */
        </script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/kitify-base.js?ver=1760853825"
            id="kitify-base-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/google-map.js?ver=1760853825"
            id="kitify-w__gmap-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/nav-menu.js?ver=1760853825"
            id="kitify-w__nav-menu-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/nova-menu.js?ver=1760853825"
            id="kitify-w__nova-menu-js"></script>
        <script type="text/javascript"
            src="https://mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/subscribe-form.js?ver=1760853825"
            id="kitify-w__subscribe-form-js"></script>




        <div class="widget_shopping_cart_live_region screen-reader-text" role="status"></div>
        <div class="crisp-client" aria-live="polite" translate="no" tabindex="-1" lang="en" dir="ltr"
            style="--crisp-color-theme-10: 240, 242, 245; --crisp-color-theme-20: 239, 245, 254; --crisp-color-theme-100: 226, 238, 255; --crisp-color-theme-200: 102, 120, 138; --crisp-color-theme-500: 25, 114, 245; --crisp-color-theme-600: 5, 94, 225; --crisp-color-theme-700: 0, 87, 215; --crisp-color-theme-800: 0, 81, 200; --crisp-color-theme-900: 0, 74, 181; --crisp-color-theme-reverse: 255, 255, 255;">
            <div class="cc-1lkve"></div>
            <div class="cc-yv368" id="crisp-chatbox" data-hidden="false" data-force-show="false"
                data-color-mode="light" data-availability="away" data-lock-maximized="false"
                data-website-logo="false" data-last-operator-face="false" data-ongoing-operator-face="false"
                data-availability-tooltip="false" data-hide-vacation="false" data-blocked="false"
                data-mobile-view="false" data-full-view="true" data-small-view="true" data-large-view="false"
                data-has-local-messages="false" data-was-availability-online="false" data-is-activity-ongoing="false"
                data-hide-on-away="false" data-hide-on-mobile="false" data-position-reverse="false">
                <div class="cc-1kr6o cc-cxjxh cc-jx6a3">
                    <div class="cc-18ov6" data-maximized="false" data-is-failure="false" role="button"
                        tabindex="0" aria-label="Open chat" data-pane-animate-entrance="false"
                        data-pop="minimized:open"><span class="cc-1442g"><!--v-if--></span><span
                            class="cc-1qbp0 cc-1o31k"><span class="cc-otlyh" data-id="chat_closed"
                                data-is-ongoing="false"><span class="cc-11f3x cc-16kzz"
                                    data-partial-pending="false"><!--v-if--></span></span></span></div>
                </div>
            </div>
            <div class="cc-yv368 cc-vx6i0"></div>
            <div class="cc-yv368 cc-1tx1r"></div>
            <div class="cc-yv368 cc-jcxto" data-color-mode="light"></div>
        </div>
    </body>

    </html>
