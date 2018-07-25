<?php

/**
 * Class WP_EXT_Theme_Genesis_Settings
 */
class WP_EXT_Theme_Genesis_Settings {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->run();
	}

	/**
	 * Plugin: `initialize`.
	 */
	public function run() {
		remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );
		remove_theme_support( 'genesis-inpost-layouts' );

		add_filter( 'genesis_footer_creds_text', [ $this, 'genesis_ext_footer_creds_filter' ] );
		add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );
		add_filter( 'genesis_author_box_title', [ $this, 'genesis_ext_author_box_title' ] );
		add_filter( 'comment_author_says_text', [ $this, 'genesis_ext_comment_author_says_text' ] );
		add_filter( 'edit_comment_link', [ $this, 'genesis_ext_edit_comment_link' ] );
		add_filter( 'edit_post_link', [ $this, 'genesis_ext_edit_post_link' ] );
		add_filter( 'the_content_more_link', [ $this, 'genesis_ext_read_more_link' ] );
		add_filter( 'cancel_comment_reply_link', [ $this, 'genesis_ext_cancel_comment_reply_link' ] );
		add_filter( 'genesis_post_info', [ $this, 'genesis_ext_post_info_filter' ] );
		add_filter( 'genesis_post_meta', [ $this, 'genesis_ext_post_meta_filter' ] );
		add_filter( 'genesis_prev_link_text', [ $this, 'genesis_ext_previous_page_link' ] );
		add_filter( 'genesis_next_link_text', [ $this, 'genesis_ext_next_page_link' ] );
		add_filter( 'genesis_breadcrumb_args', [ $this, 'genesis_ext_breadcrumb_args' ] );
		add_action( 'genesis_entry_header', [ $this, 'genesis_ext_post_format' ] );
		add_action( 'genesis_entry_header', [ $this, 'genesis_ext_featured_image' ], 1 );
		add_filter( 'genesis_site_layout', [ $this, 'wc_ext_page_layout' ] );
	}

	/**
	 * Change the footer text.
	 *
	 * @param $creds
	 *
	 * @return string
	 */
	public function genesis_ext_footer_creds_filter( $creds ) {
		$icon  = '<span class="fa fa-heart" style="color:#fe6e3a;"></span>';
		$url   = '<a title="METADATA - проектирование и разработка веб-приложений" href="https://metadata.foundation/"><strong>METADATA</strong></a>';
		$creds = 'MADE WITH ' . $icon . ' BY ' . $url . ' [footer_copyright]';

		return $creds;
	}

	/**
	 * Customize the author box title.
	 *
	 * @return string
	 */
	public function genesis_ext_author_box_title() {
		$url    = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
		$title  = esc_html( get_the_author() );
		$output = '<a itemprop="name" href="' . $url . '">' . $title . '</a>';

		return $output;
	}

	/**
	 * Modify `author_says_text` text.
	 *
	 * @return bool
	 */
	public function genesis_ext_comment_author_says_text() {
		return false;
	}

	/**
	 * Modify `edit_comment_link` text.
	 *
	 * @param $text
	 *
	 * @return mixed
	 */
	public function genesis_ext_edit_comment_link( $text ) {
		$icon    = '<span class="far fa-edit fa-fw"></span>';
		$edit    = [
			'(Edit)' => $icon,
		];
		$subject = $text;
		$output  = str_replace( array_keys( $edit ), $edit, $subject );

		return $output;
	}

	/**
	 * Modify `edit_post_link` text.
	 *
	 * @param $link
	 *
	 * @return mixed
	 */
	public function genesis_ext_edit_post_link( $link ) {
		$icon    = '<span class="far fa-edit fa-fw"></span>';
		$edit    = [
			'(Edit)' => $icon,
		];
		$subject = $link;
		$output  = str_replace( array_keys( $edit ), $edit, $subject );

		return false;
	}

	/**
	 * Modify `read_more_link` text.
	 *
	 * @return string
	 */
	public function genesis_ext_read_more_link() {
		$icon   = '<span class="fas fa-sign-in-alt fa-fw fa-lg"></span>';
		$title  = esc_html__( 'Read more', 'genesis_ui' );
		$output = '<a title="' . $title . '" class="more-link" href="' . get_permalink() . '">' . $icon . '</a>';

		return false;
	}

	/**
	 * Modify `cancel_comment_reply_link` text.
	 *
	 * @param $text
	 *
	 * @return mixed
	 */
	public function genesis_ext_cancel_comment_reply_link( $text ) {
		$icon    = '<span class="fas fa-window-close fa-fw"></span>';
		$reply   = [
			'Cancel reply'   => $icon,
			'Отменить ответ' => $icon,
		];
		$subject = $text;
		$output  = str_replace( array_keys( $reply ), $reply, $subject );

		return $output;
	}

	/**
	 * Modify `post_info`.
	 *
	 * @param $post_info
	 *
	 * @return string
	 */
	public function genesis_ext_post_info_filter( $post_info ) {
		$post_info = '[post_date] [post_author_posts_link] [post_categories before=""] [post_comments zero="0" one="1" more="%" hide_if_off="disabled"] [post_edit]';

		return $post_info;
	}

	/**
	 * Modify `post_meta`.
	 *
	 * @param $post_meta
	 *
	 * @return string
	 */
	public function genesis_ext_post_meta_filter( $post_meta ) {
		$post_meta = '[post_tags before=""]';

		return $post_meta;
	}

	/**
	 * Previous page link.
	 *
	 * @param $text
	 *
	 * @return string
	 */
	public function genesis_ext_previous_page_link( $text ) {
		$text = '<span class="fas fa-arrow-left fa-fw"></span>';

		return $text;
	}

	/**
	 * Next page link.
	 *
	 * @param $text
	 *
	 * @return string
	 */
	public function genesis_ext_next_page_link( $text ) {
		$text = '<span class="fas fa-arrow-right fa-fw"></span>';

		return $text;
	}

	/**
	 * Breadcrumb.
	 *
	 * @param $args
	 *
	 * @return mixed
	 */
	public function genesis_ext_breadcrumb_args( $args ) {
		$icon                        = '<span class="fas fa-home fa-fw"></span>';
		$args['home']                = $icon;
		$args['sep']                 = ' / ';
		$args['labels']['prefix']    = '';
		$args['labels']['author']    = '';
		$args['labels']['category']  = '';
		$args['labels']['tag']       = '';
		$args['labels']['date']      = '';
		$args['labels']['search']    = '';
		$args['labels']['tax']       = '';
		$args['labels']['post_type'] = '';
		$args['labels']['404']       = '';

		return $args;
	}

	/**
	 * Prints HTML with post formats.
	 *
	 * Create your own ext_post_format() function to override in a child theme.
	 *
	 * @return int|string
	 */
	public function genesis_ext_post_format() {
		$format = esc_html( get_post_format() );

		if ( ! current_theme_supports( 'post-formats', $format ) ) {
			return '';
		}

		switch ( $format ) {
			case 'aside':
				$icon = 'far fa-sticky-note';
				break;
			case 'gallery':
				$icon = 'far fa-images';
				break;
			case 'link':
				$icon = 'fas fa-link';
				break;
			case 'image':
				$icon = 'far fa-image';
				break;
			case 'quote':
				$icon = 'fas fa-quote-left';
				break;
			case 'status':
				$icon = 'far fa-comment-alt';
				break;
			case 'video':
				$icon = 'fas fa-video';
				break;
			case 'audio':
				$icon = 'fas fa-volume-up';
				break;
			case 'chat':
				$icon = 'far fa-comments';
				break;
			default:
				$icon = '';
		}

		$str_format = esc_html_x( 'Format', 'Used before post format.', 'genesis_ui' );

		$output = printf( '<span class="entry-format">%1$s<a title="%3$s" class="entry-format-' . esc_html( $format ) . '" href="%2$s"><span class="' . esc_html( $icon ) . '"></span></a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', $str_format ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);

		return $output;
	}

	/**
	 * Featured image settings.
	 */
	public function genesis_ext_featured_image() {
		$image = genesis_get_image( [
			'format'  => 'html',
			'size'    => 'full',
			'context' => '',
			'attr'    => [
				'alt'   => the_title_attribute( 'echo=0' ),
				'class' => 'aligncenter'
			],
		] );

		if ( is_singular( [ 'page', 'post' ] ) && has_post_thumbnail() ) {
			if ( $image ) {
				printf( '<div class="featured-image">%s</div>', $image );
			}
		}
	}

	/**
	 * WooCommerce: change page layout.
	 *
	 * @return string
	 */
	public function wc_ext_page_layout() {
		$layout = null;
		$page   = [
			'cart',
			'checkout',
			'my-account'
		];

		if ( class_exists( 'WooCommerce' )
		     && ( is_page( $page ) || is_shop() || 'product' == get_post_type() || is_woocommerce() )
		) {
			$layout = 'full-width-content';
		}

		return $layout;
	}
}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @return WP_EXT_Theme_Genesis_Settings
 */
function WP_EXT_Theme_Genesis_Settings() {
	static $object;

	if ( null == $object ) {
		$object = new WP_EXT_Theme_Genesis_Settings;
	}

	return $object;
}

/**
 * Initialize the object on `plugins_loaded`.
 */
if ( WP_EXT_Theme()->theme_info( 'Name' ) === 'Genesis' ) {
	add_action( 'after_setup_theme', [ WP_EXT_Theme_Genesis_Settings(), 'run' ] );
}
