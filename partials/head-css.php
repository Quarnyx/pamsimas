<!-- Google Font Family link -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet">

<!-- Vendor css -->
<link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
<link href="DataTables/datatables.min.css" rel="stylesheet">

<script src="DataTables/datatables.min.js"></script>
<!-- alertifyjs Css -->
<link href="assets/js/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css" />

<!-- alertifyjs default themes  Css -->
<link href="assets/js/alertifyjs/build/css/themes/default.min.css" rel="stylesheet" type="text/css" />

<!-- Icons css -->
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />

<!-- App css -->
<link href="assets/css/style.min.css" rel="stylesheet" type="text/css" />

<!-- Theme Config js -->
<script src="assets/js/config.js"></script>
<style>
    .search-results {
        position: absolute;
        width: 100%;
        max-height: 250px;
        overflow-y: auto;
        background: white;
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 0.375rem 0.375rem;
        display: none;
        z-index: 1050;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .search-results.show {
        display: block;
    }

    .search-item {
        padding: 12px 15px;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.2s;
    }

    .search-item:hover {
        background: #f8f9fa;
    }

    .search-item:last-child {
        border-bottom: none;
    }

    .meter-display {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border-radius: 0.5rem;
        text-align: center;
        margin-bottom: 20px;
    }

    .meter-display .display-label {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .meter-display .display-value {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1;
    }

    .meter-display .display-unit {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-top: 5px;
    }

    .pemakaian-display {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .preview-image {
        max-width: 100%;
        max-height: 300px;
        border-radius: 0.5rem;
        margin-top: 15px;
    }

    .loading-spinner {
        text-align: center;
        padding: 15px;
    }

    @media (max-width: 768px) {
        .meter-display .display-value {
            font-size: 2rem;
        }
    }
</style>