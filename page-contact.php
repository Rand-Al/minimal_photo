<?php

/**
 * Template Name: Contact Page
 */

get_header(); ?>
<main class="main">
    <div class="container-contact">
        <h1 class="title--page title title--contact">
            <?php
            $title = CFS()->get('contact_page_title');
            echo esc_html($title) ?: 'Contact';
            ?>

        </h1>

        <section class="contact-section">
            <h2 class="section-title">
                <?php
                $section_title = CFS()->get('contact_page_section_title');
                echo esc_html($section_title) ?: 'Get in touch with me'
                ?>
            </h2>
            <p class="section-description">
                <?php
                $section_subtitle = CFS()->get('contact_page_section_subtitle');
                echo esc_html($section_subtitle) ?: 'Fill out the form below, and I will contact you
                    as soon as possible.'
                ?>
            </p>
            <?php echo do_shortcode('[contact-form-7 id="f1a66bd" title="Форма"]') ?>
            <div class="contact-info">
                <div class="contact-item">
                    <svg
                        class="contact-icon"
                        viewBox="0 0 24 24">
                        <path
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <?php $email = CFS()->get('contact_page_email') ?: 'sergiivaschenko@gmail.com' ?>
                    <a
                        href="mailto:<?php echo esc_attr($email) ?>"
                        class="contact-link">
                        <?php echo esc_html($email) ?>
                    </a>
                </div>

                <div class="contact-item">
                    <svg
                        class="contact-icon"
                        viewBox="0 0 24 24">
                        <path
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <?php
                    $tel = CFS()->get('contact_page_tel') ?: '380503434345';
                    $formatted_tel = format_phone_number($tel)
                    ?>
                    <a
                        href="tel:<?php echo esc_attr($tel) ?>"
                        class="contact-link">
                        <?php echo esc_html($formatted_tel) ?>
                    </a>
                </div>

                <div class="contact-item">
                    <svg
                        class="contact-icon"
                        viewBox="0 0 24 24">
                        <path
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="contact-text">
                        <?php
                        $position = CFS()->get('contact_page_position') ?: 'Kyiv, Ukraine';
                        echo esc_html($position)
                        ?>
                    </span>
                </div>
            </div>
        </section>
    </div>
</main>
<?php
get_footer();
