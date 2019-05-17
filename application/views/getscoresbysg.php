<table class="table table-hover">
<tr><th><?php echo $this->lang->line('rank');?></th>
<th><?php echo $this->lang->line('first_name');?> <?php echo $this->lang->line('last_name');?></th>
<th><?php echo $this->lang->line('score_obtained');?></th>
<th><?php echo $this->lang->line('percentage_obtained');?></th>
</tr>
<?php 
 
foreach($quiz as $qk => $val){
 
?>
<tr><td><?php echo $qk+1;?></td><td><?php echo $val['first_name'];?> <?php echo $val['last_name'];?></td><td><?php echo $val['score_obtained'];?></td><td><?php echo $val['percentage_obtained'];?>%</td></tr>
<?php 
}
?>
</table>
