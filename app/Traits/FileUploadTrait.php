<?php

namespace App\Traits;

use App\Core\Helper\Helper;
use Exception;

trait FileUploadTrait
{
    // (200KB = 200 * 1024 bytes)
    public const MAX_SIZE = 200 * 1024;
    // Validate file type (optional - you can modify allowed types)
    public const ALLOWED_FILE_TYPES = ['image/jpeg', 'image/png', 'application/pdf'];

    /**
     * Handle file upload from form
     * @param string $fieldName Form input name
     * @param string|null $destination Storage folder path
     * @return array Returns array with status and either file_name or error_message
     */
    public function uploadFile($fieldName, $destination = null): array
    {
        try {
            if ($destination === null) {
                $destination = Helper::root_path() . 'storage/uploads/';
            }

            // Check if file was uploaded
            if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
                return [
                    'status' => true,
                    'file_name' => null
                ];
            }

            $file = $_FILES[$fieldName];

            // Check for upload errors
            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Upload failed with error code: " . $file['error']);
            }

            if ($file['size'] > self::MAX_SIZE) {
                throw new Exception("File size exceeds " . (self::MAX_SIZE / 1024) . "KB limit");
            }

            // Validate file type
            $fileType = mime_content_type($file['tmp_name']);
            if (!in_array($fileType, self::ALLOWED_FILE_TYPES)) {
                throw new Exception("Invalid file type. Allowed types: " . implode(', ', self::ALLOWED_FILE_TYPES));
            }

            // Ensure destination directory exists
            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

            // Generate unique filename
            $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $uniqueName = uniqid() . '.' . $fileExtension;
            $targetPath = $destination . $uniqueName;

            // Move file to storage
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                return [
                    'status' => true,
                    'file_name' => $uniqueName
                ];
            }

            throw new Exception("Failed to move uploaded file");
        } catch (Exception $e) {
            return [
                'status' => false,
                'error_message' => $e->getMessage()
            ];
        }
    }
}

