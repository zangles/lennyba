{if isset($posts) AND !empty($posts)}
<div class="widget">
   <h3>{l s='Popular Posts' mod='smartblogpopularposts'} </h3>
   <div class="owl-carousel popular-posts-slider">
      {assign var='nextItem' value=0}
      <div class="article-list"> 
      {foreach from=$posts item="post" name=blog_posts}
            {assign var="options" value=null}
            {$options.id_post= $post.id_smart_blog_post}
            {$options.slug= $post.link_rewrite}          
            <article class="article">
	            <div class="article-meta-box"><span class="article-icon article-date-icon"></span> <span class="meta-box-text">{date('d M', strtotime($post.created))}</span></div>
	            <h4><a href="{smartblog::GetSmartBlogLink('smartblog_post',$options)}" title="{$post.meta_title}">{$post.meta_title}</a></h4>
	         </article>		         
	         {if ($smarty.foreach.blog_posts.index % 3 == 2) && !$smarty.foreach.blog_posts.last} 
				</div>
				<div class="article-list"> 
			{/if}	                                        
        {/foreach}  
        </div>    	
   </div>
</div>
{/if}
