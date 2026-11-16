<?php

/*
|--------------------------------------------------------------------------
| Contact form — English source locale
|--------------------------------------------------------------------------
*/

return [

    'title' => 'Send us your project details',
    'intro' => 'Fields marked * are required.',

    'fields' => [
        'name' => 'Full name',
        'company' => 'Company',
        'email' => 'Email',
        'phone' => 'Phone',
        'inquiry_type' => 'Inquiry type',
        'message' => 'Project details',
    ],

    'placeholders' => [
        'name' => 'John Doe',
        'company' => 'Company name',
        'email' => 'john@company.com',
        'phone' => '+62 ...',
        'message' => 'Tell us about your project — material, quantity, tolerances, timeline...',
    ],

    'inquiry_types' => [
        'new-project' => 'New project',
        'engineering' => 'Engineering',
        'partnership' => 'Partnership',
        'other' => 'Other',
    ],

    'submit' => 'Send inquiry',
    'submitting' => 'Sending...',
    'success_title' => 'Thank you for your inquiry',
    'success_body' => 'Your message has been recorded and our team will contact you soon.',
    'success_again' => 'Send another message',

    'ack_subject' => 'We received your inquiry — PT. Uni-Metaltech Industry',
    'ack_body' => 'Thank you for contacting PT. Uni-Metaltech Industry. Our team has received your inquiry and will respond as soon as possible.',
    'internal_body' => 'A new inquiry was submitted through the website.',

    'errors' => [
        'title' => 'Please check the form',
        'generic' => 'The inquiry could not be sent. Please try again.',
        'throttled' => 'Too many inquiries were sent from this connection. Please try again in a minute.',
    ],

    'consent' => 'By sending this inquiry you agree that we may use the information provided to respond to your request.',

];
