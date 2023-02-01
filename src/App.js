// import './App.css';
import { Route, BrowserRouter, Routes } from 'react-router-dom';
import Layout from './components/Layout';
import Home from './components/Home';
import About from './components/About';
import Contact from './components/Contact';
import Login from './components/login';
import StudentPanel from './components/student-panel';
import SchoolAdmin from './components/school-admin';
import BusinessOwner from './components/Business-owner';
import SuperAdmin from './components/super-admin';
import Register from './components/register';
import Chat from './components/chat';
import Services from './components/services';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route index element={<Home />} />
          <Route path="about" element={<About />} />
          <Route path="services" element={<Services />} />
          <Route path="contact" element={<Contact />} />
          <Route path="login" element={<Login />} />
          <Route path="register" element={<Register />} />
          <Route path="student/:id" element={<StudentPanel />} />
          <Route path="school/:id" element={<SchoolAdmin />} />
          <Route path="business/:id" element={<BusinessOwner />} />
          <Route path="super/:id" element={<SuperAdmin />} />
          <Route path="chat" element={<Chat />} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;
