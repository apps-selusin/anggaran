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

$datapenerimaan_list = NULL; // Initialize page object first

class cdatapenerimaan_list extends cdatapenerimaan {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{EA1CE07B-E03E-4EC9-BC42-48D490D73F97}';

	// Table name
	var $TableName = 'datapenerimaan';

	// Page object name
	var $PageObjName = 'datapenerimaan_list';

	// Grid form hidden field names
	var $FormName = 'fdatapenerimaanlist';
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

		// Table object (datapenerimaan)
		if (!isset($GLOBALS["datapenerimaan"]) || get_class($GLOBALS["datapenerimaan"]) == "cdatapenerimaan") {
			$GLOBALS["datapenerimaan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["datapenerimaan"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "datapenerimaanadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "datapenerimaandelete.php";
		$this->MultiUpdateUrl = "datapenerimaanupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fdatapenerimaanlistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
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

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
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

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
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
			$this->replid->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->replid->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Initialize
		$sFilterList = "";
		$sSavedFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->replid->AdvancedSearch->ToJson(), ","); // Field replid
		$sFilterList = ew_Concat($sFilterList, $this->nama->AdvancedSearch->ToJson(), ","); // Field nama
		$sFilterList = ew_Concat($sFilterList, $this->besar->AdvancedSearch->ToJson(), ","); // Field besar
		$sFilterList = ew_Concat($sFilterList, $this->idkategori->AdvancedSearch->ToJson(), ","); // Field idkategori
		$sFilterList = ew_Concat($sFilterList, $this->rekkas->AdvancedSearch->ToJson(), ","); // Field rekkas
		$sFilterList = ew_Concat($sFilterList, $this->rekpendapatan->AdvancedSearch->ToJson(), ","); // Field rekpendapatan
		$sFilterList = ew_Concat($sFilterList, $this->rekpiutang->AdvancedSearch->ToJson(), ","); // Field rekpiutang
		$sFilterList = ew_Concat($sFilterList, $this->aktif->AdvancedSearch->ToJson(), ","); // Field aktif
		$sFilterList = ew_Concat($sFilterList, $this->keterangan->AdvancedSearch->ToJson(), ","); // Field keterangan
		$sFilterList = ew_Concat($sFilterList, $this->departemen->AdvancedSearch->ToJson(), ","); // Field departemen
		$sFilterList = ew_Concat($sFilterList, $this->info1->AdvancedSearch->ToJson(), ","); // Field info1
		$sFilterList = ew_Concat($sFilterList, $this->info2->AdvancedSearch->ToJson(), ","); // Field info2
		$sFilterList = ew_Concat($sFilterList, $this->info3->AdvancedSearch->ToJson(), ","); // Field info3
		$sFilterList = ew_Concat($sFilterList, $this->ts->AdvancedSearch->ToJson(), ","); // Field ts
		$sFilterList = ew_Concat($sFilterList, $this->token->AdvancedSearch->ToJson(), ","); // Field token
		$sFilterList = ew_Concat($sFilterList, $this->issync->AdvancedSearch->ToJson(), ","); // Field issync
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fdatapenerimaanlistsrch", $filters);

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

		// Field replid
		$this->replid->AdvancedSearch->SearchValue = @$filter["x_replid"];
		$this->replid->AdvancedSearch->SearchOperator = @$filter["z_replid"];
		$this->replid->AdvancedSearch->SearchCondition = @$filter["v_replid"];
		$this->replid->AdvancedSearch->SearchValue2 = @$filter["y_replid"];
		$this->replid->AdvancedSearch->SearchOperator2 = @$filter["w_replid"];
		$this->replid->AdvancedSearch->Save();

		// Field nama
		$this->nama->AdvancedSearch->SearchValue = @$filter["x_nama"];
		$this->nama->AdvancedSearch->SearchOperator = @$filter["z_nama"];
		$this->nama->AdvancedSearch->SearchCondition = @$filter["v_nama"];
		$this->nama->AdvancedSearch->SearchValue2 = @$filter["y_nama"];
		$this->nama->AdvancedSearch->SearchOperator2 = @$filter["w_nama"];
		$this->nama->AdvancedSearch->Save();

		// Field besar
		$this->besar->AdvancedSearch->SearchValue = @$filter["x_besar"];
		$this->besar->AdvancedSearch->SearchOperator = @$filter["z_besar"];
		$this->besar->AdvancedSearch->SearchCondition = @$filter["v_besar"];
		$this->besar->AdvancedSearch->SearchValue2 = @$filter["y_besar"];
		$this->besar->AdvancedSearch->SearchOperator2 = @$filter["w_besar"];
		$this->besar->AdvancedSearch->Save();

		// Field idkategori
		$this->idkategori->AdvancedSearch->SearchValue = @$filter["x_idkategori"];
		$this->idkategori->AdvancedSearch->SearchOperator = @$filter["z_idkategori"];
		$this->idkategori->AdvancedSearch->SearchCondition = @$filter["v_idkategori"];
		$this->idkategori->AdvancedSearch->SearchValue2 = @$filter["y_idkategori"];
		$this->idkategori->AdvancedSearch->SearchOperator2 = @$filter["w_idkategori"];
		$this->idkategori->AdvancedSearch->Save();

		// Field rekkas
		$this->rekkas->AdvancedSearch->SearchValue = @$filter["x_rekkas"];
		$this->rekkas->AdvancedSearch->SearchOperator = @$filter["z_rekkas"];
		$this->rekkas->AdvancedSearch->SearchCondition = @$filter["v_rekkas"];
		$this->rekkas->AdvancedSearch->SearchValue2 = @$filter["y_rekkas"];
		$this->rekkas->AdvancedSearch->SearchOperator2 = @$filter["w_rekkas"];
		$this->rekkas->AdvancedSearch->Save();

		// Field rekpendapatan
		$this->rekpendapatan->AdvancedSearch->SearchValue = @$filter["x_rekpendapatan"];
		$this->rekpendapatan->AdvancedSearch->SearchOperator = @$filter["z_rekpendapatan"];
		$this->rekpendapatan->AdvancedSearch->SearchCondition = @$filter["v_rekpendapatan"];
		$this->rekpendapatan->AdvancedSearch->SearchValue2 = @$filter["y_rekpendapatan"];
		$this->rekpendapatan->AdvancedSearch->SearchOperator2 = @$filter["w_rekpendapatan"];
		$this->rekpendapatan->AdvancedSearch->Save();

		// Field rekpiutang
		$this->rekpiutang->AdvancedSearch->SearchValue = @$filter["x_rekpiutang"];
		$this->rekpiutang->AdvancedSearch->SearchOperator = @$filter["z_rekpiutang"];
		$this->rekpiutang->AdvancedSearch->SearchCondition = @$filter["v_rekpiutang"];
		$this->rekpiutang->AdvancedSearch->SearchValue2 = @$filter["y_rekpiutang"];
		$this->rekpiutang->AdvancedSearch->SearchOperator2 = @$filter["w_rekpiutang"];
		$this->rekpiutang->AdvancedSearch->Save();

		// Field aktif
		$this->aktif->AdvancedSearch->SearchValue = @$filter["x_aktif"];
		$this->aktif->AdvancedSearch->SearchOperator = @$filter["z_aktif"];
		$this->aktif->AdvancedSearch->SearchCondition = @$filter["v_aktif"];
		$this->aktif->AdvancedSearch->SearchValue2 = @$filter["y_aktif"];
		$this->aktif->AdvancedSearch->SearchOperator2 = @$filter["w_aktif"];
		$this->aktif->AdvancedSearch->Save();

		// Field keterangan
		$this->keterangan->AdvancedSearch->SearchValue = @$filter["x_keterangan"];
		$this->keterangan->AdvancedSearch->SearchOperator = @$filter["z_keterangan"];
		$this->keterangan->AdvancedSearch->SearchCondition = @$filter["v_keterangan"];
		$this->keterangan->AdvancedSearch->SearchValue2 = @$filter["y_keterangan"];
		$this->keterangan->AdvancedSearch->SearchOperator2 = @$filter["w_keterangan"];
		$this->keterangan->AdvancedSearch->Save();

		// Field departemen
		$this->departemen->AdvancedSearch->SearchValue = @$filter["x_departemen"];
		$this->departemen->AdvancedSearch->SearchOperator = @$filter["z_departemen"];
		$this->departemen->AdvancedSearch->SearchCondition = @$filter["v_departemen"];
		$this->departemen->AdvancedSearch->SearchValue2 = @$filter["y_departemen"];
		$this->departemen->AdvancedSearch->SearchOperator2 = @$filter["w_departemen"];
		$this->departemen->AdvancedSearch->Save();

		// Field info1
		$this->info1->AdvancedSearch->SearchValue = @$filter["x_info1"];
		$this->info1->AdvancedSearch->SearchOperator = @$filter["z_info1"];
		$this->info1->AdvancedSearch->SearchCondition = @$filter["v_info1"];
		$this->info1->AdvancedSearch->SearchValue2 = @$filter["y_info1"];
		$this->info1->AdvancedSearch->SearchOperator2 = @$filter["w_info1"];
		$this->info1->AdvancedSearch->Save();

		// Field info2
		$this->info2->AdvancedSearch->SearchValue = @$filter["x_info2"];
		$this->info2->AdvancedSearch->SearchOperator = @$filter["z_info2"];
		$this->info2->AdvancedSearch->SearchCondition = @$filter["v_info2"];
		$this->info2->AdvancedSearch->SearchValue2 = @$filter["y_info2"];
		$this->info2->AdvancedSearch->SearchOperator2 = @$filter["w_info2"];
		$this->info2->AdvancedSearch->Save();

		// Field info3
		$this->info3->AdvancedSearch->SearchValue = @$filter["x_info3"];
		$this->info3->AdvancedSearch->SearchOperator = @$filter["z_info3"];
		$this->info3->AdvancedSearch->SearchCondition = @$filter["v_info3"];
		$this->info3->AdvancedSearch->SearchValue2 = @$filter["y_info3"];
		$this->info3->AdvancedSearch->SearchOperator2 = @$filter["w_info3"];
		$this->info3->AdvancedSearch->Save();

		// Field ts
		$this->ts->AdvancedSearch->SearchValue = @$filter["x_ts"];
		$this->ts->AdvancedSearch->SearchOperator = @$filter["z_ts"];
		$this->ts->AdvancedSearch->SearchCondition = @$filter["v_ts"];
		$this->ts->AdvancedSearch->SearchValue2 = @$filter["y_ts"];
		$this->ts->AdvancedSearch->SearchOperator2 = @$filter["w_ts"];
		$this->ts->AdvancedSearch->Save();

		// Field token
		$this->token->AdvancedSearch->SearchValue = @$filter["x_token"];
		$this->token->AdvancedSearch->SearchOperator = @$filter["z_token"];
		$this->token->AdvancedSearch->SearchCondition = @$filter["v_token"];
		$this->token->AdvancedSearch->SearchValue2 = @$filter["y_token"];
		$this->token->AdvancedSearch->SearchOperator2 = @$filter["w_token"];
		$this->token->AdvancedSearch->Save();

		// Field issync
		$this->issync->AdvancedSearch->SearchValue = @$filter["x_issync"];
		$this->issync->AdvancedSearch->SearchOperator = @$filter["z_issync"];
		$this->issync->AdvancedSearch->SearchCondition = @$filter["v_issync"];
		$this->issync->AdvancedSearch->SearchValue2 = @$filter["y_issync"];
		$this->issync->AdvancedSearch->SearchOperator2 = @$filter["w_issync"];
		$this->issync->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->nama, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->idkategori, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->rekkas, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->rekpendapatan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->rekpiutang, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->keterangan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->departemen, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->info1, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->info2, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->info3, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .= "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($sSearchKeyword <> "") {
			$ar = $this->BasicSearch->KeywordList($Default);

			// Search keyword in any fields
			if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
						$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
					}
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
			}
			if (!$Default && in_array($this->Command, array("", "reset", "resetall"))) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->replid); // replid
			$this->UpdateSort($this->nama); // nama
			$this->UpdateSort($this->besar); // besar
			$this->UpdateSort($this->idkategori); // idkategori
			$this->UpdateSort($this->rekkas); // rekkas
			$this->UpdateSort($this->rekpendapatan); // rekpendapatan
			$this->UpdateSort($this->rekpiutang); // rekpiutang
			$this->UpdateSort($this->aktif); // aktif
			$this->UpdateSort($this->keterangan); // keterangan
			$this->UpdateSort($this->departemen); // departemen
			$this->UpdateSort($this->info1); // info1
			$this->UpdateSort($this->info2); // info2
			$this->UpdateSort($this->info3); // info3
			$this->UpdateSort($this->ts); // ts
			$this->UpdateSort($this->token); // token
			$this->UpdateSort($this->issync); // issync
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
				$this->replid->setSort("");
				$this->nama->setSort("");
				$this->besar->setSort("");
				$this->idkategori->setSort("");
				$this->rekkas->setSort("");
				$this->rekpendapatan->setSort("");
				$this->rekpiutang->setSort("");
				$this->aktif->setSort("");
				$this->keterangan->setSort("");
				$this->departemen->setSort("");
				$this->info1->setSort("");
				$this->info2->setSort("");
				$this->info3->setSort("");
				$this->ts->setSort("");
				$this->token->setSort("");
				$this->issync->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
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

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if (TRUE)
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->replid->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fdatapenerimaanlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fdatapenerimaanlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fdatapenerimaanlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fdatapenerimaanlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
if (!isset($datapenerimaan_list)) $datapenerimaan_list = new cdatapenerimaan_list();

