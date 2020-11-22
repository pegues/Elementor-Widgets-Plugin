<?php
namespace VSElementorElements;

use VSElementorElements\Widgets\PostFilter;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.0.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
 	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {
		wp_register_script('vs-elementor-elements-js-slick', plugins_url('/assets/js/testwidget.js', __FILE__), ['jquery'], false, true);
	}

	/**
	 * widget_styles
	 *
	 * Load required plugin core files.
	 *
 	 * @since 1.2.0
	 * @access public
	 */
	public function widget_styles() {
		wp_register_style('vs-elementor-elements-css-bannerslider', plugins_url('assets/css/testwidget.css', __FILE__));
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once(__DIR__ . '/widgets/testwidget.php');	    // Test
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\TestWidget());           // Test
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register widget scripts
		add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);

		// Register widget styles
		add_action('elementor/frontend/after_enqueue_styles', [$this, 'widget_styles']);

		// Register widgets
		add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);

		/**
         * Following 2 actions are added to be use in ajax based posts filter
		 */
        add_action('wp_ajax_vs_elementor_postfilter_load_posts', [$this, 'vs_elementor_postfilter_load_posts']);
        add_action('wp_ajax_nopriv_vs_elementor_postfilter_load_posts', [$this, 'vs_elementor_postfilter_load_posts']);

        /**
         * Following action is used for registering custom elements
         */
        add_action('elementor/elements/elements_registered', [$this, 'register_elements']);
    }


    public function vs_elementor_postfilter_load_posts ()
    {
        /**
         * @note: got help from here: https://github.com/elementor/elementor/issues/4670
         */
        $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $_REQUEST['post_id'], true );
        $return = [];
        $return['html'] = $content;
        $posted_params = [];
        $posted_params = $this->prepare_posted_params($posted_params, $_POST);
        $return['posted_params'] = $posted_params;

        echo json_encode($return);
        wp_die();
    }

    private function prepare_posted_params($posted_params, $data, $key_prfex='')
    {
        if ($key_prfex != '') {
            $key_prfex .= '_';
        }

        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $posted_params = $this->prepare_posted_params($posted_params, $v, $key_prfex.$k);
            } else {
                $posted_params[$key_prfex.$k] = $v;
            }
        }

        return $posted_params;
    }

    private function include_elements_files()
    {
        require_once(__DIR__ . '/elements/innersection.php');// Elements: Innersection
    }

    public function register_elements()
    {
        $this->include_elements_files();
        \Elementor\Plugin::instance()->elements_manager->register_element_type(new Elements\Innersection());
    }

}

// Instantiate Plugin Class
Plugin::instance();
