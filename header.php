<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php bloginfo('description'); ?>" />
	<link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class('site'); ?>>
    <div class="site__header">
        <header class="header">
            <a href="<?php echo get_home_url(); ?>" class="header__logo">
			    <?php include "img/logo.svg"; ?>
            </a>

		    <?php $header_menu_items = dreams_get_menu_items('header-menu'); ?>
		    <?php if ($header_menu_items): ?>
                <nav class="top-stories">
                    <ul class="top-stories__list">
					    <?php foreach ($header_menu_items as $header_menu_item): ?>
                            <li class="top-stories__item">
                                <div class="top-stories__category">
								    <?php $header_menu_item_id = get_post_meta($header_menu_item->ID, '_menu_item_object_id', true); ?>
								    <?php echo get_the_category($header_menu_item_id)[0]->name; ?>
                                </div>
                                <a class="top-stories__link" href="<?php echo $header_menu_item->url ?>">
								    <?php echo $header_menu_item->title ?>
                                </a>
                            </li>
					    <?php endforeach ?>
                    </ul>
                </nav>
		    <?php endif ?>
            <div class="header__tools">
                <label for="sidebar__control" class="header__icon">
		            <?php include "img/menu.svg"; ?>
                </label>
                <a href="#search" class="header__icon">
		            <?php include "img/search.svg"; ?>
                </a>
            </div>
        </header>
    </div>

    <input type="checkbox" class="sidebar__control" id="sidebar__control" />
    <nav class="sidebar">
        <label for="sidebar__control" class="sidebar__close">
		    <?php include "img/cross.svg"; ?>
        </label>
	    <?php wp_nav_menu(['theme_location' => 'nav-menu', 'menu_class' => 'sidebar__menu']); ?>
    </nav>

