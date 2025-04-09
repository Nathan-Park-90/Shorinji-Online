<?php
/*
	Template Name: Shorinji Techniques Template
*/
?>
	<?php get_header(); ?>

	<div id="page-wrap">
		<?php
		//full container page options
		$post_full_container_choice = get_post_meta( get_the_ID(), 'pegasus-page-container-checkbox', true );
		//full container theme option
		$global_full_container_option = pegasus_get_option('full_container_chk' );

		//assign post class
		$pegasus_post_container_choice = ( 'on' === $post_full_container_choice ) ? 'container-fluid' : 'container';
		//assign global class
		$pegasus_global_container_choice = ( 'on' === $global_full_container_option ) ? 'container-fluid' : 'container' ;
		//check global first then post
		$final_container_class = ( 'container-fluid' === $pegasus_global_container_choice ) ? $pegasus_global_container_choice : $pegasus_post_container_choice;

		//left align right sidebar?
		$left_align_sidebar_chk = pegasus_get_option( 'sidebar_left_chk' ) ? pegasus_get_option( 'sidebar_left_chk' ) : 'off';
		//enable both sidebars?
		$pegasus_left_sidebar_option = ( 'on' === pegasus_get_option( 'both_sidebar_chk' ) ) ? pegasus_get_option( 'both_sidebar_chk' ) : 'off';
		//change content class if both sidebars
		$page_body_content_class = ( 'on' === $pegasus_left_sidebar_option ) ? 'col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xg-6' : 'col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xg-9';

		//page header page options
		$post_disable_page_header_choice = get_post_meta( get_the_ID(), 'pegasus-page-header-checkbox', true ) ? get_post_meta( get_the_ID(), 'pegasus-page-header-checkbox', true ) : 'off';
		//page header theme option
		$global_disable_page_header_option = pegasus_get_option('page_header_chk' ) ? pegasus_get_option('page_header_chk' ) : 'off';
		//check theme option for page header before page option
		$page_title = $post->post_title;
		$is_this_home = is_home();
		if ( 'on' === $global_disable_page_header_option ) {
			$final_page_header_option = 'on';
		} elseif ( 'on' === $post_disable_page_header_choice ) {
			$final_page_header_option = 'on';
		} else {
			$final_page_header_option = 'off';
		}

		if ( true === $is_this_home ) {
			$final_page_header_option = 'off';
		}
		?>

		<div class="<?php echo $final_container_class; ?>">
			<div class="">

				<div class="inner-content">
					<div class="content-no-sidebar">
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							<?php if( 'off' === $final_page_header_option ) { ?>
								<div class="page-header">
									<?php
									if( '' === $page_title ) {
										echo '';
									} elseif ( $page_title ) {
										echo '<h1>';
										echo the_title();
										echo '</h1>';
									}
									?>
								</div>
							<?php }else{ ?>
								<div class="page-header-spacer"></div>
							<?php } ?>

							<?php
							// URL to the JSON file
							$json_url = 'https://shorinjiome.online/wp-content/themes/pegasus-child/data/shorinji_techniques.json';

							// Fetch the JSON content
							$json_content = file_get_contents($json_url);

							// Check if fetching was successful
							if ($json_content === false) {
								die('Error: Unable to fetch JSON content from the URL.');
							}

							// Function to display flashcards
							function displayFlashcards($json) {
								$flashcards = json_decode($json, true);

								if (json_last_error() !== JSON_ERROR_NONE) {
									die('Error decoding JSON: ' . json_last_error_msg());
								}

								// 1. Get unique ranks
								$ranks = array_unique(array_column($flashcards, 'Rank'));

								// 2. Display rank buttons
								echo '<div class="rank-buttons">';
								foreach ($ranks as $rank) {
									echo '<button class="action filter__item" data-filter=".' . strtolower($rank) . '">';
									echo '<span class="action__text">' . $rank . '</span>';
									echo '</button>';
								}
								echo '</div>';

								// 3. Display flashcards
								echo '<div class="grid">';
								foreach ($flashcards as $card) {
									echo '<article class="grid__item ' . strtolower($card['Style']) . ' clearfix ' . strtolower($card['Rank']) . '">';
									echo '<div class="block-inner">';
									echo '<div class="meta">';
									echo '<a href="#" alt="' . esc_html($card['Title']) . '">';
									echo '<h3 class="meta__title">' . esc_html($card['Title']) . '</h3>';
									echo '</a>';
									echo '<p class="meta__description">' . esc_html($card['Description']) . '</p>';
									echo '</div>';
									echo '</div>';
									echo '</article>';

								}
								echo '</div>'; // grid
							}

							// Call the function with the fetched JSON content
							displayFlashcards($json_content);
							?>


							<?php the_content(); ?>

						<?php endwhile; else: ?>
							<?php /* kinda a 404 of sorts when not working */ ?>
							<div class="page-header">
								<h1>Oh no!</h1>
							</div>
							<p>No content is appearing for this page!</p>
						<?php endif; ?>
						<?php
						if ( function_exists( 'wp_bootstrap_edit_post_link' ) ) {
							// Edit post link
							wp_bootstrap_edit_post_link(
								sprintf(
								/* translators: %s: Name of current post */
									__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'textdomain' ),
									get_the_title()
								),
								'<span class="edit-link">',
								'</span>'
							);
						}
						if ( function_exists( 'wp_bootstrap_posts_pagination' ) ) {
							wp_bootstrap_posts_pagination( array(
								'prev_text'          => __( 'Previous page', 'pegasus-bootstrap' ),
								'next_text'          => __( 'Next page', 'pegasus-bootstrap' ),
								'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'pegasus-bootstrap' ) . ' </span>'
							) );
						}
						?>
					</div>
				</div></div></div></div><?php get_footer(); ?>