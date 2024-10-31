<?php
/*
Plugin Name: Random Post Loader
Description: Load Random Posts
Author:      ChiHa
Version:     1.1
Author URI:  http://www.chiha.ir
*/
class crand extends WP_Widget {
	function crand() {
		parent::WP_Widget(false,$name = __('Random Post','wp_widget_plugin'));
	}
	function form($instance) {
		if($instance) {
			$title = esc_attr($instance['title']);
			$count = (int)$instance['count'];
		} else {
			$title = '';
			$count = '1';
		}
		echo '
			<p>
				<label for="'.$this->get_field_id('title').'">Title : </label>
				<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" />
			</p>
			<p>
				<label for="'.$this->get_field_id('count').'">Count : </label>
				<input class="widefat" id="'.$this->get_field_id('count').'" name="'.$this->get_field_name('count').'" type="text" value="'.$count.'" />
			</p>
		';
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if(isset($new_instance['count']) && is_numeric($new_instance['count'])){
			$instance['count'] = strip_tags($new_instance['count']);
		} else {
			$instance['count'] = '1';
		}
		return $instance;
	}
	function widget($args,$instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$count = $instance['count'];
		echo $before_widget;
		if($title){
			echo $before_title . $title . $after_title ;
		}
		query_posts("showposts=$count&offset=0&orderby=rand");
		if (have_posts()) {
			while ( have_posts() ) {
				the_post();
				echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></title>';
			}
		} else {
			echo 'Nothing to show!';
		}
		echo $after_widget;
	}
}
add_action('widgets_init', create_function('', 'return register_widget("crand");'));
?>