
<ul class="pagination">
    {if !$smarty.get.ajax}
        {foreach from=$paginacao item=pagina}
            {if $pagina.anterior}
                <li>
                    <a {if $pagina.ativo}href="#"{else} href="{$_URLSITE}/{$pagina.url}"{/if} aria-label="Previous">
                        <i class="fa fa-chevron-left"></i>
                    </a>
                </li>
            {/if}
            {if $pagina.item}
                <li {if $pagina.ativo}class="active"{/if}>
                    <a {if $pagina.ativo}href="#" {else} href="{$_URLSITE}/{$pagina.url}" class="inativo"{/if}>
                        {$pagina.index}
                    </a>
                </li>
            {/if}
            {if $pagina.proximo}
                <li>
                    <a {if $pagina.ativo}href="#"{else} href="{$_URLSITE}/{$pagina.url}"{/if}>
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </li>
            {/if}

        {/foreach}

    {else}

        {foreach from=$paginacao item=pagina}
            {if $pagina.anterior}
                <li>
                    <a  {if $pagina.ativo}href="#"{else} href="{$url_previous}" {/if}><i class="fa fa-chevron-left"></i></a>
                </li>
            {/if}
            {if $pagina.item}
                <li {if $pagina.ativo}class="active"{/if}>
                    <a {if $pagina.ativo}href="#" {else} href="{$pagina.url}" class="inativo"{/if}>
                        {$pagina.index}
                    </a>
                </li>
            {/if}
            {if $pagina.proximo}
                <li>
                    <a  {if $pagina.ativo}href="#"{else} href="{$url_next}"{/if}>
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </li>
            {/if}

        {/foreach}
    {/if}
  
</ul>
