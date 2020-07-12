<?php
/**
 * The Template for displaying data from https://jsonplaceholder.typicode.com/users)
 */

use TestInpsyde\Wp\Plugin\TestInpsyde;

// phpcs:ignore PSR2.ControlStructures.ControlStructureSpacing.SpacingAfterOpenBrace
if ( ! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/** @noinspection PhpUnhandledExceptionInspection */
$viewService = TestInpsyde::getServiceView();
$textDomain  = $viewParams['textDomain'] ?? 'inpsyde';
$user        = $viewParams['user'] ?? [];
?>

<div class="user-details">
    <header class="entry-header">
        <div class="entry-header-inner">
            <h3 class="entry-title"><?php echo esc_html(sprintf(__('User Details ID %s', $textDomain),
                    $user['id'])) ?></h3>
        </div>
    </header>

    <div class="entry-content">

        <?php
        if ( ! empty($user)) {
            ?>
            <table class="user-details__grid">
                <tr class="user-details__grid__row">
                    <td class="user-details__grid__name"><?php echo esc_html(__('ID', $textDomain)) ?></td>
                    <td class="user-details__grid__value"><?php echo esc_html($user['id']) ?></td>
                </tr>
                <tr class="user-details__grid__row">
                    <td class="user-details__grid__name"><?php echo esc_html(__('Name', $textDomain)) ?></td>
                    <td class="user-details__grid__value"><?php echo esc_html($user['name']) ?></td>
                </tr>
                <tr class="user-details__grid__row">
                    <td class="user-details__grid__name"><?php echo esc_html(__('Username', $textDomain)) ?></td>
                    <td class="user-details__grid__value"><?php echo esc_html($user['username']) ?></td>
                </tr>
                <tr class="user-details__grid__row">
                    <td class="user-details__grid__name"><?php echo esc_html(__('Email', $textDomain)) ?></td>
                    <td class="user-details__grid__value"><?php echo esc_html($user['email']) ?></td>
                </tr>
                <tr class="user-details__grid__row">
                    <td class="user-details__grid__name"><?php echo esc_html(__('Phone', $textDomain)) ?></td>
                    <td class="user-details__grid__value"><?php echo esc_html($user['phone']) ?></td>
                </tr>
                <tr class="user-details__grid__row">
                    <td class="user-details__grid__name"><?php echo esc_html(__('Website', $textDomain)) ?></td>
                    <td class="user-details__grid__value"><?php echo esc_html($user['website']) ?></td>
                </tr>
            </table>
            <?php
        }
        ?>

    </div>
</div>
</main>
