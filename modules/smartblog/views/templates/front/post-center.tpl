<article class="article">
    {*}
    <div id="post-id-20" class="article-media-container carousel slide" data-ride="carousel" data-interval="6000">
        <div class="carousel-inner">
            <div class="item active">
                <img src="images/blog/post4.jpg" class="img-responsive" alt="Slider 1">
            </div>
            <div class="item">
                <img src="images/blog/post2.jpg" class="img-responsive" alt="Slider 2">
            </div>
            <div class="item">
                <img src="images/blog/post3.jpg" class="img-responsive" alt="Slider 3">
            </div>
        </div><a class="left carousel-control" href="#post-id-20" role="button" data-slide="prev">Prev</a>  <a class="right carousel-control" href="#post-id-20" role="button" data-slide="next">Next</a>
    </div>
    {*}
    {assign var="activeimgincat" value='0'}
    {$activeimgincat = $smartshownoimg} 
    {if ($post_img != "no" && $activeimgincat == 0) || $activeimgincat == 1}
        <div id="post-id-{$id_post}" class="article-media-container">
	    	<img src="{$modules_dir}/smartblog/images/{$post_img}-single-default.jpg" alt="{$meta_title}" />
	    </div>
    {/if}    
    <div class="article-meta-box"><span class="article-icon article-date-icon"></span>  <span class="meta-box-text">{$created|date_format:"%d %b"}</span></div>
    <div class="article-meta-box article-meta-comments"><span class="article-icon article-comment-icon"></span>  <a href="#" class="meta-box-text">{$countcomment} {l s='Com' mod='smartblog'}</a></div>
    <h2>{$meta_title}</h2>
    <div class="post-dec">{$content}</div>
    <div class="sm-margin"></div>
    <div class="article-meta-container clearfix">
        <ul class="article-meta-list pull-left">
            <li><span>{l s='Author' mod='smartblog'}:</span>{$firstname} {$lastname}</li>
            <li>
            	<span>Tags:</span>
            	{foreach from=$tags item="tag" name=blog_tags}
				{assign var="options" value=null}
				    {$options.tag = $tag.name}
				    {if $tag!=""}
				        <a href="{smartblog::GetSmartBlogLink('smartblog_tag',$options)}" title="{$tag.name}">{$tag.name}</a>{if !$smarty.foreach.blog_tags.last}, {/if}
				    {/if}
				{/foreach}
            </li>
        </ul>
        {if isset($HOOK_EXTRA_RIGHT) && $HOOK_EXTRA_RIGHT}{$HOOK_EXTRA_RIGHT}{/if}        
    </div>
</article>
<div class="sm-margin"></div>

{hook h='displaySmartAfterPost'}


{if Configuration::get('smartenablecomment') == 1}
{if $comment_status == 1}

	<div class="comments-area" id="comments">
		{if $comments && $comments|@count >0}
        <h3>Comments ({$countcomment})</h3>        
        <ul class="comments">
			
            {foreach from=$comments item=comment}
            	{$i=1}
				{include file="./comment_loop.tpl" childcommnets=$comment i=$i}
			{/foreach}
        </ul>
        {/if}
        <div id="respond">
	        <h3 class="cleafix comment-reply-title" id="reply-title">{l s='Write your review' mod='smartblog'} 
	        	<small style="float:right;">
	                <a style="display: none;" href="/wp/sellya/sellya/this-is-a-post-with-preview-image/#respond" id="cancel-comment-reply-link" rel="nofollow">{l s="Cancel Reply"  mod="smartblog"}</a>
	           </small>
			</h3>
	        <div id="commentInput">
	        	<form action="" method="post" id="commentform">
		            <input type='hidden' name='comment_post_ID' value='1478' id='comment_post_ID' />
					<input type='hidden' name='id_post' value='{$id_post}' id='id_post' />
					<input type='hidden' name='comment_parent' id='comment_parent' value='0' />
		            <div class="row">
		                <div class="col-sm-6">
		                    <div class="form-group">
		                        <input type="text" name="name" class="form-control input-lg inputName" required placeholder="{l s='Enter your nickname' mod='smartblog'} *">
		                    </div>
		                    <div class="form-group">
		                        <input type="email" name="mail" class="form-control input-lg inputMail" required placeholder="{l s='Enter your e-mail' mod='smartblog'} *">
		                    </div>
		                    <div class="form-group">
		                        <input type="text" name="website" class="form-control input-lg" placeholder="{l s='Summary of your review' mod='smartblog'}">
		                    </div>
		                </div>
		                <div class="col-sm-6">
		                    <textarea class="form-control min-height input-lg inputContent" name="comment" cols="30" rows="6" placeholder="{l s='Write your review' mod='smartblog'} *"></textarea>
		                </div>
		            </div>
		            {if Configuration::get('smartcaptchaoption') == '1'}
		            <div class="row">
		                <div class="col-sm-6">
		                    <div class="form-group">
		                        <input type="text" name="smartblogcaptcha" class="form-control input-lg smartblogcaptcha" required placeholder="{l s='Enter captcha' mod='smartblog'} *">
		                    </div>                  
		                </div>
		                <div class="col-sm-6">
		                   <img src="{$modules_dir}smartblog/classes/CaptchaSecurityImages.php?width=100&height=40&characters=5">
		                </div>
		            </div>
		            {/if}
		            <div class="xss-margin"></div>
		            <div class="form-group">
		            	<input type="submit" name="addComment" id="submitComment" class="btn btn-lg btn-custom-5 button_111_hover" value="Post Comment">
		            </div>
		       </form>
	    	</div>
    	</div>    	
	</div>








