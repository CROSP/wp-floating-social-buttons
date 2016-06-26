<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once(dirname( __FILE__ ) .'/abstract/interface-admin-page.php');
require_once(dirname( __FILE__ ) .'/class-plugin-settings.php');
require_once(ABSPATH .'wp-includes/pluggable.php');
class Floating_Share_Buttons_Admin implements Admin_Page {
	const SOCIAL_BUTTON_TAB  = 'social_buttons';
	  /**
     * The unique instance of the plugin.
     *
     * @var Floating_Share_Buttons_Admin
     */
    private static $instance;
    private $base_settings_url;
    private $current_tab;
    private $plugin_url;
    private $social_buttons;
    private $buttons_output_html = "";
    /**
     * Gets an instance of our plugin.
     *
     * @return Floating_Share_Buttons_Admin
     */
    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
 
        return self::$instance;
    }
    public function __construct () {

       $this->base_settings_url = admin_url('options-general.php?page=floating_social_buttons');
       $this->current_tab = isset($_GET['tab']) ? $_GET['tab'] : '';
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $this->update_settings();
       }
  	}
  	public function init() {
        add_filter( 'plugin_action_links_' . FSSB_PLUGIN_FILE_URL, array( $this, 'add_settings_link' ));
        add_action( 'admin_menu', array( $this, 'add_option_page' ));
        add_action( 'admin_init',array($this,'register_settings'));
        add_action( 'admin_enqueue_scripts',array($this,'enqueue_scripts'));
  	}
    public function save_changes() {

    }
    public function register_settings() {
       if($this->current_tab === self::SOCIAL_BUTTON_TAB) {
       		add_option(
            'fssb_social_buttons_data',
            Settings::$default_settings['fssb_social_buttons']
          );
       } else {
          add_option(
            'fssb_enable',
            Settings::$default_settings['fssb_enable']
          );
          add_option(
            'fssb_show_shares_count',
            Settings::$default_settings['fssb_show_shares_count']
          );
          add_option(
            'fssb_floating_position',
            Settings::$default_settings['fssb_floating_position']
          );
          add_option(
            'fssb_share_popup_prefix',
            Settings::$default_settings['fssb_share_popup_prefix']
          ); 
          add_option(
            'fssb_button_shape',
            Settings::$default_settings['fssb_button_shape']
          );
      }
    }
    public function render() {
        $this->render_settings_page();
    }
    public function submit() {

    }
    public function update_settings() {
      if(wp_verify_nonce( $_POST['update-settings'], 'fssb_update_settings' )) {
        switch ($this->current_tab) {
          case self::SOCIAL_BUTTON_TAB:
            // Handle social buttons update
          	if(isset($_POST['fssb_social_buttons_data'])) {
          		update_option('fssb_social_buttons_data',$_POST['fssb_social_buttons_data']);
          	}
            break;
          default:
            // Just use default settings keys for updating option
            foreach (Settings::$default_settings as $key => $value) {
                update_option($key,isset($_POST[$key]) ? $_POST[$key] : Settings::$default_settings[$key]);
            };
            break;
        }
      }
      else {
         die("You shall not pass !!");
      }
    }
    public function load_defaults() {
    	
    }
    private function generate_button_html($btn_id,$btn_data) {
    	$output = "";
		$output .= '<li id="'. $btn_id . '" class="list-group-item sb-item'
		 . ($btn_data->enabled != '1' ? ' sb-disabled-item' : '') . '">';
		$output .= '<div id="' . $btn_id . '" class="sb-item-container">';
		$output .= '<div class="sb-enable">
						<input class="sb-enable-checkbox" type="checkbox" name="sb_enable" value="' . $btn_data->enabled . '"'
						. ($btn_data->enabled == '1' ? 'checked="checked"' : '') .'/>
						</div>';
			$output .= '<div class="sb-icon">';
			if (!filter_var($btn_data->icon, FILTER_VALIDATE_URL) === false) {
				$output .= '<img class="sb-image-icon" src="' 
				. $btn_data->icon . '" alt="'.$btn_data->title . '">';
			}
			else {
				// TODO support other icons
				$output .= '<i class="fa ' . $btn_data->icon .' fa-fw" style="color:'. $btn_data->icon_text_color . '" aria-hidden="true"></i>';
			}
			$output .= '</div>';
			$output .= '<div class="sb-title"><p>' . $btn_data->title . '</p></div>';
			$output .= '<div class="sb-controls">
    					<i class="js-edit fa fa-pencil-square-o fa-fw"></i>
    					<i class="js-remove fa fa-times fa-fw"></i>
  					</div>
					</li>';
        return $output;
    }
    public function enqueue_scripts() {
      $current_screen = get_current_screen();
      if($current_screen->base == FSSB_SETTINGS_PAGE_URL) {
          wp_register_style('admin-settings-css', FSSB_PLUGIN_DIR . '/css/admin-settings.css');
          wp_enqueue_style( 'admin-settings-css');
          if($this->current_tab === 'social_buttons') {
              wp_register_style('ply-css', FSSB_PLUGIN_DIR . '/css/ply.css');
              wp_enqueue_style( 'ply-css');          
              wp_register_style('font-awesome-css', FSSB_PLUGIN_DIR . '/css/font-awesome.min.css');
              wp_enqueue_style( 'font-awesome-css');
              wp_register_script( 'sortable_js', FSSB_PLUGIN_DIR . '/js/Sortable.min.js', array(), '1.0');
              wp_enqueue_script( 'sortable_js' );
              wp_register_script( 'ply_js', FSSB_PLUGIN_DIR . '/js/Ply.min.js', array(), '1.0');
              wp_enqueue_script( 'ply_js' ); 
              wp_register_script( 'admin-settings-js',FSSB_PLUGIN_DIR . '/js/admin-settings.js', array(), '1.0');
              wp_enqueue_script( 'admin-settings-js' );
          }         

      }
    }
    private function pass_data_to_javascript() {
    	 update_option('fssb_social_buttons_data',Settings::$default_settings['fssb_social_buttons']);
    	 $social_buttons_data = get_option('fssb_social_buttons_data');
    	 $social_buttons_data = json_decode($social_buttons_data);
    	 ?>
     	 <script type="text/javascript">
        	var socialButtons = {};
        	<?php 
        		foreach($social_buttons_data as $button_id => $button_data) {
        			if(!empty($button_id) && !empty($button_data)) {
        				echo 'socialButtons["' . $button_id . '"] = JSON.parse(\'' . json_encode($button_data). '\');' . "\n";
        				$this->buttons_output_html .= $this->generate_button_html($button_id,$button_data);
        			}
        		}

        	?> 
        
     	 </script>
      <?php
    }
    // Add Settings link in plugin description in link list
    public function add_settings_link( $links ) {
        $url = get_admin_url() . 'options-general.php?page=' . FSSB_UNIQUE_ID;
        $settings_link = '<a href="'.$url.'">' . __( 'Settings', FSSB_DOMAIN ) . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }
    public function add_option_page() {
        // Render will be invoked on click
        add_options_page(__(FSSB_NAME,FSSB_DOMAIN), __('Floating Social Buttons',FSSB_DOMAIN), 'manage_options', FSSB_UNIQUE_ID , array($this,'render'));
    }
    // RENDER SECTION
    private function render_settings_page() {
    ?>
      <div class="wrap">
          <h1><?php esc_html_e( FSSB_NAME , FSSB_DOMAIN);?></h1>
          <?php echo $this->render_settings_tabs(); ?>
            <form id="fssb_submit_form" method="post" action="">
            <?php $this->render_main_form(); ?>
            <?php @submit_button(); ?>
            </form>
      </div>
    <?php
    }
    private function render_settings_tabs() {
		if($this->current_tab === self::SOCIAL_BUTTON_TAB) {
			$this->pass_data_to_javascript();
		}
      $output = '<h2 class="nav-tab-wrapper">';
      foreach( Settings::$view_settings_constants['tabs'] as $tab => $value ){
        $class = ( $value['argument'] === $this->current_tab ) ? ' nav-tab-active' : '';
        // Generating 
        $output .= '<a id="nav-tab-' . $tab . '" class="nav-tab' . $class . '" href="' . $this->base_settings_url 
        . (!empty($value['argument']) ? '&tab=' . $value['argument'] : ''). '">'. $value['title'] . ' </a>';
      }
      $output .= '</h2>';
      return $output;
    }
    private function render_main_form() {
        wp_nonce_field( 'fssb_update_settings', 'update-settings' );
        switch ($this->current_tab) {
          case self::SOCIAL_BUTTON_TAB:
            $this->render_social_buttons_settings_tab();
            break;
          default:
            $this->render_general_settings_tab();
            break;
        }
    }
    
    private function render_general_settings_tab() {

      ?>

          <table class="form-table">
          <tr valign="top">
            <th scope="row">
              <?php _e( "Enable ", FSSB_DOMAIN ); ?>
            </th>
            <td>
              <label for="fssb_enable">
              <input name="fssb_enable" type="checkbox" id="fssb_enable" value="1" 
              <?php checked('1', get_option('fssb_enable')); ?> />
              <?php _e( "Enable floating buttons", FSSB_DOMAIN ); ?>
              </label><br />
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">
              <?php _e( "Show shares count ", FSSB_DOMAIN ); ?>
            </th>
            <td>
              <label for="fssb_show_shares_count">
              <input name="fssb_show_shares_count" type="checkbox" id="fssb_show_shares_count" value="1" 
              <?php checked('1', get_option('fssb_show_shares_count')); ?> />
              <?php _e( "Show number of shares", FSSB_DOMAIN ); ?>
              </label><br />
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">
              <label for="fssb_share_popup_prefix">
              <?php _e( "Share popup prefix ", FSSB_DOMAIN ); ?>
              </label>
            </th>
            <td>
              <input name="fssb_share_popup_prefix" type="text" id="fssb_share_popup_prefix" value="<?php form_option('fssb_share_popup_prefix'); ?>"/>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">
              <label for="fssb_floating_position">
              <?php _e( "Floating buttons block position", FSSB_DOMAIN ); ?>
              </label>
            </th>
            <td>
                <select name="fssb_floating_position" id="fssb_floating_position">
                    <?php 
                    $selected = get_option('fssb_floating_position');
                    $selected = (!empty($selected) && $selected !== false) ?  $selected : 'verically-left';
                    foreach( Settings::$settings_constants['fssb_floating_position'] as $option => $value ){
                        echo '<option value="' . $option . '"' . ( $selected === $option ? ' selected="selected"' : '').'">' . $value . '</option>';
                    }
                    ?>
                   
                </select>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">
              <label for="fssb_button_shape">
              <?php _e( "Background button shape ", FSSB_DOMAIN ); ?>
              </label>
            </th>
            <td>
                <select name="fssb_button_shape" id="fssb_button_shape">
                    <?php 
                    $selected = get_option('fssb_button_shape');
                    $selected = (!empty($selected) && $selected !== false) ?  $selected : Settings::$default_settings['fssb_button_shape'];
                    foreach( Settings::$settings_constants['fssb_button_shape'] as $option => $value ){
                        echo '<option value="' . $option . '"' . ( $selected === $option ? ' selected="selected"' : '').'">' . $value . '</option>';
                    }
                    ?>
                   
                </select>
            </td>
          </tr>
      </table>
      <?php
    }

    private function render_social_buttons_settings_tab() {
        ?>
        <div class="header-container">
            <h2 class="section-header">Social buttons settings</h2>
            <p>You can add, edit and remove social buttons</p>
        </div>
        <div class="sb-list-container">
            <ul id="sb-list" class="list-group">
            	<?php echo $this->buttons_output_html; ?>
            </ul>
            <div class="hidden-option"><input name="fssb_social_buttons_data" type="hidden" id="fssb_social_buttons_data" 
            value=""/></div>
            <div id="sb-edit-item-container">asdsadsadsadsadsadsadasdasdasdasdas</div>
        </div>
        <?php
    }
}