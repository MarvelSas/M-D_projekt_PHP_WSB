<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/loggedCartList.css" />
    <title>M&D</title>
    <script type="text/javascript" src="../JavaScript/loggedCartList.js"></script>
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
                    <div class="listCartContainer">


                        <div class="listCartTitleContainer">
                            <div class="cartListLabelContainer">
                                <div>
                                    <h1>Koszyk (</h1>
                                </div>
                                <div>
                                  <h1><?php echo count($loggueUserCart->getCartLines()) ?>)</h1> 
                                </div>
                            </div>
                            <div class="clearCartButtonContainer">
                                <form action="loggedCartList.php" method="POST">
                                    <input class="clearCartButton"  type="submit" value="Usuń Wszystko" name="deleteProdukts"  >
                                </form>
                            </div>
                        </div>
                        <div class="listCartBodyContainer">
                            <?php
                                //Dodanie do koszyka 
                                if(isset($_POST["ItemName"])){
                                    echo $_POST["ItemName"],"</br></br></br>";
                                    $newProdukt = new Product($_POST["ItemName"],$_POST["ItemPrice"],$_POST["ItemPhotoName"]);
                                    $newProdukt->setId($_POST["ItemId"]);
                                    $loggueUserCart->addLine($newProdukt, 1);
                                    $_SESSION["loggueUserCart"] = serialize($loggueUserCart);
                                    //Zabezpieczenie przed pownowym odbieraniem formularza po odświerzeniu strony
                                    header("Location: loggedCartList.php ");
                                }

                                
                                
                                
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
                                        <div class="cartLineButtonContainer">
                                            <form action="loggedCartList.php" method="POST">
                                                <input type="hidden" value="'.$line->getProduct()->getName().'" name="deleteProdukt" >   
                                                <input class="deleteProduktButton" type="image" src="../resources/icon/delete.png" >
                                            </form>
                                        </div>
                                        
                                    
                                    
                                     
                                    
                                    
                                    
                                    </div>';
                                }

                                if(count($loggueUserCart->getCartLines())==0){
                                    echo    '<div class="cartEmptyLineConatiner">
                                            <h2>Koszyk Pusty</h2>
                                            </div>';
                                }


                                //Usuwanie elementu z koszyka
                                if(isset($_POST["deleteProdukt"])){
                                    $loggueUserCart->deleteLine($_POST["deleteProdukt"]);
                                    $_SESSION["loggueUserCart"] = serialize($loggueUserCart);

                                    //Resetowanie warości formularza
                                    echo "<script> window.location.href='loggedCartList.php';</script>";
                                }


                                //Usuwanie wszystkich produktów z koszyka
                                if(isset($_POST["deleteProdukts"])){
                                    $loggueUserCart->clear();
                                    $_SESSION["loggueUserCart"] = serialize($loggueUserCart);

                                    //Resetowanie warości formularza
                                    echo "<script> window.location.href='loggedCartList.php';</script>";
                                }
                                
                                
                            ?>
                        
                        
                        </div>
                    </div>
                    <div class="buttonListContainer">
                        <div class="innerButtonListContainer">

                            <div class="summaryAmoutCountainer">
                                <div class="amoutTitleContainer">
                                    <?php 
                                        echo "Łączna kwota :";
                                    ?>
                                </div>
                                <div class="amoutValueContainer">
                                    <?php 
                                        echo number_format($loggueUserCart->getSummaryAmout(), 2, ',', ' ')." zł";
                                    ?>
                                </div>
                            </div>
                            
                                <?php
                                    if(count($loggueUserCart->getCartLines())==0){
                                        echo '<button onclick="openOrderPage()" class="openOrderPageButtonDisable" disabled>Zamów</button>';
                                    }else{
                                        echo '<button onclick="openOrderPage()" class="openOrderPageButton">Zamów</button>';
                                    }
                                ?>

                                
                            
                            
                                <button onclick="openMenuPage()" class="backToMenuButton">Kontynuuj zakupy</button>
                            

                            
                            

                        </div>
                        
                            
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