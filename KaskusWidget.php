<?php
/*
Plugin Name: Kaskus Widget
Plugin URI: http://www.kaskus.co.id/
Description: Kaskus Widget
Author: Kaskus
Version: 1.1
Author URI: http://www.kaskus.co.id/
 */

if (!defined('ABSPATH')) {
	die('-1');
}

add_action('widgets_init', function () {
	register_widget('KaskusWidget');
});

class KaskusWidget extends WP_Widget
{
	const MIN_HEIGHT = 250;
	const MAX_HEIGHT = 1000;
	const HOTTHREAD_TYPE = 0;
	const PROFILE_TYPE = 1;
	const TYPE_LIST_THREAD = 1;
	const TYPE_LIST_JB = 2;
	const TYPE_IMAGE = 1;
	const TYPE_TEXT = 2;
	const KASKUS_WIDGET_URL = 'https://widget.kaskus.co.id';
	const KASKUS_WIDGET_URL_JS = self::KASKUS_WIDGET_URL.'/js/widget/widget.js';

	public function __construct()
	{
		parent::__construct(
			'KaskusWidget',
			__('Kaskus Widget', 'text_domain'),
			array('description' => __('Kaskus Widget', 'text_domain'))
		);
	}

	public function widget($args, $instance)
	{
		echo $args['before_widget'];
		echo $args['before_title'] . apply_filters('widget_title', "Kaskus Widget") . $args['after_title'];

		echo '<script>__kk_opt={domain:"'.self::KASKUS_WIDGET_URL.'"};(function (d, s, id){var js, fjs = d.getElementsByTagName(s)[0];if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="'.self::KASKUS_WIDGET_URL_JS.'";fjs.parentNode.insertBefore(js,fjs)}(document, \'script\', \'kaskus-widget-js\'));</script>';

		if($instance['widget_type'] == self::PROFILE_TYPE)
		{
			echo '<div class="kaskus-widget" height="'.$instance['height'].'px" data-widget="profile" data-type="'.$instance['type'].'"data-userid="'.$instance['userid'].'" data-list="'.$instance['list'].'"></div>';
		}
		else
		{
			echo '<div class="kaskus-widget" height="'.$instance['height'].'px" data-widget="hotthread" data-type="'.$instance['type'].'"></div>';
		}
		echo $args['after_widget'];
	}

	public function form($instance)
	{

		if (isset($instance['height'])) {
			$height = $instance['height'];
		} else {
			$height = __('320', 'text_domain');
		}

		if (isset($instance['type'])) {
			$type = $instance['type'];
		} else {
			$type = __(self::TYPE_IMAGE, 'text_domain');
		}

		if (isset($instance['widget_type'])) {
			$widget_type = $instance['widget_type'];
		} else {
			$widget_type = __(self::PROFILE_TYPE, 'text_domain');
		}

		if (isset($instance['userid'])) {
			$userid = $instance['userid'];
		} else {
			$userid = __('', 'text_domain');
		}

		if (isset($instance['list'])) {
			$list = $instance['list'];
		} else {
			$list = __(self::TYPE_LIST_THREAD, 'text_domain');
		}

		?>

		<style>
			.widget-content label {
				margin: 15px 0 5px;
				display: block;

			}
		</style>

		<p>
			<label for="<?php echo $this->get_field_id('widget_type'); ?>">Widget Type</label>
			<label><input class="widefat radiowidget" name="<?php echo $this->get_field_name('widget_type'); ?>" type="radio" value="<?php echo self::HOTTHREAD_TYPE; ?>" <?php echo ($widget_type == self::HOTTHREAD_TYPE) ? 'checked' : '';?>>Hot Thread</label>
			<label><input class="widefat radiowidget" name="<?php echo $this->get_field_name('widget_type'); ?>" type="radio" value="<?php echo self::PROFILE_TYPE; ?>" <?php echo ($widget_type == self::PROFILE_TYPE) ? 'checked' : '';?>>Profile</label>
			<div class="profilewidget"	<?php echo ($widget_type == self::PROFILE_TYPE) ? '':'style="display:none"'; ?>>
				<label for="<?php echo $this->get_field_id('userid'); ?>">User Id</label>
				<input class="widefat userid" name="<?php echo $this->get_field_name('userid'); ?>" type="text" value="<?php echo esc_attr($userid); ?>" <?php echo ($widget_type == self::HOTTHREAD_TYPE) ? 'disabled':'';?>>
				<label for="<?php echo $this->get_field_id('list'); ?>">List Type</label>
				<select class="widefat list_widget" name="<?php echo $this->get_field_name('list'); ?>" <?php echo ($widget_type == self::HOTTHREAD_TYPE) ? 'disabled':'';?>>
					<option value='<?php echo self::TYPE_LIST_THREAD?>' <?php if ($list == self::TYPE_LIST_THREAD) echo 'selected';?>>Thread</option>
					<option value='<?php echo self::TYPE_LIST_JB?>' <?php if ($list == self::TYPE_LIST_JB) echo 'selected';?>>Jual Beli</option>
				</select>
			</div>
			<label for="<?php echo $this->get_field_id('height'); ?>">Height</label>
			<input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>">

			<label for="<?php echo $this->get_field_id('type'); ?>">Display Type</label>
			<select class="widefat" id='<?php echo $this->get_field_id('type'); ?>'name="<?php echo $this->get_field_name('type'); ?>">
				<option value='<?php echo self::TYPE_IMAGE?>' <?php if ($type == self::TYPE_IMAGE) echo 'selected';?>>Image</option>
				<option value='<?php echo self::TYPE_TEXT?>' <?php if ($type == self::TYPE_TEXT) echo 'selected';?>>Text</option>
			</select>
		</p>
		<?php
		wp_enqueue_script('jquery');
		wp_register_script('kaskuswidget_init', plugins_url('js/kaskuswidget.js', __FILE__), array('jquery'));
		wp_enqueue_script('kaskuswidget_init');
	}

	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['height'] = (!empty($new_instance['height'])) ? strip_tags($new_instance['height']) : '';
		$instance['type'] = (!empty($new_instance['type'])) ? strip_tags($new_instance['type']) : '';
		$instance['widget_type'] = (!empty($new_instance['widget_type'])) ? strip_tags($new_instance['widget_type']) : '';
		if($new_instance['widget_type'] == self::PROFILE_TYPE)
		{
			$instance['userid'] = (!empty($new_instance['userid'])) ? strip_tags($new_instance['userid']) : '';
			$instance['list'] = (!empty($new_instance['list'])) ? strip_tags($new_instance['list']) : '';
		}

		$instance['height'] = min(max($instance['height'], self::MIN_HEIGHT), self::MAX_HEIGHT);

		return $instance;
	}
}