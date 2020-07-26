<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr>
	<th scope="row">Cross-Origin-Embedder-Policy
		<p class="description"><?php _e("The HTTP Cross-Origin-Embedder-Policy (COEP) response header prevents a document from loading any cross-origin resources that don't explicitly grant the document permission (using CORP or CORS).", 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cross-Origin-Embedder-Policy"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">Cross-Origin-Embedder-Policy</legend>
			<?php
            $cross_origin_embedder_policy = get_option('hh_cross_origin_embedder_policy', 0);
			foreach ($bools as $k => $v)
			{
				?><p><label><input type="radio" class="http-header" name="hh_cross_origin_embedder_policy" value="<?php echo $k; ?>"<?php checked($cross_origin_embedder_policy, $k); ?> /> <?php echo $v; ?></label></p><?php
			}
			?>
		</fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-coep' ); ?>
		<?php do_settings_sections( 'http-headers-coep' ); ?>
        <select name="hh_cross_origin_embedder_policy_value" class="http-header-value"<?php echo $cross_origin_embedder_policy == 1 ? NULL : ' readonly'; ?>>
            <?php
            $items = array('unsafe-none', 'require-corp');
            $cross_origin_embedder_policy_value = get_option('hh_cross_origin_embedder_policy_value');
            foreach ($items as $item) {
                ?><option value="<?php echo $item; ?>"<?php selected($cross_origin_embedder_policy_value, $item); ?>><?php echo $item; ?></option><?php
            }
            ?>
        </select>
	</td>
</tr>