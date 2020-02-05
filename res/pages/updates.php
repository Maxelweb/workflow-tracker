<?php

/**
 *  Updates page
 *  @author Maxelweb (marianosciacco.it)
 *  @version 1.0
 */

?>

	<h3 class="text-center text-secondary my-4"><i class='fas fa-sync-alt'></i> Updates</h3>
	<p class="text-center my-2">
	<?php 
		$hup = new Updates();
		if($hup->latestVersion() == "N/A")
			echo "Unable to check for new updates. Try later or checkout the <a href='".REPO."'>official repository</a>.";
		elseif($hup->currentVersion() != $hup->latestVersion()) 
			echo "Your version is <strong>not</strong> up to date.";
		else
			echo "Your version is up to date.";
	?>
	</p>
	<p class="text-center my-2">
		<i class="fas fa-download text-primary"></i> <a href="<?=REPO;?>">Download new updates from the official repo</a></a>
	</p>

	<ul class="my-4">
		<li><strong>Current version:</strong> <?=$hup->currentVersion();?></li>
		<li><strong>Latest version:</strong> <?=$hup->latestVersion();?></li>
	</ul>

	<?php
		if(!empty($hup->info()))
		{
			echo "<div class='table-responsive my-4'><table class='table table-striped table-bordered'>";
			foreach ($hup->info() as $key => $value) 
			{
				echo "<tr>
						<th>$key</th>
						<td>$value</td>
					  </tr>";
			}
			echo "</table></div>";
		}
	?>