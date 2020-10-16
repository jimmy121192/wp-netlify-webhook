<?php
/***************************************************************************************
 * HOOKS
 **************************************************************************************/
add_action('publish_future_post', 'nb_webhook_future_post', 10);
add_action('publish_post', 'nb_webhook_post', 10, 2);
//add_action('publish_page', 'nb_webhook_post', 10, 2);
add_action('post_updated', 'nb_webhook_update', 10, 3);


function nb_webhook_future_post( $post_id ) {
  nb_webhook_post($post_id, get_post($post_id));
}
function nb_webhook_update($post_id, $post_after, $post_before) {
  nb_webhook_post($post_id, $post_after);
}
function nb_webhook_post($post_id, $post) {
  $nwh_info = get_option( 'nwh_info' ); 
  $nwh_auto_enable = get_option( 'nwh_auto_enable' ); 
  if ($post->post_status === 'publish' && $nwh_auto_enable == "Yes") {
    $url = curl_init($nwh_info);
    curl_setopt($url, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
    curl_exec($url);
  }
}
