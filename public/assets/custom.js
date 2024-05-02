/**
 * RESIZE FUNCTION
 */
function resizeImage(base64Str, maxWidth, maxHeight) {
    return new Promise((resolve) => {
        let img = new Image()
        img.src = base64Str
        img.onload = () => {
            let canvas = document.createElement('canvas')
            const MAX_WIDTH = maxWidth.value
            const MAX_HEIGHT = maxHeight.value

            // maxWidth.value
            // maxHeight.value
            let width = img.width
            let height = img.height

            if (width > height) {
                if (width > MAX_WIDTH) {
                    height *= MAX_WIDTH / width
                    width = MAX_WIDTH
                }
            } else {
                if (height > MAX_HEIGHT) {
                    width *= MAX_HEIGHT / height
                    height = MAX_HEIGHT
                }
            }

            canvas.width = width
            canvas.height = height
            let ctx = canvas.getContext('2d')
            ctx.drawImage(img, 0, 0, width, height)
            resolve(canvas.toDataURL())
        }
    })
}

/**
 * LARGE SCREEN IMAGES
 */
let original = document.querySelector('.original'),
    img_result = document.querySelector('.img-result'),
    img_w = document.querySelector('.img-w'),
    img_h = document.querySelector('.img-h'),
    ratio = document.querySelector('.ratio'),
    crop = document.querySelector('.crop'),
    cropped = document.querySelector('.cropped'),
    upload = document.querySelector('#image'), //file input upload
    cropper = '';

if (upload) {
    // on change show image with crop options
    upload.addEventListener('change', (e) => {
        //Kontrolleri görünür yap
        document.getElementById('box').classList.remove('d-none');
        if (e.target.files.length) {
            // start file reader
            const reader = new FileReader();
            reader.onload = (e) => {
                if (e.target.result) {
                    // create new image
                    let img = document.createElement('img');
                    img.id = 'js-img-cropper';
                    img.src = e.target.result;
                    // clean result before
                    original.innerHTML = '';
                    // append new image
                    original.appendChild(img);
                    //append child attr for scaling cropper
                    original.firstChild.classList.add("img-fluid");
                    Cropper.setDefaults({
                        aspectRatio: ratio.value,    // Ratio
                        zoomable: false,
                        zoomOnTouch: false,
                        zoomOnWheel: false,
                        movable: false,
                        viewMode: 1,
                        checkOrientation: false,
                        autoCropArea: 1
                    });
                    // init cropper
                    cropper = new Cropper(img);
                    document.querySelectorAll('[data-toggle="cropper"]').forEach((e => {
                        e.addEventListener("click", (o => {
                            let a = e.dataset.method || !1,
                                r = e.dataset.option || !1,
                                c = {
                                    zoom: () => {
                                        cropper.zoom(r)
                                    },
                                    setDragMode: () => {
                                        cropper.setDragMode(r)
                                    },
                                    rotate: () => {
                                        cropper.rotate(r)
                                    },
                                    scaleX: () => {
                                        cropper.scaleX(r), e.dataset.option = -r
                                    },
                                    scaleY: () => {
                                        cropper.scaleY(r), e.dataset.option = -r
                                    },
                                    setAspectRatio: () => {
                                        cropper.setAspectRatio(r)
                                    },
                                    crop: () => {
                                        cropper.crop()
                                    },
                                    clear: () => {
                                        cropper.clear()
                                    }
                                };
                            c[a] && c[a]()
                        }))
                    }))
                }
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
    // save on click
    crop.addEventListener('click', (e) => {
        e.preventDefault();
        // get result to data uri
        let imgSrc = cropper.getCroppedCanvas({
            //
        }).toDataURL();

        resizeImage(imgSrc, img_w, img_h).then((result) => {
            cropped.src = result;
            document.getElementById("cropped_data").value = result;   //hidden input value ataması, base64 formatında data.
            document.getElementById('box-2').classList.remove('d-none');
        });

    });
}
