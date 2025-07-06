<?php

/**
 * Главный шаблон темы
 */
get_header(); ?>
<main class="main">
    <?php if (is_front_page()) : ?>
        <section class="hero">
            <div class="hero__body">
                <h1 class="hero__title">
                    <?php
                    $title = CFS()->get('hero_title');
                    echo esc_html(CFS()->get('hero_title') ?: 'Photography')
                    ?>
                </h1>
                <p class="hero__subtitle">
                    <?php
                    $subtitle = CFS()->get('hero_title');
                    echo esc_html(CFS()->get('hero_subtitle') ?: 'Capturing moment, telling stories')
                    ?>
                </p>
            </div>
        </section>
        <section class="portfolio" id="portfolio">
            <h2 class="portfolio__title title">
                <?php
                $portfolio_title = CFS()->get('portfolio_title');
                echo esc_html($portfolio_title ?: 'Portfolio');
                ?>
            </h2>
            <div class="portfolio__body body-portfolio">
                <?php
                $portfolio_photos = CFS()->get('photos');
                if (!empty($portfolio_photos)) :
                    foreach ($portfolio_photos as $item) :
                        $image_url = $item['portfolio_image'];
                        $image_alt = $item['portfolio_image_alt'];
                        if (!empty($image_url)) :
                ?>
                            <div class="body-potfolio__item item-body-portfolio img-ibg">
                                <img
                                    class="item-body-potfolio__img"
                                    src="<?php echo esc_url($image_url); ?>"
                                    alt="<?php echo esc_attr($image_alt ?: 'Portfolio image'); ?>" />
                            </div>
                <?php
                        endif;
                    endforeach;
                endif;
                ?>
            </div>
            <div class="portfolio__button ">
                <button class="button button--transparent">Показать еще</button>
            </div>
        </section>
        <section class="main-bottom">
            <section class="about" id="about">
                <h2 class="about__title title">About</h2>
                <p class="about__text text">
                    Hi! I’m a freelance photographer with a deep love
                    for capturing real emotions, unique moments, and the
                    beauty hidden in everyday life. Through my lens, I
                    tell stories — whether it’s a quiet glance, a wide
                    smile, or the dramatic play of light and shadow. My
                    style blends artistic vision with technical
                    precision, creating images that feel authentic and
                    timeless. I work across different genres, including
                    portrait, lifestyle, event, and editorial
                    photography. Based in Kyiv, I’m available for both
                    local and destination shoots. Let’s create something
                    meaningful together — images that will last a
                    lifetime
                </p>
            </section>

            <section class="contact" id="contact">
                <h2 class="title">Contact</h2>
                <p class="text">
                    Ready to capture your moments? Get in touch with me.
                </p>
                <button class="button">Send Message</button>
            </section>
        </section>
    <?php endif; ?>

</main>
<?php
get_footer();
