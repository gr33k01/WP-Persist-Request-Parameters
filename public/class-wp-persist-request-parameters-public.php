<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       natehobi.com
 * @since      1.0.0
 *
 * @package    Wp_Persist_Request_Parameters
 * @subpackage Wp_Persist_Request_Parameters/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Persist_Request_Parameters
 * @subpackage Wp_Persist_Request_Parameters/public
 * @author     Nate Hobi <nate.hobi@gmail.com>
 */
class Wp_Persist_Request_Parameters_Public {

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
	 * Array of request parameters to persist
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $parameters_to_persist    Array of request parameters to persist
	 */
	private $parameters_to_persist;

	/**
	 * Flag for option to save to Gravity Forms
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      bool    $save_to_gravity_forms    Flag for option to save to Gravity Forms.
	 */
	private $save_to_gravity_forms;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;

		$this->version = $version;

		$this->parameters_to_persist = $this->get_request_parameters_array();

		$this->save_to_gravity_forms = true;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-persist-request-parameters-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-persist-request-parameters-public.js', array( 'jquery', 'js-cookie' ), $this->version, false );
		wp_register_script( 'js-cookie', plugin_dir_url( __FILE__ ) . '/../../bower_components/js-cookie/src/js.cookie.js', array(), $this->version, false );
		
		$this->localize_script();
		wp_enqueue_script( $this->plugin_name );
	}

	/**
	 * Pre submission Gravity Froms hook
	 *
	 * @since    1.0.0
	 */
	public function pre_submission( $form ) {

		if ( ! $this->save_to_gravity_forms ) return;

		foreach( $this->parameters_to_persist as $param ) {
			$this->save_to_hidden_field( $param, $form );
		}
	}

	/**
	 * Save cookie value to hidden input with matching label
	 *
	 * @since    1.0.0
	 */
	private function save_to_hidden_field( $param, $form ) {
		$input_id = $this->get_input_id_from_label( $param, $form);
		if(isset($_COOKIE[$param]) && isset($input_id)) {
			$_POST[$input_id] = $_COOKIE[$param];	
		}
	}

	/**
	 * Get Gravity Forms input ID from label
	 *
	 * @since    1.0.0
	 */
	private function get_input_id_from_label( $label, $form )
	{
	    foreach( $form['fields'] as $field)
	    {
	    	var_dump($field); exit();
	    	
	        if ( strtolower($field->label) === strtolower($label) ) {
	            return 'input_' . strval($field->id);
	        }
	        
	        // Check Subfields
	        if ( isset($field->inputs) )  {
	            foreach($field->inputs as $sub_field) {
	                if ( strtolower($sub_field['label']) === strtolower($label) || strtolower($sub_field['customLabel']) === strtolower($label)) {
	                    return 'input_' . str_replace('.', '_', strval($sub_field['id']));
	                }
	            }
	        }
	    }
	    
	    return null;
	}

	/**
	 * Use script localization to make settings avalible to script
	 *
	 * @since    1.0.0
	 */

	private function localize_script() {
		$value_arr = array(
			'valuesToPersist' => $this->parameters_to_persist
			);

		wp_localize_script( $this->plugin_name, 'prpValues', $value_arr );
	}


	/**
	 * Return array of parameters to persist from setting
	 *
	 * @since    1.0.0
	 */
	private function get_request_parameters_array() {
		$params = split( ',', get_option( 'wp_prp_parameters_to_track' ) );

		for( $i = 0; $i < count( $params ); $i++ ) {
			$params[$i] = strtolower(trim($params[$i]));
		}

		return $params;
	}
}
