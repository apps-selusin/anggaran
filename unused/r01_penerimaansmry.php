<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "rcfg11.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "rphpfn11.php" ?>
<?php include_once "rusrfn11.php" ?>
<?php include_once "r01_penerimaansmryinfo.php" ?>
<?php

//
// Page class
//

$r01_penerimaan_summary = NULL; // Initialize page object first

class crr01_penerimaan_summary extends crr01_penerimaan {

	// Page ID
	var $PageID = 'summary';

	// Project ID
	var $ProjectID = "{CE2BFCDC-32CE-41CA-ABF9-868662EE06FE}";

	// Page object name
	var $PageObjName = 'r01_penerimaan_summary';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $ReportLanguage;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $ReportLanguage;
		if ($this->Subheading <> "")
			return $this->Subheading;
		return "";
	}

	// Page name
	function PageName() {
		return ewr_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewr_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Export URLs
	var $ExportPrintUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportPdfUrl;
	var $ReportTableClass;
	var $ReportTableStyle = "";

	// Custom export
	var $ExportPrintCustom = FALSE;
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EWR_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EWR_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EWR_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EWR_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_WARNING_MESSAGE], $v);
	}

		// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EWR_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EWR_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EWR_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EWR_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") // Header exists, display
			echo $sHeader;
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") // Fotoer exists, display
			echo $sFooter;
	}

	// Validate page request
	function IsPageRequest() {
		if ($this->UseTokenInUrl) {
			if (ewr_IsHttpPost())
				return ($this->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $CheckToken = EWR_CHECK_TOKEN;
	var $CheckTokenFn = "ewr_CheckToken";
	var $CreateTokenFn = "ewr_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ewr_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EWR_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EWR_TOKEN_NAME]);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $grToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$grToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (r01_penerimaan)
		if (!isset($GLOBALS["r01_penerimaan"])) {
			$GLOBALS["r01_penerimaan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["r01_penerimaan"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWR_PAGE_ID"))
			define("EWR_PAGE_ID", 'summary', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWR_TABLE_NAME"))
			define("EWR_TABLE_NAME", 'r01_penerimaan', TRUE);

		// Start timer
		if (!isset($GLOBALS["grTimer"]))
			$GLOBALS["grTimer"] = new crTimer();

		// Debug message
		ewr_LoadDebugMsg();

		// Open connection
		if (!isset($conn)) $conn = ewr_Connect($this->DBID);

		// Export options
		$this->ExportOptions = new crListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Search options
		$this->SearchOptions = new crListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Filter options
		$this->FilterOptions = new crListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fr01_penerimaansummary";

		// Generate report options
		$this->GenerateOptions = new crListOptions();
		$this->GenerateOptions->Tag = "div";
		$this->GenerateOptions->TagClassName = "ewGenerateOption";
	}

	//
	// Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $gsEmailContentType, $ReportLanguage, $Security, $UserProfile;
		global $gsCustomExport;

		// Get export parameters
		if (@$_GET["export"] <> "")
			$this->Export = strtolower($_GET["export"]);
		elseif (@$_POST["export"] <> "")
			$this->Export = strtolower($_POST["export"]);
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		$gsEmailContentType = @$_POST["contenttype"]; // Get email content type

		// Setup placeholder
		// Setup export options

		$this->SetupExportOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $ReportLanguage->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Security, $ReportLanguage, $ReportOptions;
		$exportid = session_id();
		$ReportTypes = array();

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a class=\"ewrExportLink ewPrint\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" href=\"" . $this->ExportPrintUrl . "\">" . $ReportLanguage->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;
		$ReportTypes["print"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPrint") : "";

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a class=\"ewrExportLink ewExcel\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" href=\"" . $this->ExportExcelUrl . "\">" . $ReportLanguage->Phrase("ExportToExcel") . "</a>";
		$item->Visible = FALSE;
		$ReportTypes["excel"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormExcel") : "";

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a class=\"ewrExportLink ewWord\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" href=\"" . $this->ExportWordUrl . "\">" . $ReportLanguage->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;
		$ReportTypes["word"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormWord") : "";

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a class=\"ewrExportLink ewPdf\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" href=\"" . $this->ExportPdfUrl . "\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Uncomment codes below to show export to Pdf link
//		$item->Visible = FALSE;

		$ReportTypes["pdf"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPdf") : "";

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = $this->PageUrl() . "export=email";
		$item->Body = "<a class=\"ewrExportLink ewEmail\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf_r01_penerimaan\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_r01_penerimaan',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;
		$ReportTypes["email"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormEmail") : "";
		$ReportOptions["ReportTypes"] = $ReportTypes;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = FALSE;
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = $this->ExportOptions->UseDropDownButton;
		$this->ExportOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fr01_penerimaansummary\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fr01_penerimaansummary\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton; // v8
		$this->FilterOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Set up options (extended)
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($this->Export <> "") {
			$this->ExportOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}

		// Set up table class
		if ($this->Export == "word" || $this->Export == "excel" || $this->Export == "pdf")
			$this->ReportTableClass = "ewTable";
		else
			$this->ReportTableClass = "table ewTable";
	}

	// Set up search options
	function SetupSearchOptions() {
		global $ReportLanguage;

		// Filter panel button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = $this->FilterApplied ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"fr01_penerimaansummary\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Reset filter
		$item = &$this->SearchOptions->Add("resetfilter");
		$item->Body = "<button type=\"button\" class=\"btn btn-default\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" onclick=\"location='" . ewr_CurrentPage() . "?cmd=reset'\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</button>";
		$item->Visible = TRUE && $this->FilterApplied;

		// Button group for reset filter
		$this->SearchOptions->UseButtonGroup = TRUE;

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->SearchOptions->HideAllOptions();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $ReportLanguage, $EWR_EXPORT, $gsExportFile;
		global $grDashboardReport;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		if ($this->Export <> "" && array_key_exists($this->Export, $EWR_EXPORT)) {
			$sContent = ob_get_contents();
			if (ob_get_length())
				ob_end_clean();

			// Remove all <div data-tagid="..." id="orig..." class="hide">...</div> (for customviewtag export, except "googlemaps")
			if (preg_match_all('/<div\s+data-tagid=[\'"]([\s\S]*?)[\'"]\s+id=[\'"]orig([\s\S]*?)[\'"]\s+class\s*=\s*[\'"]hide[\'"]>([\s\S]*?)<\/div\s*>/i', $sContent, $divmatches, PREG_SET_ORDER)) {
				foreach ($divmatches as $divmatch) {
					if ($divmatch[1] <> "googlemaps")
						$sContent = str_replace($divmatch[0], '', $sContent);
				}
			}
			$fn = $EWR_EXPORT[$this->Export];
			if ($this->Export == "email") { // Email
				if (@$this->GenOptions["reporttype"] == "email") {
					$saveResponse = $this->$fn($sContent, $this->GenOptions);
					$this->WriteGenResponse($saveResponse);
				} else {
					echo $this->$fn($sContent, array());
				}
				$url = ""; // Avoid redirect
			} else {
				$saveToFile = $this->$fn($sContent, $this->GenOptions);
				if (@$this->GenOptions["reporttype"] <> "") {
					$saveUrl = ($saveToFile <> "") ? ewr_FullUrl($saveToFile, "genurl") : $ReportLanguage->Phrase("GenerateSuccess");
					$this->WriteGenResponse($saveUrl);
					$url = ""; // Avoid redirect
				}
			}
		}

		// Close connection if not in dashboard
		if (!$grDashboardReport)
			ewr_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EWR_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ewr_SaveDebugMsg();
			header("Location: " . $url);
		}
		if (!$grDashboardReport)
			exit();
	}

	// Initialize common variables
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $FilterOptions; // Filter options

	// Paging variables
	var $RecIndex = 0; // Record index
	var $RecCount = 0; // Record count
	var $StartGrp = 0; // Start group
	var $StopGrp = 0; // Stop group
	var $TotalGrps = 0; // Total groups
	var $GrpCount = 0; // Group count
	var $GrpCounter = array(); // Group counter
	var $DisplayGrps = 3; // Groups per page
	var $GrpRange = 10;
	var $Sort = "";
	var $Filter = "";
	var $PageFirstGroupFilter = "";
	var $UserIDFilter = "";
	var $DrillDown = FALSE;
	var $DrillDownInPanel = FALSE;
	var $DrillDownList = "";

	// Clear field for ext filter
	var $ClearExtFilter = "";
	var $PopupName = "";
	var $PopupValue = "";
	var $FilterApplied;
	var $SearchCommand = FALSE;
	var $ShowHeader;
	var $GrpColumnCount = 0;
	var $SubGrpColumnCount = 0;
	var $DtlColumnCount = 0;
	var $Cnt, $Col, $Val, $Smry, $Mn, $Mx, $GrandCnt, $GrandSmry, $GrandMn, $GrandMx;
	var $TotCount;
	var $GrandSummarySetup = FALSE;
	var $GrpIdx;
	var $DetailRows = array();
	var $TopContentClass = "col-sm-12 ewTop";
	var $LeftContentClass = "ewLeft";
	var $CenterContentClass = "col-sm-12 ewCenter";
	var $RightContentClass = "ewRight";
	var $BottomContentClass = "col-sm-12 ewBottom";

	//
	// Page main
	//
	function Page_Main() {
		global $rs;
		global $rsgrp;
		global $Security;
		global $grFormError;
		global $grDrillDownInPanel;
		global $ReportBreadcrumb;
		global $ReportLanguage;
		global $grDashboardReport;

		// Set field visibility for detail fields
		$this->id->SetVisibility();
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

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 14;
		$nGrps = 1;
		$this->Val = &ewr_InitArray($nDtls, 0);
		$this->Cnt = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Smry = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Mn = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->Mx = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->GrandCnt = &ewr_InitArray($nDtls, 0);
		$this->GrandSmry = &ewr_InitArray($nDtls, 0);
		$this->GrandMn = &ewr_InitArray($nDtls, NULL);
		$this->GrandMx = &ewr_InitArray($nDtls, NULL);

		// Set up array if accumulation required: array(Accum, SkipNullOrZero)
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Check if search command
		$this->SearchCommand = (@$_GET["cmd"] == "search");

		// Load default filter values
		$this->LoadDefaultFilters();

		// Load custom filters
		$this->Page_FilterLoad();

		// Set up popup filter
		$this->SetupPopup();

		// Load group db values if necessary
		$this->LoadGroupDbValues();

		// Handle Ajax popup
		$this->ProcessAjaxPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Restore filter list
		$this->RestoreFilterList();

		// Build extended filter
		$sExtendedFilter = $this->GetExtendedFilter();
		ewr_AddFilter($this->Filter, $sExtendedFilter);

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewr_SetDebugMsg("popup filter: " . $sPopupFilter);
		ewr_AddFilter($this->Filter, $sPopupFilter);

		// Check if filter applied
		$this->FilterApplied = $this->CheckFilter();

		// Call Page Selecting event
		$this->Page_Selecting($this->Filter);

		// Requires search criteria
		if (($this->Filter == $this->UserIDFilter || $grFormError != "") && !$this->DrillDown)
			$this->Filter = "0=101";

		// Search options
		$this->SetupSearchOptions();

		// Get sort
		$this->Sort = $this->GetSort($this->GenOptions);

		// Get total count
		$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0 || $this->DrillDown || $grDashboardReport) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowHeader = ($this->TotalGrps > 0);

		// Set up start position if not export all
		if ($this->ExportAll && $this->Export <> "")
			$this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup($this->GenOptions);

		// Set no record found message
		if ($this->TotalGrps == 0) {
				if ($this->Filter == "0=101") {
					$this->setWarningMessage($ReportLanguage->Phrase("EnterSearchCriteria"));
				} else {
					$this->setWarningMessage($ReportLanguage->Phrase("NoRecord"));
				}
		}

		// Hide export options if export/dashboard report
		if ($this->Export <> "" || $grDashboardReport)
			$this->ExportOptions->HideAllOptions();

		// Hide search/filter options if export/drilldown/dashboard report
		if ($this->Export <> "" || $this->DrillDown || $grDashboardReport) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
			$this->GenerateOptions->HideAllOptions();
		}

		// Get current page records
		$rs = $this->GetRs($sSql, $this->StartGrp, $this->DisplayGrps);
		$this->SetupFieldCount();
	}

	// Accummulate summary
	function AccumulateSummary() {
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				if ($this->Col[$iy][0]) { // Accumulate required
					$valwrk = $this->Val[$iy];
					if (is_null($valwrk)) {
						if (!$this->Col[$iy][1])
							$this->Cnt[$ix][$iy]++;
					} else {
						$accum = (!$this->Col[$iy][1] || !is_numeric($valwrk) || $valwrk <> 0);
						if ($accum) {
							$this->Cnt[$ix][$iy]++;
							if (is_numeric($valwrk)) {
								$this->Smry[$ix][$iy] += $valwrk;
								if (is_null($this->Mn[$ix][$iy])) {
									$this->Mn[$ix][$iy] = $valwrk;
									$this->Mx[$ix][$iy] = $valwrk;
								} else {
									if ($this->Mn[$ix][$iy] > $valwrk) $this->Mn[$ix][$iy] = $valwrk;
									if ($this->Mx[$ix][$iy] < $valwrk) $this->Mx[$ix][$iy] = $valwrk;
								}
							}
						}
					}
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0]++;
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy] = 0;
				if ($this->Col[$iy][0]) {
					$this->Smry[$ix][$iy] = 0;
					$this->Mn[$ix][$iy] = NULL;
					$this->Mx[$ix][$iy] = NULL;
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0] = 0;
		}

		// Reset record count
		$this->RecCount = 0;
	}

	// Accummulate grand summary
	function AccumulateGrandSummary() {
		$this->TotCount++;
		$cntgs = count($this->GrandSmry);
		for ($iy = 1; $iy < $cntgs; $iy++) {
			if ($this->Col[$iy][0]) {
				$valwrk = $this->Val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {
					if (!$this->Col[$iy][1])
						$this->GrandCnt[$iy]++;
				} else {
					if (!$this->Col[$iy][1] || $valwrk <> 0) {
						$this->GrandCnt[$iy]++;
						$this->GrandSmry[$iy] += $valwrk;
						if (is_null($this->GrandMn[$iy])) {
							$this->GrandMn[$iy] = $valwrk;
							$this->GrandMx[$iy] = $valwrk;
						} else {
							if ($this->GrandMn[$iy] > $valwrk) $this->GrandMn[$iy] = $valwrk;
							if ($this->GrandMx[$iy] < $valwrk) $this->GrandMx[$iy] = $valwrk;
						}
					}
				}
			}
		}
	}

	// Get count
	function GetCnt($sql) {
		$conn = &$this->Connection();
		$rscnt = $conn->Execute($sql);
		$cnt = ($rscnt) ? $rscnt->RecordCount() : 0;
		if ($rscnt) $rscnt->Close();
		return $cnt;
	}

	// Get recordset
	function GetRs($wrksql, $start, $grps) {
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EWR_ERROR_FN"];
		$rswrk = $conn->SelectLimit($wrksql, $grps, $start - 1);
		$conn->raiseErrorFn = '';
		return $rswrk;
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row
				$this->FirstRowData = array();
				$this->FirstRowData['id'] = ewr_Conv($rs->fields('id'), 3);
				$this->FirstRowData['Departemen'] = ewr_Conv($rs->fields('Departemen'), 200);
				$this->FirstRowData['HeadDetail'] = ewr_Conv($rs->fields('HeadDetail'), 200);
				$this->FirstRowData['NomorHead'] = ewr_Conv($rs->fields('NomorHead'), 16);
				$this->FirstRowData['SubTotalFlag'] = ewr_Conv($rs->fields('SubTotalFlag'), 200);
				$this->FirstRowData['Urutan'] = ewr_Conv($rs->fields('Urutan'), 16);
				$this->FirstRowData['Nomor'] = ewr_Conv($rs->fields('Nomor'), 200);
				$this->FirstRowData['Pos'] = ewr_Conv($rs->fields('Pos'), 200);
				$this->FirstRowData['Nominal'] = ewr_Conv($rs->fields('Nominal'), 4);
				$this->FirstRowData['JumlahSiswa'] = ewr_Conv($rs->fields('JumlahSiswa'), 2);
				$this->FirstRowData['Bulan'] = ewr_Conv($rs->fields('Bulan'), 16);
				$this->FirstRowData['Jumlah'] = ewr_Conv($rs->fields('Jumlah'), 4);
				$this->FirstRowData['Total'] = ewr_Conv($rs->fields('Total'), 4);
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$this->id->setDbValue($rs->fields('id'));
			$this->Departemen->setDbValue($rs->fields('Departemen'));
			$this->HeadDetail->setDbValue($rs->fields('HeadDetail'));
			$this->NomorHead->setDbValue($rs->fields('NomorHead'));
			$this->SubTotalFlag->setDbValue($rs->fields('SubTotalFlag'));
			$this->Urutan->setDbValue($rs->fields('Urutan'));
			$this->Nomor->setDbValue($rs->fields('Nomor'));
			$this->Pos->setDbValue($rs->fields('Pos'));
			$this->Nominal->setDbValue($rs->fields('Nominal'));
			$this->JumlahSiswa->setDbValue($rs->fields('JumlahSiswa'));
			$this->Bulan->setDbValue($rs->fields('Bulan'));
			$this->Jumlah->setDbValue($rs->fields('Jumlah'));
			$this->Total->setDbValue($rs->fields('Total'));
			$this->Val[1] = $this->id->CurrentValue;
			$this->Val[2] = $this->Departemen->CurrentValue;
			$this->Val[3] = $this->HeadDetail->CurrentValue;
			$this->Val[4] = $this->NomorHead->CurrentValue;
			$this->Val[5] = $this->SubTotalFlag->CurrentValue;
			$this->Val[6] = $this->Urutan->CurrentValue;
			$this->Val[7] = $this->Nomor->CurrentValue;
			$this->Val[8] = $this->Pos->CurrentValue;
			$this->Val[9] = $this->Nominal->CurrentValue;
			$this->Val[10] = $this->JumlahSiswa->CurrentValue;
			$this->Val[11] = $this->Bulan->CurrentValue;
			$this->Val[12] = $this->Jumlah->CurrentValue;
			$this->Val[13] = $this->Total->CurrentValue;
		} else {
			$this->id->setDbValue("");
			$this->Departemen->setDbValue("");
			$this->HeadDetail->setDbValue("");
			$this->NomorHead->setDbValue("");
			$this->SubTotalFlag->setDbValue("");
			$this->Urutan->setDbValue("");
			$this->Nomor->setDbValue("");
			$this->Pos->setDbValue("");
			$this->Nominal->setDbValue("");
			$this->JumlahSiswa->setDbValue("");
			$this->Bulan->setDbValue("");
			$this->Jumlah->setDbValue("");
			$this->Total->setDbValue("");
		}
	}

	// Set up starting group
	function SetUpStartGroup($options = array()) {

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;
		$startGrp = (@$options["start"] <> "") ? $options["start"] : @$_GET[EWR_TABLE_START_GROUP];
		$pageNo = (@$options["pageno"] <> "") ? $options["pageno"] : @$_GET["pageno"];

		// Check for a 'start' parameter
		if ($startGrp != "") {
			$this->StartGrp = $startGrp;
			$this->setStartGroup($this->StartGrp);
		} elseif ($pageNo != "") {
			$nPageNo = $pageNo;
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$this->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $this->getStartGroup();
			}
		} else {
			$this->StartGrp = $this->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$this->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$this->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$this->setStartGroup($this->StartGrp);
		}
	}

	// Load group db values if necessary
	function LoadGroupDbValues() {
		$conn = &$this->Connection();
	}

	// Process Ajax popup
	function ProcessAjaxPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		$fld = NULL;
		if (@$_GET["popup"] <> "") {
			$popupname = $_GET["popup"];

			// Check popup name
			// Output data as Json

			if (!is_null($fld)) {
				$jsdb = ewr_GetJsDb($fld, $fld->FldType);
				if (ob_get_length())
					ob_end_clean();
				echo $jsdb;
				exit();
			}
		}
	}

	// Set up popup
	function SetupPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		if ($this->DrillDown)
			return;

		// Process post back form
		if (ewr_IsHttpPost()) {
			$sName = @$_POST["popup"]; // Get popup form name
			if ($sName <> "") {
				$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
				if ($cntValues > 0) {
					$arValues = $_POST["sel_$sName"];
					if (trim($arValues[0]) == "") // Select all
						$arValues = EWR_INIT_VALUE;
					$this->PopupName = $sName;
					if (ewr_IsAdvancedFilterValue($arValues) || $arValues == EWR_INIT_VALUE)
						$this->PopupValue = $arValues;
					if (!ewr_MatchedArray($arValues, $_SESSION["sel_$sName"])) {
						if ($this->HasSessionFilterValues($sName))
							$this->ClearExtFilter = $sName; // Clear extended filter for this field
					}
					$_SESSION["sel_$sName"] = $arValues;
					$_SESSION["rf_$sName"] = @$_POST["rf_$sName"];
					$_SESSION["rt_$sName"] = @$_POST["rt_$sName"];
					$this->ResetPager();
				}
			}

		// Get 'reset' command
		} elseif (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];
			if (strtolower($sCmd) == "reset") {
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		$this->StartGrp = 1;
		$this->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		$sWrk = @$_GET[EWR_TABLE_GROUP_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayGrps = intval($sWrk);
			} else {
				if (strtoupper($sWrk) == "ALL") { // Display all groups
					$this->DisplayGrps = -1;
				} else {
					$this->DisplayGrps = 3; // Non-numeric, load default
				}
			}
			$this->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$this->setStartGroup($this->StartGrp);
		} else {
			if ($this->getGroupPerPage() <> "") {
				$this->DisplayGrps = $this->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 3; // Load default
			}
		}
	}

	// Render row
	function RenderRow() {
		global $rs, $Security, $ReportLanguage;
		$conn = &$this->Connection();
		if (!$this->GrandSummarySetup) { // Get Grand total
			$bGotCount = FALSE;
			$bGotSummary = FALSE;

			// Get total count from sql directly
			$sSql = ewr_BuildReportSql($this->getSqlSelectCount(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
				$bGotCount = TRUE;
			} else {
				$this->TotCount = 0;
			}
		$bGotSummary = TRUE;

			// Accumulate grand summary from detail records
			if (!$bGotCount || !$bGotSummary) {
				$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
				$rs = $conn->Execute($sSql);
				if ($rs) {
					$this->GetRow(1);
					while (!$rs->EOF) {
						$this->AccumulateGrandSummary();
						$this->GetRow(2);
					}
					$rs->Close();
				}
			}
			$this->GrandSummarySetup = TRUE; // No need to set up again
		}

		// Call Row_Rendering event
		$this->Row_Rendering();

		//
		// Render view codes
		//

		if ($this->RowType == EWR_ROWTYPE_TOTAL && !($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER)) { // Summary row
			ewr_PrependClass($this->RowAttrs["class"], ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : ""); // Set up row class

			// id
			$this->id->HrefValue = "";

			// Departemen
			$this->Departemen->HrefValue = "";

			// HeadDetail
			$this->HeadDetail->HrefValue = "";

			// NomorHead
			$this->NomorHead->HrefValue = "";

			// SubTotalFlag
			$this->SubTotalFlag->HrefValue = "";

			// Urutan
			$this->Urutan->HrefValue = "";

			// Nomor
			$this->Nomor->HrefValue = "";

			// Pos
			$this->Pos->HrefValue = "";

			// Nominal
			$this->Nominal->HrefValue = "";

			// JumlahSiswa
			$this->JumlahSiswa->HrefValue = "";

			// Bulan
			$this->Bulan->HrefValue = "";

			// Jumlah
			$this->Jumlah->HrefValue = "";

			// Total
			$this->Total->HrefValue = "";
		} else {
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER) {
			} else {
			}

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Departemen
			$this->Departemen->ViewValue = $this->Departemen->CurrentValue;
			$this->Departemen->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// HeadDetail
			$this->HeadDetail->ViewValue = $this->HeadDetail->CurrentValue;
			$this->HeadDetail->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// NomorHead
			$this->NomorHead->ViewValue = $this->NomorHead->CurrentValue;
			$this->NomorHead->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// SubTotalFlag
			$this->SubTotalFlag->ViewValue = $this->SubTotalFlag->CurrentValue;
			$this->SubTotalFlag->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Urutan
			$this->Urutan->ViewValue = $this->Urutan->CurrentValue;
			$this->Urutan->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Nomor
			$this->Nomor->ViewValue = $this->Nomor->CurrentValue;
			$this->Nomor->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Pos
			$this->Pos->ViewValue = $this->Pos->CurrentValue;
			$this->Pos->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Nominal
			$this->Nominal->ViewValue = $this->Nominal->CurrentValue;
			$this->Nominal->ViewValue = ewr_FormatNumber($this->Nominal->ViewValue, $this->Nominal->DefaultDecimalPrecision, -1, 0, 0);
			$this->Nominal->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// JumlahSiswa
			$this->JumlahSiswa->ViewValue = $this->JumlahSiswa->CurrentValue;
			$this->JumlahSiswa->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Bulan
			$this->Bulan->ViewValue = $this->Bulan->CurrentValue;
			$this->Bulan->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Jumlah
			$this->Jumlah->ViewValue = $this->Jumlah->CurrentValue;
			$this->Jumlah->ViewValue = ewr_FormatNumber($this->Jumlah->ViewValue, $this->Jumlah->DefaultDecimalPrecision, -1, 0, 0);
			$this->Jumlah->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Total
			$this->Total->ViewValue = $this->Total->CurrentValue;
			$this->Total->ViewValue = ewr_FormatNumber($this->Total->ViewValue, $this->Total->DefaultDecimalPrecision, -1, 0, 0);
			$this->Total->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// id
			$this->id->HrefValue = "";

			// Departemen
			$this->Departemen->HrefValue = "";

			// HeadDetail
			$this->HeadDetail->HrefValue = "";

			// NomorHead
			$this->NomorHead->HrefValue = "";

			// SubTotalFlag
			$this->SubTotalFlag->HrefValue = "";

			// Urutan
			$this->Urutan->HrefValue = "";

			// Nomor
			$this->Nomor->HrefValue = "";

			// Pos
			$this->Pos->HrefValue = "";

			// Nominal
			$this->Nominal->HrefValue = "";

			// JumlahSiswa
			$this->JumlahSiswa->HrefValue = "";

			// Bulan
			$this->Bulan->HrefValue = "";

			// Jumlah
			$this->Jumlah->HrefValue = "";

			// Total
			$this->Total->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row
		} else {

			// id
			$CurrentValue = $this->id->CurrentValue;
			$ViewValue = &$this->id->ViewValue;
			$ViewAttrs = &$this->id->ViewAttrs;
			$CellAttrs = &$this->id->CellAttrs;
			$HrefValue = &$this->id->HrefValue;
			$LinkAttrs = &$this->id->LinkAttrs;
			$this->Cell_Rendered($this->id, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Departemen
			$CurrentValue = $this->Departemen->CurrentValue;
			$ViewValue = &$this->Departemen->ViewValue;
			$ViewAttrs = &$this->Departemen->ViewAttrs;
			$CellAttrs = &$this->Departemen->CellAttrs;
			$HrefValue = &$this->Departemen->HrefValue;
			$LinkAttrs = &$this->Departemen->LinkAttrs;
			$this->Cell_Rendered($this->Departemen, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// HeadDetail
			$CurrentValue = $this->HeadDetail->CurrentValue;
			$ViewValue = &$this->HeadDetail->ViewValue;
			$ViewAttrs = &$this->HeadDetail->ViewAttrs;
			$CellAttrs = &$this->HeadDetail->CellAttrs;
			$HrefValue = &$this->HeadDetail->HrefValue;
			$LinkAttrs = &$this->HeadDetail->LinkAttrs;
			$this->Cell_Rendered($this->HeadDetail, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// NomorHead
			$CurrentValue = $this->NomorHead->CurrentValue;
			$ViewValue = &$this->NomorHead->ViewValue;
			$ViewAttrs = &$this->NomorHead->ViewAttrs;
			$CellAttrs = &$this->NomorHead->CellAttrs;
			$HrefValue = &$this->NomorHead->HrefValue;
			$LinkAttrs = &$this->NomorHead->LinkAttrs;
			$this->Cell_Rendered($this->NomorHead, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// SubTotalFlag
			$CurrentValue = $this->SubTotalFlag->CurrentValue;
			$ViewValue = &$this->SubTotalFlag->ViewValue;
			$ViewAttrs = &$this->SubTotalFlag->ViewAttrs;
			$CellAttrs = &$this->SubTotalFlag->CellAttrs;
			$HrefValue = &$this->SubTotalFlag->HrefValue;
			$LinkAttrs = &$this->SubTotalFlag->LinkAttrs;
			$this->Cell_Rendered($this->SubTotalFlag, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Urutan
			$CurrentValue = $this->Urutan->CurrentValue;
			$ViewValue = &$this->Urutan->ViewValue;
			$ViewAttrs = &$this->Urutan->ViewAttrs;
			$CellAttrs = &$this->Urutan->CellAttrs;
			$HrefValue = &$this->Urutan->HrefValue;
			$LinkAttrs = &$this->Urutan->LinkAttrs;
			$this->Cell_Rendered($this->Urutan, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Nomor
			$CurrentValue = $this->Nomor->CurrentValue;
			$ViewValue = &$this->Nomor->ViewValue;
			$ViewAttrs = &$this->Nomor->ViewAttrs;
			$CellAttrs = &$this->Nomor->CellAttrs;
			$HrefValue = &$this->Nomor->HrefValue;
			$LinkAttrs = &$this->Nomor->LinkAttrs;
			$this->Cell_Rendered($this->Nomor, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Pos
			$CurrentValue = $this->Pos->CurrentValue;
			$ViewValue = &$this->Pos->ViewValue;
			$ViewAttrs = &$this->Pos->ViewAttrs;
			$CellAttrs = &$this->Pos->CellAttrs;
			$HrefValue = &$this->Pos->HrefValue;
			$LinkAttrs = &$this->Pos->LinkAttrs;
			$this->Cell_Rendered($this->Pos, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Nominal
			$CurrentValue = $this->Nominal->CurrentValue;
			$ViewValue = &$this->Nominal->ViewValue;
			$ViewAttrs = &$this->Nominal->ViewAttrs;
			$CellAttrs = &$this->Nominal->CellAttrs;
			$HrefValue = &$this->Nominal->HrefValue;
			$LinkAttrs = &$this->Nominal->LinkAttrs;
			$this->Cell_Rendered($this->Nominal, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// JumlahSiswa
			$CurrentValue = $this->JumlahSiswa->CurrentValue;
			$ViewValue = &$this->JumlahSiswa->ViewValue;
			$ViewAttrs = &$this->JumlahSiswa->ViewAttrs;
			$CellAttrs = &$this->JumlahSiswa->CellAttrs;
			$HrefValue = &$this->JumlahSiswa->HrefValue;
			$LinkAttrs = &$this->JumlahSiswa->LinkAttrs;
			$this->Cell_Rendered($this->JumlahSiswa, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Bulan
			$CurrentValue = $this->Bulan->CurrentValue;
			$ViewValue = &$this->Bulan->ViewValue;
			$ViewAttrs = &$this->Bulan->ViewAttrs;
			$CellAttrs = &$this->Bulan->CellAttrs;
			$HrefValue = &$this->Bulan->HrefValue;
			$LinkAttrs = &$this->Bulan->LinkAttrs;
			$this->Cell_Rendered($this->Bulan, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Jumlah
			$CurrentValue = $this->Jumlah->CurrentValue;
			$ViewValue = &$this->Jumlah->ViewValue;
			$ViewAttrs = &$this->Jumlah->ViewAttrs;
			$CellAttrs = &$this->Jumlah->CellAttrs;
			$HrefValue = &$this->Jumlah->HrefValue;
			$LinkAttrs = &$this->Jumlah->LinkAttrs;
			$this->Cell_Rendered($this->Jumlah, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Total
			$CurrentValue = $this->Total->CurrentValue;
			$ViewValue = &$this->Total->ViewValue;
			$ViewAttrs = &$this->Total->ViewAttrs;
			$CellAttrs = &$this->Total->CellAttrs;
			$HrefValue = &$this->Total->HrefValue;
			$LinkAttrs = &$this->Total->LinkAttrs;
			$this->Cell_Rendered($this->Total, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		}

		// Call Row_Rendered event
		$this->Row_Rendered();
		$this->SetupFieldCount();
	}

	// Setup field count
	function SetupFieldCount() {
		$this->GrpColumnCount = 0;
		$this->SubGrpColumnCount = 0;
		$this->DtlColumnCount = 0;
		if ($this->id->Visible) $this->DtlColumnCount += 1;
		if ($this->Departemen->Visible) $this->DtlColumnCount += 1;
		if ($this->HeadDetail->Visible) $this->DtlColumnCount += 1;
		if ($this->NomorHead->Visible) $this->DtlColumnCount += 1;
		if ($this->SubTotalFlag->Visible) $this->DtlColumnCount += 1;
		if ($this->Urutan->Visible) $this->DtlColumnCount += 1;
		if ($this->Nomor->Visible) $this->DtlColumnCount += 1;
		if ($this->Pos->Visible) $this->DtlColumnCount += 1;
		if ($this->Nominal->Visible) $this->DtlColumnCount += 1;
		if ($this->JumlahSiswa->Visible) $this->DtlColumnCount += 1;
		if ($this->Bulan->Visible) $this->DtlColumnCount += 1;
		if ($this->Jumlah->Visible) $this->DtlColumnCount += 1;
		if ($this->Total->Visible) $this->DtlColumnCount += 1;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = substr(ewr_CurrentUrl(), strrpos(ewr_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("summary", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $ReportOptions;
		$ReportTypes = $ReportOptions["ReportTypes"];
		$ReportOptions["ReportTypes"] = $ReportTypes;
	}

	// Return extended filter
	function GetExtendedFilter() {
		global $grFormError;
		$sFilter = "";
		if ($this->DrillDown)
			return "";
		$bPostBack = ewr_IsHttpPost();
		$bRestoreSession = TRUE;
		$bSetupFilter = FALSE;

		// Reset extended filter if filter changed
		if ($bPostBack) {

		// Reset search command
		} elseif (@$_GET["cmd"] == "reset") {

			// Load default values
			$this->SetSessionDropDownValue($this->Departemen->DropDownValue, $this->Departemen->SearchOperator, 'Departemen'); // Field Departemen

			//$bSetupFilter = TRUE; // No need to set up, just use default
		} else {
			$bRestoreSession = !$this->SearchCommand;

			// Field Departemen
			if ($this->GetDropDownValue($this->Departemen)) {
				$bSetupFilter = TRUE;
			} elseif ($this->Departemen->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_r01_penerimaan_Departemen'])) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setFailureMessage($grFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {
			$this->GetSessionDropDownValue($this->Departemen); // Field Departemen
		}

		// Call page filter validated event
		$this->Page_FilterValidated();

		// Build SQL
		$this->BuildDropDownFilter($this->Departemen, $sFilter, $this->Departemen->SearchOperator, FALSE, TRUE); // Field Departemen

		// Save parms to session
		$this->SetSessionDropDownValue($this->Departemen->DropDownValue, $this->Departemen->SearchOperator, 'Departemen'); // Field Departemen

		// Setup filter
		if ($bSetupFilter) {
		}

		// Field Departemen
		ewr_LoadDropDownList($this->Departemen->DropDownList, $this->Departemen->DropDownValue);
		return $sFilter;
	}

	// Build dropdown filter
	function BuildDropDownFilter(&$fld, &$FilterClause, $FldOpr, $Default = FALSE, $SaveFilter = FALSE) {
		$FldVal = ($Default) ? $fld->DefaultDropDownValue : $fld->DropDownValue;
		$sSql = "";
		if (is_array($FldVal)) {
			foreach ($FldVal as $val) {
				$sWrk = $this->GetDropDownFilter($fld, $val, $FldOpr);

				// Call Page Filtering event
				if (substr($val, 0, 2) <> "@@")
					$this->Page_Filtering($fld, $sWrk, "dropdown", $FldOpr, $val);
				if ($sWrk <> "") {
					if ($sSql <> "")
						$sSql .= " OR " . $sWrk;
					else
						$sSql = $sWrk;
				}
			}
		} else {
			$sSql = $this->GetDropDownFilter($fld, $FldVal, $FldOpr);

			// Call Page Filtering event
			if (substr($FldVal, 0, 2) <> "@@")
				$this->Page_Filtering($fld, $sSql, "dropdown", $FldOpr, $FldVal);
		}
		if ($sSql <> "") {
			ewr_AddFilter($FilterClause, $sSql);
			if ($SaveFilter) $fld->CurrentFilter = $sSql;
		}
	}

	function GetDropDownFilter(&$fld, $FldVal, $FldOpr) {
		$FldName = $fld->FldName;
		$FldExpression = $fld->FldExpression;
		$FldDataType = $fld->FldDataType;
		$FldDelimiter = $fld->FldDelimiter;
		$FldVal = strval($FldVal);
		if ($FldOpr == "") $FldOpr = "=";
		$sWrk = "";
		if (ewr_SameStr($FldVal, EWR_NULL_VALUE)) {
			$sWrk = $FldExpression . " IS NULL";
		} elseif (ewr_SameStr($FldVal, EWR_NOT_NULL_VALUE)) {
			$sWrk = $FldExpression . " IS NOT NULL";
		} elseif (ewr_SameStr($FldVal, EWR_EMPTY_VALUE)) {
			$sWrk = $FldExpression . " = ''";
		} elseif (ewr_SameStr($FldVal, EWR_ALL_VALUE)) {
			$sWrk = "1 = 1";
		} else {
			if (substr($FldVal, 0, 2) == "@@") {
				$sWrk = $this->GetCustomFilter($fld, $FldVal, $this->DBID);
			} elseif ($FldDelimiter <> "" && trim($FldVal) <> "" && ($FldDataType == EWR_DATATYPE_STRING || $FldDataType == EWR_DATATYPE_MEMO)) {
				$sWrk = ewr_GetMultiSearchSql($FldExpression, trim($FldVal), $this->DBID);
			} else {
				if ($FldVal <> "" && $FldVal <> EWR_INIT_VALUE) {
					if ($FldDataType == EWR_DATATYPE_DATE && $FldOpr <> "") {
						$sWrk = ewr_DateFilterString($FldExpression, $FldOpr, $FldVal, $FldDataType, $this->DBID);
					} else {
						$sWrk = ewr_FilterString($FldOpr, $FldVal, $FldDataType, $this->DBID);
						if ($sWrk <> "") $sWrk = $FldExpression . $sWrk;
					}
				}
			}
		}
		return $sWrk;
	}

	// Get custom filter
	function GetCustomFilter(&$fld, $FldVal, $dbid = 0) {
		$sWrk = "";
		if (is_array($fld->AdvancedFilters)) {
			foreach ($fld->AdvancedFilters as $filter) {
				if ($filter->ID == $FldVal && $filter->Enabled) {
					$sFld = $fld->FldExpression;
					$sFn = $filter->FunctionName;
					$wrkid = (substr($filter->ID, 0, 2) == "@@") ? substr($filter->ID,2) : $filter->ID;
					if ($sFn <> "")
						$sWrk = $sFn($sFld, $dbid);
					else
						$sWrk = "";
					$this->Page_Filtering($fld, $sWrk, "custom", $wrkid);
					break;
				}
			}
		}
		return $sWrk;
	}

	// Build extended filter
	function BuildExtendedFilter(&$fld, &$FilterClause, $Default = FALSE, $SaveFilter = FALSE) {
		$sWrk = ewr_GetExtendedFilter($fld, $Default, $this->DBID);
		if (!$Default)
			$this->Page_Filtering($fld, $sWrk, "extended", $fld->SearchOperator, $fld->SearchValue, $fld->SearchCondition, $fld->SearchOperator2, $fld->SearchValue2);
		if ($sWrk <> "") {
			ewr_AddFilter($FilterClause, $sWrk);
			if ($SaveFilter) $fld->CurrentFilter = $sWrk;
		}
	}

	// Get drop down value from querystring
	function GetDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewr_IsHttpPost())
			return FALSE; // Skip post back
		if (isset($_GET["so_$parm"]))
			$fld->SearchOperator = @$_GET["so_$parm"];
		if (isset($_GET["sv_$parm"])) {
			$fld->DropDownValue = @$_GET["sv_$parm"];
			return TRUE;
		}
		return FALSE;
	}

	// Get filter values from querystring
	function GetFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewr_IsHttpPost())
			return; // Skip post back
		$got = FALSE;
		if (isset($_GET["sv_$parm"])) {
			$fld->SearchValue = @$_GET["sv_$parm"];
			$got = TRUE;
		}
		if (isset($_GET["so_$parm"])) {
			$fld->SearchOperator = @$_GET["so_$parm"];
			$got = TRUE;
		}
		if (isset($_GET["sc_$parm"])) {
			$fld->SearchCondition = @$_GET["sc_$parm"];
			$got = TRUE;
		}
		if (isset($_GET["sv2_$parm"])) {
			$fld->SearchValue2 = @$_GET["sv2_$parm"];
			$got = TRUE;
		}
		if (isset($_GET["so2_$parm"])) {
			$fld->SearchOperator2 = $_GET["so2_$parm"];
			$got = TRUE;
		}
		return $got;
	}

	// Set default ext filter
	function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2) {
		$fld->DefaultSearchValue = $sv1; // Default ext filter value 1
		$fld->DefaultSearchValue2 = $sv2; // Default ext filter value 2 (if operator 2 is enabled)
		$fld->DefaultSearchOperator = $so1; // Default search operator 1
		$fld->DefaultSearchOperator2 = $so2; // Default search operator 2 (if operator 2 is enabled)
		$fld->DefaultSearchCondition = $sc; // Default search condition (if operator 2 is enabled)
	}

	// Apply default ext filter
	function ApplyDefaultExtFilter(&$fld) {
		$fld->SearchValue = $fld->DefaultSearchValue;
		$fld->SearchValue2 = $fld->DefaultSearchValue2;
		$fld->SearchOperator = $fld->DefaultSearchOperator;
		$fld->SearchOperator2 = $fld->DefaultSearchOperator2;
		$fld->SearchCondition = $fld->DefaultSearchCondition;
	}

	// Check if Text Filter applied
	function TextFilterApplied(&$fld) {
		return (strval($fld->SearchValue) <> strval($fld->DefaultSearchValue) ||
			strval($fld->SearchValue2) <> strval($fld->DefaultSearchValue2) ||
			(strval($fld->SearchValue) <> "" &&
				strval($fld->SearchOperator) <> strval($fld->DefaultSearchOperator)) ||
			(strval($fld->SearchValue2) <> "" &&
				strval($fld->SearchOperator2) <> strval($fld->DefaultSearchOperator2)) ||
			strval($fld->SearchCondition) <> strval($fld->DefaultSearchCondition));
	}

	// Check if Non-Text Filter applied
	function NonTextFilterApplied(&$fld) {
		if (is_array($fld->DropDownValue)) {
			if (is_array($fld->DefaultDropDownValue)) {
				if (count($fld->DefaultDropDownValue) <> count($fld->DropDownValue))
					return TRUE;
				else
					return (count(array_diff($fld->DefaultDropDownValue, $fld->DropDownValue)) <> 0);
			} else {
				return TRUE;
			}
		} else {
			if (is_array($fld->DefaultDropDownValue))
				return TRUE;
			else
				$v1 = strval($fld->DefaultDropDownValue);
			if ($v1 == EWR_INIT_VALUE)
				$v1 = "";
			$v2 = strval($fld->DropDownValue);
			if ($v2 == EWR_INIT_VALUE || $v2 == EWR_ALL_VALUE)
				$v2 = "";
			return ($v1 <> $v2);
		}
	}

	// Get dropdown value from session
	function GetSessionDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->DropDownValue, 'sv_r01_penerimaan_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_r01_penerimaan_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv_r01_penerimaan_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_r01_penerimaan_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_r01_penerimaan_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_r01_penerimaan_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_r01_penerimaan_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (array_key_exists($sn, $_SESSION))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $so, $parm) {
		$_SESSION['sv_r01_penerimaan_' . $parm] = $sv;
		$_SESSION['so_r01_penerimaan_' . $parm] = $so;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv_r01_penerimaan_' . $parm] = $sv1;
		$_SESSION['so_r01_penerimaan_' . $parm] = $so1;
		$_SESSION['sc_r01_penerimaan_' . $parm] = $sc;
		$_SESSION['sv2_r01_penerimaan_' . $parm] = $sv2;
		$_SESSION['so2_r01_penerimaan_' . $parm] = $so2;
	}

	// Check if has Session filter values
	function HasSessionFilterValues($parm) {
		return ((@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWR_INIT_VALUE) ||
			(@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWR_INIT_VALUE) ||
			(@$_SESSION['sv2_' . $parm] <> "" && @$_SESSION['sv2_' . $parm] <> EWR_INIT_VALUE));
	}

	// Dropdown filter exist
	function DropDownFilterExist(&$fld, $FldOpr) {
		$sWrk = "";
		$this->BuildDropDownFilter($fld, $sWrk, $FldOpr);
		return ($sWrk <> "");
	}

	// Extended filter exist
	function ExtendedFilterExist(&$fld) {
		$sExtWrk = "";
		$this->BuildExtendedFilter($fld, $sExtWrk);
		return ($sExtWrk <> "");
	}

	// Validate form
	function ValidateForm() {
		global $ReportLanguage, $grFormError;

		// Initialize form error message
		$grFormError = "";

		// Check if validation required
		if (!EWR_SERVER_VALIDATE)
			return ($grFormError == "");

		// Return validate result
		$ValidateForm = ($grFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$grFormError .= ($grFormError <> "") ? "<p>&nbsp;</p>" : "";
			$grFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Clear selection stored in session
	function ClearSessionSelection($parm) {
		$_SESSION["sel_r01_penerimaan_$parm"] = "";
		$_SESSION["rf_r01_penerimaan_$parm"] = "";
		$_SESSION["rt_r01_penerimaan_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		$fld = &$this->FieldByParm($parm);
		$fld->SelectionList = @$_SESSION["sel_r01_penerimaan_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_r01_penerimaan_$parm"];
		$fld->RangeTo = @$_SESSION["rt_r01_penerimaan_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		/**
		* Set up default values for non Text filters
		*/

		// Field Departemen
		$this->Departemen->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->Departemen->DropDownValue = $this->Departemen->DefaultDropDownValue;
		/**
		* Set up default values for extended filters
		* function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2)
		* Parameters:
		* $fld - Field object
		* $so1 - Default search operator 1
		* $sv1 - Default ext filter value 1
		* $sc - Default search condition (if operator 2 is enabled)
		* $so2 - Default search operator 2 (if operator 2 is enabled)
		* $sv2 - Default ext filter value 2 (if operator 2 is enabled)
		*/
		/**
		* Set up default values for popup filters
		*/
	}

	// Check if filter applied
	function CheckFilter() {

		// Check Departemen extended filter
		if ($this->NonTextFilterApplied($this->Departemen))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList($showDate = FALSE) {
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field Departemen
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($this->Departemen, $sExtWrk, $this->Departemen->SearchOperator);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->Departemen->FldCaption() . "</span>" . $sFilter . "</div>";
		$divstyle = "";
		$divdataclass = "";

		// Show Filters
		if ($sFilterList <> "" || $showDate) {
			$sMessage = "<div" . $divstyle . $divdataclass . "><div id=\"ewrFilterList\" class=\"alert alert-info\">";
			if ($showDate)
				$sMessage .= "<div id=\"ewrCurrentDate\">" . $ReportLanguage->Phrase("ReportGeneratedDate") . ewr_FormatDateTime(date("Y-m-d H:i:s"), 1) . "</div>";
			if ($sFilterList <> "")
				$sMessage .= "<div id=\"ewrCurrentFilters\">" . $ReportLanguage->Phrase("CurrentFilters") . "</div>" . $sFilterList;
			$sMessage .= "</div></div>";
			$this->Message_Showing($sMessage, "");
			echo $sMessage;
		}
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";

		// Field Departemen
		$sWrk = "";
		$sWrk = ($this->Departemen->DropDownValue <> EWR_INIT_VALUE) ? $this->Departemen->DropDownValue : "";
		if (is_array($sWrk))
			$sWrk = implode("||", $sWrk);
		if ($sWrk <> "")
			$sWrk = "\"sv_Departemen\":\"" . ewr_JsEncode2($sWrk) . "\"";
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Return filter list in json
		if ($sFilterList <> "")
			return "{" . $sFilterList . "}";
		else
			return "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		return $this->SetupFilterList($filter);
	}

	// Setup list of filters
	function SetupFilterList($filter) {
		if (!is_array($filter))
			return FALSE;

		// Field Departemen
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_Departemen", $filter)) {
			$sWrk = $filter["sv_Departemen"];
			if (strpos($sWrk, "||") !== FALSE)
				$sWrk = explode("||", $sWrk);
			$this->SetSessionDropDownValue($sWrk, @$filter["so_Departemen"], "Departemen");
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "Departemen");
		}
		return TRUE;
	}

	// Return popup filter
	function GetPopupFilter() {
		$sWrk = "";
		if ($this->DrillDown)
			return "";
		return $sWrk;
	}

	// Get sort parameters based on sort links clicked
	function GetSort($options = array()) {
		if ($this->DrillDown)
			return "";
		$bResetSort = @$options["resetsort"] == "1" || @$_GET["cmd"] == "resetsort";
		$orderBy = (@$options["order"] <> "") ? @$options["order"] : @$_GET["order"];
		$orderType = (@$options["ordertype"] <> "") ? @$options["ordertype"] : @$_GET["ordertype"];

		// Check for a resetsort command
		if ($bResetSort) {
			$this->setOrderBy("");
			$this->setStartGroup(1);
			$this->id->setSort("");
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

		// Check for an Order parameter
		} elseif ($orderBy <> "") {
			$this->CurrentOrder = $orderBy;
			$this->CurrentOrderType = $orderType;
			$sSortSql = $this->SortSql();
			$this->setOrderBy($sSortSql);
			$this->setStartGroup(1);
		}
		return $this->getOrderBy();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
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
<?php

// Create page object
if (!isset($r01_penerimaan_summary)) $r01_penerimaan_summary = new crr01_penerimaan_summary();
if (isset($Page)) $OldPage = $Page;
$Page = &$r01_penerimaan_summary;

// Page init
$Page->Page_Init();

// Page main
$Page->Page_Main();
if (!$grDashboardReport)
	ewr_Header(FALSE);

// Global Page Rendering event (in ewrusrfn*.php)
Page_Rendering();

// Page Rendering event
$Page->Page_Render();
?>
<?php if (!$grDashboardReport) { ?>
<?php include_once "header.php" ?>
<?php include_once "phprptinc/header.php" ?>
<?php } ?>
<script type="text/javascript">

// Create page object
var r01_penerimaan_summary = new ewr_Page("r01_penerimaan_summary");

// Page properties
r01_penerimaan_summary.PageID = "summary"; // Page ID
var EWR_PAGE_ID = r01_penerimaan_summary.PageID;
</script>
<?php if (!$Page->DrillDown && !$grDashboardReport) { ?>
<script type="text/javascript">

// Form object
var CurrentForm = fr01_penerimaansummary = new ewr_Form("fr01_penerimaansummary");

// Validate method
fr01_penerimaansummary.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
fr01_penerimaansummary.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }
<?php if (EWR_CLIENT_VALIDATE) { ?>
fr01_penerimaansummary.ValidateRequired = true; // Uses JavaScript validation
<?php } else { ?>
fr01_penerimaansummary.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Use Ajax
fr01_penerimaansummary.Lists["sv_Departemen"] = {"LinkField":"sv_Departemen","Ajax":true,"DisplayFields":["sv_Departemen","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
</script>
<?php } ?>
<?php if (!$Page->DrillDown && !$grDashboardReport) { ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<a id="top"></a>
<?php if ($Page->Export == "" && !$grDashboardReport) { ?>
<!-- Content Container -->
<div id="ewContainer" class="container-fluid ewContainer">
<?php } ?>
<?php if (@$Page->GenOptions["showfilter"] == "1") { ?>
<?php $Page->ShowFilterList(TRUE) ?>
<?php } ?>
<div class="ewToolbar">
<?php
if (!$Page->DrillDownInPanel) {
	$Page->ExportOptions->Render("body");
	$Page->SearchOptions->Render("body");
	$Page->FilterOptions->Render("body");
	$Page->GenerateOptions->Render("body");
}
?>
</div>
<?php $Page->ShowPageHeader(); ?>
<?php $Page->ShowMessage(); ?>
<?php if ($Page->Export == "" && !$grDashboardReport) { ?>
<div class="row">
<?php } ?>
<?php if ($Page->Export == "" && !$grDashboardReport) { ?>
<!-- Center Container - Report -->
<div id="ewCenter" class="col-sm-12 ewCenter">
<?php } ?>
<!-- Summary Report begins -->
<div id="report_summary">
<?php if (!$Page->DrillDown && !$grDashboardReport) { ?>
<!-- Search form (begin) -->
<form name="fr01_penerimaansummary" id="fr01_penerimaansummary" class="form-inline ewForm ewExtFilterForm" action="<?php echo ewr_CurrentPage() ?>">
<?php $SearchPanelClass = ($Page->Filter <> "") ? " in" : " in"; ?>
<div id="fr01_penerimaansummary_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<div id="r_1" class="ewRow">
<div id="c_Departemen" class="ewCell form-group">
	<label for="sv_Departemen" class="ewSearchCaption ewLabel"><?php echo $Page->Departemen->FldCaption() ?></label>
	<span class="ewSearchField">
<?php $Page->Departemen->EditAttrs["onchange"] = "ewrForms(this).Submit(); " . @$Page->Departemen->EditAttrs["onchange"]; ?>
<?php ewr_PrependClass($Page->Departemen->EditAttrs["class"], "form-control"); ?>
<select data-table="r01_penerimaan" data-field="x_Departemen" data-value-separator="<?php echo ewr_HtmlEncode(is_array($Page->Departemen->DisplayValueSeparator) ? json_encode($Page->Departemen->DisplayValueSeparator) : $Page->Departemen->DisplayValueSeparator) ?>" id="sv_Departemen" name="sv_Departemen"<?php echo $Page->Departemen->EditAttributes() ?>>
<option value=""><?php echo $ReportLanguage->Phrase("PleaseSelect") ?></option>
<?php
	$cntf = is_array($Page->Departemen->AdvancedFilters) ? count($Page->Departemen->AdvancedFilters) : 0;
	$cntd = is_array($Page->Departemen->DropDownList) ? count($Page->Departemen->DropDownList) : 0;
	$totcnt = $cntf + $cntd;
	$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($Page->Departemen->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
				$selwrk = ewr_MatchedFilterValue($Page->Departemen->DropDownValue, $filter->ID) ? " selected" : "";
?>
<option value="<?php echo $filter->ID ?>"<?php echo $selwrk ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
		$selwrk = " selected";
?>
<option value="<?php echo $Page->Departemen->DropDownList[$i] ?>"<?php echo $selwrk ?>><?php echo ewr_DropDownDisplayValue($Page->Departemen->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
</select>
<input type="hidden" name="s_sv_Departemen" id="s_sv_Departemen" value="<?php echo $Page->Departemen->LookupFilterQuery() ?>">
<script type="text/javascript">
fr01_penerimaansummary.Lists["sv_Departemen"].Options = <?php echo ewr_ArrayToJson($Page->Departemen->LookupFilterOptions) ?>;
</script>
</span>
</div>
</div>
</div>
</form>
<script type="text/javascript">
fr01_penerimaansummary.Init();
fr01_penerimaansummary.FilterList = <?php echo $Page->GetFilterList() ?>;
</script>
<!-- Search form (end) -->
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->ShowFilterList() ?>
<?php } ?>
<?php

// Set the last group to display if not export all
if ($Page->ExportAll && $Page->Export <> "") {
	$Page->StopGrp = $Page->TotalGrps;
} else {
	$Page->StopGrp = $Page->StartGrp + $Page->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Page->StopGrp) > intval($Page->TotalGrps))
	$Page->StopGrp = $Page->TotalGrps;
$Page->RecCount = 0;
$Page->RecIndex = 0;

// Get first row
if ($Page->TotalGrps > 0) {
	$Page->GetRow(1);
	$Page->GrpCount = 1;
}
$Page->GrpIdx = ewr_InitArray(2, -1);
$Page->GrpIdx[0] = -1;
$Page->GrpIdx[1] = $Page->StopGrp - $Page->StartGrp + 1;
while ($rs && !$rs->EOF && $Page->GrpCount <= $Page->DisplayGrps || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="box ewBox ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<!-- Report grid (begin) -->
<div id="gmp_r01_penerimaan" class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($Page->id->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="id"><div class="r01_penerimaan_id"><span class="ewTableHeaderCaption"><?php echo $Page->id->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="id">
<?php if ($Page->SortUrl($Page->id) == "") { ?>
		<div class="ewTableHeaderBtn r01_penerimaan_id">
			<span class="ewTableHeaderCaption"><?php echo $Page->id->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_penerimaan_id" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->id) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->id->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Departemen->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Departemen"><div class="r01_penerimaan_Departemen"><span class="ewTableHeaderCaption"><?php echo $Page->Departemen->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Departemen">
<?php if ($Page->SortUrl($Page->Departemen) == "") { ?>
		<div class="ewTableHeaderBtn r01_penerimaan_Departemen">
			<span class="ewTableHeaderCaption"><?php echo $Page->Departemen->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_penerimaan_Departemen" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Departemen) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Departemen->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Departemen->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Departemen->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->HeadDetail->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="HeadDetail"><div class="r01_penerimaan_HeadDetail"><span class="ewTableHeaderCaption"><?php echo $Page->HeadDetail->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="HeadDetail">
<?php if ($Page->SortUrl($Page->HeadDetail) == "") { ?>
		<div class="ewTableHeaderBtn r01_penerimaan_HeadDetail">
			<span class="ewTableHeaderCaption"><?php echo $Page->HeadDetail->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_penerimaan_HeadDetail" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->HeadDetail) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->HeadDetail->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->HeadDetail->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->HeadDetail->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->NomorHead->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="NomorHead"><div class="r01_penerimaan_NomorHead"><span class="ewTableHeaderCaption"><?php echo $Page->NomorHead->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="NomorHead">
<?php if ($Page->SortUrl($Page->NomorHead) == "") { ?>
		<div class="ewTableHeaderBtn r01_penerimaan_NomorHead">
			<span class="ewTableHeaderCaption"><?php echo $Page->NomorHead->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_penerimaan_NomorHead" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->NomorHead) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->NomorHead->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->NomorHead->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->NomorHead->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->SubTotalFlag->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="SubTotalFlag"><div class="r01_penerimaan_SubTotalFlag"><span class="ewTableHeaderCaption"><?php echo $Page->SubTotalFlag->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="SubTotalFlag">
<?php if ($Page->SortUrl($Page->SubTotalFlag) == "") { ?>
		<div class="ewTableHeaderBtn r01_penerimaan_SubTotalFlag">
			<span class="ewTableHeaderCaption"><?php echo $Page->SubTotalFlag->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_penerimaan_SubTotalFlag" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->SubTotalFlag) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->SubTotalFlag->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->SubTotalFlag->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->SubTotalFlag->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Urutan->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Urutan"><div class="r01_penerimaan_Urutan"><span class="ewTableHeaderCaption"><?php echo $Page->Urutan->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Urutan">
<?php if ($Page->SortUrl($Page->Urutan) == "") { ?>
		<div class="ewTableHeaderBtn r01_penerimaan_Urutan">
			<span class="ewTableHeaderCaption"><?php echo $Page->Urutan->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_penerimaan_Urutan" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Urutan) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Urutan->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Urutan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Urutan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Nomor->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Nomor"><div class="r01_penerimaan_Nomor"><span class="ewTableHeaderCaption"><?php echo $Page->Nomor->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Nomor">
<?php if ($Page->SortUrl($Page->Nomor) == "") { ?>
		<div class="ewTableHeaderBtn r01_penerimaan_Nomor">
			<span class="ewTableHeaderCaption"><?php echo $Page->Nomor->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_penerimaan_Nomor" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Nomor) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Nomor->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Nomor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Nomor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Pos->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Pos"><div class="r01_penerimaan_Pos"><span class="ewTableHeaderCaption"><?php echo $Page->Pos->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Pos">
<?php if ($Page->SortUrl($Page->Pos) == "") { ?>
		<div class="ewTableHeaderBtn r01_penerimaan_Pos">
			<span class="ewTableHeaderCaption"><?php echo $Page->Pos->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_penerimaan_Pos" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Pos) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Pos->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Pos->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Pos->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Nominal->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Nominal"><div class="r01_penerimaan_Nominal"><span class="ewTableHeaderCaption"><?php echo $Page->Nominal->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Nominal">
<?php if ($Page->SortUrl($Page->Nominal) == "") { ?>
		<div class="ewTableHeaderBtn r01_penerimaan_Nominal">
			<span class="ewTableHeaderCaption"><?php echo $Page->Nominal->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_penerimaan_Nominal" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Nominal) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Nominal->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Nominal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Nominal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->JumlahSiswa->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="JumlahSiswa"><div class="r01_penerimaan_JumlahSiswa"><span class="ewTableHeaderCaption"><?php echo $Page->JumlahSiswa->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="JumlahSiswa">
<?php if ($Page->SortUrl($Page->JumlahSiswa) == "") { ?>
		<div class="ewTableHeaderBtn r01_penerimaan_JumlahSiswa">
			<span class="ewTableHeaderCaption"><?php echo $Page->JumlahSiswa->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_penerimaan_JumlahSiswa" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->JumlahSiswa) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->JumlahSiswa->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->JumlahSiswa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->JumlahSiswa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Bulan->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Bulan"><div class="r01_penerimaan_Bulan"><span class="ewTableHeaderCaption"><?php echo $Page->Bulan->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Bulan">
<?php if ($Page->SortUrl($Page->Bulan) == "") { ?>
		<div class="ewTableHeaderBtn r01_penerimaan_Bulan">
			<span class="ewTableHeaderCaption"><?php echo $Page->Bulan->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_penerimaan_Bulan" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Bulan) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Bulan->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Bulan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Bulan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Jumlah->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Jumlah"><div class="r01_penerimaan_Jumlah"><span class="ewTableHeaderCaption"><?php echo $Page->Jumlah->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Jumlah">
<?php if ($Page->SortUrl($Page->Jumlah) == "") { ?>
		<div class="ewTableHeaderBtn r01_penerimaan_Jumlah">
			<span class="ewTableHeaderCaption"><?php echo $Page->Jumlah->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_penerimaan_Jumlah" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Jumlah) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Jumlah->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Total->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Total"><div class="r01_penerimaan_Total"><span class="ewTableHeaderCaption"><?php echo $Page->Total->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Total">
<?php if ($Page->SortUrl($Page->Total) == "") { ?>
		<div class="ewTableHeaderBtn r01_penerimaan_Total">
			<span class="ewTableHeaderCaption"><?php echo $Page->Total->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_penerimaan_Total" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Total) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Total->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Total->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Total->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
	</tr>
</thead>
<tbody>
<?php
		if ($Page->TotalGrps == 0) break; // Show header only
		$Page->ShowHeader = FALSE;
	}
	$Page->RecCount++;
	$Page->RecIndex++;
?>
<?php

		// Render detail row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_DETAIL;
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->id->Visible) { ?>
		<td data-field="id"<?php echo $Page->id->CellAttributes() ?>>
<span<?php echo $Page->id->ViewAttributes() ?>><?php echo $Page->id->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Departemen->Visible) { ?>
		<td data-field="Departemen"<?php echo $Page->Departemen->CellAttributes() ?>>
<span<?php echo $Page->Departemen->ViewAttributes() ?>><?php echo $Page->Departemen->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->HeadDetail->Visible) { ?>
		<td data-field="HeadDetail"<?php echo $Page->HeadDetail->CellAttributes() ?>>
<span<?php echo $Page->HeadDetail->ViewAttributes() ?>><?php echo $Page->HeadDetail->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->NomorHead->Visible) { ?>
		<td data-field="NomorHead"<?php echo $Page->NomorHead->CellAttributes() ?>>
<span<?php echo $Page->NomorHead->ViewAttributes() ?>><?php echo $Page->NomorHead->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->SubTotalFlag->Visible) { ?>
		<td data-field="SubTotalFlag"<?php echo $Page->SubTotalFlag->CellAttributes() ?>>
<span<?php echo $Page->SubTotalFlag->ViewAttributes() ?>><?php echo $Page->SubTotalFlag->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Urutan->Visible) { ?>
		<td data-field="Urutan"<?php echo $Page->Urutan->CellAttributes() ?>>
<span<?php echo $Page->Urutan->ViewAttributes() ?>><?php echo $Page->Urutan->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Nomor->Visible) { ?>
		<td data-field="Nomor"<?php echo $Page->Nomor->CellAttributes() ?>>
<span<?php echo $Page->Nomor->ViewAttributes() ?>><?php echo $Page->Nomor->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Pos->Visible) { ?>
		<td data-field="Pos"<?php echo $Page->Pos->CellAttributes() ?>>
<span<?php echo $Page->Pos->ViewAttributes() ?>><?php echo $Page->Pos->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Nominal->Visible) { ?>
		<td data-field="Nominal"<?php echo $Page->Nominal->CellAttributes() ?>>
<span<?php echo $Page->Nominal->ViewAttributes() ?>><?php echo $Page->Nominal->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->JumlahSiswa->Visible) { ?>
		<td data-field="JumlahSiswa"<?php echo $Page->JumlahSiswa->CellAttributes() ?>>
<span<?php echo $Page->JumlahSiswa->ViewAttributes() ?>><?php echo $Page->JumlahSiswa->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Bulan->Visible) { ?>
		<td data-field="Bulan"<?php echo $Page->Bulan->CellAttributes() ?>>
<span<?php echo $Page->Bulan->ViewAttributes() ?>><?php echo $Page->Bulan->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Jumlah->Visible) { ?>
		<td data-field="Jumlah"<?php echo $Page->Jumlah->CellAttributes() ?>>
<span<?php echo $Page->Jumlah->ViewAttributes() ?>><?php echo $Page->Jumlah->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Total->Visible) { ?>
		<td data-field="Total"<?php echo $Page->Total->CellAttributes() ?>>
<span<?php echo $Page->Total->ViewAttributes() ?>><?php echo $Page->Total->ListViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->AccumulateSummary();

		// Get next record
		$Page->GetRow(2);
	$Page->GrpCount++;
} // End while
?>
<?php if ($Page->TotalGrps > 0) { ?>
</tbody>
<tfoot>
<?php
	$Page->ResetAttrs();
	$Page->RowType = EWR_ROWTYPE_TOTAL;
	$Page->RowTotalType = EWR_ROWTOTAL_GRAND;
	$Page->RowTotalSubType = EWR_ROWTOTAL_FOOTER;
	$Page->RowAttrs["class"] = "ewRptGrandSummary";
	$Page->RenderRow();
?>
<?php if ($Page->ShowCompactSummaryFooter) { ?>
	<tr<?php echo $Page->RowAttributes() ?>><td colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount) ?>"><?php echo $ReportLanguage->Phrase("RptGrandSummary") ?> (<span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->TotCount,0,-2,-2,-2) ?></span>)</td></tr>
<?php } else { ?>
	<tr<?php echo $Page->RowAttributes() ?>><td colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount) ?>"><?php echo $ReportLanguage->Phrase("RptGrandSummary") ?> <span class="ewDirLtr">(<?php echo ewr_FormatNumber($Page->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</span></td></tr>
<?php } ?>
	</tfoot>
<?php } elseif (!$Page->ShowHeader && FALSE) { // No header displayed ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="box ewBox ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<!-- Report grid (begin) -->
<div id="gmp_r01_penerimaan" class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<?php } ?>
<?php if ($Page->TotalGrps > 0 || FALSE) { // Show footer ?>
</table>
</div>
<?php if (!($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="box-footer ewGridLowerPanel">
<?php include "r01_penerimaansmrypager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
</div>
<!-- Summary Report Ends -->
<?php if ($Page->Export == "" && !$grDashboardReport) { ?>
</div>
<!-- /#ewCenter -->
<?php } ?>
<?php if ($Page->Export == "" && !$grDashboardReport) { ?>
</div>
<!-- /.row -->
<?php } ?>
<?php if ($Page->Export == "" && !$grDashboardReport) { ?>
</div>
<!-- /.ewContainer -->
<?php } ?>
<?php
$Page->ShowPageFooter();
if (EWR_DEBUG_ENABLED)
	echo ewr_DebugMsg();
?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if (!$Page->DrillDown && !$grDashboardReport) { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// console.log("page loaded");

</script>
<?php } ?>
<?php if (!$grDashboardReport) { ?>
<?php include_once "phprptinc/footer.php" ?>
<?php include_once "footer.php" ?>
<?php } ?>
<?php
$Page->Page_Terminate();
if (isset($OldPage)) $Page = $OldPage;
?>
