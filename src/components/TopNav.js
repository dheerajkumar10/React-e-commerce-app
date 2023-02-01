import React, { Component } from 'react'
import { Link } from 'react-router-dom'


export default class TopNav extends Component {
  styles = { margin: '10px', color: 'white', textDecoration: 'none', fontWeight: '600', fontSize: '16px' };

  render() {
    return (
      <header>
        <div id="header" style={{ backgroundColor: '#9c9c9c' }}>
          <h3>Mercado Escolar</h3>
          <div style={{ alignSelf: 'end' }}>
            <Link style={this.styles} to="/">Home</Link>
            <Link style={this.styles} to="about">About</Link>
            <Link style={this.styles} to="services">Services</Link>
            <a style={this.styles} href="https://blog.hxm7426.uta.cloud/">Blog</a>
            <Link style={this.styles} to="contact">Contact</Link>
            <Link style={this.styles} to="login">Login</Link>
          </div>
        </div>
      </header>
    )
  }
}
