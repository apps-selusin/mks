<?php include_once "t96_employeesinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t05_rkas04_grid)) $t05_rkas04_grid = new ct05_rkas04_grid();

// Page init
$t05_rkas04_grid->Page_Init();

// Page main
$t05_rkas04_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t05_rkas04_grid->Page_Render();
?>
<?php if ($t05_rkas04->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft05_rkas04grid = new ew_Form("ft05_rkas04grid", "grid");
ft05_rkas04grid.FormKeyCountName = '<?php echo $t05_rkas04_grid->FormKeyCountName ?>';

// Validate form
ft05_rkas04grid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_lv3_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t05_rkas04->lv3_id->FldCaption(), $t05_rkas04->lv3_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_no_urut");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t05_rkas04->no_urut->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_keterangan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t05_rkas04->keterangan->FldCaption(), $t05_rkas04->keterangan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t05_rkas04->jumlah->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft05_rkas04grid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "lv1_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "lv2_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "lv3_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "no_urut", false)) return false;
	if (ew_ValueChanged(fobj, infix, "keterangan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jumlah", false)) return false;
	return true;
}

// Form_CustomValidate event
ft05_rkas04grid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft05_rkas04grid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft05_rkas04grid.Lists["x_lv1_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_urut","x_keterangan","",""],"ParentFields":[],"ChildFields":["x_lv2_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t02_rkas01"};
ft05_rkas04grid.Lists["x_lv1_id"].Data = "<?php echo $t05_rkas04_grid->lv1_id->LookupFilterQuery(FALSE, "grid") ?>";
ft05_rkas04grid.AutoSuggests["x_lv1_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $t05_rkas04_grid->lv1_id->LookupFilterQuery(TRUE, "grid"))) ?>;
ft05_rkas04grid.Lists["x_lv2_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_urut","x_keterangan","",""],"ParentFields":["x_lv1_id"],"ChildFields":["x_lv3_id"],"FilterFields":["x_lv1_id"],"Options":[],"Template":"","LinkTable":"t03_rkas02"};
ft05_rkas04grid.Lists["x_lv2_id"].Data = "<?php echo $t05_rkas04_grid->lv2_id->LookupFilterQuery(FALSE, "grid") ?>";
ft05_rkas04grid.AutoSuggests["x_lv2_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $t05_rkas04_grid->lv2_id->LookupFilterQuery(TRUE, "grid"))) ?>;
ft05_rkas04grid.Lists["x_lv3_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_urut","x_keterangan","",""],"ParentFields":["x_lv2_id"],"ChildFields":[],"FilterFields":["x_lv2_id"],"Options":[],"Template":"","LinkTable":"t04_rkas03"};
ft05_rkas04grid.Lists["x_lv3_id"].Data = "<?php echo $t05_rkas04_grid->lv3_id->LookupFilterQuery(FALSE, "grid") ?>";
ft05_rkas04grid.AutoSuggests["x_lv3_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $t05_rkas04_grid->lv3_id->LookupFilterQuery(TRUE, "grid"))) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($t05_rkas04->CurrentAction == "gridadd") {
	if ($t05_rkas04->CurrentMode == "copy") {
		$bSelectLimit = $t05_rkas04_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t05_rkas04_grid->TotalRecs = $t05_rkas04->ListRecordCount();
			$t05_rkas04_grid->Recordset = $t05_rkas04_grid->LoadRecordset($t05_rkas04_grid->StartRec-1, $t05_rkas04_grid->DisplayRecs);
		} else {
			if ($t05_rkas04_grid->Recordset = $t05_rkas04_grid->LoadRecordset())
				$t05_rkas04_grid->TotalRecs = $t05_rkas04_grid->Recordset->RecordCount();
		}
		$t05_rkas04_grid->StartRec = 1;
		$t05_rkas04_grid->DisplayRecs = $t05_rkas04_grid->TotalRecs;
	} else {
		$t05_rkas04->CurrentFilter = "0=1";
		$t05_rkas04_grid->StartRec = 1;
		$t05_rkas04_grid->DisplayRecs = $t05_rkas04->GridAddRowCount;
	}
	$t05_rkas04_grid->TotalRecs = $t05_rkas04_grid->DisplayRecs;
	$t05_rkas04_grid->StopRec = $t05_rkas04_grid->DisplayRecs;
} else {
	$bSelectLimit = $t05_rkas04_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t05_rkas04_grid->TotalRecs <= 0)
			$t05_rkas04_grid->TotalRecs = $t05_rkas04->ListRecordCount();
	} else {
		if (!$t05_rkas04_grid->Recordset && ($t05_rkas04_grid->Recordset = $t05_rkas04_grid->LoadRecordset()))
			$t05_rkas04_grid->TotalRecs = $t05_rkas04_grid->Recordset->RecordCount();
	}
	$t05_rkas04_grid->StartRec = 1;
	$t05_rkas04_grid->DisplayRecs = $t05_rkas04_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t05_rkas04_grid->Recordset = $t05_rkas04_grid->LoadRecordset($t05_rkas04_grid->StartRec-1, $t05_rkas04_grid->DisplayRecs);

	// Set no record found message
	if ($t05_rkas04->CurrentAction == "" && $t05_rkas04_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$t05_rkas04_grid->setWarningMessage(ew_DeniedMsg());
		if ($t05_rkas04_grid->SearchWhere == "0=101")
			$t05_rkas04_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t05_rkas04_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t05_rkas04_grid->RenderOtherOptions();
?>
<?php $t05_rkas04_grid->ShowPageHeader(); ?>
<?php
$t05_rkas04_grid->ShowMessage();
?>
<?php if ($t05_rkas04_grid->TotalRecs > 0 || $t05_rkas04->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t05_rkas04_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t05_rkas04">
<div id="ft05_rkas04grid" class="ewForm ewListForm form-inline">
<?php if ($t05_rkas04_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($t05_rkas04_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_t05_rkas04" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_t05_rkas04grid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t05_rkas04_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t05_rkas04_grid->RenderListOptions();

// Render list options (header, left)
$t05_rkas04_grid->ListOptions->Render("header", "left");
?>
<?php if ($t05_rkas04->lv1_id->Visible) { // lv1_id ?>
	<?php if ($t05_rkas04->SortUrl($t05_rkas04->lv1_id) == "") { ?>
		<th data-name="lv1_id" class="<?php echo $t05_rkas04->lv1_id->HeaderCellClass() ?>"><div id="elh_t05_rkas04_lv1_id" class="t05_rkas04_lv1_id"><div class="ewTableHeaderCaption"><?php echo $t05_rkas04->lv1_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lv1_id" class="<?php echo $t05_rkas04->lv1_id->HeaderCellClass() ?>"><div><div id="elh_t05_rkas04_lv1_id" class="t05_rkas04_lv1_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t05_rkas04->lv1_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t05_rkas04->lv1_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t05_rkas04->lv1_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t05_rkas04->lv2_id->Visible) { // lv2_id ?>
	<?php if ($t05_rkas04->SortUrl($t05_rkas04->lv2_id) == "") { ?>
		<th data-name="lv2_id" class="<?php echo $t05_rkas04->lv2_id->HeaderCellClass() ?>"><div id="elh_t05_rkas04_lv2_id" class="t05_rkas04_lv2_id"><div class="ewTableHeaderCaption"><?php echo $t05_rkas04->lv2_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lv2_id" class="<?php echo $t05_rkas04->lv2_id->HeaderCellClass() ?>"><div><div id="elh_t05_rkas04_lv2_id" class="t05_rkas04_lv2_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t05_rkas04->lv2_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t05_rkas04->lv2_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t05_rkas04->lv2_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t05_rkas04->lv3_id->Visible) { // lv3_id ?>
	<?php if ($t05_rkas04->SortUrl($t05_rkas04->lv3_id) == "") { ?>
		<th data-name="lv3_id" class="<?php echo $t05_rkas04->lv3_id->HeaderCellClass() ?>"><div id="elh_t05_rkas04_lv3_id" class="t05_rkas04_lv3_id"><div class="ewTableHeaderCaption"><?php echo $t05_rkas04->lv3_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lv3_id" class="<?php echo $t05_rkas04->lv3_id->HeaderCellClass() ?>"><div><div id="elh_t05_rkas04_lv3_id" class="t05_rkas04_lv3_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t05_rkas04->lv3_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t05_rkas04->lv3_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t05_rkas04->lv3_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t05_rkas04->no_urut->Visible) { // no_urut ?>
	<?php if ($t05_rkas04->SortUrl($t05_rkas04->no_urut) == "") { ?>
		<th data-name="no_urut" class="<?php echo $t05_rkas04->no_urut->HeaderCellClass() ?>"><div id="elh_t05_rkas04_no_urut" class="t05_rkas04_no_urut"><div class="ewTableHeaderCaption"><?php echo $t05_rkas04->no_urut->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_urut" class="<?php echo $t05_rkas04->no_urut->HeaderCellClass() ?>"><div><div id="elh_t05_rkas04_no_urut" class="t05_rkas04_no_urut">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t05_rkas04->no_urut->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t05_rkas04->no_urut->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t05_rkas04->no_urut->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t05_rkas04->keterangan->Visible) { // keterangan ?>
	<?php if ($t05_rkas04->SortUrl($t05_rkas04->keterangan) == "") { ?>
		<th data-name="keterangan" class="<?php echo $t05_rkas04->keterangan->HeaderCellClass() ?>"><div id="elh_t05_rkas04_keterangan" class="t05_rkas04_keterangan"><div class="ewTableHeaderCaption"><?php echo $t05_rkas04->keterangan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="keterangan" class="<?php echo $t05_rkas04->keterangan->HeaderCellClass() ?>"><div><div id="elh_t05_rkas04_keterangan" class="t05_rkas04_keterangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t05_rkas04->keterangan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t05_rkas04->keterangan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t05_rkas04->keterangan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t05_rkas04->jumlah->Visible) { // jumlah ?>
	<?php if ($t05_rkas04->SortUrl($t05_rkas04->jumlah) == "") { ?>
		<th data-name="jumlah" class="<?php echo $t05_rkas04->jumlah->HeaderCellClass() ?>"><div id="elh_t05_rkas04_jumlah" class="t05_rkas04_jumlah"><div class="ewTableHeaderCaption"><?php echo $t05_rkas04->jumlah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jumlah" class="<?php echo $t05_rkas04->jumlah->HeaderCellClass() ?>"><div><div id="elh_t05_rkas04_jumlah" class="t05_rkas04_jumlah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t05_rkas04->jumlah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t05_rkas04->jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t05_rkas04->jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t05_rkas04_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t05_rkas04_grid->StartRec = 1;
$t05_rkas04_grid->StopRec = $t05_rkas04_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t05_rkas04_grid->FormKeyCountName) && ($t05_rkas04->CurrentAction == "gridadd" || $t05_rkas04->CurrentAction == "gridedit" || $t05_rkas04->CurrentAction == "F")) {
		$t05_rkas04_grid->KeyCount = $objForm->GetValue($t05_rkas04_grid->FormKeyCountName);
		$t05_rkas04_grid->StopRec = $t05_rkas04_grid->StartRec + $t05_rkas04_grid->KeyCount - 1;
	}
}
$t05_rkas04_grid->RecCnt = $t05_rkas04_grid->StartRec - 1;
if ($t05_rkas04_grid->Recordset && !$t05_rkas04_grid->Recordset->EOF) {
	$t05_rkas04_grid->Recordset->MoveFirst();
	$bSelectLimit = $t05_rkas04_grid->UseSelectLimit;
	if (!$bSelectLimit && $t05_rkas04_grid->StartRec > 1)
		$t05_rkas04_grid->Recordset->Move($t05_rkas04_grid->StartRec - 1);
} elseif (!$t05_rkas04->AllowAddDeleteRow && $t05_rkas04_grid->StopRec == 0) {
	$t05_rkas04_grid->StopRec = $t05_rkas04->GridAddRowCount;
}

// Initialize aggregate
$t05_rkas04->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t05_rkas04->ResetAttrs();
$t05_rkas04_grid->RenderRow();
if ($t05_rkas04->CurrentAction == "gridadd")
	$t05_rkas04_grid->RowIndex = 0;
if ($t05_rkas04->CurrentAction == "gridedit")
	$t05_rkas04_grid->RowIndex = 0;
while ($t05_rkas04_grid->RecCnt < $t05_rkas04_grid->StopRec) {
	$t05_rkas04_grid->RecCnt++;
	if (intval($t05_rkas04_grid->RecCnt) >= intval($t05_rkas04_grid->StartRec)) {
		$t05_rkas04_grid->RowCnt++;
		if ($t05_rkas04->CurrentAction == "gridadd" || $t05_rkas04->CurrentAction == "gridedit" || $t05_rkas04->CurrentAction == "F") {
			$t05_rkas04_grid->RowIndex++;
			$objForm->Index = $t05_rkas04_grid->RowIndex;
			if ($objForm->HasValue($t05_rkas04_grid->FormActionName))
				$t05_rkas04_grid->RowAction = strval($objForm->GetValue($t05_rkas04_grid->FormActionName));
			elseif ($t05_rkas04->CurrentAction == "gridadd")
				$t05_rkas04_grid->RowAction = "insert";
			else
				$t05_rkas04_grid->RowAction = "";
		}

		// Set up key count
		$t05_rkas04_grid->KeyCount = $t05_rkas04_grid->RowIndex;

		// Init row class and style
		$t05_rkas04->ResetAttrs();
		$t05_rkas04->CssClass = "";
		if ($t05_rkas04->CurrentAction == "gridadd") {
			if ($t05_rkas04->CurrentMode == "copy") {
				$t05_rkas04_grid->LoadRowValues($t05_rkas04_grid->Recordset); // Load row values
				$t05_rkas04_grid->SetRecordKey($t05_rkas04_grid->RowOldKey, $t05_rkas04_grid->Recordset); // Set old record key
			} else {
				$t05_rkas04_grid->LoadRowValues(); // Load default values
				$t05_rkas04_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t05_rkas04_grid->LoadRowValues($t05_rkas04_grid->Recordset); // Load row values
		}
		$t05_rkas04->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t05_rkas04->CurrentAction == "gridadd") // Grid add
			$t05_rkas04->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t05_rkas04->CurrentAction == "gridadd" && $t05_rkas04->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t05_rkas04_grid->RestoreCurrentRowFormValues($t05_rkas04_grid->RowIndex); // Restore form values
		if ($t05_rkas04->CurrentAction == "gridedit") { // Grid edit
			if ($t05_rkas04->EventCancelled) {
				$t05_rkas04_grid->RestoreCurrentRowFormValues($t05_rkas04_grid->RowIndex); // Restore form values
			}
			if ($t05_rkas04_grid->RowAction == "insert")
				$t05_rkas04->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t05_rkas04->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t05_rkas04->CurrentAction == "gridedit" && ($t05_rkas04->RowType == EW_ROWTYPE_EDIT || $t05_rkas04->RowType == EW_ROWTYPE_ADD) && $t05_rkas04->EventCancelled) // Update failed
			$t05_rkas04_grid->RestoreCurrentRowFormValues($t05_rkas04_grid->RowIndex); // Restore form values
		if ($t05_rkas04->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t05_rkas04_grid->EditRowCnt++;
		if ($t05_rkas04->CurrentAction == "F") // Confirm row
			$t05_rkas04_grid->RestoreCurrentRowFormValues($t05_rkas04_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t05_rkas04->RowAttrs = array_merge($t05_rkas04->RowAttrs, array('data-rowindex'=>$t05_rkas04_grid->RowCnt, 'id'=>'r' . $t05_rkas04_grid->RowCnt . '_t05_rkas04', 'data-rowtype'=>$t05_rkas04->RowType));

		// Render row
		$t05_rkas04_grid->RenderRow();

		// Render list options
		$t05_rkas04_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t05_rkas04_grid->RowAction <> "delete" && $t05_rkas04_grid->RowAction <> "insertdelete" && !($t05_rkas04_grid->RowAction == "insert" && $t05_rkas04->CurrentAction == "F" && $t05_rkas04_grid->EmptyRow())) {
?>
	<tr<?php echo $t05_rkas04->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t05_rkas04_grid->ListOptions->Render("body", "left", $t05_rkas04_grid->RowCnt);
?>
	<?php if ($t05_rkas04->lv1_id->Visible) { // lv1_id ?>
		<td data-name="lv1_id"<?php echo $t05_rkas04->lv1_id->CellAttributes() ?>>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_lv1_id" class="form-group t05_rkas04_lv1_id">
<?php
$wrkonchange = trim("ew_UpdateOpt.call(this); " . @$t05_rkas04->lv1_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t05_rkas04->lv1_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t05_rkas04_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" id="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" value="<?php echo $t05_rkas04->lv1_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->getPlaceHolder()) ?>"<?php echo $t05_rkas04->lv1_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t05_rkas04->lv1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft05_rkas04grid.CreateAutoSuggest({"id":"x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t05_rkas04->lv1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t05_rkas04->lv1_id->ReadOnly || $t05_rkas04->lv1_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv1_id" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->OldValue) ?>">
<?php } ?>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_lv1_id" class="form-group t05_rkas04_lv1_id">
<?php
$wrkonchange = trim("ew_UpdateOpt.call(this); " . @$t05_rkas04->lv1_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t05_rkas04->lv1_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t05_rkas04_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" id="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" value="<?php echo $t05_rkas04->lv1_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->getPlaceHolder()) ?>"<?php echo $t05_rkas04->lv1_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t05_rkas04->lv1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft05_rkas04grid.CreateAutoSuggest({"id":"x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t05_rkas04->lv1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t05_rkas04->lv1_id->ReadOnly || $t05_rkas04->lv1_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } ?>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_lv1_id" class="t05_rkas04_lv1_id">
<span<?php echo $t05_rkas04->lv1_id->ViewAttributes() ?>>
<?php echo $t05_rkas04->lv1_id->ListViewValue() ?></span>
</span>
<?php if ($t05_rkas04->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv1_id" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->FormValue) ?>">
<input type="hidden" data-table="t05_rkas04" data-field="x_lv1_id" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv1_id" name="ft05_rkas04grid$x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" id="ft05_rkas04grid$x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->FormValue) ?>">
<input type="hidden" data-table="t05_rkas04" data-field="x_lv1_id" name="ft05_rkas04grid$o<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" id="ft05_rkas04grid$o<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_id" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t05_rkas04->id->CurrentValue) ?>">
<input type="hidden" data-table="t05_rkas04" data-field="x_id" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_id" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t05_rkas04->id->OldValue) ?>">
<?php } ?>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_EDIT || $t05_rkas04->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_id" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t05_rkas04->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t05_rkas04->lv2_id->Visible) { // lv2_id ?>
		<td data-name="lv2_id"<?php echo $t05_rkas04->lv2_id->CellAttributes() ?>>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_lv2_id" class="form-group t05_rkas04_lv2_id">
<?php
$wrkonchange = trim("ew_UpdateOpt.call(this); " . @$t05_rkas04->lv2_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t05_rkas04->lv2_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t05_rkas04_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" id="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" value="<?php echo $t05_rkas04->lv2_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->getPlaceHolder()) ?>"<?php echo $t05_rkas04->lv2_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv2_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t05_rkas04->lv2_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft05_rkas04grid.CreateAutoSuggest({"id":"x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t05_rkas04->lv2_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t05_rkas04->lv2_id->ReadOnly || $t05_rkas04->lv2_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv2_id" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->OldValue) ?>">
<?php } ?>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_lv2_id" class="form-group t05_rkas04_lv2_id">
<?php
$wrkonchange = trim("ew_UpdateOpt.call(this); " . @$t05_rkas04->lv2_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t05_rkas04->lv2_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t05_rkas04_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" id="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" value="<?php echo $t05_rkas04->lv2_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->getPlaceHolder()) ?>"<?php echo $t05_rkas04->lv2_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv2_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t05_rkas04->lv2_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft05_rkas04grid.CreateAutoSuggest({"id":"x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t05_rkas04->lv2_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t05_rkas04->lv2_id->ReadOnly || $t05_rkas04->lv2_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } ?>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_lv2_id" class="t05_rkas04_lv2_id">
<span<?php echo $t05_rkas04->lv2_id->ViewAttributes() ?>>
<?php echo $t05_rkas04->lv2_id->ListViewValue() ?></span>
</span>
<?php if ($t05_rkas04->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv2_id" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->FormValue) ?>">
<input type="hidden" data-table="t05_rkas04" data-field="x_lv2_id" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv2_id" name="ft05_rkas04grid$x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" id="ft05_rkas04grid$x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->FormValue) ?>">
<input type="hidden" data-table="t05_rkas04" data-field="x_lv2_id" name="ft05_rkas04grid$o<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" id="ft05_rkas04grid$o<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t05_rkas04->lv3_id->Visible) { // lv3_id ?>
		<td data-name="lv3_id"<?php echo $t05_rkas04->lv3_id->CellAttributes() ?>>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t05_rkas04->lv3_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_lv3_id" class="form-group t05_rkas04_lv3_id">
<span<?php echo $t05_rkas04->lv3_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t05_rkas04->lv3_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_lv3_id" class="form-group t05_rkas04_lv3_id">
<?php
$wrkonchange = trim(" " . @$t05_rkas04->lv3_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t05_rkas04->lv3_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t05_rkas04_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" id="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo $t05_rkas04->lv3_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->getPlaceHolder()) ?>"<?php echo $t05_rkas04->lv3_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv3_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t05_rkas04->lv3_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft05_rkas04grid.CreateAutoSuggest({"id":"x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t05_rkas04->lv3_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t05_rkas04->lv3_id->ReadOnly || $t05_rkas04->lv3_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv3_id" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->OldValue) ?>">
<?php } ?>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t05_rkas04->lv3_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_lv3_id" class="form-group t05_rkas04_lv3_id">
<span<?php echo $t05_rkas04->lv3_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t05_rkas04->lv3_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_lv3_id" class="form-group t05_rkas04_lv3_id">
<?php
$wrkonchange = trim(" " . @$t05_rkas04->lv3_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t05_rkas04->lv3_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t05_rkas04_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" id="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo $t05_rkas04->lv3_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->getPlaceHolder()) ?>"<?php echo $t05_rkas04->lv3_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv3_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t05_rkas04->lv3_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft05_rkas04grid.CreateAutoSuggest({"id":"x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t05_rkas04->lv3_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t05_rkas04->lv3_id->ReadOnly || $t05_rkas04->lv3_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } ?>
<?php } ?>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_lv3_id" class="t05_rkas04_lv3_id">
<span<?php echo $t05_rkas04->lv3_id->ViewAttributes() ?>>
<?php echo $t05_rkas04->lv3_id->ListViewValue() ?></span>
</span>
<?php if ($t05_rkas04->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv3_id" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->FormValue) ?>">
<input type="hidden" data-table="t05_rkas04" data-field="x_lv3_id" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv3_id" name="ft05_rkas04grid$x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" id="ft05_rkas04grid$x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->FormValue) ?>">
<input type="hidden" data-table="t05_rkas04" data-field="x_lv3_id" name="ft05_rkas04grid$o<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" id="ft05_rkas04grid$o<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t05_rkas04->no_urut->Visible) { // no_urut ?>
		<td data-name="no_urut"<?php echo $t05_rkas04->no_urut->CellAttributes() ?>>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_no_urut" class="form-group t05_rkas04_no_urut">
<input type="text" data-table="t05_rkas04" data-field="x_no_urut" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->no_urut->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->no_urut->EditValue ?>"<?php echo $t05_rkas04->no_urut->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_no_urut" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t05_rkas04->no_urut->OldValue) ?>">
<?php } ?>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_no_urut" class="form-group t05_rkas04_no_urut">
<input type="text" data-table="t05_rkas04" data-field="x_no_urut" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->no_urut->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->no_urut->EditValue ?>"<?php echo $t05_rkas04->no_urut->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_no_urut" class="t05_rkas04_no_urut">
<span<?php echo $t05_rkas04->no_urut->ViewAttributes() ?>>
<?php echo $t05_rkas04->no_urut->ListViewValue() ?></span>
</span>
<?php if ($t05_rkas04->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_no_urut" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t05_rkas04->no_urut->FormValue) ?>">
<input type="hidden" data-table="t05_rkas04" data-field="x_no_urut" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t05_rkas04->no_urut->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_no_urut" name="ft05_rkas04grid$x<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" id="ft05_rkas04grid$x<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t05_rkas04->no_urut->FormValue) ?>">
<input type="hidden" data-table="t05_rkas04" data-field="x_no_urut" name="ft05_rkas04grid$o<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" id="ft05_rkas04grid$o<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t05_rkas04->no_urut->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t05_rkas04->keterangan->Visible) { // keterangan ?>
		<td data-name="keterangan"<?php echo $t05_rkas04->keterangan->CellAttributes() ?>>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_keterangan" class="form-group t05_rkas04_keterangan">
<input type="text" data-table="t05_rkas04" data-field="x_keterangan" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->keterangan->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->keterangan->EditValue ?>"<?php echo $t05_rkas04->keterangan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_keterangan" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t05_rkas04->keterangan->OldValue) ?>">
<?php } ?>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_keterangan" class="form-group t05_rkas04_keterangan">
<input type="text" data-table="t05_rkas04" data-field="x_keterangan" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->keterangan->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->keterangan->EditValue ?>"<?php echo $t05_rkas04->keterangan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_keterangan" class="t05_rkas04_keterangan">
<span<?php echo $t05_rkas04->keterangan->ViewAttributes() ?>>
<?php echo $t05_rkas04->keterangan->ListViewValue() ?></span>
</span>
<?php if ($t05_rkas04->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_keterangan" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t05_rkas04->keterangan->FormValue) ?>">
<input type="hidden" data-table="t05_rkas04" data-field="x_keterangan" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t05_rkas04->keterangan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_keterangan" name="ft05_rkas04grid$x<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" id="ft05_rkas04grid$x<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t05_rkas04->keterangan->FormValue) ?>">
<input type="hidden" data-table="t05_rkas04" data-field="x_keterangan" name="ft05_rkas04grid$o<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" id="ft05_rkas04grid$o<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t05_rkas04->keterangan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t05_rkas04->jumlah->Visible) { // jumlah ?>
		<td data-name="jumlah"<?php echo $t05_rkas04->jumlah->CellAttributes() ?>>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_jumlah" class="form-group t05_rkas04_jumlah">
