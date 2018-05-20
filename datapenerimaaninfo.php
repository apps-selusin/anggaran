<?php

// Global variable for table object
$datapenerimaan = NULL;

//
// Table class for datapenerimaan
//
class cdatapenerimaan extends cTable {
	var $replid;
	var $nama;
	var $besar;
	var $idkategori;
	var $rekkas;
	var $rekpendapatan;
	var $rekpiutang;
	var $aktif;
	var $keterangan;
	var $departemen;
	var $info1;
	var $info2;
	var $info3;
	var $ts;
	var $token;
	var $issync;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'datapenerimaan';
		$this->TableName = 'datapenerimaan';
		$this->TableType = 'LINKTABLE';

		// Update Table
		$this->UpdateTable = "`datapenerimaan`";
		$this->DBID = 'jbsfina';
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

		// replid
		$this->replid = new cField('datapenerimaan', 'datapenerimaan', 'x_replid', 'replid', '`replid`', '`replid`', 19, -1, FALSE, '`replid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->replid->Sortable = TRUE; // Allow sort
		$this->replid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['replid'] = &$this->replid;

		// nama
		$this->nama = new cField('datapenerimaan', 'datapenerimaan', 'x_nama', 'nama', '`nama`', '`nama`', 200, -1, FALSE, '`nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama->Sortable = TRUE; // Allow sort
		$this->fields['nama'] = &$this->nama;

		// besar
		$this->besar = new cField('datapenerimaan', 'datapenerimaan', 'x_besar', 'besar', '`besar`', '`besar`', 131, -1, FALSE, '`besar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->besar->Sortable = TRUE; // Allow sort
		$this->besar->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['besar'] = &$this->besar;

		// idkategori
		$this->idkategori = new cField('datapenerimaan', 'datapenerimaan', 'x_idkategori', 'idkategori', '`idkategori`', '`idkategori`', 200, -1, FALSE, '`idkategori`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->idkategori->Sortable = TRUE; // Allow sort
		$this->fields['idkategori'] = &$this->idkategori;

		// rekkas
		$this->rekkas = new cField('datapenerimaan', 'datapenerimaan', 'x_rekkas', 'rekkas', '`rekkas`', '`rekkas`', 200, -1, FALSE, '`rekkas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rekkas->Sortable = TRUE; // Allow sort
		$this->fields['rekkas'] = &$this->rekkas;

		// rekpendapatan
		$this->rekpendapatan = new cField('datapenerimaan', 'datapenerimaan', 'x_rekpendapatan', 'rekpendapatan', '`rekpendapatan`', '`rekpendapatan`', 200, -1, FALSE, '`rekpendapatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rekpendapatan->Sortable = TRUE; // Allow sort
		$this->fields['rekpendapatan'] = &$this->rekpendapatan;

		// rekpiutang
		$this->rekpiutang = new cField('datapenerimaan', 'datapenerimaan', 'x_rekpiutang', 'rekpiutang', '`rekpiutang`', '`rekpiutang`', 200, -1, FALSE, '`rekpiutang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rekpiutang->Sortable = TRUE; // Allow sort
		$this->fields['rekpiutang'] = &$this->rekpiutang;

		// aktif
		$this->aktif = new cField('datapenerimaan', 'datapenerimaan', 'x_aktif', 'aktif', '`aktif`', '`aktif`', 17, -1, FALSE, '`aktif`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->aktif->Sortable = TRUE; // Allow sort
		$this->aktif->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['aktif'] = &$this->aktif;

		// keterangan
		$this->keterangan = new cField('datapenerimaan', 'datapenerimaan', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 200, -1, FALSE, '`keterangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->keterangan->Sortable = TRUE; // Allow sort
		$this->fields['keterangan'] = &$this->keterangan;

		// departemen
		$this->departemen = new cField('datapenerimaan', 'datapenerimaan', 'x_departemen', 'departemen', '`departemen`', '`departemen`', 200, -1, FALSE, '`departemen`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->departemen->Sortable = TRUE; // Allow sort
		$this->fields['departemen'] = &$this->departemen;

		// info1
		$this->info1 = new cField('datapenerimaan', 'datapenerimaan', 'x_info1', 'info1', '`info1`', '`info1`', 200, -1, FALSE, '`info1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->info1->Sortable = TRUE; // Allow sort
		$this->fields['info1'] = &$this->info1;

		// info2
		$this->info2 = new cField('datapenerimaan', 'datapenerimaan', 'x_info2', 'info2', '`info2`', '`info2`', 200, -1, FALSE, '`info2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->info2->Sortable = TRUE; // Allow sort
		$this->fields['info2'] = &$this->info2;

		// info3
		$this->info3 = new cField('datapenerimaan', 'datapenerimaan', 'x_info3', 'info3', '`info3`', '`info3`', 200, -1, FALSE, '`info3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->info3->Sortable = TRUE; // Allow sort
		$this->fields['info3'] = &$this->info3;

		// ts
		$this->ts = new cField('datapenerimaan', 'datapenerimaan', 'x_ts', 'ts', '`ts`', ew_CastDateFieldForLike('`ts`', 0, "jbsfina"), 135, 0, FALSE, '`ts`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ts->Sortable = TRUE; // Allow sort
		$this->ts->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['ts'] = &$this->ts;

		// token
		$this->token = new cField('datapenerimaan', 'datapenerimaan', 'x_token', 'token', '`token`', '`token`', 18, -1, FALSE, '`token`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->token->Sortable = TRUE; // Allow sort
		$this->token->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['token'] = &$this->token;

		// issync
		$this->issync = new cField('datapenerimaan', 'datapenerimaan', 'x_issync', 'issync', '`issync`', '`issync`', 17, -1, FALSE, '`issync`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->issync->Sortable = TRUE; // Allow sort
		$this->issync->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['issync'] = &$this->issync;
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
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`datapenerimaan`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
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
			$this->replid->setDbValue($conn->Insert_ID());
			$rs['replid'] = $this->replid->DbValue;
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
			if (array_key_exists('replid', $rs))
				ew_AddFilter($where, ew_QuotedName('replid', $this->DBID) . '=' . ew_QuotedValue($rs['replid'], $this->replid->FldDataType, $this->DBID));
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
		return "`replid` = @replid@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->replid->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->replid->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@replid@", ew_AdjustSql($this->replid->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "datapenerimaanlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "datapenerimaanview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "datapenerimaanedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "datapenerimaanadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "datapenerimaanlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("datapenerimaanview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("datapenerimaanview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "datapenerimaanadd.php?" . $this->UrlParm($parm);
		else
			$url = "datapenerimaanadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("datapenerimaanedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("datapenerimaanadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("datapenerimaandelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "replid:" . ew_VarToJson($this->replid->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->replid->CurrentValue)) {
			$sUrl .= "replid=" . urlencode($this->replid->CurrentValue);
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
			if ($isPost && isset($_POST["replid"]))
				$arKeys[] = $_POST["replid"];
			elseif (isset($_GET["replid"]))
				$arKeys[] = $_GET["replid"];
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
			$this->replid->CurrentValue = $key;
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
		$this->replid->setDbValue($rs->fields('replid'));
		$this->nama->setDbValue($rs->fields('nama'));
		$this->besar->setDbValue($rs->fields('besar'));
		$this->idkategori->setDbValue($rs->fields('idkategori'));
		$this->rekkas->setDbValue($rs->fields('rekkas'));
		$this->rekpendapatan->setDbValue($rs->fields('rekpendapatan'));
		$this->rekpiutang->setDbValue($rs->fields('rekpiutang'));
		$this->aktif->setDbValue($rs->fields('aktif'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->departemen->setDbValue($rs->fields('departemen'));
		$this->info1->setDbValue($rs->fields('info1'));
		$this->info2->setDbValue($rs->fields('info2'));
		$this->info3->setDbValue($rs->fields('info3'));
		$this->ts->setDbValue($rs->fields('ts'));
		$this->token->setDbValue($rs->fields('token'));
		$this->issync->setDbValue($rs->fields('issync'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// replid
		// nama
		// besar
		// idkategori
		// rekkas
		// rekpendapatan
		// rekpiutang
		// aktif
		// keterangan
		// departemen
		// info1
		// info2
		// info3
		// ts
		// token
		// issync
		// replid

		$this->replid->ViewValue = $this->replid->CurrentValue;
		$this->replid->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// besar
		$this->besar->ViewValue = $this->besar->CurrentValue;
		$this->besar->ViewCustomAttributes = "";

		// idkategori
		$this->idkategori->ViewValue = $this->idkategori->CurrentValue;
		$this->idkategori->ViewCustomAttributes = "";

		// rekkas
		$this->rekkas->ViewValue = $this->rekkas->CurrentValue;
		$this->rekkas->ViewCustomAttributes = "";

		// rekpendapatan
		$this->rekpendapatan->ViewValue = $this->rekpendapatan->CurrentValue;
		$this->rekpendapatan->ViewCustomAttributes = "";

		// rekpiutang
		$this->rekpiutang->ViewValue = $this->rekpiutang->CurrentValue;
		$this->rekpiutang->ViewCustomAttributes = "";

		// aktif
		$this->aktif->ViewValue = $this->aktif->CurrentValue;
		$this->aktif->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// departemen
		$this->departemen->ViewValue = $this->departemen->CurrentValue;
		$this->departemen->ViewCustomAttributes = "";

		// info1
		$this->info1->ViewValue = $this->info1->CurrentValue;
		$this->info1->ViewCustomAttributes = "";

		// info2
		$this->info2->ViewValue = $this->info2->CurrentValue;
		$this->info2->ViewCustomAttributes = "";

		// info3
		$this->info3->ViewValue = $this->info3->CurrentValue;
		$this->info3->ViewCustomAttributes = "";

		// ts
		$this->ts->ViewValue = $this->ts->CurrentValue;
		$this->ts->ViewValue = ew_FormatDateTime($this->ts->ViewValue, 0);
		$this->ts->ViewCustomAttributes = "";

		// token
		$this->token->ViewValue = $this->token->CurrentValue;
		$this->token->ViewCustomAttributes = "";

		// issync
		$this->issync->ViewValue = $this->issync->CurrentValue;
		$this->issync->ViewCustomAttributes = "";

		// replid
		$this->replid->LinkCustomAttributes = "";
		$this->replid->HrefValue = "";
		$this->replid->TooltipValue = "";

		// nama
		$this->nama->LinkCustomAttributes = "";
		$this->nama->HrefValue = "";
		$this->nama->TooltipValue = "";

		// besar
		$this->besar->LinkCustomAttributes = "";
		$this->besar->HrefValue = "";
		$this->besar->TooltipValue = "";

		// idkategori
		$this->idkategori->LinkCustomAttributes = "";
		$this->idkategori->HrefValue = "";
		$this->idkategori->TooltipValue = "";

		// rekkas
		$this->rekkas->LinkCustomAttributes = "";
		$this->rekkas->HrefValue = "";
		$this->rekkas->TooltipValue = "";

		// rekpendapatan
		$this->rekpendapatan->LinkCustomAttributes = "";
		$this->rekpendapatan->HrefValue = "";
		$this->rekpendapatan->TooltipValue = "";

		// rekpiutang
		$this->rekpiutang->LinkCustomAttributes = "";
		$this->rekpiutang->HrefValue = "";
		$this->rekpiutang->TooltipValue = "";

		// aktif
		$this->aktif->LinkCustomAttributes = "";
		$this->aktif->HrefValue = "";
		$this->aktif->TooltipValue = "";

		// keterangan
		$this->keterangan->LinkCustomAttributes = "";
		$this->keterangan->HrefValue = "";
		$this->keterangan->TooltipValue = "";

		// departemen
		$this->departemen->LinkCustomAttributes = "";
		$this->departemen->HrefValue = "";
		$this->departemen->TooltipValue = "";

		// info1
		$this->info1->LinkCustomAttributes = "";
		$this->info1->HrefValue = "";
		$this->info1->TooltipValue = "";

		// info2
		$this->info2->LinkCustomAttributes = "";
		$this->info2->HrefValue = "";
		$this->info2->TooltipValue = "";

		// info3
		$this->info3->LinkCustomAttributes = "";
		$this->info3->HrefValue = "";
		$this->info3->TooltipValue = "";

		// ts
		$this->ts->LinkCustomAttributes = "";
		$this->ts->HrefValue = "";
		$this->ts->TooltipValue = "";

		// token
		$this->token->LinkCustomAttributes = "";
		$this->token->HrefValue = "";
		$this->token->TooltipValue = "";

		// issync
		$this->issync->LinkCustomAttributes = "";
		$this->issync->HrefValue = "";
		$this->issync->TooltipValue = "";

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

		// replid
		$this->replid->EditAttrs["class"] = "form-control";
		$this->replid->EditCustomAttributes = "";
		$this->replid->EditValue = $this->replid->CurrentValue;
		$this->replid->ViewCustomAttributes = "";

		// nama
		$this->nama->EditAttrs["class"] = "form-control";
		$this->nama->EditCustomAttributes = "";
		$this->nama->EditValue = $this->nama->CurrentValue;
		$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

		// besar
		$this->besar->EditAttrs["class"] = "form-control";
		$this->besar->EditCustomAttributes = "";
		$this->besar->EditValue = $this->besar->CurrentValue;
		$this->besar->PlaceHolder = ew_RemoveHtml($this->besar->FldCaption());
		if (strval($this->besar->EditValue) <> "" && is_numeric($this->besar->EditValue)) $this->besar->EditValue = ew_FormatNumber($this->besar->EditValue, -2, -1, -2, 0);

		// idkategori
		$this->idkategori->EditAttrs["class"] = "form-control";
		$this->idkategori->EditCustomAttributes = "";
		$this->idkategori->EditValue = $this->idkategori->CurrentValue;
		$this->idkategori->PlaceHolder = ew_RemoveHtml($this->idkategori->FldCaption());

		// rekkas
		$this->rekkas->EditAttrs["class"] = "form-control";
		$this->rekkas->EditCustomAttributes = "";
		$this->rekkas->EditValue = $this->rekkas->CurrentValue;
		$this->rekkas->PlaceHolder = ew_RemoveHtml($this->rekkas->FldCaption());

		// rekpendapatan
		$this->rekpendapatan->EditAttrs["class"] = "form-control";
		$this->rekpendapatan->EditCustomAttributes = "";
		$this->rekpendapatan->EditValue = $this->rekpendapatan->CurrentValue;
		$this->rekpendapatan->PlaceHolder = ew_RemoveHtml($this->rekpendapatan->FldCaption());

		// rekpiutang
		$this->rekpiutang->EditAttrs["class"] = "form-control";
		$this->rekpiutang->EditCustomAttributes = "";
		$this->rekpiutang->EditValue = $this->rekpiutang->CurrentValue;
		$this->rekpiutang->PlaceHolder = ew_RemoveHtml($this->rekpiutang->FldCaption());

		// aktif
		$this->aktif->EditAttrs["class"] = "form-control";
		$this->aktif->EditCustomAttributes = "";
		$this->aktif->EditValue = $this->aktif->CurrentValue;
		$this->aktif->PlaceHolder = ew_RemoveHtml($this->aktif->FldCaption());

		// keterangan
		$this->keterangan->EditAttrs["class"] = "form-control";
		$this->keterangan->EditCustomAttributes = "";
		$this->keterangan->EditValue = $this->keterangan->CurrentValue;
		$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

		// departemen
		$this->departemen->EditAttrs["class"] = "form-control";
		$this->departemen->EditCustomAttributes = "";
		$this->departemen->EditValue = $this->departemen->CurrentValue;
		$this->departemen->PlaceHolder = ew_RemoveHtml($this->departemen->FldCaption());

		// info1
		$this->info1->EditAttrs["class"] = "form-control";
		$this->info1->EditCustomAttributes = "";
		$this->info1->EditValue = $this->info1->CurrentValue;
		$this->info1->PlaceHolder = ew_RemoveHtml($this->info1->FldCaption());

		// info2
		$this->info2->EditAttrs["class"] = "form-control";
		$this->info2->EditCustomAttributes = "";
		$this->info2->EditValue = $this->info2->CurrentValue;
		$this->info2->PlaceHolder = ew_RemoveHtml($this->info2->FldCaption());

		// info3
		$this->info3->EditAttrs["class"] = "form-control";
		$this->info3->EditCustomAttributes = "";
		$this->info3->EditValue = $this->info3->CurrentValue;
		$this->info3->PlaceHolder = ew_RemoveHtml($this->info3->FldCaption());

		// ts
		$this->ts->EditAttrs["class"] = "form-control";
		$this->ts->EditCustomAttributes = "";
		$this->ts->EditValue = ew_FormatDateTime($this->ts->CurrentValue, 8);
		$this->ts->PlaceHolder = ew_RemoveHtml($this->ts->FldCaption());

		// token
		$this->token->EditAttrs["class"] = "form-control";
		$this->token->EditCustomAttributes = "";
		$this->token->EditValue = $this->token->CurrentValue;
		$this->token->PlaceHolder = ew_RemoveHtml($this->token->FldCaption());

		// issync
		$this->issync->EditAttrs["class"] = "form-control";
		$this->issync->EditCustomAttributes = "";
		$this->issync->EditValue = $this->issync->CurrentValue;
		$this->issync->PlaceHolder = ew_RemoveHtml($this->issync->FldCaption());

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
					if ($this->replid->Exportable) $Doc->ExportCaption($this->replid);
					if ($this->nama->Exportable) $Doc->ExportCaption($this->nama);
					if ($this->besar->Exportable) $Doc->ExportCaption($this->besar);
					if ($this->idkategori->Exportable) $Doc->ExportCaption($this->idkategori);
					if ($this->rekkas->Exportable) $Doc->ExportCaption($this->rekkas);
					if ($this->rekpendapatan->Exportable) $Doc->ExportCaption($this->rekpendapatan);
					if ($this->rekpiutang->Exportable) $Doc->ExportCaption($this->rekpiutang);
					if ($this->aktif->Exportable) $Doc->ExportCaption($this->aktif);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
					if ($this->departemen->Exportable) $Doc->ExportCaption($this->departemen);
					if ($this->info1->Exportable) $Doc->ExportCaption($this->info1);
					if ($this->info2->Exportable) $Doc->ExportCaption($this->info2);
					if ($this->info3->Exportable) $Doc->ExportCaption($this->info3);
					if ($this->ts->Exportable) $Doc->ExportCaption($this->ts);
					if ($this->token->Exportable) $Doc->ExportCaption($this->token);
					if ($this->issync->Exportable) $Doc->ExportCaption($this->issync);
				} else {
					if ($this->replid->Exportable) $Doc->ExportCaption($this->replid);
					if ($this->nama->Exportable) $Doc->ExportCaption($this->nama);
					if ($this->besar->Exportable) $Doc->ExportCaption($this->besar);
					if ($this->idkategori->Exportable) $Doc->ExportCaption($this->idkategori);
					if ($this->rekkas->Exportable) $Doc->ExportCaption($this->rekkas);
					if ($this->rekpendapatan->Exportable) $Doc->ExportCaption($this->rekpendapatan);
					if ($this->rekpiutang->Exportable) $Doc->ExportCaption($this->rekpiutang);
					if ($this->aktif->Exportable) $Doc->ExportCaption($this->aktif);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
					if ($this->departemen->Exportable) $Doc->ExportCaption($this->departemen);
					if ($this->info1->Exportable) $Doc->ExportCaption($this->info1);
					if ($this->info2->Exportable) $Doc->ExportCaption($this->info2);
					if ($this->info3->Exportable) $Doc->ExportCaption($this->info3);
					if ($this->ts->Exportable) $Doc->ExportCaption($this->ts);
					if ($this->token->Exportable) $Doc->ExportCaption($this->token);
					if ($this->issync->Exportable) $Doc->ExportCaption($this->issync);
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
						if ($this->replid->Exportable) $Doc->ExportField($this->replid);
						if ($this->nama->Exportable) $Doc->ExportField($this->nama);
						if ($this->besar->Exportable) $Doc->ExportField($this->besar);
						if ($this->idkategori->Exportable) $Doc->ExportField($this->idkategori);
						if ($this->rekkas->Exportable) $Doc->ExportField($this->rekkas);
						if ($this->rekpendapatan->Exportable) $Doc->ExportField($this->rekpendapatan);
						if ($this->rekpiutang->Exportable) $Doc->ExportField($this->rekpiutang);
						if ($this->aktif->Exportable) $Doc->ExportField($this->aktif);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
						if ($this->departemen->Exportable) $Doc->ExportField($this->departemen);
						if ($this->info1->Exportable) $Doc->ExportField($this->info1);
						if ($this->info2->Exportable) $Doc->ExportField($this->info2);
						if ($this->info3->Exportable) $Doc->ExportField($this->info3);
						if ($this->ts->Exportable) $Doc->ExportField($this->ts);
						if ($this->token->Exportable) $Doc->ExportField($this->token);
						if ($this->issync->Exportable) $Doc->ExportField($this->issync);
					} else {
						if ($this->replid->Exportable) $Doc->ExportField($this->replid);
						if ($this->nama->Exportable) $Doc->ExportField($this->nama);
						if ($this->besar->Exportable) $Doc->ExportField($this->besar);
						if ($this->idkategori->Exportable) $Doc->ExportField($this->idkategori);
						if ($this->rekkas->Exportable) $Doc->ExportField($this->rekkas);
						if ($this->rekpendapatan->Exportable) $Doc->ExportField($this->rekpendapatan);
						if ($this->rekpiutang->Exportable) $Doc->ExportField($this->rekpiutang);
						if ($this->aktif->Exportable) $Doc->ExportField($this->aktif);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
						if ($this->departemen->Exportable) $Doc->ExportField($this->departemen);
						if ($this->info1->Exportable) $Doc->ExportField($this->info1);
						if ($this->info2->Exportable) $Doc->ExportField($this->info2);
						if ($this->info3->Exportable) $Doc->ExportField($this->info3);
						if ($this->ts->Exportable) $Doc->ExportField($this->ts);
						if ($this->token->Exportable) $Doc->ExportField($this->token);
						if ($this->issync->Exportable) $Doc->ExportField($this->issync);
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
