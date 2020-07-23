<?php
/*
Plugin Name: HTTP Headers
Plugin URI: https://zinoui.com/blog/http-headers-for-wordpress
Description: A plugin for HTTP headers management including security, access-control (CORS), caching, compression, and authentication.
Version: 1.16.1
Author: Dimitar Ivanov
Author URI: https://zinoui.com
License: GPLv2 or later
Text Domain: http-headers
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/copyleft/gpl.html>.

Copyright (c) 2017-2020 Zino UI
*/

if (!defined('ABSPATH')) {
    exit;
}

$options = include dirname(__FILE__) . '/views/includes/options.inc.php';
foreach ($options as $option) {
    if (get_option($option[0]) === false) {
        add_option($option[0], $option[1], null, 'yes');
    }
}

function build_csp_value($value) {
    $csp = array();
    foreach ($value as $key => $val)
    {
        if (is_array($val))
        {
            $source = NULL;
            if (isset($val['source']))
            {
                $source = $val['source'];
                unset($val['source']);
            }
            if (!empty($val))
            {
                $val = join(" ", array_keys($val));
                if ($source)
                {
                    $val .= " " . $source;
                }
                $csp[] = sprintf("%s %s", $key, $val);
            } elseif ($source) {
                $csp[] = sprintf("%s %s", $key, $source);
            }
        } else {
            if (in_array($key, array('block-all-mixed-content', 'upgrade-insecure-requests')))
            {
                $csp[] = $key;
            }
            if (in_array($key, array('plugin-types', 'report-to')) && !empty($val))
            {
                $csp[] = sprintf("%s %s", $key, $val);
            }
        }
    }
    
    if (!$csp)
    {
        return NULL; 
    }
    
    return join('; ', $csp);
}

