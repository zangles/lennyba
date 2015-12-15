{if $comment.id_smart_blog_comment != ''}
	<li class="comment-{$comment.id_smart_blog_comment}" id="comment-{$comment.id_smart_blog_comment}" >
		<div class="comment">
            <figure>
                <img src="{$modules_dir}/smartblog/images/avatar/avatar-author-default.jpg" alt=" {$childcommnets.name}" />
            </figure>
            <div class="comment-content">
                <h5><a href="#">{$childcommnets.name}</a></h5>
                <p>{$childcommnets.content}</p>
                {if Configuration::get('smartenablecomment') == 1}
					{if $comment_status == 1}
						<span class="comment-meta">
							<span>{$childcommnets.created|date_format}</span>
							<span class="separator">|</span>
							<a href="javasript:void(0)" onclick="return addComment.moveForm('comment-{$comment.id_smart_blog_comment}', '{$comment.id_smart_blog_comment}', 'respond', '{$smarty.get.id_post}')"  class="comment-reply-link comment-reply">{l s='Reply' mod='smartblog'}</a>
						</span>
					{else}
						<span class="comment-meta"><span>{$childcommnets.created|date_format}</span></span>
					{/if}
				{else}
					<span class="comment-meta"><span>{$childcommnets.created|date_format}</span></span>
				{/if}                    
            </div>
        </div>            
		{if isset($childcommnets.child_comments)}
			<ul class="comments">
			{foreach from=$childcommnets.child_comments item=comment}  
				{if isset($childcommnets.child_comments)}
					{$i=$i+1}
					{include file="./comment_loop.tpl" childcommnets=$comment i=$i}							
				{/if}
			{/foreach}
			</ul>
		{/if}
	</li>	
{/if}
                                        
                                        