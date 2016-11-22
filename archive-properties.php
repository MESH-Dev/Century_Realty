<?php ?>

<?php get_header(); ?>
<?php get_template_part( 'subheader'); ?>

<div class="container page_content shauns new archive"> 
	
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div class="three columns">
		&nbsp; 
		
			<?php 
            //get parent title
            global $post;
            if(is_page() && $post->post_parent) {
        			$pid = $post->post_parent;
              $thepermalink = get_permalink( $pid );
            } 
			?>
        

	           <!--<h2><a href="<?php echo $thepermalink; ?>"><?php echo get_the_title($pid); ; ?></a></h2>-->
	        	<?php
				 	//list parent child pages
				 	if($post->post_parent)
	  					$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0&depth=1");
	 				 else
	 					 $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&depth=1");
	 				 if ($children) { ?>
	 				 <div class="border_box">
						<div class="border_inner page_nav">
	  						<ul>
	  							<?php echo $children; ?>
	  						</ul>  
	  					</div>		
					</div>		       
	  				<?php }  ?>
	  		

		
	</div>	

	<div class="twelve columns content">

		<?php 
			$page_title = get_field('fp_page_title', 'options');
			$page_intro = get_field('fp_intro_text', 'options');

		?>
		 <div class="page_title_container">
				<h1><?php if(is_404()){echo "OOPS!";} else { echo $page_title; } ?></h1>the_title();
		</div> 

		<?php if($page_intro){ ?>
			<div class="the_content">
				<p>
					<?php echo $page_intro; ?>
				</p>
			</div>
		<?php } ?>
		<?php //the_content(); ?>
	</div>
		  	
<?php endwhile; ?>

</div><!-- End of Container -->







<?php get_footer(); ?>