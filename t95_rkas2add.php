<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t95_rkas2info.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t95_rkas2_add = NULL; // Initialize page object first

class ct95_rkas2_add extends ct95_rkas2 {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}';

	// Table name
	var $TableName = 't95_rkas2';

	// Page object name
	var $PageObjName = 't95_rkas2_add';

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

		// Table object (t95_rkas2)
		if (!isset($GLOBALS["t95_rkas2"]) || get_class($GLOBALS["t95_rkas2"]) == "ct95_rkas2") {
			$GLOBALS["t95_rkas2"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t95_rkas2"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't95_rkas2', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t95_rkas2list.php"));
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
		$this->no_urut->SetVisibility();
		$this->keterangan->SetVisibility();
		$this->jumlah->SetVisibility();
		$this->no_keyfield->SetVisibility();
		$this->no_level->SetVisibility();
		$this->nama_tabel->SetVisibility();
		$this->id_data->SetVisibility();

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
		global $EW_EXPORT, $t95_rkas2;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t95_rkas2);
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
					if ($pageName == "t95_rkas2view.php")
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
					$this->Page_Terminate("t95_rkas2list.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t95_rkas2list.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t95_rkas2view.php")
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
		$this->no_urut->CurrentValue = NULL;
		$this->no_urut->OldValue = $this->no_urut->CurrentValue;
		$this->keterangan->CurrentValue = NULL;
		$this->keterangan->OldValue = $this->keterangan->CurrentValue;
		$this->jumlah->CurrentValue = 0.00;
		$this->no_keyfield->CurrentValue = NULL;
		$this->no_keyfield->OldValue = $this->no_keyfield->CurrentValue;
		$this->no_level->CurrentValue = NULL;
		$this->no_level->OldValue = $this->no_level->CurrentValue;
		$this->nama_tabel->CurrentValue = NULL;
		$this->nama_tabel->OldValue = $this->nama_tabel->CurrentValue;
		$this->id_data->CurrentValue = NULL;
		$this->id_data->OldValue = $this->id_data->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->no_urut->FldIsDetailKey) {
			$this->no_urut->setFormValue($objForm->GetValue("x_no_urut"));
		}
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
		if (!$this->jumlah->FldIsDetailKey) {
			$this->jumlah->setFormValue($objForm->GetValue("x_jumlah"));
		}
		if (!$this->no_keyfield->FldIsDetailKey) {
			$this->no_keyfield->setFormValue($objForm->GetValue("x_no_keyfield"));
		}
		if (!$this->no_level->FldIsDetailKey) {
			$this->no_level->setFormValue($objForm->GetValue("x_no_level"));
		}
		if (!$this->nama_tabel->FldIsDetailKey) {
			$this->nama_tabel->setFormValue($objForm->GetValue("x_nama_tabel"));
		}
		if (!$this->id_data->FldIsDetailKey) {
			$this->id_data->setFormValue($objForm->GetValue("x_id_data"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->no_urut->CurrentValue = $this->no_urut->FormValue;
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
		$this->jumlah->CurrentValue = $this->jumlah->FormValue;
		$this->no_keyfield->CurrentValue = $this->no_keyfield->FormValue;
		$this->no_level->CurrentValue = $this->no_level->FormValue;
		$this->nama_tabel->CurrentValue = $this->nama_tabel->FormValue;
		$this->id_data->CurrentValue = $this->id_data->FormValue;
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
		$this->no_urut->setDbValue($row['no_urut']);
		$this->keterangan->setDbValue($row['keterangan']);
		$this->jumlah->setDbValue($row['jumlah']);
		$this->no_keyfield->setDbValue($row['no_keyfield']);
		$this->no_level->setDbValue($row['no_level']);
		$this->nama_tabel->setDbValue($row['nama_tabel']);
		$this->id_data->setDbValue($row['id_data']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['no_urut'] = $this->no_urut->CurrentValue;
		$row['keterangan'] = $this->keterangan->CurrentValue;
		$row['jumlah'] = $this->jumlah->CurrentValue;
		$row['no_keyfield'] = $this->no_keyfield->CurrentValue;
		$row['no_level'] = $this->no_level->CurrentValue;
		$row['nama_tabel'] = $this->nama_tabel->CurrentValue;
		$row['id_data'] = $this->id_data->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->no_urut->DbValue = $row['no_urut'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->jumlah->DbValue = $row['jumlah'];
		$this->no_keyfield->DbValue = $row['no_keyfield'];
		$this->no_level->DbValue = $row['no_level'];
		$this->nama_tabel->DbValue = $row['nama_tabel'];
		$this->id_data->DbValue = $row['id_data'];
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
		// no_urut
		// keterangan
		// jumlah
		// no_keyfield
		// no_level
		// nama_tabel
		// id_data

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// no_urut
		$this->no_urut->ViewValue = $this->no_urut->CurrentValue;
		$this->no_urut->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// jumlah
		$this->jumlah->ViewValue = $this->jumlah->CurrentValue;
		$this->jumlah->ViewCustomAttributes = "";

		// no_keyfield
		$this->no_keyfield->ViewValue = $this->no_keyfield->CurrentValue;
		$this->no_keyfield->ViewCustomAttributes = "";

		// no_level
		$this->no_level->ViewValue = $this->no_level->CurrentValue;
		$this->no_level->ViewCustomAttributes = "";

		// nama_tabel
		$this->nama_tabel->ViewValue = $this->nama_tabel->CurrentValue;
		$this->nama_tabel->ViewCustomAttributes = "";

		// id_data
		$this->id_data->ViewValue = $this->id_data->CurrentValue;
		$this->id_data->ViewCustomAttributes = "";

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

			// no_keyfield
			$this->no_keyfield->LinkCustomAttributes = "";
			$this->no_keyfield->HrefValue = "";
			$this->no_keyfield->TooltipValue = "";

			// no_level
			$this->no_level->LinkCustomAttributes = "";
			$this->no_level->HrefValue = "";
			$this->no_level->TooltipValue = "";

			// nama_tabel
			$this->nama_tabel->LinkCustomAttributes = "";
			$this->nama_tabel->HrefValue = "";
			$this->nama_tabel->TooltipValue = "";

			// id_data
			$this->id_data->LinkCustomAttributes = "";
			$this->id_data->HrefValue = "";
			$this->id_data->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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
			if (strval($this->jumlah->EditValue) <> "" && is_numeric($this->jumlah->EditValue)) $this->jumlah->EditValue = ew_FormatNumber($this->jumlah->EditValue, -2, -1, -2, 0);

			// no_keyfield
			$this->no_keyfield->EditAttrs["class"] = "form-control";
			$this->no_keyfield->EditCustomAttributes = "";
			$this->no_keyfield->EditValue = ew_HtmlEncode($this->no_keyfield->CurrentValue);
			$this->no_keyfield->PlaceHolder = ew_RemoveHtml($this->no_keyfield->FldCaption());

			// no_level
			$this->no_level->EditAttrs["class"] = "form-control";
			$this->no_level->EditCustomAttributes = "";
			$this->no_level->EditValue = ew_HtmlEncode($this->no_level->CurrentValue);
			$this->no_level->PlaceHolder = ew_RemoveHtml($this->no_level->FldCaption());

			// nama_tabel
			$this->nama_tabel->EditAttrs["class"] = "form-control";
			$this->nama_tabel->EditCustomAttributes = "";
			$this->nama_tabel->EditValue = ew_HtmlEncode($this->nama_tabel->CurrentValue);
			$this->nama_tabel->PlaceHolder = ew_RemoveHtml($this->nama_tabel->FldCaption());

			// id_data
			$this->id_data->EditAttrs["class"] = "form-control";
			$this->id_data->EditCustomAttributes = "";
			$this->id_data->EditValue = ew_HtmlEncode($this->id_data->CurrentValue);
			$this->id_data->PlaceHolder = ew_RemoveHtml($this->id_data->FldCaption());

			// Add refer script
			// no_urut

			$this->no_urut->LinkCustomAttributes = "";
			$this->no_urut->HrefValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";

			// jumlah
			$this->jumlah->LinkCustomAttributes = "";
			$this->jumlah->HrefValue = "";

			// no_keyfield
			$this->no_keyfield->LinkCustomAttributes = "";
			$this->no_keyfield->HrefValue = "";

			// no_level
			$this->no_level->LinkCustomAttributes = "";
			$this->no_level->HrefValue = "";

			// nama_tabel
			$this->nama_tabel->LinkCustomAttributes = "";
			$this->nama_tabel->HrefValue = "";

			// id_data
			$this->id_data->LinkCustomAttributes = "";
			$this->id_data->HrefValue = "";
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
		if (!$this->no_urut->FldIsDetailKey && !is_null($this->no_urut->FormValue) && $this->no_urut->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->no_urut->FldCaption(), $this->no_urut->ReqErrMsg));
		}
		if (!$this->keterangan->FldIsDetailKey && !is_null($this->keterangan->FormValue) && $this->keterangan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->keterangan->FldCaption(), $this->keterangan->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->jumlah->FormValue)) {
			ew_AddMessage($gsFormError, $this->jumlah->FldErrMsg());
		}
		if (!$this->no_keyfield->FldIsDetailKey && !is_null($this->no_keyfield->FormValue) && $this->no_keyfield->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->no_keyfield->FldCaption(), $this->no_keyfield->ReqErrMsg));
		}
		if (!$this->no_level->FldIsDetailKey && !is_null($this->no_level->FormValue) && $this->no_level->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->no_level->FldCaption(), $this->no_level->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->no_level->FormValue)) {
			ew_AddMessage($gsFormError, $this->no_level->FldErrMsg());
		}
		if (!$this->nama_tabel->FldIsDetailKey && !is_null($this->nama_tabel->FormValue) && $this->nama_tabel->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama_tabel->FldCaption(), $this->nama_tabel->ReqErrMsg));
		}
		if (!$this->id_data->FldIsDetailKey && !is_null($this->id_data->FormValue) && $this->id_data->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->id_data->FldCaption(), $this->id_data->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->id_data->FormValue)) {
			ew_AddMessage($gsFormError, $this->id_data->FldErrMsg());
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

		// no_urut
		$this->no_urut->SetDbValueDef($rsnew, $this->no_urut->CurrentValue, "", FALSE);

		// keterangan
		$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, "", FALSE);

		// jumlah
		$this->jumlah->SetDbValueDef($rsnew, $this->jumlah->CurrentValue, 0, strval($this->jumlah->CurrentValue) == "");

		// no_keyfield
		$this->no_keyfield->SetDbValueDef($rsnew, $this->no_keyfield->CurrentValue, "", FALSE);

		// no_level
		$this->no_level->SetDbValueDef($rsnew, $this->no_level->CurrentValue, 0, FALSE);

		// nama_tabel
		$this->nama_tabel->SetDbValueDef($rsnew, $this->nama_tabel->CurrentValue, "", FALSE);

		// id_data
		$this->id_data->SetDbValueDef($rsnew, $this->id_data->CurrentValue, 0, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t95_rkas2list.php"), "", $this->TableVar, TRUE);
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
if (!isset($t95_rkas2_add)) $t95_rkas2_add = new ct95_rkas2_add();

// Page init
$t95_rkas2_add->Page_Init();

// Page main
$t95_rkas2_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t95_rkas2_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft95_rkas2add = new ew_Form("ft95_rkas2add", "add");

// Validate form
ft95_rkas2add.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_no_urut");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas2->no_urut->FldCaption(), $t95_rkas2->no_urut->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_keterangan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas2->keterangan->FldCaption(), $t95_rkas2->keterangan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t95_rkas2->jumlah->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_no_keyfield");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas2->no_keyfield->FldCaption(), $t95_rkas2->no_keyfield->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_no_level");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas2->no_level->FldCaption(), $t95_rkas2->no_level->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_no_level");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t95_rkas2->no_level->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_nama_tabel");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas2->nama_tabel->FldCaption(), $t95_rkas2->nama_tabel->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_id_data");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_rkas2->id_data->FldCaption(), $t95_rkas2->id_data->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_id_data");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t95_rkas2->id_data->FldErrMsg()) ?>");

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
ft95_rkas2add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft95_rkas2add.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t95_rkas2_add->ShowPageHeader(); ?>
<?php
$t95_rkas2_add->ShowMessage();
?>
<form name="ft95_rkas2add" id="ft95_rkas2add" class="<?php echo $t95_rkas2_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t95_rkas2_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t95_rkas2_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t95_rkas2">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($t95_rkas2_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($t95_rkas2->no_urut->Visible) { // no_urut ?>
	<div id="r_no_urut" class="form-group">
		<label id="elh_t95_rkas2_no_urut" for="x_no_urut" class="<?php echo $t95_rkas2_add->LeftColumnClass ?>"><?php echo $t95_rkas2->no_urut->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas2_add->RightColumnClass ?>"><div<?php echo $t95_rkas2->no_urut->CellAttributes() ?>>
<span id="el_t95_rkas2_no_urut">
<input type="text" data-table="t95_rkas2" data-field="x_no_urut" name="x_no_urut" id="x_no_urut" size="30" maxlength="12" placeholder="<?php echo ew_HtmlEncode($t95_rkas2->no_urut->getPlaceHolder()) ?>" value="<?php echo $t95_rkas2->no_urut->EditValue ?>"<?php echo $t95_rkas2->no_urut->EditAttributes() ?>>
</span>
<?php echo $t95_rkas2->no_urut->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas2->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_t95_rkas2_keterangan" for="x_keterangan" class="<?php echo $t95_rkas2_add->LeftColumnClass ?>"><?php echo $t95_rkas2->keterangan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas2_add->RightColumnClass ?>"><div<?php echo $t95_rkas2->keterangan->CellAttributes() ?>>
<span id="el_t95_rkas2_keterangan">
<input type="text" data-table="t95_rkas2" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t95_rkas2->keterangan->getPlaceHolder()) ?>" value="<?php echo $t95_rkas2->keterangan->EditValue ?>"<?php echo $t95_rkas2->keterangan->EditAttributes() ?>>
</span>
<?php echo $t95_rkas2->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas2->jumlah->Visible) { // jumlah ?>
	<div id="r_jumlah" class="form-group">
		<label id="elh_t95_rkas2_jumlah" for="x_jumlah" class="<?php echo $t95_rkas2_add->LeftColumnClass ?>"><?php echo $t95_rkas2->jumlah->FldCaption() ?></label>
		<div class="<?php echo $t95_rkas2_add->RightColumnClass ?>"><div<?php echo $t95_rkas2->jumlah->CellAttributes() ?>>
<span id="el_t95_rkas2_jumlah">
<input type="text" data-table="t95_rkas2" data-field="x_jumlah" name="x_jumlah" id="x_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t95_rkas2->jumlah->getPlaceHolder()) ?>" value="<?php echo $t95_rkas2->jumlah->EditValue ?>"<?php echo $t95_rkas2->jumlah->EditAttributes() ?>>
</span>
<?php echo $t95_rkas2->jumlah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas2->no_keyfield->Visible) { // no_keyfield ?>
	<div id="r_no_keyfield" class="form-group">
		<label id="elh_t95_rkas2_no_keyfield" for="x_no_keyfield" class="<?php echo $t95_rkas2_add->LeftColumnClass ?>"><?php echo $t95_rkas2->no_keyfield->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas2_add->RightColumnClass ?>"><div<?php echo $t95_rkas2->no_keyfield->CellAttributes() ?>>
<span id="el_t95_rkas2_no_keyfield">
<input type="text" data-table="t95_rkas2" data-field="x_no_keyfield" name="x_no_keyfield" id="x_no_keyfield" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($t95_rkas2->no_keyfield->getPlaceHolder()) ?>" value="<?php echo $t95_rkas2->no_keyfield->EditValue ?>"<?php echo $t95_rkas2->no_keyfield->EditAttributes() ?>>
</span>
<?php echo $t95_rkas2->no_keyfield->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas2->no_level->Visible) { // no_level ?>
	<div id="r_no_level" class="form-group">
		<label id="elh_t95_rkas2_no_level" for="x_no_level" class="<?php echo $t95_rkas2_add->LeftColumnClass ?>"><?php echo $t95_rkas2->no_level->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas2_add->RightColumnClass ?>"><div<?php echo $t95_rkas2->no_level->CellAttributes() ?>>
<span id="el_t95_rkas2_no_level">
<input type="text" data-table="t95_rkas2" data-field="x_no_level" name="x_no_level" id="x_no_level" size="30" placeholder="<?php echo ew_HtmlEncode($t95_rkas2->no_level->getPlaceHolder()) ?>" value="<?php echo $t95_rkas2->no_level->EditValue ?>"<?php echo $t95_rkas2->no_level->EditAttributes() ?>>
</span>
<?php echo $t95_rkas2->no_level->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas2->nama_tabel->Visible) { // nama_tabel ?>
	<div id="r_nama_tabel" class="form-group">
		<label id="elh_t95_rkas2_nama_tabel" for="x_nama_tabel" class="<?php echo $t95_rkas2_add->LeftColumnClass ?>"><?php echo $t95_rkas2->nama_tabel->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas2_add->RightColumnClass ?>"><div<?php echo $t95_rkas2->nama_tabel->CellAttributes() ?>>
<span id="el_t95_rkas2_nama_tabel">
<input type="text" data-table="t95_rkas2" data-field="x_nama_tabel" name="x_nama_tabel" id="x_nama_tabel" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t95_rkas2->nama_tabel->getPlaceHolder()) ?>" value="<?php echo $t95_rkas2->nama_tabel->EditValue ?>"<?php echo $t95_rkas2->nama_tabel->EditAttributes() ?>>
</span>
<?php echo $t95_rkas2->nama_tabel->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t95_rkas2->id_data->Visible) { // id_data ?>
	<div id="r_id_data" class="form-group">
		<label id="elh_t95_rkas2_id_data" for="x_id_data" class="<?php echo $t95_rkas2_add->LeftColumnClass ?>"><?php echo $t95_rkas2->id_data->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t95_rkas2_add->RightColumnClass ?>"><div<?php echo $t95_rkas2->id_data->CellAttributes() ?>>
<span id="el_t95_rkas2_id_data">
<input type="text" data-table="t95_rkas2" data-field="x_id_data" name="x_id_data" id="x_id_data" size="30" placeholder="<?php echo ew_HtmlEncode($t95_rkas2->id_data->getPlaceHolder()) ?>" value="<?php echo $t95_rkas2->id_data->EditValue ?>"<?php echo $t95_rkas2->id_data->EditAttributes() ?>>
</span>
<?php echo $t95_rkas2->id_data->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$t95_rkas2_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t95_rkas2_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t95_rkas2_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ft95_rkas2add.Init();
</script>
<?php
$t95_rkas2_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t95_rkas2_add->Page_Terminate();
?>
