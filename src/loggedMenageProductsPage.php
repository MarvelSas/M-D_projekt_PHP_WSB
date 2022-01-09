<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/loggedMenageProductsPage.css" />
    <title>M&D</title>
    <script type="text/javascript" src="../JavaScript/loggedMenageProductsPage.js"></script>
</head>
<body>

        <?php
            session_start();
            include '../php/User.php';
            include '../php/Product.php';
            include '../php/databaseConnection.php';


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
                    
                    <div class="customItemDashboard">
                            

                        <div class="innerCustomerItemDashbord">

                            <div class="companyLogoContainer">
                               <h1>M&D</h1>
                            </div>
                            <!-- Formularz do dodawania -->
                            <form action="loggedMenageProductsPage.php" method="POST" enctype="multipart/form-data" class="addItemForm" id="addItemForm">
                                <div class="itemNameContainer">
                                    <input type="text" class="itemNameInput" name="itemNameInput" id="itemNameInput" placeholder="Nazwa produktu" required> 
                                </div>
                                
                                <div class="itemPriceContainer">
                                    <input type="number" class="itemPriceInput" name="itemPriceInput" id="itemPriceInput" placeholder="Cena produktu" required step="0.01" > 
                                </div>
                                
                                <div class="itemPhotoContainer">
                                    <input type="file" class="itemPhotoInput" accept=" image/jpeg, image/png" name="itemPhotoInput" id="itemPhotoInput" required>
                                </div>
                                
                                <div class="addItemSubmitContainer">
                                    <input type="submit" class="addItemSubmit" value="Dodaj" id="itemSubmit" name="itemSubmit">
                                </div>
                                
                                

                            </form>

                            <!-- Formularz do aktualizowania -->
                            <form action="loggedMenageProductsPage.php" method="POST" enctype="multipart/form-data" class="modyfiItemForm" id="modyfiItemForm">
                                <div class="itemNameContainer">
                                    <input type="text" class="disabledInput itemNameInput" name="itemNameInputModify" id="itemNameInputModify" placeholder="Nazwa produktu" required readonly> 
                                </div>
                                
                                <div class="itemPriceContainer">
                                    <input type="number" class="itemPriceInput" name="itemPriceInputModify" id="itemPriceInputModify" placeholder="Cena produktu" required step="0.01" > 
                                </div>
                                
                                
                                
                                <div class="changePriceItemSubmitContainer">
                                    <input type="submit" class="changePriceItemSubmit" value="Zmień cene" id="itemSubmitModify" name="itemSubmitModify">
                                </div>
                                <div class="CancelContainer">
                                    <button class="CancelButton">Anuluj</button>     
                                </div>
                                
                            </form>
                        </div>
                        

                        
                        <?php

                            //Dodawanie nowego itemu
                            if(isset($_POST['itemSubmit'])){
                                //Weryfikacja czy plik został przesłany
                                if(!empty($_FILES['itemPhotoInput']['name'])){

                                    
                                    $nazwaPlikuZRozszerzeniem =   $_FILES['itemPhotoInput']['name'];

                                    $rozszeniePliku = pathinfo($_FILES['itemPhotoInput']['name'],PATHINFO_EXTENSION);


                                    //Zastępowanie .jpg pustym miejscem w nazwie pliku 
                                    $nazwaPliku = str_replace(".jpg","",$nazwaPlikuZRozszerzeniem);
                                    

                                    if ($rozszeniePliku == "jpg" || $rozszeniePliku == "png")
                                    { 
                                        
                                    
                                        //echo("Plik jpg przsłany poprawie<br>");
                                        //Sprawdzenie czy już nie istnie obrazek o takiej samej nazwie
                                        $sql = "SELECT * FROM products WHERE Name='".$_POST['itemNameInput']."'";
                                        $productRow = $connect->query($sql)->fetch_assoc();

                                        if(!empty($productRow["Name"])){

                                            echo "<div class='errorMessageContainer'>Produkt o takiej nazwie istnieje już w bazie</div>"; 
                                            
                                            
                                        }else{
                                            //Tworznie lokalnej kopi zdjęcia na serverze
                                            move_uploaded_file($_FILES['itemPhotoInput']['tmp_name'], "../resources/productImages/".$_POST['itemNameInput'].".".$rozszeniePliku);
                                        
                                            //Dodawanie Produktu do bazy danych 
                                            $product = new Product($_POST['itemNameInput'],$_POST['itemPriceInput'],$_POST['itemNameInput'].".".$rozszeniePliku);
                                            $product->addToDatabase($connect);

                                        }

                                    }else{
                                        echo"<div class='errorMessageContainer'> Plik jest przesłany błędnie</div>";
                                    }
                                }
                            }


                            //Aktualizowanie itemu
                            if(isset($_POST['itemSubmitModify'])){
                                
                                $connect->query("UPDATE products SET PRICE=".$_POST['itemPriceInputModify']." WHERE  Name='".$_POST['itemNameInputModify']."'");
                                
                            }

                        ?>
                        

                    </div>

                    <div class="itemsList">
                        
                        <?php

                            //Usuwanie itemu
                            if(isset($_POST['removeItemSubmit'])){
                                $connect->query("DELETE FROM products WHERE id=".$_POST['removeItemId']);
                                unlink('../resources/productImages/'.$_POST['removeItemPhotoName']);
                            }


                            $sql = "SELECT * FROM products ";
                            $allProductsRow = $connect->query($sql);
                            

                            $liczbProduktow =  ceil($connect->query("SELECT COUNT(*) FROM products ")->fetch_array()[0]);
                            $liczbliniProduktow =  ceil($connect->query("SELECT COUNT(*) FROM products ")->fetch_array()[0]/2);
                            //echo $liczbProduktow;

                            $licznikProduktow = 1;



                            while($result = $allProductsRow->fetch_assoc()){


                            
                                

                                echo '<div class="item">
                                    <div class="itemLeftSide">
                                    <div class="pricesItemConatiner">'.number_format($result['Price'], 2, ',', ' ').' zł</div>
                                    <div class="nameItemConatiner">'.$result['Name'].'</div>
                                    <div class="buttonRemoveItemConatiner">
                                        <form action="loggedMenageProductsPage.php" method="POST">
                                            <input type="hidden" value="'.$result['Id'].'" name="removeItemId">
                                            <input type="hidden" value="'.$result['PhotoName'].'" name="removeItemPhotoName">
                                            <input type="submit" class="itemSubmit" value="Usuń" name="removeItemSubmit">
                                        </form>
                                    </div>
                                    
                                    <div class="buttonModifyItemConatiner">
                                        <button class="changePricesButton" onclick="modifyItem(`'.$result['Name']. '`,' .$result['Price']. ',`' .$result['PhotoName'].'` )">Zmień cene</button>
                                    </div>
                                    </div>
                                    <div class="itemRightSide">
                                        <img src="../resources/productImages/'.$result['PhotoName'].'" class="itemIMG">
                                    </div>
                                </div>';
                                
                                
                            }

                            
                            
                            
                        ?>

                        
                    </div>
            </div>
                
           

        </div>
                






            
        



    
    
</body>
</html>