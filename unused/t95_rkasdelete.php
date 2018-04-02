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

$t95_rkas_delete = NULL; // Initialize page object first

class ct95_rkas_delete extends ct95_rkas {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}';

	// Table name
	var $TableName = 't95_rkas';

	// Page object name
	var $PageObjName = 't95_rkas_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
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

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
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
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t95_rkaslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t95_rkas class, t95_rkasinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("t95_rkaslist.php"); // Return to list
			}
		}
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
		$row = array();
		$row['id'] = NULL;
		$row['kiri_tabel'] = NULL;
		$row['kiri_id'] = NULL;
		$row['kiri_lv2'] = NULL;
		$row['kiri_lv3'] = NULL;
		$row['kiri_lv4'] = NULL;
		$row['kiri_jumlah'] = NULL;
		$row['kanan_tabel'] = NULL;
		$row['kanan_id'] = NULL;
		$row['kanan_lv2'] = NULL;
		$row['kanan_lv3'] = NULL;
		$row['kanan_lv4'] = NULL;
		$row['kanan_jumlah'] = NULL;
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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t95_rkaslist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t95_rkas_delete)) $t95_rkas_delete = new ct95_rkas_delete();

// Page init
$t95_rkas_delete->Page_Init();

// Page main
$t95_rkas_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t95_rkas_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft95_rkasdelete = new ew_Form("ft95_rkasdelete", "delete");

