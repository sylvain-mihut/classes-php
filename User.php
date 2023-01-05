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
    public function __construct()
    {
       $this->db = mysqli_connect('localhost', 'root', '', 'classes');
        if (!$this->db) {
            echo "Connexion non établie.";
            exit;
        }
        echo "vous etes connecté";
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

        $sql = mysqli_query($this->db, "INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')");
        echo "inscription ok";
    }
    public function connect($login, $password) {
        $this->login = $login;
        $this->password = $password;

        $sqli = mysqli_query($this->db, "SELECT * FROM `utilisateurs` WHERE login = '$login' ");
        $user = $sqli->fetch_assoc();
        
        var_dump($user);

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

        $delete = mysqli_query($this->db, "DELETE FROM `utilisateurs` WHERE `login`= '$login' ");
        echo "Suppression effectuée";
        $this->disconnect();
    }

    public function update($login, $password, $email, $firstname, $lastname) {
        $_SESSION['user']['login'] =  $login;
        $_SESSION['user']['password'] = $password;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['firstname'] = $firstname;
        $_SESSION['user']['lastname'] = $lastname;

        $update = mysqli_query($this->db, "UPDATE `utilisateurs` SET `login`='$login',`password`='$password',`email`='$email',`firstname`='$firstname',`lastname`='$lastname' WHERE id = '$this->id'");
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

$newUser->getAllInfo ();
$newUser->getLogin ();
$newUser->getEmail ();
$newUser->getFirstname ();
$newUser->getLastname ();

?>
