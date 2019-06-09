<?php
$origins = array(
    'script',
    'style',
);

foreach ($origins as $origin)
{
    ?>
    <p>
    	<input type="checkbox"
	        name="hh_content_security_policy_value[<?php echo $item; ?>][<?php echo $origin; ?>]"
        	id="csp-<?php echo $item; ?>-<?php echo $origin; ?>"
        	value="1"<?php echo isset($csp_value[$item][$origin]) ? ' checked' : NULL; ?>
        	class="http-header-value"<?php echo $content_security_policy == 1 ? NULL : ' readonly'; ?>>
    	<label for="csp-<?php echo $item; ?>-<?php echo $origin; ?>"><?php echo $origin; ?></label>
    </p>
    <?php
}
?>