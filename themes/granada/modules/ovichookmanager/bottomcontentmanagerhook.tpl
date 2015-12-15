<div class="container">
   <div class="home-product-slider slider-type-2">
      <h2 class="sub-title secondary-font"><span>{l s='Bestsellers' mod='ovichookmanager'}</span></h2>
      <div class="products-slider items-slider bestseller column4">
         <div class="row">
            {$blockbestsellers}
         </div>
      </div>
      <script type="text/javascript">
      //<![CDATA[
            $(document).ready(function(){
                $('#blockbestsellers').owlCarousel({
                    loop:true,
                    margin:0,
                    responsiveClass:true,
                    responsive:{
                        0:{
                            items:1,
                            nav:true
                        },
                        496:{
                            items:2,
                            nav:true
                        },
                        768:{
                            items:3,
                            nav:true
                        },
                        1200:{
                            items:4,
                            nav:true
                        }
                    }
                });
            });
      //]]>
   </script>
   </div>
</div>