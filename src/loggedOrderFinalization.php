<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/loggedOrderFinalization.css" />
    <title>M&D</title>
    <script type="text/javascript" src="../JavaScript/loggedOrderFinalization.js"></script>
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
                
                
                <?php
                        if(isset($_POST["orderUserName"])){
                            //Dodawanie Zamówienia
                            $now = date("Y-m-d H:i:s");
                            
                            $sql = "INSERT INTO burger_order VALUES(NULL,'".$_POST["orderUserName"]."','".$_POST["orderUserSurname"]."','".$_POST["orderStreet"]."','".$_POST["orderHouseNumber"]."','".$_POST["orderCity"]."','".$_POST["orderState"]."','".$_POST["orderZipCode"]."',".$loggedUser->getId().",'".$now."',".$loggueUserCart->getSummaryAmout().",0)";
                            
                            $connect->query($sql);


                            //Pobieranie orderId
                            $sql2 = "SELECT Id FROM burger_order WHERE UserId='".$loggedUser->getId()."' and Date='".$now."'";
                            $orderId = $connect->query($sql2)->fetch_array()[0];
                            
                            //Dodawanie lini zamówienia
                            
                            
                            $sql3 = "INSERT INTO burger_order_line (`Id`, `Quantity`, `OrderId`, `ProductId`, `ProductName`, `ProductPrice`) VALUES";

                            foreach($loggueUserCart->getCartLines() as $line){
                
                                echo($line->getProduct()->getId()." : ".$line->getProduct()->getName()." : ".$line->getQuantity().'<br>');
                                $sql3 = $sql3."(NULL,".$line->getQuantity().",".$orderId.",".$line->getProduct()->getId().",'".$line->getProduct()->getName()."',".$line->getProduct()->getPrice()."),";
                            }
                            $sql3 = substr($sql3, 0, -1).";";
                            
                            $connect->query($sql3);
                            $loggueUserCart->clear();
                            $_SESSION["loggueUserCart"] = serialize($loggueUserCart);
                            header("Location: loggedOrderFinalization.php?orderId=".$orderId);
                        }else{

                            if(empty($_GET['orderId'])){
                                header("Location: loggedHomePage.php");  
                            }
                        }      
                ?>


                <?php
                    if(!empty($_GET['orderId'])){
                        //Pobieranie danych do zamówienia
                        $sql2 = "SELECT * FROM burger_order WHERE Id='".$_GET['orderId']."'";
                        $orderInformation = $connect->query($sql2)->fetch_assoc();
                        $sql3 = "SELECT * FROM burger_order_line WHERE OrderId='".$_GET['orderId']."'";
                        $orderProdustsList = $connect->query($sql3);

                        if(!($orderInformation['UserId']==$loggedUser->getId())){
                            header("Location: loggedHomePage.php"); 
                        }

                    }
                ?>

                

                <div class="contextHederContainer">
                    <span>Dziękujemy za zamówienie</span>
                </div>
                <div class="contextBodyContainer">
                    <div class="contextBodyButtonContainer">
                        <div class="orderProtuctListContainer">
                            <span>Zawartość zamówienia</span>
                        </div>

                        <?php

                            while($result = $orderProdustsList->fetch_assoc()){
                                                                

                                //Wyświetlanie Zamówienia
                                echo 
                                '<div class="cartLineContainer">
                                    <div class="cartLineNameContainer">
                                    '.$result['ProductName'].'
                                    </div>
                                    <div class="cartLineQuantityContainer">
                                    '.$result['Quantity'].' szt.
                                    </div>
                                    <div class="cartLinePriceContainer">
                                    '.number_format($result['ProductPrice'], 2, ',', ' ').' zł
                                    </div>
                                    
                                    
                                    
                                
                                
                                
                                
                                
                                
                                </div>';
                            }

                        ?>
                        <div class="orderSummaryContainer">
                            <div class="orderSummaryEmpty"></div>
                            <div class="orderSummaryValue"><?php echo "Razem :".number_format($orderInformation['SummaryPrice'], 2, ',', ' ')." zł" ?> </div>
                        </div>
                        
                    </div>
                    <div class="contextBodyTopContainer">
                        <div class="orderNumberContainer">
                            <?php echo 'Zamówienie nr '.$_GET['orderId'].'' ?>
                        </div>
                        <div class="orderDateContainer">
                            <?php echo '<span>złożone '.date("d-m-Y", strtotime($orderInformation['Date'])).'</span>' ?>
                        </div>
                        <div class="orderDataInformationContainer">
                            <span>Dane zamówienia</span>
                        </div>
                        
                        
                        <div class="orderDeliveryBodyContainer">
                            <div class="orderDeliveryUserDetailsContainer">
                                <div class="orderDeliverylinie">
                                    <span class="orderDeliveryUserDetailsTitel">Dane odbiorcy :</span>   
                                </div>
                                <div class="orderDeliverylinie">
                                    <?php echo $orderInformation['Name']." ".$orderInformation['Surname'] ?> 
                                </div>
                                <div class="orderDeliverylinie">
                                    <?php echo "e-mail: ".$loggedUser->getMail() ?> 
                                </div>
                                <div class="orderDeliverylinie">
                                    <?php echo "tel. ".$loggedUser->getPhoneNumber() ?> 
                                </div>

                            </div>
                            <div class="orderDeliveryInformationContainer">
                                <div class="orderDeliverylinie">
                                    <span class="orderDeliveryInformationTitel">Adres dostway :</span>   
                                </div>
                                <div class="orderDeliverylinie">
                                    <?php echo $orderInformation['Street']." ".$orderInformation['HouseNumber'] ?> 
                                </div>
                                <div class="orderDeliverylinie">
                                    <?php echo $orderInformation['Zip']." ".$orderInformation['City'] ?> 
                                </div>
                                <div class="orderDeliverylinie">
                                    <?php echo $orderInformation['State'] ?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                


                
                
            </div>    
                
        </div>
              






            
        



    
    
</body>
</html>