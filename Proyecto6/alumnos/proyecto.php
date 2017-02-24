<?php session_start();
	
	$id_proyecto = 1;
	//echo "Hola usuario: " . $_SESSION['usuario'] . ", bienvenido al proyecto '" . $_SESSION['id_proyecto'] . "'";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/gallery.theme.css">
	<link rel="stylesheet" href="css/gallery.prefixed.css">
  <link rel="stylesheet" href="css/font-awesome.css">
  <link rel="stylesheet" href="css/style.css">
  <?php
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
        $nombre_alumno = $alumno['nombre_alumno'];
        $nombre_alumno = $nombre_alumno . " " . $alumno['apellido1_alumno'];
        $nombre_alumno = $nombre_alumno . " " . $alumno['apellido2_alumno'];
        //$id_ano_pregunta = $alumno['id_ano_pregunta'];
        $alumnoArray[$alumnos] = $nombre_alumno; 
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
        $preguntaArray[$pregs] = $pregunta['pregunta_alumno'];
        $preguntaTemporal = $pregunta['pregunta_alumno'];
        $pregs++;
      }else{
        $pregConjunta[$pregsConjuntas] = $pregunta['pregunta_alumno'];
      }
    }
  }



?>

  <script>
  addEventListener('load',inicio,false);

  function inicio()
  {
    document.getElementById('nota').addEventListener('change',cambioNota,false);
  }

  function cambioNota()
  {    
    document.getElementById('vernota').innerHTML=document.getElementById('nota').value;
  }
</script>  

</head>
<body>
<form action="procesarNotas.proc.php" method="POST">
  <div class="gallery">
          <section class="cd-hero">
          <ul class="cd-hero-slider">
  <?php 
  $contadorTotal = 0;
    for ($i=0; $i < $pregs; $i++) { 
      echo "
          <h2>$preguntaArray[$i]</h2>
      ";
      for ($j=0; $j < $alumnos; $j++) { 
        $contadorTotal++;
        //$ponerPregunta = $pregunta[$i];

          //<img src='fb1.jpg'>
          // <i class='fa fa-meh-o' aria-hidden='false'></i>
          // <i class='fa fa-smile-o' aria-hidden='false'></i>
          //<i class='fa fa-frown-o' aria-hidden='false'></i>
        $fkiodsngf = $i . ".". $j;
        echo "
          <input type='hidden' name='$contadorTotal'>
          <p>$alumnoArray[$j] $contadorTotal</p>
          <label class='votacion'>
            <input type='radio' name='p$contadorTotal' value='0' />
            <img src='https://upload.wikimedia.org/wikipedia/commons/thumb/e/e3/Antu_face-sick.svg/100px-Antu_face-sick.svg.png'>
          </label>
          
          <label class='votacion'>
            <input type='radio' name='p$contadorTotal' value='2.5'/>
            <img src='https://upload.wikimedia.org/wikipedia/commons/thumb/7/75/Antu_face-sad.svg/100px-Antu_face-sad.svg.png'>
          </label>
          
          <label class='votacion'>
            <input id='fb3' type='radio' name='p$contadorTotal' value='5' />
            <img src='https://upload.wikimedia.org/wikipedia/commons/thumb/b/bf/Antu_face-plain.svg/100px-Antu_face-plain.svg.png'>
          </label>
          
          <label class='votacion'>
            <input id='fb4' type='radio' name='p$contadorTotal' value='7.5' />
            <img src='https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Antu_face-wink.svg/100px-Antu_face-wink.svg.png'>
          </label>

          <label class='votacion'>
            <input id='fb5' type='radio' name='p$contadorTotal' value='10' />
            <img src='https://upload.wikimedia.org/wikipedia/commons/thumb/c/c2/Antu_face-smile-grin.svg/100px-Antu_face-smile-grin.svg.png'>
          </label>
        
        ";
      }
    }
  ?>
    <input type="submit" name="Enviar">

    <div class="controls">
    <?php 
    // $contadorTotal = 0;
    //   for ($i=0; $i < $pregs; $i++) { 
    //     for ($j=0; $j < $alumnos; $j++) { 
    //       $contadorTotal++;
    //       echo "
    //         <a href='#no-autoplay-$contadorTotal' class='control-button'>•</a>
            
    //       ";
    //     }
    //   }
    ?>
    </div>
  </div>
  </form>
</body>
</html>