// Form_CustomValidate event
ft95_rkasdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft95_rkasdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t95_rkas_delete->ShowPageHeader(); ?>
<?php
$t95_rkas_delete->ShowMessage();
?>
<form name="ft95_rkasdelete" id="ft95_rkasdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t95_rkas_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t95_rkas_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t95_rkas">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t95_rkas_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($t95_rkas->id->Visible) { // id ?>
		<th class="<?php echo $t95_rkas->id->HeaderCellClass() ?>"><span id="elh_t95_rkas_id" class="t95_rkas_id"><?php echo $t95_rkas->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t95_rkas->kiri_tabel->Visible) { // kiri_tabel ?>
		<th class="<?php echo $t95_rkas->kiri_tabel->HeaderCellClass() ?>"><span id="elh_t95_rkas_kiri_tabel" class="t95_rkas_kiri_tabel"><?php echo $t95_rkas->kiri_tabel->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t95_rkas->kiri_id->Visible) { // kiri_id ?>
		<th class="<?php echo $t95_rkas->kiri_id->HeaderCellClass() ?>"><span id="elh_t95_rkas_kiri_id" class="t95_rkas_kiri_id"><?php echo $t95_rkas->kiri_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t95_rkas->kiri_lv2->Visible) { // kiri_lv2 ?>
		<th class="<?php echo $t95_rkas->kiri_lv2->HeaderCellClass() ?>"><span id="elh_t95_rkas_kiri_lv2" class="t95_rkas_kiri_lv2"><?php echo $t95_rkas->kiri_lv2->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t95_rkas->kiri_lv3->Visible) { // kiri_lv3 ?>
		<th class="<?php echo $t95_rkas->kiri_lv3->HeaderCellClass() ?>"><span id="elh_t95_rkas_kiri_lv3" class="t95_rkas_kiri_lv3"><?php echo $t95_rkas->kiri_lv3->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t95_rkas->kiri_lv4->Visible) { // kiri_lv4 ?>
		<th class="<?php echo $t95_rkas->kiri_lv4->HeaderCellClass() ?>"><span id="elh_t95_rkas_kiri_lv4" class="t95_rkas_kiri_lv4"><?php echo $t95_rkas->kiri_lv4->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t95_rkas->kiri_jumlah->Visible) { // kiri_jumlah ?>
		<th class="<?php echo $t95_rkas->kiri_jumlah->HeaderCellClass() ?>"><span id="elh_t95_rkas_kiri_jumlah" class="t95_rkas_kiri_jumlah"><?php echo $t95_rkas->kiri_jumlah->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t95_rkas->kanan_tabel->Visible) { // kanan_tabel ?>
		<th class="<?php echo $t95_rkas->kanan_tabel->HeaderCellClass() ?>"><span id="elh_t95_rkas_kanan_tabel" class="t95_rkas_kanan_tabel"><?php echo $t95_rkas->kanan_tabel->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t95_rkas->kanan_id->Visible) { // kanan_id ?>
		<th class="<?php echo $t95_rkas->kanan_id->HeaderCellClass() ?>"><span id="elh_t95_rkas_kanan_id" class="t95_rkas_kanan_id"><?php echo $t95_rkas->kanan_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t95_rkas->kanan_lv2->Visible) { // kanan_lv2 ?>
		<th class="<?php echo $t95_rkas->kanan_lv2->HeaderCellClass() ?>"><span id="elh_t95_rkas_kanan_lv2" class="t95_rkas_kanan_lv2"><?php echo $t95_rkas->kanan_lv2->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t95_rkas->kanan_lv3->Visible) { // kanan_lv3 ?>
		<th class="<?php echo $t95_rkas->kanan_lv3->HeaderCellClass() ?>"><span id="elh_t95_rkas_kanan_lv3" class="t95_rkas_kanan_lv3"><?php echo $t95_rkas->kanan_lv3->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t95_rkas->kanan_lv4->Visible) { // kanan_lv4 ?>
		<th class="<?php echo $t95_rkas->kanan_lv4->HeaderCellClass() ?>"><span id="elh_t95_rkas_kanan_lv4" class="t95_rkas_kanan_lv4"><?php echo $t95_rkas->kanan_lv4->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t95_rkas->kanan_jumlah->Visible) { // kanan_jumlah ?>
		<th class="<?php echo $t95_rkas->kanan_jumlah->HeaderCellClass() ?>"><span id="elh_t95_rkas_kanan_jumlah" class="t95_rkas_kanan_jumlah"><?php echo $t95_rkas->kanan_jumlah->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t95_rkas_delete->RecCnt = 0;
$i = 0;
while (!$t95_rkas_delete->Recordset->EOF) {
	$t95_rkas_delete->RecCnt++;
	$t95_rkas_delete->RowCnt++;

	// Set row properties
	$t95_rkas->ResetAttrs();
	$t95_rkas->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t95_rkas_delete->LoadRowValues($t95_rkas_delete->Recordset);

	// Render row
	$t95_rkas_delete->RenderRow();
?>
	<tr<?php echo $t95_rkas->RowAttributes() ?>>
<?php if ($t95_rkas->id->Visible) { // id ?>
		<td<?php echo $t95_rkas->id->CellAttributes() ?>>
<span id="el<?php echo $t95_rkas_delete->RowCnt ?>_t95_rkas_id" class="t95_rkas_id">
<span<?php echo $t95_rkas->id->ViewAttributes() ?>>
<?php echo $t95_rkas->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t95_rkas->kiri_tabel->Visible) { // kiri_tabel ?>
		<td<?php echo $t95_rkas->kiri_tabel->CellAttributes() ?>>
<span id="el<?php echo $t95_rkas_delete->RowCnt ?>_t95_rkas_kiri_tabel" class="t95_rkas_kiri_tabel">
<span<?php echo $t95_rkas->kiri_tabel->ViewAttributes() ?>>
<?php echo $t95_rkas->kiri_tabel->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t95_rkas->kiri_id->Visible) { // kiri_id ?>
		<td<?php echo $t95_rkas->kiri_id->CellAttributes() ?>>
<span id="el<?php echo $t95_rkas_delete->RowCnt ?>_t95_rkas_kiri_id" class="t95_rkas_kiri_id">
<span<?php echo $t95_rkas->kiri_id->ViewAttributes() ?>>
<?php echo $t95_rkas->kiri_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t95_rkas->kiri_lv2->Visible) { // kiri_lv2 ?>
		<td<?php echo $t95_rkas->kiri_lv2->CellAttributes() ?>>
<span id="el<?php echo $t95_rkas_delete->RowCnt ?>_t95_rkas_kiri_lv2" class="t95_rkas_kiri_lv2">
<span<?php echo $t95_rkas->kiri_lv2->ViewAttributes() ?>>
<?php echo $t95_rkas->kiri_lv2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t95_rkas->kiri_lv3->Visible) { // kiri_lv3 ?>
		<td<?php echo $t95_rkas->kiri_lv3->CellAttributes() ?>>
<span id="el<?php echo $t95_rkas_delete->RowCnt ?>_t95_rkas_kiri_lv3" class="t95_rkas_kiri_lv3">
<span<?php echo $t95_rkas->kiri_lv3->ViewAttributes() ?>>
<?php echo $t95_rkas->kiri_lv3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t95_rkas->kiri_lv4->Visible) { // kiri_lv4 ?>
		<td<?php echo $t95_rkas->kiri_lv4->CellAttributes() ?>>
<span id="el<?php echo $t95_rkas_delete->RowCnt ?>_t95_rkas_kiri_lv4" class="t95_rkas_kiri_lv4">
<span<?php echo $t95_rkas->kiri_lv4->ViewAttributes() ?>>
<?php echo $t95_rkas->kiri_lv4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t95_rkas->kiri_jumlah->Visible) { // kiri_jumlah ?>
		<td<?php echo $t95_rkas->kiri_jumlah->CellAttributes() ?>>
<span id="el<?php echo $t95_rkas_delete->RowCnt ?>_t95_rkas_kiri_jumlah" class="t95_rkas_kiri_jumlah">
<span<?php echo $t95_rkas->kiri_jumlah->ViewAttributes() ?>>
<?php echo $t95_rkas->kiri_jumlah->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t95_rkas->kanan_tabel->Visible) { // kanan_tabel ?>
		<td<?php echo $t95_rkas->kanan_tabel->CellAttributes() ?>>
<span id="el<?php echo $t95_rkas_delete->RowCnt ?>_t95_rkas_kanan_tabel" class="t95_rkas_kanan_tabel">
<span<?php echo $t95_rkas->kanan_tabel->ViewAttributes() ?>>
<?php echo $t95_rkas->kanan_tabel->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t95_rkas->kanan_id->Visible) { // kanan_id ?>
		<td<?php echo $t95_rkas->kanan_id->CellAttributes() ?>>
<span id="el<?php echo $t95_rkas_delete->RowCnt ?>_t95_rkas_kanan_id" class="t95_rkas_kanan_id">
<span<?php echo $t95_rkas->kanan_id->ViewAttributes() ?>>
<?php echo $t95_rkas->kanan_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t95_rkas->kanan_lv2->Visible) { // kanan_lv2 ?>
		<td<?php echo $t95_rkas->kanan_lv2->CellAttributes() ?>>
<span id="el<?php echo $t95_rkas_delete->RowCnt ?>_t95_rkas_kanan_lv2" class="t95_rkas_kanan_lv2">
<span<?php echo $t95_rkas->kanan_lv2->ViewAttributes() ?>>
<?php echo $t95_rkas->kanan_lv2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t95_rkas->kanan_lv3->Visible) { // kanan_lv3 ?>
		<td<?php echo $t95_rkas->kanan_lv3->CellAttributes() ?>>
<span id="el<?php echo $t95_rkas_delete->RowCnt ?>_t95_rkas_kanan_lv3" class="t95_rkas_kanan_lv3">
<span<?php echo $t95_rkas->kanan_lv3->ViewAttributes() ?>>
<?php echo $t95_rkas->kanan_lv3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t95_rkas->kanan_lv4->Visible) { // kanan_lv4 ?>
		<td<?php echo $t95_rkas->kanan_lv4->CellAttributes() ?>>
<span id="el<?php echo $t95_rkas_delete->RowCnt ?>_t95_rkas_kanan_lv4" class="t95_rkas_kanan_lv4">
<span<?php echo $t95_rkas->kanan_lv4->ViewAttributes() ?>>
<?php echo $t95_rkas->kanan_lv4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t95_rkas->kanan_jumlah->Visible) { // kanan_jumlah ?>
		<td<?php echo $t95_rkas->kanan_jumlah->CellAttributes() ?>>
<span id="el<?php echo $t95_rkas_delete->RowCnt ?>_t95_rkas_kanan_jumlah" class="t95_rkas_kanan_jumlah">
<span<?php echo $t95_rkas->kanan_jumlah->ViewAttributes() ?>>
<?php echo $t95_rkas->kanan_jumlah->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t95_rkas_delete->Recordset->MoveNext();
}
$t95_rkas_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t95_rkas_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft95_rkasdelete.Init();
</script>
<?php
$t95_rkas_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t95_rkas_delete->Page_Terminate();
?>
