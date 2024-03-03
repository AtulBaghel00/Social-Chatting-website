<?php

     
    $servername= "localhost";
    $username="root";
    $password="";
    $database="CHAT";
    $conn= mysqli_connect("$servername","$username","$password","$database");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    require_once "../vendor/autoload.php";
    require_once "../core/init.php";

    use classes\{DB, Config, Validation, Common, Session, Token, Hash, Redirect};
    use models\User;

    // First we check if the user is already connected we redirect him to index page
    if($user->getPropertyValue("isLoggedIn")) {
        Redirect::to("../index.php");
    }
    $validate = new Validation();

    $reg_success_message = '';
    $login_failure_message = '';

    if(isset($_POST["login"])) {
        if(Token::check(Common::getInput($_POST, "token_log"), "login")) {
            $validate->check($_POST, array(
                "email-or-username"=>array(
                    "name"=>"Email or username",
                    "required"=>true,
                    "max"=>255,
                    "min"=>6,
                    "email-or-username"=>true
                ),
                "password"=>array(
                    "name"=>"Password",
                    "required"=>true,
                    // Later
                    "strength"=>true
                )
            ));
    
            if($validate->passed()) {
                // Remember $user is created in init file
                $remember = isset($_POST["remember"]) ? true: false;
                $log = $user->login(Common::getInput($_POST, "email-or-username"), Common::getInput($_POST, "password"), $remember);
                
                if($log) {
                    Redirect::to("../index.php");

                        
                     
                    if ($conn->query($sql) ===TRUE) {
                        echo " ";
                    } else {
                        echo "";
                    }
                    
                   
                } else {
                    // Here define a variable with value and display it in error div in case credentials are wrong
                    $login_failure_message = "Either email or password is invalide !";
                }
            } else {
                // Here instead of printing out errors we can put them in an array and use them in proper html labels
                $login_failure_message = $validate->errors()[0];
            }
        } else {
            $validate->addError('Invalide csrf token');
        }
    }

    if(isset($_POST["register"])) {
        $validate = new Validation();
        if(Token::check(Common::getInput($_POST, "token_reg"), "register")) {
            $validate->check($_POST, array(
                "firstname"=>array(
                    "name"=>"Firstname",
                    "min"=>2,
                    "max"=>50
                ),
                "lastname"=>array(
                    "name"=>"Lastname",
                    "min"=>2,
                    "max"=>50
                ),
                "username"=>array(
                    "name"=>"Username",
                    "required"=>true,
                    "min"=>6,
                    "max"=>20,
                    "unique"=>true
                ),
                "email"=>array(
                    "name"=>"Email",
                    "required"=>true,
                    "email-or-username"=>true
                ),
                "password"=>array(
                    "name"=>"Password",
                    "required"=>true,
                    "min"=>6
                ),
                "password_again"=>array(
                    "name"=>"Repeated password",
                    "required"=>true,
                    "matches"=>"password"
                ),
            ));
    
            if($validate->passed()) {
                $salt = Hash::salt(16);
    
                $user = new User();
                $user->setData(array(
                    "firstname"=>Common::getInput($_POST, "firstname"),
                    "lastname"=>Common::getInput($_POST, "lastname"),
                    "username"=>Common::getInput($_POST, "username"),
                    "email"=>Common::getInput($_POST, "email"),
                    "password"=> Hash::make(Common::getInput($_POST, "password"), $salt),
                    "salt"=>$salt,
                    "joined"=> date("Y/m/d h:i:s"),
                    "user_type"=>1,
                    "cover"=>'',
                    "picture"=>'',
                    "private"=>-1,
                
                     
                ));
                $user->add();
                
                mkdir("../data/users/" . Common::getInput($_POST, "username")."/");
                mkdir("../data/users/" . Common::getInput($_POST, "username")."/posts/");
                mkdir("../data/users/" . Common::getInput($_POST, "username")."/media/");
                mkdir("../data/users/" . Common::getInput($_POST, "username")."/media/pictures/");
                mkdir("../data/users/" . Common::getInput($_POST, "username")."/media/covers/");

                $reg_success_message = "Your account has been created successfully.";
                /* The following flash will be shown in the index page if the user is new, and we'll also check if the user registered 
                is the same person log in because the user could create a new account but login with other account, in that case we won't
                show any welcome message*/
                
                Session::flash("register_success", "welcome to Realchat time application");
                Session::flash("new_username", Common::getInput($_POST, "username"));
            } else {
                $login_failure_message = $validate->errors()[0];
            }
        }
    }


// connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CHAT";
$conn = new mysqli($servername, $username, $password, $dbname);

