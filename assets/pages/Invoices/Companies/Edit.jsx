import React from 'react';
import {useParams} from 'react-router-dom';

function Edit() {
    let {id} = useParams();

    return (<h1>Edit {id}</h1>);
}

export {Edit};