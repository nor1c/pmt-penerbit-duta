<?php

class Holidays extends DUTA_Controller {
    private $searchableFields = ['date', 'title'];
    
    public function __construct()
    {
        parent::__construct();
        loadModel('Holiday_model');
    }

    public function index() {
        $this->template->display('holidays/index');
    }

    public function getAll() {
        $pagination = array(
            'start' => $this->input->post('start'),
            'length' => $this->input->post('length')
        );

        $search = inputPost('search')['value'];
        $filters = explode('&', $this->input->post('filters'));
        
        $holidays = $this->Holiday_model->getAll($this->searchableFields, $search, $filters, $pagination);

        $formattedData = array_map(function ($item) {
            return ['', $item['date'], $item['title']];
        }, $holidays['data']);

        $data = [
            'recordsTotal' => $holidays['recordsTotal'],
            'recordsFiltered' => $holidays['recordsTotal'],
            'data' => $formattedData
        ];
        
        echo json_encode($data);
    }

    public function checkDate() {
        $dateToCheck = inputGet('date');

        $pickedDate = $this->Holiday_model->checkDate($dateToCheck);

        echo json_encode($pickedDate);
    }

    public function create() {
        $data = inputPost();
        $data['date'] = convertDateFormat($data['date']);

        $result = $this->Holiday_model->create($data);

        echo json_encode($result);
    }
}