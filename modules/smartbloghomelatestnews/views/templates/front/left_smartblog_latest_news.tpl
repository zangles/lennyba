{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('left_smartblog_latest_news.tpl','smartbloghomelatestnews')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}	
	{if isset($view_data) AND !empty($view_data)}
	<div class="widget">
	   <h3>{l s='Latest Posts' mod='smartbloghomelatestnews'} </h3>
	   <div class="owl-carousel latest-posts-slider">
	      <div class="article-list">
	      {foreach from=$view_data item="post" name=blog_posts}
	            {assign var="options" value=null}
                    {$options.id_post = $post.id}
                    {$options.slug = $post.link_rewrite}
	            <article class="article">
                    <div class="article-media-container">
                        <a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">
                            <img src="{$modules_dir}smartblog/images/{$post.post_img}-home-default.jpg" class="img-responsive" alt="{$post.title}">
                        </a>
                    </div>
                    <div class="article-meta-box"><span class="article-icon article-date-icon"></span>  <span class="meta-box-text">{$post.date_added|date_format:"%d %b"}</span>
                    </div>
                    <h4><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}">{$post.title}</a></h4>
                    <p>{$post.short_description|truncate:150:"..."|escape:'htmlall':'UTF-8'}</p><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" class="readmore" role="button">{l s='Read More' mod='smartbloghomelatestnews'}</a>
                </article>                           
		         {if ($smarty.foreach.blog_posts.index % 2) && !$smarty.foreach.blog_posts.last} 
					</div>
					<div class="article-list"> 
				{/if}	                                        
	        {/foreach}  
	        </div>    	
	   </div>
	</div>
	{/if}

{/if}