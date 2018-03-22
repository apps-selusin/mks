<?php

// lv1_id
// lv2_id
// no_urut
// keterangan
// jumlah

?>
<?php if ($t04_rkas03->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_t04_rkas03master" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($t04_rkas03->lv1_id->Visible) { // lv1_id ?>
		<tr id="r_lv1_id">
			<td class="col-sm-2"><?php echo $t04_rkas03->lv1_id->FldCaption() ?></td>
			<td<?php echo $t04_rkas03->lv1_id->CellAttributes() ?>>
<span id="el_t04_rkas03_lv1_id">
<span<?php echo $t04_rkas03->lv1_id->ViewAttributes() ?>>
<?php echo $t04_rkas03->lv1_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t04_rkas03->lv2_id->Visible) { // lv2_id ?>
		<tr id="r_lv2_id">
			<td class="col-sm-2"><?php echo $t04_rkas03->lv2_id->FldCaption() ?></td>
			<td<?php echo $t04_rkas03->lv2_id->CellAttributes() ?>>
<span id="el_t04_rkas03_lv2_id">
<span<?php echo $t04_rkas03->lv2_id->ViewAttributes() ?>>
<?php echo $t04_rkas03->lv2_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t04_rkas03->no_urut->Visible) { // no_urut ?>
		<tr id="r_no_urut">
			<td class="col-sm-2"><?php echo $t04_rkas03->no_urut->FldCaption() ?></td>
			<td<?php echo $t04_rkas03->no_urut->CellAttributes() ?>>
<span id="el_t04_rkas03_no_urut">
<span<?php echo $t04_rkas03->no_urut->ViewAttributes() ?>>
<?php echo $t04_rkas03->no_urut->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t04_rkas03->keterangan->Visible) { // keterangan ?>
		<tr id="r_keterangan">
			<td class="col-sm-2"><?php echo $t04_rkas03->keterangan->FldCaption() ?></td>
			<td<?php echo $t04_rkas03->keterangan->CellAttributes() ?>>
<span id="el_t04_rkas03_keterangan">
<span<?php echo $t04_rkas03->keterangan->ViewAttributes() ?>>
<?php echo $t04_rkas03->keterangan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t04_rkas03->jumlah->Visible) { // jumlah ?>
		<tr id="r_jumlah">
			<td class="col-sm-2"><?php echo $t04_rkas03->jumlah->FldCaption() ?></td>
			<td<?php echo $t04_rkas03->jumlah->CellAttributes() ?>>
<span id="el_t04_rkas03_jumlah">
<span<?php echo $t04_rkas03->jumlah->ViewAttributes() ?>>
<?php echo $t04_rkas03->jumlah->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
