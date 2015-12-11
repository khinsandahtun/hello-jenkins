<!--
  @author Su Zin Kyaw
  @since  2015/11 /06-->
<!--Show Drop Down list for month-->

<?php
    use Phalcon\Filter;
    //calculate the user localtime offset
    if ($offset<0){
    $sign='-';
    $value=$offset*(-1);
  }
    else{
    $value=$offset*(-1);
    $sign='+';
} 
?> 
<section class="content-header" style="height:auto;">
          <h1>
           <?= $t->_("attendancelist"); ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"> Attendance List</li>
          </ol>
</section>

<section class="content">
        <!-- Main content -->
        <div class="buttons">
            <?php  if(isset($timezone)){?><p  onmouseover="aa" style="font-size: 17px">Current Timezone : <font color='red'><?php echo $timezone;?></font></p><?php }?>
            <form id="frm_search" onsubmit="return false;">
            <input type="text" name="year" id="startdate" class="datepicker"  placeholder="Start Date" style="margin-top: 10px;height:28px; width: 100px;">          
            <input type="text" name="month" id="enddate"  class="datepicker"   placeholder="End Date" style="margin-top: 10px;height:28px; width: 100px;">
            <input type="submit" class="buttonn" value="Search" id="search">
            <!--       <a href="#" class="button" id="search">Search</a>-->
            <a href="" class="button export" onclick="Export.Export.apply(this, [$('table.listtbl'),'attendance_list.csv']);">Export</a>
        </form>
        </div><!--Button-->
<div class="demo-content" style="padding-top:2%;">
<?php $this->flashSession->output() ?>
<table class="listtbl">
<thead>
    <tr>
                <th><?= $t->_("date"); ?></th>
	<th><?= $t->_("username"); ?></th>
	<th><?= $t->_("checkin"); ?></th>
	<th><?= $t->_("late"); ?></th>
                                <th width="150px"><?= $t->_("latereason"); ?></th>

              <th><?= $t->_("checkout"); ?></th>
	<th><?= $t->_("workingtime"); ?></th>
	<th><?= $t->_("overtime"); ?></th>
                <th><?= $t->_("location"); ?></th>
    </tr>
  </thead>
  <tbody style="display: none;">
  <?php
  
   $filter = new Filter();
   
	foreach ($attlist as $result) {
            //print_r($result);exit;
  ?>
    <tr>
	<td><?php echo $result->attendances->att_date; ?></td>
	<td><?php echo $filter->sanitize($result->core->member_login_name, "string"); ?></td>
<!--        check in time-->
	<td><?php $checkintime=$result->attendances->checkin_time;
        if ($sign=='-'){
            //add utc offset to local time
            $cintime = new DateTime($checkintime);
        $cintime->add(new DateInterval('PT' . $value . 'M'));
        echo $cintime->format('H:i:s A');
        }
        else{
            //minus utc time to local time
         $cintime = date("H:i:s A",strtotime($value." minutes",strtotime($checkintime)));
            echo $cintime;
        }
     ?>
        </td>
        
        <!--        Late-->
       <td>
                                <?php
                                //calculate late time
                                $checkintime = $result->attendances->checkin_time;
                                $dt = new DateTime($checkintime);
                                $time = $dt->format('H:i:s');
                                $office_start_time = '01:30:00 ';
                                if ($time > $office_start_time) {
                                    $start = strtotime($office_start_time);
                                    $end = strtotime($time);
                                    $late = $end - $start;
                                    
                                        echo "<font color='red'>" . gmdate("H:i:s", $late) . " </font>";
                                   
                                } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                              <td><?php
                                
                                    if ($result->attendances->notes != '') {
                                        echo "<font color='red'>" .  $result->attendances->notes . " </font>";
                                    }
                                
                                ?>
                            </td>
        
<!--        check out time -->
        <td><?php $checkouttime= $result->attendances->checkout_time;
        if($checkouttime==0){
        echo "-";}
        else{
            if($sign=='-'){
        $time = new DateTime($checkouttime);
        $time->add(new DateInterval('PT' . $value . 'M'));
        echo  $time->format('H:i:s A');}
        else {
            $time = date("H:i:s A",strtotime($value." minutes",strtotime($checkouttime)));
            echo $time;
        }
        }
?></td>
        

        
<!--        Working Hour-->
	<td>
	<?php
	$start_time=strtotime($result->attendances->checkin_time);
	$end_time=strtotime($result->attendances->checkout_time);
        if ($end_time==0){
            echo "-";
        }
        else{
          $workingHour=$end_time-$start_time;
             $hours = floor($workingHour / 3600);
            $minutes = floor(($workingHour / 60) % 60);
             $seconds = $workingHour % 60;
            $workingHour = "$hours:$minutes:$seconds";
          echo $workingHour;
	}	?>  
	</td>
        
<!--        Overtime-->
	<td><?php
        
        if ($result->attendances->overtime !=0) {
                                   echo $result->attendances->overtime;
                                } else {
                                    echo "-";
                                }

        
        
	 ?> </td>
        <td><?php echo $filter->sanitize($result->attendances->location, "string");
                
             
        ?></td>
    </tr>
    <?php
    
        }
    ?>
</tbody>
<tfoot style="display : none;"></tfoot>
</table>    
</div>
</section>
<div id="content"></div><!-- for pagination button -->


   