// Page init
$datapenerimaan_list->Page_Init();

// Page main
$datapenerimaan_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$datapenerimaan_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fdatapenerimaanlist = new ew_Form("fdatapenerimaanlist", "list");
fdatapenerimaanlist.FormKeyCountName = '<?php echo $datapenerimaan_list->FormKeyCountName ?>';

// Form_CustomValidate event
fdatapenerimaanlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fdatapenerimaanlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fdatapenerimaanlistsrch = new ew_Form("fdatapenerimaanlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($datapenerimaan_list->TotalRecs > 0 && $datapenerimaan_list->ExportOptions->Visible()) { ?>
<?php $datapenerimaan_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($datapenerimaan_list->SearchOptions->Visible()) { ?>
<?php $datapenerimaan_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($datapenerimaan_list->FilterOptions->Visible()) { ?>
<?php $datapenerimaan_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $datapenerimaan_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($datapenerimaan_list->TotalRecs <= 0)
			$datapenerimaan_list->TotalRecs = $datapenerimaan->ListRecordCount();
	} else {
		if (!$datapenerimaan_list->Recordset && ($datapenerimaan_list->Recordset = $datapenerimaan_list->LoadRecordset()))
			$datapenerimaan_list->TotalRecs = $datapenerimaan_list->Recordset->RecordCount();
	}
	$datapenerimaan_list->StartRec = 1;
	if ($datapenerimaan_list->DisplayRecs <= 0 || ($datapenerimaan->Export <> "" && $datapenerimaan->ExportAll)) // Display all records
		$datapenerimaan_list->DisplayRecs = $datapenerimaan_list->TotalRecs;
	if (!($datapenerimaan->Export <> "" && $datapenerimaan->ExportAll))
		$datapenerimaan_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$datapenerimaan_list->Recordset = $datapenerimaan_list->LoadRecordset($datapenerimaan_list->StartRec-1, $datapenerimaan_list->DisplayRecs);

	// Set no record found message
	if ($datapenerimaan->CurrentAction == "" && $datapenerimaan_list->TotalRecs == 0) {
		if ($datapenerimaan_list->SearchWhere == "0=101")
			$datapenerimaan_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$datapenerimaan_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$datapenerimaan_list->RenderOtherOptions();
?>
<?php if ($datapenerimaan->Export == "" && $datapenerimaan->CurrentAction == "") { ?>
<form name="fdatapenerimaanlistsrch" id="fdatapenerimaanlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($datapenerimaan_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fdatapenerimaanlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="datapenerimaan">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($datapenerimaan_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($datapenerimaan_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $datapenerimaan_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($datapenerimaan_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($datapenerimaan_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($datapenerimaan_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($datapenerimaan_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $datapenerimaan_list->ShowPageHeader(); ?>
<?php
$datapenerimaan_list->ShowMessage();
?>
<?php if ($datapenerimaan_list->TotalRecs > 0 || $datapenerimaan->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($datapenerimaan_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> datapenerimaan">
<form name="fdatapenerimaanlist" id="fdatapenerimaanlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($datapenerimaan_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $datapenerimaan_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="datapenerimaan">
<div id="gmp_datapenerimaan" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($datapenerimaan_list->TotalRecs > 0 || $datapenerimaan->CurrentAction == "gridedit") { ?>
<table id="tbl_datapenerimaanlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$datapenerimaan_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$datapenerimaan_list->RenderListOptions();

// Render list options (header, left)
$datapenerimaan_list->ListOptions->Render("header", "left");
?>
<?php if ($datapenerimaan->replid->Visible) { // replid ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->replid) == "") { ?>
		<th data-name="replid" class="<?php echo $datapenerimaan->replid->HeaderCellClass() ?>"><div id="elh_datapenerimaan_replid" class="datapenerimaan_replid"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->replid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="replid" class="<?php echo $datapenerimaan->replid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->replid) ?>',1);"><div id="elh_datapenerimaan_replid" class="datapenerimaan_replid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->replid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->replid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->replid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->nama->Visible) { // nama ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->nama) == "") { ?>
		<th data-name="nama" class="<?php echo $datapenerimaan->nama->HeaderCellClass() ?>"><div id="elh_datapenerimaan_nama" class="datapenerimaan_nama"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->nama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama" class="<?php echo $datapenerimaan->nama->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->nama) ?>',1);"><div id="elh_datapenerimaan_nama" class="datapenerimaan_nama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->nama->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->nama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->nama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->besar->Visible) { // besar ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->besar) == "") { ?>
		<th data-name="besar" class="<?php echo $datapenerimaan->besar->HeaderCellClass() ?>"><div id="elh_datapenerimaan_besar" class="datapenerimaan_besar"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->besar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="besar" class="<?php echo $datapenerimaan->besar->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->besar) ?>',1);"><div id="elh_datapenerimaan_besar" class="datapenerimaan_besar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->besar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->besar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->besar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->idkategori->Visible) { // idkategori ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->idkategori) == "") { ?>
		<th data-name="idkategori" class="<?php echo $datapenerimaan->idkategori->HeaderCellClass() ?>"><div id="elh_datapenerimaan_idkategori" class="datapenerimaan_idkategori"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->idkategori->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idkategori" class="<?php echo $datapenerimaan->idkategori->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->idkategori) ?>',1);"><div id="elh_datapenerimaan_idkategori" class="datapenerimaan_idkategori">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->idkategori->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->idkategori->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->idkategori->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->rekkas->Visible) { // rekkas ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->rekkas) == "") { ?>
		<th data-name="rekkas" class="<?php echo $datapenerimaan->rekkas->HeaderCellClass() ?>"><div id="elh_datapenerimaan_rekkas" class="datapenerimaan_rekkas"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->rekkas->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rekkas" class="<?php echo $datapenerimaan->rekkas->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->rekkas) ?>',1);"><div id="elh_datapenerimaan_rekkas" class="datapenerimaan_rekkas">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->rekkas->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->rekkas->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->rekkas->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->rekpendapatan->Visible) { // rekpendapatan ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->rekpendapatan) == "") { ?>
		<th data-name="rekpendapatan" class="<?php echo $datapenerimaan->rekpendapatan->HeaderCellClass() ?>"><div id="elh_datapenerimaan_rekpendapatan" class="datapenerimaan_rekpendapatan"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->rekpendapatan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rekpendapatan" class="<?php echo $datapenerimaan->rekpendapatan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->rekpendapatan) ?>',1);"><div id="elh_datapenerimaan_rekpendapatan" class="datapenerimaan_rekpendapatan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->rekpendapatan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->rekpendapatan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->rekpendapatan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->rekpiutang->Visible) { // rekpiutang ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->rekpiutang) == "") { ?>
		<th data-name="rekpiutang" class="<?php echo $datapenerimaan->rekpiutang->HeaderCellClass() ?>"><div id="elh_datapenerimaan_rekpiutang" class="datapenerimaan_rekpiutang"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->rekpiutang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rekpiutang" class="<?php echo $datapenerimaan->rekpiutang->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->rekpiutang) ?>',1);"><div id="elh_datapenerimaan_rekpiutang" class="datapenerimaan_rekpiutang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->rekpiutang->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->rekpiutang->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->rekpiutang->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->aktif->Visible) { // aktif ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->aktif) == "") { ?>
		<th data-name="aktif" class="<?php echo $datapenerimaan->aktif->HeaderCellClass() ?>"><div id="elh_datapenerimaan_aktif" class="datapenerimaan_aktif"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->aktif->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="aktif" class="<?php echo $datapenerimaan->aktif->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->aktif) ?>',1);"><div id="elh_datapenerimaan_aktif" class="datapenerimaan_aktif">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->aktif->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->aktif->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->aktif->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->keterangan->Visible) { // keterangan ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->keterangan) == "") { ?>
		<th data-name="keterangan" class="<?php echo $datapenerimaan->keterangan->HeaderCellClass() ?>"><div id="elh_datapenerimaan_keterangan" class="datapenerimaan_keterangan"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->keterangan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="keterangan" class="<?php echo $datapenerimaan->keterangan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->keterangan) ?>',1);"><div id="elh_datapenerimaan_keterangan" class="datapenerimaan_keterangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->keterangan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->keterangan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->keterangan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->departemen->Visible) { // departemen ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->departemen) == "") { ?>
		<th data-name="departemen" class="<?php echo $datapenerimaan->departemen->HeaderCellClass() ?>"><div id="elh_datapenerimaan_departemen" class="datapenerimaan_departemen"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->departemen->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="departemen" class="<?php echo $datapenerimaan->departemen->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->departemen) ?>',1);"><div id="elh_datapenerimaan_departemen" class="datapenerimaan_departemen">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->departemen->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->departemen->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->departemen->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->info1->Visible) { // info1 ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->info1) == "") { ?>
		<th data-name="info1" class="<?php echo $datapenerimaan->info1->HeaderCellClass() ?>"><div id="elh_datapenerimaan_info1" class="datapenerimaan_info1"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->info1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="info1" class="<?php echo $datapenerimaan->info1->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->info1) ?>',1);"><div id="elh_datapenerimaan_info1" class="datapenerimaan_info1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->info1->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->info1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->info1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->info2->Visible) { // info2 ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->info2) == "") { ?>
		<th data-name="info2" class="<?php echo $datapenerimaan->info2->HeaderCellClass() ?>"><div id="elh_datapenerimaan_info2" class="datapenerimaan_info2"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->info2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="info2" class="<?php echo $datapenerimaan->info2->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->info2) ?>',1);"><div id="elh_datapenerimaan_info2" class="datapenerimaan_info2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->info2->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->info2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->info2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->info3->Visible) { // info3 ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->info3) == "") { ?>
		<th data-name="info3" class="<?php echo $datapenerimaan->info3->HeaderCellClass() ?>"><div id="elh_datapenerimaan_info3" class="datapenerimaan_info3"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->info3->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="info3" class="<?php echo $datapenerimaan->info3->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->info3) ?>',1);"><div id="elh_datapenerimaan_info3" class="datapenerimaan_info3">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->info3->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->info3->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->info3->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->ts->Visible) { // ts ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->ts) == "") { ?>
		<th data-name="ts" class="<?php echo $datapenerimaan->ts->HeaderCellClass() ?>"><div id="elh_datapenerimaan_ts" class="datapenerimaan_ts"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->ts->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ts" class="<?php echo $datapenerimaan->ts->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->ts) ?>',1);"><div id="elh_datapenerimaan_ts" class="datapenerimaan_ts">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->ts->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->ts->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->ts->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->token->Visible) { // token ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->token) == "") { ?>
		<th data-name="token" class="<?php echo $datapenerimaan->token->HeaderCellClass() ?>"><div id="elh_datapenerimaan_token" class="datapenerimaan_token"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->token->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="token" class="<?php echo $datapenerimaan->token->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->token) ?>',1);"><div id="elh_datapenerimaan_token" class="datapenerimaan_token">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->token->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->token->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->token->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($datapenerimaan->issync->Visible) { // issync ?>
	<?php if ($datapenerimaan->SortUrl($datapenerimaan->issync) == "") { ?>
		<th data-name="issync" class="<?php echo $datapenerimaan->issync->HeaderCellClass() ?>"><div id="elh_datapenerimaan_issync" class="datapenerimaan_issync"><div class="ewTableHeaderCaption"><?php echo $datapenerimaan->issync->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="issync" class="<?php echo $datapenerimaan->issync->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $datapenerimaan->SortUrl($datapenerimaan->issync) ?>',1);"><div id="elh_datapenerimaan_issync" class="datapenerimaan_issync">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $datapenerimaan->issync->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($datapenerimaan->issync->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($datapenerimaan->issync->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$datapenerimaan_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($datapenerimaan->ExportAll && $datapenerimaan->Export <> "") {
	$datapenerimaan_list->StopRec = $datapenerimaan_list->TotalRecs;
} else {

	// Set the last record to display
	if ($datapenerimaan_list->TotalRecs > $datapenerimaan_list->StartRec + $datapenerimaan_list->DisplayRecs - 1)
		$datapenerimaan_list->StopRec = $datapenerimaan_list->StartRec + $datapenerimaan_list->DisplayRecs - 1;
	else
		$datapenerimaan_list->StopRec = $datapenerimaan_list->TotalRecs;
}
$datapenerimaan_list->RecCnt = $datapenerimaan_list->StartRec - 1;
if ($datapenerimaan_list->Recordset && !$datapenerimaan_list->Recordset->EOF) {
	$datapenerimaan_list->Recordset->MoveFirst();
	$bSelectLimit = $datapenerimaan_list->UseSelectLimit;
	if (!$bSelectLimit && $datapenerimaan_list->StartRec > 1)
		$datapenerimaan_list->Recordset->Move($datapenerimaan_list->StartRec - 1);
} elseif (!$datapenerimaan->AllowAddDeleteRow && $datapenerimaan_list->StopRec == 0) {
	$datapenerimaan_list->StopRec = $datapenerimaan->GridAddRowCount;
}

// Initialize aggregate
$datapenerimaan->RowType = EW_ROWTYPE_AGGREGATEINIT;
$datapenerimaan->ResetAttrs();
$datapenerimaan_list->RenderRow();
while ($datapenerimaan_list->RecCnt < $datapenerimaan_list->StopRec) {
	$datapenerimaan_list->RecCnt++;
	if (intval($datapenerimaan_list->RecCnt) >= intval($datapenerimaan_list->StartRec)) {
		$datapenerimaan_list->RowCnt++;

		// Set up key count
		$datapenerimaan_list->KeyCount = $datapenerimaan_list->RowIndex;

		// Init row class and style
		$datapenerimaan->ResetAttrs();
		$datapenerimaan->CssClass = "";
		if ($datapenerimaan->CurrentAction == "gridadd") {
		} else {
			$datapenerimaan_list->LoadRowValues($datapenerimaan_list->Recordset); // Load row values
		}
		$datapenerimaan->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$datapenerimaan->RowAttrs = array_merge($datapenerimaan->RowAttrs, array('data-rowindex'=>$datapenerimaan_list->RowCnt, 'id'=>'r' . $datapenerimaan_list->RowCnt . '_datapenerimaan', 'data-rowtype'=>$datapenerimaan->RowType));

		// Render row
		$datapenerimaan_list->RenderRow();

		// Render list options
		$datapenerimaan_list->RenderListOptions();
?>
	<tr<?php echo $datapenerimaan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$datapenerimaan_list->ListOptions->Render("body", "left", $datapenerimaan_list->RowCnt);
?>
	<?php if ($datapenerimaan->replid->Visible) { // replid ?>
		<td data-name="replid"<?php echo $datapenerimaan->replid->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_replid" class="datapenerimaan_replid">
<span<?php echo $datapenerimaan->replid->ViewAttributes() ?>>
<?php echo $datapenerimaan->replid->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->nama->Visible) { // nama ?>
		<td data-name="nama"<?php echo $datapenerimaan->nama->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_nama" class="datapenerimaan_nama">
<span<?php echo $datapenerimaan->nama->ViewAttributes() ?>>
<?php echo $datapenerimaan->nama->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->besar->Visible) { // besar ?>
		<td data-name="besar"<?php echo $datapenerimaan->besar->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_besar" class="datapenerimaan_besar">
<span<?php echo $datapenerimaan->besar->ViewAttributes() ?>>
<?php echo $datapenerimaan->besar->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->idkategori->Visible) { // idkategori ?>
		<td data-name="idkategori"<?php echo $datapenerimaan->idkategori->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_idkategori" class="datapenerimaan_idkategori">
<span<?php echo $datapenerimaan->idkategori->ViewAttributes() ?>>
<?php echo $datapenerimaan->idkategori->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->rekkas->Visible) { // rekkas ?>
		<td data-name="rekkas"<?php echo $datapenerimaan->rekkas->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_rekkas" class="datapenerimaan_rekkas">
<span<?php echo $datapenerimaan->rekkas->ViewAttributes() ?>>
<?php echo $datapenerimaan->rekkas->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->rekpendapatan->Visible) { // rekpendapatan ?>
		<td data-name="rekpendapatan"<?php echo $datapenerimaan->rekpendapatan->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_rekpendapatan" class="datapenerimaan_rekpendapatan">
<span<?php echo $datapenerimaan->rekpendapatan->ViewAttributes() ?>>
<?php echo $datapenerimaan->rekpendapatan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->rekpiutang->Visible) { // rekpiutang ?>
		<td data-name="rekpiutang"<?php echo $datapenerimaan->rekpiutang->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_rekpiutang" class="datapenerimaan_rekpiutang">
<span<?php echo $datapenerimaan->rekpiutang->ViewAttributes() ?>>
<?php echo $datapenerimaan->rekpiutang->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->aktif->Visible) { // aktif ?>
		<td data-name="aktif"<?php echo $datapenerimaan->aktif->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_aktif" class="datapenerimaan_aktif">
<span<?php echo $datapenerimaan->aktif->ViewAttributes() ?>>
<?php echo $datapenerimaan->aktif->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->keterangan->Visible) { // keterangan ?>
		<td data-name="keterangan"<?php echo $datapenerimaan->keterangan->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_keterangan" class="datapenerimaan_keterangan">
<span<?php echo $datapenerimaan->keterangan->ViewAttributes() ?>>
<?php echo $datapenerimaan->keterangan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->departemen->Visible) { // departemen ?>
		<td data-name="departemen"<?php echo $datapenerimaan->departemen->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_departemen" class="datapenerimaan_departemen">
<span<?php echo $datapenerimaan->departemen->ViewAttributes() ?>>
<?php echo $datapenerimaan->departemen->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->info1->Visible) { // info1 ?>
		<td data-name="info1"<?php echo $datapenerimaan->info1->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_info1" class="datapenerimaan_info1">
<span<?php echo $datapenerimaan->info1->ViewAttributes() ?>>
<?php echo $datapenerimaan->info1->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->info2->Visible) { // info2 ?>
		<td data-name="info2"<?php echo $datapenerimaan->info2->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_info2" class="datapenerimaan_info2">
<span<?php echo $datapenerimaan->info2->ViewAttributes() ?>>
<?php echo $datapenerimaan->info2->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->info3->Visible) { // info3 ?>
		<td data-name="info3"<?php echo $datapenerimaan->info3->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_info3" class="datapenerimaan_info3">
<span<?php echo $datapenerimaan->info3->ViewAttributes() ?>>
<?php echo $datapenerimaan->info3->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->ts->Visible) { // ts ?>
		<td data-name="ts"<?php echo $datapenerimaan->ts->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_ts" class="datapenerimaan_ts">
<span<?php echo $datapenerimaan->ts->ViewAttributes() ?>>
<?php echo $datapenerimaan->ts->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->token->Visible) { // token ?>
		<td data-name="token"<?php echo $datapenerimaan->token->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_token" class="datapenerimaan_token">
<span<?php echo $datapenerimaan->token->ViewAttributes() ?>>
<?php echo $datapenerimaan->token->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($datapenerimaan->issync->Visible) { // issync ?>
		<td data-name="issync"<?php echo $datapenerimaan->issync->CellAttributes() ?>>
<span id="el<?php echo $datapenerimaan_list->RowCnt ?>_datapenerimaan_issync" class="datapenerimaan_issync">
<span<?php echo $datapenerimaan->issync->ViewAttributes() ?>>
<?php echo $datapenerimaan->issync->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$datapenerimaan_list->ListOptions->Render("body", "right", $datapenerimaan_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($datapenerimaan->CurrentAction <> "gridadd")
		$datapenerimaan_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($datapenerimaan->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($datapenerimaan_list->Recordset)
	$datapenerimaan_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($datapenerimaan->CurrentAction <> "gridadd" && $datapenerimaan->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($datapenerimaan_list->Pager)) $datapenerimaan_list->Pager = new cPrevNextPager($datapenerimaan_list->StartRec, $datapenerimaan_list->DisplayRecs, $datapenerimaan_list->TotalRecs, $datapenerimaan_list->AutoHidePager) ?>
<?php if ($datapenerimaan_list->Pager->RecordCount > 0 && $datapenerimaan_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($datapenerimaan_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $datapenerimaan_list->PageUrl() ?>start=<?php echo $datapenerimaan_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($datapenerimaan_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $datapenerimaan_list->PageUrl() ?>start=<?php echo $datapenerimaan_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $datapenerimaan_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($datapenerimaan_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $datapenerimaan_list->PageUrl() ?>start=<?php echo $datapenerimaan_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($datapenerimaan_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $datapenerimaan_list->PageUrl() ?>start=<?php echo $datapenerimaan_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $datapenerimaan_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($datapenerimaan_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $datapenerimaan_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $datapenerimaan_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $datapenerimaan_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($datapenerimaan_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($datapenerimaan_list->TotalRecs == 0 && $datapenerimaan->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($datapenerimaan_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fdatapenerimaanlistsrch.FilterList = <?php echo $datapenerimaan_list->GetFilterList() ?>;
fdatapenerimaanlistsrch.Init();
fdatapenerimaanlist.Init();
</script>
<?php
$datapenerimaan_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$datapenerimaan_list->Page_Terminate();
?>
