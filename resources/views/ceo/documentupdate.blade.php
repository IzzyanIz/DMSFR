@extends('template/dashboardCEO')
@section('title', 'Document Approval Request ')

@section('section')
<div class="col-md-12">
  <div class="card">
    <h5 class="card-header">Update Document Request</h5>
    <div class="card-body">

<form id="approvalForm" action="{{ route('ceo.update.document.process', $document->id)}}" method="POST" enctype="multipart/form-data">
    @csrf 

        <div class="mb-4">
          <label class="form-label">Document Name:</label>
          <input type="text" class="form-control" id="document_name" name="document_name" value="{{ $document->document_name }}" readonly>
        </div> 

       
        @if($document->document_path)
            <a href="{{ asset('storage/' . $document->document_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary mt-2">
                View Current File
            </a>
        @endif

        <br><br>


        <input type="hidden" name="old_document_path" value="{{ $document->document_path }}">


        <div class="mb-4">
        <label class="form-label">Status:</label>
        <select class="form-control" name="status">
            <option value="">Please select status</option>
            <option value="accepted">Accept</option>
            <option value="rejected">Reject</option>
        </select>
        </div>

        <div class="mb-4">
          <label class="form-label">Notes:</label>
          <input type="text" class="form-control" id="notes" name="notes">
        </div> 

        <div class="text-end">
<button type="button" class="btn btn-primary" id="triggerFaceValidation">Submit Document</button>

        </div>
        
      </form>

    </div>
  </div>
</div>


<div class="modal fade" id="faceValidationModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Face Validation Required</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <video id="faceValidationVideo" width="480" height="360" autoplay muted style="border: 1px solid #ccc;"></video>
        <canvas id="faceValidationCanvas" width="480" height="360" class="d-none"></canvas>
        <p class="mt-2 text-muted">Align your face in front of the camera for verification.</p>
      </div>
      <div class="modal-footer">
        <button id="validateFaceBtn" class="btn btn-primary" disabled>Validate Face</button>
        <button class="btn btn-secondary" data-bs-dismiss="modal" id="cancelFaceValidation">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let faceVideo = document.getElementById('faceValidationVideo');
let faceCanvas = null;
let faceStream = null;
let faceInterval = null;
let faceModal = new bootstrap.Modal(document.getElementById('faceValidationModal'));

(async () => {
  await faceapi.nets.ssdMobilenetv1.loadFromUri('/models');
  await faceapi.nets.faceLandmark68Net.loadFromUri('/models');
  await faceapi.nets.faceRecognitionNet.loadFromUri('/models');
})();

document.getElementById('triggerFaceValidation').addEventListener('click', async function (e) {
    if (document.querySelector('select[name="status"]').value === '') {
        Swal.fire('Error', 'Please select a status.', 'error').then(() => {
            setTimeout(() => location.reload(), 1000);
        });
        return;
    }

    faceModal.show();

    faceStream = await navigator.mediaDevices.getUserMedia({ video: true });
    faceVideo.srcObject = faceStream;

    faceVideo.onloadeddata = () => {
        if (!faceCanvas) {
            faceCanvas = faceapi.createCanvasFromMedia(faceVideo);
            faceCanvas.style.position = 'absolute';
            faceCanvas.style.top = faceVideo.offsetTop + 'px';
            faceCanvas.style.left = faceVideo.offsetLeft + 'px';
            faceCanvas.style.zIndex = '10';
            faceCanvas.style.pointerEvents = 'none';
            document.querySelector('#faceValidationModal .modal-body').appendChild(faceCanvas);
        }
        document.getElementById('validateFaceBtn').disabled = true;
        faceInterval = setInterval(async () => {
            const detections = await faceapi.detectAllFaces(faceVideo, new faceapi.SsdMobilenetv1Options()).withFaceLandmarks();
            const dims = faceapi.matchDimensions(faceCanvas, { width: faceVideo.width, height: faceVideo.height });
            const resized = faceapi.resizeResults(detections, dims);
            faceCanvas.getContext('2d').clearRect(0, 0, faceCanvas.width, faceCanvas.height);
            faceapi.draw.drawDetections(faceCanvas, resized);
            faceapi.draw.drawFaceLandmarks(faceCanvas, resized);
            document.getElementById('validateFaceBtn').disabled = detections.length === 0;
        }, 300);
    };
});

document.getElementById('validateFaceBtn').addEventListener('click', async () => {
    const detection = await faceapi.detectSingleFace(faceVideo, new faceapi.SsdMobilenetv1Options()).withFaceLandmarks().withFaceDescriptor();
    if (!detection) {
        Swal.fire('Error', 'No face detected. Please try again.', 'error').then(() => {
            setTimeout(() => location.reload(), 1000);
        });
        return;
    }

    const descriptor = detection.descriptor;
    fetch("{{ route('validateFace') }}", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ descriptor })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            faceModal.hide();
            Swal.fire('Success', 'Face matched. Request submitted!', 'success').then(() => {
                document.getElementById('approvalForm').submit();
            });
        } else {
            Swal.fire('Error', data.message || 'Face does not match.', 'error').then(() => {
                setTimeout(() => location.reload(), 1000);
            });
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire('Error', 'Something went wrong.', 'error').then(() => {
            setTimeout(() => location.reload(), 1000);
        });
    });

    if(faceStream) faceStream.getTracks().forEach(track => track.stop());
    clearInterval(faceInterval);
});

document.getElementById('cancelFaceValidation').addEventListener('click', () => {
    if (faceStream) {
        faceStream.getTracks().forEach(track => track.stop());
    }
    clearInterval(faceInterval);
});
</script>




@endsection