<?php

class SocialWidget extends WP_Widget
{

    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'my_widget',
            'description' => 'My Widget is awesome',
        );
        parent::__construct('social_widget', 'Social Widget', $widget_ops);
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        // outputs the content of the widget
        echo $args['before_widget'];
        echo '<div class="title">'.pll_e("Социальные сети").'</div>';
        ?>
        <?php if (!empty($instance['youtube'])): ?>
        <a href="<?= $instance['youtube']; ?>" class="social-btn instagram" target="_blank">
            <i class="fab fa-youtube-f"></i>
        </a>
    <?php endif; ?>
        <?php if (!empty($instance['facebook'])): ?>
        <a href="<?= $instance['facebook']; ?>" class="social-btn facebook" target="_blank">
            <i class="fab fa-facebook-f"></i>
        </a>
    <?php endif; ?>
        <?php if (!empty($instance['instagram'])): ?>
        <a href="<?= $instance['instagram']; ?>" class="social-btn instagram" target="_blank">
            <i class="fab fa-instagram"></i>
        </a>
    <?php endif; ?>
        <?php if (!empty($instance['vk'])): ?>
        <a href="<?= $instance['vk']; ?>" class="social-btn facebook" target="_blank">
            <i class="fab fa-vk"></i>
        </a>
    <?php endif; ?>
        <?php if (!empty($instance['telegram'])): ?>
        <a href="<?= $instance['telegram']; ?>" class="social-btn facebook" target="_blank">
            <i class="fab fa-telegram"></i>
        </a>
    <?php endif; ?>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form($instance)
    {
        // outputs the options form on admin
        $youtube = !empty($instance['youtube']) ? $instance['youtube'] : '';
        $facebook = !empty($instance['facebook']) ? $instance['facebook'] : '';
        $instagram = !empty($instance['instagram']) ? $instance['instagram'] : '';
        $vk = !empty($instance['vk']) ? $instance['vk'] : '';
        $telegram = !empty($instance['telegram']) ? $instance['telegram'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('Youtube:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>"
                   name="<?php echo $this->get_field_name('youtube'); ?>" type="text"
                   value="<?php echo esc_attr($youtube); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>"
                   name="<?php echo $this->get_field_name('facebook'); ?>" type="text"
                   value="<?php echo esc_attr($facebook); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('vk'); ?>"><?php _e('VK:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('vk'); ?>"
                   name="<?php echo $this->get_field_name('vk'); ?>" type="text"
                   value="<?php echo esc_attr($vk); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>"
                   name="<?php echo $this->get_field_name('instagram'); ?>" type="text"
                   value="<?php echo esc_attr($instagram); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('telegram'); ?>"><?php _e('Telegram:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('telegram'); ?>"
                   name="<?php echo $this->get_field_name('telegram'); ?>" type="text"
                   value="<?php echo esc_attr($telegram); ?>">
        </p>
        <?php
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     *
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        // processes widget options to be saved
//        $instance = array();
        $instance = array();
        $instance['youtube'] = (!empty($new_instance['youtube'])) ? strip_tags($new_instance['youtube']) : '';
        $instance['facebook'] = (!empty($new_instance['facebook'])) ? strip_tags($new_instance['facebook']) : '';
        $instance['instagram'] = (!empty($new_instance['instagram'])) ? strip_tags($new_instance['instagram']) : '';
        $instance['vk'] = (!empty($new_instance['vk'])) ? strip_tags($new_instance['vk']) : '';
        $instance['telegram'] = (!empty($new_instance['telegram'])) ? strip_tags($new_instance['telegram']) : '';
        return $instance;
    }

}
