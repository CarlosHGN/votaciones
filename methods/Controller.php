<?php
class controllerElections{
	//Atributos
	private $report;
	//Metodos
	public function __construct() {
		$this->report = new Elections();
	}

	public function listRegions(){
		$result = $this->report->list_regions();
		return $result;
	}

  public function listContacts(){
		$result = $this->report->list_contacts();
		return $result;
	}
  
	public function listCandidatos(){
		$result = $this->report->list_candidatos();
		return $result;
	}

	public function getComunas($id_region){
		$this->report->set('id_region', $id_region);
		$result = $this->report->get_comunas();
		return $result;
	}

  public function getVoteString($campo,$valor){
    $cadena = "tbl_votos.$campo = '$valor'";
		$this->report->set('cadena', $cadena);
		$result = $this->report->get_vote_string();
		return $result;
	}

  public function createVote($name_lastname,$alias,$rut,$email,$id_region,$id_comuna,$id_candidato){
		$this->report->set('name_lastname', $name_lastname);
		$this->report->set('alias', $alias);
		$this->report->set('rut', $rut);
		$this->report->set('email', $email);
		$this->report->set('id_region', $id_region);
		$this->report->set('id_comuna', $id_comuna);
		$this->report->set('id_candidato', $id_candidato);
		$result = $this->report->create_vote();
		return $result;
	}

  public function createContact($rut,$id_contacto){
    $this->report->set('rut', $rut);
		$this->report->set('id_contacto', $id_contacto);
		$result = $this->report->create_contact();
		return $result;
	}

}