<?php
echo "<?php\n";
?>

class Controller<?php echo $class_name; ?> extends Controller {
	public function index($setting) {
      $data = [
          'module_name' => '<?php echo $module_name;?>',
      ];

      return $this->load->view('<?php echo $path;?>', $data);
	}
}
