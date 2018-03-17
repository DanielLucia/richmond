<!--<input name="buscar-categorias" placeholder="Busca categorías" data-list=".listCategorias" autocomplete="off" type="text" class="inputFilter">-->
<ul class="listCategorias Transition">
{if  $categorias|@count gt 0}
    {foreach key=key item=item from=$categorias}
        <li class="Transition">
            <a href="{$item->link}" class="link-ajax" data-target=".listPodcastsContent" data-template="podcastsTemplate">{$hooks->filter->apply("category_name", $item->nombre)}</a>
        </li>
    {/foreach}
{else}
    <li class="sinContenido">No hay categorias</li>
{/if}
</ul>
