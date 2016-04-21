<?php include('header.php'); ?>
<div class="container">
	<div style="display: none" role="alert" class="alert alert-danger text-center alert-failure-div"><p></p></div>
	<div style="display: none" role="alert" class="alert alert-success text-center alert-success-div"><p></p></div>
	
	<div class="col-xs-3">
				
				<form name="userForm" novalidate="">
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" data-ng-model="tempUser.nombre" name="nombre" id="nombre" class="form-control" required=""  data-ng-minlength="3">			 
						<span class="help-block error" data-ng-show="userForm.nombre.$invalid && userForm.nombre.$dirty">
							{{getError(userForm.nombre.$error, 'nombre')}}
						</span>
					</div>
					<div class="form-group">
						<label>Apellidos</label>
						<input type="text" data-ng-model="tempUser.apellidos" name="apellidos" id="apellidos" class="form-control" required="" data-ng-minlength="3">
						<span class="help-block error" data-ng-show="userForm.apellidos.$invalid && userForm.apellidos.$dirty">
							{{getError(userForm.apellidos.$error, 'apellidos')}}
						</span>
					</div>
					<div class="form-group">
						<label>Email</label> 
						<input type="email" data-ng-model="tempUser.email" name="email" id="email" class="form-control" required="" data-ng-minlength="3">
						<span class="help-block error" data-ng-show="userForm.email.$invalid && userForm.email.$dirty">
							{{getError(userForm.email.$error, 'email')}}
						</span>
					</div>
					<div class="form-group">
						<label>Telefono</label>  
						<input type="text" data-ng-model="tempUser.telefono" name="telefono" id="telefono" class="form-control" required="" data-ng-minlength="3">
						<span class="help-block error" data-ng-show="userForm.telefono.$invalid && userForm.telefono.$dirty">
							{{getError(userForm.telefono.$error, 'telefono')}}
						</span>
					</div>
					
					<!-- <input type="hidden" data-ng-model='tempUser.id'>  -->
					<div class="text-center">
						<button data-ng-click="AgregarUsuario()" class="btn btn-save" type="submit" ng-hide="tempUser.id" data-loading-text="Guardando..." ng-disabled="userForm.$invalid" disabled="disabled">Guardar</button>
						<button data-ng-click="ActualizarUsuario()" class="btn btn-save ng-hide" type="submit" ng-hide="!tempUser.id" data-loading-text="Actualizando..." ng-disabled="userForm.$invalid" disabled="disabled">Actualizar</button>
					</div>
					
				</form>
				<div class="clearfix"></div>
				
		</div>
		<div class="col-xs-9 col-sm-9">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th width="5%">#</th>
							<th width="20%">Nombre</th>
							<th width="20%">Apellidos</th>
							<th width="20%">Email</th>
							<th width="15%">Telefono</th>
							<th width="20%">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr class="ng-scope" data-ng-repeat="user in post.users">
							<td>{{ user.id }}</th>
						    <td>{{ user.first_name }}</td>
						    <td>{{ user.last_name }}</td>
						 	<td>{{ user.email_id }}</td>
						 	<td>{{ user.contact_no }}</td>
						 	<td><span data-ng-click="editUser(user)"><img src="images/editar.png" style="cursor:pointer;"/></span> <span data-ng-click="EliminarUsuario(user)"><img src="images/eliminar.png" style="cursor:pointer;"/></span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
</div>
<?php include_once 'footer.php'; ?>