<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");

    $account = new Account($conn);

    if(isset($_POST["submitButton"])) {
        
        $username = FormSanitizer::sanitizerFormUsername($_POST["username"]);
        $password = FormSanitizer::sanitizerFormPassword($_POST["password"]);

        $success = $account->login($username, $password);

        if($success) {

            $_SESSION["userLoggedIn"] = $username;
            //Store session 
            header("Location: index.php");
        };
    }

    function getInputValue($name) {
        if(isset($_POST[$name])) {
            echo $_POST[$name];
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Nelfix Clone</title>
        <link rel="stylesheet" href="assets/styles/styles.css" type="text/css" >
    </head>
    <body>
        <div class="signInContainer">
            <div class="column">
                <div class="header">
                    <img src="assets/images/logo.png" alt="logo">
                    <h3 class="title">Sign In</h3>
                    <span>to continue to Netflix Fake</span>
                    
                </div>
                <form method="POST">

                    <?php echo $account->getError(Constants::$loginFailed); ?> 
                    <input type="text" name="username" placeholder="Username" value="<?php getInputValue("username"); ?>" required>
                    <input type="password" name="password" placeholder="Password" required>
                    
                    <input type="submit" name="submitButton" value="SUBMIT">
                </form>

                <a href="register.php" class="signInMessage">Need an account? Sign up here</a>
            </div>
        </div>
    </body>
</html>