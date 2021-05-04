import {invoicesConstants} from "../../constants/invoices.constants";

export function _delete(state = {items: []}, action) {
    switch (action.type) {
        case invoicesConstants.DELETE_REQUEST:
            return {
                request: action.request
            };
        case invoicesConstants.DELETE_SUCCESS:
            return {};
        case invoicesConstants.DELETE_FAILURE:
            return {
                errors: action.errors,
            };
        case invoicesConstants.DELETE_VALIDATION_FAILURE:
            return {
                validationErrors: action.errors,
            };
        default:
            return state
    }
}