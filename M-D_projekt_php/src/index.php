<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css" />
    <title>M&D</title>
    <script type="text/javascript" src="../JavaScript/index.js"></script>
</head>
<body>
        <?php


            session_start();


            //Sprawdzanie czy użytkownik jest zalogowany 
            if(!empty($_SESSION["loggedUser"])){
                header( "Location: loggedHomePage.php" );
            } 
        ?>
        
    <div class="mainContainer">
        <nav class="navBar">
            <div class="logo">
                M&D
            </div>
            <div class=linkList>
                <a href="index.php" class="link">
                    Strong główna
                </a>
                <a href="MenuPage.php" class="link">
                    Menu
                </a>
                
                
            </div>
            <div class="space">

            </div>
            <button class="loginButton" onclick="openLoginPage()" >Zaloguj</button>
        </nav>

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
                        <button class="orderButton" onclick="openMenuPage()" >Zamów teraz</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>        



            
        



    
    
</body>
</html>