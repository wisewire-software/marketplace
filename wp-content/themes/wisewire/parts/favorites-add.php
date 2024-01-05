              <?php if ( is_user_logged_in() ) { ?>
              
                <?php // ADD to favorites ?>
                <p class="btn-favorites">
                  <a href="?act=Favorites|action_add&amp;item_id=<?php echo $item_object_id ?>" class="btn btn-alt">ADD TO FAVORITES</a>
                </p>

              <?php } else { ?>
              
                <p class="btn-favorites">
                  <a href="#" 
                    class="btn btn-alt btn-favorite-not-loggedin"
                    data-toggle="popover"
                    data-content='
                    <p class="info">You must be logged in to create favorites</p><p class="clearfix"><a href="/user-login" class="btn btn-login">Log in</a><a href="/user-login" class="btn">Create account</a></p>
                    '
                  >ADD TO FAVORITES</a>
                </p>
                
              <?php } ?>