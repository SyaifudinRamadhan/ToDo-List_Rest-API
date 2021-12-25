-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 05 Des 2021 pada 18.51
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_manager_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `members`
--

CREATE TABLE `members` (
  `ID` int(11) NOT NULL,
  `group_name` varchar(25) DEFAULT NULL,
  `FK_Users` int(11) NOT NULL,
  `FK_Projects` int(11) NOT NULL,
  `FK_Tasks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `members`
--

INSERT INTO `members` (`ID`, `group_name`, `FK_Users`, `FK_Projects`, `FK_Tasks`) VALUES
(1, 'Uji coba', 3, 1, 1),
(2, 'Uji Coba', 3, 1, 2),
(4, 'Uji coba', 4, 1, 2),
(5, 'Uji coba 2', 3, 2, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `projects`
--

CREATE TABLE `projects` (
  `ID` int(11) NOT NULL,
  `project_name` varchar(30) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `company` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `projects`
--

INSERT INTO `projects` (`ID`, `project_name`, `start_date`, `end_date`, `description`, `company`) VALUES
(1, 'coba test', '2021-10-25', '2021-10-31', 'kosongin aja coba testing', 'guudhfudhfudfh'),
(2, 'Coba test 2', '2021-11-01', '2021-11-30', 'fdtygdygfygfyge eftde7deyh fey87ey8eudh8', 'coba ehh 2'),
(4, 'Uji Coba 3', '2021-11-30', '2021-12-12', '', '-'),
(5, 'Project uji coba 4', '2021-11-30', '2021-12-06', '', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tasks`
--

CREATE TABLE `tasks` (
  `ID` int(11) NOT NULL,
  `task_name` varchar(25) NOT NULL,
  `start_task` date NOT NULL,
  `end_task` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` float NOT NULL,
  `FK_Projects` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tasks`
--

INSERT INTO `tasks` (`ID`, `task_name`, `start_task`, `end_task`, `description`, `status`, `FK_Projects`) VALUES
(1, 'Membuat rencana awal', '2021-10-25', '2021-10-28', 'Tugas awlan dudfubffudnubduhfudhhfudcubdycubdd', 1, 1),
(2, 'proposal atahap pertama', '2021-10-29', '2021-10-31', 'Coba diubah dengan file  fyudhfhuhefudf hngawur sek ae', 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `task_details`
--

CREATE TABLE `task_details` (
  `ID` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `satuses` tinyint(1) NOT NULL,
  `file_attachment` varchar(100) NOT NULL,
  `FK_Tasks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `task_details`
--

INSERT INTO `task_details` (`ID`, `description`, `satuses`, `file_attachment`, `FK_Tasks`) VALUES
(1, 'Tugas awlan dudfubffudnubduhfudhhfudcubdycubdd', 1, 'wETWaa19X1.pdf', 1),
(3, 'Coba diubah dengan file  fyudhfhuhefudf hngawur sek ae', 2, '2L6FwL1LaN.pdf', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `first_name` varchar(10) NOT NULL,
  `last_name` varchar(10) NOT NULL,
  `full_name` varchar(70) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(8) NOT NULL,
  `telp_number` varchar(17) NOT NULL,
  `profile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`ID`, `first_name`, `last_name`, `full_name`, `username`, `password`, `telp_number`, `profile`) VALUES
(3, 'Misaka', 'Mikoto', 'Misaka Mikoto', 'Misaka Mikoto', 'Misaka12', '081215848233', 'klpbvSubz7.jpg'),
(4, 'Shokuhou', 'MIsaki', 'Shokuhou Misaki', 'Shokuhou', 'MIsaki12', '081215848233', '-'),
(5, 'Ahmad', 'Ramadhan', 'Ahmad Syaifudin Ramadhan', 'Ahmad Syaifudin R', 'Ifud1234', '088217466532', '-');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_project` (`FK_Projects`),
  ADD KEY `id_tasks` (`FK_Tasks`),
  ADD KEY `id_users` (`FK_Users`);

--
-- Indeks untuk tabel `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `from_project` (`FK_Projects`);

--
-- Indeks untuk tabel `task_details`
--
ALTER TABLE `task_details`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `from_task` (`FK_Tasks`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `members`
--
ALTER TABLE `members`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `projects`
--
ALTER TABLE `projects`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tasks`
--
ALTER TABLE `tasks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `task_details`
--
ALTER TABLE `task_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `id_project` FOREIGN KEY (`FK_Projects`) REFERENCES `projects` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_tasks` FOREIGN KEY (`FK_Tasks`) REFERENCES `tasks` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_users` FOREIGN KEY (`FK_Users`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `from_project` FOREIGN KEY (`FK_Projects`) REFERENCES `projects` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `task_details`
--
ALTER TABLE `task_details`
  ADD CONSTRAINT `from_task` FOREIGN KEY (`FK_Tasks`) REFERENCES `tasks` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
