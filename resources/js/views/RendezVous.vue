<template>
    <v-container style="font-size: 1.2em;">
        <v-stepper v-model="e1">
            <v-stepper-header>
                <v-stepper-step :complete="e1 > 1" step="1">
                    Informations du Rendez-Vous
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="e1 > 2" step="2">
                    Informations Personnelles
                </v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
                <v-stepper-content step="1">
                    <v-card
                            class="mb-5"
                            transparent
                    >
                        <v-form ref="step1">
                            <v-container
                                    fluid
                                    grid-list-x1
                            >
                                <v-layout
                                        wrap
                                        align-center
                                >
                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <p class="label">
                                                    {{ $t('message.qCountries') }}
                                                </p>
                                            </v-flex>

                                            <v-flex xs12>
                                                <v-autocomplete
                                                        v-model="pays"
                                                        color="primary"
                                                        :rules="[nameRules.required]"
                                                        :items="mCountries"
                                                        item-text="name"
                                                        item-value="name"
                                                ></v-autocomplete>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <p class="label">
                                                    {{ $t('message.qTypes') }}
                                                </p>
                                            </v-flex>

                                            <v-flex xs12>
                                                <v-autocomplete
                                                        v-model="type"
                                                        color="primary"
                                                        :rules="[nameRules.required]"
                                                        :items="types"
                                                        item-text="value"
                                                        item-value="key"
                                                ></v-autocomplete>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex

                                    >
                                        <v-layout row wrap >
                                            <v-flex xs12 >
                                                <v-container class="px-0">
                                                    <p >
                                                       Durée en moyen de l’entretien : {{ intervale.telephonique }} min<br>
                                                       Pour les présentations en vidéoconférence : {{ intervale.video}} min<br>
                                                       Votre fuseau horaire est : (en fonction du lieu de résidence)<br>
                                                    </p>

                                                    <p class="label">
                                                        Choisissez la date et l’heure qui vous conviendrait :<br>
                                                    </p>
                                                </v-container>
                                            </v-flex>


                                            <v-flex xs12>
                                                <v-layout row wrap justify-space-between>
                                                    <v-flex xs12 sm6>
                                                        <v-date-picker v-model="picker2" color="green lighten-1" header-color="primary"></v-date-picker>
                                                    </v-flex>

                                                    <v-flex xs12 sm6>
                                                        <v-time-picker v-model="picker"></v-time-picker>
                                                    </v-flex>
                                                </v-layout>
                                            </v-flex>


<!--                                            <v-flex xs12>-->
<!--                                                <v-sheet height="400">-->
<!--                                                    <v-calendar-->
<!--                                                            ref="calendar"-->
<!--                                                            v-model="now"-->
<!--                                                            :now="today"-->
<!--                                                            :value="today"-->
<!--                                                            color="primary"-->
<!--                                                            interval-count="96"-->
<!--                                                            interval-minutes="15"-->
<!--                                                            type="week"-->
<!--                                                            @click:date="dateClicked"-->
<!--                                                            @click:day="dayClicked"-->
<!--                                                            @click:time="timeClicked"-->
<!--                                                    >-->
<!--                                                        &lt;!&ndash; the events at the top (all-day) &ndash;&gt;-->
<!--                                                        <template slot="dayHeader" slot-scope="{ date }">-->
<!--                                                            <template v-for="(event, key) in eventsMap[date]">-->
<!--                                                                &lt;!&ndash; all day events don't have time &ndash;&gt;-->
<!--                                                                <div-->
<!--                                                                        v-if="!event.time"-->
<!--                                                                        :key="key"-->
<!--                                                                        class="my-event"-->
<!--                                                                        @click="open(event)"-->
<!--                                                                        v-html="event.title"-->
<!--                                                                ></div>-->
<!--                                                            </template>-->
<!--                                                        </template>-->

<!--                                                        &lt;!&ndash; the events at the bottom (timed) &ndash;&gt;-->
<!--                                                        <template slot="dayBody" slot-scope="{ date, timeToY, minutesToPixels }">-->
<!--                                                            <template v-for="(event, key) in eventsMap[date]">-->
<!--                                                                &lt;!&ndash; timed events &ndash;&gt;-->
<!--                                                                <div-->
<!--                                                                        v-if="event.time"-->
<!--                                                                        :key="key"-->
<!--                                                                        :style="{ top: timeToY(event.time) + 'px', height: minutesToPixels(event.duration) + 'px' }"-->
<!--                                                                        class="my-event with-time"-->
<!--                                                                        @click="open(event)"-->
<!--                                                                        v-html="event.title"-->
<!--                                                                ></div>-->
<!--                                                            </template>-->
<!--                                                        </template>-->

