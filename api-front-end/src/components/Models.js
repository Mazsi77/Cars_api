import React from 'react'
import {useEffect, useState} from "react";
import { makeStyles } from '@mui/styles';
import axios from "axios";
import ModelCard from './ModelCard';
import { Container } from '@mui/material';

const client = axios.create({
    baseURL: "http://127.0.0.1:8000/api/models" 
});

const useStyles = makeStyles({
    modelsWrapper: {
        paddingTop: 30,
        display: 'flex',
        flexDirection: 'row',
        flexWrap: 'wrap',
        justifyContent: 'center',
        gap: '10px'
    }
})

export const Models = () => {
    const [models, setModels] = useState(null);
    const classes = useStyles();

    useEffect(() => {
        
        async function getModels() {
          const response = await client.get();
          setModels(response.data);
        }
        getModels();
    }, []);

    if(!models) return <>No models</>;

    return (
        <Container >
            <div className={classes.modelsWrapper}>
                {
                    models['models'].map(model => {
                        return <ModelCard key={model.id} modelId={model.id} />
                    })
                }
            </div>
        </Container>
    )
}
