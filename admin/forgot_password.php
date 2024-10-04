<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Madridejos Home Residence Management System</title>
    <link rel="icon" type="x-icon" href="../img/lg.png">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <style>
        body {
            background-image: url('../img/received_1185064586170879.jpeg');
            background-attachment: fixed;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }
        /* Custom alert styling */
        .custom-alert {
            padding: 15px;
            border-radius: 5px;
            margin-top: -10px;
            margin-left: -12px;
            display: inline-block;
            width: 100%;
        }
        /* Danger alert styling */
        .custom-alert-danger {
            background-color: transparent;
            color: #721c24;
        }
        /* Success alert styling (if needed for success messages) */
        .custom-alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .container {
            margin-top: 100px;
            max-width: 400px;
            background-color: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group label {
            color: #555;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background: rgba(200,0,0,1);
            border-color: #007bff;
            width: 29%;
            padding: 10px;
            font-size: 16px;
            text-align: center;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(184deg, rgba(200,0,0,1) 40%, rgba(50,50,50,1) 92%);
            transform: scale(1.05);
        }
        .btn-secondary{
            background: rgba(0,123,200,1); 
            border-color: #007bff;
            color: white;
            margin-left: 147px;
            width: 29%;
            padding: 10px;
            font-size: 16px;
            text-align: center;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .btn-secondary:hover {
            background: linear-gradient(184deg, rgba(0,123,255,1) 40%, rgba(0,0,139,1) 92%);
            transform: scale(1.05);
            color: white;
        }
        .alert {
            margin-top: 20px;
        }
        p{
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container" style="margin-top: -4px;">
        <h2>Forgot Password</h2>
        <p>Enter the email address associated with your account and we will send you a link to reset your password.</p>
        <form action="reset_password.php" method="POST">
            <div class="form-group">
                <label for="email">Enter your email address:</label>
                <input type="email" class="form-control" name="email" placeholder="Ex. Jose@gmail.com" required>
            </div>
            <button type="submit" name="password_reset_link" class="btn btn-primary">Send</button>
            <a href="../admin/login.php?pages=login" class="btn btn-secondary">Cancel</a> <!-- Cancel button -->
        </form>
    </div>
</body>
</html>