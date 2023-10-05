<?php
// Start Server Session
session_start();

// Display All Errors (For Easier Development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// curl -X POST \
//     -H "Authorization: Bearer $(gcloud auth print-access-token)" \
//     -H "x-goog-user-project: PROJECT_ID" \
//     -H "Content-Type: application/json; charset=utf-8" \
//     -d @request.json \
//     "https://vision.googleapis.com/v1/images:annotate"

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $image_path = $_FILES['image_file']['tmp_name'];
        $image_data = file_get_contents($image_path);
        $image_base64 = base64_encode($image_data);

        // Include cURL object file
        require '../includes/curl.class.php';
        // Initiate cURL Server bject
        $_cURL = new CurlServer($_SESSION['google_access_tokens']['access_token']);

        // Generate Call Parameters
        $parameters = '{
            "requests": [
              {
                "image": {
                  "content": "' . $image_base64 . '"
                },
                "features": [
                  {
                    "type": "TEXT_DETECTION",
                    "model": "builtin/latest"
                  }
                ]
              }
            ]
          }';

        // Make cURL call and store response on variable and on SESSION
        $response = $_cURL->post_request(
            "https://vision.googleapis.com/v1/images:annotate",
            $parameters
        );
        $_SESSION['response'] = $response;
        $json_response = $_SESSION['response'];


        // echo '<pre>';
        // print_r($parameters);
        // echo '</pre>';
        // echo '<pre>';
        // print_r($response);
        // echo '</pre>';

        // Create an image resource from the string of bytes
        $image = imagecreatefromstring($image_data);

        // Loop through each text annotation to draw the bounding boxes
        $word_list = [];
        foreach ($json_response->responses[0]->textAnnotations as $annotation) {
            $vertices = $annotation->boundingPoly->vertices;

            // Extract the coordinates of the vertices
            $x1 = $vertices[0]->x;
            $y1 = $vertices[0]->y;
            $x2 = $vertices[2]->x;
            $y2 = $vertices[2]->y;

            // Allocate a color for the bounding box (in this case, red)
            $red = imagecolorallocate($image, 255, 0, 0);

            // Draw the bounding box
            imagerectangle($image, $x1, $y1, $x2, $y2, $red);

            $word_list[] = [
                'word' => $annotation->description,
                'location' => "($x1, $y1)"
            ];
        }

        // Save the image to a file or encode as Base64
        ob_start();
        imagejpeg($image);
        $image_base64 = base64_encode(ob_get_clean());

        imagedestroy($image);
?>

        <!DOCTYPE html>
        <html>

        <head>
            <title>Text Annotations</title>
        </head>

        <body>

            <h1>Text Annotations</h1>

            <!-- Display the image -->
            <img src="data:image/jpeg;base64,<?php echo $image_base64; ?>" alt="Annotated Image">

            <!-- Display the list of words and their locations -->
            <h2>Word(s) and their locations</h2>
            <ul>
                <?php foreach ($word_list as $item) : ?>
                    <li>Word: <?php echo $item['word']; ?>
                        <ul>
                            <li>Location: <?php echo $item['location']; ?></li>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>

        </body>

        </html>
<?php
    } else {
        echo "Failed to upload image.";
    }
}
