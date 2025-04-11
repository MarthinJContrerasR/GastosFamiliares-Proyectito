<?php 

require "conexion.php";

//Variables Globales
$error = "";             
$hay_post = false;       
$nombre = "";           
$tipoGasto= "";              
$valorGasto = "";       
$codigoGasto = null;  





?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PaginaGastos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<h1 class="text-center" style="font-family: 'Arial', sans-serif; font-size: 36px; font-weight: bold; color: #2C3E50; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); letter-spacing: 1px; margin-top: 20px;">
  GASTOS FAMILIARES
</h1>

    <div class="container">
        <form action="">

            <label class="form-label" for="nombre">Nombre de la Persona:</label>
            <input class="form-control" type="text" name="txtNombre" id="nombre" placeholder="Ingrese el Nombre de la Persona" value="<?php echo htmlspecialchars($nombre) ?>"><br>

            <label class="form-label" for="tipoGasto">Tipo de Gasto</label>
            <select class="form-select" name="tipoGasto" id="tipoGasto">
                <option value="">Seleccione un Gasto</option>
                <option value="Alimentacion" <?php echo ($tipoGasto=='Alimentacion')? 'selected' : '' ?>>Alimentacion</option>
                <option value="Transporte" <?php echo  ($tipoGasto=='Transporte')? 'selected' : '' ?>>Transporte</option>
                <option value="Salud" <?php echo ($tipoGasto=='Salud')? 'selected' : '' ?>>Salud</option>
                <option value="Cine" <?php echo  ($tipoGasto=='Cine')? 'selected' : '' ?>>Cine</option>
                <option value="Provisión" <?php echo  ($tipoGasto=='Provisión')? 'selected' : '' ?>>Provisión</option>
                <option value="Educación" <?php echo  ($tipoGasto=='Educación')? 'selected' : '' ?>>Educación</option>
                <option value="Entretenimiento" <?php echo  ($tipoGasto=='Entretenimiento')? 'selected' : '' ?>>Entretenimiento</option>
            </select><br>

            <label class="form-label" for="valorGasto">Valor del Gasto</label>
            <input class="form-control" type="number" name="valorGasto" id="ValorGasto" value="<?php echo "$ " . $valorGasto ?>"><br>

            <?php
                if($codigoGasto){
                    echo '<input class="btn btn-dark" type="submit" value="Modificar" name="submit2">';
                } 
                else {
                    echo '<input class="btn btn-primary" type="submit" value="Enviar" name="submit1">';
                }
            ?>
            <a class="btn btn-secondary" href="index.php">Cancelar</a>
        </form>
        <br>

    </div>

    
</body>
</html>