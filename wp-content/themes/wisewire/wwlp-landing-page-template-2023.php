<?php
/**
 * Template Name: Home Landing 2023
 */
?>
<?php
 $protocols = array('http://', 'https://');
 $cleanurl = str_replace($protocols, '', get_bloginfo('wpurl')); 
?>

<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#" class="loading-site no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <script>
    (function(html) {
        html.className = html.className.replace(/\bno-js\b/, 'js')
    })(document.documentElement);
    </script>
    <title>Landing Page - Wisewire</title>
    <style type="text/css" id="cst_font_data">
    @font-face {
        font-family: 'Zeyada';
        font-style: normal;
        font-weight: 400;
        font-display: fallback;
        src: url('<?php echo get_site_url(); ?>/wp-content/bcf-fonts/Zeyada/zeyada-400-normal0.woff2') format('woff2');
    }

    @font-face {
        font-family: 'Titillium Web';
        font-style: normal;
        font-weight: 400;
        font-display: fallback;
        src: url('<?php echo get_site_url(); ?>/wp-content/bcf-fonts/Titillium%20Web/titillium-web-400-normal0.woff2') format('woff2'), url('<?php echo get_site_url(); ?>/wp-content/bcf-fonts/Titillium%20Web/titillium-web-400-normal1.woff2') format('woff2');
    }

    @font-face {
        font-family: 'Titillium Web';
        font-style: normal;
        font-weight: 700;
        font-display: fallback;
        src: url('<?php echo get_site_url(); ?>/wp-content/bcf-fonts/Titillium%20Web/titillium-web-700-normal0.woff2') format('woff2'), url('<?php echo get_site_url(); ?>/wp-content/bcf-fonts/Titillium%20Web/titillium-web-700-normal1.woff2') format('woff2');
    }

    @font-face {
        font-family: 'Titillium Web';
        font-style: italic;
        font-display: fallback;
        src: url('<?php echo get_site_url(); ?>/wp-content/bcf-fonts/Titillium%20Web/titillium-web-italic-italic0.woff2') format('woff2'), url('<?php echo get_site_url(); ?>/wp-content/bcf-fonts/Titillium%20Web/titillium-web-italic-italic1.woff2') format('woff2');
    }
    </style>
    <meta name='robots' content='noindex, nofollow'/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- This site is optimized with the Yoast SEO plugin v3.0.6 - https://yoast.com/wordpress/plugins/seo/ -->
    <meta name="robots" content="noindex,follow"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="Landing Page - Wisewire"/>
    <meta property="og:site_name" content="Wisewire"/>
    <meta property="og:image" content="<?php echo get_site_url(); ?>/wp-content/uploads/ask-icon.png"/>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:title" content="Landing Page - Wisewire"/>
    <meta name="twitter:image" content="<?php echo get_site_url(); ?>/wp-content/uploads/ask-icon.png"/>
    <link rel='prefetch' href='<?php echo get_stylesheet_directory_uri(); ?>/wwlp-assets/js/flatsome.js?ver=039f9485eef603e7c53a'/>
    <link rel='prefetch' href='<?php echo get_stylesheet_directory_uri(); ?>/wwlp-assets/js/chunk.slider.js?ver=3.18.0'/>
    <link rel='prefetch' href='<?php echo get_stylesheet_directory_uri(); ?>/wwlp-assets/js/chunk.popups.js?ver=3.18.0'/>
    <link rel='prefetch' href='<?php echo get_stylesheet_directory_uri(); ?>/wwlp-assets/js/chunk.tooltips.js?ver=3.18.0'/>
