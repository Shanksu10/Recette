<?php
    if(!empty($autoCompleteCategory)){
    $output = '<ul class="dropdown-menu" style="display:block; position:relative;width:100%;">';
            foreach($autoCompleteCategory as $row)
            {
                $output .= '
                <li><a class="dropdown-item" href="#">';
                    if(!isset($row->name_category_meal)){
                        $output .= $row->name;
                    }else {
                        $output .= $row->name_category_meal;
                    }
                    $output .='</a></li>';
            }
            $output .= '</ul>';
            echo $output;
    }
?>
