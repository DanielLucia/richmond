<!--<input name="buscar-podcasts" placeholder="Busca podcasts" data-list=".listPodcasts" autocomplete="off" type="text" class="inputFilter">-->
<div class="listPodcastsContent">
{if $categoria}
<h1>{$categoria->nombre}</h1>
{/if}
<ul class="listPodcasts Transition">
{if  $podcasts|@count gt 0}
    {foreach key=key item=item from=$podcasts}
        <li class="Flex onClick Transition" data-click="h3 a">
            <div class="Imagen">
                <img src="{$item->imagen}" alt="{$item->nombre}" class="Lazy" width="70" height="70" />
            </div>
            <div>
                <h3><a href="{$item->link}" class="link-ajax" data-target=".listEpisodiosContent" data-template="episodiosTemplate">{$item->nombre}</a></h3>
                <div class="Descripcion Transition">
                    <p>{$item->descripcion}</p>
                </div>
            </div>
        </li>
    {/foreach}
{else}
    <li class="sinContenido">Seleccione una categoría</li>
{/if}
</ul>
</div>
