<?php session_start();
	extract($_REQUEST);
	$id_proyecto = 1;
	//echo "Hola usuario: " . $_SESSION['usuario'] . ", bienvenido al proyecto '" . $_SESSION['id_proyecto'] . "'";

  include "../conexion_bd.php";


  // id_alumno      id_pregunta      nota


  $resultado=mysqli_query($conexion, "SELECT * FROM tbl_proyecto WHERE id_proyecto = $id_proyecto");
                        
  if (mysqli_num_rows($resultado) != 0){
    while ($proyectos = mysqli_fetch_array($resultado)) {
      $titulo_proyecto = $proyectos['titulo_proyecto'];
      $id_ano_pregunta = $proyectos['id_ano_pregunta'];
    }
  }

    $participantes=mysqli_query($conexion, "SELECT * FROM tbl_participante INNER JOIN tbl_usuario_alumno ON tbl_participante.id_usuario_alumno = tbl_usuario_alumno.id_usuario_alumno WHERE id_proyecto = $id_proyecto");
    if (mysqli_num_rows($participantes) != 0){
      $alumnos=0;
      while ($alumno = mysqli_fetch_array($participantes)) {
        $id_alumno = $alumno['id_usuario_alumno'];
        $alumnoArray[$alumnos] = $id_alumno; 
        $alumnos++;
      }
    }

  $preguntasql=mysqli_query($conexion, "SELECT * FROM tbl_pregunta_alumnos WHERE id_ano_pregunta = $id_ano_pregunta");
    if (mysqli_num_rows($preguntasql) != 0){
      $pregs=0;
      $pregsConjuntas=0;
    while ($pregunta = mysqli_fetch_array($preguntasql)) {
      $conjunta = $pregunta['comuna'];
      if ($conjunta == 0) {
        $preguntaArray[$pregs] = $pregunta['id_pregunta_alumno'];
        $preguntaTemporal = $pregunta['pregunta_alumno'];
        $pregs++;
      }else{
        $pregConjunta[$pregsConjuntas] = $pregunta['pregunta_alumno'];
      }
    }
  }

///////////////////////////////////////////////////////////////////////////////////////////
  $contadorTotal = 1;

    for ($i=0; $i < $pregs; $i++) { 
      echo "
          <h2>$preguntaArray[$i]</h2>
      ";
      for ($j=0; $j < $alumnos; $j++) { 
        $contadorTotal++;
        //$ponerPregunta = $pregunta[$i];
        echo "${$p"."$contadorTotal";
          //<img src='fb1.jpg'>
          // <i class='fa fa-meh-o' aria-hidden='false'></i>
          // <i class='fa fa-smile-o' aria-hidden='false'></i>
          //<i class='fa fa-frown-o' aria-hidden='false'></i>
        $fkiodsngf = $i . ".". $j;
        echo "
        $fkiodsngf
        
        ";
      }
    }
    ////////////////////////////////////////////////////////////////////////////////
    

  ?>

