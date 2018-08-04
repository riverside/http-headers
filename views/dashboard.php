<?php 
if (!defined('ABSPATH')) {
    exit;
}
include dirname(__FILE__) . '/includes/config.inc.php';
?>
<div class="hh-wrapper">
	<div class="hh-categories">
	<?php
	$tmp = array();
	foreach ($headers as $item)
	{
		if (!isset($tmp[$item[2]]))
		{
			$tmp[$item[2]] = array('total' => 0, 'on' => 0);
		}
		$tmp[$item[2]]['total'] += 1;
		if (get_option($item[1]) == 1)
		{
			$tmp[$item[2]]['on'] += 1;
		}
	}
	foreach ($categories as $key => $val)
	{
		?>
		<a href="<?php echo get_admin_url(); ?>options-general.php?page=http-headers&amp;category=<?php echo $key; ?>" class="hh-category">
			<i></i>
    		<span><?php echo $key[0]; ?></span>
			<strong><?php echo $val; ?></strong>(<?php printf('%u/%u', @$tmp[$key]['on'], @$tmp[$key]['total']); ?>)</a>
		<?php 
	}
	?>
    </div>

	<div class="hh-sidebar">
		<div class="hh-sidebar-inner">
			<h3><?php _e('Rate us', 'http-headers'); ?></h3>
			<p><?php _e('Tell us what you think about this plugin', 'http-headers'); ?> <a href="https://wordpress.org/support/plugin/http-headers/reviews/?rate=5#new-post"><?php _e('writing a review', 'http-headers'); ?></a>.</p>
			<h3><?php _e('Contribution', 'http-headers'); ?></h3>
			<p><?php _e('Help us to continue developing this plugin with a small donation.', 'http-headers'); ?></p>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
            	<input type="hidden" name="cmd" value="_xclick">
            	<input type="hidden" name="business" value="biggie@abv.bg">
            	<input type="hidden" name="item_name" value="HTTP Headers Donation">
            	<input type="hidden" name="no_shipping" value="1">
            	<input type="hidden" name="lc" value="US">
            	<input type="hidden" name="currency_code" value="USD">
            	<input type="hidden" name="item_number" value="">
            	$ <input type="text" name="amount" value="5" size="3">
            	<button type="submit" class="button"><?php _e('Donate', 'http-headers'); ?></button>
            </form>
		</div>
	</div>
</div>