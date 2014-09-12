/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

CREATE TABLE `novius_blocks_attributes` (
`blat_id` int(111) unsigned NOT NULL AUTO_INCREMENT,
`blat_block_id` int(11) unsigned NOT NULL,
`blat_key` varchar(50) NOT NULL,
`blat_value` varchar(512) NOT NULL,
PRIMARY KEY (`blat_id`),
KEY `blat_key` (`blat_key`),
KEY `blat_block_id` (`blat_block_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;