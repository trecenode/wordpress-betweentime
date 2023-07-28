<?php
/**
 * Plugin Name: Wordpress Between Time
 * Plugin URI:  https://13node.com
 * Description: Control What Happens Revolution Slider Need to be shown between some hours. (Configured with spain holidays)
 * Version: 0.1
 * Author: Danilo Ulloa
 * Author URI: https://13node.com
 * Text Domain: trecebetweentime
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function trece_betweentime($atts) {
	$default = array(
		'a_start' => '#',
		'a_end' => '#',
		'b_start' => '#',
		'b_end' => '#',
        'codea' => '#',
		'codeb' => '#',
		'codec' => '#',
    );
	$tatts = shortcode_atts($default, $atts);
	
	
	$currentTime = current_datetime()->format('Y-m-d H:i:s');
	$astartTime = new DateTime($tatts['a_start'], new DateTimeZone('Europe/Madrid'));
	$afstartTime = $astartTime->format('Y-m-d H:i:s');
	$aendTime = (new DateTime($tatts['a_end'], new DateTimeZone('Europe/Madrid')));
	$afendTime = $aendTime->format('Y-m-d H:i:s');
	$bstartTime = new DateTime($tatts['b_start'], new DateTimeZone('Europe/Madrid'));
	$bfstartTime = $bstartTime->format('Y-m-d H:i:s');
	$bendTime = (new DateTime($tatts['b_end'], new DateTimeZone('Europe/Madrid')));
	$bfendTime = $bendTime->format('Y-m-d H:i:s');
	
	$currentDate = new DateTime("now", new DateTimeZone("Europe/Madrid"));
	$day = $currentDate->format('d-m');
	$holidays = array(
		'01-01',
		'06-01',
		'21-02',
		'06-04',
		'07-04',
		'01-05',
		'29-06',
		'15-08',
		'08-09',
		'12-10',
		'01-11',
		'06-12',
		'08-12',
		'25-12',
	);

	if ($currentTime >= $afstartTime && $currentTime <= $afendTime) {
		if($currentDate->format('N') == 6 || $currentDate->format('N') == 7) {
			return add_revslider($tatts['codeb']);
		} else {
			if (in_array($day,$holidays)) {
				return add_revslider($tatts['codeb']);
			} else {
				return add_revslider($tatts['codea']);
			}
		}
	} elseif ($currentTime >= $bfstartTime && $currentTime <= $bfendTime) {
	    return add_revslider($tatts['codeb']);
	} else{
		return add_revslider($tatts['codec']);
	}
	
}
add_shortcode('betweentime', 'trece_betweentime');