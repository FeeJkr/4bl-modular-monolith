import React, {useEffect, useState} from 'react';
import './List.css';
import {useDispatch, useSelector} from "react-redux";
import {invoicesActions} from "../../../actions/invoices.actions";
import {Link} from "react-router-dom";
import {Toast} from "react-bootstrap";
import {filesystemService} from "../../../services/filesystem.service";

function List() {
    const invoices = useSelector(state => state.invoices.all.items);
    const dispatch = useDispatch();
    const [showToast, setShowToast] = useState(false);

    useEffect(() => {
        dispatch(invoicesActions.getAll());
    }, []);

    const handleDelete = (id) => {
        dispatch(invoicesActions.deleteInvoice(id));
        setShowToast(true);
    }

    const handleDownload = (filename, invoiceNumber) => {
        filesystemService.getFile(filename).then(file => {
            const element = document.createElement("a");
            element.href = URL.createObjectURL(file);
            element.download = invoiceNumber + ".pdf";
            document.body.appendChild(element);
            element.click();
        });
    }

    return (
        <div className="container-fluid">
            <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>Invoices</h4>

            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <div className="card-body">
                            <div className="mb-2 row">
                                <div className="col-md-12" style={{textAlign: 'right'}}>
                                    <Link to={'/invoices/generate'} className="button-create-new btn btn-success">
                                        <i className="bi bi-plus"/>
                                        Generate new
                                    </Link>
                                </div>
                            </div>

                            <div>
                                <table className="table align-middle table-nowrap table-check">
                                    <thead className="table-light">
                                    <tr>

                                        <th>ID</th>
                                        <th>Number</th>
                                        <th>Generated Date</th>
                                        <th>Sold Date</th>
                                        <th>Seller</th>
                                        <th>Buyer</th>
                                        <th>Total Net Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table-companies-body">
                                    {invoices && invoices.map(function (invoice, key) {
                                        return (
                                            <tr key={invoice.id}>
                                                <th scope="row">{++key}</th>
                                                <td>{invoice.invoiceNumber}</td>
                                                <td>{invoice.generatedAt}</td>
                                                <td>{invoice.soldAt}</td>
                                                <td>{invoice.seller.name}</td>
                                                <td>{invoice.buyer.name}</td>
                                                <td>{invoice.totalNetPrice} {invoice.currencyCode}</td>
                                                <td>
                                                    <div className="gap-3" style={{display: 'flex', gridGap: '1 rem'}}>
                                                        <a onClick={() => handleDownload(invoice.id, invoice.invoiceNumber)}
                                                           style={{fontSize: '18 px', cursor: 'pointer'}}>
                                                            <i className="bi bi-download"
                                                               style={{fontSize: '18 px'}}
                                                            />
                                                        </a>
                                                        <Link to={'/invoices/edit/' + invoice.id}>
                                                            <i className="bi bi-pencil"
                                                                style={{color: '#34c38f', fontSize: '18 px'}}
                                                            />
                                                        </Link>
                                                        <a onClick={() => handleDelete(invoice.id)}
                                                              style={{color: '#f46a6a', fontSize: '18 px', cursor: 'pointer'}}>
                                                            <i className="bi bi-trash"
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
            <Toast style={{position: 'absolute', bottom: 80, right: 20, backgroundColor: '#00ca72'}}
                   onClose={() => setShowToast(false)}
                   show={showToast}
                   delay={5000}
                   autohide
            >
                <Toast.Header closeButton={false} style={{backgroundColor: '#00ca72', borderBottom: 0}}>
                    <strong className="me-auto" style={{color: '#fff'}}>Success!</strong>
                </Toast.Header>
                <Toast.Body style={{color: '#fff'}}>
                    Invoice was successfully deleted.
                </Toast.Body>
            </Toast>
        </div>
    );
}

export {List};