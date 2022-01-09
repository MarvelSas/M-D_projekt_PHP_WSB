<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/loggedUserProfile.css" />
    <title>M&D</title>
    <script type="text/javascript" src="../JavaScript/loggedUserProfile.js"></script>
</head>
<body>

        <?php
            session_start();
            include '../php/User.php';
            include '../php/databaseConnection.php';
            include '../php/Cart.php';

            //Sprawdzanie czy użytkownik jest zalogowany
            if(empty($_SESSION["loggedUser"])){
                header( "Location: index.php" );
            }    

            //Deserializcja użytnownika
            $loggedUser = unserialize($_SESSION["loggedUser"]);

            //Deserializacja koszyka
            $loggueUserCart = unserialize($_SESSION["loggueUserCart"]);
        ?>
        
        <div class="mainContainer">
            <nav class="navBar">
                <div class="logo">
                    M&D
                </div>
                <div class=linkList>
                <?php
                        //Personalizacja okna pod określonego użytkwnika
                        switch ($loggedUser->GetRole()) {
                            case 0:
                                echo (' <a href="loggedHomePage.php" class="link">Strong główna</a>
                                        <a href="loggedMenuPage.php" class="link">Menu</a>
                                        <a href="loggedOrderList.php" class="link">Zamówienia</a>
                                        <a href="loggedUserProfile.php" class="link">Profil</a>
                                        <a href="loggedCartList.php" class="link">Koszyk</a>');
                                break;
                            case 1:
                                echo (' <a href="loggedHomePage.php" class="link">Strong główna</a>
                                        <a href="loggedMenuPage.php" class="link">Menu</a>
                                        <a href="loggedMenageProductsPage.php" class="link">Zarządzaj produktami</a>
                                        <a href="loggedOrderList.php" class="link">Zamówienia</a>
                                        <a href="loggedUserProfile.php" class="link">Profil</a>
                                        <a href="loggedCartList.php" class="link">Koszyk</a>');
                                break;
                        }


                    ?>
                </div>
                <div class="space">
                    
                </div>
                
                    <div class="userIcon">
                       
                        
                            <img src="../resources/icons8-user-male-100.png" class="userIconImg">
        
                    </div>
                
                <div class="userLogin">
                    <span><?php echo $loggedUser->GetLogin(); ?></span>
                </div>
                
                <form action="loggedHomePage.php" method="POST" class="logOutForm">
                    <input type="submit" class="logOutButton" value="Wyloguj" name="logOutSubmit">
                </form>

                
                
            </nav>


            <?php

                //Po wciśnięciu przycisku wyloguj urzytkownik zostje przenienisony do storny głównej 
                //a seja jest usuwana
                    if(isset($_POST['logOutSubmit'])){
                        session_destroy();
                        header( "Location: index.php" );
                    }

            ?>

            <div class="contextContainer">
                    
                <div class="photoContainer">
                    <img src="../resources/19881.png" class="changeUserImagine" >
                </div>    
                <div class="changeUserFormConatiner" >
                    <form action="loggedUserProfile.php" method="POST" >
                        <div class="innerChangeUserFormConatiner">
                            <div class="ChangeUserFormLogo">M&D</div>
                            <div class="ChangeUserFormLogin">
                                <label class="lableformline" for="ChangeUserFormLogin">Login: </label>
                                <input type="text" class="forminputLogin" id="ChangeUserFormLogin" name="ChangeUserFormLogin" value=<?php echo $loggedUser->getLogin() ?> disabled>
                            </div>
                            <div class="formline">
                                <label class="lableformline" for="ChangeUserFormEmail">e-mail: </label>
                                <input type="email" class="forminputEmail" id="ChangeUserFormEmail" name="ChangeUserFormEmail"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required value=<?php echo $loggedUser->getMail() ?>  >
                            </div>
                            <div class="formline">
                                <label class="lableformline" for="ChangeUserFormPhoneNr">Numer Telefonu: </label>
                                <input type="tel" class="forminputPhoneNr" id="ChangeUserFormPhoneNr" name="ChangeUserFormPhoneNr" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" title="Wprowadz numer telefonu zgodnie z formatem xxx-xxx-xxx " require value=<?php echo $loggedUser->getPhoneNumber() ?>  >
                            </div>
                            <div class="formlineButton">
                                <input type="submit" class="forminputSubtmit"  name="ChangeUserFormSubtmit"  value="Zmień">
                            </div>
                            <div class="formline">
                                <a class="linkToChangePassword" href="loggedChangePassword.php" >Zmień hasło</a>
                            </div>   
                        </div>
                    </form>
                        
                    <?php

                        if(isset($_POST["ChangeUserFormSubtmit"])){

                            
                            //Zmiana informacji w użytkuwniku w istniejącej sesji
                            $loggedUser->setMail($_POST["ChangeUserFormEmail"]);
                            $loggedUser->setPhoneNumber($_POST["ChangeUserFormPhoneNr"]);

                            $_SESSION["loggedUser"] = serialize($loggedUser);
                            
                            //Aktualizowanie użytkownika w bazie
                            $sql = "UPDATE `users` SET `Mail`='".$_POST["ChangeUserFormEmail"]."',`PhoneNumber`='".$_POST["ChangeUserFormPhoneNr"]."' WHERE `Id`=".$loggedUser->getId();
                           
                            $connect->query($sql);





                            echo "<script> window.location.href='loggedUserProfile.php';</script>";
                            
                        }

                    ?>
                    
                </div>
                
            </div>    
                
        </div>
              






            
        



    
    
</body>
</html>