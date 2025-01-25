document.querySelector('.download-csv').addEventListener('click', function (e) {
    e.preventDefault();

    const tableId = this.getAttribute('data-table-id');
    const filename = this.getAttribute('data-filename') || 'report.csv';
    const table = document.getElementById(tableId);

    if (!table) {
        alert('Table not found!');
        return;
    }

    // Initialize CSV content
    let csv = [];

    // Loop through table rows
    const rows = table.querySelectorAll('tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('th, td');
        const rowData = Array.from(cells).map(cell => `"${cell.textContent.trim().replace(/"/g, '""')}"`);
        csv.push(rowData.join(','));
    });

    // Create Blob and download link
    const csvBlob = new Blob([csv.join('\n')], { type: 'text/csv' });
    const downloadLink = document.createElement('a');
    downloadLink.href = URL.createObjectURL(csvBlob);
    downloadLink.download = filename;

    // Trigger download
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
});
