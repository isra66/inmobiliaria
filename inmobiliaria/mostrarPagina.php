<?php
// Conexión a la base de datos
$conn = mysqli_connect("localhost", "root", "", "inmobiliaria");
if(mysqli_connect_errno()) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Consulta para obtener las páginas
$sql = "SELECT * FROM paginas";
$resultado = mysqli_query($conn, $sql);

// Generar el HTML para mostrar las páginas
$html_paginas = "";
while($fila = mysqli_fetch_assoc($resultado)) {
    $titulo = $fila["titulo"];
    $contenido = $fila["contenido"];
    $imagen_ruta = $fila["imagen_ruta"];
    
    // Generar el HTML para mostrar una página
    $html_pagina = "<div class='pagina'>";
    $html_pagina .= "<h2>$titulo</h2>";
    if(!empty($imagen_ruta)) {
        $html_pagina .= "<img src='$imagen_ruta'>";
    }
    $html_pagina .= "<p>$contenido</p>";
    $html_pagina .= "</div>";
    
    $html_paginas .= $html_pagina;
}
if(isset($_GET['actualizar']) && $_GET['actualizar'] == 1) {
    // actualizar la página en la base de datos aquí
}

// mostrar la página aquí

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>

    <?php //include 'admin.php'; ?>
    <?php echo $html_paginas; ?>

