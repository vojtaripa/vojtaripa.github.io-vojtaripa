<!-- Learn about this code on MDN: https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file -->
<style>
      form {
        width: 95%;
        background: #ccc;
        margin: 0 auto;
        padding: 2.5%;
      }

      form ol {
        padding-left: 0;
      }

      form li {
        background: #eee;
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        list-style-type: none;
      }

      form img {
        height: 64px;
        margin-left; 20px;
        order: 1;
      }

      form p {
        line-height: 32px;
        padding-left: 10px;
      }

      form label, form button {
        background-color: black;
        background-image: linear-gradient(to bottom, rgba(255, 0, 0, 0), rgba(255, 0, 0, 0.4) 40%, rgba(255, 0, 0, 0.4) 60%, rgba(255, 0, 0, 0));
        color: #ccc;
        padding: 5px 10px;
        border-radius: 5px;
        border: 1px ridge gray;
      }

      form label:hover, form button:hover {
        background-color: #222;
      }

      form label:active, form button:active {
        background-color: #333;
      }
</style>


<form>
  <div>
    <label for="image_uploads">Choose images to upload (PNG, JPG)</label>
    <input type="file" id="image_uploads" name="image_uploads" accept=".jpg, .jpeg, .png" multiple>
  </div>
  <div class="preview">
    <p>No files currently selected for upload</p>
  </div>
  <div>
    <button>Submit</button>
  </div>
</form>

<script>var input = document.querySelector('input');
var preview = document.querySelector('.preview');

input.style.visibility = 'hidden';input.addEventListener('change', updateImageDisplay);function updateImageDisplay() {
  while(preview.firstChild) {
    preview.removeChild(preview.firstChild);
  }

  var curFiles = input.files;
  if(curFiles.length === 0) {
    var para = document.createElement('p');
    para.textContent = 'No files currently selected for upload';
    preview.appendChild(para);
  } else {
    var list = document.createElement('ol');
    preview.appendChild(list);
    for(var i = 0; i < curFiles.length; i++) {
      var listItem = document.createElement('li');
      var para = document.createElement('p');
      if(validFileType(curFiles[i])) {
        para.textContent = 'File name ' + curFiles[i].name + ', file size ' + returnFileSize(curFiles[i].size) + '.';
        var image = document.createElement('img');
        image.src = window.URL.createObjectURL(curFiles[i]);

        listItem.appendChild(image);
        listItem.appendChild(para);

      } else {
        para.textContent = 'File name ' + curFiles[i].name + ': Not a valid file type. Update your selection.';
        listItem.appendChild(para);
      }

      list.appendChild(listItem);
    }
  }
}var fileTypes = [
  'image/jpeg',
  'image/pjpeg',
  'image/png'
]

function validFileType(file) {
  for(var i = 0; i < fileTypes.length; i++) {
    if(file.type === fileTypes[i]) {
      return true;
    }
  }

  return false;
}function returnFileSize(number) {
  if(number < 1024) {
    return number + 'bytes';
  } else if(number > 1024 && number < 1048576) {
    return (number/1024).toFixed(1) + 'KB';
  } else if(number > 1048576) {
    return (number/1048576).toFixed(1) + 'MB';
  }
}
</script>