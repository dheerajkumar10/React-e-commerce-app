import React from 'react'
import { Link } from 'react-router-dom';
import image from './images/image.png'

export default function Home() {
    var style = { margin: '20px' };
    return (
        <main style={{ textAlign: 'center' }}>
            <h2 style={style}>Select Your Role and explore</h2>
            <div id='home' style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>

                <div style={style}>
                    <h3>Are you new to the Platform?</h3>
                    <Link to="register">Click to Register</Link>
                </div>
                <div style={style}>
                    <h3>Do you have an account?</h3>
                    <Link to="login">Click to login</Link>
                </div>
            </div>

            <br />
            <br />
            <img src={image} alt={"logo"} />

            <div style={{ textAlign: 'start', padding: '60px' }}>
                <h2>Mercado Escolar
                </h2>
                <i>Are you a student? we got you covered. advertise your products for others to purchase. select from the list of products and we deliver to your door step,</i>
                <i>You can select club of your choice and interact with other students. Can't find club of your choice? you can create a club that matches your taset</i>
                <br />
                <div>
                    We have all you need . All you need is to place your order
                    Menu doesnt match you need? We got you covered
                    Order for special item outside our menu and we make arrangement for you
                    We have fancy items that match your taste.
                </div>
            </div>
        </main>

    )
}
