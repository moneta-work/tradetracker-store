<?php
function tradetracker_store_multi() {
	if (!current_user_can('manage_options'))
	{
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
global $wpdb;
$pro_table_prefix=$wpdb->prefix.'tradetracker_';
$tablemulti = PRO_TABLE_PREFIX."multi";
define('PRO_TABLE_PREFIX', $pro_table_prefix);
    $structuremulti = "CREATE TABLE IF NOT EXISTS $tablemulti (
        id INT(9) NOT NULL AUTO_INCREMENT,
	multiname VARCHAR(100) NOT NULL,
	multilayout INT(10) NOT NULL,
        multiitems VARCHAR(10000) NOT NULL,
        multiamount int(3) NOT NULL,
	multilightbox VARCHAR(1) NOT NULL,
	UNIQUE KEY id (id)
    );";
    $wpdb->query($structuremulti);

	$hidden_field_name = 'mt_submit_hidden';

	if (!empty($_GET['multiid']) || !empty($_POST['multiid'])){
		if(!empty($_GET['multiid'])){
			$multiid = $_GET['multiid'];
		} 
		if(!empty($_POST['multiid'])){
			$multiid = $_POST['multiid'];
		} 
		$multi=$wpdb->get_results("SELECT multiname, multilayout, multiitems, multiamount, multilightbox FROM ".$tablemulti." where id=".$multiid."");
		foreach ($multi as $multi_val){
			
			$Tradetracker_multiname_val = $multi_val->multiname;
			$db_multiname_val = $multi_val->multiname;
			$Tradetracker_multilayout_val = $multi_val->multilayout;
			$db_multilayout_val = $multi_val->multilayout;
			$Tradetracker_multiitems_val = $multi_val->multiitems;
			$db_multiitems_val = $multi_val->multiitems;
			$Tradetracker_multiamount_val = $multi_val->multiamount;
			$db_multiamount_val = $multi_val->multiamount;
			$Tradetracker_multilightbox_val = $multi_val->multilightbox;
			$db_multilightbox_val = $multi_val->multilightbox;
		}

	}
	$Tradetracker_multiname_name = 'Tradetracker_multiname';
	$Tradetracker_multiname_field_name = 'Tradetracker_multiname';

	$Tradetracker_multilayout_name = 'Tradetracker_multilayout';
	$Tradetracker_multilayout_field_name = 'Tradetracker_multilayout';

	$Tradetracker_multiitems_name = 'Tradetracker_multiitems';
	$Tradetracker_multiitems_field_name = 'Tradetracker_multiitems';

	$Tradetracker_multiamount_name = 'Tradetracker_multiamount';
	$Tradetracker_multiamount_field_name = 'Tradetracker_multiamount';

	$Tradetracker_multilightbox_name = 'Tradetracker_multilightbox';
	$Tradetracker_multilightbox_field_name = 'Tradetracker_multilightbox';


	if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value

        	$Tradetracker_multiname_val = $_POST[ $Tradetracker_multiname_field_name ];
        	$Tradetracker_multilayout_val = $_POST[ $Tradetracker_multilayout_field_name ];
		$Tradetracker_multiamount_val = $_POST[ $Tradetracker_multiamount_field_name ];
		$Tradetracker_multiitems_val = $_POST[ $Tradetracker_multiitems_field_name ];
		$Tradetracker_multilightbox_val = $_POST[ $Tradetracker_multilightbox_field_name ];
		$Tradetracker_multiid_val = $_GET['multiid'];

        // Save the posted value in the database
		if(!empty($_POST['multiid'])) {
 		if ( $db_multiname_val  != $Tradetracker_multiname_val) {
			$query = $wpdb->update( $tablemulti, array( 'multiname' => $Tradetracker_multiname_val), array( 'id' => $_POST['multiid']), array( '%s'), array( '%s'), array( '%d' ) );
  		}
 		if ( $db_multilayout_val  != $Tradetracker_multilayout_val) {
			$query = $wpdb->update( $tablemulti, array( 'multilayout' => $Tradetracker_multilayout_val), array( 'id' => $_POST['multiid']), array( '%s'), array( '%s'), array( '%d' ) );
  		}
		if ( $db_multiamount_val  != $Tradetracker_multiamount_val) {
			$query = $wpdb->update( $tablemulti, array( 'multiamount' => $Tradetracker_multiamount_val), array( 'id' => $_POST['multiid']), array( '%s'), array( '%s'), array( '%d' ) );
		}
		if ( $db_multiitems_val  != $Tradetracker_multiitems_val) {
			$query = $wpdb->update( $tablemulti, array( 'multiitems' => $Tradetracker_multiitems_val), array( 'id' => $_POST['multiid']), array( '%s'), array( '%s'), array( '%d' ) );
  		}	
 		if ( $db_multilightbox_val  != $Tradetracker_multilightbox_val) {
			$query = $wpdb->update( $tablemulti, array( 'multilightbox' => $Tradetracker_multilightbox_val), array( 'id' => $_POST['multiid']), array( '%s'), array( '%s'), array( '%d' ) );
 		}
		$Tradetracker_multiid_val = $_POST['multiid'];
		} else {
        		$currentpage["multiname"]=$Tradetracker_multiname_val;
        		$currentpage["multilayout"]=$Tradetracker_multilayout_val;
        		$currentpage["multiamount"]=$Tradetracker_multiamount_val;
        		$currentpage["multiitems"]=$Tradetracker_multiitems_val;
        		$currentpage["multilightbox"]=$Tradetracker_multilightbox_val;
			$wpdb->insert( $tablemulti, $currentpage);
			$Tradetracker_multiid_val = $wpdb->insert_id;
		}
        // Put an settings updated message on the screen
?>
	<div class="updated"><p><strong><?php _e('settings saved.', 'menu-test' ); ?></strong></p></div>
<?php

	}
	if (get_option(Tradetracker_settings)==2){
		echo "<a href=\"admin.php?page=tradetracker-shop\">Setup</a> 
			> 
			<a href=\"admin.php?page=tradetracker-shop-settings\">Settings</a>";
		if ( get_option( Tradetracker_statsdash ) == 1 ) {
		echo " >
			<a href=\"admin.php?page=tradetracker-shop-stats\">Statistics</a>";
		}
		echo " >
			<a href=\"admin.php?page=tradetracker-shop-layout\">Layout</a>
			>
			<b><a href=\"admin.php?page=tradetracker-shop-multi\">Store Settings</a></b>
			>
			<a href=\"admin.php?page=tradetracker-shop-multiitems\">Item Selection</a>
			>
			<a href=\"admin.php?page=tradetracker-shop-overview\">Overview</a>
			>
			<a href=\"admin.php?page=tradetracker-shop-feedback\">Feedback</a>";
	}

