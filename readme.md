php artisan migrate:rollback
php artisan migrate --path=/database/migrations/2022_02_17_134450_add_other_fields_to_affiliations_table.php

php artisan migrate --path=/database/migrations/2022_03_24_162337_create_contact_assurances_table.php

php artisan migrate --path=/database/migrations/2022_04_29_170444_add_praticien_id_to_resultat_labos_table.php
    - supprimer manuellement consultation_medecine_generale_id_foreign dans la table resultat_labos
