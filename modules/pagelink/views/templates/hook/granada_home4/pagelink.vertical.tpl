	{if isset($menuContents) && $menuContents|@count >0}
		<div class="user-dropdown dropdown">
	     	<a title="{$name}" class="dropdown-toggle" data-toggle="dropdown"><span class="dropdown-icon"></span> <span class="dropdown-text">{if $display_name == 1}{$name}{/if}</span></a>     
	     	<ul class="dropdown-menu" role="menu">
	     		{foreach from=$menuContents item=parent_menu name=parent_menus}
					{if $parent_menu['link_type'] == 'CURRENCY-BOX'}
					
					<li class="{$parent_menu.custom_class}">
						<a href="#" class="clearfix"><span class="pull-left">{$parent_menu.currencies.name}</span><span class="dropdown-value">{$parent_menu.currencies.iso_code}</span></a>
			           <ul>
			              {foreach from=$currencies key=k item=f_currency}
							<li {if $cookie->id_currency == $f_currency.id_currency}class="selected"{/if}>
								<a href="javascript:setCurrency({$f_currency.id_currency});" title="{$f_currency.name}" rel="nofollow">{$f_currency.name}</a>
							</li>
						{/foreach}
			           </ul>
			        </li>
					{elseif $parent_menu['link_type'] == 'LANGUAGE-BOX'}
						<li class="{$parent_menu.custom_class}">
							<a href="#" class="clearfix"><span class="pull-left">{$parent_menu.name}</span><span class="dropdown-value">{$lang_iso}</span></a>
							<ul>
								{foreach from=$languages key=k item=language name="languages"}
									<li {if $language.iso_code == $lang_iso}class="active"{/if}>
										{if $language.iso_code != $lang_iso}
											{assign var=indice_lang value=$language.id_lang}
											{if isset($lang_rewrite_urls.$indice_lang)}
												<a href="{$lang_rewrite_urls.$indice_lang|escape:htmlall}" title="{$language.name}">
											{else}
												<a href="{$link->getLanguageLink($language.id_lang)|escape:htmlall}" title="{$language.name}">
							
											{/if}
										{else}
											<a href="{$link->getLanguageLink($language.id_lang)|escape:htmlall}" title="{$language.name}">
										{/if}
											{$language.name}
											<img src="{$img_lang_dir}{$language.id_lang}.jpg" alt="{$language.iso_code}" />
										</a>
									</li>
								{/foreach}								
							</ul>
				        </li>
					{else}
						<li class="{$parent_menu.custom_class}">
				    		<a href="{$parent_menu.link}" title="{$parent_menu.name}">
				    			{if $parent_menu.icon_type == 'class'}
		               				<span class="{$parent_menu.full_path}"></span>
		               			{else}
		               				{if $parent_menu.full_path != ''}
		               					<img src="{$parent_menu.full_path}" alt="{$parent_menu.name}" />
		               				{/if}               			
		               			{/if}
				    			{$parent_menu.name}
				    		</a>
				    		{if isset($parent_menu.submenus) && $parent_menu.submenus|@count >0}
				    			<ul class="simplemenus-submenus">	
				    			{foreach from=$parent_menu.submenus item=sub_menu name=sub_menus}
					    			<li class="sub-item {$sub_menu.custom_class}">
							    		<a href="{$sub_menu.link}" title="{$sub_menu.name}">
							    			{if $parent_menu.icon_type == 'class'}
					               				<span class="{$parent_menu.full_path}"></span>
					               			{else}
					               				{if $parent_menu.full_path != ''}
					               					<img src="{$parent_menu.full_path}" alt="{$parent_menu.name}" />
					               				{/if}               			
					               			{/if}
							    			{$sub_menu.name}
							    		</a>
							    	</li>
				    			{/foreach}
				    			</ul>				
				    		{/if}		
				    	</li>
					{/if}			
				{/foreach}
	     	</ul>	     
		</div>
	{/if}

