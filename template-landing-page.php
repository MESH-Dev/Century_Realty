<?php /*
 * Template Name: Landing Page Template
 */
?>

<?php /*
 * Default Page Template
 */
?>

<?php get_header(); ?>
<?php get_template_part( 'subheader'); ?>

<div class="container page_content"> 
	
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div class="three columns">
		<div class="border_box">
			<?php 
            //get parent title
            global $post;
            if(is_page() && $post->post_parent) {
        			$pid = $post->post_parent;
              $thepermalink = get_permalink( $pid );
            } 
			?>
             
			<div class="border_inner page_nav">

	           <!--<h2><a href="<?php echo $thepermalink; ?>"><?php echo get_the_title($pid); ; ?></a></h2>-->
	        	<?php
				 	//list parent child pages
				 	if($post->post_parent)
	  					$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0&depth=1");
	 				 else
	 					 $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&depth=1");
	 				 if ($children) { ?>
	  						<ul>
	  							<?php echo $children; ?>
	  						</ul>         
	  				<?php }  ?>
	  		</div>		
		</div>

		<div class="border_box page_side">
			<div class="border_inner testimonials">
				<?php $args = array( 'post_type' => 'quotes', 'posts_per_page' => 1, 'orderby'=> 'rand' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post();
					the_content(); 
					?>
					<p class="quote_source">- <?php the_title(); ?></p>
				<?php 
				endwhile;
				wp_reset_query();
				?>
			</div>
		</div>
	</div>	

	<div class="nine columns omega alpha ">
		<div class="landing_blocks"> 

			<?php if(get_field('sections'))
			{
		 
				while(has_sub_field('sections'))
				{?>
				<div class="<?php echo get_sub_field('width')?> columns ">
					<h2><a href="<?php echo get_sub_field('page_link')?>"><?php echo get_sub_field('section_title')?></a></h2>
					<?php echo get_sub_field('content')?>
					<a class="more" href="<?php echo get_sub_field('page_link')?>">read more ></a>
				</div>
 
				<?
				}
			}?>

 
		</div>	
		<?php the_content(); ?>
	</div>
		  	
<?php endwhile; ?>

</div><!-- End of Container -->




<?php get_footer(); ?>