<?php 

require "conexion.php";

//Variables Globales
$error = "";             
$hay_post = false;       
$nombre = "";           
$tipoGasto= "";              
$valorGasto = "";       
$codigoGasto = null;  

//Insertar un registro con el Boton Enviar
if(isset($_REQUEST['submit1'])){
    $hay_post = true;
    $nombre = isset($_REQUEST['txtNombre']) ? $_REQUEST['txtNombre'] : "";
    $tipoGasto = isset($_REQUEST['tipoGasto']) ? $_REQUEST['tipoGasto'] : "";
    $valorGasto = isset($_REQUEST['valorGasto']) ? $_REQUEST['valorGasto'] : "";

    if(!empty($nombre)){
        $nombre = preg_replace("/[^a-zA-ZáéíóúÁÉÍÓÚ ]/u","",$nombre);
    } else {
        $error .= "El nombre no puede estar vacío<br>";
    }

    if($tipoGasto == ""){
        $error .= "Seleccione un tipo de Gasto para poder continuar.<br>";
    }
    
    if($valorGasto==""){
        if (!is_numeric($valorGasto) || $valorGasto <= 0) {
            $error .= "Introduzca un valor numérico positivo de gasto<br>";
        }        
    }

    if(!$error){
        $stm_insertarRegistro = $conexion->prepare("insert into gastos(nombre, tipoGasto, valorGasto) values(:nombre, :tipoGasto, :valorGasto)");
        $stm_insertarRegistro->execute([':nombre'=>$nombre, ':tipoGasto'=>$tipoGasto, ':valorGasto'=>$valorGasto]);
        header("Location: index.php?mensaje=registroGastoFamiliarGuardado");
        exit();
    }
}

//Modificando un Registro
if(isset($_REQUEST['submit2'])){
    $hay_post = true;
    $nombre = isset($_REQUEST['txtNombre']) ? $_REQUEST['txtNombre'] : "";
    $tipoGasto = isset($_REQUEST['tipoGasto']) ? $_REQUEST['tipoGasto'] : "";
    $valorGasto = isset($_REQUEST['valorGasto']) ? $_REQUEST['valorGasto'] : "";

    if(!empty($nombre)){
        $nombre = preg_replace("/[^a-zA-ZáéíóúÁÉÍÓÚ ]/u","",$nombre);
    } else {
        $error .= "El nombre no puede estar vacío<br>";
    }

    if($tipoGasto == ""){
        $error .= "Seleccione un tipo de Gasto para poder continuar.<br>";
    }
    
    if($valorGasto==""){
        if (!is_numeric($valorGasto) || $valorGasto <= 0) {
            $error .= "Introduzca un valor numérico positivo de gasto<br>";
        }        
    }

    if(!$error){
        $stm_modificar = $conexion->prepare("update gastos set nombre = :nombre, tipoGasto = :tipoGasto, valorGasto = :valorGasto where codigoGasto = :id");
        $stm_modificar->execute([
            ':nombre'=>$nombre, 
            ':tipoGasto'=>$tipoGasto, 
            ':valorGasto'=>$valorGasto,
            ':id'=> $codigoGasto
        ]);
        header("Location: index.php?mensaje=registroModificado");
        exit();
    }

}

//Modificar o Elimar un Registro
if(isset($_REQUEST['id']) && isset($_REQUEST['op'])){
    $id = $_REQUEST['id'];
    $op = $_REQUEST['op'];
    
    if($op == 'm'){
        $stm_seleccionarRegistro = $conexion->prepare("select * from gastos where codigoGasto=:id");
        $stm_seleccionarRegistro->execute([':id'=>$id]);
        $resultado = $stm_seleccionarRegistro->fetch();
        $codigoGasto = $resultado['codigoGasto'];
        $nombre = $resultado['nombre'];
        $tipoGasto = $resultado['tipoGasto'];
        $valorGasto = $resultado['valorGasto'];
    }
    else if($op == 'e'){
        $stm_eliminar = $conexion->prepare("delete from gastos where codigoGasto = :id");
        $stm_eliminar->execute([':id'=>$id]);
        header("Location: index.php?mensaje=registroEliminado");
        exit();
    }
}

//




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
            <input class="form-control" type="number" name="valorGasto" id="valorGasto" step="0.01" min="0" value="<?php echo "$ " . $valorGasto ?>"><br>

            <?php
                if($codigoGasto){
                    echo '<input class="btn btn-dark" type="submit" value="Guardar" name="submit2">';
                } 
                else {
                    echo '<input class="btn btn-primary" type="submit" value="Enviar" name="submit1">';
                }
            ?>
            <a class="btn btn-secondary" href="index.php">Cancelar</a>
        </form>
        <br>

        <!-- VALIDACIONES DE ERRORES -->
        <?php if($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo "<p>$error</p>"; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>




    </div>
</body>
</html>