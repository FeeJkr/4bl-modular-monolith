import {companiesConstants} from "../constants/companies.constants";

export function companies(state = {}, action) {
    switch (action.type) {
        // get all
        case companiesConstants.GET_ALL_REQUEST:
            return {
                loading: true
            };
        case companiesConstants.GET_ALL_SUCCESS:
            return {
                items: action.companies
            };
        case companiesConstants.GET_ALL_FAILURE:
            return {
                errors: action.errors
            };

        // delete
        case companiesConstants.DELETE_REQUEST:
            return {
                ...state,
            };
        case companiesConstants.DELETE_SUCCESS:
            return {
                items: state.items.filter(company => company.id !== action.id)
            };
        case companiesConstants.DELETE_FAILURE:
            return {
                ...state,
                errors: action.errors,
            };

        // create
        case companiesConstants.CREATE_REQUEST:
            return {
                request: action.request
            };
        case companiesConstants.CREATE_SUCCESS:
            return {};
        case companiesConstants.CREATE_FAILURE:
            return {
                errors: action.errors,
            };
        case companiesConstants.CREATE_VALIDATION_FAILURE:
            return {
                validationErrors: action.errors,
            };

        // get one
        case companiesConstants.GET_ONE_REQUEST:
            return {};
        case companiesConstants.GET_ONE_SUCCESS:
            return {
                company: action.company,
            };
        case companiesConstants.GET_ONE_FAILURE:
            return {
                errors: action.errors,
            };

        // update basic information
        case companiesConstants.UPDATE_BASIC_INFORMATION_REQUEST:
            return {
                ...state,
            };
        case companiesConstants.UPDATE_BASIC_INFORMATION_SUCCESS:
            return {
                ...state,
                company: action.company,
                successUpdateBasicInformation: true,
            };
        case companiesConstants.UPDATE_BASIC_INFORMATION_FAILURE:
            return {
                ...state,
                errors: action.errors,
            };
        case companiesConstants.UPDATE_BASIC_INFORMATION_VALIDATION_FAILURE:
            return {
                ...state,
                validationErrors: action.errors,
            };

        // update payment information
        case companiesConstants.UPDATE_PAYMENT_INFORMATION_REQUEST:
            return {
                ...state,
            };
        case companiesConstants.UPDATE_PAYMENT_INFORMATION_SUCCESS:
            return {
                ...state,
                company: action.company,
                successUpdatePaymentInformation: true,
            };
        case companiesConstants.UPDATE_PAYMENT_INFORMATION_FAILURE:
            return {
                ...state,
                errors: action.errors,
            };
        case companiesConstants.UPDATE_PAYMENT_INFORMATION_VALIDATION_FAILURE:
            return {
                ...state,
                validationErrors: action.errors,
            };

        case companiesConstants.CLEAR_ALERTS:
            return {
                ...state,
                successUpdateBasicInformation: false,
                successUpdatePaymentInformation: false,
            }
        default:
            return state
    }
}