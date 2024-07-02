
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive navigation bar</title>

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <link rel="stylesheet" href="style.css">

    <style>

@import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap');

*{
    margin:0;
    padding: 0;
    text-decoration: none;
    list-style: none;
    box-sizing: border-box;
}

html{
    overflow-x: hidden;
}

body{
    overflow-x: hidden;
}

header{
    padding: 0 0.6rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #43C6AC;
    background: -webkit-linear-gradient(to right, #0a0400, #0a0400);
    background: linear-gradient(to right, #0a0400, #0a0400);
}

.logo{
    color:white;
    font-size: 1.5rem;
    /* line-height: 80px; */
    font-weight: bold;
    display: flex;
}

.logo h2{
	padding-left: 0.6rem;
	display: flex;
	justify-content: center;
	align-items: center;
    cursor: pointer;
}

.logo img{
    width: 6vw;
	height: 12vh;
	border-radius: 100%;
}

span{
    color: #5bd485;
}

.navbar .ul-list{
    display: flex;
	gap: 2rem;
}

/* .navbar .ul-list li{
    line-height: 80px;
} */

.navbar .ul-list li a{
    color: white;
    font-size: 1.2rem;
    text-transform: uppercase;
    cursor: pointer;
	/* padding: 0.5rem; */
}

.navbar .ul-list li a:hover,a:active{
    color: red;
    font-size: 1.25rem;
}



/* ============ icon button ============= */

.mobile-navbar-btn{
    display: none;
    background: transparent;
    cursor: pointer;
}
.mobile-nav-icon{
    width: 40px;
    height: 40px;
    color: white;
}
.mobile-nav-icon[name="close-outline"]{
    display: none;
}



/* ================= Main section ================= */

main{
    width: 100%;
    height: 80vh;
    background-color: rgb(159, 180, 173);
    display: flex;
    text-align: center;
    align-items: center;
    justify-content: center;
}
main h1{
    font-size: 100px;
}



/* =============== for responsive ============== */

@media (max-width:980px){
    .logo{
        color:white;
        font-size: 1.2rem;
    }
    .navbar .ul-list li a{
        color: white;
        font-size: 15px;
    }
    .logo img{
        height: 10vh;
    }
    main h1{
        font-size: 100px;
    }
}

@media (max-width:860px){
    .mobile-navbar-btn{
        display: block;
        z-index: 999;
    }
    .navbar .ul-list li{
        line-height: 60px;
    }
    .navbar .ul-list li a{
        font-size: 1rem;
    }

    header{
        position: relative;
    }
    .logo img{
        height: 6vh;
    }

    .navbar{
        width: 100%;
        height: 63vh;
        background: black ;
        position: absolute;
        top: 40px;
        left: 0;

        display: flex;
        justify-content: center;
        align-items: center;

        transform: translateX(100%);
        transition: all 0.5s linear;
    }

    .navbar .ul-list{
        flex-direction: column;
        align-items: center;
        gap: 0px;
    }

    .navbar .ul-list li a:hover,a:active{
        color: #5bd485;
        font-size: 1.25rem;
    }

    .active .navbar{
        transform: translateX(0);
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .active .mobile-navbar-btn .mobile-nav-icon[name="close-outline"]{
        display: block;
    }
    .active .mobile-navbar-btn .mobile-nav-icon[name="menu-outline"]{
        display: none;
    }

}


/* Footer Style   */
footer{
	position:absolute;
	bottom: 0%;
	background-color: #0a0400;
	color: whitesmoke;
	height: 8vh;
	width: 100vw;
	display: flex;
	justify-content: center;
	align-items: center;
}

.namelink{
	text-decoration: none;
	font-size: 1rem;
	color: aqua;
}

main {


  background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
    url("https://i.imgur.com/er8DtBW.jpg");
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;


}
    </style>
</head>

<body>

    <header class="header active">

        <label class="logo">
            <img src="https://dunkelbeverage.com/front_assets/img/logo.png" alt="logo image">
			<h2>Dunkel<span> Beverage</span> </h2>
        </label>



        <div class="mobile-navbar-btn">
            <ion-icon name="menu-outline" class="mobile-nav-icon"></ion-icon>
            <ion-icon name="close-outline" class="mobile-nav-icon"></ion-icon>
        </div>
    </header>



    <main>
        <section>


            <h1 ><a style="font-size: 40px;" class="btn btn-danger" href="{{ url('restype') }}">Restaurant Menu</a></h1><br>
            <h1 ><a style="font-size: 40px;" class="btn btn-warning" href="{{ url('bartype') }}">Bar Menu</a></h1>
        </section>
    </main>


    <footer>
		&copy;Copyright © Dunkle Beverage, All Right Reserved. Designed By  &nbsp;<i class="" style="color: #32e10e;"></i> &nbsp; <a href="https://uifstechnologies.com/" class="namelink">Uifs Technlogies</a>
	</footer>


	<script src="https://kit.fontawesome.com/13404514da.js" crossorigin="anonymous"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="app.js"></script>
    <script>

const mobile_nav = document.querySelector(".mobile-navbar-btn");
const nav_header = document.querySelector(".header");

const toogleNavbar =() =>{
    nav_header.classList.toggle("active");
}

mobile_nav.addEventListener("click", () =>toogleNavbar());


    </script>
</body>
</html>
