{if isset($latesComments) AND !empty($latesComments)}
<div class="widget">
    <h3>{l s='Comments' mod='smartbloglatestcomments'}</h3>
    <div class="owl-carousel comments-slider">
        <div class="comment-list">
        	{foreach from=$latesComments item="comment" name=blog_posts}
            {assign var="options" value=null}
            {$options.id_post= $comment.id_post}
            {$options.slug= $comment.slug}
	            <div class="comment">
	                <figure class="comment-media-container">
	                    <img src="{$modules_dir}/smartblog/images/avatar/avatar-author-default.jpg" alt="User">
	                </figure>
	                <div class="comment-meta">
	                    <h4><a href="#">{$comment.name}</a></h4><span class="comment-date">{$comment.created|date_format}</span>
	                    <p>{$comment.content|truncate:45:"..."|escape:'htmlall':'UTF-8'}</p>
	                </div>
	            </div>           
               {if ($smarty.foreach.blog_posts.index % 2) && !$smarty.foreach.blog_posts.last} 
					</div>
					<div class="comment-list"> 
				{/if}
          {/foreach}
        </div>        
    </div>
</div>
{/if}