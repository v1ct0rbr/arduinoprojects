{include file="../includes/header.tpl" cssc1="bootstrap-switch.min" css1="configuracao" gmap="true"}
{include file="../includes/menu.tpl"}

{*    {include file="../includes/messages.tpl" div_messages="messages_home" }*}
<div class="jumbotron">
    <div class="container">
        <h1>
            <!-- Nut Chanut https://www.iconfinder.com/Chanut-is -->
            <svg enable-background="new 0 0 100 100" height="100px" id="Layer_1" version="1.1" viewBox="0 0 100 100" width="100px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Setting"><path d="M86.139,41.691l-8.095-1.175c-0.276-0.762-0.539-1.506-0.864-2.219l4.987-6.622c1.406-1.882,1.123-4.653-0.673-6.448   l-5.846-5.854c-1.006-1.007-2.358-1.578-3.715-1.578c-1.006,0-1.947,0.32-2.73,0.904l-6.615,4.97   c-0.729-0.337-1.472-0.605-2.22-0.883l-1.179-7.984C58.85,12.447,56.68,11,54.141,11h-8.28c-2.539,0-4.709,1.447-5.048,3.803   l-1.18,7.96c-0.748,0.279-1.495,0.551-2.226,0.892l-6.611-4.96c-0.782-0.584-1.727-0.903-2.731-0.903   c-1.359,0-2.716,0.571-3.722,1.58l-5.856,5.852c-1.799,1.8-2.1,4.572-0.693,6.452l4.94,6.617c-0.337,0.728-0.665,1.473-0.941,2.225   l-7.928,1.175C11.567,42.023,10,44.147,10,46.741v8.276c0,2.594,1.565,4.719,3.862,5.051l8.097,1.176   c0.276,0.763,0.538,1.507,0.863,2.219l-4.987,6.622c-1.407,1.883-1.124,4.654,0.672,6.449l5.846,5.854   c1.005,1.008,2.356,1.582,3.713,1.582c1.006,0,1.951-0.313,2.733-0.896l6.614-4.954c0.728,0.337,1.473,0.635,2.221,0.913   l1.18,8.043C41.152,89.432,43.322,91,45.861,91h8.28c2.539,0,4.709-1.566,5.049-3.924l1.18-8.079   c0.742-0.276,1.488-0.548,2.227-0.892l6.611,4.959c0.779,0.584,1.725,0.903,2.73,0.903c1.358,0,2.717-0.571,3.724-1.579   l5.854-5.853c1.799-1.8,2.1-4.57,0.694-6.453l-4.94-6.615c0.34-0.733,0.666-1.479,0.941-2.225l7.93-1.175   C88.436,59.736,90,57.611,90,55.02v-8.277C90,44.147,88.436,42.023,86.139,41.691z M73.882,58.236   c-0.455,1.479-1.06,2.935-1.796,4.324l-0.749,1.407l6.683,8.925c-0.017,0.025-0.037,0.056-0.068,0.086l-5.854,5.856   c-0.027,0.028-0.056,0.052-0.08,0.067l-8.929-6.666l-1.407,0.75c-1.434,0.761-2.888,1.378-4.326,1.82l-1.523,0.488L54.236,86.68   C54.211,86.688,54.18,87,54.141,87h-8.28c-0.036,0-0.067-0.313-0.093-0.318l-1.596-11.3l-1.526-0.563   c-1.474-0.451-2.928-1.086-4.324-1.824l-1.409-0.764l-8.941,6.664c-0.021-0.015-0.043-0.037-0.066-0.06l-5.852-5.856   c-0.026-0.025-0.049-0.054-0.065-0.076l6.692-8.932l-0.76-1.412c-0.703-1.324-1.304-2.738-1.791-4.324l-0.514-1.521l-11.193-1.574   C14.419,55.104,14,55.063,14,55.02v-8.277c0-0.045,0.419-0.085,0.424-0.12l11.112-1.575l0.526-1.521   c0.456-1.482,1.09-2.938,1.825-4.325l0.762-1.408l-6.674-8.926c0.016-0.025,0.041-0.054,0.072-0.085l5.854-5.854   c0.028-0.028,0.058-0.049,0.083-0.066l8.929,6.671l1.409-0.744c1.436-0.762,2.89-1.363,4.324-1.804l1.524-0.457L45.765,15.2   c0.025-0.007,0.058-0.2,0.096-0.2h8.28c0.037,0,0.068,0.191,0.094,0.198l1.597,11.214l1.524,0.528   c1.486,0.457,2.94,1.092,4.324,1.827l1.409,0.761l8.94-6.665c0.02,0.016,0.043,0.037,0.066,0.061l5.85,5.854   c0.027,0.027,0.051,0.055,0.066,0.078l-6.689,8.932l0.758,1.411c0.693,1.311,1.313,2.765,1.791,4.325l0.516,1.521l11.189,1.575   C85.581,46.656,86,46.696,86,46.741v8.276c0,0.047-0.419,0.086-0.424,0.121l-11.111,1.574L73.882,58.236z"/><g><path d="M50.001,67.971c-9.61,0-17.428-7.82-17.428-17.43c0-9.61,7.818-17.429,17.428-17.429c9.608,0,17.429,7.818,17.429,17.429    C67.43,60.15,59.609,67.971,50.001,67.971z M50.001,37.187c-7.363,0-13.354,5.991-13.354,13.354    c0,7.363,5.991,13.354,13.354,13.354c7.362,0,13.354-5.988,13.354-13.354C63.354,43.178,57.363,37.187,50.001,37.187z"/></g></g></svg>
            CONFIGURAÇÃO
        </h1>
    </div>
