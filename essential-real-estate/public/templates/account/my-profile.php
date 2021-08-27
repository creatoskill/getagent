<?php
/**
* Created by G5Theme.
* User: trungpq
* Date: 01/11/16
* Time: 5:11 PM
*/


// $page = $_GET["page"];

// var_dump($page);
// exit();
if (!defined('ABSPATH')) {
exit; // Exit if accessed directly
}
if (!is_user_logged_in()) {
echo ere_get_template_html('global/access-denied.php', array('type' => 'not_login'));
return;
}
global $current_user;
wp_get_current_user();
$user_id = $current_user->ID;
$user_login = $current_user->user_login;
$user_firstname = get_the_author_meta('first_name', $user_id);
$user_lastname = get_the_author_meta('last_name', $user_id);
$user_email = get_the_author_meta('user_email', $user_id);
$user_mobile_number = get_the_author_meta(ERE_METABOX_PREFIX . 'author_mobile_number', $user_id);
$user_zip_code = get_the_author_meta(ERE_METABOX_PREFIX . 'author_zip', $user_id);
$agency_price = get_the_author_meta(ERE_METABOX_PREFIX . 'agency_price', $user_id);
// var_dump($user_email);
// exit;
$user_fax_number = get_the_author_meta(ERE_METABOX_PREFIX . 'author_fax_number', $user_id);
$user_company = get_the_author_meta(ERE_METABOX_PREFIX . 'author_company', $user_id);
$user_licenses = get_the_author_meta(ERE_METABOX_PREFIX . 'author_licenses', $user_id);
$user_office_number = get_the_author_meta(ERE_METABOX_PREFIX . 'author_office_number', $user_id);
$user_office_address = get_the_author_meta(ERE_METABOX_PREFIX . 'author_office_address', $user_id);
$user_des = get_the_author_meta('description', $user_id);
$user_facebook_url = get_the_author_meta(ERE_METABOX_PREFIX . 'author_facebook_url', $user_id);
$user_twitter_url = get_the_author_meta(ERE_METABOX_PREFIX . 'author_twitter_url', $user_id);
$user_linkedin_url = get_the_author_meta(ERE_METABOX_PREFIX . 'author_linkedin_url', $user_id);
$user_pinterest_url = get_the_author_meta(ERE_METABOX_PREFIX . 'author_pinterest_url', $user_id);
$user_instagram_url = get_the_author_meta(ERE_METABOX_PREFIX . 'author_instagram_url', $user_id);
$user_youtube_url = get_the_author_meta(ERE_METABOX_PREFIX . 'author_youtube_url', $user_id);
$user_vimeo_url = get_the_author_meta(ERE_METABOX_PREFIX . 'author_vimeo_url', $user_id);
$user_skype = get_the_author_meta(ERE_METABOX_PREFIX . 'author_skype', $user_id);
$user_website_url = get_the_author_meta('user_url', $user_id);

$user_position = get_the_author_meta(ERE_METABOX_PREFIX . 'author_position', $user_id);
$user_custom_picture = get_the_author_meta(ERE_METABOX_PREFIX . 'author_custom_picture', $user_id);
$author_picture_id = get_the_author_meta(ERE_METABOX_PREFIX . 'author_picture_id', $user_id);
$no_avatar_src = ERE_PLUGIN_URL . 'public/assets/images/profile-avatar.png';
$width = get_option('thumbnail_size_w');
$height = get_option('thumbnail_size_h');
$default_avatar = ere_get_option('default_user_avatar', '');
if ($default_avatar != '') {
if (is_array($default_avatar) && $default_avatar['url'] != '') {
$resize = ere_image_resize_url($default_avatar['url'], $width, $height, true);
if ($resize != null && is_array($resize)) {
$no_avatar_src = $resize['url'];
}
}
}
$user_as_agent = ere_get_option('user_as_agent', 1);
$enable_submit_property_via_frontend = ere_get_option('enable_submit_property_via_frontend', 1);
$is_agent = ere_is_agent();

