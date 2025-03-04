@extends('admin.layout')

@section('css')
<style>
.stat-box {
    padding: 25px;
    border-radius: 15px;
    text-align: center;
    color: white;
    font-weight: bold;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.stat-box:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.25);
}

.icon {
    font-size: 50px;
    margin-bottom: 10px;
    opacity: 0.9;
}

/* 🌟 Beautiful Gradient Colors */
.bg-total-orders {
    background: linear-gradient(135deg, #6b0909, rgba(243, 55, 86, 0.738));
}
.bg-total-revenue {
    background: linear-gradient(135deg, #5ecb71, #008a27);
}
.bg-total-users {
    background: linear-gradient(135deg, #1e90ff, #00bfffc4);
}
.bg-pending-orders {
    background: linear-gradient(135deg, #ffcc00d8, #ff9900);
}
.bg-total-products {
    background: linear-gradient(135deg, #6b63ffd8, #3a3aff);
}

.chart-container {
    width: 100%;
    height: 350px;
}

</style>
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Breadcrumb -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Admin Dashboard</h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <ol class="breadcrumb justify-content-end">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
</div>

<!-- ============================================================== -->
<!-- Statistics Boxes -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-md-3">
        <div class="stat-box bg-total-products">
            <i class="bi bi-boxes icon"></i>
            <h3>{{ $totalProducts }}</h3>
            <p>Total Products</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box bg-total-orders">
            <i class="bi bi-cart-check icon"></i>
            <h3>{{ $totalOrders }}</h3>
            <p>Total Orders</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box bg-total-revenue">
            <i class="bi bi-currency-exchange icon"></i>
            <h3>RM {{ number_format($totalRevenue, 2) }}</h3>
            <p>Total Revenue</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-box bg-total-users">
            <i class="bi bi-people-fill icon"></i>
            <h3>{{ $totalUsers }}</h3>
            <p>Total Users</p>
        </div>
    </div>
</div>




<div class="row mt-3">
    <div class="col-md-3">
        <div class="stat-box bg-pending-orders">
            <i class="bi bi-hourglass-split icon"></i>
            <h3>{{ $pendingOrders }}</h3>
            <p>Pending Orders</p>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- Charts (Bar & Pie) -->
<!-- ============================================================== -->
<div class="row mt-4">
    <!-- Sales Overview (Bar Chart) -->
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header text-white" style="background-color: #6b0909">
                <h5 class="mb-0">Sales Overview (Last 6 Months)</h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Order Status (Pie Chart) -->
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header text-white" style="background-color: #6b0909">
                <h5 class="mb-0">Order Status Distribution</h5>
            </div>
            <div class="card-body">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Sales Overview (Bar Chart)
        var salesCtx = document.getElementById("salesChart").getContext("2d");
        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlySalesLabels) !!},
                datasets: [{
                    label: "Sales (RM)",
                    data: {!! json_encode($monthlySalesData) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    hoverBackgroundColor: 'rgba(54, 162, 235, 0.9)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });

// Order Status (Doughnut Chart)
var orderCtx = document.getElementById("orderStatusChart").getContext("2d");
var orderStatusChart = new Chart(orderCtx, {
    type: 'doughnut',
    data: {
        labels: ["Pending", "Approved", "Completed", "Cancelled"],
        datasets: [{
            data: {!! json_encode($orderStatusData) !!},
            backgroundColor: ['#ff9900', '#3a3aff', '#008a27', '#6b0909'],
            borderColor: '#ffffff',
            borderWidth: 2,
            hoverOffset: 12
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '55%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: { size: 14, weight: 'bold' },
                    padding: 15
                }
            },
            tooltip: {
                callbacks: {
                    label: function (tooltipItem) {
                        let total = {!! json_encode(array_sum($orderStatusData)) !!};
                        let value = tooltipItem.raw;
                        let percentage = ((value / total) * 100).toFixed(1);
                        return `${tooltipItem.label}: ${value} (${percentage}%)`;
                    }
                }
            }
        }
    }
});



    });
</script>
@endsection
