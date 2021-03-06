<?php

/**
 *  Workflow setup page
 *  @author Maxelweb (marianosciacco.it)
 *  @version 1.0
 */

$found = false;

if(!empty($name) && in_array($name, $_config->auth_repos))
{
  $data_file = file_get_contents("data/db.json");
  $data = json_decode($data_file, false);

  if(!empty($data))
  { 
    if(!empty($data->repos))
    {
      foreach($data->repos as $repo)
      {
          if($name == $repo->name)
          {
              echo '
              <h3 class="text-center text-secondary mt-5 mb-4"><i class="fas fa-'.($repo->private ? "lock": "book").'"></i> <a target="_blank" href="https://github.com/'.$repo->full_name.'">'.$repo->name.'</a></h3>
              <h6 class="text-center text-muted small mb-4">Last auto-check: <strong>'.date("Y-m-d, H:i:s").'</strong></h6>
              <div class="row my-3">
              ';

              $found = true;

              if(!empty($repo))
                  foreach($repo->users as $user)
                  {
                    $branch = formatBranch($user->branch);
                      echo '
                         <div class="col-lg-4 my-3 mx-auto">
                          <div class="card">
                            <div class="card-body">
                              <blockquote class="blockquote mb-0">
                                <img src="'.$user->avatar.'" width="75" height="75" class="rounded-circle float-left mr-4" alt="">
                                <p><i class="fas fa-circle text-'.($user->update > time()-60*20 ? 'success' : 'danger').' small"></i> <a class="text-dark" href="'.$user->url.'">@'.$user->name.'</a> </p>
                                <footer class="blockquote-footer code"><a class="text-muted" href="https://github.com/'.$repo->full_name.'/tree/'.$branch.'">'.$branch.'</a></footer>
                              </blockquote>
                            </div>
                            <div class="card-footer text-muted small">
                              <i class="fas fa-history"></i> Last update: <strong>'.formatTime($user->update).'</strong>
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

if(!$found)
    echo "<p class='my-5 text-center'><i class='far fa-frown'></i> No data found.</p>";