wp_enqueue_script('plupload');
wp_enqueue_script(ERE_PLUGIN_PREFIX . 'profile');
$hide_user_info_fields = ere_get_option('hide_user_info_fields', array());
if (!is_array($hide_user_info_fields)) {
$hide_user_info_fields = array();
}
?>
<div class="row ere-user-dashboard">
<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ere-dashboard-sidebar">
<?php ere_get_template('global/dashboard-menu.php', array('cur_menu' => 'my_profile')); ?>
</div>
<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ere-dashboard-content">
<div class="ere-my-profile">
<div class="panel panel-default">
<div class="panel-heading"><?php esc_html_e('Account Settings', 'essential-real-estate'); ?></div>
<div class="panel-body profile-wrap update-profile">
    <form action="#" class="ere-update-profile">
        <div class="row">
            <?php
            if ($enable_submit_property_via_frontend == 1) {
                $message = '';
                if (!$is_agent) {
                    if ($user_as_agent == 1) {
                        $become_agent_terms_condition = ere_get_option('become_agent_terms_condition');
                        $message = sprintf(__('If you want to become an agent, please read our <a class="accent-color" target="_blank" href="%s">Terms & Conditions</a> first', 'essential-real-estate'), get_permalink($become_agent_terms_condition));
                    }
                } else {
                    $agent_id = get_the_author_meta(ERE_METABOX_PREFIX . 'author_agent_id', $user_id);
                    $agent_status = get_post_status($agent_id);
                    if ($agent_status == 'publish') {
                        $message = esc_html__('Your current account type is set to agency, if you want to remove your agency account, and return to normal account, you must click the button below', 'essential-real-estate');
                    } else {
                        $message = esc_html__('Your account need to be approved by admin to become an agency, if you want to return to normal account, you must click the button below', 'essential-real-estate');
                    }
                }
                if ($is_agent || $user_as_agent == 1):?>
                    <div class="col-sm-12">
                        <div class="jumbotron ere-account-agent">
                            <h4><?php esc_html_e('Agency Account', 'essential-real-estate'); ?></h4>

                            <p><?php echo wp_kses_post($message); ?></p>
                            <?php if (!$is_agent): ?>
                                <?php wp_nonce_field('ere_become_agent_ajax_nonce', 'ere_security_become_agent'); ?>
                                <button type="button" class="btn btn-primary"
                                        id="ere_user_as_agent"><?php esc_html_e('Become an Agency', 'essential-real-estate'); ?></button>

                            <?php else: ?>
                                <?php wp_nonce_field('ere_leave_agent_ajax_nonce', 'ere_security_leave_agent'); ?>
                                <button type="button" class="btn btn-primary"
                                        id="ere_leave_agent"><?php esc_html_e('Remove Agency Account', 'essential-real-estate'); ?></button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif;
            } ?>
            <div class="col-sm-6 ere-profile-avatar">
                <div id="user-profile-img">
                    <div class="profile-thumb">
                        <?php
                        if (!empty($author_picture_id)) {
                            $author_picture_id = intval($author_picture_id);
                            if ($author_picture_id) {
                                $avatar_src = ere_image_resize_id($author_picture_id, $width, $height, true);
                                ?>
                                <img width="<?php echo esc_attr($width) ?>"
                                     height="<?php echo esc_attr($height) ?>" id="profile-image"
                                     src="<?php echo esc_url($avatar_src); ?>"
                                     onerror="this.src = '<?php echo esc_url($no_avatar_src) ?>';"
                                     alt="<?php esc_attr_e('User Avatar', 'essential-real-estate') ?>">
                                <input type="hidden" class="profile-pic-id" id="profile-pic-id"
                                       name="profile-pic-id"
                                       value="<?php echo esc_attr($author_picture_id); ?>"/>
                                <?php
                            }
                        } else {
                            ?>
                            <img width="<?php echo esc_attr($width) ?>"
                                 height="<?php echo esc_attr($height) ?>" id="profile-image"
                                 src="<?php echo esc_url($user_custom_picture); ?>"
                                 onerror="this.src = '<?php echo esc_url($no_avatar_src) ?>';"
                                 alt="<?php esc_attr_e('User Avatar', 'essential-real-estate') ?>">
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="profile-img-controls">
                    <div id="errors_log"></div>
                </div>
                <div id="ere_profile_plupload_container">
                    <button type="button" id="ere_select_profile_image"
                            class="btn btn-primary"><?php esc_html_e('Update Profile Picture', 'essential-real-estate'); ?></button>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label
                                for="user_firstname"><?php esc_html_e('First Name', 'essential-real-estate'); ?></label>
                            <input type="text" name="user_firstname" id="user_firstname"
                                   class="form-control"
                                   value="<?php echo esc_attr($user_firstname); ?>">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label
                                for="user_lastname"><?php esc_html_e('Last Name', 'essential-real-estate'); ?></label>
                            <input type="text" name="user_lastname" id="user_lastname"
                                   class="form-control"
                                   value="<?php echo esc_attr($user_lastname); ?>">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label
                                for="user_email"><?php esc_html_e('Email', 'essential-real-estate'); ?></label>
                            <input type="text" name="user_email" id="user_email" class="form-control"
                                   value="<?php echo esc_attr($user_email); ?>">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label
                                for="user_mobile_number"><?php esc_html_e('Mobile', 'essential-real-estate'); ?></label>
                            <input type="text" id="user_mobile_number" name="user_mobile_number"
                                   class="form-control"
                                   value="<?php echo esc_attr($user_mobile_number); ?>">
                                                                    
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label
                                for="user_mobile_number"><?php esc_html_e('Zip/Postal Code', 'essential-real-estate'); ?></label>
                            <input type="text" id="user_zip_code" name="user_zip_code"
                                   class="form-control"
                                   value="<?php echo esc_attr($user_zip_code); ?>">
                                   
                        </div>
                    </div>
                                        <div class="col-sm-12">
                        <div class="form-group">
                            <label
                                for="agency_price"><?php esc_html_e('Price(Per Month)', 'essential-real-estate'); ?></label>
                            <input type="text" id="agency_price" name="agency_price" placeholder="price(USD)"
                                   class="form-control"
                                   value="<?php echo esc_attr($agency_price); ?>">
                                   
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="user_des"><?php esc_html_e('About me', 'essential-real-estate'); ?></label>
            <textarea id="user_des" name="user_des" class="form-control"
                      rows="5"><?php echo esc_attr($user_des); ?></textarea>
        </div>
        <div class="row">
            <?php if (ere_is_agent()): ?>
                <?php if (!in_array("user_company", $hide_user_info_fields)): ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label
                                for="user_company"><?php esc_html_e('Company', 'essential-real-estate'); ?></label>
                            <input type="text" id="user_company" name="user_company"
                                   class="form-control"
                                   value="<?php echo esc_attr($user_company); ?>">
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!in_array("user_position", $hide_user_info_fields)): ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label
                                for="user_position"><?php esc_html_e('Position', 'essential-real-estate'); ?></label>
                            <input type="text" id="user_position" name="user_position"
                                   value="<?php echo esc_attr($user_position); ?>" class="form-control">
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!in_array("user_office_number", $hide_user_info_fields)): ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label
                                for="user_office_number"><?php esc_html_e('Office Number', 'essential-real-estate'); ?></label>
                            <input type="text" id="user_office_number" name="user_office_number"
                                   class="form-control"
                                   value="<?php echo esc_attr($user_office_number); ?>">
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!in_array("user_office_address", $hide_user_info_fields)): ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label
                                for="user_office_address"><?php esc_html_e('Office Address', 'essential-real-estate'); ?></label>
                            <input type="text" id="user_office_address" name="user_office_address"
                                   class="form-control"
                                   value="<?php echo esc_attr($user_office_address); ?>">
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!in_array("user_licenses", $hide_user_info_fields)): ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label
                                for="user_licenses"><?php esc_html_e('Licenses', 'essential-real-estate'); ?></label>
                            <input type="text" id="user_licenses" name="user_licenses"
                                   class="form-control"
                                   value="<?php echo esc_attr($user_licenses); ?>">
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (!in_array("user_fax_number", $hide_user_info_fields)): ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label
                            for="user_fax_number"><?php esc_html_e('Fax', 'essential-real-estate'); ?></label>
                        <input type="text" id="user_fax_number" name="user_fax_number"
                               class="form-control"
                               value="<?php echo esc_attr($user_fax_number); ?>">
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!in_array("user_website_url", $hide_user_info_fields)): ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label
                            for="user_website_url"><?php esc_html_e('Website URL', 'essential-real-estate'); ?></label>
                        <input type="text" id="user_website_url" name="user_website_url"
                               class="form-control"
                               value="<?php echo esc_url($user_website_url); ?>">
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!in_array("user_skype", $hide_user_info_fields)): ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label
                            for="user_skype"><?php esc_html_e('Skype', 'essential-real-estate'); ?></label>
                        <input type="text" id="user_skype" name="user_skype" class="form-control"
                               value="<?php echo esc_attr($user_skype); ?>">
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!in_array("user_facebook_url", $hide_user_info_fields)): ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label
                            for="user_facebook_url"><?php esc_html_e('Facebook URL', 'essential-real-estate'); ?></label>
                        <input type="text" id="user_facebook_url" name="user_facebook_url"
                               value="<?php echo esc_attr($user_facebook_url); ?>" class="form-control">
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!in_array("user_twitter_url", $hide_user_info_fields)): ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label
                            for="user_twitter_url"><?php esc_html_e('Twitter URL', 'essential-real-estate'); ?></label>
                        <input type="text" id="user_twitter_url" name="user_twitter_url"
                               class="form-control"
                               value="<?php echo esc_attr($user_twitter_url); ?>">
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!in_array("user_linkedin_url", $hide_user_info_fields)): ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label
                            for="user_linkedin_url"><?php esc_html_e('Linkedin URL', 'essential-real-estate'); ?></label>
                        <input type="text" id="user_linkedin_url" name="user_linkedin_url"
                               class="form-control"
                               value="<?php echo esc_attr($user_linkedin_url); ?>">
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!in_array("user_instagram_url", $hide_user_info_fields)): ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label
                            for="user_instagram_url"><?php esc_html_e('Instagram URL', 'essential-real-estate'); ?></label>
                        <input type="text" id="user_instagram_url" name="user_instagram_url"
                               class="form-control"
                               value="<?php echo esc_attr($user_instagram_url); ?>">
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!in_array("user_pinterest_url", $hide_user_info_fields)): ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label
                            for="user_pinterest_url"><?php esc_html_e('Pinterest URL', 'essential-real-estate'); ?></label>
                        <input type="text" id="user_pinterest_url" name="user_pinterest_url"
                               class="form-control"
                               value="<?php echo esc_attr($user_pinterest_url); ?>">
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!in_array("user_youtube_url", $hide_user_info_fields)): ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label
                            for="user_youtube_url"><?php esc_html_e('Youtube URL', 'essential-real-estate'); ?></label>
                        <input type="text" id="user_youtube_url" name="user_youtube_url"
                               class="form-control"
                               value="<?php echo esc_attr($user_youtube_url); ?>">
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!in_array("user_vimeo_url", $hide_user_info_fields)): ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label
                            for="user_vimeo_url"><?php esc_html_e('Vimeo URL', 'essential-real-estate'); ?></label>
                        <input type="text" id="user_vimeo_url" name="user_vimeo_url"
                               class="form-control"
                               value="<?php echo esc_attr($user_vimeo_url); ?>">
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php wp_nonce_field('ere_update_profile_ajax_nonce', 'ere_security_update_profile'); ?>
        <button type="button" class="btn btn-primary display-block"
                id="ere_update_profile"><?php esc_html_e('Update Profile', 'essential-real-estate'); ?></button>
    </form>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading"><?php esc_html_e('Change password', 'essential-real-estate'); ?></div>
