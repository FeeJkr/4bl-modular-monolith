import {invoicesConstants} from "../../constants/invoices.constants";

export function one(state = {items: []}, action) {
    switch (action.type) {
        case invoicesConstants.GET_ONE_REQUEST:
            return {};
        case invoicesConstants.GET_ONE_SUCCESS:
            return {
                invoice: action.invoice,
            };
        case invoicesConstants.GET_ONE_FAILURE:
            return {
                errors: action.errors,
            };
        case invoicesConstants.GET_ONE_CHANGED:
            return {
                invoice: {...state.invoice, ...action.invoice},
            };
        default:
            return state
    }
}