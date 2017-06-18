<?php
   include("connect_db.php");
   session_start();
   $error = null;
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = $_POST['username'];
      $mypassword = $_POST['password']; 
	  $repeatpassword = $_POST['password-repeat'];
      $type = $_POST['type']; 
      
	  if($mypassword != $repeatpassword)
		  $error = "Incorrect Repeat Password"; 
	  else{ 
	  $sql = "SELECT * FROM login WHERE username = '$myusername'";
      $result = $dbh->prepare($sql);
	  $result->execute();
      $row = $result->fetch(PDO::FETCH_ASSOC);
	  $count = $result->rowCount();
	  if($count != 0)
		  $error = "Your Username has been used";
      else{
	  $nRows = $dbh->query('select count(*) from login')->fetchColumn(); 
	  $userid = $nRows + 1;
      $sql2 = "INSERT INTO login VALUES('$userid', '$myusername', '$mypassword', '$type')";
      $dbh->exec($sql2);
	  
	  $_SESSION['login_user'] = $myusername;
	  $_SESSION['type'] = $type;
	  if($type == "Admin"){
		 header("location: admin/index.php");
	  }else{
		 header("location: index.php");
	  }
	      }
	  }
   }
?>
<html>
<style>
body{
	width: 1000px;
	margin: 20px auto;
	background-color: #f2f2f2;
}	
 /* Bordered form */
form {
    border: 3px solid #f1f1f1;
}

/* Center the avatar image inside this container */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

/* Avatar image */
img.avatar {
    width: 40%;
    border-radius: 5%;
}

/* Full-width input fields */
input[type=text], input[type=password], select{
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

/* Extra styles for the cancel button */
.cancelbtn {
    padding: 14px 20px;
    background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn,.signupbtn {
    float: left;
    width: 50%;
}

/* Add padding to container elements */
.container {
    padding: 16px;
}

/* Clear floats */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
    .cancelbtn, .signupbtn {
       width: 100%;
    }
}
</style>
<body>


<form action="" style="border:1px solid #ccc" method = "post">
	  <div class="imgcontainer">
    <img src="img_avatar2.jpg" alt="Avatar" class="avatar">
  </div>
  <div class="container">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <label><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="password-repeat" required>
    
	<label><b>Account Type</b></label>
	<select id="type" name="type">
    <option value="Admin">Admin</option>
	<option value="Standard">Standard</option>
    </select>
	
    <div style = "font-size:22px; color:#cc0000; text-align:center;"><?php echo $error; ?></div>
	
    <div class="clearfix">
      <button type="button" class="cancelbtn" onclick="location.href='login.php';">Cancel</button>
      <button type="submit" class="signupbtn">Sign Up</button>
    </div>
  </div>
</form>

</body>
</html>
