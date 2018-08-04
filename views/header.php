<?php 
if (!defined('ABSPATH')) {
    exit;
}
include dirname(__FILE__) . '/includes/config.inc.php';
include dirname(__FILE__) . '/includes/breadcrumbs.inc.php';
?>

<section class="hh-panel">
	<form method="post" action="options.php">
	    <table class="form-table hh-table">
			<tbody>
			<?php
			$header_file = sprintf('%s/%s.php', dirname(__FILE__), basename($_GET['header']));
			if (is_file($header_file))
			{
				include $header_file;
			}
			?>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
</section>