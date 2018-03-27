<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>

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
<table border="0">
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
					<td>".$rs1->fields["jumlah"]."</td><td>&nbsp;</td>";
			if ($rs1->fields["no_level"] == 2) echo "
				<tr>
					<td>&nbsp;</td><td>".$rs1->fields["no_urut"]."</td>
					<td colspan='5'>".$rs1->fields["keterangan"]."</td>
					<td>".$rs1->fields["jumlah"]."</td>
					<td>&nbsp;</td><td>&nbsp;</td>";
			if ($rs1->fields["no_level"] == 3) echo "
				<tr>
					<td>&nbsp;</td><td>&nbsp;</td><td>".$rs1->fields["no_urut"]."</td>
					<td colspan='3'>".$rs1->fields["keterangan"]."</td>
					<td>".$rs1->fields["jumlah"]."</td>
					<td colspan='2'>&nbsp;</td><td>&nbsp;</td>";
			if ($rs1->fields["no_level"] == 4) echo "
				<tr>
					<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>".$rs1->fields["no_urut"]."</td>
					<td>".$rs1->fields["keterangan"]."</td>
					<td>".$rs1->fields["jumlah"]."</td>
					<td colspan='3'>&nbsp;</td><td>&nbsp;</td>";
		}
		else {
			echo "<tr><td colspan='9'>&nbsp;</td><td>&nbsp;</td>";
			// data tidak ada
		}
		if ($rs2->fields["no_level"] == 1) echo "
			<td>".$rs2->fields["no_urut"]."</td>
			<td colspan='7'>".$rs2->fields["keterangan"]."</td>
			<td>".$rs2->fields["jumlah"]."</td>";
		if ($rs2->fields["no_level"] == 2) echo "
			<td>&nbsp;</td><td>".$rs2->fields["no_urut"]."</td>
			<td colspan='5'>".$rs2->fields["keterangan"]."</td>
			<td>".$rs2->fields["jumlah"]."</td>
			<td>&nbsp;</td>";
		if ($rs2->fields["no_level"] == 3) echo "
			<td>&nbsp;</td><td>&nbsp;</td><td>".$rs2->fields["no_urut"]."</td>
			<td colspan='3'>".$rs2->fields["keterangan"]."</td>
			<td>".$rs2->fields["jumlah"]."</td>
			<td colspan='2'>&nbsp;</td>";
		if ($rs2->fields["no_level"] == 4) echo "
			<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>".$rs2->fields["no_urut"]."</td>
			<td>".$rs2->fields["keterangan"]."</td>
			<td>".$rs2->fields["jumlah"]."</td>
			<td colspan='3'>&nbsp;</td>";
		echo "</tr>";
		$rs2->MoveNext();
	}
}
?>
</table>