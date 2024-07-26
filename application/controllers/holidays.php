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

    // To automatically generate weekend dates from the first date of current year until the next 5 years
    public function generateWeekends() {
        // Get the current year
        $currentYear = date('Y');
        
        // Generate weekend dates for the next 5 years
        $endDate = date('Y-m-d', strtotime('+5 years', strtotime($currentYear . '-01-01')));
        $weekendDates = $this->getWeekendDates($currentYear . '-01-01', $endDate);

        // Insert weekend dates into database using 'INSERT IGNORE'
        $this->Holiday_model->insertWeekendDates($weekendDates);

        echo json_encode(array(
            'success' => true,
            'message' => 'Weekend date has been generated successfully.',
        ));
    }

    private function getWeekendDates($startDate, $endDate) {
        $weekends = [];
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start, $interval, $end);

        foreach ($period as $date) {
            if ($date->format('N') == 6 || $date->format('N') == 7) { // 6 for Saturday, 7 for Sunday
                $weekends[] = $date->format('Y-m-d');
            }
        }

        return $weekends;
    }
}