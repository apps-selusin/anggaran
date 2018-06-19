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

$t01_penerimaan_edit = NULL; // Initialize page object first

class ct01_penerimaan_edit extends ct01_penerimaan {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{EA1CE07B-E03E-4EC9-BC42-48D490D73F97}';

	// Table name
	var $TableName = 't01_penerimaan';

	// Page object name
	var $PageObjName = 't01_penerimaan_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "t01_penerimaanview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_id")) {
				$this->id->setFormValue($objForm->GetValue("x_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["id"])) {
				$this->id->setQueryStringValue($_GET["id"]);
				$loadByQuery = TRUE;
			} else {
				$this->id->CurrentValue = NULL;
			}
		}

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("t01_penerimaanlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t01_penerimaanlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->Departemen->FldIsDetailKey) {
			$this->Departemen->setFormValue($objForm->GetValue("x_Departemen"));
		}
		if (!$this->HeadDetail->FldIsDetailKey) {
			$this->HeadDetail->setFormValue($objForm->GetValue("x_HeadDetail"));
		}
		if (!$this->NomorHead->FldIsDetailKey) {
			$this->NomorHead->setFormValue($objForm->GetValue("x_NomorHead"));
		}
		if (!$this->SubTotalFlag->FldIsDetailKey) {
			$this->SubTotalFlag->setFormValue($objForm->GetValue("x_SubTotalFlag"));
		}
		if (!$this->Urutan->FldIsDetailKey) {
			$this->Urutan->setFormValue($objForm->GetValue("x_Urutan"));
		}
		if (!$this->Nomor->FldIsDetailKey) {
			$this->Nomor->setFormValue($objForm->GetValue("x_Nomor"));
		}
		if (!$this->Pos->FldIsDetailKey) {
			$this->Pos->setFormValue($objForm->GetValue("x_Pos"));
		}
		if (!$this->Nominal->FldIsDetailKey) {
			$this->Nominal->setFormValue($objForm->GetValue("x_Nominal"));
		}
		if (!$this->JumlahSiswa->FldIsDetailKey) {
			$this->JumlahSiswa->setFormValue($objForm->GetValue("x_JumlahSiswa"));
		}
		if (!$this->Bulan->FldIsDetailKey) {
			$this->Bulan->setFormValue($objForm->GetValue("x_Bulan"));
		}
		if (!$this->Jumlah->FldIsDetailKey) {
			$this->Jumlah->setFormValue($objForm->GetValue("x_Jumlah"));
		}
		if (!$this->Total->FldIsDetailKey) {
			$this->Total->setFormValue($objForm->GetValue("x_Total"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
		$this->Departemen->CurrentValue = $this->Departemen->FormValue;
		$this->HeadDetail->CurrentValue = $this->HeadDetail->FormValue;
		$this->NomorHead->CurrentValue = $this->NomorHead->FormValue;
		$this->SubTotalFlag->CurrentValue = $this->SubTotalFlag->FormValue;
		$this->Urutan->CurrentValue = $this->Urutan->FormValue;
		$this->Nomor->CurrentValue = $this->Nomor->FormValue;
		$this->Pos->CurrentValue = $this->Pos->FormValue;
		$this->Nominal->CurrentValue = $this->Nominal->FormValue;
		$this->JumlahSiswa->CurrentValue = $this->JumlahSiswa->FormValue;
		$this->Bulan->CurrentValue = $this->Bulan->FormValue;
		$this->Jumlah->CurrentValue = $this->Jumlah->FormValue;
		$this->Total->CurrentValue = $this->Total->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// Departemen
			$this->Departemen->EditAttrs["class"] = "form-control";
			$this->Departemen->EditCustomAttributes = "";
			if (trim(strval($this->Departemen->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`departemen`" . ew_SearchString("=", $this->Departemen->CurrentValue, EW_DATATYPE_STRING, "jbsakad");
			}
			$sSqlWrk = "SELECT `departemen`, `departemen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `departemen`";
			$sWhereWrk = "";
			$this->Departemen->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Departemen, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `departemen` ASC";
			$rswrk = Conn("jbsakad")->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Departemen->EditValue = $arwrk;

			// HeadDetail
			$this->HeadDetail->EditAttrs["class"] = "form-control";
			$this->HeadDetail->EditCustomAttributes = "";
			$this->HeadDetail->EditValue = ew_HtmlEncode($this->HeadDetail->CurrentValue);
			$this->HeadDetail->PlaceHolder = ew_RemoveHtml($this->HeadDetail->FldCaption());

			// NomorHead
			$this->NomorHead->EditAttrs["class"] = "form-control";
			$this->NomorHead->EditCustomAttributes = "";
			$this->NomorHead->EditValue = ew_HtmlEncode($this->NomorHead->CurrentValue);
			$this->NomorHead->PlaceHolder = ew_RemoveHtml($this->NomorHead->FldCaption());

			// SubTotalFlag
			$this->SubTotalFlag->EditAttrs["class"] = "form-control";
			$this->SubTotalFlag->EditCustomAttributes = "";
			$this->SubTotalFlag->EditValue = ew_HtmlEncode($this->SubTotalFlag->CurrentValue);
			$this->SubTotalFlag->PlaceHolder = ew_RemoveHtml($this->SubTotalFlag->FldCaption());

			// Urutan
			$this->Urutan->EditAttrs["class"] = "form-control";
			$this->Urutan->EditCustomAttributes = "";
			$this->Urutan->EditValue = ew_HtmlEncode($this->Urutan->CurrentValue);
			$this->Urutan->PlaceHolder = ew_RemoveHtml($this->Urutan->FldCaption());

			// Nomor
			$this->Nomor->EditAttrs["class"] = "form-control";
			$this->Nomor->EditCustomAttributes = "";
			$this->Nomor->EditValue = ew_HtmlEncode($this->Nomor->CurrentValue);
			$this->Nomor->PlaceHolder = ew_RemoveHtml($this->Nomor->FldCaption());

			// Pos
			$this->Pos->EditAttrs["class"] = "form-control";
			$this->Pos->EditCustomAttributes = "";
			$this->Pos->EditValue = ew_HtmlEncode($this->Pos->CurrentValue);
			$this->Pos->PlaceHolder = ew_RemoveHtml($this->Pos->FldCaption());

			// Nominal
			$this->Nominal->EditAttrs["class"] = "form-control";
			$this->Nominal->EditCustomAttributes = "";
			$this->Nominal->EditValue = ew_HtmlEncode($this->Nominal->CurrentValue);
			$this->Nominal->PlaceHolder = ew_RemoveHtml($this->Nominal->FldCaption());
			if (strval($this->Nominal->EditValue) <> "" && is_numeric($this->Nominal->EditValue)) $this->Nominal->EditValue = ew_FormatNumber($this->Nominal->EditValue, -2, -1, -2, 0);

			// JumlahSiswa
			$this->JumlahSiswa->EditAttrs["class"] = "form-control";
			$this->JumlahSiswa->EditCustomAttributes = "";
			$this->JumlahSiswa->EditValue = ew_HtmlEncode($this->JumlahSiswa->CurrentValue);
			$this->JumlahSiswa->PlaceHolder = ew_RemoveHtml($this->JumlahSiswa->FldCaption());

			// Bulan
			$this->Bulan->EditAttrs["class"] = "form-control";
			$this->Bulan->EditCustomAttributes = "";
			$this->Bulan->EditValue = ew_HtmlEncode($this->Bulan->CurrentValue);
			$this->Bulan->PlaceHolder = ew_RemoveHtml($this->Bulan->FldCaption());

			// Jumlah
			$this->Jumlah->EditAttrs["class"] = "form-control";
			$this->Jumlah->EditCustomAttributes = "";
			$this->Jumlah->EditValue = ew_HtmlEncode($this->Jumlah->CurrentValue);
			$this->Jumlah->PlaceHolder = ew_RemoveHtml($this->Jumlah->FldCaption());
			if (strval($this->Jumlah->EditValue) <> "" && is_numeric($this->Jumlah->EditValue)) $this->Jumlah->EditValue = ew_FormatNumber($this->Jumlah->EditValue, -2, -1, -2, 0);

			// Total
			$this->Total->EditAttrs["class"] = "form-control";
			$this->Total->EditCustomAttributes = "";
			$this->Total->EditValue = ew_HtmlEncode($this->Total->CurrentValue);
			$this->Total->PlaceHolder = ew_RemoveHtml($this->Total->FldCaption());
			if (strval($this->Total->EditValue) <> "" && is_numeric($this->Total->EditValue)) $this->Total->EditValue = ew_FormatNumber($this->Total->EditValue, -2, -1, -2, 0);

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// Departemen
			$this->Departemen->LinkCustomAttributes = "";
			$this->Departemen->HrefValue = "";

			// HeadDetail
			$this->HeadDetail->LinkCustomAttributes = "";
			$this->HeadDetail->HrefValue = "";

			// NomorHead
			$this->NomorHead->LinkCustomAttributes = "";
			$this->NomorHead->HrefValue = "";

			// SubTotalFlag
			$this->SubTotalFlag->LinkCustomAttributes = "";
			$this->SubTotalFlag->HrefValue = "";

			// Urutan
			$this->Urutan->LinkCustomAttributes = "";
			$this->Urutan->HrefValue = "";

			// Nomor
			$this->Nomor->LinkCustomAttributes = "";
			$this->Nomor->HrefValue = "";

			// Pos
			$this->Pos->LinkCustomAttributes = "";
			$this->Pos->HrefValue = "";

			// Nominal
			$this->Nominal->LinkCustomAttributes = "";
			$this->Nominal->HrefValue = "";

			// JumlahSiswa
			$this->JumlahSiswa->LinkCustomAttributes = "";
			$this->JumlahSiswa->HrefValue = "";

			// Bulan
			$this->Bulan->LinkCustomAttributes = "";
			$this->Bulan->HrefValue = "";

			// Jumlah
			$this->Jumlah->LinkCustomAttributes = "";
			$this->Jumlah->HrefValue = "";

			// Total
			$this->Total->LinkCustomAttributes = "";
			$this->Total->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->HeadDetail->FldIsDetailKey && !is_null($this->HeadDetail->FormValue) && $this->HeadDetail->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->HeadDetail->FldCaption(), $this->HeadDetail->ReqErrMsg));
		}
		if (!$this->NomorHead->FldIsDetailKey && !is_null($this->NomorHead->FormValue) && $this->NomorHead->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NomorHead->FldCaption(), $this->NomorHead->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->NomorHead->FormValue)) {
			ew_AddMessage($gsFormError, $this->NomorHead->FldErrMsg());
		}
		if (!$this->SubTotalFlag->FldIsDetailKey && !is_null($this->SubTotalFlag->FormValue) && $this->SubTotalFlag->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->SubTotalFlag->FldCaption(), $this->SubTotalFlag->ReqErrMsg));
		}
		if (!$this->Urutan->FldIsDetailKey && !is_null($this->Urutan->FormValue) && $this->Urutan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Urutan->FldCaption(), $this->Urutan->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Urutan->FormValue)) {
			ew_AddMessage($gsFormError, $this->Urutan->FldErrMsg());
		}
		if (!$this->Nomor->FldIsDetailKey && !is_null($this->Nomor->FormValue) && $this->Nomor->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nomor->FldCaption(), $this->Nomor->ReqErrMsg));
		}
		if (!$this->Pos->FldIsDetailKey && !is_null($this->Pos->FormValue) && $this->Pos->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Pos->FldCaption(), $this->Pos->ReqErrMsg));
		}
		if (!$this->Nominal->FldIsDetailKey && !is_null($this->Nominal->FormValue) && $this->Nominal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nominal->FldCaption(), $this->Nominal->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Nominal->FormValue)) {
			ew_AddMessage($gsFormError, $this->Nominal->FldErrMsg());
		}
		if (!$this->JumlahSiswa->FldIsDetailKey && !is_null($this->JumlahSiswa->FormValue) && $this->JumlahSiswa->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->JumlahSiswa->FldCaption(), $this->JumlahSiswa->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->JumlahSiswa->FormValue)) {
			ew_AddMessage($gsFormError, $this->JumlahSiswa->FldErrMsg());
		}
		if (!$this->Bulan->FldIsDetailKey && !is_null($this->Bulan->FormValue) && $this->Bulan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Bulan->FldCaption(), $this->Bulan->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Bulan->FormValue)) {
			ew_AddMessage($gsFormError, $this->Bulan->FldErrMsg());
		}
		if (!$this->Jumlah->FldIsDetailKey && !is_null($this->Jumlah->FormValue) && $this->Jumlah->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Jumlah->FldCaption(), $this->Jumlah->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Jumlah->FormValue)) {
			ew_AddMessage($gsFormError, $this->Jumlah->FldErrMsg());
		}
		if (!$this->Total->FldIsDetailKey && !is_null($this->Total->FormValue) && $this->Total->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Total->FldCaption(), $this->Total->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Total->FormValue)) {
			ew_AddMessage($gsFormError, $this->Total->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// Departemen
			$this->Departemen->SetDbValueDef($rsnew, $this->Departemen->CurrentValue, "", $this->Departemen->ReadOnly);

			// HeadDetail
			$this->HeadDetail->SetDbValueDef($rsnew, $this->HeadDetail->CurrentValue, "", $this->HeadDetail->ReadOnly);

			// NomorHead
			$this->NomorHead->SetDbValueDef($rsnew, $this->NomorHead->CurrentValue, 0, $this->NomorHead->ReadOnly);

			// SubTotalFlag
			$this->SubTotalFlag->SetDbValueDef($rsnew, $this->SubTotalFlag->CurrentValue, "", $this->SubTotalFlag->ReadOnly);

			// Urutan
			$this->Urutan->SetDbValueDef($rsnew, $this->Urutan->CurrentValue, 0, $this->Urutan->ReadOnly);

			// Nomor
			$this->Nomor->SetDbValueDef($rsnew, $this->Nomor->CurrentValue, "", $this->Nomor->ReadOnly);

			// Pos
			$this->Pos->SetDbValueDef($rsnew, $this->Pos->CurrentValue, "", $this->Pos->ReadOnly);

			// Nominal
			$this->Nominal->SetDbValueDef($rsnew, $this->Nominal->CurrentValue, 0, $this->Nominal->ReadOnly);

			// JumlahSiswa
			$this->JumlahSiswa->SetDbValueDef($rsnew, $this->JumlahSiswa->CurrentValue, 0, $this->JumlahSiswa->ReadOnly);

			// Bulan
			$this->Bulan->SetDbValueDef($rsnew, $this->Bulan->CurrentValue, 0, $this->Bulan->ReadOnly);

			// Jumlah
			$this->Jumlah->SetDbValueDef($rsnew, $this->Jumlah->CurrentValue, 0, $this->Jumlah->ReadOnly);

			// Total
			$this->Total->SetDbValueDef($rsnew, $this->Total->CurrentValue, 0, $this->Total->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t01_penerimaanlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Departemen":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `departemen` AS `LinkFld`, `departemen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `departemen`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "jbsakad", "f0" => '`departemen` IN ({filter_value})', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Departemen, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `departemen` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t01_penerimaan_edit)) $t01_penerimaan_edit = new ct01_penerimaan_edit();

// Page init
$t01_penerimaan_edit->Page_Init();

// Page main
$t01_penerimaan_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t01_penerimaan_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft01_penerimaanedit = new ew_Form("ft01_penerimaanedit", "edit");

// Validate form
ft01_penerimaanedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_HeadDetail");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_penerimaan->HeadDetail->FldCaption(), $t01_penerimaan->HeadDetail->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NomorHead");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_penerimaan->NomorHead->FldCaption(), $t01_penerimaan->NomorHead->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NomorHead");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->NomorHead->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_SubTotalFlag");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_penerimaan->SubTotalFlag->FldCaption(), $t01_penerimaan->SubTotalFlag->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Urutan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_penerimaan->Urutan->FldCaption(), $t01_penerimaan->Urutan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Urutan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->Urutan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Nomor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_penerimaan->Nomor->FldCaption(), $t01_penerimaan->Nomor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Pos");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_penerimaan->Pos->FldCaption(), $t01_penerimaan->Pos->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nominal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_penerimaan->Nominal->FldCaption(), $t01_penerimaan->Nominal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nominal");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->Nominal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_JumlahSiswa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_penerimaan->JumlahSiswa->FldCaption(), $t01_penerimaan->JumlahSiswa->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_JumlahSiswa");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->JumlahSiswa->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Bulan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_penerimaan->Bulan->FldCaption(), $t01_penerimaan->Bulan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Bulan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->Bulan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Jumlah");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_penerimaan->Jumlah->FldCaption(), $t01_penerimaan->Jumlah->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->Jumlah->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Total");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_penerimaan->Total->FldCaption(), $t01_penerimaan->Total->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Total");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->Total->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ft01_penerimaanedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft01_penerimaanedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft01_penerimaanedit.Lists["x_Departemen"] = {"LinkField":"x_departemen","Ajax":true,"AutoFill":false,"DisplayFields":["x_departemen","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departemen"};
ft01_penerimaanedit.Lists["x_Departemen"].Data = "<?php echo $t01_penerimaan_edit->Departemen->LookupFilterQuery(FALSE, "edit") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t01_penerimaan_edit->ShowPageHeader(); ?>
<?php
$t01_penerimaan_edit->ShowMessage();
?>
<form name="ft01_penerimaanedit" id="ft01_penerimaanedit" class="<?php echo $t01_penerimaan_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t01_penerimaan_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t01_penerimaan_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t01_penerimaan">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($t01_penerimaan_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($t01_penerimaan->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_t01_penerimaan_id" class="<?php echo $t01_penerimaan_edit->LeftColumnClass ?>"><?php echo $t01_penerimaan->id->FldCaption() ?></label>
		<div class="<?php echo $t01_penerimaan_edit->RightColumnClass ?>"><div<?php echo $t01_penerimaan->id->CellAttributes() ?>>
<span id="el_t01_penerimaan_id">
<span<?php echo $t01_penerimaan->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t01_penerimaan->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($t01_penerimaan->id->CurrentValue) ?>">
<?php echo $t01_penerimaan->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Departemen->Visible) { // Departemen ?>
	<div id="r_Departemen" class="form-group">
		<label id="elh_t01_penerimaan_Departemen" for="x_Departemen" class="<?php echo $t01_penerimaan_edit->LeftColumnClass ?>"><?php echo $t01_penerimaan->Departemen->FldCaption() ?></label>
		<div class="<?php echo $t01_penerimaan_edit->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Departemen->CellAttributes() ?>>
<span id="el_t01_penerimaan_Departemen">
<select data-table="t01_penerimaan" data-field="x_Departemen" data-value-separator="<?php echo $t01_penerimaan->Departemen->DisplayValueSeparatorAttribute() ?>" id="x_Departemen" name="x_Departemen"<?php echo $t01_penerimaan->Departemen->EditAttributes() ?>>
<?php echo $t01_penerimaan->Departemen->SelectOptionListHtml("x_Departemen") ?>
</select>
</span>
<?php echo $t01_penerimaan->Departemen->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->HeadDetail->Visible) { // HeadDetail ?>
	<div id="r_HeadDetail" class="form-group">
		<label id="elh_t01_penerimaan_HeadDetail" for="x_HeadDetail" class="<?php echo $t01_penerimaan_edit->LeftColumnClass ?>"><?php echo $t01_penerimaan->HeadDetail->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_penerimaan_edit->RightColumnClass ?>"><div<?php echo $t01_penerimaan->HeadDetail->CellAttributes() ?>>
<span id="el_t01_penerimaan_HeadDetail">
<input type="text" data-table="t01_penerimaan" data-field="x_HeadDetail" name="x_HeadDetail" id="x_HeadDetail" size="1" maxlength="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->HeadDetail->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->HeadDetail->EditValue ?>"<?php echo $t01_penerimaan->HeadDetail->EditAttributes() ?>>
</span>
<?php echo $t01_penerimaan->HeadDetail->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->NomorHead->Visible) { // NomorHead ?>
	<div id="r_NomorHead" class="form-group">
		<label id="elh_t01_penerimaan_NomorHead" for="x_NomorHead" class="<?php echo $t01_penerimaan_edit->LeftColumnClass ?>"><?php echo $t01_penerimaan->NomorHead->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_penerimaan_edit->RightColumnClass ?>"><div<?php echo $t01_penerimaan->NomorHead->CellAttributes() ?>>
<span id="el_t01_penerimaan_NomorHead">
<input type="text" data-table="t01_penerimaan" data-field="x_NomorHead" name="x_NomorHead" id="x_NomorHead" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->NomorHead->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->NomorHead->EditValue ?>"<?php echo $t01_penerimaan->NomorHead->EditAttributes() ?>>
</span>
<?php echo $t01_penerimaan->NomorHead->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->SubTotalFlag->Visible) { // SubTotalFlag ?>
	<div id="r_SubTotalFlag" class="form-group">
		<label id="elh_t01_penerimaan_SubTotalFlag" for="x_SubTotalFlag" class="<?php echo $t01_penerimaan_edit->LeftColumnClass ?>"><?php echo $t01_penerimaan->SubTotalFlag->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_penerimaan_edit->RightColumnClass ?>"><div<?php echo $t01_penerimaan->SubTotalFlag->CellAttributes() ?>>
<span id="el_t01_penerimaan_SubTotalFlag">
<input type="text" data-table="t01_penerimaan" data-field="x_SubTotalFlag" name="x_SubTotalFlag" id="x_SubTotalFlag" size="1" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->SubTotalFlag->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->SubTotalFlag->EditValue ?>"<?php echo $t01_penerimaan->SubTotalFlag->EditAttributes() ?>>
</span>
<?php echo $t01_penerimaan->SubTotalFlag->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Urutan->Visible) { // Urutan ?>
	<div id="r_Urutan" class="form-group">
		<label id="elh_t01_penerimaan_Urutan" for="x_Urutan" class="<?php echo $t01_penerimaan_edit->LeftColumnClass ?>"><?php echo $t01_penerimaan->Urutan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_penerimaan_edit->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Urutan->CellAttributes() ?>>
<span id="el_t01_penerimaan_Urutan">
<input type="text" data-table="t01_penerimaan" data-field="x_Urutan" name="x_Urutan" id="x_Urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Urutan->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Urutan->EditValue ?>"<?php echo $t01_penerimaan->Urutan->EditAttributes() ?>>
</span>
<?php echo $t01_penerimaan->Urutan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Nomor->Visible) { // Nomor ?>
	<div id="r_Nomor" class="form-group">
		<label id="elh_t01_penerimaan_Nomor" for="x_Nomor" class="<?php echo $t01_penerimaan_edit->LeftColumnClass ?>"><?php echo $t01_penerimaan->Nomor->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_penerimaan_edit->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Nomor->CellAttributes() ?>>
<span id="el_t01_penerimaan_Nomor">
<input type="text" data-table="t01_penerimaan" data-field="x_Nomor" name="x_Nomor" id="x_Nomor" size="1" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Nomor->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Nomor->EditValue ?>"<?php echo $t01_penerimaan->Nomor->EditAttributes() ?>>
</span>
<?php echo $t01_penerimaan->Nomor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Pos->Visible) { // Pos ?>
	<div id="r_Pos" class="form-group">
		<label id="elh_t01_penerimaan_Pos" for="x_Pos" class="<?php echo $t01_penerimaan_edit->LeftColumnClass ?>"><?php echo $t01_penerimaan->Pos->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_penerimaan_edit->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Pos->CellAttributes() ?>>
<span id="el_t01_penerimaan_Pos">
<input type="text" data-table="t01_penerimaan" data-field="x_Pos" name="x_Pos" id="x_Pos" size="15" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Pos->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Pos->EditValue ?>"<?php echo $t01_penerimaan->Pos->EditAttributes() ?>>
</span>
<?php echo $t01_penerimaan->Pos->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Nominal->Visible) { // Nominal ?>
	<div id="r_Nominal" class="form-group">
		<label id="elh_t01_penerimaan_Nominal" for="x_Nominal" class="<?php echo $t01_penerimaan_edit->LeftColumnClass ?>"><?php echo $t01_penerimaan->Nominal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_penerimaan_edit->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Nominal->CellAttributes() ?>>
<span id="el_t01_penerimaan_Nominal">
<input type="text" data-table="t01_penerimaan" data-field="x_Nominal" name="x_Nominal" id="x_Nominal" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Nominal->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Nominal->EditValue ?>"<?php echo $t01_penerimaan->Nominal->EditAttributes() ?>>
</span>
<?php echo $t01_penerimaan->Nominal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->JumlahSiswa->Visible) { // JumlahSiswa ?>
	<div id="r_JumlahSiswa" class="form-group">
		<label id="elh_t01_penerimaan_JumlahSiswa" for="x_JumlahSiswa" class="<?php echo $t01_penerimaan_edit->LeftColumnClass ?>"><?php echo $t01_penerimaan->JumlahSiswa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_penerimaan_edit->RightColumnClass ?>"><div<?php echo $t01_penerimaan->JumlahSiswa->CellAttributes() ?>>
<span id="el_t01_penerimaan_JumlahSiswa">
<input type="text" data-table="t01_penerimaan" data-field="x_JumlahSiswa" name="x_JumlahSiswa" id="x_JumlahSiswa" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->JumlahSiswa->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->JumlahSiswa->EditValue ?>"<?php echo $t01_penerimaan->JumlahSiswa->EditAttributes() ?>>
</span>
<?php echo $t01_penerimaan->JumlahSiswa->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Bulan->Visible) { // Bulan ?>
	<div id="r_Bulan" class="form-group">
		<label id="elh_t01_penerimaan_Bulan" for="x_Bulan" class="<?php echo $t01_penerimaan_edit->LeftColumnClass ?>"><?php echo $t01_penerimaan->Bulan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_penerimaan_edit->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Bulan->CellAttributes() ?>>
<span id="el_t01_penerimaan_Bulan">
<input type="text" data-table="t01_penerimaan" data-field="x_Bulan" name="x_Bulan" id="x_Bulan" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Bulan->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Bulan->EditValue ?>"<?php echo $t01_penerimaan->Bulan->EditAttributes() ?>>
</span>
<?php echo $t01_penerimaan->Bulan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Jumlah->Visible) { // Jumlah ?>
	<div id="r_Jumlah" class="form-group">
		<label id="elh_t01_penerimaan_Jumlah" for="x_Jumlah" class="<?php echo $t01_penerimaan_edit->LeftColumnClass ?>"><?php echo $t01_penerimaan->Jumlah->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_penerimaan_edit->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Jumlah->CellAttributes() ?>>
<span id="el_t01_penerimaan_Jumlah">
<input type="text" data-table="t01_penerimaan" data-field="x_Jumlah" name="x_Jumlah" id="x_Jumlah" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Jumlah->EditValue ?>"<?php echo $t01_penerimaan->Jumlah->EditAttributes() ?>>
</span>
<?php echo $t01_penerimaan->Jumlah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Total->Visible) { // Total ?>
	<div id="r_Total" class="form-group">
		<label id="elh_t01_penerimaan_Total" for="x_Total" class="<?php echo $t01_penerimaan_edit->LeftColumnClass ?>"><?php echo $t01_penerimaan->Total->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_penerimaan_edit->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Total->CellAttributes() ?>>
<span id="el_t01_penerimaan_Total">
<input type="text" data-table="t01_penerimaan" data-field="x_Total" name="x_Total" id="x_Total" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Total->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Total->EditValue ?>"<?php echo $t01_penerimaan->Total->EditAttributes() ?>>
</span>
<?php echo $t01_penerimaan->Total->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$t01_penerimaan_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t01_penerimaan_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t01_penerimaan_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft01_penerimaanedit.Init();
</script>
<?php
$t01_penerimaan_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t01_penerimaan_edit->Page_Terminate();
?>
