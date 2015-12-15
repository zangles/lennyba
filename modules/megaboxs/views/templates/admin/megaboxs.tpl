<div class="panel dts-panel">    
    <div class="panel-heading">
        {l s='List Mega Boxs' mod='megaboxs'}
        <span class="panel-heading-action dts-control">
        	<a href="javascript:void(0)" class="link-trash c-red" title="{l s='Delete' mod='megaboxs'}">{l s='Delete' mod='megaboxs'}</a>
        	<!--
            <a href="javascript:void(0)" class="link-deactive c-org" title="{l s='Disable' mod='megaboxs'}">{l s='Disable' mod='megaboxs'}</a>
            <a href="javascript:void(0)" class="link-active" title="{l s='Enable' mod='megaboxs'}">{l s='Enable' mod='megaboxs'}</a>
           -->
            <a href="javascript:void(0)" class="link-add link-add-megamenu" title="{l s='Add new' mod='megaboxs'}">{l s='Add new' mod='megaboxs'}</a>
        </span>
    </div>
    <div class="panel-body" style="padding:0">
        <div class="table-responsive">
            <table class="table" id="moduleList">
                <thead>
                    <tr class="nodrag nodrop">
                    	<th width="30" class="center" valign="center" style="padding-top: 3px">
                    		<a class="link-deactive link-icon chk-all" data-classname="chk-megamenu" href="javascript:void(0)"></a>
                    	</th>
                        <th width="60" class="center">{l s='ID' mod='megaboxs'}</th>
                        <th>{l s='Name' mod='megaboxs'}</th>
                        <th>{l s='Position' mod='megaboxs'}</th>
                        <th>{l s='Theme/Option' mod='megaboxs'}</th>                        
                        <th width="150">{l s='Layout' mod='megaboxs'}</th>
                        <th width="100" class="center">{l s='Ordering' mod='megaboxs'}</th>
                        <th class="center" width="280">{l s='Actions' mod='megaboxs'}</th>
                    </tr>
                </thead>
                <tbody>
                    {if $items|@count >0}
                    {foreach from=$items item=item}
                    <tr id="megamenu_{$item.id}" class="list-megamenu">
                        <td class="center"><input type="checkbox" class="chk-megamenu" value="{$item.id}" /></td>
                        <td class="center">{$item.id}</td>
                        <td><a href="javascript:void(0)" class="link-megamenu" title="{l s='Load menu content'}" data-id="{$item.id}">{$item.name}</a></td>                
                        <td>{$item.position_name}</td>
                        <td>{$item.theme_directory} / {$item.option_directory}</td>
                        <td>{megaboxs::_getLayoutName($item.layout)}</td>                                            
                        <td class="pointer dragHandle center" ><div class="dragGroup"><div class="positions">{$item.ordering}</div></div></td>
                        <td class="center">
                        	<div class="group-action action-small" style="float: right">
                        		{if $item.status == '1'}
	                            	<a href="javascript:void(0)" class="link-active link-status-megamenu" data-id="{$item.id}" data-value="{$item.status}" data-action="changemegaboxstatus">&nbsp;{l s='Status' mod='megaboxs'}</a>                                
	                            {else}
	                            	<a href="javascript:void(0)" class="link-deactive link-status-megamenu c-org" data-id="{$item.id}" data-value="{$item.status}" data-action="changemegaboxstatus">&nbsp;{l s='Status' mod='megaboxs'}</a>
	                            {/if}
                        		<a href="javascript:void(0)" data-id="{$item.id}" class="link-edit link-edit-megamenu" title="{l s='Edit megamenu' mod='megaboxs'}">&nbsp;{l s='Edit' mod='megaboxs'}</a>                        	
	                        	<a href="javascript:void(0)" data-id="{$item.id}" data-action="" class="link-copy link-copy-megamenu" title="{l s='Copy megamenu' mod='megaboxs'}">&nbsp;{l s='Copy' mod='megaboxs'}</a>
	                        	<a href="javascript:void(0)" data-id="{$item.id}" data-action="" class="link-trash link-trash-megamenu c-red" title="{l s='Delete megamenu' mod='megaboxs'}">&nbsp;{l s='Delete' mod='megaboxs'}</a>	
                        	</div>                        	
                        </td>
                    </tr>
                    {/foreach}
                    {/if}    
                </tbody>    
           </table>            
        </div>        
    </div> 
</div>



{*}
<div class="panel dts-panel" style="display: none" id="panel-menus">    
    <div class="panel-heading">
        {l s=' List menus of ' mod='megaboxs'}<span id="header-megamenu-name"></span> 
        <span class="panel-heading-action dts-control">        	
            <a href="javascript:void(0)" class="link-add link-add-menu" title="{l s='Add new' mod='megaboxs'}">{l s='Add new' mod='megaboxs'}</a>
        </span>      
    </div>
    <div class="panel-body" style="padding:0" >
        <div class="table-responsive">
        	<div class="" id="menuList">        		
        		<div class="list-body menu-sortable" data-parent="0"></div>
        	</div>
        	
        </div>
    </div> 
</div>
{*}
<div class="panel dts-panel" style="display: none" id="panel-menus">    
    <div class="panel-heading">
        {l s=' rows of ' mod='megaboxs'}<span id="header-megamenu-name"></span>
        <span class="panel-heading-action dts-control">        	
            <a href="javascript:void(0)" class="link-add link-add-row" title="{l s='Add new' mod='megaboxs'}">{l s='Add new' mod='megaboxs'}</a>            
        </span>
        {*}
        <span class="panel-heading-action">            
            <a href="javascript:void(0)" onclick="showModal('modalRow')" class="list-toolbar-btn link-add" title="{l s='Add new row'}"><i class="process-icon-new"></i></a>            
        </span>
        {*}
    </div>
    <div class="panel-body" style="padding:0" id="menu-content">
        
    </div> 