<div class="panel-body profile-wrap change-password">
    <form action="#" class="ere-change-password">
        <div id="password_reset_msgs" class="ere_messages message"></div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label
                        for="oldpass"><?php esc_html_e('Old Password', 'essential-real-estate'); ?></label>
                    <input id="oldpass" value="" class="form-control" name="oldpass" type="password">
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label
                        for="newpass"><?php esc_html_e('New Password ', 'essential-real-estate'); ?></label>
                    <input id="newpass" value="" class="form-control" name="newpass" type="password">
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label
                        for="confirmpass"><?php esc_html_e('Confirm Password', 'essential-real-estate'); ?></label>
                    <input id="confirmpass" value="" class="form-control" name="confirmpass"
                           type="password">
                </div>
            </div>

        </div>
        <?php wp_nonce_field('ere_change_password_ajax_nonce', 'ere_security_change_password'); ?>
        <button type="button" class="btn btn-primary display-block"
                id="ere_change_pass"><?php esc_html_e('Update Password', 'essential-real-estate'); ?></button>
    </form>
</div>
</div>
</div>
<!-- cs modification will be here -->
<div class="cs-agent-section">
 
    <div class="panel panel-default">
        <div class="panel-heading">Agents</div>
        <div class="main-container agents-current current-agents">
        
        <?php
            $agency_id = get_the_author_meta(ERE_METABOX_PREFIX . 'author_agent_id', $user_id);
            $agent_list = get_post_meta($agency_id,"agent_list_cs",true);
            ?>
            <div class="col-md-12">
                
                


            <?php

            foreach ($agent_list[0] as $key => $value) {
                
                echo '<div class="col-md-4">';
                echo "<div class='cs-agnt-img-bx cs-agent-image'><img src='".$value["image"]."' alt='not found' >";
                echo "</div>";
                echo "<div class='cs-agnt-bx cs-agent-name' ><span>".$value["name"]."</span>";
                echo "</div>";
                echo "<div class='cs-agnt-bx cs-agent-email' ><span>".$value["email"]."</span>";
                echo "</div>";
                echo "<div class='cs-agnt-bx cs-agent-phone'><span><a href='tel: ".$value["phone"]."'>Call ".$value["phone"]."</a></span>";
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

<?php
            ?>

            
        </div>

        <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <!-- Repeater Html Start -->
                <div id="repeater">
                    <!-- Repeater Heading -->
                    <div class="cs-agnt-bx" style="margin-top: 30px;">
                        Add New Agent
                    </div>
                    <div class="repeater-heading">
                        <div class="cs-spacer" style=" min-height: 40px;" ></div>
                        <!-- <h5 class="pull-left"></h5> -->
                        <!-- <button class="btn btn-primary pt-5 pull-right repeater-add-btn"> -->
                            <!-- Add -->
                        <!-- </button> -->
                        <div class="cs-spacer" style=" min-height: 40px;" ></div>
                    </div>
                    <div class="clearfix"></div>
                    <!-- Repeater Items -->
                    <div class="items" data-group="test">
                        <!-- Repeater Content -->
                        <div class="item-content">
                            <div class="form-group col-md-12">
                                <label for="inputImage" class="col-lg-2 control-label">Image</label>
                                <div class="col-lg-10">
                                    <input type="file" class="form-control" id="inputImage" placeholder="Image" data-name="name" name="ifile" required>
                                </div>
                            </div>
                            
                            <!-- <div class="cs-spacer" style=" min-height: 40px;" ></div> -->
                                <div class="form-group col-md-12">
                                <label for="inputName" class="col-lg-2 control-label">Name</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputName" placeholder="Name" data-name="name"
                                    name="inputname"
                                    >
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputEmail" placeholder="Email" data-skip-name="true" data-name="email"
                                    name="inputemail"
                                    >
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputPhone" class="col-lg-2 control-label">Phone</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputPhone" placeholder="Phone (with country code)" data-name="phone"
                                    name="inputphone"
                                    >
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputDesc" class="col-lg-2 control-label">description</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="inputdesc"
                                    rows="4" placeholder="Description(testimonial)" data-name="description"
                                    name="inputdesc"
                                    >
                                        
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputInsta" class="col-lg-2 control-label">Instagram</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputInsta" placeholder="Instagram" data-name="instagram" name="inputinsta"
                                    >
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputTwitter" class="col-lg-2 control-label">Twitter</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputTwitter" placeholder="Twitter" data-name="twitter" name="inputtwitter"
                                    >
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputFacebook" class="col-lg-2 control-label">Facebook</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputFacebook" placeholder="Facebook" data-name="facebook"
                                    name="inputfacebook">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputLinkedin" class="col-lg-2 control-label">Linkedin</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputLinkedin" placeholder="Linkedin" data-name="linkedin" name="inputlinkedin">
                                </div>
                            </div>
                        </div>
                        <!-- Repeater Remove Btn -->
                        <div class="pull-right repeater-remove-btn">
  <!--                           <button class="btn btn-danger remove-btn">
                                Remove
                            </button> -->
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!-- Repeater End -->

            <hr/>
            <div class="cs-save-from-btn-box pt-5 pull-right" style="min-height: 68px;">
                <span class="ajax-cs-node"></span>
                <?php $agent_id = get_the_author_meta(ERE_METABOX_PREFIX . 'author_agent_id', $user_id); ?>
                <button type="button" onclick="save_agents(<?php echo $agent_id; ?>)">
                    Save
                </button>
                
            </div><!-- //btn box -->
            <div class="cs-spacer" style=" min-height: 40px;" ></div>

            </div>
        </div> <!-- container -->
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" -->
        <!-- crossorigin="anonymous"></script> -->

    <script type="text/javascript">
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
</script>

    </div><!-- panel default -->

</div><!-- cs agent section -->
<!-- cs modification will be here -->
</div>

</div>