<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(10009, "mi_cf02_home_php", $Language->MenuPhrase("10009", "MenuText"), "cf02_home.php", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(10018, "mi_t01_penerimaan_head", $Language->MenuPhrase("10018", "MenuText"), "t01_penerimaan_headlist.php", -1, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(10005, "mi_t03_pengeluaran_head", $Language->MenuPhrase("10005", "MenuText"), "t03_pengeluaran_headlist.php", -1, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(10017, "mci_Setup", $Language->MenuPhrase("10017", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(10006, "mi_t05_satuan", $Language->MenuPhrase("10006", "MenuText"), "t05_satuanlist.php", 10017, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(10007, "mi_t98_log", $Language->MenuPhrase("10007", "MenuText"), "t98_loglist.php", 10017, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(10008, "mi_t99_log_status", $Language->MenuPhrase("10008", "MenuText"), "t99_log_statuslist.php", 10017, "", TRUE, FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
