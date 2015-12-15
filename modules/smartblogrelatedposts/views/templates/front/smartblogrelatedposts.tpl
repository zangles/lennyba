{if isset($posts) AND !empty($posts)}
<div class="carousel-container">
	<h3 class="carousel-title">{l s='Related Posts: ' mod='smartblogrelatedposts'}</h3>
	<div class="row">
		<div class="owl-carousel related-posts-carousel">
			{foreach from=$posts item="post"}				
                {assign var="options" value=null}
                {$options.id_post= $post.id_smart_blog_post}
                {$options.slug= $post.link_rewrite}                
                <article class="article">
	                <div class="article-media-container">
	                	<a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" title="{$post.meta_title}">
	                		<img src="{$modules_dir}smartblog/images/{$post.id_smart_blog_post}-home-default.jpg" class="img-responsive" alt="{$post.meta_title}" />
	                	</a>	                    
	                </div>
	                <div class="article-meta-box">
	                	<span class="article-icon article-date-icon"></span>  
	                	<span class="meta-box-text">{$post.created|date_format:"%d %b"}</span>
	                </div>
	                <h4><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" title="{$post.meta_title}">{$post.meta_title}</a></h4>
	                <p>{$post.short_description|truncate:150:"..."|escape:'htmlall':'UTF-8'}</p>
	                <a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" class="readmore" title="{l s='Read More' mod='smartblogrelatedposts'}" role="button">{l s='Read More' mod='smartblogrelatedposts'}</a>
	            </article>
            {/foreach}			
		</div>
	</div>
</div>	
{/if}