<?php 
if (!defined('ABSPATH')) {
    exit;
} 
include dirname(__FILE__) . '/includes/config.inc.php';
include dirname(__FILE__) . '/includes/breadcrumbs.inc.php';
?>
<table class="hh-index-table">
	<thead>
		<tr>
			<th><?php _e('Header', 'http-headers'); ?></th>
			<th style="width: 45%"><?php _e('Value', 'http-headers'); ?></th>
			<th class="hh-status"><?php _e('Status', 'http-headers'); ?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	foreach ($headers as $index => $item)
	{
		if (@$_GET['category'] != $item[2])
		{
			continue;
		}
		
		$key = $item[1];
		
		$option = get_option($key, 0);
		$isOn = (int) $option === 1;
		$value = NULL;
		if ($isOn)
		{
			$value = get_option($key .'_value');
			switch ($key)
			{
				case 'hh_age':
					$value = (int) $value;
					break;
				case 'hh_p3p':
					if (!empty($value))
					{
						$value = sprintf('CP="%s"', join(' ', array_keys($value)));
					}
					break;
				case 'hh_x_xxs_protection':
					if ($value == '1; report=') {
						$value .= get_option('hh_x_xxs_protection_uri');
					}
					break;
				case 'hh_x_powered_by':
					if (get_option('hh_x_powered_by_option') == 'unset') {
						$value = '[Unset]';
					}
					break;
				case 'hh_x_frame_options':
					$value = strtoupper($value);
					if ($value == 'ALLOW-FROM')
					{
						$value .= ' ' . get_option('hh_x_frame_options_domain');
					}
					break;
				case 'hh_strict_transport_security':
					$tmp = array();
					$hh_strict_transport_security_max_age = get_option('hh_strict_transport_security_max_age');
					if ($hh_strict_transport_security_max_age !== false)
					{
						$tmp[] = sprintf('max-age=%u', $hh_strict_transport_security_max_age);
						if (get_option('hh_strict_transport_security_sub_domains'))
						{
							$tmp[] = 'includeSubDomains';
						}
						if (get_option('hh_strict_transport_security_preload'))
						{
							$tmp[] = 'preload';
						}
					} else {
						$tmp = array(get_option('hh_strict_transport_security_value'));
					}
					if (!empty($tmp))
					{
						$value = join('; ', $tmp);
					}
					break;
				case 'hh_timing_allow_origin':
					if ($value == 'origin')
					{
						$value = get_option('hh_timing_allow_origin_url');
					}
					break;
				case 'hh_access_control_allow_origin':
					if ($value == 'origin')
					{
					    $value = join('<br>', get_option('hh_access_control_allow_origin_url', array()));
					}
					break;
				case 'hh_access_control_expose_headers':
				case 'hh_access_control_allow_headers':
				case 'hh_access_control_allow_methods':
					$value = join(', ', array_keys($value));
					break;
				case 'hh_content_security_policy':
				    $value = build_csp_value($value);
					if (get_option('hh_content_security_policy_report_only')) {
						$item[0] .= '-Report-Only';
					}
					break;
				case 'hh_content_encoding':
					$value = !$value ? null : join(', ', array_keys($value));
					
					$ext = get_option('hh_content_encoding_ext');
					if (!empty($ext)) {
						$ext = join(', ', array_keys($ext));
						$value .= (!empty($value) ? '<br>' : null) . $ext;
					}
					$module = get_option('hh_content_encoding_module');
					switch ($module) {
					    case 'brotli_deflate':
					        $enc = 'br, gzip';
					        break;
					    case 'brotli':
					        $enc = 'br';
					        break;
					    case 'deflate':
					    default:
					        $enc = 'gzip';
					        break;
					}
					
					$value = !empty($value) ? sprintf('%s (%s)', $enc, $value) : $enc;
					break;
				case 'hh_vary':
					$value = !$value ? null : join(', ', array_keys($value));
					break;
				case 'hh_www_authenticate':
					$value = get_option('hh_www_authenticate_type');
					break;
				case 'hh_cache_control':
					$tmp = array();
					foreach ($value as $k => $v) {
						if (in_array($k, array('max-age', 's-maxage', 'stale-while-revalidate', 'stale-if-error'))) {
							if (strlen($v) > 0) {
								$tmp[] = sprintf("%s=%u", $k, $v);
							}
						} else {
							$tmp[] = $k;
						}
					}
					$value = join(', ', $tmp);
					break;
				case 'hh_expires':
					$tmp = array();
					$types = get_option('hh_expires_type', array());
					foreach ($types as $type => $whatever) {
						list($base, $period, $suffix) = explode('_', $value[$type]);
						if (in_array($base, array('access', 'modification'))) {
							$tmp[] = $type != 'default'
								? sprintf('%s = "%s plus %u %s"', $type, $base, $period, $suffix)
								: sprintf('default = "%s plus %u %s"', $base, $period, $suffix);
						} elseif ($base == 'invalid') {
							$tmp[] = $type != 'default'
								? sprintf('%s = A0', $type)
								: sprintf('default = A0');
						}
					}
					$value = join('<br>', $tmp);
					break;
				case 'hh_cookie_security':
				    if (is_array($value)) {
				        if (isset($value['SameSite']) && !is_samesite_supported()) {
				            unset($value['SameSite']);
                        }
                    }
					$value = is_array($value) && !empty($value)
                        ? '&#10004; ' . join(' &#10004; ', array_keys($value))
                        : NULL;
					break;
				case 'hh_expect_ct':
					$tmp = array();
					$tmp[] = sprintf('max-age=%u', get_option('hh_expect_ct_max_age'));
					if (get_option('hh_expect_ct_enforce') == 1) {
						$tmp[] = 'enforce';
					}
					$tmp[] = sprintf('report-uri="%s"', get_option('hh_expect_ct_report_uri'));
					$value = join(', ', $tmp); 
					break;
				case 'hh_custom_headers':
					$_names = array($item[0]);
					$_values = array('&nbsp;');
					foreach ($value['name'] as $key => $name)
					{
						if (!empty($name) && !empty($value['value'][$key]))
						{
							$_names[] = '<p class="hh-p">&nbsp;&nbsp;&nbsp;&nbsp;'.$name.'</p>';
							$_values[] = '<p class="hh-p">'.$value['value'][$key].'</p>';
						}
					}
					$item[0] = join('', $_names);
					$value = join('', $_values);
					break;
				case 'hh_report_to':
				    $tmp = array();
				    foreach ($value as $a_item)
				    {
				        $endpoints = array();
				        foreach ($a_item['endpoints'] as $endpoint)
				        {
				            $endpoints[] = sprintf('{"url": "%s"%s%s}',
				                $endpoint['url'],
				                is_numeric($endpoint['priority']) ? sprintf(', "priority": %u', $endpoint['priority']) : NULL,
				                is_numeric($endpoint['weight']) ? sprintf(', "weight": %u', $endpoint['weight']) : NULL
				            );
				        }
				        
				        $tmp[] = sprintf('{"max_age": %u%s%s, "endpoints": [%s]}', 
				            $a_item['max_age'],
				            $a_item['group'] ? sprintf(', "group": "%s"', $a_item['group']) : NULL,
				            $a_item['include_subdomains'] ? sprintf(', "include_subdomains": true') : NULL,
				            join(", ", $endpoints)
				        );
				    }
				    $value = join(', ', $tmp);
				    break;
				case 'hh_nel':
				    $value = sprintf('{"report_to": "%s", "max_age": %u%s%s%s%s%s}',
				        $value['report_to'], $value['max_age'], 
				        isset($value['include_subdomains']) ? ', "include_subdomains": true' : NULL,
				        array_key_exists('success_fraction', $value) && is_numeric($value['success_fraction']) ? ', "success_fraction": '. $value['success_fraction'] : NULL,
				        array_key_exists('failure_fraction', $value) && is_numeric($value['failure_fraction']) ? ', "failure_fraction": '. $value['failure_fraction'] : NULL,
				        isset($value['request_headers']) && !empty($value['request_headers']) ? sprintf(', "request_headers": ["%s"]', join('", "', array_map('trim', explode(',', $value['request_headers'])))) : NULL,
				        isset($value['response_headers']) && !empty($value['response_headers']) ? sprintf(', "response_headers": ["%s"]', join('", "', array_map('trim', explode(',', $value['response_headers'])))) : NULL
				    );
				    break;
				case 'hh_feature_policy':
				    $fp = array();
				    $features = get_option('hh_feature_policy_feature');
				    if (!$features)
				    {
				        $features = array();
				    }
				    $origins = get_option('hh_feature_policy_origin');
				    foreach ($features as $key => $whatever)
				    {
				        switch ($value[$key])
				        {
				            case '*':
				            case "'none'":
				                $fp[] = sprintf("%s %s", $key, $value[$key]);
				                break;
				            case "'self'":
				                $fp[] = sprintf("%s %s%s", $key, $value[$key], !empty($origins[$key]) ? " " . $origins[$key] : NULL);
				                break;
				            case 'origin(s)':
				                $fp[] = sprintf("%s %s", $key, $origins[$key]);
				                break;
				        }
				    }
				    if (!empty($fp))
				    {
				        $value = join('; ', $fp);
				    } else {
				        $value = "";
				    }
				    break;
				case 'hh_clear_site_data':
				    $value = '"' . join('", "', array_keys($value)) . '"';
				    break;
                case 'hh_content_type':
                    $tmp = array();
                    foreach ($value as $key => $val)  {
                        $tmp[] = sprintf(".%s => %s", $key, $val);
                    }
                    $value = join("<br>", $tmp);
                    break;
				default:
					$value = !is_array($value) ? $value : join(', ', $value);
			}
		}
		$status = $isOn ? __('On', 'http-headers') : __('Off', 'http-headers');
		?>
		<tr<?php echo $isOn ? ' class="active"' : NULL; ?>>
			<td><?php echo $item[0]; ?></td>
			<td><?php echo $value; ?></td>
			<td class="hh-status hh-status-<?php echo $isOn ? 'on' : 'off'; ?>"><span><?php echo $status; ?></span></td>
			<td><a href="<?php echo get_admin_url(); ?>options-general.php?page=http-headers&header=<?php 
				echo $index; ?>"><?php _e('Edit', 'http-headers'); ?></a></td>
		</tr>
		<?php
	}
	?>
	</tbody>
</table>