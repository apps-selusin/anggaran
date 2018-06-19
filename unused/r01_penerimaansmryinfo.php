<?php

// Global variable for table object
$r01_penerimaan = NULL;

//
// Table class for r01_penerimaan
//
class crr01_penerimaan extends crTableBase {
	var $ShowGroupHeaderAsRow = FALSE;
	var $ShowCompactSummaryFooter = TRUE;
	var $id;
	var $Departemen;
	var $HeadDetail;
	var $NomorHead;
	var $SubTotalFlag;
	var $Urutan;
	var $Nomor;
	var $Pos;
	var $Nominal;
	var $JumlahSiswa;
	var $Bulan;
	var $Jumlah;
	var $Total;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $grLanguage;
		$this->TableVar = 'r01_penerimaan';
		$this->TableName = 'r01_penerimaan';
		$this->TableType = 'REPORT';
		$this->TableReportType = 'summary';
		$this->SourcTableIsCustomView = FALSE;
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// id
		$this->id = new crField('r01_penerimaan', 'r01_penerimaan', 'x_id', 'id', '`id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->id->DateFilter = "";
		$this->id->SqlSelect = "";
		$this->id->SqlOrderBy = "";
		$this->fields['id'] = &$this->id;

		// Departemen
		$this->Departemen = new crField('r01_penerimaan', 'r01_penerimaan', 'x_Departemen', 'Departemen', '`Departemen`', 200, EWR_DATATYPE_STRING, -1);
		$this->Departemen->Sortable = TRUE; // Allow sort
		$this->Departemen->DateFilter = "";
		$this->Departemen->SqlSelect = "";
		$this->Departemen->SqlOrderBy = "";
		$this->fields['Departemen'] = &$this->Departemen;

		// HeadDetail
		$this->HeadDetail = new crField('r01_penerimaan', 'r01_penerimaan', 'x_HeadDetail', 'HeadDetail', '`HeadDetail`', 200, EWR_DATATYPE_STRING, -1);
		$this->HeadDetail->Sortable = TRUE; // Allow sort
		$this->HeadDetail->DateFilter = "";
		$this->HeadDetail->SqlSelect = "";
		$this->HeadDetail->SqlOrderBy = "";
		$this->fields['HeadDetail'] = &$this->HeadDetail;

		// NomorHead
		$this->NomorHead = new crField('r01_penerimaan', 'r01_penerimaan', 'x_NomorHead', 'NomorHead', '`NomorHead`', 16, EWR_DATATYPE_NUMBER, -1);
		$this->NomorHead->Sortable = TRUE; // Allow sort
		$this->NomorHead->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->NomorHead->DateFilter = "";
		$this->NomorHead->SqlSelect = "";
		$this->NomorHead->SqlOrderBy = "";
		$this->fields['NomorHead'] = &$this->NomorHead;

		// SubTotalFlag
		$this->SubTotalFlag = new crField('r01_penerimaan', 'r01_penerimaan', 'x_SubTotalFlag', 'SubTotalFlag', '`SubTotalFlag`', 200, EWR_DATATYPE_STRING, -1);
		$this->SubTotalFlag->Sortable = TRUE; // Allow sort
		$this->SubTotalFlag->DateFilter = "";
		$this->SubTotalFlag->SqlSelect = "";
		$this->SubTotalFlag->SqlOrderBy = "";
		$this->fields['SubTotalFlag'] = &$this->SubTotalFlag;

		// Urutan
		$this->Urutan = new crField('r01_penerimaan', 'r01_penerimaan', 'x_Urutan', 'Urutan', '`Urutan`', 16, EWR_DATATYPE_NUMBER, -1);
		$this->Urutan->Sortable = TRUE; // Allow sort
		$this->Urutan->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->Urutan->DateFilter = "";
		$this->Urutan->SqlSelect = "";
		$this->Urutan->SqlOrderBy = "";
		$this->fields['Urutan'] = &$this->Urutan;

		// Nomor
		$this->Nomor = new crField('r01_penerimaan', 'r01_penerimaan', 'x_Nomor', 'Nomor', '`Nomor`', 200, EWR_DATATYPE_STRING, -1);
		$this->Nomor->Sortable = TRUE; // Allow sort
		$this->Nomor->DateFilter = "";
		$this->Nomor->SqlSelect = "";
		$this->Nomor->SqlOrderBy = "";
		$this->fields['Nomor'] = &$this->Nomor;

		// Pos
		$this->Pos = new crField('r01_penerimaan', 'r01_penerimaan', 'x_Pos', 'Pos', '`Pos`', 200, EWR_DATATYPE_STRING, -1);
		$this->Pos->Sortable = TRUE; // Allow sort
		$this->Pos->DateFilter = "";
		$this->Pos->SqlSelect = "";
		$this->Pos->SqlOrderBy = "";
		$this->fields['Pos'] = &$this->Pos;

		// Nominal
		$this->Nominal = new crField('r01_penerimaan', 'r01_penerimaan', 'x_Nominal', 'Nominal', '`Nominal`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->Nominal->Sortable = TRUE; // Allow sort
		$this->Nominal->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->Nominal->DateFilter = "";
		$this->Nominal->SqlSelect = "";
		$this->Nominal->SqlOrderBy = "";
		$this->fields['Nominal'] = &$this->Nominal;

		// JumlahSiswa
		$this->JumlahSiswa = new crField('r01_penerimaan', 'r01_penerimaan', 'x_JumlahSiswa', 'JumlahSiswa', '`JumlahSiswa`', 2, EWR_DATATYPE_NUMBER, -1);
		$this->JumlahSiswa->Sortable = TRUE; // Allow sort
		$this->JumlahSiswa->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->JumlahSiswa->DateFilter = "";
		$this->JumlahSiswa->SqlSelect = "";
		$this->JumlahSiswa->SqlOrderBy = "";
		$this->fields['JumlahSiswa'] = &$this->JumlahSiswa;

		// Bulan
		$this->Bulan = new crField('r01_penerimaan', 'r01_penerimaan', 'x_Bulan', 'Bulan', '`Bulan`', 16, EWR_DATATYPE_NUMBER, -1);
		$this->Bulan->Sortable = TRUE; // Allow sort
		$this->Bulan->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->Bulan->DateFilter = "";
		$this->Bulan->SqlSelect = "";
		$this->Bulan->SqlOrderBy = "";
		$this->fields['Bulan'] = &$this->Bulan;

		// Jumlah
		$this->Jumlah = new crField('r01_penerimaan', 'r01_penerimaan', 'x_Jumlah', 'Jumlah', '`Jumlah`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->Jumlah->Sortable = TRUE; // Allow sort
		$this->Jumlah->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->Jumlah->DateFilter = "";
		$this->Jumlah->SqlSelect = "";
		$this->Jumlah->SqlOrderBy = "";
		$this->fields['Jumlah'] = &$this->Jumlah;

		// Total
		$this->Total = new crField('r01_penerimaan', 'r01_penerimaan', 'x_Total', 'Total', '`Total`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->Total->Sortable = TRUE; // Allow sort
		$this->Total->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->Total->DateFilter = "";
		$this->Total->SqlSelect = "";
		$this->Total->SqlOrderBy = "";
		$this->fields['Total'] = &$this->Total;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ofld->GroupingFieldId == 0)
				$this->setDetailOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			if ($ofld->GroupingFieldId == 0) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				$fldsql = $fld->FldExpression;
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	// From

	var $_SqlFrom = "";

	function getSqlFrom() {
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t01_penerimaan`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}

	// Select
	var $_SqlSelect = "";

	function getSqlSelect() {
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}

	// Where
	var $_SqlWhere = "";

	function getSqlWhere() {
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}

	// Group By
	var $_SqlGroupBy = "";

	function getSqlGroupBy() {
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}

	// Having
	var $_SqlHaving = "";

	function getSqlHaving() {
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}

	// Order By
	var $_SqlOrderBy = "";

	function getSqlOrderBy() {
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Table Level Group SQL
	// First Group Field

	var $_SqlFirstGroupField = "";

	function getSqlFirstGroupField() {
		return ($this->_SqlFirstGroupField <> "") ? $this->_SqlFirstGroupField : "";
	}

	function SqlFirstGroupField() { // For backward compatibility
		return $this->getSqlFirstGroupField();
	}

	function setSqlFirstGroupField($v) {
		$this->_SqlFirstGroupField = $v;
	}

	// Select Group
	var $_SqlSelectGroup = "";

	function getSqlSelectGroup() {
		return ($this->_SqlSelectGroup <> "") ? $this->_SqlSelectGroup : "SELECT DISTINCT " . $this->getSqlFirstGroupField() . " FROM " . $this->getSqlFrom();
	}

	function SqlSelectGroup() { // For backward compatibility
		return $this->getSqlSelectGroup();
	}

	function setSqlSelectGroup($v) {
		$this->_SqlSelectGroup = $v;
	}

	// Order By Group
	var $_SqlOrderByGroup = "";

	function getSqlOrderByGroup() {
		return ($this->_SqlOrderByGroup <> "") ? $this->_SqlOrderByGroup : "";
	}

	function SqlOrderByGroup() { // For backward compatibility
		return $this->getSqlOrderByGroup();
	}

	function setSqlOrderByGroup($v) {
		$this->_SqlOrderByGroup = $v;
	}

	// Select Aggregate
	var $_SqlSelectAgg = "";

	function getSqlSelectAgg() {
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelectAgg() { // For backward compatibility
		return $this->getSqlSelectAgg();
	}

	function setSqlSelectAgg($v) {
		$this->_SqlSelectAgg = $v;
	}

	// Aggregate Prefix
	var $_SqlAggPfx = "";

	function getSqlAggPfx() {
		return ($this->_SqlAggPfx <> "") ? $this->_SqlAggPfx : "";
	}

	function SqlAggPfx() { // For backward compatibility
		return $this->getSqlAggPfx();
	}

	function setSqlAggPfx($v) {
		$this->_SqlAggPfx = $v;
	}

	// Aggregate Suffix
	var $_SqlAggSfx = "";

	function getSqlAggSfx() {
		return ($this->_SqlAggSfx <> "") ? $this->_SqlAggSfx : "";
	}

	function SqlAggSfx() { // For backward compatibility
		return $this->getSqlAggSfx();
	}

	function setSqlAggSfx($v) {
		$this->_SqlAggSfx = $v;
	}

	// Select Count
	var $_SqlSelectCount = "";

	function getSqlSelectCount() {
		return ($this->_SqlSelectCount <> "") ? $this->_SqlSelectCount : "SELECT COUNT(*) FROM " . $this->getSqlFrom();
	}

	function SqlSelectCount() { // For backward compatibility
		return $this->getSqlSelectCount();
	}

	function setSqlSelectCount($v) {
		$this->_SqlSelectCount = $v;
	}

	// Sort URL
	function SortUrl(&$fld) {
		global $grDashboardReport;
		return "";
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld) {
		global $grLanguage;
		switch ($fld->FldVar) {
		case "x_Departemen":
			$fld->LookupFilters = array("d" => "DB", "f0" => '`Departemen` = {filter_value}', "t0" => "200", "fn0" => "", "dlm" => ewr_Encrypt($fld->FldDelimiter), "af" => json_encode($fld->AdvancedFilters));
		$sWhereWrk = "";
		$fld->LookupFilters += array(
			"select" => "SELECT DISTINCT `Departemen`, `Departemen` AS `DispFld`, '' AS `DispFld2`, '' AS `DispFld3`, '' AS `DispFld4` FROM `t01_penerimaan`",
			"where" => $sWhereWrk,
			"orderby" => "`Departemen` ASC"
		);
		$this->Lookup_Selecting($fld, $fld->LookupFilters["where"]); // Call Lookup selecting
		$fld->LookupFilters["s"] = ewr_BuildReportSql($fld->LookupFilters["select"], $fld->LookupFilters["where"], "", "", $fld->LookupFilters["orderby"], "", "");
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld) {
		global $grLanguage;
		switch ($fld->FldVar) {
		}
	}

	// Table level events
	// Page Selecting event
	function Page_Selecting(&$filter) {

		// Enter your code here
	}

	// Page Breaking event
	function Page_Breaking(&$break, &$content) {

		// Example:
		//$break = FALSE; // Skip page break, or
		//$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs) {

		//$ViewValue = "xxx";
		//$ViewAttrs["style"] = "xxx";

	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}

	// Load Filters event
	function Page_FilterLoad() {

		// Enter your code here
		// Example: Register/Unregister Custom Extended Filter
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
		//ewr_UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//$this->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Page Filtering event
	function Page_Filtering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "") {

		// Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
		//if ($typ == "dropdown" && $fld->FldName == "MyField") // Dropdown filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "extended" && $fld->FldName == "MyField") // Extended filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "popup" && $fld->FldName == "MyField") // Popup filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "custom" && $opr == "..." && $fld->FldName == "MyField") // Custom filter, $opr is the custom filter ID
		//	$filter = "..."; // Modify the filter

	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}
}
?>
