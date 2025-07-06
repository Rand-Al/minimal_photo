<footer class="footer">
    <div class="container">
        <div class="footer__content">
            <div class="footer__copyright">
                © <?php echo date('Y'); ?> All rights reserved
            </div>
            <nav class="footer__nav">
                <?php wp_nav_menu(array(
                    'theme_location' => 'footer-menu',
                    'menu_class' => 'footer__list',
                    'container' => false,
                    'walker' => new Custom_Footer_Nav_Walker(),
                    'fallback_cb' => false,
                )); ?>
            </nav>
        </div>
    </div>
</footer>
</div>
<button
    class="scroll-to-top"
    id="scrollToTop"
    aria-label="Scroll to top">
    <svg
        class="scroll-to-top__icon"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round">
        <polyline points="18 15 12 9 6 15"></polyline>
    </svg>
</button>
</div>
<?php wp_footer() ?>
</body>

</html>
