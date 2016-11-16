-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 15, 2016 at 11:14 PM
-- Server version: 5.5.52-0+deb8u1
-- PHP Version: 5.6.27-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbx`
--
CREATE DATABASE IF NOT EXISTS `dbx` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dbx`;

-- --------------------------------------------------------

--
-- Table structure for table `agendamentos`
--

CREATE TABLE IF NOT EXISTS `agendamentos` (
`id` int(11) unsigned NOT NULL,
  `nome` varchar(64) NOT NULL,
  `comentario` varchar(255) DEFAULT NULL,
  `inicio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `intervalo` int(11) NOT NULL,
  `ultimaExecucao` timestamp NULL DEFAULT NULL,
  `paralelismo` tinyint(1) NOT NULL DEFAULT '1',
  `ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agendamentos_componentes`
--

CREATE TABLE IF NOT EXISTS `agendamentos_componentes` (
  `idAgendamento` int(10) unsigned NOT NULL,
  `idComponente` varchar(255) NOT NULL,
  `ordem` tinyint(3) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `artigos`
--

CREATE TABLE IF NOT EXISTS `artigos` (
`id` int(11) unsigned NOT NULL,
  `componente` int(10) unsigned NOT NULL,
  `proteina` int(10) unsigned NOT NULL,
  `idExterno` varchar(64) NOT NULL,
  `titulo` varchar(511) CHARACTER SET utf16 NOT NULL,
  `abstract` text CHARACTER SET utf8 COLLATE utf8_bin,
  `data` date NOT NULL,
  `link` varchar(512) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `autores`
--

CREATE TABLE IF NOT EXISTS `autores` (
`id` int(11) NOT NULL,
  `nome` varchar(255) CHARACTER SET utf16 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `autores_artigos`
--

CREATE TABLE IF NOT EXISTS `autores_artigos` (
  `idArtigo` int(11) NOT NULL,
  `idAutor` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `componentescoletarefinamento`
--

CREATE TABLE IF NOT EXISTS `componentescoletarefinamento` (
`ID` int(10) unsigned NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `Tipo` char(3) NOT NULL,
  `proteina` int(11) DEFAULT NULL,
  `NomeTabela` varchar(255) DEFAULT NULL,
  `componenteVisual` int(11) DEFAULT NULL,
  `Configuracao` text,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` timestamp NULL DEFAULT NULL,
  `Ativo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `componentesvisuais`
--

CREATE TABLE IF NOT EXISTS `componentesvisuais` (
`ID` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
`id` int(10) unsigned NOT NULL,
  `dataHora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mensagem` text NOT NULL,
  `origem` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proteinas`
--

CREATE TABLE IF NOT EXISTS `proteinas` (
`id` int(10) unsigned NOT NULL,
  `nome` varchar(511) NOT NULL,
  `dados` varchar(1023) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`id` int(10) unsigned NOT NULL,
  `username` varchar(63) NOT NULL,
  `password` char(32) NOT NULL,
  `authKey` varchar(256) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `authKey`) VALUES
(1, 'admin', '3f74231e8d8af5317479f82b97f3b7d8', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agendamentos`
--
ALTER TABLE `agendamentos`
 ADD PRIMARY KEY (`id`), ADD KEY `agendamento_ativo` (`ativo`);

--
-- Indexes for table `agendamentos_componentes`
--
ALTER TABLE `agendamentos_componentes`
 ADD PRIMARY KEY (`idAgendamento`,`idComponente`,`ordem`);

--
-- Indexes for table `artigos`
--
ALTER TABLE `artigos`
 ADD PRIMARY KEY (`id`), ADD KEY `proteina` (`proteina`) USING BTREE;

--
-- Indexes for table `autores`
--
ALTER TABLE `autores`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `autores_artigos`
--
ALTER TABLE `autores_artigos`
 ADD PRIMARY KEY (`idArtigo`,`idAutor`);

--
-- Indexes for table `componentescoletarefinamento`
--
ALTER TABLE `componentescoletarefinamento`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `componentesvisuais`
--
ALTER TABLE `componentesvisuais`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `nome` (`nome`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proteinas`
--
ALTER TABLE `proteinas`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id`) USING BTREE, ADD UNIQUE KEY `usuarios_nome` (`username`), ADD UNIQUE KEY `usuarios_authkey` (`authKey`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agendamentos`
--
ALTER TABLE `agendamentos`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `artigos`
--
ALTER TABLE `artigos`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `autores`
--
ALTER TABLE `autores`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `componentescoletarefinamento`
--
ALTER TABLE `componentescoletarefinamento`
MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `componentesvisuais`
--
ALTER TABLE `componentesvisuais`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `proteinas`
--
ALTER TABLE `proteinas`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
