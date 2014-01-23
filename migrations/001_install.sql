/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

 CREATE TABLE IF NOT EXISTS `novius_blocks` (
  `block_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `block_title` varchar(255) NOT NULL,
  `block_created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `block_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `block_template` varchar(100) NOT NULL,
  `block_link` varchar(255) DEFAULT NULL,
  `block_link_title` varchar(255) DEFAULT NULL,
  `block_link_new_page` tinyint(1) DEFAULT NULL,
  `block_class` varchar(255) DEFAULT NULL,
  `block_context` varchar(25) NOT NULL,
  `block_context_common_id` int(11) NOT NULL,
  `block_context_is_main` tinyint(1) NOT NULL DEFAULT '0',
  `block_model` varchar(200) DEFAULT NULL,
  `block_model_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`block_id`),
  KEY `block_created_at` (`block_created_at`),
  KEY `block_updated_at` (`block_updated_at`),
  KEY `block_model_id` (`block_model_id`),
  FULLTEXT KEY `block_template` (`block_template`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `novius_blocks_columns` (
  `blco_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `blco_title` varchar(255) NOT NULL,
  `blco_created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `blco_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `blco_parent_id` int(11) DEFAULT NULL,
  `blco_context` varchar(25) NOT NULL,
  `blco_context_common_id` int(11) NOT NULL,
  `blco_context_is_main` tinyint(1) NOT NULL DEFAULT '0',
  `blco_blocks_ordre` text,
  PRIMARY KEY (`blco_id`),
  KEY `blfo_created_at` (`blco_created_at`),
  KEY `blfo_updated_at` (`blco_updated_at`),
  KEY `blco_parent_id` (`blco_parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `novius_blocks_columns_liaison` (
  `blcl_block_id` int(11) NOT NULL,
  `blcl_blco_id` int(11) NOT NULL,
  PRIMARY KEY (`blcl_block_id`,`blcl_blco_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;