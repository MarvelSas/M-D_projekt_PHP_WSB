<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/logingPage.css" />
    <title>M&D</title>
    <script type="text/javascript" src="../JavaScript/logingpage.js"></script>
</head>
<body>

    <?php
        //Dołącznie kodu z plików zewnętrznych
        include '../php/User.php';
        include '../php/databaseConnection.php';
        include '../php/Cart.php';
        session_start();


        //Sprawdzanie czy użytkownik jest zalogowany
        if(!empty($_SESSION["loggedUser"])){
            header( "Location: loggedHomePage.php" );
        }

    ?>


    <div class="mainContainer">
     
        <div class="photoSide">
            <img src="../resources/burger.png" alt="burger" class="burgerPhoto">
        </div>  
        <div class="loginSide">
            <div class="goToHomePageButtonDiv">
                <button class="goToHomePageButton" onclick="openHomePage()" >Wróc do strony gównej</button> 
            </div>
            <div class="logoDiv">
                <span class="logo">M&D</span>
            </div>
            
            <form action="logingPage.php" method="POST">
                <div class="loginDiv">
                    <label for="userLogin" class="loginLabel">login :</label>
                    <input type="text" class="logingInput" id="userLogin" name="logingInput" required  pattern="[^()/><\][\\\x22,;|]+" >
                </div>
                <div class="passwordDiv">
                    <label for="userPassword" class="passwordLabel">hasło :</label>
                    <input type="password" class="passwordInput" id="userPassword" name="passwordInput" required  >
                </div>
                <div class="submitDiv">
                    <input type="submit" class="inputSubmit" value="Zaloguj">
                </div>

            </form>

            <div class="errorDiv">
                    
                    <div class="errorBox">
                        <?php
                            

                            //Sprzwdznie czy dane formularza są wypełnione
                            if(!empty($_POST["logingInput"]) && !empty($_POST["passwordInput"])){

                                //Wyszukiwanie użytkownika po loginie
                                $sql = "SELECT * FROM users WHERE login='".$_POST["logingInput"]."' and password='".md5($_POST["passwordInput"])."'";
                                $row = $connect->query($sql)->fetch_assoc();

                                if(!empty($row["Login"])){

                                    $loggedUser = new User($row["Login"],$row["Password"],$row["Mail"],$row["PhoneNumber"],$row["Role"]);    
                                    $loggedUser->SetId($row["Id"]);
                                    $loggueUserCart = new Cart($row["Id"]);

                                    echo $loggedUser->GetId();
                                    
                                    $_SESSION["loggedUser"] = serialize($loggedUser);

                                    $_SESSION["loggueUserCart"] = serialize($loggueUserCart);

                                    header( "Location: loggedHomePage.php" );
                                       
                                     
                                }else{
                                    echo "Podany login lub hasło jest nieprawidłowe"; 
                                }
                                
                                
                                

                            }else{  

                            }



                        ?>
                    </div>
                </div>


                <div class="dontHaveAccountSpanDiv">
                    <span class="dontHaveAccountSpan">Nie masz konta?</span>
                </div>
                <div class="createNewAccountButtonDiv">
                    <button class="createNewAccountButton" onclick="openRegisterPage()" >Założ konto</button>
                </div>

            
            
            
        </div>  

    </div>
    
    




            
        



    
    
</body>
</html>