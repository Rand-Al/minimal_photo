<?php

// Подключение файлов PHP
require_once get_template_directory() . '/inc/class-nav-walker.php';
require_once get_template_directory() . '/inc/class-footer-nav-walker.php';

// Подключение стилей и скриптов
function theme_enqueue_scripts() {
    wp_enqueue_style('theme-style', get_stylesheet_uri());
    wp_enqueue_style('theme-main', get_template_directory_uri() . '/assets/css/index-DU-3155z.css');
    wp_enqueue_script('theme-main', get_template_directory_uri() . '/assets/js/index-Dtawep0w.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

// Поддержка функций темы
function theme_setup() {
    // Поддержка пользовательского логотипа
    add_theme_support('custom-logo');

    // Поддержка меню
    register_nav_menus(array(
        'header-menu' => 'Основное меню',
        'footer-menu' => 'Меню футера'
    ));

    // Поддержка заголовка документа
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'theme_setup');
