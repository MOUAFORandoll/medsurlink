php artisan migrate:rollback
php artisan migrate --path=/database/migrations/2022_02_17_134450_add_other_fields_to_affiliations_table.php

php artisan migrate --path=/database/migrations/2022_03_24_162337_create_contact_assurances_table.php

php artisan migrate --path=/database/migrations/2022_04_29_170444_add_praticien_id_to_resultat_labos_table.php
    - supprimer manuellement consultation_medecine_generale_id_foreign dans la table resultat_labos

php artisan migrate --path=/database/migrations/2022_05_05_150043_add_praticien_to_resultat_imageries_table.php
    - supprimer manuellement consultation_medecine_generale_id_foreign dans la table resultat_imageries

parcours de soins
php artisan migrate --path=/database/migrations/2021_11_22_090512_create_ligne_de_temps_table.php
php artisan migrate --path=/database/migrations/2021_11_22_131854_create_consultation_examen_validation_table.php
php artisan migrate --path=/database/migrations/2021_12_01_091531_create_activites_ama_patient_table.php
php artisan migrate --path=/database/migrations/
php artisan migrate --path=/database/migrations/
php artisan migrate --path=/database/migrations/
