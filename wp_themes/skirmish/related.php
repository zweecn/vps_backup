<?php
	$backup = $post;
	$tags = wp_get_post_tags($post->ID);
	$tagIDs = array();
	if ($tags) {
	echo '<h4>您可能还喜欢:</h4>';
	echo '<ul>';
	$tagcount = count($tags);
	for ($i = 0; $i < $tagcount; $i++) {
	$tagIDs[$i] = $tags[$i]->term_id;
	}
	$args=array(
		'tag__in' => $tagIDs,
		'post__not_in' => array($post->ID),
		'showposts'=>6,//显示相关日志篇数
		'caller_get_posts'=>1
	);
	$my_query = new WP_Query($args);
	if( $my_query->have_posts() ) {
	while ($my_query->have_posts()) : $my_query->the_post(); ?>
	<li><a href="<?php the_permalink() ?>" target="_blank" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
	<?php endwhile;
	echo '</ul>';
	} else { ?>
	<ul>
	<?php
	query_posts(array('orderby' => 'rand', 'showposts' => 6));// 显示随机日志篇数
	if (have_posts()) :
	while (have_posts()) : the_post();?>
	<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></li>
	<?php endwhile;endif; ?>
	</ul>
	<?php }
	}
	$post = $backup;
	wp_reset_query();
?>
