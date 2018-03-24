<!DOCTYPE html>
<html lang="es">
    <head>
        {include file="Includes/Elements/metatags.tpl"}
        {include file="Includes/Elements/css.tpl"}
    </head>
    <body class="{if $showMenu}showMenu{/if}">
        {include file="Includes/Elements/header.tpl"}
        <div class="Contenido">


            <div class="container">
                {if $flash}
                <div class="row">
                    <div class="col-12 Alert">
                        <p><strong>{$flash.title}</strong></p>
                        <p>{$flash.content}</p>
                    </div>
                </div>
                {/if}
                {if $title && $showMenu}
                <div class="row">
                    <h2 class="col-12 Subtitulo">{$title}</h2>
                </div>
                {/if}
                {include file="$content"}
                {if $showMenu}
                    {include file="Includes/Elements/footer.tpl"}
                {/if}
            </div>

        </div>
        {include file="Includes/Elements/javascript.tpl"}
    </body>
</html>
