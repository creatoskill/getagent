<?php
/*
Plugin Name: Beyot Shortcodes By CS
Plugin URI: https://www.fiverr.com/creatos_kill
Description: Post Type Metal Present Your Metal Works With Charm and Efficiency.
Author: M.husnain
Author URI: https://www.fiverr.com/creatos_kill
Version: 0.1.3
*/


class beyot_shortcodes_cs
{

	function __construct()
	{

    add_shortcode( 'cs_agent_search', [$this, 'cs_agent_search_callback' ]);
		add_shortcode( 'cs_featured_agencies', [$this, 'cs_featured_agencies_callback' ]);
		
		

		//add_script
		add_action('wp_enqueue_scripts', array($this, 'cs_b_s_cs_enqueue_script'));

		add_action('admin_enqueue_scripts', array($this, 'cs_admin_enqueue_script'));

    add_action('wp_ajax_update_user_feature_status', [$this,'update_user_feature_status']);//registering ajax function

    add_action('wp_ajax_add_agent', [$this,'add_agent']);//
    add_action('wp_ajax_nopriv_add_agent', [$this,'add_agent']);//
    
    /**
      * Adding Menu Page Hook
    */
      add_action('admin_menu', [$this,'cs_dashboard_agent_page']);

     }

  function cs_featured_agencies_callback(){

?>
<div class="ere-agent clearfix agent-grid row columns-4 columns-md-3 columns-sm-2 columns-xs-2 columns-mb-1">
<?php

$args = array(
    'post_type' => 'agent',
    'post_status' => 'publish',
    'meta_query' => array(
        array(
            'key'     => 'cs_featured',
            'value'   => 'yes',
            'compare' => '=',
        ),
        array(
            'key'     => 'cs_featured',
            'compare' => 'EXISTS',
        ),
      ),
    
  );

$agents = new WP_Query( $args );
foreach ($agents->posts as $key => $agent) {
// while ( $agents->posts() ) : $agents->the_post(); 
  // var_dump($agent);

    $agent_id = $agent->ID;
    $agent_name = $agent->post_title;
    $agent_link = get_the_permalink($agent_id);

    $agent_post_meta_data = get_post_custom($agent_id);

    $agent_description = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_description']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_description'][0] : '';
    $email = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_email']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_email'][0] : '';

