
{if isset($simplecategory_groups) && $simplecategory_groups|@count >0}	
	<div class="simple-tab-container simple-tab-container-6 tab-round">
		{assign  var='first' value=0}
		<ul class="nav nav-pills" role="tablist">			
			{foreach from=$simplecategory_groups item=group name=groups}
				{if isset($group.products) && $group.products|@count >0}
					{if $first == 0}
						<li class="active secondary-font first"><a href="#simplecategory_group_{$group.module_id}_{$group.id}" role="tab" data-toggle="tab">{$group.name}</a></li>
					{else}
						<li class="secondary-font"><a href="#simplecategory_group_{$group.module_id}_{$group.id}" role="tab" data-toggle="tab">{$group.name}</a></li>
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
						<div class="products-grid grid-type-1 grid-type-4 column5 row">
							{include file="$tpl_dir./group-product-style6.tpl" products=$group.products}							
						</div>
						{literal}
						<script type="text/javascript">
					        jQuery('.simple-tab-container-6 .products-grid > div:nth-child(2n)').addClass('nth-child-2n');
					        jQuery('.simple-tab-container-6 .products-grid > div:nth-child(2n+1)').addClass('nth-child-2np1');
					        jQuery('.simple-tab-container-6 .products-grid > div:nth-child(3n)').addClass('nth-child-3n');
					        jQuery('.simple-tab-container-6 .products-grid > div:nth-child(3n+1)').addClass('nth-child-3np1');
					        jQuery('.simple-tab-container-6 .products-grid > div:nth-child(4n)').addClass('nth-child-4n');
					        jQuery('.simple-tab-container-6 .products-grid > div:nth-child(4n+1)').addClass('nth-child-4np1');
					        jQuery('.simple-tab-container-6 .products-grid > div:nth-child(5n)').addClass('nth-child-5n');
					        jQuery('.simple-tab-container-6 .products-grid > div:nth-child(5n+1)').addClass('nth-child-5np1');
					        jQuery('.simple-tab-container-6 .products-grid > div:nth-child(6n)').addClass('nth-child-6n');
					        jQuery('.simple-tab-container-6 .products-grid > div:nth-child(6n+1)').addClass('nth-child-6np1');
					    </script>
						{/literal}
						
					</div> 
				{/if}					
			{/foreach}
		</div>
	</div>
{/if}

