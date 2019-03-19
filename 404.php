<?php get_header(); ?>

<div class="site__error">
    <div class="error404__container">
        <div class="error404__number">404</div>
        <div class="error404__title">Ops, cagada</div>
        <div class="error404__text">
            <p>El artículo que estás buscando aún no está escrito.
                Pero tranquilo, nuestro ejercito de infinitos monos
                con infinitas máquinas de escribir no tardará
                mucho en redactarlo.</p>
            <p>Mientras tanto, deberías volver a la <a class="error404__link" href="<?php home_url() ?>">portada</a>, ¿no?.</p>
        </div>
        <img class="error404_image" src="<?php echo get_template_directory_uri() ?>/img/slowpoke.gif" alt="slowpoke.gif" title="404 - Ops, cagada" />
    </div>
</div>

</body>
</html>