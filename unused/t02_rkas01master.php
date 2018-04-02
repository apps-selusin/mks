<?php

// no_urut
// keterangan
// jumlah

?>
<?php if ($t02_rkas01->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_t02_rkas01master" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($t02_rkas01->no_urut->Visible) { // no_urut ?>
		<tr id="r_no_urut">
			<td class="col-sm-2"><?php echo $t02_rkas01->no_urut->FldCaption() ?></td>
			<td<?php echo $t02_rkas01->no_urut->CellAttributes() ?>>
<span id="el_t02_rkas01_no_urut">
<span<?php echo $t02_rkas01->no_urut->ViewAttributes() ?>>
<?php echo $t02_rkas01->no_urut->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t02_rkas01->keterangan->Visible) { // keterangan ?>
		<tr id="r_keterangan">
			<td class="col-sm-2"><?php echo $t02_rkas01->keterangan->FldCaption() ?></td>
			<td<?php echo $t02_rkas01->keterangan->CellAttributes() ?>>
<span id="el_t02_rkas01_keterangan">
<span<?php echo $t02_rkas01->keterangan->ViewAttributes() ?>>
<?php echo $t02_rkas01->keterangan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t02_rkas01->jumlah->Visible) { // jumlah ?>
		<tr id="r_jumlah">
			<td class="col-sm-2"><?php echo $t02_rkas01->jumlah->FldCaption() ?></td>
			<td<?php echo $t02_rkas01->jumlah->CellAttributes() ?>>
<span id="el_t02_rkas01_jumlah">
<span<?php echo $t02_rkas01->jumlah->ViewAttributes() ?>>
<?php echo $t02_rkas01->jumlah->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
