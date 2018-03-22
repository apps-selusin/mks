<?php include_once "t96_employeesinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t04_rkas03_grid)) $t04_rkas03_grid = new ct04_rkas03_grid();

// Page init
$t04_rkas03_grid->Page_Init();

// Page main
$t04_rkas03_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t04_rkas03_grid->Page_Render();
?>
<?php if ($t04_rkas03->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft04_rkas03grid = new ew_Form("ft04_rkas03grid", "grid");
ft04_rkas03grid.FormKeyCountName = '<?php echo $t04_rkas03_grid->FormKeyCountName ?>';

// Validate form
ft04_rkas03grid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_lv2_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t04_rkas03->lv2_id->FldCaption(), $t04_rkas03->lv2_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_no_urut");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t04_rkas03->no_urut->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_keterangan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t04_rkas03->keterangan->FldCaption(), $t04_rkas03->keterangan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t04_rkas03->jumlah->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft04_rkas03grid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "lv1_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "lv2_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "no_urut", false)) return false;
	if (ew_ValueChanged(fobj, infix, "keterangan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jumlah", false)) return false;
	return true;
}

// Form_CustomValidate event
ft04_rkas03grid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft04_rkas03grid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft04_rkas03grid.Lists["x_lv1_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_urut","x_keterangan","",""],"ParentFields":[],"ChildFields":["x_lv2_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t02_rkas01"};
ft04_rkas03grid.Lists["x_lv1_id"].Data = "<?php echo $t04_rkas03_grid->lv1_id->LookupFilterQuery(FALSE, "grid") ?>";
ft04_rkas03grid.AutoSuggests["x_lv1_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $t04_rkas03_grid->lv1_id->LookupFilterQuery(TRUE, "grid"))) ?>;
ft04_rkas03grid.Lists["x_lv2_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_urut","x_keterangan","",""],"ParentFields":["x_lv1_id"],"ChildFields":[],"FilterFields":["x_lv1_id"],"Options":[],"Template":"","LinkTable":"t03_rkas02"};
ft04_rkas03grid.Lists["x_lv2_id"].Data = "<?php echo $t04_rkas03_grid->lv2_id->LookupFilterQuery(FALSE, "grid") ?>";
ft04_rkas03grid.AutoSuggests["x_lv2_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $t04_rkas03_grid->lv2_id->LookupFilterQuery(TRUE, "grid"))) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($t04_rkas03->CurrentAction == "gridadd") {
	if ($t04_rkas03->CurrentMode == "copy") {
		$bSelectLimit = $t04_rkas03_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t04_rkas03_grid->TotalRecs = $t04_rkas03->ListRecordCount();
			$t04_rkas03_grid->Recordset = $t04_rkas03_grid->LoadRecordset($t04_rkas03_grid->StartRec-1, $t04_rkas03_grid->DisplayRecs);
		} else {
			if ($t04_rkas03_grid->Recordset = $t04_rkas03_grid->LoadRecordset())
				$t04_rkas03_grid->TotalRecs = $t04_rkas03_grid->Recordset->RecordCount();
		}
		$t04_rkas03_grid->StartRec = 1;
		$t04_rkas03_grid->DisplayRecs = $t04_rkas03_grid->TotalRecs;
	} else {
		$t04_rkas03->CurrentFilter = "0=1";
		$t04_rkas03_grid->StartRec = 1;
		$t04_rkas03_grid->DisplayRecs = $t04_rkas03->GridAddRowCount;
	}
	$t04_rkas03_grid->TotalRecs = $t04_rkas03_grid->DisplayRecs;
	$t04_rkas03_grid->StopRec = $t04_rkas03_grid->DisplayRecs;
} else {
	$bSelectLimit = $t04_rkas03_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t04_rkas03_grid->TotalRecs <= 0)
			$t04_rkas03_grid->TotalRecs = $t04_rkas03->ListRecordCount();
	} else {
		if (!$t04_rkas03_grid->Recordset && ($t04_rkas03_grid->Recordset = $t04_rkas03_grid->LoadRecordset()))
			$t04_rkas03_grid->TotalRecs = $t04_rkas03_grid->Recordset->RecordCount();
	}
	$t04_rkas03_grid->StartRec = 1;
	$t04_rkas03_grid->DisplayRecs = $t04_rkas03_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t04_rkas03_grid->Recordset = $t04_rkas03_grid->LoadRecordset($t04_rkas03_grid->StartRec-1, $t04_rkas03_grid->DisplayRecs);

	// Set no record found message
	if ($t04_rkas03->CurrentAction == "" && $t04_rkas03_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$t04_rkas03_grid->setWarningMessage(ew_DeniedMsg());
		if ($t04_rkas03_grid->SearchWhere == "0=101")
			$t04_rkas03_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t04_rkas03_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t04_rkas03_grid->RenderOtherOptions();
?>
<?php $t04_rkas03_grid->ShowPageHeader(); ?>
<?php
$t04_rkas03_grid->ShowMessage();
?>
<?php if ($t04_rkas03_grid->TotalRecs > 0 || $t04_rkas03->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t04_rkas03_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t04_rkas03">
<div id="ft04_rkas03grid" class="ewForm ewListForm form-inline">
<?php if ($t04_rkas03_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($t04_rkas03_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_t04_rkas03" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_t04_rkas03grid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t04_rkas03_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t04_rkas03_grid->RenderListOptions();

// Render list options (header, left)
$t04_rkas03_grid->ListOptions->Render("header", "left");
?>
<?php if ($t04_rkas03->lv1_id->Visible) { // lv1_id ?>
	<?php if ($t04_rkas03->SortUrl($t04_rkas03->lv1_id) == "") { ?>
		<th data-name="lv1_id" class="<?php echo $t04_rkas03->lv1_id->HeaderCellClass() ?>"><div id="elh_t04_rkas03_lv1_id" class="t04_rkas03_lv1_id"><div class="ewTableHeaderCaption"><?php echo $t04_rkas03->lv1_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lv1_id" class="<?php echo $t04_rkas03->lv1_id->HeaderCellClass() ?>"><div><div id="elh_t04_rkas03_lv1_id" class="t04_rkas03_lv1_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_rkas03->lv1_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_rkas03->lv1_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_rkas03->lv1_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_rkas03->lv2_id->Visible) { // lv2_id ?>
	<?php if ($t04_rkas03->SortUrl($t04_rkas03->lv2_id) == "") { ?>
		<th data-name="lv2_id" class="<?php echo $t04_rkas03->lv2_id->HeaderCellClass() ?>"><div id="elh_t04_rkas03_lv2_id" class="t04_rkas03_lv2_id"><div class="ewTableHeaderCaption"><?php echo $t04_rkas03->lv2_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lv2_id" class="<?php echo $t04_rkas03->lv2_id->HeaderCellClass() ?>"><div><div id="elh_t04_rkas03_lv2_id" class="t04_rkas03_lv2_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_rkas03->lv2_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_rkas03->lv2_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_rkas03->lv2_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_rkas03->no_urut->Visible) { // no_urut ?>
	<?php if ($t04_rkas03->SortUrl($t04_rkas03->no_urut) == "") { ?>
		<th data-name="no_urut" class="<?php echo $t04_rkas03->no_urut->HeaderCellClass() ?>"><div id="elh_t04_rkas03_no_urut" class="t04_rkas03_no_urut"><div class="ewTableHeaderCaption"><?php echo $t04_rkas03->no_urut->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_urut" class="<?php echo $t04_rkas03->no_urut->HeaderCellClass() ?>"><div><div id="elh_t04_rkas03_no_urut" class="t04_rkas03_no_urut">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_rkas03->no_urut->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_rkas03->no_urut->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_rkas03->no_urut->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_rkas03->keterangan->Visible) { // keterangan ?>
	<?php if ($t04_rkas03->SortUrl($t04_rkas03->keterangan) == "") { ?>
		<th data-name="keterangan" class="<?php echo $t04_rkas03->keterangan->HeaderCellClass() ?>"><div id="elh_t04_rkas03_keterangan" class="t04_rkas03_keterangan"><div class="ewTableHeaderCaption"><?php echo $t04_rkas03->keterangan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="keterangan" class="<?php echo $t04_rkas03->keterangan->HeaderCellClass() ?>"><div><div id="elh_t04_rkas03_keterangan" class="t04_rkas03_keterangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_rkas03->keterangan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_rkas03->keterangan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_rkas03->keterangan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t04_rkas03->jumlah->Visible) { // jumlah ?>
	<?php if ($t04_rkas03->SortUrl($t04_rkas03->jumlah) == "") { ?>
		<th data-name="jumlah" class="<?php echo $t04_rkas03->jumlah->HeaderCellClass() ?>"><div id="elh_t04_rkas03_jumlah" class="t04_rkas03_jumlah"><div class="ewTableHeaderCaption"><?php echo $t04_rkas03->jumlah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jumlah" class="<?php echo $t04_rkas03->jumlah->HeaderCellClass() ?>"><div><div id="elh_t04_rkas03_jumlah" class="t04_rkas03_jumlah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_rkas03->jumlah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_rkas03->jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_rkas03->jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t04_rkas03_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t04_rkas03_grid->StartRec = 1;
$t04_rkas03_grid->StopRec = $t04_rkas03_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t04_rkas03_grid->FormKeyCountName) && ($t04_rkas03->CurrentAction == "gridadd" || $t04_rkas03->CurrentAction == "gridedit" || $t04_rkas03->CurrentAction == "F")) {
		$t04_rkas03_grid->KeyCount = $objForm->GetValue($t04_rkas03_grid->FormKeyCountName);
		$t04_rkas03_grid->StopRec = $t04_rkas03_grid->StartRec + $t04_rkas03_grid->KeyCount - 1;
	}
}
$t04_rkas03_grid->RecCnt = $t04_rkas03_grid->StartRec - 1;
if ($t04_rkas03_grid->Recordset && !$t04_rkas03_grid->Recordset->EOF) {
	$t04_rkas03_grid->Recordset->MoveFirst();
	$bSelectLimit = $t04_rkas03_grid->UseSelectLimit;
	if (!$bSelectLimit && $t04_rkas03_grid->StartRec > 1)
		$t04_rkas03_grid->Recordset->Move($t04_rkas03_grid->StartRec - 1);
} elseif (!$t04_rkas03->AllowAddDeleteRow && $t04_rkas03_grid->StopRec == 0) {
	$t04_rkas03_grid->StopRec = $t04_rkas03->GridAddRowCount;
}

// Initialize aggregate
$t04_rkas03->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t04_rkas03->ResetAttrs();
$t04_rkas03_grid->RenderRow();
if ($t04_rkas03->CurrentAction == "gridadd")
	$t04_rkas03_grid->RowIndex = 0;
if ($t04_rkas03->CurrentAction == "gridedit")
	$t04_rkas03_grid->RowIndex = 0;
while ($t04_rkas03_grid->RecCnt < $t04_rkas03_grid->StopRec) {
	$t04_rkas03_grid->RecCnt++;
	if (intval($t04_rkas03_grid->RecCnt) >= intval($t04_rkas03_grid->StartRec)) {
		$t04_rkas03_grid->RowCnt++;
		if ($t04_rkas03->CurrentAction == "gridadd" || $t04_rkas03->CurrentAction == "gridedit" || $t04_rkas03->CurrentAction == "F") {
			$t04_rkas03_grid->RowIndex++;
			$objForm->Index = $t04_rkas03_grid->RowIndex;
			if ($objForm->HasValue($t04_rkas03_grid->FormActionName))
				$t04_rkas03_grid->RowAction = strval($objForm->GetValue($t04_rkas03_grid->FormActionName));
			elseif ($t04_rkas03->CurrentAction == "gridadd")
				$t04_rkas03_grid->RowAction = "insert";
			else
				$t04_rkas03_grid->RowAction = "";
		}

		// Set up key count
		$t04_rkas03_grid->KeyCount = $t04_rkas03_grid->RowIndex;

		// Init row class and style
		$t04_rkas03->ResetAttrs();
		$t04_rkas03->CssClass = "";
		if ($t04_rkas03->CurrentAction == "gridadd") {
			if ($t04_rkas03->CurrentMode == "copy") {
				$t04_rkas03_grid->LoadRowValues($t04_rkas03_grid->Recordset); // Load row values
				$t04_rkas03_grid->SetRecordKey($t04_rkas03_grid->RowOldKey, $t04_rkas03_grid->Recordset); // Set old record key
			} else {
				$t04_rkas03_grid->LoadRowValues(); // Load default values
				$t04_rkas03_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t04_rkas03_grid->LoadRowValues($t04_rkas03_grid->Recordset); // Load row values
		}
		$t04_rkas03->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t04_rkas03->CurrentAction == "gridadd") // Grid add
			$t04_rkas03->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t04_rkas03->CurrentAction == "gridadd" && $t04_rkas03->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t04_rkas03_grid->RestoreCurrentRowFormValues($t04_rkas03_grid->RowIndex); // Restore form values
		if ($t04_rkas03->CurrentAction == "gridedit") { // Grid edit
			if ($t04_rkas03->EventCancelled) {
				$t04_rkas03_grid->RestoreCurrentRowFormValues($t04_rkas03_grid->RowIndex); // Restore form values
			}
			if ($t04_rkas03_grid->RowAction == "insert")
				$t04_rkas03->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t04_rkas03->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t04_rkas03->CurrentAction == "gridedit" && ($t04_rkas03->RowType == EW_ROWTYPE_EDIT || $t04_rkas03->RowType == EW_ROWTYPE_ADD) && $t04_rkas03->EventCancelled) // Update failed
			$t04_rkas03_grid->RestoreCurrentRowFormValues($t04_rkas03_grid->RowIndex); // Restore form values
		if ($t04_rkas03->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t04_rkas03_grid->EditRowCnt++;
		if ($t04_rkas03->CurrentAction == "F") // Confirm row
			$t04_rkas03_grid->RestoreCurrentRowFormValues($t04_rkas03_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t04_rkas03->RowAttrs = array_merge($t04_rkas03->RowAttrs, array('data-rowindex'=>$t04_rkas03_grid->RowCnt, 'id'=>'r' . $t04_rkas03_grid->RowCnt . '_t04_rkas03', 'data-rowtype'=>$t04_rkas03->RowType));

		// Render row
		$t04_rkas03_grid->RenderRow();

		// Render list options
		$t04_rkas03_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t04_rkas03_grid->RowAction <> "delete" && $t04_rkas03_grid->RowAction <> "insertdelete" && !($t04_rkas03_grid->RowAction == "insert" && $t04_rkas03->CurrentAction == "F" && $t04_rkas03_grid->EmptyRow())) {
?>
	<tr<?php echo $t04_rkas03->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t04_rkas03_grid->ListOptions->Render("body", "left", $t04_rkas03_grid->RowCnt);
?>
	<?php if ($t04_rkas03->lv1_id->Visible) { // lv1_id ?>
		<td data-name="lv1_id"<?php echo $t04_rkas03->lv1_id->CellAttributes() ?>>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_lv1_id" class="form-group t04_rkas03_lv1_id">
<?php
$wrkonchange = trim("ew_UpdateOpt.call(this); " . @$t04_rkas03->lv1_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t04_rkas03->lv1_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t04_rkas03_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" id="sv_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" value="<?php echo $t04_rkas03->lv1_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->getPlaceHolder()) ?>"<?php echo $t04_rkas03->lv1_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t04_rkas03->lv1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft04_rkas03grid.CreateAutoSuggest({"id":"x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t04_rkas03->lv1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t04_rkas03->lv1_id->ReadOnly || $t04_rkas03->lv1_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv1_id" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->OldValue) ?>">
<?php } ?>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_lv1_id" class="form-group t04_rkas03_lv1_id">
<?php
$wrkonchange = trim("ew_UpdateOpt.call(this); " . @$t04_rkas03->lv1_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t04_rkas03->lv1_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t04_rkas03_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" id="sv_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" value="<?php echo $t04_rkas03->lv1_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->getPlaceHolder()) ?>"<?php echo $t04_rkas03->lv1_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t04_rkas03->lv1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft04_rkas03grid.CreateAutoSuggest({"id":"x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t04_rkas03->lv1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t04_rkas03->lv1_id->ReadOnly || $t04_rkas03->lv1_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } ?>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_lv1_id" class="t04_rkas03_lv1_id">
<span<?php echo $t04_rkas03->lv1_id->ViewAttributes() ?>>
<?php echo $t04_rkas03->lv1_id->ListViewValue() ?></span>
</span>
<?php if ($t04_rkas03->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv1_id" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->FormValue) ?>">
<input type="hidden" data-table="t04_rkas03" data-field="x_lv1_id" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv1_id" name="ft04_rkas03grid$x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" id="ft04_rkas03grid$x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->FormValue) ?>">
<input type="hidden" data-table="t04_rkas03" data-field="x_lv1_id" name="ft04_rkas03grid$o<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" id="ft04_rkas03grid$o<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_id" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_id" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t04_rkas03->id->CurrentValue) ?>">
<input type="hidden" data-table="t04_rkas03" data-field="x_id" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_id" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t04_rkas03->id->OldValue) ?>">
<?php } ?>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_EDIT || $t04_rkas03->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_id" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_id" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t04_rkas03->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t04_rkas03->lv2_id->Visible) { // lv2_id ?>
		<td data-name="lv2_id"<?php echo $t04_rkas03->lv2_id->CellAttributes() ?>>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t04_rkas03->lv2_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_lv2_id" class="form-group t04_rkas03_lv2_id">
<span<?php echo $t04_rkas03->lv2_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_rkas03->lv2_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_lv2_id" class="form-group t04_rkas03_lv2_id">
<?php
$wrkonchange = trim(" " . @$t04_rkas03->lv2_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t04_rkas03->lv2_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t04_rkas03_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" id="sv_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo $t04_rkas03->lv2_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->getPlaceHolder()) ?>"<?php echo $t04_rkas03->lv2_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv2_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t04_rkas03->lv2_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft04_rkas03grid.CreateAutoSuggest({"id":"x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t04_rkas03->lv2_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t04_rkas03->lv2_id->ReadOnly || $t04_rkas03->lv2_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv2_id" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->OldValue) ?>">
<?php } ?>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t04_rkas03->lv2_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_lv2_id" class="form-group t04_rkas03_lv2_id">
<span<?php echo $t04_rkas03->lv2_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_rkas03->lv2_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_lv2_id" class="form-group t04_rkas03_lv2_id">
<?php
$wrkonchange = trim(" " . @$t04_rkas03->lv2_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t04_rkas03->lv2_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t04_rkas03_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" id="sv_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo $t04_rkas03->lv2_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->getPlaceHolder()) ?>"<?php echo $t04_rkas03->lv2_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv2_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t04_rkas03->lv2_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft04_rkas03grid.CreateAutoSuggest({"id":"x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t04_rkas03->lv2_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t04_rkas03->lv2_id->ReadOnly || $t04_rkas03->lv2_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } ?>
<?php } ?>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_lv2_id" class="t04_rkas03_lv2_id">
<span<?php echo $t04_rkas03->lv2_id->ViewAttributes() ?>>
<?php echo $t04_rkas03->lv2_id->ListViewValue() ?></span>
</span>
<?php if ($t04_rkas03->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv2_id" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->FormValue) ?>">
<input type="hidden" data-table="t04_rkas03" data-field="x_lv2_id" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv2_id" name="ft04_rkas03grid$x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" id="ft04_rkas03grid$x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->FormValue) ?>">
<input type="hidden" data-table="t04_rkas03" data-field="x_lv2_id" name="ft04_rkas03grid$o<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" id="ft04_rkas03grid$o<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t04_rkas03->no_urut->Visible) { // no_urut ?>
		<td data-name="no_urut"<?php echo $t04_rkas03->no_urut->CellAttributes() ?>>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_no_urut" class="form-group t04_rkas03_no_urut">
<input type="text" data-table="t04_rkas03" data-field="x_no_urut" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" size="30" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->no_urut->getPlaceHolder()) ?>" value="<?php echo $t04_rkas03->no_urut->EditValue ?>"<?php echo $t04_rkas03->no_urut->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_no_urut" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t04_rkas03->no_urut->OldValue) ?>">
<?php } ?>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_no_urut" class="form-group t04_rkas03_no_urut">
<input type="text" data-table="t04_rkas03" data-field="x_no_urut" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" size="30" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->no_urut->getPlaceHolder()) ?>" value="<?php echo $t04_rkas03->no_urut->EditValue ?>"<?php echo $t04_rkas03->no_urut->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_no_urut" class="t04_rkas03_no_urut">
<span<?php echo $t04_rkas03->no_urut->ViewAttributes() ?>>
<?php echo $t04_rkas03->no_urut->ListViewValue() ?></span>
</span>
<?php if ($t04_rkas03->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_no_urut" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t04_rkas03->no_urut->FormValue) ?>">
<input type="hidden" data-table="t04_rkas03" data-field="x_no_urut" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t04_rkas03->no_urut->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_no_urut" name="ft04_rkas03grid$x<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" id="ft04_rkas03grid$x<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t04_rkas03->no_urut->FormValue) ?>">
<input type="hidden" data-table="t04_rkas03" data-field="x_no_urut" name="ft04_rkas03grid$o<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" id="ft04_rkas03grid$o<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t04_rkas03->no_urut->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t04_rkas03->keterangan->Visible) { // keterangan ?>
		<td data-name="keterangan"<?php echo $t04_rkas03->keterangan->CellAttributes() ?>>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_keterangan" class="form-group t04_rkas03_keterangan">
<input type="text" data-table="t04_rkas03" data-field="x_keterangan" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->keterangan->getPlaceHolder()) ?>" value="<?php echo $t04_rkas03->keterangan->EditValue ?>"<?php echo $t04_rkas03->keterangan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_keterangan" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t04_rkas03->keterangan->OldValue) ?>">
<?php } ?>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_keterangan" class="form-group t04_rkas03_keterangan">
<input type="text" data-table="t04_rkas03" data-field="x_keterangan" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->keterangan->getPlaceHolder()) ?>" value="<?php echo $t04_rkas03->keterangan->EditValue ?>"<?php echo $t04_rkas03->keterangan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_keterangan" class="t04_rkas03_keterangan">
<span<?php echo $t04_rkas03->keterangan->ViewAttributes() ?>>
<?php echo $t04_rkas03->keterangan->ListViewValue() ?></span>
</span>
<?php if ($t04_rkas03->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_keterangan" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t04_rkas03->keterangan->FormValue) ?>">
<input type="hidden" data-table="t04_rkas03" data-field="x_keterangan" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t04_rkas03->keterangan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_keterangan" name="ft04_rkas03grid$x<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" id="ft04_rkas03grid$x<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t04_rkas03->keterangan->FormValue) ?>">
<input type="hidden" data-table="t04_rkas03" data-field="x_keterangan" name="ft04_rkas03grid$o<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" id="ft04_rkas03grid$o<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t04_rkas03->keterangan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t04_rkas03->jumlah->Visible) { // jumlah ?>
		<td data-name="jumlah"<?php echo $t04_rkas03->jumlah->CellAttributes() ?>>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_jumlah" class="form-group t04_rkas03_jumlah">
<input type="text" data-table="t04_rkas03" data-field="x_jumlah" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->jumlah->getPlaceHolder()) ?>" value="<?php echo $t04_rkas03->jumlah->EditValue ?>"<?php echo $t04_rkas03->jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_jumlah" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t04_rkas03->jumlah->OldValue) ?>">
<?php } ?>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_jumlah" class="form-group t04_rkas03_jumlah">
<input type="text" data-table="t04_rkas03" data-field="x_jumlah" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->jumlah->getPlaceHolder()) ?>" value="<?php echo $t04_rkas03->jumlah->EditValue ?>"<?php echo $t04_rkas03->jumlah->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_rkas03_grid->RowCnt ?>_t04_rkas03_jumlah" class="t04_rkas03_jumlah">
<span<?php echo $t04_rkas03->jumlah->ViewAttributes() ?>>
<?php echo $t04_rkas03->jumlah->ListViewValue() ?></span>
</span>
<?php if ($t04_rkas03->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_jumlah" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t04_rkas03->jumlah->FormValue) ?>">
<input type="hidden" data-table="t04_rkas03" data-field="x_jumlah" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t04_rkas03->jumlah->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_jumlah" name="ft04_rkas03grid$x<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" id="ft04_rkas03grid$x<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t04_rkas03->jumlah->FormValue) ?>">
<input type="hidden" data-table="t04_rkas03" data-field="x_jumlah" name="ft04_rkas03grid$o<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" id="ft04_rkas03grid$o<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t04_rkas03->jumlah->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t04_rkas03_grid->ListOptions->Render("body", "right", $t04_rkas03_grid->RowCnt);
?>
	</tr>
