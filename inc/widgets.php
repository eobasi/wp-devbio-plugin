<?php
/**
 * GitHub Calander widget.
*/
class DEV_BIO_GitHubCalender extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
			DEVBIO_WIDGET_PREFIX.'github_calander',
			esc_html__( 'DevBio GitHub Calender', 'devbio' ),
			array( 'description' => esc_html__( 'Dispplay your github calander', 'devbio' ), )
		);
	}
	public function widget( $args, $instance )
	{
		$username = $instance['username'];
		
		if( empty( $username  ) )
		{
			return;
		}
		
		// Github calendar css
		wp_enqueue_style( 'devbio-github-calender', devbio_dir_url(). '/assets/plugins/github-calendar/dist/github-calendar.css');
		
		//github calendar plugin
		wp_enqueue_script( 'devbio-promise', 'https://cdnjs.cloudflare.com/ajax/libs/es6-promise/3.0.2/es6-promise.min.js', array(), null);
		wp_enqueue_script( 'devbio-fetch', 'https://cdnjs.cloudflare.com/ajax/libs/fetch/0.10.1/fetch.min.js', array(), null);
		wp_enqueue_script( 'devbio-github-calendar', get_template_directory_uri() . '/assets/plugins/github-calendar/dist/github-calendar.min.js');
		
		echo $args['before_widget'];
		?>
		<div class='github'>
			<?php  if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			} ?>
			<!--//Usage: http://caseyscarborough.com/projects/github-activity/ -->                       
			 <div id="github-graph" class="github-graph"></div>
		</div>		
		<script>
			jQuery(document).ready(function($) {
				/* Github Calendar - https://github.com/IonicaBizau/github-calendar */
				GitHubCalendar("#github-graph", "<?php echo $username; ?>");
			});
		</script>
		<?php
		echo $args['after_widget'];
	}
	
	public function form( $instance )
	{
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'My GitHub Calander', 'devbio' );
		$username = ! empty( $instance['username'] ) ? $instance['username'] : esc_html__( 'eobasi', 'devbio' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'devbio' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_attr_e( 'Username:', 'devbio' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
		</p>
		<?php
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['username'] = ( ! empty( $new_instance['username'] ) ) ? sanitize_text_field( $new_instance['username'] ) : '';
		return $instance;
	}
}

/**
 * GitHub Activity widget.
*/
class DEV_BIO_GitHubActivity extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
			DEVBIO_WIDGET_PREFIX.'github',
			esc_html__( 'DevBio GitHub Activities', 'devbio' ),
			array( 'description' => esc_html__( 'Dispplay your github activities', 'devbio' ), )
		);
	}
	public function widget( $args, $instance )
	{
		$username = $instance['username'];
		
		if( empty( $username  ) )
		{
			return;
		}

		// Github activity css
		wp_enqueue_style( 'devbio-github-activity', devbio_dir_url() . '/assets/plugins/github-activity/src/github-activity.css');
		wp_enqueue_style( 'devbio-octicons', '//cdnjs.cloudflare.com/ajax/libs/octicons/2.0.2/octicons.min.css', array(), null );
		
		//github activity script
		wp_enqueue_script( 'devbio-mustache', '//cdnjs.cloudflare.com/ajax/libs/mustache.js/0.7.2/mustache.min.js', array(), null);
		wp_enqueue_script( 'devbio-github-activity', devbio_dir_url() . '/assets/plugins/github-activity/src/github-activity.js');
		
		echo $args['before_widget'];
		?>
		<div class='github'>
			<?php  if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			} ?>
			<!--//Usage: http://caseyscarborough.com/projects/github-activity/ -->                       
			<div id='ghfeed' class='ghfeed'></div>
		</div>
		
		<script>
			jQuery(document).ready(function($) {
				/* Github Activity Feed - https://github.com/caseyscarborough/github-activity */
				GitHubActivity.feed({ username: "<?php echo $username; ?>", selector: "#ghfeed" });
			});
		</script>
		<?php
		echo $args['after_widget'];
	}
	
	public function form( $instance )
	{
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'My GitHub', 'devbio' );
		$username = ! empty( $instance['username'] ) ? $instance['username'] : esc_html__( 'eobasi', 'devbio' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'devbio' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_attr_e( 'Username:', 'devbio' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
		</p>
		<?php
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['username'] = ( ! empty( $new_instance['username'] ) ) ? sanitize_text_field( $new_instance['username'] ) : '';
		return $instance;
	}
}

