<?php
/**
 * Template Name: TEI Demo Items
 */

require_once get_template_directory() . '/Controller/TEI.php';

$control = new Controller_TEI();

get_header(); ?>  

  
  <?php /*
  <div class="container">
    <h1>TEI Demo Content</h1>
	
	<?php if (isset($_REQUEST['fn'])): ?>
	<iframe width="100%" height="600" src="/wp-content/uploads/tei/w-n-templates/preview.html?template=<?php echo str_replace(' ','',strtolower(urldecode($_REQUEST['tpl']))) ?>&fn=<?php echo $_REQUEST['fn'] ?>"></iframe>
	<?php endif; ?>
	
	<div class="row">
		<?php if ($control->data): foreach ($control->data as $k => $sheet): ?>
		<div class="col-md-6">
			<table class="table table-bordered table-condensed table-stripped table-hover">
				<thead>
					<tr><th colspan="2">Select TEI item - Sheet <?php echo $k+1 ?></th></tr>
				</thead>
				<tbody>
					<?php foreach ($sheet as $item): ?>
					<tr>
						<td><a href="?fn=<?php echo $item['A'] ?>&amp;tpl=<?php echo $item['B'] ?>"><?php echo $item['A'] ?></a></td>
						<td><?php echo $item['B'] ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php endforeach; endif; ?>
	</div>
  </div>
  */?>
  
  <?php
    // CPT fields
    
    $content = get_field('content');
    $content_more = get_field('content_more');
    $tei_headline = get_field('tei_headline');
    
  ?>

  
    <div class="container">
      <div class="page-title row-no-margin">
        <div class="col-md-6 col-no-space">
            <h1>
              <?php the_title(); ?>
            </h1>
        </div>        
      </div>      
    </div>
      
  
    <section class="custom-intro custom-intro-tei">
      <div class="container">
        <div class="row-no-margin">
          <div class="col-md-12 col-no-space">
            <div class="col-md-6 col-left">
              <?php if ($content) { ?>
                <?php echo $content; ?>
              <?php } ?>
              
              <?php if ($content_more) { ?>
              <div class="collapse" id="teiReadMore1">
                <?php echo $content_more; ?>
              </div>              
              <p class="more">
                <a role="button" data-toggle="collapse" href="#teiReadMore1" aria-expanded="false" aria-controls="publishReadMore1"><strong>Read more</strong> <span class="caret"></span></a>
              </p>  
              <?php } ?>
            </div>
            <div class="col-md-6 col-right">
              
                <br>
                <!--<div class="embed-responsive embed-responsive-16by9">
                  <?php //$tei_video = get_field('tei_video') ?>
                  <?php //if(!empty($tei_video)):?>
                  <?php //$attr_video = array('src'=>$tei_video ,  )?>
                  <?php //$video_item = wp_video_shortcode( $attr_video ) ?> 
                  <?php //echo str_replace("wp-video","wp-video embed-responsive-item" ,$video_item)?>
                <?php //endif?>
                </div>-->
                <div id="teiVideoIframe" style="width:100%"><iframe width="565" height="310" src="https://www.youtube.com/embed/pjAcfmHlUiM" frameborder="0" allowfullscreen></iframe></div>
              

              <div class="">
                <div class="col-md-12 col-right">
                  <article class="item">                
                      <div class="learning-more">
                          <p><em>Interested in learning more?</em></p>                          
                          <a href="#" class="btn" data-toggle="modal" data-target="#contactModal">Contact Us</a>
                      </div>                
                  </article>
                </div>
              </div>              
            </div>
          </div>
        </div>              
      </div>
      
    </section><!-- /custom-intro -->
    
    
    <div class="visible-xs-block">
 
      <section class="tei-demo">
        
        <div class="mobile-accordion" id="teidemo-accordion-1" role="tablist" aria-multiselectable="true">
               
          <div class="panel panel-default">
            
            <div class="panel-heading" role="tab" id="teidemoItemHeading1">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#teidemo-accordion-1" href="#teidemoItem1" aria-expanded="true" aria-controls="teidemoItem1" class="collapsed">
                  Math
                </a>
              </h4>
            </div>
            
            <div id="teidemoItem1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="teidemoItemHeading1">
              <div class="panel-body">
  
                <?php
                  // The same code for desktop and mobile
                  // START
                ?>
                     
                <div class="row">
                  <div class="col-sm-6">
                    <!--
                    <ul>
                      <li>
                        <p>Bar Graph</p>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=bargraph&fn=Math_3.MD.B.3_CLO_Q04_Demo">3.MD.B.3</a></span>
                      </li>
                      <li>
                        <p>Drop-Down</p>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=dropdown&fn=Math_HSF.IF.B.4_DRD_Demo">HSF.IF.B.4</a></span>
                      </li>
                      <li>
                        <p>Equation Builder</p>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=equation_builder&fn=Math_HSA.CED.A.1_EQU_Demo">HSA.CED.A.1</a></span>
                      </li>
                      <li>
                        <p>Hotspot</p>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=hotspot&fn=Math_8.NS.A.2_CLO_Q03_DEMO">8.NS.A.2</a></span>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=hotspot&fn=Math_4.NF.A.1_CLO_Q05_DEMO">4.NF.A.1</a></span>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=hotspot&fn=Math_HSG.CO.D.13_CLO_Q01_DEMO">HSG.CO.D.13</a></span>
                      </li>
                      <li>
                        <p>Matching</p>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=matching&fn=Math_HSA-CED.A.4_DDP_Q02">HAS.CED.A.4</a></span>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=matching&fn=Math_HSF.IF.C.7C_DDP_Q03">HSF.IF.C.7C</a></span>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=matching&fn=Math_HSG-GMD.B.4_DDP_Q09">HSG.GMD.B.4</a></span>
                      </li>
                      <li>
                        <p>Multiple Drag and Drop</p>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=multipledd&fn=Math_HSF-IF.B.4_DDP_Q05_DEMO">HSF.IF.B.4</a></span>
                      </li>
                      <li>
                        <p>Multiple Select</p>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=multipleselect&fn=Math_HSF.IF.C.9_MCQ_Q7_Demo">HSF.IF.C.9</a></span>
                      </li>
                      <li>
                        <p>Short Answer</p>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=textentry&fn=Math_7.RP.A.3_FIB_Q03_DEMO">7.RP.A.3</a></span>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=textentry&fn=Math_HSS.ID.A.2_MCQ_Q08_DEMO">HSS.ID.A.2</a></span>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=textentry&fn=Math_3.OA.D.8_FIB_Q04_DEMO">3.OA.D.8</a></span>
                      </li>                                                                                                                                                                                                     
                    </ul>
                    -->
                    <ul>
                      <li>
                        <p>Fill in the Blank</p>
                        <span><a href="https://test-platform.wisewire.com/question/math-4-oa-a-2-fib-q02/6567aabb-2e19-4e13-a84f-b0659fa0a210" target="_blank">Grade 4 Operations & Algebraic Thinking </a></span>
                      </li>
                      <li>
                        <p>Object Create</p>
                        <span><a href="https://test-platform.wisewire.com/question/math-6-g-a-3-gra-q01/14ce9df8-7c3a-4fff-86e8-348a5b3a2c23" target="_blank">Grade 6 Geometry</a></span>
                      </li>

                      <li>
                        <p>Hotspot</p>
                        <span><a href="https://test-platform.wisewire.com/question/math-6-ns-c-7-c-gra-q04/71e6c15d-3691-4b46-82a0-179e22404b53" target="_blank">Grade 6 The Number System</a></span>
                      </li> 
                      <li>
                          <p>Drag and Drop</p>
                          <span><a href="https://test-platform.wisewire.com/question/math-8-g-a-2-ddp-q03/c933d3f7-6c7f-41b0-9cad-9c4f87b6ec4b" target="_blank">Grade 8 Geometry</a></span>
                      </li>
                      <li>
                          <p>Graph Inequality</p>
                          <span><a href="https://test-platform.wisewire.com/question/graph-inequality-demo/ec00c41c-4898-4221-9eb0-60cd44440d26#" target="_blank">High School Algebra Reasoning with Equations & Inequalities</a></span>
                      </li>                                          
                    </ul>
    

                  </div>
                  
                  <div class="col-sm-6">
                                     
                  </div>
                  
                </div>
            
                <?php
                  // END
                ?>  

              </div>
            </div>
          </div>
          
          <div class="panel panel-default">
            
            <div class="panel-heading" role="tab" id="teidemoItemHeading2">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#teidemo-accordion-1" href="#teidemoItem2" aria-expanded="true" aria-controls="teidemoItem2" class="collapsed">
                  Ela
                </a>
              </h4>
            </div>
            
            <div id="teidemoItem2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="teidemoItemHeading2">
              <div class="panel-body">
            
                <?php
                  // The same code for desktop and mobile
                  // START
                ?>
                <div class="row">
                  
                  <div class="col-sm-6">
                   
                     <ul>
                      <li>
                        <p>Radio Button</p>
                        <span><a href="https://test-platform.wisewire.com/question/ccss-ela-literacy-l-3-1-b/9ae0e3b7-d030-4e57-b196-b8ae83cc846d#" target="_blank">Grade 3 Language </a></span>
                      </li>
                      <li>
                        <p>Fill in the Blank</p>
                        <span><a href="https://test-platform.wisewire.com/question/ela-ri-6-9-drd-q161-sample/a842b455-e68c-4bc6-a21b-dd222a7d7537" target="_blank">Grade 6 Reading: Informational Text</a></span>
                      </li>
                      <li>
                        <p>Radio Button</p>
                        <span><a href="https://test-platform.wisewire.com/question/ela-rl-6-7-mcq-q12/4e6c7b2d-ffe9-41ce-8ecc-c11236cee6e4#" target="_blank">Grade 6 Reading: Literature</a></span>
                      </li> 
                      <li>
                          <p>Hotspot</p>
                          <span><a href="https://test-platform.wisewire.com/question/ela-rl-9-10-7-mcq-q988/249df6f4-5509-4043-b22b-cfecdf73aa5c#" target="_blank">Grade 9–10 Reading: Literature</a></span>
                      </li>
                      <li>
                          <p>Drag and Drop</p>
                          <span><a href="https://test-platform.wisewire.com/question/ela-ri-11-12-9-ddp-q824/6fc2cb88-528a-4bbf-ad8a-786a128296b7#" target="_blank">Grade 11–12 Reading: Informational Text</a></span>
                      </li>                                          
                    </ul>
                    


                  </div>
                  
                  <div class="col-sm-6">
                    <!--
                    <ul>
                      <li>
                        <p>Multiple Drag and Drop with Passage</p>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=multipledd&fn=ELA_RI.11-12.7_DDP_Q887">RI.11-12.7</a></span>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=multipledd&fn=ELA_RL.3.6_DDP_Q6">RL.3.6</a></span>
                      </li>
                      <li>
                        <p>Multiple Select with Passage</p>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=multipleselect&fn=ELA_RI.8.1_MCQ_Q88">RI.8.1</a></span>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=multipleselect&fn=ELA_RL.3.7_MCQ_Q14">RL.3.7</a></span>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=multipleselectsingle&fn=ELA_G11_MCQ_WN02265">RL.11-12.2</a></span>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=multipleselectsingle&fn=ELA_G5_MCQ_WN02997">RI.5.2</a></span>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=multipleselect&fn=RL.11-12.7_demo">RL.11-12.7</a></span>
                      </li> 
                      <li>
                        <p>Hotspot with Passage</p>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="https://test-platform.wisewire.com/external/question/preview/249df6f4-5509-4043-b22b-cfecdf73aa5c">RL.9-10.7</a></span>
                      </li>
                      <li>
                        <p>Short Answer with Passage</p>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="/wp-content/uploads/tei/w-n-templates/preview.html?template=textentry&fn=ELA_RI.4.5_FIB_Q99">RI.4.5</a></span>
                        <span><a href="#" class="btn-iframe-tei-demo" data-toggle="modal" data-target="#previewModal" data-src="https://test-platform.wisewire.com/external/question/preview/a842b455-e68c-4bc6-a21b-dd222a7d7537">RI.6.9</a></span>
                      </li>                                     
                    </ul>
                    -->
                  </div>
                  
                </div>
                
                <?php
                  // END
                ?> 
                                          
              </div>
            </div>
          </div>          
      
        </div><!-- /mobile-accordion -->
        
      </section><!-- /teidemo -->
             
    </div><!-- /vidible-xs-block -->
    
    
        
    <!-- Hidden on <768px -->
      
    <div class="hidden-xs">
              
      <section class="tei-demo">
        
        <div class="container">
          
          <?php if ($tei_headline) { ?>
          	<h2><?php echo $tei_headline; ?></h2>
          <?php } ?>
          
          <div class="row">
            
            <div class="col-sm-6 col">
              
              <div class="category-name">
                <h3>
                  MATH
                </h3>
              </div>
                       
              <?php
                // The same code for desktop and mobile
                // START
              ?>
                   
              <div class="row">
                <div class="col-sm-12">
                 
                  <ul>
                    <li>
                      <p>Fill in the Blank</p>
                      <span><a href="https://test-platform.wisewire.com/question/math-4-oa-a-2-fib-q02/6567aabb-2e19-4e13-a84f-b0659fa0a210" target="_blank">Grade 4 Operations & Algebraic Thinking </a></span>
                    </li>
                    <li>
                      <p>Object Create</p>
                      <span><a href="https://test-platform.wisewire.com/question/math-6-g-a-3-gra-q01/14ce9df8-7c3a-4fff-86e8-348a5b3a2c23" target="_blank">Grade 6 Geometry</a></span>
                    </li>

                    <li>
                      <p>Hotspot</p>
                      <span><a href="https://test-platform.wisewire.com/question/math-6-ns-c-7-c-gra-q04/71e6c15d-3691-4b46-82a0-179e22404b53" target="_blank">Grade 6 The Number System</a></span>
                    </li> 
                    <li>
                        <p>Drag and Drop</p>
                        <span><a href="https://test-platform.wisewire.com/question/math-8-g-a-2-ddp-q03/c933d3f7-6c7f-41b0-9cad-9c4f87b6ec4b" target="_blank">Grade 8 Geometry</a></span>
                    </li>
                    <li>
                        <p>Graph Inequality</p>
                        <span><a href="https://test-platform.wisewire.com/question/graph-inequality-demo/ec00c41c-4898-4221-9eb0-60cd44440d26#" target="_blank">High School Algebra Reasoning with Equations & Inequalities</a></span>
                    </li>                                          
                  </ul>

                </div>
               
                
              </div>
          
              <?php
                // END
              ?>
                        
            </div>
        
            <div class="col-sm-6 col">
              
              <div class="category-name">
                <h3>
                  ELA
                </h3>
              </div>
              
              
              <?php
                // The same code for desktop and mobile
                // START
              ?>
              <div class="row">
                
                <div class="col-sm-12">
                 
                  <ul>
                    <li>
                      <p>Radio Button</p>
                      <span><a href="https://test-platform.wisewire.com/question/ccss-ela-literacy-l-3-1-b/9ae0e3b7-d030-4e57-b196-b8ae83cc846d#" target="_blank">Grade 3 Language</a></span>
                    </li>
                    <li>
                      <p>Fill in the Blank</p>
                      <span><a href="https://test-platform.wisewire.com/question/ela-ri-6-9-drd-q161-sample/a842b455-e68c-4bc6-a21b-dd222a7d7537" target="_blank">Grade 6 Reading: Informational Text</a></span>
                    </li>
                    <li>
                      <p>Radio Button</p>
                      <span><a href="https://test-platform.wisewire.com/question/ela-rl-6-7-mcq-q12/4e6c7b2d-ffe9-41ce-8ecc-c11236cee6e4#" target="_blank">Grade 6 Reading: Literature</a></span>
                    </li> 
                    <li>
                        <p>Hotspot</p>
                        <span><a href="https://test-platform.wisewire.com/question/ela-rl-9-10-7-mcq-q988/249df6f4-5509-4043-b22b-cfecdf73aa5c#" target="_blank">Grade 9–10 Reading: Literature</a></span>
                    </li>
                    <li>
                        <p>Drag and Drop</p>
                        <span><a href="https://test-platform.wisewire.com/question/ela-ri-11-12-9-ddp-q824/6fc2cb88-528a-4bbf-ad8a-786a128296b7#" target="_blank">Grade 11–12 Reading: Informational Text</a></span>
                    </li>                                          
                  </ul>
                </div>
                
              </div>
              
              <?php
                // END
              ?>
              
            </div>
  
          </div><!-- /row -->               
          
        </div><!-- /container -->
  
      </section><!-- /tei-demo -->
      
    </div>

    <div class="container services-more">
      <div class="learning-more">
        <p>Interested in learning more?</p>
        <a href="#" class="btn" data-toggle="modal" data-target="#contactModal">Contact us</a>
      </div>
    </div>
    
    
    <div class="modal fade modal-preview modal-iframe" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <div class="modal-title">
              <h2 id="subhead">
              </h2>
            </div>
                        
            <div class="iframe-container">
              <iframe src="" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
            </div>
            
          </div><!-- /modal-body -->
           
        </div>
      </div>
    </div><!-- /modal -->
    

<?php get_footer(); ?>