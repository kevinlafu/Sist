<?php
require_once('db_abstract_model.php');
class Cliente extends DBAbstractModel {
 public $nombre;
 public $apellido;
 public $tel;
 
 function __construct() {
 	$this->db_name = 'cliente';
 }
 
public function hola(){
	echo 'hola';
}

 
 public function set($cliente_data=array()) {
 	if(array_key_exists('id', $cliente_data)):
 		$this->get($cliente_data['id']);
	 	if($user_data['id'] != $this->email):
		 	foreach ($cliente_data as $campo=>$valor):
		 		$$campo = $valor;
		 	endforeach;
			$this->query = "
		 		INSERT INTO cliente
		 		(nombre, apellido, tel)
		 		VALUES
		 		('$nombre', '$apellido', '$tel')
		 	";
		 	$this->execute_single_query();
	 	endif;
 	endif;
 }
 
 public function edit($cliente_data=array()) {
 	foreach ($cliente_data as $campo=>$valor):
 		$$campo = $valor;
 	endforeach;
 	$this->query = "
 		UPDATE cliente
 		SET nombre='$nombre',
 		apellido='$apellido',
 		tel='$tel'
 		WHERE id = '$id'
 	";
 	$this->execute_single_query();
 }
 
 public function delete($userId='') {
 	$this->query = "
 		DELETE FROM cliente
 		WHERE id = '$userId'
 	";
 	$this->execute_single_query();
 }
 
 function __destruct() {
 unset($this);
 }
}
?>
