<?php
/**
 * WSUWP HRS Courses render functions.
 *
 * Handles formatting and printing.
 *
 * @package WSUWP_HRS_Courses
 * @since 0.3.0
 */
namespace WSUWP\HRS\Courses\Render;
use WSUWP\HRS\Courses\Setup;

/**
 * Sanitizes a block name.
 *
 * Cleans up a block name to allow it to be used in a PHP function name.
 * Only lowercase alphanumeric characters and underscores are allowed; all other
 * characters are converted to underscores.
 *
 * @since 0.3.0
 *
 * @param string $name Required. The block name to sanitize.
 * @return string The sanitized block name.
 */
function sanitize_block_name( $name ) {
	$raw_name = $name;
	$name     = strtolower( $name );
	$name     = preg_replace( '/[^a-z0-9_]/', '_', $name );

	/**
	 * Filters a sanitized block name string.
	 *
	 * @since 0.3.0
	 *
	 * @param string $name     The sanitized block name.
	 * @param string $raw_name The name prior to sanitization.
	 */
	return apply_filters( 'wsuwp_hrs_courses_sanitize_block_name', $name, $raw_name );
}

/**
 * Displays the post archive page navigation.
 *
 * Retrieves and displays the pagination navigation section on archive type
 * pages such as a taxonomy archives page.
 *
 * @since 0.4.0
 */
function archive_pagination( $total_pages = '' ) {
	$args = array(
		'base'               => str_replace( 99164, '%#%', esc_url( get_pagenum_link( 99164 ) ) ),
		'format'             => 'page/%#%',
		'type'               => 'list',
		'current'            => max( 1, get_query_var( 'paged' ) ),
		'prev_text'          => 'Previous <span class="screen-reader-text">page</span>',
		'next_text'          => 'Next <span class="screen-reader-text">page</span>',
		'before_page_number' => '<span class="screen-reader-text">Page </span>',
	);

	if ( '' !== $total_pages ) {
		$args['total'] = $total_pages;
	}

	$pagination = paginate_links( $args );

	if ( ! empty( $pagination ) ) {
		?>
		<footer class="article-footer">
			<section class="row single pager prevnext gutter pad-ends">
				<div class="column one">
					<nav class="navigation pagination" role="navigation" aria-label="Pagination navigation">
						<?php echo wp_kses_post( $pagination ); ?>
					</nav>
				</div>
			</section>
		</footer>
		<?php
	}
}

/**
 * Displays a list of all terms in a given taxonomy as a linked list.
 *
 * @since 0.6.0
 *
 * @param string $taxonomy The taxonomy to display a terms list for.
 */
function the_taxonomy_nav_list( $taxonomy ) {
	if ( ! isset( $taxonomy ) ) {
		return;
	}

	$terms    = get_terms( array( 'taxonomy' => esc_attr( $taxonomy ) ) );
	$tax_obj  = get_taxonomy( $taxonomy );
	$tax_name = $tax_obj->labels->singular_name ?? '(No name)';

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$terms_list = '';

		foreach ( $terms as $term ) {
			$terms_list .= sprintf(
				'<li><a href="%1$s">%2$s</a></li>',
				esc_url( get_term_link( $term ) ),
				esc_html( $term->name )
			);
		}

		printf(
			'<div class="wp-block-column"><h3>%1$s</h3><ul>%2$s</ul></div>',
			__( 'Browse by ' ) . esc_html( $tax_name ),
			$terms_list
		);
	}
}

/**
 * Displays the Courses search form.
 *
 * @since 0.6.0
 */
function get_courses_search_form() {
	// Retrieve the default search form.
	$default_form = get_search_form(
		array(
			'echo'       => false,
			'aria_label' => 'Courses search',
		)
	);

	// Remove the closing `<form>` tag to allow additions and modify submit button text.
	$form = str_replace( '</form>', '', $default_form );
	$form = str_replace( 'value="Search"', 'value="Search Courses"', $form );

	printf(
		'%1$s<input type="hidden" value="%2$s" name="post_type" /></form>',
		$form,
		esc_attr( Setup\WSUWP_HRS_Courses::$post_type_slug )
	);
}
