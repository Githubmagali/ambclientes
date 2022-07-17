<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (file_exists("archivo.txt"))
{$strJson=file_get_contents("archivo.txt");
$aClientes=json_decode($strJson,true);}
else
{$aClientes=array();}

if (isset($_GET ["id"])) //isset define la variable GET
{$id= $_GET ["id"];} //GEt accede a toda la query string
else { $id="";} //pregunto por una variable que no existe


if(isset($_GET["do"])&& $_GET["do"]=="eliminar")
{unset($aClientes[$id]);

$strJson=json_encode($aClientes);
file_put_contents("archivo.txt", $strJson);

header ("location:index.php");
}

if($_POST)
{$nombre=$_POST["txtNombre"];
$apellido=$_POST["txtApellido"];
$dni=$_POST["txtDni"];
$imagen="";

if($_FILES ["archivo"]["error"]=== UPLOAD_ERR_OK)
{$nombreAleatorio = date("Ymdhmsi") . rand(1000, 2000); //2022/05/17dfecha18:42:37:10:10hora
    $archivo_tmp = $_FILES["archivo"]["tmp_name"]; //C:\tmp\ghjuy6788765
    $extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
    if($extension == "jpg" || $extension == "png" || $extension == "jpeg")
        {$nombreImagen = "$nombreAleatorio.$extension";
        move_uploaded_file($archivo_tmp, "imagenes/$nombreImagen");}}
   
        if($id>=0)
        {if ($_FILES ["archivo"]["error"]== UPLOAD_ERR_OK)
        {$nombreImagen=$aClientes[$id]["imagen"];}
        else
        {if(file_exists("imagenes/". $aClientes[$id]["imagen"]))
        {unlink ("imagenes/". $aClientes[$id]["imagen"]);}}

        $aClientes[$id]=array(
            "nombre"=>$nombre,
            "apellido"=>$apellido,
            "dni"=>$dni,
            "imagen"=>$imagen
        );}
        else
        {$aClientes[]= array ("nombre" => $nombre, 
            "apellido" =>$apellido,
            "dni" => $dni, 
              "imagen" => $nombreImagen); }
        }//si quiero declarar un cliente 
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
   <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
        </head>
        <body>
            <main class="container">
                <div class="row">
                    <div class="text-center py-5 col-12">
                        <h1>Prueba</h1>
                    </div>
    </div>
                  
                        <form action=""method="post"enctype="multipart/form-data">
                        <div class="row">
                            <div class=col-3>
                                <label for="">Nombre</label>
                                <input type="text" name="txtNombre"id="txtNombre" class="form-control"required value="<?php echo isset ($aClientes[$id])? $aClientes[$id]["nombre"]: ""; ?>">
                            </div>
                            <div class="col-3">
                                <label for="">Apellido</label>
                                <input type="text" name="txtApellido"id="txtApellido" class="form-control"required value=" <?php echo isset ($aClientes[$id])? $aClientes[$id]["apellido"]:"";?>">
                            </div>
                            <div class="col-3">
                                <label for="">DNI</label>
                               <input type="text" name="txtDni"id="txtDni"class="form-control">
                            </div>
                            <div class=col-3>
                           <label for="">Archivo adjunto</label>
                            <input type="file" name="archivo" id="archivo" accept=".jpg, .jpeg, .png">
                            <small class="d-block">Archivos admitidos: .jpg, .jpeg, .png</small>
                    </div>
                    <div class=py-5>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="index.php" class="btn btn-warning my-2">Nuevo</a>
                    </div>
                        </form>
                    </div>
                   <div class="col-12">
                    <table class="table table-hover border">
                        <tr>
                            <td>Nombre</td>
                            <td>Apellido</td>
                            <td>DNI</td>
                            <td>imagen</td>
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