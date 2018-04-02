<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t03_rpuinfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t03_rpu_add = NULL; // Initialize page object first

class ct03_rpu_add extends ct03_rpu {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}';

	// Table name
	var $TableName = 't03_rpu';

	// Page object name
	var $PageObjName = 't03_rpu_add';

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
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t03_rpu)
		if (!isset($GLOBALS["t03_rpu"]) || get_class($GLOBALS["t03_rpu"]) == "ct03_rpu") {
			$GLOBALS["t03_rpu"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t03_rpu"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't03_rpu', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t03_rpulist.php"));
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
		$this->Level->SetVisibility();
		$this->Urutan->SetVisibility();
		$this->No_Urut->SetVisibility();
		$this->Keterangan->SetVisibility();
		$this->Volume->SetVisibility();
		$this->Alokasi->SetVisibility();
		$this->Unit_KOS->SetVisibility();
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
		global $EW_EXPORT, $t03_rpu;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t03_rpu);
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
					if ($pageName == "t03_rpuview.php")
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
					$this->Page_Terminate("t03_rpulist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t03_rpulist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t03_rpuview.php")
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
		$this->Level->CurrentValue = NULL;
		$this->Level->OldValue = $this->Level->CurrentValue;
		$this->Urutan->CurrentValue = NULL;
		$this->Urutan->OldValue = $this->Urutan->CurrentValue;
		$this->No_Urut->CurrentValue = NULL;
		$this->No_Urut->OldValue = $this->No_Urut->CurrentValue;
		$this->Keterangan->CurrentValue = NULL;
		$this->Keterangan->OldValue = $this->Keterangan->CurrentValue;
		$this->Volume->CurrentValue = 0.00;
		$this->Alokasi->CurrentValue = 0.00;
		$this->Unit_KOS->CurrentValue = 0.00;
		$this->Jumlah->CurrentValue = 0.00;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Level->FldIsDetailKey) {
			$this->Level->setFormValue($objForm->GetValue("x_Level"));
		}
		if (!$this->Urutan->FldIsDetailKey) {
			$this->Urutan->setFormValue($objForm->GetValue("x_Urutan"));
		}
		if (!$this->No_Urut->FldIsDetailKey) {
			$this->No_Urut->setFormValue($objForm->GetValue("x_No_Urut"));
		}
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
		}
		if (!$this->Volume->FldIsDetailKey) {
			$this->Volume->setFormValue($objForm->GetValue("x_Volume"));
		}
		if (!$this->Alokasi->FldIsDetailKey) {
			$this->Alokasi->setFormValue($objForm->GetValue("x_Alokasi"));
		}
		if (!$this->Unit_KOS->FldIsDetailKey) {
			$this->Unit_KOS->setFormValue($objForm->GetValue("x_Unit_KOS"));
		}
		if (!$this->Jumlah->FldIsDetailKey) {
			$this->Jumlah->setFormValue($objForm->GetValue("x_Jumlah"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Level->CurrentValue = $this->Level->FormValue;
		$this->Urutan->CurrentValue = $this->Urutan->FormValue;
		$this->No_Urut->CurrentValue = $this->No_Urut->FormValue;
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
		$this->Volume->CurrentValue = $this->Volume->FormValue;
		$this->Alokasi->CurrentValue = $this->Alokasi->FormValue;
		$this->Unit_KOS->CurrentValue = $this->Unit_KOS->FormValue;
		$this->Jumlah->CurrentValue = $this->Jumlah->FormValue;
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
		$this->Level->setDbValue($row['Level']);
		$this->Urutan->setDbValue($row['Urutan']);
		$this->No_Urut->setDbValue($row['No_Urut']);
		$this->Keterangan->setDbValue($row['Keterangan']);
		$this->Volume->setDbValue($row['Volume']);
		$this->Alokasi->setDbValue($row['Alokasi']);
		$this->Unit_KOS->setDbValue($row['Unit_KOS']);
		$this->Jumlah->setDbValue($row['Jumlah']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['Level'] = $this->Level->CurrentValue;
		$row['Urutan'] = $this->Urutan->CurrentValue;
		$row['No_Urut'] = $this->No_Urut->CurrentValue;
		$row['Keterangan'] = $this->Keterangan->CurrentValue;
		$row['Volume'] = $this->Volume->CurrentValue;
		$row['Alokasi'] = $this->Alokasi->CurrentValue;
		$row['Unit_KOS'] = $this->Unit_KOS->CurrentValue;
		$row['Jumlah'] = $this->Jumlah->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->Level->DbValue = $row['Level'];
		$this->Urutan->DbValue = $row['Urutan'];
		$this->No_Urut->DbValue = $row['No_Urut'];
		$this->Keterangan->DbValue = $row['Keterangan'];
		$this->Volume->DbValue = $row['Volume'];
		$this->Alokasi->DbValue = $row['Alokasi'];
		$this->Unit_KOS->DbValue = $row['Unit_KOS'];
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
		// Convert decimal values if posted back

		if ($this->Volume->FormValue == $this->Volume->CurrentValue && is_numeric(ew_StrToFloat($this->Volume->CurrentValue)))
			$this->Volume->CurrentValue = ew_StrToFloat($this->Volume->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Alokasi->FormValue == $this->Alokasi->CurrentValue && is_numeric(ew_StrToFloat($this->Alokasi->CurrentValue)))
			$this->Alokasi->CurrentValue = ew_StrToFloat($this->Alokasi->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Unit_KOS->FormValue == $this->Unit_KOS->CurrentValue && is_numeric(ew_StrToFloat($this->Unit_KOS->CurrentValue)))
			$this->Unit_KOS->CurrentValue = ew_StrToFloat($this->Unit_KOS->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Jumlah->FormValue == $this->Jumlah->CurrentValue && is_numeric(ew_StrToFloat($this->Jumlah->CurrentValue)))
			$this->Jumlah->CurrentValue = ew_StrToFloat($this->Jumlah->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// Level
		// Urutan
		// No_Urut
		// Keterangan
		// Volume
		// Alokasi
		// Unit_KOS
		// Jumlah

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// Level
		$this->Level->ViewValue = $this->Level->CurrentValue;
		$this->Level->ViewCustomAttributes = "";

		// Urutan
		$this->Urutan->ViewValue = $this->Urutan->CurrentValue;
		$this->Urutan->ViewCustomAttributes = "";

		// No_Urut
		$this->No_Urut->ViewValue = $this->No_Urut->CurrentValue;
		$this->No_Urut->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

		// Volume
		$this->Volume->ViewValue = $this->Volume->CurrentValue;
		$this->Volume->ViewCustomAttributes = "";

		// Alokasi
		$this->Alokasi->ViewValue = $this->Alokasi->CurrentValue;
		$this->Alokasi->ViewCustomAttributes = "";

		// Unit_KOS
		$this->Unit_KOS->ViewValue = $this->Unit_KOS->CurrentValue;
		$this->Unit_KOS->ViewCustomAttributes = "";

		// Jumlah
		$this->Jumlah->ViewValue = $this->Jumlah->CurrentValue;
		$this->Jumlah->ViewCustomAttributes = "";

			// Level
			$this->Level->LinkCustomAttributes = "";
			$this->Level->HrefValue = "";
			$this->Level->TooltipValue = "";

			// Urutan
			$this->Urutan->LinkCustomAttributes = "";
			$this->Urutan->HrefValue = "";
			$this->Urutan->TooltipValue = "";

			// No_Urut
			$this->No_Urut->LinkCustomAttributes = "";
			$this->No_Urut->HrefValue = "";
			$this->No_Urut->TooltipValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
			$this->Keterangan->TooltipValue = "";

			// Volume
			$this->Volume->LinkCustomAttributes = "";
			$this->Volume->HrefValue = "";
			$this->Volume->TooltipValue = "";

			// Alokasi
			$this->Alokasi->LinkCustomAttributes = "";
			$this->Alokasi->HrefValue = "";
			$this->Alokasi->TooltipValue = "";

			// Unit_KOS
			$this->Unit_KOS->LinkCustomAttributes = "";
			$this->Unit_KOS->HrefValue = "";
			$this->Unit_KOS->TooltipValue = "";

			// Jumlah
			$this->Jumlah->LinkCustomAttributes = "";
			$this->Jumlah->HrefValue = "";
			$this->Jumlah->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Level
			$this->Level->EditAttrs["class"] = "form-control";
			$this->Level->EditCustomAttributes = "";
			$this->Level->EditValue = ew_HtmlEncode($this->Level->CurrentValue);
			$this->Level->PlaceHolder = ew_RemoveHtml($this->Level->FldCaption());

			// Urutan
			$this->Urutan->EditAttrs["class"] = "form-control";
			$this->Urutan->EditCustomAttributes = "";
			$this->Urutan->EditValue = ew_HtmlEncode($this->Urutan->CurrentValue);
			$this->Urutan->PlaceHolder = ew_RemoveHtml($this->Urutan->FldCaption());

			// No_Urut
			$this->No_Urut->EditAttrs["class"] = "form-control";
			$this->No_Urut->EditCustomAttributes = "";
			$this->No_Urut->EditValue = ew_HtmlEncode($this->No_Urut->CurrentValue);
			$this->No_Urut->PlaceHolder = ew_RemoveHtml($this->No_Urut->FldCaption());

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// Volume
			$this->Volume->EditAttrs["class"] = "form-control";
			$this->Volume->EditCustomAttributes = "";
			$this->Volume->EditValue = ew_HtmlEncode($this->Volume->CurrentValue);
			$this->Volume->PlaceHolder = ew_RemoveHtml($this->Volume->FldCaption());
			if (strval($this->Volume->EditValue) <> "" && is_numeric($this->Volume->EditValue)) $this->Volume->EditValue = ew_FormatNumber($this->Volume->EditValue, -2, -1, -2, 0);

			// Alokasi
			$this->Alokasi->EditAttrs["class"] = "form-control";
			$this->Alokasi->EditCustomAttributes = "";
			$this->Alokasi->EditValue = ew_HtmlEncode($this->Alokasi->CurrentValue);
			$this->Alokasi->PlaceHolder = ew_RemoveHtml($this->Alokasi->FldCaption());
			if (strval($this->Alokasi->EditValue) <> "" && is_numeric($this->Alokasi->EditValue)) $this->Alokasi->EditValue = ew_FormatNumber($this->Alokasi->EditValue, -2, -1, -2, 0);

			// Unit_KOS
			$this->Unit_KOS->EditAttrs["class"] = "form-control";
			$this->Unit_KOS->EditCustomAttributes = "";
			$this->Unit_KOS->EditValue = ew_HtmlEncode($this->Unit_KOS->CurrentValue);
			$this->Unit_KOS->PlaceHolder = ew_RemoveHtml($this->Unit_KOS->FldCaption());
			if (strval($this->Unit_KOS->EditValue) <> "" && is_numeric($this->Unit_KOS->EditValue)) $this->Unit_KOS->EditValue = ew_FormatNumber($this->Unit_KOS->EditValue, -2, -1, -2, 0);

			// Jumlah
			$this->Jumlah->EditAttrs["class"] = "form-control";
			$this->Jumlah->EditCustomAttributes = "";
			$this->Jumlah->EditValue = ew_HtmlEncode($this->Jumlah->CurrentValue);
			$this->Jumlah->PlaceHolder = ew_RemoveHtml($this->Jumlah->FldCaption());
			if (strval($this->Jumlah->EditValue) <> "" && is_numeric($this->Jumlah->EditValue)) $this->Jumlah->EditValue = ew_FormatNumber($this->Jumlah->EditValue, -2, -1, -2, 0);

			// Add refer script
			// Level

			$this->Level->LinkCustomAttributes = "";
			$this->Level->HrefValue = "";

			// Urutan
			$this->Urutan->LinkCustomAttributes = "";
			$this->Urutan->HrefValue = "";

			// No_Urut
			$this->No_Urut->LinkCustomAttributes = "";
			$this->No_Urut->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";

			// Volume
			$this->Volume->LinkCustomAttributes = "";
			$this->Volume->HrefValue = "";

			// Alokasi
			$this->Alokasi->LinkCustomAttributes = "";
			$this->Alokasi->HrefValue = "";

			// Unit_KOS
			$this->Unit_KOS->LinkCustomAttributes = "";
			$this->Unit_KOS->HrefValue = "";

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
		if (!$this->Level->FldIsDetailKey && !is_null($this->Level->FormValue) && $this->Level->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Level->FldCaption(), $this->Level->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Level->FormValue)) {
			ew_AddMessage($gsFormError, $this->Level->FldErrMsg());
		}
		if (!$this->Urutan->FldIsDetailKey && !is_null($this->Urutan->FormValue) && $this->Urutan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Urutan->FldCaption(), $this->Urutan->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Urutan->FormValue)) {
			ew_AddMessage($gsFormError, $this->Urutan->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Volume->FormValue)) {
			ew_AddMessage($gsFormError, $this->Volume->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Alokasi->FormValue)) {
			ew_AddMessage($gsFormError, $this->Alokasi->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Unit_KOS->FormValue)) {
			ew_AddMessage($gsFormError, $this->Unit_KOS->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// Level
		$this->Level->SetDbValueDef($rsnew, $this->Level->CurrentValue, 0, FALSE);

		// Urutan
		$this->Urutan->SetDbValueDef($rsnew, $this->Urutan->CurrentValue, 0, FALSE);

		// No_Urut
		$this->No_Urut->SetDbValueDef($rsnew, $this->No_Urut->CurrentValue, NULL, FALSE);

		// Keterangan
		$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, FALSE);

		// Volume
		$this->Volume->SetDbValueDef($rsnew, $this->Volume->CurrentValue, 0, strval($this->Volume->CurrentValue) == "");

		// Alokasi
		$this->Alokasi->SetDbValueDef($rsnew, $this->Alokasi->CurrentValue, 0, strval($this->Alokasi->CurrentValue) == "");

		// Unit_KOS
		$this->Unit_KOS->SetDbValueDef($rsnew, $this->Unit_KOS->CurrentValue, 0, strval($this->Unit_KOS->CurrentValue) == "");

		// Jumlah
		$this->Jumlah->SetDbValueDef($rsnew, $this->Jumlah->CurrentValue, NULL, strval($this->Jumlah->CurrentValue) == "");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t03_rpulist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($t03_rpu_add)) $t03_rpu_add = new ct03_rpu_add();

// Page init
$t03_rpu_add->Page_Init();

// Page main
$t03_rpu_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t03_rpu_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft03_rpuadd = new ew_Form("ft03_rpuadd", "add");

// Validate form
ft03_rpuadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Level");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_rpu->Level->FldCaption(), $t03_rpu->Level->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Level");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_rpu->Level->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Urutan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_rpu->Urutan->FldCaption(), $t03_rpu->Urutan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Urutan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_rpu->Urutan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Volume");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_rpu->Volume->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Alokasi");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_rpu->Alokasi->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Unit_KOS");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_rpu->Unit_KOS->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_rpu->Jumlah->FldErrMsg()) ?>");

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
ft03_rpuadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft03_rpuadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t03_rpu_add->ShowPageHeader(); ?>
<?php
$t03_rpu_add->ShowMessage();
?>
<form name="ft03_rpuadd" id="ft03_rpuadd" class="<?php echo $t03_rpu_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t03_rpu_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t03_rpu_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t03_rpu">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($t03_rpu_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($t03_rpu->Level->Visible) { // Level ?>
	<div id="r_Level" class="form-group">
		<label id="elh_t03_rpu_Level" for="x_Level" class="<?php echo $t03_rpu_add->LeftColumnClass ?>"><?php echo $t03_rpu->Level->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t03_rpu_add->RightColumnClass ?>"><div<?php echo $t03_rpu->Level->CellAttributes() ?>>
<span id="el_t03_rpu_Level">
<input type="text" data-table="t03_rpu" data-field="x_Level" name="x_Level" id="x_Level" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Level->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Level->EditValue ?>"<?php echo $t03_rpu->Level->EditAttributes() ?>>
</span>
<?php echo $t03_rpu->Level->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_rpu->Urutan->Visible) { // Urutan ?>
	<div id="r_Urutan" class="form-group">
		<label id="elh_t03_rpu_Urutan" for="x_Urutan" class="<?php echo $t03_rpu_add->LeftColumnClass ?>"><?php echo $t03_rpu->Urutan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t03_rpu_add->RightColumnClass ?>"><div<?php echo $t03_rpu->Urutan->CellAttributes() ?>>
<span id="el_t03_rpu_Urutan">
<input type="text" data-table="t03_rpu" data-field="x_Urutan" name="x_Urutan" id="x_Urutan" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Urutan->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Urutan->EditValue ?>"<?php echo $t03_rpu->Urutan->EditAttributes() ?>>
</span>
<?php echo $t03_rpu->Urutan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_rpu->No_Urut->Visible) { // No_Urut ?>
	<div id="r_No_Urut" class="form-group">
		<label id="elh_t03_rpu_No_Urut" for="x_No_Urut" class="<?php echo $t03_rpu_add->LeftColumnClass ?>"><?php echo $t03_rpu->No_Urut->FldCaption() ?></label>
		<div class="<?php echo $t03_rpu_add->RightColumnClass ?>"><div<?php echo $t03_rpu->No_Urut->CellAttributes() ?>>
<span id="el_t03_rpu_No_Urut">
<input type="text" data-table="t03_rpu" data-field="x_No_Urut" name="x_No_Urut" id="x_No_Urut" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->No_Urut->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->No_Urut->EditValue ?>"<?php echo $t03_rpu->No_Urut->EditAttributes() ?>>
</span>
<?php echo $t03_rpu->No_Urut->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_rpu->Keterangan->Visible) { // Keterangan ?>
	<div id="r_Keterangan" class="form-group">
		<label id="elh_t03_rpu_Keterangan" for="x_Keterangan" class="<?php echo $t03_rpu_add->LeftColumnClass ?>"><?php echo $t03_rpu->Keterangan->FldCaption() ?></label>
		<div class="<?php echo $t03_rpu_add->RightColumnClass ?>"><div<?php echo $t03_rpu->Keterangan->CellAttributes() ?>>
<span id="el_t03_rpu_Keterangan">
<input type="text" data-table="t03_rpu" data-field="x_Keterangan" name="x_Keterangan" id="x_Keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Keterangan->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Keterangan->EditValue ?>"<?php echo $t03_rpu->Keterangan->EditAttributes() ?>>
</span>
<?php echo $t03_rpu->Keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_rpu->Volume->Visible) { // Volume ?>
	<div id="r_Volume" class="form-group">
		<label id="elh_t03_rpu_Volume" for="x_Volume" class="<?php echo $t03_rpu_add->LeftColumnClass ?>"><?php echo $t03_rpu->Volume->FldCaption() ?></label>
		<div class="<?php echo $t03_rpu_add->RightColumnClass ?>"><div<?php echo $t03_rpu->Volume->CellAttributes() ?>>
<span id="el_t03_rpu_Volume">
<input type="text" data-table="t03_rpu" data-field="x_Volume" name="x_Volume" id="x_Volume" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Volume->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Volume->EditValue ?>"<?php echo $t03_rpu->Volume->EditAttributes() ?>>
</span>
<?php echo $t03_rpu->Volume->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_rpu->Alokasi->Visible) { // Alokasi ?>
	<div id="r_Alokasi" class="form-group">
		<label id="elh_t03_rpu_Alokasi" for="x_Alokasi" class="<?php echo $t03_rpu_add->LeftColumnClass ?>"><?php echo $t03_rpu->Alokasi->FldCaption() ?></label>
		<div class="<?php echo $t03_rpu_add->RightColumnClass ?>"><div<?php echo $t03_rpu->Alokasi->CellAttributes() ?>>
<span id="el_t03_rpu_Alokasi">
<input type="text" data-table="t03_rpu" data-field="x_Alokasi" name="x_Alokasi" id="x_Alokasi" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Alokasi->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Alokasi->EditValue ?>"<?php echo $t03_rpu->Alokasi->EditAttributes() ?>>
</span>
<?php echo $t03_rpu->Alokasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_rpu->Unit_KOS->Visible) { // Unit_KOS ?>
	<div id="r_Unit_KOS" class="form-group">
		<label id="elh_t03_rpu_Unit_KOS" for="x_Unit_KOS" class="<?php echo $t03_rpu_add->LeftColumnClass ?>"><?php echo $t03_rpu->Unit_KOS->FldCaption() ?></label>
		<div class="<?php echo $t03_rpu_add->RightColumnClass ?>"><div<?php echo $t03_rpu->Unit_KOS->CellAttributes() ?>>
<span id="el_t03_rpu_Unit_KOS">
<input type="text" data-table="t03_rpu" data-field="x_Unit_KOS" name="x_Unit_KOS" id="x_Unit_KOS" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Unit_KOS->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Unit_KOS->EditValue ?>"<?php echo $t03_rpu->Unit_KOS->EditAttributes() ?>>
</span>
<?php echo $t03_rpu->Unit_KOS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t03_rpu->Jumlah->Visible) { // Jumlah ?>
	<div id="r_Jumlah" class="form-group">
		<label id="elh_t03_rpu_Jumlah" for="x_Jumlah" class="<?php echo $t03_rpu_add->LeftColumnClass ?>"><?php echo $t03_rpu->Jumlah->FldCaption() ?></label>
		<div class="<?php echo $t03_rpu_add->RightColumnClass ?>"><div<?php echo $t03_rpu->Jumlah->CellAttributes() ?>>
<span id="el_t03_rpu_Jumlah">
<input type="text" data-table="t03_rpu" data-field="x_Jumlah" name="x_Jumlah" id="x_Jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Jumlah->EditValue ?>"<?php echo $t03_rpu->Jumlah->EditAttributes() ?>>
</span>
<?php echo $t03_rpu->Jumlah->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$t03_rpu_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t03_rpu_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t03_rpu_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft03_rpuadd.Init();
</script>
<?php
$t03_rpu_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t03_rpu_add->Page_Terminate();
?>
