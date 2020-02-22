<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>
            <a class="navbar-brand" href="#">

            </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            {if $smarty.session.dados_sessao.login != null}
                <ul class="nav navbar-nav ">
                    <li class="{if $smarty.get.pg == 'home' || $smarty.get.pg == 'status'}active{/if} right" ><a href="home{$_EX}">Status<span class="sr-only">(current)</span></a></li>
                    <li role="separator" class="divider"></li>
                    <li class="{if $smarty.get.pg == 'configuracao'}active{/if}"><a href="configuracao{$_EX}">Configuração</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="{if $smarty.get.pg == 'logs'}active{/if}"><a href="logs{$_EX}">Logs</a></li>
                </ul>
            {/if} 
            <ul class="nav navbar-nav navbar-right">
                {if $smarty.session.dados_sessao.login == null}
                    <li class="{if $smarty.get.pg == 'login'}active{/if} right" ><a href="login{$_EX}">Login<span class="sr-only">(current)</span></a></li>
                    {else}
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{$smarty.session.dados_sessao.login}<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="login{$_EX}!sair!true">Sair</a></li>
                        </ul>
                    </li>
                {/if}

            </ul>
        </div>
    </div>
</nav>