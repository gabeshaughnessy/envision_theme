<?php

abstract class Struts_Option {
	protected $_name, $_valid_values, $_value, $_type, $_default_value,
			  $_tab, $_label, $_description, $_parent_name, $_validation_function;

	public function name( $name = NULL ) {
		if ( NULL === $name )
			return $this->_name;

		$this->_name = $name;
		return $this;
	}

	public function valid_values( $valid_values = NULL ) {
		if ( NULL === $valid_values )
			return $this->_valid_values;

		$this->_valid_values = $valid_values;
		return $this;
	}

	public function value( $value = NULL ) {
		if ( NULL === $value ) {
			return $this->_value;
		}

		$this->_value = $value;
		return $this;
	}

	public function type( $type = NULL ) {
		if ( NULL === $type )
			return $this->_type;

		$this->_type = $type;
		return $this;
	}

	public function default_value( $default_value = NULL ) {
		if ( NULL === $default_value )
			return $this->_default_value;

		$this->_default_value = $default_value;
		return $this;
	}

	public function tab( $tab = NULL ) {
		if ( NULL === $tab )
			return $this->_tab;

		$this->_tab = $tab;
		return $this;
	}

	public function label( $label = NULL ) {
		if ( NULL === $label )
			return $this->_label;

		$this->_label = $label;
		return $this;
	}

	public function description( $description = NULL ) {
		if ( NULL === $description )
			return $this->_description;

		$this->_description = $description;
		return $this;
	}

	public function parent_name( $parent_name = NULL ) {
		if ( NULL === $parent_name )
			return $this->_parent_name;

		$this->_parent_name = $parent_name;
		return $this;
	}

	public function section( $section = NULL ) {
		if ( NULL === $section )
			return $this->_section;

		$this->_section = $section;
		return $this;
	}

	public function validation_function( $validation_function = NULL ) {
		if ( NULL === $validation_function )
			return $this->_validation_function;

		$this->_validation_function = $validation_function;
		return $this;
	}

	// The HTML ID takes the form 'parentname-optionname'
	protected function html_id() {
		return $this->parent_name() . '-' . $this->name();
	}

	// Name takes the form 'parentname[optionname]'
	protected function html_name() {
		return $this->parent_name() . '[' . $this->name() . ']';
	}

	protected function html_input_class() {
		return strtolower( array_pop( explode( '_', get_class( $this ) ) ) );
	}

	public function register() {
		add_settings_field(
			$this->name(),
			$this->label(),
			array( &$this, 'to_html' ),
			$this->parent_name(),
			$this->section() );
	}

	public function validate( $value ) {
		if ( $validation_function = $this->validation_function() ) {
			return $validation_function( $value );
		} else {
			return $this->standard_validation( $value );
		}
	}

	public function to_html() {
		if ( Struts::config( 'use_struts_skin' ) ) {
			echo '<div class="' . esc_attr( 'clear struts-option ' . $this->html_input_class() ) . '">';
		}

		$this->base_html();

		if ( Struts::config( 'use_struts_skin' ) ) {
			echo "</div>";
		}
	}

	protected function base_html() {
		$this->description_html();
		if ( Struts::config( 'use_struts_skin' ) ) { $this->label_html(); }
		$this->input_html();
	}

	protected function description_html() {
		if ( $this->description() ) {
			echo "<div class='struts-option-description'>{$this->description()}</div>";
		}
	}

	protected function label_html() {
		if ( $this->label() ) {
			echo '<label class="struts-label" for="' . esc_attr( $this->html_id() ) . '">' . esc_html( $this->label() ) . '</label>';
		}
	}

	abstract protected function input_html();
	abstract protected function standard_validation( $value );
}