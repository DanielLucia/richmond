<!--<input name="buscar-episodios" placeholder="Busca episodios" data-list=".listEpisodios" autocomplete="off" type="text" class="inputFilter">-->
<div class="listEpisodiosContent">
    {if $podcast}
    <h1>{$podcast->nombre}</h1>
    {/if}
    <ul class="listEpisodios Transition">
    {if  $episodios|@count gt 0}
        {foreach key=key item=item from=$episodios}
            <li class="Flex Transition onClick" data-click=".Nombre a">
                <p class="Controles">
                    <a href="javascript:void(0);" class="Transition"><span class="typcn typcn-media-play"></span></a>
                </p>
                <p class="Fecha">{$item->date}</p>
                <p class="Nombre"><a href="{$item->link}" class="link-ajax" data-class="EpisodioView" data-target=".episodioContent" data-template="episodioTemplate">{$item->nombre}</a></p>
                <p class="Duracion">{$item->duracion}</p>
            </li>
        {/foreach}
    {else}
        <li class="sinContenido">Seleccione un podcast</li>
    {/if}
    </ul>
</div>