<input type="text" data-table="t05_rkas04" data-field="x_jumlah" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->jumlah->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->jumlah->EditValue ?>"<?php echo $t05_rkas04->jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_jumlah" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t05_rkas04->jumlah->OldValue) ?>">
<?php } ?>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_jumlah" class="form-group t05_rkas04_jumlah">
<input type="text" data-table="t05_rkas04" data-field="x_jumlah" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->jumlah->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->jumlah->EditValue ?>"<?php echo $t05_rkas04->jumlah->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t05_rkas04_grid->RowCnt ?>_t05_rkas04_jumlah" class="t05_rkas04_jumlah">
<span<?php echo $t05_rkas04->jumlah->ViewAttributes() ?>>
<?php echo $t05_rkas04->jumlah->ListViewValue() ?></span>
</span>
<?php if ($t05_rkas04->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_jumlah" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t05_rkas04->jumlah->FormValue) ?>">
<input type="hidden" data-table="t05_rkas04" data-field="x_jumlah" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t05_rkas04->jumlah->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_jumlah" name="ft05_rkas04grid$x<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" id="ft05_rkas04grid$x<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t05_rkas04->jumlah->FormValue) ?>">
<input type="hidden" data-table="t05_rkas04" data-field="x_jumlah" name="ft05_rkas04grid$o<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" id="ft05_rkas04grid$o<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t05_rkas04->jumlah->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t05_rkas04_grid->ListOptions->Render("body", "right", $t05_rkas04_grid->RowCnt);
?>
	</tr>
