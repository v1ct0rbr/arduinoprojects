//var rightKey, leftKey, topKey, bottomKey;
$(document).ready(function () {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });


});



function blockField(field) {
    $(field).block({
        message: '<h1><img src=' + "\"assets/img/loading.gif\"" + ' alt=""/></h1>',
        css: {border: 'none',
            padding: '15px', backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff'}
    });
}

$(function () {
    $('.close-panel-danger').click(function () {
        $('.panel-danger').fadeOut();
    });
    $('.close-panel-warning').click(function () {
        $('.panel-warning').fadeOut();
    });
    $('.close-panel-success').click(function () {
        $('.panel-success').fadeOut();
    });
    $('.close-panel-messages').click(function () {
        $('.messages2').fadeOut();
    });
});

function messages_json(obj, div_messages) {
    $("div.messages").empty();
    $("div." + div_messages + " div.panel-body").empty();
    if (obj.messages) {
        $("div." + div_messages).fadeIn();
        if (obj.messages.error) {
            $.each(obj.messages.error, function (i, item) {
                $("div." + div_messages + " div.panel-body").append('<div class="alert alert-danger alert-dismissable"> \n\
<button type="button" class="close" data-dismiss="alert" \n\
aria-hidden="true">×</button> <i class="glyphicon glyphicon-remove"></i> ' + item + '</div>');
            });

        }
        if (obj.messages.warning) {
            $.each(obj.messages.warning, function (i, item) {
                $("div." + div_messages + " div.panel-body").append('<div class="alert alert-warning alert-dismissable"> \n\
<button type="button" class="close" data-dismiss="alert" \n\
aria-hidden="true">×</button><i class="glyphicon glyphicon-warning-sign"></i> ' + item + '</div>');
            });

        }
        if (obj.messages.success) {
            $.each(obj.messages.success, function (i, item) {
                $("div." + div_messages + " div.panel-body").append('<div class="alert alert-success alert-dismissable"> \n\
<button type="button" class="close" data-dismiss="alert" \n\
aria-hidden="true">×</button> <i class="glyphicon glyphicon-ok"></i> ' + item + '</div>');
            });
        }
        $(".close-" + div_messages).click(function () {
            $("div." + div_messages).fadeOut();
        });
        messageAtention(div_messages);
    }
}

function messageAtention(div_messages) {
    $("." + div_messages).seekAttention({
        pulse: false
    });
    setTimeout(function () {
        $(".sa-overlay, .sa-pulse-overlay").fadeOut();
        $("." + div_messages).fadeOut();
        slideScroll(".main");
    }, 4000);
}

function slideScroll(field) {
    var catTopPosition = $(field).offset().top;
    jQuery('html, body').animate({scrollTop: catTopPosition}, 'slow');
    return false;
    $(field).parent().click(function () {
        $('html, body').animate({scrollTop: 0}, 'slow');
        return false;
    });
}

var formatTime = function (unixTimestamp) {
    var dt = new Date(unixTimestamp * 1000);

    var hours = dt.getHours();
    var minutes = dt.getMinutes();
    var seconds = dt.getSeconds();
    var dia = dt.getDate();
    var mes = dt.getMonth() + 1;
    var ano = dt.getFullYear();

    // the above dt.get...() functions return a single digit
    // so I prepend the zero here when needed
    if (hours < 10)
        hours = '0' + hours;

    if (minutes < 10)
        minutes = '0' + minutes;

    if (seconds < 10)
        seconds = '0' + seconds;

    if (dia < 10)
        dia = '0' + dia;
    if (mes < 10)
        mes = '0' + mes;

    return dia + "/" + mes + "/" + ano + " às " + hours + ":" + minutes + ":" + seconds;
}

function dataFormatada() {
    var dt = new Date();
    var hours = dt.getHours();
    var minutes = dt.getMinutes();
    var seconds = dt.getSeconds();
    if (hours < 10)
        hours = '0' + hours;

    if (minutes < 10)
        minutes = '0' + minutes;

    if (seconds < 10)
        seconds = '0' + seconds;
    dataHora = (hours + ":" + minutes + ":" + seconds);
    return dataHora;
}

function invalidSessionRedirect(dados) {
    if (dados.indexOf('fim_de_sessao') >= 0) {
        document.location = URLSITE + '/login' + EX + '!expirado!1';

    }
    if (dados.indexOf('usuario_nao_logado') >= 0) {
        document.location = URLSITE + '/login' + EX + '!autenticacao!1';
    }
}

function ajaxRequest() {
    $.get("#!ajax_request!1").done(function (dados) {
        if (dados) {
            invalidSessionRedirect(dados);
            if (dados.indexOf('fim_de_sessao') < 0 || dados.indexOf('usuario_nao_logado') < 0) {
                return "1";
            } else {
                alert("Sessão expirada!");
                return "0";
            }
        } else {
            return "1";
        }
    });
}

function respondCanvas(elem, data) {
    var c = $(elem);
    var ctx = c.get(0).getContext("2d");
    var container = c.parent();

    var $container = $(container);

    c.attr('width', $container.width()); //max width

    c.attr('height', $container.height()); //max height                   

    //Call a function to redraw other content (texts, images etc)
    new Chart(ctx).Line(data, {
        bezierCurve: false
    });
}