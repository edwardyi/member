{literal}
<style>
	.pager_table td a{
		min-width: 15px;
		display: block;
		border: 1px solid #ddd;
		margin: 2px;
		padding:2px;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 2px;
	}
	.pager_table td a:hover{
		text-decoration: none;
		background-color: #eee;
	}
	.pager_table td a.active{
		color: #fff;
		cursor: default;
		background-color: #428bca;
		border-color: #428bca;
	}
</style>
{/literal}
<table class="pager_table" border="0" align="center" cellpadding="5" cellspacing="0" class="P15">
    <tr>
      {if $pos > 1}<td height="50" align="center"><a href="{$pager_str}1">第一頁</a></td>
      <td height="50" align="center"><a href="{$pager_str}{$prev_pos}"> « </a></td>{/if}
      {foreach from=$pages item=obj name=row}
      <td width="30" height="50" align="center"><a href="{$pager_str}{$obj}" {if $pos == $obj}class="active"{/if}>{$obj}</a></td>
      {/foreach}
       {if $pos < $totalpage}<td height="50" align="center"><a href="{$pager_str}{$next_pos}"> » </a></td>
       <td height="50" align="center"><a href="{$pager_str}{$totalpage}">最後一頁</a></td>{/if}
    </tr>
</table>