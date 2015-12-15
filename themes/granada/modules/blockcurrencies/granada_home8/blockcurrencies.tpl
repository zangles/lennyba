	{if count($currencies) > 1}
		<div class="currency-dropdown dropdown">
	       <a title="Currenct" class="dropdown-toggle" data-toggle="dropdown">
	       		{foreach from=$currencies key=k item=f_currency}
					{if $cookie->id_currency == $f_currency.id_currency}
					<span class="long-name">{$f_currency.name}</span>
		       		<span class="short-name">{$f_currency.iso_code}</span>
					{/if}
				{/foreach}       	
	       	</a>
	       <ul class="dropdown-menu">       		
	       		{foreach from=$currencies key=k item=f_currency}
	       			<li {if $cookie->id_currency == $f_currency.id_currency}class="active"{/if}>
	       				<a  href="javascript:setCurrency({$f_currency.id_currency});">
	       					<span class="long-name">{$f_currency.name}</span>
	       					<span class="short-name">{$f_currency.iso_code}</span>
	       				</a>
	       			</li>       			
				{/foreach}
	       </ul>
	    </div>
	{/if}
