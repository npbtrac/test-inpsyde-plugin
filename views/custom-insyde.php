<?php
/**
 * The Template for displaying data from https://jsonplaceholder.typicode.com/users)
 */

use TestInpsyde\Wp\Plugin\Test_Inpsyde;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/** @noinspection PhpUnhandledExceptionInspection */
$view_service = Test_Inpsyde::get_view_service();
$text_domain  = $view_service->text_domain;

get_header();
?>

<main id="site-content" role="main">
	<article class="custom-page">
		<header class="custom-page__header entry-header">
			<div class="entry-header-inner">
				<h1 class="entry-title"><?php echo __( 'Custom Inpsyde', $text_domain ) ?></h1>
			</div><!-- .archive-header-inner -->
		</header>
		<div class="custom-page__content post-inner">
			<div class="entry-content">

				page content

			</div>
		</div>
	</article>
</main>

<?php
get_footer();
?>
