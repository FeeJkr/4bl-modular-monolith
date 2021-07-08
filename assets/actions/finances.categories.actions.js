import {history} from "../helpers/history";
import {financesCategoriesService} from "../services/finances.categories.service";
import {financesCategoriesConstants} from "../constants/finances.categories.constants";

export const financesCategoriesActions = {
    createCategory,
    updateCategory,
    deleteCategory,
    getAll,
    getByType,
    getOne,
    change,
    clearAlerts,
};

function createCategory(formData) {
    return dispatch => {
        dispatch(request(formData));

        financesCategoriesService.createCategory(formData)
            .then(
                response => {
                    dispatch(success());
                    history.push('/finances/categories');
                },
                errors => dispatch(failure(errors, formData))
            );
    };

    function request(formData) { return { type: financesCategoriesConstants.CREATE_REQUEST, request: formData } }
    function success() { return { type: financesCategoriesConstants.CREATE_SUCCESS } }
    function failure(errors, category) {
        if (errors.type === 'DomainError') {
            return { type: financesCategoriesConstants.CREATE_FAILURE, errors, category }
        }

        return { type: financesCategoriesConstants.CREATE_VALIDATION_FAILURE, errors: errors.errors, category, }
    }
}

function updateCategory(id, category) {
    return dispatch => {
        dispatch(request());

        financesCategoriesService.updateCategory(id, category)
            .then(
                response => {
                    dispatch(success());
                },
                errors => dispatch(failure(errors, category))
            );
    };

    function request() { return { type: financesCategoriesConstants.UPDATE_REQUEST, isLoading: true } }
    function success() { return { type: financesCategoriesConstants.UPDATE_SUCCESS, isUpdated: true } }
    function failure(errors, category) {
        if (errors.type === 'DomainError') {
            return { type: financesCategoriesConstants.UPDATE_FAILURE, errors, category}
        }

        return { type: financesCategoriesConstants.UPDATE_VALIDATION_FAILURE, errors: errors.errors, category}
    }
}

function deleteCategory(id) {
    return dispatch => {
        dispatch(request(id));

        financesCategoriesService.deleteCategory(id)
            .then(
                response => {
                    dispatch(success());
                    dispatch(updateCategoriesList(id));
                },
                errors => dispatch(failure(errors))
            );

        function request(id) { return {type: financesCategoriesConstants.DELETE_REQUEST, id} }
        function success() { return {type: financesCategoriesConstants.DELETE_SUCCESS} }
        function failure(errors) { return {type:financesCategoriesConstants.DELETE_FAILURE, errors} }
        function updateCategoriesList(id) { return {type: financesCategoriesConstants.UPDATE_AFTER_SUCCESS_DELETE, id } }
    }
}

function getAll() {
    return dispatch => {
        dispatch(request());

        financesCategoriesService.getAll()
            .then(
                categories => dispatch(success(categories)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: financesCategoriesConstants.GET_ALL_REQUEST } }
    function success(categories) { return { type: financesCategoriesConstants.GET_ALL_SUCCESS, categories } }
    function failure(errors) { return { type: financesCategoriesConstants.GET_ALL_FAILURE, errors } }
}

function getByType(type) {
    return dispatch => {
        dispatch(request());

        financesCategoriesService.getByType(type)
            .then(
                categories => dispatch(success(categories)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: financesCategoriesConstants.GET_BY_TYPE_REQUEST } }
    function success(categories) { return { type: financesCategoriesConstants.GET_BY_TYPE_SUCCESS, categories } }
    function failure(errors) { return { type: financesCategoriesConstants.GET_BY_TYPE_FAILURE, errors } }
}

function getOne(id) {
    return dispatch => {
        dispatch(request());

        financesCategoriesService.getOne(id)
            .then(
                category => dispatch(success(category)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: financesCategoriesConstants.GET_ONE_REQUEST } }
    function success(category) { return { type: financesCategoriesConstants.GET_ONE_SUCCESS, category } }
    function failure(errors) { return { type: financesCategoriesConstants.GET_ONE_FAILURE, errors } }
}

function change(category) {
    return dispatch => {
        dispatch(change(category))

        function change(category) { return { type: financesCategoriesConstants.GET_ONE_CHANGED, category} }
    }
}

function clearAlerts() {
    return dispatch => {dispatch({type: financesCategoriesConstants.CLEAR_ALERTS})};
}