function get_http_headers() {
	$statuses = array();
	$unset = array();
	$headers = array();
	$append = array();
	if (get_option('hh_x_frame_options') == 1) {
		$x_frame_options_value = strtoupper(get_option('hh_x_frame_options_value'));
		if ($x_frame_options_value == 'ALLOW-FROM') {
			$x_frame_options_value .= ' ' . get_option('hh_x_frame_options_domain');
		}
		$headers['X-Frame-Options'] = $x_frame_options_value;
	}
	if (get_option('hh_x_powered_by') == 1) {
		if (get_option('hh_x_powered_by_option') == 'set') {
			$headers['X-Powered-By'] = get_option('hh_x_powered_by_value');
		} else {
			$unset[] = 'X-Powered-By';
		}
	}
	if (get_option('hh_x_xxs_protection') == 1) {
		$headers['X-XSS-Protection'] = get_option('hh_x_xxs_protection_value');
		if ($headers['X-XSS-Protection'] == '1; report=') {
			$headers['X-XSS-Protection'] .= get_option('hh_x_xxs_protection_uri');
		}
	}
	if (get_option('hh_x_content_type_options') == 1) {
		$headers['X-Content-Type-Options'] = get_option('hh_x_content_type_options_value');
	}
	if (get_option('hh_x_download_options') == 1) {
	    $headers['X-Download-Options'] = get_option('hh_x_download_options_value');
	}
	if (get_option('hh_x_permitted_cross_domain_policies') == 1) {
	    $headers['X-Permitted-Cross-Domain-Policies'] = get_option('hh_x_permitted_cross_domain_policies_value');
	}
	if (get_option('hh_x_dns_prefetch_control') == 1) {
	    $headers['X-DNS-Prefetch-Control'] = get_option('hh_x_dns_prefetch_control_value');
	}
	if (get_option('hh_connection') == 1) {
		$headers['Connection'] = get_option('hh_connection_value');
	}
	if (get_option('hh_pragma') == 1) {
		$headers['Pragma'] = get_option('hh_pragma_value');
	}
	if (get_option('hh_age') == 1) {
		$headers['Age'] = sprintf("%u", get_option('hh_age_value'));
	}
	if (get_option('hh_cache_control') == 1) {
		$hh_cache_control_value = get_option('hh_cache_control_value', array());
		$tmp = array();
		foreach ($hh_cache_control_value as $k => $v) {
			if (in_array($k, array('max-age', 's-maxage', 'stale-while-revalidate', 'stale-if-error'))) {
				if (strlen($v) > 0) {
					$tmp[] = sprintf("%s=%u", $k, $v);
				}
			} else {
				$tmp[] = $k;
			}
		}
		$hh_cache_control_value = join(', ', $tmp);
		$headers['Cache-Control'] = $hh_cache_control_value;
	}
	if (get_option('hh_strict_transport_security') == 1) {
		$hh_strict_transport_security = array();
		
		$hh_strict_transport_security_max_age = get_option('hh_strict_transport_security_max_age');
		if ($hh_strict_transport_security_max_age !== false)
		{
			$hh_strict_transport_security[] = sprintf('max-age=%u', get_option('hh_strict_transport_security_max_age'));
			if (get_option('hh_strict_transport_security_sub_domains'))
			{
				$hh_strict_transport_security[] = 'includeSubDomains';
			}
			if (get_option('hh_strict_transport_security_preload'))
			{
				$hh_strict_transport_security[] = 'preload';
			}
		} else {
			$hh_strict_transport_security = array(get_option('hh_strict_transport_security_value'));
		}
		$headers['Strict-Transport-Security'] = join('; ', $hh_strict_transport_security);
	}
	if (get_option('hh_x_ua_compatible') == 1) {
		$headers['X-UA-Compatible'] = get_option('hh_x_ua_compatible_value');
	}
	
	if (get_option('hh_content_security_policy') == 1)
	{
		$value = get_option('hh_content_security_policy_value');
		$csp = build_csp_value($value);
		if ($csp)
		{
		    $csp_report_only = get_option('hh_content_security_policy_report_only');
			$headers['Content-Security-Policy'.($csp_report_only ? '-Report-Only' : NULL)] = $csp;
		}
	}

	if (get_option('hh_access_control_allow_origin') == 1)
	{
		$value = get_option('hh_access_control_allow_origin_value');
		switch ($value)
		{
			case 'origin':
				$value = get_option('hh_access_control_allow_origin_url', array());
				if (is_scalar($value))
				{
				    $value = array($value);
				}
				break;
		}
		if (!empty($value))
		{
			$headers['Access-Control-Allow-Origin'] = $value;
		}
	}
	if (get_option('hh_access_control_allow_credentials') == 1)
	{
		$headers['Access-Control-Allow-Credentials'] = get_option('hh_access_control_allow_credentials_value');
	}
	if (get_option('hh_access_control_max_age') == 1)
	{
		$value = get_option('hh_access_control_max_age_value');
		if (!empty($value))
		{
			$headers['Access-Control-Max-Age'] = intval($value);
		}
	}
	if (get_option('hh_access_control_allow_methods') == 1)
	{
		$value = get_option('hh_access_control_allow_methods_value');
		if (!empty($value))
		{
			$headers['Access-Control-Allow-Methods'] = join(', ', array_keys($value));
		}
	}
	if (get_option('hh_access_control_allow_headers') == 1)
	{
        $tmp = array();
		$value = get_option('hh_access_control_allow_headers_value');
		if (!empty($value))
		{
            $tmp = array_merge($tmp, array_keys($value));
		}
        $custom = get_option('hh_access_control_allow_headers_custom');
        if (!empty($custom))
        {
            $tmp = array_merge($tmp, $custom);
        }
        if ($tmp)
        {
            $tmp = array_filter($tmp, 'trim');
            $tmp = array_unique($tmp);
            $headers['Access-Control-Allow-Headers'] = join(', ', $tmp);
		}
	}
	if (get_option('hh_access_control_expose_headers') == 1)
	{
	    $tmp = array();
		$value = get_option('hh_access_control_expose_headers_value');
		if (!empty($value))
		{
            $tmp = array_merge($tmp, array_keys($value));
		}
        $custom = get_option('hh_access_control_expose_headers_custom');
        if (!empty($custom))
        {
            $tmp = array_merge($tmp, $custom);
        }
        if ($tmp)
        {
            $tmp = array_filter($tmp, 'trim');
            $tmp = array_unique($tmp);
            $headers['Access-Control-Expose-Headers'] = join(', ', $tmp);
		}
	}
	if (get_option('hh_p3p') == 1)
	{
		$value = get_option('hh_p3p_value');
		if (!empty($value))
		{
			$headers['P3P'] = 'CP="' . join(' ', array_keys($value)) . '"';
		}
	}
	if (get_option('hh_referrer_policy') == 1) {
		$headers['Referrer-Policy'] = get_option('hh_referrer_policy_value');
	}
    if (get_option('hh_cross_origin_resource_policy') == 1) {
        $headers['Cross-Origin-Resource-Policy'] = get_option('hh_cross_origin_resource_policy_value');
    }
	if (get_option('hh_www_authenticate') == 1) {
	
		switch (get_option('hh_www_authenticate_type')) {
			case 'Basic':
				if (!(isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])
					&& $_SERVER['PHP_AUTH_USER'] == get_option('hh_www_authenticate_user')
					&& $_SERVER['PHP_AUTH_PW'] == get_option('hh_www_authenticate_pswd'))) {
					$headers['WWW-Authenticate'] = sprintf("Basic realm='%s'", get_option('hh_www_authenticate_realm'));
					$statuses['HTTP/1.1'] = '401 Unauthorized';
				}
				break;
			case 'Digest':
				if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
					$realm = get_option('hh_www_authenticate_realm');
					$headers['WWW-Authenticate'] = sprintf("Digest realm='%s',qop='auth',nonce='%s',opaque='%s'",
						$realm, uniqid(), md5($realm));
					$statuses['HTTP/1.1'] = '401 Unauthorized';
				}
				break;
		}
	}
	if (get_option('hh_vary') == 1)
	{
		$value = get_option('hh_vary_value');
		if (!empty($value))
		{
			$append['Vary'] = join(', ', array_keys($value));
		}
	}
	
	if (get_option('hh_expect_ct') == 1) {
		$expect_ct_max_age = get_option('hh_expect_ct_max_age');
		$expect_ct_report_uri = get_option('hh_expect_ct_report_uri');
		if (!empty($expect_ct_report_uri) && !empty($expect_ct_max_age)) {
				
			$expect_ct = array();
			$expect_ct[] = sprintf("max-age=%u", $expect_ct_max_age);
			if (get_option('hh_expect_ct_enforce') == 1) {
				$expect_ct[] = "enforce";
			}
			$expect_ct[] = sprintf('report-uri="%s"', $expect_ct_report_uri);
			$headers['Expect-CT'] = join(', ', $expect_ct);
		}
	}
	if (get_option('hh_custom_headers') == 1) {
		$custom_headers = get_option('hh_custom_headers_value');
		if (isset($custom_headers['name'], $custom_headers['value']) && !empty($custom_headers['name'])) {
			foreach ($custom_headers['name'] as $key => $name) {
				$name = trim($name);
				$value = trim($custom_headers['value'][$key]);
				if (empty($name) || empty($value)) {
					continue;
				}
				$headers[$name] = $value;
			}
		}
	}
	if (get_option('hh_report_to') == 1) {
	    $report_to = get_option('hh_report_to_value');
	    $tmp = array();
	    foreach ($report_to as $item)
	    {
	        $endpoints = array();
	        foreach ($item['endpoints'] as $endpoint)
	        {
	            $endpoints[] = sprintf('{"url": "%s"%s%s}',
	                $endpoint['url'],
	                is_numeric($endpoint['priority']) ? sprintf(', "priority": %u', $endpoint['priority']) : NULL,
	                is_numeric($endpoint['weight']) ? sprintf(', "weight": %u', $endpoint['weight']) : NULL
	            );
	        }
	        
	        $tmp[] = sprintf('{"max_age": %u%s%s, "endpoints": [%s]}',
	            $item['max_age'],
	            $item['group'] ? sprintf(', "group": "%s"', $item['group']) : NULL,
	            $item['include_subdomains'] ? sprintf(', "include_subdomains": true') : NULL,
	            join(", ", $endpoints)
	        );
	    }
	    if ($tmp)
	    {
	       $headers['Report-To'] = join(', ', $tmp);
	    }
	}
	if (get_option('hh_nel') == 1) {
	    $nel = get_option('hh_nel_value', array());
	    if ($nel)
	    {
    	    $headers['NEL'] = sprintf('{"report_to": "%s", "max_age": %u%s%s%s%s%s}',
    	        @$nel['report_to'], @$nel['max_age'],
    	        isset($nel['include_subdomains']) ? ', "include_subdomains": true' : NULL,
    	        array_key_exists('success_fraction', $nel) && is_numeric($nel['success_fraction']) ? ', "success_fraction": '. $nel['success_fraction'] : NULL,
    	        array_key_exists('failure_fraction', $nel) && is_numeric($nel['failure_fraction']) ? ', "failure_fraction": '. $nel['failure_fraction'] : NULL,
    	        isset($nel['request_headers']) && !empty($nel['request_headers']) ? sprintf(', "request_headers": ["%s"]', join('", "', array_map('trim', explode(',', $nel['request_headers'])))) : NULL,
    	        isset($nel['response_headers']) && !empty($nel['response_headers']) ? sprintf(', "response_headers": ["%s"]', join('", "', array_map('trim', explode(',', $nel['response_headers'])))) : NULL
            );
	    }
	}
	if (get_option('hh_feature_policy') == 1) {
	    $feature_policy_feature = get_option('hh_feature_policy_feature');
	    $feature_policy_value = get_option('hh_feature_policy_value');
	    $feature_policy_origin = get_option('hh_feature_policy_origin');
	    $tmp = array();
	    $feature_policy_feature = is_array($feature_policy_feature) ? $feature_policy_feature : array();
	    foreach (array_keys($feature_policy_feature) as $feature)
	    {
	        $value = NULL;
	        switch ($feature_policy_value[$feature])
	        {
	            case '*':
	            case "'none'":
    	            $value = $feature_policy_value[$feature];
    	            break;
	            case "'self'":
	                $value = $feature_policy_value[$feature];
	                if (!empty($feature_policy_origin[$feature]))
	                {
	                    $value .= " " . $feature_policy_origin[$feature];
	                }
	                break;
	            case 'origin(s)':
	                $value = $feature_policy_origin[$feature];
	                break;
	        }
	        
	        $tmp[] = sprintf("%s %s", $feature, $value);
	    }
	    if ($tmp)
	    {
	       $headers['Feature-Policy'] = join('; ', $tmp);
	    }
	}
	
	return array($headers, $statuses, $unset, $append);
}

