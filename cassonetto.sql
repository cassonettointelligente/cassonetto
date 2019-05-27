-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 27, 2019 alle 13:45
-- Versione del server: 10.1.37-MariaDB
-- Versione PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cassonetto`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `azioni_cassonetto`
--

CREATE TABLE `azioni_cassonetto` (
  `azione` varchar(50) DEFAULT NULL,
  `id_cassonetto` int(11) DEFAULT NULL,
  `data_e_ora` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `cassonetto`
--

CREATE TABLE `cassonetto` (
  `id_cassonetto` int(11) NOT NULL,
  `citta` varchar(255) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `via` varchar(255) DEFAULT NULL,
  `cap` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `cassonetto`
--

INSERT INTO `cassonetto` (`id_cassonetto`, `citta`, `provincia`, `via`, `cap`) VALUES
(1, 'Crispiano', 'Taranto', 'Via Fausto Coppi', '74012');

-- --------------------------------------------------------

--
-- Struttura della tabella `operazione`
--

CREATE TABLE `operazione` (
  `id_operazione` int(11) NOT NULL,
  `giorno_e_ora` datetime DEFAULT CURRENT_TIMESTAMP,
  `rfid_utente` varchar(2000) DEFAULT NULL,
  `id_cassonetto` varchar(2000) DEFAULT NULL,
  `tipo_di_rifiuto` varchar(50) DEFAULT NULL,
  `peso` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `operazione`
--

INSERT INTO `operazione` (`id_operazione`, `giorno_e_ora`, `rfid_utente`, `id_cassonetto`, `tipo_di_rifiuto`, `peso`) VALUES
(5, '2019-04-03 17:18:37', '123456', '1', 'metallo', 1.5),
(6, '2019-04-03 17:18:37', '123456', '1', 'vetro', 2),
(7, '2019-04-03 17:26:14', '123456', '1', 'indifferenziato', 1),
(8, '2019-04-03 17:26:14', '123456', '1', 'umido', 3),
(9, '2019-04-03 17:26:14', '123456', '1', 'plastica', 1),
(10, '2019-04-11 16:08:06', '123456', '1', 'plastica', 2),
(12, '2019-04-26 13:08:06', '123456', '1', 'umido', 2.5),
(13, '2018-10-10 12:17:13', '123456', '1', 'indifferenziato', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `sanzione`
--

CREATE TABLE `sanzione` (
  `id_sanzione` int(11) NOT NULL,
  `data_e_ora` datetime DEFAULT CURRENT_TIMESTAMP,
  `rfid_utente` int(11) DEFAULT NULL,
  `titolo_sanzione` varchar(255) DEFAULT NULL,
  `corpo_sanzione` varchar(1000) DEFAULT NULL,
  `punteggio_rimosso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `rfid` int(11) NOT NULL,
  `totale_punti_accumulati` int(11) NOT NULL,
  `cliente_dipendente` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cognome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `psswd` varchar(255) DEFAULT NULL,
  `sesso` varchar(1) DEFAULT NULL,
  `data_di_nascita` date DEFAULT NULL,
  `codice_fiscale` varchar(255) DEFAULT NULL,
  `citta` varchar(255) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `cap` varchar(255) DEFAULT NULL,
  `via_e_numero_civico` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`rfid`, `totale_punti_accumulati`, `cliente_dipendente`, `nome`, `cognome`, `email`, `psswd`, `sesso`, `data_di_nascita`, `codice_fiscale`, `citta`, `provincia`, `cap`, `via_e_numero_civico`) VALUES
(123456, 0, 1, 'Simone', 'Villanova', 'simone1villanova@hotmail.com', '1a1b66188ca9fe149aa18581884ca28c', 'M', '1999-10-15', 'VLLSMN99R15E986S', 'crispiano', 'taranto', '74012', 'Via Fausto Coppi 4');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `cassonetto`
--
ALTER TABLE `cassonetto`
  ADD PRIMARY KEY (`id_cassonetto`);

--
-- Indici per le tabelle `operazione`
--
ALTER TABLE `operazione`
  ADD PRIMARY KEY (`id_operazione`);

--
-- Indici per le tabelle `sanzione`
--
ALTER TABLE `sanzione`
  ADD PRIMARY KEY (`id_sanzione`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`rfid`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `operazione`
--
ALTER TABLE `operazione`
  MODIFY `id_operazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `sanzione`
--
ALTER TABLE `sanzione`
  MODIFY `id_sanzione` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
