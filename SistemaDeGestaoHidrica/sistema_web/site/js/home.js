/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    data = {
        labels: [], // currently empty will contain all the labels for the data points
        datasets: [
            {
                label: "Tempo Real",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [] // currently empty will contain all the data points for bills
            }
        ]
    };
    data.labels.push(dataFormatada());
    data.datasets[0].data.push(volume_atual);
    respondCanvas("#myChart", data);
    setInterval(function () {
        updateStatus();
    }, 7000);
});

function updateStatus() {
    var count;
    var encodedURL = encodeURIComponent("view_status!comando!view_status");
    $.get(encodedURL).done(function (dataObj) {
        if (dataObj) {
            if (dataObj.indexOf('erro') < 0) {
                try {
                    var obj = $.parseJSON(dataObj);
                    $("#volume_total").html(obj.volume_total);
                    $("#volume_atual").html(obj.volume);
                    $("#volume_minimo").html(obj.volume_minimo);
                    $("#volume_maximo").html(obj.volume_maximo);
                    $(".progress-bar").attr("aria-valuenow", obj.volume);
                    $(".progress-bar").attr("aria-valuemax", obj.volume_total);
                    $(".progress-bar").css("width", ((obj.volume / obj.volume_total) * 100) + "%");
                    if (data.datasets[0].data.length > 10) {
                        data.labels.shift();
                        data.datasets[0].data.shift();
                    }
                    if (obj.estado_atual == 1) {
                        $('#image_status').removeClass("desligado");
                        $('#image_status').addClass("ligado");
                        $('#status_bomba').html("Ligado");

                    } else {
                        $('#image_status').removeClass("ligado");
                        $('#image_status').addClass("desligado");
                        $('#status_bomba').html("Desligado");
                    }
                    if (ultimoEstado != obj.estado_atual) {
                        $("ul#lista_eventos").append("<li>" + obj.ultimo_evento + "</li>");
                        ultimoEstado = obj.estado_atual;
                        if (obj.estado_atual == 1) {
                            data.labels.push("Lig(" + dataFormatada() + ")");
                        } else {
                            data.labels.push("Desl(" + dataFormatada() + ")");
                        }
                    } else {
                        data.labels.push(dataFormatada());
                    }
                    data.datasets[0].data.push(obj.volume);
                    respondCanvas("#myChart", data);
                    $("#status_bomba").html((ultimoEstado == 1 ? "Ligado" : "Desligado"));
                    count = $("ul#lista_eventos li").length;
                    if (count > 5) {
                        $("ul#lista_eventos").find('li:first').remove();
                    }
                } catch (e) {
                    erro = true;
                    bootbox.alert("erro de conversão de dados");
                    return false;
                }
            } else {
                bootbox.alert(data);
            }
        } else {
            bootbox.alert(no_data_found);
        }
    });
}