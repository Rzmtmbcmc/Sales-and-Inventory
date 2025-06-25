<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png')  }}">
    <!-- Page Title  -->
    <title>STI Web-Based Repository System</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dashlite.css?ver=2.4.0')  }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('admin/asasets/css/theme.css?ver=2.4.0')  }}">
</head>

<body class="nk-body bg-white npc-default pg-auth">


    <div class="row">

        <div class="col-md-4">

        </div>
        <div class="col-md-7">
            <div class="nk-app-root">
                <!-- main @s -->
                <div class="nk-main ">
                    <!-- wrap @s -->
                    <div class="nk-wrap nk-wrap-nosidebar">
                        <!-- content @s -->
                        <div class="nk-content ">
                            <div class="nk-split nk-split-page nk-split-md">
                                <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                                    <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                                        <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a>
                                    </div>
                                    <div class="nk-block nk-block-middle nk-auth-body">
                                        {{-- <div class="brand-logo pb-5">
                                            <a href="html/index.html" class="logo-link">
                                                <img class="logo-light logo-img logo-img-lg" src="{{ asset('assets/img/logo.jpg')  }}" srcset="{{ asset('assets/img/logo.jpg 2x')  }}" alt="logo">
                                                <img class="logo-dark logo-img logo-img-lg" src="{{ asset('assets/img/logo.jpg')  }}" srcset="{{ asset('assets/img/logo.jpg 2x')  }}" alt="logo-dark">
                                            </a>
                                        </div> --}}
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content">
                                                <h5 class="nk-block-title">Sign-In</h5>
                                            </div>

                                          @if(session()->has('mgs'))
                                                <div class="alert alert-success">
                                                {{ session()->get('mgs') }}
                                                </div>
                                            @endif

                                        </div><!-- .nk-block-head -->
                                        <form class="signup-form"  method="POST">
                                            <div id="login-Message"></div>
                                            {{-- action="{{ route('user.login') }}" --}}
                                            @csrf
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label" for="default-01">Email</label>
                                                </div>
                                                <input type="text" class="form-control form-control-lg" id="email" name="email" placeholder="Enter your email address">
                                                <span class="text-danger" id="email_mgs"></span>
                                            </div><!-- .foem-group -->
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label" for="password">Password</label>
                                                </div>
                                                <div class="form-control-wrap">
                                                    <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a>
                                                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your password">
                                                    <span class="text-danger" id="password_mgs"></span>
                                                </div>
                                            </div><!-- .foem-group -->
                                            <div class="form-group">
                                                <button class="btn btn-lg btn-primary btn-block btn-login-admin" >Sign in</button>
                                            </div>
                                        </form><!-- form -->
                                    </div><!-- .nk-block -->
                                </div><!-- .nk-split-content -->
                            </div><!-- .nk-split -->
                        </div>
                        <!-- wrap @e -->
                    </div>
                    <!-- content @e -->
                </div>
                <!-- main @e -->
            </div>

        </div>
    </div>


    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="{{ asset('admin/ssets/js/bundle.js?ver=2.4.0')}}"></script>
    <script src="{{ asset('admin/assets/js/scripts.js?ver=2.4.0')}}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>


    {{-- <script>

    $(document).ready(function() {
        $('.btn-login-admin').click(function(e) {
          e.preventDefault();

          // Show loading icon and disable button
          $('#button-text').hide();
          $('#button-loading').show();
          $('.btn-login-admin').attr('disabled', true);

            var email = $('#email').val();
            var password = $('#password').val();

          var timeout = setTimeout(function() {
              $('#button-text').show();
              $('#button-loading').hide();
              $('.btn-login-admin').attr('disabled', false);
          }, 2000);

            $.ajax({
                url: "{{ route('admin.loginaccount') }}",
                type: "POST",
                data: {
                    email: email,
                    password: password,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        $('#button-text').show();
                        $('#button-loading').hide();
                        $('#btn-submit').attr('disabled', false);
                        $('#login-Message').html('<div class="alert alert-success">Login successful!</div>');
                        window.location.href = "{{ route('admin.dashboard') }}";
                    } else {
                        $('#login-Message').html('<div class="alert alert-danger" role="alert">' + response.message + '</div>');
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';

                    if (errors.email) {
                        $('#email_mgs').html(errors.email[0]);
                    }

                    if (errors.password) {
                        $('#password_mgs').html(errors.password[0]);
                    }


                    $('#button-text').show();
                    $('#button-loading').hide();
                    $('#btn-submit').attr('disabled', false);
                }
            });
        });
    });

  </script> --}}



</html>
