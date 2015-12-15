
{if count($languages) > 1}
	<div class="language-dropdown dropdown">
       <a title="Language" class="dropdown-toggle" data-toggle="dropdown">
       		{foreach from=$languages key=k item=language name="languages"}
    			{if $language.iso_code == $lang_iso}
    				<span class="long-name">{$language.name}</span>
					<span class="short-name">{$language.iso_code}</span>	    				
    			{/if}
    		{/foreach}				
		</a>
       <ul class="dropdown-menu">
       		{foreach from=$languages key=k item=language name="languages"}
       			<li {if $language.iso_code == $lang_iso}class="active"{/if}>           				
					<a href="{$link->getLanguageLink($language.id_lang)|escape:htmlall}" title="{$language.name}">
						{$language.name}						
           				<img src="{$img_lang_dir}{$language.id_lang}.jpg" alt="{$language.iso_code}" />
       				</a>								
       			</li>					
			{/foreach}				
       </ul>
    </div>    
{/if}
