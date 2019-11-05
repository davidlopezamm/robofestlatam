   <?php 
if(isset($_POST['submit'])){
    $to = "staff@robofestlatam.org, r.rodriguez@robofestlatam.org, contacto@robofestlatam.org, r.marriro@robofestlatam.org"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $first_name = $_POST['first_name'];
    $subject = $_POST['subject'];
    $subject2 = "Copia de tu mensaje";
    $message = $first_name . " Dice:" . "\n\n" . $_POST['message'];
    $message2 = "Copia de tu mensaje " . $first_name . "\n\n" . $_POST['message'];

    $headers = "From:" . $from;
    $headers2 = "From: contacto@robofestlatam.org";
    mail($to,$subject,$message,$headers) or die ("Failure");
    mail($from,$subject2,$message2,$headers2)or die ("Failure"); // sends a copy of the message to the sender
   // echo "Mail Sent. Thank you " . $first_name . ", we will contact you shortly.";
     header('Location: index.php');
    // You cannot use header and echo together. It's one or the other.
    }
?>