    $agent_facebook_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_facebook_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_facebook_url'][0] : '';
    $agent_twitter_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_twitter_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_twitter_url'][0] : '';
    $agent_linkedin_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_linkedin_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_linkedin_url'][0] : '';
    $agent_pinterest_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_pinterest_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_pinterest_url'][0] : '';
    $agent_instagram_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_instagram_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_instagram_url'][0] : '';
    $agent_skype = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_skype']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_skype'][0] : '';
    $agent_youtube_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_youtube_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_youtube_url'][0] : '';
    $agent_vimeo_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_vimeo_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_vimeo_url'][0] : '';
    $agent_user_id = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_user_id']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_user_id'][0] : '';
    $user = get_user_by('id', $agent_user_id);
    if (empty($user)) {
        $agent_user_id = 0;
    }
    $ere_property = new ERE_Property();
    $avatar_id = get_post_thumbnail_id($agent_id);
    $width = 270;
    $height = 340;
    $custom_agent_image_size = $width."x".$height;
    $no_avatar_src = ERE_PLUGIN_URL . 'public/assets/images/profile-avatar.png';
    $default_avatar = ere_get_option('default_user_avatar', '');

    if (preg_match('/\d+x\d+/', $custom_agent_image_size)) {
        $image_sizes = explode('x', $custom_agent_image_size);
        $width=$image_sizes[0];$height= $image_sizes[1];
        $avatar_src = ere_image_resize_id($avatar_id, $width, $height, true);
        if ($default_avatar != '') {
            if (is_array($default_avatar) && $default_avatar['url'] != '') {
                $resize = ere_image_resize_url($default_avatar['url'], $width, $height, true);
                if ($resize != null && is_array($resize)) {
                    $no_avatar_src = $resize['url'];
                }
            }
        }
    } else {
        if (!in_array($custom_agent_image_size, array('full', 'thumbnail'))) {
            $custom_agent_image_size = 'full';
        }
        $avatar_src = wp_get_attachment_image_src($avatar_id, $custom_agent_image_size);
        if ($avatar_src && !empty($avatar_src[0])) {
            $avatar_src = $avatar_src[0];
        }
        if (!empty($avatar_src)) {
            list($width, $height) = getimagesize($avatar_src);
        }
        if($default_avatar!='')
        {
            if(is_array($default_avatar)&& $default_avatar['url']!='')
            {
                $no_avatar_src = $default_avatar['url'];
            }
        }
    }
    ?>
    <div class="agent-item <?php echo esc_attr($gf_item_wrap) ?>">
        <div class="agent-item-inner">
            <div class="agent-avatar">
                <a
                    title="<?php echo esc_attr($agent_name) ?>"
                    href="<?php echo esc_url($agent_link) ?>"><img width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" src="<?php echo esc_url($avatar_src) ?>" onerror="this.src = '<?php echo esc_url($no_avatar_src) ?>';" alt="<?php echo esc_attr($agent_name) ?>"                                                               title="<?php echo esc_attr($agent_name) ?>"></a>
            </div>
            <div class="agent-content">
                <div class="agent-info">
                    <?php if (!empty($agent_name)): ?>
                        <h2 class="agent-name"><a
                                title="<?php echo esc_attr($agent_name) ?>"
                                href="<?php echo esc_url($agent_link) ?>"><?php echo esc_attr($agent_name) ?></a>
                        </h2>
                    <?php endif; ?>
                    <span class="agent-total-properties"><?php
                        $total_property = $ere_property->get_total_properties_by_user($agent_id, $agent_user_id);
                        printf( _n( '%s property', '%s properties', $total_property, 'essential-real-estate' ), ere_get_format_number($total_property ));
                        ?></span>
                    <?php if (!empty($agent_description)): ?>
                        <p class="agent-description"><?php echo wp_kses_post($agent_description) ?></p>
                    <?php endif; ?>
                </div>
                <div class="agent-social">
                    <?php if (!empty($agent_facebook_url)): ?>
                        <a title="Facebook" href="<?php echo esc_url($agent_facebook_url); ?>">
                            <i class="fa fa-facebook"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($agent_twitter_url)): ?>
                        <a title="Twitter" href="<?php echo esc_url($agent_twitter_url); ?>">
                            <i class="fa fa-twitter"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($email)): ?>
                        <a title="Email" href="mailto:<?php echo esc_attr($email); ?>">
                            <i class="fa fa-envelope"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($agent_skype)): ?>
                        <a title="Skype" href="skype:<?php echo esc_url($agent_skype); ?>?call">
                            <i class="fa fa-skype"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($agent_linkedin_url)): ?>
                        <a title="Linkedin" href="<?php echo esc_url($agent_linkedin_url); ?>">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($agent_pinterest_url)): ?>
                        <a title="Pinterest" href="<?php echo esc_url($agent_pinterest_url); ?>">
                            <i class="fa fa-pinterest"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($agent_instagram_url)): ?>
                        <a title="Instagram" href="<?php echo esc_url($agent_instagram_url); ?>">
                            <i class="fa fa-instagram"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($agent_youtube_url)): ?>
                        <a title="Youtube" href="<?php echo esc_url($agent_youtube_url); ?>">
                            <i class="fa fa-youtube-play"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($agent_vimeo_url)): ?>
                        <a title="Vimeo" href="<?php echo esc_url($agent_vimeo_url); ?>">
                            <i class="fa fa-vimeo"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php
}//foreach
?>
</div>
<?php
  }



  /**
   * ajax call
   * @param void
   * @return object
   */
  function update_user_feature_status(){
    
    $u_id = $_GET['u_id'];
    $cs_featured = 'cs_featured';

    if(get_user_meta($u_id,$cs_featured,true) == "yes"){

        
        if(update_user_meta( $u_id,$cs_featured,"no" )){

            $agent_id = get_user_meta($u_id,"real_estate_author_agent_id",true);
            // get_user_meta( $u_id, 'checkbox', true );

            update_post_meta($agent_id,"cs_featured", "no");

            $response = ["message" => "Status Updated", "status" => "yes" ];
            wp_send_json_success(['response' => $response]);

        } 

    }
    else if(get_user_meta($u_id,$cs_featured,true) == "no"){

        if(update_user_meta( $u_id,$cs_featured,"yes" )){
            $agent_id = get_user_meta($u_id,"real_estate_author_agent_id",true); 
            update_post_meta($agent_id,"cs_featured", "yes");
            
            $response = ["message" => "Status Updated", "status" => "no" ];
            wp_send_json_success(['response' => $response]);

        }
      
    }
    else{

            wp_send_json_success(['response' => "Something Went Wrong"]);
    }

      

  } //update method

  


     function cs_dashboard_agent_page()
     {
      add_menu_page('Featured Agents', 'Featured Agents', 'manage_options', 'featured_agents', [$this,'featured_agents_function'],'dashicons-awards');
     }

     function featured_agents_function(){

      ?>
      <div class="agents_cs_content">
        <div class="cs-main-agent-box cs-all-agents">
        <h2>
          All Agencies 
        </h2>
            
        <div class="cs-table-main cs-box-for-agents">
          <div class="cs-table-box"> 
                <div class="main_frame">

      <div class="ua_main_content">

        <div class="ua_content_r1">

        </div><!-- ua_content_r1 -->

        <div class="ua_content_r2">


          <div class="ua_content_table">
            <!-- create table -->
            <?php

// Pagination vars
$current_page = get_query_var('paged') ? (int) get_query_var('paged') : 1;
$users_per_page = 2; // RAISE THIS AFTER TESTING ;)

$args = array(
    'number' => $users_per_page, // How many per page
    'paged' => $current_page, // What page to get, starting from 1.
    'meta_query' => array(
        'relation' => 'AND',

        array(
            'key'     => 'real_estate_package_id',
            'value'   => '450',
            'compare' => '=',
        ),
        array(
            'key'     => 'real_estate_author_agent_id',
            'compare' => 'EXISTS',
        ),
      ),
    
  );

$users = new WP_User_Query( $args );

$total_users = $users->get_total(); // How many users we have in total (beyond the current page)
$num_pages = ceil($total_users / $users_per_page); // How many pages of users we will need

?>
<h3>Page <?php echo $current_page; ?> of <?php echo $num_pages; ?></h3>
<p>Displaying <?php echo $users_per_page; ?> of <?php echo $total_users; ?> users</p>
<p>[Sometimes Have To Click Twice Because Of Ajax Call]</p>

<table class="feature_module_status_table">
  <thead>
    <tr>
      <th>Image</th>
      <th>Name</th>    
      <th>Package Name</th>
      <th>Status</th>
        <!-- <th>Last Name</th> -->
    </tr>
  </thead>

  <tbody>
    <?php
    if ( $users->get_results() ) foreach( $users->get_results() as $user )  {
      // var_dump($user->ID);  
      if( get_user_meta($user->ID,"cs_featured",true) == ""){

        update_user_meta( $user->ID, 'cs_featured', "no" ); 
      }
      $name = $user->user_nicename;
      // $lastname = $user->last_name;
      $email = $user->user_email;
      $f_status = get_user_meta($user->ID,"cs_featured",true);
      $get_agent_id = get_user_meta( $user->ID,'real_estate_author_agent_id', true);
      $get_agent_image_data = get_post_meta($get_agent_id,"_wp_attachment_metadata", true);
      // var_dump($get_agent_id);
      $upload_dir = wp_get_upload_dir();
      $get_attachment_id = get_post_meta($get_agent_id,"_thumbnail_id",true);
      $get_attachment_url = get_post_meta($get_attachment_id,"_wp_attached_file",true);
      // var_dump($no_avatar_src);

      if (!empty($get_attachment_url)) {
        
      $image_url = $upload_dir['baseurl']."/".$get_attachment_url;
      
      }else{

      $image_url = ERE_PLUGIN_URL . 'public/assets/images/profile-avatar.png';
      }

      ($f_status == 'no') ? $lt1 = "Inactive" : $lt1 = "Active"; 
      ?>
      <tr id="csrow-<?php echo $user->ID;  ?>" class="row-<?php echo $lt1;  ?>">
        <td><div class="image-cs-agent"><img src="<?php echo $image_url; ?>" height = "90" alt="no-img"></div></td>
        <td><?php echo esc_html($name); ?></td>
        <td><?php echo esc_html($email); ?></td>
        <td>

            <?php
            
                    echo '<div class="cs-btn-status-div" ><button type="button" class="btn_status '.$lt1.'" id="btnfeatured_'.$user->ID.'"
                     onclick="update_featured_status('.$user->ID .')">'.$lt1.'</button></div>'; 

            ?>
              
        </td>
        
      </tr>
      <?php
    }
    ?>
  </tbody>
</table>

<p>
  <?php
        // Previous page
  if ( $current_page > 1 ) {
    echo '<a href="'. add_query_arg(array('paged' => $current_page-1)) .'">Previous Page</a>';
  }
  echo " &nbsp ";
        // Next page
  if ( $current_page < $num_pages ) {
    echo '<a href="'. add_query_arg(array('paged' => $current_page+1)) .'">Next Page</a>';
  }
  ?>
</p>

</div>

</div><!-- ua_content_r2 -->


</div><!-- ua_main_content -->

</div>
          </div>
        </div>
        </div>
<!--         <div class="cs-sec-agent-box cs-featured-agents">
        <h2>
          Featured Agencies 
        </h2>
        <div class="cs-table-main cs-box-for-agents">
          <div class="cs-table-box"> 
            
          </div>
        </div>
        </div> -->
        
      </div>
    

      <?php

     }



     function add_agent(){
      $agency_id = isset($_GET['agency_id']) ? $_GET['agency_id'] : "";
      $name = isset($_GET['name']) ? $_GET['name'] : "";
      $email = isset($_GET['email']) ? $_GET['email'] : "";
      $phone = isset($_GET['phone']) ? $_GET['phone'] : "";
      $desc = isset($_GET['description']) ? $_GET['description'] : "";
      $insta = isset($_GET['instagram']) ? $_GET['instagram'] : "";
      $twitter = isset($_GET['twitter']) ? $_GET['twitter'] : "";
      $facebook = isset($_GET['facebook']) ? $_GET['facebook'] : "";
      $linkedin = isset($_GET['linkedin']) ? $_GET['linkedin'] : "";

      $agent = [];
      //dummy image
      $agent["image"] = "http://localhost/newme/wp-content/uploads/2019/01/contact.png";

      $agent["name"] = $name;
      $agent["email"] = $email;
      $agent["phone"] = $phone;
      $agent["description"] = $description;
      $agent["instagram"] = $insta;
      $agent["twitter"] = $twitter;
      $agent["facebook"] = $facebook;
      $agent["linkedin"] = $linkedin;


      $agent_list = get_post_meta($agency_id,"agent_list_cs",true);
      if ($agent_list == "") {
          
          update_post_meta($agency_id,"agent_list_cs",[$agent]);
        
      }else{

        array_push($agent_list, $agent);
        update_post_meta($agency_id,"agent_list_cs",[$agent_list]);

      }
      // $name = isset($_GET['']) ? $_GET[''] : "";
      // var_dump("fedfd");
      // exit();

      wp_send_json_success([$agent_list]);
     
     }
     
     function cs_b_s_cs_enqueue_script() {   

     	wp_register_style('cs_css', plugin_dir_url( __FILE__ ) . 'assets/beyot-cs-style.css',[],"4.1");
     	wp_register_script( 'cs_b-s-cs_script', plugin_dir_url( __FILE__ ) . 'assets/beyot-cs-script.js', [] , "3.3" );
     	wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(), null, false);
        wp_localize_script( 'cs_admin_js', 'ajaxURL', admin_url('admin-ajax.php'));
        
        wp_enqueue_script('cs_admin_js');
        wp_enqueue_script('jquery');
        wp_enqueue_script('cs_b-s-cs_script');
     	wp_enqueue_style('cs_css'); 
     }

       function cs_admin_enqueue_script() {   

    /*

    *Registering Scripts and Styles then load these.

    */      

    wp_register_style('cs_admin_css', plugin_dir_url( __FILE__ ) . 'assets/beyot-cs-admin-styles.css',[] , "3.8" );

    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(), null, false);

    wp_enqueue_script('jquery'); 


    wp_register_script( 'cs_b-s-cs_script', plugin_dir_url( __FILE__ ) . 'assets/beyot-cs-admin-script.js', [] , "1.9" );

    wp_localize_script( 'cs_b-s-cs_script', 'ajaxURL', admin_url('admin-ajax.php'));//localizing ajaxURL


    wp_enqueue_style('font-awesome');//fontawesome 

    wp_enqueue_script('cs_b-s-cs_script');

    wp_enqueue_style('cs_admin_css'); 

    

  }//for admin area

  function cs_agent_search_callback(){

  	$res = "";
  	$res .= '<div data-href="http://localhost/newme/advanced-search/" class="search-properties-form">
                 <div class="ere-search-status-tab">
                            <input class="search-field search-field-agent-cs" type="hidden" name="status" value="for-sale" data-default-value=""> 
                            <button type="button" data-value="for-rent" class="btn-status-filter active">For Rent</button>
                            <button type="button" data-value="for-sale" class="btn-status-filter">For Sale</button>
                            </div><div class = "input-cs-search-agent">
                            <label>Find An Agent</label>
                            <input type="text" id="agent-search-zip" placeholder="Zip/Postcode">
                            <button onclick="search_agent_cs()">Search</button>
                            </div>';

    return $res;
  }






}

new beyot_shortcodes_cs();