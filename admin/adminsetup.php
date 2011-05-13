<?php
function tradetracker_store_setup() {

	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	$file = WP_PLUGIN_DIR . '/tradetracker-store/store.css';
	$file_directory = dirname($file);
	if(is_writable($file_directory)){
	} else {
		echo "<div class=\"updated\"><p><strong>Please make sure the directory ".$file_directory."/ is writable.</strong></p></div>";
	}	
	global $wpdb;
	$pro_table_prefix=$wpdb->prefix.'tradetracker_';
	$table = PRO_TABLE_PREFIX."store";
	if (get_option(pricedecimal) != "10,2"){
	$result=$wpdb->query("ALTER TABLE `".$table."` CHANGE `price` `price` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00' ");
		update_option( pricedecimal, "10,2" );
	}
	if (get_option(tradetracker_store_productid) != "1"){
	$result=$wpdb->query("ALTER TABLE `".$table."` CHANGE `productID` `productID` VARCHAR( 25 ) NOT NULL DEFAULT '0' ");
		update_option( tradetracker_store_productid, "1" );
		global $wpdb;
		$Tradetracker_xml = get_option( Tradetracker_xml );
		if ($Tradetracker_xml == null) 
		{
			
		} else {
		$context = stream_context_create(array(
    	'http' => array(
	        'timeout' => 3      // Timeout in seconds
    	)
		));
		$cache_time = 1; // 24 hours
		$cache_file = WP_PLUGIN_DIR . '/tradetracker-store/cache.xml';
		$timedif = @(time() - filemtime($cache_file));
		if (file_exists($cache_file) && $timedif < $cache_time) 
		{
			if ('' == file_get_contents($cache_file))
				{
		     			$string = file_get_contents(''.$Tradetracker_xml.'', 0, $context);
		    			if ($f = @fopen($cache_file, 'w')) {
        					fwrite ($f, $string, strlen($string));
        					fclose($f);
    					}
					fill_database();
				}  

		} else {
    			$string = file_get_contents(''.$Tradetracker_xml.'', 0, $context);
    			if ($f = @fopen($cache_file, 'w')) {
        			fwrite ($f, $string, strlen($string));
        			fclose($f);
    			}
			fill_database();
		}
	}
	}
	// variables for the field and option names 
	$hidden_field_name = 'mt_submit_hidden';

	$Tradetracker_settings_name = 'Tradetracker_settings';
	$Tradetracker_settings_field_name = 'Tradetracker_settings';

	// Read in existing option value from database
	$Tradetracker_settings_val = get_option( $Tradetracker_settings_name );

	// See if the user has posted us some information
	// If they did, this hidden field will be set to 'Y'
	if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
		// Read their posted value

		$Tradetracker_settings_val = $_POST[ $Tradetracker_settings_field_name ];
       		// Save the posted value in the database

		if ( get_option(Tradetracker_settings)  != $Tradetracker_settings_val) {
			update_option( $Tradetracker_settings_name, $Tradetracker_settings_val );
		}

		// Put an settings updated message on the screen

?>
		<div class="updated"><p><strong><?php _e('settings saved.', 'menu-test' ); ?></strong></p></div>
<?php

	}

	// Now display the settings editing screen
	echo '<div class="wrap">';
	$file = WP_PLUGIN_DIR . '/tradetracker-store/store.css';
	$file_directory = dirname($file);
	if(is_writable($file_directory)){
	} else {
		echo "<div class=\"updated\"><p><strong>Please make sure the directory ".$file_directory."/ is writable.</strong></p></div>";
	}



	// header
	echo "<h2>" . __( 'Tradetracker Store Setup', 'menu-test' ) . "</h2>";
	// settings form

?>
<style type="text/css" media="screen">
.info {
		border-bottom: 1px dotted #666;
		cursor: help;
	}

</style>
	<?php if ($Tradetracker_settings_val==1 || empty($Tradetracker_settings_val)){ ?>
<ul class="tabset_tabs">
   <li><a href="admin.php?page=tradetracker-shop#tab1" class="active">Setup</a></li>
   <li><a href="admin.php?page=tradetracker-shop-settings#tab2">Settings</a></li>
   <li><a href="admin.php?page=tradetracker-shop-items#tab3">Items</a></li>
   <li><a href="admin.php?page=tradetracker-shop-overview#tab4">Overview</a></li>
   <li><a href="admin.php?page=tradetracker-shop-feedback#tab5">Feedback</a></li>
   <li><a href="admin.php?page=tradetracker-shop-help#tab6" class="redhelp">Help</a></li>
</ul>
	<?php } if ($Tradetracker_settings_val==2){ ?>
<ul class="tabset_tabs">
   <li><a href="admin.php?page=tradetracker-shop#tab1" class="active">Setup</a></li>
   <li><a href="admin.php?page=tradetracker-shop-settings#tab2">Settings</a></li>
		<?php if ( get_option( Tradetracker_statsdash ) == 1 ) { ?>
   <li><a href="admin.php?page=tradetracker-shop-stats#tab3">Stats</a></li>
		<?php } ?>
   <li><a href="admin.php?page=tradetracker-shop-layout#tab4">Layout</a></li>
   <li><a href="admin.php?page=tradetracker-shop-multi#tab5">Store</a></li>
   <li><a href="admin.php?page=tradetracker-shop-multiitems#tab6">Items</a></li>
   <li><a href="admin.php?page=tradetracker-shop-overview#tab7">Overview</a></li>
   <li><a href="admin.php?page=tradetracker-shop-feedback#tab8">Feedback</a></li>
   <li><a href="admin.php?page=tradetracker-shop-help#tab9" class="redhelp">Help</a></li>

</ul>
	<?php } ?>
	<div id="sideblock" style="float:right;width:200px;margin-left:10px;border:1px;position:relative;border-color:#000000;border-style:solid;"> 
		<iframe width=200 height=800 frameborder="0" src="http://debestekleurplaten.nl/tradetracker-store/news.php"></iframe>
 	</div>
<div id="tab1" class="tabset_content">
   <h2 class="tabset_label">Setup</h2>


<form name="form1" method="post" action="">
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
	<table>
		<tr>
			<td>
				<label for="tradetrackerxml" title="Choose the basic settings when you only want the basic settings, With advanced you have a lot more you can configure." class="info">
					<?php _e("Settings:", 'tradetracker-xml' ); ?>
				</label> 
			</td>
			<td>	<input type="radio" name="Tradetracker_settings" value="1" <?php if($Tradetracker_settings_val=="1"){ echo "checked"; } ?> />

			</td>
			<td>
				Basic (Input XML file, Select which items or how many items you would like to show)
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<input type="radio" name="Tradetracker_settings" value="2" <?php if($Tradetracker_settings_val=="2"){ echo "checked"; } ?> />
			</td>
			<td>
				Advanced (Same as Basic + stats, multistore support and layout adjustments)
			</td>
		</tr>
	</table>
	<hr />
	
	<p class="submit">
	<b>Always save changes before pressing next.</b><br>
		<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" /> 
		<INPUT type="button" name="Next" value="<?php esc_attr_e('Next') ?>" onclick="location.href='admin.php?page=tradetracker-shop-settings'">
		<INPUT type="button" name="Help" value="<?php esc_attr_e('Help') ?>" onclick="location.href='admin.php?page=tradetracker-shop-help'">

	</p>

</form>
</div>
</div>


<?php
}
?>