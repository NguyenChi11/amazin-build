<?php
$logo_id = get_theme_mod('header_logo', 0);
$text_header = get_theme_mod('buildpro_header_title', '');
if ($text_header === '') {
    $text_header = get_theme_mod('header_text', '');
}
if (is_scalar($text_header)) {
    $text_header = trim((string)$text_header);
    if ($text_header === '' || $text_header === '0' || $text_header === '1') {
        $text_header = '';
    }
} else {
    $text_header = '';
}
$description_header = get_theme_mod('buildpro_header_description', '');
if ($description_header === '') {
    $description_header = get_theme_mod('header_description', '');
}
?>

<header id="masthead" class="site-header">
    <div class="site-branding">
        <div class="header-logo-container">
            <?php if (is_customize_preview()): ?>
            <div class="header__hover-outline"></div>

            <script>
            (function() {
                var btn = document.querySelector('.header__customize-button');
                if (btn && window.parent && window.parent.wp && window.parent.wp.customize) {
                    btn.addEventListener('click', function() {
                        window.parent.wp.customize.section('buildpro_header_section').focus();
                    });
                }
            })();
            </script>
            <?php endif; ?>
            <a href="/" class="header-logo">
                <?= $logo_id ? wp_get_attachment_image($logo_id, 'full', false, array('class' => '')) : '<img src="' . esc_url(get_theme_file_uri('/assets/images/logo.png')) . '" alt="Logo" />' ?>
            </a>
            <h1 class="header-logo-text">
                <?= $text_header ? esc_html($text_header) : '' ?>
            </h1>
            <p class="header-logo-desc">
                <?= $description_header ? esc_html($description_header) : '' ?>
            </p>
        </div>
        <div class="header-nav-container">

            <div class="header-nav-main">
                <?php if (is_customize_preview()): ?>
                <div class="header__hover-outline"></div>

                <script>
                (function() {
                    var btn = document.currentScript && document.currentScript.previousElementSibling;
                    if (btn && window.parent && window.parent.wp && window.parent.wp.customize) {
                        btn.addEventListener('click', function() {
                            window.parent.wp.customize.section('buildpro_header_section').focus();
                        });
                    }
                })();
                </script>
                <?php endif; ?>
                <nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-1',
                            'menu_id'        => 'primary-menu',
                        )
                    );
                    ?>
                </nav><!-- #site-navigation -->
            </div>
            <div class="header-nav-button-container">
                <a href="#" class="header-nav-button">
                    <p>Request a Quote</p>
                </a>
            </div>
        </div>
        <button class="mobile-menu-toggle" aria-expanded="false" aria-controls="mobile-sidebar">
            <span>Menu</span>
        </button>
    </div>

    <div id="mobile-sidebar" class="mobile-sidebar">
        <div class="mobile-sidebar-header">
            <button class="mobile-sidebar-close" aria-label="Close Menu">✕</button>
        </div>
        <div class="header-mobile-nav">
            <?php if (is_customize_preview()): ?>
            <div class="header__hover-outline"></div>

            <script>
            (function() {
                var btn = document.currentScript && document.currentScript.previousElementSibling;
                if (btn && window.parent && window.parent.wp && window.parent.wp.customize) {
                    btn.addEventListener('click', function() {
                        window.parent.wp.customize.section('buildpro_header_section').focus();
                    });
                }
            })();
            </script>
            <?php endif; ?>
            <nav class="mobile-navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'mobile-primary-menu',
                    )
                );
                ?>
            </nav>
        </div>
        <div class="mobile-sidebar-actions">
            <a href="#" class="header-nav-button">
                <p>Request a Quote</p>
            </a>
        </div>
    </div>
    <div class="mobile-sidebar-backdrop"></div>