<?php if ($t05_rkas04->RowType == EW_ROWTYPE_ADD || $t05_rkas04->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft05_rkas04grid.UpdateOpts(<?php echo $t05_rkas04_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t05_rkas04->CurrentAction <> "gridadd" || $t05_rkas04->CurrentMode == "copy")
		if (!$t05_rkas04_grid->Recordset->EOF) $t05_rkas04_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t05_rkas04->CurrentMode == "add" || $t05_rkas04->CurrentMode == "copy" || $t05_rkas04->CurrentMode == "edit") {
		$t05_rkas04_grid->RowIndex = '$rowindex$';
		$t05_rkas04_grid->LoadRowValues();

		// Set row properties
		$t05_rkas04->ResetAttrs();
		$t05_rkas04->RowAttrs = array_merge($t05_rkas04->RowAttrs, array('data-rowindex'=>$t05_rkas04_grid->RowIndex, 'id'=>'r0_t05_rkas04', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t05_rkas04->RowAttrs["class"], "ewTemplate");
		$t05_rkas04->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t05_rkas04_grid->RenderRow();

		// Render list options
		$t05_rkas04_grid->RenderListOptions();
		$t05_rkas04_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t05_rkas04->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t05_rkas04_grid->ListOptions->Render("body", "left", $t05_rkas04_grid->RowIndex);
?>
	<?php if ($t05_rkas04->lv1_id->Visible) { // lv1_id ?>
		<td data-name="lv1_id">
<?php if ($t05_rkas04->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t05_rkas04_lv1_id" class="form-group t05_rkas04_lv1_id">
<?php
$wrkonchange = trim("ew_UpdateOpt.call(this); " . @$t05_rkas04->lv1_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t05_rkas04->lv1_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t05_rkas04_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" id="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" value="<?php echo $t05_rkas04->lv1_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->getPlaceHolder()) ?>"<?php echo $t05_rkas04->lv1_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t05_rkas04->lv1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft05_rkas04grid.CreateAutoSuggest({"id":"x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t05_rkas04->lv1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t05_rkas04->lv1_id->ReadOnly || $t05_rkas04->lv1_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } else { ?>
<span id="el$rowindex$_t05_rkas04_lv1_id" class="form-group t05_rkas04_lv1_id">
<span<?php echo $t05_rkas04->lv1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t05_rkas04->lv1_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv1_id" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv1_id" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv1_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t05_rkas04->lv2_id->Visible) { // lv2_id ?>
		<td data-name="lv2_id">
<?php if ($t05_rkas04->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t05_rkas04_lv2_id" class="form-group t05_rkas04_lv2_id">
<?php
$wrkonchange = trim("ew_UpdateOpt.call(this); " . @$t05_rkas04->lv2_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t05_rkas04->lv2_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t05_rkas04_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" id="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" value="<?php echo $t05_rkas04->lv2_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->getPlaceHolder()) ?>"<?php echo $t05_rkas04->lv2_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv2_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t05_rkas04->lv2_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft05_rkas04grid.CreateAutoSuggest({"id":"x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t05_rkas04->lv2_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t05_rkas04->lv2_id->ReadOnly || $t05_rkas04->lv2_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } else { ?>
<span id="el$rowindex$_t05_rkas04_lv2_id" class="form-group t05_rkas04_lv2_id">
<span<?php echo $t05_rkas04->lv2_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t05_rkas04->lv2_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv2_id" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv2_id" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv2_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t05_rkas04->lv3_id->Visible) { // lv3_id ?>
		<td data-name="lv3_id">
<?php if ($t05_rkas04->CurrentAction <> "F") { ?>
<?php if ($t05_rkas04->lv3_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t05_rkas04_lv3_id" class="form-group t05_rkas04_lv3_id">
<span<?php echo $t05_rkas04->lv3_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t05_rkas04->lv3_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t05_rkas04_lv3_id" class="form-group t05_rkas04_lv3_id">
<?php
$wrkonchange = trim(" " . @$t05_rkas04->lv3_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t05_rkas04->lv3_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t05_rkas04_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" id="sv_x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo $t05_rkas04->lv3_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->getPlaceHolder()) ?>"<?php echo $t05_rkas04->lv3_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv3_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t05_rkas04->lv3_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft05_rkas04grid.CreateAutoSuggest({"id":"x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t05_rkas04->lv3_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t05_rkas04->lv3_id->ReadOnly || $t05_rkas04->lv3_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t05_rkas04_lv3_id" class="form-group t05_rkas04_lv3_id">
<span<?php echo $t05_rkas04->lv3_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t05_rkas04->lv3_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv3_id" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_lv3_id" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_lv3_id" value="<?php echo ew_HtmlEncode($t05_rkas04->lv3_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t05_rkas04->no_urut->Visible) { // no_urut ?>
		<td data-name="no_urut">
<?php if ($t05_rkas04->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t05_rkas04_no_urut" class="form-group t05_rkas04_no_urut">
<input type="text" data-table="t05_rkas04" data-field="x_no_urut" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->no_urut->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->no_urut->EditValue ?>"<?php echo $t05_rkas04->no_urut->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t05_rkas04_no_urut" class="form-group t05_rkas04_no_urut">
<span<?php echo $t05_rkas04->no_urut->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t05_rkas04->no_urut->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_no_urut" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t05_rkas04->no_urut->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_no_urut" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t05_rkas04->no_urut->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t05_rkas04->keterangan->Visible) { // keterangan ?>
		<td data-name="keterangan">
<?php if ($t05_rkas04->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t05_rkas04_keterangan" class="form-group t05_rkas04_keterangan">
<input type="text" data-table="t05_rkas04" data-field="x_keterangan" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->keterangan->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->keterangan->EditValue ?>"<?php echo $t05_rkas04->keterangan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t05_rkas04_keterangan" class="form-group t05_rkas04_keterangan">
<span<?php echo $t05_rkas04->keterangan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t05_rkas04->keterangan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_keterangan" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t05_rkas04->keterangan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_keterangan" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t05_rkas04->keterangan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t05_rkas04->jumlah->Visible) { // jumlah ?>
		<td data-name="jumlah">
<?php if ($t05_rkas04->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t05_rkas04_jumlah" class="form-group t05_rkas04_jumlah">
<input type="text" data-table="t05_rkas04" data-field="x_jumlah" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t05_rkas04->jumlah->getPlaceHolder()) ?>" value="<?php echo $t05_rkas04->jumlah->EditValue ?>"<?php echo $t05_rkas04->jumlah->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t05_rkas04_jumlah" class="form-group t05_rkas04_jumlah">
<span<?php echo $t05_rkas04->jumlah->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t05_rkas04->jumlah->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t05_rkas04" data-field="x_jumlah" name="x<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" id="x<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t05_rkas04->jumlah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t05_rkas04" data-field="x_jumlah" name="o<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" id="o<?php echo $t05_rkas04_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t05_rkas04->jumlah->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t05_rkas04_grid->ListOptions->Render("body", "right", $t05_rkas04_grid->RowIndex);
?>
<script type="text/javascript">
ft05_rkas04grid.UpdateOpts(<?php echo $t05_rkas04_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t05_rkas04->CurrentMode == "add" || $t05_rkas04->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t05_rkas04_grid->FormKeyCountName ?>" id="<?php echo $t05_rkas04_grid->FormKeyCountName ?>" value="<?php echo $t05_rkas04_grid->KeyCount ?>">
<?php echo $t05_rkas04_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t05_rkas04->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t05_rkas04_grid->FormKeyCountName ?>" id="<?php echo $t05_rkas04_grid->FormKeyCountName ?>" value="<?php echo $t05_rkas04_grid->KeyCount ?>">
<?php echo $t05_rkas04_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t05_rkas04->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft05_rkas04grid">
</div>
<?php

// Close recordset
if ($t05_rkas04_grid->Recordset)
	$t05_rkas04_grid->Recordset->Close();
?>
<?php if ($t05_rkas04_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($t05_rkas04_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t05_rkas04_grid->TotalRecs == 0 && $t05_rkas04->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t05_rkas04_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t05_rkas04->Export == "") { ?>
<script type="text/javascript">
ft05_rkas04grid.Init();
</script>
<?php } ?>
<?php
$t05_rkas04_grid->Page_Terminate();
?>
