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

$datapenerimaan_view = NULL; // Initialize page object first

class cdatapenerimaan_view extends cdatapenerimaan {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{EA1CE07B-E03E-4EC9-BC42-48D490D73F97}';

	// Table name
	var $TableName = 'datapenerimaan';

	// Page object name
	var $PageObjName = 'datapenerimaan_view';

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
		$KeyUrl = "";
		if (@$_GET["replid"] <> "") {
			$this->RecKey["replid"] = $_GET["replid"];
			$KeyUrl .= "&amp;replid=" . urlencode($this->RecKey["replid"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $gbSkipHeaderFooter, $EW_EXPORT;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["replid"] <> "") {
				$this->replid->setQueryStringValue($_GET["replid"]);
				$this->RecKey["replid"] = $this->replid->QueryStringValue;
			} elseif (@$_POST["replid"] <> "") {
				$this->replid->setFormValue($_POST["replid"]);
				$this->RecKey["replid"] = $this->replid->FormValue;
			} else {
				$sReturnUrl = "datapenerimaanlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "datapenerimaanlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "datapenerimaanlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "");

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "");

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'AddBtn',url:'" . ew_HtmlEncode($this->CopyUrl) . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "");

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddQuery($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "");

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("datapenerimaanlist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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
if (!isset($datapenerimaan_view)) $datapenerimaan_view = new cdatapenerimaan_view();

// Page init
$datapenerimaan_view->Page_Init();

// Page main
$datapenerimaan_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$datapenerimaan_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fdatapenerimaanview = new ew_Form("fdatapenerimaanview", "view");

// Form_CustomValidate event
fdatapenerimaanview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fdatapenerimaanview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $datapenerimaan_view->ExportOptions->Render("body") ?>
<?php
	foreach ($datapenerimaan_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $datapenerimaan_view->ShowPageHeader(); ?>
<?php
$datapenerimaan_view->ShowMessage();
?>
<form name="fdatapenerimaanview" id="fdatapenerimaanview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($datapenerimaan_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $datapenerimaan_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="datapenerimaan">
<input type="hidden" name="modal" value="<?php echo intval($datapenerimaan_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($datapenerimaan->replid->Visible) { // replid ?>
	<tr id="r_replid">
		<td class="col-sm-2"><span id="elh_datapenerimaan_replid"><?php echo $datapenerimaan->replid->FldCaption() ?></span></td>
		<td data-name="replid"<?php echo $datapenerimaan->replid->CellAttributes() ?>>
<span id="el_datapenerimaan_replid">
<span<?php echo $datapenerimaan->replid->ViewAttributes() ?>>
<?php echo $datapenerimaan->replid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->nama->Visible) { // nama ?>
	<tr id="r_nama">
		<td class="col-sm-2"><span id="elh_datapenerimaan_nama"><?php echo $datapenerimaan->nama->FldCaption() ?></span></td>
		<td data-name="nama"<?php echo $datapenerimaan->nama->CellAttributes() ?>>
<span id="el_datapenerimaan_nama">
<span<?php echo $datapenerimaan->nama->ViewAttributes() ?>>
<?php echo $datapenerimaan->nama->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->besar->Visible) { // besar ?>
	<tr id="r_besar">
		<td class="col-sm-2"><span id="elh_datapenerimaan_besar"><?php echo $datapenerimaan->besar->FldCaption() ?></span></td>
		<td data-name="besar"<?php echo $datapenerimaan->besar->CellAttributes() ?>>
<span id="el_datapenerimaan_besar">
<span<?php echo $datapenerimaan->besar->ViewAttributes() ?>>
<?php echo $datapenerimaan->besar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->idkategori->Visible) { // idkategori ?>
	<tr id="r_idkategori">
		<td class="col-sm-2"><span id="elh_datapenerimaan_idkategori"><?php echo $datapenerimaan->idkategori->FldCaption() ?></span></td>
		<td data-name="idkategori"<?php echo $datapenerimaan->idkategori->CellAttributes() ?>>
<span id="el_datapenerimaan_idkategori">
<span<?php echo $datapenerimaan->idkategori->ViewAttributes() ?>>
<?php echo $datapenerimaan->idkategori->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->rekkas->Visible) { // rekkas ?>
	<tr id="r_rekkas">
		<td class="col-sm-2"><span id="elh_datapenerimaan_rekkas"><?php echo $datapenerimaan->rekkas->FldCaption() ?></span></td>
		<td data-name="rekkas"<?php echo $datapenerimaan->rekkas->CellAttributes() ?>>
<span id="el_datapenerimaan_rekkas">
<span<?php echo $datapenerimaan->rekkas->ViewAttributes() ?>>
<?php echo $datapenerimaan->rekkas->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->rekpendapatan->Visible) { // rekpendapatan ?>
	<tr id="r_rekpendapatan">
		<td class="col-sm-2"><span id="elh_datapenerimaan_rekpendapatan"><?php echo $datapenerimaan->rekpendapatan->FldCaption() ?></span></td>
		<td data-name="rekpendapatan"<?php echo $datapenerimaan->rekpendapatan->CellAttributes() ?>>
<span id="el_datapenerimaan_rekpendapatan">
<span<?php echo $datapenerimaan->rekpendapatan->ViewAttributes() ?>>
<?php echo $datapenerimaan->rekpendapatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->rekpiutang->Visible) { // rekpiutang ?>
	<tr id="r_rekpiutang">
		<td class="col-sm-2"><span id="elh_datapenerimaan_rekpiutang"><?php echo $datapenerimaan->rekpiutang->FldCaption() ?></span></td>
		<td data-name="rekpiutang"<?php echo $datapenerimaan->rekpiutang->CellAttributes() ?>>
<span id="el_datapenerimaan_rekpiutang">
<span<?php echo $datapenerimaan->rekpiutang->ViewAttributes() ?>>
<?php echo $datapenerimaan->rekpiutang->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->aktif->Visible) { // aktif ?>
	<tr id="r_aktif">
		<td class="col-sm-2"><span id="elh_datapenerimaan_aktif"><?php echo $datapenerimaan->aktif->FldCaption() ?></span></td>
		<td data-name="aktif"<?php echo $datapenerimaan->aktif->CellAttributes() ?>>
<span id="el_datapenerimaan_aktif">
<span<?php echo $datapenerimaan->aktif->ViewAttributes() ?>>
<?php echo $datapenerimaan->aktif->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->keterangan->Visible) { // keterangan ?>
	<tr id="r_keterangan">
		<td class="col-sm-2"><span id="elh_datapenerimaan_keterangan"><?php echo $datapenerimaan->keterangan->FldCaption() ?></span></td>
		<td data-name="keterangan"<?php echo $datapenerimaan->keterangan->CellAttributes() ?>>
<span id="el_datapenerimaan_keterangan">
<span<?php echo $datapenerimaan->keterangan->ViewAttributes() ?>>
<?php echo $datapenerimaan->keterangan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->departemen->Visible) { // departemen ?>
	<tr id="r_departemen">
		<td class="col-sm-2"><span id="elh_datapenerimaan_departemen"><?php echo $datapenerimaan->departemen->FldCaption() ?></span></td>
		<td data-name="departemen"<?php echo $datapenerimaan->departemen->CellAttributes() ?>>
<span id="el_datapenerimaan_departemen">
<span<?php echo $datapenerimaan->departemen->ViewAttributes() ?>>
<?php echo $datapenerimaan->departemen->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->info1->Visible) { // info1 ?>
	<tr id="r_info1">
		<td class="col-sm-2"><span id="elh_datapenerimaan_info1"><?php echo $datapenerimaan->info1->FldCaption() ?></span></td>
		<td data-name="info1"<?php echo $datapenerimaan->info1->CellAttributes() ?>>
<span id="el_datapenerimaan_info1">
<span<?php echo $datapenerimaan->info1->ViewAttributes() ?>>
<?php echo $datapenerimaan->info1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->info2->Visible) { // info2 ?>
	<tr id="r_info2">
		<td class="col-sm-2"><span id="elh_datapenerimaan_info2"><?php echo $datapenerimaan->info2->FldCaption() ?></span></td>
		<td data-name="info2"<?php echo $datapenerimaan->info2->CellAttributes() ?>>
<span id="el_datapenerimaan_info2">
<span<?php echo $datapenerimaan->info2->ViewAttributes() ?>>
<?php echo $datapenerimaan->info2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->info3->Visible) { // info3 ?>
	<tr id="r_info3">
		<td class="col-sm-2"><span id="elh_datapenerimaan_info3"><?php echo $datapenerimaan->info3->FldCaption() ?></span></td>
		<td data-name="info3"<?php echo $datapenerimaan->info3->CellAttributes() ?>>
<span id="el_datapenerimaan_info3">
<span<?php echo $datapenerimaan->info3->ViewAttributes() ?>>
<?php echo $datapenerimaan->info3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->ts->Visible) { // ts ?>
	<tr id="r_ts">
		<td class="col-sm-2"><span id="elh_datapenerimaan_ts"><?php echo $datapenerimaan->ts->FldCaption() ?></span></td>
		<td data-name="ts"<?php echo $datapenerimaan->ts->CellAttributes() ?>>
<span id="el_datapenerimaan_ts">
<span<?php echo $datapenerimaan->ts->ViewAttributes() ?>>
<?php echo $datapenerimaan->ts->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->token->Visible) { // token ?>
	<tr id="r_token">
		<td class="col-sm-2"><span id="elh_datapenerimaan_token"><?php echo $datapenerimaan->token->FldCaption() ?></span></td>
		<td data-name="token"<?php echo $datapenerimaan->token->CellAttributes() ?>>
<span id="el_datapenerimaan_token">
<span<?php echo $datapenerimaan->token->ViewAttributes() ?>>
<?php echo $datapenerimaan->token->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($datapenerimaan->issync->Visible) { // issync ?>
	<tr id="r_issync">
		<td class="col-sm-2"><span id="elh_datapenerimaan_issync"><?php echo $datapenerimaan->issync->FldCaption() ?></span></td>
		<td data-name="issync"<?php echo $datapenerimaan->issync->CellAttributes() ?>>
<span id="el_datapenerimaan_issync">
<span<?php echo $datapenerimaan->issync->ViewAttributes() ?>>
<?php echo $datapenerimaan->issync->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fdatapenerimaanview.Init();
</script>
<?php
$datapenerimaan_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$datapenerimaan_view->Page_Terminate();
?>
