<div id="form_all"><span class="heading">Bar code Label Auto Trigger </span>
 <form action=""  method="post" id="sys_auto_trigger"  name="sys_auto_trigger">
  <div id ="form_header">
   <div id="tabsHeader">
    <ul class="tabMain">
     <li><a href="#tabsHeader-1">Basic Info</a></li>
    </ul>
    <div class="tabContainer">
     <div id="tabsHeader-1" class="tabContent">
      <div class="large_shadow_box"> 
       <ul class="column four_column">
        <li><label>Transaction Type : </label>
         <?php echo $f->select_field_from_object('transaction_type_id', transaction_type::find_all(), 'transaction_type_id', 'transaction_type', $transaction_type_id, 'transaction_type_id', ''); ?>
        </li>
        <li><label>Association Level : </label>
         <?php echo $f->select_field_from_array('association_level', bc_label_auto_trigger::$association_level_a, $$class->association_level, 'association_level'); ?>
         <a name="show" href="form.php?class_name=bc_label_auto_trigger&<?php echo "mode=$mode"; ?>" class="show2 document_id bc_label_auto_trigger_id"><img src="<?php echo HOME_URL; ?>themes/images/refresh.png"/></a> 
        </li>
       </ul>
      </div>
     </div>
    </div>
   </div>
  </div>
 </form>
 <div id ="form_line" class="form_line"><span class="heading">Label Association </span>
  <div id="tabsLine">
   <ul class="tabMain">
    <li><a href="#tabsLine-1">Values</a></li>
   </ul>
   <div class="tabContainer"> 
    <form action=""  method="post" id="bc_label_auto_trigger_line"  name="bc_label_auto_trigger_line">
     <div id="tabsLine-1" class="tabContent">
      <table class="form_table">
       <thead> 
        <tr>
         <th>Action</th>
         <th>Line Id</th> 
         <th>Default Printer</th> 
         <?php
         switch ($association_level) {
          case 'SITE' :
           echo "<th>Site</th>";
           break;

          case 'BUSINESS' :
           echo "<th>Business Org</th>";
           break;

          case 'INVENTORY' :
           echo "<th>Inventory Org</th>";
           break;

          case 'FROM_SUBINV' :
           echo "<th>Inventory Org</th>";
           echo "<th>From Sub Inventory</th>";
           break;

          case 'USER' :
           echo "<th>User Name</th>";
           break;

          default :
           echo "<th>Multi Level</th>";
           break;
         }
         ?>
         <th>Label Format </th> 
        </tr>
       </thead>
       <tbody class="form_data_line_tbody bc_label_auto_trigger_values" >
        <?php
        $count = 0;
        $org = new org();
        foreach ($bc_label_auto_trigger_object as $bc_label_auto_trigger) {
         ?>         
         <tr class="bc_label_auto_trigger<?php echo $count ?>">
          <td>    
           <ul class="inline_action">
            <li class="add_row_img"><img  src="<?php echo HOME_URL; ?>themes/images/add.png"  alt="add new line" /></li>
            <li class="remove_row_img"><img src="<?php echo HOME_URL; ?>themes/images/remove.png" alt="remove this line" /> </li>
            <li><input type="checkbox" name="line_id_cb" value="<?php echo htmlentities($bc_label_auto_trigger->bc_label_auto_trigger_id); ?>"></li>           
            <li><?php echo form::hidden_field('transaction_type_id', $transaction_type_id); ?></li>
            <li><?php echo form::hidden_field('association_level', $association_level); ?></li>
           </ul>
          </td>
          <td><?php form::number_field_widsr('bc_label_auto_trigger_id'); ?></td>
          <td><?php echo $f->select_field_from_object('sys_printer_id', sys_printer::find_all(), 'sys_printer_id', 'printer_name', $$class->sys_printer_id) ?></td>
          <td>
           <?php
           $association_level = empty($bc_label_auto_trigger->association_level) ? $association_level : $bc_label_auto_trigger->association_level;
           switch ($association_level) {
            case 'SITE' :
             echo $f->text_field('association_level_value', 'SITE', '', '', '', 1, 1);
             break;

            case 'BUSINESS' :
             echo $f->select_field_from_object('association_level_value', $org->findAll_business(), 'org_id', 'org', $$class->association_level_value, '', '', 1);
             break;

            case 'INVENTORY' :
             echo $f->select_field_from_object('association_level_value', $org->findAll_inventory(), 'org_id', 'org', $$class->association_level_value, '', '', 1);
             break;

            case 'FROM_SUBINV' :
             $org_id_sub = null;
             if (!empty($$class->association_level_value)) {
              $subinv_i = subinventory::find_by_id($$class->association_level_value);
              $org_id_sub = $subinv_i->org_id;
             }
             echo $f->select_field_from_object('', $org->findAll_inventory(), 'org_id', 'org', $org_id_sub, '', 'org_id', 1);
             echo '</td><td>';
             echo $f->select_field_from_object('association_level_value', subinventory::find_all(), 'subinventory_id', array('subinventory','org_id'), $$class->association_level_value, '', 'subinventory_id', 1);
             break;

            case 'USER' :
             echo $f->select_field_from_object('association_level_value', user::find_all(), 'user_id', 'username', $$class->association_level_value, '', '', 1);
             break;
           }
           ?>
          </td>
          <td>
           <?php
           echo $f->select_field_from_object('bc_label_format_header_id', bc_label_format_header::find_all(), 'bc_label_format_header_id', 'format_name', $$class->bc_label_format_header_id, '', '', 1) . "</td>";
           ?>
          </td>
         </tr>
         <?php
         $count = $count + 1;
        }
        ?>
       </tbody>
      </table>
     </div>
     <div id="tabsLine-2" class="tabContent">
     </div>
    </form>
   </div>

  </div>
 </div> 
</div>

<div id="js_data">
 <ul id="js_saving_data">
  <li class="headerClassName" data-headerClassName="bc_label_auto_trigger" ></li>
  <li class="lineClassName" data-lineClassName="bc_label_auto_trigger" ></li>
  <li class="line_key_field" data-line_key_field="association_level" ></li>
  <li class="single_line" data-single_line="false" ></li>
  <li class="form_line_id" data-form_line_id="bc_label_auto_trigger" ></li>
 </ul>
 <ul id="js_contextMenu_data">
  <li class="docLineId" data-docLineId="bc_label_auto_trigger_id" ></li>
  <li class="btn2DivId" data-btn2DivId="form_line" ></li>
  <li class="trClass" data-trclass="bc_label_auto_trigger" ></li>
  <li class="tbodyClass" data-tbodyClass="form_data_line_tbody" ></li>
  <li class="noOfTabbs" data-noOfTabbs="2" ></li>
 </ul>
</div>