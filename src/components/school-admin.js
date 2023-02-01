import React, { useEffect, useState } from 'react'
import { useHistory, useParams } from "react-router-dom";
import { Link } from 'react-router-dom';

function SchoolAdmin(props) {

    const [clubs, setClubs] = useState([]);
    const [students, setStudents] = useState([]);
    const params = useParams();
    const [sellers, setSellers] = useState([]);
    const [name, setName] = useState("");
    function addclub() {
        const requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            mode: 'cors',
            body: JSON.stringify({ id: params.id, cname: name })
        };
        fetch('/api/add-club.php', requestOptions)
            .then(response => response.json())
            .then(data2 => {
                console.log(data2);
                setClubs(data2.allclubs);

            });
    }
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
            });
    }
    function deleteclub(cid) {
        const requestOptions = {
            method: 'POST',
            mode: 'cors',
            body: JSON.stringify({ cid: cid, id: params.id })
        };
        fetch('/api/delete-club.php', requestOptions)
            .then(response => response.json())
            .then(data2 => {
                console.log(data2);
                setClubs(data2.clubs);

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
        fetch('/api/school-admin.php', requestOptions)
            .then(response => response.json())
            .then(data => {

                setClubs(data.clubs);
                setStudents(data.students);
                setSellers(data.sellers);
            });
    }, [])

    return (
        <main>
            <div style={{ display: 'flex', justifyContent: 'end' }}>
                <Link to="/register" style={{ margin: '10px' }}>Add Student/Business owner</Link>
                <Link to="/login" style={{ margin: '10px' }}>Logout</Link>
            </div>
            <h2 style={{ margin: '20px' }}>Welcome:</h2>


            {/* <!-- CLUBS --> */}
            <h3>Clubs ({clubs.length})</h3>
            <div class="grid">
                {
                    clubs.map((club => <div class="box">
                        <h4>{club.name}</h4>
                        <p>created by: {club.creator}</p>
                        <p>department: {club.department}</p>
                        <button onClick={() => deleteclub(club.id)}>Delete</button>
                    </div>))
                }
            </div>

            <h4>Add Clubs</h4>
            <div class="box">
                <h4>Enter Club name</h4>
                <input onChange={(e) => setName(e.target.value)} type="text" name="name1" placeholder="club name"></input>
                <button onClick={() => addclub()}>Add</button>
            </div>

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
        </main >
    )
}

export default SchoolAdmin