import {financesCategoriesConstants} from "../../../constants/finances.categories.constants";

export function all(state = {items: []}, action) {
    switch (action.type) {
        case financesCategoriesConstants.GET_ALL_REQUEST:
            return {
                loading: true
            };
        case financesCategoriesConstants.GET_ALL_SUCCESS:
            return {
                items: action.categories
            };
        case financesCategoriesConstants.GET_ALL_FAILURE:
            return {
                errors: action.errors
            };
        case financesCategoriesConstants.UPDATE_AFTER_SUCCESS_DELETE:
            return {
                items: state.items.filter(invoice => invoice.id !== action.id)
            };
        default:
            return state
    }
}