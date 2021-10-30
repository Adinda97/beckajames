<?php 

if ( ! function_exists( 'website_setup' ) ) :
/**
* Sets up theme defaults and registers support for various WordPress features
*
*  It is important to set up these functions before the init hook so that none of these
*  features are lost.
*
*  @since MyFirstTheme 1.0
*/
function website_setup() 
{ 
	
	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'website' ),
		'secondary' => __( 'Secondary Menu', 'website' ),
		'footer_moreinfo' => __( 'Footer Meer informatie', 'website' ),
		'footer_customerservice' => __( 'Footer Klantenservice', 'website' )
	) );
	
	if ( ! isset ( $content_width) )
    $content_width = 1200;

	add_theme_support( 'custom-header' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );
	add_theme_support( 'custom-background' );
	add_post_type_support( 'page', 'excerpt' );
	add_theme_support( 'post-thumbnails' ); 
	add_theme_support('woocommerce');
	add_theme_support( 'wc-product-gallery-slider' );

}
endif; // website setup
add_action( 'after_setup_theme', 'website_setup' );


/* Adding breadcrubs */
function the_breadcrumb() {
	if (!is_home()) {
		echo '<span class="breadcrumbs"><a href="';
		echo get_option('home');
		echo '">';
		echo 'Home';
		echo "</a> / ";
		if (is_category() || is_single()) {
			the_category('title_li=');
			if (is_single()) {
				echo " / ";
				the_title();
			}
		} elseif (is_page()) {
			echo the_title();
		}
		echo '</span>';
	}
}


/* Posibility to add a custom logo */
function website_custom_logo_setup() {
    $defaults = array(
        'height'      => 50,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    );
    add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'website_custom_logo_setup' );

function sf_update_woo_flexslider_options( $options ) {

    $options['directionNav'] = true;

    return $options;
}


/* Header add to cart */
function woocommerce_header_add_to_cart_custom_fragment( $cart_fragments ) {
	   global $woocommerce;
	   ob_start();
	   ?>
	   <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View  cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	   <?php
	   $cart_fragments['a.cart-contents'] = ob_get_clean();
	   return $cart_fragments;
}

add_filter( 'woocommerce_single_product_carousel_options', 'sf_update_woo_flexslider_options' );


add_action('wp_ajax_myfilter', 'filter_function'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_myfilter', 'filter_function');

function filter_function(){
	$args = array(
		'post_type' => 'product',
		'orderby' => 'date', // we will sort posts by date
		'order'	=> $_POST['date'] // ASC or DESC
	);
 
	// for taxonomies / categories
	if( isset( $_POST['categoryfilter'] ) )
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'id',
				'terms' => $_POST['categoryfilter']
			)
		);
 
	// create $args['meta_query'] array if one of the following fields is filled
	if( isset( $_POST['price_min'] ) && $_POST['price_min'] || isset( $_POST['price_max'] ) && $_POST['price_max'])
		$args['meta_query'] = array( 'relation'=>'AND' ); // AND means that all conditions of meta_query should be true
 
	// if both minimum price and maximum price are specified we will use BETWEEN comparison
	if( isset( $_POST['price_min'] ) && $_POST['price_min'] && isset( $_POST['price_max'] ) && $_POST['price_max'] ) {
		$args['meta_query'][] = array(
			'key' => '_price',
			'value' => array( $_POST['price_min'], $_POST['price_max'] ),
			'type' => 'numeric',
			'compare' => 'between'
		);
	} else {
		// if only min price is set
		if( isset( $_POST['price_min'] ) && $_POST['price_min'] )
			$args['meta_query'][] = array(
				'key' => '_price',
				'value' => $_POST['price_min'],
				'type' => 'numeric',
				'compare' => '>'
			);
 
		// if only max price is set
		if( isset( $_POST['price_max'] ) && $_POST['price_max'] )
			$args['meta_query'][] = array(
				'key' => '_price',
				'value' => $_POST['price_max'],
				'type' => 'numeric',
				'compare' => '<'
			);
	}
 
	// if you want to use multiple checkboxed, just duplicate the above 5 lines for each checkbox
 
	$query = new WP_Query( $args );
	
	if( $query->have_posts() ) :
		while( $query->have_posts() ): $query->the_post(); 
		global $product;
		?>
		<div class="product d-flex flex-column mt-1 clickable justify-content-between">
			<i class="fa-regular fa-heart product__favorites--button" aria-hidden="true"></i>
			<img style="width:100%;" src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" class="product__image mx-auto" />
			<p class="product-title mt-4"><?php the_title() ?></p>
			<span class="product-price"><?php echo $product->get_price_html();  ?></span>
			<!-- <?php echo '<a href="'. $checkout_url.'?add-to-cart=' .$productID. '" class="btn btn-primary">'?>In winkelwagen</a> -->
			<a href="<?php echo get_permalink(); ?>" class="btn btn-primary"><?php the_field('txt-btn', 'option'); ?></a>
		</div>
		</div>

		<?php endwhile;
		wp_reset_postdata();
	else :
		echo 'Geen producten gevonden';
	endif;
	
	die();
}


