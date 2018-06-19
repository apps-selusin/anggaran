<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t02_penerimaan_detail_grid)) $t02_penerimaan_detail_grid = new ct02_penerimaan_detail_grid();

// Page init
$t02_penerimaan_detail_grid->Page_Init();

// Page main
$t02_penerimaan_detail_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t02_penerimaan_detail_grid->Page_Render();
?>
<?php if ($t02_penerimaan_detail->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft02_penerimaan_detailgrid = new ew_Form("ft02_penerimaan_detailgrid", "grid");
ft02_penerimaan_detailgrid.FormKeyCountName = '<?php echo $t02_penerimaan_detail_grid->FormKeyCountName ?>';

// Validate form
ft02_penerimaan_detailgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_penerimaan_detail->Urutan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Nominal");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_penerimaan_detail->Nominal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Banyaknya");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_penerimaan_detail->Banyaknya->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Satuan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_penerimaan_detail->Satuan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_penerimaan_detail->Jumlah->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft02_penerimaan_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Urutan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nomor", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Kode", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Pos", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nominal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Banyaknya", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Satuan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Jumlah", false)) return false;
	return true;
}

// Form_CustomValidate event
ft02_penerimaan_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft02_penerimaan_detailgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($t02_penerimaan_detail->CurrentAction == "gridadd") {
	if ($t02_penerimaan_detail->CurrentMode == "copy") {
		$bSelectLimit = $t02_penerimaan_detail_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t02_penerimaan_detail_grid->TotalRecs = $t02_penerimaan_detail->ListRecordCount();
			$t02_penerimaan_detail_grid->Recordset = $t02_penerimaan_detail_grid->LoadRecordset($t02_penerimaan_detail_grid->StartRec-1, $t02_penerimaan_detail_grid->DisplayRecs);
		} else {
			if ($t02_penerimaan_detail_grid->Recordset = $t02_penerimaan_detail_grid->LoadRecordset())
				$t02_penerimaan_detail_grid->TotalRecs = $t02_penerimaan_detail_grid->Recordset->RecordCount();
		}
		$t02_penerimaan_detail_grid->StartRec = 1;
		$t02_penerimaan_detail_grid->DisplayRecs = $t02_penerimaan_detail_grid->TotalRecs;
	} else {
		$t02_penerimaan_detail->CurrentFilter = "0=1";
		$t02_penerimaan_detail_grid->StartRec = 1;
		$t02_penerimaan_detail_grid->DisplayRecs = $t02_penerimaan_detail->GridAddRowCount;
	}
	$t02_penerimaan_detail_grid->TotalRecs = $t02_penerimaan_detail_grid->DisplayRecs;
	$t02_penerimaan_detail_grid->StopRec = $t02_penerimaan_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = $t02_penerimaan_detail_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t02_penerimaan_detail_grid->TotalRecs <= 0)
			$t02_penerimaan_detail_grid->TotalRecs = $t02_penerimaan_detail->ListRecordCount();
	} else {
		if (!$t02_penerimaan_detail_grid->Recordset && ($t02_penerimaan_detail_grid->Recordset = $t02_penerimaan_detail_grid->LoadRecordset()))
			$t02_penerimaan_detail_grid->TotalRecs = $t02_penerimaan_detail_grid->Recordset->RecordCount();
	}
	$t02_penerimaan_detail_grid->StartRec = 1;
	$t02_penerimaan_detail_grid->DisplayRecs = $t02_penerimaan_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t02_penerimaan_detail_grid->Recordset = $t02_penerimaan_detail_grid->LoadRecordset($t02_penerimaan_detail_grid->StartRec-1, $t02_penerimaan_detail_grid->DisplayRecs);

	// Set no record found message
	if ($t02_penerimaan_detail->CurrentAction == "" && $t02_penerimaan_detail_grid->TotalRecs == 0) {
		if ($t02_penerimaan_detail_grid->SearchWhere == "0=101")
			$t02_penerimaan_detail_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t02_penerimaan_detail_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t02_penerimaan_detail_grid->RenderOtherOptions();
?>
<?php $t02_penerimaan_detail_grid->ShowPageHeader(); ?>
<?php
$t02_penerimaan_detail_grid->ShowMessage();
?>
<?php if ($t02_penerimaan_detail_grid->TotalRecs > 0 || $t02_penerimaan_detail->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t02_penerimaan_detail_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t02_penerimaan_detail">
<div id="ft02_penerimaan_detailgrid" class="ewForm ewListForm form-inline">
<div id="gmp_t02_penerimaan_detail" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_t02_penerimaan_detailgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t02_penerimaan_detail_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t02_penerimaan_detail_grid->RenderListOptions();

// Render list options (header, left)
$t02_penerimaan_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($t02_penerimaan_detail->id->Visible) { // id ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->id) == "") { ?>
		<th data-name="id" class="<?php echo $t02_penerimaan_detail->id->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_id" class="t02_penerimaan_detail_id"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $t02_penerimaan_detail->id->HeaderCellClass() ?>"><div><div id="elh_t02_penerimaan_detail_id" class="t02_penerimaan_detail_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Urutan->Visible) { // Urutan ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Urutan) == "") { ?>
		<th data-name="Urutan" class="<?php echo $t02_penerimaan_detail->Urutan->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Urutan" class="t02_penerimaan_detail_Urutan"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Urutan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Urutan" class="<?php echo $t02_penerimaan_detail->Urutan->HeaderCellClass() ?>"><div><div id="elh_t02_penerimaan_detail_Urutan" class="t02_penerimaan_detail_Urutan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Urutan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Urutan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Urutan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Nomor->Visible) { // Nomor ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Nomor) == "") { ?>
		<th data-name="Nomor" class="<?php echo $t02_penerimaan_detail->Nomor->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Nomor" class="t02_penerimaan_detail_Nomor"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Nomor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nomor" class="<?php echo $t02_penerimaan_detail->Nomor->HeaderCellClass() ?>"><div><div id="elh_t02_penerimaan_detail_Nomor" class="t02_penerimaan_detail_Nomor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Nomor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Nomor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Nomor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Kode->Visible) { // Kode ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Kode) == "") { ?>
		<th data-name="Kode" class="<?php echo $t02_penerimaan_detail->Kode->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Kode" class="t02_penerimaan_detail_Kode"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Kode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Kode" class="<?php echo $t02_penerimaan_detail->Kode->HeaderCellClass() ?>"><div><div id="elh_t02_penerimaan_detail_Kode" class="t02_penerimaan_detail_Kode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Kode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Kode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Kode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Pos->Visible) { // Pos ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Pos) == "") { ?>
		<th data-name="Pos" class="<?php echo $t02_penerimaan_detail->Pos->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Pos" class="t02_penerimaan_detail_Pos"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Pos->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Pos" class="<?php echo $t02_penerimaan_detail->Pos->HeaderCellClass() ?>"><div><div id="elh_t02_penerimaan_detail_Pos" class="t02_penerimaan_detail_Pos">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Pos->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Pos->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Pos->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Nominal->Visible) { // Nominal ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Nominal) == "") { ?>
		<th data-name="Nominal" class="<?php echo $t02_penerimaan_detail->Nominal->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Nominal" class="t02_penerimaan_detail_Nominal"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Nominal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nominal" class="<?php echo $t02_penerimaan_detail->Nominal->HeaderCellClass() ?>"><div><div id="elh_t02_penerimaan_detail_Nominal" class="t02_penerimaan_detail_Nominal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Nominal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Nominal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Nominal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Banyaknya->Visible) { // Banyaknya ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Banyaknya) == "") { ?>
		<th data-name="Banyaknya" class="<?php echo $t02_penerimaan_detail->Banyaknya->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Banyaknya" class="t02_penerimaan_detail_Banyaknya"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Banyaknya->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Banyaknya" class="<?php echo $t02_penerimaan_detail->Banyaknya->HeaderCellClass() ?>"><div><div id="elh_t02_penerimaan_detail_Banyaknya" class="t02_penerimaan_detail_Banyaknya">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Banyaknya->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Banyaknya->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Banyaknya->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Satuan->Visible) { // Satuan ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Satuan) == "") { ?>
		<th data-name="Satuan" class="<?php echo $t02_penerimaan_detail->Satuan->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Satuan" class="t02_penerimaan_detail_Satuan"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Satuan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Satuan" class="<?php echo $t02_penerimaan_detail->Satuan->HeaderCellClass() ?>"><div><div id="elh_t02_penerimaan_detail_Satuan" class="t02_penerimaan_detail_Satuan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Satuan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Satuan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Satuan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Jumlah->Visible) { // Jumlah ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Jumlah) == "") { ?>
		<th data-name="Jumlah" class="<?php echo $t02_penerimaan_detail->Jumlah->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Jumlah" class="t02_penerimaan_detail_Jumlah"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Jumlah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jumlah" class="<?php echo $t02_penerimaan_detail->Jumlah->HeaderCellClass() ?>"><div><div id="elh_t02_penerimaan_detail_Jumlah" class="t02_penerimaan_detail_Jumlah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Jumlah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t02_penerimaan_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t02_penerimaan_detail_grid->StartRec = 1;
$t02_penerimaan_detail_grid->StopRec = $t02_penerimaan_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t02_penerimaan_detail_grid->FormKeyCountName) && ($t02_penerimaan_detail->CurrentAction == "gridadd" || $t02_penerimaan_detail->CurrentAction == "gridedit" || $t02_penerimaan_detail->CurrentAction == "F")) {
		$t02_penerimaan_detail_grid->KeyCount = $objForm->GetValue($t02_penerimaan_detail_grid->FormKeyCountName);
		$t02_penerimaan_detail_grid->StopRec = $t02_penerimaan_detail_grid->StartRec + $t02_penerimaan_detail_grid->KeyCount - 1;
	}
}
$t02_penerimaan_detail_grid->RecCnt = $t02_penerimaan_detail_grid->StartRec - 1;
if ($t02_penerimaan_detail_grid->Recordset && !$t02_penerimaan_detail_grid->Recordset->EOF) {
	$t02_penerimaan_detail_grid->Recordset->MoveFirst();
	$bSelectLimit = $t02_penerimaan_detail_grid->UseSelectLimit;
	if (!$bSelectLimit && $t02_penerimaan_detail_grid->StartRec > 1)
		$t02_penerimaan_detail_grid->Recordset->Move($t02_penerimaan_detail_grid->StartRec - 1);
} elseif (!$t02_penerimaan_detail->AllowAddDeleteRow && $t02_penerimaan_detail_grid->StopRec == 0) {
	$t02_penerimaan_detail_grid->StopRec = $t02_penerimaan_detail->GridAddRowCount;
}

