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

$datapenerimaan_edit = NULL; // Initialize page object first

class cdatapenerimaan_edit extends cdatapenerimaan {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{EA1CE07B-E03E-4EC9-BC42-48D490D73F97}';

	// Table name
	var $TableName = 'datapenerimaan';

	// Page object name
	var $PageObjName = 'datapenerimaan_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// Create form object
		$objForm = new cFormObj();
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "datapenerimaanview.php")
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
			if ($objForm->HasValue("x_replid")) {
				$this->replid->setFormValue($objForm->GetValue("x_replid"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["replid"])) {
				$this->replid->setQueryStringValue($_GET["replid"]);
				$loadByQuery = TRUE;
			} else {
				$this->replid->CurrentValue = NULL;
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
					$this->Page_Terminate("datapenerimaanlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "datapenerimaanlist.php")
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
		if (!$this->replid->FldIsDetailKey)
			$this->replid->setFormValue($objForm->GetValue("x_replid"));
		if (!$this->nama->FldIsDetailKey) {
			$this->nama->setFormValue($objForm->GetValue("x_nama"));
		}
		if (!$this->besar->FldIsDetailKey) {
			$this->besar->setFormValue($objForm->GetValue("x_besar"));
		}
		if (!$this->idkategori->FldIsDetailKey) {
			$this->idkategori->setFormValue($objForm->GetValue("x_idkategori"));
		}
		if (!$this->rekkas->FldIsDetailKey) {
			$this->rekkas->setFormValue($objForm->GetValue("x_rekkas"));
		}
		if (!$this->rekpendapatan->FldIsDetailKey) {
			$this->rekpendapatan->setFormValue($objForm->GetValue("x_rekpendapatan"));
		}
		if (!$this->rekpiutang->FldIsDetailKey) {
			$this->rekpiutang->setFormValue($objForm->GetValue("x_rekpiutang"));
		}
		if (!$this->aktif->FldIsDetailKey) {
			$this->aktif->setFormValue($objForm->GetValue("x_aktif"));
		}
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
		if (!$this->departemen->FldIsDetailKey) {
			$this->departemen->setFormValue($objForm->GetValue("x_departemen"));
		}
		if (!$this->info1->FldIsDetailKey) {
			$this->info1->setFormValue($objForm->GetValue("x_info1"));
		}
		if (!$this->info2->FldIsDetailKey) {
			$this->info2->setFormValue($objForm->GetValue("x_info2"));
		}
		if (!$this->info3->FldIsDetailKey) {
			$this->info3->setFormValue($objForm->GetValue("x_info3"));
		}
		if (!$this->ts->FldIsDetailKey) {
			$this->ts->setFormValue($objForm->GetValue("x_ts"));
			$this->ts->CurrentValue = ew_UnFormatDateTime($this->ts->CurrentValue, 0);
		}
		if (!$this->token->FldIsDetailKey) {
			$this->token->setFormValue($objForm->GetValue("x_token"));
		}
		if (!$this->issync->FldIsDetailKey) {
			$this->issync->setFormValue($objForm->GetValue("x_issync"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->replid->CurrentValue = $this->replid->FormValue;
		$this->nama->CurrentValue = $this->nama->FormValue;
		$this->besar->CurrentValue = $this->besar->FormValue;
		$this->idkategori->CurrentValue = $this->idkategori->FormValue;
		$this->rekkas->CurrentValue = $this->rekkas->FormValue;
		$this->rekpendapatan->CurrentValue = $this->rekpendapatan->FormValue;
		$this->rekpiutang->CurrentValue = $this->rekpiutang->FormValue;
		$this->aktif->CurrentValue = $this->aktif->FormValue;
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
		$this->departemen->CurrentValue = $this->departemen->FormValue;
		$this->info1->CurrentValue = $this->info1->FormValue;
		$this->info2->CurrentValue = $this->info2->FormValue;
		$this->info3->CurrentValue = $this->info3->FormValue;
		$this->ts->CurrentValue = $this->ts->FormValue;
		$this->ts->CurrentValue = ew_UnFormatDateTime($this->ts->CurrentValue, 0);
		$this->token->CurrentValue = $this->token->FormValue;
		$this->issync->CurrentValue = $this->issync->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("replid")) <> "")
			$this->replid->CurrentValue = $this->getKey("replid"); // replid
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// replid
			$this->replid->EditAttrs["class"] = "form-control";
			$this->replid->EditCustomAttributes = "";
			$this->replid->EditValue = $this->replid->CurrentValue;
			$this->replid->ViewCustomAttributes = "";

			// nama
			$this->nama->EditAttrs["class"] = "form-control";
			$this->nama->EditCustomAttributes = "";
			$this->nama->EditValue = ew_HtmlEncode($this->nama->CurrentValue);
			$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

			// besar
			$this->besar->EditAttrs["class"] = "form-control";
			$this->besar->EditCustomAttributes = "";
			$this->besar->EditValue = ew_HtmlEncode($this->besar->CurrentValue);
			$this->besar->PlaceHolder = ew_RemoveHtml($this->besar->FldCaption());
			if (strval($this->besar->EditValue) <> "" && is_numeric($this->besar->EditValue)) $this->besar->EditValue = ew_FormatNumber($this->besar->EditValue, -2, -1, -2, 0);

			// idkategori
			$this->idkategori->EditAttrs["class"] = "form-control";
			$this->idkategori->EditCustomAttributes = "";
			$this->idkategori->EditValue = ew_HtmlEncode($this->idkategori->CurrentValue);
			$this->idkategori->PlaceHolder = ew_RemoveHtml($this->idkategori->FldCaption());

			// rekkas
			$this->rekkas->EditAttrs["class"] = "form-control";
			$this->rekkas->EditCustomAttributes = "";
			$this->rekkas->EditValue = ew_HtmlEncode($this->rekkas->CurrentValue);
			$this->rekkas->PlaceHolder = ew_RemoveHtml($this->rekkas->FldCaption());

			// rekpendapatan
			$this->rekpendapatan->EditAttrs["class"] = "form-control";
			$this->rekpendapatan->EditCustomAttributes = "";
			$this->rekpendapatan->EditValue = ew_HtmlEncode($this->rekpendapatan->CurrentValue);
			$this->rekpendapatan->PlaceHolder = ew_RemoveHtml($this->rekpendapatan->FldCaption());

			// rekpiutang
			$this->rekpiutang->EditAttrs["class"] = "form-control";
			$this->rekpiutang->EditCustomAttributes = "";
			$this->rekpiutang->EditValue = ew_HtmlEncode($this->rekpiutang->CurrentValue);
			$this->rekpiutang->PlaceHolder = ew_RemoveHtml($this->rekpiutang->FldCaption());

			// aktif
			$this->aktif->EditAttrs["class"] = "form-control";
			$this->aktif->EditCustomAttributes = "";
			$this->aktif->EditValue = ew_HtmlEncode($this->aktif->CurrentValue);
			$this->aktif->PlaceHolder = ew_RemoveHtml($this->aktif->FldCaption());

			// keterangan
			$this->keterangan->EditAttrs["class"] = "form-control";
			$this->keterangan->EditCustomAttributes = "";
			$this->keterangan->EditValue = ew_HtmlEncode($this->keterangan->CurrentValue);
			$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

			// departemen
			$this->departemen->EditAttrs["class"] = "form-control";
			$this->departemen->EditCustomAttributes = "";
			$this->departemen->EditValue = ew_HtmlEncode($this->departemen->CurrentValue);
			$this->departemen->PlaceHolder = ew_RemoveHtml($this->departemen->FldCaption());

			// info1
			$this->info1->EditAttrs["class"] = "form-control";
			$this->info1->EditCustomAttributes = "";
			$this->info1->EditValue = ew_HtmlEncode($this->info1->CurrentValue);
			$this->info1->PlaceHolder = ew_RemoveHtml($this->info1->FldCaption());

			// info2
			$this->info2->EditAttrs["class"] = "form-control";
			$this->info2->EditCustomAttributes = "";
			$this->info2->EditValue = ew_HtmlEncode($this->info2->CurrentValue);
			$this->info2->PlaceHolder = ew_RemoveHtml($this->info2->FldCaption());

			// info3
			$this->info3->EditAttrs["class"] = "form-control";
			$this->info3->EditCustomAttributes = "";
			$this->info3->EditValue = ew_HtmlEncode($this->info3->CurrentValue);
			$this->info3->PlaceHolder = ew_RemoveHtml($this->info3->FldCaption());

			// ts
			$this->ts->EditAttrs["class"] = "form-control";
			$this->ts->EditCustomAttributes = "";
			$this->ts->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->ts->CurrentValue, 8));
			$this->ts->PlaceHolder = ew_RemoveHtml($this->ts->FldCaption());

			// token
			$this->token->EditAttrs["class"] = "form-control";
			$this->token->EditCustomAttributes = "";
			$this->token->EditValue = ew_HtmlEncode($this->token->CurrentValue);
			$this->token->PlaceHolder = ew_RemoveHtml($this->token->FldCaption());

			// issync
			$this->issync->EditAttrs["class"] = "form-control";
			$this->issync->EditCustomAttributes = "";
			$this->issync->EditValue = ew_HtmlEncode($this->issync->CurrentValue);
			$this->issync->PlaceHolder = ew_RemoveHtml($this->issync->FldCaption());

			// Edit refer script
			// replid

			$this->replid->LinkCustomAttributes = "";
			$this->replid->HrefValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";

			// besar
			$this->besar->LinkCustomAttributes = "";
			$this->besar->HrefValue = "";

			// idkategori
			$this->idkategori->LinkCustomAttributes = "";
			$this->idkategori->HrefValue = "";

			// rekkas
			$this->rekkas->LinkCustomAttributes = "";
			$this->rekkas->HrefValue = "";

			// rekpendapatan
			$this->rekpendapatan->LinkCustomAttributes = "";
			$this->rekpendapatan->HrefValue = "";

			// rekpiutang
			$this->rekpiutang->LinkCustomAttributes = "";
			$this->rekpiutang->HrefValue = "";

			// aktif
			$this->aktif->LinkCustomAttributes = "";
			$this->aktif->HrefValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";

			// departemen
			$this->departemen->LinkCustomAttributes = "";
			$this->departemen->HrefValue = "";

			// info1
			$this->info1->LinkCustomAttributes = "";
			$this->info1->HrefValue = "";

			// info2
			$this->info2->LinkCustomAttributes = "";
			$this->info2->HrefValue = "";

			// info3
			$this->info3->LinkCustomAttributes = "";
			$this->info3->HrefValue = "";

			// ts
			$this->ts->LinkCustomAttributes = "";
			$this->ts->HrefValue = "";

			// token
			$this->token->LinkCustomAttributes = "";
			$this->token->HrefValue = "";

			// issync
			$this->issync->LinkCustomAttributes = "";
			$this->issync->HrefValue = "";
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
		if (!$this->nama->FldIsDetailKey && !is_null($this->nama->FormValue) && $this->nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama->FldCaption(), $this->nama->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->besar->FormValue)) {
			ew_AddMessage($gsFormError, $this->besar->FldErrMsg());
		}
		if (!$this->idkategori->FldIsDetailKey && !is_null($this->idkategori->FormValue) && $this->idkategori->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idkategori->FldCaption(), $this->idkategori->ReqErrMsg));
		}
		if (!$this->rekkas->FldIsDetailKey && !is_null($this->rekkas->FormValue) && $this->rekkas->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->rekkas->FldCaption(), $this->rekkas->ReqErrMsg));
		}
		if (!$this->rekpendapatan->FldIsDetailKey && !is_null($this->rekpendapatan->FormValue) && $this->rekpendapatan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->rekpendapatan->FldCaption(), $this->rekpendapatan->ReqErrMsg));
		}
		if (!$this->aktif->FldIsDetailKey && !is_null($this->aktif->FormValue) && $this->aktif->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->aktif->FldCaption(), $this->aktif->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->aktif->FormValue)) {
			ew_AddMessage($gsFormError, $this->aktif->FldErrMsg());
		}
		if (!$this->departemen->FldIsDetailKey && !is_null($this->departemen->FormValue) && $this->departemen->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->departemen->FldCaption(), $this->departemen->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->ts->FormValue)) {
			ew_AddMessage($gsFormError, $this->ts->FldErrMsg());
		}
		if (!$this->token->FldIsDetailKey && !is_null($this->token->FormValue) && $this->token->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->token->FldCaption(), $this->token->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->token->FormValue)) {
			ew_AddMessage($gsFormError, $this->token->FldErrMsg());
		}
		if (!$this->issync->FldIsDetailKey && !is_null($this->issync->FormValue) && $this->issync->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->issync->FldCaption(), $this->issync->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->issync->FormValue)) {
			ew_AddMessage($gsFormError, $this->issync->FldErrMsg());
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

			// nama
			$this->nama->SetDbValueDef($rsnew, $this->nama->CurrentValue, "", $this->nama->ReadOnly);

			// besar
			$this->besar->SetDbValueDef($rsnew, $this->besar->CurrentValue, NULL, $this->besar->ReadOnly);

			// idkategori
			$this->idkategori->SetDbValueDef($rsnew, $this->idkategori->CurrentValue, "", $this->idkategori->ReadOnly);

			// rekkas
			$this->rekkas->SetDbValueDef($rsnew, $this->rekkas->CurrentValue, "", $this->rekkas->ReadOnly);

			// rekpendapatan
			$this->rekpendapatan->SetDbValueDef($rsnew, $this->rekpendapatan->CurrentValue, "", $this->rekpendapatan->ReadOnly);

			// rekpiutang
			$this->rekpiutang->SetDbValueDef($rsnew, $this->rekpiutang->CurrentValue, NULL, $this->rekpiutang->ReadOnly);

			// aktif
			$this->aktif->SetDbValueDef($rsnew, $this->aktif->CurrentValue, 0, $this->aktif->ReadOnly);

			// keterangan
			$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, NULL, $this->keterangan->ReadOnly);

			// departemen
			$this->departemen->SetDbValueDef($rsnew, $this->departemen->CurrentValue, "", $this->departemen->ReadOnly);

			// info1
			$this->info1->SetDbValueDef($rsnew, $this->info1->CurrentValue, NULL, $this->info1->ReadOnly);

			// info2
			$this->info2->SetDbValueDef($rsnew, $this->info2->CurrentValue, NULL, $this->info2->ReadOnly);

			// info3
			$this->info3->SetDbValueDef($rsnew, $this->info3->CurrentValue, NULL, $this->info3->ReadOnly);

			// ts
			$this->ts->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->ts->CurrentValue, 0), NULL, $this->ts->ReadOnly);

			// token
			$this->token->SetDbValueDef($rsnew, $this->token->CurrentValue, 0, $this->token->ReadOnly);

			// issync
			$this->issync->SetDbValueDef($rsnew, $this->issync->CurrentValue, 0, $this->issync->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("datapenerimaanlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($datapenerimaan_edit)) $datapenerimaan_edit = new cdatapenerimaan_edit();

// Page init
$datapenerimaan_edit->Page_Init();

// Page main
$datapenerimaan_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$datapenerimaan_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fdatapenerimaanedit = new ew_Form("fdatapenerimaanedit", "edit");

// Validate form
fdatapenerimaanedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datapenerimaan->nama->FldCaption(), $datapenerimaan->nama->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_besar");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($datapenerimaan->besar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idkategori");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datapenerimaan->idkategori->FldCaption(), $datapenerimaan->idkategori->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_rekkas");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datapenerimaan->rekkas->FldCaption(), $datapenerimaan->rekkas->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_rekpendapatan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datapenerimaan->rekpendapatan->FldCaption(), $datapenerimaan->rekpendapatan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_aktif");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datapenerimaan->aktif->FldCaption(), $datapenerimaan->aktif->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_aktif");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($datapenerimaan->aktif->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_departemen");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datapenerimaan->departemen->FldCaption(), $datapenerimaan->departemen->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ts");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($datapenerimaan->ts->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_token");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datapenerimaan->token->FldCaption(), $datapenerimaan->token->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_token");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($datapenerimaan->token->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_issync");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $datapenerimaan->issync->FldCaption(), $datapenerimaan->issync->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_issync");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($datapenerimaan->issync->FldErrMsg()) ?>");

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
fdatapenerimaanedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fdatapenerimaanedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $datapenerimaan_edit->ShowPageHeader(); ?>
<?php
$datapenerimaan_edit->ShowMessage();
?>
<form name="fdatapenerimaanedit" id="fdatapenerimaanedit" class="<?php echo $datapenerimaan_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($datapenerimaan_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $datapenerimaan_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="datapenerimaan">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($datapenerimaan_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($datapenerimaan->replid->Visible) { // replid ?>
	<div id="r_replid" class="form-group">
		<label id="elh_datapenerimaan_replid" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->replid->FldCaption() ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->replid->CellAttributes() ?>>
