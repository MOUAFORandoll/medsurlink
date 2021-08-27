<?php

use Illuminate\Database\Seeder;

class OtherComplementaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $anatomopathologie = [
            'ANAPATH - HISTOLOGIE',
            'BIOPSIE DU COL SOUS COLPOSCOPIE',
            'CYTOLOGIE GENERALE (ASCITE, LIQUIDE PLEURAL, ETC..)',
            'CYTOPONCTION A L\'AIGUILLE + ANALYSE/SEIN',
            'BIOPSIE POLYPE',
            'BIOPSIE STANDARD',
            'EXAMEN ANATOMOPATHOGIE : HISTOLOGIE',
            'CYTOPONCTION MAMMAIRE BILATERALE PAR OPPOSITION DES LAMES',
        ];
        $fonctioncardiovasculaire = [
            'échocardiographie transthoracique',
            'échocardiographie transoesophagienne',
            'échocardiographie d’effort sur bicyclette ergonomique',
            'épreuve d’effort sur bicyclette ergonomique',
            'épreuve d’effort sur tapis roulant',
            'échocardiographie de stress',
            'épreuve d’effort métabolique sur bicyclette ergonomique',
            'Holter rythmique de 24 h',
            'Holter rythmique de 72 h',
            'MAPA - Mesure Ambulatoire de la Pression Artérielle ',
            'Tilt test',
            'ECG STANDARD',
            'ECG D`EFFORT',

        ];
        $echographies = [
            'BIOPSIE ECHO GUIDEE',
            'ECHOGRAPHIE MAMMAIRE',
            'ECHOGRAPHIE ABDOMINALE',
            'ECHOGRAPHIE ABDOMINO PELVIENNE',
            'ECHOGRAPHIE ABDOMINO PELVIENNE + PROSTATE',
            'ECHOGRAPHIE DES PARTIES MOLLES ET PETITS ORGANES',
            'ECHOGRAPHIE DES VOIES URINAIRES',
            'ECHOGRAPHIE DOPPLER ARTERIEL ET VEINEUX',
            'ECHOGRAPHIE DOPPLER ARTERIEL OU VEINEUX',
            'ECHOGRAPHIE DOPPLER DES VAISSEAUX DU COU',
            'ECHOGRAPHIE DOPPLER OBSTETRICALE (T2 - T3)',
            'ECHOGRAPHIE DOPPLER PENIENNE',
            'ECHOGRAPHIE OBSTETRICALE (T2 - T3 GROSSE SIMPLE)',
            'ECHOGRAPHIE OBSTETRICALE (T2 - T3 GROSSESSE MULTIPLE)',
            'ECHOGRAPHIE OBSTETRICALE (T2 -T3 MORPHOLOGIQUE - RECHERCHE DES MALFORMATIONS',
            'ECHOGRAPHIE PELVIENNE',
            'ECHOGRAPHIE PELVIENNE (SUS PUBIENNE + ENDO VAGINALE)',
            'ECHOGRAPHIE VESICO PROSTATIQUE',
            'ECHOGRAPHIE VESICO PROSTATIQUE COMPLEMENTAIRE',
            'HYSTEROSONOGRAPHIE',
            'ECHOGRAPHIE DOPPLER DES ARTERES RENALES',
            'ECHOGRAPHIE OBSTETRICALE (T1 GROSSESSE SIMPLE OU MULTIPLE)',
            'BIOPSIE PROSTATIQUE ECHO GUIDEE',
            'ELASTOMETRIE DU FOIE',
            'ECHOGRAPHIE OSTEO ARTICULAIRE',
            'CYTOPONCTION ECHO GUIDEE',
            'ECHOGRAPHIE DOPPLER DES VAISSEAUX DU COU ',

        ];
        $endoscopie = [
            'ANUSCOPIE',
            'ANUSCOPIE AVEC BIOPSIE',
            'BREATH TEST_ENDOSCOPIE',
            'COLOSCOPIE AU DELA DE L`ANGLE GAUCHE AVEC BIOPSIE_ENDOSCOPIE',
            'COLOSCOPIE AU DELA DE L\'ANGLE GAUCHE_ENDOSCOPIE',
            'COLOSCOPIE SANS BIOPSIE AVEC ANESTHESIE_ENDOSCOPIE',
            'COLOSCOPIE TOTALE AVEC BIOPSIE_ENDOSCOPIE',
            'COLOSCOPIE TOTALE AVEC BIOPSIE SOUS ANESTHESIE_ENDOSCOPIE',
            'ENDOSCOPIE OESO GASTRO DUODENALE AVEC BIOPSIE',
            'ENDOSCOPIE OESO GASTRO DUODENALE AVEC TEST A L\'UREASE',
            'PH METRIE OESOPHAGIENNE DES 24H',
            'RECTOSIGMOÏDOSCOPIE',
            'RECTOSIGMOÏDOSCOPIE AVEC BIOPSIE',
            'COLOSCOPIE TOTALE SANS BIOPSIE_ENDOSCOPIE',
            'ENDOSCOPIE OESO GASTRO DUODENALE',
            'OESOPHAGOSCOPIE',
            
        ];
        $irm = [
            'IRM SANS INJECTION',
            'IRM AVEC INJECTION',
            'MYELO IRM',
            'PHLEBO IRM',
            'COLO IRM - ENTERO IRM',
            'BILI IRM',
            'IRM HEPATIQUE',
            'IRM PROSTATIQUE',
            'IRM PELVIS FEMININ',
            'IRM TSA',
            'IRM CARDIAQUE',
            'IRM ORL (PAROTIDE, SALIVAIRE, CAVUM, LARYNX, OREILLE, SINUS)',
            'IRM AORTE',
            'IRM FOETALE',
            'IRM ABDOMINALE',
            'IRM MEDULLAIRE',
            'IRM MAMMAIRE',
        ];
        $neurologie = [
            'ELECTROENCEPHALOGRAMME STANDARD',
            'ELECTROENCEPHALOGRAMME LONGUE DUREE',
            'ELECTROMYOGRAPHIE',
            'ELECTROMYOGRAPHIE 4 MEMBRES',
            'PONCTION LOMBAIRE',
            'ELECTROMYOGRAPHIE_LAMAT',
  
        ];
        $ophtamologie = [
            'CHAMPS VISUEL AUTOMATISE 10° CENTRAUX',
            'FOND D\'OEIL',
            'GONIOSCOPIE',
            'PACHYMETRIE',
            'TEST DE SCHIRMER',
            'TONOMETRIE',
            'FOND D\'OEIL SUR V3M',
            'CHAMPS VISUEL AUTOMATISE 30° CENTRAUX',

        ];
        $scanner = [
            'ANGIO SCANNER ',
            'ARTHROSCANNER ',
            'BIOPSIE - PONCTION, DRAINAGE SOUS TDM ',
            'COLO SCANNER',
            'SCANNER THORACIQUE AVEC INJECTION',
            'SCANNER THORACIQUE SANS INJECTION',
            'DENTA SCANNER',
            'MYELOSCANNER',
            'PELVISCANNER - PELVIMETRIE TDM',
            'SCANNER AVEC INJECTION PAR SEGMENT',
            'SCANNER CEREBRAL PEDIATRIQUE',
            'SCANNER CORPS ENTIER ',
            'SCANNER PEDIATRIQUE PAR SEGMENT AVEC OU SANS INJECTION',
            'SCANNER SANS INJECTION PAR SEGMENT',
            'SCANNER SINUS SANS INJECTION ',
            'URO SCANNER AVEC INJECTION',
            'URO SCANNER SANS INJECTION',
            'CORO- SCANNER',
            'INFILTRATION SCANNO GUIDEE_SCANNER',
            'SCANNER AVEC INJECTION PAR SEGMENT (CML)',
            'BIOPSIE OSSEUSE SOUS TDM',

        ];
        $radiolographie = [
            'AGE OSSEUX < 16 ANS',
            'RX BASSIN + HANCHES',
            'RX EPAULE : 3 - 4 INCIDENCES',
            'RX MEMBRES INFERIEUR 1 SEGMENT',
            'RX MEMBRES INFERIEURS 2 SEGMENTS',
            'RX MEMBRES INFERIEURS TELEMETRIE ( PANGONOMETRIE)',
            'RX MEMBRES SUPERIEURS 1 SEGMENT',
            'RX MEMBRES SUPERIEURS 2 SEGMENTS',
            'RX 2 EPAULES : 3 - 4 INCIDENCES ',
            'RX ARTHORGRAPHIE',
            'RX ASP',
            'RX CAVOGRAPHIE',
            'RX CRANE',
            'RX CYSTOGRAPHIE',
            'RX DEFERENTOGRAPHIE',
            'RX FISTULOGRAPHIE',
            'RX GALACTOGRAPHIE',
            'RX HYSTEROSALPINGOGRAPHIE AVEC KIT',
            'RX HYSTEROSALPINGOGRAPHIE SANS KIT',
            'RX LARYNGOGRAPHIE',
            'RX LAVEMENT BARYTE AU HYDRO SOLUBLES',
            'RX LAVEMENT BARYTE DOUBLE CONTRASTE',
            'RX LAVEMENT BARYTE MONO CONTRASTE',
            'RX LAVEMENT BAYTE REDUCTION HYDROSTATIQUE',
            'RX MAMMOGRAPHIE + GALACTOGRAPHIE',
            'RX MAMMOGRAPHIE DEPISTAGE : 2 INCIDENCES',
            'RX MAMMOGRAPHIE DIAGNOSTIC : 3 INCIDENCES',
            'RX MYELOGRAPHIE',
            'RX PANORAMIQUE DENTAIRE',
            'RX PHLEBOGRAPHIE BILATERALE',
            'RX RACHIS CERVICAL',
            'RX RACHIS CERVICO-DORSA',
            'RX RACHIS CERVICO-DORSO-LOMBAIRE COMPLET',
            'RX RACHIS CERVICO-LOMBAIRE',
            'RX RACHIS DORSAL',
            'RX RACHIS DORSO - LOMBAIRE',
            'RX RACHIS LOMBAIRE (DE SEZE + PROFIL)',
            'RX RACHIS LOMBAIRE + HANCHE + BASSIN',
            'RX SIALOGRAPHIE',
            'RX TELECRANE + PROFIL + MESURES',
            'Rx TELERACHIS + MESURES',
            'RX THORAX OSSEUX',
            'RX THORAX PULMONAIRE',
            'RX TRANSIT DU GRELE (T.G)',
            'RX TRANSIT OESO GASTRO DUODENAL',
            'RX TRANSIT OESOPHAGIEN (T.O)',
            'RX UROGRAPHIE INTRA VEINEUSE + MICTION',
            'SACCORADICULOGRAPHIE',
            'RX BASSIN + HANCHES (COXOMETRIE)',
            'INFILTRATION RADIO GUIDEE_RADIOLOGIE',
        ];
        $orl = [
            'AUDIOGRAMME',
            'AUDIOGRAMME + IMPEDANCIMETRIE',
            'BIOPSIE TUMORALE',
            'ENDOSCOPIE NASOPHARYNGEE',
            'EPREUVE CALORIQUE',
            'FIBROSCOPIE DE L\'OREILLE',
            'IMPEDANCIMETRIE',
            'TESTS CUTANES / PRICK TEST',
            'TYMPANOGRAMME',
            'AUDIOGRAMME VS',
            'ENDOSCOPIE PHARYNGOLARYNGEE',

        ];
        $pneumologie = [
            'BIOPSIE PLEURALE',
            'FIBROSCOPIE BRONCHIQUE',
            'SPIROMETRIE',


        ];
        $psychologie = [
            'TEST ECHELLE D\'ESTIME DE SOI',
            'TEST ECHELLE D\'ANXIETE',
            'TEST ECHELLE DE DEPRESSION',
            'TEST ECHELLE DE TRAUMA',
            'TEST ECHELLE DE BECK',
            'SOUTIEN PSYCHOLOGIQUE',

        ];

        foreach ($anatomopathologie as $category){
            \App\Models\OtherComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'ANATOMOPATHOLOGIE',
            ]);
        }
        foreach ($fonctioncardiovasculaire as $category){
            \App\Models\OtherComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'EXP. FONCT. CARDIOVASCULAIRES',
            ]);
        }
        foreach ($echographies as $category){
            \App\Models\OtherComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'ECHOGRAPHIES',
            ]);
        }
        foreach ($endoscopie as $category){
            \App\Models\OtherComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'ENDOSCOPIE',
            ]);
        }
        foreach ($irm as $category){
            \App\Models\OtherComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'IRM',
            ]);
        }
        foreach ($neurologie as $category){
            \App\Models\OtherComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'NEUROLOGIE',
            ]);
        }

        foreach ($ophtamologie as $category){
            \App\Models\OtherComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'OPHTALMOLOGIE',
            ]);
        }

        foreach ($scanner as $category){
            \App\Models\OtherComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'SCANNER',
            ]);
        }

        foreach ($radiolographie as $category){
            \App\Models\OtherComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'RADIOLOGIE',
            ]);
        }
        foreach ($orl as $category){
            \App\Models\OtherComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'ORL',
            ]);
        }
        foreach ($pneumologie as $category){
            \App\Models\OtherComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'PNEUMOLOGIE',
            ]);
        }
        foreach ($psychologie as $category){
            \App\Models\OtherComplementaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'PSYCHOLOGIE',
            ]);
        }
    }
}
