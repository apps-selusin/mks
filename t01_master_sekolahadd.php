<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t01_master_sekolahinfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t01_master_sekolah_add = NULL; // Initialize page object first

class ct01_master_sekolah_add extends ct01_master_sekolah {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}';

	// Table name
	var $TableName = 't01_master_sekolah';

	// Page object name
	var $PageObjName = 't01_master_sekolah_add';

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

		// Table object (t01_master_sekolah)
		if (!isset($GLOBALS["t01_master_sekolah"]) || get_class($GLOBALS["t01_master_sekolah"]) == "ct01_master_sekolah") {
			$GLOBALS["t01_master_sekolah"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t01_master_sekolah"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't01_master_sekolah', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t01_master_sekolahlist.php"));
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
		$this->no_stat->SetVisibility();
		$this->nama->SetVisibility();
		$this->status->SetVisibility();
		$this->desa->SetVisibility();
		$this->kecamatan->SetVisibility();
		$this->kabupaten->SetVisibility();
		$this->provinsi->SetVisibility();

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
		global $EW_EXPORT, $t01_master_sekolah;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t01_master_sekolah);
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
					if ($pageName == "t01_master_sekolahview.php")
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
					$this->Page_Terminate("t01_master_sekolahlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t01_master_sekolahlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t01_master_sekolahview.php")
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
		$this->no_stat->CurrentValue = NULL;
		$this->no_stat->OldValue = $this->no_stat->CurrentValue;
		$this->nama->CurrentValue = NULL;
		$this->nama->OldValue = $this->nama->CurrentValue;
		$this->status->CurrentValue = NULL;
		$this->status->OldValue = $this->status->CurrentValue;
		$this->desa->CurrentValue = NULL;
		$this->desa->OldValue = $this->desa->CurrentValue;
		$this->kecamatan->CurrentValue = NULL;
		$this->kecamatan->OldValue = $this->kecamatan->CurrentValue;
		$this->kabupaten->CurrentValue = NULL;
		$this->kabupaten->OldValue = $this->kabupaten->CurrentValue;
		$this->provinsi->CurrentValue = NULL;
		$this->provinsi->OldValue = $this->provinsi->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->no_stat->FldIsDetailKey) {
			$this->no_stat->setFormValue($objForm->GetValue("x_no_stat"));
		}
		if (!$this->nama->FldIsDetailKey) {
			$this->nama->setFormValue($objForm->GetValue("x_nama"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->desa->FldIsDetailKey) {
			$this->desa->setFormValue($objForm->GetValue("x_desa"));
		}
		if (!$this->kecamatan->FldIsDetailKey) {
			$this->kecamatan->setFormValue($objForm->GetValue("x_kecamatan"));
		}
		if (!$this->kabupaten->FldIsDetailKey) {
			$this->kabupaten->setFormValue($objForm->GetValue("x_kabupaten"));
		}
		if (!$this->provinsi->FldIsDetailKey) {
			$this->provinsi->setFormValue($objForm->GetValue("x_provinsi"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->no_stat->CurrentValue = $this->no_stat->FormValue;
		$this->nama->CurrentValue = $this->nama->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->desa->CurrentValue = $this->desa->FormValue;
		$this->kecamatan->CurrentValue = $this->kecamatan->FormValue;
		$this->kabupaten->CurrentValue = $this->kabupaten->FormValue;
		$this->provinsi->CurrentValue = $this->provinsi->FormValue;
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
		$this->no_stat->setDbValue($row['no_stat']);
		$this->nama->setDbValue($row['nama']);
		$this->status->setDbValue($row['status']);
		$this->desa->setDbValue($row['desa']);
		$this->kecamatan->setDbValue($row['kecamatan']);
		$this->kabupaten->setDbValue($row['kabupaten']);
		$this->provinsi->setDbValue($row['provinsi']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['no_stat'] = $this->no_stat->CurrentValue;
		$row['nama'] = $this->nama->CurrentValue;
		$row['status'] = $this->status->CurrentValue;
		$row['desa'] = $this->desa->CurrentValue;
		$row['kecamatan'] = $this->kecamatan->CurrentValue;
		$row['kabupaten'] = $this->kabupaten->CurrentValue;
		$row['provinsi'] = $this->provinsi->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->no_stat->DbValue = $row['no_stat'];
		$this->nama->DbValue = $row['nama'];
		$this->status->DbValue = $row['status'];
		$this->desa->DbValue = $row['desa'];
		$this->kecamatan->DbValue = $row['kecamatan'];
		$this->kabupaten->DbValue = $row['kabupaten'];
		$this->provinsi->DbValue = $row['provinsi'];
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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// no_stat
		// nama
		// status
		// desa
		// kecamatan
		// kabupaten
		// provinsi

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// no_stat
		$this->no_stat->ViewValue = $this->no_stat->CurrentValue;
		$this->no_stat->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->ViewCustomAttributes = "";

		// desa
		$this->desa->ViewValue = $this->desa->CurrentValue;
		$this->desa->ViewCustomAttributes = "";

		// kecamatan
		$this->kecamatan->ViewValue = $this->kecamatan->CurrentValue;
		$this->kecamatan->ViewCustomAttributes = "";

		// kabupaten
		$this->kabupaten->ViewValue = $this->kabupaten->CurrentValue;
		$this->kabupaten->ViewCustomAttributes = "";

		// provinsi
		$this->provinsi->ViewValue = $this->provinsi->CurrentValue;
		$this->provinsi->ViewCustomAttributes = "";

			// no_stat
			$this->no_stat->LinkCustomAttributes = "";
			$this->no_stat->HrefValue = "";
			$this->no_stat->TooltipValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";
			$this->nama->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// desa
			$this->desa->LinkCustomAttributes = "";
			$this->desa->HrefValue = "";
			$this->desa->TooltipValue = "";

			// kecamatan
			$this->kecamatan->LinkCustomAttributes = "";
			$this->kecamatan->HrefValue = "";
			$this->kecamatan->TooltipValue = "";

			// kabupaten
			$this->kabupaten->LinkCustomAttributes = "";
			$this->kabupaten->HrefValue = "";
			$this->kabupaten->TooltipValue = "";

			// provinsi
			$this->provinsi->LinkCustomAttributes = "";
			$this->provinsi->HrefValue = "";
			$this->provinsi->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// no_stat
			$this->no_stat->EditAttrs["class"] = "form-control";
			$this->no_stat->EditCustomAttributes = "";
			$this->no_stat->EditValue = ew_HtmlEncode($this->no_stat->CurrentValue);
			$this->no_stat->PlaceHolder = ew_RemoveHtml($this->no_stat->FldCaption());

			// nama
			$this->nama->EditAttrs["class"] = "form-control";
			$this->nama->EditCustomAttributes = "";
			$this->nama->EditValue = ew_HtmlEncode($this->nama->CurrentValue);
			$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = ew_HtmlEncode($this->status->CurrentValue);
			$this->status->PlaceHolder = ew_RemoveHtml($this->status->FldCaption());

			// desa
			$this->desa->EditAttrs["class"] = "form-control";
			$this->desa->EditCustomAttributes = "";
			$this->desa->EditValue = ew_HtmlEncode($this->desa->CurrentValue);
			$this->desa->PlaceHolder = ew_RemoveHtml($this->desa->FldCaption());

			// kecamatan
			$this->kecamatan->EditAttrs["class"] = "form-control";
			$this->kecamatan->EditCustomAttributes = "";
			$this->kecamatan->EditValue = ew_HtmlEncode($this->kecamatan->CurrentValue);
			$this->kecamatan->PlaceHolder = ew_RemoveHtml($this->kecamatan->FldCaption());

			// kabupaten
			$this->kabupaten->EditAttrs["class"] = "form-control";
			$this->kabupaten->EditCustomAttributes = "";
			$this->kabupaten->EditValue = ew_HtmlEncode($this->kabupaten->CurrentValue);
			$this->kabupaten->PlaceHolder = ew_RemoveHtml($this->kabupaten->FldCaption());

			// provinsi
			$this->provinsi->EditAttrs["class"] = "form-control";
			$this->provinsi->EditCustomAttributes = "";
			$this->provinsi->EditValue = ew_HtmlEncode($this->provinsi->CurrentValue);
			$this->provinsi->PlaceHolder = ew_RemoveHtml($this->provinsi->FldCaption());

			// Add refer script
			// no_stat

			$this->no_stat->LinkCustomAttributes = "";
			$this->no_stat->HrefValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";

			// desa
			$this->desa->LinkCustomAttributes = "";
			$this->desa->HrefValue = "";

			// kecamatan
			$this->kecamatan->LinkCustomAttributes = "";
			$this->kecamatan->HrefValue = "";

			// kabupaten
			$this->kabupaten->LinkCustomAttributes = "";
			$this->kabupaten->HrefValue = "";

			// provinsi
			$this->provinsi->LinkCustomAttributes = "";
			$this->provinsi->HrefValue = "";
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
		if (!$this->no_stat->FldIsDetailKey && !is_null($this->no_stat->FormValue) && $this->no_stat->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->no_stat->FldCaption(), $this->no_stat->ReqErrMsg));
		}
		if (!$this->nama->FldIsDetailKey && !is_null($this->nama->FormValue) && $this->nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama->FldCaption(), $this->nama->ReqErrMsg));
		}
		if (!$this->status->FldIsDetailKey && !is_null($this->status->FormValue) && $this->status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status->FldCaption(), $this->status->ReqErrMsg));
		}
		if (!$this->desa->FldIsDetailKey && !is_null($this->desa->FormValue) && $this->desa->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->desa->FldCaption(), $this->desa->ReqErrMsg));
		}
		if (!$this->kecamatan->FldIsDetailKey && !is_null($this->kecamatan->FormValue) && $this->kecamatan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kecamatan->FldCaption(), $this->kecamatan->ReqErrMsg));
		}
		if (!$this->kabupaten->FldIsDetailKey && !is_null($this->kabupaten->FormValue) && $this->kabupaten->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kabupaten->FldCaption(), $this->kabupaten->ReqErrMsg));
		}
		if (!$this->provinsi->FldIsDetailKey && !is_null($this->provinsi->FormValue) && $this->provinsi->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->provinsi->FldCaption(), $this->provinsi->ReqErrMsg));
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

		// no_stat
		$this->no_stat->SetDbValueDef($rsnew, $this->no_stat->CurrentValue, "", FALSE);

		// nama
		$this->nama->SetDbValueDef($rsnew, $this->nama->CurrentValue, "", FALSE);

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", FALSE);

		// desa
		$this->desa->SetDbValueDef($rsnew, $this->desa->CurrentValue, "", FALSE);

		// kecamatan
		$this->kecamatan->SetDbValueDef($rsnew, $this->kecamatan->CurrentValue, "", FALSE);

		// kabupaten
		$this->kabupaten->SetDbValueDef($rsnew, $this->kabupaten->CurrentValue, "", FALSE);

		// provinsi
		$this->provinsi->SetDbValueDef($rsnew, $this->provinsi->CurrentValue, "", FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t01_master_sekolahlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t01_master_sekolah_add)) $t01_master_sekolah_add = new ct01_master_sekolah_add();

