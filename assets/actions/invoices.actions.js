import {invoicesConstants} from "../constants/invoices.constants";
import {invoicesService} from "../services/invoices.service";
import {history} from "../helpers/history";

export const invoicesActions = {
    getAll,
    generateInvoice,
    deleteInvoice,
    getOne,
    change,
    updateInvoice,
    clearAlerts,
};

function getAll() {
    return dispatch => {
        dispatch(request());

        invoicesService.getAll()
            .then(
                invoices => dispatch(success(invoices)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: invoicesConstants.GET_ALL_REQUEST } }
    function success(invoices) { return { type: invoicesConstants.GET_ALL_SUCCESS, invoices } }
    function failure(errors) { return { type: invoicesConstants.GET_ALL_FAILURE, errors } }
}

function generateInvoice(formData) {
    return dispatch => {
        dispatch(request(formData));

        invoicesService.generateInvoice(formData)
            .then(
                response => {
                    dispatch(success());
                    history.push('/invoices');
                },
                errors => dispatch(failure(errors, formData))
            );
    };

    function request(formData) { return { type: invoicesConstants.CREATE_REQUEST, request: formData } }
    function success() { return { type: invoicesConstants.CREATE_SUCCESS } }
    function failure(errors, company) {
        if (errors.type === 'DomainError') {
            return { type: invoicesConstants.CREATE_FAILURE, errors, company }
        }

        return { type: invoicesConstants.CREATE_VALIDATION_FAILURE, errors: errors.errors, company, }
    }
}

function deleteInvoice(id) {
    return dispatch => {
        dispatch(request(id));

        invoicesService.deleteInvoice(id)
            .then(
                response => {
                    dispatch(success());
                    dispatch(updateInvoicesList(id));
                },
                errors => dispatch(failure(errors))
            );

        function request(id) { return {type: invoicesConstants.DELETE_REQUEST, id} }
        function success() { return {type: invoicesConstants.DELETE_SUCCESS} }
        function failure(errors) { return {type:invoicesConstants.DELETE_FAILURE, errors} }
        function updateInvoicesList(id) { return {type: invoicesConstants.UPDATE_AFTER_SUCCESS_DELETE, id } }
    }
}

function getOne(id) {
    return dispatch => {
        dispatch(request());

        invoicesService.getOne(id)
            .then(
                invoice => dispatch(success(invoice)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: invoicesConstants.GET_ONE_REQUEST } }
    function success(invoice) { return { type: invoicesConstants.GET_ONE_SUCCESS, invoice } }
    function failure(errors) { return { type: invoicesConstants.GET_ONE_FAILURE, errors } }
}

function change(invoice) {
    return dispatch => {
        dispatch(change(invoice))

        function change(invoice) { return { type: invoicesConstants.GET_ONE_CHANGED, invoice} }
    }
}

function updateInvoice(invoice) {
    return dispatch => {
        dispatch(request());

        invoicesService.updateInvoice(invoice)
            .then(
                response => {
                    dispatch(success());
                },
                errors => dispatch(failure(errors, invoice))
            );
    };

    function request() { return { type: invoicesConstants.UPDATE_REQUEST, isLoading: true } }
    function success() { return { type: invoicesConstants.UPDATE_SUCCESS, isUpdated: true } }
    function failure(errors, invoice) {
        if (errors.type === 'DomainError') {
            return { type: invoicesConstants.UPDATE_FAILURE, errors, invoice }
        }

        return { type: invoicesConstants.UPDATE_VALIDATION_FAILURE, errors: errors.errors, invoice }
    }
}

function clearAlerts() {
    return dispatch => {dispatch({type: invoicesConstants.CLEAR_ALERTS})};
}
