<?php
/* Template Name: shoppage */

get_header();
?>

<?php 

if ( is_product_category() ){
    global $wp_query;
    // get the query object
    $cat = $wp_query->get_queried_object();
    // get the thumbnail id using the queried category term_id
    $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true ); 
    // get the image URL
    $image = wp_get_attachment_url( $thumbnail_id ); 
}

if(is_search()){
	global $wp_query;
	$wp_query->is_search();
}

	
?>
<div class="row full">
	<a class="button" id="toggleFilter" style="transition: all .3s ease-in-out;">Filters</a>
</div>

<div id="filters">
	<div class="row">
	<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter" class="col-12">
			<div class="columns large-3">
				<h2>Bedrag</h2>
				<input type="text" name="price_min" placeholder="Min. prijs" />
				<input type="text" name="price_max" placeholder="Max. prijs" />
			</div>
			<div class="columns large-3">
				<h2>Sorteren</h2>
				<label>
					<div class="input-container">
					<input type="radio" name="date" value="ASC" /> Datum: Oplopend
					<span class="mark"></span>
					</div>
				</label>
				<label>
					<div class="input-container">
						<input type="radio" name="date" value="DESC" selected="selected" /> Datum: Aflopend
						<span class="mark"></span>
					</div>
				</label>
			</div>
			<div class="columns large-3">
				<input type="hidden" name="action" value="myfilter">
			</div>	
		<div class="large-2 columns">
			<button class="btn btn-primary">Filters toepassen</button>
		</div>
	</form>

</div>
</div>
<!-- <div id="response"> -->
	<div id="products" class= "archive mt-4">
		<div id="response" class="row full">
		<?php if (have_posts()) : ?>     
		<?php
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

				if($cat){

					$args = array(
						'post_type'      => 'product',
						'posts_per_page' => 6,
						'paged' => $paged,
						'tax_query'     => array(
							array(
								'taxonomy'  => 'product_cat',
								'field'     => 'id', 
								'terms'     => $cat
							)
						)
					);

					$secondArgs = array(
						'post_type'      => 'product',
						'posts_per_page' => 4,
						'paged' => $paged,
						'offset' => 6,
						'tax_query'     => array(
							array(
								'taxonomy'  => 'product_cat',
								'field'     => 'id', 
								'terms'     => $cat
							)
						)
					);
				}elseif(is_search()){
					$s=get_search_query();
					$args = array(
									's' =>$s,
									'post_type'      => 'product',
									'posts_per_page' => 12,
									'paged' => $paged
								);
				}else{
					$args = array(
						'post_type'      => 'product',
						'posts_per_page' => 12,
						'paged' => $paged
				);}

			$loop = new WP_Query( $args );

			while ( $loop->have_posts() ) : $loop->the_post();
				global $product;
				$productID = $product->get_id();
				$productVar = wc_get_product( $productID );
				$checkout_url = wc_get_checkout_url(); 

		?>

		<div class="product large-6 columns">
		<!-- <i class="fa-regular fa-heart product__favorites--button" aria-hidden="true"></i> -->
			<img style="width:100%;" src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" class="product__image mx-auto" />
			<p class="product-title mt-4"><?php the_title() ?></p>
			<span class="product-price"><?php echo $product->get_price_html();  ?></span>
			<!-- <?php echo '<a href="'. $checkout_url.'?add-to-cart=' .$productID. '" class="btn btn-primary">'?>In winkelwagen</a> -->
			<a href="<?php echo get_permalink(); ?>" class="btn btn-primary"><?php the_field('txt-btn', 'option'); ?></a>
		</div>

		<?php endwhile; ?>

		<div class="large-6 medium-12 small-12 columns productblock text-center" style="background-image: url('http://localhost/BeckaJames/wp-content/uploads/2021/10/tyler-nix-fo83GD_AARE-unsplash.jpg');">
				<h2 class="productblock-title">Nieuw!</h2>
				<span class="productblock-subtitle">Bekijk onze nieuwste producten</span>
		</div>
	<?php
		$secondLoop = new WP_Query( $secondArgs );
		while ( $secondLoop->have_posts() ) : $secondLoop->the_post();
				global $product;
				$productID = $product->get_id();
				$productVar = wc_get_product( $productID );
				$checkout_url = wc_get_checkout_url(); 

		?>

		<div class="product large-6 columns">
			<!-- <i class="fa-regular fa-heart product__favorites--button" aria-hidden="true"></i> -->
			<img style="width:100%;" src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" class="product__image mx-auto" />
			<p class="product-title mt-4"><?php the_title() ?></p>
			<span class="product-price"><?php echo $product->get_price_html();  ?></span>
			<!-- <?php echo '<a href="'. $checkout_url.'?add-to-cart=' .$productID. '" class="btn btn-primary">'?>In winkelwagen</a> -->
			<a href="<?php echo $product->get_permalink(); ?>" class="btn btn-primary"><?php the_field('txt-btn', 'option'); ?> </a>
		</div>
	<?php endwhile; ?>
	<?php
		?>

				<nav class="mx-auto pagination">
                    <ul>
                        <li><?php previous_posts_link( '&laquo; Vorige producten', $secondLoop->max_num_pages) ?></li> 
                        <li><?php next_posts_link( 'Volgende producten &raquo;', $secondLoop->max_num_pages) ?></li>
                    </ul>
                </nav>
	
		 <?php else: ?>
		<p>Sorry, er zijn geen producten gevonden<p>
			<?php endif ?>
  
		</div>
	</div>
<!-- </div> -->
<div class="row">
	<?php if($cat){?>
		<div class="category__information--container--title large-6">
			<h3 class=""><?php echo single_term_title(); ?></h3>
		</div>
	<?php } else{?>
		<div class="category__information--container--title large-6">
			<h3 class="">Winkel</h3>
		</div>
	<?php } ?>
	<div class="category__information--container large-12">
			<?php echo the_archive_description(); ?>
	</div>
</div>
<?php
get_footer();

?>