<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t01_penerimaaninfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t01_penerimaan_delete = NULL; // Initialize page object first

class ct01_penerimaan_delete extends ct01_penerimaan {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{EA1CE07B-E03E-4EC9-BC42-48D490D73F97}';

	// Table name
	var $TableName = 't01_penerimaan';

	// Page object name
	var $PageObjName = 't01_penerimaan_delete';

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

		// Table object (t01_penerimaan)
		if (!isset($GLOBALS["t01_penerimaan"]) || get_class($GLOBALS["t01_penerimaan"]) == "ct01_penerimaan") {
			$GLOBALS["t01_penerimaan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t01_penerimaan"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't01_penerimaan', TRUE);

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
		$this->Departemen->SetVisibility();
		$this->HeadDetail->SetVisibility();
		$this->NomorHead->SetVisibility();
		$this->SubTotalFlag->SetVisibility();
		$this->Urutan->SetVisibility();
		$this->Nomor->SetVisibility();
		$this->Pos->SetVisibility();
		$this->Nominal->SetVisibility();
		$this->JumlahSiswa->SetVisibility();
		$this->Bulan->SetVisibility();
		$this->Jumlah->SetVisibility();
		$this->Total->SetVisibility();

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
		global $EW_EXPORT, $t01_penerimaan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t01_penerimaan);
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
			$this->Page_Terminate("t01_penerimaanlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t01_penerimaan class, t01_penerimaaninfo.php

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
				$this->Page_Terminate("t01_penerimaanlist.php"); // Return to list
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
		$this->Departemen->setDbValue($row['Departemen']);
		$this->HeadDetail->setDbValue($row['HeadDetail']);
		$this->NomorHead->setDbValue($row['NomorHead']);
		$this->SubTotalFlag->setDbValue($row['SubTotalFlag']);
		$this->Urutan->setDbValue($row['Urutan']);
		$this->Nomor->setDbValue($row['Nomor']);
		$this->Pos->setDbValue($row['Pos']);
		$this->Nominal->setDbValue($row['Nominal']);
		$this->JumlahSiswa->setDbValue($row['JumlahSiswa']);
		$this->Bulan->setDbValue($row['Bulan']);
		$this->Jumlah->setDbValue($row['Jumlah']);
		$this->Total->setDbValue($row['Total']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['Departemen'] = NULL;
		$row['HeadDetail'] = NULL;
		$row['NomorHead'] = NULL;
		$row['SubTotalFlag'] = NULL;
		$row['Urutan'] = NULL;
		$row['Nomor'] = NULL;
		$row['Pos'] = NULL;
		$row['Nominal'] = NULL;
		$row['JumlahSiswa'] = NULL;
		$row['Bulan'] = NULL;
		$row['Jumlah'] = NULL;
		$row['Total'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->Departemen->DbValue = $row['Departemen'];
		$this->HeadDetail->DbValue = $row['HeadDetail'];
		$this->NomorHead->DbValue = $row['NomorHead'];
		$this->SubTotalFlag->DbValue = $row['SubTotalFlag'];
		$this->Urutan->DbValue = $row['Urutan'];
		$this->Nomor->DbValue = $row['Nomor'];
		$this->Pos->DbValue = $row['Pos'];
		$this->Nominal->DbValue = $row['Nominal'];
		$this->JumlahSiswa->DbValue = $row['JumlahSiswa'];
		$this->Bulan->DbValue = $row['Bulan'];
		$this->Jumlah->DbValue = $row['Jumlah'];
		$this->Total->DbValue = $row['Total'];
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

		// Convert decimal values if posted back
		if ($this->Total->FormValue == $this->Total->CurrentValue && is_numeric(ew_StrToFloat($this->Total->CurrentValue)))
			$this->Total->CurrentValue = ew_StrToFloat($this->Total->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t01_penerimaanlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t01_penerimaan_delete)) $t01_penerimaan_delete = new ct01_penerimaan_delete();

// Page init
$t01_penerimaan_delete->Page_Init();

// Page main
$t01_penerimaan_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t01_penerimaan_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft01_penerimaandelete = new ew_Form("ft01_penerimaandelete", "delete");

// Form_CustomValidate event
ft01_penerimaandelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft01_penerimaandelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft01_penerimaandelete.Lists["x_Departemen"] = {"LinkField":"x_departemen","Ajax":true,"AutoFill":false,"DisplayFields":["x_departemen","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departemen"};
ft01_penerimaandelete.Lists["x_Departemen"].Data = "<?php echo $t01_penerimaan_delete->Departemen->LookupFilterQuery(FALSE, "delete") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t01_penerimaan_delete->ShowPageHeader(); ?>
<?php
$t01_penerimaan_delete->ShowMessage();
?>
<form name="ft01_penerimaandelete" id="ft01_penerimaandelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t01_penerimaan_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t01_penerimaan_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t01_penerimaan">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t01_penerimaan_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($t01_penerimaan->Departemen->Visible) { // Departemen ?>
		<th class="<?php echo $t01_penerimaan->Departemen->HeaderCellClass() ?>"><span id="elh_t01_penerimaan_Departemen" class="t01_penerimaan_Departemen"><?php echo $t01_penerimaan->Departemen->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_penerimaan->HeadDetail->Visible) { // HeadDetail ?>
		<th class="<?php echo $t01_penerimaan->HeadDetail->HeaderCellClass() ?>"><span id="elh_t01_penerimaan_HeadDetail" class="t01_penerimaan_HeadDetail"><?php echo $t01_penerimaan->HeadDetail->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_penerimaan->NomorHead->Visible) { // NomorHead ?>
		<th class="<?php echo $t01_penerimaan->NomorHead->HeaderCellClass() ?>"><span id="elh_t01_penerimaan_NomorHead" class="t01_penerimaan_NomorHead"><?php echo $t01_penerimaan->NomorHead->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_penerimaan->SubTotalFlag->Visible) { // SubTotalFlag ?>
		<th class="<?php echo $t01_penerimaan->SubTotalFlag->HeaderCellClass() ?>"><span id="elh_t01_penerimaan_SubTotalFlag" class="t01_penerimaan_SubTotalFlag"><?php echo $t01_penerimaan->SubTotalFlag->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_penerimaan->Urutan->Visible) { // Urutan ?>
		<th class="<?php echo $t01_penerimaan->Urutan->HeaderCellClass() ?>"><span id="elh_t01_penerimaan_Urutan" class="t01_penerimaan_Urutan"><?php echo $t01_penerimaan->Urutan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_penerimaan->Nomor->Visible) { // Nomor ?>
		<th class="<?php echo $t01_penerimaan->Nomor->HeaderCellClass() ?>"><span id="elh_t01_penerimaan_Nomor" class="t01_penerimaan_Nomor"><?php echo $t01_penerimaan->Nomor->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_penerimaan->Pos->Visible) { // Pos ?>
		<th class="<?php echo $t01_penerimaan->Pos->HeaderCellClass() ?>"><span id="elh_t01_penerimaan_Pos" class="t01_penerimaan_Pos"><?php echo $t01_penerimaan->Pos->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_penerimaan->Nominal->Visible) { // Nominal ?>
		<th class="<?php echo $t01_penerimaan->Nominal->HeaderCellClass() ?>"><span id="elh_t01_penerimaan_Nominal" class="t01_penerimaan_Nominal"><?php echo $t01_penerimaan->Nominal->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_penerimaan->JumlahSiswa->Visible) { // JumlahSiswa ?>
		<th class="<?php echo $t01_penerimaan->JumlahSiswa->HeaderCellClass() ?>"><span id="elh_t01_penerimaan_JumlahSiswa" class="t01_penerimaan_JumlahSiswa"><?php echo $t01_penerimaan->JumlahSiswa->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_penerimaan->Bulan->Visible) { // Bulan ?>
		<th class="<?php echo $t01_penerimaan->Bulan->HeaderCellClass() ?>"><span id="elh_t01_penerimaan_Bulan" class="t01_penerimaan_Bulan"><?php echo $t01_penerimaan->Bulan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_penerimaan->Jumlah->Visible) { // Jumlah ?>
		<th class="<?php echo $t01_penerimaan->Jumlah->HeaderCellClass() ?>"><span id="elh_t01_penerimaan_Jumlah" class="t01_penerimaan_Jumlah"><?php echo $t01_penerimaan->Jumlah->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_penerimaan->Total->Visible) { // Total ?>
		<th class="<?php echo $t01_penerimaan->Total->HeaderCellClass() ?>"><span id="elh_t01_penerimaan_Total" class="t01_penerimaan_Total"><?php echo $t01_penerimaan->Total->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t01_penerimaan_delete->RecCnt = 0;
$i = 0;
while (!$t01_penerimaan_delete->Recordset->EOF) {
	$t01_penerimaan_delete->RecCnt++;
	$t01_penerimaan_delete->RowCnt++;

	// Set row properties
	$t01_penerimaan->ResetAttrs();
	$t01_penerimaan->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t01_penerimaan_delete->LoadRowValues($t01_penerimaan_delete->Recordset);

	// Render row
	$t01_penerimaan_delete->RenderRow();
?>
	<tr<?php echo $t01_penerimaan->RowAttributes() ?>>
<?php if ($t01_penerimaan->Departemen->Visible) { // Departemen ?>
		<td<?php echo $t01_penerimaan->Departemen->CellAttributes() ?>>
<span id="el<?php echo $t01_penerimaan_delete->RowCnt ?>_t01_penerimaan_Departemen" class="t01_penerimaan_Departemen">
<span<?php echo $t01_penerimaan->Departemen->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Departemen->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_penerimaan->HeadDetail->Visible) { // HeadDetail ?>
		<td<?php echo $t01_penerimaan->HeadDetail->CellAttributes() ?>>
<span id="el<?php echo $t01_penerimaan_delete->RowCnt ?>_t01_penerimaan_HeadDetail" class="t01_penerimaan_HeadDetail">
<span<?php echo $t01_penerimaan->HeadDetail->ViewAttributes() ?>>
<?php echo $t01_penerimaan->HeadDetail->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_penerimaan->NomorHead->Visible) { // NomorHead ?>
		<td<?php echo $t01_penerimaan->NomorHead->CellAttributes() ?>>
<span id="el<?php echo $t01_penerimaan_delete->RowCnt ?>_t01_penerimaan_NomorHead" class="t01_penerimaan_NomorHead">
<span<?php echo $t01_penerimaan->NomorHead->ViewAttributes() ?>>
<?php echo $t01_penerimaan->NomorHead->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_penerimaan->SubTotalFlag->Visible) { // SubTotalFlag ?>
		<td<?php echo $t01_penerimaan->SubTotalFlag->CellAttributes() ?>>
<span id="el<?php echo $t01_penerimaan_delete->RowCnt ?>_t01_penerimaan_SubTotalFlag" class="t01_penerimaan_SubTotalFlag">
<span<?php echo $t01_penerimaan->SubTotalFlag->ViewAttributes() ?>>
<?php echo $t01_penerimaan->SubTotalFlag->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_penerimaan->Urutan->Visible) { // Urutan ?>
		<td<?php echo $t01_penerimaan->Urutan->CellAttributes() ?>>
<span id="el<?php echo $t01_penerimaan_delete->RowCnt ?>_t01_penerimaan_Urutan" class="t01_penerimaan_Urutan">
<span<?php echo $t01_penerimaan->Urutan->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Urutan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_penerimaan->Nomor->Visible) { // Nomor ?>
		<td<?php echo $t01_penerimaan->Nomor->CellAttributes() ?>>
<span id="el<?php echo $t01_penerimaan_delete->RowCnt ?>_t01_penerimaan_Nomor" class="t01_penerimaan_Nomor">
<span<?php echo $t01_penerimaan->Nomor->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Nomor->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_penerimaan->Pos->Visible) { // Pos ?>
		<td<?php echo $t01_penerimaan->Pos->CellAttributes() ?>>
<span id="el<?php echo $t01_penerimaan_delete->RowCnt ?>_t01_penerimaan_Pos" class="t01_penerimaan_Pos">
<span<?php echo $t01_penerimaan->Pos->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Pos->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_penerimaan->Nominal->Visible) { // Nominal ?>
		<td<?php echo $t01_penerimaan->Nominal->CellAttributes() ?>>
<span id="el<?php echo $t01_penerimaan_delete->RowCnt ?>_t01_penerimaan_Nominal" class="t01_penerimaan_Nominal">
<span<?php echo $t01_penerimaan->Nominal->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Nominal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_penerimaan->JumlahSiswa->Visible) { // JumlahSiswa ?>
		<td<?php echo $t01_penerimaan->JumlahSiswa->CellAttributes() ?>>
<span id="el<?php echo $t01_penerimaan_delete->RowCnt ?>_t01_penerimaan_JumlahSiswa" class="t01_penerimaan_JumlahSiswa">
<span<?php echo $t01_penerimaan->JumlahSiswa->ViewAttributes() ?>>
<?php echo $t01_penerimaan->JumlahSiswa->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_penerimaan->Bulan->Visible) { // Bulan ?>
		<td<?php echo $t01_penerimaan->Bulan->CellAttributes() ?>>
<span id="el<?php echo $t01_penerimaan_delete->RowCnt ?>_t01_penerimaan_Bulan" class="t01_penerimaan_Bulan">
<span<?php echo $t01_penerimaan->Bulan->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Bulan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_penerimaan->Jumlah->Visible) { // Jumlah ?>
		<td<?php echo $t01_penerimaan->Jumlah->CellAttributes() ?>>
<span id="el<?php echo $t01_penerimaan_delete->RowCnt ?>_t01_penerimaan_Jumlah" class="t01_penerimaan_Jumlah">
<span<?php echo $t01_penerimaan->Jumlah->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Jumlah->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_penerimaan->Total->Visible) { // Total ?>
		<td<?php echo $t01_penerimaan->Total->CellAttributes() ?>>
<span id="el<?php echo $t01_penerimaan_delete->RowCnt ?>_t01_penerimaan_Total" class="t01_penerimaan_Total">
<span<?php echo $t01_penerimaan->Total->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Total->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t01_penerimaan_delete->Recordset->MoveNext();
}
$t01_penerimaan_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t01_penerimaan_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft01_penerimaandelete.Init();
</script>
<?php
$t01_penerimaan_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t01_penerimaan_delete->Page_Terminate();
?>
