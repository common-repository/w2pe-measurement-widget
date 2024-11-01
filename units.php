<?php

global $wpdb;

if ( function_exists('plugins_url') ){
	$url = plugins_url(plugin_basename(dirname(__FILE__)));
}
else{
	$url = get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__));
}

$all_cat = get_option('w2pe_measure_category');
//sort
asort($all_cat);

$db_table = $wpdb->prefix . 'w2pe_measure_units';


// insert data
if(isset($_POST['add'])){
	$cat = trim($_POST['cat']);
	$unit1 = trim($_POST['unit1']);
	$param1 = trim($_POST['param1']);
	$unit2 = trim($_POST['unit2']);
	$param2 = trim($_POST['param2']);
	
	if(empty($cat) || empty($unit1) || empty($param1) || empty($unit2) || empty($param2)){
		$msg1='All Fields Required';
	}else if( (!is_numeric($param1)) || (!is_numeric($param2))){
		$msg1='Invalid Parameter. Use Only Numeric Values';
	}else{
	//insert data
		$wpdb->insert( 
			$db_table, 
			array( 
				'category' => $_POST['cat'],
				'unit1' => $_POST['unit1'],
				'param1' => $_POST['param1'],
				'unit2' => $_POST['unit2'],
				'param2' => $_POST['param2']
			), 
			array( 
				'%s', 
				'%s',
				'%f',
				'%s',
				'%f'
			)
		);
		if($wpdb->insert_id){
			//success
			$msg2='New Unit Added';
		}
	}
}

//update data
if(isset($_POST['update'])){

	$cat = trim($_POST['cat']);
	$unit1 = trim($_POST['unit1']);
	$param1 = trim($_POST['param1']);
	$unit2 = trim($_POST['unit2']);
	$param2 = trim($_POST['param2']);
	
	if(empty($cat) || empty($unit1) || empty($param1) || empty($unit2) || empty($param2)){
		$msg1='Fields Required to be Updated';
	}
	else{

		$res = $wpdb->update( 
			$db_table, 
			array( 
				'category' => $_POST['cat'],
				'unit1' => $_POST['unit1'],
				'param1' => $_POST['param1'],
				'unit2' => $_POST['unit2'],
				'param2' => $_POST['param2']
			), 
			array( 'id' => $_REQUEST['cid'] ), 
			array( 
				'%s', 
				'%s',
				'%f',
				'%s',
				'%f'
			), 
				'%d'
		);				
		
	}
	if($res===0 || $res>0){
		$msg2='Information Updated';
	}
	
}

