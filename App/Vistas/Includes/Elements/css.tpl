{foreach from=$css item=file}
<link rel="stylesheet" type="text/css" media="{$file.media}" href="{$file.filename}?v=1">
{/foreach}