<!--                                                        &lt;!&ndash; the events when an interval is clicked &ndash;&gt;-->
<!--                                                        <template slot="interval" slot-scope="{ date, timeToY, minutesToPixels }">-->
<!--                                                            <template v-for="(event, key) in eventsMap[date]">-->
<!--                                                                &lt;!&ndash; timed events &ndash;&gt;-->
<!--                                                                <div-->
<!--                                                                        v-if="event.time"-->
<!--                                                                        :key="key"-->
<!--                                                                        :style="{ top: timeToY(event.time) + 'px', height: minutesToPixels(event.duration) + 'px' }"-->
<!--                                                                        class="my-event with-time"-->
<!--                                                                        @click="open(event)"-->
<!--                                                                        v-html="event.title"-->
<!--                                                                ></div>-->
<!--                                                            </template>-->

<!--                                                            &lt;!&ndash;v-layout-->
<!--                                                                    fill-height-->
<!--                                                                    align-center-->
<!--                                                                    justify-center-->
<!--                                                            >-->
<!--                                                                <template v-if="(present || future) && !checked">-->
<!--                                                                    <v-sheet-->
<!--                                                                            :color="color"-->
<!--                                                                            width="80%"-->
<!--                                                                            height="80%"-->
<!--                                                                            tile-->
<!--                                                                    ></v-sheet>-->
<!--                                                                </template>-->

<!--                                                                <template v-else-if="checked">-->
<!--                                                                    <v-sheet-->
<!--                                                                            color="inherit"-->
<!--                                                                    ></v-sheet>-->
<!--                                                                </template>-->
<!--                                                            </v-layout&ndash;&gt;-->
<!--                                                        </template>-->
<!--                                                    </v-calendar>-->
<!--                                                </v-sheet>-->
<!--                                            </v-flex>-->

<!--                                            <v-flex-->
<!--                                                    sm4-->
<!--                                                    xs12-->
<!--                                                    class="text-sm-left text-xs-center"-->
<!--                                            >-->
<!--                                                <v-btn @click="$refs.calendar.prev()">-->
<!--                                                    <v-icon-->
<!--                                                            dark-->
<!--                                                            left-->
<!--                                                    >-->
<!--                                                        keyboard_arrow_left-->
<!--                                                    </v-icon>-->
<!--                                                    Prev-->
<!--                                                </v-btn>-->
<!--                                            </v-flex>-->

<!--                                            <v-flex-->
<!--                                                    sm4-->
<!--                                                    xs12-->
<!--                                                    class="text-xs-center"-->
<!--                                            >-->
<!--                                                <v-text-field-->
<!--                                                        value="week"-->
<!--                                                        label="Type"-->
<!--                                                        disabled-->
<!--                                                ></v-text-field>-->
<!--                                            </v-flex>-->

