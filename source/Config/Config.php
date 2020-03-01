<?php
//DB
define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "seu-banco",
    "username" => "seu-usuario",
    "passwd" => "sua-senha",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);
define("DB_STUDENTS", "students");
define("DB_CARNETS", "carnets");
define("DB_TICKETS", "tickets");

define("CONF_URL", "sua url");
define("CONF_URL_GN_NOTIFICATION", CONF_URL . "/gn-notification.php");

define("CONF_GN_CLIENT_ID","seu cliente_id");
define("CONF_GN_CLIENT_SECRET","seu client_secret");
define("CONF_GN_SANDBOX",true);
define("CONF_GN_OPTIONS",[
    'client_id' => CONF_GN_CLIENT_ID,
    'client_secret' => CONF_GN_CLIENT_SECRET,
    'sandbox' => true // altere conforme o ambiente (true = desenvolvimento e false = producao)
]);


/* Informa o nível dos erros que serão exibidos */
error_reporting(E_ALL);
/* Habilita a exibição de erros */
ini_set("display_errors", 1);