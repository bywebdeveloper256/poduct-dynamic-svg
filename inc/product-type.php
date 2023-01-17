<?php
//Register the class to add the product type "dynamic product"
add_action( 'plugins_loaded', 'ps_register_dynamic_product_type' );
function ps_register_dynamic_product_type () {

	class WC_Product_Dynamic_Product extends WC_Product {

		public function __construct( $product )
        {
			$this->product_type = 'dynamic_product';
			parent::__construct( $product );
		}
    }
}

//Add the product type "dynamic product" to the select
add_filter( 'product_type_selector', 'ps_add_dynamic_product_type' );
function ps_add_dynamic_product_type ( $type )
{
	$type[ 'dynamic_product' ] = __( 'PS Dynamic Product', bwd_plugin_data( 'TextDomain' ) );
	return $type;
}

//Add the tabs "Attribute DP", "Variations DP" and "Colors DP" to the product type "Dynamic Product"
add_filter( 'woocommerce_product_data_tabs', 'ps_dynamic_product_tab' );
function ps_dynamic_product_tab( $tabs )
{
	$tabs['ps_attributes_dp'] = array(
		'label'	 => __( 'Attributes DP', bwd_plugin_data( 'TextDomain' ) ),
		'target' => 'ps_attributes_dp_option',
		'class'  => ('show_if_dynamic_product'),
	);
    $tabs['ps_variations_dp'] = array(
		'label'	 => __( 'Variations DP', bwd_plugin_data( 'TextDomain' ) ),
		'target' => 'ps_variations_dp_options',
		'class'  => ('show_if_dynamic_product'),
	);
	$tabs['ps_colors_dp'] = array(
		'label'	 => __( 'Colors DP', bwd_plugin_data( 'TextDomain' ) ),
		'target' => 'ps_colors_dp_options',
		'class'  => ('show_if_dynamic_product'),
	);
	return $tabs;
}

//Custom js to show "general" and inventory tab, and hide WC "Attributes" tab for "Dynamic Product" product type
add_action( 'admin_footer', 'ps_dynamic_product_custom_js' );
function ps_dynamic_product_custom_js()
{
	if ( 'product' != get_post_type() ) return;
	?><script type='text/javascript'>
		jQuery( document ).ready( function($)
        {
            $( '.general_options.general_tab' ).addClass( 'show_if_simple show_if_dynamic_product show_if_external' ).show();
			$( '.options_group.pricing' ).addClass( 'show_if_dynamic_product' ).show();
            $( '.inventory_options.inventory_tab' ).addClass( 'show_if_dynamic_product' ).show();
            $( '._manage_stock_field' ).addClass( 'show_if_dynamic_product' ).show();
			$( '.attribute_options.attribute_tab' ).addClass( 'hide_if_dynamic_product' ).hide();
		});
	</script><?php
}