function http_digest_parse($txt) {
	$txt = stripslashes($txt);
	
	$needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
	$data = array();
	$keys = implode('|', array_keys($needed_parts));

	preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

	foreach ($matches as $m) {
		$data[$m[1]] = $m[3] ? $m[3] : $m[4];
		unset($needed_parts[$m[1]]);
	}

	return $needed_parts ? false : $data;
}

function php_auth_digest() {
	if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) || get_option('hh_www_authenticate_user') != $data['username']) {
		die('Wrong Credentials!');
	}

	$A1 = md5($data['username'] . ':' . get_option('hh_www_authenticate_realm') . ':' . get_option('hh_www_authenticate_pswd'));
	$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
	$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);
	if ($data['response'] != $valid_response) {
		die('Wrong Credentials!');
	}
}

function php_content_encoding() {
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
		ob_start('ob_gzhandler');
	} else {
		ob_start();
	}
}

function php_cookie_security_directives() {
    $lines = array();
    if (get_option('hh_cookie_security') == 1) {
        $value = get_option('hh_cookie_security_value', array());
        if (isset($value['HttpOnly'])) {
            $lines[] = 'session.cookie_httponly = on';
        }
        if (isset($value['Secure'])) {
            $lines[] = 'session.cookie_secure = on';
        }
        if (isset($value['SameSite']) && in_array($value['SameSite'], array('None', 'Lax', 'Strict'))) {
            $lines[] = sprintf('session.cookie_samesite = "%s"', $value['SameSite']);
        }
    }
    
    return $lines;
}

function http_headers() {
	if (get_option('hh_method') !== 'php') {
		return;
	}
	// PHP method below
	list($headers, $statuses, $unset, $append) = get_http_headers();
	$isCors = false;
	foreach ($headers as $key => $value) {
	    if ($key == 'Access-Control-Allow-Origin') { 
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                if (in_array($value, array('*', 'null'))) {
                    $isCors = true;
                    header(sprintf("%s: *", $key));
                }
                
                if (is_array($value) && in_array($_SERVER['HTTP_ORIGIN'], $value)) {
                    $isCors = true;
                    header(sprintf("%s: %s", $key, $_SERVER['HTTP_ORIGIN']));
                    header("Vary: Origin", false);
                }
            }
	        continue;
	    }
	    if (in_array($key, array('Access-Control-Allow-Headers', 'Access-Control-Allow-Methods', 'Access-Control-Allow-Credentials', 'Access-Control-Max-Age', 'Access-Control-Expose-Headers'))) {
	        if ($isCors) {
	           header(sprintf("%s: %s", $key, $value));
	        }
	        continue;
	    }
		header(sprintf("%s: %s", $key, $value));
	}
	foreach ($append as $key => $value) {
		header(sprintf("%s: %s", $key, $value), false);
	}
	foreach ($unset as $header) {
		if (function_exists('header_remove')) {
			header_remove($header);
		} else {
			header("$header:");
		}
	}
	foreach ($statuses as $key => $value) {
		header(sprintf("%s %s", $key, $value));
		exit;
	}
	
	if (get_option('hh_www_authenticate') == 1) {
		php_auth_digest();
	}
	
	if (get_option('hh_content_encoding') == 1) {
		php_content_encoding();
	}
}

function http_headers_admin_add_page() {
	add_options_page('HTTP Headers', 'HTTP Headers', 'manage_options', 'http-headers', 'http_headers_admin_page');
}

