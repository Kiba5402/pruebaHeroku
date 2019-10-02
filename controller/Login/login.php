<?php 

$conexion = pg_connect("host=ec2-54-235-92-244.compute-1.amazonaws.com dbname=dbs23v1rd2lkgv user=rhsqpjwdszlryx password=83df7aee1c7d701ba74a7f3686fc522477caf035afc6f2c9326e3790ff1a9439");

$resultado = pg_query($conexion, "select * from comments") or die("Error en la Consulta SQL");

print_r(pg_fetch_array($resultado));
 ?>