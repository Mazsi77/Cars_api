import React from 'react'
import { Link as RouterLink } from 'react-router-dom';
import {Link as MaterialLink, Box, Toolbar, AppBar, Button } from '@mui/material';


export const Header = () => {
    return (
        <nav>
            <Box sx={{ flexGrow: 1 }}>
            <AppBar position="static" style={{marginBottom: 10}}>
                <Toolbar sx={{maxWidth : 1200, margin: 'auto'}}>
                    <MaterialLink component={RouterLink} underline="hover" padding="10px" to='/brands'>Brands</MaterialLink>
                    <MaterialLink component={RouterLink} underline="hover" padding="10px" to='/models'>Models</MaterialLink>
                </Toolbar>
            </AppBar>
            </Box>
      </nav>
    )
}