<?php if ($t04_rkas03->RowType == EW_ROWTYPE_ADD || $t04_rkas03->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft04_rkas03grid.UpdateOpts(<?php echo $t04_rkas03_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t04_rkas03->CurrentAction <> "gridadd" || $t04_rkas03->CurrentMode == "copy")
		if (!$t04_rkas03_grid->Recordset->EOF) $t04_rkas03_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t04_rkas03->CurrentMode == "add" || $t04_rkas03->CurrentMode == "copy" || $t04_rkas03->CurrentMode == "edit") {
		$t04_rkas03_grid->RowIndex = '$rowindex$';
		$t04_rkas03_grid->LoadRowValues();

		// Set row properties
		$t04_rkas03->ResetAttrs();
		$t04_rkas03->RowAttrs = array_merge($t04_rkas03->RowAttrs, array('data-rowindex'=>$t04_rkas03_grid->RowIndex, 'id'=>'r0_t04_rkas03', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t04_rkas03->RowAttrs["class"], "ewTemplate");
		$t04_rkas03->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t04_rkas03_grid->RenderRow();

		// Render list options
		$t04_rkas03_grid->RenderListOptions();
		$t04_rkas03_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t04_rkas03->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t04_rkas03_grid->ListOptions->Render("body", "left", $t04_rkas03_grid->RowIndex);
?>
	<?php if ($t04_rkas03->lv1_id->Visible) { // lv1_id ?>
		<td data-name="lv1_id">
<?php if ($t04_rkas03->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t04_rkas03_lv1_id" class="form-group t04_rkas03_lv1_id">
<?php
$wrkonchange = trim("ew_UpdateOpt.call(this); " . @$t04_rkas03->lv1_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t04_rkas03->lv1_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t04_rkas03_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" id="sv_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" value="<?php echo $t04_rkas03->lv1_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->getPlaceHolder()) ?>"<?php echo $t04_rkas03->lv1_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t04_rkas03->lv1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft04_rkas03grid.CreateAutoSuggest({"id":"x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t04_rkas03->lv1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t04_rkas03->lv1_id->ReadOnly || $t04_rkas03->lv1_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } else { ?>
<span id="el$rowindex$_t04_rkas03_lv1_id" class="form-group t04_rkas03_lv1_id">
<span<?php echo $t04_rkas03->lv1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_rkas03->lv1_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv1_id" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv1_id" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv1_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t04_rkas03->lv2_id->Visible) { // lv2_id ?>
		<td data-name="lv2_id">
<?php if ($t04_rkas03->CurrentAction <> "F") { ?>
<?php if ($t04_rkas03->lv2_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t04_rkas03_lv2_id" class="form-group t04_rkas03_lv2_id">
<span<?php echo $t04_rkas03->lv2_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_rkas03->lv2_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t04_rkas03_lv2_id" class="form-group t04_rkas03_lv2_id">
<?php
$wrkonchange = trim(" " . @$t04_rkas03->lv2_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t04_rkas03->lv2_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t04_rkas03_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" id="sv_x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo $t04_rkas03->lv2_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->getPlaceHolder()) ?>"<?php echo $t04_rkas03->lv2_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv2_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t04_rkas03->lv2_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft04_rkas03grid.CreateAutoSuggest({"id":"x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t04_rkas03->lv2_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t04_rkas03->lv2_id->ReadOnly || $t04_rkas03->lv2_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t04_rkas03_lv2_id" class="form-group t04_rkas03_lv2_id">
<span<?php echo $t04_rkas03->lv2_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_rkas03->lv2_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv2_id" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_lv2_id" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_lv2_id" value="<?php echo ew_HtmlEncode($t04_rkas03->lv2_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t04_rkas03->no_urut->Visible) { // no_urut ?>
		<td data-name="no_urut">
<?php if ($t04_rkas03->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t04_rkas03_no_urut" class="form-group t04_rkas03_no_urut">
<input type="text" data-table="t04_rkas03" data-field="x_no_urut" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" size="30" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->no_urut->getPlaceHolder()) ?>" value="<?php echo $t04_rkas03->no_urut->EditValue ?>"<?php echo $t04_rkas03->no_urut->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t04_rkas03_no_urut" class="form-group t04_rkas03_no_urut">
<span<?php echo $t04_rkas03->no_urut->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_rkas03->no_urut->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_no_urut" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t04_rkas03->no_urut->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_no_urut" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t04_rkas03->no_urut->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t04_rkas03->keterangan->Visible) { // keterangan ?>
		<td data-name="keterangan">
<?php if ($t04_rkas03->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t04_rkas03_keterangan" class="form-group t04_rkas03_keterangan">
<input type="text" data-table="t04_rkas03" data-field="x_keterangan" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->keterangan->getPlaceHolder()) ?>" value="<?php echo $t04_rkas03->keterangan->EditValue ?>"<?php echo $t04_rkas03->keterangan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t04_rkas03_keterangan" class="form-group t04_rkas03_keterangan">
<span<?php echo $t04_rkas03->keterangan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_rkas03->keterangan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_keterangan" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t04_rkas03->keterangan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_keterangan" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t04_rkas03->keterangan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t04_rkas03->jumlah->Visible) { // jumlah ?>
		<td data-name="jumlah">
<?php if ($t04_rkas03->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t04_rkas03_jumlah" class="form-group t04_rkas03_jumlah">
<input type="text" data-table="t04_rkas03" data-field="x_jumlah" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t04_rkas03->jumlah->getPlaceHolder()) ?>" value="<?php echo $t04_rkas03->jumlah->EditValue ?>"<?php echo $t04_rkas03->jumlah->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t04_rkas03_jumlah" class="form-group t04_rkas03_jumlah">
<span<?php echo $t04_rkas03->jumlah->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_rkas03->jumlah->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_rkas03" data-field="x_jumlah" name="x<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" id="x<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t04_rkas03->jumlah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_rkas03" data-field="x_jumlah" name="o<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" id="o<?php echo $t04_rkas03_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t04_rkas03->jumlah->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t04_rkas03_grid->ListOptions->Render("body", "right", $t04_rkas03_grid->RowIndex);
?>
<script type="text/javascript">
ft04_rkas03grid.UpdateOpts(<?php echo $t04_rkas03_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t04_rkas03->CurrentMode == "add" || $t04_rkas03->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t04_rkas03_grid->FormKeyCountName ?>" id="<?php echo $t04_rkas03_grid->FormKeyCountName ?>" value="<?php echo $t04_rkas03_grid->KeyCount ?>">
<?php echo $t04_rkas03_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t04_rkas03->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t04_rkas03_grid->FormKeyCountName ?>" id="<?php echo $t04_rkas03_grid->FormKeyCountName ?>" value="<?php echo $t04_rkas03_grid->KeyCount ?>">
<?php echo $t04_rkas03_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t04_rkas03->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft04_rkas03grid">
</div>
<?php

// Close recordset
if ($t04_rkas03_grid->Recordset)
	$t04_rkas03_grid->Recordset->Close();
?>
<?php if ($t04_rkas03_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($t04_rkas03_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t04_rkas03_grid->TotalRecs == 0 && $t04_rkas03->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t04_rkas03_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t04_rkas03->Export == "") { ?>
<script type="text/javascript">
ft04_rkas03grid.Init();
</script>
<?php } ?>
<?php
$t04_rkas03_grid->Page_Terminate();
?>
