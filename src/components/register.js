import React, { Component } from 'react'

export default class Register extends Component {
    render() {
        return (
            <main style={{ padding: '10px 100px' }}>
                <h2 style={{ margin: '20px', textAlign: 'center' }}>Register</h2>


                <form method='post' action='/api/register.php'>

                    <div class="inputs">
                        <label for="name">Your Name:</label>
                        <input type="text" name="name" id="name" />
                    </div>
                    <div class="inputs">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" />
                    </div>
                    <div class="inputs">
                        <label for="phone">Phone Number:</label>
                        <input type="text" name="phone" id="phone" />
                    </div>
                    <div class="inputs">
                        <label for="address">Address:</label>
                        <input type="address" name="address" id="address" />
                    </div>
                    <div class="inputs">
                        <label for="department">Department:</label>
                        <input type="text" name="department" id="department" />
                    </div>
                    <div class="inputs">
                        <label for="user_type">Role:</label>
                        <select name="user_type" id="user_type">
                            <option value="4">Student</option>
                            <option value="3">Business Owner</option>
                            <option value="2">School Admin</option>
                            <option value="1">Super Admin</option>
                        </select>
                    </div>
                    <div class="inputs">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" />
                    </div>

                    <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                        <button style={{ border: '2px solid green', padding: '30px', margin: '20px' }} type="submit">Submit</button>
                        <button style={{ border: '2px solid green', padding: '30px', margin: '20px' }} type="submit">Cancel</button>
                    </div>
                </form>
            </main>
        )
    }
}
