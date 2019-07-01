<template>
    <v-container>
        <v-data-table
                v-if="rdvs.length"
                :items="items"
                class="elevation-1"
        >
            <template slot="items" slot-scope="props">
                <appointment-table-row :date="props.item.date" :rdvs="props.item.rdvs" :key="props.item.date"></appointment-table-row>
            </template>
        </v-data-table>

        <template v-else>
            <v-flex xs12>
                <div class="card">
                    <div class="card-body text-xs-center">
                        <p class="card-text">
                            {{ $t('message.noResults') }}
                        </p>
                    </div>
                </div>
            </v-flex>
        </template>
    </v-container>

    <!--div>
        <v-layout wrap>
            <v-flex
                xs12
                class="mb-3"
            >
                <v-sheet height="500">
                    <v-calendar
                        ref="calendar"
                        v-model="start"
                        :type="type"
                        :end="end"
                        color="primary"
                        @click:date="dateSelected"
                        @click:day="daySelected"
                    >
                        <template slot="day" slot-scope="{ date }">
                            <v-menu
                                    v-model="dialog"
                                    full-width
                                    offset-x
                            >
                                <template slot="activator" slot-scope="{ on }">
                                    <div
                                            v-if="datePicked(date)"
                                            v-ripple
                                            class="my-event"
                                            v-on="on"
                                    >
                                        {{ rdvs.length }}
                                    </div>
                                </template>

                                <v-card
                                        color="grey lighten-4"
                                        min-width="350px"
                                        flat
                                >
                                    <v-toolbar
                                            color="primary"
                                            dark
                                    >
                                        <v-btn icon>
                                            <v-icon>edit</v-icon>
                                        </v-btn>
                                        <v-toolbar-title>
                                            {{ events[0].title }}
                                        </v-toolbar-title>
                                        <v-spacer></v-spacer>
                                        <v-btn icon>
                                            <v-icon>favorite</v-icon>
                                        </v-btn>
                                        <v-btn icon>
                                            <v-icon>more_vert</v-icon>
                                        </v-btn>
                                    </v-toolbar>
                                    <v-card-title primary-title>
                                        <span>
                                            events[0].details
                                        </span>
                                    </v-card-title>
                                    <v-card-actions>
                                        <v-btn
                                                flat
                                                color="secondary"
                                        >
                                            Cancel
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-menu>

                            <!--template-- v-for="event in eventsMap[date]">
                                <v-menu
                                    :key="event.title"
                                    v-model="event.open"
                                    full-width
                                    offset-x
                                >
                                    <template slot="activator" slot-scope="{ on }">
                                        <div
                                            v-if="!event.time"
                                            v-ripple
                                            class="my-event"
                                            v-on="on"
                                            v-html="event.title"
                                        ></div>
                                    </template>
                                    <v-card
                                        color="grey lighten-4"
                                        min-width="350px"
                                        flat
                                    >
                                        <v-toolbar
                                            color="primary"
                                            dark
                                        >
                                            <v-btn icon>
                                                <v-icon>edit</v-icon>
                                            </v-btn>
                                            <v-toolbar-title v-html="event.title"></v-toolbar-title>
                                            <v-spacer></v-spacer>
                                            <v-btn icon>
                                                <v-icon>favorite</v-icon>
                                            </v-btn>
                                            <v-btn icon>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                        </v-toolbar>
                                        <v-card-title primary-title>
                                            <span v-html="event.details"></span>
                                        </v-card-title>
                                        <v-card-actions>
                                            <v-btn
                                                flat
                                                color="secondary"
                                            >
                                                Cancel
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-menu>
                            </--template-->
                        <!--/template>

                    </v-calendar>
                </v-sheet>
            </v-flex>

            <v-flex
                sm4
                xs12
                class="text-sm-left text-xs-center"
            >
                <v-btn @click="$refs.calendar.prev()">
                    <v-icon
                        dark
                        left
                    >
                        keyboard_arrow_left
                    </v-icon>
                    Prev
                </v-btn>
            </v-flex>
            <v-flex
                sm4
                xs12
                class="text-xs-center"
            >
                <v-select
                    v-model="type"
                    :items="typeOptions"
                    label="Type"
                ></v-select>
            </v-flex>
            <v-flex
                sm4
                xs12
                class="text-sm-right text-xs-center"
            >
                <v-btn @click="$refs.calendar.next()">
                    Next
                    <v-icon
                        right
                        dark
                    >
                        keyboard_arrow_right
                    </v-icon>
                </v-btn>
            </v-flex>
        </v-layout>

        <v-layout row justify-center>
            <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                <v-card>
                    <v-toolbar dark color="primary">
                        <v-btn icon dark @click="dialog = false">
                            <v-icon>close</v-icon>
                        </v-btn>
                        <v-toolbar-title>Settings</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn dark flat @click="dialog = false">Save</v-btn>
                        </v-toolbar-items>
                    </v-toolbar>
                    <v-list three-line subheader>
                        <v-subheader>Informations du Rendez-Vous</v-subheader>
