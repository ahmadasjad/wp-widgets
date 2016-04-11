<?php

// Creating the widget 
class tooltip_menu extends WP_Widget {

    function __construct() {
        parent::__construct(
                // Base ID of your widget
                'tooltip_menu',
                // Widget name will appear in UI
                __('ToolTip Menu', 'tooltip_menu'),
                // Widget description
                array('description' => __('Drag this widget to tooltip menu widget area which is below the slider', 'tooltip_menu'),)
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance) {
//        $title = apply_filters('widget_title', $instance['title']);
        $titles = $instance['title'];
        if (!empty($titles)) {
            ?><ul class="bottomtopnav"><?php
            foreach ($titles as $key => $title) {
                ?>
                    <li>
                        <a href="javascript:void(0);"  data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="<?php echo $instance['description'][$key]; ?>"><?php echo $title; ?></a> 
                    </li>
                    <?php
                }
                ?>
            </ul> <?php
        }
    }

    // Widget Backend 
    public function form($instance) {

//        echo '<pre>';
//        var_dump($instance);
//        echo '</pre>';
        if (!isset($instance['title']) || !is_array($instance['title'])) {
            $instance['title'][0] = __('New title', 'tooltip_menu');
        }
        if (!isset($instance['description']) || !is_array($instance['description'])) {
            $instance['description'][0] = __('New Description', 'tooltip_menu');
        }
        ?>
        <div id="accordion_custom">
            <?php
            foreach ($instance['title'] as $key => $tooltip_title) {
                ?>
                <div class="tooltip_option">
                    <span class="remove_tooltip">X</span>
                    <h3 style="">
                        <?php echo esc_attr($tooltip_title); ?>
                    </h3>
                    <div class="form-group">
                        <label for="<?php echo $this->get_field_id($instance['title'] . $key); ?>"><?php _e('Title:'); ?></label> 
                        <input class="widefat" id="<?php echo $this->get_field_id($instance['title'] . $key); ?>" name="<?php echo $this->get_field_name('title[]'); ?>" type="text" value="<?php echo esc_attr($tooltip_title); ?>" />
                        <label for="<?php echo $this->get_field_id($instance['description'] . $key); ?>"><?php _e('Description:'); ?></label> 
                        <textarea class="widefat" id="<?php echo $this->get_field_id($instance['description'] . $key); ?>" name="<?php echo $this->get_field_name('description[]'); ?>" type="text" value=""><?php echo esc_attr($instance['description'][$key]); ?></textarea>
                    </div>
                </div>
                <?php
            }
            wp_register_script('accordion-js', get_template_directory_uri() . '/js/custom.js'); // Register our snippet of customiisation 
            wp_enqueue_script('accordion-js'); // Queue our snippet of customisation
            ?>
        </div>
        <div class="block">
            <span class="button add_tooltip">Add Option</span>
        </div>
        <style>
            #accordion_custom + .block {
                margin: 15px 0; 
            }
            #accordion_custom div h3{
                margin: 5px 0 0 0;    padding: 10px;    border: 1px solid #ccc;
            }
            #accordion_custom .tooltip_option{
                position: relative;

            }
            #accordion_custom .tooltip_option .remove_tooltip{
                position: absolute;
                top: 0;
                right:0;
                border: 3px solid #f00;
                padding: 8px;
            }
            #accordion_custom .form-group{
                border: 1px solid #ccc;
                border-top: 0;
                padding: 15px;
            }
        </style>

        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        foreach ($new_instance['title'] as $tooltip_title) {
            $instance['title'][] = (!empty($tooltip_title) ) ? strip_tags($tooltip_title) : '';
        }
        foreach ($new_instance['description'] as $tooltip_title) {
            $instance['description'][] = (!empty($tooltip_title) ) ? strip_tags($tooltip_title) : '';
        }
        return $instance;
    }

}

// Class tooltip_menu ends here
// Register and load the widget
function tooltip_menu() {
    register_widget('tooltip_menu');
}

add_action('widgets_init', 'tooltip_menu');
?>