<?php

namespace App\Controllers;

use App\Models\Comment;

class CommentController extends BaseController
{

    public function store()
    {
        if (!check_auth()) {
            echo json_encode(['status' => 'error', 'redirect' => LOGIN_PAGE]);
            die;
        }

        $model = new Comment();
        $model->loadData();

        if (!$model->validate()) {
            echo json_encode(['status' => 'error', 'data' => $model->listErrors()]);
            die;
        }
        if (!$model->checkPostId()) {
            echo json_encode(['status' => 'error', 'data' => 'Error post']);
            die;
        }
        if (!$model->checkParentId()) {
            echo json_encode(['status' => 'error', 'data' => 'Error comment']);
            die;
        }

        if ($model->saveComment()) {
            echo json_encode(['status' => 'success', 'data' => 'Comment added. Refresh the page to see it.']);
        } else {
            echo json_encode(['status' => 'error', 'data' => 'Some error']);
        }
        die;
    }

}