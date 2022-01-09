<?php

class CartLine{

    private $product;
    private $quantity;



    public function __construct($product,$quantity){
        
        
        $this->product= $product;
        $this->quantity= $quantity ;
        
        
        
    }

    //GET

    public function getProduct(){

        return $this->product;
    }

    public function getQuantity(){

        return $this->quantity;
    }

    //METHOD

    public function increaseQuantity($quantity){
        $this->quantity=$this->quantity+$quantity;
    }

}


?>