<!--    <link rel='prefetch' href='https://wise.krimmelworks.com/wp-content/themes/flatsome/assets/js/woocommerce.js?ver=c9fe40206165dd93147b'/> -->
    <link rel="alternate" type="application/rss+xml" title="Wisewire &raquo; Feed" href="<?php echo get_site_url(); ?>/feed/"/>
    <link rel="alternate" type="application/rss+xml" title="Wisewire &raquo; Comments Feed" href="<?php echo get_site_url(); ?>/comments/feed/"/>
    <script type="text/javascript">
    /* <![CDATA[ */
    window._wpemojiSettings = {
        "baseUrl": "https:\/\/s.w.org\/images\/core\/emoji\/14.0.0\/72x72\/",
        "ext": ".png",
        "svgUrl": "https:\/\/s.w.org\/images\/core\/emoji\/14.0.0\/svg\/",
        "svgExt": ".svg",
        "source": {
            "concatemoji": "https:\/\/<?php echo $cleanurl; ?>\/wp-includes\/js\/wp-emoji-release.min.js?ver=6.4.1"
        }
    };
    /*! This file is auto-generated */
    !function(i, n) {
        var o,
            s,
            e;
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
            e.clearRect(0, 0, e.canvas.width, e.canvas.height),
            e.fillText(t, 0, 0);
            var t = new Uint32Array(e.getImageData(0, 0, e.canvas.width, e.canvas.height).data),
                r = (e.clearRect(0, 0, e.canvas.width, e.canvas.height), e.fillText(n, 0, 0), new Uint32Array(e.getImageData(0, 0, e.canvas.width, e.canvas.height).data));
            return t.every(function(e, t) {
                return e === r[t]
            })
        }
        function u(e, t, n) {
            switch (t) {
            case "flag":
                return n(e, "\ud83c\udff3\ufe0f\u200d\u26a7\ufe0f", "\ud83c\udff3\ufe0f\u200b\u26a7\ufe0f") ? !1 : !n(e, "\ud83c\uddfa\ud83c\uddf3", "\ud83c\uddfa\u200b\ud83c\uddf3") && !n(e, "\ud83c\udff4\udb40\udc67\udb40\udc62\udb40\udc65\udb40\udc6e\udb40\udc67\udb40\udc7f", "\ud83c\udff4\u200b\udb40\udc67\u200b\udb40\udc62\u200b\udb40\udc65\u200b\udb40\udc6e\u200b\udb40\udc67\u200b\udb40\udc7f");
            case "emoji":
                return !n(e, "\ud83e\udef1\ud83c\udffb\u200d\ud83e\udef2\ud83c\udfff", "\ud83e\udef1\ud83c\udffb\u200b\ud83e\udef2\ud83c\udfff")
            }
            return !1
        }
        function f(e, t, n) {
            var r = "undefined" != typeof WorkerGlobalScope && self instanceof WorkerGlobalScope ? new OffscreenCanvas(300, 150) : i.createElement("canvas"),
                a = r.getContext("2d", {
                    willReadFrequently: !0
                }),
                o = (a.textBaseline = "top", a.font = "600 32px Arial", {});
            return e.forEach(function(e) {
                o[e] = t(a, e, n)
            }), o
        }
        function t(e) {
            var t = i.createElement("script");
            t.src = e,
            t.defer = !0,
            i.head.appendChild(t)
        }
        "undefined" != typeof Promise && (o = "wpEmojiSettingsSupports", s = ["flag", "emoji"], n.supports = {
            everything: !0,
            everythingExceptFlag: !0
        }, e = new Promise(function(e) {
            i.addEventListener("DOMContentLoaded", e, {
                once: !0
            })
        }), new Promise(function(t) {
            var n = function() {
                try {
                    var e = JSON.parse(sessionStorage.getItem(o));
                    if ("object" == typeof e && "number" == typeof e.timestamp && (new Date).valueOf() < e.timestamp + 604800 && "object" == typeof e.supportTests)
                        return e.supportTests
                } catch (e) {}
                return null
            }();
            if (!n) {
                if ("undefined" != typeof Worker && "undefined" != typeof OffscreenCanvas && "undefined" != typeof URL && URL.createObjectURL && "undefined" != typeof Blob)
                    try {
                        var e = "postMessage(" + f.toString() + "(" + [JSON.stringify(s), u.toString(), p.toString()].join(",") + "));",
                            r = new Blob([e], {
                                type: "text/javascript"
                            }),
                            a = new Worker(URL.createObjectURL(r), {
                                name: "wpTestEmojiSupports"
                            });
                        return void (a.onmessage = function(e) {
                            c(n = e.data),
                            a.terminate(),
                            t(n)
                        })
                    } catch (e) {}
                c(n = f(s, u, p))
            }
            t(n)
        }).then(function(e) {
            for (var t in e)
                n.supports[t] = e[t],
                n.supports.everything = n.supports.everything && n.supports[t],
                "flag" !== t && (n.supports.everythingExceptFlag = n.supports.everythingExceptFlag && n.supports[t]);
            n.supports.everythingExceptFlag = n.supports.everythingExceptFlag && !n.supports.flag,
            n.DOMReady = !1,
            n.readyCallback = function() {
                n.DOMReady = !0
            }
        }).then(function() {
            return e
        }).then(function() {
            var e;
            n.supports.everything || (n.readyCallback(), (e = n.source || {}).concatemoji ? t(e.concatemoji) : e.wpemoji && e.twemoji && (t(e.twemoji), t(e.wpemoji)))
        }))
    }((window, document), window._wpemojiSettings);
    /* ]]> */
    </script>
    <style id='wp-emoji-styles-inline-css' type='text/css'>
    img.wp-smiley, img.emoji {
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
    <style id='wp-block-library-inline-css' type='text/css'>
    :root {
        --wp-admin-theme-color: #007cba;
        --wp-admin-theme-color--rgb: 0, 124, 186;
        --wp-admin-theme-color-darker-10: #006ba1;
        --wp-admin-theme-color-darker-10--rgb: 0, 107, 161;
        --wp-admin-theme-color-darker-20: #005a87;
        --wp-admin-theme-color-darker-20--rgb: 0, 90, 135;
        --wp-admin-border-width-focus: 2px;
        --wp-block-synced-color: #7a00df;
        --wp-block-synced-color--rgb:122, 0, 223
    }

    @media (min-resolution: 192dpi) {
        :root {
            --wp-admin-border-width-focus:1.5px
        }
    }

    .wp-element-button {
        cursor:pointer
    }

    :root {
        --wp--preset--font-size--normal: 16px;
        --wp--preset--font-size--huge:42px
    }

    :root .has-very-light-gray-background-color {
        background-color:#eee
    }

    :root .has-very-dark-gray-background-color {
        background-color:#313131
    }

    :root .has-very-light-gray-color {
        color:#eee
    }

    :root .has-very-dark-gray-color {
        color:#313131
    }

    :root .has-vivid-green-cyan-to-vivid-cyan-blue-gradient-background {
        background:linear-gradient(135deg, #00d084, #0693e3)
    }

    :root .has-purple-crush-gradient-background {
        background:linear-gradient(135deg, #34e2e4, #4721fb 50%, #ab1dfe)
    }

    :root .has-hazy-dawn-gradient-background {
        background:linear-gradient(135deg, #faaca8, #dad0ec)
    }

    :root .has-subdued-olive-gradient-background {
        background:linear-gradient(135deg, #fafae1, #67a671)
    }

    :root .has-atomic-cream-gradient-background {
        background:linear-gradient(135deg, #fdd79a, #004a59)
    }

    :root .has-nightshade-gradient-background {
        background:linear-gradient(135deg, #330968, #31cdcf)
    }

    :root .has-midnight-gradient-background {
        background:linear-gradient(135deg, #020381, #2874fc)
    }

    .has-regular-font-size {
        font-size:1em
    }

    .has-larger-font-size {
        font-size:2.625em
    }

    .has-normal-font-size {
        font-size:var(--wp--preset--font-size--normal)
    }

    .has-huge-font-size {
        font-size:var(--wp--preset--font-size--huge)
    }

    .has-text-align-center {
        text-align:center
    }

    .has-text-align-left {
        text-align:left
    }

    .has-text-align-right {
        text-align:right
    }

    #end-resizable-editor-section {
        display:none
    }

    .aligncenter {
        clear:both
    }

    .items-justified-left {
        justify-content:flex-start
    }

    .items-justified-center {
        justify-content:center
    }

    .items-justified-right {
        justify-content:flex-end
    }

    .items-justified-space-between {
        justify-content:space-between
    }

    .screen-reader-text {
        clip: rect(1px, 1px, 1px, 1px);
        word-wrap: normal !important;
        border: 0;
        -webkit-clip-path: inset(50%);
        clip-path: inset(50%);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width:1px
    }

    .screen-reader-text:focus {
        clip: auto !important;
        background-color: #ddd;
        -webkit-clip-path: none;
        clip-path: none;
        color: #444;
        display: block;
        font-size: 1em;
        height: auto;
        left: 5px;
        line-height: normal;
        padding: 15px 23px 14px;
        text-decoration: none;
        top: 5px;
        width: auto;
        z-index:100000
    }

    html :where(.has-border-color) {
        border-style:solid
    }

    html :where([style * =border-top-color]) {
        border-top-style:solid
    }

    html :where([style * =border-right-color]) {
        border-right-style:solid
    }

    html :where([style * =border-bottom-color]) {
        border-bottom-style:solid
    }

    html :where([style * =border-left-color]) {
        border-left-style:solid
    }

    html :where([style * =border-width]) {
        border-style:solid
    }

    html :where([style * =border-top-width]) {
        border-top-style:solid
    }

    html :where([style * =border-right-width]) {
        border-right-style:solid
    }

    html :where([style * =border-bottom-width]) {
        border-bottom-style:solid
    }

    html :where([style * =border-left-width]) {
        border-left-style:solid
    }

    html :where(img[class * =wp-image-]) {
        height: auto;
        max-width:100%
    }

    :where(figure) {
        margin:0 0 1em
    }

    html :where(.is-position-sticky) {
        --wp-admin--admin-bar--position-offset:var(--wp-admin--admin-bar--height, 0px)
    }

    @media screen and (max-width: 600px) {
        html :where(.is-position-sticky) {
            --wp-admin--admin-bar--position-offset: 0px
        }
    }
    </style>
    <link rel='stylesheet' id='flatsome-main-css' href='<?php echo get_stylesheet_directory_uri(); ?>/wwlp-assets/css/flatsome.css' type='text/css' media='all'/>
<!--    <style id='flatsome-main-inline-css' type='text/css'>
    @font-face {
        font-family: "fl-icons";
        font-display: block;
        src: url(https://wise.krimmelworks.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.eot?v=3.18.0);
        src:
        url(https://wise.krimmelworks.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.eot#iefix?v=3.18.0) format("embedded-opentype"), url(https://wise.krimmelworks.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.woff2?v=3.18.0) format("woff2"), url(https://wise.krimmelworks.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.ttf?v=3.18.0) format("truetype"), url(https://wise.krimmelworks.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.woff?v=3.18.0) format("woff"), url(https://wise.krimmelworks.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.svg?v=3.18.0#fl-icons) format("svg");
    }
    </style>
    <link rel='stylesheet' id='flatsome-shop-css' href='https://wise.krimmelworks.com/wp-content/themes/flatsome/assets/css/flatsome-shop.css?ver=3.18.0' type='text/css' media='all'/>
    -->
<!--    <link rel='stylesheet' id='flatsome-style-css' href='<?php echo get_stylesheet_directory_uri(); ?>/wwlp-styles/style.css?ver=3.18.0' type='text/css' media='all'/> -->
    <script type="text/javascript" src="<?php echo get_site_url(); ?>/wp-includes/js/jquery/jquery.min.js?ver=3.7.1" id="jquery-core-js"></script>
    <script type="text/javascript" src="<?php echo get_site_url(); ?>/wp-includes/js/jquery/jquery-migrate.min.js?ver=3.4.1" id="jquery-migrate-js"></script>
    <link rel="https://api.w.org/" href="<?php echo get_site_url(); ?>/wp-json/"/>
    <link rel="alternate" type="application/json" href="<?php echo get_site_url(); ?>/wp-json/wp/v2/pages/15349"/>
    <link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo get_site_url(); ?>/xmlrpc.php?rsd"/>
    <link rel="alternate" type="application/json+oembed" href="<?php echo get_site_url(); ?>/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fwise.krimmelworks.com%2Flanding-page%2F"/>
<!--    <link rel="alternate" type="text/xml+oembed" href="<?php echo get_site_url(); ?>/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fwise.krimmelworks.com%2Flanding-page%2F&#038;format=xml"/> -->
    <style>
    #header { 
    	display: none;
    }
    .bg {
        opacity: 0;
        transition: opacity 1s;
        -webkit-transition: opacity 1s;
    }

    .bg-loaded {
        opacity: 1;
    }
    </style>
    <style id="custom-css" type="text/css">
    :root {
        --primary-color: #374159;
    }

    .tooltipster-base {
        --tooltip-color: #fff;
        --tooltip-bg-color: #374159;
    }

    .off-canvas-right .mfp-content, .off-canvas-left .mfp-content {
        --drawer-width: 300px;
    }

    .off-canvas .mfp-content.off-canvas-cart {
        --drawer-width: 360px;
    }

    .container-width, .full-width .ubermenu-nav, .container, .row {
        max-width: 1670px
    }

    .row.row-collapse {
        max-width: 1640px
    }

    .row.row-small {
        max-width: 1662.5px
    }

    .row.row-large {
        max-width: 1700px
    }

    .header-main {
        height: 90px
    }

    #logo img {
        max-height: 90px
    }

    #logo {
        width: 200px;
    }

    .header-top {
        min-height: 30px
    }

    .transparent .header-main {
        height: 90px
    }

    .transparent #logo img {
        max-height: 90px
    }

    .has-transparent + .page-title:first-of-type, .has-transparent + #main > .page-title, .has-transparent + #main > div > .page-title, .has-transparent + #main .page-header-wrapper:first-of-type .page-title {
        padding-top: 120px;
    }

    .header.show-on-scroll, .stuck .header-main {
        height:70px !important
    }

    .stuck #logo img {
        max-height: 70px !important
    }

    .header-bottom {
        background-color: #f1f1f1
    }

    @media (max-width: 549px) {
        .header-main {
            height: 70px
        }

        #logo img {
            max-height: 70px
        }
    }

    body {
        color: #3b3b3b
    }

    h1, h2, h3, h4, h5, h6, .heading-font {
        color: #3b3b3b;
    }

    body {
        font-size: 151%;
    }

    @media screen and (max-width: 549px) {
        body {
            font-size: 85%;
        }
    }

    body {
        font-family: "Titillium Web", sans-serif;
    }

    body {
        font-weight: 400;
        font-style: normal;
    }

    .nav > li > a {
        font-family: "Titillium Web", sans-serif;
    }

    .mobile-sidebar-levels-2 .nav > li > ul > li > a {
        font-family: "Titillium Web", sans-serif;
    }

    .nav > li > a, .mobile-sidebar-levels-2 .nav > li > ul > li > a {
        font-weight: 700;
        font-style: normal;
    }

    h1, h2, h3, h4, h5, h6, .heading-font, .off-canvas-center .nav-sidebar.nav-vertical > li > a {
        font-family: "Titillium Web", sans-serif;
    }

    h1, h2, h3, h4, h5, h6, .heading-font, .banner h1, .banner h2 {
        font-weight: 700;
        font-style: normal;
    }

    .alt-font {
        font-family: Zeyada, sans-serif;
    }

    .alt-font {
        font-weight: 400 !important;
        font-style: normal !important;
    }

    input[type='submit'], input[type="button"], button:not(.icon), .button:not(.icon) {
        border-radius: 20 !important
    }

    @media screen and (min-width: 550px) {
        .products .box-vertical .box-image {
            min-width: 300px !important;
            width: 300px !important;
        }
    }

    .nav-vertical-fly-out > li + li {
        border-top-width: 1px;
        border-top-style: solid;
    }
    
    /* Custom CSS */

    h1 {
        font-size: 8rem;
        line-height: 7.5rem;
    }

    h1 .wwlp-small {
        font-size: 35%;
        font-weight: 500;
        display: block;
        margin: 0 0 -0.9em 0;
        padding: 0;
    }

    .wwlp-hl-slider {
        /* change for width & height of text */
        width: 12em;
        padding-top: 4.3em;
        /* height: 10em; */
        background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/gray-line.png');
        background-position: 50% 9.5em;
    }/* Custom CSS Tablet */

    @media (max-width: 849px) {
        h1 {
            font-size: 6rem;
            line-height: 5.5rem;
        }

        .wwlp-hl-slider {
            /* change for width & height of text */
            padding-top: 0;
            /* height: 10em; */
            background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/gray-line.png');
            background-position: 50% 340px;
        }
    }
    
    /* Custom CSS Mobile */

    @media (max-width: 549px) {
        .wwlp-panel-section, .wwlp-panel-section-darker {
            margin: 15px auto;
        }

        h1 {
            font-size: 3.5rem;
            line-height: 3.6rem;
        }

        h1 .wwlp-small {
            font-size: 45%;
            line-height: 2rem;
            margin: 0 0 -0.1em 0;
        }

        .wwlp-hl-slider {
            /* change for width & height of text */
            padding-top: 0;
            /* height: 10em; */
            background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/gray-line.png');
            background-position: 50% 320px;
        }
    }
/*
    .label-new.menu-item > a:after {
        content: "New";
    }

    .label-hot.menu-item > a:after {
        content: "Hot";
    }

    .label-sale.menu-item > a:after {
        content: "Sale";
    }

    .label-popular.menu-item > a:after {
        content: "Popular";
    }
    
*/   
    </style>
    <style type="text/css" id="wp-custom-css">
    .wwlp-panel-section, .wwlp-panel-section-darker {
        border: #F5F5F5 solid 1px;
        border-radius: 12px;
        background-color: #F5F5F5;
        width: 95%;
        margin: 30px auto;
    }

    .wwlp-panel-section-darker {
        border: #EBE8E5 solid 1px;
        border-radius: 12px;
        background-color: #EBE8E5;
    }

    h3 {
        font-size: 2rem;
    }

    .wwlp-nav img.alignleft {
        margin-right: 0.3em !important;
    }

    </style>
 <!--   
    <style id="kirki-inline-styles">
    /* latin-ext */
    @font-face {
        font-family: 'Titillium Web';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://wise.krimmelworks.com/wp-content/fonts/titillium-web/NaPecZTIAOhVxoMyOr9n_E7fdM3mC6ZRbryhsA.woff) format('woff');
        unicode-range: U + 0100-02AF, U + 0304, U + 0308, U + 0329, U + 1E00-1E9F, U + 1EF2-1EFF, U + 2020, U + 20A0-20AB, U + 20AD-20CF, U + 2113, U + 2C60-2C7F, U + A720-A7FF;
    }/* latin */

    @font-face {
        font-family: 'Titillium Web';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://wise.krimmelworks.com/wp-content/fonts/titillium-web/NaPecZTIAOhVxoMyOr9n_E7fdMPmC6ZRbrw.woff) format('woff');
        unicode-range: U + 0000-00FF, U + 0131, U + 0152-0153, U + 02BB-02BC, U + 02C6, U + 02DA, U + 02DC, U + 0304, U + 0308, U + 0329, U + 2000-206F, U + 2074, U + 20AC, U + 2122, U + 2191, U + 2193, U + 2212, U + 2215, U + FEFF, U + FFFD;
    }/* latin-ext */

    @font-face {
        font-family: 'Titillium Web';
        font-style: normal;
        font-weight: 700;
        font-display: swap;
        src: url(https://wise.krimmelworks.com/wp-content/fonts/titillium-web/NaPDcZTIAOhVxoMyOr9n_E7ffHjDGIVzZZabuWIGxA.woff) format('woff');
        unicode-range: U + 0100-02AF, U + 0304, U + 0308, U + 0329, U + 1E00-1E9F, U + 1EF2-1EFF, U + 2020, U + 20A0-20AB, U + 20AD-20CF, U + 2113, U + 2C60-2C7F, U + A720-A7FF;
    }/* latin */

    @font-face {
        font-family: 'Titillium Web';
        font-style: normal;
        font-weight: 700;
        font-display: swap;
        src: url(https://wise.krimmelworks.com/wp-content/fonts/titillium-web/NaPDcZTIAOhVxoMyOr9n_E7ffHjDGItzZZabuWI.woff) format('woff');
        unicode-range: U + 0000-00FF, U + 0131, U + 0152-0153, U + 02BB-02BC, U + 02C6, U + 02DA, U + 02DC, U + 0304, U + 0308, U + 0329, U + 2000-206F, U + 2074, U + 20AC, U + 2122, U + 2191, U + 2193, U + 2212, U + 2215, U + FEFF, U + FFFD;
    }/* latin */

    @font-face {
        font-family: 'Zeyada';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://wise.krimmelworks.com/wp-content/fonts/zeyada/11hAGpPTxVPUbgZzM2yqeqWJ3w.woff) format('woff');
        unicode-range: U + 0000-00FF, U + 0131, U + 0152-0153, U + 02BB-02BC, U + 02C6, U + 02DA, U + 02DC, U + 0304, U + 0308, U + 0329, U + 2000-206F, U + 2074, U + 20AC, U + 2122, U + 2191, U + 2193, U + 2212, U + 2215, U + FEFF, U + FFFD;
    }
    </style>
-->

	<?php wp_head(); ?>
</head>

    <div id="wrapper">

        <div id="main" class="">

            <div id="gap-2113865994" class="gap-element clearfix hide-for-small" style="display:block; height:auto;">

                <style>
                #gap-2113865994 {
                    padding-top: 30px;
                }
                </style>
            </div>

            <section class="section wwlp-panel-section" id="section_1314882179">
                <div class="bg section-bg fill bg-fill  bg-loaded">
                </div>

                <div class="section-content relative">

                    <div id="gap-149502669" class="gap-element clearfix" style="display:block; height:auto;">

                        <style>
                        #gap-149502669 {
                            padding-top: 30px;
                        }
                        </style>
                    </div>

                    <div class="row" id="row-915336626">

                        <div id="col-736368639" class="col small-12 large-12">
                            <div class="col-inner">

                                <div class="row align-bottom" id="row-537151906">

                                    <div id="col-447727177" class="col medium-4 small-12 large-4">
                                        <div class="col-inner">

                                            <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_108032957">
                                                <div class="img-inner dark">
                                                    <img decoding="async" src="https://wise.krimmelworks.com/wp-content/uploads/WW_CMYK_Blue-logo.svg" class="attachment-large size-large" alt=""/>
                                                </div>

                                                <style>
                                                #image_108032957 {
                                                    width: 67%;
                                                }
                                                </style>
                                            </div>

                                        </div>

                                        <style>
                                        #col-447727177 > .col-inner {
                                            padding: 0px 0px 0.5em 0px;
                                        }
                                        </style>
                                    </div>

                                    <div id="col-1371191041" class="col hide-for-small medium-8 small-12 large-8">
                                        <div class="col-inner text-right">

                                            <div id="stack-3604893384" class="stack wwlp-nav hide-for-small stack-row justify-end items-baseline">

                                                <div id="text-3797772161" class="text">

                                                    <p>
                                                        <a href="#">
                                                            <strong>Explore AI</strong>
                                                        </a>
                                                        <br/>
                                                </div>

                                                <div id="text-1366575652" class="text">

                                                    <p>
                                                        <a href="#">
                                                            <strong>Solutions</strong>
                                                        </a>
                                                        <br/>
                                                </div>

                                                <div id="text-1442153812" class="text">

                                                    <p>
                                                        <a href="#">
                                                            <strong>About Us</strong>
                                                        </a>
                                                        <br/>
                                                </div>

                                                <div id="text-4059724436" class="text">

                                                    <p style="margin-bottom: 0 !important;" data-wp-editing="1">
                                                        <a href="#">
                                                            <strong>
                                                                <img decoding="async" class="alignleft wp-image-15365" src="https://wise.krimmelworks.com/wp-content/uploads/ask-icon.png" alt="" width="36" height="36"/>
                                                                Ask Wisewire
                                                            </strong>
                                                        </a>
                                                    </p>

                                                    <style>
                                                    #text-4059724436 {
                                                        text-align: left;
                                                    }
                                                    </style>
                                                </div>

                                                <style>
                                                #stack-3604893384 > * {
                                                    --stack-gap: 2.25rem;
                                                }
                                                </style>
                                            </div>

                                        </div>
                                    </div>

                                    <div id="col-450490195" class="col show-for-small small-12 large-12">
                                        <div class="col-inner text-left">

                                            <p>
                                                <span style="color: #d83131;">Not sure yet how we&#8217;ll handle mobile nav.</span>
                                            </p>
                                            <div class="accordion">
                                                <div id="accordion-3446719053" class="accordion-item">
                                                    <a id="accordion-3446719053-label" class="accordion-title plain" href="#accordion-item-menu" aria-expanded="false" aria-controls="accordion-3446719053-content">
                                                        <button class="toggle" aria-label="Toggle">
                                                            <i class="icon-angle-down"></i>
                                                        </button>
                                                        <span>Menu</span>
                                                    </a>
                                                    <div id="accordion-3446719053-content" class="accordion-inner" aria-labelledby="accordion-3446719053-label">

                                                        <div id="stack-3709220517" class="stack wwlp-nav show-for-small stack-row justify-end items-end sm:stack-col sm:justify-start sm:items-start">

                                                            <div id="text-3509497911" class="text">

                                                                <p>
                                                                    <a href="#">
                                                                        <strong>Explore AI</strong>
                                                                    </a>
                                                                    <br/>
                                                            </div>

                                                            <div id="text-4256017483" class="text">

                                                                <p>
                                                                    <a href="#">
                                                                        <strong>Solutions</strong>
                                                                    </a>
                                                                    <br/>
                                                            </div>

                                                            <div id="text-356484786" class="text">

                                                                <p>
                                                                    <a href="#">
                                                                        <strong>About Us</strong>
                                                                    </a>
                                                                    <br/>
                                                            </div>

                                                            <div id="text-2764709606" class="text">

                                                                <p style="margin-bottom: 0 !important;">
                                                                    <a href="#">
                                                                        <strong>
                                                                            <img decoding="async" class="alignleft wp-image-15365" src="https://wise.krimmelworks.com/wp-content/uploads/ask-icon.png" alt="" width="24" height="24"/>
                                                                            Ask Wisewire
                                                                        </strong>
                                                                    </a>
                                                                </p>

                                                                <style>
                                                                #text-2764709606 {
                                                                    text-align: left;
                                                                }
                                                                </style>
                                                            </div>

                                                            <style>
                                                            #stack-3709220517 > * {
                                                                --stack-gap: 0.5rem;
                                                            }

                                                            @media (min-width: 550px) {
                                                                #stack-3709220517 > * {
                                                                    --stack-gap: 2.25rem;
                                                                }
                                                            }
                                                            </style>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row row-collapse" id="row-771643897">

                                    <div id="col-213406109" class="col small-12 large-12">
                                        <div class="col-inner">

                                            <div id="gap-1895179284" class="gap-element clearfix hide-for-small" style="display:block; height:auto;">

                                                <style>
                                                #gap-1895179284 {
                                                    padding-top: 6em;
                                                }
                                                </style>
                                            </div>

                                            <div id="stack-4060752184" class="stack stack-row justify-start items-stretch sm:stack-col md:stack-col">

                                                <div id="text-2514088544" class="text">

                                                    <h1>
                                                        <span class="wwlp-small">What if you could</span>
                                                         rewrite your
                                                    </h1>

                                                    <style>
                                                    #text-2514088544 {
                                                        font-size: 0.75rem;
                                                    }
                                                    </style>
                                                </div>

                                                <div class="slider-wrapper relative wwlp-hl-slider" id="slider-17359995">
                                                    <div class="slider slider-type-fade slider-nav-circle slider-nav-large slider-nav-light slider-style-normal" data-flickity-options='{
                                                                "cellAlign": "center",
                                                                "imagesLoaded": true,
                                                                "lazyLoad": 1,
                                                                "freeScroll": false,
                                                                "wrapAround": true,
                                                                "autoPlay": 6000,
                                                                "pauseAutoPlayOnHover" : false,
                                                                "prevNextButtons": false,
                                                                "contain" : true,
                                                                "adaptiveHeight" : true,
                                                                "dragThreshold" : 10,
                                                                "percentPosition": true,
                                                                "pageDots": false,
                                                                "rightToLeft": false,
                                                                "draggable": false,
                                                                "selectedAttraction": 0.1,
                                                                "parallax" : 0,
                                                                "friction": 0.6        }'>

                                                        <div class="row row-collapse align-center" style="max-width:" id="row-387661638">

                                                            <div id="col-1325889921" class="col small-12 large-12">
                                                                <div class="col-inner text-center">

                                                                    <h1 class="alt-font">story</h1>
                                                                </div>

                                                                <style>
                                                                #col-1325889921 > .col-inner {
                                                                    padding: 0px 0px 0px 0px;
                                                                }
                                                                </style>
                                                            </div>

                                                        </div>
                                                        <div class="row row-collapse" style="max-width:" id="row-232046597">

                                                            <div id="col-304352601" class="col small-12 large-12">
                                                                <div class="col-inner text-center">

                                                                    <h1 class="alt-font">word2</h1>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row row-collapse" style="max-width:" id="row-176958423">

                                                            <div id="col-1681182734" class="col small-12 large-12">
                                                                <div class="col-inner text-center">

                                                                    <h1 class="alt-font">word3</h1>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="loading-spin dark large centered"></div>

                                                </div>

                                                <div id="text-805680272" class="text hide-for-medium">

                                                    <h1 style="margin-top: .6em;">.</h1>
                                                </div>

                                                <style>
                                                #stack-4060752184 > * {
                                                    --stack-gap: 0rem;
                                                }

                                                @media (min-width: 550px) {
                                                    #stack-4060752184 > * {
                                                        --stack-gap: 0.75rem;
                                                    }
                                                }
                                                </style>
                                            </div>

                                        </div>

                                        <style>
                                        #col-213406109 > .col-inner {
                                            padding: 0px 0px 20px 0px;
                                        }
                                        </style>
                                    </div>

                                </div>

                                <div class="row row-collapse" id="row-1756087653">

                                    <div id="col-264486651" class="col medium-6 small-12 large-3">
                                        <div class="col-inner">

                                            <p>illustration here</p>
                                        </div>
                                    </div>

                                    <div id="col-1300420045" class="col medium-6 small-12 large-3 small-col-first">
                                        <div class="col-inner">

                                            <div id="gap-646970527" class="gap-element clearfix hide-for-small" style="display:block; height:auto;">

                                                <style>
                                                #gap-646970527 {
                                                    padding-top: 5em;
                                                }
                                                </style>
                                            </div>

                                            <p class="lead">
                                                <strong>AI-Driven, Transformative Learning Solutions that Shape Futures</strong>
                                            </p>
                                        </div>

                                        <style>
                                        #col-1300420045 > .col-inner {
                                            padding: 0px 20px 0px 0px;
                                            margin: 0px 0px 0px 0px;
                                        }
                                        </style>
                                    </div>

                                </div>
                            </div>

                            <style>
                            #col-736368639 > .col-inner {
                                padding: 30px 10px 10px 10px;
                            }

                            @media (min-width: 550px) {
                                #col-736368639 > .col-inner {
                                    padding: 30px 40px 0px 40px;
                                }
                            }
                            </style>
                        </div>

                    </div>
                </div>

                <style>
                #section_1314882179 {
                    padding-top: 0px;
                    padding-bottom: 0px;
                }
                </style>
            </section>

            <section class="section" id="section_1872797388">
                <div class="bg section-bg fill bg-fill  bg-loaded">
                </div>

                <div class="section-content relative">

                    <div class="row large-columns-8 medium-columns-3 small-columns-3 row-full-width slider row-slider slider-nav-reveal" data-flickity-options='{"imagesLoaded": true, "groupCells": "100%", "dragThreshold" : 5, "cellAlign": "left","wrapAround": true,"prevNextButtons": true,"percentPosition": true,"pageDots": false, "rightToLeft": false, "autoPlay" : 7000}'>

                        <div class="gallery-col col">
                            <div class="col-inner">
                                <div class="box has-hover gallery-box box-none">
                                    <div class="box-image">
                                        <img fetchpriority="high" decoding="async" width="558" height="208" src="https://wise.krimmelworks.com/wp-content/uploads/logo-ageoflearning.png" class="attachment-medium size-medium" alt="Age of Learning" ids="15378,15379,15380,15381,15382,15383,15384,15385,15386,15387,15388,15389,15390,15391" style="none" lightbox="false" type="slider" width="full-width" columns="8" columns__sm="3" auto_slide="7000"/>
                                    </div>
                                    <div class="box-text text-left">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-col col">
                            <div class="col-inner">
                                <div class="box has-hover gallery-box box-none">
                                    <div class="box-image">
                                        <img loading="lazy" decoding="async" width="338" height="208" src="https://wise.krimmelworks.com/wp-content/uploads/logo-aws.png" class="attachment-medium size-medium" alt="AWS" ids="15378,15379,15380,15381,15382,15383,15384,15385,15386,15387,15388,15389,15390,15391" style="none" lightbox="false" type="slider" width="full-width" columns="8" columns__sm="3" auto_slide="7000"/>
                                    </div>
                                    <div class="box-text text-left">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-col col">
                            <div class="col-inner">
                                <div class="box has-hover gallery-box box-none">
                                    <div class="box-image">
                                        <img loading="lazy" decoding="async" width="298" height="208" src="https://wise.krimmelworks.com/wp-content/uploads/logo-brainpop.png" class="attachment-medium size-medium" alt="Brain Pop" ids="15378,15379,15380,15381,15382,15383,15384,15385,15386,15387,15388,15389,15390,15391" style="none" lightbox="false" type="slider" width="full-width" columns="8" columns__sm="3" auto_slide="7000"/>
                                    </div>
                                    <div class="box-text text-left">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-col col">
                            <div class="col-inner">
                                <div class="box has-hover gallery-box box-none">
                                    <div class="box-image">
                                        <img loading="lazy" decoding="async" width="298" height="208" src="https://wise.krimmelworks.com/wp-content/uploads/logo-chegg.png" class="attachment-medium size-medium" alt="Chegg" ids="15378,15379,15380,15381,15382,15383,15384,15385,15386,15387,15388,15389,15390,15391" style="none" lightbox="false" type="slider" width="full-width" columns="8" columns__sm="3" auto_slide="7000"/>
                                    </div>
                                    <div class="box-text text-left">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-col col">
                            <div class="col-inner">
                                <div class="box has-hover gallery-box box-none">
                                    <div class="box-image">
                                        <img loading="lazy" decoding="async" width="338" height="208" src="https://wise.krimmelworks.com/wp-content/uploads/logo-cicso.png" class="attachment-medium size-medium" alt="Cisco" ids="15378,15379,15380,15381,15382,15383,15384,15385,15386,15387,15388,15389,15390,15391" style="none" lightbox="false" type="slider" width="full-width" columns="8" columns__sm="3" auto_slide="7000"/>
                                    </div>
                                    <div class="box-text text-left">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-col col">
                            <div class="col-inner">
                                <div class="box has-hover gallery-box box-none">
                                    <div class="box-image">
                                        <img loading="lazy" decoding="async" width="466" height="208" src="https://wise.krimmelworks.com/wp-content/uploads/logo-discovery.png" class="attachment-medium size-medium" alt="Discovery Education" ids="15378,15379,15380,15381,15382,15383,15384,15385,15386,15387,15388,15389,15390,15391" style="none" lightbox="false" type="slider" width="full-width" columns="8" columns__sm="3" auto_slide="7000"/>
                                    </div>
                                    <div class="box-text text-left">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-col col">
                            <div class="col-inner">
                                <div class="box has-hover gallery-box box-none">
                                    <div class="box-image">
                                        <img loading="lazy" decoding="async" width="478" height="208" src="https://wise.krimmelworks.com/wp-content/uploads/logo-harvardms.png" class="attachment-medium size-medium" alt="Harvard Medical School" ids="15378,15379,15380,15381,15382,15383,15384,15385,15386,15387,15388,15389,15390,15391" style="none" lightbox="false" type="slider" width="full-width" columns="8" columns__sm="3" auto_slide="7000"/>
                                    </div>
                                    <div class="box-text text-left">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-col col">
                            <div class="col-inner">
                                <div class="box has-hover gallery-box box-none">
                                    <div class="box-image">
                                        <img loading="lazy" decoding="async" width="356" height="208" src="https://wise.krimmelworks.com/wp-content/uploads/logo-imagine.png" class="attachment-medium size-medium" alt="Imagine Learning" ids="15378,15379,15380,15381,15382,15383,15384,15385,15386,15387,15388,15389,15390,15391" style="none" lightbox="false" type="slider" width="full-width" columns="8" columns__sm="3" auto_slide="7000"/>
                                    </div>
                                    <div class="box-text text-left">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-col col">
                            <div class="col-inner">
                                <div class="box has-hover gallery-box box-none">
                                    <div class="box-image">
                                        <img loading="lazy" decoding="async" width="356" height="208" src="https://wise.krimmelworks.com/wp-content/uploads/logo-k12.png" class="attachment-medium size-medium" alt="K12" ids="15378,15379,15380,15381,15382,15383,15384,15385,15386,15387,15388,15389,15390,15391" style="none" lightbox="false" type="slider" width="full-width" columns="8" columns__sm="3" auto_slide="7000"/>
                                    </div>
                                    <div class="box-text text-left">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-col col">
                            <div class="col-inner">
                                <div class="box has-hover gallery-box box-none">
                                    <div class="box-image">
                                        <img loading="lazy" decoding="async" width="386" height="208" src="https://wise.krimmelworks.com/wp-content/uploads/logo-kaplan.png" class="attachment-medium size-medium" alt="Kaplan" ids="15378,15379,15380,15381,15382,15383,15384,15385,15386,15387,15388,15389,15390,15391" style="none" lightbox="false" type="slider" width="full-width" columns="8" columns__sm="3" auto_slide="7000"/>
                                    </div>
                                    <div class="box-text text-left">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-col col">
                            <div class="col-inner">
                                <div class="box has-hover gallery-box box-none">
                                    <div class="box-image">
                                        <img loading="lazy" decoding="async" width="466" height="208" src="https://wise.krimmelworks.com/wp-content/uploads/logo-natgeo.png" class="attachment-medium size-medium" alt="National Geographic" ids="15378,15379,15380,15381,15382,15383,15384,15385,15386,15387,15388,15389,15390,15391" style="none" lightbox="false" type="slider" width="full-width" columns="8" columns__sm="3" auto_slide="7000"/>
                                    </div>
                                    <div class="box-text text-left">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-col col">
                            <div class="col-inner">
                                <div class="box has-hover gallery-box box-none">
                                    <div class="box-image">
                                        <img loading="lazy" decoding="async" width="386" height="208" src="https://wise.krimmelworks.com/wp-content/uploads/logo-pearson.png" class="attachment-medium size-medium" alt="Pearson" ids="15378,15379,15380,15381,15382,15383,15384,15385,15386,15387,15388,15389,15390,15391" style="none" lightbox="false" type="slider" width="full-width" columns="8" columns__sm="3" auto_slide="7000"/>
                                    </div>
                                    <div class="box-text text-left">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-col col">
                            <div class="col-inner">
                                <div class="box has-hover gallery-box box-none">
                                    <div class="box-image">
                                        <img loading="lazy" decoding="async" width="408" height="208" src="https://wise.krimmelworks.com/wp-content/uploads/logo-uphoenix.png" class="attachment-medium size-medium" alt="University of Phoenix" ids="15378,15379,15380,15381,15382,15383,15384,15385,15386,15387,15388,15389,15390,15391" style="none" lightbox="false" type="slider" width="full-width" columns="8" columns__sm="3" auto_slide="7000" srcset="https://wise.krimmelworks.com/wp-content/uploads/logo-uphoenix.png 408w, https://wise.krimmelworks.com/wp-content/uploads/logo-uphoenix-237x120.png 237w" sizes="(max-width: 408px) 100vw, 408px"/>
                                    </div>
                                    <div class="box-text text-left">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-col col">
                            <div class="col-inner">
                                <div class="box has-hover gallery-box box-none">
                                    <div class="box-image">
                                        <img loading="lazy" decoding="async" width="358" height="208" src="https://wise.krimmelworks.com/wp-content/uploads/logo-wiley.png" class="attachment-medium size-medium" alt="Wiley" ids="15378,15379,15380,15381,15382,15383,15384,15385,15386,15387,15388,15389,15390,15391" style="none" lightbox="false" type="slider" width="full-width" columns="8" columns__sm="3" auto_slide="7000"/>
                                    </div>
                                    <div class="box-text text-left">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                #section_1872797388 {
                    padding-top: 0px;
                    padding-bottom: 0px;
                }
                </style>
            </section>

            <section class="section" id="section_1194333226">
                <div class="bg section-bg fill bg-fill  bg-loaded">
                </div>

                <div class="section-content relative">

                    <div class="row" id="row-436282608">

                        <div id="col-455636201" class="col small-12 large-12">
                            <div class="col-inner">

                                <div id="gap-1509281336" class="gap-element clearfix hide-for-small" style="display:block; height:auto;">

                                    <style>
                                    #gap-1509281336 {
                                        padding-top: 3em;
                                    }
                                    </style>
                                </div>

                                <div id="text-434127159" class="text">

                                    <h1>
                                        <span class="wwlp-small">What if you could</span>
                                         customize your journey.
                                    </h1>

                                    <style>
                                    #text-434127159 {
                                        font-size: 0.75rem;
                                    }
                                    </style>
                                </div>

                                <div class="row" id="row-1971729059">

                                    <div id="col-403343138" class="col medium-8 small-12 large-6">
                                        <div class="col-inner">

                                            <h3>Your Journey, Your Future.</h3>
                                            <p class="lead">Traditional education might have its limits, but we don’t. We bridge the gap between what you aspire and what you achieve.</p>
                                        </div>

                                        <style>
                                        #col-403343138 > .col-inner {
                                            padding: 0px 0px 0px 0px;
                                        }

                                        @media (min-width: 550px) {
                                            #col-403343138 > .col-inner {
                                                padding: 0px 0px 0px 0px;
                                            }
                                        }

                                        @media (min-width: 850px) {
                                            #col-403343138 > .col-inner {
                                                padding: 0px 5em 0px 0px;
                                            }
                                        }
                                        </style>
                                    </div>

                                    <div id="col-665510404" class="col medium-4 small-12 large-6">
                                        <div class="col-inner text-right">

                                            <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_2021971276">
                                                <div class="img-inner dark">
                                                    <img loading="lazy" decoding="async" width="1142" height="915" src="https://wise.krimmelworks.com/wp-content/uploads/FPO-astronaut.png" class="attachment-original size-original" alt="" srcset="https://wise.krimmelworks.com/wp-content/uploads/FPO-astronaut.png 1142w, https://wise.krimmelworks.com/wp-content/uploads/FPO-astronaut-768x615.png 768w" sizes="(max-width: 1142px) 100vw, 1142px"/>
                                                </div>

                                                <style>
                                                #image_2021971276 {
                                                    width: 100%;
                                                }
                                                </style>
                                            </div>

                                        </div>

                                        <style>
                                        #col-665510404 > .col-inner {
                                            padding: 2em 0px 0px 0px;
                                        }

                                        @media (min-width: 850px) {
                                            #col-665510404 > .col-inner {
                                                padding: 0px 0px 0px 8em;
                                            }
                                        }
                                        </style>
                                    </div>

                                </div>
                                <div class="row align-equal row-box-shadow-1" id="row-1894506431">

                                    <div id="col-1619559968" class="col medium-6 small-12 large-3" data-animate="bounceInUp">
                                        <div class="col-inner box-shadow-2-hover" style="background-color:rgb(251, 207, 89);">

                                            <h4>Engaging Content</h4>
                                            <p>Crafting vibrant and rigorous learning experiences targeted for retention.</p>
                                        </div>
                                    </div>

                                    <div id="col-1877466380" class="col medium-6 small-12 large-3 col-hover-focus" data-animate="bounceInUp">
                                        <div class="col-inner box-shadow-2-hover" style="background-color:rgb(255, 255, 255);">

                                            <h4>Course Pathways</h4>
                                            <p>Career specific pathways to executive continuing education courses.</p>
                                        </div>
                                    </div>

                                    <div id="col-1558906919" class="col medium-6 small-12 large-3 col-hover-focus" data-animate="bounceInUp">
                                        <div class="col-inner box-shadow-2-hover" style="background-color:rgb(216, 212, 207);">

                                            <h4>Skills Mapping</h4>
                                            <p>Designing content to map directly to in-demand skills and competencies.</p>
                                        </div>
                                    </div>

                                    <div id="col-1604297362" class="col medium-6 small-12 large-3 col-hover-focus" data-animate="bounceInUp">
                                        <div class="col-inner box-shadow-2-hover dark" style="background-color:#374159;">

                                            <h4>Learning Journeys</h4>
                                            <p>Designing content to map directly to in-demand skills and competencies.</p>
                                        </div>
                                    </div>

                                    <style>
                                    #row-1894506431 > .col > .col-inner {
                                        padding: 20px 20px 20px 30px;
                                        border-radius: 15px;
                                    }
                                    </style>
                                </div>
                            </div>

                            <style>
                            #col-455636201 > .col-inner {
                                padding: 90px 20px 10px 20px;
                            }

                            @media (min-width: 550px) {
                                #col-455636201 > .col-inner {
                                    padding: 90px 40px 10px 40px;
                                }
                            }
                            </style>
                        </div>

                    </div>
                </div>

                <style>
                #section_1194333226 {
                    padding-top: 0px;
                    padding-bottom: 0px;
                    background-color: rgb(235, 232, 229);
                }
                </style>
            </section>

            <section class="section" id="section_1579126050">
                <div class="bg section-bg fill bg-fill  bg-loaded">
                </div>

                <div class="section-content relative">

                    <div class="row" id="row-1658308680">

                        <div id="col-1992211925" class="col small-12 large-12">
                            <div class="col-inner">

                                <div class="row" id="row-965353744">

                                    <div id="col-757907816" class="col medium-6 small-12 large-6">
                                        <div class="col-inner">

                                            <p>photos or video here</p>
                                        </div>
                                    </div>

                                    <div id="col-2027387060" class="col medium-6 small-12 large-4" data-animate="blurIn">
                                        <div class="col-inner">

                                            <div id="gap-343249810" class="gap-element clearfix hide-for-small" style="display:block; height:auto;">

                                                <style>
                                                #gap-343249810 {
                                                    padding-top: 5em;
                                                }
                                                </style>
                                            </div>

                                            <div class="icon-box featured-box icon-box-left text-left">
                                                <div class="icon-box-img" style="width: 39px">
                                                    <div class="icon">
                                                        <div class="icon-inner">
                                                            <img loading="lazy" decoding="async" width="152" height="108" src="https://wise.krimmelworks.com/wp-content/uploads/quote-blue.png" class="attachment-medium size-medium" alt=""/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="icon-box-text last-reset">

                                                    <div id="gap-833159256" class="gap-element clearfix" style="display:block; height:auto;">

                                                        <style>
                                                        #gap-833159256 {
                                                            padding-top: 15px;
                                                        }
                                                        </style>
                                                    </div>

                                                    <p>
                                                        <span style="font-size: 110%;" data-animate="fadeIn">
                                                            <strong>Since partnering with Wisewire, our educational journey has been nothing short of transformative.”</strong>
                                                        </span>
                                                    </p>
                                                    <p data-animate-delay="200">
                                                        <strong>
                                                            <span style="font-size: 85%;">Jordan A.</span>
                                                        </strong>
                                                        <br/>
                                                        <span style="font-size: 85%;" data-animate="fadeIn">
                                                            <em>VP of Academics, Customer Academy</em>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>

                                            <div id="gap-773663112" class="gap-element clearfix hide-for-small" style="display:block; height:auto;">

                                                <style>
                                                #gap-773663112 {
                                                    padding-top: 5em;
                                                }
                                                </style>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <style>
                        #row-1658308680 > .col > .col-inner {
                            padding: 0px 20px 0px 20px;
                        }

                        @media (min-width: 550px) {
                            #row-1658308680 > .col > .col-inner {
                                padding: 0px 20px 0px 40px;
                            }
                        }
                        </style>
                    </div>
                </div>

                <style>
                #section_1579126050 {
                    padding-top: 30px;
                    padding-bottom: 30px;
                    min-height: 400px;
                }
                </style>
            </section>

            <section class="section" id="section_857785330">
                <div class="bg section-bg fill bg-fill  bg-loaded">
                </div>

                <div class="section-content relative">

                    <div id="gap-44405690" class="gap-element clearfix" style="display:block; height:auto;">

                        <style>
                        #gap-44405690 {
                            padding-top: 3em;
                        }
                        </style>
                    </div>

                    <div class="row" id="row-774305662">

                        <div id="col-1014787053" class="col small-12 large-12">
                            <div class="col-inner">

                                <div class="row align-equal align-center" id="row-1190965178">

                                    <div id="col-1475538846" class="col small-12 large-12">
                                        <div class="col-inner text-center">

                                            <div id="text-4271539605" class="text">

                                                <h3>Results You Care About</h3>

                                                <style>
                                                #text-4271539605 {
                                                    font-size: 2.15rem;
                                                }
                                                </style>
                                            </div>

                                        </div>

                                        <style>
                                        #col-1475538846 > .col-inner {
                                            padding: 3em 0px 4em 0px;
                                        }
                                        </style>
                                    </div>

                                    <div id="col-830367382" class="col medium-6 small-12 large-4" data-animate="flipInY">
                                        <div class="col-inner text-center">

                                            <h2 data-animate="fadeInRight">Cost Savings of 15-35%</h2>
                                        </div>
                                    </div>

                                    <div id="col-1945271479" class="col medium-6 small-12 large-4" data-animate="flipInY">
                                        <div class="col-inner text-center">

                                            <h2 data-animate="fadeInRight">45-75% Faster Time-to-Market</h2>
                                        </div>
                                    </div>

                                    <div id="col-190393705" class="col medium-6 small-12 large-4" data-animate="flipInY">
                                        <div class="col-inner text-center">

                                            <h2 data-animate="fadeInRight">1st Storyboards – 0 Content Errors</h2>
                                        </div>
                                    </div>

                                    <div id="col-75442297" class="col medium-6 small-12 large-4" data-animate="flipInY">
                                        <div class="col-inner text-center">

                                            <h2 data-animate="fadeInRight">50% Less Content Revisions</h2>
                                        </div>
                                    </div>

                                    <div id="col-881760245" class="col medium-6 small-12 large-4" data-animate="flipInY">
                                        <div class="col-inner text-center">

                                            <h2 data-animate="fadeInRight">Storyboards in 60% Less Time</h2>
                                        </div>
                                    </div>

                                    <div id="col-1231553897" class="col medium-6 small-12 large-4" data-animate="flipInY">
                                        <div class="col-inner text-center">

                                            <h2 data-animate="fadeInRight">6.5 Million Learners Reached</h2>
                                        </div>
                                    </div>

                                    <div id="col-452658582" class="col small-12 large-12">
                                        <div class="col-inner text-center">

                                            <a data-animate="fadeInRight" href="#" class="button primary is-small lowercase" style="border-radius:99px;padding:5px 50px 5px 50px;">
                                                <span>Explore Ai</span>
                                            </a>

                                        </div>

                                        <style>
                                        #col-452658582 > .col-inner {
                                            margin: 30px 0px 0px 0px;
                                        }
                                        </style>
                                    </div>

                                    <style>
                                    #row-1190965178 > .col > .col-inner {
                                        padding: 0px 4em 0px 4em;
                                    }
                                    </style>
                                </div>
                            </div>
                        </div>

                        <style>
                        #row-774305662 > .col > .col-inner {
                            padding: 0px 20px 0px 20px;
                        }

                        @media (min-width: 550px) {
                            #row-774305662 > .col > .col-inner {
                                padding: 0px 20px 0px 40px;
                            }
                        }
                        </style>
                    </div>
                </div>

                <style>
                #section_857785330 {
                    padding-top: 30px;
                    padding-bottom: 30px;
                    background-color: rgb(245, 245, 245);
                }
                </style>
            </section>

            <section class="section wwlp-panel-section-darker" id="section_1010990290">
                <div class="bg section-bg fill bg-fill  bg-loaded">
                </div>

                <div class="section-content relative">

                    <div id="gap-129421201" class="gap-element clearfix" style="display:block; height:auto;">

                        <style>
                        #gap-129421201 {
                            padding-top: 30px;
                        }
                        </style>
                    </div>

                    <div class="row" id="row-1141566981">

                        <div id="col-2046684051" class="col small-12 large-12">
                            <div class="col-inner">

                                <div class="row" id="row-2042558049">

                                    <div id="col-1808076898" class="col small-12 large-12">
                                        <div class="col-inner">

                                            <div id="gap-524488120" class="gap-element clearfix" style="display:block; height:auto;">

                                                <style>
                                                #gap-524488120 {
                                                    padding-top: 3em;
                                                }
                                                </style>
                                            </div>

                                            <div id="text-705876135" class="text">

                                                <h1>
                                                    <span class="wwlp-small">What if you could</span>
                                                     forge your own path?
                                                </h1>

                                                <style>
                                                #text-705876135 {
                                                    font-size: 0.75rem;
                                                }
                                                </style>
                                            </div>

                                        </div>

                                        <style>
                                        #col-1808076898 > .col-inner {
                                            padding: 30px 0px 0px 0px;
                                            margin: 0px 0px -40px 0px;
                                        }
                                        </style>
                                    </div>

                                </div>
                                <div class="row" id="row-1135315578">

                                    <div id="col-1625117552" class="col medium-5 small-12 large-5">
                                        <div class="col-inner text-left">

                                            <p class="lead">
                                                <strong>Your Journey Starts Now.</strong>
                                            </p>
                                            <div id="gap-1461633922" class="gap-element clearfix" style="display:block; height:auto;">

                                                <style>
                                                #gap-1461633922 {
                                                    padding-top: 30px;
                                                }
                                                </style>
                                            </div>

                                            <a data-animate="fadeInRight" href="#" class="button primary is-small lowercase" style="border-radius:99px;padding:5px 50px 5px 50px;">
                                                <span>Schedule a Demo</span>
                                            </a>

                                            <div id="gap-1735824122" class="gap-element clearfix" style="display:block; height:auto;">

                                                <style>
                                                #gap-1735824122 {
                                                    padding-top: 3em;
                                                }
                                                </style>
                                            </div>

                                        </div>

                                        <style>
                                        #col-1625117552 > .col-inner {
                                            padding: 0px 20px 0px 0px;
                                            margin: 0px 0px 0px 0px;
                                        }
                                        </style>
                                    </div>

                                    <div id="col-1644015649" class="col medium-6 small-12 large-6">
                                        <div class="col-inner text-right">

                                            <p>illustration here</p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <style>
                            #col-2046684051 > .col-inner {
                                padding: 50px 40px 10px 10px;
                            }

                            @media (min-width: 550px) {
                                #col-2046684051 > .col-inner {
                                    padding: 50px 40px 10px 40px;
                                }
                            }
                            </style>
                        </div>

                    </div>
                </div>

                <style>
                #section_1010990290 {
                    padding-top: 0px;
                    padding-bottom: 0px;
                }
                </style>
            </section>

            <section class="section dark" id="section_1472151273">
                <div class="bg section-bg fill bg-fill  bg-loaded">
                </div>

                <div class="section-content relative">

                    <div class="row" id="row-664565075">

                        <div id="col-880974908" class="col small-12 large-12">
                            <div class="col-inner">

                                <p>
                                    <strong>
                                        <a href="#">Explore AI</a>
                                    </strong>
                                    <br/>
                                    <strong>
                                        <a href="#">About Us</a>
                                    </strong>
                                    <br/>
                                    <strong>
                                        <a href="#">Contact</a>
                                    </strong>
                                </p>
                                <div class="social-icons follow-icons">
                                    <a href="http://url" target="_blank" data-label="Facebook" class="icon button circle is-outline facebook tooltip" title="Follow on Facebook" aria-label="Follow on Facebook" rel="noopener nofollow">
                                        <i class="icon-facebook"></i>
                                    </a>
                                    <a href="http://url" target="_blank" data-label="Instagram" class="icon button circle is-outline instagram tooltip" title="Follow on Instagram" aria-label="Follow on Instagram" rel="noopener nofollow">
                                        <i class="icon-instagram"></i>
                                    </a>
                                    <a href="http://url" data-label="Twitter" target="_blank" class="icon button circle is-outline twitter tooltip" title="Follow on Twitter" aria-label="Follow on Twitter" rel="noopener nofollow">
                                        <i class="icon-twitter"></i>
                                    </a>
                                    <a href="mailto:your@email" data-label="E-mail" target="_blank" class="icon button circle is-outline email tooltip" title="Send us an email" aria-label="Send us an email" rel="nofollow noopener">
                                        <i class="icon-envelop"></i>
                                    </a>
                                </div>
                                <p>
                                    <span style="color: #ffff00;">Are these supposed to be sharing or follow icons?</span>
                                </p>
                            </div>

                            <style>
                            #col-880974908 > .col-inner {
                                padding: 10px 40px 10px 20px;
                            }

                            @media (min-width: 550px) {
                                #col-880974908 > .col-inner {
                                    padding: 10px 40px 10px 40px;
                                }
                            }
                            </style>
                        </div>

                    </div>
                </div>

                <style>
                #section_1472151273 {
                    padding-top: 30px;
                    padding-bottom: 30px;
                    background-color: rgb(55, 65, 89);
                }
                </style>
            </section>

        </div>

    </div>
    
