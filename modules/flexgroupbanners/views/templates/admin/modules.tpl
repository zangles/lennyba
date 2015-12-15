<div class="panel">    
    <div class="panel-heading">
        {l s='List Modules' mod='flexgroupbanners'}
        <span class="panel-heading-action">            
            <a href="javascript:void(0)" onclick="showModal('modalModule')" class="list-toolbar-btn link-add" title="{l s='Add new module'}"><i class="process-icon-new"></i></a>
        </span>
    </div>
    <div class="panel-body" style="padding:0">
        <div class="table-responsive">
            <table class="table" id="moduleList">
                <thead>
                    <tr class="nodrag nodrop">
                        <th width="50" class="center">{l s='ID' mod='flexgroupbanners'}</th>
                        <th>{l s='Name' mod='flexmegamenus'}</th>
                        <th width="150" class="center">{l s='Position' mod='flexgroupbanners'}</th>
                        <th width="150" class="center">{l s='Layout' mod='flexgroupbanners'}</th>
                        <th width="100" class="center">{l s='Ordering' mod='flexgroupbanners'}</th>
                        <th width="50" class="center">{l s='Status' mod='flexgroupbanners'}</th>
                        <th class="center" width="50">#</th>
                    </tr>
                </thead>
                <tbody>
                    {if $items|@count >0}
                    {foreach from=$items item=item}
                    <tr id="mo_{$item.id}">
                        <td class="center">{$item.id}</td>
                        <td><a href="javascript:void(0)" class="lik-module" title="{l s='Load menu content'}" data-item-id="{$item.id}">{$item.name}</a></td>                
                        <td class="center">{$item['position_name']}</td>                    
                        <td class="center">{$item.layout_value}</td>
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
        {l s=' rows of module ' mod='flexgroupbanners'}<span id="header-module-name"></span>
        <span class="panel-heading-action">            
            <a href="javascript:void(0)" onclick="showModal('modalRow')" class="list-toolbar-btn link-add" title="{l s='Add new row'}"><i class="process-icon-new"></i></a>            
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
                <span class="modal-title"><i class="icon-cloud"></i>{l s=' Add or edit module' mod='flexgroupbanners'}</span>
            </div>
            <div class="modal-body form-horizontal" id="forgotBody">
                <form id="frmModule">{$moduleForm}</form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveModule()"><i class="icon-save"></i> {l s='Save' mod='flexgroupbanners'}</button>
            </div>
        </div>
    </div>
</div>
<div id="modalRow" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title"><i class="icon-cloud"></i>{l s=' Add or edit row' mod='flexgroupbanners'}</span>
            </div>
            <div class="modal-body form-horizontal">
                <form id="frmRow">{$rowForm}</form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveRow()"><i class="icon-save"></i> {l s='Save' mod='flexgroupbanners'}</button>
            </div>
        </div>
    </div>
</div>
<div id="modalGroup" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title"><i class="icon-cloud"></i>{l s=' Add or edit group' mod='flexgroupbanners'}</span>
            </div>
            <div class="modal-body form-horizontal">
                <form id="frmGroup">{$groupForm}</form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveGroup()"><i class="icon-save"></i> {l s='Save' mod='flexgroupbanners'}</button>
            </div>
        </div>
    </div>
</div>
<div id="modalMenuItem" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title"><i class="icon-cloud"></i>{l s=' Add or edit banner' mod='flexgroupbanners'}</span>
            </div>
            <div class="modal-body form-horizontal">
                <form id="frmBanner">{$bannerForm}</form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveBanner()"><i class="icon-save"></i> {l s='Save' mod='flexgroupbanners'}</button>
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
    var secure_key = "{$secure_key}";
    var baseModuleUrl = "{$baseModuleUrl}";
    var currentUrl = "{$currentUrl}";
    var moduleId = '0';
    var rowId = '0';    
    var groupId = '0';    
    var menuId = '0';
    
    var verticalGroupType = '';
    var iso = '{$iso}';    
    var ad = "{$ad}";
    var moduleFormNew = '';
    var rowFormNew = '';
    var groupFormNew = '';
    var menuFormNew = '';    
    var bannerFormNew = '';
</script>