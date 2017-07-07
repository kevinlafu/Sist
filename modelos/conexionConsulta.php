<?php

	$mysqli = new mysqli('localhost', 'admin', 'admin', 'sysreserva');

	if ( $mysqli->connect_errno )
	{
		die( $mysqli->mysqli_connect_error() );
	}
?>