/**
 * Projects widget.
*/
class DEV_BIO_Posts extends WP_Widget
{
	function __construct() {
		parent::__construct(
			DEVBIO_WIDGET_PREFIX.'posts',
			esc_html__( 'DevBio Blog Posts', 'devbio' ),
			array( 'description' => esc_html__( 'Dispplay latest blog list', 'devbio' ), )
		);
	}
	public function widget( $args, $instance )
	{
		$limit = !empty( $instance['limit'] ) ? $instance['limit'] : 3;
		
		$posts = new WP_Query( array(
			'posts_per_page'   => $limit,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'post',
			'post_status'      => 'publish',
		));
		
		echo $args['before_widget'];
		
		?>
		<div class='projects'>
			<?php  if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			} ?>
			<div class='content'>
				<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
				<div class='item'>
					<h3 class='title'><a href='<?php echo the_permalink(); ?>'><?php echo the_title();?></a></h3>
					<p class='summary'><?php echo truncate_post(200, get_the_content()); ?></p>
					<p><a class='more-link' href='<?php echo get_the_permalink(); ?>'><i class='fa fa-external-link'></i> Find out more</a></p>
				</div>
				<?php endwhile; ?>
				<a class='btn btn-cta-secondary' href='<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>'>See All <i class='fa fa-chevron-right'></i></a>
			</div>
		</div>
		<?php
		echo $args['after_widget'];
	}
	
	public function form( $instance )
	{
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Blog', 'devbio' );
		$limit = ! empty( $instance['limit'] ) ? $instance['limit'] : 3;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'devbio' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_attr_e( 'Limit:', 'devbio' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>">
				<?php for( $i = 3; $i <= 25; $i++ ): ?>
					<?php if( $i == $limit ): ?>
						<option value='<?php echo $i?>' selected='selected' ><?php echo $i?></option>
					<?php else: ?>
						<option value='<?php echo $i?>' ><?php echo $i?></option>
					<?php endif; ?>
				<?php endfor; ?>
			</select>
		</p>
		<?php
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['limit'] = ( ! empty( $new_instance['limit'] ) ) ? $new_instance['limit'] : 3;
		return $instance;
	}
}

