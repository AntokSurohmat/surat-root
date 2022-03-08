function view_datasss()
    {

        if ($this->request->getVar('id')) {
            $data = $this->spt->where('id', $this->request->getVar('id'))->first();
            // d(json_decode($data['nama_pegawai']));print_r(json_decode($data['nama_pegawai']));die();
            $nama = $this->spt->where('id', $this->request->getVar('id'))->get();
            foreach ($nama->getResultArray() as $row) {
                d(json_decode($row['nama_pegawai']));print_r(json_decode($row['nama_pegawai']));
                $namanya = json_decode($row['nama_pegawai']);
                // d(json_decode($row['nama_pegawai']));print_r(json_decode($row['nama_pegawai']));
                // d(json_encode($row['nama_pegawai']));print_r(json_encode($row['nama_pegawai']));die();

                foreach (json_decode($row['nama_pegawai']) as $rew) {
                    // d($rew);print_r($rew);die();
                    $query = $this->pegawai->where('nama', $rew)->get();
                    $data['ok'] = $query->getResult();
                    d($data['ok']);print_r($data['ok']);die();
                }
                
            }
            
            
            $data['pegawai'] = $this->pegawai->where('nip', $data['diperintah'])->first();
            $data[$this->csrfToken] = $this->csrfHash;
            // print_r($data[0]);
            echo json_encode($data);
        }
    }
