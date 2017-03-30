	
	<?php $grade = isset($wp_query->query['grade']) ? $wp_query->query['grade'] : 'middle'; ?>
    <?php if(isset($_REQUEST['nogrades'])){
      $grade = 'nogrades';
    }?>


	<!-- Hidden on <768px -->
	<section class="nav-grades hidden-xs">
      <div class="container">
        
        <!-- Nav tabs --> 
        <ul class="lo-nav" role="tablist">
          <li role="presentation" <?php echo ($grade == 'elementary') && !isset($wp_query->query['search']) && $wp_query->query['pagename'] != 'most-viewed' ? 'class="active"' : '' ?>>
            <a href="<?php echo get_site_url(); ?>/explore/elementary/"
               onmousedown="ga('send', 'event', 'GradeBandHeader', 'Click', 'Elementary');">Elementary
            </a>
          </li>
          <li role="presentation" <?php echo (!$grade || $grade == 'middle') && !isset($wp_query->query['search']) && $wp_query->query['pagename'] != 'most-viewed' ? 'class="active"' : '' ?>>
            <a href="<?php echo get_site_url(); ?>/explore/middle/"
               onmousedown="ga('send', 'event', 'GradeBandHeader', 'Click', 'Middle');">Middle
            </a>
          </li>
          <li role="presentation" <?php echo $grade == 'high-school' && !isset($wp_query->query['search']) && $wp_query->query['pagename'] != 'most-viewed' ? 'class="active"' : '' ?>>
            <a href="<?php echo get_site_url(); ?>/explore/high-school/"
               onmousedown="ga('send', 'event', 'GradeBandHeader', 'Click', 'HighSchool');">High School
            </a>
          </li>
          <li role="presentation" <?php echo $grade == 'higher-education' && !isset($wp_query->query['search']) && $wp_query->query['pagename'] != 'most-viewed' ? 'class="active"' : '' ?>>
            <a href="<?php echo get_site_url(); ?>/explore/higher-education/"
               onmousedown="ga('send', 'event', 'GradeBandHeader', 'Click', 'HigherEducation');">Higher Education</a>
          </li>
          <!--<li class="btn-customize">
            <a href="#" data-toggle="modal" data-target="#customizeModal" class="btn btn-alt">Customize Content</a>
          </li>-->
        </ul>
      
        <?php /*!-- Tab panes -->
        <div class="tab-content">
          
          <div role="tabpanel" class="tab-pane active" id="nav-elementary">
            <ul>
              <li class="active"><a href="#">PRE-K</a></li>
              <li><a href="#">KINDERGARTEN</a></li>
              <li><a href="#">FIRST</a></li>
              <li><a href="#">SECOND</a></li>
              <li><a href="#">THIRD</a></li>
              <li><a href="#">FOURTH</a></li>
              <li><a href="#">FIFTH</a></li>
              <li><a href="#">SIXTH </a></li>
            </ul>
          </div>
          
          <div role="tabpanel" class="tab-pane" id="nav-middle">
            <ul>
              <li><a href="#">Seventh</a></li>
              <li><a href="#">Eighth</a></li>
              <li><a href="#">Ninth</a></li>
            </ul>
          </div>
          
          <div role="tabpanel" class="tab-pane" id="nav-high-school">
            <ul>
              <li><a href="#">Tenth</a></li>
              <li><a href="#">Eleventh</a></li>
              <li><a href="#">Twelveth</a></li>
            </ul>
          </div>
          
          <div role="tabpanel" class="tab-pane" id="nav-higher-education">
            <ul>
              <li><a href="#">Undergraduate</a></li>
              <li><a href="#">Graduate</a></li>
            </ul>
          </div>                           
          
        </div><!-- /tab-content -->
        
      </div*/ ?>
      
    </section><!-- /nav-grades -->