/**
 * Projects widget.
*/
class DEV_BIO_Projects extends WP_Widget
{
	function __construct() {
		parent::__construct(
			DEVBIO_WIDGET_PREFIX.'projects',
			esc_html__( 'DevBio Projects', 'devbio' ),
			array( 'description' => esc_html__( 'Dispplay your project with featured image', 'devbio' ), )
		);
	}
	public function widget( $args, $instance )
	{
		$limit = !empty( $instance['limit'] ) ? $instance['limit'] : 3;
		
		$projects = new WP_Query( array(
			'post_type' => DEVBIO_PROJECTS ,
			'posts_per_page' => $limit,
		));
		
		$count = 0;
		
		if( empty( $projects ) )
		{
			return null;
		}
		
		echo $args['before_widget'];
		
		?>
		<div class='latest'>
			<?php  if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			} ?>
			<div class='content'>
				<?php while ( $projects->have_posts() ) : $projects->the_post(); 
					$thumbnail = has_post_thumbnail() ? get_the_post_thumbnail_url() :  main_image();
					$count += 1;
				?>
					<?php if( $count === 1 ): ?>
					<div class="item featured text-center">
						<h3 class="title"><a href="<?php echo get_the_permalink()?>"><?php echo the_title();?></a></h3>
						<?php if( !empty( $thumbnail ) ): ?>
						<div class="featured-image">
							<a href="<?php echo get_the_permalink()?>"><img class="img-responsive project-image" src="<?php echo $thumbnail?>" alt="<?php echo the_title();?>" /></a>
							<div class="ribbon">
								<div class="text">New</div>
							</div>
						</div>
						<?php endif; ?>
						<div class="desc text-left"><?php echo truncate_post(300, get_the_content())?></div>      
						<a class="btn btn-cta-secondary" href="<?php echo get_post_type_archive_link( DEVBIO_PROJECTS ); ?>" ><i class="fa fa-thumbs-o-up"></i>My Projects</a>
					</div>
					<hr class="divider" />
					<?php else: ?>
						<?php if( !empty( $thumbnail ) ): ?>
							<div class="item row">
								<a class="col-md-4 col-sm-4 col-xs-12" href="<?php echo get_the_permalink()?>">
								<img class="img-responsive project-image" src="<?php echo $thumbnail?>" alt="<?php echo the_title();?>" />
								</a>
								<div class="desc col-md-8 col-sm-8 col-xs-12">
									<h3 class="title"><a href="<?php echo get_the_permalink()?>"><?php echo the_title();?></a></h3>
									<?php echo truncate_post(200, get_the_content())?>
									<p><a class="more-link" href="<?php echo get_the_permalink()?>"><i class="fa fa-external-link"></i> Find out more</a></p>
								</div>                       
							</div>
						<?php else: ?>						
							<div class="item">
								<div class="desc">
									<h3 class="title"><a href="<?php echo get_the_permalink()?>"><?php echo the_title();?></a></h3>
									<?php echo truncate_post(200, get_the_content())?>
									<p><a class="more-link" href="<?php echo get_the_permalink()?>"><i class="fa fa-external-link"></i> Find out more</a></p>
								</div>                       
							</div>
						<?php endif; ?>
					<?php endif; ?>
				<?php endwhile; ?>
			</div>
		</div>
		<?php
		echo $args['after_widget'];
	}
	
	public function form( $instance )
	{
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Projects', 'devbio' );
		$limit = ! empty( $instance['limit'] ) ? $instance['limit'] : 3;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'devbio' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_attr_e( 'Limit:', 'devbio' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>">
				<?php for( $i = 3; $i <= 25; $i++ ): ?>
					<?php if( $i == $limit ): ?>
						<option value='<?php echo $i?>' selected='selected' ><?php echo $i?></option>
					<?php else: ?>
						<option value='<?php echo $i?>' ><?php echo $i?></option>
					<?php endif; ?>
				<?php endfor; ?>
			</select>
		</p>
		<?php
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['limit'] = ( ! empty( $new_instance['limit'] ) ) ? $new_instance['limit'] : 3;
		return $instance;
	}
}

