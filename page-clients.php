<?php
/*
Template Name: Clients
*/
?>

<?php get_header(); ?>
<?php get_template_part( 'subheader'); ?>


<div class="container page_content"> 
	




<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div class="three columns">
		
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
                  <li><a href="<?php echo site_url(); ?>/clients/">Clients</a></li>
	  							<?php echo $children; ?>
	  						</ul>  
	  					</div>		
					</div>		       
	  				<?php }  ?>
	  		
    <!--
		<div class="border_box page_side testimonials">
			<div class="border_inner testimonials">
				<?php /*$args = array( 'post_type' => 'quotes', 'posts_per_page' => 1, 'orderby'=> 'rand' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post();
					the_content(); 
					?>
					<p class="quote_source">- <?php the_title(); ?></p>
				<?php 
				endwhile;
				wp_reset_query();
				*/?>
			</div>
		</div>-->
    
  <!--END THREE-->
	</div>	

	<div class="seven offset-by-one columns content">
<?php
//CHECK LOGGED IN
if(is_user_logged_in()){
?>
    <div class="logout_bar">
      <a href="<?php echo wp_logout_url( home_url() ); ?>" title="Logout">Logout</a>
    </div>

		<?php the_content(); ?>

<?php 

//NOT LOGGED IN
} else { 

?>
<div class="login_form">
  <?php 
   $args = array(
        'echo' => true,
        'redirect' => site_url( $_SERVER['REQUEST_URI'] ), 
        'remember' => true
      );
   
   wp_login_form( $args ); 
   
   ?> 
   <a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" title="Lost Password">Lost Password</a>

   </div>
<?php } ?>

  <!--END SEVEN-->
	</div>
		  	
<?php endwhile; ?>


</div><!-- End of Container -->


<style>
.login_form {
  width: 578px;
  padding: 20px;
  margin: 0px 0px 0px 0px;
  border: 1px solid #ccc;
  border-style:double;
  border-spacing: 5px;
  font-family: 13px/18px "Georgia", "Times New Roman", Helvetica, Arial, sans-serif
}

.logout_bar {
  border-bottom: 1px solid #ccc;
  padding: 5px;
  text-align: right;
  margin-bottom: 10px;
}
</style>

<?php get_footer(); ?>