<?php

// Urutan
// Nomor
// Kode
// Nama

?>
<?php if ($t03_pengeluaran_head->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_t03_pengeluaran_headmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($t03_pengeluaran_head->Urutan->Visible) { // Urutan ?>
		<tr id="r_Urutan">
			<td class="col-sm-2"><?php echo $t03_pengeluaran_head->Urutan->FldCaption() ?></td>
			<td<?php echo $t03_pengeluaran_head->Urutan->CellAttributes() ?>>
<span id="el_t03_pengeluaran_head_Urutan">
<span<?php echo $t03_pengeluaran_head->Urutan->ViewAttributes() ?>>
<?php echo $t03_pengeluaran_head->Urutan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_pengeluaran_head->Nomor->Visible) { // Nomor ?>
		<tr id="r_Nomor">
			<td class="col-sm-2"><?php echo $t03_pengeluaran_head->Nomor->FldCaption() ?></td>
			<td<?php echo $t03_pengeluaran_head->Nomor->CellAttributes() ?>>
<span id="el_t03_pengeluaran_head_Nomor">
<span<?php echo $t03_pengeluaran_head->Nomor->ViewAttributes() ?>>
<?php echo $t03_pengeluaran_head->Nomor->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_pengeluaran_head->Kode->Visible) { // Kode ?>
		<tr id="r_Kode">
			<td class="col-sm-2"><?php echo $t03_pengeluaran_head->Kode->FldCaption() ?></td>
			<td<?php echo $t03_pengeluaran_head->Kode->CellAttributes() ?>>
<span id="el_t03_pengeluaran_head_Kode">
<span<?php echo $t03_pengeluaran_head->Kode->ViewAttributes() ?>>
<?php echo $t03_pengeluaran_head->Kode->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_pengeluaran_head->Nama->Visible) { // Nama ?>
		<tr id="r_Nama">
			<td class="col-sm-2"><?php echo $t03_pengeluaran_head->Nama->FldCaption() ?></td>
			<td<?php echo $t03_pengeluaran_head->Nama->CellAttributes() ?>>
<span id="el_t03_pengeluaran_head_Nama">
<span<?php echo $t03_pengeluaran_head->Nama->ViewAttributes() ?>>
<?php echo $t03_pengeluaran_head->Nama->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
