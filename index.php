<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (file_exists ("archivo.txt")) //Si el archivo existe cargo los clientes en la variable aClientes
{$strJson=file_get_contents("archivo.txt");
$aClientes=json_decode($strJson, true);} //LEE ARCHIVOS, va a almacenar todo el contenido en $strJson$aClientes=json_decode($strJson, true);} //json_decode recibe los parametros y nos devuelve el array que va almacenar en aclientes

else //Si el archivo no existe es porque no hay clientes, entonces es un array vacio
{$aClientes= array();}

if (isset($_GET ["id"])) //isset define la variable GET
{$id= $_GET ["id"];} //GEt accede a toda la query string
else { $id="";} //pregunto por una variable que no existe

if(isset($_GET["do"])&& $_GET["do"]== "eliminar")
{unset($aClientes[$id]);} //unsset elimina variables o posicion de un array



$strJson = json_encode($aClientes); //Convierto un aclientes en json

file_put_contents ("archivo.txt", $strJson); //almaceno el json en el archivo

//header ("Location: index.php"); //borro los datos de la querystring dejandola limpis


if($_POST)
   {$Nombre = $_POST["txtNombre"]; 
    $DNI = $_POST["txtDNI"];
    $Telefono = $_POST["txtTelefono"];
    $Correo = $_POST ["txtCorreo"];
    $Nombreimagen ="";
    

 $aClientes []= array ("Nombre" => $Nombre, "DNI" => $DNI, "Telefono" => $Telefono, "Correo" => $Correo, "Imagen" => $Nombreimagen); }

 //convertir el array de clientes es json
 $strJson1 = json_encode($aClientes);

 //almacenar en un archivo.txt en json
 file_put_contents("archivo.txt", $strJson);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMB Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
   <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
</head>
<body>
    <main class="container">
        <div class="row">
            <div class="col-12 py-5 text-center">
                <h1>Registro clientes</h1>

            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <form action="" method="POST" enctype="multipart/form-data" >
                    
                    <div>
                        <label for="">Nombre</label>
                        <input type="text" name="txtNombre" id="txtNombre" class="form-control" required value="<?php echo isset ($aClientes [$id])? $aClientes [$id]["Nombre"] :"";?>" >
                    </div>
                    
                    <div>
                        <label for="">DNI:</label>
                        <input type="text" name="txtDNI" id="txtDNI" class="form-control" required value= "<?php echo isset ($aClientes [$id])? $aClientes [$id]["DNI"] :"";?>"> 
                    </div>
                    <?php //isset va a preguntar si existe y sino existe muestro vacio ?>
                    <div>
                        <label for="">Telefono:</label>
                        <input type="text" name="txtTelefono" id="txtTelefono" class="form-control" required value="<?php echo isset ($aClientes [$id])? $aClientes [$id]["Telefono"] : "";?>">
                    </div>
                    <div>
                    <label for="">Correo:</label>
                    <input type="text" name="txtCorreo" id="txtCorreo" class="form-control" required value="<?php echo isset ($aClientes [$id])? $aClientes [$id]["Correo"]: "";?>">
                    </div>  
                    <div>
                        <label for="">Archivo adjunto</label>
                        <input type="file" name="archivo" id="archivo" accept=".jpg, .jpeg, .png">
                        <small class="d-block">Archivos admitidos: .jpg, .jpeg, .png</small>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="index.php" class="btn btn-danger my-2">Nuevo</a>
                    </div>
                </form>
            </div>
            
                <div class="col-6">
            <table class="table table-hover border" >
            <tr>
             <th>Nombre</th>
             <th>DNI</th>
             <th>Correo</th>
             <th>Acciones</th>
             <th>Imagen</th>
            </tr>
 
  <?php 


        foreach($aClientes as $pos => $cliente){ ?>
  <tr>
      <td><?php echo $cliente["Nombre"]; ?></td>
      <td><?php echo $cliente["DNI"]; ?></td>
      <td><?php echo $cliente["Correo"]; ?></td>
      <td>
       <a href="?id=<?php echo $pos; ?>&do=eliminar"> <i class="fa-solid fa-trash"></i></a>
       <a href="?id=<?php echo $pos; ?>"> <i class="fa-solid fa-pen"> </i></a> </td>
  </tr>
  <?php } ?>
         
        </table>
                </div>
            </div>
        
    </main>
</body>
</html>