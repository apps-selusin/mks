<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php $EW_ROOT_RELATIVE_PATH = ""; ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cf02_input_rkas_php = NULL; // Initialize page object first

class ccf02_input_rkas_php {

	// Page ID
	var $PageID = 'custom';

	// Project ID
	var $ProjectID = '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}';

	// Table name
	var $TableName = 'cf02_input_rkas.php';

	// Page object name
	var $PageObjName = 'cf02_input_rkas_php';

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
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
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

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'custom', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cf02_input_rkas.php', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect();

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
		if (!$Security->CanReport()) {
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

		if (@$_GET["export"] <> "")
			$gsExport = $_GET["export"]; // Get export parameter, used in header

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

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

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
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

	//
	// Page main
	//
	function Page_Main() {

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("custom", "cf02_input_rkas_php", $url, "", "cf02_input_rkas_php", TRUE);
		$this->Heading = $Language->TablePhrase("cf02_input_rkas_php", "TblCaption"); 
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cf02_input_rkas_php)) $cf02_input_rkas_php = new ccf02_input_rkas_php();

// Page init
$cf02_input_rkas_php->Page_Init();

// Page main
$cf02_input_rkas_php->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();
?>
<?php include_once "header.php" ?>
<!--<form name="form01" method="post" action="cf02_input_rkas02.php">
	<div>Mohon klik tombol Proses di bawah ini untuk melanjutkan proses input data RKAS</div>
	<input type="submit" value="Proses">
</form>-->
<?php
$db =& DbHelper();

// kosongkan tabel temporary
$q0 = "truncate t94_rkas1;";
$db->Execute($q0);
$q0 = "truncate t95_rkas2;";
$db->Execute($q0);

// ambil data level 1
$q1 = "select * from t02_rkas01 order by no_urut";
$rs1 = $db->Execute($q1);

while (!$rs1->EOF) { // looping data level 1

	//echo "<tr><td>".$rs1->fields["no_urut"].".</td><td colspan='4'>".$rs1->fields["keterangan"]."</td><td>".$rs1->fields["jumlah"]."</td><td>01000000</td><td>1</td></tr>";
	
	// pilih tabel sumber dana = 1; dan penggunaan = 2
	if ($rs1->fields["no_urut"] == 1) {
		$nama_tabel = "t94_rkas1";
	}
	else {
		$nama_tabel = "t95_rkas2";
	}
	
	// simpan data level 1 ke tabel temporary
	$q0 = "insert into ".$nama_tabel." values (
		null
		, '".$rs1->fields["no_urut"].".'
		, '".$rs1->fields["keterangan"]."'
		, ".$rs1->fields["jumlah"]."
		, '01000000'
		, '1'
		, 't02_rkas01'
		, ".$rs1->fields["id"]."
		)"; //echo $q0;
	$db->Execute($q0);

	// simpan id level 1
	$lv1_id = $rs1->fields["id"];
	
	// ambil data level 2 berdasarkan id level 1
	$q2 = "select * from t03_rkas02 where lv1_id = ".$lv1_id." order by no_urut";
	$rs2 = $db->Execute($q2);
	
	// simpan nomor keyfield
	$lv2_index = 0;
	while (!$rs2->EOF) { // looping data level 2
		
		//echo "<tr><td>&nbsp;</td><td>".$rs1->fields["no_urut"].".".$rs2->fields["no_urut"].".</td><td colspan='3'>".$rs2->fields["keterangan"]."</td><td>".$rs2->fields["jumlah"]."</td><td>01".substr("00".++$lv2_index, -2)."0000</td><td>2</td></tr>";
		
		// simpan data level 2 ke tabel temporary
		$q0 = "insert into ".$nama_tabel." values (
			null
			, '".$rs1->fields["no_urut"].".".$rs2->fields["no_urut"].".'
			, '".$rs2->fields["keterangan"]."'
			, ".$rs2->fields["jumlah"]."
			, '01".substr("00".++$lv2_index, -2)."0000'
			, '2'
			, 't03_rkas02'
			, ".$rs2->fields["id"]."
			)";
		$db->Execute($q0);
		
