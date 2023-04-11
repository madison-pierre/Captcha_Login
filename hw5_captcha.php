<?php class Captcha {
  // set up the captcha, need to use extension = gd
  private $length = 8; // number of characters
  private $capW = 300; // captcha width
  private $capH = 100; // captcha height
  private $capF = __DIR__ . DIRECTORY_SEPARATOR . "TuffyBold.ttf"; // captcha font
  private $capFS = 24; // captcha font size
  private $capB = __DIR__ . DIRECTORY_SEPARATOR . "CapBack.jpg"; // captcha background
 
  // start the session automatically
  function __construct () {
    if (session_status()==PHP_SESSION_DISABLED) { exit("Sessions disabled"); }
    if (session_status()==PHP_SESSION_NONE) { session_start(); }
  }
 
  // create a random string for each new session
  function prime () {
    $char = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $max = strlen($char) - 1;
    $_SESSION["captcha"] = "";
    for ($i=0; $i<=$this->length; $i++) { $_SESSION["captcha"] .= substr($char, rand(0, $max), 1); }
  }
 
  // create an image
  function draw ($mode=0) {
    if (!isset($_SESSION["captcha"])) { exit("Captcha not primed"); }
    $captcha = imagecreatetruecolor($this->capW, $this->capH);
    list($bx, $by) = getimagesize($this->capB);
    $bx = ($bx-$this->capW) < 0 ? 0 : rand(0, ($bx-$this->capW));
    $by = ($by-$this->capH) < 0 ? 0 : rand(0, ($by-$this->capH));
    imagecopy($captcha, imagecreatefromjpeg($this->capB), 0, 0, $bx, $by, $this->capW, $this->capH);
 
    // put the text in random places
    $ta = rand(-20, 20); // random angle
    $tc = imagecolorallocate($captcha, rand(120, 255), rand(120, 255), rand(120, 255)); // random text color
    $ts = imagettfbbox($this->capFS, $ta, $this->capF, $_SESSION["captcha"]);
    if ($ta>=0) {
      $tx = rand(abs($ts[6]), $this->capW - (abs($ts[2]) + abs($ts[6])));
      $ty = rand(abs($ts[5]), $this->capH);
    } else {
      $tx = rand(0, $this->capW - (abs($ts[0]) + abs($ts[4])));
      $ty = rand(abs($ts[7]), abs($ts[7]) + $this->capH - (abs($ts[3]) + abs($ts[7])));
    }
    imagettftext($captcha, $this->capFS, $ta, $tx, $ty, $tc, $this->capF, $_SESSION["captcha"]);
 
    // output captcha
    if ($mode==0) {
      ob_start();
      imagepng($captcha);
      $ob = base64_encode(ob_get_clean());
      echo "<img src='data:image/png;base64,$ob'>";
    } else {
      header("Content-type: image/png");
      imagepng($captcha); imagedestroy($captcha);
    }
  }
 
  // this is how we check it passes
  function verify ($check) {
    if (!isset($_SESSION["captcha"])) { exit("Captcha not primed"); }
    if ($check == $_SESSION["captcha"]) {
      unset($_SESSION["captcha"]);
      return true;
    } else { return false; }
  }
}

// create a new captcha object
$PHPCAP = new Captcha();

?>