function http_headers_admin() {
	register_setting('http-headers-mtd', 'hh_method');
	register_setting('http-headers-xfo', 'hh_x_frame_options');
	register_setting('http-headers-xfo', 'hh_x_frame_options_value');
	register_setting('http-headers-xfo', 'hh_x_frame_options_domain');
	register_setting('http-headers-xss', 'hh_x_xxs_protection');
	register_setting('http-headers-xss', 'hh_x_xxs_protection_value');
	register_setting('http-headers-xss', 'hh_x_xxs_protection_uri');
	register_setting('http-headers-cto', 'hh_x_content_type_options');
	register_setting('http-headers-cto', 'hh_x_content_type_options_value');
	register_setting('http-headers-sts', 'hh_strict_transport_security');
	register_setting('http-headers-sts', 'hh_strict_transport_security_value'); //obsolete
	register_setting('http-headers-sts', 'hh_strict_transport_security_max_age');
	register_setting('http-headers-sts', 'hh_strict_transport_security_sub_domains');
	register_setting('http-headers-sts', 'hh_strict_transport_security_preload');
	register_setting('http-headers-uac', 'hh_x_ua_compatible');
	register_setting('http-headers-uac', 'hh_x_ua_compatible_value');
	register_setting('http-headers-p3p', 'hh_p3p');
	register_setting('http-headers-p3p', 'hh_p3p_value');
	register_setting('http-headers-rp', 'hh_referrer_policy');
	register_setting('http-headers-rp', 'hh_referrer_policy_value');
	register_setting('http-headers-csp', 'hh_content_security_policy');
	register_setting('http-headers-csp', 'hh_content_security_policy_value');
	register_setting('http-headers-csp', 'hh_content_security_policy_report_only');
	register_setting('http-headers-acao', 'hh_access_control_allow_origin');
	register_setting('http-headers-acao', 'hh_access_control_allow_origin_value');
	register_setting('http-headers-acao', 'hh_access_control_allow_origin_url');
	register_setting('http-headers-acac', 'hh_access_control_allow_credentials');
	register_setting('http-headers-acac', 'hh_access_control_allow_credentials_value');
	register_setting('http-headers-acam', 'hh_access_control_allow_methods');
	register_setting('http-headers-acam', 'hh_access_control_allow_methods_value');
	register_setting('http-headers-acah', 'hh_access_control_allow_headers');
	register_setting('http-headers-acah', 'hh_access_control_allow_headers_value');
    register_setting('http-headers-acah', 'hh_access_control_allow_headers_custom');
	register_setting('http-headers-aceh', 'hh_access_control_expose_headers');
	register_setting('http-headers-aceh', 'hh_access_control_expose_headers_value');
    register_setting('http-headers-aceh', 'hh_access_control_expose_headers_custom');
	register_setting('http-headers-acma', 'hh_access_control_max_age');
	register_setting('http-headers-acma', 'hh_access_control_max_age_value');
	register_setting('http-headers-ce', 'hh_content_encoding');
	register_setting('http-headers-ce', 'hh_content_encoding_module');
	register_setting('http-headers-ce', 'hh_content_encoding_value');
	register_setting('http-headers-ce', 'hh_content_encoding_ext');
	register_setting('http-headers-vary', 'hh_vary');
	register_setting('http-headers-vary', 'hh_vary_value');
	register_setting('http-headers-xpb', 'hh_x_powered_by');
	register_setting('http-headers-xpb', 'hh_x_powered_by_option');
	register_setting('http-headers-xpb', 'hh_x_powered_by_value');
	register_setting('http-headers-wwa', 'hh_www_authenticate');
	register_setting('http-headers-wwa', 'hh_www_authenticate_type');
	register_setting('http-headers-wwa', 'hh_www_authenticate_realm');
	register_setting('http-headers-wwa', 'hh_www_authenticate_user');
	register_setting('http-headers-wwa', 'hh_www_authenticate_pswd');
	register_setting('http-headers-cc', 'hh_cache_control');
	register_setting('http-headers-cc', 'hh_cache_control_value');
	register_setting('http-headers-age', 'hh_age');
	register_setting('http-headers-age', 'hh_age_value');
	register_setting('http-headers-pra', 'hh_pragma');
	register_setting('http-headers-pra', 'hh_pragma_value');
	register_setting('http-headers-exp', 'hh_expires');
	register_setting('http-headers-exp', 'hh_expires_value');
	register_setting('http-headers-exp', 'hh_expires_type');
	register_setting('http-headers-con', 'hh_connection');
	register_setting('http-headers-con', 'hh_connection_value');
	register_setting('http-headers-cose', 'hh_cookie_security');
	register_setting('http-headers-cose', 'hh_cookie_security_value');
	register_setting('http-headers-ect', 'hh_expect_ct');
	register_setting('http-headers-ect', 'hh_expect_ct_max_age');
	register_setting('http-headers-ect', 'hh_expect_ct_report_uri');
	register_setting('http-headers-ect', 'hh_expect_ct_enforce');
	register_setting('http-headers-tao', 'hh_timing_allow_origin');
	register_setting('http-headers-tao', 'hh_timing_allow_origin_value');
	register_setting('http-headers-tao', 'hh_timing_allow_origin_url');
	register_setting('http-headers-che', 'hh_custom_headers');
	register_setting('http-headers-che', 'hh_custom_headers_value');
	register_setting('http-headers-xdo', 'hh_x_download_options');
	register_setting('http-headers-xdo', 'hh_x_download_options_value');
	register_setting('http-headers-xpcd', 'hh_x_permitted_cross_domain_policies');
	register_setting('http-headers-xpcd', 'hh_x_permitted_cross_domain_policies_value');
	register_setting('http-headers-xdpc', 'hh_x_dns_prefetch_control');
	register_setting('http-headers-xdpc', 'hh_x_dns_prefetch_control_value');
	register_setting('http-headers-rt', 'hh_report_to');
	register_setting('http-headers-rt', 'hh_report_to_value');
	register_setting('http-headers-fp', 'hh_feature_policy');
	register_setting('http-headers-fp', 'hh_feature_policy_value');
	register_setting('http-headers-fp', 'hh_feature_policy_feature');
	register_setting('http-headers-fp', 'hh_feature_policy_origin');
	register_setting('http-headers-csd', 'hh_clear_site_data');
	register_setting('http-headers-csd', 'hh_clear_site_data_value');
    register_setting('http-headers-cty', 'hh_content_type');
    register_setting('http-headers-cty', 'hh_content_type_value');
    register_setting('http-headers-corp', 'hh_cross_origin_resource_policy');
    register_setting('http-headers-corp', 'hh_cross_origin_resource_policy_value');
    register_setting('http-headers-nel', 'hh_nel');
    register_setting('http-headers-nel', 'hh_nel_value');
}

function http_headers_option($option) {
    
    include_once ABSPATH . 'wp-admin/includes/admin.php';
    
    if (isset($_POST['hh_method']))
    {
        check_admin_referer('http-headers-mtd-options');
        # When method is changed
        http_headers_activate();
        
    } elseif (get_option('hh_method') == 'htaccess') {
        # When particular header is changed
        switch (true) {
            case array_key_exists('hh_www_authenticate', $_POST):
                check_admin_referer('http-headers-wwa-options');
                update_auth_credentials();
                update_auth_directives();
                break;
            case array_key_exists('hh_content_encoding', $_POST):
                check_admin_referer('http-headers-ce-options');
                update_content_encoding_directives();
                break;
            case array_key_exists('hh_content_type', $_POST):
                check_admin_referer('http-headers-cty-options');
                update_content_type_directives();
                break;
            case array_key_exists('hh_expires', $_POST):
                check_admin_referer('http-headers-exp-options');
                update_expires_directives();
                break;
            case array_key_exists('hh_cookie_security', $_POST):
                check_admin_referer('http-headers-cose-options');
                update_cookie_security_directives();
                break;
            case array_key_exists('hh_timing_allow_origin', $_POST):
                check_admin_referer('http-headers-tao-options');
                update_timing_directives();
                break;
            case array_key_exists('option_page', $_POST) && strpos($_POST['option_page'], 'http-headers-') === 0:
                check_admin_referer($_POST['option_page'].'-options');
                update_headers_directives();
                break;
        }
	}
}
	
function nginx_headers_directives() {
    $lines = array();
    list($headers, $statuses, $unset, $append) = get_http_headers();
    
    foreach ($unset as $header) {
        $lines[] = sprintf('    more_clear_headers "%s";', $header);
    }
    $cors = $cors_header = $cors_inner = $cors_footer = array();
    $all = array();
    foreach ($headers as $key => $value) {
        if (in_array($key, array('WWW-Authenticate'))) {
            continue;
        }
        if (in_array($key, array('X-Content-Type-Options'))) {
            $all[] = sprintf('add_header %s %s always;', $key, sprintf('%1$s%2$s%1$s', strpos($value, '"') === false ? '"' : "'", $value));
            continue;
        }
        if ($key == 'Access-Control-Allow-Origin' && is_array($value)) {
            $cors_header[] = sprintf('if ($http_origin ~* ^(%s)$) {', str_replace('.', '\.', join('|', $value)));
            $cors_footer[] = '}';
            $cors_inner[] = '    add_header Access-Control-Allow-Origin "$http_origin";';
            if (!in_array('*', $value))
            {
                $cors_inner[] = '    add_header Vary "Origin";';
            }
            continue;
        }
        if (in_array($key, array('Access-Control-Allow-Headers', 'Access-Control-Allow-Methods', 'Access-Control-Allow-Credentials', 'Access-Control-Max-Age', 'Access-Control-Expose-Headers'))) {
            $cors_inner[] = sprintf('    add_header %s %s;', $key, sprintf('%1$s%2$s%1$s', strpos($value, '"') === false ? '"' : "'", $value));
            continue;
        }
        $lines[] = sprintf('    add_header %s %s;', $key, sprintf('%1$s%2$s%1$s', strpos($value, '"') === false ? '"' : "'", $value));
    }
    foreach ($append as $key => $value) {
        $lines[] = sprintf('    add_header %s %s;', $key, sprintf('%1$s%2$s%1$s', strpos($value, '"') === false ? '"' : "'", $value));
    }
    if (!empty($cors_inner))
    {
        $cors = array_merge(
            $cors_header,
            $cors_inner,
            $cors_footer
        );
    }
    if (!empty($lines)) {
        $lines = array_merge(
            $all,
            $cors,
            array('location ~* \.(php|html)$ {'),
            $lines,
            array('}')
        );
    }
    return $lines;
}

