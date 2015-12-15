{*
*  @author Ovic-soft <nguyencaoson.zpt@gmail.com>
*  @copyright  2010-2015
*}
			
		
    {if isset($HOOK_HOME_TOP_COLUMN) && $HOOK_HOME_TOP_COLUMN|trim}
      <section>
	      <div class="container">
	      	
	      		{$HOOK_HOME_TOP_COLUMN}	
	      		      	
	      </div>
      </section>
      <div class="lg-margin2x"></div>
    {/if}
<section id="content" role="main">
		{if isset($HOME_TOP_CONTENT) && $HOME_TOP_CONTENT|trim}
	        {$HOME_TOP_CONTENT}
	    {/if}
   	 	
        
        <div class="md-margin2x half hidden-xs"></div>
        <div class="sm-margin visible-xs"></div>
       	{if isset($HOOK_HOME) && $HOOK_HOME|trim}
	    	{$HOOK_HOME}
	    {/if}
	    
						
	
	
</section><!-- .columns-container -->


