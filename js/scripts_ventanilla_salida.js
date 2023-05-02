//========================filter salida====================
//=========================================================
$(document).on('click', '.toggle_filter_salida', function(){
    var list     = $('.toggle_filter').closest('.btn-group').data('list');
    var value    = $('.toggle_filter > input[type=\"radio\"]').val();
    var params   = '&filtermes='+value;

    var value_fs = $('> input[type=\"radio\"]', this).val();
    params      += '&filter_fs='+value_fs;

    if(value_fs != 'er'){
        $('.btn_add_salida').removeClass('hide');
    }else{
        $('.btn_add_salida').addClass('hide');
    }

    desplegar_current_list(list, params);
});
//========================filter salida====================
//=========================================================

$(document).on('click', '.btn_guardar_salida', function(e){
    $('.btn_guardar_salida').addClass('hide');
    $('.btn_confirmar_salida').removeClass('hide');
});

$(document).on('click','.btn_confirmar_salida', function(){
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
        destino[j] = {idpersonl:$(this).data('idpersona')};
        //destino[j] = {idpersonl:$(this).data('idpersona'),typosalida:$(this).data('typosalida')};
        j++;
    })
    /*===========armado de array destino===========*/

    var responde = $('.salida_persona_responde').val();
    //if($.trim(responde) != ''){
        var myarray = new Array();
        myarray[0] = firmado_por;
        /*=======envio via post al controlador=====*/
        var formData = new FormData( $('#form_add_salida')[0] );
        formData.append("firmado_por", JSON.stringify(firmado_por)); 
        formData.append("destino", JSON.stringify(destino));
        formData.append("responde", responde);
        formData.append("test", destino);

        //formData.append("firmado_por", firmado_por);
        $.ajax({
            url: '?controlador=salida&accion=save_form_add_salida',  //server script to process data
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

                var filtro  = '&filtermes='+$('.toggle_filter > input[type=\"radio\"]').val();
		        filtro += '&filter_fs='+$('.toggle_filter_salida.active > input[type=\"radio\"]').val();
		   		desplegar_current_list('salida', filtro); 
                reset(); alertify.success(data.msn);

                back_slide('#tab_list', '#tab_action');
                
                back_slide('#tab_list', '#tab_action');
                setTimeout(function(){ 
                    $('#tab_action').html(''); 
                    $('#salida_list > .salida_tr:first').click();
                },200);
            }else{
                reset(); alertify.error(data.msn);
                $('.btn_confirmar_salida').addClass('hide');
                $('.btn_guardar_salida').removeClass('hide');
                $('.disabled_btn').removeClass('disabled');
            }
        }); 
        /*=========================================*/
    /*}else{
        reset(); alertify.error('Una persona de destiono debe responder la salida.');
        $('.btn_confirmar_salida').addClass('hide');
        $('.btn_guardar_salida').removeClass('hide');
        $('.disabled_btn').removeClass('disabled');
    }*/
    return false;
});

$(document).on('change', '.load_salida_ks_tipo_doc', function(e){
    var tipo_requerimiento = $(this).val();
    $.ajax({
        url: '?controlador=salida&accion=view_ks_tipo_doc&tipo_requerimiento='+tipo_requerimiento,
        type: 'GET',
        dataType: 'html',
    }).done(function(data){
        $('.div_load_tipo_doc_ks').html(data);
    });
});
$(document).on('change', '#ks_salida_tipo_doc', function(){
    var tipoid    = $(this).val();
    var prioridad = $('#ks_salida_tipo_doc option[value="'+tipoid+'"]').data('prioridad');
    var respuesta = $('#ks_salida_tipo_doc option[value="'+tipoid+'"]').data('respuesta');
    var tiempo    = $('#ks_salida_tipo_doc option[value="'+tipoid+'"]').data('tiempo');
    $('#tdc_respuesta').val(respuesta);
    $('#tdc_tiempo').val(tiempo);
    $('#tdoc_prioridad').val(prioridad);
    /*
    $('#modal_list_destino_tr_selected > tr').not('.tr_neutro').remove();
    $('#modal_list_destino_tr_selected > .tr_neutro').removeClass('hide');
    */
    if($.trim(tipoid) != '')
        $('.btn_disabled').removeAttr('disabled');
    else
        $('.btn_disabled').attr('disabled','disabled');
    
});

$(document).on('click', '.call_modal_list_typo_salida', function(e){
    var destino     = destino_array();
    var idpersona   = $(this).data('idpersona');
    var details = "?controlador=salida&accion=vista_personal_list&class=modal_list_typosalida_tr_selected&type_load=ini&idpersona="+idpersona;
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

$(document).on('click', '.modal_list_typosalida_tr_selected', function(e){
    $(this).addClass('active');
    var idpersona    = $(this).data('idpersona');
    var id_typo      = $(this).data('id');
    var description  = $(this).find('.name').text();
        description += '<span class=\"gray gray_to_maroon cursor call_modal call_modal_list_typo_salida\" data-idpersona=\"'+idpersona+'\">\n\
                            <i class="fa fa-pencil-square-o hover_s f_18 pull-right"></i>\n\
                        </span> ';

    $('#modal_list_destino_tr_selected tr.tr_personal[data-idpersona=\"'+idpersona+'\"]').attr('data-typosalida',id_typo);
    $('#modal_list_destino_tr_selected tr.tr_personal[data-idpersona=\"'+idpersona+'\"] > td:eq(2)').html(description);
    return false;
});


// IMPORTANTE !!!!!!!!!!!
//tener en cuenta el ib que visualiza las entradas 
//que no han sido procesadas y la fecha limite ya esta vencida