{*
*  @author Ovic-soft <nguyencaoson.zpt@gmail.com>
*  @copyright  2010-2015
*}
			
		
{if isset($HOOK_HOME_TOP_COLUMN) && $HOOK_HOME_TOP_COLUMN|trim}
      {$HOOK_HOME_TOP_COLUMN}
{/if}

{if isset($HOME_TOP_CONTENT) && $HOME_TOP_CONTENT|trim}
  <section class="hook-home-top-content">
      <div class="container">
      	<div class="row">	      		
      		{$HOME_TOP_CONTENT}	
      	</div>	      	
      </div>
  </section>
  
{/if}
{if isset($HOOK_HOME) && $HOOK_HOME|trim}
  <section class="hook-home">
      <div class="container">
      	<div class="row">	      		
      		{$HOOK_HOME}	
      	</div>	      	
      </div>
  </section>
  <div class="lg-margin2x"></div>
  <div class="md-margin"></div>
{/if}
{if isset($HOME_BOTTOM_CONTENT) && $HOME_BOTTOM_CONTENT|trim}
  <section class="hook-home-bottom-content">
      <div class="container">
      	<div class="row">	      		
      		{$HOME_BOTTOM_CONTENT}	
      	</div>	      	
      </div>
  </section>
{/if}
