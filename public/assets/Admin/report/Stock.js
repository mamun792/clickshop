document.querySelector('.download-csv').addEventListener('click', function (e) {
    e.preventDefault();

    const tableId = this.getAttribute('data-table-id');
    const filename = this.getAttribute('data-filename') || 'report.csv';
    const table = document.getElementById(tableId);

    if (!table) {
        alert('Table not found!');
        return;
    }

  
    let csv = [];
    
 
    const rows = table.querySelectorAll('tr');
    
   
    const columnCount = table.querySelectorAll('thead th').length;

    rows.forEach(row => {
        const rowData = [];
        const cols = row.querySelectorAll('th, td');
        let colIndex = 0;

        cols.forEach(col => {
            let cellContent = col.textContent.trim();

         
            if (!cellContent) {
                cellContent = 'N/A';
            }

         
            cellContent = cellContent.replace(/"/g, '""').replace(/\n/g, ' ').replace(/,/g, ' ');

         
            if (!isNaN(cellContent)) {
                cellContent = parseFloat(cellContent).toFixed(2); 
            }

            
            rowData.push(`"${cellContent}"`);
            colIndex++;
        });

      
        while (colIndex < columnCount) {
            rowData.push('"N/A"');
            colIndex++;
        }

    
        csv.push(rowData.join(','));
    });

  
    const csvBlob = new Blob([csv.join('\n')], { type: 'text/csv' });

  
    const downloadLink = document.createElement('a');
    downloadLink.href = URL.createObjectURL(csvBlob);
    downloadLink.download = filename;

    
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
});