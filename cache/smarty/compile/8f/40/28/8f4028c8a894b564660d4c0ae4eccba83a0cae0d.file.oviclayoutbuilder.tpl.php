<?php /* Smarty version Smarty-3.1.19, created on 2015-10-21 20:07:25
         compiled from "/home/u481889647/public_html/modules/oviclayoutcontrol/views/templates/admin/layout_builder/oviclayoutbuilder.tpl" */ ?>
<?php /*%%SmartyHeaderCode:54136816456281aad44e690-98127207%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f4028c8a894b564660d4c0ae4eccba83a0cae0d' => 
    array (
      0 => '/home/u481889647/public_html/modules/oviclayoutcontrol/views/templates/admin/layout_builder/oviclayoutbuilder.tpl',
      1 => 1445437517,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '54136816456281aad44e690-98127207',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'view' => 0,
    'postUrl' => 0,
    'options' => 0,
    'option' => 0,
    'absoluteUrl' => 0,
    'thumbnails_dir' => 0,
    'id_copy_option' => 0,
    'id_option' => 0,
    'multistyle' => 0,
    'optionModulesHook' => 0,
    'templatePath' => 0,
    'logo_url' => 0,
    'displayLeft' => 0,
    'homeWidth' => 0,
    'displayRight' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56281aad6c9498_93746296',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56281aad6c9498_93746296')) {function content_56281aad6c9498_93746296($_smarty_tpl) {?><div id="ovicLayoutSeting">
<?php if ($_smarty_tpl->tpl_vars['view']->value=='displaylist') {?>
    <div class="panel clearfix" >
        <h3><i class="icon-list-ul"></i><?php echo smartyTranslate(array('s'=>' Options list','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

            <span class="panel-heading-action">
        		<a class="list-toolbar-btn newoption" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&view=setting">
        			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new option" data-html="true">
        				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new option','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

        			</span>
        		</a>
        	</span>
        </h3>
        <div class="main-container">
        <?php if (isset($_smarty_tpl->tpl_vars['options']->value)&&count($_smarty_tpl->tpl_vars['options']->value)>0) {?>
            <table class="table">
                <thead>
                    <th width="5%">id</th>
                    <th width="15%">name</th>
                    <th width="35%">Support Layout</th>
                    <th width="25%">Thumbnail</th>
                    <th width="10%">Alias</th>
                    <th width="10%">Acive</th>
                    <th width="10%">Action</th>
                </thead>
                <tbody>
                    <?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['options']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value) {
$_smarty_tpl->tpl_vars['option']->_loop = true;
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['option']->value['id_option'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['option']->value['name'];?>
</td>
                            <td class="colsetting-container">
                                <?php if (strpos($_smarty_tpl->tpl_vars['option']->value['column'],"0")!==false) {?>
                                    <label class="colactive">
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['absoluteUrl']->value;?>
/img/3col.png" alt=""/>
                                    </label>
                                <?php }?>
                                <?php if (strpos($_smarty_tpl->tpl_vars['option']->value['column'],"1")!==false) {?>
                                    <label class="colactive">
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['absoluteUrl']->value;?>
/img/leftonly.png" alt=""/>
                                    </label>
                                <?php }?>
                                <?php if (strpos($_smarty_tpl->tpl_vars['option']->value['column'],"2")!==false) {?>
                                    <label class="colactive">
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['absoluteUrl']->value;?>
/img/rightonly.png" alt=""/>
                                    </label>
                                <?php }?>
                                <?php if (strpos($_smarty_tpl->tpl_vars['option']->value['column'],"3")!==false) {?>
                                    <label class="colactive">
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['absoluteUrl']->value;?>
/img/full.png" alt=""/>
                                    </label>
                                <?php }?>
                            </td>
                            <td><?php if ($_smarty_tpl->tpl_vars['option']->value['image']) {?><div class="thumb-review"><img class="img-thumbnail" src="<?php echo $_smarty_tpl->tpl_vars['thumbnails_dir']->value;?>
/thumbnails/<?php echo $_smarty_tpl->tpl_vars['option']->value['image'];?>
" alt="" /></div><?php }?></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['option']->value['alias'];?>
</td>
                            <td>
                                    <?php if ($_smarty_tpl->tpl_vars['option']->value['active']) {?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['postUrl']->value;?>
&changeactive&id_option=<?php echo $_smarty_tpl->tpl_vars['option']->value['id_option'];?>
" data-toggle="tooltip" class="label-tooltip list-action-enable action-enabled" data-html="true" data-original-title="Actived" >
                                        
                                            <i class="icon-check"></i>
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['postUrl']->value;?>
&changeactive&id_option=<?php echo $_smarty_tpl->tpl_vars['option']->value['id_option'];?>
" data-toggle="tooltip" class="label-tooltip list-action-enable action-disabled" data-html="true" data-original-title="Deactived" >
                                        
                                            <i class="icon-remove"></i>
                                        </a>
                                    <?php }?>
                            </td>
                            <td>
                                <div class="btn-group-action">
                                    <div class="btn-group pull-right">
                                        <?php if ($_smarty_tpl->tpl_vars['option']->value['active']) {?>
                					       <a href="<?php echo $_smarty_tpl->tpl_vars['postUrl']->value;?>
&view=detail&id_option=<?php echo $_smarty_tpl->tpl_vars['option']->value['id_option'];?>
" title="Edit" class="btn btn-default">
                    	                       <i class="icon-wrench"></i> Configure
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['postUrl']->value;?>
&view=setting&id_option=<?php echo $_smarty_tpl->tpl_vars['option']->value['id_option'];?>
" title="Edit" class="btn btn-default">
                    	                       <i class="icon-pencil"></i> Edit
                                            </a>
                                        <?php }?>
                                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                						  <i class="icon-caret-down"></i>&nbsp;
        					            </button>
                						<ul class="dropdown-menu">
                                            <?php if ($_smarty_tpl->tpl_vars['option']->value['active']) {?>
                                            <li>
                                                <a href="<?php echo $_smarty_tpl->tpl_vars['postUrl']->value;?>
&view=setting&id_option=<?php echo $_smarty_tpl->tpl_vars['option']->value['id_option'];?>
" title="Edit" >
                        	                       <i class="icon-pencil"></i> Edit
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <?php }?>
                                            <li>
                								<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&view=setting&submitCopyOption&id_copy_option=<?php echo $_smarty_tpl->tpl_vars['option']->value['id_option'];?>
" title="Duplicate" onclick="return confirm('Are you sure copy this option.')">
                	                               <i class="icon-copy"></i> Duplicate
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="<?php echo $_smarty_tpl->tpl_vars['postUrl']->value;?>
&removeoption&id_option=<?php echo $_smarty_tpl->tpl_vars['option']->value['id_option'];?>
" onclick="return confirm('Are you sure delete this option, including option\'s modules Positions?')" title="Delete" class="delete">
                	                               <i class="icon-trash"></i> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                				</div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php }?>
        </div>
    </div>
<?php } elseif ($_smarty_tpl->tpl_vars['view']->value=='setting') {?>
    <div class="panel clearfix" >
        <h3><i class="icon-list-ul"></i><?php echo smartyTranslate(array('s'=>' Options Setting','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

        </h3>
        <form id="layoutconfigure" method="post" action="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" enctype="multipart/form-data" class="item-form defaultForm  form-horizontal">
            <input type="hidden" name="id_option" value="<?php if (isset($_smarty_tpl->tpl_vars['option']->value->id_option)) {?><?php echo $_smarty_tpl->tpl_vars['option']->value->id_option;?>
<?php }?>"/>
            <?php if (isset($_smarty_tpl->tpl_vars['id_copy_option']->value)) {?>
                <input type="hidden" name="id_copy_option" value="<?php echo $_smarty_tpl->tpl_vars['id_copy_option']->value;?>
"/>
            <?php }?>
            <input type="hidden" name="view" value="setting"/>
            <div class="title item-field form-group">
				<label id="title_lb" class="control-label col-lg-3 "><?php echo smartyTranslate(array('s'=>'Name','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>
</label>
                <div class="col-lg-9">
                    <div class="form-group">
			            <div class="col-lg-9">
			                <input class="form-control" type="text" id="option_name" name="option_name" value="<?php if (isset($_smarty_tpl->tpl_vars['option']->value->name)) {?><?php echo $_smarty_tpl->tpl_vars['option']->value->name;?>
<?php }?>"/>
			            </div>
						<div class="col-lg-2">
						</div>
                     </div>
				</div>
			</div>
            <div class="title item-field form-group">
				<label id="title_lb" class="control-label col-lg-3 "><?php echo smartyTranslate(array('s'=>'Alias','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>
</label>
                <div class="col-lg-9">
                    <div class="form-group">
    		            <div class="col-lg-9">
    		                <input class="form-control" type="text" id="alias" name="alias" value="<?php if (isset($_smarty_tpl->tpl_vars['option']->value->alias)) {?><?php echo $_smarty_tpl->tpl_vars['option']->value->alias;?>
<?php }?>"/>
    		            </div>
    					<div class="col-lg-2">
    					</div>
                     </div>
				</div>
			</div>
            <div class="item-field form-group">
                <label for="colsetting" class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Support Layout','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>
</label>
                <div class="col-lg-9 colsetting-container">
                    <div class="form-group">
                        <div class="col-lg-9">
                            <span class="fixed-width-lg<?php if (isset($_smarty_tpl->tpl_vars['option']->value->id_option)&&$_smarty_tpl->tpl_vars['option']->value->id_option) {?> not-editable<?php } else { ?> editable<?php }?>">
                                
                                <input type="hidden" name="colselected" id="colselected" value="<?php if (isset($_smarty_tpl->tpl_vars['option']->value->column)) {?><?php echo $_smarty_tpl->tpl_vars['option']->value->column;?>
<?php } else { ?>0<?php }?>" />
                                <input class="colsetting multiselect" type="checkbox" name="colsetting" id="3column" <?php if ((isset($_smarty_tpl->tpl_vars['option']->value->column)&&strpos($_smarty_tpl->tpl_vars['option']->value->column,"0")!==false)||!isset($_smarty_tpl->tpl_vars['option']->value->column)) {?>checked="checked"<?php }?> value="0"/>
                                <label <?php if ((isset($_smarty_tpl->tpl_vars['option']->value->column)&&strpos($_smarty_tpl->tpl_vars['option']->value->column,"0")!==false)||!isset($_smarty_tpl->tpl_vars['option']->value->column)) {?>class="colactive"<?php }?> for="3column"><img src="<?php echo $_smarty_tpl->tpl_vars['absoluteUrl']->value;?>
/img/3col.png" alt=""/></label>
                                
                                <input class="colsetting multiselect" type="checkbox" name="colsetting" id="leftonly"<?php if (isset($_smarty_tpl->tpl_vars['option']->value->column)&&strpos($_smarty_tpl->tpl_vars['option']->value->column,"1")!==false) {?>checked="checked"<?php }?> value="1" />
                                <label <?php if (isset($_smarty_tpl->tpl_vars['option']->value->column)&&strpos($_smarty_tpl->tpl_vars['option']->value->column,"1")!==false) {?>class="colactive"<?php }?> for="leftonly"><img src="<?php echo $_smarty_tpl->tpl_vars['absoluteUrl']->value;?>
/img/leftonly.png" alt=""/></label>
                                
                                <input class="colsetting multiselect" type="checkbox" name="colsetting" id="rightonly" <?php if (isset($_smarty_tpl->tpl_vars['option']->value->column)&&strpos($_smarty_tpl->tpl_vars['option']->value->column,"2")!==false) {?>checked="checked"<?php }?> value="2" />
                                <label <?php if (isset($_smarty_tpl->tpl_vars['option']->value->column)&&strpos($_smarty_tpl->tpl_vars['option']->value->column,"2")!==false) {?>class="colactive"<?php }?> for="rightonly"><img src="<?php echo $_smarty_tpl->tpl_vars['absoluteUrl']->value;?>
/img/rightonly.png" alt=""/></label>
                                
                                <input class="colsetting multiselect" type="checkbox" name="colsetting" id="nocolumn" <?php if (isset($_smarty_tpl->tpl_vars['option']->value->column)&&strpos($_smarty_tpl->tpl_vars['option']->value->column,"3")!==false) {?>checked="checked"<?php }?> value="3" />
                                <label <?php if (isset($_smarty_tpl->tpl_vars['option']->value->column)&&substr_count($_smarty_tpl->tpl_vars['option']->value->column,"3")>0) {?>class="colactive"<?php }?> for="nocolumn"><img src="<?php echo $_smarty_tpl->tpl_vars['absoluteUrl']->value;?>
/img/full.png" alt=""/></label>
                            </span>
                        </div>
                        <div class="col-lg-2">
        				</div>
                    </div>
                </div>
            </div>
            <div class="image item-field form-group">
				<label class="control-label col-lg-3">Thumbnails</label>
				<div class="col-lg-9">
                    <div class="form-group">
                        <div class="col-lg-9">
                            <?php if (isset($_smarty_tpl->tpl_vars['option']->value->image)) {?>
                                <img class="img-thumbnail" src="<?php echo $_smarty_tpl->tpl_vars['thumbnails_dir']->value;?>
/thumbnails/<?php echo $_smarty_tpl->tpl_vars['option']->value->image;?>
" alt="" />
                            <?php }?>
        					<input type="file" name="option_img" />
                            <input type="hidden" name="old_img" value="<?php if (isset($_smarty_tpl->tpl_vars['option']->value->image)) {?><?php echo $_smarty_tpl->tpl_vars['option']->value->image;?>
<?php }?>"/>
                        </div>
                        <div class="col-lg-2">
                        </div>
                    </div>
				</div>
			</div>
            <div class="item-field form-group ">
                <label for="active" class="control-label col-lg-3">Active</label>
                <div class="col-lg-9">
                    <div class="form-group">
                        <div class="col-lg-9">
                            <span class="switch prestashop-switch fixed-width-lg">
                                <input type="radio" name="active" id="active_on" <?php if (isset($_smarty_tpl->tpl_vars['option']->value->active)&&$_smarty_tpl->tpl_vars['option']->value->active==1) {?>checked="checked"<?php }?> value="1"/>
                                <label for="active_on">Yes</label>
                                <input type="radio" name="active" id="active_off" <?php if (isset($_smarty_tpl->tpl_vars['option']->value->active)&&$_smarty_tpl->tpl_vars['option']->value->active==0||!isset($_smarty_tpl->tpl_vars['option']->value->active)) {?>checked="checked"<?php }?> value="0" />
                                <label for="active_off">No</label>
                                <a class="slide-button btn"></a>
                            </span>
                        </div>
                        <div class="col-lg-2">
						</div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button type="submit" value="1" name="submitnewOption" class="btn btn-default pull-right" onclick="this.form.submit();">
                <i class="process-icon-save"></i> Save
				</button>
				<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" class="btn btn-default" onclick="window.history.back();">
					<i class="process-icon-cancel"></i> Cancel
				</a>
			</div>
        </form>
    </div>
<?php } elseif ($_smarty_tpl->tpl_vars['view']->value=='detail') {?>
    <div class="panel clearfix" >
        <h3>
            <i class="icon-list-ul"></i><?php echo smartyTranslate(array('s'=>' Layout Configure','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

            <span class="panel-heading-action">
        		<a class="list-toolbar-btn show_color" href="javascript:void(0)">
        			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Display color setting" data-html="true">
        				<?php echo smartyTranslate(array('s'=>' Color setting','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

        			</span>
        		</a>
        	</span>
        </h3>
        <input id="ajaxUrl" type="hidden" name="ajaxUrl" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1" />
        <input id="id_option" type="hidden" name="id_option" value="<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
" />
        <div id="multistyle_container">
            <?php echo $_smarty_tpl->tpl_vars['multistyle']->value;?>

        </div>
        <div class="panel">
            <h3>
                <?php echo smartyTranslate(array('s'=>' displayNav','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                <span class="panel-heading-action">
            		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayNav']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
            			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
            				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

            			</span>
            		</a>
            	</span>
            </h3>
            <div id="displayNav" class="hookContainer ui-sortable">
            <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayNav']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayNav']['modules'])>0) {?>
                <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayNav']['id_hook'];?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp2=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp1,'id_option'=>$_tmp2,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayNav']['modules'],'dataname'=>"displayNavModules"), 0);?>

            <?php }?>
            </div>
        </div>
        <div class="clearfix">
            <div class="panel col-sm-4">
                <h3><?php echo smartyTranslate(array('s'=>' displayBeforeLogo','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                    <span class="panel-heading-action">
                		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayBeforeLogo']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
                			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
                				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                			</span>
                		</a>
                	</span>
                </h3>
                <div id="displayBeforeLogo" class="hookContainer ui-sortable">
                    <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayBeforeLogo']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayBeforeLogo']['modules'])>0) {?>
                        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayBeforeLogo']['id_hook'];?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp4=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp3,'id_option'=>$_tmp4,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayBeforeLogo']['modules'],'dataname'=>"displayBeforeLogoModules"), 0);?>

                    <?php }?>
                </div>
            </div>
            <div class="panel col-sm-4">
                <img class="logo img-responsive" src="<?php echo $_smarty_tpl->tpl_vars['logo_url']->value;?>
" alt=""/>
            </div>
            <div class="panel col-sm-4">
                <h3><?php echo smartyTranslate(array('s'=>' displayTop','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                    <span class="panel-heading-action">
                		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayTop']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
                			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
                				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                			</span>
                		</a>
                	</span>
                </h3>
                <div id="displayTop" class="hookContainer ui-sortable">
                    <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayTop']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayTop']['modules'])>0) {?>
                        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayTop']['id_hook'];?>
<?php $_tmp5=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp6=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp5,'id_option'=>$_tmp6,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayTop']['modules'],'dataname'=>"displayTopModules"), 0);?>

                    <?php }?>
                </div>
            </div>
        </div>
        <div class="panel">
            <h3><?php echo smartyTranslate(array('s'=>' displayTopColumn','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                <span class="panel-heading-action">
            		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayTopColumn']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
            			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
            				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

            			</span>
            		</a>
            	</span>
            </h3>
            <div id="displayTopColumn" class="hookContainer ui-sortable">
                <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayTopColumn']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayTopColumn']['modules'])>0) {?>
                    <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayTopColumn']['id_hook'];?>
<?php $_tmp7=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp8=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp7,'id_option'=>$_tmp8,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayTopColumn']['modules'],'dataname'=>"displayTopColumnModules"), 0);?>

                <?php }?>
            </div>
        </div>
        <hr class="homeline"/>
        <div class="panel">
            <h3><?php echo smartyTranslate(array('s'=>' displayHomeTopColumn','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                <span class="panel-heading-action">
            		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTopColumn']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
            			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
            				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

            			</span>
            		</a>
            	</span>
            </h3>
            <div id="displayHomeTopColumn" class="hookContainer ui-sortable">
                <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTopColumn']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTopColumn']['modules'])>0) {?>
                    <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTopColumn']['id_hook'];?>
<?php $_tmp9=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp10=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp9,'id_option'=>$_tmp10,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTopColumn']['modules'],'dataname'=>"displayHomeTopColumnModules"), 0);?>

                <?php }?>
            </div>
        </div>
        <div class="clearfix">
            <?php if ($_smarty_tpl->tpl_vars['displayLeft']->value) {?>
                <div class="panel col-sm-3">
                    <h3><?php echo smartyTranslate(array('s'=>' displayLeftColumn','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                        <span class="panel-heading-action">
                    		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayLeftColumn']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
                    			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
                    				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                    			</span>
                    		</a>
                    	</span>
                    </h3>
                    <div id="displayLeftColumn" class="hookContainer ui-sortable">
                        <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayLeftColumn']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayLeftColumn']['modules'])>0) {?>
                            <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayLeftColumn']['id_hook'];?>
<?php $_tmp11=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp12=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp11,'id_option'=>$_tmp12,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayLeftColumn']['modules'],'dataname'=>"displayLeftColumnModules"), 0);?>

                        <?php }?>
                    </div>
                </div>
            <?php }?>
            <div id="center_column" class="col-sm-<?php echo intval($_smarty_tpl->tpl_vars['homeWidth']->value);?>
<?php if (!$_smarty_tpl->tpl_vars['displayLeft']->value) {?> hide_left<?php }?><?php if (!$_smarty_tpl->tpl_vars['displayRight']->value) {?> hide_right<?php }?>">
                <div class="panel">
                    <h3><?php echo smartyTranslate(array('s'=>' displayHomeTopContent','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                        <span class="panel-heading-action">
                    		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTopContent']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
                    			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
                    				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                    			</span>
                    		</a>
                    	</span>
                    </h3>
                    <div id="displayHomeTopContent" class="hookContainer ui-sortable">
                        <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTopContent']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTopContent']['modules'])>0) {?>
                            <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTopContent']['id_hook'];?>
<?php $_tmp13=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp14=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp13,'id_option'=>$_tmp14,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTopContent']['modules'],'dataname'=>"displayHomeTopContentModules"), 0);?>

                        <?php }?>
                    </div>
                </div>
                <div class="panel">
                    <h3><?php echo smartyTranslate(array('s'=>' displayHomeTab','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                        <span class="panel-heading-action">
                		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTab']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
                			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
                				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                			</span>
                		</a>
                	</span>
                    </h3>
                    <div id="displayHomeTab" class="hookTabContainer ui-sortable">
                        <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTab']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTab']['modules'])>0) {?>
                            <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTab']['id_hook'];?>
<?php $_tmp15=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp16=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp15,'id_option'=>$_tmp16,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTab']['modules'],'dataname'=>"displayHomeTabModules"), 0);?>

                        <?php }?>
                    </div>
                </div>
                <div class="panel">
                    <h3><?php echo smartyTranslate(array('s'=>' displayHomeTabContent','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                        <span class="panel-heading-action">
                    		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTabContent']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
                    			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
                    				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                    			</span>
                    		</a>
                    	</span>
                    </h3>
                    <div id="displayHomeTabContent" class="hookTabContentContainer ui-sortable">
                        <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTabContent']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTabContent']['modules'])>0) {?>
                            <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTabContent']['id_hook'];?>
<?php $_tmp17=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp18=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp17,'id_option'=>$_tmp18,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeTabContent']['modules'],'dataname'=>"displayHomeTabContentModules"), 0);?>

                        <?php }?>
                    </div>
                </div>
                <div class="panel">
                    <h3><?php echo smartyTranslate(array('s'=>' displayHome','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                        <span class="panel-heading-action">
                    		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHome']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
                    			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
                    				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                    			</span>
                    		</a>
                    	</span>
                    </h3>
                    <div id="displayHome" class="hookContainer ui-sortable">
                        <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHome']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHome']['modules'])>0) {?>
                            <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHome']['id_hook'];?>
<?php $_tmp19=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp20=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp19,'id_option'=>$_tmp20,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHome']['modules'],'dataname'=>"displayHomeModules"), 0);?>

                        <?php }?>
                    </div>
                </div>
                <div class="panel">
                    <h3><?php echo smartyTranslate(array('s'=>' displayHomeBottomContent','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                        <span class="panel-heading-action">
                    		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeBottomContent']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
                    			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
                    				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                    			</span>
                    		</a>
                    	</span>
                    </h3>
                    <div id="displayHomeBottomContent" class="hookContainer ui-sortable">
                        <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeBottomContent']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeBottomContent']['modules'])>0) {?>
                            <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeBottomContent']['id_hook'];?>
<?php $_tmp21=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp22=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp21,'id_option'=>$_tmp22,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeBottomContent']['modules'],'dataname'=>"displayHomeBottomContentModules"), 0);?>

                        <?php }?>
                    </div>
                </div>
            </div>
            <?php if ($_smarty_tpl->tpl_vars['displayRight']->value) {?>
            <div class="panel col-sm-3">
                <h3><?php echo smartyTranslate(array('s'=>' displayRightColumn','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                    <span class="panel-heading-action">
                		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayRightColumn']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
                			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
                				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                			</span>
                		</a>
                	</span>
                </h3>
                <div id="displayRightColumn" class="hookContainer ui-sortable">
                    <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayRightColumn']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayRightColumn']['modules'])>0) {?>
                        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayRightColumn']['id_hook'];?>
<?php $_tmp23=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp24=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp23,'id_option'=>$_tmp24,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayRightColumn']['modules'],'dataname'=>"displayRightColumnModules"), 0);?>

                    <?php }?>
                </div>
            </div>
            <?php }?>
        </div>
        <div class="panel">
            <h3><?php echo smartyTranslate(array('s'=>' displayHomeBottomColumn','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                <span class="panel-heading-action">
            		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeBottomColumn']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
            			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
            				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

            			</span>
            		</a>
            	</span>
            </h3>
            <div id="displayHomeBottomColumn" class="hookContainer ui-sortable">
                <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeBottomColumn']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeBottomColumn']['modules'])>0) {?>
                    <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeBottomColumn']['id_hook'];?>
<?php $_tmp25=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp26=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp25,'id_option'=>$_tmp26,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayHomeBottomColumn']['modules'],'dataname'=>"displayHomeBottomColumnModules"), 0);?>

                <?php }?>
            </div>
        </div>
        <hr class="homeline"/>
        <div class="panel">
            <h3><?php echo smartyTranslate(array('s'=>' displayBottomColumn','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                <span class="panel-heading-action">
            		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayBottomColumn']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
            			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
            				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

            			</span>
            		</a>
            	</span>
            </h3>
            <div id="displayBottomColumn" class="hookContainer ui-sortable">
                <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayBottomColumn']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayBottomColumn']['modules'])>0) {?>
                    <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayBottomColumn']['id_hook'];?>
<?php $_tmp27=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp28=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp27,'id_option'=>$_tmp28,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayBottomColumn']['modules'],'dataname'=>"displayBottomColumnModules"), 0);?>

                <?php }?>
            </div>
        </div>
        <div class="panel">
            <h3><?php echo smartyTranslate(array('s'=>' displayFooter','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

                <span class="panel-heading-action">
            		<a class="list-toolbar-btn newmodulehook" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ajax=1&action=displayModulesHook&id_hook=<?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayFooter']['id_hook'];?>
&id_option=<?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
">
            			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new module" data-html="true">
            				<i class="process-icon-new "></i> <?php echo smartyTranslate(array('s'=>' Add new module','mod'=>'oviclayoutbuilder'),$_smarty_tpl);?>

            			</span>
            		</a>
            	</span>
            </h3>
            <div id="displayFooter" class="hookContainer ui-sortable">
                <?php if ($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayFooter']['modules']&&count($_smarty_tpl->tpl_vars['optionModulesHook']->value['displayFooter']['modules'])>0) {?>
                    <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['optionModulesHook']->value['displayFooter']['id_hook'];?>
<?php $_tmp29=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['id_option']->value;?>
<?php $_tmp30=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['templatePath']->value)."layout_builder/modules.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_hook'=>$_tmp29,'id_option'=>$_tmp30,'modules'=>$_smarty_tpl->tpl_vars['optionModulesHook']->value['displayFooter']['modules'],'dataname'=>"displayFooterModules"), 0);?>

                <?php }?>
            </div>
        </div>
        <div class="panel-footer">
			<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['postUrl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" class="btn btn-default" onclick="window.history.back();">
				<i class="process-icon-back"></i> Back
			</a>
		</div>
    </div>
<?php }?>
</div><?php }} ?>
