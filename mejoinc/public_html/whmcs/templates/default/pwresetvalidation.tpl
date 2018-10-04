<div class="halfwidthcontainer">

{include file="$template/pageheader.tpl" title=$LANG.pwreset}

{if $errormessage}

  <div class="alert alert-error">
    <p>{$errormessage}</p>
  </div>

{else}

  <div class="alert alert-success">
    <p>{$LANG.pwresetvalidationsuccess}</p>
  </div>

  <p>{$LANG.pwresetvalidationsuccessdesc}</p>

{/if}

</div>