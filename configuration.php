<?php


const ROOT_PATH = __DIR__ . "../";

const DB_HOST = "db5000849816.hosting-data.io";
const DB_USER = "dbu976781";
const DB_PASSWORD = "Basebeebee270*";
const DB_NAME = "beebee";


require_once("controllers/Controller.php");
require_once 'libraries/Request.php';
require_once 'libraries/Http.php';
require_once 'libraries/Session.php';
require_once 'Models/Model.php';
require("templates/partials/header.phtml");
require("index.php");
require("templates/partials/footer.phtml");

?>