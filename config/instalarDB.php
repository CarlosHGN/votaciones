<?php
echo "XXXXXXXXXXXXXXXXXXXXXXXXX";
try {
  $link = new PDO("mysql:host=".HOST, USER, PASSWORD);
  $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $sql = file_get_contents('bin/db_votaciones_ini.sql');
  $link->exec($sql);

  echo '<span class="text text-success">Creada Satisfactoriamente la Base de Datos</span>';
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$link = null;