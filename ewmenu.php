<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(6, "mi_cf01_home_php", $Language->MenuPhrase("6", "MenuText"), "cf01_home.php", -1, "", AllowListMenu('{EC8C353E-21D9-43CE-9845-66794CB3C5CD}cf01_home.php'), FALSE, TRUE, "");
$RootMenu->AddMenuItem(1, "mi_t01_master_sekolah", $Language->MenuPhrase("1", "MenuText"), "t01_master_sekolahlist.php", -1, "", AllowListMenu('{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t01_master_sekolah'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(81, "mci_RKAS", $Language->MenuPhrase("81", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(65, "mi_t02_rkas", $Language->MenuPhrase("65", "MenuText"), "t02_rkaslist.php", 81, "", AllowListMenu('{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t02_rkas'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(95, "mci_RPU", $Language->MenuPhrase("95", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(82, "mi_t03_rpu", $Language->MenuPhrase("82", "MenuText"), "t03_rpulist.php", 95, "", AllowListMenu('{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t03_rpu'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(41, "mci_Input", $Language->MenuPhrase("41", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(19, "mci_Buku_Kas_BOS_26_Pembantu_Tunai", $Language->MenuPhrase("19", "MenuText"), "", 41, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(20, "mci_Buku_Transparansi_Dana_BOS", $Language->MenuPhrase("20", "MenuText"), "", 41, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(21, "mci_Buku_Kas_Umum_26_Pembantu_Bank", $Language->MenuPhrase("21", "MenuText"), "", 41, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(22, "mci_Buku_Kas_DOS_26_Laporan_Keuangan", $Language->MenuPhrase("22", "MenuText"), "", 41, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(23, "mci_Jadwal_Kegiatan_Pelaksanaan_Keuangan", $Language->MenuPhrase("23", "MenuText"), "", 41, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(12, "mci_Setup", $Language->MenuPhrase("12", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(5, "mi_t96_employees", $Language->MenuPhrase("5", "MenuText"), "t96_employeeslist.php", 12, "", AllowListMenu('{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t96_employees'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(3, "mi_t97_userlevels", $Language->MenuPhrase("3", "MenuText"), "t97_userlevelslist.php", 12, "", IsAdmin(), FALSE, FALSE, "");
$RootMenu->AddMenuItem(2, "mi_t99_audit_trail", $Language->MenuPhrase("2", "MenuText"), "t99_audit_traillist.php", 12, "", AllowListMenu('{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t99_audit_trail'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
