<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/MenuPage.css" />
    <title>M&D</title>
    <script type="text/javascript" src="../JavaScript/MenuPage.js"></script>
</head>
<body>

        <?php
            session_start();
            include '../php/User.php';
            include '../php/databaseConnection.php';
            include '../php/Cart.php';

            
               

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
                                                    <button class="itemSubmit" onclick="openLoginPage()">Do koszyka</button>
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