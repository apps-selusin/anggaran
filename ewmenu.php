<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(2, "mi_cf01_home_php", $Language->MenuPhrase("2", "MenuText"), "cf01_home.php", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(1, "mi_t01_penerimaan", $Language->MenuPhrase("1", "MenuText"), "t01_penerimaanlist.php", -1, "", TRUE, FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
