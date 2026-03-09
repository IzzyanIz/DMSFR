<form action="{{ route('login.face') }}" method="POST" enctype="multipart/form-data" id="loginForm">
    @csrf

    <div class="mb-3">
        <label for="username">Username:</label>
        <input type="text" class="form-control" name="username" required>
    </div>

    <div id="cameraSection">
        <label>Face Recognition:</label>
        <video id="video" width="300" autoplay></video>
        <input type="hidden" name="face_image_data" id="face_image_data">
        <button type="button" onclick="captureImage()">Capture Face</button>
    </div>

    <div id="passwordSection" style="display:none;">
        <label>Password:</label>
        <input type="password" name="password" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary mt-3">Login</button>
</form>

<script>
    function captureImage() {
    const video = document.getElementById('video');
    const canvas = document.createElement('canvas');
    canvas.width = 300;
    canvas.height = 300;
    canvas.getContext('2d').drawImage(video, 0, 0, 300, 300);
    
    const imageData = canvas.toDataURL('image/png');
    document.getElementById('face_image_data').value = imageData;

    // Submit the form manually after setting the image data
    document.getElementById('loginForm').submit();
}


    // Turn on camera
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            document.getElementById('video').srcObject = stream;
        })
        .catch(err => {
            document.getElementById('cameraSection').style.display = 'none';
            document.getElementById('passwordSection').style.display = 'block';
        });
</script>
