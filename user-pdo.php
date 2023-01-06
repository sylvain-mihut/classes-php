<?php
session_start();

// Création d'une classe 
class User
{

    
    // Atributs
    private $id;
    public $login;
    private $password;
    public $email;
    public $firstname;
    public $lastname;
    private $db;
    public $user;

    public function __construct()
    
    {
        $this->db = new PDO("mysql:host=localhost;dbname=classes", "root", "");
      
        if (!$this->db) {
            echo " connexion non etablie";
            die;
        }else {
            echo "vous etes connecté";

        }
        if (isset($_SESSION['user'])){
            $this->id = $_SESSION['user']['id'];
            $this->login = $_SESSION['user']['login'];
            $this->password = $_SESSION['user']['password'];
            $this->email = $_SESSION['user']['email'];
            $this->firstname = $_SESSION['user']['firstname'];
            $this->lastname = $_SESSION['user']['lastname'];
        } 
    }

    
    public function register($login, $password, $email, $firstname, $lastname) {
        
        $this->login=$login;
        $this->password=$password;
        $this->email=$email;
        $this->firstname=$firstname;
        $this->lastname=$lastname;

        $register = $this->db->prepare ( "INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES ('$this->login', '$this->password', '$this->email', '$this->firstname', '$this->lastname')");
        if ($register->execute()){
            echo "inscription ok";
        } else {
            echo "inscription échoué";
        }
        
    }
    public function connect($login, $password) {
        $this->login = $login;
        $this->password = $password;

        $connect = $this->db->prepare ("SELECT * FROM `utilisateurs` WHERE login = '$login' ");
        $connect->execute();
        $user = $connect->fetch(PDO::FETCH_ASSOC);
   
        var_dump($connect);

        $_SESSION['user'] = [
            'id'=> $user['id'],
            'login'=> $user['login'],
            'password'=> $user['password'],
            'email'=> $user['email'],
            'firstname'=> $user['firstname'],
            'lastname'=> $user['lastname'],
        ];
        var_dump($_SESSION['user']);

    }

    public function disconnect() {
        session_unset();
        session_destroy();
    }

    public function delete() {
        
        $login = $_SESSION['user']['login'];

        $delete = $this->db->prepare("DELETE FROM `utilisateurs` WHERE `login`= '$login' ");
        $delete->execute();
        $this->disconnect();
    }

    public function update($login, $password, $email, $firstname, $lastname) {
        $_SESSION['user']['login'] =  $login;
        $_SESSION['user']['password'] = $password;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['firstname'] = $firstname;
        $_SESSION['user']['lastname'] = $lastname;

        $update = $this->db->prepare ( "UPDATE `utilisateurs` SET `login`='$login',`password`='$password',`email`='$email',`firstname`='$firstname',`lastname`='$lastname' WHERE id = '$this->id'");
        $update->execute();
    }

    public function isConnected() {
        if ($this->id != null && $this->login != null && $this->password != null && $this->email != null && $this->firstname != null && $this->lastname){
            return true;
        } else {
            return false;
        }
    }

    public function getAllInfo() {
        ?> <p>Voici toutes vos informations d'utilisateur</p>
        <table border="1px">
                <thead>
                    <td>id</td>
                    <td>login</td>
                    <td>password</td>
                    <td>email</td>
                    <td>firstname</td>
                    <td>lastname</td>
                </thead>
                <tbody>
                    <td><?php echo $_SESSION['user']['id'] ?> </td>
                    <td><?php echo $_SESSION['user']['login'] ?></td>
                    <td><?php echo $_SESSION['user']['password'] ?></td>
                    <td><?php echo $_SESSION['user']['email'] ?></td>
                    <td><?php echo $_SESSION['user']['firstname'] ?></td>
                    <td><?php echo $_SESSION['user']['lastname'] ?></td>
                </tbody>
        </table>    
        <?php
    }

    public function getLogin() {
        ?> <p>Voici votre login :</p>
        <table border="1px">
                <thead>
                    <td>login</td>
                </thead>
                <tbody>
                    <td><?php echo $_SESSION['user']['login'] ?></td>
                </tbody>
        </table>
        <?php
    }

    public function getEmail() {
        ?> <p>Voici votre email :</p>
        <table border="1px">
                <thead>
                    <td>email</td>
                </thead>
                <tbody>
                    <td><?php echo $_SESSION['user']['email'] ?></td>
                </tbody>
        </table>
        <?php
    }

    public function getFirstname() {
        ?> <p>Voici votre prénom :</p>
        <table border="1px">
                <thead>
                    <td>firstname</td>
                </thead>
                <tbody>
                    <td><?php echo $_SESSION['user']['firstname'] ?></td>
                </tbody>
        </table>
        <?php
    }

    public function getLastname() {
        ?> <p>Voici votre nom :</p>
        <table border="1px">
                <thead>
                    <td>lastname</td>
                </thead>
                <tbody>
                    <td><?php echo $_SESSION['user']['lastname'] ?></td>
                </tbody>
        </table>
        <?php
    }


} 
$newUser = new User();
// $newUser->delete();


// $newUser->connect('a', 'a')
// $newUser->register('a', 'a', 'a@a.fr', 'a', 'a')
// $newUser->getAllInfo ();
// $newUser->getLogin ();
// $newUser->getEmail ();
// $newUser->getFirstname ();
// $newUser->getLastname ();

?>
