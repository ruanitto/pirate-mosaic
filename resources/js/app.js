require("./bootstrap")
require('./crop')

/* ------------------- */
/* ------------------- */
/* ---- Preloader ---- */
/* ------------------- */
/* ------------------- */
document.onreadystatechange = function () {
    var preloader = document.querySelector(".preloader")

    if (document.readyState === "complete") {
        setTimeout(function () {
            preloader.classList.remove("active")
        }, 1000)
    }
}

/* ----------------------- */
/* ----------------------- */
/* ---- Unique Random ---- */
/* ----------------------- */
/* ----------------------- */
var uniqueRandoms = []
function makeUniqueRandom(numRandoms) {
    if (!uniqueRandoms.length) {
        for (var i = 0; i < numRandoms; i++) {
            uniqueRandoms.push(i)
        }
    }
    var index = Math.floor(Math.random() * uniqueRandoms.length)
    var val = uniqueRandoms[index]

    uniqueRandoms.splice(index, 1)

    return val
}

/* -------------- */
/* -------------- */
/* ---- Crop ---- */
/* -------------- */
/* -------------- */
let $basic = $('.crop-container').croppie({
    viewport: { width: 250, height: 250 },
    boundary: { width: 300, height: 300 },
    showZoomer: false,
    url: ''
})

function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader()

        reader.onload = function (e) {
            $('.crop-container').croppie('bind', {
                url: e.target.result
            })
            $('.action-upload').toggle()
        }

        reader.readAsDataURL(input.files[0])
    }
}

$('.action-upload input').on('change', function () {
    readFile(this)
})

