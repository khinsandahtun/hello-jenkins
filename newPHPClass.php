<?php
    use Phalcon\Filter;
?>
<section class="content-header" style="height:auto;">
    <h1>
        <?= $t->_("show_salary_detail");?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?= $t->_("home");?></a></li>
        <li class="active"><?= $t->_("show_salary_detail");?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row"><!-- for search form-->
        <div class="col-md-12"><!--start add user form--->

            <div class="search-box">
            <form name="search_frm" id="search_frm">
                <div id="Menu" >
                    <input type="hidden" name="cond[mth]" value="<?php echo $month;?>" id="month">
                    <input type="hidden" name="cond[yr]" value="<?php echo $year;?>" id="year">
                    <div id="salary_detail_div1">
                        <?= $t->_("username");?> :
                        <input  class="tags"   style="width:100%;margin-top: 1px;"  id="namelist" placeholder="<?php echo $t->_("username"); ?>">
                        <input type="hidden" value="" id="formemberid" name="cond[mem]">
                    </div>
                    <div id="salary_detail_div2">
                        <?= $t->_("department");?> :
                        <span>
                            <select class="select" data-toggle="select" name="cond[dept]"  id="department">
                                <option value=""><?= $t->_("department");?></option>
                                <?php
                                foreach ($usernames as $username) {
                                    ?>
                                    <option value="<?php echo $username->member_dept_name; ?>"><?php echo $username->member_dept_name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                    </div>
                    <div id="salary_detail_div3">
                        <?= $t->_("position");?> :
                        <span>
                            <select class="select" data-toggle="select" name="cond[position]" id="position">
                                <option value="" ><?= $t->_("position");?></option>
                                <?php
                                foreach ($usernames as $username) {
                                    ?>
                                    <option value="<?php echo $username->position; ?>"><?php echo $username->position; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                    </div>
                    <div id="salary_detail_div4">
                         <?= $t->_("salary_rate");?> :
                        <select class="select" data-toggle="select" name="cond[salary]" id="salary_rate">
                          <option value="" ><?= $t->_("salary_rate");?></option>
                            <option>200000~400000</option>
                            <option>400001~700000</option>
                            <option>700001~1000000</option>
                            <option>1000001~</option>
                        </select>
                    </div>
                </div>
                <div class="search-btn-box"><!--search btn-->
                    <div>
                        <a href="#" class="button" id="search_salary"><?= $t->_("search");?></a>
                        <a href="#" class="button export"><?= $t->_("export");?></a>
                        <a href="#" title="Print" style="margin-left: 20px;" id="btn_print_salary" class="printimg"></a><br>
                       
                    </div>
                </div><!--search btn-->
            </form>
            </div>
        </div>
    </div><!-- for search form-->
    <div style="height:20px;"></div>

    <div class="row">
        <div class="col-md-12"><!--start table content--->

            <table class="listtbl" >
                <thead>
                    <tr>
                        <th><INPUT type="checkbox" id="sal_check" onchange="checkAll(this)" name="chk[]" /></th>
                        <th><?= $t->_("name");?></th>
                        <th><?= $t->_("department");?></th>
                        <th><center><?= $t->_("basic_salary");?></center></th>
                        <th><center><?= $t->_("overtime");?></center></th>
                        <th><center><?= $t->_("travel_fee");?></center></th>
                        <th><center><?= $t->_("allowance");?></center></th>
                        <th><center><?= $t->_("absent");?></center></th>
                        <th><center><?= $t->_("tax");?></center></th>
                        <th><center><?= $t->_("ssc_comp");?></center></th>
                        <th><center><?= $t->_("ssc_emp");?></center></th>
                        <th><center><?= $t->_("total");?></center></th>
                        <th width="30px"></th>
                    </tr>

                </thead>
                <tbody>
                    <?php
                    $filter = new Filter();
                    
                    $month=$this->request->get('month');
                    $year=$this->request->get('year');
                    $i = 1;
                    $totalresult="";
                    echo '<form id ="frm1">';
                    foreach ($getsalarylists as $getsalarylist) {
                        ?>
                        <tr>
                            <td><input type="checkbox" class='case' name='chk[]' value="<?= $getsalarylist['member_id']; ?>" ></td>
                            <td><?php echo $filter->sanitize($getsalarylist['full_name'] , "string"); ?></td>
                            <td><?php echo $filter->sanitize($getsalarylist['member_dept_name'] , "string") ?></td>
                            <td><div class="td-style"><?php echo number_format($filter->sanitize($getsalarylist['basic_salary'], "int")); ?></div></td>
                            <td><div class="td-style"><?php echo number_format($filter->sanitize($getsalarylist['overtime'], "int")); ?></div></td>
                            <td><div class="td-style"><?php echo number_format($filter->sanitize($getsalarylist['travel_fee'], "int")); ?></div></td>
                            <td><div class="td-style"><?php echo number_format($filter->sanitize($getsalarylist['allowance_amount'], "int")); ?></div></td>
                            <td><div class="td-style"><?php echo number_format($filter->sanitize($getsalarylist['absent_dedution'], "int")); ?></div></td>
                            <td><div class="td-style"><?php echo number_format($filter->sanitize($getsalarylist['income_tax'], "int")); ?></div></td>
                            <td><div class="td-style"><?php echo number_format($filter->sanitize($getsalarylist['ssc_comp'], "int")); ?></div></td>
                            <td><div class="td-style"><?php echo number_format($filter->sanitize($getsalarylist['ssc_emp'], "int")); ?></div></td>
                            
                            <td><div class="td-style"><?php 
                            $totalresult+=$getsalarylist['total'];
                            echo number_format($getsalarylist['total']); 
                                    
                                ?></div>
                                <input type="hidden" value="<?php echo $month; ?>" name="month" id="month">
                                <input type="hidden" value="<?php echo $year; ?>" name="year" id="year">
                            </td>
<!--                            <td><a href="payslip?member_id=<?php echo $getsalarylist['member_id']?> && month=<?php echo $month; ?> && year=<?php echo $year; ?>" class="button">Detail</a></td>-->
                            <td><a href="#" class="btn_detail" title="Detail" id="detail_img" style="margin-top: 13px;"></a></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    echo '</form>';
                    ?>
                           
                    <tr>
                        <td colspan="11" style="text-align:center; background-color:#3c8dbc; color: #FFFFFF"><b>Total salary for all user</b></td>
                        <td style="background-color:#3c8dbc; color: #FFFFFF"><div class="td-style"><b><?php echo number_format($filter->sanitize($totalresult, "int"));?></b></div></td>
                        <td style="background-color:#3c8dbc;"></td>
                    </tr>
                </tbody>
            </table>      
        </div><!--end table content--->
    </div><!-- /.row -->

</section><!-- /.content -->
