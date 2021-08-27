<?php
/**  
	* Template Name: deals archive
	*
	*    
	*/


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); 
// echo do_shortcode("[woocommerce_product_search]" );
echo do_shortcode('[woocatslider id="184"]');

$find = isset($_GET['find'])?$_GET['find']: "";
?>



<div class="div-cs-search">
    <div class="div-cs-search-inp">
        <input type="text" value="<?php echo $find; ?>" placeholder="search" class="cs-find-imp" id="cs-imp-text">
        <button type="button" onclick="search_results()" id="search-btn-cs">Search</button>
    </div>
</div>
<?php
        function time_elapsed_string($ptime)
        {

            $ptime = strtotime($ptime);
            $etime = time() - $ptime;
        
            if ($etime < 1)
            {
                return '0 seconds';
            }
        
            $a = array( 365 * 24 * 60 * 60  =>  'year',
                         30 * 24 * 60 * 60  =>  'month',
                              24 * 60 * 60  =>  'day',
                                   60 * 60  =>  'hour',
                                        60  =>  'minute',
                                         1  =>  'second'
                        );
            $a_plural = array( 'year'   => 'years',
                               'month'  => 'months',
                               'day'    => 'days',
                               'hour'   => 'hours',
                               'minute' => 'minutes',
                               'second' => 'seconds'
                        );
        
            foreach ($a as $secs => $str)
            {
                $d = $etime / $secs;
                if ($d >= 1)
                {
                    $r = round($d);
                    return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
                }
            }
        }

?>



<div class="main-box-cs">
	<div class="main-subbox-cs">
	    
		<div class="main-sub-box-heading">
		    <div class="heading-box-select">
		        <select class="deal-type-cs" id="deal-type-cs" onchange="filter_type_now()">
		            <option value="all" >All</option>
		            <option value="voucher" >Voucher</option>
		            <option value="deals" >Deals</option>
		        </select>
		        <!--<button type="button" class="filter-btn" >Go</button>-->
		        
		    </div>
		    
			
		</div> <!-- main-sub-box-heading -->
		<div class="sub-box-header-2">
		    <div class="sub-header2">
		        <?php
		        // find out the domain:
                $domain = $_SERVER['HTTP_HOST'];
                // find out the path to the current file:
                $path = $_SERVER['SCRIPT_NAME'];
                // find out the QueryString:
                $queryString = $_SERVER['QUERY_STRING'];
                // put it all together:
                $url = "http://" . $domain . $path . "?" . $queryString;
                // echo $url;

                 if($queryString!="type=voucher"){
                     
                     $url = "http://" . $domain . $path . "?" . "type=deals";
                     
                 }
                 
		        ?>
		        <span><a href="<?php echo $url."-hot"; ?>">Hot</a></span>
		        <span><a href="<?php echo $url."-new"; ?>">New</a></span>
		        <span><a href="<?php echo $url."-discussed"; ?>">Discussed</a></span>
		        
		    </div>
		    
		</div> <!-- sub-box heading 2 -->
 		<div class="main-sub-box-content">

	<?php
//voucher
//deals
//voucher-hot
//voucher-discussed
//voucher-new
//deals-hot
//deals-discussed
//deal-new

      
      if(isset($_GET['find'])){
        $args = array(
        'posts_per_page' => -1,
        'post_type' => 'product',
        's' => $_GET['find'],
        'orderby' => 'date',
      );
      }else{
        $args = array(
        'posts_per_page' => -1,
        'post_type' => 'product',
        'orderby' => 'date',
      );
      }
    //   var_dump($args);
    //   exit;
      $the_query = new WP_Query( $args );
      $_pf = new WC_Product_Factory();  
      $currency_symbol = get_woocommerce_currency_symbol();
      

      foreach ($the_query->posts as $key => $value) {
 
        $post_id = $value->ID;
        $productt = wc_get_product( $post_id );
        // var_dump($productt);
 
 		

                $post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );
            
        
        $post_thumbnail = is_array($post_thumbnail) ? $post_thumbnail[0] : "" ;

        $post_author = $value->post_author;
        $post_date = $value->post_date;
        $post_date_gmt = $value->post_date_gmt;

        $content = $value->post_content;
        $post_content = substr($content, 0, 180).".....";

        $post_title = $value->post_title;
        $post_status = $value->post_status;
        // var_dump($value);
        $post_url = $value->guid;
        // $comment_count = $value->comment_count;


        $actual_price = get_post_meta($post_id, 'price', true);
        $discount_percentage = get_post_meta($post_id, 'ddcs_discount_percentage', true);
        $discount_price = get_post_meta($post_id, 'sale_price', true);
        // $deal_title = get_post_meta($post_id, 'ddcs_deal_title', true);
        $deal_title_url = get_post_meta($post_id, 'deal_link', true);
        $voucher_code = get_post_meta($post_id, 'voucher_code', true);
        $comments_count = get_comments_number($post_id);
        
        if((isset($_GET['type']) && $_GET['type'] == "deals") && empty($deal) ){
            
            // continue;
        }
        
        if((isset($_GET['type']) && $_GET['type'] == "voucher") && empty($voucher_code) ){
            continue;            
        }
        if((isset($_GET['type']) && $_GET['type'] == "voucher-hot") && (empty($voucher_code) || !($productt->is_featured()))){
            continue;            
        }
        if((isset($_GET['type']) && $_GET['type'] == "voucher-new") && (empty($voucher_code) || $comments_count > 1)){
            // continue;            
        }
        if((isset($_GET['type']) && $_GET['type'] == "voucher-discussed") && (empty($voucher_code) || $comments_count < 1)){
            continue;            
        }
        
        if((isset($_GET['type']) && $_GET['type'] == "deals-hot") && !($productt->is_featured())){
            
            continue;            
        }
        if((isset($_GET['type']) && $_GET['type'] == "deals-new") && $comments_count > 1){
            
            // continue;            
        }
        if((isset($_GET['type']) && $_GET['type'] == "deals-discussed") && $comments_count < 1){
            
            continue;            
        }
        

        // var_dump($comment_count);
        // exit;
        // $deal_temprature = get_post_meta($post_id, 'ddcs_deal_temprature', true);
