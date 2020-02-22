<!DOCTYPE HTML>
<html class="no-js">
    <head>
        <!-- Basic Page Needs
          ================================================== -->
        <title>water pump controller</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="Victor Queiroga - VivaSoft">
        <meta charset="UTF-8"> 
        <!-- Mobile Specific Metas
          ================================================== -->
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="format-detection" content="telephone=no">
        <!-- CSS
          ================================================== -->
        {*        <link href="css/bootstrap.css" rel="stylesheet" type="text/css">*}
        <link href="{$_CSS}/animate.css" rel="stylesheet" type="text/css">
        <link href="{$_CSS}/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="{$_CSS}/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="css/main.css" rel="stylesheet" type="text/css">
        <link href="css/login.css" rel="stylesheet" type="text/css">
        <!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="css/ie8.css" media="screen" /><![endif]-->
        <!-- Color Style -->
        <link rel="icon" type="image/png" sizes="16x16" href="{$_IMG_SITE}/favicon.ico">
        <!-- SCRIPTS ================================================== -->

    </head>
    <body>
        <!--[if lt IE 7]>
                <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->

        <div id="wrapper">

            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">
                                <i class="glyphicon glyphicon-lock"></i>
                                Login Administrativo</h2>
                        </div>
                        <div class="panel-body" id="form_panel">
                            {include file="../includes/messages.tpl" div_messages="messages2" }
                            <form role="form" action="#" method="post" id="form_login">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control " placeholder="*Login" name="login" id="login" type="text" required {if $smarty.cookies.login_remember}value="{$smarty.cookies.login_remember}"{else} autofocus{/if} maxlength="50">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="*Senha" name="senha" id="senha" type="password" value="" required {if $smarty.cookies.login_remember}autofocus{/if} maxlength="10">
                                    </div>

                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="button" id="login_submit" class="btn btn-lg btn-success btn-block" value="Login">
                                </fieldset>
                                <input type="hidden" name="back_url" id="back_url" value="{$back_url}" />
                                {if $param1}
                                    <input type="hidden" name="param1" value="{$paramValue1}" />
                                {/if}

                                <input type="hidden" name="param2" value="" />
                                <input type="hidden" name="param3" value="" />
                                <input type="hidden" name="param4" value="" />
                                <input type="hidden" name="param5" value="" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {include file="../includes/footer.tpl" js1="login" jsc1="seekAttention.jquery" show_content="-1" }