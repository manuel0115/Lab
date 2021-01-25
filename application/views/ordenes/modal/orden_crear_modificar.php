
<style>
    .ui-autocomplete {
        z-index: 2147483647;
    }

    input[readonly] {
        background-color: #fff !important;
    }

    th.dt-center,
    td.dt-center {
        text-align: center !important;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title"><?php echo ($datos_orden[0]["ID_ORDEN"] > 0) ? "Modificar orden " : "Crear orden"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">


    <form action="ordenes/guardar_orden" id="frm_modficar_agregar_orden" name="frm_modficar_agregar_orden" class="form-horizontal " data-parsley-validate="true">
        
        <input type="hidden" name="id_orden" id="id_orden" class="form-control" placeholder="" value="<?php echo  $datos_orden[0]['ID_ORDEN'] ?>">

        <legend>Informacion de usuario</legend>
        <div class="row pl-2 pt-4">

            <div class="form-group col-sm-2 pl-0 d-inline-block">
                <label>NO#</label>
                <input type="text" name="id_paciente" id="id_paciente" class="form-control tabla_paciente" placeholder="XX" value="<?php echo $datos_orden[0]['ID_PACIENTE'] ?>" readonly />


            </div>

            <div class="form-group col-sm-5 pl-0 d-inline-block">
                <label>Cedula</label>
                <input type="text" name="cedula" id="cedula" class="form-control tabla_paciente " placeholder="Nombre el analisis" required value="<?php echo $datos_orden[0]['CEDULA'] ?>" />


            </div>
            <div class="form-group col-sm-5 pl-0 d-inline-block">
                <label>Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control tabla_paciente" placeholder="Nombre el analisis" required value="<?php echo $datos_orden[0]['NOMBRE'] ?>" readonly />


            </div>

        </div>
        <div class="row pl-2 pb-4 mb-1">

            <div class="form-group col-sm-12 pl-0 d-inline-block">
                <label>Referencia</label>
                <select type="text" name="referencia" id="referencia" class="form-control">

                    <?php foreach ($referencias as $key => $value) : ?>
                        <option value="<?php echo $value["ID"] ?>" <?php echo ($value["ID"] == $datos_orden[0]['REFERENCIA']) ? "selected" : ""; ?>><?php echo $value["NOMBRE"] ?></option>
                    <?php endforeach; ?>
                </select>


            </div>



        </div>
        <div class="row pl-2 pb-4 mb-1">
            <div class="form-group col-sm-10 pl-0 d-inline-block">
                <label>Lista de analisis</label>
                <input data-parsley-addanalisisno type="text" name="analisis" id="analisis" class="form-control" placeholder="nombre del analisis" data-parsley-addanalisis />
                <input type="hidden" name="id_analisis" id="id_analisis" class="form-control" value="" />
            </div>
            <div class="form-group col-sm-2 pl-0 d-inline-block">
                <label>&nbsp;</label>
                <a href="javascript:;" id="generador_ordenes" class="btn btn-primary btn-block ">Agregar <span class="btn-label"><i class="fas fa-plus"> </i></span></a>
            </div>

        </div>

      


        <div class="panel panel-inverse">
            <!-- begin panel-heading -->
            <div class="panel-heading">
                <h4 class="panel-title"></h4>

            </div>
            <!-- end panel-heading -->
            <!-- begin panel-body -->
            <div class="panel-body table-responsive p-0">
                <table id="tblAnalisisOrdenes" class="table table-striped table-bordered table-td-valign-middle" style="width:100%;">
                    <form class="form-horizontal">
                        <thead>
                            <tr>
                                <th width="1%" class="text-rap text-center">ID</th>
                                <th width="5%" class="text-rap text-center">NOMBRE</th>
                                <th width="10%" class="text-rap text-center">PRECIO</th>
                                <th width="10%" class="text-rap text-center">&nbsp;</th>
                            </tr>
                            <?php if ($datos_orden[0]["ID_ORDEN"] > 0) {

                                $LISTA_PRECIO = explode(",", $datos_orden[0]["LISTA_PRECIO"]);

                                function lista_mapeo_array($ar)
                                {
                                    $detalle = explode("-", $ar);
                                    return  $detalle[0];
                                }

                                $lista_analisis = implode(",", array_map("lista_mapeo_array", $LISTA_PRECIO));
                            } ?>
                            <input type="hidden" id="lista_analisis_old" value="<?php echo $lista_analisis ?>">

                        </thead>
                        <tbody id="tbody_orden">
                            <?php if ($datos_orden[0]["ID_ORDEN"] > 0) { ?>

                                <?php foreach ($LISTA_PRECIO as $key => $value) {
                                    $detalle = explode("-", $value);
                                ?>

                                    <tr class="id-analisis" data-id-analisis="<?php echo $detalle[0] ?>">
                                        <td width="1%" class="text-rap text-center"><?php echo $detalle[0] ?></td>
                                        <td width="5%" class="text-rap text-center"><?php echo $detalle[1] ?></td>
                                        <td width="10%" class="text-rap text-center"><?php echo $detalle[2] ?></td>
                                        <td width="10%" class="text-rap text-center"><a href="javascript:;" class="btn btn-danger eliminar-analisis"><i class="fas fa-times"></i></a> </td>
                                    </tr>



                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </form>

                </table>
            </div>

        </div>



</div>


</form>
</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_orden">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    var $frm_modficar_agregar_orden = $("#frm_modficar_agregar_orden");

    $('#analisis').autocomplete({
        minLength: 1,
        source: "analisis/autocompletadoAnalisis",
        select: function(event, ui) {
            event.preventDefault();
            $("#analisis").val(ui.item.value);
            $("#id_analisis").val(ui.item.ID);

        }
    });



    var tblAnalisisOrdenes = $("#tblAnalisisOrdenes");

    $("#generador_ordenes").click(function() {

        var referencia = $("#referencia").val();
        var id_analisis = $("#id_analisis").val();
        var lista_id = $(".dt-ordenes-id");
        var tbody_orden = $("#tbody_orden");

        if (tbody_orden.children().length == 0) {


            $.post("ordenes/getOrdenesPrecio", {
                listaAnalisis: id_analisis,
                id_referencia: referencia
            }, function(data) {


                $.each(data, function(index, value) {

                    let row = ` <tr class="id-analisis" data-id-analisis="${value.ID_ANALISIS}">
                                <td width="1%" class="text-rap text-center">${value.ID_ANALISIS}</td>
                                <td width="5%" class="text-rap text-center">${value.NOMBRE_ANALISIS}</td>
                                <td width="10%" class="text-rap text-center">${value.PRECIO}</td>
                                <td width="10%" class="text-rap text-center"><a href="javascript:;" class="btn btn-danger eliminar-analisis"><i class="fas fa-times"></i></a> </td>
                            </tr>`

                    tbody_orden.append(row);



                })
            }, "json")
        } else {
            let objs = [];

            $('#tblAnalisisOrdenes tbody tr td:nth-child(1)').each(function() {

                objs.push($(this).text());
            });

            console.log(objs.includes(id_analisis));

            let existe = objs.includes(id_analisis);

            if (!existe) {

                $.post("ordenes/getOrdenesPrecio", {
                    listaAnalisis: id_analisis,
                    id_referencia: referencia
                }, function(data) {


                    $.each(data, function(index, value) {

                        let row = ` <tr class="id-analisis" data-id-analisis="${value.ID_ANALISIS}">
                                <td width="1%" class="text-rap text-center">${value.ID_ANALISIS}</td>
                                <td width="5%" class="text-rap text-center">${value.NOMBRE_ANALISIS}</td>
                                <td width="10%" class="text-rap text-center">${value.PRECIO}</td>
                                <td width="10%" class="text-rap text-center"><a href="javascript:;" class="btn btn-danger eliminar-analisis"><i class="fas fa-times"></i></a> </td>
                            </tr>`

                        tbody_orden.append(row);



                    })
                }, "json")
            }

        }
    });

    tblAnalisisOrdenes.on("click", ".eliminar-analisis", function() {

        swal({
                title: "¿Esta seguro que desea eliminar esta analisis?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((cerrar_sesion) => {
                if (cerrar_sesion) {
                    
                    $(this).parents('tr').remove();
                }
            });

    })

    var listaAnalisisOrdenes = [];

    $('#tblAnalisisOrdenes tbody tr td:nth-child(1)').each(function() {
        //add item to array
        listaAnalisisOrdenes.push($(this).text());
    });

   

    $("#referencia").change(function() {
        let lista_analisis = [];

        let id_referencia = $(this).val()

        $('#tblAnalisisOrdenes tbody tr td:nth-child(1)').each(function() {
            //add item to array
            lista_analisis.push($(this).text());
        });

        $.post("ordenes/actulizarLista_Precios", {
            id_referencia: id_referencia,
            lista_analisis: lista_analisis
        }, function(data) {
            $("#tbody_orden").html("");

            $.each(data, function(index, value) {
                let row = ` <tr class="id-analisis" data-id-analisis="${value.ID_ANALISIS}">
                    <td width="1%" class="text-rap text-center">${value.ID_ANALISIS}</td>
                    <td width="5%" class="text-rap text-center">${value.NOMBRE}</td>
                    <td width="10%" class="text-rap text-center">${value.PRECIO}</td>
                    <td width="10%" class="text-rap text-center"><a href="javascript:;" class="btn btn-danger eliminar-analisis"><i class="fas fa-times"></i></a> </td>
                </tr>`



                $("#tbody_orden").append(row);
            })

        }, 'json')
    });

    window.Parsley.addValidator('addanalisis',
            function(value) {
                return $("#tbody_orden").children().length != 0
            })
        .addMessage('es', 'addanalisis', 'Debe agregar un analisis');
</script>