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

$t05_rkas04_add = NULL; // Initialize page object first

class ct05_rkas04_add extends ct05_rkas04 {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}';

	// Table name
	var $TableName = 't05_rkas04';

	// Page object name
	var $PageObjName = 't05_rkas04_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
		$this->lv1_id->SetVisibility();
		$this->lv2_id->SetVisibility();
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
					$this->Page_Terminate("t05_rkas04list.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t05_rkas04list.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t05_rkas04view.php")
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
		$this->lv1_id->CurrentValue = NULL;
		$this->lv1_id->OldValue = $this->lv1_id->CurrentValue;
		$this->lv2_id->CurrentValue = NULL;
		$this->lv2_id->OldValue = $this->lv2_id->CurrentValue;
		$this->lv3_id->CurrentValue = NULL;
		$this->lv3_id->OldValue = $this->lv3_id->CurrentValue;
		$this->no_urut->CurrentValue = 0;
		$this->keterangan->CurrentValue = NULL;
		$this->keterangan->OldValue = $this->keterangan->CurrentValue;
		$this->jumlah->CurrentValue = 0.00;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->lv1_id->FldIsDetailKey) {
			$this->lv1_id->setFormValue($objForm->GetValue("x_lv1_id"));
		}
		if (!$this->lv2_id->FldIsDetailKey) {
			$this->lv2_id->setFormValue($objForm->GetValue("x_lv2_id"));
		}
		if (!$this->lv3_id->FldIsDetailKey) {
			$this->lv3_id->setFormValue($objForm->GetValue("x_lv3_id"));
		}
		if (!$this->no_urut->FldIsDetailKey) {
			$this->no_urut->setFormValue($objForm->GetValue("x_no_urut"));
		}
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
		if (!$this->jumlah->FldIsDetailKey) {
			$this->jumlah->setFormValue($objForm->GetValue("x_jumlah"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->lv1_id->CurrentValue = $this->lv1_id->FormValue;
		$this->lv2_id->CurrentValue = $this->lv2_id->FormValue;
		$this->lv3_id->CurrentValue = $this->lv3_id->FormValue;
		$this->no_urut->CurrentValue = $this->no_urut->FormValue;
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
		$this->jumlah->CurrentValue = $this->jumlah->FormValue;
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
		$this->lv1_id->setDbValue($row['lv1_id']);
		if (array_key_exists('EV__lv1_id', $rs->fields)) {
			$this->lv1_id->VirtualValue = $rs->fields('EV__lv1_id'); // Set up virtual field value
		} else {
			$this->lv1_id->VirtualValue = ""; // Clear value
		}
		$this->lv2_id->setDbValue($row['lv2_id']);
		if (array_key_exists('EV__lv2_id', $rs->fields)) {
			$this->lv2_id->VirtualValue = $rs->fields('EV__lv2_id'); // Set up virtual field value
		} else {
			$this->lv2_id->VirtualValue = ""; // Clear value
		}
		$this->lv3_id->setDbValue($row['lv3_id']);
		if (array_key_exists('EV__lv3_id', $rs->fields)) {
			$this->lv3_id->VirtualValue = $rs->fields('EV__lv3_id'); // Set up virtual field value
		} else {
			$this->lv3_id->VirtualValue = ""; // Clear value
		}
		$this->no_urut->setDbValue($row['no_urut']);
		$this->keterangan->setDbValue($row['keterangan']);
		$this->jumlah->setDbValue($row['jumlah']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['lv1_id'] = $this->lv1_id->CurrentValue;
		$row['lv2_id'] = $this->lv2_id->CurrentValue;
		$row['lv3_id'] = $this->lv3_id->CurrentValue;
		$row['no_urut'] = $this->no_urut->CurrentValue;
		$row['keterangan'] = $this->keterangan->CurrentValue;
		$row['jumlah'] = $this->jumlah->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->lv1_id->DbValue = $row['lv1_id'];
		$this->lv2_id->DbValue = $row['lv2_id'];
		$this->lv3_id->DbValue = $row['lv3_id'];
		$this->no_urut->DbValue = $row['no_urut'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->jumlah->DbValue = $row['jumlah'];
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

			// lv1_id
			$this->lv1_id->LinkCustomAttributes = "";
			$this->lv1_id->HrefValue = "";
			$this->lv1_id->TooltipValue = "";

			// lv2_id
			$this->lv2_id->LinkCustomAttributes = "";
			$this->lv2_id->HrefValue = "";
			$this->lv2_id->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// lv1_id
			$this->lv1_id->EditAttrs["class"] = "form-control";
			$this->lv1_id->EditCustomAttributes = "";
			$this->lv1_id->EditValue = ew_HtmlEncode($this->lv1_id->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->lv1_id->EditValue = $this->lv1_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->lv1_id->EditValue = ew_HtmlEncode($this->lv1_id->CurrentValue);
				}
			} else {
				$this->lv1_id->EditValue = NULL;
			}
			$this->lv1_id->PlaceHolder = ew_RemoveHtml($this->lv1_id->FldCaption());

			// lv2_id
			$this->lv2_id->EditAttrs["class"] = "form-control";
			$this->lv2_id->EditCustomAttributes = "";
			$this->lv2_id->EditValue = ew_HtmlEncode($this->lv2_id->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->lv2_id->EditValue = $this->lv2_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->lv2_id->EditValue = ew_HtmlEncode($this->lv2_id->CurrentValue);
				}
			} else {
				$this->lv2_id->EditValue = NULL;
			}
			$this->lv2_id->PlaceHolder = ew_RemoveHtml($this->lv2_id->FldCaption());

			// lv3_id
			$this->lv3_id->EditAttrs["class"] = "form-control";
			$this->lv3_id->EditCustomAttributes = "";
			$this->lv3_id->EditValue = ew_HtmlEncode($this->lv3_id->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->lv3_id->EditValue = $this->lv3_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->lv3_id->EditValue = ew_HtmlEncode($this->lv3_id->CurrentValue);
				}
			} else {
				$this->lv3_id->EditValue = NULL;
			}
			$this->lv3_id->PlaceHolder = ew_RemoveHtml($this->lv3_id->FldCaption());

			// no_urut
			$this->no_urut->EditAttrs["class"] = "form-control";
			$this->no_urut->EditCustomAttributes = "";
			$this->no_urut->EditValue = ew_HtmlEncode($this->no_urut->CurrentValue);
			$this->no_urut->PlaceHolder = ew_RemoveHtml($this->no_urut->FldCaption());

			// keterangan
			$this->keterangan->EditAttrs["class"] = "form-control";
			$this->keterangan->EditCustomAttributes = "";
			$this->keterangan->EditValue = ew_HtmlEncode($this->keterangan->CurrentValue);
			$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

			// jumlah
			$this->jumlah->EditAttrs["class"] = "form-control";
			$this->jumlah->EditCustomAttributes = "";
			$this->jumlah->EditValue = ew_HtmlEncode($this->jumlah->CurrentValue);
			$this->jumlah->PlaceHolder = ew_RemoveHtml($this->jumlah->FldCaption());
			if (strval($this->jumlah->EditValue) <> "" && is_numeric($this->jumlah->EditValue)) $this->jumlah->EditValue = ew_FormatNumber($this->jumlah->EditValue, -2, -2, -2, -2);

			// Add refer script
			// lv1_id

			$this->lv1_id->LinkCustomAttributes = "";
			$this->lv1_id->HrefValue = "";

			// lv2_id
			$this->lv2_id->LinkCustomAttributes = "";
			$this->lv2_id->HrefValue = "";

			// lv3_id
			$this->lv3_id->LinkCustomAttributes = "";
			$this->lv3_id->HrefValue = "";

			// no_urut
			$this->no_urut->LinkCustomAttributes = "";
			$this->no_urut->HrefValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";

			// jumlah
			$this->jumlah->LinkCustomAttributes = "";
			$this->jumlah->HrefValue = "";
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
		if (!$this->lv3_id->FldIsDetailKey && !is_null($this->lv3_id->FormValue) && $this->lv3_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->lv3_id->FldCaption(), $this->lv3_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->no_urut->FormValue)) {
			ew_AddMessage($gsFormError, $this->no_urut->FldErrMsg());
		}
		if (!$this->keterangan->FldIsDetailKey && !is_null($this->keterangan->FormValue) && $this->keterangan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->keterangan->FldCaption(), $this->keterangan->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->jumlah->FormValue)) {
			ew_AddMessage($gsFormError, $this->jumlah->FldErrMsg());
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

		// lv1_id
		$this->lv1_id->SetDbValueDef($rsnew, $this->lv1_id->CurrentValue, NULL, FALSE);

		// lv2_id
		$this->lv2_id->SetDbValueDef($rsnew, $this->lv2_id->CurrentValue, NULL, FALSE);

		// lv3_id
		$this->lv3_id->SetDbValueDef($rsnew, $this->lv3_id->CurrentValue, 0, FALSE);

		// no_urut
		$this->no_urut->SetDbValueDef($rsnew, $this->no_urut->CurrentValue, 0, strval($this->no_urut->CurrentValue) == "");

		// keterangan
		$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, "", FALSE);

		// jumlah
		$this->jumlah->SetDbValueDef($rsnew, $this->jumlah->CurrentValue, 0, strval($this->jumlah->CurrentValue) == "");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t05_rkas04list.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_lv1_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `no_urut` AS `DispFld`, `keterangan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t02_rkas01`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`no_urut`', "dx2" => '`keterangan`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->lv1_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_lv2_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `no_urut` AS `DispFld`, `keterangan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t03_rkas02`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`no_urut`', "dx2" => '`keterangan`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "", "f1" => '`lv1_id` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->lv2_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_lv3_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `no_urut` AS `DispFld`, `keterangan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t04_rkas03`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`no_urut`', "dx2" => '`keterangan`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "", "f1" => '`lv2_id` IN ({filter_value})', "t1" => "3", "fn1" => "");
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
		case "x_lv1_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id`, `no_urut` AS `DispFld`, `keterangan` AS `Disp2Fld` FROM `t02_rkas01`";
			$sWhereWrk = "`no_urut` LIKE '{query_value}%' OR CONCAT(COALESCE(`no_urut`, ''),'" . ew_ValueSeparator(1, $this->lv1_id) . "',COALESCE(`keterangan`,'')) LIKE '{query_value}%'";
			$fld->LookupFilters = array("dx1" => '`no_urut`', "dx2" => '`keterangan`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->lv1_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_lv2_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id`, `no_urut` AS `DispFld`, `keterangan` AS `Disp2Fld` FROM `t03_rkas02`";
			$sWhereWrk = "(`no_urut` LIKE '{query_value}%' OR CONCAT(COALESCE(`no_urut`, ''),'" . ew_ValueSeparator(1, $this->lv2_id) . "',COALESCE(`keterangan`,'')) LIKE '{query_value}%') AND ({filter})";
			$fld->LookupFilters = array("dx1" => '`no_urut`', "dx2" => '`keterangan`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f1" => "`lv1_id` IN ({filter_value})", "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->lv2_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_lv3_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id`, `no_urut` AS `DispFld`, `keterangan` AS `Disp2Fld` FROM `t04_rkas03`";
			$sWhereWrk = "(`no_urut` LIKE '{query_value}%' OR CONCAT(COALESCE(`no_urut`, ''),'" . ew_ValueSeparator(1, $this->lv3_id) . "',COALESCE(`keterangan`,'')) LIKE '{query_value}%') AND ({filter})";
			$fld->LookupFilters = array("dx1" => '`no_urut`', "dx2" => '`keterangan`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f1" => "`lv2_id` IN ({filter_value})", "t1" => "3", "fn1" => "");
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
if (!isset($t05_rkas04_add)) $t05_rkas04_add = new ct05_rkas04_add();

// Page init
$t05_rkas04_add->Page_Init();

// Page main
$t05_rkas04_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t05_rkas04_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft05_rkas04add = new ew_Form("ft05_rkas04add", "add");

// Validate form
ft05_rkas04add.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_lv3_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t05_rkas04->lv3_id->FldCaption(), $t05_rkas04->lv3_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_no_urut");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t05_rkas04->no_urut->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_keterangan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t05_rkas04->keterangan->FldCaption(), $t05_rkas04->keterangan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t05_rkas04->jumlah->FldErrMsg()) ?>");

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
ft05_rkas04add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft05_rkas04add.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft05_rkas04add.Lists["x_lv1_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_urut","x_keterangan","",""],"ParentFields":[],"ChildFields":["x_lv2_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t02_rkas01"};
ft05_rkas04add.Lists["x_lv1_id"].Data = "<?php echo $t05_rkas04_add->lv1_id->LookupFilterQuery(FALSE, "add") ?>";
ft05_rkas04add.AutoSuggests["x_lv1_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $t05_rkas04_add->lv1_id->LookupFilterQuery(TRUE, "add"))) ?>;
ft05_rkas04add.Lists["x_lv2_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_urut","x_keterangan","",""],"ParentFields":["x_lv1_id"],"ChildFields":["x_lv3_id"],"FilterFields":["x_lv1_id"],"Options":[],"Template":"","LinkTable":"t03_rkas02"};
ft05_rkas04add.Lists["x_lv2_id"].Data = "<?php echo $t05_rkas04_add->lv2_id->LookupFilterQuery(FALSE, "add") ?>";
ft05_rkas04add.AutoSuggests["x_lv2_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $t05_rkas04_add->lv2_id->LookupFilterQuery(TRUE, "add"))) ?>;
ft05_rkas04add.Lists["x_lv3_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_urut","x_keterangan","",""],"ParentFields":["x_lv2_id"],"ChildFields":[],"FilterFields":["x_lv2_id"],"Options":[],"Template":"","LinkTable":"t04_rkas03"};
ft05_rkas04add.Lists["x_lv3_id"].Data = "<?php echo $t05_rkas04_add->lv3_id->LookupFilterQuery(FALSE, "add") ?>";
ft05_rkas04add.AutoSuggests["x_lv3_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $t05_rkas04_add->lv3_id->LookupFilterQuery(TRUE, "add"))) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t05_rkas04_add->ShowPageHeader(); ?>
<?php
$t05_rkas04_add->ShowMessage();
?>
<form name="ft05_rkas04add" id="ft05_rkas04add" class="<?php echo $t05_rkas04_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t05_rkas04_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t05_rkas04_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t05_rkas04">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($t05_rkas04_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($t05_rkas04->lv1_id->Visible) { // lv1_id ?>
	<div id="r_lv1_id" class="form-group">
		<label id="elh_t05_rkas04_lv1_id" class="<?php echo $t05_rkas04_add->LeftColumnClass ?>"><?php echo $t05_rkas04->lv1_id->FldCaption() ?></label>
		<div class="<?php echo $t05_rkas04_add->RightColumnClass ?>"><div<?php echo $t05_rkas04->lv1_id->CellAttributes() ?>>
<span id="el_t05_rkas04_lv1_id">
<?php
$wrkonchange = trim("ew_UpdateOpt.call(this); " . @$t05_rkas04->lv1_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t05_rkas04->lv1_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_lv1_id" style="white-space: nowrap; z-index: 8980">
	<input type="text" name="sv_x_lv1_id" id="sv_x_lv1_id" value="<?php echo $t05_rkas04->lv1_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->getPlaceHolder()) ?>"<?php echo $t05_rkas04->lv1_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t05_rkas04->lv1_id->DisplayValueSeparatorAttribute() ?>" name="x_lv1_id" id="x_lv1_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft05_rkas04add.CreateAutoSuggest({"id":"x_lv1_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t05_rkas04->lv1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_lv1_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t05_rkas04->lv1_id->ReadOnly || $t05_rkas04->lv1_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php echo $t05_rkas04->lv1_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t05_rkas04->lv2_id->Visible) { // lv2_id ?>
	<div id="r_lv2_id" class="form-group">
		<label id="elh_t05_rkas04_lv2_id" class="<?php echo $t05_rkas04_add->LeftColumnClass ?>"><?php echo $t05_rkas04->lv2_id->FldCaption() ?></label>
		<div class="<?php echo $t05_rkas04_add->RightColumnClass ?>"><div<?php echo $t05_rkas04->lv2_id->CellAttributes() ?>>
<span id="el_t05_rkas04_lv2_id">
<?php
$wrkonchange = trim("ew_UpdateOpt.call(this); " . @$t05_rkas04->lv2_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t05_rkas04->lv2_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_lv2_id" style="white-space: nowrap; z-index: 8970">
	<input type="text" name="sv_x_lv2_id" id="sv_x_lv2_id" value="<?php echo $t05_rkas04->lv2_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->getPlaceHolder()) ?>"<?php echo $t05_rkas04->lv2_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv2_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t05_rkas04->lv2_id->DisplayValueSeparatorAttribute() ?>" name="x_lv2_id" id="x_lv2_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft05_rkas04add.CreateAutoSuggest({"id":"x_lv2_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t05_rkas04->lv2_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_lv2_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t05_rkas04->lv2_id->ReadOnly || $t05_rkas04->lv2_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php echo $t05_rkas04->lv2_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t05_rkas04->lv3_id->Visible) { // lv3_id ?>
	<div id="r_lv3_id" class="form-group">
		<label id="elh_t05_rkas04_lv3_id" class="<?php echo $t05_rkas04_add->LeftColumnClass ?>"><?php echo $t05_rkas04->lv3_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t05_rkas04_add->RightColumnClass ?>"><div<?php echo $t05_rkas04->lv3_id->CellAttributes() ?>>
<span id="el_t05_rkas04_lv3_id">
<?php
$wrkonchange = trim(" " . @$t05_rkas04->lv3_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t05_rkas04->lv3_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_lv3_id" style="white-space: nowrap; z-index: 8960">
	<input type="text" name="sv_x_lv3_id" id="sv_x_lv3_id" value="<?php echo $t05_rkas04->lv3_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->getPlaceHolder()) ?>"<?php echo $t05_rkas04->lv3_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv3_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t05_rkas04->lv3_id->DisplayValueSeparatorAttribute() ?>" name="x_lv3_id" id="x_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft05_rkas04add.CreateAutoSuggest({"id":"x_lv3_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t05_rkas04->lv3_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_lv3_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t05_rkas04->lv3_id->ReadOnly || $t05_rkas04->lv3_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php echo $t05_rkas04->lv3_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t05_rkas04->no_urut->Visible) { // no_urut ?>
	<div id="r_no_urut" class="form-group">
		<label id="elh_t05_rkas04_no_urut" for="x_no_urut" class="<?php echo $t05_rkas04_add->LeftColumnClass ?>"><?php echo $t05_rkas04->no_urut->FldCaption() ?></label>
		<div class="<?php echo $t05_rkas04_add->RightColumnClass ?>"><div<?php echo $t05_rkas04->no_urut->CellAttributes() ?>>
<span id="el_t05_rkas04_no_urut">
<input type="text" data-table="t05_rkas04" data-field="x_no_urut" name="x_no_urut" id="x_no_urut" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->no_urut->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->no_urut->EditValue ?>"<?php echo $t05_rkas04->no_urut->EditAttributes() ?>>
</span>
<?php echo $t05_rkas04->no_urut->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t05_rkas04->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_t05_rkas04_keterangan" for="x_keterangan" class="<?php echo $t05_rkas04_add->LeftColumnClass ?>"><?php echo $t05_rkas04->keterangan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t05_rkas04_add->RightColumnClass ?>"><div<?php echo $t05_rkas04->keterangan->CellAttributes() ?>>
<span id="el_t05_rkas04_keterangan">
<input type="text" data-table="t05_rkas04" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->keterangan->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->keterangan->EditValue ?>"<?php echo $t05_rkas04->keterangan->EditAttributes() ?>>
</span>
<?php echo $t05_rkas04->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t05_rkas04->jumlah->Visible) { // jumlah ?>
	<div id="r_jumlah" class="form-group">
		<label id="elh_t05_rkas04_jumlah" for="x_jumlah" class="<?php echo $t05_rkas04_add->LeftColumnClass ?>"><?php echo $t05_rkas04->jumlah->FldCaption() ?></label>
		<div class="<?php echo $t05_rkas04_add->RightColumnClass ?>"><div<?php echo $t05_rkas04->jumlah->CellAttributes() ?>>
<span id="el_t05_rkas04_jumlah">
<input type="text" data-table="t05_rkas04" data-field="x_jumlah" name="x_jumlah" id="x_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->jumlah->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->jumlah->EditValue ?>"<?php echo $t05_rkas04->jumlah->EditAttributes() ?>>
</span>
<?php echo $t05_rkas04->jumlah->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$t05_rkas04_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t05_rkas04_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t05_rkas04_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft05_rkas04add.Init();
</script>
<?php
$t05_rkas04_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t05_rkas04_add->Page_Terminate();
?>
