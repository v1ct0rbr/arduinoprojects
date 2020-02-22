-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 23-Fev-2016 às 05:54
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bombadagua`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `pp_usuario`
--

CREATE TABLE IF NOT EXISTS `pp_usuario` (
  `usu_id` int(11) NOT NULL AUTO_INCREMENT,
  `usu_login` varchar(60) NOT NULL,
  `usu_password` varchar(64) DEFAULT NULL,
  `usu_token_sessao` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`usu_id`),
  UNIQUE KEY `usu_login_UNIQUE` (`usu_login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `pp_usuario`
--

INSERT INTO `pp_usuario` (`usu_id`, `usu_login`, `usu_password`, `usu_token_sessao`) VALUES
(1, 'admin', 'a2513ea84d5f0deae1f389d5b4952b0d5a8c9cd672d98ced3fe03d7bf37f65e5', 'beb7a3c3266c14c146f9955bb96b185882896bb8ebbf7a57acb9b4cf77dab174');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
