<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
        	{l s='Banners' mod='flexbanner'}
    		<span class="panel-heading-action">
                <a href="javascript:void(0)" onclick="showModal('modalBanner')" class="list-toolbar-btn link-add" title="{l s='Add New' mod='flexbanner'}"><i class="process-icon-new"></i></a>
    		</span>
        </div>
        <div class="panel-body" style="padding:0">
            <div class="table-responsive">
                <table class="table" id="bannerList">
        			<thead>
        				<tr class="nodrag nodrop">
                            <th width="50" class="">{l s='ID' mod='flexbanner'}</th>
                            <th class="">{l s='Banner' mod='flexbanner'}</th>
                            <th width="180" class="">{l s='Position' mod='flexbanner'}</th>
                            <th class="center" width="120">{l s='Ordering' mod='flexbanner'}</th> 
                            <th class="center" width="50">{l s='Status' mod='flexbanner'}</th>                 
                            <th class="center" width="50">#</th>
                        </tr>
                    </thead>
                    <tbody>
                    	{if $items && $items|@count >0}
                    		{foreach from=$items item=item}
                    		<tr id="bn_{$item.id}" class="bannerList">
		                        <td class="center">{$item.id}</td>
		                        <td>
		                        	{if $item.image}
		                        		<img src="{$item.image}" alt="{$item.alt}" class="img-responsive" style="max-height: 45px" />
		                        	{else}
		                        		{l s='No banner' mod='flexbanner'}
		                        	{/if}
		                        </td>                
		                        <td>{$item.position_name}</td>                    		                        
		                        <td class="pointer dragHandle center" ><div class="dragGroup"><div class="positions">{$item.ordering}</div></div></td>
		                        <td class="center">
		                            {if $item.status == '1'}
		                                <a title="Enabled" class="list-action-enable action-enabled lik-banner-status" item-id="{$item.id}" value="{$item.status}"><i class="icon-check"></i></a>
		                            {else}
		                                <a title="Disabled" class="list-action-enable action-disabled lik-banner-status" item-id="{$item.id}" value="{$item.status}"><i class="icon-check"></i></a>
		                            {/if}
		                        </td>
		                        <td class="center"><a href="javascript:void(0)" item-id="{$item.id}" class="lik-banner-edit"><i class="icon-edit"></i></a>&nbsp;<a href="javascript:void(0)" item-id="{$item.id}" class="lik-banner-delete"><i class="icon-trash" ></i></a></td>
		                    </tr>
                    		{/foreach}                    	
                    	{/if}                    	
                    </tbody>    
    	       </table>            
            </div>        
        </div> 
    </div>
</div>

<div id="modalBanner" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title"><i class="icon-cloud"></i>{l s=' Add new Banner' mod='flexbanner'}</span>
            </div>
            <div class="modal-body form-horizontal" id="forgotBody">
                <form id="frmBanner">{$form}</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-off"></i> {l s='Cancel' mod='flexbanner'}</button>
                <button type="button" class="btn btn-primary btnForgot" onclick="saveBanner()"><i class="icon-save"></i> {l s='Save' mod='flexbanner'}</button>
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
    var newForm = '';
</script>