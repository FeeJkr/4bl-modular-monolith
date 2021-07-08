import {financesCategoriesConstants} from "../../../constants/finances.categories.constants";

export function one(state = {items: []}, action) {
    switch (action.type) {
        case financesCategoriesConstants.GET_ONE_REQUEST:
            return {};
        case financesCategoriesConstants.GET_ONE_SUCCESS:
            return {
                category: action.category,
            };
        case financesCategoriesConstants.GET_ONE_FAILURE:
            return {
                errors: action.errors,
            };
        case financesCategoriesConstants.GET_ONE_CHANGED:
            return {
                category: {...state.category, ...action.category},
            };
        default:
            return state
    }
}