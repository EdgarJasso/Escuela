<?php 
session_start();
if (isset($_SESSION["log"]) && $_SESSION["log"]) {
    include("template/header.php");?>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-center text-white">
                        Datos de Historial
                    </div>
                    <div class="card-body">
                        <form id="form_a" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="h_id" name="h_id">
                            <div class="form-group">
                                <label for="h_alumno">Alumno:</label>
                                <select id="h_alumno" class="form-control" name="h_alumno">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="h_plan">Plan de estudios:</label>
                                <select id="h_plan" class="form-control" name="h_plan">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="h_pro">Promedio:</label>
                                <input id="h_pro" class="form-control" type="text" name="h_pro">
                            </div>
                            <div class="btn-group" role="group" aria-label="">
                                <button class="btn btn-success " id="h_add" type="button">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> añadir
                                </button> <br>
                                <button class="btn btn-info " id="h_upd" type="button">
                                    <i class="fa fa-spinner" aria-hidden="true"></i> modificar
                                </button>
                                <button class="btn btn-warning " id="h_can" type="button">
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
                            <th>ID Alumno</th>
                            <th>ID Plan Estudio</th>
                            <th>Promedio</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody id="h_tbody">
                            
                        </tbody>
                        <tfoot>
                            <th>ID Alumno</th>
                            <th>ID Plan Estudio</th>
                            <th>Promedio</th>
                            <th>Acciones</th>
                        </tfoot>
                </table>
            </div>
<?php include("template/footer.php"); ?>
<script>
    $(function () {
        $("#h_upd").hide();
        generarTHisorial();
        generarSAlumnos();
        generarSPlanes();

        $("#h_can").click(function() {
                limpiarForm();
                $("#h_upd").hide();
                $("#h_add").show();
        });
        $("#h_add").click(function() {
            altaHistorial();
        });
        $("#h_upd").click(function() {
                modificaAlumno();
        });
    });
    function generarTHisorial(){
        var data = {"tipo":"consulta"};
        $('#h_tbody').empty();
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
					url: "servicios/srv_obtener_historial.php",
					cache: false,
				})
				.done(function(data, textStatus, jqXHR) {				
					console.log(data);
                    var code = data.code;
                    if (code == 1) {
                        //console.log(data.mensaje);
                        $.each(data.data, function(index, value) {
                            //console.log(value);
                            $('#h_tbody').append('<tr><td scope="row">'+value.id_alumno+'</td><td>'+value.id_plan_estudio+'</td><td>'+value.promedio_general+'</td><td><button type="button" class="btn btn-info h_select" data-id="'+value.id_historial_academico+'" disabled><i class="fa-solid fa-arrow-pointer"></i>Seleccionar</button><button type="button" class="btn btn-danger h_delete" data-id="'+value.id_historial_academico+'"><i class="fa-solid fa-trash-can"></i></i>Eliminar</button></td></tr>');
                        });
                        $(".h_select").click(function() {
                            var dataId = $(this).attr("data-id");
                            //console.log("select:"+dataId);
                            selectAlumno(dataId);
                        });
                        
                        $(".h_delete").click(function() {
                            var dataId = $(this).attr("data-id");
                            //console.log("delete:"+dataId);
                            deleteHistorial(dataId);
                        });
                    }else{
                        console.log(data.mensaje);
                    }
				})
				.always(function() {
					console.log("finalizo generarTHisorial");
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					console.log("generarTHisorial ERROR: " + textStatus);
				});

    }
    function generarSAlumnos(){
        var data = {"tipo":"consulta"};
        $('#h_tbody').empty();
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
                            $('#h_alumno').append('<option value="'+value.id_alumno+'">'+value.id_alumno+'-'+value.nombres+' '+value.apellidos+'</option>');
                        });
                    }else{
                        console.log(data.mensaje);
                    }
				})
				.always(function() {
					console.log("finalizo generarSAlumnos");
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					console.log("generarSAlumnos ERROR: " + textStatus);
				});

    }
    function generarSPlanes(){
        var data = {"tipo":"consulta"};
        $('#h_tbody').empty();
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
					url: "servicios/srv_obtener_planes.php",
					cache: false,
				})
				.done(function(data, textStatus, jqXHR) {				
					console.log(data);
                    var code = data.code;
                    if (code == 1) {
                        //console.log(data.mensaje);
                        $.each(data.data, function(index, value) {
                            //console.log(value);
                            $('#h_plan').append('<option value="'+value.id_plan_estudio+'">'+value.categoria+'-'+value.nombre+' '+value.ciclo_escolar+'</option>');
                        });
                    }else{
                        console.log(data.mensaje);
                    }
				})
				.always(function() {
					console.log("finalizo generarSPlanes");
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					console.log("generarSPlanes ERROR: " + textStatus);
				});

    }
    function limpiarForm(){
        $("#h_alumno").val(1);
        $("#h_plan").val(1);
        $("#h_pro").val("");
    }
    function altaHistorial(){
        var datos = {};
            datos["id_alumno"] = $("#h_alumno").val();
            datos["id_plan"] = $("#h_plan").val();
            datos["promedio"] = $("#h_pro").val();
        console.log(datos);
        if ( !datos["id_alumno"].trim() || !datos["id_plan"].trim() || !datos["promedio"].trim() ) {
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
					url: "servicios/srv_guardar_historial.php",
					cache: false,
				})
				.done(function(data, textStatus, jqXHR) {				
					console.log(data);
                    var code = data.code;
                    if (code == 1) {
                        generarTHisorial();
                        limpiarForm();
                        $('#mjs_error').empty();
                        $('#mjs_error').append('<div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span></button> <strong>'+data.mensaje+'!</strong>. </div>')
                    }else{
                        $('#mjs_error').empty();
                        $('#mjs_error').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> <span class="sr-only">Close</span></button> <strong>'+data.mensaje+'!</strong>. </div>')

                    }
				})
				.always(function() {
					console.log("finalizo altaHistorial");
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					console.log("altaHistorial ERROR: " + textStatus);
				});
        }
    }
    function modificaAlumno(){
        var datos = {};
            datos["id"] = $("#h_id").val();
            datos["nombres"] = $("#h_name").val();
            datos["apellidos"] = $("#h_last").val();
            datos["fecha"] = $("#h_date").val();
            datos["correo"] = $("#h_mail").val();
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
                        $("#h_upd").hide();
                        $("#h_add").show();
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
                        $("#h_upd").show();
                        $("#h_add").hide();
                        var datos = data.data;
                        $("#h_id").val(datos.id_alumno);
                        $("#h_name").val(datos.nombres);
                        $("#h_last").val(datos.apellidos);
                        $("#h_date").val(datos.fechh_nacimiento);
                        $("#h_mail").val(datos.correo);
                    }
                    
				})
				.always(function() {
					console.log("finalizo selectAlumno");
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					console.log("selectAlumno ERROR: " + textStatus);
				});
    }

    function deleteHistorial(id){
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
					url: "servicios/srv_eliminar_historial.php",
					cache: false,
				})
				.done(function(data, textStatus, jqXHR) {				
					console.log(data);
                    var code = data.code;
                    if (code == 1) {
                        generarTHisorial();
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