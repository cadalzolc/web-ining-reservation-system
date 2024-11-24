-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2022 at 02:04 PM
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
-- Database: `db_reserve`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_add_amenity` (`p_name` VARCHAR(45), `p_rates` INT(10), `p_unit` INT(11), `p_person_limit` INT(11), `p_type` INT(11))  BEGIN

	INSERT INTO lst_aminities (name, rates, unit, person_limit, type_id, photo, status, active, discount_id) 
    VALUES  (p_name, p_rates, p_unit, p_person_limit, p_type, 'default.jpg', 'A', 1, 1);
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_add_aminity_type` (`p_name` VARCHAR(40), `p_rate` DECIMAL(10,2))  BEGIN

	INSERT INTO typ_aminities (name, rates) VALUES (p_name, p_rate);    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_add_discount` (`p_name` VARCHAR(40), `p_percent` DECIMAL(10,2))  BEGIN

	INSERT INTO typ_discount (name, percent) VALUES  (p_name, p_percent);

END$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_check_in` (`p_id` INT)  BEGIN

	DECLARE p_date VARCHAR(10);
    
    SET p_date = current_time();
    
	UPDATE trn_reservation SET date_in = p_date WHERE id = p_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_check_out` (`p_id` INT)  BEGIN

	DECLARE p_date VARCHAR(10);
    
    SET p_date = current_time();
    
	UPDATE trn_reservation SET date_out = p_date WHERE id = p_id;

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
        `la`.`person_limit` AS `person_limit`,
        `la`.`status` AS `status`,
        `la`.`unit` AS `unit`,
        `la`.`discount_id` AS `discount_id`,
        `td`.`name` AS `discount`,
        `td`.`percent` AS `percent`,
        `la`.`active` AS `active`,
        (SELECT  (CASE ISNULL(SUM(tr.no_units)) WHEN 1 THEN 0 ELSE SUM(tr.no_units) END) 
		FROM trn_schedule ts 
			LEFT OUTER JOIN trn_reservation tr ON tr.id = ts.res_id
		WHERE ts.date = p_date and tr.am_id = p_id) AS booked
    FROM
        `lst_aminities` `la`
        LEFT JOIN `typ_aminities` `ta` ON `ta`.`id` = `la`.`type_id`
        LEFT JOIN `typ_discount` `td` ON `td`.`id` = `la`.`discount_id`) AS lsr
	WHERE lsr.id = p_id;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_customer_reservation` (`p_customer_id` INT)  BEGIN

	SELECT * FROM vw_trn_reservations WHERE cs_id = p_customer_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_reservation_by_id` (`p_id` INT)  BEGIN
	SELECT *, (X.unit_count - X.booked) as available FROM
(

SELECT r.*,
(SELECT  (CASE ISNULL(SUM(tr.no_units)) WHEN 1 THEN 0 ELSE SUM(tr.no_units) END) 
		FROM trn_schedule ts 
			LEFT OUTER JOIN trn_reservation tr ON tr.id = ts.res_id
		WHERE ts.date = r.check_in and tr.am_id = r.am_id) AS booked,
        (SELECT unit FROM lst_aminities WHERE id = r.am_id) AS unit_count
    FROM vw_trn_reservations as r 
    WHERE r.id = p_id) AS X;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_reservation_by_status` (`p_status` VARCHAR(5))  BEGIN
	SELECT * FROM vw_trn_reservations WHERE status = p_status ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_reservation_for_review` ()  BEGIN
	SELECT * FROM vw_trn_reservations WHERE status IN ('S', 'P', 'C');
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_register_customer` (`p_user_account` VARCHAR(30), `p_user_password` VARCHAR(40), `p_name_first` VARCHAR(30), `p_name_middle` VARCHAR(30), `p_name_last` VARCHAR(30), `p_gender` VARCHAR(1), `p_address` VARCHAR(300), `p_contact` VARCHAR(20), `p_age` INT)  BEGIN

	DECLARE p_id INT;

	INSERT INTO user (role_id, user_account, user_password)
    VALUES (2, p_user_account, p_user_password);
    
    SET p_id = last_insert_id();
    
    INSERT INTO user_profile 
    (
    user_id, name_first, name_middle, name_last, 
    gender, address, contact, age
    )
    VALUES 
    (
    p_id, p_name_first, p_name_middle, p_name_last, 
    p_gender, p_address, p_contact, p_age
    );
    
    SELECT p_id as user_id, concat(p_name_first, ' ', p_name_last) as fullname;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_amenity` (`p_id` INT, `p_name` VARCHAR(45), `p_rates` INT(10), `p_unit` INT(11), `p_person_limit` INT(11), `p_type_id` INT(11))  BEGIN

	UPDATE lst_aminities 
    SET     name = p_name, 
		   rates = p_rates,
		   unit = p_unit,
		   person_limit = p_person_limit,
		   type_id = p_type_id    				
    WHERE id = p_id;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_amenity_type` (`p_id` INT, `p_name` VARCHAR(40), `p_rates` DECIMAL(10,2))  BEGIN
	UPDATE 	typ_aminities
	SET	
		name = p_name,
		rates = p_rates
        
	WHERE id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_discount` (`p_id` INT, `p_name` VARCHAR(40), `p_percent` DECIMAL(10,2))  BEGIN

	UPDATE 	typ_discount
    SET		name = p_name,
			percent = p_percent
	WHERE id = p_id;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_reservation_status` (`p_id` INT, `p_status` VARCHAR(1))  BEGIN

	UPDATE trn_reservation SET Status = p_status WHERE id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_reservation_with_changes` (`p_id` INT, `p_status` VARCHAR(1), `p_original` INT, `p_unit` INT)  BEGIN

	UPDATE 	trn_reservation 
    SET 	status = p_status, no_units = p_unit
    WHERE 	id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_reservetion_pay` (`p_id` INT, `p_cs_id` INT, `p_am_id` INT, `p_date` VARCHAR(10))  BEGIN

	DECLARE p_check_date VARCHAR(25);
    
    SET p_check_date = (SELECT check_in FROM trn_reservation WHERE id = p_id);
    
	UPDATE trn_reservation SET Status = 'G' WHERE id = p_id;
    
    INSERT INTO trn_schedule
	(date, am_id, status, cs_id, res_id, stamp)
    VALUES
    (p_check_date, p_am_id, 'B', p_cs_id, p_id, p_date);

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `lst_aminities`
--

