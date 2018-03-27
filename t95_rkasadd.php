<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t95_rkasinfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t95_rkas_add = NULL; // Initialize page object first

class ct95_rkas_add extends ct95_rkas {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}';

	// Table name
	var $TableName = 't95_rkas';

	// Page object name
	var $PageObjName = 't95_rkas_add';

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

		// Table object (t95_rkas)
		if (!isset($GLOBALS["t95_rkas"]) || get_class($GLOBALS["t95_rkas"]) == "ct95_rkas") {
			$GLOBALS["t95_rkas"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t95_rkas"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't95_rkas', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t95_rkaslist.php"));
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
		$this->kiri_tabel->SetVisibility();
		$this->kiri_id->SetVisibility();
		$this->kiri_lv2->SetVisibility();
		$this->kiri_lv3->SetVisibility();
		$this->kiri_lv4->SetVisibility();
		$this->kiri_jumlah->SetVisibility();
		$this->kanan_tabel->SetVisibility();
		$this->kanan_id->SetVisibility();
		$this->kanan_lv2->SetVisibility();
		$this->kanan_lv3->SetVisibility();
		$this->kanan_lv4->SetVisibility();
		$this->kanan_jumlah->SetVisibility();

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
		global $EW_EXPORT, $t95_rkas;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t95_rkas);
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
					if ($pageName == "t95_rkasview.php")
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
					$this->Page_Terminate("t95_rkaslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t95_rkaslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t95_rkasview.php")
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
		$this->kiri_tabel->CurrentValue = NULL;
		$this->kiri_tabel->OldValue = $this->kiri_tabel->CurrentValue;
		$this->kiri_id->CurrentValue = NULL;
		$this->kiri_id->OldValue = $this->kiri_id->CurrentValue;
		$this->kiri_lv2->CurrentValue = NULL;
		$this->kiri_lv2->OldValue = $this->kiri_lv2->CurrentValue;
		$this->kiri_lv3->CurrentValue = NULL;
		$this->kiri_lv3->OldValue = $this->kiri_lv3->CurrentValue;
		$this->kiri_lv4->CurrentValue = NULL;
		$this->kiri_lv4->OldValue = $this->kiri_lv4->CurrentValue;
		$this->kiri_jumlah->CurrentValue = 0.00;
		$this->kanan_tabel->CurrentValue = NULL;
		$this->kanan_tabel->OldValue = $this->kanan_tabel->CurrentValue;
		$this->kanan_id->CurrentValue = NULL;
		$this->kanan_id->OldValue = $this->kanan_id->CurrentValue;
		$this->kanan_lv2->CurrentValue = NULL;
		$this->kanan_lv2->OldValue = $this->kanan_lv2->CurrentValue;
		$this->kanan_lv3->CurrentValue = NULL;
		$this->kanan_lv3->OldValue = $this->kanan_lv3->CurrentValue;
		$this->kanan_lv4->CurrentValue = NULL;
		$this->kanan_lv4->OldValue = $this->kanan_lv4->CurrentValue;
		$this->kanan_jumlah->CurrentValue = 0.00;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->kiri_tabel->FldIsDetailKey) {
			$this->kiri_tabel->setFormValue($objForm->GetValue("x_kiri_tabel"));
		}
		if (!$this->kiri_id->FldIsDetailKey) {
			$this->kiri_id->setFormValue($objForm->GetValue("x_kiri_id"));
		}
		if (!$this->kiri_lv2->FldIsDetailKey) {
			$this->kiri_lv2->setFormValue($objForm->GetValue("x_kiri_lv2"));
		}
		if (!$this->kiri_lv3->FldIsDetailKey) {
			$this->kiri_lv3->setFormValue($objForm->GetValue("x_kiri_lv3"));
		}
		if (!$this->kiri_lv4->FldIsDetailKey) {
			$this->kiri_lv4->setFormValue($objForm->GetValue("x_kiri_lv4"));
		}
		if (!$this->kiri_jumlah->FldIsDetailKey) {
			$this->kiri_jumlah->setFormValue($objForm->GetValue("x_kiri_jumlah"));
		}
		if (!$this->kanan_tabel->FldIsDetailKey) {
			$this->kanan_tabel->setFormValue($objForm->GetValue("x_kanan_tabel"));
		}
		if (!$this->kanan_id->FldIsDetailKey) {
			$this->kanan_id->setFormValue($objForm->GetValue("x_kanan_id"));
		}
		if (!$this->kanan_lv2->FldIsDetailKey) {
			$this->kanan_lv2->setFormValue($objForm->GetValue("x_kanan_lv2"));
		}
		if (!$this->kanan_lv3->FldIsDetailKey) {
			$this->kanan_lv3->setFormValue($objForm->GetValue("x_kanan_lv3"));
		}
		if (!$this->kanan_lv4->FldIsDetailKey) {
			$this->kanan_lv4->setFormValue($objForm->GetValue("x_kanan_lv4"));
		}
		if (!$this->kanan_jumlah->FldIsDetailKey) {
			$this->kanan_jumlah->setFormValue($objForm->GetValue("x_kanan_jumlah"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->kiri_tabel->CurrentValue = $this->kiri_tabel->FormValue;
		$this->kiri_id->CurrentValue = $this->kiri_id->FormValue;
		$this->kiri_lv2->CurrentValue = $this->kiri_lv2->FormValue;
		$this->kiri_lv3->CurrentValue = $this->kiri_lv3->FormValue;
		$this->kiri_lv4->CurrentValue = $this->kiri_lv4->FormValue;
		$this->kiri_jumlah->CurrentValue = $this->kiri_jumlah->FormValue;
		$this->kanan_tabel->CurrentValue = $this->kanan_tabel->FormValue;
		$this->kanan_id->CurrentValue = $this->kanan_id->FormValue;
		$this->kanan_lv2->CurrentValue = $this->kanan_lv2->FormValue;
		$this->kanan_lv3->CurrentValue = $this->kanan_lv3->FormValue;
		$this->kanan_lv4->CurrentValue = $this->kanan_lv4->FormValue;
		$this->kanan_jumlah->CurrentValue = $this->kanan_jumlah->FormValue;
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
		$this->kiri_tabel->setDbValue($row['kiri_tabel']);
		$this->kiri_id->setDbValue($row['kiri_id']);
		$this->kiri_lv2->setDbValue($row['kiri_lv2']);
		$this->kiri_lv3->setDbValue($row['kiri_lv3']);
		$this->kiri_lv4->setDbValue($row['kiri_lv4']);
		$this->kiri_jumlah->setDbValue($row['kiri_jumlah']);
		$this->kanan_tabel->setDbValue($row['kanan_tabel']);
		$this->kanan_id->setDbValue($row['kanan_id']);
		$this->kanan_lv2->setDbValue($row['kanan_lv2']);
		$this->kanan_lv3->setDbValue($row['kanan_lv3']);
		$this->kanan_lv4->setDbValue($row['kanan_lv4']);
		$this->kanan_jumlah->setDbValue($row['kanan_jumlah']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['kiri_tabel'] = $this->kiri_tabel->CurrentValue;
		$row['kiri_id'] = $this->kiri_id->CurrentValue;
		$row['kiri_lv2'] = $this->kiri_lv2->CurrentValue;
		$row['kiri_lv3'] = $this->kiri_lv3->CurrentValue;
		$row['kiri_lv4'] = $this->kiri_lv4->CurrentValue;
		$row['kiri_jumlah'] = $this->kiri_jumlah->CurrentValue;
		$row['kanan_tabel'] = $this->kanan_tabel->CurrentValue;
		$row['kanan_id'] = $this->kanan_id->CurrentValue;
		$row['kanan_lv2'] = $this->kanan_lv2->CurrentValue;
		$row['kanan_lv3'] = $this->kanan_lv3->CurrentValue;
		$row['kanan_lv4'] = $this->kanan_lv4->CurrentValue;
		$row['kanan_jumlah'] = $this->kanan_jumlah->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->kiri_tabel->DbValue = $row['kiri_tabel'];
		$this->kiri_id->DbValue = $row['kiri_id'];
		$this->kiri_lv2->DbValue = $row['kiri_lv2'];
		$this->kiri_lv3->DbValue = $row['kiri_lv3'];
		$this->kiri_lv4->DbValue = $row['kiri_lv4'];
		$this->kiri_jumlah->DbValue = $row['kiri_jumlah'];
		$this->kanan_tabel->DbValue = $row['kanan_tabel'];
		$this->kanan_id->DbValue = $row['kanan_id'];
		$this->kanan_lv2->DbValue = $row['kanan_lv2'];
		$this->kanan_lv3->DbValue = $row['kanan_lv3'];
		$this->kanan_lv4->DbValue = $row['kanan_lv4'];
		$this->kanan_jumlah->DbValue = $row['kanan_jumlah'];
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

		if ($this->kiri_jumlah->FormValue == $this->kiri_jumlah->CurrentValue && is_numeric(ew_StrToFloat($this->kiri_jumlah->CurrentValue)))
			$this->kiri_jumlah->CurrentValue = ew_StrToFloat($this->kiri_jumlah->CurrentValue);

		// Convert decimal values if posted back
		if ($this->kanan_jumlah->FormValue == $this->kanan_jumlah->CurrentValue && is_numeric(ew_StrToFloat($this->kanan_jumlah->CurrentValue)))
			$this->kanan_jumlah->CurrentValue = ew_StrToFloat($this->kanan_jumlah->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// kiri_tabel
		// kiri_id
		// kiri_lv2
		// kiri_lv3
		// kiri_lv4
		// kiri_jumlah
		// kanan_tabel
		// kanan_id
		// kanan_lv2
		// kanan_lv3
		// kanan_lv4
		// kanan_jumlah

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// kiri_tabel
		$this->kiri_tabel->ViewValue = $this->kiri_tabel->CurrentValue;
		$this->kiri_tabel->ViewCustomAttributes = "";

		// kiri_id
		$this->kiri_id->ViewValue = $this->kiri_id->CurrentValue;
		$this->kiri_id->ViewCustomAttributes = "";

		// kiri_lv2
		$this->kiri_lv2->ViewValue = $this->kiri_lv2->CurrentValue;
		$this->kiri_lv2->ViewCustomAttributes = "";

		// kiri_lv3
		$this->kiri_lv3->ViewValue = $this->kiri_lv3->CurrentValue;
		$this->kiri_lv3->ViewCustomAttributes = "";

		// kiri_lv4
		$this->kiri_lv4->ViewValue = $this->kiri_lv4->CurrentValue;
		$this->kiri_lv4->ViewCustomAttributes = "";

		// kiri_jumlah
		$this->kiri_jumlah->ViewValue = $this->kiri_jumlah->CurrentValue;
		$this->kiri_jumlah->ViewCustomAttributes = "";

		// kanan_tabel
		$this->kanan_tabel->ViewValue = $this->kanan_tabel->CurrentValue;
		$this->kanan_tabel->ViewCustomAttributes = "";

		// kanan_id
		$this->kanan_id->ViewValue = $this->kanan_id->CurrentValue;
		$this->kanan_id->ViewCustomAttributes = "";

		// kanan_lv2
		$this->kanan_lv2->ViewValue = $this->kanan_lv2->CurrentValue;
		$this->kanan_lv2->ViewCustomAttributes = "";

		// kanan_lv3
		$this->kanan_lv3->ViewValue = $this->kanan_lv3->CurrentValue;
		$this->kanan_lv3->ViewCustomAttributes = "";

		// kanan_lv4
		$this->kanan_lv4->ViewValue = $this->kanan_lv4->CurrentValue;
		$this->kanan_lv4->ViewCustomAttributes = "";

		// kanan_jumlah
		$this->kanan_jumlah->ViewValue = $this->kanan_jumlah->CurrentValue;
		$this->kanan_jumlah->ViewCustomAttributes = "";

			// kiri_tabel
			$this->kiri_tabel->LinkCustomAttributes = "";
			$this->kiri_tabel->HrefValue = "";
			$this->kiri_tabel->TooltipValue = "";

			// kiri_id
			$this->kiri_id->LinkCustomAttributes = "";
			$this->kiri_id->HrefValue = "";
			$this->kiri_id->TooltipValue = "";

			// kiri_lv2
			$this->kiri_lv2->LinkCustomAttributes = "";
			$this->kiri_lv2->HrefValue = "";
			$this->kiri_lv2->TooltipValue = "";

			// kiri_lv3
			$this->kiri_lv3->LinkCustomAttributes = "";
			$this->kiri_lv3->HrefValue = "";
			$this->kiri_lv3->TooltipValue = "";

			// kiri_lv4
			$this->kiri_lv4->LinkCustomAttributes = "";
			$this->kiri_lv4->HrefValue = "";
			$this->kiri_lv4->TooltipValue = "";

			// kiri_jumlah
			$this->kiri_jumlah->LinkCustomAttributes = "";
			$this->kiri_jumlah->HrefValue = "";
			$this->kiri_jumlah->TooltipValue = "";

			// kanan_tabel
			$this->kanan_tabel->LinkCustomAttributes = "";
			$this->kanan_tabel->HrefValue = "";
			$this->kanan_tabel->TooltipValue = "";

			// kanan_id
			$this->kanan_id->LinkCustomAttributes = "";
			$this->kanan_id->HrefValue = "";
			$this->kanan_id->TooltipValue = "";

			// kanan_lv2
			$this->kanan_lv2->LinkCustomAttributes = "";
			$this->kanan_lv2->HrefValue = "";
			$this->kanan_lv2->TooltipValue = "";

			// kanan_lv3
			$this->kanan_lv3->LinkCustomAttributes = "";
			$this->kanan_lv3->HrefValue = "";
			$this->kanan_lv3->TooltipValue = "";

			// kanan_lv4
			$this->kanan_lv4->LinkCustomAttributes = "";
			$this->kanan_lv4->HrefValue = "";
			$this->kanan_lv4->TooltipValue = "";

			// kanan_jumlah
			$this->kanan_jumlah->LinkCustomAttributes = "";
			$this->kanan_jumlah->HrefValue = "";
			$this->kanan_jumlah->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// kiri_tabel
			$this->kiri_tabel->EditAttrs["class"] = "form-control";
			$this->kiri_tabel->EditCustomAttributes = "";
			$this->kiri_tabel->EditValue = ew_HtmlEncode($this->kiri_tabel->CurrentValue);
			$this->kiri_tabel->PlaceHolder = ew_RemoveHtml($this->kiri_tabel->FldCaption());

			// kiri_id
			$this->kiri_id->EditAttrs["class"] = "form-control";
			$this->kiri_id->EditCustomAttributes = "";
			$this->kiri_id->EditValue = ew_HtmlEncode($this->kiri_id->CurrentValue);
			$this->kiri_id->PlaceHolder = ew_RemoveHtml($this->kiri_id->FldCaption());

			// kiri_lv2
			$this->kiri_lv2->EditAttrs["class"] = "form-control";
			$this->kiri_lv2->EditCustomAttributes = "";
			$this->kiri_lv2->EditValue = ew_HtmlEncode($this->kiri_lv2->CurrentValue);
			$this->kiri_lv2->PlaceHolder = ew_RemoveHtml($this->kiri_lv2->FldCaption());

			// kiri_lv3
			$this->kiri_lv3->EditAttrs["class"] = "form-control";
			$this->kiri_lv3->EditCustomAttributes = "";
			$this->kiri_lv3->EditValue = ew_HtmlEncode($this->kiri_lv3->CurrentValue);
			$this->kiri_lv3->PlaceHolder = ew_RemoveHtml($this->kiri_lv3->FldCaption());

			// kiri_lv4
			$this->kiri_lv4->EditAttrs["class"] = "form-control";
			$this->kiri_lv4->EditCustomAttributes = "";
			$this->kiri_lv4->EditValue = ew_HtmlEncode($this->kiri_lv4->CurrentValue);
			$this->kiri_lv4->PlaceHolder = ew_RemoveHtml($this->kiri_lv4->FldCaption());

			// kiri_jumlah
			$this->kiri_jumlah->EditAttrs["class"] = "form-control";
			$this->kiri_jumlah->EditCustomAttributes = "";
			$this->kiri_jumlah->EditValue = ew_HtmlEncode($this->kiri_jumlah->CurrentValue);
			$this->kiri_jumlah->PlaceHolder = ew_RemoveHtml($this->kiri_jumlah->FldCaption());
			if (strval($this->kiri_jumlah->EditValue) <> "" && is_numeric($this->kiri_jumlah->EditValue)) $this->kiri_jumlah->EditValue = ew_FormatNumber($this->kiri_jumlah->EditValue, -2, -1, -2, 0);

			// kanan_tabel
			$this->kanan_tabel->EditAttrs["class"] = "form-control";
			$this->kanan_tabel->EditCustomAttributes = "";
			$this->kanan_tabel->EditValue = ew_HtmlEncode($this->kanan_tabel->CurrentValue);
			$this->kanan_tabel->PlaceHolder = ew_RemoveHtml($this->kanan_tabel->FldCaption());

			// kanan_id
			$this->kanan_id->EditAttrs["class"] = "form-control";
			$this->kanan_id->EditCustomAttributes = "";
			$this->kanan_id->EditValue = ew_HtmlEncode($this->kanan_id->CurrentValue);
			$this->kanan_id->PlaceHolder = ew_RemoveHtml($this->kanan_id->FldCaption());

			// kanan_lv2
			$this->kanan_lv2->EditAttrs["class"] = "form-control";
			$this->kanan_lv2->EditCustomAttributes = "";
			$this->kanan_lv2->EditValue = ew_HtmlEncode($this->kanan_lv2->CurrentValue);
			$this->kanan_lv2->PlaceHolder = ew_RemoveHtml($this->kanan_lv2->FldCaption());

			// kanan_lv3
			$this->kanan_lv3->EditAttrs["class"] = "form-control";
			$this->kanan_lv3->EditCustomAttributes = "";
			$this->kanan_lv3->EditValue = ew_HtmlEncode($this->kanan_lv3->CurrentValue);
			$this->kanan_lv3->PlaceHolder = ew_RemoveHtml($this->kanan_lv3->FldCaption());

			// kanan_lv4
			$this->kanan_lv4->EditAttrs["class"] = "form-control";
			$this->kanan_lv4->EditCustomAttributes = "";
			$this->kanan_lv4->EditValue = ew_HtmlEncode($this->kanan_lv4->CurrentValue);
			$this->kanan_lv4->PlaceHolder = ew_RemoveHtml($this->kanan_lv4->FldCaption());

			// kanan_jumlah
			$this->kanan_jumlah->EditAttrs["class"] = "form-control";
			$this->kanan_jumlah->EditCustomAttributes = "";
			$this->kanan_jumlah->EditValue = ew_HtmlEncode($this->kanan_jumlah->CurrentValue);
			$this->kanan_jumlah->PlaceHolder = ew_RemoveHtml($this->kanan_jumlah->FldCaption());
			if (strval($this->kanan_jumlah->EditValue) <> "" && is_numeric($this->kanan_jumlah->EditValue)) $this->kanan_jumlah->EditValue = ew_FormatNumber($this->kanan_jumlah->EditValue, -2, -1, -2, 0);

			// Add refer script
			// kiri_tabel

			$this->kiri_tabel->LinkCustomAttributes = "";
			$this->kiri_tabel->HrefValue = "";

			// kiri_id
			$this->kiri_id->LinkCustomAttributes = "";
			$this->kiri_id->HrefValue = "";

			// kiri_lv2
			$this->kiri_lv2->LinkCustomAttributes = "";
			$this->kiri_lv2->HrefValue = "";

			// kiri_lv3
			$this->kiri_lv3->LinkCustomAttributes = "";
			$this->kiri_lv3->HrefValue = "";

			// kiri_lv4
			$this->kiri_lv4->LinkCustomAttributes = "";
			$this->kiri_lv4->HrefValue = "";

			// kiri_jumlah
			$this->kiri_jumlah->LinkCustomAttributes = "";
			$this->kiri_jumlah->HrefValue = "";

			// kanan_tabel
			$this->kanan_tabel->LinkCustomAttributes = "";
			$this->kanan_tabel->HrefValue = "";

			// kanan_id
			$this->kanan_id->LinkCustomAttributes = "";
			$this->kanan_id->HrefValue = "";

			// kanan_lv2
			$this->kanan_lv2->LinkCustomAttributes = "";
			$this->kanan_lv2->HrefValue = "";

			// kanan_lv3
			$this->kanan_lv3->LinkCustomAttributes = "";
			$this->kanan_lv3->HrefValue = "";

			// kanan_lv4
			$this->kanan_lv4->LinkCustomAttributes = "";
			$this->kanan_lv4->HrefValue = "";

			// kanan_jumlah
			$this->kanan_jumlah->LinkCustomAttributes = "";
			$this->kanan_jumlah->HrefValue = "";
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
		if (!$this->kiri_tabel->FldIsDetailKey && !is_null($this->kiri_tabel->FormValue) && $this->kiri_tabel->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kiri_tabel->FldCaption(), $this->kiri_tabel->ReqErrMsg));
		}
		if (!$this->kiri_id->FldIsDetailKey && !is_null($this->kiri_id->FormValue) && $this->kiri_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kiri_id->FldCaption(), $this->kiri_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->kiri_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->kiri_id->FldErrMsg());
		}
		if (!$this->kiri_lv2->FldIsDetailKey && !is_null($this->kiri_lv2->FormValue) && $this->kiri_lv2->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kiri_lv2->FldCaption(), $this->kiri_lv2->ReqErrMsg));
		}
		if (!$this->kiri_lv3->FldIsDetailKey && !is_null($this->kiri_lv3->FormValue) && $this->kiri_lv3->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kiri_lv3->FldCaption(), $this->kiri_lv3->ReqErrMsg));
		}
		if (!$this->kiri_lv4->FldIsDetailKey && !is_null($this->kiri_lv4->FormValue) && $this->kiri_lv4->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kiri_lv4->FldCaption(), $this->kiri_lv4->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->kiri_jumlah->FormValue)) {
			ew_AddMessage($gsFormError, $this->kiri_jumlah->FldErrMsg());
		}
		if (!$this->kanan_tabel->FldIsDetailKey && !is_null($this->kanan_tabel->FormValue) && $this->kanan_tabel->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kanan_tabel->FldCaption(), $this->kanan_tabel->ReqErrMsg));
		}
		if (!$this->kanan_id->FldIsDetailKey && !is_null($this->kanan_id->FormValue) && $this->kanan_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kanan_id->FldCaption(), $this->kanan_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->kanan_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->kanan_id->FldErrMsg());
		}
		if (!$this->kanan_lv2->FldIsDetailKey && !is_null($this->kanan_lv2->FormValue) && $this->kanan_lv2->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kanan_lv2->FldCaption(), $this->kanan_lv2->ReqErrMsg));
		}
		if (!$this->kanan_lv3->FldIsDetailKey && !is_null($this->kanan_lv3->FormValue) && $this->kanan_lv3->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kanan_lv3->FldCaption(), $this->kanan_lv3->ReqErrMsg));
		}
		if (!$this->kanan_lv4->FldIsDetailKey && !is_null($this->kanan_lv4->FormValue) && $this->kanan_lv4->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kanan_lv4->FldCaption(), $this->kanan_lv4->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->kanan_jumlah->FormValue)) {
			ew_AddMessage($gsFormError, $this->kanan_jumlah->FldErrMsg());
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

		// kiri_tabel
		$this->kiri_tabel->SetDbValueDef($rsnew, $this->kiri_tabel->CurrentValue, "", FALSE);

		// kiri_id
		$this->kiri_id->SetDbValueDef($rsnew, $this->kiri_id->CurrentValue, 0, FALSE);

		// kiri_lv2
		$this->kiri_lv2->SetDbValueDef($rsnew, $this->kiri_lv2->CurrentValue, "", FALSE);

		// kiri_lv3
		$this->kiri_lv3->SetDbValueDef($rsnew, $this->kiri_lv3->CurrentValue, "", FALSE);

		// kiri_lv4
		$this->kiri_lv4->SetDbValueDef($rsnew, $this->kiri_lv4->CurrentValue, "", FALSE);

		// kiri_jumlah
		$this->kiri_jumlah->SetDbValueDef($rsnew, $this->kiri_jumlah->CurrentValue, 0, strval($this->kiri_jumlah->CurrentValue) == "");

		// kanan_tabel
		$this->kanan_tabel->SetDbValueDef($rsnew, $this->kanan_tabel->CurrentValue, "", FALSE);

		// kanan_id
		$this->kanan_id->SetDbValueDef($rsnew, $this->kanan_id->CurrentValue, 0, FALSE);

		// kanan_lv2
		$this->kanan_lv2->SetDbValueDef($rsnew, $this->kanan_lv2->CurrentValue, "", FALSE);

		// kanan_lv3
		$this->kanan_lv3->SetDbValueDef($rsnew, $this->kanan_lv3->CurrentValue, "", FALSE);

		// kanan_lv4
		$this->kanan_lv4->SetDbValueDef($rsnew, $this->kanan_lv4->CurrentValue, "", FALSE);

		// kanan_jumlah
		$this->kanan_jumlah->SetDbValueDef($rsnew, $this->kanan_jumlah->CurrentValue, 0, strval($this->kanan_jumlah->CurrentValue) == "");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t95_rkaslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t95_rkas_add)) $t95_rkas_add = new ct95_rkas_add();

