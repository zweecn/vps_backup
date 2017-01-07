<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Skirmish
 * @since Skirmish 1.8
 */
?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php do_action( 'before_sidebar' ); ?>
			<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
				<aside id="search" class="widget">
					<h1 class="widget-title"><?php _e( 'Search', 'skirmish' ); ?></h1>
					<?php get_search_form();?>
				</aside> 
				
				<aside id="about" class="widget">
					<h1 class="widget-title"><?php _e( 'Feed RSS', 'skirmish' ); ?></h1>
					<ul>
						<li>
							<a href="https://favorbook.com/feed" target="_blank">整站订阅(RSS)</a>
						</li>
						<li>
							<a href="https://favorbook.com/category/technology/feed" target="_blank">技术(RSS)</a>
							<a href="https://favorbook.com/category/share/feed" target="_blank">分享(RSS)</a>
							<a href="https://favorbook.com/category/life/feed" target="_blank">生活(RSS)</a>
						</li>
						<li>
							<a href="http://reader.yodao.com/#url=https://favorbook.com/feed/" target="_blank">订阅到有道</a>
							<a href="http://mail.qq.com/cgi-bin/feed?u=https://favorbook.com/feed" target="_blank">订阅到QQ邮箱</a>
						</li>
					</ul>
				</aside>

				<aside id="posts" class="widget">
					<h1 class="widget-title"><?php _e( 'Recent Post', 'skirmish' ); ?></h1>
					<?php query_posts('showposts=10'); ?>   
					<ul>   
						<?php while (have_posts()) : the_post(); ?>  
						<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li> 
						<?php endwhile;?>   
					</ul> 
				</aside>
				
				<aside id="comment-list" class="widget">
					<h1 class="widget-title"><?php _e( 'Recent Comments', 'skirmish' ); ?></h1>
					<ul>
						<?php get_recent_comments();?>
					</ul>
				</aside>
				

				<aside id="links" class="widget">
					<h1 class="widget-title"><?php _e( 'Links', 'skirmish' ); ?></h1>
					<ul>
						<?php wp_list_bookmarks('title_li=&categorize=0'); ?>
					</ul>
				</aside>

				<aside id="meta" class="widget">
					<h1 class="widget-title"><?php _e( 'Meta', 'skirmish' ); ?></h1>
					<ul>
						<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
						<?php wp_meta(); ?>
					</ul>
				</aside>

			<?php endif; // end sidebar widget area ?>
		</div><!-- #secondary .widget-area -->
