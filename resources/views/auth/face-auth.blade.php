<form action="{{ route('face.verify') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="username" value="{{ $username }}">
  <input type="hidden" name="face_filename" value="{{ $face_filename }}">

  <div>
    <label>Scan Face (Photo):</label>
    <input type="file" name="face_image" accept="image/*" required>
  </div>

  <button type="submit">Verify Face</button>
</form>
