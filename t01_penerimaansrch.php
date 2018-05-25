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

$t01_penerimaan_search = NULL; // Initialize page object first

class ct01_penerimaan_search extends ct01_penerimaan {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = '{EA1CE07B-E03E-4EC9-BC42-48D490D73F97}';

	// Table name
	var $TableName = 't01_penerimaan';

	// Page object name
	var $PageObjName = 't01_penerimaan_search';

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
			define("EW_PAGE_ID", 'search', TRUE);

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
	var $FormClassName = "form-horizontal ewForm ewSearchForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError;
		global $gbSkipHeaderFooter;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$this->CurrentAction = $objForm->GetValue("a_search");
			switch ($this->CurrentAction) {
				case "S": // Get search criteria

					// Build search string for advanced search, remove blank field
					$this->LoadSearchValues(); // Get search values
					if ($this->ValidateSearch()) {
						$sSrchStr = $this->BuildAdvancedSearch();
					} else {
						$sSrchStr = "";
						$this->setFailureMessage($gsSearchError);
					}
					if ($sSrchStr <> "") {
						$sSrchStr = $this->UrlParm($sSrchStr);
						$sSrchStr = "t01_penerimaanlist.php" . "?" . $sSrchStr;
						$this->Page_Terminate($sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$this->RowType = EW_ROWTYPE_SEARCH;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Build advanced search
	function BuildAdvancedSearch() {
		$sSrchUrl = "";
		$this->BuildSearchUrl($sSrchUrl, $this->id); // id
		$this->BuildSearchUrl($sSrchUrl, $this->Departemen); // Departemen
		$this->BuildSearchUrl($sSrchUrl, $this->HeadDetail); // HeadDetail
		$this->BuildSearchUrl($sSrchUrl, $this->NomorHead); // NomorHead
		$this->BuildSearchUrl($sSrchUrl, $this->SubTotalFlag); // SubTotalFlag
		$this->BuildSearchUrl($sSrchUrl, $this->Urutan); // Urutan
		$this->BuildSearchUrl($sSrchUrl, $this->Nomor); // Nomor
		$this->BuildSearchUrl($sSrchUrl, $this->Pos); // Pos
		$this->BuildSearchUrl($sSrchUrl, $this->Nominal); // Nominal
		$this->BuildSearchUrl($sSrchUrl, $this->JumlahSiswa); // JumlahSiswa
		$this->BuildSearchUrl($sSrchUrl, $this->Bulan); // Bulan
		$this->BuildSearchUrl($sSrchUrl, $this->Jumlah); // Jumlah
		$this->BuildSearchUrl($sSrchUrl, $this->Total); // Total
		if ($sSrchUrl <> "") $sSrchUrl .= "&";
		$sSrchUrl .= "cmd=search";
		return $sSrchUrl;
	}

	// Build search URL
	function BuildSearchUrl(&$Url, &$Fld, $OprOnly=FALSE) {
		global $objForm;
		$sWrk = "";
		$FldParm = $Fld->FldParm();
		$FldVal = $objForm->GetValue("x_$FldParm");
		$FldOpr = $objForm->GetValue("z_$FldParm");
		$FldCond = $objForm->GetValue("v_$FldParm");
		$FldVal2 = $objForm->GetValue("y_$FldParm");
		$FldOpr2 = $objForm->GetValue("w_$FldParm");
		$FldVal = $FldVal;
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = $FldVal2;
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($FldOpr == "BETWEEN") {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal) && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			}
		} else {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal));
			if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $lFldDataType)) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL" || ($FldOpr <> "" && $OprOnly && ew_IsValidOpr($FldOpr, $lFldDataType))) {
				$sWrk = "z_" . $FldParm . "=" . urlencode($FldOpr);
			}
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $lFldDataType)) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&w_" . $FldParm . "=" . urlencode($FldOpr2);
			} elseif ($FldOpr2 == "IS NULL" || $FldOpr2 == "IS NOT NULL" || ($FldOpr2 <> "" && $OprOnly && ew_IsValidOpr($FldOpr2, $lFldDataType))) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "w_" . $FldParm . "=" . urlencode($FldOpr2);
			}
		}
		if ($sWrk <> "") {
			if ($Url <> "") $Url .= "&";
			$Url .= $sWrk;
		}
	}

	function SearchValueIsNumeric($Fld, $Value) {
		if (ew_IsFloatFormat($Fld->FldType)) $Value = ew_StrToFloat($Value);
		return is_numeric($Value);
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// id

		$this->id->AdvancedSearch->SearchValue = $objForm->GetValue("x_id");
		$this->id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_id");

		// Departemen
		$this->Departemen->AdvancedSearch->SearchValue = $objForm->GetValue("x_Departemen");
		$this->Departemen->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Departemen");

		// HeadDetail
		$this->HeadDetail->AdvancedSearch->SearchValue = $objForm->GetValue("x_HeadDetail");
		$this->HeadDetail->AdvancedSearch->SearchOperator = $objForm->GetValue("z_HeadDetail");

		// NomorHead
		$this->NomorHead->AdvancedSearch->SearchValue = $objForm->GetValue("x_NomorHead");
		$this->NomorHead->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NomorHead");

		// SubTotalFlag
		$this->SubTotalFlag->AdvancedSearch->SearchValue = $objForm->GetValue("x_SubTotalFlag");
		$this->SubTotalFlag->AdvancedSearch->SearchOperator = $objForm->GetValue("z_SubTotalFlag");

		// Urutan
		$this->Urutan->AdvancedSearch->SearchValue = $objForm->GetValue("x_Urutan");
		$this->Urutan->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Urutan");

		// Nomor
		$this->Nomor->AdvancedSearch->SearchValue = $objForm->GetValue("x_Nomor");
		$this->Nomor->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nomor");

		// Pos
		$this->Pos->AdvancedSearch->SearchValue = $objForm->GetValue("x_Pos");
		$this->Pos->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Pos");

		// Nominal
		$this->Nominal->AdvancedSearch->SearchValue = $objForm->GetValue("x_Nominal");
		$this->Nominal->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Nominal");

		// JumlahSiswa
		$this->JumlahSiswa->AdvancedSearch->SearchValue = $objForm->GetValue("x_JumlahSiswa");
		$this->JumlahSiswa->AdvancedSearch->SearchOperator = $objForm->GetValue("z_JumlahSiswa");

		// Bulan
		$this->Bulan->AdvancedSearch->SearchValue = $objForm->GetValue("x_Bulan");
		$this->Bulan->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Bulan");

		// Jumlah
		$this->Jumlah->AdvancedSearch->SearchValue = $objForm->GetValue("x_Jumlah");
		$this->Jumlah->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Jumlah");

		// Total
		$this->Total->AdvancedSearch->SearchValue = $objForm->GetValue("x_Total");
		$this->Total->AdvancedSearch->SearchOperator = $objForm->GetValue("z_Total");
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
		$this->Departemen->ViewValue = $this->Departemen->CurrentValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = ew_HtmlEncode($this->id->AdvancedSearch->SearchValue);
			$this->id->PlaceHolder = ew_RemoveHtml($this->id->FldCaption());

			// Departemen
			$this->Departemen->EditAttrs["class"] = "form-control";
			$this->Departemen->EditCustomAttributes = "";
			$this->Departemen->EditValue = ew_HtmlEncode($this->Departemen->AdvancedSearch->SearchValue);
			$this->Departemen->PlaceHolder = ew_RemoveHtml($this->Departemen->FldCaption());

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
		if (!ew_CheckInteger($this->id->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->id->FldErrMsg());
		}
		if (!ew_CheckInteger($this->NomorHead->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->NomorHead->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Urutan->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Urutan->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Nominal->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Nominal->FldErrMsg());
		}
		if (!ew_CheckInteger($this->JumlahSiswa->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->JumlahSiswa->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Bulan->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Bulan->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Jumlah->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Jumlah->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Total->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->Total->FldErrMsg());
		}

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t01_penerimaanlist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
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
if (!isset($t01_penerimaan_search)) $t01_penerimaan_search = new ct01_penerimaan_search();

// Page init
$t01_penerimaan_search->Page_Init();

// Page main
$t01_penerimaan_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t01_penerimaan_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($t01_penerimaan_search->IsModal) { ?>
var CurrentAdvancedSearchForm = ft01_penerimaansearch = new ew_Form("ft01_penerimaansearch", "search");
<?php } else { ?>
var CurrentForm = ft01_penerimaansearch = new ew_Form("ft01_penerimaansearch", "search");
<?php } ?>

// Form_CustomValidate event
ft01_penerimaansearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft01_penerimaansearch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search
// Validate function for search

ft01_penerimaansearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_id");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->id->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_NomorHead");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->NomorHead->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Urutan");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->Urutan->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Nominal");
	if (elm && !ew_CheckNumber(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->Nominal->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_JumlahSiswa");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->JumlahSiswa->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Bulan");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->Bulan->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Jumlah");
	if (elm && !ew_CheckNumber(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->Jumlah->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_Total");
	if (elm && !ew_CheckNumber(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t01_penerimaan->Total->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t01_penerimaan_search->ShowPageHeader(); ?>
<?php
$t01_penerimaan_search->ShowMessage();
?>
<form name="ft01_penerimaansearch" id="ft01_penerimaansearch" class="<?php echo $t01_penerimaan_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t01_penerimaan_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t01_penerimaan_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t01_penerimaan">
<input type="hidden" name="a_search" id="a_search" value="S">
<input type="hidden" name="modal" value="<?php echo intval($t01_penerimaan_search->IsModal) ?>">
<div class="ewSearchDiv"><!-- page* -->
<?php if ($t01_penerimaan->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label for="x_id" class="<?php echo $t01_penerimaan_search->LeftColumnClass ?>"><span id="elh_t01_penerimaan_id"><?php echo $t01_penerimaan->id->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_id" id="z_id" value="="></p>
		</label>
		<div class="<?php echo $t01_penerimaan_search->RightColumnClass ?>"><div<?php echo $t01_penerimaan->id->CellAttributes() ?>>
			<span id="el_t01_penerimaan_id">
<input type="text" data-table="t01_penerimaan" data-field="x_id" name="x_id" id="x_id" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->id->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->id->EditValue ?>"<?php echo $t01_penerimaan->id->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Departemen->Visible) { // Departemen ?>
	<div id="r_Departemen" class="form-group">
		<label for="x_Departemen" class="<?php echo $t01_penerimaan_search->LeftColumnClass ?>"><span id="elh_t01_penerimaan_Departemen"><?php echo $t01_penerimaan->Departemen->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Departemen" id="z_Departemen" value="LIKE"></p>
		</label>
		<div class="<?php echo $t01_penerimaan_search->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Departemen->CellAttributes() ?>>
			<span id="el_t01_penerimaan_Departemen">
<input type="text" data-table="t01_penerimaan" data-field="x_Departemen" name="x_Departemen" id="x_Departemen" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Departemen->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Departemen->EditValue ?>"<?php echo $t01_penerimaan->Departemen->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->HeadDetail->Visible) { // HeadDetail ?>
	<div id="r_HeadDetail" class="form-group">
		<label for="x_HeadDetail" class="<?php echo $t01_penerimaan_search->LeftColumnClass ?>"><span id="elh_t01_penerimaan_HeadDetail"><?php echo $t01_penerimaan->HeadDetail->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_HeadDetail" id="z_HeadDetail" value="LIKE"></p>
		</label>
		<div class="<?php echo $t01_penerimaan_search->RightColumnClass ?>"><div<?php echo $t01_penerimaan->HeadDetail->CellAttributes() ?>>
			<span id="el_t01_penerimaan_HeadDetail">
<input type="text" data-table="t01_penerimaan" data-field="x_HeadDetail" name="x_HeadDetail" id="x_HeadDetail" size="30" maxlength="1" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->HeadDetail->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->HeadDetail->EditValue ?>"<?php echo $t01_penerimaan->HeadDetail->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->NomorHead->Visible) { // NomorHead ?>
	<div id="r_NomorHead" class="form-group">
		<label for="x_NomorHead" class="<?php echo $t01_penerimaan_search->LeftColumnClass ?>"><span id="elh_t01_penerimaan_NomorHead"><?php echo $t01_penerimaan->NomorHead->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_NomorHead" id="z_NomorHead" value="="></p>
		</label>
		<div class="<?php echo $t01_penerimaan_search->RightColumnClass ?>"><div<?php echo $t01_penerimaan->NomorHead->CellAttributes() ?>>
			<span id="el_t01_penerimaan_NomorHead">
<input type="text" data-table="t01_penerimaan" data-field="x_NomorHead" name="x_NomorHead" id="x_NomorHead" size="30" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->NomorHead->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->NomorHead->EditValue ?>"<?php echo $t01_penerimaan->NomorHead->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->SubTotalFlag->Visible) { // SubTotalFlag ?>
	<div id="r_SubTotalFlag" class="form-group">
		<label for="x_SubTotalFlag" class="<?php echo $t01_penerimaan_search->LeftColumnClass ?>"><span id="elh_t01_penerimaan_SubTotalFlag"><?php echo $t01_penerimaan->SubTotalFlag->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_SubTotalFlag" id="z_SubTotalFlag" value="LIKE"></p>
		</label>
		<div class="<?php echo $t01_penerimaan_search->RightColumnClass ?>"><div<?php echo $t01_penerimaan->SubTotalFlag->CellAttributes() ?>>
			<span id="el_t01_penerimaan_SubTotalFlag">
<input type="text" data-table="t01_penerimaan" data-field="x_SubTotalFlag" name="x_SubTotalFlag" id="x_SubTotalFlag" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->SubTotalFlag->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->SubTotalFlag->EditValue ?>"<?php echo $t01_penerimaan->SubTotalFlag->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Urutan->Visible) { // Urutan ?>
	<div id="r_Urutan" class="form-group">
		<label for="x_Urutan" class="<?php echo $t01_penerimaan_search->LeftColumnClass ?>"><span id="elh_t01_penerimaan_Urutan"><?php echo $t01_penerimaan->Urutan->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Urutan" id="z_Urutan" value="="></p>
		</label>
		<div class="<?php echo $t01_penerimaan_search->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Urutan->CellAttributes() ?>>
			<span id="el_t01_penerimaan_Urutan">
<input type="text" data-table="t01_penerimaan" data-field="x_Urutan" name="x_Urutan" id="x_Urutan" size="30" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Urutan->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Urutan->EditValue ?>"<?php echo $t01_penerimaan->Urutan->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Nomor->Visible) { // Nomor ?>
	<div id="r_Nomor" class="form-group">
		<label for="x_Nomor" class="<?php echo $t01_penerimaan_search->LeftColumnClass ?>"><span id="elh_t01_penerimaan_Nomor"><?php echo $t01_penerimaan->Nomor->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Nomor" id="z_Nomor" value="LIKE"></p>
		</label>
		<div class="<?php echo $t01_penerimaan_search->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Nomor->CellAttributes() ?>>
			<span id="el_t01_penerimaan_Nomor">
<input type="text" data-table="t01_penerimaan" data-field="x_Nomor" name="x_Nomor" id="x_Nomor" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Nomor->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Nomor->EditValue ?>"<?php echo $t01_penerimaan->Nomor->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Pos->Visible) { // Pos ?>
	<div id="r_Pos" class="form-group">
		<label for="x_Pos" class="<?php echo $t01_penerimaan_search->LeftColumnClass ?>"><span id="elh_t01_penerimaan_Pos"><?php echo $t01_penerimaan->Pos->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_Pos" id="z_Pos" value="LIKE"></p>
		</label>
		<div class="<?php echo $t01_penerimaan_search->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Pos->CellAttributes() ?>>
			<span id="el_t01_penerimaan_Pos">
<input type="text" data-table="t01_penerimaan" data-field="x_Pos" name="x_Pos" id="x_Pos" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Pos->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Pos->EditValue ?>"<?php echo $t01_penerimaan->Pos->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Nominal->Visible) { // Nominal ?>
	<div id="r_Nominal" class="form-group">
		<label for="x_Nominal" class="<?php echo $t01_penerimaan_search->LeftColumnClass ?>"><span id="elh_t01_penerimaan_Nominal"><?php echo $t01_penerimaan->Nominal->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Nominal" id="z_Nominal" value="="></p>
		</label>
		<div class="<?php echo $t01_penerimaan_search->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Nominal->CellAttributes() ?>>
			<span id="el_t01_penerimaan_Nominal">
<input type="text" data-table="t01_penerimaan" data-field="x_Nominal" name="x_Nominal" id="x_Nominal" size="30" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Nominal->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Nominal->EditValue ?>"<?php echo $t01_penerimaan->Nominal->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->JumlahSiswa->Visible) { // JumlahSiswa ?>
	<div id="r_JumlahSiswa" class="form-group">
		<label for="x_JumlahSiswa" class="<?php echo $t01_penerimaan_search->LeftColumnClass ?>"><span id="elh_t01_penerimaan_JumlahSiswa"><?php echo $t01_penerimaan->JumlahSiswa->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_JumlahSiswa" id="z_JumlahSiswa" value="="></p>
		</label>
		<div class="<?php echo $t01_penerimaan_search->RightColumnClass ?>"><div<?php echo $t01_penerimaan->JumlahSiswa->CellAttributes() ?>>
			<span id="el_t01_penerimaan_JumlahSiswa">
<input type="text" data-table="t01_penerimaan" data-field="x_JumlahSiswa" name="x_JumlahSiswa" id="x_JumlahSiswa" size="30" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->JumlahSiswa->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->JumlahSiswa->EditValue ?>"<?php echo $t01_penerimaan->JumlahSiswa->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Bulan->Visible) { // Bulan ?>
	<div id="r_Bulan" class="form-group">
		<label for="x_Bulan" class="<?php echo $t01_penerimaan_search->LeftColumnClass ?>"><span id="elh_t01_penerimaan_Bulan"><?php echo $t01_penerimaan->Bulan->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Bulan" id="z_Bulan" value="="></p>
		</label>
		<div class="<?php echo $t01_penerimaan_search->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Bulan->CellAttributes() ?>>
			<span id="el_t01_penerimaan_Bulan">
<input type="text" data-table="t01_penerimaan" data-field="x_Bulan" name="x_Bulan" id="x_Bulan" size="30" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Bulan->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Bulan->EditValue ?>"<?php echo $t01_penerimaan->Bulan->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Jumlah->Visible) { // Jumlah ?>
	<div id="r_Jumlah" class="form-group">
		<label for="x_Jumlah" class="<?php echo $t01_penerimaan_search->LeftColumnClass ?>"><span id="elh_t01_penerimaan_Jumlah"><?php echo $t01_penerimaan->Jumlah->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Jumlah" id="z_Jumlah" value="="></p>
		</label>
		<div class="<?php echo $t01_penerimaan_search->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Jumlah->CellAttributes() ?>>
			<span id="el_t01_penerimaan_Jumlah">
<input type="text" data-table="t01_penerimaan" data-field="x_Jumlah" name="x_Jumlah" id="x_Jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Jumlah->EditValue ?>"<?php echo $t01_penerimaan->Jumlah->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t01_penerimaan->Total->Visible) { // Total ?>
	<div id="r_Total" class="form-group">
		<label for="x_Total" class="<?php echo $t01_penerimaan_search->LeftColumnClass ?>"><span id="elh_t01_penerimaan_Total"><?php echo $t01_penerimaan->Total->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_Total" id="z_Total" value="="></p>
		</label>
		<div class="<?php echo $t01_penerimaan_search->RightColumnClass ?>"><div<?php echo $t01_penerimaan->Total->CellAttributes() ?>>
			<span id="el_t01_penerimaan_Total">
<input type="text" data-table="t01_penerimaan" data-field="x_Total" name="x_Total" id="x_Total" size="30" placeholder="<?php echo ew_HtmlEncode($t01_penerimaan->Total->getPlaceHolder()) ?>" value="<?php echo $t01_penerimaan->Total->EditValue ?>"<?php echo $t01_penerimaan->Total->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$t01_penerimaan_search->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t01_penerimaan_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft01_penerimaansearch.Init();
</script>
<?php
$t01_penerimaan_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t01_penerimaan_search->Page_Terminate();
?>
