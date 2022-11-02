<div class="container">
    <header>
        <h1>Speech To Text with Google API</h1>
    </header>
    <section class="main-controls">
        <div id="buttons">
            <button class="record" id="record">Record</button>
            <button class="stop" id="stop">Stop</button>
        </div>
    </section>

    <section class="sound-clips">
    </section>
</div>

<script>
    // Select Elements
    const start_btn = document.getElementById('record');
    const stopButton = document.getElementById('stop');
    const soundClips = document.querySelector('.sound-clips');

    // Function to start recording autio from microphone
    const start_recording = () => {
        navigator.mediaDevices.getUserMedia({
                audio: true,
                video: false
            })
            .then(process_recording);
    }
    start_btn.addEventListener('click', start_recording);

    // Function that is called once start_recording() initiates obtaining the media from the user
    const process_recording = function(stream) {
        // Array to store media data obtained from the user
        let chunks = [];
        // Initiate a new recording / listening object
        const mediaRecorder = new MediaRecorder(stream);
        // Store data into chunks[]
        mediaRecorder.ondataavailable = (e) => {
            chunks.push(e.data);
        };
        // Process recorded data and store locally
        mediaRecorder.onstop = (e) => {
            console.log("Recording stopped");
            // Ask the name of the recording
            const clipName = prompt("Enter a name for your recording");

            // Create containers for generating a menu to handle this recording
            const clipContainer = document.createElement("article");
            const clipLabel = document.createElement("p");
            const audio = document.createElement("audio");
            const btn_delete = document.createElement("button");
            const btn_process = document.createElement("button");

            // Generate binary data from the stored recording using the audio codec
            const blob = new Blob(chunks, {
                type: "audio/ogg; codecs=opus"
            });
            // Clear the storage array, to provide space for another recording
            chunks = [];

            // Process display containers and add values
            clipContainer.classList.add("clip");
            audio.setAttribute("controls", "");
            btn_delete.innerHTML = "Delete";
            btn_process.innerHTML = "Process";
            clipLabel.innerHTML = clipName;

            // Event listener for processing the selected audio file
            btn_process.onclick = function() {

                (async () => {
                    const rawResponse = await fetch('processing.php', {
                        method: 'POST',
                        body: blob
                    });
                    const content = await rawResponse.json();

                    console.log(content);
                    alert(content.response_received_transcript);
                })();
            };

            // Append generated containers to the soundClips DOM object
            clipContainer.appendChild(audio);
            clipContainer.appendChild(clipLabel);
            clipContainer.appendChild(btn_delete);
            clipContainer.appendChild(btn_process);
            soundClips.appendChild(clipContainer);

            // Generate audio content to insert into audio preview object
            const audio_src = window.URL.createObjectURL(blob);
            audio.src = audio_src;

            // Create event listener for then the user deletes the recording from local storage
            btn_delete.onclick = (e) => {
                let evtTgt = e.target;
                evtTgt.parentNode.parentNode.removeChild(evtTgt.parentNode);
            };
        };
        // Event listener for when the user stops the recording 
        stopButton.onclick = () => {
            mediaRecorder.stop();
            console.log(mediaRecorder.state);
            console.log("Recording stopped");
        };

        // Start the process of the initiated recording / listening object
        console.log("Recording started");
        mediaRecorder.start();
        console.log(mediaRecorder.state);
    };
</script>