<?php

// Подключение файлов PHP
require_once get_template_directory() . '/inc/class-nav-walker.php';
require_once get_template_directory() . '/inc/class-footer-nav-walker.php';
require_once get_template_directory() . '/inc/portfolio_page/post-types.php';
require_once get_template_directory() . '/inc/portfolio_page/taxonomies.php';
require_once get_template_directory() . '/inc/portfolio_page/ajax-handlers.php';

// Подключение стилей и скриптов
function theme_enqueue_scripts() {
    wp_enqueue_style('theme-style', get_stylesheet_uri());
    wp_enqueue_style('theme-main-style', get_template_directory_uri() . '/assets/css/index-DU-3155z.css');
    wp_enqueue_style('portfolio-modal-style', get_template_directory_uri() . '/assets/css/portfolio_modal.css');
    wp_enqueue_script('theme-main', get_template_directory_uri() . '/assets/js/index-Dtawep0w.js', array(), '1.0.0', true);
    wp_enqueue_script('portfolio-js', get_template_directory_uri() . '/assets/js/portfolio/portfolio.js', array(), '1.0', true);
    wp_localize_script('portfolio-js', 'portfolio_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),  // URL для отправки AJAX запросов
        'nonce' => wp_create_nonce('portfolio_nonce') // Токен безопасности
    ));
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

// Поддержка функций темы
function theme_setup() {
    // Поддержка пользовательского логотипа
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');

    // Поддержка меню
    register_nav_menus(array(
        'header-menu' => 'Основное меню',
        'footer-menu' => 'Меню футера'
    ));

    // Поддержка заголовка документа
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'theme_setup');
