{*}{Blogcomment::getToltalComment($post.id_post)}{*}
{assign var="options" value=null}
{$options.id_post = $post.id_post} 
{$options.slug = $post.link_rewrite}
{assign var="cat_options" value=null}
{if isset($post.cat_name) && $post.cat_name}
	{$cat_options.name = $post.cat_name}
	{$cat_options.id_category = $post.id_category}
	{$cat_options.slug = $post.cat_link_rewrite}
{else}
	{if isset($id_category) && $id_category >0}
		{$cat_options.name = $title_category}
		{$cat_options.id_category = $id_category}
		{$cat_options.slug = $cat_link_rewrite}
	{/if}
{/if}

<article class="article">
    <div class="article-media-container">
        <a title="{$post.meta_title}" href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">
            <img src="{$modules_dir}/smartblog/images/{$post.post_img}-single-default.jpg" class="img-responsive" alt="{$post.meta_title}">
        </a>
    </div>
    <div class="article-meta-box"><span class="article-icon article-date-icon"></span>  <span class="meta-box-text">{$post.created|date_format:"%d %b"}</span>
    </div>
    <div class="article-meta-box article-meta-comments"><span class="article-icon article-comment-icon"></span>  <a href="#" class="meta-box-text">{$post.totalcomment} {l s='Com' mod='smartblog'}</a>
    </div>
    <h2><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.meta_title}</a></h2>
    <p>{$post.meta_description}</p>
    <div class="article-meta-container clearfix"><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" class="readmore button_111_hover" role="button">{l s='Read More' mod='smartblog'}</a>
        <div class="article-meta-wrapper">
        		<span class="article-meta">{l s='By' mod='smartblog'} 
        			<a href="#" title="{$post.firstname} {$post.lastname}">{$post.firstname} {$post.lastname}</a>
        		</span>  
        		{if $cat_options != null}
        		<span class="article-meta">
        			<a href="{smartblog::GetSmartBlogLink('smartblog_category',$cat_options)}" title="{$cat_options.name}">{$cat_options.name}</a>        			
        		</span>
        		{/if}
        		<span class="article-meta">{$post.viewed} {l s='Views' mod="smartblog"}</span>
        </div>
    </div>
</article>