CREATE TABLE `lst_aminities` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(45) NOT NULL DEFAULT '',
  `photo` varchar(150) NOT NULL DEFAULT 'default.jpg',
  `rates` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(15) NOT NULL DEFAULT '',
  `active` bit(1) NOT NULL DEFAULT b'0',
  `unit` int(11) DEFAULT 0,
  `discount_id` int(11) DEFAULT 0,
  `person_limit` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lst_aminities`
--

INSERT INTO `lst_aminities` (`id`, `type_id`, `name`, `photo`, `rates`, `status`, `active`, `unit`, `discount_id`, `person_limit`) VALUES
(1, 1, 'TRIANGLE COTTAGE', 'Triangle.jpg', '300.00', 'A', b'1', 3, 1, 2),
(2, 2, 'NIPA HUT COTTAGE I', 'nipa1.jpg', '400.00', 'A', b'1', 1, 1, 20),
(3, 2, 'NIPA HUT COTTAGE II', 'hipa2.jpg', '500.00', 'A', b'1', 1, 1, 25),
(4, 3, 'ROOM', 'room2.jpg', '1000.00', 'A', b'1', 1, 1, 5),
(5, 4, 'FUNCTION HALL', 'hall.jpg', '5000.00', 'A', b'1', 1, 1, 50);

-- --------------------------------------------------------

--
-- Table structure for table `trn_reservation`
--

CREATE TABLE `trn_reservation` (
  `id` int(11) NOT NULL,
  `date` varchar(45) NOT NULL,
  `am_id` int(11) NOT NULL,
  `cs_id` int(11) DEFAULT 0,
  `amount` int(11) DEFAULT 0,
  `no_units` int(11) DEFAULT 0,
  `no_persons` int(11) DEFAULT 0,
  `check_in` varchar(45) DEFAULT '',
  `status` varchar(45) DEFAULT '',
  `discount` decimal(10,2) DEFAULT 0.00,
  `date_in` varchar(25) DEFAULT '',
  `date_out` varchar(25) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trn_reservation`
--

