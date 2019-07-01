<template>
    <v-container>
        <!--h1>
            <i class="fa fa-users"></i>

            Administration des Partenaires

            <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">
                Roles
            </a>

            <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">
                Permissions
            </a>
        </h1>

        <hr-->

        <v-data-table
                v-if="partners.length"
                :headers="headers"
                :items="partners"
                class="elevation-1"
                item-key="id"
        >
            <template slot="items" slot-scope="props">
                <partner-table-row :partners="partners" :partner="props.item" :key="props.item.id"></partner-table-row>
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
</template>

<script>
    import { mapGetters } from 'vuex';
    import PartnerTableRow from "../../../components/Partners/PartnerTableRow";

    export default {
        name: "PartnerList",

        computed: {
            ...mapGetters(["partners"])
        },

        components: { PartnerTableRow },

        data() {
            return {
                headers: [
                    {
                        text: this.$i18n.t('message.name'),
                        align: 'left',
                        sortable: false,
                        value: 'name'
                    },
                    {
                        text: this.$i18n.t('message.email'),
                        value: 'email'
                    },
                    {
                        text: this.$i18n.t('message.phoneNumber'),
                        value: 'telephone'
                    },
                    {
                        text: this.$i18n.tc('message.countries', 1),
                        value: 'pays'
                    },
                    {
                        text: this.$i18n.t('message.createdAt'),
                        value: 'created_at'
                    },
                    {
                        text: this.$i18n.tc('message.operations', 2),
                        value: 'operations'
                    }
                ],
                offset: 0,
                limit: -1,
            }
        },

        methods: {
            getPartners() {
                let args = {
                    offset: this.offset,
                    limit: this.limit
                };

                this.$store.dispatch('getPartners', { args : args });
            }
        },

        mounted() {
            // Fetch partner list
            this.getPartners();
        }
    }
</script>

<style scoped>

</style>