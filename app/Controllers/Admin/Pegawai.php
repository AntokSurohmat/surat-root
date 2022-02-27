<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourcePresenter;

class Pegawai extends ResourcePresenter
{
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        $data = array(
            'title' => 'PEGAWAI',
            'parent' => 2,
            'pmenu' => 2.1
        );
        return view('admin/pegawai/v-pegawai', $data);
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
        //
    }

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
        $data = array(
            'title' => 'Tambah Instansi',
            'parent' => 2,
            'pmenu' => 2.1,
            'method' => 'New',
            'hiddenID' => '',
        );
        return view('admin/pegawai/v-pegawaiAddEdit', $data);
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
        //
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