// Page init
$t95_rkas_add->Page_Init();

// Page main
$t95_rkas_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t95_rkas_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft95_rkasadd = new ew_Form("ft95_rkasadd", "add");

// Validate form
ft95_rkasadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_kiri_tabel");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas->kiri_tabel->FldCaption(), $t95_rkas->kiri_tabel->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kiri_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas->kiri_id->FldCaption(), $t95_rkas->kiri_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kiri_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t95_rkas->kiri_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kiri_lv2");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas->kiri_lv2->FldCaption(), $t95_rkas->kiri_lv2->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kiri_lv3");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas->kiri_lv3->FldCaption(), $t95_rkas->kiri_lv3->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kiri_lv4");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas->kiri_lv4->FldCaption(), $t95_rkas->kiri_lv4->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kiri_jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t95_rkas->kiri_jumlah->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kanan_tabel");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas->kanan_tabel->FldCaption(), $t95_rkas->kanan_tabel->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kanan_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas->kanan_id->FldCaption(), $t95_rkas->kanan_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kanan_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t95_rkas->kanan_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kanan_lv2");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas->kanan_lv2->FldCaption(), $t95_rkas->kanan_lv2->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kanan_lv3");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas->kanan_lv3->FldCaption(), $t95_rkas->kanan_lv3->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kanan_lv4");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas->kanan_lv4->FldCaption(), $t95_rkas->kanan_lv4->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kanan_jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t95_rkas->kanan_jumlah->FldErrMsg()) ?>");

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
ft95_rkasadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft95_rkasadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t95_rkas_add->ShowPageHeader(); ?>
<?php
$t95_rkas_add->ShowMessage();
?>
<form name="ft95_rkasadd" id="ft95_rkasadd" class="<?php echo $t95_rkas_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t95_rkas_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t95_rkas_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t95_rkas">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($t95_rkas_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($t95_rkas->kiri_tabel->Visible) { // kiri_tabel ?>
	<div id="r_kiri_tabel" class="form-group">
		<label id="elh_t95_rkas_kiri_tabel" for="x_kiri_tabel" class="<?php echo $t95_rkas_add->LeftColumnClass ?>"><?php echo $t95_rkas->kiri_tabel->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas_add->RightColumnClass ?>"><div<?php echo $t95_rkas->kiri_tabel->CellAttributes() ?>>
<span id="el_t95_rkas_kiri_tabel">
<input type="text" data-table="t95_rkas" data-field="x_kiri_tabel" name="x_kiri_tabel" id="x_kiri_tabel" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t95_rkas->kiri_tabel->getPlaceHolder()) ?>" value="<?php echo $t95_rkas->kiri_tabel->EditValue ?>"<?php echo $t95_rkas->kiri_tabel->EditAttributes() ?>>
</span>
<?php echo $t95_rkas->kiri_tabel->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas->kiri_id->Visible) { // kiri_id ?>
	<div id="r_kiri_id" class="form-group">
		<label id="elh_t95_rkas_kiri_id" for="x_kiri_id" class="<?php echo $t95_rkas_add->LeftColumnClass ?>"><?php echo $t95_rkas->kiri_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas_add->RightColumnClass ?>"><div<?php echo $t95_rkas->kiri_id->CellAttributes() ?>>
<span id="el_t95_rkas_kiri_id">
<input type="text" data-table="t95_rkas" data-field="x_kiri_id" name="x_kiri_id" id="x_kiri_id" size="30" placeholder="<?php echo ew_HtmlEncode($t95_rkas->kiri_id->getPlaceHolder()) ?>" value="<?php echo $t95_rkas->kiri_id->EditValue ?>"<?php echo $t95_rkas->kiri_id->EditAttributes() ?>>
</span>
<?php echo $t95_rkas->kiri_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas->kiri_lv2->Visible) { // kiri_lv2 ?>
	<div id="r_kiri_lv2" class="form-group">
		<label id="elh_t95_rkas_kiri_lv2" for="x_kiri_lv2" class="<?php echo $t95_rkas_add->LeftColumnClass ?>"><?php echo $t95_rkas->kiri_lv2->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas_add->RightColumnClass ?>"><div<?php echo $t95_rkas->kiri_lv2->CellAttributes() ?>>
<span id="el_t95_rkas_kiri_lv2">
<input type="text" data-table="t95_rkas" data-field="x_kiri_lv2" name="x_kiri_lv2" id="x_kiri_lv2" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t95_rkas->kiri_lv2->getPlaceHolder()) ?>" value="<?php echo $t95_rkas->kiri_lv2->EditValue ?>"<?php echo $t95_rkas->kiri_lv2->EditAttributes() ?>>
</span>
<?php echo $t95_rkas->kiri_lv2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas->kiri_lv3->Visible) { // kiri_lv3 ?>
	<div id="r_kiri_lv3" class="form-group">
		<label id="elh_t95_rkas_kiri_lv3" for="x_kiri_lv3" class="<?php echo $t95_rkas_add->LeftColumnClass ?>"><?php echo $t95_rkas->kiri_lv3->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas_add->RightColumnClass ?>"><div<?php echo $t95_rkas->kiri_lv3->CellAttributes() ?>>
<span id="el_t95_rkas_kiri_lv3">
<input type="text" data-table="t95_rkas" data-field="x_kiri_lv3" name="x_kiri_lv3" id="x_kiri_lv3" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t95_rkas->kiri_lv3->getPlaceHolder()) ?>" value="<?php echo $t95_rkas->kiri_lv3->EditValue ?>"<?php echo $t95_rkas->kiri_lv3->EditAttributes() ?>>
</span>
<?php echo $t95_rkas->kiri_lv3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas->kiri_lv4->Visible) { // kiri_lv4 ?>
	<div id="r_kiri_lv4" class="form-group">
		<label id="elh_t95_rkas_kiri_lv4" for="x_kiri_lv4" class="<?php echo $t95_rkas_add->LeftColumnClass ?>"><?php echo $t95_rkas->kiri_lv4->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas_add->RightColumnClass ?>"><div<?php echo $t95_rkas->kiri_lv4->CellAttributes() ?>>
<span id="el_t95_rkas_kiri_lv4">
<input type="text" data-table="t95_rkas" data-field="x_kiri_lv4" name="x_kiri_lv4" id="x_kiri_lv4" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t95_rkas->kiri_lv4->getPlaceHolder()) ?>" value="<?php echo $t95_rkas->kiri_lv4->EditValue ?>"<?php echo $t95_rkas->kiri_lv4->EditAttributes() ?>>
</span>
<?php echo $t95_rkas->kiri_lv4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas->kiri_jumlah->Visible) { // kiri_jumlah ?>
	<div id="r_kiri_jumlah" class="form-group">
		<label id="elh_t95_rkas_kiri_jumlah" for="x_kiri_jumlah" class="<?php echo $t95_rkas_add->LeftColumnClass ?>"><?php echo $t95_rkas->kiri_jumlah->FldCaption() ?></label>
		<div class="<?php echo $t95_rkas_add->RightColumnClass ?>"><div<?php echo $t95_rkas->kiri_jumlah->CellAttributes() ?>>
<span id="el_t95_rkas_kiri_jumlah">
<input type="text" data-table="t95_rkas" data-field="x_kiri_jumlah" name="x_kiri_jumlah" id="x_kiri_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t95_rkas->kiri_jumlah->getPlaceHolder()) ?>" value="<?php echo $t95_rkas->kiri_jumlah->EditValue ?>"<?php echo $t95_rkas->kiri_jumlah->EditAttributes() ?>>
</span>
<?php echo $t95_rkas->kiri_jumlah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas->kanan_tabel->Visible) { // kanan_tabel ?>
	<div id="r_kanan_tabel" class="form-group">
		<label id="elh_t95_rkas_kanan_tabel" for="x_kanan_tabel" class="<?php echo $t95_rkas_add->LeftColumnClass ?>"><?php echo $t95_rkas->kanan_tabel->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas_add->RightColumnClass ?>"><div<?php echo $t95_rkas->kanan_tabel->CellAttributes() ?>>
<span id="el_t95_rkas_kanan_tabel">
<input type="text" data-table="t95_rkas" data-field="x_kanan_tabel" name="x_kanan_tabel" id="x_kanan_tabel" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t95_rkas->kanan_tabel->getPlaceHolder()) ?>" value="<?php echo $t95_rkas->kanan_tabel->EditValue ?>"<?php echo $t95_rkas->kanan_tabel->EditAttributes() ?>>
</span>
<?php echo $t95_rkas->kanan_tabel->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas->kanan_id->Visible) { // kanan_id ?>
	<div id="r_kanan_id" class="form-group">
		<label id="elh_t95_rkas_kanan_id" for="x_kanan_id" class="<?php echo $t95_rkas_add->LeftColumnClass ?>"><?php echo $t95_rkas->kanan_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas_add->RightColumnClass ?>"><div<?php echo $t95_rkas->kanan_id->CellAttributes() ?>>
<span id="el_t95_rkas_kanan_id">
<input type="text" data-table="t95_rkas" data-field="x_kanan_id" name="x_kanan_id" id="x_kanan_id" size="30" placeholder="<?php echo ew_HtmlEncode($t95_rkas->kanan_id->getPlaceHolder()) ?>" value="<?php echo $t95_rkas->kanan_id->EditValue ?>"<?php echo $t95_rkas->kanan_id->EditAttributes() ?>>
</span>
<?php echo $t95_rkas->kanan_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas->kanan_lv2->Visible) { // kanan_lv2 ?>
	<div id="r_kanan_lv2" class="form-group">
		<label id="elh_t95_rkas_kanan_lv2" for="x_kanan_lv2" class="<?php echo $t95_rkas_add->LeftColumnClass ?>"><?php echo $t95_rkas->kanan_lv2->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas_add->RightColumnClass ?>"><div<?php echo $t95_rkas->kanan_lv2->CellAttributes() ?>>
<span id="el_t95_rkas_kanan_lv2">
<input type="text" data-table="t95_rkas" data-field="x_kanan_lv2" name="x_kanan_lv2" id="x_kanan_lv2" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t95_rkas->kanan_lv2->getPlaceHolder()) ?>" value="<?php echo $t95_rkas->kanan_lv2->EditValue ?>"<?php echo $t95_rkas->kanan_lv2->EditAttributes() ?>>
</span>
<?php echo $t95_rkas->kanan_lv2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas->kanan_lv3->Visible) { // kanan_lv3 ?>
	<div id="r_kanan_lv3" class="form-group">
		<label id="elh_t95_rkas_kanan_lv3" for="x_kanan_lv3" class="<?php echo $t95_rkas_add->LeftColumnClass ?>"><?php echo $t95_rkas->kanan_lv3->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas_add->RightColumnClass ?>"><div<?php echo $t95_rkas->kanan_lv3->CellAttributes() ?>>
<span id="el_t95_rkas_kanan_lv3">
<input type="text" data-table="t95_rkas" data-field="x_kanan_lv3" name="x_kanan_lv3" id="x_kanan_lv3" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t95_rkas->kanan_lv3->getPlaceHolder()) ?>" value="<?php echo $t95_rkas->kanan_lv3->EditValue ?>"<?php echo $t95_rkas->kanan_lv3->EditAttributes() ?>>
</span>
<?php echo $t95_rkas->kanan_lv3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas->kanan_lv4->Visible) { // kanan_lv4 ?>
	<div id="r_kanan_lv4" class="form-group">
		<label id="elh_t95_rkas_kanan_lv4" for="x_kanan_lv4" class="<?php echo $t95_rkas_add->LeftColumnClass ?>"><?php echo $t95_rkas->kanan_lv4->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas_add->RightColumnClass ?>"><div<?php echo $t95_rkas->kanan_lv4->CellAttributes() ?>>
<span id="el_t95_rkas_kanan_lv4">
<input type="text" data-table="t95_rkas" data-field="x_kanan_lv4" name="x_kanan_lv4" id="x_kanan_lv4" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t95_rkas->kanan_lv4->getPlaceHolder()) ?>" value="<?php echo $t95_rkas->kanan_lv4->EditValue ?>"<?php echo $t95_rkas->kanan_lv4->EditAttributes() ?>>
</span>
<?php echo $t95_rkas->kanan_lv4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas->kanan_jumlah->Visible) { // kanan_jumlah ?>
	<div id="r_kanan_jumlah" class="form-group">
		<label id="elh_t95_rkas_kanan_jumlah" for="x_kanan_jumlah" class="<?php echo $t95_rkas_add->LeftColumnClass ?>"><?php echo $t95_rkas->kanan_jumlah->FldCaption() ?></label>
		<div class="<?php echo $t95_rkas_add->RightColumnClass ?>"><div<?php echo $t95_rkas->kanan_jumlah->CellAttributes() ?>>
<span id="el_t95_rkas_kanan_jumlah">
<input type="text" data-table="t95_rkas" data-field="x_kanan_jumlah" name="x_kanan_jumlah" id="x_kanan_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t95_rkas->kanan_jumlah->getPlaceHolder()) ?>" value="<?php echo $t95_rkas->kanan_jumlah->EditValue ?>"<?php echo $t95_rkas->kanan_jumlah->EditAttributes() ?>>
</span>
<?php echo $t95_rkas->kanan_jumlah->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$t95_rkas_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t95_rkas_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t95_rkas_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft95_rkasadd.Init();
</script>
<?php
$t95_rkas_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t95_rkas_add->Page_Terminate();
?>
