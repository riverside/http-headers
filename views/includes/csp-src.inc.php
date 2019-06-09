<?php
$origins = array(
    'wildcard' => '*', 
    'self' => "'self'", 
    'none' => "'none'", 
    'unsafe-inline' => "'unsafe-inline'", 
    'unsafe-eval' => "'unsafe-eval'",
    'strict-dynamic' => "'strict-dynamic'",
    'report-sample' => "'report-sample'",
    'http' => 'http:',
    'https' => 'https:', 
    'data' => 'data:',
    'mediastream' => 'mediastream:',
    'blob' => 'blob:',
    'filesystem' => 'filesystem:',
);
 
foreach ($origins as $k => $origin)
{
    ?>
    <p<?php echo $origin == '*' || !isset($csp_value[$item]['*']) ? NULL : ' style="display: none"'; ?>>
        <input type="checkbox"
            name="hh_content_security_policy_value[<?php echo $item; ?>][<?php echo $origin; ?>]"
            id="csp-<?php echo $item; ?>-<?php echo $k; ?>"
            value="1"<?php echo isset($csp_value[$item][$origin]) ? ' checked' : NULL; ?>
            class="http-header-value"<?php echo $content_security_policy == 1 ? NULL : ' readonly'; ?>>
        <label for="csp-<?php echo $item; ?>-<?php echo $k; ?>"><?php echo $origin; ?></label>
    </p>
    <?php
}

switch ($item) {
    case 'script-src':
        $host_sources = array(
            'js.example.com',
            'http://js.example.com',
            'https://js.example.com',
        );
        break;
    case 'style-src':
        $host_sources = array(
            'css.example.com',
            'http://css.example.com',
            'https://css.example.com',
        );
        break;
    case 'img-src':
        $host_sources = array(
            'img.example.com',
            'http://img.example.com',
            'https://img.example.com',
        );
        break;
    case 'font-src':
        $host_sources = array(
            'font.example.com',
            'http://font.example.com',
            'https://font.example.com',
        );
        break;
    case 'default-src':
        $host_sources = array(
            'http://*.example.com',
            'mail.example.com:443',
            'https://assets.example.com',
            'cdn.example.com',
        );
        break;
    default:
        $host_sources = array(
            'https://store.example.com',
            'store.example.com',
            '*.example.com',
        );
}
shuffle($host_sources);
?>
<p<?php echo !isset($csp_value[$item]['*']) ? NULL : ' style="display: none"'; ?>>
	<input type="text" 
		name="hh_content_security_policy_value[<?php echo $item; ?>][source]" 
		class="http-header-value" 
		size="40"
		placeholder="<?php echo $host_sources[0]; ?>"
		value="<?php echo esc_attr(@$csp_value[$item]['source']); ?>"<?php echo $content_security_policy == 1 ? NULL : ' readonly'; ?>
</p>