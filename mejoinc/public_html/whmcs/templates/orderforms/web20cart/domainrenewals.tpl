<link rel="stylesheet" type="text/css" href="templates/orderforms/{$carttpl}/style.css" />

<div id="order-web20cart">

<h1>{$LANG.domainrenewals}</h1>

<div class="cartmenu" align="center"> {foreach key=num item=productgroup from=$productgroups}
  {if $gid eq $productgroup.gid}
  {$productgroup.name} | 
  {else} <a href="{$smarty.server.PHP_SELF}?gid={$productgroup.gid}">{$productgroup.name}</a> | 
  {/if}
  {/foreach}
  {if $loggedin}
  <a href="cart.php?gid=addons">{$LANG.cartproductaddons}</a> |
  <strong>{$LANG.domainrenewals}</strong> |
  {/if}
  {if $registerdomainenabled}<a href="{$smarty.server.PHP_SELF}?a=add&domain=register">{$LANG.registerdomain}</a> |{/if}
  {if $transferdomainenabled}<a href="{$smarty.server.PHP_SELF}?a=add&domain=transfer">{$LANG.transferdomain}</a> |{/if} <a href="{$smarty.server.PHP_SELF}?a=view">{$LANG.viewcart}</a> </div>

<p>{$LANG.domainrenewdesc}</p>

<form method="post" action="cart.php?a=add&renewals=true">

<table class="textcenter">
  <tr>
    <th width="20"></th>
    <th>{$LANG.orderdomain}</th>
    <th>{$LANG.domainstatus}</th>
    <th>{$LANG.domaindaysuntilexpiry}</th>
    <th></th>
  </tr>
{foreach from=$renewals item=renewal}
  <tr>
    <td>{if !$renewal.pastgraceperiod}<input type="checkbox" name="renewalids[]" value="{$renewal.id}" />{/if}</td>
    <td>{$renewal.domain}</td>
    <td>{$renewal.status}</td>
    <td>
      {if $renewal.daysuntilexpiry > 30}
        <span class="textgreen">{$renewal.daysuntilexpiry} {$LANG.domainrenewalsdays}</span>
      {elseif $renewal.daysuntilexpiry > 0}
        <span class="textred">{$renewal.daysuntilexpiry} {$LANG.domainrenewalsdays}</span>
      {else}
        <span class="textblack">{$renewal.daysuntilexpiry*-1} {$LANG.domainrenewalsdaysago}</span>
      {/if}
      {if $renewal.ingraceperiod}
        <br />
        <span class="textred">{$LANG.domainrenewalsingraceperiod}<span>
      {/if}
    </td>
    <td>
      {if $renewal.beforerenewlimit}
        <span class="textred">{$LANG.domainrenewalsbeforerenewlimit|sprintf2:$renewal.beforerenewlimitdays}<span>
      {elseif $renewal.pastgraceperiod}
        <span class="textred">{$LANG.domainrenewalspastgraceperiod}<span>
      {else}
        <select name="renewalperiod[{$renewal.id}]">
        {foreach from=$renewal.renewaloptions item=renewaloption}
          <option value="{$renewaloption.period}">{$renewaloption.period} {$LANG.orderyears} @ {$renewaloption.price}</option>
        {/foreach}
        </select>
      {/if}
    </td>
  </tr>
{foreachelse}
  <tr>
    <td colspan="5">{$LANG.domainrenewalsnoneavailable}</td>
  </tr>
{/foreach}
</table>

<p align="center"><input type="submit" value="{$LANG.ordernowbutton}" /></p>

</form>

</div>