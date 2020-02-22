/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $("#switch_pump").bootstrapSwitch();
    $("#switch_pump").on('switchChange.bootstrapSwitch', function (event, state) {
        var encodedURL = encodeURIComponent(PG_ATUAL + "!switch_pump!" + state);
        $.get(encodedURL).done(function (data) {
            if (data) {
                obj = $.parseJSON(data);
                messages_json(obj, "messages_form");
            } else {
                bootbox.alert(no_data_found);
            }
        }, "json");
    });

    setInterval(function () {
        // code you want to execute every second here
        updateSwitchButton();
    }, 5000);

    $("#form_config_container").submit(function (e) {
        e.preventDefault();
        submitConfigurationPump();
    });
    
    $("#form_config_geral").submit(function (e) {
        e.preventDefault();
        submitConfigurationGeral();
    });

    $("#submit_config_pump").click(function () {
        bootbox.confirm("Enviar novos dados da bomba d'agua?", function (result) {
            if (result) {
                $("#form_config_container").submit();
            }
        });
    });
    $("#submit_config_geral").click(function (e) {
        bootbox.confirm("Enviar novos parâmetro gerais de configuracão?", function (result) {
            if (result) {
                $("#form_config_geral").submit();
            }
        });
    });

});
function submitConfigurationPump() {

    blockField("#pump");
    $.post("#", $("#form_config_container").serialize()).done(function (data) {
        if (data) {
            obj = $.parseJSON(data);
            messages_json(obj, "messages_form");
            $("#pump").unblock();
            if (obj.messages) {
                messageAtention("messages_form");
            }
        } else {
            $("#pump").unblock();
            bootbox.alert(no_data_found);
        }
    });
}

function submitConfigurationGeral() {
    blockField("#geral");
    $.post("#", $("#form_config_geral").serialize()).done(function (data) {
        if (data) {
            obj = $.parseJSON(data);
            messages_json(obj, "messages_form");
            $("#geral").unblock();
            if (obj.messages) {
                messageAtention("messages_form");
            }
        } else {
            $("#geral").unblock();
            bootbox.alert(no_data_found);
        }
    });
}


function updateConfiguration() {
    var encodedURL = encodeURIComponent("view_status!comando!view_config");
    $.get(encodedURL).done(function (data) {
        if (data) {
            var obj = $.parseJSON(data);
            $("#area_base").val(obj.area_base);
        } else {
            bootbox.alert(no_data_found);
        }
    });
}

function updateSwitchButton() {
    $.get("view_status!comando!view_status").done(function (data) {
        if (data) {
            var obj = $.parseJSON(data);
            var estado = (obj.estado_atual == '1' ? true : false);
            $('#switch_pump').bootstrapSwitch('state', estado, true);
        } else {
            bootbox.alert(no_data_found);
        }
    });
}