google.load("visualization", "1", {packages:["corechart"]});

var ventanillaapp = new Object();
ventanillaapp.page  = '';
ventanillaapp.pages = '';
ventanillaapp.aceptar = '';
ventanillaapp.page_org    = '';
ventanillaapp.pages_org   = '';
ventanillaapp.page_area   = '';
ventanillaapp.pages_area   = '';
ventanillaapp.page_persona    = '';
ventanillaapp.pages_persona   = '';
ventanillaapp.page_persona_modal    = '';
ventanillaapp.pages_persona_modal   = '';
ventanillaapp.toggle_view = '';
ventanillaapp.toggle_view_action = '';
ventanillaapp.org     = '';
ventanillaapp.area    = '';
ventanillaapp.entrada = '';
ventanillaapp.salida  = '';
ventanillaapp.firmado_por  = [];
ventanillaapp.destino      = [];
ventanillaapp.currentmenu  = '';

ventanillaapp.delete_entrada_firmadopor  = '';
ventanillaapp.delete_entrada_destino  = '';


function go_slide(godiv, origendiv){
    /*
    $(origendiv).show("slide", { direction: "left" }, 500);
    $(godiv).hide("slide", { direction: "right" }, 500);
    */
    $(godiv).addClass('active in');
    $(origendiv).removeClass('active in');
}
function back_slide(godiv, origendiv){
    /*
    $(origendiv).hide("slide", { direction: "right" }, 500);
    $(godiv).show("slide", { direction: "left" }, 500);
    */
    $(godiv).addClass('active in');
    $(origendiv).removeClass('active in');
}
$(document).on('click', '.go_slide', function(){
    var godiv = $(this).data('godiv');
    var origendiv = $(this).data('origendiv');
    /*$(origendiv).hide("slide", { direction: "left" }, 500);
    $(godiv).show("slide", { direction: "righ" }, 500);*/
    $(godiv).addClass('active in');
    $(origendiv).removeClass('active in');
    return false;
});
$(document).on('click', '.back_slide', function(){
    var godiv = $(this).data('godiv');
    var origendiv = $(this).data('origendiv');
    /*$(origendiv).hide("slide", { direction: "right" }, 500);
    $(godiv).show("slide", { direction: "left" }, 500);*/
    $(godiv).addClass('active in');
    $(origendiv).removeClass('active in');
    setTimeout(function(){ $('#tab_action').html(''); },200); 
    return false;
});
$(document).on('click', '.return_false', function(){
  return false;
});
$(document).on('click', '.go_menu', function(e){
    var details = $('> a',this).attr('href');
    $('.go_menu').removeClass('active');
    if($(this).closest('.dropdown-menu').length == 0)
        $('.dropdown.open').removeClass('open');
    $(this).addClass('active');
    back_slide('#tab_list', '#tab_action');
    ventanillaapp.currentmenu = '';
    $.ajax({
        url: details,
        type: 'GET',
        dataType: 'html',
    }).done(function(data){
        $('#tab_list').html(data);
        setTimeout(function(){ $('#tab_action').html(''); },200); 
    });
    return false;
});
$(document).on('click', '.go_action', function(e){
    var details = $(this).data('vars');
    go_slide('#tab_action', '#tab_list');
    $.ajax({
        url: details,
        type: 'GET',
        dataType: 'html',
    }).done(function(data){
        $('#tab_action').html(data);
        $('.scroll_div').each(function(){
            if($(this).is(':visible')){
                calcular_body_list('#load_body', $(this).data('class'));
            }
        });
    });
    return false;
});

$(document).on('click', '.go_div', function(e){
    var details = $(this).data('vars');
    var div =$(this).data('div');
    if(div == '#tab_list')
        back_slide('#tab_list', '#tab_action');
    $.ajax({
        url: details,
        type: 'GET',
        dataType: 'html',
    }).done(function(data){
        $(div).html(data);
    });
    return false;
});

$(document).on('click', '.call_modal', function(e){
    var details = $(this).data('vars');
    var modal   = $(this).data('modal');
    $(modal).modal({
        show: true,
        backdrop: 'static',
        keyboard: false
    });
    $.ajax({
        url: details,
        type: 'GET',
        dataType: 'html',
        /*data: {id: 1}, */
    }).done(function(data){
        $(modal).html(data);
    });
    return false;
});

$(document).on('click', '.go_menu_dropdown', function(e){
    $('.go_menu').removeClass('active');
    return false;
});

//===============================================================
//=============================search all========================
function desplegar_current_list(target, params){
    var search = $.trim($('#search_'+target).val());
    var fs     = $('.toggle_filter_salida.active > input[type=\"radio\"]').val();
    if(search != ''){
        search = '&search='+search;
    }else{
        search = '';
    }
    params += search;
    switch(target){
        case 'entrada':{
            queue_load_all(target,'#entrada_list',params, 'entrada', 'desplegar_current_entrada');
        }break
        case 'entrada_detalle':{
            if( fs === undefined)
                queue_load_all(target,'#entrada_detalle',params, 'entrada', 'desplegar_current_entrada_detalle');
            else{
                if( fs == 'er')
                    queue_load_all(target,'#salida_detalle',params, 'entrada', 'desplegar_current_entrada_detalle');
                else
                    queue_load_all(target,'#salida_detalle',params, 'salida', 'desplegar_current_salida_detalle');
            }
        }break
        case 'entrada_copia_interna':{
            if( fs === undefined)
                queue_load_all(target,'#entrada_copia_interna',params, 'entrada', 'desplegar_current_entrada_copia_interna');
            else{
                if( fs == 'er')
                    queue_load_all(target,'#salida_copia_interna',params, 'entrada', 'desplegar_current_entrada_copia_interna');
                else
                    queue_load_all(target,'#salida_copia_interna',params, 'salida', 'desplegar_current_salida_copia_interna');
            }
        }break
        case 'salida':{
            queue_load_all(target,'#salida_list',params, 'salida', 'desplegar_current_salida');
        }break
        case 'salida_detalle':{
            queue_load_all(target,'#salida_detalle',params, 'salida', 'desplegar_current_salida_detalle');
        }break
        case 'salida_copia_interna':{
            queue_load_all(target,'#salida_copia_interna',params, 'salida', 'desplegar_current_salida_copia_interna');
        }break
        case 'revision':{
            queue_load_all(target,'#revision_list',params, 'revision', 'desplegar_current_revision');
        }break
        case 'tipodoc':{
            queue_load_all(target,'#tipodoc_list',params, 'tipodoc', 'desplegar_current_tipodoc');
        }break
        case 'tiporequerimiento':{
            queue_load_all(target,'#tiporequerimiento_list',params, 'tiporequerimiento', 'desplegar_current_tiporequerimiento');
        }break
        case 'tipoenvio':{
            queue_load_all(target,'#tipoenvio_list',params, 'tipoenvio', 'desplegar_current_tipoenvio');
        }break
        case 'organizacion':{
            queue_load_all(target,'#org_list',params, 'organizacion', 'desplegar_current_organizacion');
        }break
        case 'departamento':{
            queue_load_all(target,'#dep_list',params, 'area', 'desplegar_current_departamento');
        }break
        case 'personal':{
            queue_load_all(target,'#personal_list',params, 'personal', 'desplegar_current_personal');
        }break
        case 'personal_modal':{
            queue_load_all(target,'#personal_list_modal',params, 'personal', 'desplegar_current_personal_modal');
        }break
        case 'index':{
            queue_load_all(target,'#tab_list',params, 'ventanilla', 'vistaventanilla');
        }break
        case 'rol':{
            queue_load_all(target,'#rol_list',params, 'rol', 'desplegar_current_rol');
        }break
        case 'menu_permisos':{
            queue_load_all(target,'#permiso_list',params, 'rol', 'desplegar_current_menus_permisos');
        }break
        case 'typo_salida_modal':{
            params +='&type_load=search';
            queue_load_all(target,'#typo_salida_list_modal',params, 'salida', 'vista_personal_list');
        }break
        case 'dias_no_laborales':{
            queue_load_all(target,'#dias_no_laborales_list',params, 'parametrizacion', 'desplegar_current_dias_no_laborales_list');
        }break
        
    }  
}
function queue_load_all(target,div,params,control,action){
    ventanillaapp.toggle_view = target;
    var fs = $('.toggle_filter_salida.active > input[type=\"radio\"]').val();
    /*alert(fs+' '+target+' '+div+' '+params+' '+control+' '+action)*/
    jQuery.ajaxQueue({
        url: '?controlador='+control+'&accion='+action+params,
        type: "POST",
        async: true,
        cache: false,
        success: function( result ) {
            $(div).html(result);
            switch(target){
                case 'entrada':
                    $('#entrada_detalle tr.entrada_detail_tr').remove();
                    $('#entrada_detalle').html('<tr><td>Click en el requerimiento para ver el detalle</td></tr>');
                    $('#entrada_copia_interna tr.entrada_copia_interna_tr').remove();
                    $('#entrada_copia_interna').html('<tr><td>Click en la requerimiento para ver las copias</td></tr>');
                break;
                case 'entrada_detalle':
                    if( fs === undefined){
                        calcular_body_list_secundary('#load_body', '.scroll_div_entrada_emisor');
                    }else{
                        calcular_body_list_secundary('#load_body', '.scroll_div_salida_emisor');
                    }
                break
                case 'entrada_copia_interna':
                    if( fs === undefined){
                        calcular_body_list_secundary('#load_body', '.scroll_div_entrada_receptor');
                    }else{
                        calcular_body_list_secundary('#load_body', '.scroll_div_salida_receptor');
                    }
                break
                case 'salida':
                    $('#salida_detalle tr.salida_detail_tr').remove();
                    $('#salida_detalle').html('<tr><td>Click en la salida para ver el detalle</td></tr>');
                    $('#salida_copia_interna tr.salida_copia_interna_tr').remove();
                    $('#salida_copia_interna').html('<tr><td>Click en la salida para ver las copias</td></tr>');
                break;
                case 'salida_detalle':
                    calcular_body_list_secundary('#load_body', '.scroll_div_salida_emisor');
                break
                case 'salida_copia_interna':
                    calcular_body_list_secundary('#load_body', '.scroll_div_salida_receptor');
                break
                case 'revision':
                    
                break;
                case 'tipodoc':
                    calcular_body_list('#load_body', '.scroll_div_tipodoc');
                break;
                case 'tiporequerimiento':
                    calcular_body_list('#load_body', '.scroll_div_tiporequerimiento');
                break;
                case 'tipoenvio':
                    calcular_body_list('#load_body', '.scroll_div_tipoenvio');
                break;
            }
        }
    });
}

$(document).on('change', '.search_all', function(){
    var list  = $(this).data('list');
    var vars  = $(this).data('vars');
    if(vars === undefined){
        vars = '';
        switch(list){
            case 'salida':
                vars  = '&filtermes='+$('.toggle_filter.active > input[type=\"radio\"]').val();
                vars += '&filter_fs='+$('.toggle_filter_salida.active > input[type=\"radio\"]').val();
            break;
            case 'entrada':
                vars  = '&filtermes='+$('.toggle_filter.active > input[type=\"radio\"]').val();
            break;
            case 'revision':
                vars += '&filtro_rv='+$('.toggle_filter_revision.active > input[type=\"radio\"]').val();
            break;
        }
    }
    desplegar_current_list(list, vars);
});

function calcular_body_list(modal, div){
    var win_height = window.innerHeight;
    var resta = 0;
    //console.log(win_height);
    $(modal+' .restar_div').each(function(){
        if($(this).is(':visible')){
            resta = resta + $(this).outerHeight();
            //console.log(win_height);
        }
    });
    resta = win_height - resta;
    //console.log(resta);
    $(div).height(resta+'px');
    $(div).css('overflow','hidden');
    $(div).perfectScrollbar('update');
}

function calcular_body_list_secundary(modal, div){
    var win_height = window.innerHeight;
    var resta = 0;
    $(modal+' .restar_div_secundary').each(function(){
        if($(this).is(':visible')){
            resta = resta + $(this).outerHeight();
        }
    });
    resta = win_height - resta;
    $(div).height(resta+'px');
    $(div).css('overflow','hidden');
    $(div).perfectScrollbar('update');
}
//=============================search all========================
//===============================================================

$( window ).resize(function() {
    $('.scroll_div').each(function(){
        if($(this).is(':visible')){
            calcular_body_list('#load_body', $(this).data('class'));
        }
    });
});

function class_ks(){
    $(".chzn-select").chosen({ search_contains: true }); 
    $(".chzn-select-deselect").chosen({allow_single_deselect:true});      
    $(".chosen-results").css("max-height","250px");
}

function agrandar_modal(funct,modal){
    $(modal).find('.modal-dialog .modal-content').animate({
        width: '100%',
        height: '100%'
    }, 100, function() {
        funct();
    });
}

function calcular_modal_personal(){
    var win_height = $(window).outerHeight();
    var resta = 0;
    var top = 0;
    $('.restar_modal_personal').each(function(){
        resta = resta + $(this).outerHeight();
        //console.log('each restar div: '+resta);
    });
    resta = win_height - resta - 4;
    top = (resta/2);
      
    if(resta > 0){
        
        $('.div_scroll_rol').css('height',top+'px');
        $('.div_scroll_permiso').css('height',top+'px');

        $('.div_scroll_organizacion').css('height',top+'px');
        $('.div_scroll_departamento').css('height',top+'px');
        $('.div_scroll_persona').css('height',top+'px');
        $('.div_scroll_formulario').css('height',resta+'px');
        $('.div_scroll_organizacion, .div_scroll_departamento, .div_scroll_persona, .div_scroll_formulario, .div_scroll_rol, .div_scroll_permiso').perfectScrollbar();
    }
}

function msn_alert(div, msn, type){
    $('.div_load_msn').remove();
    $('body').append('<div class="div_load_msn"></div>');
    $('.div_load_msn').html('<div class="modal fade" id="modal_mensaje_alert" tabindex="-1" role="dialog" aria-labelledby="modal_mensaje_alert" aria-hidden="false" style="overflow-y:hidden;">\n\
                      <div class="modal-dialog">\n\
                        <div class="modal-content">\n\
                          <div class="modal-header">\n\
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\n\
                            <h4 class="modal-title">Alerta!!</h4>\n\
                          </div>\n\
                          <div class="modal-body">\n\
                            <div class="alert '+type+' alert-dismissable">\n\
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>\n\
                                  '+msn+'\n\
                            </div>\n\
                          </div>\n\
                          <div class="modal-footer">\n\
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>\n\
                          </div>\n\
                        </div>\n\
                      </div>\n\
                    </div>');
    $('#modal_mensaje_alert').modal('show');
    setTimeout(function(){ $('#modal_mensaje_alert').modal('hide'); },3000);
}

$(document).on('click', '.popover_comment_close', function(){
  $('.popover_comment').popover('hide');
  $('.popover_comment').next('.popover').attr('style','');
  return false;
});

//=========================================================
//============================entrada======================
$(document).on('click', '.modal_list_personal_tr_selected:not(.active)', function(e){
        $(this).addClass('active');
        var id_persona = $(this).data('id');
        var puede_responder = $(this).data('puederes');
        var name = $(this).find('.name').text();
        var organizacion = $(this).find('.organizacion').text();
        var departamento = $(this).find('.departamento').text();
        $('#entrada_form_list_tabla_firmado_por > .tr_neutro').addClass('hide');
        $('#entrada_form_list_tabla_firmado_por').append('<tr class=\"tr_personal\" data-idpersona=\"'+id_persona+'\">\n\
                                                                <td width="32%"><i class="fa fa-caret-right"></i> '+name+'</td>\n\
                                                                <td width="30%">'+organizacion+'</td>\n\
                                                                <td width="30%" class="border_r_0">'+departamento+'</td>\n\
                                                                <td width="8%" class="center border_l_0"><i class="fa fa-trash-o cursor delete_this_tr gray_to_maroon hover_s f_18"></i></td>\n\
                                                            </tr>');
        inyectar_search_modal('externo');
        return false;
});

$(document).on('click', '.modal_list_destino_tr_selected:not(.active)', function(e){
        $(this).addClass('active');
        var id_persona = $(this).data('id');
        var puede_responder = $(this).data('puederes');
        var chequeado = $('.entrada_persona_responde').val();
        var enabled_disabled = 'disabled';
        var name = $(this).find('.name').text();
        var organizacion = $(this).find('.organizacion').text();
        var departamento = $(this).find('.departamento').text();
        var entrada_creation_date = '';

        //====================calcular tiempo de respuesta==============
        var respuesta = $('#tdc_respuesta').val();
        var tiempo    = $('#tdc_tiempo').val();

        $('#modal_list_destino_tr_selected > .tr_neutro').addClass('hide');
        switch(ventanillaapp.currentmenu){
            case'entrada_edit':
            case'entrada_add':
                if(chequeado == ''){
                    if(puede_responder == 'yes'){
                        enabled_disabled = 'checked';
                        $('.entrada_persona_responde').val(id_persona);
                    }
                }else{
                    if(puede_responder == 'yes'){
                        enabled_disabled = '';
                    }
                }
                if(ventanillaapp.currentmenu == 'entrada_edit'){
                    entrada_creation_date = $('.entrada_creation_date').val();
                }
                $.ajax({
                    url: '?controlador=entrada&accion=calcular_respuesta_entrada',
                    type: 'GET',
                    dataType: 'json',
                    data: { respuesta: respuesta, tiempo: tiempo, entrada_creation_date: entrada_creation_date}
                }).done(function(data){
                    if(data.validacion == 'ok'){
                        $('#modal_list_destino_tr_selected').append('<tr class=\"tr_personal\" data-idpersona=\"'+id_persona+'\" data-date="'+data.tiempo_respuesta+'">\n\
                                                                                <td width="52%" class=""><i class="fa fa-caret-right"></i> '+name+'</td>\n\
                                                                                <td width="30%" class="">'+data.tiempo_respuesta_fm+'</td>\n\
                                                                                <td width="10%" class="border_r_0 center"><input type="checkbox" '+enabled_disabled+' name="entrada_responde" class="entrada_responde" value=""></td>\n\
                                                                                <td width="8%" class="center border_l_0"><i class="fa fa-trash-o cursor delete_this_tr gray_to_maroon hover_s f_18"></i></td>\n\
                                                                            </tr>');
                    }else{
                        reset(); alertify.error(data.msn);
                    }
                    inyectar_search_modal('interno');
                });
            break;
            case'salida_entrada_edit':
            case'salida_entrada_add':
            case'salida_edit':
            case'salida_add':
                $('#modal_list_destino_tr_selected').append('<tr class=\"tr_personal\" data-idpersona=\"'+id_persona+'\" data-typosalida=\"\">\n\
                    <td width="41%" class=""><i class="fa fa-caret-right"></i> '+organizacion+'</td>\n\
                    <td width="41%" class="border_r_0">'+name+'</td>\n\
                    <!-- <td width="19%" class="border_r_0">\n\
                        <span class=\"gray gray_to_maroon cursor call_modal call_modal_list_typo_salida\" data-idpersona=\"'+id_persona+'\">\n\
                            Seleccione un tipo de env&iacute;o\n\
                            <i class="fa fa-pencil-square-o hover_s f_18 pull-right"></i>\n\
                        </span>\n\
                    </td -->\n\
                    <td width="8%" class="center border_l_0"><i class="fa fa-trash-o cursor delete_this_tr gray_to_maroon hover_s f_18"></i></td>\n\
                    </tr>');
            break;
            case'':
            break;
        }
        
        //====================calcular tiempo de respuesta==============
        
        
        return false;
});

$(document).on('click', '.delete_this_tr', function(e){
    var object = $(this).closest('tbody');
    if(ventanillaapp.currentmenu == 'entrada_add'){
        if($(this).closest('.tr_personal').find('.entrada_responde').is(':checked'))
             $('.entrada_persona_responde').val('');
    }
    $(this).closest('tr').remove();  
    if($('> tr', object).length == 1)
        $('> .tr_neutro',object).removeClass('hide');
});

$(document).on('click', '.entrada_responde', function(e){
    var perna_ID = '';
    if($(this).is(':checked'))
        perna_ID = $(this).closest('tr').data('idpersona');
        
    $('.entrada_persona_responde').val(perna_ID);
    $('.entrada_responde').not(this).removeAttr('checked');
});

$(document).on('change', '#ks_entrada_tipo_doc', function(){
    var tipoid          = $(this).val();
    var prioridad       = $('#ks_entrada_tipo_doc option[value="'+tipoid+'"]').data('prioridad');
    var respuesta       = $('#ks_entrada_tipo_doc option[value="'+tipoid+'"]').data('respuesta');
    var tiempo          = '';
    if(ventanillaapp.currentmenu == 'entrada_edit'){
        tiempo = $('#tdc_tiempo').val();
    }else{
        tiempo = $('#ks_entrada_tipo_doc option[value="'+tipoid+'"]').data('tiempo');
    }
    var changedate      = $('#ks_entrada_tipo_doc option[value="'+tipoid+'"]').data('changedate');
    var respuestafisica = $('#ks_entrada_tipo_doc option[value="'+tipoid+'"]').data('respuestafisica');
    $('#tdc_respuesta').val(respuesta);
    /*
    $('#modal_list_destino_tr_selected > tr').not('.tr_neutro').remove();
    $('#modal_list_destino_tr_selected > .tr_neutro').removeClass('hide');
    */
    var entrada_creation_date = '';
    if(isNaN(tiempo) == true){
        $('#modal_list_destino_tr_selected tr.tr_personal').attr('data-date','');
        $('#modal_list_destino_tr_selected tr.tr_personal').each(function(e){
            $(' > td:eq(1)', $(this)).html('Debe digitar un tiempo de respuesta');
        });
    }else{
        if(ventanillaapp.currentmenu == 'entrada_edit'){
            entrada_creation_date = $('.entrada_creation_date').val();
        }else{
            $('#tdc_tiempo').val(tiempo);
            $('#entrada_tiempo_edit').val(tiempo);
        }
        $.ajax({
            url: '?controlador=entrada&accion=calcular_respuesta_entrada',
            type: 'GET',
            dataType: 'json',
            data: { respuesta: respuesta, tiempo: tiempo, entrada_creation_date: entrada_creation_date}
        }).done(function(data){
            if(data.validacion == 'ok'){
                $('#modal_list_destino_tr_selected tr.tr_personal').attr('data-date',data.tiempo_respuesta);
                $('#modal_list_destino_tr_selected tr.tr_personal').each(function(e){
                    $(' > td:eq(1)', $(this)).html(data.tiempo_respuesta_fm);
                });
            }else{
                reset(); alertify.error(data.msn);
            }
        });
    }

    switch(respuesta){
        case 'dias': {
            respuesta = 'Dia(s)'
        }break;
        case 'semanas': {
            respuesta = 'Semana(s)'
        }break;
        case 'meses': {
            respuesta = 'Mese(s)'
        }break;
    }
    $('#tdoc_prioridad').val(prioridad);
    $('#tdoc_respuesta').val(respuesta);
    $('#respuesta_fisica').val(respuestafisica);

    if($.trim(tipoid) != '')
        $('.btn_disabled').removeAttr('disabled');
    else
        $('.btn_disabled').attr('disabled','disabled');

    if(ventanillaapp.currentmenu != 'entrada_edit'){
        if($.trim(changedate) == 'yes')
            $('#tdc_tiempo').removeAttr('disabled');
        else
            $('#tdc_tiempo').attr('disabled','disabled');
    }
});

$(document).on('keyup', '#tdc_tiempo', function(){
    var tipoid    = $('#ks_entrada_tipo_doc').val();
    var tiempo    = parseFloat($(this).val())+0;
    var respuesta = $('#tdc_respuesta').val();
    var entrada_creation_date = '';

    var tr = '';
    if(isNaN(tiempo) == true){
        $('#modal_list_destino_tr_selected tr.tr_personal').attr('data-date','');
        $('#modal_list_destino_tr_selected tr.tr_personal').each(function(e){
            $(' > td:eq(1)', $(this)).html('Debe digitar un tiempo de respuesta');
        });
    }else{
        if(ventanillaapp.currentmenu == 'entrada_edit'){
            entrada_creation_date = $('.entrada_creation_date').val();
        }else{
            $('#entrada_tiempo_edit').val(tiempo);
        }
        tr = $(this);   
        $.ajax({
            url: '?controlador=entrada&accion=calcular_respuesta_entrada',
            type: 'GET',
            dataType: 'json',
            data: { respuesta: respuesta, tiempo: tiempo, entrada_creation_date: entrada_creation_date}
        }).done(function(data){
            if(data.validacion == 'ok'){
                $('#modal_list_destino_tr_selected tr.tr_personal').attr('data-date',data.tiempo_respuesta);
                $('#modal_list_destino_tr_selected tr.tr_personal').each(function(e){
                    $(' > td:eq(1)', $(this)).html(data.tiempo_respuesta_fm);
                });
            }else{
                reset(); alertify.error(data.msn);
            }
        });
    }
    if($.trim(tiempo) > 0 && $.trim(tipoid) != ''){
        $('.btn_guardar_entrada').removeAttr('disabled');
        $('.btn_disabled').removeAttr('disabled');
    }else{
        $('.btn_guardar_entrada').attr('disabled','disabled');
        $('.btn_disabled').attr('disabled','disabled');
    }
});

$(document).on('click', '.btn_guardar_entrada', function(e){
    $('.btn_guardar_entrada').addClass('hide');
    $('.btn_confirmar_entrada').removeClass('hide');
});

$(document).on('click','.btn_confirmar_entrada', function(){
    $('.disabled_btn').addClass('disabled');
    /*=====variables=======*/
    var i = 0;
    var j = 0;
    var firmado_por = [];
    var destino     = [];
    /*=====================*/

    /*=========armado de array firmado por=========*/
    $('#entrada_form_list_tabla_firmado_por tr.tr_personal').each(function(e){
        firmado_por[i] = {idpersonl:$(this).data('idpersona')};
        i++;
    })
    /*=========armado de array firmado por=========*/

    /*===========armado de array destino===========*/
    $('#modal_list_destino_tr_selected tr.tr_personal').each(function(e){
        destino[j] = {idpersonl:$(this).data('idpersona'),dateresponde:$(this).data('date')};
        j++;
    })
    /*===========armado de array destino===========*/

    var responde = $('.entrada_persona_responde').val();
    if($.trim(responde) != ''){
        var myarray = new Array();
        myarray[0] = firmado_por;
        /*=======envio via post al controlador=====*/
        var formData = new FormData( $('#form_add_entrada')[0] );
        formData.append("firmado_por", JSON.stringify(firmado_por)); 
        formData.append("destino", JSON.stringify(destino));
        formData.append("responde", responde);
        formData.append("test", destino);

        //formData.append("firmado_por", firmado_por);
        $.ajax({
            url: '?controlador=entrada&accion=save_form_add_entrada',  //server script to process data
            type: 'POST',
            data: formData,
            dataType: 'json',
            xhr: function() {  
                // custom xhr
                myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // check if upload property exists
                    //myXhr.upload.addEventListener('progress',progress_insert_transactions, false); // for handling the progress of the upload
                }
                return myXhr;
            },
            //success: obtener_json_insert_transactions,
            
            cache: false,
            contentType: false,
            processData: false

        }).done(function(data){
            if(data.validacion == 'ok'){
                ventanillaapp.page  = '';
                ventanillaapp.pages = '';
                desplegar_current_list('entrada','');
                reset(); alertify.success(data.msn);

                back_slide('#tab_list', '#tab_action');
                
                back_slide('#tab_list', '#tab_action');
                setTimeout(function(){ 
                    $('#tab_action').html(''); 
                    $('#entrada_list > .entrada_tr:first').click();
                },200);
            }else{
                reset(); alertify.error(data.msn);
                $('.btn_confirmar_entrada').addClass('hide');
                $('.btn_guardar_entrada').removeClass('hide');
                $('.disabled_btn').removeClass('disabled');
            }
        }); 

        /*var details  = $('#form_add_entrada').serialize();
        $.ajax({
            url: '?'+details,
            type: 'GET',
            dataType: 'json',
            data: { firmado_por: firmado_por, destino: destino, responde: responde}
        }).done(function(data){
            if(data.validacion == 'ok'){
                ventanillaapp.page  = '';
                ventanillaapp.pages = '';
                desplegar_current_list('entrada','');
                reset(); alertify.success(data.msn);

                back_slide('#tab_list', '#tab_action');
                
                back_slide('#tab_list', '#tab_action');
                setTimeout(function(){ $('#tab_action').html(''); },200);
            }else{
                reset(); alertify.error(data.msn);
                $('.btn_confirmar_entrada').addClass('hide');
                $('.btn_guardar_entrada').removeClass('hide');
                $('.disabled_btn').removeClass('disabled');
            }
        });    */
        /*=========================================*/
    }else{
        reset(); alertify.error('Una persona de destiono debe responder la entrada.');
        $('.btn_confirmar_entrada').addClass('hide');
        $('.btn_guardar_entrada').removeClass('hide');
        $('.disabled_btn').removeClass('disabled');
    }
    return false;
});
//============================entrada======================
//=========================================================

//=========================================================
//============================tipo doc=====================
function after_add_tipodoc(data){
    if(data['validacion'] == 'ok'){
        ventanillaapp.page  = '';
        ventanillaapp.pages = '';
        desplegar_current_list('tipodoc','');
        reset(); alertify.success(data['msn']);
        
        back_slide('#tab_list', '#tab_action');
        setTimeout(function(){ $('#tab_action').html(''); },200);
    }else if(data['validacion'] == 'fail'){
        reset(); alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}
//============================tipo doc=====================
//=========================================================

//=========================================================
//======================tipo requerimiento=================
function after_add_tiporequerimiento(data){
    if(data['validacion'] == 'ok'){
        ventanillaapp.page  = '';
        ventanillaapp.pages = '';
        desplegar_current_list('tiporequerimiento','');
        reset(); alertify.success(data['msn']);
        
        back_slide('#tab_list', '#tab_action');
        setTimeout(function(){ $('#tab_action').html(''); },200);
    }else if(data['validacion'] == 'fail'){
        reset(); alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}
//======================tipo requerimiento=================
//=========================================================

//=========================================================
//======================tipo envio=================
function after_add_tipoenvio(data){
    if(data['validacion'] == 'ok'){
        ventanillaapp.page  = '';
        ventanillaapp.pages = '';
        desplegar_current_list('tipoenvio','');
        reset(); alertify.success(data['msn']);
        
        back_slide('#tab_list', '#tab_action');
        setTimeout(function(){ $('#tab_action').html(''); },200);
    }else if(data['validacion'] == 'fail'){
        reset(); alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}
//======================tipo envio=================
//=========================================================

//==========================filter all=====================
//=========================================================
$(document).on('click', '.toggle_filter', function(){
    var list    = $(this).closest('.btn-group').data('list');
    var value   = $('> input[type=\"radio\"]', this).val();
    var params  = '&filtermes='+value;
    if(list == 'salida'){
        var value_fs = $('.toggle_filter_salida.active > input[type=\"radio\"]').val();
        params      += '&filter_fs='+value_fs;
    }
    desplegar_current_list(list, params);
});
//==========================filter all=====================
//=========================================================

$(document).on('click', '#entrada_list > tr', function(){
    $('#entrada_list > tr').removeClass('active');
    $(this).addClass('active');
});
$(document).on('click', '#salida_list > tr', function(){
    $('#salida_list > tr').removeClass('active');
    $(this).addClass('active');
});

$(document).on('click', '.entrada_tr', function(e){
    var id = $(this).data('iditem');
    var params = '&entrada_ID='+id;
    ventanillaapp.entrada = id;
    desplegar_current_list('entrada_detalle', params);
    desplegar_current_list('entrada_copia_interna', params);
});
$(document).on('click', '.salida_tr', function(e){
    var id      = $(this).data('iditem');
    var params  = '&salida_ID='+id;
        params += '&entrada_ID='+id;
    var fs      = $('.toggle_filter_salida.active > input[type=\"radio\"]').val();
    ventanillaapp.salida = id;
    if(fs == 'sr'){
        desplegar_current_list('salida_detalle', params);
        desplegar_current_list('salida_copia_interna', params);
    }else{
        desplegar_current_list('entrada_detalle', params);
        desplegar_current_list('entrada_copia_interna', params);
    }
});

//========================filter revision==================
//=========================================================
$(document).on('click', '.revision_tr', function(e){
    var id      = $(this).data('iditem');
    var params  = '&entrada_ID='+id;
    var fr      = $('.toggle_filter_revision.active > input[type=\"radio\"]').val();
        params += '&filtro_rv='+fr;
    ventanillaapp.entrada = id;
    desplegar_current_list('entrada_detalle', params);
});

$(document).on('click', '.toggle_filter_revision', function(){
    var list     = $(this).closest('.btn-group').data('list');
    var value_fr = $('> input[type=\"radio\"]', this).val();
    var params   = '&filtro_rv='+value_fr;

    desplegar_current_list(list, params);
});
//========================filter revision==================
//=========================================================

//==============modal edit entrada (revision) =============
$(document).on('click', '.call_modal_revision_edit', function(e){
    $(this).closest('tr').click();
    var details = $(this).data('vars');
    var modal   = "#modal_global";
    $(modal).modal({
        show: true,
        backdrop: 'static',
        keyboard: false
    });
    $.ajax({
        url: details,
        type: 'GET',
        dataType: 'html',
    }).done(function(data){
        $(modal).html(data);
    });
    return false;
});
//==============modal edit entrada (revision) =============

//==========================================================================
//==================================revision================================
$(document).on('click', '.btn_guardar_revision', function(e){
    $('.btn_guardar_revision').addClass('hide');
    $('.btn_confirmar_revision').removeClass('hide');

    $('.btn_guardar_revision_enviar').removeClass('hide');
    $('.btn_confirmar_revision_enviar').addClass('hide');
});

$(document).on('click', '.btn_guardar_revision_enviar', function(e){
    $('.btn_guardar_revision_enviar').addClass('hide');
    $('.btn_confirmar_revision_enviar').removeClass('hide');

    $('.btn_guardar_revision').removeClass('hide');
    $('.btn_confirmar_revision').addClass('hide');
});

$(document).on('click','.btn_confirmar_revision, .btn_confirmar_revision_enviar', function(){
    var comentario = $('#revision_comentario').val();
    $('.disabled_btn').addClass('disabled');
    if($.trim(comentario) != ''){
        var details  = encodeURI($('#form_revision').serialize());
        $.ajax({
            url: '?'+details,
            type: 'GET',
            dataType: 'json'
        }).done(function(data){
            if(data.validacion == 'ok'){
                ventanillaapp.page  = '';
                ventanillaapp.pages = '';
                var list  = 'revision';
                var vars  = '&filtro_rv='+$('.toggle_filter_revision.active > input[type=\"radio\"]').val();
                desplegar_current_list(list, vars);
                reset(); alertify.success(data.msn);
                
                back_slide('#tab_list', '#tab_action');
                setTimeout(function(){ $('#tab_action').html(''); },200);
                $('.btn_revision_close').click();
                $('.revision_tr:first').click();
            }else{
                reset(); alertify.error(data.msn);
                $('.btn_guardar_revision').removeClass('hide');
                $('.btn_confirmar_revision').addClass('hide');

                $('.btn_guardar_revision_enviar').removeClass('hide');
                $('.btn_confirmar_revision_enviar').addClass('hide');

                $('.disabled_btn').removeClass('disabled');
            }
        });
        /*=========================================*/
    }else{
        reset(); alertify.error('Debe escribir un comentario para la revisi&oacute;n.');
        $('.btn_guardar_revision').removeClass('hide');
        $('.btn_confirmar_revision').addClass('hide');

        $('.btn_guardar_revision_enviar').removeClass('hide');
        $('.btn_confirmar_revision_enviar').addClass('hide');

        $('.disabled_btn').removeClass('disabled');
    }
    return false;
});
//==================================revision================================
//==========================================================================

$(document).on('change', '.load_entrada_ks_tipo_doc', function(e){
    var tipo_requerimiento = $(this).val();
    $.ajax({
        url: '?controlador=entrada&accion=view_ks_tipo_doc&tipo_requerimiento='+tipo_requerimiento,
        type: 'GET',
        dataType: 'html',
    }).done(function(data){
        $('.div_load_tipo_doc_ks').html(data);
    });
});

$(document).on('click', '.cleaned_uploaded_file', function(e){
    if($('.entrada_document_add').length > 0)
        $('#entrada_document_add').val('');
    if($('.salida_document_add').length > 0)
        $('#salida_document_add').val('');
    fileupload = $('#entrada_document_add');  
    fileupload.replaceWith(fileupload.clone(true)); 
    $('.nombre_documento_cargado').html('');
    $('.cleaned_uploaded_file').addClass('hide');
    $('.nombre_documento_cargado').addClass('hide');
    if($('.entrada_doc_edit').length > 0)
        $('.entrada_doc_edit').val('docdelete');
    if($('.salida_doc_edit').length > 0)
        $('.salida_doc_edit').val('docdelete');
});

$(document).on('click', '.delete_this_tr_edit', function(e){
    var object           = $(this).closest('tbody');
    var call             = $(this).data('call');
    var delete_idpersona = $(this).closest('.tr_personal').data('idpersona');
    if(ventanillaapp.currentmenu == 'entrada_edit'){
        if($(this).closest('.tr_personal').find('.entrada_responde').is(':checked'))
             $('.entrada_persona_responde').val('');
    }

    switch(call){
        case'firmadopor':{
            if(ventanillaapp.delete_entrada_firmadopor != '')
                ventanillaapp.delete_entrada_firmadopor += ','+delete_idpersona
            else
                ventanillaapp.delete_entrada_firmadopor += delete_idpersona
            $('.delete_entrada_firmadopor').val(ventanillaapp.delete_entrada_firmadopor);
        }
        break;
        case'destino':{
            if(ventanillaapp.delete_entrada_destino != '')
                ventanillaapp.delete_entrada_destino += ','+delete_idpersona
            else
                ventanillaapp.delete_entrada_destino += delete_idpersona
            $('.delete_entrada_destino').val(ventanillaapp.delete_entrada_destino);
        }
        break;
    }

    $(this).closest('tr').remove();  
    if($('> tr', object).length == 1)
        $('> .tr_neutro',object).removeClass('hide');
    
});

