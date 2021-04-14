import axios from "axios";
import {companiesDictionary} from "../helpers/routes/companies.dictionary";
import {authHeader} from "../helpers/authHeader";

export const companiesService = {
    getAll,
    deleteCompany,
};

function getAll() {
    return axios.get(companiesDictionary.GET_ALL_URL, {
        headers: {...authHeader()}
    }).then((response) => response.data);
}

function deleteCompany(id) {
    return axios.delete(companiesDictionary.DELETE_URL.replace('{id}', id), {
        headers: {...authHeader()}
    });
}