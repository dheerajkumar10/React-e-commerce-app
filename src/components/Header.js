import React from 'react'

export default function Header() {
  return (
    <div id="header" style={{alignItems: 'center', justifyContent: 'center', padding: '50px'}}>
    <div style={{textAlign: 'center'}}>
        <h1>Picnic R U</h1>
        <h4>We Organize you picnic events</h4>
        <input style={{height: '40px', width: '300px'}} type="text" name="search" />
        <button
            style={{height: '40px', width: '100px', backgroundColor: '#353535', border: 'none', color: 'white', fontStyle: 'italic'}}>Search</button>
    </div>
    </div>
  )
}
