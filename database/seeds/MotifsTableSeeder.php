<?php
//
//use Illuminate\Database\Seeder;
//
//class MotifsTableSeeder extends Seeder
//{
//    /**
//     * Run the database seeds.
//     *
//     * @return void
//     */
//    public function run()
//    {
//        $motifs = array(
//            array("reference"=>"-30","description"=>"Ex médical/bilan santé détaillé"),
//            array("reference"=>"-31","description"=>"Ex médical/bilan santé partiel"),
//            array("reference"=>"-31","description"=>"Ex médical/bilan santé partiel"),
//            array("reference"=>"-32","description"=>"Test de sensibilité"),
//            array("reference"=>"-33","description"=>"Ex microbiologique/immunologique"),
//            array("reference"=>"-34","description"=>"Autre analyse de sang"),
//            array("reference"=>"-35","description"=>"Autre analyse d'urine"),
//            array("reference"=>"-36","description"=>"Autre analyse de selles"),
//            array("reference"=>"-37","description"=>"Cytologie/histologie"),
//            array("reference"=>"-38","description"=>"Autre analyse de laboratoire"),
//            array("reference"=>"-39","description"=>"Epreuve fonctionnelle"),
//            array("reference"=>"-40","description"=>"Endoscopie"),
//            array("reference"=>"-41","description"=>"Radiologie diagnostique/imagerie"),
//            array("reference"=>"-42","description"=>"Tracé électrique"),
//            array("reference"=>"-43","description"=>"Autre procédure diagnostique"),
//            array("reference"=>"-44","description"=>"Vaccination/médication préventive"),
//            array("reference"=>"-45","description"=>"Recom./éducation santé/avis/régime"),
//            array("reference"=>"-46","description"=>"Discussion entre dispensateurs SSP"),
//            array("reference"=>"-47","description"=>"Discussion dispensateur spécialiste"),
//            array("reference"=>"-48","description"=>"Clarification de la demande du patient"),
//            array("reference"=>"-49","description"=>"Autre procédure préventive"),
//            array("reference"=>"-50","description"=>"Médication/prescription/injection"),
//            array("reference"=>"-51","description"=>"Incision/drainage/aspiration"),
//            array("reference"=>"-52","description"=>"Excision/biopsie/cautér/débridation"),
//            array("reference"=>"-53","description"=>"Perfusion/intubat./dilatat./appareillage"),
//            array("reference"=>"-54","description"=>"Répar/fixation/suture/plâtre/prothèse"),
//            array("reference"=>"-55","description"=>"Traitement local/infiltration"),
//            array("reference"=>"-56","description"=>"Pansement/compression/bandage"),
//            array("reference"=>"-57","description"=>"Thérapie manuelle/médecine physique"),
//            array("reference"=>"-58","description"=>"Conseil thérap/écoute/examens"),
//            array("reference"=>"-59","description"=>"Autres procédures thérapeutiques"),
//            array("reference"=>"-60","description"=>"Résultats analyses/examens"),
//            array("reference"=>"-61","description"=>"Résultats ex/procéd autre dispensateur"),
//            array("reference"=>"-62","description"=>"Contact administratif"),
//            array("reference"=>"-63","description"=>"Rencontre de suivi"),
//            array("reference"=>"-64","description"=>"Epis. nouveau/en cours init. par disp."),
//            array("reference"=>"-65","description"=>"Epis. nouveau/en cours init. par tiers"),
//            array("reference"=>"-66","description"=>"Référence à dispens. SSP non médecin"),
//            array("reference"=>"-67","description"=>"Référence à médecin"),
//            array("reference"=>"-68","description"=>"Autre référence"),
//            array("reference"=>"-69","description"=>"Autres procédures"),
//
//            array("reference"=>"A01","description"=>"Douleur générale/de sites multiples"),
//            array("reference"=>"A02","description"=>"Frissons"),
//            array("reference"=>"A03","description"=>"Fièvre"),
//            array("reference"=>"A04","description"=>"Fatigue/faiblesse générale"),
//            array("reference"=>"A05","description"=>"Sensation d'être malade"),
//            array("reference"=>"A06","description"=>"Evanouissement/syncope"),
//            array("reference"=>"A07","description"=>"Coma"),
//            array("reference"=>"A08","description"=>"Gonflement"),
//            array("reference"=>"A09","description"=>"Problème de transpiration"),
//            array("reference"=>"A10","description"=>"Saignement/hémorragie"),
//            array("reference"=>"A11","description"=>"Douleur thoracique"),
//            array("reference"=>"A13","description"=>"Préoc. par/peur traitement médical"),
//            array("reference"=>"A16","description"=>"Nourrisson irritable"),
//            array("reference"=>"A18","description"=>"Préoc. par son aspect extérieur"),
//            array("reference"=>"A20","description"=>"Demande/discussion sur l'euthanasie"),
//            array("reference"=>"A21","description"=>"Facteur de risque de cancer"),
//            array("reference"=>"A23","description"=>"Facteur de risque"),
//            array("reference"=>"A25","description"=>"Peur de la mort, de mourir"),
//            array("reference"=>"A26","description"=>"Peur du cancer"),
//            array("reference"=>"A27","description"=>"Peur d'une autre maladie"),
//            array("reference"=>"A28","description"=>"Limitation de la fonction/incap."),
//            array("reference"=>"A29","description"=>"Autre Symptôme/Plainte général"),
//
//            array("reference"=>"D01","description"=>"Douleur/crampes abdominales gén."),
//            array("reference"=>"D02","description"=>"Douleur abdominale/épigastrique"),
//            array("reference"=>"D03","description"=>"Brûlure/brûlant/brûlement estomac"),
//            array("reference"=>"D04","description"=>"Douleur rectale/anale"),
//            array("reference"=>"D05","description"=>"Démangeaisons périanales"),
//            array("reference"=>"D06","description"=>"Autre douleur abdominale loc."),
//            array("reference"=>"D07","description"=>"Dyspepsie/indigestion"),
//            array("reference"=>"D08","description"=>"Flatulence/gaz/renvoi"),
//            array("reference"=>"D09","description"=>"Nausée"),
//            array("reference"=>"D10","description"=>"Vomissement"),
//            array("reference"=>"D11","description"=>"Diarrhée"),
//            array("reference"=>"D12","description"=>"Constipation"),
//            array("reference"=>"D13","description"=>"Jaunisse"),
//            array("reference"=>"D14","description"=>"Hématémèse/vomissement de sang"),
//            array("reference"=>"D15","description"=>"Méléna"),
//            array("reference"=>"D16","description"=>"Saignement rectal"),
//            array("reference"=>"D17","description"=>"Incontinence rectale"),
//            array("reference"=>"D18","description"=>"Modification selles/mouvem. intestin"),
//            array("reference"=>"D19","description"=>"Symptôme/Plainte dents/gencives"),
//            array("reference"=>"D20","description"=>"Symptôme/Plainte bouche/langue/lèvres"),
//            array("reference"=>"D21","description"=>"Problème de déglutition"),
//            array("reference"=>"D23","description"=>"Hépatomégalie"),
//            array("reference"=>"D24","description"=>"Masse abdominale"),
//            array("reference"=>"D25","description"=>"Distension abdominale"),
//            array("reference"=>"D26","description"=>"Peur du cancer du syst. digestif"),
//            array("reference"=>"D27","description"=>"Peur d’une autre maladie digestive"),
//            array("reference"=>"D28","description"=>"Limitation de la fonction/incap."),
//            array("reference"=>"D29","description"=>"Autre Symptôme/Plainte du syst. Digestif"),
//
//            array("reference"=>"F01","description"=>"Oeil douloureux"),
//            array("reference"=>"F02","description"=>"Oeil rouge"),
//            array("reference"=>"F03","description"=>"Ecoulement de l’œil"),
//            array("reference"=>"F04","description"=>"Taches visuelles/flottantes"),
//            array("reference"=>"F05","description"=>"Autre perturbation de la vision"),
//            array("reference"=>"F13","description"=>"Sensation oculaire anormale"),
//            array("reference"=>"F14","description"=>"Mouvements oculaires anormaux"),
//            array("reference"=>"F15","description"=>"Apparence anormale de l’œil"),
//            array("reference"=>"F16","description"=>"Symptôme/Plainte de la paupière"),
//            array("reference"=>"F17","description"=>"Symptôme/Plainte lunettes"),
//            array("reference"=>"F18","description"=>"Symptôme/Plainte lentilles de contact"),
//            array("reference"=>"F27","description"=>"Peur d’une maladie de l’œil"),
//            array("reference"=>"F28","description"=>"Limitation de la fonction/incap."),
//            array("reference"=>"F29","description"=>"Autre Symptôme/Plainte de l’œil"),
//
//            array("reference"=>"H01","description"=>"Douleur d'oreille/otalgie"),
//            array("reference"=>"H02","description"=>"Problème d'audition"),
//            array("reference"=>"H03","description"=>"Acouphène/bourdonnement d'oreille"),
//            array("reference"=>"H04","description"=>"Ecoulement de l'oreille"),
//            array("reference"=>"H05","description"=>"Saignement de l'oreille"),
//            array("reference"=>"H13","description"=>"Sensation d'oreille bouchée"),
//            array("reference"=>"H15","description"=>"Préoc. par l'aspect des oreilles"),
//            array("reference"=>"H27","description"=>"Peur d’une maladie de l'oreille"),
//            array("reference"=>"H28","description"=>"Limitation de la fonction/incap"),
//            array("reference"=>"H29","description"=>"Autre Symptôme/Plainte de l'oreille"),
//
//            array("reference"=>"K01","description"=>"Douleur cardiaque"),
//            array("reference"=>"K02","description"=>"Oppression/constriction cardiaque"),
//            array("reference"=>"K03","description"=>"Douleur cardiovasculaire"),
//            array("reference"=>"K04","description"=>"Palpitat./perception battements card."),
//            array("reference"=>"K05","description"=>"Autre battement cardiaque irrégulier"),
//            array("reference"=>"K06","description"=>"Veines proéminentes"),
//            array("reference"=>"K07","description"=>"Oedème, gonflement des chevilles"),
//            array("reference"=>"K22","description"=>"Facteur risque mal. cardio-vasculaire"),
//            array("reference"=>"K24","description"=>"Peur d’une maladie de cœur"),
//            array("reference"=>"K25","description"=>"Peur de l'hypertension"),
//            array("reference"=>"K27","description"=>"Peur autre maladie cardio-vasculaire"),
//            array("reference"=>"K28","description"=>"Limitation de la fonction/incap."),
//            array("reference"=>"K29","description"=>"Autre Symptôme/Plainte cardiovasculaire"),
//
//            array("reference"=>"L01","description"=>"Symptôme/Plainte du cou"),
//            array("reference"=>"L02","description"=>"Symptôme/Plainte du dos"),
//            array("reference"=>"L03","description"=>"Symptôme/Plainte des lombes"),
//            array("reference"=>"L04","description"=>"Symptôme/Plainte du thorax"),
//            array("reference"=>"L05","description"=>"Symptôme/Plainte du flanc et du creux axillaire"),
//            array("reference"=>"L07","description"=>"Symptôme/Plainte de la mâchoire"),
//            array("reference"=>"L08","description"=>"Symptôme/Plainte de l'épaule"),
//            array("reference"=>"L09","description"=>"Symptôme/Plainte du bras"),
//            array("reference"=>"L10","description"=>"Symptôme/Plainte du coude"),
//            array("reference"=>"L11","description"=>"Symptôme/Plainte du poignet"),
//            array("reference"=>"L12","description"=>"Symptôme/Plainte de la main et du doigt"),
//            array("reference"=>"L13","description"=>"Symptôme/Plainte de la hanche"),
//            array("reference"=>"L14","description"=>"Symptôme/Plainte de la jambe et de la cuisse"),
//            array("reference"=>"L15","description"=>"Symptôme/Plainte du genou"),
//            array("reference"=>"L16","description"=>"Symptôme/Plainte de la cheville"),
//            array("reference"=>"L17","description"=>"Symptôme/Plainte du pied et de l'orteil"),
//            array("reference"=>"L18","description"=>"Douleur musculaire"),
//            array("reference"=>"L19","description"=>"Symptôme/Plainte musculaire"),
//            array("reference"=>"L20","description"=>"Symptôme/Plainte d'une articulation"),
//            array("reference"=>"L26","description"=>"Peur cancer syst. ostéo-articulaire"),
//            array("reference"=>"L27","description"=>"Peur autre maladie syst. ostéo-articul."),
//            array("reference"=>"L28","description"=>"Limitation de la fonction/incap."),
//            array("reference"=>"L29","description"=>"Autre Symptôme/Plainte ostéo-articulaire"),
//
//            array("reference"=>"N01","description"=>"Mal de tête"),
//            array("reference"=>"N03","description"=>"Douleur de la face"),
//            array("reference"=>"N04","description"=>"Jambes sans repos"),
//            array("reference"=>"N05","description"=>"Fourmillements doigts, pieds, orteils"),
//            array("reference"=>"N06","description"=>"Autre perturbation de la sensibilité"),
//            array("reference"=>"N07","description"=>"Convulsion/crise comitiale"),
//            array("reference"=>"N08","description"=>"Mouvements involontaires anormaux"),
//            array("reference"=>"N16","description"=>"Perturbation du goût/de l'odorat"),
//            array("reference"=>"N17","description"=>"Vertige/étourdissement"),
//            array("reference"=>"N18","description"=>"Paralysie/faiblesse"),
//            array("reference"=>"N19","description"=>"Trouble de la parole"),
//            array("reference"=>"N26","description"=>"Peur d'un cancer neurologique"),
//            array("reference"=>"N27","description"=>"Peur d’une autre maladie neurologique"),
//            array("reference"=>"N28","description"=>"Limitation de la fonction/incap."),
//            array("reference"=>"N29","description"=>"Autre Symptôme/Plainte neurologique"),
//
//            array("reference"=>"P01","description"=>"Sensation anxiété/nervosité/tension"),
//            array("reference"=>"P02","description"=>"Réaction de stress aiguë"),
//            array("reference"=>"P03","description"=>"Sensation de dépression"),
//            array("reference"=>"P04","description"=>"Sentiment/comport. irritable/colère"),
//            array("reference"=>"P05","description"=>"Sensation vieux, comportement sénile"),
//            array("reference"=>"P06","description"=>"Perturbation du sommeil"),
//            array("reference"=>"P07","description"=>"Diminution du désir sexuel"),
//            array("reference"=>"P08","description"=>"Diminution accomplissement sexuel"),
//            array("reference"=>"P09","description"=>"Préoccupation sur identité sexuelle"),
//            array("reference"=>"P10","description"=>"Bégaiement, bredouillement, tic"),
//            array("reference"=>"P11","description"=>"Trouble de l'alimentation de l'enfant"),
//            array("reference"=>"P12","description"=>"Enurésie"),
//            array("reference"=>"P13","description"=>"Encoprésie"),
//            array("reference"=>"P15","description"=>"Alcoolisme chronique"),
//            array("reference"=>"P16","description"=>"Alcoolisation aiguë"),
//            array("reference"=>"P17","description"=>"Usage abusif du tabac"),
//            array("reference"=>"P18","description"=>"Usage abusif de médicament"),
//            array("reference"=>"P19","description"=>"Usage abusif de drogue"),
//            array("reference"=>"P20","description"=>"Perturbation de la mémoire"),
//            array("reference"=>"P22","description"=>"Symptôme/Plainte du comportement de l'enfant"),
//            array("reference"=>"P23","description"=>"Symptôme/Plainte du comportement de l'adolescent"),
//            array("reference"=>"P24","description"=>"Problème spécifique de l'apprentissage"),
//            array("reference"=>"P25","description"=>"Problèmes de phase de vie adulte"),
//            array("reference"=>"P27","description"=>"Peur d'un trouble mental"),
//            array("reference"=>"P28","description"=>"Limitation de la fonction/incap."),
//            array("reference"=>"P29","description"=>"Autre Symptôme/Plainte psychologique"),
//
//            array("reference"=>"R01","description"=>"Douleur du syst. respiratoire"),
//            array("reference"=>"R02","description"=>"Souffle court, dyspnée"),
//            array("reference"=>"R03","description"=>"Sibilance"),
//            array("reference"=>"R04","description"=>"Autre Problème respiratoire"),
//            array("reference"=>"R05","description"=>"Toux"),
//            array("reference"=>"R06","description"=>"Saignement de nez, épistaxis"),
//            array("reference"=>"R07","description"=>"Congestion nasale, éternuement"),
//            array("reference"=>"R08","description"=>"Autre Symptôme/Plainte du nez"),
//            array("reference"=>"R09","description"=>"Symptôme/Plainte des sinus"),
//            array("reference"=>"R21","description"=>"Symptôme/Plainte de la gorge"),
//            array("reference"=>"R23","description"=>"Symptôme/Plainte de la voix"),
//            array("reference"=>"R24","description"=>"Hémoptysie"),
//            array("reference"=>"R25","description"=>"Expectoration/glaire anormale"),
//            array("reference"=>"R26","description"=>"Peur d'un cancer du syst. respiratoire"),
//            array("reference"=>"R27","description"=>"Peur d’une autre maladie respiratoire"),
//            array("reference"=>"R28","description"=>"Limitation de la fonction/incap."),
//            array("reference"=>"R29","description"=>"Autre Symptôme/Plainte respiratoire"),
//            array("reference"=>"R29","description"=>"Autre Symptôme/Plainte respiratoire"),
//            array("reference"=>"S01","description"=>"Douleur/hypersensibilité de la peau"),
//            array("reference"=>"S02","description"=>"Prurit"),
//            array("reference"=>"S03","description"=>"Verrue"),
//            array("reference"=>"S04","description"=>"Tuméfaction/gonflement loc. peau"),
//            array("reference"=>"S05","description"=>"Tuméfactions/gonflements gén. peau"),
//            array("reference"=>"S06","description"=>"Eruption localisée"),
//            array("reference"=>"S07","description"=>"Eruption généralisée"),
//            array("reference"=>"S08","description"=>"Modification de la couleur de la peau"),
//            array("reference"=>"S09","description"=>"Doigt/orteil infecté"),
//            array("reference"=>"S10","description"=>"Furoncle/anthrax"),
//            array("reference"=>"S11","description"=>"Infection post-traumat. de la peau"),
//            array("reference"=>"S12","description"=>"Piqûre d'insecte"),
//            array("reference"=>"S13","description"=>"Morsure animale/humaine"),
//            array("reference"=>"S14","description"=>"Brûlure cutanée"),
//            array("reference"=>"S15","description"=>"CE dans la peau"),
//            array("reference"=>"S16","description"=>"Ecchymose/contusion"),
//            array("reference"=>"S17","description"=>"Eraflure, égratignure, ampoule"),
//            array("reference"=>"S18","description"=>"Coupure/lacération"),
//            array("reference"=>"S19","description"=>"Autre lésion traumat. de la peau"),
//            array("reference"=>"S20","description"=>"Cor/callosité"),
//            array("reference"=>"S21","description"=>"Symptôme/Plainte au sujet de la texture de la peau"),
//            array("reference"=>"S22","description"=>"Symptôme/Plainte de l'ongle"),
//            array("reference"=>"S23","description"=>"Calvitie/perte de cheveux"),
//            array("reference"=>"S24","description"=>"Autre Symptôme/Plainte cheveux, poils/cuir chevelu"),
//            array("reference"=>"S26","description"=>"Peur du cancer de la peau"),
//            array("reference"=>"S27","description"=>"Peur d’une autre maladie de la peau"),
//            array("reference"=>"S28","description"=>"Limitation de la fonction/incap."),
//            array("reference"=>"S29","description"=>"Autre Symptôme/Plainte de la peau"),
//            array("reference"=>"","description"=>""),
//            array("reference"=>"","description"=>""),
//            array("reference"=>"","description"=>""),
//            array("reference"=>"","description"=>""),
//            array("reference"=>"","description"=>""),
//
//
//T01 Soif excessive
//T02 Appétit excessif
//T03 Perte d'appétit
//T04 Problème d'alimentation nourrisson/enfant
//T05 Problème d'alimentation de l'adulte
//T07 Gain de poids
//T08 Perte de poids
//T10 Retard de croissance
//T11 Déshydratation
//T26 Peur d'un cancer du syst. endocrinien
//T27 Peur autre mal. endoc/métab./nutrit.
//T28 Limitation de la fonction/incap.
//T29 Autre Symptôme/Plainte endoc/métab./nutrit.
//
//U01 Dysurie/miction douloureuse
//U02 Miction fréquente/impérieuse
//U04 Incontinence urinaire
//U05 Autre Problème de miction
//U06 Hématurie
//U07 Autre Symptôme/Plainte au sujet de l'urine
//U08 Rétention d'urine
//
//U13 Autre Symptôme/Plainte de la vessie
//U14 Symptôme/Plainte du rein
//U26 Peur d'un cancer du syst. urinaire
//U27 Peur d’une autre maladie urinaire
//U28 Limitation de la fonction/incap.
//U29 Autre Symptôme/Plainte urinaire
//
//W01 Question de grossesse
//W02 Peur d'être enceinte
//W03 Saignement pendant la grossesse
//W05 Nausée/vomissement de grossesse
//W10 Contraception post-coïtale
//W11 Contraception orale
//W12 Contraception intra-utérine
//W13 Stérilisation chez la femme
//W14 Autre contraception chez la femme
//W15 Stérilité - hypofertilité de la femme
//W17 Saignement du post-partum
//W18 Autre Symptôme/Plainte du post-partum
//W19 Symptôme/Plainte du sein/lactation post-partum
//W21 Préoc. par modific. image et grossesse
//W27 Peur complications de la grossesse
//W28 Limitation de la fonction/incap.
//W29 Autre Symptôme/Plainte de la grossesse
//
//X01 Douleur génitale chez la femme
//X02 Douleur menstruelle
//X03 Douleur intermenstruelle
//X04 Rapport sexuel douloureux femme
//X05 Menstruation absente/rare
//X06 Menstruation excessive
//X07 Menstruation irrégulière/fréquente
//X08 Saignement intermenstruel
//X09 Symptôme/Plainte prémenstruel
//X10 Ajournement des menstruations
//X11 Symptôme/Plainte liés a la ménopause
//X12 Saignement de la post-ménopause
//X13 Saignement post-coïtal femme
//X14 Ecoulement vaginal
//X15 Symptôme/Plainte du vagin
//X16 Symptôme/Plainte de la vulve
//X17 Symptôme/Plainte du petit bassin chez la femme
//X18 Douleur du sein chez la femme
//X19 Tuméfaction/masse du sein femme
//X20 Symptôme/Plainte du mamelon chez la femme
//X21 Autre Symptôme/Plainte du sein chez la femme
//X22 Préoc. par l'apparence des seins
//X23 Peur d'une MST chez la femme
//X24 Peur dysfonction sexuelle femme
//X25 Peur d'un cancer génital femme
//X26 Peur d'un cancer du sein femme
// X27 Peur autre mal. génitale/sein femme
//X28 Limitation de la fonction/incap.
//X29 Autre Symptôme/Plainte génital chez la femme
//
//Y01 Douleur du pénis
//Y02 Douleur des testicules, du scrotum
//Y03 Ecoulement urétral chez l'homme
//Y04 Autre Symptôme/Plainte du pénis
//Y05 Autre Symptôme/Plainte des testicules/du scrotum
//Y06 Symptôme/Plainte de la prostate
//Y07 Impuissance sexuelle
//Y08 Autre Symptôme/Plainte fonction sexuelle homme
//Y10 Stérilité, hypofertilité de l'homme
//Y13 Stérilisation de l'homme
//Y14 Autre PF chez l'homme
//Y16 Symptôme/Plainte du sein chez l'homme
//Y24 Peur dysfonction sexuelle homme
//Y25 Peur d’une MST chez l'homme
//Y26 Peur d'un cancer génital homme
//Y27 Peur autre maladie génitale homme
//Y28 Limitation de la fonction/incap.
//Y29 Autre Symptôme/Plainte génitale chez l'homme
//
//Z01 Pauvreté/Problème économique
//Z02 Problème d'eau/de nourriture
//Z03 Problème d'habitat/de voisinage
//Z04 Problème socioculturel
//Z05 Problème de travail
//Z06 Problème de non emploi
//Z07 Problème d'éducation
//Z08 Problème de protection sociale
//Z09 Problème légal
//Z10 Problème relatif au syst. de soins de santé
//Z11 Problème du fait d'être malade/compliance
//Z12 Problème de relation entre partenaires
//Z13 Problème de comportement du partenaire
//Z14 Problème du à la maladie du partenaire
//Z15 Perte/décès du partenaire
//Z16 Problème de relation avec un enfant
//Z18 Problème du à la maladie d'un enfant
//Z19 Perte/décès d'un enfant
//Z20 Problème relation autre parent/famille
//Z21 Problème comportem. autre parent/famille
//Z22 Problème du à la mal. autre parent/famille
//Z23 Perte/décès autre parent/famille
//Z24 Problème de relation avec un ami
//Z25 Agression/évènement nocif
//Z27 Peur d'un Problème social
//Z28 Limitation de la fonction/incap.
//Z29 Problème social
//
//
//    }
//}
