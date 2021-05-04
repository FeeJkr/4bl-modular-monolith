import {invoicesConstants} from "../../constants/invoices.constants";

export function create(state = {items: []}, action) {
    switch (action.type) {
        case invoicesConstants.CREATE_REQUEST:
            return {
                request: action.request
            };
        case invoicesConstants.CREATE_SUCCESS:
            return {};
        case invoicesConstants.CREATE_FAILURE:
            return {
                errors: action.errors,
            };
        case invoicesConstants.CREATE_VALIDATION_FAILURE:
            return {
                validationErrors: action.errors,
            };
        default:
            return state
    }
}