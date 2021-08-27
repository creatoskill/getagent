<?php
/**
 * @var $agent_post_meta_data
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post;
$agent_id = get_the_ID();
$agent_post_meta_data = get_post_custom( $agent_id);
$property_of_agent_layout_style = ere_get_option('property_of_agent_layout_style', 'property-grid');
$property_of_agent_items_amount = ere_get_option('property_of_agent_items_amount', 6);
$property_of_agent_image_size = ere_get_option('property_of_agent_image_size', '330x180');
$property_of_agent_show_paging = ere_get_option('property_of_agent_show_paging', array());

$property_of_agent_column_lg = ere_get_option('property_of_agent_column_lg', '3');
$property_of_agent_column_md = ere_get_option('property_of_agent_column_md', '3');
$property_of_agent_column_sm = ere_get_option('property_of_agent_column_sm', '2');
$property_of_agent_column_xs = ere_get_option('property_of_agent_column_xs', '1');
$property_of_agent_column_mb = ere_get_option('property_of_agent_column_mb', '1');

$custom_property_of_agent_columns_gap = ere_get_option('property_of_agent_columns_gap', 'col-gap-30');

if (!is_array($property_of_agent_show_paging)) {
	$property_of_agent_show_paging = array();
}

if (in_array("show_paging_property_of_agent", $property_of_agent_show_paging)) {
	$property_of_agent_show_paging = 'true';
} else {
	$property_of_agent_show_paging = '';
}

$agent_user_id = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_user_id']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_user_id'][0] : '';
$user = get_user_by('id', $agent_user_id);
if (empty($user)) {
	$agent_user_id = 0;
}
$ere_property = new ERE_Property();
$total_property = $ere_property->get_total_properties_by_user($agent_id, $agent_user_id);

$property_agent_shortcode = '[ere_property layout_style = "' . $property_of_agent_layout_style . '"
    item_amount = "' . $property_of_agent_items_amount . '" columns="' . $property_of_agent_column_lg . '"
    items_md="' . $property_of_agent_column_md . '"
    items_sm="' . $property_of_agent_column_sm . '" 
    items_xs="' . $property_of_agent_column_xs . '"
    items_mb="' . $property_of_agent_column_mb . '" 
    image_size = "' . $property_of_agent_image_size . '" 
    columns_gap = "' . $custom_property_of_agent_columns_gap . '" 
    show_paging = "' . $property_of_agent_show_paging . '"
    author_id = "' . $agent_user_id . '"
    agent_id = "' . $agent_id . '"]';
?>
<?php ?>
	<div class="single-agent-element agent-properties">
		<div class="ere-heading">
			<h2><?php esc_html_e('My Agents', 'essential-real-estate'); ?><sub><?php //echo ere_get_format_number($total_property); ?></sub></h2>
		</div>

        <?php
            // $agency_id = get_the_author_meta(ERE_METABOX_PREFIX . 'author_agent_id',$agent_id);
            $agent_list = get_post_meta($agent_id,"agent_list_cs",true);
            ?>
		            <div class="col-md-12">
            <?php

            foreach ($agent_list[0] as $key => $value) {
                
                echo '<div class="col-md-4">';
                echo "<div class='cs-agnt-img-bx' style='border-bottom: 0px !important;'><img src='".$value["image"]."' alt='not found' >";
                echo "</div>";
                echo "<div class='cs-agnt-bx cs-agent-name' style='border-bottom: 0px !important;'><span>".$value["name"]."</span>";
                echo "</div>";
                echo "<div class='cs-agnt-bx cs-agent-email' style='border-bottom: 0px !important;'><span>".$value["email"]."</span>";
                echo "</div>";
                echo "<div class='cs-agnt-bx cs-agent-phone' style='border-bottom: 0px !important;'><span><a href='tel: ".$value["phone"]."'>Call ".$value["phone"]."</a></span>";
                echo "</div>";

            
                echo '</div>';
            }

?>          <!--    <div class="col-md-4">
                    <div class="cs-agnt-bx">
                        
                    <span>
                        Want to add Agent
                    </span>
                    </div>
                    <div class="cs-agnt-bx">
                        Go down
                    </div>
</div> -->

            </div>
		<div style="min-height: 40px; padding: 50px;">
			<hr/>
		</div>

<?php
            ?>

            
        </div>
		<?php //echo do_shortcode($property_agent_shortcode); ?>
	</div>
<?php ?>