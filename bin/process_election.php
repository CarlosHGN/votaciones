<?php
defined('WEBSITEPATH') OR exit('No se permite acceso directo a este archivo');

//Cleaning Form´s variables
$id = isset($_POST['id']) ? trim(filter_input(INPUT_POST, 'id', $filter = FILTER_SANITIZE_NUMBER_INT)) : "";
$dato = isset($_POST['dato']) ? trim(filter_input(INPUT_POST, 'dato', $filter = FILTER_SANITIZE_FULL_SPECIAL_CHARS)) : "";
$name_lastname = isset($_POST['name_lastname']) ? trim(filter_input(INPUT_POST, 'name_lastname', $filter = FILTER_SANITIZE_FULL_SPECIAL_CHARS)) : "";
$alias = isset($_POST['alias']) ? trim(filter_input(INPUT_POST, 'alias', $filter = FILTER_SANITIZE_FULL_SPECIAL_CHARS)) : "";
$rut = isset($_POST['rut']) ? trim(filter_input(INPUT_POST, 'rut', $filter = FILTER_SANITIZE_FULL_SPECIAL_CHARS)) : "";
$email = isset($_POST['email']) ? trim(filter_input(INPUT_POST, 'email', $filter = FILTER_VALIDATE_EMAIL)) : "";
$id_region = isset($_POST['id_region']) ? trim(filter_input(INPUT_POST, 'id_region', $filter = FILTER_SANITIZE_NUMBER_INT)) : "";
$id_comuna = isset($_POST['id_comuna']) ? trim(filter_input(INPUT_POST, 'id_comuna', $filter = FILTER_SANITIZE_NUMBER_INT)) : "";
$id_candidato = isset($_POST['id_candidato']) ? trim(filter_input(INPUT_POST, 'id_candidato', $filter = FILTER_SANITIZE_NUMBER_INT)) : "";

$accion = isset($_POST['accion']) ? trim(filter_input(INPUT_POST, 'accion', $filter = FILTER_SANITIZE_FULL_SPECIAL_CHARS)) : "";

if(!isset($accion)){
  echo '<option value="">ERROR DE DATOS</option>';
  die();
}

$controleleccion = new controllerElections();
switch($accion){
  case "regiones":
    $dataregion = $controleleccion->listRegions();
    if($dataregion == true){
      echo '<option value="" selected>Seleccione una opción</option>';
      foreach($dataregion as $data){
        echo '<option value="' . $data['id_region'].'">'.$data['region'].'</option>';
      }
    }
    $dataregion = array();
  break;

  case "comunas":
    if($id_region == ""){
      echo '<option value=" selected">DATOS FALTANTES</option>';
      die();
    }

    $datarcomuna = $controleleccion->getComunas($id_region);
    if($datarcomuna == true){
      echo '<option value="" selected>Seleccione una opción</option>';      
      foreach($datarcomuna as $data){
        echo '<option value="' . $data['id_comuna'].'">'.$data['comuna'].'</option>';
      }
    }

    $datarcomuna = array();
  break;

  case "candidatos":
    $datacandidato = $controleleccion->listCandidatos();
    if($datacandidato == true){
      echo '<option value="" selected>Seleccione una opción</option>';      
      foreach($datacandidato as $data){
        echo '<option value="' . $data['id_candidato'].'">'.$data['nombre_candidato'].'</option>';
      }
    }
    $datacandidato = array();
  break;

  case "contactos":
    $datacontacto = $controleleccion->listContacts();
    if($datacontacto == true){
      foreach($datacontacto as $data){
        echo '<div class="custom-control custom-checkbox custom-control-inline">
                <input name="id_contacto[]" id="id_contacto" type="checkbox" value="'.$data['id_contacto'].'">&nbsp;&nbsp;'.$data['descr_contacto'].'
              </div>';
      }
    }
    $datacontacto = array();
  break;
  
  case "rut":
    if($dato == ""){
      echo '<span class="text text-danger">RUT faltante</span>';
      die();
    }

    $campo = "rut";
    $valor = $dato;
    $validarrut = $controleleccion->getVoteString($campo,$valor);
    if($validarrut == true){
      echo '<span class="text text-danger">El Ciudadano con el RUT indicado ya votó</span>';
      die();
    }else{
      echo '<span class="text text-success">El Ciudadano con el RUT indicado puede votar</span>';
      die();
    }
    $validarrut = array();
  break;

  case "alias":
    if($dato == ""){
      echo '<span class="text text-danger">Alias faltante</span>';
      die();
    }

    $campo = "alias";
    $valor = $dato;
    $validarrut = $controleleccion->getVoteString($campo,$valor);
    if($validarrut == true){
      echo '<span class="text text-danger">El alias indicado ya está en uso</span>';
      die();
    }else{
      echo '<span class="text text-success">El alias indicado está disponible</span>';
      die();
    }
    $validarrut = array();
  break;

  case "Votar":
    if($name_lastname == "" || $alias == "" || $rut == "" || $email == "" || $id_candidato == "" || $id_region == "" || $id_comuna == ""){
      echo '<span class="label label-danger">Datos faltantes</span>';
      die();
    }

    if (strlen($alias) <= 5 || !preg_match('/[a-zA-Z]/', $alias) || !preg_match('/\d/', $alias)) {
      echo '<span class="text text-danger">El alias debe tener al menos 5 caracteres y un número. Por favor corrija esto para poder procesar el voto.</span>';
      die();
    }

    $campo = "alias";
    $valor = $alias;
    $validarrut = $controleleccion->getVoteString($campo,$valor);
    if($validarrut == true){
      echo '<span class="text text-danger">El alias indicado ya está en uso</span>';
      die();
    }

    include('bin/validateRUT.php');
    if (!validateRUT($rut)) {
      echo '<span class="text text-danger">El RUT no cumple con el formato estándar. Por favor corrija esto para poder procesar el voto.</span>';
      die();
    }

    $campo = "rut";
    $valor = $rut;
    $validarrut = $controleleccion->getVoteString($campo,$valor);
    if($validarrut == true){
      echo '<span class="text text-danger">El Ciudadano con el RUT indicado ya votó</span>';
      die();
    }

    if(isset($_POST['id_contacto']) && is_array($_POST['id_contacto'])){
      if (count($_POST['id_contacto']) < 2){
        echo '<span class="text text-danger">Al menos se deben seleccionar 2 formas de "Cómo se enteró de Nosotroas". Por favor corrija esto para poder procesar el voto.</span>';
        die();
      }else{
        $id_contactos = $_POST['id_contacto'];
      }
    }else{
      echo '<span class="text text-danger">Al menos se deben seleccionar 2 formas de "Cómo se enteró de Nosotroas". Por favor corrija esto para poder procesar el voto.</span>';
      die();
    }

    try {
      $registrarvoto = $controleleccion->createVote($name_lastname,$alias,$rut,$email,$id_region,$id_comuna,$id_candidato);
      foreach($id_contactos as $id_contacto){
        $registrarcontacto = $controleleccion->createContact($rut,$id_contacto);
      }
    }catch (Exception $e){
      echo '<span class="text text-danger">Error al intentar ingresar los datos. Voto no procesado</span>';
      die();
    }
    echo '<span class="text text-success"><u>Voto Registrado Satisfactoriamente</u></span>';
  break;

  default:
    die('Error: Selección no válida');
}

