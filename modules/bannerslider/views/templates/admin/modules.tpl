<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
        	{l s='Module' mod='bannerslider'}
    		<span class="panel-heading-action">
                <a href="javascript:void(0)" onclick="showModal('modalModule')" class="list-toolbar-btn link-add" title="{l s='Add new module' mod='bannerslider'}"><i class="process-icon-new"></i></a>
    		</span>
        </div>
        <div class="panel-body" style="padding:0">
            <div class="table-responsive">
                <table class="table" id="moduleList">
        			<thead>
        				<tr class="nodrag nodrop">
                            <th width="50" class="">{l s='ID' mod='bannerslider'}</th>
                            <th class="">{l s='Module name' mod='bannerslider'}</th>
                            <th width="180" class="">{l s='Layout' mod='bannerslider'}</th>
                            <th width="180" class="">{l s='Position' mod='bannerslider'}</th>
                            <th class="center" width="120">{l s='Ordering' mod='bannerslider'}</th> 
                            <th class="center" width="50">{l s='Status' mod='bannerslider'}</th>                 
                            <th class="center" width="50">#</th>
                        </tr>
                    </thead>
                    <tbody>
                    	{if $items && $items|@count >0}
                    		{foreach from=$items item=item}
                    		<tr id="mod_{$item.id}" data-id="{$item.id}" class="moduleList">
		                        <td class="center">{$item.id}</td>
		                        <td><a href="javascript:void(0)" class="lik-module" data-id="{$item.id}">{$item.name}</a></td>                
		                        <td>{$item.layout}</td>
                                <td>{$item.position_name}</td>                    		                        
		                        <td class="pointer dragHandle center" ><div class="dragGroup"><div class="positions mod_position_{$item.id}">{$item.ordering}</div></div></td>
		                        <td class="center">
		                            {if $item.status == '1'}
		                                <a title="Enabled" class="list-action-enable action-enabled lik-module-status" item-id="{$item.id}" value="{$item.status}"><i class="icon-check"></i></a>
		                            {else}
		                                <a title="Disabled" class="list-action-enable action-disabled lik-module-status" item-id="{$item.id}" value="{$item.status}"><i class="icon-check"></i></a>
		                            {/if}
		                        </td>
		                        <td class="center">
		                        	<a href="javascript:void(0)" item-id="{$item.id}" class="lik-module-edit"><i class="icon-edit"></i></a>&nbsp;<a href="javascript:void(0)" item-id="{$item.id}" class="lik-module-delete"><i class="icon-trash" ></i></a></td>
		                    </tr>
                    		{/foreach}                    	
                    	{/if}                    	
                    </tbody>    
    	       </table>            
            </div>        
        </div> 
    </div>
    
    <div class="panel" id="slide-panel" style="display: none">
        <div class="panel-heading">
        	{l s='Slide list' mod='bannerslider'} <span id="span-module-name"></span>
    		<span class="panel-heading-action">
                <a href="javascript:void(0)" onclick="showModal('modalSlide')" class="list-toolbar-btn link-add" title="{l s='Add new slide item' mod='bannerslider'}"><i class="process-icon-new"></i></a>
    		</span>
        </div>
        <div class="panel-body" style="padding:0">
            <div class="table-responsive">
                <table class="table" id="slideList">
        			<thead>
        				<tr class="nodrag nodrop">
                            <th width="50" class="">{l s='ID' mod='bannerslider'}</th>
                            <th class="">{l s='Image' mod='bannerslider'}</th>
                            <th width="" class="">{l s='Description' mod='bannerslider'}</th>
                            <th class="center" width="120">{l s='Ordering' mod='bannerslider'}</th> 
                            <th class="center" width="50">{l s='Status' mod='bannerslider'}</th>                 
                            <th class="center" width="50">{l s='Action' mod='bannerslider'}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>    
    	       </table>            
            </div>        
        </div> 
    </div>
    
</div>

<div id="modalModule" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title"><i class="icon-cloud"></i>{l s=' Add or edit module' mod='bannerslider'}</span>
            </div>
            <div class="modal-body form-horizontal" id="forgotBody">
                <form id="frmModule">{$form}</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-off"></i> {l s='Cancel' mod='flexbanner'}</button>
                <button type="button" class="btn btn-primary btnForgot" onclick="saveModule()"><i class="icon-save"></i> {l s='Save' mod='flexbanner'}</button>
            </div>
        </div>
    </div>
</div>
<div id="modalSlide" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title"><i class="icon-cloud"></i>{l s=' Add or edit slide item' mod='bannerslider'}</span>
            </div>
            <div class="modal-body form-horizontal" id="forgotBody">
                <form id="frmSlide">{$slideForm}</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-off"></i> {l s='Cancel' mod='flexbanner'}</button>
                <button type="button" class="btn btn-primary btnForgot" onclick="saveSlide()"><i class="icon-save"></i> {l s='Save' mod='flexbanner'}</button>
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
    var iso = '{$iso}';    
    var ad = "{$ad}";
    var currentUrl = "{$currentUrl}";
    var baseModuleUrl = "{$baseModuleUrl}";
    var secure_key = "{$secure_key}";
    var newModuleForm = '';
    var newSlideFrom = '';
    var moduleId = '0';
</script>