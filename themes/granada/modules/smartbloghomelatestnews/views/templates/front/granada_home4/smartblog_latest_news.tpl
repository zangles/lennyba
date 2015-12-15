	<div class="lg-margin2x hidden-sm hidden-xs"></div>
	<div class="md-margin2x visible-sm visible-xs"></div>
<div class="container">
	<div class="carousel-container">
		<h2 class="small-title big text-center">{l s='From the blog' mod='smartbloghomelatestnews'}</h2>
		<div class="row">
			{if isset($view_data) AND !empty($view_data)}
			<div class="owl-carousel blog-posts-carousel center-buttons">
				{assign var='i' value=1}
				{foreach from=$view_data item=post}
                    {assign var="options" value=null}
                    {$options.id_post = $post.id}
                    {$options.slug = $post.link_rewrite}
                    <article class="article">
                        <div class="article-media-container"><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}"><img src="{$modules_dir}smartblog/images/{$post.post_img}-home-default.jpg" class="img-responsive" alt="{$post.title}"></a></div>
                        <div class="article-meta-box"><span class="article-icon article-date-icon"></span> <span class="meta-box-text">{$post.date_added|date_format:"%d %b"}</span></div>
                        <div class="article-meta-box article-meta-comments"><span class="article-icon article-comment-icon"></span> <a href="#" class="meta-box-text">{Blogcomment::getToltalComment($post.id)} {l s='Com' mod='smartbloghomelatestnews'}</a></div>
                        <h3><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.title}</a></h3>
                        <p>{$post.short_description|truncate:150:"..."|escape:'htmlall':'UTF-8'}</p>
                        <a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" class="readmore" role="button">{l s='Read More' mod='smartbloghomelatestnews'}</a>
                     </article>
				{/foreach}
				
			</div>			
			{/if}
		</div>		
	</div>
</div>