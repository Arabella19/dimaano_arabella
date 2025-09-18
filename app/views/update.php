<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Student</title>
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: #F5F5F5;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  form {
    background: #FFFFFF;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    width: 360px;
    animation: fadeIn 0.8s ease;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
  }

  h2 {
    text-align: center;
    color: #1C274C;
    margin-bottom: 20px;
    font-weight: 700;
  }

  label {
    font-weight: 600;
    color: #1C274C;
    margin-bottom: 6px;
    display: block;
  }

  input[type="text"],
  input[type="email"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 18px;
    border: 2px solid #E0E0E0;
    border-radius: 10px;
    outline: none;
    transition: 0.3s;
    font-size: 14px;
  }

  input[type="text"]:focus,
  input[type="email"]:focus {
    border-color: #4D8BFF;
    box-shadow: 0 0 6px rgba(77, 139, 255, 0.5);
  }

  input[type="submit"] {
    width: 100%;
    padding: 12px;
    background: #FFD338;
    border: none;
    border-radius: 10px;
    color: #1C274C;
    font-weight: 700;
    cursor: pointer;
    transition: 0.3s;
  }

  input[type="submit"]:hover {
    background: #F5C400;
    transform: scale(1.05);
  }

  .actions {
    margin-top: 15px;
    text-align: center;
  }

  .back-link {
    color: #4D8BFF;
    text-decoration: none;
    font-weight: 600;
  }

  .back-link:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

<form action="<?=site_url('/update/'.segment(3));?>" method="POST">
  <h2>Edit Student ✏️</h2>

  <label for="first_name">First Name</label>
  <input type="text" id="first_name" name="first_name" value="<?=$student['first_name'];?>" placeholder="Enter first name">

  <label for="last_name">Last Name</label>
  <input type="text" id="last_name" name="last_name" value="<?=$student['last_name'];?>" placeholder="Enter last name">

  <label for="email">Email</label>
  <input type="email" id="email" name="email" value="<?=$student['email'];?>" placeholder="you@example.com">

  <input type="submit" value="Update Student">

  <div class="actions">
    <a class="back-link" href="<?=site_url('get_all')?>">⬅ Back to Students</a>
  </div>
</form>

</body>
</html>
