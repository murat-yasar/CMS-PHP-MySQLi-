<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
   <!-- Header -->
   <?php include "includes/admin_header.php"; ?>

   <!-- include DB -->
   <?php include "../user/includes/db.php"; ?>
   
   <?php            
      if(isset($_POST["login"])){
         $inputName = mysqli_real_escape_string($conn, $_POST["username"]);
         $inputPassword = mysqli_real_escape_string($conn, $_POST["password"]);

         $user_query = "SELECT * FROM users WHERE user_name = '{$inputName}' AND user_password = '{$inputPassword}' LIMIT 1";
         $users = mysqli_query($conn, $user_query);

         !$users ? die("SQL Query Failed: " . mysqli_error($conn)) : null;

         while($user = mysqli_fetch_assoc($users)){
            $_SESSION['id'] = $user["user_id"];
            $_SESSION['username'] = $user["user_name"];
            $_SESSION['password'] = $user["user_password"];
            $_SESSION['email'] = $user["user_email"];
            $_SESSION['role'] = $user["user_role"];
         }

         if($inputName === $_SESSION['username'] && $inputPassword === $_SESSION['password'] && $_SESSION['role'] === 'admin'){
            header("Location: index.php");
            exit();
         } else if ($inputName === $_SESSION['username'] && $inputPassword === $_SESSION['password'] && $_SESSION['role'] === 'member'){
            header("Location: ../user/index.php");
            exit();
         } else {
            header("Location: login.php");
            exit();
         } 
      }
   ?>

   <body class="bg-dark">
      <div class="container">
         <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login</div>
            <div class="card-body">
               <form method="POST">
                  <div class="form-group">
                     <label for="inputUsername">Username</label>
                     <div class="form-label-group">
                        <input type="text" id="inputUsername" name="username" class="form-control" placeholder="username" autofocus="autofocus" required>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="inputPassword">Password</label>
                     <div class="form-label-group">
                        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="password" required>
                     </div>
                  </div>
                  <button class="btn btn-primary btn-block" name="login" type="submit">Login</button>
               </form>
            </div>
         </div>
      </div>

      <!-- Scripts -->
      <?php include "includes/admin_scripts.php"; ?>
   </body>

</html>