const html5QrCode = new Html5Qrcode("reader");
const qrCodeSuccessCallback = (decodedText, decodedResult) => {
    html5QrCode.stop();
    var href = "http://localhost/quen_medev/public/dev-transaction-controller/transact-device-qr/";
    window.location.href = href + decodedText;
};
const config = { fps: 10, qrbox: { width: 250, height: 250 } };

function startScan(){
    html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);
}
function stopScan(){
    html5QrCode.stop();
}

function mouseClick(event) {
    var element = document.getElementById("qrReader");
    style = window.getComputedStyle(element);
    if(style.display == 'none'){
        html5QrCode.stop();
    }
  }
document.addEventListener("click", mouseClick);
