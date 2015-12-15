<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 12:05:24
         compiled from "/home/u481889647/public_html/admin/themes/default/template/controllers/logs/employee_field.tpl" */ ?>
<?php /*%%SmartyHeaderCode:167379196656277f840ad942-27974602%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '40975a18a76480469556a37e321ef8536653782c' => 
    array (
      0 => '/home/u481889647/public_html/admin/themes/default/template/controllers/logs/employee_field.tpl',
      1 => 1445407819,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '167379196656277f840ad942-27974602',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'employee_image' => 0,
    'employee_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56277f840c65f1_03508908',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56277f840c65f1_03508908')) {function content_56277f840c65f1_03508908($_smarty_tpl) {?>
<span class="employee_avatar_small">
	<img class="imgm img-thumbnail" alt="" src="<?php echo $_smarty_tpl->tpl_vars['employee_image']->value;?>
" width="32" height="32" />
</span>
<?php echo $_smarty_tpl->tpl_vars['employee_name']->value;?>
<?php }} ?>
