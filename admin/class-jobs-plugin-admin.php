<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       broiler.com
 * @since      1.0.0
 *
 * @package    Jobs_Plugin
 * @subpackage Jobs_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Jobs_Plugin
 * @subpackage Jobs_Plugin/admin
 * @author     M Bilal <muhammadbilalsupple.com>
 */
class Jobs_Plugin_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jobs-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jobs-plugin-admin.js', array( 'jquery' ), $this->version, false );

	}
	// Our custom post type function
function create_cptposttype() {
 
    register_post_type( 'jobs',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'jobs Board' ),
            ),
            'public' => true,	
            'has_archive' => true,
            'rewrite' => array('slug' => 'jobs Board'),
            'show_in_rest' => true,
			'show_in_menu' => true,
			'show_in_admin_bar'=>true,
			'supports'=>array('title'
			)
        )
    );
}

function add_custom_metabox() {
		add_meta_box(
			'meta_box_id',                 // Unique ID
			'Custom_Meta_box',      // Box title
			array($this, 'call_back_function'),  // Content callback, must be of type callable
			'jobs'                            // Post type
		);	
	}

	// call back function and using for get the custom metabox data data

	function call_back_function( $post ) {
		?>
		<p class="meta-options hcf_field">
        <label for="hcf_location">Location</label><br>
        <input id="hcf_location" type="text" name="hcf_location"  value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'hcf_location', true ) ); ?>">
    	</p>
		<p class="meta-options hcf_field">
        <label for="hcf_author">Salary range</label><br>
		<input type="range" min="1" max="100" value="50" class="slider" id="myRange">
    	</p>
		<p class="meta-options hcf_field">
        <label for="hcf_published_time">Timings</label><br>
        <input id="hcf_published_time" type="text" name="hcf_published_time"  value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'hcf_published_time', true ) ); ?>">
    	</p>
		<p class="meta-options hcf_field">
        <label for="hcf_benefit"> Benefits</label><br>
        <input id="hcf_benefit" type="text" name="hcf_benefit" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'hcf_benefit', true ) ); ?>">
    	</p>
		<?php
	}

	/**
 * Save meta box content.// get the content in the meta box 
 *
 * @param int $post_id Post ID
 */
function save_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
    $fields = [
        'hcf_location',
        'hcf_published_time',
        'hcf_benefit',
    ];
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_POST ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
        }
     }
}


	//add taxonomy  
function create_jobs_taxonomy() {
 
	// Labels part for the GUI
	 
	  $labels = array(
		'name' => _x( 'jobs-category', 'taxonomy general name' ),
		'singular_name' => _x( 'jobs', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search jobs-category' ),
		'popular_items' => __( 'Popular jobs-category' ),
		'all_items' => __( 'All jobs-category' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit jobs-category' ), 
		'update_item' => __( 'Update Topic' ),
		'add_new_item' => __( 'Add New Topic' ),
		'new_item_name' => __( 'New Topic Name' ),
		'separate_items_with_commas' => __( 'Separate jobs-category with commas' ),
		'add_or_remove_items' => __( 'Add or remove jobs-category' ),
		'choose_from_most_used' => __( 'Choose from the most used jobs-category' ),
		'menu_name' => __( 'jobs-category' ),
	 ); 

	// Now register the non-hierarchical taxonomy like tag
	
	register_taxonomy('jobs-category','jobs',array(
		'hierarchical' => false,
		'labels' => $labels,
		'show_ui' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'jobs' ),	
	));
	}
	
// Our custom post type function
function create_2ntsptfile() {
 
    register_post_type( 'application',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Application'),
            ),
            'public' => true,
            'has_archive' => true,
			'menu_icon' => 'dashicons-universal-access',
            'rewrite' => array('slug' => 'Application
			'),	
            'show_in_rest' => true,
			'show_in_menu' => true,
			'show_in_admin_bar'=>true,
			'supports'=>array('title'
			)	
        )
    );
}


