<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Обработчик AJAX запросов для получения отфильтрованных элементов портфолио
 * 
 * Эта функция принимает параметры фильтрации (категория, страница) и возвращает
 * соответствующие элементы портфолио в формате JSON для обработки JavaScript'ом
 */
function get_filtered_portfolio_items() {
    // Проверяем nonce для безопасности AJAX запросов
    // Это защищает от подделки межсайтовых запросов (CSRF атак)
    if (!wp_verify_nonce($_POST['nonce'], 'portfolio_nonce')) {
        wp_die('Ошибка безопасности');
    }

    // Получаем параметры запроса и очищаем их для безопасности
    $category = sanitize_text_field($_POST['category']);
    $page = intval($_POST['page']); // Номер страницы для пагинации
    $posts_per_page = 6; // Количество элементов за один запрос

    // Формируем параметры запроса к базе данных WordPress
    $args = array(
        'post_type' => 'portfolio_item',        // Наш кастомный тип записи
        'post_status' => 'publish',             // Только опубликованные элементы
        'posts_per_page' => $posts_per_page,    // Ограничение количества
        'paged' => $page,                       // Номер страницы для пагинации
        'orderby' => 'date',                    // Сортировка по дате создания
        'order' => 'DESC'                       // Новые элементы первыми
    );

    // Если выбрана конкретная категория (не "all"), добавляем фильтр по таксономии
    if ($category !== 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'slug',
                'terms' => $category,
            ),
        );
    }

    // Выполняем запрос к базе данных
    $portfolio_query = new WP_Query($args);

    // Подготавливаем массив данных для отправки в JSON формате
    $portfolio_items = array();

    if ($portfolio_query->have_posts()) {
        while ($portfolio_query->have_posts()) {
            $portfolio_query->the_post();

            // Получаем данные изображения записи в разных размерах
            $thumbnail_id = get_post_thumbnail_id();
            $image_data = array();

            if ($thumbnail_id) {
                // Получаем разные размеры изображения для оптимизации загрузки
                $image_data = array(
                    'thumbnail' => wp_get_attachment_image_src($thumbnail_id, 'medium')[0],
                    'full' => wp_get_attachment_image_src($thumbnail_id, 'full')[0],
                    'alt' => get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true)
                );
            }

            // Получаем категории элемента портфолио
            $categories = get_the_terms(get_the_ID(), 'portfolio_category');
            $category_names = array();
            if ($categories && !is_wp_error($categories)) {
                foreach ($categories as $cat) {
                    $category_names[] = $cat->name;
                }
            }

            // Формируем данные элемента для отправки в JavaScript
            $portfolio_items[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'content' => get_the_content(),
                'image' => $image_data,
                'categories' => $category_names,
                'date' => get_the_date()
            );
        }
        wp_reset_postdata(); // Важно восстановить глобальные данные поста
    }

    // Определяем, есть ли еще элементы для загрузки
    $has_more = ($portfolio_query->max_num_pages > $page);

    // Отправляем ответ в JSON формате
    wp_send_json_success(array(
        'items' => $portfolio_items,
        'has_more' => $has_more,
        'current_page' => $page,
        'total_pages' => $portfolio_query->max_num_pages
    ));
}

// Регистрируем AJAX обработчики для авторизованных и неавторизованных пользователей
// wp_ajax_ для авторизованных пользователей (админов)
add_action('wp_ajax_get_portfolio_items', 'get_filtered_portfolio_items');
// wp_ajax_nopriv_ для неавторизованных посетителей сайта
add_action('wp_ajax_nopriv_get_portfolio_items', 'get_filtered_portfolio_items');

/**
 * Функция для генерации nonce токена безопасности
 * 
 * Этот токен будет использоваться JavaScript'ом для подтверждения
 * легитимности AJAX запросов
 */
function portfolio_localize_script() {
    // Проверяем, что мы находимся на странице портфолио
    if (is_page_template('page-portfolio.php') || is_page('portfolio')) {
        wp_localize_script('jquery', 'portfolio_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('portfolio_nonce')
        ));
    }
}
add_action('wp_enqueue_scripts', 'portfolio_localize_script');
