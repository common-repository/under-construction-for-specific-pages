<?php
add_action('wp_ajax_underconstructionaction','insertDataUnderConstruction');
add_action('wp_ajax_nopriv_underconstructionaction','insertDataUnderConstruction');

function insertDataUnderConstruction() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'underConstruct';
  $pageid = sanitize_text_field($_POST['page_id']);
    
  $numofrows = $wpdb->get_var(
      $wpdb->prepare(
        "SELECT count(*)
          FROM $table_name
          WHERE status = %d AND pageid = %d",
        1, $pageid
      )
    );

  if($numofrows < 1) {
    $query = $wpdb->insert($table_name , array(
      "pageid" => sanitize_text_field($_POST['page_id']),
      "uc_text" => sanitize_text_field($_POST['contentText']),
      "startdatetime" => sanitize_text_field($_POST['startdatetime']),
      "enddatetime" => sanitize_text_field($_POST['enddatetime']),
      "status" => '1'
    ));

    $last_query = $wpdb->last_query;
    if ($query == true) {
      //$response = array('message'=>'Data Has Inserted Successfully', 'rescode'=>200);
      $response = '1';
    } else {
       //$response = '<span class="alert alert-danger"> Data Not Saved </span>';
      $response = '2';
       //$response = array('message'=>'Data Has NOT Inserted', 'rescode'=>202);
    }
    
  } else {
    //$response = '<span class="alert alert-info"> Data Has Already Exist </span>';
    $response = '3';
    //$response = array('message'=>'For given page, underConstruction Has Already Set', 'rescode'=>205);
  }
  //echo json_encode($response);
  echo esc_html($response);
  exit();
  wp_die();
}


add_action('wp_ajax_delete_data_unid','deleteDataUnderCOnstruction');
add_action('wp_ajax_nopriv_delete_data_unid','deleteDataUnderCOnstruction');
function deleteDataUnderCOnstruction() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'underConstruct'; 
  $userid_delete = sanitize_text_field($_POST['userid_delete']);
  $query = $wpdb->delete( $table_name, array( 'ucid' => $userid_delete ) );
  if ($query == true) {
    $response = "1";
  } else {
    $response = "2";
  }
  echo esc_html($response);
  exit();
  wp_die();
}

//update data
add_action('wp_ajax_updatedata_id','updateDataUnderConstruction');
add_action('wp_ajax_nopriv_updatedata_id','updateDataUnderConstruction');
function updateDataUnderConstruction() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'underConstruct'; 
  $userid_update = sanitize_text_field($_POST['userid_update']);
  $editorid = 'editorid_'.$userid_update;
  //$textdata = sanitize_text_field($_POST[$editorid]);
  $textdata = sanitize_text_field($_POST['content']);
  $selectPageId = sanitize_text_field($_POST['selectPageId']); 
  $startdatetime = sanitize_text_field($_POST['startdatetime']); 
  $enddatetime = sanitize_text_field($_POST['enddatetime']); 

  $data = array(
  'pageid' => $selectPageId,
  'uc_text' => $textdata,
  'startdatetime' => $startdatetime,
  'enddatetime' => $enddatetime
  );
  $where = array(
  'ucid' => $userid_update
  );
  $query = $wpdb->update( $table_name, $data, $where );

  if ($query == true) {
    $response = "1";
  } else {
    $response = "2";
  }
  echo esc_html($response);
  exit();
  wp_die();
}