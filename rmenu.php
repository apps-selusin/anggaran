<?php

// Menu
$RootMenu = new crMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(2, "mi_r01_penerimaan", $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("2", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "r01_penerimaansmry.php", -1, "", TRUE, FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
