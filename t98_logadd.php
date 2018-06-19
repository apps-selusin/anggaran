<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t98_loginfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t98_log_add = NULL; // Initialize page object first

class ct98_log_add extends ct98_log {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{EA1CE07B-E03E-4EC9-BC42-48D490D73F97}';

	// Table name
	var $TableName = 't98_log';

	// Page object name
	var $PageObjName = 't98_log_add';

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

		// Table object (t98_log)
		if (!isset($GLOBALS["t98_log"]) || get_class($GLOBALS["t98_log"]) == "ct98_log") {
			$GLOBALS["t98_log"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t98_log"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't98_log', TRUE);

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
		$this->No->SetVisibility();
		$this->Keterangan->SetVisibility();
		$this->Keterangan2->SetVisibility();
		$this->Status->SetVisibility();
		$this->TanggalJam->SetVisibility();

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
		global $EW_EXPORT, $t98_log;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t98_log);
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
					if ($pageName == "t98_logview.php")
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
					$this->Page_Terminate("t98_loglist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t98_loglist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t98_logview.php")
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
		$this->No->CurrentValue = 0;
		$this->Keterangan->CurrentValue = NULL;
		$this->Keterangan->OldValue = $this->Keterangan->CurrentValue;
		$this->Keterangan2->CurrentValue = NULL;
		$this->Keterangan2->OldValue = $this->Keterangan2->CurrentValue;
		$this->Status->CurrentValue = 0;
		$this->TanggalJam->CurrentValue = NULL;
		$this->TanggalJam->OldValue = $this->TanggalJam->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->No->FldIsDetailKey) {
			$this->No->setFormValue($objForm->GetValue("x_No"));
		}
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
		}
		if (!$this->Keterangan2->FldIsDetailKey) {
			$this->Keterangan2->setFormValue($objForm->GetValue("x_Keterangan2"));
		}
		if (!$this->Status->FldIsDetailKey) {
			$this->Status->setFormValue($objForm->GetValue("x_Status"));
		}
		if (!$this->TanggalJam->FldIsDetailKey) {
			$this->TanggalJam->setFormValue($objForm->GetValue("x_TanggalJam"));
			$this->TanggalJam->CurrentValue = ew_UnFormatDateTime($this->TanggalJam->CurrentValue, 9);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->No->CurrentValue = $this->No->FormValue;
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
		$this->Keterangan2->CurrentValue = $this->Keterangan2->FormValue;
		$this->Status->CurrentValue = $this->Status->FormValue;
		$this->TanggalJam->CurrentValue = $this->TanggalJam->FormValue;
		$this->TanggalJam->CurrentValue = ew_UnFormatDateTime($this->TanggalJam->CurrentValue, 9);
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
		$this->No->setDbValue($row['No']);
		$this->Keterangan->setDbValue($row['Keterangan']);
		$this->Keterangan2->setDbValue($row['Keterangan2']);
		$this->Status->setDbValue($row['Status']);
		$this->TanggalJam->setDbValue($row['TanggalJam']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['No'] = $this->No->CurrentValue;
		$row['Keterangan'] = $this->Keterangan->CurrentValue;
		$row['Keterangan2'] = $this->Keterangan2->CurrentValue;
		$row['Status'] = $this->Status->CurrentValue;
		$row['TanggalJam'] = $this->TanggalJam->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->No->DbValue = $row['No'];
		$this->Keterangan->DbValue = $row['Keterangan'];
		$this->Keterangan2->DbValue = $row['Keterangan2'];
		$this->Status->DbValue = $row['Status'];
		$this->TanggalJam->DbValue = $row['TanggalJam'];
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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// No
		// Keterangan
		// Keterangan2
		// Status
		// TanggalJam

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// No
		$this->No->ViewValue = $this->No->CurrentValue;
		$this->No->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

		// Keterangan2
		$this->Keterangan2->ViewValue = $this->Keterangan2->CurrentValue;
		$this->Keterangan2->ViewCustomAttributes = "";

		// Status
		if (strval($this->Status->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->Status->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Status` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t99_log_status`";
		$sWhereWrk = "";
		$this->Status->LookupFilters = array("dx1" => '`Status`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Status, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Status->ViewValue = $this->Status->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Status->ViewValue = $this->Status->CurrentValue;
			}
		} else {
			$this->Status->ViewValue = NULL;
		}
		$this->Status->ViewCustomAttributes = "";

		// TanggalJam
		$this->TanggalJam->ViewValue = $this->TanggalJam->CurrentValue;
		$this->TanggalJam->ViewValue = ew_FormatDateTime($this->TanggalJam->ViewValue, 9);
		$this->TanggalJam->ViewCustomAttributes = "";

			// No
			$this->No->LinkCustomAttributes = "";
			$this->No->HrefValue = "";
			$this->No->TooltipValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
			$this->Keterangan->TooltipValue = "";

			// Keterangan2
			$this->Keterangan2->LinkCustomAttributes = "";
			$this->Keterangan2->HrefValue = "";
			$this->Keterangan2->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";

			// TanggalJam
			$this->TanggalJam->LinkCustomAttributes = "";
			$this->TanggalJam->HrefValue = "";
			$this->TanggalJam->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// No
			$this->No->EditAttrs["class"] = "form-control";
			$this->No->EditCustomAttributes = "";
			$this->No->EditValue = ew_HtmlEncode($this->No->CurrentValue);
			$this->No->PlaceHolder = ew_RemoveHtml($this->No->FldCaption());

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// Keterangan2
			$this->Keterangan2->EditAttrs["class"] = "form-control";
			$this->Keterangan2->EditCustomAttributes = "";
			$this->Keterangan2->EditValue = ew_HtmlEncode($this->Keterangan2->CurrentValue);
			$this->Keterangan2->PlaceHolder = ew_RemoveHtml($this->Keterangan2->FldCaption());

			// Status
			$this->Status->EditCustomAttributes = "";
			if (trim(strval($this->Status->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->Status->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Status` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t99_log_status`";
			$sWhereWrk = "";
			$this->Status->LookupFilters = array("dx1" => '`Status`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Status, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->Status->ViewValue = $this->Status->DisplayValue($arwrk);
			} else {
				$this->Status->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Status->EditValue = $arwrk;

			// TanggalJam
			$this->TanggalJam->EditAttrs["class"] = "form-control";
			$this->TanggalJam->EditCustomAttributes = "";
			$this->TanggalJam->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TanggalJam->CurrentValue, 9));
			$this->TanggalJam->PlaceHolder = ew_RemoveHtml($this->TanggalJam->FldCaption());

			// Add refer script
			// No

			$this->No->LinkCustomAttributes = "";
			$this->No->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";

			// Keterangan2
			$this->Keterangan2->LinkCustomAttributes = "";
			$this->Keterangan2->HrefValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";

			// TanggalJam
			$this->TanggalJam->LinkCustomAttributes = "";
			$this->TanggalJam->HrefValue = "";
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
		if (!ew_CheckInteger($this->No->FormValue)) {
			ew_AddMessage($gsFormError, $this->No->FldErrMsg());
		}
		if (!$this->Keterangan->FldIsDetailKey && !is_null($this->Keterangan->FormValue) && $this->Keterangan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Keterangan->FldCaption(), $this->Keterangan->ReqErrMsg));
		}
		if (!ew_CheckDate($this->TanggalJam->FormValue)) {
			ew_AddMessage($gsFormError, $this->TanggalJam->FldErrMsg());
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

		// No
		$this->No->SetDbValueDef($rsnew, $this->No->CurrentValue, 0, strval($this->No->CurrentValue) == "");

		// Keterangan
		$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, "", FALSE);

		// Keterangan2
		$this->Keterangan2->SetDbValueDef($rsnew, $this->Keterangan2->CurrentValue, NULL, FALSE);

		// Status
		$this->Status->SetDbValueDef($rsnew, $this->Status->CurrentValue, 0, strval($this->Status->CurrentValue) == "");

		// TanggalJam
		$this->TanggalJam->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TanggalJam->CurrentValue, 9), NULL, FALSE);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t98_loglist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Status":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Status` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t99_log_status`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`Status`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Status, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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
if (!isset($t98_log_add)) $t98_log_add = new ct98_log_add();

// Page init
$t98_log_add->Page_Init();

// Page main
$t98_log_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t98_log_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft98_logadd = new ew_Form("ft98_logadd", "add");

// Validate form
ft98_logadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_No");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t98_log->No->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Keterangan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t98_log->Keterangan->FldCaption(), $t98_log->Keterangan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TanggalJam");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t98_log->TanggalJam->FldErrMsg()) ?>");

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
ft98_logadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft98_logadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft98_logadd.Lists["x_Status"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Status","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t99_log_status"};
ft98_logadd.Lists["x_Status"].Data = "<?php echo $t98_log_add->Status->LookupFilterQuery(FALSE, "add") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t98_log_add->ShowPageHeader(); ?>
<?php
$t98_log_add->ShowMessage();
?>
<form name="ft98_logadd" id="ft98_logadd" class="<?php echo $t98_log_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t98_log_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t98_log_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t98_log">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($t98_log_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($t98_log->No->Visible) { // No ?>
	<div id="r_No" class="form-group">
		<label id="elh_t98_log_No" for="x_No" class="<?php echo $t98_log_add->LeftColumnClass ?>"><?php echo $t98_log->No->FldCaption() ?></label>
		<div class="<?php echo $t98_log_add->RightColumnClass ?>"><div<?php echo $t98_log->No->CellAttributes() ?>>
<span id="el_t98_log_No">
<input type="text" data-table="t98_log" data-field="x_No" name="x_No" id="x_No" size="30" placeholder="<?php echo ew_HtmlEncode($t98_log->No->getPlaceHolder()) ?>" value="<?php echo $t98_log->No->EditValue ?>"<?php echo $t98_log->No->EditAttributes() ?>>
</span>
<?php echo $t98_log->No->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t98_log->Keterangan->Visible) { // Keterangan ?>
	<div id="r_Keterangan" class="form-group">
		<label id="elh_t98_log_Keterangan" for="x_Keterangan" class="<?php echo $t98_log_add->LeftColumnClass ?>"><?php echo $t98_log->Keterangan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t98_log_add->RightColumnClass ?>"><div<?php echo $t98_log->Keterangan->CellAttributes() ?>>
<span id="el_t98_log_Keterangan">
<textarea data-table="t98_log" data-field="x_Keterangan" name="x_Keterangan" id="x_Keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t98_log->Keterangan->getPlaceHolder()) ?>"<?php echo $t98_log->Keterangan->EditAttributes() ?>><?php echo $t98_log->Keterangan->EditValue ?></textarea>
</span>
<?php echo $t98_log->Keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t98_log->Keterangan2->Visible) { // Keterangan2 ?>
	<div id="r_Keterangan2" class="form-group">
		<label id="elh_t98_log_Keterangan2" class="<?php echo $t98_log_add->LeftColumnClass ?>"><?php echo $t98_log->Keterangan2->FldCaption() ?></label>
		<div class="<?php echo $t98_log_add->RightColumnClass ?>"><div<?php echo $t98_log->Keterangan2->CellAttributes() ?>>
<span id="el_t98_log_Keterangan2">
<?php ew_AppendClass($t98_log->Keterangan2->EditAttrs["class"], "editor"); ?>
<textarea data-table="t98_log" data-field="x_Keterangan2" name="x_Keterangan2" id="x_Keterangan2" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t98_log->Keterangan2->getPlaceHolder()) ?>"<?php echo $t98_log->Keterangan2->EditAttributes() ?>><?php echo $t98_log->Keterangan2->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ft98_logadd", "x_Keterangan2", 35, 4, <?php echo ($t98_log->Keterangan2->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $t98_log->Keterangan2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t98_log->Status->Visible) { // Status ?>
	<div id="r_Status" class="form-group">
		<label id="elh_t98_log_Status" for="x_Status" class="<?php echo $t98_log_add->LeftColumnClass ?>"><?php echo $t98_log->Status->FldCaption() ?></label>
		<div class="<?php echo $t98_log_add->RightColumnClass ?>"><div<?php echo $t98_log->Status->CellAttributes() ?>>
<span id="el_t98_log_Status">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Status"><?php echo (strval($t98_log->Status->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t98_log->Status->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t98_log->Status->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Status',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t98_log->Status->ReadOnly || $t98_log->Status->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t98_log" data-field="x_Status" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t98_log->Status->DisplayValueSeparatorAttribute() ?>" name="x_Status" id="x_Status" value="<?php echo $t98_log->Status->CurrentValue ?>"<?php echo $t98_log->Status->EditAttributes() ?>>
</span>
<?php echo $t98_log->Status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t98_log->TanggalJam->Visible) { // TanggalJam ?>
	<div id="r_TanggalJam" class="form-group">
		<label id="elh_t98_log_TanggalJam" for="x_TanggalJam" class="<?php echo $t98_log_add->LeftColumnClass ?>"><?php echo $t98_log->TanggalJam->FldCaption() ?></label>
		<div class="<?php echo $t98_log_add->RightColumnClass ?>"><div<?php echo $t98_log->TanggalJam->CellAttributes() ?>>
<span id="el_t98_log_TanggalJam">
<input type="text" data-table="t98_log" data-field="x_TanggalJam" data-format="9" name="x_TanggalJam" id="x_TanggalJam" placeholder="<?php echo ew_HtmlEncode($t98_log->TanggalJam->getPlaceHolder()) ?>" value="<?php echo $t98_log->TanggalJam->EditValue ?>"<?php echo $t98_log->TanggalJam->EditAttributes() ?>>
<?php if (!$t98_log->TanggalJam->ReadOnly && !$t98_log->TanggalJam->Disabled && !isset($t98_log->TanggalJam->EditAttrs["readonly"]) && !isset($t98_log->TanggalJam->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("ft98_logadd", "x_TanggalJam", {"ignoreReadonly":true,"useCurrent":false,"format":9});
</script>
<?php } ?>
</span>
<?php echo $t98_log->TanggalJam->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$t98_log_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t98_log_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t98_log_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft98_logadd.Init();
</script>
<?php
$t98_log_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t98_log_add->Page_Terminate();
?>
