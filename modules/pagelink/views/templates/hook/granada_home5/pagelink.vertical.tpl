
{if isset($menuContents) && $menuContents|@count >0}
	<div class="user-dropdown dropdown">
	   <a title="{l s='My Account'}" class="dropdown-toggle" data-toggle="dropdown"><span class="header-links-icon icon-account"></span><span class="hidden-xs">{l s='My Account'}</span> <span class="dropdown-arrow hidden-xs"></span></a>
	   <ul class="dropdown-menu" role="menu">
	      {foreach from=$menuContents item=parent_menu name=parent_menus}
				{if $parent_menu.link_type == 'CURRENCY-BOX'}
					<div class="currency-dropdown dropdown">
		               <a title="Currenct" class="dropdown-toggle" data-toggle="dropdown"><span class="long-name">{$parent_menu.currencies.name}</span><span class="short-name">{$parent_menu.currencies.iso_code}</span><span class="dropdown-arrow"></span></a>
		               <ul class="dropdown-menu">					
							{foreach from=$currencies key=k item=f_currency}
								<li><a  href="javascript:setCurrency({$f_currency.id_currency});"><span class="long-name">{$f_currency.name}</span><span class="short-name">{$f_currency.iso_code}</span></a></li>						
							{/foreach}					
		               </ul>
		            </div>
				{elseif $parent_menu.link_type == 'LANGUAGE-BOX'}
					<div class="language-dropdown dropdown">
		               <a title="Language" class="dropdown-toggle" data-toggle="dropdown"><span class="long-name">{$lang_name}</span><span class="short-name">{$lang_iso_code}</span><span class="dropdown-arrow"></span></a>
		               <ul class="dropdown-menu">
							{foreach from=$languages key=k item=language name="languages"}
								<li {if $language.iso_code == $lang_iso}class="selected_language"{/if}>
								{if $language.iso_code != $lang_iso}
									{assign var=indice_lang value=$language.id_lang}
									{if isset($lang_rewrite_urls.$indice_lang)}
										<a href="{$lang_rewrite_urls.$indice_lang|escape:htmlall}"><span class="long-name">{$language.name}</span><span class="short-name">{$language.iso_code}</span></a>								
									{else}
										<a href="{$link->getLanguageLink($language.id_lang)|escape:htmlall}"><span class="long-name">{$language.name}</span><span class="short-name">{$language.iso_code}</span></a>		
									{/if}
								{else}
									<a href="{$link->getLanguageLink($language.id_lang)|escape:htmlall}"><span class="long-name">{$language.name}</span><span class="short-name">{$language.iso_code}</span></a>
								{/if}							
								</li>
							{/foreach}                  
		               </ul>
		            </div>
				{else}
					<li>
	               		<a href="{$parent_menu.link}" title="{$parent_menu.name}">
	               			{if $parent_menu.icon_type == 'class'}
	               				<span class="{$parent_menu.full_path}"></span>
	               			{else}
	               				{if $parent_menu.full_path != ''}
	               					<img src="{$parent_menu.full_path}" alt="{$parent_menu.name}" />
	               				{/if}               			
	               			{/if}
	               			<span>{$parent_menu.name}</span>
	               		</a>
	               	</li>
				{/if}			
			{/foreach}	
	   </ul>
	</div>	
{/if}	
