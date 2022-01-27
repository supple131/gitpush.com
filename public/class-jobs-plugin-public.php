<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       broiler.com
 * @since      1.0.0
 *
 * @package    Jobs_Plugin
 * @subpackage Jobs_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Jobs_Plugin
 * @subpackage Jobs_Plugin/public
 * @author     M Bilal <muhammadbilalsupple.com>
 */
class Jobs_Plugin_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jobs_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jobs_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jobs-plugin-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jobs_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jobs_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jobs-plugin-public.js', array( 'jquery' ), $this->version, false );

	} 
	//template for the single job page
	function single_job_template($single){
		global $post;
		if($post->post_type == "jobs"){
				if(file_exists(plugin_dir_path( __FILE__ ). 'partials/single-jobs.php')){
				return plugin_dir_path( __FILE__ ). 'partials/single-jobs.php';

			}
		}
		return $single;
	}


	// function that runs when shortcode is called
	function wpb_demo_shortcode() { 
		 $args = array(
            'post_type'      => 'jobs',
            'posts_per_page' => '-1',
            'publish_status' => 'published',
         );
		$query = new WP_Query( $args ); ?>
		<h1>jobs Board</h1>
    	<form action=""  method="get">	
		<select name= 'city' id="city">
			<option value="">select city</option>
		<?php 		
        $cityarray=array();
        while($query->have_posts()) {
        $query->the_post();
        $jobid=get_the_ID();
        $getdata = get_post_meta($jobid, 'hcf_location', true);
        if(in_array($getdata,$cityarray) == false){
        ?>
                <option value="<?php echo $getdata; ?>"><?php echo $getdata; ?></option>
            <?php
            array_push($cityarray,$getdata);
            }
        } ?>
		</select>
	
	<!--select the category fetch the data from taxonomy -->
	<select name='category' id="category">
		<option value="" select category>select category</option>
		<?php
		$categoryarray=array();
        while($query->have_posts()) {
        $query->the_post() ;
        $jobid=get_the_ID();
		
        $gettax = wp_get_post_terms( $jobid, 'jobs-category');
        foreach($gettax as $jobtax) {
		if(in_array($jobtax->name,$categoryarray) == false){
		echo    '<option value="'. $jobtax->name .'">'. $jobtax->name .'</option>';
		array_push($categoryarray,$jobtax->name);      
					}          
				}          
                  } ?>
		</select>
		<input type="range" min="1" max="100" value="50" class="slider" id="myRange">
		<input type="submit" value="Go!" name='submit'>
				</form>
		
		<?php
					wp_reset_postdata() ;

			//this is to show three jobs at the bottom
		if(isset($_GET['submit'])){
			$jobCity=$_GET['city'];
			$jobCategory=$_GET['category'];
			//meta query for filtering the data
			$args = array(
				'post_type'      => 'jobs',
				'posts_per_page' => '-1',
				'publish_status' => 'published',
			 );
			 while($query->have_posts()) {
				$query->the_post();
				$jobid=get_the_ID();
				$gettax = wp_get_post_terms( $jobid, 'jobs-category');
				foreach($gettax as $jobtax) {
				$categoryName=  $jobtax->name ;        
				} 	
				$cityname = get_post_meta($jobid, 'hcf_location', true);
				if($jobCity == $cityname and $categoryName == $jobCategory ){?>
					<li><a href="<?php echo get_the_permalink();?>"><?php the_title()?></a></li>
				<?php } else if(!empty($jobCity) and empty($jobCategory)){
					if($jobCity ==$cityname){?>
						<li><a href="<?php echo get_the_permalink();?>"><?php the_title()?></a></li>
					<?php }
				}else if(empty($jobCity) and !empty($jobCategory)){
					if($jobCategory == $categoryName){
						?>
						<li><a href="<?php echo get_the_permalink();?>"><?php the_title()?></a></li>
					<?php

					}
				}

			 }


			
		}else{
			$args = array(
				'post_type'      => 'jobs',
				'posts_per_page' => '3',
				'publish_status' => 'published',
			 );
				
			$query = new WP_Query($args);
			while($query->have_posts()) {
			$query->the_post() ;
			$jobid=get_the_ID(); ?>
			
				<ul>
					<li><a href="#"><?php the_title(); ?></a></li>
				</ul>
			
				
	<?php    }  
			wp_reset_postdata() ;
		}
			
		}	

		
	
	}

