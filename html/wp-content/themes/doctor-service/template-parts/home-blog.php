<?php
/**
 * Home Page Blog design 
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @subpackage doctor-service
 * @since 1.0
 */

$health_service_enable_blog_section = get_theme_mod( 'health_service_enable_blog_section', true );
$health_service_blog_cat 		= get_theme_mod( 'health_service_blog_cat', 'uncategorized' );
if($health_service_enable_blog_section == true) {
$health_service_blog_title 	= get_theme_mod( 'health_service_blog_title' );
$health_service_blog_subtitle 	= get_theme_mod( 'health_service_blog_subtitle' );
$health_service_rm_button_label 	= get_theme_mod( 'health_service_rm_button_label' );
$health_service_blog_count 	 = apply_filters( 'health_service_blog_count', 3 );
?>
    <section class="blog-5">
        <div class="container">
           <div class="section-title-5">
			<?php if($health_service_blog_title) : ?>
				<h2><?php echo esc_html( $health_service_blog_title ); ?></h2>
				<div class="separator">
				  <ul>
					 <li><i class="fa fa-hospital-o"></i></li>
				  </ul>
				</div>
			<?php endif; ?>
		<?php if($health_service_blog_subtitle) : ?>	
            <p><?php echo esc_html( $health_service_blog_subtitle ); ?></p>
		<?php endif; ?>		
        </div>
            <div class="row">
				<?php 
			if( !empty( $health_service_blog_cat ) ) 
				{
				$blog_args = array(
					'post_type' 	 => 'post',
					'category_name'	 => esc_attr( $health_service_blog_cat ),
					'posts_per_page' => absint( $health_service_blog_count ),
				);

				$blog_query = new WP_Query( $blog_args );
				if( $blog_query->have_posts() ) {
					while( $blog_query->have_posts() ) {
						$blog_query->the_post();
				?>
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <article class="blog-item blog-1">
                        <div class="post-img">
                           <?php the_post_thumbnail(); ?>
                          <div class="date-box" >
                            <div class="m"><?php echo esc_html(get_the_date( 'j' ));?></div>
                            <div class="d"><?php echo esc_html(get_the_date( 'M' ));?></div>
                          </div>
                        </div>
                        <div class="post-content pt-4 text-left">
                            <h5>
                                <a class="heading" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h5>
                            <p class="text-left"> <?php echo esc_html(get_the_excerpt()); ?></p>
                            <?php if($health_service_rm_button_label) : ?>
								<div class="btn-wraper">
								  <a href="<?php the_permalink(); ?>" class="read-more-btn"><?php echo esc_html($health_service_rm_button_label); ?></a>
								</div>
							<?php endif; ?>		
                        </div>
                    </article>
                  </div>
              <?php
				}
			}
			wp_reset_postdata();
		}
		 ?>
            </div>
        </div>
    </section>
    <!-- blog end-->

<?php } ?>