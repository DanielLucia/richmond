{if $showMenu}
    <nav class="Sidebar">
        <aside>
            <p class="userIcon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></p>
            <h2 class="userName">{'user.name'|session}</h2>
            <p class="userEmail">{'user.email'|session}</p>
        </aside>
        {if !empty($menu.sidebar) }
        <ul>
        {foreach from=$menu.sidebar item=item}
            <li>
                <a href="{$item.url}" class="{$item.class}">
                    {if $item.icon}
                    <i class="fa fa-{$item.icon}" aria-hidden="true"></i>
                    {/if}
                    {$item.texto}
                </a>
            </li>
        {/foreach}
        </ul>
        {/if}
    </nav>

    {if !empty($menu.navbar) }
        <nav class="navBar">
            <ul class="inlineBlock textRight">
            {foreach from=$menu.navbar item=item}
            {if $item.icon}
                <li>
                    <a href="{$item.url}" class="{$item.class}">
                        <i class="fa fa-{$item.icon}" aria-hidden="true"></i>
                    </a>
                </li>
                {/if}
            {/foreach}
            </ul>
        </nav>
    {/if}

{/if}
