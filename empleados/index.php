<?php
//print_r($_POST);

$txtid = (isset($_POST['txtid']))?$_POST['txtid']:"";
$txtNombre = (isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtApellido = (isset($_POST['txtApellido']))?$_POST['txtApellido']:"";
$txtCorreo = (isset($_POST['txtCorreo']))?$_POST['txtCorreo']:"";
$txtTelefono = (isset($_POST['txtTelefono']))?$_POST['txtTelefono']:"";
$txtFoto = (isset($_FILES['txtFoto']["name"]))?$_FILES['txtFoto']["name"]:"";


$accion = (isset($_POST['accion']))?$_POST['accion']:"";

$accionAgregar = "";
$accionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;


include("../conexion/conexion.php");

switch ($accion) {
    case 'btnAgregar':

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

        echo $txtid;
        echo "presionaste agregar";
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
                unlink("../imagenes/".$empleado["foto"]);
            }
        }

            $insertar = $pdo->prepare("UPDATE empleados SET foto=:foto WHERE id=:id");

            $insertar->bindParam(':foto',$nombreArchivo);
            $insertar->bindParam(':id',$txtid);
            $insertar->execute();
        }

        

        header('Location: index.php');
        echo $txtid;
        echo "presionaste modificar";
        break;
    case 'btnEliminar':

        $insertar = $pdo->prepare("SELECT foto FROM empleados WHERE id=:id"); 

        $insertar->bindParam(':id',$txtid);
        $insertar->execute();
        $empleado = $insertar->fetch(PDO::FETCH_LAZY);
        print_r($empleado);

        if (isset($empleado['foto'])) {
            if (file_exists('../imagenes/'.$empleado['foto'])) {
                unlink("../imagenes/".$empleado["foto"]);
            }
        }
        
        $insertar = $pdo->prepare("DELETE FROM empleados WHERE id=:id"); 

        $insertar->bindParam(':id',$txtid);
        $insertar->execute();

        header('Location: index.php');
        echo $txtid;
        echo "presionaste Eliminar";
        break;
    case 'btnCancelar':
        # code...
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




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud php y MySQL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <!-- (label{lbl$:}+input[name="txt$" placeholder="" id="txt$" required]+br) --> <!-- abreviatura de codigo -->

            <!--EMPIEZA MODAL -->
            

<!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">

                
                <input type="hidden" name="txtid" value="<?php echo $txtid; ?>" placeholder="" id="txt1" required="">
                <br>
                

                <div class="form-group col-md-6">
                <label for="">Nombre(S):</label>
                <input type="text" class="form-control" name="txtNombre" value="<?php echo $txtNombre; ?>" placeholder="" id="txtNombre" required="">
                <br>
                </div>
                
                <div class="form-group col-md-6">
                <label for="">Apellido(s):</label>
                <input type="text" class="form-control" name="txtApellido" value="<?php echo $txtApellido; ?>" placeholder="" id="txt3" required="">
                <br>
                </div>

                <div class="form-group col-md-12">
                <label for="">Correo:</label>
                <input type="email" class="form-control" name="txtCorreo" value="<?php echo $txtCorreo; ?>" placeholder="" id="txt4" required="">
                <br>
                </div>

                <div class="form-group col-md-4">
                <label for="">Telefono:</label>
                <input type="text" class="form-control" name="txtTelefono" value="<?php echo $txtTelefono; ?>" placeholder="" id="txt5" required="">
                <br>
                </div>

                <div class="form-group col-md-12">
                <label for="">Foto:</label>
                <input type="file" class="form-control" accept="image/*" value="<?php echo $txtFoto; ?>" name="txtFoto" placeholder="" id="txt6" >
                <br>
                </div>

                </div>
            </div>
            <div class="modal-footer">
                <button value="btnAgregar" class="btn btn-success" type="submit" name="accion">Agregar</button>
                <button value="btnModificar" class="btn btn-warning" type="submit" name="accion">Modificar</button>
                <button value="btnEliminar" class="btn btn-danger" type="submit" name="accion">Eliminar</button>
                <button value="btnCancelar" class="btn btn-primary" type="submit" name="accion">Cancelar</button>

            </div>
        </div>
        </div>
</div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Agregar
            </button>
            
            

            
        </form>
        <!-- creamos la tabla y llamamos los datos -->
        <div class="row">
            <table class="table">
                <thead> <!-- cabecera de la tabla -->
                    <tr>
                        <th>Foto</th>
                        <th>Nombre Completo</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <?php foreach($listaEmpleados as $empleado){ ?>
                    <tr>
                        <td><img class="img-thumbnail" width="100px" src="../imagenes/<?php echo $empleado['foto'];?>"/></td>
                        <td><?php echo $empleado['nombre'];?> <?php echo $empleado['apellido'];?></td>
                        <td><?php echo $empleado['correo'];?></td>
                        <td><?php echo $empleado['telefono'];?></td>

                        <!-- cuando seleccionemos se enviaran los datos -->
                        <td>
                        <form action="" method="post" ectype="multipart/form-data">
                        <input type="hidden" name="txtid" value="<?php echo $empleado['id']; ?>">
                        <input type="hidden" name="txtNombre" value="<?php echo $empleado['nombre']; ?>">
                        <input type="hidden" name="txtApellido" value="<?php echo $empleado['apellido']; ?>">
                        <input type="hidden" name="txtCorreo" value="<?php echo $empleado['correo']; ?>">
                        <input type="hidden" name="txtTelefono" value="<?php echo $empleado['telefono']; ?>">
                        <input type="hidden" name="txtFoto" value="<?php echo $empleado['foto']; ?>">

                        <input type="submit" value="Seleccionar" name="accion">
                        <button value="btnEliminar" type="submit" name="accion">Eliminar</button>
                        
                        
                        </form>
                        
                        
                        </td>
                    </tr>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
            
               <?php } ?>
            </table>
        </div>
    </div>







<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    
</body>
</html>