</div>
<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-12">
            {include file="../includes/messages.tpl" div_messages="messages_form" }
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#controle">Controle</a></li>
                <li><a data-toggle="tab" href="#configuracoes">Configurações</a></li>

            </ul>
            <div class="tab-content ">
                <div id="controle" class="tab-pane active ">
                    <h3>Controle o estado da bomba d'agua</h3>
                    <h6>Lembre-se de verificar se a bomba está configurada para ligar/desligar automaticamente</h6>
                    <div class="switch-wrapper">
                        <input id="switch_pump" type="checkbox" name="my-checkbox" checked>
                            {*                        <input type="checkbox" value="1" checked>*}
                    </div>
                    <blockquote class="blockquote-reverse">
                        <h5> O estado da bomba d'agua é atualizado de 10 em 10 segundos</h5>
                    </blockquote>
                </div>
                <div id="configuracoes" class="tab-pane fade in">
                    <div id="geral" class="col-md-6">
                        <h3>CONFIGURAÇÕES GERAIS</h3>
                        <form id="form_config_geral" method="post" action="#">
                            <div class="form-group">
                                <label for="area_base">Timezone: </label>
                                <select name="timezone" class="form-control input-sm">
                                    {foreach from=$timezones item="tz" }
                                        <option value="{$tz.valor}" {if $timezone == $tz.valor}selected="true"{/if}>{$tz.titulo}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="col-md-12" style="text-align: center;">
                                <input id="submit_config_geral" name="submit" type="button" class="btn btn-primary btn-lg" value="Enviar">
                            </div>
                            <input type="hidden" name="configuracoes_gerais" value="true" />
                        </form>
                        <br /> <hr /> <br />
                    </div>

                    <div id="pump" class="col-md-6">
                        <h3>CONFIGURAÇÕES DO CONTAINER</h3>
                        <form id="form_config_container" method="post" action="#" >
                            <div class="form-group">
                                <label for="distancia_correcao">Distância de correção (em CM): <span data-toggle="tooltip" data-placement="right" title="posição do sensor em relação ao topo da caixa">(?)</span></label>
                                <input type="number" step="any" id="distancia_correcao" name="distancia_correcao" value="{$distancia_correcao}" required="true" class="form-control input-sm" maxlength="5" >
                            </div>
                            <div class="form-group">
                                <label for="area_base">Área da base (em CM&sup2;): </label>
                                <input type="number" step="any" id="area_base" name="area_base" value="{$area_base}" required="true" class="form-control input-sm" maxlength="5">
                            </div>
                            <div class="form-group">
                                <label for="altura">Altura (em CM): <span data-toggle="tooltip" data-placement="right" title="Altura da caixa d'agua">(?)</span></label>
                                <input type="number" step="any" id="altura" name="altura" value="{$altura}" required="true" class="form-control input-sm" maxlength="5">
                            </div>
                            <div class="form-group">
                                <label for="nivel_minimo">Nível mínimo de água (em CM): <span data-toggle="tooltip" data-placement="right" title="Nível mínimo antes de ligar a bomba">(?)</span></label>
                                <input type="number" step="any" id="nivel_minimo" name="nivel_minimo" value="{$nivel_minimo}" required="true" class="form-control input-sm" maxlength="3">
                            </div>
                            <div class="form-group">
                                <label for="nivel_maximo">Nível máximo de água (em CM): <span data-toggle="tooltip" data-placement="right" title="Nível máximo de água antes de desligar a bomba">(?)</span></label>
                                <input type="number" step="any" id="nivel_maximo" name="nivel_maximo" value="{$nivel_maximo}" required="true" class="form-control input-sm"  maxlength="3">
                            </div>
                            <hr />
                            <div class="form-group">
                                <label for="vazao">Vazão da água (em Litros / minuto): </label>
                                <input type="number" step="any" id="vazao" name="vazao" value="{$vazao}" class="form-control input-sm"  maxlength="3">
                            </div>

                            <div class="form-group">
                                <label for="tempo_espera">Tempo de espera: <span data-toggle="tooltip" data-placement="right" title="tempo de espera para começar a medir o nível após ligamento/desligamento">(?)</span></label>
                                <input type="number" step="any" id="tempo_espera" name="tempo_espera" value="{$tempo_espera}"  required="true" class="form-control input-sm"  maxlength="3">
                            </div>
                            <div class="form-group">
                                <label for="nivel_maximo">Permitir Ligamento automático da bomba: <span data-toggle="tooltip" data-placement="right" title="Nível máximo de água antes de desligar a bomba">(?)</span></label>
                                <select name="permitir_ligamento_automatico" class="form-control">
                                    <option value="1" {if $permitir_ligamento_automatico == "1"}selected="true"{/if}>SIM</option>  
                                    <option value="0" {if $permitir_ligamento_automatico == "0"}selected="true"{/if}>NÃO</option>  
                                </select>
                            </div>
                            <div class="form-group col-md-12" style="text-align: center;">
                                <input id="submit_config_pump" name="submit" type="button" class="btn btn-primary btn-lg" value="Enviar">
                            </div>
                            <input type="hidden" name="configuracoes_bomba" value="true" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {include file="../includes/footer.tpl"  jsc1="jquery-ui.min" jsc2="bootstrap-switch.min" jsc3="seekAttention.jquery" js1="configuracao" }