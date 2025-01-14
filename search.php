<?php
/**
 * The search results page
 * This is the template file to display search results.
 * It is used to display a a list of pages / posts matching a search query.
 * Each result is presented in its own promo panel at 1/3 width.
 * The sidebar is intentionally disabled on this view, regardless of site settings.
 *
 * @link      https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package   Hale
 * @copyright Ministry of Justice
 * @version   1.0
 */

get_header();
?>

	<div id="primary" class="clear search-page">
		<header class="entry-header page-header" style="">
			<div class="nhsuk-width-container">
					<h1 class="nhsuk-heading-xl">
						<?php
						/* translators: %s: search term */
						printf( esc_html__( 'Search Results for %s', 'nightingale' ), '<span>' . get_search_query() . '</span>' );

						$header_search = get_theme_mod( 'show_search', 'yes' );
						?>
					</h1>

					<div class="nhsuk-header__search--results-page">
						<?php get_search_form(); ?>
				</div>
			</div>
		</header>
		<div class="index">
			<?php
			if ( have_posts() ) :
				?>

				<p class="search-results-count">
					<?php /* Search Count */
						echo $wp_query->found_posts . ' ';
						_e('results');
					?>
				</h2>

				<div class="nhsuk-promo-group search__results-list">
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();
						?>
						<div class="nhsuk-postslisting search__results">
							<div class="nhsuk-promo">
								<?php
								if ( has_post_thumbnail() ) :
									the_post_thumbnail( 'thumbnail', [ 'class' => 'nhsuk-promo__img' ] );
								else :
									$fallback = get_theme_mod( 'blog_fallback' );
									if ( $fallback ) {
										echo wp_get_attachment_image( $fallback, 'thumbnail', false, [ 'class' => 'nhsuk-promo__img' ] );
									}
								endif;
								?>

								<h2 class="nhsuk-promo__heading">
									<a class="nhsuk-promo__link-wrapper" href="<?php the_permalink(); ?>">
										<?php the_title( ); ?>
									</a>
								</h2>

								<?php do_action( 'nightingale_before_archive_content' ); ?>
								<p class="nhsuk-promo__description">
									<?php
									$excerpt = get_the_excerpt();
									$keys    = explode( ' ', $s );
									$excerpt = preg_replace( '/(' . implode( '|', $keys ) . ')/iu', '<span class="search-terms">\0</span>', $excerpt );
									echo $excerpt; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									?>
								</p>
								<?php do_action( 'nightingale_after_archive_content' ); ?>

								<?php
								// Get and display the last updated time of the search result
									$u_time = get_the_time('U');
									$u_modified_time = get_the_modified_time('U');
									echo "<p class='search__result-updated'>Updated on ";
									the_modified_time('jS F Y');
									echo "</p> ";
								?>
							</div>
						</div>
						<?php
					endwhile;
					?>
				</div><!-- #nhsuk-panel-group nhsuk-grid-column-full -->
				<?php
				nightingale_archive_pagination();
				else :
					get_template_part( 'template-parts/content', 'none' );
			endif;
				?>
		</div>
	</div><!-- #primary -->
<?php
get_footer();
