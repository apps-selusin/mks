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
	$q = "truncate t95_rkas";
	$db->Execute($q);

// begin ambil level 1 --------------------------------------------------
	$id_kiri  = 0;
	$id_kanan = 0;
	$q = "select * from t02_rkas01";
	$rs = $db->Execute($q);
	// ambil sisi kiri
	// no_urut = 1
	while (!$rs->EOF) {
		if ($rs->fields["no_urut"] == 1) {
			$id_kiri = $rs->fields["id"];
			break;
		}
		$rs->MoveNext();
	}

	$rs = $db->Execute($q);
	// ambil sisi kanan
	// no_urut = 2
	while (!$rs->EOF) {
		if ($rs->fields["no_urut"] == 2) {
			$id_kanan = $rs->fields["id"];
			break;
		}
		$rs->MoveNext();
	}
// end of ambil level 1 -------------------------------------------------


// begin ambil level 2 --------------------------------------------------
	// cek jumlah record antara kiri dan kanan
	// lebih banyak mana
	$reccount_kiri = 0;
	$reccount_kanan = 0;
	$q = "select * from t03_rkas02 where lv1_id = ".$id_kiri."";
	$rs = $db->Execute($q);
	$reccount_kiri = $rs->RecordCount();
	$q = "select * from t03_rkas02 where lv1_id = ".$id_kanan."";
	$rs = $db->Execute($q);
	$reccount_kanan = $rs->RecordCount();
	if ($reccount_kiri >= $reccount_kanan) {
		// lebih banyak kiri atau sama dengan
		$q1 = "select * from t03_rkas02 where lv1_id = ".$id_kiri."";
		$rs1 = $db->Execute($q1);
		$q2 = "select * from t03_rkas02 where lv1_id = ".$id_kanan."";
		$rs2 = $db->Execute($q2);
		
		// mulai ambil data level 2
		while (!$rs1->EOF) {
			// ambil data sisi kiri
			$q = "insert into t95_rkas
				(id, kiri_tabel, kiri_id, kiri_lv2, kiri_jumlah) values 
				(null, 't03_rkas02', ".$rs1->fields["id"].", '".$rs1->fields["keterangan"]."', ".$rs1->fields["jumlah"].")";
			$db->Execute($q);

			// ambil data sisi kanan
			while (!$rs2->EOF) {
				$q = "update t95_rkas set 
					kanan_tabel = 't03_rkas02', 
					kanan_id = ".$rs2->fields["id"].", 
					kanan_lv2 = '".$rs2->fields["keterangan"]."',
					kanan_jumlah = ".$rs2->fields["jumlah"]." where 
					kiri_id = ".$rs1->fields["id"].""
					;
				$db->Execute($q);
				
				$rs2->MoveNext();
				break;
			}
		
			$rs1->MoveNext();
		}
	}
	else {
		// lebih banyak kanan
		/*$q1 = "select * from t03_rkas02 where lv1_id = ".$id_kanan."";
		$rs1 = $db->Execute($q1);
		$q2 = "select * from t03_rkas02 where lv1_id = ".$id_kiri."";
		$rs2 = $db->Execute($q2);*/
	}
// end of ambil level 2 -------------------------------------------------
?>