// Assuming you have the filter buttons with IDs like "filterAll", "filterProcessing", etc.
document.getElementById('filterAll').addEventListener('click', loadOrders);
document.getElementById('filterProcessing').addEventListener('click', loadOrders);
// Add similar event listeners for other filter buttons

function loadOrders(event) {
  const filterByStatus = event.target.id.replace('filter', '');

  fetch(`QLDonHang.php?filterByStatus=${filterByStatus}`)
    .then(response => response.json())
    .then(data => {
      updateOrderTable(data);
    })
    .catch(error => {
      console.error('Error loading orders:', error);
    });
}

function updateOrderTable(orders) {
  const orderTableBody = document.getElementById('orderTableBody');
  orderTableBody.innerHTML = '';

  orders.forEach(order => {
    const row = document.createElement('tr');

    const cell1 = document.createElement('td');
    cell1.textContent = order.maDonHang;
    row.appendChild(cell1);

    const cell2 = document.createElement('td');
    cell2.textContent = order.MaUser;
    row.appendChild(cell2);

    // Add more cells for other order details

    const cell9 = document.createElement('td');
    cell9.textContent = order.TenTrangThai;
    row.appendChild(cell9);

    orderTableBody.appendChild(row);
  });
}