import axios from "axios";
import {useEffect, useState} from "react";
import {Button, Container} from '@mui/material';
import { DataGrid } from '@mui/x-data-grid';
import { makeStyles } from '@mui/styles';
import ModelCard from './ModelCard';

const client = axios.create({
    baseURL: "http://127.0.0.1:8000/api/brands" 
  });

export const Create = () => {
    return (
        <div>
            
        </div>
    )
}
