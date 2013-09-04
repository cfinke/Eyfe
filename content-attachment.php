<?php
/**
 * @package Eyfe
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php $attachment = wp_get_attachment_image_src( get_the_ID(), array( 160, 160 ) ); ?>
		<a class="photo" href="<?php the_permalink(); ?>" style="background-image: url( '<?php echo $attachment[0]; ?>' ), linear-gradient( to bottom, #2b2b2b, #151515 );">
			&nbsp;
		</a>
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
