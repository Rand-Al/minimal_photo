<?php

/**
 * Регистрация кастомных таксономий
 * 
 * Этот файл управляет всеми системами категоризации и тегирования
 * специализированного контента
 */

// Защита от прямого доступа
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Регистрация таксономии для категорий портфолио
 * 
 * Позволяет группировать фотографии по типам съемки:
 * свадебные, портретные, пейзажные и другие категории
 */
function register_portfolio_category_taxonomy() {
    $labels = array(
        'name'              => 'Категории портфолио',
        'singular_name'     => 'Категория портфолио',
        'menu_name'         => 'Категории',
        'all_items'         => 'Все категории',
        'edit_item'         => 'Редактировать категорию',
        'view_item'         => 'Посмотреть категорию',
        'update_item'       => 'Обновить категорию',
        'add_new_item'      => 'Добавить новую категорию',
        'new_item_name'     => 'Название новой категории',
        'search_items'      => 'Искать категории',
    );

    $args = array(
        'labels'            => $labels,
        'hierarchical'      => false,              // Плоская структура для простоты фильтрации
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,               // Показать колонку в списке элементов портфолио
        'show_in_nav_menus' => true,
        'show_in_rest'      => true,               // Обязательно для AJAX фильтрации
        'show_tagcloud'     => false,
        'rewrite'           => array(
            'slug' => 'portfolio-category',
        ),
    );

    // Связываем таксономию с нашим кастомным типом записи
    register_taxonomy('portfolio_category', 'portfolio_item', $args);
}

add_action('init', 'register_portfolio_category_taxonomy');
