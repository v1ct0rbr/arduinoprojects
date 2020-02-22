/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $("#form_logs").submit(function (e) {
        e.preventDefault();
        submitLog();
    });
    $("#delete_log").click(function () {
        bootbox.confirm("Apagar log selecionado?", function (result) {
            if (result) {
                excluirLog();
            }
        });
    });
    $("#submit_log").click(function () {
        $("#form_logs").submit();
    });
});
function excluirLog() {
    blockField("#form_logs");
    $.get("#!apagar_arquivo!true&ano_log=" + $("#ano_log").val() + "&mes_log=" + $("#mes_log").val()).done(function (data) {
        if (data) {
            try {
                obj = $.parseJSON(data);
                messages_json(obj, "messages_form");
                $("#geral").unblock();
                if (obj.messages) {
                    messageAtention("messages_form");
                }
            } catch (e) {

            } finally {
                $("#form_logs").unblock();
            }
        } else {
            $("#form_logs").unblock();
        }
    });
}

function submitLog() {


    blockField("#form_logs");
    mostrarLog(false);
    $.post("#", $("#form_logs").serialize()).done(function (dataObj) {
        if (dataObj) {
            try {
                obj = $.parseJSON(dataObj);
                if (dataObj.indexOf("erro") < 0) {
                    $("#log_title").html("LOG: " + $("#ano_log").val() + " - " + $("#mes_log").val());
                    $("#log_content").html("");
                    $("#log_content").append(obj.result);
                    var data = {
                        labels: [], // currently empty will contain all the labels for the data points
                        datasets: [
                            {
                                label: "Log Mensal",
                                fillColor: "rgba(220,220,220,0.2)",
                                strokeColor: "rgba(220,220,220,1)",
                                pointColor: "rgba(220,220,220,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: [] // currently empty will contain all the data points for bills
                            }
                        ]
                    };
                    $.each(obj.logdata.por_data, function (position, item) {
                        if (item) {
                            data.labels.push("Dia " + position);
                        } else {
                            data.labels.push('');
                        }
                        data.datasets[0].data.push(item);
                    });
                    respondCanvas("#myChart", data);
                    mostrarLog(true);
                } else {
                    mostrarLog(false);
                    messages_json(obj, "messages_form");
                    $("#form_logs").unblock();
                    if (obj.messages) {
                        messageAtention("messages_form");
                    }
                }
            } catch (e) {
                bootbox.alert("Erro na conversão de dados");
            } finally {
                $("#form_logs").unblock();
            }
        } else {
            $("#form_logs").unblock();
            bootbox.alert("Nada encontrado");
        }
    });
}

function mostrarLog(mostrar) {
    if (mostrar == true) {
        $("#panel_log").fadeIn();
        $("#myChart").fadeIn();
    } else {
        $("#panel_log").fadeOut();
        $("#myChart").fadeOut();
    }
}
