   <?php
    public function login(){

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '<button class="close" data-dismiss="alert" class="close">&times;</button></div>');
        $config = array(
            array(
                'field' => 'pseudo',
                'label' => 'pseudo',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'password',
                'label' => 'mots de passe',
                'rules' => 'trim|required'
            ));
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()==FALSE){
            $this->layout->view('connexion');
        }else{
            $username=$this->input->post('pseudo');
            $password=$this->input->post('password');
            $login=$this->UserManager->login($username,$password);
            if (count($login)<=0){
                $this->session->set_flashdata(['infoserrone'=>'les informations de connexion sont erronées ']);
                $this->layout->view('connexion');
            }else{

            $this->session->set_userdata([
                'id'=>$login->id_user,
                'avatar'=>$login->avatar,
                'pseudo'=>$login->pseudo,
                'numeros'=>$login->numeros,
                'email'=>$login->mail
            ]);

            if (isset($_POST['remenberme']) && $_POST['remenberme']=='on'){

                $this->remenber_me();
            }

            $panier=$this->panierManager->read($this->session->userdata('id'));
            if (count($panier>0)){
                $this->session->set_userdata([
                    'paniercount'=>count($panier)]);
            }
            redirect(base_url(),'location',302);
        }
        }

    }