<?php
/**
* The admin-specific functionality of the plugin.
*
* @package Deep
*/
if ( ! defined( 'WPINC' ) ) { die; }

if ( ! class_exists( 'THWVSF_Admin' ) ) :
	class THWVSF_Admin {
		
		private $plugin_name;
		
		private $version;
		
		private $taxonomy;
		
		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 * @param      string    $plugin_name       The name of this plugin.
		 * @param      string    $version    The version of this plugin.
		 */
		public function __construct( $plugin_name, $version ) {
			$this->plugin_name = $plugin_name;
			$this->version = $version;

			add_action( 'admin_init', [$this,'define_admin_hooks'] );
		}

		public function enqueue_styles_and_scripts( $hook ) {
			if( strpos( $hook, 'product_page_th_product_variation_swatches_for_woocommerce' ) === false ){
				if( !( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'edit-tags.php' || $hook == 'term.php' || $hook == 'product_page_product_attributes' ) ){
					return;
				}
			}
			
			$this->enqueue_styles( $hook );
			$this->enqueue_scripts();
		}

		private function enqueue_styles( $hook ) {
			wp_enqueue_style( 'woocommerce_admin_styles', THWVSF_WOO_ASSETS_URL.'css/admin.css' );
			wp_enqueue_style( 'thwvsf-admin-style', THWVSF_ASSETS_URL_ADMIN . 'css/thwvsf-admin.css', $this->version );
		}

		private function enqueue_scripts() {
			$deps = ['jquery', 'jquery-ui-dialog', 'jquery-tiptip','wc-enhanced-select', 'select2', 'wp-color-picker'];
			wp_enqueue_media();
			wp_enqueue_script( 'thwvsf-admin-script', THWVSF_ASSETS_URL_ADMIN . 'js/thwvsf-admin.js', $deps, $this->version, false ); 

			$thwvsf_var = [
				'admin_url'         => admin_url(),
				'admin_path'        => plugins_url( '/', __FILE__ ),
				'ajaxurl'           => admin_url( 'admin-ajax.php' ),
				'ajax_banner_nonce' => wp_create_nonce( 'thwvsf_upgrade_notice' ),
				'placeholder_image' => THWVSF_ASSETS_URL_ADMIN . '/images/placeholder.svg',
				'upload_image'      => esc_url( THWVSF_ASSETS_URL_ADMIN .'/images/upload.svg' ),
				'remove_image'      =>  esc_url( THWVSF_ASSETS_URL_ADMIN .'/images/remove.svg' ),
			];
			
			wp_localize_script( 'thwvsf-admin-script', 'thwvsf_var', $thwvsf_var );
		}

		public function add_screen_id( $ids ){
			$ids[] = 'woocommerce_page_th_product_variation_swatches_for_woocommerce';
			$ids[] = strtolower( __( 'WooCommerce', 'woocommerce' ) ) .'_page_th_product_variation_swatches_for_woocommerce';
			return $ids;
		}
		
		public function define_admin_hooks(){
			$this->cell_props_L = [
				'label_cell_props'	=> 'width="23%"', 
				'input_cell_props'	=> 'width="20%"', 
				'input_width'		=> '200px',
			];
	
			add_filter( 'product_attributes_type_selector', [$this,'add_attribute_types'] );

			$attribute_taxonomies = wc_get_attribute_taxonomies();
			$this->attr_taxonomies = $attribute_taxonomies;

			foreach ( $attribute_taxonomies as $tax ) {
				$this->product_attr_type = $tax->attribute_type;
				add_action( 'pa_' . $tax->attribute_name . '_add_form_fields', [$this, 'add_attribute_fields'] );
				add_action( 'pa_' . $tax->attribute_name . '_edit_form_fields', [$this, 'edit_attribute_fields'], 10, 2 );
				add_filter( 'manage_edit-pa_'.$tax->attribute_name.'_columns', [$this, 'add_attribute_column'] );
				add_filter( 'manage_pa_' . $tax->attribute_name . '_custom_column', [$this, 'add_attribute_column_content'], 10, 3 );
			}
			add_action( 'created_term', [$this, 'save_term_meta'], 10, 3 );
			add_action( 'edit_term', [$this, 'save_term_meta'], 10, 3 );

			add_action( 'woocommerce_product_options_attributes', [$this,'thwvsf_popup_fields'] );
			add_action( 'woocommerce_product_option_terms', [$this,'thwvsf_product_option_terms'], 20, 2 );

			add_filter( 'woocommerce_product_data_tabs', [$this,'new_tabs_for_swatches_settings'] );
			add_action( 'woocommerce_product_data_panels', [$this,'output_custom_swatches_settings'] );
			add_action( 'woocommerce_process_product_meta', [$this, 'save_custom_fields'], 10, 2 );
		}

		public function add_attribute_types( $types ) {
			$more_types = [
				'color' => __( 'Color', 'deep' ),
				'image' => __( 'Image', 'deep' ),
				'label' => __( 'Button/Label', 'deep' ),  
			];

			$types = array_merge( $types, $more_types );
			return $types;
		}

		public function add_attribute_fields( $taxonomy ){

			$attribute_type = $this->get_attribute_type( $taxonomy );
			$this->product_attribute_fields( $taxonomy,$attribute_type, 'new', 'add' );                       
		}

		public function edit_attribute_fields( $term, $taxonomy ){
			$attribute_type  = $this->get_attribute_type( $taxonomy );
			$term_fields     = [];
			$term_type_field = get_term_meta( $term->term_id,'product_'.$taxonomy, true );

			$term_fields = [
				'term_type_field' => $term_type_field ? $term_type_field : '',
			];
			$this->product_attribute_fields( $taxonomy,$attribute_type, $term_fields,'edit' );
		}

		public function get_attribute_type( $taxonomy ){
			foreach ( $this->attr_taxonomies as $tax ) {
				if( 'pa_'.$tax->attribute_name == $taxonomy ){
					return( $tax->attribute_type );
					break;
				}
			}
		}

		public function product_attribute_fields( $taxonomy, $type, $value, $form ){
			switch ( $type ) {
				case 'color':
					$this->add_color_field( $value,$taxonomy );
					break;
				case 'image':
					$this->add_image_field( $value,$taxonomy );
					break;
				case 'label' :
					$this->add_label_field( $value,$taxonomy );
					break;
				default:
					break;
			}
		}

		private function add_color_field( $value, $taxonomy ){
			$term_type_field	= is_array( $value ) && $value['term_type_field'] ? $value['term_type_field']:'';
			$label				= __( 'Color', 'deep' );

			if( $value == 'new' ) { 
				?>  
				<div class="thwvsf-types gbl-attr-color gbl-attr-terms gbl-attr-terms-new">
					<label><?php echo esc_html( $label ); ?></label>
					<div class="thwvsf_settings_fields_form thwvs-col-div">
						<span class="thpladmin-colorpickpreview color_preview"></span>
						<input type="text" name="<?php echo'product_'.esc_attr( $taxonomy ) ; ?>" autocomplete="off" class="thpladmin-colorpick"/>
					</div> 
				</div>
				<?php

			} else {
				?>
				<tr class="gbl-attr-terms gbl-attr-terms-edit" > 
					<th><?php echo esc_html( $label ); ?></th>
					<td>
						<div class="thwvsf_settings_fields_form thwvs-col-div">
							<span class="thpladmin-colorpickpreview color_preview" style="background:<?php echo esc_attr( $term_type_field ) ?>;"></span>
							<input type="text"  name= "<?php echo'product_'.esc_attr( $taxonomy ); ?>" autocomplete="off" class="thpladmin-colorpick" value="<?php echo esc_attr( $term_type_field ) ?>"/>
						</div>         
					</td>
				</tr> 
				<?Php
			}
		}

		private function add_image_field( $value, $taxonomy ){
			$image = is_array( $value ) && $value['term_type_field'] ? wp_get_attachment_image_src( $value['term_type_field'] ) : '';
			$image = $image ? $image[0] : THWVSF_ASSETS_URL_ADMIN . '/images/placeholder.svg';
			$label = __( 'Image', 'deep' );

			if( $value == 'new' ){ 
				?>
				<div class="thwvsf-types gbl-attr-img gbl-attr-terms gbl-attr-terms-new">
					<div class='thwvsf-upload-image'>
						<label><?php echo esc_html( $label ); ?></label>
						<div class="tawcvs-term-image-thumbnail">
							<img class="i_index_media_img" src="<?php echo ( esc_url( $image ) ); ?>" width="50px" height="50px" alt="term-image"/>  <?php  ?>
						</div>
						<div style="line-height:60px;">
							<input type="hidden" class="i_index_media" name="product_<?php echo esc_attr( $taxonomy ) ?>" value="">
			
							<button type="button" class="thwvsf-upload-image-button button " onclick="thwvsf_upload_icon_image( this,event )">
								<span class="thwvsf-upload-button"><?php echo __( 'Upload', 'deep' ); ?></span>
							</button>

							<button type="button" style="display:none" class="thwvsf_remove_image_button button " onclick="thwvsf_remove_icon_image( this,event )">
								<span class="thwvsf-remove-button"><?php echo __( 'Remove', 'deep' ); ?></span>
							</button>
						</div>
					</div>
				</div>
				<?php 

			} else {
				?>
				<tr class="form-field gbl-attr-img gbl-attr-terms gbl-attr-terms-edit">
					<th><?php echo esc_html( $label ); ?></th>
					<td>
						<div class = 'thwvsf-upload-image'>
							<div class="tawcvs-term-image-thumbnail">
								<img  class="i_index_media_img" src="<?php echo ( esc_url( $image ) ); ?>" width="50px" height="50px" alt="term-image"/>  <?php  ?>
							</div>
							<div style="line-height:60px;">
								<input type="hidden" class="i_index_media"  name= "product_<?php echo esc_attr( $taxonomy ) ?>" value="">
				
								<button type="button" class="thwvsf-upload-image-button  button" onclick="thwvsf_upload_icon_image( this,event )">
									<span class="thwvsf-upload-button"><?php echo __( 'Upload', 'deep' ); ?></span>
								</button>

								<button type="button" style="<?php echo ( is_array( $value ) && $value['term_type_field']  ? '' :'display:none' ); ?> "  class="thwvsf_remove_image_button button " onclick="thwvsf_remove_icon_image( this,event )">
									<span class="thwvsf-remove-button"><?php echo __( 'Remove', 'deep' ); ?></span>
								</button>
							</div>
						</div>
					</td>
				</tr> 
				<?Php
			}   
		}

		public function add_label_field( $value, $taxonomy ){  

			$label = __( 'Label', 'deep' );
			if( $value == 'new' ){
				?>
				<div class="thwvsf-types gbl-attr-label gbl-attr-terms gbl-attr-terms-new">
					<label><?php echo esc_html( $label ); ?></label> 
					<input type="text" class="i_label" name="product_<?php echo esc_attr( $taxonomy ) ?>" value="" />
				</div>
				<?php
			}else{
				?>
				<tr class="form-field gbl-attr-label gbl-attr-terms gbl-attr-terms-edit" > 
					<th><?php echo  esc_html( $label ); ?></th>
					<td>
						<input type="text" class="i_label" name="product_<?php echo esc_attr( $taxonomy ) ?>" value="<?php echo esc_attr( $value['term_type_field'] ) ?>" />
					</td>
				</tr> 
				<?Php
			} 
		}

		public function save_term_meta( $term_id, $tt_id, $taxonomy ){
			if( isset( $_POST['product_'.$taxonomy] )  && !empty( $_POST['product_'.$taxonomy] ) ){
				update_term_meta( $term_id,'product_'.$taxonomy, wc_clean( wp_unslash( $_POST['product_'.$taxonomy] ) ) );
			}   
		}

		public function add_attribute_column( $columns ){
			$new_columns = [];

			if ( isset( $columns['cb'] ) ) {
				$new_columns['cb'] = $columns['cb'];
				unset( $columns['cb'] );
			}

			$new_columns['thumb'] = __( '', 'woocommerce' );

			$columns = array_merge( $new_columns, $columns );
		
			return $columns;
		}

		public function add_attribute_column_content( $columns, $column, $term_id ){
			$taxonomy = $_REQUEST['taxonomy'];
			$attr_type = $this->get_attribute_type( $_REQUEST['taxonomy'] );

			$value = get_term_meta( $term_id,'product_'.$taxonomy,true );

			switch ( $attr_type ) {
				case 'color':
					printf( '<span class="th-term-color-preview" style="width: 50px; height: 50px; display: inline-block;background-color:%s;"></span>', esc_attr( $value ) );
					break;

				case 'image':
					$image = $value ? wp_get_attachment_image_src( $value ) : '';
					$image = $image ? $image[0] : THWVSF_URL . 'admin/assets/images/placeholder.png';
					printf( '<img class="swatch-preview swatch-image" src="%s" width="44px" height="44px" alt="preview-image">', esc_url( $image ) );
					break;

				case 'label':
					printf( '<div class="swatch-preview swatch-label" style=" width: 50px; height: 50px; display: inline-block; background-color: #f1f1f1; line-height: 50px; ">%s</div>', esc_html( $value ) );
					break;
			}
		}

		public function get_attribute_by_taxonomy( $taxonomy ){

			global $wpdb;
			$attr = substr( $taxonomy, 3 );
			$attr = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '$attr'" );
		}

		public function thwvsf_product_option_terms( $attribute_taxonomy, $i ) {

			if ( 'select' !== $attribute_taxonomy->attribute_type ) {
				global $post, $thepostid, $product_object;
				$taxonomy = wc_attribute_taxonomy_name( $attribute_taxonomy->attribute_name );
				
				$product_id = $thepostid;
				if ( is_null( $thepostid ) && isset( $_POST[ 'post_id' ] ) ) {
					$product_id = absint( $_POST[ 'post_id' ] );
				}

				?>
				<select multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'woocommerce' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo esc_attr( $i ); ?>][]">
					<?php
						$args		= [
							'orderby'		=> 'name',
							'hide_empty'	=> 0,
						];
						$all_terms = get_terms( $taxonomy, apply_filters( 'woocommerce_product_attribute_terms', $args ) );
					
						if ( $all_terms ) :
							$options = [];
							foreach ( $all_terms as $key ) {
								$options[] = $key->term_id;
							}

							foreach ( $all_terms as $term ) :
							
								$options = ! empty( $options ) ? $options : [];

								echo '<option value="' . esc_attr( $term->term_id ) . '" ' . wc_selected( has_term( absint( $term->term_id ), $taxonomy, $product_id ), true, false ) . '>' . esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
							endforeach;
						endif;
					?>
				</select>
			
				<button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'woocommerce' ); ?></button>
				<button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'woocommerce' ); ?></button>
				
				<?php
				$taxonomy = wc_attribute_taxonomy_name( $attribute_taxonomy->attribute_name );
				$attr_type = $attribute_taxonomy->attribute_type;

				if ( (  $attribute_taxonomy->attribute_type == 'label' || $attribute_taxonomy->attribute_type == 'image' || $attribute_taxonomy->attribute_type == 'color' ) ){ ?>
					<button class="button fr plus thwvsf_add_new_attribute"  data-attr_taxonomy="<?php echo esc_attr( $taxonomy ); ?>"  data-attr_type="<?php echo esc_attr( $attr_type )?>"  data-dialog_title="<?php printf( esc_html__( 'Add new %s', '' ), esc_attr( $attribute_taxonomy->attribute_label ) ) ?>">  <?php esc_html_e( 'Add new', '' ); ?>  </button> 

				<?php  

				}else{?>
					<button class="button fr plus add_new_attribute"><?php esc_html_e( 'Add new', 'woocommerce' ); ?></button> <?php
				}
			}
		}

		public function new_tabs_for_swatches_settings( $tabs ){
			$tabs['thwvs_swatches_settings']     = [
				'label'		=> __( 'Swatches Settings', 'deep' ),
				'target'	=> 'thwvs-product-attribute-settings',
				'priority'	=> 65,
				'class'		=> [
					'variations_tab',
					'show_if_variable',
				],
			];
			return $tabs;
		}

		public function output_custom_swatches_settings(){
			
			global $post, $thepostid, $product_object,$wc_product_attributes;

			$saved_settings = get_post_meta( $thepostid,'th_custom_attribute_settings', true );

			$type_options = [
				'select' =>  __( 'Select', 'deep' ), 
				'color'  =>  __( 'Color', 'deep' ),
				'label'  =>  __( 'Button/Label', 'deep' ),
				'image'  =>  __( 'Image' , 'deep' ),
			];

			$default_design_types = THWVSF_Admin_Utils::$sample_design_labels;
			$designs = THWVSF_Admin_Utils::get_design_styles();
			$design_types = $designs ?  $designs : $default_design_types;

			?>
			<div id="thwvs-product-attribute-settings" class="panel wc-metaboxes-wrapper hidden">
				<div id="custom_variations_inner">
					<h2><?php esc_html_e( 'Custom Attribute Settings', 'deep' ); ?></h2>
					
					<?php 
					$attributes = $product_object->get_attributes();
					$i = -1;
					$has_custom_attribute = false;
					
					foreach ( $attributes as $attribute ){ 
						$attribute_name = sanitize_title( $attribute->get_name() );
						$type = '';
						
						$i++;
						if ( $attribute->is_taxonomy() == false ){
							$has_custom_attribute = true;
							?>
						<div data-taxonomy="<?php echo esc_attr( $attribute->get_taxonomy() ); ?>" class="woocommerce_attribute wc-metabox closed" rel="<?php echo esc_attr( $attribute->get_position() ); ?>">
				
							<h3>
								<div class="handlediv" title="<?php esc_attr_e( 'Click to toggle', 'woocommerce' ); ?>"></div>
								<strong class="attribute_name"><?php echo wc_attribute_label( $attribute_name ); ?></strong>
							</h3>
							<div class="thwvsf_custom_attribute wc-metabox-content  <?php echo 'thwvs-'.esc_attr( $attribute_name ); ?> hidden">
								<table cellpadding="0" cellspacing="0">
									<tbody>
										<tr>
											<td colspan="2">
												
												<p class="form-row form-row-full ">
													<label for="custom_attribute_type"><?php esc_html_e( 'Swatch Type','deep' ); ?></label>
													<span class="woocommerce-help-tip" data-tip=" Determines how this custom attribute's values are displayed">
													</span>
													<!--  <?php //echo wc_help_tip( " Determines how this custom attributes are displayed" ); // WPCS: XSS ok. ?> -->
						
													<select   name="<?php echo ( 'th_attribute_type_'.esc_attr( $attribute_name ) ); ?>" class="select short th-attr-select" value = '' onchange="thwvsf_change_term_type( this,event )">
														<?php 
														$type = $this->get_custom_fields_settings( $thepostid,$attribute_name,'type' );
													
														foreach ( $type_options as $key => $value ) { 
															$default = ( isset( $type ) &&  $type == $key ) ? 'selected' : '';
															?>
															<option value="<?php echo esc_attr( $key ); ?>" <?php echo $default ?> > <?php echo esc_html( $value ); ?> </option>
														<?php
														}?>
													</select>
												
												</p>
											</td>
											
										</tr> 
										<tr> <th></th> </tr>
										
										<tr> <td> <?php  $this->custom_attribute_settings_field( $attribute,$thepostid ); ?> </td> </tr>

									</tbody>
								</table>
							</div>
						</div>
						<?php }
					}

					if( !$has_custom_attribute ){
						?>
						<div class="inline notice woocommerce-message">

							<p><?php esc_html_e( 'No custom attributes added yet.','woocommerce-product-variation-swatches' );
						esc_html_e( ' You can add custom attributes from the', 'woocommerce-product-variation-swatches' ); ?> <a onclick="thwvsfTriggerAttributeTab( this )" href="#woocommerce-product-data"><?php  esc_html_e( ' Attributes','woocommerce-product-variation-swatches' ); ?> </a> <?php esc_html_e( 'tab','woocommerce-product-variation-swatches' ); ?></p>
						</div>
					<?php
					}
					?>

				</div>
			</div> <?php
		}

		public function custom_attribute_settings_field( $attribute, $post_id ){
			$attribute_name = sanitize_title( $attribute->get_name() );
			$type = $this->get_custom_fields_settings( $post_id,$attribute_name,'type' );        
			$this->output_field_label( $type,$attribute,$post_id );
			$this->output_field_image( $type,$attribute,$post_id );
			$this->output_field_color( $type,$attribute,$post_id );
		}

		public function output_field_label( $type, $attribute, $post_id ){
			$attribute_name = sanitize_title( $attribute->get_name() );
			$display_status = $type == 'label' ?'display: table': 'display: none' ;
			?>
			<table class="thwvsf-custom-table thwvsf-custom-table-label" style="<?php echo $display_status ; ?>">
				<?php
				$i= 0;
				foreach ( $attribute->get_options() as $term ) {
					$css = $i==0 ? 'display:table-row-group' :'';
					$open = $i==0 ? 'open' :'';
					?>
					<tr class="thwvsf-term-name">
						<td colspan="2">
							<h3 class="thwvsf-local-head <?php echo $open;?>" data-type="<?php echo esc_attr( $type ); ?>" data-term_name="<?php echo  esc_attr( $term ); ?>" onclick="thwvsf_open_body( this,event )"><?php echo esc_html( $term ); ?></h3>
							<table class="thwvsf-local-body-table">
								<tbody class="thwvsf-local-body thwvsf-local-body-<?php echo esc_attr( $term ); ?>" style="<?php echo esc_attr( $css ); ?>">
									<tr> 
										<td width="30%"><?php _e( 'Term Name', 'deep' ) ?></td>
										<td width="70%"><?php echo esc_html( $term ); ?></td>
									</tr>
									<tr class="form-field"> 
										<td><?php esc_html_e( 'Label Text', 'deep' ) ?></td>
										<td>
											<?php $term_field = $type == 'label' ? $this->get_custom_fields_settings( $post_id,$attribute_name,$term,'term_value' ) : ''; 
												$term_field = ( $term_field ) ? $term_field : '';
											?>
											<input type="text" class="i_label" name="<?php echo esc_attr( sanitize_title( 'label_'.$attribute_name.'_term_'.$term ) ); ?>" style="width:275px;" value="<?php echo esc_attr( $term_field ); ?>">
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					
					<?php 
					$i++;
				}
				?>
			</table>
			<?php
		}

		public function output_field_image( $type, $attribute, $post_id ){
			$attribute_name = sanitize_title( $attribute->get_name() );
			$display_status = $type == 'image' ?'display:table': 'display: none' ;
			?>
			<table class="thwvsf-custom-table thwvsf-custom-table-image" style="<?php echo esc_attr( $display_status ); ?>">
			<?php
				$i = 0;
				foreach ( $attribute->get_options() as $term ) {
					$css = $i==0 ? 'display:table-row-group' :'';
					$open = $i==0 ? 'open' :'';
					?>
					<tr class="thwvsf-term-name">
						<td colspan="2">
							<h3 class="thwvsf-local-head <?php echo $open;?>" data-term_name="<?php echo $term; ?>" onclick="thwvsf_open_body( this,event )"><?php echo esc_html( $term ); ?></h3>
							<table class="thwvsf-local-body-table">
								<tbody class="thwvsf-local-body thwvsf-local-body-<?php echo esc_attr( $term ); ?>" style="<?php echo $css; ?>">
									<tr> 
										<td width="30%">Term Name</td>
										<td width="70%"><?php echo $term; ?></td>
									</tr>
									<tr class="form-field"> <td><?php _e( 'Term Image', 'deep' ) ?></td>
										<td>
											<?php $term_field = $this->get_custom_fields_settings( $post_id,$attribute_name,$term,'term_value' ); 

												$term_field = ( $term_field ) ? $term_field : '';

												$image =  $type == 'image' ?  $this->get_custom_fields_settings( $post_id,$attribute_name,$term,'term_value' ) : ''; 
												$image = ( $image ) ? wp_get_attachment_image_src( $image ) : ''; 
												$remove_img = ( $image )  ? 'display:inline' :'display:none';
												// $image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
												$image = $image ? $image[0] : THWVSF_ASSETS_URL_ADMIN . '/images/placeholder.svg';
											?>

											<div class = 'thwvsf-upload-image'>
										
												<div class="tawcvs-term-image-thumbnail" style="float:left;margin-right:10px;">
													<img  class="i_index_media_img" src="<?php echo ( esc_url( $image ) ); ?>" width="60px" height="60px" alt="term-image"/>  <?php  ?>
												</div>

												<div style="line-height:30px;">
													<input type="hidden" class="i_index_media"  name= "<?php echo esc_attr( sanitize_title( 'image_'.$attribute_name.'_term_'.$term ) ); ?>" value="<?php echo $term_field; ?>">
									
													<button type="button" class="thwvsf-upload-image-button button " onclick="thwvsf_upload_icon_image( this,event )">
														<span class="thwvsf-upload-button"><?php echo __( 'Upload', 'deep' ); ?></span>
													</button>
													<button type="button" style="<?php echo $remove_img; ?>" class="thwvsf_remove_image_button button " onclick="thwvsf_remove_icon_image( this,event )">
														<span class="thwvsf-remove-button"><?php echo __( 'Remove', 'deep' ); ?></span>
													</button> 
													
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					
					<?php
					$i++;
				}?>    
			</table>
			<?php
		}

		public function output_field_color( $type, $attribute, $post_id ){

			$attribute_name = sanitize_title( $attribute->get_name() );
			$display_status = $type == 'color' ?'display: table': 'display: none' ;
			?>
			<table class="thwvsf-custom-table thwvsf-custom-table-color" style="<?php echo $display_status; ?>">
				<?php
				$i = 0;
				foreach ( $attribute->get_options() as $term ) {
					$css = $i==0 ? 'display:table-row-group' :'';
					$open = $i==0 ? 'open' :'';
					?>
					<tr class="thwvsf-term-name">
						<td colspan="2">
							<h3 class="thwvsf-local-head <?php echo $open;?>" data-term_name="<?php echo esc_attr( $term ); ?>" onclick="thwvsf_open_body( this,event )"><?php echo esc_html( $term ); ?></h3>
							<table class="thwvsf-local-body-table">
								<tbody class="thwvsf-local-body thwvsf-local-body-<?php echo $term; ?>" style="<?php echo $css; ?>">
									<tr>
										<td width="30%"><?php esc_html_e( 'Term Name', 'deep' ) ?></td>
										<td width="70%"><?php echo esc_html( $term ); ?></td>
									</tr>
									<?php 
									$color_type = $this->get_custom_fields_settings( $post_id,$attribute_name,$term,'color_type' );
									$color_type = $color_type ? $color_type : '';
									?>

									<tr>
										<td>Term Color</td>
										<td class = "th-custom-attr-color-td"><?php
											$term_field = $type == 'color' ? $this->get_custom_fields_settings( $post_id,$attribute_name,$term,'term_value' ) : ''; 
											$term_field = ( $term_field ) ? $term_field : '' ; ?>

											<div class="thwvsf_settings_fields_form thwvs-col-div" style="margin-bottom: 5px">
												<span class="thpladmin-colorpickpreview color_preview" style="background-color: <?php echo $term_field; ?> ;"></span>
												<input type="text"   name= "<?php echo esc_attr( sanitize_title( 'color_'.$attribute_name.'_term_'.$term ) ); ?>" autocomplete="off" class="thpladmin-colorpick" value="<?php echo esc_attr( $term_field ); ?>" style="width:250px;"/>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<?php
					$i++;
				} ?>
			</table><?php
		}

		public function get_custom_fields_settings( $post_id, $attribute=false, $term=false, $term_key=false ){

			$saved_settings = get_post_meta( $post_id,'th_custom_attribute_settings', true );

			if( is_array( $saved_settings ) ){
				if( $attribute ){
					if( isset( $saved_settings[$attribute] ) ){
						$attr_settings = $saved_settings[$attribute];

						if( is_array( $attr_settings ) && $term ){
							if( $term === 'type' || $term ==='tooltip_type' || $term ==='radio-type' ||  $term ==='design_type' ){
								$term_types =  ( isset( $attr_settings[$term] ) ) ?   $attr_settings[$term] :  false;
								return $term_types; 
							} else {
								$term_settings = isset( $attr_settings[$term] ) ? $attr_settings[$term] : '';
								if( is_array( $term_settings ) && $term_key ){
									$settings_value = isset( $term_settings[$term_key] ) ? $term_settings[$term_key]: '';
									return  $settings_value;
								}else{
									return false;
								}
								return $term_settings;
							}                       
						}
						return $attr_settings;
					}
					return false;
				}
				return $saved_settings;
			}else{
				return false;
			}
		}
	
		public function thwvsf_popup_fields(){
		
			$image = THWVSF_ASSETS_URL_ADMIN . '/images/placeholder.svg';
			?>
			<div class="thwvsf-attribte-dialog thwvsf-attribte-dialog-color " style = "display:none;">
				<table>
		
					<tr>
						<td><span><?php _e( 'Name:', 'deep' );?></span></td>
						<td><input type="text"  name= "attribute_name" class="thwvsf-class" value="" style="width:225px; height:40px;"/></td>
					</tr>
					<tr>
						<td><span><?php _e( 'Color:', 'deep' );?></span></td>
						<td class="locl-attr-terms">
							<div class="thwvsf_settings_fields_form thwvs-col-div">
								<span class="thpladmin-colorpickpreview color_preview"></span>
								<input type="text" name= "attribute_type" class="thpladmin-colorpick" autocomplete="off" style="width:225px; height:40px;"/>
							</div> 
						</td>
					</tr>
				</table>
			</div>

			<div class="thwvsf-attribte-dialog thwvsf-attribte-dialog-image" style = "display:none;">
				<table>
					<tr>
						<td> <span><?php esc_html_e( 'Name:', 'deep' );?></span></td>
						<td><input type="text" name= "attribute_name" class="thwvsf-class" value="" style="width:216px"/></td>
					</tr>
					<tr valign="top">
						<td><span><?php esc_html_e( 'Image:', 'deep' );?></span> </td>
						<td>
							<div class = 'thwvsf-upload-image'>
								<div class="thwvsf-term-image-thumbnail" style="float:left; margin-right:10px;">
									<img  class="i_index_media_img" src="<?php echo ( esc_url( $image ) ); ?>" width="60px" height="60px" alt="term-images"/>
								</div>

								<input type="hidden" class="i_index_media thwvsf-class"  name= "attribute_type" value="">
								<button type="button" class="thwvsf-upload-image-button button " onclick="thwvsf_upload_icon_image( this,event )">
									<span class="thwvsf-upload-button"><?php echo __( 'Upload', 'deep' ); ?></span>
								</button>
								<button type="button" style="display:none" class="thwvsf_remove_image_button button " onclick="thwvsf_remove_icon_image( this,event )">
									<span class="thwvsf-remove-button"><?php echo __( 'Remove', 'deep' ); ?></span>
								</button> 
							</div>
						</td>
					</tr>
				</table>
			</div>

			<div class="thwvsf-attribte-dialog thwvsf-attribte-dialog-label" style = "display:none;">
				<table>
					<tr>
						<td><span><?php  esc_html_e( 'Name:', 'deep' );?></span></td>
						<td><input type="text" name= "attribute_name" class="thwvsf-class" value="" /></td>
					</tr>
					<tr>
						<td><span><?php  esc_html_e( 'Label:', 'deep' );?></span> </td>
						<td>
							<input type="text" name="attribute_type" class="thwvsf-class" value="" />
						</td>
					</tr>    
				</table>
			</div>

			<?php
		}

		public function save_custom_fields( $post_id, $post ){
			
			$product = wc_get_product( $post_id );
			$local_attr_settings = [];

			foreach ( $product->get_attributes() as $attribute ) {

				if ( $attribute->is_taxonomy() == false ) {

					$attr_settings         = [];
					$attr_name             = sanitize_title( $attribute->get_name() );
					$type_key              = 'th_attribute_type_'.$attr_name;
					$attr_settings['type'] = isset( $_POST[$type_key] ) ? sanitize_text_field( $_POST[$type_key] ) : '';

					$tt_key = sanitize_title( 'th_tooltip_type_'.$attr_name );
					$attr_settings['tooltip_type'] = isset( $_POST[$tt_key] ) ? sanitize_text_field( $_POST[$tt_key] ) : '';

					$design_type_key = sanitize_title( 'th_attribute_design_type_'.$attr_name );
					$attr_settings['design_type']   = isset( $_POST[$design_type_key] ) ? sanitize_text_field( $_POST[$design_type_key] ) : '';

					if( $attr_settings['type'] == 'radio' ){
					$radio_style_key = sanitize_title( $attr_name.'_radio_button_style' );
						$attr_settings['radio-type'] = isset( $_POST[$radio_style_key ] ) ? sanitize_text_field( $_POST[$radio_style_key] ) : '';
					}else{
						$term_settings = [];
						foreach ( $attribute->get_options() as $term ) {
							$term_settings['name'] = $term;

							if( $attr_settings['type'] == 'color' ){
								$color_type_key        = sanitize_title( $attr_name.'_color_type_'.$term );
								$term_settings['color_type'] = isset( $_POST[ $color_type_key] ) ? sanitize_text_field( $_POST[$color_type_key] ) : '';
							}

							$term_key = sanitize_title( $attr_settings['type'].'_'.$attr_name.'_term_'.$term );
							$term_settings['term_value'] = isset( $_POST[$term_key] ) ? sanitize_text_field( $_POST[$term_key] ): '';
							$attr_settings[$term] = $term_settings;
						}
					}

					$local_attr_settings[$attr_name] = $attr_settings;
				}
			}

			update_post_meta( $post_id,'th_custom_attribute_settings',$local_attr_settings );     
		}
	
	}
endif;