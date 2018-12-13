SELECT me_index AS Menu, pa_index AS Page, me_level AS Niveau, di_index AS Dictionnaire, me_target AS Cible, pa_filename AS Fichier, di_fr_short AS 'Francais court', di_fr_long AS 'Francais long', di_en_short AS 'Anglais court', di_en_long AS 'Anglais long'
FROM v_menus
ORDER BY me_index
