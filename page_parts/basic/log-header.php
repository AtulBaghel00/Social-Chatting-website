<?php
    use classes\{Config, Common, Token, Validation, DB, Redirect};
    use models\User;

    $pathToLogo = Config::get("root/path");

?>

<header>
    <div>
        <a href="<?php echo Config::get("root/path") . "index.php"; ?>"><img src="<?php echo $pathToLogo ?>public/assets/images/logos/shriram.png" alt="logo" class="wide-logo"></a>
    </div>
    <div class="inline-logo-separator"></div>
    <div id="menu-login-credentials-container">
        <!-- <div style="margin: 0 12px"></div> -->
        <div class="flex-column">

            <!----------------------  EMAIL OR USERNAME  ---------------------->
            <!-- <label for="username-or-email" class="small-label">Username or email</label> -->
            <input type="text" name="email-or-username" id="username-or-email" tabindex="1" autocomplete="off" value="<?php echo htmlspecialchars(Common::getInput($_POST, 'email-or-username'));?>" class="text-input medium-text-input" form="login-form" placeholder="Email">
            
            <!----------------------  REMEMBER ME  ---------------------->
            <div class="row-v-flex">
                <input type="checkbox" tabindex="3" name="remember" form="login-form" checked>
                <label class="small-label" for="remember">Kepp me connected</label>
            </div>
        </div>
        <div style="margin: 0 4px"></div>
        <div class="flex-column">

            <!----------------------  PASSWORD  ---------------------->
            <!-- <label for="password" class="small-label">Password</label> -->
            <input type="password" name="password" tabindex="2" autocomplete="off" id="password" class="text-input medium-text-input" form="login-form" placeholder="Password">
            <a href="<?php echo Config::get("root/path");?>login/passwordRecover.php" tabindex="5" class="link">Forgotten your passowrd?</a>

        </div>
        <div style="margin: 0 4px"></div>
        <form action="<?php echo htmlspecialchars(Config::get("root/path")) . "Login/login.php" ?>" method="post" class="flex-form" id="login-form">
            <input type="hidden" name="token_log" value="<?php echo Token::generate("login"); ?>">

            <!----------------------  LOGIN  ---------------------->
            <input type="submit" name="login" tabindex="4" value="Login" class="button-style-1">
        </form>
        <!-- <div style="margin: 0 12px 0 4px"></div> -->
    </div>
</header>

<!-- Responsive for an ipad -->
<head>
<style>
@media screen and (min-device-width:640px) and (max-device-width:1024px) and (orientation:portrait) {
    
    body{
		max-width: 1262px;
		width: 100%;
		overflow-x: hidden;
	}
    header{
        width: 1262px;
    }

    #menu-login-credentials-container{
        margin-left: 12cm;
    }
    .medium-text-input{
        width: 228px;
        height: 1.3cm;
    }
    .button-style-1{
        height: 1.5cm;
    width: 1.8cm;
    }
}
</style>
</head> 