//add coulmn in cpt file in wordpress 
function application_cpt_columns($column) {

	//Add custom columns
	return array(
		'Title' => __('Title', 'application'),
		'author' => __('author', 'application'),
		'jobs_name' => __('jobs_name', 'application'),
		'application_status' => __('application  status', 'application'),
		'Date' => __('Date', 'application'),
	);
}
// get the value get_post_meta function from single_jobs.php
  function acf_admin_custom_columns( $column, $application ) {
	switch($column) {
	 	case 'jobs_name':
		echo (get_post_meta ( $application, 'jobs_name', true ) ) ;
		break; 
		//get application status data from taxonomy
		case 'application_status':
		$applicationstatus=wp_get_post_terms(  $application,  'application_category');
		foreach($applicationstatus as $applicationstatus){
		echo $applicationstatus ->name;
		}	
		break;
			
		case 'jobs_name':
	 	case 'application':
		echo get_post_meta($column, $post_id);
       	break; 
   }   
}


//user receive an email when application status is changed
function send_mail_when_status_changed($data, $postarr, $unsanitized_postarr   ){

	
	if($data['post_type']!='application'){ //checking if the post type is application
		return $data;
	}
	$post_ID=!empty($postarr['ID']) ? $postarr['ID'] :'';
	//getting the updated taxonomy ID
	$updated_status_ID=!empty($postarr['tax_input']['application_category'][1]) ? $postarr['tax_input']['application_category'][1] : '';//here
	//getting the name of the updated status
	$updated_status_term=	get_term($updated_status_ID );
	$updated_status_name=  !empty($updated_status_term->name) ?$updated_status_term->name: ''; //here
	$updated_status_name=  strtolower($updated_status_name);
	
	//getting the id of the post author
	$post_user_id=$data['post_author'];
	//getting the email of the post author
	$user_email = get_the_author_meta( 'user_email',$post_user_id);
	//fethcing the previous taxonomy status ID from the database
	$terms = wp_get_object_terms( $post_ID, 'application_category');
	$old_status_ID='';
	foreach ( $terms as $term ) {
		$old_status_ID=$term->term_id; 
	} 
	if($old_status_ID!=$updated_status_ID){
		if($updated_status_name=='approve'){
			// Email subject"
			$subject = 'Your Application Status';
			
			// Email body
			$message = 'Your Application for the Job was Approve';
			
			wp_mail( $user_email, $subject, $message );
			echo 'your status is approve';
			die();
		}else if($updated_status_name=='reject'){
			// Email subject, "New {post_type_label}"
			$subject = 'Your Application Status';
			
			// Email body
			$message = 'Your Application for the Job was Rejected ';
			
			wp_mail( $user_email, $subject, $message );
			echo 'your status is reject';
			die();
		}else if($updated_status_name=='pending'){
			// Email subject, "New {post_type_label}"
			$subject = 'Your Application Status';
			
			// Email body
			$message = 'Your Application for the Job was Pending ';
			
			wp_mail( $user_email, $subject, $message );
			echo 'your status is pending';
			die();	
		}
	}
	return $data;
} 
			function add_custom_metabox1() {
				add_meta_box(
					'meta_box_id',                 // Unique ID
					'Custom_Meta_box',      // Box title
					array($this, 'call_back_function1'),  // Content callback, must be of type callable
					'Application'                            // Post type
				);	
			}

// call back function and using for get the custom metabox data data
	//add taxonomy  
	function create_application_taxonomy() {
 
		// Labels part for the GUI
		 
		  $labels = array(
			'name' => ( 'application'),
			'singular_name' => _x( 'application', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search jobs-category' ),
			'popular_items' => __( 'Popular jobs-category' ),
			'all_items' => __( 'All application-category' ),
			'parent_item' => null,
			'parent_item_colon' => ('Parent Location:'),
			'edit_item'         => __( 'Edit Course' ),
			'update_item' => __( 'Update Topic' ),
			'add_new_item' => __( 'Add New Topic' ),
			'new_item_name' => __( 'New Topic Name' ),
			'separate_items_with_commas' => __( 'Separate application-category with commas' ),
			'add_or_remove_items' => __( 'Add or remove application-category' ),
			'choose_from_most_used' => __( 'Choose from the most used application-category' ),
			'menu_name' => __( 'application-category' ),
				
		 ); 

		// Now register the non-hierarchical taxonomy like tag
		
		register_taxonomy('application_category','application',array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,		
			'rewrite' => array( 'slug' => 'applications' ),	
		));
		}

		