		// simpan id level 2
		$lv2_id = $rs2->fields["id"];
		
		// ambil data level 3 berdasarkan id level 2
		$q3 = "select * from t04_rkas03 where lv2_id = ".$lv2_id." order by no_urut";
		$rs3 = $db->Execute($q3);
		
		// simpan nomor keyfield
		$lv3_index = 0;
		while (!$rs3->EOF) { // looping data level 3
		
			//echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>".$rs1->fields["no_urut"].".".$rs2->fields["no_urut"].".".$rs3->fields["no_urut"].".</td><td colspan='2'>".$rs3->fields["keterangan"]."</td><td>".$rs3->fields["jumlah"]."</td><td>01".substr("00".$lv2_index, -2).substr("00".++$lv3_index, -2)."00</td><td>3</td></tr>";
			
			// simpan data level 3 ke tabel temporary
			$q0 = "insert into ".$nama_tabel." values (
				null
				, '".$rs1->fields["no_urut"].".".$rs2->fields["no_urut"].".".$rs3->fields["no_urut"].".'
				, '".$rs3->fields["keterangan"]."'
				, ".$rs3->fields["jumlah"]."
				, '01".substr("00".$lv2_index, -2).substr("00".++$lv3_index, -2)."00'
				, '3'
				, 't04_rkas03'
				, ".$rs3->fields["id"]."
				)";
			$db->Execute($q0);
			
			// simpan id level 3
			$lv3_id = $rs3->fields["id"];
			
			// ambil data level 4 berdasarkan id level 3
			$q4 = "select * from t05_rkas04 where lv3_id = ".$lv3_id." order by no_urut";
			$rs4 = $db->Execute($q4);
			
