php artisan migrate:rollback
php artisan migrate --path=/database/migrations/2022_02_17_134450_add_other_fields_to_affiliations_table.php

php artisan migrate --path=/database/migrations/2022_03_24_162337_create_contact_assurances_table.php

php artisan migrate --path=/database/migrations/2022_04_29_170444_add_praticien_id_to_resultat_labos_table.php
    - supprimer manuellement consultation_medecine_generale_id_foreign dans la table resultat_labos

php artisan migrate --path=/database/migrations/2022_05_05_150043_add_praticien_to_resultat_imageries_table.php
    - supprimer manuellement consultation_medecine_generale_id_foreign dans la table resultat_imageries

parcours de soins
php artisan migrate --path=/database/migrations/2021_11_22_114522_add_ligne_de_temps_to_consultation_medecine_generale_table.php
php artisan migrate --path=/database/migrations/2021_12_09_100627_add_consultation_general_id_to_consultation_examen_validation_table.php
php artisan migrate --path=/database/migrations/2021_12_28_074058_add_version_to_consultation_examen_validation_table.php
    - mettre le medecin_control_id, etat_validation_medecin, etat_validation_souscripteur, date_validation_souscripteur,  à null dans la base de donnée
php artisan migrate --path=/database/migrations/2022_05_10_103046_add_etablissement_id_to_consultation_examen_validation_table.php
php artisan migrate --path=/database/migrations/2021_11_22_102450_create_examen_etablissement_prix_table.php
php artisan migrate --path=/database/migrations/2021_12_23_092950_create_activites_medecin_referent_table.php

php artisan migrate --path=/database/migrations/2021_12_01_091212_create_activites_ama_table.php
php artisan migrate --path=/database/migrations/2021_12_01_091531_create_activites_ama_patient_table.php

