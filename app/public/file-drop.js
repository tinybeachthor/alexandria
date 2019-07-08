function fileUpload(dropArea, progressBar) {
  // prevent defaults
  ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false)
  })
  function preventDefaults(e) {
    e.preventDefault()
    e.stopPropagation()
  }

  // highlighting drop area
  ;['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, highlight, false)
  })
  dropArea.addEventListener('dragleave', function (e) {
    if (e.pageX != 0 || e.pageY != 0) {
      return false
    }
    unhighlight()
  }, false)
  dropArea.addEventListener('drop', unhighlight, false)
  function highlight() {
    dropArea.classList.add('highlight')
  }
  function unhighlight() {
    dropArea.classList.remove('highlight')
  }

  // file drop
  dropArea.addEventListener('drop', handleDrop, false)
  function handleDrop(e) {
    let dt = e.dataTransfer
    let files = dt.files

    handleFiles(files)
  }
  function handleFiles(files) {
    files = [...files]
    initializeProgress(files.length)
    files.forEach(uploadFile)
    files.forEach(previewFile)
  }
  function uploadFile(file) {
    let url = '/book/upload'
    let formData = new FormData()
    formData.append('fileToUpload', file)

    fetch(url, {
      method: 'POST',
      body: formData
    })
      .then(() => {console.log('uploaded')})
      .then(progressDone)
      .catch((err) => {console.error(err)})
  }
  function previewFile(file) {
    let reader = new FileReader()
    reader.readAsDataURL(file)
    reader.onloadend = function () {
      let img = document.createElement('img')
      img.src = reader.result
      document.getElementById('gallery').appendChild(img)
    }
  }

  // progress
  let filesDone = 0
  let filesToDo = 0
  function initializeProgress(numfiles) {
    progressBar.value = 0
    filesDone = 0
    filesToDo = numfiles
  }
  function progressDone() {
    filesDone++
    progressBar.value = filesDone / filesToDo * 100
  }
}
