<input type="text" name="hh_content_security_policy_value[<?php echo $item; ?>]" class="http-header-value" size="40"
	value="<?php echo esc_attr(@$csp_value[$item]); ?>"<?php echo $content_security_policy == 1 ? NULL : ' readonly'; ?>>
<?php 
if ($item == 'plugin-types')
{
    ?>
    <br>
	<em>Example: application/x-shockwave-flash application/x-java-applet</em>
	<?php 
}
?>