// Initialize aggregate
$t02_penerimaan_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t02_penerimaan_detail->ResetAttrs();
$t02_penerimaan_detail_grid->RenderRow();
if ($t02_penerimaan_detail->CurrentAction == "gridadd")
	$t02_penerimaan_detail_grid->RowIndex = 0;
if ($t02_penerimaan_detail->CurrentAction == "gridedit")
	$t02_penerimaan_detail_grid->RowIndex = 0;
while ($t02_penerimaan_detail_grid->RecCnt < $t02_penerimaan_detail_grid->StopRec) {
	$t02_penerimaan_detail_grid->RecCnt++;
	if (intval($t02_penerimaan_detail_grid->RecCnt) >= intval($t02_penerimaan_detail_grid->StartRec)) {
		$t02_penerimaan_detail_grid->RowCnt++;
		if ($t02_penerimaan_detail->CurrentAction == "gridadd" || $t02_penerimaan_detail->CurrentAction == "gridedit" || $t02_penerimaan_detail->CurrentAction == "F") {
			$t02_penerimaan_detail_grid->RowIndex++;
			$objForm->Index = $t02_penerimaan_detail_grid->RowIndex;
			if ($objForm->HasValue($t02_penerimaan_detail_grid->FormActionName))
				$t02_penerimaan_detail_grid->RowAction = strval($objForm->GetValue($t02_penerimaan_detail_grid->FormActionName));
			elseif ($t02_penerimaan_detail->CurrentAction == "gridadd")
				$t02_penerimaan_detail_grid->RowAction = "insert";
			else
				$t02_penerimaan_detail_grid->RowAction = "";
		}

		// Set up key count
		$t02_penerimaan_detail_grid->KeyCount = $t02_penerimaan_detail_grid->RowIndex;

		// Init row class and style
		$t02_penerimaan_detail->ResetAttrs();
		$t02_penerimaan_detail->CssClass = "";
		if ($t02_penerimaan_detail->CurrentAction == "gridadd") {
			if ($t02_penerimaan_detail->CurrentMode == "copy") {
				$t02_penerimaan_detail_grid->LoadRowValues($t02_penerimaan_detail_grid->Recordset); // Load row values
				$t02_penerimaan_detail_grid->SetRecordKey($t02_penerimaan_detail_grid->RowOldKey, $t02_penerimaan_detail_grid->Recordset); // Set old record key
			} else {
				$t02_penerimaan_detail_grid->LoadRowValues(); // Load default values
				$t02_penerimaan_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t02_penerimaan_detail_grid->LoadRowValues($t02_penerimaan_detail_grid->Recordset); // Load row values
		}
		$t02_penerimaan_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t02_penerimaan_detail->CurrentAction == "gridadd") // Grid add
			$t02_penerimaan_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t02_penerimaan_detail->CurrentAction == "gridadd" && $t02_penerimaan_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t02_penerimaan_detail_grid->RestoreCurrentRowFormValues($t02_penerimaan_detail_grid->RowIndex); // Restore form values
		if ($t02_penerimaan_detail->CurrentAction == "gridedit") { // Grid edit
			if ($t02_penerimaan_detail->EventCancelled) {
				$t02_penerimaan_detail_grid->RestoreCurrentRowFormValues($t02_penerimaan_detail_grid->RowIndex); // Restore form values
			}
			if ($t02_penerimaan_detail_grid->RowAction == "insert")
				$t02_penerimaan_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t02_penerimaan_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t02_penerimaan_detail->CurrentAction == "gridedit" && ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT || $t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) && $t02_penerimaan_detail->EventCancelled) // Update failed
			$t02_penerimaan_detail_grid->RestoreCurrentRowFormValues($t02_penerimaan_detail_grid->RowIndex); // Restore form values
		if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t02_penerimaan_detail_grid->EditRowCnt++;
		if ($t02_penerimaan_detail->CurrentAction == "F") // Confirm row
			$t02_penerimaan_detail_grid->RestoreCurrentRowFormValues($t02_penerimaan_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t02_penerimaan_detail->RowAttrs = array_merge($t02_penerimaan_detail->RowAttrs, array('data-rowindex'=>$t02_penerimaan_detail_grid->RowCnt, 'id'=>'r' . $t02_penerimaan_detail_grid->RowCnt . '_t02_penerimaan_detail', 'data-rowtype'=>$t02_penerimaan_detail->RowType));

		// Render row
		$t02_penerimaan_detail_grid->RenderRow();

		// Render list options
		$t02_penerimaan_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t02_penerimaan_detail_grid->RowAction <> "delete" && $t02_penerimaan_detail_grid->RowAction <> "insertdelete" && !($t02_penerimaan_detail_grid->RowAction == "insert" && $t02_penerimaan_detail->CurrentAction == "F" && $t02_penerimaan_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $t02_penerimaan_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t02_penerimaan_detail_grid->ListOptions->Render("body", "left", $t02_penerimaan_detail_grid->RowCnt);
?>
	<?php if ($t02_penerimaan_detail->id->Visible) { // id ?>
		<td data-name="id"<?php echo $t02_penerimaan_detail->id->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_id" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->id->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_id" class="form-group t02_penerimaan_detail_id">
<span<?php echo $t02_penerimaan_detail->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_id" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->id->CurrentValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_id" class="t02_penerimaan_detail_id">
<span<?php echo $t02_penerimaan_detail->id->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->id->ListViewValue() ?></span>
</span>
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_id" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->id->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_id" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_id" name="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" id="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->id->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_id" name="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" id="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Urutan->Visible) { // Urutan ?>
		<td data-name="Urutan"<?php echo $t02_penerimaan_detail->Urutan->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Urutan" class="form-group t02_penerimaan_detail_Urutan">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Urutan->EditValue ?>"<?php echo $t02_penerimaan_detail->Urutan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Urutan" class="form-group t02_penerimaan_detail_Urutan">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Urutan->EditValue ?>"<?php echo $t02_penerimaan_detail->Urutan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Urutan" class="t02_penerimaan_detail_Urutan">
<span<?php echo $t02_penerimaan_detail->Urutan->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Urutan->ListViewValue() ?></span>
</span>
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" id="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" id="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Nomor->Visible) { // Nomor ?>
		<td data-name="Nomor"<?php echo $t02_penerimaan_detail->Nomor->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Nomor" class="form-group t02_penerimaan_detail_Nomor">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Nomor->EditValue ?>"<?php echo $t02_penerimaan_detail->Nomor->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Nomor" class="form-group t02_penerimaan_detail_Nomor">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Nomor->EditValue ?>"<?php echo $t02_penerimaan_detail->Nomor->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Nomor" class="t02_penerimaan_detail_Nomor">
<span<?php echo $t02_penerimaan_detail->Nomor->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Nomor->ListViewValue() ?></span>
</span>
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" id="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" id="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Kode->Visible) { // Kode ?>
		<td data-name="Kode"<?php echo $t02_penerimaan_detail->Kode->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t02_penerimaan_detail->Kode->getSessionValue() <> "") { ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Kode" class="form-group t02_penerimaan_detail_Kode">
<span<?php echo $t02_penerimaan_detail->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Kode" class="form-group t02_penerimaan_detail_Kode">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Kode" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Kode->EditValue ?>"<?php echo $t02_penerimaan_detail->Kode->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Kode" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t02_penerimaan_detail->Kode->getSessionValue() <> "") { ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Kode" class="form-group t02_penerimaan_detail_Kode">
<span<?php echo $t02_penerimaan_detail->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Kode" class="form-group t02_penerimaan_detail_Kode">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Kode" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Kode->EditValue ?>"<?php echo $t02_penerimaan_detail->Kode->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Kode" class="t02_penerimaan_detail_Kode">
<span<?php echo $t02_penerimaan_detail->Kode->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Kode->ListViewValue() ?></span>
</span>
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Kode" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Kode" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Kode" name="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" id="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Kode" name="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" id="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Pos->Visible) { // Pos ?>
		<td data-name="Pos"<?php echo $t02_penerimaan_detail->Pos->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Pos" class="form-group t02_penerimaan_detail_Pos">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Pos" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Pos->EditValue ?>"<?php echo $t02_penerimaan_detail->Pos->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Pos" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Pos" class="form-group t02_penerimaan_detail_Pos">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Pos" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Pos->EditValue ?>"<?php echo $t02_penerimaan_detail->Pos->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Pos" class="t02_penerimaan_detail_Pos">
<span<?php echo $t02_penerimaan_detail->Pos->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Pos->ListViewValue() ?></span>
</span>
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Pos" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Pos" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Pos" name="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" id="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Pos" name="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" id="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Nominal->Visible) { // Nominal ?>
		<td data-name="Nominal"<?php echo $t02_penerimaan_detail->Nominal->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Nominal" class="form-group t02_penerimaan_detail_Nominal">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Nominal->EditValue ?>"<?php echo $t02_penerimaan_detail->Nominal->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Nominal" class="form-group t02_penerimaan_detail_Nominal">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Nominal->EditValue ?>"<?php echo $t02_penerimaan_detail->Nominal->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Nominal" class="t02_penerimaan_detail_Nominal">
<span<?php echo $t02_penerimaan_detail->Nominal->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Nominal->ListViewValue() ?></span>
</span>
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" id="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" id="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Banyaknya->Visible) { // Banyaknya ?>
		<td data-name="Banyaknya"<?php echo $t02_penerimaan_detail->Banyaknya->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Banyaknya" class="form-group t02_penerimaan_detail_Banyaknya">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Banyaknya->EditValue ?>"<?php echo $t02_penerimaan_detail->Banyaknya->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Banyaknya" class="form-group t02_penerimaan_detail_Banyaknya">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Banyaknya->EditValue ?>"<?php echo $t02_penerimaan_detail->Banyaknya->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Banyaknya" class="t02_penerimaan_detail_Banyaknya">
<span<?php echo $t02_penerimaan_detail->Banyaknya->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Banyaknya->ListViewValue() ?></span>
</span>
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" id="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" id="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Satuan->Visible) { // Satuan ?>
		<td data-name="Satuan"<?php echo $t02_penerimaan_detail->Satuan->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Satuan" class="form-group t02_penerimaan_detail_Satuan">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Satuan->EditValue ?>"<?php echo $t02_penerimaan_detail->Satuan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Satuan" class="form-group t02_penerimaan_detail_Satuan">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Satuan->EditValue ?>"<?php echo $t02_penerimaan_detail->Satuan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Satuan" class="t02_penerimaan_detail_Satuan">
<span<?php echo $t02_penerimaan_detail->Satuan->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Satuan->ListViewValue() ?></span>
</span>
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" id="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" id="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Jumlah->Visible) { // Jumlah ?>
		<td data-name="Jumlah"<?php echo $t02_penerimaan_detail->Jumlah->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Jumlah" class="form-group t02_penerimaan_detail_Jumlah">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Jumlah->EditValue ?>"<?php echo $t02_penerimaan_detail->Jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Jumlah" class="form-group t02_penerimaan_detail_Jumlah">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Jumlah->EditValue ?>"<?php echo $t02_penerimaan_detail->Jumlah->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_grid->RowCnt ?>_t02_penerimaan_detail_Jumlah" class="t02_penerimaan_detail_Jumlah">
<span<?php echo $t02_penerimaan_detail->Jumlah->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Jumlah->ListViewValue() ?></span>
</span>
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" id="ft02_penerimaan_detailgrid$x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->FormValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" id="ft02_penerimaan_detailgrid$o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t02_penerimaan_detail_grid->ListOptions->Render("body", "right", $t02_penerimaan_detail_grid->RowCnt);
?>
	</tr>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD || $t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft02_penerimaan_detailgrid.UpdateOpts(<?php echo $t02_penerimaan_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t02_penerimaan_detail->CurrentAction <> "gridadd" || $t02_penerimaan_detail->CurrentMode == "copy")
		if (!$t02_penerimaan_detail_grid->Recordset->EOF) $t02_penerimaan_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t02_penerimaan_detail->CurrentMode == "add" || $t02_penerimaan_detail->CurrentMode == "copy" || $t02_penerimaan_detail->CurrentMode == "edit") {
		$t02_penerimaan_detail_grid->RowIndex = '$rowindex$';
		$t02_penerimaan_detail_grid->LoadRowValues();

		// Set row properties
		$t02_penerimaan_detail->ResetAttrs();
		$t02_penerimaan_detail->RowAttrs = array_merge($t02_penerimaan_detail->RowAttrs, array('data-rowindex'=>$t02_penerimaan_detail_grid->RowIndex, 'id'=>'r0_t02_penerimaan_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t02_penerimaan_detail->RowAttrs["class"], "ewTemplate");
		$t02_penerimaan_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t02_penerimaan_detail_grid->RenderRow();

		// Render list options
		$t02_penerimaan_detail_grid->RenderListOptions();
		$t02_penerimaan_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t02_penerimaan_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t02_penerimaan_detail_grid->ListOptions->Render("body", "left", $t02_penerimaan_detail_grid->RowIndex);
?>
	<?php if ($t02_penerimaan_detail->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_t02_penerimaan_detail_id" class="form-group t02_penerimaan_detail_id">
<span<?php echo $t02_penerimaan_detail->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_id" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_id" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Urutan->Visible) { // Urutan ?>
		<td data-name="Urutan">
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Urutan" class="form-group t02_penerimaan_detail_Urutan">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Urutan->EditValue ?>"<?php echo $t02_penerimaan_detail->Urutan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Urutan" class="form-group t02_penerimaan_detail_Urutan">
<span<?php echo $t02_penerimaan_detail->Urutan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Urutan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Nomor->Visible) { // Nomor ?>
		<td data-name="Nomor">
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Nomor" class="form-group t02_penerimaan_detail_Nomor">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Nomor->EditValue ?>"<?php echo $t02_penerimaan_detail->Nomor->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Nomor" class="form-group t02_penerimaan_detail_Nomor">
<span<?php echo $t02_penerimaan_detail->Nomor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Nomor->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Kode->Visible) { // Kode ?>
		<td data-name="Kode">
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<?php if ($t02_penerimaan_detail->Kode->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Kode" class="form-group t02_penerimaan_detail_Kode">
<span<?php echo $t02_penerimaan_detail->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Kode" class="form-group t02_penerimaan_detail_Kode">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Kode" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Kode->EditValue ?>"<?php echo $t02_penerimaan_detail->Kode->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Kode" class="form-group t02_penerimaan_detail_Kode">
<span<?php echo $t02_penerimaan_detail->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Kode" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Kode" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Pos->Visible) { // Pos ?>
		<td data-name="Pos">
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Pos" class="form-group t02_penerimaan_detail_Pos">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Pos" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Pos->EditValue ?>"<?php echo $t02_penerimaan_detail->Pos->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Pos" class="form-group t02_penerimaan_detail_Pos">
<span<?php echo $t02_penerimaan_detail->Pos->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Pos->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Pos" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Pos" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Nominal->Visible) { // Nominal ?>
		<td data-name="Nominal">
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Nominal" class="form-group t02_penerimaan_detail_Nominal">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Nominal->EditValue ?>"<?php echo $t02_penerimaan_detail->Nominal->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Nominal" class="form-group t02_penerimaan_detail_Nominal">
<span<?php echo $t02_penerimaan_detail->Nominal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Nominal->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Banyaknya->Visible) { // Banyaknya ?>
		<td data-name="Banyaknya">
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Banyaknya" class="form-group t02_penerimaan_detail_Banyaknya">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Banyaknya->EditValue ?>"<?php echo $t02_penerimaan_detail->Banyaknya->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Banyaknya" class="form-group t02_penerimaan_detail_Banyaknya">
<span<?php echo $t02_penerimaan_detail->Banyaknya->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Banyaknya->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Satuan->Visible) { // Satuan ?>
		<td data-name="Satuan">
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Satuan" class="form-group t02_penerimaan_detail_Satuan">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Satuan->EditValue ?>"<?php echo $t02_penerimaan_detail->Satuan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Satuan" class="form-group t02_penerimaan_detail_Satuan">
<span<?php echo $t02_penerimaan_detail->Satuan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Satuan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Jumlah->Visible) { // Jumlah ?>
		<td data-name="Jumlah">
<?php if ($t02_penerimaan_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Jumlah" class="form-group t02_penerimaan_detail_Jumlah">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Jumlah->EditValue ?>"<?php echo $t02_penerimaan_detail->Jumlah->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Jumlah" class="form-group t02_penerimaan_detail_Jumlah">
<span<?php echo $t02_penerimaan_detail->Jumlah->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Jumlah->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" id="o<?php echo $t02_penerimaan_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t02_penerimaan_detail_grid->ListOptions->Render("body", "right", $t02_penerimaan_detail_grid->RowIndex);
?>
<script type="text/javascript">
ft02_penerimaan_detailgrid.UpdateOpts(<?php echo $t02_penerimaan_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t02_penerimaan_detail->CurrentMode == "add" || $t02_penerimaan_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t02_penerimaan_detail_grid->FormKeyCountName ?>" id="<?php echo $t02_penerimaan_detail_grid->FormKeyCountName ?>" value="<?php echo $t02_penerimaan_detail_grid->KeyCount ?>">
<?php echo $t02_penerimaan_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t02_penerimaan_detail_grid->FormKeyCountName ?>" id="<?php echo $t02_penerimaan_detail_grid->FormKeyCountName ?>" value="<?php echo $t02_penerimaan_detail_grid->KeyCount ?>">
<?php echo $t02_penerimaan_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft02_penerimaan_detailgrid">
</div>
<?php

// Close recordset
if ($t02_penerimaan_detail_grid->Recordset)
	$t02_penerimaan_detail_grid->Recordset->Close();
?>
<?php if ($t02_penerimaan_detail_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($t02_penerimaan_detail_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t02_penerimaan_detail_grid->TotalRecs == 0 && $t02_penerimaan_detail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t02_penerimaan_detail_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t02_penerimaan_detail->Export == "") { ?>
<script type="text/javascript">
ft02_penerimaan_detailgrid.Init();
</script>
<?php } ?>
<?php
$t02_penerimaan_detail_grid->Page_Terminate();
?>
