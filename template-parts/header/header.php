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