//delete
if ( isset($_REQUEST['did']) ){
	
	$wpdb->query( 
		$wpdb->prepare( 
			"DELETE FROM $db_table
			 WHERE id = %d
			",
				$_REQUEST['did'] 
			)
	);	
}
?>

    <h1>w2pe Measurement Widget - All Units</h1>
    
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
            $row=$wpdb->get_row("select * from $db_table WHERE id = '".$_REQUEST['cid']."' ");
        ?>
        <fieldset class="cSlider">
            <legend>Update Unit</legend>
        <form action="" method="post" enctype="multipart/form-data">
        <table width="100%" border="0">
          <tr>
            <td width="26%"><div align="right">Category</div></td>
            <td width="1%"><div align="center"><strong>:</strong></div></td>
            <td width="73%">
            	<select name="cat" id="cat">
                <?php
                if(!empty($all_cat)){
					foreach($all_cat as $cat){
				?>
                	<option <?php echo ($row->category==$cat) ? 'selected=selected' : '';?>><?php echo $cat;?></option>
                <?php } }?>
                </select>
            </td>
          </tr>
		  
		  <tr>
            <td width="26%"><div align="right">Unit Name</div></td>
            <td width="1%"><div align="center"><strong>:</strong></div></td>
            <td width="73%">
            	<input type="text" name="unit1" id="unit1" value="<?php echo $row->unit1?>" />
            </td>
          </tr>
		  
		  <tr>
            <td width="26%"><div align="right">Parameter</div></td>
            <td width="1%"><div align="center"><strong>:</strong></div></td>
            <td width="73%">
            	<input type="text" name="param1" id="param1" value="<?php echo $row->param1?>" />
            </td>
          </tr>
		  
		  <tr>
            <td width="26%"><div align="right">Unit Name</div></td>
            <td width="1%"><div align="center"><strong>:</strong></div></td>
            <td width="73%">
            	<input type="text" name="unit2" id="unit2" value="<?php echo $row->unit2?>" />
            </td>
          </tr>
		  
		  <tr>
            <td width="26%"><div align="right">Parameter</div></td>
            <td width="1%"><div align="center"><strong>:</strong></div></td>
            <td width="73%">
            	<input type="text" name="param2" id="param2" value="<?php echo $row->param2?>" />
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
            <legend>Add Unit</legend>
            <form action="" method="post" enctype="multipart/form-data">
            <table width="100%" border="0">
              <tr>
                <td width="26%"><div align="right">Category</div></td>
                <td width="1%"><div align="center"><strong>:</strong></div></td>
                <td width="73%">
                    <select name="cat" id="cat">
                    <?php
                    if(!empty($all_cat)){
                        foreach($all_cat as $category){
                    ?>
                        <option><?php echo $category;?></option>
                    <?php } }?>
                    </select>
                </td>
              </tr>
              <tr>
                <td width="26%"><div align="right">Unit Name</div></td>
                <td width="1%"><div align="center"><strong>:</strong></div></td>
                <td width="73%"><div align="left"><input type="text" name="unit1"></div></td>
              </tr>
              <tr>
                <td width="26%"><div align="right">Parameter</div></td>
                <td width="1%"><div align="center"><strong>:</strong></div></td>
                <td width="73%"><div align="left"></div><input type="text" name="param1"></td>
              </tr>
              <tr>
                <td width="26%"><div align="right">Unit Name</div></td>
                <td width="1%"><div align="center"><strong>:</strong></div></td>
                <td width="73%"><div align="left"><input type="text" name="unit2"></div></td>
              </tr>
              <tr>
                <td width="26%"><div align="right">Parameter</div></td>
                <td width="1%"><div align="center"><strong>:</strong></div></td>
                <td width="73%"><div align="left"><input type="text" name="param2"></div></td>
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
            <legend>Units</legend>
            <table width="100%" border="0" class="w2pe-measure-table">
              <tr style="background:#000;color:#fff">
                <td width="19%"><div align="center"><strong>Category</strong></div></td>
                <td width="17%"><div align="center"><strong>Unit Name</strong></div></td>
                <td width="17%"><div align="center"><strong>Parameter</strong></div></td>
				<td width="17%"><div align="center"><strong>Unit Name</strong></div></td>
                <td width="17%"><div align="center"><strong>Parameter</strong></div></td>
				<td width="17%"><div align="center"><strong>Action</strong></div></td>
              </tr>
			  
				<?php
				$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
				$limit = 20; // number of rows in page
				$start = ( $pagenum - 1 ) * $limit;
				$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM `wp_w2pe_measure_units` " );
				$num_of_pages = ceil( $total / $limit );
				 
                 $result=$wpdb->get_results("SELECT * FROM `wp_w2pe_measure_units` ORDER BY `category`, `unit1` ASC LIMIT $start, $limit");
				 if(!empty($result)){
                 	foreach ($result as $r){
				?>  
				<tr>
                <td><div align="center"><?php echo stripslashes($r->category)?></div></td>
				<td><div align="center"><?php echo stripslashes($r->unit1)?></div></td>
				<td><div align="center"><?php echo stripslashes($r->param1)?></div></td>
				<td><div align="center"><?php echo stripslashes($r->unit2)?></div></td>
				<td><div align="center"><?php echo stripslashes($r->param2)?></div></td>
                <td>
                    <div align="center">
                    <a href="<?php echo $_SERVER['PHP_SELF'];?>?page=w2pe_measure_widget_menu&cid=<?php echo $r->id?>" title="Update"><img src="<?php echo $url?>/images/edit.png" /></a> 
                    <a href="<?php echo $_SERVER['PHP_SELF'];?>?page=w2pe_measure_widget_menu&did=<?php echo $r->id?>" title="Delete"><img src="<?php echo $url?>/images/delete.png" /></a>
                    </div>
                </td>
				</tr>
				<?php }}else{?>
				<tr><td colspan="3" align="center">No query added yet</td></tr>
				<?php }?>
            </table>
			<?php
            $page_links = paginate_links( array(
                'base' => add_query_arg( 'pagenum', '%#%' ),
                'format' => '',
                'prev_text' => __( '&laquo;', 'text-domain' ),
                'next_text' => __( '&raquo;', 'text-domain' ),
                'total' => $num_of_pages,
                'current' => $pagenum
            ) );
            
            if ( $page_links ) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
            }
            ?>            
        </fieldset>
</div>