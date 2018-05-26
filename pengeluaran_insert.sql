CREATE TRIGGER `tambah_pengeluaran` AFTER INSERT ON `datapengeluaran`
 FOR EACH ROW insert into db_anggaran.t02_pengeluaran (departemen, pos) values (new.departemen, new.nama)