CREATE TRIGGER `ubah_pengeluaran` AFTER UPDATE ON `datapengeluaran`
 FOR EACH ROW update db_anggaran.t02_pengeluaran set pos = new.nama where departemen = departemen and pos = old.nama