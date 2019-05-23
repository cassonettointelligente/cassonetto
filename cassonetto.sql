-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 12, 2019 alle 21:50
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
-- Struttura della tabella `cassonetto`
--

CREATE TABLE `cassonetto` (
  `rfid_cassonetto` varchar(10) NOT NULL,
  `coordinata_x` float DEFAULT NULL,
  `coordinata_y` float DEFAULT NULL,
  `percentuale_riempimento` int(11) DEFAULT NULL,
  `disponibilita_di_servizio` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `operazione`
--

CREATE TABLE `operazione` (
  `id_operazione` int(11) NOT NULL,
  `giorno_e_ora` datetime DEFAULT CURRENT_TIMESTAMP,
  `rfid_utente` varchar(2000) DEFAULT NULL,
  `rfid_cassonetto` varchar(2000) DEFAULT NULL,
  `tipo_di_rifiuto` varchar(50) DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `gas1` float DEFAULT NULL,
  `gas2` float DEFAULT NULL,
  `gas3` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `operazione`
--

INSERT INTO `operazione` (`id_operazione`, `giorno_e_ora`, `rfid_utente`, `rfid_cassonetto`, `tipo_di_rifiuto`, `peso`, `gas1`, `gas2`, `gas3`) VALUES
(5, '2019-04-03 17:18:37', '123456', '1', 'metallo', 1.5, NULL, NULL, NULL),
(6, '2019-04-03 17:18:37', '123456', '1', 'vetro', 2, NULL, NULL, NULL),
(7, '2019-04-03 17:26:14', '123456', '1', 'indifferenziato', 1, NULL, NULL, NULL),
(8, '2019-04-03 17:26:14', '123456', '1', 'umido', 3, NULL, NULL, NULL),
(9, '2019-04-03 17:26:14', '123456', '1', 'plastica', 1, NULL, NULL, NULL),
(10, '2019-04-11 16:08:06', '123456', '1', 'plastica', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `tabella_di_servizio`
--

CREATE TABLE `tabella_di_servizio` (
  `id_inserimento` int(11) NOT NULL,
  `email_servizio_clienti` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `rfid` int(11) NOT NULL,
  `totale_punti_accumulati` int(11) NOT NULL,
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

INSERT INTO `utente` (`rfid`, `totale_punti_accumulati`, `nome`, `cognome`, `email`, `psswd`, `sesso`, `data_di_nascita`, `codice_fiscale`, `citta`, `provincia`, `cap`, `via_e_numero_civico`) VALUES
(123456, 0, 'Simone', 'Villanova', 'simone1villanova@hotmail.com', '1a1b66188ca9fe149aa18581884ca28c', 'M', '1999-10-15', 'VLLSMN99R15E986S', 'crispiano', 'taranto', '74012', 'Via Fausto Coppi 4');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `cassonetto`
--
ALTER TABLE `cassonetto`
  ADD PRIMARY KEY (`rfid_cassonetto`);

--
-- Indici per le tabelle `operazione`
--
ALTER TABLE `operazione`
  ADD PRIMARY KEY (`id_operazione`);

--
-- Indici per le tabelle `tabella_di_servizio`
--
ALTER TABLE `tabella_di_servizio`
  ADD PRIMARY KEY (`id_inserimento`);

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
  MODIFY `id_operazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `tabella_di_servizio`
--
ALTER TABLE `tabella_di_servizio`
  MODIFY `id_inserimento` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
