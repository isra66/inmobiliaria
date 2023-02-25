<!doctype html>
<html lang="en">

<head>
  <title>
    
  </title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
 
<?php

session_start();

// Conexión a la base de datos
$conn = mysqli_connect("localhost", "root", "", "inmobiliaria");
if(mysqli_connect_errno()) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
// Agregar una página
if(isset($_POST['titulo']) && isset($_POST['contenido'])) {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $ruta_imagen = "imagenes/";
    if(isset($_FILES['imagen'])) {
        $nombre_imagen = $_FILES['imagen']['name'];
        $ruta_imagen = "imagenes/" . $nombre_imagen;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen);
    }
    $sql = "INSERT INTO paginas (titulo, contenido, imagen_ruta) VALUES ('$titulo', '$contenido', '$ruta_imagen')";
    mysqli_query($conn, $sql);
}

// Editar una página
if(isset($_POST['id']) && isset($_POST['titulo_editar']) && isset($_POST['contenido_editar'])) {
    $id = $_POST['id'];
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo_editar']);
    $contenido = mysqli_real_escape_string($conn, $_POST['contenido_editar']);
    $ruta_imagen = "";
    if(isset($_FILES['imagen_editar']) && $_FILES['imagen_editar']['size'] > 0) {
        $nombre_imagen = $_FILES['imagen_editar']['name'];
        $ruta_imagen = "imagenes/" . $nombre_imagen;
        move_uploaded_file($_FILES['imagen_editar']['tmp_name'], $ruta_imagen);
    }
    $sql = "UPDATE paginas SET titulo='$titulo', contenido='$contenido', imagen_ruta='$ruta_imagen' WHERE id='$id'";
    mysqli_query($conn, $sql);
}


 // Eliminar una página
if(isset($_POST['id_eliminar'])) {
  $id = $_POST['id_eliminar'];
  $sql = "DELETE FROM paginas WHERE id=$id";
  mysqli_query($conn, $sql);
  }
  ?>
  
         <h1>Bienvenido</h1>
         <h2>Agregar página</h2>
         <form method="post" enctype="multipart/form-data">
             <label>Título:</label>
             <input type="text" name="titulo"><br>
             <label>Contenido:</label>
             <textarea name="contenido"></textarea><br>
             <label>Imagen:</label>
             <a href="mostrar_pagina.php?actualizar=1">Ver página</a>
             <input type="file" name="imagen"><br>
             <button type="submit">Agregar</button>
         </form>
         <h2>Editar página</h2>
         <table>
             <thead>
                 <tr>
                     <th>Título</th>
                     <th>Contenido</th>
                     <th>Imagen</th>
                     <th>Acciones</th>
                 </tr>
             </thead>
             <tbody>
                 <?php
                 $sql = "SELECT * FROM paginas";
                 $result = mysqli_query($conn, $sql);
                 echo "<a href='mostrarPagina.php'><button>'Ver página'</button></a>";
                 while($fila = mysqli_fetch_assoc($result)) 
                 {
                     echo "<tr>";
                     echo "<td>" . $fila['titulo'] . "</td>";
                  
                     echo "<td>" . $fila['contenido'] . "</td>";
                     if($fila['imagen_ruta'] != "") {
                         echo "<td><img src='" . $fila['imagen_ruta'] . "' width='100'></td>";
                     } else {
                         echo "<td></td>";
                     }
                     echo "<td>";
                     echo "<button onclick='editar(" . $fila['id'] . ")'>Editar</button>";
                     echo "<form method='post' style='display: inline-block;'>";
                     echo "<input type='hidden' name='id_eliminar' value='" . $fila['id'] . "'>";
                     echo "<button type='submit'>Eliminar</button>";
                   

                     echo "</form>";
                     echo "</td>";
                     echo "</tr>";
                 }
                 ?>
             </tbody>
         </table>
        
         <div id="formulario_edicion" style="display: none;">
        
             <h3>Editar página</h3>
             <form method="post" enctype="multipart/form-data">
                 <input type="hidden" name="id" id="id_editar">
                 <label>Título:</label>
                 <input type="text" name="titulo_editar" id="titulo_editar"><br>
                 <label>Contenido:</label>
                 <textarea name="contenido_editar" id="contenido_editar"></textarea><br>
                 <label>Imagen:</label>
                 <input type="file" name="imagen_editar"><br>
                 <button type="submit">Guardar cambios</button>
                 <button type="button" onclick="cancelar()">Cancelar</button>
             </form>
         </div>
    <script>

function editar(id) {
           // Obtener los datos de la página a editar mediante AJAX
           var xhr = new XMLHttpRequest();
           xhr.onreadystatechange = function() {
               if(this.readyState == 4 && this.status == 200) {
                   var pagina = JSON.parse(this.responseText);
                   document.getElementById("id_editar").value = pagina.id;
                   document.getElementById("titulo_editar").value = pagina.titulo;
                   document.getElementById("contenido_editar").value = pagina.contenido;
                   document.getElementById("formulario_edicion").style.display = "block";
               }
           };
           xhr.open("GET", "editar_pagina.php?id=" + id, true);
           xhr.send();
       }
       function cancelar() {
           document.getElementById("formulario_edicion").style.display = "none";
       }
   </script>


</body>
   </html>
   <?php
   // Cerrar la conexión a la base de datos
   mysqli_close($conn);
   ?>












  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>