<?php
add_filter("gform_upload_path_3", "uvasom_change_upload_path", 10, 2);
function uvasom_change_upload_path($path_info, $form_id){
	global $blog_id;
if($blog_id ==='18' && $form_id === 3){
   $path_info["path"] = "/var/www/vhosts/med/wp-content/uploads/userphoto/";
   $path_info["url"] = "http://technology.med.virginia.edu/uploads/userphoto/";
   return $path_info;
	}
}
add_action("gform_after_submission_3", "uvasom_after_submission_3", 10, 2); //this is a gf filter which lets us get an entry after it is done.  we will use this to automatically rename files (only form 9 in the example)
function uvasom_after_submission($entry, $form){
    global $blog_id;
	if($blog_id ==='18' && $form_id === 3){
	foreach($form['fields'] as $key => $field){  //this will get all the fields that are a fileupload type
	    if($field['type'] == 'fileupload')
	    	$keys[] = $field['id'];
    }
    foreach($keys as $value){  //this will save the url info for all the fields which were submitted
    	$pathinfo = pathinfo($entry[$value]);
    	if(!empty($pathinfo['extension'])){
	    	$oldurls[$value] = $pathinfo;
	    	$pathinfo['filename'] = $entry['id'] . '_' . $form['id'] . '_' . $value;  //we are going to make the files look something like this entryid_formid_fieldid... so you may have something like 323_9_12 for the filename.   this system ensures all filenames are unique and sorted.  you can make the name anything you like.  remember it is the filename only (no path and no extension)
	    	$newurls[$value] = $pathinfo;
    	}
    }
    $uploadinfo = uvasom_change_upload_path('', 3); //this will get the upload path from our custom filter
    foreach($newurls as $key => $value){
    	$oldpath = $uploadinfo['path'].$oldurls[$key]['filename'].'.'.$oldurls[$key]['extension'];
    	$newpath = $uploadinfo['path'].$newurls[$key]['filename'].'.'.$newurls[$key]['extension'];
    	$oldurl = $uploadinfo['url'].$oldurls[$key]['filename'].'.'.$oldurls[$key]['extension'];
    	$newurl = $uploadinfo['url'].$newurls[$key]['filename'].'.'.$newurls[$key]['extension'];
    	$is_success = rename($oldpath,$newpath); //this renames the file
    	if($is_success && !empty($is_success)){
	    	global $wpdb;
	    	$wpdb->update(RGFormsModel::get_lead_details_table_name(), array("value" => $newurl), array("lead_id" => $entry["id"], "value" => $oldurl)); //this updates wordpress
    	}
    }
    return;
}
}
?>