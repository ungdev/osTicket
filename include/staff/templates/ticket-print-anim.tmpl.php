<html>

<head>
    <style type="text/css">
@page {
    header: html_def;
    footer: html_def;
    margin: 15mm;
    margin-top: 10mm;
    margin-bottom: 22mm;
}
h1 {
    text-align: center;
}
.logo {
  max-width: 220px;
  max-height: 71px;
  width: auto;
  height: auto;
  margin: 0;
}
#ticket_thread .message,
#ticket_thread .response,
#ticket_thread .note {
    margin-top:10px;
    border:1px solid #aaa;
    border-bottom:2px solid #aaa;
}
#ticket_thread .header {
    text-align:left;
    border-bottom:1px solid #aaa;
    padding:3px;
    width: 100%;
    table-layout: fixed;
}
#ticket_thread .message .header {
    background:#C3D9FF;
}
#ticket_thread .response .header {
    background:#FFE0B3;
}
#ticket_thread .note .header {
    background:#FFE;
}
#ticket_thread .info {
    padding:5px;
    background: snow;
    border-top: 0.3mm solid #ccc;
}

table.meta-data {
    width: 100%;
}
table.custom-data {
    margin-top: 10px;
}
table.custom-data th {
    width: 25%;
}
table.custom-data th,
table.meta-data th {
    text-align: right;
    background-color: #ddd;
    padding: 3px 8px;
}
table.meta-data td {
    padding: 3px 8px;
}
.faded {
    color:#666;
}
.pull-left {
    float: left;
}
.pull-right {
    float: right;
}
.flush-right {
    text-align: right;
}
.flush-left {
    text-align: left;
}
.ltr {
    direction: ltr;
    unicode-bidi: embed;
}
.headline {
    border-bottom: 2px solid black;
    font-weight: bold;
}
div.hr {
    border-top: 0.2mm solid #bbb;
    margin: 0.5mm 0;
    font-size: 0.0001em;
}
.thread-entry, .thread-body {
    page-break-inside: avoid;
}
<?php include ROOT_DIR . 'css/thread.css'; ?>
    </style>
</head>
<body>

<htmlpagefooter name="def" style="display:none">
    <div class="hr">&nbsp;</div>
    <table width="100%"><tr><td class="flush-left">
        Fiche animation n° #<?php echo $ticket->getNumber(); ?>
    </td>
    <td class="flush-right">
        Page {PAGENO}
    </td>
    </tr></table>
</htmlpagefooter>

<!-- Ticket metadata -->
<h1>BDE UTT - Fiche animation</h1>

<!-- Custom Data -->
<?php
foreach (DynamicFormEntry::forTicket($ticket->getId()) as $form) {
    // Skip core fields shown earlier in the ticket view
    $answers = $form->getAnswers()->exclude(Q::any(array(
        'field__flags__hasbit' => DynamicFormField::FLAG_EXT_STORED,
        'field__name__in' => array('subject', 'priority')
    )));
    if (count($answers) == 0)
        continue;
    if ($form->getTitle() == 'Divers & infos complémentaires' && count($answers) == 1 && $answers[0]->getField()->get('label') == 'Autres' && empty($answers[0]->display())) continue;
    ?>
        <table class="custom-data" cellspacing="0" cellpadding="4" width="100%" border="0">
        <tr><td colspan="2" class="headline flush-left"><?php echo $form->getTitle() ?></th></tr>
        <?php foreach($answers as $a) {
            if (!($v = $a->display())) continue; ?>
            <tr>
                <th><?php
    echo $a->getField()->get('label');
                ?>:</th>
                <td><?php
    echo $v;
                ?></td>
            </tr>
            <?php } ?>
        </table>
    <?php
    $idx++;
} ?>

</body>
</html>