function nginx_content_encoding_directives() {
    $lines = array();
    if (get_option('hh_content_encoding') == 1) {
        
        $lines[] = 'gzip on;';
        
        $content_encoding_value = get_option('hh_content_encoding_value');
        if (!$content_encoding_value) {
            $content_encoding_value = array();
        }
        
        $content_encoding_ext = get_option('hh_content_encoding_ext');
        if (!$content_encoding_ext) {
            $content_encoding_ext = array();
        }
        if (!empty($content_encoding_ext)) {
            //$lines[] = sprintf('<FilesMatch "\.(%s)$">', join('|', array_keys($content_encoding_ext)));
        }
        if (!empty($content_encoding_value)) {
            $lines[] = sprintf('gzip_types %s;', join(' ', array_keys($content_encoding_value)));
        }
    }
    return $lines;
}

function nginx_content_type_directives() {
    $lines = array();
    if (get_option('hh_content_type') == 1) {
        $values = get_option('hh_content_type_value', array());
        foreach ($values as $ext => $media_type) {
            $lines[] = sprintf("%s %s;", $media_type, $ext);
        }
    }

    return $lines;
}

function nginx_expires_directives() {
    $lines = array();
    if (get_option('hh_expires') == 1) {
        
        $types = get_option('hh_expires_type', array());
        $values = get_option('hh_expires_value', array());
        
        $lines[] = 'map $sent_http_content_type $expires {';
        foreach ($types as $type => $whatever) {
            list($base, $period, $suffix) = explode('_', $values[$type]);
            if (in_array($base, array('access', 'modification'))) {
                $lines[] = $type != 'default'
                    ? sprintf('    %s %u%s;', $type, $period, $suffix[0])
                    : sprintf('    default %u%s;', $period, $suffix[0]);
            } elseif ($base == 'invalid') {
                $lines[] = $type != 'default'
                    ? sprintf('    %s 0;', $type)
                    : sprintf('    default 0;');
            }
        }
        $lines[] = '}';
        
        $lines[] = 'expires $expires;';
    }
    return $lines;
}

function nginx_timing_directives() {
    $lines = array();
    if (get_option('hh_timing_allow_origin') == 1) {
        $value = get_option('hh_timing_allow_origin_value');
        switch ($value)
        {
            case 'origin':
                $value = get_option('hh_timing_allow_origin_url');
                break;
        }
        if (!empty($value))
        {
            $lines[] = 'location ~* \.(js|css|jpe?g|png|gif|eot|otf|svg|ttf|woff2?)$ {';
            $lines[] = sprintf('    add_header Timing-Allow-Origin "%s";', $value);
            $lines[] = '}';
        }
    }
    return $lines;
}

function nginx_auth_directives() {
    $lines = array();
    if (get_option('hh_www_authenticate') == 1) {
        
        $type = get_option('hh_www_authenticate_type');
        
        $file = $type == 'Basic' ? '.hh-htpasswd' : '.hh-htdigest';
        
        $lines[] = 'location ~ ^\.hh-ht(digest|passwd)$ {';
        $lines[] = '    deny all;';
        $lines[] = '}';
        
        $lines[] = sprintf('location %s {', get_home_path());
        if ($type == 'Basic') {
            $lines[] = sprintf('    auth_basic "%s";', get_option('hh_www_authenticate_realm'));
            $lines[] = sprintf('    auth_basic_user_file %s%s;', get_home_path(), $file);
        } else {
            $lines[] = sprintf('    auth_digest "%s";', get_option('hh_www_authenticate_realm'));
            $lines[] = sprintf('    auth_digest_user_file %s%s;', get_home_path(), $file);
        }
        $lines[] = '}';
    }
    return $lines;
}

function nginx_auth_credentials() {
    return apache_auth_credentials();
}

function nginx_cookie_security_directives() {
    $lines = array();
    
    //TODO
    
    return $lines;
}

function nginx_check_requirements() {
    //TODO scheduled for v2.0.0
    return true;
}

function iis_headers_directives() {
    //TODO scheduled for v2.0.0
}

function iis_content_encoding_directives() {
    //TODO scheduled for v2.0.0
}

function iis_content_type_directives() {
    //TODO scheduled for v2.0.0
}

function iis_expires_directives() {
    //TODO scheduled for v2.0.0
}

function iis_timing_directives() {
    //TODO scheduled for v2.0.0
}

function iis_auth_directives() {
    //TODO scheduled for v2.0.0
}

function iis_auth_credentials() {
    //TODO scheduled for v2.0.0
}

function iis_cookie_security_directives() {
    //TODO scheduled for v2.0.0
}

function iis_check_requirements() {
    //TODO scheduled for v2.0.0
    return true;
}

