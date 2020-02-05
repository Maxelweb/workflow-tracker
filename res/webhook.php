<?php 

// Github webhook handling

require_once 'config.php';
require_once 'utils/github-handler.php';
//$payload = json_decode(file_get_contents("tests/payload.json"), false);
$data = json_decode(file_get_contents("data/db.json"), true);

if(!empty($data) && $data != null)
{
	$found_repo = false;
	$found_user = false;

	// At least one repo exists
	foreach ($data['repos'] as &$repo)
	{
		// Repo exists
		if($repo['full_name'] == $payload->repository->full_name)
		{
			$repo['private'] = $payload->repository->private;
			foreach($repo['users'] as &$user)
			{
				// User exists
				if($user['name'] == $payload->sender->login)
				{
					$user['url'] = $payload->sender->html_url;
					$user['avatar'] = $payload->sender->avatar_url;
					$user['branch'] = $payload->ref;
					$user['update'] = time();
					$found_user = true;
					//echo "user updated";
					break;
				}
			}	

			// User NOT exists
			if(!$found_user)
			{
				$repo['users'][] = newUser($payload);
				//echo "new user added to repo";
			}

			$found_repo = true;
		}
	}

	// Repo NOT exists
	if(!$found_repo)
	{	
		$data['repos'][] = newRepo($payload);
		//echo "New repo added";
	}
}
else
{
	// First initialization
	$data['repos'][] = newRepo($payload);
	//echo "File initialized";
	
}


if(!empty($data))
{
	$data_file = fopen("data/db.json", "w");
	fwrite($data_file, json_encode($data));
	fclose($data_file);
	//echo "\nOK";
}