/* -------------------- */
/* -------------------- */
/* ---- Navigation ---- */
/* -------------------- */
/* -------------------- */
const terms = document.querySelector("#share")
const fieldOne = document.querySelector("#fieldOne")
const fieldTwo = document.querySelector("#fieldTwo")
document.querySelector("#enviar").addEventListener("click", async function (e) {
    e.preventDefault()

    if (!terms.checked) {
        return alert("Você precisa aceitar os termos para continuar")
    }

    const profile = await storage.getItem("profile")
    const token = await storage.getItem("token")

    try {
        const formData = new FormData()

        formData.set("fieldOne", fieldOne.value)
        formData.set("fieldTwo", fieldTwo.value)
        formData.set("share", share.checked)

        const imageBase64 = await readImageBlob()

        console.log(imageBase64)
        formData.set("img", imageBase64)

        const { data } = await axios.post(
            `/api/dream/${profile.id}`,
            formData,
            {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`
                }
            }
        )
        await storage.setItem("dream", data)
    } catch (err) {
        alert("Deu erro ao salvar")
        console.error(err)
    }
})

/* --------------- */
/* --------------- */
/* ---- Image ---- */
/* --------------- */
/* --------------- */
function loadXHR(url) {
    return new Promise(function (resolve, reject) {
        try {
            var xhr = new XMLHttpRequest()
            xhr.open("GET", url)
            xhr.responseType = "blob"
            xhr.onerror = function () {
                reject("Network error.")
            }
            xhr.onload = function () {
                if (xhr.status === 200) {
                    resolve(xhr.response)
                } else {
                    reject("Loading error:" + xhr.statusText)
                }
            }
            xhr.send()
        } catch (err) {
            reject(err.message)
        }
    })
}

async function readImageBlob() {
    if ($basic) {
        const result = await $basic.croppie('result', {
            type: 'base64',
            format: 'jpg',
            circle: false,
            size: {
                width: 250,
                height: 250
            }
        })
        return result.replace(/^data:image\/[a-z]+;/, '')
    }

    const previewImage = document.querySelector(".preview")
    const imageUrlBlob = previewImage.style["background-image"]
        .replace('url("', "")
        .replace('")', "")
    const imageBlob = await loadXHR(imageUrlBlob)

    return new Promise((resolve, reject) => {
        var reader = new FileReader()
        reader.readAsDataURL(imageBlob)
        reader.onloadend = function () {
            resolve(reader.result)
        }
    })
}

/* ---------------- */
/* ---------------- */
/* ---- Camera ---- */
/* ---------------- */
/* ---------------- */
$(document).ready(function (e) {
    var constraints = {
        video: {
            facingMode: "user"
        },
        audio: false
    }

    const cameras = document.querySelectorAll(".open-camera")

    let camera = document.querySelector(".camera"),
        cameraOutput = document.querySelector(".camera--output"),
        cameraSensor = document.querySelector(".camera--sensor"),
        cameraView = document.querySelector(".camera--view"),
        cameraTrigger = document.querySelector(".camera--trigger")

    if (cameraTrigger) {
        cameraTrigger.addEventListener("click", function () {
            cameraSensor.width = cameraView.videoWidth
            cameraSensor.height = cameraView.videoHeight
            cameraSensor.getContext("2d").drawImage(cameraView, 0, 0)
            cameraOutput.src = cameraSensor.toDataURL("image/webp")
            cameraOutput.classList.add("taken")
        })

        cameraOutput.onclick = function () {
            console.log("CORTOU")
            cameras[parseInt(camera.dataset.itemKey)].classList.add(
                "has-image"
            )
            cameras[parseInt(camera.dataset.itemKey)].querySelector(
                ".output"
            ).style.backgroundImage = `url(${cameraOutput.src})`
            camera.classList.remove("camera-open")
        }
    }

    function cameraStart() {
        navigator.mediaDevices
            .getUserMedia(constraints)
            .then(function (stream) {
                var track = stream.getTracks()[0]
                cameraView.srcObject = stream
                camera.classList.add("camera-open")
                cameraView.classList.add("camera-open")
                cameraOutput.classList.add("camera-open")
                cameraSensor.classList.add("camera-open")
                cameraTrigger.classList.add("camera-open")
            })
            .catch(console.error)
    }

    Array.from(cameras).forEach((item, key) => {
        let openCamera = item

        openCamera.onclick = function (e) {
            camera.dataset.itemKey = key
            cameraStart()
        }
    })
})

/* ---------------- */
/* ---------------- */
/* ---- Upload ---- */
/* ---------------- */
/* ---------------- */
$(document).ready(function (e) {
    var _URL = window.URL || window.webkitURL

    $('input[type="file"].upload').change(function (e) {
        var image, file

        if ((file = this.files[0])) {
            image = new Image()

            image.onload = function () {
                e.preventDefault()

                let src = this.src

                $(e.currentTarget)
                    .parent()
                    .find(".preview")
                    .css("background-image", "url(" + src + ")")
                $(e.currentTarget)
                    .parent()
                    .addClass("has-image")
                $(".preview").css("background-image", "url(" + src + ")")
                $(".preview")
                    .parent()
                    .addClass("has-image")
            }
        }

        image.src = _URL.createObjectURL(file)
    })
})

/* ----------------- */
/* ----------------- */
/* ---- Mosaico ---- */
/* ----------------- */
/* ----------------- */
async function mosaic() {
    const mosaicOutput = document.querySelector(".mosaico-output")
    const ctx = mosaicOutput.getContext("2d")
    const loader = document.querySelector(".loader")
    const { data } = await axios.get("/api/urls")
    const imagesUrls = Object.values(data).map(img => 'https://sonhospossiveistenda.com.br' + img.image)

    console.log("imagesUrls", imagesUrls)

    let logo = "images/nova-marca-tenda.jpg"

    var totalRowsAndCols = Math.round(Math.sqrt(imagesUrls.length))

    console.log("imagesUrls.length: ", imagesUrls.length)
    console.log("totalRowsAndCols: ", totalRowsAndCols)

    const options = {
        rowsAndCols: totalRowsAndCols,
        squareAlpha: 10,
        squareEffect: "soft-light",
        hoverSize: 200,
        pixelated: true
    }

    const maxWidth = Math.min(1000, window.innerWidth)
    const generatedImage = new Image()

    let squareWidth = Math.ceil(maxWidth / options.rowsAndCols)
    let imgAspectRatio
    let samples
    let generatedImageSamples

    function reset() {
        ctx.clearRect(0, 0, mosaicOutput.width, mosaicOutput.height)
        ctx.drawImage(generatedImage, 0, 0)
        ctx.fillStyle = "#F3F3F3"
    }

    function number2hex(number) {
        const hex = number.toString(16)
        return (hex.length === 1 ? "0" : "") + hex
    }

    function getTileColors(image, size) {
        const canvas = document.createElement("canvas")
        const context = canvas.getContext("2d")

        canvas.width = size
        canvas.height = (size * image.height) / image.width

        context.drawImage(
            image,
            0,
            0,
            image.width,
            image.height,
            0,
            0,
            canvas.width,
            canvas.height
        )

        const data = Array.from(
            context.getImageData(0, 0, canvas.width, canvas.height).data
        )

        let colors = []

        for (let i = 0; i < data.length; i += 4) {
            colors[i / 4] = `rgba(${data[i]}, ${data[i + 1]}, ${
                data[i + 2]
                }, 1)`
        }

        return colors
    }

    function render() {
        loader.classList.add("active")
        mosaicOutput.classList.remove("active")
        generatedImageSamples = []

        const rowsAndCols = options.rowsAndCols
        const rowsAndCols_Y = (options.rowsAndCols_Y = Math.floor(
            rowsAndCols * imgAspectRatio
        ))

        squareWidth = Math.ceil(maxWidth / rowsAndCols)
        ctx.clearRect(0, 0, mosaicOutput.width, mosaicOutput.height)

        var colors = getTileColors(input, rowsAndCols)

        setTimeout(function () {
            for (var i = 0; i < rowsAndCols; i++) {
                for (var j = 0; j < rowsAndCols_Y; j++) {
                    requestAnimationFrame(
                        (function (i, j) {
                            return () => {
                                const x = i * squareWidth
                                const y = j * squareWidth

                                if (options.pixelated) {
                                    const color = colors[i + j * rowsAndCols]

                                    ctx.fillStyle = color
                                    ctx.fillRect(
                                        x,
                                        y,
                                        squareWidth,
                                        squareWidth
                                    )
                                }

                                ctx.globalAlpha = options.squareAlpha
                                ctx.globalCompositeOperation = options.squareEffect

                                const randomSample =
                                    samples[
                                    Math.floor(
                                        makeUniqueRandom(samples.length)
                                    )
                                    ]


                                generatedImageSamples[
                                    i + j * rowsAndCols
                                ] = randomSample

                                ctx.drawImage(
                                    randomSample,
                                    x,
                                    y,
                                    squareWidth,
                                    squareWidth
                                )

                                ctx.globalCompositeOperation = "source-over"
                                ctx.globalAlpha = 1

                                if (
                                    i === rowsAndCols - 1 &&
                                    j === rowsAndCols_Y - 1
                                ) {
                                    loader.classList.remove("active")
                                    mosaicOutput.classList.add("active")

                                    generatedImage.src = mosaicOutput.toDataURL()
                                }
                            }
                        })(i, j)
                    )
                }
            }
        }, 4)
    }

    function Asset(url) {
        return new Promise(function (resolve, reject) {
            const img = new Image()

            img.onload = () => resolve(img)
            img.onerror = () => reject(img)
            img.src = url
        })
    }

    const input = new Image()

    input.onload = () => {
        imgAspectRatio = input.height / input.width
        mosaicOutput.width = mosaicOutput.style.width = maxWidth
        mosaicOutput.height = mosaicOutput.style.height =
            Math.floor(options.rowsAndCols * imgAspectRatio) * squareWidth

        Promise.all(imagesUrls.map(Asset))
            .then(function (images) {
                samples = images

                render()

                mosaicOutput.addEventListener("mouseout", function (e) {
                    reset()
                })

                let diff = null
                mosaicOutput.addEventListener(
                    "mousemove",
                    function (e) {
                        const x =
                            Math.floor(e.offsetX / squareWidth) * squareWidth
                        const y =
                            Math.floor(e.offsetY / squareWidth) * squareWidth

                        requestAnimationFrame(() => {
                            reset()

                            ctx.fillRect(
                                x * squareWidth,
                                y * squareWidth,
                                squareWidth,
                                squareWidth
                            )

                            const img =
                                generatedImageSamples[
                                x / squareWidth +
                                (y / squareWidth) * options.rowsAndCols
                                ]
                            var hoverSize = options.hoverSize * 2

                            ctx.fillStyle = "#FFFFFF"

                            if (!img) {
                                return
                            }

                            const ratio = hoverSize / squareWidth
                            let diffY = (diff =
                                ((1 - ratio) * squareWidth) / 2)

                            if (
                                x + diff + squareWidth * ratio >
                                mosaicOutput.width
                            ) {
                                diff =
                                    mosaicOutput.width -
                                    squareWidth * ratio -
                                    x
                            }

                            if (x + diff < 0) {
                                diff = -x
                            }

                            if (
                                y + diff + squareWidth * ratio >
                                mosaicOutput.height
                            ) {
                                diffY =
                                    mosaicOutput.height -
                                    squareWidth * ratio -
                                    y
                            }

                            if (y + diffY < 0) {
                                diffY = -y
                            }

                            ctx.drawImage(
                                img,
                                x + diff,
                                y + diffY,
                                squareWidth * ratio,
                                squareWidth * ratio
                            )
                        })
                    },
                    false
                )
            })
            .catch(console.error)
    }
    input.src = logo
}
