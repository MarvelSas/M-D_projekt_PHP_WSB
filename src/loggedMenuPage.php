<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/loggedMenuPage.css" />
    <title>M&D</title>
    <script type="text/javascript" src="../JavaScript/loggedMenuPage.js"></script>
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

            <div class="contextHeder">
                    <h1>Menu</h1>
            </div>

            <div class="contextContainer">



                        <?php
                            $sql = "SELECT * FROM products ";
                            $allProductsRow = $connect->query($sql);

                            $licznikProduktow = 1;
                            $liczbProduktow =  ceil($connect->query("SELECT COUNT(*) FROM products ")->fetch_array()[0]);
                            
                            while($result = $allProductsRow->fetch_assoc()){
                                

                                 echo' 
                                         <div class="item">
                                         
                                            <div class="itemLeftSide">
                                                <div class="pricesItemConatiner">'.number_format($result['Price'], 2, ',', ' ').' zł</div>
                                                <div class="nameItemConatiner">'.$result['Name'].'</div>
                                                <div class="buttonRemoveItemConatiner">
                                                    <form  method="POST" action="loggedCartList.php">
                                                        <input type="hidden" value="'.$result['Id'].'" name="ItemId">
                                                        <input type="hidden" value="'.$result['Name'].'" name="ItemName">
                                                        <input type="hidden" value="'.$result['Price'].'" name="ItemPrice">
                                                        <input type="hidden" value="'.$result['PhotoName'].'" name="ItemPhotoName">
                                                        <input type="submit" class="itemSubmit" value="Do koszyka" name="ItemSubmit">
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="itemRightSide">
                                                <img src="../resources/productImages/'.$result['PhotoName'].'" class="itemIMG">
                                            </div>
                                         </div>
                                    ';
                                 



                                
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