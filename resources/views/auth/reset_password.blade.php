<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pembo Mart | Password Set</title>

    <style type="text/css">
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            padding: 0 10px;
            font-family: 'Poppins', sans-serif;
        }

        .wrapper {
            background: linear-gradient(135deg, #2dce89, #28a745);
            max-width: 450px;
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease-in-out;
        }

        .wrapper:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .form header {
            font-size: 26px;
            font-weight: 700;
            padding-bottom: 10px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 3px solid rgba(255, 255, 255, 0.3);
        }

        .form form {
            margin: 20px 0;
        }

        .form form .field {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
            position: relative;
        }

        .form form .field label {
            margin-bottom: 5px;
            color: #fff;
            font-weight: 600;
        }

        .form form .input input {
            height: 45px;
            width: 24.5vw;
            font-size: 16px;
            padding: 0 15px;
            border-radius: 8px;
            border: none;
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            transition: all 0.3s ease;
        }

        .form form .input input:focus {
            background: rgba(255, 255, 255, 0.3);
        }

        .form form .button input {
            height: 50px;
            border: none;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            background: linear-gradient(135deg, #ff105f, #ffad06);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 5px 15px rgba(255, 105, 135, 0.4);
        }

        .form form .button input:hover {
            background: linear-gradient(135deg, #ffad06, #ff105f);
            transform: scale(1.05);
        }

        .form .link {
            text-align: center;
            margin: 15px 0;
            font-size: 17px;
            color: #fff;
            font-weight: 500;
        }

        .form .link a {
            color: #ffad06;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .form .link a:hover {
            color: #ff105f;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <section class="form login">
            <header style="color: white;">Reset Password</header>

            <form action="{{ route('set.new.password', $token) }}" method="POST">
                {{ csrf_field() }}
                <div class="field input">
                    <label for=""></label>
                    <input type="password" name="password" placeholder="Enter New Password" required>
                    @if ($errors->has('password'))
                        <span class="text-danger">
                            {{ $errors->first('password') }} <br>
                            Password must include at least:
                            <ul>
                                <li>One uppercase letter</li>
                                <li>One lowercase letter</li>
                                <li>One number</li>
                                <li>One special character</li>
                            </ul>
                        </span>
                    @endif
                </div>
                <div class="field input">
                    <label for=""></label>
                    <input type="password" name="confirm_password" placeholder="Enter Confirm Password" required>
                    @error('confirm_password')
                        <div class="text-danger">
                            {{ $message }}<br>
                            {{-- {{ __('The confirmation password must match the password.') }} --}}
                        </div>
                    @enderror

                </div>

                <div class="field button">
                    <input type="submit" value="RESET PASSWORD" style="margin-top: 23px;">
                </div>
            </form>
        </section>
    </div>

</body>

</html>
