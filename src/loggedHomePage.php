<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/loggedHomePage.css" />
    <title>M&D</title>
    <script type="text/javascript" src="../JavaScript/loggedHomePage.js"></script>
</head>
<body>

        <?php
            session_start();
            include '../php/User.php';


            //Sprawdzanie czy użytkownik jest zalogowany
            if(empty($_SESSION["loggedUser"])){
                header( "Location: index.php" );
            }    

            //Deserialicja użytnownika
            $loggedUser = unserialize($_SESSION["loggedUser"]);
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
                <div class="homeImageineContainer">
                    <img src="../resources/19881.png" class="homeImagine" >
                </div>

                <div class="contextText">
                    <div class="homeTextContainerSpace"> 
                    </div>
                    <div class="homeTextContainer">
                        <div class="shortTextConatiner">
                            <span>Szybka    
                                </br>dostawa & 
                                </br>Smaczne Jedzenie 
                            </span>
                        </div>
                        <div class="descirptionContainer">
                            <span>Nasze burgry są robione ze świerzych i lokalnych prdutków.     
                            Do każdego zamówienia podchodzimy indiwidualnie, 
                            checemy mieć pewność że trafiamy do ciebie 
                            </span>
                        </div>
                        <div class="buttonContainer">
                            <button class="orderButton" onclick="openMenuPage()">Zamów teraz</button>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
                






            
        



    
    
</body>
</html>