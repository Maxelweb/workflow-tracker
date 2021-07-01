<?php

/**
 *  Core functions and classes
 *  @author Maxelweb (marianosciacco.it)
 *  @version 1.0
 */

function newRepo($payload)
{
	global $_config;

	if(in_array($payload->repository->name, $_config->auth_repos))
	{
		return array(
			"name" => $payload->repository->name,
			"full_name" => $payload->repository->full_name,
			"private" => $payload->repository->private,
			"users" => array(newUser($payload))
		);
	}
	else
		die("Repo not authorized to be added.");
}

function newUser($payload)
{
	return array(
		"name" => $payload->sender->login,
		"url" => $payload->sender->html_url,
		"avatar" => $payload->sender->avatar_url,
		"branch" => $payload->ref,
		"update" => time()
	);
}

function formatBranch($b)
{
	$branch = "";
	$br = explode("/", $b);
	for($i=2; $i<count($br); $i++)
		$branch .= $i != count($br)-1 ? $br[$i].'/' : $br[$i];
	return $branch;
}


function formatTime($time)
{
	$age = time()-$time;
	$years = floor($age/(3600*24*7*4*12));
	$months = floor($age/(3600*24*7*4));
	$weeks = floor($age/(3600*24*7));
	$days = floor($age/(3600*24));
	$hours = floor($age/3600);
	$minutes = floor($age/60);
	$seconds = $age;

	if($years>0)
		$age = ($years>1) ? sprintf('%d years ago', $years) : '1 year ago';
	elseif($months>0)
		$age = ($months>1) ? sprintf('%d months ago', $months) : '1 month ago';
	elseif($weeks>0)
		$age = ($weeks>1) ? sprintf('%d weeks ago', $weeks) : '1 week ago';
	elseif($days>0)
		$age = ($days>1) ? sprintf('%d days ago', $days) : '1 day ago';
	elseif($hours>0)
		$age = ($hours>1) ? sprintf('%d hours ago', $hours) : '1 hour ago';
	elseif($minutes>0)
		$age = ($minutes>1) ? sprintf('%d mins ago', $minutes) : '1 min ago';
	elseif($seconds>0)
		$age = ($seconds>1) ? sprintf('%d sec ago', $seconds) : '1 sec ago';
	else
		$age = "undefined";

	return $age;
}	



class Updates
{
	private $version;
	private $payload;
	
	function __construct()
	{ 
		$this->version = VERSION;
		$this->payload = $this->checkNewVersion();
	}
	private function checkNewVersion()
	{
		$json = @file_get_contents('http://api.debug.ovh/wt.json');
		if(!$json)
			return array();
		return json_decode($json);
	}
	function currentVersion()
	{
		return $this->version;
	}
	function latestVersion()
	{
	 	if(!empty($this->payload))
	 		return $this->payload->version;
	 	return "N/A";
	}
	function info()
	{
		return $this->payload;
	}
}


define("VERSION", "1.0.1");
define("REPO", "https://github.com/Maxelweb/workflow-tracker");
$name = isset($_GET['name']) ? $_GET['name'] : $_config->homepage_repo;


