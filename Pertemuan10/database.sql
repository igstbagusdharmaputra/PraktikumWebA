CREATE DATABASE phpdasar;

CREATE TABLE mahasiswa (
	id INT PRIMARY KEY AUTO_INCREMENT,
	nama VARCHAR(100),
	nim CHAR (10),
	email VARCHAR(100),
	jurusan VARCHAR(100),
	gambar VARCHAR(100)
);

DESCRIBE mahasiswa;

INSERT INTO mahasiswa VALUES ('','Dharma Putra','1708561010','dharmatkjone@gmail.com','Ilmu Komputer','dharma.jpeg');
INSERT INTO mahasiswa VALUES ('','Made Suastika','1708561001','suastika@gmail.com','Ilmu Komputer','suastika.jpeg');

SELECT * FROM mahasiswa;
