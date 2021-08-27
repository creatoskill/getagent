<?php
/**
 * The template for displaying dash deals.
 *
 */
// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); 


        function time_elapsed_string($ptime)
        {
            // var_dump($ptime);
            // exit;
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
			
		</div> <!-- main-sub-box-heading -->
		<div class="main-sub-box-content">

	<?php
     
      $_pf = new WC_Product_Factory();  
      $currency_symbol = get_woocommerce_currency_symbol();

    
 
        // $post_id = $value->ID;
        global $post;
        $post_id = $post->ID;
        
        // var_dump($post_id);
        $product = $_pf->get_product($post_id);
        // var_dump($product);
        // global $product;
        // $post_id = $product->get_id();
 
 		

                $post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );
            
        
        $post_thumbnail = $post_thumbnail[0];

        $post_author = "admin";
        $post_date = $product->get_date_created();
        $post_date_gmt = get_gmt_from_date($post_id);

        $content = get_post($post_id)->post_content;
        $post_content = $content;

        $post_title = $product->get_title();
        $post_status = $product->get_status();
        // $comment_count = $value->comment_count;


        $actual_price = get_post_meta($post_id, 'price', true);
        // $discount_percentage = get_post_meta($post_id, 'ddcs_discount_percentage', true);
        $discount_price = get_post_meta($post_id, 'sale_price', true);
        // $deal_title = get_post_meta($post_id, 'ddcs_deal_title', true);
        $deal_title_url = get_post_meta($post_id, 'deal_link', true);
        $voucher_code = get_post_meta($post_id, 'voucher_code', true);
        // $deal_temprature = get_post_meta($post_id, 'ddcs_deal_temprature', true);
        $comments_count = get_comments_number($post_id);
?>


			<div class="deals-box">
				
				<div class=" d-box">
				    <div class="main-content-parent" >
				         
					<div class="main-grid-box-cs-single ">
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
								echo time_elapsed_string($post_date); ?>
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

							<div class="grid-container-row-5">
								<div class="grid-row5-section-1 cs-sec-title">
									<div class="author-img"><img src="<?php //echo $author_img_url; ?>"><i class="fa fa-universal-access"></i><span>Admin</span></div>
								</div> <!-- grid-row2-section-1 -->
								<div class="grid-row5-section-2 cs-sec-title"><span class="icn-cs"><i class="fa fa-bookmark"></i></span></div> <!-- grid-row2-section-2 -->
								<div class="grid-row5-section-3 cs-sec-title"><span class="icn-cs"><i class="fa fa-comments" aria-hidden="true"><span class="cc-cs"><?php echo $comments_count; ?></span></i> </span></div> <!-- grid-row2-section-3 -->
								<div class="grid-row5-section-4 cs-sec-title"><a href="<?php echo get_post_meta($post_id,"deal_link",true); ?>" class="get-deal-button-a btn-a btn-cs-a"><span class="new-get-deal-btn-cs">Get Deal <i class="fa fa-external-link" aria-hidden="true"></i>
</span></a></div> <!-- grid-row2-section-4 -->
																
							</div><!-- grid-container-row-5 -->
					


						</div><!-- grid-content-box -->
										
					</div> <!-- main-grid-box-cs -->
					<div class="grid-container-row-4">
								<div class="grid-row4-section-1 cs-sec-content-single"><span><?php
								echo $post_content; ?><span class="cs-mk-btn"></span>
								</span></div> <!-- grid-row2-section-1 -->
																
							</div><!-- grid-container-row-4 -->	
					</div><!-- main content parent-->
					
					<div class="comment-box-cs">
					    <div class="comment-box-header-cs">
					       <div class="comment-text-heading-cs">
					           <span class="comments-heading-cs"><?php echo $comments_count; ?> Comments</span>
					       </div>   
					    </div> 
					    <div class="comment-area-cs">
					        
					    <?php if (is_single ()) comments_template (); ?>
			
			            </div>
					    					    
					</div>
				</div> <!-- d-box -->
			</div> <!-- deals-box -->

<?php

?>

			
		</div><!--  main-sub-box-content -->


	</div>
</div> <!-- main-box-cs -->

	
<?php 

get_footer();

?>