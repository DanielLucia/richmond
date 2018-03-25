    {if !empty($menu.submenu) }
        <nav class="Submenu Scroll Transition">
            <ul>
            {foreach from=$menu.submenu item=item}
                <li>
                    <a href="{$item.url}" class="{$item.class}">{$item.texto}</a>
                </li>
            {/foreach}
            </ul>
        </nav>
    {/if}
