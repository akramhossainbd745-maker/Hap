<?php
/** Theme bootstrap and editorial content model. */
if (!defined('ABSPATH')) exit;
define('AHM_AKRAM_VERSION', '1.0.0');
function ahm_akram_setup() {
    load_theme_textdomain('ahm-akram', get_template_directory() . '/languages');
    add_theme_support('title-tag'); add_theme_support('post-thumbnails'); add_theme_support('html5', array('search-form','comment-form','comment-list','gallery','caption','style','script'));
    add_theme_support('custom-logo', array('height'=>80,'width'=>260,'flex-height'=>true,'flex-width'=>true));
    register_nav_menus(array('primary'=>__('Primary navigation','ahm-akram')));
}
add_action('after_setup_theme','ahm_akram_setup');
function ahm_akram_assets() {
    $uri=get_template_directory_uri();
    wp_enqueue_style('ahm-akram-style',get_stylesheet_uri(),array(),AHM_AKRAM_VERSION);
    if (is_front_page()) {
        wp_enqueue_script('ahm-akram-scene',$uri.'/assets/js/scene.js',array(),AHM_AKRAM_VERSION,true);
        wp_enqueue_script('ahm-akram-site',$uri.'/assets/js/site.js',array(),AHM_AKRAM_VERSION,true);
        wp_localize_script('ahm-akram-site','AhmAkram',array('rest'=>esc_url_raw(rest_url('ahm-akram/v1/contact')),'nonce'=>wp_create_nonce('wp_rest'),'seed'=>absint(get_option('ahm_seed',2026)),'placeholders'=>get_option('ahm_placeholders','1'),'minimum'=>absint(get_option('ahm_min_cards',40)),'randomFeatured'=>get_option('ahm_random_featured','1'),'booking'=>esc_url(get_option('ahm_booking_url','')),'year'=>gmdate('Y')));
    }
}
add_action('wp_enqueue_scripts','ahm_akram_assets');
function ahm_akram_register_content() {
    register_post_type('case_study',array('labels'=>array('name'=>'Case Studies','singular_name'=>'Case Study','add_new_item'=>'Add Case Study'),'public'=>true,'show_in_rest'=>true,'has_archive'=>true,'menu_icon'=>'dashicons-chart-line','supports'=>array('title','editor','thumbnail','excerpt','revisions'),'rewrite'=>array('slug'=>'results')));
    register_post_type('creative',array('labels'=>array('name'=>'Creatives','singular_name'=>'Creative'),'public'=>true,'show_in_rest'=>true,'has_archive'=>true,'menu_icon'=>'dashicons-format-image','supports'=>array('title','thumbnail','editor'),'rewrite'=>array('slug'=>'creative')));
    register_post_type('testimonial',array('labels'=>array('name'=>'Testimonials','singular_name'=>'Testimonial'),'public'=>true,'show_in_rest'=>true,'has_archive'=>false,'menu_icon'=>'dashicons-format-quote','supports'=>array('title','editor','thumbnail')));
}
add_action('init','ahm_akram_register_content');
function ahm_akram_meta() {
    $fields=array('client','industry','services','channels','headline_kpi','kpi_list','challenge','strategy','what_i_did','results','tools','quote','quote_author','quote_company','year','featured','manual_order','linked_case','before_after');
    foreach(array('case_study','creative','testimonial') as $type) foreach($fields as $key) register_post_meta($type,'_ahm_'.$key,array('type'=>'string','single'=>true,'show_in_rest'=>true,'sanitize_callback'=>'sanitize_textarea_field','auth_callback'=>function(){return current_user_can('edit_posts');}));
}
add_action('init','ahm_akram_meta');
function ahm_akram_options() { add_options_page('Ahm Akram Portfolio','Ahm Akram','manage_options','ahm-akram','ahm_akram_options_page'); }
add_action('admin_menu','ahm_akram_options');
function ahm_akram_register_settings() {
    $text=array('ahm_role'=>'Freelance Performance Marketer','ahm_headline'=>'I grow online businesses with AI-driven performance marketing.','ahm_subline'=>'5+ years of SEO, Google, Meta and TikTok Ads, and Shopify growth, built around conversion and measurable revenue. Scroll to see the results.','ahm_linkedin'=>'','ahm_facebook'=>'','ahm_instagram'=>'','ahm_youtube'=>'','ahm_github'=>'','ahm_booking_url'=>'','ahm_whatsapp'=>'','ahm_email'=>'','ahm_accent'=>'#b6ff4a','ahm_seed'=>'2026','ahm_min_cards'=>'40','ahm_webhook'=>'','ahm_ga4'=>'','ahm_gtm'=>'');
    foreach($text as $key=>$default) register_setting('ahm_akram_options',$key,array('sanitize_callback'=>in_array($key,array('ahm_seed','ahm_min_cards'),true)?'absint':(strpos($key,'url')!==false?'esc_url_raw':(strpos($key,'email')!==false?'sanitize_email':'sanitize_text_field')),'default'=>$default));
    foreach(array('ahm_spend'=>'50000+','ahm_impressions'=>'126 million','ahm_clicks'=>'45 million+','ahm_leads'=>'1 million','ahm_sales'=>'80,000+','ahm_revenue'=>'164389','ahm_roas'=>'3.3','ahm_experience'=>'5+') as $key=>$default) register_setting('ahm_akram_options',$key,array('sanitize_callback'=>'sanitize_text_field','default'=>$default));
    foreach(array('ahm_placeholders','ahm_random_featured') as $key) register_setting('ahm_akram_options',$key,array('sanitize_callback'=>function($v){return $v==='1'?'1':'0';},'default'=>'1'));
}
add_action('admin_init','ahm_akram_register_settings');
function ahm_akram_options_page(){ if(!current_user_can('manage_options'))return; ?>
<div class="wrap"><h1>Ahm Akram Portfolio settings</h1><p>Update public profile and proof figures. Enter only verified client results in Case Studies.</p><form method="post" action="options.php"><?php settings_fields('ahm_akram_options'); ?><table class="form-table"><tbody>
<?php $fields=array('ahm_role'=>'Current role','ahm_headline'=>'Hero headline','ahm_subline'=>'Hero subline','ahm_experience'=>'Experience (display)','ahm_spend'=>'Total ad spend (display)','ahm_impressions'=>'Impressions (display)','ahm_clicks'=>'Clicks (display)','ahm_leads'=>'Leads generated (display)','ahm_sales'=>'Sales driven (display)','ahm_revenue'=>'Revenue generated (display)','ahm_roas'=>'Overall ROAS (number)','ahm_linkedin'=>'LinkedIn URL','ahm_facebook'=>'Facebook URL','ahm_instagram'=>'Instagram URL','ahm_youtube'=>'YouTube URL','ahm_github'=>'GitHub URL','ahm_booking_url'=>'Booking URL (Calendly/Cal.com)','ahm_whatsapp'=>'WhatsApp number (international digits)','ahm_email'=>'Contact email','ahm_accent'=>'Accent color (hex)','ahm_seed'=>'Default layout seed','ahm_min_cards'=>'Placeholder minimum card count','ahm_ga4'=>'GA4 measurement ID','ahm_gtm'=>'GTM container ID','ahm_webhook'=>'Optional CRM webhook URL'); foreach($fields as $key=>$label): ?><tr><th><label for="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></label></th><td><input class="regular-text" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr(get_option($key)); ?>"></td></tr><?php endforeach; ?>
<tr><th>Show abstract placeholder cards</th><td><label><input type="checkbox" name="ahm_placeholders" value="1" <?php checked(get_option('ahm_placeholders','1'),'1'); ?>> Enabled</label></td></tr><tr><th>Randomize featured case study order</th><td><label><input type="checkbox" name="ahm_random_featured" value="1" <?php checked(get_option('ahm_random_featured','1'),'1'); ?>> Enabled in browser</label></td></tr>
</tbody></table><?php submit_button(); ?></form><p><strong>Proof note:</strong> totals are displayed as supplied: 5+ years, $50,000+ spend, 126 million impressions, 45 million+ clicks, 1 million leads, 80,000+ sales, $164,389 revenue, ~3.3x ROAS.</p></div><?php }
function ahm_akram_contact_endpoint(){ register_rest_route('ahm-akram/v1','/contact',array('methods'=>'POST','callback'=>'ahm_akram_handle_contact','permission_callback'=>'__return_true')); }
add_action('rest_api_init','ahm_akram_contact_endpoint');
function ahm_akram_handle_contact(WP_REST_Request $request){
    $ip=isset($_SERVER['REMOTE_ADDR'])?sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])):'unknown'; $key='ahm_rate_'.md5($ip); $count=(int)get_transient($key); if($count>=5)return new WP_Error('rate_limit','Please wait before sending another message.',array('status'=>429)); set_transient($key,$count+1,HOUR_IN_SECONDS);
    if(!wp_verify_nonce((string)$request->get_header('X-WP-Nonce'),'wp_rest'))return new WP_Error('invalid_nonce','Please refresh the page and try again.',array('status'=>403));
    $data=$request->get_json_params(); if(!empty($data['website_confirm']))return new WP_REST_Response(array('ok'=>true),200);
    $name=sanitize_text_field($data['name']??'');$email=sanitize_email($data['email']??'');$message=sanitize_textarea_field($data['message']??''); if(!$name||!is_email($email)||!$message)return new WP_Error('invalid_form','Please complete the required fields.',array('status'=>400));
    $subject='Portfolio inquiry from '.$name; $body="Name: $name\nEmail: $email\nStore: ".sanitize_text_field($data['store']??'')."\nWhatsApp: ".sanitize_text_field($data['whatsapp']??'')."\nServices: ".sanitize_text_field($data['services']??'')."\nBudget: ".sanitize_text_field($data['budget']??'')."\n\n$message";
    $to=get_option('ahm_email',get_option('admin_email')); $sent=wp_mail($to,$subject,$body,array('Reply-To: '.$name.' <'.$email.'>'));
    $webhook=get_option('ahm_webhook',''); if($sent&&$webhook)wp_remote_post(esc_url_raw($webhook),array('timeout'=>3,'headers'=>array('Content-Type'=>'application/json'),'body'=>wp_json_encode(array('name'=>$name,'email'=>$email,'message'=>$message))));
    return $sent?new WP_REST_Response(array('ok'=>true),200):new WP_Error('mail_failed','Message could not be sent. Please use the email link.',array('status'=>500));
}
function ahm_akram_schema(){ if(!is_front_page())return; $schema=array('@context'=>'https://schema.org','@type'=>'Person','name'=>'AHM Akram','jobTitle'=>'AI-Driven Digital Marketing & Performance Marketing Specialist','address'=>array('@type'=>'PostalAddress','addressLocality'=>'Dhaka','addressCountry'=>'BD'),'url'=>home_url('/')); echo '<script type="application/ld+json">'.wp_json_encode($schema,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).'</script>'; }
add_action('wp_head','ahm_akram_schema',30);
function ahm_akram_body_class($classes){$classes[]='ahm-portfolio';return $classes;} add_filter('body_class','ahm_akram_body_class');
