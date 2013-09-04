<?php
/**
 * The template for displaying image attachments.
 *
 * @package Eyfe
 */

get_header();

while ( have_posts() ) : the_post(); ?>
	<div id="primary" class="content-area image-attachment">
		<div id="content" class="site-content" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<a href="/" class="back button"><?php esc_html_e( 'Home', 'eyef' ); ?></a>
					<nav role="navigation" id="image-navigation" class="navigation-image">
						<div class="previous"><?php previous_image_link( false, __( '<span class="meta-nav">&larr;</span> Previous', 'eyfe' ) ); ?></div>
						<div class="next"><?php next_image_link( false, __( 'Next <span class="meta-nav">&rarr;</span>', 'eyfe' ) ); ?></div>
					</nav><!-- #image-navigation -->
				</header><!-- .entry-header -->

				<div class="entry-content">
					<div class="entry-attachment">
						<div class="attachment">
							<?php
								/**
								 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
								 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
								 */
								$attachments = array_values( get_children( array(
									'post_parent'    => $post->post_parent,
									'post_status'    => 'inherit',
									'post_type'      => 'attachment',
									'post_mime_type' => 'image',
									'order'          => 'ASC',
									'orderby'        => 'menu_order ID'
								) ) );
								foreach ( $attachments as $k => $attachment ) {
									if ( $attachment->ID == $post->ID )
										break;
								}
								$k++;
								// If there is more than 1 attachment in a gallery
								if ( count( $attachments ) > 1 ) {
									if ( isset( $attachments[ $k ] ) )
										// get the URL of the next image attachment
										$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
									else
										// or get the URL of the first image attachment
										$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
								} else {
									// or, if there's only 1 image, get the URL of the image
									$next_attachment_url = wp_get_attachment_url();
								}
							?>

							<a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
								$attachment_size = apply_filters( 'eyfe_attachment_size', array( 1200, 1200 ) ); // Filterable image size.
								echo wp_get_attachment_image( $post->ID, $attachment_size );
							?></a>
						</div><!-- .attachment -->
					</div><!-- .entry-attachment -->

					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'eyfe' ), 'after' => '</div>' ) ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() )
							comments_template();
					?>
				</div><!-- .entry-content -->
			</article><!-- #post-<?php the_ID(); ?> -->
		</div><!-- #content -->
	</div><!-- #primary -->
	<div id="secondary" role="complementary">
		<div id="exif">
			<?php
			
			$metadata = wp_get_attachment_metadata();
			$exif = $metadata['image_meta'];
			
			?>
			<p><?php echo esc_html( $exif['camera'] ); ?></p>

			<p>
				<?php echo esc_html( $exif['caption'] ); ?>&nbsp;
			</p>

			<p>
				<span><?php echo esc_html( sprintf( __( '%d x %d', 'eyfe' ), $metadata['width'], $metadata['height'] ) ); ?></span>
				<span><?php
				
				$filesize = filesize( get_attached_file( $post->ID ) );
				
				if ( $filesize > ( 1024 * 1024 ) )
					printf( esc_html__( '%s MB' ), round( $filesize / 1024 / 1024, 2 ) );
				else if ( $filesize > ( 1024 ) )
					printf( esc_html__( '%s KB' ), round( $filesize / 1024 ) );
				
				?></span>
				<span class="filetype"><?php echo esc_html( array_pop( explode( '.', $metadata['file'] ) ) ); ?></span>
			</p>
			
			<div class="camera-settings">
				<span><?php if ( isset( $exif['iso'] ) ) { ?>ISO <?php echo esc_html( $exif['iso'] ); ?><?php } else { ?>-<?php } ?></span>
				<span><?php if ( isset( $exif['focal_length'] ) ) { ?><?php echo esc_html( $exif['focal_length'] ); ?> mm<?php } else { ?>-<?php } ?></span>
				<span><?php if ( isset( $exif['aperture'] ) ) { ?>f/<?php echo esc_html( $exif['aperture'] ); ?><?php } else { ?>-<?php } ?></span>
				<span><?php if ( isset( $exif['shutter_speed'] ) ) { ?><?php echo esc_html( round( $exif['shutter_speed'], 2 ) ); ?><?php } else { ?>-<?php } ?></span>
			</div>
		</div>
		
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<span>
			<?php echo get_the_date( 'F j, Y h:i:s A' ); ?>
		</span>

		<?php if ( ! empty( $post->post_excerpt ) ) { ?>
			<p class="entry-caption">
				<?php the_excerpt(); ?>
			</p>
		<?php } ?>

		<div>
			<?php the_content(); ?>
		</div>
		
		<?php edit_post_link( __( 'Edit', 'eyfe' ), '<span class="edit-link">', '</span>' ); ?>
		
		<?php comment_form(); ?>
	</div><!-- #secondary -->
	<?php break; ?>
<?php endwhile; // end of the loop. ?>
	
<?php get_footer(); ?>