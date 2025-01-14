<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link      https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package   Nightingale
 * @copyright NHS Leadership Academy, Tony Blacker
 * @version   1.1 21st August 2019
 */
?>

	<?php do_action( 'nightingale_before_single_content' ); ?>

	<div class="entry-content">
		<?php
		if ( function_exists( 'nightingale_clean_bad_content' ) ) {
			nightingale_clean_bad_content( true );
		}
		?>

		<?php do_action( 'page_after_content' ); ?>
	</div><!-- .entry-content -->
	<div class="nhsuk-content__clearfix"></div>

	<?php do_action( 'nightingale_after_single_content' ); ?>
