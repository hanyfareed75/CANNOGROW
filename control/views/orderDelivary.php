<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Delivery</title>
  
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>

    <script src="https://cannigrow.free.nf/managment/views/js/orderDelivary.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
</head>
<body>
<?php include __DIR__.'/../components/navbar.php'; ?>
 

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="dateSelector">Select Date:</label>
                    <input type="date" class="form-control" id="dateSelector" 
                           value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="list-group">
                    <!-- Customer list will be dynamically populated here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true"  dir="ltr" lang="en">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailsModalLabel">Customer Orders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="orderDetailsContent">
                    <!-- Order details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <div class="row w-100">
                        <div class="col-md-6">
                            <select class="form-select" id="agentSelect">
                                <option value="">Select Agent...</option>
                            </select>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="row">
                               
                                <div class="col-md-6">
                                    <label for="orderValue">تكلفة المندوب:</label>
                                    <input type="number" class="form-control" id="agentfees" placeholder="Enter order value">
                                </div>
                                <div class="col-md-6">
                                    <label for="notes">Notes:</label>
                                    <textarea class="form-control" id="notes" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="assignAgent">Assign Agent</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
