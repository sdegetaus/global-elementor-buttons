<?php

use Elementor\Widget_Base;
use Elementor\Widget_Button;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TMX_Global_Button extends Widget_Button {

	#region CUSTOM HOOKS

	// BUTTON STYLE - CLASSES
	public static function tmx_get_button_style() {
		$styles = [
			'primary' => 'Primary',
			'secondary' => 'Secondary',
			'success' => 'Success',
			'danger' => 'Danger',
			'warning' => 'Warning',
			'info' => 'Info',
			'light' => 'Light',
			'dark' => 'Dark',
			'link' => 'Link',
		];
		$styles = apply_filters( 'tmx_set_button_styles', $styles );
		return $styles;
	}

	// BUTTON STYLE - PREFIX
	public static function tmx_get_button_style_prefix() {
		$prefix = 'btn btn-';
		$prefix = apply_filters( 'tmx_set_button_style_prefix', $prefix );
		return $prefix;
	}

	// BUTTON STYLE - DEFAULT
	public static function tmx_get_button_style_default() {
		$default = 'primary';
		$default = apply_filters( 'tmx_set_button_style_default', $default );
		return $default;
	}

	// BUTTON SIZE - CLASSES
	public static function tmx_get_button_size() {
		$sizes = [
			'xs' => 'Extra Small',
			'sm' => 'Small',
			'md' => 'Medium',
			'lg' => 'Large',
			'xl' => 'Extra Large',
		];
		$sizes = apply_filters( 'tmx_set_button_sizes', $sizes );
		return $sizes;
	}

	// BUTTON SIZE - PREFIX
	public static function tmx_get_button_size_prefix() {
		$prefix = 'elementor-size-';
		$prefix = apply_filters( 'tmx_set_button_size_prefix', $prefix );
		return $prefix;
	}

	// BUTTON SIZE - DEFAULT
	public static function tmx_get_button_size_default() {
		$default = 'sm';
		$default = apply_filters( 'tmx_set_button_size_default', $default );
		return $default;
	}

	#endregion


	public function get_name() {
		return 'tmx-global-button';
	}

	public function get_title() {
		return 'Global Button';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_button',
			[
				'label' => __( 'Button', 'elementor' ),
			]
		);

		// add our button style control
		$this->add_control(
			'button_style',
			[
				'label' => __( 'Button Style', 'tmx-global-elementor-buttons' ),
				'type' => Controls_Manager::SELECT,
				'default' => self::tmx_get_button_style_default(),
				'options' => self::tmx_get_button_style(),
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Text', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click me', 'elementor' ),
				'placeholder' => __( 'Click me', 'elementor' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'elementor' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		// add our button size control
		$this->add_control(
			'size',
			[
				'label' => __( 'Size', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => self::tmx_get_button_size_default(),
				'options' => self::tmx_get_button_size(),
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
				'default' => '',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => __( 'Icon Position', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Before', 'elementor' ),
					'right' => __( 'After', 'elementor' ),
				],
				'condition' => [
					'icon!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => __( 'Icon Spacing', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_css_id',
			[
				'label' => __( 'Button ID', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'title' => __( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'elementor' ),
				'label_block' => false,
				'description' => __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'elementor' ),
				'separator' => 'before',

			]
		);

		// used to get the button _STYLE_ prefix for js rendering (elementor backend)
		$this->add_control(
			'button_style_prefix',
			[
				'label' => 'Button Style Prefix',
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => self::tmx_get_button_style_prefix(),
			]
		);

		// used to get the button _SIZE_ prefix for js rendering (elementor backend)
		$this->add_control(
			'button_size_prefix',
			[
				'label' => 'Button Size Prefix',
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => self::tmx_get_button_size_prefix(),
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();

		// we add our button styles with their prefix
		$this->add_render_attribute( 'button', 'class', self::tmx_get_button_style_prefix() . $settings['button_style'] );

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'button', 'href', $settings['link']['url'] );
			$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}

			if ( $settings['link']['nofollow'] ) {
				$this->add_render_attribute( 'button', 'rel', 'nofollow' );
			}
		}
		
		$this->add_render_attribute( 'button', 'class', 'elementor-button' );
		$this->add_render_attribute( 'button', 'role', 'button' );

		if ( ! empty( $settings['button_css_id'] ) ) {
			$this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
		}

		if ( ! empty( $settings['size'] ) ) {
			// altered to include a custom size prefix class
			$this->add_render_attribute( 'button', 'class', self::tmx_get_button_size_prefix() . $settings['size'] );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
				<?php $this->render_text(); ?>
			</a>
		</div>
		<?php
	}

	protected function _content_template() {
		?>

		<#

		view.addRenderAttribute( 'text', 'class', 'elementor-button-text' );
		view.addInlineEditingAttributes( 'text', 'none' );
		
		#>

		<div class="elementor-button-wrapper">
			<a id="{{ settings.button_css_id }}" class="{{ settings.button_style_prefix }}{{ settings.button_style }} elementor-button {{ settings.button_size_prefix }}{{ settings.size }} elementor-animation-{{ settings.hover_animation }}" href="{{ settings.link.url }}" role="button">
				<span class="elementor-button-content-wrapper">
					<# if ( settings.icon ) { #>
					<span class="elementor-button-icon elementor-align-icon-{{ settings.icon_align }}">
						<i class="{{ settings.icon }}" aria-hidden="true"></i>
					</span>
					<# } #>
					<span {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.text }}}</span>
				</span>
			</a>
		</div>
		<?php
	}
}