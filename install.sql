 
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Structure de la table `blocs`
--

CREATE TABLE IF NOT EXISTS `blocs` (
  `bloc_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bloc_title` varchar(255) NOT NULL,
  `bloc_created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bloc_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bloc_template` varchar(100) NOT NULL,
  `bloc_link` varchar(255) DEFAULT NULL,
  `bloc_link_title` varchar(255) DEFAULT NULL,
  `bloc_link_new_page` tinyint(1) DEFAULT NULL,
  `bloc_class` varchar(255) DEFAULT NULL,
  `bloc_context` varchar(25) NOT NULL,
  `bloc_context_common_id` int(11) NOT NULL,
  `bloc_context_is_main` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bloc_id`),
  KEY `bloc_created_at` (`bloc_created_at`),
  KEY `bloc_updated_at` (`bloc_updated_at`),
  FULLTEXT KEY `bloc_template` (`bloc_template`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `blocs_columns`
--

CREATE TABLE IF NOT EXISTS `blocs_columns` (
  `blco_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `blco_title` varchar(255) NOT NULL,
  `blco_created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `blco_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `blco_parent_id` int(11) DEFAULT NULL,
  `blco_context` varchar(25) NOT NULL,
  `blco_context_common_id` int(11) NOT NULL,
  `blco_context_is_main` tinyint(1) NOT NULL DEFAULT '0',
  `blco_blocs_ordre` text,
  PRIMARY KEY (`blco_id`),
  KEY `blfo_created_at` (`blco_created_at`),
  KEY `blfo_updated_at` (`blco_updated_at`),
  KEY `blco_parent_id` (`blco_parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `blocs_columns_liaison`
--

CREATE TABLE IF NOT EXISTS `blocs_columns_liaison` (
  `blcl_bloc_id` int(11) NOT NULL,
  `blcl_blco_id` int(11) NOT NULL,
  PRIMARY KEY (`blcl_bloc_id`,`blcl_blco_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
