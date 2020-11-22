<?php
namespace Elementor;

function vs_elementor_category_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'vertical-square',
        [
            'title'  => 'Vertical Square',
            'icon' => 'font'
        ],
        0
    );
}
add_action('elementor/init', 'Elementor\vs_elementor_category_elementor_init');
