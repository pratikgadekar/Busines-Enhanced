<?php
    require_once('../../../../wp-load.php');
    include_once get_template_directory().'/anps-framework/classes/Options.php';
    $anps_social_data = $options->get_social();
    $to = $anps_social_data['email'];;
    $from = $_POST['form_data']['E-mail'];
    $subject = $_POST['form_data']['Subject'];
    $message = '';
    $message .= '<table cellpadding="0" cellspacing="0">';
    foreach ($_POST['form_data'] as $postname => $post) {
        if ($postname != "recaptcha_challenge_field" && $postname != "recaptcha_response_field") {
            $message .= "<tr><td style='padding: 5px 20px 5px 5px'><strong>" . urldecode($postname) . ":</strong>" . "</td><td style='padding: 5px; color: #444'>" . $post . "</td></tr>";
        }
    }
    $message .= '</table>';
    $headers = 'From: '.get_bloginfo('name')." <".$from .">\r\n" .
            'Reply-To: '.get_bloginfo('name')." <".$from .">\r\n" .
            'Content-type: text/html; charset=UTF-8' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
    wp_mail($to, $subject, $message, $headers);
?>