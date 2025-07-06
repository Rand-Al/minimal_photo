<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php wp_head(); ?>
    <?php if (is_front_page()) : ?>
        <style>
            :root {
                --hero-bg: url('<?php
                                $hero_bg = CFS()->get('hero_background');
                                echo $hero_bg ? esc_url($hero_bg) : get_template_directory_uri() . '/assets/images/hero.jpg';
                                ?>');
            }
        </style>
    <?php endif; ?>
</head>


<body <?php body_class('body'); ?>>
    <?php wp_body_open(); ?>
    <div class="container container--main">
        <header class="header <?= !is_front_page() ? 'header-shadow' : '' ?>">
            <div class="header__inner">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo img-ibg img-ibg--logo">
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    if ($custom_logo_id) {
                        $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
                        echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '">';
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/assets/images/logo-portfolio.webp" alt="' . esc_attr(get_bloginfo('name')) . '">';
                    }
                    ?>
                </a>
                <button
                    type="button"
                    class="burger"
                    aria-controls="primary-navigation"
                    aria-expanded="false"
                    aria-label="Toggle menu">
                    <span class="burger__line"></span>
                    <span class="burger__line"></span>
                    <span class="burger__line"></span>
                </button>

                <nav class="nav" id="primary-navigation">
                    <?php wp_nav_menu(array(
                        'theme_location' => 'header-menu',
                        'menu_class' => 'nav__list',
                        'container' => false,
                        'walker' => new Custom_Nav_Walker(),
                        'fallback_cb' => false,
                    )); ?>

                </nav>
            </div>
        </header>
