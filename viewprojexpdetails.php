<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');


$projid = $_GET["proj_id"];

$coned = getConnection();
$sqled = "
select id,b.project_type,c.name customer,project_name,
getEmpName(project_manager_id) pm,base_product,
tlr,ohrm_project_id,
getEmpName(project_created_by) crt_by,
a.status, c.customer_id,report_type,b.project_type_id,project_manager_id,project_director_id,
Planned_start_date,Planned_End_date,Actual_Start_Date sdt,Actual_End_Date edt,
project_created_on,
getEmpName(project_modified_by) mod_by,
project_modified_on,
getEmpName(project_authorised_by) auth_by,
project_authorised_on,
getEmpName(project_activated_by) act_by,
project_activated_on,
getEmpName(project_closed_by) close_by,
project_closed_on,
getEmpName(project_delivered_by) delv_by,
project_delivered_on,
getEmpName(project_warranty_by) war_by,
project_warranty_on,
getEmpName(project_deleted_by) del_by,
project_deleted_on,
getEmpName(project_deleted_by) del_by,
project_deleted_on,
getEmpName(project_deactivated_by) deact_by,
project_deactivated_on
 from project_details a
inner join project_type b on a.project_type_id = b.project_type_id
inner join hr_mysql_live.ohrm_customer c on a.ohrm_customer_id= c.customer_id
where id = " . $projid;
$resulted = mysqli_query($coned, $sqled) or debug($sqled . "   failed  <br/><br/>" . mysqli_error());
$rowed = mysqli_fetch_array($resulted);
?>
<tr>
<br>
<td>
    <font size="3"><b>View Financial Details</b></font>
</td>
<?
if($rowed[tlr]=="GREEN")
echo "<td ><img src='images/green.jpg' alt='red' width='40' height='40'</img></td>";

if($rowed[tlr]=="RED")
echo "<td ><img src='images/red.jpg' alt='red' width='40' height='40'</img></td>";


if($rowed[tlr]=="AMBER")
echo "<td ><img src='images/amber.jpg' alt='red' width='40' height='40'</img></td>";
$_GET['projid']=$projid;
include 'operproj.php';
?>
</tr>
<form name="projectForm"  method="post" onsubmit="return formSubmit();" >
    <table>
        <tr>
            <?echo "<b><inputname='projid' id='projid' type='hidden' value='$projid'></b>";
            echo "<script>document.getElementById('projid').disabled=true;</script>";
            ?>

        </tr>

        <tr>
            <td>Customer : </td>
            <td>

                <? 
                include 'getcustomer.php'; ?>
            </td>

            <td>Project : </td>

            <td> <input type = "text" id='proj' name='proj' size='50'></td>
        </tr>

        <tr>
        </tr>
        <?
        echo "<script>document.getElementById('cust').value = '$rowed[customer_id]';</script>";
        echo "<script>document.getElementById('cust').disabled=true;</script>";
        echo "<script>document.getElementById('proj').value = '$rowed[project_name]';</script>";
        echo "<script>document.getElementById('proj').disabled=true;</script>";
        ?>

        <tr>
            <td>Project Manager : </td>
            <td>
                <? 
                $_GET['q']='pm';
                include 'getemp.php'; ?>
            </td>

            <td>Project Director : </td>
            <td>

                <? 
                $_GET['q']='pd';
                include 'getemp.php'; ?>
            </td>
            <?
            echo "<script>document.getElementById('pm').value = '$rowed[project_manager_id]';</script>";
            echo "<script>document.getElementById('pm').disabled=true;</script>";
            echo "<script>document.getElementById('pd').value = '$rowed[project_director_id]';</script>";
            echo "<script>document.getElementById('pd').disabled=true;</script>";
            ?>


            <td>Project Status : </td>
            <td> 
                <select id='status' name='status' value =''>
                    <option value='Choose..' selected='selected'>Choose...</option>
                    <option value='INITIATED'>INITIATED</option>
                    <option value='ACTIVE'>ACTIVE</option>
                    <option value='PENDING INVOICE'>PENDING INVOICE</option>
                    <option value='DEACTIVATED'>DEACTIVATED</option>
                    <option value='CLOSED'>CLOSED</option>
                    <option value='INITIATE CLOSURE'>INITIATE CLOSURE</option>
                    <option value='AUTHORISE CLOSURE'>AUTHORISE CLOSURE</option>
                    <option value='WARRANTY'>WARRANTY</option>
                    <option value='DELIVERED'>DELIVERED</option>
                    <option value='AUTHORISED'>AUTHORISED</option>
                    <option value='APPROVED'>APPROVED</option>
                </select>
            </td>
            <?
            echo "<script>document.getElementById('status').value = '$rowed[status]';</script>";
            echo "<script>document.getElementById('status').disabled=true;</script>";
            ?>

        </tr>

    </table>


    <ul  class="nav nav-tabs">

        <li class="active">
            <a  href="#T1a" data-toggle="tab">Financial Summary</a>
        </li>

        <li>
            <a  href="#T2a" data-toggle="tab">Budget</a>
        </li>

        <li>
            <a  href="#T3a" data-toggle="tab">Labour Cost</a> 
        </li>
        <li>
            <a  href="#T4a" data-toggle="tab">Labour Summary</a>
        </li>

        <li>
            <a  href="#T5a" data-toggle="tab">Expense Summary</a>
        </li>

        <li>
            <a  href="#T6a" data-toggle="tab">Expense Details</a>
        </li>

        <li>
            <a  href="#T7a" data-toggle="tab">Change Request</a>
        </li>

        <li>
            <a  href="#T8a" data-toggle="tab">Invoice</a>
        </li>


    </ul>



    <div class='tab-content'>
        <div class="tab-pane fade in active" id="T1a">
            <p>
                <?php
                $_GET["q"] = $projid;
                include 'getbudgetAw.php';
                ?>
            </p>
        </div>

        <div class="tab-pane fade" id="T2a">
            <p>
                <?php
                $_GET["q"] = $projid;
                include 'getexcessbudget.php';
                ?>
            </p>
        </div>

        <div class="tab-pane fade" id="T3a">
            <p>
                <?php
                $_GET["q"] = $projid;
                include 'getlabourcost.php';
                ?>
            </p>
        </div>

        <div class="tab-pane fade" id="T4a">
            <p>
                <?php
                $_GET["q"] = $projid;
                include 'getlaboursummary.php';
                ?>
            </p>
        </div>

        <div class="tab-pane fade" id="T5a">
            <p>
                <?php
                $_GET["q"] = $projid;
                include 'getexpsummary.php';
                ?>
            </p>
        </div>
        
        <div class="tab-pane fade" id="T6a">
            <p>
                <?php
                $_GET["q"] = $projid;
                include 'getexplist.php';
                ?>
            </p>
        </div>
        
        <div class="tab-pane fade" id="T7a">
            <p>
                <?php
                $_GET["q"] = "";
                $_GET["q2"] = $projid;
                include 'getchangerequestlist.php';
                ?>
            </p>
        </div>
        <div class="tab-pane fade" id="T8a">
            <p>
                <?php
                $_GET["q"] = "";
                $_GET["q2"] = $projid;
                include 'getinvoicelist.php';
                ?>
            </p>
        </div>
    </div>




</form>
</body>
</html>
