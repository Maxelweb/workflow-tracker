<?php

require_once("../config.php");

if(!empty($name) && in_array($name, $_config->auth_repos))
{

  if($name=="updates")
  {
    require_once("updates.php");
  }
  else
  {

    $data_file = file_get_contents("data.json");
    $data = json_decode($data_file, false);

    if(empty($data))
        echo "<p class='my-5 text-center'>No data found.</p>";
    else
    {
        foreach($data->repos as $repo)
        {
            if($name == $repo->name)
            {
                echo '
                <h3 class="text-center text-secondary mt-5 mb-4"><i class="fas fa-code-branch"></i> <a target="_blank" href="https://github.com/'.$repo->full_name.'">'.$repo->name.'</a></h3>
                <div class="row my-3">
                ';

                if(!empty($repo))
                    foreach($repo->users as $user)
                    {
                        echo '
                           <div class="col-lg-4 my-3">
                            <div class="card">
                            <img src="'.$user->avatar.'" class="card-img-top" alt="">
                              <div class="card-body">
                                <blockquote class="blockquote mb-0">
                                  <p><i class="fas fa-circle text-'.($user->update > time()-60*20 ? 'success' : 'danger').' small"></i> @'.$user->name.' </p>
                                  <footer class="blockquote-footer code">'.$user->branch.'</footer>
                                </blockquote>
                              </div>
                              <div class="card-footer text-muted">
                                <i class="fas fa-history"></i> '.date("Y-m-d, H:i:s", $user->update).'
                              </div>
                            </div>
                          </div>';
                    }

                echo '</div>';
            }
        }
    }
  }
}
