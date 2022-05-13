<?php 
session_start();
if (isset($_SESSION["log"]) && $_SESSION["log"]) {
    include("template/header.php");?>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-info text-center text-white">
                        Datos de Alumno
                    </div>
                    <div class="card-body">
                        <form id="form_a" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="a_id" name="a_id">
                            <div class="form-group">
                                <label for="a_name">Nombres:</label>
                                <input id="a_name" class="form-control" type="text" name="a_name">
                            </div>
                            <div class="form-group">
                                <label for="a_last">Apellidos:</label>
                                <input id="a_last" class="form-control" type="text" name="a_last">
                            </div>
                            <div class="form-group">
                                <label for="a_date">Fecha de Nacimiento:</label>
                                <input id="a_date" class="form-control" type="date" name="a_date">
                            </div>
                            <div class="form-group">
                                <label for="my-input">Correo:</label>
                                <input id="a_mail" class="form-control" type="email" name="a_mail">
                            </div>
                            <div class="btn-group" role="group" aria-label="">
                                <button class="btn btn-success " id="a_add" type="button">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> añadir
                                </button> <br>
                                <button class="btn btn-info " id="a_upd" type="button">
                                    <i class="fa fa-spinner" aria-hidden="true"></i> modificar
                                </button>
                                <button class="btn btn-warning " id="a_can" type="button">
                                    <i class="fa-solid fa-ban"></i> cancelar
                                </button>
                            </div>
                            <hr>
                            <div id="mjs_error">
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
            <div class="col-md-8">
                <table class="table table-striped table-inverse text-center">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Nombres Completo</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody id="a_tbody">
                            
                        </tbody>
                        <tfoot>
                            <th>Nombres Completo</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tfoot>
                </table>
            </div>
<?php include("template/footer.php"); ?>
<script>
    $(function () {
        $("#a_upd").hide();
        generarTAlumnos();

        $("#a_can").click(function() {
                limpiarForm();
                $("#a_upd").hide();
                $("#a_add").show();
        });
        $("#a_add").click(function() {
                altaAlumno();
        });
        $("#a_upd").click(function() {
                modificaAlumno();
        });
    });
    function generarTAlumnos(){
        var data = {"tipo":"consulta"};
        $('#a_tbody').empty();
            $.ajax({
					data: JSON.stringify(data),
					type: "POST",
					dataType: "json",
					contentType: 'application/json',
					headers: {
						'Accept': '*/*',
						'X-Requested-With': 'XMLHttpRequest',
						'Cache-Control': 'no-cache'
					},
					url: "servicios/srv_obtener_alumnos.php",
					cache: false,
				})
				.done(function(data, textStatus, jqXHR) {				
					console.log(data);
                    var code = data.code;
                    if (code == 1) {
                        //console.log(data.mensaje);
                        $.each(data.data, function(index, value) {
                            //console.log(value);
                            $('#a_tbody').append('<tr><td scope="row">'+value.nombres+' '+value.apellidos+'</td><td>'+value.correo+'</td><td><button type="button" class="btn btn-info a_select" data-id="'+value.id_alumno+'"><i class="fa-solid fa-arrow-pointer"></i>Seleccionar</button><button type="button" class="btn btn-danger a_delete" data-id="'+value.id_alumno+'"><i class="fa-solid fa-trash-can"></i></i>Eliminar</button></td></tr>');
                        });
                        $(".a_select").click(function() {
                            var dataId = $(this).attr("data-id");
                            //console.log("select:"+dataId);
                            selectAlumno(dataId);
                        });
                        
                        $(".a_delete").click(function() {
                            var dataId = $(this).attr("data-id");
                            //console.log("delete:"+dataId);
                            deleteAlumno(dataId);
                        });
                    }else{
                        console.log(data.mensaje);
                    }
				})
				.always(function() {
					console.log("finalizo generarTAlumnos");
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					console.log("generarTAlumnos ERROR: " + textStatus);
				});

    }
    function limpiarForm(){
        $("#a_id").val("");
        $("#a_name").val("");
        $("#a_last").val("");
        $("#a_date").val("");
        $("#a_mail").val("");
    }
    function altaAlumno(){
        var datos = {};
            datos["nombres"] = $("#a_name").val();
            datos["apellidos"] = $("#a_last").val();
            datos["fecha"] = $("#a_date").val();
            datos["correo"] = $("#a_mail").val();
        console.log(datos);
        if ( !datos["nombres"].trim() || !datos["apellidos"].trim() || !datos["fecha"].trim()  || !datos["correo"].trim() ) {
            $('#mjs_error').empty();
            $('#mjs_error').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span></button> <strong>Datos imcompletos!</strong>. </div>')
        }else{
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
					url: "servicios/srv_guardar_alumnos.php",
					cache: false,
				})
				.done(function(data, textStatus, jqXHR) {				
					console.log(data);
                    var code = data.code;
                    if (code == 1) {
                        generarTAlumnos();
                        limpiarForm();
                        $('#mjs_error').empty();
                        $('#mjs_error').append('<div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span></button> <strong>'+data.mensaje+'!</strong>. </div>')
                    }else{
                        $('#mjs_error').empty();
                        $('#mjs_error').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span></button> <strong>'+data.mensaje+'!</strong>. </div>')

                    }
				})
				.always(function() {
					console.log("finalizo altaAlumno");
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					console.log("altaAlumno ERROR: " + textStatus);
				});
        }
    }
    function modificaAlumno(){
        var datos = {};
            datos["id"] = $("#a_id").val();
            datos["nombres"] = $("#a_name").val();
            datos["apellidos"] = $("#a_last").val();
            datos["fecha"] = $("#a_date").val();
            datos["correo"] = $("#a_mail").val();
        console.log(datos);
        if ( !datos["id"].trim() || !datos["nombres"].trim() || !datos["apellidos"].trim() || !datos["fecha"].trim()  || !datos["correo"].trim() ) {
            $('#mjs_error').empty();
            $('#mjs_error').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span></button> <strong>Datos imcompletos!</strong>. </div>')
        }else{
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
					url: "servicios/srv_modificar_alumno.php",
					cache: false,
				})
				.done(function(data, textStatus, jqXHR) {				
					console.log(data);
                    var code = data.code;
                    if (code == 1) {
                        generarTAlumnos();
                        limpiarForm();
                        $("#a_upd").hide();
                        $("#a_add").show();
                        $('#mjs_error').empty();
                        $('#mjs_error').append('<div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span></button> <strong>'+data.mensaje+'!</strong>. </div>')
                    }else{
                        $('#mjs_error').empty();
                        $('#mjs_error').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span></button> <strong>'+data.mensaje+'!</strong>. </div>')
                    }
				})
				.always(function() {
					console.log("finalizo altaAlumno");
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					console.log("altaAlumno ERROR: " + textStatus);
				});
        }
    }
    function selectAlumno(id){
        var data = {"id":id};
            $.ajax({
					data: JSON.stringify(data),
					type: "POST",
					dataType: "json",
					contentType: 'application/json',
					headers: {
						'Accept': '*/*',
						'X-Requested-With': 'XMLHttpRequest',
						'Cache-Control': 'no-cache'
					},
					url: "servicios/srv_obtener_alumno.php",
					cache: false,
				})
				.done(function(data, textStatus, jqXHR) {				
					console.log(data);
                    var code = data.code;
                    if (code == 1) {
                        $("#a_upd").show();
                        $("#a_add").hide();
                        var datos = data.data;
                        $("#a_id").val(datos.id_alumno);
                        $("#a_name").val(datos.nombres);
                        $("#a_last").val(datos.apellidos);
                        $("#a_date").val(datos.fecha_nacimiento);
                        $("#a_mail").val(datos.correo);
                    }
                    
				})
				.always(function() {
					console.log("finalizo selectAlumno");
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					console.log("selectAlumno ERROR: " + textStatus);
				});
    }

    function deleteAlumno(id){
        var data = {"id":id};
            $.ajax({
					data: JSON.stringify(data),
					type: "POST",
					dataType: "json",
					contentType: 'application/json',
					headers: {
						'Accept': '*/*',
						'X-Requested-With': 'XMLHttpRequest',
						'Cache-Control': 'no-cache'
					},
					url: "servicios/srv_eliminar_alumno.php",
					cache: false,
				})
				.done(function(data, textStatus, jqXHR) {				
					console.log(data);
                    var code = data.code;
                    if (code == 1) {
                        generarTAlumnos();
                        $('#mjs_error').empty();
                        $('#mjs_error').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span></button> <strong>'+data.mensaje+'!</strong>. </div>')
                    }else{
                        $('#mjs_error').empty();
                        $('#mjs_error').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span></button> <strong>'+data.mensaje+'!</strong>. </div>')
                    }
                    
				})
				.always(function() {
					console.log("finalizo deleteAlumno");
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					console.log("deleteAlumno ERROR: " + textStatus);
				});
    }
</script>

<?php }else{ echo " <h1>Error , no estas registrado</h1>";} ?>