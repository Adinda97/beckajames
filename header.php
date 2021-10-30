<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Webdesignhq
 * @since 1.0.0
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>

    <link href="<?php echo get_template_directory_uri(); ?>/css/foundation.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>	
	<?php wp_head(); ?>	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen,projection" />
</head>

<body>
<!--<div class="mobile__menu--container d-lg-none d-block">
	<div class="relative">
		<nav id="mobile-site-navigation" class="main-navigation absolute d-block d-lg-none">
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav>
	</div>
</div>
<div class="mobile__search--container d-lg-none d-block">
	<div class="col-8 mx-auto">
		<?php echo do_shortcode('[fibosearch]'); ?>
	</div>	
</div>
<div class="mini-cart__container">
</div>
<div class="mini-cart-container">
	<div class="widget_shopping_cart_content col-4">
			<?php woocommerce_mini_cart(); ?>
	</div>
</div>
<div class="mini-account-container p-5">
<?php
	if ( ! is_user_logged_in() ) {
		wp_login_form( array( 'redirect' => home_url( 'mijn-account' ) ) );
	}else{
	 echo wp_login_form();
	 } ?>
</div> -->
<header>
	<div id="topheader">
		<div class="row large">
				<?php
					$usplist = get_field('upslist', 'option');
					if($usplist)
					{
						echo '<ul class="row">';

						foreach($usplist as $uspitem)
						{ ?>
						<div class="columns large-3 medium-6 small-6" style="padding: 0 20px;">
							<div class="row align-middle uspitem">
								<div class="columns large-4">
									<img src="<?php echo $uspitem['usp_icon'] ?>">
								</div>
								<div class="columns large-8 uspitem-text">
									<p><?php echo $uspitem['usp_name'] ?> </p>
								</div>
							</div>
						</div>
					<?php }

						echo '</ul>';
					}
				?>
		</div>
	</div>
	<div id="header">
		<div class="row large align-middle">
			<div class="large-2 columns">
				<?php if ( function_exists( 'the_custom_logo' ) ) {
						 the_custom_logo();
					} ?>
			</div>
			<div class="large-5 columns">
				<button class="menu-toggle btn pt-3" type="btn" onclick=""><i class="fas fa-bars"></i></button>
					<nav id="site-navigation" class="main-navigation d-none d-lg-block">
						<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
					</nav>
			</div>
			<div class="search large-2 columns">
				<?php echo do_shortcode('[fibosearch]'); ?>
			</div>
			<div class="shop__controls large-2 columns">
				<?php if ( ! is_user_logged_in() ) { ?>
					<a href="#" class="mx-lg-3 mx-2 my-account-btn"><i class="fas fa-user"></i></a>
				<?php } else { ?>
					<a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>" class="mx-lg-3 mx-2"><i class="fas fa-user"></i></a>
				<?php } ?>
				<!-- <?php echo do_shortcode("[woo_cart_but]"); ?> -->
				<a class="mini-cart" href="#"><i class="fas fa-shopping-basket"></i></a>
			</div>
		</div>
	</div>
</header>
		<?php if(!is_front_page() && (!is_product_category () && (!is_shop()) && (!is_product() && (!is_cart() && (!is_checkout()))))) { ?>
		<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
		
		<div id="bannerindex" style="background: url('<?php echo $backgroundImg[0]; ?>') no-repeat; background-size: cover;">
		<div class="container-xxl d-flex flex-column justify-content-center h-100">
			<div class="row justify-content-center">
					<div class="col-md-8 text-center">
						<div class="bannerindexcontent text-left p-4">
							<h1 class="header__title"><?php echo get_the_title(); ?></h1>
						</div>
						<p class="header__breadcrumb"><?php woocommerce_breadcrumb(); ?></p>
					</div>
				</div>
		</div>
	</div>
	<?php } elseif(is_product_category() || (is_product())) {?>
		
		<?php 
			global $wp_query;
			$cat = $wp_query->get_queried_object();
			$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true ); 
	
			
			if ( is_product_category() ){
			$image = wp_get_attachment_url( $thumbnail_id ); 
			$title = single_term_title( "", false );
			}else{
	
				$image = get_field('cover_image');
				$title = get_the_title();
			} ?>
				<div id="bannerindex" style="background: url(<?php echo $image ?> ) no-repeat; background-size: cover; background-position: center;">
						<div class="row justify-content-center">
							<div class="large-12 text-center">
								<div class="bannerindexcontent text-left p-4">
									<h1 class="header__title"><?php echo $title ?></h1>
								</div>
								<p class="header__breadcrumb"><?php woocommerce_breadcrumb(); ?></p>
							</div>
						</div>
				</div>

	<?php } elseif(is_shop()) {?>
		<div id="bannerindex" style="background: url('http://localhost/BeckaJames/wp-content/uploads/2021/10/mael-renault-wnTPrqKEysI-unsplash.jpg') no-repeat; background-size: cover;">
			<div class="row full">
				<div class="large-6 text-center">
					<h1 class="header__title">Assortiment</h1>
					<p><?php woocommerce_breadcrumb(); ?></p>
				</div>
			</div>
		</div>
	<?php } ?>