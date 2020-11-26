<?php
require 'empleados.php';

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
                <input type="text" class="form-control <?php echo(isset($error['nombre']))?"is-invalid":""; ?>" name="txtNombre" value="<?php echo $txtNombre; ?>" placeholder="" id="txtNombre" required="">
                <div class="invalid-feedback">
                <?php echo(isset($error['nombre']))?$error['nombre']:""; ?>
                </div>
                <br>
                </div>
                
                <div class="form-group col-md-6">
                <label for="">Apellido(s):</label>
                <input type="text" class="form-control <?php echo(isset($error['apellido']))?"is-invalid":""; ?>" name="txtApellido" value="<?php echo $txtApellido; ?>" placeholder="" id="txt3" required="">
                <div class="invalid-feedback">
                <?php echo(isset($error['apellido']))?$error['apellido']:""; ?>
                </div>
                <br>
                </div>

                <div class="form-group col-md-12">
                <label for="">Correo:</label>
                <input type="email" class="form-control <?php echo(isset($error['correo']))?"is-invalid":""; ?>" name="txtCorreo" value="<?php echo $txtCorreo; ?>" placeholder="" id="txt4" required="">
                <div class="invalid-feedback">
                <?php echo(isset($error['correo']))?$error['correo']:""; ?>
                </div>
                <br>
                </div>

                <div class="form-group col-md-4">
                <label for="">Telefono:</label>
                <input type="text" class="form-control <?php echo(isset($error['telefono']))?"is-invalid":""; ?>" name="txtTelefono" value="<?php echo $txtTelefono; ?>" placeholder="" id="txt5" required="">
                <div class="invalid-feedback">
                <?php echo(isset($error['telefono']))?$error['telefono']:""; ?>
                </div>
                <br>
                </div>

                <div class="form-group col-md-12">
                <label for="">Foto:</label>
                <?php if ($txtFoto!="") { ?>
                    </br>
                        <img src="../imagenes/<?php echo $txtFoto; ?>" alt="" class="img-thumbnail rounded mx-auto d-block" width="100px">
                    </br>
                    </br>
                <?php } ?>

                <input type="file" class="form-control" accept="image/*" value="<?php echo $txtFoto; ?>" name="txtFoto" placeholder="" id="txt6" >
                <br>
                </div>

                </div>
            </div>
            <div class="modal-footer">
                <button value="btnAgregar" <?php echo $accionAgregar ?> class="btn btn-success" type="submit" name="accion">Agregar</button>
                <button value="btnModificar" <?php echo $accionModificar ?> class="btn btn-warning" type="submit" name="accion">Modificar</button>
                <button value="btnEliminar" onclick="return Confirmar('¿Esta deguro que desea eliminar el registro?');" <?php echo $accionEliminar ?> class="btn btn-danger" type="submit" name="accion">Eliminar</button>
                <button value="btnCancelar" <?php echo $accionCancelar ?> class="btn btn-primary" type="submit" name="accion">Cancelar</button>

            </div>
        </div>
        </div>
</div>
<br>
<br>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Agregar
            </button>
            <br>
            <br>
            
            

            
        </form>
        <!-- creamos la tabla y llamamos los datos -->
        <div class="row">
            <table class="table table-hover table-bordered">
                <thead class="thead-dark"> <!-- cabecera de la tabla -->
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

                        <input type="submit" value="Seleccionar" class="btn btn-info" name="accion">
                        <button value="btnEliminar" onclick="return Confirmar('¿Esta deguro que desea eliminar el registro?');" type="submit" class="btn btn-danger" name="accion">Eliminar</button>

             
                        
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
<?php if ($mostrarModal) {?>
            <script>$('#exampleModal').modal('show');</script>
                      
<?php } ?> 

<script>
    function Confirmar(Mensaje) {
        return (confirm(Mensaje))?true:false;
    }
</script>
</body>
</html>