// Page init
$t01_master_sekolah_add->Page_Init();

// Page main
$t01_master_sekolah_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t01_master_sekolah_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft01_master_sekolahadd = new ew_Form("ft01_master_sekolahadd", "add");

// Validate form
ft01_master_sekolahadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_no_stat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_master_sekolah->no_stat->FldCaption(), $t01_master_sekolah->no_stat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_master_sekolah->nama->FldCaption(), $t01_master_sekolah->nama->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_master_sekolah->status->FldCaption(), $t01_master_sekolah->status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_desa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_master_sekolah->desa->FldCaption(), $t01_master_sekolah->desa->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kecamatan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_master_sekolah->kecamatan->FldCaption(), $t01_master_sekolah->kecamatan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kabupaten");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_master_sekolah->kabupaten->FldCaption(), $t01_master_sekolah->kabupaten->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_provinsi");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_master_sekolah->provinsi->FldCaption(), $t01_master_sekolah->provinsi->ReqErrMsg)) ?>");

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
ft01_master_sekolahadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft01_master_sekolahadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t01_master_sekolah_add->ShowPageHeader(); ?>
<?php
$t01_master_sekolah_add->ShowMessage();
?>
<form name="ft01_master_sekolahadd" id="ft01_master_sekolahadd" class="<?php echo $t01_master_sekolah_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t01_master_sekolah_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t01_master_sekolah_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t01_master_sekolah">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($t01_master_sekolah_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($t01_master_sekolah->no_stat->Visible) { // no_stat ?>
	<div id="r_no_stat" class="form-group">
		<label id="elh_t01_master_sekolah_no_stat" for="x_no_stat" class="<?php echo $t01_master_sekolah_add->LeftColumnClass ?>"><?php echo $t01_master_sekolah->no_stat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_master_sekolah_add->RightColumnClass ?>"><div<?php echo $t01_master_sekolah->no_stat->CellAttributes() ?>>
<span id="el_t01_master_sekolah_no_stat">
<input type="text" data-table="t01_master_sekolah" data-field="x_no_stat" name="x_no_stat" id="x_no_stat" size="30" maxlength="12" placeholder="<?php echo ew_HtmlEncode($t01_master_sekolah->no_stat->getPlaceHolder()) ?>" value="<?php echo $t01_master_sekolah->no_stat->EditValue ?>"<?php echo $t01_master_sekolah->no_stat->EditAttributes() ?>>
</span>
<?php echo $t01_master_sekolah->no_stat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_master_sekolah->nama->Visible) { // nama ?>
	<div id="r_nama" class="form-group">
		<label id="elh_t01_master_sekolah_nama" for="x_nama" class="<?php echo $t01_master_sekolah_add->LeftColumnClass ?>"><?php echo $t01_master_sekolah->nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_master_sekolah_add->RightColumnClass ?>"><div<?php echo $t01_master_sekolah->nama->CellAttributes() ?>>
<span id="el_t01_master_sekolah_nama">
<input type="text" data-table="t01_master_sekolah" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_master_sekolah->nama->getPlaceHolder()) ?>" value="<?php echo $t01_master_sekolah->nama->EditValue ?>"<?php echo $t01_master_sekolah->nama->EditAttributes() ?>>
</span>
<?php echo $t01_master_sekolah->nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_master_sekolah->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_t01_master_sekolah_status" for="x_status" class="<?php echo $t01_master_sekolah_add->LeftColumnClass ?>"><?php echo $t01_master_sekolah->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_master_sekolah_add->RightColumnClass ?>"><div<?php echo $t01_master_sekolah->status->CellAttributes() ?>>
<span id="el_t01_master_sekolah_status">
<input type="text" data-table="t01_master_sekolah" data-field="x_status" name="x_status" id="x_status" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_master_sekolah->status->getPlaceHolder()) ?>" value="<?php echo $t01_master_sekolah->status->EditValue ?>"<?php echo $t01_master_sekolah->status->EditAttributes() ?>>
</span>
<?php echo $t01_master_sekolah->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_master_sekolah->desa->Visible) { // desa ?>
	<div id="r_desa" class="form-group">
		<label id="elh_t01_master_sekolah_desa" for="x_desa" class="<?php echo $t01_master_sekolah_add->LeftColumnClass ?>"><?php echo $t01_master_sekolah->desa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_master_sekolah_add->RightColumnClass ?>"><div<?php echo $t01_master_sekolah->desa->CellAttributes() ?>>
<span id="el_t01_master_sekolah_desa">
<input type="text" data-table="t01_master_sekolah" data-field="x_desa" name="x_desa" id="x_desa" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_master_sekolah->desa->getPlaceHolder()) ?>" value="<?php echo $t01_master_sekolah->desa->EditValue ?>"<?php echo $t01_master_sekolah->desa->EditAttributes() ?>>
</span>
<?php echo $t01_master_sekolah->desa->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_master_sekolah->kecamatan->Visible) { // kecamatan ?>
	<div id="r_kecamatan" class="form-group">
		<label id="elh_t01_master_sekolah_kecamatan" for="x_kecamatan" class="<?php echo $t01_master_sekolah_add->LeftColumnClass ?>"><?php echo $t01_master_sekolah->kecamatan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_master_sekolah_add->RightColumnClass ?>"><div<?php echo $t01_master_sekolah->kecamatan->CellAttributes() ?>>
<span id="el_t01_master_sekolah_kecamatan">
<input type="text" data-table="t01_master_sekolah" data-field="x_kecamatan" name="x_kecamatan" id="x_kecamatan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_master_sekolah->kecamatan->getPlaceHolder()) ?>" value="<?php echo $t01_master_sekolah->kecamatan->EditValue ?>"<?php echo $t01_master_sekolah->kecamatan->EditAttributes() ?>>
</span>
<?php echo $t01_master_sekolah->kecamatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_master_sekolah->kabupaten->Visible) { // kabupaten ?>
	<div id="r_kabupaten" class="form-group">
		<label id="elh_t01_master_sekolah_kabupaten" for="x_kabupaten" class="<?php echo $t01_master_sekolah_add->LeftColumnClass ?>"><?php echo $t01_master_sekolah->kabupaten->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_master_sekolah_add->RightColumnClass ?>"><div<?php echo $t01_master_sekolah->kabupaten->CellAttributes() ?>>
<span id="el_t01_master_sekolah_kabupaten">
<input type="text" data-table="t01_master_sekolah" data-field="x_kabupaten" name="x_kabupaten" id="x_kabupaten" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_master_sekolah->kabupaten->getPlaceHolder()) ?>" value="<?php echo $t01_master_sekolah->kabupaten->EditValue ?>"<?php echo $t01_master_sekolah->kabupaten->EditAttributes() ?>>
</span>
<?php echo $t01_master_sekolah->kabupaten->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_master_sekolah->provinsi->Visible) { // provinsi ?>
	<div id="r_provinsi" class="form-group">
		<label id="elh_t01_master_sekolah_provinsi" for="x_provinsi" class="<?php echo $t01_master_sekolah_add->LeftColumnClass ?>"><?php echo $t01_master_sekolah->provinsi->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_master_sekolah_add->RightColumnClass ?>"><div<?php echo $t01_master_sekolah->provinsi->CellAttributes() ?>>
<span id="el_t01_master_sekolah_provinsi">
<input type="text" data-table="t01_master_sekolah" data-field="x_provinsi" name="x_provinsi" id="x_provinsi" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_master_sekolah->provinsi->getPlaceHolder()) ?>" value="<?php echo $t01_master_sekolah->provinsi->EditValue ?>"<?php echo $t01_master_sekolah->provinsi->EditAttributes() ?>>
</span>
<?php echo $t01_master_sekolah->provinsi->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$t01_master_sekolah_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t01_master_sekolah_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t01_master_sekolah_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft01_master_sekolahadd.Init();
</script>
<?php
$t01_master_sekolah_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t01_master_sekolah_add->Page_Terminate();
?>
