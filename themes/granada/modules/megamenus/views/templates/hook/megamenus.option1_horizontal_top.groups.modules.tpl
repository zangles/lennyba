<div class="col-md-{$width} {$custom_class}">
	{if $display_title == '1'}
		<h5 class="group-title megamenu-title">{$name}</h5>
	{/if}
	{if isset($megamenus_module) && $megamenus_module != ''}
		<div class="menu-group-module">{$megamenus_module}</div>	
	{/if}
</div>
