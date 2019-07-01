<template>
    <v-container>
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
                                        <v-autocomplete
                                                v-model="mRdv.pays"
                                                color="primary"
                                                :rules="[nameRules.required]"
                                                :items="mCountries"
                                                item-text="name"
                                                item-value="name"
                                                :label="$tc('message.qCountries', 1)"
                                        ></v-autocomplete>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-autocomplete
                                                v-model="mRdv.style"
                                                color="primary"
                                                :rules="[nameRules.required]"
                                                :items="types"
                                                item-text="value"
                                                item-value="key"
                                                :label="$tc('message.qTypes', 1)"
                                        ></v-autocomplete>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <v-container>
                                                    <p>
                                                        Durée en moyen de l’entretien : {{ intervale.telephonique }} min<br>
                                                        Pour les présentations en vidéoconférence : {{ intervale.video}} min<br>
                                                        Votre fuseau horaire est : (en fonction du lieu de résidence)
                                                    </p>
                                                </v-container>
                                                Choisissez la date et l’heure :<br>
                                            </v-flex>

                                            <v-layout row wrap>
                                                <v-flex xs12 sm6>
                                                    <v-date-picker v-model="picker2" color="green lighten-1" header-color="primary"></v-date-picker>
                                                </v-flex>
                                                <v-flex xs12 sm6>
                                                    <v-time-picker v-model="picker"></v-time-picker>
                                                </v-flex>
                                            </v-layout>

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

                                        <v-text-field

                                            v-model="date_debut"

                                            color="primary"

                                            :label="$t('message.qTime')"

                                            disabled

                                        ></v-text-field>

                                    </v-flex>
                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-autocomplete
                                                v-model="mRdv.objet"
                                                color="primary"
                                                :rules="[nameRules.required]"
                                                :items="objets"
                                                :label="$t('message.qSubject')"
                                        ></v-autocomplete>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-form>
                    </v-card>

                    <v-btn
                            color="primary"
                            @click="goToStep2"
                    >
                        {{ $t('message.next') }}
                    </v-btn>
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
                                        <v-text-field
                                                v-model="selectedDate"
                                                color="primary"
                                                :label="$t('message.qTime')"
                                                disabled
                                        ></v-text-field>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-text-field
                                                v-model="mRdv.nom"
                                                :rules="[nameRules.required]"
                                                color="primary"
                                                :label="$t('message.qName')"
                                        ></v-text-field>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-text-field
                                                v-model="mRdv.email"
                                                :rules="[emailRules.required, emailRules.valid]"
                                                color="primary"
                                                :label="$t('message.qEmail')"
                                                :hint="$t('message.emailHint')"
                                        ></v-text-field>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-text-field
                                                v-model="mRdv.whatsapp"
                                                color="primary"
                                                :label="$t('message.whatsappNumber')"
                                        ></v-text-field>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-text-field
                                                v-model="mRdv.telephone"
                                                color="primary"
                                                :label="$t('message.phoneNumber')"
                                        ></v-text-field>
                                    </v-flex>

                                    <v-flex
                                            xs12
                                            d-flex
                                    >
                                        <v-text-field
                                                v-model="mRdv.skype"
                                                color="primary"
                                                :label="$t('message.skype')"
                                        ></v-text-field>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-form>
                    </v-card>

                    <v-btn
                            @click="e1 = 1"
                            flat
                    >
                        {{ $t('message.previous') }}
                    </v-btn>

                    <v-btn
                            color="primary"
                            @click="submit"
                    >
                        {{ $t('message.submit') }}
                    </v-btn>
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
        name: "EditAppointment",

        computed: {
            ...mapGetters(["countries", "rdvs", "rdv", "intervale"]),

            mRdv: function() {
                return this.rdv;
            },

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
                let newRdvs = this.rdvs;
                newRdvs.push(this.rdv);

                let eArray = [];

                _.forOwn(this.rdvs, function(value, key) {
                    let durationObject = moment.utc(moment(value.date_fin, 'YYYY-MM-DD HH:mm:ss')
                        .diff(moment(value.date_debut, 'YYYY-MM-DD HH:mm:ss')));

                    let e = {
                        //title: self.$i18n.t('message.' + value.style),
                        title: value.style,
                        date: moment(value.date_debut).format('YYYY-MM-DD'),
                        time: moment(value.date_debut).format('HH:mm'),
                        duration: durationObject._i / (1000 * 60)
                    };

                    eArray.push(e);
                });

                return eArray;
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
                let duration = this.intervale.telephonique;

                // Check type
                if (this.type == 'skype') {
                    duration = this.intervale.video;
                }

                // Determine end date
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
                type: 'appel direct',
                types: [
                    { key: 'appel direct', value: 'Appel direct' },
                    { key: 'whatsapp', value: 'WhatsApp' },
                    { key: 'skype', value: 'Skype' },
                ],
                date: this.rdv != null ? moment(this.rdv.date_debut).format('YYYY-MM-DD') : moment(new Date()).format('YYY-MM-DD'),
                heure_debut: this.rdv != null ? moment(this.rdv.date_debut).format('HH:mm') : moment(new Date()).format('HH:mm'),
                heure_fin: this.rdv != null ? moment(this.rdv.date_fin).format('HH:mm') : moment(new Date()).format('HH:mm'),
                objets: [
                    'Information sur nos services',
                    'Au sujet des rapports médicaux et factures reçus',
                    'Au sujet d’une invitation à un évènement',
                    'Autre sujet',
                ],
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

            getCountries() {
                let args = {};
                let errorMessages = {
                    generic: this.$i18n.t('message.genericError'),
                    error: this.$i18n.t('message.genericError') // TODO: Prendre message approprié
                };

                this.$store.dispatch('getCountries', { args, errorMessages });
            },

            getAppointment() {
                let args = {
                    rdv: this.$route.params.appointment
                };
                let errorMessages = {
                    generic: this.$i18n.t('message.genericError'),
                    error: this.$i18n.t('message.genericError') // TODO: Prendre message approprié
                };

                this.$store.dispatch('getAppointment', { args, errorMessages });
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
                    if ((this.mRdv.whatsapp == null || this.mRdv.whatsapp == '')
                        && (this.mRdv.numero == null || this.mRdv.numero == '')
                        && (this.mRdv.skype == null || this.mRdv.skype == '')) {
                        Vue.notify({
                            type: 'error',
                            text: this.$i18n.t('message.enterAtLeastOneNumber')
                        });
                    } else {
                        // Submit to server
                        let args = {
                            rdv: this.$route.params.appointment,
                            pays: this.mRdv.pays,
                            style: this.mRdv.style,
                            date_debut: this.date_debut,
                            date_fin: this.date_fin,
                            objet: this.mRdv.objet,
                            nom: this.mRdv.nom,
                            email: this.mRdv.email,
                            whatsapp: this.mRdv.whatsapp,
                            numero: this.mRdv.numero,
                            skype: this.mRdv.skype
                        };

                        console.log("Args:", args);

                        let successMessage = this.$i18n.t('message.appointmentUpdated');
                        let errorMessages = {
                            generic: this.$i18n.t('message.genericError'),
                            error: this.$i18n.t('message.genericError') // TODO: Prendre message approprié
                        };

                        this.$store.dispatch('updateAppointment', { args, errorMessages, successMessage });
                    }
                }
            },

            open (event) {
                //alert(event.title)
            }
        },

        mounted() {
            // Récupérer le RDV
            this.getAppointment();

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

</style>