?>


			<div class="deals-box">
				
				<div class=" d-box">
					<div class="main-grid-box-cs ">
						<div class="grid-thumb-box">
							<div class="thumb-box">
								<a href="<?php echo $deal_title_url; ?>" title=""><img src="<?php echo $post_thumbnail; ?>" alt="Not Available"></a>
							</div>
						</div> <!-- grid-thumb-box -->
						<div class="grid-content-box">
							<div class="grid-container-row-1">
								<div class="grid-section-1 cs-sec-temprature"><span><?php
								//echo $deal_temprature; ?>
								</span></div> <!-- grid-section-1 -->
								<div class="grid-section-2 cs-sec-datetime"><span><i class="fa fa-hourglass-half"></i> <?php
								echo $post_date; ?>
								</span></div> <!-- grid-section-2 -->
								<div class="grid-section-3 cs-sec-timetogo"><span class="heartbeat-cs"><i class="fa fa-heartbeat"></i> <?php
								echo time_elapsed_string($post_date_gmt); ?>
								</span></div><!-- grid-section-1 -->

								
							</div><!-- grid-container-row-1 -->

							<div class="grid-container-row-2">
								<div class="grid-row2-section-1 cs-sec-title"><span><?php
								echo $post_title; ?>
								</span></div> <!-- grid-row2-section-1 -->
																
							</div><!-- grid-container-row-2 -->
							<div class="grid-container-row-3">
								<!--<div class="grid-row3-section-2 cs-sec-discount-percentage"><span>
								<!--//echo $discount_percentage; ?>-->
								<!--</span></div> <!-- grid-row3-section-2 -->
								<?php
								if(isset($discount_price)){
								
								    ?>
								    <div class="grid-row3-section-1 cs-sec-actual-price"><span class="cs-price-now d-price-cs">£<?php
								echo $discount_price; ?>
								</span><span class="discard-price">£<?php
								echo $actual_price; ?>
								</span></div> <!-- grid-row3-section-1 --><?php
								
								}else{
								        ?>
								    <div class="grid-row3-section-1 cs-sec-actual-price"><span class="actual-price cs-price-now">£<?php
								echo $actual_price; ?>
								</span></div> <!-- grid-row3-section-1 --><?php
								}
								?>
								<div class="grid-row3-section-4 cs-sec-supplier"><span><?php
								echo $post_author; ?>
								</span></div> <!-- grid-row3-section-4 -->
																
							</div><!-- grid-container-row-3 -->
							<div class="grid-container-row-voucher">
								<div class="grid-row3-section-1 cs-sec-voucher"><span><input type="text" value="<?php echo $voucher_code; ?>" id="myInput">

                                    <div class="tooltip">
                                    <button onclick="copytext()" onmouseout="outFunc()">
                                      <span class="tooltiptext" id="myTooltip">Copy to clipboard</span>
                                      Copy text
                                      </button>
                                    </div>
								</span></div> <!-- grid-row3-section-1 -->
							
							</div><!-- grid-container-row-3 -->

							<div class="grid-container-row-4">
								<div class="grid-row4-section-1 cs-sec-content"><span><?php
								echo $post_content; ?><span class="cs-mk-btn"><a href="<?php echo $post_url; ?>">read more</a></span>
								</span></div> <!-- grid-row2-section-1 -->
																
							</div><!-- grid-container-row-4 -->
							<div class="grid-container-row-5">
								<div class="grid-row5-section-1 cs-sec-title">
									<div class="author-img"><img src="<?php //echo $author_img_url; ?>"><i class="fa fa-universal-access"></i><span>Admin</span></div>
								</div> <!-- grid-row2-section-1 -->
								<div class="grid-row5-section-2 cs-sec-title"><span class="icn-cs"><i class="fa fa-bookmark"></i></span></div> <!-- grid-row2-section-2 -->
								<div class="grid-row5-section-3 cs-sec-title"><span class="icn-cs"><i class="fa fa-comments" aria-hidden="true"><span class="cc-cs"><?php echo $comments_count; ?></span></i> </span></div> <!-- grid-row2-section-3 -->
								<div class="grid-row5-section-4 cs-sec-title"><a href="<?php echo get_post_meta($post_id,"deal_link",true); ?>" target="blank" class="get-deal-button-a btn-a btn-cs-a"><span class="new-get-deal-btn-cs">Get Deal <i class="fa fa-external-link" aria-hidden="true"></i>
</span></a></div> <!-- grid-row2-section-4 -->
																
							</div><!-- grid-container-row-5 -->


						</div><!-- grid-content-box -->
						
					</div> <!-- main-grid-box-cs -->
				</div> <!-- d-box -->
			</div> <!-- deals-box -->

<?php

}//end of foreach

?>

			
		</div><!--  main-sub-box-content -->


	</div>
</div> <!-- main-box-cs -->

	
<?php 

get_footer();

?>