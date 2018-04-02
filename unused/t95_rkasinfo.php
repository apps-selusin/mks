<?php

// Global variable for table object
$t95_rkas = NULL;

//
// Table class for t95_rkas
//
class ct95_rkas extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $id;
	var $kiri_tabel;
	var $kiri_id;
	var $kiri_lv2;
	var $kiri_lv3;
	var $kiri_lv4;
	var $kiri_jumlah;
	var $kanan_tabel;
	var $kanan_id;
	var $kanan_lv2;
	var $kanan_lv3;
	var $kanan_lv4;
	var $kanan_jumlah;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't95_rkas';
		$this->TableName = 't95_rkas';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t95_rkas`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('t95_rkas', 't95_rkas', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// kiri_tabel
		$this->kiri_tabel = new cField('t95_rkas', 't95_rkas', 'x_kiri_tabel', 'kiri_tabel', '`kiri_tabel`', '`kiri_tabel`', 200, -1, FALSE, '`kiri_tabel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kiri_tabel->Sortable = TRUE; // Allow sort
		$this->fields['kiri_tabel'] = &$this->kiri_tabel;

		// kiri_id
		$this->kiri_id = new cField('t95_rkas', 't95_rkas', 'x_kiri_id', 'kiri_id', '`kiri_id`', '`kiri_id`', 3, -1, FALSE, '`kiri_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kiri_id->Sortable = TRUE; // Allow sort
		$this->kiri_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kiri_id'] = &$this->kiri_id;

		// kiri_lv2
		$this->kiri_lv2 = new cField('t95_rkas', 't95_rkas', 'x_kiri_lv2', 'kiri_lv2', '`kiri_lv2`', '`kiri_lv2`', 200, -1, FALSE, '`kiri_lv2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kiri_lv2->Sortable = TRUE; // Allow sort
		$this->fields['kiri_lv2'] = &$this->kiri_lv2;

		// kiri_lv3
		$this->kiri_lv3 = new cField('t95_rkas', 't95_rkas', 'x_kiri_lv3', 'kiri_lv3', '`kiri_lv3`', '`kiri_lv3`', 200, -1, FALSE, '`kiri_lv3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kiri_lv3->Sortable = TRUE; // Allow sort
		$this->fields['kiri_lv3'] = &$this->kiri_lv3;

		// kiri_lv4
		$this->kiri_lv4 = new cField('t95_rkas', 't95_rkas', 'x_kiri_lv4', 'kiri_lv4', '`kiri_lv4`', '`kiri_lv4`', 200, -1, FALSE, '`kiri_lv4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kiri_lv4->Sortable = TRUE; // Allow sort
		$this->fields['kiri_lv4'] = &$this->kiri_lv4;

		// kiri_jumlah
		$this->kiri_jumlah = new cField('t95_rkas', 't95_rkas', 'x_kiri_jumlah', 'kiri_jumlah', '`kiri_jumlah`', '`kiri_jumlah`', 4, -1, FALSE, '`kiri_jumlah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kiri_jumlah->Sortable = TRUE; // Allow sort
		$this->kiri_jumlah->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['kiri_jumlah'] = &$this->kiri_jumlah;

		// kanan_tabel
		$this->kanan_tabel = new cField('t95_rkas', 't95_rkas', 'x_kanan_tabel', 'kanan_tabel', '`kanan_tabel`', '`kanan_tabel`', 200, -1, FALSE, '`kanan_tabel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kanan_tabel->Sortable = TRUE; // Allow sort
		$this->fields['kanan_tabel'] = &$this->kanan_tabel;

		// kanan_id
		$this->kanan_id = new cField('t95_rkas', 't95_rkas', 'x_kanan_id', 'kanan_id', '`kanan_id`', '`kanan_id`', 3, -1, FALSE, '`kanan_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kanan_id->Sortable = TRUE; // Allow sort
		$this->kanan_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kanan_id'] = &$this->kanan_id;

		// kanan_lv2
		$this->kanan_lv2 = new cField('t95_rkas', 't95_rkas', 'x_kanan_lv2', 'kanan_lv2', '`kanan_lv2`', '`kanan_lv2`', 200, -1, FALSE, '`kanan_lv2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kanan_lv2->Sortable = TRUE; // Allow sort
		$this->fields['kanan_lv2'] = &$this->kanan_lv2;

		// kanan_lv3
		$this->kanan_lv3 = new cField('t95_rkas', 't95_rkas', 'x_kanan_lv3', 'kanan_lv3', '`kanan_lv3`', '`kanan_lv3`', 200, -1, FALSE, '`kanan_lv3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kanan_lv3->Sortable = TRUE; // Allow sort
		$this->fields['kanan_lv3'] = &$this->kanan_lv3;

		// kanan_lv4
		$this->kanan_lv4 = new cField('t95_rkas', 't95_rkas', 'x_kanan_lv4', 'kanan_lv4', '`kanan_lv4`', '`kanan_lv4`', 200, -1, FALSE, '`kanan_lv4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kanan_lv4->Sortable = TRUE; // Allow sort
		$this->fields['kanan_lv4'] = &$this->kanan_lv4;

		// kanan_jumlah
		$this->kanan_jumlah = new cField('t95_rkas', 't95_rkas', 'x_kanan_jumlah', 'kanan_jumlah', '`kanan_jumlah`', '`kanan_jumlah`', 4, -1, FALSE, '`kanan_jumlah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kanan_jumlah->Sortable = TRUE; // Allow sort
		$this->kanan_jumlah->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['kanan_jumlah'] = &$this->kanan_jumlah;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t95_rkas`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->id->setDbValue($conn->Insert_ID());
			$rs['id'] = $this->id->DbValue;
			if ($this->AuditTrailOnAdd)
				$this->WriteAuditTrailOnAdd($rs);
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		if ($bUpdate && $this->AuditTrailOnEdit) {
			$rsaudit = $rs;
			$fldname = 'id';
			if (!array_key_exists($fldname, $rsaudit)) $rsaudit[$fldname] = $rsold[$fldname];
			$this->WriteAuditTrailOnEdit($rsold, $rsaudit);
		}
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		if ($bDelete && $this->AuditTrailOnDelete)
			$this->WriteAuditTrailOnDelete($rs);
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "t95_rkaslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "t95_rkasview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "t95_rkasedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "t95_rkasadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "t95_rkaslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t95_rkasview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t95_rkasview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t95_rkasadd.php?" . $this->UrlParm($parm);
		else
			$url = "t95_rkasadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t95_rkasedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t95_rkasadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t95_rkasdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = $_POST["id"];
			elseif (isset($_GET["id"]))
				$arKeys[] = $_GET["id"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->kiri_tabel->setDbValue($rs->fields('kiri_tabel'));
		$this->kiri_id->setDbValue($rs->fields('kiri_id'));
		$this->kiri_lv2->setDbValue($rs->fields('kiri_lv2'));
		$this->kiri_lv3->setDbValue($rs->fields('kiri_lv3'));
		$this->kiri_lv4->setDbValue($rs->fields('kiri_lv4'));
		$this->kiri_jumlah->setDbValue($rs->fields('kiri_jumlah'));
		$this->kanan_tabel->setDbValue($rs->fields('kanan_tabel'));
		$this->kanan_id->setDbValue($rs->fields('kanan_id'));
		$this->kanan_lv2->setDbValue($rs->fields('kanan_lv2'));
		$this->kanan_lv3->setDbValue($rs->fields('kanan_lv3'));
		$this->kanan_lv4->setDbValue($rs->fields('kanan_lv4'));
		$this->kanan_jumlah->setDbValue($rs->fields('kanan_jumlah'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
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

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// kiri_tabel
		$this->kiri_tabel->EditAttrs["class"] = "form-control";
		$this->kiri_tabel->EditCustomAttributes = "";
		$this->kiri_tabel->EditValue = $this->kiri_tabel->CurrentValue;
		$this->kiri_tabel->PlaceHolder = ew_RemoveHtml($this->kiri_tabel->FldCaption());

		// kiri_id
		$this->kiri_id->EditAttrs["class"] = "form-control";
		$this->kiri_id->EditCustomAttributes = "";
		$this->kiri_id->EditValue = $this->kiri_id->CurrentValue;
		$this->kiri_id->PlaceHolder = ew_RemoveHtml($this->kiri_id->FldCaption());

		// kiri_lv2
		$this->kiri_lv2->EditAttrs["class"] = "form-control";
		$this->kiri_lv2->EditCustomAttributes = "";
		$this->kiri_lv2->EditValue = $this->kiri_lv2->CurrentValue;
		$this->kiri_lv2->PlaceHolder = ew_RemoveHtml($this->kiri_lv2->FldCaption());

		// kiri_lv3
		$this->kiri_lv3->EditAttrs["class"] = "form-control";
		$this->kiri_lv3->EditCustomAttributes = "";
		$this->kiri_lv3->EditValue = $this->kiri_lv3->CurrentValue;
		$this->kiri_lv3->PlaceHolder = ew_RemoveHtml($this->kiri_lv3->FldCaption());

		// kiri_lv4
		$this->kiri_lv4->EditAttrs["class"] = "form-control";
		$this->kiri_lv4->EditCustomAttributes = "";
		$this->kiri_lv4->EditValue = $this->kiri_lv4->CurrentValue;
		$this->kiri_lv4->PlaceHolder = ew_RemoveHtml($this->kiri_lv4->FldCaption());

		// kiri_jumlah
		$this->kiri_jumlah->EditAttrs["class"] = "form-control";
		$this->kiri_jumlah->EditCustomAttributes = "";
		$this->kiri_jumlah->EditValue = $this->kiri_jumlah->CurrentValue;
		$this->kiri_jumlah->PlaceHolder = ew_RemoveHtml($this->kiri_jumlah->FldCaption());
		if (strval($this->kiri_jumlah->EditValue) <> "" && is_numeric($this->kiri_jumlah->EditValue)) $this->kiri_jumlah->EditValue = ew_FormatNumber($this->kiri_jumlah->EditValue, -2, -1, -2, 0);

		// kanan_tabel
		$this->kanan_tabel->EditAttrs["class"] = "form-control";
		$this->kanan_tabel->EditCustomAttributes = "";
		$this->kanan_tabel->EditValue = $this->kanan_tabel->CurrentValue;
		$this->kanan_tabel->PlaceHolder = ew_RemoveHtml($this->kanan_tabel->FldCaption());

		// kanan_id
		$this->kanan_id->EditAttrs["class"] = "form-control";
		$this->kanan_id->EditCustomAttributes = "";
		$this->kanan_id->EditValue = $this->kanan_id->CurrentValue;
		$this->kanan_id->PlaceHolder = ew_RemoveHtml($this->kanan_id->FldCaption());

		// kanan_lv2
		$this->kanan_lv2->EditAttrs["class"] = "form-control";
		$this->kanan_lv2->EditCustomAttributes = "";
		$this->kanan_lv2->EditValue = $this->kanan_lv2->CurrentValue;
		$this->kanan_lv2->PlaceHolder = ew_RemoveHtml($this->kanan_lv2->FldCaption());

		// kanan_lv3
		$this->kanan_lv3->EditAttrs["class"] = "form-control";
		$this->kanan_lv3->EditCustomAttributes = "";
		$this->kanan_lv3->EditValue = $this->kanan_lv3->CurrentValue;
		$this->kanan_lv3->PlaceHolder = ew_RemoveHtml($this->kanan_lv3->FldCaption());

		// kanan_lv4
		$this->kanan_lv4->EditAttrs["class"] = "form-control";
		$this->kanan_lv4->EditCustomAttributes = "";
		$this->kanan_lv4->EditValue = $this->kanan_lv4->CurrentValue;
		$this->kanan_lv4->PlaceHolder = ew_RemoveHtml($this->kanan_lv4->FldCaption());

		// kanan_jumlah
		$this->kanan_jumlah->EditAttrs["class"] = "form-control";
		$this->kanan_jumlah->EditCustomAttributes = "";
		$this->kanan_jumlah->EditValue = $this->kanan_jumlah->CurrentValue;
		$this->kanan_jumlah->PlaceHolder = ew_RemoveHtml($this->kanan_jumlah->FldCaption());
		if (strval($this->kanan_jumlah->EditValue) <> "" && is_numeric($this->kanan_jumlah->EditValue)) $this->kanan_jumlah->EditValue = ew_FormatNumber($this->kanan_jumlah->EditValue, -2, -1, -2, 0);

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->kiri_tabel->Exportable) $Doc->ExportCaption($this->kiri_tabel);
					if ($this->kiri_id->Exportable) $Doc->ExportCaption($this->kiri_id);
					if ($this->kiri_lv2->Exportable) $Doc->ExportCaption($this->kiri_lv2);
					if ($this->kiri_lv3->Exportable) $Doc->ExportCaption($this->kiri_lv3);
					if ($this->kiri_lv4->Exportable) $Doc->ExportCaption($this->kiri_lv4);
					if ($this->kiri_jumlah->Exportable) $Doc->ExportCaption($this->kiri_jumlah);
					if ($this->kanan_tabel->Exportable) $Doc->ExportCaption($this->kanan_tabel);
					if ($this->kanan_id->Exportable) $Doc->ExportCaption($this->kanan_id);
					if ($this->kanan_lv2->Exportable) $Doc->ExportCaption($this->kanan_lv2);
					if ($this->kanan_lv3->Exportable) $Doc->ExportCaption($this->kanan_lv3);
					if ($this->kanan_lv4->Exportable) $Doc->ExportCaption($this->kanan_lv4);
					if ($this->kanan_jumlah->Exportable) $Doc->ExportCaption($this->kanan_jumlah);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->kiri_tabel->Exportable) $Doc->ExportCaption($this->kiri_tabel);
					if ($this->kiri_id->Exportable) $Doc->ExportCaption($this->kiri_id);
					if ($this->kiri_lv2->Exportable) $Doc->ExportCaption($this->kiri_lv2);
					if ($this->kiri_lv3->Exportable) $Doc->ExportCaption($this->kiri_lv3);
					if ($this->kiri_lv4->Exportable) $Doc->ExportCaption($this->kiri_lv4);
					if ($this->kiri_jumlah->Exportable) $Doc->ExportCaption($this->kiri_jumlah);
					if ($this->kanan_tabel->Exportable) $Doc->ExportCaption($this->kanan_tabel);
					if ($this->kanan_id->Exportable) $Doc->ExportCaption($this->kanan_id);
					if ($this->kanan_lv2->Exportable) $Doc->ExportCaption($this->kanan_lv2);
					if ($this->kanan_lv3->Exportable) $Doc->ExportCaption($this->kanan_lv3);
					if ($this->kanan_lv4->Exportable) $Doc->ExportCaption($this->kanan_lv4);
					if ($this->kanan_jumlah->Exportable) $Doc->ExportCaption($this->kanan_jumlah);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->kiri_tabel->Exportable) $Doc->ExportField($this->kiri_tabel);
						if ($this->kiri_id->Exportable) $Doc->ExportField($this->kiri_id);
						if ($this->kiri_lv2->Exportable) $Doc->ExportField($this->kiri_lv2);
						if ($this->kiri_lv3->Exportable) $Doc->ExportField($this->kiri_lv3);
						if ($this->kiri_lv4->Exportable) $Doc->ExportField($this->kiri_lv4);
						if ($this->kiri_jumlah->Exportable) $Doc->ExportField($this->kiri_jumlah);
						if ($this->kanan_tabel->Exportable) $Doc->ExportField($this->kanan_tabel);
						if ($this->kanan_id->Exportable) $Doc->ExportField($this->kanan_id);
						if ($this->kanan_lv2->Exportable) $Doc->ExportField($this->kanan_lv2);
						if ($this->kanan_lv3->Exportable) $Doc->ExportField($this->kanan_lv3);
						if ($this->kanan_lv4->Exportable) $Doc->ExportField($this->kanan_lv4);
						if ($this->kanan_jumlah->Exportable) $Doc->ExportField($this->kanan_jumlah);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->kiri_tabel->Exportable) $Doc->ExportField($this->kiri_tabel);
						if ($this->kiri_id->Exportable) $Doc->ExportField($this->kiri_id);
						if ($this->kiri_lv2->Exportable) $Doc->ExportField($this->kiri_lv2);
						if ($this->kiri_lv3->Exportable) $Doc->ExportField($this->kiri_lv3);
						if ($this->kiri_lv4->Exportable) $Doc->ExportField($this->kiri_lv4);
						if ($this->kiri_jumlah->Exportable) $Doc->ExportField($this->kiri_jumlah);
						if ($this->kanan_tabel->Exportable) $Doc->ExportField($this->kanan_tabel);
						if ($this->kanan_id->Exportable) $Doc->ExportField($this->kanan_id);
						if ($this->kanan_lv2->Exportable) $Doc->ExportField($this->kanan_lv2);
						if ($this->kanan_lv3->Exportable) $Doc->ExportField($this->kanan_lv3);
						if ($this->kanan_lv4->Exportable) $Doc->ExportField($this->kanan_lv4);
						if ($this->kanan_jumlah->Exportable) $Doc->ExportField($this->kanan_jumlah);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 't95_rkas';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 't95_rkas';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 't95_rkas';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rsnew) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && array_key_exists($fldname, $rsold) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 't95_rkas';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$oldvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
			}
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
