<!DOCTYPE html>
<html>

<head>
    <title>Google Cloud Vision API</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333366;
        }

        form {
            border: 3px solid #f1f1f1;
            padding: 16px;
            width: 300px;
            margin: auto;
        }

        input[type="file"] {
            width: 100%;
            margin: 8px 0;
            padding: 12px 20px;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <h1>Upload an Image to Read</h1>
    <form action="processing.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="image_file" id="image_file">
        <input type="submit" value="Upload Image" name="submit">
    </form>

</body>

</html>