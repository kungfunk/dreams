    <div class="site__footer">
        <footer class="footer">
            <div class="footer__logo"><?php include "img/logo.svg"; ?></div>
            <div class="footer__menu">
			    <?php wp_nav_menu(['theme_location' => 'footer-menu']); ?>
            </div>
            <div class="footer__legal">
			    <?php wp_nav_menu(['theme_location' => 'legal-menu']); ?>
            </div>
            <a class="footer__back-to-top" href="#top">Volver arriba ↑</a>
        </footer>
    </div>
    <?php wp_footer(); ?>

</body>
</html>