<!--                                            <v-flex-->
<!--                                                    sm4-->
<!--                                                    xs12-->
<!--                                                    class="text-sm-right text-xs-center"-->
<!--                                            >-->
<!--                                                <v-btn @click="$refs.calendar.next()">-->
<!--                                                    Next-->
<!--                                                    <v-icon-->
<!--                                                            right-->
<!--                                                            dark-->
<!--                                                    >-->
<!--                                                        keyboard_arrow_right-->
<!--                                                    </v-icon>-->
<!--                                                </v-btn>-->
<!--                                            </v-flex>-->
                                        </v-layout>
                                    </v-flex>

                                    <v-flex

                                        xs12

                                        d-flex

                                    >
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <p class="label">
                                                    {{ $t('message.qTime') }}
                                                </p>
                                            </v-flex>

                                            <v-flex xs12>
                                                <v-text-field
                                                        v-model="date_debut"
                                                        color="primary"
                                                        disabled
                                                ></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <p class="label">
                                                    {{ $t('message.qSubject') }}
                                                </p>
                                            </v-flex>

                                            <v-flex xs12>
                                                <v-autocomplete
                                                        v-model="objet"
                                                        color="primary"
                                                        :rules="[nameRules.required]"
                                                        :items="objets"
                                                ></v-autocomplete>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-form>
                    </v-card>

                    <div class="text-xs-right">
                        <v-btn
                                color="primary"
                                @click="goToStep2"
                        >
                            {{ $t('message.next') }}
                        </v-btn>
                    </div>
                </v-stepper-content>

                <v-stepper-content step="2">
                    <v-card
                            class="mb-5"
                            transparent
                    >
                        <v-form ref="step2">
                            <v-container
                                    fluid
                                    grid-list-x1
                            >
                                <v-layout
                                        wrap
                                        align-center
                                >
                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <p class="label">
                                                    {{ $t('message.qTime') }}
                                                </p>
                                            </v-flex>

                                            <v-flex xs12>
                                                <v-text-field
                                                        v-model="selectedDate"
                                                        color="primary"
                                                        disabled
                                                ></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <p class="label">
                                                    {{ $t('message.qName') }}
                                                </p>
                                            </v-flex>

                                            <v-flex xs12>
                                                <v-text-field
                                                        v-model="nom"
                                                        :rules="[nameRules.required]"
                                                        color="primary"
                                                ></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <p class="label">
                                                    {{ $t('message.email') }}
                                                </p>
                                            </v-flex>

                                            <v-flex xs12>
                                                <v-text-field
                                                        v-model="email"
                                                        :rules="[emailRules.required, emailRules.valid]"
                                                        color="primary"
                                                        :hint="$t('message.emailHint')"
                                                ></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <p class="label">
                                                    {{ $t('message.whatsappNumber') }}
                                                </p>
                                            </v-flex>

                                            <v-flex xs12>
                                                <v-text-field
                                                        v-model="whatsapp"
                                                        color="primary"
                                                ></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <p class="label">
                                                    {{ $t('message.phoneNumber') }}
                                                </p>
                                            </v-flex>

                                            <v-flex xs12>
                                                <v-text-field
                                                        v-model="numero"
                                                        color="primary"
                                                ></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <p class="label">
                                                    {{ $t('message.skype') }}
                                                </p>
                                            </v-flex>

                                            <v-flex xs12>
                                                <v-text-field
                                                        v-model="skype"
                                                        color="primary"
                                                ></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-form>
                    </v-card>

                    <v-layout row justify-space-around>
                        <v-flex xs4>
                            <v-btn
                                    @click="e1 = 1"
                            >
                                {{ $t('message.previous') }}
                            </v-btn>
                        </v-flex>

                        <v-flex xs4>
                            <v-btn
                                    color="primary"
                                    @click="submit"
                            >
                                {{ $t('message.submit') }}
                            </v-btn>
                        </v-flex>
                    </v-layout>
                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
    </v-container>
</template>

