<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       natehobi.com
 * @since      1.0.0
 *
 * @package    Wp_Persist_Request_Parameters
 * @subpackage Wp_Persist_Request_Parameters/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Persist_Request_Parameters
 * @subpackage Wp_Persist_Request_Parameters/admin
 * @author     Nate Hobi <nate.hobi@gmail.com>
 */
class Wp_Persist_Request_Parameters_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The options prefix to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_prefix 	Option prefix of this plugin
	 */
	private $option_prefix = 'wp_prp';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Persist_Request_Parameters_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Persist_Request_Parameters_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-persist-request-parameters-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Persist_Request_Parameters_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Persist_Request_Parameters_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-persist-request-parameters-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Calls WP add_menu_page
	 *
	 * @since    1.0.0
	 */
	public function display_admin_page() {
		add_menu_page(
			'Persist Request Parameters',
			'Persist Request Parameters',
			'manage_options',
			'wp_persist_request_parameters_admin',
			array( $this, 'show_page' ),
			'dashicons-editor-code',
			'50.0'
			);
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function show_page() {
		include __DIR__ . '/partials/wp-persist-request-parameters-admin-display.php';
	}

	/**
	 * Registers settings for admin area.
	 *
	 * @since    1.0.0
	 */
	public function register_setting() {
		// Adds a General section
		add_settings_section(
			$this->option_prefix . '_general',
			__( 'General', 'wp-prp' ),
			array( $this, $this->option_prefix . '_general_cb' ),
			$this->plugin_name
			);

		// Adds 'Parameters to track' field in General secion
		add_settings_field(
			$this->option_prefix . '_parameters_to_track',
			__( 'Parameters to track', 'wp-prp' ),
			array( $this, $this->option_prefix . '_parameters_to_track_cb' ),
			$this->plugin_name,
			$this->option_prefix . '_general',
			array( 'label_for' => $this->option_prefix . '_parameters_to_track' )
			);

		// Registers the 'Parameters to track' field
		register_setting( $this->plugin_name, $this->option_prefix . '_parameters_to_track', array( $this, $this->option_prefix . '_sanitize_parameters_to_track' ) );


		// Adds 'Save to Gravity Forms hidden fields' field in General secion
		add_settings_field(
			$this->option_prefix . '_save_to_gf_hidden_fields',
			__( 'Save to Gravity Forms', 'wp-prp' ),
			array( $this, $this->option_prefix . '_save_to_gf_hidden_fields_cb' ),
			$this->plugin_name,
			$this->option_prefix . '_general',
			array( 'label_for' => $this->option_prefix . '_save_to_gf_hidden_fields' )
			);

		// Registers the 'Parameters to track' field
		register_setting( $this->plugin_name, $this->option_prefix . '_save_to_gf_hidden_fields', array( $this, $this->option_prefix . '_sanitize_save_to_gf_hidden_fields' ) );
	}

	/**
	 * Render the text for the general section.
	 *
	 * @since  1.0.0
	 */
	public function wp_prp_general_cb() {
		echo '<hr />';
	}

	/**
	 * Render the markup for the Parameters to track field
	 *
	 * @since  1.0.0
	 */
	public function wp_prp_parameters_to_track_cb() {
		$f_id = $this->option_prefix . '_parameters_to_track';
		$value = get_option($f_id);
	?>
		<input type="text" name="<?php echo $f_id; ?>" id="<?php echo $f_id; ?>"  value="<?php echo $value; ?>"/>
		<em class="description">A comma-seperated list of URL parameters to persist across a user's session using cookies.</em>
	<?php
	}

	/**
	 * Placeholder for Parameters to track sanitize
	 *
	 * @since  1.0.0
	 */
	public function wp_prp_sanitize_parameters_to_track( $value ) {
		return $value;
	}

	/**
	 * Render the markup for the Save to Gravity Forms hidden fields field
	 *
	 * @since  1.0.0
	 */
	public function wp_prp_save_to_gf_hidden_fields_cb() {
		$f_id = $this->option_prefix . '_save_to_gf_hidden_fields';
		$option = get_option($f_id);
	?>
		<input type="checkbox" name="<?php echo $f_id; ?>" id="<?php echo $f_id; ?>"  value="1" <?php checked(1, $option); ?> />
		<em class="description">When this option is enabled, a Gravity Forms hook will attempt save each the above parameters to a hidden field with a matching label. <strong>Note: this will only work with hidden fields.</strong></em>
	<?php
	}

	/**
	 * Placeholder for Save to Gravity Forms hidden fields sanitize
	 *
	 * @since  1.0.0
	 */
	public function wp_prp_sanitize_save_to_gf_hidden_fields( $value ) {
		return $value;
	}

}
