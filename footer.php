    <div class="site__footer">
        <footer class="footer">
            <div class="footer_left">
                <div class="footer__logo"><?php include "img/logo.svg"; ?></div>
                <div class="footer__legal">
		            <?php wp_nav_menu(['theme_location' => 'legal-menu', 'menu_class' => 'footer__legal-links']); ?>
                </div>
            </div>
            <div class="footer__menu">
		        <?php wp_nav_menu(['theme_location' => 'footer-menu', 'menu_class' => 'footer__menu-links']); ?>
            </div>
            <a class="footer__back-to-top" href="#top">Volver arriba ↑</a>
        </footer>
    </div>
    <?php wp_footer(); ?>

</body>
</html>
