<?php
//add email validation for technology website user registration
add_filter("gform_field_content", "subsection_field", 10, 5);
add_filter('gform_validation_2', 'uvasom_gforms_validation');
global $blog_id;
if($blog_id ==='18'){
function uvasom_gforms_validation($validation_result){
    $form = $validation_result["form"];

    //supposing we don't want input 1 to be a value of 86
	$uvasom_user_email = $_POST['input_10'];
   	$uva_email = explode("@", $uvasom_user_email);
	$uva_cid = $uva_email[0];
	$uva_domain = $uva_email[1];
	
 	if($uva_domain != 'virginia.edu'){

        // set the form validation to false
        $validation_result["is_valid"] = false;

        //finding Field with ID of 1 and marking it as failed validation
        foreach($form["fields"] as &$field){

            //NOTE: replace 1 with the field you would like to validate
            if($field["id"] == "10"){
                $field["failed_validation"] = true;
                $field["validation_message"] = "Please use only the @virginia.edu domain for email.";
                break;
            }
        }

    }

    //Assign modified $form object back to the validation result
    $validation_result["form"] = $form;
    return $validation_result;

 }
if($blog_id !='18'){
	echo '';}
}
?>