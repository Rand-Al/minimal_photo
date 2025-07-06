<?php

if (!defined('ABSPATH')) {
    exit;
}


function register_portfolio_item_post_type() {
    $labels = array(
        'name'               => 'Портфолио',
        'singular_name'      => 'Элемент портфолио',
        'menu_name'          => 'Портфолио',
        'add_new'            => 'Добавить фото',
        'add_new_item'       => 'Добавить новое фото',
        'edit_item'          => 'Редактировать фото',
        'new_item'           => 'Новое фото',
        'view_item'          => 'Посмотреть фото',
        'search_items'       => 'Искать в портфолио',
        'not_found'          => 'Фотографии не найдены',
        'not_found_in_trash' => 'В корзине ничего не найдено',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,              // Критически важно для Gutenberg
        'query_var'          => true,
        'rewrite'            => array('slug' => 'portfolio-item'),
        'capability_type'    => 'post',
        'has_archive'        => 'portfolio-archive',
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-camera',
        'supports'           => array(
            'title',           // Заголовок элемента портфолио
            'editor',          // Описание и дополнительный контент
            'thumbnail',       // ОСНОВНОЕ: поддержка featured image   
            'revisions',       // Ревизии для отслеживания изменений
        ),
        // Дополнительные настройки для полной совместимости с Gutenberg
        'show_in_admin_bar'   => true,             // Показывать в админ-баре
        'can_export'          => true,             // Можно экспортировать
        'exclude_from_search' => false,            // Включать в поиск по сайту
        'map_meta_cap'        => true,             // Использовать стандартные права доступа
    );

    register_post_type('portfolio_item', $args);
}


add_action('init', 'register_portfolio_item_post_type');
