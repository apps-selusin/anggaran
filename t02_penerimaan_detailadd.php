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

$t02_penerimaan_detail_add = NULL; // Initialize page object first

class ct02_penerimaan_detail_add extends ct02_penerimaan_detail {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{EA1CE07B-E03E-4EC9-BC42-48D490D73F97}';

	// Table name
	var $TableName = 't02_penerimaan_detail';

	// Page object name
	var $PageObjName = 't02_penerimaan_detail_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "t02_penerimaan_detailview.php")
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up master/detail parameters
		$this->SetupMasterParms();

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("t02_penerimaan_detaillist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t02_penerimaan_detaillist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t02_penerimaan_detailview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->id->CurrentValue = NULL;
		$this->id->OldValue = $this->id->CurrentValue;
		$this->Urutan->CurrentValue = 0;
		$this->Nomor->CurrentValue = "-";
		$this->Kode->CurrentValue = "-";
		$this->Pos->CurrentValue = "-";
		$this->Nominal->CurrentValue = 0.00;
		$this->Banyaknya->CurrentValue = 0;
		$this->Satuan->CurrentValue = 0;
		$this->Jumlah->CurrentValue = 0.00;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Urutan->FldIsDetailKey) {
			$this->Urutan->setFormValue($objForm->GetValue("x_Urutan"));
		}
		if (!$this->Nomor->FldIsDetailKey) {
			$this->Nomor->setFormValue($objForm->GetValue("x_Nomor"));
		}
		if (!$this->Kode->FldIsDetailKey) {
			$this->Kode->setFormValue($objForm->GetValue("x_Kode"));
		}
		if (!$this->Pos->FldIsDetailKey) {
			$this->Pos->setFormValue($objForm->GetValue("x_Pos"));
		}
		if (!$this->Nominal->FldIsDetailKey) {
			$this->Nominal->setFormValue($objForm->GetValue("x_Nominal"));
		}
		if (!$this->Banyaknya->FldIsDetailKey) {
			$this->Banyaknya->setFormValue($objForm->GetValue("x_Banyaknya"));
		}
		if (!$this->Satuan->FldIsDetailKey) {
			$this->Satuan->setFormValue($objForm->GetValue("x_Satuan"));
		}
		if (!$this->Jumlah->FldIsDetailKey) {
			$this->Jumlah->setFormValue($objForm->GetValue("x_Jumlah"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Urutan->CurrentValue = $this->Urutan->FormValue;
		$this->Nomor->CurrentValue = $this->Nomor->FormValue;
		$this->Kode->CurrentValue = $this->Kode->FormValue;
		$this->Pos->CurrentValue = $this->Pos->FormValue;
		$this->Nominal->CurrentValue = $this->Nominal->FormValue;
		$this->Banyaknya->CurrentValue = $this->Banyaknya->FormValue;
		$this->Satuan->CurrentValue = $this->Satuan->FormValue;
		$this->Jumlah->CurrentValue = $this->Jumlah->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['Urutan'] = $this->Urutan->CurrentValue;
		$row['Nomor'] = $this->Nomor->CurrentValue;
		$row['Kode'] = $this->Kode->CurrentValue;
		$row['Pos'] = $this->Pos->CurrentValue;
		$row['Nominal'] = $this->Nominal->CurrentValue;
		$row['Banyaknya'] = $this->Banyaknya->CurrentValue;
		$row['Satuan'] = $this->Satuan->CurrentValue;
		$row['Jumlah'] = $this->Jumlah->CurrentValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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

			// Kode
			$this->Kode->EditAttrs["class"] = "form-control";
			$this->Kode->EditCustomAttributes = "";
			if ($this->Kode->getSessionValue() <> "") {
				$this->Kode->CurrentValue = $this->Kode->getSessionValue();
			$this->Kode->ViewValue = $this->Kode->CurrentValue;
			$this->Kode->ViewCustomAttributes = "";
			} else {
			$this->Kode->EditValue = ew_HtmlEncode($this->Kode->CurrentValue);
			$this->Kode->PlaceHolder = ew_RemoveHtml($this->Kode->FldCaption());
			}

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

			// Banyaknya
			$this->Banyaknya->EditAttrs["class"] = "form-control";
			$this->Banyaknya->EditCustomAttributes = "";
			$this->Banyaknya->EditValue = ew_HtmlEncode($this->Banyaknya->CurrentValue);
			$this->Banyaknya->PlaceHolder = ew_RemoveHtml($this->Banyaknya->FldCaption());

			// Satuan
			$this->Satuan->EditAttrs["class"] = "form-control";
			$this->Satuan->EditCustomAttributes = "";
			$this->Satuan->EditValue = ew_HtmlEncode($this->Satuan->CurrentValue);
			$this->Satuan->PlaceHolder = ew_RemoveHtml($this->Satuan->FldCaption());

			// Jumlah
			$this->Jumlah->EditAttrs["class"] = "form-control";
			$this->Jumlah->EditCustomAttributes = "";
			$this->Jumlah->EditValue = ew_HtmlEncode($this->Jumlah->CurrentValue);
			$this->Jumlah->PlaceHolder = ew_RemoveHtml($this->Jumlah->FldCaption());
			if (strval($this->Jumlah->EditValue) <> "" && is_numeric($this->Jumlah->EditValue)) $this->Jumlah->EditValue = ew_FormatNumber($this->Jumlah->EditValue, -2, -1, -2, 0);

			// Add refer script
			// Urutan

			$this->Urutan->LinkCustomAttributes = "";
			$this->Urutan->HrefValue = "";

			// Nomor
			$this->Nomor->LinkCustomAttributes = "";
			$this->Nomor->HrefValue = "";

			// Kode
			$this->Kode->LinkCustomAttributes = "";
			$this->Kode->HrefValue = "";

			// Pos
			$this->Pos->LinkCustomAttributes = "";
			$this->Pos->HrefValue = "";

			// Nominal
			$this->Nominal->LinkCustomAttributes = "";
			$this->Nominal->HrefValue = "";

			// Banyaknya
			$this->Banyaknya->LinkCustomAttributes = "";
			$this->Banyaknya->HrefValue = "";

			// Satuan
			$this->Satuan->LinkCustomAttributes = "";
			$this->Satuan->HrefValue = "";

			// Jumlah
			$this->Jumlah->LinkCustomAttributes = "";
			$this->Jumlah->HrefValue = "";
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
		if (!ew_CheckInteger($this->Urutan->FormValue)) {
			ew_AddMessage($gsFormError, $this->Urutan->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Nominal->FormValue)) {
			ew_AddMessage($gsFormError, $this->Nominal->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Banyaknya->FormValue)) {
			ew_AddMessage($gsFormError, $this->Banyaknya->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Satuan->FormValue)) {
			ew_AddMessage($gsFormError, $this->Satuan->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Jumlah->FormValue)) {
			ew_AddMessage($gsFormError, $this->Jumlah->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// Urutan
		$this->Urutan->SetDbValueDef($rsnew, $this->Urutan->CurrentValue, 0, strval($this->Urutan->CurrentValue) == "");

		// Nomor
		$this->Nomor->SetDbValueDef($rsnew, $this->Nomor->CurrentValue, "", strval($this->Nomor->CurrentValue) == "");

		// Kode
		$this->Kode->SetDbValueDef($rsnew, $this->Kode->CurrentValue, "", strval($this->Kode->CurrentValue) == "");

		// Pos
		$this->Pos->SetDbValueDef($rsnew, $this->Pos->CurrentValue, "", strval($this->Pos->CurrentValue) == "");

		// Nominal
		$this->Nominal->SetDbValueDef($rsnew, $this->Nominal->CurrentValue, 0, strval($this->Nominal->CurrentValue) == "");

		// Banyaknya
		$this->Banyaknya->SetDbValueDef($rsnew, $this->Banyaknya->CurrentValue, 0, strval($this->Banyaknya->CurrentValue) == "");

		// Satuan
		$this->Satuan->SetDbValueDef($rsnew, $this->Satuan->CurrentValue, 0, strval($this->Satuan->CurrentValue) == "");

		// Jumlah
		$this->Jumlah->SetDbValueDef($rsnew, $this->Jumlah->CurrentValue, 0, strval($this->Jumlah->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($t02_penerimaan_detail_add)) $t02_penerimaan_detail_add = new ct02_penerimaan_detail_add();

// Page init
$t02_penerimaan_detail_add->Page_Init();

// Page main
$t02_penerimaan_detail_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t02_penerimaan_detail_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft02_penerimaan_detailadd = new ew_Form("ft02_penerimaan_detailadd", "add");

// Validate form
ft02_penerimaan_detailadd.Validate = function() {
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
ft02_penerimaan_detailadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft02_penerimaan_detailadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t02_penerimaan_detail_add->ShowPageHeader(); ?>
<?php
$t02_penerimaan_detail_add->ShowMessage();
?>
<form name="ft02_penerimaan_detailadd" id="ft02_penerimaan_detailadd" class="<?php echo $t02_penerimaan_detail_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t02_penerimaan_detail_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t02_penerimaan_detail_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t02_penerimaan_detail">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($t02_penerimaan_detail_add->IsModal) ?>">
<?php if ($t02_penerimaan_detail->getCurrentMasterTable() == "t01_penerimaan_head") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t01_penerimaan_head">
<input type="hidden" name="fk_Kode" value="<?php echo $t02_penerimaan_detail->Kode->getSessionValue() ?>">
<?php } ?>
<div class="ewAddDiv"><!-- page* -->
<?php if ($t02_penerimaan_detail->Urutan->Visible) { // Urutan ?>
	<div id="r_Urutan" class="form-group">
		<label id="elh_t02_penerimaan_detail_Urutan" for="x_Urutan" class="<?php echo $t02_penerimaan_detail_add->LeftColumnClass ?>"><?php echo $t02_penerimaan_detail->Urutan->FldCaption() ?></label>
		<div class="<?php echo $t02_penerimaan_detail_add->RightColumnClass ?>"><div<?php echo $t02_penerimaan_detail->Urutan->CellAttributes() ?>>
<span id="el_t02_penerimaan_detail_Urutan">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="x_Urutan" id="x_Urutan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Urutan->EditValue ?>"<?php echo $t02_penerimaan_detail->Urutan->EditAttributes() ?>>
</span>
<?php echo $t02_penerimaan_detail->Urutan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_penerimaan_detail->Nomor->Visible) { // Nomor ?>
	<div id="r_Nomor" class="form-group">
		<label id="elh_t02_penerimaan_detail_Nomor" for="x_Nomor" class="<?php echo $t02_penerimaan_detail_add->LeftColumnClass ?>"><?php echo $t02_penerimaan_detail->Nomor->FldCaption() ?></label>
		<div class="<?php echo $t02_penerimaan_detail_add->RightColumnClass ?>"><div<?php echo $t02_penerimaan_detail->Nomor->CellAttributes() ?>>
<span id="el_t02_penerimaan_detail_Nomor">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="x_Nomor" id="x_Nomor" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Nomor->EditValue ?>"<?php echo $t02_penerimaan_detail->Nomor->EditAttributes() ?>>
</span>
<?php echo $t02_penerimaan_detail->Nomor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_penerimaan_detail->Kode->Visible) { // Kode ?>
	<div id="r_Kode" class="form-group">
		<label id="elh_t02_penerimaan_detail_Kode" for="x_Kode" class="<?php echo $t02_penerimaan_detail_add->LeftColumnClass ?>"><?php echo $t02_penerimaan_detail->Kode->FldCaption() ?></label>
		<div class="<?php echo $t02_penerimaan_detail_add->RightColumnClass ?>"><div<?php echo $t02_penerimaan_detail->Kode->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->Kode->getSessionValue() <> "") { ?>
<span id="el_t02_penerimaan_detail_Kode">
<span<?php echo $t02_penerimaan_detail->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_Kode" name="x_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->CurrentValue) ?>">
<?php } else { ?>
<span id="el_t02_penerimaan_detail_Kode">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Kode" name="x_Kode" id="x_Kode" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Kode->EditValue ?>"<?php echo $t02_penerimaan_detail->Kode->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $t02_penerimaan_detail->Kode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_penerimaan_detail->Pos->Visible) { // Pos ?>
	<div id="r_Pos" class="form-group">
		<label id="elh_t02_penerimaan_detail_Pos" for="x_Pos" class="<?php echo $t02_penerimaan_detail_add->LeftColumnClass ?>"><?php echo $t02_penerimaan_detail->Pos->FldCaption() ?></label>
		<div class="<?php echo $t02_penerimaan_detail_add->RightColumnClass ?>"><div<?php echo $t02_penerimaan_detail->Pos->CellAttributes() ?>>
<span id="el_t02_penerimaan_detail_Pos">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Pos" name="x_Pos" id="x_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Pos->EditValue ?>"<?php echo $t02_penerimaan_detail->Pos->EditAttributes() ?>>
</span>
<?php echo $t02_penerimaan_detail->Pos->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_penerimaan_detail->Nominal->Visible) { // Nominal ?>
	<div id="r_Nominal" class="form-group">
		<label id="elh_t02_penerimaan_detail_Nominal" for="x_Nominal" class="<?php echo $t02_penerimaan_detail_add->LeftColumnClass ?>"><?php echo $t02_penerimaan_detail->Nominal->FldCaption() ?></label>
		<div class="<?php echo $t02_penerimaan_detail_add->RightColumnClass ?>"><div<?php echo $t02_penerimaan_detail->Nominal->CellAttributes() ?>>
<span id="el_t02_penerimaan_detail_Nominal">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="x_Nominal" id="x_Nominal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Nominal->EditValue ?>"<?php echo $t02_penerimaan_detail->Nominal->EditAttributes() ?>>
</span>
<?php echo $t02_penerimaan_detail->Nominal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_penerimaan_detail->Banyaknya->Visible) { // Banyaknya ?>
	<div id="r_Banyaknya" class="form-group">
		<label id="elh_t02_penerimaan_detail_Banyaknya" for="x_Banyaknya" class="<?php echo $t02_penerimaan_detail_add->LeftColumnClass ?>"><?php echo $t02_penerimaan_detail->Banyaknya->FldCaption() ?></label>
		<div class="<?php echo $t02_penerimaan_detail_add->RightColumnClass ?>"><div<?php echo $t02_penerimaan_detail->Banyaknya->CellAttributes() ?>>
<span id="el_t02_penerimaan_detail_Banyaknya">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="x_Banyaknya" id="x_Banyaknya" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Banyaknya->EditValue ?>"<?php echo $t02_penerimaan_detail->Banyaknya->EditAttributes() ?>>
</span>
<?php echo $t02_penerimaan_detail->Banyaknya->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_penerimaan_detail->Satuan->Visible) { // Satuan ?>
	<div id="r_Satuan" class="form-group">
		<label id="elh_t02_penerimaan_detail_Satuan" for="x_Satuan" class="<?php echo $t02_penerimaan_detail_add->LeftColumnClass ?>"><?php echo $t02_penerimaan_detail->Satuan->FldCaption() ?></label>
		<div class="<?php echo $t02_penerimaan_detail_add->RightColumnClass ?>"><div<?php echo $t02_penerimaan_detail->Satuan->CellAttributes() ?>>
<span id="el_t02_penerimaan_detail_Satuan">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="x_Satuan" id="x_Satuan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Satuan->EditValue ?>"<?php echo $t02_penerimaan_detail->Satuan->EditAttributes() ?>>
</span>
<?php echo $t02_penerimaan_detail->Satuan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_penerimaan_detail->Jumlah->Visible) { // Jumlah ?>
	<div id="r_Jumlah" class="form-group">
		<label id="elh_t02_penerimaan_detail_Jumlah" for="x_Jumlah" class="<?php echo $t02_penerimaan_detail_add->LeftColumnClass ?>"><?php echo $t02_penerimaan_detail->Jumlah->FldCaption() ?></label>
		<div class="<?php echo $t02_penerimaan_detail_add->RightColumnClass ?>"><div<?php echo $t02_penerimaan_detail->Jumlah->CellAttributes() ?>>
<span id="el_t02_penerimaan_detail_Jumlah">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="x_Jumlah" id="x_Jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Jumlah->EditValue ?>"<?php echo $t02_penerimaan_detail->Jumlah->EditAttributes() ?>>
</span>
<?php echo $t02_penerimaan_detail->Jumlah->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$t02_penerimaan_detail_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t02_penerimaan_detail_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t02_penerimaan_detail_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft02_penerimaan_detailadd.Init();
</script>
<?php
$t02_penerimaan_detail_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t02_penerimaan_detail_add->Page_Terminate();
?>
