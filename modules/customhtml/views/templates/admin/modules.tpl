<div class="panel">    
    <div class="panel-heading">
        {l s='List Modules' mod='customhtml'}
        <span class="panel-heading-action">            
            <a href="javascript:void(0)" onclick="showModal('modalModule')" class="list-toolbar-btn link-add" title="{l s='Add new module'}"><i class="process-icon-new"></i></a>
        </span>
    </div>
    <div class="panel-body" style="padding:0">
        <div class="table-responsive">
            <table class="table" id="moduleList">
                <thead>
                    <tr class="nodrag nodrop">
                        <th width="50" class="center">{l s='ID' mod='customhtml'}</th>
                        <th>{l s='Name' mod='flexmegamenus'}</th>
                        <th width="200">{l s='Position' mod='customhtml'}</th>
                        <th width="200">{l s='Layout' mod='customhtml'}</th>
                        <th width="100" class="center">{l s='Ordering' mod='customhtml'}</th>
                        <th width="50" class="center">{l s='Status' mod='customhtml'}</th>
                        <th class="center" width="50">#</th>
                    </tr>
                </thead>
                <tbody>
                    {if $items|@count >0}
                    {foreach from=$items item=item}
                    <tr id="mo_{$item.id}">
                        <td class="center">{$item.id}</td>
                        <td>{$item.name}</td>                
                        <td>{$item.position_name}</td>                    
                        <td>{$item.layout_value}</td>
                        <td class="pointer dragHandle center" ><div class="dragGroup"><div class="positions">{$item.ordering}</div></div></td>
                        <td class="center">
                            {if $item.status == '1'}
                                <a title="Enabled" class="list-action-enable action-enabled lik-module-status" item-id="{$item.id}" value="{$item.status}"><i class="icon-check"></i></a>
                            {else}
                                <a title="Disabled" class="list-action-enable action-disabled lik-module-status" item-id="{$item.id}" value="{$item.status}"><i class="icon-check"></i></a>
                            {/if}
                        </td>
                        <td class="center"><a href="javascript:void(0)" item-id="{$item.id}" class="lik-module-edit"><i class="icon-edit"></i></a>&nbsp;<a href="javascript:void(0)" item-id="{$item.id}" class="lik-module-delete"><i class="icon-trash" ></i></a></td>
                    </tr>
                    {/foreach}
                    {/if}    
                </tbody>    
           </table>            
        </div>        
    </div> 
</div>


<div id="modalModule" class="modal fade" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title"><i class="icon-cloud"></i>{l s=' Add or edit module' mod='customhtml'}</span>
            </div>
            <div class="modal-body form-horizontal" id="forgotBody">
                <form id="frmModule">{$moduleForm}</form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveModule()"><i class="icon-save"></i> {l s='Save' mod='customhtml'}</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
	$(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
    		e.stopImmediatePropagation();
    	}
    });
    var iso = "{$iso}";
    var ad = "{$ad}";
    var secure_key = "{$secure_key}";
    var currentUrl = "{$currentUrl}";
    var baseModuleUrl = "{$baseModuleUrl}";
    var moduleId = '0';        
    var moduleFormNew = '';
</script>