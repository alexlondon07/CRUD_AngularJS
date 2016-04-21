$appModulo = angular.module('appModulo', []);
//var base_path = 'http://localhost/Angular/';//Definir path
var base_path = 'http://localhost:3000/Github/AngujarJs-master/';//Definir path

$appModulo.controller('Controlador',function($scope, $http){
	$scope.post = {};
	$scope.post.users = [];
	$scope.tempUser = {};
	$scope.editMode = false;
	$scope.index = '';

	var url = base_path+'crud.php';
	//Funcion que guarda o actualiza informacion de usuario
	$scope.GuardaUser = function(){
	    $http({
	      method: 'post',
	      url: url,
	      data: $.param({'user' : $scope.tempUser, 'tipo' : 'GuardaUsuario' }),
	      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
	    }).
	    success(function(data, status, headers, config) {
	    	if(data.success){
	    		if($scope.editMode){
					console.log($scope.tempUser);
	    			$scope.post.users[$scope.index].id = $scope.tempUser.id;
	    			$scope.post.users[$scope.index].first_name = $scope.tempUser.nombre;
	    			$scope.post.users[$scope.index].last_name = $scope.tempUser.apellidos;
	    			$scope.post.users[$scope.index].email_id = $scope.tempUser.email;
	    			$scope.post.users[$scope.index].contact_no = $scope.tempUser.telefono;
	    		}else{
	    			$scope.post.users.push({
		    			id : data.id,
		    			first_name : $scope.tempUser.nombre,
		    			last_name : $scope.tempUser.apellidos,
						email_id : $scope.tempUser.email,
		    			contact_no : $scope.tempUser.telefono
		    		});
	    		}
	    		$scope.messageSuccess(data.message);
	    		$scope.userForm.$setPristine();
	    		$scope.tempUser = {};

	    	}else{
	    		$scope.messageFailure(data.message);
	    	}
	    }).
	    error(function(data, status, headers, config) {
	        $scope.codeStatus = response || "Request failed";
	    });

	    jQuery('.btn-save').button('reset');
	}
	//Boton de Guardar Nuevo Usuario
	$scope.AgregarUsuario = function(){
		jQuery('.btn-save').button('loading');
		$scope.GuardaUser();
		$scope.editMode = false;
		$scope.index = '';
	}
	//Boton de Actualizar informacion
	$scope.ActualizarUsuario = function(){
		$('.btn-save').button('loading');
		$scope.GuardaUser();
	}
	//Mostrar Informacion a editar en el formulario
	$scope.editUser = function(user){
		$scope.tempUser = {
			id: user.id,
			nombre : user.first_name,
			apellidos : user.last_name,
			email : user.email_id,
			telefono : user.contact_no
		};
		$scope.editMode = true;
		$scope.index = $scope.post.users.indexOf(user);
	}

	//Eliminar Usuarios
	$scope.EliminarUsuario = function(user){

		if (confirm("Estas Seguro De Eliminar el Usuario!")) {
			$http({
		      method: 'post',
		      url: url,
		      data: $.param({ 'id' : user.id, 'tipo' : 'Eliminar' }),
		      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		    }).
		    success(function(data, status, headers, config) {
		    	if(data.success){
		    		var index = $scope.post.users.indexOf(user);
		    		$scope.post.users.splice(index, 1);
		    	}else{
		    		$scope.messageFailure(data.message);
		    	}
		    }).
		    error(function(data, status, headers, config) {
		    	$scope.messageFailure(data.message);
		    });
		}
	}
	//Cargamos usuarios
	$scope.init = function(){
		$http({
	      method: 'post',
	      url: url,
	      data: $.param({ 'tipo' : 'Listar' }),
	      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
	    }).
	    success(function(data, status, headers, config) {

	    	if(data.success && !angular.isUndefined(data.data) ){
	    		$scope.post.users = data.data;
	    	}else{
	    		$scope.messageFailure(data.message);
	    	}
	    }).
	    error(function(data, status, headers, config) {
	    	//$scope.messageFailure(data.message);
	    });
	}
	//Mostrar Errores
	$scope.messageFailure = function (msg){
		jQuery('.alert-failure-div > p').html(msg);
		jQuery('.alert-failure-div').show();
		jQuery('.alert-failure-div').delay(5000).slideUp(function(){
			jQuery('.alert-failure-div > p').html('');
		});
	}
	//Mostramos mensajes de aviso
	$scope.messageSuccess = function (msg){
		jQuery('.alert-success-div > p').html(msg);
		jQuery('.alert-success-div').show();
		jQuery('.alert-success-div').delay(5000).slideUp(function(){
			jQuery('.alert-success-div > p').html('');
		});
	}

	//Validacion de errores
	$scope.getError = function(error, name){
		if(angular.isDefined(error)){
			if(error.required && name == 'nombre'){
				return "Teclea tu Nombre";
			}else if(error.required && name == 'apellidos'){
				return "Teclea tus Apellidos";
			}else if(error.required && name == 'email'){
				return "Teclea tu Email";
			}else if(error.required && name == 'telefono'){
				return "Coloca tu Numero de Telefono";
			}else if(error.minlength && name == 'nombre'){
				return "El Nombre debe ser mas de 3 Caracteres";
			}else if(error.minlength && name == 'apellidos'){
				return "Los Apellidos debe ser mas de 3 caracteres";
			}else if(error.email && name == 'email'){
				return "Coloca un Email Valido";
			}
		}
	}

});
