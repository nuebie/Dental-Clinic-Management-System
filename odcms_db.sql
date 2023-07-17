-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2022 at 12:58 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `odcms db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointid` int(11) NOT NULL,
  `patientid` varchar(20) NOT NULL,
  `staffid` varchar(20) DEFAULT NULL,
  `servid` int(11) NOT NULL,
  `appointdate` date NOT NULL,
  `appointtime` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `hastreatment` varchar(3) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointid`, `patientid`, `staffid`, `servid`, `appointdate`, `appointtime`, `status`, `hastreatment`) VALUES
(30, 'user6397097a2ffd4', 'user63254b02d43d2', 1, '2022-12-12', 1, 'treated', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_schedule`
--

CREATE TABLE `appointment_schedule` (
  `appointschedid` int(11) NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment_schedule`
--

INSERT INTO `appointment_schedule` (`appointschedid`, `starttime`, `endtime`) VALUES
(1, '08:00:00', '21:00:00'),
(5, '11:00:00', '12:00:00'),
(8, '13:00:00', '14:00:00'),
(9, '15:00:00', '16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `presid` int(11) NOT NULL,
  `dentistid` varchar(20) NOT NULL,
  `patientid` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `med` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`presid`, `dentistid`, `patientid`, `date`, `med`) VALUES
(14, 'user63254b02d43d2', 'user6397097a2ffd4', '2022-12-12', 'Ambesol');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `servid` int(11) NOT NULL,
  `servimage` varchar(50) NOT NULL,
  `servname` varchar(50) NOT NULL,
  `servdesc` longtext NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `pertooth` varchar(3) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`servid`, `servimage`, `servname`, `servdesc`, `price`, `pertooth`) VALUES
(1, 'IMG-63931389ca6f40.45344885.jpg', 'TOOTH EXTRACTION', '<p>While many teens and some adults get their wisdom teeth removed, there are other reasons why tooth extraction may be necessary in adulthood.</p>\r\n\r\n<p>Excessive tooth decay, tooth infection, and crowding can all require a tooth extraction. Those who get braces may need one or two teeth removed to provide room for their other teeth as they shift into place. Additionally, those who are undergoing chemotherapy or are about to have an organ transplant may need compromised teeth removed in order to keep their mouth healthy.</p>\r\n\r\n<p>Tooth extraction is performed by a dentist or oral surgeon and is a relatively quick outpatient procedure with either local, general, intravenous anesthesia, or a combination. Removing visible teeth is a simple extraction. Teeth that are broken, below the surface, or impacted require a more involved procedure.</p>', '8000.00', 'yes'),
(8, 'IMG-639710daba3dd0.28505104.jpeg', 'TOOTH CLEANING', '<p>Most teeth cleanings are performed by a dental hygienist. Before the actual cleaning process begins, they start with a physical exam of your entire mouth. The dental hygienist uses a small mirror to check around your teeth and gums for any signs of gingivitis (inflamed gums) or other potential concerns. If they detect major problems, the dental hygienist might call the dentist to make sure it’s fine to proceed.\r\n</p>\r\n\r\n<p>With the small mirror to guide them, the dental hygienist uses a scaler to get rid of plaque and tartar around your gum line, as well as in between your teeth. You’ll hear scraping, but this is normal. The more tartar there is in your mouth, the more time they’ll need to scrape a particular spot. Brushing and flossing stops plaque from building up and hardening into tartar. Once you have tartar, you can only have it removed at your dentist’s office. So if this is your least favorite part of the teeth cleaning process, the lesson is to brush and floss more often.</p>', '800.00', 'no'),
(9, 'IMG-639712b057d3c7.01933722.jpg', 'TOOTH WHITENING', '<p>Tooth whitening can be a very effective way of lightening the natural colour of your teeth without removing any of the tooth surface. It cannot make a complete colour change, but it may lighten the existing shade.</p>\r\n\r\n<p>Professional bleaching is the most usual method of tooth whitening. Your dental team will be able to tell you if you are suitable for the treatment, and will supervise it if you are. First the dental team will put a rubber shield or a gel on your gums to protect them. They will then apply the whitening product to your teeth, using a specially made tray which fits into your mouth like a mouthguard.</p>', '10000.00', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE `treatment` (
  `treatid` int(11) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `appointid` int(11) NOT NULL,
  `teethno` int(11) NOT NULL,
  `treatdesc` text NOT NULL,
  `fee` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`treatid`, `userid`, `appointid`, `teethno`, `treatdesc`, `fee`) VALUES
(10, 'user6397097a2ffd4', 30, 25, 'One tooth was extracted.', '8000.00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `contactnum` varchar(15) NOT NULL,
  `password` tinytext NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'regular_user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `fname`, `lname`, `gender`, `birthdate`, `email`, `contactnum`, `password`, `role`) VALUES
('user63254b02d43d2', 'emman', 'Emmanuell', 'Manugas', 'male', '2022-09-17', 'f@yahoo.com', '09767898767', '$2y$10$jco7XdmksRWQfQEkuriSzOG5Meyu6e4XqOBxqFZnXJPiyeUA6PqBq', 'dentist'),
('user6397097a2ffd4', 'subong', 'Monica', 'Subong', 'female', '2000-01-12', 'subong@gmail.com', '0997567875', '$2y$10$89yiUPKZyLylt8cOvGqfguvJIGpVeKb.Feg.rkvP5S4gGe2jC1opK', 'regular_user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointid`),
  ADD KEY `servid` (`servid`),
  ADD KEY `patientid` (`patientid`),
  ADD KEY `staffid` (`staffid`),
  ADD KEY `time` (`appointtime`);

--
-- Indexes for table `appointment_schedule`
--
ALTER TABLE `appointment_schedule`
  ADD PRIMARY KEY (`appointschedid`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`presid`),
  ADD KEY `dentistid` (`dentistid`),
  ADD KEY `patientid` (`patientid`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`servid`);

--
-- Indexes for table `treatment`
--
ALTER TABLE `treatment`
  ADD PRIMARY KEY (`treatid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `appointid` (`appointid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `appointment_schedule`
--
ALTER TABLE `appointment_schedule`
  MODIFY `appointschedid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `presid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `servid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `treatment`
--
ALTER TABLE `treatment`
  MODIFY `treatid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`servid`) REFERENCES `service` (`servid`),
  ADD CONSTRAINT `appointment_ibfk_4` FOREIGN KEY (`patientid`) REFERENCES `user` (`userid`),
  ADD CONSTRAINT `appointment_ibfk_5` FOREIGN KEY (`staffid`) REFERENCES `user` (`userid`),
  ADD CONSTRAINT `appointment_ibfk_6` FOREIGN KEY (`appointtime`) REFERENCES `appointment_schedule` (`appointschedid`);

--
-- Constraints for table `prescription`
--
ALTER TABLE `prescription`
  ADD CONSTRAINT `prescription_ibfk_1` FOREIGN KEY (`dentistid`) REFERENCES `user` (`userid`),
  ADD CONSTRAINT `prescription_ibfk_2` FOREIGN KEY (`patientid`) REFERENCES `user` (`userid`);

--
-- Constraints for table `treatment`
--
ALTER TABLE `treatment`
  ADD CONSTRAINT `treatment_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`),
  ADD CONSTRAINT `treatment_ibfk_2` FOREIGN KEY (`appointid`) REFERENCES `appointment` (`appointid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
