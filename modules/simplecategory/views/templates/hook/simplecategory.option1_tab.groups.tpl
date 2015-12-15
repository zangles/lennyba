{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('simplecategory.option1_tab.groups.tpl','simplecategory')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
	
	{if isset($simplecategory_groups) && $simplecategory_groups|@count >0}	
		<div class="simple-tab-container">
			{assign  var='first' value=0}
			<ul class="nav nav-pills" role="tablist">			
				{foreach from=$simplecategory_groups item=group name=groups}
					{if isset($group.products) && $group.products|@count >0}
						{if $first == 0}
							<li class="active"><a href="#simplecategory_group_{$group.module_id}_{$group.id}" role="tab" data-toggle="tab">{$group.name}</a></li>
						{else}
							<li><a href="#simplecategory_group_{$group.module_id}_{$group.id}" role="tab" data-toggle="tab">{$group.name}</a></li>
						{/if}
						{assign  var='first' value=1}
					{/if} 
				{/foreach}
			</ul>
			{assign  var='first' value=0}
			<div class="tab-content">
				{foreach from=$simplecategory_groups item=group name=groups}
					{if isset($group.products) && $group.products|@count >0}
						{if $first == 0}
						<div class="tab-pane fade in active" id="simplecategory_group_{$group.module_id}_{$group.id}">
						{else}
						<div class="tab-pane fade" id="simplecategory_group_{$group.module_id}_{$group.id}">
						{/if}
						{assign  var='first' value=1}					
							<div class="row">
								{include file="$tpl_dir./group-product-style1.tpl" products=$group.products}							
							</div>
						</div> 
					{/if}					
				{/foreach}
			</div>
		</div>
{/if}
{/if}
