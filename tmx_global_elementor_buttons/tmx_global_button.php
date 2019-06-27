<?php

use Elementor\Widget_Base;
use Elementor\Widget_Button;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TMX_Global_Button extends Widget_Button {

	#region CUSTOM HOOKS

	// BUTTON STYLE - CLASSES
	public static function tmx_get_button_style() {
		$classes = [
			'primary' => __('Primary', 'tmx-global-elementor-buttons'),
			'secondary' => __('Secondary', 'tmx-global-elementor-buttons'),
			'success' => __('Success', 'tmx-global-elementor-buttons'),
			'danger' => __('Danger', 'tmx-global-elementor-buttons'),
			'warning' => __('Warning', 'tmx-global-elementor-buttons'),
			'info' => __('Info', 'tmx-global-elementor-buttons'),
			'light' => __('Light', 'tmx-global-elementor-buttons'),
			'dark' => __('Dark', 'tmx-global-elementor-buttons'),
			'link' => __('Link', 'tmx-global-elementor-buttons'),
		];
		$classes = apply_filters( 'tmx_set_button_styles', $classes );
		return $classes;
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
			'xs' => __( 'Extra Small', 'elementor' ),
			'sm' => __( 'Small', 'elementor' ),
			'md' => __( 'Medium', 'elementor' ),
			'lg' => __( 'Large', 'elementor' ),
			'xl' => __( 'Extra Large', 'elementor' ),
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
			<a class="{{ settings.button_style_prefix }}{{ settings.button_style }} elementor-button {{ settings.button_size_prefix }}{{ settings.size }} elementor-animation-{{ settings.hover_animation }}" href="{{ settings.link.url }}">
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