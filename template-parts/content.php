<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php

	get_template_part( 'template-parts/entry-header' );

	if ( ! is_search() ) {
		get_template_part( 'template-parts/featured-image' );
	}

	?>

	<div class="post-inner">

		<div class="entry-content">

			<?php
			if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
				the_excerpt();
			} else {
				the_content( __( 'Continue reading', 'twentytwenty' ) );
			}
			?>
			<div class="dates">
				<?php
					$paint_dates = get_field( 'paint_dates' );
				foreach ( $paint_dates as $key => $paint_date ) :
						$date     = $paint_date['date'];
						$location = $paint_date['location'];
						$images   = $paint_date['images'];
					?>
					<div class="info">
						<p class="date"><?php echo $date; ?></p>
						<p class="location"><?php echo $location[0]->name; ?></p>
					</div>
					<div class="carousel">
						<?php foreach ( $images as $repeater_id => $image ) : ?>
							<div class="module">
								<figure>
									<a href="<?php echo wp_get_attachment_image_url( $image['image'], 'full' ); ?>" data-lightbox="<?php printf( 'image-%s', $image['$image'] ); ?>">
										<?php echo wp_get_attachment_image( $image['image'], 'medium' ); ?>
									</a>
									<figcaption>
										<?php echo basename( get_attached_file( $image['image'] ) ); ?>
										<div>
											<form id="<?php echo 'form-', $image['image']; ?>" method="post">
												<input name="keep" type="checkbox" <?php echo ( $image['keep_photo'] ) ? 'checked ' : ''; ?>class="switch" id="<?php echo get_the_ID(), '-', $image['image'], '-image'; ?>" label="Keep" />
												<label for="<?php echo $image['image']; ?>">Keep</label>
												<textarea name="notes" id="<?php echo get_the_ID(), '_notes'; ?>" cols="30" rows="5">
													<?php echo $image['notes']; ?>
												</textarea>
												<input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
												<input type="hidden" name="photo_id" value="<?php echo $image['image']; ?>">
												<input type="hidden" name="paint_row" value="<?php echo $key; ?>">
												<input type="hidden" name="photo_row" value="<?php echo $repeater_id; ?>">
												<?php wp_nonce_field( 'update_image', 'fww-special-string' ); ?>
												<button value="submit" class="submit-button">Submit</button>
											</form>
										</div>
									</figcaption>
								</figure>
							</div>
						<?php endforeach; ?>
					</div>
					<?php endforeach; ?>
				</div>
		</div><!-- .entry-content -->

  </div><!-- .post-inner -->

	<div class="section-inner">
		<?php
		wp_link_pages(
			array(
				'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'twentytwenty' ) . '"><span class="label">' . __( 'Pages:', 'twentytwenty' ) . '</span>',
				'after'       => '</nav>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			)
		);

		edit_post_link();

		?>

	</div><!-- .section-inner -->

	<?php

	if ( is_single() ) {

		get_template_part( 'template-parts/navigation' );

	}
	?>

</article><!-- .post -->
