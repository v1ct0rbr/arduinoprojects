{include file="../includes/header.tpl" css1="home" gmap="true"}
{include file="../includes/menu.tpl"}

{*    {include file="../includes/messages.tpl" div_messages="messages_home" }*}

<div class="jumbotron">
    <div class="container">
        <h1>
            <svg height="56.25" id="svg2" version="1.1" width="56.25" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg"><defs id="defs6"><clipPath id="clipPath16"><path d="M 0,0 0,45 45,45 45,0 0,0" id="path18"/></clipPath></defs><g id="g10" transform="matrix(1.25,0,0,-1.25,0,56.25)"><g id="g12"><g clip-path="url(#clipPath16)" id="g14"><g id="g20"><g id="g22"><g id="g24"><path d="m 9.347,6.027 0,32.946 c 0,0.843 0.684,1.527 1.527,1.527 l 13.349,0 11.43,-11.43 0,-23.043 C 35.653,5.184 34.969,4.5 34.126,4.5 l -23.252,0 c -0.843,0 -1.527,0.684 -1.527,1.527 z" id="path26" style="fill:#2b2b2b;fill-opacity:1;fill-rule:evenodd;stroke:none"/></g></g><g id="g28"><g id="g30"><path d="m 24.223,40.5 11.43,-11.43 -9.903,0 c -0.843,0 -1.527,0.684 -1.527,1.527 l 0,9.903 z" id="path32" style="fill:#525252;fill-opacity:1;fill-rule:evenodd;stroke:none"/></g></g><g id="g34"><g id="g36"><path d="m 16.154,9.325 0,-0.663 -2.716,0 0,5.514 0.772,0 0,-4.851 1.944,0 z" id="path38" style="fill:#e6e6e6;fill-opacity:1;fill-rule:nonzero;stroke:none"/></g></g><g id="g40"><g id="g42"><path d="m 21.394,13.477 c 0.549,-0.52 0.824,-1.209 0.824,-2.066 0,-0.857 -0.275,-1.546 -0.824,-2.066 -0.548,-0.52 -1.222,-0.781 -2.021,-0.781 -0.798,0 -1.472,0.261 -2.021,0.781 -0.549,0.52 -0.823,1.209 -0.823,2.066 0,0.857 0.274,1.546 0.823,2.066 0.549,0.52 1.223,0.781 2.021,0.781 0.799,0 1.473,-0.261 2.021,-0.781 z M 20.835,9.858 c 0.394,0.392 0.591,0.915 0.591,1.571 0,0.655 -0.197,1.179 -0.591,1.57 -0.395,0.392 -0.882,0.587 -1.462,0.587 -0.58,0 -1.067,-0.195 -1.461,-0.587 -0.394,-0.391 -0.591,-0.915 -0.591,-1.57 0,-0.651 0.197,-1.173 0.591,-1.567 0.394,-0.394 0.881,-0.591 1.461,-0.591 0.58,0 1.067,0.195 1.462,0.587 z" id="path44" style="fill:#e6e6e6;fill-opacity:1;fill-rule:nonzero;stroke:none"/></g></g><g id="g46"><g id="g48"><path d="m 27.962,11.604 0,-2.142 C 27.366,8.866 26.586,8.567 25.621,8.564 c -0.799,0 -1.467,0.264 -2.006,0.793 -0.538,0.528 -0.807,1.216 -0.807,2.064 0,0.843 0.267,1.526 0.801,2.05 0.535,0.524 1.203,0.787 2.004,0.787 0.89,0 1.62,-0.307 2.189,-0.921 l 0.039,-0.039 -0.527,-0.488 c -0.447,0.523 -1.014,0.784 -1.701,0.784 -0.58,0 -1.059,-0.196 -1.438,-0.587 -0.378,-0.392 -0.568,-0.92 -0.568,-1.586 0,-0.661 0.195,-1.188 0.584,-1.582 0.389,-0.395 0.878,-0.592 1.469,-0.592 0.666,0 1.164,0.149 1.494,0.445 l 0.055,0.059 0,1.221 -1.487,0 0,0.632 2.24,0 z" id="path50" style="fill:#e6e6e6;fill-opacity:1;fill-rule:nonzero;stroke:none"/></g></g></g></g></g></g></svg>
            LOGS
        </h1>
    </div>
</div>

<div class="container">

    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-3">
            <form id="form_logs" action="#" method="post">
                <div class="form-group">
                    <label class="label label-default" for="ano_log"> ANO</label>
                    <select name="ano_log" id="ano_log" class="form-control">
                        {foreach from=$anos item="a"}
                            <option value="{$a}" {if $a == $ano_atual}selected="true"{/if}>{$a}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="form-group">
                    <label class="label label-default" for="mes_log">MÊS</label>
                    <select name="mes_log" id="mes_log" class="form-control">
                        <option value="01" {if $mes_atual == "01"}selected="true"{/if}>Janeiro</option>
                        <option value="02" {if $mes_atual == "02"}selected="true"{/if}>Fevereiro</option>
                        <option value="03" {if $mes_atual == "03"}selected="true"{/if}>Março</option>
                        <option value="04" {if $mes_atual == "04"}selected="true"{/if}>Abril</option>
                        <option value="05" {if $mes_atual == "05"}selected="true"{/if}>Maio</option>
                        <option value="06" {if $mes_atual == "06"}selected="true"{/if}>Junho</option>
                        <option value="07" {if $mes_atual == "07"}selected="true"{/if}>Julho</option>
                        <option value="08" {if $mes_atual == "08"}selected="true"{/if}>Agosto</option>
                        <option value="09" {if $mes_atual == "09"}selected="true"{/if}>Setembro</option>
                        <option value="10" {if $mes_atual == "10"}selected="true"{/if}>Outubro</option>
                        <option value="11" {if $mes_atual == "11"}selected="true"{/if}>Novembro</option>
                        <option value="12" {if $mes_atual == "12"}selected="true"{/if}>Dezembro</option>
                    </select>
                </div>
                <input type="button" value="abrir log" class="btn btn-info" id="submit_log" />
                {*                    <input type="button" value="excluir log" class="btn btn-danger" id="delete_log" />*}
            </form>
        </div>
        <div>

        </div>
        <div class="col-md-9 com_borda" id="log_result" >
            {include file="../includes/messages.tpl" div_messages="messages_form" }
            <canvas id="myChart" width="400" height="300" ></canvas><br />
            <div class="panel panel-default" id="panel_log" style="display: none">
                <div class="panel-heading">
                    <h3 class="panel-title" id="log_title"></h3>
                </div>
                <div class="panel-body" id="log_content">

                </div>
            </div>
        </div>
    </div>
    <hr>

        {include file="../includes/footer.tpl"  jsc1="chart/Chart.min" js1="logs"  }