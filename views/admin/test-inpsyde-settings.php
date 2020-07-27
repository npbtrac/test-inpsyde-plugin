<?php

use TestInpsyde\Wp\Plugin\TestInpsyde;

$textDomain = $viewParams['textDomain'] ?? 'inpsyde';
?>
<div class="test-inpsyde-settings">
    <h2><?php echo esc_html(__('Test Inpsyde Settings', $textDomain)) ?></h2>
    <form method="post" action="options.php">
        <?php settings_fields(TestInpsyde::OPTIONS_GROUP_NAME); ?>
        <h3>This is my option</h3>
        <p>Some text here.</p>
        <table>
            <tr valign="top">
                <th scope="row"><label for="custom_endpoint_name">Label</label></th>
                <td><input type="text" id="custom_endpoint_name" name="custom_endpoint_name"
                           value="<?php echo esc_attr(get_option('custom_endpoint_name')); ?>"/></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>