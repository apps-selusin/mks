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

$t03_rpu_delete = NULL; // Initialize page object first

class ct03_rpu_delete extends ct03_rpu {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}';

	// Table name
	var $TableName = 't03_rpu';

	// Page object name
	var $PageObjName = 't03_rpu_delete';

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

		// Table object (t03_rpu)
		if (!isset($GLOBALS["t03_rpu"]) || get_class($GLOBALS["t03_rpu"]) == "ct03_rpu") {
			$GLOBALS["t03_rpu"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t03_rpu"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
			$this->Page_Terminate("t03_rpulist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t03_rpu class, t03_rpuinfo.php

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
				$this->Page_Terminate("t03_rpulist.php"); // Return to list
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
		$row = array();
		$row['id'] = NULL;
		$row['Level'] = NULL;
		$row['Urutan'] = NULL;
		$row['No_Urut'] = NULL;
		$row['Keterangan'] = NULL;
		$row['Volume'] = NULL;
		$row['Alokasi'] = NULL;
		$row['Unit_KOS'] = NULL;
		$row['Jumlah'] = NULL;
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
		$this->Volume->ViewValue = ew_FormatNumber($this->Volume->ViewValue, 0, -2, -2, -2);
		$this->Volume->CellCssStyle .= "text-align: right;";
		$this->Volume->ViewCustomAttributes = "";

		// Alokasi
		$this->Alokasi->ViewValue = $this->Alokasi->CurrentValue;
		$this->Alokasi->ViewValue = ew_FormatNumber($this->Alokasi->ViewValue, 0, -2, -2, -2);
		$this->Alokasi->CellCssStyle .= "text-align: right;";
		$this->Alokasi->ViewCustomAttributes = "";

		// Unit_KOS
		$this->Unit_KOS->ViewValue = $this->Unit_KOS->CurrentValue;
		$this->Unit_KOS->ViewValue = ew_FormatNumber($this->Unit_KOS->ViewValue, 0, -2, -2, -2);
		$this->Unit_KOS->CellCssStyle .= "text-align: right;";
		$this->Unit_KOS->ViewCustomAttributes = "";

		// Jumlah
		$this->Jumlah->ViewValue = $this->Jumlah->CurrentValue;
		$this->Jumlah->ViewValue = ew_FormatNumber($this->Jumlah->ViewValue, 0, -2, -2, -2);
		$this->Jumlah->CellCssStyle .= "text-align: right;";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t03_rpulist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t03_rpu_delete)) $t03_rpu_delete = new ct03_rpu_delete();

// Page init
$t03_rpu_delete->Page_Init();

// Page main
$t03_rpu_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t03_rpu_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft03_rpudelete = new ew_Form("ft03_rpudelete", "delete");

// Form_CustomValidate event
ft03_rpudelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft03_rpudelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t03_rpu_delete->ShowPageHeader(); ?>
<?php
$t03_rpu_delete->ShowMessage();
?>
<form name="ft03_rpudelete" id="ft03_rpudelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t03_rpu_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t03_rpu_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t03_rpu">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t03_rpu_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($t03_rpu->Level->Visible) { // Level ?>
		<th class="<?php echo $t03_rpu->Level->HeaderCellClass() ?>"><span id="elh_t03_rpu_Level" class="t03_rpu_Level"><?php echo $t03_rpu->Level->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t03_rpu->Urutan->Visible) { // Urutan ?>
		<th class="<?php echo $t03_rpu->Urutan->HeaderCellClass() ?>"><span id="elh_t03_rpu_Urutan" class="t03_rpu_Urutan"><?php echo $t03_rpu->Urutan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t03_rpu->No_Urut->Visible) { // No_Urut ?>
		<th class="<?php echo $t03_rpu->No_Urut->HeaderCellClass() ?>"><span id="elh_t03_rpu_No_Urut" class="t03_rpu_No_Urut"><?php echo $t03_rpu->No_Urut->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t03_rpu->Keterangan->Visible) { // Keterangan ?>
		<th class="<?php echo $t03_rpu->Keterangan->HeaderCellClass() ?>"><span id="elh_t03_rpu_Keterangan" class="t03_rpu_Keterangan"><?php echo $t03_rpu->Keterangan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t03_rpu->Volume->Visible) { // Volume ?>
		<th class="<?php echo $t03_rpu->Volume->HeaderCellClass() ?>"><span id="elh_t03_rpu_Volume" class="t03_rpu_Volume"><?php echo $t03_rpu->Volume->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t03_rpu->Alokasi->Visible) { // Alokasi ?>
		<th class="<?php echo $t03_rpu->Alokasi->HeaderCellClass() ?>"><span id="elh_t03_rpu_Alokasi" class="t03_rpu_Alokasi"><?php echo $t03_rpu->Alokasi->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t03_rpu->Unit_KOS->Visible) { // Unit_KOS ?>
		<th class="<?php echo $t03_rpu->Unit_KOS->HeaderCellClass() ?>"><span id="elh_t03_rpu_Unit_KOS" class="t03_rpu_Unit_KOS"><?php echo $t03_rpu->Unit_KOS->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t03_rpu->Jumlah->Visible) { // Jumlah ?>
		<th class="<?php echo $t03_rpu->Jumlah->HeaderCellClass() ?>"><span id="elh_t03_rpu_Jumlah" class="t03_rpu_Jumlah"><?php echo $t03_rpu->Jumlah->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t03_rpu_delete->RecCnt = 0;
$i = 0;
while (!$t03_rpu_delete->Recordset->EOF) {
	$t03_rpu_delete->RecCnt++;
	$t03_rpu_delete->RowCnt++;

	// Set row properties
	$t03_rpu->ResetAttrs();
	$t03_rpu->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t03_rpu_delete->LoadRowValues($t03_rpu_delete->Recordset);

	// Render row
	$t03_rpu_delete->RenderRow();
?>
	<tr<?php echo $t03_rpu->RowAttributes() ?>>
<?php if ($t03_rpu->Level->Visible) { // Level ?>
		<td<?php echo $t03_rpu->Level->CellAttributes() ?>>
<span id="el<?php echo $t03_rpu_delete->RowCnt ?>_t03_rpu_Level" class="t03_rpu_Level">
<span<?php echo $t03_rpu->Level->ViewAttributes() ?>>
<?php echo $t03_rpu->Level->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t03_rpu->Urutan->Visible) { // Urutan ?>
		<td<?php echo $t03_rpu->Urutan->CellAttributes() ?>>
<span id="el<?php echo $t03_rpu_delete->RowCnt ?>_t03_rpu_Urutan" class="t03_rpu_Urutan">
<span<?php echo $t03_rpu->Urutan->ViewAttributes() ?>>
<?php echo $t03_rpu->Urutan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t03_rpu->No_Urut->Visible) { // No_Urut ?>
		<td<?php echo $t03_rpu->No_Urut->CellAttributes() ?>>
<span id="el<?php echo $t03_rpu_delete->RowCnt ?>_t03_rpu_No_Urut" class="t03_rpu_No_Urut">
<span<?php echo $t03_rpu->No_Urut->ViewAttributes() ?>>
<?php echo $t03_rpu->No_Urut->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t03_rpu->Keterangan->Visible) { // Keterangan ?>
		<td<?php echo $t03_rpu->Keterangan->CellAttributes() ?>>
<span id="el<?php echo $t03_rpu_delete->RowCnt ?>_t03_rpu_Keterangan" class="t03_rpu_Keterangan">
<span<?php echo $t03_rpu->Keterangan->ViewAttributes() ?>>
<?php echo $t03_rpu->Keterangan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t03_rpu->Volume->Visible) { // Volume ?>
		<td<?php echo $t03_rpu->Volume->CellAttributes() ?>>
<span id="el<?php echo $t03_rpu_delete->RowCnt ?>_t03_rpu_Volume" class="t03_rpu_Volume">
<span<?php echo $t03_rpu->Volume->ViewAttributes() ?>>
<?php echo $t03_rpu->Volume->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t03_rpu->Alokasi->Visible) { // Alokasi ?>
		<td<?php echo $t03_rpu->Alokasi->CellAttributes() ?>>
<span id="el<?php echo $t03_rpu_delete->RowCnt ?>_t03_rpu_Alokasi" class="t03_rpu_Alokasi">
<span<?php echo $t03_rpu->Alokasi->ViewAttributes() ?>>
<?php echo $t03_rpu->Alokasi->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t03_rpu->Unit_KOS->Visible) { // Unit_KOS ?>
		<td<?php echo $t03_rpu->Unit_KOS->CellAttributes() ?>>
<span id="el<?php echo $t03_rpu_delete->RowCnt ?>_t03_rpu_Unit_KOS" class="t03_rpu_Unit_KOS">
<span<?php echo $t03_rpu->Unit_KOS->ViewAttributes() ?>>
<?php echo $t03_rpu->Unit_KOS->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t03_rpu->Jumlah->Visible) { // Jumlah ?>
		<td<?php echo $t03_rpu->Jumlah->CellAttributes() ?>>
<span id="el<?php echo $t03_rpu_delete->RowCnt ?>_t03_rpu_Jumlah" class="t03_rpu_Jumlah">
<span<?php echo $t03_rpu->Jumlah->ViewAttributes() ?>>
<?php echo $t03_rpu->Jumlah->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t03_rpu_delete->Recordset->MoveNext();
}
$t03_rpu_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t03_rpu_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft03_rpudelete.Init();
</script>
<?php
$t03_rpu_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t03_rpu_delete->Page_Terminate();
?>
