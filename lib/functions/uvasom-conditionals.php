<?php
/*site types*/
/**********INDICATES WHAT GENERAL TOPIC AREA THIS FALLS INTO*******/
function uvasom_is_uvasom_homepage() {
	$type = genesis_get_option('uvasom_site_type');
	if( $type == 'home' ) {
		return TRUE;
	} else {
		return FALSE;	
	}
}

function uvasom_is_uvasom_basicsciences() {
	$type = genesis_get_option('uvasom_site_type');
	if( $type == 'basicsciences' ) {
		return TRUE;
	} else {
		return FALSE;	
	}
}

function uvasom_is_uvasom_clinicaldepartment() {
	$type = genesis_get_option('uvasom_site_type');
	if( $type == 'clinicaldepartment' ) {
		return TRUE;
	} else {
		return FALSE;	
	}
}

function uvasom_is_uvasom_administration() {
	$type = genesis_get_option('uvasom_site_type');
	if( $type == 'administration' ) {
		return TRUE;
	} else {
		return FALSE;	
	}
}

function uvasom_is_uvasom_community() {
	$type = genesis_get_option('uvasom_site_type');
	if( $type == 'community' ) {
		return TRUE;
	} else {
		return FALSE;	
	}
}

function uvasom_is_uvasom_research() {
	$type = genesis_get_option('uvasom_site_type');
	if( $type == 'research' ) {
		return TRUE;
	} else {
		return FALSE;	
	}
}

function uvasom_is_uvasom_education() {
	$type = genesis_get_option('uvasom_site_type');
	if( $type == 'education' ) {
		return TRUE;
	} else {
		return FALSE;	
	}
}
/*section types*/
/**********INDICATES WHETHER THIS IS A MAJOR LANDING SITE OR INDIVIDUAL SITE*******/
function uvasom_is_uvasom_main_section() {
	$sec_type = genesis_get_option('uvasom_section_type');
	if( $sec_type == 'main' ) {
		return TRUE;
	} else {
		return FALSE;	
	}
}
function uvasom_is_uvasom_secondary_section() {
	$sec_type = genesis_get_option('uvasom_section_type');
	if( $sec_type == 'secondary' ) {
		return TRUE;
	} else {
		return FALSE;	
	}
}
function uvasom_is_uvasom_tertiary_section() {
	$sec_type = genesis_get_option('uvasom_section_type');
	if( $sec_type == 'tertiary' ) {
		return TRUE;
	} else {
		return FALSE;	
	}
}
?>