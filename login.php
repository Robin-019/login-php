<?php

// require "(CONFIG NAAR DATABASE)";

session_start();

// Checkt of je al ben ingelogd, zo ja? dan kan je niet nog eens inloggen
if (isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] === TRUE) {
    header("location: index.php");
    exit;
}

// Genereerd de CSRF token
$_SESSION['token'] = bin2hex(random_bytes(32));
$token = $_SESSION['token'];

?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" defer></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous" defer></script>
	</head>
	<body>
		<div class="h-100 d-flex justify-content-center align-items-center">
			<div class="rounded d-flex flex-column align-items-center customwidth-400 p-4 shadow-sm bg-light">
				<h1 class="border-bottom pb-3">Login</h1>
				<form action="auth.php" method="post">
					<div class="d-flex flex-column">
                        <input type="hidden" name="token" id="token" value="<?= $token; ?>" />
						<div class="mb-2 d-flex">
							<label for="username" class="customlabel rounded-start">
								<i class="fas fa-user"></i>
							</label>
							<input class="customtext rounded-end" type="text" name="username" placeholder="Username" id="username" required>
						</div>
						<div class="mb-2 d-flex">
							<label for="password" class="customlabel rounded-start">
								<i class="fas fa-lock"></i>
							</label>
							<input class="customtext rounded-end" type="password" name="password" placeholder="Password" id="password" required>
						</div>
                        <div>
                            <p class="text-center" id="message"></p>
                        </div>
						<input class="customsubmit rounded" type="submit" value="login" name="login" id="submit" >
					</div>
				</form>
			</div>
		</div>
	</body>
    <script>
        // Dubbele checks zowel frontend als backend (Zie auth.php)
        $(document).ready(function () {
            $("#submit").click(function (e) {
                e.preventDefault()
                let user = $("#username").val();
                let pass = $("#password").val();
                let token = $("#token").val();
                if (user.length == "" || pass.length == ""){
                    $("#message").html("Vul alle velden in")
                    $("#message").addClass("text-danger")
                    return false;
                } else {
                    // Met behulp van ajax krijg je netjes de errors zonder dat je naar andere pagina gaat
                    $.ajax({
                        type: "POST",
                        url: "./auth.php",
                        data: {token: token, user: user, pass: pass},
                        success: function (feedback) {
                            $("#message").html(feedback)
                            $("#message").addClass("text-danger")
                        }
                    })
                }
            })
        })

    </script>

    <style>
    html,
    body {
        height: 100%;
    }

    .customwidth-400 {
        width: 400px;
    }

	.customlabel {
		display: flex;
		justify-content: center;
		align-items: center;
		width: 50px;
		height: 50px;
		background-color: #8fe507;
		color: #ffffff;
	}

	.customtext {
		width: 310px;
		height: 50px;
		border: 1px solid #dee0e4;
		margin-bottom: 20px;
		padding: 0 15px;
	}

	.customsubmit {
		width: 100%;
		padding: 15px;
		margin-top: 20px;
		background-color: #8fe507;
		border: 0;
		cursor: pointer;
		font-weight: bold;
		color: #ffffff;
		transition: background-color 0.2s;
	}

	.customsubmit:hover {
		background-color: rgb(120, 230, 7);
  		transition: background-color 0.2s;
	}
    </style>



</html>
