<?php
/**
 * The Template for displaying data from https://jsonplaceholder.typicode.com/users)
 */

use TestInpsyde\Wp\Plugin\TestInpsyde;

if ( ! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/** @noinspection PhpUnhandledExceptionInspection */
$viewService = TestInpsyde::getServiceView();
$textDomain  = $viewService->textDomain;

get_header();
?>

<main id="site-content" role="main">
    <article class="custom-page">
        <header class="custom-page__header entry-header">
            <div class="entry-header-inner">
                <h1 class="entry-title"><?php echo __('Custom Inpsyde', $textDomain) ?></h1>
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
