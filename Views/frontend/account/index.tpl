{extends file="parent:frontend/account/index.tpl"}

{block name="frontend_account_index_welcome"}
     {*insert countdown premium usership here*}
    {* insert button to buy premium usership here*}
    {*on button click: prompt yes/no, write into db that a new premium usership was bought*}
    {*create new table. doctrine models for user id and date bought. also: active/not active.*}
    {$smarty.block.parent}
{/block}