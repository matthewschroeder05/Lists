CREATE DATABASE IF NOT EXISTS `login` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `login`;

CREATE TABLE `lists` (
  `ID` smallint(6) NOT NULL,
  `L1` varchar(25) NOT NULL DEFAULT '',
  `LIST` TEXT NOT NULL DEFAULT '',
  `TITLE` varchar(25) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `lists`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `lists`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
