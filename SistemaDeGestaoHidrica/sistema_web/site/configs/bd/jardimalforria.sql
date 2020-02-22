-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2015 at 07:50 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jardimalforria`
--

-- --------------------------------------------------------

--
-- Table structure for table `jatbl_categoria`
--

CREATE TABLE IF NOT EXISTS `jatbl_categoria` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_nome` varchar(100) DEFAULT NULL,
  `cat_detalhes` varchar(256) DEFAULT NULL,
  `cat_ativo` tinyint(4) DEFAULT NULL,
  `cat_ordem` int(11) DEFAULT NULL,
  `cat_link` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `ind_cat_link` (`cat_link`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jatbl_evento`
--

CREATE TABLE IF NOT EXISTS `jatbl_evento` (
  `eve_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `eve_link` varchar(100) DEFAULT NULL,
  `eve_titulo_pt` varchar(100) DEFAULT NULL,
  `eve_titulo_en` varchar(100) DEFAULT NULL,
  `eve_titulo_fr` varchar(100) DEFAULT NULL,
  `eve_descricao_pt` text,
  `eve_descricao_en` text,
  `eve_descricao_fr` text,
  `eve_data_cadastro` datetime DEFAULT NULL,
  `eve_data_inicio_evento` datetime DEFAULT NULL,
  `eve_data_fim_evento` datetime DEFAULT NULL,
  `eve_data_atualizacao` datetime DEFAULT NULL,
  `eve_usuario_cadastro` int(11) DEFAULT NULL,
  `eve_diretorio` varchar(256) DEFAULT NULL,
  `eve_lotado` tinyint(1) DEFAULT '0',
  `eve_encerrado` tinyint(1) DEFAULT '0',
  `eve_ativo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`eve_id`),
  UNIQUE KEY `eve_link_UNIQUE` (`eve_link`),
  KEY `fk_usuario_cadastro_id_idx` (`eve_usuario_cadastro`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jatbl_imagem`
--

CREATE TABLE IF NOT EXISTS `jatbl_imagem` (
  `img_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `img_nome` varchar(100) DEFAULT NULL,
  `img_diretorio` varchar(256) DEFAULT NULL,
  `img_data` datetime DEFAULT NULL,
  `img_evento_id` bigint(20) DEFAULT NULL,
  `img_noticia_id` bigint(20) DEFAULT NULL,
  `img_instalacoes` tinyint(1) DEFAULT '0',
  `img_is_banner` tinyint(1) DEFAULT NULL,
  `img_principal` tinyint(4) DEFAULT NULL,
  `img_ordem` int(11) DEFAULT '1',
  `img_titulo` varchar(100) DEFAULT NULL,
  `img_observacao` varchar(256) DEFAULT NULL,
  `img_ativo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`img_id`),
  KEY `fk_evento_id_idx` (`img_evento_id`),
  KEY `fk_jatbl_imagem_jatbl_noticia1_idx` (`img_noticia_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=183 ;

--
-- Dumping data for table `jatbl_imagem`
--

INSERT INTO `jatbl_imagem` (`img_id`, `img_nome`, `img_diretorio`, `img_data`, `img_evento_id`, `img_noticia_id`, `img_instalacoes`, `img_is_banner`, `img_principal`, `img_ordem`, `img_titulo`, `img_observacao`, `img_ativo`) VALUES
(45, '1424708101.jpg', '', '2015-02-23 13:15:01', NULL, NULL, 0, 1, 0, 3, '', '', 1),
(88, '1425261202.jpg', '', '2015-03-01 22:53:22', NULL, NULL, 0, 1, 0, 1, '', '', 1),
(125, '1425739862.jpg', '', '2015-03-07 11:51:02', NULL, NULL, 0, 1, 0, 2, '', '', 1),
(141, '1425842316_8.jpg', '2015/3', '2015-03-08 16:18:36', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(142, '1425842316_9.jpg', '2015/3', '2015-03-08 16:18:36', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(143, '1425842316_10.jpg', '2015/3', '2015-03-08 16:18:36', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(144, '1425842316_11.jpg', '2015/3', '2015-03-08 16:18:36', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(145, '1425842316_12.jpg', '2015/3', '2015-03-08 16:18:36', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(146, '1425842317_13.jpg', '2015/3', '2015-03-08 16:18:37', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(147, '1425842317_14.jpg', '2015/3', '2015-03-08 16:18:37', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(148, '1425842317_15.jpg', '2015/3', '2015-03-08 16:18:37', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(149, '1425842345_16.jpg', '2015/3', '2015-03-08 16:19:05', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(150, '1425842346_17.jpg', '2015/3', '2015-03-08 16:19:06', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(151, '1425842346_18.jpg', '2015/3', '2015-03-08 16:19:06', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(152, '1425842347_19.jpg', '2015/3', '2015-03-08 16:19:07', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(153, '1425842347_20.jpg', '2015/3', '2015-03-08 16:19:07', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(154, '1425842347_21.jpg', '2015/3', '2015-03-08 16:19:07', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(155, '1425842347_22.jpg', '2015/3', '2015-03-08 16:19:07', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(156, '1425842347_23.jpg', '2015/3', '2015-03-08 16:19:07', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(157, '1425842348_24.jpg', '2015/3', '2015-03-08 16:19:08', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(158, '1425842348_25.jpg', '2015/3', '2015-03-08 16:19:08', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(159, '1425842348_26.jpg', '2015/3', '2015-03-08 16:19:08', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(160, '1425842348_27.jpg', '2015/3', '2015-03-08 16:19:08', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(161, '1425842349_28.jpg', '2015/3', '2015-03-08 16:19:09', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(162, '1425842349_29.jpg', '2015/3', '2015-03-08 16:19:09', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(163, '1425842349_30.jpg', '2015/3', '2015-03-08 16:19:09', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(164, '1425842349_31.jpg', '2015/3', '2015-03-08 16:19:09', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(165, '1425842349_32.jpg', '2015/3', '2015-03-08 16:19:09', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(166, '1425842350_33.jpg', '2015/3', '2015-03-08 16:19:10', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(167, '1425842350_34.jpg', '2015/3', '2015-03-08 16:19:10', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(168, '1425842350_35.jpg', '2015/3', '2015-03-08 16:19:10', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(169, '1425842351_36.jpg', '2015/3', '2015-03-08 16:19:11', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(170, '1425842351_37.jpg', '2015/3', '2015-03-08 16:19:11', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(171, '1425842351_38.jpg', '2015/3', '2015-03-08 16:19:11', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(172, '1425842351_39.jpg', '2015/3', '2015-03-08 16:19:11', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(173, '1425842352_40.jpg', '2015/3', '2015-03-08 16:19:12', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(174, '1425842352_41.jpg', '2015/3', '2015-03-08 16:19:12', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(175, '1425842352_42.jpg', '2015/3', '2015-03-08 16:19:12', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(176, '1425842352_43.jpg', '2015/3', '2015-03-08 16:19:12', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(177, '1425842353_44.jpg', '2015/3', '2015-03-08 16:19:13', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(178, '1425842353_45.jpg', '2015/3', '2015-03-08 16:19:13', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(179, '1425842353_46.jpg', '2015/3', '2015-03-08 16:19:13', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(180, '1425842353_47.jpg', '2015/3', '2015-03-08 16:19:13', NULL, NULL, 1, NULL, 0, 1, NULL, NULL, 1),
(181, '1425842354_48.jpg', '2015/3', '2015-03-08 16:19:14', NULL, NULL, 1, NULL, 0, 1, 'quartos', 'testes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jatbl_noticia`
--

CREATE TABLE IF NOT EXISTS `jatbl_noticia` (
  `not_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `not_titulo_pt` varchar(100) DEFAULT NULL,
  `not_titulo_en` varchar(100) DEFAULT NULL,
  `not_titulo_fr` varchar(100) DEFAULT NULL,
  `not_descricao_pt` text,
  `not_descricao_en` text,
  `not_descricao_fr` text,
  `not_data_criacao` datetime DEFAULT NULL,
  `not_ultima_atualizacao` datetime DEFAULT NULL,
  `not_link` varchar(100) DEFAULT NULL,
  `not_usuario_cadastro` int(11) DEFAULT NULL,
  `not_ativo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`not_id`),
  KEY `ind_link` (`not_link`),
  KEY `fk_not_usuario_cadastro_id_idx` (`not_usuario_cadastro`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jatbl_noticia_categoria`
--

CREATE TABLE IF NOT EXISTS `jatbl_noticia_categoria` (
  `not_categoria_id` int(11) NOT NULL,
  `not_noticia_id` bigint(20) NOT NULL,
  PRIMARY KEY (`not_categoria_id`,`not_noticia_id`),
  KEY `fk_not_noticia_id_idx` (`not_noticia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jatbl_operacao`
--

CREATE TABLE IF NOT EXISTS `jatbl_operacao` (
  `ope_id` int(11) NOT NULL,
  `ope_nome` varchar(100) DEFAULT NULL,
  `ope_descricao` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`ope_id`),
  UNIQUE KEY `ope_nome_UNIQUE` (`ope_nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jatbl_operacao`
--

INSERT INTO `jatbl_operacao` (`ope_id`, `ope_nome`, `ope_descricao`) VALUES
(1, 'login', NULL),
(2, 'auto update', 'atualização do perfil'),
(3, 'Cadastro de Notícia', NULL),
(4, 'Atualização de Notícia', NULL),
(5, 'Exclusão de Notícia', NULL),
(6, 'Cadastro de categoria', NULL),
(7, 'Atualização de categoria', NULL),
(8, 'exclusão de categoria', NULL),
(9, 'cadastro de evento', NULL),
(10, 'atualização de evento', NULL),
(11, 'exclusão de evento', NULL),
(12, 'upload de imagens - evento', NULL),
(13, 'upload de imagens - banner', NULL),
(14, 'upload de imagens - instalações', NULL),
(15, 'exclusão de imagens - evento', NULL),
(16, 'exclusão de imagens - banner', NULL),
(17, 'exclusão de imagens - instalações', NULL),
(18, 'Atualizar usuário', NULL),
(19, 'gerar nova senha de usuário', NULL),
(20, 'exclusão de usuário', NULL),
(21, 'exclusao de imagem de evento', NULL),
(22, 'exclusao de imagem de banner', NULL),
(23, 'exclusao de imagem de instalacao', NULL),
(24, 'cadastro de usuario', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jatbl_operacao_usuario`
--

CREATE TABLE IF NOT EXISTS `jatbl_operacao_usuario` (
  `ope_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ope_usuario_id` int(11) DEFAULT NULL,
  `ope_operacao_id` int(11) DEFAULT NULL,
  `ope_data` datetime DEFAULT NULL,
  `ope_ip` varchar(45) DEFAULT NULL,
  `ope_details` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`ope_id`),
  KEY `fk_usu_id_idx` (`ope_usuario_id`),
  KEY `fk_ope_id_idx` (`ope_operacao_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jatbl_reserva`
--

CREATE TABLE IF NOT EXISTS `jatbl_reserva` (
  `res_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `res_nome` varchar(100) DEFAULT NULL,
  `res_email` varchar(100) DEFAULT NULL,
  `res_telefone` varchar(13) DEFAULT NULL,
  `res_assunto` varchar(256) DEFAULT NULL,
  `res_detalhes` varchar(2048) DEFAULT NULL,
  `res_numero_pessoas` int(11) DEFAULT NULL,
  `res_data_reserva` datetime DEFAULT NULL,
  `res_evento_id` bigint(20) DEFAULT NULL,
  `res_ativo` tinyint(1) DEFAULT '1',
  `res_aprovado` tinyint(1) DEFAULT '0',
  `res_presenca_confirmada` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`res_id`),
  KEY `fk_res_evento_id_idx` (`res_evento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jatbl_tag`
--

CREATE TABLE IF NOT EXISTS `jatbl_tag` (
  `tag_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tag_nome` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `tag_nome_UNIQUE` (`tag_nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jatbl_tag_noticia`
--

CREATE TABLE IF NOT EXISTS `jatbl_tag_noticia` (
  `not_tag_id` bigint(20) NOT NULL,
  `not_noticia_id` bigint(20) NOT NULL,
  PRIMARY KEY (`not_tag_id`,`not_noticia_id`),
  KEY `fk_tag_noticia_id_idx` (`not_noticia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jatbl_teste`
--

CREATE TABLE IF NOT EXISTS `jatbl_teste` (
  `tes_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tes_texto` text,
  `tes_data` datetime DEFAULT NULL,
  PRIMARY KEY (`tes_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jatbl_usuario`
--

CREATE TABLE IF NOT EXISTS `jatbl_usuario` (
  `usu_id` int(11) NOT NULL AUTO_INCREMENT,
  `usu_nome` varchar(100) DEFAULT NULL,
  `usu_login` varchar(100) DEFAULT NULL,
  `usu_email` varchar(100) DEFAULT NULL,
  `usu_password` varchar(100) DEFAULT NULL,
  `usu_data_criacao` datetime DEFAULT NULL,
  `usu_token_sessao` varchar(256) DEFAULT NULL,
  `usu_bloqueado` varchar(45) DEFAULT '0',
  `usu_data_bloqueio` datetime DEFAULT NULL,
  `usu_masteradmin` tinyint(1) DEFAULT '0',
  `usu_trocar_senha` tinyint(1) DEFAULT '1',
  `usu_ativado` tinyint(1) DEFAULT '1',
  `usu_ultima_alteracao_senha` datetime DEFAULT NULL,
  PRIMARY KEY (`usu_id`),
  UNIQUE KEY `usu_login_UNIQUE` (`usu_login`),
  UNIQUE KEY `usu_email_UNIQUE` (`usu_email`),
  KEY `usu_password` (`usu_password`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jatbl_usuario`
--

INSERT INTO `jatbl_usuario` (`usu_id`, `usu_nome`, `usu_login`, `usu_email`, `usu_password`, `usu_data_criacao`, `usu_token_sessao`, `usu_bloqueado`, `usu_data_bloqueio`, `usu_masteradmin`, `usu_trocar_senha`, `usu_ativado`, `usu_ultima_alteracao_senha`) VALUES
(1, 'victor', 'victor', 'victor@vivasoft.com.br', 'eae30423f94a2b91aa5b9a2f8094e454c4136a82463a51925efc520afb6c25de', '2015-01-28 18:16:38', 'bf6489fc5379d4d734bf89104f70fc0af15101148cec1745f5ebaf428eedd097', '0', NULL, 1, 1, 1, '2015-03-07 08:53:36'),
(2, 'victor henrique', 'victorhenrique', 'victorhenrique.jp@gmail.com', 'bfd4c50dc01f0af26249efaaf2be854c263852bb139d629fcf0d156111db8c95', '2015-03-07 23:08:10', '9a44b273310368a37d3c9760b59a67310787c5f6e35b3293a458c6e1a87fce1f', '0', NULL, 0, 1, 1, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jatbl_evento`
--
ALTER TABLE `jatbl_evento`
  ADD CONSTRAINT `fk_eve_usuario_cadastro_id` FOREIGN KEY (`eve_usuario_cadastro`) REFERENCES `jatbl_usuario` (`usu_id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `jatbl_imagem`
--
ALTER TABLE `jatbl_imagem`
  ADD CONSTRAINT `fk_img_evento_id` FOREIGN KEY (`img_evento_id`) REFERENCES `jatbl_evento` (`eve_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_img_noticia_id` FOREIGN KEY (`img_noticia_id`) REFERENCES `jatbl_noticia` (`not_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `jatbl_noticia`
--
ALTER TABLE `jatbl_noticia`
  ADD CONSTRAINT `fk_not_usuario_cadastro_id` FOREIGN KEY (`not_usuario_cadastro`) REFERENCES `jatbl_usuario` (`usu_id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `jatbl_noticia_categoria`
--
ALTER TABLE `jatbl_noticia_categoria`
  ADD CONSTRAINT `fk_not_categoria_id` FOREIGN KEY (`not_categoria_id`) REFERENCES `jatbl_categoria` (`cat_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_not_noticia_id` FOREIGN KEY (`not_noticia_id`) REFERENCES `jatbl_noticia` (`not_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `jatbl_operacao_usuario`
--
ALTER TABLE `jatbl_operacao_usuario`
  ADD CONSTRAINT `fk_ope_operacao_id` FOREIGN KEY (`ope_operacao_id`) REFERENCES `jatbl_operacao` (`ope_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ope_usuario_id` FOREIGN KEY (`ope_usuario_id`) REFERENCES `jatbl_usuario` (`usu_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `jatbl_reserva`
--
ALTER TABLE `jatbl_reserva`
  ADD CONSTRAINT `fk_res_evento_id` FOREIGN KEY (`res_evento_id`) REFERENCES `jatbl_evento` (`eve_id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `jatbl_tag_noticia`
--
ALTER TABLE `jatbl_tag_noticia`
  ADD CONSTRAINT `fk_tag_id` FOREIGN KEY (`not_tag_id`) REFERENCES `jatbl_tag` (`tag_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tag_noticia_id` FOREIGN KEY (`not_noticia_id`) REFERENCES `jatbl_noticia` (`not_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
