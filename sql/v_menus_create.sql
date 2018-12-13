CREATE TABLE v_menus(
me_index int( 11 ) NOT NULL default '1',
pa_index int( 11 ) NOT NULL default '1',
me_target varchar( 7 ) NOT NULL default 'page',
me_level char( 1 ) NOT NULL default '1',
di_index varchar( 8 ) NOT NULL default '',
pa_filename varchar( 255 ) NOT NULL default '',
di_fr_short varchar( 50 ) NOT NULL default '',
di_fr_long text NOT NULL ,
di_en_short varchar( 50 ) NOT NULL default '',
di_en_long text NOT NULL ,
 PRIMARY KEY ( me_index ) ,
 UNIQUE KEY me_index( me_index ) 
) 
