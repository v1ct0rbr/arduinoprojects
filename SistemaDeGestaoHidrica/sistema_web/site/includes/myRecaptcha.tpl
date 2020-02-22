<script>
    {literal}
        var RecaptchaOptions = {
            custom_translations: {
                audio_challenge: 'deixe-me ouvir',
                refresh_btn: 'Recarregar código',
                help_btn: 'Ajuda'
            },
            theme: 'custom',
            custom_theme_widget: 'recaptcha_widget'
        };
    {/literal}
</script>
<div id="recaptcha_widget" style="display:none;">
    <div id="recaptcha_image"></div>
    <div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorreto. Tente Novamente</div>
    <div class="row">
        <div class="col-md-12">
            <a class="recaptcha_option" id="recaptcha_reload" tabindex="-1" href="javascript:Recaptcha.reload();" data-toggle="tooltip" title="{$reload_captcha}"><i class="fa fa-refresh fa-fw"></i></a>
            <a class="recaptcha_option recaptcha_only_if_image" tabindex="-1" href="javascript:Recaptcha.switch_type('audio')" data-toggle="tooltip" title="{$listen_captcha}"><i class="fa fa-volume-up fa-fw"></i></a>
            <a data-toggle="tooltip" data-placement="top" tabindex="-1" class="recaptcha_option recaptcha_only_if_audio" href="javascript:Recaptcha.switch_type('image')" title="{$change_for_image_captcha}"><i class="fa fa-image fa-fw"></i></a>
            <a class="recaptcha_option" tabindex="-1" href="javascript:Recaptcha.showhelp()" data-toggle="tooltip" title="{$help}"><i class="fa fa-info-circle fa-fw"></i></a>
        </div>
    </div>
    <div class="form-group">
        <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" placeholder="{$insert_code}" data-bv-notempty-message="{$captcha_not_empty}" class="form-control" onkeypress="" maxlength="30" required />
    </div>
</div>
<script type="text/javascript"
        src="http://www.google.com/recaptcha/api/challenge?k={$public_google_key}">
</script>
<noscript>
<iframe src="http://www.google.com/recaptcha/api/noscript?k={$public_google_key}"
        height="300" width="500" frameborder="0"></iframe><br>
<textarea name="recaptcha_challenge_field" rows="3" cols="40">
</textarea>
<input type="hidden" name="recaptcha_response_field"
       value="manual_challenge">
</noscript>