import React from "react";
import ErrorOutlineRoundedIcon from "@material-ui/icons/ErrorOutlineRounded";
import CheckCircleOutlineIcon from "@material-ui/icons/CheckCircleOutline";
import '../assets/css/Alert.css';

export default function Alert(props) {
    const {type, message} = props;
    let className = 'alert alert-root';

    if (type === 'error') {
        className += ' alert-danger';
    } else if (type === 'success') {
        className += ' alert-success';
    }

    return (
        <div className={className} role="alert">
            {type === 'error' && <ErrorOutlineRoundedIcon className="alert-icon alert-icon-danger"/>}
            {type === 'success' && <CheckCircleOutlineIcon className="alert-icon alert-icon-success"/>}
            {message}
        </div>
    );
}