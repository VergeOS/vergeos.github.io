<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package Deep
 */
if( !defined( 'WPINC' ) ) {	die; }

use Deep\Components\WooCommerce;

if( !class_exists( 'THWVSF_Public' ) ):
 
class THWVSF_Public {
	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		add_action( 'after_setup_theme', [$this, 'define_public_hooks'] );
	}

	public function enqueue_styles_and_scripts() {
		$this->enqueue_styles();
		$this->enqueue_scripts();
	}

	private function enqueue_styles() {
		if ( WooCommerce::is_single_builder() ) {
			wp_register_style( 'thwvsf-public-style', THWVSF_ASSETS_URL_PUBLIC . 'css/thwvsf-public.css', $this->version );
		} else {
			wp_enqueue_style( 'thwvsf-public-style', THWVSF_ASSETS_URL_PUBLIC . 'css/thwvsf-public.css', $this->version );
		}
	}

	private function enqueue_scripts() {
		$deps = ['jquery', 'wc-add-to-cart-variation'];	
		if ( WooCommerce::is_single_builder() ) {
			wp_register_script( 'thwvsf-public-script', THWVSF_ASSETS_URL_PUBLIC . 'js/thwvsf-public.js', $deps, $this->version, true );
		} else {
			wp_enqueue_script( 'thwvsf-public-script', THWVSF_ASSETS_URL_PUBLIC . 'js/thwvsf-public.js', $deps, $this->version, true );
		}		
		$settings          = THWVSF_Utils::get_advanced_swatches_settings();
		$clear_on_reselect = 'yes';
		$behavior_of_out_of_stock = 'default';
		$show_selected_variation_name = '';

		if( $settings && is_array( $settings ) ) {

			$clear_on_reselect        = THWVSF_Utils::get_global_swatches_settings( 'clear_select', $settings );
			$behavior_of_out_of_stock = THWVSF_Utils::get_global_swatches_settings( 'behavior_of_out_of_stock', $settings );
			$show_selected_variation_name  = THWVSF_Utils::get_global_swatches_settings( 'show_selected_variation_name', $settings );
		}

		$wvs_var = [
			// 'ajax_url'					=> admin_url( 'admin-ajax.php' ),
			'clear_on_reselect' 			=> apply_filters( 'thwvsf_clear_on_reselect', $clear_on_reselect ),
			'out_of_stock'					=> apply_filters( 'thwvsf_out_of_stock', $behavior_of_out_of_stock ),
			'show_selected_variation_name'	=> $show_selected_variation_name,
		];

		wp_localize_script( 'thwvsf-public-script', 'thwvsf_public_var', $wvs_var );
	}
	
	public function define_public_hooks() {
		add_filter( 'woocommerce_dropdown_variation_attribute_options_html', [$this, 'swatches_display'], 100, 2 );
		add_filter( 'woocommerce_dropdown_variation_attribute_options_args', [$this, 'add_class_for_attribute_type'], 101, 1 );
		add_filter( 'woocommerce_reset_variations_link', [$this, 'reset_variation_link'] );
		add_filter( 'woocommerce_ajax_variation_threshold', [$this, 'change_ajax_variation_threshold'], 10, 2 );
	}

	public function reset_variation_link( $link ) {
		$custom_reset = apply_filters( 'thwvsf_reset_variations_link',false );
		if( $custom_reset ) {
			$link = '<a class="reset_variations thwvsf-variation-link" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>';
		}
		return $link;
	}

	public function change_ajax_variation_threshold( $threshold_value,$product ) {
		$threshold = THWVSF_Utils::get_global_swatches_settings( 'ajax_variation_threshold' );
		
		if( $threshold  && is_numeric( $threshold ) ) {
			$threshold_value = $threshold;
		}

		return $threshold_value;
	}

	public function get_attribute_fields( $attribute, $product ) {
		if( taxonomy_exists( $attribute ) ) {
			$attribute_taxonomies = wc_get_attribute_taxonomies();

	        foreach ( $attribute_taxonomies as $tax ) {
	            if( 'pa_'.$tax->attribute_name == $attribute ) {
	                return( $tax->attribute_type );
	                break;
	            }
	        }
	    } else {
	    	$product_id = $product->get_id();
	    	$attribute  = sanitize_title( $attribute );
			$local_attr_settings = get_post_meta( $product_id,'th_custom_attribute_settings', true );
			if( is_array( $local_attr_settings ) && isset( $local_attr_settings[$attribute] ) ) {
				$settings = $local_attr_settings[$attribute];
				$type = isset( $settings['type'] ) ? $settings['type'] : '';
				return $type;
			}

			return '';
	    }
	}

	public function get_attributes_display_design( $attribute,$product ) {
		if( taxonomy_exists( $attribute ) ) {
			$attr_id     = $this->get_attribute_id( $attribute );
			$design_type = THWVSF_Utils::get_design_swatches_settings( $attr_id );
			return  $design_type ? $design_type : 'swatch_design_default' ;
	    } else {
	    	$product_id          = $product->get_id();
			$local_attr_settings = get_post_meta( $product_id,'th_custom_attribute_settings', true );
			$attribute  = sanitize_title( $attribute );
			if( is_array( $local_attr_settings ) && isset( $local_attr_settings[$attribute] ) ) {
				$settings = $local_attr_settings[$attribute];
				$type     = isset( $settings['design_type'] ) ? $settings['design_type'] : 'swatch_design_default' ;
				return $type ? $type : 'swatch_design_default' ;
			}

			return 'swatch_design_default';
	    }
	}

	public function get_attribute_id( $taxonomy ) {

		$attribute_taxonomies = wc_get_attribute_taxonomies();
        foreach ( $attribute_taxonomies as $tax ) {
            if( 'pa_'.$tax->attribute_name == $taxonomy ) {
                return( $tax->attribute_id );
                break;
            }
        }
	}

	public function add_class_for_attribute_type( $args ) {
		$args['class'] = 'thwvs-select';
		return $args;
	}
	
	public function swatches_display( $html, $args ) {
		
		global $product;
		$attribute   = $args['attribute'];
		$type        = $this->get_attribute_fields( $attribute, $product );
		$design_type = $this->get_attributes_display_design( $attribute, $product );

		$auto_convert = '';
		$apply_auto_convert = false;
	
		if( $type === 'select' || $type == null ) {
			$auto_convert = THWVSF_Utils::get_global_swatches_settings( 'auto_convert' );
			if( $auto_convert === 'yes' ) {
				
				$type = 'label';
				$apply_auto_convert = true;
			} else {
				$html = $this->wrapp_variation_in_class( $html );
				return $html;
			}
		}

		$swatch_types = ['color','image','label'];

		if( in_array( $type, $swatch_types ) ) {

			$html = '';
			$attr_type_html = '';
		
			$attr_type_html .= $this->swatch_display_options_html( $html, $args, $type, $design_type, $apply_auto_convert );
		
		} else {
			return $html;
		}

		$html = $attr_type_html;
		$html = $this->wrapp_variation_in_class( $html );
		return $html;
	}

	public function wrapp_variation_in_class( $html ) {
		$html = '<div class="thwvsf_fields"> '. $html .' </div>';
		return $html;
	}

	public function swatch_display_options_html( $html, $args, $type, $design_type, $apply_auto_convert ) {

		$html       = $this->default_variation_field( $html,$args,$type,$design_type );
		$options    = $args['options'];
		$product    = $args['product'];
		$attribute  = $args['attribute'];
		$name       = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
		$id         = $args['id'] ? $args['id'] : sanitize_title( $attribute );
		$product_id = $product->get_id(); 
		
		if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[ $attribute ];
		}

		if ( ! empty( $options ) ) {

			if( $product ) {

				$terms = wc_get_product_terms( $product->get_id(), $attribute, ['fields' => 'all',] );
				$terms = taxonomy_exists( $attribute ) ? $terms  : $options;
				$local_attr_settings = get_post_meta( $product_id ,'th_custom_attribute_settings', true );
				$local_settings = isset( $local_attr_settings[$id] ) ?  $local_attr_settings[$id] : '';
				
				$tt_html        = '';
				$tooltip_type   = '';
				$tt_design_type = '';
				
				$settings = THWVSF_Utils::get_advanced_swatches_settings();
				
				if( is_array( $settings ) ) {

					$tt_design_type = $design_type;
					if( isset( $settings[$tt_design_type] ) ) {
						$settings_value = $settings[$tt_design_type];
						$tooltip_type = is_array( $settings_value ) &&  isset( $settings_value['tooltip_enable'] ) ? $settings_value['tooltip_enable'] : '';
					} else {
						$tooltip_type =  isset( $settings['tooltip_enable'] ) ? $settings['tooltip_enable'] : '';
					}
				}

				$html .= '<ul class="thwvsf-wrapper-ul">';

				foreach ( $terms as $term ) {

					$term_status = false;
					$name = '';
					$slug = '';
					$selected ='';
					$attr_method = '';

					if( taxonomy_exists( $attribute ) ) {
						$term_status = false;
						$attr_method = 'global';
						if ( in_array( $term->slug, $options, true ) ) {
							$term_status = true;
							$name     = apply_filters( 'woocommerce_variation_option_name', $term->name );
							$slug = $term->slug;
							$selected = sanitize_title( $args['selected'] ) == $term->slug ? 'thwvsf-selected' : '';
							//$label = get_term_meta( $term->term_id, 'label', true );
							//$label = $label ? $label : $name;
						}

					} else {

						$term_status = true;
						$name = $term;
						$slug = $name;
						$selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $term ), false ) : selected( $args['selected'], $term, false );
						$selected = $selected ? 'thwvsf-selected' : '';
						$attr_method = 'local';

					}

					$attr_class      = preg_replace( '/[^A-Za-z0-9\-\_]/', '', $slug );
					$data_val        = $slug;
					$design_class    = 'attr_'.$design_type;
					$tt_design_class = 'tooltip_'.$design_type;
					$tt_html = '';

					if( $tooltip_type === 'yes' ) {
	                 	$tt_html = '<span class="tooltiptext tooltip_'. esc_attr( $id ).' '. esc_attr( $tt_design_class ).'">'. esc_html( $name ) .'</span>' ;
	                }

	                if( $term_status ) {

		                switch ( $type ) {
		                	case 'color':
		               		$html .=  $this->add_color_display( $id,$name,$attribute,$term,$attr_class,$selected,$data_val,$tt_html,$design_class,$attr_method,$local_settings );
		            		break;
				            case 'image':
				                $html .= $this->add_image_display( $id,$name,$attribute,$term,$attr_class,$selected,$data_val,$tt_html,$design_class,$attr_method,$local_settings );
				            break;
				            case 'label' : 
				            	$html .= $this->add_label_display( $id,$name,$attribute,$term,$attr_class,$selected,$data_val,$tt_html,$design_class,$attr_method,$local_settings, $apply_auto_convert );
				            break;
		                }
		            }

				}

				$html  .= '</ul>';
			}
		}

		return $html;
	}


	public function add_color_display( $id, $name, $attribute, $term, $attr_class, $selected, $data_val, $tt_html, $design_class, $attr_method, $local_settings ) {

		if( $attr_method === 'global' ) {

			$color = get_term_meta( $term->term_id,'product_'.$attribute, true );
		} else {

			$term_settings = isset( $local_settings[$name] ) ? $local_settings[$name] : '' ;

			$color = !empty( $term_settings ) &&  isset( $term_settings['term_value'] ) ? $term_settings['term_value'] : '';
		}
       		
		$html = '
			<li class="thwvsf-wrapper-item-li thwvsf-color-li thwvsf-div thwvsf-checkbox attribute_'.esc_attr( $id ).' '. esc_attr( $attr_class ).' '.esc_attr( $selected ).' '.esc_attr( $design_class ).' thwvsf-tooltip" data-attribute_name="attribute_'.esc_attr( $id ).'" data-value="'.esc_attr( $data_val ).'" title="'.esc_attr( $name ).'">'.$tt_html.
				'<span class="thwvsf-item-span thwvsf-item-span-color" style="background-color:'.esc_attr( $color ).';"> </span>
			</li>';

		return $html;
	}

	public function add_image_display( $id, $name, $attribute, $term, $attr_class, $selected, $data_val, $tt_html, $design_class, $attr_method, $local_settings ) {

		if( $attr_method == 'global' ) {
			$value = get_term_meta( $term->term_id,'product_'.$attribute, true );
			$image = $value ? wp_get_attachment_image_src( $value ) : '';
	    	$image = $image ? $image[0] : THWVSF_URL . 'admin/assets/images/placeholder.png';
	    } else {

	    	$term_settings = isset( $local_settings[$name] ) ? $local_settings[$name] : '' ;
	    	$value = isset( $term_settings['term_value'] ) ? $term_settings['term_value'] : '';
        	$image = $value ? wp_get_attachment_image_src( $value ) : '';
	        $image = $image ? $image[0] : THWVSF_URL . 'admin/assets/images/placeholder.png';
	    }

	    $html = '<li class="thwvsf-wrapper-item-li thwvsf-image-li thwvsf-div thwvsf-checkbox attribute_'.esc_attr( $id ).' '. esc_attr( $attr_class ).' '. esc_attr( $design_class ).' '.esc_attr( $selected ).' thwvsf-tooltip" data-attribute_name="attribute_'.esc_attr( $id ).'" data-value="'.esc_attr( $data_val ).'" title="'.esc_attr( $name ).'" >'.$tt_html.'<img class="swatch-preview swatch-image "  src="'.esc_url( $image ).' " width="44px" height="44px" alt="'.esc_attr( $name ).'"></li>';	

		return $html;
	}

	public function add_label_display( $id, $name, $attribute, $term, $attr_class, $selected, $data_val, $tt_html, $design_class, $attr_method, $local_settings, $apply_auto_convert ) {

		$value = '';
		if( $apply_auto_convert ) {
			$value = $name;
		} else {
			if( $attr_method == 'global' ) {

				$label = get_term_meta( $term->term_id, 'label', true );
				$label = $label ? $label : $name;
				$value = get_term_meta( $term->term_id,'product_'.$attribute, true );
				$value  = empty( $value ) ? $name : $value;	

			} else {

				$term_settings = isset( $local_settings[$name] ) ? $local_settings[$name] : '';
				$value = $term_settings && isset( $term_settings['term_value'] ) ? $term_settings['term_value'] : '';
				$value = empty( $value ) && isset( $term_settings['name'] ) ? $term_settings['name'] : $value;
				$value = empty( $value ) &&  $term  ? $term : $value;
			}
		}

		$html = '<li class="thwvsf-wrapper-item-li thwvsf-label-li thwvsf-div thwvsf-checkbox attribute_'.esc_attr( $id ).' '. esc_attr( $attr_class ).' '.esc_attr( $design_class ).' '.esc_attr( $selected ).' thwvsf-tooltip" data-attribute_name="attribute_'.esc_attr( $id ).'" data-value="'.esc_attr( $data_val ).'" title="'.esc_attr( $name ).'">
				'.$tt_html.'
			<span class=" thwvsf-item-span item-span-text ">'.esc_html( $value ).'</span>	
			</li>';

		return $html; 
	}

	public function default_variation_field( $html,$args,$attr,$design_type ) {
		$args = wp_parse_args( apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ), [
			'options'			=> false,
			'attribute'			=> false,
			'product'			=> false,
			'selected'			=> false,
			'name'				=> '',
			'id'				=> '',
			'class'				=> '',
			'show_option_none'	=> __( 'Choose an option', 'woocommerce' ),
		] );

		// Get selected value.
		if ( false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product ) {
			$selected_key     = 'attribute_' . sanitize_title( $args['attribute'] );
			$args['selected'] = isset( $_REQUEST[ $selected_key ] ) ? wc_clean( wp_unslash( $_REQUEST[ $selected_key ] ) ) : $args['product']->get_variation_default_attribute( $args['attribute'] ); // WPCS: input var ok, CSRF ok, sanitization ok.
		}

		$options               = $args['options'];
		$product               = $args['product'];
		$attribute             = $args['attribute'];
		$name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
		$id                    = $args['id'] ? $args['id'] : sanitize_title( $attribute );
		$class                 = $args['class'];
		$show_option_none      = ( bool ) $args['show_option_none'];
		$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option', 'woocommerce' ); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

		if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[ $attribute ];
		}

		$html  = '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" data-design_type="'.esc_attr( $design_type ).'" style="display:none" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '" >';
		$html .= '<option value="">' . esc_html( $show_option_none_text ) . '</option>';

		if ( ! empty( $options ) ) {
			if ( $product && taxonomy_exists( $attribute ) ) {
				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms = wc_get_product_terms( $product->get_id(), $attribute, [
					'fields' => 'all',
				] );

				foreach ( $terms as $term ) {
					if ( in_array( $term->slug, $options, true ) ) {
						$html .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</option>';
					}
				}
			} else {
				foreach ( $options as $option ) {
					
					$selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
					$html    .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
				}
			}
		}

		$html .= '</select>';
		return $html;
	}

}

endif;

