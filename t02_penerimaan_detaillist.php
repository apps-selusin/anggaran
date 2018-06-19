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

$t02_penerimaan_detail_list = NULL; // Initialize page object first

class ct02_penerimaan_detail_list extends ct02_penerimaan_detail {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{EA1CE07B-E03E-4EC9-BC42-48D490D73F97}';

	// Table name
	var $TableName = 't02_penerimaan_detail';

	// Page object name
	var $PageObjName = 't02_penerimaan_detail_list';

	// Grid form hidden field names
	var $FormName = 'ft02_penerimaan_detaillist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t02_penerimaan_detailadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t02_penerimaan_detaildelete.php";
		$this->MultiUpdateUrl = "t02_penerimaan_detailupdate.php";

		// Table object (t01_penerimaan_head)
		if (!isset($GLOBALS['t01_penerimaan_head'])) $GLOBALS['t01_penerimaan_head'] = new ct01_penerimaan_head();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption ft02_penerimaan_detaillistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
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

		// Set up master detail parameters
		$this->SetupMasterParms();

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();
				}
			}

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->SetupSortOrder();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "t01_penerimaan_head") {
			global $t01_penerimaan_head;
			$rsmaster = $t01_penerimaan_head->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("t01_penerimaan_headlist.php"); // Return to master page
			} else {
				$t01_penerimaan_head->LoadListRowValues($rsmaster);
				$t01_penerimaan_head->RowType = EW_ROWTYPE_MASTER; // Master row
				$t01_penerimaan_head->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Exit inline mode
	function ClearInlineMode() {
		$this->setKey("id", ""); // Clear inline edit key
		$this->Nominal->FormValue = ""; // Clear form value
		$this->Jumlah->FormValue = ""; // Clear form value
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		$bInlineEdit = TRUE;
		if (isset($_GET["id"])) {
			$this->id->setQueryStringValue($_GET["id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("id", $this->id->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1;
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("id")) <> strval($this->id->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_Urutan") && $objForm->HasValue("o_Urutan") && $this->Urutan->CurrentValue <> $this->Urutan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Nomor") && $objForm->HasValue("o_Nomor") && $this->Nomor->CurrentValue <> $this->Nomor->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Kode") && $objForm->HasValue("o_Kode") && $this->Kode->CurrentValue <> $this->Kode->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Pos") && $objForm->HasValue("o_Pos") && $this->Pos->CurrentValue <> $this->Pos->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Nominal") && $objForm->HasValue("o_Nominal") && $this->Nominal->CurrentValue <> $this->Nominal->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Banyaknya") && $objForm->HasValue("o_Banyaknya") && $this->Banyaknya->CurrentValue <> $this->Banyaknya->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Satuan") && $objForm->HasValue("o_Satuan") && $this->Satuan->CurrentValue <> $this->Satuan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Jumlah") && $objForm->HasValue("o_Jumlah") && $this->Jumlah->CurrentValue <> $this->Jumlah->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Urutan, $bCtrl); // Urutan
			$this->UpdateSort($this->Nomor, $bCtrl); // Nomor
			$this->UpdateSort($this->Kode, $bCtrl); // Kode
			$this->UpdateSort($this->Pos, $bCtrl); // Pos
			$this->UpdateSort($this->Nominal, $bCtrl); // Nominal
			$this->UpdateSort($this->Banyaknya, $bCtrl); // Banyaknya
			$this->UpdateSort($this->Satuan, $bCtrl); // Satuan
			$this->UpdateSort($this->Jumlah, $bCtrl); // Jumlah
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
				$this->Urutan->setSort("ASC");
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->Kode->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Urutan->setSort("");
				$this->Nomor->setSort("");
				$this->Kode->setSort("");
				$this->Pos->setSort("");
				$this->Nominal->setSort("");
				$this->Banyaknya->setSort("");
				$this->Satuan->setSort("");
				$this->Jumlah->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssClass = "text-nowrap";
			$item->OnLeft = FALSE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// "sequence"
		$item = &$this->ListOptions->Add("sequence");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE; // Always on left
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_UrlAddHash($this->PageName(), "r" . $this->RowCnt . "_" . $this->TableVar) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\">";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if (TRUE) {
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddHash($this->InlineEditUrl, "r" . $this->RowCnt . "_" . $this->TableVar)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "");
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft02_penerimaan_detaillistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft02_penerimaan_detaillistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = FALSE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft02_penerimaan_detaillist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = FALSE;
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
		}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load default values
	function LoadDefaultValues() {
		$this->id->CurrentValue = NULL;
		$this->id->OldValue = $this->id->CurrentValue;
		$this->Urutan->CurrentValue = 0;
		$this->Urutan->OldValue = $this->Urutan->CurrentValue;
		$this->Nomor->CurrentValue = "-";
		$this->Nomor->OldValue = $this->Nomor->CurrentValue;
		$this->Kode->CurrentValue = "-";
		$this->Kode->OldValue = $this->Kode->CurrentValue;
		$this->Pos->CurrentValue = "-";
		$this->Pos->OldValue = $this->Pos->CurrentValue;
		$this->Nominal->CurrentValue = 0.00;
		$this->Nominal->OldValue = $this->Nominal->CurrentValue;
		$this->Banyaknya->CurrentValue = 0;
		$this->Banyaknya->OldValue = $this->Banyaknya->CurrentValue;
		$this->Satuan->CurrentValue = 0;
		$this->Satuan->OldValue = $this->Satuan->CurrentValue;
		$this->Jumlah->CurrentValue = 0.00;
		$this->Jumlah->OldValue = $this->Jumlah->CurrentValue;
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
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->Urutan->CurrentValue = $this->Urutan->FormValue;
		$this->Nomor->CurrentValue = $this->Nomor->FormValue;
		$this->Kode->CurrentValue = $this->Kode->FormValue;
		$this->Pos->CurrentValue = $this->Pos->FormValue;
		$this->Nominal->CurrentValue = $this->Nominal->FormValue;
		$this->Banyaknya->CurrentValue = $this->Banyaknya->FormValue;
		$this->Satuan->CurrentValue = $this->Satuan->FormValue;
		$this->Jumlah->CurrentValue = $this->Jumlah->FormValue;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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

			// Edit refer script
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
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

			// Urutan
			$this->Urutan->SetDbValueDef($rsnew, $this->Urutan->CurrentValue, 0, $this->Urutan->ReadOnly);

			// Nomor
			$this->Nomor->SetDbValueDef($rsnew, $this->Nomor->CurrentValue, "", $this->Nomor->ReadOnly);

			// Kode
			$this->Kode->SetDbValueDef($rsnew, $this->Kode->CurrentValue, "", $this->Kode->ReadOnly);

			// Pos
			$this->Pos->SetDbValueDef($rsnew, $this->Pos->CurrentValue, "", $this->Pos->ReadOnly);

			// Nominal
			$this->Nominal->SetDbValueDef($rsnew, $this->Nominal->CurrentValue, 0, $this->Nominal->ReadOnly);

			// Banyaknya
			$this->Banyaknya->SetDbValueDef($rsnew, $this->Banyaknya->CurrentValue, 0, $this->Banyaknya->ReadOnly);

			// Satuan
			$this->Satuan->SetDbValueDef($rsnew, $this->Satuan->CurrentValue, 0, $this->Satuan->ReadOnly);

			// Jumlah
			$this->Jumlah->SetDbValueDef($rsnew, $this->Jumlah->CurrentValue, 0, $this->Jumlah->ReadOnly);

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

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t02_penerimaan_detail_list)) $t02_penerimaan_detail_list = new ct02_penerimaan_detail_list();

