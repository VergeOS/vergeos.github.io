<?php
$deep_options = deep_options();
global $post;
$deep_options['deep_blog_posttitle_enable']		= isset( $deep_options['deep_blog_posttitle_enable'] ) ? $deep_options['deep_blog_posttitle_enable'] : '1' ;
$deep_options['deep_blog_meta_gravatar_enable']	= isset( $deep_options['deep_blog_meta_gravatar_enable'] ) ? $deep_options['deep_blog_meta_gravatar_enable'] : '1' ;
$deep_options['deep_blog_featuredimage_enable']	= isset( $deep_options['deep_blog_featuredimage_enable'] ) ? $deep_options['deep_blog_featuredimage_enable'] : '1' ;
$deep_options['deep_no_image']					= isset( $deep_options['deep_no_image'] ) ? $deep_options['deep_no_image'] : '0' ;
$deep_options['deep_blog_excerptfull_enable']	= isset( $deep_options['deep_blog_excerptfull_enable'] ) ? $deep_options['deep_blog_excerptfull_enable'] : '0' ;
$deep_options['deep_blog_excerpt_large']		= isset( $deep_options['deep_blog_excerpt_large'] ) ? $deep_options['deep_blog_excerpt_large'] : 93 ;
$blog_readmore_text 							= $deep_options['deep_blog_readmore_text'] ? $deep_options['deep_blog_readmore_text'] : '' ;
$deep_options['deep_blog_social_share']			= isset( $deep_options['deep_blog_social_share'] ) ? $deep_options['deep_blog_social_share'] : '1' ;
$deep_options['deep_blog_meta_date_enable']		= isset( $deep_options['deep_blog_meta_date_enable'] ) ? $deep_options['deep_blog_meta_date_enable'] : '1' ;
$deep_options['deep_blog_meta_category_enable']	= isset( $deep_options['deep_blog_meta_category_enable'] ) ? $deep_options['deep_blog_meta_category_enable'] : '1' ;
$deep_options['deep_blog_meta_comments_enable']	= isset( $deep_options['deep_blog_meta_comments_enable'] ) ? $deep_options['deep_blog_meta_comments_enable'] : '1' ;
$deep_options['featured_img_search']			= isset( $deep_options['featured_img_search'] ) ? $deep_options['featured_img_search'] : '1' ;

