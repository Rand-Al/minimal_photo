<?php
// Защита от прямого доступа
if (!defined('ABSPATH')) {
    exit;
}

class Custom_Nav_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="nav__list">';
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $output .= '<li class="nav__item">';
        $output .= '<a href="' . esc_url($item->url) . '" class="nav__link">' . esc_html($item->title) . '</a>';
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</ul>';
    }
}