<!--//Inserere les informartions concernant le rendez vous ici-->
                    <!--/v-list>
                    <v-divider></v-divider>
                    <v-list three-line subheader>
                        <v-subheader>Informations Personnelles</v-subheader>
<!--                       //Inserer les informations personnelles ici-->
                    <!--/v-list>
                </v-card>
            </v-dialog>
        </v-layout>
    </div-->

</template>

<script>
    import { mapGetters } from 'vuex';
    import AppointmentTableRow from '../../../components/Appointments/AppointmentTableRow';
    import lodash from 'lodash';
    import Vue from 'vue';
    import moment from 'moment';

    export default {
        name: "AppointmentList",
        components: { AppointmentTableRow },
        data () {
            return {
                type: 'month',
                start: moment(new Date()).format('YYYY-MM-DD HH:mm'),
                end: '2020-06-10',
                typeOptions: [
                    { text: 'Day', value: 'day' },
                    { text: '4 Day', value: '4day' },
                    { text: 'Week', value: 'week' },
                    { text: 'Month', value: 'month' }
                ],
                events : [
                    {
                        title: 'Weekly Meeting',
                        date: '2019-06-18',
                        // time: '09:00',
                        duration: 45,
                        details: 'Going to the beach!',
                        open: false
                    },
                    {
                        title: 'Thomas\'s Birthday',
                        date: '2019-06-20',
                        details: 'Going to the beach!',
                        open: false
                    },
                    {
                        title: 'Mash Potatoes',
                        date: '2019-06-25',
                        // time: '12:30',
                        duration: 180,
                        details: 'Going to the beach!',
                        open: false
                    }
                ],
                dialog: false,
            }
        },
        computed: {
            ...mapGetters(["rdvs"]),

            items: function() {
                console.log("RDVs:", this.rdvs);

                let newRdvs = this.rdvs;

                _.forEach(newRdvs, function(value) {
                    console.log("Value:", value);
                    value.date = moment(value.date_debut).format('YYYY-MM-DD');
                });

                let result = _.chain(newRdvs)
                    .groupBy('date')
                    .toPairs()
                    .map(function(r) {
                        return _.fromPairs(_.zip(["date", "rdvs"], r));
                    })
                    .value();

                console.log("Sorted RDVs:", result);

                return result;
            },

            // convert the list of events into a map of lists keyed by date
            eventsMap () {
                const map = {}
                this.events.forEach(e => (map[e.date] = map[e.date] || []).push(e))
                return map
            }
        },
        mounted () {
            //this.$refs.calendar.scrollToTime('08:00');

            this.getAppointments();
        },
        methods: {
            open (event) {
                alert(event.title)
            },
            dateSelected(event){
                console.log("Date:", event)
                this.dialog = true;
            },
            daySelected(event){
                console.log("Day:",event);
                // this.dialog = true;
            },
            datePicked(date) {
                let picked = false;
                let d1 = moment(date).format('YYYY-MM-DD');

                // Check if date is in rdvs array
                _.forEach(this.rdvs, function(value) {
                    let d2 = moment(value.date_debut).format('YYYY-MM-DD');

                    /*console.log("Date 1:", date);
                    console.log("Date 2:", value.date_debut);
                    console.log("Equal?", date == d2);*/

                    if (d1 == d2) {
                        picked = true
                    }
                });

                console.log("Picked:", picked);

                return picked;
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
            }
        }
    }
</script>

<style scoped>

    .my-event {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        border-radius: 2px;
        background-color: #00ADA7;
        color: #ffffff;
        border: 1px solid #00ADA7;
        width: 100%;
        font-size: 12px;
        padding: 3px;
        cursor: pointer;
        margin-bottom: 1px;
    }

</style>
