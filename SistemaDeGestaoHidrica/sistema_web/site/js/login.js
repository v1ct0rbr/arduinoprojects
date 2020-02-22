/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $("#senha").on("keydown", function (event) {
        if (event.which == 13) {
            $("#form_login").submit();
        }
    });

    $("#login_submit").click(function (e) {
        $("#form_login").submit();
    });

    $("#form_login").submit(function (e) {
        e.preventDefault();
        submeterLogin();
    });

    function submeterLogin() {
        blockField("#form_panel");
        $.post("#", $("#form_login").serialize(), "json").done(function (data) {
            if (data) {
                obj = $.parseJSON(data);
                $("#form_panel").unblock();
                messages_json(obj, 'messages2');
                setTimeout(function () {
                    if (obj.messages.success) {
                        $.each(obj.messages.success, function (i, item) {
                            if (item.indexOf("Login bem sucedido") >= 0) {
                                window.location.replace("home");
                            }
                        });
                    }
                }, 2000);
            } else {
                $("#form_panel").unblock();
            }
        });
    }

}
);