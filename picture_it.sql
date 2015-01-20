-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 20-Jan-2015 às 07:09
-- Versão do servidor: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `picture_it`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `files`
--

CREATE TABLE IF NOT EXISTS `files` (
`id` int(11) NOT NULL,
  `vc_legenda` varchar(150) COLLATE latin1_general_ci DEFAULT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `seguindo`
--

CREATE TABLE IF NOT EXISTS `seguindo` (
`id` int(11) NOT NULL,
  `usuario_seguidor` int(11) NOT NULL,
  `usuario_seguindo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`id` int(11) NOT NULL,
  `fb_id` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `fb_token` text COLLATE latin1_general_ci,
  `vc_nome` varchar(150) COLLATE latin1_general_ci DEFAULT NULL,
  `vc_nome_usuario` varchar(150) COLLATE latin1_general_ci DEFAULT NULL,
  `vc_email` varchar(150) COLLATE latin1_general_ci DEFAULT NULL,
  `vc_senha` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `tx_descricao` text COLLATE latin1_general_ci NOT NULL,
  `dt_cadastro` datetime DEFAULT NULL,
  `dt_ultimo_acesso` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=15 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_files_usuarios1` (`usuario_id`);

--
-- Indexes for table `seguindo`
--
ALTER TABLE `seguindo`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_seguindo_usuarios` (`usuario_seguidor`), ADD KEY `fk_seguindo_usuarios1` (`usuario_seguindo`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `seguindo`
--
ALTER TABLE `seguindo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `files`
--
ALTER TABLE `files`
ADD CONSTRAINT `fk_files_usuarios1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `seguindo`
--
ALTER TABLE `seguindo`
ADD CONSTRAINT `fk_seguindo_usuarios` FOREIGN KEY (`usuario_seguidor`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_seguindo_usuarios1` FOREIGN KEY (`usuario_seguindo`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
