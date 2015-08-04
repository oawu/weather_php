/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

$(function () {
  $('.pic[href]').fancybox ({
              padding: 0,
              margin: '70 30 30 30',
              helpers: {
                overlay: { locked: false },
                title: { type: 'over' },
                thumbs: { width: 50, height: 50 }
              }
           });
});