//Content for the Attributes DP tab
add_action( 'woocommerce_product_data_panels', 'ps_attributes_options_product_tab_content' );
function ps_attributes_options_product_tab_content()
{
	?>
		<div id='ps_attributes_dp_option' class='panel woocommerce_options_panel'>
			<div class='options_group p-3'>
				<?php if( isset( $_GET['post'] ) && !empty($_GET['post']) ){ ?>
					<div class="table-responsive">
						<table class="table" id="ps_list_attributes_dp">
							<colgroup>
								<col span="1" style="min-width:150px">
							</colgroup>
							<thead>
								<tr>
									<th scope="col"><?php esc_html_e('Name', bwd_plugin_data( 'TextDomain' ) ) ?></th>
									<th scope="col" class="text-center"><?php esc_html_e('SVG', bwd_plugin_data( 'TextDomain' ) ) ?></th>
									<th scope="col" class="text-center"><?php esc_html_e('Colors', bwd_plugin_data( 'TextDomain' ) ) ?></th>
									<th scope="col" class="text-center"><?php esc_html_e('Delete', bwd_plugin_data( 'TextDomain' ) ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
									$attributes = get_post_meta( $_GET['post'], 'ps_attributes_dp', true );

									if( !empty($attributes) ){
										foreach ( $attributes as $value )
										{ 
											require INC_FOLDER_PATH . 'templates/items/items-attributes.php';
										}
									}
								?>
							</tbody>
						</table>
					</div>
					<button type="button" typeItems="attributes" context="addAttributes" class="button button-primary button-large add_items_dp"><?php esc_html_e('Add attributes', bwd_plugin_data( 'TextDomain' ) ) ?></button>
					<button type="button" typeItems="attributes" context="saveAttributes" class="button button-primary button-large save_items_dp" post="<?php echo $_GET['post'] ?>"><?php esc_html_e('Save', bwd_plugin_data( 'TextDomain' ) ) ?></button>
				<?php }else{ ?>
					<p style="color:red">
						<?php esc_html_e('First save the product to start adding attributes, variations and colors.', bwd_plugin_data( 'TextDomain' ) ) ?>
					</p>
				<?php } ?>
			</div>
		</div>
	<?php
}

//Content for the variation DP tab
add_action( 'woocommerce_product_data_panels', 'ps_variations_options_product_tab_content' );
function ps_variations_options_product_tab_content()
{
	$post_id =  isset( $_GET['post'] ) ? $_GET['post'] : '';
	?>
		<div id='ps_variations_dp_options' class='panel woocommerce_options_panel'>
			<div class='options_group p-3'>
				<?php if( !empty( $post_id ) ){ ?>
					<div class="accordion" id="ps_list_variations_dp">
						<?php
							$attributes = get_post_meta( $_GET['post'], 'ps_attributes_dp', true );

							if( !empty($attributes)){
								foreach ( $attributes as $value )
								{ 
									require INC_FOLDER_PATH . 'templates/items/items-accordion-variations.php';
								}
							}
						?>
					</div>
					<button type="button" context="saveVariations" class="button button-primary button-large save_items_dp" post="<?php echo $_GET['post'] ?>"><?php esc_html_e('Save variations', bwd_plugin_data( 'TextDomain' ) ) ?></button>
				<?php }else{ ?>
					<p style="color:red">
						<?php esc_html_e('First save the product to start adding attributes, variations and colors.', bwd_plugin_data( 'TextDomain' ) ) ?>
					</p>
				<?php } ?>
			</div>
		</div>
	<?php
}

//Content for the color DP tab
add_action( 'woocommerce_product_data_panels', 'ps_colors_options_product_tab_content' );
function ps_colors_options_product_tab_content()
{
	?>
		<div id='ps_colors_dp_options' class='panel woocommerce_options_panel'>
			<div class='options_group p-3'>
				<?php if( isset( $_GET['post'] ) && !empty($_GET['post']) ){ ?>
					<div class="table-responsive">
						<table class="table" id="ps_list_colors_dp">
							<colgroup>
								<col span="1" style="min-width:150px">
							</colgroup>
							<thead>
								<tr>
									<th scope="col"><?php esc_html_e('Name', bwd_plugin_data( 'TextDomain' ) ) ?></th>
									<th scope="col"><?php esc_html_e('Price', bwd_plugin_data( 'TextDomain' ) ) ?></th>
									<th scope="col" class="text-center"><?php esc_html_e('Color', bwd_plugin_data( 'TextDomain' ) ) ?></th>
									<th scope="col" class="text-center"><?php esc_html_e('Stock', bwd_plugin_data( 'TextDomain' ) ) ?></th>
									<th scope="col" class="text-center"><?php esc_html_e('Delete', bwd_plugin_data( 'TextDomain' ) ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
									$colors = get_post_meta( $_GET['post'], 'ps_colors_dp', true );

									if( !empty($colors) ){
										foreach ( $colors as $value )
										{ 
											require INC_FOLDER_PATH . 'templates/items/items-colors.php';
										}
									}
								?>
							</tbody>
						</table>
					</div>
					<button type="button" typeItems="colors" context="addColors" class="button button-primary button-large add_items_dp"><?php esc_html_e('Add Colors', bwd_plugin_data( 'TextDomain' ) ) ?></button>
					<button type="button" typeItems="colors" context="saveColors" class="button button-primary button-large save_items_dp" post="<?php echo $_GET['post'] ?>"><?php esc_html_e('Save colors', bwd_plugin_data( 'TextDomain' ) ) ?></button>

					<div class="table-responsive">
						<table class="table" id="ps_list_colors_variations_dp">
							<colgroup>
								<col span="1" style="min-width:150px">
							</colgroup>
							<thead>
								<tr>
									<th scope="col"><?php esc_html_e('Text Button', bwd_plugin_data( 'TextDomain' ) ) ?></th>
									<th scope="col"><?php esc_html_e('Fill ID', bwd_plugin_data( 'TextDomain' ) ) ?></th>
									<th scope="col" ><?php esc_html_e('Variations', bwd_plugin_data( 'TextDomain' ) ) ?></th>
									<th scope="col" class="text-center"><?php esc_html_e('Delete', bwd_plugin_data( 'TextDomain' ) ) ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
									$CV = get_post_meta( $_GET['post'], 'ps_colors_variations_dp', true );
									
									if( !empty($CV) ){
										foreach ( $CV as $value )
										{ 
											require INC_FOLDER_PATH . 'templates/items/items-colors-variations.php';
										}
									}
								?>
							</tbody>
						</table>
					</div>
					<button type="button" class="button button-primary button-large" onclick="add_items( 'addIdsColor', this )"><?php esc_html_e('Add IDs', bwd_plugin_data( 'TextDomain' ) ) ?></button>
					<button type="button" class="button button-primary button-large" onclick="dp_save_items( 'saveIdsColor', <?php echo $_GET['post'] ?> )"><?php esc_html_e('Save IDs', bwd_plugin_data( 'TextDomain' ) ) ?></button>
				<?php }else{ ?>
					<p style="color:red">
						<?php esc_html_e('First save the product to start adding attributes, variations and colors.', bwd_plugin_data( 'TextDomain' ) ) ?>
					</p>
				<?php } ?>
			</div>
		</div>
	<?php
}

add_action( "woocommerce_dynamic_product_add_to_cart", function() {
	global $product;
    do_action( 'woocommerce_simple_add_to_cart' );
	echo '<div id="content-values">';
	echo '<input type="hidden" name="dp_add_to_cart">';
	echo '<input type="hidden" name="dp_price" value="'.$product->get_price().'">';
	echo '<input type="hidden" name="dp_get_currency_symbol" value="'.get_woocommerce_currency_symbol().'">';
	echo '</div>';
});