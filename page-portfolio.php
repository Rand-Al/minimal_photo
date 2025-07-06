<?php

/**
 * Template Name: Portfolio Page
 */

get_header(); ?>

<main class="main">
    <div class="container">
        <section class="portfolio-page">
            <h2 class="title title--page portfolio-page__title">
                <?php
                $title = CFS()->get('portfolio_page_title');
                echo esc_html($title) ?: 'Portfolio';
                ?>
            </h2>
            <div class="portfolio-categories" id="portfolio-filters">
                <button class="portfolio-categories__item active-category"
                    data-category="all">
                    All Works
                </button>
                <?php
                // Получаем все категории портфолио для создания кнопок фильтрации
                $categories = get_terms(array(
                    'taxonomy' => 'portfolio_category',
                    'hide_empty' => true, // Показывать только категории с контентом
                ));

                // Проверяем, что категории существуют и нет ошибок
                if ($categories && !is_wp_error($categories)) {
                    foreach ($categories as $category) {
                        printf(
                            '<button class="portfolio-categories__item" data-category="%s">%s</button>',
                            esc_attr($category->slug),
                            esc_html($category->name)
                        );
                    }
                }
                ?>
            </div>

            <!-- Контейнер для галереи изображений -->
            <div class="portfolio-page__body body-portfolio-page" id="portfolio-grid">
                <!-- Сюда будут загружаться изображения через AJAX -->
            </div>

            <!-- Индикатор загрузки -->
            <div class="portfolio-loading" id="portfolio-loading" style="display: none;">
                <p>Загрузка...</p>
            </div>

            <!-- Кнопка "Загрузить еще" -->
            <div class="portfolio-page__button">
                <button class="button button--transparent" id="load-more-portfolio" style="display: none;">
                    Load More
                </button>
            </div>
        </section>
</main>

<!-- Модальное окно для просмотра изображений -->
<div class="portfolio-modal" id="portfolio-modal" style="display: none;">
    <div class="portfolio-modal__overlay" id="modal-overlay"></div>
    <div class="portfolio-modal__content">
        <button class="portfolio-modal__close" id="modal-close">&times;</button>
        <img class="portfolio-modal__image" id="modal-image" src="" alt="">
        <div class="portfolio-modal__info">
            <h3 class="portfolio-modal__title" id="modal-title"></h3>
            <p class="portfolio-modal__description" id="modal-description"></p>
        </div>
    </div>
</div>


<?php get_footer(); ?>
