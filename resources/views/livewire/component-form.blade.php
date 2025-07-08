<div class="tpserver container pl-2 pr-2 pt-3 pb-24 max-w-full">
    <div class="container border shadow-sm rounded max-w-full" style="max-height: 100vh; overflow-y: unset;">
        <div class="row justify-content-center">
            <div class="col-lg-12 p-0">
                <div class="card shadow-sm rounded-4 m-0">
                    @if (session('info'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($view_form_content)
                        @include($view_form_content)
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .tpserver .gapflex {
            gap: 20px;
        }

        .tpserver .container {
            max-height: 65vh;
            overflow-y: auto;
        }

        .tpserver .alert .btn-close {
            margin-left: auto;
        }

        /* QR Frame Styles */
        .tpserver .qr-frame {
            position: relative;
            padding: 24px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            border: 2px solid transparent;
            background-clip: padding-box;
            max-width: 100%;
            max-height: 100%;
            overflow: hidden;
        }

        .tpserver .qr-frame::before,
        .tpserver .qr-frame::after {
            content: "";
            position: absolute;
            width: 36px;
            height: 36px;
            border-radius: 12px;
            box-sizing: border-box;
            background: white;
            box-shadow: inset 0 6px 6px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .tpserver .qr-frame::before {
            top: 6px;
            left: 6px;
            border-right: none;
            border-bottom: none;
        }

        .tpserver .qr-frame::after {
            bottom: 6px;
            right: 6px;
            border-left: none;
            border-top: none;
        }

        .tpserver .qr-frame img {
            border-radius: 12px;
            max-height: 220px;
            max-width: 220px;
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        /* Input & Button Interactions */
        .tpserver .input-hover:hover,
        .tpserver .input-hover:focus {
            border-color: #0d6efd;
        }

        .tpserver .input-hover:focus {
            box-shadow: 0 0 8px rgba(13, 110, 253, 0.4);
        }

        .tpserver .btn-hover:hover {
            background-color: #0b5ed7;
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Utilities */
        .tpserver .input-group-text {
            background-color: #e9ecef;
        }

        .tpserver textarea.form-control {
            resize: vertical;
        }

        .tpserver .bg-main {
            background-color: #4b6cb7 !important;
            color: white !important;
        }

        .tpserver .bg-light-subtle {
            background-color: #f9fafc;
        }

        .tpserver .opacity-50 {
            opacity: 0.5;
        }

        .tpserver .detail-container {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 10px;
            box-sizing: border-box;
        }

        .tpserver .list-group-item {
            padding: 8px 0;
            white-space: normal !important;
            overflow-wrap: break-word;
            max-width: 100%;
            box-sizing: border-box;
        }

        .tpserver .card-header h4,
        .tpserver .card-header h5,
        .tpserver .card-header i {
            vertical-align: middle;
        }

        .tpserver .icon-scale {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
    </style>
</div>
