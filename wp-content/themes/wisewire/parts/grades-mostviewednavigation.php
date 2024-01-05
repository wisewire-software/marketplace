	
	<?php $grade = isset($wp_query->query['grade']) ? $wp_query->query['grade'] : 'elementary'; ?>
	<!-- Hidden on <768px -->
	<section class="nav-grades hidden-xs">
      
      <div class="container">
        
        <!-- Nav tabs -->
        <ul class="lo-nav" role="tablist">
          <li role="presentation" <?php echo (!$grade || $grade == 'elementary') && !isset($wp_query->query['search']) ? 'class="active"' : '' ?>><a href="<?php echo get_site_url(); ?>/explore/elementary/">Elementary</a></li>
          <li role="presentation" <?php echo $grade == 'middle' && !isset($wp_query->query['search']) ? 'class="active"' : '' ?>><a href="<?php echo get_site_url(); ?>/explore/middle/">Middle</a></li>
          <li role="presentation" <?php echo $grade == 'high-school' && !isset($wp_query->query['search']) ? 'class="active"' : '' ?>><a href="<?php echo get_site_url(); ?>/explore/high-school/">High School</a></li>
          <li role="presentation" <?php echo $grade == 'higher-education' && !isset($wp_query->query['search']) ? 'class="active"' : '' ?>><a href="<?php echo get_site_url(); ?>/explore/higher-education/">Higher Education</a></li>
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