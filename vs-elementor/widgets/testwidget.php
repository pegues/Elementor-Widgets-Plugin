<?php
namespace VSElementorElements\Widgets;
 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
 
if (!defined('ABSPATH')) exit; // Exit if accessed directly
 
/**
 * @since 1.1.0
 */
class TestWidget extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'contentblock';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __('Test Widget', 'vs-elementor-elements');
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-pencil';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['vertical-square'];
	}

	/**
	* Register the widget controls.
	*
	* Adds different input fields to allow the user to change and customize the widget settings.
	*
	* @since 1.1.0
	*
	* @access protected
	*/
	protected function _register_controls() {
		
		// Content Section
		$this->start_controls_section(
			'section_content',
			[
				'label' => __('Content', 'vs-elementor-elements'),
			]
		);
		
		// Add Style Section
		$this->add_control(
			'style_section',
			[
				'label' => __('Style Section', 'vs-elementor-elements'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		// Title
		$this->add_control(
			'title',
			[
				'label' => __('Title', 'vs-elementor-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Title', 'vs-elementor-elements'),
			]
		);
		
		// Description
		$this->add_control(
			'description',
			[
				'label' => __('Description', 'vs-elementor-elements'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __('Description', 'vs-elementor-elements'),
			]
		);
		
		// Content
		$this->add_control(
			'content',
			[
				'label' => __('Content', 'vs-elementor-elements'),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __('Content', 'vs-elementor-elements'),
			]
		);
		
		// Group Control
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'label'    => __('Typography', 'elementor-vs-elements'),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .vs-text',
				'fields_options' => [
					'letter_spacing' => [
						'range' => [
							'min' => 0,
							'max' => 100
						]
					]
				]
			]
		);
		
		// Image
		$this->add_control(
			'mask_image',
			[
				'label' => __('Mask Image', 'vs-elementor-elements'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);
		
		// Text Align
		$this->add_control(
			'text_align',
			[
				'label' => __('Alignment', 'vs-elementor-elements'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'vs-elementor-elements'),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'vs-elementor-elements'),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __('Right', 'vs-elementor-elements'),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
			]
		);
		
		// Select Control
		$this->add_control(
			'dropdown_Example',
			[
				'label' => __('Dropdown Example', 'vs-elementor-elements'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'default' => __('Default', 'vs-elementor-elements'),
					'yes' => __('Yes', 'vs-elementor-elements'),
					'no' => __('No', 'vs-elementor-elements'),
				],
				'default' => 'default',
			]
		);
		
		// Slider Control
		$this->add_control(
			'font_size',
			[
				'label' => __('Size', 'vs-elementor-elements'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
			]
		);
		
		// Color Control
		$this->add_control(
			'text_color',
			[
				'label' => __('Text Color', 'vs-elementor-elements'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#fefefe',
			]
		);
		
		// Media Control
		$this->add_control(
			'image',
			[
				'label' => __('Choose Image', 'vs-elementor-elements'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				]
			]
		);
		
		// End Controls
		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.1.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes('title', 'none');
		$this->add_inline_editing_attributes('description', 'basic');
		$this->add_inline_editing_attributes('content', 'advanced');
		
		$this->add_inline_editing_attributes('content_typography', 'none');
		$this->add_inline_editing_attributes('mask_image', 'none');
		$this->add_inline_editing_attributes('text_align', 'none');
		$this->add_inline_editing_attributes('dropdown_example', 'none');
		$this->add_inline_editing_attributes('font_size', 'none');
		$this->add_inline_editing_attributes('text_color', 'none');
		$this->add_inline_editing_attributes('image', 'none');
		?>
		<h2 <?php echo $this->get_render_attribute_string('title'); ?>>
			<?php echo $settings['title']; ?>
		</h2>

		<div <?php echo $this->get_render_attribute_string('description'); ?>>
			<?php echo $settings['description']; ?>
		</div>

		<div <?php echo $this->get_render_attribute_string('content'); ?>>
			<div class="vs-text"><?php echo $settings['content']; ?></div>
		</div>

		<div <?php echo $this->get_render_attribute_string('content_typography'); ?>>
			<?php print_r($settings['content_typography']); ?>
			<?php echo $settings['content_typography']; ?>
		</div>

		<?php if($settings['mask_image']): ?>
		<div <?php echo $this->get_render_attribute_string('mask_image'); ?>>
			
			<?php /*
			<pre>
				<?php print_r($settings['mask_image']); ?>
			</pre>
			*/ ?>
			
			<div>
			<?php foreach($settings['mask_image'] as $key => $item){ ?>
				<?php
				if($key == 'url') {
					//echo '<div>Key: ' . $key . '</div>';
					//echo '<div>Value: ' . $item . '</div>';
					
					echo '<div id="vs-elementor-item-' . $key . '" class="vs-elementor-item">';
						echo '<img src="' . $item . '" alt="' . $settings['title'] . '" />';
					echo '</div>';
				}
				?>
			<?php } ?>
			</div>
		</div>
		<?php endif; ?>

		<div <?php echo $this->get_render_attribute_string('text_align'); ?>>
			<?php echo $settings['text_align']; ?>
		</div>

		<div <?php echo $this->get_render_attribute_string('dropdown_example'); ?>>
			<?php echo $settings['dropdown_example']; ?>
		</div>

		<div <?php echo $this->get_render_attribute_string('font_size'); ?>>
			<?php echo $settings['font_size']; ?>
		</div>

		<div <?php echo $this->get_render_attribute_string('text_color'); ?>>
			<?php echo $settings['text_color']; ?>
		</div>

		<div <?php echo $this->get_render_attribute_string('image'); ?>>
			<?php echo $settings['image']; ?>
		</div>
		
		<div class="test-list">
		<?php
			$args = array(
				'post_type' => 'menu',
				'posts_per_page' => 99
			);

			$query = new \WP_Query($args);
			
			if ($query->have_posts()) :
				while ($query->have_posts()) : $query->the_post();

					$this->data[] = array(
						'title' => get_the_title()
					);
					
					echo '<h2>' . get_the_title() . '</h2>';
					
				endwhile;
				
				wp_reset_postdata();
			endif;
			
			var_dump($this->data);
		?>
		</div>
		
		<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.1.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
		view.addInlineEditingAttributes('title', 'none');
		view.addInlineEditingAttributes('description', 'basic');
		view.addInlineEditingAttributes('content', 'advanced');
		
		view.addInlineEditingAttributes('content_typography', 'none');
		view.addInlineEditingAttributes('mask_image', 'none');
		view.addInlineEditingAttributes('text_align', 'none');
		view.addInlineEditingAttributes('dropdown_example', 'none');
		view.addInlineEditingAttributes('font_size', 'none');
		view.addInlineEditingAttributes('text_color', 'none');
		view.addInlineEditingAttributes('image', 'none');
		#>
		<h2 {{{ view.getRenderAttributeString('title') }}}>
			{{{ settings.title }}}
		</h2>

		<div {{{ view.getRenderAttributeString('description') }}}>
			{{{ settings.description }}}
		</div>

		<div {{{ view.getRenderAttributeString('content') }}}>
			<div class="vs-text">{{{ settings.content }}}</div>
		</div>

		<div {{{ view.getRenderAttributeString('content_typography') }}}>
			{{{ settings.content_typography }}}
		</div>

		<div {{{ view.getRenderAttributeString('mask_image') }}}>
			{{{ settings.mask_image }}}
		</div>

		<div {{{ view.getRenderAttributeString('text_align') }}}>
			{{{ settings.text_align }}}
		</div>

		<div {{{ view.getRenderAttributeString('dropdown_example') }}}>
			{{{ settings.dropdown_example }}}
		</div>

		<div {{{ view.getRenderAttributeString('font_size') }}}>
			{{{ settings.font_size }}}
		</div>

		<div {{{ view.getRenderAttributeString('text_color') }}}>
			{{{ settings.text_color }}}
		</div>

		<div {{{ view.getRenderAttributeString('image') }}}>
			{{{ settings.image }}}
		</div>
		<?php
	}
}
