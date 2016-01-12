<div class="row clearfix">

	<div class="col-sm-24 contact-container">
        <div class="row">
            <div class="col-sm-17">
                {if isset($confirmation)}
                    <p class="alert alert-success">{l s='Your message has been successfully sent to our team.'}</p>
                    <ul class="footer_links clearfix">
                        <li>
                            <a class="btn btn-default button button-small" href="{$base_dir}">
                        <span>
                            <i class="icon-chevron-left"></i>{l s='Home'}
                        </span>
                            </a>
                        </li>
                    </ul>
                {elseif isset($alreadySent)}
                    <p class="alert alert-warning">{l s='Your message has already been sent.'}</p>
                    <ul class="footer_links clearfix">
                        <li>
                            <a class="btn btn-default button button-small" href="{$base_dir}">
                        <span>
                            <i class="icon-chevron-left"></i>{l s='Home'}
                        </span>
                            </a>
                        </li>
                    </ul>
                {else}
                    {include file="$tpl_dir./errors.tpl"}
                    <div class="clearfix">
                        <form action="{$request_uri|escape:'html':'UTF-8'}" method="post" class="contact-form-box" enctype="multipart/form-data">

                            <fieldset>
                                <h2 class="page-subheading">{l s='Contactanos'}</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email" class="form-label">{l s='NOMBRE'}</label>
                                            {if isset($customerThread.nombre)}
                                                <input class="form-control grey input-lg" type="text" id="nombre" name="nombre" value="{$customerThread.nombre|escape:'html':'UTF-8'}" readonly="readonly" />
                                            {else}
                                                <input class="form-control grey input-lg" type="text" id="nombre" name="nombre" value="{$nombre|escape:'html':'UTF-8'}" />
                                            {/if}
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="form-label">{l s='E-MAIL'}</label>
                                            {if isset($customerThread.email)}
                                                <input class="form-control grey input-lg" type="text" id="email" name="from" value="{$customerThread.email|escape:'html':'UTF-8'}" readonly="readonly" />
                                            {else}
                                                <input class="form-control grey input-lg validate" type="text" id="email" name="from" data-validate="isEmail" value="{$email|escape:'html':'UTF-8'}" />
                                            {/if}
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="form-label">{l s='ASUNTO'}</label>
                                            {if isset($customerThread.asunto)}
                                                <input class="form-control grey input-lg" type="text" id="asunto" name="asunto" value="{$customerThread.asunto|escape:'html':'UTF-8'}" readonly="readonly" />
                                            {else}
                                                <input class="form-control grey input-lg" type="text" id="asunto" name="asunto" value="{$asunto|escape:'html':'UTF-8'}" />
                                            {/if}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="message" class="form-label">{l s='MENSAJE'}</label>
                                            <textarea class="form-control input-lg min-height" id="message" name="message">{if isset($message)}{$message|escape:'html':'UTF-8'|stripslashes}{/if}</textarea>
                                        </div>
                                        <div class="submit">
                                            <button type="submit" name="submitMessage" id="submitMessage" class="btn btn-lg btn-custom-5"><span>{l s='Enviar'}</span></button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                {/if}
            </div>
            <div class="col-sm-7">
                <address>
                    Teléfono:  4774-929<br>
                    Dirección: Chenaut 1715  5ºC <br>
                    Horario: Lun-Vie 14:00-20:00 <br>
                    Email: info@lennyba.com.ar
                </address>
            </div>
        </div>

    </div>
</div>        
<div class="xlg-margin visible-xs clearfix"></div>
<div class="row clearfix">
    {hook h="displayBottomContact"}                
</div>
{addJsDefL name='contact_fileDefaultHtml'}{l s='No file selected' js=1}{/addJsDefL}
{addJsDefL name='contact_fileButtonHtml'}{l s='Choose File' js=1}{/addJsDefL}
{addJsDef map=''}
{addJsDef markers=array()}
{addJsDef infoWindow=''}
{addJsDef defaultLat=$defaultLat}
{addJsDef defaultLong=$defaultLong}
{addJsDef distance_unit=$distanceUnit}
{addJsDef img_store_dir=$img_store_dir}
{addJsDef img_ps_dir=$img_ps_dir}
{addJsDef searchUrl=$searchUrl}
{addJsDef logo_store=$logo_store}
{addJsDef tpl_uri=$tpl_uri}
{addJsDef hasStoreIcon=$hasStoreIcon}
{addJsDefL name=translation_1}{l s='No stores were found. Please try selecting a wider radius.' js=1}{/addJsDefL}
{addJsDefL name=translation_2}{l s='store found -- see details:' js=1}{/addJsDefL}
{addJsDefL name=translation_3}{l s='stores found -- view all results:' js=1}{/addJsDefL}
{addJsDefL name=translation_4}{l s='Phone:' js=1}{/addJsDefL}
{addJsDefL name=translation_5}{l s='Get directions' js=1}{/addJsDefL}
{addJsDefL name=translation_6}{l s='Not found' js=1}{/addJsDefL}