<?php

class User{
    private int $id;
    private string $login; //должен быть уникальным
    private string $password;
    private string $email;
    private PDO $db;

    public function __construct(string $login, string $password, string $email){
        $this->id = -1;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;

        $MYSQL_log = '127.0.0.1';
        $MYSQL_user = 'admin';
        $MYSQL_bd = 'Users';
        $MYSQL_pass = 'admin';

        try {
            $db = new PDO("mysql:host=$MYSQL_log;dbname=$MYSQL_bd", $MYSQL_user, $MYSQL_pass);
            echo "successful";
        }
        catch (PDOException $e)
        {
            printf("ERROR: %s", $e->getMessage());
            die();
        }

        $this->db = $db;

        $query = "SELECT ID FROM USER WHERE LOGIN = " . "'$this->login'";
        $user = $this->db->query($query)->fetch(PDO::FETCH_ASSOC);
        if($user != null)
            $this->id = $user['ID'];
    }

    public function save(){
        if($this->id == -1){
            $query = "INSERT INTO USER (LOGIN, PASSWORD, EMAIL) VALUES (" . "'$this->login', " . "'$this->password', " . "'$this->email'" . ");";
            $this->db->exec($query);
            $this->id = $this->db->lastInsertId();
        }
        else {
            $query = "UPDATE USER SET EMAIL = " . "'$this->email'" . "WHERE ID = " . "'$this->id'";
            $this->db->query($query);
        }
    }

    public function remove(){
        if($this->id != -1){
            $query = "DELETE FROM user WHERE id=$this->id";
            $this->db->query($query);
        }
    }

    public function getById(int $id){
        $query = "SELECT * FROM USER WHERE ID = " . "'$id'";
        $user = $this->db->query($query)->fetch(PDO::FETCH_ASSOC);
        echo "<br>";
        echo "id: " . $user['id'] . "<br>";
        echo " login: " . $user['login'] . "<br>";
        echo " password: " . $user['password'] . "<br>";
        echo " email: " . $user['email'] . "<br>";
    }

    public function all(){
        $query = "SELECT * FROM USER";
        $users = $this->db->query($query)->fetchAll();
        echo "<br>";
        for($i = 0; $i <= count($users) - 1; $i++) {
            $user = $users[$i];
            echo "id: " . $user['id'] . "<br>";
            echo " login: " . $user['login'] . "<br>";
            echo " password: " . $user['password'] . "<br>";
            echo " email: " . $user['email'] . "<br>";
        }
    }

    public function getByLogin(string $login){
        $query = "SELECT * FROM USER WHERE LOGIN = " . "'$login'";
        $user = $this->db->query($query)->fetch(PDO::FETCH_ASSOC);
        echo "<br>";
        echo "id: " . $user['id'] . "<br>";
        echo " login: " . $user['login'] . "<br>";
        echo " password: " . $user['password'] . "<br>";
        echo " email: " . $user['email'] . "<br>";
    }

    public function setEmail(string $email){
        $this->email = $email;
    }
}

$usr1 = new User("nik", "123", "nik@mail.ru");
$usr1->setEmail("nik123@yandex.ru");
$usr1->save();
$usr1->all();
$usr1->getById(2);
$usr1->getByLogin("admin");
$usr1->remove();
$usr1->all();