function call_back_function1($post) {
	?>
	<div class="custom post type">
	<form action="" method="POST">
	
	<p class="">
	<label for="firstname">Full Name</label><br>
	<input type="text" id="firstname" name="firstname"  placeholder="Your last name.."  value="<?php echo get_post_meta( $post->ID, 'firstname', true ); ?>">
	</p> 

	<P>
	<input type="text"  id="lastname" name="lastname" placeholder="Your last name.." value="<?php echo esc_attr( get_post_meta( $post->ID, 'lastname', true ) ); ?>">
	</P>

	<p class="">
	<label for="birth"> Date of Birth</label><br>
	<input type="text" id="birth"  name="birth" placeholder="MM/DD/YYYY"
        onfocus="(this.type='date')"
        onblur="(this.type='text')"value="<?php echo esc_attr( get_post_meta( $post->ID, 'birth', true ) ); ?>">

	</p>
	<p class="">
	<label for="EmailAddress">Email Address</label><br>
	<input type="text" id="EmailAddress" name="EmailAddress" placeholder="Email Address.." value="<?php echo esc_attr( get_post_meta( $post->ID, 'EmailAddress', true ) ); ?>">
	</p>
	

	<p class="">
	<label for="cell">phone Number</label><br>
    <input type="text" type="text" id="cell" name="cell" placeholder="phone Number"  value="<?php echo esc_attr( get_post_meta( $post->ID, 'cell', true ) ); ?>">
    </P>

	<p class="">
	<label for="address">current address</label><br>
    <input type="text" type ="text" id="address" name= "address" placeholder="current address" value="<?php echo esc_attr( get_post_meta( $post->ID, 'address', true ) ); ?>"></textarea>
    </P>
	
	<p class="">
	<input type="file" id="myFile" name="filename">
    <br><br>
    <input type="submit" value="submit" name="submit">
    </P>
	</div>
	<?php

	}


		/**
	 * Register the menu and sub menu items for the admin area
	 *
	 * @since    1.0.0
	 */
public function my_admin_menu(){
	add_menu_page( 'WP10 General Settings', 'API plugin', 'manage_options', 'wp10test/wp10settingsgeneral.php', array( $this , 'wp10settingscallback') , 'dashicons-heart', 250  );
	add_submenu_page( 'wp10test/wp10settingsgeneral.php', 'Sub 1', 'API Importer', 'manage_options', 'wp10test/wp10importer.php', array( $this , 'wp10importercall' ));
}	
	public function wp10settingscallback(){
		//return views
			require_once 'partials/jobs-plugin-admin-display.php';
	}
	public function wp10importercall(){
		//return views	
		require_once 'partials/submenu-page.php';
		}

function wporg_settings_init() {
    // Register a new setting for "wporg" page.
    register_setting( 'wporg', 'wporg_options' );
	register_setting( 'wporg', 'last_name' );
	register_setting( 'wporg', 'Optional' );
    // Register a new section in the "wporg" page.
    add_settings_section(
        'wporg_section_developers',
        __( 'The Matrix has you.', 'wporg' ), '',
        'wporg'
    );
 
    // Register a new field in the "wporg_section_developers" section, inside the "wporg" page.
    add_settings_field(
        'wporg_field_pill', // As of WP 4.6 this value is used only internally.
    // Use $args' label_for to populate the id inside the callback.
            __( '', 'wporg' ),
        array($this ,'wporg_field_pill_cb'),
        'wporg',
        'wporg_section_developers', 
    );
}

function wporg_section_developers_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'wporg' ); ?></p>	
    <?php
}

function wporg_field_pill_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'wporg_options' );
	$lastname= get_option( 'last_name' );
	$Optional= get_option( 'Optional' );
    ?>
	
	<h2>First name:</h2>
    <input type="text" id="wporg_options" name='wporg_options' value="<?php echo  $options; ?>"><br><br>
	<h2>Last name:</h2>
	<input type="text" id="last_name" name='last_name' value="<?php echo $lastname; ?>"><br><br>
	<h2> Email:</h2>
	<input type="text" id="Optional" name='Optional' value="<?php echo $Optional; ?>"><br>
    <?php
 	}

}

 