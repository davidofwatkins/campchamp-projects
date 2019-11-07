<?php
    
    function isMobile() {
        $useragent = strtolower($_SERVER["HTTP_USER_AGENT"]);
        if (strpos($useragent, "ipad")) { return false; }
        else if (strpos($useragent, "mobile")) { return true; }
        else if (strpos($useragent, "opera mini")) { return true; }
        else { return false; }
    }
    
?>
<style>
    body {
        font-family: arial, sans-serif;
        text-align: center;
        padding: 20px;
    }
    
    .box {
        width: 400px;
        border: 3px dashed black;
        background: #bcd5fc;
        padding: 30px;
        margin: 40px auto;
        border-radius: 10px;
    }
    
    #container {
        width: 800px;
        margin: auto;
    }
    
    #cssbox:before {
        content: "According to CSS, you ARE NOT on a mobile browser";
    }
    
    @media handheld, only screen and (max-width: 480px), only screen and (max-device-width: 480px) {
        #cssbox:before {
            content: "According to CSS, you ARE on a mobile browser";
        }
    }
</style>

<div id="container">
<h1>Mobile Detector</h1>

<p id="description">This page is designed to test the detection of mobile browsers on a webpage, both through server-side code and the CSS "media" attribute.</p>
<div class="box">According to PHP, you ARE <?php if (!isMobile()) { echo "NOT"; } ?></b> on a mobile browser.</div>
<div class="box" id="cssbox"></div>
</div>