/**
 * Testimonies widget.
*/
class DEV_BIO_Testimonies extends WP_Widget
{
	function __construct() {
		parent::__construct(
			DEVBIO_WIDGET_PREFIX.'testimonies',
			esc_html__( 'DevBio Testimonies', 'devbio' ),
			array( 'description' => esc_html__( 'Dispplay users testimonies on your website', 'devbio' ), )
		);
	}
	public function widget( $args, $instance ) 
	{
		$testimonies = new WP_Query( array(
			'post_type' => DEVBIO_TESTIMONY ,
			'posts_per_page' => 1,
			'orderby' => 'rand',
		));
		
		echo $args['before_widget'];		
		?>
		<div class='testimonials'>
			<?php  if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			} ?>
			<div class='content'>
				<?php while ( $testimonies->have_posts() ) : $testimonies->the_post(); 
					$name = get_post_meta(get_the_ID(), 'name', true);
					$title = get_post_meta(get_the_ID(), 'title', true);
				?>
				<div class='item'>
					<blockquote class='quote'>                                  
						<p><i class='fa fa-quote-left'></i><?php echo wp_strip_all_tags(get_the_content())?></p>
					</blockquote>                
					<p class='source'><span class='name'><?php echo $name?></span><br /><span class='title'><?php echo $title?></span></p>                                                             
				</div>		
				<?php endwhile; ?>
				<?php if( !empty($instance['link'])): ?>
				<p><a class='more-link' href='<?php echo $instance['link']?>' ><i class='fa fa-external-link'></i> More on <?php echo devbio_get_domain_name($instance['link'])?></a></p> 
				<?php endif; ?>
			</div>
		</div> 
		<?php
		echo $args['after_widget'];
	}
	
	public function form( $instance )
	{
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Testimonies', 'devbio' );
		$link = ! empty( $instance['link'] ) ? $instance['link'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'devbio' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_attr_e( 'More Link:', 'devbio' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
		</p>
		<?php
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? sanitize_text_field( $new_instance['link'] ) : '';
		return $instance;
	}
}

/**
 * Work Experience widget.
*/
class DEV_BIO_WorkExperience extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
			DEVBIO_WIDGET_PREFIX.'experience',
			esc_html__( 'DevBio Work Experience', 'devbio' ),
			array( 'description' => esc_html__( 'Dispplay places you have worked on your website', 'devbio' ), )
		);
	}
	
	public function widget( $args, $instance ) 
	{
		$limit = !empty( $instance['limit'] ) ? $instance['limit'] : 3;
		
		$employments = new WP_Query( array(
			'post_type' => DEVBIO_WORK ,
			'posts_per_page' => $limit,
		));
		
		echo $args['before_widget'];		
		?>
		<div class='experience'>
			<?php  if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			} ?>
			<div class='content'>
				<?php while ( $employments->have_posts() ) : $employments->the_post(); 
					$position = get_post_meta(get_the_ID(), 'position', true);
					$date = get_post_meta(get_the_ID(), 'date', true);
				?>
				<div class='item'>
					<h3 class='title'><?php echo $position?> - <span class='place'><a href='<?php echo get_the_permalink()?>'><?php echo get_the_title()?></a></span> <span class='year'>(<?php echo $date?>)</span></h3>
					<p><?php echo get_the_content()?></p>
				</div>	
				<?php endwhile; ?>
				<p><a class='more-link' href='<?php echo get_post_type_archive_link( DEVBIO_WORK ); ?>' ><i class='fa fa-external-link'></i> See All</a></p> 
			</div>
		</div> 
		<?php
		echo $args['after_widget'];
	}
	
	public function form( $instance )
	{
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Work Experience', 'devbio' );
		$limit = ! empty( $instance['limit'] ) ? $instance['limit'] : 3;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'devbio' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_attr_e( 'Limit:', 'devbio' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>">
				<?php for( $i = 3; $i <= 25; $i++ ): ?>
					<?php if( $i == $limit ): ?>
						<option value='<?php echo $i?>' selected='selected' ><?php echo $i?></option>
					<?php else: ?>
						<option value='<?php echo $i?>' ><?php echo $i?></option>
					<?php endif; ?>
				<?php endfor; ?>
			</select>
		</p>
		<?php
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['limit'] = ( ! empty( $new_instance['limit'] ) ) ? $new_instance['limit'] : 3;
		return $instance;
	}
}

