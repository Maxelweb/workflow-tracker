<?php

/**
 *  Configuration file
 *  @author Maxelweb (marianosciacco.it)
 *  @version 1.0
 */


/**
 * Edit the array to change the configuration
 * -----
 * You can also edit the .htaccess in the root directory to change the timezone
 */


$_config = (object) array(

	// IMAGE-URL for favicon and icon for the navbar 
	"icon" => "#",
	
	// URL for the "back to home" navbar link
	"home" => "#", 

	// NAME-LIST for the authorized repos
	"auth_repos" => array(

		"workflow-tracker",
		"Hello-World",
	),

	// NAME for the repo to show in the homepage
	"homepage_repo" => "workflow-tracker",

	// SECRET PHRASE for github webhook, 'null' as default
	"webhook_secret" => null,

);

require_once("utils/core.php");

