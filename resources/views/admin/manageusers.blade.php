@extends('template/dashboardAdmin')
@section('title', 'Manage Users')

@section('section')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<div class="col-md-12">
   <div class="white_shd full margin_bottom_30">
      <div class="full graph_head">
         <div class="heading1 margin_0">
            <h2>User information</h2>
         </div>
      </div>
      <div class="table_section padding_infor_info">
         <div class="table_section padding_infor_info">
            <a href="{{ route('form.register.face') }}" class="btn btn-success">
               <i class="fa fa-plus-circle"></i> Add User Account
            </a> <br><br>
            <div class="table-responsive-sm">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th style="color:black; font-size:15px;">Username</th>
                        <th style="color:black; font-size:15px;">Position</th>
                        <th style="color:black; font-size:15px;">Face Registration</th>
                        <th style="color:black; font-size:15px;">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($users as $user)
                     <tr>
                        <td style="color:black; font-size:15px;">{{ $user->username }}</td>
                        <td style="color:black; font-size:15px;">
                           {{ $user->roles === 'CEO' ? 'Head of Department' : $user->roles }}
                        </td>
                        <td style="color:black; font-size:15px;">
                           @if($user->roles == 'CEO')
                           @if(empty($user->descriptor))
                           <button class="btn btn-sm btn-danger" title="Not Registered">
                              <i class="bi bi-x-lg"></i>
                           </button>
                           @else
                           <button class="btn btn-sm btn-success" title="Registered">
                              <i class="bi bi-check-lg"></i>
                           </button>
                           @endif
                           @else
                           <button class="btn btn-sm btn-secondary" title="Not Applicable">
                              <i class="bi bi-dash-lg"></i>
                           </button>
                           @endif
                        </td>
                        <td style="font-size: 20px;">
                           
                           <a href="{{ route('user.editusers', $user->id) }}" class="btn btn-outline-warning btn-sm me-1" title="Edit">
                              <i class="fa fa-pencil yellow_color"></i>
                           </a>

                           
                           <form action="{{ route('user.delete', $user->id) }}" method="POST" style="display:inline-block;"
                              onsubmit="return confirm('Are you sure you want to delete this user account?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                 <i class="fa fa-trash red_color"></i>
                              </button>
                           </form>

                           @if($user->roles == 'CEO')
                           <a
                              href="#"
                              class="btn btn-outline-primary btn-sm me-1 registerFaceBtn"
                              data-id="{{ $user->id }}"
                              data-name="{{ $user->username }}"
                              title="Add Face">
                              <i class="fa fa-camera"></i>
                           </a>
                           @endif
                        </td>
                     </tr>
                     @endforeach
                  </tbody>

               </table>

            </div>
         </div>
      </div>
   </div>

   <div class="modal fade" id="faceModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Register Face for <span id="faceUserName"></span></h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
               <video id="faceVideo" width="640" height="480" autoplay muted style="border: 1px solid #ccc;"></video>
               <canvas id="faceCanvas" width="640" height="480" class="d-none"></canvas>
            </div>
            <div class="modal-footer">
               <button id="captureFace" class="btn btn-primary">Capture & Save Face</button>
               <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>



   <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <script>
      let video = document.getElementById('faceVideo');
      let selectedUserId = null;
      let stream = null;
      let detectInterval = null;
      let canvas = null;
      let faceDetected = false;

      (async () => {
         await faceapi.nets.ssdMobilenetv1.loadFromUri('models');
         await faceapi.nets.faceLandmark68Net.loadFromUri('models');
         await faceapi.nets.faceRecognitionNet.loadFromUri('models');
      })();

      document.querySelectorAll('.registerFaceBtn').forEach(btn => {
         btn.addEventListener('click', async () => {
            selectedUserId = btn.dataset.id;
            document.getElementById('faceUserName').innerText = btn.dataset.name;

            const modal = new bootstrap.Modal(document.getElementById('faceModal'));
            modal.show();

            stream = await navigator.mediaDevices.getUserMedia({
               video: true
            });
            video.srcObject = stream;

            video.addEventListener('loadeddata', () => {
               if (canvas) canvas.remove();

               canvas = faceapi.createCanvasFromMedia(video);
               canvas.id = 'faceCanvas';
               canvas.style.position = 'absolute';
               canvas.style.top = video.offsetTop + 'px';
               canvas.style.left = video.offsetLeft + 'px';
               canvas.style.zIndex = '10';
               canvas.style.pointerEvents = 'none';

               const container = document.querySelector('#faceModal .modal-body');
               container.style.position = 'relative';
               container.appendChild(canvas);

               faceapi.matchDimensions(canvas, {
                  width: video.width,
                  height: video.height
               });

               startDetection();
            });
         });
      });

      function startDetection() {
         faceDetected = false;
         document.getElementById('captureFace').disabled = true;

         detectInterval = setInterval(async () => {
            const detections = await faceapi.detectAllFaces(video, new faceapi.SsdMobilenetv1Options()).withFaceLandmarks();
            const resized = faceapi.resizeResults(detections, {
               width: video.width,
               height: video.height
            });

            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
            faceapi.draw.drawDetections(canvas, resized);
            faceapi.draw.drawFaceLandmarks(canvas, resized);

            if (detections.length > 0) {
               faceDetected = true;
               document.getElementById('captureFace').disabled = false;
            } else {
               faceDetected = false;
               document.getElementById('captureFace').disabled = true;
            }
         }, 300);
      }

      document.getElementById('captureFace').addEventListener('click', async () => {
         if (!faceDetected) {
            Swal.fire('Error', 'No face detected. Please try again.', 'error');
            return;
         }

         const detection = await faceapi.detectSingleFace(video, new faceapi.SsdMobilenetv1Options()).withFaceLandmarks().withFaceDescriptor();
         if (!detection) {
            Swal.fire('Error', 'No face detected at capture. Please try again.', 'error');
            return;
         }

         const descriptor = detection.descriptor;
         const box = detection.detection.box;

         fetch("{{ route('users.saveFace') }}", {
               method: 'POST',
               headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
               },
               body: JSON.stringify({
                  id: selectedUserId,
                  descriptor,
                  detection: {
                     x: box.x,
                     y: box.y,
                     width: box.width,
                     height: box.height
                  }
               })
            })
            .then(res => res.json())
            .then(data => {
               if (data.success) {
                  Swal.fire('Success', 'Face registered successfully!', 'success').then(() => location.reload());
               } else {
                  Swal.fire('Error', data.message, 'error');
               }
            })
            .catch(err => {
               console.error(err);
               Swal.fire('Error', 'Something went wrong.', 'error');
            });

         stream.getTracks().forEach(track => track.stop());
         clearInterval(detectInterval);
         canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
      });
   </script>

   @endsection