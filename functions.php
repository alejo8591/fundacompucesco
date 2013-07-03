<?php
/**
 * @package WordPress
 * @subpackage fundacompucesco-theme
 * @since fundacompucesco 1.0
 */

	// Options Framework (https://github.com/devinsays/options-framework-plugin)
	if ( !function_exists( 'optionsframework_init' ) ) {
		define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/_/inc/' );
		require_once dirname( __FILE__ ) . '/_/inc/options-framework.php';
	}

	// Theme Setup (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
	function html5reset_setup() {
		load_theme_textdomain( 'html5reset', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );	
		add_theme_support( 'structured-post-formats', array( 'link', 'video' ) );
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'quote', 'status' ) );
		register_nav_menu( 'primary', __( 'Navigation Menu', 'html5reset' ) );
		add_theme_support( 'post-thumbnails' );
	}
	add_action( 'after_setup_theme', 'html5reset_setup' );
	
	// Scripts & Styles (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
	function html5reset_scripts_styles() {
		global $wp_styles;

		// Load Comments	
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
	
		// Load Stylesheets
//		wp_enqueue_style( 'html5reset-reset', get_template_directory_uri() . '/reset.css' );
//		wp_enqueue_style( 'html5reset-style', get_stylesheet_uri() );
	
		// Load IE Stylesheet.
//		wp_enqueue_style( 'html5reset-ie', get_template_directory_uri() . '/css/ie.css', array( 'html5reset-style' ), '20130213' );
//		$wp_styles->add_data( 'html5reset-ie', 'conditional', 'lt IE 9' );

		// Modernizr
		// This is an un-minified, complete version of Modernizr. Before you move to production, you should generate a custom build that only has the detects you need.
		// wp_enqueue_script( 'html5reset-modernizr', get_template_directory_uri() . '/_/js/modernizr-2.6.2.dev.js' );
		
	}
	add_action( 'wp_enqueue_scripts', 'html5reset_scripts_styles' );
	
	// WP Title (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
	function html5reset_wp_title( $title, $sep ) {
		global $paged, $page;
	
		if ( is_feed() )
			return $title;
	
//		 Add the site name.
		$title .= get_bloginfo( 'name' );
	
//		 Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";
	
//		 Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'html5reset' ), max( $paged, $page ) );
//FIX
//		if (function_exists('is_tag') && is_tag()) {
//		   single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
//		elseif (is_archive()) {
//		   wp_title(''); echo ' Archive - '; }
//		elseif (is_search()) {
//		   echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
//		elseif (!(is_404()) && (is_single()) || (is_page())) {
//		   wp_title(''); echo ' - '; }
//		elseif (is_404()) {
//		   echo 'Not Found - '; }
//		if (is_home()) {
//		   bloginfo('name'); echo ' - '; bloginfo('description'); }
//		else {
//		    bloginfo('name'); }
//		if ($paged>1) {
//		   echo ' - page '. $paged; }
	
		return $title;
	}
	add_filter( 'wp_title', 'html5reset_wp_title', 10, 2 );

