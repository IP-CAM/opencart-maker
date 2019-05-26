<?php echo "<?php\n"?>

class Controller<?php echo $class_name;?> extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('<?php echo $path?>');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('<?php echo $path?>');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        // TODO: add controller logic
    }
}