function apache_headers_directives() {
    $lines = array();
    list($headers, $statuses, $unset, $append) = get_http_headers();
    
    foreach ($unset as $header) {
        $lines[] = sprintf('    Header always unset %s', $header);
        $lines[] = sprintf('    Header unset %s', $header);
    }
    $all = array();
    foreach ($headers as $key => $value) {
        if (in_array($key, array('WWW-Authenticate'))) {
            continue;
        }
        if (in_array($key, array('X-Content-Type-Options'))) {
            $all[] = sprintf('  Header always set %s %s', $key, sprintf('%1$s%2$s%1$s', strpos($value, '"') === false ? '"' : "'", $value));
            continue;
        }
        if ($key == 'Strict-Transport-Security') {
            $lines[] = sprintf('    Header set %s %s env=HTTPS', $key, sprintf('%1$s%2$s%1$s', strpos($value, '"') === false ? '"' : "'", $value));
            continue;
        }
        if ($key == 'Access-Control-Allow-Origin') {
            $all[] = '  <IfModule mod_setenvif.c>';
            if (!is_array($value)) {
                if ($value) {
                    $value = array($value);
                } else {
                    $value = array();
                }
            }
            //$value[] = 'null';
            if (is_array($value))
            {
                $all[] = sprintf('    SetEnvIf Origin "^(%s)$" CORS=$0', str_replace(array('.', '*'), array('\.', '.+'), join('|', $value)));
            } else {
                $all[] = '    SetEnvIf Origin "^(.+)$" CORS=$0';
            }
            $all[] = '  </IfModule>';
            $all[] = '  Header set Access-Control-Allow-Origin %{CORS}e env=CORS';
            if (!in_array('*', $value))
            {
                $all[] = '  Header append Vary "Origin" env=CORS';
            }
            continue;
        }
        if (in_array($key, array('Access-Control-Allow-Headers', 'Access-Control-Allow-Methods', 'Access-Control-Allow-Credentials', 'Access-Control-Max-Age', 'Access-Control-Expose-Headers'))) {
            $all[] = sprintf('  Header set %s %s env=CORS', $key, sprintf('%1$s%2$s%1$s', strpos($value, '"') === false ? '"' : "'", $value));
            continue;
        }
        $lines[] = sprintf('    Header set %s %s', $key, sprintf('%1$s%2$s%1$s', strpos($value, '"') === false ? '"' : "'", $value));
    }
    foreach ($append as $key => $value) {
        $lines[] = sprintf('    Header append %s %s', $key, sprintf('%1$s%2$s%1$s', strpos($value, '"') === false ? '"' : "'", $value));
    }
    if (!empty($lines) || !empty($all)) {
        $lines = array_merge(
            array('<IfModule mod_headers.c>'),
            $all,
            array('  <FilesMatch "\.(php|html)$">'),
            $lines,
            array('  </FilesMatch>', '</IfModule>')
            );
    }
    return $lines;
}

function apache_content_encoding_directives() {
    $lines = array();
    if (get_option('hh_content_encoding') == 1) {
        
        $content_encoding_module = get_option('hh_content_encoding_module');

        $module = 'mod_deflate.c';
        $filter = 'DEFLATE';
        $accept_encoding = 'gzip';

        if ($content_encoding_module == 'brotli') {
            $module = 'mod_brotli.c';
            $filter = 'BROTLI_COMPRESS';
            $accept_encoding = 'br';
        }
        
        $content_encoding_value = get_option('hh_content_encoding_value');
        if (!$content_encoding_value) {
            $content_encoding_value = array();
        }
        
        $content_encoding_ext = get_option('hh_content_encoding_ext');
        if (!$content_encoding_ext) {
            $content_encoding_ext = array();
        }

        $type = join('|', array_keys($content_encoding_value));
        $ext = join('|', array_keys($content_encoding_ext));

        if (!empty($type) && !empty($ext)) {
            $expression = sprintf('(%%{CONTENT_TYPE} =~ m#^(%1$s)# || %%{REQUEST_FILENAME} =~ /.(%2$s)$/)', $type, $ext);
        } elseif (!empty($type)) {
            $expression = sprintf('%%{CONTENT_TYPE} =~ m#^(%1$s)#', $type);
        } elseif (!empty($ext)) {
            $expression = sprintf('%%{REQUEST_FILENAME} =~ /.(%1$s)$/', $ext);
        }

        if (isset($expression)) {
            $lines[] = '<IfModule mod_filter.c>';
            $lines[] = '  FilterDeclare HttpHeaders';
            if (in_array($content_encoding_module, array('brotli', 'deflate'))) {
            $lines[] = sprintf('<IfModule %s>', $module);
                $lines[] = sprintf('    FilterProvider HttpHeaders %1$s "%%{HTTP:Accept-Encoding} =~ /%2$s/ && %3$s"', $filter, $accept_encoding, $expression);
                $lines[] = '  </IfModule>';
            } else {
                $lines[] = '  <IfModule mod_deflate.c>';
                $lines[] = '    <IfModule !mod_brotli.c>';
                $lines[] = sprintf('      FilterProvider HttpHeaders DEFLATE "%%{HTTP:Accept-Encoding} =~ /gzip/ && %1$s"', $expression);
                $lines[] = '    </IfModule>';
                $lines[] = '  </IfModule>';
                $lines[] = '  <IfModule mod_brotli.c>';
                $lines[] = sprintf('    FilterProvider HttpHeaders BROTLI_COMPRESS "%%{HTTP:Accept-Encoding} =~ /br/ && %1$s"', $expression);
                $lines[] = '  </IfModule>';
            }
            $lines[] = '  FilterChain HttpHeaders';
            $lines[] = '</IfModule>';
        }
    }
    
    return $lines;
}

function apache_expires_directives() {
    $lines = array();
    if (get_option('hh_expires') == 1) {
        
        $types = get_option('hh_expires_type', array());
        $values = get_option('hh_expires_value', array());
        
        $lines[] = '<IfModule mod_expires.c>';
        $lines[] = '  ExpiresActive On';
        foreach ($types as $type => $whatever) {
            list($base, $period, $suffix) = explode('_', $values[$type]);
            if (in_array($base, array('access', 'modification'))) {
                $lines[] = $type != 'default'
                    ? sprintf('  ExpiresByType %s "%s plus %u %s"', $type, $base, $period, $suffix)
                    : sprintf('  ExpiresDefault "%s plus %u %s"', $base, $period, $suffix);
            } elseif ($base == 'invalid') {
                $lines[] = $type != 'default'
                    ? sprintf('  ExpiresByType %s A0', $type)
                    : sprintf('  ExpiresDefault A0');
            }
        }
        $lines[] = '</IfModule>';
    }
    
    return $lines;
}

function apache_content_type_directives() {
    $lines = array();
    if (get_option('hh_content_type') == 1) {
        $values = get_option('hh_content_type_value', array());
        $lines[] = '<IfModule mod_mime.c>';
        foreach ($values as $ext => $media_type) {
            $lines[] = sprintf("  AddType %s .%s", $media_type, $ext);
        }
        $lines[] = '</IfModule>';
    }

    return $lines;
}

function apache_timing_directives() {
    $lines = array();
    if (get_option('hh_timing_allow_origin') == 1) {
        $value = get_option('hh_timing_allow_origin_value');
        switch ($value)
        {
            case 'origin':
                $value = get_option('hh_timing_allow_origin_url');
                break;
        }
        if (!empty($value))
        {
            $lines[] = '<IfModule mod_headers.c>';
            $lines[] = '  <FilesMatch "\\.(js|css|jpe?g|png|gif|eot|otf|svg|ttf|woff2?)$">';
            $lines[] = sprintf('    Header set Timing-Allow-Origin "%s"', $value);
            $lines[] = '  </FilesMatch>';
            $lines[] = '</IfModule>';
        }
    }
    
    return $lines;
}