//OLD STUFF BELOW


	// Load jQuery
	if ( !function_exists( 'core_mods' ) ) {
		function core_mods() {
			if ( !is_admin() ) {
				wp_deregister_script( 'jquery' );
				wp_register_script( 'jquery', ( "//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ), false);
				wp_enqueue_script( 'jquery' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'core_mods' );
	}

	// Clean up the <head>, if you so desire.
	//	function removeHeadLinks() {
	//    	remove_action('wp_head', 'rsd_link');
	//    	remove_action('wp_head', 'wlwmanifest_link');
	//    }
	//    add_action('init', 'removeHeadLinks');

	// Custom Menu
	register_nav_menu( 'primary', __( 'Navigation Menu', 'html5reset' ) );

	// Widgets
	if ( !function_exists('register_sidebar' )) {
		function html5reset_widgets_init() {
			register_sidebar( array(
				'name'          => __( 'Sidebar Widgets', 'html5reset' ),
				'id'            => 'sidebar-primary',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
		}
		add_action( 'widgets_init', 'html5reset_widgets_init' );
	}

	// Navigation - update coming from twentythirteen
	function post_navigation() {
		echo '<div class="navigation">';
		echo '	<div class="next-posts">'.get_next_posts_link('&laquo; Older Entries').'</div>';
		echo '	<div class="prev-posts">'.get_previous_posts_link('Newer Entries &raquo;').'</div>';
		echo '</div>';
	}

	// Posted On
	function posted_on() {
		printf( __( '<span class="sep">Posted </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a> by <span class="byline author vcard">%5$s</span>', '' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_author() )
		);
	}
/*------------------------------------- Menu Nav -------------------------------------- */
	// Custom Navigation

	add_theme_support( 'menus' ); 
 
	/*
	http://codex.wordpress.org/Function_Reference/register_nav_menus#Examples
	*/
	register_nav_menus( array(
		'main-menu' => 'Main Menu' // registers the menu in the WordPress admin menu editor
	) );
	  
	/* 
	http://codex.wordpress.org/Function_Reference/wp_nav_menu 
	*/
	function shurikend_nav_bar() {
	    wp_nav_menu(array( 
	    	'container' => false,
	    	'container_class' => '',
	    	'menu' => 'Main Menu',
	    	'menu_class' => 'nav-bar',         // this adds the Foundation nav-bar class to the menu
	    	'theme_location' => 'main-menu',
	    	'before' => '',
	        'after' => '',
	        'link_before' => '',
	        'link_after' => '',
	        'depth' => 2,                      // Foundation Nav Bar only supports 2 levels
	    	'fallback_cb' => 'main_nav_fb',    // this uses the below function to list pages as a menu
		'walker' => new nav_walker()       // this calls the walker for Foundation classes and descriptions
		));
	}
	/*
	http://codex.wordpress.org/Template_Tags/wp_list_pages
	*/
	function main_nav_fb() {
		echo '<ul class="nav-bar">';
		wp_list_pages(array(
			'depth'        => 0,
			'child_of'     => 0,
			'exclude'      => '',
			'include'      => '',
			'title_li'     => '',
			'echo'         => 1,
			'authors'      => '',
			'sort_column'  => 'menu_order, post_title',
			'link_before'  => '',
			'link_after'   => '',
			'walker'       => new page_walker(),
			'post_type'    => 'page',
			'post_status'  => 'publish' 
		));
		echo '</ul>';
	}

	/* 
Customize the output of menus for Foundation nav classes and add descriptions
 
http://www.kriesi.at/archives/improve-your-wordpress-navigation-menu-output
http://wikiduh.com/1541/custom-nav-menu-walker-function-to-add-classes
http://code.hyperspatial.com/1514/twitter-bootstrap-walker-classes/ 
*/
class nav_walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
 
		$class_names = $value = '';
 
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		
		if (in_array( 'current-menu-item', $classes )){$classes[]= 'active';}
		if ($args->has_children){$classes[] = 'has-flyout';}
 
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = strlen( trim( $class_names ) ) > 0 ? ' class="' . esc_attr( $class_names ) . '"' : '';
 
		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
 
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ! empty( $item->description ) ? ' class="has-desc"' : '';
 
		$description  = ! empty( $item->description ) ? '<span class="nav-desc">'.esc_attr( $item->description ).'</span>' : '';
 
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= $description.$args->link_after;
           	if ( $args->has_children && $depth == 0 ) {
               		$item_output .= '</a><a href="#" class="flyout-toggle"><span> </span></a>';
           	 } else {
                	$item_output .= '</a>';
            	}
		$item_output .= $args->after;
 
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
    function end_el(&$output, $item, $depth) {
        $output .= "</li>\n";
    }
			
	function start_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu flyout\">\n";
	}
    function end_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent</ul>\n";
    }
				
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		}
		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}  	
	
} /* end nav walker */

	/*
Customize the output of page list for Foundation nav classes in main_nav_fb
 
http://forrst.com/posts/Using_Short_Page_Titles_for_wp_list_pages_Wordp-uV9
*/
class page_walker extends Walker_Page {
	function start_el(&$output, $page, $depth, $args, $current_page) {
		
	$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
 
		extract($args, EXTR_SKIP);
		$classes = array('page_item', 'page-item-'.$page->ID);
		if ( !empty($current_page) ) {
			$_current_page = get_page( $current_page );
			if ( isset($_current_page->ancestors) && in_array($page->ID, (array) $_current_page->ancestors) )
				$classes[] = 'current_page_ancestor';
			if ( $page->ID == $current_page )
				$classes[] = 'current_page_item active';
			elseif ( $_current_page && $page->ID == $_current_page->post_parent )
				$classes[] = 'current_page_parent';
		} elseif ( $page->ID == get_option('page_for_posts') ) {
			$classes[] = 'current_page_parent';
		}
		if ( get_children( $page->ID ) )
			$classes[] = 'has-flyout';
		
		$classes = implode(' ', apply_filters('page_css_class', $classes, $page));
		
		$output .= $indent . '<li class="' . $classes . '"><a href="' . get_page_link($page->ID) . '" title="' . esc_attr( wp_strip_all_tags( $page->post_title ) ) . '">' . $args['link_before'] . $page->post_title . $args['link_after'] . '</a>';
 
	}
    function end_el(&$output, $item, $depth) {
        $output .= "</li>\n";
    }
	
    function start_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        // $output .= "\n$indent<ul class=\"sub-menu flyout\">\n";
        $output .= "\n$indent<ul class=\"sub-menu flyout\">\n";
    }
    function end_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent</ul>\n";
    }
	
} /* end page walker */
/*------------------------------------- End Menu Nav -------------------------------------- */


?>
