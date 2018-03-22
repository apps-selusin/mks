<?php include_once "t96_employeesinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t03_rkas02_grid)) $t03_rkas02_grid = new ct03_rkas02_grid();

// Page init
$t03_rkas02_grid->Page_Init();

// Page main
$t03_rkas02_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t03_rkas02_grid->Page_Render();
?>
<?php if ($t03_rkas02->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft03_rkas02grid = new ew_Form("ft03_rkas02grid", "grid");
ft03_rkas02grid.FormKeyCountName = '<?php echo $t03_rkas02_grid->FormKeyCountName ?>';

// Validate form
ft03_rkas02grid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_lv1_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_rkas02->lv1_id->FldCaption(), $t03_rkas02->lv1_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_no_urut");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_rkas02->no_urut->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_keterangan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_rkas02->keterangan->FldCaption(), $t03_rkas02->keterangan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t03_rkas02->jumlah->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft03_rkas02grid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "lv1_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "no_urut", false)) return false;
	if (ew_ValueChanged(fobj, infix, "keterangan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jumlah", false)) return false;
	return true;
}

// Form_CustomValidate event
ft03_rkas02grid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft03_rkas02grid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft03_rkas02grid.Lists["x_lv1_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_urut","x_keterangan","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t02_rkas01"};
ft03_rkas02grid.Lists["x_lv1_id"].Data = "<?php echo $t03_rkas02_grid->lv1_id->LookupFilterQuery(FALSE, "grid") ?>";
ft03_rkas02grid.AutoSuggests["x_lv1_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $t03_rkas02_grid->lv1_id->LookupFilterQuery(TRUE, "grid"))) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($t03_rkas02->CurrentAction == "gridadd") {
	if ($t03_rkas02->CurrentMode == "copy") {
		$bSelectLimit = $t03_rkas02_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t03_rkas02_grid->TotalRecs = $t03_rkas02->ListRecordCount();
			$t03_rkas02_grid->Recordset = $t03_rkas02_grid->LoadRecordset($t03_rkas02_grid->StartRec-1, $t03_rkas02_grid->DisplayRecs);
		} else {
			if ($t03_rkas02_grid->Recordset = $t03_rkas02_grid->LoadRecordset())
				$t03_rkas02_grid->TotalRecs = $t03_rkas02_grid->Recordset->RecordCount();
		}
		$t03_rkas02_grid->StartRec = 1;
		$t03_rkas02_grid->DisplayRecs = $t03_rkas02_grid->TotalRecs;
	} else {
		$t03_rkas02->CurrentFilter = "0=1";
		$t03_rkas02_grid->StartRec = 1;
		$t03_rkas02_grid->DisplayRecs = $t03_rkas02->GridAddRowCount;
	}
	$t03_rkas02_grid->TotalRecs = $t03_rkas02_grid->DisplayRecs;
	$t03_rkas02_grid->StopRec = $t03_rkas02_grid->DisplayRecs;
} else {
	$bSelectLimit = $t03_rkas02_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t03_rkas02_grid->TotalRecs <= 0)
			$t03_rkas02_grid->TotalRecs = $t03_rkas02->ListRecordCount();
	} else {
		if (!$t03_rkas02_grid->Recordset && ($t03_rkas02_grid->Recordset = $t03_rkas02_grid->LoadRecordset()))
			$t03_rkas02_grid->TotalRecs = $t03_rkas02_grid->Recordset->RecordCount();
	}
	$t03_rkas02_grid->StartRec = 1;
	$t03_rkas02_grid->DisplayRecs = $t03_rkas02_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t03_rkas02_grid->Recordset = $t03_rkas02_grid->LoadRecordset($t03_rkas02_grid->StartRec-1, $t03_rkas02_grid->DisplayRecs);

	// Set no record found message
	if ($t03_rkas02->CurrentAction == "" && $t03_rkas02_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$t03_rkas02_grid->setWarningMessage(ew_DeniedMsg());
		if ($t03_rkas02_grid->SearchWhere == "0=101")
			$t03_rkas02_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t03_rkas02_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t03_rkas02_grid->RenderOtherOptions();
?>
<?php $t03_rkas02_grid->ShowPageHeader(); ?>
<?php
$t03_rkas02_grid->ShowMessage();
?>
<?php if ($t03_rkas02_grid->TotalRecs > 0 || $t03_rkas02->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t03_rkas02_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t03_rkas02">
<div id="ft03_rkas02grid" class="ewForm ewListForm form-inline">
<?php if ($t03_rkas02_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($t03_rkas02_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_t03_rkas02" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_t03_rkas02grid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t03_rkas02_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t03_rkas02_grid->RenderListOptions();

// Render list options (header, left)
$t03_rkas02_grid->ListOptions->Render("header", "left");
?>
<?php if ($t03_rkas02->lv1_id->Visible) { // lv1_id ?>
	<?php if ($t03_rkas02->SortUrl($t03_rkas02->lv1_id) == "") { ?>
		<th data-name="lv1_id" class="<?php echo $t03_rkas02->lv1_id->HeaderCellClass() ?>"><div id="elh_t03_rkas02_lv1_id" class="t03_rkas02_lv1_id"><div class="ewTableHeaderCaption"><?php echo $t03_rkas02->lv1_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lv1_id" class="<?php echo $t03_rkas02->lv1_id->HeaderCellClass() ?>"><div><div id="elh_t03_rkas02_lv1_id" class="t03_rkas02_lv1_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_rkas02->lv1_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_rkas02->lv1_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_rkas02->lv1_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_rkas02->no_urut->Visible) { // no_urut ?>
	<?php if ($t03_rkas02->SortUrl($t03_rkas02->no_urut) == "") { ?>
		<th data-name="no_urut" class="<?php echo $t03_rkas02->no_urut->HeaderCellClass() ?>"><div id="elh_t03_rkas02_no_urut" class="t03_rkas02_no_urut"><div class="ewTableHeaderCaption"><?php echo $t03_rkas02->no_urut->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_urut" class="<?php echo $t03_rkas02->no_urut->HeaderCellClass() ?>"><div><div id="elh_t03_rkas02_no_urut" class="t03_rkas02_no_urut">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_rkas02->no_urut->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_rkas02->no_urut->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_rkas02->no_urut->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_rkas02->keterangan->Visible) { // keterangan ?>
	<?php if ($t03_rkas02->SortUrl($t03_rkas02->keterangan) == "") { ?>
		<th data-name="keterangan" class="<?php echo $t03_rkas02->keterangan->HeaderCellClass() ?>"><div id="elh_t03_rkas02_keterangan" class="t03_rkas02_keterangan"><div class="ewTableHeaderCaption"><?php echo $t03_rkas02->keterangan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="keterangan" class="<?php echo $t03_rkas02->keterangan->HeaderCellClass() ?>"><div><div id="elh_t03_rkas02_keterangan" class="t03_rkas02_keterangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_rkas02->keterangan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_rkas02->keterangan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_rkas02->keterangan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t03_rkas02->jumlah->Visible) { // jumlah ?>
	<?php if ($t03_rkas02->SortUrl($t03_rkas02->jumlah) == "") { ?>
		<th data-name="jumlah" class="<?php echo $t03_rkas02->jumlah->HeaderCellClass() ?>"><div id="elh_t03_rkas02_jumlah" class="t03_rkas02_jumlah"><div class="ewTableHeaderCaption"><?php echo $t03_rkas02->jumlah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jumlah" class="<?php echo $t03_rkas02->jumlah->HeaderCellClass() ?>"><div><div id="elh_t03_rkas02_jumlah" class="t03_rkas02_jumlah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_rkas02->jumlah->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_rkas02->jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_rkas02->jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t03_rkas02_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t03_rkas02_grid->StartRec = 1;
$t03_rkas02_grid->StopRec = $t03_rkas02_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t03_rkas02_grid->FormKeyCountName) && ($t03_rkas02->CurrentAction == "gridadd" || $t03_rkas02->CurrentAction == "gridedit" || $t03_rkas02->CurrentAction == "F")) {
		$t03_rkas02_grid->KeyCount = $objForm->GetValue($t03_rkas02_grid->FormKeyCountName);
		$t03_rkas02_grid->StopRec = $t03_rkas02_grid->StartRec + $t03_rkas02_grid->KeyCount - 1;
	}
}
$t03_rkas02_grid->RecCnt = $t03_rkas02_grid->StartRec - 1;
if ($t03_rkas02_grid->Recordset && !$t03_rkas02_grid->Recordset->EOF) {
	$t03_rkas02_grid->Recordset->MoveFirst();
	$bSelectLimit = $t03_rkas02_grid->UseSelectLimit;
	if (!$bSelectLimit && $t03_rkas02_grid->StartRec > 1)
		$t03_rkas02_grid->Recordset->Move($t03_rkas02_grid->StartRec - 1);
} elseif (!$t03_rkas02->AllowAddDeleteRow && $t03_rkas02_grid->StopRec == 0) {
	$t03_rkas02_grid->StopRec = $t03_rkas02->GridAddRowCount;
}

// Initialize aggregate
$t03_rkas02->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t03_rkas02->ResetAttrs();
$t03_rkas02_grid->RenderRow();
if ($t03_rkas02->CurrentAction == "gridadd")
	$t03_rkas02_grid->RowIndex = 0;
if ($t03_rkas02->CurrentAction == "gridedit")
	$t03_rkas02_grid->RowIndex = 0;
while ($t03_rkas02_grid->RecCnt < $t03_rkas02_grid->StopRec) {
	$t03_rkas02_grid->RecCnt++;
	if (intval($t03_rkas02_grid->RecCnt) >= intval($t03_rkas02_grid->StartRec)) {
		$t03_rkas02_grid->RowCnt++;
		if ($t03_rkas02->CurrentAction == "gridadd" || $t03_rkas02->CurrentAction == "gridedit" || $t03_rkas02->CurrentAction == "F") {
			$t03_rkas02_grid->RowIndex++;
			$objForm->Index = $t03_rkas02_grid->RowIndex;
			if ($objForm->HasValue($t03_rkas02_grid->FormActionName))
				$t03_rkas02_grid->RowAction = strval($objForm->GetValue($t03_rkas02_grid->FormActionName));
			elseif ($t03_rkas02->CurrentAction == "gridadd")
				$t03_rkas02_grid->RowAction = "insert";
			else
				$t03_rkas02_grid->RowAction = "";
		}

		// Set up key count
		$t03_rkas02_grid->KeyCount = $t03_rkas02_grid->RowIndex;

		// Init row class and style
		$t03_rkas02->ResetAttrs();
		$t03_rkas02->CssClass = "";
		if ($t03_rkas02->CurrentAction == "gridadd") {
			if ($t03_rkas02->CurrentMode == "copy") {
				$t03_rkas02_grid->LoadRowValues($t03_rkas02_grid->Recordset); // Load row values
				$t03_rkas02_grid->SetRecordKey($t03_rkas02_grid->RowOldKey, $t03_rkas02_grid->Recordset); // Set old record key
			} else {
				$t03_rkas02_grid->LoadRowValues(); // Load default values
				$t03_rkas02_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t03_rkas02_grid->LoadRowValues($t03_rkas02_grid->Recordset); // Load row values
		}
		$t03_rkas02->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t03_rkas02->CurrentAction == "gridadd") // Grid add
			$t03_rkas02->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t03_rkas02->CurrentAction == "gridadd" && $t03_rkas02->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t03_rkas02_grid->RestoreCurrentRowFormValues($t03_rkas02_grid->RowIndex); // Restore form values
		if ($t03_rkas02->CurrentAction == "gridedit") { // Grid edit
			if ($t03_rkas02->EventCancelled) {
				$t03_rkas02_grid->RestoreCurrentRowFormValues($t03_rkas02_grid->RowIndex); // Restore form values
			}
			if ($t03_rkas02_grid->RowAction == "insert")
				$t03_rkas02->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t03_rkas02->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t03_rkas02->CurrentAction == "gridedit" && ($t03_rkas02->RowType == EW_ROWTYPE_EDIT || $t03_rkas02->RowType == EW_ROWTYPE_ADD) && $t03_rkas02->EventCancelled) // Update failed
			$t03_rkas02_grid->RestoreCurrentRowFormValues($t03_rkas02_grid->RowIndex); // Restore form values
		if ($t03_rkas02->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t03_rkas02_grid->EditRowCnt++;
		if ($t03_rkas02->CurrentAction == "F") // Confirm row
			$t03_rkas02_grid->RestoreCurrentRowFormValues($t03_rkas02_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t03_rkas02->RowAttrs = array_merge($t03_rkas02->RowAttrs, array('data-rowindex'=>$t03_rkas02_grid->RowCnt, 'id'=>'r' . $t03_rkas02_grid->RowCnt . '_t03_rkas02', 'data-rowtype'=>$t03_rkas02->RowType));

		// Render row
		$t03_rkas02_grid->RenderRow();

		// Render list options
		$t03_rkas02_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t03_rkas02_grid->RowAction <> "delete" && $t03_rkas02_grid->RowAction <> "insertdelete" && !($t03_rkas02_grid->RowAction == "insert" && $t03_rkas02->CurrentAction == "F" && $t03_rkas02_grid->EmptyRow())) {
?>
	<tr<?php echo $t03_rkas02->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t03_rkas02_grid->ListOptions->Render("body", "left", $t03_rkas02_grid->RowCnt);
?>
	<?php if ($t03_rkas02->lv1_id->Visible) { // lv1_id ?>
		<td data-name="lv1_id"<?php echo $t03_rkas02->lv1_id->CellAttributes() ?>>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t03_rkas02->lv1_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t03_rkas02_grid->RowCnt ?>_t03_rkas02_lv1_id" class="form-group t03_rkas02_lv1_id">
<span<?php echo $t03_rkas02->lv1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t03_rkas02->lv1_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t03_rkas02_grid->RowCnt ?>_t03_rkas02_lv1_id" class="form-group t03_rkas02_lv1_id">
<?php
$wrkonchange = trim(" " . @$t03_rkas02->lv1_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t03_rkas02->lv1_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t03_rkas02_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" id="sv_x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo $t03_rkas02->lv1_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->getPlaceHolder()) ?>"<?php echo $t03_rkas02->lv1_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rkas02" data-field="x_lv1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t03_rkas02->lv1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft03_rkas02grid.CreateAutoSuggest({"id":"x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t03_rkas02->lv1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t03_rkas02->lv1_id->ReadOnly || $t03_rkas02->lv1_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_lv1_id" name="o<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" id="o<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->OldValue) ?>">
<?php } ?>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t03_rkas02->lv1_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t03_rkas02_grid->RowCnt ?>_t03_rkas02_lv1_id" class="form-group t03_rkas02_lv1_id">
<span<?php echo $t03_rkas02->lv1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t03_rkas02->lv1_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t03_rkas02_grid->RowCnt ?>_t03_rkas02_lv1_id" class="form-group t03_rkas02_lv1_id">
<?php
$wrkonchange = trim(" " . @$t03_rkas02->lv1_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t03_rkas02->lv1_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t03_rkas02_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" id="sv_x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo $t03_rkas02->lv1_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->getPlaceHolder()) ?>"<?php echo $t03_rkas02->lv1_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rkas02" data-field="x_lv1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t03_rkas02->lv1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft03_rkas02grid.CreateAutoSuggest({"id":"x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t03_rkas02->lv1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t03_rkas02->lv1_id->ReadOnly || $t03_rkas02->lv1_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } ?>
<?php } ?>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_rkas02_grid->RowCnt ?>_t03_rkas02_lv1_id" class="t03_rkas02_lv1_id">
<span<?php echo $t03_rkas02->lv1_id->ViewAttributes() ?>>
<?php echo $t03_rkas02->lv1_id->ListViewValue() ?></span>
</span>
<?php if ($t03_rkas02->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_lv1_id" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->FormValue) ?>">
<input type="hidden" data-table="t03_rkas02" data-field="x_lv1_id" name="o<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" id="o<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_lv1_id" name="ft03_rkas02grid$x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" id="ft03_rkas02grid$x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->FormValue) ?>">
<input type="hidden" data-table="t03_rkas02" data-field="x_lv1_id" name="ft03_rkas02grid$o<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" id="ft03_rkas02grid$o<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_id" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_id" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_rkas02->id->CurrentValue) ?>">
<input type="hidden" data-table="t03_rkas02" data-field="x_id" name="o<?php echo $t03_rkas02_grid->RowIndex ?>_id" id="o<?php echo $t03_rkas02_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_rkas02->id->OldValue) ?>">
<?php } ?>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_EDIT || $t03_rkas02->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_id" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_id" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_rkas02->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t03_rkas02->no_urut->Visible) { // no_urut ?>
		<td data-name="no_urut"<?php echo $t03_rkas02->no_urut->CellAttributes() ?>>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_rkas02_grid->RowCnt ?>_t03_rkas02_no_urut" class="form-group t03_rkas02_no_urut">
<input type="text" data-table="t03_rkas02" data-field="x_no_urut" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rkas02->no_urut->getPlaceHolder()) ?>" value="<?php echo $t03_rkas02->no_urut->EditValue ?>"<?php echo $t03_rkas02->no_urut->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rkas02" data-field="x_no_urut" name="o<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" id="o<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t03_rkas02->no_urut->OldValue) ?>">
<?php } ?>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_rkas02_grid->RowCnt ?>_t03_rkas02_no_urut" class="form-group t03_rkas02_no_urut">
<input type="text" data-table="t03_rkas02" data-field="x_no_urut" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rkas02->no_urut->getPlaceHolder()) ?>" value="<?php echo $t03_rkas02->no_urut->EditValue ?>"<?php echo $t03_rkas02->no_urut->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_rkas02_grid->RowCnt ?>_t03_rkas02_no_urut" class="t03_rkas02_no_urut">
<span<?php echo $t03_rkas02->no_urut->ViewAttributes() ?>>
<?php echo $t03_rkas02->no_urut->ListViewValue() ?></span>
</span>
<?php if ($t03_rkas02->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_no_urut" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t03_rkas02->no_urut->FormValue) ?>">
<input type="hidden" data-table="t03_rkas02" data-field="x_no_urut" name="o<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" id="o<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t03_rkas02->no_urut->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_no_urut" name="ft03_rkas02grid$x<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" id="ft03_rkas02grid$x<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t03_rkas02->no_urut->FormValue) ?>">
<input type="hidden" data-table="t03_rkas02" data-field="x_no_urut" name="ft03_rkas02grid$o<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" id="ft03_rkas02grid$o<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t03_rkas02->no_urut->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_rkas02->keterangan->Visible) { // keterangan ?>
		<td data-name="keterangan"<?php echo $t03_rkas02->keterangan->CellAttributes() ?>>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_rkas02_grid->RowCnt ?>_t03_rkas02_keterangan" class="form-group t03_rkas02_keterangan">
<input type="text" data-table="t03_rkas02" data-field="x_keterangan" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t03_rkas02->keterangan->getPlaceHolder()) ?>" value="<?php echo $t03_rkas02->keterangan->EditValue ?>"<?php echo $t03_rkas02->keterangan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rkas02" data-field="x_keterangan" name="o<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" id="o<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t03_rkas02->keterangan->OldValue) ?>">
<?php } ?>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_rkas02_grid->RowCnt ?>_t03_rkas02_keterangan" class="form-group t03_rkas02_keterangan">
<input type="text" data-table="t03_rkas02" data-field="x_keterangan" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t03_rkas02->keterangan->getPlaceHolder()) ?>" value="<?php echo $t03_rkas02->keterangan->EditValue ?>"<?php echo $t03_rkas02->keterangan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_rkas02_grid->RowCnt ?>_t03_rkas02_keterangan" class="t03_rkas02_keterangan">
<span<?php echo $t03_rkas02->keterangan->ViewAttributes() ?>>
<?php echo $t03_rkas02->keterangan->ListViewValue() ?></span>
</span>
<?php if ($t03_rkas02->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_keterangan" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t03_rkas02->keterangan->FormValue) ?>">
<input type="hidden" data-table="t03_rkas02" data-field="x_keterangan" name="o<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" id="o<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t03_rkas02->keterangan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_keterangan" name="ft03_rkas02grid$x<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" id="ft03_rkas02grid$x<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t03_rkas02->keterangan->FormValue) ?>">
<input type="hidden" data-table="t03_rkas02" data-field="x_keterangan" name="ft03_rkas02grid$o<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" id="ft03_rkas02grid$o<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t03_rkas02->keterangan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t03_rkas02->jumlah->Visible) { // jumlah ?>
		<td data-name="jumlah"<?php echo $t03_rkas02->jumlah->CellAttributes() ?>>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_rkas02_grid->RowCnt ?>_t03_rkas02_jumlah" class="form-group t03_rkas02_jumlah">
<input type="text" data-table="t03_rkas02" data-field="x_jumlah" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rkas02->jumlah->getPlaceHolder()) ?>" value="<?php echo $t03_rkas02->jumlah->EditValue ?>"<?php echo $t03_rkas02->jumlah->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rkas02" data-field="x_jumlah" name="o<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" id="o<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t03_rkas02->jumlah->OldValue) ?>">
<?php } ?>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_rkas02_grid->RowCnt ?>_t03_rkas02_jumlah" class="form-group t03_rkas02_jumlah">
<input type="text" data-table="t03_rkas02" data-field="x_jumlah" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rkas02->jumlah->getPlaceHolder()) ?>" value="<?php echo $t03_rkas02->jumlah->EditValue ?>"<?php echo $t03_rkas02->jumlah->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_rkas02_grid->RowCnt ?>_t03_rkas02_jumlah" class="t03_rkas02_jumlah">
<span<?php echo $t03_rkas02->jumlah->ViewAttributes() ?>>
<?php echo $t03_rkas02->jumlah->ListViewValue() ?></span>
</span>
<?php if ($t03_rkas02->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_jumlah" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t03_rkas02->jumlah->FormValue) ?>">
<input type="hidden" data-table="t03_rkas02" data-field="x_jumlah" name="o<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" id="o<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t03_rkas02->jumlah->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_jumlah" name="ft03_rkas02grid$x<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" id="ft03_rkas02grid$x<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t03_rkas02->jumlah->FormValue) ?>">
<input type="hidden" data-table="t03_rkas02" data-field="x_jumlah" name="ft03_rkas02grid$o<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" id="ft03_rkas02grid$o<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t03_rkas02->jumlah->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t03_rkas02_grid->ListOptions->Render("body", "right", $t03_rkas02_grid->RowCnt);
?>
	</tr>
<?php if ($t03_rkas02->RowType == EW_ROWTYPE_ADD || $t03_rkas02->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft03_rkas02grid.UpdateOpts(<?php echo $t03_rkas02_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t03_rkas02->CurrentAction <> "gridadd" || $t03_rkas02->CurrentMode == "copy")
		if (!$t03_rkas02_grid->Recordset->EOF) $t03_rkas02_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t03_rkas02->CurrentMode == "add" || $t03_rkas02->CurrentMode == "copy" || $t03_rkas02->CurrentMode == "edit") {
		$t03_rkas02_grid->RowIndex = '$rowindex$';
		$t03_rkas02_grid->LoadRowValues();

		// Set row properties
		$t03_rkas02->ResetAttrs();
		$t03_rkas02->RowAttrs = array_merge($t03_rkas02->RowAttrs, array('data-rowindex'=>$t03_rkas02_grid->RowIndex, 'id'=>'r0_t03_rkas02', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t03_rkas02->RowAttrs["class"], "ewTemplate");
		$t03_rkas02->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t03_rkas02_grid->RenderRow();

		// Render list options
		$t03_rkas02_grid->RenderListOptions();
		$t03_rkas02_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t03_rkas02->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t03_rkas02_grid->ListOptions->Render("body", "left", $t03_rkas02_grid->RowIndex);
?>
	<?php if ($t03_rkas02->lv1_id->Visible) { // lv1_id ?>
		<td data-name="lv1_id">
<?php if ($t03_rkas02->CurrentAction <> "F") { ?>
<?php if ($t03_rkas02->lv1_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t03_rkas02_lv1_id" class="form-group t03_rkas02_lv1_id">
<span<?php echo $t03_rkas02->lv1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t03_rkas02->lv1_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t03_rkas02_lv1_id" class="form-group t03_rkas02_lv1_id">
<?php
$wrkonchange = trim(" " . @$t03_rkas02->lv1_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t03_rkas02->lv1_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t03_rkas02_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" id="sv_x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo $t03_rkas02->lv1_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->getPlaceHolder()) ?>"<?php echo $t03_rkas02->lv1_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_rkas02" data-field="x_lv1_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t03_rkas02->lv1_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
ft03_rkas02grid.CreateAutoSuggest({"id":"x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t03_rkas02->lv1_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t03_rkas02->lv1_id->ReadOnly || $t03_rkas02->lv1_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t03_rkas02_lv1_id" class="form-group t03_rkas02_lv1_id">
<span<?php echo $t03_rkas02->lv1_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t03_rkas02->lv1_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t03_rkas02" data-field="x_lv1_id" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_lv1_id" name="o<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" id="o<?php echo $t03_rkas02_grid->RowIndex ?>_lv1_id" value="<?php echo ew_HtmlEncode($t03_rkas02->lv1_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rkas02->no_urut->Visible) { // no_urut ?>
		<td data-name="no_urut">
<?php if ($t03_rkas02->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t03_rkas02_no_urut" class="form-group t03_rkas02_no_urut">
<input type="text" data-table="t03_rkas02" data-field="x_no_urut" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rkas02->no_urut->getPlaceHolder()) ?>" value="<?php echo $t03_rkas02->no_urut->EditValue ?>"<?php echo $t03_rkas02->no_urut->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t03_rkas02_no_urut" class="form-group t03_rkas02_no_urut">
<span<?php echo $t03_rkas02->no_urut->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t03_rkas02->no_urut->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t03_rkas02" data-field="x_no_urut" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t03_rkas02->no_urut->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_no_urut" name="o<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" id="o<?php echo $t03_rkas02_grid->RowIndex ?>_no_urut" value="<?php echo ew_HtmlEncode($t03_rkas02->no_urut->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rkas02->keterangan->Visible) { // keterangan ?>
		<td data-name="keterangan">
<?php if ($t03_rkas02->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t03_rkas02_keterangan" class="form-group t03_rkas02_keterangan">
<input type="text" data-table="t03_rkas02" data-field="x_keterangan" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t03_rkas02->keterangan->getPlaceHolder()) ?>" value="<?php echo $t03_rkas02->keterangan->EditValue ?>"<?php echo $t03_rkas02->keterangan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t03_rkas02_keterangan" class="form-group t03_rkas02_keterangan">
<span<?php echo $t03_rkas02->keterangan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t03_rkas02->keterangan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t03_rkas02" data-field="x_keterangan" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t03_rkas02->keterangan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_keterangan" name="o<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" id="o<?php echo $t03_rkas02_grid->RowIndex ?>_keterangan" value="<?php echo ew_HtmlEncode($t03_rkas02->keterangan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_rkas02->jumlah->Visible) { // jumlah ?>
		<td data-name="jumlah">
<?php if ($t03_rkas02->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t03_rkas02_jumlah" class="form-group t03_rkas02_jumlah">
<input type="text" data-table="t03_rkas02" data-field="x_jumlah" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t03_rkas02->jumlah->getPlaceHolder()) ?>" value="<?php echo $t03_rkas02->jumlah->EditValue ?>"<?php echo $t03_rkas02->jumlah->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t03_rkas02_jumlah" class="form-group t03_rkas02_jumlah">
<span<?php echo $t03_rkas02->jumlah->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t03_rkas02->jumlah->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t03_rkas02" data-field="x_jumlah" name="x<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" id="x<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t03_rkas02->jumlah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t03_rkas02" data-field="x_jumlah" name="o<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" id="o<?php echo $t03_rkas02_grid->RowIndex ?>_jumlah" value="<?php echo ew_HtmlEncode($t03_rkas02->jumlah->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t03_rkas02_grid->ListOptions->Render("body", "right", $t03_rkas02_grid->RowIndex);
?>
<script type="text/javascript">
ft03_rkas02grid.UpdateOpts(<?php echo $t03_rkas02_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t03_rkas02->CurrentMode == "add" || $t03_rkas02->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t03_rkas02_grid->FormKeyCountName ?>" id="<?php echo $t03_rkas02_grid->FormKeyCountName ?>" value="<?php echo $t03_rkas02_grid->KeyCount ?>">
<?php echo $t03_rkas02_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t03_rkas02->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t03_rkas02_grid->FormKeyCountName ?>" id="<?php echo $t03_rkas02_grid->FormKeyCountName ?>" value="<?php echo $t03_rkas02_grid->KeyCount ?>">
<?php echo $t03_rkas02_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t03_rkas02->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft03_rkas02grid">
</div>
<?php

// Close recordset
if ($t03_rkas02_grid->Recordset)
	$t03_rkas02_grid->Recordset->Close();
?>
<?php if ($t03_rkas02_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($t03_rkas02_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t03_rkas02_grid->TotalRecs == 0 && $t03_rkas02->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t03_rkas02_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t03_rkas02->Export == "") { ?>
<script type="text/javascript">
ft03_rkas02grid.Init();
</script>
<?php } ?>
<?php
$t03_rkas02_grid->Page_Terminate();
?>
