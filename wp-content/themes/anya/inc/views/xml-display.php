<?php
global $wp;
?>

<div class="wrap">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    <?php //include_once plugin_dir_path( __FILE__ ). 'sap_integration_woocommerce-admin-sap-message.php'?>

    <?php if (!empty($updated)): ?>
        <div class="updated">
            <p>
                <?= __(' successfully updated', 'sap-integration-woocommerce'); ?>
            </p>
        </div>
    <?php endif ?>


    <form action="<?php global $wp; $wp->query_vars; echo add_query_arg([]); ?>" method="POST">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label>Ссылка на прайс (Google Disk)</label>
                </th>

                <td>
                    <input class="regular-text w-100"
                           name="xml_price_url"
                           id="xml_price_url"
                           value="<?= get_option("xml_price_url");?>">
                </td>
            </tr>


            </tbody>
        </table>


        <p class="submit">
            <input type="submit" name="submit-xml-settings" id="submit" class="button button-primary"
                   value="Обновить">
        </p>
    </form>
</div>

