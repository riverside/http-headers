<?php
if (!(isset($_POST['url']) && preg_match('|^https?://|', $_POST['url'])))
{
	?>
	<section class="hh-panel">
		<h3><span class="hh-highlight"><?php _e('URL malformed', 'http-headers'); ?></span></h3>
	</section>
	<?php
	exit;
}

include 'includes/config.inc.php';

$args = array();

if (isset($_POST['authentication'], $_POST['username'], $_POST['password'])
	&& !empty($_POST['username'])
	&& !empty($_POST['password'])
)
{
    $args['headers'] = array(
        'Authorization' => sprintf('Basic %s', base64_encode($_POST['username'] .':'. $_POST['password']))
    );
}

$response = wp_remote_head($_POST['url'], $args);
$status = wp_remote_retrieve_response_code($response);
$dictionary = wp_remote_retrieve_headers($response);
$responseHeaders = $dictionary ? $dictionary->getAll() : array();

if ($status !== 200)
{
	?>
	<section class="hh-panel">
		<h3><span class="hh-highlight"><?php _e('HTTP Status', 'http-headers'); ?>: <?php echo $status; ?></span></h3>
		<p><?php 
		switch ($status)
		{
			case 400:
				echo 'Bad Request';
				break;
			case 401:
				echo 'Unauthorized';
				break;
			case 403:
				echo 'Forbidden';
				break;
			case 404:
				echo 'Not Found';
				break;
			case 405:
				echo 'Method Not Allowed';
				break;
			default:
		}
		?></p>
	</section>
	<?php
	exit;
}
?>
<section class="hh-panel">
	<h3><span class="hh-highlight"><?php _e('Response headers', 'http-headers'); ?></span></h3>
	<table class="hh-results">
		<thead>
			<tr>
				<th style="width: 30%"><?php _e('Header', 'http-headers'); ?></th>
				<th><?php _e('Value', 'http-headers'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$reportOnly = array('content-security-policy-report-only');
		foreach ($responseHeaders as $k => $v)
		{
			$k = strtolower($k);
			$found = in_array($k, $reportOnly);
			?>
			<tr<?php echo array_key_exists($k, $headers) || $found ? ' class="hh-found"' : NULL; ?>>
				<td><?php echo htmlspecialchars($k); ?></td>
				<td><?php echo htmlspecialchars($v); ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
</section>
<?php
$special = array('content-security-policy');
$exclude = array('custom-headers', 'cookie-security', 'x-powered-by');
$missing = array();
foreach ($headers as $k => $v)
{
	if (!array_key_exists($k, $responseHeaders)
	    && !in_array($k, $exclude)
	    && !(in_array($k, $special) && array_key_exists($k . '-report-only', $responseHeaders) ))
	{
		$missing[$k] = @$categories[$v[2]];
	}
}

if (!empty($missing))
{
	asort($missing);
	?>
	<section class="hh-panel">
		<h3><span class="hh-highlight"><?php _e('Missing headers', 'http-headers'); ?></span></h3>
		<table class="hh-results">
			<thead>
				<tr>
					<th style="width: 30%"><?php _e('Header', 'http-headers'); ?></th>
					<th><?php _e('Category', 'http-headers'); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ($missing as $k => $v)
			{
				?>
				<tr>
					<td><a href="<?php echo get_admin_url(); ?>options-general.php?page=http-headers&amp;header=<?php echo htmlspecialchars($k); ?>"><?php echo $k; ?></a></td>
					<td><?php echo $v; ?></td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
	</section>
	<?php
}