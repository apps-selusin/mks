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

$t02_rkas_list = NULL; // Initialize page object first

class ct02_rkas_list extends ct02_rkas {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}';

	// Table name
	var $TableName = 't02_rkas';

	// Page object name
	var $PageObjName = 't02_rkas_list';

	// Grid form hidden field names
	var $FormName = 'ft02_rkaslist';
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

		// Table object (t02_rkas)
		if (!isset($GLOBALS["t02_rkas"]) || get_class($GLOBALS["t02_rkas"]) == "ct02_rkas") {
			$GLOBALS["t02_rkas"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t02_rkas"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t02_rkasadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t02_rkasdelete.php";
		$this->MultiUpdateUrl = "t02_rkasupdate.php";

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft02_rkaslistsrch";

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
		$this->jml1->FormValue = ""; // Clear form value
		$this->jml2->FormValue = ""; // Clear form value
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
		if ($objForm->HasValue("x_lvl") && $objForm->HasValue("o_lvl") && $this->lvl->CurrentValue <> $this->lvl->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_urutan") && $objForm->HasValue("o_urutan") && $this->urutan->CurrentValue <> $this->urutan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_nour1") && $objForm->HasValue("o_nour1") && $this->nour1->CurrentValue <> $this->nour1->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_ket1") && $objForm->HasValue("o_ket1") && $this->ket1->CurrentValue <> $this->ket1->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_jml1") && $objForm->HasValue("o_jml1") && $this->jml1->CurrentValue <> $this->jml1->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_nour2") && $objForm->HasValue("o_nour2") && $this->nour2->CurrentValue <> $this->nour2->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_ket2") && $objForm->HasValue("o_ket2") && $this->ket2->CurrentValue <> $this->ket2->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_jml2") && $objForm->HasValue("o_jml2") && $this->jml2->CurrentValue <> $this->jml2->OldValue)
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
		$sFilterList = ew_Concat($sFilterList, $this->lvl->AdvancedSearch->ToJson(), ","); // Field lvl
		$sFilterList = ew_Concat($sFilterList, $this->urutan->AdvancedSearch->ToJson(), ","); // Field urutan
		$sFilterList = ew_Concat($sFilterList, $this->nour1->AdvancedSearch->ToJson(), ","); // Field nour1
		$sFilterList = ew_Concat($sFilterList, $this->ket1->AdvancedSearch->ToJson(), ","); // Field ket1
		$sFilterList = ew_Concat($sFilterList, $this->jml1->AdvancedSearch->ToJson(), ","); // Field jml1
		$sFilterList = ew_Concat($sFilterList, $this->nour2->AdvancedSearch->ToJson(), ","); // Field nour2
		$sFilterList = ew_Concat($sFilterList, $this->ket2->AdvancedSearch->ToJson(), ","); // Field ket2
		$sFilterList = ew_Concat($sFilterList, $this->jml2->AdvancedSearch->ToJson(), ","); // Field jml2
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft02_rkaslistsrch", $filters);

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

		// Field lvl
		$this->lvl->AdvancedSearch->SearchValue = @$filter["x_lvl"];
		$this->lvl->AdvancedSearch->SearchOperator = @$filter["z_lvl"];
		$this->lvl->AdvancedSearch->SearchCondition = @$filter["v_lvl"];
		$this->lvl->AdvancedSearch->SearchValue2 = @$filter["y_lvl"];
		$this->lvl->AdvancedSearch->SearchOperator2 = @$filter["w_lvl"];
		$this->lvl->AdvancedSearch->Save();

		// Field urutan
		$this->urutan->AdvancedSearch->SearchValue = @$filter["x_urutan"];
		$this->urutan->AdvancedSearch->SearchOperator = @$filter["z_urutan"];
		$this->urutan->AdvancedSearch->SearchCondition = @$filter["v_urutan"];
		$this->urutan->AdvancedSearch->SearchValue2 = @$filter["y_urutan"];
		$this->urutan->AdvancedSearch->SearchOperator2 = @$filter["w_urutan"];
		$this->urutan->AdvancedSearch->Save();

		// Field nour1
		$this->nour1->AdvancedSearch->SearchValue = @$filter["x_nour1"];
		$this->nour1->AdvancedSearch->SearchOperator = @$filter["z_nour1"];
		$this->nour1->AdvancedSearch->SearchCondition = @$filter["v_nour1"];
		$this->nour1->AdvancedSearch->SearchValue2 = @$filter["y_nour1"];
		$this->nour1->AdvancedSearch->SearchOperator2 = @$filter["w_nour1"];
		$this->nour1->AdvancedSearch->Save();

		// Field ket1
		$this->ket1->AdvancedSearch->SearchValue = @$filter["x_ket1"];
		$this->ket1->AdvancedSearch->SearchOperator = @$filter["z_ket1"];
		$this->ket1->AdvancedSearch->SearchCondition = @$filter["v_ket1"];
		$this->ket1->AdvancedSearch->SearchValue2 = @$filter["y_ket1"];
		$this->ket1->AdvancedSearch->SearchOperator2 = @$filter["w_ket1"];
		$this->ket1->AdvancedSearch->Save();

		// Field jml1
		$this->jml1->AdvancedSearch->SearchValue = @$filter["x_jml1"];
		$this->jml1->AdvancedSearch->SearchOperator = @$filter["z_jml1"];
		$this->jml1->AdvancedSearch->SearchCondition = @$filter["v_jml1"];
		$this->jml1->AdvancedSearch->SearchValue2 = @$filter["y_jml1"];
		$this->jml1->AdvancedSearch->SearchOperator2 = @$filter["w_jml1"];
		$this->jml1->AdvancedSearch->Save();

		// Field nour2
		$this->nour2->AdvancedSearch->SearchValue = @$filter["x_nour2"];
		$this->nour2->AdvancedSearch->SearchOperator = @$filter["z_nour2"];
		$this->nour2->AdvancedSearch->SearchCondition = @$filter["v_nour2"];
		$this->nour2->AdvancedSearch->SearchValue2 = @$filter["y_nour2"];
		$this->nour2->AdvancedSearch->SearchOperator2 = @$filter["w_nour2"];
		$this->nour2->AdvancedSearch->Save();

		// Field ket2
		$this->ket2->AdvancedSearch->SearchValue = @$filter["x_ket2"];
		$this->ket2->AdvancedSearch->SearchOperator = @$filter["z_ket2"];
		$this->ket2->AdvancedSearch->SearchCondition = @$filter["v_ket2"];
		$this->ket2->AdvancedSearch->SearchValue2 = @$filter["y_ket2"];
		$this->ket2->AdvancedSearch->SearchOperator2 = @$filter["w_ket2"];
		$this->ket2->AdvancedSearch->Save();

		// Field jml2
		$this->jml2->AdvancedSearch->SearchValue = @$filter["x_jml2"];
		$this->jml2->AdvancedSearch->SearchOperator = @$filter["z_jml2"];
		$this->jml2->AdvancedSearch->SearchCondition = @$filter["v_jml2"];
		$this->jml2->AdvancedSearch->SearchValue2 = @$filter["y_jml2"];
		$this->jml2->AdvancedSearch->SearchOperator2 = @$filter["w_jml2"];
		$this->jml2->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->ket1, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ket2, $arKeywords, $type);
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
			$this->UpdateSort($this->lvl, $bCtrl); // lvl
			$this->UpdateSort($this->urutan, $bCtrl); // urutan
			$this->UpdateSort($this->nour1, $bCtrl); // nour1
			$this->UpdateSort($this->ket1, $bCtrl); // ket1
			$this->UpdateSort($this->jml1, $bCtrl); // jml1
			$this->UpdateSort($this->nour2, $bCtrl); // nour2
			$this->UpdateSort($this->ket2, $bCtrl); // ket2
			$this->UpdateSort($this->jml2, $bCtrl); // jml2
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
				$this->urutan->setSort("ASC");
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
				$this->lvl->setSort("");
				$this->urutan->setSort("");
				$this->nour1->setSort("");
				$this->ket1->setSort("");
				$this->jml1->setSort("");
				$this->nour2->setSort("");
				$this->ket2->setSort("");
				$this->jml2->setSort("");
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.ft02_rkaslist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft02_rkaslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft02_rkaslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft02_rkaslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft02_rkaslistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$this->lvl->CurrentValue = 1;
		$this->lvl->OldValue = $this->lvl->CurrentValue;
		$this->urutan->CurrentValue = NULL;
		$this->urutan->OldValue = $this->urutan->CurrentValue;
		$this->nour1->CurrentValue = NULL;
		$this->nour1->OldValue = $this->nour1->CurrentValue;
		$this->ket1->CurrentValue = NULL;
		$this->ket1->OldValue = $this->ket1->CurrentValue;
		$this->jml1->CurrentValue = 0;
		$this->jml1->OldValue = $this->jml1->CurrentValue;
		$this->nour2->CurrentValue = NULL;
		$this->nour2->OldValue = $this->nour2->CurrentValue;
		$this->ket2->CurrentValue = NULL;
		$this->ket2->OldValue = $this->ket2->CurrentValue;
		$this->jml2->CurrentValue = 0;
		$this->jml2->OldValue = $this->jml2->CurrentValue;
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
		if (!$this->lvl->FldIsDetailKey) {
			$this->lvl->setFormValue($objForm->GetValue("x_lvl"));
		}
		$this->lvl->setOldValue($objForm->GetValue("o_lvl"));
		if (!$this->urutan->FldIsDetailKey) {
			$this->urutan->setFormValue($objForm->GetValue("x_urutan"));
		}
		$this->urutan->setOldValue($objForm->GetValue("o_urutan"));
		if (!$this->nour1->FldIsDetailKey) {
			$this->nour1->setFormValue($objForm->GetValue("x_nour1"));
		}
		$this->nour1->setOldValue($objForm->GetValue("o_nour1"));
		if (!$this->ket1->FldIsDetailKey) {
			$this->ket1->setFormValue($objForm->GetValue("x_ket1"));
		}
		$this->ket1->setOldValue($objForm->GetValue("o_ket1"));
		if (!$this->jml1->FldIsDetailKey) {
			$this->jml1->setFormValue($objForm->GetValue("x_jml1"));
		}
		$this->jml1->setOldValue($objForm->GetValue("o_jml1"));
		if (!$this->nour2->FldIsDetailKey) {
			$this->nour2->setFormValue($objForm->GetValue("x_nour2"));
		}
		$this->nour2->setOldValue($objForm->GetValue("o_nour2"));
		if (!$this->ket2->FldIsDetailKey) {
			$this->ket2->setFormValue($objForm->GetValue("x_ket2"));
		}
		$this->ket2->setOldValue($objForm->GetValue("o_ket2"));
		if (!$this->jml2->FldIsDetailKey) {
			$this->jml2->setFormValue($objForm->GetValue("x_jml2"));
		}
		$this->jml2->setOldValue($objForm->GetValue("o_jml2"));
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
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
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['lvl'] = $this->lvl->CurrentValue;
		$row['urutan'] = $this->urutan->CurrentValue;
		$row['nour1'] = $this->nour1->CurrentValue;
		$row['ket1'] = $this->ket1->CurrentValue;
		$row['jml1'] = $this->jml1->CurrentValue;
		$row['nour2'] = $this->nour2->CurrentValue;
		$row['ket2'] = $this->ket2->CurrentValue;
		$row['jml2'] = $this->jml2->CurrentValue;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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
			if (strval($this->jml1->EditValue) <> "" && is_numeric($this->jml1->EditValue)) {
			$this->jml1->EditValue = ew_FormatNumber($this->jml1->EditValue, -2, -2, -2, -2);
			$this->jml1->OldValue = $this->jml1->EditValue;
			}

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
			if (strval($this->jml2->EditValue) <> "" && is_numeric($this->jml2->EditValue)) {
			$this->jml2->EditValue = ew_FormatNumber($this->jml2->EditValue, -2, -2, -2, -2);
			$this->jml2->OldValue = $this->jml2->EditValue;
			}

			// Add refer script
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
			if (strval($this->jml1->EditValue) <> "" && is_numeric($this->jml1->EditValue)) {
			$this->jml1->EditValue = ew_FormatNumber($this->jml1->EditValue, -2, -2, -2, -2);
			$this->jml1->OldValue = $this->jml1->EditValue;
			}

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
			if (strval($this->jml2->EditValue) <> "" && is_numeric($this->jml2->EditValue)) {
			$this->jml2->EditValue = ew_FormatNumber($this->jml2->EditValue, -2, -2, -2, -2);
			$this->jml2->OldValue = $this->jml2->EditValue;
			}

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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// lvl
		$this->lvl->SetDbValueDef($rsnew, $this->lvl->CurrentValue, 0, FALSE);

		// urutan
		$this->urutan->SetDbValueDef($rsnew, $this->urutan->CurrentValue, 0, FALSE);

		// nour1
		$this->nour1->SetDbValueDef($rsnew, $this->nour1->CurrentValue, NULL, FALSE);

		// ket1
		$this->ket1->SetDbValueDef($rsnew, $this->ket1->CurrentValue, NULL, FALSE);

		// jml1
		$this->jml1->SetDbValueDef($rsnew, $this->jml1->CurrentValue, NULL, strval($this->jml1->CurrentValue) == "");

		// nour2
		$this->nour2->SetDbValueDef($rsnew, $this->nour2->CurrentValue, NULL, FALSE);

		// ket2
		$this->ket2->SetDbValueDef($rsnew, $this->ket2->CurrentValue, NULL, FALSE);

		// jml2
		$this->jml2->SetDbValueDef($rsnew, $this->jml2->CurrentValue, NULL, strval($this->jml2->CurrentValue) == "");

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
		$item->Body = "<button id=\"emf_t02_rkas\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_t02_rkas',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ft02_rkaslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
