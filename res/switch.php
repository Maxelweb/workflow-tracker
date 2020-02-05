<?php

/**
 *  Page selector for the homepage
 *  @author Maxelweb (marianosciacco.it)
 *  @version 1.0
 */


require_once 'config.php';

switch ($name) {
	case 'updates':
		require_once("pages/updates.php");
		break;
	
	default:
		require_once("pages/workflow.php");
		break;
}