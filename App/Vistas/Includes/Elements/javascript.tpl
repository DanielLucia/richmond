
<script>var flash = {if $flash}'{$flash}'{else}false{/if}</script>

{foreach from=$js item=file}
<script src="{$file.filename}" type="text/javascript" defer></script>
{/foreach}
