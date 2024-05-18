<?php
require('libs/fpdf/fpdf.php'); // Include the FPDF library

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted form data
    $fullName = $_POST['full-name'];
    $dateOfBirth = $_POST['dob'];
    $gender = $_POST['gender'];
    $fatherName = $_POST['father-name'];
    $motherName = $_POST['mother-name'];
    $guardianName = $_POST['guardian-name'];
    $highestQualification = $_POST['highest-qualification'];
    $institutionName = $_POST['institution-name'];
    $yearOfPassing = $_POST['year-of-passing'];
    $contactNumber = $_POST['contact-number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $courseSelection = $_POST['course-selection'];
    $batchTiming = $_POST['batch-timing'];
    $courseDuration = $_POST['course-duration'];
    $hearAbout = $_POST['hear-about'];
    $otherOptionText = $_POST['other-option-text'];
    $declaration = $_POST['declaration'];

    // Check if required fields are filled
    if (empty($fullName) || empty($dateOfBirth) || empty($gender) || empty($fatherName) || empty($motherName) || empty($guardianName) ||
        empty($highestQualification) || empty($institutionName) || empty($yearOfPassing) || empty($contactNumber) || empty($email) ||
        empty($address) || empty($courseSelection) || empty($batchTiming) || empty($courseDuration) || empty($hearAbout) ||
        empty($declaration)) {
        // Display error message and stop processing
        echo "Please fill out all required fields.";
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Validate declaration checkbox
    if ($declaration != 'on') {
        echo "Please agree to the declaration.";
        exit;
    }

    // Get the uploaded image file
    $imageFile = $_FILES['photo'];

    // Validate image file upload
    if (empty($imageFile['name'])) {
        echo "Please upload an image.";
        exit;
    }

    // Validate image file type and size
    $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
    $maxFileSize = 1 * 1024 * 1024; // 1MB

    if (!in_array($imageFile['type'], $allowedTypes)) {
        echo "Invalid image file type. Only JPEG, PNG, and GIF are allowed.";
        exit;
    }

    if ($imageFile['size'] > $maxFileSize) {
        echo "Image file size exceeds the limit of 1MB.";
        exit;
    }

    // Generate a unique filename for the uploaded image
    $imageFileName = uniqid() . '_' . basename($imageFile['name']);

    // Specify the upload directory
    $uploadDir = 'data/images';

    // Move the uploaded file to the upload directory
    $targetPath = $uploadDir . '/' . $imageFileName;
    if (!move_uploaded_file($imageFile['tmp_name'], $targetPath)) {
        echo "Failed to upload image. Please try again.";
        exit;
    }

    // Create a PDF from the form data
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Admission Form', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "Full Name: $fullName", 0, 1);
    $pdf->Cell(0, 10, "Date of Birth: $dateOfBirth", 0, 1);
    $pdf->Cell(0, 10, "Gender: $gender", 0, 1);
    $pdf->Cell(0, 10, "Father's Name: $fatherName", 0, 1);
    $pdf->Cell(0, 10, "Mother's Name: $motherName", 0, 1);
    $pdf->Cell(0, 10, "Guardian's Name: $guardianName", 0, 1);
    $pdf->Cell(0, 10, "Highest Qualification: $highestQualification", 0, 1);
    $pdf->Cell(0, 10, "Institution Name: $institutionName", 0, 1);
    $pdf->Cell(0, 10, "Year of Passing: $yearOfPassing", 0, 1);
    $pdf->Cell(0, 10, "Contact Number: $contactNumber", 0, 1);
    $pdf->Cell(0, 10, "Email: $email", 0, 1);
    $pdf->Cell(0, 10, "Address: $address", 0, 1);
    $pdf->Cell(0, 10, "Course Selection: $courseSelection", 0, 1);
    $pdf->Cell(0, 10, "Batch Timing: $batchTiming", 0, 1);
    $pdf->Cell(0, 10, "Course Duration: $courseDuration", 0, 1);
    $pdf->Cell(0, 10, "Heard About Us From: $hearAbout", 0, 1);
    if (!empty($otherOptionText)) {
        $pdf->Cell(0, 10, "Other Option Text: $otherOptionText", 0, 1);
    }
    $pdfFileName = uniqid() . '_form.pdf';
    $pdfFilePath = 'data/pdf/' . $pdfFileName;
    $pdf->Output('F', $pdfFilePath);

    // Connect to the database
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'creativecareeracademy';

    $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Insert data into the database
    $sql = "INSERT INTO admissions (full_name, dob, gender, father_name, mother_name, guardian_name, highest_qualification, institution_name, year_of_passing, contact_number, email, address, course_selection, batch_timing, course_duration, hear_about, other_option_text, photo, pdf_link)
            VALUES ('$fullName', '$dateOfBirth', '$gender', '$fatherName', '$motherName', '$guardianName', '$highestQualification', '$institutionName', '$yearOfPassing', '$contactNumber', '$email', '$address', '$courseSelection', '$batchTiming', '$courseDuration', '$hearAbout', '$otherOptionText', '$imageFileName', '$pdfFileName')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Display the success page
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Creative Career Academy</title>
            <link rel="icon" type="image/x-icon" href="./logo.svg">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
            <style>
                body {
                    font-family: poppins;
                    display: flex;
                    flex-direction: column;
                    background-color: rgb(0, 16, 51);
                    color: #E2FCDE;
                    height: 100vh;
                    justify-content: center;
                    align-items: center;
                    text-align: center;
                }

                .main {
                    font-size: 3rem;
                    font-weight: bold;
                }

                .para {
                    margin-top: 2rem;
                }

                .download-button {
                    background-color: #E2FCDE;
                    color: rgb(0, 16, 51);
                    border: none;
                    padding: 10px 20px;
                    font-size: 1rem;
                    cursor: pointer;
                    margin-top: 2rem;
                }
            </style>
        </head>
        <body>
            <div class="main">
                Form Submitted
            </div>
            <div class="para">
                <p>Please submit the printed copy or soft copy along with the admission fees accordingly.</p>
            </div>
            <button class="download-button" onclick="downloadForm()">Download Form</button>
        </body>
        </html>';

        // JavaScript function to download the form
        echo '<script>
            function downloadForm() {
                const formLink = "' . $pdfFilePath . '";
                window.open(formLink, "_blank");
            }
        </script>';
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Form submission failed. Please try again.";
}
?>
