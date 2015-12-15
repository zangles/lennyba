<div id="dialog-product-list" class="modal dts-modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <span class="modal-title">{l s=' Add product' mod='megamenus'}</span>
            </div>
            <div class="modal-body">
                <div class="table-responsive" >
                    <div class="clearfix">
                        <div class="form-inline pull-left">
                            <input type="text" class="form-control keyword" placeholder="{l s='ID or Name' mod='flexiblecustom'}" />
                            <button class="btn btn-default" type="button" onclick="loadProductList('1')"><i class="icon-search"></i> {l s='Search' mod='simplecategory'}</button>
                        </div>                        
                        <div id="manual-product-list-pagination" class="pull-right"></div>
                    </div>
                    <table class="table" id="manual-product-list" style="margin-top: 10px">
            			<thead>
            				<tr class="nodrag nodrop">                            
                                <th width="30" class="center">{l s='ID' mod='megamenus'}</th>
                                <th width="50" class="center">{l s='Image' mod='megamenus'}</th>
                                <th>{l s='Name' mod='megamenus'}</th>                                                                
                                <th width="30" class="">{l s='Action' mod='megamenus'}</th>
                            </tr>				
                        </thead>    
                        <tbody></tbody>
        	       </table>                   
                </div>                
            </div>           
        </div>
    </div>
</div>
{literal}
	<script type="text/javascript" language="JavaScript">
        jQuery(function($){
            $('#dialog-product-list').on('hidden.bs.modal', function (e) {
            	if($(".manual-product-list").length >0 ){
            		$(".manual-product-list").each(function (){
            			if(!$(this).hasClass('ui-sortable')) $(this).sortable({placeholder: "ui-state-highlight"});		
            		});
            	}
            });	
            $(document).on('click', '.link-open-dialog-manual-product', function(){
                showModal('dialog-product-list'); 
                loadProductList(1);
            });
            $(document).on('click','.link-add-manual-product',function(){        
                var itemId = $(this).attr('data-id');   
                var itemName = $(this).attr('data-name');                
            	$(this).removeClass('link-add-manual-product').addClass('link-add-manual-product-off').html('<i class="icon-check-square-o"></i>');
    	        var html = '<li id="manual-product-'+itemId+'" class="manual-product"><input type="hidden" class="manual_product_id" name="product_ids[]" value="'+itemId+'" /><span>'+itemName+'</span><a title="'+lab_delete+'" href="javascript:void(0)" class="link-trash-manual-product c-red pull-right" data-id="'+itemId+'"><i class="icon-trash"></i></a></li>';
    	        $("#manual-product-list").append(html);
        	});
            $(document).on('click','.link-trash-manual-product',function(){        
                var itemId = $(this).data().id; 
                $("#manual-product-"+itemId).remove();
                if($("#manual-product-"+itemId).length >0){
                	$("#manual-product-"+itemId).removeClass('link-add-manual-product-off').addClass('link-add-manual-product').html('<i class="icon-plus"></i>');
                }
        	});    
        });    
        function loadProductList(page){
            var error = false;
            var keyword = $("#dialog-product-list .keyword").val();
            var productIds = new Array();
            if($("#modalGroup").hasClass('in')){
            	if($("#modalGroup .manual_product_id").length >0){
        	    	$("#modalGroup .manual_product_id").each(function (index){
        	    		productIds[index] = $(this).val();
        	    	});
        	    }
        	    var categoryId = $("#modalGroup #group-product-category :selected").val();
            }else error = true;
            if(error == false){
                var data={'action':'loadProductList', 'categoryId':categoryId, 'productIds':productIds, 'page':page, 'keyword':keyword, 'secure_key':secure_key};
                $.ajax({
            		type:'POST',
            		url: currentUrl,
            		data: data,
            		dataType:'json',
            		cache:false,
            		async: true,
            		beforeSend: function(){},
            		complete: function(){},
            		success: function(response){
                        $("#manual-product-list-pagination").html(response.pagination);
                        $("#manual-product-list >tbody").html(response.list);										
            		}		
            	});    
            }
            
        }
	</script>
{/literal}