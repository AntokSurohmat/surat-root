<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourcePresenter;

class Wilayah extends ResourcePresenter
{
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        $data = array(
            'title' => 'WILAYAH',
            'parent' => 2,
            'pmenu' => 2.4
        );
        return view('admin/wilayah/v-wilayah', $data);
    }

    /**
     * Present a view to present a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        $data = array(
            'title' => 'WILAYAH',
            'parent' => 2,
            'pmenu' => 2.4
        );
        return view('admin/wilayah/v-wilayahAddEdit', $data);
    }

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Present a view to edit the properties of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $data = array(
            'title' => 'WILAYAH Edit',
            'parent' => 2,
            'pmenu' => 2.4
        );
        return view('admin/wilayah/v-wilayahAddEdit', $data);
    }

    /**
     * Process the updating, full or partial, of a specific resource object.
     * This should be a POST.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Present a view to confirm the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function remove($id = null)
    {
        //
    }

    /**
     * Process the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
