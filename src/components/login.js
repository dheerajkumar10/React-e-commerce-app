import React, { Component } from 'react'
import { Link, useNavigate } from 'react-router-dom'


const withRouter = (Component) => {
  const Wrapper = (props) => {
    const navigate = useNavigate();

    return (
      <Component
        navigate={navigate}
        {...props}
      />
    );
  };

  return Wrapper;
};

class Login extends Component {
  constructor(props) {
    super(props);
    this.state = {
      isLogedIn: false,
      path: "/login",
      email: "",
      password: ""
    }

    this.handleEmailChange = this.handleEmailChange.bind(this);
    this.handlePasswordChange = this.handlePasswordChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  handleSubmit(event) {
    event.preventDefault();
    // Simple POST request with a JSON body using fetch
    const requestOptions = {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      mode: 'cors',
      body: JSON.stringify({ email: this.state.email, password: this.state.password })
    };
    fetch('/api/login.php', requestOptions)
      .then(res => res.json())
      .then((res) => {
        var path = "/";
        switch (res.user_type) {
          case 1:
            path = "/super/" + res.id;
            break;

          case 2:
            path = "/school/" + res.id;
            break;

          case 3:
            path = "/business/" + res.id;
            break;

          case 4:
            path = "/student/" + res.id;
            break;

          default:
            path = "/";
            break;
        }
        this.props.navigate(path);
      })
      .catch(err => this.props.navigate("/"));
    event.preventDefault();
  }

  handleEmailChange(event) {
    var dt = this.state;
    dt.email = event.target.value;
    this.setState({ dt });
  }

  handlePasswordChange(event) {
    var dt = this.state;
    dt.password = event.target.value;
    this.setState({ dt });
  }

  render() {
    return (
      <main style={{ padding: '10px 100px' }}>
        <h2 style={{ margin: '20px', textAlign: 'center' }}>Login Form</h2>
        <form onSubmit={this.handleSubmit} method='POST'>
          <div className="inputs">
            <label for="name">Email:</label>
            <input type="email" value={this.state.email} onChange={this.handleEmailChange} name="email" id="name" />
          </div>
          <div class="inputs">
            <label htmlFor="email">Password:</label>
            <input type="password" value={this.state.password} onChange={this.handlePasswordChange} name="password" id="email" />
          </div>
          <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <button style={{ border: '2px solid green', padding: '30px', margin: '20px' }} type="submit">Login</button>
          </div>
        </form>
        <Link to='/login'>Forgot password?</Link>
        <br />
        <Link to='/register'>Register instead.</Link>
      </main>
    )
  }
}


export default withRouter(Login);