<?php
    /*
      Define Theme Options  
    */
    
    // General
    $options_google_analytics_code = (!WAN_TEST_ENVIRONMENT)? get_field('options_google_analytics_code', 'option') : "###"; 
    
    // Footer
    $options_terms_and_usage_rights_pdf = get_field('options_terms_and_usage_rights_pdf', 'option');
  ?>
  
    <style id='global-styles-inline-css' type='text/css'>
    body {
        --wp--preset--color--primary: #374159;
        --wp--preset--color--secondary: #66b2cc;
        --wp--preset--color--success: #7a9c59;
        --wp--preset--color--alert: #d7532a;
        --wp--preset--font-size--small: 13px;
        --wp--preset--font-size--medium: 20px;
        --wp--preset--font-size--large: 36px;
        --wp--preset--font-size--x-large: 42px;
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
        --wp--custom--experimental--link--color: #374159;
        --wp--custom--experimental--link--color-hover: #66b2cc;

    }

    body {
        margin: 0;
    }

    .wp-site-blocks > .alignleft {
        float: left;
        margin-right: 2em;
    }

    .wp-site-blocks > .alignright {
        float: right;
        margin-left: 2em;
    }

    .wp-site-blocks > .aligncenter {
        justify-content: center;
        margin-left: auto;
        margin-right: auto;
    }

    :where(.is-layout-flex) {
        gap: 0.5em;
    }

    :where(.is-layout-grid) {
        gap: 0.5em;
    }

    body .is-layout-flow > .alignleft {
        float: left;
        margin-inline-start: 0;
        margin-inline-end: 2em;
    }

    body .is-layout-flow > .alignright {
        float: right;
        margin-inline-start: 2em;
        margin-inline-end: 0;
    }

    body .is-layout-flow > .aligncenter {
        margin-left: auto !important;
        margin-right: auto !important;
    }

    body .is-layout-constrained > .alignleft {
        float: left;
        margin-inline-start: 0;
        margin-inline-end: 2em;
    }

    body .is-layout-constrained > .alignright {
        float: right;
        margin-inline-start: 2em;
        margin-inline-end: 0;
    }

    body .is-layout-constrained > .aligncenter {
        margin-left: auto !important;
        margin-right: auto !important;
    }

    body .is-layout-constrained > :where(:not(.alignleft):not(.alignright):not(.alignfull)) {
        max-width: var(--wp--style--global--content-size);
        margin-left: auto !important;
        margin-right: auto !important;
    }

    body .is-layout-constrained > .alignwide {
        max-width: var(--wp--style--global--wide-size);
    }

    body .is-layout-flex {
        display: flex;
    }

    body .is-layout-flex {
        flex-wrap: wrap;
        align-items: center;
    }

    body .is-layout-flex > * {
        margin: 0;
    }

    body .is-layout-grid {
        display: grid;
    }

    body .is-layout-grid > * {
        margin: 0;
    }

    body {
        padding-top: 0px;
        padding-right: 0px;
        padding-bottom: 0px;
        padding-left: 0px;
    }

    a:where(:not(.wp-element-button)) {
        text-decoration: none;
    }

    .wp-element-button, .wp-block-button__link {
        background-color: #32373c;
        border-width: 0;
        color: #fff;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        padding: calc(0.667em + 2px) calc(1.333em + 2px);
        text-decoration: none;
    }
    .has-primary-color {
        color: var(--wp--preset--color--primary) !important;
    }

    .has-secondary-color {
        color: var(--wp--preset--color--secondary) !important;
    }

    .has-success-color {
        color: var(--wp--preset--color--success) !important;
    }

    .has-alert-color {
        color: var(--wp--preset--color--alert) !important;
    }

    .has-black-background-color {
        background-color: var(--wp--preset--color--black) !important;
    }
    .has-primary-background-color {
        background-color: var(--wp--preset--color--primary) !important;
    }

    .has-secondary-background-color {
        background-color: var(--wp--preset--color--secondary) !important;
    }

    .has-success-background-color {
        background-color: var(--wp--preset--color--success) !important;
    }

    .has-alert-background-color {
        background-color: var(--wp--preset--color--alert) !important;
    }
    .has-primary-border-color {
        border-color: var(--wp--preset--color--primary) !important;
    }

    .has-secondary-border-color {
        border-color: var(--wp--preset--color--secondary) !important;
    }

    .has-success-border-color {
        border-color: var(--wp--preset--color--success) !important;
    }

    .has-alert-border-color {
        border-color: var(--wp--preset--color--alert) !important;
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

    </style>
    <script type="text/javascript" src="<?php echo get_site_url(); ?>/wp-includes/js/hoverIntent.min.js?ver=1.10.2" id="hoverIntent-js"></script>
    <script type="text/javascript" id="flatsome-js-js-extra">
    /* <![CDATA[ */
    var flatsomeVars = {
        "theme": {
            "version": "3.18.0"
        },
        "ajaxurl": "https:\/\/<?php echo $cleanurl; ?>\/wp-admin\/admin-ajax.php",
        "rtl": "",
        "sticky_height": "70",
        "stickyHeaderHeight": "0",
        "scrollPaddingTop": "0",
        "assets_url": "https:\/\/<?php echo $cleanurl; ?>\/wp-content\/themes/\<?php echo get_stylesheet(); ?>\/wwlp-assets\/",
        "lightbox": {
            "close_markup": "<button title=\"%title%\" type=\"button\" class=\"mfp-close\"><svg xmlns=\"http:\/\/www.w3.org\/2000\/svg\" width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-x\"><line x1=\"18\" y1=\"6\" x2=\"6\" y2=\"18\"><\/line><line x1=\"6\" y1=\"6\" x2=\"18\" y2=\"18\"><\/line><\/svg><\/button>",
            "close_btn_inside": false
        },
        "user": {
            "can_edit_pages": false
        },
        "i18n": {
            "mainMenu": "Main Menu",
            "toggleButton": "Toggle"
        },
        "options": {
            "cookie_notice_version": "1",
            "swatches_layout": false,
            "swatches_disable_deselect": false,
            "swatches_box_select_event": false,
            "swatches_box_behavior_selected": false,
            "swatches_box_update_urls": "1",
            "swatches_box_reset": false,
            "swatches_box_reset_limited": false,
            "swatches_box_reset_extent": false,
            "swatches_box_reset_time": 300,
            "search_result_latency": "0"
        },
        "is_mini_cart_reveal": "1"
    };
    /* ]]> */
    </script>
    <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/wwlp-assets/js/flatsome.js?ver=039f9485eef603e7c53a" id="flatsome-js-js"></script> 
    <script type="text/javascript" src="<?php echo get_site_url(); ?>/wp-includes/js/dist/vendor/wp-polyfill-inert.min.js?ver=3.1.2" id="wp-polyfill-inert-js"></script>
    <script type="text/javascript" src="<?php echo get_site_url(); ?>/wp-includes/js/dist/vendor/regenerator-runtime.min.js?ver=0.14.0" id="regenerator-runtime-js"></script>
    <script type="text/javascript" src="<?php echo get_site_url(); ?>/wp-includes/js/dist/vendor/wp-polyfill.min.js?ver=3.15.0" id="wp-polyfill-js"></script>
    <script type="text/javascript" src="<?php echo get_site_url(); ?>/wp-includes/js/dist/hooks.min.js?ver=c6aec9a8d4e5a5d543a1" id="wp-hooks-js"></script>
    <script type="text/javascript" src="<?php echo get_site_url(); ?>/wp-includes/js/dist/i18n.min.js?ver=7701b0c3857f914212ef" id="wp-i18n-js"></script>
    <script type="text/javascript" id="wp-i18n-js-after">
    /* <![CDATA[ */
    wp.i18n.setLocaleData({
        'text direction\u0004ltr': ['ltr']
    });
    /* ]]> */
    </script>

</body>
</html>


