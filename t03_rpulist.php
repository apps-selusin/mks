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

$t03_rpu_list = NULL; // Initialize page object first

class ct03_rpu_list extends ct03_rpu {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}';

	// Table name
	var $TableName = 't03_rpu';

	// Page object name
	var $PageObjName = 't03_rpu_list';

	// Grid form hidden field names
	var $FormName = 'ft03_rpulist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;
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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t03_rpuadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t03_rpudelete.php";
		$this->MultiUpdateUrl = "t03_rpuupdate.php";

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption ft03_rpulistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
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

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} elseif (@$_GET["cmd"] == "json") {
			$this->Export = $_GET["cmd"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetupDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->Command <> "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array_keys($EW_EXPORT))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Set up number of records displayed per page
	function SetupDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 20; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Exit inline mode
	function ClearInlineMode() {
		$this->setKey("id", ""); // Clear inline edit key
		$this->Volume->FormValue = ""; // Clear form value
		$this->Alokasi->FormValue = ""; // Clear form value
		$this->Unit_KOS->FormValue = ""; // Clear form value
		$this->Jumlah->FormValue = ""; // Clear form value
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (isset($_GET["id"])) {
			$this->id->setQueryStringValue($_GET["id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("id", $this->id->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1;
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("id")) <> strval($this->id->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		if ($this->CurrentAction == "copy") {
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CurrentAction = "add";
			}
		}
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old record
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertBegin")); // Batch insert begin
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertSuccess")); // Batch insert success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertRollback")); // Batch insert rollback
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_Level") && $objForm->HasValue("o_Level") && $this->Level->CurrentValue <> $this->Level->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Urutan") && $objForm->HasValue("o_Urutan") && $this->Urutan->CurrentValue <> $this->Urutan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_No_Urut") && $objForm->HasValue("o_No_Urut") && $this->No_Urut->CurrentValue <> $this->No_Urut->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Keterangan") && $objForm->HasValue("o_Keterangan") && $this->Keterangan->CurrentValue <> $this->Keterangan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Volume") && $objForm->HasValue("o_Volume") && $this->Volume->CurrentValue <> $this->Volume->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Alokasi") && $objForm->HasValue("o_Alokasi") && $this->Alokasi->CurrentValue <> $this->Alokasi->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Unit_KOS") && $objForm->HasValue("o_Unit_KOS") && $this->Unit_KOS->CurrentValue <> $this->Unit_KOS->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Jumlah") && $objForm->HasValue("o_Jumlah") && $this->Jumlah->CurrentValue <> $this->Jumlah->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Initialize
		$sFilterList = "";
		$sSavedFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJson(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->Level->AdvancedSearch->ToJson(), ","); // Field Level
		$sFilterList = ew_Concat($sFilterList, $this->Urutan->AdvancedSearch->ToJson(), ","); // Field Urutan
		$sFilterList = ew_Concat($sFilterList, $this->No_Urut->AdvancedSearch->ToJson(), ","); // Field No_Urut
		$sFilterList = ew_Concat($sFilterList, $this->Keterangan->AdvancedSearch->ToJson(), ","); // Field Keterangan
		$sFilterList = ew_Concat($sFilterList, $this->Volume->AdvancedSearch->ToJson(), ","); // Field Volume
		$sFilterList = ew_Concat($sFilterList, $this->Alokasi->AdvancedSearch->ToJson(), ","); // Field Alokasi
		$sFilterList = ew_Concat($sFilterList, $this->Unit_KOS->AdvancedSearch->ToJson(), ","); // Field Unit_KOS
		$sFilterList = ew_Concat($sFilterList, $this->Jumlah->AdvancedSearch->ToJson(), ","); // Field Jumlah
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = @$_POST["filters"];
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft03_rpulistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		$this->Command = "search";

		// Field id
		$this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
		$this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
		$this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
		$this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
		$this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
		$this->id->AdvancedSearch->Save();

		// Field Level
		$this->Level->AdvancedSearch->SearchValue = @$filter["x_Level"];
		$this->Level->AdvancedSearch->SearchOperator = @$filter["z_Level"];
		$this->Level->AdvancedSearch->SearchCondition = @$filter["v_Level"];
		$this->Level->AdvancedSearch->SearchValue2 = @$filter["y_Level"];
		$this->Level->AdvancedSearch->SearchOperator2 = @$filter["w_Level"];
		$this->Level->AdvancedSearch->Save();

		// Field Urutan
		$this->Urutan->AdvancedSearch->SearchValue = @$filter["x_Urutan"];
		$this->Urutan->AdvancedSearch->SearchOperator = @$filter["z_Urutan"];
		$this->Urutan->AdvancedSearch->SearchCondition = @$filter["v_Urutan"];
		$this->Urutan->AdvancedSearch->SearchValue2 = @$filter["y_Urutan"];
		$this->Urutan->AdvancedSearch->SearchOperator2 = @$filter["w_Urutan"];
		$this->Urutan->AdvancedSearch->Save();

		// Field No_Urut
		$this->No_Urut->AdvancedSearch->SearchValue = @$filter["x_No_Urut"];
		$this->No_Urut->AdvancedSearch->SearchOperator = @$filter["z_No_Urut"];
		$this->No_Urut->AdvancedSearch->SearchCondition = @$filter["v_No_Urut"];
		$this->No_Urut->AdvancedSearch->SearchValue2 = @$filter["y_No_Urut"];
		$this->No_Urut->AdvancedSearch->SearchOperator2 = @$filter["w_No_Urut"];
		$this->No_Urut->AdvancedSearch->Save();

		// Field Keterangan
		$this->Keterangan->AdvancedSearch->SearchValue = @$filter["x_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchOperator = @$filter["z_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchCondition = @$filter["v_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchValue2 = @$filter["y_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchOperator2 = @$filter["w_Keterangan"];
		$this->Keterangan->AdvancedSearch->Save();

		// Field Volume
		$this->Volume->AdvancedSearch->SearchValue = @$filter["x_Volume"];
		$this->Volume->AdvancedSearch->SearchOperator = @$filter["z_Volume"];
		$this->Volume->AdvancedSearch->SearchCondition = @$filter["v_Volume"];
		$this->Volume->AdvancedSearch->SearchValue2 = @$filter["y_Volume"];
		$this->Volume->AdvancedSearch->SearchOperator2 = @$filter["w_Volume"];
		$this->Volume->AdvancedSearch->Save();

		// Field Alokasi
		$this->Alokasi->AdvancedSearch->SearchValue = @$filter["x_Alokasi"];
		$this->Alokasi->AdvancedSearch->SearchOperator = @$filter["z_Alokasi"];
		$this->Alokasi->AdvancedSearch->SearchCondition = @$filter["v_Alokasi"];
		$this->Alokasi->AdvancedSearch->SearchValue2 = @$filter["y_Alokasi"];
		$this->Alokasi->AdvancedSearch->SearchOperator2 = @$filter["w_Alokasi"];
		$this->Alokasi->AdvancedSearch->Save();

		// Field Unit_KOS
		$this->Unit_KOS->AdvancedSearch->SearchValue = @$filter["x_Unit_KOS"];
		$this->Unit_KOS->AdvancedSearch->SearchOperator = @$filter["z_Unit_KOS"];
		$this->Unit_KOS->AdvancedSearch->SearchCondition = @$filter["v_Unit_KOS"];
		$this->Unit_KOS->AdvancedSearch->SearchValue2 = @$filter["y_Unit_KOS"];
		$this->Unit_KOS->AdvancedSearch->SearchOperator2 = @$filter["w_Unit_KOS"];
		$this->Unit_KOS->AdvancedSearch->Save();

		// Field Jumlah
		$this->Jumlah->AdvancedSearch->SearchValue = @$filter["x_Jumlah"];
		$this->Jumlah->AdvancedSearch->SearchOperator = @$filter["z_Jumlah"];
		$this->Jumlah->AdvancedSearch->SearchCondition = @$filter["v_Jumlah"];
		$this->Jumlah->AdvancedSearch->SearchValue2 = @$filter["y_Jumlah"];
		$this->Jumlah->AdvancedSearch->SearchOperator2 = @$filter["w_Jumlah"];
		$this->Jumlah->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->No_Urut, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Keterangan, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .= "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($sSearchKeyword <> "") {
			$ar = $this->BasicSearch->KeywordList($Default);

			// Search keyword in any fields
			if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
						$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
					}
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
			}
			if (!$Default && in_array($this->Command, array("", "reset", "resetall"))) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Level, $bCtrl); // Level
			$this->UpdateSort($this->Urutan, $bCtrl); // Urutan
			$this->UpdateSort($this->No_Urut, $bCtrl); // No_Urut
			$this->UpdateSort($this->Keterangan, $bCtrl); // Keterangan
			$this->UpdateSort($this->Volume, $bCtrl); // Volume
			$this->UpdateSort($this->Alokasi, $bCtrl); // Alokasi
			$this->UpdateSort($this->Unit_KOS, $bCtrl); // Unit_KOS
			$this->UpdateSort($this->Jumlah, $bCtrl); // Jumlah
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
				$this->Urutan->setSort("ASC");
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Level->setSort("");
				$this->Urutan->setSort("");
				$this->No_Urut->setSort("");
				$this->Keterangan->setSort("");
				$this->Volume->setSort("");
				$this->Alokasi->setSort("");
				$this->Unit_KOS->setSort("");
				$this->Jumlah->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssClass = "text-nowrap";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_UrlAddHash($this->PageName(), "r" . $this->RowCnt . "_" . $this->TableVar) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\">";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddHash($this->InlineEditUrl, "r" . $this->RowCnt . "_" . $this->TableVar)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineCopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineCopyUrl) . "\">" . $Language->Phrase("InlineCopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "" && $Security->CanAdd());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.ft03_rpulist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft03_rpulistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft03_rpulistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft03_rpulist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = FALSE;
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = FALSE;
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
		}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft03_rpulistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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
		$this->Volume->OldValue = $this->Volume->CurrentValue;
		$this->Alokasi->CurrentValue = 0.00;
		$this->Alokasi->OldValue = $this->Alokasi->CurrentValue;
		$this->Unit_KOS->CurrentValue = 0.00;
		$this->Unit_KOS->OldValue = $this->Unit_KOS->CurrentValue;
		$this->Jumlah->CurrentValue = 0.00;
		$this->Jumlah->OldValue = $this->Jumlah->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Level->FldIsDetailKey) {
			$this->Level->setFormValue($objForm->GetValue("x_Level"));
		}
		$this->Level->setOldValue($objForm->GetValue("o_Level"));
		if (!$this->Urutan->FldIsDetailKey) {
			$this->Urutan->setFormValue($objForm->GetValue("x_Urutan"));
		}
		$this->Urutan->setOldValue($objForm->GetValue("o_Urutan"));
		if (!$this->No_Urut->FldIsDetailKey) {
			$this->No_Urut->setFormValue($objForm->GetValue("x_No_Urut"));
		}
		$this->No_Urut->setOldValue($objForm->GetValue("o_No_Urut"));
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
		}
		$this->Keterangan->setOldValue($objForm->GetValue("o_Keterangan"));
		if (!$this->Volume->FldIsDetailKey) {
			$this->Volume->setFormValue($objForm->GetValue("x_Volume"));
		}
		$this->Volume->setOldValue($objForm->GetValue("o_Volume"));
		if (!$this->Alokasi->FldIsDetailKey) {
			$this->Alokasi->setFormValue($objForm->GetValue("x_Alokasi"));
		}
		$this->Alokasi->setOldValue($objForm->GetValue("o_Alokasi"));
		if (!$this->Unit_KOS->FldIsDetailKey) {
			$this->Unit_KOS->setFormValue($objForm->GetValue("x_Unit_KOS"));
		}
		$this->Unit_KOS->setOldValue($objForm->GetValue("o_Unit_KOS"));
		if (!$this->Jumlah->FldIsDetailKey) {
			$this->Jumlah->setFormValue($objForm->GetValue("x_Jumlah"));
		}
		$this->Jumlah->setOldValue($objForm->GetValue("o_Jumlah"));
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->Level->CurrentValue = $this->Level->FormValue;
		$this->Urutan->CurrentValue = $this->Urutan->FormValue;
		$this->No_Urut->CurrentValue = $this->No_Urut->FormValue;
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
		$this->Volume->CurrentValue = $this->Volume->FormValue;
		$this->Alokasi->CurrentValue = $this->Alokasi->FormValue;
		$this->Unit_KOS->CurrentValue = $this->Unit_KOS->FormValue;
		$this->Jumlah->CurrentValue = $this->Jumlah->FormValue;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
			if (strval($this->Volume->EditValue) <> "" && is_numeric($this->Volume->EditValue)) {
			$this->Volume->EditValue = ew_FormatNumber($this->Volume->EditValue, -2, -2, -2, -2);
			$this->Volume->OldValue = $this->Volume->EditValue;
			}

			// Alokasi
			$this->Alokasi->EditAttrs["class"] = "form-control";
			$this->Alokasi->EditCustomAttributes = "";
			$this->Alokasi->EditValue = ew_HtmlEncode($this->Alokasi->CurrentValue);
			$this->Alokasi->PlaceHolder = ew_RemoveHtml($this->Alokasi->FldCaption());
			if (strval($this->Alokasi->EditValue) <> "" && is_numeric($this->Alokasi->EditValue)) {
			$this->Alokasi->EditValue = ew_FormatNumber($this->Alokasi->EditValue, -2, -2, -2, -2);
			$this->Alokasi->OldValue = $this->Alokasi->EditValue;
			}

			// Unit_KOS
			$this->Unit_KOS->EditAttrs["class"] = "form-control";
			$this->Unit_KOS->EditCustomAttributes = "";
			$this->Unit_KOS->EditValue = ew_HtmlEncode($this->Unit_KOS->CurrentValue);
			$this->Unit_KOS->PlaceHolder = ew_RemoveHtml($this->Unit_KOS->FldCaption());
			if (strval($this->Unit_KOS->EditValue) <> "" && is_numeric($this->Unit_KOS->EditValue)) {
			$this->Unit_KOS->EditValue = ew_FormatNumber($this->Unit_KOS->EditValue, -2, -2, -2, -2);
			$this->Unit_KOS->OldValue = $this->Unit_KOS->EditValue;
			}

			// Jumlah
			$this->Jumlah->EditAttrs["class"] = "form-control";
			$this->Jumlah->EditCustomAttributes = "";
			$this->Jumlah->EditValue = ew_HtmlEncode($this->Jumlah->CurrentValue);
			$this->Jumlah->PlaceHolder = ew_RemoveHtml($this->Jumlah->FldCaption());
			if (strval($this->Jumlah->EditValue) <> "" && is_numeric($this->Jumlah->EditValue)) {
			$this->Jumlah->EditValue = ew_FormatNumber($this->Jumlah->EditValue, -2, -2, -2, -2);
			$this->Jumlah->OldValue = $this->Jumlah->EditValue;
			}

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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
			if (strval($this->Volume->EditValue) <> "" && is_numeric($this->Volume->EditValue)) {
			$this->Volume->EditValue = ew_FormatNumber($this->Volume->EditValue, -2, -2, -2, -2);
			$this->Volume->OldValue = $this->Volume->EditValue;
			}

			// Alokasi
			$this->Alokasi->EditAttrs["class"] = "form-control";
			$this->Alokasi->EditCustomAttributes = "";
			$this->Alokasi->EditValue = ew_HtmlEncode($this->Alokasi->CurrentValue);
			$this->Alokasi->PlaceHolder = ew_RemoveHtml($this->Alokasi->FldCaption());
			if (strval($this->Alokasi->EditValue) <> "" && is_numeric($this->Alokasi->EditValue)) {
			$this->Alokasi->EditValue = ew_FormatNumber($this->Alokasi->EditValue, -2, -2, -2, -2);
			$this->Alokasi->OldValue = $this->Alokasi->EditValue;
			}

			// Unit_KOS
			$this->Unit_KOS->EditAttrs["class"] = "form-control";
			$this->Unit_KOS->EditCustomAttributes = "";
			$this->Unit_KOS->EditValue = ew_HtmlEncode($this->Unit_KOS->CurrentValue);
			$this->Unit_KOS->PlaceHolder = ew_RemoveHtml($this->Unit_KOS->FldCaption());
			if (strval($this->Unit_KOS->EditValue) <> "" && is_numeric($this->Unit_KOS->EditValue)) {
			$this->Unit_KOS->EditValue = ew_FormatNumber($this->Unit_KOS->EditValue, -2, -2, -2, -2);
			$this->Unit_KOS->OldValue = $this->Unit_KOS->EditValue;
			}

			// Jumlah
			$this->Jumlah->EditAttrs["class"] = "form-control";
			$this->Jumlah->EditCustomAttributes = "";
			$this->Jumlah->EditValue = ew_HtmlEncode($this->Jumlah->CurrentValue);
			$this->Jumlah->PlaceHolder = ew_RemoveHtml($this->Jumlah->FldCaption());
			if (strval($this->Jumlah->EditValue) <> "" && is_numeric($this->Jumlah->EditValue)) {
			$this->Jumlah->EditValue = ew_FormatNumber($this->Jumlah->EditValue, -2, -2, -2, -2);
			$this->Jumlah->OldValue = $this->Jumlah->EditValue;
			}

			// Edit refer script
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
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

			// Level
			$this->Level->SetDbValueDef($rsnew, $this->Level->CurrentValue, 0, $this->Level->ReadOnly);

			// Urutan
			$this->Urutan->SetDbValueDef($rsnew, $this->Urutan->CurrentValue, 0, $this->Urutan->ReadOnly);

			// No_Urut
			$this->No_Urut->SetDbValueDef($rsnew, $this->No_Urut->CurrentValue, NULL, $this->No_Urut->ReadOnly);

			// Keterangan
			$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, $this->Keterangan->ReadOnly);

			// Volume
			$this->Volume->SetDbValueDef($rsnew, $this->Volume->CurrentValue, 0, $this->Volume->ReadOnly);

			// Alokasi
			$this->Alokasi->SetDbValueDef($rsnew, $this->Alokasi->CurrentValue, 0, $this->Alokasi->ReadOnly);

			// Unit_KOS
			$this->Unit_KOS->SetDbValueDef($rsnew, $this->Unit_KOS->CurrentValue, 0, $this->Unit_KOS->ReadOnly);

			// Jumlah
			$this->Jumlah->SetDbValueDef($rsnew, $this->Jumlah->CurrentValue, NULL, $this->Jumlah->ReadOnly);

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

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_t03_rpu\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_t03_rpu',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ft03_rpulist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = TRUE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->ListRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetupStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		if ($this->Export == "email") {
			echo $this->ExportEmail($Doc->Text);
		} else {
			$Doc->Export();
		}
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $Language;
		$sSender = @$_POST["sender"];
		$sRecipient = @$_POST["recipient"];
		$sCc = @$_POST["cc"];
		$sBcc = @$_POST["bcc"];

		// Subject
		$sSubject = @$_POST["subject"];
		$sEmailSubject = $sSubject;

		// Message
		$sContent = @$_POST["message"];
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterSenderEmail") . "</p>";
		}
		if (!ew_CheckEmail($sSender)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperSenderEmail") . "</p>";
		}

		// Check recipient
		if (!ew_CheckEmailList($sRecipient, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperRecipientEmail") . "</p>";
		}

		// Check cc
		if (!ew_CheckEmailList($sCc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperCcEmail") . "</p>";
		}

		// Check bcc
		if (!ew_CheckEmailList($sBcc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperBccEmail") . "</p>";
		}

		// Check email sent count
		if (!isset($_SESSION[EW_EXPORT_EMAIL_COUNTER]))
			$_SESSION[EW_EXPORT_EMAIL_COUNTER] = 0;
		if (intval($_SESSION[EW_EXPORT_EMAIL_COUNTER]) > EW_MAX_EMAIL_SENT_COUNT) {
			return "<p class=\"text-danger\">" . $Language->Phrase("ExceedMaxEmailExport") . "</p>";
		}

		// Send email
		$Email = new cEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Format = "html";
		if ($sEmailMessage <> "")
			$sEmailMessage = ew_RemoveXSS($sEmailMessage) . "<br><br>";
		foreach ($gTmpImages as $tmpimage)
			$Email->AddEmbeddedImage($tmpimage);
		$Email->Content = $sEmailMessage . ew_CleanEmailContent($EmailContent); // Content
		$EventArgs = array();
		if ($this->Recordset) {
			$this->RecCnt = $this->StartRec - 1;
			$this->Recordset->MoveFirst();
			if ($this->StartRec > 1)
				$this->Recordset->Move($this->StartRec - 1);
			$EventArgs["rs"] = &$this->Recordset;
		}
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count
			$_SESSION[EW_EXPORT_EMAIL_COUNTER]++;

			// Sent email success
			return "<p class=\"text-success\">" . $Language->Phrase("SendEmailSuccess") . "</p>"; // Set up success message
		} else {

			// Sent email failure
			return "<p class=\"text-danger\">" . $Email->SendErrDescription . "</p>";
		}
	}

	// Export QueryString
	function ExportQueryString() {

		// Initialize
		$sQry = "export=html";

		// Build QueryString for search
		if ($this->BasicSearch->getKeyword() <> "") {
			$sQry .= "&" . EW_TABLE_BASIC_SEARCH . "=" . urlencode($this->BasicSearch->getKeyword()) . "&" . EW_TABLE_BASIC_SEARCH_TYPE . "=" . urlencode($this->BasicSearch->getType());
		}

		// Build QueryString for pager
		$sQry .= "&" . EW_TABLE_REC_PER_PAGE . "=" . urlencode($this->getRecordsPerPage()) . "&" . EW_TABLE_START_REC . "=" . urlencode($this->getStartRecordNumber());
		return $sQry;
	}

	// Add search QueryString
	function AddSearchQueryString(&$Qry, &$Fld) {
		$FldSearchValue = $Fld->AdvancedSearch->getValue("x");
		$FldParm = substr($Fld->FldVar,2);
		if (strval($FldSearchValue) <> "") {
			$Qry .= "&x_" . $FldParm . "=" . urlencode($FldSearchValue) .
				"&z_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("z"));
		}
		$FldSearchValue2 = $Fld->AdvancedSearch->getValue("y");
		if (strval($FldSearchValue2) <> "") {
			$Qry .= "&v_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("v")) .
				"&y_" . $FldParm . "=" . urlencode($FldSearchValue2) .
				"&w_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("w"));
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t03_rpu_list)) $t03_rpu_list = new ct03_rpu_list();

// Page init
$t03_rpu_list->Page_Init();

// Page main
$t03_rpu_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t03_rpu_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($t03_rpu->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft03_rpulist = new ew_Form("ft03_rpulist", "list");
ft03_rpulist.FormKeyCountName = '<?php echo $t03_rpu_list->FormKeyCountName ?>';

// Validate form
ft03_rpulist.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
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
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
ft03_rpulist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Level", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Urutan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "No_Urut", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Keterangan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Volume", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Alokasi", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Unit_KOS", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Jumlah", false)) return false;
	return true;
}

// Form_CustomValidate event
ft03_rpulist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft03_rpulist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = ft03_rpulistsrch = new ew_Form("ft03_rpulistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($t03_rpu->Export == "") { ?>
<div class="ewToolbar">
<?php if ($t03_rpu_list->TotalRecs > 0 && $t03_rpu_list->ExportOptions->Visible()) { ?>
<?php $t03_rpu_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t03_rpu_list->SearchOptions->Visible()) { ?>
<?php $t03_rpu_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t03_rpu_list->FilterOptions->Visible()) { ?>
<?php $t03_rpu_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
if ($t03_rpu->CurrentAction == "gridadd") {
	$t03_rpu->CurrentFilter = "0=1";
	$t03_rpu_list->StartRec = 1;
	$t03_rpu_list->DisplayRecs = $t03_rpu->GridAddRowCount;
	$t03_rpu_list->TotalRecs = $t03_rpu_list->DisplayRecs;
	$t03_rpu_list->StopRec = $t03_rpu_list->DisplayRecs;
} else {
	$bSelectLimit = $t03_rpu_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t03_rpu_list->TotalRecs <= 0)
			$t03_rpu_list->TotalRecs = $t03_rpu->ListRecordCount();
	} else {
		if (!$t03_rpu_list->Recordset && ($t03_rpu_list->Recordset = $t03_rpu_list->LoadRecordset()))
			$t03_rpu_list->TotalRecs = $t03_rpu_list->Recordset->RecordCount();
	}
	$t03_rpu_list->StartRec = 1;
	if ($t03_rpu_list->DisplayRecs <= 0 || ($t03_rpu->Export <> "" && $t03_rpu->ExportAll)) // Display all records
		$t03_rpu_list->DisplayRecs = $t03_rpu_list->TotalRecs;
	if (!($t03_rpu->Export <> "" && $t03_rpu->ExportAll))
		$t03_rpu_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t03_rpu_list->Recordset = $t03_rpu_list->LoadRecordset($t03_rpu_list->StartRec-1, $t03_rpu_list->DisplayRecs);

	// Set no record found message
	if ($t03_rpu->CurrentAction == "" && $t03_rpu_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t03_rpu_list->setWarningMessage(ew_DeniedMsg());
		if ($t03_rpu_list->SearchWhere == "0=101")
			$t03_rpu_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t03_rpu_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($t03_rpu_list->AuditTrailOnSearch && $t03_rpu_list->Command == "search" && !$t03_rpu_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $t03_rpu_list->getSessionWhere();
		$t03_rpu_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$t03_rpu_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($t03_rpu->Export == "" && $t03_rpu->CurrentAction == "") { ?>
<form name="ft03_rpulistsrch" id="ft03_rpulistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t03_rpu_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft03_rpulistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t03_rpu">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($t03_rpu_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($t03_rpu_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $t03_rpu_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($t03_rpu_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($t03_rpu_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($t03_rpu_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($t03_rpu_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $t03_rpu_list->ShowPageHeader(); ?>
<?php
$t03_rpu_list->ShowMessage();
?>
<?php if ($t03_rpu_list->TotalRecs > 0 || $t03_rpu->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t03_rpu_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t03_rpu">
<?php if ($t03_rpu->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($t03_rpu->CurrentAction <> "gridadd" && $t03_rpu->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t03_rpu_list->Pager)) $t03_rpu_list->Pager = new cPrevNextPager($t03_rpu_list->StartRec, $t03_rpu_list->DisplayRecs, $t03_rpu_list->TotalRecs, $t03_rpu_list->AutoHidePager) ?>
<?php if ($t03_rpu_list->Pager->RecordCount > 0 && $t03_rpu_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t03_rpu_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t03_rpu_list->PageUrl() ?>start=<?php echo $t03_rpu_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t03_rpu_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t03_rpu_list->PageUrl() ?>start=<?php echo $t03_rpu_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t03_rpu_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t03_rpu_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t03_rpu_list->PageUrl() ?>start=<?php echo $t03_rpu_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t03_rpu_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t03_rpu_list->PageUrl() ?>start=<?php echo $t03_rpu_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t03_rpu_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t03_rpu_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t03_rpu_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t03_rpu_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t03_rpu_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t03_rpu_list->TotalRecs > 0 && (!$t03_rpu_list->AutoHidePageSizeSelector || $t03_rpu_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t03_rpu">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t03_rpu_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t03_rpu_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t03_rpu_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t03_rpu_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($t03_rpu->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t03_rpu_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ft03_rpulist" id="ft03_rpulist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t03_rpu_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t03_rpu_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t03_rpu">
<div id="gmp_t03_rpu" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($t03_rpu_list->TotalRecs > 0 || $t03_rpu->CurrentAction == "add" || $t03_rpu->CurrentAction == "copy" || $t03_rpu->CurrentAction == "gridedit") { ?>
<table id="tbl_t03_rpulist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t03_rpu_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t03_rpu_list->RenderListOptions();

// Render list options (header, left)
$t03_rpu_list->ListOptions->Render("header", "left");
?>
<?php if ($t03_rpu->Level->Visible) { // Level ?>
	<?php if ($t03_rpu->SortUrl($t03_rpu->Level) == "") { ?>
		<th data-name="Level" class="<?php echo $t03_rpu->Level->HeaderCellClass() ?>"><div id="elh_t03_rpu_Level" class="t03_rpu_Level"><div class="ewTableHeaderCaption"><?php echo $t03_rpu->Level->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Level" class="<?php echo $t03_rpu->Level->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_rpu->SortUrl($t03_rpu->Level) ?>',2);"><div id="elh_t03_rpu_Level" class="t03_rpu_Level">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_rpu->Level->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_rpu->Level->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_rpu->Level->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_rpu->Urutan->Visible) { // Urutan ?>
	<?php if ($t03_rpu->SortUrl($t03_rpu->Urutan) == "") { ?>
		<th data-name="Urutan" class="<?php echo $t03_rpu->Urutan->HeaderCellClass() ?>"><div id="elh_t03_rpu_Urutan" class="t03_rpu_Urutan"><div class="ewTableHeaderCaption"><?php echo $t03_rpu->Urutan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Urutan" class="<?php echo $t03_rpu->Urutan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_rpu->SortUrl($t03_rpu->Urutan) ?>',2);"><div id="elh_t03_rpu_Urutan" class="t03_rpu_Urutan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_rpu->Urutan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_rpu->Urutan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_rpu->Urutan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_rpu->No_Urut->Visible) { // No_Urut ?>
	<?php if ($t03_rpu->SortUrl($t03_rpu->No_Urut) == "") { ?>
		<th data-name="No_Urut" class="<?php echo $t03_rpu->No_Urut->HeaderCellClass() ?>"><div id="elh_t03_rpu_No_Urut" class="t03_rpu_No_Urut"><div class="ewTableHeaderCaption"><?php echo $t03_rpu->No_Urut->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="No_Urut" class="<?php echo $t03_rpu->No_Urut->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_rpu->SortUrl($t03_rpu->No_Urut) ?>',2);"><div id="elh_t03_rpu_No_Urut" class="t03_rpu_No_Urut">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_rpu->No_Urut->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t03_rpu->No_Urut->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_rpu->No_Urut->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_rpu->Keterangan->Visible) { // Keterangan ?>
	<?php if ($t03_rpu->SortUrl($t03_rpu->Keterangan) == "") { ?>
		<th data-name="Keterangan" class="<?php echo $t03_rpu->Keterangan->HeaderCellClass() ?>"><div id="elh_t03_rpu_Keterangan" class="t03_rpu_Keterangan"><div class="ewTableHeaderCaption"><?php echo $t03_rpu->Keterangan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Keterangan" class="<?php echo $t03_rpu->Keterangan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_rpu->SortUrl($t03_rpu->Keterangan) ?>',2);"><div id="elh_t03_rpu_Keterangan" class="t03_rpu_Keterangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_rpu->Keterangan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t03_rpu->Keterangan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_rpu->Keterangan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_rpu->Volume->Visible) { // Volume ?>
	<?php if ($t03_rpu->SortUrl($t03_rpu->Volume) == "") { ?>
		<th data-name="Volume" class="<?php echo $t03_rpu->Volume->HeaderCellClass() ?>"><div id="elh_t03_rpu_Volume" class="t03_rpu_Volume"><div class="ewTableHeaderCaption"><?php echo $t03_rpu->Volume->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Volume" class="<?php echo $t03_rpu->Volume->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_rpu->SortUrl($t03_rpu->Volume) ?>',2);"><div id="elh_t03_rpu_Volume" class="t03_rpu_Volume">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_rpu->Volume->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_rpu->Volume->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_rpu->Volume->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_rpu->Alokasi->Visible) { // Alokasi ?>
	<?php if ($t03_rpu->SortUrl($t03_rpu->Alokasi) == "") { ?>
		<th data-name="Alokasi" class="<?php echo $t03_rpu->Alokasi->HeaderCellClass() ?>"><div id="elh_t03_rpu_Alokasi" class="t03_rpu_Alokasi"><div class="ewTableHeaderCaption"><?php echo $t03_rpu->Alokasi->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Alokasi" class="<?php echo $t03_rpu->Alokasi->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_rpu->SortUrl($t03_rpu->Alokasi) ?>',2);"><div id="elh_t03_rpu_Alokasi" class="t03_rpu_Alokasi">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_rpu->Alokasi->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_rpu->Alokasi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_rpu->Alokasi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_rpu->Unit_KOS->Visible) { // Unit_KOS ?>
	<?php if ($t03_rpu->SortUrl($t03_rpu->Unit_KOS) == "") { ?>
		<th data-name="Unit_KOS" class="<?php echo $t03_rpu->Unit_KOS->HeaderCellClass() ?>"><div id="elh_t03_rpu_Unit_KOS" class="t03_rpu_Unit_KOS"><div class="ewTableHeaderCaption"><?php echo $t03_rpu->Unit_KOS->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Unit_KOS" class="<?php echo $t03_rpu->Unit_KOS->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_rpu->SortUrl($t03_rpu->Unit_KOS) ?>',2);"><div id="elh_t03_rpu_Unit_KOS" class="t03_rpu_Unit_KOS">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_rpu->Unit_KOS->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_rpu->Unit_KOS->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_rpu->Unit_KOS->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_rpu->Jumlah->Visible) { // Jumlah ?>
	<?php if ($t03_rpu->SortUrl($t03_rpu->Jumlah) == "") { ?>
		<th data-name="Jumlah" class="<?php echo $t03_rpu->Jumlah->HeaderCellClass() ?>"><div id="elh_t03_rpu_Jumlah" class="t03_rpu_Jumlah"><div class="ewTableHeaderCaption"><?php echo $t03_rpu->Jumlah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jumlah" class="<?php echo $t03_rpu->Jumlah->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t03_rpu->SortUrl($t03_rpu->Jumlah) ?>',2);"><div id="elh_t03_rpu_Jumlah" class="t03_rpu_Jumlah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_rpu->Jumlah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_rpu->Jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_rpu->Jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t03_rpu_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($t03_rpu->CurrentAction == "add" || $t03_rpu->CurrentAction == "copy") {
		$t03_rpu_list->RowIndex = 0;
		$t03_rpu_list->KeyCount = $t03_rpu_list->RowIndex;
		if ($t03_rpu->CurrentAction == "copy" && !$t03_rpu_list->LoadRow())
			$t03_rpu->CurrentAction = "add";
		if ($t03_rpu->CurrentAction == "add")
			$t03_rpu_list->LoadRowValues();
		if ($t03_rpu->EventCancelled) // Insert failed
			$t03_rpu_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$t03_rpu->ResetAttrs();
		$t03_rpu->RowAttrs = array_merge($t03_rpu->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_t03_rpu', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$t03_rpu->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t03_rpu_list->RenderRow();

		// Render list options
		$t03_rpu_list->RenderListOptions();
		$t03_rpu_list->StartRowCnt = 0;
?>
	<tr<?php echo $t03_rpu->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t03_rpu_list->ListOptions->Render("body", "left", $t03_rpu_list->RowCnt);
?>
	<?php if ($t03_rpu->Level->Visible) { // Level ?>
		<td data-name="Level">
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Level" class="form-group t03_rpu_Level">
<input type="text" data-table="t03_rpu" data-field="x_Level" name="x<?php echo $t03_rpu_list->RowIndex ?>_Level" id="x<?php echo $t03_rpu_list->RowIndex ?>_Level" size="1" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Level->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Level->EditValue ?>"<?php echo $t03_rpu->Level->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Level" name="o<?php echo $t03_rpu_list->RowIndex ?>_Level" id="o<?php echo $t03_rpu_list->RowIndex ?>_Level" value="<?php echo ew_HtmlEncode($t03_rpu->Level->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rpu->Urutan->Visible) { // Urutan ?>
		<td data-name="Urutan">
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Urutan" class="form-group t03_rpu_Urutan">
<input type="text" data-table="t03_rpu" data-field="x_Urutan" name="x<?php echo $t03_rpu_list->RowIndex ?>_Urutan" id="x<?php echo $t03_rpu_list->RowIndex ?>_Urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Urutan->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Urutan->EditValue ?>"<?php echo $t03_rpu->Urutan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Urutan" name="o<?php echo $t03_rpu_list->RowIndex ?>_Urutan" id="o<?php echo $t03_rpu_list->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t03_rpu->Urutan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rpu->No_Urut->Visible) { // No_Urut ?>
		<td data-name="No_Urut">
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_No_Urut" class="form-group t03_rpu_No_Urut">
<input type="text" data-table="t03_rpu" data-field="x_No_Urut" name="x<?php echo $t03_rpu_list->RowIndex ?>_No_Urut" id="x<?php echo $t03_rpu_list->RowIndex ?>_No_Urut" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->No_Urut->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->No_Urut->EditValue ?>"<?php echo $t03_rpu->No_Urut->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_No_Urut" name="o<?php echo $t03_rpu_list->RowIndex ?>_No_Urut" id="o<?php echo $t03_rpu_list->RowIndex ?>_No_Urut" value="<?php echo ew_HtmlEncode($t03_rpu->No_Urut->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rpu->Keterangan->Visible) { // Keterangan ?>
		<td data-name="Keterangan">
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Keterangan" class="form-group t03_rpu_Keterangan">
<input type="text" data-table="t03_rpu" data-field="x_Keterangan" name="x<?php echo $t03_rpu_list->RowIndex ?>_Keterangan" id="x<?php echo $t03_rpu_list->RowIndex ?>_Keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Keterangan->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Keterangan->EditValue ?>"<?php echo $t03_rpu->Keterangan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Keterangan" name="o<?php echo $t03_rpu_list->RowIndex ?>_Keterangan" id="o<?php echo $t03_rpu_list->RowIndex ?>_Keterangan" value="<?php echo ew_HtmlEncode($t03_rpu->Keterangan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rpu->Volume->Visible) { // Volume ?>
		<td data-name="Volume">
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Volume" class="form-group t03_rpu_Volume">
<input type="text" data-table="t03_rpu" data-field="x_Volume" name="x<?php echo $t03_rpu_list->RowIndex ?>_Volume" id="x<?php echo $t03_rpu_list->RowIndex ?>_Volume" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Volume->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Volume->EditValue ?>"<?php echo $t03_rpu->Volume->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Volume" name="o<?php echo $t03_rpu_list->RowIndex ?>_Volume" id="o<?php echo $t03_rpu_list->RowIndex ?>_Volume" value="<?php echo ew_HtmlEncode($t03_rpu->Volume->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rpu->Alokasi->Visible) { // Alokasi ?>
		<td data-name="Alokasi">
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Alokasi" class="form-group t03_rpu_Alokasi">
<input type="text" data-table="t03_rpu" data-field="x_Alokasi" name="x<?php echo $t03_rpu_list->RowIndex ?>_Alokasi" id="x<?php echo $t03_rpu_list->RowIndex ?>_Alokasi" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Alokasi->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Alokasi->EditValue ?>"<?php echo $t03_rpu->Alokasi->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Alokasi" name="o<?php echo $t03_rpu_list->RowIndex ?>_Alokasi" id="o<?php echo $t03_rpu_list->RowIndex ?>_Alokasi" value="<?php echo ew_HtmlEncode($t03_rpu->Alokasi->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rpu->Unit_KOS->Visible) { // Unit_KOS ?>
		<td data-name="Unit_KOS">
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Unit_KOS" class="form-group t03_rpu_Unit_KOS">
<input type="text" data-table="t03_rpu" data-field="x_Unit_KOS" name="x<?php echo $t03_rpu_list->RowIndex ?>_Unit_KOS" id="x<?php echo $t03_rpu_list->RowIndex ?>_Unit_KOS" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Unit_KOS->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Unit_KOS->EditValue ?>"<?php echo $t03_rpu->Unit_KOS->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Unit_KOS" name="o<?php echo $t03_rpu_list->RowIndex ?>_Unit_KOS" id="o<?php echo $t03_rpu_list->RowIndex ?>_Unit_KOS" value="<?php echo ew_HtmlEncode($t03_rpu->Unit_KOS->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rpu->Jumlah->Visible) { // Jumlah ?>
		<td data-name="Jumlah">
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Jumlah" class="form-group t03_rpu_Jumlah">
<input type="text" data-table="t03_rpu" data-field="x_Jumlah" name="x<?php echo $t03_rpu_list->RowIndex ?>_Jumlah" id="x<?php echo $t03_rpu_list->RowIndex ?>_Jumlah" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Jumlah->EditValue ?>"<?php echo $t03_rpu->Jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Jumlah" name="o<?php echo $t03_rpu_list->RowIndex ?>_Jumlah" id="o<?php echo $t03_rpu_list->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t03_rpu->Jumlah->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t03_rpu_list->ListOptions->Render("body", "right", $t03_rpu_list->RowCnt);
?>
<script type="text/javascript">
ft03_rpulist.UpdateOpts(<?php echo $t03_rpu_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($t03_rpu->ExportAll && $t03_rpu->Export <> "") {
	$t03_rpu_list->StopRec = $t03_rpu_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t03_rpu_list->TotalRecs > $t03_rpu_list->StartRec + $t03_rpu_list->DisplayRecs - 1)
		$t03_rpu_list->StopRec = $t03_rpu_list->StartRec + $t03_rpu_list->DisplayRecs - 1;
	else
		$t03_rpu_list->StopRec = $t03_rpu_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t03_rpu_list->FormKeyCountName) && ($t03_rpu->CurrentAction == "gridadd" || $t03_rpu->CurrentAction == "gridedit" || $t03_rpu->CurrentAction == "F")) {
		$t03_rpu_list->KeyCount = $objForm->GetValue($t03_rpu_list->FormKeyCountName);
		$t03_rpu_list->StopRec = $t03_rpu_list->StartRec + $t03_rpu_list->KeyCount - 1;
	}
}
$t03_rpu_list->RecCnt = $t03_rpu_list->StartRec - 1;
if ($t03_rpu_list->Recordset && !$t03_rpu_list->Recordset->EOF) {
	$t03_rpu_list->Recordset->MoveFirst();
	$bSelectLimit = $t03_rpu_list->UseSelectLimit;
	if (!$bSelectLimit && $t03_rpu_list->StartRec > 1)
		$t03_rpu_list->Recordset->Move($t03_rpu_list->StartRec - 1);
} elseif (!$t03_rpu->AllowAddDeleteRow && $t03_rpu_list->StopRec == 0) {
	$t03_rpu_list->StopRec = $t03_rpu->GridAddRowCount;
}

// Initialize aggregate
$t03_rpu->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t03_rpu->ResetAttrs();
$t03_rpu_list->RenderRow();
$t03_rpu_list->EditRowCnt = 0;
if ($t03_rpu->CurrentAction == "edit")
	$t03_rpu_list->RowIndex = 1;
if ($t03_rpu->CurrentAction == "gridadd")
	$t03_rpu_list->RowIndex = 0;
if ($t03_rpu->CurrentAction == "gridedit")
	$t03_rpu_list->RowIndex = 0;
while ($t03_rpu_list->RecCnt < $t03_rpu_list->StopRec) {
	$t03_rpu_list->RecCnt++;
	if (intval($t03_rpu_list->RecCnt) >= intval($t03_rpu_list->StartRec)) {
		$t03_rpu_list->RowCnt++;
		if ($t03_rpu->CurrentAction == "gridadd" || $t03_rpu->CurrentAction == "gridedit" || $t03_rpu->CurrentAction == "F") {
			$t03_rpu_list->RowIndex++;
			$objForm->Index = $t03_rpu_list->RowIndex;
			if ($objForm->HasValue($t03_rpu_list->FormActionName))
				$t03_rpu_list->RowAction = strval($objForm->GetValue($t03_rpu_list->FormActionName));
			elseif ($t03_rpu->CurrentAction == "gridadd")
				$t03_rpu_list->RowAction = "insert";
			else
				$t03_rpu_list->RowAction = "";
		}

		// Set up key count
		$t03_rpu_list->KeyCount = $t03_rpu_list->RowIndex;

		// Init row class and style
		$t03_rpu->ResetAttrs();
		$t03_rpu->CssClass = "";
		if ($t03_rpu->CurrentAction == "gridadd") {
			$t03_rpu_list->LoadRowValues(); // Load default values
		} else {
			$t03_rpu_list->LoadRowValues($t03_rpu_list->Recordset); // Load row values
		}
		$t03_rpu->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t03_rpu->CurrentAction == "gridadd") // Grid add
			$t03_rpu->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t03_rpu->CurrentAction == "gridadd" && $t03_rpu->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t03_rpu_list->RestoreCurrentRowFormValues($t03_rpu_list->RowIndex); // Restore form values
		if ($t03_rpu->CurrentAction == "edit") {
			if ($t03_rpu_list->CheckInlineEditKey() && $t03_rpu_list->EditRowCnt == 0) { // Inline edit
				$t03_rpu->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($t03_rpu->CurrentAction == "gridedit") { // Grid edit
			if ($t03_rpu->EventCancelled) {
				$t03_rpu_list->RestoreCurrentRowFormValues($t03_rpu_list->RowIndex); // Restore form values
			}
			if ($t03_rpu_list->RowAction == "insert")
				$t03_rpu->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t03_rpu->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t03_rpu->CurrentAction == "edit" && $t03_rpu->RowType == EW_ROWTYPE_EDIT && $t03_rpu->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$t03_rpu_list->RestoreFormValues(); // Restore form values
		}
		if ($t03_rpu->CurrentAction == "gridedit" && ($t03_rpu->RowType == EW_ROWTYPE_EDIT || $t03_rpu->RowType == EW_ROWTYPE_ADD) && $t03_rpu->EventCancelled) // Update failed
			$t03_rpu_list->RestoreCurrentRowFormValues($t03_rpu_list->RowIndex); // Restore form values
		if ($t03_rpu->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t03_rpu_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$t03_rpu->RowAttrs = array_merge($t03_rpu->RowAttrs, array('data-rowindex'=>$t03_rpu_list->RowCnt, 'id'=>'r' . $t03_rpu_list->RowCnt . '_t03_rpu', 'data-rowtype'=>$t03_rpu->RowType));

		// Render row
		$t03_rpu_list->RenderRow();

		// Render list options
		$t03_rpu_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t03_rpu_list->RowAction <> "delete" && $t03_rpu_list->RowAction <> "insertdelete" && !($t03_rpu_list->RowAction == "insert" && $t03_rpu->CurrentAction == "F" && $t03_rpu_list->EmptyRow())) {
?>
	<tr<?php echo $t03_rpu->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t03_rpu_list->ListOptions->Render("body", "left", $t03_rpu_list->RowCnt);
?>
	<?php if ($t03_rpu->Level->Visible) { // Level ?>
		<td data-name="Level"<?php echo $t03_rpu->Level->CellAttributes() ?>>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Level" class="form-group t03_rpu_Level">
<input type="text" data-table="t03_rpu" data-field="x_Level" name="x<?php echo $t03_rpu_list->RowIndex ?>_Level" id="x<?php echo $t03_rpu_list->RowIndex ?>_Level" size="1" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Level->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Level->EditValue ?>"<?php echo $t03_rpu->Level->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Level" name="o<?php echo $t03_rpu_list->RowIndex ?>_Level" id="o<?php echo $t03_rpu_list->RowIndex ?>_Level" value="<?php echo ew_HtmlEncode($t03_rpu->Level->OldValue) ?>">
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Level" class="form-group t03_rpu_Level">
<input type="text" data-table="t03_rpu" data-field="x_Level" name="x<?php echo $t03_rpu_list->RowIndex ?>_Level" id="x<?php echo $t03_rpu_list->RowIndex ?>_Level" size="1" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Level->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Level->EditValue ?>"<?php echo $t03_rpu->Level->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Level" class="t03_rpu_Level">
<span<?php echo $t03_rpu->Level->ViewAttributes() ?>>
<?php echo $t03_rpu->Level->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t03_rpu" data-field="x_id" name="x<?php echo $t03_rpu_list->RowIndex ?>_id" id="x<?php echo $t03_rpu_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_rpu->id->CurrentValue) ?>">
<input type="hidden" data-table="t03_rpu" data-field="x_id" name="o<?php echo $t03_rpu_list->RowIndex ?>_id" id="o<?php echo $t03_rpu_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_rpu->id->OldValue) ?>">
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_EDIT || $t03_rpu->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t03_rpu" data-field="x_id" name="x<?php echo $t03_rpu_list->RowIndex ?>_id" id="x<?php echo $t03_rpu_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_rpu->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t03_rpu->Urutan->Visible) { // Urutan ?>
		<td data-name="Urutan"<?php echo $t03_rpu->Urutan->CellAttributes() ?>>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Urutan" class="form-group t03_rpu_Urutan">
<input type="text" data-table="t03_rpu" data-field="x_Urutan" name="x<?php echo $t03_rpu_list->RowIndex ?>_Urutan" id="x<?php echo $t03_rpu_list->RowIndex ?>_Urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Urutan->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Urutan->EditValue ?>"<?php echo $t03_rpu->Urutan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Urutan" name="o<?php echo $t03_rpu_list->RowIndex ?>_Urutan" id="o<?php echo $t03_rpu_list->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t03_rpu->Urutan->OldValue) ?>">
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Urutan" class="form-group t03_rpu_Urutan">
<input type="text" data-table="t03_rpu" data-field="x_Urutan" name="x<?php echo $t03_rpu_list->RowIndex ?>_Urutan" id="x<?php echo $t03_rpu_list->RowIndex ?>_Urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Urutan->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Urutan->EditValue ?>"<?php echo $t03_rpu->Urutan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Urutan" class="t03_rpu_Urutan">
<span<?php echo $t03_rpu->Urutan->ViewAttributes() ?>>
<?php echo $t03_rpu->Urutan->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_rpu->No_Urut->Visible) { // No_Urut ?>
		<td data-name="No_Urut"<?php echo $t03_rpu->No_Urut->CellAttributes() ?>>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_No_Urut" class="form-group t03_rpu_No_Urut">
<input type="text" data-table="t03_rpu" data-field="x_No_Urut" name="x<?php echo $t03_rpu_list->RowIndex ?>_No_Urut" id="x<?php echo $t03_rpu_list->RowIndex ?>_No_Urut" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->No_Urut->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->No_Urut->EditValue ?>"<?php echo $t03_rpu->No_Urut->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_No_Urut" name="o<?php echo $t03_rpu_list->RowIndex ?>_No_Urut" id="o<?php echo $t03_rpu_list->RowIndex ?>_No_Urut" value="<?php echo ew_HtmlEncode($t03_rpu->No_Urut->OldValue) ?>">
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_No_Urut" class="form-group t03_rpu_No_Urut">
<input type="text" data-table="t03_rpu" data-field="x_No_Urut" name="x<?php echo $t03_rpu_list->RowIndex ?>_No_Urut" id="x<?php echo $t03_rpu_list->RowIndex ?>_No_Urut" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->No_Urut->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->No_Urut->EditValue ?>"<?php echo $t03_rpu->No_Urut->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_No_Urut" class="t03_rpu_No_Urut">
<span<?php echo $t03_rpu->No_Urut->ViewAttributes() ?>>
<?php echo $t03_rpu->No_Urut->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_rpu->Keterangan->Visible) { // Keterangan ?>
		<td data-name="Keterangan"<?php echo $t03_rpu->Keterangan->CellAttributes() ?>>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Keterangan" class="form-group t03_rpu_Keterangan">
<input type="text" data-table="t03_rpu" data-field="x_Keterangan" name="x<?php echo $t03_rpu_list->RowIndex ?>_Keterangan" id="x<?php echo $t03_rpu_list->RowIndex ?>_Keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Keterangan->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Keterangan->EditValue ?>"<?php echo $t03_rpu->Keterangan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Keterangan" name="o<?php echo $t03_rpu_list->RowIndex ?>_Keterangan" id="o<?php echo $t03_rpu_list->RowIndex ?>_Keterangan" value="<?php echo ew_HtmlEncode($t03_rpu->Keterangan->OldValue) ?>">
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Keterangan" class="form-group t03_rpu_Keterangan">
<input type="text" data-table="t03_rpu" data-field="x_Keterangan" name="x<?php echo $t03_rpu_list->RowIndex ?>_Keterangan" id="x<?php echo $t03_rpu_list->RowIndex ?>_Keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Keterangan->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Keterangan->EditValue ?>"<?php echo $t03_rpu->Keterangan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Keterangan" class="t03_rpu_Keterangan">
<span<?php echo $t03_rpu->Keterangan->ViewAttributes() ?>>
<?php echo $t03_rpu->Keterangan->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_rpu->Volume->Visible) { // Volume ?>
		<td data-name="Volume"<?php echo $t03_rpu->Volume->CellAttributes() ?>>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Volume" class="form-group t03_rpu_Volume">
<input type="text" data-table="t03_rpu" data-field="x_Volume" name="x<?php echo $t03_rpu_list->RowIndex ?>_Volume" id="x<?php echo $t03_rpu_list->RowIndex ?>_Volume" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Volume->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Volume->EditValue ?>"<?php echo $t03_rpu->Volume->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Volume" name="o<?php echo $t03_rpu_list->RowIndex ?>_Volume" id="o<?php echo $t03_rpu_list->RowIndex ?>_Volume" value="<?php echo ew_HtmlEncode($t03_rpu->Volume->OldValue) ?>">
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Volume" class="form-group t03_rpu_Volume">
<input type="text" data-table="t03_rpu" data-field="x_Volume" name="x<?php echo $t03_rpu_list->RowIndex ?>_Volume" id="x<?php echo $t03_rpu_list->RowIndex ?>_Volume" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Volume->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Volume->EditValue ?>"<?php echo $t03_rpu->Volume->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Volume" class="t03_rpu_Volume">
<span<?php echo $t03_rpu->Volume->ViewAttributes() ?>>
<?php echo $t03_rpu->Volume->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_rpu->Alokasi->Visible) { // Alokasi ?>
		<td data-name="Alokasi"<?php echo $t03_rpu->Alokasi->CellAttributes() ?>>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Alokasi" class="form-group t03_rpu_Alokasi">
<input type="text" data-table="t03_rpu" data-field="x_Alokasi" name="x<?php echo $t03_rpu_list->RowIndex ?>_Alokasi" id="x<?php echo $t03_rpu_list->RowIndex ?>_Alokasi" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Alokasi->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Alokasi->EditValue ?>"<?php echo $t03_rpu->Alokasi->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Alokasi" name="o<?php echo $t03_rpu_list->RowIndex ?>_Alokasi" id="o<?php echo $t03_rpu_list->RowIndex ?>_Alokasi" value="<?php echo ew_HtmlEncode($t03_rpu->Alokasi->OldValue) ?>">
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Alokasi" class="form-group t03_rpu_Alokasi">
<input type="text" data-table="t03_rpu" data-field="x_Alokasi" name="x<?php echo $t03_rpu_list->RowIndex ?>_Alokasi" id="x<?php echo $t03_rpu_list->RowIndex ?>_Alokasi" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Alokasi->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Alokasi->EditValue ?>"<?php echo $t03_rpu->Alokasi->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Alokasi" class="t03_rpu_Alokasi">
<span<?php echo $t03_rpu->Alokasi->ViewAttributes() ?>>
<?php echo $t03_rpu->Alokasi->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_rpu->Unit_KOS->Visible) { // Unit_KOS ?>
		<td data-name="Unit_KOS"<?php echo $t03_rpu->Unit_KOS->CellAttributes() ?>>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Unit_KOS" class="form-group t03_rpu_Unit_KOS">
<input type="text" data-table="t03_rpu" data-field="x_Unit_KOS" name="x<?php echo $t03_rpu_list->RowIndex ?>_Unit_KOS" id="x<?php echo $t03_rpu_list->RowIndex ?>_Unit_KOS" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Unit_KOS->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Unit_KOS->EditValue ?>"<?php echo $t03_rpu->Unit_KOS->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Unit_KOS" name="o<?php echo $t03_rpu_list->RowIndex ?>_Unit_KOS" id="o<?php echo $t03_rpu_list->RowIndex ?>_Unit_KOS" value="<?php echo ew_HtmlEncode($t03_rpu->Unit_KOS->OldValue) ?>">
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Unit_KOS" class="form-group t03_rpu_Unit_KOS">
<input type="text" data-table="t03_rpu" data-field="x_Unit_KOS" name="x<?php echo $t03_rpu_list->RowIndex ?>_Unit_KOS" id="x<?php echo $t03_rpu_list->RowIndex ?>_Unit_KOS" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Unit_KOS->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Unit_KOS->EditValue ?>"<?php echo $t03_rpu->Unit_KOS->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Unit_KOS" class="t03_rpu_Unit_KOS">
<span<?php echo $t03_rpu->Unit_KOS->ViewAttributes() ?>>
<?php echo $t03_rpu->Unit_KOS->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_rpu->Jumlah->Visible) { // Jumlah ?>
		<td data-name="Jumlah"<?php echo $t03_rpu->Jumlah->CellAttributes() ?>>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Jumlah" class="form-group t03_rpu_Jumlah">
<input type="text" data-table="t03_rpu" data-field="x_Jumlah" name="x<?php echo $t03_rpu_list->RowIndex ?>_Jumlah" id="x<?php echo $t03_rpu_list->RowIndex ?>_Jumlah" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Jumlah->EditValue ?>"<?php echo $t03_rpu->Jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Jumlah" name="o<?php echo $t03_rpu_list->RowIndex ?>_Jumlah" id="o<?php echo $t03_rpu_list->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t03_rpu->Jumlah->OldValue) ?>">
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Jumlah" class="form-group t03_rpu_Jumlah">
<input type="text" data-table="t03_rpu" data-field="x_Jumlah" name="x<?php echo $t03_rpu_list->RowIndex ?>_Jumlah" id="x<?php echo $t03_rpu_list->RowIndex ?>_Jumlah" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Jumlah->EditValue ?>"<?php echo $t03_rpu->Jumlah->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_rpu_list->RowCnt ?>_t03_rpu_Jumlah" class="t03_rpu_Jumlah">
<span<?php echo $t03_rpu->Jumlah->ViewAttributes() ?>>
<?php echo $t03_rpu->Jumlah->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t03_rpu_list->ListOptions->Render("body", "right", $t03_rpu_list->RowCnt);
?>
	</tr>
<?php if ($t03_rpu->RowType == EW_ROWTYPE_ADD || $t03_rpu->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft03_rpulist.UpdateOpts(<?php echo $t03_rpu_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t03_rpu->CurrentAction <> "gridadd")
		if (!$t03_rpu_list->Recordset->EOF) $t03_rpu_list->Recordset->MoveNext();
}
?>
<?php
	if ($t03_rpu->CurrentAction == "gridadd" || $t03_rpu->CurrentAction == "gridedit") {
		$t03_rpu_list->RowIndex = '$rowindex$';
		$t03_rpu_list->LoadRowValues();

		// Set row properties
		$t03_rpu->ResetAttrs();
		$t03_rpu->RowAttrs = array_merge($t03_rpu->RowAttrs, array('data-rowindex'=>$t03_rpu_list->RowIndex, 'id'=>'r0_t03_rpu', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t03_rpu->RowAttrs["class"], "ewTemplate");
		$t03_rpu->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t03_rpu_list->RenderRow();

		// Render list options
		$t03_rpu_list->RenderListOptions();
		$t03_rpu_list->StartRowCnt = 0;
?>
	<tr<?php echo $t03_rpu->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t03_rpu_list->ListOptions->Render("body", "left", $t03_rpu_list->RowIndex);
?>
	<?php if ($t03_rpu->Level->Visible) { // Level ?>
		<td data-name="Level">
<span id="el$rowindex$_t03_rpu_Level" class="form-group t03_rpu_Level">
<input type="text" data-table="t03_rpu" data-field="x_Level" name="x<?php echo $t03_rpu_list->RowIndex ?>_Level" id="x<?php echo $t03_rpu_list->RowIndex ?>_Level" size="1" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Level->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Level->EditValue ?>"<?php echo $t03_rpu->Level->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Level" name="o<?php echo $t03_rpu_list->RowIndex ?>_Level" id="o<?php echo $t03_rpu_list->RowIndex ?>_Level" value="<?php echo ew_HtmlEncode($t03_rpu->Level->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rpu->Urutan->Visible) { // Urutan ?>
		<td data-name="Urutan">
<span id="el$rowindex$_t03_rpu_Urutan" class="form-group t03_rpu_Urutan">
<input type="text" data-table="t03_rpu" data-field="x_Urutan" name="x<?php echo $t03_rpu_list->RowIndex ?>_Urutan" id="x<?php echo $t03_rpu_list->RowIndex ?>_Urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Urutan->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Urutan->EditValue ?>"<?php echo $t03_rpu->Urutan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Urutan" name="o<?php echo $t03_rpu_list->RowIndex ?>_Urutan" id="o<?php echo $t03_rpu_list->RowIndex ?>_Urutan" value="<?php echo ew_HtmlEncode($t03_rpu->Urutan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rpu->No_Urut->Visible) { // No_Urut ?>
		<td data-name="No_Urut">
<span id="el$rowindex$_t03_rpu_No_Urut" class="form-group t03_rpu_No_Urut">
<input type="text" data-table="t03_rpu" data-field="x_No_Urut" name="x<?php echo $t03_rpu_list->RowIndex ?>_No_Urut" id="x<?php echo $t03_rpu_list->RowIndex ?>_No_Urut" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->No_Urut->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->No_Urut->EditValue ?>"<?php echo $t03_rpu->No_Urut->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_No_Urut" name="o<?php echo $t03_rpu_list->RowIndex ?>_No_Urut" id="o<?php echo $t03_rpu_list->RowIndex ?>_No_Urut" value="<?php echo ew_HtmlEncode($t03_rpu->No_Urut->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rpu->Keterangan->Visible) { // Keterangan ?>
		<td data-name="Keterangan">
<span id="el$rowindex$_t03_rpu_Keterangan" class="form-group t03_rpu_Keterangan">
<input type="text" data-table="t03_rpu" data-field="x_Keterangan" name="x<?php echo $t03_rpu_list->RowIndex ?>_Keterangan" id="x<?php echo $t03_rpu_list->RowIndex ?>_Keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Keterangan->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Keterangan->EditValue ?>"<?php echo $t03_rpu->Keterangan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Keterangan" name="o<?php echo $t03_rpu_list->RowIndex ?>_Keterangan" id="o<?php echo $t03_rpu_list->RowIndex ?>_Keterangan" value="<?php echo ew_HtmlEncode($t03_rpu->Keterangan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rpu->Volume->Visible) { // Volume ?>
		<td data-name="Volume">
<span id="el$rowindex$_t03_rpu_Volume" class="form-group t03_rpu_Volume">
<input type="text" data-table="t03_rpu" data-field="x_Volume" name="x<?php echo $t03_rpu_list->RowIndex ?>_Volume" id="x<?php echo $t03_rpu_list->RowIndex ?>_Volume" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Volume->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Volume->EditValue ?>"<?php echo $t03_rpu->Volume->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Volume" name="o<?php echo $t03_rpu_list->RowIndex ?>_Volume" id="o<?php echo $t03_rpu_list->RowIndex ?>_Volume" value="<?php echo ew_HtmlEncode($t03_rpu->Volume->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rpu->Alokasi->Visible) { // Alokasi ?>
		<td data-name="Alokasi">
<span id="el$rowindex$_t03_rpu_Alokasi" class="form-group t03_rpu_Alokasi">
<input type="text" data-table="t03_rpu" data-field="x_Alokasi" name="x<?php echo $t03_rpu_list->RowIndex ?>_Alokasi" id="x<?php echo $t03_rpu_list->RowIndex ?>_Alokasi" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Alokasi->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Alokasi->EditValue ?>"<?php echo $t03_rpu->Alokasi->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Alokasi" name="o<?php echo $t03_rpu_list->RowIndex ?>_Alokasi" id="o<?php echo $t03_rpu_list->RowIndex ?>_Alokasi" value="<?php echo ew_HtmlEncode($t03_rpu->Alokasi->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rpu->Unit_KOS->Visible) { // Unit_KOS ?>
		<td data-name="Unit_KOS">
<span id="el$rowindex$_t03_rpu_Unit_KOS" class="form-group t03_rpu_Unit_KOS">
<input type="text" data-table="t03_rpu" data-field="x_Unit_KOS" name="x<?php echo $t03_rpu_list->RowIndex ?>_Unit_KOS" id="x<?php echo $t03_rpu_list->RowIndex ?>_Unit_KOS" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Unit_KOS->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Unit_KOS->EditValue ?>"<?php echo $t03_rpu->Unit_KOS->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Unit_KOS" name="o<?php echo $t03_rpu_list->RowIndex ?>_Unit_KOS" id="o<?php echo $t03_rpu_list->RowIndex ?>_Unit_KOS" value="<?php echo ew_HtmlEncode($t03_rpu->Unit_KOS->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rpu->Jumlah->Visible) { // Jumlah ?>
		<td data-name="Jumlah">
<span id="el$rowindex$_t03_rpu_Jumlah" class="form-group t03_rpu_Jumlah">
<input type="text" data-table="t03_rpu" data-field="x_Jumlah" name="x<?php echo $t03_rpu_list->RowIndex ?>_Jumlah" id="x<?php echo $t03_rpu_list->RowIndex ?>_Jumlah" size="10" placeholder="<?php echo ew_HtmlEncode($t03_rpu->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t03_rpu->Jumlah->EditValue ?>"<?php echo $t03_rpu->Jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rpu" data-field="x_Jumlah" name="o<?php echo $t03_rpu_list->RowIndex ?>_Jumlah" id="o<?php echo $t03_rpu_list->RowIndex ?>_Jumlah" value="<?php echo ew_HtmlEncode($t03_rpu->Jumlah->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t03_rpu_list->ListOptions->Render("body", "right", $t03_rpu_list->RowIndex);
?>
<script type="text/javascript">
ft03_rpulist.UpdateOpts(<?php echo $t03_rpu_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t03_rpu->CurrentAction == "add" || $t03_rpu->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $t03_rpu_list->FormKeyCountName ?>" id="<?php echo $t03_rpu_list->FormKeyCountName ?>" value="<?php echo $t03_rpu_list->KeyCount ?>">
<?php } ?>
<?php if ($t03_rpu->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t03_rpu_list->FormKeyCountName ?>" id="<?php echo $t03_rpu_list->FormKeyCountName ?>" value="<?php echo $t03_rpu_list->KeyCount ?>">
<?php echo $t03_rpu_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t03_rpu->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $t03_rpu_list->FormKeyCountName ?>" id="<?php echo $t03_rpu_list->FormKeyCountName ?>" value="<?php echo $t03_rpu_list->KeyCount ?>">
<?php } ?>
<?php if ($t03_rpu->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t03_rpu_list->FormKeyCountName ?>" id="<?php echo $t03_rpu_list->FormKeyCountName ?>" value="<?php echo $t03_rpu_list->KeyCount ?>">
<?php echo $t03_rpu_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t03_rpu->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t03_rpu_list->Recordset)
	$t03_rpu_list->Recordset->Close();
?>
<?php if ($t03_rpu->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($t03_rpu->CurrentAction <> "gridadd" && $t03_rpu->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t03_rpu_list->Pager)) $t03_rpu_list->Pager = new cPrevNextPager($t03_rpu_list->StartRec, $t03_rpu_list->DisplayRecs, $t03_rpu_list->TotalRecs, $t03_rpu_list->AutoHidePager) ?>
<?php if ($t03_rpu_list->Pager->RecordCount > 0 && $t03_rpu_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t03_rpu_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t03_rpu_list->PageUrl() ?>start=<?php echo $t03_rpu_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t03_rpu_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t03_rpu_list->PageUrl() ?>start=<?php echo $t03_rpu_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t03_rpu_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t03_rpu_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t03_rpu_list->PageUrl() ?>start=<?php echo $t03_rpu_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t03_rpu_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t03_rpu_list->PageUrl() ?>start=<?php echo $t03_rpu_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t03_rpu_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t03_rpu_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t03_rpu_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t03_rpu_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t03_rpu_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t03_rpu_list->TotalRecs > 0 && (!$t03_rpu_list->AutoHidePageSizeSelector || $t03_rpu_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t03_rpu">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t03_rpu_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t03_rpu_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t03_rpu_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t03_rpu_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($t03_rpu->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t03_rpu_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($t03_rpu_list->TotalRecs == 0 && $t03_rpu->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t03_rpu_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t03_rpu->Export == "") { ?>
<script type="text/javascript">
ft03_rpulistsrch.FilterList = <?php echo $t03_rpu_list->GetFilterList() ?>;
ft03_rpulistsrch.Init();
ft03_rpulist.Init();
</script>
<?php } ?>
<?php
$t03_rpu_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($t03_rpu->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$t03_rpu_list->Page_Terminate();
?>
