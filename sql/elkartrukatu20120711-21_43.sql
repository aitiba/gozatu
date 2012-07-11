-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 11, 2012 at 09:43 PM
-- Server version: 5.1.63
-- PHP Version: 5.3.6-13ubuntu3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `elkartrukatu`
--

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `url`, `created`, `ip`) VALUES
(1, 'http://aitoribanez.com/fc/', '2012-02-07 03:34:59', '127.0.0.1'),
(2, 'http://www.20minutos.es/noticia/1454100/0/', '2012-02-07 03:36:33', '127.0.0.1'),
(3, 'http://aitoribanez.com', '2012-02-07 03:38:09', '127.0.0.1'),
(4, 'http://aitoribanez.com', '2012-02-07 03:38:18', '127.0.0.1'),
(5, 'http://www.20minutos.es/noticia/1454100/0/', '2012-02-07 03:38:34', '127.0.0.1'),
(6, 'adads', '2012-02-07 03:54:38', '127.0.0.1'),
(7, 'asdasd', '2012-02-07 03:54:44', '127.0.0.1'),
(8, 'data', '2012-02-07 03:55:22', '127.0.0.1'),
(9, 'data2', '2012-02-07 03:57:27', '127.0.0.1'),
(10, 'https://github.com/nacmartin/gozame', '2012-02-07 03:58:00', '127.0.0.1'),
(11, 'http://duckduckgo.com/?q=javascriptq%3D(escape(document.location.href))%3B', '2012-02-07 03:58:36', '127.0.0.1'),
(12, 'http://www.youtube.com/watch?v=95P4sgsmHqU&feature=plcp', '2012-02-07 03:59:13', '127.0.0.1'),
(13, 'http://sf.khepin.com/2011/04/a-first-silex-project/', '2012-02-07 04:26:18', '127.0.0.1'),
(14, 'http://kortxohack.wikispaces.com/', '2012-02-07 04:31:31', '127.0.0.1'),
(15, 'aaa', '2012-02-07 04:31:50', '127.0.0.1'),
(16, 'aaa', '2012-02-07 04:31:56', '127.0.0.1'),
(17, 'https://github.com/asiermarques/Leophard/tree/master/Lib/Core', '2012-04-07 02:15:48', '127.0.0.1'),
(18, 'http://sftuts.com/doc/jobeet/en/the-admin-generator', '2012-05-07 22:10:42', '127.0.0.1'),
(19, 'http://www.deia.com/2012/06/24/opinion/tribuna-abierta/legalizado-sortu-se-define-el-escenario-electoral-vasco', '2012-07-07 20:23:27', '127.0.0.1'),
(20, 'http://www.youtube.com/watch?feature=player_embedded&v=atqIlwCevQo', '2012-10-07 21:56:13', '127.0.0.1'),
(21, 'http://kinout.tapquo.com/sublime/#/', '2012-10-07 22:06:49', '127.0.0.1'),
(22, 'http://vimeo.com/45164852', '2012-11-07 16:25:37', '127.0.0.1'),
(23, 'http://www.etnassoft.com/biblioteca/phpunit-manual/', '2012-11-07 21:41:37', '127.0.0.1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
