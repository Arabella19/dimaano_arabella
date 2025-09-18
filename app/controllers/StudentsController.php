<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentsController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->library('pagination');
        $this->call->library('session'); 
    }

    public function get_all($page = 1)
    {
        try {
            $per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
            $allowed_per_page = [10, 25, 50, 100];
            if (!in_array($per_page, $allowed_per_page)) $per_page = 10;

            $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

            $total_rows = $this->StudentsModel->count_filtered_records($keyword);

            $page = max(1, (int)$page);
            $offset = ($page - 1) * $per_page;
            $limit_clause = "LIMIT {$offset}, {$per_page}";

            $pagination_data = $this->pagination->initialize(
                $total_rows, $per_page, $page, 'get_all', 5
            );

            if ($keyword !== '') {
                $data['students'] = $this->StudentsModel->searchStudents($keyword, $limit_clause);
            } else {
                $data['students'] = $this->StudentsModel->get_records_with_pagination($limit_clause);
            }

            $data['total_records'] = $total_rows;
            $data['pagination_data'] = $pagination_data;
            $data['pagination_links'] = $this->pagination->paginate();
            $data['keyword'] = $keyword;

            $this->call->view('get_all', $data);

        } catch (Exception $e) {
            $error_msg = urlencode($e->getMessage());
            redirect('get_all/1?error=' . $error_msg);
        }
    }

    public function create() {
        if($this->form_validation->submitted()){
            $first_name = $this->io->post('first_name');
            $last_name = $this->io->post('last_name');
            $email = $this->io->post('email');
            $this->StudentsModel->create($first_name, $last_name, $email);
        }
        $this->call->view('create');
    }

    function update($id) {
        $student = $this->StudentsModel->find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'first_name' => $_POST['first_name'],
                'last_name'  => $_POST['last_name'],
                'email'      => $_POST['email']
            ];
            $this->StudentsModel->update($id, $data);
            redirect('get_all');
        }
        $this->call->view('/update', ['student' => $student]);
    }

    function delete($id) {
        $this->StudentsModel->delete($id);
        redirect('get_all');
    }

    public function search()
    {
        $keyword = $_GET['keyword'] ?? '';
        $results = $this->StudentsModel->searchStudents($keyword);

        if (!empty($results)) {
            foreach ($results as $row) {
                echo '
                <tr>
                     <td>' . htmlspecialchars($row['id']) . '</td>
                    <td>' . htmlspecialchars($row['first_name']) . '</td>
                    <td>' . htmlspecialchars($row['last_name']) . '</td>
                    <td>' . htmlspecialchars($row['email']) . '</td>
                    <td class="actions">
                        <a href="' . site_url('/update/'.$row['id']) . '" class="btn update">Update</a>
                        <a href="' . site_url('/delete/'.$row['id']) . '" 
                           class="btn delete"
                           onclick="return confirm(\'Are you sure you want to delete this record?\');">
                           Delete
                        </a>
                    </td>
                </tr>';
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>No results found</td></tr>";
        }
    }
}
