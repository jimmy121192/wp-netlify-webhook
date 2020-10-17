<?php

/***************************************************************************************
 * REGISTER PLUGIN & ADMIN MENU
 **************************************************************************************/
add_action('admin_menu', 'nwh_menu_page');
function nwh_menu_page()
{
    add_menu_page(
        'WordPress Netlify Webhook', // page <title>Title</title>
        'Netlify Webhook', // menu link text
        'manage_options', // capability to access the page
        'netlify-webhook', // page URL slug
        'nwh_page_content', // callback function /w content
        'dashicons-rest-api', // menu icon
        5 // priority
    );
}
function nwh_page_content()
{
?><h1>Netlify Webhook Settings</h1>
    <form method="post" action="options.php">
        <?php settings_fields('nwh-settings'); ?>
        <?php do_settings_sections('nwh-settings'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Webhook URL:</th>
                <td>
                    <input type="text" name="nwh_info" class="regular-field" placeholder="https://" value="<?php echo get_option('nwh_info'); ?>" />
                    <p class="description">Enter your Netlify Builds Webhook URL. Must begin with http:// or https://.</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Enable automated deployment?</th>
                <td>
                    <?php $auto_enable = get_option('nwh_auto_enable'); ?>
                    <input type="checkbox" name="nwh_auto_enable" value="Yes" <?php echo ($auto_enable && $auto_enable == "Yes") ? "checked" : ""; ?> />
                    <label for="nwh_auto_enable"> Yes</label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Trigger a new build</th>
                <td>
                    <form method="post">
                        <input type="hidden" name="nwh_deploy" id="trigger" value="on" />
                        <input type="submit" id="trigger-build" value="Deploy" />
                    </form>
                    <?php
                    function trigger_build()
                    {
                        $nwh_deploy =  get_option('nwh_deploy');
                        if ($nwh_deploy == "on") {
                            echo "Build processing...";
                            $nwh_info = get_option('nwh_info');
                            $url = curl_init($nwh_info);
                            curl_setopt($url, CURLOPT_CUSTOMREQUEST, 'POST');
                            curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
                            curl_exec($url);
                            update_option('nwh_deploy', 'off');
                        }
                    }
                    trigger_build()
                    ?>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
<?php
}
add_action('admin_init', 'update_nwh_settings');
function update_nwh_settings()
{
    register_setting('nwh-settings', 'nwh_info');
    register_setting('nwh-settings', 'nwh_deploy');
    register_setting('nwh-settings', 'nwh_auto_enable');
}
function nwh_info($content)
{
    $nwh_info = "";
    return $content . $nwh_info;
}
add_filter('the_content', 'nwh_info');
?>