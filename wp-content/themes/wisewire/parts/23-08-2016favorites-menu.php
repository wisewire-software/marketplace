<?php

global $fav_controller;

$favorites = $fav_controller->get_favorites();

if (sizeof($favorites)){
	/*Evaluates if an iten is repeated more than one time, if so, deletes all the repeated.*/
	$array_favorites = [];
	foreach ($favorites as $key => $item){
		if( in_array( $item->id, $array_favorites ) ){
			unset($favorites[$key]);
		} else{
			array_push($array_favorites, $item->id);
		}		
	}
}

?>

<li id="header-favorites">
	<a href="#" id="btn-header-favorite">Favorites<?php echo sizeof($favorites) > 0 ? ' ('.sizeof($favorites).')' : '' ?></a>

	<div class="popover popover-favorite fade bottom in" role="tooltip" id="favoritePopover">
		<div class="arrow"></div>
		<div class="wrapper">
			<div class="popover-content">
				<p class="info"><?php echo sizeof($favorites) ?> <?php echo sizeof($favorites) > 1 ? 'Items' : 'Item' ?> in your favorites</p>

				<div class="items-container">					
					
					<?php if (sizeof($favorites)): ?>
						<?php foreach ($favorites as $item): ?>								
							<?php								
								$url_item   = ($item->type!='item')? $item->id:$item->name;
								$url_remove = ($item->type!='item')? $item->id."&amp;item_type=question": $item->item_object_id;
							?>	
							<div class="item" onclick="location.href = '/item/<?php echo $url_item ?>/';">
								<div class="content"> 
									<a href="?my_action=Favorites|action_remove&amp;item_id=<?php echo $url_remove ?>" title="Are you sure that you want to remove this from favorites?" class="remove btn-confirm"></a>
									<h2 class="sub-discipline">
										<?php echo $item->title ?>
									</h2>							
									<p class="content-type">
										<?php echo $item->content_type_icon ?>
									</p>							
								</div>
							</div>							
						<?php endforeach; ?>
					<?php endif; ?>

				</div><!-- /items-container-->
				<?php if (sizeof($favorites)): ?>
				<p>
					<a href="/favorites" class="btn">View favorites</a>
				</p>
				<?php endif; ?>
			</div>
		</div>
	</div><!-- /popover -->

</li>  