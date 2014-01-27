psHistory
=========

Individual status information for orders. / Sending mails directly from shop admin to customer.
Free Module for OXID eShop.

Features

	- configure your own status for history entries
	- insert new entry and send directly from shop admin to customer
	- use your deposited signature for emails
	- preselected subject for emails (ordernumber, status)


Installation

	1. copy content from copy_this folder into your shop root
	2. install sql (see below) and update views (shop admin --> service --> tools)
	3. activate module psCmsSnippets in shop admin
	4. configure status and signature in module settings


Install SQL

	ALTER TABLE  `oxremark` CHANGE  `OXTYPE`  `OXTYPE` ENUM( 'o',  'r',  'n',  'c', 'psH' ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT  'r' COMMENT  'Record type: o - order, r - remark, n - nesletter, c - registration';
	ALTER TABLE  `oxremark` ADD  `pshistory_status` VARCHAR( 200 ) NOT NULL, ADD  `pshistory_userid` VARCHAR( 200 ) NOT NULL;

Screenshot

![psHistory](https://raw.github.com/proudcommerce/psHistory/master/screenshot.jpg)

License

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
    

Copyright

	Proud Sourcing GmbH 2014
	www.proudcommerce.com
