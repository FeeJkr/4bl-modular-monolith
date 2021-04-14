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
            }


        default:
            return state
    }
}