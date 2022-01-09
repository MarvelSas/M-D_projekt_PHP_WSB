<?php



class User{
    
    
    private $id;
    private $login ;
    private $password;
    private $mail;
    private $phoneNumber;
    private $role;


    public function __construct($login,$password,$mail,$phoneNumber,$role){
        
        
        $this->login= $login;
        $this->password= $password;
        $this->mail = $mail;
        $this->phoneNumber = $phoneNumber;
        $this->role = $role;
        
    }

    //GET

    public function getId(){

        return $this->id;
    }

    public function getLogin(){

        return $this->login;
    }
    
    public function getPassword(){

        return $this->password;
    }

    public function getMail(){

        return $this->mail;
    }

    public function getPhoneNumber(){

        return $this->phoneNumber;
    }

    public function getRole(){

        return $this->role;
    }

    

    

    //SET
    public function setId($id){

        $this->id= $id;
    }

    public function setLogin($login){

        $this->login= $login;
    }
    
    public function setPassword($password){

        $this->password= $password;
    }

    public function setMail($mail){

        $this->mail = $mail;
    }

    public function setPhoneNumber($phoneNumber){

        $this->phoneNumber = $phoneNumber;
    }

    public function setRole($role){

        $this->role = $role;
    }

    //METHOD
    
    public function addToDatabase($connect){
        $sql = "INSERT INTO users VALUES(NULL,'".$this->login."','".$this->password."','".$this->mail."','".$this->phoneNumber."',".$this->role.")";
        $connect->query($sql);
        
    }


}

abstract class usersRole{

    const Customer = 0;
    const Seller = 1;
}

/*
echo("Test");
$foo = new User("1","1","1","1",usersRole::Customer);
echo($foo->getLogin()."<br>");
echo($foo->getRole());
*/

?>
