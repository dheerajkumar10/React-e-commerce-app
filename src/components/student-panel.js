import React, { useEffect, useState } from 'react'
import { useHistory, useParams } from "react-router-dom";
import { Link } from 'react-router-dom';

function StudentPanel(props) {

    const [clubs, setClubs] = useState([]);
    const [advertisements, setAdvertisements] = useState([]);
    const [products, setProducts] = useState([]);
    const [myproducts, setMyproducts] = useState([]);
    const [myclubs, setmyclubs] = useState([]);
    const [myorders, setmyOrders] = useState([]);
    const params = useParams();
    const [name, setName] = useState("");
    const [quantity, setQuantity] = useState("");
    const [productname, setProductname] = useState("");
    const [productprice, setProductPrice] = useState("");
    const [prodimage, setProdimage] = useState("");
    const [posts, setPosts] = useState([]);
    const [postname, setPostname] = useState([]);
    const [addcontent, setAddcontent] = useState([]);
    const [postimage, setPostimage] = useState([]);

    function cancelorder(oid) {
        const requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            mode: 'cors',
            body: JSON.stringify({ id: params.id, orderid: oid })
        };
        fetch('/api/cancel-order.php', requestOptions)
            .then(response => response.json())
            .then(data1 => {
                setmyOrders(data1.myorders);

            });
    }

    function addposts() {
        const formData = new FormData();
        formData.append('id', params.id);
        formData.append("name", postname);
        formData.append("content", addcontent);
        formData.append("image", postimage);
        const requestOptions = {
            method: 'POST',
            mode: 'cors',
            body: formData
        };
        fetch('/api/add-posts.php', requestOptions)
            .then(response => response.json())
            .then(data2 => {
                setPosts(data2.posts);
            });
    }

    function addproduct() {
        const formData = new FormData();
        formData.append('id', params.id);
        formData.append("name", productname);
        formData.append("price", productprice);
        formData.append("image", prodimage);
        const requestOptions = {
            method: 'POST',
            mode: 'cors',
            body: formData
        };
        fetch('/api/add-product.php', requestOptions)
            .then(response => response.json())
            .then(data2 => {
                setMyproducts(data2.myproducts);
            });
    }
    function updateProduct(pid) {
        const formData = new FormData();
        formData.append('pid', pid);
        formData.append('id', params.id);
        formData.append("name", productname);
        formData.append("price", productprice);
        formData.append("image", prodimage);
        const requestOptions = {
            method: 'POST',
            mode: 'cors',
            body: formData
        };
        fetch('/api/update-product.php', requestOptions)
            .then(response => response.json())
            .then(data2 => {
                console.log(data2);
                setMyproducts(data2.myproducts);
            });
    }


    function deleteproduct(pid) {
        const requestOptions = {
            method: 'POST',
            mode: 'cors',
            body: JSON.stringify({ pid: pid, id: params.id })
        };
        fetch('/api/delete-product.php', requestOptions)
            .then(response => response.json())
            .then(data2 => {
                console.log(data2);
                setMyproducts(data2.products);
            });
    }
    function buyProduct(pid) {
        const requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            mode: 'cors',
            body: JSON.stringify({ id: params.id, quantity: quantity, productid: pid })
        };
        fetch('/api/order-product.php', requestOptions)
            .then(response => response.json())
            .then(data2 => {
                setmyOrders(data2.myorders);
            });
    }


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

    function joinclub(cid) {
        const requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            mode: 'cors',
            body: JSON.stringify({ id: params.id, cid: cid })
        };
        fetch('/api/join-club.php', requestOptions)
            .then(response => response.json())
            .then(data1 => {
                console.log(data1);
                setmyclubs(data1.myclubs);

            });
    }
    function leaveclub(cid) {
        const requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            mode: 'cors',
            body: JSON.stringify({ id: params.id, cid: cid })
        };
        fetch('/api/leave-club.php', requestOptions)
            .then(response => response.json())
            .then(data1 => {
                console.log(data1);
                setmyclubs(data1.myclubs);

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
        fetch('/api/student-panel.php', requestOptions)
            .then(response => response.json())
            .then(data => {
                setClubs(data.allclubs);
                setProducts(data.products);
                setmyclubs(data.myclubs);
                setmyOrders(data.myorders);
                setAdvertisements(data.advertisements);
                setMyproducts(data.myproducts);
                setPosts(data.posts);
            });
    }, [])

    return (
        <main>
            <div style={{ display: 'flex', justifyContent: 'end' }}>
                <Link to="/register" style={{ margin: '10px' }}>Register</Link>
                <Link to="/login" style={{ margin: '10px' }}>Login</Link>
                <Link style={{ margin: '10px' }} to="/chat">Chat</Link>
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
                        <button onClick={() => joinclub(club.id)}>Join</button>
                    </div>))
                }
            </div>

            <h3>My Clubs ({myclubs.length})</h3>
            <div class="grid">
                {
                    myclubs.map((mclub => <div class="box">
                        <h4>{mclub.cname}</h4>
                        <p>created by: {mclub.name}</p>
                        <button onClick={() => leaveclub(mclub.clubid)}>Leave</button>
                    </div>))
                }
            </div>
            <h4>Add Clubs</h4>
            <div class="box">
                <h4>Enter Club name</h4>
                <input onChange={(e) => setName(e.target.value)} type="text" name="name1" placeholder="club name"></input>
                <button onClick={() => addclub()}>Add</button>
            </div>

            <h4>Add Products</h4>
            <div class="box">
                <input onChange={(e) => setProductname(e.target.value)} type="text" name="pname" placeholder='product name'></input>
                <input onChange={(e) => setProductPrice(e.target.value)} type="number" name="price" placeholder='price'></input>
                <input onChange={(e) => setProdimage(e.target.files[0])} type="file" name='file'></input>
                <button onClick={() => addproduct()}>Add</button>
            </div>


            {/* Products */}
            <h3>Products ({products.length})</h3>
            <div class="grid">
                {products.map(product => <div class="box">
                    <img src={`data:image/jpg;charset=utf8;base64,${product.image}`} height={"150px"} width={"150px"}></img>
                    <h4>{product.name}</h4>
                    <p>seller: {product.seller}</p>
                    <p>Price: {product.price}</p>
                    <p>Dept.: {product.department}</p>
                    <input onChange={(e) => setQuantity(e.target.value)} type="number" name="quantity" placeholder="quantity"></input>
                    <button onClick={() => buyProduct(product.id)}>Buy</button>
                </div>
                )}

            </div>
            {/* My Products */}
            <h3>My Products ({myproducts.length})</h3>
            <div class="grid">
                {myproducts.map(product => <div class="box">
                    <img src={`data:image/jpg;charset=utf8;base64,${product.image}`} height={"150px"} width={"150px"}></img>
                    <h4>{product.name}</h4>
                    <p>seller: {product.seller}</p>
                    <p>Price: {product.price}</p>
                    <p>Dept.: {product.department}</p>
                    <h4>Manage</h4>
                    <div >
                        <input onChange={(e) => setProductname(e.target.value)} type="text" name="pname" placeholder='product name'></input>
                        <input onChange={(e) => setProductPrice(e.target.value)} type="number" name="price" placeholder='price'></input>
                        <input onChange={(e) => setProdimage(e.target.files[0])} type="file" name='file'></input>
                        <button onClick={() => updateProduct(product.id)}>update</button>
                    </div>
                    <h4>Delete Product</h4>
                    <button onClick={() => deleteproduct(product.id)}>Delete</button>
                </div>
                )}

            </div>
            <h3>My Orders</h3>
            <table>
                <thead>
                    <tr>
                        <td>Product Name</td>
                        <td>Quantity</td>
                        <td>Price</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    {myorders.map(order => <tr>
                        <td>{order.name}</td>
                        <td>{order.quantity}</td>
                        <td>{order.price}</td>
                        <td><button onClick={() => cancelorder(order.id)}>cancel</button></td>
                    </tr>)}
                </tbody>
            </table>
            {/* Advertisements*/}
            <h3>Advertisements ({advertisements.length})</h3>
            <div class="grid">
                {
                    advertisements.map((advertisement => <div class="box">
                        <h4>{advertisement.title}</h4>
                        <p> {advertisement.name}</p>
                        <p> {advertisement.content}</p>
                    </div>))
                }
            </div>

            <h4>Add Posts</h4>
            <div class="box" style={{ width: 'auto', height: '200px' }}>
                <input style={{ float: 'left' }} onChange={(e) => setPostname(e.target.value)} type="text" name="aname" placeholder='add title'></input>
                <textarea style={{ float: 'left', clear: 'both', margin: '10px 0px' }}
                    onChange={(e) => setAddcontent(e.target.value)} name="content" cols="80" placeholder='content' ></textarea>
                <input style={{ float: 'left', clear: 'both' }} onChange={(e) => setPostimage(e.target.files[0])} type="file" name='file'></input>
                <button style={{ float: 'left', clear: 'both', marginTop: '4px' }} onClick={() => addposts()}>Add</button>
            </div>

            <h3>Posts ({posts.length})</h3>
            <div class="grid">
                {posts.map(post => <div class="box">
                    <img src={`data:image/jpg;charset=utf8;base64,${post.image}`} height={"150px"} width={"150px"}></img>
                    <h4> {post.content}</h4>
                    <p>author: {post.name}</p>
                </div>
                )}

            </div>
        </main >

    )
}

export default StudentPanel