/**
 * RSS widget.
*/
class DEV_BIO_RssBlog extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
			DEVBIO_WIDGET_PREFIX.'blog',
			esc_html__( 'DevBio RSS', 'devbio' ),
			array( 'description' => esc_html__( 'Dispplay posts from an RSS feed location', 'devbio' ), )
		);
	}
	
	public function widget( $args, $instance )
	{
		echo $args['before_widget'];
		?>
		 <div class="blog">
			<?php 
				if ( ! empty( $instance['title'] ) ) {
					echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
				}
		
				wp_enqueue_script( 'devbio-jquery-rss', devbio_dir_url() . '/assets/plugins/jquery-rss/dist/jquery.rss.min.js');
				
				$feedUrl = !empty( $instance['feedUrl'] ) ? $instance['feedUrl'] : 'http://www.eobasi.com/feed';
				$limit = !empty( $instance['limit'] ) ? $instance['limit'] : 3;
			?>
			<div id="rss-feeds" class="content"></div>
		</div>
		<script>
			jQuery(document).ready(function($) {
				/* jQuery RSS - https://github.com/sdepold/jquery-rss */
				
				$("#rss-feeds").rss(
				
					//Change this to your own rss feeds
					"<?php echo $feedUrl?>",
					
					{
					// how many entries do you want?
					// default: 4
					// valid values: any integer
					limit: <?php echo (int)$limit?>,
					
					// the effect, which is used to let the entries appear
					// default: 'show'
					// valid values: 'show', 'slide', 'slideFast', 'slideSynced', 'slideFastSynced'
					effect: 'slideFastSynced',
					
					// outer template for the html transformation
					// default: "<ul>{entries}</ul>"
					// valid values: any string
					layoutTemplate: "<div class='item'>{entries}</div>",
					
					// inner template for each entry
					// default: '<li><a href="{url}">[{author}@{date}] {title}</a><br/>{shortBodyPlain}</li>'
					// valid values: any string
					entryTemplate: '<h3 class="title"><a href="{url}" target="_blank">{title}</a></h3><div><p>{shortBodyPlain}</p><a class="more-link" href="{url}" target="_blank"><i class="fa fa-external-link"></i>Read more</a></div>'
					
					}
				);				
			});
		</script>
		<?php
		echo $args['after_widget'];
	}
	
	public function form( $instance )
	{
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'RSS Feed', 'devbio' );
		$feedUrl = ! empty( $instance['feedUrl'] ) ? $instance['feedUrl'] : esc_html__( 'http://www.eobasi.com/feed', 'devbio' );
		$limit = ! empty( $instance['limit'] ) ? $instance['limit'] : 3;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'devbio' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'feedUrl' ) ); ?>"><?php esc_attr_e( 'Feed:', 'devbio' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'feedUrl' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'feedUrl' ) ); ?>" type="text" value="<?php echo esc_attr( $feedUrl ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_attr_e( 'Limit:', 'devbio' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>">
				<?php for( $i = 3; $i <= 25; $i++ ): ?>
					<?php if( $i == $limit ): ?>
						<option value='<?php echo $i?>' selected='selected' ><?php echo $i?></option>
					<?php else: ?>
						<option value='<?php echo $i?>' ><?php echo $i?></option>
					<?php endif; ?>
				<?php endfor; ?>
			</select>
		</p>
		<?php
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['feedUrl'] = ( ! empty( $new_instance['feedUrl'] ) ) ? $new_instance['feedUrl'] : '';
		$instance['limit'] = ( ! empty( $new_instance['limit'] ) ) ? $new_instance['limit'] : 3;
		return $instance;
	}
}

/**
 * About widget.
 */
class DEV_BIO_AboutWidget extends WP_Widget
{
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			DEVBIO_WIDGET_PREFIX.'about',
			esc_html__( 'DevBio About Me', 'devbio' ),
			array( 'description' => esc_html__( 'Displays your biography', 'devbio' ), )
		);
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo "<div class='content'>$instance[text]</div>";
		echo $args['after_widget'];
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'About Me', 'devbio' );
		$text = ! empty( $instance['text'] ) ? $instance['text'] : esc_html__( 'Somthing about me.', 'devbio' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'devbio' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_attr_e( 'About Me:', 'devbio' ); ?></label>
		 <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
		</p>
		<?php
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? $new_instance['text'] : '';
		return $instance;
	}
}

