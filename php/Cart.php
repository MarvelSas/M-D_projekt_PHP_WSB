<?php

include '../php/CartLine.php';
include '../php/Product.php';

class Cart{

    private $cartLines;
    private $summaryAmout ;
    private $userId;


    public function __construct($userId){
        
        
        $this->cartLines= array();
        $this->summaryAmout= 0;
        $this->userId = $userId;
        
        
    }

    //GET

    public function getCartLines(){

        return $this->cartLines;
    }

    public function getSummaryAmout(){
        return $this->summaryAmout;
    }


    //METHOD
    
    public function addLine($product,$quantity){

        $ifProductExistInCart = false;
        
        //Sumowanie wartości koszyka
        $this->summaryAmout = $this->summaryAmout + $product->getPrice(); 

        //Sprawdzanie czy w koszyku występuje dodawany produkt
        foreach($this->cartLines as $line){
            
            //Jeśli w koszyku występuje produkt o takiej samej nazwie powinna być zwiększona ilość produktu w koszyku
            if($line->getProduct()->getName()==$product->getName()){
                
                $ifProductExistInCart= true;
                $line->increaseQuantity($quantity);
                break;
            }

        }

        //Jeśli dany produkt nie istnieje w koszyku to jest tworzona dla niego nowa linia
        if(!$ifProductExistInCart){
            array_push($this->cartLines,new CartLine($product,$quantity));
        }
        
    }

    public function deleteLine($productName){
        
        
        $deleteItemKey = 0;
        $i=0;
        foreach($this->cartLines as $line){
            
            //Jeśli w koszyku występuje produkt o takiej samej nazwie powinna być zwiększona ilość produktu w koszyku
            if($line->getProduct()->getName()==$productName){
                $deleteItemKey=$i;
                $this->summaryAmout=$this->summaryAmout-($line->getProduct()->getPrice()*$line->getQuantity());
                
            }
            $i++;
        }

        
        array_splice($this->cartLines, $deleteItemKey, 1); 

    }


    public function clear(){
        $this->cartLines= array();
        $this->summaryAmout= 0;
    }

}


    // $cart = new Cart(1);

    // $cart->addLine(new Product("burger",12.12,"zdj") ,2);
    // $cart->addLine(new Product("burger",12.12,"zdj") ,2);
    // $cart->addLine(new Product("burger1",12.12,"zdj") ,2);
    // $cart->addLine(new Product("burger",12.12,"zdj") ,2);
    // $cart->addLine(new Product("burger1",12.12,"zdj") ,0);

    // foreach($cart->getCartLines() as $line){
            
    //     echo($line->getProduct()->getName()." : ".$line->getQuantity().'<br>');
    // }

?>