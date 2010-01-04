<?php

class Default_Model_Install
{
	public static function createTables($db){
		$sql = "CREATE TABLE IF NOT EXISTS `news` (
  			`id` int(11) NOT NULL auto_increment,
  			`title` varchar(64) NOT NULL,
  			`summary` varchar(255) NOT NULL,
  			`content` longtext NOT NULL,
  			`author` varchar(128) NOT NULL,
  			`created` datetime NOT NULL default '0000-00-00 00:00:00',
  			`modified` datetime NOT NULL default '0000-00-00 00:00:00',
  			`views` int(11) NOT NULL,
  			PRIMARY KEY  (`id`),
  			KEY `title` (`title`,`summary`,`author`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Holds News story meta data'";
		$db->query ( $sql );
		$sql2 = "CREATE TABLE IF NOT EXISTS `members` (
  			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `fname` varchar(25) NOT NULL,
			  `lname` varchar(50) NOT NULL,
			  `uname` varchar(25) NOT NULL,
			  `pword` varchar(255) NOT NULL,
			  `email` varchar(150) NOT NULL,
			  `active` set('0','1') default '0' NOT NULL,
			  `joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1";
		$db->query ( $sql2 );
		$sql3 = "insert into members (fname, lname, uname, pword, email, active) values ('Admin','Istrator','admin','0192023a7bbd73250516f069df18b500','admin@example.com','1')";
		$db->query($sql3);
		$sql4 = "create table if not exists `categories` (`id` int(11) not null auto_increment, `parent_id` int(11) not null, `name` varchar(64) not null, primary key (`id`))";
		$db->query($sql4);
	}
}