<script>
    import { mapGetters } from 'vuex';
    import lodash from 'lodash';
    import Vue from 'vue';
    import moment from 'moment';

    export default {
        name: "RendezVous",

        computed: {
            ...mapGetters(["countries", "rdvs", "intervale"]),

            mCountries: function() {
                let cArray = [];

                _.forOwn(this.countries, function(value, key) {
                    cArray.push(value);
                });

                return cArray;
            },

            mStyle: function() {
                if (this.type == 'skype')
                    return 'video';
                else
                    return 'regular';
            },

            events: function() {
                let self = this;
                let eArray = this.rdvs;

                _.forOwn(eArray, function(value, key) {
                    console.log("Event " + key, value);

                    let durationObject = moment.utc(moment(value.date_fin, 'YYYY-MM-DD HH:mm:ss')
                        .diff(moment(value.date_debut, 'YYYY-MM-DD HH:mm:ss')));

                    let e = {
                        //title: self.$i18n.t('message.' + value.style),
                        title: value.style,
                        date: moment(value.date_debut).format('YYYY-MM-DD'),
                        time: moment(value.date_debut).format('HH:mm'),
                        duration: durationObject._i / (1000 * 60)
                    };

                    console.log("Sorted event " + key, e);

                    eArray.push(e);
                });

                return eArray
            },

            // Convert the list of events into a map of lists keyed by date
            eventsMap () {
                const map = {};
                this.events.forEach(e => (map[e.date] = map[e.date] || []).push(e));
                return map;
            },

            selectedDate: function() {
                return moment(this.date_debut).format('ddd, MMM Do YYYY, HH:mm') + ' - ' + moment(this.date_fin).format('ddd, MMM Do YYYY, HH:mm');
            },

            date_debut: function() {
                return moment(this.picker2 + ' ' + this.picker).format('YYYY-MM-DD HH:mm');
            },

            date_fin: function() {

                let duration = this.intervale.telephonique;                // Check type

                if (this.type == 'skype') {

                    duration = this.intervale.video;

                }                // Determine end date

                return moment(this.date_debut, 'YYYY-MM-DD HH:mm')

                    .add(duration, 'minutes')

                    .format('YYYY-MM-DD HH:mm');

            }
        },

        data() {
            return {
                e1: 0,
                color: '#00ADA7',
                checked: false,
                pays: '',
                type: 'appel direct',
                types: [
                    { key: 'appel direct', value: 'Appel direct' },
                    { key: 'whatsapp', value: 'WhatsApp' },
                    { key: 'skype', value: 'Skype' },
                ],
                date: '',
                heure_debut: '',
                heure_fin: '',
                objet: 'Information sur nos services',
                objets: [
                    'Information sur nos services',
                    'Au sujet des rapports médicaux et factures reçus',
                    'Au sujet d’une invitation à un évènement',
                    'Autre sujet',
                ],
                nom: '',
                email: '',
                whatsapp: '',
                numero: '',
                skype: '',
                nameRules: {
                    required: value => !!value || this.$i18n.t('message.requiredField'),
                },
                emailRules: {
                    required: value => !!value || this.$i18n.t('message.requiredField'),
                    valid: v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
                        this.$i18n.t('message.emailNotValid')
                },
                phoneRules: {
                    required: value => !!value || this.$i18n.t('message.requiredField'),
                },
                now: moment(new Date()).format('YYYY-MM-DD HH:mm'),
                today: moment(new Date()).format('YYYY-MM-DD'),
                picker2: new Date().toISOString().substr(0, 10),
                picker: null,
            }
        },

        methods: {
            dateClicked(event) {
                //console.log("Date event:", event);

                Vue.notify({
                    type: 'error',
                    text: 'Please select specific time'
                });
            },

            dayClicked(event) {
                //console.log("Day event:", event);

                Vue.notify({
                    type: 'error',
                    text: 'Please select specific time'
                });
            },

            timeClicked(event) {
                //console.log("Time event:", event);

                this.date = event.date;
                this.heure_debut = event.time;

                console.log("Date debut:", this.date_debut);
                console.log("Date fin:", this.date_fin);
            },

            toggleState() {
                return !checked;
            },

            getCountries() {
                let args = {};
                let errorMessages = {
                    generic: this.$i18n.t('message.genericError'),
                    error: this.$i18n.t('message.genericError') // TODO: Prendre message approprié
                };

                this.$store.dispatch('getCountries', { args, errorMessages });
            },

            getAppointments() {
                let args = {
                    limit: -1
                };
                let errorMessages = {
                    generic: this.$i18n.t('message.genericError'),
                    error: this.$i18n.t('message.genericError') // TODO: Prendre message approprié
                };

                this.$store.dispatch('getAppointments', { args, errorMessages });
            },

            getIntervals() {
                let args = {};
                let errorMessages = {
                    generic: this.$i18n.t('message.genericError'),
                    error: this.$i18n.t('message.genericError') // TODO: Prendre message approprié
                };

                this.$store.dispatch('getIntervals', { args, errorMessages });
            },

            goToStep2() {
                if (this.$refs.step1.validate()) {
                    this.e1 = 2;
                }
            },

            submit() {
                if (this.$refs.step2.validate()) {
                    // Check if at least a whatsapp number, phone number or skype ID was submitted
                    if (this.whatsapp == '' && this.numero == '' && this.skype == '') {
                        Vue.notify({
                            type: 'error',
                            text: this.$i18n.t('message.enterAtLeastOneNumber')
                        });
                    } else {
                        // Submit to server
                        let args = {
                            pays: this.pays,
                            style: this.type,
                            date: this.date,
                            date_debut: this.date_debut,
                            date_fin: this.date_fin,
                            objet: this.objet,
                            nom: this.nom,
                            email: this.email,
                            whatsapp: this.whatsapp,
                            numero: this.numero,
                            skype: this.skype
                        };

                        //console.log("Args:", args);

                        let successMessage = this.$i18n.t('message.appointmentMade');
                        let errorMessages = {
                            generic: this.$i18n.t('message.genericError'),
                            error: this.$i18n.t('message.genericError') // TODO: Prendre message approprié
                        };

                        this.$store.dispatch('makeAppointment', { args, errorMessages, successMessage });
                    }
                }
            },

            open (event) {
                //alert(event.title)
            }
        },

        mounted() {
            // Récupérer les pays
            this.getCountries();

            // Récupérer les RDVs
            this.getAppointments();

            // Récupérer les intervales
            this.getIntervals();

            // this.$refs.calendar.scrollToTime('08:00');
        }
    }
</script>

<style scoped>
    .label {
        color: #00ADA7;
        margin-bottom: 0;
    }

    .my-event {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        border-radius: 2px;
        background-color: #00ADA7;
        color: #ffffff;
        border: 1px solid #00ADA7;
        font-size: 12px;
        padding: 3px;
        cursor: pointer;
        margin-bottom: 1px;
        left: 4px;
        margin-right: 8px;
        position: relative;
    }

    .my-event.with-time {
        position: absolute;
        right: 4px;
        margin-right: 0;
    }
</style>
