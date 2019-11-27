<?php

use Illuminate\Database\Seeder;

class MotifsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $motifs = [];
//            -30 Ex médical/bilan santé détaillé
//    -31 Ex médical/bilan santé partiel
//    -32 Test de sensibilité
//    -33 Ex microbiologique/immunologique
//    -34 Autre analyse de sang
//    -35 Autre analyse d'urine
//-36 Autre analyse de selles
//-37 Cytologie/histologie
//-38 Autre analyse de laboratoire
//-39 Epreuve fonctionnelle
//-40 Endoscopie
//-41 Radiologie diagnostique/imagerie
//-42 Tracé électrique
//-43 Autre procédure diagnostique
//-44 Vaccination/médication préventive
//-45 Recom./éducation santé/avis/régime
//-46 Discussion entre dispensateurs SSP
//-47 Discussion dispensateur spécialiste
//-48 Clarification de la demande du patient
//-49 Autre procédure préventive
//-50 Médication/prescription/injection
//-51 Incision/drainage/aspiration
//-52 Excision/biopsie/cautér/débridation
//-53 Perfusion/intubat./dilatat./appareillage
//-54 Répar/fixation/suture/plâtre/prothèse
//-55 Traitement local/infiltration
//-56 Pansement/compression/bandage
//-57 Thérapie manuelle/médecine physique
//-58 Conseil thérap/écoute/examens
//-59 Autres procédures thérapeutiques
//-60 Résultats analyses/examens
//-61 Résultats ex/procéd autre dispensateur
//-62 Contact administratif
//-63 Rencontre de suivi
//-64 Epis. nouveau/en cours init. par disp.
//-65 Epis. nouveau/en cours init. par tiers
//-66 Référence à dispens. SSP non médecin
//-67 Référence à médecin
//-68 Autre référence
//-69 Autres procédures
//
//A01 Douleur générale/de sites multiples
//A02 Frissons
//A03 Fièvre
//A04 Fatigue/faiblesse générale
//A05 Sensation d'être malade
//A06 Evanouissement/syncope
//A07 Coma
//A08 Gonflement
//A09 Problème de transpiration
//A10 Saignement/hémorragie
//A11 Douleur thoracique
//A13 Préoc. par/peur traitement médical
//A16 Nourrisson irritable
//A18 Préoc. par son aspect extérieur
//A20 Demande/discussion sur l'euthanasie
//A21 Facteur de risque de cancer
//A23 Facteur de risque
//A25 Peur de la mort, de mourir
//A26 Peur du cancer
//A27 Peur d'une autre maladie
//A28 Limitation de la fonction/incap.
//    A29 Autre Symptôme/Plainte général
//
//D01 Douleur/crampes abdominales gén.
//    D02 Douleur abdominale/épigastrique
//D03 Brûlure/brûlant/brûlement estomac
//D04 Douleur rectale/anale
//D05 Démangeaisons périanales
//D06 Autre douleur abdominale loc.
//    D07 Dyspepsie/indigestion
//D08 Flatulence/gaz/renvoi
//D09 Nausée
//D10 Vomissement
//D11 Diarrhée
//D12 Constipation
//D13 Jaunisse
//D14 Hématémèse/vomissement de sang
//D15 Méléna
//D16 Saignement rectal
//D17 Incontinence rectale
//D18 Modification selles/mouvem. intestin
//D19 Symptôme/Plainte dents/gencives
//D20 Symptôme/Plainte bouche/langue/lèvres
//D21 Problème de déglutition
//D23 Hépatomégalie
//D24 Masse abdominale
//D25 Distension abdominale
//D26 Peur du cancer du syst. digestif
//D27 Peur d’une autre maladie digestive
//D28 Limitation de la fonction/incap.
//D29 Autre Symptôme/Plainte du syst. Digestif
//
//F01 Oeil douloureux
//F02 Oeil rouge
//F03 Ecoulement de l’œil
//F04 Taches visuelles/flottantes
//F05 Autre perturbation de la vision
//F13 Sensation oculaire anormale
//F14 Mouvements oculaires anormaux
//F15 Apparence anormale de l’œil
//F16 Symptôme/Plainte de la paupière
//F17 Symptôme/Plainte lunettes
//F18 Symptôme/Plainte lentilles de contact
//F27 Peur d’une maladie de l’œil
//F28 Limitation de la fonction/incap.
//F29 Autre Symptôme/Plainte de l’œil
//
//H01 Douleur d'oreille/otalgie
//H02 Problème d'audition
//H03 Acouphène/bourdonnement d'oreille
//H04 Ecoulement de l'oreille
//H05 Saignement de l'oreille
//H13 Sensation d'oreille bouchée
//H15 Préoc. par l'aspect des oreilles
//H27 Peur d’une maladie de l'oreille
//H28 Limitation de la fonction/incap
//H29 Autre Symptôme/Plainte de l'oreille
//
//K01 Douleur cardiaque
//K02 Oppression/constriction cardiaque
//K03 Douleur cardiovasculaire
//K04 Palpitat./perception battements card.
//K05 Autre battement cardiaque irrégulier
//K06 Veines proéminentes
//K07 Oedème, gonflement des chevilles
//K22 Facteur risque mal. cardio-vasculaire
//K24 Peur d’une maladie de cœur
//K25 Peur de l'hypertension
//K27 Peur autre maladie cardio-vasculaire
//K28 Limitation de la fonction/incap.
//K29 Autre Symptôme/Plainte cardiovasculaire
//
//L01 Symptôme/Plainte du cou
//L02 Symptôme/Plainte du dos
//L03 Symptôme/Plainte des lombes
//L04 Symptôme/Plainte du thorax L05
//Symptôme/Plainte du flanc et du creux axillaire
//L07 Symptôme/Plainte de la mâchoire
//L08 Symptôme/Plainte de l'épaule
//L09 Symptôme/Plainte du bras
//L10 Symptôme/Plainte du coude
//L11 Symptôme/Plainte du poignet
//L12 Symptôme/Plainte de la main et du doigt
//L13 Symptôme/Plainte de la hanche
//L14 Symptôme/Plainte de la jambe et de la cuisse
//L15 Symptôme/Plainte du genou
//L16 Symptôme/Plainte de la cheville
//L17 Symptôme/Plainte du pied et de l'orteil
//L18 Douleur musculaire
//L19 Symptôme/Plainte musculaire
//L20 Symptôme/Plainte d'une articulation
//L26 Peur cancer syst. ostéo-articulaire
//L27 Peur autre maladie syst. ostéo-articul.
//L28 Limitation de la fonction/incap.
//L29 Autre Symptôme/Plainte ostéo-articulaire
//
//N01 Mal de tête
//N03 Douleur de la face
//N04 Jambes sans repos
//N05 Fourmillements doigts, pieds, orteils
//N06 Autre perturbation de la sensibilité
//N07 Convulsion/crise comitiale
//N08 Mouvements involontaires anormaux
//N16 Perturbation du goût/de l'odorat
//N17 Vertige/étourdissement
//N18 Paralysie/faiblesse
//N19 Trouble de la parole
//N26 Peur d'un cancer neurologique
//N27 Peur d’une autre maladie neurologique
//N28 Limitation de la fonction/incap.
//N29 Autre Symptôme/Plainte neurologique
//
//P01 Sensation anxiété/nervosité/tension
//P02 Réaction de stress aiguë
//P03 Sensation de dépression
//P04 Sentiment/comport. irritable/colère
//P05 Sensation vieux, comportement sénile
//P06 Perturbation du sommeil
//P07 Diminution du désir sexuel
//P08 Diminution accomplissement sexuel
//P09 Préoccupation sur identité sexuelle
//P10 Bégaiement, bredouillement, tic
//P11 Trouble de l'alimentation de l'enfant
//P12 Enurésie
//P13 Encoprésie
//P15 Alcoolisme chronique
//P16 Alcoolisation aiguë
//P17 Usage abusif du tabac
//P18 Usage abusif de médicament
//P19 Usage abusif de drogue
//P20 Perturbation de la mémoire
//P22 Symptôme/Plainte du comportement de l'enfant
//P23 Symptôme/Plainte du comportement de l'adolescent
//P24 Problème spécifique de l'apprentissage
//P25 Problèmes de phase de vie adulte
//P27 Peur d'un trouble mental
//P28 Limitation de la fonction/incap.
//P29 Autre Symptôme/Plainte psychologique
//
//R01 Douleur du syst. respiratoire
//R02 Souffle court, dyspnée
//R03 Sibilance
//R04 Autre Problème respiratoire
//R05 Toux
//R06 Saignement de nez, épistaxis
//R07 Congestion nasale, éternuement
//R08 Autre Symptôme/Plainte du nez
//R09 Symptôme/Plainte des sinus
//R21 Symptôme/Plainte de la gorge
//R23 Symptôme/Plainte de la voix
//R24 Hémoptysie
//R25 Expectoration/glaire anormale
//R26 Peur d'un cancer du syst. respiratoire
//R27 Peur d’une autre maladie respiratoire
//R28 Limitation de la fonction/incap.
//R29 Autre Symptôme/Plainte respiratoire
//
//S01 Douleur/hypersensibilité de la peau
//S02 Prurit
//S03 Verrue
//S04 Tuméfaction/gonflement loc. peau
//S05 Tuméfactions/gonflements gén. peau
//S06 Eruption localisée
//S07 Eruption généralisée
//S08 Modification de la couleur de la peau
//S09 Doigt/orteil infecté
//S10 Furoncle/anthrax
//S11 Infection post-traumat. de la peau
//S12 Piqûre d'insecte
//S13 Morsure animale/humaine
//S14 Brûlure cutanée
//S15 CE dans la peau
//S16 Ecchymose/contusion
//S17 Eraflure, égratignure, ampoule
//S18 Coupure/lacération
//S19 Autre lésion traumat. de la peau
//S20 Cor/callosité
//S21 Symptôme/Plainte au sujet de la texture de la peau
//S22 Symptôme/Plainte de l'ongle
//S23 Calvitie/perte de cheveux
//S24 Autre Symptôme/Plainte cheveux, poils/cuir chevelu
//S26 Peur du cancer de la peau
//S27 Peur d’une autre maladie de la peau
//S28 Limitation de la fonction/incap.
//S29 Autre Symptôme/Plainte de la peau
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


    }
}
