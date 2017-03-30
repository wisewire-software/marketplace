<?php
/**
 * Template Name: Filtered
 */

session_start();

require get_template_directory() . "/Controller/Filtered.php";

$control = new Controller_Filtered();

?>
  
<?php get_header(); ?> 

<div id="explore-body">
    
    <?php get_template_part('parts/grades', 'explorenavigation'.(WiseWireApi::get_option('gradelevels_nav') == 'full' ? '' : '_1')); ?>
    
    <!-- Hidden on <768px -->
    
    <div class="">
      
      <div class="container">
        
        <div class="items">

          <div class="row row-head">
            
            <div class="col-sm-6 col-headline<?php if (!$control->search) echo ' col-uppercase'; ?>">
              <h1>
				      
              </h1>
              <p>
                <?php echo $control->posts_count ?> items in this category
                <span class="ajax-loading small"></span>
                <?php if ( $active_filters = $control->display_active_filters() ) { ?>
                <br>
                <a href="?clear_filters=1" class="btn-filters-clear">Clear filters</a>
                <?php } ?>          
              </p>
            </div>
            
            <div class="col-sm-6">
              
              <div class="options">
                
                <div class="rank">
                  <p>
                    RANK BY
                  </p>
                  <select name="order_by" class="form-control select filter-order-by">
                    <option value="">Popularity</option>
                    <option value="most_recent" <?php echo $control->order_by === 'most_recent' ? 'selected' : '' ?>>
						Most recent</option>
                  </select>
                  <div class="items">
                    <div class="filters">
                      <a href="#" class="btn-filter" id="btn-filters-overlay-open">Filter</a>                  
                      <select name="order_by" class="form-control select filter-order-by small">
                        <option value="">Rank By Popularity</option>
                        <option value="most_recent" <?php echo $control->order_by === 'most_recent' ? 'selected' : '' ?>>Rank by Most recent</option>
                      </select>
                    </div>
                  </div>
                </div>
                
                <div class="grid">
                  <p>View</p>
                  <a href="#" class="btn-grid <?php echo $control->list_view === 'grid' ? 'active' : '' ?>" id="btn-view-grid"></a>
                  <a href="#" class="btn-list <?php echo $control->list_view === 'list' ? 'active' : '' ?>" id="btn-view-list"></a>
                </div>
                
              </div><!-- /options -->
              
            </div>
            
          </div><!-- /row -->
          
          <div class="row">
            <div class="filters-overlay" id="filters-overlay">
            <div class="col-sm-3 col-nav">            
                <div class="col-headline<?php if (!$control->search) echo ' col-uppercase'; ?>">
                   <h1>
            Most Viewed
                  </h1>
                  <p>
                    <?php echo $control->posts_count ?> items in this category
                    <span class="ajax-loading small small"></span>
                    <?php if ( $active_filters = $control->display_active_filters() ) { ?>
                    <br>
                    <a href="?clear_filters=1" class="btn-filters-clear">Clear filters</a>
                    <?php } ?>          
                  </p>             
                </div>     

              <div class="nav-head">
                <p>
                  Filter by<span class="ajax-loading"></span>
                </p>
              </div>
              
              <!-- 
                Basically the same code for desktop and mobile 
                IDs needs to be changed so they are not the same
                There is also additional Done button on the mobile view on the bottom of accordion
              -->  
              
              <div class="accordion-filters" id="accordion-filters" role="tablist" aria-multiselectable="true">
                  
				<?php if ($control->filter_grades['']): ?>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-heading-0">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterPanel0" aria-expanded="true" aria-controls="filterPanel0" class="collapsed">
                        Grade Level
                      </a>
                    </h1>
                  </div>
                  <div id="filterPanel0" class="panel-collapse collapse <?php echo $control->filter_requested('gradelevel') ? 'in' : '' ?>" role="tabpanel" aria-labelledby="filters-heading-0">
					<div class="panel-body panel-grades">
                      <ul>
                    <?php $grades = $WWItems->GetGrades(); ?>
                    <?php foreach ($grades as $grade_parent => $subgrades): if (isset($control->filter_grades[''][$grade_parent])): ?>
                    <li>
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#filterGradeLevel" href="#<?php echo $grade_parent ?>Nav" aria-expanded="true" aria-controls="<?php echo $grade_parent ?>Nav"><?php echo $control->filter_grades[''][$grade_parent]['name'] ?></a><span><?php //echo $grade_parent_data['count'] ?></span>
                        <ul id="<?php echo $grade_parent ?>Nav" class="panel-collapse collapse <?php echo $control->filter_grades[''][$grade_parent]['open'] ? 'in' : '' ?>" role="tabpanel">
                        <?php foreach ($subgrades as $subgrade_id => $subgrade_name): if (isset($control->filter_grades[$grade_parent][$subgrade_id])): ?>
                        <li><a href="#<?php echo $subgrade_id ?>" data-filter="gradelevel" class="filter <?php echo in_array($subgrade_id, $control->filters['gradelevel']) ? 'active' : '' ?>"><?php echo $control->filter_grades[$grade_parent][$subgrade_id]['name'] ?></a><span><?php echo $control->filter_grades[$grade_parent][$subgrade_id]['count'] ?></span></li>
                        <?php endif; endforeach; ?>
                        </ul>
                      </li> 
                    <?php endif; endforeach; ?>
                    <?php /*foreach ($control->filter_grades[''] as $grade_parent => $grade_parent_data): ?>
                      <li>
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#filterGradeLevel" href="#<?php echo $grade_parent ?>Nav-mobile" aria-expanded="true" aria-controls="<?php echo $grade_parent ?>Nav"><?php echo $grade_parent_data['name'] ?></a><span><?php //echo $grade_parent_data['count'] ?></span>
                        <ul id="<?php echo $grade_parent ?>Nav-mobile" class="panel-collapse collapse <?php echo $grade_parent_data['open'] ? 'in' : '' ?>" role="tabpanel">
                        <?php foreach ($control->filter_grades[$grade_parent] as $v): ?>
                        <li><a href="#<?php echo $v['term_id'] ?>" data-filter="gradelevel" class="filter <?php echo in_array($v['term_id'], $control->filters['gradelevel']) ? 'active' : '' ?>"><?php echo $v['name'] ?></a><span><?php echo $v['count'] ?></span></li>
                        <?php endforeach; ?>
                        </ul>
                      </li> 
                      <?php endforeach;*/ ?>
                    </ul>
                    </div>
					  
                  </div>
                </div><!-- /panel -->
				<?php endif; ?>
				  
				<?php if ($control->subdisciplines): ?>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-heading-1">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterPanel1" aria-expanded="true" aria-controls="filterPanel1" class="collapsed">
                        SUB-DISCIPLINE
                      </a>
                    </h1>
                  </div>
                  <div id="filterPanel1" class="panel-collapse collapse <?php echo $control->filter_requested('subdiscipline') ? 'in' : '' ?>" role="tabpanel" aria-labelledby="filters-heading-1">
                    <div class="panel-body">
                      <ul>
						<?php foreach ($control->subdisciplines as $v): ?>
                        <li><a href="#<?php echo $v['term_id'] ?>" data-filter="subdiscipline" class="filter <?php echo in_array($v['term_id'], $control->filters['subdiscipline']) ? 'active' : '' ?>"><?php echo $v['name'] ?></a><span><?php echo $v['count'] ?></span></li>
						<?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                </div><!-- /panel -->
				<?php endif; ?>
                                
				<?php if ($control->filter_content_types): ?>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-heading-2">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterPanel2" aria-expanded="true" aria-controls="filterPanel2" class="collapsed">
                        CONTENT TYPE
                      </a>
                    </h1>
                  </div>
                  <div id="filterPanel2" class="panel-collapse collapse <?php echo $control->filter_requested('content_type') ? 'in' : '' ?>" role="tabpanel" aria-labelledby="filters-heading-2">
                    <div class="panel-body">
                      <ul>
                       <?php foreach ($control->filter_content_types as $v): ?>
                        <li><a href="#<?php echo $v['value'] ?>" data-filter="content_type" class="filter <?php echo in_array($v['value'], $control->filters['content_type']) ? 'active' : '' ?>"><?php echo $v['value'] ?></a><span><?php echo $v['count'] ?></span></li>
						<?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                </div><!-- /panel -->
				<?php endif; ?>
                
				<?php if ($control->filter_object_types): ?>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-heading-3">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterPanel3" aria-expanded="true" aria-controls="filterPanel3" class="collapsed">
                        OBJECT TYPE
                      </a>
                    </h1>
                  </div>
                  <div id="filterPanel3" class="panel-collapse collapse <?php echo $control->filter_requested('object_type') ? 'in' : '' ?>" role="tabpanel" aria-labelledby="filters-heading-3">
                    <div class="panel-body">
                      <ul>
                        <?php foreach ($control->filter_object_types as $v): ?>
                        <li><a href="#<?php echo $v['term_id'] ?>" data-filter="object_type" class="filter <?php echo in_array($v['term_id'], $control->filters['object_type']) ? 'active' : '' ?>"><?php echo $v['name'] ?></a><span><?php echo $v['count'] ?></span></li>
						<?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                </div><!-- /panel -->   
                <?php endif; ?>
				
				<?php if ($control->filter_standards): ?>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-heading-4">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterPanel4" aria-expanded="true" aria-controls="filterPanel4" class="collapsed">
                        Standards
                      </a>
                    </h1>
                  </div>
                  <div id="filterPanel4" class="panel-collapse collapse <?php echo $control->filter_requested('standard') ? 'in' : '' ?>" role="tabpanel" aria-labelledby="filters-heading-4">
                    <div class="panel-body">
                      <ul>
                        <?php foreach ($control->filter_standards as $v): ?>
                        <li><a href="#<?php echo $v['term_id'] ?>" data-filter="standard" class="filter <?php echo in_array($v['term_id'], $control->filters['standard']) ? 'active' : '' ?>"><?php echo $v['name'] ?></a><span><?php echo $v['count'] ?></span></li>
						<?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                </div><!-- /panel -->  
				<?php endif; ?>
                
				<?php if ($control->filter_contributors): ?>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-heading-5">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterPanel5" aria-expanded="true" aria-controls="filterPanel5" class="collapsed">
                        Contributors
                      </a>
                    </h1>
                  </div>
                  <div id="filterPanel5" class="panel-collapse collapse <?php echo $control->filter_requested('contributor')  ? 'in' : '' ?>" role="tabpanel" aria-labelledby="filters-heading-5">
                    <div class="panel-body">
                      <ul>
						<?php foreach ($control->filter_contributors as $v): ?>
                        <li><a href="#<?php echo $v['value'] ?>" data-filter="contributor" class="filter <?php echo in_array($v['value'], $control->filters['contributor']) ? 'active' : '' ?>"><?php echo $v['value'] ?></a><span><?php echo $v['count'] ?></span></li>
						<?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                </div><!-- /panel -->  
                <?php endif; ?>
				
				<?php if ($control->filter_dok): ?>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-heading-6">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterPanel6" aria-expanded="true" aria-controls="filterPanel6" class="collapsed">
                        Dok
                      </a>
                    </h1>
                  </div>
                  <div id="filterPanel6" class="panel-collapse collapse <?php echo $control->filter_requested('dok')  ? 'in' : '' ?>" role="tabpanel" aria-labelledby="filters-heading-6">
                    <div class="panel-body">
                      <ul>
                        <?php foreach ($control->filter_dok as $v): ?>
                        <li><a href="#<?php echo $v['value'] ?>" data-filter="dok" class="filter <?php echo in_array($v['value'], isset($control->filters['dok']) ? $control->filters['dok'] : array()) ? 'active' : '' ?>"><?php echo $v['value'] ?></a><span><?php echo $v['count'] ?></span></li>
						<?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                </div><!-- /panel -->
				<?php endif; ?>
				
				<?php if ($control->filter_ranking): ?>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-heading-7">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterPanel7" aria-expanded="true" aria-controls="filterPanel7" class="collapsed">
                        RATING
                      </a>
                    </h1>
                  </div>
                  <div id="filterPanel7" class="panel-collapse collapse <?php echo $control->filter_requested('ranking') ? 'in' : '' ?>" role="tabpanel" aria-labelledby="filters-heading-7">
                    <div class="panel-body">
                      <ul>
						<?php foreach ($control->filter_ranking as $v): ?>
						<li><a href="#<?php echo $v['value'] ?>" data-filter="ranking" class="filter side-rate <?php echo in_array($v['value'], $control->filters['ranking']) ? 'active' : '' ?>"><?php rating_display_stars($v['value'],'') ?></a><span><?php echo $v['count'] ?></span></li>
						<?php endforeach ?>
                      
                      </ul>
                    </div>
                  </div>
                </div><!-- /panel -->
        <?php endif; ?>
        
              <a href="#" class="btn btn-filters-overlay-close" id="btn-filters-overlay-close" class="btn">Done</a>
              </div><!-- /accordion-filters -->               
			 
            </div><!-- /col-nav -->
          </div>
      <div id="explore-items" class="<?php echo $control->list_view?>-layout" >
            <div class="col-sm-9 col-items" >
              
			  <?php if ( $active_filters = $control->display_active_filters() ): ?>
              <div class="selections">
                <p>
                  Your selection
                </p>
                <ul>
				  <?php echo $active_filters ?>
                </ul>
              </div>
              <?php endif; ?>
        
        <?php $items = $control->populate_posts() ?>
        
              <?php if(TRUE): #if ($control->list_view === 'grid'): ?>
              <div id="section-view-grid">
              
                <section class="lo-items">
                    
                  <div class="row row-no-margin">

					<?php if ($items): foreach ($items as $item): ?>
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
					  <?php if ($item->type == 'item'): ?>
                      <article class="lo-item lo-item-col <?php echo $WWItems->get_color($item->item_content_type_icon) ?>" onclick="location.href='<?php echo get_permalink($item) ?>';">
                        <div class="img">
                        <?php
                        $item_main_image = get_field('item_main_image', $item->ID);
                        if ($item_main_image):
                          $size = "thumbnail"; 
                          $image = wp_get_attachment_image_src( $item_main_image, $size );
                        ?>
                        <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive" />
                        <?php else: ?>
          							<?php echo $WWItems->get_thumbnail($item->item_content_type_icon) ?>
          						  <?php endif ?>
						  
                         <?php if (substr($item->item_preview,0,1) === 'Y'): ?>
						  <div class="ribbon"><span class="icon"></span> Preview</div>
						  <?php endif; ?>
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              <?php echo $WWItems->get_subdiscipline($item->ID) ?>
                              <?php if (substr($item->item_preview,0,1) === 'Y'): ?>
                              <div class="ribbon ribbon-list-layout"><span class="icon"></span> Preview</div>
                              <?php endif; ?>
                            </h2>
                            <p class="content-type">
                              <?php echo $item->item_content_type_icon ?>
                            </p>
                            <p class="grade-level">
                              <?php //echo $WWItems->get_grades($item->ID) ?>
                            </p>
                          </div>
                          <div class="more-info">
                            <div class="content-title">
                              <h1><?php echo $item->post_title ?></h1>
                              <div class="content-type-icon">
                                <svg class="svg-<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>-dims">
                                  <use xlink:href="#<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>"></use>
                                </svg>
                              </div>
                            </div>
                            <div class="rate rate-list-layout">
                              <?php rating_display_stars($item->item_ratings,'') ?>
                              <p class="number">
                                <?php echo $item->item_ratings ? $item->item_ratings : '' ?>
                              </p>
                            </div> 
                          </div>
                          <div class="lo-info lo-info-list-layout">
                            <div class="date-rate">
                              <p class="date">
                                <?php if ($item->item_publish_date): ?>
                                <?php echo date_i18n( 'm-d-Y', strtotime( $item->item_publish_date ) ); ?>
                                <?php endif; ?>
                              </p>
                              <p class="object-type">
                                <?php echo ucfirst($item->item_object_type) ?>
                              </p>                      
                            </div>
                          </div>
                          <?php if (substr($item->item_preview,0,1) === 'Y'): ?>
                          <div class="ribbon ribbon-list-layout-small"><span class="icon"></span> Preview</div>
                          <?php endif; ?>  
                        </div>
                      </article>
                      
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
							  
							<?php if ($item->item_publish_date): ?>
                            <?php echo date_i18n( 'm-d-Y', strtotime( $item->item_publish_date ) ); ?>
							<?php endif; ?>
							  
                          </p>
                          <div class="rate">
                            <?php rating_display_stars($item->item_ratings,'') ?>
                            <p class="number">
                              <?php echo $item->item_ratings ? $item->item_ratings : '' ?>
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
						  <?php echo implode(', ',wp_get_post_terms($item->ID, 'ObjectType', array("fields" => "names"))) ?>
                        </p>
                      </div>
						
					  <?php else: // type!=item ?>
						
					  <article class="lo-item lo-item-col <?php echo $WWItems->get_color($item->item_content_type_icon) ?>" onclick="location.href='/item/<?php echo $item->ID ?>/';">
                        <div class="img">
                        <?php
                        $item_main_image = get_field('item_main_image', $item->ID);
                        if ($item_main_image):
                          $size = "thumbnail"; 
                          $image = wp_get_attachment_image_src( $item_main_image, $size );
                        ?>
                        <img alt="" src="<?php echo $image[0]; ?>" class="img-responsive" />
                        <?php else: ?>
        							<?php echo $WWItems->get_thumbnail($item->item_content_type_icon) ?>
        						  <?php endif ?>
						  
                          <?php if (substr($item->item_preview,0,1) === 'Y'): ?>
						  <div class="ribbon"><span class="icon"></span> Preview</div>
						  <?php endif; ?>
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              <?php echo $WWItems->get_subdiscipline($item->ID) ?>
                              <?php if (substr($item->item_preview,0,1) === 'Y'): ?>
                              <div class="ribbon ribbon-list-layout"><span class="icon"></span> Preview</div>
                              <?php endif; ?>
                            </h2>
                            <p class="content-type">
                              <?php echo $item->item_content_type_icon ?>
                            </p>
                            <p class="grade-level">
                              <?php //echo $WWItems->get_grades($item->ID) ?>
                            </p>
                          </div>
                          <div class="more-info">
                            <div class="content-title">
                              <h1><?php echo $item->post_title ?></h1>
                              <div class="content-type-icon">
                                <svg class="svg-<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>-dims">
                                  <use xlink:href="#<?php echo $WWItems->get_icon($item->item_content_type_icon) ?>"></use>
                                </svg>
                              </div>
                            </div>
                            <div class="rate rate-list-layout">
                              <?php rating_display_stars($item->item_ratings,'') ?>
                              <p class="number">
                                <?php echo $item->item_ratings ? $item->item_ratings : '' ?>
                              </p>
                            </div> 
                          </div>
                          <div class="lo-info lo-info-list-layout">
                            <div class="date-rate">
                              <p class="date">
                                <?php if ($item->item_publish_date): ?>
                                <?php echo date_i18n( 'm-d-Y', strtotime( $item->item_publish_date ) ); ?>
                                <?php endif; ?>
                              </p>
                              <p class="object-type">
                                <?php echo ucfirst($item->item_object_type) ?>
                              </p>                      
                            </div>
                          </div>
                          <?php if (substr($item->item_preview,0,1) === 'Y'): ?>
                          <div class="ribbon ribbon-list-layout-small"><span class="icon"></span> Preview</div>
                          <?php endif; ?>            
                        </div>
                      </article>
                      
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
							  
							<?php if ($item->item_publish_date): ?>
                            <?php echo date_i18n( 'm-d-Y', strtotime( $item->item_publish_date ) ); ?>
							<?php endif; ?>
							  
                          </p>
                          <div class="rate">
                            <?php rating_display_stars($item->item_ratings,'') ?>
                            <p class="number">
                              <?php echo $item->item_ratings ? $item->item_ratings : '' ?>
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
						  <?php echo ucfirst($item->item_object_type) ?>
                        </p>
                      </div>
					  <?php endif; // type=pod ?>
                                        
                    </div>
					  
					<?php endforeach; else: ?>
					<div class="no-results">
						<p>Sorry, no results were found.</p>
					</div>
					<?php endif; ?>
        
                  </div><!-- /row -->
                  
                </section><!-- /lo-items -->
              
              </div><!-- /view-grid -->
			  <?php endif; ?>


			  <?php $pagination = f_paginate($control->posts_count, $control->on_page,$control->page_nr,4) ?>
			  <?php if ($control->pages_count > 1): ?>
				<nav>
				  <ul class="pagination">
					  <?php if ($control->page_nr > 1): ?>
					  <li>
						<a class="filter-page-nr" href="<?php echo $control->get_permalink() . ($control->page_nr - 1) . '/' ?>" aria-label="Previous">
						  <span aria-hidden="true">&laquo;</span>
						</a>
					  </li>
					  <?php endif; ?>
					  
        <?php foreach ($pagination as $i): ?>
          <li <?php echo $control->page_nr == $i ? 'class="active"' : '' ?>><a class="filter-page-nr" href="<?php echo $control->get_permalink() . ($i!='...'?$i:$control->page_nr) . '/' ?>"><?php echo $i ?> </a></li>
        <?php endforeach ?>
					  <?php if ($control->page_nr < $control->pages_count): ?>
					  <li >
						<a class="filter-page-nr" href="<?php echo $control->get_permalink() . ($control->page_nr + 1) . '/' ?>" aria-label="Next">
						  <span aria-hidden="true">&raquo;</span>
						</a>
					  </li>
					  <?php endif; ?>
				  </ul>
				</nav>
			  <?php endif; ?>
			  
            </div><!-- /col-items -->
			</div><!-- /#explore-items -->
            
          </div><!-- /row -->
          
        </div><!-- /items -->
      
      </div><!-- /container -->
      
    </div><!-- /hidden-xs -->

    <div class="back-to-top" id="back-to-top">
      <a href="#header" class="scroll">Back to top</a>
    </div>

</div>

<?php get_footer(); ?>