<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Migration_Add_satellites extends CI_Migration {
  public function up () {
    $this->db->query (
      "CREATE TABLE `satellites` (
        `id` int(11) NOT NULL AUTO_INCREMENT,

        `pic` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '衛星雲圖',
        `pic_time` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '圖檔時間',

        `updated_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '更新時間',
        `created_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '新增時間',
        PRIMARY KEY (`id`),
        KEY `pic_time` (`pic_time`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    );
  }
  public function down () {
    $this->db->query (
      "DROP TABLE `satellites`;"
    );
  }
}