</div>




<div id="modalModule" class="modal fade dts-modal" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title">{l s=' Add or edit mega box' mod='megaboxs'}</span>
            </div>
            <div class="modal-body form-horizontal" id="forgotBody">
                <form id="frmMegamenu">{$formMegamenu}</form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveModule()"><i class="icon-save"></i> {l s='Save' mod='megaboxs'}</button>
            </div>
        </div>
    </div>
</div>
<div id="modalMenu" class="modal fade dts-modal" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title">{l s=' Add or edit menu' mod='megaboxs'}</span>
            </div>
            <div class="modal-body form-horizontal" id="forgotBody">
                <form id="frmMenu">{$formMenu}</form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveMenu()"><i class="icon-save"></i> {l s='Save' mod='megaboxs'}</button>
            </div>
        </div>
    </div>
</div>
<div id="modalSubMenu" class="modal fade dts-modal" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title">{l s=' Add or edit sub menu' mod='megaboxs'}</span>
            </div>
            <div class="modal-body form-horizontal" id="forgotBody">
                <form id="frmSubMenu">{$formSubMenu}</form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveSubMenu()"><i class="icon-save"></i> {l s='Save' mod='megaboxs'}</button>
            </div>
        </div>
    </div>
</div>
<div id="modalRow" class="modal fade dts-modal" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title">{l s='Add or edit row' mod='megaboxs'}</span>
            </div>
            <div class="modal-body form-horizontal">
                <form id="frmRow">{$formRow}</form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveRow()"><i class="icon-save"></i> {l s='Save' mod='megaboxs'}</button>
            </div>
        </div>
    </div>
</div>
<div id="modalGroup" class="modal fade dts-modal" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title">{l s=' Add or edit group' mod='megaboxs'}</span>
            </div>
            <div class="modal-body form-horizontal">
                <form id="frmGroup">
                    <div class="clearfix">
                        <div class="tab-groups" id="tab-groups">
                            <a href="#group-config" class="tab-item active">{l s='Group config' mod="simplecategory"}</a>
                            <a href="#group-description" class="tab-item">{l s='Group description' mod="simplecategory"}</a>                                       
                        </div>
                    </div>     
                    <div class="tab-content">                                
                        <div id="group-config" class="tab-pane fade in active">
                            {$formGroup.config}                                    
                        </div>
                        <div id="group-description" class="tab-pane fade">
                            {$formGroup.description}                           
                        </div>
                    </div>                    
                </form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveGroup()"><i class="icon-save"></i> {l s='Save' mod='megaboxs'}</button>
            </div>
        </div>
    </div>
</div>
<div id="modalMenuItem" class="modal fade dts-modal" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title">{l s=' Add or edit menu item' mod='megaboxs'}</span>
            </div>
            <div class="modal-body form-horizontal">
                <form id="frmMenuItem">{$formMenuItem}</form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveMenuItem()"><i class="icon-save"></i> {l s='Save' mod='megaboxs'}</button>
            </div>
        </div>
    </div>
</div>
<div id="modalSubMenuItem" class="modal fade dts-modal" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title">{l s=' Add or edit sub menu item' mod='megaboxs'}</span>
            </div>
            <div class="modal-body form-horizontal">
                <form id="frmSubMenuItem">{$formSubMenuItem}</form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveSubMenuItem()"><i class="icon-save"></i> {l s='Save' mod='megaboxs'}</button>
            </div>
        </div>
    </div>
</div>
{include file="$dialog_product"}
{addJsDefL name=uploadfile_not_setup}{l s='Error, not find element upload file!' mod='megaboxs' js=1}{/addJsDefL}
{addJsDefL name=lab_delete}{l s='Delete' mod='megaboxs' js=1}{/addJsDefL}
{addJsDefL name=lab_disable}{l s='Disable' mod='megaboxs' js=1}{/addJsDefL}
{addJsDefL name=lab_enable}{l s='Enable' mod='megaboxs' js=1}{/addJsDefL}
{addJsDefL name=confirm_delete_group}{l s='Are you sure you want to delete this group?' mod='megaboxs' js=1}{/addJsDefL}
{addJsDefL name=confirm_delete_menu}{l s='Are you sure you want to delete this menu?' mod='megaboxs' js=1}{/addJsDefL}
{addJsDefL name=confirm_delete_row}{l s='Are you sure you want to delete this row?' mod='megaboxs' js=1}{/addJsDefL}
{addJsDefL name=confirm_delete_menu_item}{l s='Are you sure you want to delete this menu item?' mod='megaboxs' js=1}{/addJsDefL}

<script type="text/javascript">
	$(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
    		e.stopImmediatePropagation();
    	}
    });
    var secure_key			= "{$secure_key}";
    var baseModuleUrl 		= "{$baseModuleUrl}";
    var currentUrl 			= "{$currentUrl}";
    var currentLanguage 	= "{$langId}";
    var megamenuId 			= '0';
    var menuId 				= '0';
    var parentMenuId 		= '0';
    var parentMenuItemId 	= '0';
    var rowId 				= '0';    
    var groupId 			= '0';    
    var iso 				= '{$iso}';    
    var ad 					= "{$ad}";
    var formNewMegamenu 	= '';
    var formNewMenu 		= '';
    var formNewRow 			= '';
    var formNewGroup 		= '';    
    var formNewMenuItem 	= '';
    var formNewSubMenu 		= '';
    var formNewSubMenuItem	='';
</script>