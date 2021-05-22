import axios from "axios";
import {filesystemDictionary} from "../helpers/routes/filesystem.dictionary";

export const filesystemService = {
    getFile,
};

function getFile(filename) {
    return axios.get(filesystemDictionary.GET_BY_NAME_URL.replace('{filename}', filename), {
        responseType: "blob",
    }).then((response) => response.data);
}
