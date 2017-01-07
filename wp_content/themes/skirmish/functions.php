<?php
/**
 * skirmish functions and definitions
 *
 * @package Skirmish
 * @since Skirmish 1.8
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since skirmish 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 540; /* pixels */

if ( ! function_exists( 'skirmish_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since skirmish 1.0
 */
function skirmish_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/tweaks.php' );


	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on skirmish, use a find and replace
	 * to change 'skirmish' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'skirmish', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'skirmish' ),
	) );

	/**
	 * Add support for the Aside and Gallery Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', ) );
	
	add_editor_style() ;

	// Enable post thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 50, 50, true );
	add_image_size( 'index-post-thumbnail', 125, 125, true );
	add_image_size( 'single-post-thumbnail', 745, 300, true );
	
	
}
endif; // skirmish_setup
add_action( 'after_setup_theme', 'skirmish_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since skirmish 1.0
 */
function skirmish_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'skirmish' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'skirmish_widgets_init' );


/**
 * if lt IE 9
 */
function skirmish_head(){
?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
}
add_action( 'wp_head', 'skirmish_head');

/**
 * Enqueue scripts and styles
 */
function skirmish_scripts() {
	global $post;

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', 'jquery', '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	wp_enqueue_style( 'fonts', 'http://fonts.googleapis.com/css?family=Lusitana|Droid+Sans' );

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'skirmish_scripts' );

/**
 * Add by zwee at 2012-05-06
 */
function archives_list_SHe() {
     global $wpdb,$month;
     $lastpost = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_date <'" . current_time('mysql') . "' AND post_status='publish' AND post_type='post' AND post_password='' ORDER BY post_date DESC LIMIT 1");
     $output = get_option('SHe_archives_'.$lastpost);
     if(empty($output)){
         $output = '';
         $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'SHe_archives_%'");
         $q = "SELECT DISTINCT YEAR(post_date) AS year, MONTH(post_date) AS month, count(ID) as posts FROM $wpdb->posts p WHERE post_date <'" . current_time('mysql') . "' AND post_status='publish' AND post_type='post' AND post_password='' GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";
         $monthresults = $wpdb->get_results($q);
         if ($monthresults) {
             foreach ($monthresults as $monthresult) {
             $thismonth    = zeroise($monthresult->month, 2);
             $thisyear    = $monthresult->year;
             $q = "SELECT ID, post_date, post_title, comment_count FROM $wpdb->posts p WHERE post_date LIKE '$thisyear-$thismonth-%' AND post_date AND post_status='publish' AND post_type='post' AND post_password='' ORDER BY post_date DESC";
             $postresults = $wpdb->get_results($q);
             if ($postresults) {
                 $text = sprintf('%s %d', $month[zeroise($monthresult->month,2)], $monthresult->year);
                 $postcount = count($postresults);
                 $output .= '<ul class="archives-list"><li><span class="archives-yearmonth">' . $text . ' &nbsp;(' . count($postresults) . '&nbsp;篇文章)</span><ul class="archives-monthlisting">' . "\n";
             foreach ($postresults as $postresult) {
                 if ($postresult->post_date != '0000-00-00 00:00:00') {
                 $url = get_permalink($postresult->ID);
                 $arc_title    = $postresult->post_title;
                 if ($arc_title)
                     $text = wptexturize(strip_tags($arc_title));
                 else
                     $text = $postresult->ID;
                     $title_text = 'View this post, &quot;' . wp_specialchars($text, 1) . '&quot;';
                     $output .= '<li>' . mysql2date('d日', $postresult->post_date) . ':&nbsp;' . "<a href='$url' title='$title_text'>$text</a>";
                     $output .= '&nbsp;(' . $postresult->comment_count . ')';
                     $output .= '</li>' . "\n";
                 }
                 }
             }
             $output .= '</ul></li></ul>' . "\n";
             }
         update_option('SHe_archives_'.$lastpost,$output);
         }else{
             $output = '<div class="errorbox">Sorry, no posts matched your criteria.</div>' . "\n";
         }
     }
     echo $output;
}


/*
 * Add by zwee 2012-12-29
 */