// Page init
$t02_penerimaan_detail_list->Page_Init();

// Page main
$t02_penerimaan_detail_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t02_penerimaan_detail_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft02_penerimaan_detaillist = new ew_Form("ft02_penerimaan_detaillist", "list");
ft02_penerimaan_detaillist.FormKeyCountName = '<?php echo $t02_penerimaan_detail_list->FormKeyCountName ?>';

// Validate form
ft02_penerimaan_detaillist.Validate = function() {
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
	return true;
}

// Form_CustomValidate event
ft02_penerimaan_detaillist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft02_penerimaan_detaillist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($t02_penerimaan_detail_list->TotalRecs > 0 && $t02_penerimaan_detail_list->ExportOptions->Visible()) { ?>
<?php $t02_penerimaan_detail_list->ExportOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php if (($t02_penerimaan_detail->Export == "") || (EW_EXPORT_MASTER_RECORD && $t02_penerimaan_detail->Export == "print")) { ?>
<?php
if ($t02_penerimaan_detail_list->DbMasterFilter <> "" && $t02_penerimaan_detail->getCurrentMasterTable() == "t01_penerimaan_head") {
	if ($t02_penerimaan_detail_list->MasterRecordExists) {
?>
<?php include_once "t01_penerimaan_headmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = $t02_penerimaan_detail_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t02_penerimaan_detail_list->TotalRecs <= 0)
			$t02_penerimaan_detail_list->TotalRecs = $t02_penerimaan_detail->ListRecordCount();
	} else {
		if (!$t02_penerimaan_detail_list->Recordset && ($t02_penerimaan_detail_list->Recordset = $t02_penerimaan_detail_list->LoadRecordset()))
			$t02_penerimaan_detail_list->TotalRecs = $t02_penerimaan_detail_list->Recordset->RecordCount();
	}
	$t02_penerimaan_detail_list->StartRec = 1;
	if ($t02_penerimaan_detail_list->DisplayRecs <= 0 || ($t02_penerimaan_detail->Export <> "" && $t02_penerimaan_detail->ExportAll)) // Display all records
		$t02_penerimaan_detail_list->DisplayRecs = $t02_penerimaan_detail_list->TotalRecs;
	if (!($t02_penerimaan_detail->Export <> "" && $t02_penerimaan_detail->ExportAll))
		$t02_penerimaan_detail_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t02_penerimaan_detail_list->Recordset = $t02_penerimaan_detail_list->LoadRecordset($t02_penerimaan_detail_list->StartRec-1, $t02_penerimaan_detail_list->DisplayRecs);

	// Set no record found message
	if ($t02_penerimaan_detail->CurrentAction == "" && $t02_penerimaan_detail_list->TotalRecs == 0) {
		if ($t02_penerimaan_detail_list->SearchWhere == "0=101")
			$t02_penerimaan_detail_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t02_penerimaan_detail_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$t02_penerimaan_detail_list->RenderOtherOptions();
?>
<?php $t02_penerimaan_detail_list->ShowPageHeader(); ?>
<?php
$t02_penerimaan_detail_list->ShowMessage();
?>
<?php if ($t02_penerimaan_detail_list->TotalRecs > 0 || $t02_penerimaan_detail->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t02_penerimaan_detail_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t02_penerimaan_detail">
<form name="ft02_penerimaan_detaillist" id="ft02_penerimaan_detaillist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t02_penerimaan_detail_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t02_penerimaan_detail_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t02_penerimaan_detail">
<?php if ($t02_penerimaan_detail->getCurrentMasterTable() == "t01_penerimaan_head" && $t02_penerimaan_detail->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t01_penerimaan_head">
<input type="hidden" name="fk_Kode" value="<?php echo $t02_penerimaan_detail->Kode->getSessionValue() ?>">
<?php } ?>
<div id="gmp_t02_penerimaan_detail" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($t02_penerimaan_detail_list->TotalRecs > 0 || $t02_penerimaan_detail->CurrentAction == "gridedit") { ?>
<table id="tbl_t02_penerimaan_detaillist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t02_penerimaan_detail_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t02_penerimaan_detail_list->RenderListOptions();

// Render list options (header, left)
$t02_penerimaan_detail_list->ListOptions->Render("header", "left");
?>
<?php if ($t02_penerimaan_detail->Urutan->Visible) { // Urutan ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Urutan) == "") { ?>
		<th data-name="Urutan" class="<?php echo $t02_penerimaan_detail->Urutan->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Urutan" class="t02_penerimaan_detail_Urutan"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Urutan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Urutan" class="<?php echo $t02_penerimaan_detail->Urutan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Urutan) ?>',2);"><div id="elh_t02_penerimaan_detail_Urutan" class="t02_penerimaan_detail_Urutan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Urutan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Urutan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Urutan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Nomor->Visible) { // Nomor ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Nomor) == "") { ?>
		<th data-name="Nomor" class="<?php echo $t02_penerimaan_detail->Nomor->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Nomor" class="t02_penerimaan_detail_Nomor"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Nomor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nomor" class="<?php echo $t02_penerimaan_detail->Nomor->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Nomor) ?>',2);"><div id="elh_t02_penerimaan_detail_Nomor" class="t02_penerimaan_detail_Nomor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Nomor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Nomor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Nomor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Kode->Visible) { // Kode ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Kode) == "") { ?>
		<th data-name="Kode" class="<?php echo $t02_penerimaan_detail->Kode->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Kode" class="t02_penerimaan_detail_Kode"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Kode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Kode" class="<?php echo $t02_penerimaan_detail->Kode->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Kode) ?>',2);"><div id="elh_t02_penerimaan_detail_Kode" class="t02_penerimaan_detail_Kode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Kode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Kode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Kode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Pos->Visible) { // Pos ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Pos) == "") { ?>
		<th data-name="Pos" class="<?php echo $t02_penerimaan_detail->Pos->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Pos" class="t02_penerimaan_detail_Pos"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Pos->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Pos" class="<?php echo $t02_penerimaan_detail->Pos->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Pos) ?>',2);"><div id="elh_t02_penerimaan_detail_Pos" class="t02_penerimaan_detail_Pos">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Pos->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Pos->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Pos->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Nominal->Visible) { // Nominal ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Nominal) == "") { ?>
		<th data-name="Nominal" class="<?php echo $t02_penerimaan_detail->Nominal->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Nominal" class="t02_penerimaan_detail_Nominal"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Nominal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nominal" class="<?php echo $t02_penerimaan_detail->Nominal->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Nominal) ?>',2);"><div id="elh_t02_penerimaan_detail_Nominal" class="t02_penerimaan_detail_Nominal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Nominal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Nominal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Nominal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Banyaknya->Visible) { // Banyaknya ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Banyaknya) == "") { ?>
		<th data-name="Banyaknya" class="<?php echo $t02_penerimaan_detail->Banyaknya->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Banyaknya" class="t02_penerimaan_detail_Banyaknya"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Banyaknya->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Banyaknya" class="<?php echo $t02_penerimaan_detail->Banyaknya->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Banyaknya) ?>',2);"><div id="elh_t02_penerimaan_detail_Banyaknya" class="t02_penerimaan_detail_Banyaknya">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Banyaknya->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Banyaknya->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Banyaknya->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Satuan->Visible) { // Satuan ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Satuan) == "") { ?>
		<th data-name="Satuan" class="<?php echo $t02_penerimaan_detail->Satuan->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Satuan" class="t02_penerimaan_detail_Satuan"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Satuan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Satuan" class="<?php echo $t02_penerimaan_detail->Satuan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Satuan) ?>',2);"><div id="elh_t02_penerimaan_detail_Satuan" class="t02_penerimaan_detail_Satuan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Satuan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Satuan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Satuan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->Jumlah->Visible) { // Jumlah ?>
	<?php if ($t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Jumlah) == "") { ?>
		<th data-name="Jumlah" class="<?php echo $t02_penerimaan_detail->Jumlah->HeaderCellClass() ?>"><div id="elh_t02_penerimaan_detail_Jumlah" class="t02_penerimaan_detail_Jumlah"><div class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Jumlah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jumlah" class="<?php echo $t02_penerimaan_detail->Jumlah->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_penerimaan_detail->SortUrl($t02_penerimaan_detail->Jumlah) ?>',2);"><div id="elh_t02_penerimaan_detail_Jumlah" class="t02_penerimaan_detail_Jumlah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_penerimaan_detail->Jumlah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_penerimaan_detail->Jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_penerimaan_detail->Jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t02_penerimaan_detail_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($t02_penerimaan_detail->ExportAll && $t02_penerimaan_detail->Export <> "") {
	$t02_penerimaan_detail_list->StopRec = $t02_penerimaan_detail_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t02_penerimaan_detail_list->TotalRecs > $t02_penerimaan_detail_list->StartRec + $t02_penerimaan_detail_list->DisplayRecs - 1)
		$t02_penerimaan_detail_list->StopRec = $t02_penerimaan_detail_list->StartRec + $t02_penerimaan_detail_list->DisplayRecs - 1;
	else
		$t02_penerimaan_detail_list->StopRec = $t02_penerimaan_detail_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t02_penerimaan_detail_list->FormKeyCountName) && ($t02_penerimaan_detail->CurrentAction == "gridadd" || $t02_penerimaan_detail->CurrentAction == "gridedit" || $t02_penerimaan_detail->CurrentAction == "F")) {
		$t02_penerimaan_detail_list->KeyCount = $objForm->GetValue($t02_penerimaan_detail_list->FormKeyCountName);
		$t02_penerimaan_detail_list->StopRec = $t02_penerimaan_detail_list->StartRec + $t02_penerimaan_detail_list->KeyCount - 1;
	}
}
$t02_penerimaan_detail_list->RecCnt = $t02_penerimaan_detail_list->StartRec - 1;
if ($t02_penerimaan_detail_list->Recordset && !$t02_penerimaan_detail_list->Recordset->EOF) {
	$t02_penerimaan_detail_list->Recordset->MoveFirst();
	$bSelectLimit = $t02_penerimaan_detail_list->UseSelectLimit;
	if (!$bSelectLimit && $t02_penerimaan_detail_list->StartRec > 1)
		$t02_penerimaan_detail_list->Recordset->Move($t02_penerimaan_detail_list->StartRec - 1);
} elseif (!$t02_penerimaan_detail->AllowAddDeleteRow && $t02_penerimaan_detail_list->StopRec == 0) {
	$t02_penerimaan_detail_list->StopRec = $t02_penerimaan_detail->GridAddRowCount;
}