?>
<style type="text/css" media="screen">
.info {
		border-bottom: 1px dotted #666;
		cursor: help;
	}

</style>
<div class="wrap">

<?php 	echo "<h2>" . __( 'Tradetracker Multi Store Settings', 'menu-test' ) . "</h2>"; ?>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<?php if(!empty($multiid)){ ?>
<input type="hidden" name="multiid" value="<?php echo $multiid; ?>">
<?php } ?>
<table>
	<tr>
		<td>
			<label for="tradetrackername" title="Fill in the name for the store." class="info">
				<?php _e("Name for Store:", 'tradetracker-storename' ); ?>
			</label> 
		</td>
		<td>
			<input type="text" name="<?php echo $Tradetracker_multiname_field_name; ?>" value="<?php echo $Tradetracker_multiname_val; ?>" size="20">
		</td>
	</tr>
	<tr>
		<td>
			<label for="tradetrackerwidth" title="Which layout would you like to use." class="info">
				<?php _e("Layout:", 'tradetracker-multilayout' ); ?>
			</label> 
		</td>
		<td>
			<select name="<?php echo $Tradetracker_multilayout_field_name; ?>">
<?php
		$tablelayout = PRO_TABLE_PREFIX."layout";
		$layout=$wpdb->get_results("SELECT id, layname FROM ".$tablelayout."");
		foreach ($layout as $layout_val){
			if($layout_val->id == $db_multilayout_val) {
				echo "<option selected=\"selected\" value=\"".$layout_val->id."\">$layout_val->layname</option>";
			} else {
				echo "<option value=\"".$layout_val->id."\">$layout_val->layname</option>";
			}
		}
