<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>
<style>
	header, footer{
		display: none;
	}
</style>
<div class="container-xxl pt-5 pb-5">
<div class="row">
    <div id="form">
		<ul id="progressbar">
			<li class="active" id="step1"><strong>Winkelwagen</strong></li>
			<li class="active" id="step2"><strong>Afrekenen</strong></li>
			<li id="step3"><strong>Bevestiging</strong></li>
		</ul>
		<fieldset>
			<div class="container-xxl mx-auto">
				<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
					<?php if ( $checkout->get_checkout_fields() ) : ?>

						<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

						<div class="col-set col-12 d-flex flex-row" id="customer_details">
							<div class="col-6">
								<?php do_action( 'woocommerce_checkout_billing' ); ?>
							</div>

							<div class="col-10 mx-auto mt-4">
								<?php do_action( 'woocommerce_checkout_shipping' ); ?>
								
							</div>
						</div>

						<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

					<?php endif; ?>
					
					<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
					
					<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

					<div id="order_review" class="woocommerce-checkout-review-order offset-1 col-4">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div>

					<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
				</form>
			</div>
			<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
		</fieldset>
	</div>
</div>
</div>
