import axios from "axios";
import {authHeader} from "../helpers/authHeader";
import {filesystemDictionary} from "../helpers/routes/filesystem.dictionary";

export const filesystemService = {
    getFile,
};

function getFile(filename) {
    return axios.get(filesystemDictionary.GET_BY_NAME_URL.replace('{filename}', filename), {
        headers: {...authHeader()},
        responseType: "blob",
    }).then((response) => response.data);
}
