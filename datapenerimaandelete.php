<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "datapenerimaaninfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$datapenerimaan_delete = NULL; // Initialize page object first

class cdatapenerimaan_delete extends cdatapenerimaan {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{EA1CE07B-E03E-4EC9-BC42-48D490D73F97}';

	// Table name
	var $TableName = 'datapenerimaan';

	// Page object name
	var $PageObjName = 'datapenerimaan_delete';

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

		// Table object (datapenerimaan)
		if (!isset($GLOBALS["datapenerimaan"]) || get_class($GLOBALS["datapenerimaan"]) == "cdatapenerimaan") {
			$GLOBALS["datapenerimaan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["datapenerimaan"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'datapenerimaan', TRUE);

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
		$this->replid->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->replid->Visible = FALSE;
		$this->nama->SetVisibility();
		$this->besar->SetVisibility();
		$this->idkategori->SetVisibility();
		$this->rekkas->SetVisibility();
		$this->rekpendapatan->SetVisibility();
		$this->rekpiutang->SetVisibility();
		$this->aktif->SetVisibility();
		$this->keterangan->SetVisibility();
		$this->departemen->SetVisibility();
		$this->info1->SetVisibility();
		$this->info2->SetVisibility();
		$this->info3->SetVisibility();
		$this->ts->SetVisibility();
		$this->token->SetVisibility();
		$this->issync->SetVisibility();

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
		global $EW_EXPORT, $datapenerimaan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($datapenerimaan);
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

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("datapenerimaanlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in datapenerimaan class, datapenerimaaninfo.php

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
				$this->Page_Terminate("datapenerimaanlist.php"); // Return to list
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
		$this->replid->setDbValue($row['replid']);
		$this->nama->setDbValue($row['nama']);
		$this->besar->setDbValue($row['besar']);
		$this->idkategori->setDbValue($row['idkategori']);
		$this->rekkas->setDbValue($row['rekkas']);
		$this->rekpendapatan->setDbValue($row['rekpendapatan']);
		$this->rekpiutang->setDbValue($row['rekpiutang']);
		$this->aktif->setDbValue($row['aktif']);
		$this->keterangan->setDbValue($row['keterangan']);
		$this->departemen->setDbValue($row['departemen']);
		$this->info1->setDbValue($row['info1']);
		$this->info2->setDbValue($row['info2']);
		$this->info3->setDbValue($row['info3']);
		$this->ts->setDbValue($row['ts']);
		$this->token->setDbValue($row['token']);
		$this->issync->setDbValue($row['issync']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['replid'] = NULL;
		$row['nama'] = NULL;
		$row['besar'] = NULL;
		$row['idkategori'] = NULL;
		$row['rekkas'] = NULL;
		$row['rekpendapatan'] = NULL;
		$row['rekpiutang'] = NULL;
		$row['aktif'] = NULL;
		$row['keterangan'] = NULL;
		$row['departemen'] = NULL;
		$row['info1'] = NULL;
		$row['info2'] = NULL;
		$row['info3'] = NULL;
		$row['ts'] = NULL;
		$row['token'] = NULL;
		$row['issync'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->replid->DbValue = $row['replid'];
		$this->nama->DbValue = $row['nama'];
		$this->besar->DbValue = $row['besar'];
		$this->idkategori->DbValue = $row['idkategori'];
		$this->rekkas->DbValue = $row['rekkas'];
		$this->rekpendapatan->DbValue = $row['rekpendapatan'];
		$this->rekpiutang->DbValue = $row['rekpiutang'];
		$this->aktif->DbValue = $row['aktif'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->departemen->DbValue = $row['departemen'];
		$this->info1->DbValue = $row['info1'];
		$this->info2->DbValue = $row['info2'];
		$this->info3->DbValue = $row['info3'];
		$this->ts->DbValue = $row['ts'];
		$this->token->DbValue = $row['token'];
		$this->issync->DbValue = $row['issync'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->besar->FormValue == $this->besar->CurrentValue && is_numeric(ew_StrToFloat($this->besar->CurrentValue)))
			$this->besar->CurrentValue = ew_StrToFloat($this->besar->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
				$sThisKey .= $row['replid'];
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("datapenerimaanlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($datapenerimaan_delete)) $datapenerimaan_delete = new cdatapenerimaan_delete();

// Page init
$datapenerimaan_delete->Page_Init();

// Page main
$datapenerimaan_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$datapenerimaan_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fdatapenerimaandelete = new ew_Form("fdatapenerimaandelete", "delete");

// Form_CustomValidate event
fdatapenerimaandelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fdatapenerimaandelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $datapenerimaan_delete->ShowPageHeader(); ?>
<?php
$datapenerimaan_delete->ShowMessage();
?>
<form name="fdatapenerimaandelete" id="fdatapenerimaandelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($datapenerimaan_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $datapenerimaan_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="datapenerimaan">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($datapenerimaan_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($datapenerimaan->replid->Visible) { // replid ?>
		<th class="<?php echo $datapenerimaan->replid->HeaderCellClass() ?>"><span id="elh_datapenerimaan_replid" class="datapenerimaan_replid"><?php echo $datapenerimaan->replid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->nama->Visible) { // nama ?>
		<th class="<?php echo $datapenerimaan->nama->HeaderCellClass() ?>"><span id="elh_datapenerimaan_nama" class="datapenerimaan_nama"><?php echo $datapenerimaan->nama->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->besar->Visible) { // besar ?>
		<th class="<?php echo $datapenerimaan->besar->HeaderCellClass() ?>"><span id="elh_datapenerimaan_besar" class="datapenerimaan_besar"><?php echo $datapenerimaan->besar->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->idkategori->Visible) { // idkategori ?>
		<th class="<?php echo $datapenerimaan->idkategori->HeaderCellClass() ?>"><span id="elh_datapenerimaan_idkategori" class="datapenerimaan_idkategori"><?php echo $datapenerimaan->idkategori->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->rekkas->Visible) { // rekkas ?>
		<th class="<?php echo $datapenerimaan->rekkas->HeaderCellClass() ?>"><span id="elh_datapenerimaan_rekkas" class="datapenerimaan_rekkas"><?php echo $datapenerimaan->rekkas->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->rekpendapatan->Visible) { // rekpendapatan ?>
		<th class="<?php echo $datapenerimaan->rekpendapatan->HeaderCellClass() ?>"><span id="elh_datapenerimaan_rekpendapatan" class="datapenerimaan_rekpendapatan"><?php echo $datapenerimaan->rekpendapatan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->rekpiutang->Visible) { // rekpiutang ?>
		<th class="<?php echo $datapenerimaan->rekpiutang->HeaderCellClass() ?>"><span id="elh_datapenerimaan_rekpiutang" class="datapenerimaan_rekpiutang"><?php echo $datapenerimaan->rekpiutang->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->aktif->Visible) { // aktif ?>
		<th class="<?php echo $datapenerimaan->aktif->HeaderCellClass() ?>"><span id="elh_datapenerimaan_aktif" class="datapenerimaan_aktif"><?php echo $datapenerimaan->aktif->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->keterangan->Visible) { // keterangan ?>
		<th class="<?php echo $datapenerimaan->keterangan->HeaderCellClass() ?>"><span id="elh_datapenerimaan_keterangan" class="datapenerimaan_keterangan"><?php echo $datapenerimaan->keterangan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->departemen->Visible) { // departemen ?>
		<th class="<?php echo $datapenerimaan->departemen->HeaderCellClass() ?>"><span id="elh_datapenerimaan_departemen" class="datapenerimaan_departemen"><?php echo $datapenerimaan->departemen->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->info1->Visible) { // info1 ?>
		<th class="<?php echo $datapenerimaan->info1->HeaderCellClass() ?>"><span id="elh_datapenerimaan_info1" class="datapenerimaan_info1"><?php echo $datapenerimaan->info1->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->info2->Visible) { // info2 ?>
		<th class="<?php echo $datapenerimaan->info2->HeaderCellClass() ?>"><span id="elh_datapenerimaan_info2" class="datapenerimaan_info2"><?php echo $datapenerimaan->info2->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->info3->Visible) { // info3 ?>
		<th class="<?php echo $datapenerimaan->info3->HeaderCellClass() ?>"><span id="elh_datapenerimaan_info3" class="datapenerimaan_info3"><?php echo $datapenerimaan->info3->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->ts->Visible) { // ts ?>
		<th class="<?php echo $datapenerimaan->ts->HeaderCellClass() ?>"><span id="elh_datapenerimaan_ts" class="datapenerimaan_ts"><?php echo $datapenerimaan->ts->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->token->Visible) { // token ?>
		<th class="<?php echo $datapenerimaan->token->HeaderCellClass() ?>"><span id="elh_datapenerimaan_token" class="datapenerimaan_token"><?php echo $datapenerimaan->token->FldCaption() ?></span></th>
<?php } ?>
<?php if ($datapenerimaan->issync->Visible) { // issync ?>
		<th class="<?php echo $datapenerimaan->issync->HeaderCellClass() ?>"><span id="elh_datapenerimaan_issync" class="datapenerimaan_issync"><?php echo $datapenerimaan->issync->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$datapenerimaan_delete->RecCnt = 0;
$i = 0;
while (!$datapenerimaan_delete->Recordset->EOF) {
	$datapenerimaan_delete->RecCnt++;
	$datapenerimaan_delete->RowCnt++;

	// Set row properties
	$datapenerimaan->ResetAttrs();
	$datapenerimaan->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$datapenerimaan_delete->LoadRowValues($datapenerimaan_delete->Recordset);

	// Render row
	$datapenerimaan_delete->RenderRow();
?>
	<tr<?php echo $datapenerimaan->RowAttributes() ?>>
<?php if ($datapenerimaan->replid->Visible) { // replid ?>
		<td<?php echo $datapenerimaan->replid->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_replid" class="datapenerimaan_replid">
<span<?php echo $datapenerimaan->replid->ViewAttributes() ?>>
<?php echo $datapenerimaan->replid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->nama->Visible) { // nama ?>
		<td<?php echo $datapenerimaan->nama->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_nama" class="datapenerimaan_nama">
<span<?php echo $datapenerimaan->nama->ViewAttributes() ?>>
<?php echo $datapenerimaan->nama->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->besar->Visible) { // besar ?>
		<td<?php echo $datapenerimaan->besar->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_besar" class="datapenerimaan_besar">
<span<?php echo $datapenerimaan->besar->ViewAttributes() ?>>
<?php echo $datapenerimaan->besar->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->idkategori->Visible) { // idkategori ?>
		<td<?php echo $datapenerimaan->idkategori->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_idkategori" class="datapenerimaan_idkategori">
<span<?php echo $datapenerimaan->idkategori->ViewAttributes() ?>>
<?php echo $datapenerimaan->idkategori->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->rekkas->Visible) { // rekkas ?>
		<td<?php echo $datapenerimaan->rekkas->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_rekkas" class="datapenerimaan_rekkas">
<span<?php echo $datapenerimaan->rekkas->ViewAttributes() ?>>
<?php echo $datapenerimaan->rekkas->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->rekpendapatan->Visible) { // rekpendapatan ?>
		<td<?php echo $datapenerimaan->rekpendapatan->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_rekpendapatan" class="datapenerimaan_rekpendapatan">
<span<?php echo $datapenerimaan->rekpendapatan->ViewAttributes() ?>>
<?php echo $datapenerimaan->rekpendapatan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->rekpiutang->Visible) { // rekpiutang ?>
		<td<?php echo $datapenerimaan->rekpiutang->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_rekpiutang" class="datapenerimaan_rekpiutang">
<span<?php echo $datapenerimaan->rekpiutang->ViewAttributes() ?>>
<?php echo $datapenerimaan->rekpiutang->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->aktif->Visible) { // aktif ?>
		<td<?php echo $datapenerimaan->aktif->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_aktif" class="datapenerimaan_aktif">
<span<?php echo $datapenerimaan->aktif->ViewAttributes() ?>>
<?php echo $datapenerimaan->aktif->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->keterangan->Visible) { // keterangan ?>
		<td<?php echo $datapenerimaan->keterangan->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_keterangan" class="datapenerimaan_keterangan">
<span<?php echo $datapenerimaan->keterangan->ViewAttributes() ?>>
<?php echo $datapenerimaan->keterangan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->departemen->Visible) { // departemen ?>
		<td<?php echo $datapenerimaan->departemen->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_departemen" class="datapenerimaan_departemen">
<span<?php echo $datapenerimaan->departemen->ViewAttributes() ?>>
<?php echo $datapenerimaan->departemen->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->info1->Visible) { // info1 ?>
		<td<?php echo $datapenerimaan->info1->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_info1" class="datapenerimaan_info1">
<span<?php echo $datapenerimaan->info1->ViewAttributes() ?>>
<?php echo $datapenerimaan->info1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->info2->Visible) { // info2 ?>
		<td<?php echo $datapenerimaan->info2->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_info2" class="datapenerimaan_info2">
<span<?php echo $datapenerimaan->info2->ViewAttributes() ?>>
<?php echo $datapenerimaan->info2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->info3->Visible) { // info3 ?>
		<td<?php echo $datapenerimaan->info3->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_info3" class="datapenerimaan_info3">
<span<?php echo $datapenerimaan->info3->ViewAttributes() ?>>
<?php echo $datapenerimaan->info3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->ts->Visible) { // ts ?>
		<td<?php echo $datapenerimaan->ts->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_ts" class="datapenerimaan_ts">
<span<?php echo $datapenerimaan->ts->ViewAttributes() ?>>
<?php echo $datapenerimaan->ts->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->token->Visible) { // token ?>
		<td<?php echo $datapenerimaan->token->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_token" class="datapenerimaan_token">
<span<?php echo $datapenerimaan->token->ViewAttributes() ?>>
<?php echo $datapenerimaan->token->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($datapenerimaan->issync->Visible) { // issync ?>
		<td<?php echo $datapenerimaan->issync->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_delete->RowCnt ?>_datapenerimaan_issync" class="datapenerimaan_issync">
<span<?php echo $datapenerimaan->issync->ViewAttributes() ?>>
<?php echo $datapenerimaan->issync->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$datapenerimaan_delete->Recordset->MoveNext();
}
$datapenerimaan_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $datapenerimaan_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fdatapenerimaandelete.Init();
</script>
<?php
$datapenerimaan_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$datapenerimaan_delete->Page_Terminate();
?>
