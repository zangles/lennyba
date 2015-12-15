<div class="panel">    
    <div class="panel-heading">
        {l s='List Parallax' mod='customparallax'}
        <span class="panel-heading-action">            
            <a href="javascript:void(0)" onclick="showModal('modalModule')" class="list-toolbar-btn link-add" title="{l s='Add new module'}"><i class="process-icon-new"></i></a>
        </span>
    </div>
    <div class="panel-body" style="padding:0">
        <div class="table-responsive">
            <table class="table" id="moduleList">
                <thead>
                    <tr class="nodrag nodrop">
                        <th width="50" class="center">{l s='ID' mod='customparallax'}</th>
                        <th>{l s='Name' mod='flexmegamenus'}</th>
                        <th width="200">{l s='Position' mod='customparallax'}</th>
                        <th width="200">{l s='Layout' mod='customparallax'}</th>
                        <th width="100" class="center">{l s='Ordering' mod='customparallax'}</th>
                        <th width="50" class="center">{l s='Status' mod='customparallax'}</th>
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
                <span class="modal-title"><i class="icon-cloud"></i>{l s=' Add or edit module' mod='customparallax'}</span>
            </div>
            <div class="modal-body form-horizontal" id="forgotBody">
                <form id="frmModule">
                	<div class="clearfix">
                        <div class="tab-groups" id="tab-groups">
                            <a href="#module-config" class="tab-item active">{l s='Module config' mod="customparallax"}</a>
                            <a href="#parallax-config" class="tab-item">{l s='Parallax config' mod="customparallax"}</a>                                       
                        </div>
                    </div>     
                    <div class="tab-content">                                
                        <div id="module-config" class="tab-pane fade in active">
                            {$moduleForm.config}                                    
                        </div>
                        <div id="parallax-config" class="tab-pane fade">
                            {$moduleForm.parallax}                           
                        </div>
                    </div>
                	
                </form>           
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-primary btnForgot" onclick="saveModule()"><i class="icon-save"></i> {l s='Save' mod='customparallax'}</button>
            </div>
        </div>
    </div>
</div>

{addJsDefL name=uploadfile_not_setup}{l s='Error, not find element upload file!' mod='megaboxs' js=1}{/addJsDefL}
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
    var moduleConfig = '';
    var parallaxConfig = '';
</script>