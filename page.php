<?php

get_template_part( 'template-parts/block', 'header' );
the_post();
?>

	<article>
		<h1><?php the_title(); ?></h1>
    <?php // get_template_part( 'template-parts/block', 'premium-content' ); ?>
		<div class="the-content"><?php the_content(); ?></div>
	</article>

<?php get_template_part( 'template-parts/block', 'footer' ); ?>
