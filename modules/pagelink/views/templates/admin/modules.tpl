<div class="panel">    
    <div class="panel-heading">
        {l s='List Modules' mod='flexgroupmenus'}
        <span class="panel-heading-action">            
            <a href="javascript:void(0)" onclick="showModal('modalModule')" class="list-toolbar-btn link-add" title="{l s='Add new module'}"><i class="process-icon-new"></i></a>
        </span>
    </div>
    <div class="panel-body" style="padding:0">
        <div class="table-responsive">
            <table class="table" id="moduleList">
                <thead>
                    <tr class="nodrag nodrop">
                        <th width="50" class="center">{l s='ID' mod='flexgroupmenus'}</th>
                        <th>{l s='Name' mod='flexmegamenus'}</th>
                        <th>{l s='Position' mod='flexgroupmenus'}</th>
                        <th>{l s='Layout' mod='flexgroupmenus'}</th>
                        <th width="100" class="center">{l s='Ordering' mod='flexgroupmenus'}</th>
                        <th width="50" class="center">{l s='Status' mod='flexgroupmenus'}</th>
                        <th class="center" width="50">#</th>
                    </tr>
                </thead>
                <tbody>
                    {if $items|@count >0}
                    {foreach from=$items item=item}
                    <tr id="mo_{$item.id}">
                        <td class="center">{$item.id}</td>
                        <td><a href="javascript:void(0)" class="lik-module" title="{l s='Load menu content'}" data-item-id="{$item.id}">{$item.name}</a></td>                
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
<div class="panel" style="display: none" id="row_of_module">    
    <div class="panel-heading">
        {l s=' Menus of module ' mod='flexgroupmenus'}<span id="header-module-name"></span>
        <span class="panel-heading-action">            
            <a href="javascript:void(0)" onclick="showModal('modalMenuItem')" class="list-toolbar-btn link-add" title="{l s='Add new row'}"><i class="process-icon-new"></i></a>            
        </span>
    </div>
    <div class="panel-body" style="padding:0" id="module-content">
        
    </div> 
</div>




<div id="modalModule" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title"><i class="icon-cloud"></i>{l s=' Add or edit module' mod='flexgroupmenus'}</span>
            </div>
            <div class="modal-body form-horizontal" id="forgotBody">
                <form id="frmModule">{$moduleForm}</form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveModule()"><i class="icon-save"></i> {l s='Save' mod='flexgroupmenus'}</button>
            </div>
        </div>
    </div>
</div>

<div id="modalMenuItem" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title"><i class="icon-cloud"></i>{l s=' Add or edit menu item' mod='flexgroupmenus'}</span>
            </div>
            <div class="modal-body form-horizontal">
                <form id="frmMenuItem">{$menuItemForm}</form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveMenuItem()"><i class="icon-save"></i> {l s='Save' mod='flexgroupmenus'}</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var secure_key = "{$secure_key}";
    var currentUrl = "{$currentUrl}";
    var baseModuleUrl = "{$baseModuleUrl}";
    var moduleId = '0';
        
    var moduleFormNew = '';
    var menuItemFormNew = '';
</script>