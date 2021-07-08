import axios from "axios";
import {financesCategoriesDictionary} from "../helpers/routes/finances.categories.dictionary";

export const financesCategoriesService = {
    createCategory,
    updateCategory,
    deleteCategory,
    getAll,
    getByType,
    getOne,
};

function createCategory(formData) {
    return axios.post(financesCategoriesDictionary.CREATE_URL, {
        name: formData.name,
        type: formData.type,
        icon: formData.icon,
    }).catch(error => Promise.reject(error.response.data));
}

function updateCategory(id, formData) {
    return axios.post(financesCategoriesDictionary.UPDATE_URL.replace('{id}', id), {
        name: formData.name,
        type: formData.type,
        icon: formData.icon,
    }).catch(error => Promise.reject(error.response.data));
}

function deleteCategory(id) {
    return axios.delete(financesCategoriesDictionary.DELETE_URL.replace('{id}', id));
}

function getAll() {
    return axios.get(financesCategoriesDictionary.GET_ALL_URL)
        .then((response) => response.data);
}

function getByType(type) {
    return axios.get(financesCategoriesDictionary.GET_ALL_BY_TYPE.replace('{type}', type))
        .then((response) => response.data);
}

function getOne(id) {
    return axios.get(financesCategoriesDictionary.GET_ONE_URL.replace('{id}', id))
        .then((response) => response.data);
}