function apache_auth_directives() {
    $lines = array();
    if (get_option('hh_www_authenticate') == 1) {
        
        $type = get_option('hh_www_authenticate_type');
        
        $file = $type == 'Basic' ? '.hh-htpasswd' : '.hh-htdigest';
        
        $lines[] = '<FilesMatch "^\.hh-ht(digest|passwd)$">';
        $lines[] = '  <IfModule mod_authz_core.c>';
        $lines[] = '    Require all denied';
        $lines[] = '  </IfModule>';
        $lines[] = '  <IfModule !mod_authz_core.c>';
        $lines[] = '    Order deny,allow';
        $lines[] = '    Deny from all';
        $lines[] = '  </IfModule>';
        $lines[] = '</FilesMatch>';
        // no empty AuthName
		$realm = get_option('hh_www_authenticate_realm'); // AuthName
		$realm = ($realm == '') ? 'restricted area':$realm; // Empty => give fixed value
        
        $lines[] = sprintf('<IfModule mod_auth_%s.c>', strtolower($type));
        $lines[] = sprintf('  AuthType %s', get_option('hh_www_authenticate_type'));
        $lines[] = sprintf('  AuthName "%s"', $realm);
        $lines[] = sprintf('  AuthUserFile "%s%s"', get_home_path(), $file);
        $lines[] = '  Require valid-user';
        $lines[] = '</IfModule>';
    }
    
    return $lines;
}

function apache_auth_credentials() {
    if (get_option('hh_www_authenticate') == 1) {
        $type = get_option('hh_www_authenticate_type');
        $usernames = get_option('hh_www_authenticate_user', array());
        $passwords = get_option('hh_www_authenticate_pswd', array());
        if (!is_array($usernames)) {
            $usernames = array($usernames);
        }
        if (!is_array($passwords)) {
            $passwords = array($passwords);
        }
        $realm = get_option('hh_www_authenticate_realm');
        $auth = array();
        switch ($type) {
            case 'Basic':
                $ht_file = get_home_path().'.hh-htpasswd';
                foreach ($usernames as $k => $user) {
                    $auth[] = sprintf('%s:{SHA}%s', $user, base64_encode(sha1($passwords[$k], true)));
                }
                break;
            case 'Digest':
                $ht_file = get_home_path().'.hh-htdigest';
                foreach ($usernames as $k => $user) {
                    $auth[] = sprintf('%s:%s:%s', $user, $realm, md5($user.':'.$realm.':'.$passwords[$k]));
                }
                break;
        }
        $auth = join("\n", $auth);
        
        return compact('ht_file', 'auth');
    }
    return false;
}

function apache_cookie_security_directives() {
    $lines = array();
    if (get_option('hh_cookie_security') == 1) {
        $value = get_option('hh_cookie_security_value', array());
        if (isset($value['HttpOnly'])) {
            $lines[] = 'php_flag session.cookie_httponly on';
        }
        if (isset($value['Secure'])) {
            $lines[] = 'php_flag session.cookie_secure on';
        }
        if (isset($value['SameSite']) && in_array($value['SameSite'], array('None', 'Lax', 'Strict'))) {
            $lines[] = sprintf('php_value session.cookie_samesite "%s"', $value['SameSite']);
        }
    }

    return $lines;
}

function apache_check_requirements() {
    return check_filename(get_home_path().'.htaccess');
}

function update_headers_directives() {
	$lines = array();
	if (get_option('hh_method') == 'htaccess') {
		$lines = apache_headers_directives();
	}
	
	return insert_with_markers(get_home_path().'.htaccess', "HttpHeaders", $lines);
}

function update_content_encoding_directives() {
	$lines = array();
	if (get_option('hh_method') == 'htaccess') {
		$lines = apache_content_encoding_directives();
	}
	
	return insert_with_markers(get_home_path().'.htaccess', "HttpHeadersCompression", $lines);
}

function update_expires_directives() {
	$lines = array();
	if (get_option('hh_method') == 'htaccess') {
	    $lines = apache_expires_directives();
	}
	
	return insert_with_markers(get_home_path().'.htaccess', "HttpHeadersExpires", $lines);
}

function update_content_type_directives() {
    $lines = array();
    if (get_option('hh_method') == 'htaccess') {
        $lines = apache_content_type_directives();
    }

    return insert_with_markers(get_home_path().'.htaccess', "HttpHeadersContentType", $lines);
}

function update_timing_directives() {
	$lines = array();
	if (get_option('hh_method') == 'htaccess') {
		$lines = apache_timing_directives();
	}
	
	return insert_with_markers(get_home_path().'.htaccess', "HttpHeadersTiming", $lines);
}

function update_auth_directives() {
	$lines = array();
	if (get_option('hh_method') == 'htaccess') {
	    $lines = apache_auth_directives();
	}
	
	return insert_with_markers(get_home_path().'.htaccess', "HttpHeadersAuth", $lines);
}

function update_auth_credentials() {
	if (get_option('hh_method') == 'htaccess') {
		$credentials = apache_auth_credentials();
		
		return @file_put_contents($credentials['ht_file'], $credentials['auth']);
	}
	
	return false;
}

function update_cookie_security_directives() {
    $lines = array();
    $is_apache = get_option('hh_method') == 'htaccess';
    $htaccess = get_home_path().'.htaccess';
    $is_cgi = strpos(PHP_SAPI, 'cgi') !== false;
    if ($is_cgi) {
        $filename = get_home_path().ini_get('user_ini.filename');
        $lines = php_cookie_security_directives();
    } elseif ($is_apache) {
        $filename = $htaccess;
        $lines = apache_cookie_security_directives();
    }
    
    if (!$is_apache) {
        insert_with_markers($htaccess, "HttpHeadersCookieSecurity", array());
    }
    
    if ($is_cgi) {
        return update_user_ini_filename($filename, "HttpHeadersCookieSecurity", $lines);
    }
    
    return insert_with_markers($filename, "HttpHeadersCookieSecurity", $lines);
}

function update_user_ini_filename($filename, $marker, $insertion) {
    if (!is_array($insertion)) {
        $insertion = explode("\n", $insertion);
    }
    
    $start_marker = "; BEGIN " . $marker;
    $end_marker   = "; END " . $marker;
    
    $data = "";
    if (is_file($filename)) {
        $data = @file_get_contents($filename);
    }
    
    $string = $start_marker;
    if ($insertion)
    {
        $string .= "\n".join("\n", $insertion);
    }
    $string .= "\n".$end_marker;
    
    $pattern = '/'.$start_marker.'.*'.$end_marker.'/isU';
    
    if (preg_match($pattern, $data)) {
        $data = preg_replace($pattern, $string, $data);
    } else {
        $data .= "\n".$string;
    }
    
    $bytes = @file_put_contents($filename, $data, LOCK_EX);
    
    return !!$bytes;
}

function is_samesite_supported() {
    return version_compare(PHP_VERSION, '7.3.0', '>=');
}

function http_headers_text_domain() {
    load_plugin_textdomain('http-headers', false, basename( dirname( __FILE__ ) ) . '/languages/');
}

function http_headers_settings_link( $links ) {
	$url = get_admin_url() . 'options-general.php?page=http-headers';
	$settings_link = '<a href="' . $url . '">' . __('Settings', 'http-headers') . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}

function http_headers_after_setup_theme() {
	add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'http_headers_settings_link');
}

