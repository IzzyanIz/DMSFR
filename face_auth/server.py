from flask import Flask, request, jsonify
import face_recognition
from PIL import Image
import numpy as np
import io
import os

app = Flask(__name__)

# Path where all face images are stored (you saved them in Laravel)
USER_FACE_FOLDER = "../storage/app/public/face_data"

@app.route('/compare-face', methods=['POST'])
def compare_face():
    filename = request.form.get('face_filename')  # full filename from DB
    uploaded_file = request.files.get('face_image')

    if not username or not uploaded_file:
        return jsonify({"status": "error", "message": "Missing data"}), 400

    user_image_path = os.path.join(USER_FACE_FOLDER, filename)
    
    if not os.path.exists(user_image_path):
        return jsonify({"status": "error", "message": "No stored face found for this user"}), 404

    # Load stored face
    stored_image = face_recognition.load_image_file(user_image_path)
    stored_encoding = face_recognition.face_encodings(stored_image)
    if not stored_encoding:
        return jsonify({"status": "error", "message": "No face found in stored image"}), 400

    # Load uploaded face
    uploaded_image = Image.open(uploaded_file.stream)
    uploaded_np = np.array(uploaded_image)
    uploaded_encoding = face_recognition.face_encodings(uploaded_np)
    if not uploaded_encoding:
        return jsonify({"status": "error", "message": "No face found in uploaded image"}), 400

    # Compare faces
    result = face_recognition.compare_faces([stored_encoding[0]], uploaded_encoding[0])[0]

    if result:
        return jsonify({"status": "success", "message": "Face matched"})
    else:
        return jsonify({"status": "fail", "message": "Face did not match"}), 401

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=5001)
