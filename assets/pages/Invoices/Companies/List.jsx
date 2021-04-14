import React, {useEffect} from 'react';
import './List.css';
import {useDispatch, useSelector} from "react-redux";
import {companiesActions} from "../../../actions/companies.actions";
import {Link} from "react-router-dom";

function List() {
    const companies = useSelector(state => state.companies.items);
    const dispatch = useDispatch();

    useEffect(() => {
        dispatch(companiesActions.getAll());
    }, []);

    function handleDelete(id) {
        dispatch(companiesActions.deleteCompany(id));
    }

    return (
        <div className="container-fluid">
            <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>Companies</h4>

            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <div className="card-body">
                            <div className="mb-2 row">
                                <div className="col-md-12" style={{textAlign: 'right'}}>
                                    <button className="button-create-new btn btn-success"
                                            id="button-create-new-company">
                                        <i className="bi bi-plus"/>
                                        Create new
                                    </button>
                                </div>
                            </div>

                            <div>
                                <table className="table align-middle table-nowrap table-check">
                                    <thead className="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Identification Number</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table-companies-body">
                                    {companies && companies.map(function (company) {
                                        return (
                                            <tr key={company.id}>
                                                <th scope="row">{company.id}</th>
                                                <td>{company.name}</td>
                                                <td>{company.identificationNumber}</td>
                                                <td>{company.street}, {company.zipCode} {company.city}</td>
                                                <td>
                                                    <div className="gap-3"
                                                         style={{display: 'flex', gridGap: '1 rem'}}>
                                                        <Link to={'companies/edit/' + company.id}>
                                                            <i className="bi bi-pencil edit-company-button"
                                                                style={{color: '#34c38f', fontSize: '18 px'}}
                                                            />
                                                        </Link>
                                                        <a onClick={() => handleDelete(company.id)}
                                                              style={{color: '#f46a6a', fontSize: '18 px', cursor: 'pointer'}}>
                                                            <i className="bi bi-trash delete-company-button"
                                                                style={{color: '#f46a6a', fontSize: '18 px'}}
                                                            />
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        );
                                    })}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export {List};