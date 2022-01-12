import React from 'react'
import { Link as RouterLink } from 'react-router-dom';
import {Link as MaterialLink, Box, Toolbar, AppBar, Button } from '@mui/material';


export const Header = () => {
    return (
        <nav>
            <Box sx={{ flexGrow: 1 }}>
            <AppBar position="static">
                <Toolbar sx={{maxWidth : 1200, margin: 'auto'}}>
                    <MaterialLink component={RouterLink} to='/brands'>Brands</MaterialLink>
                    <MaterialLink component={RouterLink} to='/models'>Models</MaterialLink>
                </Toolbar>
            </AppBar>
            </Box>
      </nav>
    )
}
