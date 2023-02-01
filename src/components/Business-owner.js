import React, { useEffect, useState } from 'react'
import { useHistory, useParams } from "react-router-dom";
import { Link } from 'react-router-dom';

function BusinessOwner(props) {

    const [products, setProducts] = useState([]);
    const [orders, setOrders] = useState([]);
    const params = useParams();
    const [productname, setProductname] = useState("");
    const [productprice, setProductPrice] = useState("");
    const [prodimage, setProdimage] = useState("");
    const [advertisements, setAdvertisements] = useState([]);
    const [addname, setAddname] = useState([]);
    const [addcontent, setAddcontent] = useState([]);

    function addadvertisement() {
        const requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            mode: 'cors',
            body: JSON.stringify({ id: params.id, title: addname, content: addcontent })
        };
        fetch('/api/add-advertisements.php', requestOptions)
            .then(response => response.json())
            .then(data2 => {
                console.log(data2);
                setAdvertisements(data2.myadvertisements);

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
                setProducts(data2.myproducts);
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
                setProducts(data2.products);
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
                setProducts(data2.products);
            });
    }

    function deleteadv(aid) {
        console.log(aid)
        const requestOptions = {
            method: 'POST',
            mode: 'cors',
            body: JSON.stringify({ aid: aid, id: params.id })
        };
        fetch('/api/delete-adv.php', requestOptions)
            .then(response => response.json())
            .then(data2 => {
                console.log(data2);
                setAdvertisements(data2.advertisements);
            });
    }

    function cancelorder(oid) {
        console.log(oid);
        const requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            mode: 'cors',
            body: JSON.stringify({ id: params.id, orderid: oid })
        };
        fetch('/api/cancel-order.php', requestOptions)
            .then(response => response.json())
            .then(data1 => {
                console.log(data1.myborders);
                setOrders(data1.myborders);

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
        fetch('/api/business-owner.php', requestOptions)
            .then(response => response.json())
            .then(data => {

                setProducts(data.products);
                setOrders(data.orders);
                setAdvertisements(data.myadvertisements);
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


            <h4>Add Products</h4>
            <div class="box">
                <input onChange={(e) => setProductname(e.target.value)} type="text" name="pname" placeholder='product name'></input>
                <input onChange={(e) => setProductPrice(e.target.value)} type="number" name="price" placeholder='price'></input>
                <input onChange={(e) => setProdimage(e.target.files[0])} type="file" name='file'></input>
                <button onClick={() => addproduct()}>Add</button>
            </div>

            <h3>My Products ({products.length})</h3>
            <div class="grid">
                {products.map(product => <div class="box">
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
                        <td>customer Name</td>
                        <td>Quantity</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    {orders.map(order => <tr>
                        <td>{order.name}</td>
                        <td>{order.buyer}</td>
                        <td>{order.quantity}</td>
                        <td><button onClick={() => cancelorder(order.id)}>cancel</button></td>
                        <td><button onClick={() => cancelorder(order.id)}>deliver</button></td>
                    </tr>)}
                </tbody>
            </table>

            <h4>Add Advertisements</h4>
            <div class="box" style={{ width: 'auto', height: '200px' }}>
                <input style={{ float: 'left' }} onChange={(e) => setAddname(e.target.value)} type="text" name="aname" placeholder='add title'></input>
                <textarea style={{ float: 'left', clear: 'both', margin: '10px 0px' }}
                    onChange={(e) => setAddcontent(e.target.value)} name="content" cols="80" placeholder='content' ></textarea>
                <button style={{ float: 'left', clear: 'both' }} onClick={() => addadvertisement()}>Add</button>
            </div>

            <h3>My Advertisements ({advertisements.length})</h3>
            <div class="grid">
                {
                    advertisements.map((advertisement => <div class="box">
                        <h4>{advertisement.title}</h4>
                        <p> {advertisement.content}</p>
                        <button onClick={() => deleteadv(advertisement.id)} >delete</button>
                    </div>))
                }
            </div>
        </main >
    )
}

export default BusinessOwner