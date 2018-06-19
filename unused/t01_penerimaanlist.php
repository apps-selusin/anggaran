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

$t01_penerimaan_list = NULL; // Initialize page object first

class ct01_penerimaan_list extends ct01_penerimaan {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{EA1CE07B-E03E-4EC9-BC42-48D490D73F97}';

	// Table name
	var $TableName = 't01_penerimaan';

	// Page object name
	var $PageObjName = 't01_penerimaan_list';

	// Grid form hidden field names
	var $FormName = 'ft01_penerimaanlist';
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

		// Table object (t01_penerimaan)
		if (!isset($GLOBALS["t01_penerimaan"]) || get_class($GLOBALS["t01_penerimaan"]) == "ct01_penerimaan") {
			$GLOBALS["t01_penerimaan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t01_penerimaan"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t01_penerimaanadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t01_penerimaandelete.php";
		$this->MultiUpdateUrl = "t01_penerimaanupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft01_penerimaanlistsrch";

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

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();
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

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();
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

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Process filter list
			$this->ProcessFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
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

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->Command <> "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);
		if ($sFilter == "") {
			$sFilter = "0=101";
			$this->SearchWhere = $sFilter;
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
		$this->Nominal->FormValue = ""; // Clear form value
		$this->Jumlah->FormValue = ""; // Clear form value
		$this->Total->FormValue = ""; // Clear form value
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		$this->CurrentAction = "add";
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old record
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
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
		if ($objForm->HasValue("x_Departemen") && $objForm->HasValue("o_Departemen") && $this->Departemen->CurrentValue <> $this->Departemen->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_HeadDetail") && $objForm->HasValue("o_HeadDetail") && $this->HeadDetail->CurrentValue <> $this->HeadDetail->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_NomorHead") && $objForm->HasValue("o_NomorHead") && $this->NomorHead->CurrentValue <> $this->NomorHead->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_SubTotalFlag") && $objForm->HasValue("o_SubTotalFlag") && $this->SubTotalFlag->CurrentValue <> $this->SubTotalFlag->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Urutan") && $objForm->HasValue("o_Urutan") && $this->Urutan->CurrentValue <> $this->Urutan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Nomor") && $objForm->HasValue("o_Nomor") && $this->Nomor->CurrentValue <> $this->Nomor->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Pos") && $objForm->HasValue("o_Pos") && $this->Pos->CurrentValue <> $this->Pos->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Nominal") && $objForm->HasValue("o_Nominal") && $this->Nominal->CurrentValue <> $this->Nominal->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_JumlahSiswa") && $objForm->HasValue("o_JumlahSiswa") && $this->JumlahSiswa->CurrentValue <> $this->JumlahSiswa->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Bulan") && $objForm->HasValue("o_Bulan") && $this->Bulan->CurrentValue <> $this->Bulan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Jumlah") && $objForm->HasValue("o_Jumlah") && $this->Jumlah->CurrentValue <> $this->Jumlah->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Total") && $objForm->HasValue("o_Total") && $this->Total->CurrentValue <> $this->Total->OldValue)
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

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Initialize
		$sFilterList = "";
		$sSavedFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJson(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->Departemen->AdvancedSearch->ToJson(), ","); // Field Departemen
		$sFilterList = ew_Concat($sFilterList, $this->HeadDetail->AdvancedSearch->ToJson(), ","); // Field HeadDetail
		$sFilterList = ew_Concat($sFilterList, $this->NomorHead->AdvancedSearch->ToJson(), ","); // Field NomorHead
		$sFilterList = ew_Concat($sFilterList, $this->SubTotalFlag->AdvancedSearch->ToJson(), ","); // Field SubTotalFlag
		$sFilterList = ew_Concat($sFilterList, $this->Urutan->AdvancedSearch->ToJson(), ","); // Field Urutan
		$sFilterList = ew_Concat($sFilterList, $this->Nomor->AdvancedSearch->ToJson(), ","); // Field Nomor
		$sFilterList = ew_Concat($sFilterList, $this->Pos->AdvancedSearch->ToJson(), ","); // Field Pos
		$sFilterList = ew_Concat($sFilterList, $this->Nominal->AdvancedSearch->ToJson(), ","); // Field Nominal
		$sFilterList = ew_Concat($sFilterList, $this->JumlahSiswa->AdvancedSearch->ToJson(), ","); // Field JumlahSiswa
		$sFilterList = ew_Concat($sFilterList, $this->Bulan->AdvancedSearch->ToJson(), ","); // Field Bulan
		$sFilterList = ew_Concat($sFilterList, $this->Jumlah->AdvancedSearch->ToJson(), ","); // Field Jumlah
		$sFilterList = ew_Concat($sFilterList, $this->Total->AdvancedSearch->ToJson(), ","); // Field Total
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = @$_POST["filters"];
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft01_penerimaanlistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		$this->Command = "search";

		// Field id
		$this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
		$this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
		$this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
		$this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
		$this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
		$this->id->AdvancedSearch->Save();

		// Field Departemen
		$this->Departemen->AdvancedSearch->SearchValue = @$filter["x_Departemen"];
		$this->Departemen->AdvancedSearch->SearchOperator = @$filter["z_Departemen"];
		$this->Departemen->AdvancedSearch->SearchCondition = @$filter["v_Departemen"];
		$this->Departemen->AdvancedSearch->SearchValue2 = @$filter["y_Departemen"];
		$this->Departemen->AdvancedSearch->SearchOperator2 = @$filter["w_Departemen"];
		$this->Departemen->AdvancedSearch->Save();

		// Field HeadDetail
		$this->HeadDetail->AdvancedSearch->SearchValue = @$filter["x_HeadDetail"];
		$this->HeadDetail->AdvancedSearch->SearchOperator = @$filter["z_HeadDetail"];
		$this->HeadDetail->AdvancedSearch->SearchCondition = @$filter["v_HeadDetail"];
		$this->HeadDetail->AdvancedSearch->SearchValue2 = @$filter["y_HeadDetail"];
		$this->HeadDetail->AdvancedSearch->SearchOperator2 = @$filter["w_HeadDetail"];
		$this->HeadDetail->AdvancedSearch->Save();

		// Field NomorHead
		$this->NomorHead->AdvancedSearch->SearchValue = @$filter["x_NomorHead"];
		$this->NomorHead->AdvancedSearch->SearchOperator = @$filter["z_NomorHead"];
		$this->NomorHead->AdvancedSearch->SearchCondition = @$filter["v_NomorHead"];
		$this->NomorHead->AdvancedSearch->SearchValue2 = @$filter["y_NomorHead"];
		$this->NomorHead->AdvancedSearch->SearchOperator2 = @$filter["w_NomorHead"];
		$this->NomorHead->AdvancedSearch->Save();

		// Field SubTotalFlag
		$this->SubTotalFlag->AdvancedSearch->SearchValue = @$filter["x_SubTotalFlag"];
		$this->SubTotalFlag->AdvancedSearch->SearchOperator = @$filter["z_SubTotalFlag"];
		$this->SubTotalFlag->AdvancedSearch->SearchCondition = @$filter["v_SubTotalFlag"];
		$this->SubTotalFlag->AdvancedSearch->SearchValue2 = @$filter["y_SubTotalFlag"];
		$this->SubTotalFlag->AdvancedSearch->SearchOperator2 = @$filter["w_SubTotalFlag"];
		$this->SubTotalFlag->AdvancedSearch->Save();

		// Field Urutan
		$this->Urutan->AdvancedSearch->SearchValue = @$filter["x_Urutan"];
		$this->Urutan->AdvancedSearch->SearchOperator = @$filter["z_Urutan"];
		$this->Urutan->AdvancedSearch->SearchCondition = @$filter["v_Urutan"];
		$this->Urutan->AdvancedSearch->SearchValue2 = @$filter["y_Urutan"];
		$this->Urutan->AdvancedSearch->SearchOperator2 = @$filter["w_Urutan"];
		$this->Urutan->AdvancedSearch->Save();

		// Field Nomor
		$this->Nomor->AdvancedSearch->SearchValue = @$filter["x_Nomor"];
		$this->Nomor->AdvancedSearch->SearchOperator = @$filter["z_Nomor"];
		$this->Nomor->AdvancedSearch->SearchCondition = @$filter["v_Nomor"];
		$this->Nomor->AdvancedSearch->SearchValue2 = @$filter["y_Nomor"];
		$this->Nomor->AdvancedSearch->SearchOperator2 = @$filter["w_Nomor"];
		$this->Nomor->AdvancedSearch->Save();

		// Field Pos
		$this->Pos->AdvancedSearch->SearchValue = @$filter["x_Pos"];
		$this->Pos->AdvancedSearch->SearchOperator = @$filter["z_Pos"];
		$this->Pos->AdvancedSearch->SearchCondition = @$filter["v_Pos"];
		$this->Pos->AdvancedSearch->SearchValue2 = @$filter["y_Pos"];
		$this->Pos->AdvancedSearch->SearchOperator2 = @$filter["w_Pos"];
		$this->Pos->AdvancedSearch->Save();

		// Field Nominal
		$this->Nominal->AdvancedSearch->SearchValue = @$filter["x_Nominal"];
		$this->Nominal->AdvancedSearch->SearchOperator = @$filter["z_Nominal"];
		$this->Nominal->AdvancedSearch->SearchCondition = @$filter["v_Nominal"];
		$this->Nominal->AdvancedSearch->SearchValue2 = @$filter["y_Nominal"];
		$this->Nominal->AdvancedSearch->SearchOperator2 = @$filter["w_Nominal"];
		$this->Nominal->AdvancedSearch->Save();

		// Field JumlahSiswa
		$this->JumlahSiswa->AdvancedSearch->SearchValue = @$filter["x_JumlahSiswa"];
		$this->JumlahSiswa->AdvancedSearch->SearchOperator = @$filter["z_JumlahSiswa"];
		$this->JumlahSiswa->AdvancedSearch->SearchCondition = @$filter["v_JumlahSiswa"];
		$this->JumlahSiswa->AdvancedSearch->SearchValue2 = @$filter["y_JumlahSiswa"];
		$this->JumlahSiswa->AdvancedSearch->SearchOperator2 = @$filter["w_JumlahSiswa"];
		$this->JumlahSiswa->AdvancedSearch->Save();

		// Field Bulan
		$this->Bulan->AdvancedSearch->SearchValue = @$filter["x_Bulan"];
		$this->Bulan->AdvancedSearch->SearchOperator = @$filter["z_Bulan"];
		$this->Bulan->AdvancedSearch->SearchCondition = @$filter["v_Bulan"];
		$this->Bulan->AdvancedSearch->SearchValue2 = @$filter["y_Bulan"];
		$this->Bulan->AdvancedSearch->SearchOperator2 = @$filter["w_Bulan"];
		$this->Bulan->AdvancedSearch->Save();

		// Field Jumlah
		$this->Jumlah->AdvancedSearch->SearchValue = @$filter["x_Jumlah"];
		$this->Jumlah->AdvancedSearch->SearchOperator = @$filter["z_Jumlah"];
		$this->Jumlah->AdvancedSearch->SearchCondition = @$filter["v_Jumlah"];
		$this->Jumlah->AdvancedSearch->SearchValue2 = @$filter["y_Jumlah"];
		$this->Jumlah->AdvancedSearch->SearchOperator2 = @$filter["w_Jumlah"];
		$this->Jumlah->AdvancedSearch->Save();

		// Field Total
		$this->Total->AdvancedSearch->SearchValue = @$filter["x_Total"];
		$this->Total->AdvancedSearch->SearchOperator = @$filter["z_Total"];
		$this->Total->AdvancedSearch->SearchCondition = @$filter["v_Total"];
		$this->Total->AdvancedSearch->SearchValue2 = @$filter["y_Total"];
		$this->Total->AdvancedSearch->SearchOperator2 = @$filter["w_Total"];
		$this->Total->AdvancedSearch->Save();
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $this->id, $Default, FALSE); // id
		$this->BuildSearchSql($sWhere, $this->Departemen, $Default, FALSE); // Departemen
		$this->BuildSearchSql($sWhere, $this->HeadDetail, $Default, FALSE); // HeadDetail
		$this->BuildSearchSql($sWhere, $this->NomorHead, $Default, FALSE); // NomorHead
		$this->BuildSearchSql($sWhere, $this->SubTotalFlag, $Default, FALSE); // SubTotalFlag
		$this->BuildSearchSql($sWhere, $this->Urutan, $Default, FALSE); // Urutan
		$this->BuildSearchSql($sWhere, $this->Nomor, $Default, FALSE); // Nomor
		$this->BuildSearchSql($sWhere, $this->Pos, $Default, FALSE); // Pos
		$this->BuildSearchSql($sWhere, $this->Nominal, $Default, FALSE); // Nominal
		$this->BuildSearchSql($sWhere, $this->JumlahSiswa, $Default, FALSE); // JumlahSiswa
		$this->BuildSearchSql($sWhere, $this->Bulan, $Default, FALSE); // Bulan
		$this->BuildSearchSql($sWhere, $this->Jumlah, $Default, FALSE); // Jumlah
		$this->BuildSearchSql($sWhere, $this->Total, $Default, FALSE); // Total

		// Set up search parm
		if (!$Default && $sWhere <> "" && in_array($this->Command, array("", "reset", "resetall"))) {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->id->AdvancedSearch->Save(); // id
			$this->Departemen->AdvancedSearch->Save(); // Departemen
			$this->HeadDetail->AdvancedSearch->Save(); // HeadDetail
			$this->NomorHead->AdvancedSearch->Save(); // NomorHead
			$this->SubTotalFlag->AdvancedSearch->Save(); // SubTotalFlag
			$this->Urutan->AdvancedSearch->Save(); // Urutan
			$this->Nomor->AdvancedSearch->Save(); // Nomor
			$this->Pos->AdvancedSearch->Save(); // Pos
			$this->Nominal->AdvancedSearch->Save(); // Nominal
			$this->JumlahSiswa->AdvancedSearch->Save(); // JumlahSiswa
			$this->Bulan->AdvancedSearch->Save(); // Bulan
			$this->Jumlah->AdvancedSearch->Save(); // Jumlah
			$this->Total->AdvancedSearch->Save(); // Total
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = $Fld->FldParm();
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1)
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE || $Fld->FldDataType == EW_DATATYPE_TIME) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Check if search parm exists
	function CheckSearchParms() {
		if ($this->id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Departemen->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->HeadDetail->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->NomorHead->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->SubTotalFlag->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Urutan->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nomor->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Pos->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nominal->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->JumlahSiswa->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Bulan->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Jumlah->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Total->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->id->AdvancedSearch->UnsetSession();
		$this->Departemen->AdvancedSearch->UnsetSession();
		$this->HeadDetail->AdvancedSearch->UnsetSession();
		$this->NomorHead->AdvancedSearch->UnsetSession();
		$this->SubTotalFlag->AdvancedSearch->UnsetSession();
		$this->Urutan->AdvancedSearch->UnsetSession();
		$this->Nomor->AdvancedSearch->UnsetSession();
		$this->Pos->AdvancedSearch->UnsetSession();
		$this->Nominal->AdvancedSearch->UnsetSession();
		$this->JumlahSiswa->AdvancedSearch->UnsetSession();
		$this->Bulan->AdvancedSearch->UnsetSession();
		$this->Jumlah->AdvancedSearch->UnsetSession();
		$this->Total->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore advanced search values
		$this->id->AdvancedSearch->Load();
		$this->Departemen->AdvancedSearch->Load();
		$this->HeadDetail->AdvancedSearch->Load();
		$this->NomorHead->AdvancedSearch->Load();
		$this->SubTotalFlag->AdvancedSearch->Load();
		$this->Urutan->AdvancedSearch->Load();
		$this->Nomor->AdvancedSearch->Load();
		$this->Pos->AdvancedSearch->Load();
		$this->Nominal->AdvancedSearch->Load();
		$this->JumlahSiswa->AdvancedSearch->Load();
		$this->Bulan->AdvancedSearch->Load();
		$this->Jumlah->AdvancedSearch->Load();
		$this->Total->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Departemen, $bCtrl); // Departemen
			$this->UpdateSort($this->HeadDetail, $bCtrl); // HeadDetail
			$this->UpdateSort($this->NomorHead, $bCtrl); // NomorHead
			$this->UpdateSort($this->SubTotalFlag, $bCtrl); // SubTotalFlag
			$this->UpdateSort($this->Urutan, $bCtrl); // Urutan
			$this->UpdateSort($this->Nomor, $bCtrl); // Nomor
			$this->UpdateSort($this->Pos, $bCtrl); // Pos
			$this->UpdateSort($this->Nominal, $bCtrl); // Nominal
			$this->UpdateSort($this->JumlahSiswa, $bCtrl); // JumlahSiswa
			$this->UpdateSort($this->Bulan, $bCtrl); // Bulan
			$this->UpdateSort($this->Jumlah, $bCtrl); // Jumlah
			$this->UpdateSort($this->Total, $bCtrl); // Total
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

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Departemen->setSort("");
				$this->HeadDetail->setSort("");
				$this->NomorHead->setSort("");
				$this->SubTotalFlag->setSort("");
				$this->Urutan->setSort("");
				$this->Nomor->setSort("");
				$this->Pos->setSort("");
				$this->Nominal->setSort("");
				$this->JumlahSiswa->setSort("");
				$this->Bulan->setSort("");
				$this->Jumlah->setSort("");
				$this->Total->setSort("");
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

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = ($this->CurrentAction == "add");
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

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
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
		$option = $options["addedit"];

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "");

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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft01_penerimaanlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft01_penerimaanlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft01_penerimaanlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft01_penerimaanlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ResetSearch") . "\" data-caption=\"" . $Language->Phrase("ResetSearch") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ResetSearchBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

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
		$this->Departemen->CurrentValue = "-";
		$this->Departemen->OldValue = $this->Departemen->CurrentValue;
		$this->HeadDetail->CurrentValue = "H";
		$this->HeadDetail->OldValue = $this->HeadDetail->CurrentValue;
		$this->NomorHead->CurrentValue = 0;
		$this->NomorHead->OldValue = $this->NomorHead->CurrentValue;
		$this->SubTotalFlag->CurrentValue = "N";
		$this->SubTotalFlag->OldValue = $this->SubTotalFlag->CurrentValue;
		$this->Urutan->CurrentValue = 0;
		$this->Urutan->OldValue = $this->Urutan->CurrentValue;
		$this->Nomor->CurrentValue = "-";
		$this->Nomor->OldValue = $this->Nomor->CurrentValue;
		$this->Pos->CurrentValue = "-";
		$this->Pos->OldValue = $this->Pos->CurrentValue;
		$this->Nominal->CurrentValue = 0.00;
		$this->Nominal->OldValue = $this->Nominal->CurrentValue;
		$this->JumlahSiswa->CurrentValue = 0;
		$this->JumlahSiswa->OldValue = $this->JumlahSiswa->CurrentValue;
		$this->Bulan->CurrentValue = 0;
		$this->Bulan->OldValue = $this->Bulan->CurrentValue;
		$this->Jumlah->CurrentValue = 0.00;
		$this->Jumlah->OldValue = $this->Jumlah->CurrentValue;
		$this->Total->CurrentValue = 0.00;
		$this->Total->OldValue = $this->Total->CurrentValue;
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// id

		$this->id->AdvancedSearch->SearchValue = @$_GET["x_id"];
		if ($this->id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->id->AdvancedSearch->SearchOperator = @$_GET["z_id"];

		// Departemen
		$this->Departemen->AdvancedSearch->SearchValue = @$_GET["x_Departemen"];
		if ($this->Departemen->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->Departemen->AdvancedSearch->SearchOperator = @$_GET["z_Departemen"];

		// HeadDetail
		$this->HeadDetail->AdvancedSearch->SearchValue = @$_GET["x_HeadDetail"];
		if ($this->HeadDetail->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->HeadDetail->AdvancedSearch->SearchOperator = @$_GET["z_HeadDetail"];

		// NomorHead
		$this->NomorHead->AdvancedSearch->SearchValue = @$_GET["x_NomorHead"];
		if ($this->NomorHead->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->NomorHead->AdvancedSearch->SearchOperator = @$_GET["z_NomorHead"];

		// SubTotalFlag
		$this->SubTotalFlag->AdvancedSearch->SearchValue = @$_GET["x_SubTotalFlag"];
		if ($this->SubTotalFlag->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->SubTotalFlag->AdvancedSearch->SearchOperator = @$_GET["z_SubTotalFlag"];

		// Urutan
		$this->Urutan->AdvancedSearch->SearchValue = @$_GET["x_Urutan"];
		if ($this->Urutan->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->Urutan->AdvancedSearch->SearchOperator = @$_GET["z_Urutan"];

		// Nomor
		$this->Nomor->AdvancedSearch->SearchValue = @$_GET["x_Nomor"];
		if ($this->Nomor->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->Nomor->AdvancedSearch->SearchOperator = @$_GET["z_Nomor"];

		// Pos
		$this->Pos->AdvancedSearch->SearchValue = @$_GET["x_Pos"];
		if ($this->Pos->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->Pos->AdvancedSearch->SearchOperator = @$_GET["z_Pos"];

		// Nominal
		$this->Nominal->AdvancedSearch->SearchValue = @$_GET["x_Nominal"];
		if ($this->Nominal->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->Nominal->AdvancedSearch->SearchOperator = @$_GET["z_Nominal"];

		// JumlahSiswa
		$this->JumlahSiswa->AdvancedSearch->SearchValue = @$_GET["x_JumlahSiswa"];
		if ($this->JumlahSiswa->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->JumlahSiswa->AdvancedSearch->SearchOperator = @$_GET["z_JumlahSiswa"];

		// Bulan
		$this->Bulan->AdvancedSearch->SearchValue = @$_GET["x_Bulan"];
		if ($this->Bulan->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->Bulan->AdvancedSearch->SearchOperator = @$_GET["z_Bulan"];

		// Jumlah
		$this->Jumlah->AdvancedSearch->SearchValue = @$_GET["x_Jumlah"];
		if ($this->Jumlah->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->Jumlah->AdvancedSearch->SearchOperator = @$_GET["z_Jumlah"];

		// Total
		$this->Total->AdvancedSearch->SearchValue = @$_GET["x_Total"];
		if ($this->Total->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->Total->AdvancedSearch->SearchOperator = @$_GET["z_Total"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
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
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
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
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['Departemen'] = $this->Departemen->CurrentValue;
		$row['HeadDetail'] = $this->HeadDetail->CurrentValue;
		$row['NomorHead'] = $this->NomorHead->CurrentValue;
		$row['SubTotalFlag'] = $this->SubTotalFlag->CurrentValue;
		$row['Urutan'] = $this->Urutan->CurrentValue;
		$row['Nomor'] = $this->Nomor->CurrentValue;
		$row['Pos'] = $this->Pos->CurrentValue;
		$row['Nominal'] = $this->Nominal->CurrentValue;
		$row['JumlahSiswa'] = $this->JumlahSiswa->CurrentValue;
		$row['Bulan'] = $this->Bulan->CurrentValue;
		$row['Jumlah'] = $this->Jumlah->CurrentValue;
		$row['Total'] = $this->Total->CurrentValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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

			// Add refer script
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Departemen
			$this->Departemen->EditAttrs["class"] = "form-control";
			$this->Departemen->EditCustomAttributes = "";
			if (trim(strval($this->Departemen->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`departemen`" . ew_SearchString("=", $this->Departemen->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "jbsakad");
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
			$this->HeadDetail->EditValue = ew_HtmlEncode($this->HeadDetail->AdvancedSearch->SearchValue);
			$this->HeadDetail->PlaceHolder = ew_RemoveHtml($this->HeadDetail->FldCaption());

			// NomorHead
			$this->NomorHead->EditAttrs["class"] = "form-control";
			$this->NomorHead->EditCustomAttributes = "";
			$this->NomorHead->EditValue = ew_HtmlEncode($this->NomorHead->AdvancedSearch->SearchValue);
			$this->NomorHead->PlaceHolder = ew_RemoveHtml($this->NomorHead->FldCaption());

			// SubTotalFlag
			$this->SubTotalFlag->EditAttrs["class"] = "form-control";
			$this->SubTotalFlag->EditCustomAttributes = "";
			$this->SubTotalFlag->EditValue = ew_HtmlEncode($this->SubTotalFlag->AdvancedSearch->SearchValue);
			$this->SubTotalFlag->PlaceHolder = ew_RemoveHtml($this->SubTotalFlag->FldCaption());

			// Urutan
			$this->Urutan->EditAttrs["class"] = "form-control";
			$this->Urutan->EditCustomAttributes = "";
			$this->Urutan->EditValue = ew_HtmlEncode($this->Urutan->AdvancedSearch->SearchValue);
			$this->Urutan->PlaceHolder = ew_RemoveHtml($this->Urutan->FldCaption());

			// Nomor
			$this->Nomor->EditAttrs["class"] = "form-control";
			$this->Nomor->EditCustomAttributes = "";
			$this->Nomor->EditValue = ew_HtmlEncode($this->Nomor->AdvancedSearch->SearchValue);
			$this->Nomor->PlaceHolder = ew_RemoveHtml($this->Nomor->FldCaption());

			// Pos
			$this->Pos->EditAttrs["class"] = "form-control";
			$this->Pos->EditCustomAttributes = "";
			$this->Pos->EditValue = ew_HtmlEncode($this->Pos->AdvancedSearch->SearchValue);
			$this->Pos->PlaceHolder = ew_RemoveHtml($this->Pos->FldCaption());

			// Nominal
			$this->Nominal->EditAttrs["class"] = "form-control";
			$this->Nominal->EditCustomAttributes = "";
			$this->Nominal->EditValue = ew_HtmlEncode($this->Nominal->AdvancedSearch->SearchValue);
			$this->Nominal->PlaceHolder = ew_RemoveHtml($this->Nominal->FldCaption());

			// JumlahSiswa
			$this->JumlahSiswa->EditAttrs["class"] = "form-control";
			$this->JumlahSiswa->EditCustomAttributes = "";
			$this->JumlahSiswa->EditValue = ew_HtmlEncode($this->JumlahSiswa->AdvancedSearch->SearchValue);
			$this->JumlahSiswa->PlaceHolder = ew_RemoveHtml($this->JumlahSiswa->FldCaption());

			// Bulan
			$this->Bulan->EditAttrs["class"] = "form-control";
			$this->Bulan->EditCustomAttributes = "";
			$this->Bulan->EditValue = ew_HtmlEncode($this->Bulan->AdvancedSearch->SearchValue);
			$this->Bulan->PlaceHolder = ew_RemoveHtml($this->Bulan->FldCaption());

			// Jumlah
			$this->Jumlah->EditAttrs["class"] = "form-control";
			$this->Jumlah->EditCustomAttributes = "";
			$this->Jumlah->EditValue = ew_HtmlEncode($this->Jumlah->AdvancedSearch->SearchValue);
			$this->Jumlah->PlaceHolder = ew_RemoveHtml($this->Jumlah->FldCaption());

			// Total
			$this->Total->EditAttrs["class"] = "form-control";
			$this->Total->EditCustomAttributes = "";
			$this->Total->EditValue = ew_HtmlEncode($this->Total->AdvancedSearch->SearchValue);
			$this->Total->PlaceHolder = ew_RemoveHtml($this->Total->FldCaption());
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// Departemen
		$this->Departemen->SetDbValueDef($rsnew, $this->Departemen->CurrentValue, "", strval($this->Departemen->CurrentValue) == "");

		// HeadDetail
		$this->HeadDetail->SetDbValueDef($rsnew, $this->HeadDetail->CurrentValue, "", strval($this->HeadDetail->CurrentValue) == "");

		// NomorHead
		$this->NomorHead->SetDbValueDef($rsnew, $this->NomorHead->CurrentValue, 0, strval($this->NomorHead->CurrentValue) == "");

		// SubTotalFlag
		$this->SubTotalFlag->SetDbValueDef($rsnew, $this->SubTotalFlag->CurrentValue, "", strval($this->SubTotalFlag->CurrentValue) == "");

		// Urutan
		$this->Urutan->SetDbValueDef($rsnew, $this->Urutan->CurrentValue, 0, strval($this->Urutan->CurrentValue) == "");

		// Nomor
		$this->Nomor->SetDbValueDef($rsnew, $this->Nomor->CurrentValue, "", strval($this->Nomor->CurrentValue) == "");

		// Pos
		$this->Pos->SetDbValueDef($rsnew, $this->Pos->CurrentValue, "", strval($this->Pos->CurrentValue) == "");

		// Nominal
		$this->Nominal->SetDbValueDef($rsnew, $this->Nominal->CurrentValue, 0, strval($this->Nominal->CurrentValue) == "");

		// JumlahSiswa
		$this->JumlahSiswa->SetDbValueDef($rsnew, $this->JumlahSiswa->CurrentValue, 0, strval($this->JumlahSiswa->CurrentValue) == "");

		// Bulan
		$this->Bulan->SetDbValueDef($rsnew, $this->Bulan->CurrentValue, 0, strval($this->Bulan->CurrentValue) == "");

		// Jumlah
		$this->Jumlah->SetDbValueDef($rsnew, $this->Jumlah->CurrentValue, 0, strval($this->Jumlah->CurrentValue) == "");

		// Total
		$this->Total->SetDbValueDef($rsnew, $this->Total->CurrentValue, 0, strval($this->Total->CurrentValue) == "");

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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->id->AdvancedSearch->Load();
		$this->Departemen->AdvancedSearch->Load();
		$this->HeadDetail->AdvancedSearch->Load();
		$this->NomorHead->AdvancedSearch->Load();
		$this->SubTotalFlag->AdvancedSearch->Load();
		$this->Urutan->AdvancedSearch->Load();
		$this->Nomor->AdvancedSearch->Load();
		$this->Pos->AdvancedSearch->Load();
		$this->Nominal->AdvancedSearch->Load();
		$this->JumlahSiswa->AdvancedSearch->Load();
		$this->Bulan->AdvancedSearch->Load();
		$this->Jumlah->AdvancedSearch->Load();
		$this->Total->AdvancedSearch->Load();
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
		if ($pageId == "list") {
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
		} elseif ($pageId == "extbs") {
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
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		if ($pageId == "list") {
			switch ($fld->FldVar) {
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
			}
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
		// $this->Departemen->Visible = false;

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
if (!isset($t01_penerimaan_list)) $t01_penerimaan_list = new ct01_penerimaan_list();

// Page init
$t01_penerimaan_list->Page_Init();

// Page main
$t01_penerimaan_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t01_penerimaan_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft01_penerimaanlist = new ew_Form("ft01_penerimaanlist", "list");
ft01_penerimaanlist.FormKeyCountName = '<?php echo $t01_penerimaan_list->FormKeyCountName ?>';

// Validate form
ft01_penerimaanlist.Validate = function() {
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
	return true;
}

// Form_CustomValidate event
ft01_penerimaanlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft01_penerimaanlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft01_penerimaanlist.Lists["x_Departemen"] = {"LinkField":"x_departemen","Ajax":true,"AutoFill":false,"DisplayFields":["x_departemen","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departemen"};
ft01_penerimaanlist.Lists["x_Departemen"].Data = "<?php echo $t01_penerimaan_list->Departemen->LookupFilterQuery(FALSE, "list") ?>";

// Form object for search
var CurrentSearchForm = ft01_penerimaanlistsrch = new ew_Form("ft01_penerimaanlistsrch");

// Validate function for search
ft01_penerimaanlistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
ft01_penerimaanlistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft01_penerimaanlistsrch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft01_penerimaanlistsrch.Lists["x_Departemen"] = {"LinkField":"x_departemen","Ajax":true,"AutoFill":false,"DisplayFields":["x_departemen","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"departemen"};
ft01_penerimaanlistsrch.Lists["x_Departemen"].Data = "<?php echo $t01_penerimaan_list->Departemen->LookupFilterQuery(FALSE, "extbs") ?>";
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($t01_penerimaan_list->TotalRecs > 0 && $t01_penerimaan_list->ExportOptions->Visible()) { ?>
<?php $t01_penerimaan_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t01_penerimaan_list->SearchOptions->Visible()) { ?>
<?php $t01_penerimaan_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t01_penerimaan_list->FilterOptions->Visible()) { ?>
<?php $t01_penerimaan_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $t01_penerimaan_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t01_penerimaan_list->TotalRecs <= 0)
			$t01_penerimaan_list->TotalRecs = $t01_penerimaan->ListRecordCount();
	} else {
		if (!$t01_penerimaan_list->Recordset && ($t01_penerimaan_list->Recordset = $t01_penerimaan_list->LoadRecordset()))
			$t01_penerimaan_list->TotalRecs = $t01_penerimaan_list->Recordset->RecordCount();
	}
	$t01_penerimaan_list->StartRec = 1;
	if ($t01_penerimaan_list->DisplayRecs <= 0 || ($t01_penerimaan->Export <> "" && $t01_penerimaan->ExportAll)) // Display all records
		$t01_penerimaan_list->DisplayRecs = $t01_penerimaan_list->TotalRecs;
	if (!($t01_penerimaan->Export <> "" && $t01_penerimaan->ExportAll))
		$t01_penerimaan_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t01_penerimaan_list->Recordset = $t01_penerimaan_list->LoadRecordset($t01_penerimaan_list->StartRec-1, $t01_penerimaan_list->DisplayRecs);

	// Set no record found message
	if ($t01_penerimaan->CurrentAction == "" && $t01_penerimaan_list->TotalRecs == 0) {
		if ($t01_penerimaan_list->SearchWhere == "0=101")
			$t01_penerimaan_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t01_penerimaan_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$t01_penerimaan_list->RenderOtherOptions();
?>
<?php if ($t01_penerimaan->Export == "" && $t01_penerimaan->CurrentAction == "") { ?>
<form name="ft01_penerimaanlistsrch" id="ft01_penerimaanlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t01_penerimaan_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft01_penerimaanlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t01_penerimaan">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$t01_penerimaan_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$t01_penerimaan->RowType = EW_ROWTYPE_SEARCH;

// Render row
$t01_penerimaan->ResetAttrs();
$t01_penerimaan_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($t01_penerimaan->Departemen->Visible) { // Departemen ?>
	<div id="xsc_Departemen" class="ewCell form-group">
		<label for="x_Departemen" class="ewSearchCaption ewLabel"><?php echo $t01_penerimaan->Departemen->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Departemen" id="z_Departemen" value="LIKE"></span>
		<span class="ewSearchField">
<select data-table="t01_penerimaan" data-field="x_Departemen" data-value-separator="<?php echo $t01_penerimaan->Departemen->DisplayValueSeparatorAttribute() ?>" id="x_Departemen" name="x_Departemen"<?php echo $t01_penerimaan->Departemen->EditAttributes() ?>>
<?php echo $t01_penerimaan->Departemen->SelectOptionListHtml("x_Departemen") ?>
</select>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $t01_penerimaan_list->ShowPageHeader(); ?>
<?php
$t01_penerimaan_list->ShowMessage();
?>
<?php if ($t01_penerimaan_list->TotalRecs > 0 || $t01_penerimaan->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t01_penerimaan_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t01_penerimaan">
<form name="ft01_penerimaanlist" id="ft01_penerimaanlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t01_penerimaan_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t01_penerimaan_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t01_penerimaan">
<div id="gmp_t01_penerimaan" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($t01_penerimaan_list->TotalRecs > 0 || $t01_penerimaan->CurrentAction == "add" || $t01_penerimaan->CurrentAction == "copy" || $t01_penerimaan->CurrentAction == "gridedit") { ?>
<table id="tbl_t01_penerimaanlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t01_penerimaan_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t01_penerimaan_list->RenderListOptions();

// Render list options (header, left)
$t01_penerimaan_list->ListOptions->Render("header", "left");
?>
<?php if ($t01_penerimaan->Departemen->Visible) { // Departemen ?>
	<?php if ($t01_penerimaan->SortUrl($t01_penerimaan->Departemen) == "") { ?>
		<th data-name="Departemen" class="<?php echo $t01_penerimaan->Departemen->HeaderCellClass() ?>"><div id="elh_t01_penerimaan_Departemen" class="t01_penerimaan_Departemen"><div class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Departemen->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Departemen" class="<?php echo $t01_penerimaan->Departemen->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_penerimaan->SortUrl($t01_penerimaan->Departemen) ?>',2);"><div id="elh_t01_penerimaan_Departemen" class="t01_penerimaan_Departemen">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Departemen->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_penerimaan->Departemen->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_penerimaan->Departemen->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_penerimaan->HeadDetail->Visible) { // HeadDetail ?>
	<?php if ($t01_penerimaan->SortUrl($t01_penerimaan->HeadDetail) == "") { ?>
		<th data-name="HeadDetail" class="<?php echo $t01_penerimaan->HeadDetail->HeaderCellClass() ?>"><div id="elh_t01_penerimaan_HeadDetail" class="t01_penerimaan_HeadDetail"><div class="ewTableHeaderCaption"><?php echo $t01_penerimaan->HeadDetail->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="HeadDetail" class="<?php echo $t01_penerimaan->HeadDetail->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_penerimaan->SortUrl($t01_penerimaan->HeadDetail) ?>',2);"><div id="elh_t01_penerimaan_HeadDetail" class="t01_penerimaan_HeadDetail">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_penerimaan->HeadDetail->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_penerimaan->HeadDetail->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_penerimaan->HeadDetail->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_penerimaan->NomorHead->Visible) { // NomorHead ?>
	<?php if ($t01_penerimaan->SortUrl($t01_penerimaan->NomorHead) == "") { ?>
		<th data-name="NomorHead" class="<?php echo $t01_penerimaan->NomorHead->HeaderCellClass() ?>"><div id="elh_t01_penerimaan_NomorHead" class="t01_penerimaan_NomorHead"><div class="ewTableHeaderCaption"><?php echo $t01_penerimaan->NomorHead->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NomorHead" class="<?php echo $t01_penerimaan->NomorHead->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_penerimaan->SortUrl($t01_penerimaan->NomorHead) ?>',2);"><div id="elh_t01_penerimaan_NomorHead" class="t01_penerimaan_NomorHead">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_penerimaan->NomorHead->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_penerimaan->NomorHead->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_penerimaan->NomorHead->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_penerimaan->SubTotalFlag->Visible) { // SubTotalFlag ?>
	<?php if ($t01_penerimaan->SortUrl($t01_penerimaan->SubTotalFlag) == "") { ?>
		<th data-name="SubTotalFlag" class="<?php echo $t01_penerimaan->SubTotalFlag->HeaderCellClass() ?>"><div id="elh_t01_penerimaan_SubTotalFlag" class="t01_penerimaan_SubTotalFlag"><div class="ewTableHeaderCaption"><?php echo $t01_penerimaan->SubTotalFlag->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="SubTotalFlag" class="<?php echo $t01_penerimaan->SubTotalFlag->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_penerimaan->SortUrl($t01_penerimaan->SubTotalFlag) ?>',2);"><div id="elh_t01_penerimaan_SubTotalFlag" class="t01_penerimaan_SubTotalFlag">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_penerimaan->SubTotalFlag->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_penerimaan->SubTotalFlag->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_penerimaan->SubTotalFlag->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_penerimaan->Urutan->Visible) { // Urutan ?>
	<?php if ($t01_penerimaan->SortUrl($t01_penerimaan->Urutan) == "") { ?>
		<th data-name="Urutan" class="<?php echo $t01_penerimaan->Urutan->HeaderCellClass() ?>"><div id="elh_t01_penerimaan_Urutan" class="t01_penerimaan_Urutan"><div class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Urutan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Urutan" class="<?php echo $t01_penerimaan->Urutan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_penerimaan->SortUrl($t01_penerimaan->Urutan) ?>',2);"><div id="elh_t01_penerimaan_Urutan" class="t01_penerimaan_Urutan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Urutan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_penerimaan->Urutan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_penerimaan->Urutan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_penerimaan->Nomor->Visible) { // Nomor ?>
	<?php if ($t01_penerimaan->SortUrl($t01_penerimaan->Nomor) == "") { ?>
		<th data-name="Nomor" class="<?php echo $t01_penerimaan->Nomor->HeaderCellClass() ?>"><div id="elh_t01_penerimaan_Nomor" class="t01_penerimaan_Nomor"><div class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Nomor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nomor" class="<?php echo $t01_penerimaan->Nomor->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_penerimaan->SortUrl($t01_penerimaan->Nomor) ?>',2);"><div id="elh_t01_penerimaan_Nomor" class="t01_penerimaan_Nomor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Nomor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_penerimaan->Nomor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_penerimaan->Nomor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_penerimaan->Pos->Visible) { // Pos ?>
	<?php if ($t01_penerimaan->SortUrl($t01_penerimaan->Pos) == "") { ?>
		<th data-name="Pos" class="<?php echo $t01_penerimaan->Pos->HeaderCellClass() ?>"><div id="elh_t01_penerimaan_Pos" class="t01_penerimaan_Pos"><div class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Pos->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Pos" class="<?php echo $t01_penerimaan->Pos->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_penerimaan->SortUrl($t01_penerimaan->Pos) ?>',2);"><div id="elh_t01_penerimaan_Pos" class="t01_penerimaan_Pos">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Pos->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_penerimaan->Pos->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_penerimaan->Pos->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_penerimaan->Nominal->Visible) { // Nominal ?>
	<?php if ($t01_penerimaan->SortUrl($t01_penerimaan->Nominal) == "") { ?>
		<th data-name="Nominal" class="<?php echo $t01_penerimaan->Nominal->HeaderCellClass() ?>"><div id="elh_t01_penerimaan_Nominal" class="t01_penerimaan_Nominal"><div class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Nominal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nominal" class="<?php echo $t01_penerimaan->Nominal->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_penerimaan->SortUrl($t01_penerimaan->Nominal) ?>',2);"><div id="elh_t01_penerimaan_Nominal" class="t01_penerimaan_Nominal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Nominal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_penerimaan->Nominal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_penerimaan->Nominal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_penerimaan->JumlahSiswa->Visible) { // JumlahSiswa ?>
	<?php if ($t01_penerimaan->SortUrl($t01_penerimaan->JumlahSiswa) == "") { ?>
		<th data-name="JumlahSiswa" class="<?php echo $t01_penerimaan->JumlahSiswa->HeaderCellClass() ?>"><div id="elh_t01_penerimaan_JumlahSiswa" class="t01_penerimaan_JumlahSiswa"><div class="ewTableHeaderCaption"><?php echo $t01_penerimaan->JumlahSiswa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="JumlahSiswa" class="<?php echo $t01_penerimaan->JumlahSiswa->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_penerimaan->SortUrl($t01_penerimaan->JumlahSiswa) ?>',2);"><div id="elh_t01_penerimaan_JumlahSiswa" class="t01_penerimaan_JumlahSiswa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_penerimaan->JumlahSiswa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_penerimaan->JumlahSiswa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_penerimaan->JumlahSiswa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_penerimaan->Bulan->Visible) { // Bulan ?>
	<?php if ($t01_penerimaan->SortUrl($t01_penerimaan->Bulan) == "") { ?>
		<th data-name="Bulan" class="<?php echo $t01_penerimaan->Bulan->HeaderCellClass() ?>"><div id="elh_t01_penerimaan_Bulan" class="t01_penerimaan_Bulan"><div class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Bulan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bulan" class="<?php echo $t01_penerimaan->Bulan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_penerimaan->SortUrl($t01_penerimaan->Bulan) ?>',2);"><div id="elh_t01_penerimaan_Bulan" class="t01_penerimaan_Bulan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Bulan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_penerimaan->Bulan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_penerimaan->Bulan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_penerimaan->Jumlah->Visible) { // Jumlah ?>
	<?php if ($t01_penerimaan->SortUrl($t01_penerimaan->Jumlah) == "") { ?>
		<th data-name="Jumlah" class="<?php echo $t01_penerimaan->Jumlah->HeaderCellClass() ?>"><div id="elh_t01_penerimaan_Jumlah" class="t01_penerimaan_Jumlah"><div class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Jumlah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jumlah" class="<?php echo $t01_penerimaan->Jumlah->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_penerimaan->SortUrl($t01_penerimaan->Jumlah) ?>',2);"><div id="elh_t01_penerimaan_Jumlah" class="t01_penerimaan_Jumlah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Jumlah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_penerimaan->Jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_penerimaan->Jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t01_penerimaan->Total->Visible) { // Total ?>
	<?php if ($t01_penerimaan->SortUrl($t01_penerimaan->Total) == "") { ?>
		<th data-name="Total" class="<?php echo $t01_penerimaan->Total->HeaderCellClass() ?>"><div id="elh_t01_penerimaan_Total" class="t01_penerimaan_Total"><div class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Total->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Total" class="<?php echo $t01_penerimaan->Total->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t01_penerimaan->SortUrl($t01_penerimaan->Total) ?>',2);"><div id="elh_t01_penerimaan_Total" class="t01_penerimaan_Total">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t01_penerimaan->Total->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t01_penerimaan->Total->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t01_penerimaan->Total->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t01_penerimaan_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($t01_penerimaan->CurrentAction == "add" || $t01_penerimaan->CurrentAction == "copy") {
		$t01_penerimaan_list->RowIndex = 0;
		$t01_penerimaan_list->KeyCount = $t01_penerimaan_list->RowIndex;
		if ($t01_penerimaan->CurrentAction == "add")
			$t01_penerimaan_list->LoadRowValues();
		if ($t01_penerimaan->EventCancelled) // Insert failed
			$t01_penerimaan_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$t01_penerimaan->ResetAttrs();
		$t01_penerimaan->RowAttrs = array_merge($t01_penerimaan->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_t01_penerimaan', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$t01_penerimaan->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t01_penerimaan_list->RenderRow();

		// Render list options
		$t01_penerimaan_list->RenderListOptions();
		$t01_penerimaan_list->StartRowCnt = 0;
?>
	<tr<?php echo $t01_penerimaan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t01_penerimaan_list->ListOptions->Render("body", "left", $t01_penerimaan_list->RowCnt);
?>
	<?php if ($t01_penerimaan->Departemen->Visible) { // Departemen ?>
		<td data-name="Departemen">
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Departemen" class="form-group t01_penerimaan_Departemen">
<select data-table="t01_penerimaan" data-field="x_Departemen" data-value-separator="<?php echo $t01_penerimaan->Departemen->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen"<?php echo $t01_penerimaan->Departemen->EditAttributes() ?>>
<?php echo $t01_penerimaan->Departemen->SelectOptionListHtml("x<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen") ?>
</select>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Departemen" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen" value="<?php echo ew_HtmlEncode($t01_penerimaan->Departemen->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->HeadDetail->Visible) { // HeadDetail ?>
		<td data-name="HeadDetail">
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_HeadDetail" class="form-group t01_penerimaan_HeadDetail">
<input type="text" data-table="t01_penerimaan" data-field="x_HeadDetail" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_HeadDetail" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_HeadDetail" size="1" maxlength="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->HeadDetail->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->HeadDetail->EditValue ?>"<?php echo $t01_penerimaan->HeadDetail->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_HeadDetail" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_HeadDetail" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_HeadDetail" value="<?php echo ew_HtmlEncode($t01_penerimaan->HeadDetail->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->NomorHead->Visible) { // NomorHead ?>
		<td data-name="NomorHead">
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_NomorHead" class="form-group t01_penerimaan_NomorHead">
<input type="text" data-table="t01_penerimaan" data-field="x_NomorHead" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_NomorHead" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_NomorHead" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->NomorHead->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->NomorHead->EditValue ?>"<?php echo $t01_penerimaan->NomorHead->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_NomorHead" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_NomorHead" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_NomorHead" value="<?php echo ew_HtmlEncode($t01_penerimaan->NomorHead->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->SubTotalFlag->Visible) { // SubTotalFlag ?>
		<td data-name="SubTotalFlag">
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_SubTotalFlag" class="form-group t01_penerimaan_SubTotalFlag">
<input type="text" data-table="t01_penerimaan" data-field="x_SubTotalFlag" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_SubTotalFlag" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_SubTotalFlag" size="1" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->SubTotalFlag->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->SubTotalFlag->EditValue ?>"<?php echo $t01_penerimaan->SubTotalFlag->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_SubTotalFlag" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_SubTotalFlag" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_SubTotalFlag" value="<?php echo ew_HtmlEncode($t01_penerimaan->SubTotalFlag->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Urutan->Visible) { // Urutan ?>
		<td data-name="Urutan">
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Urutan" class="form-group t01_penerimaan_Urutan">
<input type="text" data-table="t01_penerimaan" data-field="x_Urutan" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Urutan" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Urutan->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Urutan->EditValue ?>"<?php echo $t01_penerimaan->Urutan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Urutan" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Urutan" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t01_penerimaan->Urutan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Nomor->Visible) { // Nomor ?>
		<td data-name="Nomor">
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Nomor" class="form-group t01_penerimaan_Nomor">
<input type="text" data-table="t01_penerimaan" data-field="x_Nomor" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nomor" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nomor" size="1" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Nomor->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Nomor->EditValue ?>"<?php echo $t01_penerimaan->Nomor->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Nomor" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Nomor" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t01_penerimaan->Nomor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Pos->Visible) { // Pos ?>
		<td data-name="Pos">
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Pos" class="form-group t01_penerimaan_Pos">
<input type="text" data-table="t01_penerimaan" data-field="x_Pos" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Pos" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Pos->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Pos->EditValue ?>"<?php echo $t01_penerimaan->Pos->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Pos" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Pos" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t01_penerimaan->Pos->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Nominal->Visible) { // Nominal ?>
		<td data-name="Nominal">
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Nominal" class="form-group t01_penerimaan_Nominal">
<input type="text" data-table="t01_penerimaan" data-field="x_Nominal" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nominal" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nominal" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Nominal->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Nominal->EditValue ?>"<?php echo $t01_penerimaan->Nominal->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Nominal" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Nominal" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t01_penerimaan->Nominal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->JumlahSiswa->Visible) { // JumlahSiswa ?>
		<td data-name="JumlahSiswa">
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_JumlahSiswa" class="form-group t01_penerimaan_JumlahSiswa">
<input type="text" data-table="t01_penerimaan" data-field="x_JumlahSiswa" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_JumlahSiswa" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_JumlahSiswa" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->JumlahSiswa->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->JumlahSiswa->EditValue ?>"<?php echo $t01_penerimaan->JumlahSiswa->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_JumlahSiswa" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_JumlahSiswa" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_JumlahSiswa" value="<?php echo ew_HtmlEncode($t01_penerimaan->JumlahSiswa->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Bulan->Visible) { // Bulan ?>
		<td data-name="Bulan">
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Bulan" class="form-group t01_penerimaan_Bulan">
<input type="text" data-table="t01_penerimaan" data-field="x_Bulan" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Bulan" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Bulan" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Bulan->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Bulan->EditValue ?>"<?php echo $t01_penerimaan->Bulan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Bulan" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Bulan" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t01_penerimaan->Bulan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Jumlah->Visible) { // Jumlah ?>
		<td data-name="Jumlah">
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Jumlah" class="form-group t01_penerimaan_Jumlah">
<input type="text" data-table="t01_penerimaan" data-field="x_Jumlah" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Jumlah" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Jumlah" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Jumlah->EditValue ?>"<?php echo $t01_penerimaan->Jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Jumlah" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Jumlah" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t01_penerimaan->Jumlah->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Total->Visible) { // Total ?>
		<td data-name="Total">
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Total" class="form-group t01_penerimaan_Total">
<input type="text" data-table="t01_penerimaan" data-field="x_Total" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Total" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Total" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Total->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Total->EditValue ?>"<?php echo $t01_penerimaan->Total->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Total" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Total" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Total" value="<?php echo ew_HtmlEncode($t01_penerimaan->Total->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t01_penerimaan_list->ListOptions->Render("body", "right", $t01_penerimaan_list->RowCnt);
?>
<script type="text/javascript">
ft01_penerimaanlist.UpdateOpts(<?php echo $t01_penerimaan_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($t01_penerimaan->ExportAll && $t01_penerimaan->Export <> "") {
	$t01_penerimaan_list->StopRec = $t01_penerimaan_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t01_penerimaan_list->TotalRecs > $t01_penerimaan_list->StartRec + $t01_penerimaan_list->DisplayRecs - 1)
		$t01_penerimaan_list->StopRec = $t01_penerimaan_list->StartRec + $t01_penerimaan_list->DisplayRecs - 1;
	else
		$t01_penerimaan_list->StopRec = $t01_penerimaan_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t01_penerimaan_list->FormKeyCountName) && ($t01_penerimaan->CurrentAction == "gridadd" || $t01_penerimaan->CurrentAction == "gridedit" || $t01_penerimaan->CurrentAction == "F")) {
		$t01_penerimaan_list->KeyCount = $objForm->GetValue($t01_penerimaan_list->FormKeyCountName);
		$t01_penerimaan_list->StopRec = $t01_penerimaan_list->StartRec + $t01_penerimaan_list->KeyCount - 1;
	}
}
$t01_penerimaan_list->RecCnt = $t01_penerimaan_list->StartRec - 1;
if ($t01_penerimaan_list->Recordset && !$t01_penerimaan_list->Recordset->EOF) {
	$t01_penerimaan_list->Recordset->MoveFirst();
	$bSelectLimit = $t01_penerimaan_list->UseSelectLimit;
	if (!$bSelectLimit && $t01_penerimaan_list->StartRec > 1)
		$t01_penerimaan_list->Recordset->Move($t01_penerimaan_list->StartRec - 1);
} elseif (!$t01_penerimaan->AllowAddDeleteRow && $t01_penerimaan_list->StopRec == 0) {
	$t01_penerimaan_list->StopRec = $t01_penerimaan->GridAddRowCount;
}

// Initialize aggregate
$t01_penerimaan->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t01_penerimaan->ResetAttrs();
$t01_penerimaan_list->RenderRow();
if ($t01_penerimaan->CurrentAction == "gridedit")
	$t01_penerimaan_list->RowIndex = 0;
while ($t01_penerimaan_list->RecCnt < $t01_penerimaan_list->StopRec) {
	$t01_penerimaan_list->RecCnt++;
	if (intval($t01_penerimaan_list->RecCnt) >= intval($t01_penerimaan_list->StartRec)) {
		$t01_penerimaan_list->RowCnt++;
		if ($t01_penerimaan->CurrentAction == "gridadd" || $t01_penerimaan->CurrentAction == "gridedit" || $t01_penerimaan->CurrentAction == "F") {
			$t01_penerimaan_list->RowIndex++;
			$objForm->Index = $t01_penerimaan_list->RowIndex;
			if ($objForm->HasValue($t01_penerimaan_list->FormActionName))
				$t01_penerimaan_list->RowAction = strval($objForm->GetValue($t01_penerimaan_list->FormActionName));
			elseif ($t01_penerimaan->CurrentAction == "gridadd")
				$t01_penerimaan_list->RowAction = "insert";
			else
				$t01_penerimaan_list->RowAction = "";
		}

		// Set up key count
		$t01_penerimaan_list->KeyCount = $t01_penerimaan_list->RowIndex;

		// Init row class and style
		$t01_penerimaan->ResetAttrs();
		$t01_penerimaan->CssClass = "";
		if ($t01_penerimaan->CurrentAction == "gridadd") {
			$t01_penerimaan_list->LoadRowValues(); // Load default values
		} else {
			$t01_penerimaan_list->LoadRowValues($t01_penerimaan_list->Recordset); // Load row values
		}
		$t01_penerimaan->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t01_penerimaan->CurrentAction == "gridedit") { // Grid edit
			if ($t01_penerimaan->EventCancelled) {
				$t01_penerimaan_list->RestoreCurrentRowFormValues($t01_penerimaan_list->RowIndex); // Restore form values
			}
			if ($t01_penerimaan_list->RowAction == "insert")
				$t01_penerimaan->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t01_penerimaan->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t01_penerimaan->CurrentAction == "gridedit" && ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT || $t01_penerimaan->RowType == EW_ROWTYPE_ADD) && $t01_penerimaan->EventCancelled) // Update failed
			$t01_penerimaan_list->RestoreCurrentRowFormValues($t01_penerimaan_list->RowIndex); // Restore form values
		if ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t01_penerimaan_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$t01_penerimaan->RowAttrs = array_merge($t01_penerimaan->RowAttrs, array('data-rowindex'=>$t01_penerimaan_list->RowCnt, 'id'=>'r' . $t01_penerimaan_list->RowCnt . '_t01_penerimaan', 'data-rowtype'=>$t01_penerimaan->RowType));

		// Render row
		$t01_penerimaan_list->RenderRow();

		// Render list options
		$t01_penerimaan_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t01_penerimaan_list->RowAction <> "delete" && $t01_penerimaan_list->RowAction <> "insertdelete" && !($t01_penerimaan_list->RowAction == "insert" && $t01_penerimaan->CurrentAction == "F" && $t01_penerimaan_list->EmptyRow())) {
?>
	<tr<?php echo $t01_penerimaan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t01_penerimaan_list->ListOptions->Render("body", "left", $t01_penerimaan_list->RowCnt);
?>
	<?php if ($t01_penerimaan->Departemen->Visible) { // Departemen ?>
		<td data-name="Departemen"<?php echo $t01_penerimaan->Departemen->CellAttributes() ?>>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Departemen" class="form-group t01_penerimaan_Departemen">
<select data-table="t01_penerimaan" data-field="x_Departemen" data-value-separator="<?php echo $t01_penerimaan->Departemen->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen"<?php echo $t01_penerimaan->Departemen->EditAttributes() ?>>
<?php echo $t01_penerimaan->Departemen->SelectOptionListHtml("x<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen") ?>
</select>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Departemen" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen" value="<?php echo ew_HtmlEncode($t01_penerimaan->Departemen->OldValue) ?>">
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Departemen" class="form-group t01_penerimaan_Departemen">
<select data-table="t01_penerimaan" data-field="x_Departemen" data-value-separator="<?php echo $t01_penerimaan->Departemen->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen"<?php echo $t01_penerimaan->Departemen->EditAttributes() ?>>
<?php echo $t01_penerimaan->Departemen->SelectOptionListHtml("x<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen") ?>
</select>
</span>
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Departemen" class="t01_penerimaan_Departemen">
<span<?php echo $t01_penerimaan->Departemen->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Departemen->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t01_penerimaan" data-field="x_id" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_id" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t01_penerimaan->id->CurrentValue) ?>">
<input type="hidden" data-table="t01_penerimaan" data-field="x_id" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_id" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t01_penerimaan->id->OldValue) ?>">
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT || $t01_penerimaan->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t01_penerimaan" data-field="x_id" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_id" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t01_penerimaan->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t01_penerimaan->HeadDetail->Visible) { // HeadDetail ?>
		<td data-name="HeadDetail"<?php echo $t01_penerimaan->HeadDetail->CellAttributes() ?>>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_HeadDetail" class="form-group t01_penerimaan_HeadDetail">
<input type="text" data-table="t01_penerimaan" data-field="x_HeadDetail" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_HeadDetail" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_HeadDetail" size="1" maxlength="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->HeadDetail->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->HeadDetail->EditValue ?>"<?php echo $t01_penerimaan->HeadDetail->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_HeadDetail" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_HeadDetail" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_HeadDetail" value="<?php echo ew_HtmlEncode($t01_penerimaan->HeadDetail->OldValue) ?>">
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_HeadDetail" class="form-group t01_penerimaan_HeadDetail">
<input type="text" data-table="t01_penerimaan" data-field="x_HeadDetail" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_HeadDetail" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_HeadDetail" size="1" maxlength="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->HeadDetail->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->HeadDetail->EditValue ?>"<?php echo $t01_penerimaan->HeadDetail->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_HeadDetail" class="t01_penerimaan_HeadDetail">
<span<?php echo $t01_penerimaan->HeadDetail->ViewAttributes() ?>>
<?php echo $t01_penerimaan->HeadDetail->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->NomorHead->Visible) { // NomorHead ?>
		<td data-name="NomorHead"<?php echo $t01_penerimaan->NomorHead->CellAttributes() ?>>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_NomorHead" class="form-group t01_penerimaan_NomorHead">
<input type="text" data-table="t01_penerimaan" data-field="x_NomorHead" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_NomorHead" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_NomorHead" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->NomorHead->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->NomorHead->EditValue ?>"<?php echo $t01_penerimaan->NomorHead->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_NomorHead" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_NomorHead" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_NomorHead" value="<?php echo ew_HtmlEncode($t01_penerimaan->NomorHead->OldValue) ?>">
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_NomorHead" class="form-group t01_penerimaan_NomorHead">
<input type="text" data-table="t01_penerimaan" data-field="x_NomorHead" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_NomorHead" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_NomorHead" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->NomorHead->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->NomorHead->EditValue ?>"<?php echo $t01_penerimaan->NomorHead->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_NomorHead" class="t01_penerimaan_NomorHead">
<span<?php echo $t01_penerimaan->NomorHead->ViewAttributes() ?>>
<?php echo $t01_penerimaan->NomorHead->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->SubTotalFlag->Visible) { // SubTotalFlag ?>
		<td data-name="SubTotalFlag"<?php echo $t01_penerimaan->SubTotalFlag->CellAttributes() ?>>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_SubTotalFlag" class="form-group t01_penerimaan_SubTotalFlag">
<input type="text" data-table="t01_penerimaan" data-field="x_SubTotalFlag" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_SubTotalFlag" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_SubTotalFlag" size="1" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->SubTotalFlag->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->SubTotalFlag->EditValue ?>"<?php echo $t01_penerimaan->SubTotalFlag->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_SubTotalFlag" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_SubTotalFlag" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_SubTotalFlag" value="<?php echo ew_HtmlEncode($t01_penerimaan->SubTotalFlag->OldValue) ?>">
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_SubTotalFlag" class="form-group t01_penerimaan_SubTotalFlag">
<input type="text" data-table="t01_penerimaan" data-field="x_SubTotalFlag" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_SubTotalFlag" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_SubTotalFlag" size="1" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->SubTotalFlag->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->SubTotalFlag->EditValue ?>"<?php echo $t01_penerimaan->SubTotalFlag->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_SubTotalFlag" class="t01_penerimaan_SubTotalFlag">
<span<?php echo $t01_penerimaan->SubTotalFlag->ViewAttributes() ?>>
<?php echo $t01_penerimaan->SubTotalFlag->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Urutan->Visible) { // Urutan ?>
		<td data-name="Urutan"<?php echo $t01_penerimaan->Urutan->CellAttributes() ?>>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Urutan" class="form-group t01_penerimaan_Urutan">
<input type="text" data-table="t01_penerimaan" data-field="x_Urutan" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Urutan" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Urutan->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Urutan->EditValue ?>"<?php echo $t01_penerimaan->Urutan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Urutan" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Urutan" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t01_penerimaan->Urutan->OldValue) ?>">
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Urutan" class="form-group t01_penerimaan_Urutan">
<input type="text" data-table="t01_penerimaan" data-field="x_Urutan" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Urutan" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Urutan->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Urutan->EditValue ?>"<?php echo $t01_penerimaan->Urutan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Urutan" class="t01_penerimaan_Urutan">
<span<?php echo $t01_penerimaan->Urutan->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Urutan->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Nomor->Visible) { // Nomor ?>
		<td data-name="Nomor"<?php echo $t01_penerimaan->Nomor->CellAttributes() ?>>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Nomor" class="form-group t01_penerimaan_Nomor">
<input type="text" data-table="t01_penerimaan" data-field="x_Nomor" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nomor" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nomor" size="1" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Nomor->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Nomor->EditValue ?>"<?php echo $t01_penerimaan->Nomor->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Nomor" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Nomor" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t01_penerimaan->Nomor->OldValue) ?>">
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Nomor" class="form-group t01_penerimaan_Nomor">
<input type="text" data-table="t01_penerimaan" data-field="x_Nomor" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nomor" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nomor" size="1" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Nomor->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Nomor->EditValue ?>"<?php echo $t01_penerimaan->Nomor->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Nomor" class="t01_penerimaan_Nomor">
<span<?php echo $t01_penerimaan->Nomor->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Nomor->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Pos->Visible) { // Pos ?>
		<td data-name="Pos"<?php echo $t01_penerimaan->Pos->CellAttributes() ?>>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Pos" class="form-group t01_penerimaan_Pos">
<input type="text" data-table="t01_penerimaan" data-field="x_Pos" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Pos" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Pos->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Pos->EditValue ?>"<?php echo $t01_penerimaan->Pos->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Pos" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Pos" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t01_penerimaan->Pos->OldValue) ?>">
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Pos" class="form-group t01_penerimaan_Pos">
<input type="text" data-table="t01_penerimaan" data-field="x_Pos" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Pos" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Pos->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Pos->EditValue ?>"<?php echo $t01_penerimaan->Pos->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Pos" class="t01_penerimaan_Pos">
<span<?php echo $t01_penerimaan->Pos->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Pos->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Nominal->Visible) { // Nominal ?>
		<td data-name="Nominal"<?php echo $t01_penerimaan->Nominal->CellAttributes() ?>>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Nominal" class="form-group t01_penerimaan_Nominal">
<input type="text" data-table="t01_penerimaan" data-field="x_Nominal" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nominal" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nominal" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Nominal->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Nominal->EditValue ?>"<?php echo $t01_penerimaan->Nominal->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Nominal" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Nominal" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t01_penerimaan->Nominal->OldValue) ?>">
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Nominal" class="form-group t01_penerimaan_Nominal">
<input type="text" data-table="t01_penerimaan" data-field="x_Nominal" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nominal" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nominal" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Nominal->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Nominal->EditValue ?>"<?php echo $t01_penerimaan->Nominal->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Nominal" class="t01_penerimaan_Nominal">
<span<?php echo $t01_penerimaan->Nominal->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Nominal->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->JumlahSiswa->Visible) { // JumlahSiswa ?>
		<td data-name="JumlahSiswa"<?php echo $t01_penerimaan->JumlahSiswa->CellAttributes() ?>>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_JumlahSiswa" class="form-group t01_penerimaan_JumlahSiswa">
<input type="text" data-table="t01_penerimaan" data-field="x_JumlahSiswa" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_JumlahSiswa" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_JumlahSiswa" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->JumlahSiswa->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->JumlahSiswa->EditValue ?>"<?php echo $t01_penerimaan->JumlahSiswa->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_JumlahSiswa" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_JumlahSiswa" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_JumlahSiswa" value="<?php echo ew_HtmlEncode($t01_penerimaan->JumlahSiswa->OldValue) ?>">
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_JumlahSiswa" class="form-group t01_penerimaan_JumlahSiswa">
<input type="text" data-table="t01_penerimaan" data-field="x_JumlahSiswa" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_JumlahSiswa" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_JumlahSiswa" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->JumlahSiswa->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->JumlahSiswa->EditValue ?>"<?php echo $t01_penerimaan->JumlahSiswa->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_JumlahSiswa" class="t01_penerimaan_JumlahSiswa">
<span<?php echo $t01_penerimaan->JumlahSiswa->ViewAttributes() ?>>
<?php echo $t01_penerimaan->JumlahSiswa->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Bulan->Visible) { // Bulan ?>
		<td data-name="Bulan"<?php echo $t01_penerimaan->Bulan->CellAttributes() ?>>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Bulan" class="form-group t01_penerimaan_Bulan">
<input type="text" data-table="t01_penerimaan" data-field="x_Bulan" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Bulan" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Bulan" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Bulan->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Bulan->EditValue ?>"<?php echo $t01_penerimaan->Bulan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Bulan" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Bulan" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t01_penerimaan->Bulan->OldValue) ?>">
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Bulan" class="form-group t01_penerimaan_Bulan">
<input type="text" data-table="t01_penerimaan" data-field="x_Bulan" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Bulan" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Bulan" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Bulan->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Bulan->EditValue ?>"<?php echo $t01_penerimaan->Bulan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Bulan" class="t01_penerimaan_Bulan">
<span<?php echo $t01_penerimaan->Bulan->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Bulan->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Jumlah->Visible) { // Jumlah ?>
		<td data-name="Jumlah"<?php echo $t01_penerimaan->Jumlah->CellAttributes() ?>>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Jumlah" class="form-group t01_penerimaan_Jumlah">
<input type="text" data-table="t01_penerimaan" data-field="x_Jumlah" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Jumlah" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Jumlah" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Jumlah->EditValue ?>"<?php echo $t01_penerimaan->Jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Jumlah" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Jumlah" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t01_penerimaan->Jumlah->OldValue) ?>">
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Jumlah" class="form-group t01_penerimaan_Jumlah">
<input type="text" data-table="t01_penerimaan" data-field="x_Jumlah" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Jumlah" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Jumlah" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Jumlah->EditValue ?>"<?php echo $t01_penerimaan->Jumlah->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Jumlah" class="t01_penerimaan_Jumlah">
<span<?php echo $t01_penerimaan->Jumlah->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Jumlah->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Total->Visible) { // Total ?>
		<td data-name="Total"<?php echo $t01_penerimaan->Total->CellAttributes() ?>>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Total" class="form-group t01_penerimaan_Total">
<input type="text" data-table="t01_penerimaan" data-field="x_Total" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Total" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Total" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Total->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Total->EditValue ?>"<?php echo $t01_penerimaan->Total->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Total" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Total" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Total" value="<?php echo ew_HtmlEncode($t01_penerimaan->Total->OldValue) ?>">
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Total" class="form-group t01_penerimaan_Total">
<input type="text" data-table="t01_penerimaan" data-field="x_Total" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Total" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Total" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Total->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Total->EditValue ?>"<?php echo $t01_penerimaan->Total->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t01_penerimaan_list->RowCnt ?>_t01_penerimaan_Total" class="t01_penerimaan_Total">
<span<?php echo $t01_penerimaan->Total->ViewAttributes() ?>>
<?php echo $t01_penerimaan->Total->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t01_penerimaan_list->ListOptions->Render("body", "right", $t01_penerimaan_list->RowCnt);
?>
	</tr>
<?php if ($t01_penerimaan->RowType == EW_ROWTYPE_ADD || $t01_penerimaan->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft01_penerimaanlist.UpdateOpts(<?php echo $t01_penerimaan_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t01_penerimaan->CurrentAction <> "gridadd")
		if (!$t01_penerimaan_list->Recordset->EOF) $t01_penerimaan_list->Recordset->MoveNext();
}
?>
<?php
	if ($t01_penerimaan->CurrentAction == "gridadd" || $t01_penerimaan->CurrentAction == "gridedit") {
		$t01_penerimaan_list->RowIndex = '$rowindex$';
		$t01_penerimaan_list->LoadRowValues();

		// Set row properties
		$t01_penerimaan->ResetAttrs();
		$t01_penerimaan->RowAttrs = array_merge($t01_penerimaan->RowAttrs, array('data-rowindex'=>$t01_penerimaan_list->RowIndex, 'id'=>'r0_t01_penerimaan', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t01_penerimaan->RowAttrs["class"], "ewTemplate");
		$t01_penerimaan->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t01_penerimaan_list->RenderRow();

		// Render list options
		$t01_penerimaan_list->RenderListOptions();
		$t01_penerimaan_list->StartRowCnt = 0;
?>
	<tr<?php echo $t01_penerimaan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t01_penerimaan_list->ListOptions->Render("body", "left", $t01_penerimaan_list->RowIndex);
?>
	<?php if ($t01_penerimaan->Departemen->Visible) { // Departemen ?>
		<td data-name="Departemen">
<span id="el$rowindex$_t01_penerimaan_Departemen" class="form-group t01_penerimaan_Departemen">
<select data-table="t01_penerimaan" data-field="x_Departemen" data-value-separator="<?php echo $t01_penerimaan->Departemen->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen"<?php echo $t01_penerimaan->Departemen->EditAttributes() ?>>
<?php echo $t01_penerimaan->Departemen->SelectOptionListHtml("x<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen") ?>
</select>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Departemen" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Departemen" value="<?php echo ew_HtmlEncode($t01_penerimaan->Departemen->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->HeadDetail->Visible) { // HeadDetail ?>
		<td data-name="HeadDetail">
<span id="el$rowindex$_t01_penerimaan_HeadDetail" class="form-group t01_penerimaan_HeadDetail">
<input type="text" data-table="t01_penerimaan" data-field="x_HeadDetail" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_HeadDetail" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_HeadDetail" size="1" maxlength="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->HeadDetail->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->HeadDetail->EditValue ?>"<?php echo $t01_penerimaan->HeadDetail->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_HeadDetail" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_HeadDetail" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_HeadDetail" value="<?php echo ew_HtmlEncode($t01_penerimaan->HeadDetail->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->NomorHead->Visible) { // NomorHead ?>
		<td data-name="NomorHead">
<span id="el$rowindex$_t01_penerimaan_NomorHead" class="form-group t01_penerimaan_NomorHead">
<input type="text" data-table="t01_penerimaan" data-field="x_NomorHead" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_NomorHead" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_NomorHead" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->NomorHead->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->NomorHead->EditValue ?>"<?php echo $t01_penerimaan->NomorHead->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_NomorHead" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_NomorHead" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_NomorHead" value="<?php echo ew_HtmlEncode($t01_penerimaan->NomorHead->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->SubTotalFlag->Visible) { // SubTotalFlag ?>
		<td data-name="SubTotalFlag">
<span id="el$rowindex$_t01_penerimaan_SubTotalFlag" class="form-group t01_penerimaan_SubTotalFlag">
<input type="text" data-table="t01_penerimaan" data-field="x_SubTotalFlag" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_SubTotalFlag" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_SubTotalFlag" size="1" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->SubTotalFlag->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->SubTotalFlag->EditValue ?>"<?php echo $t01_penerimaan->SubTotalFlag->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_SubTotalFlag" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_SubTotalFlag" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_SubTotalFlag" value="<?php echo ew_HtmlEncode($t01_penerimaan->SubTotalFlag->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Urutan->Visible) { // Urutan ?>
		<td data-name="Urutan">
<span id="el$rowindex$_t01_penerimaan_Urutan" class="form-group t01_penerimaan_Urutan">
<input type="text" data-table="t01_penerimaan" data-field="x_Urutan" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Urutan" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Urutan->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Urutan->EditValue ?>"<?php echo $t01_penerimaan->Urutan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Urutan" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Urutan" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t01_penerimaan->Urutan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Nomor->Visible) { // Nomor ?>
		<td data-name="Nomor">
<span id="el$rowindex$_t01_penerimaan_Nomor" class="form-group t01_penerimaan_Nomor">
<input type="text" data-table="t01_penerimaan" data-field="x_Nomor" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nomor" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nomor" size="1" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Nomor->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Nomor->EditValue ?>"<?php echo $t01_penerimaan->Nomor->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Nomor" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Nomor" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Nomor" value="<?php echo ew_HtmlEncode($t01_penerimaan->Nomor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Pos->Visible) { // Pos ?>
		<td data-name="Pos">
<span id="el$rowindex$_t01_penerimaan_Pos" class="form-group t01_penerimaan_Pos">
<input type="text" data-table="t01_penerimaan" data-field="x_Pos" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Pos" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Pos->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Pos->EditValue ?>"<?php echo $t01_penerimaan->Pos->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Pos" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Pos" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Pos" value="<?php echo ew_HtmlEncode($t01_penerimaan->Pos->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Nominal->Visible) { // Nominal ?>
		<td data-name="Nominal">
<span id="el$rowindex$_t01_penerimaan_Nominal" class="form-group t01_penerimaan_Nominal">
<input type="text" data-table="t01_penerimaan" data-field="x_Nominal" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nominal" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Nominal" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Nominal->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Nominal->EditValue ?>"<?php echo $t01_penerimaan->Nominal->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Nominal" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Nominal" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Nominal" value="<?php echo ew_HtmlEncode($t01_penerimaan->Nominal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->JumlahSiswa->Visible) { // JumlahSiswa ?>
		<td data-name="JumlahSiswa">
<span id="el$rowindex$_t01_penerimaan_JumlahSiswa" class="form-group t01_penerimaan_JumlahSiswa">
<input type="text" data-table="t01_penerimaan" data-field="x_JumlahSiswa" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_JumlahSiswa" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_JumlahSiswa" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->JumlahSiswa->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->JumlahSiswa->EditValue ?>"<?php echo $t01_penerimaan->JumlahSiswa->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_JumlahSiswa" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_JumlahSiswa" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_JumlahSiswa" value="<?php echo ew_HtmlEncode($t01_penerimaan->JumlahSiswa->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Bulan->Visible) { // Bulan ?>
		<td data-name="Bulan">
<span id="el$rowindex$_t01_penerimaan_Bulan" class="form-group t01_penerimaan_Bulan">
<input type="text" data-table="t01_penerimaan" data-field="x_Bulan" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Bulan" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Bulan" size="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Bulan->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Bulan->EditValue ?>"<?php echo $t01_penerimaan->Bulan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Bulan" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Bulan" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t01_penerimaan->Bulan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Jumlah->Visible) { // Jumlah ?>
		<td data-name="Jumlah">
<span id="el$rowindex$_t01_penerimaan_Jumlah" class="form-group t01_penerimaan_Jumlah">
<input type="text" data-table="t01_penerimaan" data-field="x_Jumlah" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Jumlah" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Jumlah" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Jumlah->EditValue ?>"<?php echo $t01_penerimaan->Jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Jumlah" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Jumlah" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t01_penerimaan->Jumlah->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t01_penerimaan->Total->Visible) { // Total ?>
		<td data-name="Total">
<span id="el$rowindex$_t01_penerimaan_Total" class="form-group t01_penerimaan_Total">
<input type="text" data-table="t01_penerimaan" data-field="x_Total" name="x<?php echo $t01_penerimaan_list->RowIndex ?>_Total" id="x<?php echo $t01_penerimaan_list->RowIndex ?>_Total" size="5" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Total->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Total->EditValue ?>"<?php echo $t01_penerimaan->Total->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t01_penerimaan" data-field="x_Total" name="o<?php echo $t01_penerimaan_list->RowIndex ?>_Total" id="o<?php echo $t01_penerimaan_list->RowIndex ?>_Total" value="<?php echo ew_HtmlEncode($t01_penerimaan->Total->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t01_penerimaan_list->ListOptions->Render("body", "right", $t01_penerimaan_list->RowIndex);
?>
<script type="text/javascript">
ft01_penerimaanlist.UpdateOpts(<?php echo $t01_penerimaan_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t01_penerimaan->CurrentAction == "add" || $t01_penerimaan->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $t01_penerimaan_list->FormKeyCountName ?>" id="<?php echo $t01_penerimaan_list->FormKeyCountName ?>" value="<?php echo $t01_penerimaan_list->KeyCount ?>">
<?php } ?>
<?php if ($t01_penerimaan->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t01_penerimaan_list->FormKeyCountName ?>" id="<?php echo $t01_penerimaan_list->FormKeyCountName ?>" value="<?php echo $t01_penerimaan_list->KeyCount ?>">
<?php echo $t01_penerimaan_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t01_penerimaan->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t01_penerimaan_list->Recordset)
	$t01_penerimaan_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($t01_penerimaan->CurrentAction <> "gridadd" && $t01_penerimaan->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t01_penerimaan_list->Pager)) $t01_penerimaan_list->Pager = new cPrevNextPager($t01_penerimaan_list->StartRec, $t01_penerimaan_list->DisplayRecs, $t01_penerimaan_list->TotalRecs, $t01_penerimaan_list->AutoHidePager) ?>
<?php if ($t01_penerimaan_list->Pager->RecordCount > 0 && $t01_penerimaan_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t01_penerimaan_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t01_penerimaan_list->PageUrl() ?>start=<?php echo $t01_penerimaan_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t01_penerimaan_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t01_penerimaan_list->PageUrl() ?>start=<?php echo $t01_penerimaan_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t01_penerimaan_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t01_penerimaan_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t01_penerimaan_list->PageUrl() ?>start=<?php echo $t01_penerimaan_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t01_penerimaan_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t01_penerimaan_list->PageUrl() ?>start=<?php echo $t01_penerimaan_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t01_penerimaan_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t01_penerimaan_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t01_penerimaan_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t01_penerimaan_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t01_penerimaan_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t01_penerimaan_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t01_penerimaan_list->TotalRecs == 0 && $t01_penerimaan->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t01_penerimaan_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft01_penerimaanlistsrch.FilterList = <?php echo $t01_penerimaan_list->GetFilterList() ?>;
ft01_penerimaanlistsrch.Init();
ft01_penerimaanlist.Init();
</script>
<?php
$t01_penerimaan_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t01_penerimaan_list->Page_Terminate();
?>
