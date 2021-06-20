import React, {useEffect, useState} from 'react';
import {useDispatch, useSelector} from "react-redux";
import {companiesActions} from "../../actions/companies.actions";
import {Link} from "react-router-dom";
import {Button, Dropdown, Modal, Nav, Toast} from "react-bootstrap";
import expense from './icons/expense.svg';
import income from './icons/income.svg';
import transfer from './icons/transfer.svg';
import './Dashboard.css';
import {useRef} from "react";
import Flatpickr from "react-flatpickr";
import AsyncSelect from "react-select/async/dist/react-select.esm";
import {companiesService} from "../../services/companies.service";
import Select from "react-select";

function Dashboard() {
    const expensesCategories = [{name: 'Expense 1'},{name: 'Expense 2'},{name: 'Expense 3'},{name: 'Expense 4'},{name: 'Expense 5'},{name: 'Expense 6'},{name: 'Expense 7'},{name: 'Expense 8'},{name: 'Expense 9'},{name: 'Expense 10'},{name: 'Expense 11'},{name: 'Expense 12'},{name: 'Expense 13'},{name: 'Expense 14'},{name: 'Expense 15'},{name: 'Expense 16'},{name: 'Expense 17'},{name: 'Expense 18'},{name: 'Expense 19'},{name: 'Expense 20'},{name: 'Expense 21'},{name: 'Expense 22'},{name: 'Expense 23'},{name: 'Expense 24'},{name: 'Expense 25'},{name: 'Expense 26'},{name: 'Expense 27'},{name: 'Expense 28'},{name: 'Expense 29'},{name: 'Expense 30'},{name: 'Expense 31'},{name: 'Expense 32'},{name: 'Expense 33'},{name: 'Expense 34'},{name: 'Expense 35'},{name: 'Expense 36'},{name: 'Expense 37'},{name: 'Expense 38'},{name: 'Expense 39'},{name: 'Expense 40'},{name: 'Expense 41'},{name: 'Expense 42'},];
    const incomeCategories = [{name: 'Income 1'},{name: 'Income 2'},{name: 'Income 3'},];
    const [visibleCategories, setVisibleCategories] = useState(expensesCategories);
    const [inputs, setInputs] = useState({
        category: null,
        transactionType: 'Expenses',
    });
    const [showDropdown, setShowDropdown] = useState(false);

    const ref = useRef(null);

    useEffect(() => {
        /**
         * Alert if clicked on outside of element
         */
        function handleClickOutside(event) {
            if (ref.current && !ref.current.contains(event.target)) {
                setShowDropdown(false);
            }
        }

        // Bind the event listener
        document.addEventListener("mousedown", handleClickOutside);
        return () => {
            // Unbind the event listener on clean up
            document.removeEventListener("mousedown", handleClickOutside);
        };
    }, [ref]);

    const toggleDropdown = () => {
        setShowDropdown(!showDropdown);
    }

    console.log(inputs);

    const chooseCategory = (category) => {

        setInputs({...inputs, category: category.name, });
        setShowDropdown(false);
    }

    function calculate(e) {
        const stringToCalculate = e.target.value;
        const isValid = /^[0-9*\\/+-., ()]+$/.test(stringToCalculate);

        if (isValid) {
            e.target.value = eval(stringToCalculate.replace(',', '.')).toFixed(2);
        } else {
        }
    }

    const changeTransactionType = (event) => {
        const type = event.target.innerText;
        setInputs({...inputs, transactionType: type});

        if (type === 'Income') {
            setVisibleCategories(incomeCategories);

            return;
        }

        if (type === 'Expenses') {
            setVisibleCategories(expensesCategories);

            return;
        }

        setInputs({...inputs, category: 'Transfer', transactionType: 'Transfer'});
        setVisibleCategories([]);
        setShowDropdown(false);
    }

    const companiesOptions = () => new Promise(resolve => {
        resolve(
            companiesService.getAll().then(data => {
                return data.map((company) => {return {value: company.id, label: company.name}});
            })
        );
    });

    const currencySelectStyles = {
        container: (provided, state) => ({
            ...provided,
            width: '100px',
            borderTopLeftRadius: 0,
            borderBottomLeftRadius: 0,
        }),
    }

    return (
        <div className="container-fluid">
            <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>Finances</h4>

            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <div className="card-body">
                            <div className="mb-2">
                                <div className="row">
                                    <div className="col-md-3" ref={ref}>
                                        <Dropdown show={showDropdown}>
                                            <Dropdown.Toggle id="dropdown-basic" className={inputs.category ? 'select-category select-category-active' : 'select-category'} onClick={() => toggleDropdown()}>
                                                {inputs.category ? (<span role="img" aria-label="sheep">🐑 {inputs.category}</span>) : "Choose category"}
                                            </Dropdown.Toggle>

                                            <Dropdown.Menu className="dropdown">
                                                <div>
                                                    <div className="row g-2" style={{justifyContent: 'center'}}>
                                                        <div style={{marginRight: '10px'}} className={inputs.transactionType === 'Expenses' ? 'col-md-3 transaction-type-button transaction-type-button-expenses-active' : 'col-md-3 transaction-type-button'} onClick={changeTransactionType}>
                                                            <div style={{paddingTop: '3px'}}>Expenses</div>
                                                        </div>
                                                        <div style={{marginRight: '10px'}} className={inputs.transactionType === 'Income' ? 'col-md-3 transaction-type-button transaction-type-button-income-active' : 'col-md-3 transaction-type-button'} onClick={changeTransactionType}>
                                                            <div style={{paddingTop: '3px'}}>Income</div>
                                                        </div>
                                                        <div style={{marginRight: '10px'}} className={inputs.transactionType === 'Transfer' ? 'col-md-3 transaction-type-button transaction-type-button-active' : 'col-md-3 transaction-type-button'} onClick={changeTransactionType}>
                                                            <div style={{paddingTop: '3px'}}>Transfer</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div className="category-list-div">
                                                    <ul className="category-list">
                                                        {visibleCategories.map((category) => {
                                                            return <li onClick={() => chooseCategory(category)} key={category.name}><span style={{marginRight: '10px'}}>&#128540;</span> {category.name}</li>
                                                        })}
                                                    </ul>
                                                </div>
                                            </Dropdown.Menu>
                                        </Dropdown>
                                    </div>

                                    <div className="col-md-2">
                                        <div className="mb-3 input-group">
                                            <Flatpickr
                                                name="generatedAt"
                                                placeholder="Choose generate invoice date"
                                                options={{dateFormat: 'd-m-Y'}}
                                                onChange={date => console.log(date)}
                                                className="form-control"
                                                style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5, backgroundColor: '#fff'}}
                                            />
                                        </div>
                                    </div>

                                    <div className="col-md-2">
                                        <div className="form-group">
                                            <input name="invoiceNumber" placeholder="Enter invoice number..." type="text"
                                                   className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   onChange={() => console.log('fix me')}
                                            />
                                        </div>
                                    </div>

                                    <div className="col-md-2">
                                        <div className="form-group">
                                            <AsyncSelect
                                                name="sellerId"
                                                loadOptions={companiesOptions}
                                                defaultOptions
                                                placeholder={'Choose seller'}
                                                style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                onChange={() => console.log('fix me')}
                                            />
                                        </div>
                                    </div>

                                    <div className="col-md-3">
                                        <div className="form-group input-group">
                                            <input
                                                name="price"
                                                type="number"
                                                step="0.01"
                                                className="form-control"
                                                placeholder="Invoice product price"
                                                style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                value='0.0'
                                                onChange={() => console.log('fix me')}
                                            />
                                            <Select
                                                name="sellerId"
                                                options={[{value: 'PLN', label: 'PLN'}]}
                                                defaultValue={{value: 'PLN', label: 'PLN'}}
                                                defaultOptions
                                                placeholder={'Currency'}
                                                styles={currencySelectStyles}
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div className="row">
                                    <div className="col-md-2 offset-7">
                                        <div className="form-group">
                                            <AsyncSelect
                                                name="sellerId"
                                                loadOptions={companiesOptions}
                                                defaultOptions
                                                placeholder={'Choose seller'}
                                                style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                onChange={() => console.log('fix me')}
                                            />
                                        </div>
                                    </div>
                                    <div className="col-md-2">
                                        <div className="form-group">
                                            <AsyncSelect
                                                name="sellerId"
                                                loadOptions={companiesOptions}
                                                defaultOptions
                                                placeholder={'Choose seller'}
                                                style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                onChange={() => console.log('fix me')}
                                            />
                                        </div>
                                    </div>

                                    <div className="col-md-1">
                                        <button
                                            type="button"
                                            className="inner btn btn-success"
                                            style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5, width: '100%'}}
                                            onClick={() => console.log('fix me')}
                                        >
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export {Dashboard};