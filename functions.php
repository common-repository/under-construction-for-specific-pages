<?php
function getAllPageList($pid=NULL){
	$select = '';
	$select.='<select name="selectPageId" id="selectPageId">';
	$select.='<option disabled>Select Page</option>';

	$pages = get_pages(); 
	foreach ($pages as $page_data) {
	  $title = $page_data->post_title; 
	  $pageid = $page_data->ID; 
	  if (!empty($pid)) {
	    if ($pid == $pageid ) {
	      $selected = 'selected';
	    } else {
	      $selected = '';
	    }
	  }
	  //echo "<pre>"; print_r($page_data);
	  $select.='<option value="'.$pageid.'" '.$selected.' >'.$title.'</option>';
	}
	$select.='</select>';
	return $select;
}
function editText($text, $editdata){
	//return $text;
	//return the_editor( $text );

	ob_start();
	wp_editor( $text, $editdata);
	$temp = ob_get_clean();
	$temp .= \_WP_Editors::enqueue_scripts();
	$temp .= print_footer_scripts();
	$temp .= \_WP_Editors::editor_js();
	return $temp;
}
?>