			// simpan nomor keyfield
			$lv4_index = 0;
			while (!$rs4->EOF) { // looping data level 4
			
				//echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>".$rs1->fields["no_urut"].".".$rs2->fields["no_urut"].".".$rs3->fields["no_urut"].".".$rs4->fields["no_urut"].".</td><td>".$rs4->fields["keterangan"]."</td><td>".$rs4->fields["jumlah"]."</td><td>01".substr("00".$lv2_index, -2).substr("00".$lv3_index, -2).substr("00".++$lv4_index, -2)."</td><td>4</td></tr>";
				
				// simpan data level 4 ke tabel temporary
				$q0 = "insert into ".$nama_tabel." values (
					null
					, '".$rs1->fields["no_urut"].".".$rs2->fields["no_urut"].".".$rs3->fields["no_urut"].".".$rs4->fields["no_urut"].".'
					, '".$rs4->fields["keterangan"]."'
					, ".$rs4->fields["jumlah"]."
					, '01".substr("00".$lv2_index, -2).substr("00".$lv3_index, -2).substr("00".++$lv4_index, -2)."'
					, '4'
					, 't05_rkas04'
					, ".$rs4->fields["id"]."
					)";
				$db->Execute($q0);
				$rs4->MoveNext();
			}
			$rs3->MoveNext();
		}
		$rs2->MoveNext();
	}
	$rs1->MoveNext();
}
?>
<table border="1">
<?php
$q1 = "select * from t94_rkas1";
$rs1 = $db->Execute($q1);
$q2 = "select * from t95_rkas2";
$rs2 = $db->Execute($q2);
if ($rs1->RecordCount() >= $rs2->RecordCount()) {
	//lebih banyak kiri atau sama dengan
}
else {
	//lebih banyak kanan
	while (!$rs2->EOF) {
		$q1 = "select * from t94_rkas1 where no_keyfield = '".$rs2->fields["no_keyfield"]."'";
		$rs1 = $db->Execute($q1);
		if (!$rs1->EOF) {
			// data ada
			if ($rs1->fields["no_level"] == 1) echo "
				<tr>
					<td>".$rs1->fields["no_urut"]."</td>
					<td colspan='7'>".$rs1->fields["keterangan"]."</td>
					<td><a href='./".$rs1->fields["nama_tabel"]."edit.php?id=".$rs1->fields["id_data"]."'>".$rs1->fields["jumlah"]."</a></td><td>&nbsp;</td>";
			if ($rs1->fields["no_level"] == 2) echo "
				<tr>
					<td>&nbsp;</td><td>".$rs1->fields["no_urut"]."</td>
					<td colspan='5'>".$rs1->fields["keterangan"]."</td>
					<td><a href='./".$rs1->fields["nama_tabel"]."edit.php?id=".$rs1->fields["id_data"]."'>".$rs1->fields["jumlah"]."</a></td>
					<td>&nbsp;</td><td>&nbsp;</td>";
			if ($rs1->fields["no_level"] == 3) echo "
				<tr>
					<td>&nbsp;</td><td>&nbsp;</td><td>".$rs1->fields["no_urut"]."</td>
					<td colspan='3'>".$rs1->fields["keterangan"]."</td>
					<td><a href='./".$rs1->fields["nama_tabel"]."edit.php?id=".$rs1->fields["id_data"]."'>".$rs1->fields["jumlah"]."</a></td>
					<td colspan='2'>&nbsp;</td><td>&nbsp;</td>";
			if ($rs1->fields["no_level"] == 4) echo "
				<tr>
					<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>".$rs1->fields["no_urut"]."</td>
					<td>".$rs1->fields["keterangan"]."</td>
					<td><a href='./".$rs1->fields["nama_tabel"]."edit.php?id=".$rs1->fields["id_data"]."'>".$rs1->fields["jumlah"]."</a></td>
					<td colspan='3'>&nbsp;</td><td>&nbsp;</td>";
		}
		else {
			echo "<tr><td colspan='9'>&nbsp;</td><td>&nbsp;</td>";
			// data tidak ada
		}
		if ($rs2->fields["no_level"] == 1) echo "
			<td>".$rs2->fields["no_urut"]."</td>
			<td colspan='7'>".$rs2->fields["keterangan"]."</td>
			<td><a href='./".$rs2->fields["nama_tabel"]."edit.php?id=".$rs2->fields["id_data"]."'>".$rs2->fields["jumlah"]."</a></td>";
		if ($rs2->fields["no_level"] == 2) echo "
			<td>&nbsp;</td><td>".$rs2->fields["no_urut"]."</td>
			<td colspan='5'>".$rs2->fields["keterangan"]."</td>
			<td><a href='./".$rs2->fields["nama_tabel"]."edit.php?id=".$rs2->fields["id_data"]."'>".$rs2->fields["jumlah"]."</a></td>
			<td>&nbsp;</td>";
		if ($rs2->fields["no_level"] == 3) echo "
			<td>&nbsp;</td><td>&nbsp;</td><td>".$rs2->fields["no_urut"]."</td>
			<td colspan='3'>".$rs2->fields["keterangan"]."</td>
			<td><a href='./".$rs2->fields["nama_tabel"]."edit.php?id=".$rs2->fields["id_data"]."'>".$rs2->fields["jumlah"]."</a></td>
			<td colspan='2'>&nbsp;</td>";
		if ($rs2->fields["no_level"] == 4) echo "
			<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>".$rs2->fields["no_urut"]."</td>
			<td>".$rs2->fields["keterangan"]."</td>
			<td><a href='./".$rs2->fields["nama_tabel"]."edit.php?id=".$rs2->fields["id_data"]."'>".$rs2->fields["jumlah"]."</a></td>
			<td colspan='3'>&nbsp;</td>";
		echo "</tr>";
		$rs2->MoveNext();
	}
}
?>
</table>
<?php if (EW_DEBUG_ENABLED) echo ew_DebugMsg(); ?>
<?php include_once "footer.php" ?>
<?php
$cf02_input_rkas_php->Page_Terminate();
?>
