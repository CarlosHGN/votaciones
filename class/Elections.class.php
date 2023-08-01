<?php
date_default_timezone_set('America/Santiago');
class Elections{
  private $id;
  private $id_region;
  private $rut;
  private $cadena;
  private $name_lastname;
  private $alias;
  private $email;
  private $id_comuna;
  private $id_candidato;
  private $id_contacto;
  private $attrib;
  private $column;
  private $query;

  private $conn;

  public function __construct(){
    $this->conn = new Database();
  }

  public function set($attrib, $content) {
    $this->$attrib = $content;
    $this->column = $attrib;
  }

  public function get($attrib) {
    return $this->$attrib;
  }

  public function list_regions(){
    try {
      $this->query = $this->conn->prepare('SELECT id_region, region FROM tbl_regiones');
      $this->query->execute();
      $result = $this->query->fetchAll();
      $this->query = null;
      return $result;
    }catch (PDOException $e) {
        $e->getMessage();
    }
  }
  
  public function get_comunas(){
    try {
      $this->query = $this->conn->prepare('SELECT id_comuna, comuna FROM tbl_comunas 
                                          INNER JOIN tbl_provincias ON tbl_provincias.id_provincia = tbl_comunas.id_provincia 
                                          INNER JOIN tbl_regiones ON tbl_regiones.id_region = tbl_provincias.id_region 
                                          WHERE 
                                          tbl_provincias.id_region = :id_region
                                          GROUP BY tbl_comunas.id_comuna');
      $this->query->bindValue(':id_region', $this->id_region, PDO::PARAM_INT);
      $this->query->execute();
      $result = $this->query->fetchAll();
      $this->query = null;
      return $result;
    }catch (PDOException $e) {
        $e->getMessage();
    }
  }
  
  public function list_contacts(){
    try {
      $this->query = $this->conn->prepare('SELECT id_contacto, descr_contacto FROM tbl_contactos 
                                          ORDER BY id_contacto ASC');
      $this->query->execute();
      $result = $this->query->fetchAll();
      $this->query = null;
      return $result;
    }catch (PDOException $e) {
        $e->getMessage();
    }
  }
  
  public function list_candidatos(){
    try {
      $this->query = $this->conn->prepare('SELECT id_candidato, nombre_candidato FROM tbl_candidatos
                                          ORDER BY nombre_candidato ASC');
      $this->query->execute();
      $result = $this->query->fetchAll();
      $this->query = null;
      return $result;
    }catch (PDOException $e) {
        $e->getMessage();
    }
  }

  public function get_vote_string(){
    try {
      $this->query = $this->conn->prepare('SELECT id_voto FROM tbl_votos 
                                          WHERE '.$this->cadena);
      $this->query->execute();
      $result = $this->query->fetchAll();
      $this->query = null;
      return $result;
    }catch (PDOException $e) {
        $e->getMessage();
    }
  }

  public function create_vote(){
    try {
      $this->query = $this->conn->prepare("INSERT INTO tbl_votos(rut, name_lastname, alias, email, id_region, id_comuna, id_candidato) 
                                          VALUES (:rut, :name_lastname, :alias, :email, :id_region, :id_comuna, :id_candidato)");
      $this->query->bindValue(':rut', $this->rut, PDO::PARAM_STR);
      $this->query->bindValue(':name_lastname', $this->name_lastname, PDO::PARAM_STR);
      $this->query->bindValue(':alias', $this->alias, PDO::PARAM_STR);
      $this->query->bindValue(':email', $this->email, PDO::PARAM_STR);
      $this->query->bindValue(':id_region', $this->id_region, PDO::PARAM_INT);
      $this->query->bindValue(':id_comuna', $this->id_comuna, PDO::PARAM_INT);
      $this->query->bindValue(':id_candidato', $this->id_candidato, PDO::PARAM_INT);
      $this->query->execute();
      $result = $this->query->rowCount();
      return $result;
    } catch (PDOException $e) {
        $e->getMessage();
    }
  }

  public function create_contact(){
    try {
      $this->query = $this->conn->prepare("INSERT INTO tbl_registro_contactos(rut, id_contacto) VALUES (:rut, :id_contacto)");
      $this->query->bindValue(':rut', $this->rut, PDO::PARAM_STR);
      $this->query->bindValue(':id_contacto', $this->id_contacto, PDO::PARAM_INT);
      $this->query->execute();
      $result = $this->query->rowCount();
      return $result;
    } catch (PDOException $e) {
        $e->getMessage();
    }
  }

}
