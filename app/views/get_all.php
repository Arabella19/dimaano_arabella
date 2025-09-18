<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Management</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #F5F5F5;
      margin: 0;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #1C274C;
      margin-bottom: 20px;
    }

    .top-actions {
      text-align: center;
      margin-bottom: 20px;
    }

    .btn-add {
      background: #4D8BFF;
      color: #fff;
      border: none;
      padding: 12px 20px;
      font-weight: 600;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }
    .btn-add:hover {
      background: #356BDD;
    }

    .search-container {
      text-align: center;
      margin-bottom: 20px;
    }

    .search-box {
      width: 50%;
      padding: 12px;
      border: 2px solid #E0E0E0;
      border-radius: 8px;
      font-size: 14px;
      outline: none;
    }

    .search-box:focus {
      border-color: #4D8BFF;
      box-shadow: 0 0 6px rgba(77, 139, 255, 0.4);
    }

    table {
      margin: 0 auto;
      border-collapse: collapse;
      width: 90%;
      background: #FFFFFF;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    th, td {
      padding: 12px;
      text-align: center;
    }

    th {
      background: #FFD338;
      color: #1C274C;
    }

    tr:nth-child(even) {
      background: #FAFAFA;
    }

    .actions .btn {
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 13px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn.update {
      background: #4D8BFF;
      color: white;
    }
    .btn.update:hover {
      background: #356BDD;
    }

    .btn.delete {
      background: #FF6B6B;
      color: white;
    }
    .btn.delete:hover {
      background: #E63939;
    }

    
    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .pagination ul {
      list-style-type: none; 
      display: flex;
      gap: 10px;
      padding: 0;
      margin: 0;
    }

    .pagination li {
      list-style-type: none;
    }

    .pagination a, .pagination span {
      padding: 8px 12px;
      background: #E0E0E0;
      border-radius: 6px;
      text-decoration: none;
      color: #1C274C;
      font-weight: 600;
    }

    .pagination .current {
      background: #4D8BFF;
      color: #fff;
    }
  </style>
</head>
<body>

  <h1>📋 Student Management</h1>

  <div class="top-actions">
    <a href="<?=site_url('create')?>"><button class="btn-add">+ Add Student</button></a>
  </div>

  <div class="search-container">
    <input type="text" id="searchInput" class="search-box" placeholder="Search students...">
  </div>

  <table id="studentTable">
    <thead>
      <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($students as $students): ?>
        <tr>
          <td><?=$students['id']?></td>
          <td><?=$students['first_name']?></td>
          <td><?=$students['last_name']?></td>
          <td><?=$students['email']?></td>
          <td class="actions">
            <a href="<?= site_url('/update/'.$students['id']); ?>" class="btn update">Update</a>
            <a href="<?= site_url('/delete/'.$students['id']); ?>" class="btn delete"
               onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="pagination">
    <?= isset($pagination_links) ? $pagination_links : '' ?>
  </div>

  <script>
    let typingTimer;
    document.getElementById("searchInput").addEventListener("keyup", function() {
      clearTimeout(typingTimer);
      let keyword = this.value;

      typingTimer = setTimeout(() => {
        fetch("<?= site_url('students/search') ?>?keyword=" + keyword)
          .then(res => res.text())
          .then(data => {
            document.querySelector("#studentTable tbody").innerHTML = data;
          });
      }, 300);
    });
  </script>

</body>
</html>
