<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/loggedOrderForm.css" />
    <title>M&D</title>
    <script type="text/javascript" src="../JavaScript/loggedOrderFrom.js"></script>
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

            //Sprawdzanie czy użytkownik ma jakieś produkty w koszyku
            if(count($loggueUserCart->getCartLines())==0){
                header( "Location: loggedMenuPage.php" );
            }


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
                


                <div class="formContainer"> 
                    
                    <form action="loggedOrderFinalization.php" method="POST" class="userForm">
                        <div class="innerFormContainer">

                            <div class="titleFormContainer">
                                <h1>Dane odbiorcy</h1>  
                            </div>
                            <div class="userNameFormContainer">
                                <input type="text" class="userNameFormInput" name="orderUserName" id="orderUserName"   placeholder="Imie" pattern="[^()/><\][\\\x22,;|]+" required>  
                            </div>
                            <div class="userSurnameFormContainer">
                                <input type="text" class="userSurnameFormInput" name="orderUserSurname" id="orderUserSurname" placeholder="Nazwisko" pattern="[^()/><\][\\\x22,;|]+" required> 
                            </div>
                            <div class="userStreetFormConatiner">
                                <input type="text" class="userStreetFormInput" name="orderStreet" id="orderStreet" placeholder="Ulica" pattern="[^()/><\][\\\x22,;|]+" required> 
                            </div>
                            <div class="userHourseNumberFormConatiner">
                                <input type="text" class="userHouseNumberFormInput" name="orderHouseNumber" id="orderHouseNumber" placeholder="Numer domu/mieszkania" pattern="[^()/><\][\\\x22,;|]+" required> 
                            </div>
                            <div class="userCityFormContainer">
                                <input type="text" class="userCityFormInput" name="orderCity" id="orderCity" placeholder="Miasto" pattern="[^()/><\][\\\x22,;|]+" required>   
                            </div>
                            <div class="userStateFormContainer">
                                <input type="text" class="userStateFormInput" name="orderState" id="orderState" placeholder="Województw" pattern="[^()/><\][\\\x22,;|]+" required>    
                            </div>
                            <div class="userZipCodeFormContainer">
                                <input type="text" class="userZipCodeFormInput" name="orderZipCode" id="orderZipCode"  placeholder="Kod pocztowy"  pattern="[0-9]{2}-[0-9]{3}" title="Wprowadz Kod pocztowy zgodnie z formatem xx-xxx" required>
                            </div>
                            <div class="submitFormConatiner">
                                <input type="submit" class="submitFormInput" value="Finalizuj zamówienie">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="orderProductListContainer">


                    <div class="listCartTitleContainer">
                        <div class="cartListLabelContainer">
                            <div>
                                <h1>Twoje Zamówienie (</h1>
                            </div>
                            <div>
                                <h1><?php echo count($loggueUserCart->getCartLines()) ?>)</h1> 
                            </div>
                        </div>
                        <div class="clearCartButtonContainer">
                            
                        </div>
                    </div>

                        <?php

                        foreach($loggueUserCart->getCartLines() as $line){
                                                            

                            //Wyświetlanie lini koszyka
                            echo 
                            '<div class="cartLineContainer">
                                <div class="cartLineImageContainer">
                                    <img src="../resources/productImages/'.$line->getProduct()->getPhotoName().'" class="cartLineImage">  
                                </div>
                                <div class="cartLineNameContainer">
                                '.$line->getProduct()->getName().'
                                </div>
                                <div class="cartLinePriceContainer">
                                '.number_format($line->getProduct()->getPrice(), 2, ',', ' ').' zł
                                </div>
                                <div class="cartLineQuantityContainer">
                                '.$line->getQuantity().' szt.
                                </div>
                                
                                
                            
                            
                            
                            
                            
                            
                            </div>';
                        }
                    ?>
                </div>  
                
                
                
            </div>    
            <footer class="footerContainer">
                <div class="leftFooterContainer">
                    <div>
                        Kontakt:           
                    </div>  
                    <div>
                        tel. 777-222-555
                    </div>
                </div>
                <div class="rightFooterContainer">
                    <div>
                        pon - pt 8:00 21:00           
                    </div>  
                    <div>
                        sob - niedz 8:00 15:00
                    </div>            
                </div>       
            </footer> 
        </div>
              






            
        



    
    
</body>
</html>