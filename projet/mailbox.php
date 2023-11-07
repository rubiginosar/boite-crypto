<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CryptoBox | Home</title>

    <style>
      @import url("https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap");
      body {
        font-family: "Poppins", sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
        margin-top: 80px;
      }

      header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: #333;
        color: #fff;
        padding: 10px;
        z-index: 100;
      }

      nav ul {
        list-style: none;
        padding: 0;
        position: sticky;
        display:flex;
        justify-content:space-around;
      }

      nav ul li {
        display: inline;
        margin-right: 20px;
      }

      nav ul li a {
        text-decoration: none;
        color: #fff;
      }
      nav ul li a:hover {
            text-decoration: none;
            color: #2980b9;
        }
      nav ul li a:focus {
            text-decoration: none;
            color: #8e44ad;
        }
      section {
        background-color: #fff;
        margin: 5px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background: linear-gradient(120deg, #2980b9, #8e44ad);
        overflow: hidden;
        width: 100%;
      }
      span {
        text-transform: uppercase;
        display: block;
        text-align:center;
      }
      .text1 {
        color: black;
        font-size:60px;
        font-weight:700;
        letter-spacing:8px;
        animation: text 3s 1;
        position: relative;
      }
      .text2 {
        font-size:40px;
        position: relative;
      }
      @keyframes text {
        0%{color:black;
          margin-bottom:-40px;
        }
        30%{
          letter-spacing:25px;
          margin-bottom:-40px; 
        }
        85%{
          letter-spacing:8px;
          margin-bottom:-40px;
        }
        
      }
    </style>
  </head>
  <body>
    <header>
      <nav>
        <ul>
          <li><a href="./mailbox.php">Home</a></li>
          <li><a href="./home.php">Send Message</a></li>
          <li><a href="./messages.php">Receive Message</a></li>
          <li><a href="./dic.php">Attack</a></li>
          <li><a href="./att.php">Password</a></li>
          <li><a href="./stegano.php">Steganographie</a></li>
          <li><a href="./logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>
    <section id="welcome">
      <span class="text1">Welcome to Your </span>
      <span class="text2">CRYPTOBOX</span>
    </section>
  </body>
</html>
