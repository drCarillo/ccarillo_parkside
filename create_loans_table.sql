--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `loan_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `loan_type` tinyint(1) unsigned NOT NULL,
  `borrower_ssn` int(9) unsigned NOT NULL,
  `property_value` decimal(13,4) DEFAULT NULL,
  `loan_amount` decimal(13,4) DEFAULT NULL,
  `loan_status` tinyint(1) unsigned DEFAULT NULL,
  `loan_application_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`loan_id`),
  KEY `borrower_ssn` (`borrower_ssn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;