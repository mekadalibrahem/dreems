// TODO : DELETE DREAM
<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Check if user is logged in
if (!isAdminLoggedIn()) {
    header('Location: index.php');
    exit;
}

// Check if deleting a specific dream
if (isset($_GET['id'])) {
    $dreamId = (int)$_GET['id'];
    
    $database = new Database();
    
    // Delete the dream
    $result = $database->deleteDream($dreamId);
    
    if ($result) {
        $_SESSION['success_message'] = 'تم حذف الحلم بنجاح!';
    } else {
        $_SESSION['error_message'] = 'حدث خطأ أثناء حذف الحلم.';
    }
}

// Redirect back to admin index
header('Location: index.php');
exit;
?>
