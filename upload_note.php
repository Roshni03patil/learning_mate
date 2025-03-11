<?php
include 'db.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = $_POST['subject_id'];
    $note_text = $_POST['note_text'];
    $pdf_file = $_FILES['pdf_file'];

    // Set pdf_file_name to NULL if no file is uploaded
    $pdf_file_name = NULL;

    // If a PDF is uploaded, process it
    if (!empty($pdf_file['name'])) {
        $target_dir = "uploads/"; // Folder to store PDFs
        $pdf_file_name = basename($pdf_file['name']);
        $target_file = $target_dir . $pdf_file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Ensure it's a PDF file
        if ($file_type != "pdf") {
            echo "Only PDF files are allowed.";
            exit;
        }

        // Move the uploaded PDF file to the "uploads" folder
        if (!move_uploaded_file($pdf_file['tmp_name'], $target_file)) {
            echo "Failed to upload PDF.";
            exit;
        }
    }

    // Insert the note text and the PDF file name (if available) into the database
    $sql = "INSERT INTO notes (subject_id, note_text, pdf_file) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $subject_id, $note_text, $pdf_file_name);

    if ($stmt->execute()) {
        echo "Note added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