<span id="el_datapenerimaan_replid">
<span<?php echo $datapenerimaan->replid->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $datapenerimaan->replid->EditValue ?></p></span>
</span>
<input type="hidden" data-table="datapenerimaan" data-field="x_replid" name="x_replid" id="x_replid" value="<?php echo ew_HtmlEncode($datapenerimaan->replid->CurrentValue) ?>">
<?php echo $datapenerimaan->replid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->nama->Visible) { // nama ?>
	<div id="r_nama" class="form-group">
		<label id="elh_datapenerimaan_nama" for="x_nama" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->nama->CellAttributes() ?>>
<span id="el_datapenerimaan_nama">
<input type="text" data-table="datapenerimaan" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->nama->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->nama->EditValue ?>"<?php echo $datapenerimaan->nama->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->besar->Visible) { // besar ?>
	<div id="r_besar" class="form-group">
		<label id="elh_datapenerimaan_besar" for="x_besar" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->besar->FldCaption() ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->besar->CellAttributes() ?>>
<span id="el_datapenerimaan_besar">
<input type="text" data-table="datapenerimaan" data-field="x_besar" name="x_besar" id="x_besar" size="30" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->besar->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->besar->EditValue ?>"<?php echo $datapenerimaan->besar->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->besar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->idkategori->Visible) { // idkategori ?>
	<div id="r_idkategori" class="form-group">
		<label id="elh_datapenerimaan_idkategori" for="x_idkategori" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->idkategori->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->idkategori->CellAttributes() ?>>
<span id="el_datapenerimaan_idkategori">
<input type="text" data-table="datapenerimaan" data-field="x_idkategori" name="x_idkategori" id="x_idkategori" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->idkategori->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->idkategori->EditValue ?>"<?php echo $datapenerimaan->idkategori->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->idkategori->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->rekkas->Visible) { // rekkas ?>
	<div id="r_rekkas" class="form-group">
		<label id="elh_datapenerimaan_rekkas" for="x_rekkas" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->rekkas->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->rekkas->CellAttributes() ?>>
<span id="el_datapenerimaan_rekkas">
<input type="text" data-table="datapenerimaan" data-field="x_rekkas" name="x_rekkas" id="x_rekkas" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->rekkas->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->rekkas->EditValue ?>"<?php echo $datapenerimaan->rekkas->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->rekkas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->rekpendapatan->Visible) { // rekpendapatan ?>
	<div id="r_rekpendapatan" class="form-group">
		<label id="elh_datapenerimaan_rekpendapatan" for="x_rekpendapatan" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->rekpendapatan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->rekpendapatan->CellAttributes() ?>>
<span id="el_datapenerimaan_rekpendapatan">
<input type="text" data-table="datapenerimaan" data-field="x_rekpendapatan" name="x_rekpendapatan" id="x_rekpendapatan" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->rekpendapatan->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->rekpendapatan->EditValue ?>"<?php echo $datapenerimaan->rekpendapatan->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->rekpendapatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->rekpiutang->Visible) { // rekpiutang ?>
	<div id="r_rekpiutang" class="form-group">
		<label id="elh_datapenerimaan_rekpiutang" for="x_rekpiutang" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->rekpiutang->FldCaption() ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->rekpiutang->CellAttributes() ?>>
<span id="el_datapenerimaan_rekpiutang">
<input type="text" data-table="datapenerimaan" data-field="x_rekpiutang" name="x_rekpiutang" id="x_rekpiutang" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->rekpiutang->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->rekpiutang->EditValue ?>"<?php echo $datapenerimaan->rekpiutang->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->rekpiutang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->aktif->Visible) { // aktif ?>
	<div id="r_aktif" class="form-group">
		<label id="elh_datapenerimaan_aktif" for="x_aktif" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->aktif->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->aktif->CellAttributes() ?>>
<span id="el_datapenerimaan_aktif">
<input type="text" data-table="datapenerimaan" data-field="x_aktif" name="x_aktif" id="x_aktif" size="30" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->aktif->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->aktif->EditValue ?>"<?php echo $datapenerimaan->aktif->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->aktif->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_datapenerimaan_keterangan" for="x_keterangan" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->keterangan->FldCaption() ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->keterangan->CellAttributes() ?>>
<span id="el_datapenerimaan_keterangan">
<input type="text" data-table="datapenerimaan" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->keterangan->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->keterangan->EditValue ?>"<?php echo $datapenerimaan->keterangan->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->departemen->Visible) { // departemen ?>
	<div id="r_departemen" class="form-group">
		<label id="elh_datapenerimaan_departemen" for="x_departemen" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->departemen->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->departemen->CellAttributes() ?>>
<span id="el_datapenerimaan_departemen">
<input type="text" data-table="datapenerimaan" data-field="x_departemen" name="x_departemen" id="x_departemen" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->departemen->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->departemen->EditValue ?>"<?php echo $datapenerimaan->departemen->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->departemen->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->info1->Visible) { // info1 ?>
	<div id="r_info1" class="form-group">
		<label id="elh_datapenerimaan_info1" for="x_info1" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->info1->FldCaption() ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->info1->CellAttributes() ?>>
<span id="el_datapenerimaan_info1">
<input type="text" data-table="datapenerimaan" data-field="x_info1" name="x_info1" id="x_info1" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->info1->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->info1->EditValue ?>"<?php echo $datapenerimaan->info1->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->info1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->info2->Visible) { // info2 ?>
	<div id="r_info2" class="form-group">
		<label id="elh_datapenerimaan_info2" for="x_info2" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->info2->FldCaption() ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->info2->CellAttributes() ?>>
<span id="el_datapenerimaan_info2">
<input type="text" data-table="datapenerimaan" data-field="x_info2" name="x_info2" id="x_info2" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->info2->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->info2->EditValue ?>"<?php echo $datapenerimaan->info2->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->info2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->info3->Visible) { // info3 ?>
	<div id="r_info3" class="form-group">
		<label id="elh_datapenerimaan_info3" for="x_info3" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->info3->FldCaption() ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->info3->CellAttributes() ?>>
<span id="el_datapenerimaan_info3">
<input type="text" data-table="datapenerimaan" data-field="x_info3" name="x_info3" id="x_info3" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->info3->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->info3->EditValue ?>"<?php echo $datapenerimaan->info3->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->info3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->ts->Visible) { // ts ?>
	<div id="r_ts" class="form-group">
		<label id="elh_datapenerimaan_ts" for="x_ts" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->ts->FldCaption() ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->ts->CellAttributes() ?>>
<span id="el_datapenerimaan_ts">
<input type="text" data-table="datapenerimaan" data-field="x_ts" name="x_ts" id="x_ts" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->ts->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->ts->EditValue ?>"<?php echo $datapenerimaan->ts->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->ts->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->token->Visible) { // token ?>
	<div id="r_token" class="form-group">
		<label id="elh_datapenerimaan_token" for="x_token" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->token->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->token->CellAttributes() ?>>
<span id="el_datapenerimaan_token">
<input type="text" data-table="datapenerimaan" data-field="x_token" name="x_token" id="x_token" size="30" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->token->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->token->EditValue ?>"<?php echo $datapenerimaan->token->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->token->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($datapenerimaan->issync->Visible) { // issync ?>
	<div id="r_issync" class="form-group">
		<label id="elh_datapenerimaan_issync" for="x_issync" class="<?php echo $datapenerimaan_edit->LeftColumnClass ?>"><?php echo $datapenerimaan->issync->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $datapenerimaan_edit->RightColumnClass ?>"><div<?php echo $datapenerimaan->issync->CellAttributes() ?>>
<span id="el_datapenerimaan_issync">
<input type="text" data-table="datapenerimaan" data-field="x_issync" name="x_issync" id="x_issync" size="30" placeholder="<?php echo ew_HtmlEncode($datapenerimaan->issync->getPlaceHolder()) ?>" value="<?php echo $datapenerimaan->issync->EditValue ?>"<?php echo $datapenerimaan->issync->EditAttributes() ?>>
</span>
<?php echo $datapenerimaan->issync->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$datapenerimaan_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $datapenerimaan_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $datapenerimaan_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fdatapenerimaanedit.Init();
</script>
<?php
$datapenerimaan_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$datapenerimaan_edit->Page_Terminate();
?>
