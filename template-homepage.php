<?php /*
 * Template Name: Homepage Template
 */
?>

	<?php get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
	<!-- HOMEPAGE SLIDER -->
	<div class="slides">
		<ul class="rslides">
			<?php if(get_field('rotating_images'))
			{
		 
				while(has_sub_field('rotating_images'))
				{?>
				<li>
					<img src="<?php echo get_sub_field('image')?>" alt="" title="">
					<!--<div class="container">
						<div class="home_quote_container">
							 <div class="home_quote">
								<p><?php echo get_sub_field('quote')?></p>
							</div>
						</div>
					</div>-->
				</li>
 
				<?
				}
			}?>
		 
		</ul>
	</div>

	<div class="container home">
		
		<div class="six columns ">
			<div class="border_box">
				<div class="home_callout">
					<h2><a href="<?php echo get_field('left_link')?>"><?php echo get_field('left_callout_box')?></a></h2>
				</div>
			</div>	
		</div>	
		<div class="six columns ">
			<div class="border_box callout">
				<div class="home_callout">
					<h2><a href="<?php echo get_field('right_link')?>"><?php echo get_field('right_callout_box')?></a></h2>
				</div>
			</div>	
		</div>
		
		<!-- <div class="twelve columns home_line"> </div> -->

		<div class="twelve columns home_column">
			<!-- Comment out for now -->
			<!--<h2> <a href="<?php echo get_field('left_box_link')?>" title="<?php echo get_field('left_box_title')?>"><?php echo get_field('left_box_title')?></a></h2> -->			<?php echo get_field('left_box_content')?>
			<!-- <a class="more" href="<?php echo get_field('left_box_link')?>" title="<?php echo get_field('left_box_title')?>">read more ></a>-->
		</div>

		<!-- Comment out for now  __ More link should remain commmented-->
		<!-- <div class="four columns home_column">
			
			<h2><a href="<?php echo get_field('middle_box_link')?>" title="<?php echo get_field('middle_box_title')?>"><?php echo get_field('middle_box_title')?></a></h2>
			<?php echo get_field('middle_box_content')?>
			 <a class="more" href="<?php echo get_field('middle_box_link')?>" title="<?php echo get_field('middle_box_title')?>">read more ></a>
		</div>-->

		<!-- Comment out for now  __ More link should remain commmented-->
		<!-- <div class="four columns home_column">
			<h2><a href="<?php echo get_field('right_box_link')?>" title="<?php echo get_field('Right_box_title')?>"><?php echo get_field('Right_box_title')?></a></h2>
			<?php echo get_field('Right_box_content')?>
			<a class="more" href="<?php echo get_field('right_box_link')?>" title="<?php echo get_field('Right_box_title')?>">read more ></a>
		</div> -->
 
				
			<?php endwhile; ?>
		 
	</div><!-- End of Container -->







	<?php get_footer(); ?>