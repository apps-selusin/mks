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

$t01_master_sekolah_edit = NULL; // Initialize page object first

class ct01_master_sekolah_edit extends ct01_master_sekolah {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}';

	// Table name
	var $TableName = 't01_master_sekolah';

	// Page object name
	var $PageObjName = 't01_master_sekolah_edit';

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

		// Table object (t01_master_sekolah)
		if (!isset($GLOBALS["t01_master_sekolah"]) || get_class($GLOBALS["t01_master_sekolah"]) == "ct01_master_sekolah") {
			$GLOBALS["t01_master_sekolah"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t01_master_sekolah"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $RecCnt;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";

		// Load record by position
		$loadByPosition = FALSE;
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_id")) {
				$this->id->setFormValue($objForm->GetValue("x_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["id"])) {
				$this->id->setQueryStringValue($_GET["id"]);
				$loadByQuery = TRUE;
			} else {
				$this->id->CurrentValue = NULL;
			}
			if (!$loadByQuery)
				$loadByPosition = TRUE;
		}

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("t01_master_sekolahlist.php"); // Return to list page
		} elseif ($loadByPosition) { // Load record by position
			$this->SetupStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$this->Recordset->Move($this->StartRec-1);
				$loaded = TRUE;
			}
		} else { // Match key values
			if (!is_null($this->id->CurrentValue)) {
				while (!$this->Recordset->EOF) {
					if (strval($this->id->CurrentValue) == strval($this->Recordset->fields('id'))) {
						$this->setStartRecordNumber($this->StartRec); // Save record position
						$loaded = TRUE;
						break;
					} else {
						$this->StartRec++;
						$this->Recordset->MoveNext();
					}
				}
			}
		}

		// Load current row values
		if ($loaded)
			$this->LoadRowValues($this->Recordset);

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("t01_master_sekolahlist.php"); // Return to list page
				} else {
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t01_master_sekolahlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
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
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
		$this->no_stat->CurrentValue = $this->no_stat->FormValue;
		$this->nama->CurrentValue = $this->nama->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->desa->CurrentValue = $this->desa->FormValue;
		$this->kecamatan->CurrentValue = $this->kecamatan->FormValue;
		$this->kabupaten->CurrentValue = $this->kabupaten->FormValue;
		$this->provinsi->CurrentValue = $this->provinsi->FormValue;
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
		$row = array();
		$row['id'] = NULL;
		$row['no_stat'] = NULL;
		$row['nama'] = NULL;
		$row['status'] = NULL;
		$row['desa'] = NULL;
		$row['kecamatan'] = NULL;
		$row['kabupaten'] = NULL;
		$row['provinsi'] = NULL;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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

			// Edit refer script
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// no_stat
			$this->no_stat->SetDbValueDef($rsnew, $this->no_stat->CurrentValue, "", $this->no_stat->ReadOnly);

			// nama
			$this->nama->SetDbValueDef($rsnew, $this->nama->CurrentValue, "", $this->nama->ReadOnly);

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", $this->status->ReadOnly);

			// desa
			$this->desa->SetDbValueDef($rsnew, $this->desa->CurrentValue, "", $this->desa->ReadOnly);

			// kecamatan
			$this->kecamatan->SetDbValueDef($rsnew, $this->kecamatan->CurrentValue, "", $this->kecamatan->ReadOnly);

			// kabupaten
			$this->kabupaten->SetDbValueDef($rsnew, $this->kabupaten->CurrentValue, "", $this->kabupaten->ReadOnly);

			// provinsi
			$this->provinsi->SetDbValueDef($rsnew, $this->provinsi->CurrentValue, "", $this->provinsi->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t01_master_sekolahlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($t01_master_sekolah_edit)) $t01_master_sekolah_edit = new ct01_master_sekolah_edit();

// Page init
$t01_master_sekolah_edit->Page_Init();

// Page main
$t01_master_sekolah_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t01_master_sekolah_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft01_master_sekolahedit = new ew_Form("ft01_master_sekolahedit", "edit");

// Validate form
ft01_master_sekolahedit.Validate = function() {
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
ft01_master_sekolahedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft01_master_sekolahedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t01_master_sekolah_edit->ShowPageHeader(); ?>
<?php
$t01_master_sekolah_edit->ShowMessage();
?>
<?php if (!$t01_master_sekolah_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t01_master_sekolah_edit->Pager)) $t01_master_sekolah_edit->Pager = new cPrevNextPager($t01_master_sekolah_edit->StartRec, $t01_master_sekolah_edit->DisplayRecs, $t01_master_sekolah_edit->TotalRecs, $t01_master_sekolah_edit->AutoHidePager) ?>
<?php if ($t01_master_sekolah_edit->Pager->RecordCount > 0 && $t01_master_sekolah_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t01_master_sekolah_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t01_master_sekolah_edit->PageUrl() ?>start=<?php echo $t01_master_sekolah_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t01_master_sekolah_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t01_master_sekolah_edit->PageUrl() ?>start=<?php echo $t01_master_sekolah_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t01_master_sekolah_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t01_master_sekolah_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t01_master_sekolah_edit->PageUrl() ?>start=<?php echo $t01_master_sekolah_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t01_master_sekolah_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t01_master_sekolah_edit->PageUrl() ?>start=<?php echo $t01_master_sekolah_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t01_master_sekolah_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="ft01_master_sekolahedit" id="ft01_master_sekolahedit" class="<?php echo $t01_master_sekolah_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t01_master_sekolah_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t01_master_sekolah_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t01_master_sekolah">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($t01_master_sekolah_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($t01_master_sekolah->no_stat->Visible) { // no_stat ?>
	<div id="r_no_stat" class="form-group">
		<label id="elh_t01_master_sekolah_no_stat" for="x_no_stat" class="<?php echo $t01_master_sekolah_edit->LeftColumnClass ?>"><?php echo $t01_master_sekolah->no_stat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_master_sekolah_edit->RightColumnClass ?>"><div<?php echo $t01_master_sekolah->no_stat->CellAttributes() ?>>
<span id="el_t01_master_sekolah_no_stat">
<input type="text" data-table="t01_master_sekolah" data-field="x_no_stat" name="x_no_stat" id="x_no_stat" size="30" maxlength="12" placeholder="<?php echo ew_HtmlEncode($t01_master_sekolah->no_stat->getPlaceHolder()) ?>" value="<?php echo $t01_master_sekolah->no_stat->EditValue ?>"<?php echo $t01_master_sekolah->no_stat->EditAttributes() ?>>
</span>
<?php echo $t01_master_sekolah->no_stat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_master_sekolah->nama->Visible) { // nama ?>
	<div id="r_nama" class="form-group">
		<label id="elh_t01_master_sekolah_nama" for="x_nama" class="<?php echo $t01_master_sekolah_edit->LeftColumnClass ?>"><?php echo $t01_master_sekolah->nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_master_sekolah_edit->RightColumnClass ?>"><div<?php echo $t01_master_sekolah->nama->CellAttributes() ?>>
<span id="el_t01_master_sekolah_nama">
<input type="text" data-table="t01_master_sekolah" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_master_sekolah->nama->getPlaceHolder()) ?>" value="<?php echo $t01_master_sekolah->nama->EditValue ?>"<?php echo $t01_master_sekolah->nama->EditAttributes() ?>>
</span>
<?php echo $t01_master_sekolah->nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_master_sekolah->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_t01_master_sekolah_status" for="x_status" class="<?php echo $t01_master_sekolah_edit->LeftColumnClass ?>"><?php echo $t01_master_sekolah->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_master_sekolah_edit->RightColumnClass ?>"><div<?php echo $t01_master_sekolah->status->CellAttributes() ?>>
<span id="el_t01_master_sekolah_status">
<input type="text" data-table="t01_master_sekolah" data-field="x_status" name="x_status" id="x_status" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_master_sekolah->status->getPlaceHolder()) ?>" value="<?php echo $t01_master_sekolah->status->EditValue ?>"<?php echo $t01_master_sekolah->status->EditAttributes() ?>>
</span>
<?php echo $t01_master_sekolah->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_master_sekolah->desa->Visible) { // desa ?>
	<div id="r_desa" class="form-group">
		<label id="elh_t01_master_sekolah_desa" for="x_desa" class="<?php echo $t01_master_sekolah_edit->LeftColumnClass ?>"><?php echo $t01_master_sekolah->desa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_master_sekolah_edit->RightColumnClass ?>"><div<?php echo $t01_master_sekolah->desa->CellAttributes() ?>>
<span id="el_t01_master_sekolah_desa">
<input type="text" data-table="t01_master_sekolah" data-field="x_desa" name="x_desa" id="x_desa" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_master_sekolah->desa->getPlaceHolder()) ?>" value="<?php echo $t01_master_sekolah->desa->EditValue ?>"<?php echo $t01_master_sekolah->desa->EditAttributes() ?>>
</span>
<?php echo $t01_master_sekolah->desa->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_master_sekolah->kecamatan->Visible) { // kecamatan ?>
	<div id="r_kecamatan" class="form-group">
		<label id="elh_t01_master_sekolah_kecamatan" for="x_kecamatan" class="<?php echo $t01_master_sekolah_edit->LeftColumnClass ?>"><?php echo $t01_master_sekolah->kecamatan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_master_sekolah_edit->RightColumnClass ?>"><div<?php echo $t01_master_sekolah->kecamatan->CellAttributes() ?>>
<span id="el_t01_master_sekolah_kecamatan">
<input type="text" data-table="t01_master_sekolah" data-field="x_kecamatan" name="x_kecamatan" id="x_kecamatan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_master_sekolah->kecamatan->getPlaceHolder()) ?>" value="<?php echo $t01_master_sekolah->kecamatan->EditValue ?>"<?php echo $t01_master_sekolah->kecamatan->EditAttributes() ?>>
</span>
<?php echo $t01_master_sekolah->kecamatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_master_sekolah->kabupaten->Visible) { // kabupaten ?>
	<div id="r_kabupaten" class="form-group">
		<label id="elh_t01_master_sekolah_kabupaten" for="x_kabupaten" class="<?php echo $t01_master_sekolah_edit->LeftColumnClass ?>"><?php echo $t01_master_sekolah->kabupaten->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_master_sekolah_edit->RightColumnClass ?>"><div<?php echo $t01_master_sekolah->kabupaten->CellAttributes() ?>>
<span id="el_t01_master_sekolah_kabupaten">
<input type="text" data-table="t01_master_sekolah" data-field="x_kabupaten" name="x_kabupaten" id="x_kabupaten" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_master_sekolah->kabupaten->getPlaceHolder()) ?>" value="<?php echo $t01_master_sekolah->kabupaten->EditValue ?>"<?php echo $t01_master_sekolah->kabupaten->EditAttributes() ?>>
</span>
<?php echo $t01_master_sekolah->kabupaten->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_master_sekolah->provinsi->Visible) { // provinsi ?>
	<div id="r_provinsi" class="form-group">
		<label id="elh_t01_master_sekolah_provinsi" for="x_provinsi" class="<?php echo $t01_master_sekolah_edit->LeftColumnClass ?>"><?php echo $t01_master_sekolah->provinsi->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t01_master_sekolah_edit->RightColumnClass ?>"><div<?php echo $t01_master_sekolah->provinsi->CellAttributes() ?>>
<span id="el_t01_master_sekolah_provinsi">
<input type="text" data-table="t01_master_sekolah" data-field="x_provinsi" name="x_provinsi" id="x_provinsi" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_master_sekolah->provinsi->getPlaceHolder()) ?>" value="<?php echo $t01_master_sekolah->provinsi->EditValue ?>"<?php echo $t01_master_sekolah->provinsi->EditAttributes() ?>>
</span>
<?php echo $t01_master_sekolah->provinsi->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<input type="hidden" data-table="t01_master_sekolah" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($t01_master_sekolah->id->CurrentValue) ?>">
<?php if (!$t01_master_sekolah_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t01_master_sekolah_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t01_master_sekolah_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$t01_master_sekolah_edit->IsModal) { ?>
<?php if (!isset($t01_master_sekolah_edit->Pager)) $t01_master_sekolah_edit->Pager = new cPrevNextPager($t01_master_sekolah_edit->StartRec, $t01_master_sekolah_edit->DisplayRecs, $t01_master_sekolah_edit->TotalRecs, $t01_master_sekolah_edit->AutoHidePager) ?>
<?php if ($t01_master_sekolah_edit->Pager->RecordCount > 0 && $t01_master_sekolah_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t01_master_sekolah_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t01_master_sekolah_edit->PageUrl() ?>start=<?php echo $t01_master_sekolah_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t01_master_sekolah_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t01_master_sekolah_edit->PageUrl() ?>start=<?php echo $t01_master_sekolah_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t01_master_sekolah_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t01_master_sekolah_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t01_master_sekolah_edit->PageUrl() ?>start=<?php echo $t01_master_sekolah_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t01_master_sekolah_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t01_master_sekolah_edit->PageUrl() ?>start=<?php echo $t01_master_sekolah_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t01_master_sekolah_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
ft01_master_sekolahedit.Init();
</script>
<?php
$t01_master_sekolah_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t01_master_sekolah_edit->Page_Terminate();
?>
