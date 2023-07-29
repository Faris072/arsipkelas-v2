<template>
    <div>
        <header id="header" class="fixed-top ">
            <div class="container d-flex align-items-center">

                <h1 class="logo me-auto"><router-link to="/">Arsha</router-link></h1>
                <!-- Uncomment below if you prefer to use an image logo -->
                <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

                <nav id="navbar" class="navbar">
                    <ul>
                        <li><router-link class="nav-link scrollto" to="/#hero">Home</router-link></li>
                        <li><router-link class="nav-link scrollto" to="/#about">About</router-link></li>
                        <li><router-link class="nav-link scrollto" to="/#services">Services</router-link></li>
                        <li><router-link class="nav-link scrollto" to="/#portfolio">Portfolio</router-link></li>
                        <li><router-link class="nav-link scrollto" to="/#team">Team</router-link></li>
                        <li><router-link :class="`nav-link scrollto ${$route?.name == 'blog' ? 'active' : ''}`" to="/blog">Blog</router-link></li>
                        <li><router-link class="nav-link scrollto" to="/#contact">Contact</router-link></li>
                        <li><router-link class="getstarted scrollto" to="/#about">Get Started</router-link></li>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav><!-- .navbar -->

            </div>
        </header><!-- End Header -->
    </div>
</template>

<script>
    export default {
        mounted(){
            let that = this;
            let navbarlinks = this.select('#navbar .scrollto', true);
            let position = window.scrollY + 200;
            navbarlinks.forEach(navbarlink => {
                if (!navbarlink.hash) return
                let section = that.select(navbarlink.hash)
                if (!section) return
                if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
                    navbarlink.classList.add('active')
                } else {
                    navbarlink.classList.remove('active')
                }
            })
        },
        methods: {
            select(el, all = false){
                el = el.trim()
                if (all) {
                return [...document.querySelectorAll(el)]
                } else {
                return document.querySelector(el)
                }
            }
        }
    }
</script>
