<?php
/**
 * Class IntegrationInsightlyCalderaforms.
 *
 * @package integration-insightly-calderaforms
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'IntegrationInsightlyCalderaforms', false ) ) :

    /**
     * IntegrationInsightlyCalderaforms Class
     */
	class IntegrationInsightlyCalderaforms {

        /**
        * Member Variable
        *
        * @var object instance
        */
        private static $instance;

        /**
         * Returns the *Singleton* instance of this class.
         *
         * @return Singleton The *Singleton* instance.
         */
        public static function get_instance() {
            if ( null === self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Class Constructor
         *
         * @since  1.0.0
         * @return void
         */
		public function __construct() {

			// Load text domain
			add_action( 'plugins_loaded', array( $this, 'iicf_plugin_load_textdomain' ) );

			// Check whether Caldera form is active or not
			register_activation_hook( __FILE__, array( $this, 'iicf_integration_activate' ) );

            //Register Processor Hook
	   	   add_filter( 'caldera_forms_get_form_processors',  array( $this, 'iicf_register_processor' ) );

		}

		/**
	 	* Check Caldera Forms is active or not
		*
		* @since 1.0.0
        * @return void
		*/
	    public function iicf_integration_activate( $network_wide ) {
			if( ! function_exists( 'caldera_forms_load' ) ) {
			    wp_die( 'The "Caldera Forms" Plugin must be activated before activating the "Integration of Insightly and Caldera Forms" Plugin.' );
			}
		}

        /**
         * Load plugin textdomain.
         *
         * @since 1.0.0
         * @return void
        */
		public function iicf_plugin_load_textdomain() {
			load_plugin_textdomain( 'integration-insightly-calderaforms', false, basename( dirname( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Add Our Custom Processor
		 *
		 * @uses "caldera_forms_get_form_processors" filter
		 *
		 * @since 1.0.0
		 *
		 * @param array $processors
		 * @return array Processors
		*/
		public function iicf_register_processor( $processors ) {
		  	$processors['cf_insightly_integration'] = array(
				'name'              =>  __( 'Insightly Integration', 'integration-insightly-calderaforms' ),
				'description'       =>  __( 'Send Caldera Forms submission data to Insightly using Insightly REST API.', 'integration-insightly-calderaforms' ),
				'pre_processor'		=>  array( $this, 'cf_insightly_integration_processor' ),
				'template' 			=>  __DIR__ . '/config.php'
			);
			return $processors;
		}

		/**
		 * Send data to Insightly using Caldera Processor
         *
		 * @param array $config Processor config
		 * @param array $form Form config
		 * @param string $process_id Unique process ID for this submission
		 * @since 1.0.0
		 * @return void|array
		*/
	   	public function cf_insightly_integration_processor( $config, $form, $process_id ) {

            if( ! isset( $config['iicf_insightly_api_key'] ) || empty( $config['iicf_insightly_api_key'] ) ) {
                return;
		  	}

            if( ! isset( $config['iicf_insightly_api_url'] ) || empty( $config['iicf_insightly_api_url'] ) ) {
                return;
		  	}
      	    if( ! isset( $config['iicf_insightly_obj'] ) || empty( $config['iicf_insightly_obj'] ) ) {
			    return;
		  	}

            $insightly_api_key    = Caldera_Forms::do_magic_tags( $config['iicf_insightly_api_key'] );
            $insightly_api_url    = Caldera_Forms::do_magic_tags( $config['iicf_insightly_api_url'] );
            $insightly_first_name = Caldera_Forms::do_magic_tags( $config['iicf_insightly_first_name'] );
            $insightly_last_name  = Caldera_Forms::do_magic_tags( $config['iicf_insightly_last_name'] );
            $insightly_email      = Caldera_Forms::do_magic_tags( $config['iicf_insightly_email'] );


    	  	/* Saving form submission data into insightly using  insightly REST API*/
    	 	$wp_version                = get_bloginfo( 'version' );
    		$header                    = [];
            $header['Authorization']   = 'Basic '.$insightly_api_key ;
            $header['Accept-Encoding'] = 'gzip';
            $header['content-type']    = 'application/json';
            $header['cache-control']   = 'no-cache';

            //Prepare form data
            $arr = array(
                "FIRST_NAME" => $insightly_first_name,
                "LAST_NAME" => $insightly_last_name,
                "EMAIL_ADDRESS" => $insightly_email,
            );

            //Insightly API URL
            $url = $insightly_api_url.'/v3.1/Contacts';

            //Prepare Insightly arguments for API call
            $args = array(
                'body'      => json_encode( $arr ),
                'headers'   => $header,
                'timeout'   => 45
            );

            // pushing form data into Insightly account
            try {

                $results    = wp_remote_post( $url, $args );
                $code       = wp_remote_retrieve_response_code( $results );

                if( intval( $code ) !== 200 ) {
                    return;
                }

            } catch ( Exception $e ) {

            }

		}

	}

	/**
      * Calling class using 'get_instance()' method
    */
    IntegrationInsightlyCalderaforms::get_instance();

endif;
