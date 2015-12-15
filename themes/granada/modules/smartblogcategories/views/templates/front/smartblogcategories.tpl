{if isset($categories) AND !empty($categories)}
<div class="widget">	
    <h3>{l s='Categories' mod='smartblogcategories'}</h3>
    <ul class="category-widget" id="category-widget">
	{foreach from=$categories item="category"}
        {assign var="options" value=null}
        {$options.id_category = $category.id_smart_blog_category}
        {$options.slug = $category.link_rewrite}
        	<li class="cleafix"><a href="{smartblog::GetSmartBlogLink('smartblog_category',$options)}">{$category.meta_title} {*}<span class="badge post-count pull-right">{$category.count}</span>{*}</a>
            
	{/foreach}
    </ul>
</div>    
{/if}