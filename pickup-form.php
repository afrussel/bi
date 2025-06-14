<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function clean($field) {
        return htmlspecialchars(trim($_POST[$field] ?? ''));
    }

    $firstName = clean('et_pb_contact_first_name_0');
    $lastName = clean('et_pb_contact_last_name_0');
    $company = clean('et_pb_contact_company_0');
    $jobTitle = clean('et_pb_contact_job_title_0');
    $phone = clean('et_pb_contact_phone_number_0');
    $email = filter_var(trim($_POST['et_pb_contact_email_0']), FILTER_SANITIZE_EMAIL);
    $country = clean('et_pb_contact_country_0');
    $postal = clean('et_pb_contact_postal_0');
    $business = clean('et_pb_contact_describe_your_business_0');
    $inventory = clean('et_pb_contact_current_inventory_0');
    $productType = clean('et_pb_contact_what_type_of_products_do_you_want_to_buy?_0');
    $brands = clean('et_pb_contact_what_brands?_0');
    $quantity = clean('et_pb_contact_what_quantity?_0');
    $message = clean('et_pb_contact_message_0');
    $userCaptcha = trim($_POST['captcha']);
    $correctCaptcha = trim($_POST['captcha_answer']);

    // Simple server-side captcha check
    if ($userCaptcha !== $correctCaptcha) {
        echo "Incorrect captcha. Please try again.";
        exit;
    }

    $to = "rasel365@yahoo.com, ceo@biturbollc.com";
    $subject = "New Pickup Request from $firstName $lastName";
    $body = "Pickup Request Details:\n\n" .
            "Name: $firstName $lastName\n" .
            "Company: $company\n" .
            "Job Title: $jobTitle\n" .
            "Phone: $phone\n" .
            "Email: $email\n" .
            "Country: $country\n" .
            "Postal: $postal\n" .
            "Business: $business\n" .
            "Inventory: $inventory\n" .
            "Products: $productType\n" .
            "Brands: $brands\n" .
            "Quantity: $quantity\n\n" .
            "Message:\n$message";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $subject, $body, $headers)) {
        echo "Message sent successfully.";
    } else {
        echo "Sorry, something went wrong. Please try again later.";
    }
} else {
    echo "Invalid request.";
}
