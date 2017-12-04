<?php
	$page_title = "Profile"; 
  include_once "partials/headers.php";
	include_once "partials/parseProfile.php";
?>
    <div class="container">

      <?php if(!isset($_SESSION['username'])) : ?>
			<p class ="lead">You are not authorized to view this page. <a href="login.php">Login</a> Not yet a member?<a href="signup.php">Sign up</a></p>
	  	<?php else: ?>
			   <section>
            <table class="table table-bordered table-condensed">
              <tr><th style="width: 20%; ">Username:</th><td><?php if(isset($username)) echo $username ?></td></tr>
               <tr><th>Email:</th><td><?php if(isset($email)) echo $email ?></td></tr>
                <tr><th>Date Joined:</th><td><?php if(isset($date_joined)) echo $date_joined ?></td></tr>
                 <tr><th><td><a class="pull-right" href="edit-profile.php?user_identity=<?php if(isset($encode_id)) echo $encode_id; ?>"><span class="glyphicon glyphicon-edit">Edit Profile</span></a></td></th></tr>
            </table>   
         </section>
	  	<?php endif ?>

      </div>

    <!--   <?php echo $_SERVER['REMOTE_ADDR'] . "<br>" . $_SERVER['HTTP_USER_AGENT'] ?> -->
      
    </div><!-- /.container -->
<?php 
	include_once "partials/footers.php";
 ?>