if (!isset($t02_rkas_list)) $t02_rkas_list = new ct02_rkas_list();

// Page init
$t02_rkas_list->Page_Init();

// Page main
$t02_rkas_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t02_rkas_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($t02_rkas->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft02_rkaslist = new ew_Form("ft02_rkaslist", "list");
ft02_rkaslist.FormKeyCountName = '<?php echo $t02_rkas_list->FormKeyCountName ?>';

// Validate form
ft02_rkaslist.Validate = function() {
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
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
ft02_rkaslist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "lvl", false)) return false;
	if (ew_ValueChanged(fobj, infix, "urutan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nour1", false)) return false;
	if (ew_ValueChanged(fobj, infix, "ket1", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jml1", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nour2", false)) return false;
	if (ew_ValueChanged(fobj, infix, "ket2", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jml2", false)) return false;
	return true;
}

// Form_CustomValidate event
ft02_rkaslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft02_rkaslist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = ft02_rkaslistsrch = new ew_Form("ft02_rkaslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($t02_rkas->Export == "") { ?>
<div class="ewToolbar">
<?php if ($t02_rkas_list->TotalRecs > 0 && $t02_rkas_list->ExportOptions->Visible()) { ?>
<?php $t02_rkas_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t02_rkas_list->SearchOptions->Visible()) { ?>
<?php $t02_rkas_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t02_rkas_list->FilterOptions->Visible()) { ?>
<?php $t02_rkas_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
if ($t02_rkas->CurrentAction == "gridadd") {
	$t02_rkas->CurrentFilter = "0=1";
	$t02_rkas_list->StartRec = 1;
	$t02_rkas_list->DisplayRecs = $t02_rkas->GridAddRowCount;
	$t02_rkas_list->TotalRecs = $t02_rkas_list->DisplayRecs;
	$t02_rkas_list->StopRec = $t02_rkas_list->DisplayRecs;
} else {
	$bSelectLimit = $t02_rkas_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t02_rkas_list->TotalRecs <= 0)
			$t02_rkas_list->TotalRecs = $t02_rkas->ListRecordCount();
	} else {
		if (!$t02_rkas_list->Recordset && ($t02_rkas_list->Recordset = $t02_rkas_list->LoadRecordset()))
			$t02_rkas_list->TotalRecs = $t02_rkas_list->Recordset->RecordCount();
	}
	$t02_rkas_list->StartRec = 1;
	if ($t02_rkas_list->DisplayRecs <= 0 || ($t02_rkas->Export <> "" && $t02_rkas->ExportAll)) // Display all records
		$t02_rkas_list->DisplayRecs = $t02_rkas_list->TotalRecs;
	if (!($t02_rkas->Export <> "" && $t02_rkas->ExportAll))
		$t02_rkas_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t02_rkas_list->Recordset = $t02_rkas_list->LoadRecordset($t02_rkas_list->StartRec-1, $t02_rkas_list->DisplayRecs);

	// Set no record found message
	if ($t02_rkas->CurrentAction == "" && $t02_rkas_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t02_rkas_list->setWarningMessage(ew_DeniedMsg());
		if ($t02_rkas_list->SearchWhere == "0=101")
			$t02_rkas_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t02_rkas_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($t02_rkas_list->AuditTrailOnSearch && $t02_rkas_list->Command == "search" && !$t02_rkas_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $t02_rkas_list->getSessionWhere();
		$t02_rkas_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$t02_rkas_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($t02_rkas->Export == "" && $t02_rkas->CurrentAction == "") { ?>
<form name="ft02_rkaslistsrch" id="ft02_rkaslistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t02_rkas_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft02_rkaslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t02_rkas">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($t02_rkas_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($t02_rkas_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $t02_rkas_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($t02_rkas_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($t02_rkas_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($t02_rkas_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($t02_rkas_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $t02_rkas_list->ShowPageHeader(); ?>
<?php
$t02_rkas_list->ShowMessage();
?>
<?php if ($t02_rkas_list->TotalRecs > 0 || $t02_rkas->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t02_rkas_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t02_rkas">
<?php if ($t02_rkas->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($t02_rkas->CurrentAction <> "gridadd" && $t02_rkas->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t02_rkas_list->Pager)) $t02_rkas_list->Pager = new cPrevNextPager($t02_rkas_list->StartRec, $t02_rkas_list->DisplayRecs, $t02_rkas_list->TotalRecs, $t02_rkas_list->AutoHidePager) ?>
<?php if ($t02_rkas_list->Pager->RecordCount > 0 && $t02_rkas_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t02_rkas_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t02_rkas_list->PageUrl() ?>start=<?php echo $t02_rkas_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t02_rkas_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t02_rkas_list->PageUrl() ?>start=<?php echo $t02_rkas_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t02_rkas_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t02_rkas_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t02_rkas_list->PageUrl() ?>start=<?php echo $t02_rkas_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t02_rkas_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t02_rkas_list->PageUrl() ?>start=<?php echo $t02_rkas_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t02_rkas_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t02_rkas_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t02_rkas_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t02_rkas_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t02_rkas_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t02_rkas_list->TotalRecs > 0 && (!$t02_rkas_list->AutoHidePageSizeSelector || $t02_rkas_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t02_rkas">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t02_rkas_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t02_rkas_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t02_rkas_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t02_rkas_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($t02_rkas->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t02_rkas_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ft02_rkaslist" id="ft02_rkaslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t02_rkas_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t02_rkas_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t02_rkas">
<div id="gmp_t02_rkas" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($t02_rkas_list->TotalRecs > 0 || $t02_rkas->CurrentAction == "add" || $t02_rkas->CurrentAction == "copy" || $t02_rkas->CurrentAction == "gridedit") { ?>
<table id="tbl_t02_rkaslist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t02_rkas_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t02_rkas_list->RenderListOptions();

// Render list options (header, left)
$t02_rkas_list->ListOptions->Render("header", "left");
?>
<?php if ($t02_rkas->lvl->Visible) { // lvl ?>
	<?php if ($t02_rkas->SortUrl($t02_rkas->lvl) == "") { ?>
		<th data-name="lvl" class="<?php echo $t02_rkas->lvl->HeaderCellClass() ?>"><div id="elh_t02_rkas_lvl" class="t02_rkas_lvl"><div class="ewTableHeaderCaption"><?php echo $t02_rkas->lvl->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lvl" class="<?php echo $t02_rkas->lvl->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_rkas->SortUrl($t02_rkas->lvl) ?>',2);"><div id="elh_t02_rkas_lvl" class="t02_rkas_lvl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_rkas->lvl->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_rkas->lvl->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_rkas->lvl->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_rkas->urutan->Visible) { // urutan ?>
	<?php if ($t02_rkas->SortUrl($t02_rkas->urutan) == "") { ?>
		<th data-name="urutan" class="<?php echo $t02_rkas->urutan->HeaderCellClass() ?>"><div id="elh_t02_rkas_urutan" class="t02_rkas_urutan"><div class="ewTableHeaderCaption"><?php echo $t02_rkas->urutan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="urutan" class="<?php echo $t02_rkas->urutan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_rkas->SortUrl($t02_rkas->urutan) ?>',2);"><div id="elh_t02_rkas_urutan" class="t02_rkas_urutan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_rkas->urutan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_rkas->urutan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_rkas->urutan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_rkas->nour1->Visible) { // nour1 ?>
	<?php if ($t02_rkas->SortUrl($t02_rkas->nour1) == "") { ?>
		<th data-name="nour1" class="<?php echo $t02_rkas->nour1->HeaderCellClass() ?>"><div id="elh_t02_rkas_nour1" class="t02_rkas_nour1"><div class="ewTableHeaderCaption"><?php echo $t02_rkas->nour1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nour1" class="<?php echo $t02_rkas->nour1->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_rkas->SortUrl($t02_rkas->nour1) ?>',2);"><div id="elh_t02_rkas_nour1" class="t02_rkas_nour1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_rkas->nour1->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_rkas->nour1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_rkas->nour1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_rkas->ket1->Visible) { // ket1 ?>
	<?php if ($t02_rkas->SortUrl($t02_rkas->ket1) == "") { ?>
		<th data-name="ket1" class="<?php echo $t02_rkas->ket1->HeaderCellClass() ?>"><div id="elh_t02_rkas_ket1" class="t02_rkas_ket1"><div class="ewTableHeaderCaption"><?php echo $t02_rkas->ket1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ket1" class="<?php echo $t02_rkas->ket1->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_rkas->SortUrl($t02_rkas->ket1) ?>',2);"><div id="elh_t02_rkas_ket1" class="t02_rkas_ket1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_rkas->ket1->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t02_rkas->ket1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_rkas->ket1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_rkas->jml1->Visible) { // jml1 ?>
	<?php if ($t02_rkas->SortUrl($t02_rkas->jml1) == "") { ?>
		<th data-name="jml1" class="<?php echo $t02_rkas->jml1->HeaderCellClass() ?>"><div id="elh_t02_rkas_jml1" class="t02_rkas_jml1"><div class="ewTableHeaderCaption"><?php echo $t02_rkas->jml1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jml1" class="<?php echo $t02_rkas->jml1->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_rkas->SortUrl($t02_rkas->jml1) ?>',2);"><div id="elh_t02_rkas_jml1" class="t02_rkas_jml1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_rkas->jml1->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_rkas->jml1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_rkas->jml1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_rkas->nour2->Visible) { // nour2 ?>
	<?php if ($t02_rkas->SortUrl($t02_rkas->nour2) == "") { ?>
		<th data-name="nour2" class="<?php echo $t02_rkas->nour2->HeaderCellClass() ?>"><div id="elh_t02_rkas_nour2" class="t02_rkas_nour2"><div class="ewTableHeaderCaption"><?php echo $t02_rkas->nour2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nour2" class="<?php echo $t02_rkas->nour2->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_rkas->SortUrl($t02_rkas->nour2) ?>',2);"><div id="elh_t02_rkas_nour2" class="t02_rkas_nour2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_rkas->nour2->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_rkas->nour2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_rkas->nour2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_rkas->ket2->Visible) { // ket2 ?>
	<?php if ($t02_rkas->SortUrl($t02_rkas->ket2) == "") { ?>
		<th data-name="ket2" class="<?php echo $t02_rkas->ket2->HeaderCellClass() ?>"><div id="elh_t02_rkas_ket2" class="t02_rkas_ket2"><div class="ewTableHeaderCaption"><?php echo $t02_rkas->ket2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ket2" class="<?php echo $t02_rkas->ket2->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_rkas->SortUrl($t02_rkas->ket2) ?>',2);"><div id="elh_t02_rkas_ket2" class="t02_rkas_ket2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_rkas->ket2->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t02_rkas->ket2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_rkas->ket2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t02_rkas->jml2->Visible) { // jml2 ?>
	<?php if ($t02_rkas->SortUrl($t02_rkas->jml2) == "") { ?>
		<th data-name="jml2" class="<?php echo $t02_rkas->jml2->HeaderCellClass() ?>"><div id="elh_t02_rkas_jml2" class="t02_rkas_jml2"><div class="ewTableHeaderCaption"><?php echo $t02_rkas->jml2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jml2" class="<?php echo $t02_rkas->jml2->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t02_rkas->SortUrl($t02_rkas->jml2) ?>',2);"><div id="elh_t02_rkas_jml2" class="t02_rkas_jml2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t02_rkas->jml2->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t02_rkas->jml2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t02_rkas->jml2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t02_rkas_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($t02_rkas->CurrentAction == "add" || $t02_rkas->CurrentAction == "copy") {
		$t02_rkas_list->RowIndex = 0;
		$t02_rkas_list->KeyCount = $t02_rkas_list->RowIndex;
		if ($t02_rkas->CurrentAction == "copy" && !$t02_rkas_list->LoadRow())
			$t02_rkas->CurrentAction = "add";
		if ($t02_rkas->CurrentAction == "add")
			$t02_rkas_list->LoadRowValues();
		if ($t02_rkas->EventCancelled) // Insert failed
			$t02_rkas_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$t02_rkas->ResetAttrs();
		$t02_rkas->RowAttrs = array_merge($t02_rkas->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_t02_rkas', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$t02_rkas->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t02_rkas_list->RenderRow();

		// Render list options
		$t02_rkas_list->RenderListOptions();
		$t02_rkas_list->StartRowCnt = 0;
?>
	<tr<?php echo $t02_rkas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t02_rkas_list->ListOptions->Render("body", "left", $t02_rkas_list->RowCnt);
?>
	<?php if ($t02_rkas->lvl->Visible) { // lvl ?>
		<td data-name="lvl">
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_lvl" class="form-group t02_rkas_lvl">
<input type="text" data-table="t02_rkas" data-field="x_lvl" name="x<?php echo $t02_rkas_list->RowIndex ?>_lvl" id="x<?php echo $t02_rkas_list->RowIndex ?>_lvl" size="1" placeholder="<?php echo ew_HtmlEncode($t02_rkas->lvl->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->lvl->EditValue ?>"<?php echo $t02_rkas->lvl->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_lvl" name="o<?php echo $t02_rkas_list->RowIndex ?>_lvl" id="o<?php echo $t02_rkas_list->RowIndex ?>_lvl" value="<?php echo ew_HtmlEncode($t02_rkas->lvl->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_rkas->urutan->Visible) { // urutan ?>
		<td data-name="urutan">
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_urutan" class="form-group t02_rkas_urutan">
<input type="text" data-table="t02_rkas" data-field="x_urutan" name="x<?php echo $t02_rkas_list->RowIndex ?>_urutan" id="x<?php echo $t02_rkas_list->RowIndex ?>_urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t02_rkas->urutan->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->urutan->EditValue ?>"<?php echo $t02_rkas->urutan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_urutan" name="o<?php echo $t02_rkas_list->RowIndex ?>_urutan" id="o<?php echo $t02_rkas_list->RowIndex ?>_urutan" value="<?php echo ew_HtmlEncode($t02_rkas->urutan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_rkas->nour1->Visible) { // nour1 ?>
		<td data-name="nour1">
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_nour1" class="form-group t02_rkas_nour1">
<input type="text" data-table="t02_rkas" data-field="x_nour1" name="x<?php echo $t02_rkas_list->RowIndex ?>_nour1" id="x<?php echo $t02_rkas_list->RowIndex ?>_nour1" size="3" placeholder="<?php echo ew_HtmlEncode($t02_rkas->nour1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->nour1->EditValue ?>"<?php echo $t02_rkas->nour1->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_nour1" name="o<?php echo $t02_rkas_list->RowIndex ?>_nour1" id="o<?php echo $t02_rkas_list->RowIndex ?>_nour1" value="<?php echo ew_HtmlEncode($t02_rkas->nour1->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_rkas->ket1->Visible) { // ket1 ?>
		<td data-name="ket1">
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_ket1" class="form-group t02_rkas_ket1">
<input type="text" data-table="t02_rkas" data-field="x_ket1" name="x<?php echo $t02_rkas_list->RowIndex ?>_ket1" id="x<?php echo $t02_rkas_list->RowIndex ?>_ket1" size="20" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_rkas->ket1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->ket1->EditValue ?>"<?php echo $t02_rkas->ket1->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_ket1" name="o<?php echo $t02_rkas_list->RowIndex ?>_ket1" id="o<?php echo $t02_rkas_list->RowIndex ?>_ket1" value="<?php echo ew_HtmlEncode($t02_rkas->ket1->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_rkas->jml1->Visible) { // jml1 ?>
		<td data-name="jml1">
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_jml1" class="form-group t02_rkas_jml1">
<input type="text" data-table="t02_rkas" data-field="x_jml1" name="x<?php echo $t02_rkas_list->RowIndex ?>_jml1" id="x<?php echo $t02_rkas_list->RowIndex ?>_jml1" size="10" placeholder="<?php echo ew_HtmlEncode($t02_rkas->jml1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->jml1->EditValue ?>"<?php echo $t02_rkas->jml1->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_jml1" name="o<?php echo $t02_rkas_list->RowIndex ?>_jml1" id="o<?php echo $t02_rkas_list->RowIndex ?>_jml1" value="<?php echo ew_HtmlEncode($t02_rkas->jml1->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_rkas->nour2->Visible) { // nour2 ?>
		<td data-name="nour2">
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_nour2" class="form-group t02_rkas_nour2">
<input type="text" data-table="t02_rkas" data-field="x_nour2" name="x<?php echo $t02_rkas_list->RowIndex ?>_nour2" id="x<?php echo $t02_rkas_list->RowIndex ?>_nour2" size="3" placeholder="<?php echo ew_HtmlEncode($t02_rkas->nour2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->nour2->EditValue ?>"<?php echo $t02_rkas->nour2->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_nour2" name="o<?php echo $t02_rkas_list->RowIndex ?>_nour2" id="o<?php echo $t02_rkas_list->RowIndex ?>_nour2" value="<?php echo ew_HtmlEncode($t02_rkas->nour2->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_rkas->ket2->Visible) { // ket2 ?>
		<td data-name="ket2">
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_ket2" class="form-group t02_rkas_ket2">
<input type="text" data-table="t02_rkas" data-field="x_ket2" name="x<?php echo $t02_rkas_list->RowIndex ?>_ket2" id="x<?php echo $t02_rkas_list->RowIndex ?>_ket2" size="20" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_rkas->ket2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->ket2->EditValue ?>"<?php echo $t02_rkas->ket2->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_ket2" name="o<?php echo $t02_rkas_list->RowIndex ?>_ket2" id="o<?php echo $t02_rkas_list->RowIndex ?>_ket2" value="<?php echo ew_HtmlEncode($t02_rkas->ket2->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_rkas->jml2->Visible) { // jml2 ?>
		<td data-name="jml2">
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_jml2" class="form-group t02_rkas_jml2">
<input type="text" data-table="t02_rkas" data-field="x_jml2" name="x<?php echo $t02_rkas_list->RowIndex ?>_jml2" id="x<?php echo $t02_rkas_list->RowIndex ?>_jml2" size="10" placeholder="<?php echo ew_HtmlEncode($t02_rkas->jml2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->jml2->EditValue ?>"<?php echo $t02_rkas->jml2->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_jml2" name="o<?php echo $t02_rkas_list->RowIndex ?>_jml2" id="o<?php echo $t02_rkas_list->RowIndex ?>_jml2" value="<?php echo ew_HtmlEncode($t02_rkas->jml2->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t02_rkas_list->ListOptions->Render("body", "right", $t02_rkas_list->RowCnt);
?>
<script type="text/javascript">
ft02_rkaslist.UpdateOpts(<?php echo $t02_rkas_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($t02_rkas->ExportAll && $t02_rkas->Export <> "") {
	$t02_rkas_list->StopRec = $t02_rkas_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t02_rkas_list->TotalRecs > $t02_rkas_list->StartRec + $t02_rkas_list->DisplayRecs - 1)
		$t02_rkas_list->StopRec = $t02_rkas_list->StartRec + $t02_rkas_list->DisplayRecs - 1;
	else
		$t02_rkas_list->StopRec = $t02_rkas_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t02_rkas_list->FormKeyCountName) && ($t02_rkas->CurrentAction == "gridadd" || $t02_rkas->CurrentAction == "gridedit" || $t02_rkas->CurrentAction == "F")) {
		$t02_rkas_list->KeyCount = $objForm->GetValue($t02_rkas_list->FormKeyCountName);
		$t02_rkas_list->StopRec = $t02_rkas_list->StartRec + $t02_rkas_list->KeyCount - 1;
	}
}
$t02_rkas_list->RecCnt = $t02_rkas_list->StartRec - 1;
if ($t02_rkas_list->Recordset && !$t02_rkas_list->Recordset->EOF) {
	$t02_rkas_list->Recordset->MoveFirst();
	$bSelectLimit = $t02_rkas_list->UseSelectLimit;
	if (!$bSelectLimit && $t02_rkas_list->StartRec > 1)
		$t02_rkas_list->Recordset->Move($t02_rkas_list->StartRec - 1);
} elseif (!$t02_rkas->AllowAddDeleteRow && $t02_rkas_list->StopRec == 0) {
	$t02_rkas_list->StopRec = $t02_rkas->GridAddRowCount;
}

// Initialize aggregate
$t02_rkas->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t02_rkas->ResetAttrs();
$t02_rkas_list->RenderRow();
$t02_rkas_list->EditRowCnt = 0;
if ($t02_rkas->CurrentAction == "edit")
	$t02_rkas_list->RowIndex = 1;
if ($t02_rkas->CurrentAction == "gridadd")
	$t02_rkas_list->RowIndex = 0;
if ($t02_rkas->CurrentAction == "gridedit")
	$t02_rkas_list->RowIndex = 0;
while ($t02_rkas_list->RecCnt < $t02_rkas_list->StopRec) {
	$t02_rkas_list->RecCnt++;
	if (intval($t02_rkas_list->RecCnt) >= intval($t02_rkas_list->StartRec)) {
		$t02_rkas_list->RowCnt++;
		if ($t02_rkas->CurrentAction == "gridadd" || $t02_rkas->CurrentAction == "gridedit" || $t02_rkas->CurrentAction == "F") {
			$t02_rkas_list->RowIndex++;
			$objForm->Index = $t02_rkas_list->RowIndex;
			if ($objForm->HasValue($t02_rkas_list->FormActionName))
				$t02_rkas_list->RowAction = strval($objForm->GetValue($t02_rkas_list->FormActionName));
			elseif ($t02_rkas->CurrentAction == "gridadd")
				$t02_rkas_list->RowAction = "insert";
			else
				$t02_rkas_list->RowAction = "";
		}

		// Set up key count
		$t02_rkas_list->KeyCount = $t02_rkas_list->RowIndex;

		// Init row class and style
		$t02_rkas->ResetAttrs();
		$t02_rkas->CssClass = "";
		if ($t02_rkas->CurrentAction == "gridadd") {
			$t02_rkas_list->LoadRowValues(); // Load default values
		} else {
			$t02_rkas_list->LoadRowValues($t02_rkas_list->Recordset); // Load row values
		}
		$t02_rkas->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t02_rkas->CurrentAction == "gridadd") // Grid add
			$t02_rkas->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t02_rkas->CurrentAction == "gridadd" && $t02_rkas->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t02_rkas_list->RestoreCurrentRowFormValues($t02_rkas_list->RowIndex); // Restore form values
		if ($t02_rkas->CurrentAction == "edit") {
			if ($t02_rkas_list->CheckInlineEditKey() && $t02_rkas_list->EditRowCnt == 0) { // Inline edit
				$t02_rkas->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($t02_rkas->CurrentAction == "gridedit") { // Grid edit
			if ($t02_rkas->EventCancelled) {
				$t02_rkas_list->RestoreCurrentRowFormValues($t02_rkas_list->RowIndex); // Restore form values
			}
			if ($t02_rkas_list->RowAction == "insert")
				$t02_rkas->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t02_rkas->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t02_rkas->CurrentAction == "edit" && $t02_rkas->RowType == EW_ROWTYPE_EDIT && $t02_rkas->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$t02_rkas_list->RestoreFormValues(); // Restore form values
		}
		if ($t02_rkas->CurrentAction == "gridedit" && ($t02_rkas->RowType == EW_ROWTYPE_EDIT || $t02_rkas->RowType == EW_ROWTYPE_ADD) && $t02_rkas->EventCancelled) // Update failed
			$t02_rkas_list->RestoreCurrentRowFormValues($t02_rkas_list->RowIndex); // Restore form values
		if ($t02_rkas->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t02_rkas_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$t02_rkas->RowAttrs = array_merge($t02_rkas->RowAttrs, array('data-rowindex'=>$t02_rkas_list->RowCnt, 'id'=>'r' . $t02_rkas_list->RowCnt . '_t02_rkas', 'data-rowtype'=>$t02_rkas->RowType));

		// Render row
		$t02_rkas_list->RenderRow();

		// Render list options
		$t02_rkas_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t02_rkas_list->RowAction <> "delete" && $t02_rkas_list->RowAction <> "insertdelete" && !($t02_rkas_list->RowAction == "insert" && $t02_rkas->CurrentAction == "F" && $t02_rkas_list->EmptyRow())) {
?>
	<tr<?php echo $t02_rkas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t02_rkas_list->ListOptions->Render("body", "left", $t02_rkas_list->RowCnt);
?>
	<?php if ($t02_rkas->lvl->Visible) { // lvl ?>
		<td data-name="lvl"<?php echo $t02_rkas->lvl->CellAttributes() ?>>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_lvl" class="form-group t02_rkas_lvl">
<input type="text" data-table="t02_rkas" data-field="x_lvl" name="x<?php echo $t02_rkas_list->RowIndex ?>_lvl" id="x<?php echo $t02_rkas_list->RowIndex ?>_lvl" size="1" placeholder="<?php echo ew_HtmlEncode($t02_rkas->lvl->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->lvl->EditValue ?>"<?php echo $t02_rkas->lvl->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_lvl" name="o<?php echo $t02_rkas_list->RowIndex ?>_lvl" id="o<?php echo $t02_rkas_list->RowIndex ?>_lvl" value="<?php echo ew_HtmlEncode($t02_rkas->lvl->OldValue) ?>">
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_lvl" class="form-group t02_rkas_lvl">
<input type="text" data-table="t02_rkas" data-field="x_lvl" name="x<?php echo $t02_rkas_list->RowIndex ?>_lvl" id="x<?php echo $t02_rkas_list->RowIndex ?>_lvl" size="1" placeholder="<?php echo ew_HtmlEncode($t02_rkas->lvl->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->lvl->EditValue ?>"<?php echo $t02_rkas->lvl->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_lvl" class="t02_rkas_lvl">
<span<?php echo $t02_rkas->lvl->ViewAttributes() ?>>
<?php echo $t02_rkas->lvl->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t02_rkas" data-field="x_id" name="x<?php echo $t02_rkas_list->RowIndex ?>_id" id="x<?php echo $t02_rkas_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_rkas->id->CurrentValue) ?>">
<input type="hidden" data-table="t02_rkas" data-field="x_id" name="o<?php echo $t02_rkas_list->RowIndex ?>_id" id="o<?php echo $t02_rkas_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_rkas->id->OldValue) ?>">
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_EDIT || $t02_rkas->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t02_rkas" data-field="x_id" name="x<?php echo $t02_rkas_list->RowIndex ?>_id" id="x<?php echo $t02_rkas_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t02_rkas->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t02_rkas->urutan->Visible) { // urutan ?>
		<td data-name="urutan"<?php echo $t02_rkas->urutan->CellAttributes() ?>>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_urutan" class="form-group t02_rkas_urutan">
<input type="text" data-table="t02_rkas" data-field="x_urutan" name="x<?php echo $t02_rkas_list->RowIndex ?>_urutan" id="x<?php echo $t02_rkas_list->RowIndex ?>_urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t02_rkas->urutan->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->urutan->EditValue ?>"<?php echo $t02_rkas->urutan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_urutan" name="o<?php echo $t02_rkas_list->RowIndex ?>_urutan" id="o<?php echo $t02_rkas_list->RowIndex ?>_urutan" value="<?php echo ew_HtmlEncode($t02_rkas->urutan->OldValue) ?>">
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_urutan" class="form-group t02_rkas_urutan">
<input type="text" data-table="t02_rkas" data-field="x_urutan" name="x<?php echo $t02_rkas_list->RowIndex ?>_urutan" id="x<?php echo $t02_rkas_list->RowIndex ?>_urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t02_rkas->urutan->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->urutan->EditValue ?>"<?php echo $t02_rkas->urutan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_urutan" class="t02_rkas_urutan">
<span<?php echo $t02_rkas->urutan->ViewAttributes() ?>>
<?php echo $t02_rkas->urutan->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_rkas->nour1->Visible) { // nour1 ?>
		<td data-name="nour1"<?php echo $t02_rkas->nour1->CellAttributes() ?>>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_nour1" class="form-group t02_rkas_nour1">
<input type="text" data-table="t02_rkas" data-field="x_nour1" name="x<?php echo $t02_rkas_list->RowIndex ?>_nour1" id="x<?php echo $t02_rkas_list->RowIndex ?>_nour1" size="3" placeholder="<?php echo ew_HtmlEncode($t02_rkas->nour1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->nour1->EditValue ?>"<?php echo $t02_rkas->nour1->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_nour1" name="o<?php echo $t02_rkas_list->RowIndex ?>_nour1" id="o<?php echo $t02_rkas_list->RowIndex ?>_nour1" value="<?php echo ew_HtmlEncode($t02_rkas->nour1->OldValue) ?>">
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_nour1" class="form-group t02_rkas_nour1">
<input type="text" data-table="t02_rkas" data-field="x_nour1" name="x<?php echo $t02_rkas_list->RowIndex ?>_nour1" id="x<?php echo $t02_rkas_list->RowIndex ?>_nour1" size="3" placeholder="<?php echo ew_HtmlEncode($t02_rkas->nour1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->nour1->EditValue ?>"<?php echo $t02_rkas->nour1->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_nour1" class="t02_rkas_nour1">
<span<?php echo $t02_rkas->nour1->ViewAttributes() ?>>
<?php echo $t02_rkas->nour1->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_rkas->ket1->Visible) { // ket1 ?>
		<td data-name="ket1"<?php echo $t02_rkas->ket1->CellAttributes() ?>>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_ket1" class="form-group t02_rkas_ket1">
<input type="text" data-table="t02_rkas" data-field="x_ket1" name="x<?php echo $t02_rkas_list->RowIndex ?>_ket1" id="x<?php echo $t02_rkas_list->RowIndex ?>_ket1" size="20" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_rkas->ket1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->ket1->EditValue ?>"<?php echo $t02_rkas->ket1->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_ket1" name="o<?php echo $t02_rkas_list->RowIndex ?>_ket1" id="o<?php echo $t02_rkas_list->RowIndex ?>_ket1" value="<?php echo ew_HtmlEncode($t02_rkas->ket1->OldValue) ?>">
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_ket1" class="form-group t02_rkas_ket1">
<input type="text" data-table="t02_rkas" data-field="x_ket1" name="x<?php echo $t02_rkas_list->RowIndex ?>_ket1" id="x<?php echo $t02_rkas_list->RowIndex ?>_ket1" size="20" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_rkas->ket1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->ket1->EditValue ?>"<?php echo $t02_rkas->ket1->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_ket1" class="t02_rkas_ket1">
<span<?php echo $t02_rkas->ket1->ViewAttributes() ?>>
<?php echo $t02_rkas->ket1->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_rkas->jml1->Visible) { // jml1 ?>
		<td data-name="jml1"<?php echo $t02_rkas->jml1->CellAttributes() ?>>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_jml1" class="form-group t02_rkas_jml1">
<input type="text" data-table="t02_rkas" data-field="x_jml1" name="x<?php echo $t02_rkas_list->RowIndex ?>_jml1" id="x<?php echo $t02_rkas_list->RowIndex ?>_jml1" size="10" placeholder="<?php echo ew_HtmlEncode($t02_rkas->jml1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->jml1->EditValue ?>"<?php echo $t02_rkas->jml1->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_jml1" name="o<?php echo $t02_rkas_list->RowIndex ?>_jml1" id="o<?php echo $t02_rkas_list->RowIndex ?>_jml1" value="<?php echo ew_HtmlEncode($t02_rkas->jml1->OldValue) ?>">
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_jml1" class="form-group t02_rkas_jml1">
<input type="text" data-table="t02_rkas" data-field="x_jml1" name="x<?php echo $t02_rkas_list->RowIndex ?>_jml1" id="x<?php echo $t02_rkas_list->RowIndex ?>_jml1" size="10" placeholder="<?php echo ew_HtmlEncode($t02_rkas->jml1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->jml1->EditValue ?>"<?php echo $t02_rkas->jml1->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_jml1" class="t02_rkas_jml1">
<span<?php echo $t02_rkas->jml1->ViewAttributes() ?>>
<?php echo $t02_rkas->jml1->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_rkas->nour2->Visible) { // nour2 ?>
		<td data-name="nour2"<?php echo $t02_rkas->nour2->CellAttributes() ?>>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_nour2" class="form-group t02_rkas_nour2">
<input type="text" data-table="t02_rkas" data-field="x_nour2" name="x<?php echo $t02_rkas_list->RowIndex ?>_nour2" id="x<?php echo $t02_rkas_list->RowIndex ?>_nour2" size="3" placeholder="<?php echo ew_HtmlEncode($t02_rkas->nour2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->nour2->EditValue ?>"<?php echo $t02_rkas->nour2->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_nour2" name="o<?php echo $t02_rkas_list->RowIndex ?>_nour2" id="o<?php echo $t02_rkas_list->RowIndex ?>_nour2" value="<?php echo ew_HtmlEncode($t02_rkas->nour2->OldValue) ?>">
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_nour2" class="form-group t02_rkas_nour2">
<input type="text" data-table="t02_rkas" data-field="x_nour2" name="x<?php echo $t02_rkas_list->RowIndex ?>_nour2" id="x<?php echo $t02_rkas_list->RowIndex ?>_nour2" size="3" placeholder="<?php echo ew_HtmlEncode($t02_rkas->nour2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->nour2->EditValue ?>"<?php echo $t02_rkas->nour2->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_nour2" class="t02_rkas_nour2">
<span<?php echo $t02_rkas->nour2->ViewAttributes() ?>>
<?php echo $t02_rkas->nour2->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_rkas->ket2->Visible) { // ket2 ?>
		<td data-name="ket2"<?php echo $t02_rkas->ket2->CellAttributes() ?>>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_ket2" class="form-group t02_rkas_ket2">
<input type="text" data-table="t02_rkas" data-field="x_ket2" name="x<?php echo $t02_rkas_list->RowIndex ?>_ket2" id="x<?php echo $t02_rkas_list->RowIndex ?>_ket2" size="20" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_rkas->ket2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->ket2->EditValue ?>"<?php echo $t02_rkas->ket2->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_ket2" name="o<?php echo $t02_rkas_list->RowIndex ?>_ket2" id="o<?php echo $t02_rkas_list->RowIndex ?>_ket2" value="<?php echo ew_HtmlEncode($t02_rkas->ket2->OldValue) ?>">
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_ket2" class="form-group t02_rkas_ket2">
<input type="text" data-table="t02_rkas" data-field="x_ket2" name="x<?php echo $t02_rkas_list->RowIndex ?>_ket2" id="x<?php echo $t02_rkas_list->RowIndex ?>_ket2" size="20" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_rkas->ket2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->ket2->EditValue ?>"<?php echo $t02_rkas->ket2->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_ket2" class="t02_rkas_ket2">
<span<?php echo $t02_rkas->ket2->ViewAttributes() ?>>
<?php echo $t02_rkas->ket2->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t02_rkas->jml2->Visible) { // jml2 ?>
		<td data-name="jml2"<?php echo $t02_rkas->jml2->CellAttributes() ?>>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_jml2" class="form-group t02_rkas_jml2">
<input type="text" data-table="t02_rkas" data-field="x_jml2" name="x<?php echo $t02_rkas_list->RowIndex ?>_jml2" id="x<?php echo $t02_rkas_list->RowIndex ?>_jml2" size="10" placeholder="<?php echo ew_HtmlEncode($t02_rkas->jml2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->jml2->EditValue ?>"<?php echo $t02_rkas->jml2->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_jml2" name="o<?php echo $t02_rkas_list->RowIndex ?>_jml2" id="o<?php echo $t02_rkas_list->RowIndex ?>_jml2" value="<?php echo ew_HtmlEncode($t02_rkas->jml2->OldValue) ?>">
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_jml2" class="form-group t02_rkas_jml2">
<input type="text" data-table="t02_rkas" data-field="x_jml2" name="x<?php echo $t02_rkas_list->RowIndex ?>_jml2" id="x<?php echo $t02_rkas_list->RowIndex ?>_jml2" size="10" placeholder="<?php echo ew_HtmlEncode($t02_rkas->jml2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->jml2->EditValue ?>"<?php echo $t02_rkas->jml2->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t02_rkas_list->RowCnt ?>_t02_rkas_jml2" class="t02_rkas_jml2">
<span<?php echo $t02_rkas->jml2->ViewAttributes() ?>>
<?php echo $t02_rkas->jml2->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t02_rkas_list->ListOptions->Render("body", "right", $t02_rkas_list->RowCnt);
?>
	</tr>
<?php if ($t02_rkas->RowType == EW_ROWTYPE_ADD || $t02_rkas->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft02_rkaslist.UpdateOpts(<?php echo $t02_rkas_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t02_rkas->CurrentAction <> "gridadd")
		if (!$t02_rkas_list->Recordset->EOF) $t02_rkas_list->Recordset->MoveNext();
}
?>
<?php
	if ($t02_rkas->CurrentAction == "gridadd" || $t02_rkas->CurrentAction == "gridedit") {
		$t02_rkas_list->RowIndex = '$rowindex$';
		$t02_rkas_list->LoadRowValues();

		// Set row properties
		$t02_rkas->ResetAttrs();
		$t02_rkas->RowAttrs = array_merge($t02_rkas->RowAttrs, array('data-rowindex'=>$t02_rkas_list->RowIndex, 'id'=>'r0_t02_rkas', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t02_rkas->RowAttrs["class"], "ewTemplate");
		$t02_rkas->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t02_rkas_list->RenderRow();

		// Render list options
		$t02_rkas_list->RenderListOptions();
		$t02_rkas_list->StartRowCnt = 0;
?>
	<tr<?php echo $t02_rkas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t02_rkas_list->ListOptions->Render("body", "left", $t02_rkas_list->RowIndex);
?>
	<?php if ($t02_rkas->lvl->Visible) { // lvl ?>
		<td data-name="lvl">
<span id="el$rowindex$_t02_rkas_lvl" class="form-group t02_rkas_lvl">
<input type="text" data-table="t02_rkas" data-field="x_lvl" name="x<?php echo $t02_rkas_list->RowIndex ?>_lvl" id="x<?php echo $t02_rkas_list->RowIndex ?>_lvl" size="1" placeholder="<?php echo ew_HtmlEncode($t02_rkas->lvl->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->lvl->EditValue ?>"<?php echo $t02_rkas->lvl->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_lvl" name="o<?php echo $t02_rkas_list->RowIndex ?>_lvl" id="o<?php echo $t02_rkas_list->RowIndex ?>_lvl" value="<?php echo ew_HtmlEncode($t02_rkas->lvl->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_rkas->urutan->Visible) { // urutan ?>
		<td data-name="urutan">
<span id="el$rowindex$_t02_rkas_urutan" class="form-group t02_rkas_urutan">
<input type="text" data-table="t02_rkas" data-field="x_urutan" name="x<?php echo $t02_rkas_list->RowIndex ?>_urutan" id="x<?php echo $t02_rkas_list->RowIndex ?>_urutan" size="1" placeholder="<?php echo ew_HtmlEncode($t02_rkas->urutan->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->urutan->EditValue ?>"<?php echo $t02_rkas->urutan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_urutan" name="o<?php echo $t02_rkas_list->RowIndex ?>_urutan" id="o<?php echo $t02_rkas_list->RowIndex ?>_urutan" value="<?php echo ew_HtmlEncode($t02_rkas->urutan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_rkas->nour1->Visible) { // nour1 ?>
		<td data-name="nour1">
<span id="el$rowindex$_t02_rkas_nour1" class="form-group t02_rkas_nour1">
<input type="text" data-table="t02_rkas" data-field="x_nour1" name="x<?php echo $t02_rkas_list->RowIndex ?>_nour1" id="x<?php echo $t02_rkas_list->RowIndex ?>_nour1" size="3" placeholder="<?php echo ew_HtmlEncode($t02_rkas->nour1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->nour1->EditValue ?>"<?php echo $t02_rkas->nour1->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_nour1" name="o<?php echo $t02_rkas_list->RowIndex ?>_nour1" id="o<?php echo $t02_rkas_list->RowIndex ?>_nour1" value="<?php echo ew_HtmlEncode($t02_rkas->nour1->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_rkas->ket1->Visible) { // ket1 ?>
		<td data-name="ket1">
<span id="el$rowindex$_t02_rkas_ket1" class="form-group t02_rkas_ket1">
<input type="text" data-table="t02_rkas" data-field="x_ket1" name="x<?php echo $t02_rkas_list->RowIndex ?>_ket1" id="x<?php echo $t02_rkas_list->RowIndex ?>_ket1" size="20" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_rkas->ket1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->ket1->EditValue ?>"<?php echo $t02_rkas->ket1->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_ket1" name="o<?php echo $t02_rkas_list->RowIndex ?>_ket1" id="o<?php echo $t02_rkas_list->RowIndex ?>_ket1" value="<?php echo ew_HtmlEncode($t02_rkas->ket1->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_rkas->jml1->Visible) { // jml1 ?>
		<td data-name="jml1">
<span id="el$rowindex$_t02_rkas_jml1" class="form-group t02_rkas_jml1">
<input type="text" data-table="t02_rkas" data-field="x_jml1" name="x<?php echo $t02_rkas_list->RowIndex ?>_jml1" id="x<?php echo $t02_rkas_list->RowIndex ?>_jml1" size="10" placeholder="<?php echo ew_HtmlEncode($t02_rkas->jml1->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->jml1->EditValue ?>"<?php echo $t02_rkas->jml1->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_jml1" name="o<?php echo $t02_rkas_list->RowIndex ?>_jml1" id="o<?php echo $t02_rkas_list->RowIndex ?>_jml1" value="<?php echo ew_HtmlEncode($t02_rkas->jml1->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_rkas->nour2->Visible) { // nour2 ?>
		<td data-name="nour2">
<span id="el$rowindex$_t02_rkas_nour2" class="form-group t02_rkas_nour2">
<input type="text" data-table="t02_rkas" data-field="x_nour2" name="x<?php echo $t02_rkas_list->RowIndex ?>_nour2" id="x<?php echo $t02_rkas_list->RowIndex ?>_nour2" size="3" placeholder="<?php echo ew_HtmlEncode($t02_rkas->nour2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->nour2->EditValue ?>"<?php echo $t02_rkas->nour2->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_nour2" name="o<?php echo $t02_rkas_list->RowIndex ?>_nour2" id="o<?php echo $t02_rkas_list->RowIndex ?>_nour2" value="<?php echo ew_HtmlEncode($t02_rkas->nour2->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_rkas->ket2->Visible) { // ket2 ?>
		<td data-name="ket2">
<span id="el$rowindex$_t02_rkas_ket2" class="form-group t02_rkas_ket2">
<input type="text" data-table="t02_rkas" data-field="x_ket2" name="x<?php echo $t02_rkas_list->RowIndex ?>_ket2" id="x<?php echo $t02_rkas_list->RowIndex ?>_ket2" size="20" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t02_rkas->ket2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->ket2->EditValue ?>"<?php echo $t02_rkas->ket2->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_ket2" name="o<?php echo $t02_rkas_list->RowIndex ?>_ket2" id="o<?php echo $t02_rkas_list->RowIndex ?>_ket2" value="<?php echo ew_HtmlEncode($t02_rkas->ket2->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t02_rkas->jml2->Visible) { // jml2 ?>
		<td data-name="jml2">
<span id="el$rowindex$_t02_rkas_jml2" class="form-group t02_rkas_jml2">
<input type="text" data-table="t02_rkas" data-field="x_jml2" name="x<?php echo $t02_rkas_list->RowIndex ?>_jml2" id="x<?php echo $t02_rkas_list->RowIndex ?>_jml2" size="10" placeholder="<?php echo ew_HtmlEncode($t02_rkas->jml2->getPlaceHolder()) ?>" value="<?php echo $t02_rkas->jml2->EditValue ?>"<?php echo $t02_rkas->jml2->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t02_rkas" data-field="x_jml2" name="o<?php echo $t02_rkas_list->RowIndex ?>_jml2" id="o<?php echo $t02_rkas_list->RowIndex ?>_jml2" value="<?php echo ew_HtmlEncode($t02_rkas->jml2->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t02_rkas_list->ListOptions->Render("body", "right", $t02_rkas_list->RowIndex);
?>
<script type="text/javascript">
ft02_rkaslist.UpdateOpts(<?php echo $t02_rkas_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t02_rkas->CurrentAction == "add" || $t02_rkas->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $t02_rkas_list->FormKeyCountName ?>" id="<?php echo $t02_rkas_list->FormKeyCountName ?>" value="<?php echo $t02_rkas_list->KeyCount ?>">
<?php } ?>
<?php if ($t02_rkas->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t02_rkas_list->FormKeyCountName ?>" id="<?php echo $t02_rkas_list->FormKeyCountName ?>" value="<?php echo $t02_rkas_list->KeyCount ?>">
<?php echo $t02_rkas_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t02_rkas->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $t02_rkas_list->FormKeyCountName ?>" id="<?php echo $t02_rkas_list->FormKeyCountName ?>" value="<?php echo $t02_rkas_list->KeyCount ?>">
<?php } ?>
<?php if ($t02_rkas->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t02_rkas_list->FormKeyCountName ?>" id="<?php echo $t02_rkas_list->FormKeyCountName ?>" value="<?php echo $t02_rkas_list->KeyCount ?>">
<?php echo $t02_rkas_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t02_rkas->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t02_rkas_list->Recordset)
	$t02_rkas_list->Recordset->Close();
?>
<?php if ($t02_rkas->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($t02_rkas->CurrentAction <> "gridadd" && $t02_rkas->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t02_rkas_list->Pager)) $t02_rkas_list->Pager = new cPrevNextPager($t02_rkas_list->StartRec, $t02_rkas_list->DisplayRecs, $t02_rkas_list->TotalRecs, $t02_rkas_list->AutoHidePager) ?>
<?php if ($t02_rkas_list->Pager->RecordCount > 0 && $t02_rkas_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t02_rkas_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t02_rkas_list->PageUrl() ?>start=<?php echo $t02_rkas_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t02_rkas_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t02_rkas_list->PageUrl() ?>start=<?php echo $t02_rkas_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t02_rkas_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t02_rkas_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t02_rkas_list->PageUrl() ?>start=<?php echo $t02_rkas_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t02_rkas_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t02_rkas_list->PageUrl() ?>start=<?php echo $t02_rkas_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t02_rkas_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t02_rkas_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t02_rkas_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t02_rkas_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t02_rkas_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t02_rkas_list->TotalRecs > 0 && (!$t02_rkas_list->AutoHidePageSizeSelector || $t02_rkas_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t02_rkas">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($t02_rkas_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t02_rkas_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t02_rkas_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t02_rkas_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($t02_rkas->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t02_rkas_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($t02_rkas_list->TotalRecs == 0 && $t02_rkas->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t02_rkas_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t02_rkas->Export == "") { ?>
<script type="text/javascript">
ft02_rkaslistsrch.FilterList = <?php echo $t02_rkas_list->GetFilterList() ?>;
ft02_rkaslistsrch.Init();
ft02_rkaslist.Init();
</script>
<?php } ?>
<?php
$t02_rkas_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($t02_rkas->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$t02_rkas_list->Page_Terminate();
?>
