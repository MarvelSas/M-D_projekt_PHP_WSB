<?php

    class Product{

        private $id;
        private $name;
        private $price;
        private $photoName;

        public function __construct($name,$price,$photoName){
        
        
            $this->name= $name;
            $this->price= $price;
            $this->photoName = $photoName;
            
        }



        //GET
        public function getId(){

            return $this->id;
        }

        public function getName(){

            return $this->name;
        }


        public function getPrice(){

            return $this->price;
        }


        public function getPhotoName(){

            return $this->photoName;
        }

        //SET
        public function setId($id){

            $this->id= $id;
        }
        public function setName($name){

            $this->name= $name;
        }
        public function setPrice($price){

            $this->price= $price;
        }
        public function setPhotoName($photoName){

            $this->photoName = $photoName;
        }

        //METHOD

        public function addToDatabase($connect){
            $sql = "INSERT INTO products VALUES(NULL,'".$this->name."',".$this->price.",'".$this->photoName."')";
            $connect->query($sql);
            
        }








        

    }



?>

