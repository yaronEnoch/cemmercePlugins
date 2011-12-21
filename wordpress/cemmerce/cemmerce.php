<?php
/*
Plugin Name: Cemmerce Embed Code Plugin
Plugin URI: N.A.
Description: Adds Cemmerce Embed Code to your blog
Version: 0.1
Author: Zohar Arad
Author URI: http://www.zohararad.com
License: N.A
*/

//register cemmerce settings menu
add_action('admin_menu', 'cemmerce_menu');

// add settings page and init admin settings
function cemmerce_menu() {
  add_menu_page('Cemmerce Embed Code Settings', 'Cemmerce Settings', 'administrator', __FILE__, 'cemmerce_settings_page',null);
  add_action( 'admin_init', 'register_cemmerce_settings' );
}

// register publisher_ID options field
function register_cemmerce_settings() {
  //register our settings
  register_setting( 'cemmerce-settings-group', 'publisher_ID' );
}

// render embed code settings page
function cemmerce_settings_page() {
  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  } ?>
  <div class="wrap">
    <h2>Cemmerce Embed Code Settings</h2>
    <form method="post" action="options.php"><?php
      settings_fields( 'cemmerce-settings-group' ); ?>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">Publisher ID</th>
          <td><input type="text" name="publisher_ID" value="<?php echo get_option('publisher_ID'); ?>" /></td>
        </tr>
        <tr valign="top">
          <th scope="row">&nbsp;</th>
          <td><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></td>
        </tr>
      </table>
    </form>
 </div><?php
}

// add embed code to footer - filter function
function add_embed_code(){?>
  <script type="text/javascript">
    function addCemmerceEmbedCode(){
      var s = document.createElement('script');
      s.type = 'text/javascript'; s.async = true;
      s.src = '';
      document.getElementsByTagName('body')[0].appendChild(s); 
    }
    
    var cemmerce;
    window.cemmerceAsync = function(App){
      var publisher_ID = '<?php echo get_option('publisher_ID'); ?>'
      cemmerce = new App('cemmerce',publisher_ID);
    }
    if(typeof(jQuery) !== 'undefined'){
      $(document).ready(addCemmerceEmbedCode);
    } else {
      addCemmerceEmbedCode();
    }
  </script>
  <?php
}
// register add_embed_code filter to wp_footer hook
add_filter('wp_footer','add_embed_code');
?>