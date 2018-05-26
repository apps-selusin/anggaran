CREATE TRIGGER `tambah_penerimaan` AFTER INSERT ON `datapenerimaan`
 FOR EACH ROW insert into db_anggaran.t01_penerimaan (departemen, pos) values (new.departemen, new.nama)