<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
  <div class="container ">
      <div class="row">
          <div class="col-md-4">
              
          </div>
          <div class="col-md-4">
          <br><br><br>
          <div class="card">
              <div class="card-header bg-info text-white">
                  Login
              </div>
              <div class="card-body">
               <div id="msj"></div>
                 <form id="fm_login"> 
                     <div class="form-group">
                       <label for="fm_correo">Correo:</label>
                       <input type="text" required name="fm_correo" id="fm_correo" class="form-control" placeholder="Ingresa tu usuario" aria-describedby="helpId">
                     </div>
                     <div class="form-group">
                         <label for="fm_contrasenia">Contraseña:</label>
                         <input id="fm_contrasenia" required class="form-control" type="password" name="fm_contrasenia" placeholder="*****">
                     </div>
                     <button type="submit" class="btn btn-primary" id="fm_btn">Entrar</button>
                 </form>
                 <p class="text-center">Accesos: test@test.com / 12345678</p>
                 
              </div>
          </div>


          </div>
          
      </div>
  </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        $(function () {
             $("#fm_contrasenia").keypress(function (e) { 
                if (e.which === 13) {
                    validarLogin();
                }
            }); 

            $( "#fm_login" ).submit(function( event ) {
                event.preventDefault();
                validarLogin();
            });
        });


        function validarLogin(){
            var c  = $("#fm_correo").val();
            var p  = $("#fm_contrasenia").val();
            var datos = {"correo": c, "pass": p};
				console.log(datos);
				$.ajax({
					data: JSON.stringify(datos),
					type: "POST",
					dataType: "json",
					contentType: 'application/json',
					headers: {
						'Accept': '*/*',
						'X-Requested-With': 'XMLHttpRequest',
						'Cache-Control': 'no-cache'
					},
					url: "servicios/srv_validar_login.php",
					cache: false,
				})
				.done(function(data, textStatus, jqXHR) {				
					console.log(data);
                    if (data.code == 1) {
                        $("#msj").empty();
                        $("#msj").append('<div class="alert alert-success" role="alert"><strong>'+data.mensaje+'</strong></div>');
                        setTimeout(function(){ location.href=data.url; }, 1500);
                    }else{
                        $("#msj").empty();
                        $("#msj").append('<div class="alert alert-danger" role="alert"><strong>'+data.mensaje+'</strong></div>');
                    }
				})
				.always(function() {
					console.log("finalizo validarLogin");
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					console.log("validarLogin ERROR: " + textStatus);
				});
        }
    </script>
    </body>
</html>