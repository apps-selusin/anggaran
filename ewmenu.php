<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(2, "mi_cf01_home_php", $Language->MenuPhrase("2", "MenuText"), "cf01_home.php", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(10007, "mi_t98_log", $Language->MenuPhrase("10007", "MenuText"), "t98_loglist.php", 2, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(10008, "mi_t99_log_status", $Language->MenuPhrase("10008", "MenuText"), "t99_log_statuslist.php", 2, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(1, "mi_t01_penerimaan", $Language->MenuPhrase("1", "MenuText"), "t01_penerimaanlist.php", -1, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(10005, "mi_t03_pengeluaran_head", $Language->MenuPhrase("10005", "MenuText"), "t03_pengeluaran_headlist.php", -1, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(10006, "mi_t04_satuan", $Language->MenuPhrase("10006", "MenuText"), "t04_satuanlist.php", -1, "", TRUE, FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
