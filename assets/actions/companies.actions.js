import {companiesConstants} from "../constants/companies.constants";
import {companiesService} from "../services/companies.service";

export const companiesActions = {
    getAll,
    deleteCompany,
};

function getAll() {
    return dispatch => {
        dispatch(request());

        companiesService.getAll()
            .then(
                companies => dispatch(success(companies)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: companiesConstants.GET_ALL_REQUEST } }
    function success(companies) { return { type: companiesConstants.GET_ALL_SUCCESS, companies } }
    function failure(errors) { return { type: companiesConstants.GET_ALL_FAILURE, errors } }
}

function deleteCompany(id) {
    return dispatch => {
        dispatch(request(id));

        companiesService.deleteCompany(id)
            .then(
                response => dispatch(success(id)),
                errors => dispatch(failure(id, errors))
            );
    };

    function request(id) { return { type: companiesConstants.DELETE_REQUEST, id } }
    function success(id) { return { type: companiesConstants.DELETE_SUCCESS, id } }
    function failure(id, error) { return { type: companiesConstants.DELETE_FAILURE, id, error } }
}
