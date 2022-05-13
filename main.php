<?php 
session_start();
if (isset($_SESSION["log"]) && $_SESSION["log"]) {
    include("template/header.php");?>
            <div class="col-md-3">         
            </div>
            <div class="col-md-6">
                <div class="jumbotron text-center bg-info">
                    <h1 class="display-4 text-white">Bienvenidos <?=$_SESSION["nombre"]?> </h1>
                    <p class="lead">Portal para la administracion de tus alumnos</p>
                    <hr class="my-2">
                    <a href="alumnos.php" class="btn btn-primary">Administrar alumnos</a>
                </div>
            </div>
            <div class="col-md-3">         
            </div>
    <?php include("template/footer.php");
}else{
    echo " <h1>Error , no estas registrado</h1>";
} ?>