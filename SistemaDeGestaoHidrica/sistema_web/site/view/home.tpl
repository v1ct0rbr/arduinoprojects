{include file="../includes/header.tpl" css1="home"}
{include file="../includes/menu.tpl"}
<script>
    var ultimoEstado = "{$estado_atual}";
    var volume_atual = {$volume};
    var erro = false;
    var data;
    
</script>
<div class="jumbotron">
    <div class="container">
        <h1>
            <svg enable-background="new 0 0 64 64" height="64px" id="Layer_1" version="1.1" viewBox="0 0 64 64" width="64px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><g><circle cx="24.135" cy="6.427" fill="#241F20" r="5.867"/></g><g><path d="M56.198,24.387c-4.308-3.028-8.367-4.585-13.277-4.423c-7.354,0.18-11.192,4.412-12.808,5.883    c-1.613,1.471-3.263,2.405-6.315,3.336c-6.568,1.824-11.668-1.63-13.583-3.222c-0.004-0.003-0.008-0.003-0.012-0.007    c-0.713-0.538-1.107-0.699-1.32-0.744H7.666c-0.914,0-1.079,1.073-1.102,1.647c0,5.239,0,21.359,0,23.309    c0.269,2.333,0.664,3.625,2.784,5.311c2.12,1.687,4.767,1.439,4.767,1.439s34.616-0.005,36.51-0.007    c1.854-0.144,3.63-0.68,5.239-2.607c1.608-1.928,1.567-4.136,1.567-4.136s0.003-15.806,0.007-23.21    C57.434,25.56,56.534,24.671,56.198,24.387z M18.268,45.802c-2.814,0-5.094-2.28-5.094-5.094s2.28-5.094,5.094-5.094    c2.813,0,5.094,2.28,5.094,5.094S21.081,45.802,18.268,45.802z M45.585,50.977c-3.529,0-6.388-2.858-6.388-6.386    c0-3.528,2.858-6.387,6.388-6.387c3.526,0,6.385,2.858,6.385,6.387C51.97,48.118,49.111,50.977,45.585,50.977z" fill="#241F20"/></g><g><path d="M63.946,15.262c-0.007-1.353-0.906-1.483-1.2-1.49h-1.098c-1.301,0-1.242,1.424-1.242,1.424l0,0    c0.004,7.106,0.021,38.821-0.003,39.435c-0.028,0.692-0.166,2.464-1.855,3.987c-1.827,1.467-3.654,1.273-3.654,1.273    s-45.568,0-46.647-0.056c-0.858-0.139-2.353-0.443-3.626-2.132s-1.024-3.903-1.024-3.903V15.334c0-1.294-0.792-1.53-1.222-1.562    H1.354c-1.069,0-1.272,0.835-1.302,1.315c0,6.673,0,36.977,0,39.489c0,2.823,1.024,5.066,3.495,7.049s5.364,1.81,5.364,1.81    s44.543,0,46.482-0.005c1.938-0.005,4.484-0.881,6.585-3.286c2.101-2.404,1.969-5.567,1.969-5.567V15.262z" fill="#241F20"/></g></g></svg>
            WATER PUMP VIEWER
        </h1>
    </div>
</div>
<div class="container">
    <!-- Example row of columns -->
    <div class="row">
            <div class="col-md-12">

                <canvas id="myChart" width="400" height="200"></canvas>
            </div>
        </div>
    <hr>
    
    <div class="row">
        <div class="col-md-4">
            <h2 class="text-center"> Status da bomba</h2>
            <h4 style="text-align: center;">
                <svg id="image_status {if $estado_atual == 1}ligado{else}desligado{/if}" enable-background="new 0 0 64 64" height="64px" id="Layer_1" version="1.1" viewBox="0 0 64 64" width="64px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M56.826,32C56.826,18.311,45.689,7.174,32,7.174S7.174,18.311,7.174,32S18.311,56.826,32,56.826S56.826,45.689,56.826,32z   M34.437,31.962c0,1.301-1.054,2.356-2.356,2.356c-1.301,0-2.356-1.055-2.356-2.356V19.709c0-1.301,1.055-2.356,2.356-2.356  c1.301,0,2.356,1.054,2.356,2.356V31.962z M48.031,32.041c0,8.839-7.191,16.03-16.031,16.03s-16.031-7.191-16.031-16.03  c0-4.285,1.669-8.313,4.701-11.34c0.46-0.46,1.062-0.689,1.665-0.689s1.207,0.23,1.667,0.691c0.92,0.921,0.919,2.412-0.002,3.332  c-2.139,2.138-3.318,4.981-3.318,8.006c0,6.24,5.077,11.317,11.318,11.317s11.318-5.077,11.318-11.317  c0-3.023-1.176-5.865-3.314-8.003c-0.92-0.921-0.919-2.412,0.001-3.333c0.921-0.921,2.412-0.919,3.333,0.001  C46.364,23.734,48.031,27.76,48.031,32.041z"/></svg>
                <br />
                <span class="text-center" id="status_bomba" >{if $estado_atual == 1}Ligado{else}Desligado{/if}</span>
            </h4>
        </div>
        <div class="col-md-4 com_borda">
            <h2 class="text-center">Volume</h2>
            <h5 class="text-center">
                <br />
                <div class="progress" style="text-align: center;">
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{$volume}" aria-valuemin="0" aria-valuemax="{$volume_total}" style="width: 20%">
                    </div>
                </div>
            </h5>                    
            <ul>
                <li><b>Volume:</b> <span id="volume_atual">{$volume}</span> de <span id="volume_total">{$volume_total}</span> Litro(s)&nbsp;&nbsp;&nbsp;</li>
                <li><b>Volume mínimo:</b> <span id="volume_minimo">{$volume_minimo}</span> Litro(s)&nbsp;&nbsp;&nbsp;</li>
                <li><b>Volume máximo:</b> <span id="volume_maximo">{$volume_maximo}</span> Litro(s)</li>
            </ul>
        </div>
        <div class="col-md-4 com_borda">
            <h2 class="text-center"> Events</h2>
            <br />
            <ul id="lista_eventos">
                {if $ultimo_evento}<li>{$ultimo_evento}</li>{/if}
            </ul>
        </div>
    </div>
    
        

        <div class="row">
            <div class="col-md-12">
                <blockquote class="blockquote-reverse">
                    <h5> Todos os valores são atualizados de 10 em 10 segundos</h5>
                </blockquote>
            </div>
        </div>
        {include file="../includes/footer.tpl"  jsc1="chart/Chart.min" js1="home"  }