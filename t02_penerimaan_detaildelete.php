<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t02_penerimaan_detailinfo.php" ?>
<?php include_once "t01_penerimaan_headinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t02_penerimaan_detail_delete = NULL; // Initialize page object first

class ct02_penerimaan_detail_delete extends ct02_penerimaan_detail {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{EA1CE07B-E03E-4EC9-BC42-48D490D73F97}';

	// Table name
	var $TableName = 't02_penerimaan_detail';

	// Page object name
	var $PageObjName = 't02_penerimaan_detail_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t02_penerimaan_detail)
		if (!isset($GLOBALS["t02_penerimaan_detail"]) || get_class($GLOBALS["t02_penerimaan_detail"]) == "ct02_penerimaan_detail") {
			$GLOBALS["t02_penerimaan_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t02_penerimaan_detail"];
		}

		// Table object (t01_penerimaan_head)
		if (!isset($GLOBALS['t01_penerimaan_head'])) $GLOBALS['t01_penerimaan_head'] = new ct01_penerimaan_head();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't02_penerimaan_detail', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->Urutan->SetVisibility();
		$this->Nomor->SetVisibility();
		$this->Kode->SetVisibility();
		$this->Pos->SetVisibility();
		$this->Nominal->SetVisibility();
		$this->Banyaknya->SetVisibility();
		$this->Satuan->SetVisibility();
		$this->Jumlah->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $t02_penerimaan_detail;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t02_penerimaan_detail);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up master/detail parameters
		$this->SetupMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t02_penerimaan_detaillist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t02_penerimaan_detail class, t02_penerimaan_detailinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("t02_penerimaan_detaillist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->id->setDbValue($row['id']);
		$this->Urutan->setDbValue($row['Urutan']);
		$this->Nomor->setDbValue($row['Nomor']);
		$this->Kode->setDbValue($row['Kode']);
		$this->Pos->setDbValue($row['Pos']);
		$this->Nominal->setDbValue($row['Nominal']);
		$this->Banyaknya->setDbValue($row['Banyaknya']);
		$this->Satuan->setDbValue($row['Satuan']);
		$this->Jumlah->setDbValue($row['Jumlah']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['Urutan'] = NULL;
		$row['Nomor'] = NULL;
		$row['Kode'] = NULL;
		$row['Pos'] = NULL;
		$row['Nominal'] = NULL;
		$row['Banyaknya'] = NULL;
		$row['Satuan'] = NULL;
		$row['Jumlah'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->Urutan->DbValue = $row['Urutan'];
		$this->Nomor->DbValue = $row['Nomor'];
		$this->Kode->DbValue = $row['Kode'];
		$this->Pos->DbValue = $row['Pos'];
		$this->Nominal->DbValue = $row['Nominal'];
		$this->Banyaknya->DbValue = $row['Banyaknya'];
		$this->Satuan->DbValue = $row['Satuan'];
		$this->Jumlah->DbValue = $row['Jumlah'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->Nominal->FormValue == $this->Nominal->CurrentValue && is_numeric(ew_StrToFloat($this->Nominal->CurrentValue)))
			$this->Nominal->CurrentValue = ew_StrToFloat($this->Nominal->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Jumlah->FormValue == $this->Jumlah->CurrentValue && is_numeric(ew_StrToFloat($this->Jumlah->CurrentValue)))
			$this->Jumlah->CurrentValue = ew_StrToFloat($this->Jumlah->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// Urutan
		// Nomor
		// Kode
		// Pos
		// Nominal
		// Banyaknya
		// Satuan
		// Jumlah

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// Urutan
		$this->Urutan->ViewValue = $this->Urutan->CurrentValue;
		$this->Urutan->ViewCustomAttributes = "";

		// Nomor
		$this->Nomor->ViewValue = $this->Nomor->CurrentValue;
		$this->Nomor->ViewCustomAttributes = "";

		// Kode
		$this->Kode->ViewValue = $this->Kode->CurrentValue;
		$this->Kode->ViewCustomAttributes = "";

		// Pos
		$this->Pos->ViewValue = $this->Pos->CurrentValue;
		$this->Pos->ViewCustomAttributes = "";

		// Nominal
		$this->Nominal->ViewValue = $this->Nominal->CurrentValue;
		$this->Nominal->ViewCustomAttributes = "";

		// Banyaknya
		$this->Banyaknya->ViewValue = $this->Banyaknya->CurrentValue;
		$this->Banyaknya->ViewCustomAttributes = "";

		// Satuan
		$this->Satuan->ViewValue = $this->Satuan->CurrentValue;
		$this->Satuan->ViewCustomAttributes = "";

		// Jumlah
		$this->Jumlah->ViewValue = $this->Jumlah->CurrentValue;
		$this->Jumlah->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// Urutan
			$this->Urutan->LinkCustomAttributes = "";
			$this->Urutan->HrefValue = "";
			$this->Urutan->TooltipValue = "";

			// Nomor
			$this->Nomor->LinkCustomAttributes = "";
			$this->Nomor->HrefValue = "";
			$this->Nomor->TooltipValue = "";

			// Kode
			$this->Kode->LinkCustomAttributes = "";
			$this->Kode->HrefValue = "";
			$this->Kode->TooltipValue = "";

			// Pos
			$this->Pos->LinkCustomAttributes = "";
			$this->Pos->HrefValue = "";
			$this->Pos->TooltipValue = "";

			// Nominal
			$this->Nominal->LinkCustomAttributes = "";
			$this->Nominal->HrefValue = "";
			$this->Nominal->TooltipValue = "";

			// Banyaknya
			$this->Banyaknya->LinkCustomAttributes = "";
			$this->Banyaknya->HrefValue = "";
			$this->Banyaknya->TooltipValue = "";

			// Satuan
			$this->Satuan->LinkCustomAttributes = "";
			$this->Satuan->HrefValue = "";
			$this->Satuan->TooltipValue = "";

			// Jumlah
			$this->Jumlah->LinkCustomAttributes = "";
			$this->Jumlah->HrefValue = "";
			$this->Jumlah->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up master/detail based on QueryString
	function SetupMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "t01_penerimaan_head") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_Kode"] <> "") {
					$GLOBALS["t01_penerimaan_head"]->Kode->setQueryStringValue($_GET["fk_Kode"]);
					$this->Kode->setQueryStringValue($GLOBALS["t01_penerimaan_head"]->Kode->QueryStringValue);
					$this->Kode->setSessionValue($this->Kode->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "t01_penerimaan_head") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_Kode"] <> "") {
					$GLOBALS["t01_penerimaan_head"]->Kode->setFormValue($_POST["fk_Kode"]);
					$this->Kode->setFormValue($GLOBALS["t01_penerimaan_head"]->Kode->FormValue);
					$this->Kode->setSessionValue($this->Kode->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			if (!$this->IsAddOrEdit()) {
				$this->StartRec = 1;
				$this->setStartRecordNumber($this->StartRec);
			}

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t01_penerimaan_head") {
				if ($this->Kode->CurrentValue == "") $this->Kode->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t02_penerimaan_detaillist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t02_penerimaan_detail_delete)) $t02_penerimaan_detail_delete = new ct02_penerimaan_detail_delete();

// Page init
$t02_penerimaan_detail_delete->Page_Init();

// Page main
$t02_penerimaan_detail_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t02_penerimaan_detail_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft02_penerimaan_detaildelete = new ew_Form("ft02_penerimaan_detaildelete", "delete");

// Form_CustomValidate event
ft02_penerimaan_detaildelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft02_penerimaan_detaildelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t02_penerimaan_detail_delete->ShowPageHeader(); ?>
<?php
$t02_penerimaan_detail_delete->ShowMessage();
?>
<form name="ft02_penerimaan_detaildelete" id="ft02_penerimaan_detaildelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t02_penerimaan_detail_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t02_penerimaan_detail_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t02_penerimaan_detail">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t02_penerimaan_detail_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($t02_penerimaan_detail->id->Visible) { // id ?>
		<th class="<?php echo $t02_penerimaan_detail->id->HeaderCellClass() ?>"><span id="elh_t02_penerimaan_detail_id" class="t02_penerimaan_detail_id"><?php echo $t02_penerimaan_detail->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_penerimaan_detail->Urutan->Visible) { // Urutan ?>
		<th class="<?php echo $t02_penerimaan_detail->Urutan->HeaderCellClass() ?>"><span id="elh_t02_penerimaan_detail_Urutan" class="t02_penerimaan_detail_Urutan"><?php echo $t02_penerimaan_detail->Urutan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_penerimaan_detail->Nomor->Visible) { // Nomor ?>
		<th class="<?php echo $t02_penerimaan_detail->Nomor->HeaderCellClass() ?>"><span id="elh_t02_penerimaan_detail_Nomor" class="t02_penerimaan_detail_Nomor"><?php echo $t02_penerimaan_detail->Nomor->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_penerimaan_detail->Kode->Visible) { // Kode ?>
		<th class="<?php echo $t02_penerimaan_detail->Kode->HeaderCellClass() ?>"><span id="elh_t02_penerimaan_detail_Kode" class="t02_penerimaan_detail_Kode"><?php echo $t02_penerimaan_detail->Kode->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_penerimaan_detail->Pos->Visible) { // Pos ?>
		<th class="<?php echo $t02_penerimaan_detail->Pos->HeaderCellClass() ?>"><span id="elh_t02_penerimaan_detail_Pos" class="t02_penerimaan_detail_Pos"><?php echo $t02_penerimaan_detail->Pos->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_penerimaan_detail->Nominal->Visible) { // Nominal ?>
		<th class="<?php echo $t02_penerimaan_detail->Nominal->HeaderCellClass() ?>"><span id="elh_t02_penerimaan_detail_Nominal" class="t02_penerimaan_detail_Nominal"><?php echo $t02_penerimaan_detail->Nominal->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_penerimaan_detail->Banyaknya->Visible) { // Banyaknya ?>
		<th class="<?php echo $t02_penerimaan_detail->Banyaknya->HeaderCellClass() ?>"><span id="elh_t02_penerimaan_detail_Banyaknya" class="t02_penerimaan_detail_Banyaknya"><?php echo $t02_penerimaan_detail->Banyaknya->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_penerimaan_detail->Satuan->Visible) { // Satuan ?>
		<th class="<?php echo $t02_penerimaan_detail->Satuan->HeaderCellClass() ?>"><span id="elh_t02_penerimaan_detail_Satuan" class="t02_penerimaan_detail_Satuan"><?php echo $t02_penerimaan_detail->Satuan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_penerimaan_detail->Jumlah->Visible) { // Jumlah ?>
		<th class="<?php echo $t02_penerimaan_detail->Jumlah->HeaderCellClass() ?>"><span id="elh_t02_penerimaan_detail_Jumlah" class="t02_penerimaan_detail_Jumlah"><?php echo $t02_penerimaan_detail->Jumlah->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t02_penerimaan_detail_delete->RecCnt = 0;
$i = 0;
while (!$t02_penerimaan_detail_delete->Recordset->EOF) {
	$t02_penerimaan_detail_delete->RecCnt++;
	$t02_penerimaan_detail_delete->RowCnt++;

	// Set row properties
	$t02_penerimaan_detail->ResetAttrs();
	$t02_penerimaan_detail->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t02_penerimaan_detail_delete->LoadRowValues($t02_penerimaan_detail_delete->Recordset);

	// Render row
	$t02_penerimaan_detail_delete->RenderRow();
?>
	<tr<?php echo $t02_penerimaan_detail->RowAttributes() ?>>
<?php if ($t02_penerimaan_detail->id->Visible) { // id ?>
		<td<?php echo $t02_penerimaan_detail->id->CellAttributes() ?>>
<span id="el<?php echo $t02_penerimaan_detail_delete->RowCnt ?>_t02_penerimaan_detail_id" class="t02_penerimaan_detail_id">
<span<?php echo $t02_penerimaan_detail->id->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_penerimaan_detail->Urutan->Visible) { // Urutan ?>
		<td<?php echo $t02_penerimaan_detail->Urutan->CellAttributes() ?>>
<span id="el<?php echo $t02_penerimaan_detail_delete->RowCnt ?>_t02_penerimaan_detail_Urutan" class="t02_penerimaan_detail_Urutan">
<span<?php echo $t02_penerimaan_detail->Urutan->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Urutan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_penerimaan_detail->Nomor->Visible) { // Nomor ?>
		<td<?php echo $t02_penerimaan_detail->Nomor->CellAttributes() ?>>
<span id="el<?php echo $t02_penerimaan_detail_delete->RowCnt ?>_t02_penerimaan_detail_Nomor" class="t02_penerimaan_detail_Nomor">
<span<?php echo $t02_penerimaan_detail->Nomor->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Nomor->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_penerimaan_detail->Kode->Visible) { // Kode ?>
		<td<?php echo $t02_penerimaan_detail->Kode->CellAttributes() ?>>
<span id="el<?php echo $t02_penerimaan_detail_delete->RowCnt ?>_t02_penerimaan_detail_Kode" class="t02_penerimaan_detail_Kode">
<span<?php echo $t02_penerimaan_detail->Kode->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Kode->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_penerimaan_detail->Pos->Visible) { // Pos ?>
		<td<?php echo $t02_penerimaan_detail->Pos->CellAttributes() ?>>
<span id="el<?php echo $t02_penerimaan_detail_delete->RowCnt ?>_t02_penerimaan_detail_Pos" class="t02_penerimaan_detail_Pos">
<span<?php echo $t02_penerimaan_detail->Pos->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Pos->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_penerimaan_detail->Nominal->Visible) { // Nominal ?>
		<td<?php echo $t02_penerimaan_detail->Nominal->CellAttributes() ?>>
<span id="el<?php echo $t02_penerimaan_detail_delete->RowCnt ?>_t02_penerimaan_detail_Nominal" class="t02_penerimaan_detail_Nominal">
<span<?php echo $t02_penerimaan_detail->Nominal->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Nominal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_penerimaan_detail->Banyaknya->Visible) { // Banyaknya ?>
		<td<?php echo $t02_penerimaan_detail->Banyaknya->CellAttributes() ?>>
<span id="el<?php echo $t02_penerimaan_detail_delete->RowCnt ?>_t02_penerimaan_detail_Banyaknya" class="t02_penerimaan_detail_Banyaknya">
<span<?php echo $t02_penerimaan_detail->Banyaknya->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Banyaknya->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_penerimaan_detail->Satuan->Visible) { // Satuan ?>
		<td<?php echo $t02_penerimaan_detail->Satuan->CellAttributes() ?>>
<span id="el<?php echo $t02_penerimaan_detail_delete->RowCnt ?>_t02_penerimaan_detail_Satuan" class="t02_penerimaan_detail_Satuan">
<span<?php echo $t02_penerimaan_detail->Satuan->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Satuan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_penerimaan_detail->Jumlah->Visible) { // Jumlah ?>
		<td<?php echo $t02_penerimaan_detail->Jumlah->CellAttributes() ?>>
<span id="el<?php echo $t02_penerimaan_detail_delete->RowCnt ?>_t02_penerimaan_detail_Jumlah" class="t02_penerimaan_detail_Jumlah">
<span<?php echo $t02_penerimaan_detail->Jumlah->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Jumlah->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t02_penerimaan_detail_delete->Recordset->MoveNext();
}
$t02_penerimaan_detail_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t02_penerimaan_detail_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft02_penerimaan_detaildelete.Init();
</script>
<?php
$t02_penerimaan_detail_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t02_penerimaan_detail_delete->Page_Terminate();
?>
