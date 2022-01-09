<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/loggedChangePassword.css" />
    <title>M&D</title>
    <script type="text/javascript" src="../JavaScript/loggedChangePassword.js"></script>
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
                    <form action="loggedChangePassword.php" method="POST" >
                        <div class="innerChangeUserFormConatiner">
                            <div class="ChangeUserFormLogo">M&D</div>
                            <div class="ChangeUserFormOldPassword">
                                <label class="lableformline" for="ChangeUserFormOldPassword">Stare hasło: </label>
                                <input type="password" class="forminputOldPassword" id="ChangeUserFormOldPassword" name="ChangeUserFormOldPassword" required>
                            </div>
                            <div class="formline">
                                <label class="lableformline" for="ChangeUserFormNewPassword">Nowe hasło: </label>
                                <input type="password" class="forminputNewPassword" id="ChangeUserFormNewPassword" name="ChangeUserFormNewPassword"  required  >
                            </div>
                            <div class="formline">
                                <label class="lableformline" for="ChangeUserFormConfirmNewPassword">Potwórz hasło: </label>
                                <input type="password" class="forminputConfirmNewPassword" id="ChangeUserFormConfirmNewPassword" name="ChangeUserFormConfirmNewPassword" required>
                            </div>
                            <div class="formline">
                                <input type="submit" class="forminputSubtmit"  name="ChangeUserFormSubtmit" value="Zmień">
                            </div>
                            
                        </div>
                    </form>

                    <?php

                        if(isset($_POST["ChangeUserFormSubtmit"])){

                            
                            //Sprawdzanie poprawności wprowadzenia starego hasła
                            if($loggedUser->getPassword()==md5($_POST["ChangeUserFormOldPassword"])){
                                
                                //Zmiana informacji w użytkuwniku w istniejącej sesji
                                $loggedUser->setPassword(md5($_POST["ChangeUserFormNewPassword"]));
                                $_SESSION["loggedUser"] = serialize($loggedUser);

                                if($_POST["ChangeUserFormNewPassword"]==$_POST["ChangeUserFormConfirmNewPassword"]){

                            
                                //Aktualizowanie użytkownika w bazie
                                $sql = "UPDATE `users` SET `Password`='".md5($_POST["ChangeUserFormNewPassword"])."' WHERE `Id`=".$loggedUser->getId();
                                echo $sql;
                                $connect->query($sql);

                                header( "Location: loggedChangePassword.php" ); 
                                }else{
                                    echo "podane hasła nie są identyczne"; 
                                }


                                
                            }else{

                                echo "podane hasło jest błędne";
                            }
                            
                        }

                    ?>

                </div>
                
            </div>    
                
        </div>
              






            
        



    
    
</body>
</html>