INSERT INTO `trn_reservation` (`id`, `date`, `am_id`, `cs_id`, `amount`, `no_units`, `no_persons`, `check_in`, `status`, `discount`, `date_in`, `date_out`) VALUES
(24, '2021-12-13', 2, 9, 400, 1, 0, '2021-12-12', 'Sent', '0.00', '', ''),
(25, '2021-12-13', 1, 64, 300, 1, 0, '2021-12-16', 'Pending', '0.00', '', ''),
(26, '2021-12-13', 1, 9, 300, 1, 0, '2021-12-12', 'X', '0.00', '', ''),
(33, '2021-12-20', 1, 71, 300, 0, 0, '2021-12-20', 'X', '0.00', '', ''),
(34, '2021-12-20', 1, 71, 300, 1, 0, '2021-12-20', 'G', '0.00', '15:22:58', '15:23:15'),
(35, '2021-12-20', 1, 71, 300, 0, 0, '2021-12-20', 'S', '0.00', '', ''),
(36, '2021-12-20', 1, 72, 300, 1, 0, '2021-12-20', 'P', '0.00', '', ''),
(38, '2021-12-21', 4, 9, 1000, 1, 0, '2021-12-30', 'P', '0.00', '', ''),
(39, '2021-12-22', 1, 9, 300, 1, 0, '2021-12-24', 'P', '0.00', '', ''),
(40, '2021-12-22', 1, 74, 600, 2, 0, '2021-12-23', 'X', '0.00', '', ''),
(41, '2021-12-22', 1, 9, 600, 2, 0, '2021-12-23', 'S', '0.00', '', ''),
(42, '2022-02-25', 1, 9, 300, 1, 0, '2022-02-25', 'P', '0.00', '', ''),
(43, '2022-02-27', 1, 75, 350, 1, 0, '2022-02-27', 'X', '0.00', '', ''),
(44, '2022-03-01', 1, 9, 300, 1, 0, '2022-03-01', 'X', '0.00', '', ''),
(46, '2022-03-19', 1, 9, 300, 1, 0, '2022-03-19', 'G', '0.00', '15:45:28', '15:46:14'),
(47, '2022-04-02', 1, 9, 300, 1, 0, '2022-04-02', 'S', '0.00', '', ''),
(48, '2022-04-02', 1, 9, 300, 1, 0, '2022-04-02', 'X', '0.00', '', ''),
(75, '2022-04-02', 2, 84, 400, 1, 0, '2022-04-02', 'X', '0.00', '', ''),
(79, '2022-04-02', 2, 9, 400, 1, 0, '2022-04-02', 'G', '0.00', '19:19:15', '19:21:04'),
(80, '2022-04-02', 2, 9, 400, 1, 0, '2022-04-02', 'X', '0.00', '', ''),
(81, '2022-04-02', 2, 9, 400, 1, 0, '2022-04-02', 'C', '0.00', '', ''),
(82, '2022-04-02', 2, 88, 400, 1, 0, '2022-04-02', 'X', '0.00', '', ''),
(83, '2022-04-02', 5, 9, 5000, 1, 0, '2022-04-02', 'X', '0.00', '', ''),
(84, '2022-04-02', 5, 9, 5000, 1, 0, '2022-04-02', 'X', '0.00', '', ''),
(85, '2022-04-03', 3, 9, 500, 1, 0, '2022-04-03', 'X', '0.00', '', ''),
(86, '2022-04-03', 5, 9, 5000, 1, 0, '2022-04-03', 'X', '0.00', '', ''),
(87, '2022-04-03', 3, 9, 500, 1, 0, '2022-04-03', 'X', '0.00', '', ''),
(88, '2022-04-03', 1, 89, 300, 1, 0, '2022-04-03', 'X', '0.00', '', ''),
(89, '2022-04-03', 5, 90, 5000, 1, 0, '2022-04-05', 'S', '0.00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `trn_schedule`
--

CREATE TABLE `trn_schedule` (
  `id` int(11) NOT NULL,
  `date` varchar(10) DEFAULT '',
  `am_id` int(11) DEFAULT 0,
  `status` varchar(12) DEFAULT '',
  `cs_id` int(11) DEFAULT 0,
  `res_id` int(11) DEFAULT 0,
  `stamp` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trn_schedule`
--

INSERT INTO `trn_schedule` (`id`, `date`, `am_id`, `status`, `cs_id`, `res_id`, `stamp`) VALUES
(1, '2021-12-09', 1, 'B', 9, 1, '2021-12-10'),
(2, '2021-12-10', 1, 'B', 9, 2, '2021-12-10'),
(3, '2021-12-09', 1, 'B', 9, 3, '2021-12-10'),
(4, '2021-12-10', 1, 'B', 9, 7, '2021-12-10'),
(5, '2021-12-09', 1, 'B', 9, 9, '2021-12-10'),
(6, '2021-12-09', 1, 'B', 9, 10, '2021-12-10'),
(7, '2021-12-09', 2, 'B', 60, 11, '2021-12-10'),
(8, '2021-12-10', 4, 'B', 61, 14, '2021-12-10'),
(9, '2021-12-11', 1, 'B', 9, 16, '2021-12-11'),
(10, '2021-12-10', 9, 'B', 62, 21, '2021-12-11'),
(11, '2021-12-12', 1, 'B', 9, 22, '2021-12-12'),
(12, '2021-12-16', 1, 'B', 64, 25, '2021-12-13'),
(13, '2021-12-12', 1, 'B', 9, 26, '2021-12-13'),
(14, '2021-12-15', 1, 'B', 65, 27, '2021-12-13'),
(15, '2021-12-20', 4, 'B', 67, 28, '2021-12-18'),
(16, '2021-12-20', 1, 'B', 68, 29, '2021-12-20'),
(17, '2021-12-22', 2, 'B', 69, 30, '2021-12-20'),
(18, '2021-12-24', 5, 'B', 70, 31, '2021-12-20'),
(19, '2021-12-21', 1, 'B', 1, 32, '2021-12-20'),
(20, '2021-12-20', 1, 'B', 72, 36, '2021-12-20'),
(21, '2021-12-28', 2, 'B', 73, 37, '2021-12-20'),
(22, '2021-12-30', 4, 'B', 9, 38, '2021-12-21'),
(23, '2021-12-20', 1, 'B', 71, 34, '2021-12-20'),
(24, '2022-03-19', 1, 'B', 9, 46, '2022-03-19'),
(25, '2022-04-02', 2, 'B', 9, 79, '2022-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `typ_aminities`
--

CREATE TABLE `typ_aminities` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `rates` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `typ_aminities`
--

INSERT INTO `typ_aminities` (`id`, `name`, `rates`) VALUES
(1, 'TRIAGLE COTTAGE', '500'),
(2, 'NIPA HOT COTTAGE ', '300'),
(3, 'ROOM', '1000'),
(4, 'HALL', '5000'),
(5, 'bar', '500'),
(30, 'billiard', '2500'),
(31, 'Jaysam M. Casaljay', '2');

-- --------------------------------------------------------

--
-- Table structure for table `typ_discount`
--

CREATE TABLE `typ_discount` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `percent` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `typ_discount`
--

INSERT INTO `typ_discount` (`id`, `name`, `percent`) VALUES
(1, 'NO DISCOUNT', '0.00'),
(3, '20% Discount', '0.20'),
(4, '20% Discount', '0.20'),
(13, '30% Discount', '0.30'),
(15, 'piso la', '0.01'),
(16, 'doz', '0.02');

-- --------------------------------------------------------

--
-- Table structure for table `typ_roles`
--

CREATE TABLE `typ_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `typ_roles`
--

INSERT INTO `typ_roles` (`id`, `name`) VALUES
(1, 'Guest'),
(2, 'Customer'),
(3, 'Staff'),
(4, 'Owner');

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
(3, 2, 'test', '21232f297a57a5a743894a0e4a801fc3'),
(4, 2, 'adx', '202cb962ac59075b964b07152d234b70'),
(5, 2, 'ddd', '77963b7a931377ad4ab5ad6a9cd718aa'),
(6, 2, 'asda', '0cc175b9c0f1b6a831c399e269772661'),
(7, 2, 'asda', '0cc175b9c0f1b6a831c399e269772661'),
(8, 2, 'adam', '202cb962ac59075b964b07152d234b70'),
(9, 2, 'ren', '202cb962ac59075b964b07152d234b70'),
(10, 2, 'adam', '202cb962ac59075b964b07152d234b70'),
(11, 2, 'rens', '827ccb0eea8a706c4c34a16891f84e7b'),
(12, 2, 'ren', '827ccb0eea8a706c4c34a16891f84e7b'),
(13, 2, 'natsu', '60238fbc0ec15fab7cd0eb04309e13ed'),
(14, 2, 'jaysam', 'c51ce410c124a10e0db5e4b97fc2af39'),
(15, 2, 'jaysam', 'c51ce410c124a10e0db5e4b97fc2af39'),
(16, 2, 'jaysam', '202cb962ac59075b964b07152d234b70'),
(17, 2, 'jaysam', '202cb962ac59075b964b07152d234b70'),
(18, 2, 'jaysam', '202cb962ac59075b964b07152d234b70'),
(20, 2, '123', 'e034fb6b66aacc1d48f445ddfb08da98'),
(21, 2, '123', 'e034fb6b66aacc1d48f445ddfb08da98'),
(22, 2, '123', 'e034fb6b66aacc1d48f445ddfb08da98'),
(23, 2, 'jay', '202cb962ac59075b964b07152d234b70'),
(24, 2, 'sa', 'c12e01f2a13ff5587e1e9e4aedb8242d'),
(25, 2, 'rena', '202cb962ac59075b964b07152d234b70'),
(26, 2, 'rena', '202cb962ac59075b964b07152d234b70'),
(27, 2, 'ged', '202cb962ac59075b964b07152d234b70'),
(28, 2, 'aiy', '202cb962ac59075b964b07152d234b70'),
(29, 2, '123', '202cb962ac59075b964b07152d234b70'),
(30, 2, 'renan', '202cb962ac59075b964b07152d234b70'),
(31, 2, 'fgg', '202cb962ac59075b964b07152d234b70'),
(32, 2, 'kevs', '202cb962ac59075b964b07152d234b70'),
(33, 2, 'adam', '202cb962ac59075b964b07152d234b70'),
(34, 2, 'adam', 'e10adc3949ba59abbe56e057f20f883e'),
(35, 2, 'rens', '202cb962ac59075b964b07152d234b70'),
(36, 2, 'nats', '92daa86ad43a42f28f4bf58e94667c95'),
(37, 2, 'haha', '4e4d6c332b6fe62a63afe56171fd3725'),
(38, 2, 'yup', 'cf79ae6addba60ad018347359bd144d2'),
(39, 2, 'yup', '202cb962ac59075b964b07152d234b70'),
(40, 2, 'yup', '202cb962ac59075b964b07152d234b70'),
(41, 2, 'tay', '0a113ef6b61820daa5611c870ed8d5ee'),
(42, 2, 'yet', 'bcbe3365e6ac95ea2c0343a2395834dd'),
(43, 2, 'carla', 'b706835de79a2b4e80506f582af3676a'),
(44, 2, 'car', '15de21c670ae7c3f6f3f1f37029303c9'),
(45, 2, 'wen', 'b0baee9d279d34fa1dfd71aadb908c3f'),
(46, 2, 'sav', '310dcbbf4cce62f762a2aaa148d556bd'),
(47, 2, 'xxx', '202cb962ac59075b964b07152d234b70'),
(48, 2, 'yyy', '202cb962ac59075b964b07152d234b70'),
(49, 2, 'rrr', '81dc9bdb52d04dc20036dbd8313ed055'),
(50, 2, 'rrr', '202cb962ac59075b964b07152d234b70'),
(51, 2, 'yyy', '202cb962ac59075b964b07152d234b70'),
(52, 2, 'ttt', '9990775155c3518a0d7917f7780b24aa'),
(53, 2, 'momo', 'b0baee9d279d34fa1dfd71aadb908c3f'),
(54, 2, 'adam', '202cb962ac59075b964b07152d234b70'),
(55, 2, 'adam', 'd3eb9a9233e52948740d7eb8c3062d14'),
(56, 2, 'tang', 'dcddb75469b4b4875094e14561e573d8'),
(57, 2, 'yas', 'd3eb9a9233e52948740d7eb8c3062d14'),
(58, 2, 'g', 'c4ca4238a0b923820dcc509a6f75849b'),
(59, 2, 'hhh', 'a3aca2964e72000eea4c56cb341002a4'),
(60, 2, 'kkk', 'cb42e130d1471239a27fca6228094f0e'),
(61, 2, 'mam', '698d51a19d8a121ce581499d7b701668'),
(62, 2, 'NATS', '202cb962ac59075b964b07152d234b70'),
(63, 2, 'testt', '202cb962ac59075b964b07152d234b70'),
(64, 2, 'ven', '202cb962ac59075b964b07152d234b70'),
(65, 2, 'mam', '202cb962ac59075b964b07152d234b70'),
(66, 2, 'jason', '827ccb0eea8a706c4c34a16891f84e7b'),
(67, 2, 'ikaw', '202cb962ac59075b964b07152d234b70'),
(68, 2, 'bert', '202cb962ac59075b964b07152d234b70'),
(69, 2, 'narf', '202cb962ac59075b964b07152d234b70'),
(70, 2, 'aling', '202cb962ac59075b964b07152d234b70'),
(71, 2, 'jason', '124c2581ed27bd3e9850c3a72421d65d'),
(72, 2, 'warren123', '91cd058c84a3b24f971b075eb0aa768b'),
(73, 2, 'gg', '202cb962ac59075b964b07152d234b70'),
(74, 2, 'warren', '827ccb0eea8a706c4c34a16891f84e7b'),
(75, 2, 'sam', '202cb962ac59075b964b07152d234b70'),
(76, 2, 'admin', '202cb962ac59075b964b07152d234b70'),
(77, 2, 'admin', '202cb962ac59075b964b07152d234b70'),
(78, 2, 'admin', '202cb962ac59075b964b07152d234b70'),
(79, 2, 'admin', '202cb962ac59075b964b07152d234b70'),
(80, 2, 'admin', '202cb962ac59075b964b07152d234b70'),
(81, 2, 'admin', '202cb962ac59075b964b07152d234b70'),
(82, 2, 'admin', '202cb962ac59075b964b07152d234b70'),
(83, 2, 'admin', '202cb962ac59075b964b07152d234b70'),
(84, 2, 'admin', '202cb962ac59075b964b07152d234b70'),
(85, 2, 'admin', '202cb962ac59075b964b07152d234b70'),
(86, 2, 'admin', '202cb962ac59075b964b07152d234b70'),
(87, 2, 'admin', '202cb962ac59075b964b07152d234b70'),
(88, 2, 'admin', '202cb962ac59075b964b07152d234b70'),
(89, 2, 'carl', '202cb962ac59075b964b07152d234b70'),
(90, 2, 'carl', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT 0,
  `name_first` varchar(30) NOT NULL DEFAULT '',
  `name_middle` varchar(30) NOT NULL DEFAULT '',
  `name_last` varchar(30) NOT NULL DEFAULT '',
  `gender` varchar(6) NOT NULL DEFAULT '',
  `age` int(11) NOT NULL DEFAULT 0,
  `contact` varchar(45) NOT NULL DEFAULT '',
  `address` varchar(150) NOT NULL DEFAULT '',
  `photo` varchar(300) NOT NULL DEFAULT '',
  `mobile` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_id`, `name_first`, `name_middle`, `name_last`, `gender`, `age`, `contact`, `address`, `photo`, `mobile`) VALUES
(1, 2, 'renato', 'judloman', 'solitarios', 'male', 19, '9978473320', 'cogon', '', ''),
(2, 3, 'rechell', 'villarante', 'cajurao', 'feamle', 19, '9978473320', 'nijaga', '', ''),
(12, 11, 'regr', 'eg', 'gfh', 'F', 22, '9978473320', 'fghd', '', ''),
(13, 12, 'werw', 'wragwr', 'wrg', 'F', 12, '9978473320', 'fghd', '', ''),
(14, 13, 'renato', 'j', 'solitarios', 'F', 22, '9978473320', 'Bgy. Cogon Calbayog City', '', ''),
(15, 14, 'Jaysam', 'M.', 'Casaljay', 'M', 34, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(31, 30, 'Jaysam', 'M.', 'Casaljay', 'M', 34, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(32, 31, 'Ailyn', 'M.', 'Ty', 'M', 34, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(33, 32, 'Kevin', 'f', 'santiago', 'M', 24, '9978473320', 'bgy. awang calbayog city', '', ''),
(34, 33, 'diaz', 'g', 'adfg', 'F', 32, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(35, 34, 'diaz', 'g', 'adfg', 'F', 32, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(36, 35, 'diaz', 's', 'dvgsg', 'F', 34, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(37, 36, 'fgjhsr', 'ryjrrjsrsj', 'rjy', 'F', 12, '9978473320', 'j rts', '', ''),
(38, 37, 'njhh', 'juyu', 'uytrt', 'M', 25, '9978473320', 'gfdsa', '', ''),
(39, 38, 'lyn', 's', 'semias', 'F', 23, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(40, 39, 'lyn', 's', 'semias', 'F', 23, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(41, 40, 'lyn', 's', 'semias', 'F', 23, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(42, 41, 'eyt', 'eythter', 'hrt', 'F', 12, '9978473320', 'efwe', '', ''),
(43, 42, 'jullie ann', 'g', 'diaz', 'F', 22, '9978473320', 'Bgy. Cogon Calbayog City', '', ''),
(44, 43, 'carlo', 'g', 'papasin', 'F', 34, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(45, 44, 'carla', 'h', 'papasin', 'M', 22, '9978473320', 'bgy. ipao', '', ''),
(46, 45, 'mic', 'c', 'lacson', 'M', 40, '9978473320', 'Bgy. Cogon Calbayog City', '', ''),
(47, 46, 'mans', 'd', 'yans', 'F', 34, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(48, 47, 'xxx', 'x', 'xxx', 'M', 12, '9978473320', 'Bgy. Cogon Calbayog City', '', ''),
(49, 48, 'yyy', 'yy', 'yyy', 'M', 21, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(50, 49, 'rrr', 'rr', 'rr', 'M', 34, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(51, 50, 'rrr', 'rr', 'rr', 'M', 34, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(52, 51, 'trtr', 'tt', 't', 'M', 34, '9978473320', 'tt', '', ''),
(53, 52, 'Jaysam', 'M.', 'Casaljay', 'M', 21, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(54, 9, 'Juan', 'Santos', 'Dela Cruz', 'F', 100, '9978473320', 'Brgy. Rawis', '', ''),
(55, 53, 'kiko', 'haha', 'jojo', 'M', 25, '9978473320', 'brgy.kfvndfj', '', ''),
(56, 54, 'hhh', 'h', 'jj', 'M', 21, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(57, 55, 'hhh', 'h', 'jj', 'M', 21, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(58, 56, 'lyn', 'h', 'man', 'M', 34, '9978473320', 'Bgy. Cogon Calbayog City', '', ''),
(59, 57, 'ann', 'g', 'diaz', 'F', 23, '9978473320', 'bgy. palanas', '', ''),
(60, 58, 'gg', 'g', 'ggg', 'M', 21, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(61, 59, 'hhh', 'h', 'hh', 'F', 12, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(62, 60, 'mam', 'h', 'ko', 'F', 34, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(63, 61, 'realyn', 'j', 'Baguio', 'F', 30, '9978473320', 'Bgy. Dagum Calbayog', '', ''),
(64, 62, 'NATOT', 'j', 'SOLITARIOS ', 'M', 22, '9978473320', 'Bgy. Cogon Calbayog City', '', ''),
(65, 63, 'test', 'tes', 'teeee', 'M', 78, '9978473320', 'Bgy. Rawis Calbayog City', '', ''),
(66, 64, 'kevin', 'lentejas', 'santiago', 'M', 24, '9978473320', 'bgy. awang calbayog city', '', ''),
(67, 65, 'Rialyn', 'v', 'Baguio', 'M', 26, '9978473320', 'bgy. Dagum', '', ''),
(68, 66, 'jason', 'calagos', 'sagadal', 'M', 24, '9978473320', 'brgy rawis', '', ''),
(70, 68, 'juan', 'c', 'cruz', 'M', 30, '9978473320', 'Bgy. Awang Calbayog City', '', ''),
(71, 69, 'narf', 'f', 'maligaya', 'M', 34, '9978473320', 'bgy. awang calbayog city', '', ''),
(72, 70, 'Aling', 'd', 'mahinay', 'F', 34, '9978473320', 'Bgy. Cogon Calbayog City', '', ''),
(73, 71, 'jason', 'calagos', 'sagadal', 'M', 24, '9978473320', 'brgy. rawis', '', ''),
(74, 72, 'Warren Hero', 'Robles', 'Calagos', 'M', 23, '9978473320', 'Brgy. San Policarpo Calbayog City', '', ''),
(75, 73, 'gg', 'g', 'gg', 'M', 34, '9978473320', 'bgy. awang calbayog city', '', ''),
(76, 74, 'warren', 'robles', 'calagos', 'M', 20, '0912544214', 'brgy ipao', '', ''),
(77, 75, 'Jaysam', 'M.', 'Casaljay', 'M', 34, '09978473320', 'Bgy. Rawis Calbayog City', '', ''),
(78, 76, 'Marian', 'd', 'Rivera', 'F', 30, '09235555454', 'Bgy. Rawis Calbayog City', '', ''),
(79, 77, 'Marian', 'd', 'Rivera', 'F', 30, '09235555454', 'Bgy. Rawis Calbayog City', '', ''),
(80, 78, 'Marian', 'd', 'Rivera', 'F', 30, '09235555454', 'Bgy. Rawis Calbayog City', '', ''),
(81, 79, 'Marian', 'd', 'Rivera', 'F', 30, '09235555454', 'Bgy. Rawis Calbayog City', '', ''),
(82, 80, 'Marian', 'd', 'Rivera', 'F', 30, '09235555454', 'Bgy. Rawis Calbayog City', '', ''),
(83, 81, 'Marian', 'd', 'Rivera', 'F', 30, '09235555454', 'Bgy. Rawis Calbayog City', '', ''),
(84, 82, 'Marian', 'd', 'Rivera', 'F', 30, '09235555454', 'Bgy. Rawis Calbayog City', '', ''),
(85, 83, 'Marian', 'd', 'Rivera', 'F', 30, '09235555454', 'Bgy. Rawis Calbayog City', '', ''),
(86, 84, 'Marian', 'd', 'Rivera', 'F', 30, '09235555454', 'Bgy. Rawis Calbayog City', '', ''),
(87, 85, 'Marian', 'd', 'Rivera', 'F', 30, '09235555454', 'Bgy. Rawis Calbayog City', '', ''),
(88, 86, 'Marian', 'd', 'Rivera', 'F', 30, '09235555454', 'Bgy. Rawis Calbayog City', '', ''),
(89, 87, 'Marian', 'd', 'Rivera', 'F', 30, '09235555454', 'Bgy. Rawis Calbayog City', '', ''),
(90, 88, 'Marian', 'd', 'Rivera', 'F', 30, '09235555454', 'Bgy. Rawis Calbayog City', '', ''),
(91, 89, 'carlo', 'b', 'Papasin', 'M', 23, '09978473320', 'Bgy. Ipao Calbayog City', '', ''),
(92, 90, 'Carla', 'B', 'Papasin', 'M', 23, '09978473320', 'Bgy. Ipao Calbayog City', '', '');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_lst_amenities`
-- (See below for the actual view)
--
CREATE TABLE `vw_lst_amenities` (
`id` int(11)
,`type_id` int(11)
,`type` varchar(45)
,`name` varchar(45)
,`photo` varchar(150)
,`rates` decimal(10,2)
,`status` varchar(15)
,`unit` int(11)
,`discount_id` int(11)
,`discount` varchar(45)
,`percent` decimal(10,2)
,`active` bit(1)
,`person_limit` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_rpt_reservation`
-- (See below for the actual view)
--
CREATE TABLE `vw_rpt_reservation` (
`date` varchar(45)
,`sales` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_trn_reservations`
-- (See below for the actual view)
--
CREATE TABLE `vw_trn_reservations` (
`id` int(11)
,`date` varchar(45)
,`am_id` int(11)
,`aminity` varchar(45)
,`cs_id` int(11)
,`customer` varchar(61)
,`address` varchar(150)
,`contact` varchar(45)
,`age` int(11)
,`gender` varchar(6)
,`amount` int(11)
,`no_units` int(11)
,`no_persons` int(11)
,`check_in` varchar(45)
,`status` varchar(45)
,`discount` decimal(10,2)
,`date_in` varchar(25)
,`date_out` varchar(25)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_users`
-- (See below for the actual view)
--
CREATE TABLE `vw_users` (
`user_id` int(11)
,`role_id` int(11)
,`role` varchar(45)
,`user_account` varchar(50)
,`user_password` varchar(35)
,`fullname` varchar(61)
,`address` varchar(150)
,`contact` varchar(45)
,`age` int(11)
,`gender` varchar(6)
,`photo` varchar(6)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_lst_amenities`
--
DROP TABLE IF EXISTS `vw_lst_amenities`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_lst_amenities`  AS SELECT `la`.`id` AS `id`, `la`.`type_id` AS `type_id`, `ta`.`name` AS `type`, `la`.`name` AS `name`, `la`.`photo` AS `photo`, `la`.`rates` AS `rates`, `la`.`status` AS `status`, `la`.`unit` AS `unit`, `la`.`discount_id` AS `discount_id`, `td`.`name` AS `discount`, `td`.`percent` AS `percent`, `la`.`active` AS `active`, `la`.`person_limit` AS `person_limit` FROM ((`lst_aminities` `la` left join `typ_aminities` `ta` on(`ta`.`id` = `la`.`type_id`)) left join `typ_discount` `td` on(`td`.`id` = `la`.`discount_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_rpt_reservation`
--
DROP TABLE IF EXISTS `vw_rpt_reservation`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_rpt_reservation`  AS SELECT `r`.`date` AS `date`, sum(`r`.`amount`) AS `sales` FROM `trn_reservation` AS `r` WHERE `r`.`status` = 'G' GROUP BY `r`.`date` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_trn_reservations`
--
DROP TABLE IF EXISTS `vw_trn_reservations`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_trn_reservations`  AS SELECT `tr`.`id` AS `id`, `tr`.`date` AS `date`, `tr`.`am_id` AS `am_id`, `la`.`name` AS `aminity`, `tr`.`cs_id` AS `cs_id`, `u`.`fullname` AS `customer`, `u`.`address` AS `address`, `u`.`contact` AS `contact`, `u`.`age` AS `age`, `u`.`gender` AS `gender`, `tr`.`amount` AS `amount`, `tr`.`no_units` AS `no_units`, `tr`.`no_persons` AS `no_persons`, `tr`.`check_in` AS `check_in`, `tr`.`status` AS `status`, `tr`.`discount` AS `discount`, `tr`.`date_in` AS `date_in`, `tr`.`date_out` AS `date_out` FROM ((`trn_reservation` `tr` left join `lst_aminities` `la` on(`la`.`id` = `tr`.`am_id`)) left join `vw_users` `u` on(`u`.`user_id` = `tr`.`cs_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_users`
--
DROP TABLE IF EXISTS `vw_users`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_users`  AS SELECT `u`.`user_id` AS `user_id`, `u`.`role_id` AS `role_id`, `r`.`name` AS `role`, `u`.`user_account` AS `user_account`, `u`.`user_password` AS `user_password`, concat(`up`.`name_first`,' ',`up`.`name_last`) AS `fullname`, `up`.`address` AS `address`, `up`.`contact` AS `contact`, `up`.`age` AS `age`, `up`.`gender` AS `gender`, `up`.`gender` AS `photo` FROM ((`user` `u` left join `user_profile` `up` on(`up`.`user_id` = `u`.`user_id`)) left join `typ_roles` `r` on(`r`.`id` = `u`.`role_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lst_aminities`
--
ALTER TABLE `lst_aminities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trn_reservation`
--
ALTER TABLE `trn_reservation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trn_schedule`
--
ALTER TABLE `trn_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `typ_aminities`
--
ALTER TABLE `typ_aminities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `typ_discount`
--
ALTER TABLE `typ_discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `typ_roles`
--
ALTER TABLE `typ_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lst_aminities`
--
ALTER TABLE `lst_aminities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `trn_reservation`
--
ALTER TABLE `trn_reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `trn_schedule`
--
ALTER TABLE `trn_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `typ_aminities`
--
ALTER TABLE `typ_aminities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `typ_discount`
--
ALTER TABLE `typ_discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `typ_roles`
--
ALTER TABLE `typ_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
