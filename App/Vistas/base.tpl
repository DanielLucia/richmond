<!DOCTYPE html>
<html lang="es">
    <head>
        {include file="Includes/Elements/metatags.tpl"}
        {include file="Includes/Elements/css.tpl"}
    </head>
    <body class="{if $showMenu}showMenu{/if}">
        {include file="Includes/Elements/header.tpl"}
        <div class="Contenido">
            {if $title}
            <h2 class="Subtitulo">{$title}</h2>
            {/if}
            {include file="$content"}
        </div>

        {include file="Includes/Elements/javascript.tpl"}
    </body>
</html>
