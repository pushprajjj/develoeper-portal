<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'partials/_dbconnect.php';
    
    $sec = 0.1;     
    $date = date("Y-m-d h:i:sa");
    $link =  $_SERVER["REQUEST_URI"] ;
    $visitor_email = $_POST['email'];
    $visitor_name = $_POST['name'];
    $visitor_phone = $_POST['phone'];
    $visitor_message = $_POST['message'];
     $email_subject = "New form submission";
    $headers = "From: no-reply@pcresort.in" . "\r\n" .
                "CC: no-reply@pcresort.in";
    $to = "pushprajkumar7874@gmail.com";
    $email_body = "Visitor Name: $visitor_name.\n".
             "Visitor Email: $visitor_email.\n".
             "Visitor message: $visitor_message.\n".
             "Message time: $date.\n";
    
    
    //recaptcha process starts
    
    $postURL = "https://www.google.com/recaptcha/api/siteverify";
    $secret = "6LcjSB4kAAAAABPN93tdM3tGfbVvb4lef__aMSGz";
    $response = $_POST['g-recaptcha-response'];

    $curlx = curl_init();
    curl_setopt($curlx, CURLOPT_URL, $postURL);
    curl_setopt($curlx, CURLOPT_HEADER, 0);
    curl_setopt($curlx, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlx, CURLOPT_POST, 1);

    $post_data = [
        "secret" => $secret,
        "response" => $response
    ];

    curl_setopt($curlx, CURLOPT_POSTFIELDS, $post_data);
    $resp = json_decode(curl_exec($curlx));
    curl_close($curlx);
    
    //recaptcha process ends
    if ($resp->success == true) {
        //email sending operation starts
        
       $retval = mail($to,$email_subject,$email_body,$headers);
             
          
         if( $retval == true ) { 
            echo "Message sent successfully..."; 
         }
         else { 
            echo "Message could not be sent..."; 
         } 
                //form submit operation starts
                //$sql = "INSERT INTO `contactform` (`visitor_email`, `visitor_name`, `visitor_phone`, `visitor_message`, `timestamp`) VALUES ( '$visitor_email', '$visitor_name', '$visitor_phone','$visitor_message', '$date')";
                //$result = mysqli_query($conn, $sql);
               // if($result){
                 $stmt = $conn->prepare("INSERT INTO `contactform` (`visitor_email`, `visitor_name`, `visitor_phone`, `visitor_message`, `timestamp`) VALUES (?, ?, ?, ?, ?)");
                 $stmt->bind_param("sssss", $visitor_email, $visitor_name, $visitor_phone, $visitor_message, $date);
                    if ($stmt->execute()) {
       
    
      
         echo '<script>alert("Hello '.$visitor_name.', We recieved your message and will be get in touch with you soon !")</script>';
        
}   

        

        // var_dump($resp);exit();
    }else{
        //Google recaptcha verification failed
          echo '<script>alert("Hello '.$visitor_name.', Spam bots are not welcome here !")</script>';
    }


}
    
    
    
header("Refresh: $sec; url=$link");

    ?>


<!doctype html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Developer - Pc Resort </title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/devicons/css/devicons.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/resume.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/contact.css" />
    <link rel="stylesheet" href="css/loader.css" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
 <script src="https://www.google.com/recaptcha/api.js"></script>
  <script>
   function onSubmit(token) {
     document.getElementById("contactform").submit();
   }
 </script>
 <style>
  .skills{
  animation-duration: 0.5s;
    animation-iteration-count: 1;
    transform-origin: bottom;
}
 .skills:hover{
  animation-name: bounce;
    animation-timing-function: ease;
    transform: translateY(-20px);
}

@keyframes bounce {
  0%   { transform: translateY(0); }
 
  100% { transform: translateY(-20px); }
}

