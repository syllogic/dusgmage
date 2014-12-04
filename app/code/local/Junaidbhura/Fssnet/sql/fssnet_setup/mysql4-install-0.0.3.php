<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
CREATE TABLE `{$this->getTable( 'junaidbhura_fssnet_redirect' )}` (
  `fssnet_redirect_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `action` varchar(20) NOT NULL,
  `langid` varchar(20) NOT NULL,
  `currencycode` varchar(15) NOT NULL,
  `amt` float unsigned NOT NULL,
  `response_url` varchar(255) NOT NULL,
  `error_url` varchar(255) NOT NULL,
  `trackid` varchar(20) NOT NULL,
  `udf1` varchar(255) NOT NULL,
  `udf2` varchar(255) NOT NULL,
  `udf3` varchar(255) NOT NULL,
  `udf4` varchar(255) NOT NULL,
  `udf5` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `fssnet_redirect_ip` varchar(50) NOT NULL,
  `fssnet_redirect_dtime` datetime NOT NULL,
  PRIMARY KEY (`fssnet_redirect_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `{$this->getTable( 'junaidbhura_fssnet_response' )}` (
  `fssnet_response_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `response_ip` varchar(25) NOT NULL,
  `error` varchar(255) NOT NULL,
  `error_text` varchar(255) NOT NULL,
  `paymentid` varchar(255) NOT NULL,
  `trackid` varchar(255) NOT NULL,
  `result` varchar(100) NOT NULL,
  `tranid` varchar(255) NOT NULL,
  `amt` float unsigned NOT NULL,
  `fssnet_response_ip` varchar(50) NOT NULL,
  `fssnet_response_dtime` datetime NOT NULL,
  PRIMARY KEY (`fssnet_response_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQLTEXT;

$installer->run($sql);

$installer->endSetup();