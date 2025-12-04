import './bootstrap';

window.addEventListener('print-return', event => {
    const returnId = event.detail[0];
    const url = `/returns/print/${returnId}`;
    const printWindow = window.open(url, '_blank');
    printWindow.addEventListener('load', () => {
        printWindow.print();
    });
});
