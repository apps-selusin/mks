<?php

// lv1_id
// no_urut
// keterangan
// jumlah

?>
<?php if ($t03_rkas02->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_t03_rkas02master" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($t03_rkas02->lv1_id->Visible) { // lv1_id ?>
		<tr id="r_lv1_id">
			<td class="col-sm-2"><?php echo $t03_rkas02->lv1_id->FldCaption() ?></td>
			<td<?php echo $t03_rkas02->lv1_id->CellAttributes() ?>>
<span id="el_t03_rkas02_lv1_id">
<span<?php echo $t03_rkas02->lv1_id->ViewAttributes() ?>>
<?php echo $t03_rkas02->lv1_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_rkas02->no_urut->Visible) { // no_urut ?>
		<tr id="r_no_urut">
			<td class="col-sm-2"><?php echo $t03_rkas02->no_urut->FldCaption() ?></td>
			<td<?php echo $t03_rkas02->no_urut->CellAttributes() ?>>
<span id="el_t03_rkas02_no_urut">
<span<?php echo $t03_rkas02->no_urut->ViewAttributes() ?>>
<?php echo $t03_rkas02->no_urut->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_rkas02->keterangan->Visible) { // keterangan ?>
		<tr id="r_keterangan">
			<td class="col-sm-2"><?php echo $t03_rkas02->keterangan->FldCaption() ?></td>
			<td<?php echo $t03_rkas02->keterangan->CellAttributes() ?>>
<span id="el_t03_rkas02_keterangan">
<span<?php echo $t03_rkas02->keterangan->ViewAttributes() ?>>
<?php echo $t03_rkas02->keterangan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_rkas02->jumlah->Visible) { // jumlah ?>
		<tr id="r_jumlah">
			<td class="col-sm-2"><?php echo $t03_rkas02->jumlah->FldCaption() ?></td>
			<td<?php echo $t03_rkas02->jumlah->CellAttributes() ?>>
<span id="el_t03_rkas02_jumlah">
<span<?php echo $t03_rkas02->jumlah->ViewAttributes() ?>>
<?php echo $t03_rkas02->jumlah->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