function http_headers_enqueue($hook) {
    if ( 'http-headers.php' != $hook ) {
    	# FIXME
        //return;
    }

    wp_enqueue_script('http_headers_admin_scripts', plugin_dir_url( __FILE__ ) . 'assets/scripts.js', array(), '1.16.1', true);
    wp_localize_script('http_headers_admin_scripts', 'hh', array(
        'lbl_delete' => __('Delete', 'http-headers'),
        'lbl_value' => __('Value', 'http-headers'),
        'lbl_remove_endpoint' => __('Remove endpoint', 'http-headers'),
        'lbl_remove_group' => __('Remove group', 'http-headers'),
    ));
    wp_enqueue_style('http_headers_admin_styles', plugin_dir_url( __FILE__ ) . 'assets/styles.css', array(), '1.16.1');
}

function http_headers_ajax_inspect() {
    check_ajax_referer('inspect');
    if (current_user_can('manage_options')) {
        include 'views/ajax-inspect.php';
    }
    wp_die();
}

function http_headers_post_import() {
    check_admin_referer('import');
    global $wpdb;
    if (!(isset($_FILES['file']['tmp_name'])
        && is_uploaded_file($_FILES['file']['tmp_name'])
        && $_FILES['file']['error'] == UPLOAD_ERR_OK
    )) {
        wp_redirect(sprintf("%soptions-general.php?page=http-headers&tab=advanced&status=ERR&code=100", get_admin_url()));
        exit;
    }
    
    $string = @file_get_contents($_FILES['file']['tmp_name']);
    if ($string === false) {
        wp_redirect(sprintf("%soptions-general.php?page=http-headers&tab=advanced&status=ERR&code=101", get_admin_url()));
        exit;
    }
    
    $arr = preg_split('/;(\s+)?\n/', $string);
    foreach ($arr as $statement) {
        $statement = preg_replace("/(INSERT\s*INTO\s*)[\w\_]+options/", '${1}'.$wpdb->options, $statement);
        $wpdb->query($statement);
    }
    
    wp_redirect(sprintf("%soptions-general.php?page=http-headers&tab=advanced&status=OK", get_admin_url()));
    exit;
}

function http_headers_post_export() {
    check_admin_referer('export');
    global $wpdb;
    $options = include dirname(__FILE__) . '/views/includes/options.inc.php';
    $opts = array();
    foreach ($options as $option)
    {
        $opts[] = $option[0];
    }
    $statement = sprintf("SELECT * FROM %s WHERE option_name IN ('%s');", $wpdb->options, join("','", $opts));
    $results = $wpdb->get_results($statement, ARRAY_A);
    $sql = array();
    
    $indexes = array();
    foreach ($options as $option)
    {
        foreach ($results as $item)
        {
            if ($item['option_name'] == $option[0])
            {
                $indexes[$option[0]] = 1;
                
                $value = str_replace("'", "''", $item['option_value']);
                $query = array();
                $query[] = sprintf("INSERT INTO %s (option_id, option_name, option_value, autoload)", $wpdb->options);
                $query[] = sprintf("VALUES (NULL, '%s', '%s', '%s')", $item['option_name'], $value, $item['autoload']);
                $query[] = sprintf("ON DUPLICATE KEY UPDATE option_value = '%s', autoload = '%s';", $value, $item['autoload']);
                $sql[] = join("\n", $query);
                break;
            }
        }
        
        if (!isset($indexes[$option[0]]))
        {
            $query = array();
            $query[] = sprintf("INSERT INTO %s (option_id, option_name, option_value, autoload)", $wpdb->options);
            $query[] = sprintf("VALUES (NULL, '%s', '%s', 'yes')", $option[0], $option[1]);
            $query[] = sprintf("ON DUPLICATE KEY UPDATE option_value = '%s', autoload = 'yes';", $option[1]);
            $sql[] = join("\n", $query);
        }
    }
    
    $sql = join("\n\n", $sql);
    $length = function_exists('mb_strlen') ? mb_strlen($sql) : strlen($sql);
    $name = sprintf('WP-HTTP-Headers-%u.sql', time());
    
    # Send headers
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false);
    header('Content-Transfer-Encoding: binary');
    header('Content-Disposition: attachment; filename="'.$name.'";');
    header('Content-Type: application/sql');
    header('Content-Length: ' . $length);
    
    echo $sql;
    exit;
}

function check_filename($filename) {
    if (!is_file($filename)) {
        return -1;
    }
    
    clearstatcache();
    if (!is_writable($filename)) {
        return -2;
    }
    
    return true;
}

function check_webserver_requirements() {
    $method = get_option('hh_method');
    if ($method == 'htaccess') {
        return apache_check_requirements();
    }
    
    return true;
}

function check_php_requirements() {
    if (strpos(PHP_SAPI, 'cgi') !== false) {
        // cgi, cgi-fcgi, fpm-fcgi
        return check_filename(get_home_path().ini_get('user_ini.filename'));
    }
    
    return true;
}

function http_headers_logout() {
    if (get_option('hh_clear_site_data') == 1) {
        $values = get_option('hh_clear_site_data_value', array());
        $tmp = array_keys($values);
        if ($tmp) {
            header(sprintf('Clear-Site-Data: "%s"', join('", "', $tmp)));
        }
    }
}

function http_headers_activate() {
    update_headers_directives();
    update_auth_credentials();
    update_auth_directives();
    update_content_encoding_directives();
    update_content_type_directives();
    update_expires_directives();
    update_cookie_security_directives();
    update_timing_directives();
}

function http_headers_deactivate() {
    $filename = get_home_path().'.htaccess';
    
    insert_with_markers($filename, "HttpHeaders", array());
    insert_with_markers($filename, "HttpHeadersCompression", array());
    insert_with_markers($filename, "HttpHeadersContentType", array());
    insert_with_markers($filename, "HttpHeadersExpires", array());
    insert_with_markers($filename, "HttpHeadersTiming", array());
    insert_with_markers($filename, "HttpHeadersAuth", array());
    insert_with_markers($filename, "HttpHeadersCookieSecurity", array());
}

register_activation_hook(__FILE__, 'http_headers_activate');
register_deactivation_hook(__FILE__, 'http_headers_deactivate');
add_action('wp_logout', 'http_headers_logout');

if ( is_admin() ){ // admin actions
    add_action('admin_menu', 'http_headers_admin_add_page');
	add_action('admin_init', 'http_headers_admin');
	add_action("added_option", 'http_headers_option');
	add_action("updated_option", 'http_headers_option');
	add_action('admin_enqueue_scripts', 'http_headers_enqueue');
	add_action('after_setup_theme', 'http_headers_after_setup_theme');
	add_action('plugins_loaded', 'http_headers_text_domain');
	add_action('wp_ajax_inspect', 'http_headers_ajax_inspect');
	add_action('admin_post_import', 'http_headers_post_import');
	add_action('admin_post_export', 'http_headers_post_export');
} else {
  // non-admin enqueues, actions, and filters
	add_action('send_headers', 'http_headers');
}

function http_headers_admin_page() {
	include 'views/index.php';
}