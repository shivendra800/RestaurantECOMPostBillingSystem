<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menu List</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500&family=Petemoss&display=swap");

        * {
            box-sizing: border-box;
            font-family: "Cinzel", serif;
        }

        body {
            margin: 0;
            padding: 0;
          
        }



        main {
            display: flex;
            justify-content: center;
            background-color: #d9d9d9;
             text-align:center;
            font-size: 2.5em;
            font-style: italic;
        }

        .book {
            --book-height: 100vh;
            --book-ratio: 1.4;
        }

        .book>div {
            height: var(--book-height);
            width: calc(var(--book-height) / var(--book-ratio));
            overflow: auto;
            background-color: #0a0a0a;
            transform: scale(0.9);
            border-radius: 6px;
            transform-origin: left;
            justify-content: center;
        }

        .book-cover {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            z-index: 9;
            text-align: center;
            background: linear-gradient(135deg, black 25%, transparent 25%) -50px 0,
                linear-gradient(225deg, black 25%, transparent 25%) -50px 0,
                linear-gradient(315deg, black 25%, transparent 25%),
                linear-gradient(45deg, black 25%, transparent 25%);
            background-size: 2em 2em;
            background-color: #232323;
            color: white;
            transition: transform 2s;
        }

        .book-cover::before {
            content: "";
            position: absolute;
            width: 20px;
            right: 20px;
            top: 0;
            bottom: 0;
            background-color: #b11509;
        }

        h1 {
            font-family: "Petemoss", cursive;
            font-size: 98px;
            font-weight: 300;
            color: #dbd75d;
        }

        h2 {
            font-size: 16px;
        }

        .separator {
            --separator-size: 8px;
            width: var(--separator-size);
            height: var(--separator-size);
            background-color: #dbd75d;
            margin: 50px auto 60px auto;
            border-radius: 50%;
            position: relative;
        }

        .separator::after,
        .separator::before {
            content: "";
            position: absolute;
            width: 12px;
            background-color: white;
            height: 2px;
            top: calc(50% - 1px);
        }

        .separator::after {
            left: 15px;
        }

        .separator::before {
            right: 15px;
        }

        .book-content {
            transform: scale(0.9) translateY(30px);
            background-color: white !important;
            transition: all 0.3s 1s;
        }

        .book-content h3,
        .book-content p {
            opacity: 0;
            transition: all 0.3s 0.3s;
        }

        h3 {
            padding: 30px;
        }

        p {
            padding: 0px 30px 10px 30px;
            text-align: justify;
            font-size: 14px;
        }

        .book-cover>div {
            transition: opacity 0s 0.6s;
        }

        .book:hover>.book-cover {
            transform: rotateY(180deg) scale(0.9);
        }

        .book:hover>.book-cover>div {
            opacity: 0;
        }

        .book:hover>.book-content {
            transform: scale(0.9) translateY(0px);
        }

        .book:hover>.book-content h3,
        .book:hover>.book-content p {
            opacity: 1;
        }

        h1 {
            background-image: linear-gradient(to right, #ee00ff 0%, #fbff00 100%);
            color: transparent;
            -webkit-background-clip: text;
            text-align: center;
            font-size: 60px;
        }

        img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        h2 {
            background-image: linear-gradient(to right, #ee00ff 0%, #fbff00 100%);
            color: transparent;
            -webkit-background-clip: text;
            text-align: center;
            font-size: 40px;
            font-family: 'Times New Roman', Times, serif;
        }

        ul {
            font-size: 30px;
            color: hsl(244, 93%, 77%)
        }

        a:link {
            color: #fff;
            font-size: 20px;
            text-decoration: none;
        }

        a:hover {
            color: #4e54c8;
        }

        a:active {
            color: rgb(0, 0, 0);
        }

        h3 {
            font-size: 30px;
            text-align: center;
            color: #fff;
            font-family: 'Caveat', cursive;
        }

        .credit a {
            text-decoration: none;
            color: #fff;
            font-weight: 800;
        }

        .credit {
            color: #fff;
            text-align: center;
            margin-top: 10px;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        @media only screen and (max-width: 860px) {
            h1 {
                font-size: 38px;
            }

            .menu-card-container {
                margin: 20px 5%;
                width: 80%;
            }
        }

        @media only screen and (max-width: 600px) {
            h1 {
                font-size: 28px;
            }

            .menu-card-container {
                margin: 20px 1%;
                width: 88%;
            }

            ul {
                font-size: 20px;
                color: #8f94fb
            }

            h2 {
                font-size: 18px;
            }

            h3 {
                font-size: 18px;
            }
        }

        /* new csss   --------------------------------------------------------------------------------------------------------------------------------------------*/
        .menu-card-container {
            /* margin: 20px 15%; */
            /* width: 100%; */
            background: #000000;
            background: -webkit-linear-gradient(to right, #434343, #000000);
            background: linear-gradient(to right, #434343, #000000);
            /* padding:5%;
    border-radius: 40px; */
        }


        h1 {
            background-image: linear-gradient(to right, #ee00ff 0%, #fbff00 100%);
            color: transparent;
            -webkit-background-clip: text;
            text-align: center;
            font-size: 60px;
        }

        img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        h2 {
            background-image: linear-gradient(to right, #ee00ff 0%, #fbff00 100%);
            color: transparent;
            -webkit-background-clip: text;
            text-align: center;
            font-size: 40px;
            font-family: 'Times New Roman', Times, serif;
        }

        ul {
            font-size: 20px;
            color: #8f94fb
        }

        a:link {
            color: #fff;
            font-size: 20px;
            text-decoration: none;
        }

        a:hover {
            color: #4e54c8;
        }

        a:active {
            color: rgb(0, 0, 0);
        }

        h3 {
            font-size: 30px;
            text-align: center;
            color: #fff;
            font-family: 'Caveat', cursive;
        }

        .credit a {
            text-decoration: none;
            color: #fff;
            font-weight: 800;
        }

        .credit {
            color: #fff;
            text-align: center;
            margin-top: 10px;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        @media only screen and (max-width: 860px) {
            h1 {
                font-size: 38px;
            }

            .menu-card-container {
                margin: 20px 5%;
                width: 80%;
            }
        }

        @media only screen and (max-width: 600px) {
            h1 {
                font-size: 28px;
            }

            .menu-card-container {
                margin: 20px 1%;
                width: 88%;
            }

            ul {
                font-size: 20px;
                color: #8f94fb
            }

            h2 {
                font-size: 18px;
            }

            h3 {
                font-size: 18px;
            }
        }


    </style>
</head>
<body>

    <main>
        <div class="book">
            <div class="book-cover">
                <div>
                    <img src="{{ url('front_assets/img/logo.png') }}">
                    <div class="separator"></div>
                    <h1>Dunkel Beverage</h1>
                    <div class="separator"></div>
                    {{-- <h2>by Shivendra Tripathi</h2> --}}
                </div>
            </div>
            <div class="book-content ">
                <div class="menu-card-container">
                    <h1>All Menu Item List</h1>

                        <img src="{{ url('front_assets/img/logo.png') }}">

                    @php
                    use App\Models\MenuItemPrice;
                    @endphp
                    @foreach ($getCategory as $catlist )
                    @php
                    $getMenuItem = MenuItemPrice::where('menu_subcat_id',$catlist['id'])->get();
                    @endphp



                    <h2><i><b>{{ $catlist['menu_subcat_name'] }}</b></i></h2>
                    <ul style="list-style-type:disc;">
                        @foreach ( $getMenuItem as $itemList )
                       <li>{{ $itemList['menu_item_name'] }} ---- Rs.{{ $itemList['menu_item_price'] }}</li>
                        @endforeach
                        

                    </ul>
                    <hr><br>



                    @endforeach

                        <img src="{{ url('front_assets/img/logo.png') }}">
                        <br>
                        <a href="https://dunkelbeverage.com/">Visit Our Website</a>




                    <h3>Thank you for you visit <br><small>You just made our business grow..and for that we are GRATEFULL!</small></h3>
                    <div class="credit">Made with <span style="color:tomato;font-size:10px;">❤ </span>by<a href="https://uifstechnologies.com/"> Uifs Technlogies</a></div>

                </div>
            </div>
        </div>
    </main>

</body>
</html>