@media screen and (max-width: 992px) {
  .mob {
  display:flex;
 align-text:center;  }
}
</style>
 
  </head>
 

  <body id="page-top">
       
      
      <div id="preloader"></div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">
        <span class="d-block d-lg-none">Pc Resort</span>
        <span class="d-none d-lg-block">
          <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="img/profile.jpg" alt="">
        </span>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item">
           <a class="nav-link js-scroll-trigger" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#experience">Works</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#education">Education</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#skills">Skills</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#interests">Interests</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="https://pcresort.in/" target="_blank">Blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="https://notes.pcresort.in/" target="_blank">iNotes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="https://forum.pcresort.in/" target="_blank">Community Forum</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#Contact">Contact us</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container-fluid p-0 ">

      <section class="resume-section p-3 p-lg-5 d-flex d-column" id="about">
        <div class="my-auto">
          <h1 class="mb-0 ">Pushpraj
            <span class="text-primary">Yadav</span>
          </h1>
          <div class="subheading mb-5">Professsor Colony · Madhepura, 852113 · (06476)-452593 ·
            <a href="mailto:pushprajkumar7874@gmail.com">Pushpraj@pcresort.in</a>
          </div>
          <p class="mb-5">I am experienced in delivering fast and secure websites for school, organization and institutes as well as for indivisuals for blog.  </p>
          <ul class="list-inline list-social-icons mb-0">
            <li class="list-inline-item">
              <a href="https://www.facebook.com/pushprajhere/" target="_blank">
                <span class="fa-stack fa-lg">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                </span>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="https://twitter.com/pushprajhere" target="_blank">
                <span class="fa-stack fa-lg">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                </span>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="https://www.instagram.com/pushprajjj/" target="_blank">
                <span class="fa-stack fa-lg">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
                </span>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="https://github.com/pushprajjj" target="_blank">
                <span class="fa-stack fa-lg">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                </span>
              </a>
            </li>
          </ul>
        </div>
      </section>

      <section class="resume-section p-3 p-lg-5 d-flex flex-column" id="experience">
        <div class="my-auto">
          <h2 class="mb-5">Works</h2>
          <div class="resume-item d-flex flex-column flex-md-row mb-5">
            <div class="resume-content mr-auto">
            <a class="mb-0" href="https://school.pcresort.in/" target="_blank"><h3>School.pcresort.in</h3></a>
              <div class="subheading mb-3">School Website</div>
              <p>This is a school website with highly advance features like Student Login with admission database sync, Fully managed admin dashboard, 2FA admin login with otp. <strong class="text-dark">This site can be customized according to your needs.</strong> </p>
            </div>
            <div class="resume-date text-md-right">
              <span class="text-primary">March 2023 </span>
            </div>
          </div>
          
          <div class="resume-item d-flex flex-column flex-md-row mb-5">
            <div class="resume-content mr-auto">
              <a class="mb-0" href="https://notes.pcresort.in/" target="_blank"><h3>iNotes</h3></a>
              <div class="subheading mb-3">Notes taking app</div>
              <p>iNotes is a notes taking web application where user can login with pc resort account and write notes</p>
            </div>
            <div class="resume-date text-md-right">
              <span class="text-primary">October 2022 </span>
            </div>
          </div>
          <div class="resume-item d-flex flex-column flex-md-row mb-5">
            <div class="resume-content mr-auto">
              <a class="mb-0" href="https://forum.pcresort.in/" target="_blank"><h3>iDiscuss</h3></a>
              <div class="subheading mb-3">Community Forum</div>
              <p>iDiscuss is a prototype community forum where students can discusss their question & answers if it belongs to a educational organization</p>
            </div>
            <div class="resume-date text-md-right">
              <span class="text-primary">August 2022 </span>
            </div>
          </div>
          
          <div class="resume-item d-flex flex-column flex-md-row mb-5">
            <div class="resume-content mr-auto">
              <a class="mb-0" href="https://sakacademy.in/" target="_blank"><h3>Sakacademy.in</h3></a>
              <div class="subheading mb-3">Educational institute</div>
              <p> A well known institute in patna for jee (main+ adv.) & AIIMS.</p>
            </div>
            <div class="resume-date text-md-right">
              <span class="text-primary">October 2021 </span>
            </div>
          </div>
          <div class="resume-item d-flex flex-column flex-md-row mb-5">
            <div class="resume-content mr-auto">
              <a class="mb-0" href="https://Shadowpath.ml/" target="_blank"><h3>Shadowpath.ml</h3></a>
              <div class="subheading mb-3">Personal Portofolio</div>
              <p>This website is based on personal interests like photography and story writing.</p>
            </div>
            <div class="resume-date text-md-right">
              <span class="text-primary">December 2021</span>
            </div>
          </div>

          <div class="resume-item d-flex flex-column flex-md-row mb-5">
            <div class="resume-content mr-auto">
              <a class="mb-0" href="https://pcresort.in/" target="_blank"><h3>pcresort.in</h3></a>
              <div class="subheading mb-3">Tech Blog</div>
              <p>A blog site related to technology, games, ets.</p>
            </div>
            <div class="resume-date text-md-right">
              <span class="text-primary">August 2021</span>
            </div>
          </div>

      <div class="resume-item d-flex flex-column flex-md-row mb-5">
            <div class="resume-content mr-auto">
              <a class="mb-0" href="https://mafiaesports.ga/" target="_blank"><h3>Mafiaesports.ga</h3></a>
              <div class="subheading mb-3">E-sports Website</div>
              <p>An organization who dedicated to esports and gaming industry</p>
            </div>
            <div class="resume-date text-md-right">
              <span class="text-primary">November 2021</span>
            </div>
          </div>

          <div class="resume-item d-flex flex-column flex-md-row mb-5">
            <div class="resume-content mr-auto">
              <a class="mb-0" href="https://dodesports.ga" target="_blank"><h3>dod e-sports</h3></a>
              <div class="subheading mb-3">E-sports Website</div>
              <p>An organization who dedicated to esports and gaming industry</p>
            </div>
            <div class="resume-date text-md-right">
              <span class="text-primary">November 2021</span>
            </div>
          </div>

        </div>

      </section>

      <section class="resume-section p-3 p-lg-5 d-flex flex-column" id="education">
        <div class="my-auto">
          <h2 class="mb-5">Education</h2>

          <div class="resume-item d-flex flex-column flex-md-row mb-5">
            <div class="resume-content mr-auto">
              <h3 class="mb-0">T.P COLLEGE MADHEPURA</h3>
              <div class="subheading mb-3">Bachelor In Computer application</div>
              <div>Computer Science - Web Development Track</div>
              
            </div>
            <div class="resume-date text-md-right">
              <span class="text-primary">june 2018 - May 2022</span>
            </div>
          </div>

      

        </div>
      </section>

      <section class="resume-section p-3 p-lg-5 d-flex flex-column" id="skills">
        <div class="my-auto">
          <h2 class="mb-5">Skills</h2>

          <div class="subheading mb-3">Programming Languages &amp; Tools</div>
          <ul class="list-inline list-icons">
            <li class="list-inline-item skills">
              <i class="devicons devicons-html5 "></i>
            </li>
            <li class="list-inline-item skills">
              <i class="devicons devicons-css3"></i>
            </li>
            <li class="list-inline-item skills">
              <i class="devicons devicons-javascript"></i>
            </li>
            <li class="list-inline-item skills">
              <i class="devicons devicons-php"></i>
            </li>
            <li class="list-inline-item skills">
              <i class="devicons devicons-wordpress"></i>
            </li>
          </ul>

          <div class="subheading mb-3">Workflow</div>
          <ul class="fa-ul mb-0">
            <li>
              <i class="fa-li fa fa-check"></i>
              Mobile-First, Responsive Design</li>
            <li>
              <i class="fa-li fa fa-check"></i>
              Cross Browser Testing &amp; Debugging</li>
            <li>
              <i class="fa-li fa fa-check"></i>
              Cross Functional Teams</li>
          
          </ul>
        </div>
      </section>

      <section class="resume-section p-3 p-lg-5 d-flex flex-column" id="interests">
        <div class="my-auto">
          <h2 class="mb-5">Interests</h2>
          <p>Apart from being a web developer, I enjoy most of my time being indoor and playing video games and stream on youtube.</p>
          <p class="mb-0">I follow a number of sci-fi and fantasy genre movies and television shows, and I spend a large amount of my free time exploring the latest technolgy advancements in the front-end web development world.</p>
        </div>
      </section>

     <section class="resume-section p-3 p-lg-5 d-flex flex-column" id="Contact">
        <div class="my-auto">
          <h2 class="mb-5">Contact</h2>
          <div class="container">
      <span class="big-circle"></span>
      <img src="img/shape.png" class="square" alt="" />
      <div class="form">
        <div class="contact-info">
          <h3 class="title">Let's get in touch</h3>
          <p class="text">
            If you have any question, simply ask me on my social media handles or through contact form.
          </p>

          <div class="info">
            <div class="information">
              <img src="img/location.png" class="icon" alt="" />
              Madhepura, Bihar, India
            </div>
            <div class="information">
              <img src="img/email.png" class="icon" alt="" />
             <a href="mailto:pushprajkumar7874@gmail.com">Pushpraj@pcresort.in</a>
            </div>
            <div class="information">
              <img src="img/fiverrr.png" class="icon" alt="" />
             <a href="https://www.fiverr.com/share/K696Yk" target="_blank" >Gig On Fiber</a>
            </div>
            <div class="information">
              <img src="img/linktree.png" class="icon" alt="" />
             <a href="https://linktr.ee/pushprajj" target="_blank" >Click Here for linktree</a>
            </div>
          </div>

          <div class="social-media">
                  <p>Connect with us :</p>
                  <div class="social-icons">
                    <a href="https://www.facebook.com/pushprajhere/" target="_blank">
                      <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/pushprajhere" target="_blank">
                      <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.instagram.com/pushprajjj/" target="_blank">
                      <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/channel/UCOb70GTmL2VZE4nJv8fECOQ" target="_blank">
                      <i class="fab fa-youtube"></i>
                    </a>
            </div>
          </div>
        </div>

        <div class="contact-form">
          <span class="circle one"></span>
          <span class="circle two"></span>

        <form id="contactform" action="/" method="post"  >
            <h3 class="title">Contact us</h3>
            <div class="input-container">
                    <input type="text" name="name" id="name" placeholder="Your Name" class="input" />
 
                  </div>
                  <div class="input-container">
                    <input type="email" name="email" id="email" placeholder="Your Email" class="input" />

                  </div>
                  <div class="input-container">
                    <input type="tel" name="phone" id="phone" placeholder="Mobile Number" class="input" />

                  </div>
                  <div class="input-container textarea">
                    <textarea name="message" id="message" class="input" placeholder="Your Message"></textarea>

                  </div>
            <button class="g-recaptcha" 
        data-sitekey="6LcjSB4kAAAAAN2YfepYhOw2A1Hm6PhGWnv5sVoB" 
        data-callback='onSubmit' 
        data-action='submit'>Submit</button>
          </form>
        </div>
      </div>
    </div>

    
      </section>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/resume.min.js"></script>

<script>
  var loader = document.getElementById("preloader");
  window.addEventListener("load", function(){
    loader.style.display = "none";
  })
</script>

  </body>

</html>
