-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2021 at 04:36 PM
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
	SELECT * FROM vw_trn_reservations WHERE status IN ('S', 'P');
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
    SET 	status = p_status, original = p_original, no_units = p_unit
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
(66, 2, 'jason', '827ccb0eea8a706c4c34a16891f84e7b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
