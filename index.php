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
{unset($aClientes[$id]); //unsset elimina variables o posicion de un array

 //almaceno el json en el archivo
 //convertir el array de clientes es json
 $strJson = json_encode($aClientes);

 //almacenar en un archivo.txt en json
 file_put_contents("archivo.txt", $strJson);

header ("Location: index.php");} //borro los datos de la querystring dejandola limpia


if($_POST)
   {$nombre = $_POST["txtnombre"]; 
    $dni = $_POST["txtdni"];
    $telefono = $_POST["txttelefono"];
    $correo = $_POST ["txtcorreo"];
    $nombreimagen ="";


    if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) 
       
        {$nombrealeatorio = date("Ymdhmsi") . rand(1000, 2000); //2022/05/17dfecha18:42:37:10:10hora
        $archivo_tmp = $_FILES["archivo"]["tmp_name"]; //C:\tmp\ghjuy6788765
        $extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
        if($extension == "jpg" || $extension == "png" || $extension == "jpeg")
            {$nombreimagen = "$nombrealeatorio.$extension";
            move_uploaded_file($archivo_tmp, "imagenes/$nombreimagen");}}
       
      
    
        // Si no se subio una imagen y estoy editando conservar en $nombreimagen el nombre de la imagen anterior que esta asociada al cliente que estamos editando
        if($id >= 0)
         {if ($_FILES["archivo"]["error"] !== UPLOAD_ERR_OK) 
            {$nombreimagen = $aClientes[$id]["imagen"];}
          else 
            //Si viene una imagen Y hay una imagen anterior, eliminar la anterior
            {if(file_exists("imagenes/". $aClientes[$id]["imagen"]))
                {unlink("imagenes/". $aClientes[$id]["imagen"]);}} //unlink elimina la imagen dentro de la carpeta de imaganes
            
               
         
         
      $aClientes[$id]= array ("nombre" => $nombre, "dni" => $dni, "telefono" => $telefono, "correo" => $correo, "imagen" => $nombreimagen); }
      //id si estoy editando
else {$aClientes[]= array ("nombre" => $nombre, "dni" => $dni, "telefono" => $telefono, "correo" => $correo, "imagen" => $nombreimagen); }
}//si quiero declarar un cliente 

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
                        <input type="text" name="txtnombre" id="txtnombre" class="form-control" required value="<?php echo isset ($aClientes [$id])? $aClientes [$id]["nombre"] :"";?>" >
                    </div>
                    
                    <div>
                        <label for="">DNI</label>
                        <input type="text" name="txtdni" id="txtdni" class="form-control" required value= "<?php echo isset ($aClientes[$id])? $aClientes[$id]["dni"] :"";?>"> 
                    </div>
                    <?php //isset va a preguntar si existe y sino existe muestro vacio ?>
                    <div>
                        <label for="">Telefono</label>
                        <input type="text" name="txttelefono" id="txttelefono" class="form-control" required value="<?php echo isset ($aClientes[$id])? $aClientes[$id]["telefono"] : "";?>">
                    </div>
                    <div>
                    <label for="">Correo</label>
                    <input type="text" name="txtcorreo" id="txtcorreo" class="form-control" required value="<?php echo isset ($aClientes[$id])? $aClientes[$id]["correo"]: "";?>">
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
 
  <?php   foreach($aClientes as $pos=> $cliente){ ?>
  <tr>
      
      <td><?php echo $cliente["nombre"]; ?></td>
      <td><?php echo $cliente["dni"]; ?></td>
      <td><?php echo $cliente["correo"]; ?></td>
      <td>
       <a href="?id=<?php echo $pos; ?>&do=eliminar"><i class="fa-solid fa-trash"></i></a>
       <a href="?id=<?php echo $pos; ?>"> <i class="fa-solid fa-pen"> </i></a> </td>
       <td><img src="imagenes/<?php echo $cliente["imagen"]; ?>" class="img-thumbnail"></td>
      
  </tr>
  <?php } ?>
         
        </table>
                </div>
            </div>
        
    </main>
</body>
</html>