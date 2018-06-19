<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t04_pengeluaran_detail_grid)) $t04_pengeluaran_detail_grid = new ct04_pengeluaran_detail_grid();

// Page init
$t04_pengeluaran_detail_grid->Page_Init();

// Page main
$t04_pengeluaran_detail_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t04_pengeluaran_detail_grid->Page_Render();
?>
<?php if ($t04_pengeluaran_detail->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft04_pengeluaran_detailgrid = new ew_Form("ft04_pengeluaran_detailgrid", "grid");
ft04_pengeluaran_detailgrid.FormKeyCountName = '<?php echo $t04_pengeluaran_detail_grid->FormKeyCountName ?>';

// Validate form
ft04_pengeluaran_detailgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($t04_pengeluaran_detail->Urutan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Nominal");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t04_pengeluaran_detail->Nominal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Banyaknya");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t04_pengeluaran_detail->Banyaknya->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t04_pengeluaran_detail->Jumlah->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft04_pengeluaran_detailgrid.EmptyRow = function(infix) {
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
ft04_pengeluaran_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft04_pengeluaran_detailgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft04_pengeluaran_detailgrid.Lists["x_Satuan"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t05_satuan"};
ft04_pengeluaran_detailgrid.Lists["x_Satuan"].Data = "<?php echo $t04_pengeluaran_detail_grid->Satuan->LookupFilterQuery(FALSE, "grid") ?>";
ft04_pengeluaran_detailgrid.AutoSuggests["x_Satuan"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $t04_pengeluaran_detail_grid->Satuan->LookupFilterQuery(TRUE, "grid"))) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($t04_pengeluaran_detail->CurrentAction == "gridadd") {
	if ($t04_pengeluaran_detail->CurrentMode == "copy") {
		$bSelectLimit = $t04_pengeluaran_detail_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t04_pengeluaran_detail_grid->TotalRecs = $t04_pengeluaran_detail->ListRecordCount();
			$t04_pengeluaran_detail_grid->Recordset = $t04_pengeluaran_detail_grid->LoadRecordset($t04_pengeluaran_detail_grid->StartRec-1, $t04_pengeluaran_detail_grid->DisplayRecs);
		} else {
			if ($t04_pengeluaran_detail_grid->Recordset = $t04_pengeluaran_detail_grid->LoadRecordset())
				$t04_pengeluaran_detail_grid->TotalRecs = $t04_pengeluaran_detail_grid->Recordset->RecordCount();
		}
		$t04_pengeluaran_detail_grid->StartRec = 1;
		$t04_pengeluaran_detail_grid->DisplayRecs = $t04_pengeluaran_detail_grid->TotalRecs;
	} else {
		$t04_pengeluaran_detail->CurrentFilter = "0=1";
		$t04_pengeluaran_detail_grid->StartRec = 1;
		$t04_pengeluaran_detail_grid->DisplayRecs = $t04_pengeluaran_detail->GridAddRowCount;
	}
	$t04_pengeluaran_detail_grid->TotalRecs = $t04_pengeluaran_detail_grid->DisplayRecs;
	$t04_pengeluaran_detail_grid->StopRec = $t04_pengeluaran_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = $t04_pengeluaran_detail_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t04_pengeluaran_detail_grid->TotalRecs <= 0)
			$t04_pengeluaran_detail_grid->TotalRecs = $t04_pengeluaran_detail->ListRecordCount();
	} else {
		if (!$t04_pengeluaran_detail_grid->Recordset && ($t04_pengeluaran_detail_grid->Recordset = $t04_pengeluaran_detail_grid->LoadRecordset()))
			$t04_pengeluaran_detail_grid->TotalRecs = $t04_pengeluaran_detail_grid->Recordset->RecordCount();
	}
	$t04_pengeluaran_detail_grid->StartRec = 1;
	$t04_pengeluaran_detail_grid->DisplayRecs = $t04_pengeluaran_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t04_pengeluaran_detail_grid->Recordset = $t04_pengeluaran_detail_grid->LoadRecordset($t04_pengeluaran_detail_grid->StartRec-1, $t04_pengeluaran_detail_grid->DisplayRecs);

	// Set no record found message
	if ($t04_pengeluaran_detail->CurrentAction == "" && $t04_pengeluaran_detail_grid->TotalRecs == 0) {
		if ($t04_pengeluaran_detail_grid->SearchWhere == "0=101")
			$t04_pengeluaran_detail_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t04_pengeluaran_detail_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t04_pengeluaran_detail_grid->RenderOtherOptions();
?>
<?php $t04_pengeluaran_detail_grid->ShowPageHeader(); ?>
<?php
$t04_pengeluaran_detail_grid->ShowMessage();
?>
<?php if ($t04_pengeluaran_detail_grid->TotalRecs > 0 || $t04_pengeluaran_detail->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t04_pengeluaran_detail_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t04_pengeluaran_detail">
<div id="ft04_pengeluaran_detailgrid" class="ewForm ewListForm form-inline">
<div id="gmp_t04_pengeluaran_detail" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_t04_pengeluaran_detailgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t04_pengeluaran_detail_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t04_pengeluaran_detail_grid->RenderListOptions();

// Render list options (header, left)
$t04_pengeluaran_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($t04_pengeluaran_detail->Urutan->Visible) { // Urutan ?>
	<?php if ($t04_pengeluaran_detail->SortUrl($t04_pengeluaran_detail->Urutan) == "") { ?>
		<th data-name="Urutan" class="<?php echo $t04_pengeluaran_detail->Urutan->HeaderCellClass() ?>"><div id="elh_t04_pengeluaran_detail_Urutan" class="t04_pengeluaran_detail_Urutan"><div class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Urutan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Urutan" class="<?php echo $t04_pengeluaran_detail->Urutan->HeaderCellClass() ?>"><div><div id="elh_t04_pengeluaran_detail_Urutan" class="t04_pengeluaran_detail_Urutan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Urutan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_pengeluaran_detail->Urutan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_pengeluaran_detail->Urutan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_pengeluaran_detail->Nomor->Visible) { // Nomor ?>
	<?php if ($t04_pengeluaran_detail->SortUrl($t04_pengeluaran_detail->Nomor) == "") { ?>
		<th data-name="Nomor" class="<?php echo $t04_pengeluaran_detail->Nomor->HeaderCellClass() ?>"><div id="elh_t04_pengeluaran_detail_Nomor" class="t04_pengeluaran_detail_Nomor"><div class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Nomor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nomor" class="<?php echo $t04_pengeluaran_detail->Nomor->HeaderCellClass() ?>"><div><div id="elh_t04_pengeluaran_detail_Nomor" class="t04_pengeluaran_detail_Nomor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Nomor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_pengeluaran_detail->Nomor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_pengeluaran_detail->Nomor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_pengeluaran_detail->Kode->Visible) { // Kode ?>
	<?php if ($t04_pengeluaran_detail->SortUrl($t04_pengeluaran_detail->Kode) == "") { ?>
		<th data-name="Kode" class="<?php echo $t04_pengeluaran_detail->Kode->HeaderCellClass() ?>"><div id="elh_t04_pengeluaran_detail_Kode" class="t04_pengeluaran_detail_Kode"><div class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Kode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Kode" class="<?php echo $t04_pengeluaran_detail->Kode->HeaderCellClass() ?>"><div><div id="elh_t04_pengeluaran_detail_Kode" class="t04_pengeluaran_detail_Kode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Kode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_pengeluaran_detail->Kode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_pengeluaran_detail->Kode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_pengeluaran_detail->Pos->Visible) { // Pos ?>
	<?php if ($t04_pengeluaran_detail->SortUrl($t04_pengeluaran_detail->Pos) == "") { ?>
		<th data-name="Pos" class="<?php echo $t04_pengeluaran_detail->Pos->HeaderCellClass() ?>"><div id="elh_t04_pengeluaran_detail_Pos" class="t04_pengeluaran_detail_Pos"><div class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Pos->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Pos" class="<?php echo $t04_pengeluaran_detail->Pos->HeaderCellClass() ?>"><div><div id="elh_t04_pengeluaran_detail_Pos" class="t04_pengeluaran_detail_Pos">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Pos->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_pengeluaran_detail->Pos->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_pengeluaran_detail->Pos->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_pengeluaran_detail->Nominal->Visible) { // Nominal ?>
	<?php if ($t04_pengeluaran_detail->SortUrl($t04_pengeluaran_detail->Nominal) == "") { ?>
		<th data-name="Nominal" class="<?php echo $t04_pengeluaran_detail->Nominal->HeaderCellClass() ?>"><div id="elh_t04_pengeluaran_detail_Nominal" class="t04_pengeluaran_detail_Nominal"><div class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Nominal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nominal" class="<?php echo $t04_pengeluaran_detail->Nominal->HeaderCellClass() ?>"><div><div id="elh_t04_pengeluaran_detail_Nominal" class="t04_pengeluaran_detail_Nominal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Nominal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_pengeluaran_detail->Nominal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_pengeluaran_detail->Nominal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_pengeluaran_detail->Banyaknya->Visible) { // Banyaknya ?>
	<?php if ($t04_pengeluaran_detail->SortUrl($t04_pengeluaran_detail->Banyaknya) == "") { ?>
		<th data-name="Banyaknya" class="<?php echo $t04_pengeluaran_detail->Banyaknya->HeaderCellClass() ?>"><div id="elh_t04_pengeluaran_detail_Banyaknya" class="t04_pengeluaran_detail_Banyaknya"><div class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Banyaknya->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Banyaknya" class="<?php echo $t04_pengeluaran_detail->Banyaknya->HeaderCellClass() ?>"><div><div id="elh_t04_pengeluaran_detail_Banyaknya" class="t04_pengeluaran_detail_Banyaknya">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Banyaknya->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_pengeluaran_detail->Banyaknya->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_pengeluaran_detail->Banyaknya->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_pengeluaran_detail->Satuan->Visible) { // Satuan ?>
	<?php if ($t04_pengeluaran_detail->SortUrl($t04_pengeluaran_detail->Satuan) == "") { ?>
		<th data-name="Satuan" class="<?php echo $t04_pengeluaran_detail->Satuan->HeaderCellClass() ?>"><div id="elh_t04_pengeluaran_detail_Satuan" class="t04_pengeluaran_detail_Satuan"><div class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Satuan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Satuan" class="<?php echo $t04_pengeluaran_detail->Satuan->HeaderCellClass() ?>"><div><div id="elh_t04_pengeluaran_detail_Satuan" class="t04_pengeluaran_detail_Satuan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Satuan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_pengeluaran_detail->Satuan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_pengeluaran_detail->Satuan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_pengeluaran_detail->Jumlah->Visible) { // Jumlah ?>
	<?php if ($t04_pengeluaran_detail->SortUrl($t04_pengeluaran_detail->Jumlah) == "") { ?>
		<th data-name="Jumlah" class="<?php echo $t04_pengeluaran_detail->Jumlah->HeaderCellClass() ?>"><div id="elh_t04_pengeluaran_detail_Jumlah" class="t04_pengeluaran_detail_Jumlah"><div class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Jumlah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jumlah" class="<?php echo $t04_pengeluaran_detail->Jumlah->HeaderCellClass() ?>"><div><div id="elh_t04_pengeluaran_detail_Jumlah" class="t04_pengeluaran_detail_Jumlah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_pengeluaran_detail->Jumlah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_pengeluaran_detail->Jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_pengeluaran_detail->Jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t04_pengeluaran_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t04_pengeluaran_detail_grid->StartRec = 1;
$t04_pengeluaran_detail_grid->StopRec = $t04_pengeluaran_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t04_pengeluaran_detail_grid->FormKeyCountName) && ($t04_pengeluaran_detail->CurrentAction == "gridadd" || $t04_pengeluaran_detail->CurrentAction == "gridedit" || $t04_pengeluaran_detail->CurrentAction == "F")) {
		$t04_pengeluaran_detail_grid->KeyCount = $objForm->GetValue($t04_pengeluaran_detail_grid->FormKeyCountName);
		$t04_pengeluaran_detail_grid->StopRec = $t04_pengeluaran_detail_grid->StartRec + $t04_pengeluaran_detail_grid->KeyCount - 1;
	}
}
$t04_pengeluaran_detail_grid->RecCnt = $t04_pengeluaran_detail_grid->StartRec - 1;
if ($t04_pengeluaran_detail_grid->Recordset && !$t04_pengeluaran_detail_grid->Recordset->EOF) {
	$t04_pengeluaran_detail_grid->Recordset->MoveFirst();
	$bSelectLimit = $t04_pengeluaran_detail_grid->UseSelectLimit;
	if (!$bSelectLimit && $t04_pengeluaran_detail_grid->StartRec > 1)
		$t04_pengeluaran_detail_grid->Recordset->Move($t04_pengeluaran_detail_grid->StartRec - 1);
} elseif (!$t04_pengeluaran_detail->AllowAddDeleteRow && $t04_pengeluaran_detail_grid->StopRec == 0) {
	$t04_pengeluaran_detail_grid->StopRec = $t04_pengeluaran_detail->GridAddRowCount;
}

// Initialize aggregate
$t04_pengeluaran_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t04_pengeluaran_detail->ResetAttrs();
$t04_pengeluaran_detail_grid->RenderRow();
if ($t04_pengeluaran_detail->CurrentAction == "gridadd")
	$t04_pengeluaran_detail_grid->RowIndex = 0;
if ($t04_pengeluaran_detail->CurrentAction == "gridedit")
	$t04_pengeluaran_detail_grid->RowIndex = 0;
while ($t04_pengeluaran_detail_grid->RecCnt < $t04_pengeluaran_detail_grid->StopRec) {
	$t04_pengeluaran_detail_grid->RecCnt++;
	if (intval($t04_pengeluaran_detail_grid->RecCnt) >= intval($t04_pengeluaran_detail_grid->StartRec)) {
		$t04_pengeluaran_detail_grid->RowCnt++;
		if ($t04_pengeluaran_detail->CurrentAction == "gridadd" || $t04_pengeluaran_detail->CurrentAction == "gridedit" || $t04_pengeluaran_detail->CurrentAction == "F") {
			$t04_pengeluaran_detail_grid->RowIndex++;
			$objForm->Index = $t04_pengeluaran_detail_grid->RowIndex;
			if ($objForm->HasValue($t04_pengeluaran_detail_grid->FormActionName))
				$t04_pengeluaran_detail_grid->RowAction = strval($objForm->GetValue($t04_pengeluaran_detail_grid->FormActionName));
			elseif ($t04_pengeluaran_detail->CurrentAction == "gridadd")
				$t04_pengeluaran_detail_grid->RowAction = "insert";
			else
				$t04_pengeluaran_detail_grid->RowAction = "";
		}

		// Set up key count
		$t04_pengeluaran_detail_grid->KeyCount = $t04_pengeluaran_detail_grid->RowIndex;

		// Init row class and style
		$t04_pengeluaran_detail->ResetAttrs();
		$t04_pengeluaran_detail->CssClass = "";
		if ($t04_pengeluaran_detail->CurrentAction == "gridadd") {
			if ($t04_pengeluaran_detail->CurrentMode == "copy") {
				$t04_pengeluaran_detail_grid->LoadRowValues($t04_pengeluaran_detail_grid->Recordset); // Load row values
				$t04_pengeluaran_detail_grid->SetRecordKey($t04_pengeluaran_detail_grid->RowOldKey, $t04_pengeluaran_detail_grid->Recordset); // Set old record key
			} else {
				$t04_pengeluaran_detail_grid->LoadRowValues(); // Load default values
				$t04_pengeluaran_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t04_pengeluaran_detail_grid->LoadRowValues($t04_pengeluaran_detail_grid->Recordset); // Load row values
		}
		$t04_pengeluaran_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t04_pengeluaran_detail->CurrentAction == "gridadd") // Grid add
			$t04_pengeluaran_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t04_pengeluaran_detail->CurrentAction == "gridadd" && $t04_pengeluaran_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t04_pengeluaran_detail_grid->RestoreCurrentRowFormValues($t04_pengeluaran_detail_grid->RowIndex); // Restore form values
		if ($t04_pengeluaran_detail->CurrentAction == "gridedit") { // Grid edit
			if ($t04_pengeluaran_detail->EventCancelled) {
				$t04_pengeluaran_detail_grid->RestoreCurrentRowFormValues($t04_pengeluaran_detail_grid->RowIndex); // Restore form values
			}
			if ($t04_pengeluaran_detail_grid->RowAction == "insert")
				$t04_pengeluaran_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t04_pengeluaran_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t04_pengeluaran_detail->CurrentAction == "gridedit" && ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_EDIT || $t04_pengeluaran_detail->RowType == EW_ROWTYPE_ADD) && $t04_pengeluaran_detail->EventCancelled) // Update failed
			$t04_pengeluaran_detail_grid->RestoreCurrentRowFormValues($t04_pengeluaran_detail_grid->RowIndex); // Restore form values
		if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t04_pengeluaran_detail_grid->EditRowCnt++;
		if ($t04_pengeluaran_detail->CurrentAction == "F") // Confirm row
			$t04_pengeluaran_detail_grid->RestoreCurrentRowFormValues($t04_pengeluaran_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t04_pengeluaran_detail->RowAttrs = array_merge($t04_pengeluaran_detail->RowAttrs, array('data-rowindex'=>$t04_pengeluaran_detail_grid->RowCnt, 'id'=>'r' . $t04_pengeluaran_detail_grid->RowCnt . '_t04_pengeluaran_detail', 'data-rowtype'=>$t04_pengeluaran_detail->RowType));

		// Render row
		$t04_pengeluaran_detail_grid->RenderRow();

		// Render list options
		$t04_pengeluaran_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t04_pengeluaran_detail_grid->RowAction <> "delete" && $t04_pengeluaran_detail_grid->RowAction <> "insertdelete" && !($t04_pengeluaran_detail_grid->RowAction == "insert" && $t04_pengeluaran_detail->CurrentAction == "F" && $t04_pengeluaran_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $t04_pengeluaran_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t04_pengeluaran_detail_grid->ListOptions->Render("body", "left", $t04_pengeluaran_detail_grid->RowCnt);
?>
	<?php if ($t04_pengeluaran_detail->Urutan->Visible) { // Urutan ?>
		<td data-name="Urutan"<?php echo $t04_pengeluaran_detail->Urutan->CellAttributes() ?>>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Urutan" class="form-group t04_pengeluaran_detail_Urutan">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Urutan" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Urutan->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Urutan->EditValue ?>"<?php echo $t04_pengeluaran_detail->Urutan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Urutan" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Urutan->OldValue) ?>">
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Urutan" class="form-group t04_pengeluaran_detail_Urutan">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Urutan" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Urutan->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Urutan->EditValue ?>"<?php echo $t04_pengeluaran_detail->Urutan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Urutan" class="t04_pengeluaran_detail_Urutan">
<span<?php echo $t04_pengeluaran_detail->Urutan->ViewAttributes() ?>>
<?php echo $t04_pengeluaran_detail->Urutan->ListViewValue() ?></span>
</span>
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Urutan" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Urutan->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Urutan" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Urutan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Urutan" name="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" id="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Urutan->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Urutan" name="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" id="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Urutan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_id" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_id" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->id->CurrentValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_id" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_id" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->id->OldValue) ?>">
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_EDIT || $t04_pengeluaran_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_id" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_id" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t04_pengeluaran_detail->Nomor->Visible) { // Nomor ?>
		<td data-name="Nomor"<?php echo $t04_pengeluaran_detail->Nomor->CellAttributes() ?>>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Nomor" class="form-group t04_pengeluaran_detail_Nomor">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Nomor" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" size="1" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nomor->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Nomor->EditValue ?>"<?php echo $t04_pengeluaran_detail->Nomor->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Nomor" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nomor->OldValue) ?>">
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Nomor" class="form-group t04_pengeluaran_detail_Nomor">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Nomor" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" size="1" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nomor->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Nomor->EditValue ?>"<?php echo $t04_pengeluaran_detail->Nomor->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Nomor" class="t04_pengeluaran_detail_Nomor">
<span<?php echo $t04_pengeluaran_detail->Nomor->ViewAttributes() ?>>
<?php echo $t04_pengeluaran_detail->Nomor->ListViewValue() ?></span>
</span>
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Nomor" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nomor->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Nomor" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nomor->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Nomor" name="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" id="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nomor->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Nomor" name="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" id="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nomor->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t04_pengeluaran_detail->Kode->Visible) { // Kode ?>
		<td data-name="Kode"<?php echo $t04_pengeluaran_detail->Kode->CellAttributes() ?>>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t04_pengeluaran_detail->Kode->getSessionValue() <> "") { ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Kode" class="form-group t04_pengeluaran_detail_Kode">
<span<?php echo $t04_pengeluaran_detail->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_pengeluaran_detail->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Kode->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Kode" class="form-group t04_pengeluaran_detail_Kode">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Kode" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" size="5" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Kode->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Kode->EditValue ?>"<?php echo $t04_pengeluaran_detail->Kode->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Kode" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Kode->OldValue) ?>">
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t04_pengeluaran_detail->Kode->getSessionValue() <> "") { ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Kode" class="form-group t04_pengeluaran_detail_Kode">
<span<?php echo $t04_pengeluaran_detail->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_pengeluaran_detail->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Kode->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Kode" class="form-group t04_pengeluaran_detail_Kode">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Kode" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" size="5" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Kode->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Kode->EditValue ?>"<?php echo $t04_pengeluaran_detail->Kode->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Kode" class="t04_pengeluaran_detail_Kode">
<span<?php echo $t04_pengeluaran_detail->Kode->ViewAttributes() ?>>
<?php echo $t04_pengeluaran_detail->Kode->ListViewValue() ?></span>
</span>
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Kode" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Kode->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Kode" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Kode->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Kode" name="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" id="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Kode->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Kode" name="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" id="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Kode->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t04_pengeluaran_detail->Pos->Visible) { // Pos ?>
		<td data-name="Pos"<?php echo $t04_pengeluaran_detail->Pos->CellAttributes() ?>>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Pos" class="form-group t04_pengeluaran_detail_Pos">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Pos" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Pos->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Pos->EditValue ?>"<?php echo $t04_pengeluaran_detail->Pos->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Pos" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Pos->OldValue) ?>">
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Pos" class="form-group t04_pengeluaran_detail_Pos">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Pos" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Pos->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Pos->EditValue ?>"<?php echo $t04_pengeluaran_detail->Pos->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Pos" class="t04_pengeluaran_detail_Pos">
<span<?php echo $t04_pengeluaran_detail->Pos->ViewAttributes() ?>>
<?php echo $t04_pengeluaran_detail->Pos->ListViewValue() ?></span>
</span>
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Pos" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Pos->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Pos" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Pos->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Pos" name="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" id="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Pos->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Pos" name="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" id="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Pos->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t04_pengeluaran_detail->Nominal->Visible) { // Nominal ?>
		<td data-name="Nominal"<?php echo $t04_pengeluaran_detail->Nominal->CellAttributes() ?>>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Nominal" class="form-group t04_pengeluaran_detail_Nominal">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Nominal" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" size="5" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nominal->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Nominal->EditValue ?>"<?php echo $t04_pengeluaran_detail->Nominal->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Nominal" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nominal->OldValue) ?>">
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Nominal" class="form-group t04_pengeluaran_detail_Nominal">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Nominal" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" size="5" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nominal->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Nominal->EditValue ?>"<?php echo $t04_pengeluaran_detail->Nominal->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Nominal" class="t04_pengeluaran_detail_Nominal">
<span<?php echo $t04_pengeluaran_detail->Nominal->ViewAttributes() ?>>
<?php echo $t04_pengeluaran_detail->Nominal->ListViewValue() ?></span>
</span>
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Nominal" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nominal->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Nominal" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nominal->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Nominal" name="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" id="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nominal->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Nominal" name="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" id="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nominal->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t04_pengeluaran_detail->Banyaknya->Visible) { // Banyaknya ?>
		<td data-name="Banyaknya"<?php echo $t04_pengeluaran_detail->Banyaknya->CellAttributes() ?>>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Banyaknya" class="form-group t04_pengeluaran_detail_Banyaknya">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Banyaknya" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" size="1" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Banyaknya->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Banyaknya->EditValue ?>"<?php echo $t04_pengeluaran_detail->Banyaknya->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Banyaknya" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Banyaknya->OldValue) ?>">
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Banyaknya" class="form-group t04_pengeluaran_detail_Banyaknya">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Banyaknya" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" size="1" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Banyaknya->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Banyaknya->EditValue ?>"<?php echo $t04_pengeluaran_detail->Banyaknya->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Banyaknya" class="t04_pengeluaran_detail_Banyaknya">
<span<?php echo $t04_pengeluaran_detail->Banyaknya->ViewAttributes() ?>>
<?php echo $t04_pengeluaran_detail->Banyaknya->ListViewValue() ?></span>
</span>
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Banyaknya" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Banyaknya->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Banyaknya" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Banyaknya->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Banyaknya" name="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" id="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Banyaknya->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Banyaknya" name="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" id="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Banyaknya->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t04_pengeluaran_detail->Satuan->Visible) { // Satuan ?>
		<td data-name="Satuan"<?php echo $t04_pengeluaran_detail->Satuan->CellAttributes() ?>>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Satuan" class="form-group t04_pengeluaran_detail_Satuan">
<?php
$wrkonchange = trim(" " . @$t04_pengeluaran_detail->Satuan->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t04_pengeluaran_detail->Satuan->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" style="white-space: nowrap; z-index: <?php echo (9000 - $t04_pengeluaran_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" id="sv_x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" value="<?php echo $t04_pengeluaran_detail->Satuan->EditValue ?>" size="1" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->getPlaceHolder()) ?>"<?php echo $t04_pengeluaran_detail->Satuan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Satuan" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t04_pengeluaran_detail->Satuan->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft04_pengeluaran_detailgrid.CreateAutoSuggest({"id":"x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t04_pengeluaran_detail->Satuan->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t04_pengeluaran_detail->Satuan->ReadOnly || $t04_pengeluaran_detail->Satuan->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $t04_pengeluaran_detail->Satuan->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan',url:'t05_satuanaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $t04_pengeluaran_detail->Satuan->FldCaption() ?></span></button>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Satuan" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->OldValue) ?>">
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Satuan" class="form-group t04_pengeluaran_detail_Satuan">
<?php
$wrkonchange = trim(" " . @$t04_pengeluaran_detail->Satuan->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t04_pengeluaran_detail->Satuan->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" style="white-space: nowrap; z-index: <?php echo (9000 - $t04_pengeluaran_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" id="sv_x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" value="<?php echo $t04_pengeluaran_detail->Satuan->EditValue ?>" size="1" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->getPlaceHolder()) ?>"<?php echo $t04_pengeluaran_detail->Satuan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Satuan" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t04_pengeluaran_detail->Satuan->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft04_pengeluaran_detailgrid.CreateAutoSuggest({"id":"x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t04_pengeluaran_detail->Satuan->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t04_pengeluaran_detail->Satuan->ReadOnly || $t04_pengeluaran_detail->Satuan->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $t04_pengeluaran_detail->Satuan->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan',url:'t05_satuanaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $t04_pengeluaran_detail->Satuan->FldCaption() ?></span></button>
</span>
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Satuan" class="t04_pengeluaran_detail_Satuan">
<span<?php echo $t04_pengeluaran_detail->Satuan->ViewAttributes() ?>>
<?php echo $t04_pengeluaran_detail->Satuan->ListViewValue() ?></span>
</span>
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Satuan" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Satuan" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Satuan" name="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" id="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Satuan" name="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" id="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t04_pengeluaran_detail->Jumlah->Visible) { // Jumlah ?>
		<td data-name="Jumlah"<?php echo $t04_pengeluaran_detail->Jumlah->CellAttributes() ?>>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Jumlah" class="form-group t04_pengeluaran_detail_Jumlah">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Jumlah" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" size="5" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Jumlah->EditValue ?>"<?php echo $t04_pengeluaran_detail->Jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Jumlah" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Jumlah->OldValue) ?>">
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Jumlah" class="form-group t04_pengeluaran_detail_Jumlah">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Jumlah" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" size="5" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Jumlah->EditValue ?>"<?php echo $t04_pengeluaran_detail->Jumlah->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_pengeluaran_detail_grid->RowCnt ?>_t04_pengeluaran_detail_Jumlah" class="t04_pengeluaran_detail_Jumlah">
<span<?php echo $t04_pengeluaran_detail->Jumlah->ViewAttributes() ?>>
<?php echo $t04_pengeluaran_detail->Jumlah->ListViewValue() ?></span>
</span>
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Jumlah" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Jumlah->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Jumlah" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Jumlah->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Jumlah" name="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" id="ft04_pengeluaran_detailgrid$x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Jumlah->FormValue) ?>">
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Jumlah" name="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" id="ft04_pengeluaran_detailgrid$o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Jumlah->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t04_pengeluaran_detail_grid->ListOptions->Render("body", "right", $t04_pengeluaran_detail_grid->RowCnt);
?>
	</tr>
<?php if ($t04_pengeluaran_detail->RowType == EW_ROWTYPE_ADD || $t04_pengeluaran_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft04_pengeluaran_detailgrid.UpdateOpts(<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t04_pengeluaran_detail->CurrentAction <> "gridadd" || $t04_pengeluaran_detail->CurrentMode == "copy")
		if (!$t04_pengeluaran_detail_grid->Recordset->EOF) $t04_pengeluaran_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t04_pengeluaran_detail->CurrentMode == "add" || $t04_pengeluaran_detail->CurrentMode == "copy" || $t04_pengeluaran_detail->CurrentMode == "edit") {
		$t04_pengeluaran_detail_grid->RowIndex = '$rowindex$';
		$t04_pengeluaran_detail_grid->LoadRowValues();

		// Set row properties
		$t04_pengeluaran_detail->ResetAttrs();
		$t04_pengeluaran_detail->RowAttrs = array_merge($t04_pengeluaran_detail->RowAttrs, array('data-rowindex'=>$t04_pengeluaran_detail_grid->RowIndex, 'id'=>'r0_t04_pengeluaran_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t04_pengeluaran_detail->RowAttrs["class"], "ewTemplate");
		$t04_pengeluaran_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t04_pengeluaran_detail_grid->RenderRow();

		// Render list options
		$t04_pengeluaran_detail_grid->RenderListOptions();
		$t04_pengeluaran_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t04_pengeluaran_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t04_pengeluaran_detail_grid->ListOptions->Render("body", "left", $t04_pengeluaran_detail_grid->RowIndex);
?>
	<?php if ($t04_pengeluaran_detail->Urutan->Visible) { // Urutan ?>
		<td data-name="Urutan">
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Urutan" class="form-group t04_pengeluaran_detail_Urutan">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Urutan" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Urutan->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Urutan->EditValue ?>"<?php echo $t04_pengeluaran_detail->Urutan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Urutan" class="form-group t04_pengeluaran_detail_Urutan">
<span<?php echo $t04_pengeluaran_detail->Urutan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_pengeluaran_detail->Urutan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Urutan" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Urutan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Urutan" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Urutan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t04_pengeluaran_detail->Nomor->Visible) { // Nomor ?>
		<td data-name="Nomor">
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Nomor" class="form-group t04_pengeluaran_detail_Nomor">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Nomor" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" size="1" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nomor->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Nomor->EditValue ?>"<?php echo $t04_pengeluaran_detail->Nomor->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Nomor" class="form-group t04_pengeluaran_detail_Nomor">
<span<?php echo $t04_pengeluaran_detail->Nomor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_pengeluaran_detail->Nomor->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Nomor" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nomor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Nomor" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nomor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t04_pengeluaran_detail->Kode->Visible) { // Kode ?>
		<td data-name="Kode">
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<?php if ($t04_pengeluaran_detail->Kode->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Kode" class="form-group t04_pengeluaran_detail_Kode">
<span<?php echo $t04_pengeluaran_detail->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_pengeluaran_detail->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Kode->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Kode" class="form-group t04_pengeluaran_detail_Kode">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Kode" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" size="5" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Kode->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Kode->EditValue ?>"<?php echo $t04_pengeluaran_detail->Kode->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Kode" class="form-group t04_pengeluaran_detail_Kode">
<span<?php echo $t04_pengeluaran_detail->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_pengeluaran_detail->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Kode" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Kode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Kode" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Kode->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t04_pengeluaran_detail->Pos->Visible) { // Pos ?>
		<td data-name="Pos">
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Pos" class="form-group t04_pengeluaran_detail_Pos">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Pos" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Pos->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Pos->EditValue ?>"<?php echo $t04_pengeluaran_detail->Pos->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Pos" class="form-group t04_pengeluaran_detail_Pos">
<span<?php echo $t04_pengeluaran_detail->Pos->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_pengeluaran_detail->Pos->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Pos" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Pos->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Pos" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Pos->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t04_pengeluaran_detail->Nominal->Visible) { // Nominal ?>
		<td data-name="Nominal">
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Nominal" class="form-group t04_pengeluaran_detail_Nominal">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Nominal" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" size="5" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nominal->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Nominal->EditValue ?>"<?php echo $t04_pengeluaran_detail->Nominal->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Nominal" class="form-group t04_pengeluaran_detail_Nominal">
<span<?php echo $t04_pengeluaran_detail->Nominal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_pengeluaran_detail->Nominal->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Nominal" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nominal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Nominal" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Nominal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t04_pengeluaran_detail->Banyaknya->Visible) { // Banyaknya ?>
		<td data-name="Banyaknya">
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Banyaknya" class="form-group t04_pengeluaran_detail_Banyaknya">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Banyaknya" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" size="1" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Banyaknya->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Banyaknya->EditValue ?>"<?php echo $t04_pengeluaran_detail->Banyaknya->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Banyaknya" class="form-group t04_pengeluaran_detail_Banyaknya">
<span<?php echo $t04_pengeluaran_detail->Banyaknya->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_pengeluaran_detail->Banyaknya->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Banyaknya" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Banyaknya->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Banyaknya" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Banyaknya->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t04_pengeluaran_detail->Satuan->Visible) { // Satuan ?>
		<td data-name="Satuan">
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Satuan" class="form-group t04_pengeluaran_detail_Satuan">
<?php
$wrkonchange = trim(" " . @$t04_pengeluaran_detail->Satuan->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t04_pengeluaran_detail->Satuan->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" style="white-space: nowrap; z-index: <?php echo (9000 - $t04_pengeluaran_detail_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" id="sv_x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" value="<?php echo $t04_pengeluaran_detail->Satuan->EditValue ?>" size="1" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->getPlaceHolder()) ?>"<?php echo $t04_pengeluaran_detail->Satuan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Satuan" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t04_pengeluaran_detail->Satuan->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft04_pengeluaran_detailgrid.CreateAutoSuggest({"id":"x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t04_pengeluaran_detail->Satuan->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t04_pengeluaran_detail->Satuan->ReadOnly || $t04_pengeluaran_detail->Satuan->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $t04_pengeluaran_detail->Satuan->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan',url:'t05_satuanaddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $t04_pengeluaran_detail->Satuan->FldCaption() ?></span></button>
</span>
<?php } else { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Satuan" class="form-group t04_pengeluaran_detail_Satuan">
<span<?php echo $t04_pengeluaran_detail->Satuan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_pengeluaran_detail->Satuan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Satuan" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Satuan" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Satuan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t04_pengeluaran_detail->Jumlah->Visible) { // Jumlah ?>
		<td data-name="Jumlah">
<?php if ($t04_pengeluaran_detail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Jumlah" class="form-group t04_pengeluaran_detail_Jumlah">
<input type="text" data-table="t04_pengeluaran_detail" data-field="x_Jumlah" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" size="5" placeholder="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t04_pengeluaran_detail->Jumlah->EditValue ?>"<?php echo $t04_pengeluaran_detail->Jumlah->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t04_pengeluaran_detail_Jumlah" class="form-group t04_pengeluaran_detail_Jumlah">
<span<?php echo $t04_pengeluaran_detail->Jumlah->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_pengeluaran_detail->Jumlah->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Jumlah" name="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" id="x<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Jumlah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_pengeluaran_detail" data-field="x_Jumlah" name="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" id="o<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t04_pengeluaran_detail->Jumlah->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t04_pengeluaran_detail_grid->ListOptions->Render("body", "right", $t04_pengeluaran_detail_grid->RowIndex);
?>
<script type="text/javascript">
ft04_pengeluaran_detailgrid.UpdateOpts(<?php echo $t04_pengeluaran_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t04_pengeluaran_detail->CurrentMode == "add" || $t04_pengeluaran_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t04_pengeluaran_detail_grid->FormKeyCountName ?>" id="<?php echo $t04_pengeluaran_detail_grid->FormKeyCountName ?>" value="<?php echo $t04_pengeluaran_detail_grid->KeyCount ?>">
<?php echo $t04_pengeluaran_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t04_pengeluaran_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t04_pengeluaran_detail_grid->FormKeyCountName ?>" id="<?php echo $t04_pengeluaran_detail_grid->FormKeyCountName ?>" value="<?php echo $t04_pengeluaran_detail_grid->KeyCount ?>">
<?php echo $t04_pengeluaran_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t04_pengeluaran_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft04_pengeluaran_detailgrid">
</div>
<?php

// Close recordset
if ($t04_pengeluaran_detail_grid->Recordset)
	$t04_pengeluaran_detail_grid->Recordset->Close();
?>
<?php if ($t04_pengeluaran_detail_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($t04_pengeluaran_detail_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t04_pengeluaran_detail_grid->TotalRecs == 0 && $t04_pengeluaran_detail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t04_pengeluaran_detail_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t04_pengeluaran_detail->Export == "") { ?>
<script type="text/javascript">
ft04_pengeluaran_detailgrid.Init();
</script>
<?php } ?>
<?php
$t04_pengeluaran_detail_grid->Page_Terminate();
?>
