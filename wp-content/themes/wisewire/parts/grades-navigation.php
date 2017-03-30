
	<?php global $WWItems; ?>

	<section class="nav-grades hidden-xs">
      
      <div class="container">
        
        <!-- Nav tabs -->
        <ul class="lo-nav" role="tablist">
          <li role="presentation" <?php echo $WWItems::$grade_name == 'elementary' ? 'class="active"' : '' ?>><a href="#nav-elementary" aria-controls="nav-elementary" role="tab" data-toggle="tab">Elementary</a></li>
          <li role="presentation" <?php echo $WWItems::$grade_name == 'middle' ? 'class="active"' : '' ?>><a href="#nav-middle" aria-controls="nav-middle" role="tab" data-toggle="tab">Middle</a></li>
          <li role="presentation" <?php echo $WWItems::$grade_name == 'high-school' ? 'class="active"' : '' ?>><a href="#nav-high-school" aria-controls="nav-high-school" role="tab" data-toggle="tab">High School</a></li>
          <li role="presentation" <?php echo $WWItems::$grade_name == 'higher-education' ? 'class="active"' : '' ?>><a href="#nav-higher-education" aria-controls="nav-higher-education" role="tab" data-toggle="tab">Higher Education</a></li>
          <!--<li class="btn-customize">
            <a href="#" data-toggle="modal" data-target="#customizeModal" class="btn btn-alt">Customize Content</a>
          </li>-->
        </ul>
      
        <!-- Tab panes -->
        <div class="tab-content">
          <?php $grades = $WWItems::GetGrades() ?>
          <?php foreach ($grades as $grade_name => $subgrades): ?>
          <div role="tabpanel" class="tab-pane <?php echo $WWItems::$grade_name == $grade_name ? 'active' : '' ?>" id="nav-<?php echo $grade_name ?>">
            <ul>
              <?php foreach ($subgrades as $subgrade_id => $subgrade_name): ?>
              <li class="<?php echo $subgrade_id == $WWItems::$subgrade_id ? 'active' : '' ?>"><a href="/explore/<?php echo $subgrade_name ?>/"><?php echo strtoupper($subgrade_name) ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endforeach; ?>
          
        </div><!-- /tab-content -->
        
      </div>
      
    </section><!-- /lo-navigation -->