// Initialize aggregate
$t02_penerimaan_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t02_penerimaan_detail->ResetAttrs();
$t02_penerimaan_detail_list->RenderRow();
$t02_penerimaan_detail_list->EditRowCnt = 0;
if ($t02_penerimaan_detail->CurrentAction == "edit")
	$t02_penerimaan_detail_list->RowIndex = 1;
if ($t02_penerimaan_detail->CurrentAction == "gridedit")
	$t02_penerimaan_detail_list->RowIndex = 0;
while ($t02_penerimaan_detail_list->RecCnt < $t02_penerimaan_detail_list->StopRec) {
	$t02_penerimaan_detail_list->RecCnt++;
	if (intval($t02_penerimaan_detail_list->RecCnt) >= intval($t02_penerimaan_detail_list->StartRec)) {
		$t02_penerimaan_detail_list->RowCnt++;
		if ($t02_penerimaan_detail->CurrentAction == "gridadd" || $t02_penerimaan_detail->CurrentAction == "gridedit" || $t02_penerimaan_detail->CurrentAction == "F") {
			$t02_penerimaan_detail_list->RowIndex++;
			$objForm->Index = $t02_penerimaan_detail_list->RowIndex;
			if ($objForm->HasValue($t02_penerimaan_detail_list->FormActionName))
				$t02_penerimaan_detail_list->RowAction = strval($objForm->GetValue($t02_penerimaan_detail_list->FormActionName));
			elseif ($t02_penerimaan_detail->CurrentAction == "gridadd")
				$t02_penerimaan_detail_list->RowAction = "insert";
			else
				$t02_penerimaan_detail_list->RowAction = "";
		}

		// Set up key count
		$t02_penerimaan_detail_list->KeyCount = $t02_penerimaan_detail_list->RowIndex;

		// Init row class and style
		$t02_penerimaan_detail->ResetAttrs();
		$t02_penerimaan_detail->CssClass = "";
		if ($t02_penerimaan_detail->CurrentAction == "gridadd") {
			$t02_penerimaan_detail_list->LoadRowValues(); // Load default values
		} else {
			$t02_penerimaan_detail_list->LoadRowValues($t02_penerimaan_detail_list->Recordset); // Load row values
		}
		$t02_penerimaan_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t02_penerimaan_detail->CurrentAction == "edit") {
			if ($t02_penerimaan_detail_list->CheckInlineEditKey() && $t02_penerimaan_detail_list->EditRowCnt == 0) { // Inline edit
				$t02_penerimaan_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($t02_penerimaan_detail->CurrentAction == "gridedit") { // Grid edit
			if ($t02_penerimaan_detail->EventCancelled) {
				$t02_penerimaan_detail_list->RestoreCurrentRowFormValues($t02_penerimaan_detail_list->RowIndex); // Restore form values
			}
			if ($t02_penerimaan_detail_list->RowAction == "insert")
				$t02_penerimaan_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t02_penerimaan_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t02_penerimaan_detail->CurrentAction == "edit" && $t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT && $t02_penerimaan_detail->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$t02_penerimaan_detail_list->RestoreFormValues(); // Restore form values
		}
		if ($t02_penerimaan_detail->CurrentAction == "gridedit" && ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT || $t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) && $t02_penerimaan_detail->EventCancelled) // Update failed
			$t02_penerimaan_detail_list->RestoreCurrentRowFormValues($t02_penerimaan_detail_list->RowIndex); // Restore form values
		if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t02_penerimaan_detail_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$t02_penerimaan_detail->RowAttrs = array_merge($t02_penerimaan_detail->RowAttrs, array('data-rowindex'=>$t02_penerimaan_detail_list->RowCnt, 'id'=>'r' . $t02_penerimaan_detail_list->RowCnt . '_t02_penerimaan_detail', 'data-rowtype'=>$t02_penerimaan_detail->RowType));

		// Render row
		$t02_penerimaan_detail_list->RenderRow();

		// Render list options
		$t02_penerimaan_detail_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t02_penerimaan_detail_list->RowAction <> "delete" && $t02_penerimaan_detail_list->RowAction <> "insertdelete" && !($t02_penerimaan_detail_list->RowAction == "insert" && $t02_penerimaan_detail->CurrentAction == "F" && $t02_penerimaan_detail_list->EmptyRow())) {
?>
	<tr<?php echo $t02_penerimaan_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t02_penerimaan_detail_list->ListOptions->Render("body", "left", $t02_penerimaan_detail_list->RowCnt);
?>
	<?php if ($t02_penerimaan_detail->Urutan->Visible) { // Urutan ?>
		<td data-name="Urutan"<?php echo $t02_penerimaan_detail->Urutan->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Urutan" class="form-group t02_penerimaan_detail_Urutan">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Urutan" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Urutan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Urutan->EditValue ?>"<?php echo $t02_penerimaan_detail->Urutan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Urutan" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Urutan" class="form-group t02_penerimaan_detail_Urutan">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Urutan" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Urutan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Urutan->EditValue ?>"<?php echo $t02_penerimaan_detail->Urutan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Urutan" class="t02_penerimaan_detail_Urutan">
<span<?php echo $t02_penerimaan_detail->Urutan->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Urutan->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_id" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_id" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->id->CurrentValue) ?>">
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_id" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_id" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->id->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT || $t02_penerimaan_detail->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_id" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_id" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t02_penerimaan_detail->Nomor->Visible) { // Nomor ?>
		<td data-name="Nomor"<?php echo $t02_penerimaan_detail->Nomor->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Nomor" class="form-group t02_penerimaan_detail_Nomor">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nomor" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nomor" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Nomor->EditValue ?>"<?php echo $t02_penerimaan_detail->Nomor->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nomor" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Nomor" class="form-group t02_penerimaan_detail_Nomor">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nomor" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nomor" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Nomor->EditValue ?>"<?php echo $t02_penerimaan_detail->Nomor->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Nomor" class="t02_penerimaan_detail_Nomor">
<span<?php echo $t02_penerimaan_detail->Nomor->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Nomor->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Kode->Visible) { // Kode ?>
		<td data-name="Kode"<?php echo $t02_penerimaan_detail->Kode->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t02_penerimaan_detail->Kode->getSessionValue() <> "") { ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Kode" class="form-group t02_penerimaan_detail_Kode">
<span<?php echo $t02_penerimaan_detail->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Kode" class="form-group t02_penerimaan_detail_Kode">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Kode" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Kode->EditValue ?>"<?php echo $t02_penerimaan_detail->Kode->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Kode" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t02_penerimaan_detail->Kode->getSessionValue() <> "") { ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Kode" class="form-group t02_penerimaan_detail_Kode">
<span<?php echo $t02_penerimaan_detail->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Kode" class="form-group t02_penerimaan_detail_Kode">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Kode" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Kode->EditValue ?>"<?php echo $t02_penerimaan_detail->Kode->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Kode" class="t02_penerimaan_detail_Kode">
<span<?php echo $t02_penerimaan_detail->Kode->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Kode->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Pos->Visible) { // Pos ?>
		<td data-name="Pos"<?php echo $t02_penerimaan_detail->Pos->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Pos" class="form-group t02_penerimaan_detail_Pos">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Pos" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Pos" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Pos->EditValue ?>"<?php echo $t02_penerimaan_detail->Pos->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Pos" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Pos" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Pos" class="form-group t02_penerimaan_detail_Pos">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Pos" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Pos" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Pos->EditValue ?>"<?php echo $t02_penerimaan_detail->Pos->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Pos" class="t02_penerimaan_detail_Pos">
<span<?php echo $t02_penerimaan_detail->Pos->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Pos->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Nominal->Visible) { // Nominal ?>
		<td data-name="Nominal"<?php echo $t02_penerimaan_detail->Nominal->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Nominal" class="form-group t02_penerimaan_detail_Nominal">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nominal" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nominal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Nominal->EditValue ?>"<?php echo $t02_penerimaan_detail->Nominal->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nominal" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Nominal" class="form-group t02_penerimaan_detail_Nominal">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nominal" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nominal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Nominal->EditValue ?>"<?php echo $t02_penerimaan_detail->Nominal->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Nominal" class="t02_penerimaan_detail_Nominal">
<span<?php echo $t02_penerimaan_detail->Nominal->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Nominal->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Banyaknya->Visible) { // Banyaknya ?>
		<td data-name="Banyaknya"<?php echo $t02_penerimaan_detail->Banyaknya->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Banyaknya" class="form-group t02_penerimaan_detail_Banyaknya">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Banyaknya" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Banyaknya" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Banyaknya->EditValue ?>"<?php echo $t02_penerimaan_detail->Banyaknya->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Banyaknya" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Banyaknya" class="form-group t02_penerimaan_detail_Banyaknya">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Banyaknya" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Banyaknya" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Banyaknya->EditValue ?>"<?php echo $t02_penerimaan_detail->Banyaknya->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Banyaknya" class="t02_penerimaan_detail_Banyaknya">
<span<?php echo $t02_penerimaan_detail->Banyaknya->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Banyaknya->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Satuan->Visible) { // Satuan ?>
		<td data-name="Satuan"<?php echo $t02_penerimaan_detail->Satuan->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Satuan" class="form-group t02_penerimaan_detail_Satuan">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Satuan" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Satuan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Satuan->EditValue ?>"<?php echo $t02_penerimaan_detail->Satuan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Satuan" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Satuan" class="form-group t02_penerimaan_detail_Satuan">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Satuan" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Satuan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Satuan->EditValue ?>"<?php echo $t02_penerimaan_detail->Satuan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Satuan" class="t02_penerimaan_detail_Satuan">
<span<?php echo $t02_penerimaan_detail->Satuan->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Satuan->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Jumlah->Visible) { // Jumlah ?>
		<td data-name="Jumlah"<?php echo $t02_penerimaan_detail->Jumlah->CellAttributes() ?>>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Jumlah" class="form-group t02_penerimaan_detail_Jumlah">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Jumlah" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Jumlah->EditValue ?>"<?php echo $t02_penerimaan_detail->Jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Jumlah" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->OldValue) ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Jumlah" class="form-group t02_penerimaan_detail_Jumlah">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Jumlah" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Jumlah->EditValue ?>"<?php echo $t02_penerimaan_detail->Jumlah->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_penerimaan_detail_list->RowCnt ?>_t02_penerimaan_detail_Jumlah" class="t02_penerimaan_detail_Jumlah">
<span<?php echo $t02_penerimaan_detail->Jumlah->ViewAttributes() ?>>
<?php echo $t02_penerimaan_detail->Jumlah->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t02_penerimaan_detail_list->ListOptions->Render("body", "right", $t02_penerimaan_detail_list->RowCnt);
?>
	</tr>
<?php if ($t02_penerimaan_detail->RowType == EW_ROWTYPE_ADD || $t02_penerimaan_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft02_penerimaan_detaillist.UpdateOpts(<?php echo $t02_penerimaan_detail_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t02_penerimaan_detail->CurrentAction <> "gridadd")
		if (!$t02_penerimaan_detail_list->Recordset->EOF) $t02_penerimaan_detail_list->Recordset->MoveNext();
}
?>
<?php
	if ($t02_penerimaan_detail->CurrentAction == "gridadd" || $t02_penerimaan_detail->CurrentAction == "gridedit") {
		$t02_penerimaan_detail_list->RowIndex = '$rowindex$';
		$t02_penerimaan_detail_list->LoadRowValues();

		// Set row properties
		$t02_penerimaan_detail->ResetAttrs();
		$t02_penerimaan_detail->RowAttrs = array_merge($t02_penerimaan_detail->RowAttrs, array('data-rowindex'=>$t02_penerimaan_detail_list->RowIndex, 'id'=>'r0_t02_penerimaan_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t02_penerimaan_detail->RowAttrs["class"], "ewTemplate");
		$t02_penerimaan_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t02_penerimaan_detail_list->RenderRow();

		// Render list options
		$t02_penerimaan_detail_list->RenderListOptions();
		$t02_penerimaan_detail_list->StartRowCnt = 0;
?>
	<tr<?php echo $t02_penerimaan_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t02_penerimaan_detail_list->ListOptions->Render("body", "left", $t02_penerimaan_detail_list->RowIndex);
?>
	<?php if ($t02_penerimaan_detail->Urutan->Visible) { // Urutan ?>
		<td data-name="Urutan">
<span id="el$rowindex$_t02_penerimaan_detail_Urutan" class="form-group t02_penerimaan_detail_Urutan">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Urutan" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Urutan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Urutan->EditValue ?>"<?php echo $t02_penerimaan_detail->Urutan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Urutan" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Urutan" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Urutan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Nomor->Visible) { // Nomor ?>
		<td data-name="Nomor">
<span id="el$rowindex$_t02_penerimaan_detail_Nomor" class="form-group t02_penerimaan_detail_Nomor">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nomor" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nomor" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Nomor->EditValue ?>"<?php echo $t02_penerimaan_detail->Nomor->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nomor" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nomor" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nomor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Kode->Visible) { // Kode ?>
		<td data-name="Kode">
<?php if ($t02_penerimaan_detail->Kode->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Kode" class="form-group t02_penerimaan_detail_Kode">
<span<?php echo $t02_penerimaan_detail->Kode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t02_penerimaan_detail->Kode->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t02_penerimaan_detail_Kode" class="form-group t02_penerimaan_detail_Kode">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Kode" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" size="30" maxlength="15" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Kode->EditValue ?>"<?php echo $t02_penerimaan_detail->Kode->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Kode" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Kode" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Kode->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Pos->Visible) { // Pos ?>
		<td data-name="Pos">
<span id="el$rowindex$_t02_penerimaan_detail_Pos" class="form-group t02_penerimaan_detail_Pos">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Pos" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Pos" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Pos->EditValue ?>"<?php echo $t02_penerimaan_detail->Pos->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Pos" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Pos" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Pos->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Nominal->Visible) { // Nominal ?>
		<td data-name="Nominal">
<span id="el$rowindex$_t02_penerimaan_detail_Nominal" class="form-group t02_penerimaan_detail_Nominal">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nominal" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nominal" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Nominal->EditValue ?>"<?php echo $t02_penerimaan_detail->Nominal->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Nominal" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nominal" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Nominal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Banyaknya->Visible) { // Banyaknya ?>
		<td data-name="Banyaknya">
<span id="el$rowindex$_t02_penerimaan_detail_Banyaknya" class="form-group t02_penerimaan_detail_Banyaknya">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Banyaknya" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Banyaknya" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Banyaknya->EditValue ?>"<?php echo $t02_penerimaan_detail->Banyaknya->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Banyaknya" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Banyaknya" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Banyaknya" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Banyaknya->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Satuan->Visible) { // Satuan ?>
		<td data-name="Satuan">
<span id="el$rowindex$_t02_penerimaan_detail_Satuan" class="form-group t02_penerimaan_detail_Satuan">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Satuan" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Satuan" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Satuan->EditValue ?>"<?php echo $t02_penerimaan_detail->Satuan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Satuan" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Satuan" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Satuan" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Satuan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_penerimaan_detail->Jumlah->Visible) { // Jumlah ?>
		<td data-name="Jumlah">
<span id="el$rowindex$_t02_penerimaan_detail_Jumlah" class="form-group t02_penerimaan_detail_Jumlah">
<input type="text" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Jumlah" id="x<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t02_penerimaan_detail->Jumlah->EditValue ?>"<?php echo $t02_penerimaan_detail->Jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_penerimaan_detail" data-field="x_Jumlah" name="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Jumlah" id="o<?php echo $t02_penerimaan_detail_list->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t02_penerimaan_detail->Jumlah->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t02_penerimaan_detail_list->ListOptions->Render("body", "right", $t02_penerimaan_detail_list->RowIndex);
?>
<script type="text/javascript">
ft02_penerimaan_detaillist.UpdateOpts(<?php echo $t02_penerimaan_detail_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t02_penerimaan_detail->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $t02_penerimaan_detail_list->FormKeyCountName ?>" id="<?php echo $t02_penerimaan_detail_list->FormKeyCountName ?>" value="<?php echo $t02_penerimaan_detail_list->KeyCount ?>">
<?php } ?>
<?php if ($t02_penerimaan_detail->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t02_penerimaan_detail_list->FormKeyCountName ?>" id="<?php echo $t02_penerimaan_detail_list->FormKeyCountName ?>" value="<?php echo $t02_penerimaan_detail_list->KeyCount ?>">
<?php echo $t02_penerimaan_detail_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t02_penerimaan_detail->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t02_penerimaan_detail_list->Recordset)
	$t02_penerimaan_detail_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($t02_penerimaan_detail->CurrentAction <> "gridadd" && $t02_penerimaan_detail->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t02_penerimaan_detail_list->Pager)) $t02_penerimaan_detail_list->Pager = new cPrevNextPager($t02_penerimaan_detail_list->StartRec, $t02_penerimaan_detail_list->DisplayRecs, $t02_penerimaan_detail_list->TotalRecs, $t02_penerimaan_detail_list->AutoHidePager) ?>
<?php if ($t02_penerimaan_detail_list->Pager->RecordCount > 0 && $t02_penerimaan_detail_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t02_penerimaan_detail_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t02_penerimaan_detail_list->PageUrl() ?>start=<?php echo $t02_penerimaan_detail_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t02_penerimaan_detail_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t02_penerimaan_detail_list->PageUrl() ?>start=<?php echo $t02_penerimaan_detail_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t02_penerimaan_detail_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t02_penerimaan_detail_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t02_penerimaan_detail_list->PageUrl() ?>start=<?php echo $t02_penerimaan_detail_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t02_penerimaan_detail_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t02_penerimaan_detail_list->PageUrl() ?>start=<?php echo $t02_penerimaan_detail_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t02_penerimaan_detail_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t02_penerimaan_detail_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t02_penerimaan_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t02_penerimaan_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t02_penerimaan_detail_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t02_penerimaan_detail_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t02_penerimaan_detail_list->TotalRecs == 0 && $t02_penerimaan_detail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t02_penerimaan_detail_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft02_penerimaan_detaillist.Init();
</script>
<?php
$t02_penerimaan_detail_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t02_penerimaan_detail_list->Page_Terminate();
?>
