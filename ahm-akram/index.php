<?php get_header();?><section class="section wrap"><h1><?php the_title();?></h1><?php while(have_posts()){the_post();the_content();}?></section><?php get_footer();?>
