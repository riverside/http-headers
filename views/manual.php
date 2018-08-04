<?php 
if (!defined('ABSPATH')) {
    exit;
}
include dirname(__FILE__) . '/includes/breadcrumbs.inc.php';
?>
<div class="hh-tabs">
	<ul>
		<li class="hh-active"><a href="#hh-tab-1">Apache</a></li>
		<li><a href="#hh-tab-2">Nginx</a></li>
	</ul>
	<div id="hh-tab-1" class="hh-tab-active">
		<h3><span class="hh-highlight"><?php echo get_home_path().'.htaccess'; ?></span></h3>
		<textarea class="hh-textarea-manual" rows="20" readonly><?php 
	$lines = apache_headers_directives();
	if ($lines)
	{
	    echo join("\n", $lines);
	    echo "\n\n";
	}
	
	$lines = apache_auth_directives();
	if ($lines)
	{
	   echo join("\n", $lines);
	   echo "\n\n";
	}
	
	$lines = apache_content_encoding_directives();
	if ($lines)
	{
	    echo join("\n", $lines);
	    echo "\n\n";
	}
	
	$lines = apache_expires_directives();
	if ($lines)
	{
	    echo join("\n", $lines);
	    echo "\n\n";
	}
	
	$lines = apache_cookie_security_directives();
	if ($lines)
	{
	    echo join("\n", $lines);
	    echo "\n\n";
	}
	
	$lines = apache_timing_directives();
	echo join("\n", $lines);
	?></textarea>
	<?php 
	$credentials = apache_auth_credentials();
	if ($credentials)
	{
	    ?>
	    <h3><span class="hh-highlight"><?php echo $credentials['ht_file']; ?></span></h3>
	    <textarea class="hh-textarea-manual" rows="5" readonly><?php 
	    echo $credentials['auth'];
	    ?></textarea><?php
	}
	?>
	</div>
	<div id="hh-tab-2" class="hh-hidden">
		<textarea class="hh-textarea-manual" rows="20" readonly><?php 
		$lines = nginx_headers_directives();
		if ($lines)
		{
		    echo join("\n", $lines);
		    echo "\n\n";
		}
		
		$lines = nginx_auth_directives();
		if ($lines)
		{
		    echo join("\n", $lines);
		    echo "\n\n";
		}
		
		$lines = nginx_content_encoding_directives();
		if ($lines)
		{
		    echo join("\n", $lines);
		    echo "\n\n";
		}
		
		$lines = nginx_expires_directives();
		if ($lines)
		{
		    echo join("\n", $lines);
		    echo "\n\n";
		}
		
		$lines = nginx_cookie_security_directives();
		if ($lines)
		{
		    echo join("\n", $lines);
		    echo "\n\n";
		}
		
		$lines = nginx_timing_directives();
		if ($lines)
		{
		    echo join("\n", $lines);
		    echo "\n\n";
		}
		?></textarea>
		<?php 
		$credentials = nginx_auth_credentials();
    	if ($credentials)
    	{
    	    ?>
    	    <h3><span class="hh-highlight"><?php echo $credentials['ht_file']; ?></span></h3>
    	    <textarea class="hh-textarea-manual" rows="5" readonly><?php 
    	    echo $credentials['auth'];
    	    ?></textarea><?php
    	}
    	?>
	</div>
</div>