<?php
/**
 * WSUWP Courses Archive Template
 *
 * The template for displaying lists of courses in archive formats.
 *
 * @package WSUWP_HRS_Courses
 * @since 0.4.0
 */
namespace WSUWP\HRS\Courses\Templates\Archive;
use WSUWP\HRS\Courses\Setup;
use WSUWP\HRS\Courses\Render;

get_header();
?>

<main id="wsuwp-main" class="wsuwp-courses-archive">
	<header class="page-header">
		<h1>
			<?php
			if ( ! is_search() ) {
				printf(
					/* translators: the HRS news archive title: 1: the taxonomy name if it exists or the word "All" */
					esc_html__( '%s Courses', 'wsuwp-hrs-courses' ),
					single_term_title( '', false ) ?? 'All'
				);
			} else {
				printf(
					/* translators: the HRS news archive title: 1: the search term */
					esc_html__( 'Courses matching: %s', 'wsuwp-hrs-courses' ),
					get_search_query()
				);
			}
			?>
		</h1>
	</header>
	<section class="row single gutter courses-archive">
		<?php
		if ( is_tax() ) {
			the_archive_description();
		} else {
			?>
			<div class="wp-block-hrs-wsu-edu-callouts courses-archive-frontmatter">
				<p class="has-large-font-size">Find a Course</p>
				<div class="wp-block-columns has-3-columns">
					<?php Render\the_taxonomy_nav_list( 'course_tag' ); ?>
					<?php Render\the_taxonomy_nav_list( 'learning_program' ); ?>
					<div class="wp-block-column">
						<h3><?php _e( 'Search by Keyword', 'wsuwp-hrs-courses' ); ?></h3>
						<?php Render\get_courses_search_form(); ?>
					</div>
				</div>
			</div>
			<?php
		}
		?>

		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'archive-content column one' ); ?>>
					<header class="article-header">
						<p class="course-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
						</p>
						<div class="article-taxonomy--primary">
							<?php
							echo get_the_term_list(
								get_the_ID(),
								'learning_program',
								__( '<ul><li>', 'wsuwp-hrs-courses' ),
								' ',
								'</li></ul>'
							);
							?>
						</div>
					</header>
					<div class="article-content">
						<?php the_content(); ?>
					</div>
				</article>
				<?php
			}
		} else {
			?>
			<article class="archive-content column one">
				<header class="article-header">
					<h2>
						<?php esc_html_e( 'We couldn&rsquo;t find any courses matching:', 'hrs-wsu-edu' ); ?>
						<span class="search-query"><?php echo get_search_query(); ?></span>
					</h2>
				</header>
				<div class="article-content">
					<p><?php esc_html_e( 'Perhaps try another search term, or browse courses by Course Tag or Learning Program.', 'wsuwp-hrs-courses' ); ?></p>
					<p><a href="<?php echo esc_url( get_post_type_archive_link( Setup\WSUWP_HRS_Courses::$post_type_slug ) ); ?>"><?php esc_html_e( 'Return to the All Courses page.', 'wsuwp-hrs-courses' ); ?></a></p>
				</div>
			</article>
			<?php
		}
		?>
	</section>
	<?php Render\archive_pagination(); ?>
	<?php get_template_part( 'parts/footers' ); ?>

</main><!--/#page-->

<?php
get_footer();
