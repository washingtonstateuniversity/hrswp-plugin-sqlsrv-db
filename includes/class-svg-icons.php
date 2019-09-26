<?php
/**
 * WSUWP HRS Courses SVG Icons class
 *
 * @package WSUWP_HRS_Courses
 * @since 0.4.0
 */

namespace WSUWP\HRS\Courses\Icons;

/**
 * This class handles displaying SVG icons for the plugin.
 *
 * Place each <svg> source on its own array key, without the `width` or `height`
 * attributes. These will be added dynamically. All icons are assumed to be
 * square (equal height and width).
 *
 * @since 0.4.0
 */
class SVG_Icons {
	/**
	 * User Interface (UI) icons SVG sources.
	 *
	 * @since 0.4.0
	 *
	 * @var array
	 */
	static $ui_icons = array(
		'attachment' => /* material-design - attachment */ '
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
	<path d="M2 12.5C2 9.46 4.46 7 7.5 7H18c2.21 0 4 1.79 4 4s-1.79 4-4 4H9.5C8.12 15 7 13.88 7 12.5S8.12 10 9.5 10H17v2H9.41c-.55 0-.55 1 0 1H18c1.1 0 2-.9 2-2s-.9-2-2-2H7.5C5.57 9 4 10.57 4 12.5S5.57 16 7.5 16H17v2H7.5C4.46 18 2 15.54 2 12.5z"/>
	<path fill="none" d="M0 0h24v24H0V0z"/>
</svg>',
		'link'       => /* material-design – link */ '
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
    <path d="M0 0h24v24H0z" fill="none"></path>
    <path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"></path>
</svg>',
	);

	/**
	 * Gets the SVG code for a given icon.
	 *
	 * @since 0.4.0
	 *
	 * @param string $group Required. The icon collection group containing the icon SVG markup.
	 * @param string $icon  Required. The icon name.
	 * @param int    $size  The icon size in pixels. Default 24.
	 * @return string|null The SVG string of the selected icon, or null if the icon is not found.
	 */
	public static function get_svg( $group, $icon, $size = 24 ) {
		if ( 'ui' === $group ) {
			$icon_collection = self::$ui_icons;
		} else {
			$icon_collection = array();
		}
		if ( array_key_exists( $icon, $icon_collection ) ) {
			$str = sprintf( '<svg class="svg-icon" width="%1$d" height="%1$d" aria-hidden="true" role="img" focusable="false"', $size );
			$svg = preg_replace( '/^<svg /', $str, trim( $icon_collection[ $icon ] ) ); // Add extra attributes to the SVG code.
			$svg = preg_replace( '/([\n\t]+)/', ' ', $svg ); // Remove newlines and tabs.
			$svg = preg_replace( '/>\s*</', '><', $svg ); // Remove whitespace between SVG tags.
			return $svg;
		}
		return null;
	}
}
