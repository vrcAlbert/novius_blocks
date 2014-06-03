/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

CREATE TABLE IF NOT EXISTS `novius_blocks_displays` (
  `blod_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blod_title` varchar(100) NOT NULL,
  `blod_structure` text,
  `blod_created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `blod_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`blod_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
