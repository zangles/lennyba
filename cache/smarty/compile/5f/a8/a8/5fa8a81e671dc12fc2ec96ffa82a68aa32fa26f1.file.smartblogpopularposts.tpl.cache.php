<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 11:27:47
         compiled from "/home/u481889647/public_html/themes/granada/modules/smartblogpopularposts/views/templates/front/granada_left/smartblogpopularposts.tpl" */ ?>
<?php /*%%SmartyHeaderCode:754681385627a0e37c0b78-36686084%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5fa8a81e671dc12fc2ec96ffa82a68aa32fa26f1' => 
    array (
      0 => '/home/u481889647/public_html/themes/granada/modules/smartblogpopularposts/views/templates/front/granada_left/smartblogpopularposts.tpl',
      1 => 1445437516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '754681385627a0e37c0b78-36686084',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'posts' => 0,
    'post' => 0,
    'options' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5627a0e37dc8d0_80754417',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5627a0e37dc8d0_80754417')) {function content_5627a0e37dc8d0_80754417($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['posts']->value)&&!empty($_smarty_tpl->tpl_vars['posts']->value)) {?>
<div class="widget">
   <h3><?php echo smartyTranslate(array('s'=>'Popular Posts','mod'=>'smartblogpopularposts'),$_smarty_tpl);?>
 </h3>
   <div class="owl-carousel popular-posts-slider">
      <?php $_smarty_tpl->tpl_vars['nextItem'] = new Smarty_variable(0, null, 0);?>
      <div class="article-list"> 
      <?php  $_smarty_tpl->tpl_vars["post"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["post"]->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['posts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars["post"]->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars["post"]->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['blog_posts']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars["post"]->key => $_smarty_tpl->tpl_vars["post"]->value) {
$_smarty_tpl->tpl_vars["post"]->_loop = true;
 $_smarty_tpl->tpl_vars["post"]->iteration++;
 $_smarty_tpl->tpl_vars["post"]->last = $_smarty_tpl->tpl_vars["post"]->iteration === $_smarty_tpl->tpl_vars["post"]->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['blog_posts']['index']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['blog_posts']['last'] = $_smarty_tpl->tpl_vars["post"]->last;
?>
            <?php $_smarty_tpl->tpl_vars["options"] = new Smarty_variable(null, null, 0);?>
            <?php $_smarty_tpl->createLocalArrayVariable('options', null, 0);
$_smarty_tpl->tpl_vars['options']->value['id_post'] = $_smarty_tpl->tpl_vars['post']->value['id_smart_blog_post'];?>
            <?php $_smarty_tpl->createLocalArrayVariable('options', null, 0);
$_smarty_tpl->tpl_vars['options']->value['slug'] = $_smarty_tpl->tpl_vars['post']->value['link_rewrite'];?>          
            <article class="article">
	            <div class="article-meta-box"><span class="article-icon article-date-icon"></span> <span class="meta-box-text"><?php echo date('d M',strtotime($_smarty_tpl->tpl_vars['post']->value['created']));?>
</span></div>
	            <h4><a href="<?php echo smartblog::GetSmartBlogLink('smartblog_post',$_smarty_tpl->tpl_vars['options']->value);?>
" title="<?php echo $_smarty_tpl->tpl_vars['post']->value['meta_title'];?>
"><?php echo $_smarty_tpl->tpl_vars['post']->value['meta_title'];?>
</a></h4>
	         </article>		         
	         <?php if (($_smarty_tpl->getVariable('smarty')->value['foreach']['blog_posts']['index']%3==2)&&!$_smarty_tpl->getVariable('smarty')->value['foreach']['blog_posts']['last']) {?> 
				</div>
				<div class="article-list"> 
			<?php }?>	                                        
        <?php } ?>  
        </div>    	
   </div>
</div>
<?php }?>
<?php }} ?>
