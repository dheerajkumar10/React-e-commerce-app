import React, { Component } from 'react'

export default class Contact extends Component {

    handleChange = e => {
        console.log(e.target.value);
    }

  render() {
    return (
        <main style={{padding: '10px 100px'}}>
        <h2 style={{margin: '20px', textAlign: 'center'}}>About Mercado Escolar</h2>

        <div class="inputs">
            <label for="name">Your Name:</label>
            <input onChange={this.handleChange} type="text" name="name" id="name"/>
        </div>
        <div class="inputs">
            <label for="email">Email:</label>
            <input onChange={this.handleChange} type="email" name="email" id="email"/>
        </div>
        <div class="inputs">
            <label for="subject">Subject:</label>
            <input onChange={this.handleChange} type="text" name="subject" id="subject"/>
        </div>
        <div class="inputs">
            <label for="complain">Complain:</label>
            <input onChange={this.handleChange} type="text" name="complain" id="complain"/>
        </div>

        <div style={{display: 'flex' ,alignItems: 'center', justifyContent: 'center'}}>
            <button style={{border: '2px solid green', padding: '30px', margin: '20px'}} type="submit">Submit</button>
            <button style={{border: '2px solid green', padding: '30px', margin: '20px'}} type="submit">Cancel</button>
        </div>



    </main>

    )
  }
}
