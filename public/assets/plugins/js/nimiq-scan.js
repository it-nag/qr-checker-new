import QrScanner from '../nimiq-scan/qr-scanner.min.js';

// Variables
var qrScanner = null;
var scannedResult = null;

// Functions
function initScanNimiq(videoElement, qrTextInput) {
    qrScanner = new QrScanner(
        videoElement,
        (result) => {
            qrTextInput.value = result.data;

            qrTextInput.dispatchEvent(new Event('change'));

            qrScanner.destroy();
        },
        { /* your options or returnDetailedScanResult: true if you're not specifying any other options */ },
    );

    qrScanner.start();
}

function startScan() {
    qrScanner.start();
}

function stopScan() {
    qrScanner.start();
}

function destroyScan() {
    qrScanner.destroy();
}

export { initScanNimiq, startScan, stopScan, destroyScan, scannedResult }
