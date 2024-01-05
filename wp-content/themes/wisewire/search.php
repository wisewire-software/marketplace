<?php  wp_redirect(get_site_url()) ?>

<?php get_header(); ?>  

    <?php
      /************************
        
      Its basically copy/paste of the explore page so we can resuse a lot
      
      *************************/
    ?>
    
    
    <!-- Visible on <768px -->
    
    <div class="customize-link-mobile visible-xs-block">
      <div class="container">
        <p>
          <a href="#" data-toggle="modal" data-target="#myModal">CUSTOMIZE CONTENT ></a>
        </p>
      </div>
    </div>
    
    <!-- Visible on <768px -->
    
    <section class="nav-grades-mobile visible-xs-block">
      <div class="container">
        <p>
          ELEMENTARY: SIXTH grade
        </p>
      </div>
    </section>
    
    
    <!-- Hidden on <768px -->
    
    <section class="nav-grades hidden-xs">
      
      <div class="container">
        
        <!-- Nav tabs -->
        <ul class="lo-nav" role="tablist">
          <li role="presentation" class="active"><a href="#nav-elementary" aria-controls="nav-elementary" role="tab" data-toggle="tab">Elementary</a></li>
          <li role="presentation"><a href="#nav-middle" aria-controls="nav-middle" role="tab" data-toggle="tab">Middle</a></li>
          <li role="presentation"><a href="#nav-high-school" aria-controls="nav-high-school" role="tab" data-toggle="tab">High School</a></li>
          <li role="presentation"><a href="#nav-higher-education" aria-controls="nav-higher-education" role="tab" data-toggle="tab">Higher Education</a></li>
          <li class="btn-customize">
            <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-alt">Customize Content</a>
          </li>
        </ul>
        
      </div>
      
    </section><!-- /lo-navigation -->
    
    <!-- Hidden on <768px -->
    
    <div class="hidden-xs">
      
      <div class="container">
        
        <div class="items search-results">     
          
          <div class="row row-head">
            
            <div class="col-sm-7 col-headline">
              <h1>
                Search results: <span>Biology</span>
              </h1>
              <p>
                200 items in this category
              </p>
            </div>
            
            <div class="col-sm-5">
              
              <div class="options">
                
                <div class="rank">
                  <p>
                    RANK BY
                  </p>
                  <select class="form-control select">
                    <option value="popularity">Popularity</option>
                    <option value="mostrecent">Most recent</option>
                  </select>
                </div>
                
                <div class="grid">
                  <p>View</p>
                  <a href="#" class="btn-grid active" id="btn-view-grid"></a>
                  <a href="#" class="btn-list" id="btn-view-list"></a>
                </div>
                
              </div><!-- /options -->
              
            </div>
            
          </div><!-- /row -->
          
          <div class="row">
            
            <div class="col-sm-3 col-nav">            
                
              <div class="nav-head">
                <p>
                  Filter by
                </p>
              </div>
              
              <!-- 
                Basically the same code for desktop and mobile 
                IDs needs to be changed so they are not the same
                There is also additional Done button on the mobile view on the bottom of accordion
              -->  
              
              <div class="accordion-filters" id="accordion-filters" role="tablist" aria-multiselectable="true">
                
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-grade-level">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterGradeLevel" aria-expanded="true" aria-controls="filterGradeLevel" class="collapsed">
                        Grade Level
                      </a>
                    </h1>
                  </div>
                  <div id="filterGradeLevel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filters-grade-level">
                    <div class="panel-body panel-grades">
                      <ul>
                        <li>
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#filterGradeLevel" href="#elementaryNav" aria-expanded="true" aria-controls="elementaryNav">Elementary</a><span>62</span>
                          <ul id="elementaryNav" class="panel-collapse collapse" role="tabpanel">
                            <li><a href="#">Pre-k</a></li>
                            <li><a href="#">Kindergarten</a></li>
                            <li><a href="#" class="active">First</a></li>
                            <li><a href="#">Second</a></li>
                            <li><a href="#">Third</a></li>
                            <li><a href="#">Fourth</a></li>
                          </ul>
                        </li>
                        <li>
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#filterGradeLevel" href="#middleNav" aria-expanded="true" aria-controls="middleyNav">Middle</a><span>84</span>
                          <ul id="middleNav" class="panel-collapse collapse" role="tabpanel">
                            <li><a href="#">Filter 1</a></li>
                            <li><a href="#">Filter 2</a></li>
                            <li><a href="#">Filter 3</a></li>
                            <li><a href="#">Filter 4</a></li>
                            <li><a href="#">Filter 5</a></li>
                          </ul>
                        </li>
                        <li>
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#filterGradeLevel" href="#highNav" aria-expanded="true" aria-controls="highNav">High School</a><span>24</span>
                          <ul id="highNav" class="panel-collapse collapse" role="tabpanel">
                            <li><a href="#">Filter 1</a></li>
                            <li><a href="#">Filter 2</a></li>
                            <li><a href="#">Filter 3</a></li>
                            <li><a href="#">Filter 4</a></li>
                            <li><a href="#">Filter 5</a></li>
                          </ul>
                        </li>
                        <li>
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#filterGradeLevel" href="#higherNav" aria-expanded="true" aria-controls="higherNav">Higher Education</a><span>48</span>
                          <ul id="higherNav" class="panel-collapse collapse" role="tabpanel">
                            <li><a href="#">Filter 1</a></li>
                            <li><a href="#">Filter 2</a></li>
                            <li><a href="#">Filter 3</a></li>
                            <li><a href="#">Filter 4</a></li>
                            <li><a href="#">Filter 5</a></li>
                          </ul>
                        </li>                                                
                      </ul>
                    </div>
                  </div>
                </div><!-- /panel --> 
                                
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-heading-1">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterPanel1" aria-expanded="true" aria-controls="filterPanel1" class="collapsed">
                        SUB-DISCIPLINE
                      </a>
                    </h1>
                  </div>
                  <div id="filterPanel1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filters-heading-1">
                    <div class="panel-body">
                      <ul>
                        <li><a href="#" class="active">Civics</a></li>
                        <li><a href="#">Economics</a><span>67</span></li>
                        <li><a href="#">Geography</a><span>23</span></li>
                        <li><a href="#">Government</a><span>39</span></li>
                        <li><a href="#">U.S. History</a><span>42</span></li>
                        <li><a href="#">World History</a><span>58</span></li>
                      </ul>
                    </div>
                  </div>
                </div><!-- /panel -->
                                
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-heading-2">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterPanel2" aria-expanded="true" aria-controls="filterPanel2" class="collapsed">
                        CONTENT TYPE
                      </a>
                    </h1>
                  </div>
                  <div id="filterPanel2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filters-heading-2">
                    <div class="panel-body">
                      <ul>
                        <li><a href="#">Activity</a><span>23</span></li>
                        <li><a href="#">App</a><span>24</span></li>
                        <li><a href="#">Assessment</a><span>5</span></li>
                        <li><a href="#">Courseware</a><span>10</span></li>
                        <li><a href="#">Tutorial</a><span>4</span></li>
                      </ul>
                    </div>
                  </div>
                </div><!-- /panel -->   
                
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-heading-3">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterPanel3" aria-expanded="true" aria-controls="filterPanel3" class="collapsed">
                        OBJECT TYPE
                      </a>
                    </h1>
                  </div>
                  <div id="filterPanel3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filters-heading-3">
                    <div class="panel-body">
                      <ul>
                        <li><a href="#">Filter 1</a><span>24</span></li>
                        <li><a href="#">Filter 2</a><span>18</span></li>
                        <li><a href="#">Lorem ipsum</a><span>2</span></li>
                      </ul>
                    </div>
                  </div>
                </div><!-- /panel -->   
                
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-heading-4">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterPanel4" aria-expanded="true" aria-controls="filterPanel4" class="collapsed">
                        Standards
                      </a>
                    </h1>
                  </div>
                  <div id="filterPanel4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filters-heading-4">
                    <div class="panel-body">
                      <ul>
                        <li><a href="#">Common Core</a><span>29</span></li>
                        <li><a href="#">Lorem ipsum</a><span>9</span></li>
                      </ul>
                    </div>
                  </div>
                </div><!-- /panel -->  
                
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-heading-5">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterPanel5" aria-expanded="true" aria-controls="filterPanel5" class="collapsed">
                        Contributors
                      </a>
                    </h1>
                  </div>
                  <div id="filterPanel5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filters-heading-5">
                    <div class="panel-body">
                      <ul>
                        <li><a href="#">Wisewire</a><span>18</span></li>
                        <li><a href="#">OpenStax</a><span>14</span></li>
                        <li><a href="#">Kaplan</a><span>2</span></li>
                        <li><a href="#">Lorem ipsum</a><span>2</span></li>
                      </ul>
                    </div>
                  </div>
                </div><!-- /panel -->  

                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="filters-heading-7">
                    <h1 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion-filters" href="#filterPanel7" aria-expanded="true" aria-controls="filterPanel7" class="collapsed">
                        RANKING
                      </a>
                    </h1>
                  </div>
                  <div id="filterPanel7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filters-heading-7">
                    <div class="panel-body">
                      <ul>
                        <li><a href="#">Filter 1</a><span>24</span></li>
                        <li><a href="#">Filter 2</a><span>18</span></li>
                        <li><a href="#">Lorem ipsum</a><span>2</span></li>
                      </ul>
                    </div>
                  </div>
                </div><!-- /panel -->                                                                                             

              </div><!-- /accordion-filters -->               
                
              
            </div><!-- /col-nav -->
            
            <div class="col-sm-9 col-items">
              
              <div class="selections">
                <p>
                  Your selection
                </p>
                <ul>
                  <li>
                    <a href="#">U.S. History</a>
                  </li>
                  <li>
                    <a href="#">Common Core</a>
                  </li>
                  <li>
                    <a href="#">Wisewire</a>
                  </li>
                </ul>
              </div>
              
              <div id="section-view-grid">
              
                <section class="lo-items">
                    
                  <div class="row row-no-margin">
                    
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
                      <article class="lo-item lo-item-col lo-content-type-1" onclick="location.href='detail.html';">
                        <div class="img">
                          <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo-featured.jpg" alt="" class="img-responsive" />
                          <div class="ribbon"><span class="icon"></span> Preview</div>
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              Biology
                            </h2>
                            <p class="content-type">
                              Assessment Module
                            </p>
                            <p class="grade-level">
                              Tenth Grade, Eleventh Grade, Twelveth Grade, Undergraduate
                            </p>
                          </div>
                          <div class="content-title">
                            <h1>Hit veliaeprerum am delores</h1>
                            <div class="content-type-icon">
                              <svg class="svg-icon_yellow_assessment-dims">
                                <use xlink:href="#icon_yellow_assessment"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </article>
                      
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
                            01-01-2015
                          </p>
                          <div class="rate">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                            <p class="number">
                              3.5
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
                          Multiple Choice
                        </p>
                      </div>
                                        
                    </div>
                    
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
                      <article class="lo-item lo-item-col lo-content-type-3" onclick="location.href='detail.html';">
                        <div class="img">
                          <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo-featured.jpg" alt="" class="img-responsive" />
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              Biology
                            </h2>
                            <p class="content-type">
                              Assessment Module
                            </p>
                            <p class="grade-level">
                              Tenth Grade, Eleventh Grade, Twelveth Grade, Undergraduate
                            </p>
                          </div>
                          <div class="content-title">
                            <h1>Hit veliaeprerum am delores</h1>
                            <div class="content-type-icon">
                              <svg class="svg-icon_yellow_assessment-dims">
                                <use xlink:href="#icon_yellow_assessment"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </article>
                                    
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
                            01-01-2015
                          </p>
                          <div class="rate">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                            <p class="number">
                              3.5
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
                          Multiple Choice
                        </p>
                      </div>
                                                      
                    </div>         
                                
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
                      <article class="lo-item lo-item-col lo-content-type-1" onclick="location.href='detail.html';">
                        <div class="img">
                          <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo/default_yellow_module.png" alt="" class="img-responsive" />
                          <div class="ribbon"><span class="icon"></span> Preview</div>
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              Biology
                            </h2>
                            <p class="content-type">
                              Assessment Module
                            </p>
                            <p class="grade-level">
                              Tenth Grade, Eleventh Grade, Twelveth Grade, Undergraduate
                            </p>
                          </div>
                          <div class="content-title">
                            <h1>Hit veliaeprerum am delores</h1>
                            <div class="content-type-icon">
                              <svg class="svg-icon_yellow_assessment-dims">
                                <use xlink:href="#icon_yellow_assessment"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </article>
                      
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
                            01-01-2015
                          </p>
                          <div class="rate">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                            <p class="number">
                              3.5
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
                          Game-based<br> learning
                        </p>
                      </div>
                                        
                    </div>
                    
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
                      <article class="lo-item lo-item-col lo-content-type-3" onclick="location.href='detail.html';">
                        <div class="img">
                          <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo-featured.jpg" alt="" class="img-responsive" />
                          <div class="ribbon"><span class="icon"></span> Preview</div>
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              Biology
                            </h2>
                            <p class="content-type">
                              Coursework Module
                            </p>
                            <p class="grade-level">
                              Tenth Grade, Eleventh Grade, Twelveth Grade, Undergraduate
                            </p>
                          </div>
                          <div class="content-title">
                            <h1>Hit veliaeprerum am delores</h1>
                            <div class="content-type-icon">
                              <svg class="svg-icon_blue_coursework-dims">
                                <use xlink:href="#icon_blue_coursework"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </article>
                                    
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
                            01-01-2015
                          </p>
                          <div class="rate">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                            <p class="number">
                              3.5
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
                          Multiple Choice
                        </p>
                      </div>
                                                      
                    </div>         
                    
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
                      <article class="lo-item lo-item-col lo-content-type-1" onclick="location.href='detail.html';">
                        <div class="img">
                          <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo-featured.jpg" alt="" class="img-responsive" />
                          <div class="ribbon"><span class="icon"></span> Preview</div>
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              Biology
                            </h2>
                            <p class="content-type">
                              Assessment Module
                            </p>
                            <p class="grade-level">
                              Tenth Grade, Eleventh Grade, Twelveth Grade, Undergraduate
                            </p>
                          </div>
                          <div class="content-title">
                            <h1>Hit veliaeprerum am delores</h1>
                            <div class="content-type-icon">
                              <svg class="svg-icon_yellow_assessment-dims">
                                <use xlink:href="#icon_yellow_assessment"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </article>
                      
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
                            01-01-2015
                          </p>
                          <div class="rate">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                            <p class="number">
                              3.5
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
                          Multiple Choice
                        </p>
                      </div>
                                        
                    </div>
                    
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
                      <article class="lo-item lo-item-col lo-content-type-3" onclick="location.href='detail.html';">
                        <div class="img">
                          <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo-featured.jpg" alt="" class="img-responsive" />
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              Biology
                            </h2>
                            <p class="content-type">
                              Assessment Module
                            </p>
                            <p class="grade-level">
                              Tenth Grade, Eleventh Grade, Twelveth Grade, Undergraduate
                            </p>
                          </div>
                          <div class="content-title">
                            <h1>Hit veliaeprerum am delores</h1>
                            <div class="content-type-icon">
                              <svg class="svg-icon_yellow_assessment-dims">
                                <use xlink:href="#icon_yellow_assessment"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </article>
                                    
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
                            01-01-2015
                          </p>
                          <div class="rate">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                            <p class="number">
                              3.5
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
                          Multiple Choice
                        </p>
                      </div>
                                                      
                    </div>         
                                
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
                      <article class="lo-item lo-item-col lo-content-type-1" onclick="location.href='detail.html';">
                        <div class="img">
                          <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo/default_yellow_module.png" alt="" class="img-responsive" />
                          <div class="ribbon"><span class="icon"></span> Preview</div>
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              Biology
                            </h2>
                            <p class="content-type">
                              Assessment Module
                            </p>
                            <p class="grade-level">
                              Tenth Grade, Eleventh Grade, Twelveth Grade, Undergraduate
                            </p>
                          </div>
                          <div class="content-title">
                            <h1>Hit veliaeprerum am delores</h1>
                            <div class="content-type-icon">
                              <svg class="svg-icon_yellow_assessment-dims">
                                <use xlink:href="#icon_yellow_assessment"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </article>
                      
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
                            01-01-2015
                          </p>
                          <div class="rate">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                            <p class="number">
                              3.5
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
                          Game-based<br> learning
                        </p>
                      </div>
                                        
                    </div>
                    
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
                      <article class="lo-item lo-item-col lo-content-type-1" onclick="location.href='detail.html';">
                        <div class="img">
                          <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo-featured.jpg" alt="" class="img-responsive" />
                          <div class="ribbon"><span class="icon"></span> Preview</div>
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              Biology
                            </h2>
                            <p class="content-type">
                              Assessment Module
                            </p>
                            <p class="grade-level">
                              Tenth Grade, Eleventh Grade, Twelveth Grade, Undergraduate
                            </p>
                          </div>
                          <div class="content-title">
                            <h1>Hit veliaeprerum am delores</h1>
                            <div class="content-type-icon">
                              <svg class="svg-icon_yellow_assessment-dims">
                                <use xlink:href="#icon_yellow_assessment"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </article>
                      
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
                            01-01-2015
                          </p>
                          <div class="rate">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                            <p class="number">
                              3.5
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
                          Multiple Choice
                        </p>
                      </div>
                                        
                    </div>
                    
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
                      <article class="lo-item lo-item-col lo-content-type-3" onclick="location.href='detail.html';">
                        <div class="img">
                          <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo-featured.jpg" alt="" class="img-responsive" />
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              Biology
                            </h2>
                            <p class="content-type">
                              Assessment Module
                            </p>
                            <p class="grade-level">
                              Tenth Grade, Eleventh Grade, Twelveth Grade, Undergraduate
                            </p>
                          </div>
                          <div class="content-title">
                            <h1>Hit veliaeprerum am delores</h1>
                            <div class="content-type-icon">
                              <svg class="svg-icon_yellow_assessment-dims">
                                <use xlink:href="#icon_yellow_assessment"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </article>
                                    
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
                            01-01-2015
                          </p>
                          <div class="rate">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                            <p class="number">
                              3.5
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
                          Multiple Choice
                        </p>
                      </div>
                                                      
                    </div>         
                                
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
                      <article class="lo-item lo-item-col lo-content-type-1" onclick="location.href='detail.html';">
                        <div class="img">
                          <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo/default_yellow_module.png" alt="" class="img-responsive" />
                          <div class="ribbon"><span class="icon"></span> Preview</div>
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              Biology
                            </h2>
                            <p class="content-type">
                              Assessment Module
                            </p>
                            <p class="grade-level">
                              Tenth Grade, Eleventh Grade, Twelveth Grade, Undergraduate
                            </p>
                          </div>
                          <div class="content-title">
                            <h1>Hit veliaeprerum am delores</h1>
                            <div class="content-type-icon">
                              <svg class="svg-icon_yellow_assessment-dims">
                                <use xlink:href="#icon_yellow_assessment"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </article>
                      
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
                            01-01-2015
                          </p>
                          <div class="rate">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                            <p class="number">
                              3.5
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
                          Game-based<br> learning
                        </p>
                      </div>
                                        
                    </div>
                    
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
                      <article class="lo-item lo-item-col lo-content-type-3" onclick="location.href='detail.html';">
                        <div class="img">
                          <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo-featured.jpg" alt="" class="img-responsive" />
                          <div class="ribbon"><span class="icon"></span> Preview</div>
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              Biology
                            </h2>
                            <p class="content-type">
                              Coursework Module
                            </p>
                            <p class="grade-level">
                              Tenth Grade, Eleventh Grade, Twelveth Grade, Undergraduate
                            </p>
                          </div>
                          <div class="content-title">
                            <h1>Hit veliaeprerum am delores</h1>
                            <div class="content-type-icon">
                              <svg class="svg-icon_blue_coursework-dims">
                                <use xlink:href="#icon_blue_coursework"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </article>
                                    
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
                            01-01-2015
                          </p>
                          <div class="rate">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                            <p class="number">
                              3.5
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
                          Multiple Choice
                        </p>
                      </div>
                                                      
                    </div>         
                    
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
                      <article class="lo-item lo-item-col lo-content-type-1" onclick="location.href='detail.html';">
                        <div class="img">
                          <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo-featured.jpg" alt="" class="img-responsive" />
                          <div class="ribbon"><span class="icon"></span> Preview</div>
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              Biology
                            </h2>
                            <p class="content-type">
                              Assessment Module
                            </p>
                            <p class="grade-level">
                              Tenth Grade, Eleventh Grade, Twelveth Grade, Undergraduate
                            </p>
                          </div>
                          <div class="content-title">
                            <h1>Hit veliaeprerum am delores</h1>
                            <div class="content-type-icon">
                              <svg class="svg-icon_yellow_assessment-dims">
                                <use xlink:href="#icon_yellow_assessment"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </article>
                      
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
                            01-01-2015
                          </p>
                          <div class="rate">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                            <p class="number">
                              3.5
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
                          Multiple Choice
                        </p>
                      </div>
                                        
                    </div>
                    
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
                      <article class="lo-item lo-item-col lo-content-type-3" onclick="location.href='detail.html';">
                        <div class="img">
                          <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo-featured.jpg" alt="" class="img-responsive" />
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              Biology
                            </h2>
                            <p class="content-type">
                              Assessment Module
                            </p>
                            <p class="grade-level">
                              Tenth Grade, Eleventh Grade, Twelveth Grade, Undergraduate
                            </p>
                          </div>
                          <div class="content-title">
                            <h1>Hit veliaeprerum am delores</h1>
                            <div class="content-type-icon">
                              <svg class="svg-icon_yellow_assessment-dims">
                                <use xlink:href="#icon_yellow_assessment"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </article>
                                    
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
                            01-01-2015
                          </p>
                          <div class="rate">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                            <p class="number">
                              3.5
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
                          Multiple Choice
                        </p>
                      </div>
                                                      
                    </div>         
                                
                    <div class="col-sm-6 col-md-4 col-no-space col-2-next col-wrapper">
                      
                      <article class="lo-item lo-item-col lo-content-type-1" onclick="location.href='detail.html';">
                        <div class="img">
                          <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo/default_yellow_module.png" alt="" class="img-responsive" />
                          <div class="ribbon"><span class="icon"></span> Preview</div>
                        </div>
                        <div class="content">
                          <div class="details">
                            <h2 class="sub-discipline">
                              Biology
                            </h2>
                            <p class="content-type">
                              Assessment Module
                            </p>
                            <p class="grade-level">
                              Tenth Grade, Eleventh Grade, Twelveth Grade, Undergraduate
                            </p>
                          </div>
                          <div class="content-title">
                            <h1>Hit veliaeprerum am delores</h1>
                            <div class="content-type-icon">
                              <svg class="svg-icon_yellow_assessment-dims">
                                <use xlink:href="#icon_yellow_assessment"></use>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </article>
                      
                      <div class="lo-info lo-info-outside">
                        <div class="date-rate">
                          <p class="date">
                            01-01-2015
                          </p>
                          <div class="rate">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                            <p class="number">
                              3.5
                            </p>
                          </div>
                        </div>
                        <p class="object-type">
                          Game-based<br> learning
                        </p>
                      </div>
                                        
                    </div>    
                                  
                  </div><!-- /row -->
                  
                </section><!-- /lo-items -->
              
              </div><!-- /view-grid -->
              
              
              <div id="section-view-list" class="section-view-list" style="display: none;">
                
                <article class="lo-item lo-list-view lo-content-type-2" onclick="location.href='detail.html';">
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        Biology
                        <div class="ribbon"><span class="icon"></span> Preview</div>
                      </h2>
                      <p class="content-type">
                        Textbook Module 
                      </p>
                      <p class="grade-level">
                        Tenth Grade, Eleventh Grade 
                      </p>
                    </div>
                    <div class="more-info">
                      <div class="content-title">
                        <h1>Hit veliaeprerum am delores</h1>
                        <div class="content-type-icon">
                          <svg class="svg-icon_blue_textbook-dims">
                            <use xlink:href="#icon_blue_textbook"></use>
                          </svg>
                        </div>
                      </div>
                      <div class="rate">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                        <p class="number">
                          3.5
                        </p>
                      </div>                    
                    </div>
                    <div class="lo-info">
                      <div class="date-rate">
                        <p class="date">
                          01-01-2015
                        </p>
                        <p class="object-type">
                          Question/Answer
                        </p>                      
                      </div>
                    </div>                  
                  </div>
                </article>
                
                <article class="lo-item lo-list-view lo-content-type-3" onclick="location.href='detail.html';">
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        Biology
                      </h2>
                      <p class="content-type">
                        Courseware Module
                      </p>
                      <p class="grade-level">
                        Tenth Grade, Eleventh Grade
                      </p>
                    </div>
                    <div class="more-info">
                      <div class="content-title">
                        <h1>Hit veliaeprerum am delores</h1>
                        <div class="content-type-icon">
                          <svg class="svg-icon_blue_coursework-dims">
                            <use xlink:href="#icon_blue_coursework"></use>
                          </svg>
                        </div>
                      </div>
                      <div class="rate">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                        <p class="number">
                          3.5
                        </p>
                      </div>                    
                    </div>
                    <div class="lo-info">
                      <div class="date-rate">
                        <p class="date">
                          01-01-2015
                        </p>
                        <p class="object-type">
                          Game-based learning
                        </p>                      
                      </div>
                    </div>                  
                  </div>
                </article>
              
                <article class="lo-item lo-list-view lo-content-type-2" onclick="location.href='detail.html';">
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        Biology
                        <div class="ribbon"><span class="icon"></span> Preview</div>
                      </h2>
                      <p class="content-type">
                        Textbook Module 
                      </p>
                      <p class="grade-level">
                        Tenth Grade, Eleventh Grade 
                      </p>
                    </div>
                    <div class="more-info">
                      <div class="content-title">
                        <h1>Hit veliaeprerum am delores</h1>
                        <div class="content-type-icon">
                          <svg class="svg-icon_blue_textbook-dims">
                            <use xlink:href="#icon_blue_textbook"></use>
                          </svg>
                        </div>
                      </div>
                      <div class="rate">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                        <p class="number">
                          3.5
                        </p>
                      </div>                    
                    </div>
                    <div class="lo-info">
                      <div class="date-rate">
                        <p class="date">
                          01-01-2015
                        </p>
                        <p class="object-type">
                          Question/Answer
                        </p>                      
                      </div>
                    </div>                  
                  </div>
                </article>
                
                <article class="lo-item lo-list-view lo-content-type-3" onclick="location.href='detail.html';">
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        Biology
                      </h2>
                      <p class="content-type">
                        Courseware Module
                      </p>
                      <p class="grade-level">
                        Tenth Grade, Eleventh Grade
                      </p>
                    </div>
                    <div class="more-info">
                      <div class="content-title">
                        <h1>Hit veliaeprerum am delores</h1>
                        <div class="content-type-icon">
                          <svg class="svg-icon_blue_coursework-dims">
                            <use xlink:href="#icon_blue_coursework"></use>
                          </svg>
                        </div>
                      </div>
                      <div class="rate">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                        <p class="number">
                          3.5
                        </p>
                      </div>                    
                    </div>
                    <div class="lo-info">
                      <div class="date-rate">
                        <p class="date">
                          01-01-2015
                        </p>
                        <p class="object-type">
                          Game-based learning
                        </p>                      
                      </div>
                    </div>                  
                  </div>
                </article>
                
                <article class="lo-item lo-list-view lo-content-type-2" onclick="location.href='detail.html';">
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        Biology
                        <div class="ribbon"><span class="icon"></span> Preview</div>
                      </h2>
                      <p class="content-type">
                        Textbook Module 
                      </p>
                      <p class="grade-level">
                        Tenth Grade, Eleventh Grade 
                      </p>
                    </div>
                    <div class="more-info">
                      <div class="content-title">
                        <h1>Hit veliaeprerum am delores</h1>
                        <div class="content-type-icon">
                          <svg class="svg-icon_blue_textbook-dims">
                            <use xlink:href="#icon_blue_textbook"></use>
                          </svg>
                        </div>
                      </div>
                      <div class="rate">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                        <p class="number">
                          3.5
                        </p>
                      </div>                    
                    </div>
                    <div class="lo-info">
                      <div class="date-rate">
                        <p class="date">
                          01-01-2015
                        </p>
                        <p class="object-type">
                          Question/Answer
                        </p>                      
                      </div>
                    </div>                  
                  </div>
                </article>
                
                <article class="lo-item lo-list-view lo-content-type-3" onclick="location.href='detail.html';">
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        Biology
                      </h2>
                      <p class="content-type">
                        Courseware Module
                      </p>
                      <p class="grade-level">
                        Tenth Grade, Eleventh Grade
                      </p>
                    </div>
                    <div class="more-info">
                      <div class="content-title">
                        <h1>Hit veliaeprerum am delores</h1>
                        <div class="content-type-icon">
                          <svg class="svg-icon_blue_coursework-dims">
                            <use xlink:href="#icon_blue_coursework"></use>
                          </svg>
                        </div>
                      </div>
                      <div class="rate">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                        <p class="number">
                          3.5
                        </p>
                      </div>                    
                    </div>
                    <div class="lo-info">
                      <div class="date-rate">
                        <p class="date">
                          01-01-2015
                        </p>
                        <p class="object-type">
                          Game-based learning
                        </p>                      
                      </div>
                    </div>                  
                  </div>
                </article>
                
                <article class="lo-item lo-list-view lo-content-type-2" onclick="location.href='detail.html';">
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        Biology
                        <div class="ribbon"><span class="icon"></span> Preview</div>
                      </h2>
                      <p class="content-type">
                        Textbook Module 
                      </p>
                      <p class="grade-level">
                        Tenth Grade, Eleventh Grade 
                      </p>
                    </div>
                    <div class="more-info">
                      <div class="content-title">
                        <h1>Hit veliaeprerum am delores</h1>
                        <div class="content-type-icon">
                          <svg class="svg-icon_blue_textbook-dims">
                            <use xlink:href="#icon_blue_textbook"></use>
                          </svg>
                        </div>
                      </div>
                      <div class="rate">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                        <p class="number">
                          3.5
                        </p>
                      </div>                    
                    </div>
                    <div class="lo-info">
                      <div class="date-rate">
                        <p class="date">
                          01-01-2015
                        </p>
                        <p class="object-type">
                          Question/Answer
                        </p>                      
                      </div>
                    </div>                  
                  </div>
                </article>
                
                <article class="lo-item lo-list-view lo-content-type-3" onclick="location.href='detail.html';">
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        Biology
                      </h2>
                      <p class="content-type">
                        Courseware Module
                      </p>
                      <p class="grade-level">
                        Tenth Grade, Eleventh Grade
                      </p>
                    </div>
                    <div class="more-info">
                      <div class="content-title">
                        <h1>Hit veliaeprerum am delores</h1>
                        <div class="content-type-icon">
                          <svg class="svg-icon_blue_coursework-dims">
                            <use xlink:href="#icon_blue_coursework"></use>
                          </svg>
                        </div>
                      </div>
                      <div class="rate">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                        <p class="number">
                          3.5
                        </p>
                      </div>                    
                    </div>
                    <div class="lo-info">
                      <div class="date-rate">
                        <p class="date">
                          01-01-2015
                        </p>
                        <p class="object-type">
                          Game-based learning
                        </p>                      
                      </div>
                    </div>                  
                  </div>
                </article>
                
                <article class="lo-item lo-list-view lo-content-type-2" onclick="location.href='detail.html';">
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        Biology
                        <div class="ribbon"><span class="icon"></span> Preview</div>
                      </h2>
                      <p class="content-type">
                        Textbook Module 
                      </p>
                      <p class="grade-level">
                        Tenth Grade, Eleventh Grade 
                      </p>
                    </div>
                    <div class="more-info">
                      <div class="content-title">
                        <h1>Hit veliaeprerum am delores</h1>
                        <div class="content-type-icon">
                          <svg class="svg-icon_blue_textbook-dims">
                            <use xlink:href="#icon_blue_textbook"></use>
                          </svg>
                        </div>
                      </div>
                      <div class="rate">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                        <p class="number">
                          3.5
                        </p>
                      </div>                    
                    </div>
                    <div class="lo-info">
                      <div class="date-rate">
                        <p class="date">
                          01-01-2015
                        </p>
                        <p class="object-type">
                          Question/Answer
                        </p>                      
                      </div>
                    </div>                  
                  </div>
                </article>
                
                <article class="lo-item lo-list-view lo-content-type-3" onclick="location.href='detail.html';">
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        Biology
                      </h2>
                      <p class="content-type">
                        Courseware Module
                      </p>
                      <p class="grade-level">
                        Tenth Grade, Eleventh Grade
                      </p>
                    </div>
                    <div class="more-info">
                      <div class="content-title">
                        <h1>Hit veliaeprerum am delores</h1>
                        <div class="content-type-icon">
                          <svg class="svg-icon_blue_coursework-dims">
                            <use xlink:href="#icon_blue_coursework"></use>
                          </svg>
                        </div>
                      </div>
                      <div class="rate">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                        <p class="number">
                          3.5
                        </p>
                      </div>                    
                    </div>
                    <div class="lo-info">
                      <div class="date-rate">
                        <p class="date">
                          01-01-2015
                        </p>
                        <p class="object-type">
                          Game-based learning
                        </p>                      
                      </div>
                    </div>                  
                  </div>
                </article>
                
                <article class="lo-item lo-list-view lo-content-type-2" onclick="location.href='detail.html';">
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        Biology
                        <div class="ribbon"><span class="icon"></span> Preview</div>
                      </h2>
                      <p class="content-type">
                        Textbook Module 
                      </p>
                      <p class="grade-level">
                        Tenth Grade, Eleventh Grade 
                      </p>
                    </div>
                    <div class="more-info">
                      <div class="content-title">
                        <h1>Hit veliaeprerum am delores</h1>
                        <div class="content-type-icon">
                          <svg class="svg-icon_blue_textbook-dims">
                            <use xlink:href="#icon_blue_textbook"></use>
                          </svg>
                        </div>
                      </div>
                      <div class="rate">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                        <p class="number">
                          3.5
                        </p>
                      </div>                    
                    </div>
                    <div class="lo-info">
                      <div class="date-rate">
                        <p class="date">
                          01-01-2015
                        </p>
                        <p class="object-type">
                          Question/Answer
                        </p>                      
                      </div>
                    </div>                  
                  </div>
                </article>
                
                <article class="lo-item lo-list-view lo-content-type-3" onclick="location.href='detail.html';">
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        Biology
                      </h2>
                      <p class="content-type">
                        Courseware Module
                      </p>
                      <p class="grade-level">
                        Tenth Grade, Eleventh Grade
                      </p>
                    </div>
                    <div class="more-info">
                      <div class="content-title">
                        <h1>Hit veliaeprerum am delores</h1>
                        <div class="content-type-icon">
                          <svg class="svg-icon_blue_coursework-dims">
                            <use xlink:href="#icon_blue_coursework"></use>
                          </svg>
                        </div>
                      </div>
                      <div class="rate">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                        <p class="number">
                          3.5
                        </p>
                      </div>                    
                    </div>
                    <div class="lo-info">
                      <div class="date-rate">
                        <p class="date">
                          01-01-2015
                        </p>
                        <p class="object-type">
                          Game-based learning
                        </p>                      
                      </div>
                    </div>                  
                  </div>
                </article>
                
                <article class="lo-item lo-list-view lo-content-type-2" onclick="location.href='detail.html';">
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        Biology
                        <div class="ribbon"><span class="icon"></span> Preview</div>
                      </h2>
                      <p class="content-type">
                        Textbook Module 
                      </p>
                      <p class="grade-level">
                        Tenth Grade, Eleventh Grade 
                      </p>
                    </div>
                    <div class="more-info">
                      <div class="content-title">
                        <h1>Hit veliaeprerum am delores</h1>
                        <div class="content-type-icon">
                          <svg class="svg-icon_blue_textbook-dims">
                            <use xlink:href="#icon_blue_textbook"></use>
                          </svg>
                        </div>
                      </div>
                      <div class="rate">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                        <p class="number">
                          3.5
                        </p>
                      </div>                    
                    </div>
                    <div class="lo-info">
                      <div class="date-rate">
                        <p class="date">
                          01-01-2015
                        </p>
                        <p class="object-type">
                          Question/Answer
                        </p>                      
                      </div>
                    </div>                  
                  </div>
                </article>
                
                <article class="lo-item lo-list-view lo-content-type-3" onclick="location.href='detail.html';">
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        Biology
                      </h2>
                      <p class="content-type">
                        Courseware Module
                      </p>
                      <p class="grade-level">
                        Tenth Grade, Eleventh Grade
                      </p>
                    </div>
                    <div class="more-info">
                      <div class="content-title">
                        <h1>Hit veliaeprerum am delores</h1>
                        <div class="content-type-icon">
                          <svg class="svg-icon_blue_coursework-dims">
                            <use xlink:href="#icon_blue_coursework"></use>
                          </svg>
                        </div>
                      </div>
                      <div class="rate">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                        <p class="number">
                          3.5
                        </p>
                      </div>                    
                    </div>
                    <div class="lo-info">
                      <div class="date-rate">
                        <p class="date">
                          01-01-2015
                        </p>
                        <p class="object-type">
                          Game-based learning
                        </p>                      
                      </div>
                    </div>                  
                  </div>
                </article>                                                                                              
                
              </div><!-- /view-list -->
  
                
            </div><!-- /col-items -->
            
          </div><!-- /row -->
          
        </div><!-- /items -->
      
      </div><!-- /container -->
      
    </div><!-- /hidden-xs -->



    <!-- Visible on <768px -->
    
    <div class="visible-xs-block">
      
      <div class="items search-results">
        
        <div class="container">
          
          <div class="filters-overlay" id="filters-overlay">
            
            <div class="col-headline">
              <h1>
                Search results: <span>Biology</span>
              </h1>
              <p>
                200 items in this category
              </p>
              <a href="#" class="btn-header-filters-overlay-close" id="btn-header-filters-overlay-close"></a>
            </div> 
            
            <div class="filters">
              <a href="#" class="btn-filter" id="btn-filters-overlay-open">Filter</a>
              <select class="form-control select">
                <option value="popularity">Rank by Popularity</option>
                <option value="mostrecent">Rank by Most recent</option>
              </select>          
            </div><!-- /filters -->
          
            <!-- 
              Basically the same code for desktop and mobile 
              IDs needs to be changed so they are not the same
              There is also additional Done button on the mobile view on the bottom of accordion
            -->          
            <div class="accordion-filters" id="accordion-filters-mobile" role="tablist" aria-multiselectable="true">
              
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="filters-grade-level-mobile">
                  <h1 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion-filters-mobile" href="#filterGradeLevel-mobile" aria-expanded="true" aria-controls="filterGradeLevel-mobile" class="collapsed">
                      Grade Level
                    </a>
                  </h1>
                </div>
                <div id="filterGradeLevel-mobile" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filters-grade-level-mobile">
                  <div class="panel-body panel-grades">
                    <ul>
                      <li>
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#filterGradeLevel-mobile" href="#elementaryNav-mobile" aria-expanded="true" aria-controls="elementaryNav-mobile">Elementary</a><span>62</span>
                        <ul id="elementaryNav-mobile" class="panel-collapse collapse" role="tabpanel">
                          <li><a href="#">Pre-k</a></li>
                          <li><a href="#">Kindergarten</a></li>
                          <li><a href="#" class="active">First</a></li>
                          <li><a href="#">Second</a></li>
                          <li><a href="#">Third</a></li>
                          <li><a href="#">Fourth</a></li>
                        </ul>
                      </li>
                      <li>
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#filterGradeLevel-mobile" href="#middleNav-mobile" aria-expanded="true" aria-controls="middleyNav-mobile">Middle</a><span>84</span>
                        <ul id="middleNav-mobile" class="panel-collapse collapse" role="tabpanel">
                          <li><a href="#">Filter 1</a></li>
                          <li><a href="#">Filter 2</a></li>
                          <li><a href="#">Filter 3</a></li>
                          <li><a href="#">Filter 4</a></li>
                          <li><a href="#">Filter 5</a></li>
                        </ul>
                      </li>
                      <li>
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#filterGradeLevel-mobile" href="#highNav-mobile" aria-expanded="true" aria-controls="highNav-mobile">High School</a><span>24</span>
                        <ul id="highNav-mobile" class="panel-collapse collapse" role="tabpanel">
                          <li><a href="#">Filter 1</a></li>
                          <li><a href="#">Filter 2</a></li>
                          <li><a href="#">Filter 3</a></li>
                          <li><a href="#">Filter 4</a></li>
                          <li><a href="#">Filter 5</a></li>
                        </ul>
                      </li>
                      <li>
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#filterGradeLevel-mobile" href="#higherNav-mobile" aria-expanded="true" aria-controls="higherNav-mobile">Higher Education</a><span>48</span>
                        <ul id="higherNav-mobile" class="panel-collapse collapse" role="tabpanel">
                          <li><a href="#">Filter 1</a></li>
                          <li><a href="#">Filter 2</a></li>
                          <li><a href="#">Filter 3</a></li>
                          <li><a href="#">Filter 4</a></li>
                          <li><a href="#">Filter 5</a></li>
                        </ul>
                      </li>                                                
                    </ul>
                  </div>
                </div>
              </div><!-- /panel --> 
                              
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="filters-heading-1-mobile">
                  <h1 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion-filters-mobile" href="#filterPanel1-mobile" aria-expanded="true" aria-controls="filterPanel1-mobile" class="collapsed">
                      SUB-DISCIPLINE
                    </a>
                  </h1>
                </div>
                <div id="filterPanel1-mobile" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filters-heading-1-mobile">
                  <div class="panel-body">
                    <ul>
                      <li><a href="#" class="active">Civics</a></li>
                      <li><a href="#">Economics</a><span>67</span></li>
                      <li><a href="#">Geography</a><span>23</span></li>
                      <li><a href="#">Government</a><span>39</span></li>
                      <li><a href="#">U.S. History</a><span>42</span></li>
                      <li><a href="#">World History</a><span>58</span></li>
                    </ul>
                  </div>
                </div>
              </div><!-- /panel -->
                              
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="filters-heading-2-mobile">
                  <h1 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion-filters-mobile" href="#filterPanel2-mobile" aria-expanded="true" aria-controls="filterPanel2-mobile" class="collapsed">
                      CONTENT TYPE
                    </a>
                  </h1>
                </div>
                <div id="filterPanel2-mobile" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filters-heading-2-mobile">
                  <div class="panel-body">
                    <ul>
                      <li><a href="#">Activity</a><span>23</span></li>
                      <li><a href="#">App</a><span>24</span></li>
                      <li><a href="#">Assessment</a><span>5</span></li>
                      <li><a href="#">Courseware</a><span>10</span></li>
                      <li><a href="#">Tutorial</a><span>4</span></li>
                    </ul>
                  </div>
                </div>
              </div><!-- /panel -->   
              
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="filters-heading-3-mobile">
                  <h1 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion-filters-mobile" href="#filterPanel3-mobile" aria-expanded="true" aria-controls="filterPanel3-mobile" class="collapsed">
                      OBJECT TYPE
                    </a>
                  </h1>
                </div>
                <div id="filterPanel3-mobile" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filters-heading-3-mobile">
                  <div class="panel-body">
                    <ul>
                      <li><a href="#">Filter 1</a><span>24</span></li>
                      <li><a href="#">Filter 2</a><span>18</span></li>
                      <li><a href="#">Lorem ipsum</a><span>2</span></li>
                    </ul>
                  </div>
                </div>
              </div><!-- /panel -->   
              
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="filters-heading-4-mobile">
                  <h1 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion-filters-mobile" href="#filterPanel4-mobile" aria-expanded="true" aria-controls="filterPanel4-mobile" class="collapsed">
                      Standards
                    </a>
                  </h1>
                </div>
                <div id="filterPanel4-mobile" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filters-heading-4-mobile">
                  <div class="panel-body">
                    <ul>
                      <li><a href="#">Common Core</a><span>29</span></li>
                      <li><a href="#">Lorem ipsum</a><span>9</span></li>
                    </ul>
                  </div>
                </div>
              </div><!-- /panel -->  
              
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="filters-heading-5-mobile">
                  <h1 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion-filters-mobile" href="#filterPanel5-mobile" aria-expanded="true" aria-controls="filterPanel5-mobile" class="collapsed">
                      Contributors
                    </a>
                  </h1>
                </div>
                <div id="filterPanel5-mobile" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filters-heading-5-mobile">
                  <div class="panel-body">
                    <ul>
                      <li><a href="#">Wisewire</a><span>18</span></li>
                      <li><a href="#">OpenStax</a><span>14</span></li>
                      <li><a href="#">Kaplan</a><span>2</span></li>
                      <li><a href="#">Lorem ipsum</a><span>2</span></li>
                    </ul>
                  </div>
                </div>
              </div><!-- /panel -->   
  
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="filters-heading-7-mobile">
                  <h1 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion-filters-mobile" href="#filterPanel7-mobile" aria-expanded="true" aria-controls="filterPanel7-mobile" class="collapsed">
                      RANKING
                    </a>
                  </h1>
                </div>
                <div id="filterPanel7-mobile" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filters-heading-7-mobile">
                  <div class="panel-body">
                    <ul>
                      <li><a href="#">Filter 1</a><span>24</span></li>
                      <li><a href="#">Filter 2</a><span>18</span></li>
                      <li><a href="#">Lorem ipsum</a><span>2</span></li>
                    </ul>
                  </div>
                </div>
              </div><!-- /panel --> 
              
              <a href="#" class="btn btn-filters-overlay-close" id="btn-filters-overlay-close" class="btn">Done</a>                                                                                            
  
            </div><!-- /accordion-filters -->             
            
          </div><!-- /filters-overlay -->
          
        </div><!-- /container -->
        
        <div class="mobile-accordion">
          
          <article class="lo-item lo-content-type-2" onclick="location.href='detail.html';">
            <div class="content">
              <div class="details">
                <h2 class="sub-discipline">
                  U.S. History
                </h2>
                <p class="content-type">
                  Textbook module
                </p>
                <p class="grade-level">
                  Sixth grade, Seventh Grade, Eighth Grade
                </p>
              </div>
              <div class="more-info">
                <div class="content-title">
                  <h1>Social Studies Techbook</h1>
                  <div class="content-type-icon">
                    <svg class="svg-icon_blue_textbook-dims">
                      <use xlink:href="#icon_blue_textbook"></use>
                    </svg>
                  </div>
                </div>
                <div class="rate">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                  <p class="number">
                    3.5
                  </p>
                </div>                                        
              </div>
              <div class="lo-info">
                <div class="date-rate">
                  <p class="date">
                    01-01-2015
                  </p>
                  <p class="object-type">
                    eBook
                  </p>                      
                </div>
              </div>
              <div class="ribbon"><span class="icon"></span> Preview</div>                 
            </div>
          </article>
          
          <article class="lo-item lo-content-type-2" onclick="location.href='detail.html';">
            <div class="content">
              <div class="details">
                <h2 class="sub-discipline">
                  Biology
                </h2>
                <p class="content-type">
                  Textbook module
                </p>
                <p class="grade-level">
                  Tenth Grade, Eleventh Grades
                </p>
              </div>
              <div class="more-info">
                <div class="content-title">
                  <h1>Hit veliaeprerum am delores</h1>
                  <div class="content-type-icon">
                    <svg class="svg-icon_blue_textbook-dims">
                      <use xlink:href="#icon_blue_textbook"></use>
                    </svg>
                  </div>
                </div>
                <div class="rate">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                  <p class="number">
                    3.5
                  </p>
                </div>                                        
              </div>
              <div class="lo-info">
                <div class="date-rate">
                  <p class="date">
                    01-01-2015
                  </p>
                  <p class="object-type">
                    Question/Answer
                  </p>                      
                </div>
              </div>
              <div class="ribbon"><span class="icon"></span> Preview</div>                 
            </div>
          </article>              
        
          <article class="lo-item lo-content-type-3" onclick="location.href='detail.html';">
            <div class="content">
              <div class="details">
                <h2 class="sub-discipline">
                  Biology
                </h2>
                <p class="content-type">
                  Courseware Module
                </p>
                <p class="grade-level">
                  Tenth Grade, Eleventh Grades
                </p>
              </div>
              <div class="more-info">
                <div class="content-title">
                  <h1>Hit veliaeprerum am delores</h1>
                  <div class="content-type-icon">
                    <svg class="svg-icon_blue_coursework-dims">
                      <use xlink:href="#icon_blue_coursework"></use>
                    </svg>
                  </div>
                </div>
                <div class="rate">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                  <p class="number">
                    3.5
                  </p>
                </div>                    
              </div>
              <div class="lo-info">
                <div class="date-rate">
                  <p class="date">
                    01-01-2015
                  </p>
                  <p class="object-type">
                    Game-based learning
                  </p>                      
                </div>
              </div>
              <div class="ribbon"><span class="icon"></span> Preview</div>                 
            </div>
          </article>
                    
          <article class="lo-item lo-content-type-2" onclick="location.href='detail.html';">
            <div class="content">
              <div class="details">
                <h2 class="sub-discipline">
                  U.S. History
                </h2>
                <p class="content-type">
                  Textbook module
                </p>
                <p class="grade-level">
                  Sixth grade, Seventh Grade, Eighth Grade
                </p>
              </div>
              <div class="more-info">
                <div class="content-title">
                  <h1>Social Studies Techbook</h1>
                  <div class="content-type-icon">
                    <svg class="svg-icon_blue_textbook-dims">
                      <use xlink:href="#icon_blue_textbook"></use>
                    </svg>
                  </div>
                </div>
                <div class="rate">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                  <p class="number">
                    3.5
                  </p>
                </div>                                        
              </div>
              <div class="lo-info">
                <div class="date-rate">
                  <p class="date">
                    01-01-2015
                  </p>
                  <p class="object-type">
                    eBook
                  </p>                      
                </div>
              </div>
              <div class="ribbon"><span class="icon"></span> Preview</div>                 
            </div>
          </article>
          
          <article class="lo-item lo-content-type-2" onclick="location.href='detail.html';">
            <div class="content">
              <div class="details">
                <h2 class="sub-discipline">
                  Biology
                </h2>
                <p class="content-type">
                  Textbook module
                </p>
                <p class="grade-level">
                  Tenth Grade, Eleventh Grades
                </p>
              </div>
              <div class="more-info">
                <div class="content-title">
                  <h1>Hit veliaeprerum am delores</h1>
                  <div class="content-type-icon">
                    <svg class="svg-icon_blue_textbook-dims">
                      <use xlink:href="#icon_blue_textbook"></use>
                    </svg>
                  </div>
                </div>
                <div class="rate">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                  <p class="number">
                    3.5
                  </p>
                </div>                                        
              </div>
              <div class="lo-info">
                <div class="date-rate">
                  <p class="date">
                    01-01-2015
                  </p>
                  <p class="object-type">
                    Question/Answer
                  </p>                      
                </div>
              </div>
              <div class="ribbon"><span class="icon"></span> Preview</div>                 
            </div>
          </article>              
        
          <article class="lo-item lo-content-type-3" onclick="location.href='detail.html';">
            <div class="content">
              <div class="details">
                <h2 class="sub-discipline">
                  Biology
                </h2>
                <p class="content-type">
                  Courseware Module
                </p>
                <p class="grade-level">
                  Tenth Grade, Eleventh Grades
                </p>
              </div>
              <div class="more-info">
                <div class="content-title">
                  <h1>Hit veliaeprerum am delores</h1>
                  <div class="content-type-icon">
                    <svg class="svg-icon_blue_coursework-dims">
                      <use xlink:href="#icon_blue_coursework"></use>
                    </svg>
                  </div>
                </div>
                <div class="rate">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                  <p class="number">
                    3.5
                  </p>
                </div>                    
              </div>
              <div class="lo-info">
                <div class="date-rate">
                  <p class="date">
                    01-01-2015
                  </p>
                  <p class="object-type">
                    Game-based learning
                  </p>                      
                </div>
              </div>
              <div class="ribbon"><span class="icon"></span> Preview</div>                 
            </div>
          </article>                    
                         
          <article class="lo-item lo-content-type-2" onclick="location.href='detail.html';">
            <div class="content">
              <div class="details">
                <h2 class="sub-discipline">
                  U.S. History
                </h2>
                <p class="content-type">
                  Textbook module
                </p>
                <p class="grade-level">
                  Sixth grade, Seventh Grade, Eighth Grade
                </p>
              </div>
              <div class="more-info">
                <div class="content-title">
                  <h1>Social Studies Techbook</h1>
                  <div class="content-type-icon">
                    <svg class="svg-icon_blue_textbook-dims">
                      <use xlink:href="#icon_blue_textbook"></use>
                    </svg>
                  </div>
                </div>
                <div class="rate">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                  <p class="number">
                    3.5
                  </p>
                </div>                                        
              </div>
              <div class="lo-info">
                <div class="date-rate">
                  <p class="date">
                    01-01-2015
                  </p>
                  <p class="object-type">
                    eBook
                  </p>                      
                </div>
              </div>
              <div class="ribbon"><span class="icon"></span> Preview</div>                 
            </div>
          </article>
          
          <article class="lo-item lo-content-type-2" onclick="location.href='detail.html';">
            <div class="content">
              <div class="details">
                <h2 class="sub-discipline">
                  Biology
                </h2>
                <p class="content-type">
                  Textbook module
                </p>
                <p class="grade-level">
                  Tenth Grade, Eleventh Grades
                </p>
              </div>
              <div class="more-info">
                <div class="content-title">
                  <h1>Hit veliaeprerum am delores</h1>
                  <div class="content-type-icon">
                    <svg class="svg-icon_blue_textbook-dims">
                      <use xlink:href="#icon_blue_textbook"></use>
                    </svg>
                  </div>
                </div>
                <div class="rate">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                  <p class="number">
                    3.5
                  </p>
                </div>                                        
              </div>
              <div class="lo-info">
                <div class="date-rate">
                  <p class="date">
                    01-01-2015
                  </p>
                  <p class="object-type">
                    Question/Answer
                  </p>                      
                </div>
              </div>
              <div class="ribbon"><span class="icon"></span> Preview</div>                 
            </div>
          </article>              
        
          <article class="lo-item lo-content-type-3" onclick="location.href='detail.html';">
            <div class="content">
              <div class="details">
                <h2 class="sub-discipline">
                  Biology
                </h2>
                <p class="content-type">
                  Courseware Module
                </p>
                <p class="grade-level">
                  Tenth Grade, Eleventh Grades
                </p>
              </div>
              <div class="more-info">
                <div class="content-title">
                  <h1>Hit veliaeprerum am delores</h1>
                  <div class="content-type-icon">
                    <svg class="svg-icon_blue_coursework-dims">
                      <use xlink:href="#icon_blue_coursework"></use>
                    </svg>
                  </div>
                </div>
                <div class="rate">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars.png" alt="" /> 
                  <p class="number">
                    3.5
                  </p>
                </div>                    
              </div>
              <div class="lo-info">
                <div class="date-rate">
                  <p class="date">
                    01-01-2015
                  </p>
                  <p class="object-type">
                    Game-based learning
                  </p>                      
                </div>
              </div>
              <div class="ribbon"><span class="icon"></span> Preview</div>                 
            </div>
          </article>
                                                                                      
        </div><!-- /section-list-view -->
               
      </div><!-- /items --> 
          
    </div><!-- /vivible-xs-block -->


    <div class="back-to-top" id="back-to-top">
      <a href="#header" class="scroll">Back to top</a>
    </div>
    
    
<?php get_footer(); ?>
