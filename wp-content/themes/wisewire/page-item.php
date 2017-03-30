
<?php get_header(); ?>  

  
  <?php
  
  print_r($_REQUEST);
  
    // List all item content 
        
    $title = get_the_title();
    $item_object_id = get_field('item_object_id');
    $item_publish_date = get_field('item_publish_date');
    $item_home_page_feature = get_field('item_home_page_feature');
    $item_explore_page_feature = get_field('item_explore_page_feature');
    $item_detail_page_template = get_field('item_detail_page_template');
    $item_sample_demo_template = get_field('item_sample_demo_template');
    $item_price = get_field('item_price');
    $item_cta_button = get_field('item_cta_button');
    $item_preview = get_field('item_preview');
    $item_content_type_icon = get_field('item_content_type_icon');
    $item_grade_level = get_field('item_grade_level');
    $item_object_type = get_field('item_object_type');
    $item_object_type_tei_type = get_field('item_object_type_tei_type');
    $item_contributor = get_field('item_contributor');
    $item_contributor_link = get_field('item_contributor_link');
    $item_contributor_email = get_field('item_contributor_email');
    $item_contributor_description = get_field('item_contributor_description');
    $item_contributor_image = get_field('item_contributor_image');
    $item_ratings = get_field('item_ratings');
    $item_standards = get_field('item_standards');
    $item_standards_subtag = get_field('item_standards_subtag');
    $item_dok = get_field('item_dok');
    $item_keywords = get_field('item_keywords');
    $item_pdf_download_terms_button = get_field('item_pdf_download_terms_button');
    $item_pdf_download_terms_button_url = get_field('item_pdf_download_terms_button_url');
    $item_for_sale = get_field('item_for_sale');
    $item_license_type = get_field('item_license_type');
    $item_language = get_field('item_language');
    $item_long_description = get_field('item_long_description');
    $item_parent_object = get_field('item_parent_object');
    $item_parent_object_child_objects = get_field('item_parent_object_child_objects');
    $item_parent_object_next_in_sequence = get_field('item_parent_object_next_in_sequence');
    $item_parent_object_previous_in_sequence = get_field('item_parent_object_previous_in_sequence');
    $item_related_content = get_field('item_related_content');
    $item_demo_viewer_template = get_field('item_demo_viewer_template');
    $item_demo_viewer_pdf_viewer_preview_pages = get_field('item_demo_viewer_pdf_viewer_preview_pages');
    $item_demo_viewer_subhead_cta = get_field('item_demo_viewer_subhead_cta');
    
    /*
      
    echo '<h1>Display all fields attached to an item:</h1>';
    
    if ($title) {
    	echo '<strong>title:</strong> ' . $title . '<br>';
    }
    
    echo '<strong>image:</strong> TODO<br>';
    
    echo '<strong>categories attached to the item:</strong><br>';
    echo get_the_category_list();
    
    if ($item_object_id) {
    	echo '<strong>item_object_id:</strong> ' . $item_object_id . '<br>';
    }
    if ($item_publish_date) {
    	echo '<strong>item_publish_date:</strong> ' . $item_publish_date . '<br>';
    }
    if ($item_home_page_feature) {
    	echo '<strong>item_home_page_feature:</strong> ' . $item_home_page_feature . '<br>';
    }
    if ($item_explore_page_feature) {
    	echo '<strong>item_explore_page_feature:</strong> ' . $item_explore_page_feature . '<br>';
    }
    if ($item_detail_page_template) {
    	echo '<strong>item_detail_page_template:</strong> ' . $item_detail_page_template . '<br>';
    }
    if ($item_sample_demo_template) {
    	echo '<strong>item_sample_demo_template:</strong> ' . $item_sample_demo_template . '<br>';
    }
    if ($item_price) {
    	echo '<strong>item_price:</strong> ' . $item_price . '<br>';
    }
    if ($item_cta_button) {
    	echo '<strong>item_cta_button:</strong> ' . $item_cta_button . '<br>';
    }
    if ($item_preview) {
    	echo '<strong>item_preview:</strong> ' . $item_preview . '<br>';
    }
    if ($item_content_type_icon) {
    	echo '<strong>item_content_type_icon:</strong> ' . $item_content_type_icon . '<br>';
    }
    if ($item_grade_level) {
    	echo '<strong>item_grade_level:</strong> ' . $item_grade_level . '<br>';
    }
    if ($item_object_type) {
    	echo '<strong>item_object_type:</strong> ' . $item_object_type . '<br>';
    }
    if ($item_object_type_tei_type) {
    	echo '<strong>item_object_type_tei_type:</strong> ' . $item_object_type_tei_type . '<br>';
    }
    if ($item_contributor) {
    	echo '<strong>item_contributor:</strong> ' . $item_contributor . '<br>';
    }
    if ($item_contributor_link) {
    	echo '<strong>item_contributor_link:</strong> ' . $item_contributor_link . '<br>';
    }
    if ($item_contributor_email) {
    	echo '<strong>item_contributor_email:</strong> ' . $item_contributor_email . '<br>';
    }
    if ($item_contributor_description) {
    	echo '<strong>item_contributor_description:</strong> ' . $item_contributor_description . '<br>';
    }
    if ($item_contributor_image) {
    	echo '<strong>item_contributor_image:</strong> ' . $item_contributor_image . '<br>';
    }
    if ($item_ratings) {
    	echo '<strong>item_ratings:</strong> ' . $item_ratings . '<br>';
    }
    if ($item_standards) {
    	echo '<strong>item_standards:</strong> ' . $item_standards . '<br>';
    }
    if ($item_standards_subtag) {
    	echo '<strong>item_standards_subtag:</strong> ' . $item_standards_subtag . '<br>';
    }
    if ($item_dok) {
    	echo '<strong>item_dok:</strong> ' . $item_dok . '<br>';
    }
    if ($item_keywords) {
    	echo '<strong>item_keywords:</strong> ' . $item_keywords . '<br>';
    }
    if ($item_pdf_download_terms_button) {
    	echo '<strong>item_pdf_download_terms_button:</strong> ' . $item_pdf_download_terms_button . '<br>';
    }
    if ($item_pdf_download_terms_button_url) {
    	echo '<strong>item_pdf_download_terms_button_url:</strong> ' . $item_pdf_download_terms_button_url . '<br>';
    }
    if ($item_for_sale) {
    	echo '<strong>item_for_sale:</strong> ' . $item_for_sale . '<br>';
    }
    if ($item_license_type) {
    	echo '<strong>item_license_type:</strong> ' . $item_license_type . '<br>';
    }
    if ($item_language) {
    	echo '<strong>item_language:</strong> ' . $item_language . '<br>';
    }
    if ($item_long_description) {
    	echo '<strong>item_long_description:</strong> ' . $item_long_description . '<br>';
    }
    if ($item_parent_object) {
    	echo '<strong>item_parent_object:</strong> ' . $item_parent_object . '<br>';
    }
    if ($item_parent_object_child_objects) {
    	echo '<strong>item_parent_object_child_objects:</strong> ' . $item_parent_object_child_objects . '<br>';
    }
    if ($item_parent_object_next_in_sequence) {
    	echo '<strong>item_parent_object_next_in_sequence:</strong> ' . $item_parent_object_next_in_sequence . '<br>';
    }
    if ($item_parent_object_previous_in_sequence) {
    	echo '<strong>item_parent_object_previous_in_sequence:</strong> ' . $item_parent_object_previous_in_sequence . '<br>';
    }
    if ($item_related_content) {
    	echo '<strong>item_related_content:</strong> ' . $item_related_content . '<br>';
    }
    if ($item_demo_viewer_template) {
    	echo '<strong>item_demo_viewer_template:</strong> ' . $item_demo_viewer_template . '<br>';
    }
    if ($item_demo_viewer_pdf_viewer_preview_pages) {
    	echo '<strong>item_demo_viewer_pdf_viewer_preview_pages:</strong> ' . $item_demo_viewer_pdf_viewer_preview_pages . '<br>';
    }
    if ($item_demo_viewer_subhead_cta) {
    	echo '<strong>item_demo_viewer_subhead_cta:</strong> ' . $item_demo_viewer_subhead_cta . '<br>';
    }
    */
    
  ?>





    <!-- Visible on <768px -->
    
    <div class="customize-link-mobile visible-xs-block">
      <div class="container">
        <p>
          <a href="#" data-toggle="modal" data-target="#customizeModal">CUSTOMIZE CONTENT ></a>
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
          <li role="presentation"><a href="#nav-high" aria-controls="nav-high" role="tab" data-toggle="tab">High</a></li>
          <li role="presentation"><a href="#nav-higher-education" aria-controls="nav-higher-education" role="tab" data-toggle="tab">Higher Education</a></li>
          <li class="btn-customize">
            <a href="#" data-toggle="modal" data-target="#customizeModal" class="btn btn-alt">Customize Content</a>
          </li>
        </ul>
      
        <!-- Tab panes -->
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
          
        </div><!-- /tab-content -->
        
      </div>
      
    </section><!-- /lo-navigation -->

    <!-- Learn More Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <div class="modal-title">
              <h1>
                Did you know we can custom fit content for you?
              </h1>
            </div>
            
            <div class="modal-desc">
              <p>
                 Ipsam exped que ped minitatus vidis sim sum quid ut ipid maio excea debisint que doluptate voleniendita debitem aut re dolorem faccum dolectem reperiam volupta turesequam solorep raturec atendia dolo doluptius. Apic tem. Ita nimi, vidempo ritempe eturers peritin ihicae am, corae nonseque mi. <a href="#">See customize page for more details.</a>
              </p>
            </div>
            
            <form>
              
              <div class="container-fluid container-form">
                
                <div class="row">
                  
                  <div class="col col-sm-4">
                    <div class="form-group">
                      <input type="text" class="form-control" id="" placeholder="First Name">
                    </div>
                  </div>
                  
                  <div class="col col-sm-4">
                    <div class="form-group">
                      <input type="text" class="form-control" id="" placeholder="Last Name">
                    </div>
                  </div>
                  
                  <div class="col col-sm-4">
                    <div class="form-group">
                      <input type="email" class="form-control" id="" placeholder="Email">
                    </div>
                  </div>
                  
                </div><!-- /row -->
                
                <div class="row">
                  
                  <div class="col col-sm-4">
                    <div class="form-group">
                      <input type="text" class="form-control" id="" placeholder="Phone">
                    </div>
                  </div>
                  
                  <div class="col col-sm-8">
                    <div class="form-group">
                      <input type="text" class="form-control" id="" placeholder="School affiliation">
                    </div>
                  </div>
                  
                </div>
                
                <div class="row">
                  
                  <div class="col col-sm-12">
                    <div class="form-group">
                      <textarea class="form-control" rows="4" placeholder="Lorem ipsum"></textarea>  
                    </div>
                  </div>
                  
                </div>
                
                <button type="submit" class="btn">Submit</button>
                
              </div>
            
            </form>
            
          </div><!-- /modal-body -->
        </div>
      </div>
    </div>

    <section class="detail">
      
      <div class="container">
        
        <div class="btn-back hidden-xs">
          <a href="#">&lt; Back</a>
        </div>
            
        <div class="metadata">
          <h1>
            U.S. History
          </h1>
          <a href="exploreall.html">VIEW ALL U.S. History</a>
          <h2>
            Social Studies Techbook 
          </h2>
        </div><!-- /detail-info -->      
            
      </div>
      
      <!-- Visible on <768px -->
      <div class="visible-xs-block">
      
        <div class="container">
          <div class="img">
            <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo/temp-detail.png" alt="" class="img-responsive" />
            <a href="#" class="ribbon" data-toggle="modal" data-target="#previewModal"><span class="icon"></span> Preview</a>
          </div>            
        </div>
        
        <div class="product-info">
          
          <div class="container">
            
            <p class="interested">
              Interested in purchasing this item?
            </p>
            
            <div class="buttons">
              <p class="btn-contact">
                <a href="#" data-toggle="modal" data-target="#contactModal" class="btn">Contact us</a>
              </p>
              
              <?php get_template_part('parts/favorites', 'add'); ?>

            </div>
            
            <div class="rate-section">
              <div class="side-rate">
                <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars-big.png" alt="" />
                <span class="number">3.5</span>
              </div>
              <p class="rateit">
                <a href="#" data-toggle="modal" data-target="#rateModal">RATE THIS &gt;</a>
              </p>   
            </div>  
            
            <div class="contributor">
              <p>
                <strong>Contributor</strong>
                <span>
                  <a href="#" data-toggle="modal" data-target="#contributorDetailsModal">Discovery<br>Education</a>
                </span>
                
              </p>
            </div>
            
            <p class="download">
              <a href="#">DOWNLOAD TERMS AND usage rights &gt;</a>
            </p>
                
          </div>
                          
        </div>
          
        <div class="mobile-accordion" id="mobile-accordion-1" role="tablist" aria-multiselectable="true">
                
          <div class="panel panel-default">
            
            <div class="panel-heading" role="tab" id="viewDetailsHeading1">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#mobile-accordion-1" href="#viewDetails" aria-expanded="true" aria-controls="viewDetails" class="collapsed">
                  View Details
                </a>
              </h4>
            </div>
            
            <div id="viewDetails" class="panel-collapse collapse view-details" role="tabpanel" aria-labelledby="viewDetailsHeading1">
              <div class="panel-body">  
                
                <div class="panel-content details-content-more">
                                        
                  <dl class="dl-horizontal">
                    <dt>Update</dt>
                    <dd>01-01-2015</dd>
                    
                    <dt>This item includes</dt>
                    <dd>1 Textbook</dd>
                    
                    <dt>Module Type</dt>
                    <dd>Courseware</dd>
                    
                    <dt>Grade Level</dt>
                    <dd>Sixth Grade, Seventh Grade, Eighth Grade</dd>
                    
                    <dt>Object Type</dt>
                    <dd>Interactive</dd>
                  </dl> 
                
                </div> 
                                       
              </div>
            </div>
          </div>  
          
          <div class="panel panel-default">
            
            <div class="panel-heading" role="tab" id="descriptionHeading1">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#mobile-accordion-1" href="#descriptionPanel" aria-expanded="true" aria-controls="descriptionPanel" class="collapsed">
                  Description
                </a>
              </h4>
            </div>
            
            <div id="descriptionPanel" class="panel-collapse collapse accordion-description" role="tabpanel" aria-labelledby="descriptionHeading3">
              <div class="panel-body">
                       
                <div class="panel-content">
                     
                  <p>
                    W&N was the sole content developer for Discovery Education’s innovative Social Studies Techbook, which covers U.S. History (Colonization through Reconstruction), U.S. History (Reconstruction through Present), World History, and World Geography and Culture. This digital-first middle school curriculum follows the five E model. W&N conceptualized the program, including scope and sequencing and template design, and then wrote, edited, reviewed, and spec’d all content. <a href="#">This is a link style for body copy.</a>
                  </p>
                  
                  <h2>Sample Header 1 Style</h2>
                  
                  <p>
                    The Core Interactive Text was supplemented by primary sources, maps, and multimedia; paper-and-pencil and interactive activities; an interactive glossary; reading passages; review; and assessments. W&N also managed the production teams, reviewed all elements for quality assurance, and provided alt text for 508 compliance.                
                  </p>   
                  
                  <div class="collapse" id="detailMobileReadMore1">
                    <div class="content-more">
                      <p>
                        The Social Studies Techbook is quickly becoming popular with teachers and students because it makes digital learning easy-to-use, interactive, and engaging. Features such as the Interactive Map and Board Builder create learning opportunities not possible with a traditional textbook. The Techbook also helps students build critical-thinking and citizenship skills, and various reading tools allow for differentiated instruction. The Techbook was also awarded a 2015 SIIA CoDIE award.
                      </p>
                    </div>
                  </div>              
                  <p class="more">
                    <a role="button" data-toggle="collapse" href="#detailMobileReadMore1" aria-expanded="false" aria-controls="detailMobileReadMore1"><strong>Read more</strong> <span class="caret"></span></a>
                  </p>
                
                </div>
                                         
              </div>
            </div>
          </div>                   
                  
        </div><!-- /mobile-accordion -->          
          
        <div class="container">
          <ul class="post-nav">
            <li class="previous">
              <a href="#" data-toggle="tooltip" data-placement="right" title="Maximum width for tooltip is 450px. Text is cut when too lon...">&lt; Previous</a>
            </li>
            <li class="next">
              <a href="#"  data-toggle="tooltip" data-placement="left" title="Maximum width for tooltip is 450px. Text is cut when too lon...">Next &gt;</a>
            </li>
          </ul> 
        </div>         
        
        
        <div class="accordion-style">
          
          <h2 class="title">Related Items</h2>
          
          <article class="lo-item lo-content-type-3" onclick="location.href='detail.html';">
            <div class="content">
              <div class="details">
                <h2 class="sub-discipline">
                  Math Techbook
                </h2>
              </div>
              <div class="content-title">
                <h1>Wisewire</h1>
                <div class="content-type-icon">
                  <svg class="svg-icon_blue_coursework-dims">
                    <use xlink:href="#icon_blue_coursework"></use>
                  </svg>
                </div>
              </div>
            </div>
          </article>    
              
          <article class="lo-item lo-content-type-3" onclick="location.href='detail.html';">
            <div class="content">
              <div class="details">
                <h2 class="sub-discipline">
                  Science Techbook
                </h2>
              </div>
              <div class="content-title">
                <h1>Wisewire</h1>
                <div class="content-type-icon">
                  <svg class="svg-icon_blue_coursework-dims">
                    <use xlink:href="#icon_blue_coursework"></use>
                  </svg>
                </div>
              </div>
            </div>
          </article>
          
          <article class="lo-item lo-content-type-4" data-toggle="modal" data-target="#videoModal">
            <div class="content">
              <div class="details">
                <h2 class="sub-discipline">
                  The New World: Taxation
                </h2>
              </div>
              <div class="content-title">
                <h1>Kahn Academy</h1>
                <div class="content-type-icon">
                  <svg class="svg-icon_purple_video-dims">
                    <use xlink:href="#icon_purple_video"></use>
                  </svg>
                </div>
              </div>
            </div>
          </article>    
          
          <article class="lo-item lo-content-type-4" data-toggle="modal" data-target="#videoModal">
            <div class="content">
              <div class="details">
                <h2 class="sub-discipline">
                  World War I
                </h2>
              </div>
              <div class="content-title">
                <h1>YouTube</h1>
                <div class="content-type-icon">
                  <svg class="svg-icon_purple_video-dims">
                    <use xlink:href="#icon_purple_video"></use>
                  </svg>
                </div>
              </div>
            </div>
          </article>              
          
        </div><!-- accordion-style -->
        
      </div><!-- /visible-xs-block -->
     
            
      <!-- Hidden on <768px -->
      <div class="hidden-xs">
        
        <div class="container">
          
          <div class="col-left">

            <div class="img">
              <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo/temp-detail.png" alt="" class="img-responsive" />
              <a href="#" class="ribbon ribbon-xl" data-toggle="modal" data-target="#previewModal"><span class="icon"></span> Preview</a>
            </div>
        
            <article>
              
              <p>
                W&N was the sole content developer for Discovery Education’s innovative Social Studies Techbook, which covers U.S. History (Colonization through Reconstruction), U.S. History (Reconstruction through Present), World History, and World Geography and Culture. This digital-first middle school curriculum follows the five E model. W&N conceptualized the program, including scope and sequencing and template design, and then wrote, edited, reviewed, and spec’d all content. <a href="#">This is a link style for body copy.</a>
              </p>
              
              <h2>Sample Header 1 Style</h2>
              
              <p>
                The Core Interactive Text was supplemented by primary sources, maps, and multimedia; paper-and-pencil and interactive activities; an interactive glossary; reading passages; review; and assessments. W&N also managed the production teams, reviewed all elements for quality assurance, and provided alt text for 508 compliance.                
              </p>   
              
              <div class="collapse" id="detailReadMore1">
                <div class="content-more">
                  <p>
                    The Social Studies Techbook is quickly becoming popular with teachers and students because it makes digital learning easy-to-use, interactive, and engaging. Features such as the Interactive Map and Board Builder create learning opportunities not possible with a traditional textbook. The Techbook also helps students build critical-thinking and citizenship skills, and various reading tools allow for differentiated instruction. The Techbook was also awarded a 2015 SIIA CoDIE award.
                  </p>
                </div>
              </div>              
              <p class="more">
                <a role="button" data-toggle="collapse" href="#detailReadMore1" aria-expanded="false" aria-controls="detailReadMore1"><strong>Read more</strong> <span class="caret"></span></a>
              </p>         
              
            </article>
            
            <ul class="post-nav">
              <li class="previous">
                <a href="#" data-toggle="tooltip" data-placement="right" title="Maximum width for tooltip is 450px. Text is cut when too lon...">&lt; previous IN THIS SERIES</a>
              </li>
              <li class="next">
                <a href="#"  data-toggle="tooltip" data-placement="left" title="Maximum width for tooltip is 450px. Text is cut when too lon...">next IN THIS SERIES &gt;</a>
              </li>
            </ul>
            
          </div>
          
          <div class="col-right">
            
            <div class="sidebar">
              
              <p class="interested">
                Interested in purchasing<br>this item?
              </p>
              <p class="btn-contact">
                <a href="#" data-toggle="modal" data-target="#contactModal" class="btn">Contact us</a>
              </p>
              
              <?php get_template_part('parts/favorites', 'add'); ?>
              
              <div class="side-rate">
                <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars-big.png" alt="" />
                <span class="number">3.5</span>
              </div>
              <p class="rateit">
                <a href="#" data-toggle="modal" data-target="#rateModal">RATE THIS ITEM &gt;</a>
              </p>
              <div class="details-content">
                <a role="button" data-toggle="collapse" href="#detailsContentReadMore1" aria-expanded="false" aria-controls="detailsContentReadMore1" class="btn-details"><strong>View details</strong> <span class="caret"></span></a>
                <div class="collapse" id="detailsContentReadMore1">
                  <div class="details-content-more">
                    
                    <dl>
                      <dt>Update</dt>
                      <dd>01-01-2015</dd>
                      
                      <dt>This item includes</dt>
                      <dd>1 Textbook</dd>
                      
                      <dt>Module Type</dt>
                      <dd>Courseware</dd>
                      
                      <dt>Grade Level</dt>
                      <dd>Sixth Grade, Seventh Grade, Eighth Grade</dd>
                      
                      <dt>Object Type</dt>
                      <dd>Interactive</dd>
                    </dl>
                    
                  </div>
                </div>
              </div>
              
              <div class="contributor">
                <p>
                  <strong>Contributor</strong>
                  <a href="#" data-toggle="modal" data-target="#contributorDetailsModal">Discovery Education</a>
                  <a href="#" data-toggle="modal" data-target="#contributorDetailsImageModal">Jason Smith (demo)</a>
                </p>
              </div>
              
              <p class="download">
                <a href="#">DOWNLOAD TERMS AND usage rights &gt;</a>
              </p>
              
            </div>
            
          </div>
          
        </div>
        
      </div><!-- /hidden-xs -->        
      
          
    </section><!-- /detail -->


    <div class="modal fade modal-preview" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <div class="modal-title">
              <h1>
                TODO, DEMO VIEWER.
                <br>
                This part will be done when working on WordPress Development.
              </h1>
            </div>
            
          </div><!-- /modal-body -->
        </div>
      </div>
    </div>
    
    
    <div class="modal fade modal-rate" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <div class="modal-title">
              <h1>
                Rate this item
              </h1>
            </div>
            
            <div class="clearfix">
              
              <div class="col-left">
                <article class="lo-item lo-item-col lo-content-type-1" onclick="location.href='detail.html';">
                  <div class="img">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo-featured.jpg" alt="" class="img-responsive" />
                  </div>
                  <div class="content">
                    <div class="details">
                      <h2 class="sub-discipline">
                        CCSS
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
              </div>
              
              <div class="col-right">
                
                <div class="current-rating">
                  <p class="current">
                    Current rating
                  </p>
                  <div class="rate">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars-xl.png" alt="" /> 
                    <p class="number">
                      3.5
                    </p>
                  </div> 
                </div>  
                  
                <div class="rate-function">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/stars-xxl.png" alt="" class="img-responsive" />  
                </div>            
                
                <button class="btn" data-dismiss="modal">
                  Submit
                </button>
                      
              </div>
              
            </div>
            
          </div><!-- /modal-body -->
        </div>
      </div>
    </div>

    <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <div class="modal-title">
              <h1>
                Contact Us
              </h1>
            </div>
            
            <div class="modal-desc">
              <p>
                 We’re here to help you. Let us know what items you’re interested in and a member of our Wisewire team will contact you.
              </p>
            </div>
            
            <form>
              
              <div class="container-fluid">
                
                <div class="row">
                  
                  <div class="col col-sm-4">
                    <div class="form-group">
                      <input type="text" class="form-control" id="" placeholder="First Name">
                    </div>
                  </div>
                  
                  <div class="col col-sm-4">
                    <div class="form-group">
                      <input type="text" class="form-control" id="" placeholder="Last Name">
                    </div>
                  </div>
                  
                  <div class="col col-sm-4">
                    <div class="form-group">
                      <input type="email" class="form-control" id="" placeholder="Email">
                    </div>
                  </div>
                  
                </div><!-- /row -->
                
                <div class="row">
                  
                  <div class="col col-sm-4">
                    <div class="form-group">
                      <input type="text" class="form-control" id="" placeholder="Phone">
                    </div>
                  </div>
                  
                  <div class="col col-sm-8">
                    <div class="form-group">
                      <input type="text" class="form-control" id="" placeholder="School affiliation">
                    </div>
                  </div>
                  
                </div>
                
                <div class="row">
                  
                  <div class="col col-sm-12">
                    <div class="form-group">
                      <textarea class="form-control" rows="4" placeholder="Items you’re interested in"></textarea>  
                    </div>
                  </div>
                  
                </div>
                
                <div class="row">
                  
                  <div class="col-sm-12">
                    <button type="submit" class="btn">Submit</button>
                  </div>
                  
                </div><!-- /row -->
                
              </div>
            
            </form>            
            
     
          </div><!-- /modal-body -->
        </div>
      </div>
    </div>
    
    
    <div class="modal fade modal-contributor" id="contributorDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <div class="modal-title modal-title-border">
              <h1>
                Contributor Details
              </h1>
            </div>
            
            <div class="clearfix">
              
              <div class="col col-left">
                
                <div class="option-logo">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/testimonials/discovery.png" alt="" class="img-responsive" />
                  <a href="http://google.com" class="btn" target="_blank">Website</a>
                  <a href="#" data-toggle="modal" data-target="#contributorContactModal" class="btn" data-dismiss="modal">Contact</a>
                </div>
                
              </div>
              
              <div class="col col-right">
                <p>
                  Discovery Education transforms classrooms, empowers teachers and captivates students by leading the way in providing high quality, dynamic, digital content to school districts large and small, rural and suburban and everything in between.
                </p>
                <p>
                  Accelerate student achievement in your district by capturing the minds and imaginations of students with the fascination of Discovery, tapping into students’ natural curiosity and desire to learn.
                </p>
                  Discovery Education offers a portfolio of opportunities for districts to meet students where they want to learn in the digital age. With award-winning digital content, interactive lessons, real time assessment, virtual experiences with some of Discovery’s greatest talent, classroom contests & challenges, professional development and more — Discovery is leading the way in transforming classrooms and inspiring learning
                </p>
              </div>                
            
            </div>

          </div><!-- /modal-body -->
        </div>
      </div>
    </div>
        
    <div class="modal fade modal-contributor" id="contributorDetailsImageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <div class="modal-title modal-title-border">
              <h1>
                Contributor Details
              </h1>
            </div>
            
            <div class="clearfix">
              
              <div class="col col-left">
                
                <div class="option-img">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/contributor.png" alt="" class="img-responsive" />
                  <p>
                    <strong>Jason Smith</strong>
                    Lorem Ipsum
                  </p>
                  <a href="mailto:email@email.com" class="btn">Contact</a>
                </div>
                
              </div>
              
              <div class="col col-right">
                <p>
                  Contributor’s bio here Tur sunt. Vitat. Ulparum sitiure prore, sitatem quatia quaepud aecaborpossi dempelitiat. Minctis quassus dit ad explit lia verum dit rem quas cor sinvenis eum quibusame nis id molum resti sumquae. 
                </p>
                <p>
                  Et ea cuscius que andello reperatendit imagnim porrum volupta volor siti simi, quo et unt pratur res maionse quatur sit que nam illande et aut verovid mi, cullit etur, vent, voles doloreptae volupta nihita nus eum sint modigent autem quam.
                </p>
              </div>                
            
            </div>

          </div><!-- /modal-body -->
        </div>
      </div>
    </div>
    
            
    <div class="modal fade" id="contributorContactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <div class="modal-title">
              <h1>
                Contact Contributor
              </h1>
            </div>
            
            <div class="modal-desc">
              <p>
                 Um cusam evendaese sit di quis il enducil litiumquam sumquatur, od qui beriorrum aliciis con ressi conecer iandel ilignat quiant dolesciis rehent quiam, sento blaboressim aliti ist latus mosamen dignis adi omnist, nulpa qui custia del maiorib erovit alibus arum qui
              </p>
            </div>
            
            
            <form>
              
              <div class="container-fluid">
                
                <div class="row">
                  
                  <div class="col col-sm-4">
                    <div class="form-group">
                      <input type="text" class="form-control" id="" placeholder="First Name">
                    </div>
                  </div>
                  
                  <div class="col col-sm-4">
                    <div class="form-group">
                      <input type="text" class="form-control" id="" placeholder="Last Name">
                    </div>
                  </div>
                  
                  <div class="col col-sm-4">
                    <div class="form-group">
                      <input type="email" class="form-control" id="" placeholder="Email">
                    </div>
                  </div>
                  
                </div><!-- /row -->
                
                <div class="row">
                  
                  <div class="col col-sm-12">
                    <div class="form-group">
                      <textarea class="form-control" rows="4" placeholder="Lorem Ipsum"></textarea>  
                    </div>
                  </div>
                  
                </div>
                
                <div class="row">
                  
                  <div class="col-sm-12">
                    <button type="submit" class="btn">Submit</button>
                  </div>
                  
                </div><!-- /row -->
                
              </div>
            
            </form>             
     
          </div><!-- /modal-body -->
        </div>
      </div>
    </div>        
    
      

    <div class="hidden-xs">
      
      <section class="lo-items lo-shadow lo-last lo-related">
        
        <div class="container">
          
          <div class="section-title">
            <h1>
              RELATED ITEMS
            </h1>
          </div>

          <div class="row row-no-margin">
            
            <div class="col-sm-3 col-no-space col-2-next">
              
              <article class="lo-item lo-item-col lo-content-type-3" onclick="location.href='detail.html';">
                <div class="img">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo/lo-related-1.png" alt="" class="img-responsive" />
                </div>
                <div class="content">
                  <div class="details">
                    <h2 class="sub-discipline">
                      Math Techbook
                    </h2>
                  </div>
                  <div class="content-title">
                    <h1>Wisewire</h1>
                    <div class="content-type-icon">
                      <svg class="svg-icon_blue_coursework-dims">
                        <use xlink:href="#icon_blue_coursework"></use>
                      </svg>
                    </div>
                  </div>
                </div>
              </article>
                                
            </div>
            
            <div class="col-sm-3 col-no-space col-2-next">
              
              <article class="lo-item lo-item-col lo-content-type-3" onclick="location.href='detail.html';">
                <div class="img">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo/lo-related-2.png" alt="" class="img-responsive" />
                </div>
                <div class="content">
                  <div class="details">
                    <h2 class="sub-discipline">
                      Science Techbook
                    </h2>
                  </div>
                  <div class="content-title">
                    <h1>Wisewire</h1>
                    <div class="content-type-icon">
                      <svg class="svg-icon_blue_coursework-dims">
                        <use xlink:href="#icon_blue_coursework"></use>
                      </svg>
                    </div>
                  </div>
                </div>
              </article>
                                              
            </div>         
                        
            <div class="col-sm-3 col-no-space col-2-next">
              
              <article class="lo-item lo-item-col lo-content-type-4" data-toggle="modal" data-target="#videoModal">
                <div class="img">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo/lo-related-3.png" alt="" class="img-responsive" />
                </div>
                <div class="content">
                  <div class="details">
                    <h2 class="sub-discipline">
                      The New World: Taxation
                    </h2>
                  </div>
                  <div class="content-title">
                    <h1>Kahn Academy</h1>
                    <div class="content-type-icon">
                      <svg class="svg-icon_purple_video-dims">
                        <use xlink:href="#icon_purple_video"></use>
                      </svg>
                    </div>
                  </div>
                </div>
              </article>
                                
            </div>
            
            <div class="col-sm-3 col-no-space col-2-next">
              
              <article class="lo-item lo-item-col lo-content-type-4" data-toggle="modal" data-target="#videoModal">
                <div class="img">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/temp/lo/lo-related-4.png" alt="" class="img-responsive" />
                </div>
                <div class="content">
                  <div class="details">
                    <h2 class="sub-discipline">
                      World War I
                    </h2>
                  </div>
                  <div class="content-title">
                    <h1>YouTube</h1>
                    <div class="content-type-icon">
                      <svg class="svg-icon_purple_video-dims">
                        <use xlink:href="#icon_purple_video"></use>
                      </svg>
                    </div>
                  </div>
                </div>
              </article>
                                              
            </div>         
            
          </div><!-- /row -->
          
        </div><!-- /container -->
        
      </section><!-- /lo-items lo-recommended -->
      
    </div><!-- /hidden-xs -->

    <!--
      Modal for YouTube video
      Clicked on Related Items World War I
    -->
        
    <div class="modal fade modal-video" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <div class="modal-title">
              <h1>
                World War I
              </h1>
            </div>
            
            <div class="video">
              <img src="<?php echo get_template_directory_uri(); ?>/img/temp/youtube.png" alt="" class="img-responsive" />
            </div>
            
          </div><!-- /modal-body -->
        </div>
      </div>
    </div>
  
  
  
<?php get_footer(); ?>