function zww_archives_list() {
     if( !$output = get_option('zww_archives_list') ){
         $output = '<div id="archives"><p>[<a id="al_expand_collapse" href="#">全部展开/收缩</a>] <em>(注: 点击月份可以展开)</em></p>';
         $the_query = new WP_Query( 'posts_per_page=-1&ignore_sticky_posts=1' ); //update: 加上忽略置顶文章
         $year=0; $mon=0; $i=0; $j=0;
         while ( $the_query->have_posts() ) : $the_query->the_post();
             $year_tmp = get_the_time('Y');
             $mon_tmp = get_the_time('m');
             $y=$year; $m=$mon;
             if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></li>';
             if ($year != $year_tmp && $year > 0) $output .= '</ul>';
             if ($year != $year_tmp) {
                 $year = $year_tmp;
                 $output .= '<h3 class="al_year">'. $year .' 年</h3><ul class="al_mon_list">'; //输出年份
             }
             if ($mon != $mon_tmp) {
                 $mon = $mon_tmp;
                 $output .= '<li><span class="al_mon">'. $mon .' 月</span><ul class="al_post_list">'; //输出月份
             }
             $output .= '<li>'. get_the_time('d日: ') .'<a href="'. get_permalink() .'">'. get_the_title() .'</a> <em>('. get_comments_number('0', '1', '%') .')</em></li>'; //输出文章日期和标题
         endwhile;
         wp_reset_postdata();
         $output .= '</ul></li></ul></div>';
         update_option('zww_archives_list', $output);
     }
     echo $output;
 }
function clear_zal_cache() {
     update_option('zww_archives_list', ''); // 清空 zww_archives_list
}
add_action('save_post', 'clear_zal_cache'); // 新发表文章/修改文章时
wp_enqueue_script('jquery');

/*
 * Add by zwee 2013-03-24 //最新评论函数
 */
function get_recent_comments(){   
    //获取最近的5条评论   
	// 不显示pingback的type=comment,不显示自己的,user_id=0.(此两个参数可有可无)
	$comments=get_comments(array('number'=>5,'status'=>'approve','type'=>'comment','user_id'=>0));
    $output = '';   
    foreach($comments as $comment) {   
        //去除评论内容中的标签   
        $comment_content = strip_tags($comment->comment_content);   
        //评论可能很长,所以考虑截断评论内容,只显示10个字   
        $short_comment_content = trim(mb_substr($comment_content ,0, 10,"UTF-8"));   
        //先获取头像   
        $output .= '<li><div style="float:left;">'.get_avatar( $comment, 40 )."</div>"; 
        //$output .= '<li><div style="float:left;">'.get_avatar( $comment, 40,' ',$comment->comment_author)."</div>"; 
        //获取作者   
        $output .= '<div style="height:48px;margin-left:46px;">'.$comment->comment_author .':<br /><a href="';
        //评论内容和链接  
        $output .= get_permalink( $comment->comment_post_ID ) .'" title="查看 '.get_post( $comment->comment_post_ID )->post_title .'">';   
        $output .= $short_comment_content .'..</a></div></li>'; 
    }   
    //输出   
    echo $output;   
} 

/*
 * Add by zwee 2013-03-31 //第一个图片
 */
function getFirstImage($postId) {
	$args = array(
			'numberposts' => 1,
			'order'=> 'ASC',
			'post_mime_type' => 'image',
			'post_parent' => $postId,
			'post_status' => null,
			'post_type' => 'attachment'
			);
	$attachments = get_children($args);

	// 如果没有上传图片, 返回空字符串
	if(!$attachments) {
		return '';
	}

	// 获取缩略图中的第一个图片, 并组装成 HTML 节点返回
	$image = array_pop($attachments);
	$imageSrc = wp_get_attachment_image_src($image->ID, 'thumbnail');
	$imageUrl = $imageSrc[0];
	$html = '<img src="' . $imageUrl . '" alt="' . the_title('', '', false) . '" />';
	return $html;
}

/* Remove Admin Bar*/
show_admin_bar( false );

function add_smilies_to_form(){
    include(TEMPLATEPATH . '/smiley.php');
}
//下面之所以区别对待，是因为默认情况下用户登录与否comment_form有所不同
if (is_user_logged_in()) {//用户登录情况下，加到登录信息下面（留言框顶部）
    add_filter('comment_form_logged_in_after', 'add_smilies_to_form');
}
else { //非登录情况下，加到fields下（留言框顶部）
    add_filter( 'comment_form_after_fields', 'add_smilies_to_form');
}

/*
 * Add by zwee 2013-06-15
 */
function my_avatar($avatar) {
	$tmp = strpos($avatar, 'http');
	$g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp);
	$tmp = strpos($g, 'avatar/') + 7;
	$f = substr($g, $tmp, strpos($g, "?", $tmp) - $tmp);
	$w = get_bloginfo('wpurl');
	$e = ABSPATH .'avatar/'. $f .'.jpg';
	$t = 2592000; //設定30天, 單位:秒
	if ( !is_file($e) || (time() - filemtime($e)) > $t ) { //當頭像不存在或文件超過14天才更新
		copy(htmlspecialchars_decode($g), $e);
	} else  $avatar = strtr($avatar, array($g => $w.'/avatar/'.$f.'.jpg'));
	if (filesize($e) < 500) copy($w.'/avatar/default.jpg', $e);
	return $avatar;
}
add_filter('get_avatar', 'my_avatar');


/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );
