$(document).on('click', '.btn_guardar', function(e){
    $(this).addClass('hide');
    $(this).next('.btn_confirmar').removeClass('hide');
});
$(document).on('click', '.btn_confirmar', function(e){
    $(this).addClass('hide');
    $(this).prev('.btn_guardar').removeClass('hide');
});
$(document).on('click', '.guardar_form', function(e){
    var form = $(this).data('form');
    var execute = $(this).data('execute');
    enviar_form(form, execute);
});
$(document).on('click', '.delete_form', function(e){
    var vars = $(this).data('vars');
    var execute = $(this).data('execute');
    enviar_form_delete(vars, execute);
});
function enviar_form_delete(vars, execute){
    $.ajax({
        url: vars,
        type: 'GET',
        dataType: 'json',
    }).done(function(data){
        var fn = window[execute];
        if (typeof fn === "function") fn(data);
    });
}
function enviar_form(form, execute){
    var details = $(form).serialize();
    $.ajax({
        url: '?'+details,
        type: 'GET',
        dataType: 'json',
    }).done(function(data){
        var fn = window[execute];
        if (typeof fn === "function") fn(data);
    });
}
function after_add_org(data){
    if(data['validacion'] == 'ok'){
        desplegar_current_list('organizacion','');
        reset();alertify.success(data['msn']);
        $('.div_scroll_formulario').html('');
        $('.load_btn_personal').html('');
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}
function after_add_rol(data){
    if(data['validacion'] == 'ok'){
        desplegar_current_list('rol','');
        desplegar_current_list('menu_permisos','&rol_ID2='+data.rol_ID2);
        reset();alertify.success(data['msn']);
        $('.div_scroll_formulario').html('');
        $('.load_btn_personal').html('');
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}

function after_add_dia_no_laboral(data){
    if(data['validacion'] == 'ok'){
        $('.cancelar_add_dia_no_laboral').click();
        desplegar_current_list('dias_no_laborales','');
        reset();alertify.success(data['msn']);
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}


function after_add_dep(data){
    if(data['validacion'] == 'ok'){
        params = '&org_ID='+ventanillaapp.org;
        desplegar_current_list('departamento',params);
        reset();alertify.success(data['msn']);
        $('.div_scroll_formulario').html('');
        $('.load_btn_personal').html('');
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}

function after_delete_rol(data){
    if(data['validacion'] == 'ok'){
        desplegar_current_list('rol','');
        reset();alertify.success(data['msn']);
        $('.div_scroll_formulario').html('');
        $('.load_btn_personal').html('');
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}
function after_add_personal(data){
    if(data['validacion'] == 'ok'){
        var params = '&org_ID='+data['org_ID']+'&area_ID='+data['area_ID'];
        desplegar_current_list('personal',params);
        var params2 = $('#search_personal_modal').data('vars');
        desplegar_current_list('personal_modal',params2);
        reset();alertify.success(data['msn']);
        $('.div_scroll_formulario').html('');
        $('.load_btn_personal').html('');
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}
function after_edit_perfil(data){
    if(data['validacion'] == 'ok'){
        reset();alertify.success(data['msn']);
        document.location.href ="";
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}
function after_add_ciudadano(data){
    if(data['validacion'] == 'ok'){
        $('.t_ciudadano').find('a').click();
        reset();alertify.success(data['msn']);
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}
function after_delete_personal(data){
    if(data['validacion'] == 'ok'){
        var vars = $('#search_personal').data('vars');
        desplegar_current_list('personal', vars);
        reset();alertify.success(data['msn']);
        $('.div_scroll_formulario').html('');
        $('.load_btn_personal').html('');
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}
function after_delete_ciudadano(data){
    if(data['validacion'] == 'ok'){
        $('.cancel_edit_ciudadano').click();
        reset();alertify.success(data['msn']);
        $('.div_scroll_formulario').html('');
        $('.load_btn_personal').html('');
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}
function after_delete_tipodoc(data){
    if(data['validacion'] == 'ok'){
        $('.cancel_add_tipodoc').click();
        desplegar_current_list('tipodoc', '');
        reset();alertify.success(data['msn']);
        $('.div_scroll_formulario').html('');
        $('.load_btn_personal').html('');
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}

function after_delete_tiporequerimiento(data){
    if(data['validacion'] == 'ok'){
        $('.cancelar_tipo_requerimiento').click();
        desplegar_current_list('tiporequerimiento', '');
        reset();alertify.success(data['msn']);
        $('.div_scroll_formulario').html('');
        $('.load_btn_personal').html('');
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}
function after_delete_entrada(data){
    if(data['validacion'] == 'ok'){
        $('.cancelar_edit_entrada').click();
        desplegar_current_list('entrada', '');
        reset();alertify.success(data['msn']);
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}

function after_delete_salida(data){
    if(data['validacion'] == 'ok'){
        $('.cancelar_edit_salida').click();
        desplegar_current_list('salida', '');
        reset();alertify.success(data['msn']);
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}

function after_delete_canal(data){
    if(data['validacion'] == 'ok'){
        $('.cancelar_form_canal').click();
        desplegar_current_list('tipoenvio', '');
        reset();alertify.success(data['msn']);
        $('.div_scroll_formulario').html('');
        $('.load_btn_personal').html('');
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}

function after_delete_organizacion(data){
    if(data['validacion'] == 'ok'){
        desplegar_current_list('organizacion', '');
        reset();alertify.success(data['msn']);
        $('.div_scroll_formulario').html('');
        $('.load_btn_personal').html('');
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}
function after_delete_area(data){
    if(data['validacion'] == 'ok'){
        var vars = $('#search_departamento').data('vars');
        desplegar_current_list('departamento', vars);
        reset();alertify.success(data['msn']);
        $('.div_scroll_formulario').html('');
        $('.load_btn_personal').html('');
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}
function after_add_ciudadano_modal(data){
    if(data['validacion'] == 'ok'){
        $('#modal_global_personal').modal('hide');
        var firmado_por = firmado_por_array();
        desplegar_current_list('personal_modal','&view=externo&class=modal_list_personal_tr_selected&seleccionados='+firmado_por);
        reset();alertify.success(data['msn']);
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}
function after_add_entidad(data){
    if(data['validacion'] == 'ok'){
        reset();alertify.success(data['msn']);
        $('#tab_list').addClass('active in');
        $('#tab_action').removeClass('active in');
        desplegar_current_list('organizacion','&entidades=yes'); 
    }else if(data['validacion'] == 'fail'){
        reset();alertify.error(data['msn']);
    }else if(data['validacion'] == 'permiso'){
        $('#modal_permiso').modal('show');
    }
}

function class_ks_by_ID(select){
    $(select).chosen({ search_contains: true });       
    $(select+" .chosen-results").css("max-height","120px");
}

$(document).on('click', '.call_ks_in_this_tab', function(e){
    var id_tab = $(this).attr('href');
    var id_ks = '';
    setTimeout(function(){  
        $(id_tab+' .recorer_tab').each(function(){
            id_ks = $(this).attr('id');
            if(id_ks != '' && id_ks != undefined){
                class_ks_by_ID('#'+id_ks);
            }
        });
    },500); 
});

$(document).on('change', '.load_ks_areas', function(e){
    var org_ID = $(this).val();
    $.ajax({
        url: '?controlador=personal&accion=view_ks_areas&org_ID='+org_ID,
        type: 'GET',
        dataType: 'html',
    }).done(function(data){
        $('.div_load_areas_ks').html(data);
    });
});


function reset () {
    $("#toggleCSS").attr("href", "../themes/alertify.default.css");
    alertify.set({
        labels : {
            ok     : "OK",
            cancel : "Cancel"
        },
        delay : 5000,
        buttonReverse : false,
        buttonFocus   : "ok"
    });
}

$(document).on('click', '.org_tr', function(e){
    var id = $(this).data('id');
    var params = '&org_ID='+id;
    ventanillaapp.org = id;
    construir_search('.search_inyectado_departamento','.div_scroll_formulario','departamento','?controlador=area&accion=form_add_edit_dep&case=add&org_ID='+id,'&org_ID='+id);
    desplegar_current_list('departamento', params);
});

$(document).on('click', '.rol_tr', function(e){
    var id = $(this).data('rolid');
    var params = '&rol_ID2='+id;
    desplegar_current_list('menu_permisos', params);
});

$(document).on('click', '.area_tr', function(e){
    var area_id = $(this).data('area');
    var org_id = $(this).data('org');
    var params = '&org_ID='+org_id+'&area_ID='+area_id;
    ventanillaapp.area = area_id;
    construir_search('.search_inyectado_personal','.div_scroll_formulario','personal','?controlador=personal&accion=form_add_edit_persona&case=add&org_ID='+org_id+'&area_ID='+area_id,'&org_ID='+org_id+'&area_ID='+area_id);
    desplegar_current_list('personal', params);
});

function construir_search(div,go_div,target,params_plus,params_search){
    $(div).html('<input type="text" class="form-control search_all" id="search_'+target+'" data-list="'+target+'" placeholder="Buscar" data-vars="'+params_search+'">\n\
                    <span class="input-group-btn">\n\
                        <a class="btn btn-default icon_search go_div" data-div="'+go_div+'" type="button" href="javascript:void(0);" data-vars="'+params_plus+'"><i class="fa fa-plus"></i></a>\n\
                    </span>');
}

$(document).on('click', '.log_out', function(e){
    var details = $('> a',this).attr('href');
    $.ajax({
        url: details,
        type: 'GET',
        dataType: 'html',
    }).done(function(data){
        document.location.href ="";
    });
    return false;
});

function firmado_por_array(){
    ventanillaapp.firmado_por  = [];
    $('#entrada_form_list_tabla_firmado_por tr.tr_personal').each(function(e){
        ventanillaapp.firmado_por.push($(this).data('idpersona'));
    })
    return ventanillaapp.firmado_por;
}
function destino_array(){
    ventanillaapp.destino = [];
    $('#modal_list_destino_tr_selected tr.tr_personal').each(function(e){
        ventanillaapp.destino.push($(this).data('idpersona'));
    })
    return ventanillaapp.destino;
}

$(document).on('click', '.call_modal_list_firmado_por', function(e){
    var firmado_por = firmado_por_array();
    //console.log(firmado_por);
    var details = "?controlador=personal&accion=vista_personal_list&view=externo&class=modal_list_personal_tr_selected&seleccionados="+firmado_por;
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
        /*data: {id: 1}, */
    }).done(function(data){
        $(modal).html(data);
    });
    return false;
});

$(document).on('click', '.call_modal_list_destino', function(e){
    var destino = destino_array();
    var details = "?controlador=personal&accion=vista_personal_list&view=interno&class=modal_list_destino_tr_selected&seleccionados="+destino;
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
        /*data: {id: 1}, */
    }).done(function(data){
        $(modal).html(data);
    });
    return false;
});

$(document).on('click', '.call_modal_list_firmado_por_salida', function(e){
    var firmado_por = firmado_por_array();
    //console.log(firmado_por);
    var details = "?controlador=personal&accion=vista_personal_list&view=interno&class=modal_list_personal_tr_selected&seleccionados="+firmado_por;
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
        /*data: {id: 1}, */
    }).done(function(data){
        $(modal).html(data);
    });
    return false;
});

$(document).on('click', '.call_modal_list_destino_salida', function(e){
    var destino = destino_array();
    var details = "?controlador=personal&accion=vista_personal_list&view=externo&class=modal_list_destino_tr_selected&seleccionados="+destino;
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
        /*data: {id: 1}, */
    }).done(function(data){
        $(modal).html(data);
    });
    return false;
});

$(document).on('click', '.tab_active', function(e){
    var tab = $(this).data('taba');
    $(tab).find('a').click();
});

$(document).on('click', '.active_tab', function(e){
    $('.ul_tabs_index').find('li').removeClass('active');
    $(this).closest('li').addClass('active');
});

$(document).on('change', '.marcar_desmarcar_permiso', function(e){
    var permiso_ID = $(this).data('id');
    $.ajax({
        url: '?controlador=rol&accion=activar_desactivar_permiso&permiso_ID='+permiso_ID,
        type: 'GET',
        dataType: 'json',
    }).done(function(data){
        if(data['validacion'] == 'ok'){
            if(data['color'] == 'negro'){
                reset();alertify.log(data['msn']); 
            }else if(data['color'] == 'verde'){
                reset();alertify.success(data['msn']); 
            }
        }else if(data['validacion'] == 'fail'){
            reset();alertify.error(data['msn']);
        }else if(data['validacion'] == 'permiso'){
            $('#modal_permiso').modal('show');
        }
    });
});


function inyectar_search_modal(interno_externo){
    var value_search = $('.search_modal_personal_list_span').find('input').val();
    if(interno_externo == 'externo'){
        var seleccionados = firmado_por_array();
        var clase = 'modal_list_personal_tr_selected';
    }else if(interno_externo == 'interno'){
        var seleccionados = destino_array();
        var clase = 'modal_list_destino_tr_selected';
    }
    $('.search_modal_personal_list_span').html('<input type="text" class="form-control search_all" value="'+value_search+'" id="search_personal_modal" data-vars="&view='+interno_externo+'&class='+clase+'&seleccionados='+seleccionados+'" data-list="personal_modal" placeholder="Buscar">');
}

$(document).on('click', '.guardar_parametrizacion', function(e){
    var parametro       = $(this).data('param');
    var value_parametro = $('.'+parametro).val();
    $.ajax({
        url: '?controlador=parametrizacion&accion=guardar_parametro&parametro='+parametro+'&valor='+value_parametro,
        type: 'GET',
        dataType: 'json',
    }).done(function(data){
        if(data['validacion'] == 'ok'){
            reset();alertify.success(data['msn']);
        }else if(data['validacion'] == 'fail'){
            reset();alertify.error(data['msn']);
        }else if(data['validacion'] == 'permiso'){
            $('#modal_permiso').modal('show');
        }
    });
});

$(document).on('click', '.guardar_dias_habiles', function(e){
    var details  = $('#form_dias_hablites').serialize();
    $.ajax({
        url: '?controlador=parametrizacion&accion=guardar_dias_habiles&'+details,
        type: 'GET',
        dataType: 'json',
    }).done(function(data){
        if(data['validacion'] == 'ok'){
            reset();alertify.success(data['msn']);
        }else if(data['validacion'] == 'fail'){
            reset();alertify.error(data['msn']);
        }else if(data['validacion'] == 'permiso'){
            $('#modal_permiso').modal('show');
        }
    });
});

$(document).on('click', '.backup_db', function(e){
    $('.spin_download_db').removeClass('hide');
    $.ajax({
        url: '?controlador=parametrizacion&accion=backup_db',
        type: 'GET',
        dataType: 'json',
    }).done(function(data){
        $('.spin_download_db').addClass('hide');
        if(data['validacion'] == 'ok'){
            reset();alertify.success(data['msn']);
            document.location.href = data['file'];
        }else if(data['validacion'] == 'fail'){
            reset();alertify.error(data['msn']);
        }else if(data['validacion'] == 'permiso'){
            $('#modal_permiso').modal('show');
        }
    });
});
 
$(document).on('click', '.generar_excel', function(e){
    $('.spin_generar_xls').removeClass('hide');
    var report = $(this).data('report');
    var inicio = encodeURI($('#fecha_reporte_inicio').find('input').val());
    var fin    = encodeURI($('#fecha_reporte_fin').find('input').val());
    var accion = '';
    if(report == 'entradas'){
        accion = 'generar_excel_entradas';
    }else if(report == 'salidas'){
        accion = 'generar_excel_salidas';
    }
    $.ajax({
        url: '?controlador=informe&accion='+accion+'&tipo='+report+'&inicio='+inicio+'&fin='+fin,
        type: 'GET',
        dataType: 'json',
    }).done(function(data){
        $('.spin_generar_xls').addClass('hide');
        if(data['validacion'] == 'ok'){
            reset();alertify.success(data['msn']);
            document.location.href = data['file'];
        }else if(data['validacion'] == 'fail'){
            reset();alertify.error(data['msn']);
        }else if(data['validacion'] == 'permiso'){
            $('#modal_permiso').modal('show');
        }
    });
});

$(document).on('click', '.filtrar_roles_org', function(e){
    var org_ID = $(this).data('orgid');
    var org_name = $(this).text();
    $.ajax({
        url: '?controlador=rol&accion=desplegar_current_rol&org_ID='+org_ID,
        type: 'GET',
        dataType: 'html',
    }).done(function(data){
        $('#rol_list').html(data);
        $('.org_selected').html('para '+org_name);
    });
});

$(document).on('click', '.eliminar_dia_no_laboral', function(e){
    var id_dia = $(this).data('id');
    $.ajax({
        url: '?controlador=parametrizacion&accion=borrar_dia_no_laboral&id_dia='+id_dia,
        type: 'GET',
        dataType: 'json',
    }).done(function(data){
        if(data['validacion'] == 'ok'){
            desplegar_current_list('dias_no_laborales','');
            reset();alertify.success(data['msn']);
        }else if(data['validacion'] == 'fail'){
            reset();alertify.error(data['msn']);
        }else if(data['validacion'] == 'permiso'){
            $('#modal_permiso').modal('show');
        }
    });
});

//===================change upload docs====================
$(document).on('click', '.trigger_click', function(e){
    var input_file = $(this).data('inpfile');
    $(input_file).trigger('click');
});

$(document).on('change', '#entrada_document_add, #salida_document_add', function(e){
    $('.nombre_documento_cargado').html($(this).val());
    $('.cleaned_uploaded_file').removeClass('hide');
    $('.nombre_documento_cargado').removeClass('hide');
    $('.salida_doc_edit').val('docnew');
});

$(document).on('change', '#entrada_document_edit, #salida_document_edit', function(e){
    $('.nombre_documento_cargado').html($(this).val());
    $('.cleaned_uploaded_file').removeClass('hide');
    $('.nombre_documento_cargado').removeClass('hide');
    $('.entrada_doc_edit').val('docnew');
});
//===================change upload docs====================