/**
 * Credits widget.
*/
class DEV_BIO_Credits extends WP_Widget
{
	function __construct() {
		parent::__construct(
			DEVBIO_WIDGET_PREFIX.'credits',
			esc_html__( 'DevBio Credits', 'devbio' ),
			array( 'description' => esc_html__( 'Dispplay credit links to resources used', 'devbio' ), )
		);
	}
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		?>
		<div class='credits'>
			<h2 class='heading'>Credits</h2>
			<div class='content'>
				<ul class='list-unstyled'>
					<li><a href='http://getbootstrap.com/' target='_blank'><i class='fa fa-external-link'></i> Bootstrap</a></li>
					<li><a href='http://fortawesome.github.io/Font-Awesome/' target='_blank'><i class='fa fa-external-link'></i> FontAwesome</a></li>
					<li><a href='http://jquery.com/' target='_blank'><i class='fa fa-external-link'></i> jQuery</a></li>
					<li><a href='https://github.com/IonicaBizau/github-calendar' target='_blank'><i class='fa fa-external-link'></i> GitHub Calendar Plugin</a></li>
					
					<li><a href='http://caseyscarborough.com/projects/github-activity/' target='_blank'><i class='fa fa-external-link'></i> GitHub Activity Stream</a></li>
					
				</ul>
			</div>
		</div>
		<?php
		echo $args['after_widget'];
	}
}

/**
 * Languages widget.
*/
class DEV_BIO_Languages extends WP_Widget
{
	function __construct() {
		parent::__construct(
			DEVBIO_WIDGET_PREFIX.'languages',
			esc_html__( 'DevBio Languages', 'devbio' ),
			array( 'description' => esc_html__( 'List languages you can speak.', 'devbio' ), )
		);
	}
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		?>
		<div class='languages'>
			<h2 class='heading'>Languages</h2>
			<div class='content'>
				<ul class='list-unstyled'>
					<li class='item'>
						<span class='title'><strong>English:</strong></span>
						<span class='level'>Native Speaker <br class='visible-xs'/><i class='fa fa-star'></i> <i class='fa fa-star'></i> <i class='fa fa-star'></i> <i class='fa fa-star'></i> <i class='fa fa-star'></i> </span>
					</li><!--//item-->
					<li class='item'>
						<span class='title'><strong>French:</strong></span>
						<span class='level'>Proficiency <br class='visible-sm visible-xs'/><i class='fa fa-star'></i> <i class='fa fa-star-half'></i></span>
					</li><!--//item-->
				</ul>
			</div>
		</div>
		<?php
		echo $args['after_widget'];
	}
}

/**
 * Education widget.
*/
class DEV_BIO_Education extends WP_Widget
{
	function __construct() {
		parent::__construct(
			DEVBIO_WIDGET_PREFIX.'education',
			esc_html__( 'DevBio Education', 'devbio' ),
			array( 'description' => esc_html__( 'Dispplay your education info', 'devbio' ), )
		);
	}
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		?>
		<div class='education'>
			<h2 class='heading'>Education</h2>
			<div class='content'>
				<div class='item'>
					<h3 class='title'><i class='fa fa-graduation-cap'></i> BSc Information Technology</h3>
					<h4 class='university'>Kwame Nkrumah University of Science and Technology<span class='year'>(2015-2019)</span></h4>
				</div>
			</div>
		</div>
		<?php
		echo $args['after_widget'];
	}
}

/**
 * Skills widget.
*/
class DEV_BIO_SkillsWidget extends WP_Widget
{
	function __construct() {
		parent::__construct(
			DEVBIO_WIDGET_PREFIX.'skills',
			esc_html__( 'DevBio Skills', 'devbio' ),
			array( 'description' => esc_html__( 'Show of your skills.', 'devbio' ), )
		);
	}
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		?>
		 <div class='skills'>
			<h2 class='heading'>Skills</h2>
			<div class='content'>
				<p class='intro'>I have extensive expereince in Oxwall/Skadate and Wordpress development. Some tools in my toolbox includes: </p>
				<div class='skillset'>			   
					<div class='item'>
						<h3 class='level-title'>PHP &amp; MySQL<span class='level-label' data-toggle='tooltip' data-placement='left' data-animation='true' title='You can use the tooltip to add more info...'>Expert</span></h3>
						<div class='level-bar'>
							<div class='level-bar-inner' data-level='96%'>
							</div>                                      
						</div><!--//level-bar-->                                 
					</div><!--//item-->
					<div class='item'>
						<h3 class='level-title'>Javascript &amp; jQuery<span class='level-label'>Expert</span></h3>
						<div class='level-bar'>
							<div class='level-bar-inner' data-level='96%'>
							</div>                                      
						</div><!--//level-bar-->                                 
					</div><!--//item-->
					
