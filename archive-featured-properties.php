<?php ?>

<?php get_header(); ?>
<?php get_template_part( 'subheader'); ?>

<div class="container page_content shauns new archive"> 
	<div class="title-container row">
		<?php 

		//Declare variables for options page fields for this page
		$page_title = get_field('fp_page_title', 'options');
		$page_intro = get_field('fp_intro_text', 'options');

		?>

		 <div class="page_title_container">
				<h1><?php if(is_404()){echo "OOPS!";} else { echo $page_title; } ?></h1> <!-- the_title(); -->
		</div> 

		<?php if($page_intro){ ?>
			<div class="the_content">
				<p>
					<?php echo $page_intro; ?>
				</p>
			</div>
		<?php } ?>
	</div>
<?php //if ( have_posts(the_query) ) while ( have_posts() ) : the_post(); ?>
	<div class="three columns">
		
			<div class="filters">
				<h2> Filter properties by:</h2>
				<div class="filter footage">
					<h3>Square Footage/Pad Size</h3>
					<fieldset name="footage">
						<?php $footages = get_terms('property_size');
								foreach ($footages as $footage){
						?>
						
						<input type="checkbox" id="<?php echo $footage->slug ?>" name="<?php echo $footage->slug; ?>" value="<?php echo $footage->slug ?>" data-filter="<?php echo $footage->slug ?>" /><?php //echo $footage->name ?>
						<label for="<?php echo $footage->slug; ?>"><span></span><?php echo $footage->name; ?></label>
						<?php } ?>	

					</fieldset>
				</div>
				<div class="filter property-type">
					<h3>Property Type</h3>
					<fieldset>
						<?php $property_types = get_terms('property_type');
								foreach ($property_types as $property_type){
						?>
						<input type="checkbox" id="<?php echo $property_type->slug ?>" name="<?php echo $property_type->slug; ?>" value="<?php echo $property_type->slug ?>" data-filter="<?php echo $property_type->slug ?>" /><?php //echo $footage->name ?>
						<label for="<?php echo $property_type->slug; ?>"><span></span><?php echo $property_type->name; ?></label>

						<?php } ?>	

					</fieldset>
				</div>
				<div class="filter contract">
					<h3>Sale or Lease</h3>
					<fieldset>
						<?php $contracts = get_terms('contract_type');
								foreach ($contracts as $contract){
						?>
						<input type="checkbox" id="<?php echo $contract->slug ?>" name="<?php echo $contract->slug; ?>" value="<?php echo $contract->slug ?>" data-filter="<?php echo $contract->slug ?>" /><?php //echo $footage->name ?>
						<label for="<?php echo $contract->slug; ?>"><span></span><?php echo $contract->name; ?></label>
						
						<?php } ?>	

					</fieldset>
				</div>
				<div class="filter location">
					<h3>Location</h3>
					<fieldset>
						<?php $locations = get_terms('location');
								foreach ($locations as $location){
						?>

						<input type="checkbox" id="<?php echo $location->slug ?>" name="<?php echo $location->slug; ?>" value="<?php echo $location->slug ?>" data-filter="<?php echo $location->slug ?>" /><?php //echo $footage->name ?>
						<label for="<?php echo $location->slug; ?>"><span></span><?php echo $location->name; ?></label>

						<?php } ?>	

					</fieldset>
				</div>

			</div>
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

	

	<div class="seven columns content">
		

		<?php 

		$args = array(
			'post_type' => 'featured-properties',
			'post_status' => 'publish',
			'order' => 'DESC',
			'order_by' => 'name',
			'posts_per_page' => -1,
			);

		$the_query = new WP_Query($args);

		if ($the_query->have_posts()) while ($the_query->have_posts()) : $the_query->the_post();
		  $post_img = get_field('fp_image', $post->ID);
		  $post_img_url = $post_img['sizes']['large'];
		  //var_dump($post_img_url);

		?>
			<div class="post row">
				<div class="row">
					<h2><?php echo the_title($post->ID); ?></h2>
				</div>

				<?php if($post_img){ ?>
				<div class="three columns alpha">
					<img src="<?php echo $post_img_url; ?>" >
				</div>
				<?php } ?>
				<div class=" <?php if($post_img) {echo "four columns omega"; }else{echo "alpha"; } ?>">
					<?php the_content($post->ID); ?>
				</div>
			</div>
		<?php //the_content(); ?>
		<?php endwhile; ?>
	</div>
		  	


</div><!-- End of Container -->







<?php get_footer(); ?>