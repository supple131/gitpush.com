
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: black;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: black;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>


<h3>Apply Now</h3>


    <div class="container">
    <form action="" method="POST">
    
    <p class="Application_field_data">
    <label for="Full_Name">Full Name</label>
    <input type="text" id="fname" name="firstname" placeholder="Your name.." >
    </p>
    
    <p class="Application_field_data">
    <input type="text" id="lname" name="lastname" placeholder="Your last name.." >
    </P>

    <p class="Application_field_data">
    <label for="fname">Birth Date</label>
    <input type="text"  name="birth" placeholder="MM/DD/YYYY"
        onfocus="(this.type='date')"
        onblur="(this.type='text')"
        value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'Full_Name', true ) ); ?>"
        >
    </P>                                 

    <p class="Application_field_data">
    <label for="fname">Email Address</label>
    <input type="text" id="email" name="EmailAddress" placeholder="Email Address" >
    </p>

    <p class="Application_field_data">
    <label for="phone_Number">phone Number</label>
    <input type="text" id="cell" name="cell" placeholder="phone Numberrr">
    </p>

    <p class="Application_field_data">
    <label for="current_address">current address</label>
    <input type ="text" id="address" name=" address" placeholder="current address" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'current_address', true ) ); ?>"></textarea>
    </p>

    <p class="Application_field_data">
    <input type="file" id="myFile" name="filename">
    <br><br>
    <input type="submit" value="submit" name="submit">
    </p>
  
          <?php 
     
     if(isset($_POST['submit'] )){
      
        $getfirstname=$_POST['firstname'];
        $getlasttname=$_POST['lastname'];
        $getdatebirth=$_POST['birth'];
        $getemail=$_POST['EmailAddress'];
        $getcell=$_POST['cell'];
        $getaddress=$_POST['address'];
        $getfile=$_POST['filename'];
        $concat = $getfirstname . $getlasttname;
        $jobs_name= get_the_title();  
        $new = array(
          'post_type' => 'application',
          'post_status' => 'publish',
          'post_title' => $concat,   
        );
           
          
        $application=wp_insert_post( $new );
        update_post_meta( $application, 'firstname', $_POST['firstname'] );
        update_post_meta( $application, 'lastname', $_POST['lastname'] );
        update_post_meta( $application, 'birth', $_POST['birth'] );
        update_post_meta( $application, 'EmailAddress', $_POST['EmailAddress'] );
        update_post_meta( $application, 'cell', $_POST['cell'] );
        update_post_meta( $application, 'address', $_POST['address'] ); 
        update_post_meta( $application, 'filename', $_POST['filename'] );
        update_post_meta( $application, 'jobs_name' , $jobs_name );
        echo "submitted";  
        return;
      }
     
      
      
    ?>
  </form>
</div>