$post_thumb = ( get_the_post_thumbnail( get_the_ID(), 'full' ) ) ? '' : 'post-no-image';
$classes = array(
	'blog-post',
	'blgtyp1',
	$post_thumb,
);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
	<div class="blog-inner">
		<?php
		$post_format	= get_post_format(get_the_ID());
		$content		= get_the_content();
		$post_format	= $post_format ? $post_format : 'standard';
		$meta_video		= rwmb_meta( 'deep_featured_video_meta' );

		if( $deep_options['deep_blog_featuredimage_enable'] && $deep_options['featured_img_search'] ) {
			if( 'video'  == $post_format || 'audio'  == $post_format ) {
				$pattern = '\\[' .'(\\[?)' ."(video|audio)" .'(?![\\w-])' .'(' .'[^\\]\\/]*' .'(?:' .'\\/(?!\\])' .'[^\\]\\/]*' .')*?' .')' .'(?:' .'(\\/)' .'\\]' .'|' .'\\]' .'(?:' .'(' .'[^\\[]*+' .'(?:' .'\\[(?!\\/\\2\\])' .'[^\\[]*+' .')*+' .')' .'\\[\\/\\2\\]' .')?' .')' .'(\\]?)';
				preg_match('/'.$pattern.'/s', $post->post_content, $matches);
				if( ( is_array($matches) ) && (isset($matches[3])) && ( ($matches[2] == 'video') || ('audio'  == $post_format)) && ( isset( $matches[2] ) ) ) {
					$video = $matches[0];
					echo do_shortcode($video);
					$content = preg_replace('/'.$pattern.'/s', '', $content);
				} else if( ( ! empty( $meta_video ) ) ) {
					echo do_shortcode( $meta_video );
				}
			} elseif( 'gallery'  == $post_format ) {
				if ( has_block( 'gallery', $post->post_content ) ) {
					$blocks = parse_blocks( get_the_content() );
					foreach ( $blocks as $block ) {
						if ( $block['blockName'] == 'core/gallery' ) {
							wp_kses_post( $block['innerHTML'] );
						}
					}
				} else {
					$pattern = '\\[' .'(\\[?)' ."(gallery)" .'(?![\\w-])' .'(' .'[^\\]\\/]*' .'(?:' .'\\/(?!\\])' .'[^\\]\\/]*' .')*?' .')' .'(?:' .'(\\/)' .'\\]' .'|' .'\\]' .'(?:' .'(' .'[^\\[]*+' .'(?:' .'\\[(?!\\/\\2\\])' .'[^\\[]*+' .')*+' .')' .'\\[\\/\\2\\]' .')?' .')' .'(\\]?)';
					preg_match( '/'.$pattern.'/s', $post->post_content, $matches );
					if( ( is_array( $matches ) ) && ( isset( $matches[3] ) ) && ( $matches[2] == 'gallery' ) && ( isset( $matches[2] ) ) ) {
						$ids		= ( shortcode_parse_atts( $matches[3] ) );
						$ids		= is_array( $ids ) && isset( $ids['ids'] ) ? $ids['ids'] : '';
						$galley_url	= array();
						$galley_id	= explode( ",", $ids );
						?>
						<div class="post-gallery-format">
							<div class="gl-img owl-carousel owl-theme">
								<?php
								for( $i=0; $i < sizeof( $galley_id ); $i++ ) {
									if( !empty( $galley_id[$i] ) ) {
										if ( !class_exists( 'Wn_Img_Maniuplate' ) ) {
											require_once DEEP_COMPONENTS_DIR . 'helper-classes/class_webnus_manuplate.php';
										}
										$image = new Wn_Img_Maniuplate; // instance from settor class
										$thumbnail_url = $image->m_image( $galley_id[$i], wp_get_attachment_url( $galley_id[$i] ) , '1300' , '667' ); // set required and get result
										echo '<img src="' . esc_url( $thumbnail_url ) . '" alt="' . esc_attr( get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) ) . '">';
									}
								} ?>
							</div>
						</div>
						<?php
					}
				}
			} else {
				if( has_post_thumbnail() ){
					get_the_image( array( 'meta_key' => array( 'Full', 'Full' ), 'size' => 'Full') );
				} else {
					if( $deep_options['deep_no_image'] ){
						echo ! empty( $deep_options['deep_no_image_src']['id'] ) ? '<a href="'.esc_url( get_the_permalink() ).'">' . wp_get_attachment_image($deep_options['deep_no_image_src']['id'], 'full') . '</a>' : '<a href="'.esc_url( get_the_permalink() ).'"><img src="' . esc_url( DEEP_ASSETS_URL ) . 'images/no_image.jpg' . '"></a>';
					}
				}
			}
		} ?>
		<!-- title, thumbnail, post metadata -->
		<div class="blgt1-top-sec">
			<div class="blog1-header-wrap">
				<div class="postmetadata">
					<?php
					if( $deep_options['deep_blog_meta_date_enable'] ) { ?>
						<h6 class="blog-date"><i class="ti-calendar"></i><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_time(get_option( 'date_format' )) ?></a></h6>
						<?php
					}
					if( $deep_options['deep_blog_meta_category_enable'] ) { ?>
						<h6 class="blog-cat"><i class="ti-folder"></i><?php the_category(', ') ?> </h6>
						<?php
					}
					if( $deep_options['deep_blog_meta_comments_enable'] ) { ?>
						<h6 class="blog-comments"><a class="hcolorf" href="<?php echo esc_html( get_comments_link() );?>"><i class="ti-comment"></i><?php comments_number(  ); ?></a></h6>
						<?php
					} ?>
					<div class="clearfix"></div>
				</div>
				<?php
				if( function_exists( 'wp_review_show_total' ) ) {
					wp_review_show_total(true, 'review-total-only small-thumb');
				}
				if( $deep_options['deep_blog_posttitle_enable'] ) {
					if( ('aside' != $post_format ) && ('quote' != $post_format) ) {
						if( 'link' == $post_format ) {
							preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $content,$matches);
							$content = preg_replace('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i','', $content,1);
							$link ='';
							if(isset($matches) && is_array($matches)) $link = $matches[0]; ?>
							<h3 class="post-title"><a href="<?php echo esc_url($link); ?>"><?php the_title() ?></a></h3> <?php
						} else { ?>
							<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3> <?php
						}
					}
				}
			if ( $post_format != 'quote' ) {
				if( $deep_options['deep_blog_meta_gravatar_enable'] ) { ?>
					<div class="au-avatar-box">
						<div class="au-avatar"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 30 ); ?></div>
						<h6 class="blog-author"><?php the_author_posts_link(); ?></h6>
					</div>
				<?php } ?>
			<?php } ?>
			</div>
		</div>
		<!-- content -->
		<div class="blgt1-inner">
			<?php
				if( 0 == $deep_options['deep_blog_excerptfull_enable'] ) {
					if( 'quote' == $post_format  ) echo '<blockquote>';
					echo '<p>';
					echo deep_excerpt(($deep_options['deep_blog_excerpt_large']) ? $deep_options['deep_blog_excerpt_large'] : 93 );
					if ( $blog_readmore_text ) {
						echo '... <br><br><a class="readmore" href="' . esc_url( get_permalink($post->ID) ) . '">' . esc_html( $blog_readmore_text ) . '</a>';
					} else {
						echo '... <br><br><a class="readmore" href="' . esc_url( get_permalink($post->ID) ) . '">' . esc_html__('Continue Reading', 'deep') . '</a>';
					}
					echo '</p>';
					if( 'quote' == $post_format  ) echo '</blockquote>';
				} else {
					if( 'quote' == $post_format  ) echo '<blockquote>';
					echo wp_kses_post(apply_filters('the_content',$content));
					if( 'quote' == $post_format  ) echo '</blockquote>';
				}
			?>
		</div>

		<?php if ( $post_format == 'quote' ) {
			if( $deep_options['deep_blog_meta_gravatar_enable'] ) { ?>
				<div class="au-avatar-box">
					<div class="au-avatar"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 90 ); ?></div>
					<h6 class="blog-author"><?php esc_html_e('Write By:','deep') . the_author_posts_link(); ?></h6>
				</div>
			<?php } ?>
		<?php } ?>

		<?php
		if( 1 == $deep_options['deep_blog_index_social_share'] ) {
			$dashed_title =  sanitize_title_with_dashes ( get_the_title() );
			$dashed_blog_info_name =  sanitize_title_with_dashes ( get_bloginfo( 'name' ) );
			deep_social_share( get_the_id() );
		}
		?>
		<hr class="vertical-space1">
	</div>
</article>