import { combineReducers } from 'redux';
import { authentication } from './authentication.reducer';
import {registration} from "./registration.reducer";
import {companies} from "./companies.reducer";
import {invoices} from "./invoices";

const rootReducer = combineReducers({
    authentication,
    registration,
    companies,
    invoices,
});

export default rootReducer;