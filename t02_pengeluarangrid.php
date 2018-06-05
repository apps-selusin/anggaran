<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t02_pengeluaran_grid)) $t02_pengeluaran_grid = new ct02_pengeluaran_grid();

// Page init
$t02_pengeluaran_grid->Page_Init();

// Page main
$t02_pengeluaran_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t02_pengeluaran_grid->Page_Render();
?>
<?php if ($t02_pengeluaran->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft02_pengeluarangrid = new ew_Form("ft02_pengeluarangrid", "grid");
ft02_pengeluarangrid.FormKeyCountName = '<?php echo $t02_pengeluaran_grid->FormKeyCountName ?>';

// Validate form
ft02_pengeluarangrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_Urutan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_pengeluaran->Urutan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Nominal");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_pengeluaran->Nominal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Banyaknya");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_pengeluaran->Banyaknya->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Satuan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_pengeluaran->Satuan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_pengeluaran->Jumlah->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Total");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_pengeluaran->Total->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft02_pengeluarangrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Urutan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nomor", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Kode", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Pos", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nominal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Banyaknya", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Satuan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Jumlah", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Total", false)) return false;
	return true;
}

// Form_CustomValidate event
ft02_pengeluarangrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft02_pengeluarangrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($t02_pengeluaran->CurrentAction == "gridadd") {
	if ($t02_pengeluaran->CurrentMode == "copy") {
		$bSelectLimit = $t02_pengeluaran_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t02_pengeluaran_grid->TotalRecs = $t02_pengeluaran->ListRecordCount();
			$t02_pengeluaran_grid->Recordset = $t02_pengeluaran_grid->LoadRecordset($t02_pengeluaran_grid->StartRec-1, $t02_pengeluaran_grid->DisplayRecs);
		} else {
			if ($t02_pengeluaran_grid->Recordset = $t02_pengeluaran_grid->LoadRecordset())
				$t02_pengeluaran_grid->TotalRecs = $t02_pengeluaran_grid->Recordset->RecordCount();
		}
		$t02_pengeluaran_grid->StartRec = 1;
		$t02_pengeluaran_grid->DisplayRecs = $t02_pengeluaran_grid->TotalRecs;
	} else {
		$t02_pengeluaran->CurrentFilter = "0=1";
		$t02_pengeluaran_grid->StartRec = 1;
		$t02_pengeluaran_grid->DisplayRecs = $t02_pengeluaran->GridAddRowCount;
	}
	$t02_pengeluaran_grid->TotalRecs = $t02_pengeluaran_grid->DisplayRecs;
	$t02_pengeluaran_grid->StopRec = $t02_pengeluaran_grid->DisplayRecs;
} else {
	$bSelectLimit = $t02_pengeluaran_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t02_pengeluaran_grid->TotalRecs <= 0)
			$t02_pengeluaran_grid->TotalRecs = $t02_pengeluaran->ListRecordCount();
	} else {
		if (!$t02_pengeluaran_grid->Recordset && ($t02_pengeluaran_grid->Recordset = $t02_pengeluaran_grid->LoadRecordset()))
			$t02_pengeluaran_grid->TotalRecs = $t02_pengeluaran_grid->Recordset->RecordCount();
	}
	$t02_pengeluaran_grid->StartRec = 1;
	$t02_pengeluaran_grid->DisplayRecs = $t02_pengeluaran_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t02_pengeluaran_grid->Recordset = $t02_pengeluaran_grid->LoadRecordset($t02_pengeluaran_grid->StartRec-1, $t02_pengeluaran_grid->DisplayRecs);

	// Set no record found message
	if ($t02_pengeluaran->CurrentAction == "" && $t02_pengeluaran_grid->TotalRecs == 0) {
		if ($t02_pengeluaran_grid->SearchWhere == "0=101")
			$t02_pengeluaran_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t02_pengeluaran_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t02_pengeluaran_grid->RenderOtherOptions();
?>
<?php $t02_pengeluaran_grid->ShowPageHeader(); ?>
<?php
$t02_pengeluaran_grid->ShowMessage();
?>
<?php if ($t02_pengeluaran_grid->TotalRecs > 0 || $t02_pengeluaran->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t02_pengeluaran_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t02_pengeluaran">
<div id="ft02_pengeluarangrid" class="ewForm ewListForm form-inline">
<div id="gmp_t02_pengeluaran" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_t02_pengeluarangrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t02_pengeluaran_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t02_pengeluaran_grid->RenderListOptions();

// Render list options (header, left)
$t02_pengeluaran_grid->ListOptions->Render("header", "left");
?>
<?php if ($t02_pengeluaran->Urutan->Visible) { // Urutan ?>
	<?php if ($t02_pengeluaran->SortUrl($t02_pengeluaran->Urutan) == "") { ?>
		<th data-name="Urutan" class="<?php echo $t02_pengeluaran->Urutan->HeaderCellClass() ?>"><div id="elh_t02_pengeluaran_Urutan" class="t02_pengeluaran_Urutan"><div class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Urutan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Urutan" class="<?php echo $t02_pengeluaran->Urutan->HeaderCellClass() ?>"><div><div id="elh_t02_pengeluaran_Urutan" class="t02_pengeluaran_Urutan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Urutan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_pengeluaran->Urutan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_pengeluaran->Urutan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_pengeluaran->Nomor->Visible) { // Nomor ?>
	<?php if ($t02_pengeluaran->SortUrl($t02_pengeluaran->Nomor) == "") { ?>
		<th data-name="Nomor" class="<?php echo $t02_pengeluaran->Nomor->HeaderCellClass() ?>"><div id="elh_t02_pengeluaran_Nomor" class="t02_pengeluaran_Nomor"><div class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Nomor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nomor" class="<?php echo $t02_pengeluaran->Nomor->HeaderCellClass() ?>"><div><div id="elh_t02_pengeluaran_Nomor" class="t02_pengeluaran_Nomor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Nomor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_pengeluaran->Nomor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_pengeluaran->Nomor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_pengeluaran->Kode->Visible) { // Kode ?>
	<?php if ($t02_pengeluaran->SortUrl($t02_pengeluaran->Kode) == "") { ?>
		<th data-name="Kode" class="<?php echo $t02_pengeluaran->Kode->HeaderCellClass() ?>"><div id="elh_t02_pengeluaran_Kode" class="t02_pengeluaran_Kode"><div class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Kode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Kode" class="<?php echo $t02_pengeluaran->Kode->HeaderCellClass() ?>"><div><div id="elh_t02_pengeluaran_Kode" class="t02_pengeluaran_Kode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Kode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_pengeluaran->Kode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_pengeluaran->Kode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_pengeluaran->Pos->Visible) { // Pos ?>
	<?php if ($t02_pengeluaran->SortUrl($t02_pengeluaran->Pos) == "") { ?>
		<th data-name="Pos" class="<?php echo $t02_pengeluaran->Pos->HeaderCellClass() ?>"><div id="elh_t02_pengeluaran_Pos" class="t02_pengeluaran_Pos"><div class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Pos->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Pos" class="<?php echo $t02_pengeluaran->Pos->HeaderCellClass() ?>"><div><div id="elh_t02_pengeluaran_Pos" class="t02_pengeluaran_Pos">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Pos->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_pengeluaran->Pos->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_pengeluaran->Pos->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_pengeluaran->Nominal->Visible) { // Nominal ?>
	<?php if ($t02_pengeluaran->SortUrl($t02_pengeluaran->Nominal) == "") { ?>
		<th data-name="Nominal" class="<?php echo $t02_pengeluaran->Nominal->HeaderCellClass() ?>"><div id="elh_t02_pengeluaran_Nominal" class="t02_pengeluaran_Nominal"><div class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Nominal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nominal" class="<?php echo $t02_pengeluaran->Nominal->HeaderCellClass() ?>"><div><div id="elh_t02_pengeluaran_Nominal" class="t02_pengeluaran_Nominal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Nominal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_pengeluaran->Nominal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_pengeluaran->Nominal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_pengeluaran->Banyaknya->Visible) { // Banyaknya ?>
	<?php if ($t02_pengeluaran->SortUrl($t02_pengeluaran->Banyaknya) == "") { ?>
		<th data-name="Banyaknya" class="<?php echo $t02_pengeluaran->Banyaknya->HeaderCellClass() ?>"><div id="elh_t02_pengeluaran_Banyaknya" class="t02_pengeluaran_Banyaknya"><div class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Banyaknya->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Banyaknya" class="<?php echo $t02_pengeluaran->Banyaknya->HeaderCellClass() ?>"><div><div id="elh_t02_pengeluaran_Banyaknya" class="t02_pengeluaran_Banyaknya">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Banyaknya->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_pengeluaran->Banyaknya->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_pengeluaran->Banyaknya->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_pengeluaran->Satuan->Visible) { // Satuan ?>
	<?php if ($t02_pengeluaran->SortUrl($t02_pengeluaran->Satuan) == "") { ?>
		<th data-name="Satuan" class="<?php echo $t02_pengeluaran->Satuan->HeaderCellClass() ?>"><div id="elh_t02_pengeluaran_Satuan" class="t02_pengeluaran_Satuan"><div class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Satuan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Satuan" class="<?php echo $t02_pengeluaran->Satuan->HeaderCellClass() ?>"><div><div id="elh_t02_pengeluaran_Satuan" class="t02_pengeluaran_Satuan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Satuan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_pengeluaran->Satuan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_pengeluaran->Satuan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_pengeluaran->Jumlah->Visible) { // Jumlah ?>
	<?php if ($t02_pengeluaran->SortUrl($t02_pengeluaran->Jumlah) == "") { ?>
		<th data-name="Jumlah" class="<?php echo $t02_pengeluaran->Jumlah->HeaderCellClass() ?>"><div id="elh_t02_pengeluaran_Jumlah" class="t02_pengeluaran_Jumlah"><div class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Jumlah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jumlah" class="<?php echo $t02_pengeluaran->Jumlah->HeaderCellClass() ?>"><div><div id="elh_t02_pengeluaran_Jumlah" class="t02_pengeluaran_Jumlah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Jumlah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_pengeluaran->Jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_pengeluaran->Jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_pengeluaran->Total->Visible) { // Total ?>
	<?php if ($t02_pengeluaran->SortUrl($t02_pengeluaran->Total) == "") { ?>
		<th data-name="Total" class="<?php echo $t02_pengeluaran->Total->HeaderCellClass() ?>"><div id="elh_t02_pengeluaran_Total" class="t02_pengeluaran_Total"><div class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Total->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Total" class="<?php echo $t02_pengeluaran->Total->HeaderCellClass() ?>"><div><div id="elh_t02_pengeluaran_Total" class="t02_pengeluaran_Total">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_pengeluaran->Total->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_pengeluaran->Total->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_pengeluaran->Total->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t02_pengeluaran_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t02_pengeluaran_grid->StartRec = 1;
$t02_pengeluaran_grid->StopRec = $t02_pengeluaran_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t02_pengeluaran_grid->FormKeyCountName) && ($t02_pengeluaran->CurrentAction == "gridadd" || $t02_pengeluaran->CurrentAction == "gridedit" || $t02_pengeluaran->CurrentAction == "F")) {
		$t02_pengeluaran_grid->KeyCount = $objForm->GetValue($t02_pengeluaran_grid->FormKeyCountName);
		$t02_pengeluaran_grid->StopRec = $t02_pengeluaran_grid->StartRec + $t02_pengeluaran_grid->KeyCount - 1;
	}
}
$t02_pengeluaran_grid->RecCnt = $t02_pengeluaran_grid->StartRec - 1;
if ($t02_pengeluaran_grid->Recordset && !$t02_pengeluaran_grid->Recordset->EOF) {
	$t02_pengeluaran_grid->Recordset->MoveFirst();
	$bSelectLimit = $t02_pengeluaran_grid->UseSelectLimit;
	if (!$bSelectLimit && $t02_pengeluaran_grid->StartRec > 1)
		$t02_pengeluaran_grid->Recordset->Move($t02_pengeluaran_grid->StartRec - 1);
} elseif (!$t02_pengeluaran->AllowAddDeleteRow && $t02_pengeluaran_grid->StopRec == 0) {
	$t02_pengeluaran_grid->StopRec = $t02_pengeluaran->GridAddRowCount;
}

// Initialize aggregate
$t02_pengeluaran->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t02_pengeluaran->ResetAttrs();
$t02_pengeluaran_grid->RenderRow();
if ($t02_pengeluaran->CurrentAction == "gridadd")
	$t02_pengeluaran_grid->RowIndex = 0;
if ($t02_pengeluaran->CurrentAction == "gridedit")
	$t02_pengeluaran_grid->RowIndex = 0;
while ($t02_pengeluaran_grid->RecCnt < $t02_pengeluaran_grid->StopRec) {
	$t02_pengeluaran_grid->RecCnt++;
	if (intval($t02_pengeluaran_grid->RecCnt) >= intval($t02_pengeluaran_grid->StartRec)) {
		$t02_pengeluaran_grid->RowCnt++;
		if ($t02_pengeluaran->CurrentAction == "gridadd" || $t02_pengeluaran->CurrentAction == "gridedit" || $t02_pengeluaran->CurrentAction == "F") {
			$t02_pengeluaran_grid->RowIndex++;
			$objForm->Index = $t02_pengeluaran_grid->RowIndex;
			if ($objForm->HasValue($t02_pengeluaran_grid->FormActionName))
				$t02_pengeluaran_grid->RowAction = strval($objForm->GetValue($t02_pengeluaran_grid->FormActionName));
			elseif ($t02_pengeluaran->CurrentAction == "gridadd")
				$t02_pengeluaran_grid->RowAction = "insert";
			else
				$t02_pengeluaran_grid->RowAction = "";
		}

		// Set up key count
		$t02_pengeluaran_grid->KeyCount = $t02_pengeluaran_grid->RowIndex;

		// Init row class and style
		$t02_pengeluaran->ResetAttrs();
		$t02_pengeluaran->CssClass = "";
		if ($t02_pengeluaran->CurrentAction == "gridadd") {
			if ($t02_pengeluaran->CurrentMode == "copy") {
				$t02_pengeluaran_grid->LoadRowValues($t02_pengeluaran_grid->Recordset); // Load row values
				$t02_pengeluaran_grid->SetRecordKey($t02_pengeluaran_grid->RowOldKey, $t02_pengeluaran_grid->Recordset); // Set old record key
			} else {
				$t02_pengeluaran_grid->LoadRowValues(); // Load default values
				$t02_pengeluaran_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t02_pengeluaran_grid->LoadRowValues($t02_pengeluaran_grid->Recordset); // Load row values
		}
		$t02_pengeluaran->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t02_pengeluaran->CurrentAction == "gridadd") // Grid add
			$t02_pengeluaran->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t02_pengeluaran->CurrentAction == "gridadd" && $t02_pengeluaran->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t02_pengeluaran_grid->RestoreCurrentRowFormValues($t02_pengeluaran_grid->RowIndex); // Restore form values
		if ($t02_pengeluaran->CurrentAction == "gridedit") { // Grid edit
			if ($t02_pengeluaran->EventCancelled) {
				$t02_pengeluaran_grid->RestoreCurrentRowFormValues($t02_pengeluaran_grid->RowIndex); // Restore form values
			}
			if ($t02_pengeluaran_grid->RowAction == "insert")
				$t02_pengeluaran->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t02_pengeluaran->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t02_pengeluaran->CurrentAction == "gridedit" && ($t02_pengeluaran->RowType == EW_ROWTYPE_EDIT || $t02_pengeluaran->RowType == EW_ROWTYPE_ADD) && $t02_pengeluaran->EventCancelled) // Update failed
			$t02_pengeluaran_grid->RestoreCurrentRowFormValues($t02_pengeluaran_grid->RowIndex); // Restore form values
		if ($t02_pengeluaran->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t02_pengeluaran_grid->EditRowCnt++;
		if ($t02_pengeluaran->CurrentAction == "F") // Confirm row
			$t02_pengeluaran_grid->RestoreCurrentRowFormValues($t02_pengeluaran_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t02_pengeluaran->RowAttrs = array_merge($t02_pengeluaran->RowAttrs, array('data-rowindex'=>$t02_pengeluaran_grid->RowCnt, 'id'=>'r' . $t02_pengeluaran_grid->RowCnt . '_t02_pengeluaran', 'data-rowtype'=>$t02_pengeluaran->RowType));

		// Render row
		$t02_pengeluaran_grid->RenderRow();

		// Render list options
		$t02_pengeluaran_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t02_pengeluaran_grid->RowAction <> "delete" && $t02_pengeluaran_grid->RowAction <> "insertdelete" && !($t02_pengeluaran_grid->RowAction == "insert" && $t02_pengeluaran->CurrentAction == "F" && $t02_pengeluaran_grid->EmptyRow())) {
?>
	<tr<?php echo $t02_pengeluaran->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t02_pengeluaran_grid->ListOptions->Render("body", "left", $t02_pengeluaran_grid->RowCnt);
?>
	<?php if ($t02_pengeluaran->Urutan->Visible) { // Urutan ?>
		<td data-name="Urutan"<?php echo $t02_pengeluaran->Urutan->CellAttributes() ?>>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Urutan" class="form-group t02_pengeluaran_Urutan">
<input type="text" data-table="t02_pengeluaran" data-field="x_Urutan" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Urutan->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Urutan->EditValue ?>"<?php echo $t02_pengeluaran->Urutan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Urutan" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Urutan->OldValue) ?>">
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Urutan" class="form-group t02_pengeluaran_Urutan">
<input type="text" data-table="t02_pengeluaran" data-field="x_Urutan" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Urutan->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Urutan->EditValue ?>"<?php echo $t02_pengeluaran->Urutan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Urutan" class="t02_pengeluaran_Urutan">
<span<?php echo $t02_pengeluaran->Urutan->ViewAttributes() ?>>
<?php echo $t02_pengeluaran->Urutan->ListViewValue() ?></span>
</span>
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Urutan" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Urutan->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Urutan" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Urutan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Urutan" name="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" id="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Urutan->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Urutan" name="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" id="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Urutan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_id" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_id" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_pengeluaran->id->CurrentValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_id" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_id" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_pengeluaran->id->OldValue) ?>">
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_EDIT || $t02_pengeluaran->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_id" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_id" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_pengeluaran->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t02_pengeluaran->Nomor->Visible) { // Nomor ?>
		<td data-name="Nomor"<?php echo $t02_pengeluaran->Nomor->CellAttributes() ?>>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Nomor" class="form-group t02_pengeluaran_Nomor">
<input type="text" data-table="t02_pengeluaran" data-field="x_Nomor" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Nomor->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Nomor->EditValue ?>"<?php echo $t02_pengeluaran->Nomor->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Nomor" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Nomor->OldValue) ?>">
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Nomor" class="form-group t02_pengeluaran_Nomor">
<input type="text" data-table="t02_pengeluaran" data-field="x_Nomor" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Nomor->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Nomor->EditValue ?>"<?php echo $t02_pengeluaran->Nomor->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Nomor" class="t02_pengeluaran_Nomor">
<span<?php echo $t02_pengeluaran->Nomor->ViewAttributes() ?>>
<?php echo $t02_pengeluaran->Nomor->ListViewValue() ?></span>
</span>
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Nomor" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Nomor->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Nomor" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Nomor->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Nomor" name="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" id="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Nomor->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Nomor" name="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" id="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Nomor->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Kode->Visible) { // Kode ?>
		<td data-name="Kode"<?php echo $t02_pengeluaran->Kode->CellAttributes() ?>>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t02_pengeluaran->Kode->getSessionValue() <> "") { ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Kode" class="form-group t02_pengeluaran_Kode">
<span<?php echo $t02_pengeluaran->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_pengeluaran->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Kode->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Kode" class="form-group t02_pengeluaran_Kode">
<input type="text" data-table="t02_pengeluaran" data-field="x_Kode" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Kode->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Kode->EditValue ?>"<?php echo $t02_pengeluaran->Kode->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Kode" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Kode->OldValue) ?>">
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t02_pengeluaran->Kode->getSessionValue() <> "") { ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Kode" class="form-group t02_pengeluaran_Kode">
<span<?php echo $t02_pengeluaran->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_pengeluaran->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Kode->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Kode" class="form-group t02_pengeluaran_Kode">
<input type="text" data-table="t02_pengeluaran" data-field="x_Kode" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Kode->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Kode->EditValue ?>"<?php echo $t02_pengeluaran->Kode->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Kode" class="t02_pengeluaran_Kode">
<span<?php echo $t02_pengeluaran->Kode->ViewAttributes() ?>>
<?php echo $t02_pengeluaran->Kode->ListViewValue() ?></span>
</span>
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Kode" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Kode->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Kode" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Kode->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Kode" name="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" id="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Kode->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Kode" name="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" id="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Kode->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Pos->Visible) { // Pos ?>
		<td data-name="Pos"<?php echo $t02_pengeluaran->Pos->CellAttributes() ?>>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Pos" class="form-group t02_pengeluaran_Pos">
<input type="text" data-table="t02_pengeluaran" data-field="x_Pos" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Pos->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Pos->EditValue ?>"<?php echo $t02_pengeluaran->Pos->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Pos" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Pos->OldValue) ?>">
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Pos" class="form-group t02_pengeluaran_Pos">
<input type="text" data-table="t02_pengeluaran" data-field="x_Pos" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Pos->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Pos->EditValue ?>"<?php echo $t02_pengeluaran->Pos->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Pos" class="t02_pengeluaran_Pos">
<span<?php echo $t02_pengeluaran->Pos->ViewAttributes() ?>>
<?php echo $t02_pengeluaran->Pos->ListViewValue() ?></span>
</span>
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Pos" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Pos->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Pos" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Pos->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Pos" name="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" id="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Pos->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Pos" name="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" id="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Pos->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Nominal->Visible) { // Nominal ?>
		<td data-name="Nominal"<?php echo $t02_pengeluaran->Nominal->CellAttributes() ?>>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Nominal" class="form-group t02_pengeluaran_Nominal">
<input type="text" data-table="t02_pengeluaran" data-field="x_Nominal" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Nominal->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Nominal->EditValue ?>"<?php echo $t02_pengeluaran->Nominal->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Nominal" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Nominal->OldValue) ?>">
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Nominal" class="form-group t02_pengeluaran_Nominal">
<input type="text" data-table="t02_pengeluaran" data-field="x_Nominal" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Nominal->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Nominal->EditValue ?>"<?php echo $t02_pengeluaran->Nominal->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Nominal" class="t02_pengeluaran_Nominal">
<span<?php echo $t02_pengeluaran->Nominal->ViewAttributes() ?>>
<?php echo $t02_pengeluaran->Nominal->ListViewValue() ?></span>
</span>
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Nominal" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Nominal->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Nominal" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Nominal->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Nominal" name="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" id="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Nominal->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Nominal" name="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" id="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Nominal->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Banyaknya->Visible) { // Banyaknya ?>
		<td data-name="Banyaknya"<?php echo $t02_pengeluaran->Banyaknya->CellAttributes() ?>>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Banyaknya" class="form-group t02_pengeluaran_Banyaknya">
<input type="text" data-table="t02_pengeluaran" data-field="x_Banyaknya" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Banyaknya->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Banyaknya->EditValue ?>"<?php echo $t02_pengeluaran->Banyaknya->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Banyaknya" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Banyaknya->OldValue) ?>">
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Banyaknya" class="form-group t02_pengeluaran_Banyaknya">
<input type="text" data-table="t02_pengeluaran" data-field="x_Banyaknya" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Banyaknya->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Banyaknya->EditValue ?>"<?php echo $t02_pengeluaran->Banyaknya->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Banyaknya" class="t02_pengeluaran_Banyaknya">
<span<?php echo $t02_pengeluaran->Banyaknya->ViewAttributes() ?>>
<?php echo $t02_pengeluaran->Banyaknya->ListViewValue() ?></span>
</span>
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Banyaknya" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Banyaknya->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Banyaknya" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Banyaknya->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Banyaknya" name="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" id="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Banyaknya->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Banyaknya" name="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" id="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Banyaknya->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Satuan->Visible) { // Satuan ?>
		<td data-name="Satuan"<?php echo $t02_pengeluaran->Satuan->CellAttributes() ?>>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Satuan" class="form-group t02_pengeluaran_Satuan">
<input type="text" data-table="t02_pengeluaran" data-field="x_Satuan" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Satuan->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Satuan->EditValue ?>"<?php echo $t02_pengeluaran->Satuan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Satuan" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Satuan->OldValue) ?>">
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Satuan" class="form-group t02_pengeluaran_Satuan">
<input type="text" data-table="t02_pengeluaran" data-field="x_Satuan" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Satuan->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Satuan->EditValue ?>"<?php echo $t02_pengeluaran->Satuan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Satuan" class="t02_pengeluaran_Satuan">
<span<?php echo $t02_pengeluaran->Satuan->ViewAttributes() ?>>
<?php echo $t02_pengeluaran->Satuan->ListViewValue() ?></span>
</span>
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Satuan" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Satuan->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Satuan" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Satuan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Satuan" name="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" id="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Satuan->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Satuan" name="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" id="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Satuan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Jumlah->Visible) { // Jumlah ?>
		<td data-name="Jumlah"<?php echo $t02_pengeluaran->Jumlah->CellAttributes() ?>>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Jumlah" class="form-group t02_pengeluaran_Jumlah">
<input type="text" data-table="t02_pengeluaran" data-field="x_Jumlah" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Jumlah->EditValue ?>"<?php echo $t02_pengeluaran->Jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Jumlah" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Jumlah->OldValue) ?>">
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Jumlah" class="form-group t02_pengeluaran_Jumlah">
<input type="text" data-table="t02_pengeluaran" data-field="x_Jumlah" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Jumlah->EditValue ?>"<?php echo $t02_pengeluaran->Jumlah->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Jumlah" class="t02_pengeluaran_Jumlah">
<span<?php echo $t02_pengeluaran->Jumlah->ViewAttributes() ?>>
<?php echo $t02_pengeluaran->Jumlah->ListViewValue() ?></span>
</span>
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Jumlah" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Jumlah->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Jumlah" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Jumlah->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Jumlah" name="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" id="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Jumlah->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Jumlah" name="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" id="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Jumlah->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Total->Visible) { // Total ?>
		<td data-name="Total"<?php echo $t02_pengeluaran->Total->CellAttributes() ?>>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Total" class="form-group t02_pengeluaran_Total">
<input type="text" data-table="t02_pengeluaran" data-field="x_Total" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Total->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Total->EditValue ?>"<?php echo $t02_pengeluaran->Total->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Total" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Total->OldValue) ?>">
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Total" class="form-group t02_pengeluaran_Total">
<input type="text" data-table="t02_pengeluaran" data-field="x_Total" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Total->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Total->EditValue ?>"<?php echo $t02_pengeluaran->Total->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_pengeluaran_grid->RowCnt ?>_t02_pengeluaran_Total" class="t02_pengeluaran_Total">
<span<?php echo $t02_pengeluaran->Total->ViewAttributes() ?>>
<?php echo $t02_pengeluaran->Total->ListViewValue() ?></span>
</span>
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Total" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Total->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Total" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Total->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Total" name="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" id="ft02_pengeluarangrid$x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Total->FormValue) ?>">
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Total" name="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" id="ft02_pengeluarangrid$o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Total->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t02_pengeluaran_grid->ListOptions->Render("body", "right", $t02_pengeluaran_grid->RowCnt);
?>
	</tr>
<?php if ($t02_pengeluaran->RowType == EW_ROWTYPE_ADD || $t02_pengeluaran->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft02_pengeluarangrid.UpdateOpts(<?php echo $t02_pengeluaran_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t02_pengeluaran->CurrentAction <> "gridadd" || $t02_pengeluaran->CurrentMode == "copy")
		if (!$t02_pengeluaran_grid->Recordset->EOF) $t02_pengeluaran_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t02_pengeluaran->CurrentMode == "add" || $t02_pengeluaran->CurrentMode == "copy" || $t02_pengeluaran->CurrentMode == "edit") {
		$t02_pengeluaran_grid->RowIndex = '$rowindex$';
		$t02_pengeluaran_grid->LoadRowValues();

		// Set row properties
		$t02_pengeluaran->ResetAttrs();
		$t02_pengeluaran->RowAttrs = array_merge($t02_pengeluaran->RowAttrs, array('data-rowindex'=>$t02_pengeluaran_grid->RowIndex, 'id'=>'r0_t02_pengeluaran', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t02_pengeluaran->RowAttrs["class"], "ewTemplate");
		$t02_pengeluaran->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t02_pengeluaran_grid->RenderRow();

		// Render list options
		$t02_pengeluaran_grid->RenderListOptions();
		$t02_pengeluaran_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t02_pengeluaran->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t02_pengeluaran_grid->ListOptions->Render("body", "left", $t02_pengeluaran_grid->RowIndex);
?>
	<?php if ($t02_pengeluaran->Urutan->Visible) { // Urutan ?>
		<td data-name="Urutan">
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_pengeluaran_Urutan" class="form-group t02_pengeluaran_Urutan">
<input type="text" data-table="t02_pengeluaran" data-field="x_Urutan" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Urutan->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Urutan->EditValue ?>"<?php echo $t02_pengeluaran->Urutan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_pengeluaran_Urutan" class="form-group t02_pengeluaran_Urutan">
<span<?php echo $t02_pengeluaran->Urutan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_pengeluaran->Urutan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Urutan" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Urutan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Urutan" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Urutan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Nomor->Visible) { // Nomor ?>
		<td data-name="Nomor">
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_pengeluaran_Nomor" class="form-group t02_pengeluaran_Nomor">
<input type="text" data-table="t02_pengeluaran" data-field="x_Nomor" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Nomor->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Nomor->EditValue ?>"<?php echo $t02_pengeluaran->Nomor->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_pengeluaran_Nomor" class="form-group t02_pengeluaran_Nomor">
<span<?php echo $t02_pengeluaran->Nomor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_pengeluaran->Nomor->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Nomor" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Nomor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Nomor" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Nomor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Kode->Visible) { // Kode ?>
		<td data-name="Kode">
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<?php if ($t02_pengeluaran->Kode->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t02_pengeluaran_Kode" class="form-group t02_pengeluaran_Kode">
<span<?php echo $t02_pengeluaran->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_pengeluaran->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Kode->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t02_pengeluaran_Kode" class="form-group t02_pengeluaran_Kode">
<input type="text" data-table="t02_pengeluaran" data-field="x_Kode" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Kode->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Kode->EditValue ?>"<?php echo $t02_pengeluaran->Kode->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t02_pengeluaran_Kode" class="form-group t02_pengeluaran_Kode">
<span<?php echo $t02_pengeluaran->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_pengeluaran->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Kode" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Kode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Kode" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Kode->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Pos->Visible) { // Pos ?>
		<td data-name="Pos">
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_pengeluaran_Pos" class="form-group t02_pengeluaran_Pos">
<input type="text" data-table="t02_pengeluaran" data-field="x_Pos" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Pos->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Pos->EditValue ?>"<?php echo $t02_pengeluaran->Pos->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_pengeluaran_Pos" class="form-group t02_pengeluaran_Pos">
<span<?php echo $t02_pengeluaran->Pos->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_pengeluaran->Pos->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Pos" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Pos->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Pos" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Pos->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Nominal->Visible) { // Nominal ?>
		<td data-name="Nominal">
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_pengeluaran_Nominal" class="form-group t02_pengeluaran_Nominal">
<input type="text" data-table="t02_pengeluaran" data-field="x_Nominal" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Nominal->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Nominal->EditValue ?>"<?php echo $t02_pengeluaran->Nominal->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_pengeluaran_Nominal" class="form-group t02_pengeluaran_Nominal">
<span<?php echo $t02_pengeluaran->Nominal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_pengeluaran->Nominal->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Nominal" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Nominal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Nominal" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Nominal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Banyaknya->Visible) { // Banyaknya ?>
		<td data-name="Banyaknya">
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_pengeluaran_Banyaknya" class="form-group t02_pengeluaran_Banyaknya">
<input type="text" data-table="t02_pengeluaran" data-field="x_Banyaknya" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Banyaknya->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Banyaknya->EditValue ?>"<?php echo $t02_pengeluaran->Banyaknya->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_pengeluaran_Banyaknya" class="form-group t02_pengeluaran_Banyaknya">
<span<?php echo $t02_pengeluaran->Banyaknya->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_pengeluaran->Banyaknya->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Banyaknya" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Banyaknya->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Banyaknya" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Banyaknya->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Satuan->Visible) { // Satuan ?>
		<td data-name="Satuan">
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_pengeluaran_Satuan" class="form-group t02_pengeluaran_Satuan">
<input type="text" data-table="t02_pengeluaran" data-field="x_Satuan" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Satuan->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Satuan->EditValue ?>"<?php echo $t02_pengeluaran->Satuan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_pengeluaran_Satuan" class="form-group t02_pengeluaran_Satuan">
<span<?php echo $t02_pengeluaran->Satuan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_pengeluaran->Satuan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Satuan" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Satuan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Satuan" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Satuan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Jumlah->Visible) { // Jumlah ?>
		<td data-name="Jumlah">
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_pengeluaran_Jumlah" class="form-group t02_pengeluaran_Jumlah">
<input type="text" data-table="t02_pengeluaran" data-field="x_Jumlah" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Jumlah->EditValue ?>"<?php echo $t02_pengeluaran->Jumlah->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_pengeluaran_Jumlah" class="form-group t02_pengeluaran_Jumlah">
<span<?php echo $t02_pengeluaran->Jumlah->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_pengeluaran->Jumlah->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Jumlah" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Jumlah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Jumlah" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Jumlah->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_pengeluaran->Total->Visible) { // Total ?>
		<td data-name="Total">
<?php if ($t02_pengeluaran->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_pengeluaran_Total" class="form-group t02_pengeluaran_Total">
<input type="text" data-table="t02_pengeluaran" data-field="x_Total" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" size="30" placeholder="<?php echo ew_HtmlEncode($t02_pengeluaran->Total->getPlaceHolder()) ?>" value="<?php echo $t02_pengeluaran->Total->EditValue ?>"<?php echo $t02_pengeluaran->Total->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_pengeluaran_Total" class="form-group t02_pengeluaran_Total">
<span<?php echo $t02_pengeluaran->Total->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_pengeluaran->Total->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Total" name="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" id="x<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Total->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_pengeluaran" data-field="x_Total" name="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" id="o<?php echo $t02_pengeluaran_grid->RowIndex ?>_Total" value="<?php echo ew_HtmlEncode($t02_pengeluaran->Total->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t02_pengeluaran_grid->ListOptions->Render("body", "right", $t02_pengeluaran_grid->RowIndex);
?>
<script type="text/javascript">
ft02_pengeluarangrid.UpdateOpts(<?php echo $t02_pengeluaran_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t02_pengeluaran->CurrentMode == "add" || $t02_pengeluaran->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t02_pengeluaran_grid->FormKeyCountName ?>" id="<?php echo $t02_pengeluaran_grid->FormKeyCountName ?>" value="<?php echo $t02_pengeluaran_grid->KeyCount ?>">
<?php echo $t02_pengeluaran_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t02_pengeluaran->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t02_pengeluaran_grid->FormKeyCountName ?>" id="<?php echo $t02_pengeluaran_grid->FormKeyCountName ?>" value="<?php echo $t02_pengeluaran_grid->KeyCount ?>">
<?php echo $t02_pengeluaran_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t02_pengeluaran->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft02_pengeluarangrid">
</div>
<?php

// Close recordset
if ($t02_pengeluaran_grid->Recordset)
	$t02_pengeluaran_grid->Recordset->Close();
?>
<?php if ($t02_pengeluaran_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($t02_pengeluaran_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t02_pengeluaran_grid->TotalRecs == 0 && $t02_pengeluaran->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t02_pengeluaran_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t02_pengeluaran->Export == "") { ?>
<script type="text/javascript">
ft02_pengeluarangrid.Init();
</script>
<?php } ?>
<?php
$t02_pengeluaran_grid->Page_Terminate();
?>
