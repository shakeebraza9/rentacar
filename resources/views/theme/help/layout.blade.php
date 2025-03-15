<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset(getset('fav_icon')) }}" type="image/x-icon" rel="icon">
    <title>{{ getset('site_title') }} Help Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



    <meta data-n-head="ssr" charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary-color: #00c853;
            --primary-dark: #009624;
            --primary-light: #5efc82;
            --text-color: #333;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }

        .header {
            background-color: var(--primary-color);
            padding: 15px 0;
            color: white;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 66%;
            height: 60px;

            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .logo i {
            color: var(--primary-color);
            font-size: 24px;
        }

        .search-container {
            margin: 20px 0;
        }

        .search-input {
            border-radius: 25px;
            padding: 12px 20px;
            border: 1px solid #ddd;
            width: 100%;
        }

        .category-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: var(--text-color);
        }

        .faq-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 15px;
            background-color: white;
            transition: all 0.3s ease;
        }

        .faq-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-color: var(--primary-color);
        }

        .faq-question {
            color: var(--primary-color);
            font-weight: 500;
            margin-bottom: 5px;
        }

        .faq-meta {
            color: #888;
            font-size: 12px;
        }

        .sidebar-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .sidebar-icon {
            font-size: 40px;
            color: var(--primary-color);
            margin-bottom: 15px;
            text-align: center;
        }

        .user-avatars {
            display: flex;
            margin-top: 15px;
        }

        .avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #ddd;
            margin-right: -10px;
            border: 2px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: white;
        }

        .avatar:nth-child(1) {
            background-color: #FF9800;
        }

        .avatar:nth-child(2) {
            background-color: #2196F3;
        }

        .avatar:nth-child(3) {
            background-color: #4CAF50;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            color: var(--text-color);
            text-decoration: none;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .sidebar-link:last-child {
            border-bottom: none;
        }

        .sidebar-link i {
            color: var(--primary-color);
            margin-right: 10px;
            font-size: 20px;
        }

        .sidebar-link:hover {
            color: var(--primary-color);
        }

        .breadcrumb {
            background-color: transparent;
            padding: 10px 0;
        }

        .nav-link {
            color: white;
            margin-left: 20px;
        }

        .nav-link:hover {
            color: rgba(255,255,255,0.8);
        }

        #kb-footer {
            background: #fff;
            padding: 10px 10%;
            min-height: 70px
        }

        #kb-footer,
        #kb-footer #footer-content {
            width: 100%;
            display: -moz-flex;
            display: flex;
            -moz-align-items: center;
            align-items: center
        }

        #kb-footer #footer-content {
            position: relative;
            height: 100%
        }

        #kb-footer .logo {
            width: 30px;
            height: 30px;
            -moz-flex: none;
            flex: none
        }

        #kb-footer .logo img {
            width: 100%;
            height: 100%
        }

        #kb-footer #branding {
            font-size: 15px;
            color: #9c9aa6;
            text-align: center;
            -moz-flex: 1 1 auto;
            flex: 1 1 auto
        }

        #kb-footer #branding #branding-text {
            display: inline-block;
            padding: 8px 15px
        }

        #kb-footer #branding #branding-text:hover {
            background: #fafafa;
            border-radius: 3px
        }

        #kb-footer #branding img {
            margin-left: -5px;
            margin-right: -5px;
            height: 3ex;
            width: auto;
            min-height: 20px;
            min-width: 20px;
            display: inline-block;
            vertical-align: middle
        }

        #kb-footer #branding #tawkto-link {
            direction: ltr;
            color: #9c9aa6;
            -moz-justify-content: center;
            justify-content: center
        }

        #kb-footer #branding #tawkto-link,
        #kb-footer #social-links {
            display: -moz-flex;
            display: flex;
            -moz-align-items: center;
            align-items: center
        }

        #kb-footer #social-links {
            position: absolute;
            -moz-flex: none;
            flex: none
        }

        #kb-footer #social-links.left {
            left: 0
        }

        #kb-footer #social-links.right {
            right: 0
        }

        #kb-footer #social-links .social-icon {
            width: 40px;
            height: 40px;
            display: -moz-flex;
            display: flex;
            -moz-align-items: center;
            align-items: center;
            -moz-justify-content: center;
            justify-content: center
        }

        #kb-footer #social-links .social-icon:hover {
            background: #fafafa;
            border-radius: 3px
        }
    </style>
    @yield('css')
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container" style="max-width:99%;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="logo-container">
                        <a href="{{ route('home') }}" class="logo d-flex align-items-center text-decoration-none">
                            <img src="{{ asset(getset('fav_icon')) }}" alt="Logo" style="width:100px; height:90px;">
                            <h3 style="font-size: 20px; color:white;"> {{ getset('site_title') }} Help Center</h3>
                        </a>
                    </div>

                </div>
                <div class="col-md-6 text-end">
                    <a id="ticket-submit-link" href="javascript:void(0);" class="nav-link d-inline-block">Submit Ticket</a>
                    <a href="{{ route('home') }}" class="nav-link d-inline-block">Our Website</a>
                </div>
            </div>
        </div>
        @yield("search")
        <div class="container search-container" style="margin-top:20px;width:100%;margin-left: 134px;">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="input-group" style="max-width:90%; margin:auto;">
                        <input type="text" id="search-input" class="form-control" placeholder="Search for answers"
                            style="border-radius:0; padding:12px 20px; border:1px solid #ddd;">
                        <span class="input-group-text bg-white border-start-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        

        
        
    </header>
    <ul id="search-results" class="faq-list mt-3" style="position: absolute;
  top: 131px;
  right: 12%;
  width: 74%;background-color:white;z-index:999; border:1px soild #00c853;">
    </ul>






   @yield('content')

   <footer id="kb-footer">
    <div id="footer-content">

        <div id="social-links" class="left" style="display:;">
          <a href="{{ getset('facebook_link') }}" target="_blank" class="social-icon"><svg width="20" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.538 5.329a1.2 1.2 0 11-2.4 0 1.2 1.2 0 012.4 0zM10 14a3.333 3.333 0 110-6.666A3.333 3.333 0 0110 14zm0-8.468a5.135 5.135 0 100 10.27 5.135 5.135 0 000-10.27zm0-3.063c2.67 0 2.986.01 4.04.058.976.044 1.505.207 1.858.344.466.182.8.398 1.15.748.35.35.566.683.748 1.15.137.353.3.882.344 1.857.048 1.055.058 1.37.058 4.041 0 2.67-.01 2.986-.058 4.04-.044.976-.207 1.505-.344 1.858-.182.466-.398.8-.748 1.15-.35.35-.683.566-1.15.748-.353.137-.882.3-1.857.344-1.055.048-1.37.058-4.041.058-2.67 0-2.987-.01-4.04-.058-.976-.044-1.505-.207-1.858-.344a3.099 3.099 0 01-1.15-.748 3.099 3.099 0 01-.748-1.15c-.137-.353-.3-.882-.344-1.857-.048-1.055-.058-1.37-.058-4.04 0-2.671.01-2.987.058-4.042.044-.975.207-1.504.344-1.857.182-.466.398-.8.748-1.15.35-.35.683-.566 1.15-.748.353-.137.882-.3 1.857-.344 1.055-.048 1.37-.058 4.041-.058zm0-1.802c-2.716 0-3.056.011-4.123.06-1.064.048-1.791.218-2.427.465a4.9 4.9 0 00-1.772 1.153A4.9 4.9 0 00.525 4.116C.278 4.753.109 5.48.06 6.544.012 7.61 0 7.95 0 10.667s.012 3.056.06 4.123c.049 1.064.218 1.791.465 2.427a4.9 4.9 0 001.153 1.771 4.902 4.902 0 001.772 1.154c.636.247 1.363.416 2.427.465 1.067.048 1.407.06 4.123.06s3.056-.012 4.123-.06c1.064-.049 1.791-.218 2.427-.465a4.903 4.903 0 001.772-1.154 4.902 4.902 0 001.153-1.77c.247-.637.416-1.364.465-2.428.048-1.067.06-1.407.06-4.123s-.012-3.057-.06-4.123c-.049-1.065-.218-1.791-.465-2.428a4.902 4.902 0 00-1.153-1.77 4.903 4.903 0 00-1.772-1.154c-.636-.247-1.363-.417-2.427-.465C13.056.678 12.716.667 10 .667z" fill="#9C9AA6"></path>
                </svg></a>
          <a href="{{ getset('instagram_link') }}" target="_blank" class="social-icon"><svg width="10" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.293 7.143H6.128V5.067c0-.78.517-.961.88-.961h2.234V.679L6.166.667c-3.414 0-4.191 2.556-4.191 4.191v2.285H0v3.531h1.975v9.993h4.153v-9.993h2.803l.362-3.531z" fill="#9C9AA6"></path>
                </svg></a></div>
    </div>
