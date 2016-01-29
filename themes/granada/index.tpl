{*
*  @author Ovic-soft <nguyencaoson.zpt@gmail.com>
*  @copyright  2010-2015
*}
{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('index.tpl')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
	{assign var='left_column_size' value=0}{assign var='right_column_size' value=0}
	{if isset($HOOK_LEFT_COLUMN) && $HOOK_LEFT_COLUMN|trim && !$hide_left_column}{$left_column_size=3}{/if}
	{if isset($HOOK_RIGHT_COLUMN) && $HOOK_RIGHT_COLUMN|trim && !$hide_right_column}{$right_column_size=3}{/if}

	{assign var='left_column' value=false}
	{assign var='right_column' value=false}
	{if isset($HOOK_LEFT_COLUMN) && $HOOK_LEFT_COLUMN|trim && !$hide_left_column}
		{$left_column=true}
	{/if}
	{if isset($HOOK_RIGHT_COLUMN) && $HOOK_RIGHT_COLUMN|trim && !$hide_right_column}
		{$right_column=true}
	{/if}
	<section id="content" role="main">
		<div id="columns" class="container">
			<div class="row">
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						<li data-target="#carousel-example-generic" data-slide-to="1"></li>
					</ol>


					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<img src="{$base_dir}/img/azs/slider/slide_1.jpg" alt="...">
							<div class="carousel-caption" style="margin-bottom: 175px;">
								<p>INTRODUCING</p>
								<h1>GITANO SS16</h1>
								<a href="{$link->getCMSLink('7-gitano-ss16' )|escape:'html':'UTF-8'}">
									<div class="btn-action">VER CAMPAÑA</div>
								</a>
							</div>
						</div>
						<div class="item">
							<img src="{$base_dir}/img/azs/slider/slide_2.jpg" alt="...">
							<div class="carousel-caption" style="margin-bottom: 175px;">
								<p>INTRODUCING</p>
								<h1>GITANO SS16</h1>
								<a href="{$link->getCMSLink('7-gitano-ss16')|escape:'html':'UTF-8'}">
									<div class="btn-action">VER CAMPAÑA</div>
								</a>
							</div>
						</div>
					</div>

					<!-- Controls -->
					<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>



				{*<div class="col-md-9 col-md-push-3 col-sm-12">*}
				    {*{if isset($HOME_TOP_CONTENT) && $HOME_TOP_CONTENT|trim}*}
				        {*{$HOME_TOP_CONTENT}*}
				    {*{/if}			   *}
				    {*{if isset($HOOK_HOME) && $HOOK_HOME|trim}*}
				    	{*<div class="lg-margin hidden-xs"></div>*}
				    	{*<div class="xs-margin visible-xs"></div>*}
				    	{*{$HOOK_HOME}*}
				    {*{/if}				    *}
			    {*</div><!-- #center_column -->*}
			    {*<aside class="col-md-3 col-md-pull-9 col-sm-12 sidebar home-sidebar dark" role="complementary">{$HOOK_LEFT_COLUMN}</aside>			    *}
			</div>
			<div class="row" style="color: white;">
				<div class="col-sm-12">
					<div class="backgroundResponsive" style="
						background-image: url('/img/azs/shop_1.gif');
						display: table;
						overflow: hidden;
						height: 500px;
						margin-top: 80px;
						">
						<div class="text-center verticalcenter">
							<p style="margin-bottom: -12px;">New</p>
							<p style="font-size: 50px">ARRIVALS </p>
							<a href="{$link->getCategoryLink(12)|escape:'html':'UTF-8'}">
								<div class="btn-action" style="background-color: white;color: black;">COMPRAR</div>
							</a>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="backgroundResponsive" style="
						background-image: url('/img/azs/shop_2.gif');
						display: table;
						overflow: hidden;
						height: 500px;
						margin-top: 80px;
						">
						<div class="text-center verticalcenter">
							<p  style="font-size: 50px;margin-top: 12px;">ACCESORIOS</p>
							<a href="{$link->getCategoryLink(71)|escape:'html':'UTF-8'}">
								<div class="btn-action"  style="background-color: white;color: black;">COMPRAR</div>
							</a>
						</div>

					</div>
				</div>
			</div>

			<div class="row" style="margin-top: 100px;">
				<div class="col-md-24">
					<iframe src="https://player.vimeo.com/video/143423491?title=0&byline=0&portrait=0" width="100%" height="700" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
				</div>
			</div>

			<div class="row" style="margin-top: 100px;">
				<div id="carousel-example-generic1" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					{*<ol class="carousel-indicators">*}
						{*<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>*}
						{*<li data-target="#carousel-example-generic" data-slide-to="1"></li>*}
						{*<li data-target="#carousel-example-generic" data-slide-to="2"></li>*}
					{*</ol>*}
					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<img src="/img/azs/home_lookbook_1920x900px.jpg" alt="...">
							<div class="carousel-caption" style="left: 0%;">
								<div class="text-center verticalcenter" style="padding-left: 27%;
																				color: black;
																				padding-bottom: 100px;
																				text-shadow: none;">
									<p>SPRING / SUMMER 2016</p>
									<h1 style="font-size: 65px;">LOOKBOOK</h1>
									<p>New beginnings, new inspirations, new LENNY Collection.</p>
									<a href="{$link->getCMSLink('8-01')|escape:'html':'UTF-8'}">
										<div class="btn-action">VER LOOKBOOK</div>
									</a>
								</div>
							</div>
						</div>
						<div class="item">
							<img src="/img/azs/home_lookbook2_1920x900.jpg" alt="...">
							<div class="carousel-caption" style="left: 0%;">
								<div class="text-center verticalcenter" style="padding-left: 27%;
																				color: black;
																				padding-bottom: 100px;
																				text-shadow: none;">
									<p>SPRING / SUMMER 2016</p>
									<h1 style="font-size: 65px;">LOOKBOOK</h1>
									<p>New beginnings, new inspirations, new LENNY Collection.</p>
									<a href="{$link->getCMSLink('8-01')|escape:'html':'UTF-8'}">
										<div class="btn-action">VER LOOKBOOK</div>
									</a>
								</div>
							</div>
						</div>
						<div class="item">
							<img src="/img/azs/home_lookbook3_1920x900.jpg" alt="...">
							<div class="carousel-caption" style="left: 0%;">
								<div class="text-center verticalcenter" style="padding-left: 27%;
																				color: black;
																				padding-bottom: 100px;
																				text-shadow: none;">
									<p>SPRING / SUMMER 2016</p>
									<h1 style="font-size: 65px;">LOOKBOOK</h1>
									<p>New beginnings, new inspirations, new LENNY Collection.</p>
									<a href="{$link->getCMSLink('8-01')|escape:'html':'UTF-8'}">
										<div class="btn-action">VER LOOKBOOK</div>
									</a>
								</div>
							</div>
						</div>
					</div>

					<!-- Controls -->
					<a class="left carousel-control" href="#carousel-example-generic1" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#carousel-example-generic1" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>

			<div class="row" style="margin-top: 75px">
				<div class="col-md-24 text-center">
					<h1>NEWSLETTER</h1>
					<p style="color: black"> Suscribite ahora y estarás al día de nuestras novedades, últimos lookbooks y promociones exclusivas</p>
				</div>
				<div class="col-md-6 col-md-offset-9">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Enter email address" aria-describedby="basic-addon2">
						<span class="input-group-addon" style="text-align: center" id="basic-addon2">SIGN UP</span>
					</div>
				</div>
			</div>
		</div><!-- #columns -->

	</section><!-- .columns-container -->
	<script>
		$(document).ready(function(){
			$('.carousel').carousel();
		});
	</script>
{/if}
