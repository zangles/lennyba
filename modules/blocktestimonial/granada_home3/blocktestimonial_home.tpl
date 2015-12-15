
    {if $testimonials|@count > 0}
    <!-- MODULE Block ovictestimonial -->
    
        <div class="container">
            <div class="testimonials-section">
                <h3 class="testimonials-title">{$TESTIMONIAL_TITLE}</h3>
                <div id="testimonials-slider">
                    {foreach from=$testimonials item=info}
                    <div class="item">
                        <div class="icon-quote">&amp;nbsp;</div>
                        <div class="testimonials-content">{$info.text|escape:html:'UTF-8'}</div>
                        <div class="testimonials-author">{$info.name|escape:html:'UTF-8'} {*}{$info.company|escape:html:'UTF-8'}{*}</div>
                    </div>
                    {/foreach}
                </div>
            </div>
        </div>
    
    <!-- /MODULE Block ovictestimonial -->
    {/if}
