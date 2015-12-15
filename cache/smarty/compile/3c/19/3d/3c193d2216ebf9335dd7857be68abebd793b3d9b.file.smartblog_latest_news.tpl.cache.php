<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 11:27:47
         compiled from "/home/u481889647/public_html/themes/granada/modules/smartbloghomelatestnews/views/templates/front/granada_left/smartblog_latest_news.tpl" */ ?>
<?php /*%%SmartyHeaderCode:27952845627a0e39b3b04-78734670%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3c193d2216ebf9335dd7857be68abebd793b3d9b' => 
    array (
      0 => '/home/u481889647/public_html/themes/granada/modules/smartbloghomelatestnews/views/templates/front/granada_left/smartblog_latest_news.tpl',
      1 => 1445437516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27952845627a0e39b3b04-78734670',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'view_data' => 0,
    'post' => 0,
    'options' => 0,
    'modules_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5627a0e39dcca9_43565074',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5627a0e39dcca9_43565074')) {function content_5627a0e39dcca9_43565074($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/u481889647/public_html/tools/smarty/plugins/modifier.date_format.php';
?>	<div class="lg-margin2x hidden-sm hidden-xs"></div>
	<div class="md-margin2x visible-sm visible-xs"></div>
	<div class="carousel-container">
		<h2 class="carousel-title"><?php echo smartyTranslate(array('s'=>'From the blog','mod'=>'smartbloghomelatestnews'),$_smarty_tpl);?>
</h2>
		<div class="row">
			<?php if (isset($_smarty_tpl->tpl_vars['view_data']->value)&&!empty($_smarty_tpl->tpl_vars['view_data']->value)) {?>
			<div class="owl-carousel from-theblog-carousel from-theblog-wide">
				<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(1, null, 0);?>
				<?php  $_smarty_tpl->tpl_vars['post'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['post']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['view_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['post']->key => $_smarty_tpl->tpl_vars['post']->value) {
$_smarty_tpl->tpl_vars['post']->_loop = true;
?>
                    <?php $_smarty_tpl->tpl_vars["options"] = new Smarty_variable(null, null, 0);?>
                    <?php $_smarty_tpl->createLocalArrayVariable('options', null, 0);
$_smarty_tpl->tpl_vars['options']->value['id_post'] = $_smarty_tpl->tpl_vars['post']->value['id'];?>
                    <?php $_smarty_tpl->createLocalArrayVariable('options', null, 0);
$_smarty_tpl->tpl_vars['options']->value['slug'] = $_smarty_tpl->tpl_vars['post']->value['link_rewrite'];?>
                    <article class="article">
                        <div class="article-media-container"><a href="<?php echo smartblog::GetSmartBlogLink('smartblog_post',$_smarty_tpl->tpl_vars['options']->value);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['modules_dir']->value;?>
smartblog/images/<?php echo $_smarty_tpl->tpl_vars['post']->value['post_img'];?>
-home-default.jpg" class="img-responsive" alt="<?php echo $_smarty_tpl->tpl_vars['post']->value['title'];?>
"></a></div>
                        <div class="article-meta-box"><span class="article-icon article-date-icon"></span> <span class="meta-box-text"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['post']->value['date_added'],"%d %b");?>
</span></div>
                        <div class="article-meta-box article-meta-comments"><span class="article-icon article-comment-icon"></span> <a href="#" class="meta-box-text"><?php echo Blogcomment::getToltalComment($_smarty_tpl->tpl_vars['post']->value['id']);?>
 <?php echo smartyTranslate(array('s'=>'Com','mod'=>'smartbloghomelatestnews'),$_smarty_tpl);?>
</a></div>
                        <h3><a href="<?php echo smartblog::GetSmartBlogLink('smartblog_post',$_smarty_tpl->tpl_vars['options']->value);?>
"><?php echo $_smarty_tpl->tpl_vars['post']->value['title'];?>
</a></h3>
                        <p><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['post']->value['short_description'],150,"..."), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
                        <a href="<?php echo smartblog::GetSmartBlogLink('smartblog_post',$_smarty_tpl->tpl_vars['options']->value);?>
" class="readmore" role="button"><?php echo smartyTranslate(array('s'=>'Read More','mod'=>'smartbloghomelatestnews'),$_smarty_tpl);?>
</a>
                     </article>
				<?php } ?>
				
			</div>			
			<?php }?>
		</div>		
	</div>
	<div class="md-margin2x hidden-xs"></div>
	<div class="xlg-margin visible-xs"></div>
<?php }} ?>
