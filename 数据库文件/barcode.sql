-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-09-08 18:05:20
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `barcode`
--

-- --------------------------------------------------------

--
-- 表的结构 `filedata`
--

CREATE TABLE IF NOT EXISTS `filedata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ctime` varchar(20) NOT NULL DEFAULT '0' COMMENT '订单日期',
  `danhao` varchar(10) NOT NULL DEFAULT '0' COMMENT '货主出库单号',
  `adress` varchar(50) NOT NULL DEFAULT '0' COMMENT '送货地址',
  `tiaoma` varchar(20) NOT NULL DEFAULT '0' COMMENT '条码',
  `uptime` varchar(20) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `filename` varchar(30) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ctime` (`ctime`),
  KEY `tiaoma` (`tiaoma`),
  KEY `adress` (`adress`),
  KEY `danhao` (`danhao`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='出货的数据' AUTO_INCREMENT=4068 ;

-- --------------------------------------------------------

--
-- 表的结构 `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `pw` varchar(50) NOT NULL,
  `gl` int(1) NOT NULL DEFAULT '0' COMMENT '管理员',
  `u_k` int(1) NOT NULL DEFAULT '0' COMMENT '解锁',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `unlock` (`u_k`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
