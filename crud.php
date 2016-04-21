<?php
include('dbconfig.php'); 
if( isset($_POST['tipo']) && !empty( isset($_POST['tipo']) ) ){
	$type 		= $_POST['tipo'];
	
	switch ($type) {
		case "GuardaUsuario":
			$id			= isset($_POST['user']['id']) ? $_POST['user']['id'] : ''; 
			$nombre		= $_POST['user']['nombre'];
			$apellidos	= $_POST['user']['apellidos'];
			$email		= $_POST['user']['email'];
			$telefono	= $_POST['user']['telefono'];
	
			$crud->Guarda($id ,$nombre, $apellidos, $email , $telefono);
			break;
		case "Eliminar":
			$crud->EliminarUsuario($_POST['id']); 
			break;
		case "Listar":			
			$crud->ListarDatos();
			break;
		default:
			$crud->AccionNoValida();
	}
}else{
	$crud->AccionNoValida();
} 
 ?>