</footer>


<div class="modal fade" id="ticketModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title mx-auto">Submit Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="ticket-form">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="ticket-name" placeholder="Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="ticket-email" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="ticket-subject_input" placeholder="Subject" required>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" id="ticket-message_input" placeholder="Message" required></textarea>
                    </div>
                    <button type="button" class="btn btn-light text-secondary w-100">Submit Request</button>
                </form>
            </div>
            <div class="modal-footer bg-light"></div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
    $(document).ready(function() {
        // Open Modal on Click
        $('#ticket-submit-link').click(function() {
            $('#ticketModal').modal('show');
        });
        $('#ticket-form button').click(function(e) {
            e.preventDefault();

            const formData = {
                name: $('#ticket-name').val(),
                email: $('#ticket-email').val(),
                subject: $('#ticket-subject_input').val(),
                message: $('#ticket-message_input').val()
            };
            $.ajax({
                type: 'POST',
                url: '/submit-report',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert('Form submitted successfully!');
                },
                error: function(error) {
                    alert('Something went wrong!');
                }
            });
        });



        $('#search-input').on('keyup', function () {
            let query = $(this).val();
            if (query.length > 2) { // Only search if input is more than 2 characters
                $.ajax({
                    url: "{{ route('help.search') }}",
                    type: "GET",
                    data: { search: query },
                    success: function (response) {
                        $('#search-results').html(response);
                    }
                });
            } else {
                $('#search-results').html('');
            }
        });

    });


</script>

    @yield(section: 'js')

</body>


</html>