/* Optionpage*/

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Algemene instellingen',
		'menu_title'	=> 'Algemeen',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Header instellingen',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Footer instellingen',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Webshop instellingen',
		'menu_title'	=> 'Webshop',
		'parent_slug'	=> 'theme-general-settings',
	));
	
}

// Cart Icon
add_shortcode ('woo_cart_but', 'woo_cart_but' );
/**
 * Create Shortcode for WooCommerce Cart Menu Item
 */
function woo_cart_but() {
	ob_start();
 
        $cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count
        $cart_url = wc_get_cart_url();  // Set Cart URL
  
        ?>
        <a class="menu-item cart-contents" href="<?php echo $cart_url; ?>" title="My Basket">
			<i class="fas fa-shopping-basket"></i>
	    <?php
        if ( $cart_count > 0 ) {
       ?>
            <span class="cart-contents-count"><?php echo $cart_count; ?></span>
        <?php
        }
        ?>
        </a>
        <?php
	        
    return ob_get_clean();
 
}

add_filter( 'woocommerce_add_to_cart_fragments', 'woo_cart_but_count' );
/**
 * Add AJAX Shortcode when cart contents update
 */
function woo_cart_but_count( $fragments ) {
 
    ob_start();
    
    $cart_count = WC()->cart->cart_contents_count;
    $cart_url = wc_get_cart_url();
    
    ?>
    <a class="cart-contents menu-item" href="<?php echo $cart_url; ?>" title="<?php _e( 'View your shopping cart' ); ?>">
	<i class="fas fa-shopping-basket"></i>
	<?php
    if ( $cart_count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo $cart_count; ?></span>
        <?php            
    }
        ?></a>
    <?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}


// Hook in
add_filter( 'woocommerce_default_address_fields' , 'custom_override_address_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_address_fields( $address_fields ) {
	$address_fields['first_name']['placeholder'] = 'Voornaam';
	$address_fields['last_name']['placeholder'] = 'Achternaam';
	$address_fields['company']['placeholder'] = 'Bedrijfsnaam (optioneel)';
	$address_fields['country']['placeholder'] = 'Land/regio';
	$address_fields['city']['placeholder'] = 'Plaats';
	$address_fields['postcode']['placeholder'] = 'Postcode';
	// $address_fields['email']['placeholder'] = 'Postcode';
	// $address_fields['phone']['placeholder'] = 'Telefoonnummer';
	


	$address_fields['first_name']['label'] = '';
	$address_fields['last_name']['label'] = '';
	$address_fields['company']['label'] = '';
	$address_fields['country']['label'] = '';
	$address_fields['address_1']['label'] = '';
	$address_fields['city']['label'] = '';
	$address_fields['postcode']['label'] = '';
     return $address_fields;
}

add_filter( 'woocommerce_checkout_fields' , 'override_billing_checkout_fields', 20, 1 );
function override_billing_checkout_fields( $fields ) {
    $fields['billing']['billing_phone']['placeholder'] = 'Telefoon';
    $fields['billing']['billing_email']['placeholder'] = 'Email';
	$fields['billing']['billing_phone']['label'] = '';
    $fields['billing']['billing_email']['label'] = '';
    return $fields;
}

function mode_theme_update_mini_cart() {
	echo wc_get_template( 'cart/mini-cart.php' );
	die();
  }
  add_filter( 'wp_ajax_nopriv_mode_theme_update_mini_cart', 'mode_theme_update_mini_cart' );
  add_filter( 'wp_ajax_mode_theme_update_mini_cart', 'mode_theme_update_mini_cart' );

