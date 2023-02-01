import React, { Component } from 'react';
import TopNav from './TopNav';
import { Link, Outlet } from "react-router-dom";
import Header from './Header'
import './layout.css';



export default class Layout extends Component {
  render() {
    return (
      <>
        <TopNav />
        <Outlet />
        <footer>
          <h3>
            <Link style={{ textDecoration: 'none', color: 'white' }} to="super">Super Admin</Link>
          </h3>
        </footer>
      </>
    )
  }
}
