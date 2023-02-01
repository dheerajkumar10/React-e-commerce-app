import React from 'react';
import { BrowserRouter as Router, Route, Link, Switch } from 'react-router-dom';
import products from './images/products.png';
import clubs from './images/clubs.jpg';
import posts from './images/posts2.jpg';
import adv from './images/adv.png';

class Services extends React.Component {
    render() {
        return (
            <React.Fragment>
                {/*<!-- Wrapper -->*/}
                <div id="wrapper">
                    <section id="banner-sub">
                        <div class="inner">
                            <header class="major">
                                <h1>Services</h1>
                            </header>
                        </div>
                    </section>
                    {/* <!-- Main --> */}
                    <div id="main">
                        { /* <!-- One --> */}
                        <section id="one" class="spotlights">
                            <section>
                                <img class="image" src={products} alt="about-us" data-position="center center" height={'500px'} width={'1000px'} />
                                <div class="content">
                                    <div class="inner">
                                        <header class="major">
                                            <h3>Products</h3>
                                        </header>
                                        <p>Students can sell their products and buy them from other students and business owners. </p>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <img class="image" src={adv} alt="" data-position="top center" height={'500px'} width={'1000px'} />
                                <div class="content">
                                    <div class="inner">
                                        <header class="major">
                                            <h3>Advertisements</h3>
                                        </header>
                                        <p>Students can view all the advertisements and get the best offers. Business Owners can post advertisements</p>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <img class="image" src={clubs} alt="" data-position="25% 25%" height={'500px'} width={'1000px'} />
                                <div class="content">
                                    <div class="inner">
                                        <header class="major">
                                            <h3>Clubs</h3>
                                        </header>
                                        <p>Join Clubs and unleash other intrests and make new connections</p>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <img class="image" src={posts} alt="about-us" data-position="center center" height={'500px'} width={'1000px'} />
                                <div class="content">
                                    <div class="inner">
                                        <header class="major">
                                            <h3>Posts</h3>
                                        </header>
                                        <p>Post gives all the details of new activites in the campus and student can express what he feels he can post pictures and updates </p>
                                    </div>
                                </div>
                            </section>
                        </section>
                    </div>
                </div>
            </React.Fragment>
        )
    }
}
export default Services;
