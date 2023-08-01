<?php
include('keys.php');
define('HOST', $hosting);
define('DATABASE', $database);
define('USER', $userr);
define('PASSWORD', $pss);
define('CAN_REGISTER', 'any');
define('DEFAULT_ROLE', 2);
define('IDLETIME', '3600'); // Max. session's inactivity time
define('SECURE', TRUE); // Important: When the system is in production, this option must be in TRUE
define('WEBSITEPATH', 'http://localhost/votaciones/'); //Website Address
define('WEBSITENAME', 'SISTEMA DE VOTACIOMES'); //Website Name
define('SESSIONNAME', 'CONTROL_VOTACIONES'); //Session Name
define('SYSTEMVERSION', 'versión V.1.0 || CRUD DESARROLLADO POR CARLOS GONZÁLEZ N.'); //Systems Version
define('PROCESSES', 'Votaciones Generales'); //Processes Added

try {
    $link = new PDO("mysql:host=".HOST, USER, PASSWORD);
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = file_get_contents('bin/db_votaciones_ini.sql');
    $link->exec($sql);
  
    echo '<div class="bg bg-success text text-white">Creada Satisfactoriamente la Base de Datos</div>';
  } catch(PDOException $e) {
    "<br>" . $e->getMessage();
  }
  
  $link = null;