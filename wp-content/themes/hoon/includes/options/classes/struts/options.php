<?php

class Struts_Options {
	protected $_sections, $_all_options, $_name, $_slug, $_page_name, $_stranded_options;

	public function __construct( $slug, $name, $page_name ) {
		$this->sections( array() );
		$this->all_options( array() );
		$this->stranded_options( array() );
		$this->slug( $slug );
		$this->name( $name );
		$this->page_name( $page_name );
		$this->register_hooks();
	}

	/***** Attribute accessors *****/

	// Sections are containers for options
	public function sections( $sections = NULL ) {
		if ( NULL === $sections )
			return $this->_sections;

		$this->_sections = $sections;

		return $this;
	}

	// Every option added, regardless of whether it was added to a section or not.
	// This is useful for efficiently setting/getting option values without scanning all sections.
	public function all_options( $all_options = NULL ) {
		if ( NULL === $all_options )
			return $this->_all_options;

		$this->_all_options = $all_options;

		return $this;
	}

	// All options without a section.
	public function stranded_options( $stranded_options = NULL ) {
		if ( NULL === $stranded_options )
			return $this->_stranded_options;

		$this->_stranded_options = $stranded_options;

		return $this;
	}

	public function slug( $slug = NULL ) {
		if ( NULL === $slug )
			return $this->_slug;

		$this->_slug = $slug;

		return $this;
	}

	public function name( $name = NULL ) {
		if ( NULL === $name )
			return $this->_name;

		$this->_name = $name;

		return $this;
	}
	
	public function page_name( $page_name = NULL ) {
		if ( NULL === $page_name )
			return $this->_page_name;

		$this->_page_name = $page_name;

		return $this;
	}


	/***** WordPress setup *****/

	public function register_hooks() {
		// Load the Admin Options page
		add_action( 'admin_menu', array( &$this, 'add_theme_options_page' ) );
		// Register the sections and options
		add_action( 'admin_init', array( &$this, 'register' ) );
		// Enqueue the styles and scripts
		add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
	}

