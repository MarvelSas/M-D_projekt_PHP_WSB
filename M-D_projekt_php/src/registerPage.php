<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/registerPage.css" />
    <title>M&D</title>
    <script type="text/javascript" src="../JavaScript/registerpage.js"></script>
</head>
<body>
    <?php
        //Dołącznie kodu z plików zewnętrznych
        include '../php/User.php';
        include '../php/databaseConnection.php';
        session_start();

        //Sprawdzanie czy użytkownik jest zalogowany  
        if(!empty($_SESSION["loggedUser"])){
            header( "Location: loggedHomePage.php" );
        }    
    ?>




    

    <div class="mainContainer">
     
        <div class="photoSide">
            <img src="../resources/frytki.png" alt="burger" class="chipsPhoto">
        </div>  
        <div class="loginSide">
            <div class="goToHomePageButtonDiv">
                <button class="goToHomePageButton" onclick="openHomePage()" >Wróc do strony gównej</button> 
            </div>
            <div class="logoDiv">
                <span class="logo">M&D</span>
            </div>
            
            <form action="registerPage.php" method="POST">
                <div class="loginDiv">
                    <label for="userLogin" class="loginLabel">login :</label>
                    <input type="text" class="logingInput" id="userLogin" name="logingInput" minlength="6"   required pattern="[^()/><\][\\\x22,;|]+">
                </div>
                <div class="passwordDiv">
                    <label for="userPassword" class="passwordLabel">hasło :</label>
                    <input type="password" class="passwordInput" id="userPassword" name="passwordInput" minlength="10"    required>
                </div>
                <div class="repeatPasswordDiv">
                    <label for="userRepeatPassword" class="repeatPasswordLabel">potwórz hasło :</label>
                    <input type="password" class="repeatPasswordInput" id="userRepeatPassword" name="repeatPasswordInput" minlength="10"   required>
                </div>
                <div class="mailDiv">
                    <label for="mailName" class="mailLabel">e-mail :</label>
                    <input type="email" class="mailInput" id="mailName" name="mailInput"    required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                </div>
                <div class="phoneNumerDiv">
                    <label for="userPhoneNumer" class="phoneNumerLabel">Numer telefonu :</label>
                    <input type="tel" class="phoneNumerInput" id="userPhoneNumer" name="phoneNumerInput" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" title="Wprowadz numer telefonu zgodnie z formatem xxx-xxx-xxx "  required>
                </div>
                
                <div class="errorDiv">
                    
                    <div class="errorBox">
                        <?php
                        

                        //Sprawdzenie czy cały fromularz został wypełniony
                        if((!empty($_POST["logingInput"]) && !empty($_POST["passwordInput"])  && !empty($_POST["repeatPasswordInput"]) && !empty($_POST["mailInput"]) && !empty($_POST["phoneNumerInput"]))){
                            
                            
                            

                            //Sprawdzanie czy hasłą są identyczne
                            if($_POST["passwordInput"]==$_POST["repeatPasswordInput"]){
                                
                                $user = new User($_POST["logingInput"],md5($_POST["passwordInput"]),$_POST["mailInput"],$_POST["phoneNumerInput"],usersRole::Customer);

                                echo $user->getLogin();
                                echo $user->getPassword();
                                echo $user->getPhoneNumber();
                                echo $user->getMail();
                                echo $user->getRole();

                                $user->addToDatabase($connect);

                                header( "Location: logingPage.php" );   

                            }else{
                                echo "Podane hasłą rożnią się"; 
                            }

                        }



                        ?>
                    </div>
                </div>




                <div class="submitDiv">
                    <input type="submit" class="inputSubmit" value="Zarejestruj">
                </div>
                

            </form>
            



            

            
        </div>  

    </div>
    
    




            
        



    
    
</body>
</html>