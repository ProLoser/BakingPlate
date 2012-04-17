# $Id$
#
# Copyright 2005-2011, Cake Software Foundation, Inc.
#
# Licensed under The MIT License
# Redistributions of files must retain the above copyright notice.
# MIT License (http://www.opensource.org/licenses/mit-license.php)

CREATE TABLE acos (
  id INTEGER(10) UNSIGNED NOT null AUTO_INCREMENT,
  parent_id INTEGER(10) DEFAULT null,
  model VARCHAR(255) DEFAULT '',
  foreign_key INTEGER(10) UNSIGNED DEFAULT null,
  alias VARCHAR(255) DEFAULT '',
  lft INTEGER(10) DEFAULT null,
  rght INTEGER(10) DEFAULT null,
  PRIMARY KEY  (id)
);

CREATE TABLE aros_acos (
  id INTEGER(10) UNSIGNED NOT null AUTO_INCREMENT,
  aro_id INTEGER(10) UNSIGNED NOT null,
  aco_id INTEGER(10) UNSIGNED NOT null,
  _create CHAR(2) NOT null DEFAULT 0,
  _read CHAR(2) NOT null DEFAULT 0,
  _update CHAR(2) NOT null DEFAULT 0,
  _delete CHAR(2) NOT null DEFAULT 0,
  PRIMARY KEY(id)
);

CREATE TABLE aros (
  id INTEGER(10) UNSIGNED NOT null AUTO_INCREMENT,
  parent_id INTEGER(10) DEFAULT null,
  model VARCHAR(255) DEFAULT '',
  foreign_key INTEGER(10) UNSIGNED DEFAULT null,
  alias VARCHAR(255) DEFAULT '',
  lft INTEGER(10) DEFAULT null,
  rght INTEGER(10) DEFAULT null,
  PRIMARY KEY  (id)
);