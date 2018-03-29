<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t02_rkasinfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t02_rkas_edit = NULL; // Initialize page object first

class ct02_rkas_edit extends ct02_rkas {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}';

	// Table name
	var $TableName = 't02_rkas';

	// Page object name
	var $PageObjName = 't02_rkas_edit';

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

		// Table object (t02_rkas)
		if (!isset($GLOBALS["t02_rkas"]) || get_class($GLOBALS["t02_rkas"]) == "ct02_rkas") {
			$GLOBALS["t02_rkas"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t02_rkas"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't02_rkas', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t02_rkaslist.php"));
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
		$this->lvl->SetVisibility();
		$this->urutan->SetVisibility();
		$this->nour1->SetVisibility();
		$this->ket1->SetVisibility();
		$this->jml1->SetVisibility();
		$this->nour2->SetVisibility();
		$this->ket2->SetVisibility();
		$this->jml2->SetVisibility();

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
		global $EW_EXPORT, $t02_rkas;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t02_rkas);
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
					if ($pageName == "t02_rkasview.php")
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
			$this->Page_Terminate("t02_rkaslist.php"); // Return to list page
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
					$this->Page_Terminate("t02_rkaslist.php"); // Return to list page
				} else {
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t02_rkaslist.php")
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
		if (!$this->lvl->FldIsDetailKey) {
			$this->lvl->setFormValue($objForm->GetValue("x_lvl"));
		}
		if (!$this->urutan->FldIsDetailKey) {
			$this->urutan->setFormValue($objForm->GetValue("x_urutan"));
		}
		if (!$this->nour1->FldIsDetailKey) {
			$this->nour1->setFormValue($objForm->GetValue("x_nour1"));
		}
		if (!$this->ket1->FldIsDetailKey) {
			$this->ket1->setFormValue($objForm->GetValue("x_ket1"));
		}
		if (!$this->jml1->FldIsDetailKey) {
			$this->jml1->setFormValue($objForm->GetValue("x_jml1"));
		}
		if (!$this->nour2->FldIsDetailKey) {
			$this->nour2->setFormValue($objForm->GetValue("x_nour2"));
		}
		if (!$this->ket2->FldIsDetailKey) {
			$this->ket2->setFormValue($objForm->GetValue("x_ket2"));
		}
		if (!$this->jml2->FldIsDetailKey) {
			$this->jml2->setFormValue($objForm->GetValue("x_jml2"));
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
		$this->lvl->CurrentValue = $this->lvl->FormValue;
		$this->urutan->CurrentValue = $this->urutan->FormValue;
		$this->nour1->CurrentValue = $this->nour1->FormValue;
		$this->ket1->CurrentValue = $this->ket1->FormValue;
		$this->jml1->CurrentValue = $this->jml1->FormValue;
		$this->nour2->CurrentValue = $this->nour2->FormValue;
		$this->ket2->CurrentValue = $this->ket2->FormValue;
		$this->jml2->CurrentValue = $this->jml2->FormValue;
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
		$this->lvl->setDbValue($row['lvl']);
		$this->urutan->setDbValue($row['urutan']);
		$this->nour1->setDbValue($row['nour1']);
		$this->ket1->setDbValue($row['ket1']);
		$this->jml1->setDbValue($row['jml1']);
		$this->nour2->setDbValue($row['nour2']);
		$this->ket2->setDbValue($row['ket2']);
		$this->jml2->setDbValue($row['jml2']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['lvl'] = NULL;
		$row['urutan'] = NULL;
		$row['nour1'] = NULL;
		$row['ket1'] = NULL;
		$row['jml1'] = NULL;
		$row['nour2'] = NULL;
		$row['ket2'] = NULL;
		$row['jml2'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->lvl->DbValue = $row['lvl'];
		$this->urutan->DbValue = $row['urutan'];
		$this->nour1->DbValue = $row['nour1'];
		$this->ket1->DbValue = $row['ket1'];
		$this->jml1->DbValue = $row['jml1'];
		$this->nour2->DbValue = $row['nour2'];
		$this->ket2->DbValue = $row['ket2'];
		$this->jml2->DbValue = $row['jml2'];
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

		if ($this->jml1->FormValue == $this->jml1->CurrentValue && is_numeric(ew_StrToFloat($this->jml1->CurrentValue)))
			$this->jml1->CurrentValue = ew_StrToFloat($this->jml1->CurrentValue);

		// Convert decimal values if posted back
		if ($this->jml2->FormValue == $this->jml2->CurrentValue && is_numeric(ew_StrToFloat($this->jml2->CurrentValue)))
			$this->jml2->CurrentValue = ew_StrToFloat($this->jml2->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// lvl
		// urutan
		// nour1
		// ket1
		// jml1
		// nour2
		// ket2
		// jml2

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// lvl
		$this->lvl->ViewValue = $this->lvl->CurrentValue;
		$this->lvl->ViewCustomAttributes = "";

		// urutan
		$this->urutan->ViewValue = $this->urutan->CurrentValue;
		$this->urutan->ViewCustomAttributes = "";

		// nour1
		$this->nour1->ViewValue = $this->nour1->CurrentValue;
		$this->nour1->ViewCustomAttributes = "";

		// ket1
		$this->ket1->ViewValue = $this->ket1->CurrentValue;
		$this->ket1->ViewCustomAttributes = "";

		// jml1
		$this->jml1->ViewValue = $this->jml1->CurrentValue;
		$this->jml1->ViewValue = ew_FormatNumber($this->jml1->ViewValue, 0, -2, -2, -2);
		$this->jml1->CellCssStyle .= "text-align: right;";
		$this->jml1->ViewCustomAttributes = "";

		// nour2
		$this->nour2->ViewValue = $this->nour2->CurrentValue;
		$this->nour2->ViewCustomAttributes = "";

		// ket2
		$this->ket2->ViewValue = $this->ket2->CurrentValue;
		$this->ket2->ViewCustomAttributes = "";

		// jml2
		$this->jml2->ViewValue = $this->jml2->CurrentValue;
		$this->jml2->ViewValue = ew_FormatNumber($this->jml2->ViewValue, 0, -2, -2, -2);
		$this->jml2->CellCssStyle .= "text-align: right;";
		$this->jml2->ViewCustomAttributes = "";

			// lvl
			$this->lvl->LinkCustomAttributes = "";
			$this->lvl->HrefValue = "";
			$this->lvl->TooltipValue = "";

			// urutan
			$this->urutan->LinkCustomAttributes = "";
			$this->urutan->HrefValue = "";
			$this->urutan->TooltipValue = "";

			// nour1
			$this->nour1->LinkCustomAttributes = "";
			$this->nour1->HrefValue = "";
			$this->nour1->TooltipValue = "";

			// ket1
			$this->ket1->LinkCustomAttributes = "";
			$this->ket1->HrefValue = "";
			$this->ket1->TooltipValue = "";

			// jml1
			$this->jml1->LinkCustomAttributes = "";
			$this->jml1->HrefValue = "";
			$this->jml1->TooltipValue = "";

			// nour2
			$this->nour2->LinkCustomAttributes = "";
			$this->nour2->HrefValue = "";
			$this->nour2->TooltipValue = "";

			// ket2
			$this->ket2->LinkCustomAttributes = "";
			$this->ket2->HrefValue = "";
			$this->ket2->TooltipValue = "";

			// jml2
			$this->jml2->LinkCustomAttributes = "";
			$this->jml2->HrefValue = "";
			$this->jml2->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// lvl
			$this->lvl->EditAttrs["class"] = "form-control";
			$this->lvl->EditCustomAttributes = "";
			$this->lvl->EditValue = ew_HtmlEncode($this->lvl->CurrentValue);
			$this->lvl->PlaceHolder = ew_RemoveHtml($this->lvl->FldCaption());

			// urutan
			$this->urutan->EditAttrs["class"] = "form-control";
			$this->urutan->EditCustomAttributes = "";
			$this->urutan->EditValue = ew_HtmlEncode($this->urutan->CurrentValue);
			$this->urutan->PlaceHolder = ew_RemoveHtml($this->urutan->FldCaption());

			// nour1
			$this->nour1->EditAttrs["class"] = "form-control";
			$this->nour1->EditCustomAttributes = "";
			$this->nour1->EditValue = ew_HtmlEncode($this->nour1->CurrentValue);
			$this->nour1->PlaceHolder = ew_RemoveHtml($this->nour1->FldCaption());

			// ket1
			$this->ket1->EditAttrs["class"] = "form-control";
			$this->ket1->EditCustomAttributes = "";
			$this->ket1->EditValue = ew_HtmlEncode($this->ket1->CurrentValue);
			$this->ket1->PlaceHolder = ew_RemoveHtml($this->ket1->FldCaption());

			// jml1
			$this->jml1->EditAttrs["class"] = "form-control";
			$this->jml1->EditCustomAttributes = "";
			$this->jml1->EditValue = ew_HtmlEncode($this->jml1->CurrentValue);
			$this->jml1->PlaceHolder = ew_RemoveHtml($this->jml1->FldCaption());
			if (strval($this->jml1->EditValue) <> "" && is_numeric($this->jml1->EditValue)) $this->jml1->EditValue = ew_FormatNumber($this->jml1->EditValue, -2, -2, -2, -2);

			// nour2
			$this->nour2->EditAttrs["class"] = "form-control";
			$this->nour2->EditCustomAttributes = "";
			$this->nour2->EditValue = ew_HtmlEncode($this->nour2->CurrentValue);
			$this->nour2->PlaceHolder = ew_RemoveHtml($this->nour2->FldCaption());

			// ket2
			$this->ket2->EditAttrs["class"] = "form-control";
			$this->ket2->EditCustomAttributes = "";
			$this->ket2->EditValue = ew_HtmlEncode($this->ket2->CurrentValue);
			$this->ket2->PlaceHolder = ew_RemoveHtml($this->ket2->FldCaption());

			// jml2
			$this->jml2->EditAttrs["class"] = "form-control";
			$this->jml2->EditCustomAttributes = "";
			$this->jml2->EditValue = ew_HtmlEncode($this->jml2->CurrentValue);
			$this->jml2->PlaceHolder = ew_RemoveHtml($this->jml2->FldCaption());
			if (strval($this->jml2->EditValue) <> "" && is_numeric($this->jml2->EditValue)) $this->jml2->EditValue = ew_FormatNumber($this->jml2->EditValue, -2, -2, -2, -2);

			// Edit refer script
			// lvl

			$this->lvl->LinkCustomAttributes = "";
			$this->lvl->HrefValue = "";

			// urutan
			$this->urutan->LinkCustomAttributes = "";
			$this->urutan->HrefValue = "";

			// nour1
			$this->nour1->LinkCustomAttributes = "";
			$this->nour1->HrefValue = "";

			// ket1
			$this->ket1->LinkCustomAttributes = "";
			$this->ket1->HrefValue = "";

			// jml1
			$this->jml1->LinkCustomAttributes = "";
			$this->jml1->HrefValue = "";

			// nour2
			$this->nour2->LinkCustomAttributes = "";
			$this->nour2->HrefValue = "";

			// ket2
			$this->ket2->LinkCustomAttributes = "";
			$this->ket2->HrefValue = "";

			// jml2
			$this->jml2->LinkCustomAttributes = "";
			$this->jml2->HrefValue = "";
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
		if (!$this->lvl->FldIsDetailKey && !is_null($this->lvl->FormValue) && $this->lvl->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->lvl->FldCaption(), $this->lvl->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->lvl->FormValue)) {
			ew_AddMessage($gsFormError, $this->lvl->FldErrMsg());
		}
		if (!$this->urutan->FldIsDetailKey && !is_null($this->urutan->FormValue) && $this->urutan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->urutan->FldCaption(), $this->urutan->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->urutan->FormValue)) {
			ew_AddMessage($gsFormError, $this->urutan->FldErrMsg());
		}
		if (!ew_CheckNumber($this->jml1->FormValue)) {
			ew_AddMessage($gsFormError, $this->jml1->FldErrMsg());
		}
		if (!ew_CheckNumber($this->jml2->FormValue)) {
			ew_AddMessage($gsFormError, $this->jml2->FldErrMsg());
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

			// lvl
			$this->lvl->SetDbValueDef($rsnew, $this->lvl->CurrentValue, 0, $this->lvl->ReadOnly);

			// urutan
			$this->urutan->SetDbValueDef($rsnew, $this->urutan->CurrentValue, 0, $this->urutan->ReadOnly);

			// nour1
			$this->nour1->SetDbValueDef($rsnew, $this->nour1->CurrentValue, NULL, $this->nour1->ReadOnly);

			// ket1
			$this->ket1->SetDbValueDef($rsnew, $this->ket1->CurrentValue, NULL, $this->ket1->ReadOnly);

			// jml1
			$this->jml1->SetDbValueDef($rsnew, $this->jml1->CurrentValue, NULL, $this->jml1->ReadOnly);

			// nour2
			$this->nour2->SetDbValueDef($rsnew, $this->nour2->CurrentValue, NULL, $this->nour2->ReadOnly);

			// ket2
			$this->ket2->SetDbValueDef($rsnew, $this->ket2->CurrentValue, NULL, $this->ket2->ReadOnly);

			// jml2
			$this->jml2->SetDbValueDef($rsnew, $this->jml2->CurrentValue, NULL, $this->jml2->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t02_rkaslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t02_rkas_edit)) $t02_rkas_edit = new ct02_rkas_edit();

// Page init
$t02_rkas_edit->Page_Init();

// Page main
$t02_rkas_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t02_rkas_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft02_rkasedit = new ew_Form("ft02_rkasedit", "edit");

// Validate form
ft02_rkasedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_lvl");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t02_rkas->lvl->FldCaption(), $t02_rkas->lvl->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_lvl");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_rkas->lvl->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_urutan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t02_rkas->urutan->FldCaption(), $t02_rkas->urutan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_urutan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_rkas->urutan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jml1");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_rkas->jml1->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jml2");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t02_rkas->jml2->FldErrMsg()) ?>");

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
ft02_rkasedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft02_rkasedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t02_rkas_edit->ShowPageHeader(); ?>
<?php
$t02_rkas_edit->ShowMessage();
?>
<?php if (!$t02_rkas_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t02_rkas_edit->Pager)) $t02_rkas_edit->Pager = new cPrevNextPager($t02_rkas_edit->StartRec, $t02_rkas_edit->DisplayRecs, $t02_rkas_edit->TotalRecs, $t02_rkas_edit->AutoHidePager) ?>
<?php if ($t02_rkas_edit->Pager->RecordCount > 0 && $t02_rkas_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t02_rkas_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t02_rkas_edit->PageUrl() ?>start=<?php echo $t02_rkas_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t02_rkas_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t02_rkas_edit->PageUrl() ?>start=<?php echo $t02_rkas_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t02_rkas_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t02_rkas_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t02_rkas_edit->PageUrl() ?>start=<?php echo $t02_rkas_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t02_rkas_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t02_rkas_edit->PageUrl() ?>start=<?php echo $t02_rkas_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t02_rkas_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="ft02_rkasedit" id="ft02_rkasedit" class="<?php echo $t02_rkas_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t02_rkas_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t02_rkas_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t02_rkas">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($t02_rkas_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($t02_rkas->lvl->Visible) { // lvl ?>
	<div id="r_lvl" class="form-group">
		<label id="elh_t02_rkas_lvl" for="x_lvl" class="<?php echo $t02_rkas_edit->LeftColumnClass ?>"><?php echo $t02_rkas->lvl->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_rkas_edit->RightColumnClass ?>"><div<?php echo $t02_rkas->lvl->CellAttributes() ?>>
<span id="el_t02_rkas_lvl">
<input type="text" data-table="t02_rkas" data-field="x_lvl" name="x_lvl" id="x_lvl" size="1" placeholder="<?php echo ew_HtmlEncode($t02_rkas->lvl->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->lvl->EditValue ?>"<?php echo $t02_rkas->lvl->EditAttributes() ?>>
</span>
<?php echo $t02_rkas->lvl->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_rkas->urutan->Visible) { // urutan ?>
	<div id="r_urutan" class="form-group">
		<label id="elh_t02_rkas_urutan" for="x_urutan" class="<?php echo $t02_rkas_edit->LeftColumnClass ?>"><?php echo $t02_rkas->urutan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t02_rkas_edit->RightColumnClass ?>"><div<?php echo $t02_rkas->urutan->CellAttributes() ?>>
<span id="el_t02_rkas_urutan">
<input type="text" data-table="t02_rkas" data-field="x_urutan" name="x_urutan" id="x_urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t02_rkas->urutan->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->urutan->EditValue ?>"<?php echo $t02_rkas->urutan->EditAttributes() ?>>
</span>
<?php echo $t02_rkas->urutan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_rkas->nour1->Visible) { // nour1 ?>
	<div id="r_nour1" class="form-group">
		<label id="elh_t02_rkas_nour1" for="x_nour1" class="<?php echo $t02_rkas_edit->LeftColumnClass ?>"><?php echo $t02_rkas->nour1->FldCaption() ?></label>
		<div class="<?php echo $t02_rkas_edit->RightColumnClass ?>"><div<?php echo $t02_rkas->nour1->CellAttributes() ?>>
<span id="el_t02_rkas_nour1">
<input type="text" data-table="t02_rkas" data-field="x_nour1" name="x_nour1" id="x_nour1" size="3" placeholder="<?php echo ew_HtmlEncode($t02_rkas->nour1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->nour1->EditValue ?>"<?php echo $t02_rkas->nour1->EditAttributes() ?>>
</span>
<?php echo $t02_rkas->nour1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_rkas->ket1->Visible) { // ket1 ?>
	<div id="r_ket1" class="form-group">
		<label id="elh_t02_rkas_ket1" for="x_ket1" class="<?php echo $t02_rkas_edit->LeftColumnClass ?>"><?php echo $t02_rkas->ket1->FldCaption() ?></label>
		<div class="<?php echo $t02_rkas_edit->RightColumnClass ?>"><div<?php echo $t02_rkas->ket1->CellAttributes() ?>>
<span id="el_t02_rkas_ket1">
<input type="text" data-table="t02_rkas" data-field="x_ket1" name="x_ket1" id="x_ket1" size="20" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_rkas->ket1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->ket1->EditValue ?>"<?php echo $t02_rkas->ket1->EditAttributes() ?>>
</span>
<?php echo $t02_rkas->ket1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_rkas->jml1->Visible) { // jml1 ?>
	<div id="r_jml1" class="form-group">
		<label id="elh_t02_rkas_jml1" for="x_jml1" class="<?php echo $t02_rkas_edit->LeftColumnClass ?>"><?php echo $t02_rkas->jml1->FldCaption() ?></label>
		<div class="<?php echo $t02_rkas_edit->RightColumnClass ?>"><div<?php echo $t02_rkas->jml1->CellAttributes() ?>>
<span id="el_t02_rkas_jml1">
<input type="text" data-table="t02_rkas" data-field="x_jml1" name="x_jml1" id="x_jml1" size="10" placeholder="<?php echo ew_HtmlEncode($t02_rkas->jml1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->jml1->EditValue ?>"<?php echo $t02_rkas->jml1->EditAttributes() ?>>
</span>
<?php echo $t02_rkas->jml1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_rkas->nour2->Visible) { // nour2 ?>
	<div id="r_nour2" class="form-group">
		<label id="elh_t02_rkas_nour2" for="x_nour2" class="<?php echo $t02_rkas_edit->LeftColumnClass ?>"><?php echo $t02_rkas->nour2->FldCaption() ?></label>
		<div class="<?php echo $t02_rkas_edit->RightColumnClass ?>"><div<?php echo $t02_rkas->nour2->CellAttributes() ?>>
<span id="el_t02_rkas_nour2">
<input type="text" data-table="t02_rkas" data-field="x_nour2" name="x_nour2" id="x_nour2" size="3" placeholder="<?php echo ew_HtmlEncode($t02_rkas->nour2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->nour2->EditValue ?>"<?php echo $t02_rkas->nour2->EditAttributes() ?>>
</span>
<?php echo $t02_rkas->nour2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_rkas->ket2->Visible) { // ket2 ?>
	<div id="r_ket2" class="form-group">
		<label id="elh_t02_rkas_ket2" for="x_ket2" class="<?php echo $t02_rkas_edit->LeftColumnClass ?>"><?php echo $t02_rkas->ket2->FldCaption() ?></label>
		<div class="<?php echo $t02_rkas_edit->RightColumnClass ?>"><div<?php echo $t02_rkas->ket2->CellAttributes() ?>>
<span id="el_t02_rkas_ket2">
<input type="text" data-table="t02_rkas" data-field="x_ket2" name="x_ket2" id="x_ket2" size="20" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_rkas->ket2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->ket2->EditValue ?>"<?php echo $t02_rkas->ket2->EditAttributes() ?>>
</span>
<?php echo $t02_rkas->ket2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t02_rkas->jml2->Visible) { // jml2 ?>
	<div id="r_jml2" class="form-group">
		<label id="elh_t02_rkas_jml2" for="x_jml2" class="<?php echo $t02_rkas_edit->LeftColumnClass ?>"><?php echo $t02_rkas->jml2->FldCaption() ?></label>
		<div class="<?php echo $t02_rkas_edit->RightColumnClass ?>"><div<?php echo $t02_rkas->jml2->CellAttributes() ?>>
<span id="el_t02_rkas_jml2">
<input type="text" data-table="t02_rkas" data-field="x_jml2" name="x_jml2" id="x_jml2" size="10" placeholder="<?php echo ew_HtmlEncode($t02_rkas->jml2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->jml2->EditValue ?>"<?php echo $t02_rkas->jml2->EditAttributes() ?>>
</span>
<?php echo $t02_rkas->jml2->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<input type="hidden" data-table="t02_rkas" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($t02_rkas->id->CurrentValue) ?>">
<?php if (!$t02_rkas_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t02_rkas_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t02_rkas_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$t02_rkas_edit->IsModal) { ?>
<?php if (!isset($t02_rkas_edit->Pager)) $t02_rkas_edit->Pager = new cPrevNextPager($t02_rkas_edit->StartRec, $t02_rkas_edit->DisplayRecs, $t02_rkas_edit->TotalRecs, $t02_rkas_edit->AutoHidePager) ?>
<?php if ($t02_rkas_edit->Pager->RecordCount > 0 && $t02_rkas_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t02_rkas_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t02_rkas_edit->PageUrl() ?>start=<?php echo $t02_rkas_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t02_rkas_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t02_rkas_edit->PageUrl() ?>start=<?php echo $t02_rkas_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t02_rkas_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t02_rkas_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t02_rkas_edit->PageUrl() ?>start=<?php echo $t02_rkas_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t02_rkas_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t02_rkas_edit->PageUrl() ?>start=<?php echo $t02_rkas_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t02_rkas_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
ft02_rkasedit.Init();
</script>
<?php
$t02_rkas_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t02_rkas_edit->Page_Terminate();
?>
