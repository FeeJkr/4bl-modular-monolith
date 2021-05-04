import {invoicesConstants} from "../../constants/invoices.constants";

export function all(state = {items: []}, action) {
    switch (action.type) {
        case invoicesConstants.GET_ALL_REQUEST:
            return {
                loading: true
            };
        case invoicesConstants.GET_ALL_SUCCESS:
            return {
                items: action.invoices
            };
        case invoicesConstants.GET_ALL_FAILURE:
            return {
                errors: action.errors
            };
        case invoicesConstants.UPDATE_AFTER_SUCCESS_DELETE:
            return {
                items: state.items.filter(invoice => invoice.id !== action.id)
            };
        default:
            return state
    }
}