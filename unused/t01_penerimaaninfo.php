<?php

// Global variable for table object
$t01_penerimaan = NULL;

//
// Table class for t01_penerimaan
//
class ct01_penerimaan extends cTable {
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
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't01_penerimaan';
		$this->TableName = 't01_penerimaan';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t01_penerimaan`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('t01_penerimaan', 't01_penerimaan', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// Departemen
		$this->Departemen = new cField('t01_penerimaan', 't01_penerimaan', 'x_Departemen', 'Departemen', '`Departemen`', '`Departemen`', 200, -1, FALSE, '`Departemen`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Departemen->Sortable = TRUE; // Allow sort
		$this->Departemen->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Departemen->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Departemen'] = &$this->Departemen;

		// HeadDetail
		$this->HeadDetail = new cField('t01_penerimaan', 't01_penerimaan', 'x_HeadDetail', 'HeadDetail', '`HeadDetail`', '`HeadDetail`', 200, -1, FALSE, '`HeadDetail`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->HeadDetail->Sortable = TRUE; // Allow sort
		$this->fields['HeadDetail'] = &$this->HeadDetail;

		// NomorHead
		$this->NomorHead = new cField('t01_penerimaan', 't01_penerimaan', 'x_NomorHead', 'NomorHead', '`NomorHead`', '`NomorHead`', 16, -1, FALSE, '`NomorHead`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NomorHead->Sortable = TRUE; // Allow sort
		$this->NomorHead->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['NomorHead'] = &$this->NomorHead;

		// SubTotalFlag
		$this->SubTotalFlag = new cField('t01_penerimaan', 't01_penerimaan', 'x_SubTotalFlag', 'SubTotalFlag', '`SubTotalFlag`', '`SubTotalFlag`', 200, -1, FALSE, '`SubTotalFlag`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SubTotalFlag->Sortable = TRUE; // Allow sort
		$this->fields['SubTotalFlag'] = &$this->SubTotalFlag;

		// Urutan
		$this->Urutan = new cField('t01_penerimaan', 't01_penerimaan', 'x_Urutan', 'Urutan', '`Urutan`', '`Urutan`', 16, -1, FALSE, '`Urutan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Urutan->Sortable = TRUE; // Allow sort
		$this->Urutan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Urutan'] = &$this->Urutan;

