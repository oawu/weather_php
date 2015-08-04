<?php echo render_cell ('admin_frame_cell', 'header'); ?>

<div id='container' class='<?php echo !$frame_sides ? 'no_sides': '';?>'>
  <?php
  if (isset ($message) && $message) { ?>
    <div class='info'><?php echo $message;?></div>
<?php
  } ?>

  <form action='<?php echo base_url ('admin', 'satellites');?>' method='get'<?php echo $has_search ? ' class="show"' : '';?>>
    <div class='l'>
      <input type='text' name='id' value='<?php echo isset ($columns['id']) ? $columns['id'] : '';?>' placeholder='請輸入ID..' />
      <input type='text' name='pic_time' value='<?php echo isset ($columns['pic_time']) ? $columns['pic_time'] : '';?>' placeholder='請輸入圖檔時間..' />
    </div>
    <button type='submit' class='submit'>尋找</button>
    <!-- <a class='new' href='<?php echo base_url ('admin', 'satellites', 'add');?>'>新增</a> -->
  </form>
  <button type='button' onClick="if (!$(this).prev ().is (':visible')) $(this).attr ('class', 'search_feature icon-circle-up').prev ().addClass ('show'); else $(this).attr ('class', 'search_feature icon-circle-down').prev ().removeClass ('show');" class='search_feature icon-circle-<?php echo $has_search ? 'up' : 'down';?>'></button>

  <table class='table-list-rwd'>
    <tbody>
<?php if ($satellites) {
        foreach ($satellites as $satellite) { ?>
          <tr>
            <td data-title='ID' width='120'><?php echo $satellite->id;?></td>
            <td data-title='雲圖時間'><?php echo $satellite->pic_time;?></td>
            <td data-title='衛星雲圖' width='110'>
              <img src='<?php echo $satellite->pic->url ('100x100c');?>' href='<?php echo $satellite->pic->url ();?>' data-id='<?php echo $satellite->id;?>' class='fancybox_town pic' data-fancybox-group="group_special_pic"/>
            </td>
            <td data-title='執行時間' width='160' data-time='<?php echo $satellite->created_at;?>' class='created_at'><?php echo $satellite->created_at;?></td>
          </tr>
  <?php }
      } else { ?>
        <tr><td colspan>目前沒有任何資料。</td></tr>
<?php }?>
    </tbody>
  </table>
  <?php echo render_cell ('admin_frame_cell', 'pagination', $pagination);?>
</div>

<?php echo render_cell ('admin_frame_cell', 'footer');?>
