CREATE TRIGGER `ubah_penerimaan` AFTER UPDATE ON `datapenerimaan`
 FOR EACH ROW update db_anggaran.t01_penerimaan set pos = new.nama where departemen = departemen and pos = old.nama