	public function enqueue_scripts() {
		$enqueue_scripts =
			is_admin()
			&&
			current_user_can( 'edit_theme_options' )
			&&
			isset( $_GET['page'] )
			&&
			$_GET['page'] == $this->slug();

		if ( $enqueue_scripts ) {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'farbtastic' );
			wp_enqueue_script(
				'struts-admin',
				Struts::config( 'struts_root_uri' ) . '/javascripts/struts.js',
				array( 'jquery', 'media-upload' ),
				null
			);

			add_thickbox();

			wp_enqueue_style( 'farbtastic' );

			if ( Struts::config( 'use_struts_skin' ) ) {
				wp_enqueue_style(
					'struts-admin',
					Struts::config( 'struts_root_uri' ) . '/stylesheets/struts.css'
				);
			}
		}
	}

	public function initialize() {
		$option_values = get_option( $this->name() );

		if ( false === $option_values || empty( $option_values ) ) {
			$option_values = $this->defaults();
		}
		update_option( $this->name(), $option_values );

		foreach ( $this->all_options() as $option ) {
			if ( isset( $option_values[$option->name()] ) ) {
				$option->value( $option_values[$option->name()] );
			} else {
				$option->value( $option->default_value() );
			}
		}
	}

	public function add_theme_options_page() {
		add_theme_page(
			__( $this->page_name(), 'hoon' ),
			__( $this->page_name(), 'hoon' ),
			'edit_theme_options',
			$this->slug(),
			array( &$this, 'echo_form_html' ) );
	}

	public function register() {
		register_setting( $this->name(), $this->name(), array( &$this, 'validate' ) );
		$this->register_sections();
		$this->register_stranded_options();
	}

	protected function register_stranded_options() {
		foreach( $this->stranded_options() as $option ) {
			$option->register();
		}
	}

	protected function register_sections() {
		foreach( $this->sections() as $section ) {
			$section->register();
		}
	}

	public function validate( $inputs ) {
		$validated_input = array();

		if ( isset( $inputs['struts_reset'] ) ) {
			$validated_input = $this->defaults();
		} else {
			$all_options = $this->all_options();

			foreach ( $inputs as $key => $value ) {
				if ( isset(  $all_options[$key] ) ) {
					$option = $all_options[$key];
					$validated_input[$key] = $option->validate( $value );
				}
			}
		}

		return $validated_input;
	}

	/**
	 *
	 */
	public function add_section( $id, $title, $description = NULL ) {
		$this->_sections[$id] = new Struts_Section( $id, $title, $description, $this->name() );
	}

	/**
	 * Adds an option with the given name and type to this collection
	 * Sets the option's parent_name to this collection's name, and returns the option
	 *
	 * @param $name - unique (within the collection ) name for this option
	 * @param $type - type of option (text/select/checkbox/etc)
	 * @param $section - name of the section this option goes in
	 *
	 * @return Struts_Option
	 */
	public function add_option( $name, $type, $section = NULL ) {
		$option_class = 'Struts_Option_' . ucfirst( $type );

		$option = new $option_class;
		$option->name( $name );
		$option->parent_name( $this->name() );

		if ( NULL !== $section ) {
			$sections = $this->sections();
			if ( ! isset( $sections[$section] ) ) {
				throw new SectionNotFoundException( sprintf( __( 'Section with name &lsquo;%1$s&rsquo; not defined', 'hoon' ), esc_html( $section ) ) );

			}

			$option->section( $section );
			$sections[$section]->add_option($option);
		} else {
			// No section provided
			$this->_stranded_options[$name] = $option;
		}

		$this->_all_options[$name] = $option;

		return $option;
	}

	public function get_value( $option_name ) {
		$options = $this->all_options();
		if ( isset( $options[$option_name] ) ) {
			$option = $options[$option_name];
			return $option->value();
		} else {
			return NULL;
		}
	}

	/**
	 * Returns the default values of all options in this collection as a hash
	 *
	 * @return array
	 */
	public function defaults() {
		$defaults = array();

		$options = $this->all_options();

		foreach ( $options as $option ) {
			$defaults[ $option->name() ] = $option->default_value();
		}

		return $defaults;
	}

	/***** HTML Output *****/

	public function echo_form_html() { ?>
		<div id="struts-options" class="wrap">
			<div id="icon-themes" class="icon32"><br></div>
			<h2><?php _e( 'Theme Options', 'hoon' ); ?></h2>
			<div id="struts-options" class="wrap">
				<div id="struts-options-body">
					<?php echo $this->settings_updated_html(); ?>
					<form action="options.php" method="post">
						<?php
							settings_fields( $this->name() );
							$this->do_options_html();
						?>
						<div class="struts-buttons-container">
							<input name="<?php echo esc_attr( $this->name() ); ?>[struts_submit]" type="submit" class="button-primary struts-save-button" value="<?php esc_attr_e( 'Save Settings', 'hoon' ); ?>" />
							<input name="<?php echo esc_attr( $this->name() ); ?>[struts_reset]" type="submit" class="button-secondary struts-reset-button" value="<?php esc_attr_e( 'Reset Defaults', 'hoon' ); ?>" onclick="return confirm('<?php esc_attr_e( 'Click OK if you want to reset your theme options to the defaults.', 'hoon' ); ?>')" />
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php }

	public function settings_updated_html() {
		if ( isset( $_GET['settings-updated'] ) )
			return "<div class='updated'><p>" . __( 'Theme settings updated successfully.', 'hoon' ) . "</p></div>";
	}

	public function do_options_html() {

		if ( ! Struts::config( 'use_struts_skin' ) ) {
			do_settings_sections( $this->name() );
			return;
		}

		foreach ( $this->sections() as $section ) {
			$section->to_html();
		}

		foreach ( $this->stranded_options() as $option ) {
			$option->to_html();
		}
	}

}

class SectionNotFoundException extends Exception { }