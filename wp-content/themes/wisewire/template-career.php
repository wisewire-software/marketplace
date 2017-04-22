<?php
/**
 * Template Name: Career
 */

?>

<?php get_header(); ?>

<section class="career-banner" style="background: url(<?php bloginfo('template_directory'); ?>/img/careers/career-banner.jpg);">
	<div class="container">
		<div class="banner-text">
			<span class="circle">Join</span>
			<span>our team</span>
		</div>
	</div>
</section>
<section class="career-content">
	<div class="container">
                <h2 class="text-center"><?php the_field('career_title') ?></h2>
		<?php
			$jobList = get_field('job_list');
                        if($jobList):
		?>
		<?php $counter=1; foreach ($jobList as $jobListData): ?>
		<div class="row item-career">
			<div class="col-lg-3 col-md-3 col-sm-1">
				<h3><?php echo $jobListData['job_title'];?></h3>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-1">
				<?php echo $jobListData['job_description'];?>
				<a target="_blank" href="<?php echo $jobListData['job_description_url'];?>"><?php echo $jobListData['job_description_url_text'];?></a>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-1 text-right">
				<a href="#" class="apply-btn" data-toggle="modal" data-target="#myModal<?php echo $counter; ?>">Apply!</a>
			</div>
		</div>
		<div class="modal fade" id="myModal<?php echo $counter; ?>" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<h3 id="subjectTitle<?php echo $counter; ?>"><?php echo $jobListData['job_title'];?></h3>
						<?php echo $jobListData['job_description'];?>
						<div class="career-form">
							<?php echo do_shortcode('[contact-form-7 id="68148" title="Careers"]') ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $counter++; endforeach; ?>
                <?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>


<script>
	$(document).ready(function(){
		$('[id*="subjectTitle"]').each(function(){
			var subject = $(this).text();
			$(this).parent().find('#subject').val(subject).attr('disabled', true);
		});
	})
</script>