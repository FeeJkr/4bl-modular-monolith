import { combineReducers } from 'redux';
import {companies} from "./companies.reducer";
import {invoices} from "./invoices";
import {authentication} from "./authentication";
import {finances} from "./finances";

const rootReducer = combineReducers({
    authentication,
    companies,
    invoices,
    finances,
});

export default rootReducer;