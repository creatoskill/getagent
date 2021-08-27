<?php
/*
Plugin Name: Beyot Shortcodes By CS
Plugin URI: https://www.fiverr.com/creatos_kill
Description: Post Type Metal Present Your Metal Works With Charm and Efficiency.
Author: M.husnain
Author URI: https://www.fiverr.com/creatos_kill
Version: 0.1.2
*/


class beyot_shortcodes_cs
{

	function __construct()
	{

		// exit();
		// add_filter( 'pre_get_posts', array($this, 'namespace_add_custom_types') );
		add_shortcode( 'cs_agent_search', [$this, 'cs_agent_search_callback' ]);
		
		

		//add_script
		add_action('wp_enqueue_scripts', array($this, 'cs_b_s_cs_enqueue_script'));

		add_action('admin_enqueue_scripts', array($this, 'cs_admin_enqueue_script'));
		// /**
  //    	* Adding Menu Page Hook
  //    	*/
  //    	add_action('admin_menu', [$this,'cs_dashboard_deals_page']);
    add_action('wp_ajax_add_agent', [$this,'add_agent']);//
    add_action('wp_ajax_nopriv_add_agent', [$this,'add_agent']);//
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
      $agent["image"] = "https://getagent.developersaeed.com/wp-content/uploads/2019/01/contact.png";

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

     	wp_register_style('cs_css', plugin_dir_url( __FILE__ ) . 'assets/beyot-cs-style.css',[],"4.4");
     	wp_register_script( 'cs_b-s-cs_script', plugin_dir_url( __FILE__ ) . 'assets/beyot-cs-script.js', [] , "3.4" );
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

    wp_register_style('cs_admin_css', plugin_dir_url( __FILE__ ) . 'assets/beyot-cs-admin-styles.css',[] , "3.7" );

    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(), null, false);

    wp_enqueue_script('jquery'); 


    wp_register_script( 'cs_b-s-cs_script', plugin_dir_url( __FILE__ ) . 'assets/beyot-cs-admin-script.js', [] , "2.0" );

    wp_localize_script( 'cs_b-s-cs_script', 'ajaxURL', admin_url('admin-ajax.php'));//localizing ajaxURL


    wp_enqueue_style('font-awesome');//fontawesome 

    wp_enqueue_script('cs_b-s-cs_script');

    wp_enqueue_style('cs_admin_css'); 

    

  }//for admin area

  function cs_agent_search_callback(){

  	$res = "";
  	$res .= '<div data-href="http://localhost/newme/advanced-search/" class="search-properties-form">
                 <div class="ere-search-status-tab">
                            </div><div class = "input-cs-search-agent">
                            <label>Find An Agent</label>
                            <input type="text" id="agent-search-zip" placeholder="Zip/Postcode">
                            <button id="search-agent-btn" onclick="search_agent_cs()">Search</button>
                            </div>';

    return $res;
  }

// <input class="search-field search-field-agent-cs" type="hidden" name="status" value="for-sale" data-default-value=""> 
//                             <button type="button" data-value="for-rent" class="btn-status-filter active">For Rent</button>
//                             <button type="button" data-value="for-sale" class="btn-status-filter">For Sale</button>




}

new beyot_shortcodes_cs();