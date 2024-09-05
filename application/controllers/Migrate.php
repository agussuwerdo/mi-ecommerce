<?php
class Migrate extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('migration');
  }

  public function index()
  {
    $this->benchmark->mark('code_start');
    // Find all migrations, default to empty array if none are found
    $migrations = $this->migration->find_migrations() ?: [];

    // Get the highest version number
    $latest_version = max(array_keys($migrations)) ?: '000';

    // Run the migration to the latest version
    if ($this->migration->version($latest_version) === FALSE) {
      show_error($this->migration->error_string());
    } else {
      echo 'Migration to the latest version (' . $latest_version . ') completed successfully!';
    }
    $this->benchmark->mark('code_end');
    echo '<br>Completed in ' . $this->benchmark->elapsed_time('code_start', 'code_end') . ' seconds';
  }

  public function version($version_to_run)
  {
    $this->benchmark->mark('code_start');
    // Run the migration to selected version
    if ($this->migration->version($version_to_run) === FALSE) {
      show_error($this->migration->error_string());
    } else {
      echo 'Migration to version ' . $version_to_run . ' completed successfully!';
    }
    $this->benchmark->mark('code_end');
    echo '<br>Completed in ' . $this->benchmark->elapsed_time('code_start', 'code_end') . ' seconds';
  }

  public function list()
  {
    $this->benchmark->mark('code_start');
    print_r($this->migration->find_migrations());
    $this->benchmark->mark('code_end');
    echo '<br>Completed in ' . $this->benchmark->elapsed_time('code_start', 'code_end') . ' seconds';
  }
}
