-- ========================================================================
-- Copyright (C) 2001-2002,2004 Rodolphe Quiedeville <rodolphe@quiedeville.org>
-- Copyright (C) 2004           Laurent Destailleur  <eldy@users.sourceforge.net>
--
-- This program is free software; you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation; either version 2 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program. If not, see <http://www.gnu.org/licenses/>.
--
-- $Id: llx_c_type_fees.sql,v 1.4 2011/08/03 01:25:29 eldy Exp $
-- ========================================================================

create table llx_c_type_fees
(
  id        integer      AUTO_INCREMENT PRIMARY KEY,
  code      varchar(12)  UNIQUE NOT NULL,
  libelle   varchar(30),
  active    tinyint DEFAULT 1   NOT NULL,
  module    varchar(32) NULL
)ENGINE=innodb;
