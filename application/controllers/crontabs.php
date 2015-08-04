<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Crontabs extends Site_controller {

  public function __construct () {
    parent::__construct ();
  }
  public function get_all_satellite ($psw) {
    if (md5 ($psw) != '6d499b8cebdc1464c46cc22a201036bd')
      return;

    for ($i = 2; $i < 5; $i++) { 
      for ($j = 0; $j < 24; $j++) { 
        $time = sprintf ('2015-08-%02d %02d:00:00', $i, $j);
        $time_key = sprintf ('2015-08-%02d-%02d-00', $i, $j);
        $url = 'http://www.cwb.gov.tw/V7/observe/satellite/Data/HS1P/HS1P-' . $time_key . '.jpg';

        $params = array (
            'pic' => '',
            'pic_time' => $time,
          );
        if (verifyCreateOrm ($satellite = Satellite::create ($params)))
          if (!$satellite->pic->put_url ($url))
            $satellite->destroy ();
        echo "sleep " . $time . "\n";
        sleep(1);
        $time = sprintf ('2015-08-%02d %02d:30:00', $i, $j);
        $time_key = sprintf ('2015-08-%02d-%02d-30', $i, $j);
        $url = 'http://www.cwb.gov.tw/V7/observe/satellite/Data/HS1P/HS1P-' . $time_key . '.jpg';

        $params = array (
            'pic' => '',
            'pic_time' => $time,
          );

        if (verifyCreateOrm ($satellite = Satellite::create ($params)))
          if (!$satellite->pic->put_url ($url))
            $satellite->destroy ();
        echo "sleep " . $time . "\n";
        sleep(1);
      }
    }
  }

  public function get_satellite ($psw) {
    $log = CrontabLog::start ('每 30 分鐘，雷達雲圖 get_satellite');

    if (md5 ($psw) != '6d499b8cebdc1464c46cc22a201036bd')
      return $log->error ('密碼錯誤！');

    $time = date (sprintf ('Y-m-d H:%02d:00', floor (date ('i') / 30) * 30));
    $time_key = date (sprintf ('Y-m-d-H-%02d', floor (date ('i') / 30) * 30));

    if (Satellite::find ('one', array ('select' => 'id', 'conditions' => array ('pic_time = ?', $time_key))))
      return $log->error ('Satellite 重複 time_key：' . $time_key);

    $url = 'http://www.cwb.gov.tw/V7/observe/satellite/Data/HS1P/HS1P-' . $time_key . '.jpg';
    $params = array (
        'pic' => '',
        'pic_time' => $time,
      );

    if (!verifyCreateOrm ($satellite = Satellite::create ($params)))
      return $log->error ('Create Satellite 失敗');

    if (!$satellite->pic->put_url ($url)) {
      $satellite->destroy ();
      return $log->error ('Satellite put_url 失敗');
    }

    $log->finish ();
  }
  public function test ($psw) {
    if (md5 ($psw) != '6d499b8cebdc1464c46cc22a201036bd')
      return ;
    echo "Yes";
  }

  public function clean_all_github_cell ($psw) {
    $log = CrontabLog::start ('清除 update_weather 完成後');

    if (md5 ($psw) != '6d499b8cebdc1464c46cc22a201036bd')
      return $log->error ('密碼錯誤！');

    clean_cell ('github_cell', '*');
    $log->finish ();
  }
  public function clean_query ($psw) {
    $log = CrontabLog::start ('每 30 分鐘，清除 query logs');

    if (md5 ($psw) != '6d499b8cebdc1464c46cc22a201036bd')
      return $log->error ('密碼錯誤！');
    
    $this->load->helper ('file');
    write_file (FCPATH . 'application/logs/query.log', '', FOPEN_READ_WRITE_CREATE_DESTRUCTIVE);

    $log->finish ();
  }
  public function weather_all ($psw) {
    $log = CrontabLog::start ('每 60 分鐘，清除 update_weather');

    if (md5 ($psw) != '6d499b8cebdc1464c46cc22a201036bd')
      return $log->error ('密碼錯誤！');

    foreach (Town::all (array ('order' => 'RAND()')) as $town) {
      clean_cell ('town_cell', 'update_weather', $town->id);
      $town->update_weather ();
    }

    $this->clean_all_github_cell ($psw);

    $log->finish ();
  }
}
