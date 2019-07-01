/**
 * Rendez-Vous Module
 */
import Vue from 'vue';
import router from '../../../router';
import { apiModel, makeApiRequest } from "../../../api";
import AppConfig from '../../../constants/AppConfig';

// States
const state = {
    rdvs: [],
    rdv: {},
    intervale: {}
};

// Getters
const getters = {
    rdvs: state => {
        return state.rdvs
    },

    rdv: state => {
        return state.rdv
    },

    intervale: state => {
        return state.intervale
    }
};

// Actions
const actions = {
    getAppointments(context, payload) {
        function successCallback(response) {
            context.commit('getAppointmentsHandler', { rdvs: response.data.rdvs });
        }

        function errorCallback(error) {
            Vue.notify({
                type: 'error',
                text: payload.errorMessages.error
            });
        }

        const localToken = localStorage.getItem('ms-token');

        makeApiRequest(payload.args, apiModel.RDV.List, localToken, successCallback, errorCallback, payload.errorMessages);
    },

    getAppointment(context, payload) {
        function successCallback(response) {
            context.commit('getAppointmentHandler', { rdv: response.data.rdv });
        }

        function errorCallback(error) {
            Vue.notify({
                type: 'error',
                text: payload.errorMessages.error
            });
        }

        const localToken = localStorage.getItem('ms-token');

        makeApiRequest(payload.args, apiModel.RDV.Get, localToken, successCallback, errorCallback, payload.errorMessages);
    },

    getIntervals(context, payload) {
        function successCallback(response) {
            context.commit('getIntervalsHandler', { intervale: response.data.intervale });
        }

        function errorCallback(error) {
            Vue.notify({
                type: 'error',
                text: payload.errorMessages.error
            });
        }

        const localToken = localStorage.getItem('ms-token');

        makeApiRequest(payload.args, apiModel.RDV.GetIntervals, localToken, successCallback, errorCallback, payload.errorMessages);
    },

    makeAppointment(context, payload) {
        function successCallback(response) {
            Vue.notify({
                type: 'success',
                text: payload.successMessage
            });
        }

        function errorCallback(error) {
            Vue.notify({
                type: 'error',
                text: payload.errorMessages.error
            });
        }

        const localToken = localStorage.getItem('ms-token');

        makeApiRequest(payload.args, apiModel.RDV.Create, localToken, successCallback, errorCallback, payload.errorMessages);
    },

    updateAppointment(context, payload) {
        function successCallback(response) {
            Vue.notify({
                type: 'success',
                text: payload.successMessage
            });

            router.push({ name: 'appointments' });
        }

        function errorCallback(error) {
            Vue.notify({
                type: 'error',
                text: payload.errorMessages.error
            });
        }

        const localToken = localStorage.getItem('ms-token');

        makeApiRequest(payload.args, apiModel.RDV.Update, localToken, successCallback, errorCallback, payload.errorMessages);
    },

    deleteAppointment(context, payload) {
        function successCallback(response) {
            context.commit('deleteAppointmentHandler', { index: payload.index, successMessage: payload.successMessage });
        }

        function errorCallback(error) {
            Vue.notify({
                type: 'error',
                text: payload.errorMessages.error
            });
        }

        const localToken = localStorage.getItem('ms-token');

        makeApiRequest(payload.args, apiModel.RDV.Delete, localToken, successCallback, errorCallback, payload.errorMessages);
    }
};

// Mutations
const mutations = {
    getAppointmentsHandler(state, { rdvs }) {
        // Update rdvs state
        state.rdvs = rdvs;
    },

    getAppointmentHandler(state, { rdv }) {
        // Update rdv state
        state.rdv = rdv;
    },

    getIntervalsHandler(state, { intervale }) {
        // Update intervale state
        state.intervale = intervale;
    },

    deleteAppointmentHandler(state, { index, successMessage }) {
        state.rdvs.splice(index, 1);

        Vue.notify({
            type: 'success',
            text: successMessage
        });
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}