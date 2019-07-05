<template>
    <v-container>
        <v-data-table
                v-if="contracts.length"
                :headers="headers"
                :items="contracts"
                class="elevation-1"
                item-key="id"
        >
            <template slot="items" slot-scope="props">
                <contract-table-row :contracts="contracts" :contract="props.item" :key="props.item.id"></contract-table-row>
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
    import ContractTableRow from "../../../components/Contracts/ContractTableRow";

    export default {
        name: "ContractList",

        computed: {
            ...mapGetters(["contracts"])
        },

        components: { ContractTableRow },

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
            getContracts() {
                let args = {
                    offset: this.offset,
                    limit: this.limit
                };

                this.$store.dispatch('getContracts', { args : args });
            }
        },

        mounted() {
            // Fetch contract list
            this.getContracts();
        }
    }
</script>

<style scoped>

</style>