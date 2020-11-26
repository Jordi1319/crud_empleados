<?php
//print_r($_POST);

$txtid = (isset($_POST['txtid']))?$_POST['txtid']:"";
$txtNombre = (isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtApellido = (isset($_POST['txtApellido']))?$_POST['txtApellido']:"";
$txtCorreo = (isset($_POST['txtCorreo']))?$_POST['txtCorreo']:"";
$txtTelefono = (isset($_POST['txtTelefono']))?$_POST['txtTelefono']:"";
$txtFoto = (isset($_FILES['txtFoto']["name"]))?$_FILES['txtFoto']["name"]:"";


$accion = (isset($_POST['accion']))?$_POST['accion']:"";

$error = array();

/* activacion de botones */
$accionAgregar = "";
$accionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;


include("../conexion/conexion.php");

switch ($accion) {
    case 'btnAgregar':

        /* validacion */
        if ($txtNombre=="") {
            $error['nombre'] = "Escribe el nombre";
        }
        if ($txtApellido=="") {
            $error['apellido'] = "Escribe el apellido";
        }
        if ($txtCorreo=="") {
            $error['correo'] = "Correo no valido";
        }
        if ($txtTelefono=="") {
            $error['telefono'] = "Digita tu numero de contacto";
        }
        if (count($error) > 0) {
            $mostrarModal = true;
        break;
        }

        $insertar = $pdo->prepare("INSERT INTO empleados(nombre,apellido,correo,telefono,foto) /* Creamos un objeto  */
        VALUES(:nombre,:apellido,:correo,:telefono,:foto)");

        $insertar->bindParam(':nombre',$txtNombre);
        $insertar->bindParam(':apellido',$txtApellido);
        $insertar->bindParam(':correo',$txtCorreo);
        $insertar->bindParam(':telefono',$txtTelefono);

        $fecha = new DateTime();
        $nombreArchivo = ($txtFoto!="")?$fecha->getTimestamp()."_".$_FILES["txtFoto"]["name"]:"cheems.png";

        $tmpFoto = $_FILES["txtFoto"]["tmp_name"];

        if ($tmpFoto!="") {
            move_uploaded_file($tmpFoto,"../imagenes/".$nombreArchivo);
        }
        $insertar->bindParam(':foto',$nombreArchivo);
        $insertar->execute();

        header('Location: index.php');

        break;

    case 'btnModificar':
        
        $insertar = $pdo->prepare("UPDATE empleados SET 
        nombre=:nombre,
        apellido=:apellido,
        correo=:correo,
        telefono=:telefono WHERE id=:id"); /* Creamos un objeto  */

        $insertar->bindParam(':nombre',$txtNombre);
        $insertar->bindParam(':apellido',$txtApellido);
        $insertar->bindParam(':correo',$txtCorreo);
        $insertar->bindParam(':telefono',$txtTelefono);
        $insertar->bindParam(':id',$txtid);
        $insertar->execute();

        $fecha = new DateTime();
        $nombreArchivo = ($txtFoto!="")?$fecha->getTimestamp()."_".$_FILES["txtFoto"]["name"]:"cheems.png";

        $tmpFoto = $_FILES["txtFoto"]["tmp_name"];

        if ($tmpFoto!="") {
            move_uploaded_file($tmpFoto,"../imagenes/".$nombreArchivo);

            $insertar = $pdo->prepare("SELECT foto FROM empleados WHERE id=:id"); 

            $insertar->bindParam(':id',$txtid);
            $insertar->execute();
            $empleado = $insertar->fetch(PDO::FETCH_LAZY);
            print_r($empleado);

        if (isset($empleado["foto"])) {
            if (file_exists("../imagenes/".$empleado["foto"])) {

                if ($empleado['foto']!="cheems.png") {
                    unlink("../imagenes/".$empleado["foto"]);
                }
            }
        }

            $insertar = $pdo->prepare("UPDATE empleados SET foto=:foto WHERE id=:id");

            $insertar->bindParam(':foto',$nombreArchivo);
            $insertar->bindParam(':id',$txtid);
            $insertar->execute();
        }

        

        header('Location: index.php');
        
        break;
    case 'btnEliminar':

        $insertar = $pdo->prepare("SELECT foto FROM empleados WHERE id=:id"); 

        $insertar->bindParam(':id',$txtid);
        $insertar->execute();
        $empleado = $insertar->fetch(PDO::FETCH_LAZY);
        print_r($empleado);

        if (isset($empleado['foto'])&&($empleado['foto']!="cheems.png")) {
            if (file_exists('../imagenes/'.$empleado['foto'])) {
                unlink("../imagenes/".$empleado["foto"]);
            }
        }
        
        $insertar = $pdo->prepare("DELETE FROM empleados WHERE id=:id"); 

        $insertar->bindParam(':id',$txtid);
        $insertar->execute();

        header('Location: index.php');
       
        break;
    case 'btnCancelar':
        header('Location: index.php');
        break;

    case 'Seleccionar':
        $accionAgregar = "disabled";
        $accionModificar = $accionEliminar = $accionCancelar = "";
        $mostrarModal=true;

        $insertar = $pdo->prepare("SELECT * FROM empleados WHERE id=:id"); 
        $insertar->bindParam(':id',$txtid);
        $insertar->execute();
        $empleado = $insertar->fetch(PDO::FETCH_LAZY);

        $txtNombre = $empleado['nombre'];
        $txtApellido = $empleado['apellido'];
        $txtCorreo = $empleado['correo'];
        $txtTelefono = $empleado['telefono'];
        $txtFoto = $empleado['foto'];


        break;
    
    default:
        # code...
        break;
}
    $insertar = $pdo->prepare("SELECT * FROM `empleados` WHERE 1");
    $insertar->execute();
    $listaEmpleados=$insertar->fetchAll(PDO::FETCH_ASSOC); /* devolver o asociar informacion */

    //print_r($listaEmpleados);

?>