// get the user's IP address or cookie value
$user_identifier = $_SERVER['REMOTE_ADDR']; // use IP address
// $user_identifier = $_COOKIE['user_id']; // use cookie value

// check if the user is logging in or logging out
if ($user_identifier) {
    // update the user's login status in the database
    $sql = "UPDATE users SET onlinecheck = 1 WHERE user_identifier = '$user_identifier'";
    $conn->query($sql);
} else {
    // update the user's logout status in the database
    $sql = "UPDATE users SET onlinecheck = 0 WHERE user_identifier = '$user_identifier'";
    $conn->query($sql);
}

 
 
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realtime</title>
    <link rel='shortcut icon' type='image/x-icon' href='../public/assets/images/favicons/shriram.png' />
    <link rel="stylesheet" href="../public/css/global.css">
    <link rel="stylesheet" href="../public/css/login.css">
    <link rel="stylesheet" href="../public/css/log-header.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- 
responsive for idpad  -->
    <style>
@media screen and (min-device-width:640px) and (max-device-width:1024px) and (orientation:portrait) {
  .wrapper{
    margin-right: -7cm;
    margin-left: 1cm;
    margin-top: 4cm;
    max-width: 448px;
    height:18cm; 
  }
  #registration-section{
    width:400px;
  }
  .form h1{
    font-size: 51px;
  }
  .form form .input input {
    height: 60px;
  }
  .form form .button input{
    height: 60px;
    margin-top: 10px;
    font-size:46px;
  }
}
    </style>
</head>
<body>
    <?php include "../page_parts/basic/log-header.php" ?>
    <main>
        <div class="login-img-reg-container">
            <div id="left-asset-wrapper">
                <!-- <h2 id="login-left-text">“The government doesn't want any system of transmitting information to remain unbroken, unless it's under its own control.” ― Isaac Asimov, Tales of the Black Widowers</h2> -->
                <img src="../public/assets/images/previe.png" id="login-image-preview" alt="">
            </div>
            <div class="wrapper">
            <section class="form login">
            <div id="registration-section">
                <div class="green-message">
                    <p class="green-message-text"><?php echo $reg_success_message; ?></p>
                    <script>
                        if($(".green-message-text").text() !== "") {
                            $(".green-message").css("display", "block");
                        }
                    </script>
                </div>
                <div class="red-message">
                    <p class="red-message-text"><?php echo $login_failure_message; ?></p>
                    <script>
                        if($(".red-message-text").text() !== "") {
                            $(".red-message").css("display", "block");
                        }
                    </script>
                </div>
                <h1>Real Chat Time</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="flex-column">
                    <div class="field input">
                        <!-- <label for="firstname" class="classic-label">Firstname</label> -->
                        <input type="text" name="firstname" value="<?php echo htmlspecialchars(Common::getInput($_POST, "firstname")); ?>" id="firstname" placeholder="Firstname" autocomplete="off"  >
                    </div>
                    <div class="field input">
                        <!-- <label for="lastname" class="classic-label">Lastname</label> -->
                        <input type="text" name="lastname" value="<?php echo htmlspecialchars(Common::getInput($_POST, "lastname")); ?>" id="lastname" placeholder="Lastname" autocomplete="off"  >
                    </div>
                    <div class="field input">
                        <!-- <label for="username" class="classic-label">Username</label> -->
                        <input type="text" name="username" value="<?php echo htmlspecialchars(Common::getInput($_POST, "username")); ?>" id="username" placeholder="Username" autocomplete="off"  >
                    </div>
                    <div class="field input">
                        <!-- <label for="email" class="classic-label">Email</label> -->
                        <input type="text" name="email" value="<?php echo htmlspecialchars(Common::getInput($_POST, "email")); ?>" id="email" placeholder="Email address" autocomplete="off"  >
                    </div>
                    <div class="field input">
                        <!-- <label for="password" class="classic-label">Password</label> -->
                        <input type="password" name="password" id="password" placeholder="Password" autocomplete="off"  ">
                    </div>
                    <div class="field input">
                        <!-- <label for="password_again" class="classic-label">Re-enter you password</label> -->
                        <input type="password" name="password_again" id="password_again" placeholder="Re-enter password" ">
                    </div>
                
                    <div class="field button">
                        <input type="hidden" name="token_reg" value="<?php echo Token::generate("register"); ?>">
                        <input type="submit" value="Register" name="register" class="button-style-1" style="width: 100%;" align-items="center">
                    </div>
                </form>
                <div class="."></div>
            </div>
                    </section>
            </div>
        </div>
    </main>
</body>
</html>