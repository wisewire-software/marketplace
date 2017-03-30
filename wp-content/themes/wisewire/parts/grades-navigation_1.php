
	<?php global $WWItems; ?>

	<section class="nav-grades hidden-xs">
      
      <div class="container"> 
        
        <!-- Nav tabs -->
        <ul class="lo-nav" role="tablist">
          <li role="presentation" <?php echo $WWItems::$grade_name == 'elementary' ? 'class="active"' : '' ?>><a href="<?php echo get_site_url(); ?>/explore/elementary/">Elementary</a></li>
          <li role="presentation" <?php echo $WWItems::$grade_name == 'middle' ? 'class="active"' : '' ?>><a href="<?php echo get_site_url(); ?>/explore/middle/">Middle</a></li>
          <li role="presentation" <?php echo $WWItems::$grade_name == 'high-school' ? 'class="active"' : '' ?>><a href="<?php echo get_site_url(); ?>/explore/high-school/">High School</a></li>
          <li role="presentation" <?php echo $WWItems::$grade_name == 'higher-education' ? 'class="active"' : '' ?>><a href="<?php echo get_site_url(); ?>/explore/higher-education/">Higher Education</a></li>
          <!--<li class="btn-customize">
            <a href="#" data-toggle="modal" data-target="#customizeModal" class="btn btn-alt">Customize Content</a>
          </li>-->
        </ul>
      
        <!-- Tab panes -->
        <?php /*div class="tab-content">
          
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
          
          <div role="tabpanel" class="tab-pane" id="nav-high">
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
          
        </div*/ ?><!-- /tab-content -->
        
      </div>
      
    </section><!-- /lo-navigation -->