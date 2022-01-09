<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/loggedOrderList.css" />
    <title>M&D</title>
    <script type="text/javascript" src="../JavaScript/loggedOrderList.js"></script>
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



                   

                    //Dla użytkownika
                    if($loggedUser->getRole()==0){
                        $sql = "SELECT * FROM burger_order WHERE UserId='".$loggedUser->getId()."' ";
                        $allOrdersRow = $connect->query($sql);
                        $orderCount =  ceil($connect->query("SELECT count(*) FROM burger_order WHERE UserId='".$loggedUser->getId()."' ")->fetch_array()[0]);
                    }

                    //Dla sprzedawny
                    if($loggedUser->getRole()==1){
                        $sql = "SELECT * FROM burger_order ";
                        $allOrdersRow = $connect->query($sql);
                        $orderCount =  ceil($connect->query("SELECT count(*) FROM burger_order ")->fetch_array()[0]);
                    }

                    echo '<div class="orderRow">
                            <h1>Zamówienia ('.$orderCount.')</h1>
                        </div>';

                    if($orderCount==0){
                        echo '<div class="orderRow">
                                <div class="emptyOrderList">
                                    <h1>Brak zamówień</h1>
                                </div>
                            </div>'; 
                    }

                    while($result = $allOrdersRow->fetch_assoc()){


                            
                       //Wyświetlanie lini nagłówka
                        echo'   <div class="orderRow">

                                    <div class="orderRowHeder">
                                        <div class="orderNumberContainer">Nr Zamówienia: '.$result["Id"].'</div>
                                        <div class="orderDateContainer">Data: '.$result["Date"].'</div>';
                                       
                                        //Weryfikacja statusu
                                        if($result["Status"]==1){
                                            echo '<div class="orderStatusContainer">Status: Ukończone</div>';
                                        }else{
                                            echo '<div class="orderStatusContainer">Status: W realizacji</div>';
                                        }
                                    
                                       
                        
                        //Sprawdzanie czy jest zalogowany jako sprzedawca
                        if($loggedUser->getRole()==1){
                            
                            //Zmiana statusu zamówienia na Ukończone
                            if($result["Status"]==1){
                                echo '<div class="orderChangeStatusButtonContainer">
                                        <form action="loggedOrderList.php" method="POST">
                                            <input type="hidden" value="'.$result["Id"].'" name="changeStatusOrder" >   
                                            <input class="orderChangeStatusDisabledButton" type="submit" value="Zrealizuj" disabled>
                                        </form>
                                    </div>';
                            }else{
                                echo '<div class="orderChangeStatusButtonContainer">
                                        <form action="loggedOrderList.php" method="POST">
                                            <input type="hidden" value="'.$result["Id"].'" name="changeStatusOrder" >   
                                            <input class="orderChangeStatusButton" type="submit" value="Zrealizuj">
                                        </form>
                                    </div>';
                            }



                            echo        '<div class="orderDeleteButtonContainer">
                                        <form action="loggedOrderList.php" method="POST">
                                            <input type="hidden" value="'.$result["Id"].'" name="deleteOrder" >   
                                            <input class="orderDeleteButton" type="submit" value="Usuń" >
                                        </form>
                                    </div>
                                    ';
                        }           
                                   
                                   
                        //Proces usuwania zamówienia
                        if(isset($_POST["deleteOrder"])){
                            

                            $connect->query("DELETE FROM `burger_order` WHERE Id='".$_POST["deleteOrder"]."'");
                            $connect->query("DELETE FROM `burger_order_line` WHERE OrderId='".$_POST["deleteOrder"]."'");

                            //Resetowanie warości formularza
                            header("Location: loggedOrderList.php ");
                        }

                        //Proces zmiany statusu zamówienia
                        if(isset($_POST["changeStatusOrder"])){
                            

                            $connect->query("UPDATE `burger_order` SET `Status`='1' WHERE Id='".$_POST["changeStatusOrder"]."'");

                            //Resetowanie warości formularza
                            header("Location: loggedOrderList.php ");
                        }
                        

                                   
                                   
                        echo'   </div>
                                    <div class="orderRowBody">';
                         //Wyświetlanie lini zamówienia           
                         $sqlOrderLine="SELECT * FROM burger_order_line WHERE OrderId=".$result["Id"]." "; 
                         $allOrdersRowLine=$connect->query($sqlOrderLine);
                         while($resultLine = $allOrdersRowLine->fetch_assoc()){

                            echo'<div class="orderRowBodyLine">
                                    <div class="orderLineProductName">'.$resultLine["ProductName"].'</div>
                                    <div class="orderLineQuantity">'.$resultLine["Quantity"].' szt.</div>
                                    <div class="orderLineProductPrice">'.number_format($resultLine["ProductPrice"], 2, ',', ' ').' zł</div>
                            
                            
                            
                            </div>
                            
                            
                            ';
                        
                         }

                         //Wyswietlenie sumarycznej wartoścli lini zamówienia
                         echo '<div class="orderRowBodyLine">
                                <div class="orderLineProductName"></div>
                                <div class="orderLineQuantity"></div>
                                <div class="orderLineProductPriceSummary">
                                    <div>
                                        Razem:
                                    </div>
                                    <div>
                                        '.number_format($result["SummaryPrice"], 2, ',', ' ').' zł
                                    </div>
                                </div>
                            </div>';


                                    
                                   
                        echo'       </div>


                                </div>';
                       
                        
                        
                    }


                ?>

                



                
                
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