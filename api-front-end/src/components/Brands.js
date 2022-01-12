import React from 'react'
import axios from "axios";
import {useEffect, useState} from "react";
import {Button, Container} from '@mui/material';
import { DataGrid } from '@mui/x-data-grid';
import { makeStyles } from '@mui/styles';
import ModelCard from './ModelCard';

const client = axios.create({
    baseURL: "http://127.0.0.1:8000/api/brands" 
  });

const columns = [
    { field: 'id', headerName: 'ID', },
    {
      field: 'name',
      headerName: 'Name',
      editable: true,
    }
];

const useStyles = makeStyles({
    currentBrand: {
        display: 'flex',
        flexDirection: 'row',
        flexWrap: 'wrap',
        height: 200,
        margin: '20px 0',
    },
    imageWrapper: {
        display: 'flex',
        width: '25%',
        minWidth: 100,
        height: 200,
        justifyContent: 'center',
        alignItems: 'center',
        backgroundColor: 'rgba(255, 255, 255, 0.05)',
        '& img' : {
            maxHeight: 200,
            maxWidth: '100%'
        }
    },
    detailsWrapper: {
        textAlign: 'left',
        paddingLeft: 10,
        '& h2' :{
            fontSize: 32
        }
    },
    modelsWrapper: {
        display: 'flex',
        flexDirection: 'row',
        flexWrap: 'wrap',
        gap: '10px'
    }
})

function Brands() {

    const classes = useStyles();

    const [brands, setBrands] = useState(null);
    const [currentId, setCurrentId] = useState(null);
    const [currentBrand, setCurrentBrand] = useState(null)

    useEffect(() => {
        async function getBrands() {
          const response = await client.get();
          setBrands(response.data);
        }
        getBrands();
    }, []);

    useEffect(() => {
        if(currentId){
        async function getBrand() {
          const response = await client.get('/' + currentId);
          setCurrentBrand(response.data);
        }
        getBrand();
    }
    }, [currentId]);



    return (
        !brands ? <h2>No brands</h2> : 
            brands['success']?
            <Container >
                <div style={{ display: 'flex', height: '300px' }}>
                    <div style={{ flexGrow: 1 }}>
                        <DataGrid columns={columns} rows={brands['brands']} pagination onRowClick={(row) =>{
                            setCurrentId(row['id']);
                        }}/>
                    </div>
                </div>
                {currentBrand !=null ?
                    <div>
                        <div className={classes.currentBrand}>
                            <div className={classes.imageWrapper}>
                                <img src={currentBrand.logo} alt="Company logo"/>
                            </div>
                            <div className={classes.detailsWrapper}>
                                <h2>{currentBrand.name}</h2>
                                <p>Country: <b>{currentBrand.country}</b></p>
                                <p>Number of models: <b>{currentBrand['number_of_models']}</b></p>
                            </div>
                        </div>
                        <div className={classes.modelsWrapper}>
                            {
                                currentBrand['models'].map(model => {
                                    return <ModelCard key={model.id} modelId={model.id} />
                                })
                            }
                        </div>
                    </div>
                    :
                    <h2>Select a brand</h2>
                }
            </Container>
        :
            <h2>No brands</h2>
    )
}

export default Brands