<script type="text/javascript">
$('#submitComment').bind('click',function(event) {
event.preventDefault();
 
 
var data = { 'action':'postcomment', 
'id_post':$('input[name=\'id_post\']').val(),
'comment_parent':$('input[name=\'comment_parent\']').val(),
'name':$('input[name=\'name\']').val(),
'website':$('input[name=\'website\']').val(),
'smartblogcaptcha':$('input[name=\'smartblogcaptcha\']').val(),
'comment':$('textarea[name=\'comment\']').val(),
'mail':$('input[name=\'mail\']').val() };
	$.ajax( {
	  url: baseDir + 'modules/smartblog/ajax.php',
	  data: data,
	  
	  dataType: 'json',
	  
	  beforeSend: function() {
				$('.success, .warning, .error').remove();
				$('#submitComment').attr('disabled', true);
				$('#commentInput').before('<div class="attention"><img src="http://321cart.com/sellya/catalog/view/theme/default/image/loading.gif" alt="" />Please wait!</div>');

				},
		complete: function() {
				$('#submitComment').attr('disabled', false);
				$('.attention').remove();
				},
		success: function(json) {
			if (json['error']) {
					 
						$('#commentInput').before('<div class="warning">' + '<i class="icon-warning-sign icon-lg"></i>' + json['error']['common'] + '</div>');
						
						if (json['error']['name']) {
							$('.inputName').after('<span class="error">' + json['error']['name'] + '</span>');
						}
						if (json['error']['mail']) {
							$('.inputMail').after('<span class="error">' + json['error']['mail'] + '</span>');
						}
						if (json['error']['comment']) {
							$('.inputContent').after('<span class="error">' + json['error']['comment'] + '</span>');
						}
						if (json['error']['captcha']) {
							$('.smartblogcaptcha').after('<span class="error">' + json['error']['captcha'] + '</span>');
						}
					}
					
					if (json['success']) {
						$('input[name=\'name\']').val('');
						$('input[name=\'mail\']').val('');
						$('input[name=\'website\']').val('');
						$('textarea[name=\'comment\']').val('');
				 		$('input[name=\'smartblogcaptcha\']').val('');
					
						$('#commentInput').before('<div class="success">' + json['success'] + '</div>');
						setTimeout(function(){
							$('.success').fadeOut(300).delay(450).remove();
													},2500);
					
					}
				}
			} );
		} );
		
 




    var addComment = {
		moveForm : function(commId, parentId, respondId, postId) {
		
		var t = this, div, comm = t.I(commId), respond = t.I(respondId), cancel = t.I('cancel-comment-reply-link'), parent = t.I('comment_parent'), post = t.I('comment_post_ID');		
		if ( ! comm || ! respond || ! cancel || ! parent ){
			return;
		}
			
 
		t.respondId = respondId;
		postId = postId || false;

		if ( ! t.I('wp-temp-form-div') ) {
			div = document.createElement('div');
			div.id = 'wp-temp-form-div';
			div.style.display = 'none';
			respond.parentNode.insertBefore(div, respond);
		}

		
		comm.parentNode.insertBefore(respond, comm.nextSibling);
		if ( post && postId ) post.value = postId;
		parent.value = parentId;
		cancel.style.display = '';

		cancel.onclick = function() {
			var t = addComment, temp = t.I('wp-temp-form-div'), respond = t.I(t.respondId);

			if ( ! temp || ! respond )
				return;

			t.I('comment_parent').value = '0';
			temp.parentNode.insertBefore(respond, temp);
			temp.parentNode.removeChild(temp);
			this.style.display = 'none';
			this.onclick = null;
			return false;
		};

		try { t.I('comment').focus(); }
		catch(e) {}

		return false;
	},

	I : function(e) {
		return document.getElementById(e);
	}
};

      
      
</script>
{/if}
{/if}

