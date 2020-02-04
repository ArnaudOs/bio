<?php


const ROOT_PATH = __DIR__ . "../";

const DB_HOST = "localhost";
const DB_USER = "root";
const DB_PASSWORD = "";
const DB_NAME = "beebee";


require_once("Controllers/Controller.php");
require_once 'libraries/Request.php';
require_once 'libraries/Http.php';
require_once 'libraries/Session.php';
require_once 'Models/Model.php';
require("templates/partials/header.phtml");
require("index.php");
require("templates/partials/footer.phtml");

?>