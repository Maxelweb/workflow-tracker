<?php

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
		$json = file_get_contents('http://api.debug.ovh/wt.json');
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


define("VERSION", "1.0");
define("REPO", "https://github.com/Maxelweb/workflow-tracker");
$name = isset($_GET['name']) ? $_GET['name'] : $_config->homepage_repo;


