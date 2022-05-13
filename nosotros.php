<?php 
session_start();
if (isset($_SESSION["log"]) && $_SESSION["log"]) {
     include("template/header.php");?>
           <div class="col-md-4">
                <img class="img-thumbnail rounded mx-auto d-block" src="img/logo.jpg" alt="logo">
           </div>
           <div class="col-md-4">
               <div class="card">
                   <div class="card-header bg-info">
                       <strong>
                           ¿Quienes somos?
                       </strong>
                   </div>
                   <div class="card-body">
                       <h5 class="card-title">Aqui en "Empresa" </h5>
                       <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit maxime, officiis ea quo sapiente iure ab sint voluptatem tenetur earum non minus sit harum officia culpa optio expedita vitae laudantiume doloremque fugiat libero quisquam placeat perspiciatis. Quam quibusdam ut dolor sint voluptatem tenetur earum nonsint voluptatem tenetur earum non dolorum!</p>
                   </div>
               </div>
           </div>
           <div class="col-md-4">
           <div class="card">
                   <div class="card-header bg-success">
                        <strong>
                           ¿Quienes somos?
                        </strong>
                   </div>
                   <div class="card-body">
                       <h5 class="card-title">Aqui en "Empresa" </h5>
                       <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit maxime, officiis ea quo sapiente iure ab sint voluptatem tenetur earum non minus sit harum officia culpa optio expedita vitae laudantiume doloremque fugiat libero quisquam placeat perspiciatis. Quam quibusdam ut dolor sint voluptatem tenetur earum nonsint voluptatem tenetur earum non dolorum!</p>
                   </div>
               </div>
           </div>
<?php include("template/footer.php");
}else{
    echo " <h1>Error , no estas registrado</h1>";
} ?>