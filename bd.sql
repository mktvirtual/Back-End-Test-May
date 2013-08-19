-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2.1
-- http://www.phpmyadmin.net
--
-- Máquina: mysql02.syntex.com.br
-- Data de Criação: 19-Ago-2013 às 09:39
-- Versão do servidor: 5.1.54
-- versão do PHP: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `syntex1`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivos`
--

CREATE TABLE IF NOT EXISTS `arquivos` (
  `arquivo_id` int(11) NOT NULL AUTO_INCREMENT,
  `endereco` varchar(100) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `users_id` bigint(20) NOT NULL,
  `origem` int(1) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`arquivo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `arquivos`
--

INSERT INTO `arquivos` (`arquivo_id`, `endereco`, `descricao`, `users_id`, `origem`, `created`) VALUES
(17, '60602A0B2CBAEEC8F2EF3F0228BA85CF27E2.jpg', 'DOGS!!', 100002018535617, 0, '2013-08-19 09:27:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
  `comentario_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `arquivo_id` int(11) NOT NULL,
  `comentario` varchar(240) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`comentario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `comentarios`
--

INSERT INTO `comentarios` (`comentario_id`, `user_id`, `arquivo_id`, `comentario`, `created`) VALUES
(1, 100002018535617, 17, 'Segunda-feira... =D', '2013-08-19 09:29:02'),
(2, 100002018535617, 17, '=)', '2013-08-19 09:31:08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `email` varchar(80) NOT NULL,
  `username` varchar(80) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`user_id`, `nome`, `email`, `username`) VALUES
(100002018535617, 'Robson Miranda', 'binho_256@hotmail.com', 'binho256');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
