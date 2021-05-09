
<?php

require_once __DIR__ . '/vendor/autoload.php';



$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<style type="text/css">
.tg  {border-collapse:collapse;border-color:#aabcfe;border-spacing:0;}
.tg td{background-color:#e8edff;border-color:#aabcfe;border-style:solid;border-width:1px;color:#669;
  font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg th{background-color:#b9c9fe;border-color:#aabcfe;border-style:solid;border-width:1px;color:#039;
  font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg .tg-hmp3{background-color:#D2E4FC;text-align:left;vertical-align:top}
.tg .tg-baqh{text-align:center;vertical-align:top}
.tg .tg-mb3i{background-color:#D2E4FC;text-align:right;vertical-align:top}
.tg .tg-lqy6{text-align:right;vertical-align:top}
.tg .tg-0lax{text-align:left;vertical-align:top}
</style>
<table class="tg">
<thead>
  <tr>
    <th class="tg-baqh" colspan="6">Results</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg-hmp3">No</td>
    <td class="tg-hmp3">Competition</td>
    <td class="tg-hmp3">John</td>
    <td class="tg-hmp3">Adam</td>
    <td class="tg-hmp3">Robert</td>
    <td class="tg-hmp3">Paul</td>
  </tr>
  <tr>
    <td class="tg-0lax">1</td>
    <td class="tg-0lax">Swimming</td>
    <td class="tg-lqy6">1:30</td>
    <td class="tg-lqy6">2:05</td>
    <td class="tg-lqy6">1:15</td>
    <td class="tg-lqy6">1:41</td>
  </tr>
  <tr>
    <td class="tg-hmp3">2</td>
    <td class="tg-hmp3">Running</td>
    <td class="tg-mb3i">15:30</td>
    <td class="tg-mb3i">14:10</td>
    <td class="tg-mb3i">15:45</td>
    <td class="tg-mb3i">16:00</td>
  </tr>
  <tr>
    <td class="tg-0lax">3</td>
    <td class="tg-0lax">Shooting</td>
    <td class="tg-lqy6">70%</td>
    <td class="tg-lqy6">55%</td>
    <td class="tg-lqy6">90%</td>
    <td class="tg-lqy6">88%</td>
  </tr>
</tbody>
</table>');
$mpdf->Output("meu-pdf", "I");
