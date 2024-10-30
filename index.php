<?php
/*
Plugin Name: Kin Direcciones
Plugin URI: http://www.kinwebdesign.com
Description: Show your customers how to get to your business with this contact info widget that includes an interactive Google map. Access Direcciones from the <strong>Appearance → Widgets</strong> screen. For more information visit, <a href="http://www.kinwebdesign.com">Kin Web Design</a>.
Author: Kin Web Design
Author URI: http://www.kinwebdesign.com
Version: 1.1
*/

/*
  _  _______ _   _  __          ________ ____    _____  ______  _____ _____ _____ _   _ 
 | |/ /_   _| \ | | \ \        / /  ____|  _ \  |  __ \|  ____|/ ____|_   _/ ____| \ | |
 | ' /  | | |  \| |  \ \  /\  / /| |__  | |_) | | |  | | |__  | (___   | || |  __|  \| |
 |  <   | | | . ` |   \ \/  \/ / |  __| |  _ <  | |  | |  __|  \___ \  | || | |_ | . ` |
 | . \ _| |_| |\  |    \  /\  /  | |____| |_) | | |__| | |____ ____) |_| || |__| | |\  |
 |_|\_\_____|_| \_|     \/  \/   |______|____/  |_____/|______|_____/|_____\_____|_| \_|
*/

class kin_direcciones extends WP_Widget {
	function kin_direcciones() {
		parent::__construct(false,'Kin Direcciones' );
	}
	function widget($args,$instance ) {
		extract($args);
		$title=apply_filters('widget_title',$instance['title']);
		$name=$instance['name'];
		$address=$instance['address'];
		$city=$instance['city'];
		$state=$instance['state'];
		$phone_number=$instance['phone_number'];
		$email_address=$instance['email_address'];
		$height=$instance['height'];
		$zoom=$instance['zoom'];
		$color=$instance['color'];
		echo $before_widget;
		echo '<div class="widget-text wp_widget_plugin_box">';
			if ($title) {
				echo $before_title . $title . $after_title;
			}
			echo '<div class="wp_widget_plugin_text">';
			if ($name) {
				echo '<a href="' . get_bloginfo('url') . '">' . $name . '</a><br />';
			}
			if ($address) {
				echo $address . '<br />';
			}
			if ($city and $state) {
				echo $city . ', ' . $state . '<br />';
			}
			if ($phone_number) {
				echo $phone_number . '<br />';
			}
			if ($email_address) {
				echo '<a href="mailto:' . $email_address . '">' . $email_address . '</a><br /><br />';
			}
			if ($height=='') {$height='300';}
			if ($zoom=='') {$zoom='15';}
			if ($color=='') {$color='black';}
			echo '
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDq1l4p0CQgpkWfd5qTiRELZZP5hTc9EFk"></script>
			<div id="map-canvas" style="height:' . $height . 'px; width:100%; margin:0; padding:0;"></div>
			<script type="text/javascript">
			    var geocoder=new google.maps.Geocoder();
			    var latlng=new google.maps.LatLng(-34.397,150.644);
			    var mapOptions={
			    	zoom:' . $zoom . ',
			    	center:latlng
			    }
			    var map=new google.maps.Map(document.getElementById("map-canvas"),mapOptions);
				var styles=[
					{
						stylers: [
							{hue:"#' . $color . '"},
							{saturation:100},
							{lightness:0}
						]
					}
				];
				map.setOptions({styles:styles});
				var address="' . $address . ', ' . $city . ', ' . $state . '";
			    geocoder.geocode({"address":address},function(results,status) {
			    	if (status==google.maps.GeocoderStatus.OK) {
			    		map.setCenter(results[0].geometry.location);
			    		var marker=new google.maps.Marker({
			    			map:map,
			    			position:results[0].geometry.location
			    		});
			    	}
			    });
			</script>
			<br />
			';
			echo '</div>';
		echo '</div>';
		echo $after_widget;
	}
	function update($new_instance,$old_instance) {
		$instance=$old_instance;
		$instance['title']=strip_tags($new_instance['title']);
		$instance['name']=strip_tags($new_instance['name']);
		$instance['address']=strip_tags($new_instance['address']);
		$instance['city']=strip_tags($new_instance['city']);
		$instance['state']=strip_tags($new_instance['state']);
		$instance['phone_number']=strip_tags($new_instance['phone_number']);
		$instance['email_address']=strip_tags($new_instance['email_address']);
		$instance['height']=strip_tags($new_instance['height']);
		$instance['zoom']=strip_tags($new_instance['zoom']);
		$instance['color']=strip_tags($new_instance['color']);		
		return $instance;
	}
	function form($instance) {
		if ($instance) {
			$title=esc_attr($instance['title']);
			$name=esc_attr($instance['name']);
			$address=esc_attr($instance['address']);
			$city=esc_attr($instance['city']);
			$state=esc_attr($instance['state']);
			$phone_number=esc_attr($instance['phone_number']);
			$email_address=esc_attr($instance['email_address']);
			$height=esc_attr($instance['height']);
			$zoom=esc_attr($instance['zoom']);
			$color=esc_attr($instance['color']);
		}
		else {
			$title='';
			$address='';
		}
		echo '
		<p>
			Title:
			<input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" />
		</p>
		<p>
			Name:
			<input class="widefat" id="' . $this->get_field_id('name') . '" name="' . $this->get_field_name('name') . '" type="text" value="' . $name . '" />
		</p>
		<p>
			Street Address:
			<input class="widefat" id="' . $this->get_field_id('address') . '" name="' . $this->get_field_name('address') . '" type="text" value="' . $address . '" />
		</p>
		<p>
			City:
			<input class="widefat" id="' . $this->get_field_id('city') . '" name="' . $this->get_field_name('city') . '" type="text" value="' . $city . '" />
		</p>
		<p>
			State:
			<input class="widefat" id="' . $this->get_field_id('state') . '" name="' . $this->get_field_name('state') . '" type="text" value="' . $state . '" />
		</p>
		<p>
			Phone Number:
			<input class="widefat" id="' . $this->get_field_id('phone_number') . '" name="' . $this->get_field_name('phone_number') . '" type="text" value="' . $phone_number . '" />
		</p>
		<p>
			Email Address:
			<input class="widefat" id="' . $this->get_field_id('email_address') . '" name="' . $this->get_field_name('email_address') . '" type="text" value="' . $email_address . '" />
		</p>
		<p>
			Map Height:
			<input class="widefat" id="' . $this->get_field_id('height') . '" name="' . $this->get_field_name('height') . '" type="text" value="' . $height . '" />
			<i>ie: 300</i>			
		</p>
		<p>
			Map Zoom:
			<input class="widefat" id="' . $this->get_field_id('zoom') . '" name="' . $this->get_field_name('zoom') . '" type="text" value="' . $zoom . '" />
			<i>ie: 15</i>
		</p>
		<p>
			Map Color:
			<input class="widefat" id="' . $this->get_field_id('color') . '" name="' . $this->get_field_name('color') . '" type="text" value="' . $color . '" />
			<i>ie: 61CDF5</i>
		</p>
		<p>Visit <a href="http://www.kinwebdesign.com" target="_blank">Kin Web Design</a> for help.</p>
		';
	}
}
function register_kin_direcciones() {
	register_widget('kin_direcciones');
}
add_action('widgets_init','register_kin_direcciones');

function register_kin_direcciones_menus() {
	add_menu_page(
		'Kin Direcciones Support and Resources',
		'Direcciones',
		'manage_options',
		'kin-direcciones/support.php',
		''
	);
}
add_action('admin_menu','register_kin_direcciones_menus');
?>