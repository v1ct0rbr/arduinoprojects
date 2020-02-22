<div class="messages" >
    {if $messages.error}
        {foreach from=$messages.error item="message"}
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="glyphicon glyphicon-remove"></i>
                {$message}
            </div>
        {/foreach}
    {/if}
    {if $messages.warning}
        {foreach from=$messages.warning item="message"}
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="glyphicon glyphicon-warning-sign"></i>
                {$message}
            </div>
        {/foreach}
    {/if}
    {if $messages.success}
        {foreach from=$messages.success item="message"}
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="glyphicon glyphicon-ok"></i>
                {$message}
            </div>
        {/foreach}
    {/if}
</div>
  
{include file="../includes/messages_ajax.tpl" div_messages=$div_messages cols=$cols }