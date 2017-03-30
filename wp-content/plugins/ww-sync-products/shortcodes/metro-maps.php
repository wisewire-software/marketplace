<?php
function metro_mashup_shortcode($atts){
   extract(shortcode_atts(array(
	  'width' => '100%',
	  'height' => '350px',
	  'zoom' => 7,
	  'region' => '',
	  'format' => '',
	  'focus' => '',
	  'association' , '',
	  'streetview' => false
   ), $atts));

?>
	
    <div id="map_canvas" style="width:<?php echo $width; ?>;height:<?php echo $height; ?>;"></div>
	
    <script type="text/javascript">
      
	   jQuery(function($) {
			
			$.post('/wp-content/plugins/metromba-custom/shortcodes/markers.php', { region: '<?php echo $region; ?>',  format: '<?php echo $format; ?>' ,  focus: '<?php echo $focus; ?>' , association: '<?php echo $association; ?>' } , function(data) {
				
				$('#map_canvas').gmap({'streetViewControl':false}); // Add the contructor
			  	$.each( data.markers, function(i, m) {
			
					// alert('hello');
			
					$('#map_canvas').gmap('addMarker', { 
						'position': new google.maps.LatLng(m.latitude, m.longitude), 
						'bounds': true ,
						
						
					}).click(function() {
						$('#map_canvas').gmap('openInfoWindow', { 'content': m.content, 'maxWidth': '300' }, this);
					});
					
				});
			}, "json"); 
			
			 
        });
	
	</script>

    <?php
	
}


   add_shortcode('metromashup', 'metro_mashup_shortcode');
   

function metro_map_shortcode($atts){
   extract(shortcode_atts(array(
	  'width' => '100%',
	  'height' => '350px',
	  'zoom' => ''
   ), $atts));


				if(get_field('locations'))
				{
					$addmarkers = array();
					$a = 0;
					while(has_sub_field('locations'))
					{
						
						$location_title[] = get_sub_field('location_title');
						$location_desc[] = get_sub_field('location_description');
						$location = get_sub_field('location');
						$location_string[] = $location['address'];
						$coord_string[] = $location['coordinates'];
						$coord = explode(',',$location['coordinates']);
						
						$lat = (double)$coord[0];
						$long = (double)$coord[1];
						$title = get_the_title();
						$permalink = get_permalink();
						if ( has_post_thumbnail($post->ID)){
							$thumbnail = get_the_post_thumbnail($post->ID, array(100,100) );
							$formatted_thumb = '<div class="alignleft">'.$thumbnail.'</div>';
						}else{
							$thumbnail = '';	
						}
						
						$addmarkers[$a]['marker'] = "this.addMarker( { 'position': '".$lat.",".$long."', 'bounds': false} );"; 
						$addmarkers[$a]['center'] = "'center': '".$lat.",".$long."'";
						$a++;
					}
						
				};
				


	
	?>
                  
	
				  
        						<?php
								$i = 0;
									if($addmarkers){
										foreach($addmarkers as $marker){
										
									?>
									<div class="school-location">
										<div id="metromap-<?php echo $i; ?>-<?php echo $post->ID; ?>" style="width:100%;height:150px;"></div>
										
										<script type="text/javascript">
							
				
										   jQuery(function($) {
											   
												  $('#metromap-<?php echo $i; ?>-<?php echo $post->ID; ?>').gmap({
													  'streetViewControl':false,
													  'zoom':13, <?php echo $marker['center']; ?>,
													  'callback':function() {
															<?php echo $marker['marker'];	?>
														}
													});

											});
										
										</script>
							 
											<h4 style="margin-top:10px;"><?php echo $location_title[$i]; ?></h4>
											<p><?php echo $location_string[$i]; ?></p>
										
											<span class="dir-btn"><a class="get-directions" href="https://maps.google.com/maps?q=<?php echo $location_string[$i].','.$coord_string[$i]; ?>">get directions</a></span>
									</div>
									<?php
											$i++;
										}
									}
								
								?>		
							


    <?php
	
}


   add_shortcode('metromap', 'metro_map_shortcode');   
   

?>
