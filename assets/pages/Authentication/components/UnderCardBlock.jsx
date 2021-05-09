import {Link} from "react-router-dom";
import React from "react";
import '../assets/css/UnderCardBlock.css';

export default function UnderCardBlock(props) {
    const {message, link} = props;

    return (
        <div className="mt-5 text-center d-block">
            <p className="d-block">
                <span className="font-weight-300"> {message} </span>
                <Link to={link.pathname} className="link">
                    {link.label}
                </Link>
            </p>
        </div>
    );
}