</header><!-- #masthead -->
<?php if (is_customize_preview()) : ?>
<script>
(function() {
    var api = window.parent && window.parent.wp && window.parent.wp.customize;
    var currentPageId = <?php echo (int) get_queried_object_id(); ?>;
    var cfg = {
        frontId: <?php echo (int) get_option('page_on_front'); ?>,
        homeIds: <?php
                            $home_pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'home-page.php', 'number' => 50));
                            $home_ids = array();
                            foreach ($home_pages as $hp) {
                                $home_ids[] = (int) $hp->ID;
                            }
                            echo wp_json_encode($home_ids);
                            ?>
    };

    function appendCS(url) {
        try {
            var uuid = api && api.settings && api.settings.changeset && api.settings.changeset.uuid;
            if (!uuid) return url;
            var u = new URL(url, window.location.origin);
            if (!u.searchParams.get('customize_changeset_uuid')) {
                u.searchParams.set('customize_changeset_uuid', uuid);
            }
            return u.toString();
        } catch (e) {
            return url;
        }
    }

    function isHome(id) {
        id = parseInt(id || 0, 10);
        if (!id) return false;
        return (cfg.frontId && id === cfg.frontId) || (Array.isArray(cfg.homeIds) && cfg.homeIds.indexOf(id) > -1);
    }

    function focusSectionById(id) {
        try {
            if (!api || !api.section) return;
            var target = isHome(id) ? 'buildpro_banner_section' : 'buildpro_header_section';
            var s = api.section(target);
            if (s && s.focus) {
                s.focus();
            }
        } catch (e) {}
    }

    function bindHeaderOutlines() {
        var nodes = document.querySelectorAll('.header__hover-outline');
        for (var i = 0; i < nodes.length; i++) {
            nodes[i].addEventListener('click', function() {
                try {
                    if (api) {
                        var setting = api('buildpro_preview_page_id');
                        if (setting && typeof setting.set === 'function') {
                            setting.set(currentPageId);
                        }
                        focusSectionById(currentPageId);
                    }
                } catch (e) {}
            });
        }
    }

    function bindMenuLinks() {
        var links = document.querySelectorAll('.main-navigation a, .mobile-navigation a');
        for (var j = 0; j < links.length; j++) {
            links[j].addEventListener('click', function(ev) {
                try {
                    if (!api) return;
                    var href = this.getAttribute('href') || '';
                    var objId = this.getAttribute('data-object-id') || '0';
                    objId = parseInt(objId || 0, 10);
                    if (href) {
                        var url = appendCS(href);
                        var did = false;
                        if (api.previewer) {
                            if (api.previewer.previewUrl && typeof api.previewer.previewUrl.set ===
                                'function') {
                                api.previewer.previewUrl.set(url);
                                did = true;
                            } else if (typeof api.previewer.previewUrl === 'function') {
                                api.previewer.previewUrl(url);
                                did = true;
                            } else if (api.previewer.url && typeof api.previewer.url.set === 'function') {
                                api.previewer.url.set(url);
                                did = true;
                            }
                            if (!did) {
                                var frame = window.parent && window.parent.document && window.parent
                                    .document.querySelector('#customize-preview iframe');
                                if (frame) {
                                    frame.src = url;
                                    did = true;
                                }
                            }
                            if (did) {
                                setTimeout(function() {
                                    try {
                                        if (api.previewer.refresh) {
                                            api.previewer.refresh();
                                        }
                                    } catch (e) {}
                                }, 100);
                            }
                        }
                        if (objId > 0) {
                            var setting = api('buildpro_preview_page_id');
                            if (setting && typeof setting.set === 'function') {
                                setting.set(objId);
                            }
                            focusSectionById(objId);
                        } else {
                            focusSectionById(0);
                        }
                        ev.preventDefault();
                    }
                } catch (e) {}
            });
        }
    }

    function init() {
        bindHeaderOutlines();
        bindMenuLinks();
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
<?php endif; ?>
<?php if (!$logo_id || !$text_header || !$description_header) : ?>
<script src="<?= esc_url(get_theme_file_uri('/assets/data/header-data.js')); ?>"></script>
<script>
(function() {
    var data = window.headerData || {};
    <?php if (!$logo_id): ?>
    var imgEl = document.querySelector('.header-logo img');
    if (imgEl && data.logo) {
        imgEl.src = data.logo;
    }
    <?php endif; ?>
    <?php if (!$text_header): ?>
    var titleEl = document.querySelector('.header-logo-text');
    if (titleEl && data.title) {
        titleEl.textContent = data.title;
    }
    <?php endif; ?>
    <?php if (!$description_header): ?>
    var descEl = document.querySelector('.header-logo-desc');
    if (descEl && data.description) {
        descEl.textContent = data.description;
    }
    <?php endif; ?>
})();
</script>
<?php endif; ?>