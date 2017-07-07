<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<!--QUITAR ASquiv="refresh" content="3">-->
	<title>Sistema De Reservas</title>
	<link href="../css/font.css" rel="stylesheet" type="text/css">
	<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../css/app.css" rel="stylesheet" type="text/css">
	<link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/app.js"></script>
	<script type="text/javascript" src="../js/botonera.js"></script>
	<script type="text/javascript" src="../js/misc.js"></script>
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

<div class="calendar">



<?php

	$mysqli = new mysqli('localhost', 'admin', 'admin', 'sysreserva');

	if ( $mysqli->connect_errno )
	{
		die( $mysqli->mysqli_connect_error() );
	}
	
	
	
	$datetime = new DateTime();

	// mes en texto
	$txt_months = array(
		'Enero', 'Febrero', 'Marzo',
		'Abril', 'Mayo', 'Junio',
		'Julio', 'Agosto', 'Septiembre',
		'Octubre', 'Noviembre', 'Diciembre'
	);
	$txt_months_cal = array(
		'January', 'February', 'March',
		'April', 'May', 'June',
		'July', 'August', 'September',
		'October', 'November', 'December'
	);

	//$bandera= true;
	$movimiento= $datetime->format('n');
	$var_php= $datetime->format('n');
	
	echo "<script language='javascript'>
		var cantidad;
		document.getElementById('var_php');
	     </script> ";
	     //cantidad = prompt('Introduce cantidad',1);
	//Ya tenemos capturada la variable con javascript
	?>	
		<form  method="POST" name="enviar" action="index.php">
		            <select name="var_php" class="styled-select slate">    
       					<option value="1" selected="selected">Enero</option>
       					<option value="2">Febrero</option>
       					<option value="3">Marzo</option>
       					<option value="4">Abril</option>
       					<option value="5">Mayo</option>
       					<option value="6">Junio</option>
       					<option value="7">Julio</option>
       					<option value="8">Agosto</option>
       					<option value="9">Septiembre</option>
       					<option value="10">Octubre</option>
       					<option value="11">Noviembre</option>
       					<option value="12">Diciembre</option>
  					</select>
		            <input type="submit" name="submit" value="Elegir" class="btn btn-lg btn-primary"></form>
	<?php	 
		 if($bandera = 0){ //action="<?php echo $_SERVER['PHP_SELF']; ?>"
	?>
		 	<script language='javascript'>
		              document.enviar.var_php.value=cantidad;
		              document.enviar.submit();
		</script>
	<?php
		$bandera=false;
	}
	
	$movimiento = "1";
	$var_php = "1";
	
	if (isset($_POST['var_php']))	{
		$var_php = $_POST ['var_php'];//"<script> document.write(cantidad); </script>";
	}
	$movimiento =$var_php;

	/*  	if(isset($_GET['count']))	{
	  		$movimiento= 1;
	  		//$movimiento = (int) $_REQUEST['movim'];
	  	}
	echo ' '.$movimiento;*/

    //aca empieza lo del form ?actionevent
	if(isset($_GET['add-event']))
	{
		$error = true;

		if(!isset($_POST['start_hour']) || empty($_POST['start_hour']))
			$errors[] = 'hora de inicio necesaria';

		if(!isset($_POST['end_hour']) || empty($_POST['end_hour']))
			$errors[] = 'hora de finalizacion necesaria';

		$start_hour = explode(':', isset($_POST['start_hour']) ? $_POST['start_hour'] : '');
		$end_hour = explode(':', isset($_POST['end_hour']) ? $_POST['end_hour'] : '');

		if(!preg_match('~^([1-2][0-3]|[01]?[1-9]):([0-5]?[0-9]):([0-5]?[0-9])$~', $_POST['start_hour']))
		{
			$errors[] = 'hora de inicio incorrecta';
		}

		if(!preg_match('~^([1-2][0-3]|[01]?[1-9]):([0-5]?[0-9]):([0-5]?[0-9])$~', $_POST['end_hour']))
		{
			$errors[] = 'hora de finalizacion incorrecta';
		}

		$month = (int) $_POST['month'];
		$day = (int) $_POST['day'];

		$start_datetime = new DateTime();
		$end_datetime = new DateTime();

		$start_datetime->setDate(date('Y'), $month, $day);
		$end_datetime->setDate(date('Y'), $month, $day);

		$start_datetime->setTime(
			$start_hour[0],
			$start_hour[1],
			$start_hour[2]
		);

		$end_datetime->setTime(
			$end_hour[0],
			$end_hour[1],
			$end_hour[2]
		);

		if($end_datetime < $start_datetime)
			$errors[] = 'la hora de finalizacion debe ser superar a la de inicio';

		$description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

		if( empty($description) || trim($description) == '' )
			$errors[] = 'descripcion invalida';

		$pAct = $_POST['pago'];
		echo $pAct;

		if( empty($pAct) || trim($description) == '' )
			$errors[] = 'falta pago';

		$pTot = $_POST['combo'];
		echo $pTot;

		if( empty($pAct) || trim($description) == '' )
			$errors[] = 'falta combo';

		//si hasta aca no hubo errores continua con la grabacion en la base de datos.

		if( !empty($errors) )
		{
			die(implode('<br>', $errors) . '
				</body></html>');
		}
		else
		{
			$formated_startdate = $start_datetime->format('Y-m-d G:i:s');
			$formated_enddate = $end_datetime->format('Y-m-d G:i:s');
			$team_code = 1;

			$data = array(
				'des'=>$description,
				'inicio'=>$formated_startdate,
				'fin'=>$formated_enddate,
				'pAct' => (float) $pAct,
				'pTot' => (float) $pTot, 
				'equipo'=>$team_code
			);
			//$this->events_model->crearEvento($data);

			if($stmt = $mysqli->prepare("
				INSERT INTO calendar_events
				(descripcion, fecha_inicio, fecha_fin, cod_equipo) 
				VALUES (?, ?, ?, ?)"))
			{
				$stmt->bind_param('sssi', 
					$description,
					$formated_startdate,
					$formated_enddate,
					$team_code
				);

				$stmt->execute();

				header('location: index.php');
			}
			else
			{
				die($mysqli->error . '
					</body></html>');
			}
		}
	}

	$result = $mysqli->query('SELECT * FROM calendar_events');

	if( !$result )
		die( $mysqli->error );

	$events = array();

	while($row = $result->fetch_assoc())
	{
		$start_date = new DateTime($row['fecha_inicio']);
		$end_date = new DateTime($row['fecha_fin']);
		$day = $start_date->format('j');
		$month = $start_date->format('n');

		$events[$month][] = array(
			'id' => $row['id'],
			'day' => $day,
			'start_hour' => $start_date->format('G:i a'),
			'end_hour' => $end_date->format('G:i a'),
			'preAct' => $row['precio_actual'],
			'preTot' => $row['precio_total'],
			'team_code' => $row['cod_equipo'],
			'description' => $row['descripcion']
		);
	}
	
	$datetime = new DateTime();

	// mes en texto
	$txt_months = array(
		'Enero', 'Febrero', 'Marzo',
		'Abril', 'Mayo', 'Junio',
		'Julio', 'Agosto', 'Septiembre',
		'Octubre', 'Noviembre', 'Diciembre'
	);
	$txt_months_cal = array(
		'January', 'February', 'March',
		'April', 'May', 'June',
		'July', 'August', 'September',
		'October', 'November', 'December'
	);
//****************************esta parte esta como backup******************************************************************************************
	// month number
	//$month_number = $datetime->format('n')+ intval($movimiento);
	

	// nombre del mes
	//$month_txt = ucwords($txt_months[$datetime->format('n')-1+ intval($movimiento)]);
	

	// ultimo dia del mes
	//$month_days = date('j', strtotime("last day of"))+ intval($movimiento);
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	// month number
	$month_number = $movimiento;
	

	// nombre del mes
	$month_txt = ucwords($txt_months[$movimiento-1]);
	$month_txt_cal = ucwords($txt_months_cal[$movimiento-1]);
	$str="last day of".$month_txt_cal;
	// ultimo dia del mes
	$month_days = date('j', strtotime($str));

	echo '<h1>' . $month_txt . '</h1>';

	

	$contadorIndiv = 0;
	
	foreach(range(1, $month_days) as $day)
	{
		$contadorIndiv++;
		$marked = false;
		$markedType = false;
		$events_list = array();
		// si existe el mes en los eventos...
		if(array_key_exists($month_number, $events))
		{
			// recorremos los eventos del mes $events[numero de mes]
			foreach($events[$month_number] as $key => $event)
			{
				// si el dia del evento coincide lo marcamos y guardamos la informacion
				if($event['day'] == $day)
				{
					$marked = true;
					$events_list[] = $event;
					if($event['preAct'] == $event['preTot']){
						$markedType = true;
					}
					break;
				}
			}
		}

		echo '
		<div class="day' . ($marked ? ' marked' : '') . ($markedType ? ' pagado' : '') . '">
			<strong class="day-number">' . $day . '</strong>';

			if( !empty($events_list) )
			{
				echo '<div class="events"><ul>';
					
					foreach($events_list as $event)
					{
						echo '<li>
							<h5>' . $event['description'] . '</h5>
							<div>
								<strong>Inicio:</strong>
								<span>' . $event['start_hour'] . '</span>
							</div>
							
							<div>
								<strong>Fin:</strong>
								<span>' . $event['end_hour'] . '</span>
							</div>

							<div>
								<strong>Deuda:</strong>
								<span>' . "Faltan: $". ($event['preTot']-$event['preAct']) . '</span>
							</div>
						</li>';
					}

				echo '</ul></div>';
			}
			else
			{
				echo '<a data-month="' . $month_number . '" data-day="' . $day . '" class="add-event" href="#">
					<img border="0" alt="Crear Evento" src="../img/agendaico.png" id="b'.$contadorIndiv.'" onmouseOver="mouseOver('.$contadorIndiv.')" onmouseOut="mouseOut('.$contadorIndiv.')"/>
					</a>';
			}

		echo '</div>';
	}
	?>
</div>
<div class="add-event-form">
	<div class="wrapper">
		<form method="POST" action="?add-event">
		<? //aca se carga el formulario que se cargara con el evento .modal('show') ?>
		</form>
	</div>
</div>

<? //aca empieza el formulario que se cargara con el evento .modal('show') ?>
<div class="modal fade" id="add-event">
  <div class="modal-dialog">
    <div class="modal-content">
    <form method="POST" action="?add-event">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Agregar evento</h4>
      </div>
      <div class="modal-body">
			<div>
				<label>Descripcion</label>
				<input type="text" name="description">
			</div>
			<div>
				<label>Pago</label>
				<input type="text" name="pago" value="0">
			</div>
			<div>
				<label>Combo</label>
				<input type="text" name="combo" value="3200">
			</div>
			<div>
				<label>Hora de inicio</label>
				<input type="text" name="start_hour" value="08:00:00">
			</div>
			<div>
				<label>Hora de finalizacion</label>
				<input type="text" name="end_hour" value="23:00:00">
			</div>
			<div>
				<input type="hidden" name="month">
				<input type="hidden" name="day">
			</div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Agregar evento</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>