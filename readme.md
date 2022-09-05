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

php artisan migrate --path=/database/migrations/2022_05_13_145159_create_model_changes_history_table.php (pas encore)

php artisan migrate --path=/database/migrations/2021_12_29_114729_create_activites_controle_table.php

php artisan migrate --path=/database/migrations/2022_05_16_164429_add_affiliation_id_to_ligne_de_temps_table.php

php artisan migrate --path=/database/migrations/2022_05_17_111718_add_affiliation_id_and_ligne_temps_id_to_activites_ama_patient_table.php

php artisan migrate --path=/database/migrations/2022_05_19_111548_add_ligne_temps_id_to_rendez_vous_table.php

php artisan migrate --path=/database/migrations/2022_05_23_121028_add_fields_to_activites_controle.php

php artisan migrate --path=/database/migrations/2022_06_01_115835_add_consultation_id_to_rendez_vous_table.php


composer require doctrine/dbal:^2.12.1 

php artisan migrate --path=/database/migrations/2022_06_02_094859_update_date_validations_to_consultation_examen_validation.php

composer require ramsey/uuid "^3.7"

php artisan migrate --path=/database/migrations/2022_06_03_155418_add_uuid_to_payments_table.


php artisan migrate --path=/database/migrations/2022_06_06_142647_add_ligne_de_temps_id_to_version_validations_table.php

php artisan migrate --path=/database/migrations/2022_06_06_151155_create_motiffables_table.php

php artisan migrate --path=/database/migrations/2022_06_09_084538_create_clotures_table.php


## concentement du patient et du souscripteur
php artisan migrate --path=/database/migrations/2022_06_30_172954_add_concentement_to_patient_souscripteurs_table.php
php artisan migrate --path=/database/migrations/2022_07_04_091726_add_consentement_to_souscripteurs.php
php artisan migrate --path=/database/migrations/2022_07_07_115408_add_consentement_to_patients_table.php

php artisan migrate --path=/database/migrations/2022_07_11_150100_add_restriction_to_patients_table.php
php artisan migrate --path=/database/migrations/2022_07_11_151019_add_restriction_to_patient_souscripteurs_table.php

## gestion des medias avec laravel medias
composer require "spatie/laravel-medialibrary:^7.0.0"
php artisan migrate --path=/database/migrations/2022_07_04_154636_create_media_table.php

## autocomplete des models
composer require barryvdh/laravel-ide-helper:*
php artisan ide-helper:generate

## Délai de prise en charge
php artisan migrate --path=/database/migrations/2022_08_23_094803_create_type_operation_table.php
php artisan migrate --path=/database/migrations/2022_08_23_095010_create_delai_operation_table.php

php artisan db:seed --class=TypeOperationTableSeeder

composer dump-autoload
php artisan db:seed --class=ActivitesAmaSeeder
php artisan db:seed --class=RoleTableSeeder
php artisan db:seed --class=PermissionTableSeeder