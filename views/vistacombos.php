<?php

require_once('combosModelo.php');


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<!--QUITAR ASquiv="refresh" content="3">-->
	<title>Sistema De Reservas</title>
	<link href="../css/font.css" rel="stylesheet" type="text/css">
	<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../css/crud.css" rel="stylesheet" type="text/css">
	<link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/misc.js"></script>
	<script type="text/javascript" src="../js/crudCliente.js"></script>
</head>
<style type="text/css">
	* {
	  padding: 0;
	  margin: 0;
	}
	p {
	  margin-bottom: 20px;
	}
	.wrapper {
	  width: 80%;
	  /*margin: auto;*/
	  overflow:hidden;
	}
	header {
	  background: rgba(0,0,0,0.9);
	  width: 100%;
	  position: fixed;
	  z-index: 10;
	}
	.body{
		padding-top: 80px;
	}
	nav {
	  float: left; /* Desplazamos el nav hacia la izquierda */
	}
	nav ul {
	  list-style: none;
	  overflow: hidden; /* Limpiamos errores de float */
	}
	nav ul li {
	  float: left;
	  font-family: Arial, sans-serif;
	  font-size: 16px;
	}
	nav ul li a {
	  display: block; /* Convertimos los elementos a en elementos bloque para manipular el padding */
	  padding: 20px;
	  color: #fff;
	  text-decoration: none;
	}
	nav ul li:hover {
	  background: #3ead47;
	}
	.contenido {
	  padding-top: 80px;
	}
		
</style>
<?php 
	$base_url="http://localhost/sist/views/"
	
?>
<header>
  <section class="wrapper">
        <nav>
            <ul>
                <li><a href="<?php echo $base_url .'index.php';?>">Inicio</a></li>
                <li><a href="<?php echo $base_url .'vistacliente.php';?>">Clientes</a></li>
                <li><a href="<?php echo $base_url .'vistacombos.php';?>">Combos</a></li>
            </ul>
    	</nav>
    </section>
</header>
<body>



<section class="body">
	<div class="container">
		<div class="table-responsive">
			<button type="button"
				class="btn btn-lg btn-primary"
				data-toggle="modal"
				data-target="#myModal"
				style='margin-bottom:10px;'
				onclick="newCbCliente()">Nuevo
			</button>
			<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Id</th>
							<th>Nombre</th>
							<th>Apellido</th>
							<th>Telefono</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$mysqli = new mysqli('localhost', 'admin', 'admin', 'sysreserva');

						if ( $mysqli->connect_errno )
						{
							die( $mysqli->mysqli_connect_error() );
						}


						if (isset($_POST["save-cliente"])) {  
			                $nombre = $_POST['nombre'];
			                $apellido = $_POST['apellido'];
			                $tel  = $_POST['tel'];
			                if($_POST['modo'] === 'new'){	
			                	$mysqli->query("INSERT INTO cliente(nombre, apellido, tel) VALUES('".$nombre."', '".$apellido."', '".$tel."')");
			                }
			                else{
			                	$id = $_POST['id'];
			                	$mysqli->query("UPDATE cliente SET nombre ='".$nombre."', apellido='".$apellido."', tel='".$tel."' WHERE id='".$id."'");
			                }
			               header('Location: '.$base_url.'vistacliente.php');
		            	}

		            	if (isset($_POST["delete-cliente-select"]) ) { 
					        $idselect = $_POST['iddelete'];
					        $mysqli->query("DELETE FROM cliente WHERE id='".$idselect."'");
					        header('Location: '.$base_url.'vistacliente.php');
						}


						$result = $mysqli->query('SELECT * FROM cliente');
						if( !$result )
							die( $mysqli->error );
						while($clientes = $result->fetch_assoc())
						{
						?>
									<tr>	
										<td><?php print $clientes['id']; ?></td>
										<td><?php print $clientes['nombre']; ?></td>
										<td><?php print $clientes['apellido']; ?></td>
										<td><?php print $clientes['tel']; ?></td>
										<td>
											<button id="see-cliente" name="see-cliente" type="button" class="btn btn-success"
		        							data-toggle="modal"
									        data-target="#myModal"
									        onclick="openCbCliente('see','<?php print $clientes['id']; ?>','<?php print $clientes['nombre']; ?>','<?php print $clientes['apellido']; ?>','<?php print $clientes['tel']; ?>')">
									    	Ver</button>

									    	<button id="edit-cliente" name="edit-cliente" type="button" class="btn btn-primary"
			        							data-toggle="modal"
										        data-target="#myModal"
										        onclick="openCbCliente('edit','<?php print $clientes['id']; ?>','<?php print $clientes['nombre']; ?>','<?php print $clientes['apellido']; ?>','<?php print $clientes['tel']; ?>')">
										    Editar</button>

										    <button id="delete-cliente-modal" name="delete-cliente-modal" type="button" class="btn btn-danger"
			        							data-toggle="modal"
										        data-target="#myModalDelete"
										        onclick="deleteCbCliente(<?php print $clientes['id']; ?> , '<?php print $clientes['nombre']; ?>' )">
										    Eliminar</button>
									    </td>
									</tr>                             
				<?php		} ?>
					</tbody>
			</table>
		</div>
	</div>
</section>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Crear Cliente</h4>
            </div>
            <form role="form" name="formCliente" method="post" action="vistacliente.php">
                <div class="modal-body">                                    
                    <div class="input-group">
                        <input type="hidden" class="form-control" id="modo" name="modo">
                    </div>
                    <div class="input-group">
                        <input type="hidden" class="form-control" id="id" name="id" placeholder="Id se Autogenera" >
                    </div>
                    <div class="input-group">
                        <label for="apellido">Nombre</label>
                        <input type="text" class="form-control" style='text-transform:uppercase;' id="nombre" name="nombre" placeholder="Nombre" >
                    </div>
                    <div class="input-group"> 
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" style='text-transform:uppercase;' id="apellido" name="apellido" placeholder="Apellido" aria-describedby="sizing-addon2">
                    </div>                        
                    <div class="input-group"> 
                        <label for="tel">Teléfono</label>
                        <input type="text" class="form-control" style='text-transform:uppercase;' id="tel" name="tel" placeholder="Teléfono" aria-describedby="sizing-addon2">
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button id="save-cliente" name="save-cliente" type="submit" class="btn btn-primary">Guardar</button>
                    <button id="cancel" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>                                    
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal DELETE -->
<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalDeleteLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Cliente</h4>
            </div>
            <form role="form" name="formDeleteCliente" method="post" action="vistacliente.php">
                <div class="modal-body">                                    
                        <div class="input-group">
                            <label for="id">¿Se va a eliminar el registro del cliente seleccionado?</label>
                        </div>       
                        <div class="input-group">
                            <label for="id">Id</label>
                            <input type="text" readonly class="form-control" id="iddelete" name="iddelete" >                                        
                        </div>
                        <div class="input-group">
                            <label for="id">Nombre</label>
                            <input type="text" readonly class="form-control" id="nombre" name="nombre">
                        </div>
                </div>
                <div class="modal-footer">
                        <button id="delete-cliente-select" name="delete-cliente-select" type="submit" class="btn btn-primary">Aceptar</button>                                        
                        <button id="cancel" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>                                    
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  


</body>
</html>