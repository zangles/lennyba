{*
*  @author Ovic-soft <nguyencaoson.zpt@gmail.com>
*  @copyright  2010-2015
*}
			
		
{if isset($HOOK_HOME_TOP_COLUMN) && $HOOK_HOME_TOP_COLUMN|trim}
  <section>
      <div class="container">
      	<div class="row mixed-banner-row">	      		
      		{$HOOK_HOME_TOP_COLUMN}	
      	</div>	      	
      </div>
  </section>
{/if}
{if isset($HOME_TOP_CONTENT) && $HOME_TOP_CONTENT|trim}
  <section class="hook-home-top-content">
      <div class="container">      	
      	{$HOME_TOP_CONTENT}	
      </div>
  </section>
  <div class="lg-margin2x"></div>
{/if}
{if isset($HOOK_HOME) && $HOOK_HOME|trim}	
	{$HOOK_HOME}
	<div class="lg-margin2x"></div>
	<div class="md-margin"></div>	
{/if}
