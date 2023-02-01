import React, { useEffect, useState } from 'react'
import { useHistory, useParams } from "react-router-dom";
import { Link } from 'react-router-dom';

function SuperAdmin(props) {

    const [students, setStudents] = useState([]);
    const params = useParams();
    const [sellers, setSellers] = useState([]);
    const [admins, setAdmins] = useState([]);
    function deleteuser(uid) {
        const requestOptions = {
            method: 'POST',
            mode: 'cors',
            body: JSON.stringify({ uid: uid, id: params.id })
        };
        fetch('/api/delete-user.php', requestOptions)
            .then(response => response.json())
            .then(data2 => {
                console.log(data2);
                setStudents(data2.students);
                setSellers(data2.sellers);
                setAdmins(data2.school_admins);
            });
    }
    //useffect
    useEffect(() => {
        const requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            mode: 'cors',
            body: JSON.stringify({ id: params.id })
        };
        fetch('/api/super-admin.php', requestOptions)
            .then(response => response.json())
            .then(data => {

                setStudents(data.students);
                setSellers(data.business_owners);
                setAdmins(data.school_admins);
            });
    }, [])

    return (
        <main>
            <div style={{ display: 'flex', justifyContent: 'end' }}>
                <Link to="/register" style={{ margin: '10px' }}>Add User</Link>
                <Link to="/login" style={{ margin: '10px' }}>logout</Link>
                <a style={{ margin: '10px' }} href='/api/dashboard.php'>Dashboard</a>
            </div>
            <h2 style={{ margin: '20px' }}>Welcome:</h2>

            {/* <!-- STUDENTS --> */}
            <h3>Students ({students.length})</h3>
            <div class="grid">
                {
                    students.map((student => <div class="box">
                        <h4>{student.name}</h4>
                        <p>department: {student.department}</p>
                        <button onClick={() => deleteuser(student.id)}>Delete</button>
                    </div>))
                }
            </div>
            {/* <!-- SELLERS --> */}
            <h3>Business Owners ({sellers.length})</h3>
            <div class="grid">
                {
                    sellers.map((seller => <div class="box">
                        <h4>{seller.id}</h4>
                        <h4>{seller.name}</h4>
                        <button onClick={() => deleteuser(seller.id)}>Delete</button>
                    </div>))
                }

            </div>
            {/* <!-- ADMINS --> */}
            <h3>School Admins ({admins.length})</h3>
            <div class="grid">
                {
                    admins.map((admin => <div class="box">
                        <h4>{admin.id}</h4>
                        <h4>{admin.name}</h4>
                        <button onClick={() => deleteuser(admin.id)}>Delete</button>
                    </div>))
                }
            </div>
        </main >
    )
}

export default SuperAdmin