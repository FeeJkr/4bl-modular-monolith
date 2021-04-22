import axios from "axios";
import {companiesDictionary} from "../helpers/routes/companies.dictionary";
import {authHeader} from "../helpers/authHeader";

export const companiesService = {
    getAll,
    deleteCompany,
    createCompany,
    getOne,
    updateBasicInformation,
    updatePaymentInformation,
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

function createCompany(formData) {
    return axios.post(companiesDictionary.CREATE_URL, {
        name: formData.name,
        identificationNumber: formData.identificationNumber,
        email: formData.email,
        phoneNumber: formData.phoneNumber,
        street: formData.street,
        zipCode: formData.zipCode,
        city: formData.city,
    }, {
        headers: {...authHeader()},
    }).catch(error => Promise.reject(error.response.data));
}

function getOne(id) {
    return axios.get(companiesDictionary.GET_ONE_URL.replace('{id}', id), {
        headers: {...authHeader()}
    }).then((response) => response.data);
}

function updateBasicInformation(id, formData) {
    return axios.post(companiesDictionary.UPDATE_BASIC_INFORMATION_URL.replace('{id}', id), {
        name: formData.name,
        identificationNumber: formData.identificationNumber,
        email: formData.email,
        phoneNumber: formData.phoneNumber,
        street: formData.street,
        zipCode: formData.zipCode,
        city: formData.city,
    }, {
        headers: {...authHeader()},
    }).catch(error => Promise.reject(error.response.data));
}

function updatePaymentInformation(id, formData) {
    return axios.post(companiesDictionary.UPDATE_PAYMENT_INFORMATION_URL.replace('{id}', id), {
        paymentType: formData.paymentType,
        paymentLastDate: formData.paymentLastDate,
        bank: formData.bank,
        accountNumber: formData.accountNumber,
    }, {
        headers: {...authHeader()},
    }).catch(error => Promise.reject(error.response.data));
}
