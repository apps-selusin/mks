<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t05_rkas04info.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t05_rkas04_search = NULL; // Initialize page object first

class ct05_rkas04_search extends ct05_rkas04 {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}';

	// Table name
	var $TableName = 't05_rkas04';

	// Page object name
	var $PageObjName = 't05_rkas04_search';

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
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;

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
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t05_rkas04)
		if (!isset($GLOBALS["t05_rkas04"]) || get_class($GLOBALS["t05_rkas04"]) == "ct05_rkas04") {
			$GLOBALS["t05_rkas04"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t05_rkas04"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't05_rkas04', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

		// User table object (t96_employees)
		if (!isset($UserTable)) {
			$UserTable = new ct96_employees();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanSearch()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("t05_rkas04list.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->lv3_id->SetVisibility();
		$this->no_urut->SetVisibility();
		$this->keterangan->SetVisibility();
		$this->jumlah->SetVisibility();

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
		global $EW_EXPORT, $t05_rkas04;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t05_rkas04);
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
					if ($pageName == "t05_rkas04view.php")
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
						$sSrchStr = "t05_rkas04list.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->lv3_id); // lv3_id
		$this->BuildSearchUrl($sSrchUrl, $this->no_urut); // no_urut
		$this->BuildSearchUrl($sSrchUrl, $this->keterangan); // keterangan
		$this->BuildSearchUrl($sSrchUrl, $this->jumlah); // jumlah
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

		// lv3_id
		$this->lv3_id->AdvancedSearch->SearchValue = $objForm->GetValue("x_lv3_id");
		$this->lv3_id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_lv3_id");

		// no_urut
		$this->no_urut->AdvancedSearch->SearchValue = $objForm->GetValue("x_no_urut");
		$this->no_urut->AdvancedSearch->SearchOperator = $objForm->GetValue("z_no_urut");

		// keterangan
		$this->keterangan->AdvancedSearch->SearchValue = $objForm->GetValue("x_keterangan");
		$this->keterangan->AdvancedSearch->SearchOperator = $objForm->GetValue("z_keterangan");

		// jumlah
		$this->jumlah->AdvancedSearch->SearchValue = $objForm->GetValue("x_jumlah");
		$this->jumlah->AdvancedSearch->SearchOperator = $objForm->GetValue("z_jumlah");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->jumlah->FormValue == $this->jumlah->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah->CurrentValue)))
			$this->jumlah->CurrentValue = ew_StrToFloat($this->jumlah->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// lv1_id
		// lv2_id
		// lv3_id
		// no_urut
		// keterangan
		// jumlah

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// lv1_id
		if ($this->lv1_id->VirtualValue <> "") {
			$this->lv1_id->ViewValue = $this->lv1_id->VirtualValue;
		} else {
			$this->lv1_id->ViewValue = $this->lv1_id->CurrentValue;
		if (strval($this->lv1_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->lv1_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_urut` AS `DispFld`, `keterangan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t02_rkas01`";
		$sWhereWrk = "";
		$this->lv1_id->LookupFilters = array("dx1" => '`no_urut`', "dx2" => '`keterangan`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->lv1_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->lv1_id->ViewValue = $this->lv1_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->lv1_id->ViewValue = $this->lv1_id->CurrentValue;
			}
		} else {
			$this->lv1_id->ViewValue = NULL;
		}
		}
		$this->lv1_id->ViewCustomAttributes = "";

		// lv2_id
		if ($this->lv2_id->VirtualValue <> "") {
			$this->lv2_id->ViewValue = $this->lv2_id->VirtualValue;
		} else {
			$this->lv2_id->ViewValue = $this->lv2_id->CurrentValue;
		if (strval($this->lv2_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->lv2_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_urut` AS `DispFld`, `keterangan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t03_rkas02`";
		$sWhereWrk = "";
		$this->lv2_id->LookupFilters = array("dx1" => '`no_urut`', "dx2" => '`keterangan`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->lv2_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->lv2_id->ViewValue = $this->lv2_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->lv2_id->ViewValue = $this->lv2_id->CurrentValue;
			}
		} else {
			$this->lv2_id->ViewValue = NULL;
		}
		}
		$this->lv2_id->ViewCustomAttributes = "";

		// lv3_id
		if ($this->lv3_id->VirtualValue <> "") {
			$this->lv3_id->ViewValue = $this->lv3_id->VirtualValue;
		} else {
			$this->lv3_id->ViewValue = $this->lv3_id->CurrentValue;
		if (strval($this->lv3_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->lv3_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_urut` AS `DispFld`, `keterangan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t04_rkas03`";
		$sWhereWrk = "";
		$this->lv3_id->LookupFilters = array("dx1" => '`no_urut`', "dx2" => '`keterangan`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->lv3_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->lv3_id->ViewValue = $this->lv3_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->lv3_id->ViewValue = $this->lv3_id->CurrentValue;
			}
		} else {
			$this->lv3_id->ViewValue = NULL;
		}
		}
		$this->lv3_id->ViewCustomAttributes = "";

		// no_urut
		$this->no_urut->ViewValue = $this->no_urut->CurrentValue;
		$this->no_urut->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// jumlah
		$this->jumlah->ViewValue = $this->jumlah->CurrentValue;
		$this->jumlah->ViewValue = ew_FormatNumber($this->jumlah->ViewValue, 2, -2, -2, -2);
		$this->jumlah->CellCssStyle .= "text-align: right;";
		$this->jumlah->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// lv3_id
			$this->lv3_id->LinkCustomAttributes = "";
			$this->lv3_id->HrefValue = "";
			$this->lv3_id->TooltipValue = "";

			// no_urut
			$this->no_urut->LinkCustomAttributes = "";
			$this->no_urut->HrefValue = "";
			$this->no_urut->TooltipValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";

			// jumlah
			$this->jumlah->LinkCustomAttributes = "";
			$this->jumlah->HrefValue = "";
			$this->jumlah->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = ew_HtmlEncode($this->id->AdvancedSearch->SearchValue);
			$this->id->PlaceHolder = ew_RemoveHtml($this->id->FldCaption());

			// lv3_id
			$this->lv3_id->EditAttrs["class"] = "form-control";
			$this->lv3_id->EditCustomAttributes = "";
			$this->lv3_id->EditValue = ew_HtmlEncode($this->lv3_id->AdvancedSearch->SearchValue);
			$this->lv3_id->PlaceHolder = ew_RemoveHtml($this->lv3_id->FldCaption());

			// no_urut
			$this->no_urut->EditAttrs["class"] = "form-control";
			$this->no_urut->EditCustomAttributes = "";
			$this->no_urut->EditValue = ew_HtmlEncode($this->no_urut->AdvancedSearch->SearchValue);
			$this->no_urut->PlaceHolder = ew_RemoveHtml($this->no_urut->FldCaption());

			// keterangan
			$this->keterangan->EditAttrs["class"] = "form-control";
			$this->keterangan->EditCustomAttributes = "";
			$this->keterangan->EditValue = ew_HtmlEncode($this->keterangan->AdvancedSearch->SearchValue);
			$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

			// jumlah
			$this->jumlah->EditAttrs["class"] = "form-control";
			$this->jumlah->EditCustomAttributes = "";
			$this->jumlah->EditValue = ew_HtmlEncode($this->jumlah->AdvancedSearch->SearchValue);
			$this->jumlah->PlaceHolder = ew_RemoveHtml($this->jumlah->FldCaption());
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
		if (!ew_CheckInteger($this->no_urut->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->no_urut->FldErrMsg());
		}
		if (!ew_CheckNumber($this->jumlah->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->jumlah->FldErrMsg());
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
		$this->lv3_id->AdvancedSearch->Load();
		$this->no_urut->AdvancedSearch->Load();
		$this->keterangan->AdvancedSearch->Load();
		$this->jumlah->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t05_rkas04list.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_lv3_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `no_urut` AS `DispFld`, `keterangan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t04_rkas03`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`no_urut`', "dx2" => '`keterangan`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->lv3_id, $sWhereWrk); // Call Lookup Selecting
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
		case "x_lv3_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id`, `no_urut` AS `DispFld`, `keterangan` AS `Disp2Fld` FROM `t04_rkas03`";
			$sWhereWrk = "`no_urut` LIKE '{query_value}%' OR CONCAT(COALESCE(`no_urut`, ''),'" . ew_ValueSeparator(1, $this->lv3_id) . "',COALESCE(`keterangan`,'')) LIKE '{query_value}%'";
			$fld->LookupFilters = array("dx1" => '`no_urut`', "dx2" => '`keterangan`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->lv3_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($t05_rkas04_search)) $t05_rkas04_search = new ct05_rkas04_search();

// Page init
$t05_rkas04_search->Page_Init();

// Page main
$t05_rkas04_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t05_rkas04_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($t05_rkas04_search->IsModal) { ?>
var CurrentAdvancedSearchForm = ft05_rkas04search = new ew_Form("ft05_rkas04search", "search");
<?php } else { ?>
var CurrentForm = ft05_rkas04search = new ew_Form("ft05_rkas04search", "search");
<?php } ?>

// Form_CustomValidate event
ft05_rkas04search.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft05_rkas04search.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft05_rkas04search.Lists["x_lv3_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_urut","x_keterangan","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t04_rkas03"};
ft05_rkas04search.Lists["x_lv3_id"].Data = "<?php echo $t05_rkas04_search->lv3_id->LookupFilterQuery(FALSE, "search") ?>";
ft05_rkas04search.AutoSuggests["x_lv3_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $t05_rkas04_search->lv3_id->LookupFilterQuery(TRUE, "search"))) ?>;

// Form object for search
// Validate function for search

ft05_rkas04search.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_id");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t05_rkas04->id->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_no_urut");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t05_rkas04->no_urut->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_jumlah");
	if (elm && !ew_CheckNumber(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t05_rkas04->jumlah->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t05_rkas04_search->ShowPageHeader(); ?>
<?php
$t05_rkas04_search->ShowMessage();
?>
<form name="ft05_rkas04search" id="ft05_rkas04search" class="<?php echo $t05_rkas04_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t05_rkas04_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t05_rkas04_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t05_rkas04">
<input type="hidden" name="a_search" id="a_search" value="S">
<input type="hidden" name="modal" value="<?php echo intval($t05_rkas04_search->IsModal) ?>">
<div class="ewSearchDiv"><!-- page* -->
<?php if ($t05_rkas04->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label for="x_id" class="<?php echo $t05_rkas04_search->LeftColumnClass ?>"><span id="elh_t05_rkas04_id"><?php echo $t05_rkas04->id->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_id" id="z_id" value="="></p>
		</label>
		<div class="<?php echo $t05_rkas04_search->RightColumnClass ?>"><div<?php echo $t05_rkas04->id->CellAttributes() ?>>
			<span id="el_t05_rkas04_id">
<input type="text" data-table="t05_rkas04" data-field="x_id" name="x_id" id="x_id" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->id->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->id->EditValue ?>"<?php echo $t05_rkas04->id->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t05_rkas04->lv3_id->Visible) { // lv3_id ?>
	<div id="r_lv3_id" class="form-group">
		<label class="<?php echo $t05_rkas04_search->LeftColumnClass ?>"><span id="elh_t05_rkas04_lv3_id"><?php echo $t05_rkas04->lv3_id->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_lv3_id" id="z_lv3_id" value="="></p>
		</label>
		<div class="<?php echo $t05_rkas04_search->RightColumnClass ?>"><div<?php echo $t05_rkas04->lv3_id->CellAttributes() ?>>
			<span id="el_t05_rkas04_lv3_id">
<?php
$wrkonchange = trim(" " . @$t05_rkas04->lv3_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t05_rkas04->lv3_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_lv3_id" style="white-space: nowrap; z-index: 8960">
	<input type="text" name="sv_x_lv3_id" id="sv_x_lv3_id" value="<?php echo $t05_rkas04->lv3_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->getPlaceHolder()) ?>"<?php echo $t05_rkas04->lv3_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv3_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t05_rkas04->lv3_id->DisplayValueSeparatorAttribute() ?>" name="x_lv3_id" id="x_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->AdvancedSearch->SearchValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft05_rkas04search.CreateAutoSuggest({"id":"x_lv3_id","forceSelect":false});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t05_rkas04->lv3_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_lv3_id',m:0,n:10,srch:true});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t05_rkas04->lv3_id->ReadOnly || $t05_rkas04->lv3_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t05_rkas04->no_urut->Visible) { // no_urut ?>
	<div id="r_no_urut" class="form-group">
		<label for="x_no_urut" class="<?php echo $t05_rkas04_search->LeftColumnClass ?>"><span id="elh_t05_rkas04_no_urut"><?php echo $t05_rkas04->no_urut->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_no_urut" id="z_no_urut" value="="></p>
		</label>
		<div class="<?php echo $t05_rkas04_search->RightColumnClass ?>"><div<?php echo $t05_rkas04->no_urut->CellAttributes() ?>>
			<span id="el_t05_rkas04_no_urut">
<input type="text" data-table="t05_rkas04" data-field="x_no_urut" name="x_no_urut" id="x_no_urut" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->no_urut->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->no_urut->EditValue ?>"<?php echo $t05_rkas04->no_urut->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t05_rkas04->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label for="x_keterangan" class="<?php echo $t05_rkas04_search->LeftColumnClass ?>"><span id="elh_t05_rkas04_keterangan"><?php echo $t05_rkas04->keterangan->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_keterangan" id="z_keterangan" value="LIKE"></p>
		</label>
		<div class="<?php echo $t05_rkas04_search->RightColumnClass ?>"><div<?php echo $t05_rkas04->keterangan->CellAttributes() ?>>
			<span id="el_t05_rkas04_keterangan">
<input type="text" data-table="t05_rkas04" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->keterangan->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->keterangan->EditValue ?>"<?php echo $t05_rkas04->keterangan->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t05_rkas04->jumlah->Visible) { // jumlah ?>
	<div id="r_jumlah" class="form-group">
		<label for="x_jumlah" class="<?php echo $t05_rkas04_search->LeftColumnClass ?>"><span id="elh_t05_rkas04_jumlah"><?php echo $t05_rkas04->jumlah->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_jumlah" id="z_jumlah" value="="></p>
		</label>
		<div class="<?php echo $t05_rkas04_search->RightColumnClass ?>"><div<?php echo $t05_rkas04->jumlah->CellAttributes() ?>>
			<span id="el_t05_rkas04_jumlah">
<input type="text" data-table="t05_rkas04" data-field="x_jumlah" name="x_jumlah" id="x_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->jumlah->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->jumlah->EditValue ?>"<?php echo $t05_rkas04->jumlah->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$t05_rkas04_search->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t05_rkas04_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft05_rkas04search.Init();
</script>
<?php
$t05_rkas04_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t05_rkas04_search->Page_Terminate();
?>
