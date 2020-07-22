<?php 
//echo "\n<br/> container view data".__FILE__.__LINE__." contentdata "; print_r([$controller,$contentcontroller, $content]); 
?>
		<div class="container-fluid" style="background-color: #ffffff;">
		
			<?= view_cell($controller.'::header') ?>
			<?php // echo view_cell($contentcontroller.'::'.$contentmethod) ?>
			<?php 
				$cco = new $contentcontroller; 
				echo call_user_func_array([$cco, $contentmethod], $parameterArray); 
			?>
			<?= view_cell($controller.'::footer') ?>
		</div>