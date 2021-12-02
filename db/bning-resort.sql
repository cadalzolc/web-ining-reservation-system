-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2021 at 05:46 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medallion`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_add_reservation` (`p_am_id` INT, `p_cs_id` INT, `p_no_units` INT, `p_check_in` VARCHAR(10), `p_no_persons` INT)  BEGIN

	DECLARE p_date VARCHAR(10);
    DECLARE p_rate VARCHAR(10);
    DECLARE p_amount VARCHAR(10);
    DECLARE p_id INT;
    
    SET p_rate = (SELECT rates FROM lst_aminities WHERE id = p_am_id);
    SET p_date = current_date();
    SET p_amount = 0;
    
    IF NOT ISNULL(p_rate) THEN
		SET p_amount = p_rate * p_no_units;
    END IF;

	INSERT INTO trn_reservation
	(
	date, am_id, cs_id, amount, no_units, check_in, status, discount, no_persons
	)
	VALUES
	(
	p_date, p_am_id, p_cs_id, p_amount, p_no_units, p_check_in, 'P', 0, p_no_persons
	);
    
     SET p_id = LAST_INSERT_ID();
     
     SELECT CONCAT('RS', 1000 + p_id) as trans_no, p_id as id;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_aminity_info_today` (`p_id` INT, `p_date` VARCHAR(10))  BEGIN

 SELECT *, 
	unit - booked As available FROM
 (
 SELECT 
        `la`.`id` AS `id`,
        `la`.`type_id` AS `type_id`,
        `ta`.`name` AS `type`,
        `la`.`name` AS `name`,
        `la`.`photo` AS `photo`,
        `la`.`rates` AS `rates`,
        `la`.`person` AS `person`,
        `la`.`status` AS `status`,
        `la`.`unit` AS `unit`,
        `la`.`discount_id` AS `discount_id`,
        `td`.`name` AS `discount`,
        `td`.`percent` AS `percent`,
        `la`.`active` AS `active`,
        (SELECT COUNT(*) AS N 
		FROM trn_schedule ts 
		WHERE ts.am_id = la.id AND ts.date = p_date) AS booked
    FROM
        `lst_aminities` `la`
        LEFT JOIN `typ_aminities` `ta` ON `ta`.`id` = `la`.`type_id`
        LEFT JOIN `typ_discount` `td` ON `td`.`id` = `la`.`discount_id`) AS lsr
	WHERE lsr.id = p_id;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login` (`p_user` VARCHAR(50), `p_pass` VARCHAR(50))  BEGIN

	SELECT * FROM vw_users 
    WHERE user_account = p_user 
    AND user_password = p_pass;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login_customer` (`p_user` VARCHAR(50), `p_pass` VARCHAR(50))  BEGIN

	SELECT * FROM vw_users 
    WHERE user_account = p_user 
    AND user_password = p_pass
    AND role_id = 2;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accomodation`
--