		// Nomor
		$this->Nomor = new cField('t01_penerimaan', 't01_penerimaan', 'x_Nomor', 'Nomor', '`Nomor`', '`Nomor`', 200, -1, FALSE, '`Nomor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nomor->Sortable = TRUE; // Allow sort
		$this->fields['Nomor'] = &$this->Nomor;

		// Pos
		$this->Pos = new cField('t01_penerimaan', 't01_penerimaan', 'x_Pos', 'Pos', '`Pos`', '`Pos`', 200, -1, FALSE, '`Pos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Pos->Sortable = TRUE; // Allow sort
		$this->fields['Pos'] = &$this->Pos;

		// Nominal
		$this->Nominal = new cField('t01_penerimaan', 't01_penerimaan', 'x_Nominal', 'Nominal', '`Nominal`', '`Nominal`', 4, -1, FALSE, '`Nominal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nominal->Sortable = TRUE; // Allow sort
		$this->Nominal->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Nominal'] = &$this->Nominal;

		// JumlahSiswa
		$this->JumlahSiswa = new cField('t01_penerimaan', 't01_penerimaan', 'x_JumlahSiswa', 'JumlahSiswa', '`JumlahSiswa`', '`JumlahSiswa`', 2, -1, FALSE, '`JumlahSiswa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JumlahSiswa->Sortable = TRUE; // Allow sort
		$this->JumlahSiswa->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['JumlahSiswa'] = &$this->JumlahSiswa;

		// Bulan
		$this->Bulan = new cField('t01_penerimaan', 't01_penerimaan', 'x_Bulan', 'Bulan', '`Bulan`', '`Bulan`', 16, -1, FALSE, '`Bulan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Bulan->Sortable = TRUE; // Allow sort
		$this->Bulan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Bulan'] = &$this->Bulan;

		// Jumlah
		$this->Jumlah = new cField('t01_penerimaan', 't01_penerimaan', 'x_Jumlah', 'Jumlah', '`Jumlah`', '`Jumlah`', 4, -1, FALSE, '`Jumlah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Jumlah->Sortable = TRUE; // Allow sort
		$this->Jumlah->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Jumlah'] = &$this->Jumlah;

		// Total
		$this->Total = new cField('t01_penerimaan', 't01_penerimaan', 'x_Total', 'Total', '`Total`', '`Total`', 4, -1, FALSE, '`Total`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Total->Sortable = TRUE; // Allow sort
		$this->Total->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Total'] = &$this->Total;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t01_penerimaan`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`Urutan` ASC";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->id->setDbValue($conn->Insert_ID());
			$rs['id'] = $this->id->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "t01_penerimaanlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "t01_penerimaanview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "t01_penerimaanedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "t01_penerimaanadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "t01_penerimaanlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t01_penerimaanview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t01_penerimaanview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t01_penerimaanadd.php?" . $this->UrlParm($parm);
		else
			$url = "t01_penerimaanadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t01_penerimaanedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t01_penerimaanadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t01_penerimaandelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = $_POST["id"];
			elseif (isset($_GET["id"]))
				$arKeys[] = $_GET["id"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->Departemen->setDbValue($rs->fields('Departemen'));
		$this->HeadDetail->setDbValue($rs->fields('HeadDetail'));
		$this->NomorHead->setDbValue($rs->fields('NomorHead'));
		$this->SubTotalFlag->setDbValue($rs->fields('SubTotalFlag'));
		$this->Urutan->setDbValue($rs->fields('Urutan'));
		$this->Nomor->setDbValue($rs->fields('Nomor'));
		$this->Pos->setDbValue($rs->fields('Pos'));
		$this->Nominal->setDbValue($rs->fields('Nominal'));
		$this->JumlahSiswa->setDbValue($rs->fields('JumlahSiswa'));
		$this->Bulan->setDbValue($rs->fields('Bulan'));
		$this->Jumlah->setDbValue($rs->fields('Jumlah'));
		$this->Total->setDbValue($rs->fields('Total'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id
		// Departemen
		// HeadDetail
		// NomorHead
		// SubTotalFlag
		// Urutan
		// Nomor
		// Pos
		// Nominal
		// JumlahSiswa
		// Bulan
		// Jumlah
		// Total
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// Departemen
		if (strval($this->Departemen->CurrentValue) <> "") {
			$sFilterWrk = "`departemen`" . ew_SearchString("=", $this->Departemen->CurrentValue, EW_DATATYPE_STRING, "jbsakad");
		$sSqlWrk = "SELECT `departemen`, `departemen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departemen`";
		$sWhereWrk = "";
		$this->Departemen->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Departemen, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `departemen` ASC";
			$rswrk = Conn("jbsakad")->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Departemen->ViewValue = $this->Departemen->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Departemen->ViewValue = $this->Departemen->CurrentValue;
			}
		} else {
			$this->Departemen->ViewValue = NULL;
		}
		$this->Departemen->ViewCustomAttributes = "";

		// HeadDetail
		$this->HeadDetail->ViewValue = $this->HeadDetail->CurrentValue;
		$this->HeadDetail->ViewCustomAttributes = "";

		// NomorHead
		$this->NomorHead->ViewValue = $this->NomorHead->CurrentValue;
		$this->NomorHead->ViewCustomAttributes = "";

		// SubTotalFlag
		$this->SubTotalFlag->ViewValue = $this->SubTotalFlag->CurrentValue;
		$this->SubTotalFlag->ViewCustomAttributes = "";

		// Urutan
		$this->Urutan->ViewValue = $this->Urutan->CurrentValue;
		$this->Urutan->ViewCustomAttributes = "";

		// Nomor
		$this->Nomor->ViewValue = $this->Nomor->CurrentValue;
		$this->Nomor->ViewCustomAttributes = "";

		// Pos
		$this->Pos->ViewValue = $this->Pos->CurrentValue;
		$this->Pos->ViewCustomAttributes = "";

		// Nominal
		$this->Nominal->ViewValue = $this->Nominal->CurrentValue;
		$this->Nominal->ViewCustomAttributes = "";

		// JumlahSiswa
		$this->JumlahSiswa->ViewValue = $this->JumlahSiswa->CurrentValue;
		$this->JumlahSiswa->ViewCustomAttributes = "";

		// Bulan
		$this->Bulan->ViewValue = $this->Bulan->CurrentValue;
		$this->Bulan->ViewCustomAttributes = "";

		// Jumlah
		$this->Jumlah->ViewValue = $this->Jumlah->CurrentValue;
		$this->Jumlah->ViewCustomAttributes = "";

		// Total
		$this->Total->ViewValue = $this->Total->CurrentValue;
		$this->Total->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// Departemen
		$this->Departemen->LinkCustomAttributes = "";
		$this->Departemen->HrefValue = "";
		$this->Departemen->TooltipValue = "";

		// HeadDetail
		$this->HeadDetail->LinkCustomAttributes = "";
		$this->HeadDetail->HrefValue = "";
		$this->HeadDetail->TooltipValue = "";

		// NomorHead
		$this->NomorHead->LinkCustomAttributes = "";
		$this->NomorHead->HrefValue = "";
		$this->NomorHead->TooltipValue = "";

		// SubTotalFlag
		$this->SubTotalFlag->LinkCustomAttributes = "";
		$this->SubTotalFlag->HrefValue = "";
		$this->SubTotalFlag->TooltipValue = "";

		// Urutan
		$this->Urutan->LinkCustomAttributes = "";
		$this->Urutan->HrefValue = "";
		$this->Urutan->TooltipValue = "";

		// Nomor
		$this->Nomor->LinkCustomAttributes = "";
		$this->Nomor->HrefValue = "";
		$this->Nomor->TooltipValue = "";

		// Pos
		$this->Pos->LinkCustomAttributes = "";
		$this->Pos->HrefValue = "";
		$this->Pos->TooltipValue = "";

		// Nominal
		$this->Nominal->LinkCustomAttributes = "";
		$this->Nominal->HrefValue = "";
		$this->Nominal->TooltipValue = "";

		// JumlahSiswa
		$this->JumlahSiswa->LinkCustomAttributes = "";
		$this->JumlahSiswa->HrefValue = "";
		$this->JumlahSiswa->TooltipValue = "";

		// Bulan
		$this->Bulan->LinkCustomAttributes = "";
		$this->Bulan->HrefValue = "";
		$this->Bulan->TooltipValue = "";

		// Jumlah
		$this->Jumlah->LinkCustomAttributes = "";
		$this->Jumlah->HrefValue = "";
		$this->Jumlah->TooltipValue = "";

		// Total
		$this->Total->LinkCustomAttributes = "";
		$this->Total->HrefValue = "";
		$this->Total->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// Departemen
		$this->Departemen->EditAttrs["class"] = "form-control";
		$this->Departemen->EditCustomAttributes = "";

		// HeadDetail
		$this->HeadDetail->EditAttrs["class"] = "form-control";
		$this->HeadDetail->EditCustomAttributes = "";
		$this->HeadDetail->EditValue = $this->HeadDetail->CurrentValue;
		$this->HeadDetail->PlaceHolder = ew_RemoveHtml($this->HeadDetail->FldCaption());

		// NomorHead
		$this->NomorHead->EditAttrs["class"] = "form-control";
		$this->NomorHead->EditCustomAttributes = "";
		$this->NomorHead->EditValue = $this->NomorHead->CurrentValue;
		$this->NomorHead->PlaceHolder = ew_RemoveHtml($this->NomorHead->FldCaption());

		// SubTotalFlag
		$this->SubTotalFlag->EditAttrs["class"] = "form-control";
		$this->SubTotalFlag->EditCustomAttributes = "";
		$this->SubTotalFlag->EditValue = $this->SubTotalFlag->CurrentValue;
		$this->SubTotalFlag->PlaceHolder = ew_RemoveHtml($this->SubTotalFlag->FldCaption());

		// Urutan
		$this->Urutan->EditAttrs["class"] = "form-control";
		$this->Urutan->EditCustomAttributes = "";
		$this->Urutan->EditValue = $this->Urutan->CurrentValue;
		$this->Urutan->PlaceHolder = ew_RemoveHtml($this->Urutan->FldCaption());

		// Nomor
		$this->Nomor->EditAttrs["class"] = "form-control";
		$this->Nomor->EditCustomAttributes = "";
		$this->Nomor->EditValue = $this->Nomor->CurrentValue;
		$this->Nomor->PlaceHolder = ew_RemoveHtml($this->Nomor->FldCaption());

		// Pos
		$this->Pos->EditAttrs["class"] = "form-control";
		$this->Pos->EditCustomAttributes = "";
		$this->Pos->EditValue = $this->Pos->CurrentValue;
		$this->Pos->PlaceHolder = ew_RemoveHtml($this->Pos->FldCaption());

		// Nominal
		$this->Nominal->EditAttrs["class"] = "form-control";
		$this->Nominal->EditCustomAttributes = "";
		$this->Nominal->EditValue = $this->Nominal->CurrentValue;
		$this->Nominal->PlaceHolder = ew_RemoveHtml($this->Nominal->FldCaption());
		if (strval($this->Nominal->EditValue) <> "" && is_numeric($this->Nominal->EditValue)) $this->Nominal->EditValue = ew_FormatNumber($this->Nominal->EditValue, -2, -1, -2, 0);

		// JumlahSiswa
		$this->JumlahSiswa->EditAttrs["class"] = "form-control";
		$this->JumlahSiswa->EditCustomAttributes = "";
		$this->JumlahSiswa->EditValue = $this->JumlahSiswa->CurrentValue;
		$this->JumlahSiswa->PlaceHolder = ew_RemoveHtml($this->JumlahSiswa->FldCaption());

		// Bulan
		$this->Bulan->EditAttrs["class"] = "form-control";
		$this->Bulan->EditCustomAttributes = "";
		$this->Bulan->EditValue = $this->Bulan->CurrentValue;
		$this->Bulan->PlaceHolder = ew_RemoveHtml($this->Bulan->FldCaption());

		// Jumlah
		$this->Jumlah->EditAttrs["class"] = "form-control";
		$this->Jumlah->EditCustomAttributes = "";
		$this->Jumlah->EditValue = $this->Jumlah->CurrentValue;
		$this->Jumlah->PlaceHolder = ew_RemoveHtml($this->Jumlah->FldCaption());
		if (strval($this->Jumlah->EditValue) <> "" && is_numeric($this->Jumlah->EditValue)) $this->Jumlah->EditValue = ew_FormatNumber($this->Jumlah->EditValue, -2, -1, -2, 0);

		// Total
		$this->Total->EditAttrs["class"] = "form-control";
		$this->Total->EditCustomAttributes = "";
		$this->Total->EditValue = $this->Total->CurrentValue;
		$this->Total->PlaceHolder = ew_RemoveHtml($this->Total->FldCaption());
		if (strval($this->Total->EditValue) <> "" && is_numeric($this->Total->EditValue)) $this->Total->EditValue = ew_FormatNumber($this->Total->EditValue, -2, -1, -2, 0);

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->Departemen->Exportable) $Doc->ExportCaption($this->Departemen);
					if ($this->HeadDetail->Exportable) $Doc->ExportCaption($this->HeadDetail);
					if ($this->NomorHead->Exportable) $Doc->ExportCaption($this->NomorHead);
					if ($this->SubTotalFlag->Exportable) $Doc->ExportCaption($this->SubTotalFlag);
					if ($this->Urutan->Exportable) $Doc->ExportCaption($this->Urutan);
					if ($this->Nomor->Exportable) $Doc->ExportCaption($this->Nomor);
					if ($this->Pos->Exportable) $Doc->ExportCaption($this->Pos);
					if ($this->Nominal->Exportable) $Doc->ExportCaption($this->Nominal);
					if ($this->JumlahSiswa->Exportable) $Doc->ExportCaption($this->JumlahSiswa);
					if ($this->Bulan->Exportable) $Doc->ExportCaption($this->Bulan);
					if ($this->Jumlah->Exportable) $Doc->ExportCaption($this->Jumlah);
					if ($this->Total->Exportable) $Doc->ExportCaption($this->Total);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->Departemen->Exportable) $Doc->ExportCaption($this->Departemen);
					if ($this->HeadDetail->Exportable) $Doc->ExportCaption($this->HeadDetail);
					if ($this->NomorHead->Exportable) $Doc->ExportCaption($this->NomorHead);
					if ($this->SubTotalFlag->Exportable) $Doc->ExportCaption($this->SubTotalFlag);
					if ($this->Urutan->Exportable) $Doc->ExportCaption($this->Urutan);
					if ($this->Nomor->Exportable) $Doc->ExportCaption($this->Nomor);
					if ($this->Pos->Exportable) $Doc->ExportCaption($this->Pos);
					if ($this->Nominal->Exportable) $Doc->ExportCaption($this->Nominal);
					if ($this->JumlahSiswa->Exportable) $Doc->ExportCaption($this->JumlahSiswa);
					if ($this->Bulan->Exportable) $Doc->ExportCaption($this->Bulan);
					if ($this->Jumlah->Exportable) $Doc->ExportCaption($this->Jumlah);
					if ($this->Total->Exportable) $Doc->ExportCaption($this->Total);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->Departemen->Exportable) $Doc->ExportField($this->Departemen);
						if ($this->HeadDetail->Exportable) $Doc->ExportField($this->HeadDetail);
						if ($this->NomorHead->Exportable) $Doc->ExportField($this->NomorHead);
						if ($this->SubTotalFlag->Exportable) $Doc->ExportField($this->SubTotalFlag);
						if ($this->Urutan->Exportable) $Doc->ExportField($this->Urutan);
						if ($this->Nomor->Exportable) $Doc->ExportField($this->Nomor);
						if ($this->Pos->Exportable) $Doc->ExportField($this->Pos);
						if ($this->Nominal->Exportable) $Doc->ExportField($this->Nominal);
						if ($this->JumlahSiswa->Exportable) $Doc->ExportField($this->JumlahSiswa);
						if ($this->Bulan->Exportable) $Doc->ExportField($this->Bulan);
						if ($this->Jumlah->Exportable) $Doc->ExportField($this->Jumlah);
						if ($this->Total->Exportable) $Doc->ExportField($this->Total);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->Departemen->Exportable) $Doc->ExportField($this->Departemen);
						if ($this->HeadDetail->Exportable) $Doc->ExportField($this->HeadDetail);
						if ($this->NomorHead->Exportable) $Doc->ExportField($this->NomorHead);
						if ($this->SubTotalFlag->Exportable) $Doc->ExportField($this->SubTotalFlag);
						if ($this->Urutan->Exportable) $Doc->ExportField($this->Urutan);
						if ($this->Nomor->Exportable) $Doc->ExportField($this->Nomor);
						if ($this->Pos->Exportable) $Doc->ExportField($this->Pos);
						if ($this->Nominal->Exportable) $Doc->ExportField($this->Nominal);
						if ($this->JumlahSiswa->Exportable) $Doc->ExportField($this->JumlahSiswa);
						if ($this->Bulan->Exportable) $Doc->ExportField($this->Bulan);
						if ($this->Jumlah->Exportable) $Doc->ExportField($this->Jumlah);
						if ($this->Total->Exportable) $Doc->ExportField($this->Total);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
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
}
?>
