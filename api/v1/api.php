<?php


session_start();
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/choloapp/api/v1/helpers.php');
class DB
{
    var $DBUser = 'root';
    var $DBPass = 'root';
    var $DBServer = 'localhost';
    var $DBName = 'choloapp';
    
    public function connect()
    {
        try {
            $strDSN   = "mysql:host=$this->DBServer;dbname=$this->DBName;";
            $username = $this->DBUser;
            $pass     = $this->DBPass;
            $conn     = new PDO($strDSN, $username, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
            echo 'connected';
        }
        catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } //end method
} //end class

function login()
{
    
    $db   = new DB;
    $conn = $db->connect();
    $stmt = $conn->prepare('SELECT * FROM customers_auth WHERE uid = :id');
    $id   = 169; //$_GET['uid'];
    $stmt->execute(array(
        'id' => $id
    ));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //return encrypt('sDnMpXZ85ks/7itt7z2wHJgNN7x/w1ZDx7m1nBSpQuw=');
    if ($result != null) {
        $_SESSION["user"] = $result[0];
    }
    return $result;
}


function DoLogin($id)
{
    return login();
}

function session()
{
    if ($_SESSION["user"] != null) {
        return $_SESSION["user"];
    }
    
    else {
        return "";
    }
    
}

function Logout()
{
    // destroy the session 
    session_destroy();
    return "Cierre De Sesion Existoso" ;
    
}


$possible_url = array(
    "session",
    "login",
    "logout"
);

$value = "An error has occurred";

if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
    switch ($_GET["action"]) {
        case "session":
            $value = session();
            break;
        case "logout":
            $value = Logout();
            break;
        case "login":
            if (isset($_GET["id"]))
                $value = DoLogin($_GET["id"]);
            else
                $value = "Missing argument";
            break;
    }
}

//return JSON array
exit(json_encode($value));
?>