CREATE TABLE `accomodation` (
  `acc_id` int(11) NOT NULL,
  `acc_type` varchar(35) NOT NULL,
  `acc_price` double NOT NULL,
  `acc_slot` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accomodation`
--

INSERT INTO `accomodation` (`acc_id`, `acc_type`, `acc_price`, `acc_slot`) VALUES
(1, 'Triangle Cottage', 200, 3),
(2, 'Nipa Hut Cottage', 300, 2),
(3, 'Room', 1000, 1),
(4, 'Function Hall', 5000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `booked`
--

CREATE TABLE `booked` (
  `book_id` int(11) NOT NULL,
  `book_by` varchar(50) NOT NULL,
  `book_contact` varchar(15) NOT NULL,
  `book_address` varchar(100) NOT NULL,
  `book_name` varchar(50) NOT NULL,
  `book_age` int(50) NOT NULL,
  `book_gender` varchar(50) NOT NULL,
  `book_departure` date NOT NULL,
  `dest_id` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `origin_id` int(11) NOT NULL,
  `book_tracker` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booked`
--

INSERT INTO `booked` (`book_id`, `book_by`, `book_contact`, `book_address`, `book_name`, `book_age`, `book_gender`, `book_departure`, `dest_id`, `acc_id`, `origin_id`, `book_tracker`) VALUES
(74, 'Renato J. Solitarios Jr.', '09977889323', 'Bgy. Cogon Calbayog City', 'renato', 20, 'Male', '2021-11-30', 1, 1, 1, '61a48f3760b71');

-- --------------------------------------------------------

--
-- Table structure for table `destination`
--

CREATE TABLE `destination` (
  `dest_id` int(11) NOT NULL,
  `dest_destination` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `destination`
--

INSERT INTO `destination` (`dest_id`, `dest_destination`) VALUES
(1, 'Aling B\'ning');

-- --------------------------------------------------------

--
-- Table structure for table `origin`
--

CREATE TABLE `origin` (
  `origin_id` int(11) NOT NULL,
  `origin_desc` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `origin`
--

INSERT INTO `origin` (`origin_id`, `origin_desc`) VALUES
(1, 'Calbayog City');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `stat_id` int(11) NOT NULL,
  `stat_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`stat_id`, `stat_desc`) VALUES
(1, 'Paid'),
(2, 'Refunded');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `trans_id` int(11) NOT NULL,
  `trans_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `trans_payment` double NOT NULL,
  `trans_passenger` varchar(100) NOT NULL,
  `trans_age` int(11) NOT NULL,
  `trans_gender` varchar(15) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `origin_id` int(11) NOT NULL,
  `dest_id` int(11) NOT NULL,
  `stat_id` int(11) DEFAULT 1,
  `trans_refunded` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`trans_id`, `trans_time`, `trans_payment`, `trans_passenger`, `trans_age`, `trans_gender`, `acc_id`, `origin_id`, `dest_id`, `stat_id`, `trans_refunded`) VALUES
(21, '2021-11-29 08:56:11', 180, 'renato', 20, 'Male', 1, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `user_account` varchar(50) NOT NULL,
  `user_password` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `role_id`, `user_account`, `user_password`) VALUES
(1, 4, 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(2, 2, 'guest', '21232f297a57a5a743894a0e4a801fc3'),
(3, 2, 'test', '21232f297a57a5a743894a0e4a801fc3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accomodation`
--
ALTER TABLE `accomodation`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `booked`
--
ALTER TABLE `booked`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `dest_id` (`dest_id`,`acc_id`),
  ADD KEY `acc_id` (`acc_id`),
  ADD KEY `origin_id` (`origin_id`);

--
-- Indexes for table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`dest_id`);

--
-- Indexes for table `origin`
--
ALTER TABLE `origin`
  ADD PRIMARY KEY (`origin_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`stat_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `acc_id` (`acc_id`,`origin_id`,`dest_id`,`stat_id`),
  ADD KEY `origin_id` (`origin_id`),
  ADD KEY `dest_id` (`dest_id`),
  ADD KEY `stat_id` (`stat_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accomodation`
--
ALTER TABLE `accomodation`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `booked`
--
ALTER TABLE `booked`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `destination`
--
ALTER TABLE `destination`
  MODIFY `dest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `origin`
--
ALTER TABLE `origin`
  MODIFY `origin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `stat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booked`
--
ALTER TABLE `booked`
  ADD CONSTRAINT `booked_ibfk_1` FOREIGN KEY (`dest_id`) REFERENCES `destination` (`dest_id`),
  ADD CONSTRAINT `booked_ibfk_2` FOREIGN KEY (`acc_id`) REFERENCES `accomodation` (`acc_id`),
  ADD CONSTRAINT `booked_ibfk_3` FOREIGN KEY (`origin_id`) REFERENCES `origin` (`origin_id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `accomodation` (`acc_id`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`origin_id`) REFERENCES `origin` (`origin_id`),
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`dest_id`) REFERENCES `destination` (`dest_id`),
  ADD CONSTRAINT `transaction_ibfk_4` FOREIGN KEY (`stat_id`) REFERENCES `status` (`stat_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
