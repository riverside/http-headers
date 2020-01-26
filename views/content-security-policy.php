<?php
if (!defined('ABSPATH')) {
    exit;
}
$content_security_policy = get_option('hh_content_security_policy', 0);
?>
<tr valign="top">
	<th scope="row">Content Security Policy
		<p class="description"><?php _e('Content Security Policy (CSP) is an added layer of security that helps to detect and mitigate certain types of attacks, including Cross Site Scripting (XSS) and data injection attacks. These attacks are used for everything from data theft to site defacement or distribution of malware.', 'http-headers'); ?></p>
		
		<p>
		<label><input type="checkbox" class="http-header-value"
			name="hh_content_security_policy_report_only" value="1"
			<?php checked(get_option('hh_content_security_policy_report_only'), 1, true); ?>
			<?php echo $content_security_policy == 1 ? NULL : ' readonly'; ?> /> "Report-Only" (<?php _e('for reporting-only purposes', 'http-headers'); ?>)</label>
		</p>
        <hr>
        <p class="description">Useful tools:</p>
        <p class="description">
            <a target="_blank" href="https://zinoui.com/tools/sri-generator">SRI Hash Generator</a>
            - generates subresource integrity hashes using a cryptographic algorithm.
        </p>
        <p class="description">
            <a target="_blank" href="https://zinoui.com/tools/csp-hash">CSP Hash Generator</a>
            - generates CSP hashes to use in script-src and style-src directives.
        </p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
	</th>
	<td>
       	<fieldset>
        	<legend class="screen-reader-text">Content-Security-Policy</legend>
	    <?php
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_content_security_policy" value="<?php echo $k; ?>"<?php checked($content_security_policy, $k, true); ?> /> <?php echo $v; ?></label></p><?php
        }
        ?>
       	</fieldset>
	</td>
	<td>
	<?php settings_fields( 'http-headers-csp' ); ?>
	<?php do_settings_sections( 'http-headers-csp' ); ?>
		<table>
			<tbody>
				<tr>
					<td><strong><?php _e('Directive', 'http-headers'); ?></strong></td>
					<td><strong><?php _e('Value', 'http-headers'); ?></strong></td>
				</tr>
			<?php 
			$directives = array(
			    'default-src', 
			    'script-src',
			    'style-src',
			    'img-src',
			    'connect-src',
			    'font-src',
			    'media-src',
			    'report-uri',
			    'child-src',
			    'form-action',
			    'frame-ancestors',
			    'object-src', 
			    'frame-src',
			    'worker-src',
			    'manifest-src',
			    'base-uri',
			    'plugin-types',
			    'report-to',
			    'sandbox',
			    'require-sri-for',
                'block-all-mixed-content', 
                'upgrade-insecure-requests',
			);
			$csp_value = get_option('hh_content_security_policy_value');
			foreach ($directives as $item)
			{
				?>
				<tr>
        			<td><?php echo $item; ?></td>
        			<td>
        			<?php 
        			
        			if ($item == 'sandbox')
        			{
        			    include 'includes/csp-sandbox.inc.php';
        			    
        			} elseif (in_array($item, array('block-all-mixed-content', 'upgrade-insecure-requests'))) {
        			             			    
        			    include 'includes/csp-inc.inc.php';
        			    
        			} elseif (in_array($item, array('report-to', 'plugin-types'))) {
        			    
        			    include 'includes/csp-text.inc.php';
        			    
        			} elseif ($item == 'require-sri-for') {
        			    
        			    include 'includes/csp-sri.inc.php';
        			    
        			} else {
        			    
        			    include 'includes/csp-src.inc.php';
        			    
        			}
        			?>
        			</td>
        		</tr>
				<?php
			}
			?>
        	</tbody>
		</table>
	</td>
</tr>