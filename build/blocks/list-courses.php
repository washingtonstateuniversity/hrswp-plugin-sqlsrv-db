<?php
/**
 * Server-side rendering of the `hrscourses/list-courses` block.
 *
 * @package WSUWP_HRS_Courses
 * @since 0.4.0
 */
namespace WSUWP\HRS\Courses\Blocks\list_courses;
use WSUWP\HRS\Courses\Setup;

/**
 * Renders the `hrscourses/list-courses` dynamic block contents.
 *
 * @since 0.4.0
 *
 * @param array $attributes The block attributes passed from `register_block_type`.
 *
 * @return string The formatted HTML for display.
 */
function render_block_list_courses( $attributes ) {
	$args = array(
		'posts_per_page'   => $attributes['coursesToShow'],
		'post_type'        => Setup\WSUWP_HRS_Courses::$post_type_slug,
		'post_status'      => 'publish',
		'order'            => $attributes['order'],
		'orderby'          => $attributes['orderBy'],
		'suppress_filters' => false,
	);

	if ( isset( $attributes['learningPrograms'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'learning_program',
				'field'    => 'id',
				'terms'    => $attributes['learningPrograms'],
			),
		);
	}

	$recent_courses = get_posts( $args );

	if ( ! $recent_courses ) {
		$block_content = sprintf(
			'<div class="components-placeholder"><div class="components-placeholder__label">%1$s %2$s</div><div class="components-placeholder__fieldset">%3$s</div></div>',
			'<svg aria-hidden="true" role="img" focusable="false" class="dashicon dashicons-admin-post" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M10.44 3.02l1.82-1.82 6.36 6.35-1.83 1.82c-1.05-.68-2.48-.57-3.41.36l-.75.75c-.92.93-1.04 2.35-.35 3.41l-1.83 1.82-2.41-2.41-2.8 2.79c-.42.42-3.38 2.71-3.8 2.29s1.86-3.39 2.28-3.81l2.79-2.79L4.1 9.36l1.83-1.82c1.05.69 2.48.57 3.4-.36l.75-.75c.93-.92 1.05-2.35.36-3.41z"></path></svg>',
			__( 'List Courses' ),
			__( 'No courses found.' )
		);
		return $block_content;
	}

	$list_items_markup = '';
	$excerpt_length    = $attributes['excerptLength'];

	foreach ( $recent_courses as $course ) {
		$title = get_the_title( $course );
		if ( ! $title ) {
			$title = __( '(No title)', 'wsuwp-hrs-courses' );
		}
		$list_items_markup .= sprintf(
			'<li><p class="course-title"><a href="%1$s">%2$s</a></p>',
			esc_url( get_permalink( $course ) ),
			$title
		);

		if ( isset( $attributes['displayPostDate'] ) && $attributes['displayPostDate'] ) {
			$list_items_markup .= sprintf(
				'<time datetime="%1$s" class="wp-block-hrscourses-list-courses__post-date">%2$s</time>',
				esc_attr( get_the_date( 'c', $course ) ),
				esc_html( get_the_date( '', $course ) )
			);
		}

		if ( isset( $attributes['displayCourseContent'] ) && $attributes['displayCourseContent']
			&& isset( $attributes['displayCourseContentRadio'] ) && 'excerpt' === $attributes['displayCourseContentRadio'] ) {
			$course_excerpt = $course->post_excerpt;
			if ( ! ( $course_excerpt ) ) {
				$course_excerpt = $course->post_content;
			}
			$trimmed_excerpt = esc_html( wp_trim_words( $course_excerpt, $excerpt_length, ' &hellip; ' ) );

			$list_items_markup .= sprintf(
				'<div class="wp-block-hrscourses-list-courses__post-excerpt">%1$s</div>',
				$trimmed_excerpt
			);
		}

		if ( isset( $attributes['displayCourseContent'] ) && $attributes['displayCourseContent']
			&& isset( $attributes['displayCourseContentRadio'] ) && 'full_post' === $attributes['displayCourseContentRadio']
		) {
			$full_content = apply_filters( Setup\WSUWP_HRS_Courses::$post_type_slug . '_documents_list', $course->post_content );
			$full_content = apply_filters( Setup\WSUWP_HRS_Courses::$post_type_slug . '_enroll_link', $full_content );

			$list_items_markup .= sprintf(
				'<div class="wp-block-hrscourses-list-courses__full_content">%1$s</div>',
				$full_content
			);
		}

		$list_items_markup .= "</li>\n";
	}

	$class = 'wp-block-hrscourses-list-courses wp-block-latest-posts__list';
	if ( isset( $attributes['align'] ) ) {
		$class .= ' align' . $attributes['align'];
	}

	if ( isset( $attributes['postLayout'] ) && 'grid' === $attributes['postLayout'] ) {
		$class .= ' is-grid';
	}

	if ( isset( $attributes['columns'] ) && 'grid' === $attributes['postLayout'] ) {
		$class .= ' columns-' . $attributes['columns'];
	}

	if ( isset( $attributes['displayPostDate'] ) && $attributes['displayPostDate'] ) {
		$class .= ' has-dates';
	}

	if ( isset( $attributes['className'] ) ) {
		$class .= ' ' . $attributes['className'];
	}

	$block_content = sprintf(
		'<ul class="%1$s">%2$s</ul>',
		esc_attr( $class ),
		$list_items_markup
	);

	return $block_content;
}

/**
 * Registers the `hrscourses/list-courses` on the server.
 *
 * @since 0.4.0
 */
function register_block_list_courses() {
	register_block_type(
		'hrscourses/list-courses',
		array(
			'attributes'      => array(
				'align'                     => array(
					'type' => 'string',
					'enum' => array( 'left', 'center', 'right', 'wide', 'full' ),
				),
				'className'                 => array(
					'type' => 'string',
				),
				'learningPrograms'          => array(
					'type' => 'string',
				),
				'coursesToShow'             => array(
					'type'    => 'number',
					'default' => 5,
				),
				'displayCourseContent'      => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'displayCourseContentRadio' => array(
					'type'    => 'string',
					'default' => 'excerpt',
				),
				'excerptLength'             => array(
					'type'    => 'number',
					'default' => 55,
				),
				'displayPostDate'           => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'postLayout'                => array(
					'type'    => 'string',
					'default' => 'list',
				),
				'columns'                   => array(
					'type'    => 'number',
					'default' => 3,
				),
				'order'                     => array(
					'type'    => 'string',
					'default' => 'desc',
				),
				'orderBy'                   => array(
					'type'    => 'string',
					'default' => 'date',
				),
			),
			'render_callback' => __NAMESPACE__ . '\render_block_list_courses',
		)
	);
}
// Use later priority to make sure required resources are ready.
add_action( 'init', __NAMESPACE__ . '\register_block_list_courses', 25 );
