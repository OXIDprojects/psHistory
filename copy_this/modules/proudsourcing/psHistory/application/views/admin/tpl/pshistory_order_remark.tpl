[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

[{ if $readonly }]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<script type="text/javascript" src="[{ $oViewConf->getBaseDir() }]out/admin/src/js/libs/jquery.min.js"></script>

<form name="transfer" id="transfer" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="oxid" value="[{ $oxid }]">
    <input type="hidden" name="cl" value="user_remark">
</form>

<form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
    <input type="hidden" name="fnc" value="">
    <input type="hidden" name="oxid" value="[{ $oxid }]">
    <input type="hidden" name="editval[oxuser__oxid]" value="[{ $oxid }]">
    <input type="hidden" name="rem_oxid" value="[{ $rem_oxid }]">

    <table cellspacing="0" cellpadding="0" border="0" width="98%">
        <tr>
            <td valign="top" class="edittext">
                <select name="rem_oxid" size="17" style="width: 250px;" class="editinput" onChange="Javascript:document.myedit.submit();" [{ $readonly }]>
                [{foreach from=$allremark item=allitem}]
                    <option value="[{ $allitem->oxremark__oxid->value }]" [{ if $allitem->selected}]SELECTED[{/if}]>[{ $allitem->oxremark__oxheader|oxformdate:"datetime" }] |
                        [{ if $allitem->oxremark__oxtype->value == "psH" }]
                            [{ $allitem->oxremark__pshistory_status->value }]
                        [{ else }]
                            [{ if $allitem->oxremark__oxtype->value == "r" }][{ oxmultilang ident="ORDER_REMARK_REMARK" }][{elseif $allitem->oxremark__oxtype->value == "o" }][{ oxmultilang ident="ORDER_REMARK_ORDER" }][{elseif $allitem->oxremark__oxtype->value == "c" }][{ oxmultilang ident="ORDER_REMARK_USER" }][{else}][{ oxmultilang ident="ORDER_REMARK_NEWS" }][{/if}]
                        [{ /if }]
                    </option>
                [{/foreach}]
                </select>
                <br><br>
                <input type="submit" class="edittext" name="save" value="[{ oxmultilang ident="GENERAL_DELETE" }]" onClick="Javascript:document.myedit.fnc.value='delete'"" [{ $readonly }]><br>

            </td>
            <!-- Anfang rechte Seite -->
            <td valign="top" class="edittext" align="left" style="line-height: 2.0;">
                <select name="pshistory_status" id="pshistory_status" size="1" class="editinput">
                [{ foreach from=$pshistory_status item=status }]
                    <option value="[{ $status }]">[{ $status }]</option>
                [{ /foreach }]
                </select>
                <br>
                <input type="checkbox" name="pshistory_sendmail" id="pshistory_sendmail" value="1"><label for="pshistory_sendmail"> [{ oxmultilang ident="PSHISTORY_ORDERREMARK_SENDMAIL" }]</label>
                <br>
                <div id="pshistory_sendmail_content" style="display: none;">
                    <input type="checkbox" name="pshistory_add_signature" id="pshistory_add_signature" value="1"><label for="pshistory_add_signature"> [{ oxmultilang ident="PSHISTORY_ORDERREMARK_SIGNATURE" }]</label>
                    <br>
                    [{ oxmultilang ident="PSHISTORY_ORDERREMARK_RECEIVER" }] <input type="text" style="width: 200px;" class="editinput" name="pshistory_mailto" id="pshistory_mailto" value="[{ $pshistory_mailto }]">
                    <br>
                    [{ oxmultilang ident="PSHISTORY_ORDERREMARK_SUBJECT" }] <input type="text" style="width: 200px;" class="editinput" name="pshistory_subject" id="pshistory_subject" value="">
                </div>

                <textarea class="editinput" cols="100" rows="17" wrap="VIRTUAL" id="remarktext" name="remarktext" [{ $readonly }]>[{$remarktext}]</textarea>
                <br>
                [{if $remarkheader}][{$remarkheader|oxformdate:"datetime":true}][{ if $username }] ([{ $username }])[{ /if }]<br>[{/if}]
                <input type="hidden" name="remarkheader" value="[{$remarkheader}]">

                <input type="submit" class="edittext" name="save" value="[{ oxmultilang ident="GENERAL_SAVE" }]" onClick="Javascript:document.myedit.fnc.value='save'"" [{ $readonly }]>
            </td>
            <!-- Ende rechte Seite -->
        </tr>
    </table>
</form>

<div id="pshistory_signature" style="display: none;">
[{ foreach from=$pshistory_signature item=signature }]
[{ $signature }]
[{ /foreach }]
</div>

<script>
    $( "#pshistory_sendmail" ).click(function() {
        var subject = $("#pshistory_status").val();
        $("#pshistory_subject").val('[[{$pshistory_subject}]] '+subject);
        $("#pshistory_sendmail_content").fadeToggle();
    });

    $( "#pshistory_add_signature" ).click(function() {
        var signature = $("#pshistory_signature").html();
        $("#remarktext").append(signature);
    });

    $( "#pshistory_status" ).change(function() {
        var subject = $("#pshistory_status").val();
        $("#pshistory_subject").val('[[{$pshistory_subject}]] '+subject);
    });
</script>

[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]
