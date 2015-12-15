<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 11:19:06
         compiled from "/home/u481889647/public_html/admin823g1fycx/themes/default/template/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:151426732156279eda9d8b38-05442962%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '60aa3f52b328b5e99963653be16b8a119deb0d60' => 
    array (
      0 => '/home/u481889647/public_html/admin823g1fycx/themes/default/template/content.tpl',
      1 => 1445407545,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '151426732156279eda9d8b38-05442962',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56279edaa07ac0_72201131',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56279edaa07ac0_72201131')) {function content_56279edaa07ac0_72201131($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>


<div class="row">
	<div class="col-lg-12">
		<?php if (isset($_smarty_tpl->tpl_vars['content']->value)) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div><?php }} ?>
