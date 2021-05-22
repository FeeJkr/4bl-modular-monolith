import { combineReducers } from 'redux';
import {companies} from "./companies.reducer";
import {invoices} from "./invoices";
import {authentication} from "./authentication";

const rootReducer = combineReducers({
    authentication,
    companies,
    invoices,
});

export default rootReducer;