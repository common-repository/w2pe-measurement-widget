<?php
$all_cat = get_option('w2pe_measure_category');

if ( function_exists('plugins_url') ){
	$url = plugins_url(plugin_basename(dirname(__FILE__)));
}
else{
	$url = get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__));
}


// insert data
if(isset($_POST['add'])){
	$name = trim($_POST['name']);
	$check = array_search($name, $all_cat);
	
	if(!empty($check)){
		$msg1 = 'Category Name already exist';
	}else{
		array_push($all_cat, $name);
		update_option('w2pe_measure_category', $all_cat);
		$msg2 = 'New Category Added';
	}
}

//update data
if(isset($_POST['update'])){
	$name = trim($_POST['name']);
	$cid = $_POST['cid'];
	$oldname = $all_cat[$cid];
	$check = array_search($name, $all_cat);
	
	if(!empty($check)){
		if($oldname == $name){
			update_option('w2pe_measure_category', $all_cat);
			$msg2 = 'Category Updated';	
		}else{
			$msg1 = 'Category Name already exist';
		}
	}else{
		$replace = array( $cid => $name);
		$new_cat = array_replace($all_cat, $replace);
		update_option('w2pe_measure_category', $new_cat);
		$msg2 = 'Category Updated';
	}	
}

//delete
if ( isset($_REQUEST['did']) ){
	unset($all_cat[$_REQUEST['did']]);
	update_option('w2pe_measure_category', $all_cat);
}
?>

    <h1>w2pe Measurement Widget - All Categories</h1>
    
    <div class="w2pe_measure">
    <?php if ( isset($msg1) ){?>
    <div class="updated error" id="msg"><p><strong><?php echo $msg1;?></strong></p></div>
    <?php }?>
    <?php if ( isset($msg2) ){?>
    <div class="updated" id="msg"><p><strong><?php echo $msg2;?></strong></p></div>
    <?php }?>

    <!--html for update-->
        <?php
        if ( isset($_REQUEST['cid']) ){
			
        ?>
        <fieldset class="cSlider">
            <legend>Update Category</legend>
        <form action="" method="post" enctype="multipart/form-data">
        <table width="100%" border="0">
          <tr>
            <td width="26%"><div align="right">Caption</div></td>
            <td width="1%"><div align="center"><strong>:</strong></div></td>
            <td width="73%">
            	<input type="text" name="name" value="<?php echo stripslashes($all_cat[$_REQUEST['cid']]) ?>" />
                <input type="hidden" name="cid" value="<?php echo $_REQUEST['cid']; ?>" />
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="submit" class="button button-primary button-large" name="update" value="Update" /></td>
          </tr>
        </table>
        </form>
        </fieldset>
        <?php }else{?>
        <!--html for add-->
        <fieldset>
            <legend>Add Category</legend>
            <form action="" method="post" enctype="multipart/form-data">
            <table width="100%" border="0">
              <tr>
                <td width="26%"><div align="right">Name</div></td>
                <td width="1%"><div align="center"><strong>:</strong></div></td>
                <td width="73%"><input type="text" name="name" value="" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" class="button button-primary button-large" name="add" value="Add" /></td>
              </tr>
            </table>
            </form>
        </fieldset>
        <?php }?>
        
        
        <fieldset>
            <legend>Categories</legend>
            <table width="100%" border="0" class="w2pe-measure-table">
              <tr style="background:#000;color:#fff">
                <td width="45%"><div align="center"><strong>Name</strong></div></td>
                <td width="35%"><div align="center"><strong>Total Units</strong></div></td>
                <td width="22%"><div align="center"><strong>Action</strong></div></td>
              </tr>
              <?php
			  global $wpdb;
			  $db_table = $wpdb->prefix . 'w2pe_measure_units';
			  $all_cats = get_option('w2pe_measure_category');
			  if(!empty($all_cats)){
				  asort($all_cats);
				  foreach($all_cats as $key => $ac){
					  $unit_count = $wpdb->get_var( "SELECT COUNT(*) as `total` FROM $db_table WHERE `category`= '$ac' " );
			  ?>
              <tr>
                <td width="45%"><div align="center"><strong><?php echo $ac;?></strong></div></td>
                <td width="35%"><div align="center"><strong><?php echo $unit_count;?></strong></div></td>
                <td width="22%"><div align="center">
                    <a href="<?php echo $_SERVER['PHP_SELF'];?>?page=w2pe_measure_cat&cid=<?php echo $key?>" title="Update"><img src="<?php echo $url?>/images/edit.png" /></a> 
                    <a href="<?php echo $_SERVER['PHP_SELF'];?>?page=w2pe_measure_cat&did=<?php echo $key?>" title="Delete"><img src="<?php echo $url?>/images/delete.png" /></a>
                    </div>
                </td>
              </tr>
              <?php } }?>
            </table>
        </fieldset>
</div>