					<div class='item'>
						<h3 class='level-title'>HTML5, CSS3, SASS &amp; LESS<span class='level-label'>Expert</span></h3>
						<div class='level-bar'>
							<div class='level-bar-inner' data-level='96%'>
							</div>                                      
						</div><!--//level-bar-->                                 
					</div><!--//item-->
					
					<div class='item'>
						<h3 class='level-title'>Project Management<span class='level-label'>Pro</span></h3>
						<div class='level-bar'>
							<div class='level-bar-inner' data-level='85%'>
							</div>                                      
						</div><!--//level-bar-->                                 
					</div><!--//item-->
					
					<p><a class='more-link' href='https://www.linkedin.com/in/ebenzunlimited/'><i class='fa fa-external-link'></i> More on Linkedin</a></p> 
				</div>              
			</div>  
		</div> 
		<script>
			jQuery(document).ready(function($) {
				/*======= Skillset *=======*/
				
				$('.level-bar-inner').css('width', '0');
				
				$(window).on('load', function() {
					$('.level-bar-inner').each(function() {
					
						var itemWidth = $(this).data('level');
						
						$(this).animate({
							width: itemWidth
						}, 800);
						
					});
				});
				
				/* Bootstrap Tooltip for Skillset */
				$('.level-label').tooltip();				
			});
		</script>
		<?php
		echo $args['after_widget'];
	}
}

/**
 * Info widget.
*/
class DEV_BIO_InfoWidget extends WP_Widget
{
	function __construct() {
		parent::__construct(
			DEVBIO_WIDGET_PREFIX.'info',
			esc_html__( 'DevBio Address', 'devbio' ),
			array( 'description' => esc_html__( 'Dispplays your basic contact info', 'devbio' ), )
		);
	}
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		?>
		 <div class="info">
			<h2 class="heading sr-only">Basic Information</h2>
			<div class="content">
				<ul class="list-unstyled">
					<li><i class="fa fa-map-marker"></i><span class="sr-only">Location:</span>Accra, Ghana</li>
					<li><i class="fa fa-phone"></i><span class="sr-only">Phone:</span>+233-542-443-947</li>
					<li><i class="fa fa-envelope-o"></i><span class="sr-only">Email:</span><a href="mailto://info@eobasi.com">info[at]eobasi.com</a></li>
					<li><i class="fa fa-link"></i><span class="sr-only">Website:</span><a href="http://www.eobasi.com">http://www.eobasi.com</a></li>
				</ul>
			</div>
		</div>
		<?php
		echo $args['after_widget'];
	}
}

add_action( 'widgets_init', function()
{
    register_widget( 'DEV_BIO_AboutWidget' );
	register_widget( 'DEV_BIO_InfoWidget' );
	register_widget( 'DEV_BIO_SkillsWidget' );
	
	register_widget( 'DEV_BIO_Languages' );
	register_widget( 'DEV_BIO_Credits' );
	
	register_widget( 'DEV_BIO_GitHubActivity' );
	register_widget( 'DEV_BIO_GitHubCalender' );
	register_widget( 'DEV_BIO_RssBlog' );
	
	register_widget( 'DEV_BIO_Testimonies' );
	register_widget( 'DEV_BIO_WorkExperience' );
	register_widget( 'DEV_BIO_Education' );	
	
	register_widget( 'DEV_BIO_Projects' );
	register_widget( 'DEV_BIO_Posts' );
});