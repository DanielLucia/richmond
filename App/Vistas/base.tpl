<!DOCTYPE html>
<html lang="es">
    <head>
        {include file="Includes/Elements/metatags.tpl"}
        {include file="Includes/Elements/css.tpl"}
    </head>
    <body class="{if $showMenu}showMenu{/if}">
        {include file="Includes/Elements/header.tpl"}
        <div class="Contenido">
            {if $flash}
            <div class="Alert">
                <p><strong>{$flash.title}</strong></p>
                <p>{$flash.content}</p>
            </div>
            {/if}
            {if $title && $showMenu}
            <h2 class="Subtitulo">{$title}</h2>
            {/if}
            {include file="$content"}
            {if $showMenu}
                {include file="Includes/Elements/footer.tpl"}
            {/if}
        </div>
        {include file="Includes/Elements/javascript.tpl"}
    </body>
</html>