?>
			</select>		
		</td>
	</tr>

	<tr>
		<td>
			<label for="tradetrackerfont" title="How much items would you like to show." class="info">
				<?php _e("Amount of items:", 'tradetracker-amount' ); ?> 
			</label> 
		</td>
		<td>
			<input type="text" name="<?php echo $Tradetracker_multiamount_field_name; ?>" value="<?php echo $Tradetracker_multiamount_val; ?>" size="7">
		</td>
	</tr>

	<tr>
		<td>
			<label for="tradetrackeritems" title="Current selected items." class="info">
				<?php _e("Selected items:", 'tradetracker-items' ); ?> 
			</label> 
		</td>
		<td>
			<input type="text" name="<?php echo $Tradetracker_multiitems_field_name; ?>" value="<?php echo $Tradetracker_multiitems_val; ?>" size="50"> 
		</td>
	</tr>

	<tr>
		<td>
			<label for="tradetrackerlightbox" title="Do you want to use lightbox for the images? You will need an extra plugin for that" class="info">
				<?php _e("Use Lightbox:", 'tradetracker-lightbox' ); ?> 
			</label>
		</td>
		<td>
			<input type="radio" name="<?php echo $Tradetracker_multilightbox_field_name; ?>" <?php if($Tradetracker_multilightbox_val==1) {echo "checked";} ?> value="1"> Yes (<a href="http://wordpress.org/extend/plugins/wp-jquery-lightbox/" target="_blank">You will need this plugin</a>)
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
			<input type="radio" name="<?php echo $Tradetracker_multilightbox_field_name; ?>" <?php if($Tradetracker_multilightbox_val==0){echo "checked";} ?> value="0"> No
		</td>
	</tr>
</table>
<hr />

<p class="submit">
	<b>Always save changes before pressing next.</b><br>
	<input type="submit" name="Submit" class="button-primary" value="<?php if($multiid>="1"){ esc_attr_e('Save Changes'); } else { esc_attr_e('Create'); } ?>" />
	<INPUT type="button" name="New" value="<?php esc_attr_e('New') ?>" onclick="location.href='admin.php?page=tradetracker-shop-multi'"> 
	<INPUT type="button" name="Next" value="<?php esc_attr_e('Next') ?>" onclick="location.href='admin.php?page=tradetracker-shop-multiitems'"> 
	<INPUT type="button" name="Help" value="<?php esc_attr_e('Help') ?>" onclick="location.href='admin.php?page=tradetracker-shop-help'">
</p>

</form>
	<table width="400">
		<tr>
			<td>
				<b>Store Name</b>
			</td>
			<td>
			</td>
			<td>
			</td>
		</tr>
<?php
		$layoutedit=$wpdb->get_results("SELECT id, multiname FROM ".$tablemulti."");
		foreach ($layoutedit as $layout_val){
?>

		<tr>
			<td>
				<?php echo $layout_val->multiname; ?>
			</td>
			<td>
				<a href="admin.php?page=tradetracker-shop-multi&multiid=<?php echo $layout_val->id; ?>">Edit</a>
			</td>
			<td>
				<a href="admin.php?page=tradetracker-shop-multiitems&multiid=<?php echo $layout_val->id; ?>">Select Items</a>
			</td>
		</tr>
			
<?php		
		
		}
?>
	</table>
</div>
<?php
}
?>