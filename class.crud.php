<?php

class crud
{
	private $db;
	
	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}
	public function ListarDatos(){
		try{
			$query 	  = "select * from tbl_users";
			$stmt 	  = $this->db->prepare($query);
			$stmt->execute();
			$data	  = array();
			$contador = 0;
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$data['data'][] = $row;
				$contador = $contador + 1;
			}
			if($contador == 0){
				throw new Exception( "No Hay Informacion" );
			}
			$data['success'] = true;
			echo json_encode($data);
		}
		catch (Exception $e){
			$data = array();
			$data['success'] = false;
			$data['message'] = $e->getMessage();
			echo json_encode($data);
			
		}
	}
	public function Guarda($id,$nombre,$apellidos,$email,$telefono){
		try
		{
			if($nombre == '' || $apellidos == '' || $email == ''|| $telefono == '' ){
				throw new Exception( "Los Campos Son Obligatorios" );
			}
			$data = array(); 
			if($id==""){
				$stmt = $this->db->prepare("INSERT INTO tbl_users(first_name,last_name,email_id,contact_no) VALUES(:fname, :lname, :email, :contact)");
				$stmt->bindparam(":fname",$nombre);
				$stmt->bindparam(":lname",$apellidos);
				$stmt->bindparam(":email",$email);
				$stmt->bindparam(":contact",$telefono);
				$stmt->execute();
				$data['id'] = $this->db->lastInsertId();
				$data['success'] = true;
				$data['message'] = 'Informacion Guardada!!';
			}else{
				$stmt=$this->db->prepare("UPDATE tbl_users SET first_name=:fname, 
														   last_name=:lname, 
														   email_id=:email, 
														   contact_no=:contact
														WHERE id=:id ");
				$stmt->bindparam(":fname",$nombre);
				$stmt->bindparam(":lname",$apellidos);
				$stmt->bindparam(":email",$email);
				$stmt->bindparam(":contact",$telefono);
				$stmt->bindparam(":id",$id);
				$stmt->execute();				
				$data['success'] = true;
				$data['message'] = 'Informacion Actualizada Correctamente';
			}
			echo json_encode($data);
		}
		catch(PDOException $e)
		{ 
			$data = array();
			$data['success'] = false;
			$data['message'] = $e->getMessage();
			echo json_encode($data);
		}
	} 
	public function EliminarUsuario($id)
	{
		$data = array();
		try
		{			
			$stmt = $this->db->prepare("DELETE FROM tbl_users WHERE id=:id");
			$stmt->bindparam(":id",$id);
			$stmt->execute();
			$data['success'] = true;
			$data['message'] = 'Usuario eliminado correctamente'; 
		}
		catch(PDOException $e)
		{ 			 
			$data['success'] = false;
			$data['message'] = $e->getMessage();			
		}
		echo json_encode($data);
	}
	function AccionNoValida()
	{
		$data = array();
		$data['success'] = false;
		$data['message'] = "Accion No valida";
		echo json_encode($data); 
	}	
}
