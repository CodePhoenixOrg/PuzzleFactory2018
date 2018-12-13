INSERT INTO v_menus( me_index, pa_index, me_level, di_index, me_target, pa_filename, di_fr_short, di_fr_long, di_en_short, di_en_long ) 
SELECT m.me_index, m.pa_index, m.me_level, m.di_index, m.me_target, p.pa_filename, d.di_fr_short, d.di_fr_long, d.di_en_short, d.di_en_long
FROM menus m, pages p, dictionary d
WHERE m.di_index = d.di_index AND p.di_index = d.di_index
ORDER BY m.me_index
