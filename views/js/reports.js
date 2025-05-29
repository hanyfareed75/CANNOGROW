
document.addEventListener('DOMContentLoaded', function() {
    fetchReports();

    // Add event listeners for sidebar navigation
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            fetchReports();
        });
    });
});

async function fetchReports() {
    try {
        showLoading(true);
        
        const response = await fetch(`https://cannigrow.free.nf/managment/api/reportsAPI.php`);
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        if (data.error) throw new Error(data.error);

        updateDashboard(data);
    } catch (error) {
        console.error('Error fetching reports:', error);
        alert('حدث خطأ أثناء تحميل التقارير');
    } finally {
        showLoading(false);
    }
}

function updateDashboard(data) {
    // Update summary cards with null checks
    const updateElement = (id, value) => {
        const element = document.getElementById(id);
        if (element && value != null) {
            element.textContent = value.toLocaleString('ar-EG');
        }
    };

    updateElement('totalSales', data.summary?.total_revenue || 0);
    updateElement('totalCustomers', data.summary?.total_customers || 0);
    updateElement('totalOrders', data.summary?.total_orders || 0);
    updateElement('totalProducts', data.summary?.total_products || 0);
    // Update table
    updateTable(data.details || []);
}

function updateTable(details) {
    const tbody = document.querySelector('#reportsTable tbody');
    if (!tbody) return;
console.log(details);
    tbody.innerHTML = '';
    
    details.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.cust_name || "-"}</td>
            <td>${item.total_orders || 0}</td>
            <td>${(item.total_spending || 0).toLocaleString("ar-EG")}</td>
            <td>${
              item.last_order_date
                ? new Date(item.last_order_date).toLocaleDateString("ar-EG")
                : "-"
            }</td>
        `;
        tbody.appendChild(row);
    });

    if (details.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center">لا توجد بيانات متاحة</td>
            </tr>
        `;
    }
}

function showLoading(show) {
    const spinner = document.getElementById('loadingSpinner');
    if (spinner) {
        spinner.classList.toggle('d-none', !show);
    }
}