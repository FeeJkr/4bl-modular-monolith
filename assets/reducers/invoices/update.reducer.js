import {invoicesConstants} from "../../constants/invoices.constants";

export function update(state = {}, action) {
    switch (action.type) {
        case invoicesConstants.UPDATE_REQUEST:
            return {
                isLoading: true,
            };
        case invoicesConstants.UPDATE_SUCCESS:
            return {
                isUpdated: true,
            };
        case invoicesConstants.UPDATE_FAILURE:
            return {
                errors: action.errors,
            };
        case invoicesConstants.UPDATE_VALIDATION_FAILURE:
            return {
                validationErrors: action.errors,
            };
        case invoicesConstants.CLEAR_ALERTS:
            return {
                ...state,
                isUpdated: false,
            };
        default:
            return state
    }
}